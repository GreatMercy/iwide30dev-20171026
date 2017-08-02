<?php

class Yage2 extends MY_Controller{
//	private $inter_id = 'a465195239';    //开发
	private $inter_id='a486201893';//测试
	private $url = 'http://182.92.222.169:9601/CRS.asmx';
	private $user = 'CRS';
	private $pwd = '1';
	private $group_code = 'ARGYLE';
	
	private $pms_auth;
	
	public function __construct(){
		parent::__construct();
		
		$this->pms_auth = [
			'url'             => $this->url,
			'user'            => $this->user,
			'pwd'             => $this->pwd,
			'group'           => $this->group_code,
			'lang'            => 'CN',
			'resv_type'       => [
				'normal' => 'PR', //现付订单状态
				'paid'   => 'PP', //微信支付订单状态
				'nopay'  => 'NOG', //预付订单状态
			],
			'origin_code'     => 'WX',
			'discount_reason' => 'DOT',
		    'source'=>'微信',
		];

		echo json_encode($this->pms_auth,JSON_UNESCAPED_UNICODE);exit;
		$this->load->helper('common');
		
		$this->load->model('hotel/pms/Argyle_hotel_model', 'pms');
		$this->serv_api = new Argyle_api();
		$pms_auth = $this->pms_auth;
		$pms_auth['inter_id'] = $this->inter_id;
		$this->serv_api->setPmsAuth($pms_auth);
	}
	
	public function fixpmsauth(){
		$this->db->where(['inter_id' => $this->inter_id])->update('hotel_additions', ['pms_auth' => json_encode($this->pms_auth)]);
	}
	
	public function get_hotels(){
		$url = $this->url . '/crs1GetPropertyInfoListJson';
		$params = [
			'CityCode'      => '',
			'ArrivalDate'   => '',
			'DepartureDate' => '',
			'Rooms'         => '',
			'Persons'       => '',
		];
		$res = $this->serv_api->httpPost($url, $params);
		if($res['success'] && !empty($res['data'])){
			$hotels = $res['data'];
			$room_params = $params;
			$rurl = $this->url . '/crsIfcRoomTypeDetailJson';
			foreach($hotels as &$v){
				$room_params['rule'] = '';
				$room_params['roomType'] = '';
				$room_params['Hotel'] = $v['code'];
				$res = $this->serv_api->httpPost($rurl, $room_params);
				if($res['success'] && !empty($res['data'])){
					$rooms = $res['data'];
					$v['rooms'] = [];
					foreach($rooms as $t){
						if(!array_key_exists('Code', $t)){
							continue;
						}
						$temp = explode('.', $t['Description']);
						$t['Name'] = end($temp);
						$v['rooms'][] = $t;
					}
				}else{
					$v['rooms'] = [];
				}
			}
			file_put_contents(FD_PUBLIC . '/yage_hotels_pms.json', json_encode($hotels));
			echo json_encode($hotels);
		}
	}

	public function getrooms(){
		$url=$this->url.'/crsIfcRoomTypeDetailJson';
		$params = [
			'CityCode'      => '',
			'ArrivalDate'   => '',
			'DepartureDate' => '',
			'Rooms'         => '',
			'Persons'       => '',
			'rule'=>'',
			'roomType'=>'',
			'Hotel'=>'龙凤祥雅阁酒店'
		];
		$res = $this->serv_api->httpPost($url, $params);
		exit(json_encode($res));
	}
	
	public function catches(){
		$json = file_get_contents(FD_PUBLIC . '/yage_hotels_pms.json');
//		exit($json);
		$hotels = json_decode($json, true);
		$additions = [];
		$rooms = [];
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
				'name'        => $v['Name'],
				'address'     => $v['Address'],
				'tel'         => $v['Telephone'],
				'intro'       => $v['Name'],
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
					'pms_type'           => 'argyle',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'argyle',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['code'],
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
			
			if(!empty($v['rooms'])){
				foreach($v['rooms'] as $t){
					$rooms[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['Name'],
						'description' => $t['Description'],
						'webser_id'   => $t['Code'],
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
	
	public function priceset(){
		$rooms = $this->db->from('hotel_rooms')->where(['inter_id' => $this->inter_id])->get()->result_array();
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

	public function merge_pmsid(){
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/argyle_hotels.xls"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		//		$highestColumm = $sheet->getHighestColumn(); // 取得总列数
		//		$highestColumm = PHPExcel_Cell::columnIndexFromString($highestColumm); //字母列转换为数字列 如:AA变为27

		$json=file_get_contents(FD_PUBLIC.'/tmp_data/argyle_hotels.json');
		$hotels=json_decode($json,true);
		$list=[];
		foreach($hotels as $v){
			$list[$v['hotel_id']]=$v;
		}
		$exists=[];
		$none=[];
		for($row = 2; $row <= $highestRow; $row++){
			if($sheet->getCell('A' . $row)->getValue()!=''){
				if($sheet->getCell('C' . $row)->getValue() != '' && isset($list[$sheet->getCell('A' . $row)->getValue()])){
					$exists[$sheet->getCell('A' . $row)->getValue()] = [
						'hotel_web_id' => $sheet->getCell('C' . $row)->getValue(),
						'inter_id' => $list[$sheet->getCell('A' . $row)->getValue()]['inter_id'],
					];
				}else{
					$none[] = $sheet->getCell('A' . $row)->getValue();
				}
			}
		}

		$additions=[];
		foreach($exists as $k=>$v){
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $v['inter_id'],
					'pms_type'           => 'argyle',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[]=[
				'hotel_id'           => $k,
				'inter_id'           => $v['inter_id'],
				'pms_type'           => 'argyle',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['hotel_web_id'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
		}

		$sql="update iwide_hotels set `status` = 2 where hotel_id in (".implode(',',$none).")";
		/*foreach($additions as $v){
			$sql.=$this->db->insert_string('hotel_additions',$v).";\n";
		}*/
		echo $sql;

	}
}