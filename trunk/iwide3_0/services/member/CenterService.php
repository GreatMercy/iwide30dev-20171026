<?php

namespace App\services\member;

use App\services\MemberBaseService;
use EA_const_url;
/**
 * Class CenterService
 * @package App\services\member
 * @author lijiaping  <lijiaping@mofly.cn>
 */
class CenterService extends MemberBaseService
{

    private   $res_data = array();
    protected $args = array();

    //加载基本类、设置基础信息
    public function getBase(){
        $this->getCI()->load->library("MYLOG");
        $this->getCI()->load->helper('common_helper');
        $this->getCI()->load->model('wx/Publics_model','Publics_model');
        $this->res_data = array(
            'status'=>2,
            'data'=>array()
        );
    }

    /**
     * 获取服务实例方法
     * @return CenterService
     */
    public static function getInstance()
    {
        return self::init(self::class);
    }

    public function index($inter_id = '',$openid = '', $filed_names = array()){
        //设置优惠券中心链接 - star
        $this->getCI()->load->model('membervip/common/Public_model','member_public');
        $where = array(
            'inter_id'=>$inter_id,
            'type_code'=>'member_card_url'
        );
        $card_host_info = $this->getCI()->member_public->get_info($where,'inter_member_config');
        $card_host = !empty($card_host_info['value'])?$card_host_info['value']:'';
        $card_url = EA_const_url::inst()->get_url('membervip/card');
        if(!empty($card_host)){
            $_card_host = explode(',',$card_host);
            $public_host = !empty($_card_host[0])?$_card_host[0]:'';
            $public_inter_id = !empty($_card_host[1])?$_card_host[1]:'';
            $ec_data = $inter_id.$openid;
            $public = $this->getCI()->Publics_model->get_public_by_id ($inter_id);
            $key = $public['app_secret'];
            $encrypt = urlencode(kecrypt($ec_data,$key));
            $segments = base64_encode("{$inter_id}***{$openid}***{$encrypt}");
            $card_url = "{$public_host}/membervip/cardcenter?id={$public_inter_id}&f={$segments}";
            $data['card_url'] = $card_url;
        }

        $assets_bottons = array();
        foreach ($filed_names as $key => $_name){
            switch ($key){
                case 'credit_name':
                    $assets_bottons[$key] = array(
                        'name'=>$_name,
                        'link'=> EA_const_url::inst()->get_url('membervip/bonus',array('credit_type'=>1))
                    );
                    break;
                case 'balance_name':
                    $assets_bottons[$key] = array(
                        'name'=>$_name,
                        'link'=> EA_const_url::inst()->get_url('membervip/balance',array('credit_type'=>1))
                    );
                    break;
                case 'coupon_name':
                    $assets_bottons[$key] = array(
                        'name'=>$_name,
                        'link'=>$card_url
                    );
                    break;
            }
        }

        $data = array(
            'assets_bottons'=>$assets_bottons,
        );

        $data['info'] = $this->getCI()->Publics_model->get_fans_info_one($inter_id,$openid);
        $post_center_url = PMS_PATH_URL."member/center";
        $post_center_data =  array(
            'inter_id'=>$inter_id,
            'openid' =>$openid,
        );
        //请求用户登录(默认)会员卡信息(注：第一次有可能返回的数据是空)
        $center_data = $this->doCurlPostRequest( $post_center_url , $post_center_data );
        $center_data = $this->parse_curl_msg($center_data);
        $data['centerinfo'] = $center_data['data'];
        //获取会员中心菜单列表
        $post_center_config_url = PMS_PATH_URL."adminmember/get_center_info";
        $post_center_config_data = array(
            'inter_id'=>$inter_id,
        );
        $center_config = $this->doCurlPostRequest( $post_center_config_url , $post_center_config_data );
        $center_config = $this->parse_curl_msg($center_config);
        $center_config = $center_config['data'];
        if(isset($center_config['value'])){
            $data['menukey'] = array_unique( array_column($center_config['value'],'group'));
            sort($data['menukey']);
        }
        //检测是否是分销账号和是否是协议客用户
        $this->getCI()->load->model ( 'distribute/staff_model' );
        $saler_info = $this->getCI()->staff_model->saler_info ( $openid, $inter_id );
        if($saler_info) {
            if ($saler_info && $saler_info ['status'] == 2){
                if(isset($saler_info ['distribute_hidden']) && $saler_info ['distribute_hidden'] == 0){
                    $data['isDistribution'] = 1;
                }else{
                    $data['isDistribution'] = 0;
                }
                $data['is_club'] = $saler_info['is_club'];
            }else{
                $data['isDistribution'] = 0;
                $data['is_club'] = 0;
            }
        }else{
            $data['isDistribution'] = 0;
            $data['is_club'] = 0;
        }
        //检测是否是绑定用户，如果是，绑定过后，，去掉绑定菜单
        if( $data['centerinfo']['value']=='perfect' ){
            if( $data['centerinfo']['id_card_no'] || $data['centerinfo']['pms_user_id'] ){
                $is_binning = true;
            }else{
                $is_binning = false;
            }
        }else{
            $is_binning = false;
        }
        $data['menu'] = isset($center_config['value'])?$center_config['value']:array();

        $g_key = 0;
        $end_group = 1;
        foreach ($data['menu'] as $key => $value) {
            if(isset($data['centerinfo']['is_login']) && $data['centerinfo']['is_login']=='f' && $value['modelname']=='我的电子会员卡') unset($data['menu'][$key]);

            if($data['is_club']==0 && $value['modelname']=='社群客' ){
                unset($data['menu'][$key]);
            }
            if($data['isDistribution']==0 && ($value['modelname']=='全员营销' || $value['modelname']=='分销中心')){
                unset($data['menu'][$key]);
            }

            if($data['isDistribution']==1 && $value['modelname']=='分销注册'){
                unset($data['menu'][$key]);
            }

            if( $is_binning && ($value['modelname']=='会员登录' || $value['modelname']=='会员绑定' || $value['modelname']=='绑定登录' ) ){
                unset($data['menu'][$key]);
            }
        }

        /*扫描权限地址*/
        $this->getCI()->load->model('membervip/common/Public_model','common_model');
        $where = array(
            'openid'=>$openid,
            'inter_id'=>$inter_id
        );

        $scanqr_auth = $this->getCI()->common_model->get_info($where,'scanqr_auth');
        if(!empty($scanqr_auth) && $scanqr_auth['status']==1){
            $end_key = $g_key + 1;
            $data['menu'][$end_key] = array(
                'group'=>$end_group,
                'modelname'=>'扫码核销',
                'ico'=>'ui_icon16',
                'link'=>$scanqr_auth['url'],
            );
        }

        $data['inter_id']=$inter_id;
        $data['filed_name'] = $filed_names;

        $this->res_data['status'] = 1;
        $this->res_data['msg_lvl'] = 1;
        $this->res_data['msg'] = 'ok';
        $this->res_data['data'] = $data;
        return $this->res_data;
    }


