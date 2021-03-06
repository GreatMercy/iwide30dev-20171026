<?php

namespace App\services\member;

use App\services\MemberBaseService;

/**
 * Class LoginService
 * @package App\services\member
 * @author lijiaping  <lijiaping@mofly.cn>
 *
 */
class LoginService extends MemberBaseService
{

    /**
     * 获取服务实例方法
     * @return LoginService
     */
    public static function getInstance()
    {
        return self::init(self::class);
    }

    /**
     * 检查是否为已登录的会员卡
     * @param string $inter_id 酒店集团ID
     * @param string $openid 微信用户ID
     * @return bool|integer
     */
    public function check_member_card_ogin($inter_id = '', $openid = ''){
        $this->getCI()->load->model('membervip/front/Member_model', 'member_model');
        $userinfo = $this->getCI()->member_model->get_user_info($inter_id,$openid,'member_info_id,member_mode,is_login');
        if(empty($userinfo) OR $userinfo['member_mode'] == 1 OR $userinfo['is_login'] == 'f') return false;
        return $userinfo['member_info_id'];
    }

    //会员卡登录页面
    public function index($inter_id){
        $post_config_url = PMS_PATH_URL."adminmember/getloginconfig";
        $post_config_data =  array(
            'inter_id'=>$inter_id,
        );
        //请求登录配置
        $login_config = array();
        $login_conf = $this->doCurlPostRequest( $post_config_url , $post_config_data );
        if(isset($login_conf['data']) && !empty($login_conf['data'])){
            $login_config = $login_conf['data'];
        }
        //'^[1][35789][0-9]{9}$'
        if($inter_id=='a421641095'){
            if(isset($login_config['phone']) && isset($login_config['phone']['regular']) && !empty($login_config['phone']['regular'])){
                $login_config['phone']['regular'] = '^[0-9]{6,}$';
            }
        }
        $data['login_config'] = $login_config;
        $data['inter_id'] = $inter_id;
        if ($this->getCI()->input->get('redir')){
            $data['succ_url']=urldecode(substr($_SERVER ['REQUEST_URI'],strpos($_SERVER ['REQUEST_URI'],'redir=')+6));
            $data['redir']=urlencode(substr($_SERVER ['REQUEST_URI'],strpos($_SERVER ['REQUEST_URI'],'redir=')+6));
        }else {
            $data['succ_url']=site_url('membervip/center').'?id='.$inter_id;
            $data['redir']='';
        }
        return $data;
    }

    //绑定登录模式
    public function binning_login($inter_id){
        $post_config_url = PMS_PATH_URL."adminmember/getloginconfig";
        $post_config_data =  array(
            'inter_id'=>$inter_id,
            );
        //请求登录配置
        $data['login_config'] = $this->doCurlPostRequest( $post_config_url , $post_config_data )['data'];

        return $data;
    }

    //储值卡绑定
    public function bindcard($inter_id){
        $post_config_url = PMS_PATH_URL."adminmember/getloginconfig";
        $post_config_data =  array(
            'inter_id'=>$inter_id,
        );
        //请求登录配置
        $data['login_config'] = $this->doCurlPostRequest( $post_config_url , $post_config_data )['data'];

        return $data;
    }

    //保存储值卡绑定
    public function savebindcard($inter_id,$openid){
        $bind_url = PMS_PATH_URL."member/bindcard";
        $bind_data = array(
            'inter_id'=>$inter_id,
            'openid'=>$openid,
            'data'=>$_POST,
        );
        $bind_result = $this->doCurlPostRequest( $bind_url , $bind_data );

        return $bind_result;
    }

    //登录保存
    public function savelogin($inter_id,$openid){
        $this->getCI()->session->unset_tempdata($inter_id.'vip_user');
        $post_login_url = PMS_PATH_URL."member/login";
        if($inter_id == 'a480304439'){ //优程定制
            $this->getCI()->load->model ( 'distribute/Fans_model' );
            $fans = $this->getCI()->Fans_model->get_fans_beloning($inter_id,$openid);
            if(!empty($fans)){
                $_POST['hotel_id']  = ($fans->hotel_id > 0 ) ? $fans->hotel_id : '' ;
            }
        }
        $post_login_data = array(
            'inter_id'=>$inter_id,
            'openid'=>$openid,
            'data'=>$_POST,
            'add_type'=>'login'
        );

        //如果有验证码,验证
        $conf_url = PMS_PATH_URL."adminmember/getloginconfig";
        $post_data =  array('inter_id'=>$inter_id);
        //请求登录配置
        $loginconfig = $this->doCurlPostRequest($conf_url,$post_data);
        $loginconfig = isset($loginconfig['data'])?$loginconfig['data']:array();
        if(isset($loginconfig['phonesms']) && $loginconfig['phonesms']['show']=='1' && $loginconfig['phonesms']['check']=='1'){
            if(!isset($_POST['phonesms'])) {
                return array('err'=>'40003','msg'=>'验证码不存在');
            }
            $checkSmsData = $post_login_data;
            $checkSmsData['data']['sms']=$_POST['phonesms'];
            $checkSmsData['phone']=isset($_POST['phone'])?$_POST['phone']:0;
            $checkSmsData['cellphone']=$checkSmsData['phone'];
            $checkSmsData['sms']=$_POST['phonesms'];
            $checkSmsData['smstype'] = isset($_POST['smstype'])?$_POST['smstype']:2;
            $res = $this->doCurlPostRequest(PMS_PATH_URL."member/checksms",$checkSmsData);
            if($res['err']>0){
                return $res;
            }
        }
        
        $login_result = $this->doCurlPostRequest( $post_login_url , $post_login_data );
        if($login_result['err']=='0'){
            $member_info_id = $login_result['data']['member_info_id'];
            $this->getCI()->session->set_userdata($inter_id.$openid.'_member_info_id',$member_info_id);
            $this->getCI()->session->set_userdata($inter_id.$openid.'_logined',1);

            $this->getCI()->load->model('membervip/front/Member_model');
            $this->getCI()->Member_model->check_user_info($inter_id,$openid);
        }
        return $login_result;
    }

    public function wxlogin($inter_id = '', $openid = ''){
        $wx_login_data = array(
            'inter_id'=>$inter_id,
            'openid'=>$openid,
            'data'=>$_POST,
        );
        $wx_login_url = PMS_PATH_URL."member/wxlogin";
        $login_result = $this->doCurlPostRequest($wx_login_url, $wx_login_data);
        if($login_result['err']=='0'){
            $member_info_id = $login_result['data']['member_info_id'];
            $this->getCI()->session->set_userdata($inter_id.$openid.'_member_info_id',$member_info_id);
            $this->getCI()->session->set_userdata($inter_id.$openid.'_logined',1);

            $this->getCI()->load->model('membervip/front/Member_model');
            $this->getCI()->Member_model->check_user_info($inter_id,$openid);
        }
        return $login_result;
    }

    //退出登录
    public function outlogin($inter_id,$openid){
        $this->getCI()->session->unset_tempdata($inter_id.'vip_user');
        $post_login_url = PMS_PATH_URL."member/outlogin";
        $post_login_data = array(
            'inter_id'=>$inter_id,
            'openid'=>$openid,
            );
        $login_result = $this->doCurlPostRequest( $post_login_url , $post_login_data );
        if($login_result['err']=='0'){
            $this->getCI()->session->set_userdata($inter_id.$openid.'_logined',0);
            $this->getCI()->load->model('membervip/front/Member_model');
            $this->getCI()->Member_model->check_user_info($inter_id,$openid);
        }
        return $login_result;
    }
}