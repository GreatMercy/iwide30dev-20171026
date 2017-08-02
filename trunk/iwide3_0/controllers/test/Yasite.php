<?php

class Yasite extends MY_Controller{

	private $soap_url = 'http://121.41.82.114:9020/CloudUnion.asmx?WSDL';
	private $client;
	private $inter_id;
	private $pms_set;

	private $hotel_list = array(
		array('hotel_web_id' => '1', 'name' => '雅斯特酒店（深圳坪山店）', 'hotel_id' => '1232'),
		array('hotel_web_id' => '2', 'name' => '雅斯特酒店（南宁友宁店）', 'hotel_id' => '1233'),
		array('hotel_web_id' => '3', 'name' => '雅斯特酒店（广西贵港中央广场店）', 'hotel_id' => '1234'),
		array('hotel_web_id' => '4', 'name' => '雅斯特酒店（南宁琅东金湖广场店）', 'hotel_id' => '1235'),
		array('hotel_web_id' => '5', 'name' => '雅斯特酒店（南宁朝阳万达广场店）', 'hotel_id' => '1236'),
		array('hotel_web_id' => '6', 'name' => '雅斯特酒店（湖北宜昌解放路步行街店）', 'hotel_id' => '1237'),
		array('hotel_web_id' => '7', 'name' => '雅斯特酒店（南宁宾阳店）', 'hotel_id' => '1238'),
		array('hotel_web_id' => '8', 'name' => '雅斯特酒店（广西北海北部湾广场店）', 'hotel_id' => '1239'),
		array('hotel_web_id' => '9', 'name' => '雅斯特酒店（广西钦州港店）', 'hotel_id' => '1240'),
		array('hotel_web_id' => '10', 'name' => '雅斯特酒店（南宁江南金盛广场店）', 'hotel_id' => '1241'),
		array('hotel_web_id' => '11', 'name' => '雅斯特酒店（广西钦州人民路店）', 'hotel_id' => '1242'),
		array('hotel_web_id' => '12', 'name' => '雅斯特酒店（湖北咸宁崇阳店）', 'hotel_id' => '1243'),
		array('hotel_web_id' => '14', 'name' => '雅斯特酒店（广西靖西店）', 'hotel_id' => '1244'),
		array('hotel_web_id' => '15', 'name' => '雅斯特酒店（湖北咸宁温泉店）', 'hotel_id' => '1245'),
		array('hotel_web_id' => '16', 'name' => '雅斯特酒店（湖北随州白云湖店）', 'hotel_id' => '1246'),
		array('hotel_web_id' => '17', 'name' => '雅斯特酒店（南宁朝阳广场店）', 'hotel_id' => '1247'),
		array('hotel_web_id' => '18', 'name' => '雅斯特酒店（广西柳州柳侯公园店）', 'hotel_id' => '1248'),
		array('hotel_web_id' => '19', 'name' => '城市便捷酒店（南宁友爱南棉路店）', 'hotel_id' => '1249'),
		array('hotel_web_id' => '20', 'name' => '城市便捷酒店（贵港世纪广场店）', 'hotel_id' => '1250'),
		array('hotel_web_id' => '21', 'name' => '雅斯特酒店PLUS（南宁南湖公园店）', 'hotel_id' => '1251'),
		array('hotel_web_id' => '22', 'name' => '雅斯特酒店（广西玉林文化广场店）', 'hotel_id' => '1252'),
		array('hotel_web_id' => '23', 'name' => '雅斯特酒店（南宁衡阳东路店）', 'hotel_id' => '1253'),
		array('hotel_web_id' => '24', 'name' => '雅斯特酒店（南宁亭江路店）', 'hotel_id' => '1254'),
		array('hotel_web_id' => '25', 'name' => '雅斯特酒店（广西贺州市政广场店）', 'hotel_id' => '1255'),
		array('hotel_web_id' => '26', 'name' => '雅斯特酒店（广西柳州白云市场店）', 'hotel_id' => '1256'),
		array('hotel_web_id' => '27', 'name' => '雅斯特酒店PLUS（武汉省博物馆店）', 'hotel_id' => '1257'),
		array('hotel_web_id' => '28', 'name' => '雅斯特酒店PLUS（武汉体育学院店）', 'hotel_id' => '1258'),
		array('hotel_web_id' => '29', 'name' => '雅斯特酒店PLUS（桂林万福广场店', 'hotel_id' => '1259'),
		array('hotel_web_id' => '30', 'name' => '雅斯特酒店PLUS（贵港桂平西山店）', 'hotel_id' => '1260'),
		array('hotel_web_id' => '31', 'name' => '雅斯特酒店PLUS（湖南邵阳邵东店）', 'hotel_id' => '1261'),
		array('hotel_web_id' => '32', 'name' => '雅斯特酒店PLUS（南宁上林店）', 'hotel_id' => '1262'),
		array('hotel_web_id' => '33', 'name' => '雅斯特酒店PLUS（桂林北极广场店）', 'hotel_id' => '1263'),
		array('hotel_web_id' => '34', 'name' => '雅斯特酒店PLUS（钦州年年丰广场店）', 'hotel_id' => '1264'),
		array('hotel_web_id' => '35', 'name' => '雅斯特酒店PLUS（南宁武鸣店）', 'hotel_id' => '1265'),
		array('hotel_web_id' => '36', 'name' => '武汉中山公园店', 'hotel_id' => '1266'),
		array('hotel_web_id' => '37', 'name' => '雅斯特酒店PLUS（南宁广西大学店）', 'hotel_id' => '1267'),
		array('hotel_web_id' => '38', 'name' => '雅斯特酒店PLUS（南宁火车站店）', 'hotel_id' => '1268'),
		array('hotel_web_id' => '39', 'name' => '广西梧州高铁站店', 'hotel_id' => '1269'),
		array('hotel_web_id' => '40', 'name' => '雅斯特酒店PLUS（南宁青山路店）', 'hotel_id' => '1270'),
		array('hotel_web_id' => '41', 'name' => '雅斯特酒店PLUS（南宁琅西桂春路店）', 'hotel_id' => '1271'),
		array('hotel_web_id' => '72', 'name' => '雅美途酒店（钦州时代名城店）', 'hotel_id' => '1272'),
		array('hotel_web_id' => '73', 'name' => '雅斯特酒店（襄阳常春店）', 'hotel_id' => '1273'),
		array('hotel_web_id' => '99999', 'name' => '测试店', 'hotel_id' => '1274')
	);

