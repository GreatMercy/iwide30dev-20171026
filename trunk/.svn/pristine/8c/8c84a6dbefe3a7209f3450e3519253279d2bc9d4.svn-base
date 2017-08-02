<?php

class TestLvyun extends MY_Controller{
	private $url = 'http://pms.eaka365.net:8102/ipmsgroup/CRS';
	private $pms_auth = [
		'salesChannel' => 'WEB',
		'hotelGroupId' => 2,
		'url'          => 'http://pms.eaka365.net:8102/ipmsgroup/CRS',
		'member_url'   => 'http://pms.eaka365.net:8102/ipmsgroup/',
		'src'          => 'YM',
		'market'       => 'FIT',
		'taCode'       => 9330,
	];

	/*{"salesChannel":"WEB","hotelGroupId":2,"url":"http://pms.eaka365.net:8102/ipmsgroup/CRS","member_url":"http://pms.eaka365.net:8102/ipmsgroup/","src":"YM","market":"FIT","taCode":9330}*/

	private $inter_id = 'a445223616';

	public function hotels(){
		set_time_limit(900);
		$url = $this->url . '/queryHotelList';
		$list=$this->db->from('hotels h')->select('h.name,ha.hotel_web_id,h.hotel_id')->join('hotel_additions ha','ha.hotel_id=h.hotel_id','inner')->where(['h.inter_id'=>$this->inter_id,'ha.pms_type'=>'lvyun'])->get()->result_array();
		$hotels=[];
		foreach($list as $v){
			$hotels[$v['hotel_web_id']]=$v;
		}
		$id_arr=array_keys($hotels);
		$data = [
			'date'         => date('Y-m-d'),
			'dayCount'     => 1,
			'cityCode'     => '',
			'brandCode'    => '',
			'order'        => '1',
			//			'firstResult' => 0,
			'pageSize'     => 200,
			//			'rateCodes' => '',
			'salesChannel' => 'WEB',
			'hotelIds'     => implode(',',$id_arr),
			/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
			'hotelGroupId' => 2
		];

		$json = $this->doCurlGetRequest($url, $data,900);
		$result = json_decode($json, true);

		$list= [];

		foreach($result['hrList'] as $v){
		/*	if(!empty($v['roomList'])){
				$exists[]=$hotels[$v['hotelId']]['hotel_id'].'=>'.$hotels[$v['hotelId']]['name'];
			}else{
				$noexists[]=$hotels[$v['hotelId']]['hotel_id'].'=>'.$hotels[$v['hotelId']]['name'];
			}*/
//			$v['name'] = '云盟酒店测试Lvyun';
			$list[] = $v;
		}
		echo json_encode($list);exit;
		echo json_encode([
			'exists'=>$exists,
		    'none'=>$noexists,
		                 ]);
		exit;
		return $hotels;
	}

	function doCurlGetRequest($url, $data = array(), $timeout = 10){
		if($url == "" || $timeout <= 0){
			return false;
		}
		if($data != array()){
			$url = $url . '?' . http_build_query($data);
		}
		$con = curl_init(( string )$url);
		curl_setopt($con, CURLOPT_HEADER, false);
		curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($con, CURLOPT_TIMEOUT, ( int )$timeout);
		curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false);

