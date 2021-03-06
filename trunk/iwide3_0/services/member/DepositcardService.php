<?php

namespace App\services\member;

use App\services\MemberBaseService;

/**
 * Class DepositcardService
 * @package App\services\member
 * @author lijiaping  <lijiaping@mofly.cn>
 *
 */
class DepositcardService extends MemberBaseService
{
    private $saler_id = 0;

    /**
     * 获取服务实例方法
     * @return DepositcardService
     */
    public static function getInstance()
    {
        return self::init(self::class);
    }

    public function __construct()
    {
        parent::__construct();
        $salesId = $this->getCI()->input->get('salesId');
        if ($salesId) {
            $this->getCI()->load->model('distribute/Staff_model');
            $saler = $this->getCI()->Staff_model->get_my_base_info_saler($this->getCI()->inter_id, $salesId);
            \MYLOG::w("get_my_base_info_saler :" . json_encode($saler) . '|' . $salesId . '|' . $this->getCI()->inter_id, 'membervip/debug-log');
            if (!empty($saler)) {
                $this->getCI()->session->set_userdata('salesId',$salesId);
                $this->saler_id = $salesId;
                $saler_id = \App\services\member\SupportService::getInstance()->check_set_saler($this->getCI()->inter_id, $this->getCI()->openid, $this->saler_id); //分销保护
                \MYLOG::w("check_set_saler_saler_id :" . $saler_id . '|' . $this->getCI()->inter_id, 'membervip/debug-log');
            }
        }

    }

    //会员可购卡列表
    public function index($inter_id, $openid, $_token, &$_template, $_template_filed_names)
    {

        // if($inter_id=='a472731996'||$inter_id=='a484619482'){ //测试环境是 a469428180，正式是 a472731996
        //     $userInfo = $this->check_user_login_info($inter_id,$openid);
        // }else{
        //     $userInfo = $this->check_user_login($inter_id,$openid);
        // }
        $userInfo = $this->check_user_login_info($inter_id, $openid);

        $wx_config = $this->_get_sign_package($inter_id);
        $hide = true;
        /*检查是否满足泛分销条件*/
        if ($inter_id == 'a472731996') {  //测试环境是 a469428180，正式是 a472731996

            $this->getCI()->load->model('membervip/common/Public_model', "com_model");
            $redis_img = $this->getCI()->com_model->get_vip_redis();
            $pan_sales_id = $this->getCI()->input->get('disId');
            $pan_sales_id = \App\services\member\SupportService::getInstance()->check_set_saler($inter_id, $openid, $pan_sales_id, 'pan'); //分销保护
            if (!empty($pan_sales_id)) {
                $redis_img->set("{$inter_id}_pan_dis_id_{$openid}", $pan_sales_id);
            }

            //检查资格
            if (isset($userInfo['data']) && !empty($userInfo['data'])) { //暂时写死
                $lvl_pms_code = str_replace(',', '', $userInfo['data']['lvl_pms_code']);
                if (in_array($lvl_pms_code, array(2, 3))) {  //暂时写死了
                    $this->getCI()->load->model('distribute/Idistribute_model');
                    $this->getCI()->load->model('wx/publics_model');
                    $fansInfo = $this->getCI()->Idistribute_model->fans_is_saler($inter_id, $openid);
                    if (!$fansInfo) {
                        $this->getCI()->load->model('distribute/openid_rel_model');
                        $deliver_infos = $this->getCI()->publics_model->get_public_by_id($this->getCI()->openid_rel_model->get_redis_key_status('__DISTRIBUTION_DELIER_ACCOUNT'));
                        $url = 'http://credit.iwide.cn' . $_SERVER ['REQUEST_URI'];
                        $site_url = prep_url($deliver_infos['domain']) . '/distribute/dis_ext/auto_back/' . '?id=' . $this->getCI()->openid_rel_model->get_redis_key_status('__DISTRIBUTION_DELIER_ACCOUNT') . '&f=' . base64_encode($inter_id . '***' . $openid . '***' . $url);
                        $data['redirect'] = $site_url;
                        return $data;
                    } else {
                        $salesInfo = json_decode($fansInfo, true);
                        if ($salesInfo['typ'] == 'FANS') {
                            $this->getCI()->load->model('membervip/front/Pandistribution_model', "pan_dis_model");
                            $pan_member = $this->getCI()->pan_dis_model->get_member($inter_id, $openid, $userInfo['data']);
                            if (!$pan_member) {
                                $dis_id = $this->getCI()->pan_dis_model->add_member($inter_id, $userInfo['data']);
                                $hide = false;
                            } else {
                                $dis_id = $pan_member['id'];
                                $hide = true;
                            }
                        }
//                        else if($salesInfo['typ'] == 'STAFF'){
//                            $dis_id = $salesInfo['info']['qrcode_id'];
//                        }
                        else {
                            $hide = true;
                            $dis_id = '';
                        }

                    }
                }
            } else {
                $hide = true;
            }
            //设定转发链接
            $wx_config['base_api_list'] = array('hideMenuItems', 'showMenuItems', 'onMenuShareTimeline', 'onMenuShareAppMessage');
            $js_api_list = '';
            foreach ($wx_config['base_api_list'] as $v) {
                $js_api_list .= "'{$v}',";
            }
            $wx_config['js_api_list'] = substr($js_api_list, 0, -1);
            if (!empty($dis_id)) {
                $share_config['link'] = site_url('membervip/depositcard') . '?id=' . $inter_id . '&disId=' . $dis_id;
            } else {
                $share_config['link'] = site_url('membervip/depositcard') . '?id=' . $inter_id;
            }
            $share_config['title'] = '点击购买雅斯特会员卡，立享住房最高7,5折优惠！';
            $share_config['imgUrl'] = base_url("public/member/yasite/ys_logo.jpg");
            $share_config['desc'] = '加入雅士会，福利多多，优惠多多';

        }


        $post_card_url = PMS_PATH_URL . "depositcard/get_list";
        $post_card_data = array(
            'inter_id' => $inter_id,
            'openid' => $openid,
            'deposit_type' => 'g',
        );
        $card_list_info = $this->doCurlPostRequest($post_card_url, $post_card_data)['data'];
        $data = array(
            'inter_id' => $inter_id,
            'card_list' => $card_list_info,
            'wx_config' => $wx_config,
            'hide' => $hide
        );
        if (isset($share_config) && !empty($share_config)) {
            $data['js_share_config'] = $share_config;
        }
        if ($inter_id == 'a464919542') $_template = 'phase2';

        $route = 'member';
        $file = 'depositcard';
        $data['filed_name'] = $_template_filed_names;
        if ($inter_id == 'a484619482') {
            //洲际定制，需要用于判断等级信息,弹出相应提示
            $data['can_buy'] = $userInfo['data']['member_lvl_id'] == 348;
        }
        return $data;
    }

