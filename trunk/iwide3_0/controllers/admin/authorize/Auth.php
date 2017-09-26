<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Admin_Priv {


	protected $label_module= '';		//面包屑导航
	protected $label_controller= '';

	public function index()
	{
	    //$this->output->enable_profiler(TRUE);
	    $url= EA_const_url::inst()->get_default_admin();
	    $this->_redirect($url);
	}

	public function updb()
	{
	    echo str_repeat('=', 30). "\n <br/>start update db\n <br/>.<br/>.<br/>.<br/><br/>";
	    $this->_update_db();
	    echo str_repeat('=', 30). "\n <br/>update complete!\n ";
	}

	public function verify()
	{
	    $this->load->library('MY_verify');
	    $config= array(
	        'imageH' => 40,
	        'fontSize' => 20,
	    );
		$verify = new MY_verify($config);
		$verify->entry();
	}

	public function login()
	{

	    $redirect = $this->input->get('redirect');
	    $post= $this->input->post();
	    
	    $oath_para=array();
	    $oath_para['redirect_uri'] = $this->input->get('redirect_uri');
	    $oath_para['app_id']= $this->input->get('app_id');
	    $oath_para['state']= $this->input->get('state');
	    $oath_para['scope']= $this->input->get('scope');
	    foreach ($oath_para as $pk=>$para){
	        if (is_null($para)||$para===''){
	            echo '缺少参数 '.$pk;
	            exit;
	        }
	    }
	    if (!$redirect_uri = base64_decode($oath_para['redirect_uri'])){
	        echo 'redirect_uri格式错误';
	        exit;
	    }

	    $redir_domain = get_url_domain($redirect_uri);
	    $this->load->model ( 'application/Application_info_model' );
	    $app_info = $this->Application_info_model->get_application ( $oath_para['app_id'], 1 );
	    if (!$app_info){
	        echo 'appid参数错误';
	        exit;
	    }
	    if (empty($app_info['white_domains'])){
	        echo 'app域名配置错误';
	        exit;
	    }
	    $white_domains=explode(',', $app_info['white_domains']);
	    if (!in_array($redir_domain, $white_domains)){
	        echo 'redirect_uri域名错误';
	        exit;
	    }
	    $url= site_url('authorize/auth/login');
	    $url.= '?'.http_build_query($oath_para);

        $post['form_action']= $url;
        echo $this->_load_view('authorize/login', $post, TRUE);

        /*
	    if( empty($post['username']) && empty($post['password']) ){
	        $post['form_action']= $url;
	        echo $this->_load_view($this->priv_dir. '/login', $post, TRUE);
	        
	    } else if( empty($post['username']) || empty($post['password']) ){
	        $this->session->set_flashdata('error_msg', '请输入密码！');
	        $this->_redirect($url);
	        
	    } else if( !$this->session->validate_captcha($post['captcha']) ){
	        $this->session->set_flashdata('error_msg', '验证码有误！');
	        $this->_redirect($url);
	        
	    } else {
	        $this->load->model('core/priv_admin', 'm_admin');
	        if($this->m_admin->authenticate($post['username'], $post['password'])){
	            $admin= $this->m_admin->load_by_username($post['username']);
	            $admin->m_set('update_time', date('Y-m-d H:i:s') )->m_save();
	            if($admin) {
	                //记录登陆日志
					$this->_log(NULL);
		            
		            $this->load->model('authority/Valify_tokens_model');
		            $oauth_code=$this->Valify_tokens_model->tokenAddAdapter(3,array('admin_id'=>$admin->m_get('admin_id'),'app_id'=>'a5cfb5d96b','valify_data'=>array('username'=>$admin->m_get('username'))));
					if($redirect_uri){
					    if (strpos ( $redirect_uri, '?' )){
					        $redirect_uri.='&icode='.$oauth_code;
					    }else {
					        $redirect_uri.='?icode='.$oauth_code;
					    }
					    $redirect_uri.='&state='.$oath_para['state'];
					    $this->_redirect($redirect_uri);
					} else {
					    $this->_redirect(EA_const_url::inst()->get_default_admin());
					}
	                
	            } else {
                    $this->session->set_flashdata('error_msg', '账号还没有正确分配权限，无法登陆！');
                    $this->_redirect($url);
	            }
	        } else {
                $this->session->set_flashdata('error_msg', '无效账号密码，或账户处于冻结状态！');
                $this->_redirect($url);
	        }
	    }
        */

	}
	
	public function logout()
	{
		$profile= $this->session->get_admin_profile();
		$this->session->admin_logout();
		
		//记录退出日志
		//$this->_log(NULL, $profile);
	    $url= EA_const_url::inst()->get_login_admin();

	    if( isset($_SERVER ['HTTP_REFERER']) && $_SERVER ['HTTP_REFERER'] ){
	        if( substr($_SERVER ['HTTP_REFERER'], -11)=='auth/logout' )
	            $url.= '';
	        elseif( substr($_SERVER ['HTTP_REFERER'], -9)=='auth/deny' )
	            $url.= '';
	        else
	            $url.= '?redirect='. urlencode($_SERVER ['HTTP_REFERER']);
	    }
	    $this->_redirect($url);
	}

	public function nofound()
	{
	    echo $this->_render_content($this->priv_dir. '/404');
	}
	
	public function deny()
	{
	    echo $this->_render_content($this->priv_dir. '/deny');
	}
	
	public function dashboard()
	{
		$data = array();
	    echo $this->_render_content($this->priv_dir. '/main',$data);
	}
	
	/**
	 * 显示管理员的授权二维码
	 */
	public function admin_qrcode()
	{
		$id= $this->input->get('id');
		if($id){
			$this->load->helper('encrypt');
	        $encrypt_util= new Encrypt();
			$admin_id= $encrypt_util->decrypt( base64_decode($id) );
			$this->load->model('core/priv_admin');
			$admin= $this->priv_admin->load($admin_id);
			if( $admin->has_inter_id() ){
			    //只针对有inter_id的商家账号
			    $key= base64_encode( $encrypt_util->encrypt( json_encode( array(
			        'key'=>'fixed',	//暂时用固定的key，二维码长期有效
			        'id'=> $admin_id,
			        'inter_id'=> $admin->m_get('inter_id'),
			    ) ) ) );

			    $url= EA_const_url::inst()->get_url('*/*/admin_authid', array('id'=>$admin->m_get('inter_id'), 'key'=> $key) );
			    if( defined('PROJECT_AREA') && PROJECT_AREA=='mooncake' ){
			        $url= str_replace('mk2016.mp.', 'mp.', $url);
			    }
			    $this->_get_qrcode_png($url);
			    
			} else {
			    return FALSE;
			}
			
		} else {
			return FALSE;
		}
	}

	/**
	 * 接收授权二维码跳转，处理函数在 front/privilege/auth.php
	 */
	public function admin_authid()
	{
	    //echo $code;die;'
	    $id= $this->input->get('id');
	    $key= $this->input->get('key');
	    $url= EA_const_url::inst()->get_front_url($id, 'privilege/auth/admin_authid', array('id'=>$id, 'key'=> $key ) );
	    $url = urlencode ($url);
	    $scope = 'snsapi_userinfo';
	    $this->load->model('wx/Publics_model');
	    $public=$this->Publics_model->get_public_by_id($id);
	    $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $public ['app_id']
	       . "&redirect_uri=$url&response_type=code&scope=$scope&state=STATE#wechat_redirect";
	    $this->_redirect($url);
	}
	
	/**
	 * remove to front url
	 * @deprecated 已废弃，代码迁移到 front/privilege/auth.php 中admin_authid方法
	 */
	public function _admin_authid()
	{
		$code= $this->input->get ( 'code' );
		if($code){
			$this->load->helper('encrypt');
	        $encrypt_util= new Encrypt();
			$json= $encrypt_util->decrypt( base64_decode( $key) );
			//print_r($json);die;
			$data= json_decode($json);
			if( isset($data['key']) && isset($data['inter_id']) && $data['key']=='fixed' ){
				//TODO: 读取openid，写入授权表
        		$this->load->model('wx/Publics_model');
        		$public=$this->Publics_model->get_public_by_id($data['inter_id']);
			    $code = 'snsapi_userinfo';
			    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $public ['app_id'] 
			         . "&secret=" . $public ['app_secret']. "&code=$code&grant_type=authorization_code";
			    
			    $this->load->helper('common');
			    $result = doCurlGetRequest($url);
			    
			    $result = json_decode( $result, TRUE );
			    if ($result ['openid']) {
			        $this->Publics_model->update_wxuser_info ( $this->session->userdata ( 'inter_id' ), $result ['openid'], $result ['access_token'] );
    				$this->load->model('core/priv_admin_authid', 'admin_authid');
    				$model= $this->admin_authid;
    				$insert= array(
    					'openid'=> $result ['openid'],
    					'nickname'=> $result ['nickname'],
    					'headimgurl'=> $result ['headimgurl'],
    					'auth_time'=> date("Y-m-d H:i:s"),
    					'status'=> $model::STATUS_APPLY,
    					'admin_id'=> $data['id'],
    					'inter_id'=> $data['inter_id'],
    				);
    				$model->m_save($insert);
			    }
			}
		} else {
		    die('授权请求失败，请稍后再试。');
		}
	}

    /**
     * 显示二维码
     */
    public function showAuthQr()
    {
        $text = !empty($this->input->get('url')) ? addslashes($this->input->get('url')) : '';
        $this->load->helper('phpqrcode');
        $text = urldecode($text);
        QRcode::png($text,false,6,6);
    }

	
}
