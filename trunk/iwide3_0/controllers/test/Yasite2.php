<?php

/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2016/9/19
 * Time: 10:46
 */
class Yasite2 extends MY_Controller{
	private $soap;

//	private $inter_id = 'a474337632';  //开发

//	private $inter_id = 'a474353453';       //测试
	private $inter_id = 'a472731996';       //生产
	
	private $pms_set;
	
	public function __construct(){
		parent::__construct();
		$soap_opt = [
			'soap_version' => SOAP_1_1,
			'encoding'     => 'UTF-8',
			'cache_wsdl'   => WSDL_CACHE_NONE,
			'trace'        => true,
		];
		$this->soap = new SoapClient('http://121.41.82.114:9026/IWideService.asmx?wsdl', $soap_opt);
		$this->load->helper('common');
		
		$this->pms_set = [
			'pms_auth' => json_encode([
				'url' => 'http://121.41.82.114:9026/IWideService.asmx?wsdl',
			]),
			
			'inter_id' => $this->inter_id
		];
		
		$config = [
			'url'      => 'http://121.41.82.114:9026/IWideService.asmx?wsdl',
			'inter_id' => $this->inter_id,
		];
		
		$this->load->library('Baseapi/Yasiteiwapi', $config, 'serv_api');
	}
	
	public function getrooms(){
		$id = $this->input->get('id');
		$rooms = $this->soap->__soapCall('GetAllRoomType', ['parameters' => ['ChainID' => $id]]);
		$list = [];
		if(!empty($rooms->GetAllRoomTypeResult)){
			$temp = obj2array($rooms->GetAllRoomTypeResult);
			if(!empty($temp['RoomType'])){
				is_array(current($temp['RoomType'])) or $temp['RoomType'] = [$temp['RoomType']];
				foreach($temp['RoomType'] as $v){
					$list[] = [
						'webser_id' => $v['RoomTypeID'],
						'name'      => $v['RoomTypeName'],
					];
				}
			}
		}
		echo '<pre>';
		print_r($list);
	}
	
	public function allHotels(){
		set_time_limit(0);
		$obj = $this->soap->__soapCall('GetAllHotels', []);
		$result = obj2array($obj->GetAllHotelsResult);
		foreach($result['Chain'] as &$v){
			/*$detail = $this->soap->__soapCall('GetAllChainAttachedInfo', ['parameters' => ['ChainID' => $v['ChainID']]]);
			if(!empty($detail->GetAllChainAttachedInfoResult)){
				$v['detail'] = obj2array($detail->GetAllChainAttachedInfoResult);
			} else{
				$v['detail'] = [];
			}

			$rooms = $this->soap->__soapCall('GetAllRoomType', ['parameters' => ['ChainID' => $v['ChainID']]]);
			if(!empty($rooms->GetAllRoomTypeResult)){
				$v['room_list'] = obj2array($rooms->GetAllRoomTypeResult);
			} else{
				$v['room_list'] = [];
			}*/
		}
		$json = json_encode($result);
//		file_put_contents(FD_PUBLIC.'/yasite2_hotels.json',$json);
		echo $json;
//		$result=xml2array($xml);
//		print_r($result);
	}
	