    //会员购卡详细信息
    public function info($inter_id, $openid, $_token, &$_template, $_template_filed_names)
    {

        // if($inter_id=='a472731996'){ //测试环境是 a469428180，正式是 a472731996
        // }else{
        //     $userInfo = $this->check_user_login($inter_id,$openid);
        // }
        $userInfo = $this->check_user_login_info($inter_id, $openid);


        $extra = array(
            're_url' => base_url($_SERVER['REQUEST_URI']) . "&id=" . $inter_id,
            'loginFlag' => $userInfo
        );

        $wx_config = $this->_get_sign_package($inter_id);
        $hide = true;
        $this->getCI()->load->model('membervip/common/Public_model', 'p_model');
        $cardId = isset($_GET['cardId']) ? (int)$_GET['cardId'] : 0;
        $post_info_url = PMS_PATH_URL . "depositcard/getinfo";
        $post_info_data = array(
            'inter_id' => $inter_id,
            'deposit_card_id' => $cardId,
        );
        $card_info = $this->doCurlPostRequest($post_info_url, $post_info_data)['data'];
        if(empty($card_info['logo_url'])){
            $this->getCI()->load->model ( 'common/Enum_model' );
            $logo_url_info = $this->getCI()->Enum_model->get_enum_des ( array (
                 'MEMBER_CARD_DEMO_IMG'
             ));
            $card_info['logo_url'] = $logo_url_info['MEMBER_CARD_DEMO_IMG']['member_card_demo_img'];
        }
        /*检查是否满足泛分销条件*/
        if ($inter_id == 'a472731996') {  //测试环境是a469428180，正式是a472731996
            $redis_img = $this->getCI()->p_model->get_vip_redis();
            $pan_sales_id = $this->getCI()->input->get('disId');
            $pan_sales_id = \App\services\member\SupportService::getInstance()->check_set_saler($inter_id, $openid, $pan_sales_id, 'pan'); //分销保护
            if (!empty($pan_sales_id)) $redis_img->set("{$inter_id}_pan_dis_id_{$openid}", $pan_sales_id);

            //检查资格
            if (isset($userInfo['data']) && !empty($userInfo['data'])) { //暂时写死
                $lvl_pms_code = str_replace(',', '', $userInfo['data']['lvl_pms_code']);
                if (in_array($lvl_pms_code, array(2, 3))) {  //暂时写死了
                    $this->getCI()->load->model('distribute/Idistribute_model');
                    $this->getCI()->load->model('wx/publics_model');
                    $fansInfo = $this->getCI()->Idistribute_model->fans_is_saler($inter_id, $openid);
                    if (!$fansInfo) {
                        $this->getCI()->load->model('distribute/openid_rel_model');
                        $deliver_infos = $this->getCI()->publics_model->get_public_by_id($this->getCI()->openid_rel_model->get_redis_key_status('__DISTRIBUTION_DELIER_ACCOUNT'));
                        $url = 'http://credit.iwide.cn' . $_SERVER ['REQUEST_URI'];
                        $site_url = prep_url($deliver_infos['domain']) . '/distribute/dis_ext/auto_back/' . '?id=' . $this->getCI()->openid_rel_model->get_redis_key_status('__DISTRIBUTION_DELIER_ACCOUNT') . '&f=' . base64_encode($inter_id . '***' . $openid . '***' . $url);
                        $data['redirect'] = $site_url;
                        return $data;
                    } else {
                        $salesInfo = json_decode($fansInfo, true);
                        if ($salesInfo['typ'] == 'FANS') {
                            $this->getCI()->load->model('membervip/front/Pandistribution_model', "pan_dis_model");
                            $pan_member = $this->getCI()->pan_dis_model->get_member($inter_id, $openid, $userInfo['data']);
                            if (!$pan_member) {
                                $dis_id = $this->getCI()->pan_dis_model->add_member($inter_id, $userInfo['data']);
                                $hide = false;
                            } else {
                                $dis_id = $pan_member['id'];
                                $hide = true;
                            }
                        }
//                        else if($salesInfo['typ'] == 'STAFF'){
//                            $dis_id = $salesInfo['info']['qrcode_id'];
//                        }
                        else {
                            $dis_id = '';
                        }

                    }
                }
            }

            $share_config['title'] = '点击购买雅斯特会员卡，立享住房最高7,5折优惠！';
            $share_config['imgUrl'] = base_url("public/member/yasite/ys_logo.jpg");
            $share_config['desc'] = '加入雅士会，福利多多，优惠多多';

        }

        if (!empty($dis_id)) {
            $share_config['link'] = site_url('membervip/depositcard/info') . '?cardId=' . $cardId . "&id=" . $inter_id . '&disId=' . $dis_id;
        } else {
            $share_config['link'] = site_url('membervip/depositcard/info') . '?cardId=' . $cardId . "&id=" . $inter_id;
        }
        //设定转发链接
        $js_api_list = '';
        $wx_config['base_api_list'] = array('hideMenuItems', 'showMenuItems', 'onMenuShareTimeline', 'onMenuShareAppMessage');
        foreach ($wx_config['base_api_list'] as $v) {
            $js_api_list .= "'{$v}',";
        }
        $wx_config['js_api_list'] = $js_api_list;


        $deposit_card = $this->getCI()->p_model->get_info(array('deposit_card_id' => $cardId), 'deposit_card', 'pay_type');
        $pay_type = array();
        if (!empty($deposit_card)) {
            $pay_types = explode(',', $deposit_card['pay_type']);
            foreach ($pay_types as $vo) {
                switch ($vo) {
                    case 'wechat':
                        $pay_type[$vo] = '微信支付';
                        break;
                    case 'balance':
                        $pay_type[$vo] = $_template_filed_names['balance_name'] . '支付';
                        break;
                }
            }
        }

        $card_info['description'] = nl2br($card_info['description']);
        $data = array(
            'card' => $card_info,
            'pay_type' => $pay_type,
            'inter_id' => $inter_id,
            'wx_config' => $wx_config,
            'hide' => $hide,
            'extra' => $extra
        );
        if (isset($share_config) && !empty($share_config)) {
            $data['js_share_config'] = $share_config;
        }
        if ($inter_id == 'a464919542') $_template = 'phase2';
        $data['filed_name'] = $_template_filed_names;
        return $data;
    }

