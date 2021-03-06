<?php

use App\controllers\front\traits\Controller;
use App\controllers\front\traits\Soma;

/**
 * Class MY_Front
 *
 * @property Publics_model $Publics_model
 * @property \CI_DB_mysqli_driver| \CI_DB_query_builder $db
 */
class MY_Front extends CI_Controller
{
    use Controller, Soma;

    public $inter_id;
    public $openid;
    public $public;

    protected $module = '';
    protected $controller = '';
    protected $action = '';

    /**
     * MY_Front constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->initMonoLog();

        $realid = substr($this->input->get('realid'), 0, 10);
        if ($realid) {//兼容拉卡拉前台回调id冲突
            $this->inter_id = $realid;
        }

        $this->inter_id = $this->input->get('id') ? substr($this->input->get('id'), 0, 10) : $this->session->userdata('inter_id');

        if (!$this->inter_id) {
            show_error('wrong url');
        } else {
            $this->session->set_userdata(array(
                'inter_id' => $this->inter_id,
            ));
        }

        //@Editor lGh 停服跳转
        $this->load->model('wx/Publics_model');
        $this->public = $this->Publics_model->get_public_by_id($this->inter_id);
        if (isset($this->public['run_status']) && $this->public['run_status'] === 'stop') {
            redirect(site_url('./upgrade_page'));
        }

        $this->_init_router();
        $this->_save_get_params($this->module, $this->controller);

        //$this->_reflash_ticket_force( $this->inter_id  );
        if (ENVIRONMENT === 'production') {
            //生产环境不能自定义openid
        } else {
            $openid = $this->input->get('openid');
            if (!empty($openid)) {
                $this->session->set_userdata(array(
                    $this->inter_id . 'openid' => $openid,
                ));
            }
        }

        $this->openid = $this->session->userdata($this->inter_id . 'openid');
        //MYLOG::soma_tracker($this->inter_id,$this->openid,0,"","tracker_debug");

        if (empty ($this->openid)) {

            if ($this->checkUseTwoTimesOuth()) {

                $this->twoTimesOuth();
                $this->openid = $this->session->userdata($this->inter_id . 'openid');

            } else {
                if (isset($_SERVER['SERVER_SOFTWARE']) && $_SERVER['SERVER_SOFTWARE'] == 'nginx') {
                    $refer = 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
                } else {
                    $refer = 'http://' . $_SERVER ['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
                }

                $this->_wx_redirect($this->inter_id, $refer);
            }
        }

    }

    /**
     * 针对卡购无法正常获取api_ticket 导致录音失败
     * @param unknown $inter_id
     */
    protected function _reflash_ticket_force($inter_id)
    {
        //非异步提交的情况下执行
        if (is_ajax_request()) {
            return true;
        }
        if ($inter_id == 'a453956624') {
            $this->load->model('wx/access_token_model');
            $ticket = $this->access_token_model->reflash_ticket_force($inter_id);

            return $ticket;
        }
    }

    /**
     * 对于需要跳转站外域名获取code的，根据inter_id 做区分跳转
     * @param unknown $inter_id
     * @param unknown $refer
     */
    protected function _wx_redirect($inter_id, $refer)
    {
        switch ($inter_id) {
            case 'a453956624':
                $p_callback = site_url('public_oauth/index') . '?id=' . $inter_id . '&refer=' . urlencode($refer);
                //echo $p_callback;die;
                $callback = base64_encode($p_callback);

                //$refer = 'http://uat.digital.kargotest.com/iwidemall?calbak='. $callback;
                $refer = 'http://mycard.kargocard.com/iwidemall?calbak=' . $callback;
                //echo $refer;die;
                //$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5f969321cf58a9d5&redirect_uri="
                $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx992e5c06624b1a6e&redirect_uri="
                    . urlencode($refer) . "&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
                //. urlencode ($refer)."&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
                //echo $url;die;
                redirect($url);
                break;

            default:
                redirect(site_url('public_oauth/index') . '?id=' . $inter_id . '&refer=' . urlencode($refer));
                break;
        }
    }

