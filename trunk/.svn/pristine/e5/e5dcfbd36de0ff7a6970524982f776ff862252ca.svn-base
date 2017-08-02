<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Qingmu extends MY_Controller{
	/*protected function getOpenId(){
		return $this->openid;
	}*/

	private $inter_id = 'a467894987';//测试

	private static function abc(){
		$abc='abc';


}
//	private $inter_id = 'a464919542'; //正式

//	private $inter_id = 'a445223616';      //云盟


	public function fipmsauth(){
		$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
		$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';
		$PmsInfo = array(
			"wsdl"     => $wsdl,
			"location" => $location,
			"key"      => 'key',
			"AppKey"   => 'key'
		);
		$this->db->update('hotel_additions', array('pms_auth' => json_encode($PmsInfo)), array('pms_type' => 'beyondh'));
	}


	public function catchAllHotel(){    //拉取酒店基本信息

		set_time_limit(0);

		$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
		$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';


		$soap = new SoapClient($wsdl, array(
			'location'     => $location,
			'soap_version' => SOAP_1_1,
			'encoding'     => 'utf-8'
		));


		$unixExpireTimestamp = time() + 86400;


		$paras = array('pageIndex' => 1, 'pageSize' => 1000);
		$signature = $this->beyondh_sign($paras, $unixExpireTimestamp, 'JFK', 'JFK');
		$paras['unixExpireTimestamp'] = $unixExpireTimestamp;
		$paras['signature'] = $signature;
		$hotel = $soap->__soapCall("GetAllHotels", array("parameters" => $paras));
		foreach($hotel->GetAllHotelsResult->Content->HotelSearchResponse as $d){
			$d->HotelId = number_format($d->HotelId, 0, '', '');
		}

		$hotel = $hotel->GetAllHotelsResult->Content->HotelSearchResponse;

		$PmsInfo = array(
			"wsdl"     => $wsdl,
			"location" => $location,
			"key"      => 'key',
			"AppKey"   => 'key'
		);

		$json_pms = json_encode($PmsInfo);

		$hotelInfo = array();

		$additions_result = $this->db->from('hotel_additions')->where(['inter_id' => $this->inter_id])->get()->result_array();
		$additions_arr = [];
		foreach($additions_result as $v){
			if($v['hotel_web_id']){
				$additions_arr[$v['hotel_web_id']] = $v;
			}
		}

		foreach($hotel as $new_hotel){

//			$result = $this->db->query("SELECT * FROM `iwide_hotels` WHERE inter_id= '$this->inter_id' AND address='{$new_hotel->Address}'")->row();


			if(!empty($result)){

				echo "已经接入" . $new_hotel->Name;
				echo "</br>";

			} else{

				$data = array(
					"name"      => $new_hotel->Name,
					"address"   => $new_hotel->Address,
					"latitude"  => $new_hotel->Latitude,
					"longitude" => $new_hotel->Longitude,
					"tel"       => $new_hotel->Phone,
					"intro"     => $new_hotel->Description,
					"inter_id"  => $this->inter_id
				);


//				$writeAdapter = $this->load->database('member_write', true);

//				$writeAdapter->insert("iwide_hotels", $data);
				$this->db->insert('hotels', $data);

				$hotel_id = $this->db->insert_id();
				if(empty($additions_arr[$new_hotel->HotelId])){
					$data_additional = array(
						"inter_id"     => $this->inter_id,
						"hotel_id"     => $hotel_id,
						"pms_type"     => 'beyondh',
						"pms_auth"     => $json_pms,
						"hotel_web_id" => $new_hotel->HotelId
					);
					$this->db->insert("hotel_additions", $data_additional);
				}else{
					$this->db->where(['hotel_web_id'=>$new_hotel->HotelId,'inter_id'=>$this->inter_id])->update('hotel_additions',['hotel_id'=>$hotel_id]);
				}
			}

		};

	}


	public function getRooms(){     //拉取酒店所有房型

		set_time_limit(0);

		$hotel_additions = $this->db->get_where('hotel_additions', array(
			'inter_id' => $this->inter_id,
			'pms_type' => 'beyondh'
		))->result();


		$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
		$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';

		$soap = new SoapClient($wsdl, array(
			'location'     => $location,
			'soap_version' => SOAP_1_1,
			'encoding'     => 'utf-8'
		));


		foreach($hotel_additions as $arr){

			$unixExpireTimestamp = time() + 86400;

			$paras = array('hotelId' => floatval($arr->hotel_web_id));
			$signature = $this->beyondh_sign($paras, $unixExpireTimestamp, 'wechat', 'wechat');
			$paras['unixExpireTimestamp'] = $unixExpireTimestamp;
			$paras['signature'] = $signature;
			$allRooms = $soap->__soapCall("GetHotelRoomTypes", array("parameters" => $paras))->GetHotelRoomTypesResult->Content->RoomType;


			foreach($allRooms as $rooms){

				$data = array(
					'inter_id'  => $this->inter_id,
					'hotel_id'  => $arr->hotel_id,
					'webser_id' => $rooms->Id,
					'name'      => $rooms->RoomTypeName
				);


				$result = $this->db->query("SELECT * FROM `iwide_hotel_rooms` WHERE inter_id='$this->inter_id' AND webser_id='{$rooms->Id}' AND hotel_id=$arr->hotel_id")->row();


				if(!empty($result)){

					echo "酒店" . $arr->hotel_id . "已经拉取过" . $rooms->RoomTypeName;
					echo "</br>";

				} else{
					$this->db->insert("hotel_rooms", $data);
				}


			}


		}

	}


	function getHotelImage(){            //拉取酒店相册，酒店服务

		if(!file_exists(FD_PUBLIC . '/qingmu_hotel_image.json')){
			/*$hl = array();
			foreach($this->hotel_list as $v){
				$hl[$v['hotel_web_id']] = $v['hotel_id'];
			}*/

			set_time_limit(0);

//			$disp_type = $this->check_hotel_config();

			$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
			$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';

			$soap = new SoapClient($wsdl, array(
				'location'     => $location,
				'soap_version' => SOAP_1_1,
				'encoding'     => 'utf-8'
			));


			$unixExpireTimestamp = time() + 86400;


			$paras = array('pageIndex' => 1, 'pageSize' => 1000);
			$signature = $this->beyondh_sign($paras, $unixExpireTimestamp, 'wechat', 'wechat');
			$paras['unixExpireTimestamp'] = $unixExpireTimestamp;
			$paras['signature'] = $signature;
			$hotel = $soap->__soapCall("GetAllHotels", array("parameters" => $paras));
			foreach($hotel->GetAllHotelsResult->Content->HotelSearchResponse as $d){
				$d->HotelId = number_format($d->HotelId, 0, '', '');
			}

			$hotel = $hotel->GetAllHotelsResult->Content->HotelSearchResponse;

//		print_r($hotel);exit;

			$service_icon = array(
				'WiFi'   => '&#xe8;',
				'吹风机'    => '&#xe4;',
				//            '电热水壶'=>'&#xe8;',
				//            '国内长途电话'=>'&#xe8;',
				//            '电梯'=>'&#xe8;',
				//            '中央空调'=>'&#xe8;',
				'停车场'    => '&#xe7;',
				//            '旅游票务'=>'&#xe8;',
				'24小时热水' => '&#xeb;',
				'餐饮'     => '&#xea;',
				//            'KTV'=>'&#xe8;',
				//            '会议室'=>'&#xe8;',
				//            '国际长途电话'=>'&#xe8;',
				//            '外币兑换'=>'&#xe8;',
				//            '洗衣'=>'&#xe8;',
				'中餐厅'    => '&#xea;',
			);

			$image_data = array();
			$hotel_img_list = array();
			foreach($hotel as $new_hotel){
				if(empty($new_hotel->HotelId)){
					continue;
				}
				/*$res = $this->getHotelInfoByWebId($new_hotel->HotelId);
				if(empty($res->hotel_id)){
					continue;
				}
				$hotel_id = $res->hotel_id;
				*/

//				$hotel_id = $hl[$new_hotel->HotelId];

				if(isset($new_hotel->ServiceTags->string)){
					$serviceIcon = $new_hotel->ServiceTags->string;
					foreach($serviceIcon as $arr){                  //插入酒店服务
						if(array_key_exists($arr, $service_icon)){
							$image_data[] = array(
								'hotel_web_id' => $new_hotel->HotelId,
								'inter_id'     => $this->inter_id,
								'type'         => 'hotel_service',
								'info'         => $arr,
								'disp_type'    => 0,
								'room_id'      => 0,
								'image_url'    => $service_icon[$arr]
							);
							/*$params[] = array(
								'inter_id'  => $this->inter_id,
								'hotel_id'  => $hotel_id,
								'info'      => $arr,
								'type'      => 'hotel_service',
								'disp_type' => 0,
								'image_url' => $service_icon[$arr]
							);*/

//						$writeAdapter->insert("iwide_hotel_images", $data);
						}
					}
				}
				if(!empty($new_hotel->ImageUris)){
					$hotel_images = explode('|', $new_hotel->ImageUris);
					if($hotel_images){
						$hotel_img = $this->GrabImage($hotel_images[0], 'qingmutest');
//						$hotel_img = $hotel_images[0];
						if($hotel_img){
							$hotel_img_list[] = array(
								'hotel_web_id' => $new_hotel->HotelId,
								'intro_img'    => $hotel_img
							);
						}
					}
					foreach($hotel_images as $arr_images){
						$images_url = $this->GrabImage($arr_images, 'qingmutest');
//						$images_url = $arr_images;
						if($images_url){
							$image_data[] = array(
								'hotel_web_id' => $new_hotel->HotelId,
								'inter_id'     => $this->inter_id,
								'type'         => 'hotel_lightbox',
								'room_id'      => 0,
								'info'         => $new_hotel->Name,
								'image_url'    => $images_url,
								'disp_type'    => 0,
								'web_url'      => $arr_images,
							);
						}
					}
				}

			}

			file_put_contents(FD_PUBLIC . '/qingmu_hotel_image.json', json_encode($image_data));
			file_put_contents(FD_PUBLIC . '/qingmu_hotel_intro_image.json', json_encode($hotel_img_list));
		} else{
			$image_data = file_get_contents(FD_PUBLIC . '/qingmu_hotel_image.json');
			$image_data = json_decode($image_data, true);
		}
		return $image_data;
	}

	public function fix_introimg(){
		$image_data = file_get_contents(FD_PUBLIC . '/qingmu_hotel_intro_image.json');
		$image_list = json_decode($image_data, true);
		$hotel_json = file_get_contents(FD_PUBLIC . '/qingmu_ha.json');
		$hl = json_decode($hotel_json, true);
		$hotels = array();
		foreach($hl as $v){
			$hotels[$v['hotel_web_id']] = $v['hotel_id'];
		}
		$sql = "";
		foreach($image_list as $v){
			if(isset($hotels[$v['hotel_web_id']]) && $v['intro_img'] != ''){
				$v['intro_img'] = trim($v['intro_img'], '/');
				$sql .= "update iwide_hotels set intro_img = '" . $v['intro_img'] . "' where hotel_id=" . (int)$hotels[$v['hotel_web_id']] . " and inter_id = '" . $this->inter_id . "';\n";
			}
		}
		/*$sql .= "delete iwide_hotel_images where inter_id = '" . $this->inter_id . "' `type` = 'hotel_lightbox'";

		$image_data = file_get_contents(FD_PUBLIC . '/qingmu_hotel_image.json');
		$image_list = json_decode($image_data, true);
		$params = array();
		foreach($image_list as $v){
			if(isset($hotels[$v['hotel_web_id']])&&$v['type']=='hotel_lightbox'){
				$v['hotel_id'] = $hotels[$v['hotel_web_id']];
				$v['inter_id'] = $this->inter_id;
				unset($v['hotel_web_id'], $v['web_url']);
				$params[] = $v;
			}
		}

		if($params){
			$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
			$db = $this->pms->_shard_db();
			$db->set_insert_batch($params)->insert_batch('hotel_images_copy');
		}*/

		echo $sql;
	}

	public function downimage(){
		set_time_limit(0);
		$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
		$db = $this->pms->_shard_db();
		$image_data = file_get_contents(FD_PUBLIC . '/qingmu_hotel_intro_image.json');
		$image_list = json_decode($image_data, true);
		$hotel = $db->from('hotel_additions')->where(array('inter_id' => $this->inter_id))->get()->result_array();
		$list = array();
		foreach($hotel as $v){
			$list[$v['hotel_web_id']] = $v['hotel_id'];
		}
		/*foreach($image_list as $v){
			if(isset($list[$v['hotel_web_id']])){
				$db->update('hotels', array('intro_img' => $v['intro_img']), array(
					'hotel_id' => $list[$v['hotel_web_id']],
					'inter_id' => $this->inter_id
				));
			}

		}*/

		//房型图片
		$image_data = file_get_contents(FD_PUBLIC . '/qingmu_hotel_image.json');
		$image_list = json_decode($image_data, true);
		$params = array();
		foreach($image_list as $v){
			if(isset($list[$v['hotel_web_id']])){
				$v['hotel_id'] = $list[$v['hotel_web_id']];
				unset($v['hotel_web_id'], $v['web_url']);
				$params[] = $v;
			}
		}
		if($params){
			$db->set_insert_batch($params)->insert_batch('hotel_images');
		}

		echo 'success';
	}


	public function catchimages(){
		$image_data = file_get_contents(FD_PUBLIC . '/qingmu_hotel_image.json');
		$image_list = json_decode($image_data, true);

		$hl = array();
		foreach($this->hotel_list as $v){
			$hl[$v['hotel_web_id']] = $v['hotel_id'];
		}

		foreach($image_list as &$v){
			if(isset($v['web_url'])){
				$v['image_url'] = $v['web_url'];
				unset($v['web_url']);
			}
		}
		if($image_list){

			$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
			$db = $this->pms->_shard_db();

			$db->where(array('inter_id' => $this->inter_id))->delete('iwide_hotel_images_copy');
			$db->set_insert_batch($image_list)->insert_batch('hotel_images_copy');
		}

		$list = file_get_contents(FD_PUBLIC . '/qingmu_hotel_intro_image.json');
		$list = json_decode($list, true);
		$sql = '';
		foreach($list as $v){
			$sql .= "update iwide_hotels set intro_img = '" . $v['intro_img'] . "' where hotel_id = '" . (int)$v['hotel_id'] . "';" . "\n";
		}
		if($sql){
			file_put_contents(FD_PUBLIC . '/qingmu_upd.sql', $sql);
		}
		echo 'success';
	}


	function get_room_change(){

		$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
		$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';

		$soap = new SoapClient($wsdl, array(
			'location'     => $location,
			'soap_version' => SOAP_1_1,
			'encoding'     => 'utf-8'
		));


		$unixExpireTimestamp = time() + 86400;

//            $paras=array('HallIds'=>'','FloorIds'=>'','RoomTypeIds'=>array('TR','BK'),'RoomAttributeIds'=>'','EstimatedArriveTime'=>strval('2016-06-05T12:00:00.000'),'EstimatedDepartureTime'=>strval('2016-06-07T12:00:00.000'),'HotelId'=>floatval('201096561885199'));
//            $signature=$this->beyondh_sign($paras,$unixExpireTimestamp,'wechat','wechat');
//            $paras['unixExpireTimestamp']=$unixExpireTimestamp;
//            $paras['signature']=$signature;
//
//            $room=$soap->__soapCall("SearchAvailiableRooms", $paras);

		$para['HallIds'] = '';
		$para['FloorIds'] = '';
		$para['RoomTypeIds'] = array('TR', 'BK');
		$para['RoomAttributeIds'] = '';
		$para['EstimatedArriveTime'] = '2016-06-29T12:00:00.000';
		$para['EstimatedDepartureTime'] = '2016-06-30T12:00:00.000';
		$para['HotelId'] = 201096561885199;
		ksort($para, SORT_STRING);
		$paras = array('SearchAvailiableRooms' => $para);
		$signature = $this->beyondh_sign($paras, $unixExpireTimestamp, 'wechat', 'wechat');
		$room = $soap->__soapCall("SearchAvailiableRooms", array(
			"parameters" => array(
				'searchAvailiableRoomModel' => $para,
				'unixExpireTimestamp'       => $unixExpireTimestamp,
				'signature'                 => $signature
			)
		));

		var_dump($room->SearchAvailiableRoomsResult);
		exit;


	}


	function beyondh_sign($paras, $timestamp, $signkey, $key){  //签名
		$s = '';
		if(!empty($paras)){
			foreach($paras as $k => $p){
				$a = $this->sign_string($p);
				$s .= $a;
			}
		}
		$s = strtolower($s);
		$s .= $timestamp . $signkey;
		$s = $key . ':' . md5($s);
		return $s;
	}

	function sign_string($paras){       //签名
		$s = '';
		if(is_null($paras)){
			return '';
		} else{
			if($paras === false){
				$s .= 'false';
			} else{
				if($paras === true){
					$s .= 'true';
				} else{
					if(is_array($paras) || is_object($paras)){
						ksort($paras, SORT_STRING);
						foreach($paras as $k => $pa){
							$s .= $this->sign_string($pa);
						}
					} else{
						if(strtotime($paras) && strstr($paras, 'T') !== false && $paras != 'T'){
							$s .= date('Y-m-d H-i-s', strtotime($paras));
						} else{
							if(strstr($paras, 'E+')){
								$paras = number_format($paras, 0, '', '');
								$s .= $paras;
							} else{
								$s .= $paras;
							}
						}
					}
				}
			}
		}
		return $s;
	}


	function getHotelInfoByWebId($web_id){      //根据酒店pmsid获取酒店ID

		$result = $this->db->query("SELECT * FROM `iwide_hotel_additions` WHERE inter_id='$this->inter_id' AND hotel_web_id='{$web_id}'")->row();

		return $result;

	}


	function check_hotel_config(){      //检查酒店相册是否已经配置，没有配置则添加配置

		$result = $this->db->query("SELECT * FROM `iwide_hotel_config` WHERE inter_id='$this->inter_id' AND param_name='HOTEL_GALLERY_TYPE' AND module='HOTEL' AND priority=0")->row();


		if(empty($result)){

			$this->db->query("INSERT INTO `iwide_hotel_config`(inter_id,param_name,module,priority,param_value) VALUES('$this->inter_id','HOTEL_GALLERY_TYPE','HOTEL',0,'酒店')");

			$result = $this->db->query("SELECT * FROM `iwide_hotel_config` WHERE inter_id='$this->inter_id' AND param_name='HOTEL_GALLERY_TYPE' AND module='HOTEL' AND priority=0")->row();

		}

		return $result->id;
	}


	public function GrabImage($url, $local_path, $filename = ""){
//		return $url;
		if($url == ""){
			return false;
		}

		$path = FD_PUBLIC . '/' . $local_path . '/' . date('Ym') . '/';
		$wpat = FD_PUBLIC . '/uploads/' . date('Ym') . '/';

		if(!is_dir(FCPATH . $path)){
			mkdir(FCPATH . $path, 0777, true);
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
		return false;
	}


	public function test(){

		set_time_limit(0);
		$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
//		$a = $this->pms->search_web_hotel(date('Y-m-d'), date('Y-m-d',time()+86400), 'detail', '442492034564097', '', '', 1, 12);
//		$a = $this->pms->search_web_hotel('2016-08-05', '2016-08-06', 'detail', '200591879700489', '', '', 1, 12);
//		$a=$this->pms->get_all_hotels(1,100);

//		$a=$this->pms->searchHotelById('201015418880007',date('Y-m-d'), date('Y-m-d',time()+86400),array('member_levels'=>array(''),'room_type_id'=>array('SSDCA')),false);
		//马鞍区郑蒲港清沐精品酒店 442492034564097
//		$a=$this->pms->searchHotelById('442492034564097',date('Y-m-d'), date('Y-m-d',time()+86400));
		//后巷中心大街店 455907328868353
		$search_param = array(
			'recache' => true,
		);
		$a = $this->pms->searchHotelById('394475832016897', date('Y-m-d', time() + 86400), date('Y-m-d', time() + 86400), $search_param);
		echo json_encode($a);
		exit;
		$a = array();
		/*$tmp = array(
			'394475832016897',
			'440343009656833'
		);*/
		$tmp = array(
			'442492034564097',
			'455907328868353'
		);
		$list = array();
		foreach($tmp as $v){
			$list[] = $this->pms->searchHotelById($v, date('Y-m-d'), date('Y-m-d', time() + 86400), array(
				'',
				'E会员',
				'66尾号',
				'金沐卡会员',
				'77尾号',
				'88尾号',
				'金房卡'
			));

		}
		echo json_encode($list);
	}

	public function new_hotel(){
		$hotel_web_id = '295514432815105';
		set_time_limit(0);
		$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
		$search_param = array(
			'recache'       => true,
			'member_levels' => ['', 'E会员', '66尾号', '金沐卡会员', '77尾号', '88尾号'],
		);
		$hotel = $this->pms->searchHotelById($hotel_web_id, date('Y-m-d'), date('Y-m-d', time() + 86400), $search_param);

		$db = $this->load->database('default', true);

		if(!empty($hotel[$hotel_web_id])){
			$hotel_info = $hotel['295514432815105'];

			$data = array(
				"name"      => $hotel_info['Name'],
				"address"   => $hotel_info['Address'],
				"latitude"  => $hotel_info['Latitude'],
				"longitude" => $hotel_info['Longitude'],
				"tel"       => $hotel_info['Phone'],
				"intro"     => $hotel_info['Description'],
				"inter_id"  => $this->inter_id,
			);
			$db->insert('hotels_copy', $data);
			$hotel_id = $db->insert_id();

			$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
			$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';
			$PmsInfo = array(
				"wsdl"     => $wsdl,
				"location" => $location,
				"key"      => 'key',
				"AppKey"   => 'key'
			);

			$json_pms = json_encode($PmsInfo);
			$params = [
				"inter_id"     => $this->inter_id,
				"hotel_id"     => $hotel_id,
				"pms_type"     => 'beyondh',
				"pms_auth"     => $json_pms,
				"hotel_web_id" => $hotel_info['HotelId'],
			];

			$db->insert('hotel_additions_copy', $params);

			$service_icon = array(
				'WiFi'   => '&#xe8;',
				'吹风机'    => '&#xe4;',
				//            '电热水壶'=>'&#xe8;',
				//            '国内长途电话'=>'&#xe8;',
				//            '电梯'=>'&#xe8;',
				//            '中央空调'=>'&#xe8;',
				'停车场'    => '&#xe7;',
				//            '旅游票务'=>'&#xe8;',
				'24小时热水' => '&#xeb;',
				'餐饮'     => '&#xea;',
				//            'KTV'=>'&#xe8;',
				//            '会议室'=>'&#xe8;',
				//            '国际长途电话'=>'&#xe8;',
				//            '外币兑换'=>'&#xe8;',
				//            '洗衣'=>'&#xe8;',
				'中餐厅'    => '&#xea;',
			);

			$image_data = [];
			if(!empty($hotel_info['ServiceTags']['string'])){
				$serviceIcon = $hotel_info['ServiceTags']['string'];
				foreach($serviceIcon as $arr){                  //插入酒店服务
					if(array_key_exists($arr, $service_icon)){
						$image_data[] = array(
							'hotel_id'  => $hotel_id,
							'inter_id'  => $this->inter_id,
							'type'      => 'hotel_service',
							'info'      => $arr,
							'disp_type' => 0,
							'room_id'   => 0,
							'image_url' => $service_icon[$arr]
						);
					}
				}
			}

			if($image_data){
				$db->insert_batch('hotel_images_copy', $image_data);
			}

			$room_data = [];
			if(!empty($hotel_info['RoomCounts']['RoomCount'])){
				foreach($hotel_info['RoomCounts']['RoomCount'] as $v){
					if(!$v['RoomType']['Virtual']){
						$room_data[] = [
							'inter_id'  => $this->inter_id,
							'hotel_id'  => $hotel_id,
							'webser_id' => $v['RoomType']['Id'],
							'name'      => $v['RoomType']['RoomTypeName'],
						];
					}
				}
			}

			if($room_data){
				$db->insert_batch('hotel_rooms_copy', $room_data);
			}

			if(!empty($hotel_info['LowestPrice']['RoomPrice'])){
				$lowest = null;
				$pricearr = [];
				foreach($hotel_info['LowestPrice']['RoomPrice'] as $v){
					$pricearr[] = $v['ActualPrice'];
				}

				$lowest = min($pricearr);
				$params = array(
					'hotel_id'     => $hotel_id,
					'inter_id'     => $this->inter_id,
					'lowest_price' => $lowest,
					'update_time'  => date('Y-m-d H:i:s'),
				);

				$db->insert('hotel_lowest_price_copy', $params);
			}

			echo 'success';

		}
	}

	public function test2(){
		set_time_limit(0);
		$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
		$a = $this->pms->get_all_hotels(1, 100);
		print_r($this->obj2array($a));
	}

	public function testhour(){
		$hotel_web_id = '295514432815105';//含山望梅店
//		$hotel_web_id='201101091733524';//常州孟河大道店
		$hotel_web_id = '169894572376065';//后巷中心大街店
		$hotel_web_id='196373661892612';

		set_time_limit(0);
		$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
		$member_levels = [
			"",
//			"66尾号",
//			"77尾号",
//			"88尾号",
//			"E会员",
//			"金房卡",
//			"金沐卡会员"
		];
		$a = $this->pms->getHourPrice($hotel_web_id, date('Y-m-d'), $member_levels, $this->inter_id, true);
		echo json_encode($a);
	}


	public function testpromo(){

		set_time_limit(0);
		$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
		$a = $this->pms->getPromoActive('227885230620673', date('Y-m-d'), date('Y-m-d', time() + 86400), $this->inter_id, true);
		print_r($a);
	}

	public function fixlowest(){
		$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
		$hotels = $this->pms->search_web_hotel(date('Y-m-d'), date('Y-m-d', time() + 86400), 'detail', '440343009656833');
		$hotels = obj2array($hotels);
		$hotel_list = array(
			'440343009656833' => 2736,
		);
		$params = array();
		foreach($hotels as $k => $v){
			if(!empty($v['LowestPrice']['RoomPrice']) && isset($hotel_list[$k])){
				$rp = $v['LowestPrice']['RoomPrice'];
				$min_price = null;
				foreach($rp as $t){
					if($min_price === null){
						$min_price = $t['ActualPrice'];
					} else{
						$min_price = min($t['ActualPrice'], $min_price);
					}
				}
				$params[] = array(
					'hotel_id'     => $hotel_list[$k],
					'inter_id'     => $this->inter_id,
					'lowest_price' => $min_price,
					'update_time'  => date('Y-m-d H:i:s'),
				);
			}
		}
		print_r($params);
		exit;
		if($params){
			$res = $this->db->set_insert_batch($params)->insert_batch('hotel_lowest_price_copy');
			echo $this->db->last_query();
//			print_r($params);
		}

	}

	public function lowestprice(){
		set_time_limit(180);
		$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
		$db = $this->pms->_shard_db();
		$hotels = $this->pms->search_web_hotel('2016-07-12', '2016-07-13', 'detail', null, '', '', 1, 100);


		$local_hotels = $db->from('iwide_hotel_additions')->where(array(
			                                                          'inter_id'  => $this->inter_id,
			                                                          'hotel_id>' => 0
		                                                          ))->select('hotel_id,hotel_web_id')->get()->result_array();
		$hotel_list = array();
		foreach($this->hotel_list as $v){
			$hotel_list[$v['hotel_web_id']] = $v['hotel_id'];
		}

		$hotels = $this->obj2array($hotels);
		$params = array();
		foreach($hotels as $k => $v){
			if(!empty($v['LowestPrice']['RoomPrice']) && isset($hotel_list[$k])){
				$rp = $v['LowestPrice']['RoomPrice'];
				$rp = array_shift($rp);
				$params[] = array(
					'hotel_id'     => $hotel_list[$k],
					'inter_id'     => $this->inter_id,
					'lowest_price' => $rp['OrignPrice'],
					'update_time'  => date('Y-m-d H:i:s'),
				);
			}
		}
		if($params){
			$res = $db->set_insert_batch($params)->insert_batch('hotel_lowest_price_copy');
			print_r($res);
		}

	}

	protected function obj2array($obj){
		$obj = (array)$obj;
		$result = array();
		foreach($obj as $k => $v){
			if(is_array($v) or is_object($v)){
				if($v){
					$v = $this->obj2array($v);
				} else{
					$v = null;
				}
			}
			$result[$k] = $v;
		}
		return $result;
	}

	public function catchrooms(){
		$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
		$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';

		$soap = new SoapClient($wsdl, array(
			'location'     => $location,
			'soap_version' => SOAP_1_1,
			'encoding'     => 'utf-8'
		));
		$data = array();
		$sql = "";
		foreach($this->hotel_list as $arr){

			$unixExpireTimestamp = time() + 86400;

			$paras = array('hotelId' => doubleval($arr['hotel_web_id']));
			$signature = $this->beyondh_sign($paras, $unixExpireTimestamp, 'wechat', 'wechat');
			$paras['unixExpireTimestamp'] = $unixExpireTimestamp;
			$paras['signature'] = $signature;
			$allRooms = $soap->__soapCall("GetHotelRoomTypes", array("parameters" => $paras))->GetHotelRoomTypesResult->Content->RoomType;


			foreach($allRooms as $rooms){

				$sql .= "update iwide_hotel_room set webser_id = '" . $rooms->Id . "' where inter_id = '" . $this->inter_id . "' and hotel_id = '" . $arr['hotel_id'] . "' and name = '" . $rooms->RoomTypeName . "';" . "\n";
				/*$data[] = array(
					'inter_id'  => $this->inter_id,
					'hotel_id'  => $arr['hotel_id'],
					'webser_id' => $rooms->Id,
					'name'      => $rooms->RoomTypeName
				);*/

			}
		}
		if($sql){
			file_put_contents(FD_PUBLIC . '/qingmu_room.sql', $sql);
		}
		echo $sql;

		/*if($data){
			$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
			$db = $this->pms->_shard_db();
			$db->set_insert_batch($data)->insert_batch('hotel_rooms_copy');
		}*/
		echo 'success';
	}

	public function priceset_fjson(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/qingmu_roomsfp.json');
		$room_list = json_decode($json, true);
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$db = $this->pms->_shard_db();
		$price_list = array(
			array('price_code' => 7),
			//			array('price_code' => 8),
			//			array('price_code' => 9),
			//			array('price_code' => 10),
		);

		foreach($room_list as $v){
			foreach($price_list as $t){
				/*$row = $db->from('hotel_price_set')->where(array(
					                                           'inter_id'   => $v['inter_id'],
					                                           'hotel_id'   => $v['hotel_id'],
					                                           'room_id'    => $v['room_id'],
					                                           'price_code' => $t['price_code'],
				                                           ))->get()->row_array();*/
				$row = false;
				if(!$row){
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
		}
		if($params){
			$db->set_insert_batch($params)->insert_batch('hotel_price_set_copy');
		}
	}

	public function insert_price(){
		set_time_limit(900);
		$room_list=$this->db->from('hotel_rooms')->where(['inter_id'=>$this->inter_id])->get()->result_array();

		$params = array();
		foreach($room_list as $v){
			for($i=1;$i<=10;$i++){
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
			$this->db->set_insert_batch($params)->insert_batch('hotel_price_set');
		}
		echo 'success';
	}


	public function catchhotels(){
		set_time_limit(0);

		$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
		$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';


		$soap = new SoapClient($wsdl, array(
			'location'     => $location,
			'soap_version' => SOAP_1_1,
			'encoding'     => 'utf-8'
		));


		$unixExpireTimestamp = time() + 86400;


		$paras = array('pageIndex' => 1, 'pageSize' => 1000);
		$signature = $this->beyondh_sign($paras, $unixExpireTimestamp, 'wechat', 'wechat');
		$paras['unixExpireTimestamp'] = $unixExpireTimestamp;
		$paras['signature'] = $signature;
		$hotel = $soap->__soapCall("GetAllHotels", array("parameters" => $paras));
		foreach($hotel->GetAllHotelsResult->Content->HotelSearchResponse as $d){
			$d->HotelId = number_format($d->HotelId, 0, '', '');
		}

		$hotels = $hotel->GetAllHotelsResult->Content->HotelSearchResponse;

		$PmsInfo = array(
			"wsdl"     => $wsdl,
			"location" => $location,
			"key"      => 'key',
			"AppKey"   => 'key'
		);

		$json_pms = json_encode($PmsInfo);

		$params = array();
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$db = $this->pms->_shard_db();
		foreach($hotels as $v){
			$data = array(
				"name"      => $v->Name,
				"address"   => $v->Address,
				"latitude"  => $v->Latitude,
				"longitude" => $v->Longitude,
				"tel"       => $v->Phone,
				"intro"     => $v->Description,
				"inter_id"  => $this->inter_id
			);
			$db->set($data)->insert('hotels_copy');
			$insert_id = $db->insert_id();

			$params[] = array(
				"inter_id"     => $this->inter_id,
				"hotel_id"     => $insert_id,
				"pms_type"     => 'beyondh',
				"pms_auth"     => $json_pms,
				"hotel_web_id" => $v->HotelId
			);

		}
		if($params){
			$db->set_insert_batch($params)->insert_batch('hotel_additions_copy');
		}
		echo 'success';
	}

	public function crooms(){
		set_time_limit(0);

		/*$hotel_additions = $this->db->get_where('hotel_additions_copy', array(
			'inter_id' => $this->inter_id,
			'pms_type' => 'beyondh'
		))->result();*/

		$json = file_get_contents(FD_PUBLIC . '/tmp_data/qingmu_hotels.json');
		$list = json_decode($json);


		$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
		$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';

		$soap = new SoapClient($wsdl, array(
			'location'     => $location,
			'soap_version' => SOAP_1_1,
			'encoding'     => 'utf-8'
		));
		$data = array();


		foreach($list as $arr){

			$unixExpireTimestamp = time() + 86400;

			$paras = array('hotelId' => floatval($arr->hotel_web_id));
			$signature = $this->beyondh_sign($paras, $unixExpireTimestamp, 'wechat', 'wechat');
			$paras['unixExpireTimestamp'] = $unixExpireTimestamp;
			$paras['signature'] = $signature;
			$allRooms = $soap->__soapCall("GetHotelRoomTypes", array("parameters" => $paras))->GetHotelRoomTypesResult->Content->RoomType;


			foreach($allRooms as $rooms){

				$data[] = array(
					'inter_id'  => $this->inter_id,
					'hotel_id'  => $arr->hotel_id,
					'webser_id' => $rooms->Id,
					'name'      => $rooms->RoomTypeName
				);
			}
		}
		if($data){
			$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
			$db = $this->pms->_shard_db();
			$db->set_insert_batch($data)->insert_batch('hotel_rooms_copy');
		}
		echo 'success';
	}

	public function merge(){
		set_time_limit(0);

		/*$json_new=file_get_contents(FD_PUBLIC.'/tmp_data/qingmu_hotels_l.json');
		$new_list=json_decode($json_new,true);

		$hotel_tmp=array();
		foreach($new_list as $v){
			$hotel_tmp[$v['hotel_id']]=$v;
		}*/

		$json_new = file_get_contents(FD_PUBLIC . '/tmp_data/qingmu_hotels.json');
		$new_list = json_decode($json_new, true);

		$json_old = file_get_contents(FD_PUBLIC . '/tmp_data/qingmu_web_hotels.json');
		$old_list = json_decode($json_old, true);
		//旧资料以PMS上酒店ID作为键
		$arr = array();
		foreach($old_list as $v){
			$arr[$v['hotel_web_id']] = $v;
		}
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$db = $this->pms->_shard_db();

		//新资料以旧资料的酒店ID
		$hotel_merge = array();
		foreach($new_list as $v){
			if(isset($arr[$v['hotel_web_id']])){
				/*$tmp=$hotel_tmp[$arr[$v['hotel_web_id']]['hotel_id']];
				$para=array(
					'country'=>$tmp['country'],
					'province'=>$tmp['province'],
					'city'=>$tmp['city'],
					'intro_img'=>$tmp['intro_img'],
				);
				$db->where(array('hotel_id'=>$v['hotel_id']))->set($para)->update('hotels_copy');*/

				$hotel_merge[$arr[$v['hotel_web_id']]['hotel_id']] = $v;
			} else{
				$hotel_merge['no_' . $v['hotel_id']] = $v;
			}
		}

		$json_new = file_get_contents(FD_PUBLIC . '/tmp_data/qingmu_rooms.json');
		$new_list = json_decode($json_new, true);

		$json_old = file_get_contents(FD_PUBLIC . '/tmp_data/qingmu_web_rooms.json');
		$old_list = json_decode($json_old, true);

		$arr = array();
		foreach($old_list as $v){
			$arr[$v['hotel_web_id']][$v['webser_id']] = $v;
		}

		$new = array();
		foreach($new_list as $v){
			if(isset($arr[$v['hotel_web_id']][$v['webser_id']])){
//				$v['room_img']=$arr[$v['hotel_web_id']][$v['webser_id']]['room_img'];
//				$db->where(array('room_id'=>$v['room_id']))->set(array('room_img'=>$v['room_img']))->update('hotel_rooms_copy');

				$new[$arr[$v['hotel_web_id']][$v['webser_id']]['room_id']] = $v;
			} else{
				$new['no_' . $v['room_id']] = $v;
			}
		}

		$merge = array(
			'hotels' => $hotel_merge,
			'rooms'  => $new,
		);
		return $merge;

	}

	public function getimages(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/qingmu_web_images.json');
		$list = json_decode($json, true);
		$merge = $this->merge();
		$rooms = $merge['rooms'];
		$hotels = $merge['hotels'];
//		print_r($merge);
//		exit;
		$params = array();
//		print_r($list);
		foreach($list as $v){
			unset($v['id']);
			$v['inter_id'] = $this->inter_id;
			if(!$v['room_id']){
				//酒店图片
				if(isset($hotels[$v['hotel_id']])){
					$v['hotel_id'] = $hotels[$v['hotel_id']]['hotel_id'];
					$params[] = $v;
				}
			} else{
				if(isset($rooms[$v['room_id']])){
					$v['hotel_id'] = $hotels[$v['hotel_id']]['hotel_id'];
					$v['room_id'] = $rooms[$v['room_id']]['room_id'];
					$params[] = $v;
				}
			}
		}
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$db = $this->pms->_shard_db();
		$db->set_insert_batch($params)->insert_batch('hotel_images_copy');
		echo 'success';
	}

	public function getlowest(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/qingmu_lowest.json');
		$list = json_decode($json, true);
		$merge = $this->merge();
		$rooms = $merge['rooms'];
		$hotels = $merge['hotels'];
		$params = array();
		foreach($list as $v){
			$v['inter_id'] = $this->inter_id;
			if(isset($hotels[$v['hotel_id']])){
				$v['hotel_id'] = $hotels[$v['hotel_id']]['hotel_id'];
				$params[] = $v;
			}
		}
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$db = $this->pms->_shard_db();
		$db->set_insert_batch($params)->insert_batch('hotel_lowest_price_copy');
		echo 'success';
	}

	public function getpriceset(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/qingmu_priceset.json');
		$list = json_decode($json, true);
		$merge = $this->merge();
		$rooms = $merge['rooms'];
		$hotels = $merge['hotels'];
		$params = array();
		foreach($list as $v){
			$v['inter_id'] = $this->inter_id;
			if(isset($rooms[$v['room_id']])){
				$v['hotel_id'] = $hotels[$v['hotel_id']]['hotel_id'];
				$v['room_id'] = $rooms[$v['room_id']]['room_id'];
				$params[] = $v;
			}
		}
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$db = $this->pms->_shard_db();
		$db->set_insert_batch($params)->insert_batch('hotel_price_set_copy');
		echo 'success';
	}

	public function getweborder(){
		$pms_set = array(
			'inter_id'     => $this->inter_id,
			'hotel_web_id' => '331918750007297',
		);
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		print_r($this->pms->get_web_order('454654016209031', $pms_set));
	}

	public function getroom(){
		$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
		$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';

		$soap = new SoapClient($wsdl, array(
			'location'     => $location,
			'soap_version' => SOAP_1_1,
			'encoding'     => 'utf-8'
		));

		$unixExpireTimestamp = time() + 86400;

		$paras = array('hotelId' => doubleval('200582580928515'));
		$arr = array('hotelId' => '200582580928515');
		$signature = $this->beyondh_sign($arr, $unixExpireTimestamp, 'wechat', 'wechat');
		$paras['unixExpireTimestamp'] = $unixExpireTimestamp;
		$paras['signature'] = $signature;
		$allRooms = $soap->__soapCall("GetHotelRoomTypes", array("parameters" => $paras))->GetHotelRoomTypesResult->Content->RoomType;
		echo json_encode($allRooms);
	}

	public function getallr(){

		$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
		$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';

		$soap = new SoapClient($wsdl, array(
			'location'     => $location,
			'soap_version' => SOAP_1_1,
			'encoding'     => 'utf-8'
		));

		$unixExpireTimestamp = time() + 86400;

//		$paras = array('hotelId' => doubleval('200582580928515'));
//		$arr=array('hotelId'=>'200582580928515');
		$signature = $this->beyondh_sign(array(), $unixExpireTimestamp, 'wechat', 'wechat');
		$paras['unixExpireTimestamp'] = $unixExpireTimestamp;
		$paras['signature'] = $signature;
		$allRooms = $soap->__soapCall("GetRoomTypes", array("parameters" => $paras));
		print_r($allRooms);
	}

	public function getallh(){
		$wsdl = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl';
		$location = 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic';


		$soap = new SoapClient($wsdl, array(
			'location'     => $location,
			'soap_version' => SOAP_1_1,
			'encoding'     => 'utf-8'
		));


		$unixExpireTimestamp = time() + 86400;


		$paras = array('pageIndex' => 1, 'pageSize' => 1000);
		$signature = $this->beyondh_sign($paras, $unixExpireTimestamp, 'wechat', 'wechat');
		$paras['unixExpireTimestamp'] = $unixExpireTimestamp;
		$paras['signature'] = $signature;
		$hotel = $soap->__soapCall("GetAllHotels", array("parameters" => $paras));
		print_r($hotel);
	}

	public function recordtime(){
		/*$record=$this->db->from('webservice_record')->where(array('inter_id'=>$this->inter_id,'record_type'=>'query_time'))->order_by('id','desc')->limit(20)->get()->result_array();
		$list=array();
		foreach($record as $v){
			$v['_record_time'] = date('Y-m-d H:i:s', $v['record_time']);

			$v['receive_content'] = json_decode($v['receive_content'], TRUE);
			$v['receive_content']['执行时间'] = $v['_record_time'];
			$list[] = $v['receive_content'];
		}*/
		$json = array(
			'{"\u67e5\u8be2\u672c\u5730\u914d\u7f6e":"0.0035\u79d2","\u8bf7\u6c42PMS\u5b9e\u65f6\u623f\u6001":"18.2588\u79d2","\u4e0e\u672c\u5730\u623f\u578b\u5339\u914d":"0.0429\u79d2","\u83b7\u53d6\u623f\u578b\u623f\u6001\u603b\u8017\u65f6":"18.3052\u79d2","\u6267\u884c\u65f6\u95f4":"2016-08-11 14:24:16"}',
			'{"\u67e5\u8be2\u672c\u5730\u914d\u7f6e":"0.0034\u79d2","\u8bf7\u6c42PMS\u5b9e\u65f6\u623f\u6001":"8.0402\u79d2","\u4e0e\u672c\u5730\u623f\u578b\u5339\u914d":"0.0386\u79d2","\u83b7\u53d6\u623f\u578b\u623f\u6001\u603b\u8017\u65f6":"8.0822\u79d2","\u6267\u884c\u65f6\u95f4":"2016-08-11 14:24:16"}',
			'{"\u67e5\u8be2\u672c\u5730\u914d\u7f6e":"0.0034\u79d2","\u8bf7\u6c42PMS\u5b9e\u65f6\u623f\u6001":"23.7773\u79d2","\u4e0e\u672c\u5730\u623f\u578b\u5339\u914d":"0.0236\u79d2","\u83b7\u53d6\u623f\u578b\u623f\u6001\u603b\u8017\u65f6":"23.8043\u79d2","\u6267\u884c\u65f6\u95f4":"2016-08-11 14:16:27"}',
			'{"\u67e5\u8be2\u672c\u5730\u914d\u7f6e":"0.0034\u79d2","\u8bf7\u6c42PMS\u5b9e\u65f6\u623f\u6001":"31.4865\u79d2","\u4e0e\u672c\u5730\u623f\u578b\u5339\u914d":"0.0475\u79d2","\u83b7\u53d6\u623f\u578b\u623f\u6001\u603b\u8017\u65f6":"31.5373\u79d2","\u6267\u884c\u65f6\u95f4":"2016-08-11 14:16:21"}',
			'{"\u67e5\u8be2\u672c\u5730\u914d\u7f6e":"0.0034\u79d2","\u8bf7\u6c42PMS\u5b9e\u65f6\u623f\u6001":"48.3757\u79d2","\u4e0e\u672c\u5730\u623f\u578b\u5339\u914d":"0.0241\u79d2","\u83b7\u53d6\u623f\u578b\u623f\u6001\u603b\u8017\u65f6":"48.4032\u79d2","\u6267\u884c\u65f6\u95f4":"2016-08-11 14:15:38"}'
		);

		$list = array();
		foreach($json as $v){
			$list[] = json_decode($v, true);
		}
		echo json_encode($list);
	}

	public function getorder(){
		$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
		$params = array(
			'U8146964099107393' => array(
				'web_orderid' => '458238008803500',
				'pms_set'     => array('hotel_web_id' => '196362979000323'),
			),
			'T4146966005054109' => array(
				'web_orderid' => '458333311647746',
				'pms_set'     => array('hotel_web_id' => '196773974622213'),
			),
			'ck146968194029621' => array(
				'web_orderid' => '458441723543601',
				'pms_set'     => array('hotel_web_id' => '196773974622213'),
			),
			'38146967467744665' => array(
				'web_orderid' => '458406452756518',
				'pms_set'     => array('hotel_web_id' => '200595503579150'),
			),
			'X0146967044764840' => array(
				'web_orderid' => '458385287462934',
				'pms_set'     => array('hotel_web_id' => '201010339577857'),
			),
			'T0146902835315388' => array(
				'web_orderid' => '455174827655348',
				'pms_set'     => array('hotel_web_id' => '394475832016897'),
			),
			'oc146968205902362' => array(
				'web_orderid' => '458443350720573',
				'pms_set'     => array('hotel_web_id' => '406575747137537'),
			),
		);
		$list = array();
		set_time_limit(0);
		$this->load->helper('common');
		$status_arr = $this->pms->pms_enum('status');
		unset($params);
		/*$v=array(
			'web_orderid'=>'458423201497122',
			'pms_set'=>array('hotel_web_id'=>'197027884367873','inter_id'=>$this->inter_id)
		);*/
		/*$v=array(
			'web_orderid'=>'460984805474327',
			'pms_set'=>array('hotel_web_id'=>'196164814503937','inter_id'=>$this->inter_id)
		);*/
		/*$params=array(
			'oA147047687416251'=>array(
				'web_orderid'=>'462417452400654',
				'pms_set'=>array('hotel_web_id'=>'201015418880007','inter_id'=>$this->inter_id),
			),
			'oh8147046045394319'=>array(
				'web_orderid'=>'462334302289924',
				'pms_set'=>array('hotel_web_id'=>'196373661892612','inter_id'=>$this->inter_id),
			),
			'oh8147046050976789'=>array(
				'web_orderid'=>'462334576377860',
				'pms_set'=>array('hotel_web_id'=>'196373661892612','inter_id'=>$this->inter_id),
			),
		);*/
		$params = array(
			'464277984935960' => array(
				'web_orderid' => '464277984935960',
				'pms_set'     => array('hotel_web_id' => '201016425512969', 'inter_id' => $this->inter_id),
			)
		);
		$params = [
			'oY147887779595143' => [
				'web_orderid' => '504422029476361',
				'pms_set'     => ['hotel_web_id' => '174189599522817', 'inter_id' => $this->inter_id],
			],
			'Hc147876166800874' => [
				'web_orderid' => '503840370065625',
				'pms_set'     => ['hotel_web_id' => '200594903793677', 'inter_id' => $this->inter_id],
			],
			'Hc147922308633092' => [
				'web_orderid' => '506147455517057',
				'pms_set'     => ['hotel_web_id' => '200594903793677', 'inter_id' => $this->inter_id],
			],
			'MU147945968270961' => [
				'web_orderid' => '507331490333002',
				'pms_set'     => ['hotel_web_id' => '201013275590661', 'inter_id' => $this->inter_id],
			],
		];

		/*$params=[
			'_E147990687836284'=>[
				'web_orderid'=>'509566413078968',
				'pms_set'=>['hotel_web_id'=>'196164814503937','inter_id'=>$this->inter_id],
			],
			'7o147859472143080'=>[
				'web_orderid'=>'503005632872461',
				'pms_set'=>['hotel_web_id'=>'201098495459345','inter_id'=>$this->inter_id],
			],
		];*/
		foreach($params as $k => $v){
			$res = $this->pms->get_web_order($v['web_orderid'], $v['pms_set']);
			$res = obj2array($res);
			/*if($res){
				$list[]=array(
					'orderid'=>$k,
					'web_status'=>$res['OrderStatus'],
					'status'=>$status_arr[$res['OrderStatus']],
				);
			}*/
			$list[] = $res;
//			echo json_encode($res);
		}
		echo json_encode($list);
	}

	public function checkinstatus(){
		$hotel_web_id = '196765141417986';
		$web_orderid = '508246921855277';
		$orderids = array(doubleval('508246921855277'));
		$orderids_sign = array('508246921855277');
//		$orderids_sign=$orderids=array();
		$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
		$res = $this->pms->getWebCheckin($hotel_web_id, $web_orderid);
		print_r($res);
	}

	public function get_bill_list(){
		set_time_limit(900);
		$params = [
			'oY147887779595143' => [
				'hotel_web_id' => '174189599522817',
				'bill_id'      => '504422029476365',
			],
			'Hc147876166800874' => [
				'hotel_web_id' => '200594903793677',
				'bill_id'      => '503840370065629',
			],
			'Hc147922308633092' => [
				'hotel_web_id' => '200594903793677',
				'bill_id'      => '506147455517063',
			],
			'MU147945968270961' => [
				'hotel_web_id' => '201013275590661',
				'bill_id'      => '507331490333006',
			],
		];
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$list = [];
		foreach($params as $k => $v){
			$res = $this->pms->getOrderBill($v['hotel_web_id'], $v['bill_id']);
			$list[$k] = $res;
		}
		echo json_encode($list);
	}

	public function get_bill(){
		$hotel_web_id = '196765141417986';
//		$bill_id = ['499117852101526','499117807274808'];
		$bill_id = ['508246255144302'];
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$list = [];
		$fang_fee = ['D1000', 'D1001', 'D1002', 'D1020'];
		foreach($bill_id as $v){
			$res = $this->pms->getOrderBill($hotel_web_id, $v);
			$new_price = 0;
			foreach($res as $t){
				if(in_array($t['DebitType'], $fang_fee)){//房费类型
					$new_price += $t['Amount'];
				}
			}

			$list[] = $res;
		}
		echo json_encode($list);
	}

	public function get_billids(){
		$json = file_get_contents(FD_PUBLIC . '/qingmutest/qingmu_problem.json');
		$list = json_decode($json, true);
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$fang_fee = ['D1000', 'D1001', 'D1002', 'D1020'];
		$result = [];
		set_time_limit(900);
		$_list = array_slice($list, 100);
		foreach($_list as $v){
			$hotel_web_id = $v['hotel_web_id'];
			$web_orderid = $v['web_orderid'];
			$res = $this->pms->getWebCheckin($hotel_web_id, $web_orderid);
			if(!empty($res[$web_orderid])){
				foreach($res[$web_orderid] as $k => $t){
					if($k == $v['webs_orderid']){
						$v['bill_id'] = (string)$t['BillId'];
						$result[] = $v;

						/*$bill_id=$t['BillId'];
						$rs=$this->pms->getOrderBill($hotel_web_id,$bill_id);

						$new_price = 0;
						foreach($rs as $w){
							if(in_array($w['DebitType'], $fang_fee)){//房费类型
								$new_price += $w['Amount'];
							}
						}

						if($v['iprice']-$new_price!= 0){
							$result[] = [
								'sub_id'    => $v['item_id'],
								'orderid'   => $v['orderid'],
								'inter_id'  => $this->inter_id,
								'new_price' => $new_price,
								'iprice'    => $v['iprice'],
							];
						}*/
					}
				}
			}
		}
		if($result){
			file_put_contents(FD_PUBLIC . '/qingmutest/fixed1.json', json_encode($result));
			echo json_encode($result);
		}
	}

	public function check_price(){
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$json = file_get_contents(FD_PUBLIC . '/qingmutest/fixed.json');
		$list = json_decode($json, true);
		$fang_fee = ['D1000', 'D1001', 'D1002', 'D1020'];
		$result = [];
		set_time_limit(900);
		$_list = array_slice($list, 100);
		foreach($_list as $v){
			$hotel_web_id = $v['hotel_web_id'];
			$bill_id = $v['bill_id'];
			$rs = $this->pms->getOrderBill($hotel_web_id, $bill_id);

			$new_price = 0;
			foreach($rs as $w){
				if(in_array($w['DebitType'], $fang_fee)){//房费类型
					$new_price += $w['Amount'];
				}
			}

			if($v['iprice'] - $new_price != 0){
				$result[] = [
					'sub_id'    => $v['sub_id'],
					'orderid'   => $v['orderid'],
					'inter_id'  => $this->inter_id,
					'new_price' => $new_price,
					'iprice'    => $v['iprice'],
				];
			}
		}
		if($result){
			file_put_contents(FD_PUBLIC . '/qingmutest/new_price1.json', json_encode($result));
			echo json_encode($result);
		}

	}

	public function occpation(){
		$orderids = '458568163868800';
		$orderids_sign = '458568163868800';
//		$orderids_sign=$orderids=array();
		$this->load->model('hotel/pms/BeyondH_hotel_model', 'pms');
		$pms_set = array('hotel_web_id' => '196763937652737', 'inter_id' => $this->inter_id);
		$this->pms->getOccupation($orderids, $pms_set);
	}

	public function testbill(){
//		$order_json='[{"id":"498593","hotel_id":"2685","openid":"oNjXVjmXj6KF5NbIH8pdPycNkgU4","inter_id":"a464919542","price":"115.00","roomnums":"1","name":"\u4f59\u5149\u6167","tel":"18505556601","order_time":"1470298842","startdate":"20160804","enddate":"20160805","paid":"1","orderid":"U4147029884235452","status":"1","holdtime":"2016-08-05 12:00","paytype":"weixin","isdel":"0","operate_reason":"\u652f\u4ed8\u5b8c\u6210","remark":"","member_no":"2428022","handled":"0","coupon_favour":"0.00","complete_reward_given":"1","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"1","complete_point_info":"","web_orderid":"461527282761829","room_codes":"{\"12314\":{\"code\":{\"price_type\":\"common\",\"extra_info\":{\"type\":\"code\",\"pms_code\":\"\\u91d1\\u623f\\u5361\",\"virtual\":true,\"physical_webser_id\":\"SSXX\",\"webser_id\":\"ssxxth\"}},\"room\":{\"webser_id\":\"SSXX\"}}}","web_paid":"2","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","hotel_web_id":"200592638869514"}, {"id":"498599","hotel_id":"2685","openid":"oNjXVjmXj6KF5NbIH8pdPycNkgU4","inter_id":"a464919542","price":"115.00","roomnums":"1","name":"\u8861\u6b63\u6587","tel":"13952010163","order_time":"1470298926","startdate":"20160804","enddate":"20160805","paid":"1","orderid":"U4147029892613024","status":"1","holdtime":"2016-08-05 12:00","paytype":"weixin","isdel":"0","operate_reason":"\u652f\u4ed8\u5b8c\u6210","remark":"","member_no":"2428022","handled":"0","coupon_favour":"0.00","complete_reward_given":"1","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"1","complete_point_info":"","web_orderid":"461526654697555","room_codes":"{\"12314\":{\"code\":{\"price_type\":\"common\",\"extra_info\":{\"type\":\"code\",\"pms_code\":\"\\u91d1\\u623f\\u5361\",\"virtual\":true,\"physical_webser_id\":\"SSXX\",\"webser_id\":\"ssxxth\"}},\"room\":{\"webser_id\":\"SSXX\"}}}","web_paid":"2","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","hotel_web_id":"200592638869514"}]';

		$order_json = '{"id":"498976","hotel_id":"2662","openid":"oNjXVjhd6OBk20n4RJ7oF7_RPM14","inter_id":"a464919542","price":"117.00","roomnums":"1","name":"\u6d4b\u8bd5","tel":"18520102018","order_time":"1470305566","startdate":"20160804","enddate":"20160805","paid":"1","orderid":"14147030556660781","status":"1","holdtime":"2016-08-05 12:00","paytype":"weixin","isdel":"0","operate_reason":"\u652f\u4ed8\u5b8c\u6210","remark":"","member_no":"2104942","handled":"0","coupon_favour":"0.00","complete_reward_given":"1","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"2","complete_point_info":"{\"type\":\"BALANCE\",\"give_amount\":117,\"give_rate\":\"1.000000\"}","web_orderid":"461560904302713","room_codes":"{\"12142\":{\"code\":{\"price_type\":\"member\",\"extra_info\":{\"type\":\"code\",\"pms_code\":\"\\u91d1\\u6c90\\u5361\\u4f1a\\u5458\",\"virtual\":false,\"physical_webser_id\":null,\"webser_id\":\"SSDC\"}},\"room\":{\"webser_id\":\"SSDC\"}}}","web_paid":"2","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","hotel_web_id":"196164814503937"}';


		$order = json_decode($order_json, true);
//		print_r($order);
//		exit;
		$web_orderid = $order['web_orderid'];
		$pms_set = array('hotel_web_id' => '196164814503937', 'inter_id' => $this->inter_id);
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');

		$par = array(
			'sub_item_type' => 'C9240',
			'trans_no'      => $order['orderid'],
		);

		$res = $this->pms->add_web_bill($web_orderid, $order, $pms_set, $par);
		var_dump($res);

	}

	public function handle_bill(){
		$json = null;
//		$json='["464140277547024",{"id":"518375","inter_id":"a464919542","orderid":"GU147082144262689","coupon_favour":"0.00","complete_reward_given":"0","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"0","complete_point_info":"","web_orderid":"464140277547024","room_codes":"{\"12378\":{\"code\":{\"price_type\":\"common\",\"extra_info\":{\"type\":\"code\",\"pms_code\":\"\\u91d1\\u623f\\u5361\",\"virtual\":true,\"physical_webser_id\":\"SSXXB\",\"webser_id\":\"XSSXXB\"}},\"room\":{\"webser_id\":\"SSXXB\"}}}","web_paid":"0","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","hotel_id":"2694","openid":"oNjXVjhw60lHvAB-dOLnwjWf9xGU","price":"128.00","roomnums":"1","name":"\u6c88\u96f7","tel":"15950559541","order_time":"1470821442","startdate":"20160810","enddate":"20160811","paid":"1","status":"1","holdtime":"18:00","paytype":"weixin","isdel":"0","operate_reason":"\u652f\u4ed8\u5b8c\u6210","remark":"","member_no":"2454763","handled":"0","hname":"\u9547\u6c5f\u4e2d\u5c71\u897f\u8def\u5927\u6da6\u53d1\u5e97","himg":"http:\/\/file.iwide.cn\/public\/uploads\/201607\/20160708151118638.jpg","haddress":"\u4e2d\u5c71\u897f\u8def2\u53f7","longitude":"119.425836","latitude":"32.187849","htel":"0511-85481999","order_datetime":"2016-08-10 17:30:42","order_details":[{"id":"546552","orderid":"GU147082144262689","inter_id":"a464919542","room_id":"12378","iprice":"128.00","startdate":"20160810","enddate":"20160811","istatus":"0","allprice":"128","room_no":"","roomname":"\u65f6\u5c1a\u4f11\u95f2\u623fB","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"7","room_no_id":"0","price_code_name":"\u7279\u60e0\u4ef7","handled":"0","webs_orderid":"","real_allprice":"128","club_id":"","sub_id":"546552"}],"first_detail":{"id":"546552","orderid":"GU147082144262689","inter_id":"a464919542","room_id":"12378","iprice":"128.00","startdate":"20160810","enddate":"20160811","istatus":"0","allprice":"128","room_no":"","roomname":"\u65f6\u5c1a\u4f11\u95f2\u623fB","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"7","room_no_id":"0","price_code_name":"\u7279\u60e0\u4ef7","handled":"0","webs_orderid":"","real_allprice":"128","club_id":"","sub_id":"546552"}},{"inter_id":"a464919542","hotel_id":"2694","pms_type":"beyondh","pms_auth":"{\"wsdl\":\"http:\\\/\\\/njqm.beyondh.com:7998\\\/Service\\\/Order\\\/HotelService.svc?wsdl\",\"location\":\"http:\\\/\\\/njqm.beyondh.com:7998\\\/Service\\\/Order\\\/HotelService.svc\\\/Basic\",\"key\":\"key\",\"AppKey\":\"key\"}","hotel_web_id":"200598871605267","pms_room_state_way":"4","pms_member_way":"1"},"GU147082144262689"]';

		$params = json_decode($json, true);
		/*$params[3] = array(
			'sub_item_type' => 'C9240',
			'trans_no'      => $params[3],
		);*/
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$res = $this->pms->add_web_bill($params[0], $params[1], $params[2], $params[3]);
		var_dump($res);
	}

	public function testbackbill(){
		$hotel_web_id = '200582580928515';
		$bill_item_id = '458657326530734';
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');

		$res = $this->pms->rollback_bill($bill_item_id, $hotel_web_id, '测试');
		print_r($res);

	}

	public function testconf(){
		$map = array(
			'param_name'  => 'BOOK_DATE_VALIDATE',
			'module'      => 'HOTEL',
			'param_value' => json_encode(array(
				                             'startdate' => array(
					                             array('compare' => 'less', 'hour' => 6, 'val' => -1),
				                             ),
			                             )),
			'hotel_id'    => 0,
			'inter_id'    => $this->inter_id,
		);
		$this->db->insert('hotel_config', $map);
		echo 'success';
	}
	
	public function getprice(){
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		$hotel_web_id='196351587270600';
//		$sdate='2017-05-09';
		$sdate=date('Y-m-d').'T12:00:00';
		$edate=date('Y-m-d',time()+86400).'T12:00:00';
//		$edate='2017-05-10';
		$search_params=[
		'member_levels'=>[	'',
		                      'E会员',
		                      '66尾号',
		                      '金沐卡会员',
		                      '77尾号',
		                      '88尾号'],
		'web_room_types'=>[]
		];
		$res=$this->pms->searchHotelById($hotel_web_id,$sdate,$edate,$search_params);
		echo json_encode($res);
	}

	public function catch_newhotels(){
		/*$tmp = array(
			'442492034564097',
			'455907328868353'
		);*/
		$tmp = array('196351587270658');
		$this->load->model('hotel/pms/Beyondh_hotel_model', 'pms');
		set_time_limit(0);
		$pms_auth = '{"wsdl":"http:\/\/njqm.beyondh.com:7998\/Service\/Order\/HotelService.svc?wsdl","location":"http:\/\/njqm.beyondh.com:7998\/Service\/Order\/HotelService.svc\/Basic","key":"key","AppKey":"key"}';
		$addi_params = $room_params = $lowest_params = array();
		$db = $this->load->database('default', true);
		foreach($tmp as $v){
			$hotel = $this->pms->searchHotelById($v, date('Y-m-d'), date('Y-m-d', time() + 86400), array(
				'member_levels' => array(
					'',
					'E会员',
					'66尾号',
					'金沐卡会员',
					'77尾号',
					'88尾号'
				)
			), $this->inter_id);
			$hotel = obj2array($hotel);
			if(!empty($hotel[$v])){
				$arr = $hotel[$v];
				$data = array(
					'name'      => $arr['Name'],
					'address'   => $arr['Address'],
					'latitude'  => $arr['Latitude'],
					'longitude' => $arr['Longitude'],
					'tel'       => $arr['Phone'],
					'intro'     => $arr['Description'],
					'inter_id'  => $this->inter_id,
				);
				$db->insert('hotels_copy', $data);
				$hotel_id = $db->insert_id();
				$addi_params[] = array(
					'inter_id'           => $this->inter_id,
					'hotel_web_id'       => $arr['HotelId'],
					'pms_auth'           => $pms_auth,
					'pms_type'           => 'beyondh',
					'pms_room_state_way' => 4,
					'hotel_id'           => $hotel_id,
				);
				if(!empty($arr['RoomCounts']['RoomCount'])){
					foreach($arr['RoomCounts']['RoomCount'] as $t){
						$room_params[] = array(
							'inter_id'  => $this->inter_id,
							'hotel_id'  => $hotel_id,
							'name'      => $t['RoomType']['RoomTypeName'],
							'webser_id' => $t['RoomTypeId'],
						);
					}
				}
				if(!empty($arr['LowestPrice']['RoomPrice'])){
					$rp = $arr['LowestPrice']['RoomPrice'];
					$min_price = null;
					foreach($rp as $t){
						if($min_price === null){
							$min_price = $t['ActualPrice'];
						} else{
							$min_price = min($t['ActualPrice'], $min_price);
						}
					}
					$lowest_params[] = array(
						'hotel_id'     => $hotel_id,
						'inter_id'     => $this->inter_id,
						'lowest_price' => $min_price,
						'update_time'  => date('Y-m-d H:i:s'),
					);
				}
			}
		}
		if($addi_params){
			$db->insert_batch('hotel_additions_copy', $addi_params);
		}
		if($room_params){
			$db->insert_batch('hotel_rooms_copy', $room_params);
		}
		if($lowest_params){
			$db->insert_batch('hotel_lowest_price_copy', $lowest_params);
		}
		echo 'success';
	}

	public function merge_set(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/qingmu_rooms_prod.json');
		$room_list = json_decode($json, true);
		$params = array();
//		$t = 13;
		foreach($room_list as $v){
//			if($v['hotel_id']!=3690){
			for($t = 14; $t <= 15; $t++){
				$params[] = array(
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $t,
					'edittime'   => time(),
					'status'     => 1,
				);
			}
//			}

		}
		$db = $this->load->database('default', true);
		if($params){
//			echo json_encode($params);
			$db->insert_batch('hotel_price_set_copy', $params);
		}
		echo 'success';
	}

    public function balanceBill(){
		$this->load->helper('common');
		$this->load->model('hotel/pms/Beyondh_hotel_model','pms');
		$web_orderid='504422029476361';
		$pms_set=['hotel_web_id'=>'174189599522817'];
		$order=[
			'price'=>219.00,
		];

		var_dump($this->pms->addBalanceBill($web_orderid,$order,$pms_set));
	}
	
	
	public function testorder(){
		$json='{"orderAddRequest":{"ContractId":0,"EstimatedArriveTime":"2017-05-10T16:00:00.000","EstimatedDepartureTime":"2017-05-10T19:00:00.000","ExpireKeepTime":null,"ExternalPriceName":null,"Guests":[{"Name":"测试","Gender":"0","Phone":"","Mobile":"","Fax":"","Email":"","Nationality":"","TransactoinId":0}],"HotelId":"511079484276737","IsExtenalPrice":true,"Liaisons":[{"Name":"测试","Gender":"0","Phone":"","Mobile":"18999999999","Fax":"","Email":"","TransactoinId":0}],"CheckinType":"Hour3","PublicMemo":null,"PrePaymentTypeId":null,"PromotionId":0,"Locked":false,"MemberId":null,"SalerId":null,"RoomPlans":[{"RoomTypeId":"GJDCFA","Amount":"1","RoomType":null,"TransactoinId":0,"Price":[{"Date":"2017-05-10T00:00:00","OrignPrice":60,"RoomCount":0,"ActualPrice":60,"RoomTypeId":"GJDCFA","TransactoinId":0,"RoomType":null,"Description":""}]}],"OrderItemRequests":null}}';
		$obj=json_decode($json);
		
		
		
		$paras = array('orderAddRequest' => $obj->orderAddRequest);
		$paras['orderAddRequest']->HotelId=doubleval($obj->orderAddRequest->HotelId);
		$signs=json_decode($json,true);
		$signs['orderAddRequest']['HotelId'] = $obj->orderAddRequest->HotelId;
		
		$this->load->helper('common');
		$this->load->model('hotel/pms/Beyondh_hotel_model','pms');
		
		$res=$this->pms->sub_to_web('order', "AddOrder", $paras, $signs);
		echo json_encode([
			'request'=>$signs,
		    'res'=>$res
		    
		]);
	}


}