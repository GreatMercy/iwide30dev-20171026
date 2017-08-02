<?php

/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2017/3/9
 * Time: 17:35
 */
class Jinling extends MY_Controller{
//	private $inter_id = 'a491558929';
//	private $inter_id = 'a491796658';
//	private $url = 'http://218.94.138.251/FWI/ReservationService.asmx?wsdl';
//	private $InterID = 'xxx';
//	private $InterPwd = 'xxx';
//	private $Channel = 'WX';

//	private $inter_id = 'a491796658';
	private $inter_id = 'a492669988'; //生产
	private $url = 'http://223.112.1.211:9004/FWI/ReservationService.asmx?wsdl';
	private $InterID = 'xxx';
	private $InterPwd = 'xxx';
	private $Channel = 'WX';
	
	private $soap;
	private $pms_auth;
	
	public function __construct(){
		parent::__construct();
		$this->pms_auth = [
			'url'       => $this->url,
			'InterID'   => $this->InterID,
			'InterPwd'  => $this->InterPwd,
			'Channel'   => $this->Channel,
			'resv_type' => [
				'normal' => '1',
				'prepay' => 'E'
			],
			'pccode'    => ['weixin' => '9261', 'bonus' => '9090'],
			'NegoID'    => 'B155445',
		];
		
		$soap_opt = [
			'soap_version' => SOAP_1_1,
			'encoding'     => 'UTF-8',
			'cache_wsdl'   => WSDL_CACHE_NONE,
			'trace'        => true,
		];
		$this->soap = new SoapClient($this->url, $soap_opt);
		$this->load->helper('common');
	}
	
	public function fixpmsauth(){
		$this->db->update('hotel_additions', ['pms_auth' => json_encode($this->pms_auth)], ['inter_id' => $this->inter_id]);
	}
	
	public function funcs(){
		
		echo '<pre>';
		print_r($this->soap->__getFunctions());
		print_r($this->soap->__getTypes());
		exit;
	}
	
	public function getprice(){
		set_time_limit(0);
		$hotel_web_id = '010';
		
		$data = [
			'Channel'    => $this->Channel,
			'HotelID'    => $hotel_web_id,
			'ArrDate'    => '2017-05-28',
			'DepDate'    => '2017-05-29',
			'Rmtype'     => 'DK',
			'RateCode'   => 'WEB-BAR',
			'Amount'     => 1,
			'Adult'      => 1,
			'Child'      => 0,
			'CardNo'     => '',
			'NegoID'     => '',
			'IsBestRate' => '',
			//			'RmType'     => '',
			//			'RateCode'   => ''
		];
		
		$params = [
			'InterID'  => $this->InterID,
			'InterPwd' => $this->InterPwd,
			'RmInf'    => $data,
		];
		
		$res = $this->soap->__soapCall('GetRmInf_MED', ['parameter' => $params]);
//		exit(json_encode($res));
		$price_code = [];
		foreach($res->GetRmInf_MEDResult->RoomInfoList->RoomInfo as $v){
			foreach($v->RateCodeList->RateCodeInfo as $t){
				$price_code[$t->WebRateCode] = $t->RateCodeDesc;
			}
		}
		print_r([
			'request'    => $this->soap->__getLastRequest(),
			//			'request'=>$data,
			'response'   => $res,
			'price_code' => $price_code
		]);
	}
	
	
	public function singleprice(){
		set_time_limit(0);
		$hotel_web_id = '010';
		
		$data = [
			'Channel'  => $this->Channel,
			'HotelID'  => $hotel_web_id,
			'ArrDate'  => '2017-05-28',
			'DepDate'  => '2017-05-30',
			'Rmtype'   => 'DK',
			'RateCode' => 'WEB-BAR'
		];
		
		$params = [
			'InterID'  => $this->InterID,
			'InterPwd' => $this->InterPwd,
			'getrd'    => $data,
		];
		
		$res = $this->soap->__soapCall('GetRateDetailMED', ['parameter' => $params]);
		print_r($res);
		exit;
		/*exit(json_encode($res));
		$price_code=[];
		foreach($res->GetRmInf_MEDResult->RoomInfoList->RoomInfo as $v){
			foreach($v->RateCodeList->RateCodeInfo as $t){
				$price_code[$t->WebRateCode]=$t->RateCodeDesc;
			}
		}*/
		print_r([
			'request'  => $data,
			//			'request'=>$data,
			'response' => $res,
			//		    'price_code'=>$price_code
		]);
	}
	
	public function getcacheprice(){
		set_time_limit(0);
		$hotel_web_id = '033';
		
		$data = [
			'Channel'    => $this->Channel,
			'HotelID'    => $hotel_web_id,
			'ArrDate'    => date('Y-m-d', time()),
			'DepDate'    => date('Y-m-d', time() + 86400 * 20),
			'Amount'     => 1,
			'Adult'      => 1,
			'Child'      => 0,
			'CardNo'     => '',
			'NegoID'     => '',
			'IsBestRate' => '',
			'RmType'     => '',
			'RateCode'   => ''
		];
		
		$params = [
			'InterID'  => $this->InterID,
			'InterPwd' => $this->InterPwd,
			'RmInf'    => $data,
		];
		
		$res = $this->soap->__soapCall('GetRmRate_MED', ['parameter' => $params]);
//		exit(json_encode($res));
//		$res=obj2array($res->GetRmRate_MEDResult);
		/*$web_room_arr=[];
		foreach($res['RoomInfoList']['RoomInfo'] as $v){
			$web_room_arr[]=$v['RoomType'];
		}
		$web_room_arr=array_unique($web_room_arr);
		echo count($web_room_arr)."\n";
		exit(implode(',',$web_room_arr));*/
		$price_code = [];
		if(!empty($res->GetRmRate_MEDResult->RoomInfoList->RoomInfo)){
			foreach($res->GetRmRate_MEDResult->RoomInfoList->RoomInfo as $v){
				if(!empty($v->RateCodeList->RateCodeInfo)){
					foreach($v->RateCodeList->RateCodeInfo as $t){
						if(!empty($t->WebRateCode))
							$price_code[$t->WebRateCode] = $t->RateCodeDesc;
					}
				}
			}
		}
		
		echo json_encode([
			'request'    => $data,
			//			'requestHeader' => $this->soap->__getLastRequestHeaders(),
			//			'request'=>$data,
			'response'   => $res,
			'price_code' => $price_code
		]);
	}
	
