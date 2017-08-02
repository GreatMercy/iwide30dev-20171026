<?php
/**
 * 平台日志类，用于平台日常记录
 * @author Race
 * @version 1.0
 */
class MYLOG{
	
	//日志分隔符，统一，不能改动
	const _SQER = " | ";
	
	//PMS访问及错误日志log的目录
	const _PMS_ACCESS_LOG_DIR = 'pms_log';
	const _PMS_ERROR_LOG_DIR = 'pms_error';
	

	/**
	 * 日志写入
	 * 格式：
	 * Y-m-d H:i:s | 进程id | 客户端IP | session id | 访问地址 | POST=post参数(json格式) | 内容
	 * @param unknown $content 内容
	 * @param unknown $dir 目录名称
	 * @param string $file_key	文件名标记
	 */
	static public function w( $content,$dir = 'default',$file_key = '' )
	{
		
		$file= date('Y-m-d').$file_key. '.log';
		//echo $tmpfile;die;
		$path= APPPATH.'logs'.DS. $dir. DS;
	
		if( !file_exists($path) ) {
			@mkdir($path, 0777, TRUE);
		}
		$log_str='';
		if (is_array($content)){//批量记日志
			foreach ($content as $cont){
				$cont = str_replace("\r"," ",$cont);
				$cont = str_replace("\n"," ",$cont);
				$log_str .= date("Y-m-d H:i:s")." | ".getmypid()." | ".$_SERVER['REMOTE_ADDR']." | ".session_id()." | ".$_SERVER['REQUEST_URI'].' | POST='.json_encode($_POST).' | '.$cont."\n";
			}
		}else{
			$content = str_replace("\r"," ",$content);
			$content = str_replace("\n"," ",$content);
		
			//echo __FILE__
			$log_str = date("Y-m-d H:i:s")." | ".getmypid()." | ".$_SERVER['REMOTE_ADDR']." | ".session_id()." | ".$_SERVER['REQUEST_URI'].' | POST='.json_encode($_POST).' | '.$content."\n";
		}
	
		$fp = fopen( $path. $file, "a");
		fwrite($fp, $log_str);
		fclose($fp);
		
	}
	
	
	
	
	/**
	 * pms接口调用日志记录
	 * 格式：
	 * self::w()格式 | inter_id | 等待时间 | api类型 | api地址 | 发送记录 | 接收记录 | 备注
	 * @param unknown $inter_id
	 * @param unknown $send_time 接口调用时发请求的时间
	 * @param unknown $pms_wait_time 接口调用耗时
	 * @param unknown $api_type api类型，用于不同酒店的api有多个接口，用于识别不同的接口
	 * @param unknown $api_url api接口链接
	 * @param unknown $send_content 发送内容
	 * @param unknown $record_content 接收到的内容
	 * @param unknown $remark 备注
	 */
	static public function pms_access_record($inter_id,$send_time,$pms_wait_time,$api_type,$api_url,$send_content,$record_content,$remark = ""){
		
		//时间 酒店inter_id 调用耗时(ms） openid 接口类别 发送记录 接收记录
		//self::w($content, $dir)
		$arr[] = $inter_id;
		$arr[] = $send_time;
		$arr[] = $pms_wait_time;
		$arr[] = $api_type;
		$arr[] = $api_url;
		$arr[] = $send_content;
		$arr[] = $record_content;
		$arr[] = $remark;
		$content = implode(self::_SQER,$arr);
		
		self::w($content,self::_PMS_ACCESS_LOG_DIR,"_access");
		
		
	}
	
