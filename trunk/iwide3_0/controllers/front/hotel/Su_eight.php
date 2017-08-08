<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Su_eight extends MY_Controller {
	function __construct() {
		parent::__construct ();
		set_time_limit ( 0 );
	}
	function add_city_code() {
		// $this->load->library ( 'Baseapi/Subaapi_webservice', array (
		// 'testModel' => TRUE
		// ), 'su' );
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$s8 = $this->Suba_hotel_ext_model->get_web_obj ();
		$data = $s8->GetCity ();
		$inter_id = 'a455510009';
		$data = $data ['GetCityResult'] ['Content'] ['RegionModel'];
		$tmp = array (
				'hotel_id' => 0,
				'inter_id' => $inter_id,
				'webservice_name' => 'suba',
				'value_type' => 'city_code' 
		);
		$tmp_des = array (
				'hotel_id' => 0,
				'inter_id' => $inter_id,
				'webservice_name' => 'suba',
				'value_type' => 'city_code_des' 
		);
		$this->load->model ( 'common/Webservice_model' );
		$citys = $this->Webservice_model->get_web_reflect ( $inter_id, 0, 'suba', array (
				'city_code',
				'city_code_des' 
		), 1, 'w2l' );
		$city = empty ( $citys ['city_code'] ) ? array () : $citys ['city_code'];
		$city_des = empty ( $citys ['city_code_des'] ) ? array () : $citys ['city_code_des'];
		$add_count = 0;
		$update_count = 0;
		$des_add_count = 0;
		$des_update_count = 0;
		foreach ( $data as $d ) {
			if (empty ( $city [$d ['RegionCode']] )) {
				$tmp ['web_value'] = $d ['RegionCode'];
				$tmp ['local_value'] = json_encode ( array (
						'r' => $d ['RegionName'],
						'p' => $d ['PinyinName'],
						'n' => 0 
				), JSON_UNESCAPED_UNICODE );
				echo $this->db->insert_string ( 'webservice_field_config', $tmp ).';<br />';
				$add_count ++;
			} else {
				$updata = array (
						'local_value' => json_encode ( array (
								'r' => $d ['RegionName'],
								'p' => $d ['PinyinName'],
								'n' => 0 
						) ) 
				);
// 				$this->db->where ( array (
// 						'hotel_id' => 0,
// 						'inter_id' => $inter_id,
// 						'webservice_name' => 'suba',
// 						'value_type' => 'city_code',
// 						'web_value' => $d ['RegionCode'] 
// 				) );
				echo $this->db->update_string ( 'webservice_field_config', $updata ,array (
						'hotel_id' => 0,
						'inter_id' => $inter_id,
						'webservice_name' => 'suba',
						'value_type' => 'city_code',
						'web_value' => $d ['RegionCode'] 
				)).';<br />';
				$update_count ++;
			}
			if (empty ( $city_des [$d ['RegionCode']] )) {
				$tmp_des ['web_value'] = $d ['RegionCode'];
				$tmp_des ['local_value'] = $d ['RegionName'];
				echo $this->db->insert_string ( 'webservice_field_config', $tmp_des ).';<br />';
				$des_add_count ++;
			} else {
				$updata_des = array (
						'local_value' => $d ['RegionName'] 
				);
// 				$this->db->where ( array (
// 						'hotel_id' => 0,
// 						'inter_id' => $inter_id,
// 						'webservice_name' => 'suba',
// 						'value_type' => 'city_code_des',
// 						'web_value' => $d ['RegionCode'] 
// 				) );
				echo $this->db->update_string ( 'webservice_field_config', $updata_des ,array (
						'hotel_id' => 0,
						'inter_id' => $inter_id,
						'webservice_name' => 'suba',
						'value_type' => 'city_code_des',
						'web_value' => $d ['RegionCode'] 
				)).';<br />';
				$des_update_count ++;
			}
		}
		echo 'add:' . $add_count . '<br />';
		echo 'update:' . $update_count . '<br />';
		echo 'des_add_count:' . $des_add_count . '<br />';
		echo 'des_update_count:' . $des_update_count . '<br />';
		$this->change_hot_city ();
	}
	function add_landmark_code() {
		$this->load->library ( 'Baseapi/Subaapi_webservice', array (
				'testModel' => TRUE 
		), 'su' );
		$data = $this->su->GetCity ();
		$inter_id = 'a455510009';
		$data = $data ['GetCityResult'] ['Content'] ['RegionModel'];
		$tmp = array (
				'hotel_id' => 0,
				'inter_id' => $inter_id,
				'webservice_name' => 'suba',
				'value_type' => 'city_code' 
		);
		$tmp_des = array (
				'hotel_id' => 0,
				'inter_id' => $inter_id,
				'webservice_name' => 'suba',
				'value_type' => 'city_code_des' 
		);
		$this->load->model ( 'common/Webservice_model' );
		$citys = $this->Webservice_model->get_web_reflect ( $inter_id, 0, 'suba', array (
				'city_code',
				'city_code_des' 
		), 1, 'w2l' );
		$city = empty ( $citys ['city_code'] ) ? array () : $citys ['city_code'];
		$city_des = empty ( $citys ['city_code_des'] ) ? array () : $citys ['city_code_des'];
		$add_count = 0;
		$update_count = 0;
		$des_add_count = 0;
		$des_update_count = 0;
		foreach ( $data as $d ) {
			if (empty ( $city [$d ['RegionCode']] )) {
				$tmp ['web_value'] = $d ['RegionCode'];
				$tmp ['local_value'] = json_encode ( array (
						'r' => $d ['RegionName'],
						'p' => $d ['PinyinName'],
						'n' => 0 
				), JSON_UNESCAPED_UNICODE );
				$this->db->insert ( 'webservice_field_config', $tmp );
				$add_count ++;
			} else {
				$updata = array (
						'local_value' => json_encode ( array (
								'r' => $d ['RegionName'],
								'p' => $d ['PinyinName'],
								'n' => 0 
						), JSON_UNESCAPED_UNICODE ) 
				);
				$this->db->where ( array (
						'hotel_id' => 0,
						'inter_id' => $inter_id,
						'webservice_name' => 'suba',
						'value_type' => 'city_code',
						'web_value' => $d ['RegionCode'] 
				) );
				$this->db->update ( 'webservice_field_config', $updata );
				$update_count ++;
			}
			if (empty ( $city_des [$d ['RegionCode']] )) {
				$tmp_des ['web_value'] = $d ['RegionCode'];
				$tmp_des ['local_value'] = $d ['RegionName'];
				$this->db->insert ( 'webservice_field_config', $tmp_des );
				$des_add_count ++;
			} else {
				$updata_des = array (
						'local_value' => $d ['RegionName'] 
				);
				$this->db->where ( array (
						'hotel_id' => 0,
						'inter_id' => $inter_id,
						'webservice_name' => 'suba',
						'value_type' => 'city_code_des',
						'web_value' => $d ['RegionCode'] 
				) );
				$this->db->update ( 'webservice_field_config', $updata_des );
				$des_update_count ++;
			}
		}
		echo 'add:' . $add_count . '<br />';
		echo 'update:' . $update_count . '<br />';
		echo 'des_add_count:' . $des_add_count . '<br />';
		echo 'des_update_count:' . $des_update_count . '<br />';
		$this->change_hot_city ();
	}
	function change_hot_city() {
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$s8 = $this->Suba_hotel_ext_model->get_web_obj ();
		$inter_id = 'a455510009';
		$data = $s8->sendTo ( 'region', "GetHotCity", '' );
		$data = $data ['GetHotCityResult'] ['Content'] ['RegionModel'];
		$this->load->model ( 'common/Webservice_model' );
		$city = $this->Webservice_model->get_web_reflect ( $inter_id, 0, 'suba', array (
				'city_code' 
		), 1, 'w2l' );
		$city = empty ( $city ['city_code'] ) ? array () : $city ['city_code'];
		$tmp = array (
				'hotel_id' => 0,
				'inter_id' => $inter_id,
				'webservice_name' => 'suba',
				'value_type' => 'city_code' 
		);
		$num = count ( $data ) + 1;
		$add_count = 0;
		$update_count = 0;
		foreach ( $data as $d ) {
			if (empty ( $city [$d ['RegionCode']] )) {
				$tmp ['web_value'] = $d ['RegionCode'];
				$tmp ['local_value'] = json_encode ( array (
						'r' => $d ['RegionName'],
						'p' => $d ['PinyinName'],
						'n' => $num 
				), JSON_UNESCAPED_UNICODE );
				echo $this->db->insert_string ( 'webservice_field_config', $tmp ) . ';' . '<br />';
				$add_count ++;
			} else {
				$updata = array (
						'local_value' => json_encode ( array (
								'r' => $d ['RegionName'],
								'p' => $d ['PinyinName'],
								'n' => $num 
						), JSON_UNESCAPED_UNICODE ) 
				);
// 				$this->db->where ( array (
// 						'hotel_id' => 0,
// 						'inter_id' => $inter_id,
// 						'webservice_name' => 'suba',
// 						'value_type' => 'city_code',
// 						'web_value' => $d ['RegionCode'] 
// 				) );
				echo $this->db->update_string ( 'webservice_field_config', $updata ,array (
						'hotel_id' => 0,
						'inter_id' => $inter_id,
						'webservice_name' => 'suba',
						'value_type' => 'city_code',
						'web_value' => $d ['RegionCode'] 
				)). ';' . '<br />';
				$update_count ++;
			}
			$num --;
		}
		echo 'add:' . $add_count . '<br />';
		echo 'update:' . $update_count;
	}
	function grab_hotel() {
		set_time_limit ( 0 );
		$inter_id = 'a455510009';
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$s8 = $this->Suba_hotel_ext_model->get_web_obj (FALSE);
		$search_model = new HotelSearchModel ();
		$search_model->ArrDate = date ( 'Y-m-d', strtotime ( '+ 2 day', time () ) );
		$search_model->OutDate = date ( 'Y-m-d', strtotime ( '+ 3 day', time () ) );
		$search_model->CityCode = '';
// 		$search_model->HotelID = '3424';
		$search_model->PageIndex = 1;
		$search_model->PageSize = 2000;
		
		$web_hotels = $this->Suba_hotel_ext_model->get_web_hotel ( $search_model );
// 	var_dump($web_hotels);exit;	
		$this->db->where ( 'inter_id', $inter_id );
		$this->db->where ( 'pms_type', 'suba' );
		$this->db->where ( 'hotel_id >', 0 );
		$result = $this->db->get ( 'hotel_additions ')->result_array ();
		$hotel_ids = array ();
		foreach ( $result as $r ) {
			$hotel_ids [$r ['hotel_web_id']] = $r['hotel_id'];
		}
		
// var_dump($hotel_ids);
// var_dump($hotel_web_ids);
// var_dump($ids_diff);
// exit;
		$hotels = array ();
		$lowest = array ();
		
		$this->load->helper('calculate');
		
		foreach ( $web_hotels as $web_id => $h ) {
			if (isset($hotel_ids[$web_id]))
				continue;
			//更新酒店电话
// 			else{
// 				if(!empty($h['BizPhone']))
// 				echo $this->db->update_string('hotels',array('tel'=>$h['BizPhone']),array(
// 						'inter_id'=>'a455510007',
// 						'hotel_id'=>$hotel_ids[$web_id]
// 				)). ';<br />';
// 			}
// 			continue;
				
			$wh = $this->Suba_hotel_ext_model->get_web_hotel_detail ( $web_id );
			if (empty($wh ['HotelName']))
				$wh ['HotelName']=$web_id;
			
			$location=bd2gcj($wh['Longitude'], $wh['Latitude']);
				
			$data = array (
					'name' => $wh ['HotelName'],
					'address' => $wh ['Address'],
					'latitude' => $location ['latitude'],
					'longitude' => $location ['longitude'],
					'tel' => $wh ['BizPhone'],
					'intro' => empty ( $wh ['Introduction'] ) ? '' : $wh ['Introduction'],
					'short_intro' => $wh ['Merit'],
					'intro_img' => $wh ['HotelPic'],
					'services' => '',
					'email' => '',
					'fax' => '',
					'star' => 0,
					'country' => '中国',
					'province' => '',
					'web' => '',
					'status' => 1,
					'city' => $wh ['CityName'],
					'sort' => 0,
					'book_policy' => '' 
			);
			$hotels [$web_id] = $data;
			$lowest [$web_id] = $wh ['MinPrice'];
		}
// 		var_dump($hotels);exit;
// 		echo count($web_hotels);exit;
		$addition = array (
				'pms_auth' => '',
				'pms_room_state_way' => 1,
				'pms_member_way' => 1 
		);
		$this->load->model ( 'common/Pms_model' );
		$params = array (
				'lowest' => $lowest,
				'hotel_id' => 4567 
		);
		$this->Pms_model->update_pms_hotel ( $inter_id, 'suba', $hotels, $addition, $params );
		echo count($hotels);
	}
	
	function update_hotels() {
		set_time_limit ( 0 );
		$inter_id = 'a455510009';
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
	
		$this->db->where ( 'inter_id', $inter_id );
		$this->db->where ( 'pms_type', 'suba' );
		$this->db->where ( 'hotel_id >', 0 );
		$result = $this->db->get ( 'hotel_additions ')->result_array ();
		$no_ids=array();
		$valid_ids=array();
		$this->load->helper('calculate');
		foreach ( $result as $r ) {
			$hotel = $this->Suba_hotel_ext_model->get_web_hotel_detail ( $r['hotel_web_id'] );
			if(isset($hotel['Latitude'])){
				$valid_ids[]=$r['hotel_id'];
				$data=bd2gcj($hotel['Longitude'], $hotel['Latitude']);
				echo $this->db->update_string('hotels',array('latitude'=>$data['latitude'],'longitude'=>$data['longitude']),array('inter_id'=>$inter_id,'hotel_id'=>$r['hotel_id'])).';<br />';
			}else {
				$no_ids[]=$r['hotel_id'];
			}
		}
		echo implode(',', $valid_ids).'<br />';
		echo implode(',', $no_ids).'<br />';
	}
	
	function grab_room() {
		set_time_limit ( 0 );
		$inter_id = 'a455510007';
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$s8 = $this->Suba_hotel_ext_model->get_web_obj ();
		$search_model = new RoomSearchModel ();
		$search_model->HotelID = '';
		$search_model->ArrDate = date ( 'Y-m-d' );
		$search_model->OutDate = date ( 'Y-m-d', strtotime ( '+ 1 day', time () ) );
		
		$web_hotels = $this->Suba_hotel_ext_model->get_web_hotel ( $search_model );
		$hotels = array ();
		$lowest = array ();
		foreach ( $web_hotels as $web_id => $h ) {
			$wh = $this->Suba_hotel_ext_model->get_web_hotel_detail ( $web_id );
			$data = array (
					'name' => $wh ['HotelName'],
					'address' => $wh ['Address'],
					'latitude' => $wh ['Latitude'],
					'longitude' => $wh ['Longitude'],
					'tel' => $wh ['BizPhone'],
					'intro' => empty ( $wh ['Introduction'] ) ? '' : $wh ['Introduction'],
					'short_intro' => $wh ['Merit'],
					'intro_img' => $wh ['HotelPic'],
					'services' => '',
					'email' => '',
					'fax' => '',
					'star' => 0,
					'country' => '中国',
					'province' => '',
					'web' => '',
					'status' => 1,
					'city' => $wh ['CityName'],
					'sort' => 0,
					'book_policy' => '' 
			);
			$hotels [$web_id] = $data;
			$lowest [$web_id] = $wh ['MinPrice'];
		}
		$addition = array (
				'pms_auth' => '',
				'pms_room_state_way' => 1,
				'pms_member_way' => 1 
		);
		$this->load->model ( 'common/Pms_model' );
		$params = array (
				'lowest' => $lowest 
		);
		$this->Pms_model->update_pms_hotel ( $inter_id, 'suba', $hotels, $addition, $params );
	}
	function get_hotel_detail() {
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$s8 = $this->Suba_hotel_ext_model->get_web_hotel_detail ( '233',array('hotel_id'=>1394) );
		var_dump ( $s8 );
	}
	function get_web_hotel() {
		$inter_id = 'a455510007';
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$s8 = $this->Suba_hotel_ext_model->get_web_obj ();
		$search_model = new HotelSearchModel ();
		$search_model->ArrDate = date ( 'Y-m-d' );
		$search_model->OutDate = date ( 'Y-m-d', strtotime ( '+ 1 day', time () ) );
		$search_model->CityCode = '';
		$search_model->PageIndex = 1;
		$search_model->PageSize = 200;
		$search_model->HotelID = 3696;
		$search_model->CityCode = '110100';
		$search_model->RegionCode = '';
// 		$search_model->Keywords = '北京朝阳路大悦城青年路店';
// 		$search_model->Latitude = '23.136425';
// 		$search_model->Longitude = '113.32873';
		// $search_model->LandMarkID = '466';
		$search_model->SortType = 4;
		
		$web_hotels = $this->Suba_hotel_ext_model->get_web_hotel ( $search_model );
// 		var_dump ( $search_model );
		var_dump ( $web_hotels );
	}
	function get_web_comment_count() {
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$data = $this->Suba_hotel_ext_model->get_web_comment_count ( 'a455510007', 1099, '2028' );
		var_dump ( $data );
	}
	function get_web_comments() {
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$this->load->model ( 'common/Pms_model' );
		// $web_hotels=$this->Pms_model->get_hotels_pms_set('a455510007','suba');
		// foreach ($web_hotels as $wh){
		// if (!empty($wh['hotel_web_id'])){
		$data = $this->Suba_hotel_ext_model->get_web_comments ( 'a455510007', 1099, '148' );
		// if (count($data['GetHotelCommentsResult']['Content']['ListContent'])>1){
		// var_dump($wh['hotel_web_id']);
		var_dump ( $data );
		// exit;
		// }
		// }
		// }
		// var_dump($web_hotels);
	}
	// 骄傲店 = 1 << 0
	// 质量之星 = 1 << 1
	// 特色酒店 = 1 << 2
	function get_hotel_honor() {
		set_time_limit ( 0 );
		$inter_id = 'a455510009';
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$this->load->model ( 'common/Pms_model' );
		$web_hotels = $this->Pms_model->get_hotels_pms_set ( $inter_id, 'suba' );
		$reflect = array (
				82,
				81,
				80 
		);
		$count = count ( $reflect );
		$this->load->model ( 'hotel/Hotel_config_model' );
		$params = array ();
		$params ['effect'] = 1;
		$params ['default'] = 1;
		$data = $this->Hotel_config_model->get_hotels_config ( $inter_id, 'HOTEL', array_keys ( $web_hotels ), 'ICONS_IMG_SERACH_RESULT', $params );
		$add_count = 0;
		$update_count = 0;
		$config = array (
				'inter_id' => $inter_id,
				'module' => 'HOTEL',
				'param_name' => 'ICONS_IMG_SERACH_RESULT' 
		);
		foreach ( $web_hotels as $wh ) {
			if (! empty ( $wh ['hotel_web_id'] )) {
				$s8 = $this->Suba_hotel_ext_model->get_web_hotel_detail ( $wh ['hotel_web_id'] ,array('hotel_id'=>$wh['hotel_id']));
				$tmp = str_pad ( decbin ( $s8 ['Honour'] ), 3, 0, STR_PAD_LEFT );
				$honor = '';
				for($i = 0; $i < $count; $i ++) {
					$honor .= $tmp [$i] == 1 ? ',' . $reflect [$i] : '';
				}
				if (! empty ( $honor ))
					$honor = substr ( $honor, 1 );
				if (isset ( $data [$wh ['hotel_id']] ['ICONS_IMG_SERACH_RESULT'] )) {
					$cur = current ( $data [$wh ['hotel_id']] ['ICONS_IMG_SERACH_RESULT'] );
					$this->db->where ( 'id', $cur ['id'] );
					$this->db->update ( 'hotel_config', array (
							'param_value' => $honor 
					) );
					$update_count ++;
				} else {
					$config ['hotel_id'] = $wh ['hotel_id'];
					$config ['param_value'] = $honor;
					$this->db->insert ( 'hotel_config', $config );
					$add_count ++;
				}
			}
		}
		echo 'add_count:' . $add_count . '<br />';
		echo 'update_count:' . $update_count . '<br />';
	}
	function get_web_landmark() {
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$data = $this->Suba_hotel_ext_model->get_web_landmark ( 'a455510007', '110100' );
		var_dump ( $data );
	}
	function get_webtype_landmark() {
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$data = $this->Suba_hotel_ext_model->get_web_landmark_by_type ( 'a455510007', '110100', 6 );
		var_dump ( $data );
	}
	function get_web_order() {
		$oid=$this->input->get('o');
		if (!$oid)exit('fff');
		$this->load->model ( 'hotel/pms/Suba_hotel_model' );
		$data = $this->Suba_hotel_model->get_order_info ( array (
				'web_orderid' => $oid
		) );
		var_dump ( $data );
	}
	function add_web_comment(){
		$this->load->helper('common');
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$s8 = $this->Suba_hotel_ext_model->get_web_obj ();
		var_dump($s8->AddComment('32495781', '13955747', 1, '测试评论32495781', '111111', getIp () ));
	}
	function get_web_member(){
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$result = $this->Suba_hotel_ext_model->get_web_member ('303503087');
		var_dump($result);
	}
	function get_hotel_imgs(){
		$this->load->helper('common');
		$this->load->model ( 'hotel/pms/Suba_hotel_ext_model' );
		$s8 = $this->Suba_hotel_ext_model->get_web_obj ();
// 		$imgs
	}
	function order_test(){
		$json='{"bookInfo":{"HotelID":"409","Channel":50,"RoomTypeID":"1669","ArrDate":"2016-05-25","OutDate":"2016-05-26","HoldTime":"2016-05-25 18:00","RoomCount":"1","GuestName":"廖大雄","GuestMobile":"18819188370","RateCode":"SUPER","TotalPrice":216,"ContactName":"廖大雄","ContactMobile":"18819188370","DailyPrices":[{"RoomDay":"2016-05-25","Price":216,"BreakfastID":2,"CouponAmount":0}],"UsedAmAccount":0,"UsedCoupons":[{"UsedAmount":10,"RoomDay":"2016-05-25","CouponNo":1720072034}],"PayType":1,"PayChannelID":0,"CardNo":"305536126"}}';
// 		$json='{"bookInfo":{"HotelID":"628","Channel":50,"RoomTypeID":"2849","ArrDate":"2016-05-13","OutDate":"2016-05-14","HoldTime":"2016-05-13 18:00","RoomCount":"4","GuestName":"测试123111","GuestMobile":"18620039668","RateCode":"WEB","TotalPrice":792,"ContactName":"测试123111","ContactMobile":"18620039668","DailyPrices":[{"RoomDay":"2016-05-13","Price":198,"BreakfastID":1,"CouponAmount":0}],"UsedAmAccount":0,"UsedCoupons":0,"PayType":1,"PayChannelID":0,"CardNo":0}}';
		$searchModel=json_decode($json,true);
		var_dump($searchModel);exit;
// 		$searchModel = array(
					
// 				"bookInfo"=>$searchModel
					
// 		);
		$this->load->library ( 'Baseapi/Subaapi_webservice',array(
					
				'_testModel'=>false
		) );
		$suba = new Subaapi_webservice(false);
		$result = $suba->BookOrder($searchModel);
		var_dump($result);
	}
}
