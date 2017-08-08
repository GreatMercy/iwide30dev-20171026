<?php

class Yage extends MY_Controller{
	private $inter_id = 'a465195239';
	private $ser_api;

	private $pms_set;

	public function __construct(){
		parent::__construct();
		$this->load->model('hotel/pms/Yage_hotel_model', 'pms');
//		$this->ser_api = new YageAPI(0);

		$this->pms_set = array(
//			'hotel_web_id' => 'AS051801', //68007
'pms_auth' => json_encode(array(
	                          'url'    => $this->ser_api->api0,
	                          'secret' => $this->ser_api->sec0,
                          )),
		);
	}


	public function fixpms(){
		$this->db->update('hotel_additions', array('pms_auth' => $this->pms_set['pms_auth']), array('inter_id' => $this->inter_id));
	}

	private $current_hotel = array(
		array(
			'inter_id'           => 'a465195239',
			'hotel_id'           => '2626',
			'pms_type'           => 'yage',
			'pms_auth'           => '{"url":"http:\\/\\/218.245.5.41\\/KWS_TRAIN\\/","secret":"277c8dab-aa63-40c3-8287-ed5c88395ec4"}',
			'hotel_web_id'       => '000001',
			'pms_room_state_way' => '1',
			'pms_member_way'     => '1'
		),
		array(
			'inter_id'           => 'a465195239',
			'hotel_id'           => '2627',
			'pms_type'           => 'yage',
			'pms_auth'           => '{"url":"http:\\/\\/218.245.5.41\\/kws_www\\/","secret":"277c8dab-aa63-40c3-8287-ed5c88395ec4"}',
			'hotel_web_id'       => 'AB031201',
			'pms_room_state_way' => '1',
			'pms_member_way'     => '1'
		),
		array(
			'inter_id'           => 'a465195239',
			'hotel_id'           => '2628',
			'pms_type'           => 'yage',
			'pms_auth'           => '{"url":"http:\\/\\/218.245.5.41\\/kws_www\\/","secret":"277c8dab-aa63-40c3-8287-ed5c88395ec4"}',
			'hotel_web_id'       => 'AG085801',
			'pms_room_state_way' => '1',
			'pms_member_way'     => '1'
		),
		array(
			'inter_id'           => 'a465195239',
			'hotel_id'           => '2629',
			'pms_type'           => 'yage',
			'pms_auth'           => '{"url":"http:\\/\\/218.245.5.41\\/kws_www\\/","secret":"277c8dab-aa63-40c3-8287-ed5c88395ec4"}',
			'hotel_web_id'       => 'AH028001',
			'pms_room_state_way' => '1',
			'pms_member_way'     => '1'
		),
		array(
			'inter_id'           => 'a465195239',
			'hotel_id'           => '2630',
			'pms_type'           => 'yage',
			'pms_auth'           => '{"url":"http:\\/\\/218.245.5.41\\/KWS_TRAIN\\/","secret":"277c8dab-aa63-40c3-8287-ed5c88395ec4"}',
			'hotel_web_id'       => 'AR031801',
			'pms_room_state_way' => '1',
			'pms_member_way'     => '1'
		),
		array(
			'inter_id'           => 'a465195239',
			'hotel_id'           => '2631',
			'pms_type'           => 'yage',
			'pms_auth'           => '{"url":"http:\\/\\/218.245.5.41\\/KWS_TRAIN\\/","secret":"277c8dab-aa63-40c3-8287-ed5c88395ec4"}',
			'hotel_web_id'       => 'AS047702',
			'pms_room_state_way' => '1',
			'pms_member_way'     => '1'
		),
		array(
			'inter_id'           => 'a465195239',
			'hotel_id'           => '2632',
			'pms_type'           => 'yage',
			'pms_auth'           => '{"url":"http:\\/\\/218.245.5.41\\/kws_www\\/","secret":"277c8dab-aa63-40c3-8287-ed5c88395ec4"}',
			'hotel_web_id'       => 'AS051801',
			'pms_room_state_way' => '1',
			'pms_member_way'     => '1'
		)
	);

