<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Roles extends MY_Admin
{
    protected $admin_profile;

    public function __construct()
    {
        parent::__construct();
        $this->admin_profile = $this->session->userdata('admin_profile');
        $this->load->helper('appointment');
    }


    public function role_list()
    {
        $param = request();
        $return = array(
            'param'      => $param,
        );

        echo $this->_render_content($this->_load_view_file('role_list'), $return, TRUE);
    }
    public function add_role()
    {
        $param = request();
        $return = array(
            'param'      => $param,
        );

        echo $this->_render_content($this->_load_view_file('add_role'), $return, TRUE);
    }
    public function authority_module()
    {
        $param = request();
        $return = array(
            'param'      => $param,
        );

        echo $this->_render_content($this->_load_view_file('authority_module'), $return, TRUE);
    }
    public function authority_list()
    {
        $param = request();
        $return = array(
            'param'      => $param,
        );

        echo $this->_render_content($this->_load_view_file('authority_list'), $return, TRUE);
    }    
}