    /**
     * 会员卡用户中心
     * @param string $inter_id 微信酒店集团ID
     * @param string $openid 微信用户ID
     * @param array $filed_names 字典
     * @param boolean $is_restful 皮肤类型「false: view ，true: api」
     * @return array
     */
    public function member_center($inter_id = '',$openid = '', $filed_names = array(),$is_restful = false){
        $this->getBase(); //加载基本类、设置基础信息

        $this->getCI()->load->model('membervip/common/Public_model','common_model');
        //设置优惠券中心链接 - star
        $where = array(
            'inter_id'=>$inter_id,
            'type_code'=>'member_card_url'
        );
        $card_host_info = $this->getCI()->common_model->get_info($where,'inter_member_config');
        $card_host = !empty($card_host_info['value'])?$card_host_info['value']:'';
        $card_url = EA_const_url::inst()->get_url('membervip/card');
        if(!empty($card_host)){
            $_card_host = explode(',',$card_host);
            $public_host = !empty($_card_host[0])?$_card_host[0]:'';
            $public_inter_id = !empty($_card_host[1])?$_card_host[1]:'';
            $ec_data = $inter_id.$openid;
            $public = $this->getCI()->Publics_model->get_public_by_id ($inter_id);
            $key = $public['app_secret'];
            $encrypt = urlencode(kecrypt($ec_data,$key));
            $segments = base64_encode("{$inter_id}***{$openid}***{$encrypt}");
            $card_url = "{$public_host}/membervip/cardcenter?id={$public_inter_id}&f={$segments}";
        }

        $assets_bottons = array();
        foreach ($filed_names as $key => $_name){
            switch ($key){
                case 'credit_name':
                    $assets_bottons[$key] = array(
                        'name'=>$_name,
                        'link'=> EA_const_url::inst()->get_url('membervip/bonus',array('credit_type'=>1))
                    );
                    break;
                case 'balance_name':
                    $assets_bottons[$key] = array(
                        'name'=>$_name,
                        'link'=> EA_const_url::inst()->get_url('membervip/balance',array('credit_type'=>1))
                    );
                    break;
                case 'coupon_name':
                    $assets_bottons[$key] = array(
                        'name'=>$_name,
                        'link'=>$card_url
                    );
                    break;
            }
        }

        $web_data = array(
            'assets_bottons'=>$assets_bottons,
        );


        $web_data['info'] = $this->getCI()->Publics_model->get_fans_info_one($inter_id,$openid);
        $post_center_url = PMS_PATH_URL."member/center";
        $post_center_data =  array(
            'inter_id'=>$inter_id,
            'openid' =>$openid,
        );
        //请求用户登录(默认)会员卡信息(注：第一次有可能返回的数据是空)
        $center_data = $this->doCurlPostRequest($post_center_url,$post_center_data);
        $center_data = $this->parse_curl_msg($center_data);
        if(empty($center_data['data'])){
            $this->res_data['msg_lvl'] = 2;
            $this->res_data['msg'] = '加载出错';
            return $this->res_data;
        }
        $web_data['centerinfo'] = $center_data['data'];

        //获取会员中心菜单列表
        $post_center_config_url = PMS_PATH_URL."adminmember/get_member_center_info";
        $post_center_config_data = array(
            'inter_id'=>$inter_id,
        );
        $center_config = $this->doCurlPostRequest( $post_center_config_url , $post_center_config_data );
        $_config = $this->parse_curl_msg($center_config);
        if(empty($_config['data'])){
            $this->res_data['msg_lvl'] = 2;
            $this->res_data['msg'] = '加载配置出错';
            return $this->res_data;
        }
        $center_config = $_config['data'];
        //检测是否是分销账号和是否是协议客用户
        $this->getCI()->load->model ( 'distribute/staff_model' );
        $saler_info = $this->getCI()->staff_model->saler_info ( $openid, $inter_id );
        if($saler_info) {
            if ($saler_info && $saler_info ['status'] == 2){
                if(isset($saler_info ['distribute_hidden']) && $saler_info ['distribute_hidden'] == 0){
                    $web_data['isDistribution'] = 1;
                }else{
                    $web_data['isDistribution'] = 0;
                }
                $web_data['is_club'] = $saler_info['is_club'];
            }else{
                $web_data['isDistribution'] = 0;
                $web_data['is_club'] = 0;
            }
        }else{
            $web_data['isDistribution'] = 0;
            $web_data['is_club'] = 0;
        }
        //检测是否是绑定用户，如果是，绑定过后，，去掉绑定菜单
        if( $web_data['centerinfo']['value']=='perfect' ){
            if( $web_data['centerinfo']['id_card_no'] || $web_data['centerinfo']['pms_user_id'] ){
                $is_binning = true;
            }else{
                $is_binning = false;
            }
        }else{
            $is_binning = false;
        }
        $web_data['menu'] = isset($center_config['nav_conf'])? json_decode($center_config['nav_conf'],true):array();


        $this->getCI()->load->model ( 'club/Clubs_model' );
        $show_club= $this->getCI()->Clubs_model->show_club_reg ($inter_id, $openid, $center_data['data']['member_lvl_id']);
        if(!empty($web_data['menu'])){
            $g_key = 0;
            foreach($web_data['menu'] as $group_key => &$group_menu){
                $g_key = $group_key;
                foreach($group_menu as $menu_key => &$menu_link){
                    switch($menu_link['modelname']){
                        case '我的电子会员卡':
                            if(isset($web_data['centerinfo']['is_login']) && $web_data['centerinfo']['is_login']=='f')
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            break;
                        case '社群客':
                            if($web_data['is_club']==0)
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            break;
                        case '激活社群客':
                            if($show_club['status']!=1)
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            break;
                        case '全员营销':
                            if($web_data['isDistribution']==0)
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            break;
                        case '分销中心':
                            if($web_data['isDistribution']==0)
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            break;
                        case '分销注册':
                            if($web_data['isDistribution']==1)
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            break;
                        case '会员登录':
                            if($is_binning)
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            break;
                        case '会员绑定':
                            if($is_binning)
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            break;
                        case '绑定登录':
                            if($is_binning)
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            break;
                        case '购买会员卡'://洲际购买会员卡定制，只有审核通过会员才显示
                            if($web_data['centerinfo']['member_lvl_id']=='609'&&$this->inter_id=='a483582961')
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            break;
                        case '收益中心':        //仅泛分销员可见，粉丝与分销员不可见
                            $this->getCI()->load->model('distribute/Idistribute_model');
                            $fansInfo = $this->getCI()->Idistribute_model->fans_is_saler($inter_id,$openid);
                            if(!$fansInfo){  //非分销人员
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            }else{
                                $salesInfo = json_decode($fansInfo,true);
                                if($salesInfo['typ'] != 'FANS'){    //非泛分销人员
                                    unset($web_data['menu'] [$group_key][$menu_key]);
                                }
                            }
                            break;
                        case '提交资料':
                            if($web_data['centerinfo']['member_lvl_id'] == '958')
                                unset($web_data['menu'] [$group_key][$menu_key]);
                            break;
                        default:
                            break;
                    }
                }
            }

            /*扫描权限地址*/
            $where = array(
                'openid'=>$openid,
                'inter_id'=>$inter_id
            );

            $scanqr_auth = $this->getCI()->common_model->get_info($where,'scanqr_auth');
            if(!empty($scanqr_auth) && $scanqr_auth['status']==1){
                $end_key = $g_key + 1;
                $web_data['menu'][$end_key][0] = array(
                    'icon'=>'ui_icon16',
                    'modelname'=>'扫码核销',
                    'link'=>$scanqr_auth['url'],
                    'is_login'=>2,
                    'listorder'=>0
                );
            }

            $web_data['menu'] = self::parseMenuKeyMaping($web_data['menu'],$is_restful);
        }

        $web_data['inter_id'] = $inter_id;
        $web_data['filed_name'] = $filed_names;
        $this->res_data['status'] = 1;
        $this->res_data['msg_lvl'] = 1;
        $this->res_data['msg'] = 'ok';
        $this->res_data['data'] = $web_data;
        return $this->res_data;
    }

