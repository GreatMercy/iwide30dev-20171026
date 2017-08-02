<?php

//{"usercd":"crs1","password":"crs1","channel_cd":"JFK01","url":"http:\/\/139.129.44.225\/W_webserviceSaas\/JsonPattern\/","lang":"cn","grpcd":"BD","acct_typ":"27","resv_typ":"09","rmtax_cd":"01","crdt_cd":"00","org_cd":"56","market_cd":"09"}

//{"usercd":"crs1","password":"crs1","channel_cd":"JFK01","url":"http:\/\/139.129.44.225\/W_webserviceSaas\/JsonPattern\/","lang":"cn","grpcd":"BD","acct_typ":"27","resv_typ":"09","crdt_cd":"00","org_cd":"56","market_cd":"09"}

//{"usercd":"crs1","password":"crs1","channel_cd":"JFK01","url":"http:\/\/139.129.44.225\/W_webserviceSaas\/JsonPattern\/","lang":"cn","grpcd":"BD","acct_typ":"27","resv_typ":"09","rmtax_cd":"01","crdt_cd":"00","org_cd":"56","market_cd":"09"}
class Baideng extends MY_Controller{
//	private $url = 'http://139.129.44.225/W_webserviceSaas/JsonPattern/';
private $url='http://118.190.73.238/W_webserviceSaas/JsonPattern/';
	private $usr = 'crs1';
	private $pwd = 'crs1';
	private $channel = 'JFK01';
	private $grpcd = 'BD';
	private $serv_api;
	private $inter_id = 'a483583294';  //开发
//	private $inter_id = 'a483410662';//测试
//	private $inter_id = 'a484191907'; //生产
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('common');
		$this->pms_auth = array(
			'usercd'     => $this->usr,
			'password'   => $this->pwd,
			'channel_cd' => $this->channel,
			'url'        => $this->url,
			'lang'       => 'cn',
			'grpcd'      => $this->grpcd,
			'acct_typ'   => '27',
			'resv_typ'   => '09',
			'rmtax_cd'   => '01',
			'crdt_cd'    => '00',
			'org_cd'     => '56',
			'market_cd'  => '09'
		);
		$conf = $this->pms_auth;
		$conf['inter_id'] = $this->inter_id;
		$this->load->model('hotel/pms/Zhongruaniw_hotel_model');
		$this->serv_api = new ZhongruanApi();
		$this->serv_api->setPMSAuth($conf);
	}
	
	public function new_ratequery(){
		$hotel_web_id='BD021';
		$sdate=date('Y-m-d',time()+86400*4);
		$edate=date('Y-m-d',time()+86400*5);
		$res=$this->serv_api->getHotelPrice($hotel_web_id, $sdate, $edate);
		
		echo json_encode([
			'request'=>[
				'url'=>$this->url,
			    'hotelId'=>$hotel_web_id,
			    'start'=>$sdate,
			    'end'=>$edate,
			],
		    'response'=>$res,
		]);
	}
	
	public function ratequery(){
		$hotel_web_id='BD028';
		$res=$this->serv_api->GetHotel($hotel_web_id, date('Y-m-d'), date('Y-m-d',time()+86400*3),['BZJ']);
		
		echo json_encode([
			'request'=>[
				'url'=>$this->url,
				'hotelId'=>$hotel_web_id,
				'start'=>date('Y-m-d'),
				'end'=>date('Y-m-d',time()+86400*3),
			],
			'response'=>$res,
		]);
	}
	
	public function fixpms(){
		$this->db->where(['inter_id' => $this->inter_id])->update('hotel_additions', ['pms_auth' => json_encode($this->pms_auth)]);
		echo 'success';
	}
	
	public function dev_pms(){
		$additions_param[] = [
			'hotel_id'           => 0,
			'inter_id'           => $this->inter_id,
			'hotel_web_id'       => '',
			'pms_type'           => 'zhongruaniw',
			'pms_room_state_way' => 4,
			'pms_member_way'     => 1,
			'pms_auth'           => json_encode($this->pms_auth)
		];
		$additions_param[] = [
			'hotel_id'           => 4706,
			'inter_id'           => $this->inter_id,
			'hotel_web_id'       => 'BD028',
			'pms_type'           => 'zhongruaniw',
			'pms_room_state_way' => 4,
			'pms_member_way'     => 1,
			'pms_auth'           => json_encode($this->pms_auth)
		];
		
		$this->db->insert_batch('hotel_additions', $additions_param);
		
	}
	
	public function get_hotels(){
		
		$pms_auth = $this->pms_auth;
		$pms_auth['apocalypse'] = true;
		unset($pms_auth['url']);
		
		$data = http_build_query($pms_auth);
//		print_r($this->pms_auth);exit;
		$res = doCurlPostRequest($this->url . 'GetHtlList.aspx', $data);
		$list = array();
		$results = json_decode($res, true);
		
		$room_params = $pms_auth;
		foreach($results['data'] as $v){
			$room_params['htl_cd'] = $v['htlcd'];
			$query_str = http_build_query($room_params);
			$res = doCurlPostRequest($this->url . 'GetRoomList.aspx', $query_str);
			$res = json_decode($res, true);
			$v['rooms_list'] = $res['data'];
			$list[] = $v;
		}
		file_put_contents(FD_PUBLIC . '/baideng_hotels_pms.json', json_encode($list));
		echo json_encode($list);
		exit;
	}
	
	public function catches(){
		$json = file_get_contents(FD_PUBLIC . '/baideng_hotels_pms.json');
		$hotels = json_decode($json, true);
		$rooms = [];
		$icons = [];
		$additions = [];
		$tel = '400 853 2333';
		$icon_arr = [
			[
				'code' => '&#xe8;',
				'name' => 'WIFI',
			],
			[
				'code' => '&#xeb;',
				'name' => '热水',
			],
			[
				'code' => '&#xe3;',
				'name' => '免费上网',
			],
		];
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['htlnm'] ? $v['htlnm'] : $v['htlcd'],
				'address'     => $v['htladdr'],
				'tel'         => $tel,
				'intro'       => $v['htl_intro'],
				'short_intro' => '',
				'city'        => '',
				'province'    => '',
				'star'        => $v['htlcls'] > 9 ? 0 : $v['htlcls'],
				//				'latitude'    => $v['latitude'],
				//				'longitude'   => $v['longitute'],
			];
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'zhongruaniw',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'zhongruaniw',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['htlcd'],
				'pms_room_state_way' => 4,
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
			if(!empty($v['rooms_list'])){
				foreach($v['rooms_list'] as $t){
					$rooms[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['rm_nm'],
						'description' => $t['rm_nm'],
						//						'sub_des'     => '',
						//						'nums'        => 0,
						//						'bed_num'     => $t['BedCount'],
						//						'sort'        => $t['Sort'],
						'webser_id'   => $t['rm_cd'],
					];
				}
			}
		}
		
		if($additions){
			$this->db->insert_batch('hotel_additions', $additions);
		}
		if($icons){
			$this->db->insert_batch('hotel_images', $icons);
		}
		if($rooms){
			$this->db->insert_batch('hotel_rooms', $rooms);
		}
		echo 'success';
	}
	
	public function catches_prod(){
		$json = file_get_contents(FD_PUBLIC . '/baideng_hotels_pms.json');
		$db = $this->load->database('default', true);
		$hotels = json_decode($json, true);
		$rooms = [];
		$icons = [];
		$additions = [];
		$tel = '400 853 2333';
		$icon_arr = [
			[
				'code' => '&#xe8;',
				'name' => 'WIFI',
			],
			[
				'code' => '&#xeb;',
				'name' => '热水',
			],
			[
				'code' => '&#xe3;',
				'name' => '免费上网',
			],
		];
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['htlnm'] ? $v['htlnm'] : $v['htlcd'],
				'address'     => $v['htladdr'],
				'tel'         => $tel,
				'intro'       => $v['htl_intro'],
				'short_intro' => '',
				'city'        => '',
				'province'    => '',
				'star'        => $v['htlcls'] > 9 ? 0 : $v['htlcls'],
				//				'latitude'    => $v['latitude'],
				//				'longitude'   => $v['longitute'],
			];
			$db->insert('hotels_copy', $data);
			$hotel_id = $db->insert_id();
			
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'zhongruaniw',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'zhongruaniw',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['htlcd'],
				'pms_room_state_way' => 4,
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
			if(!empty($v['rooms_list'])){
				foreach($v['rooms_list'] as $t){
					$rooms[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['rm_nm'],
						'description' => $t['rm_nm'],
						//						'sub_des'     => '',
						//						'nums'        => 0,
						//						'bed_num'     => $t['BedCount'],
						//						'sort'        => $t['Sort'],
						'webser_id'   => $t['rm_cd'],
					];
				}
			}
		}
		
		if($additions){
			$db->insert_batch('hotel_additions_copy', $additions);
		}
		if($icons){
			$db->insert_batch('hotel_images_copy', $icons);
		}
		if($rooms){
			$db->insert_batch('hotel_rooms_copy', $rooms);
		}
		echo 'success';
	}
	
	
	public function test(){
		$hotels = $this->serv_api->getHotetList();
		$list = array();
		foreach($hotels as $v){
			$v['room_list'] = $this->serv_api->getRooms($v['htlcd']);
			$list[] = $v;
		}
		echo json_encode($list);
	}
	
	public function test_room(){
		$rm_list = ['1RSHS', 'SHK'];
		print_r($this->serv_api->getRoomAvl('BD028', date('Y-m-d'), date('Y-m-d', time() + 86400 * 5)));
	}
	
	public function test_price(){
		$rate_list = [
			'XCBAR',
			/*'XCBAR2',
			'XCLTP',
			'XCSO',
			'XCTJQ',
			'XCTJQ2',
			'XCAB',
			'XCLS',
			'XCT',
			'P_XCB',
			'P_XCL',
			'P_XCO'*/
		];
		print_r($this->serv_api->getPriceLite('BD030', date('Y-m-d'), date('Y-m-d', time() + 86400), $rate_list));
	}
	
	public function get_hotel(){
		$rate_list = [
			'XCBAR',
			'XCBAR2',
			'XCLTP',
			'XCSO',
			'XCTJQ',
			'XCTJQ2',
			'XCAB',
			'XCLS',
			'XCT',
			'P_XCB',
			'P_XCL',
			'P_XCO'
		];
		print_r($this->serv_api->getHotel('BD028', date('Y-m-d'), date('Y-m-d', time() + 86400 * 2), $rate_list));
	}
	
	public function test_status(){
		print_r($this->serv_api->getRoomStatus('BD028', date('Y-m-d'), date('Y-m-d', time() + 86400)));
	}
	
	public function test_payment(){
		$web_orderid = '112578';
		$tel = '18888888888';
		print_r($this->serv_api->modifyOrder($web_orderid, $tel, 576, '测试支付入账'));
	}
	
	/*public function test_price(){
		$this->serv_api = new ZhongruaniwApi();
		$params = array(
			'arr_dt'     => date('Y-m-d'),
			'dpt_dt'     => date('Y-m-d', time() + 86400),
			'channel_cd' => 'WX',
			'rp_cd'      => '01',
			'htl_cd'     => '006',
		);
		print_r($this->serv_api->getPriceLite($params));
	}*/
	
	public function priceset(){
//		$rooms = $this->db->from('hotel_rooms')->where(['inter_id' => $this->inter_id])->get()->result_array();
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/baideng_rooms.json');
		$rooms = json_decode($json, true);
		$params = [];
		foreach($rooms as $v){
			for($i = 52; $i <= 52; $i++){
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
	
	public function lowest(){
		$rate_list = ['XCBAR','XCT','P_XCB','XCSO'];
		set_time_limit(900);
//		$hotels=$this->from('hotel_additions')->where(['inter_id'=>$this->inter_id,'hotel_id>'=>0])->get()->result_array();
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/baideng_addition_prod.json');
		$hotels = json_decode($json, true);
		$lowest = [];
		foreach($hotels as $v){
			$res = $this->serv_api->getPriceLite($v['hotel_web_id'], date('Y-m-d'), date('Y-m-d', time() + 86400), $rate_list);
			$min = [];
			foreach($res as $t){
				foreach($t as $w){
					$min[] = $w;
				}
			}
			if($min){
				$lowest[] = [
					'hotel_id'     => $v['hotel_id'],
					'inter_id'     => $v['inter_id'],
					'lowest_price' => min($min),
					'update_time'  => date('Y-m-d H:i:s'),
				];
			}
		}
		if($lowest){
			$db = $this->load->database('default', true);
			$db->insert_batch('hotel_lowest_price_copy', $lowest);
		}
		echo 'success';
	}
	
	public function roomavl(){
		$res=$this->serv_api->getRoomAvl('BD025', '2017-04-14', '2017-04-20',['SHJT','SHK']);
		print_r($res);
	}

	
}