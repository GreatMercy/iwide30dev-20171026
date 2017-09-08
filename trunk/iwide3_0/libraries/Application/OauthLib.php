<?php

namespace Application\libraries;

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
    public static function create_oauth_code($app_id) {
        return sha1 ( self::createNoncestr () . $app_id . microtime ( ) );
    }
    public static function create_accesstoken($app_id) {
    }
    public static function create_session_key($app_id) {
        return sha1 ( uniqid ( self::createNoncestr (), TRUE ) . microtime ( true ) . $app_id );
    }
    public static function create_granted_key($app_id) {
        return sha1 ( $app_id . uniqid ( self::createNoncestr ( 16 ), TRUE ) . microtime ( true ) );
    }
    /**
     * 产生随机字符串，默认32位
     * @param number 长度
     * @return string
     */
    public static function createNoncestr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = "";
        $char_length = strlen ( $chars ) - 1;
        for($i = 0; $i < $length; $i ++) {
            $str .= substr ( $chars, mt_rand ( 0, $char_length ), 1 );
        }
        return $str;
    }
    public static function format_query_para_map($para_map, $urlencode) {
        $buff = "";
        ksort ( $para_map );
        foreach ( $para_map as $k => $v ) {
            if ($urlencode) {
                $v = urlencode ( $v );
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar=NULL;
        if (strlen ( $buff ) > 0) {
            $reqPar = substr ( $buff, 0, strlen ( $buff ) - 1 );
        }
        return $reqPar;
    }
    /**
     * 签名方法
     * @param Array 参与签名的数组对象
     * @param string 参与签名的token
     * @return string 签名结果
     */
    public static function get_sign($parameters, $sign_key = '') {
        ksort ( $parameters );
        $String = self::format_query_para_map ( $parameters, false );
        if (! empty ( $sign_key ))
            $String = $String . "&key=" . $sign_key;
        $String = sha1 ( $String );
        $result_ = strtoupper ( $String );
        return $result_;
    }
}