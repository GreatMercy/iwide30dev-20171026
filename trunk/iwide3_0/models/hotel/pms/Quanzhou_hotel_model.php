<?php

class Quanzhou_hotel_model extends MY_Model{
	private $serv_api;
	
	public function __construct(){
		parent::__construct();
		$this->serv_api = new QuanzhouApi();
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
		
		$local_data = null;
		
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
			/*$web_price_code .= isset($web_reflect['member_price_code'][$member_level]) ? ',' . $web_reflect['member_price_code'][$member_level] : '';
			$web_price_code = substr($web_price_code, 1);*/
			
			//价格代码少时可以直接获取所有，方便缓存
			if($pms_set['pms_room_state_way'] == 3 || $pms_set['pms_room_state_way'] == 4){
				$web_code_arr = [];
				$price_code_list = $this->readDB()->from('hotel_price_info')->select('external_code')->where([
					'inter_id'        => $pms_set['inter_id'],
					'status'          => 1,
					'external_code!=' => ''
				])->get()->result_array();
				foreach($price_code_list as $v){
					$web_code_arr[] = $v['external_code'];
				}
				if($web_code_arr){
					$web_code_arr = array_unique($web_code_arr);
					$web_price_code = implode(',', $web_code_arr);
				}
			}
			//价格代码多时，查询可用房里的价格代码，查询的房价码较少
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
					if(!empty($v['show_info'])){
						foreach($v['show_info'] as $t){
							$web_price_code[]=$t['external_code'];
						}
					}
				}
			}
			$web_price_code=array_unique($web_price_code);*/
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
			'countday'     => $countday,
			'web_rids'     => $web_rids,
			'condit'       => $condit,
			'web_reflect'  => $web_reflect,
			'member_level' => $member_level,
			'idents'       => $idents,
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
					), $params, $local_data);
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
		
		$recache_uri = ['bookroom', 'saveorder'];
		if(!$all_exists || !empty($params['condit']['recache']) || in_array($this->uri->segment(3), $recache_uri)){
			if(!in_array($this->uri->segment(3), $recache_uri)){
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
			$func_data = ['hotel_id' => $params['idents']['hotel_id']];
			$web_rate_result = $this->serv_api->rateQuery($startdate, $countday, $web_price_code, [], $func_data);
			
			$cache_data = [];
			foreach($web_rate_result as $v){
				$web_rate_arr = [];
				//返回的只有首晚价，将首晚价作为所有价格的每日价格
				if(!empty($v['ratelists']['ratelist'])){
					$ratelist = $v['ratelists']['ratelist'];
					is_array(current($ratelist)) or $ratelist = [$ratelist];
					foreach($ratelist as $t){
						$web_rate_arr[$t['ratecode']] = [
							'rate'  => ['code' => $t['ratecode'], 'name' => $t['ratecode'], 'package' => $t['package']],
							'daily' => ['price' => $t['roomrate'], 'quantity' => $v['surnum']],
						];
					}
				}
				
				for($i = 0; $i < $countday; $i++){
					$in_date = date('Ymd', strtotime($startdate) + 86400 * $i);
					$cache_data[$in_date][$v['roomInventoryCode']]['name'] = $v['roomInventoryCode'];
					$cache_data[$in_date][$v['roomInventoryCode']]['rates'] = $web_rate_arr;
				}
			}

//			echo '<pre>';print_r($cache_data);
			
			if(in_array($this->uri->segment(3), $recache_uri)){
				//下单时，获取每天的价格，每次请求只能查询单个房型单个价格代码
				$web_room = $web_room_list[0];
				$web_rate = $web_price_code[0];
				$web_rate_rows = $this->serv_api->getRmRate($web_room, $startdate, $countday, $web_rate, [], $func_data);
				$daily_rate = [];
				foreach($web_rate_rows as $v){
					list($in_date, $in_time) = explode('T', $v['date']);
					$in_date = date('Ymd', strtotime($in_date));
					$daily_rate[$in_date] = $v;
				}
				//将每日价格替换到首晚价
				foreach($cache_data as $k => $v){
					if(!isset($daily_rate[$k])){
						//每天价格返回不全时，unset
						unset($cache_data[$k][$web_room]);
						continue;
					}
					
					$row = $daily_rate[$k];
					//替换价格
					$cache_data[$k][$web_room]['rates'][$web_rate]['daily']['price'] = $row['rate'];
				}
			}
//			print_r($cache_data);
//			echo '</pre>';
			
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
						'package'  => $t['package'],
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
					
					$least_arr = [1];
					
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
										$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'), 1);
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
									$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'), 1);
								}else{
									$tmp[$w][$dk]['price'] = $td['price'];
								}
								$tmp[$w][$dk]['nums'] = $tmp['least_num'];
								$allprice .= ',' . $tmp[$w][$dk]['price'];
								$amount += $tmp[$w][$dk]['price'];
							}
							
							$data[$room_key]['show_info'][$sik]['avg_price'] = number_format($amount / $params['countday'], 2);
							$data[$room_key]['show_info'][$sik]['allprice'] = substr($allprice, 1);
							$data[$room_key]['show_info'][$sik]['total'] = $amount;
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
				'orderid'  => $order['orderid'],
				'inter_id' => $order['inter_id']
			));
			$this->db->update('hotel_order_additions', array(
				//更新pms单号到本地
				'web_orderid' => $web_orderid
			));
			$upstatus = null;
			$has_paid = null;
			if($order['status'] != 9){
				$upstatus = 1;
			}
			
			$config_data = $this->Hotel_config_model->get_hotel_config($inter_id, 'HOTEL', $order ['hotel_id'], array(
				'PMS_BANCLANCE_REDUCE_WAY',
			));
			
			if($order['point_favour'] > 0){
				//调用入账接口
				
			}
			
			//使用优惠券时
			if($order['coupon_favour'] > 0){
				//入账
				
			}
			
			if($order['paytype'] == 'balance' && !empty($config_data['PMS_BANCLANCE_REDUCE_WAY']) && $config_data['PMS_BANCLANCE_REDUCE_WAY'] == 'after'){
				$this->load->model('hotel/Member_model');
				$sub_orders = [];
				foreach($order['order_details'] as $v){
					$sub_orders[$v['sub_id']] = $v['iprice'];
				}
				$balance_param = [
					'crsNo' => $web_orderid,
					'extra' => json_encode([
						'orders' => $sub_orders
					]),
				];
				
				$res = $this->Member_model->reduce_balance($inter_id, $order['openid'], $order['price'], $order['orderid'], '订房订单余额支付', $balance_param, $order);
				if(!$res){
					//支付失败，取消订单
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
				$has_paid = 1;
			}
			
			if(!empty($params['trans_no'])){
				$this->add_web_bill($web_orderid, $order, $pms_set, $params['trans_no']);
			}
			
			return array('s' => 1, 'upstatus' => $upstatus, 'has_paid' => $has_paid);
		}
	}
	
	function order_reserve($order, $pms_set, $params = array()){
		$this->apiInit($pms_set);
		
		$room_codes = json_decode($order ['room_codes'], true);
		$room_codes = $room_codes[$order ['first_detail'] ['room_id']]; //$room_codes 结构：array('本地room_id'=>array('room'=>array('webser_id'=>房型代码),'code'=>array($extra_info(就是取房态时的 extra_info),'price_type'=>'价格类型')))
		$extra_info = $room_codes['code']['extra_info'];
		
		$remark = '';
		if($order['coupon_favour'] > 0){
			$remark .= '使用优惠券：' . $order['coupon_favour'] . '元。';
		}
		if($order['point_favour'] > 0){
			$remark .= '积分扣减：' . $order['point_favour'] . '元。';
		}
		
		$post_data = [
			'name_first'     => mb_substr($order['name'], 0, 1, 'utf-8'),
			'name_sur'       => mb_substr($order['name'], 1, null, 'utf-8'),
			'rmtype'         => $room_codes['room']['webser_id'],
			'startdate'      => $order['startdate'],
			'countday'       => get_room_night($order['startdate'], $order['enddate'], 'ceil', $order),
			'rate_plan_code' => $extra_info['pms_code'],
			'num_rooms'      => $order['roomnums'],
			'name'           => $order['name'],
			'tel'            => $order['tel'],
			'remark'         => $remark,
		];
		
		$this->load->model('api/Vmember_model', 'vm');
		$member = $this->vm->getUserInfo($order['openid'], $order['inter_id']);
		$extra = [];
		if($member['logined']){
			$extra['openid'] = $order['openid'];
		}
		
		$result = $this->serv_api->submitOrder($post_data, $extra, ['orderid' => $order['orderid']]);
		
		return $result;
	}
	
	public function update_web_order($inter_id, $order, $pms_set){
		
		$web_orderid = $order['web_orderid'];
		$this->apiInit($pms_set);
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$func_data = ['orderid' => $order['orderid']];
		$web_order = $this->serv_api->queryOrder($web_orderid, [], $func_data);
		
		$istatus = -1;
		
		if(!empty($web_order)){
			$web_status = $web_order['Rates']['Rate']['rateBasisUnits'];
			$status = $this->pms_enum('status', $web_status);
			
			$this->load->model('hotel/Order_model');
			
			$od = $order['first_detail'];
			
			// 未确认单先确认
			if($status != 0 && $order['status'] == 0){
				$this->change_order_status($inter_id, $order['orderid'], 1);
				$this->Order_model->handle_order($inter_id, $order['orderid'], 1, '', array(
					'no_tmpmsg' => 1
				));
			}
			
			$istatus = $status;
			
			if($od ['istatus'] == 4 && $istatus == 5){
				$istatus = 4;
			}
			
			$updata = [];
			
			$od = $order['first_detail'];
			
			//PMS上的入住，离店时间
			$web_start = date('Ymd', strtotime($web_order['TimeSpan']['startTime']));
			$web_end = date('Ymd', strtotime($web_order['TimeSpan']['startTime']) + 86400 * $web_order['TimeSpan']['numberOfTimeUnits']);
			
			//判断实际入住时间，订单记录的入住时间
			$ori_day_diff = get_room_night($od['startdate'], $od['enddate'], 'ceil', $od);//至少有一个间夜
			$web_day_diff = get_room_night($web_start, $web_end, 'ceil');//至少有一个间夜
			$day_diff = $web_day_diff - $ori_day_diff;
			
			$updata['startdate'] = $web_start;
			$updata['enddate'] = $web_end;
			if($day_diff != 0 || $web_start != $od ['startdate'] || $web_end != $od ['enddate']){
				$updata ['no_check_date'] = 1;
			}
			
			$new_price = $web_order['Rates']['Rate']['Amount']['valueTotal'];
			
			$ori_total = array_sum(explode(',', $od['allprice'])); //本地记录的不含优惠总价
			$old_total = array_sum(explode(',', $od['real_allprice'])); //下单时的金额
			$discount_price = $ori_total - $old_total;  //优惠的价格
			$new_price -= $discount_price;
			if($new_price >= 0 && $od['iprice'] != $new_price){
				$updata ['no_check_date'] = 1;
				$updata['new_price'] = $new_price;
			}
			
			if($istatus != $od ['istatus']){
				$updata['istatus'] = $istatus;
			}
			
			if(!empty ($updata)){
				$this->Order_model->update_order_item($inter_id, $order['orderid'], $od['sub_id'], $updata);
			}
			
		}
		return $istatus;
	}
	
	public function cancel_order_web($inter_id, $order, $pms_set = array()){
		$this->inter_id = $order['inter_id'];
		if(empty($order['web_orderid'])){
			return array(
				's'      => 0,
				'errmsg' => '取消失败~'
			);
		}
		
		$this->apiInit($pms_set);
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$func_data = ['orderid' => $order['orderid']];
		
		$extra = [];
		$res = $this->serv_api->cancelOrder($order['web_orderid'], $extra, $func_data);
		
		if($res){
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
		$this->apiInit($pms_set);
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		
		$func_data = ['orderid' => $order['orderid']];
		
		$web_order = $this->serv_api->queryOrder($web_orderid, [], $func_data);
		
		if(empty($web_order)){
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
		
		$payment_params = [
			'confirmationID' => $web_orderid,
			'paycode'        => $pms_auth['paycode'],
			'CashOrderNo'    => $trans_no,
			'amount'         => $order['price'],
			'remark'         => $order['orderid'],
		];
		
		$extra = [];
		$res = $this->serv_api->addPayment($payment_params, $extra, $func_data);
		if($res){
			$web_paid = 1;
		}
		
		$this->db->where(array(
			'orderid'  => $order['orderid'],
			'inter_id' => $order['inter_id']
		));
		$this->db->update('hotel_order_additions', array(
			'web_paid' => $web_paid
		));
		
		return $web_paid == 1;
	}
	
	function check_order_canpay($order, $pms_set){
		$this->apiInit($pms_set);
		
		$func_data = ['orderid' => $order['orderid']];
		$web_order = $this->serv_api->queryOrder($order['web_orderid'], [], $func_data);
		
		if(!empty($web_order)){
			$status = $this->pms_enum('status', $web_order['Rates']['Rate']['rateBasisUnits']);
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
					'Q' => 0,
					'R' => 1,
					'I' => 2,
					'O' => 3,
					'D' => 3,
					//					'H' => 3,
					'X' => 5,
					'N' => 8,
					'S' => 3,
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

class QuanzhouApi{
	private $inter_id;
	private $url;
	private $CI;
	
	private $user;
	private $pwd;
	
	private $originator;
	private $source_code;
	private $market_code;
	private $channel_code;
	private $operator;
	
	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->helper('common');
		$this->CI->load->model('common/Webservice_model');
	}
	
	public function setPmsAuth($config = []){
		$this->inter_id = $config['inter_id'];
		$this->url = $config['url'];
		$this->user = $config['user'];
		$this->pwd = $config['pwd'];
		$this->originator = $config['originator'];
		$this->source_code = $config['source_code'];
		$this->market_code = $config['market_code'];
		$this->channel_code = $config['channel_code'];
		$this->operator = $config['operator'];
	}
	
	public function rateQuery($sdate, $countday, $web_rate_arr, $extra = [], $func_data = []){
		$xml = '<RatePlan reservationActionType="CHANGE"><ratePlanCode>' . implode(',', $web_rate_arr) . '</ratePlanCode><TimeSpan timeUnitType="DAY"><startTime>' . date('Y-m-d', strtotime($sdate)) . ' 00:00:00</startTime><numberOfTimeUnits>' . $countday . '</numberOfTimeUnits></TimeSpan><Rates><Rate reservationActionType="CHANGE" rateBasisTimeUnitType="DAY"></Rate></Rates><CusNo>' . (isset($extra['cur_no']) ? $extra['cur_no'] : '') . '</CusNo></RatePlan>';
		
		$openid = isset($extra['openid']) ? $extra['openid'] : '';
		
		$params = ['xml' => $this->data2xml(1020, ['RatePlans' => $xml], $openid)];
		$res = $this->postService('RateQueryByCusNo', $params, $func_data);
		$result = [];
		if(isset($res['Head']['retcode']) && $res['Head']['retcode'] == '00001' && !empty($res['Body']['record'])){
			$result = $res['Body']['record'];
			is_array(current($result)) or $result = [$result];
		}
		return $result;
	}
	
	public function getRmRate($web_room, $sdate, $countday, $web_rate, $extra = [], $func_data = []){
		$sdate = date('Y-m-d', strtotime($sdate)) . 'T12:00:00';
		$data = [
			'RoomRate' => [
				'stay'     => $sdate,
				'type'     => $web_room,
				'day'      => $countday,
				'ratecode' => $web_rate,
			]
		];
		
		$openid = isset($extra['openid']) ? $extra['openid'] : '';
		$params = ['xml' => $this->data2xml(10, $data, $openid)];
		$result = [];
		$res = $this->postService('GetRmrate', $params, $func_data);
		if(isset($res['Head']['retcode']) && $res['Head']['retcode'] == '0' && !empty($res['Body']['ResponseBodyRmrate']['Rmrate'])){
			$result = $res['Body']['ResponseBodyRmrate']['Rmrate'];
			is_array(current($result)) or $result = [$result];
		}
		return $result;
	}
	
	public function submitOrder($post_data, $extra = [], $func_data = []){
		$xml = '<Reservation mfShareAction="NA" mfReservationAction="ADD">';
		$xml .= '<reservationOriginatorCode>' . $this->originator . '</reservationOriginatorCode>'; //订房中心
		$xml .= '<protocol></protocol>';  //协议单位
		$xml .= '<ResComments><ResComment reservationActionType="CHANGE"><comment>' . $post_data['remark'] . '</comment></ResComment></ResComments>';    //订单备注
		$xml .= '<ResProfiles><ResProfile><Profile profileType="GUEST">';
		$xml .= '<IndividualName><nameTitle/>';  //根据性别来确定Mr,Ms
		$xml .= '<nameFirst>' . $post_data['name_first'] . '</nameFirst>';
		$xml .= '<nameSur>' . $post_data['name_sur'] . '</nameSur>';
		$xml .= '</IndividualName>';
		$xml .= '<primaryLanguageID>C</primaryLanguageID>';
		$xml .= '</Profile></ResProfile></ResProfiles>';
		$xml .= '<RoomStays><RoomStay mfShareAction="NA" mfReservationAction="ADD" reservationActionType="CHANGE" reservationStatusType="RESERVED"><roomStayRPH/>';
		$xml .= '<roomInventoryCode>' . $post_data['rmtype'] . '</roomInventoryCode>'; //房型
		$xml .= '<roomNo></roomNo>';   //房间号  *传此值，房间数必须为1
		$xml .= '<TimeSpan timeUnitType="DAY">';
		$xml .= '<startTime>' . date('Y-m-d', strtotime($post_data['startdate'])) . ' 18:00:00</startTime>';   //到店时间
		$xml .= '<numberOfTimeUnits>' . $post_data['countday'] . '</numberOfTimeUnits>';
		$xml .= '<arrtime>19:30</arrtime>';
		$xml .= '</TimeSpan>';
		$xml .= '<GuestCounts>';
		$xml .= '<GuestCount><ageQualifyingCode>ADULT</ageQualifyingCode><mfCount>1</mfCount></GuestCount>';   //成人人数
		$xml .= '<GuestCount><ageQualifyingCode>CHILD</ageQualifyingCode><mfCount>0</mfCount></GuestCount>';  //儿童人数
		$xml .= '</GuestCounts>';
		$xml .= '<RatePlans><RatePlan reservationActionType="CHANGE">';
		$xml .= '<ratePlanCode>' . $post_data['rate_plan_code'] . '</ratePlanCode>';
		$xml .= '<mfsourceCode>' . $this->source_code . '</mfsourceCode>';  //在微网站增加来源码的设置页面，最长3位
		$xml .= '<mfMarketCode>' . $this->market_code . '</mfMarketCode>'; //在微网站增加市场码的设置页面，最长3位
		$xml .= '<numRooms>' . $post_data['num_rooms'] . '</numRooms>'; //房间数
		$xml .= '</RatePlan></RatePlans>';
		$xml .= '<mfchannelCode>' . $this->channel_code . '</mfchannelCode>';//在微网站增加渠道码的设置页面，最长3位
		$xml .= '</RoomStay></RoomStays>';
		$xml .= '<resCommentRPHs>' . $post_data['tel'] . '</resCommentRPHs>';
		$xml .= '<resProfileRPHs>' . $post_data['name'] . '</resProfileRPHs>';
		$xml .= '<mfsaleid />';
		$xml .= '</Reservation>';
		
		$openid = isset($extra['openid']) ? $extra['openid'] : '';
		$params = ['xml' => $this->data2xml(1009, $xml, $openid)];
		$result = [
			'result' => false,
		];
		$res = $this->postService('Reservation', $params, $func_data);
		if(isset($res['Head']['retcode']) && $res['Head']['retcode'] == '00001' && !empty($res['Body']['ReservationResponse']['Reservation'])){
			$result = [
				'result'      => true,
				'web_orderid' => $res['Body']['ReservationResponse']['Reservation']['confirmationID'],
			];
		}else{
			$result['errmsg'] = isset($res['Head']['retmsg']) ? $res['Head']['retmsg'] : '';
		}
		return $result;
	}
	
	public function queryOrder($web_orderid, $extra = [], $func_data = []){
		$data = [
			'ReservationDetail' => [
				'confirmationID' => $web_orderid,
				'cardno'         => '',
				'mobile'         => isset($extra['mobile']) ? $extra['mobile'] : '',
			],
		];
		
		$openid = isset($extra['openid']) ? $extra['openid'] : '';
		$params = ['xml' => $this->data2xml(1011, $data, $openid)];
		
		$res = $this->postService('GetReservationDetail', $params, $func_data);
		if(isset($res['Head']['retcode']) && $res['Head']['retcode'] == '00001' && !empty($res['Body']['ReservationResponses']['ReservationResponse']['Reservation'])){
			return $res['Body']['ReservationResponses']['ReservationResponse']['Reservation'];
		}
		return [];
	}
	
	public function cancelOrder($web_orderid, $extra = [], $func_data = []){
		$data = [
			'ReservationCancel' => [
				'confirmationID' => $web_orderid,
			]
		];
		$openid = isset($extra['openid']) ? $extra['openid'] : '';
		$params = ['xml' => $this->data2xml(1011, $data, $openid)];
		
		$res = $this->postService('ResCancel', $params, $func_data);
		if(isset($res['Head']['retcode']) && $res['Head']['retcode'] == '00001'){
			return true;
		}
		return false;
	}
	
	public function addPayment($post_data, $extra = [], $func_data = []){
		$data = [
			'ReservationOperator' => [
				'confirmationID' => $post_data['web_orderid'],
				'paycode'        => $post_data['paycode'],
				'CashOrderNo'    => $post_data['trans_no'],
				'amount'         => $post_data['amount'],
				'Operator'       => $this->operator,
				'remark'         => isset($post_data['remark']) ? $post_data['remark'] : '',
			],
		];
		
		$openid = isset($extra['openid']) ? $extra['openid'] : '';
		$params = ['xml' => $this->data2xml(1031, $data, $openid)];
		
		$res = $this->postService('ReservationCashment', $params, $func_data);
		if(isset($res['Head']['retcode']) && $res['Head']['retcode'] == '00001'){
			return true;
		}
		return false;
		
	}
	
	private function postService($func, $parameters, $func_data = []){
		$time = time();
		$result = [];
		$s = null;
		$run_alarm = 0;
		
		$soap_opt = array(
			'soap_version' => SOAP_1_1,
			'encoding'     => 'UTF-8',
			'cache_wsdl'   => WSDL_CACHE_NONE,
			//			'trace'        => true,
		);
		
		$soap = null;
		try{
			$soap = new SoapClient($this->url, $soap_opt);
		}catch(SoapFault $e){
			$this->checkWebResult('', [], $e, $time, microtime(), [], ['run_alarm' => 1]);
		}catch(Exception $e){
			$this->checkWebResult('', [], $e, $time, microtime(), [], ['run_alarm' => 1]);
		};
		
		if($soap !== null){
			try{
				$obj = $soap->__soapCall($func, ['parameters' => $parameters]);
				
				$this->CI->Webservice_model->add_webservice_record($this->inter_id, 'quanzhou', $this->url, func_get_args(), $obj, 'query_post', $time, microtime(), $this->CI->session->userdata($this->inter_id . 'openid'));
				
				
				if(!empty($obj->{$func . 'Result'})){
					$res = $obj->{$func . 'Result'};
					$result = xml2array($res);
				}
				$s = $result;
			}catch(SoapFault $e){
				$s = $e;
				$run_alarm = 1;
			}catch(Exception $e){
				$s = $e;
				$run_alarm = 1;
			}
			$this->checkWebResult($func, $parameters, $s, $time, microtime(), $func_data, ['run_alarm' => $run_alarm]);
		}
		
		return $result;
	}
	
	
	protected function checkWebResult($func_name, $send, $receive, $now, $micro_time, $func_data = [], $params = []){
		$func_name_des = $this->pms_enum('func_name', $func_name);
		isset ($func_name_des) or $func_name_des = $func_name; // 方法名描述\
		$err_msg = ''; // 错误提示信息
		$err_lv = NULL; // 错误级别，1报警，2警告
		$alarm_wait_time = 5; // 默认超时时间
		if(!empty($params['run_alarm'])){ // 程序运行报错，直接报警
			$err_msg = '程序报错,' . json_encode($receive, JSON_UNESCAPED_UNICODE);
			$err_lv = 1;
		}else{
			if(!isset($receive['Head']['retcode'])){
				$err_lv = 1;
				$err_msg = '接口报错';
			}else{
				
				switch($func_name){
					case 'RateQueryByCusNo':
						if($receive['Head']['retcode'] != '00001'){
							$err_lv = 2;
							$err_msg = '接口错误：' . $receive['Head']['retmsg'];
						}elseif(empty($receive['Body']['record'])){
							$err_lv = 2;
							$err_msg = '空数据';
						}
						break;
					case 'GetRmrate':
						if($receive['Head']['retcode'] != '0'){
							$err_lv = 2;
							$err_msg = '接口错误：' . $receive['Head']['retmsg'];
						}elseif(empty($receive['Body']['ResponseBodyRmrate']['Rmrate'])){
							$err_lv = 2;
							$err_msg = '空数据';
						}
						break;
					case 'Reservation':
						if($receive['Head']['retcode'] != '00001'){
							$err_lv = 1;
							$err_msg = '接口错误：' . $receive['Head']['retmsg'];
						}elseif(empty($receive['Body']['ReservationResponse']['Reservation'])){
							$err_lv = 1;
							$err_msg = '空数据';
						}
						break;
					case 'GetReservationDetail':
						if($receive['Head']['retcode'] != '00001'){
							$err_lv = 2;
							$err_msg = '接口错误：' . $receive['Head']['retmsg'];
						}elseif(empty($receive['Body']['ReservationResponses']['ReservationResponse']['Reservation'])){
							$err_lv = 2;
							$err_msg = '空数据';
						}
						break;
					case 'ResCancel':
						if($receive['Head']['retcode'] != '00001'){
							$err_lv = 1;
							$err_msg = '接口错误：' . $receive['Head']['retmsg'];
						}
						break;
					case 'ReservationCashment':
						if($receive['Head']['retcode'] != '00001'){
							$err_lv = 1;
							$err_msg = '接口错误：' . $receive['Head']['retmsg'];
						}
						
						break;
				}
			}
		}
		
		$this->CI->Webservice_model->webservice_error_log($this->inter_id, 'quanzhou', $err_lv, $err_msg, array(
			'web_path'        => $this->url,
			'send'            => $send,
			'receive'         => $receive,
			'send_time'       => $now,
			'receive_time'    => $micro_time,
			'fun_name'        => $func_name_des,
			'alarm_wait_time' => $alarm_wait_time
		), $func_data);
	}
	
	
	private function pms_enum($type = '', $key = ''){
		$arr = [];
		switch($type){
			case 'func_name':
				$arr = [
					'RateQueryByCusNo'     => '获取房态',
					'GetRmrate'            => '获取每日价格',
					'Reservation'          => '提交订单',
					'GetReservationDetail' => '查询订单',
					'ResCancel'            => '取消订单',
					'ReservationCashment'  => '网络入账',
				];
				break;
		}
		if($key === ''){
			return $arr;
		}
		return isset($arr[$key]) ? $arr[$key] : null;
	}
	
	protected function data2xml($systype, $data, $openid = ''){
		$xml = '<?xml version="1.0" encoding="utf-8" ?><Request>';
		$head = [
			'transcode' => 10,
			'systype'   => $systype,
			'reqtime'   => date('Y-m-d') . 'T' . date('H:i:s'),
			'username'  => $this->user,
			'password'  => $this->pwd,
			'openid'    => $openid,
		];
		$xml .= '<Head>' . array2xml($head) . '</Head>';
		$xml .= '<Body>' . (is_array($data) ? array2xml($data) : $data) . '</Body>';
		$xml .= '</Request>';
		return $xml;
	}
	
	
}