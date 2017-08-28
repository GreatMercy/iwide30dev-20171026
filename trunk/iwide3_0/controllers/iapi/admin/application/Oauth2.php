<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Oauth2 extends MY_Application_Admin {
    public function __construct() {
        parent::__construct ();
    }
    public function login_session() {
        $code = $this->input->get ( 'code' );
        $app_id = $this->input->get ( 'app_id' );
        $app_sercet = $this->input->get ( 'app_sercet' );
    }
}
