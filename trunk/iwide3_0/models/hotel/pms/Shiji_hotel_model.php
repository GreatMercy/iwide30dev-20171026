<?php
if(!defined('BASEPATH')){
	exit('No direct script access allowed');
}

class Shiji_hotel_model extends MY_Model{
	public function __construct(){
		parent::__construct();
		$this->load->helper('common');
	}
	
	public function get_rooms_change($rooms, $idents, $condit, $pms_set = []){
		statistic('A1');
		$this->load->model('common/Webservice_model');
		$web_reflect = $this->Webservice_model->get_web_reflect($idents['inter_id'], $idents['hotel_id'], $pms_set['pms_type'], [
			'web_price_code_set'
		], 1, 'w2l');
		
		$this->load->model('api/Vmember_model', 'vm');
		$member_level = $this->vm->getLvlPmsCode($condit['openid'], $idents['inter_id']);
		
		$web_price_code = '';
		
		if(!empty ($condit['price_codes'])){
			$web_price_code = $condit['price_codes'];
		} else{
			if(!empty ($web_reflect['web_price_code'])){
				foreach($web_reflect['web_price_code'] as $wpc){
					$web_price_code .= ',' . $wpc;
				}
			}
			$web_price_code .= isset ($web_reflect['member_price_code'][$member_level]) ? ',' . $web_reflect['member_price_code'][$member_level] : '';
			$web_price_code = substr($web_price_code, 1);
		}
		$web_price_code = explode(',', $web_price_code);
		$countday = get_room_night($condit['startdate'],$condit['enddate'],'ceil',$condit);//至少有一个间夜
		$web_rids = [];
		foreach($rooms as $r){
			$web_rids[$r['webser_id']] = $r['room_id'];
		}
		statistic('A2');
		$params = [
			'countday'     => $countday,
			'web_rids'     => $web_rids,
			'condit'       => $condit,
			'web_reflect'  => $web_reflect,
			'member_level' => $member_level,
			'idents'       => $idents,
		];
		
		if(!empty ($web_price_code)){
			$pms_data = $this->get_web_roomtype($pms_set, $web_price_code, $condit['startdate'], $condit['enddate'], $params);
		}
		statistic('A3');
		$data = [];
		if(!empty ($pms_data)){
			switch($pms_set['pms_room_state_way']){
				case 1 :
				case 2 :
					$data = $this->get_rooms_change_allpms($pms_data, [
						'rooms' => $rooms
					], $params);
					break;
				case 3:
					$data = $this->get_rooms_change_lmem($pms_data, [
						'rooms' => $rooms
					], $params);
					break;
				case 4:
					$data = $this->get_rooms_change_ratecode($pms_data, [
						'rooms' => $rooms
					], $params);
					break;
			}
		}
		statistic('A4');
		
		$a_b = statistic('A1', 'A2');//查询本地配置
		$b_c = statistic('A2', 'A3');//请求PMS实时房态
		$c_d = statistic('A3', 'A4');//与本地房型匹配
		$a_d = statistic('A1', 'A4');//获取房型
		$timer_arr = [
			'查询本地配置'    => $a_b . '秒',
			'请求PMS实时房态' => $b_c . '秒',
			'与本地房型匹配'   => $c_d . '秒',
			'获取房型房态总耗时' => $a_d . '秒',
			'执行时间'      => date('Y-m-d H:i:s'),
		];
		pms_logger(func_get_args(), $timer_arr, __METHOD__ . '->query_time', $pms_set['inter_id']);
		return $data;
	}
	function point_pay_check($inter_id, $params = [], $pms_set = []){
	    $result = ['can_exchange' => 0, 'pay_set' => [], 'point_need' => 0, 'des' => ''];
	    if(empty($params['extra_para']['pms_point'])||empty($params['roomnums'])||$params['roomnums']<0){
	        $result['can_exchange'] = 0;
	        $result['errmsg'] = '参数错误';
	        return $result;
	    }
	    $result['point_need'] = $params['extra_para']['pms_point']*$params['roomnums'];
	    $result['can_exchange'] = $params['bonus'] >= $result['point_need'] ? 1 : 0;
	    $result['des'] = $result['point_need'] . '/' . $params['bonus'];
	
	    if($params['bonus'] < $result['point_need']){
	        $result['errmsg'] = '积分不足以支付';
	    }
	
	    return $result;
	}
	public function update_web_order($inter_id, $order, $pms_set){
		$this->apiInit($pms_set);
    	$web_order = $this->serv_api->getOrder($order['web_orderid'],['orderid'=>$order['orderid']]);
    	if ($order['roomnums']>1){
    		$related_order = $this->serv_api->getRelatedOrder($pms_set['hotel_web_id'],$order['web_orderid'],$order,['orderid'=>$order['orderid']]);
		}
		$status = -1;
		if($web_order){
		    $pms_auth = json_decode($pms_set['pms_auth'], true);
			$status_arr = $this->pms_enum('status');
			$status = isset($status_arr[$web_order['Status_code']['code']]) ? $status_arr[$web_order['Status_code']['code']] : false;
			if($order['status'] == 4 && $status == 5){
			    $status = 4;
			}
		    if (empty($pms_auth['suborder_update'])){
    			if($status != $order['status'] && $status !== false){
    			    $this->load->model('hotel/Order_model');
    			    $this->change_order_status($inter_id, $order['orderid'], $status);
    			    $this->Order_model->handle_order($inter_id, $order['orderid'], $status, $order['openid']);
    			}
		    }else if ($pms_auth['suborder_update']==1){
				$this->load->model('hotel/Order_model');
				$no_webid=array();
				$has_webid=array();
				$sub_order_rels=array();
                $not_exist_ids=array();
				$order_details=array_column($order ['order_details'], NULL,'sud_id');
		        foreach ( $order_details as $ok=>$od ) {
		            empty($od['webs_orderid']) ? $no_webid[]=$ok :$has_webid[$ok]=$od['webs_orderid'];
		        }
		        if (!empty($related_order)){
		            if (count($no_webid)==$order['roomnums']){
		                foreach ($related_order as $web_sub_id=>$web_sub_order){
		                    $sub_order_rels[array_shift($no_webid)]=$web_sub_id;
		                }
		            }else{
		                foreach ($has_webid as $sub_id=>$web_sub_id){
		                    if (empty($related_order[$web_sub_id])){
		                        $not_exist_ids[$sub_id]=$sub_id;
		                    }else {
		                        $sub_order_rels[$sub_id]=$web_sub_id;
		                    }
		                }
		            }
		            foreach ( $order_details as $ok=>$od ) {
                        if (isset ( $sub_order_rels [$ok] )) {
                            $webs_orderid=$sub_order_rels [$ok];
                            $istatus = $status_arr [$related_order [$webs_orderid]['Status_code']['code']];
                            if ($od ['istatus'] == 4 && $istatus == 5) {
                                $istatus = 4;
                            }
                            $web_start = date ( 'Ymd', strtotime ( $related_order [$webs_orderid] ['Arrival'] ) );
                            $web_end = date ( 'Ymd', strtotime ( $related_order [$webs_orderid] ['Departure'] ) );
                            $web_end = $web_end == $web_start ? date ( 'Ymd', strtotime ( '+ 1 day', strtotime ( $web_start ) ) ) : $web_end;
                            $ori_day_diff = get_room_night ( $od ['startdate'], $od ['enddate'], 'ceil', $od ); // 至少有一个间夜
                            $web_day_diff = get_room_night ( $web_start, $web_end, 'ceil' ); // 至少有一个间夜
                            $day_diff = $web_day_diff - $ori_day_diff;
                            
                            $updata = array ();
                            if ($istatus != $od ['istatus']) {
                                $updata ['istatus'] = $istatus;
                            }
                            if (($day_diff != 0 || $web_start != $od ['startdate'] || $web_end != $od ['enddate'])) {
                                $updata ['no_check_date'] = 1;
                                $updata ['startdate'] = $web_start;
                                $updata ['enddate'] = $web_end;
                            }
                            $web_price = $related_order[$webs_orderid]['Total_revenue']*1;
                            if ($web_price!=$od['iprice']) {
                                $updata ['new_price'] = $web_price;
                            }
                            if (empty($od['webs_orderid'])){
                                $updata['webs_orderid']=$webs_orderid;
                            }
                            if (! empty ( $updata )) {
                                $this->Order_model->update_order_item ( $inter_id, $order ['orderid'], $od ['sub_id'], $updata );
                            }
                        }else if(isset($not_exist_ids[$ok])){
                            
                        }
                    }
		        }else {
		            if (!in_array($status,array(0,1))){
		                $this->change_order_status($inter_id, $order['orderid'], $status);
		                $this->Order_model->handle_order($inter_id, $order['orderid'], $status, $order['openid']);
		            }
		        }
		    }
		}
		
		return $status;
	}
	
