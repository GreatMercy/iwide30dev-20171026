<?php

/**
 * Class Express
 * @author renshuai  <renshuai@mofly.cn>
 *
 */
class IwidepayApi extends MY_Admin_Iapi
{
    function __construct() {
        parent::__construct ();
        $this->inter_id = $this->session->get_admin_inter_id ();
        $this->module = 'soma';
        $this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
        $this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
        $this->load->helper('appointment');
    }

    public function index()
    {
        $param = request();

        ajax_return('2','21');
    }




}