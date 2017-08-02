<?php

class Zy extends MY_Controller{
	private $url = 'http://120.76.101.150/TEST_webservice/JsonPattern/';
//	private $url = 'http://120.76.101.150/TEST_webservice/Interface.asmx?wsdl';
	private $usr = 'crs1';
	private $pwd = 'crs1';
	private $channel = '';

	public function __construct(){
		parent::__construct();
		$this->load->helper('common');
		$this->pms_auth = array(
			'user'    => 'crs1',
			'pwd'     => 'crs1',
			'channel' => '',
			'url'     => 'http://120.76.101.150/TEST_webservice/JsonPattern/',
			'lang'    => 'CN',
		);
	}

	public function get_hotels(){
		$data = array(
			'usercd'     => $this->usr,
			'password'   => $this->pwd,
			'lang'       => 'CN',
			'apocalypse' => true,
		);

		$data = http_build_query($data);
		$res = doCurlPostRequest($this->url . 'GetHtlList.aspx', $data);
		$list = array();
		$results = json_decode($res, true);
		$room_params = array(
			'usercd'   => $this->usr,
			'password' => $this->pwd,
			'lang'     => 'CN',
		);
		foreach($results['data'] as $v){
			$room_params['htl_cd'] = $v['htlcd'];
			$query_str = http_build_query($room_params);
			$res = doCurlPostRequest($this->url . 'GetRoomList.aspx', $query_str);
			$res = json_decode($res, true);
			$list[] = array(
				'info'      => $v,
				'room_list' => $res['data']
			);
		}
		print_r($list);
	}

	public function test(){
		$serv_api = new ZhongruanApi();
		$serv_api->setPmsAuth($this->pms_auth);
		$hotels = $serv_api->getHotetList();
		$list = array();
		foreach($hotels as $v){
			$v['room_list'] = $serv_api->getRooms($v['htlcd']);
			$list[] = $v;
		}
		echo json_encode($list);
	}

	public function test_room(){
		$serv_api = new ZhongruanApi();
		$serv_api->setPmsAuth($this->pms_auth);
		$params = array(
			'arr_dt'     => date('Y-m-d'),
			'dpt_dt'     => date('Y-m-d', time() + 86400 * 3),
			'htl_cd'     => '006',
			'channel_cd' => 'WX',
			'htl_ip'     => '',
			'htl_port'   => 0,
			'rm_list'    => 'APA,APA-1,APG',
		);
		print_r($params);
		print_r($serv_api->getRoomAvl($params));
	}

	public function test_hotels(){
		$serv_api = new ZhongruanApi();
		$serv_api->setPmsAuth($this->pms_auth);
		$params = array(
			'arr_dt'     => date('Y-m-d'),
			'dpt_dt'     => date('Y-m-d', time() + 86400 * 3),
			'channel_cd' => 'WX',
			'rp_cd'      => '01',
			'htl_cd'=>'006',
		);
		echo json_encode($serv_api->getHotels($params));
	}

	/*public function test_price(){
		$serv_api = new ZhonghuiApi();
		$serv_api->setPmsAuth($this->pms_auth);
		$params = array(
			'arr_dt'     => date('Y-m-d'),
			'dpt_dt'     => date('Y-m-d', time() + 86400),
			'channel_cd' => 'WX',
			'rp_cd'      => '01',
			'htl_cd'     => '006',
		);
		print_r($serv_api->getPriceLite($params));
	}*/


}

class ZhonghuiApi{
	private $url;
	private $user;
	private $pwd;
	private $lang = 'CN';

	public function __construct(){
		$ci =& get_instance();
		$ci->load->helper('common');
	}

	public function setPmsAuth($params){
		if(!empty($params['url'])){
			$this->url = $params['url'];
		}
		if(!empty($params['user'])){
			$this->user = $params['user'];
		}
		if(!empty($params['pwd'])){
			$this->pwd = $params['pwd'];
		}
		if(!empty($params['lang'])){
			$this->lang = $params['lang'];
		}
	}

	public function getHotetList(){
		$params = array(
			'apocalypse' => true,
		);
		$res = $this->apiCall($this->url . 'GetHtlList.aspx', $params);
		return $res['status'] == 200 ? $res['data'] : array();
	}

	public function getHotels($params){
		array_key_exists('htl_cls', $params) or $params['htl_cls'] = 99;
		$res = $this->apiCall($this->url . 'GetHotels.aspx', $params);
		return $res;
		return 200 == $res['status'] ? $res['data'] : array();
	}