    /**
     * 开始购卡(所有的优先进入这个页面,当查询到信息后，检测到需要填写信息则,开始跳转否则,跳转支付)
     */
    public function buycard($inter_id, $openid)
    {
        $cardId = isset($_POST['cardId']) ? (int)$_POST['cardId'] : 0;
        $pay_type = isset($_POST['pay_type']) ? $_POST['pay_type'] : 'wechat';

        $userInfo = $this->check_user_login($inter_id, $openid);
        if (!empty($userInfo['redirect']) || (!empty($userInfo['err']) && $userInfo['err'] == 40003)) {
            return $userInfo;
        }
        $post_info_url = PMS_PATH_URL . "depositcard/getinfo";
        $post_info_data = array(
            'inter_id' => $inter_id,
            'deposit_card_id' => $cardId,
        );
        $card_info = $this->doCurlPostRequest($post_info_url, $post_info_data);

        if (empty($card_info['data'])) return array('err' => 40003, 'msg' => '购卡信息不存在!');

        if (isset($card_info['data']['is_distribution']) && $card_info['data']['is_distribution'] == 't' && $inter_id == 'a472731996') {
            return array('err' => 0, 'msg' => 'ok!', 'data' => base_url("index.php/membervip/depositcard/edituser?cardId={$cardId}&pay={$pay_type}"));
        } else {
            return array('err' => 0, 'msg' => 'ok!', 'data' => base_url("index.php/membervip/depositcard/pay?cardId={$cardId}&pay={$pay_type}"));
        }
    }

