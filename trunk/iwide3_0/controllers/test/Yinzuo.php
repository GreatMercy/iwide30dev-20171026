<?php

class Yinzuo extends MY_Controller{
//	private $url = 'http://123.233.118.91:8039/xmsopen-web/rest'; //测试
//	private $url = 'http://www.jyinns.net:8939/xmsopen-web/rest'; //生产
//	private $url = 'http://www.jyinns.net:8939/ItfServerRS/rest/';
	private $url = 'http://123.233.118.91:8039/ItfServerRS/rest'; //测试

//	private $appkey = 'WX1601';
//	private $secret = 'msmMIvXW0SNMDIhK9cL';//测试
//	private $secret = 'fQKWr6dr1oBs5UumNok';//生产

//	private $cmmcode = 'WEB'; //测试
	private $cmmcode = 'WECHAT';//生产

//	private $inter_id = 'a475288456';//开发
	private $inter_id = 'a476088708';//测试
//	private $inter_id = 'a476756979';//生产

	private $pms_set = [];

	private $user = 'YZWECHAT';
	private $pwd = '5d7a4d94ae9ce422e587f80c121a5282';

	public function __construct(){
		parent::__construct();
		$this->load->helper('common');

		$conf = [
			'url'          => $this->url,
			'user'         => $this->user,
			'pwd'          => $this->pwd,
			'cmmcode'      => $this->cmmcode,
			'channel'      => 'WECHAT',
			'sign_hotelid' => 'G000001',
		];


		$this->pms_set = [
			'pms_auth' => json_encode($conf),
			'inter_id' => $this->inter_id
		];

		$conf['inter_id'] = $this->inter_id;

		$this->load->library('Baseapi/Xiruanapi', $conf, 'serv_api');
		
	}

	public function fix(){
		$row = $this->db->from('hotel_additions')->where([
			                                                 'inter_id' => $this->inter_id,
			                                                 'hotel_id' => 0
		                                                 ])->get()->row_array();
		$pms_auth = json_decode($row['pms_auth'], true);
		$pms_auth['sign_hotelid'] = 'G000001';
		$this->db->update('hotel_additions', ['pms_auth' => json_encode($pms_auth)], ['inter_id' => $this->inter_id]);
	}

	public function fixpms(){
		$json = file_get_contents(FD_PUBLIC . '/yinzuo_hotels_pms_prod.json');
		$temp_list = json_decode($json, true);
		foreach($temp_list as $v){
			$hotels[$v['hotelid']] = $v;
		}

		$list = $this->db->from('hotel_additions')->where([
			                                                  'inter_id'  => $this->inter_id,
			                                                  'hotel_id>' => 0
		                                                  ])->get()->result_array();

		foreach($list as $v){
			if(isset($hotels[$v['hotel_web_id']])){
				$pms_auth = json_decode($v['pms_auth'], true);
				$pms_auth['mode'] = $hotels[$v['hotel_web_id']]['mode'] == '直营' ? '1' : '0';
				$this->db->update('hotel_additions', ['pms_auth' => json_encode($pms_auth)], [
					'hotel_id' => $v['hotel_id'],
					'inter_id' => $this->inter_id
				]);
			}
		}
		echo 'success';
	}

	public function login(){
		$params = [
			'appkey'  => $this->appkey,
			'secret'  => $this->secret,
			'method'  => 'xmsopen.public.login',
			'ver'     => '1.0.0',
			'hotelid' => 'G000001',
			'loc'     => 'zh_CN',
			'ts'      => time(),
		];

		$params['sign'] = $this->sign($params);
		$json = json_encode($params);
		$res = $this->curl_post_json($this->url, $json);
		echo $res;
	}

