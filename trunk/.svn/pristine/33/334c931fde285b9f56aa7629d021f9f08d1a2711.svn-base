<?php

// namespace App\libraries\Iapi;
class OauthLib {
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
    public function create_oauth_code($app_id) {
        return sha1 ( self::createNoncestr () . $app_id . microtime (true) );
    }
    public function create_accesstoken() {
    }
    public function create_session_key() {
    }
    public function create_granted_key() {
    }
    /**
     * 产生随机字符串，不长于32位
     * @param number 长度
     * @return string
     */
    function createNoncestr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = "";
        $char_length = strlen ( $chars ) - 1;
        for($i = 0; $i < $length; $i ++) {
            $str .= substr ( $chars, mt_rand ( 0, $char_length ), 1 );
        }
        return $str;
    }
}