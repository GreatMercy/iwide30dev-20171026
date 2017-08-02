<?php

class Zhongruaniw_hotel_model extends MY_Model{
	private $serv_api;
	
	public function __construct(){
		parent::__construct();
		$this->serv_api = new ZhongruanApi();
	}
	
	public function get_rooms_change($rooms, $idents, $condit, $pms_set = []){
		statistic('A1');
		$this->load->model('common/Webservice_model');
		$web_reflect = $this->Webservice_model->get_web_reflect($idents ['inter_id'], $idents ['hotel_id'], $pms_set ['pms_type'], [
			'web_price_code_set',
		], 1, 'w2l');
		
		$this->load->model('api/Vmember_model','vm');
		$member_level=$this->vm->getLvlPmsCode($condit['openid'],$idents['inter_id']);
		
		$web_price_code = '';
		
		if(!empty ($condit ['price_codes'])){
			$web_price_code = $condit ['price_codes'];
			
			//对接模式是本地价格代码时，读取对应的external_code值【PMS价格代码】
			if($pms_set['pms_room_state_way'] == 3 || $pms_set['pms_room_state_way'] == 4){
				$web_code_arr = [];
				$price_code_list = $this->readDB()->from('hotel_price_info')->select('external_code')->where(['inter_id' => $pms_set['inter_id']])->where_in('price_code', explode(',', $condit['price_codes']))->get()->result_array();
				foreach($price_code_list as $v){
					$web_code_arr[] = $v['external_code'];
				}
				if($web_code_arr){
					$web_price_code = implode(',', $web_code_arr);
				}
			}
		}else{
			if(!empty ($web_reflect ['web_price_code'])){
				foreach($web_reflect ['web_price_code'] as $wpc){
					$web_price_code .= ',' . $wpc;
				}
			}
			$web_price_code .= isset ($web_reflect['member_price_code'] [$member_level]) ? ',' . $web_reflect['member_price_code'][$member_level] : '';
			$web_price_code = substr($web_price_code, 1);
		}
		
		$web_price_code = explode(',', $web_price_code);
		
		$countday = get_room_night($condit['startdate'], $condit['enddate'], 'ceil');
		$web_rids = [];
		foreach($rooms as $r){
			$web_rids [$r ['webser_id']] = $r ['room_id'];
		}
		
		statistic('A2');
		$params = [
			'countday'     => $countday,
			'web_rids'     => $web_rids,
			'condit'       => $condit,
			'web_reflect'  => $web_reflect,
			'idents'       => $idents,
		];
//		$web_price_code = [1, 2, 3, 4];
		/*if($pms_set['pms_room_state_way'] == 3 || $pms_set['pms_room_state_way'] == 4){
			$this->load->model('hotel/Order_model');
			$local_data = $this->Order_model->get_rooms_change($rooms, $idents, $condit);
			$web_price_code = [];
			foreach($local_data as $k => $v){
				if(!empty($v['state_info'])){
					foreach($v['state_info'] as $t){
						$web_price_code[]=$t['external_code'];
					}
				}

			}
		}
		$web_price_code=array_unique($web_price_code);*/
		statistic('A3');
		$pms_data = $this->get_web_roomtype($pms_set, $web_price_code, $condit ['startdate'], $condit ['enddate'], $params);
		statistic('A4');
		$data = [];
		if(!empty ($pms_data)){
			switch($pms_set ['pms_room_state_way']){
				case 1 :
				case 2 :
					$data = $this->get_rooms_change_allpms($pms_data, [
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
		statistic('A5');
		
		$a_b = statistic('A1', 'A2');//查询本地配置
		$b_c = statistic('A2', 'A3');//请求本地房态
		$c_d = statistic('A3', 'A4');//请求PMS实时房态
		$d_e = statistic('A4', 'A5');//与本地房型匹配
		$a_e = statistic('A1', 'A5');//获取房型
		$timer_arr = [
			'查询本地配置'    => $a_b . '秒',
			'与本地房型匹配'   => $b_c . '秒',
			'请求PMS实时房态' => $c_d . '秒',
			'与本地房型匹配'   => $d_e . '秒',
			'获取房型房态总耗时' => $a_e . '秒',
			'执行时间'      => date('Y-m-d H:i:s'),
		];
		pms_logger(func_get_args(), $timer_arr, __METHOD__ . '->query_time', $pms_set['inter_id']);
		return $data;
	}
	
	public function update_web_order($inter_id, $order, $pms_set){
		$this->apiInit($pms_set);
		$web_order = $this->serv_api->queryOrder($order['web_orderid'],$order['tel'],true,['orderid'=>$order['orderid']]);
		$istatus = -1;
		if(!empty($web_order)){
			$status_arr = $this->pms_enum('status');
			$this->load->model('hotel/Order_model');
			$ensure_check=0;
			foreach($order['order_details'] as $od){
				$webs_orderid = $od['webs_orderid'];
				if(!empty($web_order[$webs_orderid])){
					$wb=$web_order[$webs_orderid];
					$istatus=$status_arr[$wb['acct_stus']];
					if($istatus==5&&$od['istatus']==4){
						$istatus=4;
					}
					// 未确认单先确认
					if($istatus != 0 && $order['status'] == 0 && $ensure_check == 0) {
						$this->db->where(array(
							'orderid' => $order['orderid'],
							'inter_id' => $inter_id
						) );
						$this->db->update('hotel_orders', array(
							'status' => 1
						) );
						$this->Order_model->handle_order($inter_id, $order['orderid'], 1, '', array(
							'no_tmpmsg' => 1
						) );
						$ensure_check = 1;
					}
					list($_web_start,$_time)=explode('T',$wb['arr_dt']);
					$web_start=date('Ymd',strtotime($_web_start));
					list($_web_end,$_time)=explode('T',$wb['dpt_dt']);
					$web_end=date('Ymd',strtotime($_web_end));
					$ori_day_diff=get_room_night($web_start,$web_end,'ceil',$od);
					$web_day_diff=get_room_night($web_start,$web_end,'ceil');
					$day_diff = $web_day_diff - $ori_day_diff;
					$updata=[];
					$updata ['startdate'] = $web_start;
					$updata ['enddate'] = $web_end;
					if($day_diff != 0 || $web_start != $od ['startdate'] || $web_end != $od ['enddate']){
						$updata ['no_check_date'] = 1;
					}
					
					if($istatus != $od ['istatus']){
						$updata ['istatus'] = $istatus;
					}
					
					if(!empty ($updata)){
						$this->Order_model->update_order_item($inter_id, $order['orderid'], $od['sub_id'], $updata);
					}
				}
			}
		}
		return $istatus;
	}
	
	public function cancel_order_web($inter_id, $order, $pms_set = []){
		if(empty ($order ['web_orderid'])){
			return [
				's'      => 0,
				'errmsg' => '取消失败'
			];
		}
		$this->apiInit($pms_set);
		
		$res = $this->serv_api->cancelOrder($order['web_orderid'],$order['tel'], '用户取消', ['orderid'=>$order['orderid']]);
		
		if(200==$res['status']&&true===$res['data']){
			
			if($order['paytype'] == 'weixin' && $order['paid'] == 1){
				$this->load->model('hotel/Order_check_model');
				$this->Order_check_model->hotel_weixin_refund($order['orderid'], $inter_id, 'send');
			}
			
			return [                        //取消成功，直接这样return，接下来的程序会继续处理
			                                's'      => 1,
			                                'errmsg' => '取消成功'
			];
		}
		
		return [
			's'      => 0,
			'errmsg' => '取消失败,' . isset($res['data']) ? $res['data'] : '',
		];
		
	}
	
	public function add_web_bill($web_orderid, $order, $pms_set, $trans_no){
		$pms_auth = json_decode($pms_set['pms_auth'], true);
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
		$this->apiInit($pms_set);
		//查询网络订单是否存在
		$web_order = $this->serv_api->queryOrder($web_orderid,$order['tel'],false,['orderid'=>$order['orderid']]);
		
		if(!$web_order){
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
		if($order['paytype']=='weixin'){
			$remark='微信支付【'.$trans_no.'】';
		}elseif($order['paytype']=='balance'){
			$remark='储值支付';
		}
		$result = $this->serv_api->modifyOrder($web_orderid,$order['tel'],$order['price'],$remark,['orderid'=>$order['orderid']]);
		if($result){
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
	
	function order_reserve($order, $pms_set, $params = []){
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$this->apiInit($pms_set);
		
		$starttime = strtotime($order['startdate']);
		$endtime = strtotime($order['enddate']);
		
		$countday=get_room_night($order['startdate'],$order['enddate'],'ceil');
		
		/*if(ceil(($endtime - time()) / 86400) > 30){
			return [
				'result' => 0,
				'errmsg' => '最多可预订未来30天的房',
			];
		}*/
		
		$startdate = date('Y-m-d', $starttime);// . 'T12:00:00';
		$enddate = date('Y-m-d', $endtime);// . 'T12:00:00';
		
		$dates = [];
		for($tmpdate = $order['startdate']; $tmpdate < $order['enddate'];){
			$dates[] = $tmpdate;
			$tmpdate = date('Ymd', strtotime($tmpdate) + 86400);
		}
		
		$room_codes = json_decode($order ['room_codes'], true);
		$room_codes = $room_codes [$order ['first_detail'] ['room_id']]; //$room_codes 结构：array('本地room_id'=>array('room'=>array('webser_id'=>房型代码),'code'=>array($extra_info(就是取房态时的 extra_info),'price_type'=>'价格类型')))
		$extra_info = $room_codes['code']['extra_info'];
		
		$this->load->model('api/Vmember_model','vm');
		$member=$this->vm->getUserInfo($order['openid'],$order['inter_id']);
		
		$remark = '';
		
		$resv_info=new ResvInfo();
		$resv_info->arr_dt=$startdate;
		$resv_info->contact=$order['name'];
		$resv_info->acctnm=$order['name'];
		$resv_info->contact_tel=$order['tel'];
		$resv_info->dpt_dt=$enddate;
		$resv_info->fst_arr_tm=$startdate.'T11:00:00';
		$resv_info->htl_cd=$pms_set['hotel_web_id'];
		if(!empty($member['pms_user_id'])){
			$resv_info->ic_num=$member['membership_number'];
		}
		$resv_info->lst_arr_tm=$startdate.'T18:00:00';
		$resv_info->rm_typ=$room_codes['room']['webser_id'];
		$resv_info->rp_cd=$extra_info['pms_code'];
		$resv_info->channel_cd=$pms_auth['channel_cd'];
		/*$resv_info->comm_amt=$web_rate_row['comm_amt'];
		$resv_info->dcomm_amt=$web_rate_row['dcomm_amt'];
		$resv_info->fxcomm_amt=$web_rate_row['fxcomm_amt'];
		$resv_info->dfxcomm_amt=$web_rate_row['dfxcomm_amt'];*/
		
		/*if($order['inter_id']=='a484191907'){
			$resv_info->rp_cd='ZDY';//临时解决办法，拜登的PMS提交的每日房价与价格代码不一致时，在PMS悠会出问题，只能使用自定义【ZDY】这个价格代码提交订单
		}*/
		
		$favor = empty ( $order ['coupon_favour'] ) ? 0 : floatval ( $order ['coupon_favour'] );
		$favor += empty ( $order ['point_favour'] ) ? 0 : floatval ( $order ['point_favour'] ); // 优惠的总金额
		
		$remark = '微信预订(' . $order['first_detail']['price_code_name'] . ')，PMS价格代码：'.$extra_info['pms_code'].'。';
//		$remark.=',微信订单号：'.$order['orderid'];
		
		if($order['coupon_favour'] > 0){
			$remark .= '使用优惠券：' . $order['coupon_favour'] . '元。';
		}
		if($order['point_favour']>0){
			$remark .= '积分扣减：' . $order['point_favour'] . '元。';
		}
		if($order['paytype']=='daofu'){
			$remark.='支付方式：前台现付。';
		}
		
		$resv_info->remark=$remark;
		
		$comm_arr=[];
		for($i=0;$i<=$countday;$i++){
			$comm_arr[]=0;
		}
		
		$resv_info->Dcomm_amt=implode(',',$comm_arr);
		$resv_info->Dfxcomm_amt=implode(',',$comm_arr);
		
		//PMS的配置值
		$resv_info->acct_typ=$pms_auth['acct_typ'];
		$resv_info->resv_typ=$pms_auth['resv_typ'];
		$resv_info->rmtax_cd=$pms_auth['rmtax_cd'];
		$resv_info->crdt_cd=$pms_auth['crdt_cd'];
		$resv_info->org_cd=$pms_auth['org_cd'];
		$resv_info->market_cd=$pms_auth['market_cd'];
		
		$resv_list=[];
		for($i=0;$i<$order['roomnums'];$i++){
			$resv_list[$i]=clone $resv_info;
			$sub=$order['order_details'][$i];
			$allprice_arr=explode(',',$sub['allprice']);
			$real_arr=explode(',',$sub['real_allprice']);
			$lst_price=end($allprice_arr);
			$real_arr[]=$lst_price;
			$resv_list[$i]->rt_amt=$real_arr[0];
			$resv_list[$i]->everyday_amt=implode(',',$real_arr);
		}
		
		$res=$this->serv_api->submitOrder($resv_list,['orderid'=>$order['orderid']]);
		
		/*$resv_info->everyday_amt=$web_rate_row['drt_amt'];
		$resv_info->rt_amt=$daily_rate[0];

		$resv_info->crdt_cd='';
		$resv_info->acctnm=$order['name'];*/
		
		if(200==$res['status']){
			$sub_list=[];
			foreach($res['data'] as $v){
				$sub_list[]=$v['acctnum'];
			}
			return [
				'result'      => 1,
				'web_orderid' => $res['message'],
				'sub_list'=>$sub_list
			];
		}else{
			return [
				'result' => 0,
				'errmsg' => $res['message'],
			];
		}
	}
	
	public function order_to_web($inter_id, $orderid, $params = [], $pms_set = []){
		$pms_auth=json_decode($pms_set['pms_auth'],true);
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
			//			$pms_set ['pms_auth'] = json_decode($pms_set ['pms_auth'], TRUE);
			//kdkjlksjijkflija diljijkjosjklj
			
			/*
				构造要提交的数据
			*/
			
			$result = $this->order_reserve($order, $pms_set, $params);//提交订单
			
			if($result['result']){
				$web_orderid = $result['web_orderid'];            //取得返回的pms订单id
				$this->db->where([
					'orderid'  => $order ['orderid'],
					'inter_id' => $order ['inter_id']
				]);
				$this->db->update('hotel_order_additions', [
					//更新pms单号到本地
					'web_orderid' => $web_orderid
				]);
				
				for($i = 0; $i < $order['roomnums']; $i++){
					$child = $order['order_details'][$i];
					$this->db->where(['id' => (int)$child['id']])->update('hotel_order_items', ['webs_orderid' => $result['sub_list'][$i]]);
				}
				
				if($order['status'] != 9){
					$this->change_order_status($inter_id, $orderid, 1);
					$this->Order_model->handle_order($inter_id, $orderid, 1); // 若pms的订单是即时确认的，执行确认操作，否则省略这一步
				}
				
				$config_data = $this->Hotel_config_model->get_hotel_config($inter_id, 'HOTEL', $order ['hotel_id'], array(
					'PMS_BANCLANCE_REDUCE_WAY'
				));
				
				if(!empty ($params ['third_no'])){ // 提交账务,如果传入了 trans_no,代表已经支付，调用pms的入账接口
					$this->add_web_bill($web_orderid, $order, $pms_set, $params ['third_no']);
				}
				
				if($order['paytype'] == 'balance'){
					if(!empty ($config_data ['PMS_BANCLANCE_REDUCE_WAY']) && $config_data ['PMS_BANCLANCE_REDUCE_WAY'] == 'after'){
						$this->load->model('hotel/Member_model');
						$balance_param = [
							'crsNo' => $web_orderid,
							'hotel_web_id'=>$pms_set['hotel_web_id'],
						];
						if($this->Member_model->reduce_balance($inter_id, $order['openid'], $order['price'], $order['orderid'], '订房订单余额支付', $balance_param,$order)){
							//调用入账接口
							$this->add_web_bill($web_orderid, $order, $pms_set, $order['orderid']);
							$this->Order_model->update_order_status($inter_id, $order['orderid'], 1, $order['openid'], true);
						}else{
							$this->cancel_order_web($pms_set['inter_id'], $order, $pms_set, '储值支付失败，取消订单');
							$info = $this->Order_model->cancel_order($inter_id, array(
								'only_openid'   => $order ['openid'],
								'member_no'     => '',
								'orderid'       => $order ['orderid'],
								'cancel_status' => 5,
								'no_tmpmsg'     => 1,
								'delete'        => 2,
								'idetail'       => array(
									'i'
								)
							));
							
							return [
								's'      => 0,
								'errmsg' => '储值支付失败！',
							];
						}
					}
				}
				
				return [ // 返回成功
				         's' => 1
				];
			}else{
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
	
	public function get_rooms_change_allpms($pms_state, $rooms, $params){
		$data = array();
		foreach($rooms ['rooms'] as $rm){
			if(!empty ($pms_state ['pms_state'] [$rm ['webser_id']])){
				$data [$rm ['room_id']] ['room_info'] = $rm;
				$data [$rm ['room_id']] ['state_info'] = empty ($pms_state ['valid_state'] [$rm ['webser_id']]) ? array() : $pms_state ['valid_state'] [$rm ['webser_id']];
				$data [$rm ['room_id']] ['show_info'] = $pms_state ['pms_state'] [$rm ['webser_id']];
				$data [$rm ['room_id']] ['lowest'] = min($pms_state ['exprice'] [$rm ['webser_id']]);
				$data [$rm ['room_id']] ['highest'] = max($pms_state ['exprice'] [$rm ['webser_id']]);
			}
		}
		
		return $data;
	}
	
	
	public function get_rooms_change_ratecode($pms_data, $rooms, $params = []){
		$local_rooms = $rooms ['rooms'];
		$this->load->model('hotel/Order_model');
		$data = $this->Order_model->get_rooms_change($local_rooms, $params ['idents'], $params ['condit']);
		
		$pms_state = $pms_data['pms_state'];
		$valid_state = $pms_data['valid_state'];
		$condit=$params['condit'];
		$merge = [
			'least_num',
			'book_status',
			'extra_info',
			'date_detail',
			//			'avg_price',
			//			'allprice',
			//			'total',
			//			'total_price',
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
									}else{
										$tmp[$w][$dk]['price'] = $td['price'];
									}
									$tmp[$w][$dk]['nums'] = $tmp['least_num']<$si['least_num']?$tmp['least_num']:$si['least_num'];
									$allprice .= ',' . $tmp[$w][$dk]['price'];
									$amount += $tmp[$w][$dk]['price'];
								}
								
								$data[$room_key]['state_info'][$sik]['avg_price'] = number_format($amount / $params['countday'], 2);
								$data[$room_key]['state_info'][$sik]['allprice'] = substr($allprice, 1);
								$data[$room_key]['state_info'][$sik]['total'] = intval($amount);
								$data[$room_key]['state_info'][$sik]['total_price'] = $data[$room_key]['state_info'][$sik]['total'] * $nums;
							}
							$data[$room_key]['state_info'][$sik][$w] = $tmp[$w];
						}
					}
					//若PMS库存比本地库存多时，将值改为本地库存
					if($tmp['least_num']>=$si['least_num']){
						$data[$room_key]['state_info'][$sik]['least_num']=$si['least_num'];
					}
					//若本地可预订房量为0时，则房量状态设为满房
					if($si['least_num']<=0){
						$data[$room_key]['state_info'][$sik]['book_status']=$si['book_status'];
					}
					
					$avg_price = str_replace(',', '', $data[$room_key]['state_info'][$sik]['avg_price']);;
					if($avg_price > 0)
						$min_price[] = $avg_price;
//					}
				}
			}
			$data[$room_key]['lowest'] = empty($min_price) ? 0 : min($min_price);
			$data[$room_key]['highest'] = empty($min_price) ? 0 : max($min_price);
			/*if(empty($lrm['show_info'])){
				$lrm['show_info'] = $lrm['state_info'];
				$data[$room_key]['show_info'] = $lrm['state_info'];
			}*/
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
								}else{
									$tmp[$w][$dk]['price'] = $td['price'];
								}
								$tmp[$w][$dk]['nums'] = $tmp['least_num'];
								$allprice .= ',' . $tmp[$w][$dk]['price'];
								$amount += $tmp[$w][$dk]['price'];
							}
							
							$data[$room_key]['show_info'][$sik]['avg_price'] = number_format($amount / $params['countday'], 2);
							$data[$room_key]['show_info'][$sik]['allprice'] = substr($allprice, 1);
							$data[$room_key]['show_info'][$sik]['total'] = intval($amount);
							$data[$room_key]['show_info'][$sik]['total_price'] = $data[$room_key]['show_info'][$sik]['total'] * $nums;
						}
					}
					
