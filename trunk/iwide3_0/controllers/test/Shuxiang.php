<?php

class Shuxiang extends MY_Controller{
	private $inter_id = 'a449675133';
	private $url = 'http://183.129.215.114:7312/ipmsgroup/CRS';
	private $mem_url = 'http://183.129.215.114:7312/ipmsgroup/';
	private $hotel_code = 'GCBZG';
	private $key = '10003';
	private $secret = '8b3d727f1ba1cde61cef63143ebab5e5';
	private $user = 'gcbzg0';
	private $pwd = '89kjanJD1k02b';
	private $hotel_group_id = 2;
	
	private $sales_channel = 'web';
	private $pms_auth;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('common');
		
		$this->pms_auth = [
			'url'             => $this->url,
			'hotelGroupId'    => $this->hotel_group_id,
			'hotelCode'       => $this->hotel_code,
			'salesChannel'    => $this->sales_channel,
			'member_url'      => $this->url,
			'weixin'          => 'weixin',
			'order_channel'   => $this->sales_channel,
			'com_memberprice' => 1,
			'src'=>'WIK',
			
			'fang_fee'        => ['0001', '0002', '0003', '0004', '0005','0006','0009'],
		    'new_upd'=>1,
		    'multi_rooms'=>1
		];
	}
	
	public function fixpms(){
		$this->db->where(['inter_id'=>$this->inter_id,'hotel_id>'=>3000])->update('hotel_additions',['pms_auth'=>json_encode($this->pms_auth)]);
	}
	
	public function upd_pms_auth(){
		$def_pms_auth='{"url":"http:\/\/115.159.18.191:8102\/ipmsgroup\/CRS","salesChannel":"DG","hotelGroupId":2,"member_url":"http:\/\/pms.myschotel.com:8090\/ipms\/","weixin":"weixin","taCode":"9030","order_channel":"DL","com_memberprice":1}';
		$pms_auth=json_decode($def_pms_auth,true);
		$merge=[
			'fang_fee'        => ['0001', '0002', '0003', '0004', '0005','0006','0009'],
			'new_upd'=>1,
			'multi_rooms'=>1
		];
		$pms_auth=array_merge($pms_auth,$merge);
		echo $this->db->update_string('hotel_additions',['pms_auth'=>json_encode($pms_auth)],['inter_id'=>$this->inter_id,'pms_type'=>'lvyun']);
	}
	
	public function catches(){
		$hotel_web_id=9;
		$hotels[$hotel_web_id] = [
			'hotelid' => $hotel_web_id,
			'name'    => '绿云测试酒店',
		];
		
		$url = $this->url . '/queryHotelList';
		$data = array(
			'date'           => date('Y-m-d', time() + 86400 * 2),
			'dayCount'       => 1,                                                                                                             
			'cityCode'       => '',
			'brandCode'      => '',
			'order'          => '1',
			'pageSize'       => 10,
			'salesChannel'   => $this->sales_channel,
			'hotelIds'       => $hotel_web_id,
			'hotelGroupId'   => $this->hotel_group_id,
		);
		$json = doCurlGetRequest($url, $data);
		exit($json);
		$arr=json_decode($json,true);
		if(!empty($arr['hrList'])){
		    $hotels[$hotel_web_id]['rooms']=$arr['hrList'][0]['rmtypes'];
		}
		file_put_contents(FD_PUBLIC.'/lvyun/test_hotel.json',json_encode($hotels));
		echo json_encode($hotels);
	}
	
	public function import_hotels(){
		$json=file_get_contents(FD_PUBLIC.'/lvyun/test_hotel.json');
		$hotels=json_decode($json,true);
		
		$additions=$rooms=[];
		
		foreach($hotels as $v){
			$data = array(
				'name'     => $v['name'],
				'inter_id' => $this->inter_id,
			);
			
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			/*if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'lvyun',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}*/
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'lvyun',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['hotelid'],
				'pms_room_state_way' => 3,
				'pms_member_way'     => 1,
			];
			
			if(!empty($v['rooms'])){
				foreach($v['rooms'] as $t){
					$rooms[] = array(
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['descript'],
						'description' => '',
						'sub_des'     => '',
						'nums'        => 0,
						'bed_num'     => 0,
						//						'sort'        => $t['Sort'],
						'webser_id'   => $t['code'],
					);
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
	
	public function login(){
		$data = [
			'hotelGroupCode' => $this->hotel_code,
			'usercode'       => $this->user,
			'password'       => $this->pwd,
			'method'         => 'user.login',
			'local'          => 'zh_CN',
			'format'         => 'json',
			'appKey'         => $this->key,
		];
		$sign_arr = $this->sign($data);
		$data['sign'] = $sign_arr['sign'];
		$url = 'http://183.129.215.114:7312/ipmsgroup/router';
		$json = doCurlGetRequest($url, $data);
//		exit(json_encode($data));
//		exit($json);
		print_r([
			'request'  => $data,
			'sign_str' => $sign_arr['string'],
			'response' => json_decode($json, true),
		]);
	}
	
	public function rooms(){
		
		$url = $this->url . '/queryHotelList';
		$data = array(
			'date'           => date('Y-m-d', time() + 86400 * 2),
			'dayCount'       => 1,
			'cityCode'       => '',
			'brandCode'      => '',
			'order'          => '1',
			//			'firstResult' => 0,
			'pageSize'       => 10,
			//			'rateCodes' => '',
			'salesChannel'   => $this->sales_channel,
			'hotelIds'       => '9',
			/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
			'hotelGroupId'   => $this->hotel_group_id,
			'sessionId'      => '2369633B19BD4027A83904F7C757BD04',
			'appKey'         => $this->key,
			'hotelGroupCode' => $this->hotel_code,
		);
		$sign_arr = $this->sign($data);
		$data['sign'] = $sign_arr['sign'];
		$json = doCurlGetRequest($url, $data);
		exit($json);
	}
	
	public function book(){
//		$json = '{"arr":"2017-06-20 12:00:00","dep":"2017-06-21 12:00:00","rmtype":"DXK","rateCode":"BAR","src":"WIK","rmNum":"3","rsvMan":"金房卡测试","sex":"0","mobile":"18888888888","email":"","idType":"01","idNo":"","cardType":"","cardNo":"","adult":"1","remark":"微信订单。使用优惠券：0.00。积分抵扣：0.00。","disAmount":"","market":"WAK","salesChannel":"WEB","hotelId":"9","hotelGroupId":2,"everyDayRate":"[{\"date\":\"2017-06-22\",\"realRate\":\"0.01\"},{\"date\":\"2017-06-23\",\"realRate\":\"0.01\"},{\"date\":\"2017-06-24\",\"realRate\":\"0.01\"}]","weixin":"weixin","channel":"WEB"}';
//		$data = json_decode($json, true);
		
		$every_rate = [];
		$in_day = 3;
		for($i = 0; $i < $in_day; $i++){
			$every_rate[] = [
				'date'     => date('Y-m-d', time() + 86400 * $i),
				'realRate' => '3',
			];
		}
		$data = [
			'arr'          => date('Y-m-d') . ' 12:00:00',
			'dep'          => date('Y-m-d', time() + 86400 * $in_day) . ' 12:00:00',
			'rmtype'       => 'DXK',
			'rateCode'     => 'BAR',
			'src'          => 'WIK',
			'rmNum'        => 3,
			'rsvMan'       => '金房卡测试',
			'sex'          => '1',
			'mobile'       => '18888888888',
			'email'        => '',
			'idType'       => '01',
			'idNo'         => '',
			'cardType'     => '',
			'cardNo'       => '',
			'adult'        => 1,
			'remark'       => '微信订单。使用优惠券：0.00。积分抵扣：0.00。',
			'disAmount'    => '',
			'market'       => 'WAK',
			'salesChannel' => 'WEB',
			'hotelId'      => 9,
			'hotelGroupId' => 2,
			'everyDayRate' => json_encode($every_rate),
			'weixin'       => 'weixin',
			'channel'      => 'WEB'
		];
//		$data['hotelGroupCode']=$this->hotel_code;
//		$data['appKey']=$this->key;
//		$data['sessionId']='2369633B19BD4027A83904F7C757BD04';

//		$sign_arr=$this->sign($data);
//		print_r($sign_arr);
//		$data['sign']=$sign_arr['sign'];
//		print_r($data);
		$url = $this->url . '/book';
		$json = doCurlGetRequest($url, $data);
		exit($json);
	}
	
	public function query(){
		$web_orderid = 'X1706260014';
		$url = $this->url . '/findResrvGuest';
		$data = array(
			"cardNo"       => "",
			"crsNo"        => $web_orderid,
			"hotelGroupId" => $this->hotel_group_id,
		);
		$json = doCurlGetRequest($url, $data);
		echo $json;
		
	}
	
	public function query_sub(){
//		$web_orderid='X1706200003';
//		$web_orderid='X1706210007';
//		$web_orderid='X1706220015';
//		$web_orderid = 'X1706220016';
//		$web_orderid='X1706220017';
//		$web_orderid='X1706260014';
		$web_orderid = 'X1706260031';
//		$web_orderid='X1706260032';
		$data = [
			'crsNo'        => $web_orderid,
			'hotelGroupId' => $this->hotel_group_id,
			//		    'hotelId'=>9,
			//		    'masterId'=>'',
			//		    'roomNo'=>'',
		];
		$url = $this->url . '/orderInfo';
		
		$json = doCurlGetRequest($url, $data);
		echo $json;
	}
	
	public function query_amt(){
		set_time_limit(0);
		$web_orderid = 'X1706220017';
//		$web_orderid='X1706210007';
		$data = [
//			'accnt'        => 3995,
//			'crsNo'=>$web_orderid,
'hotelGroupId' => $this->hotel_group_id,
'hotelId'      => 9,
//		    'masterId'=>'',
//		    'roomNo'=>'',
		];
		$url = $this->url . '/simpleAccount';
//		for($i = 3800; $i < 4100; $i++){
		$data['accnt'] = 4309;
		$json = doCurlGetRequest($url, $data);
		$res = json_decode($json, true);
//			if($res['resultCode'] == 0 && !empty($res['result'])){
		exit($json);
//			}

//		}
		
	}
	
	public function sign($data){
		ksort($data, SORT_STRING);
//		echo json_encode($data);  exit;
		$key_str = $this->secret;
		foreach($data as $k => $v){
			$key_str .= $k . $v;
		}
		$key_str .= $this->secret;
		return [
			'string' => $key_str,
			'sign'   => strtoupper(sha1($key_str)),
		];
	}
	
	
	public function price_set(){
		$params = array();
		$room_list = $this->db->from('hotel_rooms')->where(array('inter_id' => $this->inter_id))->get()->result_array();
		foreach($room_list as $v){
			for($t = 8; $t < 45; $t++){
				$params[] = array(
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $t,
					'edittime'   => time(),
					'status'     => 1,
				);
			}
		}
		if($params){
//			echo json_encode($params);
			$this->db->insert_batch('hotel_price_set', $params);
		}
		echo 'success';
	}
	
	public function merge_set(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/sx_rooms.json');
		$room_list = json_decode($json, true);
		$params = array();
		foreach($room_list as $v){
			for($t = 55; $t <= 57; $t++){
				$params[] = array(
					'inter_id'   => $v['inter_id'],
					'hotel_id'   => $v['hotel_id'],
					'room_id'    => $v['room_id'],
					'price_code' => $t,
					'edittime'   => time(),
					'status'     => 1,
				);
			}
		}
		$db = $this->load->database('default', true);
		if($params){
//			echo json_encode($params);
			$db->insert_batch('hotel_price_set_copy', $params);
		}
		echo 'success';
	}
}