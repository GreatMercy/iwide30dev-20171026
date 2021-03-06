<?php

class Gbsz_hotel_model extends MY_Model{
	private $serv_api;
	
	public function __construct(){
		parent::__construct();
		$this->serv_api = new GsbzApi();
	}
	
	public function get_rooms_change($rooms, $idents, $condit, $pms_set = array()){
		$this->inter_id = $pms_set['inter_id'];
		$this->load->model('common/Webservice_model');
		$web_reflect = $this->Webservice_model->get_web_reflect($idents['inter_id'], $idents['hotel_id'], $pms_set['pms_type'], array(
			'web_price_code_set',
		), 1, 'w2l');
		
		$this->load->model('api/Vmember_model', 'vm');
		$member_level = $this->vm->getLvlPmsCode($condit['openid'], $idents['inter_id']);
		
		$web_price_code = '';
		
		if(!empty($condit['price_codes'])){
			$web_price_code = $condit['price_codes'];
			
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
			$web_price_code .= isset($web_reflect['member_price_code'][$member_level]) ? ',' . $web_reflect['member_price_code'][$member_level] : '';
			$web_price_code = substr($web_price_code, 1);
		}
		
		$web_price_code = explode(',', $web_price_code);
		$countday = get_room_night($condit['startdate'], $condit['enddate'], 'ceil', $condit);//至少有一个间夜
		$web_rids = array();
		foreach($rooms as $r){
			$web_rids[$r['webser_id']] = $r['room_id'];
		}
		
		//是否时租房类型
		if(empty($condit['only_type']) && !empty($condit['price_type']) && is_array($condit['price_type'])){
			$pt_arr = $condit['price_type'];
			if(count($pt_arr) == 1){
				$condit['only_type'] = end($pt_arr);
			}
		}
		
		$params = array(
			'countday'      => $countday,
			'web_rids'      => $web_rids,
			'condit'        => $condit,
			'web_reflect'   => $web_reflect,
			'member_level'  => $member_level,
			'idents'        => $idents,
		);

//		if(!empty($web_price_code)){
		$pms_data = $this->get_web_roomtype($pms_set, $web_price_code, $condit['startdate'], $condit['enddate'], $params);
//		}
		$result = array();
		if(!empty($pms_data)){
			switch($pms_set['pms_room_state_way']){
				case 1 :
				case 2 :
					$result = $this->get_rooms_change_allpms($pms_data, array(
						'rooms' => $rooms
					), $params);
					break;
				case 4:
					$result = $this->get_rooms_change_ratecode($pms_data, array(
						'rooms' => $rooms
					), $params);
					break;
			}
		}
		
		return $result;
	}
	
