<?php

/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2017/2/16
 * Time: 12:08
 */
class Longstay extends MY_Controller{
	private $url = 'http://182.254.244.164:8091/ipmsgroup/CRS';
	private $usr_url = 'http://182.254.244.164:8101/ipmsmember/membercard/';
	private $sales_channel = 'JFK';
	private $hotel_group_id = 28;
	private $src = 'JFK';
	private $pms_auth;
	private $hotel_group_code = 'JQLSJPKZG';

//	private $inter_id='a489545360'; //测试
	private $inter_id = 'a490610684';//生产
	
	public function __construct(){
		parent::__construct();
		$this->pms_auth = array(
			'salesChannel' => $this->sales_channel,
			'hotelGroupId' => $this->hotel_group_id,
			'url'          => $this->url,
			'member_url'   => $this->usr_url,
			'src'          => $this->src,
		);
		$this->load->helper('common');
	}
	
	public function get_hotels(){
		set_time_limit(600);
		$url = $this->url . '/hotels';
		$prm = ['hotelGroupCode' => $this->hotel_group_code];
		$json = doCurlGetRequest($url, $prm);
		$res = json_decode($json, true);
		if(!empty($res['result'])){
			$hotels = [];
			$url = $this->url . '/roomList';
			foreach($res['result'] as $v){
				$hotels[$v['id']] = [
					'name'    => $v['descript'],
					'address' => $v['address1'],
					'id'      => $v['id'],
					'sta'     => $v['sta'],
					'tel'     => $v['phone'],
					'fax'     => $v['fax'],
					'city'    => $v['city'],
					'email'   => $v['email'],
				];
				$data = [
					'hotelGroupId' => $this->hotel_group_id,
					'hotelId'      => $v['id'],
				];
				$json = doCurlGetRequest($url, $data);
				$rooms = json_decode($json, true);
				if(!empty($rooms['result'])){
					$hotels[$v['id']]['room_list'] = $rooms['result'];
				}
			}
			
			if($hotels){
				ksort($hotels);
				file_put_contents(FD_PUBLIC . '/tmp_data/longstay_hotels_pms.json', json_encode($hotels));
			}
			exit(json_encode($hotels));
		}
	}
	
	public function test_price(){
		$url = $this->url . '/queryHotelList';
		$data = array(
			'date'         => date('Y-m-d'),
			'dayCount'     => 1,
			'cityCode'     => '',
			'brandCode'    => '',
			'order'        => '1',
			//			'firstResult' => 0,
			'pageSize'     => 10,
			//			'rateCodes' => '',
			'salesChannel' => $this->sales_channel,
			'hotelGroupId' => $this->hotel_group_id,
			'hotelIds'     => '41,50,51,52,53',
			/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
		);
		$json = doCurlGetRequest($url, $data);
		exit($json);
	}
	