	public function catchHotels(){
		set_time_limit(9000);
		$json = file_get_contents(FD_PUBLIC . '/yasite2_hotels.json');
		$hotels = json_decode($json, true);
		
		$additions = [];
		$icons = [];
		
		$icon_arr = [
			[
				'code' => '&#xe7;',
				'name' => '停车',
			],
			[
				'code' => '&#xe8;',
				'name' => 'WIFI',
			],
			[
				'code' => '&#xeb;',
				'name' => '热水',
			],
			[
				'code' => '&#xe5;',
				'name' => '叫醒服务',
			],
			[
				'code' => '&#xe9;',
				'name' => '行李寄存',
			],
		];
		
		$this->load->helper('calculate');
		
		foreach($hotels['Chain'] as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['ChainName'],
				'address'     => $v['ChainAddress'],
				'tel'         => $v['Telephone'],
				'intro'       => isset($v['detail']['enc_value']['Summary']) ? $v['detail']['enc_value']['Summary'] : '',
				'short_intro' => isset($v['detail']['enc_value']['Summary']) ? $v['detail']['enc_value']['Summary'] : '',
				'city'        => $v['CityName'],
				'status'      => $v['State'] == 'startbusiness' ? 1 : 0,
				'sort'        => $v['Sort'],
			];
			if(!empty($v['detail']['enc_value']['BaiduPosition']) && strpos($v['detail']['enc_value']['BaiduPosition'], ',') !== false){
				$position = str_replace(["\t", "\n", "\r"], '', $v['detail']['enc_value']['BaiduPosition']);
				$lng_lat = explode(',', $position);
				$lng_lat = bd2gcj($lng_lat[0], $lng_lat[1]);
				
				$data['longitude'] = $lng_lat['longitude'];
				$data['latitude'] = $lng_lat['latitude'];
			}
			
			
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'yasiteiw',
				'pms_auth'           => $this->pms_set['pms_auth'],
				'hotel_web_id'       => $v['ChainID'],
				'pms_room_state_way' => 1,
				'pms_member_way'     => 1,
			];
			
			foreach($icon_arr as $t){
				$icons[] = [
					'inter_id'  => $this->inter_id,
					'hotel_id'  => $hotel_id,
					'type'      => 'hotel_service',
					'room_id'   => 0,
					'image_url' => $t['code'],
					'info'      => $t['name'],
				];
			}
			
