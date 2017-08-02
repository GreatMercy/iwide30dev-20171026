<?php
class Yunmeng extends CI_Controller {
	private $url = 'http://114.215.188.191:18080/HotelCRSREQ/app/hotelSelfService';
	private $zurl = 'http://218.244.135.198:18080/HotelCRSREQ_01/app/hotelSelfService';
	// private $zurl = 'http://218.244.135.198:18080/HotelCRSREQ/app/hotelSelfService';
	public function __construct() {
		parent::__construct ();
		$this->load->helper ( 'common_helper' );
	}
	
	/*
	 * register 会员注册
	 */
	public function register() {
		$url = $this->url . '?method=register&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"userName" => "hong",
				"passWord" => "12345678",
				"mobile" => "13580506405",
				"checkNum" => "短信验证码",
				"nickName" => "hong",
				"email" => "645030000@qq.com",
				"realName" => "夏夜",
				"idCard" => "445121199301252338",
				"cardTypeCode" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":{"id":"15121515191954910000","userName":"hong","idCard":"445121199301252338","chainCode":"","brandCode":"","hotelCode":"","email":"645030813@qq.com","mobile":"13502556584","nickName":"hong","realName":"吴作鸿","memberCard":[{"id":"15121515191964321000","chainCode":"THISGROUP","brandCode":"","hotelCode":"","memberCode":"","cardTypeCode":"01","startDate":"","endDate":""}]},"state":"1","code":"200000"}
		 * 
		 * {"message":"用户（名）已存在,身份证号已存在,邮箱已存在","state":"0","code":"010102,010302,010702"}
		 */
	}
	
	/*
	 * checkUser 会员校验（作废）
	 */
	public function checkUser() {
		$url = $this->url . '?method=checkUser&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"id" => "",
				"userName" => "hong",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"mobile" => "13580506405",
				"email" => "645030000@qq.com",
				"idCard" => "445121199301222222" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","errorMsg":"method 参数有错误","method":"checkUser","code":"200100"}
		 */
	}
	
