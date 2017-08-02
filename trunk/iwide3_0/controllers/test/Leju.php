<?php

class Leju extends MY_Controller{
	//	private $inter_id = 'a478161062';//开发
	//	private $inter_id='a478664131';//测试
	private $inter_id = 'a479866040';//生产

	public function __construct(){
		parent::__construct();
		$soap_opt = [
			'soap_version' => SOAP_1_1,
			'encoding'     => 'UTF-8',
			'trace'        => true,
		];
		//		$url = 'http://116.255.236.235:8899/ipegasus/services/CrsService?wsdl';//测试API
		$url = 'http://116.255.254.142:8899/ipegasus/services/CrsService?wsdl';//生产API
		$this->soap = new SoapClient($url, $soap_opt);
		$this->load->helper('common');

		$var_xml = '<AuthenticationToken><Username>crs</Username><Password>crs.admin</Password></AuthenticationToken>';

		$soap_var = new SoapVar($var_xml, XSD_ANYXML);
		$soap_header = new SoapHeader('http://temporg.com/xsd/', 'SoapHeader', $soap_var, true);
		$this->soap_header = $soap_header;

		$this->pms_set = [
			'pms_auth' => json_encode([
				'url'        => $url,
				'user'       => 'crs',
				'pwd'        => 'crs.admin',
				'source'     => 'WX',
				'res_type'   => [
					'no_pay' => 'T',
					'paid'   => 'G',
				],
				'channel'    => 'weixin',
				'res_clerk'  => 'WEB',
				'res_status' => 'R',
				'res_mode'   => 'N',
			    'paytype'=>[
			    	'default'=>'ERP',
			        'weixin'=>'WECHATPAY',
			        'balance'=>'ZC'
			    ]
			]),

			'inter_id' => $this->inter_id
		];
		$this->load->database('default', 1);
	}

	public function fixed(){
		$this->db->update('hotel_additions', ['pms_auth' => $this->pms_set['pms_auth']], ['inter_id' => $this->inter_id]);
		echo $this->db->affected_rows();
	}

	function show(){
		$func = $this->soap->__getFunctions();
		$types = $this->soap->__getTypes();
		print_r(['functions' => $func, 'types' => $types]);
	}

	public function hotels(){
		set_time_limit(900);
		$obj = $this->soap->__soapCall('getHotelList', ['parameters' => []], null, $this->soap_header);
		$hotels = [];
		if(isset($obj->out->result) && $obj->out->result == 0 && !empty($obj->out->hotelDTOs->HotelDTO)){
			$hotels = obj2array($obj->out->hotelDTOs->HotelDTO);
			is_array(current($hotels)) or $hotels = [$hotels];
			foreach($hotels as &$v){
				$v['room_list'] = $this->rooms($v['hotelId']);
			}

		}
		exit(json_encode($hotels));

		if(!empty($hotels)){
			file_put_contents(FD_PUBLIC . '/leju_hotels_pms_prod.json', json_encode($hotels));
		}
	}

	public function rooms($hotelid = null){
		$param = [
			'parameters' => ['in0' => $hotelid]
		];
		$obj = $this->soap->__soapCall('getHotelRoomQty', $param, null, $this->soap_header);
		$rooms = [];
		if(isset($obj->out->result) && $obj->out->result == 0 && !empty($obj->out->rmTypes->RmType)){
			$rooms = obj2array($obj->out->rmTypes->RmType);
			is_array(current($rooms)) or $rooms = [$rooms];
		}
		return $rooms;
	}

	public function getratecodeandrmtype($hotelid){
		$param = [
			'parameters' => ['in0' => $hotelid]
		];
		$obj = $this->soap->__soapCall('getRateCodeAndRmTypeByHotelId', $param, null, $this->soap_header);
		exit(json_encode($obj));
		$rooms = [];
		if(isset($obj->out->result) && $obj->out->result == 0 && !empty($obj->out->rmTypes->RmType)){
			$rooms = obj2array($obj->out->rmTypes->RmType);
			is_array(current($rooms)) or $rooms = [$rooms];
		}
		return $rooms;
	}

	public function roomstate(){
		$hotelid = 44;
		$conf = json_decode($this->pms_set['pms_auth'], true);
		$conf['inter_id'] = $this->inter_id;
		$this->load->library('Baseapi/Qianlimaapi', $conf, 'serv_api');
		$ratecode = ['RACK2', 'KLP1', 'LJP1', 'COME1', 'SWV1'];
		$ratecode = ['KLP1', 'LJP1'];
		$result = $this->serv_api->getPmsRoomState($hotelid, $ratecode, date('Y-m-d'), date('Y-m-d', strtotime('+3 day', time())));
		echo json_encode($result);
	}

