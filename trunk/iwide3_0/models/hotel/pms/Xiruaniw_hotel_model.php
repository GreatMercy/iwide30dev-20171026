<?php

class Xiruaniw_hotel_model extends MY_Model{
	const INVOICE_DOMAIN = 'http://www.aisinogz.com:10176/';//发票接口测试域名
	public function __construct(){
		parent::__construct();
		$this->load->helper('common');
		$this->load->library('MYLOG');
	}
	
	public function get_rooms_change($rooms, $idents, $condit, $pms_set = []){
		statistic('A1');
		$this->load->model('common/Webservice_model');
		$web_reflect = $this->Webservice_model->get_web_reflect($idents ['inter_id'], $idents ['hotel_id'], $pms_set ['pms_type'], [
			'web_price_code_set',
			//			'rate_to_point',
			//			'point_rate_related',
			//			'point_rate_code',
		], 1, 'w2l');
		
		$this->load->model('api/Vmember_model', 'vm');
		$member_level = $this->vm->getLvlPmsCode($condit['openid'], $idents['inter_id']);
		
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
			$web_price_code .= isset ($web_reflect ['member_price_code'] [$member_level]) ? ',' . $web_reflect ['member_price_code'] [$member_level] : '';
			$web_price_code = substr($web_price_code, 1);
		}
		$web_price_code = explode(',', $web_price_code);
		$countday = get_room_night($condit['startdate'], $condit['enddate'], 'ceil');
		$web_rids = [];
		foreach($rooms as $r){
			$web_rids [$r ['webser_id']] = $r ['room_id'];
		}
		
		//是否积分房
		$point_rate_code = '';
		if(!empty($web_reflect['point_rate_code'])){
			foreach($web_reflect['point_rate_code'] as $v){
				$point_rate_code .= ',' . $v;
			}
			$point_rate_code = substr($point_rate_code, 1);
		}
		$point_rate_code = explode(',', $point_rate_code);
		
		statistic('A2');
		$params = [
			'countday'        => $countday,
			'web_rids'        => $web_rids,
			'condit'          => $condit,
			'web_reflect'     => $web_reflect,
			'member_level'    => $member_level,
			'idents'          => $idents,
			'point_rate_code' => $point_rate_code,
		];
		//		$web_price_code = [1, 2, 3, 4];
		
		$pms_data = $this->get_web_roomtype($pms_set, $web_price_code, $condit ['startdate'], $condit ['enddate'], $params);
		statistic('A3');
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
	
	public function get_rooms_change_ratecode($pms_data, $rooms, $params){
		$local_rooms = $rooms['rooms'];
		$condit = $params['condit'];
		$this->load->model('hotel/Order_model');
		$data = $this->Order_model->get_rooms_change($local_rooms, $params['idents'], $params['condit']);
		$pms_state = $pms_data['pms_state'];
		$valid_state = $pms_data['valid_state'];
		
		$merge = [
			'des',
			'price_name',
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
			
			$nums = isset($condit['nums'][$lrm['room_info']['room_id']]) ? $condit['nums'][$lrm['room_info']['room_id']] : 1;
			
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
								$closed = false;
								foreach($tmp[$w] as $dk => $td){
									$closed = $closed || $td['price'] == -1;
									if($si['related_cal_way'] && $si['related_cal_value']){
										$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
									}else{
										$tmp[$w][$dk]['price'] = $td['price'];
									}
									$tmp[$w][$dk]['nums'] = $tmp['least_num'];
									$allprice .= ',' . $tmp[$w][$dk]['price'];
									$amount += $tmp[$w][$dk]['price'];
								}
								if($closed){
									$amount=-1*$params['countday'];
								}
								
								$data[$room_key]['state_info'][$sik]['avg_price'] = number_format($amount / $params['countday'], 2);
								$data[$room_key]['state_info'][$sik]['allprice'] = substr($allprice, 1);
								$data[$room_key]['state_info'][$sik]['total'] = intval($amount);
								$data[$room_key]['state_info'][$sik]['total_price'] = $data[$room_key]['state_info'][$sik]['total'] * $nums;
							}
							$data[$room_key]['state_info'][$sik][$w] = $tmp[$w];
						}
					}
					$avg_price = str_replace(',', '', $data[$room_key]['state_info'][$sik]['avg_price']);;
					if($avg_price >= 0)
						$min_price[] = $avg_price;