	public function get_web_roomtype($pms_set, $web_price_code, $startdate, $enddate, $params = array()){
		//缓存数据
		$countday = $params['countday'];
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
		
		$web_room_rate = [];
		if(!$all_exists || !empty($params['condit']['recache']) || $this->uri->segment(3) == 'saveorder'){
			if($this->uri->segment(3) != 'saveorder'){
				for($start = $sdate; $start < $edate;){
					$rk = $rk_temp . $start;
					//删除缓存数据，防止接口没有数据返回时，本地仍有缓存
					$redis->del($rk);
					$start = date('Ymd', strtotime($start) + 86400);
				}
			}
			
			//房型
			$web_room_list = array_keys($params['web_rids']);
			$this->apiInit($pms_set);
			list($scenic, $hotel_web_id) = explode('#', $pms_set['hotel_web_id']);
			$web_rate_result = $this->serv_api->getRoomState($scenic, $web_room_list, $startdate, $enddate, ['hotel_id' => $params['idents']['hotel_id']]);
			$web_rate_code = '0';
			$cache_data = [];
			foreach($web_rate_result as $k => $v){
				for($i = 0; $i < $countday; $i++){
					$row = $v[$i];
					$in_date = date('Ymd', strtotime($row['date']));
					$cache_data[$in_date][$k]['name'] = $k;
					$cache_data[$in_date][$k]['rates'][$web_rate_code] = [
						'rate'  => ['code' => $web_rate_code, 'name' => $web_rate_code],
						'daily' => ['price' => $row['price'], 'quantity' => $row['availnum']]
					];
				}
			}
			
			foreach($cache_data as $k => $v){
				//设置本地缓存
				/*if($this->uri->segment(3) != 'saveorder'){
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
				}*/
				
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
						'type'     => 'code',
						'pms_code' => $web_rate,
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
	
	public function get_rooms_change_ratecode($pms_data, $rooms, $params = []){
		$local_rooms = $rooms ['rooms'];
		$this->load->model('hotel/Order_model');
		$data = $this->Order_model->get_rooms_change($local_rooms, $params ['idents'], $params ['condit']);
		$pms_state = $pms_data['pms_state'];
		$valid_state = $pms_data['valid_state'];
		$condit = $params['condit'];
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
										$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'),1);
									}else{
										$tmp[$w][$dk]['price'] = $td['price'];
									}
									$tmp[$w][$dk]['nums'] = $tmp['least_num'] < $si['least_num'] ? $tmp['least_num'] : $si['least_num'];
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
					if(!empty($pms_auth['local_inventory'])){
						if($tmp['least_num'] >= $si['least_num']){
							$data[$room_key]['state_info'][$sik]['least_num'] = $si['least_num'];
						}
						//若本地可预订房量为0时，则房量状态设为满房
						if($si['least_num'] <= 0){
							$data[$room_key]['state_info'][$sik]['book_status'] = $si['book_status'];
						}
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
									$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'),1);
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
	
	public function order_to_web($inter_id, $orderid, $params = array(), $pms_set = array()){
		$this->load->model('hotel/Order_model');
		$order = $this->Order_model->get_main_order($inter_id, array(
			'orderid' => $orderid,
			'idetail' => array(
				'i'
			)
		));
		if(!$order){
			return array(
				's'      => 0,
				'errmsg' => '订单不存在'
			);
		}
		$order = $order[0];
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		
		$res = $this->order_reserve($order, $pms_set, $params);
		
		if(!$res['result']){
			$this->change_order_status($inter_id, $orderid, 10);
			
			return array(
				's'      => 0,
				'errmsg' => '提交订单失败。' . $res['errmsg']
			);
		}else{
			$web_orderid = $res['web_orderid'];
			$this->db->where(array(
				'orderid'  => $order ['orderid'],
				'inter_id' => $order ['inter_id']
			));
			$this->db->update('hotel_order_additions', array(
				//更新pms单号到本地
				'web_orderid' => $web_orderid
			));
			$upstatus = null;
			$has_paid = null;
			if($order ['status'] != 9){
				$upstatus = 1;
			}
			
			if(!empty($params['trans_no'])){
				$this->add_web_bill($web_orderid, $order, $pms_set, $params['trans_no']);
			}
			
			return array('s' => 1, 'upstatus' => $upstatus, 'has_paid' => $has_paid);
		}
	}
	
	function order_reserve($order, $pms_set, $params = array()){
		list($scenic, $hotel_web_id) = explode('#', $pms_set['hotel_web_id']);
		$this->apiInit($pms_set);
		$sdate = date('Y-m-d', strtotime($order['startdate']));
		$edate = date('Y-m-d', strtotime($order['enddate']));
		
		$sign_amount = array_sum(explode(',', $order['first_detail']['allprice']));
		
		$total_amount = $sign_amount * $order['roomnums'];
		
		
		$room_codes = json_decode($order ['room_codes'], true);
		$room_codes = $room_codes[$order ['first_detail'] ['room_id']]; //$room_codes 结构：array('本地room_id'=>array('room'=>array('webser_id'=>房型代码),'code'=>array($extra_info(就是取房态时的 extra_info),'price_type'=>'价格类型')))
		$extra_info = $room_codes['code']['extra_info'];
		
		$memo = '';
		if($order['coupon_favour'] > 0){
			$memo .= '使用优惠券：' . $order['coupon_favour'] . '元。';
		}
		if($order['point_favour'] > 0){
			$memo .= '积分扣减：' . $order['point_favour'] . '元。';
		}
		
		$post_data = [
			'sceniccode'  => $scenic,
			'otaorderid'  => $order['orderid'],
			'totalamount' => $total_amount,
			'memo'        => $memo,
			'guestinfo'   => [
				'guestname' => $order['name'],
				'mobile'    => $order['tel'],
				'idtype'    => '',
				'idno'      => '',
			],
			'orderlist'   => [
				'room' => [
					[
						'roomtype'  => $room_codes['room']['webser_id'],
						'hotelid'   => $hotel_web_id,
						'startdate' => $sdate,
						'enddate'   => $edate,
						'num'       => $order['roomnums'],
						'guestinfo' => [
							'guestname' => $order['name'],
							'mobile'    => $order['tel'],
							'idtype'    => '',
							'idno'      => '',
						],
					]
				],
			]
		];
		
		$func_data=['orderid'=>$order['orderid']];
		$result = $this->serv_api->submitOrder($post_data,$func_data);
		
		return $result;
		
	}
	
	public function update_web_order($inter_id, $order, $pms_set){
		list($scenic, $hotel_web_id) = explode('#', $pms_set['hotel_web_id']);
		
		$web_orderid = $order['web_orderid'];
		$this->apiInit($pms_set);
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$func_data = ['orderid' => $order['orderid']];
		$web_order = $this->serv_api->queryOrder($scenic, $order['orderid'], $func_data);
		
		$istatus = -1;
		
		if(!empty($web_order)){
			$status = $this->pms_enum('status', $web_order['ostatus']);
			
			$this->load->model('hotel/Order_model');
			
			// 未确认单先确认
			if($status != 0 && $order['status'] == 0){
				$this->change_order_status($inter_id, $order['orderid'], 1);
				$this->Order_model->handle_order($inter_id, $order['orderid'], 1, '', array(
					'no_tmpmsg' => 1
				));
			}
			
			if($order ['status'] == 4 && $status == 5){
				$status = 4;
			}
			$istatus = $status;
			
			if($status != $order['status']){
				$this->Order_model->update_order_status($inter_id, $order['orderid'], $status, $order['openid']);
			}
			
		}
		return $istatus;
	}
	
	public function cancel_order_web($inter_id, $order, $pms_set = []){
		list($scenic, $hotel_web_id) = explode('#', $pms_set['hotel_web_id']);
		
		$this->inter_id = $order['inter_id'];
		if(empty ($order ['web_orderid'])){
			return array(
				's'      => 0,
				'errmsg' => '取消失败~'
			);
		}
		
		$this->apiInit($pms_set);
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$func_data = ['orderid' => $order['orderid']];
		$total_favour = 0;
		if($order['coupon_favour'] > 0){
			$total_favour += $order['coupon_favour'];
		}
		if($order['point_favour'] > 0){
			$total_favour += $order['point_favour'];
		}
		$res = $this->serv_api->cancelOrder($scenic, $order['orderid'], '取消订单', [
			$order['price'],
			$total_favour
		], 0, $func_data);
		
		if($res['result']){
			return ['s' => 1, 'errmsg' => '取消成功'];
		}else{
			return ['s' => 0, 'errmsg' => '取消失败。' . $res['errmsg']];
		}
	}
	function add_web_bill($web_orderid, $order, $pms_set, $trans_no = ''){
		$web_paid = 2;
		//空订单号
		if(empty($web_orderid)){
			$this->db->where(array(
				'orderid'  => $order ['orderid'],
				'inter_id' => $order ['inter_id']
			));
			$this->db->update('hotel_order_additions', array(
				//更新web_paid 状态，2为失败，1为成功
				'web_paid' => $web_paid
			));
			return false;
		}
		list($scenic, $hotel_web_id) = explode('#', $pms_set['hotel_web_id']);
		$this->apiInit($pms_set);
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		
		$func_data = ['orderid' => $order['orderid']];
		$total_favour = 0;
		if($order['coupon_favour'] > 0){
			$total_favour += $order['coupon_favour'];
		}
		if($order['point_favour'] > 0){
			$total_favour += $order['point_favour'];
		}
		
		$res = $this->serv_api->addPayment($scenic, $order['orderid'], $trans_no, [$order['paytype'],$total_favour], $pms_auth['paytype'][$order['paytype']],$func_data);
		if($res){
			$web_paid=1;
		}
		
		$this->db->where(array(
			'orderid'  => $order['orderid'],
			'inter_id' => $order['inter_id']
		));
		$this->db->update('hotel_order_additions', array(
			'web_paid' => $web_paid
		));
		
		return $web_paid==1;
	}
	
	function check_order_canpay($order, $pms_set){
		$this->apiInit($pms_set);
		
		list($scenic, $hotel_web_id) = explode('#', $pms_set['hotel_web_id']);
		$func_data = ['orderid' => $order['orderid']];
		$web_order = $this->serv_api->queryOrder($scenic, $order['orderid'], $func_data);
		
		if(!empty($web_order)){
			$status = $this->pms_enum('status', $web_order['ostatus']);
		}
		if(isset($status) && ($status == 1 || $status == 0)){//订单确认
			return true;
		}else{
			return false;
		}
	}
	
	protected function pms_enum($type = '', $key = ''){
		$arr = [];
		switch($type){
			case 'status':
				//订单状态,0预订，1确认，2入住，3离店，4用户取消，5酒店取消,6酒店删除，7异常，8未到，9待支付
				$arr = array(
					'0' => 0,
					'1' => 1,
					'2' => 5,
					'3' => 5,
					'4' => 5,
					'5' => 3,
					'6' => 2
				);
				break;
		}
		
		if($key === ''){
			return $arr;
		}
		
		return isset($arr[$key]) ? $arr[$key] : null;
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
	
	
	private function apiInit($pms_set){
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$pms_auth['inter_id'] = $pms_set['inter_id'];
		$this->serv_api->setPMSAuth($pms_auth);
	}
	
	private function readDB(){
		static $db_read;
		if(!$db_read){
			$db_read = $this->load->database('iwide_r1', true);
		}
		return $db_read;
	}
}

class GsbzApi{
	
	private $appid;
	private $url;
	private $key;
	private $inter_id;
	private $CI;
	
	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->helper('common');
		$this->CI->load->model('common/Webservice_model');
	}
	
	public function setPmsAuth($config){
		$this->appid = $config['appid'];
		$this->key = $config['key'];
		$this->url = $config['url'];
	}
	
	public function getRoomState($scenic, $web_rooms, $sdate, $edate, $func_data = []){
		$result = [];
		$uri = 'resources/room/available';
		$sdate = date('Y-m-d', strtotime($sdate));
		$edate = date('Y-m-d', strtotime($edate));
		foreach($web_rooms as $v){
			$bizdata_arr = [
				'sceniccode' => $scenic,
				'startdate'  => $sdate,
				'enddate'    => $edate,
				'roomtype'   => $v
			];
			$rs = $this->postService($uri, $bizdata_arr, $func_data);
			if(isset($rs['result']) && $rs['result'] == 'success'){
				$result[$v] = $rs['data'];
			}
		}
		return $result;
	}
	
	public function submitOrder($bizdata_arr = [], $func_data = []){
		$uri = 'order/add';
		array_key_exists('packagecode', $bizdata_arr) or $bizdata_arr['packagecode'] = '';
		array_key_exists('packagenum', $bizdata_arr) or $bizdata_arr['packagenum'] = '';
		array_key_exists('payment', $bizdata_arr) or $bizdata_arr['payment'] = 0;
		array_key_exists('remark', $bizdata_arr) or $bizdata_arr['remark'] = '';
		array_key_exists('paytype', $bizdata_arr) or $bizdata_arr['paytype'] = 2;
		if(!isset($bizdata_arr['orderlist']['pos'])){
			$bizdata_arr['orderlist']['pos'] = [];
		}
		if(!isset($bizdata_arr['orderlist']['ticket'])){
			$bizdata_arr['orderlist']['ticket'] = [];
		}
		if(!isset($bizdata_arr['orderlist']['customitem'])){
			$bizdata_arr['orderlist']['customitem'] = [];
		}
		
		$rs = $this->postService($uri, $bizdata_arr, $func_data);
		if(isset($rs['result']) && $rs['result'] == 'success'){
			return [
				'result'      => true,
				'web_orderid' => $rs['data']['orderid'],
			];
		}
		return [
			'result' => false,
			'errmsg' => isset($rs['data']['desc']) ? $rs['data']['desc'] : '',
		];
	}
	
	public function queryOrder($scenic, $orderid, $func_data = []){
		$uri = 'order/query';
		$bizdata_arr = [
			'sceniccode' => $scenic,
			'otaorderid' => $orderid,
		];
		
		$rs = $this->postService($uri, $bizdata_arr, $func_data);
		
		if(isset($rs['result']) && 'success' == $rs['result']){
			return $rs['data'];
		}
		
		return [];
	}
	
	public function cancelOrder($scenic, $orderid, $remark = '', $amount = [], $full = 0, $func_data = []){
		$uri = 'order/cancel';
		$bizdata_arr = [
			'sceniccode'   => $scenic,
			'otaorderid'  => $orderid,
			'refundreason' => $remark,
			'amount'       => $amount,
			'full'         => $full,
		];
		
		$rs = $this->postService($uri, $bizdata_arr, $func_data);
		
		if(isset($rs['result']) && 'success' == $rs['result']){
			return [
				'result' => true,
				'fee'    => $rs['data']['fee'],
			];
		}
		
		return [
			'result' => false,
			'errmsg' => isset($rs['data']['desc']) ? $rs['data']['desc'] : '',
		];
		
	}
	
	/**
	 * 订单支付
	 * @param $scenic 景区代码
	 * @param $orderid 本地订单ID
	 * @param $payid 支付流水号
	 * @param array $amount 支付金额，优惠金额
	 * @param $paytype 支付方式
	 * @param array $func_data 本地数据
	 * @return bool
	 */
	public function addPayment($scenic, $orderid, $payid, $amount = [], $paytype, $func_data = []){
		$uri = 'order/pay';
		$bizdata_arr = [
			'sceniccode'  => $scenic,
			'otaorderid'  => $orderid,
			'payid'       => $payid,
			'amount'      => $amount,
			'paymenttype' => $paytype
		];
		
		$rs = $this->postService($uri, $bizdata_arr, $func_data);
		
		
		if(isset($rs['result']) && 'success' == $rs['result']){
			return true;
		}
		
		return false;
	}
	
	
	private function postService($func, $bizdata = null, $func_data = []){
		$time = time();
		$sign_data = $this->sign($bizdata);
		
		$url = $this->url . $func;
		
		$request = [
			'appid'   => $this->appid,
			'bizdata' => $bizdata != null ? json_encode($bizdata) : null,
			'sign'    => $sign_data['sign'],
		];
		$json = json_encode($request);
		$extra = ['CURLOPT_HTTPHEADER' => ['Content-Type: application/json']];
		
		$res = doCurlPostRequest($url, $json, $extra, 15);
		
		$request['sign_string'] = $sign_data['string'];
		
		$microtime = microtime();
		
		$this->CI->Webservice_model->add_webservice_record($this->inter_id, 'Gbsz', $url, $request, $res, 'query_post', $time, $microtime, $this->CI->session->userdata($this->inter_id . 'openid'));
		
		$run_alarm = empty($res) ? 1 : 0;
		
		$result = json_decode($res, true);
		
		$func_data['openid'] = $this->CI->session->userdata($this->inter_id . 'openid');
		
		$this->checkWebResult($url,$func, $request, $result, $time, $microtime, $func_data, ['run_alarm' => $run_alarm]);
		
		return $result;
	}
	
	private function sign($bizdata = null){
		!is_null($bizdata) or $bizdata = 'null';
		
		if(is_array($bizdata)){
			$bizdata = json_encode($bizdata);
		}
		$str = 'appid=' . $this->appid . '&bizdata=' . $bizdata . '&key=' . $this->key;
		
		return [
			'string' => $str,
			'sign'   => md5($str),
		];
	}
	
	protected function checkWebResult($url, $func_name, $send, $receive, $now, $micro_time, $func_data = [], $params = []){
		$func_name_des = $this->pms_enum('func_name', $func_name);
		isset ($func_name_des) or $func_name_des = $func_name; // 方法名描述\
		$err_msg = ''; // 错误提示信息
		$err_lv = NULL; // 错误级别，1报警，2警告
		$alarm_wait_time = 5; // 默认超时时间
		if(!empty($params['run_alarm'])){ // 程序运行报错，直接报警
			$err_msg = '程序报错,' . json_encode($receive, JSON_UNESCAPED_UNICODE);
			$err_lv = 1;
		}else{
			
		}
		
		$this->CI->Webservice_model->webservice_error_log($this->inter_id, 'Gbsz', $err_lv, $err_msg, array(
			'web_path'        => $url,
			'send'            => $send,
			'receive'         => $receive,
			'send_time'       => $now,
			'receive_time'    => $micro_time,
			'fun_name'        => $func_name_des,
			'alarm_wait_time' => $alarm_wait_time
		), $func_data);
	}
	
	
	protected function pms_enum($type = '', $key = ''){
		$arr = [];
		switch($type){
			case  'func_name':
				$arr = [
					'resources/room/available' => '房态查询',
					'order/add'                => '提交订单',
					'order/query'              => '查询订单',
					'order/cancel'             => '取消订单',
					'order/pay'                => '入账',
				];
				break;
		}
		
		if($key === ''){
			return $arr;
		}
		return isset($arr[$key]) ? $arr[$key] : null;
	}
	
	
}