    //
    public function pay($inter_id, $openid, $_token)
    {

        $cardId = isset($_GET['cardId']) ? (int)$_GET['cardId'] : 0;
        $pay_type = isset($_GET['pay']) ? $_GET['pay'] : 'wechat';
        $userInfo = $this->check_user_login($inter_id, $openid);
        if (!empty($userInfo['redirect']) || (!empty($userInfo['err']) && $userInfo['err'] == 40003)) {
            return $userInfo;
        }
        $this->getCI()->load->model('membervip/common/Public_model', 'p_model');
        $deposit_card = $this->getCI()->p_model->get_info(array('deposit_card_id' => $cardId), 'deposit_card', 'pay_type');
        if (!empty($deposit_card)) {
            $pay_types = explode(',', $deposit_card['pay_type']);
            if(!in_array($pay_type,$pay_types)){
                $pay_type = $pay_types[0];
            }
        }else{
            return array('err' => 40003, 'msg' => '此卡暂不能购买!');
        }

        //创建支付订单
        $saler_id = \App\services\member\SupportService::getInstance()->check_set_saler($inter_id, $openid, $this->saler_id); //分销保护
        if (!empty($saler_id) && $saler_id > 0) $distribution_num = $saler_id;
        $create_order_data['distribution_num'] = (isset($distribution_num) && !empty($distribution_num)) ? $distribution_num : 0;

        $create_order_data['deposit_card_id'] = $cardId;
        $create_order_url = INTER_PATH_URL . 'depositorder/create';
        $create_order_data['inter_id'] = $inter_id;
        $create_order_data['openid'] = $openid;
        $create_order_data['token'] = $_token;
        $create_info = $this->doCurlPostRequest($create_order_url, $create_order_data);
        if (isset($create_info['err'])) {
            return $create_info;
        } else {
            if ($pay_type == 'balance') {
                $data['redirect'] = base_url("index.php/membervip/balance/pay?orderId=" . $create_info['data']);
            } else {
                $data['redirect'] = base_url("index.php/wxpay/vip_pay?orderId=" . $create_info['data'] . '&payfor=card');
            }
            return $data;
        }
    }

