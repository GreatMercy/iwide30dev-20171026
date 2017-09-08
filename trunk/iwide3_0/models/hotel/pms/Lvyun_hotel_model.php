<?php
class Lvyun_hotel_model extends CI_Model {
	const TAB_HO = 'hotel_orders';
	function __construct() {
		parent::__construct ();
		$this->load->helper('common');
	}

	public function get_rooms_change($rooms, $idents = array(), $condit = array(), $pms_set = array()) {
		statistic('A1');
		$days = get_room_night($condit ['startdate'],$condit ['enddate'],'round',$condit);//至少有一个间夜
		$web_rids = array ();
		foreach ( $rooms as $r ) {
			$web_rids [$r ['webser_id']] = $r ['room_id'];
		}
		$this->load->model ( 'common/Webservice_model' );
		$level_reflect = $this->Webservice_model->get_web_reflect ( $idents ['inter_id'], $idents ['hotel_id'], $pms_set ['pms_type'], array (
			'member_level',
			'member_price_code',
			'web_price_code',
			'price_code_set',
			'members_price_code',
			'basic_price_code'
		), 1, 'w2l' );


		switch($pms_set['inter_id']){
			case 'a468224499':
			case 'a445223617':
				$this->load->model('api/Vmember_model','vm');
				$member_level=$this->vm->getLvlPmsCode($condit['openid'],$idents['inter_id']);
				break;
			default:
				if(isset($level_reflect['member_level'])){
					$mem_levels = array_flip($level_reflect ['member_level']);
					$member_level = isset ($mem_levels [$condit ['member_level']]) ? $mem_levels [$condit ['member_level']] : '';
				}else{
					$member_level='';
				}
				break;
		}

		// $member_level = 'CZKK';
		$level_price_code = isset ( $level_reflect ['member_price_code'] [$member_level] ) ? $level_reflect ['member_price_code'] [$member_level] : NULL;
		if (empty ( $level_price_code ) && ! empty ( $level_reflect ['member_price_code'] ['default_member_price_code'] )) {
			$level_price_code = $level_reflect ['member_price_code'] ['default_member_price_code'];
		}
		$code_config = array ();
		if (! empty ( $level_reflect ['price_code_set'] )) {
			foreach ( $level_reflect ['price_code_set'] as $mk => $mc ) {
				$code_config [$mk] = json_decode ( $mc, TRUE );
			}
		}
		if (! empty ( $level_reflect ['web_price_code'] )) {
			foreach ( $level_reflect ['web_price_code'] as $wpc ) {
				$level_price_code .= ',' . $wpc;
			}
		}
		// $code_config['VIP-4']='{"pre_pay":1,"no_pay_way":["balance"]}';
		// var_dump($level_reflect);
		// $level_price_code='WX';
		if ($pms_set ['pms_room_state_way'] == 3) {
			$level_price_code = '';
		}
		$params = array (
			'idents' => $idents,
			'condit' => $condit,
			'web_rids' => $web_rids,
			'web_code' => $level_price_code,
			'member_level' => $member_level,
			'code_config' => $code_config
		);
		statistic('A2');
		$pms_data = $this->get_web_roomtype ( $pms_set, $condit ['startdate'], $days, $params );
		// var_dump ( $level_price_code );
		// var_dump ( $pms_data );
		// exit ();
		$data=[];
		statistic('A3');
		if (! empty ( $pms_data )) {
			$allprice = array ();
			$this->load->model ( 'hotel/Member_model' );
			$levels = $this->Member_model->get_member_levels ( $idents ['inter_id'] );
			switch ($pms_set ['pms_room_state_way']) {
				case 1 :
				case 2 :
					$data= $this->get_rooms_change_allpms ( $pms_data, array (
						'rooms' => $rooms
					), array (
						                                        'member_level' => $member_level,
						                                        'levels' => $levels,
						                                        'days' => $days,
						                                        'idents' => $idents,
						                                        'condit' => $condit
					                                        ) );
					break;
				case 3 :
					$data= $this->get_rooms_change_lmem ( $pms_data, array (
						'rooms' => $rooms
					), array (
						                                      'member_level' => $member_level,
						                                      'levels' => $levels,
						                                      'days' => $days,
						                                      'idents' => $idents,
						                                      'condit' => $condit,
						                                      'field_config' => $level_reflect,
						                                      'inter_id'=>$pms_set['inter_id'],
					                                      ) );
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
	function get_rooms_change_allpms($pms_state, $rooms, $params) {
		$data = array ();
		foreach ( $rooms ['rooms'] as $rm ) {
			if (! empty ( $pms_state ['pms_state'] [$rm ['webser_id']] )) {
				$data [$rm ['room_id']] ['room_info'] = $rm;
				// $data [$rm ['room_id']] ['state_info'] = empty ( $pms_state ['valid_state'] [$rm ['webser_id']] ) ? array () : $pms_state ['valid_state'] [$rm ['webser_id']];
				$data [$rm ['room_id']] ['state_info'] = $pms_state ['pms_state'] [$rm ['webser_id']];
				$data [$rm ['room_id']] ['show_info'] = array ();
				$data [$rm ['room_id']] ['lowest'] = min ( $pms_state ['exprice'] [$rm ['webser_id']] );
				$data [$rm ['room_id']] ['highest'] = max ( $pms_state ['exprice'] [$rm ['webser_id']] );
			}
		}
		return $data;
	}
	function get_rooms_change_lmem($pms_data, $rooms, $params) {
		$data = array ();
		// $needrooms = $rooms ['needrooms'];
		// $web_rooms = $rooms ['web_rooms'];
		$local_rooms = $rooms ['rooms'];
		$member_level = $params ['member_level'];
		$levels = $params ['levels'];
		$condit = $params ['condit'];
		$this->load->model ( 'hotel/Order_model' );
		$data = $this->Order_model->get_rooms_change ( $local_rooms, $params ['idents'], $params ['condit'] );
//		echo '<pre>';print_r($data);exit;
		$pms_state = $pms_data ['pms_state'];
		$this->load->model ( 'hotel/Order_model' );
		$members_price_code = empty ( $params ['field_config'] ['members_price_code'] ['all'] ) ? array () : explode ( ',', $params ['field_config'] ['members_price_code'] ['all'] );
		$basic_price_code=!empty($params['field_config']['basic_price_code'])?$params['field_config']['basic_price_code']:[];
		foreach ( $data as $room_key => $lrm ) {
			$web_info = array ();
			$webps = array ();
			$min_price = array ();
			if (! empty ( $lrm ['state_info'] )) {
				foreach ( $lrm ['state_info'] as $sik => $si ) {
					//检查member_price_code是否存在该等级PMS代码配对值
					if($si ['external_code'] !== '' && !empty($basic_price_code[$si['external_code']])){
						$si['external_code'] = $basic_price_code[$si['external_code']];
					}
					/*if(!empty($pms_state [$lrm ['room_info'] ['webser_id']])){
						echo '<pre>';
						print_r($si);
						print_r($pms_state [$lrm ['room_info'] ['webser_id']]);
						exit;
					}*/
					if ($si ['external_code'] !== '' && ! empty ( $pms_state [$lrm ['room_info'] ['webser_id']] [$si ['external_code']] )) {
						$tmp = $pms_state [$lrm ['room_info'] ['webser_id']] [$si ['external_code']];
//						echo '<pre>';print_r($tmp);exit;
						$nums = isset ( $condit ['nums'] [$lrm ['room_info'] ['room_id']] ) ? $condit ['nums'] [$lrm ['room_info'] ['room_id']] : 1;
						//云盟房型库存处理
						if($params['inter_id']=='a445223616'){
							if ($data [$room_key] ['state_info'] [$sik] ['price_type'] == 'member') {
								$data [$room_key] ['state_info'] [$sik] ['least_num'] = $tmp ['least_num'];
								$data [$room_key] ['state_info'] [$sik] ['book_status'] = $tmp ['book_status'];
							} else {
								$data [$room_key] ['state_info'] [$sik] ['least_num'] = $data [$room_key] ['state_info'] [$sik] ['least_num'] <= $tmp ['least_num'] ? $data [$room_key] ['state_info'] [$sik] ['least_num'] : $tmp ['least_num'];
								$data [$room_key] ['state_info'] [$sik] ['book_status'] = $tmp ['book_status'];
								if ($data [$room_key] ['state_info'] [$sik] ['least_num'] <= 0) {
									$data [$room_key] ['state_info'] [$sik] ['book_status'] = 'full';
								}
							}
						}else{
							$data [$room_key] ['state_info'] [$sik] ['least_num'] = $tmp ['least_num'];
							$data [$room_key] ['state_info'] [$sik] ['book_status'] = $tmp ['book_status'];
						}
						$allprice = '';
						$amount = 0;
						foreach ( $tmp ['date_detail'] as $dk => $td ) {
							//云盟
							if($params['inter_id'] == 'a445223616'){
								if($data [$room_key] ['state_info'] [$sik] ['price_type'] == 'member' || (!empty($si ['related_code']))){
									$tmp ['date_detail'] [$dk] ['price'] = round($this->Order_model->cal_related_price($td ['price'], $si ['related_cal_way'], $si ['related_cal_value'], 'price'));
								} else{
									$tmp ['date_detail'] [$dk] ['price'] = round($data [$room_key] ['state_info'] [$sik] ['date_detail'] [$dk] ['price']);
								}
								$tmp ['date_detail'] [$dk] ['nums'] = $data [$room_key] ['state_info'] [$sik] ['least_num'];
							} else{
								if(!empty($si ['related_cal_way']) && !empty($si ['related_cal_value'])){
									$tmp ['date_detail'] [$dk] ['price'] = round($this->Order_model->cal_related_price($td ['price'], $si ['related_cal_way'], $si ['related_cal_value'], 'price'));
								} else{
									$tmp ['date_detail'] [$dk] ['price'] = $td['price'];
								}
								$tmp ['date_detail'] [$dk] ['nums'] = $tmp ['least_num'];
							}
							$allprice .= ',' . $tmp ['date_detail'] [$dk] ['price'];
							$amount += $tmp ['date_detail'] [$dk] ['price'];
						}
						$data [$room_key] ['state_info'] [$sik] ['date_detail'] = $tmp ['date_detail'];
						$data [$room_key] ['state_info'] [$sik] ['extra_info'] = $tmp ['extra_info'];
						empty ( $tmp ['des'] ) ?  : $data [$room_key] ['state_info'] [$sik] ['des'] = $tmp ['des'];
						// empty($tmp ['price_name'])?:$data [$room_key] ['state_info'] [$sik] ['price_name'] = $tmp ['price_name'];

						$data [$room_key] ['state_info'] [$sik] ['avg_price'] = number_format ( $amount / $params ['days'], 2,'.','' );
						$data [$room_key] ['state_info'] [$sik] ['allprice'] = substr ( $allprice, 1 );
						$data [$room_key] ['state_info'] [$sik] ['total'] = intval ( $amount );
						$data [$room_key] ['state_info'] [$sik] ['total_price'] = $data [$room_key] ['state_info'] [$sik] ['total'] * $nums;
						$min_price [] = $data [$room_key] ['state_info'] [$sik] ['avg_price'];
					} else {
						unset ( $data [$room_key] ['state_info'] [$sik] );
					}
				}
			}
			if(!empty ($pms_state [$lrm ['room_info'] ['webser_id']])){
				foreach($pms_state [$lrm ['room_info'] ['webser_id']] as $web_code => $ps){
					if(isset ($params ['member_level']) && !empty($members_price_code) && !in_array($web_code, $members_price_code)){
						$data [$room_key] ['state_info'] [$web_code] = $ps;
						$min_price [] = $ps ['avg_price'];
					}
				}
			}
			$data [$room_key] ['lowest'] = empty ( $min_price ) ? 0 : min ( $min_price );
			$data [$room_key] ['highest'] = empty ( $min_price ) ? 0 : max ( $min_price );

//			if($params['inter_id']=='a449675133'){
			/*if(!$lrm['show_info']){
				$lrm['show_info'] = $lrm['state_info'];
				$data[$room_key]['show_info'] = $lrm['state_info'];
			}*/
//			}
			if (! empty ( $lrm ['show_info'] )) {
				foreach ( $lrm ['show_info'] as $sik => $si ) {

					//检查member_price_code是否存在该等级PMS代码配对值
					if($si ['external_code'] !== '' && !empty($basic_price_code[$si['external_code']])){
						$si['external_code'] = $basic_price_code[$si['external_code']];
					}
					// if (isset ( $member_level ) && ! empty ( $condit ['member_privilege'] ) && isset ( $si ['condition'] ['member_level'] ) && array_key_exists ( $si ['condition'] ['member_level'], $condit ['member_privilege'] )) {
					if ($si ['external_code'] !== '' && ! empty ( $pms_state [$lrm ['room_info'] ['webser_id']] [$si ['external_code']] )) {
						$tmp = $pms_state [$lrm ['room_info'] ['webser_id']] [$si ['external_code']];
						$nums = isset ( $condit ['nums'] [$lrm ['room_info'] ['room_id']] ) ? $condit ['nums'] [$lrm ['room_info'] ['room_id']] : 1;
						$data [$room_key] ['show_info'] [$sik] ['least_num'] = $tmp ['least_num'];
						$data [$room_key] ['show_info'] [$sik] ['book_status'] = $tmp ['book_status'];
						$allprice = '';
						$amount = 0;
						foreach ( $tmp ['date_detail'] as $dk => $td ) {
							if(!empty($si ['related_cal_way'])&&!empty($si ['related_cal_value'])){
								$tmp ['date_detail'] [$dk] ['price'] = round($this->Order_model->cal_related_price($td ['price'], $si ['related_cal_way'], $si ['related_cal_value'], 'price'));
							}else{
								$tmp ['date_detail'] [$dk] ['price']=$td ['price'];
							}
							$tmp ['date_detail'] [$dk] ['nums'] = $tmp ['least_num'];
							$allprice .= ',' . $tmp ['date_detail'] [$dk] ['price'];
							$amount += $tmp ['date_detail'] [$dk] ['price'];
						}
						$data [$room_key] ['show_info'] [$sik] ['date_detail'] = $tmp ['date_detail'];
						$data [$room_key] ['show_info'] [$sik] ['extra_info'] = $tmp ['extra_info'];
						empty ( $tmp ['des'] ) ?  : $data [$room_key] ['show_info'] [$sik] ['des'] = $tmp ['des'];

						$data [$room_key] ['show_info'] [$sik] ['avg_price'] = number_format ( $amount / $params ['days'], 2,'.','' );
						$data [$room_key] ['show_info'] [$sik] ['allprice'] = substr ( $allprice, 1 );
						$data [$room_key] ['show_info'] [$sik] ['total'] = intval ( $amount );
						$data [$room_key] ['show_info'] [$sik] ['total_price'] = $data [$room_key] ['show_info'] [$sik] ['total'] * $nums;
					}
					// }
				}
			}
		}
//		echo '<pre>';print_r($data);exit;
		return $data;
	}
	function get_web_roomtype($pms_set, $startdate, $days, $params) {
		$pms_auth = json_decode ( $pms_set ['pms_auth'], TRUE );
		$url = $pms_auth ['url'] . '/queryHotelList';
		$rate_codes = isset ( $params ['web_code'] ) ? $params ['web_code'] : '';
		$data = array (
			'date' => date ( 'Y-m-d', strtotime ( $startdate ) ),
			'dayCount' => $days,
			'cityCode' => '',
			'brandCode' => '',
			'order' => '1',
			'firstResult' => 1,
			'pageSize' => 10,
			'rateCodes' => $rate_codes,
			'salesChannel' => isset($pms_auth['priceSalesChannel'])?$pms_auth['priceSalesChannel']:$pms_auth['salesChannel'],
			// 'hotelIds' => 13,
			'hotelIds' => $pms_set ['hotel_web_id'],
			/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
			'hotelGroupId' => $pms_auth ['hotelGroupId']
		);
		$res = $this->get_to ( $url, $data, $pms_set ['inter_id'] );
		// var_dump ( $res );
		// var_dump ( $data );
		// exit ();
		$code_des = array ();
		$pms_state = array ();
		$exprice = array ();
		if (! empty ( $res ['hrList'] )) {
			$states = current ( $res ['hrList'] );
			if (! empty ( $states ['roomList'] )) {
				foreach ( $states ['rateCodes'] as $rc ) {
					$code_des [$rc ['code']] = $rc ['descript'];
				}
				$day_diff = round ( (strtotime ( $startdate ) - strtotime ( date ( 'Ymd' ) )) / 86400 );
				foreach ( $states ['roomList'] as $rl ) {
					if (! empty ( $code_des [$rl ['ratecode']] )) {
						if ((! empty ( $rl ['advMin'] ) && $rl ['advMin'] > $day_diff) || (! empty ( $rl ['stayMin'] ) && $rl ['stayMin'] > $days)) {
							continue;
						}

						// 判断价格代码设置
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['condition'] = array ();
						if (! empty ( $params ['code_config'] [$rl ['ratecode']] )) {
							if (!empty($params ['code_config'] [$rl ['ratecode']]['condition'])){
								$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['condition'] = $params ['code_config'] [$rl ['ratecode']]['condition'];
							}
							if (!empty($params ['code_config'] [$rl ['ratecode']]['limit_level'])&&isset($params ['condit']['member_level'])&&!in_array($params ['condit']['member_level'], $params ['code_config'] [$rl ['ratecode']]['limit_level'])){
								unset($pms_state [$rl ['rmtype']] [$rl ['ratecode']]);
								continue;
							}
						}

						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['price_name'] = $code_des [$rl ['ratecode']];
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['price_type'] = 'pms';
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['extra_info'] = array (
							'type' => 'code',
							'pms_code' => $rl ['ratecode'],
							'market' => $rl ['market'],
							'src' => $rl ['src'],
							'member_level' => $params ['member_level']
						);
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['price_code'] = $rl ['ratecode'];
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['des'] = '';
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['sort'] = 0;
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['disp_type'] = 'buy';
						$allprice = '';
						$amount = '';
						for($i = 0; $i < $days; $i ++) {
							$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['date_detail'] [date ( 'Ymd', strtotime ( '+ ' . $i . ' day ', strtotime ( $startdate ) ) )] = array (
								'price' => $rl ['avgRate1'],
								'nums' => $rl ['avail']
							);
							$allprice .= ',' . $rl ['avgRate1'];
							$amount += $rl ['avgRate1'];
						}
						if (isset ( $params ['web_rids'] [$rl ['rmtype']] )) {
							$nums = empty ( $params ['condit'] ['nums'] [$params ['web_rids'] [$rl ['rmtype']]] ) ? 1 : $params ['condit'] ['nums'] [$params ['web_rids'] [$rl ['rmtype']]];
						} else {
							$nums = 1;
						}
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['allprice'] = substr ( $allprice, 1 );
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['total'] = $rl ['crate1'];
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['related_des'] = '';
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['total_price'] = $rl ['crate1'] * $nums;
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['avg_price'] = $rl ['avgRate1'];
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['price_resource'] = 'webservice';
						if ($rl ['avail'] > 1)
							$rl ['avail'] = 1;
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['least_num'] = $rl ['avail'];
						$book_status = 'full';
						if ($rl ['avail'] >= $nums)
							$book_status = 'available';
						$pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['book_status'] = $book_status;

						$exprice [$rl ['rmtype']] [] = $pms_state [$rl ['rmtype']] [$rl ['ratecode']] ['avg_price'];
						// if ($room_detail ['canBook'] == 1) {
						// $valid_state [$type_state ['roomTypeCode']] [$room_detail ['ratePlanCode']] = $pms_state [$type_state ['roomTypeCode']] [$room_detail ['ratePlanCode']];
						// }
					}
				}
			}
		}
		return array (
			'pms_state' => $pms_state,
			'exprice' => $exprice
		);
	}
	function cancel_order_web($inter_id, $order, $pms_set = array()) {
		$web_orderid = isset ( $order ['web_orderid'] ) ? $order ['web_orderid'] : "";
		if (! $web_orderid) {
			return array (
				's' => 0,
				'errmsg' => '取消失败'
			);
		}

		//判断订单时间
		$intime = strtotime($order['startdate']);

		$this->load->model ( 'hotel/Hotel_config_model' );
		$config_data = $this->Hotel_config_model->get_hotel_config ( $inter_id, 'HOTEL', $order['hotel_id'], 'ORDER_PAID_CANCEL_TIME');

		if(!empty($config_data['ORDER_PAID_CANCEL_TIME'])&&$order['paytype']=='weixin'){
			$out_time = json_decode($config_data['ORDER_PAID_CANCEL_TIME'],true);
			if(isset($out_time[$order ['first_detail']['price_code']])){
				$timelimit = $out_time[$order ['first_detail']['price_code']];
			}elseif(isset($out_time['all'])){
				$timelimit = $out_time['all'];
			}

			if(mktime($timelimit, 0, 0, date('m', $intime), date('d', $intime), date('Y', $intime)) < time() && $this->uri->segment(3)!= 'deal_order_queues' && $order['status']!=9){
				//时间超过入住时间当天的限制时间不能取消
				return array(
					's'      => 0,
					'errmsg' => '只能在入住当天'.$timelimit.'点前取消订单！',
				);
			}
		}

		$pms_auth = json_decode ( $pms_set ['pms_auth'], TRUE );
		$url = $pms_auth ['url'] . '/cancelbook';

		$data = array (
			"cardNo" => '',
			"crsNo" => $web_orderid,
			"hotelGroupId" => $pms_auth ['hotelGroupId']
		);
		$res = $this->post_to ( $url, $data, $inter_id );
		if (isset ( $res ['resultCode'] ) && $res ['resultCode'] == 0)
			return array (
				's' => 1,
				'errmsg' => '取消成功'
			);
		return array (
			's' => 0,
			'errmsg' => '取消失败'
		);
	}
	public function update_web_order($inter_id, $list, $pms_set) {
		switch ($inter_id) {
			case 'a449675133' :
			case 'a438686762' :
			case 'a457946152' :
			case 'a445223616' :
				return $this->update_web_order_sub ( $inter_id, $list, $pms_set );
				break;
			default :
				return $this->update_web_order_main ( $inter_id, $list, $pms_set );
				break;
		}
		return FALSE;
	}
	public function update_web_order_sub($inter_id, $list, $pms_set) {
		$res=$this->get_web_order($list['web_orderid'],$inter_id,$pms_set);
		$new_status = null;

		if (isset ( $res ['resultCode'] ) && $res ['resultCode'] == 0) {
			$status_arr = $this->pms_enum ( 'status' );
			$new_status = $status_arr [$res ['guest'] ['sta']];
			$this->load->model ( 'hotel/Order_model' );
			foreach ( $list ['order_details'] as $od ) {
				if ($od ['istatus'] == 4 && $new_status == 5) {
					$new_status = 4;
				}
				$web_start = date ( 'Ymd', strtotime ( $res ['guest'] ['arr'] ) );
				$web_end = date ( 'Ymd', strtotime ( $res ['guest'] ['dep'] ) );
				$web_end = $web_end == $web_start ? date ( 'Ymd', strtotime ( '+ 1 day', strtotime ( $web_start ) ) ) : $web_end;
				$ori_day_diff = get_room_night($od ['startdate'],$od ['enddate'],'ceil',$od);//至少有一个间夜
				$web_day_diff = get_room_night($web_start,$web_end,'ceil');//至少有一个间夜
				$day_diff = $web_day_diff - $ori_day_diff;
				$updata = array ();
				if ($new_status != $od ['istatus']) {
					$updata ['istatus'] = $new_status;
				}

				// 云盟返佣机制更改
				// 到付：提前离店，按pms计算；
				// 微信支付：按下单时订单计算；
				if($inter_id == 'a445223616'){
					if ($day_diff != 0 || $web_start != $od ['startdate'] || $web_end != $od ['enddate']) {
						if($day_diff < 0 && $list ['paid'] == 0){
							$first_price = floatval($od ['allprice']); // 取首日价格
							$allprice = explode(',', $od ['allprice']);
							$countday = abs($day_diff);
							if(date('Ymd', strtotime($res ['guest'] ['dep'])) == $web_start){
								$countday--;
							}
							$updata ['no_check_date'] = 1;
							$updata ['startdate'] = $web_start;
							$updata ['enddate'] = date('Ymd', strtotime($res ['guest'] ['dep']));
							$reduce_amount = 0;
							for($j = 0; $j < $countday; $j++){
								$tmp = array_pop($allprice);
								$reduce_amount += empty ($tmp) ? $first_price : $tmp;
							}
							$updata ['new_price'] = $od ['iprice'] - $reduce_amount;
						}
					}
				}else{
					$updata ['startdate'] = $web_start;
					$updata ['enddate'] = $web_end;

					if ($day_diff != 0 || $web_start != $od ['startdate'] || $web_end != $od ['enddate']) {
						$updata ['no_check_date'] = 1;
					}
					$web_price = floatval($res ['guest'] ['rateSum']);
					if(empty ($web_price)){
						if($web_day_diff == 1){
							$web_price = floatval($od ['allprice']);
						}
					}
					if($web_price>0&&$web_price != $od['iprice']){
						$updata['no_check_data'] = 1;
						$updata['new_price'] = $web_price;
					}
				}


				if (! empty ( $updata )) {
					$this->Order_model->update_order_item ( $inter_id, $list ['orderid'], $od ['sub_id'], $updata );
				}
			}
		}
		return $new_status;
	}
	public function update_web_order_main($inter_id, $list, $pms_set) {
		$res=$this->get_web_order($list['web_orderid'],$inter_id,$pms_set);
		$new_status = null;
		if (isset ( $res ['resultCode'] ) && $res ['resultCode'] == 0) {
			$status_arr = $this->pms_enum ( 'status' );
			$new_status = $status_arr [$res ['guest'] ['sta']];
			if ($list ['status'] == 4 && $new_status == 5) {
				$new_status = 4;
			}
			if ($new_status != $list ['status']) {
				$this->load->model ( 'hotel/Order_model' );
				$this->db->where ( array (
					                   'inter_id' => $list ['inter_id'],
					                   'orderid' => $list ['orderid']
				                   ) );
				$this->db->update ( 'hotel_orders', array (
					'status' => $new_status
				) );
				$this->Order_model->handle_order ( $inter_id, $list ['orderid'], $new_status, $list ['openid'] );
			}
		}
		return $new_status;
	}

	public function get_web_order($web_orderid, $inter_id, $pms_set){
		$pms_auth = json_decode($pms_set['pms_auth'], true);
		$url = $pms_auth ['url'] . '/findResrvGuest';
		$data = array(
			"cardNo"       => "",
			"crsNo"        => $web_orderid,
			"hotelGroupId" => $pms_auth['hotelGroupId']
		);
		$res = $this->post_to($url, $data, $inter_id);
		if(isset($res['resultCode']) && $res['resultCode'] == 0){
			return $res;
		}else{
			$url = $pms_auth ['url'] . '/findResrvGuestHistory';
			$res = $this->post_to($url, $data, $inter_id);
		}
		return $res;
	}

	// R=预订，X=取消，I=在住，S=挂账，O=离店，N=Noshow
	function pms_enum($type) {
		switch ($type) {
			case 'status' :
				return array(
					'R' => 1,
					'X' => 5,
					'I' => 2,
					'O' => 3,
					'N' => 8,
					'S' => 3,
					'D'=>5,
				);
				break;
			default :
				break;
		}
	}
	function order_to_web($inter_id, $orderid, $paras = array(), $pms_set = array()) {
		$this->load->model ( 'hotel/Order_model' );
		$order = $this->Order_model->get_main_order ( $inter_id, array ( // 取订单信息，包含订单主单信息和子单信息
		                                                                 'orderid' => $orderid,
		                                                                 'idetail' => array (
			                                                                 'i'
		                                                                 )
		) );
		if (! empty ( $order )) {
			$order = $order [0]; // 订单信息
			$coupon_info=json_decode($order['coupon_des'],TRUE);
			if (!empty($coupon_info['cash_token'][0]['extra']['source'])&&$coupon_info['cash_token'][0]['extra']['source']=='pms')
				return $this->order_to_web_coupon($inter_id, $orderid,$paras,$pms_set, $order);
			return $this->order_to_web_normal($inter_id, $orderid,$paras,$pms_set, $order);
		}
		return array (
			's' => 0,
			'errmsg' => '提交订单失败'
		);
	}

	function order_to_web_normal($inter_id, $orderid, $paras = array(), $pms_set = array(),$order){
//        echo 'inside order to web';
		$pms_auth = json_decode ( $pms_set ['pms_auth'], TRUE );
		$hotel_no = $pms_set ['hotel_web_id'];
		$room_codes = json_decode ( $order ['room_codes'], TRUE );
		$room_codes = $room_codes [$order ['first_detail'] ['room_id']];
		$url = $pms_auth ['url'] . '/book';
		$card_type = '';
		$card_no = '';
		
		//有绿云会员号才传
		$this->load->model('hotel/Member_model');
		$member=$this->Member_model->check_openid_member($inter_id,$order['openid']);

// 		if(!isset($member->mode)){
// 			$member->mode=$member->member_mode;
// 		}
		
		if (! empty ( $order ['member_no'] ) && (!empty($member)&&$member->member_mode==2&&$member->is_login=='t')) {
			$card_type = $room_codes ['code'] ['extra_info'] ['member_level'];
			$card_no = $order ['member_no'];
		}
		$favor = empty ( $order ['coupon_favour'] ) ? 0 : $order ['coupon_favour'];

		$custom_price = array ();
		// $custom_price = '';
		$allprice = explode ( ',', $order ['first_detail'] ['allprice'] );
		$total_favour = $order ['coupon_favour'] + $order ['point_favour'];
		$favour_info = empty ( $order ['coupon_favour'] ) ? '' : '使用优惠券：' . $order ['coupon_favour'] . '。';
		$favour_info .= empty ( $order ['point_favour'] ) ? '' : '积分抵扣：' . $order ['point_favour'] . '。';

		if('a462961398'==$inter_id&&'point'==$order['paytype']){
			$favour_info.='使用积分：'.$order['point_used_amount'].'换房';
		}

		$favour = number_format ( $total_favour / $order ['roomnums'], 2, '.', '' );
		if ($favour > 0) {
			for($i = 0; $i < count ( $allprice ); $i ++) {
				if ($allprice [$i] >= $favour) {
					$allprice [$i] -= $favour;
					$favour = 0;
					break;
				} else {
					$favour -= $allprice [$i];
					$allprice [$i] = 0;
				}
				if ($favour == 0)
					break;
			}
		}
		$i = 0;
		foreach ( $allprice as $ap ) {
			$custom_price [] = array (
				'date' => date ( 'Y-m-d', strtotime ( '+ ' . $i . 'day', strtotime ( $order ['first_detail'] ['startdate'] ) ) ),
				'realRate' => $ap
			);
			// $custom_price .= ',{date:' . date ( 'Y-m-d', strtotime ( '+ ' . $i . 'day', strtotime ( $order ['first_detail'] ['startdate'] ) ) ) . ',realRate:' . $ap . '}';
			$i ++;
		}
		// $custom_price = substr ( $custom_price, 1 );
		// $custom_price = '[' . $custom_price . ']';
		$src = 'NET';
		if (! empty ( $pms_auth ['src'] )) {
			$src = $pms_auth ['src'];
		}
		$data = array (
			"arr" => date ( 'Y-m-d 12:00:00', strtotime ( $order ['startdate'] ) ),
			"dep" => date ( 'Y-m-d 12:00:00', strtotime ( $order ['enddate'] ) ),
			"rmtype" => $room_codes ['room'] ['webser_id'], // 房型代码
			"rateCode" => $room_codes ['code'] ['extra_info'] ['pms_code'], // MEM,RACK,ENT,MAN 房价码
			"src" => $src,
			"rmNum" => $order ['roomnums'],
			"rsvMan" => $order ['name'],
			"sex" => "0",
			"mobile" => $order ['tel'],
			"email" => '',
			"idType" => "01",
			"idNo" => "",
			"cardType" => $card_type,
			"cardNo" => $card_no,
			"adult" => "1",
			"remark" => "微信订单。" . $favour_info,
			"disAmount" => '',
			"market" => $room_codes ['code'] ['extra_info'] ['market'],
			"saleChannel" => $pms_auth ['salesChannel'],
			'salesChannel'=>$pms_auth['salesChannel'],
			"hotelId" => $hotel_no,
			"hotelGroupId" => $pms_auth ['hotelGroupId'],
			"everyDayRate" => json_encode ( $custom_price )
		);
		if (! empty ( $pms_auth ['weixin'] )) {
			$data ['weixin'] = $pms_auth ['weixin'];
		}
		if($order['inter_id']=='a487576098'){
			$data['channel']=$pms_auth['salesChannel'];
		}
        //特殊的备注
        $this->load->model ( 'common/Enum_model' );
        $pay_types = $this->Enum_model->get_enum_des ( 'PAY_WAY',1);
        if ($order['inter_id'] == 'a499938809' && $pms_auth['special_remark'] == 1) {
            $data['remark'] .= $order['order_details'][0]['price_code_name']
                            .','.$order['price'].','.$pay_types[$order['paytype']];
        }

		$res = $this->post_to ( $url, $data, $inter_id );
		/*
		 * 返回的信息如下：
		 * {"crsNo":"W1512300002","paySta":"0","deposit":0,"resultCode":0}
		 */
		if (! empty ( $res ['crsNo'] )) {
			$web_orderid = $res ['crsNo'];
			$this->db->where ( array (
				                   'orderid' => $order ['orderid'],
				                   'inter_id' => $order ['inter_id']
			                   ) );
			$this->db->update ( 'hotel_order_additions', array ( // 将pms的单号更新到相应订单
			                                                     'web_orderid' => $web_orderid
			) );
			// $this->Order_model->update_order_status ( $inter_id, $orderid, 1 ); // 若pms的订单是即时确认的，执行确认操作
			if ($order ['status'] != 9) {
				$this->db->where ( array (
					                   'orderid' => $order ['orderid'],
					                   'inter_id' => $order ['inter_id']
				                   ) );
				$this->db->update ( 'hotel_orders', array (
					'status' => 1
				) );
				$this->Order_model->handle_order ( $inter_id, $orderid, 1 ); // 若pms的订单是即时确认的，执行确认操作
			} else if ($order ['paytype'] == 'balance') {
				$this->load->model ( 'hotel/Hotel_config_model' );
				$config_data = $this->Hotel_config_model->get_hotel_config ( $inter_id, 'HOTEL', $order ['hotel_id'], array (
					'PMS_BANCLANCE_REDUCE_WAY',
                    'BONUS_EXCHANGE_BALANCE',
                    'PMS_BONUS_COMSUME_WAY'
				) );
				if (! empty ( $config_data ['PMS_BANCLANCE_REDUCE_WAY'] ) && $config_data ['PMS_BANCLANCE_REDUCE_WAY'] == 'after') {
					$this->load->model ( 'hotel/Member_model' );
					$balance_param=array(
						'crsNo'=>$web_orderid,
                        'hotelId' => $hotel_no
//						'password'=>$room_codes ['room'] ['consume_code']
					);
					if(!empty($room_codes['room']['consume_code'])){
						$balance_param['password']=$room_codes ['room'] ['consume_code'];
					}
					if ($this->Member_model->reduce_balance ( $inter_id, $order ['openid'], $order ['price'], $order ['orderid'] . ',' . $web_orderid . ',' . $room_codes ['room'] ['consume_code'], '订房订单余额支付',$balance_param )) {
						//云盟储值支付需要入账
						if($inter_id=='a445223616'){
							$this->add_web_bill($web_orderid,$order,$pms_auth,$orderid,1);
						}
						$this->Order_model->update_order_status ( $inter_id, $order ['orderid'], 1, $order ['openid'], true );
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


                if($config_data['BONUS_EXCHANGE_BALANCE'] && $order ['point_used_amount']>0 && !empty($order ['point_favour'])){
                    if (! empty ( $config_data ['PMS_BONUS_COMSUME_WAY'] ) && $config_data ['PMS_BONUS_COMSUME_WAY'] == 'after') {
                        $this->load->model ( 'hotel/Member_model' );
                        $bonus_config = json_decode($config_data['BONUS_EXCHANGE_BALANCE']);
                        $params['rate'] = $bonus_config->rate;
                        $params['percentage'] = $bonus_config->percentage;
                        $params['count'] = $order['coupon_favour'];
                        $params['crsNo'] = $order['first_detail']['webs_orderid'];
                        $params['hotelId'] = $hotel_no;
                        if(!empty($room_codes['room']['consume_code'])){
                            $params['password']=$room_codes ['room'] ['bonus_consume_code'];
                        }else{
                            $params['password']='';
                        }
                        if(!$this->Member_model->exchange_bonus($inter_id, $order ['orderid'], $order ['openid'], $order ['point_used_amount'],$params)){
                            $this->Order_model->update_point_reduce($inter_id,$order ['orderid'],3);
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
                        }
                    }
                        $this->Order_model->update_point_reduce($inter_id,$order ['orderid'],1);
                }
			}
			if (! empty ( $paras ['trans_no'] )) {
				$this->add_web_bill ( $web_orderid, $order, $pms_auth, $paras ['trans_no'] );
			}
			return array ( // 返回成功
			               's' => 1
			);
		} else {
			$this->db->where ( array (
				                   'orderid' => $order ['orderid'],
				                   'inter_id' => $order ['inter_id']
			                   ) );
			$this->db->update ( 'hotel_orders', array ( // 提交失败，把订单状态改为下单失败
			                                            'status' => 10
			) );
			return array ( // 返回失败
			               's' => 0,
			               'errmsg' => $res ['resultMsg']
			);
		}
	}

	function order_to_web_coupon($inter_id, $orderid, $paras = array(), $pms_set = array(),$order){
		$pms_auth = json_decode ( $pms_set ['pms_auth'], TRUE );
		$hotel_no = $pms_set ['hotel_web_id'];
		$room_codes = json_decode ( $order ['room_codes'], TRUE );
		$room_codes = $room_codes [$order ['first_detail'] ['room_id']];
		$url = $pms_auth ['url'] . '/bookWithCoupon';
		$card_type = '';
		$card_no = '';
		//有绿云会员号才传
		$this->load->model('hotel/Member_model');
		$member=$this->Member_model->check_openid_member($inter_id,$order['openid']);

// 		if(!isset($member->mode)){
// 			$member->mode=$member->member_mode;
// 		}

		if (! empty ( $order ['member_no'] ) && (!empty($member)&&$member->member_mode==2&&$member->is_login=='t')) {
			$card_type = $room_codes ['code'] ['extra_info'] ['member_level'];
			$card_no = $order ['member_no'];
		}

		$custom_price = array ();
		// $custom_price = '';
		$allprice = explode ( ',', $order ['first_detail'] ['allprice'] );
		$total_favour = $order ['coupon_favour'] + $order ['point_favour'];
		$favour_info = empty ( $order ['coupon_favour'] ) ? '' : '使用优惠券抵扣：' . $order ['coupon_favour'] . '。';
		$favour_info .= empty ( $order ['point_favour'] ) ? '' : '积分抵扣：' . $order ['point_favour'] . '。';
		$favour = number_format ( $total_favour / $order ['roomnums'], 2, '.', '' );
		if ($favour > 0) {
			for($i = 0; $i < count ( $allprice ); $i ++) {
				if ($allprice [$i] >= $favour) {
					$allprice [$i] -= $favour;
					$favour = 0;
					break;
				} else {
					$favour -= $allprice [$i];
					$allprice [$i] = 0;
				}
				if ($favour == 0)
					break;
			}
		}
		$i = 0;
		foreach ( $allprice as $ap ) {
			$custom_price [] = array (
				'date' => date ( 'Y-m-d', strtotime ( '+ ' . $i . 'day', strtotime ( $order ['first_detail'] ['startdate'] ) ) ),
				'realRate' => $ap
			);
			$i ++;
		}
		$src = 'NET';
		if (! empty ( $pms_auth ['src'] )) {
			$src = $pms_auth ['src'];
		}
		$coupon_info=json_decode($order['coupon_des'],TRUE);
		$coupon_info=$coupon_info['cash_token'][0];
		$couponTypeArr = array(
			'discount' => 'RF', //折扣
			'voucher'  => 'DF' //代金
		);
		$data = array (
			"arr" => date ( 'Y-m-d 12:00:00', strtotime ( $order ['startdate'] ) ),
			"dep" => date ( 'Y-m-d 12:00:00', strtotime ( $order ['enddate'] ) ),
			"rmtype" => $room_codes ['room'] ['webser_id'], // 房型代码
			"rateCode" => $room_codes ['code'] ['extra_info'] ['pms_code'], // MEM,RACK,ENT,MAN 房价码
			"src" => $src,
			"rmNum" => $order ['roomnums'],
			"rsvMan" => $order ['name'],
			"sex" => "0",
			"mobile" => $order ['tel'],
			"email" => '',
			"idType" => "01",
			"idNo" => "",
			"cardType" => $card_type,
			"cardNo" => $card_no,
			"adult" => "1",
			"remark" => "微信订单。" . $favour_info,
			"disAmount" => '0',
			"market" => $room_codes ['code'] ['extra_info'] ['market'],
			"saleChannel" => $pms_auth ['salesChannel'],
			"hotelId" => $hotel_no,
			"hotelGroupId" => $pms_auth ['hotelGroupId'],
			"couponDetailCode" => $coupon_info['code'],
			// 				"couponDetailCode" => 'FH807040000704877',
			"couponCode" => $coupon_info['extra']['coupon_id'],
			// 				"couponCode" => 'FH80',
			"costValue" => '-'.floatval($order['coupon_favour']),
			// 				"costValue" => -120,
			"cosType" => $couponTypeArr[$coupon_info['extra']['type']],
			'startDate'=>date ( 'Y-m-d 12:00:00', strtotime ( $order ['startdate'] ) ),
			'endDate'=>date ( 'Y-m-d 12:00:00', strtotime ( $order ['enddate'] ) )
		);
		if (! empty ( $pms_auth ['weixin'] )) {
			$data ['weixin'] = $pms_auth ['weixin'];
		}
		if($order['inter_id']=='a487576098'){
			$data['channel']=$pms_auth['salesChannel'];
		}
        //特殊的备注
        $this->load->model ( 'common/Enum_model' );
        $pay_types = $this->Enum_model->get_enum_des ( 'PAY_WAY',1);
        if ($order['inter_id'] == 'a499938809' && $pms_auth['special_remark'] == 1) {
            $data['remark'] .= $order['order_details'][0]['price_code_name']
                            .','.$order['price'].','.$pay_types[$order['paytype']];
        }

		$res = $this->post_to ( $url, $data, $inter_id );

		/*
		 * 返回的信息如下：
		 * {"crsNo":"W1512300002","paySta":"0","deposit":0,"resultCode":0}
		 */
		if (! empty ( $res ['crsNo'] )) {
			$web_orderid = $res ['crsNo'];
			$this->db->where ( array (
				                   'orderid' => $order ['orderid'],
				                   'inter_id' => $order ['inter_id']
			                   ) );
			$this->db->update ( 'hotel_order_additions', array ( // 将pms的单号更新到相应订单
			                                                     'web_orderid' => $web_orderid
			) );
			// $this->Order_model->update_order_status ( $inter_id, $orderid, 1 ); // 若pms的订单是即时确认的，执行确认操作
			if ($order ['status'] != 9) {
				$this->db->where ( array (
					                   'orderid' => $order ['orderid'],
					                   'inter_id' => $order ['inter_id']
				                   ) );
				$this->db->update ( 'hotel_orders', array (
					'status' => 1
				) );
				$this->Order_model->handle_order ( $inter_id, $orderid, 1 ); // 若pms的订单是即时确认的，执行确认操作
			} elseif ($order ['paytype'] == 'balance') {
				$this->load->model ( 'hotel/Hotel_config_model' );
				$config_data = $this->Hotel_config_model->get_hotel_config ( $inter_id, 'HOTEL', $order ['hotel_id'], array (
					'PMS_BANCLANCE_REDUCE_WAY',
                    'PMS_BONUS_COMSUME_WAY',
                    'BONUS_EXCHANGE_BALANCE'
				) );
				if (! empty ( $config_data ['PMS_BANCLANCE_REDUCE_WAY'] ) && $config_data ['PMS_BANCLANCE_REDUCE_WAY'] == 'after') {
					$this->load->model ( 'hotel/Member_model' );
					$balance_param=array(
							'crsNo'=>$web_orderid,
							'password'=>$room_codes ['room'] ['consume_code'],
                            'hotelId' => $hotel_no
					);

					if ($this->Member_model->reduce_balance ( $inter_id, $order ['openid'], $order ['price'], $order ['orderid'] . ',' . $web_orderid . ',' . $room_codes ['room'] ['consume_code'], '订房订单余额支付' ,$balance_param)) {
						//云盟储值支付需要入账
						if($inter_id=='a445223616'){
							$this->add_web_bill($web_orderid,$order,$pms_auth,$orderid,1);
						}
						$this->Order_model->update_order_status ( $inter_id, $order ['orderid'], 1, $order ['openid'], true );
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

                if($config_data['BONUS_EXCHANGE_BALANCE'] && !empty($order ['point_used_amount']) && !empty($order ['point_favour'])){
                    if (! empty ( $config_data ['PMS_BONUS_COMSUME_WAY'] ) && $config_data ['PMS_BONUS_COMSUME_WAY'] == 'after') {
                    $this->load->model ( 'hotel/Member_model' );
                        $bonus_config = json_decode($config_data['BONUS_EXCHANGE_BALANCE']);
                        $params['rate'] = $bonus_config->rate;
                        $params['percentage'] = $bonus_config->percentage;
                        $params['count'] = $order['point_favour'];
                        $params['crsNo'] = $web_orderid;
                        $params['hotelId'] = $hotel_no;
                        if(!empty($room_codes['room']['consume_code'])){
                            $params['password']=$room_codes ['room'] ['bonus_consume_code'];
                        }else{
                            $params['password']='';
                        }
                        if(!$this->Member_model->exchange_bonus($inter_id,$order ['openid'],  $order ['point_used_amount'],$order ['orderid'], '隐居积分换算扣减',$params)){
                            $this->Order_model->update_point_reduce($inter_id,$order ['orderid'],3);
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
                        }
                    }
                    $this->Order_model->update_point_reduce($inter_id,$order ['orderid'],1);
                }

            }
			if (! empty ( $paras ['trans_no'] )) {
				$this->add_web_bill ( $web_orderid, $order, $pms_auth, $paras ['trans_no'] );
			}
			return array ( // 返回成功
			               's' => 1
			);
		} else {
			$this->db->where ( array (
				                   'orderid' => $order ['orderid'],
				                   'inter_id' => $order ['inter_id']
			                   ) );
			$this->db->update ( 'hotel_orders', array ( // 提交失败，把订单状态改为下单失败
			                                            'status' => 10
			) );
			return array ( // 返回失败
			               's' => 0,
			               'errmsg' => $res ['resultMsg']
			);
		}

	}

	function add_web_bill($web_orderid, $order, $pms_auth, $trans_no = '',$bill_type=0) {
		$url = $pms_auth ['url'] . '/saveWebPay';
// 		$taCode = empty ( $pms_auth ['taCode'] ) ? '' : $pms_auth ['taCode'];
		$data = array (
			'crsNo' => $web_orderid,
			'money' => $order['price'],
			'taNo' => $trans_no,
			// 				'taCode' => $taCode,
			'taRemark' => '微信支付，支付流水号：' . $trans_no,
			'hotelGroupId' => $pms_auth ['hotelGroupId']
		);

		if(('a487647571'==$order['inter_id']||'a487576098'==$order['inter_id'])&&!empty($order['_third_no'])){
			//万信入账时，使用流水号，并非商户单号
			$data['taNo']=$order['_third_no'];
			$data['taRemark']='微信支付，支付流水号：'.$order['_third_no'];
		}

		if($bill_type==1){
			$data['taRemark']='储值支付，支付流水号：'.$trans_no;
		}elseif($bill_type==2){
			$data['taRemark']='积分支付';
		}

		//书香要传taCode，隐居不用,
		//云盟使用taCode，万信使用taCode
		if($order ['inter_id'] == 'a449675133' || 'a445223616' == $order['inter_id']||'a487647571'==$order['inter_id']||'a487576098'==$order['inter_id']){
			$data['taCode'] = $pms_auth ['taCode'];
		}
		
		if($order['inter_id']=='a462961398'&&$bill_type==2){ //世茂积分入账使用代码
			$data['taCode']=$pms_auth['point_taCode'];
		}
		
		$res = $this->post_to ( $url, $data, $order ['inter_id'] );

		$web_paid = 2;
		$s = FALSE;
		if (isset ( $result ['resultCode'] ) && $result ['resultCode'] == 0) {
			$web_paid = 1;
			$s = TRUE;
		}
		$this->db->where ( array (
			                   'orderid' => $order ['orderid'],
			                   'inter_id' => $order ['inter_id']
		                   ) );
		$this->db->update ( 'hotel_order_additions', array ( // 将pms的单号更新到相应订单
		                                                     'web_paid' => $web_paid
		) );
		return $s;
	}
	function get_to($url, $data = array(), $inter_id = '') {
		$this->load->helper ( 'common' );
		$r_url = $url;
		$url_param = '';
		if (! empty ( $data )) {
			foreach ( $data as $k => $d ) {
				$url_param .= '&' . $k . '=' . $d;
			}
		}
		$url .= empty ( $url_param ) ? '' : '?' . substr ( $url_param, 1 );
		$now = time ();
		$s = doCurlGetRequest ( $url );

		$this->load->model('common/Webservice_model');
		$this->Webservice_model->add_webservice_record($inter_id, 'lvyun', $r_url, $data, $s,'query_get', $now, microtime (), $this->session->userdata ( $inter_id . 'openid' ));

		$s = json_decode ( $s, true );
		return $s;
	}

	function post_to($url, $data = array(), $inter_id = '') {
		$this->load->helper ( 'common' );
		$send_content = http_build_query ( $data );
		$now = time ();
		$s = doCurlPostRequest ( $url, $send_content );

		$this->load->model('common/Webservice_model');
		$this->Webservice_model->add_webservice_record($inter_id, 'lvyun', $url, $data, $s,'query_post', $now, microtime (), $this->session->userdata ( $inter_id . 'openid' ));

		$s = json_decode ( $s, true );
		return $s;
	}
	//判断订单是否能支付
	function check_order_canpay($list, $pms_set) {
		$pms_auth = json_decode ( $pms_set ['pms_auth'], TRUE );
		$url = $pms_auth ['url'] . '/findResrvGuest';
		$data = array (
			"cardNo" => "",
			"crsNo" => $list ['web_orderid'],
			"hotelGroupId" => $pms_auth ['hotelGroupId']
		);
		$res = $this->post_to ( $url, $data, $list['inter_id'] );
		if (isset ( $res ['resultCode'] ) && $res ['resultCode'] == 0) {
			$status_arr = $this->pms_enum ( 'status' );
			$new_status = $status_arr [$res ['guest'] ['sta']];
		}
		if(isset($new_status) && ($new_status == 1 || $new_status == 0)){//订单预定或确认
			return true;
		}else{
			return false;
		}
	}

	function point_pay_check($inter_id, $params = [], $pms_set = []){

		$this->load->model('hotel/Hotel_config_model');
		$cfg_data = $this->Hotel_config_model->get_hotel_config($inter_id, 'HOTEL', $params['hotel_id'], array(
			'POINT_EXCHANGE_ROOM',
		));
		$result = ['can_exchange' => 0, 'pay_set' => [], 'point_need' => 0, 'des' => ''];
		if(empty($cfg_data['POINT_EXCHANGE_ROOM'])){
			$result['can_exchange'] = 0;
			$result['errmsg'] = '参数错误';
			return $result;
		}
		$cfg = json_decode($cfg_data['POINT_EXCHANGE_ROOM'], true);

		//判断入住天数
		if(!empty($cfg['orderday'])){
			if($params['countday'] > $cfg['orderday']){
				$result['can_exchange'] = 0;
				$result['errmsg'] = '只能预订' . $cfg['orderday'] . '天的积分房';
				return $result;
			}
		}
		if(!empty($cfg['roomnums'])){
			//判断预订房间
			if($params['roomnums'] > $cfg['roomnums']){
				$result['can_exchange'] = 0;
				$result['errmsg'] = '每次只能预订' . $cfg['roomnums'] . '间积分房';
				return $result;
			}
		}
		if(!empty($cfg['room_ids'])){
			if(!in_array($params['room_id'], $cfg['room_ids'])){
				$result['can_exchange'] = 0;
				$result['errmsg'] = '该房型不可用积分兑换';
				return $result;
			}
		}
		//仅显示时，不需要验证价格代码
		if(empty($params['only_show'])){

		}

		$point_need = 0;
		switch($cfg['ext_way']){
			case 'fixed':
				if(!empty($cfg['point_needed'][$params['room_id']])){
					$point_need=$cfg['point_needed'][$params['room_id']];
				}elseif(!empty($cfg['point_needed']['0'])){
					$point_need=$cfg['point_needed']['0'];
				}
				break;
		}

		//计算换房积分
		$result['pay_set']['ex_way'] = 'rate';

		$result['point_need'] = $point_need;

		$result['can_exchange'] = $params['bonus'] >= $point_need ? 1 : 0;
		$result['des'] = $result['point_need'] . '/' . $params['bonus'];

		if($params['bonus'] < $point_need){
			$result['errmsg'] = '积分不足以支付';
		}

		return $result;

	}

}