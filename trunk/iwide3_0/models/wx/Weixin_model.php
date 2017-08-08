<?php
/**
 * 微信基础
 *
 */
class Weixin_model extends CI_Model {
	var $data = array ();
	var $wxcpt, $sReqTimeStamp, $sReqNonce, $sEncryptMsg,$token;
	public function __construct() {
		$content = file_get_contents ( 'php://input' );
		if(empty($content)){
			die ( '这是微信请求的接口地址，直接在浏览器里无效' );
		}
		MYLOG::w('info|'.$content,'subamsg');
		if (isset($_GET ['encrypt_type']) && $_GET ['encrypt_type'] == 'aes') {
			vendor ( 'WXBiz.wxBizMsgCrypt' );
			$this->sReqTimeStamp = $_GET['timestamp'];
			$this->sReqNonce = $_GET['nonce'];
			$this->sEncryptMsg = $_GET['msg_signature'];
			$this->load->model('wx/Publics_model');
			$id = $_GET['id'];
			$info = $this->Publics_model->get_public_by_id($id);
			
			$this->token = $info ['inter_id'];
			$this->wxcpt = new WXBizMsgCrypt ( 'weiphp', $info ['aes_key'], $info ['appid'] );
			
			$sMsg = ""; // 解析之后的明文
			$errCode = $this->wxcpt->DecryptMsg ( $this->sEncryptMsg, $this->sReqTimeStamp, $this->sReqNonce, $content, $sMsg );
			if ($errCode != 0) {
				exit ();
			} else {
				// 解密成功，sMsg即为xml格式的明文
				$content = $sMsg;
			}
		}
		$data = simplexml_load_string($content,"SimpleXMLElement",LIBXML_NOCDATA);
		$card_events = array('card_pass_check','user_get_card','user_del_card','user_consume_card','user_view_card','user_enter_session_from_card');
		
		if($_GET['id']=='a439536396' && !in_array($data['event'],$card_events)){//城市名人a439536396
			$this->load->helper('common');
			echo doCurlPostRequest('http://dx.4008266333.net/cch.aspx',$content);
			exit;
		}
		$this->data = json_decode(json_encode($data),TRUE);
	}
	/* 获取微信平台请求的信息 */
	public function getData() {
		return $this->data;
	}
	/* ========================发送被动响应消息 begin================================== */
	public function replyService($to_user_name,$from_user_name,$interid=""){
		/* $handle = @fopen(APPPATH. 'logs/kefu2.log','a');
		if ($handle) {
			fwrite($handle,date('Y-m-d H:i:s')."__".$interid.' - '.file_get_contents("php://input")."\n");
			fclose($handle);
		} */
		
		//d开头的为测试号， a开头的为正式，目前365和远洲 采用自主多客服系统处理数据
		//白云：a450941565
		/*
		if(!empty($interid) && ($interid == "d460605501" || $interid == "d460605502" || $interid == "a450941565" || $interid == "a445223616" || $interid == "a440577876" || $interid == "a452233816" || $interid == "a450939254" || $interid == "a450690696" || $interid == "a456989316")){
			$url = "";
			if($interid == "d460605501" || $interid == "d460605502"){
				$url = "http://kefutest.iwide.cn/frontend/web/index.php?r=public/recivemsg";
			}else{
				$url = "http://kefu.iwide.cn/frontend/web/index.php?r=public/recivemsg";
			}
			
			$msg = array();
			$msg['interid'] = $interid;
			$msg['msgxml']	= file_get_contents("php://input");
			$this->http_post($url,$msg);
			echo "";
			exit();
		}else{
			$msg ['ToUserName']   = $to_user_name;
			$msg ['FromUserName'] = $from_user_name;
			$msg ['CreateTime']   = time();
			$msg ['MsgType']      = 'transfer_customer_service';
			$msg ['FuncFlag']      = 0;
			$xml = new \SimpleXMLElement ( '<xml></xml>' );
			$this->_data2xml ( $xml, $msg );
			$str = $xml->asXML ();
			echo $str;
		}
		*/
		
		//$fp = fopen("show_log.txt", "a");
		//@fwrite($fp, $str,strlen($str));
		
		if(!empty($interid)){
			//因为365云盟 要求转到他们自己客服
			if($interid == "a445223616"){
				$msg ['ToUserName']   = $to_user_name;
				$msg ['FromUserName'] = $from_user_name;
				$msg ['CreateTime']   = time();
				$msg ['MsgType']      = 'transfer_customer_service';
				$msg ['FuncFlag']      = 0;
				$xml = new \SimpleXMLElement ( '<xml></xml>' );
				$this->_data2xml ( $xml, $msg );
				$str = $xml->asXML ();
				echo $str;
				exit();
			}else{
                //速8推送到第三方接口
                if($interid == 'a429262687'){//速8 a455510007
                    $res = $this->subaMsg($to_user_name,$this->data,$interid);
                    $res = json_decode($res,true);
                    if(isset($res['ok']) && isset($res['fallback']) && $res['fallback']){
                        ob_clean();
                        echo "";
                        exit();
                    }
                }
				$url = "";
				if($interid == "d460605501" || $interid == "d460605502"){
					$url = "http://kefutest.iwide.cn/frontend/web/index.php?r=public/recivemsg";
				}else{
					$url = "http://kefu.iwide.cn/frontend/web/index.php?r=public/recivemsg";
				}
				
				$msg = array();
				$msg['interid'] = $interid;
				$msg['msgxml']	= file_get_contents("php://input");
				//@fwrite($fp, $msg['msgxml'],strlen($msg['msgxml']));
				$this->http_post($url,$msg);
				ob_clean();
				echo "";
				exit();
			}
			//@fwrite($fp, "finish",strlen("finish"));
		}else{
			ob_clean();
			echo "success";
			exit();
		}
		
	}

