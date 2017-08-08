<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Access_token_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	const ACCESS_TOKEN  = 0;
	const API_TICKET    = 1;
	const CARD_TICKET   = 2;
	const ADDRESS_TOKEN = 4;
	
	function create($array) {
		return $this->db->insert ( 'access_tokens', $array );
	}
	function update($array) {
		$this->db->where ( array (
				'inter_id' => $array ['inter_id'],
				'type'     => $array ['$type'] 
		) );
		return $this->db->update ( 'access_tokens', $array );
	}
	/**
	 * 获取access_token
	 * @param $inter_id 公众号ID
	 * @return unknown|string
	 */
	function get_access_token($inter_id,$return_expire_time = FALSE,$type='weixin') {
		if ($type=='wxapp'){
			return $this->get_wxa_access_token($inter_id,$return_expire_time);
		}
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'type'     => self::ACCESS_TOKEN 
		) );
		$this->db->limit ( 1 );
		$access_token_query = $this->db->get ( 'access_tokens' );
		if ($access_token_query->num_rows () > 0) {
			$access_token = $access_token_query->row_array ();
			if (time () - $access_token ['expire'] < 7200) {
				if (! $return_expire_time) {
					return $access_token ['access_token'];
				} else {
					return array ('access_token' => $access_token ['access_token'],'expire' => $access_token ['expire'] + 7200 );
				}
			}
		}
		$this->load->model ( 'wx/publics_model' );
		$this->load->helper ( 'common' );
		$public_details = $this->publics_model->get_public_by_id ( $inter_id );
		
		/** 将固定获取access_token 改为根据inter_id 判断获取  by libinyan
		$appid          = $public_details ['app_id'];
		$secret         = $public_details ['app_secret'];
		$url            = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret;
		$data           = doCurlGetRequest ( $url );
		$data           = json_decode ( $data, true );
		*/
		$data= $this->get_access_token_divider($public_details);
		
		$time 			= time ();
		if (isset($data ['access_token']) && $data ['access_token']) {
			$this->db->replace ( 'access_tokens', array (
					'inter_id'     => $inter_id,
					'access_token' => $data ['access_token'],
					'expire'       => $time,
					'type'         => self::ACCESS_TOKEN 
			) );
			if(!$return_expire_time){
				return $data ['access_token'];
			}else {
				return array('access_token'=>$data ['access_token'],'expire'=>$time + 7200);
			}
		} else {
			return "error";
		}
	}
	public function get_access_token_divider($public_details){
        $this->load->helper ( 'common' );
	    $appid = $public_details ['app_id'];
	    $secret= $public_details ['app_secret'];
	    
	    switch ($public_details ['inter_id']) { 
	        case 'a453956624':
	            /** Calling Domo
	             * https://uat.digital.kargocard.com/CHolder/control/token?grant_type=client_credential&appid=wx5f969321cf58a9d5&secret=32e64d96956c200d19524698c3f59bc6&signature=17db36f866eb221a6078190efc3139916f73dcd74cb903d584c9bc7fd3cf24a8cb12d9ce71953ef58d7b60f6eb11b05f9b8f24e562da8e0d561b3e9367a8d40b4c98d9bf85188f200cd70d97b8dd8aa95f3ae55845fc9a642fd296a56ed7610b
    	         */
    		    $base_string= "grant_type=client_credential&appid=" . $appid. "&secret=" . $secret;
    	        $this->load->library('Mall/Lib_kargo');
    		    $signature= Lib_kargo::inst()->encrytion( $base_string );
    		    $api_url= Lib_kargo::inst()->get_token_api_url();
	            $url  = $api_url. "?". $base_string. "&signature=". $signature;
	            $data = doCurlGetRequest ( $url );
	            $data = json_decode ( $data, true );
    	        break;
	        
	        default:
        	    $url   = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret;
        	    $data  = doCurlGetRequest ( $url );
        	    $data  = json_decode ( $data, true );
	            break;
	    }
	    return $data;
	}
	function reflash_access_token($inter_id,$return_expire_time = FALSE,$type='public') {
        if ($type=='wxapp'){
			return $this->refresh_wxa_access_token($inter_id,$return_expire_time);
		}
		$this->load->model ( 'wx/publics_model' );
		$public_details = $this->publics_model->get_public_by_id ( $inter_id );
		$appid = $public_details ['app_id'];
		$secret = $public_details ['app_secret'];
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $secret;
		$this->load->helper ( 'common' );
		$data = doCurlGetRequest ( $url );
		$data = json_decode ( $data, true );
		$time = time ();
		if (isset($data ['access_token']) && $data ['access_token']) {
			$this->db->replace ( 'access_tokens', array (
					'inter_id'     => $inter_id,
					'access_token' => $data ['access_token'],
					'expire'       => $time,
					'type'         => self::ACCESS_TOKEN 
			) );
			if(!$return_expire_time)
				return $data ['access_token'];
			else 
				return array('access_token'=>$data ['access_token'],'expire'=>$time + 7200);
		} else {
			return "error";
		}
	}
	/**
	 * 共享收货地址accesstoken获取
	 * 
	 * @param unknown $inter_id        	
	 * @return unknown|string
	 */
	function get_address_token($inter_id) {
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'type' => self::ADDRESS_TOKEN 
		) );
		$this->db->limit ( 1 );
		$access_token_query = $this->db->get ( 'access_tokens' );
		if ($access_token_query->num_rows () > 0) {
			$access_token = $access_token_query->row_array ();
			if (time () - $access_token ['expire'] < 7200) {
				return $access_token ['access_token'];
			}
		}
		$this->load->model ( 'wx/publics_model' );
		$public_details = $this->publics_model->get_public_by_id ( $inter_id );
		$appid = $public_details ['app_id'];
		$secret = $public_details ['app_secret'];
		
		$this->load->helper ( 'common' );
		$data = doCurlGetRequest ( $url );
		$data = json_decode ( $data, true );
		if ($data ['access_token']) {
			$this->db->replace ( 'access_tokens', array (
					'inter_id' => $inter_id,
					'access_token' => $data ['access_token'],
					'expire' => time (),
					'type' => self::ACCESS_TOKEN 
			) );
			return $data ['access_token'];
		} else {
			return "error";
		}
	}
	function get_api_ticket($inter_id) {
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'type' => self::API_TICKET 
		) );
		$this->db->limit ( 1 );
		$query = $this->db->get ( 'access_tokens' );
		if ($query->num_rows () > 0) {
			$query = $query->row_array ();
			if (time () - $query ['expire'] < 7200) {
				return $query ['access_token'];
			}
		}
		$accessToken = $this->get_access_token ( $inter_id );
		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
		$this->load->helper ( 'common' );
		$res = json_decode ( doCurlGetRequest ( $url ) );
		$ticket = empty($res->ticket)?'':$res->ticket;
		if ($ticket) {
			$this->db->replace ( 'access_tokens', array (
					'inter_id' => $inter_id,
					'access_token' => $ticket,
					'expire' => time (),
					'type' => self::API_TICKET 
			) );
		}
		return $ticket;
	}
	function get_card_ticket($inter_id,$continue = true) {
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'type' => self::CARD_TICKET 
		) );
		$this->db->limit ( 1 );
		$query = $this->db->get ( 'access_tokens' );
		if ($query->num_rows () > 0) {
			$query = $query->row_array ();
			if (time () - $query ['expire'] < 7200) {
				return $query ['access_token'];
			}
		}
		$accessToken = $this->get_access_token ( $inter_id );
		$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $accessToken . '&type=wx_card';
		$this->load->helper ( 'common' );
		$res = json_decode ( doCurlGetRequest ( $url ) );
		if($res->errcode && $continue){
			$this->reflash_access_token($inter_id);
			return $this->get_card_ticket($inter_id,FALSE);
		}
		if (isset($res->ticket)) {
			$this->db->replace ( 'access_tokens', array (
					'inter_id' => $inter_id,
					'access_token' => $res->ticket,
					'expire' => time (),
					'type' => self::CARD_TICKET 
			) );
		}
		return $res->ticket;
	}
	private function get_ticket($inter_id,$type){
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'type' => $type
		) );
		$this->db->limit ( 1 );
		$query = $this->db->get ( 'access_tokens' );
		if ($query->num_rows () > 0) {
			$query = $query->row_array ();
			if (time () - $query ['expire'] < 7200) {
				return $query ['access_token'];
			}
		}
		$accessToken = $this->get_access_token ( $inter_id );
		$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $accessToken . '&type=wx_card';
		$this->load->helper ( 'common' );
		$res = json_decode ( doCurlGetRequest ( $url ) );
		$ticket = $res->ticket;
		if ($ticket) {
			$this->db->replace ( 'access_tokens', array (
					'inter_id' => $inter_id,
					'access_token' => $ticket,
					'expire' => time (),
					'type' => self::CARD_TICKET
			) );
		}
		return $ticket;
	}

	public function reflash_ticket_force($inter_id, $type=FALSE)
	{
	    if ( $type==FALSE ) $type= self::API_TICKET;
	    if($type== self::API_TICKET ){
	        $accessToken = $this->get_access_token ( $inter_id );
	        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
	        $this->load->helper ( 'common' );
	        $res = json_decode ( doCurlGetRequest ( $url ) );
	        $ticket = empty($res->ticket)?'':$res->ticket;
	        if ($ticket) {
	            $this->db->replace ( 'access_tokens', array (
	                'inter_id' => $inter_id,
	                'access_token' => $ticket,
	                'expire' => time (),
	                'type' => self::API_TICKET
	            ) );
	        }
	        return $ticket;
	    }
	}
	
	private function __get_ticket($inter_id,$type){
		$this->load->model ( 'wx/publics_model' );
		$this->load->helper ( 'common' );
		$res_ticket = '';
		switch ($type){
			case 0:
				$public_details = $this->publics_model->get_public_by_id ( $inter_id );
				$url            = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $public_details ['app_id'] . "&secret=" . $public_details ['app_secret'];
				$res            = json_decode (doCurlGetRequest ( $url ), true );
				$res_ticket     = $res['access_token'];
				break;
			case 1:
				$access_token = $this->get_access_token ( $inter_id );
				$url          = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$access_token";
				$res          = json_decode ( doCurlGetRequest ( $url ) );
				$res_ticket   = $res->ticket;
				break;
			case 2:
				$access_token = $this->get_access_token ( $inter_id );
				$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $access_token . '&type=wx_card';
				$this->load->helper ( 'common' );
				$res = json_decode ( doCurlGetRequest ( $url ) );
				$res_ticket   = $res->ticket;
				break;
		}
		if ($data ['access_token']) {
			$this->db->replace ( 'access_tokens', array (
					'inter_id'     => $inter_id,
					'access_token' => $res_ticket,
					'expire'       => time (),
					'type'         => $type 
			) );
			return $data ['access_token'];
		} else {
			return "error";
		}
	}
	
	public function getSignPackage($inter_id, $url = '') {
		$this->load->helper ( 'common_helper' );
		$this->load->model ( 'wx/Publics_model' );
		$jsapiTicket = $this->get_api_ticket ( $inter_id );
		$protocol = (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
		if (! $url)
			$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$timestamp = time ();
		$nonceStr = createNonceStr ();
		$public = $this->Publics_model->get_public_by_id ( $inter_id );
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
		
		$signature = sha1 ( $string );
		
		$signPackage = array (
				"appId" => $public ['app_id'],
				"nonceStr" => $nonceStr,
				"timestamp" => $timestamp,
				"url" => $url,
				"signature" => $signature,
				"rawString" => $string 
		);
		return $signPackage;
	}
	
	public function getCardPackage($cardId,$inter_id,$codes='',$openid='',$nonce_str = '',$timestamp = '') {
		if (empty ( $timestamp ))
			$timestamp = time ();
		if (empty ( $nonce_str ))
			$nonce_str = $this->createNonceStr ();
		
		$api_ticket = $this->get_card_ticket ( $inter_id );
		$this->load->helper ( 'common' );
		if ($codes && is_array ( $codes )) {
			foreach ( $codes as $code ) {
				$arrays = array ( $api_ticket, $timestamp, $cardId );
				if ($codes) {
					$arrays [] = $codes;
				}
				if ($openid) {
					$arrays [] = $openid;
				}
				sort( $arrays,SORT_LOCALE_STRING );
				$string = sha1(implode( $arrays ));
// 				$p = $this->getSignCard ( $cardId, $api_ticket, $codes );
				$tmpArray ['card_id'] = $cardId;
				$tmpArray ['card_ext'] = array ();
				$tmpArray ['card_ext'] ['code'] = $code;
				$tmpArray ['card_ext'] ['openid'] = $openid;
				$tmpArray ['card_ext'] ['timestamp'] = $timestamp;
				$tmpArray ['card_ext'] ['signature'] = $string;
				$tmpArray ['card_ext'] ['nonce_str'] = $nonce_str;
				$resultArray [] = $tmpArray;
			}
		} else {
			$arrays = array ( $api_ticket, $timestamp, $cardId, $codes );
			if ($openid) {
				$arrays [] = $openid;
			}
			sort( $arrays,SORT_LOCALE_STRING );
			$string = sha1(implode( $arrays ));
// 			$p = $this->getSignCard ( $cardId, $api_ticket, $codes );
			$tmpArray ['card_id'] = $cardId;
			$tmpArray ['card_ext'] = array ();
			$tmpArray ['card_ext'] ['code'] = $codes;
			$tmpArray ['card_ext'] ['openid'] = $openid;
			$tmpArray ['card_ext'] ['timestamp'] = $timestamp;
			$tmpArray ['card_ext'] ['signature'] = $string;
			$tmpArray ['card_ext'] ['nonce_str'] = $nonce_str;
			$resultArray [] = $tmpArray;
		}
		return $resultArray;
	}
	/**
	 * 产生随机字符串，不长于32位
	 * @param number 长度
	 * @return string
	 */
	function createNoncestr($length = 32) {
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$str = "";
		for($i = 0; $i < $length; $i ++) {
			$str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
		}
		return $str;
	}
	
	function get_wxa_access_token($inter_id,$return_expire_time = FALSE) {
		$token_type=22;
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'type'     => $token_type
		) );
		$this->db->limit ( 1 );
		$access_token = $this->db->get ( 'access_tokens' )->row_array();
		if ($access_token && time () - $access_token ['expire'] < 7200) {
			if (! $return_expire_time) {
				return $access_token ['access_token'];
			} else {
				return array ('access_token' => $access_token ['access_token'],'expire' => $access_token ['expire'] + 7200 );
			}
		}
		$this->load->model ( 'wx/publics_model' );
		$public_appinfo = $this->publics_model->get_wxapublic_info ( $inter_id );
	
		if(isset($public_appinfo)){
			$this->load->helper ( 'common' );
			$url   = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $public_appinfo['app_id'] . "&secret=" . $public_appinfo['app_secret'];
	        $data  = doCurlGetRequest ( $url );
	        $data  = json_decode ( $data, true );
		
			$time = time ();
			if (isset($data ['access_token']) && $data ['access_token']) {
				$this->db->replace ( 'access_tokens', array (
						'inter_id'     => $inter_id,
						'access_token' => $data ['access_token'],
						'expire'       => $time,
						'type'         => $token_type
				) );
				if(!$return_expire_time){
					return $data ['access_token'];
				}else {
					return array('access_token'=>$data ['access_token'],'expire'=>$time + 7200);
				}
			}
		}
		return FALSE;
	}
	
	function refresh_wxa_access_token($inter_id,$return_expire_time = FALSE) {
		$this->load->model ( 'wx/publics_model' );
		$public_details = $this->publics_model->get_wxapublic_info ( $inter_id );
		if (isset($public_details)){
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $public_details ['app_id'] . "&secret=" . $public_details ['app_secret'];
			$this->load->helper ( 'common' );
			$data = doCurlGetRequest ( $url );
			$data = json_decode ( $data, true );
			$time = time ();
			if (isset($data ['access_token']) && $data ['access_token']) {
				$this->db->replace ( 'access_tokens', array (
						'inter_id'     => $inter_id,
						'access_token' => $data ['access_token'],
						'expire'       => $time,
						'type'         => 22
				) );
				if(!$return_expire_time)
					return $data ['access_token'];
				else
					return array('access_token'=>$data ['access_token'],'expire'=>$time + 7200);
			}
		}
		return FALSE;
	}
}