    /**
     * 会员卡用户资料
     * @param string $inter_id 微信酒店集团ID
     * @param string $openid 微信用户ID
     * @param string $type 输出格式，iapi-前后端分离，template-模版输出
     * @return array
     */
    public function info($inter_id = '', $openid = '',$type = 'iapi'){
        $this->getBase();
        $post_config_url = PMS_PATH_URL."adminmember/getmodifyconfig";
        $post_config_data =  array(
            'inter_id'=>$inter_id,
        );
        //请求资料信息
        $data['modify_config'] = $this->doCurlPostRequest( $post_config_url , $post_config_data )['data'];
        $post_center_url = PMS_PATH_URL."member/center";
        $post_center_data =  array(
            'inter_id'=>$inter_id,
            'openid' =>$openid,
        );
        //请求用户登录(默认)会员卡信息
        $data['info'] =$this->getCI()->Publics_model->get_fans_info_one($inter_id,$openid);
        $curl_result = $this->doCurlPostRequest( $post_center_url , $post_center_data );
        if(!empty($curl_result['data']['birth'])) $curl_result['data']['birth_date'] = date('Y-m-d',$curl_result['data']['birth']);
        if($type == 'iapi')
            $data['curl_data']['centerinfo'] = $curl_result;
        elseif ($type == 'template'){
            $centerinfo = $this->parse_curl_msg($curl_result);
            $data['centerinfo'] = $centerinfo['data'];
        }
        $data['inter_id'] = $inter_id;
        $this->res_data['status'] = 1;
        $this->res_data['msg_lvl'] = 1;
        $this->res_data['msg'] = 'ok';
        $this->res_data['data'] = $data;
        return $this->res_data;
    }