	//速8 获取location信息
	public function send_location_info($to_user_name,$from_user_name,$interid=""){
		MYLOG::w('微信内容|'.json_encode($this->data),'subamsg');
		if(isset($this->data['Event']) && $this->data['Event']=='LOCATION'){
			//MYLOG::w('微信内容|'.json_encode($this->data),'subamsg');
			//根据openid查一次 uuid
			$uuid = $this->db->get_where('subaopenid_uuid',array('openid'=>$to_user_name))->row_array()['uuid'];
			if(empty($uuid)){
				//没有新生一个
				$uuid = $this->subaCreateUuid();
				$insert = $this->db->insert('subaopenid_uuid',array('openid'=>$to_user_name,'uuid'=>$uuid));
				if(!$insert){
					echo 'error';
					die;
				}
			}
			$url = 'http://api.0mzl.com/feed/coordinate';
			$header = array('Content-Type'=>'application/json');
			$client_secret = 'UXQEdyOPqFl7zUKmXrLNGeCSffyvd6e5jaI7kmUh';
            $location = $this->wgstogcj($this->data['Latitude'],$this->data['Longitude']);
			$message = array(
				'channel_uuid'=>'91f40ca7-cfa2-4c83-b193-35002cb90922',
				//'service_uuid' => '',
				'user_uuid' => $uuid,
				'latitude'=>isset($location['lat'])?(float)$location['lat']:'',
				'longitude'=>isset($location['lon'])?(float)$location['lon']:'',
				//  'data'=>array('text'=>$content),
				'timestamp'=> $this->msectime(),
			);
			$sign = $this->subaSignature($message['channel_uuid'],'',$message['user_uuid'],$message['timestamp'],$client_secret);
			$message['signature'] = $sign;
			$param = $message;
			$this->load->helper('common');
			MYLOG::w('params|'.json_encode($param),'subamsg');
			//var_dump(json_encode($content));die;
			$res = doCurlPostRequest($url,json_encode($param),$header);
			MYLOG::w('res|'.json_encode($res),'subamsg');
			return $res;
		}
	}
	/* 回复文本消息 */
	public function replyText($content) {
		$msg ['Content'] = $content;
		$this->_replyData ( $msg, 'text' );
	}
	/* 回复图片消息 */
	public function replyImage($media_id) {
		$msg ['Image'] ['MediaId'] = $media_id;
		$this->_replyData ( $msg, 'image' );
	}
	/* 回复语音消息 */
	public function replyVoice($media_id) {
		$msg ['Voice'] ['MediaId'] = $media_id;
		$msg ['Voice'] ['MediaId'] = $media_id;
		$this->_replyData ( $msg, 'voice' );
	}
	/* 回复视频消息 */
	public function replyVideo($media_id, $title = '', $description = '') {
		$msg ['Video'] ['MediaId'] = $media_id;
		$msg ['Video'] ['Title'] = $title;
		$msg ['Video'] ['Description'] = $description;
		$this->_replyData ( $msg, 'video' );
	}
	/* 回复音乐消息 */
	public function replyMusic($media_id, $title = '', $description = '', $music_url, $HQ_music_url) {
		$msg ['Music'] ['ThumbMediaId'] = $media_id;
		$msg ['Music'] ['Title'] = $title;
		$msg ['Music'] ['Description'] = $description;
		$msg ['Music'] ['MusicURL'] = $music_url;
		$msg ['Music'] ['HQMusicUrl'] = $HQ_music_url;
		$this->_replyData ( $msg, 'music' );
	}
	/*
	 * 回复图文消息 articles array 格式如下： array( array('Title'=>'','Description'=>'','PicUrl'=>'','Url'=>''), array('Title'=>'','Description'=>'','PicUrl'=>'','Url'=>'') );
	 */
	public function replyNews($articles) {
		$msg ['ArticleCount'] = count ( $articles );
		$msg ['Articles'] = $articles;
		
		$this->_replyData ( $msg, 'news' );
	}
	/* 发送回复消息到微信平台 */
	private function _replyData($msg, $msgType) {
		$msg ['ToUserName'] = $this->data ['FromUserName'];
		$msg ['FromUserName'] = $this->data ['ToUserName'];
		$msg ['CreateTime'] = time();
		$msg ['MsgType'] = $msgType;
		
		$xml = new \SimpleXMLElement ( '<xml></xml>' );
		$this->_data2xml ( $xml, $msg );
		$str = $xml->asXML ();
		
		// 记录日志
		//addWeixinLog ( $str, '_replyData' );
		
		if (isset($_GET ['encrypt_type']) && $_GET ['encrypt_type'] == 'aes') {
			$sEncryptMsg = ""; // xml格式的密文
			$errCode = $this->wxcpt->EncryptMsg ( $str, $this->sReqTimeStamp, $this->sReqNonce, $sEncryptMsg );
			if ($errCode == 0) {
				$str = $sEncryptMsg;
			} else {
				//addWeixinLog ( $str, "EncryptMsg Error: " . $errCode );
			}
		}
		
		echo ($str);
	}