    /**
     *    储值
     *
     *
     */
    public function buydeposit($inter_id, $openid, $_token, &$_template, $_template_filed_names, $not_login_handle = true)
    {
        $userInfo = $this->check_user_login($inter_id, $openid);
        if ($not_login_handle && !empty($userInfo['redirect']) || (!empty($userInfo['err']) && $userInfo['err'] == 40003)) {
            return $userInfo;
        }
        $post_card_url = PMS_PATH_URL . "depositcard/get_list";
        $post_card_data = array(
            'inter_id' => $inter_id,
            'openid' => $openid,
            'deposit_type' => 'c',
        );
        $card_list_info = $this->doCurlPostRequest($post_card_url, $post_card_data)['data'];
        $total_deposit = isset($userInfo['data']['balance']) ? $userInfo['data']['balance'] : 0;
        $data = array(
            'inter_id' => $inter_id,
            'deposit_list' => $card_list_info,
            'total_deposit' => $total_deposit
        );
        if ($inter_id == 'a464919542') $_template = 'phase2';
        $data['filed_name'] = $_template_filed_names;
        return $data;
    }

    //填写分销信息
    public function edituser($inter_id, $openid, $_token, &$_template)
    {
        $userInfo = $this->check_user_login($inter_id, $openid);
        if (!empty($userInfo['redirect']) || (!empty($userInfo['err']) && $userInfo['err'] == 40003)) {
            return $userInfo;
        }
        $cardId = isset($_GET['cardId']) ? (int)$_GET['cardId'] : 0;
        $pay_type = isset($_GET['pay']) ? $_GET['pay'] : 'wechat';
        $post_info_url = PMS_PATH_URL . "depositcard/getinfo";
        $post_info_data = array(
            'inter_id' => $inter_id,
            'deposit_card_id' => $cardId,
        );
        $card_info = $this->doCurlPostRequest($post_info_url, $post_info_data)['data'];
        if (!$card_info) {
            return array('err' => 40003, 'msg' => 'Error link');
        }
        $post_center_url = PMS_PATH_URL . "member/center";
        $post_center_data = array(
            'inter_id' => $inter_id,
            'openid' => $openid,
        );
        //请求用户登录(默认)会员卡信息
        $data['info'] = $this->doCurlPostRequest($post_center_url, $post_center_data)['data'];
        $data['card_id'] = $cardId;
        $data['card_info'] = $card_info;
        //拉取授权信息
        $this->getCI()->load->model('wx/access_token_model');
        $this->getCI()->load->model('wx/Publics_model');
        $data['signpackage'] = $this->getCI()->access_token_model->getSignPackage($inter_id);
        $data['public'] = $this->getCI()->Publics_model->get_public_by_id($inter_id);
        $data['pay_type'] = $pay_type;
        if ($inter_id == 'a464919542') $_template = 'phase2';
        return $data;
    }

    //创建储值订单
    public function save_deposit_order($inter_id, $openid, $_token)
    {
        $userInfo = $this->check_user_login($inter_id, $openid);
        if (!empty($userInfo['redirect']) || (!empty($userInfo['err']) && $userInfo['err'] == 40003)) {
            return $userInfo;
        }
        $depositId = (int)$this->getCI()->input->post('depositId');
        // $depositMoney = $this->getCI()->input->post('depositMoney');
        $money = $this->getCI()->input->post('money');
        $distribution_num = $this->getCI()->input->post('distribution_num');
        $saler_id = \App\services\member\SupportService::getInstance()->check_set_saler($inter_id, $openid, $this->saler_id); //分销保护
        if (!empty($saler_id) && $saler_id > 0) $distribution_num = $saler_id;

        if ($depositId) {
            //创建支付订单
            $create_order_data['deposit_card_id'] = $depositId;
            $create_order_url = INTER_PATH_URL . 'depositorder/create';
            $create_order_data['inter_id'] = $inter_id;
            $create_order_data['openid'] = $openid;
            $create_order_data['token'] = $_token;
            $create_order_data['distribution_num'] = (isset($distribution_num) && !empty($distribution_num)) ? $distribution_num : 0;
            $create_info = $this->doCurlPostRequest($create_order_url, $create_order_data);
            if (empty($create_info)) {
                return array('err' => '40003', 'msg' => '系统繁忙！');
            }
            return $create_info;
        } else {
            if ($money == 0) {
                return array('err' => '10212', 'msg' => '充值金额不能为空');
            }
            $create_order = array(
                'pay_money' => $money,
                'inter_id' => $inter_id,
                'open_id' => $openid,
                'deposit_card_id' => 0,
                'ok_pay_money' => 0,
                'token' => $_token,
                'createtime' => time(),
            );
            $create_order_url = INTER_PATH_URL . 'depositorder/create_order';
            $create_order_data = $create_order;
            $create_info = $this->doCurlPostRequest($create_order_url, $create_order_data);
            if (empty($create_info)) {
                return array('err' => '40003', 'msg' => '系统繁忙！');
            }
            return $create_info;
        }
    }

