<?php
use App\services\member\DepositcardService;

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *  用户购卡
 *  @author  lijiaping
*   @copyright www.iwide.cn
*   @version 4.0
*   @Email lijiaping@mofly.cn
 */
class Depositcard extends MY_Front_Member
{


    //会员可购卡列表
    public function index(){

        $data = DepositcardService::getInstance()->index($this->inter_id,$this->openid,$this->_token,$this->_template,$this->_template_filed_names);
        if(!empty($data['redirect'])){
            redirect($data['redirect']);exit;
        }
        if(!empty($data['err'])){
            echo $data['msg'];exit;
        }
        $this->template_show('member',$this->_template,'depositcard',$data);
    }

    //会员购卡详细信息
    public function info(){
        $data = DepositcardService::getInstance()->info($this->inter_id,$this->openid,$this->_token,$this->_template,$this->_template_filed_names);
        if(!empty($data['redirect'])){
            redirect($data['redirect']);exit;
        }
        if(!empty($data['err'])){
            echo $data['msg'];exit;
        }
        $this->load->view('member/'.$this->_template.'/depositcardinfo',$data);
    }

    /**
     * 开始购卡(所有的优先进入这个页面,当查询到信息后，检测到需要填写信息则,开始跳转否则,跳转支付)
     */
    public function buycard(){
        $data = DepositcardService::getInstance()->buycard($this->inter_id,$this->openid);
        if(!empty($data['redirect'])){
            redirect($data['redirect']);exit;
        }
        if(!empty($data['err'])){
            $this->_ajaxReturn($data['msg'],null,0);
        }else{
            $this->_ajaxReturn($data['msg'],$data['data'],1);
        }

    }

    //
    public function pay(){
         $data = DepositcardService::getInstance()->pay($this->inter_id,$this->openid,$this->_token);
        if(!empty($data['redirect'])){
            redirect($data['redirect']);exit;
        }
        echo $data['msg'];
    }

    /**
     *	储值
     *
     *
     */
    public function buydeposit(){
        $data = DepositcardService::getInstance()->buydeposit($this->inter_id,$this->openid,$this->_token,$this->_template,$this->_template_filed_names);
        if(!empty($data['redirect'])){
            redirect($data['redirect']);exit;
        }
        $this->template_show('member',$this->_template,'buydeposit',$data);
    }

    //填写分销信息
    public function edituser(){
        $data = DepositcardService::getInstance()->edituser($this->inter_id,$this->openid,$this->_token,$this->_template);
        if(!empty($data['redirect'])){
            redirect($data['redirect']);exit;
        }
        $this->template_show('member',$this->_template,'depositcardedit',$data);
    }

    //创建储值订单
    public function save_deposit_order(){
        $data = DepositcardService::getInstance()->save_deposit_order($this->inter_id,$this->openid,$this->_token);
        echo json_encode($data);
    }
    //开始创建订单
    public function save_order(){
        $data = DepositcardService::getInstance()->save_order($this->inter_id,$this->openid,$this->_token);
        if(!empty($data['err'])){
            $this->_ajaxReturn($data['msg'],null,0);
        }else{
            $this->_ajaxReturn($data['msg'],$data['data'],$data['err']);
        }
    }

    //支付成功
    public function okpay(){
        $data = DepositcardService::getInstance()->okpay($this->inter_id,$this->openid,$this->_token,$this->_template,$this->_template_filed_names);
        $this->load->view('member/'.$this->_template.'/okpay',$data);
    }
    //支付失败
    public function nopay(){
        $data = DepositcardService::getInstance()->nopay($this->inter_id);
        $this->load->view('member/'.$this->_template.'/nopay',$data);
    }

    // /**
    //  * 把请求/返回记录记入文件
    //  * @param String content
    //  * @param String type
    //  */
    // protected function vip_order_write_log( $content, $type='request' )
    // {
    //     DepositcardService::vip_order_write_log($this->inter_id)->nopay($content,$type);
    // }

    

    // /**
    //  * 把请求/返回记录记入文件
    //  * @param String content
    //  * @param String type
    //  */
    // protected function api_write_log( $content, $type='request' )
    // {
    //     DepositcardService::vip_order_write_log($this->inter_id)->api_write_log($content,$type);
    // }

    /**
     * *更改泛分销状态
     */
    public function update_distribution_stats(){
        $data = DepositcardService::getInstance()->update_distribution_stats($this->inter_id,$this->openid);
        if(!empty($data['redirect'])){
            redirect($data['redirect']);exit;
        }
        echo json_encode($data);

    }

    /*更新购买者信息*/
    public function update_order_buyer(){
        $data = DepositcardService::getInstance()->update_order_buyer($this->inter_id,$this->openid);
        if(!empty($data['err'])){
            $this->_ajaxReturn($data['msg'],null,0);
        }else{
            $this->_ajaxReturn($data['msg'],$data['data'],$data['err']);
        }

    }

    
}
?>