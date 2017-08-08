<?php

class Junting extends MY_Controller{
	/*测试地址：http://120.55.89.210:8011/OtaDataEngine.asmx
	渠道用户名：iwide
	渠道密码：iwide
	*/
	private $soap;
	private $pms_auth;
//	private $inter_id = 'a479194687';//开发
//	private $inter_id='a480930558';//测试
	private $inter_id = 'a483407432';//正式
	
	public function __construct(){
		parent::__construct();
		$soap_opt = [
			'soap_version' => SOAP_1_1,
			'encoding'     => 'UTF-8',
			'trace'        => true,
			'cache_wsdl'   => WSDL_CACHE_NONE,
		];
		$this->load->helper('common');
		
		$this->pms_auth = [
//			'url'  => 'http://61.234.191.53:8070/OtaDataEngine.asmx?wsdl',
'user'     => 'iwide',
'url'      => 'http://60.191.125.141:8070/OtaDataEngine.asmx?wsdl',
'pwd'      => 'iwide',
'pay_type' => [
	'daofu_'        => 99,
	'daofu_coupon'  => 3,
	'weixin_'       => 5,
	'weixin_coupon' => 6,
],
		];
		
		
		$conf = $this->pms_auth;
		$conf['inter_id'] = $this->inter_id;
		
		$this->soap = new SoapClient($this->pms_auth['url'], $soap_opt);
		$this->load->model('hotel/pms/Yuheng_hotel_model', 'pms');
		$this->serv_api = new Yuhengapi();
		$this->serv_api->setPMSAuth($conf);
		
	}
	
	public function show(){
		print_r([$this->soap->__getFunctions(), $this->soap->__getTypes()]);
	}
	
	public function hotels(){
		set_time_limit(900);
		$parameters = [
			'paramters' => [
				'strCannelId'       => $this->pms_auth['user'],
				'strCannelPassWord' => $this->pms_auth['pwd'],
			],
		];
		$res = $this->soap->__soapCall('HotelInfomation', $parameters);
		if(!empty($res->HotelInfomationResult->any)){
			$res = xml2array($res->HotelInfomationResult->any);
			if(!empty($res['NewDataSet']['HotelInformation'])){
				$res = $res['NewDataSet']['HotelInformation'];
			}
		}
		
		if(is_array($res)){
			$pa = [
				'strCannelId'       => $this->pms_auth['user'],
				'strCannelPassWord' => $this->pms_auth['pwd'],
				'dtArrival'         => date('Y-m-d'),
				'dtDeparutre'       => date('Y-m-d', time() + 86400),
			];
			foreach($res as &$v){
				$pa['strHotelId'] = $v['hotelid'];
				$rs = $this->soap->__soapCall('GetRateDetail', ['parameters' => $pa]);
				if(!empty($rs->GetRateDetailResult->any)){
					$rs = xml2array($rs->GetRateDetailResult->any);
					if(!empty($rs['NewDataSet']['RoomRateDetail'])){
						$v['room_list'] = $rs['NewDataSet']['RoomRateDetail'];
					}else{
						$v['room_list'] = [];
					}
				}
			}
			reset($res);
			file_put_contents(FD_PUBLIC . '/junting_hotels_prod.json', json_encode($res));
			print_r($res);
		}
	}
	
