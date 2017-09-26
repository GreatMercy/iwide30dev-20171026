<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Account extends MY_Application_Admin_Iapi {
    public function __construct() {
        parent::__construct ();
    }
    public function test_session() {
        // $this->set_user_session('test_sess', 1,30);
        $user_info = $this->user_session ( '' );
        $data = $this->get_source ();
        echo json_encode ( array (
                'session_data' => $user_info,
                'your_data' => $data 
        ) );
    }
    public function get_account_publics() {
    }
}
