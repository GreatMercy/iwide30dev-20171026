<?php

class Huali extends MY_Controller{
	
	/*private $url = 'http://xop.test.foxhis.com/xmsopen-web/rest';
	private $appkey = 'ZHHL';
	private $secret = 'w99s8KFp3MBCB3Bhpum';
	private $cmmcode = 'ZHHL';
	private $sign_hotelid = 'G000001';
	private $inter_id = 'a499671615';//测试*/
	
	private $url = 'http://zhhl.xms.foxhis.com/xmsopen-web/rest';
	private $appkey = 'ZHHL';
	private $secret = 'w99s8KFp3MBCB3Bhpum';
	private $cmmcode = 'WXJFK';
	private $sign_hotelid = 'G000001';
	private $inter_id = 'a500000398';
	private $src = 'THC';
	private $market = 'OWE';
	
	private $pms_auth;
	
	public function __construct(){
		parent::__construct();
		
		$conf = [
			'url'                => $this->url,
			'appkey'             => $this->appkey,
			'secret'             => $this->secret,
			'cmmcode'            => $this->cmmcode,
			'loc'                => 'zh_CN',
			'sign_hotelid'       => $this->sign_hotelid,
			'src'                => $this->src,
			'market'             => $this->market,
			'restype'            => [
				'normal' => 'R01',
			],
			'pay_code'           => [
				'weixin' => '9060',
			],
			'first_night_coupon' => 1,
			'local_price_name'=>1
		];
		
		$this->pms_auth=$conf;
		print_r($this->pms_auth);exit;
		
		$conf['inter_id'] = $this->inter_id;
		
		if($this->session->userdata($this->inter_id . ':sess')){
			$conf['sess'] = $this->session->userdata($this->inter_id . ':sess');
		}
		$this->load->library('Baseapi/Xiruanapi_new', $conf, 'serv_api');
		
	}
	
	public function fix(){
		/*$row=$this->db->from('hotel_additions')->where(['inter_id'=>$this->inter_id,'hotel_id'=>0])->get()->row_array();
		$pms_auth=json_decode($row['pms_auth'],true);
		$pms_auth['sign_hotelid']=$this->sign_hotelid;
		$this->db->update('hotel_additions',['pms_auth'=>json_encode($pms_auth)],['inter_id'=>$this->inter_id]);*/
		$this->db->update('hotel_additions', [
			'pms_auth' => json_encode($this->pms_auth)
		], ['inter_id' => $this->inter_id]);
	}
	
	public function login(){
		$params = [
			'appkey'  => $this->appkey,
			'secret'  => $this->secret,
			'method'  => 'xmsopen.public.login',
			'ver'     => '1.0.0',
			'hotelid' => $this->sign_hotelid,
			'loc'     => 'zh_CN',
			'ts'      => time(),
		];
		
		$params['sign'] = $this->sign($params);
		$json = json_encode($params);
		$res = $this->curl_post_json($this->url, $json);
		$res = json_decode($res, true);
		if($res['success']){
			$this->session->set_userdata($this->inter_id . ':sess', $res['session']);
			return $res['session'];
		}
		return null;
	}
	
