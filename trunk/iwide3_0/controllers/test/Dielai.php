<?php

/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2017/2/16
 * Time: 12:08
 */
class Dielai extends MY_Controller{
	private $url = 'http://115.159.203.249:8092/ipmsgroup/CRS';
	private $usr_url = 'http://115.159.203.249:8092/ipmsmember/membercard/';
//	private $url='http://106.75.10.41:8100/ipmsgroup/CRS';
//	private $usr_url = 'http://106.75.10.41:8100/ipmsmember/membercard/';
	private $sales_channel = 'CRS';
	private $hotel_groupid = 2;
	private $src = 'WECHAT';
	private $pms_auth;

//	private $inter_id = 'a499938809';//测试
	private $inter_id='a498464307';//生产
	
	public function __construct(){
		parent::__construct();
		$this->pms_auth = array(
			'salesChannel' => $this->sales_channel,
			'hotelGroupId' => $this->hotel_groupid,
			'url'          => $this->url,
			'member_url'   => $this->usr_url,
			'src'          => $this->src,
			'taCode'=> '9020',
			'point_taCode'=>'9620',
			
			'fang_fee'    => ['1000','1001','1002','1003','1004','1005','1006','1007','1008','1010','1020','1021','1022','1023','1024','1025','1026','1999'],
			'new_upd'     => 1,
			'multi_rooms' => 1,
		    'bill_ta'=>1,
		    'new_level'=>1,
		);
		
		$this->load->helper('common');
	}
	
	public function fixpms(){
		$this->db->where(['inter_id' => $this->inter_id])->update('hotel_additions', ['pms_auth' => json_encode($this->pms_auth)]);
		echo 'success';
	}
	
	public function get_hotels(){
		set_time_limit(600);
//		$url='http://106.75.7.248:8090/ipmsgroup/CRS/hotels?hotelGroupCode=LILIAN';
		$url = $this->url . '/hotels';
		$prm = ['hotelGroupCode' => 'ZTGHOTELS'];
		$json = doCurlGetRequest($url, $prm);
		$res = json_decode($json, true);
		
		$valid_arr = [9, 13, 14, 15, 17, 18];
		
		if(!empty($res['result'])){
			$hotels = [];
			$url = $this->url . '/roomList';
			foreach($res['result'] as $v){
				if(in_array($v['id'], $valid_arr)){
					$hotels[$v['id']] = [
						'name'    => $v['descript'],
						'address' => $v['address1'],
						'id'      => $v['id'],
						'sta'     => $v['sta'],
						'tel'     => $v['phoneRsv'],
						'fax'     => $v['fax'],
						'city'    => $v['city'],
						'email'   => $v['email'],
					];
					$data = [
						'hotelGroupId' => $this->hotel_groupid,
						'hotelId'      => $v['id'],
					];
					$json = doCurlGetRequest($url, $data);
					$rooms = json_decode($json, true);
					if(!empty($rooms['result'])){
						$hotels[$v['id']]['room_list'] = $rooms['result'];
					}
				}
			}
			if($hotels){
				ksort($hotels);
				file_put_contents(FD_PUBLIC . '/dielai/hotels_prod.json', json_encode($hotels));
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
			'hotelGroupId' => $this->hotel_groupid,
			'hotelIds'     => '9,13,14,15,17,18',
			/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
		);
		$json = doCurlGetRequest($url, $data);
		echo json_encode([
			'url'=>$url,
			'request'=>$data,
		    'response'=>json_decode($json,true)
		]);
	}
	
	public function catches(){
		$json = file_get_contents(FD_PUBLIC . '/dielai/hotels_test.json');
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
	
	public function prod_additions(){
		$hotels=[
			5922=>'13',
			5921=>'9',
			5920=>'14',
			5919=>'15',
			5917=>'18',
			5916=>'17',
		];
		$additions=[];
		foreach($hotels as $k=>$v){
			if(!$additions){
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
				'hotel_id'           => $k,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'lvyun',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v,
				'pms_room_state_way' => 3,
				'pms_member_way'     => 1,
			];
		}
		
		$db = $this->load->database('default', true);
		$db->insert_batch('hotel_additions_copy',$additions);
		echo 'success';
	}
	
	public function prod_catches(){
		$json = file_get_contents(FD_PUBLIC . '/dielai/hotel_prod.json');
		$db = $this->load->database('default', true);
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
			
			$db->insert('hotels_copy', $data);
			$hotel_id = $db->insert_id();
			if(!$additions){
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
			for($i = 1; $i <= 1; $i++){
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
			'hotelGroupId' => $this->hotel_groupid,
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
		$json = file_get_contents(FD_PUBLIC . '/dielai/prod_rooms.json');
		$rooms = json_decode($json, true);
		$params = [];
		foreach($rooms as $v){
			for($i = 1; $i <= 4; $i++){
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
	
	public function room_test(){
		$json=file_get_contents(FD_PUBLIC.'/dielai/hotels_prod.json');
		$hotels=json_decode($json,true);
		$rooms=[];
		foreach($hotels as $v){
			if(!empty($v['room_list'])){
				foreach($v['room_list'] as $t){
					$rooms[] = array(
						'hotel_id'    => $v['id'],
						'inter_id'    => $this->inter_id,
						'name'        => $t['roomDescript'],
						'description' => $v['name'],
						'sub_des'     => '',
						'nums'        => 0,
						'bed_num'     => 0,
						//						'sort'        => $t['Sort'],
						'webser_id'   => $t['roomType'],
					);
				}
			}
		}
		$db=$this->load->database('default',true);
		$db->insert_batch('hotel_rooms_copy2',$rooms);
		echo 'success';
	}
	
}