	public function get_rooms(){
		$list = [
//			array('name' => '中央预订', 'hotel_id' => '4621', 'hotel_web_id' => '000000'),
//			array('name' => '上海柏阳君亭酒店', 'hotel_id' => '4623', 'hotel_web_id' => 'J021002'),
//			array('name' => '上海同文君亭酒店', 'hotel_id' => '4624', 'hotel_web_id' => 'J021003'),
//			array('name' => '珀斯君亭酒店', 'hotel_id' => '4627', 'hotel_web_id' => 'J061001'),
//			array('name' => '淀山湖中星君亭酒店', 'hotel_id' => '4628', 'hotel_web_id' => 'J512001'),
array('name' => '杭州湖滨君亭酒店', 'hotel_id' => '4630', 'hotel_web_id' => 'J571001'),
//			array('name' => '义乌华丰酒店', 'hotel_id' => '4640', 'hotel_web_id' => 'J579002'),
//			array('name' => '南昌红牛酒店', 'hotel_id' => '4641', 'hotel_web_id' => 'J791001'),
//			array('name' => '杭州千岛湖峰泰君亭酒店', 'hotel_id' => '4636', 'hotel_web_id' => 'J571007')
		];
		$result = [];
		$pa = [
			'strCannelId'       => $this->pms_auth['user'],
			'strCannelPassWord' => $this->pms_auth['pwd'],
			'dtArrival'         => date('Y-m-d'),
			'dtDeparutre'       => date('Y-m-d', time() + 86400),
		];
		foreach($list as $v){
			$pa['strHotelId'] = $v['hotel_web_id'];
			$rs = $this->soap->__soapCall('getRateDetail', ['parameters' => $pa]);
			if(!empty($rs->GetRateDetailResult->any)){
//				$result[] = $rs;
//				continue;
				$rs = xml2array($rs->GetRateDetailResult->any);
				if(!empty($rs['NewDataSet']['RoomRateDetail'])){
					$result[$v['hotel_id']] = $rs['NewDataSet']['RoomRateDetail'];
				}else{
					$result[$v['hotel_id']] = [];
				}
			}
		}
		exit(json_encode($result));
		$list = [];
		foreach($result as $k => $v){
			if(!empty($v)){
				foreach($v as $t){
					$list[$k][$t['code']][] = $t;
				}
			}
		}
		$rooms_param = $lowest_param = [];
		foreach($list as $k => $v){
			$min = [];
			if(!empty($v)){
				foreach($v as $t){
					$room_data = $t[0];
					foreach($t as $w){
						if($w['ratecode'] == 'RAC'){
							$min[] = $w['rate'];
						}
					}
					
					$rooms_param[] = [
						'hotel_id'    => $k,
						'inter_id'    => $this->inter_id,
						'name'        => !empty($room_data['descript']) ? $room_data['descript'] : $room_data['code'],
						'description' => !empty($room_data['descript']) ? $room_data['descript'] : $room_data['code'],
						'sub_des'     => '',
						'nums'        => 0,
						//						'bed_num'     => $t['BedCount'],
						//						'sort'        => $t['seqId'],
						'webser_id'   => $room_data['code'],
						'status'      => 1,
					];
				}
			}
			if($min){
				$lowest_param[] = [
					'hotel_id'     => $k,
					'inter_id'     => $this->inter_id,
					'lowest_price' => min($min),
					'update_time'  => date('Y-m-d H:i:s'),
				];
			}
		}
		$db = $this->load->database('default', true);
		if($rooms_param){
			$db->insert_batch('hotel_rooms_copy', $rooms_param);
		}
		if($lowest_param){
			$db->insert_batch('hotel_lowest_price_copy', $lowest_param);
		}
		echo 'success';
	}
	
	public function catches(){
		$json = file_get_contents(FD_PUBLIC . '/junting_pms_hotels.json');
		$list = json_decode($json, true);
		$additions_param = [];
		$rooms_param = [];
		$lowest_param = [];
		$hotels = [];
		foreach($list as $v){
			$room_list = $v['room_list'];
			unset($v['room_list']);
			foreach($room_list as $t){
				$v['room_list'][$t['code']] = $t;
			}
			$hotels[] = $v;
		}
		foreach($hotels as $v){
			$data = [
				'inter_id' => $this->inter_id,
				'name'     => $v['description'],
				'address'  => $v['address'],
				'tel'      => isset($v['phone']) ? $v['phone'] : '',
				//				'intro'       => $v['intro'],
				//				'short_intro' => $v['intro'],
				//				'province'    => $v['stateCName'],
				'city'     => $v['cityname'],
				'status'   => 1,
				//				'sort'        => $v['seqId'],
				//				'star'        => (int)$v['star'],
			
			];
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			if(!$additions_param){
				$additions_param[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'hotel_web_id'       => '',
					'pms_type'           => 'yuheng',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
					'pms_auth'           => json_encode($this->pms_auth)
				];
			}
			
			$additions_param[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'hotel_web_id'       => $v['hotelid'],
				'pms_type'           => 'yuheng',
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
				'pms_auth'           => json_encode($this->pms_auth)
			];
			
			if(!empty($v['room_list'])){
				$min = [];
				foreach($v['room_list'] as $k => $t){
					$rooms_param[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['descript'],
						'description' => $t['descript'],
						'sub_des'     => '',
						'nums'        => 0,
						//						'bed_num'     => $t['BedCount'],
						//						'sort'        => $t['seqId'],
						'webser_id'   => $k,
						'status'      => 1,
					];
					$min[] = $t['rate'];
				}
				if($min){
					$lowest_param[] = [
						'hotel_id'     => $hotel_id,
						'inter_id'     => $this->inter_id,
						'lowest_price' => min($min),
						'update_time'  => date('Y-m-d H:i:s'),
					];
				}
			}
		}
		
		if($additions_param){
			$this->db->insert_batch('hotel_additions', $additions_param);
		}
		if($rooms_param){
			$this->db->insert_batch('hotel_rooms', $rooms_param);
		}
		if($lowest_param){
			$this->db->insert_batch('hotel_lowest_price', $lowest_param);
		}
		echo 'success';
	}
	
