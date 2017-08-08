<?php
	require_once 'lib/nusoap.php';
//用于查看发送的头部信息和相应信息	
//	echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
//	echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
	
/*
备注：
先调用get_sessionid，将返回ASP.NET_SessionId的值，再将ASP.NET_SessionId存入cookie打包发送至接口即可，ASP.NET_SessionId两小时需重新调用

两种业务如果有会员登录，与关联的用initOrder2,SaveOrder；如果不是会员只能定会员价，会员价是SaveOrder4_2
initOrder2就是支持所有类型订单

可以使用的订单接口有：
84、 初始定单数据(带各种订单功能的）（InitOrder2）
87、 初始定单数据	（InitOrder）
91、 保存订单,返回XML结果数据带，订单 首晚应付金额，金额应付金额 ,去哪儿ppb		（SaveOrder4_2）
93、 越早定越便宜保存订单,返回XML结果数据带，订单 首晚应付金额，金额应付金额,去哪儿越早 （SaveOrder4_3）
116、 保存订单 （SaveOrder）
 */

	//获取ASP.NET_SessionId
	function get_sessionid(){
		//1、 获得传输密钥 Podinn.WapService.GetSecurityKey
		$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
		$client->soap_defencoding = 'UTF-8';  
		$client->decode_utf8 = false;  
		$client->xml_encoding = 'UTF-8'; 
		$client->call ( 'GetSecurityKey', array() );
		$key = $client->document;
		$cookie = $client->getCookies();
	
		//181、 加密函数（DES），此函数为各自开发语言实现，正式时不开放接口
		$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
		$client->soap_defencoding = 'UTF-8';  
		$client->decode_utf8 = false;  
		$client->xml_encoding = 'UTF-8'; 
		$client->setCookie("ASP.NET_SessionId", $cookie[0]["value"]);
		$client->call ( 'Encode', array("str"=>"test") );
		$p = $client->document;
		$ps = simplexml_load_string($p);
	
		//2、 验证接口访问权限 Podinn.WapService.WebServiceLogin
		$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
		$client->soap_defencoding = 'UTF-8';
		$client->setCookie("ASP.NET_SessionId", $cookie[0]["value"]);
		$client->decode_utf8 = false;  
		$client->xml_encoding = 'UTF-8'; 
		$data = array("userName"=>$ps->EncodeResult,"password"=>$ps->EncodeResult);
		$client->call ( 'WebServiceLogin', $data);
		$p = $client->document;	
		$cookie = $client->getCookies();	
		return $cookie[0]['value'];	
	}

	// $res = get_sessionid();	//ASP.NET_SessionId，第一次开启，当调用接口时返回无权限则再次调用即可。
	// var_dump($res);
	$session_key = 'nuihf4mtgpm4yx0occ2on5qa';	//密钥
	//会员标识
	$user_id = '337B782CDCBB2D8B6069DEDB7D39273C787769064DC7C94A71211BB70E2505AB903DD7B322DB351697D8B7C9D82D633EE2DA05D0A13ECDBFD8129EDB37AF8785FD1D6F8FA653D6A406C145A83D6DEA549746FD86B976800A5B393927877B22D096ED19233294C6CCD8C598B2750459A955243EFE7F0CD0339EAFAF325E1EDE28FFFD960C6050FBD1E5D34028235C4C02';

	//加密
	function encode( $session_key , $value ){
		$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
		$client->soap_defencoding = 'UTF-8';  
		$client->decode_utf8 = false;  
		$client->xml_encoding = 'UTF-8'; 
		$client->setCookie("ASP.NET_SessionId", $session_key);
		$client->call ( 'Encode', array("str" => $value) );
		$p = $client->document;
		$ps = simplexml_load_string($p);
		return $ps->EncodeResult;
	}

	//12、 普通会员注册（带返回注册卡号） 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"email"=>'645030000@qq.com',
	// 	"mobile"=>'13580506000',
	// 	'password'=>'123123',
	// 	'mobileWay'=>'mobile_wap',
	// 	'sfz'=>'440112199001077557'
	// );
	// $client->call ( 'Register2',$data);
	// $p = $client->document;
	// var_dump($p);
	//返回信息：<Register2Response xmlns="http://tempuri.org/"><Register2Result>OK00051630</Register2Result></Register2Response>
	
	//13、 会员卡注册，可以送优惠券 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"email"=>'ws645030810@sina.cn',
	// 	"name"=>"hong",
	// 	"mobile"=>'13502556580',
	// 	'password'=>'123123',
	// 	'regType'=>'WAP_REG_YI',
	// 	'sfz'=>'44011119820418751X'
	// );
	// $client->call ( 'Register3',$data);
	// $p = $client->document;
	// var_dump($p);
	//<Register3Response xmlns="http://tempuri.org/"><Register3Result>EX_促销礼包不存在</Register3Result></Register3Response>
	
	//11、 普通网站会员注册
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"email"=>'ws645030813@sina.cn',
//		"name"=>"hong",
//		"mobile"=>'13502556584',
//		'password'=>'123123',
//		'mobileWay'=>'mobile_wap'
//	);
//	$client->call ( 'Register',$data);
//	$p = $client->document;
//	var_dump($p);
	//<RegisterResponse xmlns="http://tempuri.org/"><RegisterResult>OK</RegisterResult></RegisterResponse>
	
	//6、 会员登录 
// 	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
// 	$client->soap_defencoding = 'UTF-8';
// 	$client->setCookie("ASP.NET_SessionId", $session_key );
// 	$client->decode_utf8 = false;  
// 	$client->xml_encoding = 'UTF-8'; 
// 	$data = array(
// 		"userName"=>'645030813@qq.com',
// 		"IsTravel"=>"0",
// 		'password'=>'123123'
// 	);
// 	$client->call ( 'Login',$data);
// 	$p = $client->document;
// 	var_dump($p);
// //<LoginResponse xmlns="http://tempuri.org/"><LoginResult>OK|fd0f3a0bkdt12fd4mb0zubsm</LoginResult></LoginResponse>
// 	$cookie = $client->getCookies();
// 	var_dump($cookie);//获取ASPXAUTH，信息如下所示
/*
	array (size=2)
	0 => 
	    array (size=2)
	      'name' => string 'ASP.NET_SessionId' (length=17)
	      'value' => string $session_key (length=24)
	1 => 
	    array (size=6)
	      'name' => string '.ASPXAUTH' (length=9)
	      'value' => string '337B782CDCBB2D8B6069DEDB7D39273C787769064DC7C94A71211BB70E2505AB903DD7B322DB351697D8B7C9D82D633EE2DA05D0A13ECDBFD8129EDB37AF8785FD1D6F8FA653D6A406C145A83D6DEA549746FD86B976800A5B393927877B22D096ED19233294C6CCD8C598B2750459A955243EFE7F0CD0339EAFAF325E1EDE28FFFD960C6050FBD1E5D34028235C4C02' (length=288)
	      'domain' => string 'sandbox.podinns.com' (length=19)
	      'path' => string '/' (length=1)
	      'expires' => string '' (length=0)
	      'secure' => boolean false
 */ 
	
	//7、 获得登录会员识别
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $client->call ( 'GetLoginMemID',array());
	// $p = $client->document;
	// var_dump($p);
	//<GetLoginMemIDResponse xmlns="http://tempuri.org/"><GetLoginMemIDResult>50bRAm9%2fLSXrZgvfbCNj4vDeZQIVsXvlRLywJABhuz8%3d</GetLoginMemIDResult></GetLoginMemIDResponse>
	//获得的MemID有效时间为十分钟
	
	//8、 找回密码 Podinn.WapService.GetPassword
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"step"=>"1",
//		"ConfirmWay"=>"email",
//		"password"=>"123123123",
//		"CheckCode"=>"",
//		"mobileOrEmail"=>"ws645030813@sina.cn"
//	);
//	$client->call ( 'GetPassword',$data);
//	$p = $client->document;
//	var_dump($p);
	//<GetPasswordResponse xmlns="http://tempuri.org/"><GetPasswordResult>OK1</GetPasswordResult></GetPasswordResponse>
	
	//9、 注销会员登录
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array();
//	$client->call ( 'LoginOut',$data);
//	$p = $client->document;
//	var_dump($p);
	//<LoginOutResponse xmlns="http://tempuri.org/"></LoginOutResponse>
	//已注销成功，调用“获得登录会员识别”接口时，返回<GetLoginMemIDResponse xmlns="http://tempuri.org/"><GetLoginMemIDResult>EX_无权限</GetLoginMemIDResult></GetLoginMemIDResponse>
	
	//10、 注销会员登录
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array();
//	$client->call ( 'LoginOut2',$data);
//	$p = $client->document;
//	var_dump($p);
	//<LoginOut2Response xmlns="http://tempuri.org/"><LoginOut2Result>OK</LoginOut2Result></LoginOut2Response>
	
	//14、 会员卡注册，可以送优惠券(验证手机验证码，其它功能同Register3) 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"name"=>"hong",
	// 	"sfz"=>"440106198303178431",
	// 	"email"=>"",
	// 	"mobile"=>"13502556512",
	// 	"password"=>"123123",
	// 	"regType"=>"WAP_REG_YI",
	// 	"mobileCode"=>"1234",
	// 	"recommendMobile"=>""	//推荐人手机，可不填 或 推荐码+"|"+设备序列
	// );
	// $client->call ( 'LoginOut2',$data);
	// $p = $client->document;
	// var_dump($p);
	//<LoginOut2Response xmlns="http://tempuri.org/"><LoginOut2Result>OK</LoginOut2Result></LoginOut2Response>

	//15、 Wap注册申领虚拟卡，请之前对数据做正确性效验 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"name"=>"hong",
	// 	"sfz"=>"440115198909287559",
	// 	"email"=>"645030800@qq.com",
	// 	"mobile"=>"13580506400",
	// 	"password"=>"123123",
	// 	"regType"=>"WAP_REG_YI"
	// );
	// $client->call ( 'Register4',$data);
	// $p = $client->document;
	// var_dump($p);
	//<Register4Response xmlns="http://tempuri.org/"><Register4Result>EX_促销礼包不存在</Register4Result></Register4Response>
	
	//16、 获得积分
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array();
//	$client->call ( 'GetUserFen',$data);
//	$p = $client->document;
//	var_dump($p);
	//<GetUserFenResponse xmlns="http://tempuri.org/"><GetUserFenResult>0</GetUserFenResult></GetUserFenResponse>
	
	//17、 获得剩于金额
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array();
//	$client->call ( 'GetUserMoney',$data);
//	$p = $client->document;
//	var_dump($p);
	//<GetUserMoneyResponse xmlns="http://tempuri.org/"><GetUserMoneyResult>0.00</GetUserMoneyResult></GetUserMoneyResponse>
	
	//18、 获得城市列表(接口缺少行政区域编号，名称，酒店数量)
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
////	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array();
//	$client->call ( 'GetCitys',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetCitysResult] => SimpleXMLElement Object ( [ArrayOfHotelModel.City] => SimpleXMLElement Object ( [HotelModel.City] => Array ( [0] => SimpleXMLElement Object ( [B] => 0,1,2 [CityID] => 2 [CityName] => 杭州 [PinYin] => hangzhou [SName] => 浙江 ) [1] => SimpleXMLElement Object ( [B] => 0,1 [CityID] => 1 [CityName] => 北京 [PinYin] => beijing [SName] => 北京 ) [2] => SimpleXMLElement Object ( [B] => 0,1 [CityID] => 9 [CityName] => 上海 [PinYin] => shanghai [SName] => 上海 ) [3] => SimpleXMLElement Object ( [B] => 0,1 [CityID] => 12 [CityName] => 西安 [PinYin] => xian [SName] => 陕西 ) [4] => SimpleXMLElement Object ( [B] => 0 [CityID] => 5 [CityName] => 苏州 [PinYin] => suzhou [SName] => 江苏 ) [5] => SimpleXMLElement Object ( [B] => 0 [CityID] => 11 [CityName] => 武汉 [PinYin] => wuhan [SName] => 湖北 ) [6] => SimpleXMLElement Object ( [B] => 0 [CityID] => 24 [CityName] => 成都 [PinYin] => chengdu [SName] => 四川 ) [7] => SimpleXMLElement Object ( [B] => 0,2 [CityID] => 21 [CityName] => 南京 [PinYin] => nanjing [SName] => 江苏 ) [8] => SimpleXMLElement Object ( [B] => 0 [CityID] => 7 [CityName] => 无锡 [PinYin] => wuxi [SName] => 江苏 ) [9] => SimpleXMLElement Object ( [B] => 0 [CityID] => 28 [CityName] => 广州 [PinYin] => guangzhou [SName] => 广东 ) [10] => SimpleXMLElement Object ( [B] => 0 [CityID] => 33 [CityName] => 贵阳 [PinYin] => guiyang [SName] => 贵州 ) [11] => SimpleXMLElement Object ( [B] => 0 [CityID] => 23 [CityName] => 天津 [PinYin] => tianjin [SName] => 天津 ) [12] => SimpleXMLElement Object ( [B] => 0 [CityID] => 30 [CityName] => 重庆 [PinYin] => chongqing [SName] => 重庆 ) [13] => SimpleXMLElement Object ( [B] => 0 [CityID] => 4 [CityName] => 宁波 [PinYin] => ningbo [SName] => 浙江 ) [14] => SimpleXMLElement Object ( [B] => 0 [CityID] => 3 [CityName] => 嘉兴 [PinYin] => jiaxing [SName] => 浙江 ) [15] => SimpleXMLElement Object ( [B] => 0 [CityID] => 39 [CityName] => 舟山 [PinYin] => zhoushan [SName] => 浙江 ) [16] => SimpleXMLElement Object ( [B] => 0,1 [CityID] => 26 [CityName] => 金华 [PinYin] => jinhua [SName] => 浙江 ) [17] => SimpleXMLElement Object ( [B] => 0 [CityID] => 64 [CityName] => 洛杉矶 [PinYin] => los angels [SName] => 美国 ) [18] => SimpleXMLElement Object ( [B] => 0,1 [CityID] => 41 [CityName] => 乌鲁木齐 [PinYin] => wulumuqi [SName] => 新疆 ) [19] => SimpleXMLElement Object ( [B] => 0 [CityID] => 25 [CityName] => 厦门 [PinYin] => xiamen [SName] => 福建 ) [20] => SimpleXMLElement Object ( [B] => 0 [CityID] => 10 [CityName] => 沈阳 [PinYin] => shenyang [SName] => 辽宁 ) [21] => SimpleXMLElement Object ( [B] => 0 [CityID] => 46 [CityName] => 南通 [PinYin] => nantong [SName] => 江苏 ) [22] => SimpleXMLElement Object ( [B] => 0,1 [CityID] => 20 [CityName] => 徐州 [PinYin] => xuzhou [SName] => 江苏 ) [23] => SimpleXMLElement Object ( [B] => 0 [CityID] => 19 [CityName] => 淮安 [PinYin] => huaian [SName] => 江苏 ) [24] => SimpleXMLElement Object ( [B] => 0 [CityID] => 37 [CityName] => 昆山 [PinYin] => kunshan [SName] => 江苏 ) [25] => SimpleXMLElement Object ( [B] => 0 [CityID] => 34 [CityName] => 常州 [PinYin] => changzhou [SName] => 江苏 ) [26] => SimpleXMLElement Object ( [B] => 0 [CityID] => 40 [CityName] => 扬州 [PinYin] => yangzhou [SName] => 江苏 ) [27] => SimpleXMLElement Object ( [B] => 0 [CityID] => 54 [CityName] => 常熟 [PinYin] => chagnshu [SName] => 江苏 ) [28] => SimpleXMLElement Object ( [B] => 0 [CityID] => 35 [CityName] => 丽江 [PinYin] => lijiang [SName] => 云南 ) [29] => SimpleXMLElement Object ( [B] => 0 [CityID] => 18 [CityName] => 哈尔滨 [PinYin] => haerbin [SName] => 黑龙江 ) [30] => SimpleXMLElement Object ( [B] => 0 [CityID] => 50 [CityName] => 兰州 [PinYin] => lanzhou [SName] => 甘肃 ) [31] => SimpleXMLElement Object ( [B] => 0 [CityID] => 43 [CityName] => 银川 [PinYin] => yinchuan [SName] => 宁夏 ) [32] => SimpleXMLElement Object ( [B] => 0 [CityID] => 49 [CityName] => 廊坊 [PinYin] => langfang [SName] => 河北 ) [33] => SimpleXMLElement Object ( [B] => 0 [CityID] => 29 [CityName] => 深圳 [PinYin] => shenzhen [SName] => 广东 ) [34] => SimpleXMLElement Object ( [B] => 0,1 [CityID] => 22 [CityName] => 绍兴 [PinYin] => shaoxing [SName] => 浙江 ) [35] => SimpleXMLElement Object ( [B] => 0,2 [CityID] => 38 [CityName] => 温州 [PinYin] => wenzhou [SName] => 浙江 ) [36] => SimpleXMLElement Object ( [B] => 0 [CityID] => 80 [CityName] => 昆明 [PinYin] => kunming [SName] => 云南 ) [37] => SimpleXMLElement Object ( [B] => 3 [CityID] => 67 [CityName] => 衢州 [PinYin] => quzhou [SName] => 浙江 ) [38] => SimpleXMLElement Object ( [B] => 0 [CityID] => 70 [CityName] => 拉萨 [PinYin] => lasa [SName] => 西藏 ) [39] => SimpleXMLElement Object ( [B] => 0 [CityID] => 8 [CityName] => 济南 [PinYin] => jinan [SName] => 山东 ) [40] => SimpleXMLElement Object ( [B] => 0 [CityID] => 47 [CityName] => 连云港 [PinYin] => lianyungang [SName] => 江苏 ) [41] => SimpleXMLElement Object ( [B] => 0 [CityID] => 48 [CityName] => 石河子 [PinYin] => shihezi [SName] => 新疆 ) [42] => SimpleXMLElement Object ( [B] => 0 [CityID] => 51 [CityName] => 遂宁 [PinYin] => suining [SName] => 四川 ) [43] => SimpleXMLElement Object ( [B] => 0 [CityID] => 52 [CityName] => 宿迁 [PinYin] => suqian [SName] => 江苏 ) [44] => SimpleXMLElement Object ( [B] => 0 [CityID] => 55 [CityName] => 镇江 [PinYin] => zhenjiang [SName] => 江苏 ) [45] => SimpleXMLElement Object ( [B] => 0 [CityID] => 61 [CityName] => 滕州 [PinYin] => tengzhou [SName] => 山东 ) [46] => SimpleXMLElement Object ( [B] => 0 [CityID] => 62 [CityName] => 西宁 [PinYin] => xining [SName] => 青海 ) [47] => SimpleXMLElement Object ( [B] => 0 [CityID] => 65 [CityName] => 黄山 [PinYin] => huangshan [SName] => 安徽 ) [48] => SimpleXMLElement Object ( [B] => 0 [CityID] => 69 [CityName] => 东阳 [PinYin] => dongyang [SName] => 浙江 ) [49] => SimpleXMLElement Object ( [B] => 0 [CityID] => 81 [CityName] => 开封 [PinYin] => kaifeng [SName] => 河南 ) [50] => SimpleXMLElement Object ( [B] => 0 [CityID] => 82 [CityName] => 马鞍山 [PinYin] => maanshan [SName] => 安徽 ) [51] => SimpleXMLElement Object ( [B] => 0 [CityID] => 86 [CityName] => 黄石 [PinYin] => huangshi [SName] => 湖北 ) [52] => SimpleXMLElement Object ( [B] => 0 [CityID] => 87 [CityName] => 临安 [PinYin] => linan [SName] => 浙江 ) [53] => SimpleXMLElement Object ( [B] => 0 [CityID] => 84 [CityName] => 台湾 [PinYin] => taiwan [SName] => 台湾 ) [54] => SimpleXMLElement Object ( [B] => 0 [CityID] => 90 [CityName] => 郑州 [PinYin] => zhengzhou [SName] => 河南 ) [55] => SimpleXMLElement Object ( [B] => 0 [CityID] => 89 [CityName] => 张家界 [PinYin] => zhangjiajie [SName] => 湖南 ) [56] => SimpleXMLElement Object ( [B] => 0 [CityID] => 91 [CityName] => 新乡 [PinYin] => xinxiang [SName] => 河南 ) [57] => SimpleXMLElement Object ( [B] => 1 [CityID] => 93 [CityName] => 诸暨 [PinYin] => zhuji [SName] => 浙江 ) [58] => SimpleXMLElement Object ( [B] => 0 [CityID] => 94 [CityName] => 曲阜 [PinYin] => qufu [SName] => 山东 ) [59] => SimpleXMLElement Object ( [B] => 0 [CityID] => 95 [CityName] => 平遥 [PinYin] => pingyao [SName] => 山西 ) [60] => SimpleXMLElement Object ( [B] => 0 [CityID] => 97 [CityName] => 东京 [PinYin] => dongjing [SName] => 日本 ) [61] => SimpleXMLElement Object ( [B] => 0 [CityID] => 98 [CityName] => 晋中 [PinYin] => jinzhong [SName] => 山西 ) [62] => SimpleXMLElement Object ( [B] => 0 [CityID] => 99 [CityName] => 招远 [PinYin] => zhaoyuan [SName] => 山东 ) [63] => SimpleXMLElement Object ( [B] => 0 [CityID] => 45 [CityName] => 枣庄 [PinYin] => zaozhuang [SName] => 山东 ) [64] => SimpleXMLElement Object ( [B] => 0 [CityID] => 56 [CityName] => 佛山 [PinYin] => fushan [SName] => 广东 ) [65] => SimpleXMLElement Object ( [B] => 0 [CityID] => 58 [CityName] => 黄冈 [PinYin] => huanggang [SName] => 湖北 ) [66] => SimpleXMLElement Object ( [B] => 0 [CityID] => 59 [CityName] => 太原 [PinYin] => taiyuan [SName] => 山西 ) [67] => SimpleXMLElement Object ( [B] => 0,1 [CityID] => 66 [CityName] => 合肥 [PinYin] => hefei [SName] => 安徽 ) [68] => SimpleXMLElement Object ( [B] => 0 [CityID] => 57 [CityName] => 青岛 [PinYin] => qingdao [SName] => 山东 ) [69] => SimpleXMLElement Object ( [B] => 0 [CityID] => 60 [CityName] => 嘉峪关 [PinYin] => jiayuguan [SName] => 甘肃 ) [70] => SimpleXMLElement Object ( [B] => 0 [CityID] => 63 [CityName] => 桂林 [PinYin] => guilin [SName] => 广西 ) [71] => SimpleXMLElement Object ( [B] => 3 [CityID] => 68 [CityName] => 常山 [PinYin] => changshan [SName] => 浙江 ) [72] => SimpleXMLElement Object ( [B] => 0 [CityID] => 71 [CityName] => 秦皇岛 [PinYin] => qinhuangdao [SName] => 河北 ) [73] => SimpleXMLElement Object ( [B] => 0 [CityID] => 74 [CityName] => 大连 [PinYin] => dalian [SName] => 辽宁 ) ) ) ) )
	
	//19、 根据坐标获得城市(手机上建议缓存，手机一次打开只读一次)
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
////	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array("map"=>"20,20","b"=>"0");
//	$client->call ( 'GetCityByMap',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
//	Array ( [GetCityByMapResult] => SimpleXMLElement Object ( [HotelModel.City] => SimpleXMLElement Object ( [B] => 0 [CityID] => 48 [CityName] => 石河子 [PinYin] => shihezi [SName] => 新疆 ) ) )
	
	//20、 获得手机平台全局参数
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
////	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array();
//	$client->call ( 'GetGlobalParams',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetGlobalParamsResult] => [{"key":"MOBILE_REG_IS_IMAGE","value":"0"}] )

	//21、 获得图形验证码（需要Session支持）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
