<?php
use Application\libraries\OauthLib;
require_once APPPATH . "/libraries/Application/OauthLib.php";
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Login extends MY_Application_Admin_Iapi {
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
        // check code
        $this->load->model ( 'authority/Valify_tokens_model' );
        $token_check = $this->Valify_tokens_model->upGetToken ( 3, $code );
        if ($token_check ['s'] != 1) {
            switch ($token_check ['err']) {
                case 'none' :
                    echo 'invalid code';
                    exit ();
                    break;
                case 'used' :
                    echo 'code used';
                    exit ();
                    break;
                case 'expired' :
                    echo 'exprired code';
                    exit ();
                    break;
                default :
                    echo 'wtf code?';
                    exit ();
                    break;
            }
        }
        $user_info=json_decode($token_check['token']['valify_data'],TRUE);
        $session_key = OauthLib::inst ()->create_oauth_code ( $this->app_id );
        $granted_key = OauthLib::inst ()->create_granted_key ( $this->app_id );
        $this->_init_session ( $session_key );
        $this->set_user_session ( 'username', $user_info['username'] );
        $this->set_user_session ( 'granted_key', $granted_key );
        $this->set_user_session ( 'logined', 1 );
        $info = array (
                'session_key' => $session_key,
                'granted_key' => $granted_key 
        );
        $info ['userinfo'] = $user_info;
        echo json_encode ( $info );
    }
}