	public function hotels(){
		set_time_limit(900);
		$url = 'http://123.233.118.91:8039/ItfServerRS/rest/member/';
		/*$params = [
			'appkey'  => $this->appkey,
			'session' => 'PI2fQb858Joueq8qxbk',
			'method'  => 'xmsopen.reservation.xopgetcity',
			'ver'     => '1.0.0',
			'hotelid' => 'G000001',
			'loc'     => 'zh_CN',
			'ts'      => time(),
			'cmmcode' => $this->cmmcode,
		];

		$params['sign'] = $this->sign($params);
		$json = json_encode($params);
		$res = $this->curl_post_json($url, $json);*/
		$params = [
			'rq'      => 'getcity',
			'hotelid' => 'G000001',
			'pw'      => '5d7a4d94ae9ce422e587f80c121a5282',
			'user'    => 'YZWECHAT',
			'cmmcode' => $this->cmmcode,
		];

		$res = $this->curl_post_json($url . $params['rq'], json_encode($params));
		$result = json_decode($res, true);
		if($result['success'] && !empty($result['result'])){
			$hotels = [];
			$fail = [];
			foreach($result['result'] as $v){
				/*$params = [
					'appkey'  => $this->appkey,
					'session' => 'oWcX4vfhYJcNl0vXVeg',
					'method'  => 'xmsopen.reservation.xopqueryhotel',
					'ver'     => '1.0.0',
					'hotelid' => 'G000001',
					'loc'     => 'zh_CN',
					'ts'      => time(),
					'cmmcode' => $this->cmmcode,
					'params'  => [
						['city' => $v['seq']]
					]
				];*/
				$params['rq'] = 'hotel';
				$params['param'] = [
					'city' => $v['code'],
				];

				$json = json_encode($params);
				$res = $this->curl_post_json($url . 'queryhotel', $json);

				/*echo json_encode([
					                 'url'      => $url . 'queryhotel',
					                 'request'  => $params,
					                 'response' => json_decode($res, true),
				                 ]);
				exit;*/

				$list = json_decode($res, true);
				if(!empty($list['result'])){
					foreach($list['result'] as $t){
						$t['city'] = $v['des'];
						$hotels[] = $t;
					}
				} else{
					$fail = array_merge($fail, $list);
				}
			}

			$no_rooms = [];

			foreach($hotels as &$v){
//				$params['method']='xmsopen.reservation.xopgetroomtype';
//				$params['params']=[['hotelid' => $v['hotelid']]];
				/*$params = [
					'appkey'  => $this->appkey,
					'session' => 'oWcX4vfhYJcNl0vXVeg',
					'method'  => 'xmsopen.reservation.xopgetroomtype',
					'ver'     => '1.0.0',
					'hotelid' => 'G000001',
					'loc'     => 'zh_CN',
					'ts'      => time(),
					'cmmcode' => $this->cmmcode,
					'params'  => [
						['hotelid' => $v['hotelid']]
					]
				];*/
//				$params['sign'] = $this->sign($params);
				$params['rq'] = 'getrmtype';
				$params['param'] = [
					'hotelid' => $v['hotelid'],
				];
				$json = json_encode($params);
				$res = $this->curl_post_json($url . 'getrmtype', $json);
				/*echo json_encode([
					                 'url'      => $url . 'getrmtype',
					                 'request'  => $params,
					                 'response' => json_decode($res, true),
				                 ]);
				exit;*/
				$list = json_decode($res, true);

				if($list['success']){
					$v['rooms'] = $list['result'];
					if(!$list['result']){
						$no_rooms[] = $v['hotelid'];
					}
				} else{
					/*echo json_encode([
										 'url'      => $url . 'getrmtype',
										 'request'  => $params,
										 'response' => json_decode($res, true),
									 ]);
					exit;*/
					$v['errs'] = true;
				}
			}
			reset($hotels);
			file_put_contents(FD_PUBLIC . '/yinzuo_hotels_pms_test.json', json_encode($hotels));
			echo json_encode($hotels);
		} else{
			echo json_encode([
				                 'url'      => $this->url,
				                 'request'  => $params,
				                 'response' => json_decode($res, true),
			                 ]);
			exit;
		}

	}