	public function addorder(){
		$data = [
			'HotelID'       => '010',
			'Channel'       => $this->Channel,
			'ArrDate'       => date('Y-m-d'),
			'DepDate'       => date('Y-m-d', time() + 86400 * 7),
			'RmType'        => 'DKN',
			'RateCode'      => 'ELITE-BARA',
			'Rate'          => '460.00',
			'Amount'        => 3,
			'Audlt'         => 1,
			'Child'         => 0,
			'Name'          => '金房卡1,金房卡2,金房卡3',
			'Phone'         => '18888888888',
			'Country'       => '',
			'Zip'           => '',
			'MobileReceive' => false,
			'Mobile'        => '18888888888',
			'Email'         => '',
			'City'          => '',
			'Address'       => '',
			'Title'         => '',
			'Remark'        => '这是测试订单',
			'CardNo'        => '',
			'DepositRule'   => '',
			'CancelRule'    => '',
			'ResType'       => 'C',
			'CrsNo'         => '',
			'NegoID'        => '',
			'NegoType'      => '',
			'AgentOID'      => '',
			'AgentCardNo'   => '',
			'AgentMobile'   => '',
			'AgentType'     => '',
			
			//文档没有列出的参数
			'BeforeHour'    => '',
			//			'Payment'=>0,
			//			'PayMode'=>'C',
			//			'PayCode'=>'9200',
			
			//		    'Sta'=>'R',
			//		    'RoomNo'=>'',
			//		    'Name2'=>'',
			//		    'ResNo'=>'',
			//		    'Accnt'=>'',
			//		    'FName'>'',
			//		    'LName'=>'',
		
		];
		$params = [
			'InterID'  => $this->InterID,
			'InterPwd' => $this->InterPwd,
			'neworder' => $data,
		];
		$res = $this->soap->__soapCall('NewOrderMED', ['parameter' => $params]);
		print_r($this->soap->__getLastRequest());
		print_r($res);
		//C171382624, C171382625,C171382626
		
	}
	
	public function cancelorder(){
		$data = [
			'ResNo'   => $this->input->get('res_no'),
			'Accnt'   => '',
			'Channel' => $this->Channel,
		];
		$params = [
			'InterID'     => $this->InterID,
			'InterPwd'    => $this->InterPwd,
			'cancelorder' => $data,
		];
		
		$res = $this->soap->__soapCall('CancelOrderMED', ['parameter' => $params]);
		print_r($this->soap->__getLastRequest());
		print_r($res);
	}
	
	public function getorder(){
		$res_no = $this->input->get('res_no');
		$data = [
			'resNo' => $res_no,
			'crsNo' => '',
		];
		$res = $this->soap->__soapCall('GetRes', ['parameter' => $data]);
		print_r($this->soap->__getLastRequest());
		print_r($res);
	}
	
	public function gethotels(){
		set_time_limit(900);
		$data = [
			'InterID'  => $this->InterID,
			'InterPwd' => $this->InterPwd,
			'request'  => [
				'City' => '',
			],
		];
		$res = $this->soap->__soapCall('GetHotelList', ['paramters' => $data]);
		$res = obj2array($res->GetHotelListResult);
		$hotels = [];
		if($res['RetCode'] == 0){
			foreach($res['HotelList']['HotelInfo'] as $v){
				$hotels[$v['HotelId']] = [
					'hotel_web_id' => $v['HotelId'],
					'name'         => $v['HotelName']
				];
				
				$data = [
					'Channel'    => $this->Channel,
					'HotelID'    => $v['HotelId'],
					'ArrDate'    => date('Y-m-d'),
					'DepDate'    => date('Y-m-d', time() + 86400),
					'Amount'     => 1,
					'Adult'      => 1,
					'Child'      => 0,
					'CardNo'     => '',
					'NegoID'     => '',
					'IsBestRate' => '',
					'RmType'     => '',
					'RateCode'   => ''
				];
				
				$params = [
					'InterID'  => $this->InterID,
					'InterPwd' => $this->InterPwd,
					'RmInf'    => $data,
				];
				
				$result = $this->soap->__soapCall('GetRmRate_MED', ['parameter' => $params]);
				$result = obj2array($result->GetRmRate_MEDResult);
				if(isset($result['RetCode']) && $result['RetCode'] == 0){
					foreach($result['RoomInfoList']['RoomInfo'] as $t){
						$hotels[$v['HotelId']]['rooms'][] = [
							'name'      => $t['RoomDesc'],
							'webser_id' => $t['RoomType'],
						];
					}
				}
			}
		}
		
		echo json_encode($hotels);
	}
	
