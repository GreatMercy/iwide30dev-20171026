<?php
class authorityLib {
    public static function creatValifyToken($params = array()) {
        return md5 ( self::createNoncestr () . microtime ( true ) );
    }
    public static function creatValifyToken3($params = array()) {
        return md5 ( self::createNoncestr () . microtime ( ) );
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
}