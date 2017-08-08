<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(E_ALL);
class Msgs extends MY_Admin {
	
	public function __construct(){
		parent::__construct();
		if($this->input->get('debug') == 1){
			$this->output->enable_profiler(true);
		}
	}
	
	public function edit(){
		$this->label_action= '编辑消息';
		$this->_init_breadcrumb($this->label_action);
		$this->load->model('hotel/hotel_model');
		$view_params= array(
				'check_data'=> FALSE,
				'hotels'=>$this->hotel_model->get_hotel_hash(array('inter_id'=>$this->session->userdata('inter_id')),array('hotel_id','name'))
		);
		$html= $this->_render_content($this->_load_view_file('edit'), $view_params, TRUE);
		echo $html;
	}
	public function save_edit(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', '标题', 'required',array('required' => '请填写%s.'));
        $this->form_validation->set_rules('content', '内容', 'required',array('required' => '请填写%s.'));

        if ($this->form_validation->run() == FALSE){
	        $validat_obj= _get_validation_object();
	        $message= $validat_obj->error_html();
	        $this->session->put_error_msg($message, 'register');
	        
	        $view_params= array(
	        		'form_data'=> $this->input->post () 
			);
			echo $this->_render_content ( $this->_load_view_file ( 'edit' ), $view_params, TRUE );
		} else {
			$this->load->model ( 'distribute/idistribute_model' );
			$admin_profile = $this->session->userdata ( 'admin_profile' );
			$params = $this->input->post ();
			$params ['inter_id'] = $admin_profile ['inter_id'];
			$params ['msg_typ'] = 1;
			if($this->uri->segment(4) == 'qa'){
				$params ['msg_typ'] = 2;
			}
			if ($this->idistribute_model->create_notice ( $params )) {
				$this->session->put_success_msg ( '发送成功' );
				redirect ( 'distribute/msgs/logs' );
			} else {
				$this->session->put_error_msg ( '发送失败' );
				$view_params = array (
						'form_data' => $this->input->post () 
				);
				echo $this->_render_content ( $this->_load_view_file ( 'edit' ), $view_params, TRUE );
			}
		}
	}
	public function logs() {
		$inter_id = $this->session->get_admin_inter_id ();
		$this->load->model ( 'distribute/distribute_notice_model' );
		$this->load->library ( 'pagination' );
		$config ['per_page'] = 20;
		$page = empty ( $this->uri->segment ( 5 ) ) ? 0 : ($this->uri->segment ( 5 ) - 1) * $config ['per_page'];
		$config ['use_page_numbers'] = TRUE;
		$config ['cur_page'] = $page;
		$config ['uri_segment'] = 5;
		$config ['numbers_link_vars'] = array (
				'class' => 'number' 
		);
		$cate = '1';
		if($this->uri->segment(4)){
			$cate = $this->uri->segment(4);
		}
		$config ['cur_tag_open'] = '<a class="number current" href="#">';
		$config ['cur_tag_close'] = '</a>';
		$config ['base_url'] = base_url ( "index.php/distribute/msgs/logs/".$cate );
		$config ['total_rows'] = $this->distribute_notice_model->get_notices_count ( $inter_id, $cate);
		$config ['cur_tag_open'] = '<li class="paginate_button active"><a>';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li class="paginate_button">';
		$config ['num_tag_close'] = '</li>';
		$config ['first_tag_open'] = '<li class="paginate_button first">';
		$config ['first_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="paginate_button last">';
		$config ['last_tag_close'] = '</li>';
		$config ['prev_tag_open'] = '<li class="paginate_button previous">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_tag_open'] = '<li class="paginate_button next">';
		$config ['next_tag_close'] = '</li>';
		$this->pagination->initialize ( $config );
		$query = $this->distribute_notice_model->get_notices ( $inter_id,$cate , $config ['per_page'],$page );
		$view_params = array (
				'pagination' => $this->pagination->create_links (),
				'res' => $query,
				'msg_typs' => array(0 => '绩效发放',1 => '关注提醒',2 => '常见问题')
		);
		$html = $this->_render_content ( $this->_load_view_file ( 'msgs' ), $view_params, TRUE );
		echo $html;
	}
}