////	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array();
//	$client->call ( 'GetImageCode',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetImageCodeResult] => R0lGODlhZAAeAPcAAAAAAAAAMwAAZgAAmQAAzAAA/wArAAArMwArZgArmQArzAAr/wBVAABVMwBVZgBVmQBVzABV/wCAAACAMwCAZgCAmQCAzACA/wCqAACqMwCqZgCqmQCqzACq/wDVAADVMwDVZgDVmQDVzADV/wD/AAD/MwD/ZgD/mQD/zAD//zMAADMAMzMAZjMAmTMAzDMA/zMrADMrMzMrZjMrmTMrzDMr/zNVADNVMzNVZjNVmTNVzDNV/zOAADOAMzOAZjOAmTOAzDOA/zOqADOqMzOqZjOqmTOqzDOq/zPVADPVMzPVZjPVmTPVzDPV/zP/ADP/MzP/ZjP/mTP/zDP//2YAAGYAM2YAZmYAmWYAzGYA/2YrAGYrM2YrZmYrmWYrzGYr/2ZVAGZVM2ZVZmZVmWZVzGZV/2aAAGaAM2aAZmaAmWaAzGaA/2aqAGaqM2aqZmaqmWaqzGaq/2bVAGbVM2bVZmbVmWbVzGbV/2b/AGb/M2b/Zmb/mWb/zGb//5kAAJkAM5kAZpkAmZkAzJkA/5krAJkrM5krZpkrmZkrzJkr/5lVAJlVM5lVZplVmZlVzJlV/5mAAJmAM5mAZpmAmZmAzJmA/5mqAJmqM5mqZpmqmZmqzJmq/5nVAJnVM5nVZpnVmZnVzJnV/5n/AJn/M5n/Zpn/mZn/zJn//8wAAMwAM8wAZswAmcwAzMwA/8wrAMwrM8wrZswrmcwrzMwr/8xVAMxVM8xVZsxVmcxVzMxV/8yAAMyAM8yAZsyAmcyAzMyA/8yqAMyqM8yqZsyqmcyqzMyq/8zVAMzVM8zVZszVmczVzMzV/8z/AMz/M8z/Zsz/mcz/zMz///8AAP8AM/8AZv8Amf8AzP8A//8rAP8rM/8rZv8rmf8rzP8r//9VAP9VM/9VZv9Vmf9VzP9V//+AAP+AM/+AZv+Amf+AzP+A//+qAP+qM/+qZv+qmf+qzP+q///VAP/VM//VZv/Vmf/VzP/V////AP//M///Zv//mf//zP///wAAAAAAAAAAAAAAACH5BAEAAPwALAAAAABkAB4AAAj/APcJHEiwoMGDCBMqXMiwocJo+yBKjEhxosWKGC9qzMhxo8eOID1GqydwmcB6EEmOLHkyZUSS+0zuQznzJcuZLlfGbFlTp0yaKmH+zCmUZ1CCEDFSVJp04lKnTZ8KhDpVKtOqUa9qpUoR6M2fNnUCdbmz7FGxKcnKBLsSLc6aZdmSBCuzakWYSU02VdkV2RGlModd2WR3ZFSaebHyfXnYqUyuUNuS5Jt2oM6kMC1JmBCKp8BhgBz5tNxzIM2uS8uixpzULNGbhU2nrlsZojAJuCVU2Bvt1uDYlN9GK3aH9NvVxlW3Xk6aNUveVU+b1Kf5DrDcRgbqAxRoWWXEJ1OD/wpl+HjO53Oxfg0L0+7j42WZ77u9AeI8HrgnFFcGCEvW8BPRtMwyxbmn3mlSTfafVNGs9N5pCJo01j6axVFVMBIwcEc07gCCCERr3VWaQON11dpQluEV3FgsIhXbUnrFdp8E9RWUCUS2XKGJi+ZFFAx5+2zSGUXLbNJgYaddlpx8Fw0kYVgFeaUZdjEmdQsgRsYlVT42bNaZMsU5aEdnkjl5oGTfkcUSbSky9tR9FCSDn5eWbXcFm+GZZAkDuXGwT4kRKRPKmMYtBxOCrVnVZHQgvkjTdX/Nl9uGJA0TiBcYgTejBHfII0F2odwhE5jLkFlUfFKh6JVOz8FnE6r7wP955D7U7TbVOVZQ8qpLU9ZoyQSn7KNJsDGFEoqgVS0T7GOnqqeoUojCWplmkTq1VC9WVNJYPnNaKJAlFHRGYETLgBJNqWWBkqWSU61alFfOPmliabKqZRM03IUYETB8SuBnRPPY8K8mndFzx5en5AVKgUTCJiKT7Xom0WKpCZOdswPR09+s0XiK2x36mMEBRPJgYARExkYjKMpk7qOMkY0WumqyDnPFqJbtEiWRO1aIdqg+kFCQlD5g+IlhgSXGkRTBJx2M1IRWodReVKoaRjGDBWV1ZSUhRRTyBkETO14o5pILZCjDumngWxQnxmNqlaH4lkkSpgRNjlZg6fBpIdP7aFgxYw6pzybB0hMqaTNjDTVgUCKY6X/yWXoFIFeQ0fBynka6D9lAmlTiMnYEaBXOi7ntKpRmIblasxoHYkUgV7BG09EUETykQIQbLG50qDN4VryoJ8keckphdMvrsadGIQWntOfdRKCcUu7t780bYul7Q1wZ3Iq9SrdBvYg2dz5g1JgoXJuA2bLb1TtKVlYxy5uYu0u6GGOPnv47d0Wgw3yo+ztZnLVUw73qwU9LaMKL6vYBDTMU536vIhjDJsIWgzSmJsLbCZpkU7WpvS1+sIEIPbyTIuaUzXSO0SBfsHe+RJ2Ie/CTmpscZxW5sUqDZorPoSAmnOPQJCAAOw== )
	
	//22、 发送手机验证码，注一个手机一天最多送5次，每次发送时间要大小60秒
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
////	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array("mobile"=>"13580506405","isCheckMobile"=>"");
//	$client->call ( 'MobileSendCode',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [MobileSendCodeResult] => OK )  暂时没有收到
	//当isCheckMobile为 1 时，返回Array ( [MobileSendCodeResult] => F ) 表示手机已注册
	
	//23、 验证手机验证码是否正确（同一验证码可以输错3次，否则每次都返回错误）
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array("code"=>"1234");
	// $client->call ( 'MobileCheckCode',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
//	Array ( [MobileCheckCodeResult] => NO )
	
	//24、 搜索酒店 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"start"=>"2001-01-01",
	// 	"end"=>"2016-01-10",	
	// 	"pageIndex"=>"1",	
	// 	"pageSize"=>"10",	
	// 	"city"=>"0",	
	// 	"hotelName"=>"",	
	// 	"porder"=>"0",	
	// 	"plorder"=>"0"
	// );
	// $client->call ( 'SearchHotel',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [SearchHotelResult] => SimpleXMLElement Object ( [PageDataOfHotelModel.CommonHotelSimple47PfhAw0] => SimpleXMLElement Object ( [Count] => 1 [Datas] => SimpleXMLElement Object ( [HotelModel.CommonHotelSimple] => SimpleXMLElement Object ( [PH_NAME] => 布丁酒店杭州武林西湖文化广场地铁站店 [PH_NO] => zj1 ) ) ) ) )
	
	//25、 搜索酒店(包含地图，与电话，地址等信息) 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"start"=>"2001-01-01",
	// 	"end"=>"2016-01-10",	
	// 	"pageIndex"=>"1",	
	// 	"pageSize"=>"10",	
	// 	"city"=>"0",	
	// 	"hotelName"=>"",	
	// 	"porder"=>"0",	
	// 	"plorder"=>"0"
	// );
	// $client->call ( 'SearchHotel2',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [SearchHotel2Result] => SimpleXMLElement Object ( [PageDataOfHotelModel.HotelMobile47PfhAw0] => SimpleXMLElement Object ( [Count] => 1 [Datas] => SimpleXMLElement Object ( [HotelModel.HotelMobile] => SimpleXMLElement Object ( [PD_BAIDU_MAP] => 120.169898,30.289227 [PH_ADDRESS] => 杭州市河东路85号（近文晖路口朝晖三区）,地铁1号线至西湖文化广场站下A出口,前方河东路步行5分钟,左边中国农业银行口进即可,酒店200米有机场大巴 [PH_FEN] => 4.423 [PH_MAP_INFO] => 120.162997,30.283336 [PH_NAME] => 布丁酒店杭州武林西湖文化广场地铁站店 [PH_NO] => zj1 [PH_ORDER_PRICE] => 134 [PH_PIC_PATH] => http://pod100.com/uf/UploadFiles/20150626/0b89de42035947d4855624c328381853.jpg [PH_TEL] => 0571-85237220 ) ) ) ) )
	
	//26、 搜索酒店(包含地图，与电话，地址,可预订最近价等信息) 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"start"=>"2001-01-01",
	// 	"end"=>"2016-01-10",	
	// 	"pageIndex"=>"1",	
	// 	"pageSize"=>"10",	
	// 	"city"=>"0",	
	// 	"hotelName"=>"",	
	// 	"porder"=>"0",	
	// 	"plorder"=>"0",
	// 	"priceCode" => ""
	// );
	// $client->call ( 'SearchHotel3',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [SearchHotel3Result] => SimpleXMLElement Object ( [PageDataOfHotelModel.HotelMobile47PfhAw0] => SimpleXMLElement Object ( [Count] => 1 [Datas] => SimpleXMLElement Object ( [HotelModel.HotelMobile] => SimpleXMLElement Object ( [PD_BAIDU_MAP] => 120.169898,30.289227 [PH_ADDRESS] => 杭州市河东路85号（近文晖路口朝晖三区）,地铁1号线至西湖文化广场站下A出口,前方河东路步行5分钟,左边中国农业银行口进即可,酒店200米有机场大巴 [PH_FEN] => 4.423 [PH_MAP_INFO] => 120.162997,30.283336 [PH_NAME] => 布丁酒店杭州武林西湖文化广场地铁站店 [PH_NO] => zj1 [PH_ORDER_PRICE] => 134 [PH_PIC_PATH] => http://pod100.com/uf/UploadFiles/20150626/0b89de42035947d4855624c328381853.jpg [PH_TEL] => 0571-85237220 ) ) ) ) )
	
	//27 搜索酒店(包含地图，与电话，地址,可预订最近价(合计)等信息) 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"start"=>"2001-01-01",
//		"end"=>"2016-01-10",	
//		"pageIndex"=>"1",	
//		"pageSize"=>"10",	
//		"city"=>"0",	
//		"hotelName"=>"",	
//		"porder"=>"0",	
//		"plorder"=>"0",
//		"priceCode" => ""
//	);
//	$client->call ( 'SearchHotel4',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	// Array ( [SearchHotel4Result] => SimpleXMLElement Object ( [PageDataOfHotelModel.HotelMobile47PfhAw0] => SimpleXMLElement Object ( [Count] => 1 [Datas] => SimpleXMLElement Object ( [HotelModel.HotelMobile] => SimpleXMLElement Object ( [PD_BAIDU_MAP] => 120.169898,30.289227 [PH_ADDRESS] => 杭州市河东路85号（近文晖路口朝晖三区）,地铁1号线至西湖文化广场站下A出口,前方河东路步行5分钟,左边中国农业银行口进即可,酒店200米有机场大巴 [PH_FEN] => 4.423 [PH_MAP_INFO] => 120.162997,30.283336 [PH_NAME] => 布丁酒店杭州武林西湖文化广场地铁站店 [PH_NO] => zj1 [PH_ORDER_PRICE] => 134 [PH_PIC_PATH] => http://pod100.com/uf/UploadFiles/20150626/0b89de42035947d4855624c328381853.jpg [PH_TEL] => 0571-85237220 ) ) ) ) )
	
	//28、 搜索酒店(微信用)OpenID （缺少OpenID）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"start"=>"2001-01-01",
	// 	"end"=>"2016-01-10",	
	// 	"pageIndex"=>"1",	
	// 	"pageSize"=>"10",	
	// 	"city"=>"0",	
	// 	"hotelName"=>"",	
	// 	"porder"=>"0",	
	// 	"plorder"=>"0",
	// 	"OpenID" => ""
	// );
	// $client->call ( 'SearchHotel5_2',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	// Array ( [0] => )
	
	//29、 搜索酒店(包含地图，与电话，地址,可预订最近价等信息) 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"start"=>"2001-01-01",
	// 	"end"=>"2016-01-10",	
	// 	"pageIndex"=>"1",	
	// 	"pageSize"=>"10",	
	// 	"city"=>"0",	
	// 	"area"=>"0",
	// 	"areaType"=>"2",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",	
	// 	"porder"=>"0",	
	// 	"plorder"=>"0",
	// 	"priceCode" => "",
	// 	"dataType" => "xml",
	// 	"map" => "",
	// 	"fun" => "",
	// 	"brand" => "",
	// 	"linkTag" => "0"
	// );
	// $client->call ( 'SearchHotelMobileNew3',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [SearchHotelMobileNew3Result] => SimpleXMLElement Object ( [PageDataOfHotelMList47PfhAw0] => SimpleXMLElement Object ( [Count] => 0 [Datas] => SimpleXMLElement Object ( ) ) ) )
	
	//30、 搜索酒店(包含地图，与电话，地址,可预订最近价等信息) 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"start"=>"2001-01-01",
	// 	"end"=>"2016-01-10",	
	// 	"pageIndex"=>"1",	
	// 	"pageSize"=>"10",	
	// 	"city"=>"0",	
	// 	"area"=>"0",
	// 	"areaType"=>"2",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",	
	// 	"porder"=>"0",	
	// 	"plorder"=>"0",
	// 	"priceCode" => "",
	// 	"dataType" => "xml",
	// 	"map" => "",
	// 	"fun" => "",
	// 	"brand" => "",
	// 	"linkTag" => "0"
	// );
	// $client->call ( 'SearchHotelMobileNew2',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [SearchHotelMobileNew2Result] => EX_参数非法 )
	
	//31、 根据地图做标获得周边布丁酒店 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"city"=>"48",
	// 	"map"=>"",	
	// 	"area"=>"0",	
	// 	"areaType"=>"1",	
	// 	"count"=>"0",	
	// 	"distinct"=>"",	
	// 	"dataType"=>"json",	
	// 	"fun"=>"",
	// 	"priceCode"=>"",
	// 	"start"=>"2001-01-01",
	// 	"end"=>"2016-01-10",	
	// 	"roomCount"=>"1",
	// 	"brand"=>""
	// );
	// $client->call ( 'SearchHotel',$data);
	// $p = $client->document;
	// print_r($p);
	//0
	
	//32、 搜索酒店功能(特定类别的酒店列表，不分页)
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"city"=>"0",
	// 	"fun"=>"D"
	// );
	// $client->call ( 'SearchHotel',$data);
	// $p = $client->document;
	// print_r($p);
	//EX_String 引用没有设置为 String 的实例。 参数名: s
	
	//33、 团购参加酒店列表
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"tuanCode"=>"",
	// 	"dataType"=>"xml"
	// );
	// $client->call ( 'SearchHotelTuan',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [SearchHotelTuanResult] => EX_团购编号不正确或已经过期 )
	
	//34、 搜索酒店房型（夜宵）
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"Hotels"=>"zj1",
	// 	"fun"=>""
	// );
	// $client->call ( 'SearchWapRoomYeXiao',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//soap:Client服务器无法读取请求。 ---> XML 文档(1, 405)中有错误。 ---> 输入字符串的格式不正确。
	
	//35、 根据手机获得最新订单（此接口不对外）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"mobile"=>"13580506405"
