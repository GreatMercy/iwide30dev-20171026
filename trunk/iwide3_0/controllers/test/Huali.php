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
		
		$json = file_get_contents(FD_PUBLIC . '/huali/hotel_prod.json');
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
	
	public function priceset(){
		$db = $this->load->database('default', true);
		$room_list = $db->from('hotel_rooms_copy')->where(['inter_id' => $this->inter_id])->select('room_id,hotel_id,inter_id')->get()->result_array();
//		$json = file_get_contents(FD_PUBLIC . '/huali/rooms_no27.json');
//		$room_list = json_decode($json, true);
		$params = [];
		foreach($room_list as $v){
			for($i = 2; $i <= 4; $i++){
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
		
		$db->insert_batch('hotel_price_set_copy', $params);
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