	public function order_to_web($inter_id, $orderid, $params = array(), $pms_set = array()){
		$this->load->model('hotel/Order_model');
		$order = $this->Order_model->get_main_order($inter_id, array(
			'orderid' => $orderid,
			'idetail' => array(
				'i'
			)
		));
		if(!empty ($order)){
			$order = $order[0];   //获取本地已保存的订单信息
			$pms_auth = json_decode($pms_set['pms_auth'], true);
			$room_codes = json_decode($order['room_codes'], true);
			$room_codes = $room_codes[$order['first_detail']['room_id']]; //$room_codes 结构：array('本地room_id'=>array('room'=>array('webser_id'=>房型代码),'code'=>array($extra_info(就是取房态时的 extra_info),'price_type'=>'价格类型')))
//			$pms_set['pms_auth'] = json_decode($pms_set['pms_auth'], TRUE);
			
			/*
				构造要提交的数据
			*/
			
			$result = $this->order_reserve($order, $inter_id, $pms_set, $params);//提交订单
			
			if($result['result']){
				$web_orderid = $result['web_orderid'];            //取得返回的pms订单id
				$this->db->where(array(
					'orderid'  => $order['orderid'],
					'inter_id' => $order['inter_id']
				));
				$this->db->update('hotel_order_additions', array(        //更新pms单号到本地
				                                                         'web_orderid' => $web_orderid
				));
				$upstatus=NULL;
				$has_paid=NULL;
				$this->load->model ( 'hotel/Hotel_config_model' );
				$config_data = $this->Hotel_config_model->get_hotel_config ( $inter_id, 'HOTEL', $order ['hotel_id'], array (
				        'PMS_BANCLANCE_REDUCE_WAY',
				        'PMS_POINT_REDUCE_WAY'
				) );
				if($order['status'] != 9){
				    $upstatus=1;
// 					$this->change_order_status($inter_id, $orderid, 1);
// 					$this->Order_model->handle_order($inter_id, $orderid, 1); // 若pms的订单是即时确认的，执行确认操作，否则省略这一步
				}else if ($order['paytype']=='point'){
				    $params=array();
				    $params['crsNo'] = $web_orderid;
				    if (! empty ( $config_data ['PMS_POINT_REDUCE_WAY'] ) && $config_data ['PMS_POINT_REDUCE_WAY'] == 'after') {
				        if (!empty($pms_auth['pms_reduce_paypoint'])){
				            $has_paid=1;//积分支付时由pms下单时扣减,则下单成功表示支付成功
				        }else{
				            $this->load->model ( 'hotel/Member_model' );
				            if (! $this->Member_model->consum_point ( $order ['inter_id'], $order ['orderid'], $order ['openid'], $order ['point_used_amount'],$params )) {
				                $info = $this->Order_model->cancel_order ( $inter_id, array (
				                        'only_openid' => $order ['openid'],
				                        'member_no' => '',
				                        'orderid' => $order ['orderid'],
				                        'cancel_status' => 5,
				                        'no_tmpmsg' => 1,
				                        'delete' => 2,
				                        'idetail' => array (
				                                'i'
				                        )
				                ) );
				                return array (
				                        's' => 0,
				                        'errmsg' => '积分扣减失败'
				                );
				            }else{
				                $has_paid=1;
				            }
				        }
				    }
				}else if ($order ['paytype'] == 'balance'){
    				if (! empty ( $config_data ['PMS_BANCLANCE_REDUCE_WAY'] ) && $config_data ['PMS_BANCLANCE_REDUCE_WAY'] == 'after') {
    					$this->load->model ( 'hotel/Member_model' );
    					$balance_param=array(
    						'crsNo'=>$web_orderid
    					);
    					if ($this->Member_model->reduce_balance ( $inter_id, $order ['openid'], $order ['price'], $order ['orderid'], '订房订单余额支付',$balance_param,$order)) {
    					    $has_paid=1;
    					} else {
    						$info = $this->Order_model->cancel_order ( $inter_id, array (
    							'only_openid' => $order ['openid'],
    							'member_no' => '',
    							'orderid' => $order ['orderid'],
    							'cancel_status' => 5,
    							'no_tmpmsg' => 1,
    							'delete' => 2,
    							'idetail' => array (
    								'i'
    							)
    						) );
    						return array (
    							's' => 0,
    							'errmsg' => '储值支付失败'
    						);
    					}
    				}
    			}
				
				if(!empty ($params['third_no'])){ // 提交账务,如果传入了 trans_no,代表已经支付，调用pms的入账接口
					$this->add_web_bill($web_orderid, $order, $pms_set, $params['third_no']);
				}
				return array( // 返回成功
				         's' => 1,
				         'has_paid'=>$has_paid,
				         'upstatus'=>$upstatus
				);
			} else{
				$this->change_order_status($inter_id, $orderid, 10);
				return array( // 返回失败
				              's'      => 0,
				              'errmsg' => '提交订单失败' . ',' . $result['errmsg']
				);
			}
		}
		return array(
			's'      => 0,
			'errmsg' => '提交订单失败'
		);
	}
	
