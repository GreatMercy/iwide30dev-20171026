<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GiftDelivery extends MY_Front_Soma {



    /**
     * 跳转礼包二维码详情页面
     */
    public function redirect_gift_detail(){

        $params = array();
        $params['id'] = $this->input->get('gift_detail_id');
        $params['inter_id'] = $this->input->get('inter_id');
        $params['request_token'] = $this->input->get('request_token');

        $this->_view('gift_delivery/qrcode_gift_detail',$params);

    }


    /***
     * 礼包礼包页面
     */
    public function gift_list(){

        $parmas['inter_id'] = $this->input->get('inter_id');
        $parmas['saler_id'] = $this->input->get('saler_id');
        $parmas['saler_name'] = $this->input->get('saler_name');

        $this->_view('gift_delivery/gift_list');
    }


    /***
     * 确认领取礼包详情页
     */
    public function receive_gift_detail(){

        $this->_view('gift_delivery/receive_gift_detail');
    }


}