		return curl_exec($con);
	}


	public function catches(){
		$hotels = $this->hotels();
		$pms_auth = $this->pms_auth;
		$additions = [];
		$rooms = [];
		$lowest = [];
		foreach($hotels as $v){
			/*if(!empty($v['roomList'])){
				$fr = current($v['roomList']);
				$pms_auth['src'] = $fr['src'];
			}*/

			$data = [
				'name'     => $v['name'],
				'inter_id' => $this->inter_id,
			];
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_auth'           => json_encode($pms_auth),
				'hotel_web_id'       => $v['hotelId'],
				'pms_room_state_way' => 1,
				'pms_member_way'     => 1,
				'pms_type'           => 'lvyun',
			];

			if(!empty($v['rmtypes'])){
				foreach($v['rmtypes'] as $t){
					$rooms[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['descript'],
						'description' => '',
						'sub_des'     => '',
						'nums'        => 0,
						'bed_num'     => 0,
						//						'sort'        => $t['Sort'],
						'webser_id'   => $t['code'],
					];
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
				$lowest[] = [
					'hotel_id'     => $hotel_id,
					'inter_id'     => $this->inter_id,
					'lowest_price' => $min_price,
					'update_time'  => date('Y-m-d H:i:s'),
				];
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

	public function new_pms_data(){
		set_time_limit(900);
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/zhuzhe2lvyun.xlsx"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
//		$highestColumm = $sheet->getHighestColumn(); // 取得总列数
//		$highestColumm = PHPExcel_Cell::columnIndexFromString($highestColumm); //字母列转换为数字列 如:AA变为27
		$merge=[];
		$new=[];
		for($row = 2; $row <= $highestRow; $row++){
			if($sheet->getCell('C' . $row)->getValue()!=''){
				$merge[$sheet->getCell('C' . $row)->getValue()]=[
					'hotel_web_id'=>$sheet->getCell('E' . $row)->getValue(),
					'name'=>$sheet->getCell('B' . $row)->getValue(),
				];
			}else{
				$new[$sheet->getCell('E' . $row)->getValue()]=$sheet->getCell('B' . $row)->getValue();
			}
			/*$merge[$sheet->getCell('D' . $row)->getValue()]=[
				'hotel_web_id'=>$sheet->getCell('A' . $row)->getValue(),
				'name'=>$sheet->getCell('C' . $row)->getValue(),
			];*/
		}

//		echo json_encode($merge);exit;

//		$list=$this->db->from('hotel_additions')->where(['inter_id'=>$this->inter_id,'hotel_id>'=>0])->get()->result_array();
		$json=file_get_contents(FD_PUBLIC.'/tmp_data/zhuzhe_hotels.json');
		$list=json_decode($json,true);
		foreach($list as $v){
			if(isset($merge[$v['hotel_id']])){
				$updata = [
					'pms_auth'     => json_encode($this->pms_auth),
					'pms_type'     => 'lvyun',
					'hotel_web_id' => $merge[$v['hotel_id']]['hotel_web_id'],
				];
				$this->db->update('hotel_additions',$updata, ['hotel_id' => $v['hotel_id'], 'inter_id' => $v['inter_id']]);
			} else{//已经解约酒店，
				$this->db->update('hotels', ['status' => 0], ['hotel_id' => $v['hotel_id'], 'inter_id' => $v['inter_id']]);
			}
		}
		//新增的
		/*$condition=[];
		foreach($list as $v){
			$condition[$v['hotel_web_id']]=$v;
		}
		$new=[];
		foreach($merge as $k=>$v){
			if(!isset($condition[$k])){
				$new[$v['hotel_web_id']]=$v['name'];
			}
		}*/
//		echo json_encode($new);exit;
		if($new){
			$hotelids=array_keys($new);
			$url = $this->url . '/queryHotelList';
			$data = [
				'date'         => date('Y-m-d'),
				'dayCount'     => 1,
				'cityCode'     => '',
				'brandCode'    => '',
				'order'        => '1',
				//			'firstResult' => 0,
				'pageSize'     => 10,
				//			'rateCodes' => '',
				'salesChannel' => 'CRS',
				'hotelIds'     => implode(',',$hotelids),
				/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
				'hotelGroupId' => 2
			];

			$this->load->helper('common');

			$json = doCurlGetRequest($url, $data);
			$pms_auth=$this->pms_auth;

			$result=json_decode($json,true);
			foreach($result['hrList'] as $v){
				/*if(!empty($v['roomList'])){
					$fr = current($v['roomList']);
					$pms_auth['src'] = $fr['src'];
				}*/

				$data = [
					'name'     => $new[$v['hotelId']],
					'inter_id' => $this->inter_id,
				];
				$this->db->insert('hotels', $data);
				$hotel_id = $this->db->insert_id();
				$additions[] = [
					'hotel_id'           => $hotel_id,
					'inter_id'           => $this->inter_id,
					'pms_auth'           => json_encode($pms_auth),
					'hotel_web_id'       => $v['hotelId'],
					'pms_room_state_way' => 3,
					'pms_member_way'     => 1,
					'pms_type'           => 'lvyun',
				];

				if(!empty($v['rmtypes'])){
					foreach($v['rmtypes'] as $t){
						$rooms[] = [
							'hotel_id'    => $hotel_id,
							'inter_id'    => $this->inter_id,
							'name'        => $t['descript'],
							'description' => '',
							'sub_des'     => '',
							'nums'        => 0,
							'bed_num'     => 0,
							//						'sort'        => $t['Sort'],
							'webser_id'   => $t['code'],
						];
					}
				}

				$min_price = 0;
				if(!empty($v['roomList'])){
					foreach($v['roomList'] as $t){
						if($t['ratecode'] == 'RAC'){
							if($min_price > 0){
								$min_price = min($min_price, $t['rate1']);
							} else{
								$min_price = $t['rate1'];
							}
						}

					}
				}

				if($min_price > 0){
					$lowest[] = [
						'hotel_id'     => $hotel_id,
						'inter_id'     => $this->inter_id,
						'lowest_price' => $min_price,
						'update_time'  => date('Y-m-d H:i:s'),
					];
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
			/*echo json_encode([
				$additions,
			    $rooms,
			    $lowest
			                 ]);exit;*/
		}
		echo 'success';
	}

	public function new_pms_rooms_data(){
		set_time_limit(900);
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/zhuzhe2lvyun_rooms.xlsx"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
//		$highestColumm = $sheet->getHighestColumn(); // 取得总列数
//		$highestColumm = PHPExcel_Cell::columnIndexFromString($highestColumm); //字母列转换为数字列 如:AA变为27
		$merge=[];
		$new=[];
		for($row = 2; $row <= $highestRow; $row++){
			if($sheet->getCell('C' . $row)->getValue()!=''){
				$merge[$sheet->getCell('C' . $row)->getValue()]=[
					'webser_id'=>$sheet->getCell('E' . $row)->getValue(),
					'name'=>$sheet->getCell('B' . $row)->getValue(),
				];
			}else{
				$new[]=[
					'name'=>$sheet->getCell('B' . $row)->getValue(),
				    'hotel_id'=>$sheet->getCell('A' . $row)->getValue(),
				    'webser_id'=>$sheet->getCell('E' . $row)->getValue(),
				];

			}
			/*$merge[$sheet->getCell('D' . $row)->getValue()]=[
				'hotel_web_id'=>$sheet->getCell('A' . $row)->getValue(),
				'name'=>$sheet->getCell('C' . $row)->getValue(),
			];*/
		}

//		echo json_encode($merge);exit;

		$json=file_get_contents(FD_PUBLIC.'/tmp_data/zhuzhe_rooms.json');
		$list=json_decode($json,true);
		foreach($list as $v){
			if(isset($merge[$v['room_id']])){
				$r=$merge[$v['room_id']];
				if($r['webser_id']){
					$this->db->update('hotel_rooms',['webser_id'=>$r['webser_id'],'name'=>$r['name']],['room_id'=>$v['room_id']]);
				}else{
					$this->db->update('hotel_rooms',['status'=>0],['room_id'=>$v['room_id']]);
				}
			}else{
				$this->db->update('hotel_rooms',['status'=>0],['room_id'=>$v['room_id']]);
			}
		}

		//新房型
		if($new){
			$room_params=[];
			foreach($new as $v){
				$room_params[] = [
					'hotel_id'    => $v['hotel_id'],
					'inter_id'    => $this->inter_id,
					'name'        => $v['name'],
					'description' => $v['name'],
					'sub_des'     => '',
					'nums'        => 0,
					//						'bed_num'     => $t['BedCount'],
//					'sort'        => $t['seqId'],
					'webser_id'   => $v['webser_id'],
					'status'      => 1
				];
			}
			if($room_params){
				$this->db->insert_batch('hotel_rooms',$room_params);
			}
		}
		echo 'success';
	}

	public function price_set(){
		$rooms=$this->db->from('hotel_rooms')->where(['inter_id'=>$this->inter_id])->get()->result_array();
		$params=[];
		for($i=1;$i<=21;$i++){
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
		}

		$this->db->insert_batch('hotel_price_set',$params);
		echo 'success';
	}

	public function fixpmsauth(){
		$db=$this->load->database('default',true);

		$db->update('hotel_additions_copy',['pms_auth'=>json_encode($this->pms_auth)],['inter_id'=>$this->inter_id,'pms_type'=>'lvyun']);
		echo 'success';
		exit;
		$list=$this->db->from('hotel_additions')->where(['inter_id'=>$this->inter_id,'pms_type'=>'lvyun'])->get()->result_array();
		foreach($list as $v){
			$update=[
				'pms_auth'=>json_encode($this->pms_auth)
			];
		}
	}

	public function merge_new_pms(){
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/zhuzhe2lvyun.xlsx"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数

		$merge=[];
		for($row = 2; $row <= $highestRow; $row++){
			if($sheet->getCell('C' . $row)->getValue()!=''){
				$merge[$sheet->getCell('C' . $row)->getValue()]=[
					'hotel_web_id'=>$sheet->getCell('E' . $row)->getValue(),
					'name'=>$sheet->getCell('B' . $row)->getValue(),
				];
			}
		}

		if($merge){
			$json=file_get_contents(FD_PUBLIC.'/tmp_data/zhuzhe_hotels.json');
			$list=json_decode($json,true);
//			$list=$this->db->from('hotel_additions')->where(['inter_id'=>$this->inter_id,'hotel_id>'=>0])->get()->result_array();
			$sql="";
			$un_sql="";
			foreach($list as $v){
				if(isset($merge[$v['hotel_id']])){
					$sql.="update iwide_hotel_additions set pms_auth = '".json_encode($this->pms_auth)."',pms_type='lvyun',hotel_web_id='".$merge[$v['hotel_id']]['hotel_web_id']."' where hotel_id = '".$v['hotel_id']."' and inter_id='".$v['inter_id']."';"."\n";
				} else{//已经解约酒店，
					$un_sql.="update iwide_hotels set status = 0 where hotel_id = '".$v['hotel_id']."' and inter_id = '".$v['inter_id']."';"."\n";
				}
			}
			echo $sql."\n\n".$un_sql;
		}
	}

	public function check_pms_data(){
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/zhuzhe2lvyun.xlsx"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数

		$merge=[];
		for($row = 2; $row <= $highestRow; $row++){
			if($sheet->getCell('C' . $row)->getValue()!=''){
				$merge[$sheet->getCell('E' . $row)->getValue()]=[
					'hotel_web_id'=>$sheet->getCell('E' . $row)->getValue(),
					'name'=>$sheet->getCell('B' . $row)->getValue(),
					'hotel_id'=>$sheet->getCell('C' . $row)->getValue(),
				];
			}
		}

		$ids=array_keys($merge);
		$data = [
			'date'         => date('Y-m-d'),
			'dayCount'     => 1,
			'cityCode'     => '',
			'brandCode'    => '',
			'order'        => '1',
			//			'firstResult' => 0,
			'pageSize'     => 200,
			//			'rateCodes' => '',
			'salesChannel' => 'WEB',
//			'hotelIds'     => implode(',',$ids),
		    'hotelIds'=>'208',
			/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
			'hotelGroupId' => 2
		];

		$url = $this->url . '/queryHotelList';

		$json = $this->doCurlGetRequest($url, $data,900);
		exit($json);
		$list=json_decode($json,true);
		$empty=[];
		foreach($list['hrList'] as $v){
			if(empty($v['roomList'])){
				$empty[]=$merge[$v['hotelId']];
			}
		}
		echo json_encode($empty);
	}

	public function merge_new_room_pms(){
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/zhuzhe2lvyun_rooms.xlsx"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数

		$merge=[];
		for($row = 2; $row <= $highestRow; $row++){
			if($sheet->getCell('C' . $row)->getValue()!=''){
				$merge[$sheet->getCell('C' . $row)->getValue()]=[
					'webser_id'=>$sheet->getCell('E' . $row)->getValue(),
					'name'=>$sheet->getCell('B' . $row)->getValue(),
				];
			}
		}

		if($merge){
			$json=file_get_contents(FD_PUBLIC.'/tmp_data/zhuzhe_rooms.json');
			$list=json_decode($json,true);
			$sql="";
			$un_sql="";
			foreach($list as $v){
				if(isset($merge[$v['room_id']])){
					$r=$merge[$v['room_id']];
					if($r['webser_id']!=''){
						$sql .= "update iwide_hotel_rooms set webser_id = '" . $r['webser_id'] . "' where room_id = '" . $v['room_id'] . "' and inter_id='" . $v['inter_id'] . "';" . "\n";
					}else{
						$sql.="update iwide_hotel_rooms set `status` = 0 where room_id = '".$v['room_id']."' and inter_id='".$v['inter_id']."';"."\n";
					}
				} else{//没有新的房型ID，
					$sql.="update iwide_hotel_rooms set `status` = 0 where room_id = '".$v['room_id']."' and inter_id='".$v['inter_id']."';"."\n";
				}
			}
			echo $sql."\n\n".$un_sql;
		}
	}

	public function new_hotels(){
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/zhuzhe2lvyun.xlsx"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
//		$highestColumm = $sheet->getHighestColumn(); // 取得总列数
//		$highestColumm = PHPExcel_Cell::columnIndexFromString($highestColumm); //字母列转换为数字列 如:AA变为27
		$new=[];
		for($row = 2; $row <= $highestRow; $row++){
			if($sheet->getCell('C' . $row)->getValue()==''){
				$new[$sheet->getCell('E' . $row)->getValue()]=$sheet->getCell('B' . $row)->getValue();
			}
		}

		$db=$this->load->database('default',true);

		if($new){
			$hotelids=array_keys($new);
			$url = $this->url . '/queryHotelList';
			$data = [
				'date'         => date('Y-m-d'),
				'dayCount'     => 1,
				'cityCode'     => '',
				'brandCode'    => '',
				'order'        => '1',
				//			'firstResult' => 0,
				'pageSize'     => 10,
				//			'rateCodes' => '',
				'salesChannel' => 'CRS',
				'hotelIds'     => implode(',',$hotelids),
				/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
				'hotelGroupId' => 2
			];

			$this->load->helper('common');

			$json = doCurlGetRequest($url, $data);
			$pms_auth=$this->pms_auth;

			$result=json_decode($json,true);
			foreach($result['hrList'] as $v){
				if(!empty($v['roomList'])){
					$fr = current($v['roomList']);
					$pms_auth['src'] = $fr['src'];
				}

				$data = [
					'name'     => $new[$v['hotelId']],
					'inter_id' => $this->inter_id,
				];
				$db->insert('hotels_copy', $data);
				$hotel_id = $db->insert_id();
				$additions[] = [
					'hotel_id'           => $hotel_id,
					'inter_id'           => $this->inter_id,
					'pms_auth'           => json_encode($pms_auth),
					'hotel_web_id'       => $v['hotelId'],
					'pms_room_state_way' => 3,
					'pms_member_way'     => 1,
					'pms_type'           => 'lvyun',
				];

				if(!empty($v['rmtypes'])){
					foreach($v['rmtypes'] as $t){
						$rooms[] = [
							'hotel_id'    => $hotel_id,
							'inter_id'    => $this->inter_id,
							'name'        => $t['descript'],
							'description' => '',
							'sub_des'     => '',
							'nums'        => 0,
							'bed_num'     => 0,
							//						'sort'        => $t['Sort'],
							'webser_id'   => $t['code'],
						];
					}
				}

				$min_price = 0;
				if(!empty($v['roomList'])){
					foreach($v['roomList'] as $t){
						if($t['ratecode'] == 'RAC'){
							if($min_price > 0){
								$min_price = min($min_price, $t['rate1']);
							} else{
								$min_price = $t['rate1'];
							}
						}

					}
				}

				if($min_price > 0){
					$lowest[] = [
						'hotel_id'     => $hotel_id,
						'inter_id'     => $this->inter_id,
						'lowest_price' => $min_price,
						'update_time'  => date('Y-m-d H:i:s'),
					];
				}
			}

			if($additions){
				$db->insert_batch('hotel_additions_copy', $additions);
			}
			if($rooms){
				$db->insert_batch('hotel_rooms_copy', $rooms);
			}
			if($lowest){
				$db->insert_batch('hotel_lowest_price_copy', $lowest);
			}
			/*echo json_encode([
				$additions,
			    $rooms,
			    $lowest
			                 ]);exit;*/
		}
		echo 'success';
	}

	public function new_rooms(){
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/tmp_data/zhuzhe2lvyun_rooms.xlsx"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数

		$new=[];
		for($row = 2; $row <= $highestRow; $row++){
			if($sheet->getCell('C' . $row)->getValue()==''){
				$new[]=[
					'name'=>$sheet->getCell('B' . $row)->getValue(),
					'hotel_id'=>$sheet->getCell('A' . $row)->getValue(),
					'webser_id'=>$sheet->getCell('E' . $row)->getValue(),
				];

			}
		}

		if($new){
			$room_params=[];
			foreach($new as $v){
				$room_params[] = [
					'hotel_id'    => $v['hotel_id'],
					'inter_id'    => $this->inter_id,
					'name'        => $v['name'],
					'description' => $v['name'],
					'sub_des'     => '',
					'nums'        => 0,
					//						'bed_num'     => $t['BedCount'],
					//					'sort'        => $t['seqId'],
					'webser_id'   => $v['webser_id'],
					'status'      => 1
				];
			}
			if($room_params){
				$db=$this->load->database('default',true);
				$db->insert_batch('hotel_rooms_copy',$room_params);
				echo 'success';
			}
		}

	}

	public function disabledother(){

		$json=file_get_contents(FD_PUBLIC.'/tmp_data/zhuzhe_hotels.json');
		$list=json_decode($json,true);
		$id_list=[];
		foreach($list as $v){
			$id_list[]=$v['hotel_id'];
		}
		$this->db->where(['inter_id'=>$this->inter_id])->where_not_in('hotel_id',$id_list)->update('hotels',['status'=>0]);
	}

	public function checkorder($web_orderid){
		$url = $this->url . '/findResrvGuest';
		$data = array (
			"cardNo" => "",
			"crsNo" => $web_orderid,
			"hotelGroupId" => $this->pms_auth['hotelGroupId']
		);
		$this->load->helper ( 'common' );
		$send_content = http_build_query ( $data );
		$s = doCurlPostRequest ( $url, $send_content );

		echo $s;
	}
}