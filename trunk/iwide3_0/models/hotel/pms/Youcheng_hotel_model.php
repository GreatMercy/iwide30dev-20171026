<?php

class Youcheng_hotel_model extends MY_Model{
	public function __construct(){
		parent::__construct();
		$this->load->helper('common');
        $this->_url = 'http://115.29.185.74:9020/WebSiteApi/api';
//        $this->load->library('Baseapi/Youchengapi', 'server_api');
	}

	public function get_rooms_change($rooms, $idents, $condit, $pms_set = []){

		$this->load->model('common/Webservice_model');
		$web_reflect = $this->Webservice_model->get_web_reflect($idents ['inter_id'], $idents ['hotel_id'], $pms_set ['pms_type'], [
			'web_price_code_set'
		], 1, 'w2l');


		$this->load->model('api/Vmember_model','vm');
		$member_level=$this->vm->getLvlPmsCode($condit['openid'],$idents['inter_id']);

		$web_price_code = '';

		if(!empty ($condit ['member_privilege'])){
			if($pms_set['pms_room_state_way'] == 3 || $pms_set['pms_room_state_way'] == 4){
                  foreach($condit ['member_privilege'] as $arr){
                      $price_code = str_replace(',','',$arr['lvl_pms_code']);
                      $web_price_code.=','.$price_code;
                  }
                $web_price_code = substr($web_price_code,1);
                $web_price_code = $web_price_code.',0';
			}
		} else{
			if(!empty ($web_reflect ['web_price_code'])){
				foreach($web_reflect ['web_price_code'] as $wpc){
					$web_price_code .= ',' . $wpc;
				}
			}
			$web_price_code .= isset ($web_reflect ['member_price_code'] [$member_level]) ? ',' . $web_reflect ['member_price_code'] [$member_level] : '';
			$web_price_code = substr($web_price_code, 1);
		}

		$web_price_code = explode(',', $web_price_code);

		$countday = ceil((strtotime($condit ['enddate']) - strtotime($condit ['startdate'])) / 86400); // 获得相差天数
		$web_rids = [];
		foreach($rooms as $r){
			$web_rids [$r ['webser_id']] = $r ['room_id'];
		}

		$params = [
			'countday'     => $countday,
			'web_rids'     => $web_rids,
			'condit'       => $condit,
			'web_reflect'  => $web_reflect,
			'member_level' => $member_level,
			'idents'       => $idents,
		];

//        $web_price_code = [1, 2, 3, 4];

		$data = [];

        switch($pms_set ['pms_room_state_way']){
            case 1 :
            case 2 :
            case 3:
                $this->load->model ( 'hotel/Order_model' );
                $data = $this->Order_model->get_rooms_change ( $rooms, $params ['idents'], $params ['condit'] );
                $price_code=array();
                foreach($data as $data_arr){
                    if(isset($data_arr['state_info'])){
                        foreach($data_arr['state_info'] as $room_arr){
                            if(!in_array($room_arr['external_code'],$price_code)){
                                $price_code[]=$room_arr['external_code'];
                            }
                        }
                    }
                }
                $pms_data = $this->get_web_roomtype($pms_set, $web_price_code, $condit ['startdate'], $condit ['enddate'], $params);

                return $this->get_rooms_change_lmem ( $pms_data, array (
                    'rooms' => $rooms
                ), $params,$data );
                break;
        }
		return $data;
	}