	private $zl = array(
		'AG085801',
		'AB031201',
		'AH028001',
		'AS051801'
	);
	private $jm = array(
		'GBJCT',
		'GSZHY',
		'GTJKG',
		'GYYYY',
		'GYZZJ',
		'IJXGZ',
		'INCNC',
		'INMWH',
		'NSZSF',
		'NSZSH'
	);

	public function getallh(){
		$this->ser_api->switchMode(1);
		$hotels = $this->ser_api->getHotels();
		print_r($hotels);
	}

	public function get_hotels(){
		set_time_limit(0);

		$current = array();
		/*foreach($this->current_hotel as $v){
			$current[] = $v['hotel_web_id'];
		}*/

		$price_list = array(
			array('price_code' => 1),
			array('price_code' => 2),
			array('price_code' => 3),
			array('price_code' => 4),
			array('price_code' => 5),
		);

//		$this->ser_api->switchMode(1);
		/*if(!file_exists(FD_PUBLIC . '/yage_hotel.json')){
			set_time_limit(0);
			$hotels = $this->ser_api->getHotels();
			$list = array();
			foreach($hotels as $v){
				if(!in_array($v['Code'], $current) && in_array($v['Code'], $this->zl)){
					$v['room_list'] = $this->ser_api->getHotelRoomType($v['Code']);
					$list[] = $v;
				}
			}

			$this->ser_api->switchMode(1);
			$hotels = $this->ser_api->getHotels();
			foreach($hotels as $v){
				if(!in_array($v['Code'], $current) && in_array($v['Code'], $this->jm)){
					$v['room_list'] = $this->ser_api->getHotelRoomType($v['Code']);
					$list[] = $v;
				}
			}
			file_put_contents(FD_PUBLIC . '/yage_hotel.json', json_encode($list));
		} else{
			$hotel_json = file_get_contents(FD_PUBLIC . '/yage_hotel.json');
			$list = json_decode($hotel_json, true);
		}*/

		$this->ser_api->switchMode(0);
		$hotels = $this->ser_api->getHotels();
		$list = array();
		foreach($hotels as $v){
			if(!in_array($v['Code'], $current) && in_array($v['Code'], $this->zl)){
				$v['room_list'] = $this->ser_api->getHotelRoomType($v['Code']);
				$list[] = $v;
			}
		}

		$this->ser_api->switchMode(1);
		$hotels = $this->ser_api->getHotels();
		foreach($hotels as $v){
			if(!in_array($v['Code'], $current) && in_array($v['Code'], $this->jm)){
				$v['room_list'] = $this->ser_api->getHotelRoomType($v['Code']);
				$list[] = $v;
			}
		}
		echo json_encode($list);
		return $list;
	}

	public function newRoom(){
		$this->ser_api->switchMode(1);
		$room_list = $this->ser_api->getHotelRoomType('NSZSF');
		$exists = array(
			'DB',
			'JS',
			'EK'
		);
		print_r($room_list);
		exit;
		$data = array();
		foreach($room_list as $v){
			if(!in_array($v['RoomType']['code'], $exists)){
				$name_arr = explode('|', $v['name']);
				$data[] = array(
					'hotel_id'  => 2746,
					'inter_id'  => $this->inter_id,
					'name'      => $name_arr[0],
					'webser_id' => $v['RoomType']['code']
				);
			}
		}

		/*if($data){
			$this->db->insert_batch('hotel_rooms_copy',$data);
		}
		echo 'success';*/

	}

