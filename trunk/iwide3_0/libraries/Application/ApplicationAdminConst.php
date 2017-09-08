<?php

namespace Application\libraries;

class ApplicationAdminConst {
    public function __construct() {
        $this->CI = & get_instance ();
    }
    const SESSION_TTL=7200;
	public static $url_seg = array (
			'LOGIN_SESSION' => 'iapi/v1/application/authorize/login/login_session', // 获取授权
			'GET_ACCESS_TOKEN' => 'iapi/v1/application/authorize/get_access_token', // 获取授权
	);
	public static $valify_appinfo_url = array (
			'LOGIN_SESSION'
	);
	public static $no_login_session_url = array (
			'LOGIN_SESSION'
	);
	public static $no_signature_url = array (
			'LOGIN_SESSION'
	);
	public static $valify_appid_url = array (
			'GET_ACCESS_TOKEN'
	);
	public static function enums($type, $key = NULL, $value = NULL) {
		switch ($type) {
			case 'valify_appinfo_url' :
				$data = self::abbr2seg(self::$valify_appinfo_url);
				break;
			case 'no_login_session_url' :
				$data = self::abbr2seg(self::$no_login_session_url);
				break;
			case 'no_signature_url' :
				$data = self::abbr2seg(self::$no_signature_url);
				break;
			case 'valify_appid_url' :
				$data = self::abbr2seg(self::$valify_appid_url);
				break;
			default :
				$vars = get_class_vars ( __CLASS__ );
				$data = isset ( $vars [$type] ) ? $vars [$type] : NULL;
		}
		if (is_array ( $data )) {
			if (isset ( $key )) {
				return isset ( $data [$key] ) ? $data [$key] : NULL;
			}
			if (isset ( $value )) {
				return in_array ( $value, $data );
			}
		}
		return $data;
	}
	public static function abbr2seg($abbrs) {
		$data = array ();
		foreach ( $abbrs as $a ) {
			$data [] = isset ( self::$url_seg [$a] ) ? self::$url_seg [$a] : $a;
		}
		return $data;
	}
}