	private function change_order_status($inter_id, $orderid, $status){
		$this->db->where(array(
			'orderid'  => $orderid,
			'inter_id' => $inter_id
		));
		$this->db->update('hotel_orders', array( // 提交失败，把订单状态改为下单失败
		                                         'status' => (int)$status
		));
	}
	
	public function cancel_order_web($inter_id, $order, $pms_set = array()){
		
		if(empty ($order['web_orderid'])){
			return array(
				's'      => 0,
				'errmsg' => '取消失败'
			);
		}
		$ri_edit = array();
		/*
			构造取消订单数据
		*/
		$this->apiInit($pms_set);
		$res = $this->serv_api->cancelReservation($order['web_orderid'],'用户取消',['orderid'=>$order['orderid']]);
		if(isset($res['result']) && $res['result']){
			return array(                        //取消成功，直接这样return，接下来的程序会继续处理
			                                     's'      => 1,
			                                     'errmsg' => '取消成功'
			);
		}
		
		return array(
			's'      => 0,
			'errmsg' => '取消失败,' . (isset($res['ErrReason']) ? $res['ErrReason'] : ''),
		);
	}
	
	public function add_web_bill($web_orderid, $order, $pms_set, $trans_no = ''){
		$web_paid = 2;
		$this->apiInit($pms_set);
		$web_order = $this->serv_api->getOrder($web_orderid,['orderid'=>$order['orderid']]);
		if(!$web_order){
			$this->db->where(array(
				'orderid'  => $order['orderid'],
				'inter_id' => $order['inter_id']
			));
			$this->db->update('hotel_order_additions', array( //更新web_paid 状态，2为失败，1为成功
			                                                  'web_paid' => $web_paid
			));
			return false;
		}
		
		$pay_params = [
			'OrderId'            => $web_orderid,
			'GatewayReferenceNo' => $trans_no,
			'Amount'             => $order['price'],
			//			'Remark'             => '微信支付商户单号：' . $order['orderid'],
		];
		
		$res = $this->serv_api->addPaymentGateway($pay_params,['orderid'=>$order['orderid']]);
		if(!empty($res['OrderId'])){
			$remark = $web_order['Comments'];
			$remark .= ' 支付方式：微信支付，【支付单号:' . $trans_no . '】';
//			$remark .= '该订单已使用微信支付，支付单号:' . $trans_no;
			$web_order['Comments'] = $remark;
			$func_data=['orderid'=>$order['orderid']];
			
			$post_data['oOrderInfo'] = $web_order;
			$res = $this->serv_api->modifyOrder($post_data,$func_data);
			
			$pms_auth = json_decode($pms_set['pms_auth'], true);
			
			$post_data['oOrderInfo']['Reservation_type'] = [
				'code' => !empty($pms_auth['reserv_type']['paid']) ? $pms_auth['reserv_type']['paid'] : 'GPP'
			];
			
			$res = $this->serv_api->modifyOrder($post_data,$func_data);
			
			$web_paid = 1;
		}
		
		/*$remark = $web_order['Comments'];
		$remark .= '该订单已使用微信支付，支付单号:' . $trans_no;
//		$remark.='测试修改订单';
		$web_order['Comments'] = $remark;
		$post_data['oOrderInfo'] = $web_order;

		$res = $this->serv_api->modifyOrder($post_data);

		if(!empty($res['oOrderInfo'])){
			$web_paid = 1;
		}*/
		
		$this->db->where(array(
			'orderid'  => $order['orderid'],
			'inter_id' => $order['inter_id']
		));
		$this->db->update('hotel_order_additions', array(
			'web_paid' => $web_paid
		));
		
		return $web_paid==1;
		
	}
	