//	);
//	$client->call ( 'LoadNewsOrderByMobile',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [0] => )
	
	//36、 获得酒店详细信息(原Wap准备废弃)
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"2"
	// );
	// $client->call ( 'LoadHotelDetail',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelDetailResult] => SimpleXMLElement Object ( [HotelModel.HotelSimple2] => SimpleXMLElement Object ( ) ) )
	
	//37、 获得酒店房型详细信息
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"RoomID"=>"YXDCA"
	// );
	// $client->call ( 'LoadHotelRoomDetail',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelRoomDetailResult] => SimpleXMLElement Object ( [HotelModel.HotelRoomType] => SimpleXMLElement Object ( [HRT_BED_TYPE_NAME] => 大床 [HRT_BED_WIDTH_NAME] => 1.35米 [HRT_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150626/72f74e0fdba746b4987b5f67e794a1a0.jpg [HRT_FUN] => 'A','B','U' [HRT_ID] => 4 [HRT_NAME] => 特价大床房A [HRT_NO] => YXDCA [HRT_PH_NO] => zj1 [HRT_ROOM_Area] => 10 [HRT_ROOM_Desc] => 配电视、wifi [HRT_ROOM_FLOOR] => SimpleXMLElement Object ( ) [HRT_ROOM_NETWORK_NAME] => 无线宽带【免费】 ) ) 
	
	//38、 查询酒店所有房型信息
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1"
	// );
	// $client->call ( 'LoadHotelRoomDetails',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelRoomDetailsResult] => SimpleXMLElement Object ( [ArrayOfHotelModel.HotelRoomType] => SimpleXMLElement Object ( [HotelModel.HotelRoomType] => Array ( [0] => SimpleXMLElement Object ( [HRT_BED_TYPE_NAME] => 大床 [HRT_BED_WIDTH_NAME] => 1.35米 [HRT_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150626/72f74e0fdba746b4987b5f67e794a1a0.jpg [HRT_FUN] => 'A','B','U' [HRT_ID] => 4 [HRT_NAME] => 特价大床房A [HRT_NO] => YXDCA [HRT_PH_NO] => zj1 [HRT_ROOM_Area] => 10 [HRT_ROOM_Desc] => 配电视、wifi [HRT_ROOM_FLOOR] => SimpleXMLElement Object ( ) [HRT_ROOM_NETWORK_NAME] => 无线宽带【免费】 ) [1] => SimpleXMLElement Object ( [HRT_BED_TYPE_NAME] => 大床 [HRT_BED_WIDTH_NAME] => 1.35米 [HRT_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150626/72f74e0fdba746b4987b5f67e794a1a0.jpg [HRT_FUN] => 'A','B','U' [HRT_ID] => 1 [HRT_NAME] => 大床房A [HRT_NO] => YXSC [HRT_PH_NO] => zj1 [HRT_ROOM_Area] => 10 [HRT_ROOM_Desc] => 配电视、wifi [HRT_ROOM_FLOOR] => SimpleXMLElement Object ( ) [HRT_ROOM_NETWORK_NAME] => 无线宽带【免费】 ) [2] => SimpleXMLElement Object ( [HRT_BED_TYPE_NAME] => 大床 [HRT_BED_WIDTH_NAME] => 1.35米 [HRT_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150626/72f74e0fdba746b4987b5f67e794a1a0.jpg [HRT_FUN] => 'A','B','U' [HRT_ID] => 2 [HRT_NAME] => 商务大床房 [HRT_NO] => SWDCF [HRT_PH_NO] => zj1 [HRT_ROOM_Area] => 10 [HRT_ROOM_Desc] => 配电视、wifi [HRT_ROOM_FLOOR] => SimpleXMLElement Object ( ) [HRT_ROOM_NETWORK_NAME] => 无线宽带【免费】 ) [3] => SimpleXMLElement Object ( [HRT_BED_TYPE_NAME] => 双床 [HRT_BED_WIDTH_NAME] => 1.1米 [HRT_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150626/9b4fe9bae69549139450afbda39bf34d.jpg [HRT_FUN] => 'B','J','V','U' [HRT_ID] => 3 [HRT_NAME] => 标准房 [HRT_NO] => SCF [HRT_PH_NO] => zj1 [HRT_ROOM_Area] => 15 [HRT_ROOM_Desc] => 配电视、wifi [HRT_ROOM_FLOOR] => SimpleXMLElement Object ( ) [HRT_ROOM_NETWORK_NAME] => 无线宽带【免费】 ) ) ) ) )
	
	//39、 获得酒店完整详细信息
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1"
	// );
	// $client->call ( 'LoadHotelDetail2',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelDetail2Result] => SimpleXMLElement Object ( [HotelModel.HotelData] => SimpleXMLElement Object ( [PD_BAIDU_MAP] => 120.169898,30.289227 [PH_ADDRESS] => 杭州市河东路85号（近文晖路口朝晖三区）,地铁1号线至西湖文化广场站下A出口,前方河东路步行5分钟,左边中国农业银行口进即可,酒店200米有机场大巴 [PH_AREA] => '12','105','333','7','208','343','346' [PH_BRAND] => 0 [PH_CITY_REGION] => 5 [PH_COUNT] => 1111177 [PH_DESC] => 布丁酒店连锁-武林西湖文化广场地铁站店紧靠地铁西湖文化广场站，背靠潮王路、近文晖路，浙江省科技馆、西湖文化广场、杭州和平会展中心、特色餐饮、金融、商务、休闲、购物等中心林立。是白领商务人士、时尚人群休闲旅游探亲访友的首选酒店，入住武林西湖文化广场店，让您倍感闹中取静的同时，更让您举足信步间享受杭州时尚潮流和领略运河水韵的诗情画意！ [PH_DISTICT] => 杭州知名美食小吃-新丰小吃、麦当劳、肯德基、一席地，傣味火锅，湘味馆，梁大妈妈菜，河东路美食街、胜利河美食街近在咫尺 [PH_D_FEN] => 4.987 [PH_FAX] => 0571-85236770 [PH_FEN] => 4.423 [PH_FEN_COUNT] => 3105 [PH_FEN_OTHER_COUNT] => 40 [PH_GOOD_PL_COUNT] => 2864 [PH_GOOGLE_MAP] => 30.283318071682515,120.16300646494301 [PH_GO_WAY] => 汽车北站可乘坐K67路至朝晖三区站下，往前步行约3分钟即可到达酒店； 汽车南站可乘坐K44路至朝晖三区站下，往前步行约3分钟即可到达酒店； 汽车西站可乘坐K179路至市交警支队站下，往前步行约100米即可到达酒店； 城站火车站出站左边到香榭商务大厦可乘坐K30路至朝晖三区 九堡客运中心可乘坐101路至潮王路口换乘316至朝晖三区，往前步行约3分钟即可到达酒店； 萧山国际机场可乘机场大巴至武林小广场，换乘316至至朝晖三区，往前步行约3分钟即可到达酒店； 酒店附近上塘路高架横贯杭城南北，杭州萧山国际机场、杭州城站火车站、西湖、杭州滨江高新区、出城东北门等核心区均可出门直上上塘高架直达、杭州火车东站（文晖路可直达）、地铁西湖文化广场站（未开）出入十分便利。 [PH_HOTEL_FUN] => '8','A','B','E','F','G','H','I','J','R','V','U' [PH_IS_FOREIGN] => 0 [PH_IS_HOT] => 1 [PH_IS_OPEN] => 1 [PH_IS_WIFI] => 2 [PH_KEYWORKS] => 04001019 [PH_MAP_INFO] => 120.162997,30.283336 [PH_NAME] => 布丁酒店杭州武林西湖文化广场地铁站店 [PH_NO] => zj1 [PH_N_BANK] => 建设银行：位于河东路92号，电话95533，里程100米 工商银行：位于河东路98号，电话95588，里程100米 中国银行：位于河东路75号，电话95566，里程50米 招商银行：位于河东路102号，电话95555，里程50米 中信银行：位于文晖路88号，电话95558，里程50米 农业银行：位于河东路86号，电话95599，里程10米 [PH_N_BUY] => 距离杭州大厦，银泰百货，杭州丝绸城，百大购物中心10分钟车程，武林路时尚女装街，四季青服装街，解百新世纪大厦，文三路电子信息街20分钟车程 [PH_N_FEN_1] => 4.378 [PH_N_FEN_2] => 4.34 [PH_N_FEN_3] => 4.419 [PH_N_FEN_4] => 4.348 [PH_N_HOSPITLE] => 浙江省人民医院、杭州市市六医院，杭州市儿童医院近在咫尺 [PH_N_YL] => 附近两岸咖啡，环球1号，浙江新远国际影城 [PH_ORDER] => 9 [PH_PC_ID] => 2 [PH_PIC_PATH] => /uf/UploadFiles/20150626/0b89de42035947d4855624c328381853.jpg [PH_PIC_PATH2] => /uf/UploadFiles/20150626/8bed969de47945d08b440e002729fcbc.jpg [PH_PIC_PATH3] => /uf/UploadFiles/20150626/9cd1202ca19b436886a4f37178f7e3f3.jpg [PH_PIC_PATH4] => /uf/UploadFiles/20150626/725401200a7c43878e352a3a6da7c796.jpg [PH_PIC_PATH5] => /uf/UploadFiles/20150626/ce76d924a6cb4562a24a4623a91109f0.jpg [PH_PIC_PATH6] => /uf/UploadFiles/20150626/7094be6ae3394647b5009478a855d4de.jpg [PH_PP_ID] => 1 [PH_ROOT_SETTING] => '1','2','3','4','5','6','7','8','9' [PH_SCENERY] => 浙江省自然博物馆，革命历史纪念馆，浙江省科技馆，出酒店右转，10分钟左右即到，距离西湖约15分钟车程，杭州新青年广场、仅需3-5分钟车程，西湖文化广场店位于市中心商务中心地带。西湖推荐景点吴山广场，太子湾公园，龙井村，西溪湿地，环境优美，空气尤其好，非常适合漫步游览哦~~~ 商务中心：面朝杭州最繁华的延安路武林广场商圈，毗邻武林广场，西湖文化广场等，浙江工业大学、杭州环球中心、浙江省教育大厦。 [PH_SERVICE_SETTING] => '1','2','3','4','5','6','7','9','11','14','16' [PH_TEL] => 0571-85237220 [PH_TIP] => SimpleXMLElement Object ( ) ) ) )
	
	//40、 获得酒店促销标签,注：这里只取文本内容图片数据不显示
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"dataType"=>"xml"
	// );
	// $client->call ( 'LoadHotelTag',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
//	Array ( [LoadHotelTagResult] => SimpleXMLElement Object ( [ArrayOfHomeModel.CustomLinkTag] => SimpleXMLElement Object ( ) ) )
	
	//41、 加载后多天的价格（单房型）
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"RoomTypeID"=>"SWDCF",
	// 	"startDate" => "2016-01-10",
	// 	"RateCode" => "USER"
	// );
	// $client->call ( 'LoadNext7Price',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadNext7PriceResult] => EX_未将对象引用设置到对象的实例。 )
	
	//42、 查询多天房价信息
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"startDate" => "2016-01-08",
	// 	"endDate"=>"2016-02-20",
	// 	"roomCount"=>"1",
	// 	"RateCode" => ""
	// );
	// $client->call ( 'LoadNextAllPrice',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadNextAllPriceResult] => SimpleXMLElement Object ( [ArrayOfSearchHotelRatesRsp.RoomAvalible] => SimpleXMLElement Object ( ) ) )
	
	//43、 查询多天房价信息,(简化大小，推荐使用,功能同：LoadNextAllPrice ,去哪儿) 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"startDate" => "2016-01-07",
	// 	"endDate"=>"2016-01-20",
	// 	"roomCount"=>"1",
	// 	"RateCode" => "USER",
	// 	"resultType"=>"xml",
	// 	"isListP"=>"1"
	// );
	// $client->call ( 'LoadNextAllPrice_short',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadNextAllPrice_shortResult] => SimpleXMLElement Object ( [ArrayOfHRoom] => SimpleXMLElement Object ( ) ) )
	
	//44、 美团房价，>3 返回4，否则为实际房价,（美团，点评）  
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"startDate" => "2012-01-06",
	// 	"endDate"=>"2016-01-20",
	// 	"roomCount"=>"1",
	// 	"RateCode" => "USER",
	// 	"resultType"=>"xml",
	// 	"isListP"=>"1"
	// );
	// $client->call ( 'LoadNextAllPrice_short4',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadNextAllPrice_short4Result] => SimpleXMLElement Object ( [ArrayOfHRoom] => SimpleXMLElement Object ( ) ) )
	
	//45、 查询多天房价信息,(简化大小，推荐使用,功能同：LoadNextAllPrice,新定义0:满房，否则为剩于房间数，>3时也只返回3) 
	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl');
	$client->soap_defencoding = 'UTF-8';
	$client->setCookie("ASP.NET_SessionId", $session_key );
	$client->decode_utf8 = false;  
	$client->xml_encoding = 'UTF-8'; 
	$data = array(
		"hotelNo"=>"zj1",
		"startDate" => "2016-03-06",
		"endDate"=>"2016-03-20",
		"RateCode" => "USER",
		"resultType"=>"xml"
	);
	$client->call ( 'LoadNextAllPrice_short2',$data);
	$p = $client->document;
	print_r((array)simplexml_load_string($p));
	//Array ( [LoadNextAllPrice_short2Result] => SimpleXMLElement Object ( [ArrayOfHRoom] => SimpleXMLElement Object ( ) ) )
	
	//46、 查询越早定越便宜多天价格,注意无价格是返回的是字符串空,HPrice对象中B字段，新定义0:满房，否则为剩于房间数，>3时也只返回3 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"startDate" => "2016-01-07",
	// 	"endDate"=>"2016-10-20",
	// 	"resultType"=>"xml"
	// );
	// $client->call ( 'LoadNextAllFLM_short',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadNextAllFLM_shortResult] => SimpleXMLElement Object ( [ArrayOfHRoom] => SimpleXMLElement Object ( ) ) )
	
	//47、 查询69元多天价格,注意无价格是返回的是字符串空,HPrice对象中B字段，新定义0:满房，否则为剩于房间数，>3时也只返回3(去哪儿) 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
////	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"startDate" => "2012-01-06",
	// 	"endDate"=>"2016-10-20",
	// 	"resultType"=>"xml"
	// );
	// $client->call ( 'LoadNextAllFLM_short',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [LoadNextAllFLM_shortResult] => SimpleXMLElement Object ( [ArrayOfHRoom] => SimpleXMLElement Object ( ) ) )
	
	//48、 功能性价格查询(新) 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"dCode"=>"T",
	// 	"hotelNo"=>"zj1",
	// 	"startDate" => "2012-01-06",
	// 	"endDate"=>"2016-10-20",
	// 	"roomCount" => "1",
	// 	"resultType"=>"xml"
	// );
	// $client->call ( 'LoadNextByFun_short',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [LoadNextByFun_shortResult] => SimpleXMLElement Object ( [ArrayOfHRoom] => SimpleXMLElement Object ( ) ) )
	
	//49、 查询自定义价格 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
////	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"dCode"=>"A",
//		"hotelNo"=>"zj1",
//		"startDate" => "2012-01-06",
//		"endDate"=>"2016-10-20",
//		"roomCount" => "1"
//	);
//	$client->call ( 'LoadHotelSelfPrice',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelSelfPriceResult] => SimpleXMLElement Object ( [ArrayOfHotelSelfPrice.P] => SimpleXMLElement Object ( ) ) )
	
	//50、 夜宵价格结果（带房间数返回）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"startDate" => "2012-01-06",
	// 	"dataType" => "xml"
	// );
	// $client->call ( 'LoadHotelSelfPrice',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelSelfPriceResult] => SimpleXMLElement Object ( [ArrayOfHotelSelfPrice.P] => SimpleXMLElement Object ( ) ) )
	
	//51、 获得团购报价(缺少团购编号)
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"tuanCode"=>"",
	// 	"hotelNo"=>"zj1",
	// 	"startDate" => "2012-01-06",
	// 	"endDate"=>"2016-02-06",
	// 	"dataType" => "xml"
	// );
	// $client->call ( 'LoadHotelSelfPriceTuan',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelSelfPriceTuanResult] => EX_团购编号不正确或已经过期 )
	
	//52、 查询钟点房价格
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"dataType" => "xml"
	// );
	// $client->call ( 'LoadHotelHourRoom',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelHourRoomResult] => EX_值不能为 null。 参数名: key )
	
	//53、 查询下几天向房价信息(同程) 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"startDate" => "2012-01-06",
	// 	"endDate"=>"2016-02-06",
	// 	"roomCount" => "",
	// 	"memID"=>""//需要加密
	// );
	// $client->call ( 'LoadNextAllPrice2',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [0] => )
	
	//54、 判断酒店是否被收藏
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1"
	// );
	// $client->call ( 'LoadHotelDetailIsFavorite',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelDetailIsFavoriteResult] => -1 )  返回1为收藏
	
	//55、 获得酒店价格信息,返回结果默认有容余，以后考滤精减 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"start" =>"2016-01-07",
	// 	"end"=>"2016-03-03",
	// 	"count"=>"1"
	// );
	// $client->call ( 'LoadHotelDetailPriceInfo',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelDetailPriceInfoResult] => SimpleXMLElement Object ( [ArrayOfHotelModel.HotelPriceInfo] => SimpleXMLElement Object ( [HotelModel.HotelPriceInfo] => Array ( [0] => SimpleXMLElement Object ( [CanBook] => 0 [Desc] => SimpleXMLElement Object ( ) [MyPriceCode] => SimpleXMLElement Object ( ) [PriceList] => 200 [PriceMy] => SimpleXMLElement Object ( ) [PriceUser] => 190 [PriceVIP4] => 184 [PriceVIP5] => 176 [PriceVIP9] => 170 [RoomTags] => SimpleXMLElement Object ( ) [RoomTypeId] => YXDCA [RoomTypeName] => 特价大床房A ) [1] => SimpleXMLElement Object ( [CanBook] => 0 [Desc] => SimpleXMLElement Object ( ) [MyPriceCode] => SimpleXMLElement Object ( ) [PriceList] => 200 [PriceMy] => SimpleXMLElement Object ( ) [PriceUser] => 190 [PriceVIP4] => 184 [PriceVIP5] => 176 [PriceVIP9] => 170 [RoomTags] => SimpleXMLElement Object ( ) [RoomTypeId] => YXSC [RoomTypeName] => 大床房A ) [2] => SimpleXMLElement Object ( [CanBook] => 0 [Desc] => SimpleXMLElement Object ( ) [MyPriceCode] => SimpleXMLElement Object ( ) [PriceList] => 200 [PriceMy] => SimpleXMLElement Object ( ) [PriceUser] => 190 [PriceVIP4] => 184 [PriceVIP5] => 176 [PriceVIP9] => 170 [RoomTags] => SimpleXMLElement Object ( ) [RoomTypeId] => SWDCF [RoomTypeName] => 商务大床房 ) [3] => SimpleXMLElement Object ( [CanBook] => 0 [Desc] => SimpleXMLElement Object ( ) [MyPriceCode] => SimpleXMLElement Object ( ) [PriceList] => 200 [PriceMy] => SimpleXMLElement Object ( ) [PriceUser] => 190 [PriceVIP4] => 184 [PriceVIP5] => 176 [PriceVIP9] => 170 [RoomTags] => SimpleXMLElement Object ( ) [RoomTypeId] => SCF [RoomTypeName] => 标准房 ) ) ) ) )
	
	//56、 获得酒店价格信息,包括房型详细信息，返回结果仅支持json 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"start" =>"2016-01-07",
	// 	"end"=>"2016-03-03",
	// 	"count"=>"1"
	// );
	// $client->call ( 'LoadHotelDetailPriceInfo3',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelDetailPriceInfo3Result] => {"Prices":[{"RoomTypeId":"YXDCA","RoomTypeName":"特价大床房A","PriceList":"200","PriceUser":"190","PriceVIP4":"184","PriceVIP5":"176","PriceVIP9":"170","PriceMy":null,"MyPriceCode":null,"Desc":null,"CanBook":"0","RoomTags":[]},{"RoomTypeId":"YXSC","RoomTypeName":"大床房A","PriceList":"200","PriceUser":"190","PriceVIP4":"184","PriceVIP5":"176","PriceVIP9":"170","PriceMy":null,"MyPriceCode":null,"Desc":null,"CanBook":"0","RoomTags":[]},{"RoomTypeId":"SWDCF","RoomTypeName":"商务大床房","PriceList":"200","PriceUser":"190","PriceVIP4":"184","PriceVIP5":"176","PriceVIP9":"170","PriceMy":null,"MyPriceCode":null,"Desc":null,"CanBook":"0","RoomTags":[]},{"RoomTypeId":"SCF","RoomTypeName":"标准房","PriceList":"200","PriceUser":"190","PriceVIP4":"184","PriceVIP5":"176","PriceVIP9":"170","PriceMy":null,"MyPriceCode":null,"Desc":null,"CanBook":"0","RoomTags":[]}],"Details":[{"HRT_ID":4,"HRT_PH_NO":"zj1","HRT_NO":"YXDCA","HRT_NAME":"特价大床房A","HRT_BED_TYPE_NAME":"大床","HRT_BED_WIDTH_NAME":"1.35米","HRT_ROOM_NETWORK_NAME":"无线宽带【免费】","HRT_ROOM_Area":"10","HRT_ROOM_FLOOR":null,"HRT_ROOM_Desc":"配电视、wifi","HRT_FILE_PATH":"http://pod100.com/uf/UploadFiles/20150626/72f74e0fdba746b4987b5f67e794a1a0.jpg","HRT_FUN":"'A','B','U'"},{"HRT_ID":1,"HRT_PH_NO":"zj1","HRT_NO":"YXSC","HRT_NAME":"大床房A","HRT_BED_TYPE_NAME":"大床","HRT_BED_WIDTH_NAME":"1.35米","HRT_ROOM_NETWORK_NAME":"无线宽带【免费】","HRT_ROOM_Area":"10","HRT_ROOM_FLOOR":null,"HRT_ROOM_Desc":"配电视、wifi","HRT_FILE_PATH":"http://pod100.com/uf/UploadFiles/20150626/72f74e0fdba746b4987b5f67e794a1a0.jpg","HRT_FUN":"'A','B','U'"},{"HRT_ID":2,"HRT_PH_NO":"zj1","HRT_NO":"SWDCF","HRT_NAME":"商务大床房","HRT_BED_TYPE_NAME":"大床","HRT_BED_WIDTH_NAME":"1.35米","HRT_ROOM_NETWORK_NAME":"无线宽带【免费】","HRT_ROOM_Area":"10","HRT_ROOM_FLOOR":null,"HRT_ROOM_Desc":"配电视、wifi","HRT_FILE_PATH":"http://pod100.com/uf/UploadFiles/20150626/72f74e0fdba746b4987b5f67e794a1a0.jpg","HRT_FUN":"'A','B','U'"},{"HRT_ID":3,"HRT_PH_NO":"zj1","HRT_NO":"SCF","HRT_NAME":"标准房","HRT_BED_TYPE_NAME":"双床","HRT_BED_WIDTH_NAME":"1.1米","HRT_ROOM_NETWORK_NAME":"无线宽带【免费】","HRT_ROOM_Area":"15","HRT_ROOM_FLOOR":null,"HRT_ROOM_Desc":"配电视、wifi","HRT_FILE_PATH":"http://pod100.com/uf/UploadFiles/20150626/9b4fe9bae69549139450afbda39bf34d.jpg","HRT_FUN":"'B','J','V','U'"}]} )
	
	//57、 获得酒店详情活动多个价格，返回结果仅支持json，（手机客户端） 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"hotelNo"=>"zj1",