	public function hotels(){
		set_time_limit(900);
		if($this->session->userdata($this->inter_id . ':sess')){
			$session_id = $this->session->userdata($this->inter_id . ':sess');
		}else{
			$session_id = $this->login();
		}
		
		$params = [
			'appkey'  => $this->appkey,
			'session' => $session_id,
			'method'  => 'xmsopen.reservation.xopgetcity',
			'ver'     => '1.0.0',
			'hotelid' => $this->sign_hotelid,
			'loc'     => 'zh_CN',
			'ts'      => time(),
			'cmmcode' => $this->cmmcode,
		];
		
		$params['sign'] = $this->sign($params);
		$json = json_encode($params);
		$res = $this->curl_post_json($this->url, $json);
		$result = json_decode($res, true);
		if($result['success'] && !empty($result['results'])){
			$hotels = [];
			$fail = [];
			foreach($result['results'] as $v){
				$params = [
					'appkey'  => $this->appkey,
					'session' => $session_id,
					'method'  => 'xmsopen.reservation.xopqueryhotel',
					'ver'     => '1.0.0',
					'hotelid' => $this->sign_hotelid,
					'loc'     => 'zh_CN',
					'ts'      => time(),
					'cmmcode' => $this->cmmcode,
					'params'  => [
						['city' => $v['seq']]
					]
				];
				
				$params['sign'] = $this->sign($params);
				
				$json = json_encode($params);
				$res = $this->curl_post_json($this->url, $json);
				$list = json_decode($res, true);
				if(!empty($list['results'])){
					foreach($list['results'] as $t){
						$t['city'] = $v['des'];
						$hotels[] = $t;
					}
				}else{
					$fail[] = ['request' => $params, 'response' => $list];
				}
			}
			
			
			foreach($hotels as &$v){
				$params = [
					'appkey'  => $this->appkey,
					'session' => $session_id,
					'method'  => 'xmsopen.reservation.xopgetroomtype',
					'ver'     => '1.0.0',
					'hotelid' => $this->sign_hotelid,
					'loc'     => 'zh_CN',
					'ts'      => time(),
					'cmmcode' => $this->cmmcode,
					'params'  => [
						['hotelid' => $v['hotelid']]
					]
				];
				$params['sign'] = $this->sign($params);
				
				$json = json_encode($params);
				$res = $this->curl_post_json($this->url, $json);
				$list = json_decode($res, true);
				if(!empty($list['results'])){
					$v['rooms'] = $list['results'];
				}else{
					$v['rooms'] = [];
				}
			}
			if($fail && empty($hotels)){
				echo json_encode($fail);
				exit;
			}
			reset($hotels);
			file_put_contents(FD_PUBLIC.'/huali/hotel_prod.json',json_encode($hotels));
			echo json_encode($hotels);
//			$this->catches($hotels);
		}else{
			echo $res;
		}
		
	}
	