	public function downroomicon(){
		$hotels = $this->get_hotels();

		$this->load->model('hotel/pms/Yage_hotel_model', 'pms');
		$db = $this->pms->_shard_db();
		$hotel_add = $db->from('hotel_additions_copy')->get()->result_array();
		$hotel2web = array();
		foreach($hotel_add as $v){
			$hotel2web[$v['hotel_web_id']] = $v['hotel_id'];
		}
		$hotel_list = array();
		$room_list = array();
		foreach($hotels as $v){
			if(empty($hotel2web[$v['Code']])){
				continue;
			}
			if(!empty($v['room_list'])){
//				print_r($v['room_list']);
				is_array(current($v['room_list'])) or $v['room_list'] = array($v['room_list']);
				foreach($v['room_list'] as $t){
					$room_list[$hotel2web[$v['Code']]][$t['RoomType']['code']] = $t;
				}
//					$hotel_list[$hotel2web[$v['Code']]]=$v;
			}
		}
		$list = $db->from('hotel_rooms_copy')->get()->result_array();
		$icons = array(
			'水壶'   => '&#xeb;',
			'宽带上网' => '&#xe3;',
			'Wifi' => '&#xe8;',
			'吹风机'  => '&#xe4;',
		);
		$data = array();
		foreach($list as $v){
			if(empty($room_list[$v['hotel_id']][$v['webser_id']])){
				continue;
			}
			$t = $room_list[$v['hotel_id']][$v['webser_id']];
			if(empty($t['HotelInstallations']['CommonInfo'])){
				continue;
			}
			is_array(current($t['HotelInstallations']['CommonInfo'])) or $t['HotelInstallations']['CommonInfo'] = array($t['HotelInstallations']['CommonInfo']);
			foreach($t['HotelInstallations']['CommonInfo'] as $w){
				$icon_arr = explode('|', $w['name']);
				if(array_key_exists($icon_arr[0], $icons)){
					$data[] = array(
						'inter_id'  => $v['inter_id'],
						'hotel_id'  => $v['hotel_id'],
						'room_id'   => $v['room_id'],
						'image_url' => $icons[$icon_arr[0]],
						'type'      => 'hotel_room_service',
					);
				}
			}

//			$web_detail=$hotel_list[$v['hotel_id']];
			/*if(!empty($web_detail['room_list'])){
				is_array(current($web_detail['room_list'])) or $web_detail['room_list']=array($web_detail['room_list']);
				foreach($web_detail['room_list'] as $t){
					if(empty($t['HotelInstallations']['CommonInfo'])) continue;
					foreach($t['HotelInstallations']['CommonInfo'] as $w){
						$icon_arr=explode('|',$w['name']);
						if(array_key_exists($icon_arr[0],$icons)){
							$data[]=array(
								'inter_id'=>$v['inter_id'],
							    'hotel_id'=>$v['hotel_id'],
							    'room_id'=>$v['room_id'],
							    'image_url'=>$icons[$icon_arr[0]],
							    'type'=>'hotel_room_service',
							);
						}
					}
					/*$icon_arr=explode('|',$t['Installations']);
					$icon_arr=explode(',',$icon_arr[0]);
					foreach($icon_arr as $v){
					}*
				}
			}*/
		}

		if($data){
			$db->set_insert_batch($data)->insert_batch('hotel_images_copy');
			echo 'success';
		}

	}

	public function insertaddi(){
		$hotel_id = 3306;
		$hotel_web_id = 'GNCKM';
		$pms_auth = json_encode(array(
			                        'url'    => $this->ser_api->api1,
			                        'secret' => $this->ser_api->sec1,
		                        ));

		$data = array(
			'hotel_id'           => $hotel_id,
			'inter_id'           => $this->inter_id,
			'pms_type'           => 'yage',
			'pms_auth'           => $pms_auth,
			'hotel_web_id'       => $hotel_web_id,
			'pms_room_state_way' => 3,
			'pms_member_way'     => 1,
		);

		$this->db->insert('hotel_additions_copy', $data);
		echo $this->db->last_query();
	}