//		"start" =>"2016-01-07",
//		"end"=>"2016-03-03",
//		"count"=>"1",
//		"linkTag"=>"32",
//		"v"=>"520"
//	);
//	$client->call ( 'LoadHotelDetailPriceInfo4',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelDetailPriceInfo4Result] => [{"RoomType":"YXDCA","RoomTypeName":"特价大床房A","PriceList":"200","MyPrice":"89","CanBook":false,"BED_TYPE":"大床","BED_WIDTH":"1.35米","NETWORK":"无线宽带【免费】","Area":"10","Desc":"配电视、wifi","Pic":"http://pod100.com/uf/UploadFiles/20150626/72f74e0fdba746b4987b5f67e794a1a0.jpg","ActivityPrice":[{"PriceUser":"190","CanBook":false,"ActivityName":"会员价","TitleTip":null,"O_FUN":0,"FullTip":null,"BookTip":null,"LMR_ID":0,"Left":0,"focus":false,"isSmall":false,"imgFun":"","Ppre":"￥","Breakfast":null,"bQuick":false,"PriceValue":null},{"PriceUser":"89","CanBook":false,"ActivityName":"69爆爽价","TitleTip":"","O_FUN":28,"FullTip":null,"BookTip":"","LMR_ID":0,"Left":0,"focus":false,"isSmall":false,"imgFun":"","Ppre":"￥","Breakfast":null,"bQuick":false,"PriceValue":null},{"PriceUser":"152","CanBook":false,"ActivityName":"惊喜折上折","TitleTip":"会员价基础上再7-8折","O_FUN":38,"FullTip":"数量有限抢完为止","BookTip":"会员价基础上再7-8折","LMR_ID":0,"Left":0,"focus":true,"isSmall":false,"imgFun":"","Ppre":"￥","Breakfast":null,"bQuick":true,"PriceValue":null},{"PriceUser":"140","CanBook":false,"ActivityName":"预付立减","TitleTip":"预付更优惠","O_FUN":10,"FullTip":"数量有限抢完为止","BookTip":"预付更优惠","LMR_ID":0,"Left":0,"focus":true,"isSmall":false,"imgFun":"","Ppre":"￥","Breakfast":null,"bQuick":true,"PriceValue":null},{"PriceUser":"120","CanBook":false,"ActivityName":"越早定越便宜","TitleTip":"必需提前2天，订单不可修改、不取消、不退款","O_FUN":32,"FullTip":"数量有限抢完为止","BookTip":null,"LMR_ID":1,"Left":0,"focus":false,"isSmall":false,"imgFun":"","Ppre":"￥","Breakfast":null,"bQuick":true,"PriceValue":null}],"RoomTags":[]},{"RoomType":"YXSC","RoomTypeName":"大床房A","PriceList":"200","MyPrice":"69","CanBook":false,"BED_TYPE":"大床","BED_WIDTH":"1.35米","NETWORK":"无线宽带【免费】","Area":"10","Desc":"配电视、wifi","Pic":"http://pod100.com/uf/UploadFiles/20150626/72f74e0fdba746b4987b5f67e794a1a0.jpg","ActivityPrice":[{"PriceUser":"190","CanBook":false,"ActivityName":"会员价","TitleTip":null,"O_FUN":0,"FullTip":null,"BookTip":null,"LMR_ID":0,"Left":0,"focus":false,"isSmall":false,"imgFun":"","Ppre":"￥","Breakfast":null,"bQuick":false,"PriceValue":null},{"PriceUser":"69","CanBook":false,"ActivityName":"69爆爽价","TitleTip":"","O_FUN":28,"FullTip":null,"BookTip":"","LMR_ID":0,"Left":0,"focus":false,"isSmall":false,"imgFun":"","Ppre":"￥","Breakfast":null,"bQuick":false,"PriceValue":null}],"RoomTags":[]},{"RoomType":"SWDCF","RoomTypeName":"商务大床房","PriceList":"200","MyPrice":"69","CanBook":false,"BED_TYPE":"大床","BED_WIDTH":"1.35米","NETWORK":"无线宽带【免费】","Area":"10","Desc":"配电视、wifi","Pic":"http://pod100.com/uf/UploadFiles/20150626/72f74e0fdba746b4987b5f67e794a1a0.jpg","ActivityPrice":[{"PriceUser":"190","CanBook":false,"ActivityName":"会员价","TitleTip":null,"O_FUN":0,"FullTip":null,"BookTip":null,"LMR_ID":0,"Left":0,"focus":false,"isSmall":false,"imgFun":"","Ppre":"￥","Breakfast":null,"bQuick":false,"PriceValue":null},{"PriceUser":"69","CanBook":false,"ActivityName":"69爆爽价","TitleTip":"","O_FUN":28,"FullTip":null,"BookTip":"","LMR_ID":0,"Left":0,"focus":false,"isSmall":false,"imgFun":"","Ppre":"￥","Breakfast":null,"bQuick":false,"PriceValue":null}],"RoomTags":[]},{"RoomType":"SCF","RoomTypeName":"标准房","PriceList":"200","MyPrice":"79","CanBook":false,"BED_TYPE":"双床","BED_WIDTH":"1.1米","NETWORK":"无线宽带【免费】","Area":"15","Desc":"配电视、wifi","Pic":"http://pod100.com/uf/UploadFiles/20150626/9b4fe9bae69549139450afbda39bf34d.jpg","ActivityPrice":[{"PriceUser":"190","CanBook":false,"ActivityName":"会员价","TitleTip":null,"O_FUN":0,"FullTip":null,"BookTip":null,"LMR_ID":0,"Left":0,"focus":false,"isSmall":false,"imgFun":"","Ppre":"￥","Breakfast":null,"bQuick":false,"PriceValue":null},{"PriceUser":"79","CanBook":false,"ActivityName":"69爆爽价","TitleTip":"","O_FUN":28,"FullTip":null,"BookTip":"","LMR_ID":0,"Left":0,"focus":false,"isSmall":false,"imgFun":"","Ppre":"￥","Breakfast":null,"bQuick":false,"PriceValue":null}],"RoomTags":[]}] )
	
	//58、 获得酒店价格信息,多天返回总价(微信,废弃中..) 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"hotelNo"=>"zj1",
//		"start" =>"2016-01-07",
//		"end"=>"2016-03-03",
//		"count"=>"1"
//	);
//	$client->call ( 'LoadHotelDetailPriceInfo2',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelDetailPriceInfo2Result] => SimpleXMLElement Object ( [ArrayOfHotelModel.HotelPriceInfo] => SimpleXMLElement Object ( [HotelModel.HotelPriceInfo] => Array ( [0] => SimpleXMLElement Object ( [CanBook] => 0 [Desc] => SimpleXMLElement Object ( ) [MyPriceCode] => SimpleXMLElement Object ( ) [PriceList] => 8800 [PriceMy] => SimpleXMLElement Object ( ) [PriceUser] => 8360 [PriceVIP4] => 8096 [PriceVIP5] => 7744 [PriceVIP9] => SimpleXMLElement Object ( ) [RoomTags] => SimpleXMLElement Object ( ) [RoomTypeId] => YXDCA [RoomTypeName] => 特价大床房A ) [1] => SimpleXMLElement Object ( [CanBook] => 0 [Desc] => SimpleXMLElement Object ( ) [MyPriceCode] => SimpleXMLElement Object ( ) [PriceList] => 8800 [PriceMy] => SimpleXMLElement Object ( ) [PriceUser] => 8360 [PriceVIP4] => 8096 [PriceVIP5] => 7744 [PriceVIP9] => SimpleXMLElement Object ( ) [RoomTags] => SimpleXMLElement Object ( ) [RoomTypeId] => YXSC [RoomTypeName] => 大床房A ) [2] => SimpleXMLElement Object ( [CanBook] => 0 [Desc] => SimpleXMLElement Object ( ) [MyPriceCode] => SimpleXMLElement Object ( ) [PriceList] => 8800 [PriceMy] => SimpleXMLElement Object ( ) [PriceUser] => 8360 [PriceVIP4] => 8096 [PriceVIP5] => 7744 [PriceVIP9] => SimpleXMLElement Object ( ) [RoomTags] => SimpleXMLElement Object ( ) [RoomTypeId] => SWDCF [RoomTypeName] => 商务大床房 ) [3] => SimpleXMLElement Object ( [CanBook] => 0 [Desc] => SimpleXMLElement Object ( ) [MyPriceCode] => SimpleXMLElement Object ( ) [PriceList] => 8800 [PriceMy] => SimpleXMLElement Object ( ) [PriceUser] => 8360 [PriceVIP4] => 8096 [PriceVIP5] => 7744 [PriceVIP9] => SimpleXMLElement Object ( ) [RoomTags] => SimpleXMLElement Object ( ) [RoomTypeId] => SCF [RoomTypeName] => 标准房 ) ) ) ) )
	
	//59、 获得酒店价格信息,多天返回总价(微信) （暂时缺少OpenID）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"hotelNo"=>"zj1",
	// 	"start" =>"2016-01-07",
	// 	"end"=>"2016-03-03",
	// 	"count"=>"1",
	// 	"OpenID"=>""
	// );
	// $client->call ( 'LoadHotelDetailPriceInfo2_2',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [0] => )
	
	//60、 获得用户可点评的入住信息
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// );
	// $client->call ( 'LoadHotelCommentList',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadHotelCommentListResult] => SimpleXMLElement Object ( [ArrayOfHotelModel.HotelComment] => SimpleXMLElement Object ( ) ) )
	
	//61、 点评 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"orderID"=>"O16010711114538101S",
	// 	"HotelID" =>"zj1",
	// 	"J_Star1"=>"5",
	// 	"J_Star2"=>"5",
	// 	"J_Star3"=>"5",
	// 	"J_Star4"=>"5",
	// 	"content"=>"评论啊"
	// );
	// $client->call ( 'HotelComment',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [HotelCommentResult] => EX_定单号不正确或已评 )
	
	//62、 点评2 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"orderID"=>"O16010615520048701S",
	// 	"HotelID" =>"zj1",
	// 	"J_Star1"=>"5",
	// 	"J_Star2"=>"5",
	// 	"J_Star3"=>"5",
	// 	"J_Star4"=>"5",
	// 	"content"=>"评论啊",
	// 	"InDest"=>"2",
	// 	"pl"=>"2",
	// 	"hotelLike"=>"评论啊"
	// );
	// $client->call ( 'HotelComment2',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [HotelComment2Result] => EX_定单号不正确或已评 )
	
	//63、 获得代码表
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// // $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"CodeTableName"=>"CD_HOTEL_PEN_DEST"
	// );
	// $client->call ( 'GetCodeTable',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [GetCodeTableResult] => EX_无权限调用此接口 )
	
	//64、 添加常用酒店
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"HotelID"=>"zj1"
	// );
	// $client->call ( 'AddMyCommonHotel',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [AddMyCommonHotelResult] => -100 )用户未登录
	//Array ( [AddMyCommonHotelResult] => OK ) 成功
	//Array ( [AddMyCommonHotelResult] => ERROR )表示已收藏
	
	//65、 删除常用酒店
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"HotelID"=>"zj1"
//	);
//	$client->call ( 'DeleteMyCommonHotel',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [DeleteMyCommonHotelResult] => EX_无权限调用此接口 )
	
	//66、 获得我常用的酒店列表
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// );
	// $client->call ( 'LoadMyCommonHotel',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadMyCommonHotelResult] => SimpleXMLElement Object ( [ArrayOfHotelModel.CommonHotel] => SimpleXMLElement Object ( [HotelModel.CommonHotel] => SimpleXMLElement Object ( [MCH_HOTEL_ID] => zj1 [MCH_PM_ID] => 4978027 [PH_NAME] => 布丁酒店杭州武林西湖文化广场地铁站店 [PH_TEL] => 0571-85237220 ) ) ) )
	
	//67、 获得类型贴子（我的）
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"PageIndex"=>"1",
	// 	"type"=>"7",
	// 	"pageSize"=>"10"
	// );
	// $client->call ( 'GetMyDntList',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [GetMyDntListResult] => EX_反射类型“Discuz.Toolkit.TopicGetListResponse”时出错。 )
	
	//68、 获得当前用户所有优惠券
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"pageIndex"=>"1",
	// 	"pageSize"=>"2"
	// );
	// $client->call ( 'LoadMyVoucher',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadMyVoucherResult] => SimpleXMLElement Object ( [PageDataOfMemberModel.Voucher47PfhAw0] => SimpleXMLElement Object ( [Count] => 0 [Datas] => SimpleXMLElement Object ( ) ) ) )
	
	//69、 优惠券统计
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"dataType"=>"xml"
	// );
	// $client->call ( 'LoadMyVoucherSum',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadMyVoucherSumResult] => SimpleXMLElement Object ( [publicName2Model] => SimpleXMLElement Object ( [N] => 0 [N2] => SimpleXMLElement Object ( ) ) ) )
	
	//70、 获得当前用户所有特权券
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"pageIndex"=>"1",
//		"pageSize"=>"2",
//		"dataType"=>"xml"
//	);
//	$client->call ( 'LoadMySelfPriceList',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [LoadMySelfPriceListResult] => SimpleXMLElement Object ( [PageDataOfMemberModel.HotelSelfPrice47PfhAw0] => SimpleXMLElement Object ( [Count] => 0 [Datas] => SimpleXMLElement Object ( ) ) ) )
	
	//71、 获得我的订单列表
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// );
	// $client->call ( 'LoadMyOrder',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadMyOrderResult] => SimpleXMLElement Object ( [ArrayOfCardOrder] => SimpleXMLElement Object ( [CardOrder] => SimpleXMLElement Object ( [CanOperator] => false [HotelName] => 布丁酒店杭州武林西湖文化广场地铁站店 [adult_quantity] => 1 [arrive_info] => SimpleXMLElement Object ( ) [booker_name] => hong [check_in_date] => 2016-01-10 [check_out_date] => 2016-01-11 [child_quantity] => 0 [deposit] => 0.00 [earliest_arrive] => SimpleXMLElement Object ( ) [email] => SimpleXMLElement Object ( ) [guarantee_score] => SimpleXMLElement Object ( ) [hotel_id] => zj1 [latest_arrive] => SimpleXMLElement Object ( ) [mobile] => SimpleXMLElement Object ( ) [newStatus] => SimpleXMLElement Object ( ) [note] => SimpleXMLElement Object ( ) [order_status] => 入住前 [order_status_code] => 0 [order_time] => 2016-01-06T15:54:06 [payment_mode_id] => SimpleXMLElement Object ( ) [reserve_hour] => SimpleXMLElement Object ( ) [room_order_id] => O16010615520048701S [room_quantity] => 1 [room_type_id] => YXDCA [room_type_name] => 优选大床房A [total_price] => 190 ) ) ) )Array ( [LoadMyOrderResult] => SimpleXMLElement Object ( [ArrayOfCardOrder] => SimpleXMLElement Object ( [CardOrder] => SimpleXMLElement Object ( [CanOperator] => false [HotelName] => 布丁酒店杭州武林西湖文化广场地铁站店 [adult_quantity] => 1 [arrive_info] => SimpleXMLElement Object ( ) [booker_name] => hong [check_in_date] => 2016-01-10 [check_out_date] => 2016-01-11 [child_quantity] => 0 [deposit] => 0.00 [earliest_arrive] => SimpleXMLElement Object ( ) [email] => SimpleXMLElement Object ( ) [guarantee_score] => SimpleXMLElement Object ( ) [hotel_id] => zj1 [latest_arrive] => SimpleXMLElement Object ( ) [mobile] => SimpleXMLElement Object ( ) [newStatus] => SimpleXMLElement Object ( ) [note] => SimpleXMLElement Object ( ) [order_status] => 入住前 [order_status_code] => 0 [order_time] => 2016-01-06T15:54:06 [payment_mode_id] => SimpleXMLElement Object ( ) [reserve_hour] => SimpleXMLElement Object ( ) [room_order_id] => O16010615520048701S [room_quantity] => 1 [room_type_id] => YXDCA [room_type_name] => 优选大床房A [total_price] => 190 ) ) ) )
	
	//72、 获得我的订单列表,带开始时间与结速时间 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"start"=>"2016-01-05",
//		"end"=>"2016-01-07",
//		"dataType"=>"xml"
//	);
//	$client->call ( 'LoadMyOrder2',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [LoadMyOrder2Result] => SimpleXMLElement Object ( [ArrayOfCardOrder] => SimpleXMLElement Object ( [CardOrder] => SimpleXMLElement Object ( [CanOperator] => false [HotelName] => 布丁酒店杭州武林西湖文化广场地铁站店 [adult_quantity] => 1 [arrive_info] => SimpleXMLElement Object ( ) [booker_name] => hong [check_in_date] => 2016-01-10 [check_out_date] => 2016-01-11 [child_quantity] => 0 [deposit] => 0.00 [earliest_arrive] => SimpleXMLElement Object ( ) [email] => SimpleXMLElement Object ( ) [guarantee_score] => SimpleXMLElement Object ( ) [hotel_id] => zj1 [latest_arrive] => SimpleXMLElement Object ( ) [mobile] => SimpleXMLElement Object ( ) [newStatus] => SimpleXMLElement Object ( ) [note] => SimpleXMLElement Object ( ) [order_status] => 入住前 [order_status_code] => 0 [order_time] => 2016-01-06T15:54:06 [payment_mode_id] => SimpleXMLElement Object ( ) [reserve_hour] => SimpleXMLElement Object ( ) [room_order_id] => O16010615520048701S [room_quantity] => 1 [room_type_id] => YXDCA [room_type_name] => 优选大床房A [total_price] => 190 ) ) ) )
	
	//73、 获得历史订单
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"InName"=>"hong",
	// 	"HotelID"=>"zj1"
	// );
	// $client->call ( 'MyOrderHistoryList',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));	
	//Array ( [MyOrderHistoryListResult] => SimpleXMLElement Object ( [ArrayOfCardCheckRecord] => SimpleXMLElement Object ( ) ) )
	
	//74、 APP搜索列表功能 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'AppFun',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [AppFunResult] => [{"Value":"P","Text":"惊喜折上折"},{"Value":"D","Text":"越早定越便宜"},{"Value":"C","Text":"积分换免房"},{"Value":"M","Text":"69元爆爽价"},{"Value":"Q","Text":"返现"},{"Value":"K","Text":"预付立减"}] )
	
	//75、 获得历史订单(可以根据时间) 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"InName"=>"hong",
	// 	"HotelID"=>"zj1",
	// 	"start"=>"2016-01-05",
	// 	"end"=>"2016-01-07",
	// 	"dataType"=>"xml"
	// );
	// $client->call ( 'MyOrderHistoryList2',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [MyOrderHistoryList2Result] => SimpleXMLElement Object ( [ArrayOfCardCheckRecord] => SimpleXMLElement Object ( ) ) )
	
	//76、 查会员卡对应的返现操作日志
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"cardNo"=>"00051625",
	// 	"cardTypeID"=>"100",
	// 	"dataType"=>"xml"
	// );
	// $client->call ( 'MyCashHistory',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));	
	//Array ( [MyCashHistoryResult] => 0.00| )
	
	//77、 提现申请列表
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"pageIndex"=>"1",
//		"pageSize"=>"6",
//		"dataType"=>"xml"
//	);
//	$client->call ( 'MyCashApplication',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [MyCashApplicationResult] => SimpleXMLElement Object ( [PageDataOfCashModel47PfhAw0] => SimpleXMLElement Object ( [Count] => 0 [Datas] => SimpleXMLElement Object ( ) ) ) )
	
	//78、 获得会员卡返现余额
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"cardNo"=>"00051625",
	// 	"cardTypeID"=>"100",
	// 	"dataType"=>"xml"
	// );
	// $client->call ( 'MyCashLeft',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));	
	///Array ( [MyCashLeftResult] => 0 )

	//79、 当前订单中使用返现，相关应付金额接口需要修改为
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"cash"=>"1"
//	);
//	$client->call ( 'MyCashUse',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
//	//Array ( [0] => )
	
	//80、 验证码领券模块,验证码通过，GetImageCode接口获得图形 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"id"=>"1",
	// 	"type"=>"20130828",
	// 	"key"=>"",
	// 	"vmCode"=>""
	// );
	// $client->call ( 'GetVoucherByCode',$data);
	// $p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//
	
	//81、 获得历史订单(可以根据时间)
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"start"=>"2016-01-05",
//		"end"=>"2016-01-07",
//		"dataType"=>"xml",
//		"pageIndex"=>"1",
//		"pageSize"=>"3",
//		"openID"=>""
//	);
//	$client->call ( 'MyOrderWenXin',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [0] => )
	
	//82、 获得订单(根据会员卡号),建议按天或按月来查询 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"start"=>"2016-01-01",
	// 	"end"=>"2016-01-10",
	// 	"dataType"=>"xml",
	// 	"cardNo"=>"00051625",
	// 	"cardType"=>"100"
	// );
	// $client->call ( 'MyOrderByCard',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));	
	//Array ( [0] => )
	
	//83、 取消定单
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"orderId"=>"O16010711245931121S",
	// 	"mobile"=>"13580506405",
	// 	"DispoteMoney"=>"0",
	// 	"cancelReson"=>"测试"
	// );
	// $client->call ( 'CancelOrder',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));	
	//Array ( [CancelOrderResult] => OK )

	//84、 初始定单数据(带各种订单功能的） 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"HotelID"=>"zj1",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomCount"=>"1",
	// 	"from"=>"-1",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"",
	// 	"LinkMobile"=>"13502556580",
	// 	"LMR_ID"=>"0",
	// 	"O_FUN"=>"0"	//在酒店详细报名接口会返回 每种活动的O_FUN值
	// );
	// $client->call ( 'InitOrder2',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));	
	//Array ( [InitOrder2Result] => OK )

	//85、 设置 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"InName"=>"hong",