    /**
     * @param String module/function/view/hotel_id 当view和function同名时，view可忽略，hotel_id为当前方法访问的酒店id，没有可不传
     * @param Array data in view
     * @param Array $extra_preview
     * @param Array $extra_subview
     * @param string $return
     * $paras string module/function/view/hotel_id 当view和function同名时，view可忽略，hotel_id为当前方法访问的酒店id，没有可不传
     * $data array data in view
     * $custom_skin_name
     * $extra_views array('preview'=array(),'subview'=>array())
     * $return
     */
    protected function display($paras, $data, $skin = '', $extra_views = array(), $return = false)
    {
        if (empty($extra_views['module_view'])) {
            $view = $this->get_display_view($paras);
        } else {
            $view = $extra_views['module_view'];
        }
        $paras = explode('/', $paras);
        $paras [2] = empty ($paras [2]) ? $paras [1] : $paras [2];
        $paras[2] = str_replace('.', '/', $paras[2]);
        $paras [3] = empty ($paras [3]) ? 0 : $paras [3];
// 		$sql = "SELECT s.skin_name,s.overall_style,a.* from 
//              (SELECT * FROM " . $this->db->dbprefix ( 'view_skin_set' ) . " WHERE `inter_id` = '" . $this->inter_id . "' AND `status` = 1 AND `module` = '" . $paras [0] . "' AND `hotel_id` in (0, " . $paras [3] . ") order by hotel_id desc) s
//           	  left join  (SELECT * FROM " . $this->db->dbprefix ( 'view_disp_set' ) . " WHERE `inter_id` = '" . $this->inter_id . "' AND `module` = '" . $paras [0] . "' AND `func` = '" . $paras [1] . "' AND `status` = 1) a 
//                  ON s.inter_id = a.inter_id";
// 		$view = $this->db->query ( $sql )->row_array ();
        if (empty($skin)) {
            $skin = empty ($view ['skin_name']) ? 'default' : $view ['skin_name'];
        }
        if (empty($extra_views['view_subfix'])) {
            $subfix = empty ($view ['view_subfix']) ? '' : '_' . $view ['view_subfix'];
        } else {
            $subfix = '_' . $extra_views['view_subfix'];
        }
        $path = '/' . $paras [0] . '/' . $skin . '/';
        $data ['media_path'] = $paras [0] . '/' . $skin;
        $data ['extra_style'] = $view ['extra_style'];


        //统计代码
        //$this->load->model("statistics/Statistics_model");
        //$data['statistics_js'] = $this->Statistics_model->outputJs($this->inter_id,$this->openid);

        $data['statistics_js'] = '';


        $data ['overall_style'] = empty($view ['overall_style']) ? array() : json_decode($view['overall_style'], true);
        $more_preview = empty ($view ['extra_preview']) ? array() : explode(',', $view ['extra_preview']);
        $more_subview = empty ($view ['extra_subview']) ? array() : explode(',', $view ['extra_subview']);
        $extra_preview = empty ($extra_views ['preview']) ? $more_preview : array_merge($extra_views ['preview'], $more_preview);
        $extra_subview = empty ($extra_views ['subview']) ? $more_subview : array_merge($extra_views ['subview'], $more_subview);
        if (!empty ($extra_preview)) {
            foreach ($extra_preview as $ev) {
                $this->load->view($path . $ev . '.php', $data, $return);
            }
        }
        if ($return == true) {
            return $this->load->view($path . $paras [2] . $subfix . '.php', $data, $return);
        } else {
            $this->load->view($path . $paras [2] . $subfix . '.php', $data, $return);
        }
        if (!empty ($extra_subview)) {
            foreach ($extra_subview as $ev) {
                $this->load->view($path . $ev . '.php', $data, $return);
            }
        }
    }