					$data[$room_key]['show_info'][$sik][$w] = $tmp[$w];
				}
			}
			if(empty($data[$room_key]['state_info'])){
				unset($data[$room_key]);
			}
		}
		
		return $data;
	}
	
	public function get_web_roomtype($pms_set, $web_price_code, $startdate, $enddate, $params = array()){
		//缓存数据
		$countday=$params['countday'];
		$this->load->helper('common');
		$this->load->library('Cache/Redis_proxy', array(
			'not_init'    => FALSE,
			'module'      => 'common',
			'refresh'     => FALSE,
			'environment' => ENVIRONMENT
		), 'redis_proxy');
		$redis = $this->redis_proxy;
		
		//判断本地缓存中每日都有数据
		$all_exists = true;
		$rk_temp = $pms_set['inter_id'] . ':price_lite:' . $params['idents']['hotel_id'] . ':';
		$sdate = date('Ymd', strtotime($startdate));
		$edate = date('Ymd', strtotime($enddate));
		
		for($start = $sdate; $start < $edate;){
			$rk = $rk_temp . $start;
			if(!$redis->exists($rk)){
				$all_exists = false;
				break;
			}
			$start = date('Ymd', strtotime($start) + 86400);
		}
		
		$web_room_rate=[];
		if(!$all_exists || !empty($params['condit']['recache']) || $this->uri->segment(3) == 'saveorder'){
			if($this->uri->segment(3) != 'saveorder'){
				for($start = $sdate; $start < $edate;){
					$rk = $rk_temp . $start;
					//删除缓存数据，防止接口没有数据返回时，本地仍有缓存
					$redis->del($rk);
					$start = date('Ymd', strtotime($start) + 86400);
				}
			}
			
			$this->apiInit($pms_set);
			$request_price_code = '';
			if(count($web_price_code) == 1){
				$request_price_code = $web_price_code[0];
			}
			$web_rate_result = $this->serv_api->getHotelPrice($pms_set['hotel_web_id'], $startdate, $enddate, $request_price_code, ['hotel_id' => $params['idents']['hotel_id']]);
			$web_room_list = array_keys($params['web_rids']);
			$qty_result = $this->serv_api->getRoomAvl($pms_set['hotel_web_id'], $startdate, $enddate, $web_room_list, ['hotel_id' => $params['idents']['hotel_id']]);
			$web_qty_list = [];
			foreach($qty_result as $v){
				$web_qty_list[$v['rm_list']][] = $v;
			}
			$cache_data = [];
			foreach($web_rate_result as $v){
				if(!array_key_exists($v['rm_cd'], $web_qty_list)){
					continue;
				}
				$daily_price = explode(',', $v['drt_amt']);
				$web_rate_arr = [
					'code' => $v['rpcd'],
					'name' => $v['rpdrpt'],
				];
				
				for($i = 0; $i < $countday; $i++){
					$w = $web_qty_list[$v['rm_cd']][$i];
					
					$daily_list = [
						'price'    => $daily_price[$i],
						'quantity' => $w['day_amt'],
					];
					$cache_data[date('Ymd', strtotime($sdate) + 86400 * $i)][$v['rm_cd']]['name'] = $v['rm_nm'];
					$cache_data[date('Ymd', strtotime($sdate) + 86400 * $i)][$v['rm_cd']]['rates'][$v['rpcd']] = [
						'rate'  => $web_rate_arr,
						'daily' => $daily_list,
					];
				}
			}
			
			
			foreach($cache_data as $k => $v){
				//设置本地缓存
				if($this->uri->segment(3) != 'saveorder'){
					$rk = $rk_temp . $k;
					//保存到redis的数据,将数组的值转为JSON，避免多次循环
					$redis_data = array_map('json_encode', $v);
					$redis->hMset($rk, $redis_data);
					//记录当前KEY获取缓存的数量
					pms_logger([
						$rk,
						$_SERVER['REQUEST_URI']
					], $v, __METHOD__ . '->set_redis', $pms_set['inter_id']);
					$redis->expire($rk, 3600);
				}
				
				//组合
				foreach($v as $web_room => $_row){
					//每个房型的数据
					$web_room_rate[$web_room]['name'] = $_row['name'];
					$web_room_rate[$web_room]['code'] = $web_room;
					if(!empty($_row['rates'])){
						foreach($_row['rates'] as $web_rate => $t){
							if(empty($web_room_rate[$web_room]['rates'][$web_rate])){
								$web_room_rate[$web_room]['rates'][$web_rate] = $t['rate'];
							}
							//每日价格记录
							$daily_rec = $t['daily'];
							$daily_rec['in_date'] = $k;
							$web_room_rate[$web_room]['rates'][$web_rate]['daily'][] = $daily_rec;
						}
					}
				}
			}
		}else{
			//读取本地缓存数据--开始
//			statistic('A');
			for($start = $sdate; $start < $edate;){
				$rk = $rk_temp . $start;
				
				$redis_data = $redis->hGetAll($rk);
				pms_logger([
					$rk,
					$_SERVER['REQUEST_URI']
				], $redis_data, __METHOD__ . '->get_redis', $pms_set['inter_id']);
				if($redis_data){
					foreach($redis_data as $web_room => $v){
						//每个房型的数据
						$_row = json_decode($v, true);
						$web_room_rate[$web_room]['name'] = $_row['name'];
						$web_room_rate[$web_room]['code'] = $web_room;
						if(!empty($_row['rates'])){
							foreach($_row['rates'] as $web_rate => $t){
								if(empty($web_room_rate[$web_room]['rates'][$web_rate])){
									$web_room_rate[$web_room]['rates'][$web_rate] = $t['rate'];
								}
								//每日价格记录
								$daily_rec = $t['daily'];
								$daily_rec['in_date'] = $start;
								$web_room_rate[$web_room]['rates'][$web_rate]['daily'][] = $daily_rec;
							}
						}
					}
				}
				
				$start = date('Ymd', strtotime($start) + 86400);
			}
			//读取本地缓存数据--结束
		}
		
		$pms_state = [];
		$valid_state = [];
		$exprice = [];
		
		if($web_room_rate){
			foreach($web_room_rate as $web_room => $v){
				if(!array_key_exists($web_room, $params['web_rids'])){
					continue;
				}
				$pms_state[$web_room] = [];
				foreach($v['rates'] as $web_rate => $t){
					
					$pms_state[$web_room][$web_rate]['price_name'] = $t['name'];
					$pms_state[$web_room][$web_rate]['price_type'] = 'pms';
					$pms_state[$web_room][$web_rate]['price_code'] = $web_rate;
					$pms_state[$web_room][$web_rate]['extra_info'] = [
						'type'         => 'code',
						'pms_code'     => $web_rate,
					];
					$pms_state[$web_room][$web_rate]['des'] = $t['name'];
					$pms_state[$web_room][$web_rate]['sort'] = 0;
					$pms_state[$web_room][$web_rate]['disp_type'] = 'buy';
					
					$web_set = [];
					if(isset ($params['web_reflect']['web_price_code_set'][$web_rate])){
						$web_set = json_decode($params['web_reflect']['web_price_code_set'][$web_rate], true);
					}
					
					$pms_state[$web_room][$web_rate]['condition'] = $web_set;
					
					if(isset($params['web_rids'][$web_room]) && isset($params['condit']['nums'][$params['web_rids'][$web_room]])){
						$nums = $params['condit']['nums'][$params['web_rids'][$web_room]];
					}else{
						$nums = 1;
					}
					
					$allprice = [];
					$amount = 0;
					
					$least_arr = [3];
					
					$date_status = true;
					
					foreach($t['daily'] as $w){
						if($w['in_date'] < date('Ymd', strtotime($enddate))){
							
							$pms_state[$web_room][$web_rate]['date_detail'][$w['in_date']] = [
								'price' => $w['price'],
								'nums'  => $w['price'] > 0 ? $w['quantity'] : 0,
							];
							
							$allprice[$w['in_date']] = $w['price'];
							$amount += $w['price'];
							$least_arr[] = $w['quantity'];
							
							$date_status = $date_status && $w['quantity'] > 0 && $w['price'] > 0;
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
					
					ksort($allprice);
					$least_count = min($least_arr);
					$least_count > 0 or $least_count = 0;
					
					$pms_state[$web_room][$web_rate]['allprice'] = implode(',', $allprice);
					$pms_state[$web_room][$web_rate]['total'] = $amount;
					$pms_state[$web_room][$web_rate]['related_des'] = '';
					$pms_state[$web_room][$web_rate]['total_price'] = $amount * $nums;
					
					$pms_state[$web_room][$web_rate]['avg_price'] = number_format($amount / $params ['countday'], 2, '.', '');
					$pms_state[$web_room][$web_rate]['price_resource'] = 'webservice';
					
					
					$book_status = 'full';
					if($date_status){
						$book_status = 'available';
					}
					
					$pms_state[$web_room][$web_rate]['book_status'] = $book_status;
					$exprice [$web_room][] = $pms_state[$web_room][$web_rate]['avg_price'];
					
					$pms_state[$web_room][$web_rate]['least_num'] = $least_count;
					$valid_state[$web_room][$web_rate] = $pms_state[$web_room][$web_rate];
					
				}
			}
		}
		
		return [
			'pms_state'   => $pms_state,
			'valid_state' => $valid_state,
			'exprice'     => $exprice,
		];
	}
	
	function pms_enum($type){
		switch($type){
			case 'status' :
				return [
					//订单状态,0预订，1确认，2入住，3离店，4用户取消，5酒店取消,6酒店删除，7异常，8未到，9待支付
					
					'2' => 0,
					'1' => 1,
					'4' => 2,
					'5' => 3,
					'*' => 5,
					'@' => 6,
					'0' => 8,
				];
				break;
			default :
				return [];
				break;
		}
	}
	
	
	function check_order_canpay($order, $pms_set){
		$this->apiInit($pms_set);
		$web_order = $this->serv_api->queryOrder($order['web_orderid'], $order['tel'],false,['orderid'=>$order['orderid']]);
		$check = true;
		if($web_order){
			$status_arr = $this->pms_enum('status');
			foreach($web_order as $v){
				$check = $check && ($status_arr[$web_order['acct_stus']] == 1 || $status_arr[$web_order['acct_stus']] == 0);
			}
//			$status=$web_order['acct_stus'];
		}else{
			$check = false;
		}
		return $check;
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
	
	
	protected function apiInit($pms_set){
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$pms_auth['inter_id'] = $pms_set['inter_id'];
		$this->serv_api->setPMSAuth($pms_auth);
	}
	
	private function readDB(){
		static $db_read;
		if(!$db_read){
			$db_read = $this->load->database('iwide_r1',true);
		}
		return $db_read;
	}
}

class ZhongruanApi{
	private $url;
	private $usercd;
	private $password;
	private $lang = 'CN';
	private $channel_cd;
	private $grpcd;
	private $inter_id;
	private $CI;
	
	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->helper('common');
		$this->CI->load->model('common/Webservice_model');
	}
	
	public function setPMSAuth($params){
		if(!empty($params['url'])){
			$this->url = $params['url'];
		}
		if(!empty($params['usercd'])){
			$this->usercd = $params['usercd'];
		}
		if(!empty($params['password'])){
			$this->password = $params['password'];
		}
		if(!empty($params['lang'])){
			$this->lang = $params['lang'];
		}
		if(!empty($params['channel_cd'])){
			$this->channel_cd = $params['channel_cd'];
		}
		if(!empty($params['grpcd'])){
			$this->grpcd = $params['grpcd'];
		}
		if(!empty($params['inter_id'])){
			$this->inter_id = $params['inter_id'];
		}
	}
	
	public function getHotetList(){
		$params = array(
			'apocalypse' => true,
		);
		$res = $this->httpPost($this->url . 'GetHtlList.aspx', $params);
		return $res['status'] == 200 ? $res['data'] : array();
	}
	
	public function getRooms($hotelId){
		$params = array(
			'htl_cd' => $hotelId,
		);
		$res = $this->httpPost($this->url . 'GetRoomList.aspx', $params);
		if(200 == $res['status']){
			return $res['data'];
		}
		return array();
	}
	
	/**
	 * @param mixed $params
	 *  <code>
	 *  (
	 *  saasacctnum=> Saas酒店系统返回账单号 [optional]
	 *  acctnum=> 预订单帐号 [optional]
	 *  manipulate=> 操作类型（1：新建，2：修改，3：删除）
	 *  acctnm=> 入住人姓名
	 *  contact=> 联系人姓名
	 *  contact_tel=> 联系电话
	 *  careificate_typ=> 证件类型，以客户集团管理软件中定义的类型代码为准
	 *  careificate_num=> 证件号码
	 *  htl_cd=> 酒店代码，以客户集团管理软件中定义的类型代码为准
	 *  rm_typ=> 房类代码，以客户集团管理软件中定义的类型代码为准
	 *  arr_dt=> 来店日期，如：2014-5-1
	 *  dpt_dt=> 离店日期，如：2014-5-4
	 *  rt_amt=> 首日房价
	 *  everyday_amt=> 每日房价，多个金额间逗号隔开，如预订1晚：100,120；2晚：100,120,120  以此类推
	 *  fst_arr_tm=> 最早来店时间，如：2015-5-25 11:00:00
	 *  lst_arr_tm=> 最晚来店时间，如：2015-5-25 15:00:00
	 *  htl_nm=> [optional]
	 *  rm_nm=> [optional]
	 *  acct_stus=> 订单状态（新建预订传2）
	 *  bed_amt=>  加床价
	 *  bed_add=> 加床数
	 *  breakfast_amt=> 加早餐价格
	 *  breakfast_add=> 加早餐数
	 *  room_num=> [optional]
	 *  e_mail=> 电子邮箱. [optional]
	 *  ic_num=> 会员卡号 [optional]
	 *  company_num=> 客户编号 [optional]
	 *  org_dt=> [optional]
	 *  remark=> 备注 [optional]
	 *  people_num=> 入住人数（传入1）
	 *  affirm_typ=> 确认方式：不需确认 0；电话确认 1；邮件确认 2；传真确认 3；短信确认 4
	 *  subscription=> 订金
	 *  deal_subscription=> 应付订金金额 [optional]
	 *  su_tm=> 支付期限（单位小时） [optional]
	 *  service_list=> 代码_01,代码_01,代码_01…… [optional]
	 *  gh_num=> 客史号 [optional]
	 *  fax=> 传真 [optional]
	 *  rp_cd=> 价格代码，以客户集团管理软件中定义的类型代码为准
	 *  channel_cd=> 渠道代码，以客户集团管理软件中定义的类型代码为准
	 *  comm_amt=> 首日佣金
	 *  dcomm_amt=> 每日佣金，多个金额间逗号隔开，如：0,0,0,0
	 *  fxcomm_amt=> 首日分销佣金
	 *  dfxcomm_amt=> 每日分销佣金，多个金额间逗号隔开，如：10,12,12,12
	 *  meal_cnt=> 含早数
	 *  crdt_cd=> 支付方式，以客户集团管理软件中定义的类型代码为准
	 *  trust_num=> 信用卡号码 [optional]
	 *  trust_dt=> 信用卡有效期 [optional]
	 *  geo1=> 国籍（传入CN），以客户集团管理软件中定义的类型代码为准
	 *  htl_typ=> 酒店类型（传入1）
	 *  apply_nums=> 应用数量 [optional]
	 *  apply_id=> 应用id [optional]
	 *  favor_id=> 特价房模板编号 [optional]
	 *  favor_nums=> 特价房使用数量 [optional]
	 *  pay_num=> 网上支付票据号 [optional]
	 *  arr_tm=> 航班到达时间 [optional]
	 *  arr_flt=> 航班号[optional]
	 *  org_cd=> 客源代码，以客户集团管理软件中定义的类型代码为准
	 *  )
	 *  </code>
	 * @param array $func_data
	 * @return mixed
	 */
	
	public function submitOrder($params,$func_data=[]){
		$params = array(
			'ResvInfo' => $params,
		);
		$data = array(
			'resvinfo' => array2xml($params)
		);
		$res = $this->httpPost($this->url . 'AddResvInfo.aspx', $data,$func_data);
		return $res;
	}
	
	public function cancelOrder($web_orderid,$tel,$reason = '',$func_data=[]){
		$params = array(
			'resvnum' => $web_orderid,
			'tel'=>$tel,
			'reason'  => $reason,
		);
		$res = $this->httpPost($this->url . 'CancelResvInfo.aspx', $params,$func_data);
		return $res;
	}
	
	public function getOrderContact($web_orderid, $name,$func_data=[]){
		$params = [
			'resvnum' => $web_orderid,
			'contact' => $name,
		];
		$res = $this->httpPost($this->url, 'GetCheckinHotelInfo.aspx', $params,$func_data);
		if(200 == $res['status']){
			return $res['data'];
		}
		return [];
	}
	
	public function queryOrder($web_orderid, $tel,$keymap=false,$func_data=[]){
		$params = [
			'affirm_typ'  => 9999,
			//			'arr_dt'      => date('Y-m-d', strtotime($start)),
			//			'dpt_dt'      => date('Y-m-d', strtotime($end)),
			'contact_tel' => $tel,
			'resvnum'     => $web_orderid,
		];
		$res = $this->httpPost($this->url. 'GetHistoryResv.aspx', $params,$func_data);
		if(200==$res['status']){
			if(!$keymap){
				return $res['data'];
			}
			$list=[];
			foreach($res['data'] as $v){
				$list[$v['acctnum']]=$v;
			}
			return $list;
		}
		
		return [];
	}
	
	/**
	 * @param $hotel_web_id
	 * @param $startdate
	 * @param $enddate
	 * @param array $webser_id_list
	 * @return array|mixed
	 */
	public function getRoomAvl($hotel_web_id, $startdate, $enddate, $webser_id_list = [],$func_data=[]){
		$params = [
			'arr_dt'   => date('Y-m-d', strtotime($startdate)),
			'dpt_dt'   => date('Y-m-d', strtotime($enddate)),
			'htl_ip'   => '',
			'htl_port' => 0,
			'htl_cd'   => $hotel_web_id,
			'rm_list'  => implode(',', $webser_id_list),
		];
		$res = $this->httpPost($this->url . 'GetRoomAvl.aspx', $params,$func_data);
//		return $res;
		
		if($res['status'] == 200){
			return $res['data'];
		}
		return array();
	}
	
	/**
	 * @param $params
	 *  <code>
	 *  array(                                                                                             `
	 *  arr_dt=>入住日期
	 *  dpt_dt=>离店日期
	 *  channel_cd=>销售渠道代码
	 *  htl_cd=>酒店代码 (以客户集团管理软件中定义的类型代码为准)
	 *  rp_cd=>价格代码
	 *  )
	 *  </code>
	 * @return array
	 */
	public function getPriceLite($hotel_web_id, $startdate, $enddate, $rate_list = [],$func_data=[]){
		$params = [
			'arr_dt'  => date('Y-m-d', strtotime($startdate)),
			'dpt_dt'  => date('Y-m-d', strtotime($enddate)),
			'htl_cls' => 99,
			'htl_cd'  => $hotel_web_id,
		];
		$result = [];
		foreach($rate_list as $v){
			$params['rp_cd'] = $v;
			$res = $this->httpPost($this->url . 'GetPriceLite.aspx', $params,$func_data);
			if(200 == $res['status']){
				$res['data'] = rtrim($res['data'], ';');
				$pl_arr = explode(';', $res['data']);
				foreach($pl_arr as $t){
					$arr = explode(',', $t);
					$result[$arr[0]][$v] = $arr[1];
				}
			}
		}
		return $result;
	}
	
	public function getHotel($hotel_web_id, $startdate, $enddate, $rate_list = [],$func_data=[]){
		$params = [
			'arr_dt'  => date('Y-m-d', strtotime($startdate)),
			'dpt_dt'  => date('Y-m-d', strtotime($enddate)),
			'htl_cls' => 99,
			'htl_cd'  => $hotel_web_id,
		];
		$result = [];
		foreach($rate_list as $v){
			$params['rp_cd'] = $v;
			$res = $this->httpPost($this->url . 'GetHotels.aspx', $params);
			if(200 == $res['status']){
				foreach($res['data'] as $t){
					if(!empty($t['rm_list'])){
						foreach($t['rm_list'] as $w){
							$w['rp_cd']=$t['rp_cd'];
							$w['rp_nm']=$t['rp_nm'];
							$result[$w['rm_cd']][$v]=$w;
						}
					}
				}
			}
		}
		
		return $result;
	}
	
	public function modifyOrder($web_orderid,$tel,$subscription,$remark,$func_data=[]){
		$params=[
			'resvnum'=>$web_orderid,
			'contact_tel'=>$tel,
			'subscription'=>(float)$subscription,
		];
		if($remark){
			$params['remark']=$remark;
		}
		$res=$this->httpPost($this->url.'ModResvInfo.aspx',$params,$func_data);
		return $res;
	}
	
	public function getHotelPrice($hotel_web_id, $startdate, $enddate, $web_rate = '',$func_data=[]){
		$params = [
			'arr_dt'  => date('Y-m-d', strtotime($startdate)),
			'dpt_dt'  => date('Y-m-d', strtotime($enddate)),
			'htl_cls' => 99,
			'htl_cd'  => $hotel_web_id,
			'rp_cd'   => $web_rate
		];
		
		$res = $this->httpPost($this->url . 'GetPriceToHuiYun.aspx', $params,$func_data);
		$result=[];
		if($res['status']==200&&!empty($res['data'])){
			foreach($res['data'] as $v){
				if($v['htlcd']==$hotel_web_id){
					/*if(!empty($v['rm_list'])){
						foreach($v['rm_list'] as $t){
							$result[$t['rm_cd']][$t['rpcd']]=$t;
						}
					}*/
					$result = $v['rm_list'];
					break;
				}
			}
		}
		return $result;
	}
	
	protected function commonField(){
		return array(
			'usercd'     => $this->usercd,
			'password'   => $this->password,
			'lang'       => $this->lang,
			'channel_cd' => $this->channel_cd,
			'grpcd'      => $this->grpcd,
		);
	}
	
	private function httpPost($url, $curl_array,$func_data=[]){
		$time=time();
		$curl_array = array_merge($this->commonField(), $curl_array);
		$query_str = http_build_query($curl_array);
		$res = doCurlPostRequest($url,$query_str,[],15);
		$this->CI->Webservice_model->add_webservice_record($this->inter_id,'zhongruaniw',$url,$curl_array,$res,'query_post',$time,microtime(),$this->CI->session->userdata($this->inter_id.'openid'));
		$s=$res;
		$res = json_decode($res, true);
		
		$run_alarm = 0;
		
		$func=substr($url,strrpos($url,'/'));
		$func=substr($func,0,strpos($func,'.')+1);
		
		$this->checkWebResult($func, $curl_array, $s, $time, microtime(),$func_data, ['run_alarm' => $run_alarm]);
		
		return $res;
	}
	
	protected function checkWebResult($func_name, $send, $receive, $now, $micro_time,$func_data=[], $params = []){
		$func_name_des = $this->pms_enum('func_name', $func_name);
		isset ($func_name_des) or $func_name_des = $func_name; // 方法名描述\
		$err_msg = ''; // 错误提示信息
		$err_lv = NULL; // 错误级别，1报警，2警告
		$alarm_wait_time = 5; // 默认超时时间
		if(!empty($params['run_alarm'])){ // 程序运行报错，直接报警
			$err_msg = '程序报错,' . json_encode($receive, JSON_UNESCAPED_UNICODE);
			$err_lv = 1;
		}else{
			$res=json_decode($receive);
			if(!is_array($res)||!$res){
				$err_lv=1;
				$err_msg='接口错误：'.$receive;
			}else{
				switch($func_name){ // 针对不同方法判断是否出错
					case 'getPriceLite':
					case 'GetHotels':
					case 'GetRoomAvl':
					case 'GetHistoryResv':
					case 'GetCheckinHotelInfo':
					case 'GetPriceToHuiYun':
						if($res['status']!=200){
							$err_msg=$res['message'];
							$err_lv=2;
						}elseif(empty($res['data'])){
							$err_msg='空数据';
							$err_lv=2;
						}
						break;
					case 'AddResvInfo':
					case 'CancelResvInfo':
					case 'ModResvInfo':
						if($res['status']!=200){
							$err_msg=$res['message'];
							$err_lv=1;
						}
						break;
				}
				
			}
		}
		
		$this->CI->Webservice_model->webservice_error_log( $this->inter_id, 'zhongruaniw', $err_lv, $err_msg, array (
			'web_path' => $this->url,
			'send' => $send,
			'receive' => $receive,
			'send_time' => $now,
			'receive_time' => $micro_time,
			'fun_name' => $func_name_des,
			'alarm_wait_time' => $alarm_wait_time
		), $func_data );
	}
	
	private function pms_enum($type = '', $key = ''){
		$arr = [];
		switch($type){
			case 'func_name':
				$arr = [
					'getPriceLite' => '获取房价',
					'GetHotels' => '获取房价',
					'GetRoomAvl'=>'获取房量',
					'GetPriceToHuiYun'=>'获取房价',
					'AddResvInfo'=>'新增订单',
					'GetHistoryResv'=>'查询订单',
					'CancelResvInfo'=>'取消订单',
					'ModResvInfo'=>'修改订单',
				];
				break;
		}
		if($key === ''){
			return $arr;
		}
		return isset($arr[$key]) ? $arr[$key] : null;
	}
}

class ResvInfo{
	public $acct_stus = 2;   //订单状态（新建预订传2） 必输域
	public $affirm_typ = 0;   //确认方式：不需确认 0；电话确认 1；邮件确认 2；传真确认 3；短信确认 4 必输域
	public $arr_dt;         //来店日期，如：2014-5-1 必输域
	public $dpt_dt; //离店日期 必填
	public $bed_add = 0;   //加床数 必输域
	public $bed_amt = 0;   //加床价 必输域
	public $breakfast_add = 0; //加早餐价格 必填
	public $breakfast_amt = 0;   //加早餐数 必填
	public $careificate_num = ''; //证件号码 必填
	public $careificate_typ = ''; //证件类型 必填
	public $contact; //联系人姓名 必填
	public $contact_tel; //联系电话 必填
	public $everyday_amt; //每日房价，多个金额间逗号隔开，如预订1晚：100,120；2晚：100,120,120  以此类推 必填
	public $fst_arr_tm; //最早来店时间，如：2015-5-25 11:00:00 必填
	public $lst_arr_tm; //最晚来店时间，如：2015-5-25 15:00:00 必填
	public $htl_cd; //酒店代码，以客户集团管理软件中定义的类型代码为准 必填
	public $manipulate = 1;  //操作类型（1：新建，2：修改，3：删除） 必填
	public $people_num = 1; //入住人数（传入1） 必填
	public $rm_typ; //房类代码，以客户集团管理软件中定义的类型代码为 必填
	public $rt_amt; //首日房价 必填
	public $subscription = 0; //订金 必填
	public $rp_cd; //价格代码，以客户集团管理软件中定义的类型代码为准 必填
	public $channel_cd; //渠道代码，以客户集团管理软件中定义的类型代码为准 必填
	public $comm_amt = 0; //首日佣金 必填
	public $Dcomm_amt = ''; //每日佣金，多个金额间逗号隔开，如：0,0,0,0 必填
	public $Fxcomm_amt = 0; //首日分销佣金 必填
	public $Dfxcomm_amt = ''; //每日分销佣金，多个金额间逗号隔开，如：10,12,12,12 必填
	public $Meal_cnt = 0; //含早数 必填
	public $crdt_cd;  //支付方式，以客户集团管理软件中定义的类型代码为准 必填
	public $geo1 = 'CN'; //国籍（传入CN），以客户集团管理软件中定义的类型代码为准 必填
	public $htl_typ = 2;  //酒店类型（传入2） 必填
	public $acct_typ;   //	账户类型，以客户集团管理软件中定义的类型代码为准 必填
	public $resv_typ;   //预订类型，以客户集团管理软件中定义的类型代码为准 必填
	public $rmtax_cd;  //房税结构类型，以客户集团管理软件中定义的类型代码为准 必填
	public $acctnm; //入住人姓名 必填
	public $ic_num = ''; //会员卡号
	public $remark = ''; //备注
	public $org_cd;   //客源代码，以客户集团管理软件中定义的类型代码为准
	public $market_cd;  //市场代码，以客户集团管理软件中定义的类型代码为准


//	public $e_mail; //电子邮箱
//	public $service_list; //代码_01,代码_01,代码_01……
//	public $gh_num;  //客史号
//	public $fax; //传真
//	public $trust_num; //信用卡号码
//	public $trust_dt; //信用卡有效期
//	public $apply_nums;  //应用数量                       ``
//	public $apply_id; //应用id
//	public $company_num;  //客户编号
//	public $favor_id;   //特价房模板编号
//	public $favor_nums; //特价房使用数量
//	public $pay_num;   //网上支付票据号
//	public $arr_tm;    //航班到达时间
//	public $deal_subscription;   //应付订金金额
//	public $su_tm;      //支付期限（单位小时）
//	public $saasacctnum; //SAAS酒店账号


//	public $acctnum = '';
//	public $htl_nm = '';
//	public $rm_nm = '';
//	public $resvnum = '';
//	public $arr_flt = '';
//	public $room_num = 0;
//	public $org_dt = '0001-01-01';
//	public $coupon_amt = 0.0; // 新加属性
}