//		"LinkEmail"=>"",
//		"LinkMobile"=>"13580506405"
//	);
//	$client->call ( 'SetOrderUserInfo',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [SetOrderUserInfoResult] => OK )
	
	//86、 设置房间数 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"roomCount"=>"1"
//	);
//	$client->call ( 'SetOrderRoomCount',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [SetOrderRoomCountResult] => OK )
	
	//87、 初始定单数据 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"HotelID"=>"zj1",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomCount"=>"1",
	// 	"from"=>"-1",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"",
	// 	"LinkMobile"=>"13502556580"
	// );
	// $client->call ( 'InitOrder',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));	
	//Array ( [InitOrder2Result] => OK )
	//

	//88、 保存订单 （需要“memID”，该接口不要用）
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"memID"=>"L5TBSBMfVHOr3acHLy1BZw==",//已加密
	// 	"HotelID"=>"zj1",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomCount"=>"1",
	// 	"from"=>"-1",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405"
	// );
	// $client->call ( 'SaveOrder2',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [SaveOrder2Result] => EX_没有读到你的会员卡信息，请刷新重试 )
	
	//89、 优惠订单（关联会员）,-10元,参数同:SaveOrder2（微信）（作废） 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"OpenID"=>"",
	// 	"HotelID"=>"zj1",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomTypeName"=>"特价大床房A",
	// 	"RoomCount"=>"1",
	// 	"from"=>"-1",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405",
	// 	"voucherKey"=>"VOUCHER_QQ_AUTO_SEND_10"
	// );
	// $client->call ( 'SaveOrder2_3',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [0] => )

	//90、 保存订单,92折，注册新用户 (需要“memID”参数，该接口不用要)
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"memID"=>"L5TBSBMfVHOr3acHLy1BZw==",
	// 	"cardNo"=>"00051625",
	// 	"cardType"=>"100",
	// 	"HotelID"=>"zj1",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomTypeName"=>"特价大床房A",
	// 	"RoomCount"=>"1",
	// 	"from"=>"-1",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405"
	// );
	// $client->call ( 'SaveOrder4',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [SaveOrder4Result] => 服务器忙，请重试! )

	//91、 保存订单,返回XML结果数据带，订单 首晚应付金额，金额应付金额 ,去哪儿ppb 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// // $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"memID"=>"L5TBSBMfVHOr3acHLy1BZw==",
	// 	"cardNo"=>"00051625",
	// 	"cardType"=>"100",
	// 	"HotelID"=>"zj1",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomTypeName"=>"特价大床房A",
	// 	"RoomCount"=>"1",
	// 	"from"=>"-1",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405",
	// 	"OtherOrderNo"=>"O16010711114538101S",
	// 	"payWay"=>"0",
	// 	"totalMoney"=>"",
	// 	"priceType"=>""
	// );
	// $client->call ( 'SaveOrder4_2',$data);
	// $p = $client->document;
	// print_r($p);
	// success O16010711243572311S

	//92、 保存订单,自助保存订单  （无关）
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"cardNo"=>"00051625",
	// 	"cardType"=>"100",
	// 	"HotelID"=>"zj1",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomTypeName"=>"特价大床房A",
	// 	"RoomCount"=>"1",
	// 	"from"=>"-1",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405",
	// 	"OtherOrderNo"=>"O16010711114538101S",
	// 	"payWay"=>"0",
	// 	"totalMoney"=>"",
	// 	"voucherKey"=>"VOUCHER_QQ_AUTO_SEND_10"
	// );
	// $client->call ( 'SaveOrder4_5',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	// Array ( [0] => )

	//93、 越早定越便宜保存订单,返回XML结果数据带，订单 首晚应付金额，金额应付金额,去哪儿越早   
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"memID"=>"",
	// 	"cardNo"=>"00051625",
	// 	"cardType"=>"100",
	// 	"HotelID"=>"zj1",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomTypeName"=>"特价大床房A",
	// 	"RoomCount"=>"1",
	// 	"from"=>"-1",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405",
	// 	"OtherOrderNo"=>"O16010711114538101S",
	// 	"payWay"=>"0",
	// 	"totalMoney"=>""
	// );
	// $client->call ( 'SaveOrder4_3',$data);
	// $p = $client->document;
	// print_r($p);
	//0 success O16010711243572311S 0 0

	//94、 检查新会员（qunar）
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"sfz"=>"440106198303178431",
	// 	"dataType"=>"xml"
	// );
	// $client->call ( 'CheckNewUser',$data);
	// $p = $client->document;
	// var_dump($p);
	/*
	<CheckNewUserResponse xmlns="http://tempuri.org/"><CheckNewUserResult><?xml version="1.0" encoding="utf-8"?>
		<Return>
		  <RetCode>0</RetCode>
		  <RetMsg>Success</RetMsg>
		</Return>
	</CheckNewUserResult></CheckNewUserResponse>
	 */

    //95、 69保存订单（去哪儿）  
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"memID"=>"",
	// 	"cardNo"=>"00051625",
	// 	"cardType"=>"100",
	// 	"HotelID"=>"zj1",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomTypeName"=>"特价大床房A",
	// 	"RoomCount"=>"1",
	// 	"from"=>"-1",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405",
	// 	"OtherOrderNo"=>"O16010711114538101S",
	// 	"payWay"=>"0",
	// 	"totalMoney"=>"",
	// 	"sfz"=>"440106198303178431"
	// );
	// $client->call ( 'SaveOrder4_4',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//报错，返回Array ( [0] => )

	//116、 保存订单 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"payWay"=>"0",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405",
	// 	"cash"=>""
	// );
	// $client->call ( 'SaveOrder',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [SaveOrderResult] => OKO16010615520048701S )
	//Array ( [SaveOrderResult] => OKO16010711245931121S )
	
	//96、 通知付款(每客户订单仅能支付一次)
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"OrderNo"=>"O16010615520048701S",
//		"OtherOrderNo"=>"1111",
//		"money"=>"1",
//		"payMethodNo"=>"111"
//	);
//	$client->call ( 'DepositOrder',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
//	Array ( [DepositOrderResult] => EX_无权限调用此接口 )
	
	//97、 自定义价格保存定单(夜宵) （需要“memID”，不用）
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"dCode"=>"",
	// 	"memID"=>"",
	// 	"HotelID"=>"zj1",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomCount"=>"1",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405",
	// 	"priceType"=>""
	// );
	// $client->call ( 'SaveOrder5',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [SaveOrder5Result] => EX_业务代码错误 )

	//98、 自定义价格保存定单(注册新会员),未启动 
	
	//99、 保存订单2（中介订单,同程） (需要“memID”参数，不是我们这边调用的)
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"memID"=>"L5TBSBMfVHOr3acHLy1BZw==",
	// 	"HotelID"=>"zj1",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomTypeName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"RoomCount"=>"1",
	// 	"from"=>"-1",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405",
	// 	"Commission_company_id"=>"23",
	// 	"Commission_type_id"=>"579",
	// 	"Biz_source_id"=>"10000001",
	// 	"TotalRoomCount"=>"1",
	// 	"isDanBao"=>"1",
	// 	"inOrderNo"=>"",
	// 	"arrivalTime"=>"20"
	// );
	// $client->call ( 'SaveOrder6_2',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	// Array ( [0] => )

	//100、 保存订单,钟点房  
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"memID"=>"L5TBSBMfVHOr3acHLy1BZw==",
	// 	"HotelID"=>"zj1",
	// 	"hotelName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"InDate"=>"2016-01-08",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomTypeName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"RoomCount"=>"1",
	// 	"arrivalTime"=>"20",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405",
	// 	"from"=>"-1"
	// );
	// $client->call ( 'SaveOrder7',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	// Array ( [SaveOrder7Result] => 该酒店不参加钟点房 )

	//101、 保存订单团购(暂不支持新会员团购与多天连住团购) 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"tuanCode"=>"111",
	// 	"HotelID"=>"zj1",
	// 	"InDate"=>"2016-01-08",
	// 	"InDate2"=>"2016-01-10",
	// 	"RoomType"=>"YXDCA",
	// 	"RoomTypeName"=>"布丁酒店杭州武林西湖文化广场地铁站店",
	// 	"RoomCount"=>"1",
	// 	"arrivalTime"=>"20",
	// 	"InName"=>"hong",
	// 	"LinkEmail"=>"645030813@qq.com",
	// 	"LinkMobile"=>"13580506405",
	// 	"from"=>"-1",
	// 	"OtherOrderNo"=>"O16010615520048701S",
	// 	"payMethodNo"=>"111"
	// );
	// $client->call ( 'SaveOrder9',$data);
	// $p = $client->document;
	// var_dump($p);
	/*
	返回的数据：
	<SaveOrder9Response xmlns="http://tempuri.org/"><SaveOrder9Result><?xml version="1.0" encoding="utf-8" ?><Return><RetCode>-3000</RetCode><RetMsg>团购类型不正确</RetMsg></Return></SaveOrder9Result></SaveOrder9Response>
	 */
	
	//102、 获得订单详情（扩展信息参数咨询技术支持人员） 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"orderID"=>"vWhr5QJRT9LMw2w2c1LsTXq988edl2rGhWAtXCM32Co=",//O16010615520048701S 
//		"mobile"=>"",
//		"bDailyPrice"=>"1",
//		"realReserveHour"=>"111",
//		"fact"=>""
//	);
//	$client->call ( 'GetOrderDetail',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetOrderDetailResult] => SimpleXMLElement Object ( [GetOrderDetailRsp] => SimpleXMLElement Object ( [HotelAddress] => 杭州市河东路85号（近文晖路口朝晖三区）,地铁1号线至西湖文化广场站下A出口,前方河东路步行5分钟,左边中国农业银行口进即可,酒店200米有机场大巴 [HotelName] => 布丁酒店杭州武林西湖文化广场地铁站店 [adult_quantity] => 1 [booker_name] => hong [check_in_date] => 2016-01-10 [check_out_date] => 2016-01-11 [child_quantity] => 0 [company_id] => 0 [daily_prices] => 2016-01-10:190.00 [deposit] => 0 [email] => 645030813@qq.com [fack_out] => SimpleXMLElement Object ( ) [fact_in] => SimpleXMLElement Object ( ) [fact_nights] => 0 [hotel_id] => zj1 [member_card_no] => 00051625 [member_card_type_Name] => SimpleXMLElement Object ( ) [member_card_type_id] => SimpleXMLElement Object ( ) [mobile] => 13580506405 [note] => SimpleXMLElement Object ( ) [order_status] => 入住前 [order_status_code] => 0 [order_time] => 2016-01-06 [payment_mode_id] => SimpleXMLElement Object ( ) [payment_mode_id_code] => 0 [rate_code] => MEMV1 [reserve_hour] => 18 [room_order_id] => O16010615520048701S [room_quantity] => 1 [room_type_id] => YXDCA [room_type_name] => 优选大床房A [total_price] => 190 ) ) )

	//103、 获得订单详情,adult_quantity字段为门市价总价(微信)
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"orderID"=>"vWhr5QJRT9LMw2w2c1LsTXq988edl2rGhWAtXCM32Co=",
	// 	"mobile"=>"KAEJl9eotfN9wIdP6nqe/w==" 
	// );
	// $client->call ( 'GetOrderDetail2',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	// Array ( [0] => )
	
	//104、 根据定单号初始定单
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"orderID"=>"O16010615520048701S",
//		"mobile"=>"13580506405"
//	);
//	$client->call ( 'InitOrderByOrderID',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [InitOrderByOrderIDResult] => OK )
	
	//105、 加载特权券列表
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'LoadSelfPrice',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
//	/Array ( [LoadSelfPriceResult] => SimpleXMLElement Object ( [ArrayOfSelectListItem] => SimpleXMLElement Object ( ) ) )
	
	//106、 加载特权券列表（新）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"dataType"=>"xml"
//	);
//	$client->call ( 'LoadSelfPrice2',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [LoadSelfPrice2Result] => SimpleXMLElement Object ( [ArrayOfSelfPriceList] => SimpleXMLElement Object ( ) ) )
	
	//107、 设置特权券(使用后优惠券自动清空)  
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"selfNo"=>"xml",
	// 	"selfType"=>"100"
	// );
	// $client->call ( 'setSelfPrice',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [setSelfPriceResult] => OK )

	//108、 设置门店优惠码 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"no"=>"xml"
	// );
	// $client->call ( 'SetHotelVoucher',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [SetHotelVoucherResult] => 优惠码不正确 )
	
	//109、 加载优惠券列表
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// );
	// $client->call ( 'LoadVoucher',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadVoucherResult] => SimpleXMLElement Object ( [ArrayOfSelectListItem] => SimpleXMLElement Object ( ) ) )
	
	//110、 加载优惠券列表
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"dataType"=>"100"
	// );
	// $client->call ( 'LoadVoucherWithMoney',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [LoadVoucherWithMoneyResult] => SimpleXMLElement Object ( [ArrayOfVoucherList] => SimpleXMLElement Object ( ) ) )
	
	//111、 设置优惠券
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"voucherNo"=>"11110",
	// 	"voucherType"=>"JS"
	// );
	// $client->call ( 'setVoucher',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [setVoucherResult] => 0|190.00|380 )  优惠金额|实付金额|获得积分
	//Array ( [setVoucherResult] => 0|380.00|760 )
	
	//112、 获得订单实体
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// );
	// $client->call ( 'GetOrderEntry',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [GetOrderEntryResult] => SimpleXMLElement Object ( [HotelModel.SearchAndEntryOfHotelBookModel.BookInfoQ0OmUAgs] => SimpleXMLElement Object ( [Search] => SimpleXMLElement Object ( ) [obj] => SimpleXMLElement Object ( [Add5] => false [Arrival_Time] => 18 [BCancel] => false [Biz_source_id] => SimpleXMLElement Object ( ) [Brand] => 0 [Bsfz] => false [BuyGood] => SimpleXMLElement Object ( ) [CXInfo] => SimpleXMLElement Object ( ) [CardMoneyTypeId] => MEMV1 [CardNo] => 00051625 [CardTypeID] => 100 [CardTypeIsMoney] => 1 [CardTypeName] => 网站会员 [Commission_type_id] => SimpleXMLElement Object ( ) [CompanyID] => SimpleXMLElement Object ( ) [DanBaoHour] => 0 [DistinctWeek] => SimpleXMLElement Object ( ) [FenCardPercent] => 2 [FenMoneyPay] => 0 [FenPayNeed] => 0 [FirstNightFee] => 190 [FirstNightListFee] => 200.00 [FullFee] => 200.00 [GuaType] => SimpleXMLElement Object ( ) [Guest_market_id] => SimpleXMLElement Object ( ) [HVNo] => SimpleXMLElement Object ( ) [HVType] => SimpleXMLElement Object ( ) [HasDoOrder] => true [HolidayPay] => false [HotelName] => 布丁酒店杭州武林西湖文化广场地铁站店 [InDate] => 2016-01-10T00:00:00 [InDate2] => 2016-01-11T00:00:00 [InName] => hong [IsAddComm] => SimpleXMLElement Object ( ) [IsAddCommHotel] => SimpleXMLElement Object ( ) [IsFenPay] => SimpleXMLElement Object ( ) [IsGw] => 0 [IsSelect] => SimpleXMLElement Object ( ) [IsSellGoods] => 1 [LinkEmail] => 645030813@qq.com [LinkMobile] => 13580506405 [LoginWay] => SimpleXMLElement Object ( ) [MustPayTip] => SimpleXMLElement Object ( ) [NC_CODE] => 04001019 [NoFL] => 1 [NotCount] => 0 [NotSendSms] => false [NotUseVoucher] => false [NotWx] => false [Note] => SimpleXMLElement Object ( ) [O_F2] => 0 [O_FUN] => 0 [OrderDate] => 2016-01-06T15:52:01.3193741+08:00 [OrderMustPay] => false [OtherInfo] => SimpleXMLElement Object ( ) [OtherSelfPriceDCode] => SimpleXMLElement Object ( ) [PD_OTHER_DATA3] => SimpleXMLElement Object ( ) [PMS_ERROR_CODE] => 0 [PayMode] => 0 [Phone] => SimpleXMLElement Object ( ) [PriceType] => 0 [RoomCount] => 1 [RoomType] => YXDCA [RoomTypeName] => 特价大床房A [Room_order_id] => O16010615520048701S [Rooms] => SimpleXMLElement Object ( ) [SMoney] => 0 [SelfPrice] => false [SelfPriceNo] => SimpleXMLElement Object ( ) [SelfPriceTypeID] => SimpleXMLElement Object ( ) [Sfzh] => SimpleXMLElement Object ( ) [TCode] => SimpleXMLElement Object ( ) [Times] => SimpleXMLElement Object ( ) [TotalFee] => 190 [TuanCode] => SimpleXMLElement Object ( ) [UseCash] => 0 [UseReVoucher] => false [UserCount] => 1 [VoucherDesc] => SimpleXMLElement Object ( ) [VoucherMoney] => 0 [VoucherNo] => SimpleXMLElement Object ( ) [VoucherTypeID] => SimpleXMLElement Object ( ) [WXOpenID] => SimpleXMLElement Object ( ) [Weeks] => SimpleXMLElement Object ( [HotelBookModel.WeekInfo] => SimpleXMLElement Object ( [Date] => 2016-01-10T00:00:00 [FullPrice] => 200.00 [Price] => 190 [Week] => 0 [WeekOfYear] => 3 [status] => 2 ) ) [_PayStatus] => SimpleXMLElement Object ( ) [cardId] => 30083753 [flmID] => SimpleXMLElement Object ( ) [from] => -1 [from2] => SimpleXMLElement Object ( ) [id] => zj1 [isYH] => 0 [remark] => SimpleXMLElement Object ( ) [setMustPayTip2] => SimpleXMLElement Object ( ) ) ) ) )
	
	//113、 获得订单实体包含，优惠券特权券集合
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'GetOrderEntryWithVandS',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetOrderEntryWithVandSResult] => OK00	返回:OK10原XML,第三位表示是否有优惠券，第4位表示是否有特权券
	
	//114、 设置价格类型（用户选择卡里）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"code"=>"GM8+KiTbf4QeeSlPq/ciDw==",//codestr