	public function catchhotel(){
		$hotel_list = $this->get_hotels();
		$db = $this->pms->_shard_db();
		/*$zl_codes = array(
			'AG085801',
			'AS051801',
			'AH028001',
			'AB031201'
		);*/
		foreach($hotel_list as $v){
			$add_arr = explode('|', $v['Address']);
			$params = array(
				'inter_id'    => $this->inter_id,
				'name'        => $v['Name'],
				'address'     => $add_arr[0],
				'tel'         => $v['Phone'],
				'email'       => $v['Email'],
				//				'latitude'    => '',
				//				'longitude'   => '',
				'intro'       => $v['Desc'],
				'short_intro' => $v['Desc'],
				//				'intro_img'   => $img,
				'fax'         => $v['Fax'],
				'star'        => $v['Stars'],
				'province'    => $v['Province']['code'],
				'city'        => $v['CityName'],
			);

			$db->set($params)->insert('hotels_copy');
			$insert_id = $this->pms->insert_id();

			if(in_array($v['Code'], $this->zl)){
				$pms_auth = json_encode(array(
					                        'url'    => $this->ser_api->api0,
					                        'secret' => $this->ser_api->sec0,
				                        ));
			} else{
				$pms_auth = json_encode(array(
					                        'url'    => $this->ser_api->api1,
					                        'secret' => $this->ser_api->sec1,
				                        ));
			}

			$data = array(
				'hotel_id'           => $insert_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'yage',
				'pms_auth'           => $pms_auth,
				'hotel_web_id'       => $v['Code'],
				'pms_room_state_way' => 3,
				'pms_member_way'     => 1,
			);

			$db->set($data)->insert('hotel_additions_copy');

			//房型
			if(!empty($v['room_list'])){
				is_array(current($v['room_list'])) or $v['room_list'] = array($v['room_list']);
				$room_data = array();
				foreach($v['room_list'] as $t){
					$name_arr = explode('|', $t['name']);
					$des_arr = explode('|', $t['Des']);
					$room_data[] = array(
						'hotel_id'    => $insert_id,
						'inter_id'    => $this->inter_id,
						'name'        => $name_arr[0],
						'description' => $des_arr[0],
						'sub_des'     => '',
						'nums'        => 0,
						//						'bed_num'     => $t['numadults'],
						//						'sort'        => $t['Sort'],
						'webser_id'   => $t['RoomType']['code'],
						//						'room_img'    => $rimg,
						//						'area'        => $t['area'],
					);
				}
				if($room_data){
					$db->set_insert_batch($room_data)->insert_batch('hotel_rooms_copy');
				}
			}
		}
		echo 'success';
	}

	public function getlowest(){
		$data = file_get_contents(FD_PUBLIC . '/yage_price.json');
		$data = json_decode($data, true);

		if($data){
			$this->load->model('hotel/pms/Yage_hotel_model', 'pms');
			$db = $this->pms->_shard_db();
			$db->set_insert_batch($data)->insert_batch('hotel_lowest_price_copy');
		}
		echo 'success';
	}

	public function newhloweest(){
		$hotels = array(
			array(
				'inter_id'=>$this->inter_id,
				'hotel_id'     => 3299,
				'hotel_web_id' => 'NGDHZ',
				'pms_auth'     => json_encode(array(
					                              'url'    => $this->ser_api->api1,
					                              'secret' => $this->ser_api->sec1,
				                              ))
			),
			array(
				'inter_id'=>$this->inter_id,
				'hotel_id'     => 3306,
				'hotel_web_id' => 'GNCKM',
				'pms_auth'     => json_encode(array(
					                              'url'    => $this->ser_api->api1,
					                              'secret' => $this->ser_api->sec1,
				                              ))
			),
		);
		$data = array();

		$params = array(
			'arrival'   => date('Y-m-d'),
			'departure' => date('Y-m-d', time() + 86400),
			'room_num'  => 1,
		);
		foreach($hotels as $v){
			$params['hotel_code'] = $v['hotel_web_id'];
			$this->ser_api->setApiAuth(json_decode($v['pms_auth'], true));
			$rate = $this->ser_api->getAvailability($params);
			if(isset($rate['RateInfos']['RateInfo']['RoomRateDetails']['RoomRateDetail'])){
				$t = $rate['RateInfos']['RateInfo']['RoomRateDetails']['RoomRateDetail'];
				$min_price = null;
				foreach($t as $w){
					if(!empty($w['RateDetailDailys']['RateDetailDaily']['prs_1'])){
						if($min_price === null){
							$min_price = (int)$w['RateDetailDailys']['RateDetailDaily']['prs_1'];
						} else{
							$min_price = min($min_price, (int)$w['RateDetailDailys']['RateDetailDaily']['prs_1']);
						}
					}
				}
				$price_list[$v['hotel_web_id']] = $min_price;
				$data[] = array(
					'hotel_id'     => $v['hotel_id'],
					'inter_id'     => $v['inter_id'],
					'lowest_price' => $min_price,
					'update_time'  => date('Y-m-d H:i:s'),
				);
			}
		}

		if($data){
			$this->db->set_insert_batch($data)->insert_batch('hotel_lowest_price_copy');
			echo $this->db->last_query();
		}
	}