//					}
				}
			}
			$data[$room_key]['lowest'] = empty($min_price) ? -1 : min($min_price);
			
			$data[$room_key]['highest'] = empty($min_price) ? -1 : max($min_price);
			/*if(empty($lrm['show_info'])){
				$lrm['show_info'] = $lrm['state_info'];
				$data[$room_key]['show_info'] = $lrm['state_info'];
			}*/
			foreach($lrm['show_info'] as $sik => $si){
				//需要设置PMS价格代码值
				$web_rate = $si['external_code'];
				if($web_rate === '' || empty($pms_state[$lrm['room_info']['webser_id']][$web_rate])){//PMS上不存在该价格代码
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
							$closed = false;
							foreach($tmp[$w] as $dk => $td){
								$closed = $closed || $td['price'] == -1;
								if($si['related_cal_way'] && $si['related_cal_value']){
									$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
								}else{
									$tmp[$w][$dk]['price'] = $td['price'];
								}
								$tmp[$w][$dk]['nums'] = $tmp['least_num'];
								$allprice .= ',' . $tmp[$w][$dk]['price'];
								$amount += $tmp[$w][$dk]['price'];
							}
							
							if($closed){
								$amount=-1*$params['countday'];
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
//		echo '<pre>';print_r($data);exit;
		
		
		return $data;
	}
	
	public function update_web_order($inter_id, $order, $pms_set){
		$this->apiInit($pms_set);
		$web_order = $this->serv_api->queryOrder($order['web_orderid'],['orderid'=>$order['orderid']]);
		$istatus = -1;
		if(!empty ($web_order)){
			$status_arr = $this->pms_enum('status');
			$main_order = $web_order['main'];
			
			$sub_order = $web_order['sub'];
			
			$this->load->model('hotel/Order_model');
			
			$status = $status_arr [$main_order['sta']];
			
			// 未确认单先确认
			if($status != 0 && $order ['status'] == 0){
				$this->change_order_status($inter_id, $order['orderid'], 1);
				$this->Order_model->handle_order($inter_id, $order ['orderid'], 1, '', [
					'no_tmpmsg' => 1
				]);
			}
			
			//如果子订单没有数据，则表示还没有分房，直接操作主订单
			if(empty($sub_order)){
				if($order ['status'] == 4 && $status == 5){
					$status = 4;
				}
				
				$this->change_order_status($inter_id, $order['orderid'], $status);
				
				$this->Order_model->handle_order($inter_id, $order ['orderid'], $status);
				
				$istatus = $status;
			}else{
				//存在子订单，则操作子订单状态
				$local_exists = [];  //已更新至本地的子订单号
				$local_noexists = []; //还没有更新
				
				foreach($order ['order_details'] as $od){
					if(!empty($od['webs_orderid'])){
						$local_exists[$od['webs_orderid']] = $od;
					}else{
						$local_noexists[] = $od;
					}
				}
				$i = 0;
				foreach($sub_order as $v){
					$updata = [];
					if(array_key_exists($v['accnt'], $local_exists)){
						//该子订单号已保存至本地
						$od = $local_exists[$v['accnt']];
					}else{
						//还没有更新至本地子订单号
						$od = $local_noexists[$i];
						
						$this->db->where(['id' => (int)$od['sub_id']])->update('hotel_order_items', ['webs_orderid' => $v['accnt']]);
						
						$i++;
					}
					
					if($v['sta']=='H'){
						continue;
					}
					
					$istatus = $status_arr[$v['sta']];
					if($od ['istatus'] == 4 && $istatus == 5){
						$istatus = 4;
					}
					
					
					//PMS上的入住，离店时间
					$web_start = date('Ymd', strtotime($v['arr']));
					$web_end = date('Ymd', strtotime($v['dep']));
					$web_end = $web_end == $web_start ? date('Ymd', strtotime('+ 1 day', strtotime($web_start))) : $web_end;
					
					//判断实际入住时间，订单记录的入住时间
					$ori_day_diff = get_room_night($od['startdate'], $od['enddate'], 'ceil', $od);//至少有一个间夜
					$web_day_diff = get_room_night($web_start, $web_end, 'ceil');//至少有一个间夜
					$day_diff = $web_day_diff - $ori_day_diff;
					
					$updata ['startdate'] = $web_start;
					$updata ['enddate'] = $web_end;
					if($day_diff != 0 || $web_start != $od ['startdate'] || $web_end != $od ['enddate']){
						$updata ['no_check_date'] = 1;
					}
					
					//重新计算总价价
					$new_price = $v['paymoney'];
					
					$ori_total = array_sum(explode(',', $od['allprice'])); //本地记录的不含优惠总价
					$old_total = array_sum(explode(',', $od['real_allprice'])); //下单时的金额
					$discount_price = $ori_total - $old_total;  //优惠的价格
					$new_price -= $discount_price;
					if($new_price >= 0 && $od['iprice'] != $new_price){
						$updata ['no_check_date'] = 1;
						$updata['new_price'] = $new_price;
					}
					
					if($istatus != $od['istatus']){
						$updata ['istatus'] = $istatus;
					}
					
					if(!empty ($updata)){
						$this->Order_model->update_order_item($inter_id, $order ['orderid'], $od ['sub_id'], $updata);
					}
				}
				
				//判断未处理完的子订单
				/*$count1=count($local_noexists);
				if($i<$count1){
					$_tal=$count1-$i;
					for($j=0;$j<$_tal;$j++){
						$updata = [];
						$od=$local_noexists[$j];
						
						$istatus = 5;
						
						if($od ['istatus'] == 4 && $istatus == 5){
							$istatus = 4;
						}
						
						if($istatus != $od['istatus']){
							$updata ['istatus'] = $istatus;
						}
						
						if(!empty ($updata)){
							$this->Order_model->update_order_item($inter_id, $order ['orderid'], $od ['sub_id'], $updata);
						}
					}
					
				}*/
				
			}
		}
		return $istatus;
	}
	
	function pms_enum($type){
		switch($type){
			case 'status' :
				return [
					//订单状态,0预订，1确认，2入住，3离店，4用户取消，5酒店取消,6酒店删除，7异常，8未到，9待支付
					
					'Q' => 0,
					'R' => 1,
					'I' => 2,
					'O' => 3,
					'D' => 3,
					//					'H' => 3,
					'X' => 5,
					'N' => 8,
					'S' => 3,
				];
				break;
			default :
				return [];
				break;
		}
	}
	
	public function cancel_order_web($inter_id, $order, $pms_set = []){
		if(empty ($order ['web_orderid'])){
			return [
				's'      => 0,
				'errmsg' => '取消失败'
			];
		}
		$this->apiInit($pms_set);
		
		$res = $this->serv_api->cancelOrder($pms_set['hotel_web_id'], $order['web_orderid'], '用户取消', 'T',['orderid'=>$order['orderid']]);
		
		if(!empty($res['success'])){
			
			if($order['paytype'] == 'weixin' && $order['paid'] == 1){
				$this->load->model('hotel/Order_check_model');
				$this->Order_check_model->hotel_weixin_refund($order['orderid'], $inter_id, 'send');
			}
			
			//恒大酒店取消后调用短信接口
			if($inter_id=='a468919145'){
				$params=[
					$order['name'],
					$order['web_orderid'],
				];
				if($this->uri->segment(3) == 'deal_order_queues'){
					//未支付订单超时自动取消
					$type='auto_cancel';
				}else{
					//人工取消【包括会员，酒店】
					$type='cus_cancel';
				}
				$this->sendSMS($order['tel'],$type,$params,$inter_id);
			}
			
			return [                        //取消成功，直接这样return，接下来的程序会继续处理
			                                's'      => 1,
			                                'errmsg' => '取消成功'
			];
		}
		
		return [
			's'      => 0,
			'errmsg' => '取消失败,' . isset($res['msg']) ? $res['msg'] : '',
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
	
	
	function order_reserve($order, $pms_set, $params = []){
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$this->apiInit($pms_set);
		
		$starttime = strtotime($order['startdate']);
		$endtime = strtotime($order['enddate']);
		
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
			$tmpdate = date('Ymd', strtotime('+ 1 day', strtotime($tmpdate)));
		}
		
		$room_codes = json_decode($order ['room_codes'], true);
		$room_codes = $room_codes [$order ['first_detail'] ['room_id']]; //$room_codes 结构：array('本地room_id'=>array('room'=>array('webser_id'=>房型代码),'code'=>array($extra_info(就是取房态时的 extra_info),'price_type'=>'价格类型')))
		$extra_info = $room_codes['code']['extra_info'];
		
		$member = $this->vm->getUserInfo($order['openid'], $order['inter_id']);
		
		$remark = '';
		
		$room_count = $order['roomnums'];
		if($order['coupon_favour'] > 0){
			$remark .= '使用优惠券：' . $order ['coupon_favour'] . '元。';
			$coupon_arr = [];
			$coupon_des = json_decode($order['coupon_des'], true);
			if(array_key_exists('cash_token', $coupon_des)){
				$coupon_count = count($coupon_des['cash_token']);
				for($i = 0; $i < $coupon_count; $i++){
					$t = $coupon_des['cash_token'][$i];
					//将券分到每间房的记录，
					$coupon_arr[($i + 1) % $room_count][] = [
						'code'   => $t['code'],
						'amount' => $t['amount'],
					];
				}
			}
			
			//使用券的备注
			$rn = 0;
			foreach($coupon_arr as $v){
				//每间房的优惠信息
				$rn++;
				$tc = count($v);
				$remark .= '房间' . $rn . '【';
				for($i = 0; $i < $tc; $i++){
					$t = $v[$i];
					$remark .= date('Y-m-d', strtotime($dates[$i])) . '：使用券（' . $t['code'] . '）优惠' . $t['amount'] . '元|';
				}
				$remark .= '】';
			}
		}
		if($order['point_favour'] > 0){
			$remark .= '积分扣减：' . $order['point_favour'] . '元。';
		}
		
		$daily_price = explode(',', $order ['first_detail'] ['allprice']);
		
		$order_params = [
			'ratecode' => $extra_info['pms_code'],
			'rmtype'   => $room_codes['room']['webser_id'],
			'rmnum'    => $order['roomnums'],
			'rate'     => $daily_price[0],
			'hotelid'  => $pms_set['hotel_web_id'],
			'name'     => $order['name'],
			'mobile'   => $order['tel'],
			'arr'      => $startdate,
			'dep'      => $enddate,
			'gstno'    => 1,
			'cardno'   => $member ? $member['pms_user_id'] : null,
			'ref'      => $remark,
			//			'coupon'   => $coupon,  //优惠券
			//			'dicount'  => $discount,
			'crsno'    => $order['orderid'],
			'restype'  => $pms_auth['restype']['normal'],
		];
		
		switch($order['paytype']){
			case 'weixin':
				$order_params['payment'] = '微信支付';
//				$order_params['restype'] = $pms_auth['restype']['paid'];
				break;
			case 'balance':
				$order_params['payment'] = '储值支付';
//				$order_params['restype'] = $pms_auth['restype']['paid'];
				break;
		}
		
		$result = $this->serv_api->saveOrder($order_params,['orderid'=>$order['orderid']]);
		
		if(!empty($result['success'])){
			return [
				'result'      => 1,
				'web_orderid' => $result['results']['rsvno'],
			];
		}else{
			return [
				'result' => 0,
				'errmsg' => isset($result['msg']) ? $result['msg'] : '',
			];
		}
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
		$web_order = $this->serv_api->queryOrder($order['web_orderid'],['orderid'=>$order['orderid']]);
		
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
		$payment = [
			'rsvno'     => $web_orderid,
			'pay_money' => $order['price'],
			'pay_code'  => isset($pms_auth['pay_code'][$order['paytype']]) ? $pms_auth['pay_code'][$order['paytype']] : '0000',
			'payno'     => $trans_no,
			'remark'    => '订单预付：' . $web_orderid,
			'hotelid'   => $web_order['main']['hotelid']
		];
		$result = $this->serv_api->addPayment($payment,['orderid'=>$order['orderid']]);
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
				$this->db->update('hotel_order_additions', [        //更新pms单号到本地
				                                                    'web_orderid' => $web_orderid
				]);
				
				if($order['status'] != 9){
					$this->change_order_status($inter_id, $orderid, 1);
					$this->Order_model->handle_order($inter_id, $orderid, 1); // 若pms的订单是即时确认的，执行确认操作，否则省略这一步
				}
				
				if(!empty ($params ['third_no'])){ // 提交账务,如果传入了 trans_no,代表已经支付，调用pms的入账接口
					$this->add_web_bill($web_orderid, $order, $pms_set, $params ['third_no']);
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
	
	private function get_rooms_change_allpms($pms_state, $rooms, $params){
		$data = [];
		foreach($rooms['rooms'] as $rm){
			if(!empty ($pms_state['pms_state'][$rm['webser_id']])){
				$data[$rm['room_id']]['room_info'] = $rm;
				$data[$rm['room_id']]['state_info'] = empty ($pms_state['valid_state'][$rm['webser_id']]) ? [] : $pms_state['valid_state'][$rm['webser_id']];
				$data[$rm['room_id']]['show_info'] = $pms_state['pms_state'][$rm['webser_id']];
				$data[$rm['room_id']]['lowest'] = empty($pms_state['exprice'][$rm['webser_id']]) ? -1 : min($pms_state['exprice'][$rm['webser_id']]);
				$data[$rm['room_id']]['highest'] = empty($pms_state['exprice'][$rm['webser_id']]) ? -1 : max($pms_state['exprice'][$rm['webser_id']]);
			}
		}
		
		return $data;
	}
	
	public function get_web_roomtype($pms_set, $web_price_code, $startdate, $enddate, $params){
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$this->apiInit($pms_set);
		
		if(count($params['web_rids']) == 1){
			$web_room_arr = array_keys($params['web_rids']);
			$web_room = $web_room_arr[0];
		}else{
			$web_room = null;
		}
		
		if(count($web_price_code) == 1){
			$web_rate = $web_price_code[0];
			
			
			if(!empty($params['point_rate_code']) && in_array($web_rate, $params['point_rate_code']) && !empty($params['web_reflect']['rate_to_point'])){
				$tmp = $params['web_reflect']['rate_to_point'];
				$web_rate = current($tmp);
			}
			
		}else{
			$web_rate = null;
		}
		
		$func_data=['hotel_id'=>$params['idents']['hotel_id']];
		$qty_result = $this->serv_api->getRoomQty($pms_set['hotel_web_id'], $startdate, $enddate, $web_room, $web_rate,$func_data);
		$daily_result = $this->serv_api->getRoomDailyPrice($pms_set['hotel_web_id'], $startdate, $enddate, $web_room, $web_rate,$func_data);
		
		//房量
		$web_room_qty = [];
		foreach($qty_result as $v){
			$web_room_qty[$v['rmtype']][date('Ymd', strtotime($v['date']))] = $v['avail'];
		}
		
		$countday = $params['countday'];
		
		//每日房价
		$web_room_rate = [];
		foreach($daily_result as $v){
			$in_data = date('Ymd', strtotime($v['date']));
			$v['in_date'] = $in_data;
			$v['avail'] = isset($web_room_qty[$v['rmtype']][$in_data]) ? $web_room_qty[$v['rmtype']][$in_data] : 0;
			
			if(!empty($params['web_reflect']['rate_to_point'])&&!empty($params['point_rate_code']) && in_array($v['ratecode'], $params['point_rate_code'])){
				$v['is_point_rate'] = true;
				$rate_to_point=end($params['web_reflect']['rate_to_point']);
				foreach($daily_result as $t){
					if($t['rmtype']==$v['rmtype']&&$t['ratecode']==$rate_to_point&&$v['date']==$t['date']){
						$v['rate']=$t['rate'];
						break;
					}
				}
			}
			if(!$v['rate']){
				continue;
			}
			
			$web_room_rate[$v['rmtype']][$v['ratecode']][] = $v;
			//判断该价格是否用于计算积分价格
			/*if($countday == 1 && !empty($params['web_reflect']['rate_to_point']) && in_array($v['ratecode'], $params['web_reflect']['rate_to_point'])){
				if(!empty($params['web_reflect']['point_rate_related'][$pms_auth['mode']])){
					$point_rate = $params['web_reflect']['point_rate_related'][$pms_auth['mode']];
					$v['ratecode'] = $point_rate;
					$v['is_point_rate'] = true;
					$web_room_rate[$v['rmtype']][$v['ratecode']][] = $v;
				}
			}*/
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
				foreach($v as $web_rate => $t){
					$row = $t[0];
					
					$pms_state[$web_room][$web_rate]['price_name'] = $row['descript'];
					$pms_state[$web_room][$web_rate]['price_type'] = 'pms';
					$pms_state[$web_room][$web_rate]['price_code'] = $web_rate;
					$pms_state[$web_room][$web_rate]['extra_info'] = [
						'type'         => 'code',
						'pms_code'     => $web_rate,
						'pkg'          => isset($row['pkg']) ? $row['pkg'] : '',
						'is_pms_point' => !empty($row['is_point_rate']),
						//								'channel_code' => $rd ['channelCode']
					];
					$pms_state[$web_room][$web_rate]['des'] = isset($row['ratecodeinfo'])?$row['ratecodeinfo']:'';
					$pms_state[$web_room][$web_rate]['sort'] = 0;
					$pms_state[$web_room][$web_rate]['disp_type'] = 'buy';
					$pms_state[$web_room][$web_rate]['is_pms_point'] = !empty($row['is_point_rate']);
					
					$web_set = [];
					if(isset ($params ['web_reflect'] ['web_price_code_set'] [$web_rate])){
						$web_set = json_decode($params ['web_reflect'] ['web_price_code_set'] [$web_rate], true);
					}
					
					$pms_state[$web_room][$web_rate]['condition'] = $web_set;
					
					if(isset($params['web_rids'][$web_room]) && isset($params['condit']['nums'][$params['web_rids'][$web_room]])){
						$nums = $params['condit']['nums'][$params['web_rids'][$web_room]];
					}else{
						$nums = 1;
					}
					
					$allprice = [];
					$amount = 0;
					
					if(!empty($row['is_point_rate'])){
						$least_arr = [1];
					}else{
						$least_arr = [3];
					}
					
					$date_status = true;
					
					//是否关房
					$closed = false;
					foreach($t as $w){
						$w['rate'] = number_format($w['rate'], 2, '.', '');
						
						$pms_state[$web_room][$web_rate]['date_detail'][$w['in_date']] = [
							'price' => $w['rate'],
							'nums'  => $w['avail'],
						];
						
						$allprice[$w['in_date']] = $w['rate'];
						$amount += $w['rate'];
						
						$least_arr[] = $w['avail'];
						
						$date_status = $date_status && $w['avail'] > 0 && $w['rate'] > 0;
						
						$closed = $closed || $w['rate'] == -1;
						
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
					
					if($closed){
						$amount=-1*$countday;
					}
					
					$pms_state[$web_room][$web_rate]['allprice'] = implode(',', $allprice);
					$pms_state[$web_room][$web_rate]['total'] = $amount;
					$pms_state[$web_room][$web_rate]['related_des'] = '';
					$pms_state[$web_room][$web_rate]['total_price'] = $amount * $nums;
					
					$pms_state[$web_room][$web_rate]['avg_price'] = number_format($amount / $params ['countday'], 2, '.', '');
					$pms_state[$web_room][$web_rate]['price_resource'] = 'webservice';
					
					
					$book_status = 'full';
					if($date_status && !$closed){
						$book_status = 'available';
					}
					
					$pms_state[$web_room][$web_rate]['book_status'] = $book_status;
					if($pms_state[$web_room][$web_rate]['avg_price'] >= 0)
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
	
	//判断订单是否能支付
	function check_order_canpay($order, $pms_set){
		$this->apiInit($pms_set);
		$web_order = $this->serv_api->queryOrder($order['web_orderid'],['orderid'=>$order['orderid']]);
		if($web_order){
			$status_arr = $this->pms_enum('status');
			$main_order = $web_order['main'];
			if($main_order){
				$status = $status_arr [$main_order['sta']];
			}
		}
		if(isset($status) && ($status == 1 || $status == 0)){//订单预定或确认
			return true;
		}else{
			return false;
		}
	}
	
	private function apiInit($pms_set){
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		
		$conf = array(
			'inter_id'     => $pms_set['inter_id'],
			'appkey'       => $pms_auth['appkey'],
			'secret'       => $pms_auth['secret'],
			'url'          => $pms_auth['url'],
			'cmmcode'      => $pms_auth['cmmcode'],
			//			'channel'      => $pms_auth['channel'],
			'sign_hotelid' => $pms_auth['sign_hotelid'],
			'loc'          => $pms_auth['loc'],
			'sess'         => $this->session->userdata($pms_set['inter_id'] . ':sess'),
		);
		$this->load->library('Baseapi/Xiruanapi_new', $conf, 'serv_api');
	}

	// 打开金税卡是执行其他开票业务的前提，并且，每次使用程序只需要打开一次金税卡，然后调用其他接口，直到程序关闭。
	private function auto_tax_openCard(){
		$url = self::INVOICE_DOMAIN.'TaxHttpService/tax_openCard';
		$back_json = doCurlPostRequest ($url , array(), array (), 20 );
		if(empty($back_json)){
			MYLOG::w('打开金税卡接口返回空,url:'.$url,'Aisino_invoice');
			return false;
		}
		$result = json_decode($back_json,true);
		if(!empty($result['RetCode'])&&($result['RetCode']==1011||$result['RetCode']==3001)){
			return true;
		}
		MYLOG::w('打开金税卡接口异常,url:'.$url.',result:'.$back_json,'Aisino_invoice');
	}

	// 查询下张发票的信息或者查询是否有下张发票
	function get_next_invoice($infoKind){
		if(!is_numeric($infoKind)){
			MYLOG::w('get_next_invoice参数格式错误infoKind:'.$infoKind,'Aisino_invoice');
			return false;
		}
		if($this->auto_tax_openCard()){
			$put_json = json_encode(array('infoKind'=>$infoKind));
			$url = self::INVOICE_DOMAIN.'TaxHttpService/tax_getInfo';
			$back_json = doCurlPostRequest($url, http_build_query(array('inputJson'=>$put_json)), array(),20);
			if(empty($back_json)){
				MYLOG::w('查询下张发票的信息接口返回空,url:'.$url.',post:'.$put_json,'Aisino_invoice');
				return false;
			}
			$result = json_decode($back_json,true);
			return $result;
		}
	}

	// 作废发票
	function cancel_invoice($infoKind,$typeCode,$num){
		if(!is_numeric($infoKind)||empty($typeCode)||empty($num)){
			MYLOG::w('cancel_invoice参数格式错误infoKind:'.$infoKind.',typeCode:'.$typeCode.',num:'.$num,'Aisino_invoice');
			return false;
		}
		if($this->auto_tax_openCard()){
			$put_json = json_encode(array(
				'infoKind'=>$infoKind,
				'typeCode'=>$typeCode,
				'num'=>$num,
				));
			$url = self::INVOICE_DOMAIN.'TaxHttpService/tax_cancel';
			$back_json = doCurlPostRequest($url , http_build_query(array('inputJson'=>$put_json)), array(),20);
			if(empty($back_json)){
				MYLOG::w('作废发票接口返回空,url:'.$url.',post:'.$put_json,'Aisino_invoice');
				return false;
			}
			$result = json_decode($back_json,true);
			return $result;
		}
	}

	// 打印发票
	function print_invoice($infoKind,$typeCode,$num,$printType=0,$confirmWin=0){
		if(!is_numeric($infoKind)||empty($typeCode)||empty($num)){
			MYLOG::w('print_invoice参数格式错误infoKind:'.$infoKind.',typeCode:'.$typeCode.',num:'.$num,'Aisino_invoice');
			return false;
		}
		if($this->auto_tax_openCard()){
			$put_json = json_encode(array(
				'infoKind'=>$infoKind,
				'typeCode'=>$typeCode,
				'num'=>$num,
				'printType'=>$printType,// 0打印发票,1打印清单
				'confirmWin'=>$confirmWin,// 0不预览,1预览(建议为0)
				));
			$url = self::INVOICE_DOMAIN.'TaxHttpService/tax_print';
			$back_json = doCurlPostRequest($url , http_build_query(array('inputJson'=>$put_json)), array(),20);
			if(empty($back_json)){
				MYLOG::w('打印发票接口返回空,url:'.$url.',post:'.$put_json,'Aisino_invoice');
				return false;
			}
			$result = json_decode($back_json,true);
			return $result;
		}
	}

	// 开具发票
	function issue_invoice($infoKind,$content=array()){
		if(!is_numeric($infoKind)||empty($content)){
			MYLOG::w('issue_invoice参数格式错误infoKind:'.$infoKind.',content数组为空','Aisino_invoice');
			return false;
		}
		if($this->auto_tax_openCard()){
			$arrays = array();
			$arrays['billCode'] = !empty($content['billCode'])?$content['billCode']:'';//单据号
			$arrays['infoKind'] = $infoKind;//发票类型
			//购方名称
			if(!empty($content['cName'])){
				$arrays['cName'] = $content['cName'];
			}else{
				MYLOG::w('cName为空或不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
				return false;
			}
			//购方地址电话
			if($infoKind===0){
				if(!empty($content['cAddress'])){
					$arrays['cAddress'] = $content['cAddress'];
				}else{
					MYLOG::w('cAddress为空或不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
				}
			}else{
				$arrays['cAddress'] = !empty($content['cAddress'])?$content['cAddress']:'';
			}
			//购方银行账号
			if($infoKind===0){
				if(!empty($content['cBank'])){
					$arrays['cBank'] = $content['cBank'];
				}else{
					MYLOG::w('cBank为空或不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
				}
			}else{
				$arrays['cBank'] = !empty($content['cBank'])?$content['cBank']:'';
			}
			//购方税号
			if($infoKind===0){
				if(!empty($content['cTaxCode'])){
					$arrays['cTaxCode'] = $content['cTaxCode'];
				}else{
					MYLOG::w('cTaxCode为空或不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
				}
			}else{
				$arrays['cTaxCode'] = !empty($content['cTaxCode'])?$content['cTaxCode']:'';
			}
			//税率
			if(isset($content['taxRate'])){
				$arrays['taxRate'] = $content['taxRate'];
			}else{
				MYLOG::w('taxRate不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
			}
			$arrays['cashier'] = !empty($content['cashier'])?$content['cashier']:'';//收款人
			$arrays['checker'] = !empty($content['checker'])?$content['checker']:'';//复核人
			//开票人
			if(!empty($content['invoicer'])){
				$arrays['invoicer'] = $content['invoicer'];
			}else{
				MYLOG::w('invoicer为空或不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
			}
			$arrays['listName'] = !empty($content['listName'])?$content['listName']:'';//是否开具清单
			//销方地址电话
			if($infoKind===0){
				if(!empty($content['sAddress'])){
					$arrays['sAddress'] = $content['sAddress'];
				}else{
					MYLOG::w('sAddress为空或不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
				}
			}else{
				$arrays['sAddress'] = !empty($content['sAddress'])?$content['sAddress']:'';
			}
			//销方银行账号
			if($infoKind===0){
				if(!empty($content['sBank'])){
					$arrays['sBank'] = $content['sBank'];
				}else{
					MYLOG::w('sBank为空或不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
				}
			}else{
				$arrays['sBank'] = !empty($content['sBank'])?$content['sBank']:'';
			}
			$arrays['notes'] = !empty($content['notes'])?$content['notes']:'';//备注
			//发票明细
			if(!empty($content['details'])){
				//金额
				if(isset($content['details']['amount'])){
					$arrays['details']['amount'] = $content['details']['amount'];
				}else{
					MYLOG::w('details=>amount不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
				}
				//商品名称
				if(!empty($content['details']['goodsName'])){
					$arrays['details']['goodsName'] = $content['details']['goodsName'];
				}else{
					MYLOG::w('details=>goodsName为空或不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
				}
				$arrays['details']['number'] = isset($content['details']['number'])?$content['details']['number']:'';//商品数量
				$arrays['details']['price'] = isset($content['details']['price'])?$content['details']['price']:'';//单价
				$arrays['details']['unit'] = !empty($content['details']['unit'])?$content['details']['unit']:'';//单位
				//含税标记
				if(isset($content['details']['priceKind'])){
					$arrays['details']['priceKind'] = $content['details']['priceKind'];
				}else{
					MYLOG::w('details=>priceKind不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
				}
				$arrays['details']['standard'] = !empty($content['details']['standard'])?$content['details']['standard']:'';//商品规格
				//税率
				if(isset($content['details']['taxRate'])){
					$arrays['details']['taxRate'] = $content['details']['taxRate'];
				}else{
					MYLOG::w('details=>taxRate不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
				}
				$arrays['details']['taxItem'] = !empty($content['details']['taxItem'])?$content['details']['taxItem']:'';//税目
				//新增字段
				$arrays['details']['goodsNoVer'] = isset($content['goodsNoVer'])?$content['goodsNoVer']:'1.0';//编码版本 固定1.0
				//税收分类编码
				if(isset($content['details']['goodsTaxNo'])){
					$arrays['details']['goodsTaxNo'] = $content['details']['goodsTaxNo'];
				}else{
					MYLOG::w('details=>goodsTaxNo不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
				}
				//优惠政策
				if(isset($content['details']['taxPre'])){
					$arrays['details']['taxPre'] = $content['details']['taxPre'];
				}else{
					MYLOG::w('details=>taxPre不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
				}
				$arrays['details']['taxPreCon'] = !empty($content['details']['taxPreCon'])?$content['details']['taxPreCon']:'';//优惠政策内容
				$arrays['details']['zeroTax'] = isset($content['details']['zeroTax'])?$content['details']['zeroTax']:'';//零税率标志
				$arrays['details']['cropGoodsNo'] = !empty($content['details']['cropGoodsNo'])?$content['details']['cropGoodsNo']:'';//自编码
				$arrays['details']['taxDeduction'] = isset($content['details']['taxDeduction'])?$content['details']['taxDeduction']:0;//差额 扣除额
				//新增字段end
				$arrays['details']['taxAmount'] = !empty($content['details']['taxAmount'])?$content['details']['taxAmount']:'';//税额
				$arrays['details']['discountFlag'] = !empty($content['details']['discountFlag'])?$content['details']['discountFlag']:'';//折扣标记
				$arrays['details']['discountRate'] = !empty($content['details']['discountRate'])?$content['details']['discountRate']:'';//折扣率
				$arrays['details']['sequence'] = !empty($content['details']['sequence'])?$content['details']['sequence']:'';//行号
			}else{
				MYLOG::w('details为空或不存在,infoKind:'.$infoKind.',content:'.json_encode($content),'Aisino_invoice');
					return false;
			}
			$arrays['cancelFlag'] = isset($content['cancelFlag'])?$content['cancelFlag']:'';//作废标记
			$arrays['totalAmount'] = isset($content['totalAmount'])?$content['totalAmount']:'';//总金额
			$arrays['totalTaxAmount'] = isset($content['totalTaxAmount'])?$content['totalTaxAmount']:'';//总税额
			$arrays['correspondingNumber'] = isset($content['correspondingNumber'])?$content['correspondingNumber']:'';//对应蓝票号码
			$arrays['correspondingTypeCode'] = isset($content['correspondingTypeCode'])?$content['correspondingTypeCode']:'';//对应蓝票代码
			$arrays['discountFlag'] = isset($content['discountFlag'])?$content['discountFlag']:'';//折扣标记
			$arrays['negativeFlag'] = isset($content['negativeFlag'])?$content['negativeFlag']:'';//负数标志
			$arrays['negNoticeNo'] = isset($content['negNoticeNo'])?$content['negNoticeNo']:'';//通知单号
			$arrays['infoNumber'] = isset($content['infoNumber'])?$content['infoNumber']:'';//发票号码
			$arrays['infoTypeCode'] = isset($content['infoTypeCode'])?$content['infoTypeCode']:'';//发票代码
			$arrays['details'] = array($arrays['details']);
			$put_json = json_encode($arrays);
			$url = self::INVOICE_DOMAIN.'TaxHttpService/tax_invoice';
			$back_json = doCurlPostRequest($url , http_build_query(array('inputJson'=>$put_json)), array(),20);
			if(empty($back_json)){
				MYLOG::w('开具发票接口返回空,url:'.$url.',infoKind:'.$infoKind.',post:'.$put_json,'Aisino_invoice');
				return false;
			}
			$result = json_decode($back_json,true);
			return $result;
		}
	}

	private function readDB(){
		static $db_read;
		if(!$db_read){
			$db_read = $this->load->database('iwide_r1',true);
		}
		return $db_read;
	}
	
	public function sendSMS($mobile, $type, $params, $inter_id){
		$this->load->model('common/Webservice_model');
		$time=time();
		$tmpl = '';
		//客人名称，订单号
		switch($type){
			case 'cus_cancel':
				$tmpl = '尊敬的%s：您好，预订的订单号为%s的订单，已经取消，如有需要请重新预订，感谢您的支持！如有疑问请指点呢4008-408-006';
				break;
			case 'auto_cancel':
				$tmpl = '尊敬的%s：您好,您预订的订单号为%s的订单，由于超时未支付成功，系统已自动取消，请知晓，如有需要请重新预订，谢谢！如有疑问请致电4008-408-006';
				break;
			
		}
		array_unshift($params, $tmpl);
		$content = call_user_func_array('sprintf', $params);
		
		$data = [
			'userId' => 'H11202',
			'password' => '220692',
			'pszMobis' => $mobile,
			'pszMsg' => $content,
			'iMobiCount' => 1,
			'pszSubPort' => '*'
		];
		
		
		$url = 'http://61.145.229.29:7791/MWGate/wmgw.asmx/MongateCsSpSendSmsNew?'.http_build_query($data);
		
		
		$con = curl_init(( string )$url);
		curl_setopt($con, CURLOPT_HEADER, false);
		//		curl_setopt($con, CURLOPT_POST, TRUE);
		curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($con, CURLOPT_TIMEOUT, 2);
		//		curl_setopt($con, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($con, CURLOPT_SSL_VERIFYHOST, 0);
		$res = curl_exec($con);
		curl_close($con);
		//		var_dump($res);
		$result = $res ? 'TRUE' : 'FALSE';
		
		$this->Webservice_model->add_webservice_record($inter_id,'xiruaniw',$url,func_get_args(),$res,'query_post',$time,microtime(),$this->session->userdata($inter_id.'openid'));
	}
}