	public function getRooms($hotelId){
		$params = array(
			'htl_cd' => $hotelId,
		);
		$res = $this->apiCall($this->url . 'GetRoomList.aspx', $params);
		if(200 == $res['status']){
			return $res['data'];
		} else{
			return array();
		}
	}

	/**
	 * @param mixed $params
	 *  <code>
	 *  (
	 *  saasacctnum=> Saas酒店系统返回账单号 [optional]
	 *  acctnum=> 预订单帐号 [optional]
	 *  manipulate=> 操作类型（1：新建，2：修改，3：删除）
	 *  acctnm=> 入住人姓名
	 *  contact=> 联系人姓名
	 *  contact_tel=> 联系电话
	 *  careificate_typ=> 证件类型，以客户集团管理软件中定义的类型代码为准
	 *  careificate_num=> 证件号码
	 *  htl_cd=> 酒店代码，以客户集团管理软件中定义的类型代码为准
	 *  rm_typ=> 房类代码，以客户集团管理软件中定义的类型代码为准
	 *  arr_dt=> 来店日期，如：2014-5-1
	 *  dpt_dt=> 离店日期，如：2014-5-4
	 *  rt_amt=> 首日房价
	 *  everyday_amt=> 每日房价，多个金额间逗号隔开，如预订1晚：100,120；2晚：100,120,120  以此类推
	 *  fst_arr_tm=> 最早来店时间，如：2015-5-25 11:00:00
	 *  lst_arr_tm=> 最晚来店时间，如：2015-5-25 15:00:00
	 *  htl_nm=> [optional]
	 *  rm_nm=> [optional]
	 *  acct_stus=> 订单状态（新建预订传2）
	 *  bed_amt=>  加床价
	 *  bed_add=> 加床数
	 *  breakfast_amt=> 加早餐价格
	 *  breakfast_add=> 加早餐数
	 *  room_num=> [optional]
	 *  e_mail=> 电子邮箱. [optional]
	 *  ic_num=> 会员卡号 [optional]
	 *  company_num=> 客户编号 [optional]
	 *  org_dt=> [optional]
	 *  remark=> 备注 [optional]
	 *  people_num=> 入住人数（传入1）
	 *  affirm_typ=> 确认方式：不需确认 0；电话确认 1；邮件确认 2；传真确认 3；短信确认 4
	 *  subscription=> 订金
	 *  deal_subscription=> 应付订金金额 [optional]
	 *  su_tm=> 支付期限（单位小时） [optional]
	 *  service_list=> 代码_01,代码_01,代码_01…… [optional]
	 *  gh_num=> 客史号 [optional]
	 *  fax=> 传真 [optional]
	 *  rp_cd=> 价格代码，以客户集团管理软件中定义的类型代码为准
	 *  channel_cd=> 渠道代码，以客户集团管理软件中定义的类型代码为准
	 *  comm_amt=> 首日佣金
	 *  Dcomm_amt=> 每日佣金，多个金额间逗号隔开，如：0,0,0,0
	 *  Fxcomm_amt=> 首日分销佣金
	 *  Dfxcomm_amt=> 每日分销佣金，多个金额间逗号隔开，如：10,12,12,12
	 *  Meal_cnt=> 含早数
	 *  crdt_cd=> 支付方式，以客户集团管理软件中定义的类型代码为准
	 *  trust_num=> 信用卡号码 [optional]
	 *  trust_dt=> 信用卡有效期 [optional]
	 *  geo1=> 国籍（传入CN），以客户集团管理软件中定义的类型代码为准
	 *  htl_typ=> 酒店类型（传入1）
	 *  Apply_nums=> 应用数量 [optional]
	 *  Apply_id=> 应用id [optional]
	 *  Favor_id=> 特价房模板编号 [optional]
	 *  Favor_nums=> 特价房使用数量 [optional]
	 *  pay_num=> 网上支付票据号 [optional]
	 *  arr_tm=> 航班到达时间 [optional]
	 *  arr_flt=> 航班号[optional]
	 *  org_cd=> 客源代码，以客户集团管理软件中定义的类型代码为准
	 *  )
	 *  </code>
	 * @return mixed
	 */
	public function createOrder($params){
		$params = array(
			'ResvInfo' => $params,
		);
		$data = array(
			'resvinfo' => array2xml($params)
		);
		print_r($data);exit;
		$res = $this->apiCall($this->url . 'AddResvInfo.aspx', $data);
		return $res;
	}

