<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tsadpt extends CI_Controller {

	public function index(){
		$hotel_id = $this->input->get('h') ? $this->input->get('h') : 0;
		
		$param = array('inter_id'=>'a123','hotel_id'=>$hotel_id,'status'=>1,'offset'=>0,'limit'=>10);
		
		$this->load->library('PMS_Adapter',$param);
		echo $this->pms_adapter->get_orders(1,1,1,1,1);
	}
	function test(){
		if($this->input->get('code')){
			$code = $this->input->get ( 'code' );
			$redirect_uri = urldecode($this->input->get ( 'redirect' ));
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx992e5c06624b1a6e&secret=901647c10c10a2b8a0487324d8794706&code=$code&grant_type=authorization_code";
			
			$this->load->helper('common');
			$result = doCurlGetRequest($url);
			var_dump($result);
			die("I'm here...");
		}else{
			redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx992e5c06624b1a6e&redirect_uri=".urlencode('http://mycard.kargocard.com/aaa?code=XXXXXXX')."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect");
		}
	}
}