//		"cardNo" => "000001"
//	);
//	$client->call ( 'SetOrderPriceCode',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [SetOrderPriceCodeResult] => SimpleXMLElement Object ( [HotelModel.SearchAndEntryOfHotelBookModel.BookInfoQ0OmUAgs] => SimpleXMLElement Object ( [Search] => SimpleXMLElement Object ( ) [obj] => SimpleXMLElement Object ( [Add5] => false [Arrival_Time] => 18 [BCancel] => false [Biz_source_id] => SimpleXMLElement Object ( ) [Brand] => 0 [Bsfz] => false [BuyGood] => SimpleXMLElement Object ( ) [CXInfo] => SimpleXMLElement Object ( ) [CardMoneyTypeId] => MEMV1 [CardNo] => 00051625 [CardTypeID] => 100 [CardTypeIsMoney] => 1 [CardTypeName] => 网站会员 [Commission_type_id] => SimpleXMLElement Object ( ) [CompanyID] => SimpleXMLElement Object ( ) [DanBaoHour] => 0 [DistinctWeek] => SimpleXMLElement Object ( ) [FenCardPercent] => 2 [FenMoneyPay] => 0 [FenPayNeed] => 0 [FirstNightFee] => 190 [FirstNightListFee] => 200.00 [FullFee] => 200.00 [GuaType] => SimpleXMLElement Object ( ) [Guest_market_id] => SimpleXMLElement Object ( ) [HVNo] => SimpleXMLElement Object ( ) [HVType] => SimpleXMLElement Object ( ) [HasDoOrder] => true [HolidayPay] => false [HotelName] => 布丁酒店杭州武林西湖文化广场地铁站店 [InDate] => 2016-01-10T00:00:00 [InDate2] => 2016-01-11T00:00:00 [InName] => hong [IsAddComm] => SimpleXMLElement Object ( ) [IsAddCommHotel] => SimpleXMLElement Object ( ) [IsFenPay] => SimpleXMLElement Object ( ) [IsGw] => 0 [IsSelect] => SimpleXMLElement Object ( ) [IsSellGoods] => 1 [LinkEmail] => 645030813@qq.com [LinkMobile] => 13580506405 [LoginWay] => SimpleXMLElement Object ( ) [MustPayTip] => SimpleXMLElement Object ( ) [NC_CODE] => 04001019 [NoFL] => 1 [NotCount] => 0 [NotSendSms] => false [NotUseVoucher] => false [NotWx] => false [Note] => SimpleXMLElement Object ( ) [O_F2] => 0 [O_FUN] => 0 [OrderDate] => 2016-01-06T15:52:01.3193741+08:00 [OrderMustPay] => false [OtherInfo] => SimpleXMLElement Object ( ) [OtherSelfPriceDCode] => SimpleXMLElement Object ( ) [PD_OTHER_DATA3] => SimpleXMLElement Object ( ) [PMS_ERROR_CODE] => 0 [PayMode] => 0 [Phone] => SimpleXMLElement Object ( ) [PriceType] => 0 [RoomCount] => 1 [RoomType] => YXDCA [RoomTypeName] => 特价大床房A [Room_order_id] => O16010615520048701S [Rooms] => SimpleXMLElement Object ( ) [SMoney] => 0 [SelfPrice] => false [SelfPriceNo] => SimpleXMLElement Object ( ) [SelfPriceTypeID] => SimpleXMLElement Object ( ) [Sfzh] => SimpleXMLElement Object ( ) [TCode] => SimpleXMLElement Object ( ) [Times] => SimpleXMLElement Object ( ) [TotalFee] => 190 [TuanCode] => SimpleXMLElement Object ( ) [UseCash] => 0 [UseReVoucher] => false [UserCount] => 1 [VoucherDesc] => SimpleXMLElement Object ( ) [VoucherMoney] => 0 [VoucherNo] => SimpleXMLElement Object ( ) [VoucherTypeID] => SimpleXMLElement Object ( ) [WXOpenID] => SimpleXMLElement Object ( ) [Weeks] => SimpleXMLElement Object ( [HotelBookModel.WeekInfo] => SimpleXMLElement Object ( [Date] => 2016-01-10T00:00:00 [FullPrice] => 200.00 [Price] => 190 [Week] => 0 [WeekOfYear] => 3 [status] => 2 ) ) [_PayStatus] => SimpleXMLElement Object ( ) [cardId] => 30083753 [flmID] => SimpleXMLElement Object ( ) [from] => -1 [from2] => SimpleXMLElement Object ( ) [id] => zj1 [isYH] => 0 [remark] => SimpleXMLElement Object ( ) [setMustPayTip2] => SimpleXMLElement Object ( ) ) ) ) )
	
	//115、 设置新的支付方式，并返回应付金额（必需已经初始订单实例）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"payWay"=>"0",
//		"orderNo" => "O16010615520048701S"
//	);
//	$client->call ( 'SetPayMode',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [SetPayModeResult] => OK190 ) //OK后为应金额
	
	//117、 获得卡我的所有卡信息
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'LoadCards',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [LoadCardsResult] => SimpleXMLElement Object ( [ArrayOfCardsFull] => SimpleXMLElement Object ( [CardsFull] => SimpleXMLElement Object ( [CARD_FEN_PENCENT] => 2 [CARD_PIC_PATH] => http://pod100.com/uf/UploadFiles/20151020/96e55583a3684d76b5b12a5ac8e487fc.png [CardDesc] => 1、享95折优惠（一卡一房） 2、本人入住享1:1倍房费积分（积分有效期1年） 3、退房时间12:00点 [CardID] => 30083753 [CardPriceCode] => MEMV1 [CardPriceName] => 网站会员-95折 [CardTypeID] => 100 [CardTypeName] => 网站会员 [IsMoneyCard] => 1 [MC_NO] => 00051625 ) ) ) )
	
	//118、 获得卡我的所有卡信息,带积分与余额
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"dataType" => "xml"
//	);
//	$client->call ( 'LoadCardsWithFenAndMoney',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [LoadCardsWithFenAndMoneyResult] => SimpleXMLElement Object ( [ArrayOfCardWithP_M] => SimpleXMLElement Object ( [CardWithP_M] => SimpleXMLElement Object ( [CardDesc] => 1、享95折优惠（一卡一房） 2、本人入住享1:1倍房费积分（积分有效期1年） 3、退房时间12:00点 [CardId] => 30083753 [CardPriceCode] => MEMV1 [CardPriceName] => 网站会员-95折 [CardTypeID] => 100 [CardTypeName] => 网站会员 [Cash] => 0 [Fen] => 0 [IsMoneyCard] => 1 [MC_NO] => 00051625 [Money] => 0 [PriceShort] => 95折 ) ) ) )
	
	//119、 获得单张卡的积分与余额
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"cardType" => "100",
	// 	"cardNo" => "00051625"
	// );
	// $client->call ( 'LoadCardFenAndMoney',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));	
	//Array ( [LoadCardFenAndMoneyResult] => 0|0.00 )
	
	//120、 获得单张卡的积分与金额
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"cardNo" => "00051625",
//		"CardType"=>"100"
//	);
//	$client->call ( 'LoadsCardFenAndMOney',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [LoadsCardFenAndMOneyResult] => 0|0.00 )  积分|金额
	
	//121、 获得当前定单应付金额(订单总价)
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'getOrderFackPayMoney',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [getOrderFackPayMoneyResult] => 190 )
	
	//122、 获得当前定单,现在需付金额（存在首晚，只付第一晚金额）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'getOrderFFPayMoney',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [getOrderFFPayMoneyResult] => 190 )
	
	//123、 存储卡支付
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"password"=>"123123"
//	);
//	$client->call ( 'LePay',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [LePayResult] => EX_无权限调用此接口 )
	
	//124、 修改密码 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"oldPass"=>"123123123",
//		"newPass"=>"123123123",
//		"newPass2"=>"123123123"
//	);
//	$client->call ( 'ChangePassword',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [ChangePasswordResult] => EX_无权限调用此接口 )
	
	//125、 获得历史用户历史积分,未登录返回，“未登录”
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'LoadFenHistory',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));	
	//Array ( [LoadFenHistoryResult] => SimpleXMLElement Object ( [ArrayOfCardScoreLog] => SimpleXMLElement Object ( ) ) )
	
	//126、 我常用联系人
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"pageIndex"=>"1",
//		"pageSize"=>"3",
//		"dataType"=>"xml"
//	);
//	$client->call ( 'MyCommonUserList',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));		
	//Array ( [MyCommonUserListResult] => SimpleXMLElement Object ( [PageDataOfHotelBookModel.CommonUser47PfhAw0] => SimpleXMLElement Object ( [Count] => 0 [Datas] => SimpleXMLElement Object ( ) ) ) )
	
	//127、 合并积分
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"card"=>"00051625_100"
//	);
//	$client->call ( 'UnionFen',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [UnionFenResult] => OK )
	
	//128、 上传用户头像
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"base64Img"=>"http://pod100.com/uf/UploadFiles/20150626/72f74e0fdba746b4987b5f67e794a1a0.jpg"
//	);
//	$client->call ( 'UploadMobileImg',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
//	Array ( [UploadMobileImgResult] => EX_输入的不是有效的 Base-64 字符串，因为它包含非 Base-64 字符、两个以上的填充字符，或者填充字符间包含非法字符。 )
	
	//129、 获手机用户头像·
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// );
	// $client->call ( 'BetMobileImg',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [BetMobileImgResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//130、 酒店路书
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"hotelNo"=>"zj1",
//		"dataType"=>"xml"
//	);
//	$client->call ( 'HotelLuShu',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [HotelLuShuResult] => SimpleXMLElement Object ( [publicName2Model] => SimpleXMLElement Object ( [N] => 汽车北站：67路公交车至朝晖三区下 地铁1号线：至西湖文化广场站下A出口，前方河东路步行5分钟，左边中国农业银行口进即可！ 汽车南站：44路公交车至朝晖三区下 汽车西站：179路公交车至市交警支队下，往回走，十字路左至朝晖三区即到 城站火车站：香榭大厦做30路至朝晖三区下 九堡客运中心：101路公交车至潮王路口转316至朝晖三区 萧山国际机场：机场大巴至武林小广场下转316路至朝晖三区 萧山火车南站：301路至武林小广场转316至朝晖三区 [N2] => 从上海出发：市区→G92 → G60→S2→朝杭州/德胜路方向，稍向右转，进入杭州市区。 从苏州出发：市区→G15W→嘉兴枢纽→G60→S2→朝杭州/德胜路方向，稍向右转，进入杭州市区。 从南京出发：市区→G25→上塘高架→从登云路出口离开，进入杭州市区。 ) ) )
	
	//131、 删除常用联系人
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"id"=>""
//	);
//	$client->call ( 'MyCommonUserDelete',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [MyCommonUserDeleteResult] => OK )
	
	//132、 更新常联系人，请对数据格式做效验
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"id"=>"00001",
//		"userName"=>"wu",
//		"mobile"=>"13502556584",
//		"email"=>"",
//		"sfz"=>"520520520520520",
//	);
//	$client->call ( 'MyCommonUserEdit',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [MyCommonUserEditResult] => OK )
	
	//133、 判断会员卡是否可升级
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"cardNo"=>"00051625",
//		"cardType"=>"100",
//		"dataType"=>"xml"
//	);
//	$client->call ( 'CardUpdateJudge',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [CardUpdateJudgeResult] => EX_无权限调用此接口 )
	
	//134、 使用积分进行卡升级
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"cardNo"=>"00051625",
//		"cardType"=>"100"
//	);
//	$client->call ( 'CardUpdateByFen',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [CardUpdateByFenResult] => EX_无权限调用此接口 )
	
	//135、 获得存值卡历史（最新20）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"dataType"=>"xml"