	public function lowestprice(){
		$this->load->model('hotel/pms/Yage_hotel_model', 'pms');
		$db = $this->pms->_shard_db();
		if(!file_exists(FD_PUBLIC . '/yage_price.json')){
			$hotels = $db->where(array('inter_id' => $this->inter_id))->from('hotel_additions_copy')->get()->result_array();
//		print_r($hotels);exit;
//			$db->where(array('inter_id' => $this->inter_id))->from('hotel_lowest_price')->delete();

//			$hotels = $this->get_hotels();
			$params = array(
				'arrival'   => '2016-07-01',
				'departure' => '2016-07-02',
				'room_num'  => 1,
			);
			$price_list = array();
			$data = array();
			foreach($hotels as $v){
				$params['hotel_code'] = $v['hotel_web_id'];
				$this->ser_api->setApiAuth(json_decode($v['pms_auth'], true));
				$rate = $this->ser_api->getAvailability($params);
				print_r($rate);
				if(isset($rate['RateInfos']['RateInfo']['RoomRateDetails']['RoomRateDetail'])){
					$t = $rate['RateInfos']['RateInfo']['RoomRateDetails']['RoomRateDetail'];
					$min_price = null;
					foreach($t as $w){
						if(!empty($w['RateDetailDailys']['RateDetailDaily']['prs_1'])){
							if($min_price === null){
								$min_price = (int)$w['RateDetailDailys']['RateDetailDaily']['prs_1'];
							} else{
								$min_price = min($min_price, (int)$w['RateDetailDailys']['RateDetailDaily']['prs_1']);
							}
						}
					}
					$price_list[$v['hotel_web_id']] = $min_price;
					$data[] = array(
						'hotel_id'     => $v['hotel_id'],
						'inter_id'     => $v['inter_id'],
						'lowest_price' => $min_price,
						'update_time'  => date('Y-m-d H:i:s'),
					);
				}
			}

			file_put_contents(FD_PUBLIC . '/yage_price.json', json_encode($data));
		} else{
			$data = file_get_contents(FD_PUBLIC . '/yage_price.json');
			$data = json_decode($data, true);
		}
		print_r($data);
	}

	public function fixAddr(){
		$hotels = $this->get_hotels();
		$db = $this->pms->_shard_db();
		foreach($hotels as $v){
			$hotel_id = $this->getHotelIdByWebId($v['Code']);
			$add_arr = explode('|', $v['Address']);
			$db->update('iwide_hotels', array('address' => $add_arr[0]), array('hotel_id' => $hotel_id));
		}
	}

	public function getHotelIdByWebId($webid){
		static $static = array();
		if(isset($static[$webid])){
			return $static[$webid];
		}

		$db = $this->pms->_shard_db();
		$row = $db->from('hotel_additions')->select('hotel_id')->where(array(
			                                                               'inter_id'     => $this->inter_id,
			                                                               'hotel_web_id' => $webid
		                                                               ))->get()->row_array();
		if(empty($row)){
			$static[$webid] = 0;
		} else{
			$static[$webid] = $row['hotel_id'];
		}
		return $static[$webid];
	}