	/**
	 * pms接口调用日志记录
	 * 格式：
	 * self::w()格式 | ERROR=错误级别 1：严重，2：中等  | 错误提示 | inter_id | 等待时间 | api类型 | api地址 | 发送记录 | 接收记录 | 备注	 
	 * @param unknown $inter_id 
	 * @param unknown $send_time 接口调用时发请求的时间
	 * @param unknown $receive_time 接口耗时
	 * @param unknown $api_type api类型，用于不同酒店的api有多个接口，用于识别不同的接口
	 * @param unknown $api_url api接口链接
	 * @param unknown $send_content 发送内容
	 * @param unknown $record_content 接收到的内容
	 * @param unknown $error_lev 错误级别 1：严重，2：中等
	 * @param unknown $error_msg 错误提示
	 * @param unknown $remark_data 备注
	 */
	static public function pms_error_record($inter_id,$send_time,$wait_time,$api_type,$api_url,$send_content,$record_content,$error_lev=0,$error_msg='',$remark_data=''){
	
		//时间 酒店inter_id 调用耗时(ms） openid 接口类别 发送记录 接收记录
		//self::w($content, $dir)
		//例子：2016-01-01 11:11:11 | ERROR=1 | 获取酒店信息失败 | a452342111 | 2000 | asdsedczveweqweqwsad | getHotels | {hotel_id:100} | {hotel_name:名称}
		$arr[] = "ERROR=".$error_lev;
		$arr[] = $error_msg;
		
		$arr[] = $inter_id;
		$arr[] = $send_time;
		$arr[] = $wait_time;
		$arr[] = $api_type;
		$arr[] = $api_url;
		$arr[] = $record_content;
		$arr[] = $send_content;
		$arr[] = $remark_data;
		
		$content = implode(self::_SQER,$arr);
	
		self::w($content,'hotel'.DS.self::_PMS_ERROR_LOG_DIR);
	
	
	}
	
	
	static function hotel_tracker($openid,$inter_id,$hotel_id = 0,$page_name="",$dir = 'tracker',$file_key = '' ){

		//时间，openid，业务(business-hotel,business-soma,business-mooncake),
		//接口(hotel/search,hotel/sresult,hotel/index,hotel/bookroom等)，
		//用户IP，interid，hotelid，URL，会话id , post|get数据	
		$arr[] = date("Y-m-d H:i:s");
		$arr[] = $openid;
		$arr[] = "business-hotel";
		if($page_name == ""){
			$page_arr = explode(".php",$_SERVER['REQUEST_URI']);
			$page_name = isset($page_arr[1])?$page_arr[1]:$_SERVER['PHP_SELF'];
			$page_arr2 = explode("?",$page_name);
			$page_name = $page_arr2[0];
		}
		$arr[] = $page_name;
		$arr[] = $inter_id;
		if(isset($_REQUEST['h']) && $_REQUEST['h'] > 0){
			$hotel_id = $_REQUEST['h'];
		}else if(isset($_REQUEST['hotel_id']) && $_REQUEST['hotel_id'] > 0){
			$hotel_id = $_REQUEST['hotel_id'];
		}else if(isset($_REQUEST['hid']) && $_REQUEST['hid'] > 0){
			$hotel_id = $_REQUEST['hid'];
		}
		$arr[] = $hotel_id;
		$arr[] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$arr[] = session_id();
		
		$arr[] = json_encode($_REQUEST);
		
		self::tracker($arr);
		
	}
	
	
	static function Wxapp_tracker($openid,$inter_id,$hotel_id = 0,$page_name="",$dir = 'tracker',$file_key = '' ){
	
		//时间，openid，业务(business-hotel,business-soma,business-mooncake),
		//接口(hotel/search,hotel/sresult,hotel/index,hotel/bookroom等)，
		//用户IP，interid，hotelid，URL，会话id , post|get数据
		$arr[] = date("Y-m-d H:i:s");
		$arr[] = $openid;
		$arr[] = "business-wxapp";
		if($page_name == ""){
			$page_arr = explode(".php",$_SERVER['REQUEST_URI']);
			$page_name = isset($page_arr[1])?$page_arr[1]:$_SERVER['PHP_SELF'];
			$page_arr2 = explode("?",$page_name);
			$page_name = $page_arr2[0];
		}
		$arr[] = "wxapp/".$page_name;
		$arr[] = $inter_id;
		if(isset($_REQUEST['h']) && $_REQUEST['h'] > 0){
			$hotel_id = $_REQUEST['h'];
		}else if(isset($_REQUEST['hotel_id']) && $_REQUEST['hotel_id'] > 0){
			$hotel_id = $_REQUEST['hotel_id'];
		}
		$arr[] = $hotel_id;
		$arr[] = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$arr[] = session_id();
	
		$arr[] = json_encode($_REQUEST);
		
		//app增加页面的前序
		//$_SERVER['HTTP_REFERER'] = "wxapp/".$_SERVER['HTTP_REFERER'];
	
		self::tracker($arr);
	
	}
	
	static function soma_tracker($openid,$inter_id,$production_id = 0,$page_name="",$dir = 'tracker',$file_key = '' ){
	
		//时间，openid，业务(business-hotel,business-soma,business-mooncake),
		//接口(hotel/search,hotel/sresult,hotel/index,hotel/bookroom等)，
		//用户IP，interid，hotelid，URL，会话id , post|get数据
		$arr[] = date("Y-m-d H:i:s");
		$arr[] = $openid;
		$arr[] = "business-soma";
		if($page_name == ""){
			$page_arr = explode(".php",$_SERVER['REQUEST_URI']);
			$page_name = isset($page_arr[1])?$page_arr[1]:$_SERVER['PHP_SELF'];
			$page_arr2 = explode("?",$page_name);
			$page_name = $page_arr2[0];
		}
		$arr[] = $page_name;
		$arr[] = $inter_id;
		
		$pid = $production_id;
		if(isset($_REQUEST['pid']) && $_REQUEST['pid'] > 0){
			$pid = $_REQUEST['pid'];
		}
		
		$arr[] = $pid;
		$arr[] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$arr[] = session_id();
	
		$arr[] = json_encode($_REQUEST);
	
		self::tracker($arr);
	
	}
	
	
	static function distribute_tracker($openid,$inter_id,$info_id = 0,$page_name="",$dir = 'tracker',$file_key = '' ){
	
		//时间，openid，业务(business-hotel,business-soma,business-mooncake),
		//接口(hotel/search,hotel/sresult,hotel/index,hotel/bookroom等)，
		//用户IP，interid，hotelid，URL，会话id , post|get数据
		$arr[] = date("Y-m-d H:i:s");
		$arr[] = $openid;
		$arr[] = "business-distribute";
		if($page_name == ""){
			$page_arr = explode(".php",$_SERVER['REQUEST_URI']);
			$page_name = isset($page_arr[1])?$page_arr[1]:$_SERVER['PHP_SELF'];
			$page_arr2 = explode("?",$page_name);
			$page_name = $page_arr2[0];
		}
		$arr[] = $page_name;
		$arr[] = $inter_id;
		/*if(isset($_REQUEST['h']) && $_REQUEST['h'] > 0){
		 $hotel_id = $_REQUEST['h'];
		}else if(isset($_REQUEST['hotel_id']) && $_REQUEST['hotel_id'] > 0){
		$hotel_id = $_REQUEST['hotel_id'];
		}*/
	
		$arr[] = $info_id;
		$arr[] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$arr[] = session_id();
	
		$arr[] = json_encode($_REQUEST);
	
		self::tracker($arr);
	
	}
	
