<?php

// namespace App\libraries\Iapi;

class ApplicationAdminLib {
    private static $_objs = array (); // 对象容器
    public static $_common_url_param = array ();
    public static $_basic_param = array ();
    public function __construct() {
        $this->CI = & get_instance ();
    }
    public static function inst($className = __CLASS__) {
        if (isset ( self::$_objs [$className] )) {
            return self::$_objs [$className];
        } else {
            return self::$_objs [$className] = new $className ( null );
        }
    }
	public static $url_seg = array (
			'LOGIN_SESSION' => 'iapi/v1/application/authorize/login_session', // 获取授权
	);
	public static $valify_appinfo_url = array (
			'LOGIN_SESSION'
	);
	public static $no_login_session_url = array (
			'LOGIN_SESSION'
	);
	public static function enums($type, $key = NULL, $value = NULL) {
		switch ($type) {
			case 'valify_appinfo_url' :
				$data = self::abbr2seg(self::$valify_appinfo_url);
				break;
			case 'no_login_session_url' :
				$data = self::abbr2seg(self::$no_login_session_url);
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