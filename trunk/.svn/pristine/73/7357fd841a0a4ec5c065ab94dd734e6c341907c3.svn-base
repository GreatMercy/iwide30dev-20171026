<?php

class Qr extends MY_Controller{

    public function __construct(){
        parent::__construct();

    }

    public function index()
    {
        $this->load->helper('phpqrcode');
        $text = 'http://zb.jinfangka.cn/index.php/hotel/hotel/search?token=a429262688';
        QRcode::png($text,false,6,6);
    }

}