	static function member_tracker($openid,$inter_id,$member_info_id = 0,$page_name="",$dir = 'tracker',$file_key = '' ){
	
		//时间，openid，业务(business-hotel,business-soma,business-mooncake),
		//接口(hotel/search,hotel/sresult,hotel/index,hotel/bookroom等)，
		//用户IP，interid，hotelid，URL，会话id , post|get数据
		$arr[] = date("Y-m-d H:i:s");
		$arr[] = $openid;
		$arr[] = "business-member";
		if($page_name == ""){
			$page_arr = explode(".php",$_SERVER['REQUEST_URI']);
			$page_name = isset($page_arr[1])?$page_arr[1]:$_SERVER['PHP_SELF'];
			$page_arr2 = explode("?",$page_name);
			$page_name = $page_arr2[0];
		}
		$arr[] = $page_name;
		$arr[] = $inter_id;
		/*if(isset($_REQUEST['h']) && $_REQUEST['h'] > 0){
			$hotel_id = $_REQUEST['h'];
		}else if(isset($_REQUEST['hotel_id']) && $_REQUEST['hotel_id'] > 0){
			$hotel_id = $_REQUEST['hotel_id'];
		}*/
		
		$arr[] = $member_info_id;
		$arr[] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$arr[] = session_id();
	
		$arr[] = json_encode($_REQUEST);
	
		self::tracker($arr);
	
	}
	
	
	/**
	 * 探针通用写方法
	 * @param unknown $arr
	 * @param string $dir
	 * @param string $file_key
	 */
	static function tracker($arr,$dir = 'tracker',$file_key = ''){
		if (ENVIRONMENT === 'dev') return;
		$file= date('Y-m-d').$file_key. '.log';
		//echo $tmpfile;die;
		$path= APPPATH.'logs'.DS. $dir. DS;
		
		if( !file_exists($path) ) {
			@mkdir($path, 0777, TRUE);
		}

		/*foreach($arr as $key=>$data){
			$sql = str_replace("\r"," ",$content);
			$sql = str_replace("\n"," ",$content);
		}*/
		$arr[] = self::getIP();
		$arr[] = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:"";
		
		$content = "\n".implode(self::_SQER,$arr);
		
		$fp = fopen( $path. $file, "a");
		fwrite($fp, $content);
		fclose($fp);
		
	}
	
	static function common_tracker($tracker_key,$page_id = 0,$openid = "",$inter_id="",$page_name="" ){
	
		//时间，openid，业务(business-hotel,business-soma,business-mooncake),
		//接口(hotel/search,hotel/sresult,hotel/index,hotel/bookroom等)，
		//用户IP，interid，hotelid，URL，会话id , post|get数据
		$arr[] = date("Y-m-d H:i:s");
		$arr[] = $openid?$openid:"no openid";
		$arr[] = $tracker_key;
		if($page_name == ""){
			$page_arr = explode(".php",$_SERVER['REQUEST_URI']);
			$page_name = isset($page_arr[1])?$page_arr[1]:$_SERVER['PHP_SELF'];
			$page_arr2 = explode("?",$page_name);
			$page_name = $page_arr2[0];
		}
		$arr[] = $page_name;
		$arr[] = $inter_id?$inter_id:"no inter_id";

		$arr[] = $page_id;
		$arr[] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$arr[] = session_id();
	
		$arr[] = json_encode($_REQUEST);
	
		self::tracker($arr);
	
	}
	
	
	static function getIP() {
		
		if (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) {
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) {
			$ip = getenv('HTTP_FORWARDED_FOR');
	
		}
		elseif (getenv('HTTP_FORWARDED')) {
			$ip = getenv('HTTP_FORWARDED');
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	
	
	
}