	/*
	 * sendCheckNum 发送验证码
	 */
	public function sendCheckNum() {
		$url = $this->url . '?method=sendCheckNum&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"type" => "PMS",
				"mobile" => "13580506405" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"发送短信验证码失败","state":"0","code":"200100"}
		 */
	}
	
	/*
	 * login	会员登陆
	 */
	public function login() {
		$url = $this->url . '?method=login&json=';
		$json = array (
				"channelFrom" => "iwide",
				"channelCode" => "",
				"chainCode" => "TESTGROUP",
				"brandCode" => "",
				"hotelCode" => "",
				"loginKey" => "80034659",
				"passWord" => "888888",
				"cardTypeCode" => "",
				"exCardTypeCode" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		var_dump ( $res );
		/*
		 * 返回的信息：
		 * {"message":"成功","data":{"id":"15121512021136410000","userName":"80034659","idCard":"350127197101075046","chainCode":"TESTGROUP","brandCode":"","hotelCode":"","email":"","mobile":"13999992212","nickName":"","realName":"高纪明","memberCard":[{"id":"15121512021141112000","chainCode":"TESTGROUP","brandCode":"","hotelCode":"","memberCode":"80034659","cardTypeCode":"11","startDate":"2000-01-01","endDate":"2020-01-01"}]},"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * modifyPwd 修改会员密码
	 */
	public function modifyPwd() {
		$url = $this->url . '?method=modifyPwd&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"id" => "15121515191954910000",
				"oldPassWord" => "123456",
				"newPassWord" => "12345678" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：(成功)
		 * {"message":"成功","state":"1","code":"200000"}
		 * 
		 * 将id随机更改一个字符，则失败，信息如下："id"=>"15121515191954910020",
		 * {"message":"服务器忙","state":"0","errorMsg":"","method":"modifyPwd","code":"200100"}
		 * 
		 * 当oldPassWord输入错误时，返回：
		 * {"message":"原始密码错误","state":"0","code":"010203"}
		 */
	}
	
	/*
	 * reSetPwd 重置会员密码
	 */
	public function reSetPwd() {
		$url = $this->url . '?method=reSetPwd&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"mobile" => "13502556584",
				"checkNum" => "PT1000",
				"newPassWord" => "123456" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"验证码错误","state":"0","code":"010801"}
		 */
	}
	
	/*
	 * searchUser 查询会员信息（暂停使用）
	 */
	public function searchUser() {
		$url = $this->url . '?method=searchUser&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"id" => "15121515191954910000",
				"userName" => "hong",
				"idCard" => "445121199301222222",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"mobile" => "13580506405",
				"nickName" => "hong",
				"email" => "645030000@qq.com",
				"realName" => "夏夜",
				"orderByColumn" => "CREATETIME",
				"orderByType" => "ASC",
				"start" => "0",
				"pageSize" => "3" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","dataSize":1,"data":[{"id":"15121515191954910000","userName":"hong","idCard":"445121199301252338","chainCode":"","brandCode":"","hotelCode":"","mobile":"13502556584","nickName":"hong","email":"645030813@qq.com","realName":"吴作鸿"}],"state":"1","code":"200000"}
		 * 
		 * 当参数值填写：channelCode，orderByColumn，orderByType，start，pageSize
		 * {"message":"成功","dataSize":33,"data":[{"id":"1","userName":"test","idCard":"1","chainCode":"","brandCode":"","hotelCode":"","mobile":"1","nickName":"1","email":"1","realName":"1"},{"id":"10","userName":"M","idCard":"1234567890","chainCode":"","brandCode":"","hotelCode":"","mobile":"12345678901","nickName":"昵称","email":"8881@126.com","realName":"真实姓名"},{"id":"129","userName":"星空","idCard":"13043519880815342x","chainCode":"","brandCode":"","hotelCode":"","mobile":"15303201390","nickName":"","email":"906998364@qq.com","realName":"郑龙梅"}],"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchUserDetail 查询会员详细信息
	 */
	public function searchUserDetail() {
		$url = $this->url . '?method=searchUserDetail&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"id" => "15121515191954910000",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":{"id":"15121515191954910000","userName":"hong","idCard":"445121199301252338","chainCode":"","brandCode":"","hotelCode":"","mobile":"13502556584","nickName":"hong","email":"645030813@qq.com","realName":"吴作鸿","memberCard":[{"id":"15121515191964321000","chainCode":"THISGROUP","brandCode":"","hotelCode":"","memberCode":"","cardTypeCode":"01","startDate":"","endDate":""}]},"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * modifyUser 修改会员信息
	 */
	public function modifyUser() {
		$url = $this->url . '?method=modifyUser' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"id" => "15121515191954910000",
				"mobile" => "13580506405",
				"checkNum" => "",
				"nickName" => "hong",
				"email" => "645030000@qq.com",
				"realName" => "夏夜",
				"idCard" => "445121199301222222" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchMemberCardType 查询会员卡类型
	 */
	public function searchMemberCardType() {
		$url = $this->url . '?method=searchMemberCardType' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"userId" => "15121515191954910000",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( json_decode ( $res ) );
		/*
		 * 返回信息：
		 * {"message":"成功","data":[{"id":"f39d61584eaa8398014ed28a881e0238","cardTypeCode":"02","chainCode":"ZLGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"协议卡","description":"协议卡"},{"id":"f39d61584eaa8398014ed28a60130237","cardTypeCode":"01","chainCode":"ZLGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"普卡","description":"普卡"},{"id":"f39d61584eaa8398014ed28811aa0236","cardTypeCode":"11","chainCode":"ZLGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"金卡","description":"金卡"},{"id":"f39d61584eaa8398014ed287cf220235","cardTypeCode":"13","chainCode":"ZLGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"铂金卡","description":"铂金卡"},{"id":"f39d61584eaa8398014ece8a620600f1","cardTypeCode":"14","chainCode":"ZLGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"E卡","description":"E卡"},{"id":"f39d61584eaa8398014eafb260b3003a","cardTypeCode":"15","chainCode":"YJGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"家园卡","description":"家园卡"},{"id":"f2573c3f505a83be01505af1e10a0001","cardTypeCode":"01","chainCode":"THISGROUP","brandCode":"","hotelCode":"HY2459","type":"S","cardTypeName":"普卡","description":"普卡"},{"id":"7","cardTypeCode":"13","chainCode":"YJGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"铂金卡","description":"铂金卡"},{"id":"6","cardTypeCode":"16","chainCode":"YJGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"GOGO卡","description":"GOGO卡"},{"id":"5","cardTypeCode":"11","chainCode":"YJGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"金卡","description":"金卡"},{"id":"4","cardTypeCode":"13","chainCode":"TESTGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"铂金卡","description":"铂金卡"},{"id":"3","cardTypeCode":"12","chainCode":"TESTGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"银卡","description":"银卡"},{"id":"22","cardTypeCode":"01","chainCode":"THISGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"普卡","description":"普卡"},{"id":"21","cardTypeCode":"YINKA","chainCode":"THISGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"银卡","description":"银卡"},{"id":"20","cardTypeCode":"JINKA","chainCode":"THISGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"金卡","description":"金卡"},{"id":"2","cardTypeCode":"JINKA","chainCode":"","brandCode":"","hotelCode":"HY2403","type":"S","cardTypeName":"酒店金卡","description":"酒店金卡描述"},{"id":"19","cardTypeCode":"11","chainCode":"YJGROUPTEST","brandCode":"","hotelCode":"","type":"G","cardTypeName":"金卡","description":"金卡"},{"id":"18","cardTypeCode":"16","chainCode":"YJGROUPTEST","brandCode":"","hotelCode":"","type":"G","cardTypeName":"E会员","description":"E会员"},{"id":"17","cardTypeCode":"15","chainCode":"YJGROUPTEST","brandCode":"","hotelCode":"","type":"G","cardTypeName":"GOGO卡","description":"GOGO卡"},{"id":"16","cardTypeCode":"14","chainCode":"YJGROUPTEST","brandCode":"","hotelCode":"","type":"G","cardTypeName":"家园卡","description":"家园卡"},{"id":"15","cardTypeCode":"13","chainCode":"YJGROUPTEST","brandCode":"","hotelCode":"","type":"G","cardTypeName":"铂金卡","description":"铂金卡"},{"id":"14","cardTypeCode":"12","chainCode":"YJGROUPTEST","brandCode":"","hotelCode":"","type":"G","cardTypeName":"银卡","description":"银卡"},{"id":"10","cardTypeCode":"12","chainCode":"YJGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"银卡","description":"银卡"},{"id":"1","cardTypeCode":"11","chainCode":"TESTGROUP","brandCode":"","hotelCode":"","type":"G","cardTypeName":"金卡","description":"金卡"}],"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchMemberCard 查询会员卡信息
	 */
	public function searchMemberCard() {
		$url = $this->url . '?method=searchMemberCard' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"userId" => "15121515191954910000",
				"id" => "15121515191964321000",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"cardTypeCode" => "01",
				"memberCode" => "",
				"orderByColumn" => "STARTDATE",
				"orderByType" => "ASC",
				"start" => "0",
				"pageSize" => "2" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * id为data数据下的memberCard的id   ；    userId为data数据下的id
		 * 返回信息：
		 * {"message":"成功","dataSize":1,"data":[{"id":"15121515191964321000","userId":"15121515191954910000","chainCode":"THISGROUP","brandCode":"","hotelCode":"","memberCode":"","cardTypeCode":"01","cardTypeName":"普卡","description":"普卡","startDate":"","endDate":""}],"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchMemberCardDetail 查询会员卡详细信息
	 */
	public function searchMemberCardDetail() {
		$url = $this->url . '?method=searchMemberCardDetail' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"id" => "15121515191964321000",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":{"id":"15121515191964321000","userId":"15121515191954910000","chainCode":"THISGROUP","brandCode":"","hotelCode":"","memberCode":"","cardTypeCode":"01","cardTypeName":"普卡","description":"普卡","startDate":"","endDate":"","point":"0","balance":"0"},"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * addMemberCard 添加会员卡信息
	 */
	public function addMemberCard() {
		$url = $this->url . '?method=addMemberCard' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"userId" => "15111010263370187000",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"cardTypeCode" => "11",
				"memberCode" => "80034659",
				"startDate" => "2015-11-19",
				"endDate" => "2015-12-21" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","errorMsg":"","method":"addMemberCard","code":"200100"}
		 */
	}
	
	/*
	 * updateMemberCard 修改会员卡信息
	 */
	public function updateMemberCard() {
		$url = $this->url . '?method=updateMemberCard' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"userId" => "15111010263371720000",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"cardTypeCode" => "11",
				"memberCode" => "80034659",
				"startDate" => "2015-11-19",
				"endDate" => "2015-12-30" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","errorMsg":"","method":"addMemberCard","code":"200100"}
		 */
	}
	
	/*
	 * deleteMemberCard 删除会员卡信息
	 */
	public function deleteMemberCard() {
		$url = $this->url . '?method=deleteMemberCard' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"userId" => "15111010263371720000",
				"id" => "15111010263370187000",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：（只要id不为空，则成功）
		 * {"message":"成功","state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchFrequentContactInfo 查询常用联系人信息
	 */
	public function searchFrequentContactInfo() {
		$url = $this->url . '?method=searchFrequentContactInfo' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"userId" => "15111010263370187000",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"name" => "高纪明",
				"mobile" => "13999999999" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","dataSize":0,"data":[],"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * modifyFrequentContactInfo	维护常用联系人信息
	 */
	public function modifyFrequentContactInfo() {
		$url = $this->url . '?method=modifyFrequentContactInfo' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"id" => "15121515191964321000",
				"userId" => "15121515191954910000",
				"name" => "夏夜",
				"idCard" => "445121199301222222",
				"mobile" => "13580506405" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":{"id":"15121516433091711000"},"state":"1","code":"200000"}
		 * 
		 * 一个身份证只能一次
		 * {"message":"此身份证常用联系人信息已经存在","state":"0","code":"010102"}
		 */
	}
	
	/*
	 * deleteFrequentContactInfo	删除常用联系人信息
	 */
	public function deleteFrequentContactInfo() {
		$url = $this->url . '?method=deleteFrequentContactInfo' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"chainCode" => "",
				"brandCode" => "",
				"hotelCode" => "",
				"id" => "15111010263371720000" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchHotel	酒店查询
	 */
	public function searchHotel() {
		$url = $this->zurl . '?method=HSearchHotel';
		// http://218.244.135.198:18080/HotelCRSREQ_01/app/hotelSelfService??method=HSearchHotel
		// http://218.244.135.198:18080/HotelCRSREQ_01/app/hotelSelfService?method=HSearchHotel
		// $url = $this->url . '?method=searchHotel' . '&json=';
		$json = array (
				"channelCode" => "18",
				"channelFrom" => "iwide",
				// "userId"=> "15111010263370187000",
				"userId" => "",
				"hotelName" => "",
				"chainCode" => "YJGROUP",
				// "chainCode"=> "",
				"brandCode" => "",
				"cityCode" => "",
				"cityNameLike" => "",
				"xCoordinate" => "",
				"yCoordinate" => "",
				"startDate" => "2016-01-28",
				"endDate" => "2016-01-31",
				"start" => "0",
				"pageSize" => "500",
				"administrativeArea" => "",
				"business" => "",
				"distanceRange" => "N",
				"rank" => "",
				"sequence" => "",
				"priceRange" => "N" 
		);
		// $url .= json_encode($json);
		// $res = doCurlGetRequest( $url );
		$s = http_build_query ( $json );
		$res = doCurlPostRequest ( $url, $s );
		// echo $url.',';
		// echo $s;
		// var_dump($res);
		// print_r($res);
		return json_decode ( $res, TRUE );
		/*
		 * 返回信息：
		 当method = searchHotel时，返回
		 * {"message":"查询酒店成功","dataSize":1,"data":[{"address":"北京市 朝阳区 安贞街道裕民路12号","arder":"免费WIFI,免费停车场,餐厅","around":"","coreServices":"0,0,0,0,0,01,1,1,0,0,0","description":"阿斯顿发电房三方","distance":"0.000","hotelCode":"HY2403","hotelName":"华仪连锁惠新东街店","rank":"三星酒店","roomRate":135,"service":"医疗支援,邮政服务","smallImgUrl":"","telephone":"010-82356925","xCoordinate":116.430367,"yCoordinate":39.992137}],"state":"1"}
		 
		 当method = HotelSearch时，返回
		 {"message":"查询酒店成功","dataSize":1,"data":[{"address":"北京市 朝阳区 安贞街道裕民路12号","arder":"ssx001,ssx002,ssx003","around":"","description":"阿斯顿发电房三方","distance":"0.000","hotelCode":"HY2403","hotelName":"华仪连锁惠新东街店","rank":"三星酒店","roomRate":"80.00","service":"免费WIFI,免费停车场,餐厅,","smallImgUrl":"","telephone":"010-82356925","xCoordinate":116.430367,"yCoordinate":39.992137}],"state":"1"}
		 */
	}
	function huayihotel_add() {
		// exit ();
		$inter_id = 'a445223616';
		set_time_limit(-1);
		$hotels = $this->searchHotel ();
		var_dump($hotels);exit;
		$data = array (
				'inter_id' => $inter_id 
		);
		$lowest = array (
				'inter_id' => $inter_id,
				'update_time' => date ( 'Y-m-d H:i:s' ) 
		);
		$addition = array (
				'inter_id' => $inter_id,
				'pms_type' => 'huayi',
				'pms_room_state_way' => 3,
				'pms_member_way' => 1 
		);
		$hotel_additions = array ();
		$hotel_count = 0;
		$addition_count = 0;
		$hotel_id = 862;
		$prefix = 'http://file.iwide.cn/public/uploads/201601/';
		$hotel_haven = explode ( ',', 'HY1890,HY1891,HY1892,HY1893,HY1894,HY1895,HY1904,HY1908,HY1920,HY1924,HY1926,HY1930,HY1933,HY1938,HY2000,HY2002,HY2021,HY2026,HY2028,HY2341,HY2594,HY2596,HY2615,HY2618,HY2620,HY2623,HY2625,HY2629,HY2631,HY2632,HY2638,HY2641,HY2644,HY2647,HY2653,HY2663,HY2665,HY2675,HY2676,HY2677,HY2678,HY2686,HY2695,HY2696,HY2699' );
		foreach ( $hotels ['data'] as $oh ) {
			if (! in_array ( $oh ['hotelCode'], $hotel_haven )) {
				$data ['latitude'] = $oh ['yCoordinate'];
				$data ['longitude'] = $oh ['xCoordinate'];
				$data ['address'] = $oh ['address'];
				$data ['tel'] = $oh ['telephone'];
				$data ['name'] = $oh ['hotelName'];
				$data ['hotel_id'] = $hotel_id;
				$data ['intro'] = $oh ['description'];
				$data ['star'] = 0;
				$data ['short_intro'] = $oh ['rank'];
				$data ['intro_img'] = $prefix . $this->GrabImage ( trim ( $oh ['smallImgUrl'] ), 'yumenghin_' . $hotel_id );
				$data ['status'] = 2;
				$this->db->insert ( 'hotels', $data );
				$hotel_count ++;
				
				$addition ['hotel_id'] = $hotel_id;
				$addition ['hotel_web_id'] = $oh ['hotelCode'];
				// echo '<table>';
				// if(!in_array($oh ['hotelCode'],$hotel_haven))
				// echo '<tr><td>'.$oh ['hotelName'].'</td><td>'.$oh ['hotelCode'].'</td></tr>';
				// echo '</table>';
				$this->db->insert ( 'hotel_additions', $addition );
				
				$lowest ['hotel_id'] = $hotel_id;
				$lowest ['lowest_price'] = $oh ['roomRate'];
				$this->db->insert ( 'hotel_lowest_price', $lowest );
				
// 	var_dump ( $data );
// 	var_dump ( $addition );
// 	var_dump ( $lowest );
// 	exit ();
	
				$addition_count ++;
				$hotel_id ++;
			}
		}
		echo 'hotel:' . $hotel_count . '<br />';
		echo 'addition:' . $addition_count . '<br />';
	}
	public function GrabImage($url, $filename = "") {
		if ($url == "")
			return false;
		
		$ext = strrchr ( $url, "." );
		// if($ext!=".gif" && $ext!=".jpg" && $ext!=".png")
		// return false;
		if ($filename == "") {
			$filename = date ( 'YmdHis' ) . rand ( 10, 99 ) . $ext;
		}
		$filename .= $ext;
		
		ob_start ();
		readfile ( $url );
		$img = ob_get_contents ();
		ob_end_clean ();
		$size = strlen ( $img );
		
		$fp2 = @fopen ( $filename, "a" );
		fwrite ( $fp2, $img );
		fclose ( $fp2 );
		
		return $filename;
	}
	/*
	 * searchCityAll	查询所有城市
	 */
	public function searchCityAll() {
		$url = $this->url . '?method=searchCityAll' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"userId" => "15111010263370187000",
				"hotelCode" => "",
				"chainCode" => "",
				"brandCode" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		var_dump ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":[{"cityCode":"PEK","cityName":"北京","hotelNum":1}],"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchHotelDetail	查询酒店详细
	 */
	public function searchHotelDetail() {
		$url = $this->url . '?method=searchHotelDetail' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"userId" => "15111010263370187000",
				"hotelCode" => "HY2403",
				"chainCode" => "",
				"brandCode" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":{"hotelCode":"HY2403","hotelName":"华仪连锁惠新东街店","address":"北京市 朝阳区 安贞街道裕民路12号","telephone":"010-82356925","chainCode":"TESTGROUP","brandCode":"TESTGROUP","cityCode":"PEK","xCoordinate":"39.992137","yCoordinate":"116.430367","rank":"三星"},"state":"1","code":"200000"}
		 */
	}
	function huayiroom_add() {exit;
		set_time_limit ( 0 );
		$inter_id = 'a445223616';
		$sql = "SELECT h.*,a.hotel_web_id FROM `iwide_hotels` h join 
				iwide_hotel_additions a on h.inter_id=a.inter_id and a.hotel_id=h.hotel_id WHERE h.`inter_id` LIKE '$inter_id' and h.hotel_id >861";
		$hotels = $this->db->query ( $sql )->result_array ();
		$room = array (
				'inter_id' => $inter_id 
		);
		$room_count = 0;
		$room_id = 2805;
		$bed_types = array (
				'SIN' => '单人床',
				'DOU' => '双人床',
				'KIN' => '标准床',
				'KOD' => '大/双床' 
		);
		$prefix = 'http://file.iwide.cn/public/uploads/201601/';
		foreach ( $hotels as $hr ) {
			$web_rooms = $this->SingleHotelSearch ( $hr ['hotel_web_id'] );
			if (! empty ( $web_rooms ['data'] ['roomTypes'] )) {
				$web_rooms = $web_rooms ['data'] ['roomTypes'];
// var_dump($web_rooms);exit;
				$room ['hotel_id'] = $hr ['hotel_id'];
				foreach ( $web_rooms as $wr ) {
					$room ['room_id'] = $room_id;
					$room ['name'] = $wr ['roomTypeName'];
					// $room ['price'] = $hr ['price'];
					// $room ['oprice'] = $hr ['vprice'];
					$room ['description'] = '';
					$room ['nums'] = 1;
					// $room ['bed_num'] = $hr ['bed_num'];
					$room ['area'] = $wr ['totalArea'];
					// $room ['status'] = $hr ['status'] == 0 ? 1 : 2;
					$room ['webser_id'] = $wr ['roomTypeCode'];
					$room ['room_img'] = $prefix . $this->GrabImage ( trim ( $wr ['smallImgUrl'] ), 'yumengrimg_' . $room_id );
					// $room ['sort'] = $hr ['sort'];
					$sub_des = '';
					if (! empty ( $wr ['totalArea'] ))
						$sub_des .= $wr ['totalArea'] . ' ';
					if (! empty ( $bed_types [$wr ['bedtype']] ))
						$sub_des .= $bed_types [$wr ['bedtype']];
					$room ['sub_des'] = $sub_des;
					$this->db->insert ( 'hotel_rooms', $room );
// 					var_dump ( $room );exit;
					$room_count ++;
					$room_id ++;
				}
			}
		}
		echo 'room:' . $room_count . '<br />';
	}
	/*
	 * searchHotelRoomStay	单酒店查询，酒店房型价格 当前版本
	 */
	public function SingleHotelSearch($hotel_code) {
		$url = $this->zurl . '?method=SingleHotelSearch' . '&json=';
		$json = array (
				"channelCode" => "18",
				"channelFrom" => "iwide",
				"userId" => "",
				"priceRange" => "",
				"chainCode" => "YJGROUP",
				"brandCode" => "",
				"hotelCode" => 'HY2683',
				"startDate" => "2016-01-25",
				"endDate" => "2016-01-26",
				"memberCode" => '',
				"cardTypeCode" => '' 
		);
		$url .= json_encode ( $json );
		// print_r ( $url );
		$res = doCurlGetRequest ( $url );
		// print_r($res);
		var_dump(json_decode ( $res, TRUE ));exit;
		return json_decode ( $res, TRUE );
		// * 返回信息：
		// 将method = searchHotelRoomStay时
		// * {"message":"没有查询到数据","state":"0"}
		
		// 将method = SingleHotelSearch时，返回的数据
		// {"message":"查询成功","state":"1","data":{"channels":[{"channelCode":"12","channelFrom":"iwide","channelName":"银卡"}],"detail":[{"channelCode":"12","ratePlans":[{"canBook":"0","memberCardCode":"11","memberCardName":"金卡","ratePlanCode":"HY~11","roomTypes":[{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"169.00"}],"roomQuantity":"10","roomTypeCode":"BZ","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"80.00"}],"roomQuantity":"10","roomTypeCode":"DC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"169.00"}],"roomQuantity":"10","roomTypeCode":"SDC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"169.00"}],"roomQuantity":"10","roomTypeCode":"SMF","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"144.00"}],"roomQuantity":"10","roomTypeCode":"TDR","states":"1"}]},{"canBook":"1","memberCardCode":"12","memberCardName":"银卡","ratePlanCode":"HY~12","roomTypes":[{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"179.00"}],"roomQuantity":"10","roomTypeCode":"BZ","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"170.00"}],"roomQuantity":"10","roomTypeCode":"DC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"179.00"}],"roomQuantity":"10","roomTypeCode":"SDC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"179.00"}],"roomQuantity":"10","roomTypeCode":"SMF","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"152.00"}],"roomQuantity":"10","roomTypeCode":"TDR","states":"1"}]},{"canBook":"0","memberCardCode":"13","memberCardName":"铂金卡","ratePlanCode":"HY~13","roomTypes":[{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"159.00"}],"roomQuantity":"10","roomTypeCode":"BZ","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"151.00"}],"roomQuantity":"10","roomTypeCode":"DC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"159.00"}],"roomQuantity":"10","roomTypeCode":"SDC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"159.00"}],"roomQuantity":"10","roomTypeCode":"SMF","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"135.00"}],"roomQuantity":"10","roomTypeCode":"TDR","states":"1"}]}]}],"endDate":"2015-12-23","hotel":[{"hotelAddress":"北京市 朝阳区 安贞街道裕民路12号","hotelCode":"HY2403","hotelName":"华仪连锁惠新东街店","hotelReviewDescUrl":"http://hc.brandwisdom.cn//yijia365.php?h=234148&a=14858N6TJ4CWZ6HS&d=FNGJHB6L&display=sjcomment","hotelReviewUrl":"http://hc.brandwisdom.cn//yijia365.php?h=234148&a=14858N6TJ4CWZ6HS&d=FNGJHB6L&display=sjindex","hotelTel":"010-82356925","services":"免费WIFI,免费停车场,餐厅"}],"hotelImgUrl":[],"ratePlans":[{"freemeal":"无早","payment":"前台现付","paymentCode":"T","ratePlanCode":"HY~11","ratePlanName":"金卡价格计划"},{"freemeal":"无早","payment":"全款预付","paymentCode":"Y","ratePlanCode":"HY~12","ratePlanName":"银卡价格计划"},{"freemeal":"无早","payment":"前台现付","paymentCode":"T","ratePlanCode":"HY~13","ratePlanName":"铂金卡价格计划"}],"roomTypes":[{"bedarea":"11","bedtype":"QUE","bigImgUrl":"","floor":"1","internet":"N","roomTypeCode":"BZ","roomTypeName":"标准间","smallImgUrl":"","totalArea":""},{"bedarea":"2","bedtype":"KOD","bigImgUrl":"","floor":"1","internet":"N","roomTypeCode":"DC","roomTypeName":"大床房","smallImgUrl":"http://112.124.104.225:17000/image/springmvc-plupload/plupload/files/HY2403/o_19hsdq2afi71pgdmrn16a112bi7.jpg","totalArea":""},{"bedarea":"4","bedtype":"NONE","bigImgUrl":"","floor":"1","internet":"N","roomTypeCode":"SDC","roomTypeName":"商务大床房","smallImgUrl":"http://112.124.104.225:17000/image/springmvc-plupload/plupload/files/HY2403/o_19hsdqqh41iao1uur7jld7dcji7.jpg","totalArea":""},{"bedarea":"3","bedtype":"NONE","bigImgUrl":"","floor":"1","internet":"N","roomTypeCode":"SMF","roomTypeName":"商务数码房","smallImgUrl":"http://112.124.104.225:17000/image/springmvc-plupload/plupload/files/HY2403/o_19hsdrgvsjtvfqf1lloqg0t3l7.jpg","totalArea":""},{"bedarea":"3","bedtype":"NONE","bigImgUrl":"","floor":"1","internet":"N","roomTypeCode":"TDR","roomTypeName":"特惠单人房","smallImgUrl":"http://112.124.104.225:17000/image/springmvc-plupload/plupload/files/HY2403/o_19hsds2ng1c3sf4q1lgap5p1tjo7.jpg","totalArea":""}],"startDate":"2015-12-23"}}
	}
	
	/*
	 * searchHotelRoomStay	单酒店查询，酒店房型价格 未来版本
	 */
	public function searchHotelRoomStay() {
		$url = $this->url . '?method=SingleHotelSearch' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"userId" => "",
				"hotelCode" => "HY2403",
				"chainCode" => "",
				"brandCode" => "",
				"startDate" => "2015-11-25",
				"endDate" => "2015-12-26",
				"memberCode" => "MB",
				"cardTypeCode" => "MB" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"查询成功","state":"1","data":{"channels":[{"channelCode":"12","channelFrom":"iwide","channelName":"银卡"}],"detail":[{"channelCode":"12","ratePlans":[{"canBook":"0","memberCardCode":"12","memberCardName":"","ratePlanCode":"HY~11","roomTypes":[{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"169.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"169.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"169.00"}],"roomQuantity":"10","roomTypeCode":"BZ","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"80.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"80.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"80.00"}],"roomQuantity":"10","roomTypeCode":"DC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"169.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"169.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"169.00"}],"roomQuantity":"10","roomTypeCode":"SDC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"169.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"169.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"169.00"}],"roomQuantity":"10","roomTypeCode":"SMF","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"144.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"144.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"144.00"}],"roomQuantity":"10","roomTypeCode":"TDR","states":"1"}]},{"canBook":"1","memberCardCode":"12","memberCardName":"","ratePlanCode":"HY~12","roomTypes":[{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"179.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"179.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"179.00"}],"roomQuantity":"10","roomTypeCode":"BZ","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"170.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"170.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"170.00"}],"roomQuantity":"10","roomTypeCode":"DC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"179.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"179.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"179.00"}],"roomQuantity":"10","roomTypeCode":"SDC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"179.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"179.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"179.00"}],"roomQuantity":"10","roomTypeCode":"SMF","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"152.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"152.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"152.00"}],"roomQuantity":"10","roomTypeCode":"TDR","states":"1"}]},{"canBook":"0","memberCardCode":"12","memberCardName":"","ratePlanCode":"HY~13","roomTypes":[{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"159.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"159.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"159.00"}],"roomQuantity":"10","roomTypeCode":"BZ","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"151.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"151.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"151.00"}],"roomQuantity":"10","roomTypeCode":"DC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"159.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"159.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"159.00"}],"roomQuantity":"10","roomTypeCode":"SDC","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"159.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"159.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"159.00"}],"roomQuantity":"10","roomTypeCode":"SMF","states":"1"},{"rates":[{"acticityPrice":[],"date":"2015-12-23","rate":"135.00"},{"acticityPrice":[],"date":"2015-12-24","rate":"135.00"},{"acticityPrice":[],"date":"2015-12-25","rate":"135.00"}],"roomQuantity":"10","roomTypeCode":"TDR","states":"1"}]}]}],"endDate":"2015-12-26","hotel":[{"hotelAddress":"北京市 朝阳区 安贞街道裕民路12号","hotelCode":"HY2403","hotelName":"华仪连锁惠新东街店","hotelReviewDescUrl":"http://hc.brandwisdom.cn//yijia365.php?h=234148&a=14858N6TJ4CWZ6HS&d=FNGJHB6L&display=sjcomment","hotelReviewUrl":"http://hc.brandwisdom.cn//yijia365.php?h=234148&a=14858N6TJ4CWZ6HS&d=FNGJHB6L&display=sjindex","hotelTel":"010-82356925","services":"免费WIFI,免费停车场,餐厅"}],"hotelImgUrl":[],"ratePlans":[{"freemeal":"无早","payment":"前台现付","paymentCode":"T","ratePlanCode":"HY~11","ratePlanName":"金卡价格计划"},{"freemeal":"无早","payment":"全款预付","paymentCode":"Y","ratePlanCode":"HY~12","ratePlanName":"银卡价格计划"},{"freemeal":"无早","payment":"前台现付","paymentCode":"T","ratePlanCode":"HY~13","ratePlanName":"铂金卡价格计划"}],"roomTypes":[{"bedarea":"11","bedtype":"QUE","bigImgUrl":"","floor":"1","internet":"N","roomTypeCode":"BZ","roomTypeName":"标准间","smallImgUrl":"","totalArea":""},{"bedarea":"2","bedtype":"KOD","bigImgUrl":"","floor":"1","internet":"N","roomTypeCode":"DC","roomTypeName":"大床房","smallImgUrl":"http://112.124.104.225:17000/image/springmvc-plupload/plupload/files/HY2403/o_19hsdq2afi71pgdmrn16a112bi7.jpg","totalArea":""},{"bedarea":"4","bedtype":"NONE","bigImgUrl":"","floor":"1","internet":"N","roomTypeCode":"SDC","roomTypeName":"商务大床房","smallImgUrl":"http://112.124.104.225:17000/image/springmvc-plupload/plupload/files/HY2403/o_19hsdqqh41iao1uur7jld7dcji7.jpg","totalArea":""},{"bedarea":"3","bedtype":"NONE","bigImgUrl":"","floor":"1","internet":"N","roomTypeCode":"SMF","roomTypeName":"商务数码房","smallImgUrl":"http://112.124.104.225:17000/image/springmvc-plupload/plupload/files/HY2403/o_19hsdrgvsjtvfqf1lloqg0t3l7.jpg","totalArea":""},{"bedarea":"3","bedtype":"NONE","bigImgUrl":"","floor":"1","internet":"N","roomTypeCode":"TDR","roomTypeName":"特惠单人房","smallImgUrl":"http://112.124.104.225:17000/image/springmvc-plupload/plupload/files/HY2403/o_19hsds2ng1c3sf4q1lgap5p1tjo7.jpg","totalArea":""}],"startDate":"2015-12-23"}}
		 */
	}
	
	/*
	 * bookHotel	预定
	 */
	public function bookHotel() {
		$url = $this->url . '?method=bookHotel' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"userId" => "",
				"chainCode" => "TESTGROUP",
				"brandCode" => "",
				"hotelCode" => "HY2403",
				"guestCounts" => "1",
				"guestName" => "hong",
				"ratePlanCode" => "HY~12",
				"roomTypeCode" => "BZ",
				"totalAmount" => "179",
				"startDate" => "2016-01-20",
				"endDate" => "2016-01-21",
				"arriveEarliest" => "12:00",
				"arriveLatest" => "18:00",
				"mobile" => "13580506405",
				"roomQuantity" => "2",
				"specialRequest" => "",
				"resType" => "2",
				"rateDaily" => [ 
						"179.00" 
				],
				"roomId" => [ ],
				"memberCardCode" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		var_dump ( $res );
		print_r ( json_decode ( $res ) );
		/*
		 * 返回信息：
		 * {"message":"成功","data":{"externalResId":"GDS15122313H5N6"},"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * bookTypeUpdate	预定类型修改
	 */
	public function bookTypeUpdate() {
		$url = $this->url . '?method=bookTypeUpdate' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"userId" => "15111010263370187000",
				"hotelCode" => "HY2403",
				"chainCode" => "",
				"brandCode" => "",
				"externalResId" => "GDS15122313H5N6",
				"type" => "1" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","state":"1","code":"200000"}
		 */
	}
	
	/*
	 * cancel	取消订单
	 */
	public function cancel() {
		$url = $this->url . '?method=cancel' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"userId" => "",
				"hotelCode" => "",
				"chainCode" => "",
				"brandCode" => "",
				"externalResId" => "GDS15122313H5N6" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchOrderSync	订单查询实时数据 PMS实时查询 越多速度越慢(暂停使用)
	 */
	public function searchOrderSync() {
		$url = $this->url . '?method=searchOrderSync' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				// "id": "订单ID 只查询一条时使用",
				"timeType" => "",
				"startDate" => "2011-12-10",
				"endDate" => "2015-12-16",
				"userId" => "15111010263370187000",
				"idCard" => "350127197101075046",
				// "externalResId"=> "GDS15110513HKRL",
				"status" => "",
				"orderByColumn" => "CREATETIME",
				"orderByType" => "ASC",
				"start" => "0",
				"pageSize" => "2" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","dataSize":0,"data":[],"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchOrder	订单查询列表
	 */
	public function searchOrder() {
		$url = $this->url . '?method=searchOrder' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				// "id"=> "订单ID 只查询一条时使用",
				"timeType" => "",
				"startDate" => "2011-12-10",
				"endDate" => "2015-12-16",
				// "userId"=> "下单会员用户id [查询时:C端必填，B端忽略此字段]",
				"idCard" => "350127197101075046",
				"hotelCode" => "",
				"chainCode" => "",
				"brandCode" => "",
				"externalResId" => "",
				"status" => "",
				"inStatus" => "",
				"orderByColumn" => "CREATETIME",
				"orderByType" => "ASC",
				"start" => "0",
				"pageSize" => "2" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 如果"externalResId"=> "",
		 * 返回信息：
		 * {"message":"成功","dataSize":409,"data":[{"id":"13H4LH","hotelCode":"HY2403","hotelName":"华仪连锁惠新东街店","hotelAddress":"北京市 朝阳区 安贞街道裕民路12号","hotelTel":"010-82356925","channelName":"银卡","channelTel":"","ratePlanCode":"HY~12","ratePlanName":"银卡","roomTypeCode":"BZ","roomTypeName":"标准间","resRoomTypeInvType":"标准间","roomQuantity":1,"startTime":"2015-10-11","endTime":"2015-10-12","guestCounts":1,"personName":" 测试;","arriveEarlyTime":"18:00","arriveLateTime":"18:00","payTypeCode":"T","payType":"前台现付","payTypeName":"前台现付","totalAmount":139,"specialRequest":"","externalResId":"GDS15101113H4LH","createDateTime":"2015-10-11 09:22:11","status":"MISS","nightSize":1,"freemeal":"0","telephone":"15234213658"},{"id":"13H4ML","hotelCode":"HY2403","hotelName":"华仪连锁惠新东街店","hotelAddress":"北京市 朝阳区 安贞街道裕民路12号","hotelTel":"010-82356925","channelName":"银卡","channelTel":"","ratePlanCode":"HY~12","ratePlanName":"银卡","roomTypeCode":"BZ","roomTypeName":"标准间","resRoomTypeInvType":"标准间","roomQuantity":1,"startTime":"2015-10-13","endTime":"2015-10-14","guestCounts":1,"personName":" Zujiazhen;","arriveEarlyTime":"18:00","arriveLateTime":"18:00","payTypeCode":"T","payType":"前台现付","payTypeName":"前台现付","totalAmount":139,"specialRequest":"","externalResId":"GDS15101313H4ML","createDateTime":"2015-10-13 17:07:28","status":"CAN","nightSize":1,"freemeal":"0","telephone":"13261873443"}],"state":"1","code":"200000"}
		 *	
		 * 如果"externalResId"=> "GDS15110513HKRL",
		 * 返回的信息为：
		 * {"message":"成功","dataSize":0,"data":[],"state":"1","code":"200000"}
		 * */
	}
	
	/*
	 * searchOrderDetail	订单查询详细GDS15123013H5RL
	 */
	public function searchOrderDetail() {
		$url = $this->url . '?method=searchOrderDetail' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				// "id"=> "15111010263370187000",
				// "userId"=> "15110511445213416000",
				"idCard" => "",
				"externalResId" => "GDS15123013H5RL",
				// "externalResId"=> "GDS15122213H5N2",
				"hotelCode" => "HY2403",
				"chainCode" => "TESTGROUP",
				"brandCode" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( json_decode ( $res, true ) );
		/*
		 * 返回信息：
		 * {"message":"成功","data":{"id":"13H5N2","hotelCode":"HY2403","hotelName":"华仪连锁惠新东街店","hotelAddress":"北京市 朝阳区 安贞街道裕民路12号","hotelTel":"010-82356925","channelName":"银卡","channelTel":"","ratePlanCode":"HY~12","ratePlanName":"银卡价格计划","roomTypeCode":"BZ","roomTypeName":"标准间","resRoomTypeInvType":"标准间","roomQuantity":1,"startTime":"2015-12-23","endTime":"2015-12-24","guestCounts":1,"personName":" 王小二;","arriveEarlyTime":"12:00","arriveLateTime":"18:00","payTypeCode":"Y","payType":"全额预付","payTypeName":"全额预付","totalAmount":179,"specialRequest":"","externalResId":"GDS15122213H5N2","createDateTime":"2015-12-22 15:23:31","status":"CON","nightSize":1,"freemeal":"0","rateAmount":[],"userId":"","idCard":"","telephone":"13580506405","room":[{"buildingNo":"","floor":"","section":"","roomNumber":"","roomTypeCode":"BZ","roomTypeName":"标准房","roomDateTime":"","groupNo":"","realName":"王小二","idCard":"","mobile":"13580506405","status":"CON","checkInDate":"2015-12-23","checkOutDate":"2015-12-24"}],"pay":[]},"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchRoomService	查询客房服务（只查询STATUS=Y）
	 */
	public function searchRoomService() {
		$url = $this->url . '?method=searchRoomService' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"type" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 当参数type为空时,
		 * 返回信息：
		 * {"message":"成功","data":[{"id":"1","name":"送茶","description":"送茶","rate":10,"rateUnit":"","maxBookNumber":100,"remark":"送茶","type":""},{"id":"2","name":"送拖鞋","description":"送拖鞋","rate":0,"rateUnit":"双","maxBookNumber":10,"remark":"送拖鞋","type":"CUSTOMER"}],"state":"1","code":"200000"}
		 * 
		 * 当参数type为“Y”时,
		 * 返回信息：
		 * {"message":"成功","data":[],"state":"1","code":"200000"}
		 * */
	}
	
	/*
	 * submitRoomService	提交客房服务
	 */
	public function submitRoomService() {
		$url = $this->url . '?method=submitRoomService' . '&json=';
		$js = array (
				"id" => "1",
				"number" => "1",
				"totalAmount" => "10" 
		);
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"orderId" => "GDS15110513HKRL",
				"idCard" => "350127197101075046",
				"roomService" => [ 
						json_encode ( $js ) 
				],
				"totalAmount" => "10",
				"remark" => "" 
		);
		$url .= json_encode ( $json );
		print_r ( $url );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","errorMsg":"","method":"submitRoomService","code":"200100"}
		 * */
	}
	
	/*
	 * searchTravelList	查询旅行清单 暂时不做
	 */
	public function searchTravelList() {
		$url = $this->url . '?method=searchTravelList' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"userId" => "15111010263370187000",
				"startDate" => "2011-12-10",
				"endDate" => "2015-12-16",
				"sort" => "ASC" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":[],"state":"1","code":"200000"}
		 * */
	}
	
	/*
	 * searchStrategy	查询政策(zhang) 未完
	 */
	public function searchStrategy() {
		$url = $this->url . '?method=searchStrategy' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"type" => "0",
				"ratePlanCode" => "",
				"roomTypeCode" => "",
				"startDate" => "2015-12-16",
				"endDate" => "2015-12-17",
				"orderId" => "GDS15110513HKRL" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 当入住时间小于当前时间
		 * 返回信息：
		 * {"message ":"不能入住进历史中","state":"1"}
		 * 
		 * 当入住时间大于当前时间
		 * {"message ":"预定成功","state":"1"}
		 * */
	}
	
	/*
	 * searchRoom	查询可用房间
	 */
	public function searchRoom() {
		$url = $this->url . '?method=searchRoom' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"ratePlanCode" => "123",
				"roomTypeCode" => "0",
				"startDate" => "2011-12-16",
				"endDate" => "2015-12-17",
				"orderId" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 没有订单时，返回信息：
		 * {"message":"成功","data":{"roomTypeCode":"0","building":[],"buildingCount":0,"ratePlanCode":"123"},"state":"1","code":"200000"}
		 * */
	}
	
	/*
	 * submitRoom7Guest	分房，入住客人接口（全量接口）
	 */
	public function submitRoom7Guest() {
		$url = $this->url . '?method=submitRoom7Guest' . '&json=';
		$js1 = array (
				"roomId" => "123",
				"idCard" => "445121199301222222" 
		);
		$js2 = array (
				"mobile" => "1358050640",
				"realName" => "夏夜",
				"idCard" => "445121199301222222" 
		);
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"userId" => "15121515191954910000",
				"roomId" => [ 
						"123" 
				],
				"guest" => [ 
						json_encode ( $js2 ) 
				],
				"room7guest" => [ 
						json_encode ( $js1 ) 
				],
				"startDate" => "2011-12-16",
				"endDate" => "2015-12-17",
				"orderId" => "GDS15122213H5N2" 
		);
		$url .= json_encode ( $json );
		print_r ( $url );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","errorMsg":"","method":"searchRoom","code":"200100"}
		 * */
	}
	
	/*
	 * submitCancelRoom		取消分房
	 */
	public function submitCancelRoom() {
		$url = $this->url . '?method=submitCancelRoom' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"userId" => "",
				"roomId" => "",
				"orderId" => "GDS15122213H5N2" 
		);
		$url .= json_encode ( $json );
		print_r ( $url );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","code":"200100"}
		 * */
	}
	
	/*
	 * searchBills		查询账单
	 */
	public function searchBills() {
		$url = $this->url . '?method=searchBills' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"orderId" => "GDS15122213H5N2",
				"idCard" => "350127197101075046" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","errorMsg":"","method":"searchBills","code":"200100"}
		 */
	}
	
	/*
	 * submitInvoice	提交发票
	 */
	public function submitInvoice() {
		$url = $this->url . '?method=submitInvoice' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"userId" => "15110511445213416000",
				"orderId" => "GDS15122213H5N2",
				"idCard" => "350127197101075046",
				"title" => "iwide",
				"receiveMode" => "0",
				"address" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","errorMsg":"","method":"searchBills","code":"200100"}
		 */
	}
	
	/*
	 * searchInvoice	查询发票列表,需要先添加发票
	 */
	public function searchInvoice() {
		$url = $this->url . '?method=searchInvoice' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"userId" => "15110511445213416000" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":[],"state":"1","code":"200000"}
		 
		 * {"message":"成功","data":[{"id":"15122315061878522000","title":"iwide","receiveMode":0,"address":""}],"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * addInvoice	添加发票
	 */
	public function addInvoice() {
		$url = $this->url . '?method=addInvoice' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"userId" => "15110511445213416000",
				"title" => "iwide",
				"receiveMode" => "0",
				"address" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":{"id":"15122315061878522000"},"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * updateInvoice	修改发票
	 */
	public function updateInvoice() {
		$url = $this->url . '?method=updateInvoice' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"userId" => "15110511445213416000",
				"id" => "15121611534834520000",
				"title" => "jinfangka",
				"receiveMode" => "0",
				"address" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 当原发票的信息没有更改时，
		 * 返回信息：
		 * {"message":"发票已存在","state":"0","code":"060101"}
		 * 
		 * 修改了title 后,返回的信息为：
		 * {"message":"成功","state":"1","code":"200000"}
		 */
	}
	
	/*
	 * deleteInvoice	删除发票
	 */
	public function deleteInvoice() {
		$url = $this->url . '?method=deleteInvoice' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"userId" => "15110511445213416000",
				"id" => "15121611534834520000" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","state":"1","code":"200000"}
		 */
	}
	
	/*
	 * submitCheckIn	入住
	 */
	public function submitCheckIn() {
		$url = $this->url . '?method=submitCheckIn' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"userId" => "15110511445213416000",
				"signIdCard" => "王小二",
				"roomId" => "123",
				"orderId" => "GDS15122213H5N2",
				"image" => "123",
				"imageExt" => "JPG" 
		);
		$url .= json_encode ( $json );
		
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","errorMsg":"method 参数有错误","method":"submitCheckIn","code":"200100"}
		 */
	}
	
	/*
	 * searchRoomTypeConfig	查询房型配置
	 */
	public function searchRoomTypeConfig() {
		$url = $this->url . '?method=searchRoomTypeConfig' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"roomTypeCode" => "0" 
		);
		$url .= json_encode ( $json );
		print_r ( $url );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","errorMsg":"","method":"searchRoomTypeConfig","code":"200100"}
		 */
	}
	
	/*
	 * searchImg	获取图片
	 */
	public function searchImg() {
		$url = $this->url . '?method=searchImg' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"roomTypeCode" => "11",
				"type" => "H" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":[],"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * submitCheckOut	退房
	 */
	public function submitCheckOut() {
		$url = $this->url . '?method=submitCheckOut' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"userId" => "15110511445213416000",
				"orderId" => "GDS15122213H5N2",
				"idCard" => "350127197101075046",
				"buildingNo" => "01",
				"floor" => "01",
				"roomNumber" => "H" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","code":"200100"}
		 */
	}
	
	/*
	 * getLockStatus	获取锁状态，判断是否有锁可用
	 */
	public function getLockStatus() {
		$url = $this->url . '?method=getLockStatus' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"roomTypeCode" => "",
				"roomNumber" => "" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":"N","state":"1","code":"200000"}
		 */
	}
	
	/*
	 * openLock	开锁上电
	 */
	public function openLock() {
		$url = $this->url . '?method=openLock' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"userId" => "15110511445213416000",
				"orderId" => "GDS15122213H5N2",
				"idCard" => "350127197101075046" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","errorMsg":"","method":"openLock","code":"200100"}
		 */
	}
	
	/*
	 * getServiceTime	获取服务器时间
	 */
	public function getServiceTime() {
		$url = $this->url . '?method=getServiceTime' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":{"timestamp":1450249488471,"general":"2015-12-16 15:04:48"},"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchHotelProfile	获取酒店简介
	 */
	public function searchHotelProfil() {
		$url = $this->url . '?method=searchHotelProfile' . '&json=';
		$json = array (
				"channelCode" => "001",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403" 
		);
		$url .= json_encode ( $json );
		
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","data":{"title":"酒店简介","content":"酒店简介\"20120718165424_WFkNf.jpeg\"/<\/p>"},"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * searchHotelService	获取酒店服务
	 */
	public function searchHotelService() {
		$url = $this->url . '?method=searchHotelService' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"id" => "",
				"hotelCode" => "HY2403",
				"start" => "0",
				"pageSize" => "10" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"成功","dataSize":0,"data":[],"state":"1","code":"200000"}
		 */
	}
	
	/*
	 * updateMemPoint	会员积分增减
	 */
	public function updateMemPoint() {
		$url = $this->url . '?method=updateMemPoint' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"chainCode" => "",
				"brandCode" => "",
				"memberCardCode" => "15111010263370187000",
				"invoice" => "123",
				"tradeType" => "123",
				"point" => "1",
				"remark" => "备注" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"会员卡号不存在","state":"0","code":"010603"}
		 */
	}
	
	/*
	 * transferAccount	传账
	 */
	public function transferAccount() {
		$url = $this->url . '?method=transferAccount' . '&json=';
		$json = array (
				"channelCode" => "12",
				"channelFrom" => "iwide",
				"hotelCode" => "HY2403",
				"exTernalResId" => "01",
				"roomNumber" => "11",
				"idCard" => "350127197101075046",
				"accountCode" => "111",
				"amount" => "10",
				"externalResId" => "GDS15110513HKRL" 
		);
		$url .= json_encode ( $json );
		$res = doCurlGetRequest ( $url );
		print_r ( $res );
		/*
		 * 返回信息：
		 * {"message":"服务器忙","state":"0","code":"200100"}
		 */
	}
}	