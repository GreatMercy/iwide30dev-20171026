<?php

class Gbsz extends MY_Controller{
//	private $inter_id = 'a497252965';
	/*private $inter_id='a497337940';
	private $url = 'http://183.237.135.108:3000/';
	private $appid = 'appid_7989cc51bd491701b3c365f678603eea';
	private $user = 'gubeijfk';
	private $pwd = '654321';
	private $key = '724015a80519c65049aec6628776b532';*/
	
	private $inter_id='a492755178';
	private $url='http://111.204.228.65:3000/';
	private $appid='appid_3fb07b791558f8a67bf8094d31e24600';
	private $user='gubeijfk';
	private $pwd='gb654321';
	private $key='7cb2a8dcd5431dd519a0845e2e22a810';
	
	private $pms_auth;
	
	public function __construct(){
		parent::__construct();
		$this->pms_auth = [
			'url'   => $this->url,
			'appid' => $this->appid,
			'user'  => $this->user,
			'pwd'   => $this->pwd,
			'key'   => $this->key,
		    'paytype'=>['weixin'=>'WX','unionpay'=>'YL']
		
		];
		exit(json_encode($this->pms_auth));
		$this->load->helper('common');
	}
	
	public function fixpms(){
		$this->db->update('hotel_additions',['pms_type'=>'gbsz'],['inter_id'=>$this->inter_id]);
	}
	
	public function login_act(){
		$url = $this->url . 'user/dologin';
		$param = [
			'username' => $this->user,
			'password' => md5($this->pwd),
		];
		
		$res = doCurlGetRequest($url, $param);
		
		print_r([
			'url'=>$url,
		    'req'=>$param,
		    'res'=>json_decode($res,true),
		]);
	}
	
	private function sign($bizdata = null){
		!is_null($bizdata) or $bizdata = 'null';
		
		if(is_array($bizdata)){
			$bizdata=json_encode($bizdata);
		}
		$str = 'appid=' . $this->appid . '&bizdata=' . $bizdata . '&key=' . $this->key;
		
		return [
			'string' => $str,
			'sign'   => md5($str),
		];
	}
	
	private function postService($url, $bizdata = null){
		
		$sign_data=$this->sign($bizdata);
		
		$post_data = [
			'appid'   => $this->appid,
			'bizdata' => $bizdata != null ? json_encode($bizdata) : null,
			'sign'    => $sign_data['sign'],
		];
		$json = json_encode($post_data);
		$extra = ['CURLOPT_HTTPHEADER' => ['Content-Type: application/json']];
		
		$res = doCurlPostRequest($url, $json, $extra, 900);
		return [
			'url'      => $url,
			'request'  => $post_data,
			'response' => json_decode($res, true),
		    'sign_string'=>$sign_data['string']
		];
	}
	
	private function sign_arr($arr=[]){
		$sign_arr=[];
		foreach($arr as $k=>$v){
			if(is_array($v)&&$v){
				$sign_arr[$k]=$this->sign_arr($v);
			}elseif(is_null($v)){
				$sign_arr[$k]='null';
			}else{
				$sign_arr[$k]=$v;
			}
		}
		return $sign_arr;
	}
	
	public function get_scenic(){
		$bizdata = null;
		$url = $this->url . 'resources/scenic';
		
		$result = $this->postService($url, $bizdata);
		
		echo json_encode($result);
	}
	
	public function get_rooms(){
		$sceniccode='GBHOTEL';
		
		$url=$this->url.'resources/room/list';
		$bizdata_arr=[
			'sceniccode'=>$sceniccode,
		    'startdate'=>date('Y-m-d'),
		    'enddate'=>date('Y-m-d',time()+86400*2),
		];
		
		$result=$this->postService($url,$bizdata_arr);
		echo json_encode($result);
	}
	