    function get_rooms_change_lmem($pms_data, $rooms, $params,$data) {

        $condit=$params ['condit'];
        $pms_state=$pms_data;
        foreach ( $data as $room_key => $lrm ) {

            $min_price = array ();
            if (empty ( $pms_state [$lrm ['room_info'] ['webser_id']] )) {
                unset ( $data [$room_key] );
                continue;
            }
            if (! empty ( $lrm ['state_info'] )) {
                foreach ( $lrm ['state_info'] as $sik => $si ) {

                    if ($si ['external_code'] !== '') {
                        $external_code = $si ['external_code'];
                    }

                    if ( ! empty ( $pms_state [$lrm ['room_info'] ['webser_id']] [$external_code] )) {

                        $tmp = $pms_state [$lrm ['room_info'] ['webser_id']] [$external_code];
                        // $otmp = $pms_state [$lrm ['room_info'] ['webser_id']] [$external_code];
                        $nums = isset ( $condit ['nums'] [$lrm ['room_info'] ['room_id']] ) ? $condit ['nums'] [$lrm ['room_info'] ['room_id']] : 1;

                        $data [$room_key] ['state_info'] [$sik] ['least_num'] = $tmp ['least_num'];
                        $data [$room_key] ['state_info'] [$sik] ['book_status'] = $tmp ['book_status'];

                        $data [$room_key] ['state_info'] [$sik] ['extra_info'] = $tmp ['extra_info'];
                        // $data [$room_key] ['state_info'] [$sik] ['extra_info'] ['channel_code'] = $price_level;
                        $allprice = '';
                        $amount = 0;
                        foreach ( $tmp ['date_detail'] as $dk => $td ) {

                            if ($data [$room_key] ['state_info'] [$sik] ['price_type'] == 'member') {
                                $tmp ['date_detail'] [$dk] ['price'] = round ( $this->Order_model->cal_related_price ( $td ['price'], $si ['related_cal_way'], $si ['related_cal_value'], 'price' ) );
                            } else {

                            }

                            if($data [$room_key] ['state_info'] [$sik] ['related_code']!=0 && !empty($data [$room_key] ['state_info'] [$sik] ['related_cal_way'])){
                                $tmp ['date_detail'] [$dk] ['price'] = round ( $this->Order_model->cal_related_price ( $td ['price'], $si ['related_cal_way'], $si ['related_cal_value'], 'price' ) );
                            }

                            $tmp ['date_detail'] [$dk] ['nums'] = $data [$room_key] ['state_info'] [$sik] ['least_num'];
                            $allprice .= ',' . $tmp ['date_detail'] [$dk] ['price'];
                            $amount += $tmp ['date_detail'] [$dk] ['price'];
                        }
                        $data [$room_key] ['state_info'] [$sik] ['date_detail'] = $tmp ['date_detail'];

                        $data [$room_key] ['state_info'] [$sik] ['avg_price'] = number_format ( $amount / $params ['countday'], 2 );
                        $data [$room_key] ['state_info'] [$sik] ['allprice'] = substr ( $allprice, 1 );
                        $data [$room_key] ['state_info'] [$sik] ['total'] = floatval($amount);
                        $data [$room_key] ['state_info'] [$sik] ['total_price'] = $data [$room_key] ['state_info'] [$sik] ['total'] * $nums;

                        $min_price [] = str_replace(',','',$data [$room_key] ['state_info'] [$sik] ['avg_price']);

                    }else{
                        unset($data [$room_key]['state_info'][$sik]);

                    }
                }

                $data [$room_key] ['lowest'] = empty ( $min_price ) ? 0 : min ( $min_price );
                $data [$room_key] ['highest'] = empty ( $min_price ) ? 0 : max ( $min_price );

            }
            if (empty ( $data [$room_key] ['state_info'] )) {
                unset ( $data [$room_key] );
            }

                if (! empty ( $lrm ['show_info'] )) {
                    foreach ($lrm ['show_info'] as $sik => $si){
                        foreach ( $tmp ['date_detail'] as $dk => $td ) {

                            if ($si ['external_code'] !== '') {
                                $external_code = $si ['external_code'];
                            }

                            if ( ! empty ( $pms_state [$lrm ['room_info'] ['webser_id']] [$external_code] )) {

                                $tmp = $pms_state [$lrm ['room_info'] ['webser_id']] [$external_code];
                                // $otmp = $pms_state [$lrm ['room_info'] ['webser_id']] [$external_code];
                                $nums = isset ( $condit ['nums'] [$lrm ['room_info'] ['room_id']] ) ? $condit ['nums'] [$lrm ['room_info'] ['room_id']] : 1;

                                $data [$room_key] ['show_info'] [$sik] ['least_num'] = $tmp ['least_num'];
                                $data [$room_key] ['show_info'] [$sik] ['book_status'] = $tmp ['book_status'];

                                $data [$room_key] ['show_info'] [$sik] ['extra_info'] = $tmp ['extra_info'];
                                // $data [$room_key] ['state_info'] [$sik] ['extra_info'] ['channel_code'] = $price_level;
                                $allprice = '';
                                $amount = 0;
                                foreach ( $tmp ['date_detail'] as $dk => $td ) {

                                    if ($data [$room_key] ['show_info'] [$sik] ['price_type'] == 'member') {
                                        $tmp ['date_detail'] [$dk] ['price'] = round ( $this->Order_model->cal_related_price ( $td ['price'], $si ['related_cal_way'], $si ['related_cal_value'], 'price' ) );
                                    } else {

                                    }

                                    if($data [$room_key] ['show_info'] [$sik] ['related_code']!=0 && !empty($data [$room_key] ['show_info'] [$sik] ['related_cal_way'])){
                                        $tmp ['date_detail'] [$dk] ['price'] = round ( $this->Order_model->cal_related_price ( $td ['price'], $si ['related_cal_way'], $si ['related_cal_value'], 'price' ) );
                                    }

                                    $tmp ['date_detail'] [$dk] ['nums'] = $data [$room_key] ['show_info'] [$sik] ['least_num'];
                                    $allprice .= ',' . $tmp ['date_detail'] [$dk] ['price'];
                                    $amount += $tmp ['date_detail'] [$dk] ['price'];
                                }
                                $data [$room_key] ['show_info'] [$sik] ['date_detail'] = $tmp ['date_detail'];

                                $data [$room_key] ['show_info'] [$sik] ['avg_price'] = number_format ( $amount / $params ['countday'], 2 );
                                $data [$room_key] ['show_info'] [$sik] ['allprice'] = substr ( $allprice, 1 );
                                $data [$room_key] ['show_info'] [$sik] ['total'] = floatval($amount);
                                $data [$room_key] ['show_info'] [$sik] ['total_price'] = $data [$room_key] ['show_info'] [$sik] ['total'] * $nums;

                                $min_price [] = str_replace(',','',$data [$room_key] ['show_info'] [$sik] ['avg_price']);

                            }else{
                                unset($data [$room_key]['show_info'][$sik]);

                            }
                    }
                }

            }

        }

        return $data;
    }



