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

        echo $this->_render_content($this->_load_view_file('index'), $return, TRUE);
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

        echo $this->_render_content($this->_load_view_file('edit'), $return, TRUE);
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

        echo $this->_render_content($this->_load_view_file('edit'), $return, TRUE);
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

}