    //开始创建订单
    public function save_order($inter_id, $openid, $_token)
    {
        $this->getCI()->load->model('membervip/common/Public_model', 'p_model');
        $cardId = isset($_GET['cardId']) ? (int)$_GET['cardId'] : 0;
        $pay_type = isset($_POST['pay_type']) ? $_POST['pay_type'] : 'wechat';

        //创建支付订单
        $post_data = $this->getCI()->input->post();
        /*
        if(empty($post_data['phone'])){
            $this->_ajaxReturn('请输入手机号码');
        }

        $regexp = "/^[1][345789][0-9]{9}$/";
        if (strlen($post_data['phone']) !=11 ){
            $this->_ajaxReturn('手机号码长度不合法');
        }

        if(!preg_match( $regexp , $post_data['phone'] )){
            $this->_ajaxReturn('手机号码不合法');
        }

        if(empty($post_data['idno'])){
            $this->_ajaxReturn('请输入证件号码');
        }

        $regexp = "/^[0-9Xx]+$/";
        if( strlen($post_data['idno']) < 15 || strlen($post_data['idno']) >= 19 ){
            $this->_ajaxReturn('身份证长度不合法'.strlen($post_data['idno']));
        }

        if( !preg_match( $regexp , $post_data['idno'] ) ){
            $this->_ajaxReturn('身份证格式不正确');
        }
*/
        //检查是否属于泛分销订单
        $key = '';
        $redis_img = $this->getCI()->p_model->get_vip_redis();
        $pan_sales_id = $redis_img->get("{$inter_id}_pan_dis_id_{$openid}");
        if ((!isset($post_data['distribution_num']) || empty($post_data['distribution_num'])) && !empty($pan_sales_id)) {
            $post_data['distribution_num'] = $pan_sales_id;
            $post_data['distribution_type'] = 'FANS';
            $key = "{$inter_id}_pan_dis_id_{$openid}";
        }

        unset($post_data['pay_type']);
        $create_order_data = $post_data;
        $create_order_data['deposit_card_id'] = $cardId;
        $create_order_url = INTER_PATH_URL . 'depositorder/create';
        $create_order_data['inter_id'] = $inter_id;
        $create_order_data['openid'] = $openid;
        $create_order_data['token'] = $_token;
        $create_info = $this->doCurlPostRequest($create_order_url, $create_order_data);
        if (isset($create_info['err']) && $create_info['err'] > 0) {
            $msg = !empty($create_info['msg']) ? $create_info['msg'] : '订单创建失败';
            return array('err' => 40003, 'msg' => $msg);
        }
        $msg = !empty($create_info['msg']) ? $create_info['msg'] : 'ok';
        if (!empty($key)) $redis_img->del($key); //清空泛分销关系
        $order_id = !empty($create_info['data']) ? $create_info['data'] : 0;
        $jumpurl = $pay_type == 'balance' ? base_url("index.php/membervip/balance/pay?orderId={$order_id}") : base_url("index.php/wxpay/vip_pay?orderId={$order_id}");
        return array('err' => 0, 'msg' => $msg, 'data' => $jumpurl);

    }