	public function __construct(){
		parent::__construct();
		$this->client = new SoapClient($this->soap_url, array(
			'encoding' => 'UTF-8',
		));
		$this->pms_set = array(
			'pms_auth' => json_encode(array(
				                          'url'  => $this->soap_url,
				                          'user' => 'yestehotel',
				                          'pwd'  => 'yestehotel400.+-',
			                          )),

			'inter_id' => $this->inter_id
		);
		$this->inter_id = 'a445223616';
	}

	public function getAllHotels(){


//		$str_hotel = $this->client->GetAllHotels()->GetAllHotelsResult;
//		print_r($this->client->__getFunctions());
//		     print_r($this->client->__getTypes());
//		exit;
		$str_hotel = $this->client->__soapCall('GetAllHotels', array())->GetAllHotelsResult;
		$hotel = json_decode($str_hotel, TRUE);
//		echo '<pre>';
//		print_r($hotel);
		return $hotel;
	}

	public function getAllHotelsInfo(){

		$str_info_list = $this->client->GetAllHotelAttachedInfo()->GetAllHotelAttachedInfoResult;
		$info_list = json_decode($str_info_list, TRUE);
//		echo '<pre>';
//		print_r($info_list);
		return $info_list;
	}

	protected function getRoomsByHotelId($hid){
		/*	$str_rooms=$this->client->_soapCall('GetAllRoomType',array (
				'parameters' => array('HotelID '=>$hid)
			) );*/
//		$str_rooms=$this->client->GetAllRoomType($hid)->GetAllRoomTypeResult;

		$str_rooms = $this->client->__soapCall('GetAllRoomType', array('parameters' => array('hotelID' => $hid)))->GetAllRoomTypeResult;

		$rooms = json_decode($str_rooms, TRUE);
//		echo $str_rooms;
		return $rooms;
	}

