<?php

class Shimao extends MY_Controller{
	private $url = 'http://115.159.222.122:8090/ipms/CRS';
	private $usr_url = 'http://115.159.222.122:8090/ipms/';

//	private $inter_id = 'a468224499';  //测试
	private $inter_id='a462961398';

	private $pms_auth = array(
		'salesChannel' => 'web',
		'hotelGroupId' => 1,
		'url'          => 'http://115.159.222.122:8090/ipms/CRS',
		'member_url'   => 'http://115.159.222.122:8090/ipms/',
		'src'          => 'WEBCN',
	);

	public function __construct(){
		parent::__construct();
	}



	public function updateauth(){
		$this->db->update('hotel_additions',array('pms_auth'=>json_encode($this->pms_auth)),array('inter_id'=>$this->inter_id,'pms_type'=>'lvyun'));
	}

	public function get_hotels(){
		if(true||!file_exists(FD_PUBLIC . '/shimao_hotels.json')){
			$hotel_info = array(
				1 => '松江睿选酒店',
				2 => '大连睿选酒店',
				3 => '上海虹桥世茂睿选尚品酒店',
				4 => '泰州世茂茂御酒店',
			);
			$url = $this->url . '/queryHotelList';
			$data = array(
				'date'         => date('Y-m-d'),
				'dayCount'     => 2,
				'cityCode'     => '',
				'brandCode'    => '',
				'order'        => '1',
				//			'firstResult' => 0,
				'pageSize'     => 10,
				//			'rateCodes' => '',
				'salesChannel' => 'web',
				'hotelIds'     => '1,2,3,4',
				/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
				'hotelGroupId' => 1
			);

			$this->load->helper('common');
			$json = doCurlGetRequest($url, $data);
			exit($json);
			$list = json_decode($json, true);
			$hotels = array();
			foreach($list['hrList'] as $v){
				$v['name'] = $hotel_info[$v['hotelId']];
				$hotels[] = $v;
			}

			file_put_contents(FD_PUBLIC . '/shimao_hotels.json', json_encode($hotels));
			exit(json_encode($hotels));
		} else{
			$json = file_get_contents(FD_PUBLIC . '/shimao_hotels.json');
			$hotels = json_decode($json, true);
		}
		return $hotels;
	}

	public function insert2DB(){
		$hotels = $this->get_hotels();
		$additions = array();
		$rooms = array();
		$lowest = array();
		foreach($hotels as $v){
			$data = array(
				'name'     => $v['name'],
				'inter_id' => $this->inter_id,
			);
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			$additions[] = array(
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['hotelId'],
				'pms_room_state_way' => 1,
				'pms_member_way'     => 1,
				'pms_type'           => 'lvyun',
			);
			if(!empty($v['rmtypes'])){
				foreach($v['rmtypes'] as $t){
					$rooms[] = array(
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['descript'],
						'description' => '',
						'sub_des'     => '',
						'nums'        => 0,
						'bed_num'     => 0,
						//						'sort'        => $t['Sort'],
						'webser_id'   => $t['code'],
					);
				}
			}
			$min_price = 0;
			if(!empty($v['roomList'])){
				foreach($v['roomList'] as $t){
					if($t['ratecode'] == 'BEN0-0B-N'){
						if($min_price > 0){
							$min_price = min($min_price, $t['rate1']);
						} else{
							$min_price = $t['rate1'];
						}
					}

				}
			}

			if($min_price > 0){
				$lowest[] = array(
					'hotel_id'     => $hotel_id,
					'inter_id'     => $this->inter_id,
					'lowest_price' => $min_price,
					'update_time'  => date('Y-m-d H:i:s'),
				);
			}

		}
		if($additions){
			$this->db->insert_batch('hotel_additions', $additions);
		}
		if($rooms){
			$this->db->insert_batch('hotel_rooms', $rooms);
		}
		if($lowest){
			$this->db->insert_batch('hotel_lowest_price', $lowest);
		}
		echo 'success';
	}

	public function updadditions(){
		$this->db->update('hotel_additions', array('pms_auth' => json_encode($this->pms_auth)), array('inter_id' => $this->inter_id));
		echo 'success';
	}

	public function insert_main(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/shimao_hotels.json');
		$hotel_list = json_decode($json, true);
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/shimao_rooms.json');
		$rooms = json_decode($json, true);
		$room_list = array();
		foreach($rooms as $v){
			$room_list[$v['hotel_id']][] = $v;
		}

		$json = file_get_contents(FD_PUBLIC . '/tmp_data/shimao_lowest.json');
		$lowest = json_decode($json, true);
		$lowest_list = array();
		foreach($lowest as $v){
			$lowest_list[$v['hotel_id']] = $v;
		}

		$params = array();
		$room_params = array();
		$lowest_params = array();
		foreach($hotel_list as $v){
			$data = array(
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
			);
			$this->db->insert('hotels_copy', $data);
			$hotel_id = $this->db->insert_id();
			if(!$params){
				$params[] = array(
					'inter_id'           => $this->inter_id,
					'hotel_id'           => 0,
					'pms_type'           => $v['pms_type'],
					'pms_auth'           => $v['pms_auth'],
					'hotel_web_id'       => '',
					'pms_room_state_way' => $v['pms_room_state_way'],
					'pms_member_way'     => $v['pms_member_way'],
				);
			}
			$params[] = array(
				'inter_id'           => $this->inter_id,
				'hotel_id'           => $hotel_id,
				'pms_type'           => $v['pms_type'],
				'pms_auth'           => $v['pms_auth'],
				'hotel_web_id'       => $v['hotel_web_id'],
				'pms_room_state_way' => $v['pms_room_state_way'],
				'pms_member_way'     => $v['pms_member_way'],
			);

			if(!empty($room_list[$v['hotel_id']])){
				foreach($room_list[$v['hotel_id']] as $t){
					$room_params[] = array(
						'inter_id'    => $this->inter_id,
						'hotel_id'    => $hotel_id,
						'name'        => $t['name'],
						'price'       => $t['price'],
						'oprice'      => $t['oprice'],
						'description' => $t['description'],
						'nums'        => $t['nums'],
						'bed_num'     => $t['bed_num'],
						'area'        => $t['area'],
						'status'      => $t['status'],
						'sort'        => $t['sort'],
						'room_img'    => $t['room_img'],
						'book_policy' => $t['book_policy'],
						'sub_des'     => $t['sub_des'],
						'webser_id'   => $t['webser_id'],
					);
				}
			}

			if(!empty($lowest_list[$v['hotel_id']])){
				$t = $lowest_list[$v['hotel_id']];
				$t['hotel_id'] = $hotel_id;
				$t['inter_id'] = $this->inter_id;
				$lowest_params[] = $t;
			}
		}


		if($params){
			$this->db->insert_batch('hotel_additions_copy', $params);
		}

		if($room_params){
			$this->db->insert_batch('hotel_rooms_copy', $room_params);
		}
		if($lowest_params){
			$this->db->insert_batch('hotel_lowest_price_copy', $lowest_params);
		}

		echo 'success';
	}

}