    //支付成功
    public function okpay($inter_id, $openid, $_token, $_template, $_template_filed_names)
    {
        $data = array();
        $data['filed_name'] = $_template_filed_names;
//        $jump_url = $this->getCI()->session->userdata('JFK_member_vip_jump_url'); //跳转链接
        $this->getCI()->load->model('hotel/Hotel_config_model');
        $jump_url = '';
        $config_data = $this->getCI()->Hotel_config_model->get_hotel_config($inter_id, 'MEMBERVIP', 0, array(
            'DEPOSITCARD_OKPAY_ENSURE_URLTYPE'
        ));
        if (!empty($config_data['DEPOSITCARD_OKPAY_ENSURE_URLTYPE'])) {
            if ($config_data['DEPOSITCARD_OKPAY_ENSURE_URLTYPE'] == 'saler_hotel' && $saler_id = intval($this->getCI()->input->get('salesId'))) {
                $this->getCI()->load->model('distribute/Staff_model');
                $sales = $this->getCI()->Staff_model->get_my_base_info_saler($inter_id, $saler_id);
                if (!empty($sales['hotel_id'])) {
                    $jump_url = site_url('hotel/hotel/index') . '?id=' . $inter_id . '&h=' . $sales['hotel_id'];
                }
            }
        }
        if (!empty($jump_url)) {
            $data['jump_url'] = $jump_url;
        } else {
            $data['jump_url'] = site_url("membervip/center?id={$inter_id}");
        }

        //order_data
        $orderId = $this->getCI()->input->get('orderId');
        $orderNum = $this->getCI()->input->get('orderNum');
        $orderMoney = $this->getCI()->input->get('orderMoney');

        if (!empty($orderId) && !empty($orderNum) && !empty($orderMoney)) {
            $post_center_url = PMS_PATH_URL . "member/center";
            $post_center_data = array(
                'inter_id' => $inter_id,
                'openid' => $openid,
            );
            //请求用户登录(默认)会员卡信息
            $data['info'] = $this->doCurlPostRequest($post_center_url, $post_center_data)['data'];
        }
        $data['orderId'] = $orderId;
        $data['orderNum'] = $orderNum;
        $data['inter_id'] = $inter_id;
        return $data;
    }

    //支付失败
    public function nopay($inter_id)
    {
        $orderId = isset($_GET['orderId']) ? (int)$_GET['orderId'] : 0;
        $interId = isset($_GET['interId']) ? (int)$_GET['interId'] : 0;
        $orderNum = isset($_GET['orderNum']) ? (int)$_GET['orderNum'] : 0;
        $orderMoney = isset($_GET['orderMoney']) ? (int)$_GET['orderMoney'] : 0;
//        $jump_url = $this->getCI()->session->userdata('JFK_member_vip_jump_url'); //跳转链接
        $jump_url = '';
        $data = array(
            'restarturl' => base_url('index.php/wxpay/vip_pay?orderId=' . $orderId),
        );
        $payfor = $this->getCI()->input->get('payfor') ? $this->getCI()->input->get('payfor') : '';
        if ($payfor == 'card') {
            $data['restarturl'] .= '&payfor=card';
        }
        if (!empty($jump_url)) {
            $data['jump_url'] = $jump_url;
        } else {
            $data['jump_url'] = site_url("membervip/center?id={$inter_id}");
        }
        return $data;
    }

    /**
     * 把请求/返回记录记入文件
     * @param String content
     * @param String type
     */
    protected function vip_order_write_log($content, $type = 'request')
    {
        $file = date('Y-m-d_H') . '.txt';
        $path = APPPATH . 'logs' . DS . 'front' . DS . 'membervip_order' . DS;
        if (!file_exists($path)) {
            @mkdir($path, 0777, TRUE);
        }
        $ip = $this->getCI()->input->ip_address();
        $fp = fopen($path . $file, 'a');

        $content = str_repeat('-', 40) . "\n[" . $type . ' : ' . date('Y-m-d H:i:s') . ' : ' . $ip . ']'
            . "\n" . $content . "\n";
        fwrite($fp, $content);
        fclose($fp);
    }

    //获取会员模式，对用户的操作进行限制
    protected function check_user_login($inter_id, $openid, $redir_url = '')
    {
        //获取微信会员卡的信息
        $post_center_url = PMS_PATH_URL . "member/center";
        $post_center_data = array(
            'inter_id' => $inter_id,
            'openid' => $openid,
        );
        //请求用户登录(默认)会员卡信息(注：第一次有可能返回的数据是空)
        $userInfo = $this->doCurlPostRequest($post_center_url, $post_center_data);

        if (isset($userInfo['data'])) {
            $userinfo = $userInfo['data'];
            if ($userinfo['value'] == "login" && $userinfo['member_mode'] == 1) {
                if (!empty($redir_url))
                    return array('redirect' => base_url("index.php/membervip/login?id=" . $inter_id . "&redir=" . $redir_url));
                else
                    return array('redirect' => base_url("index.php/membervip/login?id=" . $inter_id));
            }
        } else {
            return array('err' => 40003, 'msg' => 'userinfo is error');
        }
        return $userInfo;
    }