	public function catch_hotel(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/jinling_hotels_pms.json');
		exit($json);
		$hotels = json_decode($json, true);
		$rooms = [];
		$additions = [];
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['name'],
				'address'     => '',
				'tel'         => '',
				'intro'       => $v['name'],
				'short_intro' => '',
				'city'        => '',
				'province'    => '',
				'star'        => 0,
				//				'latitude'    => $v['latitude'],
				//				'longitude'   => $v['longitute'],
			];
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'xiruan3',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'xiruan3',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['hotel_web_id'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			
			if(!empty($v['rooms'])){
				foreach($v['rooms'] as $t){
					$rooms[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['name'],
						'description' => $t['name'],
						'webser_id'   => $t['webser_id'],
					];
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
	
	public function getrd(){
		set_time_limit(0);
		$hotel_web_id = '010';
		
		$data = [
			'Channel'  => $this->Channel,
			'HotelID'  => $hotel_web_id,
			'ArrDate'  => date('Y-m-d', time()),
			'DepDate'  => date('Y-m-d', time() + 86400 * 7),
			'Rmtype'   => 'DK',
			'RateCode' => 'WEB-LTO-B'
		];
		
		$params = [
			'InterID'  => $this->InterID,
			'InterPwd' => $this->InterPwd,
			'getrd'    => $data,
		];
		
		$res = $this->soap->__soapCall('GetRateDetail', ['parameter' => $params]);
		print_r([
			'request'  => $this->soap->__getLastRequest(),
			//			'request'=>$data,
			'response' => $res,
		]);
	}
	
	public function getRoomAvl(){
		$this->load->helper('common');
		$url = 'http://218.94.138.251/FWI/FoxhisChannelIS.asmx/GetRoomAmount';
		$params = [
			'HotelID'  => '010',
			'FromDate' => date('Y-m-d', time()),
			'ToDate'   => date('Y-m-d', time() + 86400 * 7),
			'NegoID'   => 1,
		];
		$post_request = http_build_query($params);
		$xml = doCurlPostRequest($url, $post_request);
//		exit($xml);
//		echo $xml;

//		$p = xml_parser_create();
//		xml_parse_into_struct($p, $xml, $vals, $index);
//		xml_parser_free($p);
//		print_r($index);
//		print_r($vals);
//		exit;
		/*$reader=new XMLReader();
		$reader->XML($xml);
		while($reader->read()){
			print_r($reader->name);
		}*/
		
		$dom = new DOMDocument();
		$dom->loadXML($xml);
		print_r($this->getArray($dom->documentElement));

//	    $result=xml2array($xml);
//	    var_dump($result);
	}
	
	function getArray($node){
		$array = false;
		
		if($node->hasAttributes()){
			foreach($node->attributes as $attr){
				$array[$attr->nodeName] = $attr->nodeValue;
			}
		}
		
		if($node->hasChildNodes()){
			if($node->childNodes->length == 1){
				$array = $this->getArray($node->firstChild);
			}else{
				foreach($node->childNodes as $childNode){
					if($childNode->nodeType != XML_TEXT_NODE){
						if($childNode->hasChildNodes() && $childNode->childNodes->length > 1){
							$array[$childNode->nodeName][] = $this->getArray($childNode);
						}else{
							$array[$childNode->nodeName] = $this->getArray($childNode);
						}
					}
				}
			}
		}else{
			return $node->nodeValue;
		}
		return $array;
	}
	
	public function priceset(){
		$hotel_id = 5085;
		set_time_limit(900);
		$rooms = $this->db->from('hotel_rooms')->where([
			'inter_id' => $this->inter_id,
			//			'hotel_id<>' => $hotel_id
		])->get()->result_array();
		$params = [];
		for($i = 21; $i <= 150; $i++){
			$params = [];
			foreach($rooms as $v){
				$params[] = [
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $i,
					'edittime'   => time(),
					'status'     => 1,
				];
			}
			$this->db->insert_batch('hotel_price_set', $params);
		}
		echo 'success';
	}
	
	public function room_label(){
		set_time_limit(900);
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/jinling_room_types.xls"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		
		$hotels = [];
		$hotel_web_id = $hotel_name = $label_name = '';
		$label_arr = $additions = $rooms = [];
		for($row = 2; $row <= $highestRow; $row++){
			if(!empty($sheet->getCell('B' . $row)->getValue())){
				$hotel_name = $sheet->getCell('B' . $row)->getValue();
			}
			
			if(!empty($sheet->getCell('A' . $row)->getValue())){
				$hotel_web_id = $sheet->getCell('A' . $row)->getValue();
				$hotels[$hotel_web_id] = [
					'name'         => $hotel_name,
					'hotel_web_id' => $hotel_web_id,
				];
			}
			
			if(!empty($sheet->getCell('C' . $row)->getValue())){
				$label_name = $sheet->getCell('C' . $row)->getValue();
				$label_arr[] = $label_name;
			}
			
			$hotels[$hotel_web_id]['rooms'][] = [
				'name'       => $sheet->getCell('D' . $row)->getValue(),
				'webser_id'  => $sheet->getCell('E' . $row)->getValue(),
				'label_name' => $label_name,
			];
		}
		
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['name'],
				'address'     => '',
				'tel'         => '',
				'intro'       => $v['name'],
				'short_intro' => '',
				'city'        => '',
				'province'    => '',
				'star'        => 0,
				//				'latitude'    => $v['latitude'],
				//				'longitude'   => $v['longitute'],
			];
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'xiruan3',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'xiruan3',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['hotel_web_id'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			
			if(!empty($v['rooms'])){
				foreach($v['rooms'] as $t){
					$rooms[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['name'],
						'description' => $t['name'],
						'webser_id'   => $t['webser_id'],
					];
				}
			}
		}
		if($additions){
			$this->db->insert_batch('hotel_additions', $additions);
		}
		if($rooms){
			$this->db->insert_batch('hotel_rooms', $rooms);
		}
		echo 'success' . "\n";
		
		$label_arr = array_unique($label_arr);
		$params = [];
		foreach($label_arr as $v){
			$params[] = [
				'inter_id'    => $this->inter_id,
				'label_name'  => $v,
				'label_tab'   => 'room',
				'type'        => 'roomtype',
				'create_time' => date('Y-m-d H:i:s'),
				'status'      => 1,
			];
		}
		if($params){
			$this->db->insert_batch('hotel_label_types', $params);
		}
		
		$label_res = $this->db->from('hotel_label_types')->where([
			'inter_id'  => $this->inter_id,
			'label_tab' => 'room',
			'type'      => 'roomtype',
			'status'    => 1
		])->select('type_id,label_name')->get()->result_array();
		$label_list = [];
		foreach($label_res as $v){
			$label_list[$v['label_name']] = $v['type_id'];
		}
		
		$local_res = $this->db->from('hotel_rooms r')->join('hotel_additions ha', 'ha.hotel_id=r.hotel_id', 'inner')->select('r.room_id,r.webser_id,r.name,ha.hotel_web_id,r.hotel_id,r.inter_id')->where([
			'r.inter_id' => $this->inter_id,
			'r.status'   => 1
		])->get()->result_array();
		
		$local_rooms = [];
		foreach($local_res as $v){
			$local_rooms[$v['hotel_web_id']][$v['webser_id']] = [
				'hotel_id' => $v['hotel_id'],
				'room_id'  => $v['room_id'],
				'inter_id' => $v['inter_id'],
			];
		}
		
		$params = [];
		foreach($hotels as $k => $v){
			foreach($v['rooms'] as $t){
				$rm_arr = $local_rooms[$k][$t['webser_id']];
				$label_type = $label_list[$t['label_name']];
				
				$params[] = [
					'inter_id'    => $rm_arr['inter_id'],
					'hotel_id'    => $rm_arr['hotel_id'],
					'tab_id'      => $rm_arr['room_id'],
					'label_type'  => $label_type,
					'create_time' => date('Y-m-d H:i:s'),
				];
			}
		}
		
		if($params){
			$this->db->insert_batch('hotel_labels', $params);
		}
		
		echo 'Complete';
		
		
	}
	
	public function import_ratecode(){
		set_time_limit(900);
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/jinling/ratecode_list.xlsx"); // 载入excel文件
		/*$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		
		$pre_pay=[];
		for($row=2;$row<=$highestRow;$row++){
			$ratecode=$sheet->getCell('C'.$row)->getValue();
			$rate_name=$sheet->getCell('D'.$row)->getValue();
			$pre_pay[$ratecode]=$rate_name;
		}*/
		
		$sheet = $PHPExcel->getSheet(1); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		
		$webrate = [];
		for($row = 2; $row <= $highestRow; $row++){
			$ratecode = $sheet->getCell('C' . $row)->getValue();
			$rate_name = $sheet->getCell('D' . $row)->getValue();
			$webrate[$ratecode] = $rate_name;
		}
		
		$params = [];
		$price_code = 21;
		$levels = [
			'373' => '微信会员',
			'374' => '普卡',
			'375' => '金卡',
			'376' => '铂金卡',
		];
		foreach($webrate as $k => $v){
			if(strpos($k, 'ELITE') !== false){
				foreach($levels as $lvl => $t){
					$params[] = [
						'price_code'           => $price_code,
						'inter_id'             => $this->inter_id,
						'price_name'           => $v,
						'channel_code'         => 'Weixin',
						'edittime'             => time(),
						'status'               => 1,
						'use_condition'        => json_encode([
							'pre_pay'      => 0,
							'no_pay_way'   => ['weixin', 'point'],
							'package_only' => 0,
							'member_level' => $lvl,
						]),
						'des'                  => $t,
						'sort'                 => 0,
						'type'                 => 'common',
						'unlock_code'          => '',
						'related_code'         => 0,
						'related_cal_way'      => 'divide',
						'related_cal_value'    => 0,
						'must_date'            => 3,
						'external_code'        => $k,
						'external_way'         => 0,
						'add_service_set'      => '',
						'coupon_condition'     => json_encode([
							'num_type'   => 'order',
							'coupon_num' => 1,
							'no_coupon'  => 0,
						]),
						'bonus_condition'      => json_encode([
							'no_part_bonus' => 1,
							'poc'           => 1,
						]),
						'time_condition'       => '',
						'bookpolicy_condition' => json_encode([
							'breakfast_nums' => -1,
							'retain_time'    => [
								'daofu'  => 18,
								'point'  => 18,
								'weixin' => 18,
							],
							'delay_time'     => [
								'daofu'  => 12,
								'point'  => 12,
								'weixin' => 12,
							],
						])
					];
					
					$price_code++;
				}
			}else{
				$params[] = [
					'price_code'           => $price_code,
					'inter_id'             => $this->inter_id,
					'price_name'           => $v,
					'channel_code'         => 'Weixin',
					'edittime'             => time(),
					'status'               => 1,
					'use_condition'        => json_encode([
						'pre_pay'      => 0,
						'no_pay_way'   => ['weixin', 'point'],
						'package_only' => 0,
					]),
					'des'                  => '',
					'sort'                 => 0,
					'type'                 => 'common',
					'unlock_code'          => '',
					'related_code'         => 0,
					'related_cal_way'      => 'divide',
					'related_cal_value'    => 0,
					'must_date'            => 3,
					'external_code'        => $k,
					'external_way'         => 0,
					'add_service_set'      => '',
					'coupon_condition'     => json_encode([
						'num_type'   => 'order',
						'coupon_num' => 1,
						'no_coupon'  => 0,
					]),
					'bonus_condition'      => json_encode([
						'no_part_bonus' => 1,
						'poc'           => 1,
					]),
					'time_condition'       => '',
					'bookpolicy_condition' => json_encode([
						'breakfast_nums' => -1,
						'retain_time'    => [
							'daofu'  => 18,
							'point'  => 18,
							'weixin' => 18,
						],
						'delay_time'     => [
							'daofu'  => 12,
							'point'  => 12,
							'weixin' => 12,
						],
					])
				];
				
				$price_code++;
			}
		}
		
		if($params){
//			print_r($params);exit;
			$this->db->insert_batch('hotel_price_info', $params);
			echo 'success';
		}
		
		
		/*echo json_encode([
			'prepay'=>$pre_pay,
		    'normal'=>$pay,
		]);*/
	}
	
	public function newrate(){
		$ratecode = [
			'WEB-SUM'  => '“清凉一夏”夏季促销',
			'WEB-SUM2' => '“清凉一夏”夏季促销二',
			'WEB-SUM3' => '“清凉一夏”夏季促销三',
			'WEB-QZ'   => '夏季亲子包价',
			'WEB-QZ2'  => '夏季亲子包价二',
			'WEB-QZ3'  => '夏季亲子包价三',
			'WEB-QZ4'  => '夏季亲子包价四',
			
			'WEB-618'    => '6.18大促活动价',
			'WEB-TJ'     => '特惠价（双早）',
			'ELITE-N-TJ' => '会员特惠价(无早)',
			'ELITE-TJ'   => '会员特惠价(双早)',
			'WEB-HGS1'   => '自助晚餐包价(赠送一张券)',
			'WEB-HGS2'   => '德云社门票包价(赠送一张券)',
		];
	}
	
	public function pkg_info(){
		set_time_limit(900);
		$db = $this->load->database('default', true);
		
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/jinling/pkg_des_list.xlsx"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		
		$pkg_info = [];
		for($i = 2; $i <= $highestRow; $i++){
			$pkg_info[$sheet->getCell('A' . $i)->getValue()][$sheet->getCell('C' . $i)->getValue()] = $sheet->getCell('D' . $i)->getValue();
		}
		
		/*$new_res = $db->from('hotel_additions_copy')->where(['inter_id'  => $this->inter_id,
		                                                     'hotel_id>' => 0
		])->get()->result_array();
		$new_hotels = [];
		foreach($new_res as $v){
			$new_hotels[$v['hotel_web_id']] = $v['hotel_id'];
		}*/
		
		$new_res = $this->db->from('hotel_additions')->where([
			'inter_id'  => $this->inter_id,
			'hotel_id>' => 0
		])->get()->result_array();
		$new_hotels = [];
		foreach($new_res as $v){
			$new_hotels[$v['hotel_web_id']] = $v['hotel_id'];
		}
		
		$params = [];
		foreach($pkg_info as $k => $v){
			foreach($v as $tk => $t){
				if(!empty($new_hotels[$k])){
					$params[] = [
						'web_value'       => $tk,
						'local_value'     => $t,
						'webservice_name' => 'xiruan3',
						'hotel_id'        => $new_hotels[$k],
						'inter_id'        => $this->inter_id,
						'status'          => 1,
						'value_type'      => 'pkg_data'
					];
				}
			}
		}

//		$db->insert_batch('hotel_config_copy', $params);
		$this->db->insert_batch('webservice_field_config', $params);
		echo 'success';
		
		
		/*$pkg_info = array_map('json_encode', $pkg_info);
		
		$this->load->library('Cache/Redis_proxy', array(
			'not_init'    => FALSE,
			'module'      => 'common',
			'refresh'     => FALSE,
			'environment' => ENVIRONMENT
		), 'redis_proxy');
		$redis = $this->redis_proxy;
		$redis->hMset('pkg_detail:' . $this->inter_id, $pkg_info);
		$redis->expire('pkg_detail:' . $this->inter_id, 86400 * 7);
		
		echo $redis->hGet('pkg_detail:' . $this->inter_id, '010');*/
	}
	
	public function room_label_prod(){
		set_time_limit(900);
		$db = $this->load->database('default', true);
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/jinling_room_types.xls"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		
		$hotels = [];
		$hotel_web_id = $hotel_name = $label_name = '';
		$label_arr = $additions = $rooms = [];
		for($row = 2; $row <= $highestRow; $row++){
			if(!empty($sheet->getCell('B' . $row)->getValue())){
				$hotel_name = $sheet->getCell('B' . $row)->getValue();
			}
			
			if(!empty($sheet->getCell('A' . $row)->getValue())){
				$hotel_web_id = $sheet->getCell('A' . $row)->getValue();
				$hotels[$hotel_web_id] = [
					'name'         => $hotel_name,
					'hotel_web_id' => $hotel_web_id,
				];
			}
			
			if(!empty($sheet->getCell('C' . $row)->getValue())){
				$label_name = $sheet->getCell('C' . $row)->getValue();
				$label_arr[] = $label_name;
			}
			
			$hotels[$hotel_web_id]['rooms'][] = [
				'name'       => $sheet->getCell('D' . $row)->getValue(),
				'webser_id'  => $sheet->getCell('E' . $row)->getValue(),
				'label_name' => $label_name,
			];
		}
		
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['name'],
				'address'     => '',
				'tel'         => '',
				'intro'       => $v['name'],
				'short_intro' => '',
				'city'        => '',
				'province'    => '',
				'star'        => 0,
				//				'latitude'    => $v['latitude'],
				//				'longitude'   => $v['longitute'],
			];
			$db->insert('hotels_copy', $data);
			$hotel_id = $db->insert_id();
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'xiruan3',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'xiruan3',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['hotel_web_id'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			
			if(!empty($v['rooms'])){
				foreach($v['rooms'] as $t){
					$rooms[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['name'],
						'description' => $t['name'],
						'webser_id'   => $t['webser_id'],
					];
				}
			}
		}
		if($additions){
			$db->insert_batch('hotel_additions_copy', $additions);
		}
		if($rooms){
			$db->insert_batch('hotel_rooms_copy', $rooms);
		}
		echo 'success' . "\n";
		
		$label_arr = array_unique($label_arr);
		$params = [];
		foreach($label_arr as $v){
			$params[] = [
				'inter_id'    => $this->inter_id,
				'label_name'  => $v,
				'label_tab'   => 'room',
				'type'        => 'roomtype',
				'create_time' => date('Y-m-d H:i:s'),
				'status'      => 1,
			];
		}
		if($params){
			$db->insert_batch('hotel_label_types_copy', $params);
		}
		
		$label_res = $db->from('hotel_label_types_copy')->where([
			'inter_id'  => $this->inter_id,
			'label_tab' => 'room',
			'type'      => 'roomtype',
			'status'    => 1
		])->select('type_id,label_name')->get()->result_array();
		$label_list = [];
		foreach($label_res as $v){
			$label_list[$v['label_name']] = $v['type_id'];
		}
		
		$local_res = $db->from('hotel_rooms_copy r')->join('hotel_additions_copy ha', 'ha.hotel_id=r.hotel_id', 'inner')->select('r.room_id,r.webser_id,r.name,ha.hotel_web_id,r.hotel_id,r.inter_id')->where([
			'r.inter_id' => $this->inter_id,
			'r.status'   => 1
		])->get()->result_array();
		
		$local_rooms = [];
		foreach($local_res as $v){
			$local_rooms[$v['hotel_web_id']][$v['webser_id']] = [
				'hotel_id' => $v['hotel_id'],
				'room_id'  => $v['room_id'],
				'inter_id' => $v['inter_id'],
			];
		}
		
		$params = [];
		foreach($hotels as $k => $v){
			foreach($v['rooms'] as $t){
				$rm_arr = $local_rooms[$k][$t['webser_id']];
				$label_type = $label_list[$t['label_name']];
				
				$params[] = [
					'inter_id'    => $rm_arr['inter_id'],
					'hotel_id'    => $rm_arr['hotel_id'],
					'tab_id'      => $rm_arr['room_id'],
					'label_type'  => $label_type,
					'create_time' => date('Y-m-d H:i:s'),
				];
			}
		}
		
		if($params){
			$db->insert_batch('hotel_labels_copy', $params);
		}
		
		echo 'Complete';
		
	}
	
	public function import2mp(){
		set_time_limit(900);
		$db = $this->load->database('default', true);
		
		$json = file_get_contents(FD_PUBLIC . '/jinling/jinling_pms_rooms.json');
		$old_res = json_decode($json, true);
		$old_rooms = [];
		foreach($old_res as $v){
			$old_rooms[$v['hotel_id']][] = $v;
		}
		
		$json = file_get_contents(FD_PUBLIC . '/jinling/jinling_pms_hotels.json');
		$old_res = json_decode($json, true);
		$old_hotels = [];
		foreach($old_res as $v){
			$v['rooms'] = $old_rooms[$v['hotel_id']];
			$old_hotels[] = $v;
		}
		
		$additions = $rooms = [];
		foreach($old_hotels as $v){
			$room_list = $v['rooms'];
			$hotel_web_id = $v['hotel_web_id'];
			unset($v['hotel_id'], $v['rooms'], $v['hotel_web_id']);
			$data = $v;
			
			$v['inter_id'] = $this->inter_id;
			$db->insert('hotels_copy', $data);
			$hotel_id = $db->insert_id();
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $v['inter_id'],
					'pms_type'           => 'xiruan3',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $v['inter_id'],
				'pms_type'           => 'xiruan3',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $hotel_web_id,
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			
			foreach($room_list as $t){
				$t['hotel_id'] = $hotel_id;
				$t['inter_id'] = $v['inter_id'];
				unset($t['room_id']);
				$rooms[] = $t;
			}
		}
		
		if($additions){
			$db->insert_batch('hotel_additions_copy', $additions);
		}
		if($rooms){
			$db->insert_batch('hotel_rooms_copy', $rooms);
		}
		echo 'success' . "\n";
		
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/jinling_room_types.xls"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		
		$label_arr = $hotels = [];
		for($row = 2; $row <= $highestRow; $row++){
			if(!empty($sheet->getCell('B' . $row)->getValue())){
				$hotel_name = $sheet->getCell('B' . $row)->getValue();
			}
			
			if(!empty($sheet->getCell('A' . $row)->getValue())){
				$hotel_web_id = $sheet->getCell('A' . $row)->getValue();
				$hotels[$hotel_web_id] = [
					'name'         => $hotel_name,
					'hotel_web_id' => $hotel_web_id,
				];
			}
			
			if(!empty($sheet->getCell('C' . $row)->getValue())){
				$label_name = $sheet->getCell('C' . $row)->getValue();
				$label_arr[] = $label_name;
			}
			
			$hotels[$hotel_web_id]['rooms'][] = [
				'name'       => $sheet->getCell('D' . $row)->getValue(),
				'webser_id'  => $sheet->getCell('E' . $row)->getValue(),
				'label_name' => $label_name,
			];
		}
		
		$label_arr = array_unique($label_arr);
		$params = [];
		foreach($label_arr as $v){
			$params[] = [
				'inter_id'    => $this->inter_id,
				'label_name'  => $v,
				'label_tab'   => 'room',
				'type'        => 'roomtype',
				'create_time' => date('Y-m-d H:i:s'),
				'status'      => 1,
			];
		}
		if($params){
			$db->insert_batch('hotel_label_types_copy', $params);
		}
		
		$label_res = $db->from('hotel_label_types_copy')->where([
			'inter_id'  => $this->inter_id,
			'label_tab' => 'room',
			'type'      => 'roomtype',
			'status'    => 1
		])->select('type_id,label_name')->get()->result_array();
		$label_list = [];
		foreach($label_res as $v){
			$label_list[$v['label_name']] = $v['type_id'];
		}
		
		$local_res = $db->from('hotel_rooms_copy r')->join('hotel_additions_copy ha', 'ha.hotel_id=r.hotel_id', 'inner')->select('r.room_id,r.webser_id,r.name,ha.hotel_web_id,r.hotel_id,r.inter_id')->where([
			'r.inter_id' => $this->inter_id,
			'r.status'   => 1
		])->get()->result_array();
		
		$local_rooms = [];
		foreach($local_res as $v){
			$local_rooms[$v['hotel_web_id']][$v['webser_id']] = [
				'hotel_id' => $v['hotel_id'],
				'room_id'  => $v['room_id'],
				'inter_id' => $v['inter_id'],
			];
		}
		
		$params = [];
		foreach($hotels as $k => $v){
			foreach($v['rooms'] as $t){
				$rm_arr = $local_rooms[$k][$t['webser_id']];
				$label_type = $label_list[$t['label_name']];
				
				$params[] = [
					'inter_id'    => $rm_arr['inter_id'],
					'hotel_id'    => $rm_arr['hotel_id'],
					'tab_id'      => $rm_arr['room_id'],
					'label_type'  => $label_type,
					'create_time' => date('Y-m-d H:i:s'),
				];
			}
		}
		
		if($params){
			$db->insert_batch('hotel_labels_copy', $params);
		}
		
		echo 'Complete';
		
	}
	
	
	public function merge_images(){
		set_time_limit(900);
		$json = file_get_contents(FD_PUBLIC . '/jinling/jinling_pms_hotels.json');
		$db = $this->load->database('default', true);
		$old_res = json_decode($json, true);
		$old_hotels = [];
		foreach($old_res as $v){
			$old_hotels[$v['hotel_id']] = $v['hotel_web_id'];
		}
		
		$json = file_get_contents(FD_PUBLIC . '/jinling/jinling_pms_rooms.json');
		$old_res = json_decode($json, true);
		$old_rooms = [];
		foreach($old_res as $v){
			$old_rooms[$v['hotel_id']][$v['room_id']] = $v['webser_id'];
		}
		
		$json = file_get_contents(FD_PUBLIC . '/jinling/jinling_pms_images.json');
		$old_images = json_decode($json, true);
		
		$new_res = $db->from('hotel_additions_copy')->where([
			'inter_id'  => $this->inter_id,
			'hotel_id>' => 0
		])->get()->result_array();
		$new_hotels = [];
		foreach($new_res as $v){
			$new_hotels[$v['hotel_web_id']] = $v['hotel_id'];
		}
		
		$new_res = $db->from('hotel_rooms_copy')->where([
			'inter_id'  => $this->inter_id,
			'hotel_id>' => 0
		])->get()->result_array();
		$new_rooms = [];
		foreach($new_res as $v){
			$new_rooms[$v['hotel_id']][$v['webser_id']] = $v['room_id'];
		}
		
		$image_data = [];
		$i = 0;
		foreach($old_images as $v){
			$i++;
			$hotel_web_id = $old_hotels[$v['hotel_id']];
			$hotel_id = $new_hotels[$hotel_web_id];
			if($v['room_id'] > 0){
				$webser_id = $old_rooms[$v['hotel_id']][$v['room_id']];
				$room_id = $new_rooms[$hotel_id][$webser_id];
				$v['room_id'] = $room_id;
			}
			$v['hotel_id'] = $hotel_id;
			$v['inter_id'] = $this->inter_id;
			unset($v['id']);
			$image_data[] = $v;
			if($i % 5000 == 0){
				$db->insert_batch('hotel_images_copy', $image_data);
				$image_data = [];
			}
		}
		
		if($image_data){
			$db->insert_batch('hotel_images_copy', $image_data);
		}
		echo 'success';
	}
	
	/*$levels = [
			'373' => '微信会员',
			'374' => '普卡',
			'375' => '金卡',
			'376' => '铂金卡',
		];*/
	
	public function pricecode_import(){
		set_time_limit(900);
		$json = file_get_contents(FD_PUBLIC . '/jinling/jinling_pms_pricecode.json');
		
		$old_res = json_decode($json, true);
		$match_levels = [
			'373' => 903,
			'374' => 904,
			'375' => 905,
			'376' => 906,
		];
		$params = [];
		foreach($old_res as $v){
			$v['inter_id'] = $this->inter_id;
			$use_condition = json_decode($v['use_condition'], true);
			if(!empty($use_condition['member_level'])){
				$use_condition['member_level'] = $match_levels[$use_condition['member_level']];
			}
			$v['use_condition'] = json_encode($use_condition);
			
			$params[] = $v;
		}
		$db = $this->load->database('default', true);
		
		$db->insert_batch('hotel_price_info_copy', $params);
		echo 'success';
		
		$new_res = $db->from('hotel_rooms_copy')->where(['inter_id' => $this->inter_id])->get()->result_array();
		$hotel_id = 0;
		$params = [];
		foreach($new_res as $v){
			if($params && $hotel_id != $v['hotel_id']){
				$db->insert_batch('hotel_price_set_copy', $params);
				$params = [];
			}
			for($i = 1; $i <= 150; $i++){
				$params[] = [
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $i,
					'edittime'   => time(),
					'status'     => 1,
				];
			}
			
			$hotel_id = $v['hotel_id'];
		}
		echo 'complete';
	}
	
	public function import_config(){
		set_time_limit(900);
		$json = file_get_contents(FD_PUBLIC . '/jinling/jinling_pms_config.json');
		
		$old_res = json_decode($json, true);
		$db = $this->load->database('default', true);
		
		$params = [];
		foreach($old_res as $v){
			unset($v['id']);
			$v['inter_id'] = $this->inter_id;
			$params[] = $v;
		}
		$db->insert_batch('hotel_config_copy', $params);
		echo 'success';
	}
	
	public function fill_openid(){
		$json = file_get_contents(FD_PUBLIC . '/jinling/order_list-20170523.json');
		$order_arr = json_decode($json, true);
		
		$order_list = [];
		foreach($order_arr as $v){
			$order_list[$v['web_orderid']] = $v;
		}
		
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		for($f = 20170519; $f <= 20170523; $f++){
			$PHPExcel = $reader->load(FD_PUBLIC . "/jinling/daily/$f.xlsx"); // 载入excel文件
			$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
			$highestRow = $sheet->getHighestRow(); // 取得总行数
			
			//创建一个excel
			$objExcel = new PHPExcel();
			$objExcel->setActiveSheetIndex(0);
			
			$letter_arr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
			
			foreach($letter_arr as $v){
				$objExcel->getActiveSheet()->getColumnDimension($v)->setAutoSize(true);
				$objExcel->getActiveSheet()->getStyle($v . '1')->setFont($sheet->getStyle($v . '1')->getFont());
				$objExcel->getActiveSheet()->getStyle($v . '1')->getAlignment()->setHorizontal($sheet->getStyle($v . '1')->getAlignment()->getHorizontal());
				$objExcel->getActiveSheet()->getStyle($v . '1')->getFill()->setFillType($sheet->getStyle($v . '1')->getFill()->getFillType());
				$objExcel->getActiveSheet()->getStyle($v . '1')->getFill()->getStartColor()->setARGB($sheet->getStyle($v . '1')->getFill()->getStartColor()->getARGB());
				if(!empty($sheet->getCell($v . '1')->getValue())){
					$objExcel->getActiveSheet()->setCellValue($v . '1', $sheet->getCell($v . '1')->getValue());
				}
			}
			$objExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
			$objExcel->getActiveSheet()->getStyle('M1')->setFont($sheet->getStyle('J1')->getFont());
			$objExcel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal($sheet->getStyle('J1')->getAlignment()->getHorizontal());
			$objExcel->getActiveSheet()->getStyle('M1')->getFill()->setFillType($sheet->getStyle('J1')->getFill()->getFillType());
			$objExcel->getActiveSheet()->getStyle('M1')->getFill()->getStartColor()->setARGB($sheet->getStyle('J1')->getFill()->getStartColor()->getARGB());
			
			$objExcel->getActiveSheet()->setCellValue('M1', '备注');
			
			for($i = 2; $i <= $highestRow; $i++){
				
				$objExcel->getActiveSheet()->getCell('M' . $i)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING2);
				
				foreach($letter_arr as $v){
					$objExcel->getActiveSheet()->getColumnDimension($v)->setAutoSize(true);
					$objExcel->getActiveSheet()->getStyle($v . $i)->setFont($sheet->getStyle($v . $i)->getFont());
					$objExcel->getActiveSheet()->getStyle($v . $i)->getAlignment()->setHorizontal($sheet->getStyle($v . $i)->getAlignment()->getHorizontal());
					$objExcel->getActiveSheet()->getStyle($v . $i)->getFill()->setFillType($sheet->getStyle($v . $i)->getFill()->getFillType());
					$objExcel->getActiveSheet()->getStyle($v . $i)->getFill()->getStartColor()->setARGB($sheet->getStyle($v . $i)->getFill()->getStartColor()->getARGB());
					if(!empty($sheet->getCell($v . $i)->getValue())){
						$objExcel->getActiveSheet()->setCellValue($v . $i, $sheet->getCell($v . $i)->getValue());
					}
				}
				
				$objExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
				$objExcel->getActiveSheet()->getStyle('M' . $i)->setFont($sheet->getStyle('J' . $i)->getFont());
				$objExcel->getActiveSheet()->getStyle('M' . $i)->getFont()->getColor()->setRGB('#CC0000');
				$objExcel->getActiveSheet()->getStyle('M' . $i)->getAlignment()->setHorizontal($sheet->getStyle('J' . $i)->getAlignment()->getHorizontal());
				$objExcel->getActiveSheet()->getStyle('M' . $i)->getFill()->setFillType($sheet->getStyle('J' . $i)->getFill()->getFillType());
				$objExcel->getActiveSheet()->getStyle('M' . $i)->getFill()->getStartColor()->setARGB($sheet->getStyle('J' . $i)->getFill()->getStartColor()->getARGB());
				
				$openid = $sheet->getCell('J' . $i)->getValue();
				$web_orderid = $sheet->getCell('I' . $i)->getValue();
				if(empty($openid)){
					if(isset($order_list[$web_orderid])){
						$objExcel->getActiveSheet()->setCellValue('M' . $i, $order_list[$web_orderid]['openid']);
					}
				}
				
			}
			
			$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
			
			$objWriter->save(FD_PUBLIC . '/jinling/merge/' . $f . '.xlsx');
		}
		echo 'success';
		
	}
	
	public function newset(){
		$rooms = [
			['hotel_id' => 5680, 'room_id' => 27628, 'inter_id' => $this->inter_id],
			['hotel_id' => 5680, 'room_id' => 27629, 'inter_id' => $this->inter_id],
		];
		
		$params = [];
		foreach($rooms as $v){
			for($i = 1; $i <= 150; $i++){
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
	}
	
}