	public function get_hotels(){
		$bizdata = null;
		$url = $this->url . 'resources/scenic';
		
		$result = $this->postService($url, $bizdata);
		if(!empty($result['response'])&&$result['response']['result']=='success'&&!empty($result['response']['data'])){
			$scenic_list=$result['response']['data'];
			$r_url=$this->url.'resources/room/list';
			$hotels=[];
			foreach($scenic_list as $v){
				$bizdata_arr=[
					'sceniccode'=>$v['sceniccode'],
					'startdate'=>date('Y-m-d',time()+86400*7),
					'enddate'=>date('Y-m-d',time()+86400*8),
				];
				$res=$this->postService($r_url,$bizdata_arr);
				if(!empty($res['response'])&&$res['response']['result']=='success'&&!empty($res['response']['data'])){
					$hotel_ls=$res['response']['data'];
					foreach($hotel_ls as $t){
						$hotels[]=[
							'sceniccode'=>$v['sceniccode'],
						    'hotelid'=>$t['hotelid'],
						    'hotelname'=>$t['hotelname'],
						    'rooms'=>$t['roomtypelist']
						];
					}
				}
			}
		}
		if($hotels){
			file_put_contents(FD_PUBLIC.'/gsbz/hotels_prod.json',json_encode($hotels));
		}
	}
	
	public function catches(){
		$json=file_get_contents(FD_PUBLIC.'/gsbz/hotels_test.json');
		$hotels = json_decode($json, true);
		$additions = $rooms = $icons = [];
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['hotelname'],
				'address'     => '',
				'tel'         => '',
				'fax'         => '',
				'intro'       => $v['hotelname'],
				'short_intro' => $v['hotelname'],
				'city'        => '',
				'province'    => '',
				'star'        => 0,
				'latitude'    => '',
				'longitude'   => '',
			];
			