    protected function get_display_view($paras)
    {
        $paras = explode('/', $paras);
        $paras [2] = empty ($paras [2]) ? $paras [1] : $paras [2];
        $paras [2] = str_replace('.', '/', $paras [2]);
        $paras [3] = empty ($paras [3]) ? 0 : $paras [3];
        $sql = "SELECT s.skin_name,s.overall_style,a.* from " . $this->db->dbprefix('view_skin_set') . " s
          	  left join " . $this->db->dbprefix('view_disp_set') . " a
                 ON s.inter_id = a.inter_id and s.module=a.module AND a.`func` = '" . $paras [1] . "' AND a.`status` = 1
          	  		WHERE s.`inter_id` = '" . $this->inter_id . "' AND s.`status` = 1 AND s.`module` = '" . $paras [0] . "' AND s.`hotel_id` in (0, " . $paras [3] . ") 
                 	 order by s.hotel_id desc limit 1";

        return $this->db->query($sql)->row_array();
    }

    /**
     * @author libinyan
     */
    protected function _init_router()
    {
        $segments = $this->uri->segments;
        $this->module = $segments[1];
        $this->controller = isset($segments[2]) ? $segments[2] : 'index';
        $this->action = isset($segments[3]) ? $segments[3] : 'index';

    }

    /**
     *  解决首次打开，经微信授权跳转后丢失 get参数的问题 （此方法设置后，运行频率极高，需注意程序的稳定性）
     * @author libinyan@mofly.cn
     */
    protected function _save_get_params($module = 'mall', $controller = 'wap')
    {
        if ($module) {
            switch ($module) {
                case 'mall':
                    //参数丢失问题已解决
                    /* if($controller=='wap'){
                        $saler    = $this->input->get('saler');
                        $fans_id  = $this->input->get('f');
                        $identity = $this->input->get('t');
                        //if($saler) $this->session->set_userdata( array('topic_saler' => $saler ) ); 
                        //if($fans_id) $this->session->set_userdata( array('topic_fans_id' => $fans_id ) ); 
                        if($identity) $this->session->set_userdata( array('topic_identity' => $identity ) );
                    } */
                    break;
                case 'privilege':
                    if ($controller == 'auth') {
                        $code = $this->input->get('code');
                        $key = $this->input->get('key');
                        if ($code) {
                            $this->session->set_userdata(array('authid_code' => $code));
                        }
                        if ($key) {
                            $this->session->set_userdata(array('authid_key' => $key));
                        }
                    }
                    break;
                case 'member':
                    if ($controller == 'pgetcard') {
                        $rid = $this->input->get('rid');
                        if ($rid) {
                            $this->session->set_userdata(array('wxcard_id' => $rid));
                        }
                    }
                    break;
                default:
                    return;
                    break;
            }
        }

        return;
    }

    /**
     * @author libinyan@mofly.cn
     */
    protected function _ftp_server($env = 'prod')
    {
        $this->load->library('ftp');
        if ($env == 'test') {
            $configftp['hostname'] = config_item('ftp_hostname');
            $configftp['username'] = config_item('ftp_username');
            $configftp['password'] = config_item('ftp_password');
            $configftp['passive'] = config_item('ftp_passive');
            $configftp['port'] = config_item('ftp_port');
            $configftp['debug'] = config_item('ftp_debug');
            $result = $this->ftp->connect($configftp);

            $this->ftp->floder = config_item('ftp_floder');
            $this->ftp->weburl = config_item('ftp_url');

            if ( ENVIRONMENT === 'production') {
                //生产环境不能开启debug模式
            } else {
                $this->ftp->debug = true;
            }
        } else {
            $configftp['hostname'] = config_item('ftphostname');
            $configftp['username'] = config_item('ftpusername');
            $configftp['password'] = config_item('ftppassword');
            $configftp['passive'] = config_item('ftppassive');
            $configftp['port'] = config_item('ftpport');
            $configftp['debug'] = config_item('ftpdebug');
            $result = $this->ftp->connect($configftp);

            $this->ftp->floder = config_item('ftpfloder');
            $this->ftp->weburl = config_item('ftpurl');

            if ( ENVIRONMENT === 'production') {
                //生产环境不能开启debug模式
            } else {
                $this->ftp->debug = true;
            }
        }

        //var_dump($this->ftp);
        return $this->ftp;
    }