//	);
//	$client->call ( 'MyDepositHistory',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [MyDepositHistoryResult] => 0.00| ) 	正常返回:余额|积分历史数据
	
	//136、 获得积分历史
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"dataType"=>"xml",
//		"startDate"=>"2015-01-01",
//		"endDate"=>"2016-01-01"
//	);
//	$client->call ( 'MyFenHistory',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [MyFenHistoryResult] => 0| )
	
	//137、 获得我的勋章
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"dataType"=>"xml"
	// );
	// $client->call ( 'MyMedal',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [MyMedalResult] => SimpleXMLElement Object ( [ArrayOfMyMedalResult] => SimpleXMLElement Object ( [MyMedalResult] => Array ( [0] => SimpleXMLElement Object ( [SM_DESC] => 入住过12次以及以上的住友酒店旗下门店 [SM_NO] => 001 [SM_PIC_PATH] => http://pod100.com/uf/UploadFiles/20150609/7e8a88df96614913b9af1288de855d13.png [SM_PIC_PATH2] => http://pod100.com/uf/UploadFiles/20150609/be51f4bbec5c478cb7530276f4f8fbcc.png [SM_TITLE] => 布折不扣 [HasGet] => false ) [1] => SimpleXMLElement Object ( [SM_DESC] => 入住过3个以及以上城市的住友酒店旗下门店 [SM_NO] => 002 [SM_PIC_PATH] => http://pod100.com/uf/UploadFiles/20150609/0fe1ce1848ae405b805ae8b5d1da37b9.png [SM_PIC_PATH2] => http://pod100.com/uf/UploadFiles/20150609/a7eed323fba64290b7bc1658196d2164.png [SM_TITLE] => 独步天下 [HasGet] => false ) [2] => SimpleXMLElement Object ( [SM_DESC] => 总消费金额5000元以上 [SM_NO] => 003 [SM_PIC_PATH] => http://pod100.com/uf/UploadFiles/20150609/f00937c0964a4d8088036760a2c178cc.png [SM_PIC_PATH2] => http://pod100.com/uf/UploadFiles/20150609/4b4765014c5749c3a67359f01e5804c6.png [SM_TITLE] => 任性豪客 [HasGet] => false ) [3] => SimpleXMLElement Object ( [SM_DESC] => APP预订入住10间夜以及以上 [SM_NO] => 004 [SM_PIC_PATH] => http://pod100.com/uf/UploadFiles/20150609/cd569898ba5544d1a4b5726abee63845.png [SM_PIC_PATH2] => http://pod100.com/uf/UploadFiles/20150609/a27d0aec5a6f494c862c65c5d2490d96.png [SM_TITLE] => 移动圣手 [HasGet] => false ) [4] => SimpleXMLElement Object ( [SM_DESC] => 官网预订入住10间夜以及以上 [SM_NO] => 005 [SM_PIC_PATH] => http://pod100.com/uf/UploadFiles/20150609/1ce6c8d9986c4fb5aa3f9bd47eb8293a.png [SM_PIC_PATH2] => http://pod100.com/uf/UploadFiles/20150609/d27a70561a5b4debbccb12832042f6bf.png [SM_TITLE] => 官网大师 [HasGet] => false ) [5] => SimpleXMLElement Object ( [SM_DESC] => 入住过住友旗下不同品牌酒店2个以及以上 [SM_NO] => 006 [SM_PIC_PATH] => http://pod100.com/uf/UploadFiles/20150609/76cadc9dd00c454fb783158c4e4aac00.png [SM_PIC_PATH2] => http://pod100.com/uf/UploadFiles/20150609/7ad90e89f5e74b80975882a7ed013955.png [SM_TITLE] => 尽收眼底 [HasGet] => false ) ) ) ) )
	
	//138、 增加勋章
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"SM_NO"=>"2222222"
//	);
//	$client->call ( 'MyMedalInsert',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [MyMedalInsertResult] => OK )
	
	//139、 是否有新消息
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'hasNewMessage',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [hasNewMessageResult] => 0 )
	
	//140、 获得登录会员编号
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'MG_MemId',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [MG_MemIdResult] => EX_无权限调用此接口 )
	
	//141、 获得友情链接(不需要授权)
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"type"=>"31",
//		"dataType"=>"xml"
//	);
//	$client->call ( 'MG_Link',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [MG_LinkResult] => SimpleXMLElement Object ( [ArrayOfLinks] => SimpleXMLElement Object ( [Links] => SimpleXMLElement Object ( [GL_TITLE] => 布丁官网 [GL_TYPE] => 31 [GL_URL] => http://www.podinns.com ) ) ) )
	
	//142、 获得漫果地标(不需要授权)
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"city"=>"2",
//		"dataType"=>"xml"
//	);
//	$client->call ( 'MG_Area',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [MG_AreaResult] => SimpleXMLElement Object ( [ArrayOfMGArea] => SimpleXMLElement Object ( [MGArea] => Array ( [0] => SimpleXMLElement Object ( [AreaID] => 107 [AreaName] => 吴山广场 [CityID] => 2 ) [1] => SimpleXMLElement Object ( [AreaID] => 7 [AreaName] => 西湖文化广场 [CityID] => 2 ) [2] => SimpleXMLElement Object ( [AreaID] => 333 [AreaName] => 火车东站 [CityID] => 2 ) [3] => SimpleXMLElement Object ( [AreaID] => 208 [AreaName] => 和平国际会展中心 [CityID] => 2 ) [4] => SimpleXMLElement Object ( [AreaID] => 499 [AreaName] => 河坊街 [CityID] => 2 ) ) ) ) )
	
	//143、 定制内容查询(不需要授权)
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"type"=>"2",
//		"count"=>"0",
//		"smallType"=>"0",
//		"dataType"=>"xml"
//	);
//	$client->call ( 'MG_CustomLink',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
/*
Array ( [MG_CustomLinkResult] => SimpleXMLElement Object ( [ArrayOfCustomLink] => SimpleXMLElement Object ( [CustomLink] => Array ( [0] => SimpleXMLElement Object ( [CL_DESC] => 官网专享抢购房，最低价保障，69元起！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140301/7992a4b6c70b4b7aa6867f04a81a2d6b.jpg [CL_IS_HOT] => 1 [CL_IS_NEW] => 0 [CL_TITLE] => 官网专享抢购房69元起 [CL_URL] => http://www.podinns.com/hotel/hotelzxf ) [1] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店会员免费领取快的国庆红包，最高10元等你抢！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20141001/53ee8c10c5fe4ed0bbbd5be60ee5b55b.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 快的国庆红包免费领 [CL_URL] => http://c2.kuaidadi.com/taxi/web/p/random_index.htm?activityUid=3b1a819bb1dda2d2e01a73725e7e05bd ) [2] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店会员领取暗号，机票免房拍立得等你来抢！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140918/f7e943a4c5954adeb90e244ab37b1a4d.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 芒果布丁，送机票免房啦 [CL_URL] => http://www.podinns.com/Activity/a/BD20141001.html ) [3] => SimpleXMLElement Object ( [CL_DESC] => 活动期间，精致布丁卡、乐卡、橙卡及Z卡会员通过官网/APP预订即可享受门市价8折，且入住成功后，即可获赠7折特权券一张 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150522/74452ee56ca149059d6af4240668b497.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 储值卡会员专享8折 [CL_URL] => http://www.podinns.com/Activity/a/dfj2015.html ) [4] => SimpleXMLElement Object ( [CL_DESC] => 亿卡会员及以上享受新店7折 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150416/d8da2764b40143b585eeb010185beed8.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 新店7折 [CL_URL] => http://www.podinns.com/Activity/a/20157z.html ) [5] => SimpleXMLElement Object ( [CL_DESC] => 裸价风暴来了 周日-周四所有房型一降到底 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20141114/c3ed00f2d3804238b373daa0c811b391.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 7周年庆 裸价风暴来了 [CL_URL] => http://www.podinns.com/Hotel/Hotelfb ) [6] => SimpleXMLElement Object ( [CL_DESC] => 会员预订，折后最高再减60元 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150813/a3d6b30cdd1340319276dc4456ed73c3.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 低到你尖叫 [CL_URL] => http://www.podinns.com/activity/c/201509ddnjj-wap.html ) [7] => SimpleXMLElement Object ( [CL_DESC] => 首次入住活动仅限从未有过入住记录的客人 首次入住仅限一间夜 此活动必须会员本人入住 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150320/91ea95cb2dce41f7a623da6eb1ff6a5a.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 首次入住专享特惠 [CL_URL] => http://www.podinns.com/activity/a/2015f69.html ) [8] => SimpleXMLElement Object ( [CL_DESC] => 招新火热大抢购，69元起住五星时尚大床房！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140423/6ac35d2293da4267b1d2ef6cac9915f9.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 69元起住五星时尚大床房 [CL_URL] => http://www.podinns.com/ft69 ) [9] => SimpleXMLElement Object ( [CL_DESC] => 下载布丁酒店APP，领取安佳进口牛奶一盒 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150918/03518867fca242fca93014649a48b94c.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 晚安牛奶，“布”见不散 [CL_URL] => http://www.podinns.com/Activity/c/201510niunai.html ) [10] => SimpleXMLElement Object ( [CL_DESC] => 百元红包&亿卡免费拿 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150902/5e28be678b9a4b5d8ac26e083dbc2b8a.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 你开学 我房价 [CL_URL] => http://www.podinns.com/Activity/a/201509school.html ) [11] => SimpleXMLElement Object ( [CL_DESC] => 每晚可获返现金10元，推荐朋友入住每单可获返现5元，返现金可提现到支付宝，也可支付房费。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20141005/665a339b5cec446cb066b9001903720f.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 1 [CL_TITLE] => 官网预订返现大升级 [CL_URL] => http://www.podinns.com/Activity/a/2014_fxhd.html ) [12] => SimpleXMLElement Object ( [CL_DESC] => 69元起住五星时尚大床房，仅限新会员APP预订 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131107/10df8cd5b6dc46e982cec3c3cde7cbb4.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 69元起住五星时尚大床房 [CL_URL] => http://touch.podinns.com/f69 ) [13] => SimpleXMLElement Object ( [CL_DESC] => 乐卡以及以上级别会员折后再减5-10元 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140301/ebfafb70b2e24f3c87a5011a211602bc.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 越早定越便宜！最低5折起 [CL_URL] => http://www.podinns.com/Hotel/HotelFirstLessMoney ) [14] => SimpleXMLElement Object ( [CL_DESC] => 省去中介租房佣金，入住酒店式公寓 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140822/061a2a9170814f238fc38840f298b746.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 1 [CL_TITLE] => 长包房月租1600元起 [CL_URL] => http://www.podinns.com/booklong ) [15] => SimpleXMLElement Object ( [CL_DESC] => 299积分可兑换一张10元优惠券 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150821/ddf022540da047668ba1e9094a14b534.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 积分超值兑换 [CL_URL] => http://www.podinns.com/YLMember/FenAwardDetail/849.html ) [16] => SimpleXMLElement Object ( [CL_DESC] => APP专享抢购房，全网最低价，首晚最减10元！先抢先得，房源有限，抢完即止！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131024/46092c7c24c94d419449b5c1c0de82d8.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => APP专享抢购房，首晚最减10元 [CL_URL] => http://www.podinns.com/Activity/c/gwzxqgf.html ) [17] => SimpleXMLElement Object ( [CL_DESC] => 通过官方APP成功预订布丁酒店并入住即可在入住酒店前台领取布丁酒店专享5元乐视充值点卡一张 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131018/5e79663261734e9abc6f120254936064.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 官方APP预订酒店，乐视大片免费看 [CL_URL] => http://www.podinns.com/Activity/c/2013APPletv_wap.html ) [18] => SimpleXMLElement Object ( [CL_DESC] => 3000积分起换免房，最高获取3.5倍积分 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150720/165bbf58f3a644659ed0226580f36e2b.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 3000积分起换免房 [CL_URL] => http://www.podinns.com/activity/a/3000mf.html ) [19] => SimpleXMLElement Object ( [CL_DESC] => 住布丁集勋章，做任务赢大奖！ 免房、nano、ipad、macbook等你来拿！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20120302/1bb1e23ed8bf45c482916efcec856a63.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 低碳护照 重新来袭 [CL_URL] => http://www.podinns.com/Activity/a/2012dthz.html ) [20] => SimpleXMLElement Object ( [CL_DESC] => 畅游积分大乐透,7种玩法随心享 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20120507/d5568524bcb1417fb03320750ef667f9.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 畅游积分大乐透,7种玩法随心享 [CL_URL] => http://www.podinns.com/Activity/a/jifen.html ) [21] => SimpleXMLElement Object ( [CL_DESC] => 越早定越便宜！提前10天6折,提前7天6.5折,提前3天7折,提前1天8折！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20130222/8534c889d31240a7ae22804c0011e693.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 越早定越便宜！最低只要99元！ [CL_URL] => http://touch.podinns.com/HotelSearchFirstLessMoney ) [22] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店会员免费领取信和大金融理财产品代金券 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140915/bada949f59a44483b817161e5f395dc7.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 信和大金融代金券免费领 [CL_URL] => http://www.podinns.com/activity/pubget/ecpXinHe99 ) [23] => SimpleXMLElement Object ( [CL_DESC] => 凭布丁酒店特享优惠码，即可享受京东到家购物7.7折优惠。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150819/438376e877274c7cb73bc2ee97191b46.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 七夕“啪”出新高度？京东到房要啥有啥 [CL_URL] => http://www.podinns.com/activity/a/bdjdqx20158.html ) [24] => SimpleXMLElement Object ( [CL_DESC] => 人类已经无法阻挡平板制成爆红的脚步了！2014年6月4日起前往布丁酒店连锁各门店均可报名参加，每周三公布周赛成绩，每月最后一个周三公布月赛成绩。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140604/ad2f39be8a9b46088c572c5373539960.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 平板世界杯，等你来挑战 [CL_URL] => http://touch.podinns.com/MobileA/Plank ) [25] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店会员领暗号，化妆品免房等你抢 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20141008/69db015dcd074e539767b79111c0bcd9.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 小也布丁送化妆品免房 [CL_URL] => http://www.podinns.com/Activity/a/2014xybd.html ) [26] => SimpleXMLElement Object ( [CL_DESC] => 越早定越便宜！提前1天8折,提前3天75折,提前10天7折,提前30天6折,提前60天5折！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140401/bd3b539d77cd4d4a9615be78a3487bb0.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 越早定越便宜！最低5折起 [CL_URL] => http://touch.podinns.com/HotelSearchFirstLessMoney ) [27] => SimpleXMLElement Object ( [CL_DESC] => 近日，布丁酒店宣布正式上线小米电视预订，成为首家进驻小米电视的酒店。用户可以通过小米电视直接进行酒店查询、预订、订单管理等操作。据悉，用户所有操作信息与布丁酒店官网后台直连，保证了准确、快速、高效。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140313/f91ff9a0f15f498abf6d533b330bf5fd.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 小米电视也能订酒店：布丁酒店首家进驻 [CL_URL] => http://www.podinns.com/Home/wxDetail/2847.html ) [28] => SimpleXMLElement Object ( [CL_DESC] => 情人节“撕”袜大作战 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140313/f854141cc6f54412bbb15cce0b5081c0.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => “撕”袜大作战 [CL_URL] => http://www.podinns.com/Home/wxDetail/2801.html ) [29] => SimpleXMLElement Object ( [CL_DESC] => 11月29日，布丁酒店支付宝钱包公众服务正式上线，成为首家上线公众服务的酒店。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131210/ad2f1b09730f45518c93dfa9c6b7b978.jpg [CL_IS_HOT] => 1 [CL_IS_NEW] => 1 [CL_TITLE] => 布丁酒店支付宝合作重装升级 公众服务正式上线 [CL_URL] => http://www.podinns.com/Home/wxDetail/2302.html ) [30] => SimpleXMLElement Object ( [CL_DESC] => 又一天过去了。今天过得怎么样，梦想是不是更远了？ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131219/2a156abbea494a45ac8bbbc456cd03a9.jpeg [CL_IS_HOT] => 1 [CL_IS_NEW] => 1 [CL_TITLE] => 这样密集的负能量段子,看起来实在是太爽了! [CL_URL] => http://www.podinns.com/Home/wxDetail/2321.html ) [31] => SimpleXMLElement Object ( [CL_DESC] => 一个人想要成功，不依靠任何外力，一步一步脚踏实地确实也能够成功，但是难免会走一些弯路，遇到一些挫折，或者说要多付出好几倍的力量。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131227/1d14960e4145419eb792a1452b86a118.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 测你在2014年能否得贵人相助 [CL_URL] => http://www.podinns.com/Home/wxDetail/2365.html ) [32] => SimpleXMLElement Object ( [CL_DESC] => 浙江有很多酒店旅舍，就像浙江的人儿一样，有着特殊的腔调，找个和你一样爱生活、有创意的酒店才是王道 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131229/af1cbd96be0e48c68fff10d7857b20a5.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 开房也要有腔调 [CL_URL] => http://www.podinns.com/Home/wxDetail/2367.html ) [33] => SimpleXMLElement Object ( [CL_DESC] => “一千个人眼里有一千个哈姆雷特”，同样，一千个人心里也有一千种对时尚的认知，快时尚开始在很多领域渗透。赶在时间前面，在潮流刚刚涌来时，以最快的速度用产品表达快时尚理念；同时，以足够好的品质来展现品牌的信誉度，这就是快时尚的力量，也是一个品牌实力的象征。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131125/3d5c9cd353304b2aa3a309b8baf664dd.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 1 [CL_TITLE] => 布丁“快时尚” [CL_URL] => http://www.podinns.com/Home/wxDetail/2141.html ) [34] => SimpleXMLElement Object ( [CL_DESC] => 69是什么？看看布丁怎么玩69吧~ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131125/557c22c4a720439d93ad400c958d6696.png [CL_IS_HOT] => 1 [CL_IS_NEW] => 1 [CL_TITLE] => 布丁69总攻略 [CL_URL] => http://www.podinns.com/Home/wxDetail/2282.html ) [35] => SimpleXMLElement Object ( [CL_DESC] => 每个人心中都有一个丽江，高大的玉龙雪山，美丽的沪沽湖，壮观的虎跳峡，宁静的束河古镇，神秘的摩梭族人。总有一个理由可以让你爱上这个地方。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131125/1ec6dafbf9e64f53bd021050ddc3f43c.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 1 [CL_TITLE] => 每个人心中都有一个关于丽江的梦想 [CL_URL] => http://www.podinns.com/Home/wxDetail/2283.html ) [36] => SimpleXMLElement Object ( [CL_DESC] => 亲爱的爸爸妈妈：在感恩节之际，静静的为我们的父母表达感谢！无论身在何处，心中那份牵挂永远荡在心中。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131128/68d5d07c4c1b4120b2d9646e74cdbae6.jpeg [CL_IS_HOT] => 1 [CL_IS_NEW] => 1 [CL_TITLE] => 感恩节，送父母什么好？ [CL_URL] => http://www.podinns.com/Home/wxDetail/2287.html ) [37] => SimpleXMLElement Object ( [CL_DESC] => 你知道自己适合去欧洲哪些国家旅行吗？快来看看吧~ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131129/c4c921074f1142d8bbf99537e8bb9d3d.jpg [CL_IS_HOT] => 1 [CL_IS_NEW] => 1 [CL_TITLE] => 性格和喜好决定您适合欧洲哪些国家 [CL_URL] => http://www.podinns.com/Home/wxDetail/2289.html ) [38] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店会员免费参赛，免房车模免费领取 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140917/668b74119d6b46338dfe8be21891a9c0.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 免费玩比赛，车模免房等你拿 [CL_URL] => http://reg.669.com/bdhotel/Default2.aspx ) [39] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店会员免费领取AA用车88元代金券 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140807/21b3339c93154cdf91993ea9190dc568.JPG [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 住布丁，豪车接送 [CL_URL] => http://www.podinns.com/activity/pubget/ecpaa ) [40] => SimpleXMLElement Object ( [CL_DESC] => 用布丁酒店app下单并入住成功，每天50张电影票免费送 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140722/b99dbaca8f414a1d9bd4196659ef3654.JPG [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => APP订房并入住送免费电影票 [CL_URL] => http://www.podinns.com/Activity/a/2014_bfmn.html ) [41] => SimpleXMLElement Object ( [CL_DESC] => 官网预订布丁酒店浙江、江苏门店，将有机会获得驴妈妈提供的免费游乐园门票 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140623/5b8455bf6fd5418680bd89739d03f821.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 布丁带你嗨翻天 [CL_URL] => http://www.podinns.com/Activity/a/2014_bylxj.html ) [42] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店用户免费领取网易火车票提供的5元红包 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140625/6f3aa26e9a434cc0bc5402921618a398.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 暑期出行红包大派送 [CL_URL] => http://www.podinns.com/activity/pubget/Bhc2014 ) [43] => SimpleXMLElement Object ( [CL_DESC] => 免费参与世界杯竞猜，纯金大力神杯，智能手机，免房等你拿 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140613/9e79bec673f44217a512dfc390f9ef95.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 人人有奖，竞猜世界杯 [CL_URL] => http://yuedu.163.com/worldcup.do?operation=league&utm_source=buding&utm_medium=wp ) [44] => SimpleXMLElement Object ( [CL_DESC] => 凭民生银行信用卡在线免费申领价值28元亿卡，享受全连锁房价92折 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140617/9bbdb6b2672847e5b1a503ef8df5bacf.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 凭民生银行信用卡在线免费申领价值28元亿卡 [CL_URL] => http://www.podinns.com/account/buycardcd/cmbc ) [45] => SimpleXMLElement Object ( [CL_DESC] => 凭平安银行信用卡在线免费申领价值28元亿卡，享受全连锁房价92折 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140617/a67e8510ae56403484c211dc1f098aa1.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 凭平安银行信用卡在线免费申领价值28元亿卡 [CL_URL] => http://www.podinns.com/account/buycardcd/pingan ) [46] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店会员免费参赛，话费卡免房券一网打尽 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140423/ffb7a0dbba6d48ed80c698c2cd2a57ea.JPG [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => “布丁酒店”捕鱼大奖赛，赢话费免房 [CL_URL] => http://ad.lkgame.com/event_ad_218.html ) [47] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店会员新特权，3-5元彩票免费领。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140415/8b0be9b8280a4ee5aa0f7a4892668507.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 布丁酒店用户彩票免费领 [CL_URL] => http://www.podinns.com/activity/pubget/BX2014 ) [48] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店用户专享特权 玩《魂斗士》马上有惊喜 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140404/0fc8e192588943b0a7740944683f2b1d.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 布丁酒店用户玩游戏，中大奖！ [CL_URL] => http://hds.yunyoyo.cn/BDhotel/index.html ) [49] => SimpleXMLElement Object ( [CL_DESC] => 布丁用户享特权，免费参加“布丁酒店杯”斗地主金币赛， 更多大奖等你拿！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140328/aa95f13a1f49443b9cf7a87426fc79f3.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => “布丁酒店杯”斗地主锦标赛 [CL_URL] => http://oreg.jj.cn/gpbd/bdjd.html?siteid=4500994 ) [50] => SimpleXMLElement Object ( [CL_DESC] => 布丁用户享特权，玩热血三国，Ipad，游戏周边，免房券等你来拿！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140225/350358f262584fb5a12744fc7cf1ae46.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 玩热血三国，马上有惊喜 [CL_URL] => http://www.podinns.com/gamerxsg ) [51] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店会员新特权，限量红酒免费领，8折优惠特权专享！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140228/bcec0dd29d2146f58e3535a3409179fa.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 布丁用户享特权，限量红酒免费领 [CL_URL] => http://www.podinns.com/activity/pubget/g_melodieuxwine ) [52] => SimpleXMLElement Object ( [CL_DESC] => 春节免费送你回家过年，回家不能等！200元回家券免费送 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140124/9a904c19967e405eb623537319157b06.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 回家不能等！200元回家券免费送 [CL_URL] => http://www.weibo.com/3428701164/AttXcq2Xx?mod=weibotime ) [53] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店会员新特权，3元彩金免费领，千元大奖等你拿，2014马上有钱 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140120/d0dd9f8a08974f2281f6a5806f52b7b0.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 布丁用户免费领取3元彩金， 2014马上中大奖 [CL_URL] => http://www.podinns.com/ecp888 ) [54] => SimpleXMLElement Object ( [CL_DESC] => 凭ISIC国际学生卡免费申领价值28元布丁酒店亿卡，享受房费92折，还可领取200元优惠券 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131223/1ca4450f079248589a3a76f09d9cf524.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 凭ISIC国际学生卡在线免费申领价值28元布丁酒店亿卡 [CL_URL] => http://www.podinns.com/Account/BuyCardCD/ISIC ) [55] => SimpleXMLElement Object ( [CL_DESC] => 凭浦发银行信用卡免费申领价值28元布丁酒店亿卡，享受房费92折折扣 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131220/867fe6a94750495bb64e167c0717d934.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 凭浦发银行信用卡在线免费申领价值28元布丁酒店亿卡 [CL_URL] => http://www.podinns.com/Account/BuyCardCD/spd ) [56] => SimpleXMLElement Object ( [CL_DESC] => 安装我查查购物助手送布丁超值优惠券 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131216/eb5b6456d78947c79fac644cc21f34ab.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 我查查购物助手送布丁优惠券 [CL_URL] => http://e.wochacha.com/buding.html ) [57] => SimpleXMLElement Object ( [CL_DESC] => 嘀嘀打车，免费手机叫车软件，拿起手机赶快下载吧！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131212/16298136b6604254ba1a44546b5fd4db.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 嘀嘀打车，免费手机叫车软件 [CL_URL] => http://www.xiaojukeji.com/website/download.html ) [58] => SimpleXMLElement Object ( [CL_DESC] => 参加JJ斗地主比赛，免房、话费抢不停！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131012/6eec5eb8228b42ab892307ecce6e4f1d.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 喜迎新春“布丁酒店杯”斗地主大奖赛 [CL_URL] => http://oreg.jj.cn/gpbd/bud.html?siteid=4500994 ) [59] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店用户携手老K游戏，玩捕鱼达人，音箱、免房券免费拿! [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131202/2b41493b3103440f941b778bc755e199.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 布丁用户大回馈，参赛免费得音响和免房券 [CL_URL] => http://ad.lkgame.com/event_ad_201.html ) [60] => SimpleXMLElement Object ( [CL_DESC] => 布丁酒店用户免费领取35张柯达照片 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131202/58c703c6382f45fc886d11d93f72a0f1.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 布丁用户免费领取35张柯达照片 [CL_URL] => http://www.wodexiangce.cn/service?type=7&inviter=fyh5r4 ) [61] => SimpleXMLElement Object ( [CL_DESC] => 网易云阅读，好礼大放送，下载就送500阅读红包，更有布丁豪华礼包等你拿！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131118/1580368e5bbf4d508cf0d50c5dd68abe.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 网易云阅读，下载就送500红包外加布丁豪华礼包！ [CL_URL] => http://yuedu.163.com/promotion/podinn/?act=rdpodinn_20131118_01 ) [62] => SimpleXMLElement Object ( [CL_DESC] => 凭中信银行信用卡免费申领价值28元布丁酒店亿卡，享受房费92折！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131113/7f2a3360983a46e890ecdb1920468328.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 凭中信银行信用卡在线免费申领价值28元布丁酒店亿卡 [CL_URL] => http://www.podinns.com/Account/BuyCardCD/Ecitica ) [63] => SimpleXMLElement Object ( [CL_DESC] => 万宁九周年，布丁大礼包免费送，更有机会获得布丁酒店免房券！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131112/03409476fc2746229599f44c849c0e90.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 万宁九周年，你住潮店我买单 [CL_URL] => http://weibo.com/1887206614/AhEkYyKAW ) [64] => SimpleXMLElement Object ( [CL_DESC] => 布丁会员专享，周杰伦周边等你拿，半价房券免费抢！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20131009/f43014d61d4f4050aef12e1fe9bb994c.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 布丁会员专享免费抢周杰伦明星周边 [CL_URL] => http://www.podinns.com/Activity/a/2013_dm_0.html ) [65] => SimpleXMLElement Object ( [CL_DESC] => 立即注册成为布丁会员免费丽江游，200元现金券、免费券、乐视高清包月卡、全部免费送！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20130822/31236c096e7343d78729716faf334cdf.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 抢免费丽江游、乐视包月卡 [CL_URL] => http://www.podinns.com/Account/BuyCardCD/2013letv ) [66] => SimpleXMLElement Object ( [CL_DESC] => 住布丁，有优惠！你打车，我补贴！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20130710/c8e858488d094bffa9d4a17fef60c024.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 住布丁，有优惠！你打车，我补贴！ [CL_URL] => http://www.podinns.com/Activity/a/yijiaoche.html ) [67] => SimpleXMLElement Object ( [CL_DESC] => 京津冀旅游一卡通用户,这次你赚到了！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20130618/44d9bc7268b9495e8003f4664cd60f60.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 京津冀旅游一卡通用户尊享布丁酒店3大特权 [CL_URL] => http://www.podinns.com/Account/BuyCardCD/2013jjj ) [68] => SimpleXMLElement Object ( [CL_DESC] => QQ会员尊享特权 1、房费92折：自动升级为亿卡，若您为布丁更高级别老会员，则默认绑定更高级别会员卡。 2、入住首晚5折：目前只针对新注册会员用户。 3、赠送给QQ会员的500元优惠券包括：15张20元，20张10元。 4、本特权为QQ会员用户独享，最终解释权归布丁酒店及QQ会员所有。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20130516/ee0175315f9b4d5ca679aa1d313cc34b.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => QQ会员尊享布丁酒店3大特权 [CL_URL] => http://vip.qq.com/clubact/2013/hotel/index.html ) [69] => SimpleXMLElement Object ( [CL_DESC] => #六一大孩子免费去旅行#六一，快给心里的那个小孩放个假吧！即日起，同时关注@布丁酒店 @周五旅游 ，转发本微博，即有机会获得杭州西溪国家湿地公园(非诚勿扰拍摄地)门票+船票1张。活动时间：5.25-5.29。想放假的童鞋转起~~~ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20120228/309cdea0cd574caba8d66b191c157098.jpg [CL_IS_HOT] => 1 [CL_IS_NEW] => 0 [CL_TITLE] => 六一，大孩子免费去旅行 [CL_URL] => http://e.weibo.com/1659851815/zyk9S9zRl ) [70] => SimpleXMLElement Object ( [CL_DESC] => 通过活动页面下载安装布丁酒店手机客户端并支付宝快捷登陆首次注册布丁酒店会员： 1、即可领取部分门店首晚5折特权券一张。 2、可获50个集分宝。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20130511/68fe938283bc409fa5447c95cc8b76c4.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 通过手机客户端预订入住，最高送4450个集分宝 [CL_URL] => https://jfb.alipay.com/activity/detail.htm?themeId=394 ) [71] => SimpleXMLElement Object ( [CL_DESC] => [#酒店控于布丁携手巨献#] 自2013年1月31日至3月31日通过【酒店控APP】预定并成功入住布丁酒店 （仅限上海地区）就有机会获得iPhone5，iPad mini。每周还抽取布丁乐卡会员卡一张。更有情人节活动等着你参与。详情参见上海各布丁门店海报。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20130511/c7f75efd5375462194587f203838de1d.png [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 预定即可获得iPhone5 [CL_URL] => http://www.bingdian.com/download_iphone.html ) [72] => SimpleXMLElement Object ( [CL_DESC] => 新会员注册，并点亮城市图标，即可有机会赢取布丁全国免房券和优惠券大礼包。 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20130511/f50bf1573fd74aa281ddac614b30f321.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 点亮城市图标，赢取百万豪礼 [CL_URL] => http://vip.tenpay.com/action/light/index.shtml ) [73] => SimpleXMLElement Object ( [CL_DESC] => 凭招商银行信用卡免费申领价值28元布丁酒店亿卡，享受房费门市价92折优惠 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20120228/6585403a01504dfcbdbae3d0b554ee86.jpg [CL_IS_HOT] => 1 [CL_IS_NEW] => 1 [CL_TITLE] => 凭招商银行信用卡在线免费申领价值28元布丁酒店亿卡 [CL_URL] => http://www.podinns.com/Account/BuyCardCD/cmbchina ) [74] => SimpleXMLElement Object ( [CL_DESC] => 凭光大银行信用卡在线免费申领价值28元布丁酒店亿卡，享受房费92折优惠 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20120306/b8fc56e91cf44c889ccc75ff675c8017.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 凭光大银行信用卡在线免费申领价值28元布丁酒店亿卡 [CL_URL] => http://www.podinns.com/Account/BuyCardCD/cebbank ) [75] => SimpleXMLElement Object ( [CL_DESC] => 维络城乐卡联名卡，可享受布丁酒店住店88折优惠，同时享受维络城各种优惠！限量，抢购中！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20120319/06750c18229b47f2afa28eb95ea0d094.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 维络城乐卡联名卡，限量发售中 [CL_URL] => http://www.podinns.com/Account/BuyCardVelo ) [76] => SimpleXMLElement Object ( [CL_DESC] => 搜狐闪电邮积分兑换布丁酒店亿卡，享受房费门市价92折优惠 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20120228/9a9c3a4aa86f48eea3cbfc5c28641e40.jpg [CL_IS_HOT] => 1 [CL_IS_NEW] => 1 [CL_TITLE] => 搜狐闪电邮积分兑换亿卡 [CL_URL] => http://www.podinns.com/Account/sohu ) [77] => SimpleXMLElement Object ( [CL_DESC] => 即刻加入国航知音，即可赠送800里程 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20120717/ce1cf6de92134d829bb53500b74ad79e.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 加入国航知音，送800里程 [CL_URL] => http://www.podinns.com/activity/a/airchina.html ) [78] => SimpleXMLElement Object ( [CL_DESC] => 情侣红钻 年终回馈 真爱有礼百分百 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20121212/a842f569f40b48b3b6138e1fa395dd0a.jpg [CL_IS_HOT] => 0 [CL_IS_NEW] => 0 [CL_TITLE] => 情侣红钻 年终回馈 真爱有礼百分百 [CL_URL] => http://show.qq.com/live/vipact/lovervip_truelove/index.html ) ) ) ) )
 */
	
	//144、 用户资料修改 
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"PM_NAME"=>"hong",
	// 	"PM_ID_NUM"=>"520520520520520",
	// 	"PM_IDNUM_TYPE"=>"11",
	// 	"PM_TEL"=>"13580506405",
	// 	"PM_ADDRESS"=>"11",
	// 	"PM_SEX"=>"1",
	// 	"PM_JOB"=>"1",
	// 	"PM_IN_MONEY"=>"11",
	// 	"PM_HOW_KNOW"=>"11"
	// );
	// $client->call ( 'MG_MemberUpdate',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [0] => )
	
	//145、 获得我的消息
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"pageSize"=>"3",
//		"pageIndex"=>"1"
//	);
//	$client->call ( 'MyMessage',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [MyMessageResult] => SimpleXMLElement Object ( [PageDataOfMessageModel.MyMessage47PfhAw0] => SimpleXMLElement Object ( [Count] => 0 [Datas] => SimpleXMLElement Object ( ) ) ) )
	
	//146、 直接返回信息详细
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"id"=>"1"
//	);
//	$client->call ( 'MyMessageDetail',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [MyMessageDetailResult] => SimpleXMLElement Object ( ) )
	
	//147、 查询天气与pm2.5 (有可能无数据注意容错)，返回json格式数据
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"cityId"=>"28"
	// );
	// $client->call ( 'Weather',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [WeatherResult] => null )
	
	//148、 获得广告图（无权限认证）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"adType"=>"1",