	public function testroomtype(){
		$this->pms->get_web_roomtype($this->pms_set, array(), '2016-06-12', '2016-06-13');
	}

	public function hotels_down(){
		$hotel_list = $this->get_hotels();
		$db = $this->pms->_shard_db();
		$zl_codes = array(
			'AG085801',
			'AS051801',
			'AH028001',
			'AB031201'
		);
		foreach($hotel_list as &$v){
			$add_arr = explode('|', $v['Address']);
			$params = array(
				'inter_id'    => $this->inter_id,
				'name'        => $v['Name'],
				'address'     => $add_arr[0],
				'tel'         => $v['Phone'],
				'email'       => $v['Email'],
				//				'latitude'    => '',
				//				'longitude'   => '',
				'intro'       => $v['Desc'],
				'short_intro' => $v['Desc'],
				//				'intro_img'   => $img,
				'fax'         => $v['Fax'],
				'star'        => $v['Stars'],
				'province'    => $v['Province']['code'],
				'city'        => $v['CityName'],
			);
		}
		$db->set_insert_batch($params)->insert_batch('hotels_copy');
	}

	public function booking(){
//		$order_json = '{"id":"355920","inter_id":"a465195239","orderid":"36146641811229755","coupon_favour":"0.00","complete_reward_given":"0","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"0","complete_point_info":"","web_orderid":"","room_codes":"{\"10899\":{\"code\":{\"price_type\":\"pms\",\"extra_info\":{\"type\":\"code\",\"pms_code\":\"LO30\"}},\"room\":{\"webser_id\":\"BTW\"}}}","web_paid":"0","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","hotel_id":"2791","openid":"oX3WojhfNUD4JzmlwTzuKba1My36","price":"509.00","roomnums":"1","name":"\u6d4b\u8bd5","tel":"12345678912","order_time":"1466418112","startdate":"20160620","enddate":"20160621","paid":"0","status":"0","holdtime":"18:00","paytype":"daofu","isdel":"0","operate_reason":null,"remark":"","member_no":"11282295","handled":"0","hname":"\u5317\u4eac\u5927\u96e8\u6fb3\u65af\u7279","himg":null,"haddress":"\u5317\u4eac \u671d\u9633\u533a \u4eac\u987a\u8def99\u53f7","longitude":"","latitude":"","htel":"","order_datetime":"2016-06-20 18:21:52","order_details":[{"id":"642356","orderid":"36146641811229755","inter_id":"a465195239","room_id":"10899","iprice":"509.00","startdate":"20160620","enddate":"20160621","istatus":"0","allprice":"509.00","room_no":"","roomname":"\u5546\u52a1\u53cc\u4eba\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"LO30","room_no_id":"0","price_code_name":"\u96c6\u56e2\u5b98\u7f51\u4ef7","handled":"0","webs_orderid":"","real_allprice":"509","sub_id":"642356"}],"first_detail":{"id":"642356","orderid":"36146641811229755","inter_id":"a465195239","room_id":"10899","iprice":"509.00","startdate":"20160620","enddate":"20160621","istatus":"0","allprice":"509.00","room_no":"","roomname":"\u5546\u52a1\u53cc\u4eba\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"LO30","room_no_id":"0","price_code_name":"\u96c6\u56e2\u5b98\u7f51\u4ef7","handled":"0","webs_orderid":"","real_allprice":"509","sub_id":"642356"},"ori_price":"509.00"}';
		$order_json = '{"id":"355925","inter_id":"a465195239","orderid":"36146641934039257","coupon_favour":"0.00","complete_reward_given":"0","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"0","complete_point_info":"","web_orderid":"91099","room_codes":"{\"10892\":{\"code\":{\"price_type\":\"pms\",\"extra_info\":{\"type\":\"code\",\"pms_code\":\"LO32\"}},\"room\":{\"webser_id\":\"DKI\"}}}","web_paid":"0","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","hotel_id":"2790","openid":"oX3WojhfNUD4JzmlwTzuKba1My36","price":"416.00","roomnums":"1","name":"\u6d4b\u8bd5","tel":"12345678912","order_time":"1466419340","startdate":"20160620","enddate":"20160621","paid":"0","status":"0","holdtime":"18:00","paytype":"daofu","isdel":"0","operate_reason":null,"remark":"","member_no":"11282295","handled":"0","hname":"-----","himg":null,"haddress":"\u6c5f\u82cf\u7701\u8fde\u4e91\u6e2f\u5e02\u65b0\u6d66\u533a\u6d77\u8fde\u4e1c\u8def18\u53f7","longitude":"","latitude":"","htel":"400-650-9878","order_datetime":"2016-06-20 18:42:20","order_details":[{"id":"642361","orderid":"36146641934039257","inter_id":"a465195239","room_id":"10892","iprice":"416.00","startdate":"20160620","enddate":"20160621","istatus":"0","allprice":"416.00","room_no":"","roomname":"\u8c6a\u534e\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"LO32","room_no_id":"0","price_code_name":"\u96c6\u56e2\u5b98\u7f51\u542b\u53cc\u65e9","handled":"0","webs_orderid":"","real_allprice":"416","sub_id":"642361"}],"first_detail":{"id":"642361","orderid":"36146641934039257","inter_id":"a465195239","room_id":"10892","iprice":"416.00","startdate":"20160620","enddate":"20160621","istatus":"0","allprice":"416.00","room_no":"","roomname":"\u8c6a\u534e\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"LO32","room_no_id":"0","price_code_name":"\u96c6\u56e2\u5b98\u7f51\u542b\u53cc\u65e9","handled":"0","webs_orderid":"","real_allprice":"416","sub_id":"642361"},"ori_price":"416.00"}';
		$order = json_decode($order_json, true);
		$this->load->model('hotel/pms/Yage_hotel_moel', 'pms');
		print_r($this->pms->order_to_web($this->inter_id, $order['orderid'], array(), $this->pms_set));
	}