	protected function getStatusByHotelId($hid){
		/*	$str_rooms=$this->client->_soapCall('GetAllRoomType',array (
				'parameters' => array('HotelID '=>$hid)
			) );*/
//	$str_status=$this->client->GetAllHotelHouseStatusInfo($hid)->GetAllHotelHouseStatusInfoResult;

		$str_status = $this->client->__soapCall('GetAllHotelHouseStatusInfo', array(
			'parameters' => array(
				'HotelID' => $hid,       //Date(1463587200000)
				//				'StartDate' => date('Y-m-d'),
				//				'EndDate'   => date('Y-m-d', time() + 86400),
			)
		))->GetAllHotelHouseStatusInfoResult;
//		exit($str_status);
		$temp = json_decode($str_status, TRUE);

		$price_arr = array();
		foreach($temp as $v){
			$v['AccDate'] = substr($v['AccDate'], strpos($v['AccDate'], '(') + 1, 10);
			$price_arr[$v['RoomTypeID']][$v['RoomRateTypeID']][] = array(
				'RoomRate'      => $v['RoomRate'],
				'RoomCount'     => $v['RoomCount'],
				'CheckInCount'  => $v['CheckInCount'],
				'BookInCount'   => $v['BookInCount'],
				'StopSaleCount' => $v['StopSaleCount'],
				'ControlCount'  => $v['ControlCount'],
				'AccDate'       => $v['AccDate']
			);
		}

		$status = array();
		foreach($temp as $v){
			$v['AccDate'] = substr($v['AccDate'], strpos($v['AccDate'], '(') + 1, 10);
			$v['ts'] = date('Y-m-d', $v['AccDate']);
			unset($v['RoomRate'], $v['RoomCount'], $v['CheckInCount'], $v['BookInCount'], $v['StopSaleCount'], $v['ControlCount'], $v['AccDate']);
			$status[$v['RoomTypeID']][$v['RoomRateTypeID']] = $v;
		}
		foreach($status as &$v){
			foreach($v as &$t){
				$t['DailyPrice'] = $price_arr[$t['RoomTypeID']][$t['RoomRateTypeID']];
			}
		}
		return $status;
	}

	public function testRoom(){
		print_r($this->getStatusByHotelId(isset($_GET['hotel_id']) ? $_GET['hotel_id'] : 99999));
	}

	public function mergeInfo(){
		ini_set('display_errors', 'On');
		set_time_limit(0);
		$hotels = $this->getAllHotels();
		$infos = $this->getAllHotelsInfo();
		$results = array();
		$count = count($hotels);
		for($i = 0; $i < $count; $i++){
			$results[$hotels[$i]['ChainID']]['base'] = $hotels[$i];
			if(isset($infos[$i])){
				$results[$infos[$i]['ChainID']]['info'] = $infos[$i];
			}
			$results[$hotels[$i]['ChainID']]['rooms'] = $this->getRoomsByHotelId($hotels[$i]['ChainID']);
//			$results[$hotels[$i]['ChainID']]['status'] = $this->getStatusByHotelId($hotels[$i]['ChainID']);
		}
		print_r($results);
		echo json_encode($results);
//		return $results;
	}


	public function mergeToDb(){
		set_time_limit(0);
		$results = $this->mergeInfo();
//		echo json_encode($results);exit;
//		                           print_r($results);
		$inter_id = 'a445223617';
		$this->load->model('hotel/pms/Yasite_hotel_model', 'pms');
		$res = array();
		foreach($results as $k => $v){
			if(!empty($v['base'])){

				$params = array(
					'inter_id' => $inter_id,
					'name'     => $v['base']['ChainName'],
					'address'  => $v['base']['ChainAddress'],
					'tel'      => $v['base']['Telephone'],
					'intro'    => isset($v['info']['Summary']) ? $v['info']['Summary'] : '',
					'city'     => $v['base']['CityName'],
				);
				$this->pms->_shard_db()->set($params);
				$this->pms->_shard_db()->insert('hotels');
				$insert_id = $this->pms->insert_id();
				$data = array(
					'hotel_id'           => $insert_id,
					'inter_id'           => $inter_id,
					'pms_type'           => 'yasite',
					'pms_auth'           => json_encode(array(
						                                    'url'  => $this->soap_url,
						                                    'user' => 'yestehotel',
						                                    'pwd'  => 'yestehotel400.+-',
					                                    )),
					'hotel_web_id'       => $k,
					'pms_room_state_way' => 3,
					'pms_member_way'     => 1,
				);
				$this->pms->_shard_db()->set($data);
				$this->pms->_shard_db()->insert('hotel_additions');

				if($v['rooms']){
					foreach($v['rooms'] as $t){
						$room_data = array(
							'hotel_id'    => $insert_id,
							'inter_id'    => $inter_id,
							'name'        => $t['RoomTypeName'],
							'description' => $t['Description'],
							'sub_des'     => $t['Remark'],
							'nums'        => 0,
							'bed_num'     => $t['BedCount'],
							'sort'        => $t['Sort'],
							'webser_id'   => $t['RoomTypeID'],
						);
						$this->pms->_shard_db()->set($room_data);
						$this->pms->_shard_db()->insert('hotel_rooms');
					}
				}

				$res['success'][] = $k;
			} else{
				$res['fail'][] = $k;
			}

		}

		echo json_encode($res);

	}