	public function catches(){
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

		$json = file_get_contents(FD_PUBLIC . '/yinzuo_hotels_pms_prod.json');
//		exit($json);
		$hotels = json_decode($json, true);
		$additions = [];
		$rooms = [];
		$lowest = [];
		$icons = [];
		$db = $this->load->database('default', true);
//		$db = $this->db;
		$no_rooms = [];
		$has_rooms = [];
		foreach($hotels as $v){
			/*if(!$v['rooms']){
				$no_rooms[] = $v['des'];
			} else{
				$has_rooms[] = $v['des'];
			}*/

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

			if(empty($v['rooms'])){
				$data['status']=0;
			}

			$db->insert('hotels_copy', $data);
			$hotel_id = $db->insert_id();
			$pms_auth = json_decode($this->pms_set['pms_auth'], true);

			if(!$additions){
				$pms_auth['mode'] = 1;
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'xiruan',
					'pms_auth'           => json_encode($pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$pms_auth['mode'] = $v['mode'] == '直营' ? 1 : 0;

			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'xiruan',
				'pms_auth'           => json_encode($pms_auth),
				'hotel_web_id'       => $v['hotelid'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			if($v['price']){
				$lowest[] = [
					'hotel_id'     => $hotel_id,
					'inter_id'     => $this->inter_id,
					'lowest_price' => $v['price'],
					'update_time'  => date('Y-m-d H:i:s'),
				];
			}

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
		/*if($lowest){
			$db->insert_batch('hotel_lowest_price_copy', $lowest);
		}*/
		if($icons){
			$db->insert_batch('hotel_images_copy', $icons);
		}
		if($rooms){
			$db->insert_batch('hotel_rooms_copy', $rooms);
		}
		echo 'success';
	}

	public function get_lowest(){
		set_time_limit(900);
		$db=$this->load->database('default',true);
		$list=$db->from('hotel_additions_copy a')->join('hotels_copy h','h.hotel_id=a.hotel_id','inner')->select("a.hotel_web_id,a.hotel_id")->where(['a.inter_id'=>$this->inter_id,'a.hotel_id>'=>0,'h.status'=>1])->get()->result_array();
		$lowest=[];
		foreach($list as $v){
			$res = $this->serv_api->getRoomDailyPrice($v['hotel_web_id'],date('Y-m-d',time()+86400),date('Y-m-d',time()+86400*2));
//			echo json_encode($res);exit;
			$min=[];
			foreach($res as $t){
				if($t['rate']>0)
				$min[]=$t['rate'];
			}
			if($min){
				$lowest[]=[
					'hotel_id'     => $v['hotel_id'],
					'inter_id'     => $this->inter_id,
					'lowest_price' => min($min),
					'update_time'  => date('Y-m-d H:i:s'),
				];
			}
		}

		echo json_encode($lowest);
	}

	public function lowest(){
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/yinzuo_lowest.json');
		$list=json_decode($json,true);
		$db=$this->load->database('default',true);
		$db->insert_batch('hotel_lowest_price_copy',$list);
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
		} else{
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
		} else{
			if($str === false){
				$string .= 'false';
			} elseif($str === true){
				$string .= 'true';
			} else{
				if(is_array($str) || is_object($str)){
					ksort($str, SORT_STRING);
					foreach($str as $k => $v){
						$string .= $this->sign_string($v);
					}
				} else{
					if(strtotime($str) && strstr($str, 'T') !== false && $str != 'T'){
						$string .= strtotime($str) . '0000';
					} else{
						if(strstr($str, 'E+')){
							$str = number_format($str, 0, '', '');
							$string .= $str;
						} else{
							$string .= $str;
						}
					}
				}
			}
		}
		return $string;
	}

	public function testroomtype(){

		$hotel_web_id = 'H60102';
		set_time_limit(900);
		/*$list = $this->db->from('hotel_additions')->where(['inter_id' => $this->inter_id])->get()->result_array();
		$pms_data = [];
		foreach($list as $v){
			$pms_data[$v['hotel_id']]['qty'] = $this->serv_api->getRoomQty($v['hotel_web_id'], date('Y-m-d'), date('Y-m-d', time() + 86400*3));

			$pms_data[$v['hotel_id']]['daily']=$this->serv_api->getRoomDailyPrice($v['hotel_web_id'], date('Y-m-d'), date('Y-m-d', time() + 86400*3));
		}*/

		$pms_data['qty'] = $this->serv_api->getRoomQty($hotel_web_id, date('Y-m-d'), date('Y-m-d', time() + 86400 * 3));
		$pms_data['daily'] = $this->serv_api->getRoomDailyPrice($hotel_web_id, date('Y-m-d'), date('Y-m-d', time() + 86400 * 3));
		$pms_data['price'] = $this->serv_api->getRoomPrice($hotel_web_id, date('Y-m-d'), date('Y-m-d', time() + 86400 * 3), null, null, 3);
		$promo = [
			'hotelid' => $hotel_web_id,
			'arr'     => date('Y-m-d'),
			'dep'     => date('Y-m-d', time() + 86400 * 3)
		];
//		$pms_data['promo'] = $this->serv_api->getRoomPromoPrice($promo);

		echo json_encode($pms_data);
	}

	public function test_bill(){
		$json = '{"id":"659552","inter_id":"a475288456","orderid":"94147591331877251","coupon_favour":"0.00","complete_reward_given":"0","coupon_des":"","wxpay_favour":"0.00","point_given":"1","printed":"1","point_used":"0","coupon_give_info":"","point_favour":"0.00","point_used_amount":"0.00","coupon_used":"0","complete_point_given":"0","complete_point_info":"","web_orderid":"C16A080001","room_codes":"{\"14835\":{\"code\":{\"price_type\":\"pms\",\"extra_info\":{\"type\":\"code\",\"pms_code\":\"RACK\",\"pkg\":\"NET\",\"bonus_rate\":false}},\"room\":{\"webser_id\":\"BK\"}}}","web_paid":"0","add_service_info":"","add_service_price":"0.00","balance_part":"0.00","refund":"0","hotel_id":"4027","openid":"oBWOYv-WZ4se-RY6wq5SBqgH3p94","price":"507.00","roomnums":"3","name":"\u5f00\u53d1","tel":"18888888888","order_time":"1475913318","startdate":"20161008","enddate":"20161009","paid":"0","status":"0","holdtime":"18:00","paytype":"daofu","isdel":"0","operate_reason":null,"remark":"","member_no":"JFK2880003539537","handled":"0","hname":"\u5929\u6d25\u706b\u8f66\u7ad9\u5510\u5bb6\u53e3\u5e97","himg":null,"haddress":"\u5929\u6d25\u5e02\u6cb3\u4e1c\u533a\u536b\u56fd\u905369\u53f7","longitude":"","latitude":"","htel":"022-58903777\u8f6c0      ","order_datetime":"2016-10-08 15:55:18","order_details":[{"id":"694978","orderid":"94147591331877251","inter_id":"a475288456","room_id":"14835","iprice":"169.00","startdate":"20161008","enddate":"20161009","istatus":"0","allprice":"169.0000","room_no":"","roomname":"\u5546\u52a1\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"RACK","room_no_id":"0","price_code_name":"\u6563\u5ba2[\u95e8\u5e02\u4ef7]","handled":"0","webs_orderid":"","real_allprice":"169","club_id":"","grade_all_id":"0","grade_status":"0","leavetime":null,"sub_id":"694978"},{"id":"694979","orderid":"94147591331877251","inter_id":"a475288456","room_id":"14835","iprice":"169.00","startdate":"20161008","enddate":"20161009","istatus":"0","allprice":"169.0000","room_no":"","roomname":"\u5546\u52a1\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"RACK","room_no_id":"0","price_code_name":"\u6563\u5ba2[\u95e8\u5e02\u4ef7]","handled":"0","webs_orderid":"","real_allprice":"169","club_id":"","grade_all_id":"0","grade_status":"0","leavetime":null,"sub_id":"694979"},{"id":"694980","orderid":"94147591331877251","inter_id":"a475288456","room_id":"14835","iprice":"169.00","startdate":"20161008","enddate":"20161009","istatus":"0","allprice":"169.0000","room_no":"","roomname":"\u5546\u52a1\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"RACK","room_no_id":"0","price_code_name":"\u6563\u5ba2[\u95e8\u5e02\u4ef7]","handled":"0","webs_orderid":"","real_allprice":"169","club_id":"","grade_all_id":"0","grade_status":"0","leavetime":null,"sub_id":"694980"}],"first_detail":{"id":"694978","orderid":"94147591331877251","inter_id":"a475288456","room_id":"14835","iprice":"169.00","startdate":"20161008","enddate":"20161009","istatus":"0","allprice":"169.0000","room_no":"","roomname":"\u5546\u52a1\u5927\u5e8a\u623f","room_occupy":"0","in_openid":"","share_lock":"1","share_lock_pwd":"0","price_code":"RACK","room_no_id":"0","price_code_name":"\u6563\u5ba2[\u95e8\u5e02\u4ef7]","handled":"0","webs_orderid":"","real_allprice":"169","club_id":"","grade_all_id":"0","grade_status":"0","leavetime":null,"sub_id":"694978"},"ori_price":"507.00"}';
		$order = json_decode($json, true);

		$json = '{"inter_id":"a475288456","hotel_id":"4027","pms_type":"xiruan","pms_auth":"{\"url\":\"http:\\\/\\\/123.233.118.91:8039\\\/xmsopen-web\\\/rest\",\"appkey\":\"WX1601\",\"secret\":\"msmMIvXW0SNMDIhK9cL\",\"cmmcode\":\"WEB\",\"restype\":1,\"loc\":\"zh_CN\",\"sign_hotelid\":\"G000001\"}","hotel_web_id":"H10083","pms_room_state_way":"1","pms_member_way":"1"}';
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
		/**
		 * 门市价
		 * RACK=>门市价，MEM16=>手机专享价
		 *
		 * 会员价
		 * MEM6=>E会员，MEM1=>银卡会员价，MEM10=>新银卡价，MEM11=>银卡价，MEM2=>金卡价，MEM12=>铂金卡价，MEM3=>倍积卡价，MEM8=>惠享卡价
		 *
		 * 积分换房
		 * MEM5=>直营店积分换房，MEM7=>加盟店积分换房
		 *
		 * 协议价
		 * IC=>集团内部价，CORA5=>A类协议，CORA5F=>B类协议，CORA75=>佳驿75拆协议
		 */

//		$room_list = $this->db->from('hotel_rooms')->where(['inter_id' => $this->inter_id])->select('room_id,hotel_id,inter_id')->get()->result_array();
		$params = [];
		$room_list=$this->db->from('hotel_rooms')->where(['inter_id'=>$this->inter_id])->get()->result_array();
		foreach($room_list as $v){
			for($i = 1; $i <= 2; $i++){
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
		exit;
		$db=$this->load->database('default',true);
		$json=file_get_contents(FD_PUBLIC.'/tmp_data/yinzuo_rooms.json');
		$room_list = json_decode($json,true);
		$params = [];
		foreach($room_list as $v){
			for($i = 19; $i <= 23; $i++){
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
		echo 'success';
	}

	public function checkrooms(){
		$json = file_get_contents(FD_PUBLIC . '/yinzuo_hotels_pms_prod.json');
		$hotels = json_decode($json, true);
		$res = [];
		foreach($hotels as $v){
			/*if(isset($v['rooms']) && !$v['rooms']){
				$res[] = $v['hotelid'];
			}*/
			if(!empty($v['errs']))
				$res[]=$v['hotelid'];
		}
		echo implode(',', $res);
	}

	public function query_order($web_orderid){
		$web_order=$this->serv_api->queryOrder($web_orderid);
		echo json_encode($web_order);
	}

	public function gethotel(){
		$hotel_web_id='H60005';
		$res=$this->serv_api->getRoomDailyPrice($hotel_web_id,date('Y-m-d'),date('Y-m-d',strtotime('+1 day',time())));
		echo json_encode($res);
	}

	public function testPy(){
		$this->load->library('Str_Py',null,'py');
		$arr=[
			'滕','鄄','郓'
		];

		$res=[];
		foreach($arr as $v){
			$res[$v]=$this->py->getInitials($v);
		}
		print_r($res);
	}
	
	public function fixbill(){
//		$json='{"rq":"payment","hotelid":"G000001","pw":"5d7a4d94ae9ce422e587f80c121a5282","user":"YZWECHAT","cmmcode":"WECHAT","param":{"rsvno":"C175103148","pay_money":"133.00","pay_code":null,"payno":"4002802001201705100318445669","remark":"订单预付：C175103148"}}';
//		$json='{"rq":"payment","hotelid":"G000001","pw":"5d7a4d94ae9ce422e587f80c121a5282","user":"YZWECHAT","cmmcode":"WECHAT","param":{"rsvno":"C175103374","pay_money":"153.00","pay_code":null,"payno":"4009452001201705100319353243","remark":"订单预付：C175103374"}}';
//		$json='{"rq":"payment","hotelid":"G000001","pw":"5d7a4d94ae9ce422e587f80c121a5282","user":"YZWECHAT","cmmcode":"WECHAT","param":{"rsvno":"C175103883","pay_money":"118.00","pay_code":null,"payno":"4003592001201705100332814804","remark":"订单预付：C175103883"}}';
//		$json='{"rq":"payment","hotelid":"G000001","pw":"5d7a4d94ae9ce422e587f80c121a5282","user":"YZWECHAT","cmmcode":"WECHAT","param":{"rsvno":"C175105064","pay_money":"125.00","pay_code":null,"payno":"4002802001201705110359816593","remark":"订单预付：C175105064"}}';
//		$json='{"rq":"payment","hotelid":"G000001","pw":"5d7a4d94ae9ce422e587f80c121a5282","user":"YZWECHAT","cmmcode":"WECHAT","param":{"rsvno":"C175105067","pay_money":"455.00","pay_code":null,"payno":"4002802001201705110361763748","remark":"订单预付：C175105067"}}';
		
		$data=json_decode($json,true);
		$payment = $data['param'];
		$payment['pay_code']=9129;
		
		$res=$this->serv_api->addPayment($payment);
		
		var_dump($res);
	}

}