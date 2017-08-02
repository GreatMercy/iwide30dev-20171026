<?php

class Yayue extends MY_Controller{
//	private $inter_id = 'a495681515'; //开发
	private $inter_id = 'a495509426';
	private $base_url = 'http://pms.beyondh.com:7998/Service/';
	private $key = 'weixin';
	private $signkey = 'weixin';
	
	private $pms_auth;
	private $serv_api;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('common');
		$this->pms_auth = [
			'base_url'        => $this->base_url,
			'key'             => $this->key,
			'signkey'         => $this->signkey,
			'order_with_user' => true,
			'fee_items'       => ['D1000', 'D1001', 'D1002', '1003', 'D1004', 'D1005', 'D1020'],
			'sub_item_type'   => ['point' => 'C9150', 'weixin' => 'C9240', 'balance' => 'C9130'],
			'paytype'         => ['weixin' => 'WeChat']
		];
		$pms_auth = $this->pms_auth;
		$pms_auth['inter_id'] = $this->inter_id;
		$this->load->model('hotel/pms/Beyondh2_hotel_model', 'pms');
		$this->serv_api = new Beyondh2Api();
		$this->serv_api->setPmsAuth($pms_auth);
	}
	
	public function fixauth(){
		$this->db->where(['inter_id'=>$this->inter_id])->update('hotel_additions',['pms_auth'=>json_encode($this->pms_auth)]);
	}
	
	public function get_hotels(){
		set_time_limit(900);
		$url = $this->base_url . 'Order/HotelService.svc?wsdl';
		$location = $this->base_url . 'Order/HotelService.svc/Basic';
		
		$soap = new SoapClient($url, array(
			'location'     => $location,
			'soap_version' => SOAP_1_1,
			'encoding'     => 'utf-8'
		));
		$unixExpireTimestamp = time() + 86400;
		
		
		$paras = array('pageIndex' => 1, 'pageSize' => 1000);
		$signature = $this->beyondh_sign($paras, $unixExpireTimestamp, $this->signkey, $this->key);
		$paras['unixExpireTimestamp'] = $unixExpireTimestamp;
		$paras['signature'] = $signature;
		$hotel_res = $soap->__soapCall("GetAllHotels", array("parameters" => $paras));
		$hotel = [];
		if($hotel_res->GetAllHotelsResult->Success == 'true'){
			$hotel_list = obj2array($hotel_res->GetAllHotelsResult->Content->HotelSearchResponse);
			foreach($hotel_list as $v){
				$v['rooms'] = [];
				$paras = array('hotelId' => $v['HotelId']);
				$signature = $this->beyondh_sign($paras, $unixExpireTimestamp, $this->signkey, $this->key);
				$paras['unixExpireTimestamp'] = $unixExpireTimestamp;
				$paras['signature'] = $signature;
				$room_res = $soap->__soapCall("GetHotelRoomTypes", array("parameters" => $paras));
				if($room_res->GetHotelRoomTypesResult->Success == 'true' && !empty($room_res->GetHotelRoomTypesResult->Content->RoomType)){
					$v['rooms'] = obj2array($room_res->GetHotelRoomTypesResult->Content->RoomType);
				}
				$hotel[] = $v;
			}
		}
		
		file_put_contents(FD_PUBLIC . '/yayue/hotel_test.json', json_encode($hotel));
		
		echo json_encode($hotel);
	}
	
	public function catches(){
		$json = file_get_contents(FD_PUBLIC . '/yayue/hotel_test.json');
//		exit($json);
		$hotels = json_decode($json, true);
		$service_icon = array(
			'WiFi'   => '&#xe8;',
			'吹风机'    => '&#xe4;',
			'停车场'    => '&#xe7;',
			'24小时热水' => '&#xeb;',
			'餐饮'     => '&#xea;',
			'中餐厅'    => '&#xea;',
		);
		
		$additions = $rooms = $icons = [];
		foreach($hotels as $v){
			
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['Name'],
				'address'     => $v['Address'],
				'tel'         => $v['Phone'],
				'fax'         => $v['Fax'],
				'intro'       => $v['Name'],
				'short_intro' => $v['Name'],
				'city'        => $v['CityName'],
				'province'    => '',
				'star'        => $v['Star'],
				'latitude'    => $v['Latitude'],
				'longitude'   => $v['Longitude'],
			];
			
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'beyondh2',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'beyondh2',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['HotelId'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			
			if(!empty($v['rooms'])){
				is_array(current($v['rooms'])) or $v['rooms'] = [$v['rooms']];
				foreach($v['rooms'] as $t){
					$rooms[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['RoomTypeName'],
						'description' => $t['Description'],
						'webser_id'   => $t['Id'],
						'bed_num'     => $t['BedAmount'],
					];
				}
			}
			
			if(!empty($v['ServiceTags'])){
				is_array($v['ServiceTags']['string']) or $v['ServiceTags']['string'] = [$v['ServiceTags']['string']];
				foreach($v['ServiceTags']['string'] as $t){
					if(isset($service_icon[$t])){
						$icons[] = [
							'inter_id'  => $this->inter_id,
							'hotel_id'  => $hotel_id,
							'type'      => 'hotel_service',
							'room_id'   => 0,
							'image_url' => $service_icon[$t],
							'info'      => $t,
						];
					}
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
	
	public function getprice(){
		$hotel_web_id = '2147483644';
		$sdate = date('Y-m-d');
		$edate = date('Y-m-d', time() + 86400);
		
		$res = $this->serv_api->getRoomState($hotel_web_id, $sdate, $edate);
		echo json_encode($res);
	}
	
	public function getclock(){
		$sdate = date('Y-m-d');
		$hotel_web_id = '2147483644';
		$res = $this->serv_api->getHourPrice($hotel_web_id, $sdate);
		print_r($res);
		
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
		}else{
			if($paras === false){
				$s .= 'false';
			}else{
				if($paras === true){
					$s .= 'true';
				}else{
					if(is_array($paras) || is_object($paras)){
						ksort($paras, SORT_STRING);
						foreach($paras as $k => $pa){
							$s .= $this->sign_string($pa);
						}
					}else{
						if(strtotime($paras) && strstr($paras, 'T') !== false && $paras != 'T'){
							$s .= date('Y-m-d H-i-s', strtotime($paras));
						}else{
							if(strstr($paras, 'E+')){
								$paras = number_format($paras, 0, '', '');
								$s .= $paras;
							}else{
								$s .= $paras;
							}
						}
					}
				}
			}
		}
		return $s;
	}
	
	public function priceset(){
		set_time_limit(900);
		$rooms = $this->db->from('hotel_rooms')->where([
			'inter_id' => $this->inter_id,
		])->get()->result_array();
		$params = [];
		foreach($rooms as $v){
			for($i = 1; $i <= 5; $i++){
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
	
	public function pointPay(){
		$hotel_web_id = '136565963849729';
		$payment_id = 0;
		$price = 50;
		$extra = [
			'payment_feetype' => 'A',
			'bill_id'         => '589374176444495',
			'sub_item_type'   => $this->pms_auth['sub_item_type']['point'],
			'bill_item_type'  => 'Credit',
			'remark'          => '测试积分兑换入账',
			'amount'          => '1000',
		];
		var_dump($this->serv_api->addPayment($hotel_web_id, $payment_id, $price, $extra));
	}
	
	public function test_bill(){
		$json='{"id":"18458","inter_id":"a495509426","orderid":"94149664581769431","coupon_favour":"0.00","complete_reward_given":"1","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"1","complete_point_info":"","web_orderid":"593262160724011","room_codes":"{\"25271\":{\"code\":{\"price_type\":\"common\",\"extra_info\":{\"type\":\"code\",\"pms_code\":\"\\u975e\\u4f1a\\u5458\",\"orign_price\":\"279.00\",\"is_clock\":false,\"promotion_id\":\"\",\"virtual\":false,\"webser_id\":\"\\u9ebb\\u5c06\\u53cc\"}},\"room\":{\"webser_id\":\"\\u9ebb\\u5c06\\u53cc\"},\"payment_id\":\"593269291040846\"}}","web_paid":"0","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","refund":"0","third_favour_info":"","complete_balance_given":"1","complete_balance_info":"","balance_refund":"0","hotel_id":"5146","openid":"oBWOYv-WZ4se-RY6wq5SBqgH3p94","price":"279.00","roomnums":"1","name":"开发者","tel":"18888888888","order_time":"1496645817","startdate":"20170605","enddate":"20170606","paid":"0","status":"1","holdtime":"2017-06-05 18:00","paytype":"weixin","isdel":"0","operate_reason":null,"remark":"","member_no":"9674319","jfk_member_no":"JFK9574314646342","handled":"0","mt_pms_orderid":"","starttime":"0000-00-00 00:00:00","price_type":"common","channel":"weixin","is_invoice":"1","link_saler":"0","own_saler":"0","link_f_saler":"0","own_f_saler":"0","email":"","customer_remark":"","hname":"华夏一品酒店","himg":null,"haddress":"沪闵路289号","longitude":"121.435865","latitude":"31.159439","htel":"85772888","order_datetime":"2017-06-05 14:56:57","order_details":[{"id":"19722","orderid":"94149664581769431","inter_id":"a495509426","room_id":"25271","iprice":"279.00","startdate":"20170605","enddate":"20170606","istatus":"1","allprice":"279","room_no":"","roomname":"麻将双","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"5","room_no_id":"0","price_code_name":"门市价","handled":"0","webs_orderid":"","real_allprice":"279","club_id":"","leavetime":null,"item_hotel_id":"5146","mt_room_id":"","breakfast_nums":"","customer":null,"inners":"","sub_id":"19722"}],"first_detail":{"id":"19722","orderid":"94149664581769431","inter_id":"a495509426","room_id":"25271","iprice":"279.00","startdate":"20170605","enddate":"20170606","istatus":"1","allprice":"279","room_no":"","roomname":"麻将双","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"5","room_no_id":"0","price_code_name":"门市价","handled":"0","webs_orderid":"","real_allprice":"279","club_id":"","leavetime":null,"item_hotel_id":"5146","mt_room_id":"","breakfast_nums":"","customer":null,"inners":"","sub_id":"19722"},"status_des":"已确认","show_orderid":"593262160724011"}';
		$order=json_decode($json,true);
		
		$json='{"inter_id":"a495509426","hotel_id":"5146","pms_type":"beyondh2","pms_auth":"{\"base_url\":\"http:\\\/\\\/pms.beyondh.com:7998\\\/Service\\\/\",\"key\":\"weixin\",\"signkey\":\"weixin\",\"order_with_user\":true,\"fee_items\":[\"D1000\",\"D1001\",\"D1002\",\"1003\",\"D1004\",\"D1005\",\"D1020\"],\"sub_item_type\":{\"point\":\"C9150\",\"weixin\":\"C9240\",\"balance\":\"C9130\"},\"paytype\":{\"weixin\":\"WeChat\"}}","hotel_web_id":"136565963849729","pms_room_state_way":"4","pms_member_way":"1"}';
		$pms_set=json_decode($json,true);
		$inter_id=$order['inter_id'];
		
		$res=$this->pms->add_web_bill($order['web_orderid'],$order,$pms_set,$order['orderid']);
		var_dump($res);
	}
}