	public function cancel_order_web($inter_id, $order, $pms_set = []){
		if(empty ($order ['web_orderid'])){
			return [
				's'      => 0,
				'errmsg' => '取消失败'
			];
		}

		$res = $this->cancelOrder($pms_set,$pms_set['hotel_web_id'], $order['web_orderid']);

		if($res){
			return [                        //取消成功，直接这样return，接下来的程序会继续处理
			                                's'      => 1,
			                                'errmsg' => '取消成功'
			];
		}

		return [
			's'      => 0,
			'errmsg' => '取消失败,' . $res['msg'],
		];

	}

	private function change_order_status($inter_id, $orderid, $status){
		$this->db->where([
			                 'orderid'  => $orderid,
			                 'inter_id' => $inter_id
		                 ]);
		$this->db->update('hotel_orders', [ // 提交失败，把订单状态改为下单失败
		                                    'status' => (int)$status
		]);
	}


	public function add_web_bill($web_orderid, $order, $pms_set){
		$web_paid = 2;
		//空订单号
		if(empty($web_orderid)){
			$this->db->where([
				                 'orderid'  => $order ['orderid'],
				                 'inter_id' => $order ['inter_id']
			                 ]);
			$this->db->update('hotel_order_additions', [ //更新web_paid 状态，2为失败，1为成功
			                                             'web_paid' => $web_paid
			]);
			return false;
		}

//		//查询网络订单是否存在
//		$web_order = $this->check_order($pms_set,$pms_set['hotel_web_id'], $order['web_orderid']);

        if(!isset($order['web_orderid']) ||  empty($order['web_orderid'])){
			$this->db->where([
				                 'orderid'  => $order ['orderid'],
				                 'inter_id' => $order ['inter_id']
			                 ]);
			$this->db->update('hotel_order_additions', [
				'web_paid' => $web_paid
			]);
			return false;
		}


		//PMS上的入账接口
		$result = $this->addpayment($pms_set,$pms_set['hotel_web_id'], $order['web_orderid'], $order['price'],$order ['orderid']);

		if(!empty($result)){
			$web_paid = 1;
		}


		$this->db->where([
			                 'orderid'  => $order ['orderid'],
			                 'inter_id' => $order ['inter_id']
		                 ]);
		$this->db->update('hotel_order_additions', [
			'web_paid' => $web_paid
		]);
		return $web_paid==1;
	}