	/* 组装xml数据 */
	public function _data2xml($xml, $data, $item = 'item') {
		foreach ( $data as $key => $value ) {
			is_numeric ( $key ) && ($key = $item);
			if (is_array ( $value ) || is_object ( $value )) {
				$child = $xml->addChild ( $key );
				$this->_data2xml ( $child, $value, $item );
			} else {
				if (is_numeric ( $value )) {
					$child = $xml->addChild ( $key, $value );
				} else {
					$child = $xml->addChild ( $key );
					$node = dom_import_simplexml ( $child );
					$node->appendChild ( $node->ownerDocument->createCDATASection ( $value ) );
				}
			}
		}
	}
	/* ========================发送被动响应消息 end================================== */
	/* 上传多媒体文件 */
	public function uploadFile($file, $type = 'image', $acctoken = '') {
		$post_data ['type'] = $type; // 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
		$post_data ['media'] = $file;
		
		$url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=$acctoken&type=image";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
		ob_start ();
		curl_exec ( $ch );
		$result = ob_get_contents ();
		ob_end_clean ();
		
		return $result;
	}
	/* 下载多媒体文件 */
	public function downloadFile($media_id, $acctoken = '') {
		// TODO
	}
	/**
	 * GET 请求
	 *
	 * @param string $url        	
	 */
	private function http_get($url) {
		$oCurl = curl_init ();
		if (stripos ( $url, "https://" ) !== FALSE) {
			curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYHOST, FALSE );
		}
		curl_setopt ( $oCurl, CURLOPT_URL, $url );
		curl_setopt ( $oCurl, CURLOPT_RETURNTRANSFER, 1 );
		$sContent = curl_exec ( $oCurl );
		$aStatus = curl_getinfo ( $oCurl );
		curl_close ( $oCurl );
		if (intval ( $aStatus ["http_code"] ) == 200) {
			return $sContent;
		} else {
			return false;
		}
	}
	
	/**
	 * POST 请求
	 *
	 * @param string $url        	
	 * @param array $param        	
	 * @return string content
	 */
	private function http_post($url, $param) {
		$oCurl = curl_init ();
		if (stripos ( $url, "https://" ) !== FALSE) {
			curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYHOST, false );
		}
		if (is_string ( $param )) {
			$strPOST = $param;
		} else {
			$aPOST = array ();
			foreach ( $param as $key => $val ) {
				$aPOST [] = $key . "=" . urlencode ( $val );
			}
			$strPOST = join ( "&", $aPOST );
		}
		curl_setopt ( $oCurl, CURLOPT_URL, $url );
		curl_setopt ( $oCurl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $oCurl, CURLOPT_POST, true );
		curl_setopt ( $oCurl, CURLOPT_POSTFIELDS, $strPOST );
		$sContent = curl_exec ( $oCurl );
		$aStatus = curl_getinfo ( $oCurl );
		curl_close ( $oCurl );
		if (intval ( $aStatus ["http_code"] ) == 200) {
			return $sContent;
		} else {
			return false;
		}
	}

    //地址位置转换 wgs-84 to gcj-02
    private function wgstogcj($wgsLat, $wgsLon) {
        if ($wgsLon < 72.004 || $wgsLon > 137.8347){
            return array('lat' => $wgsLat, 'lon' => $wgsLon);
        }elseif($wgsLat < 0.8293 || $wgsLat > 55.8271){
            return array('lat' => $wgsLat, 'lon' => $wgsLon);
        }
        $PI = 3.14159265358979324;
        $a = 6378245.0;//  a: 卫星椭球坐标投影到平面地图坐标系的投影因子。
        $ee = 0.00669342162296594323;//  ee: 椭球的偏心率。
        $dLat = $this->transformLat($wgsLon - 105.0, $wgsLat - 35.0);
        $dLon = $this->transformLon($wgsLon - 105.0, $wgsLat - 35.0);
        $radLat = $wgsLat / 180.0 * $PI;
        $magic = sin($radLat);
        $magic = 1 - $ee * $magic * $magic;
        $sqrtMagic = sqrt($magic);
        $dLat = ($dLat * 180.0) / (($a * (1 - $ee)) / ($magic * $sqrtMagic) * $PI);
        $dLon = ($dLon * 180.0) / ($a / $sqrtMagic * cos($radLat) * $PI);
        return array('lat' => $wgsLat + $dLat,'lon' => $wgsLon + $dLon);
    }
    private function transformLat($x, $y) {
        $PI = 3.14159265358979324;
        $ret = -100.0 + 2.0 * $x + 3.0 * $y + 0.2 * $y * $y + 0.1 * $x * $y + 0.2 * sqrt(abs($x));
        $ret += (20.0 * sin(6.0 * $x * $PI) + 20.0 * sin(2.0 * $x * $PI)) * 2.0 / 3.0;
        $ret += (20.0 * sin($y * $PI) + 40.0 * sin($y / 3.0 * $PI)) * 2.0 / 3.0;
        $ret += (160.0 * sin($y / 12.0 * $PI) + 320 * sin($y * $PI / 30.0)) * 2.0 / 3.0;
        return $ret;
    }
    private function transformLon($x, $y) {
        $PI = 3.14159265358979324;
        $ret = 300.0 + $x + 2.0 * $y + 0.1 * $x * $x + 0.1 * $x * $y + 0.1 * sqrt(abs($x));
        $ret += (20.0 * sin(6.0 * $x * $PI) + 20.0 * sin(2.0 * $x * $PI)) * 2.0 / 3.0;
        $ret += (20.0 * sin($x * $PI) + 40.0 * sin($x / 3.0 * $PI)) * 2.0 / 3.0;
        $ret += (150.0 * sin($x / 12.0 * $PI) + 300.0 * sin($x / 30.0 * $PI)) * 2.0 / 3.0;
        return $ret;
    }
    //速8 接入第三方
    private function subaMsg($openid,$content,$inter_id='a455510007'){
		$this->load->library('MYLOG');
		MYLOG::w('微信内容|'.json_encode($content),'subamsg');
        //根据openid查一次 uuid
        $uuid = $this->db->get_where('subaopenid_uuid',array('openid'=>$openid))->row_array()['uuid'];
        if(empty($uuid)){
            //没有新生一个
            $uuid = $this->subaCreateUuid();
            $insert = $this->db->insert('subaopenid_uuid',array('openid'=>$openid,'uuid'=>$uuid));
            if(!$insert){
                echo 'error';
                die;
            }
        }
        $this->load->helper('common');
        $url = "http://api.0mzl.com/channel_message";
        $header = array('Content-Type'=>'application/json');
        $client_secret = 'UXQEdyOPqFl7zUKmXrLNGeCSffyvd6e5jaI7kmUh';
        $message = array(
            'channel_uuid'=>'91f40ca7-cfa2-4c83-b193-35002cb90922',
            'service_uuid' => '',
            'user_uuid' => $uuid,
            'type'=>'text',
          //  'data'=>array('text'=>$content),
            'time'=> $this->msectime(),
        );
		if($content['MsgType'] == 'text'){
			$message['data'] = array('text'=>$content['Content']);
		}elseif($content['MsgType'] == 'voice'){
			$this->load->model ( 'wx/access_token_model' );
			$access_token = $this->access_token_model->get_access_token ( $inter_id );
			$wxurl = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$content['MediaId'];
			$get_res = file_get_contents($wxurl);
			$getresdata = json_decode($get_res,true);
			if( $getresdata && isset($getresdata['errcode']) && ($getresdata['errcode'] == '40001' || $getresdata['errcode'] == '42001')){//过期  重新获取一次
				MYLOG::w('第一次授权失败|'.json_encode($get_res),'subamsg');
				$access_token = $this->access_token_model->reflash_access_token ( $inter_id );//只刷新一次
				$wxurl = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$content['MediaId'];
				$get_res = file_get_contents($wxurl);
				$getresdata = json_decode($get_res,true);

			}
			//如果还存在就退出了
			if($getresdata && isset($getresdata['errcode'])){
				return false;
			}

			MYLOG::w('get_res|'.json_encode($get_res),'subamsg');
			$audio_data = base64_encode($get_res);
			$array = array(
				'text'=>'',
				'audio'=>array(
					"format"=> "amr",
        			"rate"=> "8000",
        			"channel"=> 1,
        			"decode"=>"base64",
					"data" => $audio_data,
				)
			);
			$message['data'] = $array;
		}
        $sign = $this->subaSignature($message['channel_uuid'],$message['service_uuid'],$message['user_uuid'],$message['time'],$client_secret);
        $param = array('message'=>$message,
            'signature'=>$sign
        );

		MYLOG::w('params|'.json_encode($param),'subamsg');
		//var_dump(json_encode($content));die;
        $res = doCurlPostRequest($url,json_encode($param),$header);
        MYLOG::w('res|'.json_encode($res),'subamsg');
        return $res;
    }

    //速8接入零秒云 签名
    private function subaSignature($channel_uuid,$service_uuid='',$user_uuid,$time,$client_secret){
        $str = $channel_uuid;
        if(!empty($service_uuid)){
        	$str .= $service_uuid.$user_uuid.$time;
        }else{
        	$str .= $user_uuid.$time;
        }
        $sign = hash_hmac('sha256',$str,$client_secret);
        return $sign;
    }
    //s速8生成用户唯一码
    private function subaCreateUuid(){
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,
            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
    //返回毫秒数
    private function msectime() {
        list($tmp1, $tmp2) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($tmp1) + floatval($tmp2)) * 1000);
    }
	
	
}