	public function cancelbooking(){
		$order_json = '{"id":"355925","inter_id":"a465195239","orderid":"36146641934039257","coupon_favour":"0.00","complete_reward_given":"0","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"0","complete_point_info":"","web_orderid":"91102","room_codes":"{\"10892\":{\"code\":{\"price_type\":\"pms\",\"extra_info\":{\"type\":\"code\",\"pms_code\":\"LO32\"}},\"room\":{\"webser_id\":\"DKI\"}}}","web_paid":"0","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","hotel_id":"2790","openid":"oX3WojhfNUD4JzmlwTzuKba1My36","price":"416.00","roomnums":"1","name":"\u6d4b\u8bd5","tel":"12345678912","order_time":"1466419340","startdate":"20160620","enddate":"20160621","paid":"0","status":"0","holdtime":"18:00","paytype":"daofu","isdel":"0","operate_reason":null,"remark":"","member_no":"11282295","handled":"0","hname":"-----","himg":null,"haddress":"\u6c5f\u82cf\u7701\u8fde\u4e91\u6e2f\u5e02\u65b0\u6d66\u533a\u6d77\u8fde\u4e1c\u8def18\u53f7","longitude":"","latitude":"","htel":"400-650-9878","order_datetime":"2016-06-20 18:42:20","order_details":[{"id":"642361","orderid":"36146641934039257","inter_id":"a465195239","room_id":"10892","iprice":"416.00","startdate":"20160620","enddate":"20160621","istatus":"0","allprice":"416.00","room_no":"","roomname":"\u8c6a\u534e\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"LO32","room_no_id":"0","price_code_name":"\u96c6\u56e2\u5b98\u7f51\u542b\u53cc\u65e9","handled":"0","webs_orderid":"","real_allprice":"416","sub_id":"642361"}],"first_detail":{"id":"642361","orderid":"36146641934039257","inter_id":"a465195239","room_id":"10892","iprice":"416.00","startdate":"20160620","enddate":"20160621","istatus":"0","allprice":"416.00","room_no":"","roomname":"\u8c6a\u534e\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"LO32","room_no_id":"0","price_code_name":"\u96c6\u56e2\u5b98\u7f51\u542b\u53cc\u65e9","handled":"0","webs_orderid":"","real_allprice":"416","sub_id":"642361"},"ori_price":"416.00"}';
		$order = json_decode($order_json, true);
		$this->load->model('hotel/pms/Yage_hotel_moel', 'pms');
		print_r($this->pms->cancel_order_web($this->inter_id, $order, $this->pms_set));
	}

