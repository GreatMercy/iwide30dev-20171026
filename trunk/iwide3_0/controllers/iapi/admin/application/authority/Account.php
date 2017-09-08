<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Account extends MY_Application_Admin_Iapi {
    public function __construct() {
        parent::__construct ();
    }
    public function get_account_publics() {
        $user_info=$this->user_session('',true);
        var_dump($user_info);
    }
}