	function order_reserve($order, $inter_id, $pms_set, $params = array()){
		
		$this->apiInit($pms_set);
		
		$starttime = strtotime($order['startdate']);
		$endtime = strtotime($order['enddate']);
		$startdate = date('Y-m-d', $starttime);
		$enddate = date('Y-m-d', $endtime);
		
		$room_codes = json_decode($order['room_codes'], true);
		$room_codes = $room_codes[$order['first_detail']['room_id']];
		
		$extra_info = $room_codes['code']['extra_info'];
		
		if(!isset($extra_info['pms_code'])){
			return array(
				'result' => false,
				'errmsg' => '不存在价格代码',
			);
		}
		
		$data = array(
			'hotel_code' => $pms_set['hotel_web_id'],
			'arrival'    => $startdate,
			'departure'  => $enddate,
			'room_type'  => $room_codes['room']['webser_id'],
			'rate_code'  => $extra_info['pms_code']
		);

//		$rate_detail = $this->serv_api->getRateDetailDaily($data);
		
		/*if(!empty($rate_detail['RetCode'])){
			return array(
				'result' => false,
				'errmsg' => $rate_detail['ErrReason']
			);
		}*/
		if(!empty($extra_info['adv_bookin'])){
			$bday = ceil((strtotime($order['startday']) - strtotime(date('Y-m-d')) / 86400));
			if($bday > $extra_info['adv_bookin']){
				return array(
					'result' => false,
					'errmsg' => '超过可预订时间',
				);
			}
		}
		
		/*if(empty($rate_detail['RoomRateDetails']['RoomRateDetail']['RateDetailDailys']['RateDetailDaily'])){
			return array(
				'result' => false,
				'errmsg' => '房型信息不存在'
			);
		}*/
		
		$count_day = get_room_night($startdate,$enddate,'ceil',$order);//至少有一个间夜
//		$daily_args = $rate_detail['RoomRateDetails']['RoomRateDetail']['RateDetailDailys']['RateDetailDaily'];
//		is_array(current($daily_args)) or $daily_args = array($daily_args);
		$real_price = explode(',', $order['first_detail']['real_allprice']);
		$stay_info = array();
		
		$daily_remark = [];
		
		if (!empty($order['first_detail']['inners'])){
		    $inners=json_decode($order['first_detail']['inners'],TRUE);
		    $per_adult_num=isset($inners['adults'])?count($inners['adults']):1;
		    $per_child_num=isset($inners['children'])?count($inners['children']):0;
		    $baby_num=empty($inners['baby']['num'])?0:intval($inners['baby']['num']);
		}else{
		    $per_adult_num=1;
		    $per_child_num=0;
		    $baby_num=0;
		}
		$pms_auth = json_decode($pms_set['pms_auth'], true);
	//	$order['paytype']='point';
	//	$order['member_no']='20000005';
		for($i = 0; $i < $count_day; $i++){
//			$v = $daily_args[$i];
//			$house_date = explode('T', $v['InHouseDate']);
			
			$house_date = date('Y-m-d', $starttime + ($i * 86400));
			$stay_info['OrderRoomStayInfo'][] = array(
				'DT'           => $house_date,
				'RoomTypeCode' => $room_codes['room']['webser_id'],
				'RateAmount'   => $real_price[$i],//isset($real_price[$i]) ? doubleval($real_price[$i]) : $v['prs_1'],
				//				'Tax'           => $v['Tax'],
				//				'ServiceCharge' => $v['ServiceCharge'],
				'CurrencyType' => 'CNY',
				'RoomNum'      => 1,
				'Adults'       => $per_adult_num,
				'ExtraBed'     => 0,
				'Children'     => $per_child_num,
				'RateCode'     => $extra_info['pms_code'],
				'FixedRate'    => empty($pms_auth['FixedRate'])?TRUE:FALSE,
			);
			
			$daily_remark[] = $real_price[$i] . ' ' . $house_date;
		}
		
		$remark = empty($pms_auth['no_remark_rate'])?'戴斯微信渠道_金房卡 日房价/' . implode('/', $daily_remark) . ' 总房价 ' . $order['price']:'';

		if($order['coupon_favour'] > 0){
			$remark .= ' 使用优惠券:' . $order['coupon_favour'] . '元。';
		}
		if($order['paytype']=='daofu'){
			$remark .= ' 支付方式：酒店现付。';
		}
		
		if(!empty($paras['trans_no'])){
			$remark .= ' 支付方式：微信支付，【支付单号:' . $params['trans_no'] . '】。';
		}
		
		$this->load->model('api/Vmember_model', 'vm');
		$member = $this->vm->getUserInfo($order['openid'], $order['inter_id']);
		
	    $reservation_type=empty($pms_auth['reserv_type'][$order['paytype']])?(!empty($pms_auth['reserv_type']['no_pay'])?$pms_auth['reserv_type']['no_pay']:'6PM'):$pms_auth['reserv_type'][$order['paytype']];
		$post_data['oOrderInfo'] = array(
			'Arrival'            => date('Y-m-d', strtotime($order['startdate'])),
			'ArrivalTime'        => '18:00',
			//						'Keep_hour'             => $order['holdtime'],
			'Departure'          => date('Y-m-d', strtotime($order['enddate'])),
			'Room_num'           => $order['roomnums'],
			'Adults'             => $per_adult_num*$order['roomnums'],
			'Children'           => $per_child_num*$order['roomnums'],
			'Infant'           => $baby_num,
			'Extra_bed'          => 0,
			'Firstname'          => $order['name'],
			'Lastname'           => $order['name'],
			'Mobile'             => $order['tel'],
			'Phone'              => $order['tel'],
			'ChineseName'        => $order['name'],
		    'Email'              => $order['email'],
// 		    'BookerName'              => $order['name'],
// 		    'BookerEmail'              => $order['email'],
// 		    'BookerMobile'              => $order['tel'],
		    'Birthday'=>'1900-01-01T00:00:00',
			//			'Email_confirm'         => $order['email'],
			'OrderRoomStayInfos' => $stay_info,
			'Hotel_code'         => array(
				'code' => $pms_set['hotel_web_id'],
			),
			'Guesttype_code'     => array(
				'code' => $order['member_no'] ? "0002" : "0000",
			),
			'Roomtype_code'      => array(
				'code' => $room_codes['room']['webser_id']
			),
			'Rate_code'          => array(
				'code' => $extra_info['pms_code'],
			),
			/*'Channel'            => array(
				'code' => 'WEB',
			),
			'Source'             => array(
				'code' => 'LOP',
			),
			'Market'             => array(
				'code' => 'WEB',
			),*/
			
			'Member_id'             => array('code' => $order['member_no']),
			'Reservation_type'      => array(
				'code' => $reservation_type,
			),
			'Total_revenue'         => $order['price'],
			'Title'                 => array(
				'code' => 'Mm',
				'name' => '先生/女士',
			),
// 			'Comments'              => $remark,
			'Isfixedrate'           => empty($pms_auth['FixedRate'])?TRUE:FALSE,
			'Rate'                  => $real_price[0]*$order['roomnums'],
		    'ChannelConfirmID'      =>$order['orderid']
		);
		if (isset($pms_auth['multi_inn'])){
		    $this->load->helper('string');
		    $names=dismantle_manname($order['name']);
		    $post_data['oOrderInfo']['Firstname']=$names['first'];
		    $post_data['oOrderInfo']['Lastname']=$names['last'];
		    foreach ($order['order_details'] as $od){
		        $item_inner=json_decode($od['inners'],TRUE);
		        if (isset($item_inner['adults'])){
		            foreach ($item_inner['adults'] as $a){
		                $names=dismantle_manname($a['name']);
		                $post_data['oOrderInfo']['Accompanyings']['OrderInfoAccompanying'][]=array(
		                        'FirstName' => $names['first'],
		                        'ChineseName'=>$a['name'],
		                        'LastName'=>$names['last'],
		                        'Birthday'=>'1900-01-01'
		                );
		            }
		        }
		        if (isset($item_inner['children'])){
		            foreach ($item_inner['children'] as $c){
		                $names=dismantle_manname($c['name']);
		                $post_data['oOrderInfo']['Accompanyings']['OrderInfoAccompanying'][]=array(
		                        'FirstName' => $names['first'],
		                        'ChineseName'=>$c['name'],
		                        'LastName'=>$names['last'],
		                        'Birthday'=>isset($c['birthday'])?$c['birthday']:'1900-01-01'
		                );
		            }
		        }
		    }
		    if ($baby_num){
		        for ($i=1;$i<=$baby_num;$i++){
		            $post_data['oOrderInfo']['Accompanyings']['OrderInfoAccompanying'][]=array(
		                    'FirstName' => '儿'.$i,
		                    'ChineseName'=>'婴儿'.$i,
		                    'LastName'=>'婴',
		                    'Birthday'=>date('Y-01-01')
		            );
		        }
		    }
	        array_shift($post_data['oOrderInfo']['Accompanyings']['OrderInfoAccompanying']);
		}else{
		    $post_data['oOrderInfo']['OrderInfoAccompanying'] = array(
				'FirstName' => $order['name'],
				'Mobile'    => $order['tel'],
				//				'Email'     => $order['email'],
			);
		}
		if (!empty($order['add_service_info'])){
		    $service_info=json_decode($order['add_service_info'],TRUE);
		    if (!empty($service_info['parking'])){
		        $remark.='需要预留车位，车牌号：'.$service_info['parking']['car_no'].'。';
		    }
		    if (!empty($service_info['invoice'])){
		        $remark.='需要开发票：';
		        if ($service_info['invoice']['type']==2){
		            $remark.='增值税专用发票，';
		            $remark.='单位名称：'.$service_info['invoice']['title'].'，';
		            $remark.='纳税人编号：'.$service_info['invoice']['content']['code'].'，';
		            $remark.='注册地址：'.$service_info['invoice']['content']['address'].'，';
		            $remark.='注册电话：'.$service_info['invoice']['content']['phonecall'].'，';
		            $remark.='开户银行：'.$service_info['invoice']['content']['bank'].'，';
		            $remark.='银行帐号：'.$service_info['invoice']['content']['account'].'。';
		        }else{
    		        $remark.='普通发票,抬头：'.$service_info['invoice']['title'].'。';
		        }
		    }
		    if (!empty($service_info['pickup']['way'])){
// 		        $remark.='来时接送：';
// 		        $remark.=$service_info['pickup']['way']=='train'?'车站':'机场';
// 		        $remark.='：'.$service_info['pickup']['station'];
// 		        $remark.='，'.$service_info['pickup']['tno'];
// 		        $remark.='，'.date('Y-m-d H:i',strtotime($service_info['pickup']['arrtime'])).'。';
		        $post_data['oOrderInfo']['ArrivalTransportationYN']='Y';
		        $post_data['oOrderInfo']['ArrivalStationCode']=$service_info['pickup']['station'];
		        $post_data['oOrderInfo']['ArrivalDateTime']=date('Y-m-d',strtotime($service_info['pickup']['arrtime'])).'T'.date('H:i:s',strtotime($service_info['pickup']['arrtime']));
		        $post_data['oOrderInfo']['ArrivalTransportNo']=$service_info['pickup']['tno'];
		    }
		    if (!empty($service_info['takeoff']['way'])){
// 		        $remark.='回程接送：';
// 		        $remark.=$service_info['takeoff']['way']=='train'?'车站':'机场';
// 		        $remark.='：'.$service_info['takeoff']['station'];
// 		        $remark.='，'.$service_info['takeoff']['tno'];
// 		        $remark.='，'.date('Y-m-d H:i',strtotime($service_info['takeoff']['arrtime'])).'。';
		        $post_data['oOrderInfo']['DepartureTransportationYN']='Y';
		        $post_data['oOrderInfo']['DepartureStationCode']=$service_info['takeoff']['station'];
		        $post_data['oOrderInfo']['DepartureDateTime']=date('Y-m-d',strtotime($service_info['takeoff']['arrtime'])).'T'.date('H:i:s',strtotime($service_info['takeoff']['arrtime']));
		        $post_data['oOrderInfo']['DepartureTransportNo']=$service_info['takeoff']['tno'];
		    }
		}
		if($member['pms_user_id']){
			$post_data['oOrderInfo']['BookerID']=$member['membership_number'];
		}
		if (!empty($order['customer_remark'])){
		    $remark.='客人备注：'.$order['customer_remark'].'。';
		}
		$post_data['oOrderInfo']['Comments']=$remark;
		$res = $this->serv_api->createReservation($post_data,['orderid'=>$order['orderid']]);
		if(!empty($res['oOrderInfo'])){
			return array(
				'result'      => true,
				'web_orderid' => $res['oOrderInfo']['ID'],
			);
		} else{
			return array(
				'result' => false,
				'errmsg' => isset($res['ErrReason']) ? $res['ErrReason'] : ''
			);
		}
		
	}
	