	public function priceset(){
		$price_list = array(
			array('price_code' => 1),
			array('price_code' => 2),
			array('price_code' => 3),
			array('price_code' => 4),
			array('price_code' => 5),
		);

		$this->load->model('hotel/pms/Yage_hotel_moel', 'pms');
		$db = $this->pms->_shard_db();
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/yage_rooms.json');
		$list = json_decode($json, true);
		$data = array();
		foreach($list as $v){
			foreach($price_list as $t){
				$row = $db->from('hotel_price_set_copy1')->where(array(
					                                                 'room_id'  => $v['room_id'],
					                                                 'hotel_id' => $v['hotel_id'],
					                                                 'inter_id' => $v['inter_id'],
				                                                 ))->get()->row_array();

				if(!$row){
					$data[] = array(
						'inter_id'   => $v['inter_id'],
						'hotel_id'   => $v['hotel_id'],
						'room_id'    => $v['room_id'],
						'price_code' => $t['price_code'],
						'edittime'   => time(),
						'status'     => 1,
					);
				} else{
					$fail[] = array(
						'inter_id'   => $v['inter_id'],
						'hotel_id'   => $v['hotel_id'],
						'room_id'    => $v['room_id'],
						'price_code' => $t['price_code'],
						'edittime'   => time(),
						'status'     => 1,
					);
				}
			}
		}
		if($data){
			$db->set_insert_batch($data)->insert_batch('hotel_price_set_copy');
			echo 'success';
		}
		print_r($fail);
	}

	public function level(){
		$this->load->model('api/Vmember_model', 'vmember');
		print_r($this->vmember->getLevelInfo($this->inter_id, 12));
		print_r($this->vmember->getLevelList($this->inter_id));
	}

	public function getr(){
		$this->ser_api->switchMode(1);
		$list = $this->ser_api->getHotelRoomType('GNCKM');
		print_r($list);
	}

	public function testroomchange(){
		$adata = array(
			'hotel_code' => 'GNCKM',
			'arrival'    => date('Y-m-d'),
			'departure'  => date('Y-m-d', time() + 86400),
		);

		$this->ser_api->switchMode(1);
		$res = $this->ser_api->getAvailability($adata);
		echo json_encode($res);

	}

	public function newPrice(){
		$room_list = array(
			13367,
			13368,
			13369
		);
		$hotel_id = 2746;
		$price_list = array(
			array('price_code' => 1),
			array('price_code' => 2),
			array('price_code' => 3),
			array('price_code' => 4),
			array('price_code' => 5),
		);
		$data = array();
		foreach($room_list as $v){
			foreach($price_list as $t){
				$data[] = array(
					'inter_id'   => $this->inter_id,
					'hotel_id'   => $hotel_id,
					'room_id'    => $v,
					'price_code' => $t['price_code'],
					'edittime'   => time(),
					'status'     => 1,
				);
			}
		}

		if($data){
			$this->db->insert_batch('hotel_price_set_copy', $data);
		}

	}

	public function getOrder(){
		$this->ser_api->switchMode(1);
		$res = $this->ser_api->getOrder($_GET['id']);
//		$res['Comments']=mb_convert_encoding($res['Comments'],'UTF-8','UCS-2LE');
		print_r($res);
	}

	public function testmodify(){
		$this->ser_api->switchMode(1);
		$this->load->model('hotel/pms/Yage_hotel_model', 'pms');
		$this->pms->add_web_bill($_GET['id'],array('inter_id'=>$this->inter_id,'orderid'=>11111,),$this->pms_set,time());
	}


}