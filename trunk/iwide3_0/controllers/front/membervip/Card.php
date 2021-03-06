<?php

use App\services\member\CardService;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *    会员卡卡券
 * @author  Frandon
 * @copyright www.iwide.cn
 * @version 4.0
 * @Email 489291589@qq.com
 */
class Card extends MY_Front_Member
{
    private $initTime;
    private $endt;
    private $url_group = array();
    private $args = array();

    public function __construct()
    {
        $this->initTime = microtime(true);
        parent::__construct();
        $this->endt = microtime(true);
        $this->load->helper('common_helper');
        $this->args = get_args();

        //设置前端需要用到的URL
        $this->url_group['cardcenter_url'] = base_url("index.php/membervip/card?id={$this->inter_id}");
        $this->url_group['cardinfo_url'] = base_url("index.php/membervip/card/cardinfo?id={$this->inter_id}");
        $this->url_group['pcardinfo_url'] = base_url("index.php/membervip/card/pcardinfo?id={$this->inter_id}");
        $this->url_group['center_url'] = base_url("index.php/membervip/center?id={$this->inter_id}");
        $this->url_group['qrcodecon_url'] = base_url("index.php/membervip/center/qrcodecon?id={$this->inter_id}");
        $this->url_group['gift_card_url'] = base_url("index.php/membervip/card/gift_card?id={$this->inter_id}");
        $this->url_group['passwduseoff_url'] = base_url("index.php/membervip/card/passwduseoff?id={$this->inter_id}");
        $this->url_group['getpackage_url'] = base_url("index.php/membervip/card/getpackage?id={$this->inter_id}");
        $this->url_group['addcard_url'] = base_url("index.php/membervip/card/addcard?id={$this->inter_id}");
        $this->url_group['givecard_url'] = base_url("index.php/membervip/card/givecard?id={$this->inter_id}");
        $this->url_group['hang_card_url'] = base_url("index.php/membervip/card/hang_card?id={$this->inter_id}");
        $this->url_group['savegivecard_url'] = base_url("index.php/membervip/card/savegivecard?id={$this->inter_id}");
        $this->url_group['receive_card_url'] = base_url("index.php/membervip/card/receive_card?id={$this->inter_id}");
        $this->url_group['check_useoff_url'] = base_url("index.php/membervip/card/check_useoff?id={$this->inter_id}");

        $this->url_group['iapi']['cardcenter_url'] = base_url("index.php/iapi/membervip/card?id={$this->inter_id}");
        $this->url_group['iapi']['cardinfo_url'] = base_url("index.php/iapi/membervip/card/cardinfo?id={$this->inter_id}");
        $this->url_group['iapi']['pcardinfo_url'] = base_url("index.php/iapi/membervip/card/pcardinfo?id={$this->inter_id}");
        $this->url_group['iapi']['gift_card_url'] = base_url("index.php/iapi/membervip/card/gift_card?id={$this->inter_id}");
        $this->url_group['iapi']['passwduseoff_url'] = base_url("index.php/iapi/membervip/card/passwduseoff?id={$this->inter_id}");
        $this->url_group['iapi']['getpackage_url'] = base_url("index.php/iapi/membervip/card/getpackage?id={$this->inter_id}");
        $this->url_group['iapi']['addcard_url'] = base_url("index.php/iapi/membervip/card/addcard?id={$this->inter_id}");
        $this->url_group['iapi']['givecard_url'] = base_url("index.php/iapi/membervip/card/givecard?id={$this->inter_id}");
        $this->url_group['iapi']['hang_card_url'] = base_url("index.php/iapi/membervip/card/hang_card?id={$this->inter_id}");
        $this->url_group['iapi']['savegivecard_url'] = base_url("index.php/iapi/membervip/card/savegivecard?id={$this->inter_id}");
        $this->url_group['iapi']['receive_card_url'] = base_url("index.php/iapi/membervip/card/receive_card?id={$this->inter_id}");
        $this->url_group['iapi']['check_useoff_url'] = base_url("index.php/iapi/membervip/card/check_useoff?id={$this->inter_id}");
        $this->url_group['iapi']['receive_url'] = base_url("index.php/iapi/membervip/card/receive?id={$this->inter_id}");

    }

    //会员卡券列表
    public function index()
    {
        $data['data'] = array();
        if (!$this->is_restful()) {
            $data = CardService::getInstance()->index($this->inter_id, $this->openid, $this->_template, $this->url_group);
        } else {
            $data['data'] = $this->url_group;
        }
        $data['data']['page_title'] = '我的优惠券';
        $this->template_show('member', $this->_template, 'card', $data['data']);
    }

