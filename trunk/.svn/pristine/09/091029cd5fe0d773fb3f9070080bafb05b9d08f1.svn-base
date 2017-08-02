<?php

class Quanzhou extends MY_Controller{
//	private $inter_id = 'a497354152';
	
	private $inter_id = 'a498015157';
	//生产
	private $url = 'http://61.131.63.98:20200/PMSDataInterface/ReservationService/?wsdl';
	private $user = 'G+7AH+y8r+g=';
	private $pwd = 'rCaDR8mFSsI6iIrrGYEfRw==';
	
	private $channel_code = 'WCH';
	private $market_code = 'OTA';
	private $source_code = 'QZS';
	private $originator = '0351831';
	private $operator = 'XR_WX';
	
	private $hotel_web_id = 'QZJD';
	
	private $soap;
	private $pms_auth;

//	测试
//	private $url='http://116.62.16.31:20001/PMSDataInterface/ReservationService/?wsdl';
//	private $user='DFSdGoxv8aJ3kERUuZtAaQ==';
//	private $pwd='zvfIj3+443BaMLFMiveGFA==';
	
	public function __construct(){
		parent::__construct();
		$this->pms_auth = [
			'url'          => $this->url,
			'user'         => $this->user,
			'pwd'          => $this->pwd,
			'channel_code' => $this->channel_code,
			'market_code'  => $this->market_code,
			'source_code'  => $this->source_code,
			'originator'   => $this->originator,
			'operator'     => $this->operator,
			'paycode'      => ['weixin' => '9220', 'coupon' => '0108', 'point' => '0109', 'balance' => '9006']
		
		];
		$config = $this->pms_auth;
		$config['inter_id'] = $this->inter_id;
		
		$soap_opt = [
			'soap_version' => SOAP_1_1,
			'encoding'     => 'UTF-8',                                              
			//			'cache_wsdl'   => WSDL_CACHE_NONE,
			'trace'        => true,
		];
		$this->soap = new SoapClient($this->url, $soap_opt);
//				echo '<pre>';print_r($this->soap->__getFunctions());
//				print_r($this->soap->__getTypes());exit;
		$this->load->helper('common');
		
		$this->load->model('hotel/pms/Quanzhou_hotel_model', 'pms');
		$this->serv_api = new QuanzhouApi();
		$this->serv_api->setPmsAuth($config);
	}
	
	public function fixpms(){
		$this->db->where(['inter_id' => $this->inter_id])->update('hotel_additions', ['pms_auth' => json_encode($this->pms_auth)]);
		echo 'success';
	}
	
	public function allRoomType(){
		$params = [
			'parameters' => [
				'xml' => $this->data2xml(1017)
			],
		];
//		print_r($params['parameters']['xml']);
		$res = $this->soap->__soapCall('SearchRoomType', $params);
		$result = xml2array($res->SearchRoomTypeResult);
		$hotels[$this->hotel_web_id] = [
			'hotelid' => $this->hotel_web_id,
			'name'    => '泉州酒店',
		];
		$hotels[$this->hotel_web_id]['rooms'] = $result['Body']['ResponseBodyRmtype']['Rmtype'];
		
		file_put_contents(FD_PUBLIC . '/quanzhou/hotels_test.json', json_encode($hotels));
		echo json_encode($hotels);
	}
	
	public function catches(){
		$json = file_get_contents(FD_PUBLIC . '/quanzhou/hotels_test.json');
		$hotels = json_decode($json, true);
		$additions = $rooms = $icons = [];
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['name'],
				'address'     => '',
				'tel'         => '',
				'fax'         => '',
				'intro'       => $v['name'],
				'short_intro' => $v['name'],
				'city'        => '',
				'province'    => '',
				'star'        => 0,
				'latitude'    => '',
				'longitude'   => '',
			];
			
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'quanzhou',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'quanzhou',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['hotelid'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			
			if(!empty($v['rooms'])){
				is_array(current($v['rooms'])) or $v['rooms'] = [$v['rooms']];
				foreach($v['rooms'] as $t){
					$rooms[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['descript'],
						'description' => $t['descript'],
						'webser_id'   => $t['rmtype'],
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
	
	public function rmRate(){
		
		$web_rate = 'RAC';
		$web_room = 'SSR';
		$countday = 1;
		$sdate = date('Y-m-d');
		$res = $this->serv_api->getRmRate($web_room, $sdate, $countday, $web_rate);
		print_r($res);
		exit;
		
		set_time_limit(900);
		$data = [
			'RoomRate' => [
				'stay'     => date('Y-m-d') . 'T12:00:00.000',
				'type'     => 'SSR',
				'day'      => 1,
				'ratecode' => 'RAC',
			]
		];
		$params = [
			'parameters' => [
				'xml' => $this->data2xml(1014, $data)
			],
		];
		$res = $this->soap->__soapCall('GetRmrate', $params);
		print_r($params['parameters']['xml']);
		print_r($res);
//		$result=xml2array($res->GetRmrateResult);
//		print_r($result);
	}
	
	public function rateQuery(){
		
		$web_rates = ['RAC', 'GSXY', 'BJHY'];
		$sdate = date('Y-m-d');
		$countday = 1;
		$res = $this->serv_api->rateQuery($sdate, $countday, $web_rates);
		
		print_r($res);
		exit;
		
		set_time_limit(900);
		$data = [
			'RatePlans' => [
				'RatePlan' => [
					'ratePlanCode' => 'RAC,GSXY',
					'TimeSpan'     => [
						'startTime'         => date('Y-m-d') . ' 00:00:00',
						'numberOfTimeUnits' => 3,
					],
					'Rates'        => [
						'Rate' => 'SSR'
					],
					'CusNo'        => ''
				],
			]
		];
		/*$data=[
			'RatePlans'=>'<RatePlan reservationActionType="CHANGE"><ratePlanCode>RAC</ratePlanCode><TimeSpan timeUnitType="DAY"><startTime>'.date('Y-m-d').' 00:00:00</startTime><numberOfTimeUnits>5</numberOfTimeUnits></TimeSpan><Rates><Rate reservationActionType="CHANGE" rateBasisTimeUnitType="DAY"></Rate></Rates><CusNo></CusNo></RatePlan>',
		];*/
		$params = [
			'parameters' => [
				'xml' => $this->data2xml(1020, $data)
			],
		];
		$res = $this->soap->__soapCall('RateQueryByCusNo', $params);
		print_r($params['parameters']['xml']);
		echo "\n";
//		print_r($res);
		$result = xml2array($res->RateQueryByCusNoResult);
		print_r($result);
	}
	
	public function index(){
		die;
	}
	
	public function data2xml($systype, $data = []){
		$xml = '<?xml version="1.0" encoding="utf-8" ?><Request>';
		$head = [
			'transcode' => 10,
			'systype'   => $systype,
			'reqtime'   => date('Y-m-d') . 'T' . date('H:i:s'),
			'username'  => $this->user,
			'password'  => $this->pwd,
			'openid'    => '',
		];
		$xml .= '<Head>' . array2xml($head) . '</Head>';
		$xml .= '<Body>' . array2xml($data) . '</Body>';
		$xml .= '</Request>';
		return $xml;
	}
	
	public function priceset(){
		$rooms = $this->db->from('hotel_rooms')->where(['inter_id' => $this->inter_id])->get()->result_array();
		$params = [];
		foreach($rooms as $v){
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
}