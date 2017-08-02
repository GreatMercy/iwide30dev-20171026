<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	后台用户登录配置
*	@author Frandon
*	@time 三月三十一号
*	@version www.iwide.cn
*	@
*/
class Resetpasswordconfig extends MY_Admin_Api
{

	//配置列表
	public function index(){
		$post_data = array(
			'inter_id'=>$this->session->get_admin_inter_id(),
			);
		//请求登录配置信息URL
		$post_config_url = PMS_PATH_URL."adminmember/getresetconfig";
		$reset_config = $this->doCurlPostRequest( $post_config_url , $post_data );
		$data = array(
			'resetconfig' =>$reset_config['data'],
			);
		$html= $this->_render_content($this->_load_view_file('edit'),$data,false);
		
	}

	//增加或修改配置
	public function edit_post(){
		$post_data = $_POST;
		$post_data['inter_id'] =$this->session->get_admin_inter_id();
		$reset_config = $this->doCurlPostRequest( PMS_PATH_URL."adminmember/getregconfig" , $post_data );
		foreach ($reset_config['data'] as $key => $value) {
			if( isset($post_data[$key.'_show']) ){
				$reset_config['data'][$key]['show'] =1;
			}
			if( isset($post_data[$key.'_check']) ){
				$reset_config['data'][$key]['check'] =1;
			}
		}
		$save_config_url = PMS_PATH_URL."adminmember/savememberconfig";
		$save_post_data = array(
			'inter_id' => $this->session->get_admin_inter_id(),
			'config_data'=>$post_data,
			'type'=>'reset',
			);
		$save_reset_config = $this->doCurlPostRequest( $save_config_url , $save_post_data );
		redirect('membervip/resetpasswordconfig');
		exit;
	}

}
?>