	public function catches(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/longstay_hotels_pms.json');
		$hotels = json_decode($json, true);
		$additions = [];
		$rooms = [];
		
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['name'],
				'address'     => $v['address'],
				'tel'         => $v['tel'],
				'intro'       => $v['name'],
				'fax'         => $v['fax'],
				'email'       => $v['email'],
				'short_intro' => '',
				'city'        => '',
				'province'    => '',
				'star'        => 0,
				'status'      => $v['sta'] == 'I' ? 1 : 2,
				//				'latitude'    => $v['latitude'],
				//				'longitude'   => $v['longitute'],
			];
			
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'lvyun',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'lvyun',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['id'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			
			if(!empty($v['room_list'])){
				foreach($v['room_list'] as $t){
					$rooms[] = array(
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['roomDescript'],
						'description' => '',
						'sub_des'     => '',
						'nums'        => 0,
						'bed_num'     => 0,
						//						'sort'        => $t['Sort'],
						'webser_id'   => $t['roomType'],
					);
				}
			}
		}
		if($additions){
			$this->db->insert_batch('hotel_additions', $additions);
		}
		if($rooms){
			$this->db->insert_batch('hotel_rooms', $rooms);
		}
		echo 'success';
	}
	
	public function prod_catches(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/longstay_hotels_prod.json');
		$db = $this->load->database('default', true);
		$res = json_decode($json, true);
		foreach($res as $v){
			$v['inter_id'] = $this->inter_id;
			$hotel_id = $v['hotel_id'];
			unset($v['hotel_id']);
			$v['room_list']=[];
			$hotels[$hotel_id] = $v;
		}
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/longstay_rooms_prod.json');
		$rooms = json_decode($json, true);
		foreach($rooms as $v){
			$v['inter_id'] = $this->inter_id;
			$hotel_id = $v['hotel_id'];
			unset($v['hotel_id'], $v['room_id']);
			$hotels[$hotel_id]['room_list'][] = $v;
		}
		$additions = [];
		$rooms = [];
//		print_r($hotels);exit;
		
		foreach($hotels as $k => $v){
			$room_list = $v['room_list'];
			$data = [
				'inter_id'    => $v['inter_id'],
				'name'        => $v['name'],
				'address'     => $v['address'],
				'tel'         => $v['tel'],
				'intro'       => $v['intro'],
				'fax'         => $v['fax'],
				'email'       => $v['email'],
				'short_intro' => $v['short_intro'],
				'city'        => $v['city'],
				'province'    => $v['province'],
				'star'        => $v['star'],
				'status'      => $v['status'],
				'latitude'    => $v['latitude'],
				'longitude'   => $v['longitude'],
			];
			
			
			$db->insert('hotels_copy', $data);
			$hotel_id = $db->insert_id();
			/*if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'lvyun',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 3,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'lvyun',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['id'],
				'pms_room_state_way' => 3,
				'pms_member_way'     => 1,
			];*/
			
			/*if(!empty($v['room_list'])){
				foreach($v['room_list'] as $t){
					$rooms[] = array(
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['roomDescript'],
						'description' => '',
						'sub_des'     => '',
						'nums'        => 0,
						'bed_num'     => 0,
						//						'sort'        => $t['Sort'],
						'webser_id'   => $t['roomType'],
					);
				}
			}*/
			foreach($room_list as $t){
				$t['hotel_id'] = $hotel_id;
				unset($t['type']);
				$rooms[] = $t;
			}
		}
		if($additions){
			$db->insert_batch('hotel_additions_copy', $additions);
		}
		if($rooms){
			$db->insert_batch('hotel_rooms_copy', $rooms);
		}
		echo 'success';
	}
	
	public function priceset(){
		$room_list = $this->db->from('hotel_rooms')->where(['inter_id' => $this->inter_id])->get()->result_array();
		$params = [];
		foreach($room_list as $v){
			for($i = 1; $i <= 3; $i++){
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
	
	public function lowest(){
		$db = $this->load->database('default', true);
//		$hotels=$db->where(['inter_id'=>$this->inter_id,'hotel_id>'=>0])->from('hotel_additions_copy')->get()->result_array();\
		$json = '[{"inter_id":"a487576098","hotel_id":"5148","hotel_web_id":"12"}, {"inter_id":"a487576098","hotel_id":"5149","hotel_web_id":"13"}, {"inter_id":"a487576098","hotel_id":"5150","hotel_web_id":"14"}, {"inter_id":"a487576098","hotel_id":"5151","hotel_web_id":"15"}, {"inter_id":"a487576098","hotel_id":"5152","hotel_web_id":"16"}, {"inter_id":"a487576098","hotel_id":"5153","hotel_web_id":"17"}, {"inter_id":"a487576098","hotel_id":"5154","hotel_web_id":"18"}, {"inter_id":"a487576098","hotel_id":"5155","hotel_web_id":"19"}, {"inter_id":"a487576098","hotel_id":"5156","hotel_web_id":"20"}, {"inter_id":"a487576098","hotel_id":"5157","hotel_web_id":"21"}, {"inter_id":"a487576098","hotel_id":"5158","hotel_web_id":"22"}, {"inter_id":"a487576098","hotel_id":"5159","hotel_web_id":"23"}, {"inter_id":"a487576098","hotel_id":"5160","hotel_web_id":"24"}, {"inter_id":"a487576098","hotel_id":"5161","hotel_web_id":"26"}, {"inter_id":"a487576098","hotel_id":"5162","hotel_web_id":"27"}, {"inter_id":"a487576098","hotel_id":"5163","hotel_web_id":"28"}, {"inter_id":"a487576098","hotel_id":"5164","hotel_web_id":"29"}, {"inter_id":"a487576098","hotel_id":"5165","hotel_web_id":"30"}, {"inter_id":"a487576098","hotel_id":"5166","hotel_web_id":"31"}, {"inter_id":"a487576098","hotel_id":"5167","hotel_web_id":"33"}, {"inter_id":"a487576098","hotel_id":"5168","hotel_web_id":"34"}, {"inter_id":"a487576098","hotel_id":"5169","hotel_web_id":"35"}, {"inter_id":"a487576098","hotel_id":"5170","hotel_web_id":"36"}, {"inter_id":"a487576098","hotel_id":"5171","hotel_web_id":"37"}, {"inter_id":"a487576098","hotel_id":"5172","hotel_web_id":"9"}]';
		$hotels = json_decode($json, true);
		$ids = [];
		foreach($hotels as $v){
			$ids[$v['hotel_web_id']] = [
				'inter_id' => $v['inter_id'],
				'hotel_id' => $v['hotel_id']
			];
		}
		$url = $this->url . '/queryHotelList';
		$data = array(
			'date'         => date('Y-m-d'),
			'dayCount'     => 1,
			'cityCode'     => '',
			'brandCode'    => '',
			'order'        => '1',
			//			'firstResult' => 0,
			'pageSize'     => 10,
			'rateCodes'    => 'RAC',
			'salesChannel' => $this->price_sales_channel,
			'hotelGroupId' => $this->hotel_group_id,
			'hotelIds'     => implode(',', array_keys($ids)),
			/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
		);
		$json = doCurlGetRequest($url, $data);
		$result = json_decode($json, true);
		$lowest = [];
		foreach($result['hrList'] as $v){
			if(!empty($v['minRate'])){
				$w = $ids[$v['hotelId']];
				$lowest[] = [
//					'hotel_web_id'=>$v['hotelId'],
'hotel_id'     => $w['hotel_id'],
'inter_id'     => $w['inter_id'],
'lowest_price' => $v['minRate'],
'update_time'  => date('Y-m-d H:i:s'),
				];
			}
		}
		$db->insert_batch('hotel_lowest_price_copy', $lowest);
		echo 'success';
	}
	
	public function pricesetprod(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/wanxin_rooms_prod.json');
		$rooms = json_decode($json, true);
		$params = [];
		foreach($rooms as $v){
			for($i = 1; $i <= 8; $i++){
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
	
}