    /**
     * 储值卡二维码页面
     * @param string $inter_id 微信酒店集团ID
     * @param string $openid 微信用户ID
     * @param string $type 输出格式，iapi-JSON输出，template-模版输出
     * @return array
     */
    public function qrcode($inter_id = '',$openid = '',$type = 'iapi'){
        $data = array();
        $post_center_url = PMS_PATH_URL."member/center";
        $post_center_data =  array(
            'inter_id'=>$inter_id,
            'openid' =>$openid,
        );
        //请求用户登录(默认)会员卡信息
        $curl_result = $this->doCurlPostRequest($post_center_url,$post_center_data);
        if($type == 'iapi')
            $data['curl_data']['centerinfo'] = $curl_result;
        elseif ($type == 'template'){
            $centerinfo = $this->parse_curl_msg($curl_result);
            $data['centerinfo'] = $centerinfo['data'];
        }
        $this->res_data['status'] = 1;
        $this->res_data['msg_lvl'] = 1;
        $this->res_data['msg'] = 'ok';
        $this->res_data['data'] = $data;
        return $this->res_data;
    }

    static private function parseMenuKeyMaping($menus = array(),$flag = false){
        if(!$flag OR empty($menus)) return $menus;
        foreach ($menus as $key => &$menu){
            if(!empty($menu)){
                $menu_icon_conf = self::menu_icon_conf();
                foreach ($menu as  &$men){
                    if(isset($men['icon'])) $men['icon'] = !empty($menu_icon_conf[$men['icon']])?$menu_icon_conf[$men['icon']]:$men['icon'];
                }
            }
        }
        return $menus;
    }

    static private function menu_icon_conf(){
        return array(
            'ui_icon1' => '&#xe677;', //我的资料
            'ui_icon2' => '&#xe62d;', //酒店订单
            'ui_icon3' => '&#xe629;', //商城订单
            'ui_icon4' => '&#xe628;', //在线预订
            'ui_icon5' => '&#xe657;', //我的收藏
            'ui_icon6' => '&#xe67a;', //我的地址
            'ui_icon7' => '&#xe66d;', //全员分销
            'ui_icon8' => '&#xe621;', //社群客
            'ui_icon9' => '&#xe678;', //关于金房卡
            'ui_icon10' => '&#xe682;', //签到
            'ui_icon11' => '&#xe62e;', //我的余额
            'ui_icon12' => '&#xe679;', //记录
            'ui_icon13' => '&#xe67b;', //绑定
            'ui_icon14' => '&#xe62c;', //充值
            'ui_icon15' => '&#xe620;', //购买会员卡
            'ui_icon16' => '&#xe632;', //扫码核销
            'ui_icon37' => '&#xe61f;', //我的权益
        );
    }
}