	public function order_to_web($inter_id, $orderid, $params = [], $pms_set = []){
		$this->load->model('hotel/Order_model');
		$order = $this->Order_model->get_main_order($inter_id, [
			'orderid' => $orderid,
			'idetail' => [
				'i'
			]
		]);
		if(!empty ($order)){
			$order = $order [0];   //获取本地已保存的订单信息
			$room_codes = json_decode($order ['room_codes'], true);
			$room_codes = $room_codes [$order ['first_detail'] ['room_id']]; //$room_codes 结构：array('本地room_id'=>array('room'=>array('webser_id'=>房型代码),'code'=>array($extra_info(就是取房态时的 extra_info),'price_type'=>'价格类型')))


            $params_mem = array(
                'membership_number'=>'',
                'telephone'=>'',
                'pms_user_id'=>0,
                'name'=>$order['name']
            );


            $this->load->model ( 'distribute/Fans_model' );
            $fans_info = $this->Fans_model->get_fans_info_by_openid($inter_id,$order ['openid']);
            if(!empty($fans_info->nickname)){
                $params_mem['name']=$fans_info->nickname;
            }


            $this->load->model ( 'hotel/Member_new_model' );
            $memberInfo=$this->Member_new_model->getMemberByOpenId($inter_id,$order ['openid']);

            $pms_level=0;

            if(!empty($memberInfo)){

                if(isset($memberInfo->telephone)){
                    $params_mem['telephone']=$memberInfo->telephone;
                }
                if(isset($memberInfo->pms_user_id) && $memberInfo->pms_user_id!=''){
                    $params_mem['pms_user_id']=$memberInfo->pms_user_id;
                }
                if(isset($memberInfo->lvl_pms_code)){
                    $pms_level = $memberInfo->lvl_pms_code;
                }
                if(isset($memberInfo->membership_number)){
                    $params_mem['membership_number']=$memberInfo->membership_number;
                }
                if(isset($memberInfo->name) && !empty($memberInfo->name)){
                    $params_mem['name']=$memberInfo->name;
                }
            }

            $pms_mem_info = $this->roomStateByMem($pms_set,$pms_set['hotel_web_id'],$pms_level);


            $first_price = explode(',',$order['first_detail']['allprice']);

            if(isset($first_price[0])){
                $first_price = $first_price[0];
            }else{
                $first_price = 0.01;
            }

            //判断是否为夜宵房，入住时间非当天，而且离店时间为当天的
            $new_startdate=$order['startdate'];
            if(strtotime($new_startdate) < strtotime(date('Y-m-d'))){
                if($order['enddate'] == date('Y-m-d')){
                    //离店时间为当天的，则认为是凌晨房
                    $order['startdate'] = date('Y-m-d');
                }
            }


			$result = $this->order_to_pms($order, $pms_set, $params_mem , $pms_mem_info , $pms_set['hotel_web_id'],$first_price,$orderid);//提交订单

			if(!isset($result['errmsg'])){
				$web_orderid = $result['pms_orderid'];            //取得返回的pms订单id
				$this->db->where([
					                 'orderid'  => $order ['orderid'],
					                 'inter_id' => $order ['inter_id']
				                 ]);
				$this->db->update('hotel_order_additions', [        //更新pms单号到本地
				                                                    'web_orderid' => $web_orderid
				]);
				if($order ['status'] != 9){
					$this->change_order_status($inter_id, $orderid, 1);
					$this->Order_model->handle_order($inter_id, $orderid, 1); // 若pms的订单是即时确认的，执行确认操作，否则省略这一步
				}

                if($order['coupon_favour'] > 0){      //每张优惠券的金额分别进行入账
                    $coupon_des = json_decode($order['coupon_des']);
                    if(isset($coupon_des->cash_token)){
                        foreach($coupon_des->cash_token as $coupon_amount){
                            $res = $this->addpayment($pms_set,$pms_set['hotel_web_id'], $web_orderid, -$coupon_amount->amount,$order ['orderid'],1089,'coupon_favour');
                        }
                    }
                }

				if(!empty ($params ['third_no'])){ // 提交账务,如果传入了 trans_no,代表已经支付，调用pms的入账接口
					$this->add_web_bill($web_orderid, $order, $pms_set);
				}

				return [ // 返回成功
				         's' => 1
				];
			} else{
				$this->change_order_status($inter_id, $orderid, 10);
				return [ // 返回失败
				         's'      => 0,
				         'errmsg' => '提交订单失败' . ',' . $result ['errmsg']
				];
			}
		}
		return [
			's'      => 0,
			'errmsg' => '提交订单失败'
		];
	}