	/*public function getOrder(){
		$oid = '4822';
		$this->load->model('hotel/pms/Yasite_hotel_model', 'pms');
		$pms_res = $this->pms->get_web_order($oid, $this->pms_set);
		print_r($pms_res);
	}*/

	public function catch_rooms(){

		$this->load->model('hotel/pms/Yasite_hotel_model', 'pms');
		$hc = count($this->hotel_list);
		$list = array();
		for($i = 0; $i < $hc; $i++){
			$v = $this->hotel_list[$i];
			$v['rooms'] = $this->getRoomsByHotelId($v['hotel_web_id']);
			$list[] = $v;
		}

		$room_data = array();
		foreach($list as $v){
			foreach($v['rooms'] as $t){
				$room_data[] = array(
					'hotel_id'    => $v['hotel_id'],
					'inter_id'    => $this->inter_id,
					'name'        => $t['RoomTypeName'],
					'description' => $t['Description'],
					'sub_des'     => $t['Remark'],
					'nums'        => 0,
					'bed_num'     => $t['BedCount'],
					'sort'        => $t['Sort'],
					'webser_id'   => $t['RoomTypeID'],
				);
			}
		}
		if($room_data){
			$db = $this->pms->_shard_db();
			$db->set_insert_batch($room_data)->insert_batch('hotel_rooms_copy');
		}
		echo 'success';

	}

	public function get_min_price(){
		set_time_limit(0);
		$this->load->model('hotel/pms/Yasite_hotel_model', 'pms');
		$db = $this->pms->_shard_db();

		$data = array();
		$fail = array();
		foreach($this->hotel_list as $v){
			try{
				$info = $this->getStatusByHotelId($v['hotel_web_id']);
				$min = NULL;
				foreach($info as $t){
					foreach($t as $tmp){
						$pz = array_shift($tmp['DailyPrice']);
						$min = $min !== NULL ? min($min, $pz['RoomRate']) : $pz['RoomRate'];
					}
				}
				$min = intval($min * 0.9);
				$data[] = array(
					'hotel_id'     => $v['hotel_id'],
					'inter_id'     => $this->inter_id,
					'lowest_price' => $min,
					'update_time'  => date('Y-m-d H:i:s'),
				);
			} catch(Exception $e){
				$fail[] = $v;
				continue;
			}

		}
//		file_put_contents(FD_PUBLIC . '/fail.json', json_encode($fail));

		$db->set_insert_batch($data)->insert_batch('hotel_lowest_price_copy');
		echo 'success';
	}

	public function price_set(){
		$this->load->model('hotel/pms/Yasite_hotel_model', 'pms');
		$db = $this->pms->_shard_db();
		$rooms_list = $db->where(array('inter_id' => $this->inter_id))->from('hotel_rooms_copy')->get()->result_array();
		$price_list = array(
			array('price_code' => 1),
			array('price_code' => 2),
			array('price_code' => 3),
			array('price_code' => 4),
			array('price_code' => 5),
		);
		$params = array();
		foreach($rooms_list as $v){
			foreach($price_list as $t){
				$params[] = array(
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $t['price_code'],
					'edittime'   => time(),
					'status'     => 1,
				);
			}
		}

		$db->set_insert_batch($params)->insert_batch('hotel_price_set_copy');

		$db->where(array(
			           'inter_id'   => $this->inter_id,
			           'price_code' => 1
		           ))->set(array('status' => 2))->update('hotel_price_set_copy');

	}

	public function getHotels(){
		print_r($this->getAllHotels());
	}

