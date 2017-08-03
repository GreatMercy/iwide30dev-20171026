<?php
use App\services\member\BalanceService;

defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	用户积分 
*	@author  lijiaping
*   @copyright www.iwide.cn
*   @version 4.0
*   @Email lijiaping@mofly.cn
*/
class Balance extends MY_Front_Member
{
	//会员余额记录
	public function index(){
		$data = array();
        if(!$this->is_restful()){
            $data = BalanceService::getInstance()->index($this->inter_id,$this->openid,$this->_token,$this->_template,$this->_template_filed_names);
        }
        $this->template_show('member',$this->_template,'balance',$data);
	}


    //余额支付密码设置
    public function setpwd(){
        $data = array();
        if(!$this->is_restful()){
    	   $data = BalanceService::getInstance()->setpwd($this->inter_id,$this->openid,$this->_token);
        }
        if(!empty($data['redirect'])){
	    	Header( "Location:".$data['redirect'] );exit;
        }
        $this->template_show('member',$this->_template,'setpwd',$data);
    }

    //保存支付密码设置
    public function save_setpwd(){
    	$status = BalanceService::getInstance()->save_setpwd($this->inter_id,$this->openid,$this->_token);
    	echo json_encode($status);
    }

    //余额支付密码修改
    public function changepwd(){
        $data = array();
        if(!$this->is_restful()){
           $data = BalanceService::getInstance()->changepwd($this->inter_id,$this->openid,$this->_token);
        }
        if(!empty($data['redirect'])){
        	Header( "Location:".$data['redirect']);exit;
        }
        $this->template_show('member',$this->_template,'changepwd',$data);
    }

    //保存支付密码修改
    public function save_changepwd(){
    	$status = BalanceService::getInstance()->save_changepwd($this->inter_id,$this->openid,$this->_token);
    	echo json_encode($status);
    }

    public function pay(){
        $data = array();
        if(!$this->is_restful()){
           $data = BalanceService::getInstance()->pay($this->inter_id,$this->openid,$this->_token,$this->_template,$this->_template_filed_names);
        }
        $this->template_show('member',$this->_template,'balancepay',$data);

    }

    public function sub_pay(){
        $status = BalanceService::getInstance()->sub_pay($this->inter_id,$this->openid);
        echo json_encode($status);
    }

    //储值支付成功
    public function okpay(){
        $data = BalanceService::getInstance()->okpay($this->inter_id,$this->openid,$this->_token,$this->_template,$this->_template_filed_names);
        $this->template_show('member',$this->_template,'okpay',$data);
    }

    //储值支付失败
    public function nopay(){
        $data = BalanceService::getInstance()->nopay($this->inter_id);
        $this->template_show('member',$this->_template,'nopay',$data);
    }
}
?>