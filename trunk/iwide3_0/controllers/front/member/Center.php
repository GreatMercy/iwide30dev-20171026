<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Center extends MY_Front
{


    public function __construct()
    {
        parent::__construct();
        /*2016-07-07莫林切换新会员中心，处理公众号链接生效时间增加，次日删除*/
        if($this->inter_id == 'a452223043'){
            //微信返回的信息显示没有关注，则进行高级授权验证
            if( isset($_SERVER['SERVER_SOFTWARE']) && $_SERVER['SERVER_SOFTWARE']=='nginx' )
                $refer =  'http://'. $_SERVER ['HTTP_HOST']. $_SERVER ['REQUEST_URI'] ;
            else
                $refer =  'http://'. $_SERVER ['SERVER_NAME']. $_SERVER ['REQUEST_URI'] ;
            $refer = str_replace('/member/','/membervip/',$refer);
            redirect($refer);
        }

    }

	protected function getOpenId()
	{
		return $this->openid;
	}
	
	public function qrcode()
	{
		$openid = $this->getOpenId();
		$this->load->model('member/imember');
		$data['member'] = $this->imember->getMemberDetailByOpenId($openid,$this->inter_id,0);
		$this->display('member/qrcode', $data);
	}
	
	public function index()
	{
		$openid = $this->getOpenId();
		$this->load->model('wx/Publics_model');
		$data['info'] =$this->Publics_model->get_fans_info($openid);
		$data['publicinfo'] = $this->Publics_model->get_public_by_id($this->inter_id);
		//检测信息，如果没有则新增一份
		$this->load->model('member/member','member');
		$addUserInfo = $this->member->addUserInfo( $this->inter_id , $openid );
		$this->load->model('member/imember');

        //通过openid登录
        $this->imember->loginWithOpenid($openid,$this->inter_id,0);

		//查询会员信息是否存在
		$member = $this->imember->getMemberDetailByOpenId($openid,$this->inter_id,0);
		if($member && isset($member->mem_id)) {
			$this->imember->getMemberLevel($member);
			$data['member'] = $member;
		} else {
			$result = $this->imember->initMember($openid, array(), $this->inter_id,0);
			if($result) {
				if(!empty($data['info']['nickname'])) {
					$namearr = array('name'=>$data['info']['nickname']);
					$this->imember->addMemberInfo($openid,$data);
				}
				
				$member = $result;
				if($member && isset($member->mem_id)) {
					$this->imember->getMemberLevel($member);
					$data['member'] = $member;
				}
			}
		}
		//检测是否是分销账号
		$this->load->model ( 'distribute/staff_model' );
		$saler_info = $this->staff_model->saler_info ( $openid, $this->inter_id );
		if($saler_info) {
			if ($saler_info && $saler_info ['status'] == 2){
				$data['isDistribution'] = 1;
                $data['is_club']=$saler_info['is_club'];
			}else{
				$data['isDistribution'] = 0;
                $data['is_club']=0;
			}
		}
		
		$data['member'] = $this->imember->modifiedMember($openid, $data['member'], $this->inter_id, 0);

        $this->load->model('wx/access_token_model');
		$data['signpackage'] = $this->access_token_model->getSignPackage($this->inter_id);


//        //卡券
//        //authorBy Jake
        $this->load->model('member/imember');
        $cards = $this->imember->getIgetcard($openid);

        //原逻辑
//		$this->load->model('member/igetcard');
//        $cards = $this->igetcard->getCardsByOpenid($openid);
		$data['card_num'] = count($cards);

		$data['openid'] = $openid;
		
		$this->load->model('member/iconfig');
		$info = $this->iconfig->getConfig('basicinfo',true,$this->session->get_admin_inter_id());
		if($info) {
			$data['basicinfo'] = $info->value;
		} else {
			$data['basicinfo'] = array();
		}
		$membermodel = $this->iconfig->getConfig('membermodel',false,$this->inter_id);
		if($membermodel) $data['membermodel'] = $membermodel->value;
		if($this->session->has_userdata('message')){
			$data['message'] = $this->session->message;
			$this->session->unset_userdata('message');
		}
        $data['inter_id']=$this->inter_id;

		$this->display('member/index/center', $data);
	}
	
	public function userinfo()
	{
		$openid = $this->getOpenId();
		
		//$memid = $this->input->get('mem_id');

		$this->load->model('member/imember');
		$memberinfo = $this->imember->getMemberDetailByOpenId($openid);
		$data['memberinfo'] = $memberinfo;

// 		$this->load->model('member_model');
// 		$data['info'] =$this->member_model->get_fans_info($openid);
		$this->load->model('wx/Publics_model');
		$data['info'] =$this->Publics_model->get_fans_info($openid);
		$this->load->model('wx/access_token_model');
		$data['signpackage'] = $this->access_token_model->getSignPackage($this->inter_id);
		$data['inter_id'] = $this->inter_id;
		if($memberinfo) {
			$this->load->model('member/iconfig');
			
			$membermodel = $this->iconfig->getConfig('membermodel',false,$this->inter_id);
			if($membermodel && $membermodel->value=='login' && !$memberinfo->is_login) {
				redirect('member/center');
				exit;
			}
			
			if($membermodel) $data['membermodel'] = $membermodel->value;
			
			$data['fields'] = array();
			if($this->iconfig->getConfig('register_fields',true,$this->inter_id)) {
			    $data['fields'] = $this->iconfig->getConfig('register_fields',true,$this->inter_id)->value;
			}
			
			$this->display('member/userinfo', $data);
		} else {
			redirect('member/perfectinfo');
		}
	}
	
	public function saveaddress()
	{	
		$memid = $this->input->get('memid');
		$data = $this->input->post();

		if($memid) {
			$this->load->model('member/iaddress');
			$data['mem_id'] = intval($memid);
			
			if(isset($data['address_id']) && !empty($data['address_id'])) {
				$address_id = intval($data['address_id']);
				unset($data['address_id']);
				$this->iaddress->updateAddress($address_id, $data);
			} else {
				$this->iaddress->createAddress($data);
			}
		}
		
		redirect('member/center/addresslist?memid='.$memid);
	}
	
	public function addresslist()
	{		
		$memid = $this->input->get('memid');
		
		$this->load->model('member/iaddress');
		$addressList = $this->iaddress->getAddressList($memid);
		
		$data['memid'] = $memid;
		$data['addresslist'] = $addressList;
		$this->display('member/address', $data);
	}
	
	public function editaddress()
	{	
		$memid = $this->input->get('memid');
		$address_id = $this->input->get('address_id');
		
		$data['memid'] = intval($memid);
		
		if($address_id) {
		    $this->load->model('member/iaddress');
		    $address = $this->iaddress->getAddress($address_id);
		    if($address) $data['address'] = $address;
		}
		
		$this->display('member/editaddress', $data);
	}
	
	public function smsvalid()
	{
		$openid = $this->getOpenId();
		$getsms = $this->input->get("sms");
		$this->load->model('member/imember');
		$result = $this->imember->checkSendSms($openid,$getsms,$this->inter_id,0);
		echo $result;
	}
	//检查图片验证码
	public function smspicvalid()
	{
		$getsms = $this->input->get("smspic");
		if($_SESSION['code'] == $getsms){
			echo 1;
		}else 
			echo 0;
	}

	public function sendsms()
	{		
		$telephone = $this->input->get("telephone");
		$num = mt_rand(100000, 999999);

		$this->session->set_userdata('sms', $num);

		$this->load->model('member/imember');
		$result = $this->imember->sendSms($_GET, $num , $this->inter_id, 0);
		echo $result;
	}

	public function sendsmsother()
	{		
		$telephone = $this->input->get("telephone");
		$num = mt_rand(100000, 999999);

		$this->session->set_userdata('sms', $num);

		$this->load->model('member/imember');
		$result = $this->imember->sendSms($_GET, $num , $this->inter_id, 0);
		if($result == '发送成功'){
			echo json_encode(array('data'=>'ok'));
		}else{
			echo json_encode(array('data'=>'fail'));
		}
	}

	/**
	 * 碧桂园酒店发送短信
	 * @auhtor kngiht
	 * @return unknow
	 */
	public function sendbgysms(){
		$telephone = $this->input->get("telephone");
		if(empty($telephone)){
			echo json_encode(array('data'=>'fail'));
		}
		$num = mt_rand(100000, 999999);
		$this->session->set_userdata('sms', $num);
		$this->load->model('member/imember');
		$result = $this->imember->sendBgySms($_GET, $num , $this->inter_id, 0);
		if($result){
			echo json_encode(array('data'=>'ok'));
		}else{
			echo json_encode(array('data'=>'fail'));
		}
	}

	//发送找回密码短信
	public function sendsmspassword(){

        //图片验证
        $picCode = $this->input->get('picCode');
        if(!empty($picCode)){

//            $this->db->inset( 'iwide_weixin_text',array('content'=>json_encode()));
            $x = json_encode(array('sessionCode'=>$this->session->code,'userCode'=>$picCode));
            $this->db->query("insert into `iwide_weixin_text` (content,edit_date) value( '{$x}',NOW())");
            if($this->session->has_userdata('code') && ($picCode != $this->session->code)){
                $result = '验证码不正确';
                echo ($result);
                exit;
            }
        }

		$telephone = $this->input->get("telephone");
		$num = mt_rand(100000, 999999);

		$this->session->set_userdata('sms', $num);
		$this->load->model('member/imember');
		$result = $this->imember->sendSetPassword($telephone, $num, $this->inter_id, 0);
		echo $result;
	}

	//短信获取用户信息页面
	public function getuserinfo(){
		$openid = $this->getOpenId();
		$this->load->model('member/imember');
		$member = $this->imember->getMemberByOpenId($openid,$this->inter_id,0);
		//考虑到兼容，新增跳转
		//$this->imember->headerUrlCenter();
		if(!$member || !isset($member->mem_id)) {
			redirect('member/center');
		}
	
		$this->load->model('member/iconfig');
		$fields = $this->iconfig->getConfig('register_fields',true,$this->inter_id);
		if($fields) {
			$data['fields'] = $this->iconfig->getConfig('register_fields',true,$this->inter_id)->value;
		} else {
			$data['fields'] = array();
		}
		$this->load->model('wx/access_token_model');
		$data['signpackage'] = $this->access_token_model->getSignPackage($this->inter_id);
		$this->display('member/ym_register',$data);
	}
	//发送短信
	public function usersendsms()
	{		
		$telephone = $this->input->get("telephone");
		$num = mt_rand(100000, 999999);
		$this->session->set_userdata('sms', $num);
		$this->load->model('member/Sms','sms');
		$this->sms->setLog();
		$result = $this->sms->Sendsms( $telephone ,array($num) , '60225' );
		echo $result['msg'];
	}
	//开始拉取用户信息
	public function saveuserinfo(){
		$openid = $this->getOpenId();
		$data['telephone'] = $this->input->post('telephone');
		$data['sms'] = $this->input->post('sms');
		//var_dump($data);
		$this->load->model('member/imember');
		$result = $this->imember->loginGetUserinfo($openid,$data, $this->inter_id,0);
		//var_dump($result);
		if($result) {
			$this->session->set_userdata('message', "登录成功！");
			redirect('member/center');
		} else {
			$this->session->set_userdata('message', "登录失败！");
		}
		redirect('member/center');
	}
	
/*	public function test_reduce()
	{
		 $post['hotelGroupId']='2';
			//$data['hotelId']=$post['hotelId'];
			$post['cardId']='168404';
			$post['cardNo']='168404';
			$post['code']='WX001';
			//$data['extraInfo']=$post['extraInfo'];
			$post['amountString']=10;
			$post['addr']='天河区';
			//$data['disHotel']=$post['disHotel'];
			$post['remark']='test';
			$this->load->model ( 'member/interface/lvyun' , 'lvyun' );
			$res=$this->lvyun->WxdeductPoints($post); 
	
		$openid='oX3Woju12TEuceoZaGKvi7tc0TX4';
		$bonus        = 1;
		$note         = '扣减成功';
		$order_id     = 2;
		$inter_id     = 'a429262687';
		$this->load->model ( 'member/imember' , 'imember' );
		$res = $this->imember->reduceBonus($openid,$bonus,$note,$order_id,$inter_id,0);
		//var_dump($res);exit;
	
	}*/


    public function bindCard(){
        $openid = $this->getOpenId();
        $this->load->model('member/imember');
//        $member = $this->imember->getMemberByOpenId($openid,$this->inter_id,0);
//        //考虑到兼容，新增跳转
//        //$this->imember->headerUrlCenter();
//        if(!$member || !isset($member->mem_id)) {
//            redirect('member/center');
//        }
//
//        $this->load->model('member/iconfig');
//        $fields = $this->iconfig->getConfig('register_fields',true,$this->inter_id);
//        if($fields) {
//            $data['fields'] = $this->iconfig->getConfig('register_fields',true,$this->inter_id)->value;
//        } else {
//            $data['fields'] = array();
//        }
        $this->load->model('wx/access_token_model');
        $data['signpackage'] = $this->access_token_model->getSignPackage($this->inter_id);
        $this->display('member/bl_bindCard',$data);
    }


    public function bindBailiMember(){

        $openid = $this->getOpenId();
        $data['telephone'] = $this->input->post('telephone');
        $data['sms'] = $this->input->post('sms');
        $data['VipName'] = $this->input->post('name');
        //var_dump($data);
        $this->load->model('member/imember');
        $result = $this->imember->loginGetUserinfo($openid,$data,$this->inter_id,0);


        if($result==1) {
            $this->session->set_userdata('message', "绑定成功！");
            redirect('member/center');
        } elseif($result==0) {
            $this->session->set_userdata('message', "会员不存在！");
        }elseif($result==-1){
            $this->session->set_userdata('message', "该会员卡已被绑定，有疑问请联系酒店工作人员。");
        }
        redirect('member/center');


    }


    public function memberIntro(){
        $this->load->model('member/imember');
        $member = $this->imember->getMemberDetailByOpenId($this->openid,$this->inter_id,0);
        $data['member'] = $member;
        $this->display('member/default/member_introduction',$data);


    }

}