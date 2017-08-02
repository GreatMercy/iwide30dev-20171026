<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Shuxiang extends CI_Controller {
	/*
	 * 书香的接口测试，其 hotelGroupId=2
	 */
	private $url = 'http://202.107.192.24:8090/ipms';
	// private $url = 'http://61.177.58.132:11001/ipms';
	// private $url = 'http://221.133.244.43:38090/ipms';
	public function __construct() {
		parent::__construct ();
		$this->load->helper ( 'common_helper' );
	}
	function post_to($url, $data) {
		$this->load->helper ( 'common' );
		$send_content = http_build_query ( $data );
		$s = doCurlPostRequest ( $url, $send_content );
		/* 	$this->db->insert ( 'weixin_text', array (
		 'content' => $s . '--' . json_encode ( $data ) . '--' . $url,
		 'edit_date' => date ( 'Y-m-d H:i:s' )
		 ) ); */
		// var_dump ( $s );
		$s = json_decode ( $s, true );
		return $s;
	}
	function get_to($url, $data = array()) {
		$this->load->helper ( 'common' );
		$s = doCurlGetRequest ( $url );
		/* 
		 $this->db->insert ( 'weixin_text', array (
		 'content' => $s . '--' . json_encode ( $data ) . '--' . $url,
		 'edit_date' => date ( 'Y-m-d H:i:s' )
		 ) ); */
		// var_dump($url) ;
		// var_dump ( $s );
		$s = json_decode ( $s, true );
		return $s;
	}
	
	/*
	 * CRS/ResultRate 房价查询
	 */
	// http://61.177.58.132:11011/ipms/CRS/queryHotelList?date=2016-01-30&dayCount=2&cityCode=SZJS&rateCodes=&salesChannel=DG&hotelIds=9&hotelGroupId=2
	public function ResultRate() {
		// $url = $this->url . '/CRS/queryHotelList?date=2016-01-20&dayCount=2&cityCode=QDSD&rateCodes=MEM,RACK,ENT,MAN&salesChannel=WEB&hotelIds=13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36&hotelGroupId=2';
		$url = $this->url . '/CRS/queryHotelList';
		$data = array (
				'date' => date ( 'Y-m-d' ),
				'dayCount' => 2,
				'cityCode' => '',
				'brandCode' => '',
				'order' => '2',
				'firstResult' => 1,
				'pageSize' => 10,
				'rateCodes' => '',
				'salesChannel' => 'WEB',
				'hotelIds' => '18,19,20',
				/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
				'hotelGroupId' => 2 
		);
		$url .= '?' . http_build_query ( $data );
// 		echo $url;
		$res = $this->get_to ( $url );
// 		print_r ( $res );
		return $res;
		/*
		 * 返回信息：
		 * {"hrList":[{"hotelId":13},{"hotelId":14},{"hotelId":15},{"hotelId":16},{"hotelId":17},{"hotelId":18},{"hotelId":32},{"hotelId":33},{"hotelId":34},{"hotelId":30},{"hotelId":19},{"hotelId":20},{"hotelId":21},{"hotelId":22},{"hotelId":23},{"hotelId":24},{"hotelId":12},{"hotelId":11},{"hotelId":25},{"hotelId":31},{"hotelId":10},{"hotelId":9},{"hotelId":28},{"hotelId":29},{"hotelId":35},{"hotelId":36}],"totalRows":26,"resultCode":0}
		 */
	}
	function add_lvyun_room() {
		exit;
		$inter_id = 'a457946152';
		$pms_auth = array (
				'url' => 'http://202.107.192.24:8090/ipms1/CRS',
				'salesChannel' => 'WEB',
				'hotelGroupId' => 2 
		);
		$pms_auth = json_encode ( $pms_auth );
		$hotels = $this->ResultRate ();
// 		var_dump($hotels);
// 		exit;
		$hotel = array (
				'inter_id' => $inter_id 
		);
		$room = array (
				'inter_id' => $inter_id,
				'status' => 1 
		);
		$lowest = array (
				'inter_id' => $inter_id,
				'update_time' => date ( 'Y-m-d H:i:s' ) 
		);
		$addition = array (
				'inter_id' => $inter_id,
				'pms_type' => 'lvyun',
				'pms_auth' => $pms_auth,
				'pms_room_state_way' => 1,
				'pms_member_way' => 1 
		);
		$hotel_id = 1078;
		$room_id = 3978;
		foreach ( $hotels ['hrList'] as $hl ) {
			$hotel['name']='隐居_'.$hl['hotelId'];
			$hotel['hotel_id']=$hotel_id;
			$addition['hotel_id']=$hotel_id;
			$addition['hotel_web_id']=$hl['hotelId'];
			$room['hotel_id']=$hotel_id;
			$lowest['hotel_id']=$hotel_id;
			$lowest['lowest_price']=isset($hl['minRate'])?$hl['minRate']:0;
			
// var_dump($hotel);
// var_dump($addition);
// var_dump($lowest);
// exit;			
			$this->db->insert('hotel_lowest_price',$lowest);
			$this->db->insert('hotels',$hotel);
			$this->db->insert('hotel_additions',$addition);
			if(!empty($hl['rmtypes'])){
			foreach ($hl['rmtypes'] as $rt){
				$room['webser_id']=$rt['code'];
				$room['name']=$rt['descript'];
				$room['room_id']=$room_id;
				$this->db->insert('hotel_rooms',$room);
				$room_id++;
			}
			}
			$hotel_id++;
		}
		echo 'ok';
	}
	
	/*
	 * 1.11 每日房价【保留不用】
	 /CRS/rateQueryEveryDay
	 */
	public function rateQueryEveryDay() {
		$this->url .= '/CRS/rateQueryEveryDay?';
		$data = array (
				"rateCode" => "WL",
				"rmType" => "BD",
				"date" => "2016-01-15",
				"dayCount" => "1",
				"salesChannel" => "DG",
				"hotelId" => 13,
				"hotelGroupId" => "2" 
		);
		echo $this->url;
		$this->url.=http_build_query($data);
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"queryResult":[{"date":"2016-01-01 00:00:00","rate1":"338.00"}],"resultCode":0}
		 */
	}
	
	/*
	 * 预定列表
	 */
	public function findResrvList() {
		$this->url .= '/CRS/findResrvList?cardNo=1&arr=2015-12-03&dep=2015-12-28&crsNo=&hotelGroupId=1';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		/*
		 * 返回的信息：
		 * string '{"resrvList":[],"totalRows":0,"resultCode":0}' (length=45)
		 */
	}
	
	/*
	 * 1.3 订单详情 
	 /CRS/findResrvGuest
	 */
	public function findResrvGuest() {
		$this->url .= '/CRS/findResrvGuest?';
		$data = array (
				"cardNo" => "",
				"crsNo" => "W1601110009",
				"hotelGroupId" => "2" 
		);
		$res = doCurlGetRequest ( $this->url, $data );
		print_r ( json_decode($res,true) );
		/*
		 * 返回的信息如下：
		 * {"guest":{"idType":"01","sex":"1","paySta":"0","deposit":0.00,"rateTotal":338.00,"remark":"","hotelGroupId":2,"rmtype":"E1YNH","hotelDescript":"安溪宝龙艺筑酒店","cityCode":"QZFU","staDescript":"预订","rsvMan":"hong","sexDescript":"男","hotelId":5,"rate":338.00,"rmNum":1,"createDatetime":{"nanos":0},"name":"hong","rmtypeDescript":"高级双床舒适房","dep":"2016-01-02","idNo":"445213199202252338","crsNo":"W1512300001","sta":"R","arr":"2016-01-01","modifyDatetime":{"nanos":0},"email":"645030813@sina.cn","cityDescript":"泉州","rateSum":338.0,"mobile":"13580506405"},"resultCode":0}
		 */
	}
	
	/*
	 * 1.4 取消预定 （确实预订单）
	 /CRS/cancelbook
	 */
	public function cancelbook() {
		$this->url .= '/CRS/cancelbook?';
		$data = array (
				"cardNo" => "",
// 				"cardNo" => "00006491",
				"crsNo" => "W1601110008",
				"hotelGroupId" => "2" 
		);
		$res = doCurlGetRequest ( $this->url, $data );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"resultCode":0}
		 */
	}
	
	/*
	 * membercard/memberLogin 会员登录（因为接口重构，所以进行注释。）
	 */
	// public function memberLogin(){
	// $this->url .= '/membercard/memberLogin?loginId=13584874600&loginPassword=123456&hotelGroupId=2';
	// $res = doCurlGetRequest( $this->url );
	// print_r($res);
	// /*
	// * 当账号和密码正确时，返回信息如下：
	// * {"cardId":"168404","cardNo":"80030000216","sta":"Y","staDescript":"已用","cardType":"GCJK","cardTypeDescript":"积分储值卡计划","cardLevel":"CZKK","cardLevelDescript":"尊客卡","pointBalance":2500.0,"rateCode":"ZK","salesCode":"","keepTime":"","checkOutTime":"","memberId":42530,"name":"申现波(备份服务器测试库)","lastName":"申现波","sex":"1","sexDescript":"男性","idType":"01","idTypeDescript":"身份证","idNo":"110101201401022314","mobile":"13584874600","phone":"13584874600","email":"sxb@soocor.com","Street":"","loginTime":"2015-12-07 17:08:33","mobileBind":"T","emailBind":"F","isWechatMem":"F","cardListDto":[{"cardId":"168404","cardNo":"80030000216","sta":"Y","staDescript":"已用","cardType":"GCJK","cardTypeDescript":"积分储值卡计划","cardLevel":"CZKK","cardLevelDescript":"尊客卡","pointBalance":2500.0,"rateCode":"ZK","keepTime":"","isAccount":"T","checkOutTime":""}],"resultCode":0}
	// *
	// * 当账号或密码输入错误时，返回的信息如下：
	// * $this->url .= '/membercard/memberLogin?loginId=1&loginPassword=123&hotelGroupId=2';
	// * {"resultCode":6000,"resultMsg":"登录用户名或密码错误。"}
	// */
	// }
	
	/*
	 * membercard/registerMemberCardApply 会员注册
	 */
	public function registerMemberCardApply() {
		$this->url .= '/membercard/registerMemberCardApply?';
		$data = array (
				"name" => "hyman",
				"sex" => "1",
				"mobile" => "13502556581",
				"email" => "645030810@qq.com",
				"idType" => "01",
				"idNo" => "520520520520520",
				"verifyType" => "01",
				"verifyHost" => "645030813@qq.com",
				"password" => "12345678",
				"hotelGroupId" => "2" 
		);
		
		$res = doCurlGetRequest ( $this->url, $data );
		var_dump ( $res );
		/*
		 * 返回的信息如下：
		 * string '{"applyId":882,"resultCode":0,"resultMsg":"成功"}' (length=51)
		 * 每运行一次，applyId 自加一
		 */
	}
	
	/*
	 * /membercard/registerMemberCard 注册验证
	 */
	public function registerMemberCard() {
		$this->url .= '/membercard/registerMemberCard?applyId=894&mobileOrEmail=mobile&verifyCode=430149&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		/*
		 * applyId=894  对应的verifyCode = 430149 
		 * 返回的信息为：
		 * string '{"resultCode":6001,"resultMsg":"会员信息错误，验证不通过。"}' (length=73)
		 */
	}
	
	/*
	 * /membercard/getPointList 会员积分列表
	 */
	public function getPointList() {
		$this->url .= '/membercard/getPointList?';
		$data = array (
				"cardId" => "58173", // cardNo
				"beginDate" => "2015-10-01",
				"endDate" => "2015-11-01",
				"firstResult" => "0",
				"pageSize" => "1",
				"hotelGroupId" => "2" 
		);
		$res = doCurlGetRequest ( $this->url, $data );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"totalRows":0,"pointBalance":0.0,"pointCharge":0.0,"pointPromotionTan":0.0,"cardPointList":[],"resultCode":0,"resultMsg":"成功"}
		 */
	}
	
	/*
	 * /membercard/updateMember 会员信息修改
	 */
	public function updateMember() {
		$this->url .= '/membercard/updateMember?memberId=168404&street=BJ&newPassword=123456&oldPassword=123456' . '&hotelGroupId=1';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		/*
		 * 当全部信息输入均正确时，返回的信息为：
		 * string '{"resultCode":0,"resultMsg":"成功"}' (length=37)
		 * 
		 * 当卡号输入错误时，$this->url .= '/membercard/updateMember?memberId=80030000216&street=BJ&newPassword=123456&oldPassword=123456' . '&hotelGroupId=2';
		 * 返回的信息为：
		 * string '{"resultCode":6004,"resultMsg":"会员信息不存在。"}' (length=58)
		 * 
		 * 当旧密码输入错误时，$this->url .= '/membercard/updateMember?memberId=168404&street=BJ&newPassword=123456&oldPassword=123' . '&hotelGroupId=2';
		 * 返回的信息为：
		 * string '{"resultCode":7013,"resultMsg":"会员登录密码输入错误"}' (length=64)
		 */
	}
	
	/*
	 * /membercard/getExchangItemList 积分兑换物品列表
	 */
	public function getExchangItemList() {
		$this->url .= '/membercard/getExchangItemList?' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		print_r ( $res );
		/*
		 * 返回的信息如下:
		 * {"totalRows":2,"cardExchangeItemList":[{"code":"HUH22789","descript":"内野 素色绣字毛巾组 ","descriptEn":"内野 素色绣字毛巾组 HUH22789 ","category":"QTDH","amount":1,"exchangeUnit":"套","point":5600.00,"stocks":4,"special":"","pic":134617,"picUrl":"http://122.224.65.101:38090/pic/CardExchangeItem/201411/31/cbded46dca6c4e97a554c65608bf5f1f.jpg","descriptDetail":"内野 素色绣字毛巾组","isHalt":"F","listOrder":1,"codeType":"1","groupCode":"HUH22789","isGroup":"T","cardTypeCodes":"GJFK,GCJK,GCZK,GWLK","createUser":"GTJ02","createDatetime":"2014-12-31 13:28:55","modifyUser":"GTJ02","modifyDatetime":"2014-12-31 13:28:55","id":1,"hotelId":0,"hotelGroupId":2},{"code":"TA31070112","descript":"多样屋 英格兰化妆包方巾礼盒组-粉 ","descriptEn":"多样屋 英格兰化妆包方巾礼盒组-粉","category":"QTDH","amount":1,"exchangeUnit":"套","point":4600.00,"stocks":4,"special":"","picUrl":"","descriptDetail":"多样屋 英格兰化妆包方巾礼盒组-粉 ","isHalt":"F","listOrder":2,"codeType":"1","groupCode":"TA31070112","isGroup":"T","cardTypeCodes":"GJFK,GCJK,GCZK,GWLK","createUser":"GTJ02","createDatetime":"2014-12-31 13:30:01","modifyUser":"GTJ02","modifyDatetime":"2014-12-31 13:30:01","id":27,"hotelId":0,"hotelGroupId":2}],"cardExchangeItemCategoryList":[{"code":"QTDH","descript":"前台兑换礼品","descriptEn":"前台兑换礼品"}],"hotelInfoDto":[{"hotelId":36,"code":"SX038","descript":"书香集团-无锡巡唐店","descripEn":"书香集团-无锡巡唐店","descriptShort":"书香集团-无锡巡唐店"},{"hotelId":13,"code":"SX002","descript":"书香集团-苏州园区店","descripEn":"书香集团-苏州园区店","descriptShort":"园区店"},{"hotelId":14,"code":"SX003","descript":"书香集团-上海店","descripEn":"书香集团-上海店","descriptShort":"上海店"},{"hotelId":15,"code":"SX004","descript":"书香集团-苏州树山店","descripEn":"书香集团-苏州树山店","descriptShort":"树山店"},{"hotelId":16,"code":"SX005","descript":"书香集团-苏州独墅湖店","descripEn":"书香集团-苏州独墅湖店","descriptShort":"独墅湖"},{"hotelId":17,"code":"SX006","descript":"书香集团-新区店","descripEn":"书香集团-新区店","descriptShort":"新区店"},{"hotelId":18,"code":"SX009","descript":"书香集团-苏州平江府店","descripEn":"书香集团-苏州平江府店","descriptShort":"平江府"},{"hotelId":19,"code":"SX019","descript":"书香集团-济南店","descripEn":"书香集团-济南店","descriptShort":"济南店"},{"hotelId":20,"code":"SX020","descript":"书香集团-无锡店","descripEn":"书香集团-无锡店","descriptShort":"无锡店"},{"hotelId":21,"code":"SX021","descript":"书香集团-南京店","descripEn":"书香集团-南京店","descriptShort":"南京店"},{"hotelId":22,"code":"SX022","descript":"书香集团-徐州店","descripEn":"书香集团-徐州店","descriptShort":"徐州店"},{"hotelId":23,"code":"SX023","descript":"书香集团-杭州店","descripEn":"书香集团-杭州店","descriptShort":"杭州店"},{"hotelId":24,"code":"SX024","descript":"书香集团-苏州新浒店","descripEn":"书香集团-苏州新浒店","descriptShort":"新浒店"},{"hotelId":12,"code":"SX025","descript":"书香集团-南通店","descripEn":"书香集团-南通店","descriptShort":"南通店"},{"hotelId":11,"code":"SX026","descript":"书香集团-南京中江店","descripEn":"书香集团-南京中江店","descriptShort":"中江店"},{"hotelId":25,"code":"SX027","descript":"书香集团-镇江店","descripEn":"书香集团-镇江店","descriptShort":"镇江店"},{"hotelId":31,"code":"SX028","descript":"书香集团-苏州月亮湾店","descripEn":"书香集团-苏州月亮湾店","descriptShort":"月亮湾"},{"hotelId":10,"code":"SX030","descript":"书香集团-湖西店","descripEn":"书香集团-湖西店","descriptShort":"湖西店"},{"hotelId":9,"code":"SX031","descript":"书香集团-山塘府邸","descripEn":"书香集团-山塘府邸","descriptShort":"山塘府邸"},{"hotelId":28,"code":"SX032","descript":"书香集团-大丰店","descripEn":"书香集团-大丰店","descriptShort":"大丰店"},{"hotelId":29,"code":"SX033","descript":"书香集团-通州湾","descripEn":"书香集团-通州湾","descriptShort":"通州湾"},{"hotelId":30,"code":"SX013","descript":"书香集团-胥城大厦","descripEn":"书香集团-胥城大厦","descriptShort":"胥城大厦"},{"hotelId":35,"code":"SX034","descript":"书香世家-神鹿家园","descripEn":"书香世家-神鹿家园","descriptShort":"神鹿家园"},{"hotelId":34,"code":"SX012","descript":"盘门店(关)","descripEn":"盘门店(关)","descriptShort":"盘门店(关)"},{"hotelId":33,"code":"SX011","descript":"木渎店(关)","descripEn":"木渎店(关)","descriptShort":"木渎店(关)"},{"hotelId":32,"code":"SX010","descript":"观前店(关)","descripEn":"观前店(关)","descriptShort":"观前店(关)"}],"resultCode":0,"resultMsg":"成功"}
		 */
	}
	
	/*
	 * /membercard/pointExchange 物品兑换
	 */
	public function pointExchange() {
		$this->url .= '/membercard/pointExchange?&code=SX002&remark=' . urlencode ( '书香集团-苏州园区店' ) . '&cardId=168404' . '&hotelGroupId=1';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		
		/*
		 * 当$this->url .= '/membercard/pointExchange?&code=SX002&remark='. urlencode('书香集团-苏州园区店') .'&cardId=168404' . '&hotelGroupId=2';
		 * 返回的信息如下：
		 * string '{"resultCode":6007,"resultMsg":"兑换物品不存在。"}' (length=58)
		 * 
		 * 当$this->url .= '/membercard/pointExchange?&code=HUH22789&remark='. urlencode('内野 素色绣字毛巾组') .'&cardId=168404' . '&hotelGroupId=2';
		 * 返回的信息如下：
		 * string '{"resultCode":6006,"resultMsg":"兑换需要的积分不足。"}' (length=64)
		 */
	}
	
	/*
	 * membercard/verifyMobileApply 申请修改手机号码
	 */
	public function verifyMobileApply() {
		$this->url .= '/membercard/verifyMobileApply?newMobile=13584874600&memberId=168404&verifyHost=123' . '&hotelGroupId=1';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		/*
		 * $this->url .= '/membercard/verifyMobileApply?newMobile=13584874600&memberId=168404&verifyHost=123' . '&hotelGroupId=2';
		 * 返回的信息如下：
		 * string '{"sendTo":"13584874600","resultCode":0,"resultMsg":"成功"}' (length=60)
		 *
		 * 当memberId为8404时，即不知卡号是否正确时， $this->url .= '/membercard/verifyMobileApply?newMobile=13584874600&memberId=8404&verifyHost=123' . '&hotelGroupId=2';
		 * 返回的信息为成功，如下：
		 * string '{"sendTo":"13584874600","resultCode":0,"resultMsg":"成功"}' (length=60)
		 * 
		 * 当memberId输入错误时，$this->url .= '/membercard/verifyMobileApply?newMobile=13584874600&memberId=1&verifyHost=123' . '&hotelGroupId=2';
		 * 返回的信息如下：
		 * string '{"resultCode":6004,"resultMsg":"会员信息不存在。"}' (length=58)
		 */
	}
	
	/*
	 * 3.7 确认修改手机号码 （多了个字符t）（缺少验证码验证）
	 /membercard/verifyMobilet
	 */
	public function verifyMobilet() {
		$this->url .= '/membercard/verifyMobile?';
		$data = array (
				"newMobile" => "13580506405",
				"memberId" => "58173",
				"verifyCode" => "123",
				"hotelGroupId" => "2" 
		);
		$res = doCurlGetRequest ( $this->url, $data );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"resultCode":6001,"resultMsg":"会员信息错误，验证不通过。"}
		 */
	}
	
	/*
	 * membercard/verifyEmailApply 申请修改邮箱
	 */
	public function verifyEmailApply() {
		$this->url .= '/membercard/verifyEmailApply?newEmail=645030813@qq.com&memberId=168404&verifyHost=645030813@qq.com' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		/*
		 * 当memberId为8404时，即不知卡号是否正确时，$this->url .= '/membercard/verifyEmailApply?newEmail=sxb@soocor.com&memberId=8404&verifyHost=123' . '&hotelGroupId=2';
		 * 返回的信息如下：
		 * string '{"sendTo":"sxb@soocor.com","resultCode":0,"resultMsg":"成功"}' (length=63)
		 * 
		 * 当member为正确时，$this->url .= '/membercard/verifyEmailApply?newEmail=sxb@soocor.com&memberId=168404&verifyHost=123' . '&hotelGroupId=2';
		 * 返回的信息如下：
		 * string '{"sendTo":"sxb@soocor.com","resultCode":0,"resultMsg":"成功"}' (length=63)
		 * 
		 * 当memberId为4时，即卡号错误时，$this->url .= '/membercard/verifyEmailApply?newEmail=sxb@soocor.com&memberId=4&verifyHost=123' . '&hotelGroupId=2';
		 * 返回的信息如下：
		 * string '{"resultCode":6004,"resultMsg":"会员信息不存在。"}' (length=58)
		 */
	}
	
	/*
	 * membercard/verifyEmail 确认修改邮箱
	 */
	public function verifyEmail() {
		$this->url .= '/membercard/verifyEmail?newEmail=sxb@soocor.com&memberId=168404&verifyCode=430149' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		/*
		 * 测试代码：http://61.177.58.132:11001/ipms/membercard/verifyEmail?newEmail=645030813@qq.com&memberId=168404&verifyCode=123&hotelGroupId=2
		 * 返回的数据为：
		 * {"resultCode":6002,"resultMsg":"验证码错误或已过期。"}
		 * 
		 * 测试代码：http://61.177.58.132:11001/ipms/membercard/verifyEmail?newEmail=sxb@soocor.com&memberId=168404&verifyCode=430149&hotelGroupId=2
		 * 返回的信息为：
		 * {"resultCode":3,"resultMsg":"该邮箱号已有会员登记使用，请确认该邮箱号(sxb@soocor.com)的实际归属!"}
		 */
	}
	
	/*
	 * 3.10 重置密码 (报错)
	 /membercard/resetPassword
	 */
	public function resetPassword() {
		$this->url .= '/membercard/resetPassword?';
		$data = array (
				"loginId" => "80010003694", // cardId:58173
				"memberName" => "JACK",
				"sendType" => "13516706382",
				"hotelGroupId" => "2" 
		);
		$res = doCurlGetRequest ( $this->url, $data );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"resultCode":6011,"resultMsg":"手机格式错误。"}
		 * {"resultCode":6004,"resultMsg":"会员信息不存在。"}
		 * {"resultCode":6001,"resultMsg":"会员信息错误，验证不通过。"}
		 */
	}
	
	/*
	 * web/webSyncHotel 同步酒店信息
	 */
	public function webSyncHotel() {
		$this->url .= '/web/webSyncHotel?' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"hotelList":[{"id":9,"code":"SX031","descript":"书香集团-山塘府邸","shortDescript":"山塘府邸","roomNum":28,"phone":"0512-67879889","fax":"0512-67879009","address":"江苏苏州市山塘街88号 ","provinceCode":"JS","cityCode":"SZJS","cityDescript":"苏州","districtCode":"320500","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":18,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"5","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":10,"code":"SX030","descript":"书香集团-湖西店","shortDescript":"湖西店","roomNum":137,"phone":"0512-67333999","fax":"0512-67632999","address":"江苏苏州市工业园区苏桐路37号","provinceCode":"JS","cityCode":"SZJS","cityDescript":"苏州","districtCode":"320500","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":17,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":11,"code":"SX026","descript":"书香集团-南京中江店","shortDescript":"中江店","roomNum":149,"phone":"025-85233888","fax":"025-85233777","address":"江苏省南京市秦淮区三元巷7号","provinceCode":"JS","cityCode":"NJJS","cityDescript":"南京","districtCode":"320100","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":14,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":12,"code":"SX025","descript":"书香集团-南通店","shortDescript":"南通店","roomNum":97,"phone":"0513-81013888","fax":"0513-81013777","address":"江苏南通市崇川区经济技术开发区星湖街区A区22、26幢","provinceCode":"JS","cityCode":"NT","cityDescript":"南通","districtCode":"320600","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":13,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":13,"code":"SX002","descript":"书香集团-苏州园区店","shortDescript":"园区店","roomNum":108,"phone":"0512-67635888","fax":"0512-67630777","address":"江苏苏州园区苏惠路158号","provinceCode":"JS","cityCode":"SZJS","cityDescript":"苏州","districtCode":"320500","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":1,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":14,"code":"SX003","descript":"书香集团-上海店","shortDescript":"上海店","roomNum":190,"phone":"021-51182666","fax":"021-51182628","address":"上海闵行区吴中路1389号","provinceCode":"SH","cityCode":"SHSH","cityDescript":"上海","districtCode":"310112","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":2,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":15,"code":"SX004","descript":"书香集团-苏州树山店","shortDescript":"树山店","roomNum":114,"phone":"0512-66066888","fax":"0512-66060777","address":"江苏苏州新区通安镇树山村生态休闲广场","provinceCode":"JS","cityCode":"SZJS","cityDescript":"苏州","districtCode":"320500","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":3,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":16,"code":"SX005","descript":"书香集团-苏州独墅湖店","shortDescript":"独墅湖","roomNum":181,"phone":"0512-62795888","fax":"0512-62790777","address":"江苏苏州园区通达路2699号","provinceCode":"JS","cityCode":"SZJS","cityDescript":"苏州","districtCode":"320500","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":4,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":17,"code":"SX006","descript":"书香集团-新区店","shortDescript":"新区店","roomNum":95,"phone":"0512-87655888","fax":"0512-87650777","address":"江苏苏州新区玉山路60号","provinceCode":"JS","cityCode":"SZJS","cityDescript":"苏州","districtCode":"320500","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":5,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":18,"code":"SX009","descript":"书香集团-苏州平江府店","shortDescript":"平江府","roomNum":130,"phone":"0512-67706688","fax":"0512-67779688","address":"江苏苏州市平江区白塔东路60号","provinceCode":"JS","cityCode":"SZJS","cityDescript":"苏州","districtCode":"320500","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":6,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"5","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":19,"code":"SX019","descript":"书香集团-济南店","shortDescript":"济南店","roomNum":123,"phone":"0531-66570666","fax":"0531-66570667","address":"山东济南市新宇路以西世纪财富中心D座1-3层","provinceCode":"SD","cityCode":"JNSD","cityDescript":"济南","districtCode":"370100","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":7,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":20,"code":"SX020","descript":"书香集团-无锡店","shortDescript":"无锡店","roomNum":158,"phone":"0510-85175000","fax":"0510-85578800","address":"江苏无锡市滨湖区震泽路899号（江南大学南门对面）","provinceCode":"JS","cityCode":"WXJS","cityDescript":"无锡","districtCode":"320200","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":8,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":21,"code":"SX021","descript":"书香集团-南京店","shortDescript":"南京店","roomNum":115,"phone":"025-86819888","fax":"025-85233777","address":"江苏南京市鼓楼区管家桥65号新华大厦内","provinceCode":"JS","cityCode":"NJJS","cityDescript":"南京","districtCode":"320106","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":9,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":22,"code":"SX022","descript":"书香集团-徐州店","shortDescript":"徐州店","roomNum":129,"phone":"0516-83066666","fax":"0516-83907677","address":"江苏徐州市建国东路219号","provinceCode":"JS","cityCode":"XZJS","cityDescript":"徐州","districtCode":"320300","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":10,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":23,"code":"SX023","descript":"书香集团-杭州店","shortDescript":"杭州店","roomNum":187,"phone":"0571-88468888","fax":"0571-88465497","address":"浙江省杭州市莫干山路246号","provinceCode":"ZJ","cityCode":"HZZJ1","cityDescript":"杭州","districtCode":"330100","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":11,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":24,"code":"SX024","descript":"书香集团-苏州新浒店","shortDescript":"新浒店","roomNum":55,"phone":"0512-66717188","fax":"0512-66717288","address":"江苏苏州市高新区浒关浒杨工业园浒杨路81号","provinceCode":"JS","cityCode":"SZJS","cityDescript":"苏州","districtCode":"320500","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":12,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":25,"code":"SX027","descript":"书香集团-镇江店","shortDescript":"镇江店","roomNum":115,"phone":"0511-85826888","fax":"0511-85826777","address":"江苏镇江市润州区冠城路8号工人大厦镇江市","provinceCode":"JS","cityCode":"ZJJS","cityDescript":"镇江","districtCode":"321111","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":15,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":28,"code":"SX032","descript":"书香集团-大丰店","shortDescript":"大丰店","roomNum":53,"phone":"0515-83239999","fax":"0515-83378602","address":"江苏大丰市城东新区春柳北路19号","provinceCode":"JS","cityCode":"DFJS","cityDescript":"大丰","districtCode":"320982","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":19,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":29,"code":"SX033","descript":"书香集团-通州湾","shortDescript":"通州湾","roomNum":57,"phone":"0513-86222999 ","fax":"0513-81687053","address":"江苏南通滨海园区海盐路6号","provinceCode":"JS","cityCode":"NT","cityDescript":"南通","districtCode":"320600","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":20,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":30,"code":"SX013","descript":"书香集团-胥城大厦","shortDescript":"胥城大厦","roomNum":392,"phone":"0512-68286688","fax":"0512-68364319","address":"江苏苏州市三香路333号","provinceCode":"JS","cityCode":"SZJS","cityDescript":"苏州","districtCode":"320500","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":21,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":31,"code":"SX028","descript":"书香集团-苏州月亮湾店","shortDescript":"月亮湾","roomNum":147,"phone":"0512-67956888","fax":"0512-67956716","address":"苏州工业园区独墅湖高教区若水路398号","provinceCode":"JS","cityCode":"SZJS","cityDescript":"苏州","districtCode":"320500","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":16,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":35,"code":"SX034","descript":"书香世家-神鹿家园","shortDescript":"神鹿家园","roomNum":46,"phone":"0515-83393399","fax":"0515-83391939","address":"江苏省大丰麋鹿园国家级自然保护区 ","provinceCode":"JS","cityCode":"DFJS","cityDescript":"大丰","districtCode":"320982","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":22,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""},{"id":36,"code":"SX038","descript":"书香集团-无锡巡唐店","shortDescript":"书香集团-无锡巡唐店","roomNum":115,"phone":"","fax":"","address":"江苏省无锡市","provinceCode":"JS","cityCode":"WXJS","cityDescript":"无锡","districtCode":"320200","townCode":"","shoppingDistrictCode":"","scenicSpotCode":"","listOrder":0,"sta":"I","bookListOrder":"0","brandCode":"001","brandImg":"","startLevel":"4","score":"0.0","extraFlag":"","mainImg":"","mapImage":"","smallRmImg":"","bigRmImg":"","remarket":""}],"resultCode":0,"resultMsg":"查询成功"}
		 */
	}
	
	/*
	 * membercard/getAccountList 获取会员储值记录列表
	 */
	public function getAccountList() {
		$this->url .= '/membercard/getAccountList?cardId=280242&beginDate=2014-10-12&endDate=2015-12-01' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		print_r ( $res );
		/*
		 * 当member换成membercard时
		 * 返回的数据如下：
		 * {"totalRows":0,"accountBalance":0.0,"accountFreeze":0.0,"accountCredit":0.0,"accountList":[],"resultCode":0,"resultMsg":"成功"}
		 * 
		 * cardId=168404恰好没有储值纪录，
		 * 示例如下：
		 *	http://61.177.58.132:11001/ipms/membercard/getAccountList?cardId=280242&beginDate=2014-10-12&endDate=2015-12-01&hotelGroupId=2
		 * 返回的信息：
		 * {"totalRows":1,"accountBalance":1.0,"accountFreeze":0.0,"accountCredit":0.0,"accountList":[{"cardId":280242,"taDescript":"人民币现金","account_type":"充值","amount":1.0,"hotel":19,"remark":"","createDate":"2015-04-02 12:23:46"}],"resultCode":0,"resultMsg":"成功"}
		 */
	}
	
	/*
	 * 3.12 旧卡激活
	 /membercard/reactiveCard
	 */
	public function reactiveCard() {
		$this->url .= '/membercard/reactiveCard?';
		$data = array (
				"cardno" => "00006491",
				"name" => "hong",
				"mobileOrEmail" => "13580506405",
				"hotelGroupId" => "2" 
		);
		$res = doCurlGetRequest ( $this->url, $data );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"resultCode":6022,"resultMsg":"会员已激活。"}
		 */
	}
	
	/*
	 * CRS/saveWebPay 支付金额录入订金
	 */
	public function saveWebPay() {
		$this->url .= '/CRS/saveWebPay?crsNo=123&money=123&taNo=9600&taRemark=123' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		/*
		 * 接口文档中少了两个参数，taNo（会员卡的付款方式为 9600 ；人民币现金为 9000） 和 taRemark(备注信息)
		 * 返回的信息如下：
		 * string '{"resultCode":1}' (length=16)
		 */
	}
	
	/*
	 * membercard/giftPointToMember 积分促销接口
	 */
	public function giftPointToMember() {
		$this->url .= '/membercard/giftPointToMember?cardId=168404&triggerWay=MEMWEBREVIEW' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		/*
		 * 当cardId输入正确的卡号168404时，
		 * 返回的结果如下：
		 * string '{"resultCode":0}' (length=16)
		 * 
		 * 当cardId输入错误的8404时，
		 * 返回的结果如下：
		 * string '{"resultCode":6003}' (length=19)
		 */
	}
	
	/*
	 * CRS/findCouponDetailListByCardNo 根据会员卡号获得电子券列表
	 */
	public function findCouponDetailListByCardNo() {
		$this->url .= '/CRS/findCouponDetailListByCardNo?cardNo=168404' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		/*
		 * 接口参数错误,接口文档中标识的参数为cardId,
		 * 测试代码：$this->url .= '/CRS/findCouponDetailListByCardNo?cardId=168404' . '&hotelGroupId=2';
		 * 返回的信息如下：
		 * string '{"resultCode":1,"resultMsg":"Required String parameter \u0027cardNo\u0027 is not present"}' (length=90)
		 * 
		 * 正确的参数应该为 cardNo，
		 * 测试代码：$this->url .= '/CRS/findCouponDetailListByCardNo?cardNo=168404' . '&hotelGroupId=2';
		 * 返回的信息如下：
		 * string '{"couponList":[],"totalRows":0,"resultCode":0,"resultMsg":"调用成功"}' (length=73)
		 * */
	}
	
	/*
	 * 1.1 订单提交
	 /CRS/book
	 */
	public function book() {
		$this->url .= '/CRS/book?';
		$data = array (
				"arr" => "2016-01-01 12:00:00",
				"dep" => "2016-01-02 12:00:00",
				"rmtype" => "E1YNH", // 房型代码
				"rateCode" => "TA", // MEM,RACK,ENT,MAN 房价码
				"rmNum" => "1",
				"rsvMan" => "hong",
				"sex" => "1",
				"mobile" => "13580506405",
				"email" => "645030813@sina.cn",
				"idType" => "01",
				"idNo" => "445213199202252338",
				"cardType" => "YJ",
				"cardNo" => "00006491",
				"adult" => "1",
				"remark" => "",
				"disAmount" => "0",
				"saleChannel" => "",
				"hotelId" => "5",
				"hotelGroupId" => "2" 
		);
		$res = doCurlGetRequest ( $this->url, $data );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"crsNo":"W1512300002","paySta":"0","deposit":0,"resultCode":0}
		 */
	}
	
	/*
	 * membercard/registerMemberCardWithOutVerify 非验证性会员注册
	 */
	public function registerMemberCardWithOutVerify() {
		$this->url .= '/membercard/registerMemberCardWithOutVerify?';
		$data = array (
				"name" => "hyman",
				"sex" => "1",
				"mobile" => "13502556581",
				"email" => "645030810@qq.com",
				"idType" => "01",
				"idNo" => "520520520520520",
				"verifyType" => "01",
				"verifyHost" => "645030813@qq.com",
				"password" => "12345678",
				"hotelGroupId" => "2" 
		);
		$res = doCurlGetRequest ( $this->url, $data );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"cardId":"280246","cardNo":"80010001116","sta":"I","staDescript":"有效","cardType":"GWLK","cardTypeDescript":"网络卡","cardLevel":"CWSK","cardLevelDescript":"网尚客","pointBalance":0.0,"rateCode":"SK","salesCode":"","keepTime":"","checkOutTime":"","memberId":280263,"name":"hyman","lastName":"hyman","sex":"2","sexDescript":"女性","birth":"1952-05-20 01:00:00","idType":"01","idTypeDescript":"身份证","idNo":"520520520520520","mobile":"13502556581","email":"645030810@qq.com","mobileBind":"T","emailBind":"T","isWechatMem":"F","cardListDto":[{"cardId":"280246","cardNo":"80010001116","sta":"I","staDescript":"有效","cardType":"GWLK","cardTypeDescript":"网络卡","cardLevel":"CWSK","cardLevelDescript":"网尚客","pointBalance":0.0,"rateCode":"SK","keepTime":"","isAccount":"F","checkOutTime":""}],"resultCode":0}
		 */
	}
	
	/*
	 * membercard/onlineSalesCoupon 单独电子券发放
	 */
	public function onlineSalesCoupon() {
		$this->url .= '/membercard/onlineSalesCoupon?cardNo=80030000216&number=1&couponCode=123&startDate=2015-12-8&endDate=2015-12-10' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		print_r ( $res );
		/*
		 * $this->url .= '/membercard/onlineSalesCoupon?cardNo=168404&number=1&couponCode=123&startDate=2015-12-8&endDate=2015-12-10' . '&hotelGroupId=2';
		 * 返回的结果如下：
		 * {"resultCode":7007,"resultMsg":"卡号为168404的会员卡不存在!"}
		 * 
		 * $this->url .= '/membercard/onlineSalesCoupon?cardNo=80030000216&number=1&couponCode=123&startDate=2015-12-8&endDate=2015-12-10' . '&hotelGroupId=2';
		 * {"resultCode":1,"resultMsg":"电子券代码不存在"}
		 */
	}
	
	/*
	 * membercard/verifyOpenIdIsExists 微信Openid检查是否存在
	 */
	public function verifyOpenIdIsExists() {
		$this->url .= '/membercard/verifyOpenIdIsExists?openIdUserId=ojTzOww-9bzxheadiX3ravbi0v_o&openIdType=WEIXIN' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		/*
		 * 返回的信息如下：
		 * string '{"resultCode":-1,"resultMsg":"账号绑定信息不存在"}' (length=59)
		 */
	}
	
	/*
	 * membercard/bindOpenId 微信账号绑定已有会员卡接口
	 */
	public function bindOpenId() {
		$this->url .= '/membercard/bindOpenId?memberId=168404&openIdUserId=ojTzOww-9bzxheadiX3ravbi0v_o&openIdType=WEIXIN' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		var_dump ( $res );
		/*
		 * 返回的信息如下：
		 * string '{"resultCode":0,"resultMsg":""}' (length=31)
		 */
	}
	
	/*
	 * membercard/registerMemberCardWithOutVerify 微信账号注册新会员接口
	 */
	// public function registerMemberCardWithOutVerify(){
	// $this->url .= '/membercard/registerMemberCardWithOutVerify?name=申现波&sex=1&mobile=13524874600&email=sxb@soocor.com&idType=01&idNo=110101201401022314&openIdUserId=ojTzOww-9bzxheadiX3ravbi0v_o&openIdType=WEIXIN&password=123456&' . '&hotelGroupId=2';
	// $res = doCurlGetRequest( $this->url );
	// var_dump($res);
	// /*
	// * 返回的信息如下：
	// * string '{"resultCode":3,"resultMsg":"该手机号已注册成为会员，请检查输入是否正确或使用导入功能。"}' (length=118)
	// */
	// }
	
	/*
	 * /membercard/memberLogin 微信账号登陆接口
	 */
	public function memberLogin() {
		$this->url .= '/membercard/memberLogin?';
		$data = array (
				"loginId" => "80010001116", // cardNo
				"loginPassword" => "12345678",
				"hotelGroupId" => "2" 
		);
		$res = doCurlGetRequest ( $this->url, $data );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"cardId":"280246","cardNo":"80010001116","sta":"I","staDescript":"有效","cardType":"GWLK","cardTypeDescript":"网络卡","cardLevel":"CWSK","cardLevelDescript":"网尚客","pointBalance":0.0,"rateCode":"SK","salesCode":"","keepTime":"","checkOutTime":"","memberId":280263,"name":"hyman","lastName":"hyman","sex":"2","sexDescript":"女性","birth":"1952-05-20 01:00:00","idType":"01","idTypeDescript":"身份证","idNo":"520520520520520","mobile":"13502556581","email":"645030810@qq.com","loginTime":"2015-12-30 14:52:30","mobileBind":"T","emailBind":"T","isWechatMem":"F","cardListDto":[{"cardId":"280246","cardNo":"80010001116","sta":"I","staDescript":"有效","cardType":"GWLK","cardTypeDescript":"网络卡","cardLevel":"CWSK","cardLevelDescript":"网尚客","pointBalance":0.0,"rateCode":"SK","keepTime":"","isAccount":"F","checkOutTime":""}],"resultCode":0}
		 */
	}
	
	/*
	 * /membercard/memberPay 储值卡支付
	 */
	// public function memberPay(){
	// $this->url .= '/membercard/memberPay?cardId=168404&password=123456&money=0.01&cardNo=80030000216&taCode=1&crsNo=1' . '&hotelGroupId=2';
	// $res = doCurlGetRequest( $this->url );
	// print_r($res);
	// /*
	// * 返回信息：404界面
	// */
	// }
	
	/*
	 * /membercard/memberPay 储值卡充值
	 */
	public function memberPay() {
		$this->url .= '/membercard/memberPay?cardId=168404&password=123456&money=0.01&cardNo=80030000216&taCode=1&crsNo=1' . '&hotelGroupId=2';
		$res = doCurlGetRequest ( $this->url );
		print_r ( $res );
		/*
		 * 返回信息：404界面
		 */
	}
	
	/*
	 * 1.8 使用电子券预订	（缺少电子券，类型代码）
	 /CRS/bookWithCoupon
	 */
	public function bookWithCoupon() {
		$this->url .= '/CRS/bookWithCoupon?';
		$data = array (
				"arr" => "2016-01-01 12:00:00",
				"dep" => "2016-01-02 12:00:00",
				"rmtype" => "E1YNH", // 房型代码
				"rateCode" => "TA", // MEM,RACK,ENT,MAN 房价码
				"rmNum" => "1",
				"rsvMan" => "hong",
				"sex" => "1",
				"mobile" => "13580506405",
				"email" => "645030813@sina.cn",
				"idType" => "01",
				"idNo" => "445213199202252338",
				"cardType" => "YJ",
				"cardNo" => "00006491",
				"adult" => "1",
				"remark" => "",
				"disAmount" => "0",
				"saleChannel" => "WEB",
				"src" => "INC",
				"market" => "IDS",
				"couponDetailCode" => "", // 电子券编号
				"couponCode" => "", // 电子券类型代码
				"costValue" => "-100", // 电子券优惠金额
				"cosType" => "P", // 电子券类型
				"startDate" => "",
				"endDate" => "",
				"hotelId" => "5",
				"hotelGroupId" => "2" 
		);
		$res = doCurlGetRequest ( $this->url, $data );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"resultCode":1,"resultMsg":"length too little"}
		 */
	}
	
	/*
	 * 1.12 储值卡支付 (补上参数hotelGroupId)
	 /CRS/saveMemberCardPay
	 */
	public function saveMemberCardPay() {
		$this->url .= '/CRS/saveMemberCardPay?';
		$data = array (
				"cardId" => "58173",
				"password" => "123456",
				"money" => "100.00",
				"cardNo" => "00006491",
				"taCode" => "112",
				"crsNo" => "W1512300002",
				"taNo" => "1",
				"taRemark" => "1",
				"hotelGroupId" => "2" 
		);
		$res = doCurlGetRequest ( $this->url, $data );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"resultCode":6024,"resultMsg":"会员储值卡余额不足。"}
		 */
	}
	
	/*
	 * 1.13 房量接口[20150604 新增接口]
	 /LMM/otaRateDatas
	 */
	public function otaRateDatas() {
		$this->url .= '/LMM/otaRateDatas?';
		$data = array (
				"cardId" => "58173",
				"password" => "123456",
				"money" => "100.00",
				"cardNo" => "00006491",
				"taCode" => "112",
				"crsNo" => "W1512300002",
				"taNo" => "1",
				"taRemark" => "1",
				"hotelGroupId" => "2" 
		);
		$res = doCurlPOSTRequest ( $this->url, json_encode ( $data ) );
		print_r ( $res );
		/*
		 * 返回的信息如下：
		 * {"resultCode":0,"resultMessage":"返回成功","resultInfos":[]}
		 */
	}
}