	/*public function testReserve(){
		$room_codes = array(
			99999 => array(
				'room' => array(
					'webser_id' => 1,
					'name'      => '标准大床房',
				),
			),

		);

		$order = array(
			'first_detail' => array(
				'room_id' => 99999,
			),
			'roomnums'     => 1,
			'tel'          => '12345678912',
			'enddate'      => '2016-05-30',
			'startdate'    => '2016-05-20',
			'name'         => '测试专号',
			'holdtime'     => 7,
			'price'        => 248,
			'openid'       => '',
			'trans_no'     => '999999',
			'room_codes'   => json_encode($room_codes)
		);
	}

	public function updateUP(){
		$this->load->model('hotel/pms/Yasite_hotel_model', 'pms');
//		print_r($this->pms->_shard_db()->where(array('inter_id'=>$this->inter_id))->from('hotel_additions')->get()->result_array());
		$data = array(
			'pms_auth' => json_encode(array(
				                          'url'  => $this->soap_url,
				                          'user' => 'yestehotel',
				                          'pwd'  => 'yestehotel400.+-',
			                          )),
		);
		$this->pms->_shard_db()->where(array('inter_id' => $this->inter_id))->set($data)->update('hotel_additions');

		print_r($this->pms->_shard_db()->where(array('inter_id' => $this->inter_id))->from('hotel_additions')->get()->result_array());
	}

	public function testAuth(){
		//HelloWorld
		$this->load->model('hotel/pms/Yasite_hotel_model', 'pms');
		$data = array(
			'pms_auth' => json_encode(array(
				                          'url'  => $this->soap_url,
				                          'user' => 'yestehotel',
				                          'pwd'  => 'yestehotel400.+-',
			                          )),
		);
		$res = $this->pms->sub_to_web($this->pms_set, 'HelloWorld', array(), 1);
		print_r($res);
	}

	public function testPay(){
		//add_web_bill
		$this->load->model('hotel/pms/Yasite_hotel_model', 'pms');
		$oid = 4912;
		$order = array(
			'orderid'  => '36146399638038519',
			'inter_id' => $this->inter_id,
			'price'    => 207
		);
		$trans_no = '201605231638013';
		$this->pms_set['hotel_web_id'] = 99999;
		print_r($this->pms->add_web_bill($oid, $order, $this->pms_set, $trans_no));

	}

	public function testFunT(){
		print_r($this->client->__getFunctions());
		print_r($this->client->__getTypes());

//		print_r($this->client->__getLastRequestHeaders());
//		print_r($this->client->__getLastResponseHeaders());
	}

	public function testObjSign(){
		$var = new stdClass();
		$var->useridd = 'abc';
		$var->password = 'demo';
		$arr = (array)$var;
		ksort($arr);
		echo http_build_query($arr);
	}*/

	public function priceCode(){
		$this->load->model('hotel/pms/Yasite_hotel_model', 'pms');
		$db = $this->pms->_shard_db();

		$price_list = $db->where(array('inter_id' => $this->inter_id))->from('hotel_price_info')->get()->result_array();

		$rooms_list = $db->where(array('inter_id' => $this->inter_id))->from('hotel_rooms')->get()->result_array();

		$db->where(array('inter_id' => $this->inter_id))->from('hotel_price_set')->delete();

		$params = array();
		foreach($rooms_list as $v){
			foreach($price_list as $t){
				$params[] = array(
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $t['price_code'],
					'edittime'   => time(),
					'status'     => 1,
				);
			}
		}

		$db->set_insert_batch($params)->insert_batch('hotel_price_set');

		$db->where(array(
			           'inter_id'   => $this->inter_id,
			           'price_code' => 1
		           ))->set(array('status' => 2))->update('hotel_price_set');
	}

	public function lowestPrice(){
		set_time_limit(0);
		$this->load->model('hotel/pms/Yasite_hotel_model', 'pms');
		$db = $this->pms->_shard_db();

		$hotels = $db->where(array('pms_type' => 'yasite'))->from('hotel_additions')->get()->result_array();
		$data = array();
		$fail = array();
		$db->where(array('inter_id' => $this->inter_id))->from('hotel_lowest_price')->delete();
		foreach($hotels as $v){
			try{
				$info = $this->getStatusByHotelId($v['hotel_web_id']);
				$min = NULL;
				foreach($info as $t){
					foreach($t as $tmp){
						$pz = array_shift($tmp['DailyPrice']);
						$min = $min !== NULL ? min($min, $pz['RoomRate']) : $pz['RoomRate'];
					}
				}
				$min = intval($min * 0.9);
				$data[] = array(
					'hotel_id'     => $v['hotel_id'],
					'inter_id'     => $v['inter_id'],
					'lowest_price' => $min,
					'update_time'  => date('Y-m-d H:i:s'),
				);
			} catch(Exception $e){
				$fail[] = $v;
				continue;
			}

		}
//		file_put_contents(FD_PUBLIC . '/fail.json', json_encode($fail));

		$db->set_insert_batch($data)->insert_batch('hotel_lowest_price');
		echo 'success';
	}