    /**
     * @author libinyan@mofly.cn
     * @param  [type]  $content  [二维码内容]
     * @param  boolean $filename [生成图片名，文件名空则直接显示图片，不保存文件]
     * @param  integer $size [图片大小]
     * @param  integer $margin [白边举例]
     * @return [type]
     */
    public function _get_qrcode_png($content, $filename = false, $size = 5, $margin = 1, $base_path = false)
    {
        $this->load->helper('phpqrcode');
        if ($filename === false) {
            QRcode::png($content, false, 'Q', $size, $margin, true);

            return true;

        } else {
            if ($base_path == false) {
                $base_path = 'qrcode' . '/' . $this->module . '/' . $this->controller . '/' . $this->action;
            }
            $path = FCPATH . FD_PUBLIC . '/' . $base_path;
            //echo $path;die;
            if (!file_exists($path)) {
                @mkdir($path, 755, true);
            }
            $file = $path . '/' . $filename . '.png';
            //echo $file;die;
            QRcode::png($content, $file, 'Q', $size, $margin);

//ftp开始，初始化测试服务器ftp
            if ( ENVIRONMENT == 'production') {
                $this->ftp = $this->_ftp_server('prod');
            } else {
                $this->ftp = $this->_ftp_server('test');
            }
//$to_file = '/public_html'. $file_system_path;
            $to_file = $this->ftp->floder . FD_PUBLIC . '/' . $base_path . '/';
//echo $to_file;die;  //   /public_html/public/qrcode/mall/test/qr/
            $isdir = $this->ftp->list_files('./public_html/public/qrcode/mall');
            if (empty($isdir)) {
                $newpath = '/';
                $arrpath = explode('/', $to_file);
                foreach ($arrpath as $v) {
                    if ($v && $v != $this->ftp->floder) {
                        $newpath .= $v . '/';
                        $isdirchild = $this->ftp->list_files($newpath);
                        if (empty($isdirchild)) {
                            $this->ftp->mkdir($newpath);
                        }
                    }
                }
            }
            $upload_name = $filename . '.png';
            $to_file = str_replace(array('\\', '//'), array('/', '/'), $to_file . '/' . $upload_name);
            if (!file_exists($file)) {
                echo '原上传文件不存在！';
            } else {
                $result = $this->ftp->upload($file, $to_file, 'binary', 0775);
            }
            $this->ftp->close();
//ftp结束

//@unlink($file);   //二维码留底，不删除
            $upload_url = $this->ftp->weburl . '/' . FD_PUBLIC . '/' . $base_path . '/' . $upload_name;

            return $upload_url;
        }
    }

    /**
     * 不需要进行四次跳转的，以速度优先的进行这个权限处理
     * 访问这个页面，没验证就会跳至微信权授，获取权授后直接跳回
     */
    private function twoTimesOuth()
    {

        $this->load->library('Weixin_login');

        //$this->Weixin_login->login();
        $weixin_login = new Weixin_login();

        $weixin_login->login();


    }

    /**
     * 配置了只跳转二次的页面即返回true,否侧返回false
     * @return boolean
     */
    private function checkUseTwoTimesOuth()
    {

        /* if($_GET['id'] != 'a426755343'){

            return false;

        }
         */
        $pages = array("hotel/search", "hotel/index", "package/index", "mall/wap/topic", "soma/", "soma/order", "soma/center/bulid_openid_map_record", "soma/package/package_detail", "soma/package");
        //$_SERVER['REQUEST_URI']
        //strpos($mystring, $findme);
        $findit = 0;
        foreach ($pages as $page) {

            if (strpos($_SERVER['REQUEST_URI'], $page) > 0) {

                return true;

            }

        }

        return false;


    }

}

//前台Soma模块专用Controller by libinyan
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "MY_Front_Soma.php";
//会员模块专用
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "MY_Front_Member.php";
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "MY_Front_Mapi.php";
//订房模块专用
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "MY_Front_Hotel.php";