    protected function check_user_login_info($inter_id, $openid)
    {
        //获取微信会员卡的信息
        $post_center_url = PMS_PATH_URL . "member/center";
        $post_center_data = array(
            'inter_id' => $inter_id,
            'openid' => $openid,
        );
        //请求用户登录(默认)会员卡信息(注：第一次有可能返回的数据是空)
        $userInfo = $this->doCurlPostRequest($post_center_url, $post_center_data);

        if (isset($userInfo['data'])) {
            $userinfo = $userInfo['data'];
            if ($userinfo['value'] == "login" && $userinfo['member_mode'] == 1) {
                return false;
            }
        } else {
            return false;
        }
        return $userInfo;
    }


    /**
     * 把请求/返回记录记入文件
     * @param String content
     * @param String type
     */
    protected function api_write_log($content, $type = 'request')
    {
        $file = date('Y-m-d_H') . '.txt';
        $path = APPPATH . 'logs' . DS . 'front' . DS . 'membervip' . DS;
        if (!file_exists($path)) {
            @mkdir($path, 0777, TRUE);
        }
        $ip = $this->getCI()->input->ip_address();
        $fp = fopen($path . $file, 'a');

        $content = str_repeat('-', 40) . "\n[" . $type . ' : ' . date('Y-m-d H:i:s') . ' : ' . $ip . ']'
            . "\n" . $content . "\n";
        fwrite($fp, $content);
        fclose($fp);
    }

    /**
     * *更改泛分销状态
     */
    public function update_distribution_stats($inter_id, $openid)
    {
        $userInfo = $this->check_user_login($inter_id, $openid);
        $action = $this->getCI()->input->post('status');
        $notice = $this->getCI()->input->post('notice');
        if (!empty($userInfo['redirect']) || (!empty($userInfo['err']) && $userInfo['err'] == 40003)) {
            return $userInfo;
        }
        if (!isset($userInfo['data']) || empty($userInfo['data'])) {
            return array('err' => 40003, 'msg' => '会员信息有误');
        }

        $this->getCI()->load->model('membervip/front/Pandistribution_model', "pan_dis_model");
        if ($notice && $action == 'cancel_auth') {  //取消并不在提示
            $this->getCI()->pan_dis_model->update_member($inter_id, $userInfo['data'], 0, 1);
        } elseif ($action == 'authorize') {
            $this->getCI()->pan_dis_model->update_member($inter_id, $userInfo['data'], 1, 1);
        }

        return array('err' => 0, 'msg' => 'ok!');
    }

    /*更新购买者信息*/
    public function update_order_buyer($inter_id, $openid, $_token)
    {
        //order_data
        $update_order_url = INTER_PATH_URL . 'depositorder/update_info';
        $update_order_data['deposit_card_pay_id'] = $this->getCI()->input->post('orderId');
        $update_order_data['order_num'] = $this->getCI()->input->post('orderNum');
//        $update_order_data['orderMoney'] = $this->getCI()->input->post('orderMoney');
        $update_order_data['name'] = $this->getCI()->input->post('name');
        $update_order_data['phone'] = $this->getCI()->input->post('phone');
        $update_order_data['idno'] = $this->getCI()->input->post('idno');
        $update_order_data['inter_id'] = $inter_id;
        $update_order_data['openid'] = $openid;
        $update_order_data['token'] = $_token;

        $update_info = $this->doCurlPostRequest($update_order_url, $update_order_data);
        if (isset($update_info['err']) && $update_info['err'] > 0) {
            $msg = !empty($update_info['msg']) ? $update_info['msg'] : '更新订单信息失败';
            return array('err' => 40003, 'msg' => $msg);
        } else {
            return array('err' => 0, 'msg' => 'ok!', 'data' => base_url("index.php/membervip/center?id=" . $inter_id));
        }


//    [name] => 微信用户
//    [phone] =>
//    [idno] =>


    }

    /**
     * 获取微信JSSDK配置信息
     * @param $inter_id
     * @param string $url
     * @return array
     */
    protected function _get_sign_package($inter_id, $url = '')
    {
        $this->getCI()->load->helper('common');
        $this->getCI()->load->model('wx/publics_model', 'publics');
        $this->getCI()->load->model('wx/access_token_model');
        $jsapiTicket = $this->getCI()->access_token_model->get_api_ticket($inter_id);

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        if (!$url)
            $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = createNonceStr();
        $public = $this->getCI()->publics->get_public_by_id($inter_id);

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array(
            "appId" => $public['app_id'],
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }
}