	public function cancelOrder($web_orderid, $reason = ''){
		$params = array(
			'resvnum' => $web_orderid,
			'ic_num'  => '',
			'tel'     => '',
			'mail'    => '',
			'reason'  => $reason,
		);
		$res = $this->apiCall($this->url . 'CancelResvInfo.aspx', $params);
		return $res;
	}

	public function getOrder($web_orderid){
		return array();
	}

	/**
	 * @param $params
	 *  <code>
	 *  array(
	 *  arr_dt=>入住日期
	 *  apt_dt=>离店日期
	 *  channel_cd=>销售渠道代码
	 *  htl_ip=>酒店ip地址,
	 *  htl_port=>酒店端口号
	 *  htl_cd=>酒店代码 (以客户集团管理软件中定义的类型代码为准)
	 *  rm_list=>房类代码集合 (以客户集团管理软件中定义的类型代码为准,多房类代码间逗号隔开，如：ST,SR,SP)
	 *  )
	 *  </code>
	 * @return array
	 */
	public function getRoomAvl($params){
		$res = $this->apiCall($this->url . 'GetRoomAvl.aspx', $params);
		return $res;

		if($res['status'] == 200){
			return $res['data'];
		}
		return array();
	}

	/**
	 * @param $params
	 *  <code>
	 *  array(
	 *  arr_dt=>入住日期
	 *  apt_dt=>离店日期
	 *  channel_cd=>销售渠道代码
	 *  htl_cd=>酒店代码 (以客户集团管理软件中定义的类型代码为准)
	 *  rp_cd=>价格代码
	 *  )
	 *  </code>
	 * @return array
	 */
	public function getPriceLite($params){
		array_key_exists('htl_cls', $params) or $params['htl_cls'] = 99;
		$res = $this->apiCall($this->url . 'GetPriceLite.aspx', $params);
		return $res;
		if(200 == $res['status']){
			return $res['data'];
		}
		return array();
	}

	protected function commonField(){
		return array(
			'usercd'   => $this->user,
			'password' => $this->pwd,
			'lang'     => $this->lang,
		);
	}

	private function apiCall($url, $curl_array){
		$curl_array = array_merge($this->commonField(), $curl_array);
		$query_str = http_build_query($curl_array);
		$res = doCurlPostRequest($url, $query_str);
		$res = json_decode($res, true);
		return $res;
	}
}

class ResvInfo{
	public $saasacctnum = '';
	public $acctnm = '';
	public $payment_type = '';
	public $acctnum = '';
	public $acct_stus = 2;
	public $careificate_num = '';
	public $careificate_typ = '';
	public $everyday_amt = '';
	public $contact = '';
	public $e_mail = '';
	public $htl_nm = '';
	public $ic_num = '';
	public $manipulate = 1;
	public $arr_dt = '0001-01-01';
	public $dpt_dt = '0001-01-01';
	public $pay_num = '';
	public $arr_tm = '';
	public $rt_amt = 0;
	public $deal_subscription = 0;
	public $Apply_nums = 1;
	public $su_tm = 0;
	public $Favor_id = 0;
	public $Apply_id = 0;
	public $favor_num = 0;
	public $fst_arr_tm = '0001-01-01';
	public $lst_arr_tm = '0001-01-01';
	public $remark = '';
	public $rm_nm = '';
	public $rm_typ = '';
	public $resvnum = '';
	public $geo1 = '';
	public $company_num = '';
	public $service_list = '';
	public $trust_num = '';
	public $crdt_cd = '';
	public $fax = '';
	public $channel_cd = 'WX';
	public $comm_amt = '';
	public $dcomm_amt = '';
	public $Fxcomm_amt = '';
	public $dfxcomm_amt = '';
	public $arr_flt = '';
	public $gh_num = '';
	public $bed_amt = 0;
	public $Meal_cnt = 0;
	public $subscription = 0;
	public $room_num = 0;
	public $bed_add = 0;
	public $breakfast_amt = 0;
	public $breakfast_add = 0;
	public $org_dt = '0001-01-01';
	public $people_num = 1;
	public $affirm_typ = 0;
	public $trust_dt = '0001-01-01';
	public $htl_typ = '';
	public $Favor_nums = 0;
	public $contact_tel = '';
	public $htl_cd = '099'; // 099为测试酒店
	public $org_cd = '';
//	public $coupon_amt = 0.0; // 新加属性
}