	public function catches($hotels){
		/*'&#xe7;':'停车','&#xed;':'接机服务','&#xe5;':'叫醒服务','&#xe9;':'行李寄存','&#xea;':'餐厅','&#xe8;':'Wifi','&#xeb;':'热水'
房间服务图标字体代码：
'&#xe3;':'上网','&#xe5;':'叫醒服务','&#xe9;':'行李寄存','&#xe4;':'吹风机','&#xe8;':'Wifi','&#xeb;':'热水'*/
		
		$icon_arr = [
			[
				'code' => '&#xe8;',
				'name' => 'WIFI',
			],
			[
				'code' => '&#xe7;',
				'name' => '停车场',
			],
			[
				'code' => '&#xea;',
				'name' => '餐厅',
			],
			[
				'code' => '&#xe9;',
				'name' => '行李寄送',
			],
			[
				'code' => '&#xe3;',
				'name' => '免费上网',
			],
		];
		
		$additions = [];
		$rooms = [];
		$lowest = [];
		$icons = [];
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['des'],
				'address'     => $v['addr'],
				'tel'         => $v['phone'],
				'intro'       => '',
				'short_intro' => '',
				'city'        => $v['city'],
				'status'      => $v['sta'] == 'I' ? 1 : 0,
				'sort'        => $v['seq'],
				'star'        => (int)$v['star'],
				'latitude'    => $v['latitude'],
				'longitude'   => $v['longitute'],
			];
			
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'xiruaniw',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'xiruaniw',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['hotelid'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			
			$lowest[] = [
				'hotel_id'     => $hotel_id,
				'inter_id'     => $this->inter_id,
				'lowest_price' => $v['price'],
				'update_time'  => date('Y-m-d H:i:s'),
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
						'name'        => $t['des'],
						'description' => $t['des1'],
						'sub_des'     => isset($t['detailinfo']) ? $t['detailinfo'] : '',
						'webser_id'   => $t['rmtype'],
					];
				}
			}
		}
		
		if($additions){
			$this->db->insert_batch('hotel_additions', $additions);
		}
		if($lowest){
			$this->db->insert_batch('hotel_lowest_price', $lowest);
		}
		if($icons){
			$this->db->insert_batch('hotel_images', $icons);
		}
		if($rooms){
			$this->db->insert_batch('hotel_rooms', $rooms);
		}
		echo 'success';
	}
	
	public function prod_catch(){
		/*'&#xe7;':'停车','&#xed;':'接机服务','&#xe5;':'叫醒服务','&#xe9;':'行李寄存','&#xea;':'餐厅','&#xe8;':'Wifi','&#xeb;':'热水'
房间服务图标字体代码：
'&#xe3;':'上网','&#xe5;':'叫醒服务','&#xe9;':'行李寄存','&#xe4;':'吹风机','&#xe8;':'Wifi','&#xeb;':'热水'*/
		
		$icon_arr = [
			[
				'code' => '&#xe8;',
				'name' => 'WIFI',
			],
			[
				'code' => '&#xe7;',
				'name' => '停车场',
			],
			[
				'code' => '&#xea;',
				'name' => '餐厅',
			],
			[
				'code' => '&#xe9;',
				'name' => '行李寄送',
			],
			[
				'code' => '&#xe3;',
				'name' => '免费上网',
			],
		];
		
		$json = file_get_contents(FD_PUBLIC . '/huali_hotels_pms.json');
		$hotels = json_decode($json, true);
		$additions = [];
		$rooms = [];
		$lowest = [];
		$icons = [];
		$db = $this->load->database('default', true);
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['des'],
				'address'     => $v['addr'],
				'tel'         => $v['phone'],
				'intro'       => '',
				'short_intro' => '',
				'city'        => $v['city'],
				'status'      => $v['sta'] == 'I' ? 1 : 0,
				'sort'        => $v['seq'],
				'star'        => (int)$v['star'],
				'latitude'    => $v['latitude'],
				'longitude'   => $v['longitute'],
			];
			
			$db->insert('hotels_copy', $data);
			$hotel_id = $db->insert_id();
			
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'xiruaniw',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'xiruaniw',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['hotelid'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			
			$lowest[] = [
				'hotel_id'     => $hotel_id,
				'inter_id'     => $this->inter_id,
				'lowest_price' => $v['price'],
				'update_time'  => date('Y-m-d H:i:s'),
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
						'name'        => $t['des'],
						'description' => $t['des'],
						'sub_des'     => isset($t['detailinfo']) ? $t['detailinfo'] : '',
						//						'nums'        => 0,
						//						'bed_num'     => $t['BedCount'],
						//						'sort'        => $t['Sort'],
						'webser_id'   => $t['rmtype'],
					];
//					$db->insert('hotel_rooms',$rooms);
//					$room_id=$db->
				}
			}
		}
		
		if($additions){
			$db->insert_batch('hotel_additions_copy', $additions);
		}
		if($lowest){
//			$db->insert_batch('hotel_lowest_price', $lowest);
		}
		if($icons){
			$db->insert_batch('hotel_images_copy', $icons);
		}
		if($rooms){
			$db->insert_batch('hotel_rooms_copy', $rooms);
		}
		echo 'success';
	}
	
	
	function curl_post_json($url, $json){
		$header[] = "Content-type: text/json";
		$ch = curl_init((string)$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		$response = curl_exec($ch);
		if(curl_errno($ch)){
			curl_close($ch);
			return json_encode([
				'success' => false,
			]);
		}else{
			curl_close($ch);
			return $response;
		}
	}
	
	function sign($data){
		$sign_text = $data['appkey'] . $data['hotelid'] . $data['loc'] . $data['ts'];
		
		if(!empty($data['params'])){
			$params = $data['params'];
			
			ksort($params);
			foreach($params as $v){
				$sign_param = strtoupper($this->sign_string($v));
				$sign_text .= $sign_param;
			}
		}
		return md5($sign_text);
	}
	
	function sign_string($str){
		$string = '';
		if(is_null($str)){
			return '';
		}else{
			if($str === false){
				$string .= 'false';
			}elseif($str === true){
				$string .= 'true';
			}else{
				if(is_array($str) || is_object($str)){
					ksort($str, SORT_STRING);
					foreach($str as $k => $v){
						$string .= $this->sign_string($v);
					}
				}else{
					if(strtotime($str) && strstr($str, 'T') !== false && $str != 'T'){
						$string .= strtotime($str) . '0000';
					}else{
						if(strstr($str, 'E+')){
							$str = number_format($str, 0, '', '');
							$string .= $str;
						}else{
							$string .= $str;
						}
					}
				}
			}
		}
		return $string;
	}
	
	public function lowest(){
		/*$json = file_get_contents(FD_PUBLIC . '/huali_hotels_pms.json');
		$hotels = json_decode($json, true);*/
		set_time_limit(900);
		$db = $this->load->database('default', true);
		$hotels = $db->from('hotel_additions_copy')->where([
			'inter_id'  => $this->inter_id,
			'hotel_id>' => 0
		])->get()->result_array();
		$lowest = [];
		foreach($hotels as $v){
			$hotel_web_id = $v['hotel_web_id'];
			$min = [];
			$res = $this->serv_api->getRoomDailyPrice($hotel_web_id, date('Y-m-d'), date('Y-m-d', time() + 86400));
			foreach($res as $t){
				$min[] = $t['rate'];
			}
			if($min){
				$lowest[] = [
					'hotel_id'     => $v['hotel_id'],
					'inter_id'     => $v['inter_id'],
					'lowest_price' => min($min),
					'update_time'  => date('Y-m-d H:i:s'),
				];
			}
			
		}
		if($lowest){
			$db->insert_batch('hotel_lowest_price_copy', $lowest);
		}
		echo 'success';
	}
	
	public function testroomtype(){
		
		$hotel_web_id = 'H000026';
		
		set_time_limit(900);
		
		$pms_data = [];
//			$pms_data[$v['hotelid']]['qty'] = $this->serv_api->getRoomQty($hotel_web_id, date('Y-m-d'), date('Y-m-d', time() + 86400));
		$pms_data[$hotel_web_id]['daily'] = $this->serv_api->getRoomDailyPrice($hotel_web_id, date('Y-m-d'), date('Y-m-d', time() + 86400 * 10));
//			$pms_data[$v['hotelid']]['price'] = $this->serv_api->getRoomPrice($hotel_web_id, date('Y-m-d'), date('Y-m-d', time() + 86400), null, null, 3);
		/*$promo = [
			'hotelid' => $hotel_web_id,
			'arr'     => date('Y-m-d'),
			'dep'     => date('Y-m-d', time() + 86400 * 3)
		];
		$pms_data[$v['hotelid']]['promo'] = $this->serv_api->getRoomPromoPrice($promo);*/
		
		
		echo json_encode($pms_data);
	}
	
	public function test_bill(){
		$json = '{"id":"659552","inter_id":"a475288456","orderid":"94147591331877251","coupon_favour":"0.00","complete_reward_given":"0","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"0","complete_point_info":"","web_orderid":"C16A080001","room_codes":"{\"14835\":{\"code\":{\"price_type\":\"pms\",\"extra_info\":{\"type\":\"code\",\"pms_code\":\"RACK\",\"pkg\":\"NET\",\"bonus_rate\":false}},\"room\":{\"webser_id\":\"BK\"}}}","web_paid":"0","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","refund":"0","hotel_id":"4027","openid":"oBWOYv-WZ4se-RY6wq5SBqgH3p94","price":"507.00","roomnums":"3","name":"\u5f00\u53d1","tel":"18888888888","order_time":"1475913318","startdate":"20161008","enddate":"20161009","paid":"0","status":"0","holdtime":"18:00","paytype":"daofu","isdel":"0","operate_reason":null,"remark":"","member_no":"JFK2880003539537","handled":"0","hname":"\u5929\u6d25\u706b\u8f66\u7ad9\u5510\u5bb6\u53e3\u5e97","himg":null,"haddress":"\u5929\u6d25\u5e02\u6cb3\u4e1c\u533a\u536b\u56fd\u905369\u53f7","longitude":"","latitude":"","htel":"022-58903777\u8f6c0      ","order_datetime":"2016-10-08 15:55:18","order_details":[{"id":"694978","orderid":"94147591331877251","inter_id":"a475288456","room_id":"14835","iprice":"169.00","startdate":"20161008","enddate":"20161009","istatus":"0","allprice":"169.0000","room_no":"","roomname":"\u5546\u52a1\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"RACK","room_no_id":"0","price_code_name":"\u6563\u5ba2[\u95e8\u5e02\u4ef7]","handled":"0","webs_orderid":"","real_allprice":"169","club_id":"","grade_all_id":"0","grade_status":"0","leavetime":null,"sub_id":"694978"},{"id":"694979","orderid":"94147591331877251","inter_id":"a475288456","room_id":"14835","iprice":"169.00","startdate":"20161008","enddate":"20161009","istatus":"0","allprice":"169.0000","room_no":"","roomname":"\u5546\u52a1\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"RACK","room_no_id":"0","price_code_name":"\u6563\u5ba2[\u95e8\u5e02\u4ef7]","handled":"0","webs_orderid":"","real_allprice":"169","club_id":"","grade_all_id":"0","grade_status":"0","leavetime":null,"sub_id":"694979"},{"id":"694980","orderid":"94147591331877251","inter_id":"a475288456","room_id":"14835","iprice":"169.00","startdate":"20161008","enddate":"20161009","istatus":"0","allprice":"169.0000","room_no":"","roomname":"\u5546\u52a1\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"RACK","room_no_id":"0","price_code_name":"\u6563\u5ba2[\u95e8\u5e02\u4ef7]","handled":"0","webs_orderid":"","real_allprice":"169","club_id":"","grade_all_id":"0","grade_status":"0","leavetime":null,"sub_id":"694980"}],"first_detail":{"id":"694978","orderid":"94147591331877251","inter_id":"a475288456","room_id":"14835","iprice":"169.00","startdate":"20161008","enddate":"20161009","istatus":"0","allprice":"169.0000","room_no":"","roomname":"\u5546\u52a1\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"RACK","room_no_id":"0","price_code_name":"\u6563\u5ba2[\u95e8\u5e02\u4ef7]","handled":"0","webs_orderid":"","real_allprice":"169","club_id":"","grade_all_id":"0","grade_status":"0","leavetime":null,"sub_id":"694978"},"ori_price":"507.00"}';
		$order = json_decode($json, true);
		
		$json = '{"inter_id":"a475288456","hotel_id":"4027","pms_type":"xiruan","pms_auth":"{\"url\":\"http:\\\/\\\/123.233.118.91:8039\\\/xmsopen-web\\\/rest\",\"appkey\":\"WX1601\",\"secret\":\"msmMIvXW0SNMDIhK9cL\",\"cmmcode\":\"WEB\",\"restype\":1,\"loc\":\"zh_CN\",\"sign_hotelid\":\"$this->sign_hotelid\"}","hotel_web_id":"H10083","pms_room_state_way":"1","pms_member_way":"1"}';
		$pms_set = json_decode($json, true);
		
		$this->load->library('PMS_Adapter', [
			'inter_id' => $pms_set['inter_id'],
			'hotel_id' => $order['hotel_id'],
		], 'pmsa');
		
		$param = [
			'trans_no' => $order['orderid'],
			'third_no' => time() . time(),
		];
		
		var_dump($this->pmsa->add_web_bill($order, $param));
		
	}
	
	public function priceset(){
		$db = $this->load->database('default', true);
		$this->db = $db;
//		$room_list = $this->db->from('hotel_rooms_copy')->where(['inter_id' => $this->inter_id])->select('room_id,hotel_id,inter_id')->get()->result_array();
		$json = file_get_contents(FD_PUBLIC . '/huali/rooms_no27.json');
		$room_list = json_decode($json, true);
		$params = [];
		foreach($room_list as $v){
			for($i = 27; $i <= 27; $i++){
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
		
		$this->db->insert_batch('hotel_price_set_copy', $params);
	}
	
	public function test_payment(){
		$web_orderid = 'C17071900000004';
		$fee = 200.00;
		$pay_code = '9009';
		$payno = '4005682001201707191537030437';// time() . time();
		
		$params = [
			'pay_money' => $fee,
			'pay_code'  => $pay_code,
			'payno'     => $payno,
			'remark'    => '测试网络支付入账',
			'rsvno'     => $web_orderid,
		];
		
		var_dump($this->serv_api->addPayment($params));
		
		
	}
	
	public function getweborder(){
		$res = $this->serv_api->queryOrder('C16122900000011');
		print_r($res);
	}
	
	public function history_order(){
		$web_orderid = 'C17022600000001';
		$res = $this->serv_api->queryHistoryOrder($web_orderid);
		echo json_encode($res);
	}
	
	
}