    //获取pms卡券列表-隐居定制
    public function pcard()
    {
        $data['data'] = array();
        $data = CardService::getInstance()->pcard($this->inter_id, $this->openid, $this->url_group);
        $data['data']['page_title'] = '我的优惠券';
        $this->template_show('member', $this->_template, 'pcard', $data['data']);
    }

    public function pcardinfo()
    {
        $member_card_id = !empty($this->args['member_card_id']) ? $this->args['member_card_id'] : '';
        $data['data'] = array();
        if (!$this->is_restful()) {
            $data = CardService::getInstance()->pcardinfo($this->inter_id, $this->openid, $member_card_id, $this->url_group);
        } else {
            $data['data'] = $this->url_group;
        }
        $data['data']['page_title'] = '优惠券详情';
        $this->template_show('member', $this->_template, 'pcardinfo', $data['data']);
    }

    //Ajax会员卡券列表
    public function ajax_card()
    {
        $next_id = !empty($this->args['next_id']) ? $this->args['next_id'] : '';
        $data['data'] = array();
        if (!$this->is_restful()) {
            $data = CardService::getInstance()->ajax_card($this->inter_id, $this->openid, $next_id, $this->url_group);
        }
        echo json_encode($data['data']);
    }

    //会员自主领取优惠页面
    public function getcard()
    {
        $card_rule_id = !empty($this->args['card_rule_id']) ? $this->args['card_rule_id'] : 0;
        if ($card_rule_id == 996 && $this->inter_id == 'a449675133')
            $this->check_user_login();

        $data['data'] = array();
        if (!$this->is_restful()) {
            $data = CardService::getInstance()->getcard($this->inter_id, $this->openid, $card_rule_id, $this->_template_filed_names, $this->url_group);
        } else {
            $data['data'] = $this->url_group;
        }
        $data['data']['page_title'] = '豪礼大放送';
        $this->template_show('member', $this->_template, 'getcard', $data['data']);
    }

    //领取卡券
    public function addcard()
    {
        $card_rule_id = !empty($this->args['card_rule_id']) ? $this->args['card_rule_id'] : 0;
        $data = array();
        if (!$this->is_restful()) {
            $data = CardService::getInstance()->addcard($this->inter_id, $this->openid, $card_rule_id);
        }
        echo json_encode($data);
    }

    //卡券转赠页面
    public function givecard()
    {
        redirect(site_url('./upgrade_page'));
        $this->load->model('wx/Publics_model');
        $data = $this->assign_data;
        $data['info'] = $this->Publics_model->get_fans_info($this->openid);
//	    $this->check_user_login();
        //获取卡券的详细
        $card_openid = isset($_GET['cardOpenid']) ? $_GET['cardOpenid'] : $this->openid;
        $member_card_id = isset($_GET['member_card_id']) ? (int)$_GET['member_card_id'] : 0;
        $post_card_info_data = array(
            'token' => $this->_token,
            'inter_id' => $this->inter_id,
            'openid' => $card_openid,
            'member_card_id' => $member_card_id,
        );
        $card_info = $this->doCurlPostRequest(INTER_PATH_URL . "membercard/getinfo", $post_card_info_data);
        if (isset($card_info['data'])) {
            $data['card_info'] = $card_info['data'];
        } else {
            $data['card_info'] = array();
        }
        $data['card_openid'] = $card_openid;
        $data['openid'] = $this->openid;
        $data['inter_id'] = $this->inter_id;
        $this->load->model('wx/access_token_model');
        $this->load->model('wx/Publics_model');
        $data['signpackage'] = $this->access_token_model->getSignPackage($this->inter_id);
        $data['public'] = $this->Publics_model->get_public_by_id($this->inter_id);
        $this->load->model('wx/access_token_model');
        $data['signpackage'] = $this->access_token_model->getSignPackage($this->inter_id);
        $this->template_show('member', $this->_template, 'givecard', $data);
    }

    //转赠卡券挂起
    public function hang_card()
    {
        $member_card_id = !empty($this->args['card_id']) ? $this->args['card_id'] : 0;
        $data = array();
        if (!$this->is_restful()) {
            $data = CardService::getInstance()->hang_card($this->inter_id, $this->openid, $member_card_id);
        }
        echo json_encode($data);
    }