//		"dataType"=>"xml",
//		"city"=>"2"
//	);
//	$client->call ( 'GetMobileAd',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetMobileAdResult] => SimpleXMLElement Object ( [ArrayOfAd] => SimpleXMLElement Object ( [Ad] => Array ( [0] => SimpleXMLElement Object ( [SA_ALT] => 布丁酒店进军美国：好莱坞环球影城店开业 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [1] => SimpleXMLElement Object ( [SA_ALT] => 布丁酒店支付宝合作重装升级 公众服务正式上线 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [2] => SimpleXMLElement Object ( [SA_ALT] => 小米电视也能订酒店：布丁酒店首家进驻 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [3] => SimpleXMLElement Object ( [SA_ALT] => 【商业与公益】布丁酒店的《低碳护照》 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [4] => SimpleXMLElement Object ( [SA_ALT] => NETGEAR与布丁酒店连锁战略合作签约 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [5] => SimpleXMLElement Object ( [SA_ALT] => 布丁酒店成为首家手机支付宝合作酒店 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [6] => SimpleXMLElement Object ( [SA_ALT] => 微信，改变酒店营销模式 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [7] => SimpleXMLElement Object ( [SA_ALT] => 戴斌：布丁酒店，老百姓享受得起的品质 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [8] => SimpleXMLElement Object ( [SA_ALT] => USB插座——布丁酒店客房升级新武器 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [9] => SimpleXMLElement Object ( [SA_ALT] => 布丁酒店客房全面升级拉开序幕 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [10] => SimpleXMLElement Object ( [SA_ALT] => 恋上一张床 布丁酒店引入羽绒床垫 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [11] => SimpleXMLElement Object ( [SA_ALT] => 布丁酒店：超小经济酒店的“加减法则” [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [12] => SimpleXMLElement Object ( [SA_ALT] => 时尚——布丁style [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [13] => SimpleXMLElement Object ( [SA_ALT] => 布丁酒店首推360度全景展示功能 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [14] => SimpleXMLElement Object ( [SA_ALT] => “国考”进入倒计时 预订酒店需趁早 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [15] => SimpleXMLElement Object ( [SA_ALT] => 布丁酒店联手微信跨界合作 首推订房功能 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [16] => SimpleXMLElement Object ( [SA_ALT] => 乐视网发力主题季和节日营销 获时尚品牌支持 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [17] => SimpleXMLElement Object ( [SA_ALT] => 经济适用IT男的出差新选择 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [18] => SimpleXMLElement Object ( [SA_ALT] => 布丁旅游季，感恩丽江游 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [19] => SimpleXMLElement Object ( [SA_ALT] => 布丁酒店CEO朱晖：慢火炖出“快时尚” [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [20] => SimpleXMLElement Object ( [SA_ALT] => 布丁酒店：高低铺叠出快时尚 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [21] => SimpleXMLElement Object ( [SA_ALT] => “十一”临近 布丁成休闲旅游首选酒店品牌 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [22] => SimpleXMLElement Object ( [SA_ALT] => 特色酒店崛起 [SA_LINK] => /dnt/showtopic-7.aspx [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [23] => SimpleXMLElement Object ( [SA_ALT] => 布丁酒店的“快时尚”之道 [SA_LINK] => /dnt/showtopic-9.aspx [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [24] => SimpleXMLElement Object ( [SA_ALT] => 经济型酒店或助推旅游经济井喷式发展 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [25] => SimpleXMLElement Object ( [SA_ALT] => 去哪儿网携手HTC、布丁酒店首推无线NFC应用 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) [26] => SimpleXMLElement Object ( [SA_ALT] => 布丁酒店天天109会员房受市场热捧 [SA_LINK] => SimpleXMLElement Object ( ) [SA_PIC_PATH] => SimpleXMLElement Object ( ) ) ) ) ) )
	
	//149、 合作网站登录判断
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"way"=>"qq",
	// 	"user_id"=>"0101",
	// 	"userName"=>"hong"
	// );
	// $client->call ( 'OtherLoginJudge',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [OtherLoginJudgeResult] => NO )
	
	//150、 合作网站第一次注册
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"way"=>"qq",
//		"user_id"=>"0101",
//		"mobile"=>"13580506401",
//		"email"=>"645030811@qq.com"
//	);
//	$client->call ( 'OtherLoginReg',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [OtherLoginRegResult] => OK )
	
	//151、 支付宝登录
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"authCode"=>"111"	//授权码
//	);
//	$client->call ( 'AliPayLogin',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AliPayLoginResult] => EX_授权码code无效 )
	
	//152、 支付宝快登
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"alipayUser_id"=>"111",
	// 	"authCode"=>""
	// );
	// $client->call ( 'AliPayJoin',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [AliPayJoinResult] => EX_Invalid Arguments )

	//153、 获得AccessToken
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'AliPayAccessToken',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AliPayAccessTokenResult] => NO )
	
	//154、 合作网站第一次注册(带手机验证码) 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"way"=>"qq",
//		"user_id"=>"0101",
//		"mobile"=>"13580506401",
//		"email"=>"645030811@qq.com",
//		"mobileCode"=>"1111"
//	);
//	$client->call ( 'OtherLoginReg_2',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [OtherLoginReg_2Result] => NO )

	//155、 获得酒店点评
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"pageIndex"=>"1",
//		"pageSize"=>"3",
//		"HotelID"=>"zj1",
//		"isMy"=>""
//	);
//	$client->call ( 'GetHotelCommentList',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetHotelCommentListResult] => EX_无权限调用此接口 )
	
	//156、 获得帮助类别
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'GetHelpType',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetHelpTypeResult] => EX_无权限调用此接口 )

	//157、 根据关键字获得分享内容
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"key"=>"HotelDetail_cnzjhzbd02"
//	);
//	$client->call ( 'GetShareContent',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetShareContentResult] => 杭州布丁酒店吴山广场店为年轻白领,商务人士和个性化的人群提供时尚,简约的住宿客房,杭州布丁酒店吴山广场店联系地址:中国杭州市上城区高银街58号 )

	//158、 获得1970年的时间戳
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'GetServiceTime',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetServiceTimeResult] => 1452079597 )

	//159、 按城市获得城区与地标
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"city"=>"33"
//	);
//	$client->call ( 'GetRegion',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetRegionResult] => {"Area":[],"Region":[{"ID":238,"Name":"花溪区","C":0,"B":null},{"ID":239,"Name":"云岩区","C":0,"B":null}]} )

	//160、 获得帮助内容
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'GetHelps',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetHelpsResult] => EX_无权限调用此接口 )

	//161、 获得优惠促销内容	
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"pageIndex"=>"1",
//		"pageSize"=>"3",
//		"type"=>"1"
//	);
//	$client->call ( 'FavourableSearchList',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [FavourableSearchListResult] => SimpleXMLElement Object ( [PageDataOfHomeModel.Favourable47PfhAw0] => SimpleXMLElement Object ( [Count] => 8 [Datas] => SimpleXMLElement Object ( [HomeModel.Favourable] => Array ( [0] => SimpleXMLElement Object ( [CL_COUNT] => 532890 [CL_DATE] => 进行中 [CL_DESC] => 官网专享抢购房，最低价保障，69元起！ [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20140301/7992a4b6c70b4b7aa6867f04a81a2d6b.jpg [CL_ID] => 826 [CL_IS_NEW] => 0 [CL_TITLE] => 官网专享抢购房69元起 [CL_URL] => http://www.podinns.com/hotel/hotelzxf ) [1] => SimpleXMLElement Object ( [CL_COUNT] => 7920 [CL_DATE] => 2015.4.11-2015.12.31 [CL_DESC] => 亿卡会员及以上享受新店7折 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150416/d8da2764b40143b585eeb010185beed8.jpg [CL_ID] => 7012 [CL_IS_NEW] => 0 [CL_TITLE] => 新店7折 [CL_URL] => http://www.podinns.com/Activity/a/20157z.html ) [2] => SimpleXMLElement Object ( [CL_COUNT] => 193600 [CL_DATE] => 2015年3月5日至2015年12月31日 [CL_DESC] => 首次入住活动仅限从未有过入住记录的客人 首次入住仅限一间夜 此活动必须会员本人入住 [CL_FILE_PATH] => http://pod100.com/uf/UploadFiles/20150320/91ea95cb2dce41f7a623da6eb1ff6a5a.jpg [CL_ID] => 6971 [CL_IS_NEW] => 0 [CL_TITLE] => 首次入住专享特惠 [CL_URL] => http://www.podinns.com/activity/a/2015f69.html ) ) ) ) ) )

	//162、 最新定制文章类内容
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"pageIndex"=>"1",
//		"pageSize"=>"3",
//		"type"=>"1"
//	);
//	$client->call ( 'FavourableGet',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//内容太多，包括了二维码等。

	//163、 获得优惠促销内容详细
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"id"=>"1010"
//	);
//	$client->call ( 'FavourableDetail',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [FavourableDetailResult] => EX_无记录 )

	//164、 移动平台支付支付订单号生成
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"type"=>"LECHONG",
	// 	"xml"=>"a123"
	// );
	// $client->call ( 'GetAliPayOrder',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [GetAliPayOrderResult] => EX_根级别上的数据无效。 第 1 行，位置 1。 )
	
	//165、 获得支付宝标题
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"hotelNO"=>"zj1"
//	);
//	$client->call ( 'GetAliTitle',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [GetAliTitleResult] => 杭州武林西湖文化广场地铁站店_房费|04001019 )
	
	//166、 住友APP获得会员信息（字段不够迟点添加）
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"memId"=>"123",
	// 	"dataType"=>"xml"
	// );
	// $client->call ( 'AppGetMember',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	// Array ( [AppGetMemberResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//167、 住友APP首页信息
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"dataType"=>"xml"
//	);
//	$client->call ( 'AppGetHome',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AppGetHomeResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//168、 加载，某个用户关注或被关注的清单 
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"MF_ID"=>"1",
//		"type"=>"1",
//		"pageIndex"=>"1",
//		"pageSize"=>"3",
//		"dataType"=>"xml",
//	);
//	$client->call ( 'AppMemberGetMyFocusList',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AppMemberGetMyFocusListResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//169、 关注操作
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"MF_FOCUS_ID"=>"1",
	// 	"op"=>"1"//1为添加，-1为删除
	// );
	// $client->call ( 'AppMemberFocusDo',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [AppMemberFocusDoResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//170、 获得签到积分相关信息
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"dataType"=>"xml",
//	);
//	$client->call ( 'AppLoginFenInfo',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AppLoginFenInfoResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//171、 签到获得积分
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//	);
//	$client->call ( 'AppLoginFenGet',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AppLoginFenGetResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//172、 更新会员信息（昵称与签名）
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"SM_NICK"=>"123",
//		"SM_SIGN"=>"123"
//	);
//	$client->call ( 'AppUpdateMember',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AppUpdateMemberResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//173、 发布Sns
	// $client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
	// $client->soap_defencoding = 'UTF-8';
	// $client->setCookie("ASP.NET_SessionId", $session_key );
	// $client->setCookie(".ASPXAUTH", $user_id );
	// $client->decode_utf8 = false;  
	// $client->xml_encoding = 'UTF-8'; 
	// $data = array(
	// 	"SC_TITLE"=>"",
	// 	"SC_CONTENT"=>"",
	// 	"base64Img"=>"",
	// 	"base64Img2"=>"",
	// 	"base64Img3"=>"",
	// 	"SC_LOCATION"=>""
	// );
	// $client->call ( 'AppSnsCreate',$data);
	// $p = $client->document;
	// print_r((array)simplexml_load_string($p));
	//Array ( [AppSnsCreateResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//174、 搜索Sns
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"type"=>"0",
//		"pageIndex"=>"1",
//		"pageSize"=>"3",
//		"memId"=>"",
//		"location"=>"",
//		"dataType"=>"xml"
//	);
//	$client->call ( 'AppSnsSearch',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AppSnsSearchResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//175、 Sns点赞操作
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"SC_ID"=>"0",
//		"op"=>"1"
//	);
//	$client->call ( 'AppSnsSupport',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AppSnsSupportResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//176、 回复动态
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"SC_ID"=>"0",
//		"Replay"=>"回复"
//	);
//	$client->call ( 'AppSnsAddReplay',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AppSnsAddReplayResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//177、 获取回复详细
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"SC_ID"=>"0",
//		"pageIndex"=>"1",
//		"pageSize"=>"3",
//		"dataType"=>"xml",
//	);
//	$client->call ( 'AppSnsReplaySearch',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AppSnsReplaySearchResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//177、 获取回复详细
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"SC_ID"=>"0",
//		"pageIndex"=>"1",
//		"pageSize"=>"3",
//		"dataType"=>"xml",
//	);
//	$client->call ( 'AppSnsReplaySearch',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [AppSnsReplaySearchResult] => EX_无法打开登录所请求的数据库 "PodinnSnsTest"。登录失败。 用户 'podinn2015Test' 登录失败。 )
	
	//178、 获得会员卡的价格代码
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"cardType"=>"100"
//	);
//	$client->call ( 'ZZ_GetCardRate',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [0] => )
	
	//179、 定单使用优惠券，每定单只能使用一次
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"OrderNo"=>"O16010615520048701S",
//		"voucherKey"=>"VOUCHER_QQ_AUTO_SEND_10"
//	);
//	$client->call ( 'ZZ_OrderVoucher',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [0] => )
	
	//180、 自助设备接口
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
//	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"method"=>"ZZ_OrderVoucher",
//		"req"=>"1"
//	);
//	$client->call ( 'ZZ_Interface',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [0] => )
	
	//182、 解密函数（DES），此函数为各自开发语言实现，正式时不开放接口
//	$client = new soapclient('http://www.sandbox.podinns.com/wapservice.asmx?wsdl',true);
//	$client->soap_defencoding = 'UTF-8';
//	$client->setCookie("ASP.NET_SessionId", $session_key );
////	$client->setCookie(".ASPXAUTH", $user_id );
//	$client->decode_utf8 = false;  
//	$client->xml_encoding = 'UTF-8'; 
//	$data = array(
//		"str"=>"DGqAxKkrUjOk1i1kb8TFVA=="
//	);
//	$client->call ( 'Decode',$data);
//	$p = $client->document;
//	print_r((array)simplexml_load_string($p));
	//Array ( [DecodeResult] => test )
	