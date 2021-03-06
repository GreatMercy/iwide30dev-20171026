<?php
if(!defined('BASEPATH')){
	exit ('No direct script access allowed');
}

/**
 * 公共函数库
 */
function getIp(){
	if(isset ($_SERVER)){
		if(isset ($_SERVER ["HTTP_X_FORWARDED_FOR"])){
			$realip = $_SERVER ["HTTP_X_FORWARDED_FOR"];
		} else{
			if(isset ($_SERVER ["HTTP_CLIENT_IP"])){
				$realip = $_SERVER ["HTTP_CLIENT_IP"];
			} else{
				$realip = $_SERVER ["REMOTE_ADDR"];
			}
		}
	} else{
		if(getenv("HTTP_X_FORWARDED_FOR")){
			$realip = getenv("HTTP_X_FORWARDED_FOR");
		} else{
			if(getenv("HTTP_CLIENT_IP")){
				$realip = getenv("HTTP_CLIENT_IP");
			} else{
				$realip = getenv("REMOTE_ADDR");
			}
		}
	}
	return $realip;
}

/**
 *    作用：格式化参数，签名过程需要使用
 */
function formatBizQueryParaMap($paraMap, $urlencode = null){
	$buff = "";
	ksort($paraMap);
	foreach($paraMap as $k => $v){
		if($urlencode){
			$v = urlencode($v);
		}
		//$buff .= strtolower($k) . "=" . $v . "&";
		$buff .= $k . "=" . $v . "&";
	}
	$reqPar;
	if(strlen($buff) > 0){
		$reqPar = substr($buff, 0, strlen($buff) - 1);
	}
	return $reqPar;
}

/**
 * 封装curl的调用接口，post的请求方式
 * @param string URL
 * @param string POST表单值
 * @param array  扩展字段值
 * @param second 超时时间
 * @return mixed 请求成功返回成功结构，否则返回FALSE
 */
function doCurlPostRequest($url, $requestString, $extra = array(), $timeout = 5){
	if($url == "" || $requestString == "" || $timeout <= 0){
		return false;
	}
	$con = curl_init(( string )$url);
	curl_setopt($con, CURLOPT_HEADER, false);
	curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
	curl_setopt($con, CURLOPT_POST, true);
	curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($con, CURLOPT_TIMEOUT, ( int )$timeout);
	curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($con, CURLOPT_SSL_VERIFYHOST, 0);

	if(!empty ($extra) && is_array($extra)){
		$headers = array();
		foreach($extra as $opt => $value){
			if(strexists($opt, 'CURLOPT_')){
				curl_setopt($con, constant($opt), $value);
			} elseif(is_numeric($opt)){
				curl_setopt($con, $opt, $value);
			} else{
				$headers [] = "{$opt}: {$value}";
			}
		}
		if(!empty ($headers)){
			curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
		}
	}
	$res = curl_exec($con);
//	var_dump(curl_error($con));
	curl_close($con);
	return $res;
}

function strexists($string, $find){
	return !(strpos($string, $find) === false);
}


/**
 * 封装curl的调用接口，get的请求方式
 * @param string 请求URL
 * @param array  请求参数值array(key=>value,...)
 * @param second 超时时间
 * @return mixed 请求成功返回成功结构，否则返回FALSE
 */
function doCurlGetRequest($url, $data = array(), $timeout = 10){
	if($url == "" || $timeout <= 0){
		return false;
	}
	if($data != array()){
		$url = $url . '?' . http_build_query($data);
	}
	$con = curl_init(( string )$url);
	curl_setopt($con, CURLOPT_HEADER, false);
	curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($con, CURLOPT_TIMEOUT, ( int )$timeout);
	curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false);

	return curl_exec($con);
}

/**
 * 产生随机字符串，不长于32位
 * @param number 长度
 * @return string
 */