	function pms_enum($type = 'status'){
		switch($type){
			case 'status':
				/*0001：RESERVED  ；0003：CANCELED  ；0004：CHECK IN；0005：WAITING；0006：CHECK OUT ；0007：NO SHOW；0008：REJECTED
				*/
				//订单状态,0预订，1确认，2入住，3离店，4用户取消，5酒店取消,6酒店删除，7异常，8未到，9待支付
				return array(
					'0001' => 1,
					'0003' => 5,
					'0004' => 2,
					'0005' => 1,
					'0006' => 3,
					'0007' => 8,
					'0008' => 5
				);
				break;
			default:
				return array();
				break;
		}
	}
	
	function get_web_roomtype($pms_set, $web_price_code, $startdate, $enddate, $params = array()){
//		$member_level = $params['member_level'];
//		$countday = $params['countday'];
		
		$this->apiInit($pms_set);
		$pms_auth=json_decode($pms_set['pms_auth'],TRUE);
		//PMS上的会员ID
		$this->load->model('api/Vmember_model', 'vm');
		$pms_user = $this->vm->getUserInfo($params['condit']['openid'], $pms_set['inter_id']);
		
		$adata = array(
			'hotel_code' => $pms_set['hotel_web_id'],
			'arrival'    => date('Y-m-d', strtotime($startdate)),
			'departure'  => date('Y-m-d', strtotime($enddate)),
			//			'card_no'        => '00000002',
			//			'guesttype_code' => '0002',
		);
		if($pms_user && $pms_user['pms_user_id'] != ''){
			$adata['card_no'] = $pms_user['membership_number'];
// 			$adata['card_no'] = '20000005';
			$adata['guesttype_code'] = '0002';
		}
//$adata['card_no'] = '20000005';
//$adata['guesttype_code'] = '0002';
		
		$pms_state = array();
		$valid_state = array();
		$exprice = array();
		
		$ailability_result = $this->serv_api->getAvailability($adata,['hotel_id'=>$params['idents']['hotel_id']]);
		if(!empty($ailability_result['RateInfos']['RateInfo'])){
			
			$rate_list = $ailability_result['RateInfos']['RateInfo'];
			is_array(current($rate_list)) or $rate_list = array($rate_list);
			foreach($rate_list as $v){
				$rate_info = $v['Rate'];
				$rate_name_arr = explode('|', $rate_info['name']);
				$web_rate = $rate_info['code'];
//				print_r($web_price_code);
//				print_r($web_rate);
				/*if(!in_array($web_rate, $web_price_code)){
					continue;
				}*/
//				if(in_array($web_rate, $web_price_code)){
				$room_rate_list = $v['RoomRateDetails']['RoomRateDetail'];
				$multi = false;
				foreach($room_rate_list as $k => $t){
					if(is_int($k)){
						$multi = true;
					} else{
						$multi = false;
					}
					break;
				}
				if(!$multi){
					$room_rate_list = array($room_rate_list);
				}
				foreach($room_rate_list as $t){
					$web_room = $t['RoomTypeDetail']['code'];
					if(array_key_exists($web_room, $params['web_rids'])){
						$pms_state[$web_room][$web_rate]['price_name'] = $rate_name_arr[0];
						$pms_state[$web_room][$web_rate]['price_type'] = 'pms';
						$pms_state[$web_room][$web_rate]['price_code'] = $web_rate;
						$pms_state[$web_room][$web_rate]['extra_info'] = array(
							'type'           => 'code',
							'pms_code'       => $web_rate,
							'adv_bookin'     => $rate_info['AdvBookin'],
							//																'channel_code' => $rd['channelCode']
						);
						$pms_state[$web_room][$web_rate]['des'] = '';
						$pms_state[$web_room][$web_rate]['sort'] = 0;
						$pms_state[$web_room][$web_rate]['disp_type'] = 'buy';
						
						$web_set = array();
						if(isset ($params['web_reflect']['web_price_code_set'][$web_rate])){
							$web_set = json_decode($params['web_reflect']['web_price_code_set'][$web_rate], true);
						}
						
						$pms_state[$web_room][$web_rate]['condition'] = $web_set;
						
						if(isset($params['web_rids'][$web_room]) && isset($params['condit']['nums'][$params['web_rids'][$web_room]])){
							$nums = $params['condit']['nums'][$params['web_rids'][$web_room]];
						} else{
							$nums = 1;
						}
						
						$allprice = array();
						$amount = 0;
						
						if(1 == $t['RoomTypeDetail']['Status']){
							$room_status = true;
						} else{
							$room_status = false;
						}
						
						$least_arr = [];
						$least_count = 0;
						$date_status = true;
						$total_point=0;
						
						$room_rate_daily = $t['RateDetailDailys']['RateDetailDaily'];
						is_array(current($room_rate_daily)) or $room_rate_daily = array($room_rate_daily);
						foreach($room_rate_daily as $w){
							if($w['prs_1']>0){
								$in_date_arr = explode('T', $w['InHouseDate']);
								$pms_state[$web_room][$web_rate]['date_detail'][date('Ymd', strtotime($in_date_arr[0]))] = array(
									'price' => $w['prs_1']*1,
									'nums'  => $w['AvailableRooms']
								);
								
								$allprice[] = $w['prs_1']*1;
								$amount += $w['prs_1'];
								$least_arr[] = $w['AvailableRooms'];
								
								$date_status=$date_status&&$w['Status']==1&&$w['AvailableRooms']>0;
								
								if (!empty($w['Resv_points'])&&$w['Resv_points']>0){
								    $pms_state[$web_room][$web_rate]['extra_info']['day_points'][$w['Resv_points']][]=date('Ymd', strtotime($in_date_arr[0]));
								    $total_point+=$w['Resv_points'];
								}
							}
						}
						
						//校验日期价格
						$all_exists = true;
						for($start = date('Ymd', strtotime($startdate)); $start < date('Ymd', strtotime($enddate));){
							if(empty($pms_state[$web_room][$web_rate]['date_detail'][$start])){
								$all_exists = false;
								break;
							}
							$start = date('Ymd', strtotime($start) + 86400);
						}
						
						//是否所有日期都直接价格代码
						if(!$all_exists){
							unset($pms_state[$web_room][$web_rate]);
							continue;
						}
						
						if($least_arr){
							$least_arr[] = empty($pms_auth['max_book_num'])?1:intval($pms_auth['max_book_num']);
							$least_count = min($least_arr);
						}
						$least_count > 0 or $least_count = 0;
						
						$pms_state[$web_room][$web_rate]['allprice'] = implode(',', $allprice);
						$pms_state[$web_room][$web_rate]['total'] = $amount;
						$pms_state[$web_room][$web_rate]['related_des'] = '';
						$pms_state[$web_room][$web_rate]['total_price'] = $amount * $nums;
						if(!empty($total_point)) {
						    $pms_state[$web_room][$web_rate]['pms_point'] = $total_point;
						    $pms_state[$web_room][$web_rate]['pms_total_point'] = $total_point * $nums;
						}
						
						$pms_state[$web_room][$web_rate]['avg_price'] = number_format($amount / $params['countday'], 2, '.', '');
						$pms_state[$web_room][$web_rate]['price_resource'] = 'webservice';
						
						$book_status = 'full';
						if($room_status && $date_status){
							$book_status = 'available';
						}
						
						$pms_state[$web_room][$web_rate]['book_status'] = $book_status;
						$exprice[$web_room][] = $pms_state[$web_room][$web_rate]['avg_price'];
						
						$pms_state[$web_room][$web_rate]['least_num'] = $least_count;
						$valid_state[$web_room][$web_rate] = $pms_state[$web_room][$web_rate];
					}
//					}
				}
			}
		}
		
		return array(
			'pms_state'   => $pms_state,
			'valid_state' => $valid_state,
			'exprice'     => $exprice
		);
	}
	
	
	public function get_rooms_change_ratecode($pms_data, $rooms, $params){
		$local_rooms = $rooms['rooms'];
		$condit = $params['condit'];
		$this->load->model('hotel/Order_model');
		$data = $this->Order_model->get_rooms_change($local_rooms, $params['idents'], $params['condit']);
		$pms_state = $pms_data['pms_state'];
		$valid_state = $pms_data['valid_state'];
		
		$merge = [
			'least_num',
			'book_status',
			'extra_info',
			'date_detail',
			//			'avg_price',
			//			'allprice',
			//			'total',
			//			'total_price',
			'pms_point',
			'pms_total_point'
		];
		
		foreach($data as $room_key => $lrm){
			$min_price = [];
			if(empty ($valid_state[$lrm['room_info']['webser_id']])){
				unset ($data[$room_key]);
				continue;
			}
			
			$nums = isset ($condit['nums'][$lrm['room_info']['room_id']]) ? $condit['nums'][$lrm['room_info']['room_id']] : 1;
			
			if(!empty($lrm['state_info'])){
				
				foreach($lrm['state_info'] as $sik => $si){
					
					//需要设置PMS价格代码值
					$web_rate = $si['external_code'];
					
					if($web_rate === '' || empty($pms_state[$lrm['room_info']['webser_id']][$web_rate])){//PMS上不存在该价格代码
						unset($data[$room_key]['state_info'][$sik]);
						continue;
					}
					
					//PMS上的房态数据
					$tmp = $pms_state[$lrm['room_info']['webser_id']][$web_rate];
					foreach($merge as $w){
						if(isset($tmp[$w])){
							
							if($w == 'date_detail'){
								$allprice = '';
								$amount = 0;
								foreach($tmp[$w] as $dk => $td){
									if($si['related_cal_way'] && $si['related_cal_value']){
										$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
									} else{
										$tmp[$w][$dk]['price'] = $td['price'];
									}
									$tmp[$w][$dk]['nums'] = $tmp['least_num'];
									$allprice .= ',' . $tmp[$w][$dk]['price'];
									$amount += $tmp[$w][$dk]['price'];
								}
								
								$data[$room_key]['state_info'][$sik]['avg_price'] = number_format($amount / $params['countday'], 1,'.','');
								$data[$room_key]['state_info'][$sik]['allprice'] = substr($allprice, 1);
								$data[$room_key]['state_info'][$sik]['total'] = intval($amount);
								$data[$room_key]['state_info'][$sik]['total_price'] = $data[$room_key]['state_info'][$sik]['total'] * $nums;
							}
							$data[$room_key]['state_info'][$sik][$w] = $tmp[$w];
						}
					}
					
					$min_price[] = str_replace(',','',$data[$room_key]['state_info'][$sik]['avg_price']);
//					}
				}
			}
			$data[$room_key]['lowest'] = empty($min_price) ? 0 : min($min_price);
			$data[$room_key]['highest'] = empty($min_price) ? 0 : max($min_price);
			/*if(empty($lrm['show_info'])){
				$lrm['show_info'] = $lrm['state_info'];
				$data[$room_key]['show_info'] = $lrm['state_info'];
			}*/
			if(!empty($lrm['show_info'])){
				foreach($lrm['show_info'] as $sik => $si){
					//需要设置PMS价格代码值
					$web_rate = $si['external_code'];
					if($web_rate === '' || empty($pms_state[$lrm['room_info']['webser_id']][$web_rate])){//PMS上不存在该价格代码
//					echo '<pre>';print_r($pms_state[$lrm['room_info']['webser_id']]);print_r($lrm);exit;
						unset($data[$room_key]['show_info'][$sik]);
						continue;
					}
					
					//PMS上的房态数据
					$tmp = $pms_state[$lrm['room_info']['webser_id']][$web_rate];
					foreach($merge as $w){
						if(isset($tmp[$w])){
							
							if($w == 'date_detail'){
								$allprice = '';
								$amount = 0;
								foreach($tmp[$w] as $dk => $td){
									if($si['related_cal_way'] && $si['related_cal_value']){
										$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
									} else{
										$tmp[$w][$dk]['price'] = $td['price'];
									}
									$tmp[$w][$dk]['nums'] = $tmp['least_num'];
									$allprice .= ',' . $tmp[$w][$dk]['price'];
									$amount += $tmp[$w][$dk]['price'];
								}
								
								$data[$room_key]['show_info'][$sik]['avg_price'] = number_format($amount / $params['countday'], 1);
								$data[$room_key]['show_info'][$sik]['allprice'] = substr($allprice, 1);
								$data[$room_key]['show_info'][$sik]['total'] = intval($amount);
								$data[$room_key]['show_info'][$sik]['total_price'] = $data[$room_key]['show_info'][$sik]['total'] * $nums;
							}
						}
						
						$data[$room_key]['show_info'][$sik][$w] = $tmp[$w];
					}
				}
			}
			if(empty($data[$room_key]['state_info'])){
				unset($data[$room_key]);
			}
		}
// 		echo '<pre>';print_r($data);exit;
		
		return $data;
	}
	
	
	public function get_rooms_change_allpms($pms_state, $rooms, $params){
		$data = array();
		foreach($rooms['rooms'] as $rm){
			if(!empty ($pms_state['pms_state'][$rm['webser_id']])){
				$data[$rm['room_id']]['room_info'] = $rm;
				$data[$rm['room_id']]['state_info'] = empty ($pms_state['valid_state'][$rm['webser_id']]) ? array() : $pms_state['valid_state'][$rm['webser_id']];
				$data[$rm['room_id']]['show_info'] = $pms_state['pms_state'][$rm['webser_id']];
				$data[$rm['room_id']]['lowest'] = min($pms_state['exprice'][$rm['webser_id']]);
				$data[$rm['room_id']]['highest'] = max($pms_state['exprice'][$rm['webser_id']]);
			}
		}
		
		return $data;
	}
	
