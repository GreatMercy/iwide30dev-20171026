<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
class Application_info_model extends MY_Model {
    function __construct() {
        parent::__construct ();
    }
    const TAB_APPLICATION = 'iwide_applications';
    public function get_application($app_id, $status = NULL) {
        $db = $this->_db ();
        $db->where ( 'app_id', $app_id );
        $status ? $db->where ( 'status', $status ) : $db->where_in ( 'status', array (
                1,
                2 
        ) );
        $db->limit ( 1 );
        return $db->get ( self::TAB_APPLICATION )->row_array ();
    }
    public function valify_app_info($app_id, $app_secret, $app_info = array()) {
        if (! $app_info) {
            $app_info = $this->get_application ( $app_id, 1 );
        }
        if ($app_info) {
            if ($app_secret === $this->real_app_secret ( $app_id, $app_info ['app_secret'] )) {
                return array (
                        'app_id' => $app_info ['app_id'],
                        'app_name' => $app_info ['app_name'] 
                );
            } else if ($app_secret == $app_info ['app_secret']) {
                MYLOG::w ( 'app_id:' . $app_id . ',app_name:' . $app_info ['app_name'] . ',数据库信息已泄漏', 'application/alarm', '_dbleak' );
            }
        }
        return FALSE;
    }
    public function real_app_secret($app_id, $app_secret) {
        return md5 ( $app_secret . hexdec ( substr ( $app_id, 2, 6 ) ) . $app_id );
    }
}