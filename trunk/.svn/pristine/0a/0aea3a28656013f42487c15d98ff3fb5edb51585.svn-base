<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Authorize extends MY_Application_Admin_Iapi {
    public function __construct() {
        parent::__construct ();
    }
    public function get_access_token() {
        $app_id = $this->get_source ( 'app_id' );
        $app_sercet = $this->get_source ( 'app_sercet' );
    }
    public function login_session() {
        $code = $this->input->get ( 'code' );
        if (! $code) {
            echo 'no code';
            exit ();
        }
        echo json_encode(array (
                'session_key' => '',
                'granted_key' => '',
                'userinfo' => array () 
        ));
    }
}
