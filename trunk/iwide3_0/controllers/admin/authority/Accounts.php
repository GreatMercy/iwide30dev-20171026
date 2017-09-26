<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Account
 * 管理员账户管理 模板路由
 * 沙沙
 * 2017-7-24
 */

class Accounts extends MY_Admin
{
    protected $admin_profile;

    public function __construct()
    {
        parent::__construct();
        $this->admin_profile = $this->session->userdata('admin_profile');
        $this->load->helper('appointment');
    }

    /**
     * 首页管理列表
     *
     */
    public function index()
    {
        $param = request();
        $return = array(
            'param'      => $param,
        );

        echo $this->_render_content($this->_load_view_file('account_list'), $return, TRUE);
    }

    /**
     * 编辑 账户
     */
    public function edit()
    {
        $param = request();
        $return = array(
            'param' => $param,
        );

        echo $this->_render_content($this->_load_view_file('edit_account'), $return, TRUE);
    }

    /**
     * 添加账户
     */
    public function add()
    {
        $param = request();
        $return = array(
            'param' => $param,
        );

        echo $this->_render_content($this->_load_view_file('add_account'), $return, TRUE);
    }

    /**
     * 显示二维码
     */
    public function showAuthQr()
    {
        $param = request();
        $text = !empty($param['url']) ? addslashes($param['url']) : '';
        $this->load->helper('phpqrcode');
        $text = urldecode($text);
        QRcode::png($text,false,6,6);
    }

    /**
     * 登录
     */
    public function login()
    {
        $param = request();
        $return = array(
            'param' => $param,
        );
        echo $this->_render_content($this->_load_view_file('login'), $return, TRUE);
    }

    public function ash()
    {
        $sql = 'a:1:{s:4:"club";a:1:{s:11:"controllers";a:3:{i:96;a:1:{s:5:"funcs";a:3:{i:586;a:0:{}i:587;a:0:{}i:588;a:0:{}}}i:97;a:1:{s:5:"funcs";a:5:{i:590;a:0:{}i:595;a:0:{}i:596;a:0:{}i:599;a:0:{}i:603;a:0:{}}}i:98;a:1:{s:5:"funcs";a:5:{i:604;a:0:{}i:605;a:0:{}i:607;a:0:{}i:608;a:0:{}i:612;a:0:{}}}}}}';
        $arr = unserialize($sql);
         //print_r($arr);
        //echo json_encode($arr);

        $arr = array(
            'appointment' => array(
                96 => array(
                    586 => array(),
                ),
            ),
            'hotel' => array(
                1 => array(
                    5 => array(),
                    7 => array(),
                ),
                2 => array(

                ),
            ),
        );

        print_r($arr);
    }

}