			if(!empty($v['room_list']['RoomType'])){
				foreach($v['room_list']['RoomType'] as $t){
					$room_data = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['RoomTypeName'],
						'description' => $t['Description'],
						'sub_des'     => $t['Remark'],
						'nums'        => 0,
						'bed_num'     => $t['BedCount'],
						'sort'        => $t['Sort'],
						'webser_id'   => $t['RoomTypeID'],
					];
					
					$this->db->insert('hotel_rooms', $room_data);
					$room_id = $this->db->insert_id();
					
					foreach($icon_arr as $w){
						$icons[] = [
							'inter_id'  => $this->inter_id,
							'hotel_id'  => $hotel_id,
							'type'      => 'room_service',
							'room_id'   => $room_id,
							'image_url' => $w['code'],
							'info'      => $w['name'],
						];
					}
				}
			}
		}
		
		if($additions){
			$this->db->insert_batch('hotel_additions', $additions);
		}
		if($icons){
			$this->db->insert_batch('hotel_images', $icons);
		}
		
		echo 'success';
		
	}
	
	public function priceset(){
		$rooms = $this->db->from('hotel_rooms')->where(['inter_id' => $this->inter_id])->get()->result_array();
		$params = [];
		
		foreach($rooms as $v){
			for($i = 1; $i <= 6; $i++){
				$params[] = [
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $i,
					'edittime'   => time(),
					'status'     => 1,
				];
			}
		}
		$this->db->insert_batch('hotel_price_set', $params);
		echo 'success';
		
	}
	
	public function test_bill(){
		$order_json = '{"id":"459055","inter_id":"a474337632","orderid":"36147445238777984","coupon_favour":"0.00","complete_reward_given":"0","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"0","complete_point_info":"","web_orderid":"8436","room_codes":"{\"14823\":{\"code\":{\"price_type\":\"pms\",\"extra_info\":{\"type\":\"code\",\"pms_code\":1}},\"room\":{\"webser_id\":\"11\"}}}","web_paid":"0","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","hotel_id":"4023","openid":"oX3WojhfNUD4JzmlwTzuKba1My36","price":"230.00","roomnums":"1","name":"\u5f00\u53d1","tel":"18888888888","order_time":"1474452387","startdate":"20160921","enddate":"20160922","paid":"0","status":"0","holdtime":"18:00","paytype":"daofu","isdel":"0","operate_reason":null,"remark":"","member_no":"2979908","handled":"0","hname":"\u6d4b\u8bd5\u5e97","himg":null,"haddress":"\u6d4b\u8bd5\u5e97","longitude":"","latitude":"","htel":"4000091199","order_datetime":"2016-09-21 18:06:27","order_details":[{"id":"642998","orderid":"36147445238777984","inter_id":"a474337632","room_id":"14823","iprice":"230.00","startdate":"20160921","enddate":"20160922","istatus":"0","allprice":"230.0000","room_no":"","roomname":"\u8c6a\u534e\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"1","room_no_id":"0","price_code_name":"\u95e8\u5e02\u4ef7","handled":"0","webs_orderid":"","real_allprice":"230","club_id":"","grade_all_id":"0","grade_status":"0","leavetime":null,"sub_id":"642998"}],"first_detail":{"id":"642998","orderid":"36147445238777984","inter_id":"a474337632","room_id":"14823","iprice":"230.00","startdate":"20160921","enddate":"20160922","istatus":"0","allprice":"230.0000","room_no":"","roomname":"\u8c6a\u534e\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"1","room_no_id":"0","price_code_name":"\u95e8\u5e02\u4ef7","handled":"0","webs_orderid":"","real_allprice":"230","club_id":"","grade_all_id":"0","grade_status":"0","leavetime":null,"sub_id":"642998"},"ori_price":"230.00"}';
		$order = json_decode($order_json, true);
		
		$this->load->library('PMS_Adapter', [
			'inter_id' => $this->inter_id,
			'hotel_id' => $order['hotel_id'],
		], 'pmsa');
		
		$param = [
			'trans_no' => $order['orderid'],
			'third_no' => time() . time(),
		];
		
		var_dump($this->pmsa->add_web_bill($order, $param));
	}
	
	public function test_trans(){
		$this->load->library('PMS_Adapter', [
			'inter_id' => $this->inter_id,
			'hotel_id' => '4023',
		], 'pmsa');
		
		var_dump($this->serv_api->addTrans(99999, 8436, 3, 20, '使用积分抵扣房费20元'));
	}
	
	public function test_new_order(){
		$web_orderid = '8781';
		$hotel_web_id = '99999';
		
		$params = [
			'chainID' => $hotel_web_id,
			'folioID' => $web_orderid,
		];
//		echo json_encode($params);
		$obj = $this->soap->__soapCall('QueryConnectedOrder', [
			'parameters' => $params
		]);
		
		echo json_encode([
			'parameters' => $params,
			'result'     => json_decode($obj->QueryConnectedOrderResult, true),
		]);
	}
	
	
	public function test_plans(){
		$web_orderid = '8639';
		$hotel_web_id = '99999';
		
		$params = [
			'ChainID' => $hotel_web_id,
			'FolioID' => $web_orderid,
		];
//		echo json_encode($params);
		$obj = $this->soap->__soapCall('QueryRoomRatePlan', [
			'parameters' => $params
		]);
		
		echo json_encode([
			'parameters' => $params,
			'result'     => json_decode($obj->QueryRoomRatePlanResult, true),
		]);
	}
	
	function getprice(){
		$hotel_web_id = $this->input->get('id');
		$result = $this->serv_api->getRoomStatus($hotel_web_id, date('Y-m-d'), date('Y-m-d'));
		print_r($result);
	}
	
	public function lowest_price(){
		set_time_limit(0);
		$list = $this->db->from('hotel_additions')->where(['inter_id' => $this->inter_id])->get()->result_array();
		$params = [];
		$valid_rate = [1, 2, 3, 4, 45];
		
		$first = $list[0];
		
		$this->load->library('PMS_Adapter', [
			'inter_id' => $this->inter_id,
			'hotel_id' => 0
		], 'pmsa');
		
		foreach($list as $v){
			$result = $this->serv_api->getRoomStatus($v['hotel_web_id'], date('Y-m-d'), date('Y-m-d'));
			
			/*$parameters = [
				'ChainID'      => (int)$v['hotel_web_id'],
				'BeginAccDate' => date('Y-m-d'),
				'EndAccDate'   => date('Y-m-d'),
			];

			$result = $this->soap->__soapCall('GetHotelDetailsWithRoomStatus', ['parameters' => $parameters])->GetHotelDetailsWithRoomStatusResult;*/
			
			$price_arr = [];
			if(!empty($result['RoomStatusItems']['QueryRoomStatusItem'])){
				foreach($result['RoomStatusItems']['QueryRoomStatusItem'] as $t){
					if(in_array($t['RoomRateTypeID'], $valid_rate)){
						$price_arr[] = $t['RoomRate'];
					}
				}
			}
			if($price_arr){
				$params[] = [
					'hotel_id'     => $v['hotel_id'],
					'inter_id'     => $v['inter_id'],
					'lowest_price' => min($price_arr),
					'update_time'  => date('Y-m-d H:i:s'),
				];
			}
			
		}
		if($params){
//			$res = $this->db->set_insert_batch($params)->insert_batch('hotel_lowest_price');
//			print_r($res);
			print_r($params);
		}
	}
	
	public function insert_main(){
		$db = $this->load->database('default', true);
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/yasite2_hotels.json');
		$hotel_list = json_decode($json, true);
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/yasite2_rooms.json');
		$result = json_decode($json, true);
		$room_list = [];
		foreach($result as $v){
			$room_list[$v['hotel_id']][] = $v;
		}
		
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/yasite2_lowest.json');
		$result = json_decode($json, true);
		$lowest_list = [];
		foreach($result as $v){
			$lowest_list[$v['hotel_id']] = $v;
		}
		
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/yasite2_images.json');
		$result = json_decode($json, true);
		$hotel_images = [];
		$room_images = [];
		foreach($result as $v){
			if($v['room_id']){
				$room_images[$v['room_id']][] = $v;
			}else{
				$hotel_images[$v['hotel_id']][] = $v;
			}
		}
		
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/yasite2_price_set.json');
		$result = json_decode($json, true);
		$price_set = [];
		foreach($result as $v){
			$price_set[$v['room_id']][] = $v;
		}
		
		
		$params = [];
		$lowest_params = [];
		$image_params = [];
		$price_params = [];
		foreach($hotel_list as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['name'],
				'address'     => $v['address'],
				'tel'         => $v['tel'],
				'latitude'    => $v['latitude'],
				'longitude'   => $v['longitude'],
				'intro'       => $v['intro'],
				'intro_img'   => $v['intro_img'],
				'fax'         => $v['fax'],
				'star'        => $v['star'],
				'province'    => $v['province'],
				'city'        => $v['city'],
				'short_intro' => $v['short_intro'],
				'services'    => $v['services'],
				'email'       => $v['email'],
				'country'     => $v['country'],
				'web'         => $v['web'],
				'status'      => $v['status'],
				'sort'        => $v['sort'],
				'book_policy' => $v['book_policy'],
			];
			$db->insert('hotels_copy', $data);
			$hotel_id = $db->insert_id();
			if(!$params){
				$params[] = [
					'inter_id'           => $this->inter_id,
					'hotel_id'           => 0,
					'pms_type'           => $v['pms_type'],
					'pms_auth'           => $v['pms_auth'],
					'hotel_web_id'       => '',
					'pms_room_state_way' => $v['pms_room_state_way'],
					'pms_member_way'     => $v['pms_member_way'],
				];
			}
			$params[] = [
				'inter_id'           => $this->inter_id,
				'hotel_id'           => $hotel_id,
				'pms_type'           => $v['pms_type'],
				'pms_auth'           => $v['pms_auth'],
				'hotel_web_id'       => $v['hotel_web_id'],
				'pms_room_state_way' => $v['pms_room_state_way'],
				'pms_member_way'     => $v['pms_member_way'],
			];
			
			if(!empty($room_list[$v['hotel_id']])){
				foreach($room_list[$v['hotel_id']] as $t){
					$room_param = $t;
					unset($room_param['room_id']);
					$room_param['inter_id'] = $this->inter_id;
					$room_param['hotel_id'] = $hotel_id;
					
					$db->insert('hotel_rooms_copy', $room_param);
					$room_id = $db->insert_id();
					
					//图片
					if(!empty($room_images[$t['room_id']])){
						foreach($room_images[$t['room_id']] as $w){
							$w['room_id'] = $room_id;
							$w['inter_id'] = $this->inter_id;
							$w['hotel_id'] = $hotel_id;
							$image_params[] = $w;
						}
					}
					
					//价格配置
					if(!empty($price_set[$t['room_id']])){
						foreach($price_set[$t['room_id']] as $w){
							unset($w['bonus_condition']);
							$w['room_id'] = $room_id;
							$w['inter_id'] = $this->inter_id;
							$w['hotel_id'] = $hotel_id;
							$price_params[] = $w;
						}
					}
				}
			}
			
			//图片
			if(!empty($hotel_images[$v['hotel_id']])){
				foreach($hotel_images[$v['hotel_id']] as $w){
					$w['inter_id'] = $this->inter_id;
					$w['hotel_id'] = $hotel_id;
					$image_params[] = $w;
				}
			}
			
			//最低价
			if(!empty($lowest_list[$v['hotel_id']])){
				$t = $lowest_list[$v['hotel_id']];
				$t['hotel_id'] = $hotel_id;
				$t['inter_id'] = $this->inter_id;
				$lowest_params[] = $t;
			}
		}
		
		
		if($params){
			$db->insert_batch('hotel_additions_copy', $params);
		}
		
		if($image_params){
			$db->insert_batch('hotel_images_copy', $image_params);
		}
		
		if($price_params){
			$db->insert_batch('hotel_price_set_copy', $price_params);
		}
		
		/*if($room_params){
			$db->insert_batch('hotel_rooms_copy', $room_params);
		}*/
		if($lowest_params){
			$db->insert_batch('hotel_lowest_price_copy', $lowest_params);
		}
		
		echo 'success';
	}
	
	public function merge_set(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/yeste_roomsp.json');
		$room_list = json_decode($json, true);
		$params = array();
//		$t = 7;
		foreach($room_list as $v){
//			if($v['hotel_id']!=3690){
			for($t = 8; $t <= 13; $t++){
				$params[] = array(
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $t,
					'edittime'   => time(),
					'status'     => 1,
				);
			}
//			}
		
		}
		$db = $this->load->database('default', true);
		if($params){
//			echo json_encode($params);
			$db->insert_batch('hotel_price_set_copy', $params);
		}
		echo 'success';
	}
	
	public function testcoupon(){
		$json = '{"cash_token":[{"amount":"20.00","code":6776992,"title":"20元订房代金券","is_wxcard":0,"wxcard_id":"","extra":{"type":"voucher"}}]}';
		$coupon_arr = json_decode($json, true);
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
			echo $remark;
			exit;
		}
		var_dump(is_array($coupon_arr));
	}
	
	public function teststate(){
		$json = '{"id":"764936","hotel_id":"3924","openid":"oULLgjhzsLYflCygPRJ0AFPmDVSc","inter_id":"a472731996","price":"552.00","roomnums":"1","name":"\u59da\u56fd\u6e05","tel":"13506213842","order_time":"1478171668","startdate":"20161105","enddate":"20161108","paid":"1","orderid":"Sc147817166887683","status":"2","holdtime":"2016-11-08 12:00","paytype":"weixin","isdel":"0","operate_reason":"\u652f\u4ed8\u5b8c\u6210","remark":"","member_no":"13506213842","handled":"0","coupon_favour":"0.00","complete_reward_given":"1","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"1","complete_point_info":"","web_orderid":"7204","room_codes":"{\"17174\":{\"code\":{\"price_type\":\"common\",\"extra_info\":{\"type\":\"code\",\"pms_code\":305}},\"room\":{\"webser_id\":\"26\"}}}","web_paid":"1","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","refund":"0"}';
		$order = json_decode($json, true);
		
		$this->load->model('hotel/pms/Yasiteiw_hotel_model', 'pms');
		
		$pms_set = $this->db->where([
			'inter_id' => $this->inter_id,
			'hotel_id' => 0
		])->from('hotel_additions')->get()->row_array();
		var_dump($this->pms->update_web_order($this->inter_id, $order, $pms_set));
		exit;
	}
	
	public function test_order(){
		$params = [
			'',
			'ChainID' => '41',
			'FolioID' => '25088',
		];
		$obj = $this->soap->__soapCall('QueryOrder', [
			'parameters' => $params
		]);
		print_r($this->soap->__getLastRequest());
	}
	
	public function show(){
		print_r([
			$this->soap->__getTypes()
		]);
	}
	
	public function check_price(){
		$json = file_get_contents(FD_PUBLIC . '/yasite/problem_order.json');
		$list = json_decode($json, true);
		$res = [];
		set_time_limit(0);
		foreach($list as $v){
			if($v['webs_orderid']){
				$pms_res = $this->serv_api->calculatRoomRate($v['hotel_web_id'], $v['webs_orderid']);
			}else{
				$pms_res = $this->serv_api->calculatRoomRate($v['hotel_web_id'], $v['web_orderid']);
			}
			
			if($pms_res['result'] == 'succeed' && !empty($pms_res['TotalRoomRate'])){
				$ori_total = array_sum(explode(',', $v['allprice'])); //本地记录的不含优惠总价
				$real_total = array_sum(explode(',', $v['real_allprice']));//含优惠的总价
				$discount_price = $ori_total - $real_total;
				$new_price = $pms_res['TotalRoomRate'] - $discount_price;
				if($v['iprice'] - $new_price != 0){
					$res[] = [
						'sub_id'    => $v['item_id'],
						'orderid'   => $v['orderid'],
						'inter_id'  => $this->inter_id,
						'new_price' => $new_price,
						'iprice'    => $v['iprice'],
					];
				}
			}
		}
		if($res){
			file_put_contents(FD_PUBLIC . '/yasite/fixed.json', json_encode($res));
		}
	}
	
	public function fixed_price(){
		$json = file_get_contents(FD_PUBLIC . '/yasite/problem_order.json');
		$orders = json_decode($json, true);
		$res = [];
		foreach($orders as $v){
			$res[$v['item_id']] = $v;
		}
		$json = file_get_contents(FD_PUBLIC . '/yasite/fixed.json');
		$list1 = json_decode($json, true);
		$_list = [];
		
		$json = file_get_contents(FD_PUBLIC . '/yasite/old.json');
		$list2 = json_decode($json, true);
		foreach($list2 as $v){
			$_list[] = $v['sub_id'];
		}
		$list = [];
		foreach($list1 as $v){
			if(!in_array($v['sub_id'], $_list)){
				$list[] = $v;
			}
		}
		
		
		$json = file_get_contents(FD_PUBLIC . '/yasite/dmo1.json');
		$temp = json_decode($json, true);
		$exists = [];
		foreach($temp as $v){
			$exists[$v['grade_id']] = $v;
		}
		$sql = "";
		$fix = "";
		foreach($list as $v){
			$sql .= "update iwide_hotel_order_items set iprice = '" . floatval($v['new_price']) . "' where id = " . $v['sub_id'] . " and inter_id='" . $v['inter_id'] . "';\n";
			
			if(isset($exists[$v['sub_id']]) && isset($res[$v['sub_id']])){
				if($exists[$v['sub_id']]['order_amount'] - $v['new_price'] != 0){
					$fix .= "update iwide_distribute_grade_all set grade_amount = '" . floatval($v['new_price']) . "', order_amount = '" . floatval($v['new_price']) . "' where grade_id = '" . $v['sub_id'] . "' and grade_table = 'iwide_hotels_order';\n";
				}
				/*$t=$res[$v['sub_id']];
				$day_diff=ceil((strtotime($t['real_enddate'])-strtotime($t['startdate']))/86400);
				$point=bcmul($day_diff,0.01,2);
				$fix .= "update iwide_distribute_grade_all set grade_amount = '" . floatval($v['new_price']) . "', grade_total = '" . bcmul($point,1,2) . "' where grade_id = " . $v['sub_id'] . " and grade_table = 'iwide_hotels_order';\n";*/
			}
		}
		echo $sql . "\n" . $fix;
	}
	
	public function check_oid(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/prob_pmsoid.json');
		$list = json_decode($json, true);
		$arr = [];
		foreach($list as $v){
			$arr[] = $v['web_orderid'];
		}
		echo implode(',', $arr);
	}
	
	public function checkOrderAmount(){
		$params = [
			[
				'hotel_web_id' => 22,
				'web_orderid'  => 39924,
			],
			
			[
				'hotel_web_id' => 38,
				'web_orderid'  => 28691,
			]
		];
		
		$res = [];
		foreach($params as $v){
			$res[] = $this->serv_api->getRoomAccTrans($v['hotel_web_id'], $v['web_orderid']);
		}
		print_r($res);
	}
	
	public function findOrder(){
		$json = '[{"ChainID":"41","FolioID":"28888"},{"ChainID":"26","FolioID":"22909"},{"ChainID":"29","FolioID":"40917"},{"ChainID":"22","FolioID":"43096"},{"ChainID":"22","FolioID":"43097"},{"ChainID":"32","FolioID":"35044"},{"ChainID":"41","FolioID":"28890"},{"ChainID":"41","FolioID":"28891"},{"ChainID":"32","FolioID":"35045"},{"ChainID":"29","FolioID":"40918"},{"ChainID":"33","FolioID":"27616"},{"ChainID":"32","FolioID":"35046"},{"ChainID":"10","FolioID":"43529"},{"ChainID":"76","FolioID":"6765"},{"ChainID":"23","FolioID":"55170"},{"ChainID":"15","FolioID":"37805"},{"ChainID":"18","FolioID":"32697"},{"ChainID":"18","FolioID":"32698"},{"ChainID":"33","FolioID":"27619"},{"ChainID":"16","FolioID":"40211"},{"ChainID":"34","FolioID":"26657"},{"ChainID":"26","FolioID":"22912"},{"ChainID":"35","FolioID":"15566"},{"ChainID":"41","FolioID":"28888"}]';
		$list = json_decode($json, true);
		$result = [];
		foreach($list as $v){
			$where = [
				'oa.web_orderid'  => $v['FolioID'],
				'ha.hotel_web_id' => $v['ChainID'],
				'o.paid'          => 1,
				'oa.web_paid'     => 2,
			];
			$row = $this->db->select('p.*')->from('pay_log p')->join('hotel_orders o', 'o.orderid=p.out_trade_no', 'inner')->join('hotel_order_additions oa', 'oa.orderid=p.out_trade_no', 'inner')->join('hotel_additions ha', 'ha.hotel_id=o.hotel_id', 'inner')->where($where)->get()->row_array();
			exit($this->db->last_query());
			$result[] = $row;
		}
		print_r($result);
	}
	
	public function testmonth(){
		$json = file_get_contents(FD_PUBLIC . '/yasite/month.json');
		$list = json_decode($json, true);
		$result = [];
		foreach($list['GetHotelDetailsWithRoomStatusResult']['RoomStatusItems']['QueryRoomStatusItem'] as $v){
			if($v['RoomRateTypeID'] == 1 && $v['RoomTypeID'] == 1){
				$result[] = $v;
			}
		}
		echo json_encode($result);
		
	}
	
	public function freepriceset(){
		$json = '[{"room_id":"17154","hotel_id":"3920","inter_id":"a472731996"}, {"room_id":"17155","hotel_id":"3920","inter_id":"a472731996"}, {"room_id":"17175","hotel_id":"3925","inter_id":"a472731996"}, {"room_id":"17176","hotel_id":"3925","inter_id":"a472731996"}, {"room_id":"17177","hotel_id":"3925","inter_id":"a472731996"}, {"room_id":"19687","hotel_id":"3875","inter_id":"a472731996"}, {"room_id":"20523","hotel_id":"3861","inter_id":"a472731996"}, {"room_id":"20524","hotel_id":"3861","inter_id":"a472731996"}, {"room_id":"20525","hotel_id":"3921","inter_id":"a472731996"}, {"room_id":"20526","hotel_id":"3921","inter_id":"a472731996"}, {"room_id":"20527","hotel_id":"3921","inter_id":"a472731996"}, {"room_id":"21966","hotel_id":"4391","inter_id":"a472731996"}, {"room_id":"21967","hotel_id":"4391","inter_id":"a472731996"}, {"room_id":"21979","hotel_id":"4599","inter_id":"a472731996"}, {"room_id":"21980","hotel_id":"4599","inter_id":"a472731996"}, {"room_id":"22419","hotel_id":"4673","inter_id":"a472731996"}, {"room_id":"22420","hotel_id":"4673","inter_id":"a472731996"}, {"room_id":"22610","hotel_id":"4419","inter_id":"a472731996"}, {"room_id":"22611","hotel_id":"4419","inter_id":"a472731996"}]';
		$rooms = json_decode($json, true);
		$params = [];
		foreach($rooms as $v){
			for($i = 7; $i <= 7; $i++){
				$params[] = [
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $i,
					'edittime'   => time(),
					'status'     => 1,
				];
			}
		}
		$db = $this->load->database('default', true);
		$db->insert_batch('hotel_price_set_copy', $params);
		echo 'success';
	}

	public function newset(){
		$db=$this->load->database('default',true);
		
		$json=file_get_contents(FD_PUBLIC.'/yasite/rooms_no26.json');
		$rooms=json_decode($json,true);
		$params=[];
		foreach($rooms as $v){
			for($i=26;$i<=26;$i++){
				$params[] = [
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $i,
					'edittime'   => time(),
					'status'     => 1,
					'nums'       => 3,
				];
			}
		}
		$db->insert_batch('hotel_price_set_copy',$params);
		
		echo 'success';
	}
	
	public function month_test(){
		$json=file_get_contents(FD_PUBLIC.'/tmp_data/yasite_test.json');
		echo $json;
	}
	
	public function add_trans(){
		set_time_limit(900);
		$json=file_get_contents(FD_PUBLIC.'/tmp_data/orderlist_yasiteiw.json');
		$list=json_decode($json,true);
		$cont=count($list);
//		$order=$list[0];
//		exit(json_encode($order));
		for($i=1;$i<$cont;$i++){
			$order=$list[$i];
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
					$res = $this->serv_api->addTrans($order['hotel_web_id'], $order['web_orderid'], 1, $order['coupon_favour'], $remark);
					echo json_encode($res)."\n";
				}
			}
		}
	}
	
	public function pms_priceset(){
		$json=file_get_contents(FD_PUBLIC.'/yasite/yesite_rooms.json');
		$rooms=json_decode($json,true);
		$params = [];
		
		foreach($rooms as $v){
			for($i = 1; $i <= 6; $i++){
				$params[] = [
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $i,
					'edittime'   => time(),
					'status'     => 1,
				];
			}
		}
		$this->db->insert_batch('hotel_price_set', $params);
		echo 'success';
		
	}
	
	public function querySubs(){
		$res=$this->serv_api->queryConnectedOrder('72','18931');
		print_r($res);
	}
	
}