    function get_web_roomtype($pms_set, $web_price_code, $startdate, $enddate, $params){

        $params=array();
        $roomtype = array();

        $cuontdays = ceil((strtotime($enddate) - strtotime($startdate))/86400);   //间夜数
        $c_enddate = date('Y-m-d',strtotime($enddate) - 86400);
        $startdate = date('Y-m-d',strtotime($startdate));


        foreach($web_price_code as $level_code){

            $level_price_code = $this->pms_enum('price_code');

            if(isset($level_price_code[$level_code])){

                $send_data=array(
                    'HotelID'=>$pms_set['hotel_web_id'],
                    'StartDate'=>$startdate,
                    'EndDate'=>$c_enddate,
                    'nSourceID'=>5,
                    'sRoomRateType'=>$level_price_code[$level_code]
                );


                $res = $this->getRoomStatus($pms_set,$send_data);

                $result[] = $res;

            }

        }


        if($result){       //过滤重复的数据
            $i=0;
            foreach($result as $res){
                if(!empty($res)){
                    $length = count($res->RoomTypes)/$cuontdays;
                    for($i=0;$i<$length;$i++){
                        $roomtype[]=$res->RoomTypes[$i*($cuontdays)];
                    }
                }
            }
        }

        $info=array();

        foreach($roomtype as $arr){
            $least_num ='';
            $pms_room_id = '';
            $date_detail=array();

            foreach($arr->RoomRateItems as $detail_tmp){

                $count_num =  $detail_tmp->RoomCount-$detail_tmp->ControlCount-$detail_tmp->BookInCount-$detail_tmp->CheckInCount;

                if($count_num<0)$count_num=0;

                if(empty($least_num)){
                    $least_num = $count_num;
                }elseif($count_num < $least_num){
                    $least_num = $least_num;
                }

                if($least_num > 8)$least_num=8;

                if(empty($pms_room_id)){
                    $pms_room_id = $detail_tmp->RoomRateTypeID;
                }

                $date = date('Ymd',strtotime($detail_tmp->AccDate));

                $date_detail[$date]=array(
                    'price'=>$detail_tmp->RoomRate ,
                    'nums'=>$count_num ,
                );

            }

            if($arr->BookFlag==1){     //判断房间预订性
                $book_status='available';
            }else{
                $book_status = 'full';
            }

            $extra_info=array();
            if(isset($arr->RoomRateItems)){
                $RoomRateItems=$arr->RoomRateItems[0];
                $extra_info = array(
                    'RoomRateTypeID'=>$RoomRateItems->RoomRateTypeID,
                    'RoomRateTypeName'=>$RoomRateItems->RoomRateTypeName,
                    'RoomRate'=>$RoomRateItems->RoomRate,
                    'ChainName'=>$RoomRateItems->ChainName,
                    'RoomTypeID'=>$RoomRateItems->RoomTypeID,
                    'RoomTypeName'=>$RoomRateItems->RoomTypeName,
                    'RoomTypeCode'=>$RoomRateItems->RoomTypeCode,
                    'RoomCount'=>$RoomRateItems->RoomCount,
                    'CheckInCount'=>$RoomRateItems->CheckInCount,
                    'BookInCount'=>$RoomRateItems->BookInCount,
                    'ControlCount'=>$RoomRateItems->ControlCount,
                    'BedCount'=>$RoomRateItems->BedCount,
                    'MaxCheckInCount'=>$RoomRateItems->MaxCheckInCount,
                );
            }


            $info[$arr->RoomTypeID][$pms_room_id]=array(
                'price_name'=>$arr->RoomTypeName,
                'price_type'=>'pms',
                'extra_info'=>$extra_info,
                'price_code'=>$RoomRateItems->RoomRateTypeID,
                'least_num'=>$least_num,
                'book_status'=>$book_status,
                'date_detail'=>$date_detail
            );
        }

        return $info;

    }




    private function send($method='get',$url,$params=array(),$func_data=array()){   //发送请求

        $run_alarm = 0;

        try {
            if($method=='get'){
                $s = doCurlGetRequest ( $url,$params);
            }elseif($method=='post'){
                $s = doCurlPostRequest ( $url,$params);
            }
        } catch ( Exception $e ) {
            $s = $e;
            $run_alarm = 1;
        }



        if(isset($this->inter_id) && empty($this->inter_id)){
            $inter_id = $this->inter_id;
        }else{
            $inter_id = 'a480304439';
        }

        $now = time();

//        $mirco_time = microtime();
//        $mirco_time = explode(' ', $mirco_time);
//        $wait_time = $mirco_time [1] - $now + number_format($mirco_time [0], 2, '.', '');
//
//        $this->db->insert('webservice_record', array(
//            'send_content'    => json_encode($params),
//            'receive_content' => json_encode($s),
//            'record_time'     => $now,
//            'inter_id'        => $inter_id,
//            'service_type'    => 'youcheng',
//            'web_path'        => $url,
//            'record_type'     => 'webservice',
//            'openid'          => '',
//            'wait_time'       => $wait_time
//        ));

//        $this->load->library('MYLOG');
//        MYLOG::w('send_content:'.json_encode($params).'||'.'receive_content:'.json_encode($s).'||'.'record_time:'.$now.'||'.'inter_id:'.$inter_id.'||'.'service_type:youcheng'.'||'.'web_path:'.$url.'||'.'wait_time:'.$wait_time,'pms_log');


        $this->check_web_result ( $inter_id, $url, $params, $s, $now,  microtime (), $func_data, array (
            'run_alarm' => $run_alarm
        ) );

        $this->load->model('common/Webservice_model');
        $this->Webservice_model->add_webservice_record($inter_id, 'youcheng', $url, $params, $s,'webservice', $now, microtime (), '');

        return json_decode($s);

    }



