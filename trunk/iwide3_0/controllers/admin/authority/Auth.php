<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Account
 * 管理员登录 模板路由
 * 沙沙
 * 2017-9-19
 */

class Auth extends MY_Admin
{
    protected $admin_profile;

    public function __construct()
    {
        parent::__construct();
        $this->admin_profile = $this->session->userdata('admin_profile');
        $this->load->helper('appointment');
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




}