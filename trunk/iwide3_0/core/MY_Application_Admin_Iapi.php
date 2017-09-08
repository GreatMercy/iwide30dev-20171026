<?php
use App\libraries\Iapi\CommonLib;
use Application\libraries\ApplicationAdminConst;
use Application\libraries\OauthLib;
require_once APPPATH . "/libraries/Application/ApplicationAdminConst.php";
require_once APPPATH . "/libraries/Application/OauthLib.php";
class MY_Application_Admin_Iapi extends MY_Controller {
    protected $module = '';
    protected $controller = '';
    protected $action = '';
    protected $source = '';
    protected $iuri = '';
    protected $app_info = array ();
    protected $app_id = '';
    protected $session_key = '';
    private $_session_key = '';
    protected $application_session_driver;
    protected $logined = FALSE;
    private $_app_info;
    // 初始化
    public function __construct() {
        parent::__construct ();
        $this->_init_router ();
        $this->_init_params ();
        $this->check_app_id ();
        if (ApplicationAdminConst::enums ( 'valify_appinfo_url', NULL, $this->iuri )) { // 检查app_id以及app_secret
            $this->check_app_info ();
        }
        if (! ApplicationAdminConst::enums ( 'no_login_session_url', NULL, $this->iuri )) { // 检查是否有登录态
            $this->check_login_session ();
        }
        if (! ApplicationAdminConst::enums ( 'no_signature_url', NULL, $this->iuri )) { // 检查签名
            $this->check_signature ();
        }
        if (ApplicationAdminConst::enums ( 'valify_accesstoken_url', NULL, $this->iuri )) { // 检查accesstoken
            $this->check_app_accesstoken ();
        }
        $this->set_user_session('refresh_session_time', time());
    }
    protected function out_put_msg($result, $msg = '', $data = array(), $fun = '', $status_code = 200, $extra = array(), $msg_lv = 0, $exit = TRUE) {
        $this->output->set_status_header ( $status_code );
        echo json_encode ( CommonLib::create_put_msg ( 'application', $result, $msg, $data, $fun, $extra, $msg_lv ), JSON_UNESCAPED_UNICODE );
        if ($exit) {
            exit ();
        }
    }
    /**返回source中数据
     * @param string $index 数据在数组中下标
     * @param boolean $xss_clean 是否过滤
     * @param boolean $in TRUE 在data中取,FALSE 在外层数据取
     * @return NULL|mixed
     */
    protected function get_source($index = '', $xss_clean = TRUE, $in = TRUE) {
        if ($index === '')
            return $this->source;
        if ($in)
            $value = isset ( $this->source ['data'] [$index] ) ? $this->source ['data'] [$index] : NULL;
        else
            $value = isset ( $this->source [$index] ) ? $this->source [$index] : NULL;
        return ($xss_clean === TRUE) ? $this->security->xss_clean ( $value ) : $value;
    }
    /**获得对应session_key的session数据
     * @param string $key 传入空字符串时，返回全部未过期session值
     * @param boolean $all_real true且$key为''时，返回真实session值
     * @return mixed|NULL|mixed|NULL
     * 传入key为空时返回所有session数据，结构：array('key1'=>array('val'=>'session值','expt'=>'此值的有效时间戳'))
     * 传入key不为空：返回key对应session值（需存在且在有效期内，否则返回NULL)
     */
    protected function user_session($key = '', $all_real = FALSE) {
        $now = time ();
        $session_driver = $this->get_session_driver ();
        if (! $user_session_key = $this->create_user_session_key ()) {
            return NULL;
        }
        if ($key === '') {
            $data = $session_driver->hGetAll ( $user_session_key );
            if ($all_real) {
                return $data;
            }
            $valid_data = array ();
            foreach ( $data as $sk => $sv ) {
                $sv = json_decode ( $sv, TRUE );
                if ((! isset ( $sv ['expt'] ) || $sv ['expt'] >= $now) && isset ( $sv ['val'] )) {
                    $valid_data [$sk] = $sv ['val'];
                }
            }
            return $valid_data;
        } else {
            $data = $session_driver->hGet ( $user_session_key, $key );
            if ($data !== FALSE) {
                $data = json_decode ( $data, TRUE );
                if ((! isset ( $data ['expt'] ) || $data ['expt'] >= $now) && isset ( $data ['val'] )) {
                    return $data ['val'];
                }
            }
        }
        return NULL;
    }
    protected function check_user_session($valify_session_key) {
        $session_driver = $this->get_session_driver ();
        $data = $session_driver->hLen ( $this->app_id . '-apl-' . $valify_session_key );
        if (! empty ( $data ) && json_decode ( $data, TRUE ))
            return TRUE;
        return FALSE;
    }
    protected function create_user_session_key() {
        if (! $this->app_id || ! $this->_session_key)
            return NULL;
        return $this->app_id . '-apl-' . $this->_session_key;
    }
    protected function _init_session($session_key) {
        if ($this->controller == 'login' && $this->action == 'login_session') {
            $this->_session_key = $session_key;
        } else
            return FALSE;
    }
    /**设置对应session_key的session数据，使用redis hash
     * @param unknown $key
     * @param unknown $value
     * @param unknown $time
     * @return boolean
     */
    protected function set_user_session($key, $value, $time = NULL) {
        if (! $user_session_key = $this->create_user_session_key ()) {
            return FALSE;
        }
        $session_driver = $this->get_session_driver ();
        $value = json_encode ( array (
                'val' => $value,
                'expt' => isset ( $time ) ? time () + $time : NULL 
        ) );
        if ($session_driver->hSet ( $user_session_key, $key, $value )) {
            $session_driver->setTimeout ( $user_session_key, ApplicationAdminConst::SESSION_TTL );
            return TRUE;
        }
        return FALSE;
    }
    /**
     * 获取当前使用的session驱动
     */
    protected function get_session_driver() {
        if (! isset ( $this->application_session_driver )) {
            $this->load->library ( 'Cache/Redis_proxy', array (
                    'not_init' => FALSE,
                    'module' => 'application',
                    'refresh' => FALSE,
                    'environment' => ENVIRONMENT 
            ), 'redis_proxy' );
            $this->application_session_driver = $this->redis_proxy;
        }
        return $this->application_session_driver;
    }
    protected function _init_router() {
        $URI = & load_class ( 'URI', 'core', NULL );
        $segments = $URI->segments;
        $this->api_type = $segments [1];
        $this->api_ver = $segments [2];
        $this->module = $segments [4];
        $this->controller = isset ( $segments [5] ) ? $segments [5] : 'index';
        $this->action = isset ( $segments [6] ) ? $segments [6] : 'index';
        $this->iuri = $this->api_type . '/' . $this->api_ver . '/application/' . $this->module . '/' . $this->controller . '/' . $this->action;
        return;
    }
    private function _init_params() {
        $this->source = json_decode ( file_get_contents ( 'php://input' ), TRUE );
    }
    protected function check_app_info() {
        $app_id = $this->input->get ( 'app_id', TRUE );
        $app_secret = $this->input->get ( 'app_secret', TRUE );
        if (empty ( $app_id ) || empty ( $app_secret )) {
            echo 'invalid appinfo';
            exit ();
        }
        $this->load->model ( 'application/Application_info_model' );
        $check = $this->Application_info_model->valify_app_info ( $app_id, $app_secret, $this->_app_info );
        if ($check) {
            $this->app_info = $check;
            $this->app_id = $check ['app_id'];
            return;
        }
        echo 'invalid application';
        exit ();
    }
    protected function check_app_id() {
        $app_id = $this->input->get ( 'app_id', TRUE );
        if (empty ( $app_id )) {
            echo 'missing app_id';
            exit ();
        }
        $this->load->model ( 'application/Application_info_model' );
        $check = $this->Application_info_model->get_application ( $app_id, 1 );
        if ($check) {
            $this->app_info = array (
                    'app_id' => $check ['app_id'],
                    'app_name' => $check ['app_name'] 
            );
            $this->app_id = $check ['app_id'];
            $this->_app_info = $check;
            return;
        }
        echo 'invalid application';
        exit ();
    }
    protected function check_login_session() {
        if (empty ( $this->app_id )) {
            echo 'invalid app_id';
            exit ();
        }
        $session_key = $this->get_source ( 'session_key', TRUE, FALSE );
        if (empty ( $session_key )) {
            echo 'missing session_key';
            exit ();
        }
        if (! $this->check_user_session ( $session_key )) {
            echo 'not login';
            exit ();
        }
        $this->session_key = $session_key;
        $this->_session_key = $session_key;
        $this->logined = TRUE;
    }
    protected function check_signature() {
        if ($this->logined !== TRUE) {
            echo 'not authorized';
            exit ();
        }
        $signature = $this->get_source ( 'signature', TRUE, FALSE );
        if (! $signature) {
            echo 'missing signature';
            exit ();
        }
        if (empty ( $this->session_key )) {
            echo 'missing session_key';
            exit ();
        }
        $granted_key = $this->user_session ( 'granted_key' );
        if (! $granted_key) {
            echo 'not granted';
            exit ();
        }
        $parameters = isset ( $this->source ['data'] ) ? $this->source ['data'] : array ();
        if ($signature !== OauthLib::get_sign ( $parameters, $granted_key )) {
            echo 'wrong signature';
            exit ();
        }
    }
}