    private function getRoomStatus($pms_set,$params){   //获取房态

        /*
         * $params['HotelID']=220001;
         * $params['StartDate']='2016-12-29';
         * $params['EndDate']='2016-12-30';
         * $params['nSourceID']=5;
         * $params['sRoomRateType']=3;
         * */

        $pms_set = json_decode($pms_set['pms_auth']);
        $url = $pms_set->url;

        $func = $url.'/books/GetHotelRoomStatus1';

        $s = $this->send('get',$func,$params);

        return $s;

    }


    private function roomStateByMem($pms_set,$nChainID,$level){  //根据会员等级获取对应的房型关系

        $pms_set = json_decode($pms_set['pms_auth']);
        $url = $pms_set->url;

        $func= $url.'/Books/GetRoomRateTypeByMebType';

        $data=array(
            'nChainID'=>$nChainID,
            'nMebType'=>$level
        );

        $res = $this->send('get',$func,$data);

        return $res;

    }



    function order_to_pms($order, $pms_set, $memberInfo,$pms_mem_info,$nChainID,$price,$orderid){    //新的订单

        $room_codes = json_decode ( $order ['room_codes'], TRUE );
        $room_codes = $room_codes [$order ['first_detail'] ['room_id']];


        $pms_set = json_decode($pms_set['pms_auth']);
        $url = $pms_set->url;

        $func= $url.'/Books/AddPersonBook';

        $startdate=strtotime($order['startdate']);
        $enddate=strtotime($order['enddate']);
        $arrive_time = date('Y-m-d',$startdate).'T'.$pms_mem_info->ArriveTime;
        $leave_time = date('Y-m-d',$enddate).'T'.$pms_mem_info->DepartTime;

        $params=array(

            'dtArroig'=> $arrive_time,
            'dtDeporig' =>$leave_time,
            'nChainID' =>$nChainID ,
            'nClientUserID'=> 333,//固定的算是操作人
            'nMebID' =>$memberInfo['pms_user_id'],//会员ID
            'nMebTypeID'=> $pms_mem_info->MebType,
            'nRoomCount' =>$order['roomnums'],
            'nRoomRate' =>ceil($price),
            'nRoomRateTypeID'=> $pms_mem_info->RoomRateTypeID,
            'nRoomTypeID' =>$room_codes ['room'] ['webser_id'],
            'nSourceID'=> 5,//原来ID
            'sClientUserName'=> '微站',
            'sGuestName'=> $order['name'],
            'sGuestMobile'=> $order['tel'],
            'sMebProperty' =>$memberInfo['membership_number'],//卡号
            'sMobile'=> $memberInfo['telephone'],
            'sName'=> $memberInfo['name']
        );

        $res = $this->send('get',$func,$params,array('orderid'=>$orderid));



        if(!isset($res->Message)){
            $res = array('s'=>1,'pms_orderid'=>$res);
        }else{
            $res = array('errmsg'=>'提交失败');
        }

        return $res;

    }




    function check_order($pms_set,$web_hotel_id,$web_order_id){    //查询对应的订单

        // 预订/停售房:有效  Book = 1,
        // 预定取消/停售房:完成  CancelBook = 2,
        // 预订未到/停售房:取消R  NoShow = 3,
        // 入住  CheckIn = 4,
        // 退房 CheckOut = 5

        $pms_set = json_decode($pms_set['pms_auth']);
        $url = $pms_set->url;

        $func= $url.'/EB/GetMebFolio';

        $params=array(
            'nFolioID'=>$web_order_id,
            'nChainID'=>$web_hotel_id,
            'nFlag'=>1
        );

        $res = $this->send('get',$func,$params);

        return $res;

    }


    public function addpayment($pms_set,$ChainID, $web_orderid, $price,$orderid,$nItemID=6012,$bIsCredit=''){    //入账

        $pms_set = json_decode($pms_set['pms_auth']);
        $url = $pms_set->url;

        if($bIsCredit=='coupon_favour'){         //优惠券抵扣不结算
            $params['bIsCredit']='false';
        }else{
            $params['bIsCredit']='true';
        }

        $params['nChainID']=$ChainID;
        $params['nFolioID']=$web_orderid;
        $params['nItemID']=$nItemID;//固定，金房卡结算
        $params['dAmount']=$price;
        $params['nClientUserID']= 333;//固定的算是操作人
        $params['sClientUserName']='微站';
        $params['nSubItemID']=0;
        $params['sRefCode']='';
        $params['sRemark']='';
        $params['sShiftCode']='';

        $func = $url.'/AccTrans/AddTrans';

        $s = $this->send('get',$func,$params,array('orderid'=>$orderid));

        return $s;


    }


