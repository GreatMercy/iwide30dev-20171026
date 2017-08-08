<?php

namespace App\services\member;

use App\services\MemberBaseService;

/**
 * Class ResetpasswordService
 * @package App\services\member
 * @author lijiaping  <lijiaping@mofly.cn>
 *
 */
class ResetpasswordService extends MemberBaseService
{

    /**
     * 获取服务实例方法
     * @return ResetpasswordService
     */
    public static function getInstance()
    {
        return self::init(self::class);
    }

    //用户重置密码页面
    public function index($inter_id){
        $post_config_url = PMS_PATH_URL."adminmember/getresetconfig";
        $post_config_data =  array(
            'inter_id'=>$inter_id,
            );
        //请求注册配置
        $data['login_config'] = $this->doCurlPostRequest( $post_config_url , $post_config_data )['data'];
        return $data;

    }

    //保存重置密码
    public function saveresetpassword($inter_id,$openid){
        $post_login_url = PMS_PATH_URL."member/resetpassword";
        $post_login_data = array(
            'inter_id'=>$inter_id,
            'openid'=>$openid,
            'phone'=>$this->getCI()->input->post('phone'),
            'data'=>$this->getCI()->input->post(),
            'sms'=>$this->getCI()->input->post('phonesms'),
        );

        //如果有验证码,验证
        $conf_url = PMS_PATH_URL."adminmember/getresetconfig";
        $post_data =  array('inter_id'=>$inter_id);
        //请求登录配置
        $pwdconfig = $this->doCurlPostRequest($conf_url,$post_data);
        $pwdconfig = isset($pwdconfig['data'])?$pwdconfig['data']:array();
        if(isset($pwdconfig['phonesms']) && $pwdconfig['phonesms']['show']=='1' && $pwdconfig['phonesms']['check']=='1'){
            if(!isset($_POST['phonesms'])) {
                return array('err'=>'40003','msg'=>'验证码不存在');
            }
            $checkSmsData = $post_login_data;
            $checkSmsData['data']['sms']=$_POST['phonesms'];
            $checkSmsData['cellphone']=$post_login_data['phone'];
            $checkSmsData['smstype'] = isset($_POST['smstype'])?$_POST['smstype']:4;
            $res = $this->doCurlPostRequest(PMS_PATH_URL."member/checksms",$checkSmsData);
            if($res['err']>0){
                return $res;
            }
        }

        $login_result = $this->doCurlPostRequest( $post_login_url , $post_login_data );
        return $login_result;
    }

    //储值卡重置密码页面
    public function resetbindpwd($inter_id){
        $post_config_url = PMS_PATH_URL."adminmember/getresetconfig";
        $post_config_data =  array(
            'inter_id'=>$inter_id,
        );
        //请求注册配置
        $data['login_config'] = $this->doCurlPostRequest( $post_config_url , $post_config_data )['data'];
        return $data;

    }

    //保存重置密码
    public function saveresetbindpwd($inter_id,$openid){
        $post_login_url = PMS_PATH_URL."member/resetpassword";
        $post_login_data = array(
            'inter_id'=>$inter_id,
            'openid'=>$openid,
            'phone'=>$this->getCI()->input->post('phone'),
            'data'=>$this->getCI()->input->post(),
            'pandc'=>1
        );

        $login_result = $this->doCurlPostRequest( $post_login_url , $post_login_data );
        return $login_result;
    }
}