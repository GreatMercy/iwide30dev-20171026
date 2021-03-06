<?php

class Beyondh2_hotel_model extends MY_Model{
	private $serv_api;
	
	public function __construct(){
		parent::__construct();
		$this->serv_api = new Beyondh2Api();
	}
	
	public function get_rooms_change($rooms, $idents, $condit, $pms_set = array()){
		$this->inter_id = $pms_set['inter_id'];
		statistic('a');
		$this->load->model('common/Webservice_model');
		$web_reflect = $this->Webservice_model->get_web_reflect($idents['inter_id'], $idents['hotel_id'], $pms_set['pms_type'], array(
			'member_price_code',
			'virtual_price_set',
			'web_checkin',
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
		
		//当前会员级别的价格代码，匹配时租房价显示
		$level_price_code = isset($web_reflect['member_price_code'][$member_level]) ? $web_reflect['member_price_code'][$member_level] : ($member_level ? $member_level : $web_reflect['member_price_code']['0']);
		
		//是否时租房类型
		if(empty($condit['only_type']) && !empty($condit['price_type']) && is_array($condit['price_type'])){
			$pt_arr = $condit['price_type'];
			if(count($pt_arr) == 1){
				$condit['only_type'] = end($pt_arr);
			}
		}
		
		$pms_lvl_list = [];
		if(!empty($condit['member_privilege'])){
			$member_privilege = $condit['member_privilege'];
			foreach($member_privilege as $v){
				$lvl_pms_code = explode(',', trim($v['lvl_pms_code']));
				$pms_lvl_list = array_merge($pms_lvl_list, $lvl_pms_code);
			}
			array_unshift($pms_lvl_list, '');
			$pms_lvl_list = array_unique($pms_lvl_list);
			$pms_lvl_list = array_values($pms_lvl_list);
		}
		$params = array(
			'countday'         => $countday,
			'web_rids'         => $web_rids,
			'condit'           => $condit,
			'web_reflect'      => $web_reflect,
			'member_level'     => $member_level,
			'idents'           => $idents,
			'level_price_code' => $level_price_code,
			'pms_lvl_list'     => $pms_lvl_list,
		);

//		if(!empty($web_price_code)){
		statistic('b');
		$pms_data = $this->get_web_roomtype($pms_set, $web_price_code, $condit['startdate'], $condit['enddate'], $params);
//		}
		statistic('c');
		$result = array();
		if(!empty($pms_data)){
			switch($pms_set['pms_room_state_way']){
				case 1 :
				case 2 :
					$result = $this->get_rooms_change_allpms($pms_data, array(
						'rooms' => $rooms
					), $params);
					break;
				case 3 :
					$result = $this->get_rooms_change_lmem($pms_data, array(
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
		statistic('d');
		$a_b = statistic('a', 'b');//查询本地配置
		$b_c = statistic('b', 'c');//请求PMS实时房态
		$c_d = statistic('c', 'd');//与本地房型匹配
		$a_d = statistic('a', 'd');//获取房型
		$timer_arr = array(
			'查询本地配置'    => $a_b . '秒',
			'请求PMS实时房态' => $b_c . '秒',
			'与本地房型匹配'   => $c_d . '秒',
			'获取房型房态总耗时' => $a_d . '秒',
			'执行时间'      => date('Y-m-d H:i:s'),
		);
		pms_logger(func_get_args(), $timer_arr, __METHOD__ . '->query_time', $pms_set['inter_id']);

//		$this->Webservice_model->log_service_record('获取房型房态', json_encode($timer_arr), $pms_set['inter_id'], 'beyondh', 'get_rooms_change', 'query_time');
		return $result;
	}
	
	function get_web_roomtype($pms_set, $web_price_code, $startdate, $enddate, $params){
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
		
		$sdate = date('Ymd', strtotime($startdate));
		$edate = date('Ymd', strtotime($enddate));
		
		//时租房房价码
		$clock_rate_set = array();
		if(!empty($params['web_reflect']['web_checkin']['hour'])){
			$clock_rate_set = explode(',', $params['web_reflect']['web_checkin']['hour']);
		}
		//促销房价码
		$promo_rate_set = array();
		if(!empty($params['web_reflect']['web_checkin']['promotion'])){
			$promo_rate_set = explode(',', $params['web_reflect']['web_checkin']['promotion']);
		}
		
		$saveorder = false;
		//价格代码为虚拟房价码时
		if($this->uri->segment(3) == 'saveorder'){
			$saveorder = true;
			
			if(in_array($web_price_code[0], $clock_rate_set)){     //时租房价
				$normal_recache = false;
				$promo_recache = false;
			}elseif(in_array($web_price_code[0], $promo_rate_set)){   //促销房价
				$normal_recache = false;
				$clock_recache = false;
			}else{ //普通房价
				$clock_recache = false;
				$promo_recache = false;
			}
		}
		
		$func_data = ['hotel_id' => $params['idents']['hotel_id']];
		
		$web_room_rate = [];
		
		//需要显示的级别
		$pms_lvl_list = $params['pms_lvl_list'];
		/*if($pms_lvl_list){
			array_unshift($pms_lvl_list, '');
		}*/
		$this->apiInit($pms_set);
		//时租房价
		if(!empty($params['condit']['only_type']) && $params['condit']['only_type'] == 'athour'){
			//是否有时租房
			if($clock_rate_set && date('Ymd') == $sdate && $countday == 1){
				$clock_rk_temp = $pms_set['inter_id'] . ':clock_price_lite:' . $params['idents']['hotel_id'] . ':';
				$clock_rk = $clock_rk_temp . $sdate;
				$clock_exists = $redis->exists($clock_rk);
				if(!$clock_exists || !empty($params['condit']['recache']) || !empty($clock_recache)){
					if($this->uri->segment(3) != 'saveorder'){
						
						for($start = $sdate; $start < $edate;){
							$rk = $clock_rk_temp . $start;
							//删除缓存数据，防止接口没有数据返回时，本地仍有缓存
							$redis->del($rk);
							$start = date('Ymd', strtotime($start) + 86400);
						}
					}
					
					$clock_lvl_list = $pms_lvl_list;
					if($saveorder){//下单时，只获取一个等级的时租房价
						$clock_lvl_list = [$params['member_level']];
					}
					$cache_data = [];
					$clock_result = $this->serv_api->getHourPrice($pms_set['hotel_web_id'], $sdate, $clock_lvl_list, $func_data);
					foreach($clock_result as $v){
						$checkin = $v['CheckinType'];
						$prices_arr = $v['Prices']['RoomPrice'];
						is_array(current($prices_arr)) or $prices_arr = [$prices_arr];
						foreach($prices_arr as $t){
							$_rate = $t['Description'];
							$daily_list = [
								'price'       => $t['ActualPrice'],
								'quantity'    => $t['RoomCount'],
								'orign_price' => $t['OrignPrice'],
							];
							
							$cache_data[$sdate][$t['RoomTypeId']]['name'] = $t['RoomType']['RoomTypeName'];
							if(isset($v['RoomType']['PhysicalRoomTypeId'])){
								$cache_data[$sdate][$v['RoomTypeId']]['physical_code'] = $v['RoomType']['PhysicalRoomTypeId'];
							}
							
							$cache_data[$sdate][$t['RoomTypeId']]['rates'][$checkin][$_rate] = [
								'rate'  => [
									'code'        => $checkin,
									'name'        => $_rate,
									'orign_price' => $t['OrignPrice'],
									'virtual'     => $v['RoomType']['Virtual'], //是否虚拟房型
									'is_clock'    => true,
								],
								'daily' => $daily_list
							];
						}
					}
					
					foreach($cache_data as $k => $v){
						//设置本地缓存
						if(!$saveorder){
							$rk = $clock_rk_temp . $k;
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
								
								foreach($_row['rates'] as $checkin => $t){
									//判断本地是否有此时租
									if(in_array($checkin, $clock_rate_set)){
										foreach($t as $rcode => $w){
											if($rcode == $params['level_price_code'] && $w['daily']['price'] != $w['daily']['orign_price']){
												$web_room_rate[$web_room]['rates'][$checkin] = $w['rate'];
												
												//每日价格记录
												$daily_rec = $w['daily'];
												$daily_rec['in_date'] = $k;
												$web_room_rate[$web_room]['rates'][$checkin]['daily'][] = $daily_rec;
											}
										}
									}
								}
							}
						}
					}
				}else{
					//读取本地缓存数据--开始
					for($start = $sdate; $start < $edate;){
						$rk = $clock_rk_temp . $start;
						
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
									foreach($_row['rates'] as $checkin => $t){
										//判断本地是否有此时租
										if(in_array($checkin, $clock_rate_set)){
											foreach($t as $rcode => $w){
												if($rcode == $params['level_price_code'] && $w['daily']['price'] != $w['daily']['orign_price']){
													$web_room_rate[$web_room]['rates'][$checkin] = $w['rate'];
													
													//每日价格记录
													$daily_rec = $w['daily'];
													$daily_rec['in_date'] = $start;
													$web_room_rate[$web_room]['rates'][$checkin]['daily'][] = $daily_rec;
												}
											}
										}
									}
								}
							}
						}
						
						$start = date('Ymd', strtotime($start) + 86400);
					}
					//读取本地缓存数据--结束
				}
			}
		}else{
			//判断本地缓存中每日都有数据
			$all_exists = true;
			$rk_temp = $pms_set['inter_id'] . ':price_lite:' . $params['idents']['hotel_id'] . ':';
			
			for($start = $sdate; $start < $edate;){
				$rk = $rk_temp . $start;
				if(!$redis->exists($rk)){
					$all_exists = false;
					break;
				}
				$start = date('Ymd', strtotime($start) + 86400);
			}
			
			if(!$all_exists || !empty($params['condit']['recache']) || !empty($normal_recache)){
				if($this->uri->segment(3) != 'saveorder'){
					for($start = $sdate; $start < $edate;){
						$rk = $rk_temp . $start;
						//删除缓存数据，防止接口没有数据返回时，本地仍有缓存
						$redis->del($rk);
						$start = date('Ymd', strtotime($start) + 86400);
					}
				}
				
				//只显示物理房
				$only_physical = true;
				
				if(!empty($params['web_reflect']['virtual_price_set'])){
					$only_physical = false;
				}
				
				$search_extra = array(
					'only_physical' => $only_physical,
					'lvl_list'      => $pms_lvl_list,
					//				    'web_rooms'=>array_keys($params['web_rids']),
				);
				if($saveorder){
					if(isset($params['web_relect']['virtual_price_set'][$web_price_code[0]])){
						unset($search_extra['web_rooms']);
						$search_extra['lvl_list'] = array($params['web_relect']['virtual_price_set'][$web_price_code[0]]);
					}
				}
				
				//查询实时房态
				$_list = $this->serv_api->getRoomState($pms_set['hotel_web_id'], $startdate, $enddate, $search_extra, $func_data);
				if(!empty($_list[$pms_set['hotel_web_id']])){
					$cache_data = [];
					$web_rate_result = $_list[$pms_set['hotel_web_id']];
					
					//房量
					$web_qty_list = [];
					is_array(current($web_rate_result['RoomCounts']['RoomCount'])) or $web_rate_result['RoomCounts']['RoomCount'] = array($web_rate_result['RoomCounts']['RoomCount']);
					foreach($web_rate_result['RoomCounts']['RoomCount'] as $v){
						$daily_res = $v['DetailCounts']['int'];
						is_array($daily_res) or $daily_res = [$daily_res];
						$break = false;
						for($i = 0; $i < $countday; $i++){
							$qty_arr = [];
							if(empty($daily_res[$i])){
								$break = true;
								break;
							}
							$qty_arr[date('Ymd', strtotime($sdate) + 86400 * $i)] = $daily_res[$i];
							
						}
						if($break){
							continue;
						}
						$web_qty_list[$v['RoomTypeId']] = $qty_arr;
					}
					
					is_array(current($web_rate_result['DetailPrices']['RoomPrice'])) or $web_rate_result['DetailPrices']['RoomPrice'] = array($web_rate_result['DetailPrices']['RoomPrice']);
					//每日价格
					foreach($web_rate_result['DetailPrices']['RoomPrice'] as $v){
						if(!array_key_exists($v['RoomTypeId'], $web_qty_list)){
							continue;
						}
						$_rate = $v['Description'];
						
						if(!empty($v['RoomType']['Virtual'])){
							//虚拟房型时
						}
						
						$qty_arr = $web_qty_list[$v['RoomTypeId']];
						
						list($in_date, $in_time) = explode('T', $v['Date'], 2);
						$in_date = date('Ymd', strtotime($in_date));
						
						$daily_list = [
							'price'       => $v['ActualPrice'],
							'quantity'    => $qty_arr[$in_date],
							'orign_price' => $v['OrignPrice'],
						];
						
						//按格式填充数组【日期】【房型】【价格代码】
						$cache_data[$in_date][$v['RoomTypeId']]['name'] = $v['RoomType']['RoomTypeName'];
						if(isset($v['RoomType']['PhysicalRoomTypeId'])){
							$cache_data[$in_date][$v['RoomTypeId']]['physical_code'] = $v['RoomType']['PhysicalRoomTypeId'];
						}
						
						$cache_data[$in_date][$v['RoomTypeId']]['rates'][$_rate] = [
							'rate'  => [
								'code'        => $_rate,
								'name'        => $_rate,
								'orign_price' => $v['OrignPrice'],
								'virtual'     => $v['RoomType']['Virtual'], //是否虚拟房型
							],
							'daily' => $daily_list
						];
						
					}
					
					foreach($cache_data as $k => $v){
						//设置本地缓存
						if(!$saveorder){
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
				}
			}else{
				//读取本地缓存数据--开始
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
			
			if($promo_rate_set){
				//促销活动
				//判断本地缓存中每日都有数据
				$promo_exists = true;
				$promo_rk_temp = $pms_set['inter_id'] . ':price_lite:' . $params['idents']['hotel_id'] . ':' . $params['member_level'] . ':';
				
				for($start = $sdate; $start < $edate;){
					$rk = $promo_rk_temp . $start;
					if(!$redis->exists($rk)){
						$promo_exists = false;
						break;
					}
					$start = date('Ymd', strtotime($start) + 86400);
				}
				if(!$promo_exists || !empty($params['condit']['recache']) || !empty($normal_recache)){
					if($this->uri->segment(3) != 'saveorder'){
						for($start = $sdate; $start < $edate;){
							$rk = $rk_temp . $start;
							//删除缓存数据，防止接口没有数据返回时，本地仍有缓存
							$redis->del($rk);
							$start = date('Ymd', strtotime($start) + 86400);
						}
					}
					
					$this->load->model('api/Vmember_model', 'vm');
					$member_info = $this->vm->getUserInfo($params['condit']['openid'], $pms_set['inter_id']);
					
					$promo_extra = array(
						'pms_user_id' => $member_info['pms_user_id'],
						'recache'     => $promo_recache,
						'web_rooms'   => array_keys($params['web_rids']),
					);
					
					$promotion_result = $this->serv_api->getPromotion($pms_set['hotel_web_id'], $sdate, $edate, $promo_extra, $func_data);
				}else{
				
				}
			}
		}
		
		
		$pms_state = [];
		$valid_state = [];
		$exprice = [];
		
		if($web_room_rate){
			foreach($web_room_rate as $web_room => $v){
				$real_web_room = $web_room;  //实际的房型代码
				if(!empty($v['physical_code'])){
					$web_room = $v['physical_code'];         //若是虚拟房型代码时，取其物理房型的代码
				}
				//是否存在物理
				if(!array_key_exists($web_room, $params['web_rids'])){
					continue;
				}
				$pms_state[$web_room] = [];
				foreach($v['rates'] as $web_rate => $t){
					if(($t['virtual'] && !isset($params['web_reflect']['virtual_price_set'][$web_rate])) || (isset($params['web_reflect']['virtual_price_set'][$web_rate]) && !$t['virtual'])){
						continue;
					}
					
					$pms_state[$web_room][$web_rate]['price_name'] = $t['name'];
					$pms_state[$web_room][$web_rate]['price_type'] = 'pms';
					$pms_state[$web_room][$web_rate]['price_code'] = $web_rate;
					$pms_state[$web_room][$web_rate]['extra_info'] = [
						'type'         => 'code',
						'pms_code'     => $web_rate,
						'orign_price'  => $t['orign_price'],
						'is_clock'     => !empty($t['is_clock']),
						'promotion_id' => isset($t['promotion_id']) ? $t['promotion_id'] : '',
						'virtual'      => !empty($t['virtual']),
						'webser_id'    => $real_web_room,//虚拟房型时下单传虚拟房型的房型代码
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
										$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
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
			$bill_id = $res['bill_id'];
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
			
			/*if($order['point_favour']){
				$config_data = $this->Hotel_config_model->get_hotel_config($inter_id, 'HOTEL', $order ['hotel_id'], array(
					'PMS_BONUS_COMSUME_WAY',
					'POINT_PAY_WITH_BILL',
				));
				if(!empty($config_data['PMS_POINT_REDUCE_WAY']) && $config_data['PMS_POINT_REDUCE_WAY'] == 'after'){
					$point_params = ['crsNo' => $web_orderid];
					
					if(!empty($config_data['POINT_PAY_WITH_BILL'])){
						$point_params['extra'] = [
							'point_pay_with_bill' => 1,
							'FeeType'             => 'A',
							'Memo'                => '积分部分抵扣',
							'SubItemType'         => $pms_auth['sub_item_type']['point'],
							'BillItemType'        => 'Credit',
							'BillId'              => $bill_id,
							'HotelId'             => $pms_set['hotel_web_id'],
							'Amount'              => $order['point_favour']
						];
					}
					
					if(!$this->Member_model->consum_point($order['inter_id'], $order['orderid'], $order['openid'], $order['point_used_amount'], $point_params)){
						$this->Order_model->update_point_reduce($inter_id, $order['orderid'], 3);
						$info = $this->Order_model->cancel_order($inter_id, array(
							'only_openid'   => $order['openid'],
							'member_no'     => '',
							'orderid'       => $order ['orderid'],
							'cancel_status' => 5,
							'no_tmpmsg'     => 1,
							'delete'        => 2,
							'idetail'       => array(
								'i'
							)
						));
						return array(
							's'      => 0,
							'errmsg' => '积分扣减失败'
						);
					}else{
						$has_paid = 1;
					}
				}
			}*/
			if($order['paytype'] == 'point'){
				$config_data = $this->Hotel_config_model->get_hotel_config($inter_id, 'HOTEL', $order ['hotel_id'], array(
					'PMS_POINT_REDUCE_WAY',
					'POINT_PAY_WITH_BILL',
				));
				if(!empty($config_data['PMS_POINT_REDUCE_WAY']) && $config_data['PMS_POINT_REDUCE_WAY'] == 'after'){
					$point_params = ['crsNo' => $web_orderid];
					
					if(!empty($config_data['POINT_PAY_WITH_BILL'])){
						$point_params['extra'] = [
							'point_pay_with_bill' => 1,
							'FeeType'             => 'A',
							'Memo'                => '积分支付订单。',
							'SubItemType'         => $pms_auth['sub_item_type'][$order['paytype']],
							'BillItemType'        => 'Credit',
							'BillId'              => $bill_id,
							'HotelId'             => $pms_set['hotel_web_id'],
							'Amount'              => $order['price']
						];
					}
					
					if(!$this->Member_model->consum_point($order['inter_id'], $order['orderid'], $order['openid'], $order['point_used_amount'], $point_params)){
						$this->Order_model->update_point_reduce($inter_id, $order['orderid'], 3);
						$info = $this->Order_model->cancel_order($inter_id, array(
							'only_openid'   => $order['openid'],
							'member_no'     => '',
							'orderid'       => $order ['orderid'],
							'cancel_status' => 5,
							'no_tmpmsg'     => 1,
							'delete'        => 2,
							'idetail'       => array(
								'i'
							)
						));
						return array(
							's'      => 0,
							'errmsg' => '积分扣减失败'
						);
					}else{
						$has_paid = 1;
					}
				}
			}elseif($order['paytype'] == 'balance'){
				$config_data = $this->Hotel_config_model->get_hotel_config($inter_id, 'HOTEL', $order ['hotel_id'], array(
					'PMS_BANCLANCE_REDUCE_WAY',
					'BALANCE_PAY_WITH_BILL'
				));
				if(!empty($config_data ['PMS_BANCLANCE_REDUCE_WAY']) && $config_data ['PMS_BANCLANCE_REDUCE_WAY'] == 'after'){
					$sub_orders = [];
					foreach($order['order_details'] as $v){
						$sub_orders[$v['sub_id']] = $v['iprice'];
					}
					$balance_param = ['crsNo' => $web_orderid,];
					if(!empty($config_data['POINT_PAY_WITH_BILL'])){
						$balance_param['extra'] = [
							'balance_pay_with_bill' => 1,
							'FeeType'               => 'A',
							'Memo'                  => '储值支付订单',
							'SubItemType'           => $pms_auth['sub_item_type'][$order['paytype']],
							'BillItemType'          => 'Credit',
							'BillId'                => $bill_id,
							'HotelId'               => $pms_set['hotel_web_id'],
							'Amount'                => $order['price']
						];
					}
					$balance_param['extra']['orders'] = $sub_orders;
					if(!$this->Member_model->reduce_balance($inter_id, $order['openid'], $order['price'], $order['orderid'], '订房订单余额支付', $balance_param, $order)){
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
			
			if(!empty($params['trans_no'])){
				$this->add_web_bill($web_orderid, $order, $pms_set, $params['trans_no']);
			}
			
			return array('s' => 1, 'upstatus' => $upstatus, 'has_paid' => $has_paid);
		}
	}
	
	function order_reserve($order, $pms_set, $params = array()){
		$this->apiInit($pms_set);
		$startdate = date('Y-m-d', strtotime($order['startdate']));
		$enddate = date('Y-m-d', strtotime($order['enddate']));
		
		$new_startdate = $startdate;
		
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		
		//判断是否预订凌晨房，入住时间非当天，而且离店时间为当天的
		$is_bd = false;
		if(strtotime($new_startdate) < strtotime(date('Y-m-d'))){
			if($enddate == date('Y-m-d')){
				//离店时间为当天的，则认为是凌晨房
				$new_startdate = date('Y-m-d');
				$is_bd = true;
			}else{
				//其他情况提示用户重新选择日期
				return [
					'result' => false,
					'errmsg' => '预订凌晨房需要入住时间为昨天，离店时间必须是当天！',
				];
			}
		}
		
		$room_codes = json_decode($order['room_codes'], true);
		$room_codes = $room_codes [$order['first_detail'] ['room_id']];
		
		$extra_info = $room_codes['code']['extra_info'];
		
		//若extra_info里存在webser_id则取extra_id里的
		$webser_id = !empty($extra_info['webser_id']) ? $extra_info['webser_id'] : $room_codes['room']['webser_id'];
		
		if(!isset($extra_info['pms_code'])){
			return array(
				'result' => false,
				'errmsg' => '不存在价格代码',
			);
		}
		$is_clock = $extra_info['is_clock'];   //是否为时租房价
		
		$promotion_id = !empty($extra_info['promotion_id']) ? $extra_info['promotion_id'] : null; //是否为促销活动
		
		$OrderAddRequest = new OrderAddRequest();
		
		
		$this->load->model('api/Vmember_model', 'vm');
		$member = $this->vm->getUserInfo($order['openid'], $order['inter_id']);
		
		if(!empty($pms_auth['order_with_user']) && $member['logined']){
			$OrderAddRequest->MemberId = $member['pms_user_id'];
		}
		
		$OrderAddRequest->HotelId = doubleval($pms_set['hotel_web_id']);
		$OrderAddRequest->EstimatedArriveTime = $new_startdate . ($is_bd ? 'T03:00:00' : 'T12:00:00');
		$OrderAddRequest->EstimatedDepartureTime = $enddate . 'T12:00:00';
		
		$OrderAddRequest->Locked = false;
		
		if($order['coupon_favour'] > 0 || $order['point_favour'] > 0)
			$OrderAddRequest->IsExtenalPrice = true;
		
		if($order['paytype'] != 'daofu'){
			$OrderAddRequest->PrePaymentTypeId = 'Full';
		}
		//入住类型,若是时租房类型，则将入住类型改为时租类型
		if($is_clock){
			$OrderAddRequest->CheckinType = $extra_info['pms_code'];
			$hour=preg_replace('/\D/s', '', $extra_info['pms_code']);
			$OrderAddRequest->EstimatedArriveTime = date('Y-m-d', strtotime($order['starttime'])) . 'T' . date('H:i:s', strtotime($order['starttime']));
			$OrderAddRequest->EstimatedDepartureTime = date('Y-m-d', strtotime($new_startdate) + 86400) . 'T' . date('H:i:s', strtotime($order['starttime'])+($hour*3600));
		}
		
		$guest1 = new Guest();
		$guest1->Name = $order['name'];
		$Guests[] = $guest1;
		$OrderAddRequest->Guests = $Guests;
		
		$liaison1 = new Liaison();
		$liaison1->Name = $order['name'];
		$liaison1->Mobile = $order['tel'];
		$Liaison[] = $liaison1;
		$OrderAddRequest->Liaisons = $Liaison;
		$dates = array();
		
		if($is_bd){
			$dates[] = $startdate;
		}elseif($is_clock){
			$dates[] = $new_startdate;
		}else{
			for($tmpdate = $order['startdate']; $tmpdate < $order['enddate'];){
				$dates[] = $tmpdate;
				$tmpdate = date('Ymd', strtotime($tmpdate) + 86400);
			}
		}
		
		$real_price = explode(',', $order['first_detail']['real_allprice']);
		
		$RoomPrice = array();
		//每日房价
		for($i = 0; $i < count($dates); $i++){
			$rprice = new RoomPrice();
			$rprice->Date = date('Y-m-d', strtotime($dates[$i])) . 'T00:00:00';
			
			$rprice->OrignPrice = floatval($extra_info['orign_price']);
			$rprice->ActualPrice = floatval($real_price[$i]);
			$rprice->RoomTypeId = $webser_id;
			$RoomPrice[] = $rprice;
		}
		
		$roomplan = new RoomPlan();
		$roomplan->RoomTypeId = $webser_id;
		$roomplan->Amount = $order['roomnums'];
		$roomplan->Price = $RoomPrice;
		$roomPlans[] = $roomplan;
		
		$OrderAddRequest->RoomPlans = $roomPlans;
		
		$remark = '';
		if(!empty($params['trans_no'])){
			$remark .= '该订单已通过微信支付！';
		}
		
		if($order['paytype'] == 'balance'){
			$remark .= '订单使用储值支付。';
		}
		
		if($order['coupon_favour'] > 0){
			$remark .= '使用优惠券:' . $order['coupon_favour'] . '元';
		}
		if($order['point_favour'] > 0){
			$remark .= '积分扣减：' . $order['point_favour'] . '元。';
		}
		
		if($remark){
			$OrderAddRequest->PublicMemo = $remark;
		}
		
		if($promotion_id){
			$OrderAddRequest->PromotionId = doubleval($promotion_id);
		}
		
		$sign_arr = obj2array($OrderAddRequest);
		$sign_arr['HotelId'] = $pms_set['hotel_web_id'];
		ksort($sign_arr, SORT_STRING);
		if($promotion_id){
			$sign_arr['PromotionId'] = $promotion_id;
		}
		
		$sign_data = ['orderAddRequest' => $sign_arr];
		$data = ['orderAddRequest' => $OrderAddRequest];
		
		$func_data = ['orderid' => $order['orderid']];
		$res = $this->serv_api->submitOrder($data, $sign_data, $func_data);
		return $res;
	}
	
	public function update_web_order($inter_id, $order, $pms_set){
		$web_orderid = $order['web_orderid'];
		$this->apiInit($pms_set);
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$func_data = ['orderid' => $order['orderid']];
		$web_order = $this->serv_api->queryOrder($pms_set['hotel_web_id'], $web_orderid, $func_data);
		
		$istatus = -1;
		
		if(!empty($web_order)){
			$web_status = $web_order['OrderStatus'];
			$status_arr = $this->pms_enum('status');
			$this->load->model('hotel/Order_model');
			$status = $status_arr[$web_status];
			
			// 未确认单先确认
			if($status != 0 && $order['status'] == 0){
				$this->change_order_status($inter_id, $order['orderid'], 1);
				$this->Order_model->handle_order($inter_id, $order['orderid'], 1, '', array(
					'no_tmpmsg' => 1
				));
			}
			
			if($web_status == 'InProgress' || $web_status == 'Finish'){
				$checkin_list = $this->serv_api->queryCheckIn($pms_set['hotel_web_id'], $web_orderid, $func_data);
				
				if(!empty($checkin_list[$web_orderid])){
					//本地订单列表是否已更新过入住ID
					$local_items = array();
					$local_noitem = array();
					foreach($order ['order_details'] as $od){
						if(!empty($od['webs_orderid'])){
							$local_items[$od['webs_orderid']] = $od;
						}else{
							$local_noitem[] = $od;
						}
					}
					$i = 0;
					foreach($checkin_list[$web_orderid] as $k => $v){
						//判断该入住ID是否已存在本地订单中
						$updata = array();
						if(array_key_exists($k, $local_items)){
							$od = $local_items[$k];
						}else{
							//不存在本地订单中
							$od = $local_noitem[$i];
							
							$this->db->where(array('id' => (int)$od['sub_id']))->update('hotel_order_items', array('webs_orderid' => $k));
							
							$i++;
						}
						$wstatus = $v['CheckinStatus'];//订单状态
						$istatus = $status_arr[$wstatus];
						if($od ['istatus'] == 4 && $istatus == 5){
							$istatus = 4;
						}
						
						list($s_day, $s_time) = explode('T', $v['ActualArriveTime'], 2);
						//实际入住时间
						$web_start = date('Ymd', strtotime($s_day));
						if($v['ActualDepatureTime']){
							//实际离店时间
							list($e_day, $e_time) = explode('T', $v['ActualDepatureTime'], 2);
						}else{
							list($e_day, $e_time) = explode('T', $v['EstimatedDepartureTime'], 2);
						}
						
						$web_end = date('Ymd', strtotime($e_day));
						if($order['price_type'] != 'athour'){
							$web_end = $web_end == $web_start ? date('Ymd', strtotime('+ 1 day', strtotime($web_start))) : $web_end;
						}
						//判断实际入住时间，订单记录的入住时间
						$ori_day_diff = get_room_night($od['startdate'], $od['enddate'], 'ceil', $od);//至少有一个间夜
						$web_day_diff = get_room_night($web_start, $web_end, 'ceil');//至少有一个间夜
						$day_diff = $web_day_diff - $ori_day_diff;
						
						$updata ['startdate'] = $web_start;
						$updata ['enddate'] = $web_end;
						
						if($day_diff != 0 || $web_start != $od ['startdate'] || $web_end != $od ['enddate']){
							$updata ['no_check_date'] = 1;
						}
						
						if(3 == $istatus){//离店，计算最新房费
							$bill_info = $this->serv_api->getOrderBillDetail($pms_set['hotel_web_id'], $v['BillId'], $func_data);
							
							$fang_fee = ['D1000', 'D1001', 'D1002', '1003', 'D1004', 'D1005', 'D1020'];
							if($bill_info){
								$new_price = 0;
								foreach($bill_info as $t){
									if(in_array($t['DebitType'], $fang_fee)){//房费类型
										$new_price += $t['Amount'];
									}
								}
								
								if($new_price >= 0 && $new_price != $od['iprice']){
									$updata['no_check_date'] = 1;
									$updata['new_price'] = $new_price;
								}
							}
						}
						
						if($istatus != $od ['istatus']){
							$updata ['istatus'] = $istatus;
						}
						
						if(!empty ($updata)){
							$this->Order_model->update_order_item($inter_id, $order ['orderid'], $od ['sub_id'], $updata);
						}
						
					}
					
				}else{
					if($web_order == 'Finish'){
						$status = 7;//订单完成但没有入住信息
						$this->Order_model->update_order_status($inter_id, $order['orderid'], $status, $order['openid']);
					}
				}
			}else{
				if($order ['status'] == 4 && $status == 5){
					$status = 4;
				}
				$istatus = $status;
				
				if($status != $order['status']){
					$this->Order_model->update_order_status($inter_id, $order['orderid'], $status, $order['openid']);
				}
			}
			
		}
		return $istatus;
	}
	
	public function cancel_order_web($inter_id, $order, $pms_set = array(), $reason = '用户取消'){
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
		$res = $this->serv_api->cancelOrder($pms_set['hotel_web_id'], $order['web_orderid'], '取消订单', $func_data);
		
		if($res){
			return ['s' => 1, 'errmsg' => '已取消'];
		}
		return ['s' => 0, ',errmsg' => '取消失败'];
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
		
		$func_data = ['orderid' => $order['orderid'], 'web_orderid' => $web_orderid];
		//查询网络订单是否存在
		$web_order = $this->serv_api->queryOrder($pms_set['hotel_web_id'], $web_orderid, $func_data);
		if(!$web_order){
			$this->db->where(array(
				'orderid'  => $order ['orderid'],
				'inter_id' => $order ['inter_id']
			));
			$this->db->update('hotel_order_additions', array(
				'web_paid' => $web_paid
			));
			return false;
		}
		
		$room_codes = json_decode($order['room_codes'], true);
		$codes_arr = $room_codes[$order['first_detail']['room_id']];
		
		//添加在线支付
		if(empty($codes_arr['payment_id'])){
			$payment_id = $this->serv_api->addOnlinePayment($pms_set['hotel_web_id'], $web_order['BillId'], $order['price'], $pms_auth['paytype'][$order['paytype']], $func_data);
			if($payment_id){
				$room_codes[$order['first_detail']['room_id']]['payment_id'] = $payment_id;
				$this->db->where([
					'orderid'  => $order['orderid'],
					'inter_id' => $order['inter_id']
				])->update('hotel_order_additions', ['room_codes' => json_encode($room_codes)]);
			}
		}else{
			$payment_id = $codes_arr['payment_id'];
		}
		
		if($payment_id){
			//修改在线支付
			$upd_res = $this->serv_api->updateOnlinePayment($pms_set['hotel_web_id'], $payment_id, $order['price'], $trans_no, $order['openid'], $func_data);
			if($upd_res){
				$this->load->model('api/Vmember_model', 'vm');
				$pms_user_id = $this->vm->getPmsUserId($order['openid'], $order['inter_id']);
				$bill_extra = [
					'bill_id'          => $web_order['BillId'],
					'sub_item_type'    => $pms_auth['sub_item_type'][$order['paytype']],
					'bill_item_type'   => 'Credit',
					'payment_fee_type' => '酒店预订费用',
					'remark'           => '支付订单入账',
					'payment_feetype'  => 'A',
				    'pms_user_id'=>$pms_user_id
				];
				
				//入账
				if($this->serv_api->addPayment($pms_set['hotel_web_id'], $payment_id, $order['price'], $bill_extra, $func_data)){
					$web_paid = 1;
				}
			}
		}
		
		$this->db->where(array(
			'orderid'  => $order ['orderid'],
			'inter_id' => $order ['inter_id']
		));
		$this->db->update('hotel_order_additions', array(
			'web_paid' => $web_paid
		));
		
		return $web_paid == 1;
	}
	
	
	//判断订单是否能支付
	function check_order_canpay($order, $pms_set){
		$this->apiInit($pms_set);
		$web_orderid = $order['web_orderid'];
		$web_order = $this->serv_api->queryOrder($pms_set['hotel_web_id'], $web_orderid);
		if(!empty($web_order)){
			$web_status = $web_order['OrderStatus'];
			$status_arr = $this->pms_enum('status');
			$status = $status_arr[$web_status];
		}
		if(isset($status) && ($status == 1 || $status == 0)){//订单确认
			return true;
		}else{
			return false;
		}
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
	
	
	protected function pms_enum($type = '', $key = ''){
		$arr = [];
		switch($type){
			case 'status':
				//订单状态,0预订，1确认，2入住，3离店，4用户取消，5酒店取消,6酒店删除，7异常，8未到，9待支付
				$arr = array(
					'3'          => 3,
					'1'          => 1,
					'2'          => 8,
					'0'          => 5,
					'InProgress' => 1,
					'Finish'     => 3,
					'NoShow'     => 8,
					'Cancel'     => 5,
					'I'          => 2,
					'O'          => 3,
					'S'          => 3
				);
				break;
		}
		
		if($key === ''){
			return $arr;
		}
		
		return isset($arr[$key]) ? $arr[$key] : null;
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

class Beyondh2Api{
	private $inter_id;
	private $key;
	private $signkey;
	private $base_url;
	
	const HOTEL_WSDL = 'Order/HotelService.svc?wsdl';
	const HOTEL_LOCATION = 'Order/HotelService.svc/Basic';
	const ORDER_WSDL = 'Order/OrderService.svc?wsdl';
	const ORDER_LOCATION = 'Order/OrderService.svc/Basic';
	const CRM_WSDL = 'Crm/CrmService.svc?wsdl';
	const CRM_LOCATION = 'Crm/CrmService.svc/Basic';
	const BILL_WSDL = 'Bill/BillService.svc?wsdl';
	const BILL_LOCATION = 'Bill/BillService.svc/Basic';
	
	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->helper('common');
		$this->CI->load->model('common/Webservice_model');
	}
	
	public function setPmsAuth($config){
		$this->inter_id = $config['inter_id'];
		$this->base_url = $config['base_url'];
		$this->key = $config['key'];
		$this->signkey = $config['signkey'];
		$this->base_url = $config['base_url'];
	}
	
	public function getRoomState($hotel_web_id, $sdate, $edate, $extra = [], $func_data = []){
		$sdate = date('Y-m-d', strtotime($sdate)) . 'T12:00:00';
		$edate = date('Y-m-d', strtotime($edate)) . 'T12:00:00';
		
		$hotelSearchRequest = new HotelSearchRequest();
		if(!empty($extra['only_physical'])){
			$hotelSearchRequest->PhysicalRoomTypeOnly = $extra['only_physical'];
		}
		
		if(!empty($extra['web_rooms'])){
			$hotelSearchRequest->RoomTypeIds = $extra['web_rooms'];
		}
		$hotelSearchRequest->OnlyOpenedHotel = true;
		$hotelSearchRequest->HotelIds = [doubleval($hotel_web_id)];
		
		$hotelSearchRequest->HotelName = '';
		$hotelSearchRequest->CityId = '';
		$hotelSearchRequest->EndDate = $edate;
		$hotelSearchRequest->BeginDate = $sdate;
		$hotelSearchRequest->PageSize = 10;
		$hotelSearchRequest->PageIndex = 1;
		
		if(!empty($extra['lvl_list'])){
			$hotelSearchRequest->MemberLevels = $extra['lvl_list'];
		}
		
		$sign_arr = obj2array($hotelSearchRequest);
		$sign_arr['HotelIds'] = [$hotel_web_id];
		
		ksort($sign_arr, SORT_STRING);
		
		$sign_data = ['searchRequest' => $sign_arr];
		$data = ['searchRequest' => $hotelSearchRequest];
		
		$soap_params = [
			'uri'  => self::HOTEL_WSDL,
			'loca' => self::HOTEL_LOCATION,
			'func' => 'Search',
		];
		
		$post_params = [
			'data'      => $data,
			'sign_data' => $sign_data,
		];
		
		$obj = $this->postService($soap_params, $post_params, 0, $func_data);
		
		$result = [];
		if($obj->Success && !empty($obj->Content->HotelSearchResponse)){
			$s = obj2array($obj->Content->HotelSearchResponse);
			
			is_array(current($s)) or $s = [$s];
			foreach($s as $v){
				$v['HotelId'] = number_format($v['HotelId'], 0, '', '');
				$result[$v['HotelId']] = $v;
			}
		}
		
		return $result;
	}
	
	public function getHourPrice($hotel_web_id, $sdate, $lvl_list = [], $func_data = []){
		$sdate = date('Y-m-d', strtotime($sdate)) . 'T06:00:00';
		$edate = date('Y-m-d', strtotime($sdate)) . "T22:00:00";
		
		$list = [];
		
		$HourRentPriceRequest = new HourRentPriceRequest ();
		$HourRentPriceRequest->HotelId = doubleval($hotel_web_id);
		$HourRentPriceRequest->EstimatedArriveTime = $sdate;
		$HourRentPriceRequest->EstimatedDepartureTime = $edate;
		$HourRentPriceRequest->MemberLevels = $lvl_list;
		
		$sign_arr = obj2array($HourRentPriceRequest);
		$sign_arr['HotelId'] = $hotel_web_id;
		ksort($sign_arr, SORT_STRING);
		
		$sign_data = ['hourRentMemberPriceRequest' => $sign_arr];
		$data = ['hourRentMemberPriceRequest' => $HourRentPriceRequest];
		
		$soap_params = [
			'uri'  => self::HOTEL_WSDL,
			'loca' => self::HOTEL_LOCATION,
			'func' => 'GetHourRentMemberPrice',
		];
		
		$post_params = [
			'data'      => $data,
			'sign_data' => $sign_data,
		];
		$obj = $this->postService($soap_params, $post_params, 0, $func_data);
		
		$result = [];
		if($obj->Success && !empty($obj->Content->HourRentRoomPrice)){
			$result = obj2array($obj->Content->HourRentRoomPrice);
			if(isset($result['CheckinType'])){
				$result = [$result];
			}
		}
		
		return $result;
		
	}
	
	public function getPromotion($hotel_web_id, $sdate, $edate, $extra = [], $func_data = []){
		$sdate = date('Y-m-d', strtotime($sdate));
		$edate = date('Y-m-d', strtotime($edate));
		
		$OrderAddRequest = new OrderAddRequest();
		$OrderAddRequest->MemberId = $extra['pms_user_id'];
		$OrderAddRequest->HotelId = doubleval($hotel_web_id);
		$OrderAddRequest->EstimatedArriveTime = $sdate;
		$OrderAddRequest->EstimatedDepartureTime = $edate;
		
		//房型数据
		$roomPlans = [];
		foreach($extra['web_rooms'] as $v){
			$roomplan = new RoomPlan();
			$roomplan->RoomTypeId = $v;
			$roomplan->Price = [];
			$roomplan->Amount = 1;
			$roomPlans[] = $roomplan;
		}
		$result = [];
		
		if(!empty($roomPlans)){
			$OrderAddRequest->RoomPlans = $roomPlans;
			
			$sign_arr = obj2array($OrderAddRequest);
			$sign_arr['HotelId'] = $hotel_web_id;
			ksort($sign_arr, SORT_STRING);
			
			$sign_data = ['orderAddRequest' => $sign_arr];
			$data = ['orderAddRequest' => $OrderAddRequest];
			
			$soap_params = [
				'uri'  => self::ORDER_WSDL,
				'loca' => self::ORDER_LOCATION,
				'func' => 'GetAvailablePromotionPrices',
			];
			
			$post_params = [
				'data'      => $data,
				'sign_data' => $sign_data,
			];
			
			$obj = $this->postService($soap_params, $post_params, 0, $func_data);
			
			if($obj->Success && !empty($obj->Content)){
				$result = obj2array($obj->Content);
			}
		}
		return $result;
	}
	
	public function queryOrder($hotel_web_id, $web_orderid, $func_data = []){
		$data = ['orderId' => doubleval($web_orderid), 'hotelId' => doubleval($hotel_web_id)];
		$sign_data = ['orderId' => $web_orderid, 'hotelId' => $hotel_web_id];
		
		$soap_params = [
			'uri'  => self::ORDER_WSDL,
			'loca' => self::ORDER_LOCATION,
			'func' => 'GetOrder',
		];
		
		$post_params = [
			'data'      => $data,
			'sign_data' => $sign_data,
		];
		
		$obj = $this->postService($soap_params, $post_params, 0, $func_data);
		
		if($obj->Success && !empty($obj->Content)){
			$result = obj2array($obj->Content);
			$result['OrderId'] = number_format($result['OrderId'], 0, '', '');
			$result['BillId'] = number_format($result['BillId'], 0, '', '');
		}
		return $result;
	}
	
	public function submitOrder($post_data, $sign_data, $func_data = []){
		$soap_params = [
			'uri'  => self::ORDER_WSDL,
			'loca' => self::ORDER_LOCATION,
			'func' => 'AddOrder',
		];
		
		$post_params = [
			'data'      => $post_data,
			'sign_data' => $sign_data,
		];
		
		$obj = $this->postService($soap_params, $post_params, 0, $func_data);
		
		if($obj->Success && !empty($obj->Content)){
			return [
				'result'      => true,
				'web_orderid' => number_format($obj->Content->OrderId, 0, '', ''),
				'bill_id'     => number_format($obj->Content->BillId, 0, '', ''),
			];
		}else{
			return [
				'result' => false,
				'errmsg' => !empty($obj->ErrorMessage) ? $obj->ErrorMessage : '',
			];
		}
	}
	
	public function queryCheckIn($hotel_web_id, $web_orderid, $func_data = []){
		is_array($web_orderid) or $web_orderid = [$web_orderid];
		$cki_req = new CheckinSearchRequest();
		
		$cki_req->HotelId = doubleval($hotel_web_id);
		$cki_req->OrderIds = array_map('doubleval', $web_orderid);
		
		$sign_arr = obj2array($cki_req);
		$sign_arr['HotelId'] = $hotel_web_id;
		$sign_arr['OrderIds'] = $web_orderid;
		$sign_data = ['checkinSearchRequest' => $sign_arr];
		$data = ['checkinSearchRequest' => $cki_req];
		
		$soap_params = [
			'uri'  => self::ORDER_WSDL,
			'loca' => self::ORDER_LOCATION,
			'func' => 'SearchCheckin',
		];
		
		$post_params = [
			'data'      => $data,
			'sign_data' => $sign_data,
		];
		
		$result = [];
		
		$obj = $this->postService($soap_params, $post_params, 0, $func_data);
		if($obj->Success && !empty($obj->Content->CheckinResponse)){
			$s = obj2array($obj->Content->CheckinResponse);
			is_array(current($s)) or $s = [$s];
			foreach($s as $v){
				$v['OrderId'] = number_format($v['OrderId'], 0, '', '');
				$v['CheckinId'] = number_format($v['CheckinId'], 0, '', '');
				$v['BillId'] = number_format($v['BillId'], 0, '', '');
				$result[$v['OrderId']][$v['CheckinId']] = $v;
			}
		}
		return $result;
		
	}
	
	public function getOrderBillDetail($hotel_web_id, $bill_id, $func_data = []){
		
		$bill_req = new BillDetailRequest();
		$bill_req->BillId = doubleval($bill_id);
		$bill_req->HotelId = doubleval($hotel_web_id);
		
		$sign_arr = obj2array($bill_req);
		$sign_arr['BillId'] = $bill_id;
		$sign_arr['HotelId'] = $hotel_web_id;
		$sign_data = ['billDetailRequest' => $sign_arr];
		$data = ['billDetailRequest' => $bill_req];
		
		$soap_params = [
			'uri'  => self::BILL_WSDL,
			'loca' => self::BILL_LOCATION,
			'func' => 'GetBillDetails',
		];
		
		$post_params = [
			'data'      => $data,
			'sign_data' => $sign_data,
		];
		
		$result = [];
		
		$obj = $this->postService($soap_params, $post_params, 0, $func_data);
		
		if($obj->Success && !empty($obj->Content->BillItemResponse)){
			$result = obj2array($obj->Content->BillItemResponse);
			is_array(current($result)) or $result = [$result];
		}
		return $result;
		
	}
	
	public function cancelOrder($hotel_web_id, $web_orderid, $reason = '', $func_data = []){
		$cancel = new OrderCancelRequest();
		$cancel->HotelId = doubleval($hotel_web_id);
		$cancel->OrderId = doubleval($web_orderid);
		$cancel->Reason = $reason;
		
		$sign_arr = obj2array($cancel);
		
		$sign_arr['HotelId'] = $hotel_web_id;
		$sign_arr['OrderId'] = $web_orderid;
		ksort($sign_arr, SORT_STRING);
		$sign_data = array('orderCancelRequest' => $sign_arr);
		$data = array('orderCancelRequest' => $cancel);
		
		$soap_params = [
			'uri'  => self::ORDER_WSDL,
			'loca' => self::ORDER_LOCATION,
			'func' => 'CancelOrder',
		];
		
		$post_params = [
			'data'      => $data,
			'sign_data' => $sign_data,
		];
		
		$obj = $this->postService($soap_params, $post_params, 0, $func_data);
		if($obj->Success){
			return true;
		}
		return false;
		
	}
	
	public function addOnlinePayment($hotel_web_id, $bill_id, $price, $pay_type, $func_data = []){
		$onlineReq = new OnlinePaymentRequest();
		$onlineReq->HotelId = doubleval($hotel_web_id);
		$onlineReq->BillId = doubleval($bill_id);
		$onlineReq->PayType = $pay_type;
		$onlineReq->Amount = floatval($price);
		
		$sign_arr = obj2array($onlineReq);
		ksort($sign_arr, SORT_STRING);
		$sign_arr['HotelId'] = $hotel_web_id;
		$sign_arr['BillId'] = $bill_id;
		$sign_data = ['onlinePaymentAddRequest' => $sign_arr];
		$data = ['onlinePaymentAddRequest' => $onlineReq];
		
		$soap_params = [
			'uri'  => self::BILL_WSDL,
			'loca' => self::BILL_LOCATION,
			'func' => 'AddOnlinePayment',
		];
		
		$post_params = [
			'data'      => $data,
			'sign_data' => $sign_data,
		];
		
		$obj = $this->postService($soap_params, $post_params, 0, $func_data);
		
		if($obj->Success && !empty($obj->Content)){
			return number_format($obj->Content->Id,0,'','');
		}
		return null;
	}
	
	public function updateOnlinePayment($hotel_web_id, $payment_id, $price, $trans_no, $openid = '', $func_data = []){
		$updateRequest = new PaymentUpdateReqeust();
		$updateRequest->HotelId = doubleval($hotel_web_id);
		$updateRequest->Id = doubleval($payment_id);
		$updateRequest->TransctionId = $trans_no;
		$updateRequest->PayAmount = floatval($price);
		$updateRequest->OpenId = $openid;
		$updateRequest->PayTime = date('Y-m-d') . 'T' . date('H:i:s');
		
		$sign_arr = obj2array($updateRequest);
		ksort($sign_arr, SORT_STRING);
		$sign_arr['HotelId'] = $hotel_web_id;
		$sign_arr['Id'] = $payment_id;
		$sign_data = ['onlinePaymentUpdateRequest' => $sign_arr];
		$data = ['onlinePaymentUpdateRequest' => $updateRequest];
		
		$soap_params = [
			'uri'  => self::BILL_WSDL,
			'loca' => self::BILL_LOCATION,
			'func' => 'UpdateOnlinePayment',
		];
		
		$post_params = [
			'data'      => $data,
			'sign_data' => $sign_data,
		];
		
		$obj = $this->postService($soap_params, $post_params, 0, $func_data);
		
		if($obj->Success && !empty($obj->Content)){
			return true;
		}
		return false;
		
	}
	
	/**
	 * 入账
	 * @param $hotel_web_id
	 * @param $payment_id
	 * @param $price
	 * @param array $extra
	 * [
	 *  pms_user_id=>会员的PMS会员ID
	 *  amount=>扣除的金额【储值，积分】不传时与price同值，
	 *  payment_feetype=>费用类型【A】
	 *  bill_id=>帐套ID，下单时返回，查询PMS订单信息时也有返回
	 *  bill_item_type=>财务类型【Credit】
	 *  sub_item_type=>Credit或Debit类型
	 *  remark=>备注
	 * ]
	 * @param array $func_data
	 * @return bool
	 */
	public function addPayment($hotel_web_id, $payment_id, $price, $extra = [], $func_data = []){
		$payment_req = new PaymentRequest();
		
		$payment_req->OnlinePaymentId = doubleval($payment_id);
		$payment_req->Amount = !empty($extra['amount']) ? $extra['amount'] : $price;
		
		if(!empty($extra['pms_user_id'])){
			$payment_req->MemberId = $extra['pms_user_id'];
		}
		
		$payment_req->FeeType = $extra['payment_feetype'];
		
		$bill_req = new BillItemAddRequest();
		$bill_req->Amount = $price;
		$bill_req->BillId = doubleval($extra['bill_id']);
		$bill_req->SubItemType = $extra['sub_item_type'];
		
		$bill_req->BillItemType = $extra['bill_item_type'];
		
		$bill_req->HotelId = doubleval($hotel_web_id);
		
		$bill_req->Memo = $extra['remark'];// . '=========测试到账';
		$bill_req->PaymentRequest = $payment_req;
		
		$sign_arr = obj2array($bill_req);
		ksort($sign_arr['PaymentRequest'], SORT_STRING);
		ksort($sign_arr, SORT_STRING);
		$sign_arr['PaymentRequest']['OnlinePaymentId'] = $payment_id;
		
		$sign_arr['HotelId'] = $hotel_web_id;
		$sign_arr['BillId'] = $extra['bill_id'];
		
		$sign_data = ['billItemAddRequest' => $sign_arr];
		$data = ['billItemAddRequest' => $bill_req];
		
		$soap_params = [
			'uri'  => self::BILL_WSDL,
			'loca' => self::BILL_LOCATION,
			'func' => 'AddBillItem',
		];
		
		$post_params = [
			'data'      => $data,
			'sign_data' => $sign_data,
		];
		
		$obj = $this->postService($soap_params, $post_params, 0, $func_data);
		
		if($obj->Success && !empty($obj->Content)){
			return true;
		}
		return false;
		
	}
	
	private function postService($soap_params, $params, $expire_time = 0, $func_data = []){
		$time = time();
		
		$soap = null;
		$func_name = $soap_params['func'];
		
		$url = $this->base_url . $soap_params['uri'];
		$location = $this->base_url . $soap_params['loca'];
		
		try{
			$soap = new SoapClient($url, array(
				'location'     => $location,
				'soap_version' => SOAP_1_1,
				'encoding'     => 'utf-8'
			));
		}catch(SoapFault $e){
			$this->checkWebResult($url, '', [], $e, $time, microtime(), [], ['run_alarm' => 1]);
		}catch(Exception $e){
			$this->checkWebResult($url, '', [], $e, $time, microtime(), [], ['run_alarm' => 1]);
		}
		
		if($soap === null){
			return [];
		}
		
		if(!$expire_time){
			$expire_time = $this->create_expire_time();
		}
		
		$data = $params['data'];
		
		if(!empty($params['sign_data'])){
			$sign_data = $params['sign_data'];
		}else{
			$sign_data = $data;
		}
		
		$signature = $this->beyondh_sign($sign_data, $expire_time);
		$data['unixExpireTimestamp'] = $expire_time;
		$data['signature'] = $signature;
		
		$sign_data['unixExpireTimestamp'] = $expire_time;
		$sign_data['signature'] = $signature;
		
		$result = new stdClass();
		$result->Success = false;
		$s = null;
		$run_alarm = 0;
		if($soap !== null){
			try{
				$result = $soap->__soapCall($func_name, ["parameters" => $data]);
				
				$this->CI->Webservice_model->add_webservice_record($this->inter_id, 'beyondh', $url, [
					$func_name,
					$sign_data
				], $result, 'query_post', $time, microtime(), $this->CI->session->userdata($this->inter_id . 'openid'));
				
				$result = $result->{$func_name . 'Result'};
				
				$s = $result;
			}catch(SoapFault $e){
				$s = $e;
				$run_alarm = 1;
			}catch(Exception $e){
				$s = $e;
				$run_alarm = 1;
			}
			
			$this->checkWebResult($url, $func_name, $sign_data, $s, $time, microtime(), $func_data, ['run_alarm' => $run_alarm]);
		}
		return $result;
		
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
			if(!$receive->Success){
				$err_lv = 2;
				$err_msg = '请求失败：' . $receive->ErrorMessage;
				switch($func_name){
					case 'AddOrder':
					case 'CancelOrder':
					case 'AddOnlinePayment':
					case 'UpdateOnlinePayment':
					case 'AddBillItem':
						$err_lv = 1;
						break;
				}
			}else{
				switch($func_name){
					case 'Search':
						if(empty($receive->Content->HotelSearchResponse)){
							$err_msg = '没有返回数据';
							$err_lv = 2;
						}
						break;
					case 'GetHourRentMemberPrice':
						if(empty($receive->Content->HourRentRoomPrice)){
							$err_msg = '没有返回数据';
							$err_lv = 2;
						}
						break;
					case 'GetAvailablePromotionPrices':
						if(empty($receive->Content)){
							$err_msg = '没有返回数据';
							$err_lv = 2;
						}
						break;
				}
			}
		}
		
		$this->CI->Webservice_model->webservice_error_log($this->inter_id, 'beyondh', $err_lv, $err_msg, array(
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
					'Search'                      => '房态查询',
					'GetHourRentMemberPrice'      => '时租房价',
					'GetAvailablePromotionPrices' => '促销活动',
					'AddOrder'                    => '提交订单',
					'GetOrder'                    => '查询订单',
					'SearchCheckin'               => '查询入住',
					'CancelOrder'                 => '取消订单',
					'AddOnlinePayment'            => '添加在线支付',
					'UpdateOnlinePayment'         => '更新在线支付',
					'AddBillItem'                 => '添加到账',
				];
				break;
		}
		
		if($key === ''){
			return $arr;
		}
		return isset($arr[$key]) ? $arr[$key] : null;
	}
	
	
	private function create_expire_time(){
		return time() + 86400;
	}
	
	private function beyondh_sign($paras, $timestamp){
		$s = '';
		foreach($paras as $p){
			$a = $this->sign_string($p, 0);
			$s .= $a;
		}
		$s = strtolower($s);
		$s .= $timestamp . $this->signkey;
		$s = $this->key . ':' . md5($s);
		return $s;
	}
	
	private function sign_string($paras, $t = 0){
		$s = '';
		if(is_null($paras)){
			return '';
		}else{
			if($paras === false){
				$s .= 'false';
			}else{
				if($paras === true){
					$s .= 'true';
				}else{
					if(is_array($paras) || is_object($paras)){
						ksort($paras, SORT_STRING);
						foreach($paras as $k => $pa){
							$s .= $this->sign_string($pa);
						}
					}else{
						if(strtotime($paras) && strstr($paras, 'T') !== false && $paras != 'T'){
							$s .= date('Y-m-d H-i-s', strtotime($paras));
						}else{
							if(strstr($paras, 'E+')){
								$paras = number_format($paras, 0, '', '');
								$s .= $paras;
							}else{
								$s .= $paras;
							}
						}
					}
				}
			}
		}
		return $s;
	}
}

class HotelSearchRequest{
	public $CityId = '';
	public $DistrictId = '';
	public $HotelIds = [];
	public $HotelName = '';
	public $BeginDate = '';
	public $EndDate = '';
	public $Star = null;
	public $Longitude = null;
	public $Latitude = null;
	public $Distance = null;
	public $OrgSns = [];
	public $RoomTypeIds = [];
	public $MemberLevels = [];
	public $ServiceTags = [];
	public $PhysicalRoomTypeOnly = null;
	public $BasicInfoOnly = null;
	public $IncludeDetailCounts = true;
	public $ExcludePrices = null;
	public $ExcludeRoomCounts = null;
	public $OnlyOpenedHotel = null;
	public $PageIndex = 1;
	public $PageSize = 10;
}

class OrderAddRequest{
	public $ContractId = 0;
	public $EstimatedArriveTime = '';
	public $EstimatedDepartureTime = '';
	public $ExpireKeepTime = null;
	public $ExternalPriceName = null;
	public $Guests = null;
	public $HotelId = 0;
	public $IsExtenalPrice = null;
	public $Liaisons = [];
	public $CheckinType = 'Normal';
	public $PublicMemo = null;
	public $PrePaymentTypeId = null;
	public $PromotionId = 0;
	public $Locked = false;
	public $MemberId = null;
	public $SalerId = null;
	public $RoomPlans = null;
	public $OrderItemRequests = null;
}

class Guest{
	public $Name = '';
	public $Gender = '0';
	public $Phone = '';
	public $Mobile = '';
	public $Fax = '';
	public $Email = '';
	public $Nationality = '';
	public $TransactoinId = 0;
}

class Liaison{
	public $Name = '';
	public $Gender = '0';
	public $Phone = '';
	public $Mobile = '';
	public $Fax = '';
	public $Email = '';
	public $TransactoinId = 0;
}

class RoomPlan{
	public $RoomTypeId = '';
	public $Amount = 0;
	public $RoomType = null;
	public $TransactoinId = 0;
	public $Price = [];
}

class RoomPrice{
	public $Date = '';
	public $OrignPrice = 0;
	public $RoomCount = 0;
	public $ActualPrice = 0;
	public $RoomTypeId = 0;
	public $TransactoinId = 0;
	public $RoomType = null;
	public $Description = '';
}

class OrderItemRequest{
	public $ItemId = 0;
	public $ItemPrice = 0;
	public $ItemCount = 1;
	public $CustomerOwned = false;
	public $PersistentOnRefresh = false;
}

class RoomType{
	public $Id = '';
	public $OwnerId = 0;
	public $RoomTypeName = '';
	public $Description = '';
	public $BedType = '';
	public $HotelRoomTypeDescription = '';
	public $BedAmount = 0;
	public $Virtual = false;
	public $PhysicalRoomTypeId = '';
	public $Abbreviation = '';
	public $IsActive = false;
	public $ImageUris = '';
}

class MemberAddRequest{
	public $Address = '';
	public $BirthDay = null;
	public $CreateBy = '';
	public $CreateTime = '';//nn
	public $CreditScore = 0;
	public $Email = '';
	public $ExtCardNo = '';
	public $Fax = '';
	public $Gender = '';
	public $IDNo = '';
	public $IDType = 'C01';
	public $IsPermanentLevel = false;
	public $Level = 'P';
	public $Mobile = '';
	public $Name = '';
	public $NationCode = '';
	public $OpenId = '';
	public $ParentCardNo = '';
	public $Password = '';
	public $Phone = '';
	public $Remark = '';
	public $SourceChannel = 'J';
	public $SourceDetailCode = '';
	public $SourceType = '2';
	public $StatusCode = 'I';
	public $TransactoinId = 0;
	public $ZipCode = '';
}

class SearchAvailiableRooms{
	public $EstimatedArriveTime = '';
	public $EstimatedDepartureTime = '';
	public $FloorIds = '';
	public $HallIds = '';
	public $HotelId = 0;
	public $RoomAttributeIds = '';
	public $RoomTypeIds = [];
}

class OccupationSearchRequest{
	public $HotelId = 0;
	public $OrderId = 0;
}

class CheckinRequest{
	public $Customer = null;
	public $HotelId = 0;
	public $OrderId = 0;
	public $OccupationId = 0;
}

class CustomerRequest{
	public $CardNo = '';
	public $CardTypeId = '';
	public $Mobile = '';
	public $Name = '';
}

class OrderCancelRequest{
	public $HotelId = 0;
	public $OrderId = 0;
	public $Reason = '';
}

Class CheckinSearchRequest{
	public $CheckinIds = null;
	public $CheckinStatus = array('I', 'O', 'S');
	public $HotelId = 0;
	public $MemberCardId = '';
	public $MemberId = '';
	public $OccupationIds = null;
	public $OrderIds = null;
	public $PageIndex = 1;
	public $PageSize = 10;
	public $RoomNumbers = null;
}

Class CheckinNetDoorOpenRequest{
	public $CheckinId = 0;
	public $HotelId = 0;
}

Class BillItemAddRequest{
	public $BillId = 0;
	public $BillItemType = '';
	public $SubItemType = '';
	public $IsDeposit = false;
	public $Amount = 0;
	public $Memo = '';
	public $HotelId = '';
	public $ExternalRefId = 0;
	public $PaymentRequest = null;
}

Class PaymentRequest{
	public $ArAccountId = 0;
	public $ArAccountName = '';
	public $BankKey = '';
	public $CardNumber = '';
	public $AuthorizeId = '';
	public $BeginValidTime = null;
	public $EndValidTime = null;
	public $OnlinePaymentId = 0;
	public $Memo = '';
	public $Amount = 0;
	public $MemberId = '';
	public $FeeType = '';
}

Class PartialPayOrderBillRequest{
	public $BillId = 0;
	public $HotelId = 0;
}

Class BillDetailRequest{
	public $BillId = 0;
	public $HotelId = 0;
}

//时租房价格
class HourRentPriceRequest{
	public $HotelId = 0;        //酒店编号
	public $EstimatedArriveTime = '';            //预计到店时间
	public $EstimatedDepartureTime = '';        //预计离店时间
	public $TransactionId = 0;        //事务号
	public $MemberLevels = [];
}

class OnlinePaymentRequest{
	public $HotelId = 0;
	public $BillId = 0;
	public $RoomDetail = '';
	public $PayType = '';
	public $Amount = 0;
}

class PaymentUpdateReqeust{
	public $HotelId = 0;
	public $Id = 0;
	public $OpenId = '';
	public $BankType = '';
	public $BankBillNo = '';
	public $TransctionId = '';
	public $NotifyId = '';
	public $PayAmount = 0;
	public $PayTime = null;
	public $IsSuccess = true;
	public $BillItemId = 0;
}