	function get_rooms_change_lmem($pms_data, $rooms, $params){
		$local_rooms = $rooms['rooms'];
		$condit = $params['condit'];
		$this->load->model('hotel/Order_model');
		$data = $this->Order_model->get_rooms_change($local_rooms, $params['idents'], $params['condit']);
		$pms_state = $pms_data['pms_state'];
		$valid_state = $pms_data['valid_state'];
		foreach($data as $room_key => $lrm){
			$min_price = [];
			if(empty ($valid_state[$lrm['room_info']['webser_id']])){
				unset ($data[$room_key]);
				continue;
			}
			if(!empty ($lrm['state_info'])){
				foreach($lrm['state_info'] as $sik => $si){
					// if (isset ( $member_level ) && ! empty ( $condit['member_privilege'] ) && isset ( $si['condition']['member_level'] ) && array_key_exists ( $si['condition']['member_level'], $condit['member_privilege'] )) {
					/*if ($si['external_code'] !== '') {
						$external_code = $params['web_reflect']['member_level'][$si['external_code']];
						$external_code_reflect = $params['web_reflect']['member_price_code'][$external_code];
						$external_code = $params['web_reflect']['member_price_code'][$price_level];
					}*/
					if($si['external_code'] !== ''){
//						$external_code_reflect = $params['web_reflect']['member_level'][$si['external_code']];
						$external_code_reflect = $params['web_reflect']['member_price_code'][$si['external_code']];
					}
//					print_r($si['external_code']);
//					exit($external_code_reflect);
					if(isset ($external_code_reflect)){
						$external_code_arr = explode(',', $external_code_reflect);
						foreach($external_code_arr as $w){
							if(empty($pms_state[$lrm['room_info']['webser_id']][$w])){
								continue;
							}
							
							$tmp = $pms_state[$lrm['room_info']['webser_id']][$w];
							
							$nums = isset ($condit['nums'][$lrm['room_info']['room_id']]) ? $condit['nums'][$lrm['room_info']['room_id']] : 1;
							
							$data[$room_key]['state_info'][$sik]['least_num'] = $tmp['least_num'];
							$data[$room_key]['state_info'][$sik]['book_status'] = $tmp['book_status'];
							
							$data[$room_key]['state_info'][$sik]['extra_info'] = $tmp['extra_info'];
							
							$data[$room_key]['state_info'][$sik]['extra_info']['local_price_name'] = $si['price_name'];
							
							$allprice = '';
							$amount = 0;
							foreach($tmp['date_detail'] as $dk => $td){
								if($si['price_type'] == 'member'){
									$tmp['date_detail'][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
								} else{
									$tmp['date_detail'][$dk]['price'] = $td['price'];
								}
								
								$tmp['date_detail'][$dk]['nums'] = $tmp['least_num'];
								$allprice .= ',' . $tmp['date_detail'][$dk]['price'];
								$amount += $tmp['date_detail'][$dk]['price'];
							}
							$data[$room_key]['state_info'][$sik]['date_detail'] = $tmp['date_detail'];
							$data[$room_key]['state_info'][$sik]['avg_price'] = number_format($amount / $params['countday'], 1);
							$data[$room_key]['state_info'][$sik]['allprice'] = substr($allprice, 1);
							$data[$room_key]['state_info'][$sik]['total'] = intval($amount);
							$data[$room_key]['state_info'][$sik]['total_price'] = $amount * $nums;
							$min_price[] = $data[$room_key]['state_info'][$sik]['avg_price'];
						}
					}
					
				}
				$data[$room_key]['lowest'] = empty ($min_price) ? 0 : min($min_price);
				$data[$room_key]['highest'] = empty ($min_price) ? 0 : max($min_price);
				/*if(!$lrm['show_info']){
					$lrm['show_info'] = $lrm['state_info'];
					$data[$room_key]['show_info'] = $lrm['state_info'];
				}*/
				if(!empty($lrm['show_info'])){
					foreach($lrm['show_info'] as $sik => $si){
						if($si['external_code'] !== ''){
//						$external_code_reflect = $params['web_reflect']['member_level'][$si['external_code']];
							$external_code_reflect = $params['web_reflect']['member_price_code'][$si['external_code']];
						}
						
						if(isset($external_code_reflect)){
							$external_code_arr = explode(',', $external_code_reflect);
							foreach($external_code_arr as $w){
								if(empty($pms_state[$lrm['room_info']['webser_id']][$w])){
									continue;
								}
								$tmp = $pms_state[$lrm['room_info']['webser_id']][$w];
								
								$nums = isset ($condit['nums'][$lrm['room_info']['room_id']]) ? $condit['nums'][$lrm['room_info']['room_id']] : 1;
								$data[$room_key]['show_info'][$sik]['least_num'] = $tmp['least_num'];
								$data[$room_key]['show_info'][$sik]['book_status'] = $tmp['book_status'];
								$allprice = '';
								$amount = 0;
								foreach($tmp['date_detail'] as $dk => $td){
									if($si['price_type'] == 'member'){
										$tmp['date_detail'][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
									} else{
										$tmp['date_detail'][$dk]['price'] = $td['price'];
									}
									
									$tmp['date_detail'][$dk]['nums'] = $data[$room_key]['show_info'][$sik]['least_num'];
									$allprice .= ',' . $tmp['date_detail'][$dk]['price'];
									$amount += $tmp['date_detail'][$dk]['price'];
								}
								$data[$room_key]['show_info'][$sik]['date_detail'] = $tmp['date_detail'];
								
								$data[$room_key]['show_info'][$sik]['avg_price'] = number_format($amount / $params['countday'], 1);
								$data[$room_key]['show_info'][$sik]['allprice'] = substr($allprice, 1);
								$data[$room_key]['show_info'][$sik]['total'] = intval($amount);
								$data[$room_key]['show_info'][$sik]['total_price'] = $data[$room_key]['show_info'][$sik]['total'] * $nums;
							}
						} else{
							unset ($data[$room_key]['show_info'][$sik]);
						}
					}
				}
			}
			
			if(empty ($data[$room_key]['state_info'])){
				unset ($data[$room_key]);
			}
		}
		return $data;
	}
	
	//判断订单是否能支付
	function check_order_canpay($order, $pms_set){
		$this->apiInit($pms_set);
		$web_order = $this->serv_api->getOrder($order['web_orderid'],['orderid'=>$order['orderid']]);
		if($web_order){
			$status_arr = $this->pms_enum('status');
			$status = isset($status_arr[$web_order['Status_code']['code']]) ? $status_arr[$web_order['Status_code']['code']] : -1;
		}
		if(isset($status) && ($status == 1 || $status == 0)){//订单预定或确认
			return true;
		} else{
			return false;
		}
	}
	
	public function apiInit($pms_set){
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		
		$conf = array(
			'inter_id'      => $pms_set['inter_id'],
			'user'          => $pms_auth['user'],
			'pwd'           => $pms_auth['pwd'],
			'url'           => $pms_auth['url'],
			'channel_code'  => $pms_auth['channel_code'],
			'market_code'   => $pms_auth['market_code'],
			'source_code'   => $pms_auth['source_code'],
//			'member_source' => $pms_auth['member_source'],
		);
		$secret = $this->session->userdata($pms_set['inter_id'] . ':secret');
		if($secret){
			$conf['secret'] = $secret;
		}
		$this->load->library('Baseapi/Shijiapi', $conf, 'serv_api');
	}
}