    function cancelOrder($pms_set,$ChainID,$pms_order_id){    //取消订单

        $pms_set = json_decode($pms_set['pms_auth']);
        $url = $pms_set->url;

        $func= $url.'/Books/CancelPersonBook';

        $params=array(
            'nChainID'=>intval($ChainID),
            'nRoomFolioID'=>intval($pms_order_id),
            'nClientUserID'=>333, //固定的算是操作人
            'sClientUserName'=>'微站',   //操作人名称,固定
            'sRemark'=>'手机网站',
            'sStiffCode'=>0
        );

        $res = $this->send('get',$func,$params);

        return $res;

    }




    function getOrderItem($pms_set,$nChainID,$pms_orderId,$orderid){   //关联房单

        $pms_set = json_decode($pms_set['pms_auth']);
        $url = $pms_set->url;

        $func= $url.'/Books/GetAssociationRoomFolio';

        $params=array(
            'nChainID'=>$nChainID,
            'nRoomFolioID'=>$pms_orderId
        );

        $res = $this->send('get',$func,$params,array('orderid'=>$orderid));

        return $res;


    }


    function update_web_order($inter_id, $order, $pms_set) {

        $web_orders = $this->getOrderItem ( $pms_set , $pms_set ['hotel_web_id'] , $order['web_orderid']  ,$order ['orderid'] );
        $status = -1;
        $istatus = -1;

        $updata=array();
        $updata['no_check_date']=1;

        $status_arr = $this->pms_enum('status');

        $this->load->model('hotel/Order_model');

        if (! empty ( $web_orders )) {

            foreach($web_orders as $key => $arr){
                if($arr->SourceID !=5){
                    unset($web_orders[$key]);
                }
            }

            if(count($order['order_details'])==count($web_orders)){   //pms排房数与本地子订单数量相符，一一同步对应

                foreach($web_orders as $key => $web_order){

                    if($web_order->FolioState !=1 && $order['order_details'][$key]['istatus']!=4 && $status_arr[$web_order->FolioState]!=$order['order_details'][$key]['istatus']){

                        if($web_order->AccState !=2 && $web_order->FolioState==5){

                        }else{

                            $updata ['istatus'] = $status_arr[$web_order->FolioState];

                            $startdate = strtotime($web_order->Arrival);
                            $enddate = strtotime($web_order->Depart);
                            $updata ['startdate'] = date('Ymd',$startdate);
                            $updata ['enddate'] = date('Ymd',$enddate);

                            $night = (strtotime($updata ['enddate']) - strtotime($updata ['startdate']))/86400;
                            if($night==0)$night=1;

                            if($web_order->AccState ==2 && $updata ['istatus']==3){
                                $updata['new_price'] = $this->getBillAmount($pms_set,$web_order->ChainID,$web_order->FolioID);
                            }

/*                            if(($updata['new_price']==0 && $updata ['istatus']!=3) || $web_order->AccState !=2){
                                unset($updata['new_price']);
                            }*/

                            $istatus = $updata ['istatus'];

                            if($this->Order_model->update_order_item($inter_id, $order['order_details'][$key]['orderid'], $order['order_details'][$key]['sub_id'], $updata)){
                                $this->db->where ( array (
                                    'id' => $order['order_details'][$key]['sub_id'],
                                    'inter_id' => $inter_id,
                                    'orderid' => $order ['orderid']
                                ) );
                                $this->db->update ( 'hotel_order_items', array (
                                    'webs_orderid' => $web_order->FolioID,
                                ) );
                            }
                        }

                    }

                }
//                if($web_order[0]->ChgtoID==0){}

            }else{    //同步数量与本地子订单不符

                foreach($order['order_details'] as $key=>$local_order){

                    $i = $key+1;

                    if($i<=count($web_orders)){   //本地订单有对应排房对应进行同步

                        if(isset($web_orders[$key]) && $local_order['istatus']!=4 && $web_orders[$key]->FolioState!=1 && $status_arr[$web_orders[$key]->FolioState]!=$local_order['istatus']){

                            $updata['no_check_date']=1;
                            $updata ['istatus'] = $status_arr[$web_orders[$key]->FolioState];

                            $startdate = strtotime($web_orders[$key]->Arrival);
                            $enddate = strtotime($web_orders[$key]->Depart);
                            $updata ['startdate'] = date('Ymd',$startdate);
                            $updata ['enddate'] = date('Ymd',$enddate);

                            if($this->Order_model->update_order_item($inter_id, $local_order['orderid'], $local_order['sub_id'], $updata)){
                                $this->db->where ( array (
                                    'id' => $order['order_details'][$key]['sub_id'],
                                    'inter_id' => $inter_id,
                                    'orderid' => $order ['orderid']
                                ) );
                                $this->db->update ( 'hotel_order_items', array (
                                    'webs_orderid' => $web_orders[$key]->FolioID,
                                ) );
                            }

                            $istatus = $updata ['istatus'];
                        }

                    }else{

                        if($local_order['istatus']!=5){

                            unset($updata);

                            $updata ['istatus'] = 5;

                            $this->Order_model->update_order_item($inter_id, $local_order['orderid'], $local_order['sub_id'], $updata);

                        }
                    }
                }
            }
        }

        return $istatus;

    }