    //转赠优惠券挂起
    public function gift_card()
    {
        $member_card_id = !empty($this->args['mcid']) ? floatval($this->args['mcid']) : 0;
        $module = !empty($this->args['module']) ? $this->args['module'] : '';
        $card_code = !empty($this->args['card_code']) ? trim($this->args['card_code']) : '';
        $data = array();
        if (!$this->is_restful()) {
            $data = CardService::getInstance()->gift_card($this->inter_id, $this->openid, $member_card_id, $module, $card_code);
        }
        echo json_encode($data);
    }

    //转赠优惠券挂起
    public function receive_card()
    {
        $ec_code = !empty($this->args['ec_code']) ? trim($this->args['ec_code']) : 0;
        $data = array();
        if (!$this->is_restful()) {
            $data = CardService::getInstance()->receive_card($this->inter_id, $this->openid, $ec_code, $this->url_group);
        }
        echo json_encode($data);
    }

    //保存卡券转赠信息
    public function savegivecard()
    {
        $openid = isset($this->args['cardOpenid']) ? $this->args['cardOpenid'] : '';
        $card_id = isset($this->args['card_id']) ? $this->args['card_id'] : '';
        $cardModule = 'vip';

        $data = array();
        if (!$this->is_restful()) {
            $data = CardService::getInstance()->savegivecard($this->inter_id, $this->openid, $openid, $card_id, $cardModule);
        }
        echo json_encode($data);
    }


    public function before_receive()
    {
        $this->load->model('wx/Publics_model', 'publics_model');
        $gift_encrypt = $this->input->get('sf');
        $share_interid = $this->input->get('share_interid');
        $share_public = $this->publics_model->get_public_by_id($share_interid);
        $_pattern = "/^((http:\/\/)|(https:\/\/))?([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}/"; //匹配网址域名
        preg_match_all($_pattern, $share_public['domain'], $match);
        if (!$match) {
            $share_domain = $share_public['domain'];
        } else {
            if (strpos($match[0][0], 'http://') !== false OR strpos($match[0][0], 'https://') !== false) {
                $public_host = $match[0][0];
            } else {
                $public_host = "http://{$match[0][0]}";
            }
            $share_domain = $public_host;
        }

        $ec_data = $this->inter_id . $this->openid;
        $key = $share_public['app_secret'];
        $encrypt = kecrypt($ec_data, $key);
        $segments = base64_encode("{$this->inter_id}***{$this->openid}***{$encrypt}");
        $share_url = "{$share_domain}/membervip/cardcenter/receive?id={$share_interid}&f={$segments}&sf={$gift_encrypt}";
        redirect($share_url);
    }

    //卡券详细页面
    public function receive()
    {
        $ec_code = !empty($this->args['sf']) ? trim($this->args['sf']) : '';
        $is_restful = $this->is_restful() ? false : true;
        $data = CardService::getInstance()->receive($this->inter_id, $this->openid, $ec_code, $this->url_group, $is_restful);

        if ($data['status'] == '3' && $data['jump'] == '1') {
            redirect($data['redirect_uri']);
        }
        $data['data']['page_title'] = '领取优惠券';
        $data['data']['sf'] = $ec_code;
        if (!empty($data['data']['iapi']['receive_url'])) $data['data']['iapi']['receive_url'] .= '&sf=' . $ec_code;
        $this->template_show('member', $this->_template, 'receive', $data['data']);
    }

    //卡券详细页面
    public function cardinfo()
    {
        $member_card_id = !empty($this->args['member_card_id']) ? floatval($this->args['member_card_id']) : '';
        $is_restful = $this->is_restful() ? false : true;
        $data = CardService::getInstance()->cardinfo($this->inter_id, $this->openid, $member_card_id, $this->url_group, $is_restful);
        if ($data['status'] == '3' && $data['jump'] == '1') {
            redirect($data['redirect_uri']);
        }

        $data['data']['page_title'] = '优惠券详情';
        $this->template_show('member', $this->_template, 'cardinfo', $data['data']);
    }

    //卡券扫码使用
    public function codeuseoff()
    {
        $data = CardService::getInstance()->codeuseoff($this->inter_id, $this->openid);
        $data['data']['page_title'] = '扫码核销';
        $this->template_show('member', $this->_template, 'codeuseoff', $data['data']);
    }

