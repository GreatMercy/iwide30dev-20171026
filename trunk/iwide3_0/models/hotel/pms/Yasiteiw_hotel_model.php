<?php

class Yasiteiw_hotel_model extends MY_Model{
	public function __construct(){
		parent::__construct();
		$this->load->helper('common');
	}
	
	public function get_rooms_change($rooms, $idents, $condit, $pms_set = []){
		statistic('A1');
		$this->load->model('common/Webservice_model');
		$web_reflect = $this->Webservice_model->get_web_reflect($idents ['inter_id'], $idents ['hotel_id'], $pms_set ['pms_type'], [
			'web_price_code_set',
			'free_rate_set'
		], 1, 'w2l');
		
		$member_level = $this->vm->getLvlPmsCode($condit['openid'], $idents['inter_id']);
		
		$web_price_code = '';
		
		if(!empty ($condit ['price_codes'])){
			if($pms_set['pms_room_state_way'] == 3 || $pms_set['pms_room_state_way'] == 4){
				$this->load->model('hotel/Price_code_model', 'pcm');
				$pricecodeinfo = $this->pcm->get_price_code($pms_set['inter_id'], $condit ['price_codes']);
				$web_price_code = $pricecodeinfo['external_code'];
			}else{
				$web_price_code = $condit ['price_codes'];
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
		$countday = get_room_night($condit['startdate'], $condit['enddate'], 'ceil', $condit);//至少有一个间夜
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
			'member_level' => $member_level,
			'idents'       => $idents,
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
		$local_rooms = $rooms ['rooms'];
		$condit = $params ['condit'];
		$this->load->model('hotel/Order_model');
		$data = $this->Order_model->get_rooms_change($local_rooms, $params ['idents'], $params ['condit']);
		$pms_state = $pms_data ['pms_state'];
		$valid_state = $pms_data ['valid_state'];
		
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
			if(empty ($valid_state [$lrm ['room_info'] ['webser_id']])){
				unset ($data [$room_key]);
				continue;
			}
			
			$nums = isset ($condit ['nums'] [$lrm ['room_info'] ['room_id']]) ? $condit ['nums'] [$lrm ['room_info'] ['room_id']] : 1;
			
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
								foreach($tmp [$w] as $dk => $td){
									if($si['related_cal_way'] && $si['related_cal_value']){
										$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
									}else{
										$tmp[$w][$dk]['price'] = $td['price'];
									}
//									$tmp [$w] [$dk] ['nums'] = $tmp['least_num'];
									$allprice .= ',' . $tmp [$w] [$dk] ['price'];
									$amount += $tmp [$w] [$dk] ['price'];
								}
								
								$data [$room_key] ['state_info'] [$sik] ['avg_price'] = number_format($amount / $params ['countday'], 1);
								$data [$room_key] ['state_info'] [$sik] ['allprice'] = substr($allprice, 1);
								$data [$room_key] ['state_info'] [$sik] ['total'] = intval($amount);
								$data [$room_key] ['state_info'] [$sik] ['total_price'] = $data [$room_key] ['state_info'] [$sik] ['total'] * $nums;
							}elseif($w == 'least_num'){
								if(!empty($si['condition']['mxn']) && $si['condition']['mxn'] < $tmp[$w]){
									$tmp[$w] = $si['condition']['mxn'];
								}
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
								foreach($tmp [$w] as $dk => $td){
									if($si['related_cal_way'] && $si['related_cal_value']){
										$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
									}else{
										$tmp[$w][$dk]['price'] = $td['price'];
									}
									$tmp [$w] [$dk] ['nums'] = $tmp['least_num'];
									$allprice .= ',' . $tmp [$w] [$dk] ['price'];
									$amount += $tmp [$w] [$dk] ['price'];
								}
								
								$data [$room_key] ['show_info'] [$sik] ['avg_price'] = number_format($amount / $params ['countday'], 1);
								$data [$room_key] ['show_info'] [$sik] ['allprice'] = substr($allprice, 1);
								$data [$room_key] ['show_info'] [$sik] ['total'] = intval($amount);
								$data [$room_key] ['show_info'] [$sik] ['total_price'] = $data [$room_key] ['show_info'] [$sik] ['total'] * $nums;
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
		
		return $data;
	}
	
	
	public function update_web_order($inter_id, $order, $pms_set){
		$this->apiInit($pms_set);
		$web_order = $this->serv_api->queryOrder($pms_set['hotel_web_id'], $order['web_orderid'], ['orderid' => $order['orderid']]);
		
		$status = -1;
		$istatus = -1;
		if(!empty ($web_order) && is_array($web_order)){
			$status_arr = $this->pms_enum('status');
			
			$status = $status_arr [$web_order['FolioState']];
			if($order ['status'] == 4 && $status == 5){
				$status = 4;
			}
			$this->load->model('hotel/Order_model');
			
			// 未确认单先确认
			if($status != 0 && $order ['status'] == 0){
				$this->change_order_status($inter_id, $order['orderid'], 1);
				$this->Order_model->handle_order($inter_id, $order ['orderid'], 1, '', [
					'no_tmpmsg' => 1
				]);
			}
			
			$related_orders = [];
			$order_count = count($order['order_details']);
			if($order_count == 1){
				$related_orders[] = $web_order;
			}else{
				$related_result = $this->serv_api->queryConnectedOrder($web_order['ChainID'], $order['web_orderid'], ['orderid' => $order['orderid']]);
				if(!empty($related_result['DataSet'])){
					$related_orders = $related_result['DataSet'];
					is_array(current($related_orders)) or $related_orders = [$related_orders];
				}
			}
			
			//斯特特有可能预订多间房，实际入住时，取消了某些房，PMS不会产生订单数据
			if(in_array($status, [2, 3, 8]) && count($related_orders) < $order_count){ //入住或离店时，而且PMS返回订单数量少于系统子订单数时
				$limit_count = $order_count - count($related_orders);
				//缺少的子订单数据与主订单一致，
				$web_order_copy = $web_order;
				//若订单状态为入住/离店时，复制的订单状态为取消
				$web_order_copy['FolioState'] = 2;
				//子订单号改为空值
				$web_order_copy['FolioID'] = '';
				
				for($i = 0; $i < $limit_count; $i++){
					$related_orders[] = $web_order_copy;
				}
			}
			
			if(!empty($related_orders)){
				//本地订单列表是否已更新过入住ID
				$local_items = [];
				$local_noitem = [];
				
				foreach($order['order_details'] as $od){
					if(!empty($od['webs_orderid'])){
						$local_items[$od['webs_orderid']] = $od;
					}else{
						$local_noitem[] = $od;
					}
				}
				
				$i = 0;
				foreach($related_orders as $v){
					//判断该入住ID是否已存在本地订单中
					$updata = [];
					if(isset($local_items[$v['FolioID']])){
						$od = $local_items[$v['FolioID']];
					}else{
						//不存在本地订单中
						$od = $local_noitem[$i];
						//有子订单号时才执行更新操作
						if($v['FolioID'])
							$this->db->where(['id' => (int)$od['sub_id']])->update('hotel_order_items', ['webs_orderid' => $v['FolioID']]);

//							$updata['webs_orderid'] = $v['FolioID'];
						$i++;
					}
					
					$wstatus = $v['FolioState'];//订单状态
					$istatus = $status_arr[$wstatus];
					if($od ['istatus'] == 4 && $istatus == 5){
						$istatus = 4;
					}
					if($istatus == 3){//离店状态
						if($v['AccState'] != 2){ //挂账状态下，订单状态改为入住，
							$istatus = 2;
						}
					}
					//PMS上的入住，离店时间
					$web_start = date('Ymd', $v['Arrival']);
					$web_end = date('Ymd', $v['Depart']);
					$web_end = $web_end == $web_start ? date('Ymd', strtotime('+ 1 day', strtotime($web_start))) : $web_end;
					
					//判断实际入住时间，订单记录的入住时间
					$ori_day_diff = get_room_night($od ['startdate'], $od ['enddate'], 'ceil', $od);//至少有一个间夜
					$web_day_diff = get_room_night($web_start, $web_end, 'ceil');//至少有一个间夜
					$day_diff = $web_day_diff - $ori_day_diff;
					
					$updata ['startdate'] = $web_start;
					$updata ['enddate'] = $web_end;
					if($day_diff != 0 || $web_start != $od ['startdate'] || $web_end != $od ['enddate']){
						$updata ['no_check_date'] = 1;
					}
					
					if($istatus == 3){
						//离店状态，获取结算金额
						//重新计算房价
						$web_total_res = $this->serv_api->getRoomAccTrans($web_order['ChainID'], $v['FolioID'], [
							'orderid' => $order['orderid'],
							'sub_id'  => $od['sub_id']
						]);
						if($web_total_res['result'] == 'succeed'){
							$new_price = $web_total_res['TotalRoomDebit'];
							if($new_price >= 0 && $new_price != $od['iprice']){
								$updata ['no_check_date'] = 1;
								$updata['new_price'] = $new_price;
							} /*elseif($new_price == 0){
								//结算房费为0时，取消订单
								$this->db->where(['id' => (int)$od['sub_id']])->update('hotel_order_items', ['istatus' => 1]);
								$istatus = 5;
							}*/
						}
						
					}
					
					if($istatus != $od ['istatus']){
						$updata ['istatus'] = $istatus;
					}
					
					if($od['room_no']!=$v['RoomNo']){
						$updata['room_no']=$v['RoomNo'];
					}
					
					if(!empty ($updata)){
						$this->Order_model->update_order_item($inter_id, $order ['orderid'], $od ['sub_id'], $updata);
					}
					
				}
			}elseif($status != $order ['status'] && $status !== false){
				$istatus = $status;
				$this->change_order_status($order['inter_id'], $order['orderid'], $status);
				$this->Order_model->handle_order($inter_id, $order ['orderid'], $status, $order ['openid']);
			}
		}
		return $istatus;
	}
	
	function pms_enum($type){
		switch($type){
			case 'status' :
				return [
					/*
					 * 0 ：未在线支付
1：等待提交给支付机构
2：等待支付结果
3：支付成功
4：支付失败
5：支付取消
					 */
					
					////FolioState:1=预订，2=取消，3=未到，4=入住，5=退房
					//订单状态,0预订，1确认，2入住，3离店，4用户取消，5酒店取消,6酒店删除，7异常，8未到，9待支付
					
					'1' => 1,
					'2' => 5,
					'3' => 8,
					'4' => 2,
					'5' => 3,
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
		
		$res = $this->serv_api->cancelOrder($pms_set['hotel_web_id'], $order['web_orderid'], ['orderid' => $order['orderid']]);
		
		if($res['result'] == 'succeed'){
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
	
	function order_reserve($order, $pms_set, $params = []){
		$this->apiInit($pms_set);
		
		$starttime = strtotime($order['startdate']);
		$endtime = strtotime($order['enddate']);
		
		if(ceil(($endtime - time()) / 86400) > 90){
			return [
				'result' => 0,
				'errmsg' => '最多可预订未来90天的房',
			];
		}
		
		$startdate = date('Y-m-d', $starttime) . 'T18:00:00';
		$enddate = date('Y-m-d', $endtime) . 'T12:00:00';
		
		$room_codes = json_decode($order ['room_codes'], true);
		$room_codes = $room_codes [$order ['first_detail'] ['room_id']]; //$room_codes 结构：array('本地room_id'=>array('room'=>array('webser_id'=>房型代码),'code'=>array($extra_info(就是取房态时的 extra_info),'price_type'=>'价格类型')))
		$extra_info = $room_codes['code']['extra_info'];
		
		$member = $this->vm->getUserInfo($order['openid'], $order['inter_id']);
		
		$remark = '';
		
		if($order['paytype'] == 'balance'){
			$remark .= '雅币支付。';
		}
		if($order['coupon_favour'] > 0){
			$remark .= '使用优惠券：' . $order['coupon_favour'] . '元。';
		}
		if($order['point_favour'] > 0){
			$remark .= '积分扣减：' . $order['point_favour'] . '元。';
		}
		
		$sub_source=22;
		if($order['paytype']=='point'||$order['paytype']=='balance'){
			$sub_source=24;
		}elseif($order['paytyp']=='weixin'){
			$sub_source=23;
		}
		
		//协议订单时，需要提交分销员名称，社群客名称
		$order_item = end($order['order_details']);
		if(!empty($order_item['club_id'])){
			$this->load->model('club/Club_model');
			$club_row = $this->Club_model->getClubInfoByClubId($order_item['club_id'], $order['inter_id']);
			if($club_row){
				$remark .= '分销员：' . $club_row['name'] . '，社群客名称：' . $club_row['club_name'];
				if($order['paytype']=='daofu'){
					$sub_source=30;
				}else{
					$sub_source=31;
				}
			}
		}
		
		$daily_price = explode(',', $order ['first_detail'] ['allprice']);
		
		//判断是否为勉强价格代码
		$this->load->model('common/Webservice_model');
		$web_reflect = $this->Webservice_model->get_web_reflect($order['inter_id'], $order['hotel_id'], $pms_set['pms_type'], [
			'free_rate_set'
		], 1, 'w2l');
		
		$free = false;
		if(isset($web_reflect['free_rate_set'][$extra_info['pms_code']])){
			$free = true;
			$remark .= ' 喜迎财神免费住（除夕至初四）';
		}
		
		if('package' == $order['channel']){
			$remark .= $order['remark'];
		}
		
		$book_folio = [
			'ChainID'        => $pms_set['hotel_web_id'],
			'RoomTypeID'     => $room_codes['room']['webser_id'],
			'Arrorig'        => $startdate,
			'Deporig'        => $enddate,
			'Mobile'         => $member && $member['telephone'] ? $member['telephone'] : $order['tel'],
			'MebName'        => $member && $member['pms_user_id'] ? $member['name'] : $order['name'],
			'ContractName'   => $member && $member['pms_user_id'] ? $member['name'] : $order['name'],
			'Phone'          => $member && $member['telephone'] ? $member['telephone'] : $order['tel'],
			'RoomCount'      => $order['roomnums'],
			'MebID'          => $member ? (int)$member['pms_user_id'] : 0,
			'MebTypeID'      => $member ? (int)$member['lvl_pms_code'] : 0,
			'RoomRate'       => $daily_price[0],
			'RoomRateTypeID' => $extra_info['pms_code'],
			'Remark'         => $remark,
			'SubSourceID'    => $sub_source,
		];
		
		$guest_folio = [
			[
				'Name'  => $order['name'],
				'Phone' => $order['tel'],
			],
		];
		$func_data = ['orderid' => $order['orderid']];
		$result = $this->serv_api->submitOrder($book_folio, $guest_folio, $free, $func_data);
		
		if(is_numeric($result)){
			return [
				'result'      => 1,
				'web_orderid' => $result,
			];
		}else{
			return [
				'result' => 0,
				'errmsg' => $result,
			];
		}
	}
	
	public function add_web_bill($web_orderid, $order, $pms_set, $trans_no,$pay_type=0){
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
		$web_order = $this->serv_api->queryOrder($pms_set['hotel_web_id'], $web_orderid, ['orderid' => $order['orderid']]);
		
		if(!$web_order || !is_array($web_order)){
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
		$amount=$order['price'];
		if($pay_type==1||$pay_type==2){
			$amount=0;
		}
		$result = $this->serv_api->addPayment($web_order['ChainID'], $web_orderid, $trans_no, $amount, ['orderid' => $order['orderid']]);
		if($result['result'] == 'succeed'){
			$web_paid = 1;
		}
		
		$this->db->where([
			'orderid'  => $order ['orderid'],
			'inter_id' => $order ['inter_id']
		]);
		$this->db->update('hotel_order_additions', [
			'web_paid' => $web_paid
		]);
		return $web_paid == 1;
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
					// 若pms的订单是即时确认的，执行确认操作，否则省略这一步
					$this->Order_model->update_order_status($inter_id, $order['orderid'], 1, $order['openid']);
				}
				
				if(!empty ($params ['third_no'])){ // 提交账务,如果传入了 trans_no,代表已经支付，调用pms的入账接口
					$this->add_web_bill($web_orderid, $order, $pms_set, $params['third_no']);
				}
				
				//优惠券账目
				$func_data = ['orderid' => $order['orderid']];
				if($order['coupon_favour'] > 0){
					$coupon_arr = json_decode($order['coupon_des'], true);
					$remark = '';
					if(is_array($coupon_arr)){
						foreach($coupon_arr as $k => $v){
							if(is_array($v)){
								foreach($v as $t){
									$remark .= '优惠券：' . $t['title'] . '，券码：' . $t['code'] . '，抵扣金额：' . $t['amount'] . '元；';
								}
							}
						}
					}
					if($remark){
						$res = $this->serv_api->addTrans($pms_set['hotel_web_id'], $web_orderid, 1, $order['coupon_favour'], $remark, $func_data);
					}
				}
				
				//积分账目
				if($order['point_favour'] > 0){
					$remark = '使用积分：' . $order['point_used_amount'] . '，扣抵房费：' . $order['point_favour'] . '；';
					$res = $this->serv_api->addTrans($pms_set['hotel_web_id'], $web_orderid, 3, $order['point_favour'], $remark, $func_data);
				}
				
				if($order['paytype']=='balance'){
					$this->load->model('hotel/Hotel_config_model');
					$config_data = $this->Hotel_config_model->get_hotel_config($inter_id, 'HOTEL', $order ['hotel_id'], array(
						'PMS_BANCLANCE_REDUCE_WAY'
					));
					if(!empty ($config_data ['PMS_BANCLANCE_REDUCE_WAY']) && $config_data ['PMS_BANCLANCE_REDUCE_WAY'] == 'after'){
						$remark='订单使用雅币支付。';
						
						//添加账单记录
						$res = $this->serv_api->addTrans($pms_set['hotel_web_id'], $web_orderid, 5, $order['price'], $remark, $func_data);
						$pay_res=false;
						if($res['result']=='succeed'){
							$this->load->model('hotel/Member_model');
							$sub_orders=[];
							foreach($order['order_details'] as $v){
								$sub_orders[$v['sub_id']]=$v['iprice'];
							}
							$balance_param = [
								'crsNo' => $web_orderid,
								'hotel_web_id'=>$pms_set['hotel_web_id'],
								'trans_id'=>$res['Tradeid'],
								'extra'=>json_encode([
									'orders'=>$sub_orders
								]),
							];
							if($this->Member_model->reduce_balance($inter_id, $order['openid'], $order['price'], $order['orderid'], '订房订单余额支付', $balance_param,$order)){
								$pay_res=true;
								//调用入账接口
								$this->Order_model->update_order_status($inter_id, $order['orderid'], 1, $order['openid'], true);
								$this->add_web_bill($web_orderid, $order, $pms_set, $res['Tradeid'],1);
								
							}
						}
						//储值支付失败
						if(!$pay_res){
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
				}elseif($order['paytype']=='point'){
					$this->load->model('hotel/Hotel_config_model');
					$config_data = $this->Hotel_config_model->get_hotel_config($inter_id, 'HOTEL', $order ['hotel_id'], array(
						'PMS_POINT_REDUCE_WAY'
					));
					if(!empty($config_data['PMS_POINT_REDUCE_WAY'])&&$config_data['PMS_POINT_REDUCE_WAY']=='after'){
						$remark='积分换房。';
						$func_data=[
							'orderid'=>$orderid,
						];
						$res = $this->serv_api->addTrans($pms_set['hotel_web_id'], $web_orderid, 3, $order['price'], $remark, $func_data);
						$pay_res=false;
						if($res['result']=='succeed'){
							$bonus_params=[
								'crsNo' => $web_orderid,
								'trans_id'=>$res['Tradeid'],
							];
							if($this->Member_model->consum_point($order['inter_id'], $order['orderid'], $order['openid'], $order['point_used_amount'],$bonus_params)){
								$pay_res=true;
								//调用入账接口
								$this->Order_model->update_order_status($inter_id, $order['orderid'], 1, $order['openid'], true);
								$this->add_web_bill($web_orderid, $order, $pms_set, $res['Tradeid'],2);
							}
							
						}
						//支付失败
						if(!$pay_res){
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
								'errmsg' => '积分支付失败！',
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
	
	private function get_rooms_change_allpms($pms_state, $rooms, $params){
		$data = [];
		foreach($rooms ['rooms'] as $rm){
			if(!empty ($pms_state ['pms_state'] [$rm ['webser_id']])){
				$data [$rm ['room_id']] ['room_info'] = $rm;
				$data [$rm ['room_id']] ['state_info'] = empty ($pms_state ['valid_state'] [$rm ['webser_id']]) ? [] : $pms_state ['valid_state'] [$rm ['webser_id']];
				$data [$rm ['room_id']] ['show_info'] = $pms_state ['pms_state'] [$rm ['webser_id']];
				$data [$rm ['room_id']] ['lowest'] = min($pms_state ['exprice'] [$rm ['webser_id']]);
				$data [$rm ['room_id']] ['highest'] = max($pms_state ['exprice'] [$rm ['webser_id']]);
			}
		}
		
		return $data;
	}
	
	public function get_web_roomtype($pms_set, $web_price_code, $startdate, $enddate, $params){
		$this->apiInit($pms_set);
		$_enddate = date('Ymd', strtotime($enddate) - 86400);
		
		$result = $this->serv_api->getRoomStatus($pms_set['hotel_web_id'], $startdate, $_enddate, ['hotel_id' => $params['idents']['hotel_id']]);
		$pms_state = [];
		$valid_state = [];
		$exprice = [];
		
		if(!empty($result['RoomStatusItems']['QueryRoomStatusItem'])){
			$room_rate_list = [];
			foreach($result['RoomStatusItems']['QueryRoomStatusItem'] as $v){
				$web_room = $v['RoomTypeID'];
				$web_rate = $v['RoomRateTypeID'];
				
				list($in_date, $in_time) = explode('T', $v['AccDate'], 2);
				$in_date = date('Ymd', strtotime($in_date));
				
				$rate_detail = [
					'in_date'    => $in_date,
					'left_count' => $v['RoomCount'] - $v['CheckInCount'] - $v['BookInCount'] - $v['StopSaleCount'] - $v['ControlCount'],
					'price'      => $v['RoomRate'],
				];
				
				$room_rate_list[$web_room][$web_rate]['room_item'] = $v;
				$room_rate_list[$web_room][$web_rate]['rate_item'][] = $rate_detail;
				
			}
			
			foreach($room_rate_list as $web_room => $v){
				if(!array_key_exists($web_room, $params['web_rids'])){
					continue;
				}
				foreach($v as $web_rate => $t){
					/*if(!in_array($web_rate, $web_price_code)){
						continue;
					}*/
					$pms_state[$web_room][$web_rate]['price_name'] = $t['room_item']['RoomRateTypeName'];
					$pms_state[$web_room][$web_rate]['price_type'] = 'pms';
					$pms_state[$web_room][$web_rate]['price_code'] = $web_rate;
					$pms_state[$web_room][$web_rate]['extra_info'] = [
						'type'     => 'code',
						'pms_code' => $web_rate
						//								'channel_code' => $rd ['channelCode']
					];
					$pms_state[$web_room][$web_rate]['des'] = '';
					$pms_state[$web_room][$web_rate]['sort'] = 0;
					$pms_state[$web_room][$web_rate]['disp_type'] = 'buy';
					
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
					
					$least_count = 5;
					//若是免费房价格代码时，只能预订一间
					
					$least_arr = [5];
					
					$date_status = true;
					
					foreach($t['rate_item'] as $w){
						$pms_state[$web_room][$web_rate]['date_detail'][$w['in_date']] = [
							'price' => $w['price'],
							'nums'  => $w['left_count'],
						];
						
						$allprice[$w['in_date']] = $w['price'];
						$amount += $w['price'];
						$least_arr[] = $w['left_count'];
						$date_status = $date_status && ($w['left_count'] > 0);
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
	
	//判断订单是否能支付
	function check_order_canpay($order, $pms_set){
		$this->apiInit($pms_set);
		$web_order = $this->serv_api->queryOrder($pms_set['hotel_web_id'], $order['web_orderid'], ['orderid' => $order['web_orderid']]);
		if($web_order){
			$status_arr = $this->pms_enum('status');
			$status = $status_arr[$web_order['FolioState']];
		}
		if(isset($status) && ($status == 1 || $status == 0)){//订单预定或确认
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 续住
	 * @param $order
	 * @param $pms_set
	 * @param array $params
	 * [
	 *  'sub_id'=>需要续住的子单号
	 *  'money'=>续住的金额
	 *  'third_no'=>交易流水号
	 *
	 * ]
	 * @return array
	 */
	public function continue_stay($order, $pms_set, $params = []){
		$this->apiInit($pms_set);
		$func_data = ['orderid' => $order['orderid'], 'sub_id' => $params['sub_id']];
		/*$web_order = $this->serv_api->queryOrder($pms_set['hotel_web_id'], $params['webs_orderid'], $func_data);
		if(!$web_order){
			return [
				's'      => 0,
				'errmsg' => '网络订单不存在',
			];
		}*/
		
		$res = $this->serv_api->continueStay($pms_set['hotel_web_id'], $params['webs_orderid'], $params['money'], $params['third_no'], 1, '续住1天', $func_data);
		if($res['result'] == 'succeed'){
			return [
				's' => 1,
			];
		}
		return [
			's'      => 0,
			'errmsg' => '操作失败！' . isset($res['msg']) ? $res['msg'] : '',
		];
	}
	
	private function apiInit($pms_set){
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$config = [
			'url'      => $pms_auth['url'],
			'inter_id' => $pms_set['inter_id'],
		];
		
		
		$this->load->library('Baseapi/Yasiteiwapi', $config, 'serv_api');
	}
}