	public function lowest(){
		set_time_limit(900);
		$hotel_list = $this->db->from('hotel_additions_copy')->where(['inter_id'  => $this->inter_id,
																	  'hotel_id>' => 0
		])->get()->result_array();
		$conf = json_decode($this->pms_set['pms_auth'], true);
		$conf['inter_id'] = $this->inter_id;
		$this->load->library('Baseapi/Qianlimaapi', $conf, 'serv_api');
		$ratecode = ['ALL'];
		$params = [];
		foreach($hotel_list as $v){
			$result = $this->serv_api->getPmsRoomState($v['hotel_web_id'], $ratecode, date('Y-m-d'), date('Y-m-d', strtotime('+3 day', time())));
			$min = [];
			if(!empty($result)){
				foreach($result as $t){
					if($t['ratePrice'] > 0) $min[] = $t['ratePrice'];
				}
			}
			if($min){
				$params[] = [
					'hotel_id'     => $v['hotel_id'],
					'inter_id'     => $v['inter_id'],
					'lowest_price' => min($min),
					'update_time'  => date('Y-m-d H:i:s'),
				];
			}
		}
		if($params){
			$this->db->delete('hotel_lowest_price_copy', ['inter_id' => $this->inter_id]);
			$this->db->insert_batch('hotel_lowest_price_copy', $params);
			echo 'success';
		}
	}

	public function catches(){
		$json = file_get_contents(FD_PUBLIC . '/leju_hotels_pms_prod.json');
		$hotels = json_decode($json, true);
		$addition_params = [];
		$room_params = [];
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['CName'],
				'address'     => $v['address'],
				'tel'         => $v['tel'],
				'intro'       => $v['intro'],
				'short_intro' => $v['intro'],
				'province'    => $v['stateCName'],
				'city'        => $v['cityCName'],
				'status'      => $v['status'] == 1 ? 1 : 0,
				'sort'        => $v['seqId'],
				'star'        => (int)$v['star'],
				//				'latitude'    => $v['latitude'],
				//				'longitude'   => $v['longitute'],
			];

			$this->db->insert('hotels_copy', $data);
			$hotel_id = $this->db->insert_id();
			if(!$addition_params){
				$addition_params[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'qianlima',
					'pms_auth'           => $this->pms_set['pms_auth'],
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$addition_params[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'qianlima',
				'pms_auth'           => $this->pms_set['pms_auth'],
				'hotel_web_id'       => $v['hotelId'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];

			if(!empty($v['room_list'])){
				foreach($v['room_list'] as $t){
					$room_params[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['CName'],
						'description' => $t['CName'],
						'sub_des'     => '',
						'nums'        => 0,
						//						'bed_num'     => $t['BedCount'],
						'sort'        => $t['seqId'],
						'webser_id'   => $t['code'],
						'status'      => $t['status'] == 1 ? 1 : 0,
					];
				}
			}
		}

		if($addition_params){
			$this->db->insert_batch('hotel_additions_copy', $addition_params);
		}
		if($room_params){
			$this->db->insert_batch('hotel_rooms_copy', $room_params);
		}

		echo 'success';
	}

	public function priceset(){
		$list = $this->db->from('hotel_rooms_copy')->where(['inter_id' => $this->inter_id])->get()->result_array();
		$params = [];
		foreach($list as $v){
			for($i = 1; $i <= 5; $i++){
				$params[] = [
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $i,
				];
			}
		}
		$this->db->insert_batch('hotel_price_set_copy', $params);
		echo 'success';
	}

	public function test_payment(){
		$web_orderid = '108315';
		$pay_fee = '247';
		$pym = 'ERP';
		$param = [
			'in0' => $web_orderid,
			'in1' => $pay_fee,
			'in2' => $pym,
		];

		$obj = $this->soap->__soapCall('updateGres', ['parameters' => $param], null, $this->soap_header);
		print_r($this->soap->__getLastRequest());
		print_r($obj);

	}

	public function new_rooms(){
		$hotel_id = 4756;
		$hotel_web_id = '68';
		$rooms = $this->rooms($hotel_web_id);
		$room_params = [];
		foreach($rooms as $v){
			$room_params[] = [
				'hotel_id'    => $hotel_id,
				'inter_id'    => $this->inter_id,
				'name'        => $v['CName'],
				'description' => $v['CName'],
				'sub_des'     => '',
				'nums'        => 0,
				//						'bed_num'     => $t['BedCount'],
				'sort'        => $v['seqId'],
				'webser_id'   => $v['code'],
				'status'      => $v['status'] == 1 ? 1 : 0,
			];
		}
		$db = $this->load->database('default', true);
		$db->insert_batch('hotel_rooms_copy', $room_params);
		echo 'success';
	}
}