function createNoncestr($length = 32){
	$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
	$str = "";
	for($i = 0; $i < $length; $i++){
		$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $str;
}

/**
 * 统计区间耗时及使用内存
 * @param string $start 开始点 若只有开始节点时，则会记录该点的时间值，使用内存值
 * @param string $end   结束点
 * @param mixed  $dec   类型（数字代表保留小数点位数，m表示返回内存使用情况)
 * @return string
 */
function statistic($start, $end = '', $dec = 4){
	static $_info = [];
	static $_mem = [];
	if(is_float($end)){ // 记录时间
		$_info[$start] = $end;
	} elseif(!empty($end)){ // 统计时间和内存使用
		if($dec == 'm'){
			if(!isset($_mem[$end])){
				$_mem[$end] = memory_get_usage();
			}
			return size_format($_mem[$end] - $_mem[$start]);
		} else{
			if(!isset($_info[$end])){
				$_info[$end] = microtime(true);
			}
			return number_format(($_info[$end] - $_info[$start]), $dec);
		}

	} else{ // 记录时间和内存使用
		$_info[$start] = microtime(true);
		$_mem[$start] = memory_get_usage();
	}
}

function array2xml($data, $item = 'item', $id = null){
	$xml = $attr = '';
	foreach($data as $key => $val){
		if(is_numeric($key)){
			$id && $attr = " {$id}=\"{$key}\"";
			$key = $item;
		}
		$tag_state = true;

		if(is_array($val) || is_object($val)){
			foreach($val as $k => $t){
				if(is_numeric($k)){
					$tag_state = false;
				}
			}
		}

		if($tag_state === true){
			$xml .= "<{$key}{$attr}>";
		}

		$item = $key;
		$xml .= (is_array($val) || is_object($val)) ? array2xml($val, $item, $id) : $val;
		if($tag_state === true){
			$xml .= "</{$key}>";
		}
	}
	return $xml;
}

function obj2array($obj){
	return json_decode(json_encode($obj), true);
}

function xmlobj2array($obj){
	$obj = (array)$obj;
	$result = array();
	foreach($obj as $k => $v){
		if(empty($v)){
			if(is_object($v)){
				$v = null;
			}
		} else{
			if(is_array($v) || is_object($v)){
				$v = xmlobj2array($v);
			}
		}
		$result[$k] = $v;
	}
	return $result;
}

function xml2array($xml){
	if(!$xml){
		return array();
	}
	$obj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
	return xmlobj2array($obj);
}

/**
 * 执行http 请求 XML
 * @param $url
 * @param $xml
 * @param int $timeout
 * @return bool|mixed|null
 */
function curl_post_xml($url, $xml, $timeout = 0){
	if($url == "" || $timeout < 0){
		return false;
	}
	$header[] = "Content-type: text/xml";
	$ch = curl_init((string)$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	if($timeout)
		curl_setopt($ch, CURLOPT_TIMEOUT, ( int )$timeout);
	$response = curl_exec($ch);
	if(curl_errno($ch)){
		//print curl_error($ch);
		curl_close($ch);
		return null;
	} else{
		curl_close($ch);
		return $response;
	}
}

/**
 * 记录PMS数据日志
 * @param array  $req
 * @param array  $res
 * @param string $web_path
 * @param string $inter_id
 * @param array  $api_req
 */
function pms_logger($req = array(), $res = array(), $web_path = '', $inter_id = '', $api_req = array(), $use_time = null){
	is_string($req) or $req=json_encode($req,JSON_UNESCAPED_UNICODE);
	is_string($res) or $res=json_encode($res,JSON_UNESCAPED_UNICODE);
	$res=preg_replace('/[\r\n]+/','',$res);//为了方便查找记录，将返回结果写成一行
	$CI = &get_instance();
	$ip = $CI->input->ip_address();

	$content = '[' . date('Y-m-d H:i:s') . ']  | ' . $CI->input->server('SERVER_ADDR'). ' | ' . getmypid() . '|' . session_id() . ' | ' . $web_path . ' | ' . $ip . ' | [Request] : ' . $req;
	if($api_req){
		is_string($api_req) or $api_req=json_encode($api_req);
		$content .= ' | [API Request] : ' . $api_req;
	}
	$content .= ' | [Response] : ' . $res;
	if($use_time !== null){
		$content .= ' | [Query Time] : ' . $use_time;
	}
	$content .= "\n" . str_repeat('=', 100) . "\n\n";

	$pith = 50 * 1024 * 1024;

	$inter_id != '' or $inter_id = 'noname';

	$folder = APPPATH . 'logs' . DS . 'pms' . DS . $inter_id. DS;
	if(!is_dir($folder)){
		mkdir($folder, 0777, true);
	}
	$file = $folder . date('Ymd') . '.txt';

	$fp = fopen($file, 'ab+');
	/*$i=0;
	//执行文件锁，
	$lock_sta = flock($fp, LOCK_EX | LOCK_NB);
	while(!$lock_sta){
		fclose($fp);
		$file = $folder . date('Ymd') . '.' . $i . '.txt';
		$fp = fopen($file, 'ab+');
		$lock_sta = flock($fp, LOCK_EX | LOCK_NB);
		$i++;
		//文件序号大于9时，重0重新循环一次直到取得锁为止
		if($i > 9){
			$i = 0;
			usleep(1000);
		}
	}*/

	fwrite($fp, $content);
	//	flock($fp,LOCK_UN);
	fclose($fp);

	if(file_exists($file) && filesize($file) > $pith){
		$backfile = substr(basename($file), 0, strrpos(basename($file), '.txt')) . '_' . date('Hi') . '.txt';
		rename($file, $folder . DS . $backfile);
	}

}

/**
 * 从Redis中获取酒店起始价
 * @param $inter_id
 * @param $hotel_id
 * @param $member_level
 * @param $startdate
 * @param $enddate
 * @return mixed|null
 */
function lowest_from_redis($inter_id, $hotel_id, $member_level, $startdate = 0, $enddate = 0){
	$ci =& get_instance();
	$ci->load->library('Cache/Redis_proxy',array(
		'not_init'=>FALSE,
		'module'=>'common',
		'refresh'=>FALSE,
		'environment'=>ENVIRONMENT
	),'redis_proxy');

	//读取当天的起价缓存
	$key_date = 'lowest:' . $inter_id . ':' . $hotel_id . ':' . $member_level . ':' . date('Ymd', strtotime($startdate)) . ':' . date('Ymd', strtotime($enddate));
	//起价缓存
	$key = 'lowest:' . $inter_id . ':' . $hotel_id . ':' . $member_level;

	if($ci->redis_proxy->exists($key_date)){
		$redis_data = $ci->redis_proxy->hGetAll($key_date);
	} else{
		$redis_data = $ci->redis_proxy->hGetAll($key);
	}

	if($redis_data){
		$min_price = [];
		//循环，KEY为房型ID
		foreach($redis_data as $k => $v){
			$min_price[] = $v;
		}
		return min($min_price);
	}
	return null;
}

function my_sort($a,$b){
	if(is_array($a)) $a = end($a);
	if(is_array($b)) $b = end($b);
	if ($a==$b) return 0;
	return ($a<$b)?-1:1;
}

function my_rsort($a,$b){
	if(is_array($a)) $a = end($a);
	if(is_array($b)) $b = end($b);
	if ($a==$b) return 0;
	return ($a>$b)?-1:1;
}

/**
 * 接受POST、GET数据和XML数据
 * @return array
 */
function get_args(){
    $args = array();
    if(strpos($_SERVER['REQUEST_URI'],'?')!==false || $_SERVER['REQUEST_METHOD']=='GET'){
        $args = $_GET; //接收GET数据
    }
    $input = file_get_contents("php://input"); //接收原始数据

    json_decode($input);
    if(json_last_error() == JSON_ERROR_NONE){ //数据为JSON格式
        $data = json_decode($input,true);
    }else{
        parse_str($input,$data); //参数存到$data中
    }
    if(!empty($data)) $args = array_merge($args,$data);

    //如果是XML
    $xml_data = xml_parser($input);
    if($xml_data){
        $args = array_merge($args,$xml_data);
    }
    return $args;
}

/**
 * 解析XML格式的字符串
 * @param $str
 * @return bool|mixed 解析正确就返回解析结果,否则返回false
 */
function xml_parser($str){
    $xml_parser = xml_parser_create();
    if(!xml_parse($xml_parser,$str,true)){
        xml_parser_free($xml_parser);
        return false;
    }else {
        return (json_decode(json_encode(simplexml_load_string($str)),true));
    }
}