    /**
     * 扫码核销异步请求
     */
    public function card_callback()
    {
        $code = !empty($this->args['code']) ? $this->args['code'] : '';
        $data = CardService::getInstance()->card_callback($this->inter_id, $this->openid, $code);
        echo json_encode($data);
    }

    /**
     *    消费码核销
     *
     */
    public function passwduseoff()
    {
        $member_card_id = !empty($this->args['member_card_id']) ? floatval($this->args['member_card_id']) : '';
        $passwd = !empty($this->args['passwd']) ? $this->args['passwd'] : '';
        $data = array();
        if (!$this->is_restful()) {
            $data = CardService::getInstance()->passwduseoff($this->inter_id, $this->openid, $member_card_id, $passwd);
        }
        echo json_encode($data);
    }

    //获取会员模式，对用户的操作进行限制
    protected function check_user_login()
    {
        //获取微信会员卡的信息
        $post_center_url = PMS_PATH_URL . "member/center";
        $post_center_data = array(
            'inter_id' => $this->inter_id,
            'openid' => $this->openid,
        );
        //请求用户登录(默认)会员卡信息(注：第一次有可能返回的数据是空)
        $userInfo = $this->doCurlPostRequest($post_center_url, $post_center_data);
        if (isset($userInfo['data'])) {
            $userinfo = $userInfo['data'];
            if ($userinfo['value'] == "login" && $userinfo['member_mode'] == 1) {
                header("Location:" . base_url("index.php/membervip/login?id=" . $this->inter_id));
                exit;
            }
        } else {
            exit('userinfo is error');
        }
    }

    public function getpackage()
    {
        $package_id = isset($this->args['package_id']) ? (int)$this->args['package_id'] : 0;
        $frequency = isset($this->args['frequency']) ? (int)$this->args['frequency'] : 0;
        $card_rule_id = isset($this->args['card_rule_id']) ? intval($this->args['card_rule_id']) : 0;

        $data = array();
        if (!$this->is_restful()) {
            $data = CardService::getInstance()->getpackage($this->inter_id, $this->openid, $package_id, $frequency, $card_rule_id);
        }
        echo json_encode($data);
    }

    /**
     * 获取微信JSSDK配置信息
     * @param $inter_id
     * @param string $url
     * @return array
     */
    protected function _get_sign_package($inter_id, $url = '')
    {
        $this->load->helper('common');
        $this->load->model('wx/publics_model', 'publics');
        $this->load->model('wx/access_token_model');
        $jsapiTicket = $this->access_token_model->get_api_ticket($inter_id);

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        if (!$url)
            $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = createNonceStr();
        $public = $this->publics->get_public_by_id($inter_id);

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


    /*卡券跳转*/
    public function cardcenterredir()
    {
        $this->load->model('wx/Publics_model', 'publics_model');

        //加密参数
        $this->load->helper('qfglobal');
        $public = $this->publics_model->get_public_by_id($this->inter_id);
        $key = $public['app_secret'];
        $ec_data = $this->inter_id . $this->openid;
        $sign = kecrypt($ec_data, $key);
        $card_domain = 'http://test1.lostsk.com/index.php/membervip/cardcenter/?id=a484619482';
//        $url =   $card_domain. $_SERVER ['REQUEST_URI'] ;
        $site_url = prep_url($card_domain . '&f=' . base64_encode($this->inter_id . '***' . $this->openid . '***' . $sign));
        redirect($site_url);
    }

    //通过券码检测优惠券是否已经使用和核销
    public function check_useoff()
    {
        if (is_ajax_request()) {
            $this->load->model('membervip/common/Public_model', 'common_model');
            $coupon_code = $this->input->post("coupon_code");

            $this->load->model('membervip/front/Member_model', 'mem');
            $user = $this->mem->get_user_info($this->inter_id, $this->openid, 'member_info_id');

            $where = array(
                'open_id' => $this->openid,
                'inter_id' => $this->inter_id,
                'coupon_code' => $coupon_code,
                'member_info_id' => !empty($user['member_info_id']) ? $user['member_info_id'] : 0
            );

            $member_card = $this->common_model->get_info($where, 'member_card', 'is_use,is_useoff');
            if (!empty($member_card) && $member_card['is_use'] == 't' && $member_card['is_useoff'] == 't') {
                $this->_ajaxReturn('使用核销成功!', $this->url_group['cardcenter_url'], 1);
            }
            $this->_ajaxReturn('使用核销失败!');
        }
        $this->_ajaxReturn('很抱歉，请求失败，请联系管理员');
    }
}

?>