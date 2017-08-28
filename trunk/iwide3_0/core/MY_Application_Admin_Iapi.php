<?php
// use App\libraries\Iapi\InterfaceAdminLib;
class MY_Application_Admin_Iapi extends MY_Controller {
    protected $module = '';
    protected $controller = '';
    protected $action = '';
    protected $source = '';
    protected $iuri = '';
    protected $app_info = array ();
    protected $app_id = '';
    private $_session_key = '';
    protected $application_session_driver;
    // 初始化
    public function __construct() {
        parent::__construct ();
        $this->_init_router ();
        $this->load->library ( 'Application/ApplicationAdminLib' );
        // $this->load->library('Iapi/CommonLib');
        $this->_init_params ();
        if (ApplicationAdminLib::enums ( 'valify_appinfo_url', NULL, $this->iuri )) {//检查app_id以及app_secret
            $this->check_app_info ();
        }
        if (! $this->app_info && ApplicationAdminLib::enums ( 'valify_appid_url', NULL, $this->iuri )) {//检查app_id
            $this->check_app_id ();
        }
        if (! ApplicationAdminLib::enums ( 'no_login_session_url', NULL, $this->iuri )) {//检查是否有登录态
            $this->check_login_session ();
        }
        if (ApplicationAdminLib::enums ( 'valify_accesstoken_url', NULL, $this->iuri )) {//检查accesstoken
            $this->check_app_accesstoken ();
        }
    }
    protected function _base_input_valid() {
        if ($this->source) {
            if (! isset ( $source ['signature'] )) {
                $this->out_put_msg ( FALSE, 'Invalid Signature' );
            }
            $sign = $source ['signature'];
            unset ( $source ['signature'] );
            $this->load->model ( 'interface/Isigniture_model' );
            $token = $this->get_inter_id_token ( $source ['itd'] );
            if (empty ( $token )) {
                $this->out_put_msg ( FALSE, 'Invalid Parameter "itd"' );
            }
            $signature = $this->Isigniture_model->get_sign ( $source, $token );
            if ($sign != $signature) {
                $this->out_put_msg ( FALSE, 'Signiture error' );
            }
            if (empty ( $this->source ['inter_id'] )) {
                $this->out_put_msg ( 1 );
            }
            $this->inter_id = $this->get_source ( 'inter_id', '', FALSE );
            $nobug = $this->get_source ( 'nobug', '', FALSE );
            $this->inter_id = substr ( $this->inter_id, 0, 10 );
            if (($this->action !== 'wx_login') && ($this->debug !== TRUE || empty ( $nobug ))) {
                if (empty ( $this->source ['token'] )) {
                    $this->out_put_msg ( 4 );
                }
                $this->token = $this->get_source ( 'token', '', FALSE );
                if ($this->module == 'user' && $this->action == 'login') {
                    $this->fans_ext = $this->get_token_session ( $this->inter_id, $this->token, 'login' );
                } else {
                    $this->fans_ext = $this->get_token_session ( $this->inter_id, $this->token, 'db' );
                }
                if (empty ( $this->fans_ext ['wxapp_openid'] )) {
                    $this->out_put_msg ( 4 );
                }
            }
        } else {
            $this->out_put_msg ( 1 );
            exit ();
        }
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
     * @param string $filter 过滤函数 按需添加
     * @param string $in TRUE 在send_data中取,FALSE 在外层数据取
     * @return NULL|mixed
     */
    protected function get_source($index = '', $xss_clean = FALSE, $in = TRUE) {
        if ($index === '')
            return $this->source;
        if ($in)
            $value = isset ( $this->source ['data'] [$index] ) ? $this->source ['data'] [$index] : NULL;
        else
            $value = isset ( $this->source [$index] ) ? $this->source [$index] : NULL;
        return ($xss_clean === TRUE) ? $this->security->xss_clean ( $value ) : $value;
    }
    /**获得对应session_key的session数据
     * @param string $key
     * @return mixed|NULL|mixed|NULL
     */
    protected function user_session($key = '') {
        $session_driver = $this->get_session_driver ();
        $data = $session_driver->get ( $this->create_user_session_key () );
        if (! empty ( $data )) {
            $data = json_decode ( $data, TRUE );
            if ($key === '') {
                return $data;
            }
            return empty ( $data [$key] ) ? NULL : $data [$key];
        }
        return NULL;
    }
    /**获得对应session_key的session数据
     * @param string $key
     * @return mixed|NULL|mixed|NULL
     */
    protected function check_user_session($valify_session_key) {
        $session_driver = $this->get_session_driver ();
        $data = $session_driver->get ( $this->app_id . '_' . $valify_session_key );
        if (! empty ( $data ) && json_decode ( $data, TRUE )) 
            return TRUE;
        return FALSE;
    }
    protected function create_user_session_key() {
        return $this->app_id . '_' . $this->session_key;
    }
    /**设置对应session_key的session数据，值为json字符串，取时先拿出来decode再赋值
     * @param unknown $app_id
     * @param unknown $session_key
     * @param unknown $key
     * @param unknown $value
     * @param unknown $time
     * @return boolean
     */
    protected function set_user_session($app_id, $session_key, $key, $value, $time = NULL) {
        $session_driver = $this->get_session_driver ();
        $origin = $this->user_session ( $app_id, $session_key );
        empty ( $origin ) ? $origin = array (
                $key => $value 
        ) : $origin [$key] = $value;
        if ($session_driver->set ( $this->create_user_session_key (), json_encode ( $origin ), $time ))
            return TRUE;
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
        $this->module = $segments [3];
        $this->controller = isset ( $segments [4] ) ? $segments [4] : 'index';
        $this->action = isset ( $segments [5] ) ? $segments [5] : 'index';
        $this->iuri = $this->api_type . '/' . $this->api_ver . '/' . $this->module . '/' . $this->controller . '/' . $this->action;
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
        $check = $this->Application_info_model->valify_app_info ( $app_id, $app_secret );
        if ($check) {
            $this->app_info = $check;
            $this->app_id = $check ['app_id'];
            return;
        }
        echo 'invalid application';
        exit;
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
            return;
        }
        echo 'invalid application';
        exit;
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
        if (! $this->check_user_session ($session_key)) {
            echo 'not login';
            exit ();
        }
        $this->_session_key = $_session_key;
    }
}