	public function img_test(){
		foreach($this->hotel_list as $v){
			if($v['hotel_id'] = 1232){
				$res = $this->client->__soapCall('GetHotelsImages', array('parameters' => array('HotelID' => $v['hotel_web_id'])))->GetHotelsImagesResult;
				$res = json_decode($res, TRUE);
				$img = $this->GrabImage($res[0]['AbsolutePath'], 'yasite');
				print_r($res);
				break;
			}
		}
	}


	public function images(){
		if(!file_exists(FCPATH . FD_PUBLIC . '/yasite_intro_image.json')){
			$list = array();
			set_time_limit(0);
			$intro_images = array();
			foreach($this->hotel_list as $v){
				$res = $this->client->__soapCall('GetHotelsImages', array('parameters' => array('HotelID' => $v['hotel_web_id'])))->GetHotelsImagesResult;
				$res = json_decode($res, TRUE);
				if(!empty($res) && is_array($res)){
					$a = $res;
					$a = current($a);
					$intro_images[] = array(
						'hotel_id'    => $v['hotel_id'],
						'intro_img'   => $this->GrabImage($a['AbsolutePath'], 'yasite'),
						'web_img_url' => $a['AbsolutePath'],
					);
					foreach($res as $t){
						if(!empty($t['AbsolutePath'])){
							$img = $this->GrabImage($t['AbsolutePath'], 'yasite');
							if($img){
								$list[] = array(
									'inter_id'    => $this->inter_id,
									'hotel_id'    => $v['hotel_id'],
									'room_id'     => 0,
									'image_url'   => $img,
									'info'        => $t['Summary'],
									'type'        => 'hotel_lightbox',
									'sort'        => 0,
									'web_img_url' => $t['AbsolutePath'],
								);
							}

						}
					}
				}
			}
			file_put_contents(FCPATH . FD_PUBLIC . '/yasite_image.json', json_encode($list));
			file_put_contents(FCPATH . FD_PUBLIC . '/yasite_intro_image.json', json_encode($intro_images));

		} else{
			$list = file_get_contents(FCPATH . FD_PUBLIC . '/yasite_image.json');
//			$list = json_decode($list, TRUE);
		}

		print_r($list);

		return $list;
	}

	public function catchimages(){
		$list = file_get_contents(FCPATH . FD_PUBLIC . '/yasite_image.json');
		$list = json_decode($list, TRUE);
		$this->load->model('hotel/pms/Yasite_hotel_model', 'pms');
		foreach($list as &$v){
			$v['image_url']=$v['web_img_url'];
			unset($v['web_img_url']);
		}
		$db = $this->pms->_shard_db();
		$db->set_insert_batch($list)->insert_batch('hotel_images_copy');
		echo 'success';

		$list = file_get_contents(FCPATH . FD_PUBLIC . '/yasite_intro_image.json');
		$list = json_decode($list, TRUE);
		$sql = '';
		foreach($list as $v){
			$sql .= "update iwide_hotels set intro_img = '" . $v['web_img_url'] . "' where hotel_id = '" . (int)$v['hotel_id'] . "';" . "\n";
		}
		if($sql){
			file_put_contents(FD_PUBLIC . '/yasite_upd.sql', $sql);
		}
		echo 'success';

	}


	public function GrabImage($url, $local_path, $filename = ""){
//		return $url;
		if($url == ""){
			return FALSE;
		}


		$path = FD_PUBLIC . '/' . $local_path . '/' . date('Ym') . '/';
		$wpat = FD_PUBLIC . '/uploads/' . date('Ym') . '/';

		if(!is_dir(FCPATH . $path)){
			mkdir(FCPATH . $path, 0777, TRUE);
		}


		$ext = strrchr($url, ".");
		if($filename == ""){
			list($usec, $sec) = explode(' ', microtime());
			$usec = intval($usec * 1000);
			$fn = date('YmdHis') . $usec;
			$filename = $path . $fn;
			$wfile = $wpat . $fn;
		} else{
			$wfile = $filename;
		}

		$filename .= $ext;
		$wfile .= $ext;
		if(file_exists(FCPATH . $filename)){
			return $this->GrabImage($url, $local_path);
		}

		ob_start();
		readfile($url);
		$img = ob_get_contents();
		ob_end_clean();
		$size = strlen($img);
		if($size > 0){
			/*$fp2 = @fopen(FCPATH . $filename, "a");
			fwrite($fp2, $img);
			fclose($fp2);*/
			file_put_contents(FCPATH . $filename, $img);
			return 'http://file.iwide.cn/' . $wfile;
		}
		return FALSE;
	}


}