	public function prod_catches(){
		$json = file_get_contents(FD_PUBLIC . '/junting_hotels_prod.json');
		$list = json_decode($json, true);
		$additions_param = [];
		$rooms_param = [];
		$lowest_param = [];
		$hotels = [];
		$db = $this->load->database('default', true);
		foreach($list as $v){
			$room_list = $v['room_list'];
			unset($v['room_list']);
			foreach($room_list as $t){
				$v['room_list'][$t['code']] = $t;
			}
			$hotels[] = $v;
		}
		foreach($hotels as $v){
			$data = [
				'inter_id' => $this->inter_id,
				'name'     => $v['description'],
				'address'  => $v['address'],
				'tel'      => isset($v['phone']) ? $v['phone'] : '',
				//				'intro'       => $v['intro'],
				//				'short_intro' => $v['intro'],
				//				'province'    => $v['stateCName'],
				'city'     => $v['cityname'],
				'status'   => 1,
				//				'sort'        => $v['seqId'],
				//				'star'        => (int)$v['star'],
			
			];
			$db->insert('hotels_copy', $data);
			$hotel_id = $db->insert_id();
			if(!$additions_param){
				$additions_param[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'hotel_web_id'       => '',
					'pms_type'           => 'yuheng',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
					'pms_auth'           => json_encode($this->pms_auth)
				];
			}
			
			$additions_param[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'hotel_web_id'       => $v['hotelid'],
				'pms_type'           => 'yuheng',
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
				'pms_auth'           => json_encode($this->pms_auth)
			];
			
			if(!empty($v['room_list'])){
				$min = [];
				foreach($v['room_list'] as $k => $t){
					$rooms_param[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['descript'],
						'description' => $t['descript'],
						'sub_des'     => '',
						'nums'        => 0,
						//						'bed_num'     => $t['BedCount'],
						//						'sort'        => $t['seqId'],
						'webser_id'   => $k,
						'status'      => 1,
					];
					$min[] = $t['rate'];
				}
				if($min){
					$lowest_param[] = [
						'hotel_id'     => $hotel_id,
						'inter_id'     => $this->inter_id,
						'lowest_price' => min($min),
						'update_time'  => date('Y-m-d H:i:s'),
					];
				}
			}
		}
		
		if($additions_param){
			$db->insert_batch('hotel_additions_copy', $additions_param);
		}
		if($rooms_param){
			$db->insert_batch('hotel_rooms_copy', $rooms_param);
		}
		if($lowest_param){
			$db->insert_batch('hotel_lowest_price_copy', $lowest_param);
		}
		echo 'success';
	}
	
	
	public function roomrate(){
		$pa = [
			'strCannelId'       => $this->pms_auth['user'],
			'strCannelPassWord' => $this->pms_auth['pwd'],
			'dtArrival'         => date('Y-m-d'),
			'dtDeparutre'       => date('Y-m-d', time() + 86400 * 3),
			'strHotelId'        => 'J021001',
		];
		$rs = $this->soap->__soapCall('GetRateDetail', ['parameters' => $pa]);
		if(!empty($rs->GetRateDetailResult->any)){
			$rs = xml2array($rs->GetRateDetailResult->any);
			if(!empty($rs['NewDataSet']['RoomRateDetail'])){
				$rs = $rs['NewDataSet']['RoomRateDetail'];
			}else{
				$rs = [];
			}
		}
		exit(json_encode($rs));
	}
	
	public function pricecode(){
		$db = $this->load->database('default', true);
		$rooms = $db->from('hotel_rooms_copy')->where(['inter_id' => $this->inter_id])->get()->result_array();
		$params = [];
		foreach($rooms as $v){
			for($i = 1; $i <= 3; $i++){
				$params[] = array(
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $i,
					'edittime'   => time(),
					'status'     => 1,
				);
			}
		}
		if($params){
			$db->insert_batch('hotel_price_set_copy', $params);
		}
	}
	
	public function fix(){
		$this->db->update('hotel_additions', [
			'pms_auth' => json_encode($this->pms_auth),
			'pms_type' => 'yuheng'
		], ['inter_id' => $this->inter_id]);
	}
	
	public function file_time(){
		$file = APPPATH . 'logs' . DS . 'pms' . DS . $this->inter_id . DS . date('Y-m-d') . '.txt';
		echo 'filectime:' . date('Y-m-d H:i:s', filectime($file)) . "\n";
		echo 'fileatime:' . date('Y-m-d H:i:s', fileatime($file)) . "\n";
		echo 'filemtime:' . date('Y-m-d H:i:s', filemtime($file)) . "\n";
		
	}
	
	public function test_payment(){
		$web_orderid = 'WX16122300003';
		$price = 428.00;
		$paytype = 5;
		$result = $this->serv_api->addPayment($web_orderid, $paytype, $price, $price);
		var_dump($result);
	}
	
	public function cancel_order(){
		$web_orderid='WX17010900009';
		print_r($this->serv_api->cancelOrder($web_orderid));
	}
	
	
}