			$this->db->insert('hotels', $data);
			$hotel_id = $this->db->insert_id();
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'gbsz',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'gbsz',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['sceniccode'].'#'.$v['hotelid'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			
			if(!empty($v['rooms'])){
				is_array(current($v['rooms'])) or $v['rooms'] = [$v['rooms']];
				foreach($v['rooms'] as $t){
					$rooms[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['rtname'],
						'description' => $t['rtname'],
						'webser_id'   => $t['roomtype'],
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
	
	public function hotels_from_xls(){
		$this->load->file(APPPATH . 'libraries/PHPExcel.php');
		$this->load->file(APPPATH . 'libraries/Export/PHPExcel/IOFactory.php');
		$reader = PHPExcel_IOFactory::createReader('Excel2007'); //设置以Excel5格式(Excel97-2003工作簿)
		$PHPExcel = $reader->load(FD_PUBLIC . "/gsbz/rmtypegrid.xlsx"); // 载入excel文件
		$sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		
		$hotels=[];
		$scenic_code='GBHOTEL';
		for($row=1;$row<=$highestRow;$row++){
			$hotel_web_id=$sheet->getCell('C'.$row)->getValue();
			$hotel_name=$sheet->getCell('D'.$row)->getValue();
			if(empty($hotels[$hotel_web_id])){
				$hotels[$hotel_web_id]=[
					'sceniccode'=>$scenic_code,
					'hotelid'=>$hotel_web_id,
					'hotelname'=>$hotel_name,
				];
			}
			$hotels[$hotel_web_id]['rooms'][]=[
				'roomtype'=>$sheet->getCell('A'.$row)->getValue(),
				'rtname'=>$sheet->getCell('B'.$row)->getValue()
			];
		}
		
		file_put_contents(FD_PUBLIC.'/gsbz/hotels_prod.json',json_encode($hotels));
		echo json_encode($hotels);
	}
	
	public function import_prod(){
		$json=file_get_contents(FD_PUBLIC.'/gsbz/hotels_prod.json');
		$hotels = json_decode($json, true);
		$additions = $rooms = $icons = [];
		$db=$this->load->database('default',true);
		foreach($hotels as $v){
			$data = [
				'inter_id'    => $this->inter_id,
				'name'        => $v['hotelname'],
				'address'     => '',
				'tel'         => '',
				'fax'         => '',
				'intro'       => $v['hotelname'],
				'short_intro' => $v['hotelname'],
				'city'        => '',
				'province'    => '',
				'star'        => 0,
				'latitude'    => '',
				'longitude'   => '',
			];
			
			$db->insert('hotels_copy', $data);
			$hotel_id = $db->insert_id();
			if(!$additions){
				$additions[] = [
					'hotel_id'           => 0,
					'inter_id'           => $this->inter_id,
					'pms_type'           => 'gbsz',
					'pms_auth'           => json_encode($this->pms_auth),
					'hotel_web_id'       => '',
					'pms_room_state_way' => 4,
					'pms_member_way'     => 1,
				];
			}
			$additions[] = [
				'hotel_id'           => $hotel_id,
				'inter_id'           => $this->inter_id,
				'pms_type'           => 'gbsz',
				'pms_auth'           => json_encode($this->pms_auth),
				'hotel_web_id'       => $v['sceniccode'].'#'.$v['hotelid'],
				'pms_room_state_way' => 4,
				'pms_member_way'     => 1,
			];
			
			if(!empty($v['rooms'])){
				is_array(current($v['rooms'])) or $v['rooms'] = [$v['rooms']];
				foreach($v['rooms'] as $t){
					$rooms[] = [
						'hotel_id'    => $hotel_id,
						'inter_id'    => $this->inter_id,
						'name'        => $t['rtname'],
						'description' => $t['rtname'],
						'webser_id'   => $t['roomtype'],
					];
				}
			}
			
		}
		if($additions){
			$db->insert_batch('hotel_additions_copy', $additions);
		}
		if($icons){
			$db->insert_batch('hotel_images_copy', $icons);
		}
		if($rooms){
			$db->insert_batch('hotel_rooms_copy', $rooms);
		}
		echo 'success';
	}
	
	
	public function priceset(){
		$db=$this->load->database('default',true);
		$room_list=$db->from('hotel_rooms_copy')->where(['inter_id'=>$this->inter_id])->get()->result_array();
		$params=[];
		foreach($room_list as $v){
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
		$db->insert_batch('hotel_price_set_copy',$params);
		echo 'success';
	}
	
	public function get_room_state(){
		$roomtype='XC82';
		$sceniccode='GBHOTEL';
		$url=$this->url.'resources/room/available';
		$bizdata_arr=[
			'sceniccode'=>$sceniccode,
			'startdate'=>date('Y-m-d'),
			'enddate'=>date('Y-m-d',time()+86400),
		    'roomtype'=>$roomtype
		];
		$list=[];
		$list[]=$this->postService($url,$bizdata_arr);
		
		$bizdata_arr['roomtype']='SZ11';
		$list[]=$this->postService($url,$bizdata_arr);
		echo json_encode($list);
	}
	
	public function add_order(){
		$hotelid='WA';
		$roomtype='WA11';
		$sceniccode='GBHOTEL';
		$url=$this->url.'order/add';
		
		$bizdata=[
			'sceniccode'=>$sceniccode,
		    'otaorderid'=>time(),
		    'packagecode'=>'',
		    'packagenum'=>'',
		    'totalamount'=>1420,
		    'payment'=>0,
		    'remark'=>'Test Order',
		    'memo'=>'',
		    'paytype'=>2,
		    'guestinfo'=>[
		    	'guestname'=>'Jing Fang Ka',
		        'mobile'=>'18888888888',
		        'idtype'=>'',
		        'idno'=>'',
		    ],
		    'orderlist'=>[
		    	'room'=>[
		    		[
					    'roomtype'  => $roomtype,
					    'hotelid'   => $hotelid,
					    'startdate' => date('Y-m-d'),
					    'enddate'   => date('Y-m-d', time() + 86400 * 1),
					    'num'       => 1,
					    'guestinfo' => [
						    'guestname' => 'ing Fang Ka',
						    'mobile'    => '18888888888',
						    'idtype'    => '',
						    'idno'      => '',
					    ],]
			    ],
		        'pos'=>[],
		        'ticket'=>[],
		        'customitem'=>[],
		    ]
		];
		
		$result=$this->postService($url,$bizdata);
		print_r($result);
	}
	
	public function get_order(){
		$orderid='Z20170606003508';
		$otaorderid='1496744895';
		$sceniccode='GBHOTEL';
		
		$url=$this->url.'order/query';
		$bizdata=[
			'sceniccode'=>$sceniccode,
		    'otaorderid'=>$otaorderid,
		];
		$result=$this->postService($url,$bizdata);
		print_r($result);
	}
	
	public function cancel_order(){
		$orderid='Z20170609003535';
		$otaorderid='1496997435';
		$sceniccode='GBHOTEL';
		
		$url=$this->url.'order/cancel';
		
		$bizdata=[
			'sceniccode'=>$sceniccode,
			'otaorderid'=>$otaorderid,
		    'refundreason'=>'Cancel Order Reason',
		    'amount'=>[1420,0],
		    'full'=>0,
		];
		$result=$this->postService($url,$bizdata);
		print_r($result);
	}
	
	
}