    function pms_enum($type) {

        // 预订/停售房:有效  Book = 1,
        // 预定取消/停售房:完成  CancelBook = 2,
        // 预订未到/停售房:取消R  NoShow = 3,
        // 入住  CheckIn = 4,
        // 退房 CheckOut = 5

        switch ($type) {
            case 'status' :
                return array (
                    '1' => 0,
                    '2' => 5,
                    '3' => 5,
                    '4' => 2,
                    '5' => 3
                );
                break;
            case 'price_code' :
                return array (
                    '0' => 1,
                    '1' => 2,
                    '2' => 3,
                    '3' => 4,
                );
                break;
            case 'func_name' :
                $data = array (
                    'GetHotelRoomStatus1' => '查询房态',
                    'GetRoomRateTypeByMebType'=>'员等级获取对应的房型关系',
                    'AddPersonBook' => '新增订单',
                    'GetMebFolio' => '查询订单',
                    'AddTrans'=>'入账',
                    'CancelPersonBook' => '取消订单',
                    'GetAssociationRoomFolio' => '查询房态',
                    'GetRoomDebit' => '房单账单'
                );
                break;
            default :
                return array ();
                break;
        }
    }


    function getBillAmount($pms_set,$nChainID,$pms_orderId){   //获取房单对应的账单金额

        $pms_set = json_decode($pms_set['pms_auth']);
        $url = $pms_set->url;

        $func= $url.'/AccTrans/GetRoomDebit';

        $params=array(
            'nChainID'=>$nChainID,
            'nFolioID'=>$pms_orderId
        );

        $res = $this->send('get',$func,$params);

        return $res;

    }


    function check_web_result($inter_id, $web_path, $send, $receive, $now, $micro_receive_time, $func_data = array(), $params = array()) {
        $func_name = substr ( $web_path, strrpos ( $web_path, '/' ) + 1 );
        $func_name_des = $this->pms_enum ( 'func_name', $func_name );
        isset ( $func_name_des ) or $func_name_des = $func_name;
        $err_msg = '';
        $err_lv = NULL;
        $alarm_wait_time = 5;
        if (! empty ( $params ['run_alarm'] )) {
            $err_msg = '程序报错,' . json_encode ( $receive, JSON_UNESCAPED_UNICODE );
            $err_lv = 1;
        } else {
            $res = json_encode ( $receive, JSON_UNESCAPED_UNICODE );
            switch ($func_name) {
                case 'GetHotelRoomStatus1' :
                    if (!isset($res->RoomTypes)) {
                        $err_msg = $receive;
                        $err_lv = 2;
                    }
                    break;
                case 'GetRoomRateTypeByMebType' :
                    if (!isset($res->MtrrtID)) {
                        $err_msg = $receive;
                        $err_lv = 2;
                    }
                    break;
                case 'AddPersonBook' :
                    if (!is_numeric($receive)) {
                        $err_msg = $receive;
                        $err_lv = 1;
                    }
                    break;
                case 'GetMebFolio' :
                    if (!isset($res->FolioID)) {
                        $err_msg = $receive;
                        $err_lv = 2;
                    }
                    break;
                case 'AddTrans' :
                    if (!is_numeric($receive)) {
                        $err_msg = $receive;
                        $err_lv = 1;
                    }
                    break;
                case 'CancelPersonBook' :
                    if (!($receive)) {
                        $err_msg = $receive;
                        $err_lv = 1;
                    }
                    break;
                case 'GetAssociationRoomFolio' :
                    if (!isset($res[0]->FolioID)) {
                        $err_msg = $receive;
                        $err_lv = 2;
                    }
                    break;
                case 'GetRoomDebit' :
                    if (!is_numeric($receive)) {
                        $err_msg = $receive;
                        $err_lv = 2;
                    }
                    break;
                default :
                    break;
            }
        }
        $this->load->model ( 'common/Webservice_model' );
        $this->Webservice_model->webservice_error_log ( $inter_id, 'youcheng', $err_lv, $err_msg, array (
            'web_path' => $web_path,
            'send' => $send,
            'receive' => $receive,
            'send_time' => $now,
            'receive_time' => $micro_receive_time,
            'fun_name' => $func_name_des,
            'alarm_wait_time' => $alarm_wait_time
        ), $func_data );
    }




}