<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Home_setting extends MY_Admin {
	protected $label_controller = '首页设置';
	protected $label_action = '';
	function __construct() {
		parent::__construct ();
		$this->inter_id = $this->session->get_admin_inter_id ();
		$this->module = 'hotel';
		$this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
		$this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
		// $this->output->enable_profiler ( true );
	}
	protected function main_model_name() {
		return 'plugins/Home_model';
	}
	public function index() {
		$data = $this->common_data;
		$this->load->model ( 'common/Enum_model' );
		$enum_des = $this->Enum_model->get_enum_des ( array (
				'HOME_SETTING_SELECT' 
		) );
		$data['select'] = $enum_des['HOME_SETTING_SELECT'];

		$this->load->model ( 'hotel/Hotel_config_model' );
		$config_data = $this->Hotel_config_model->get_hotels_config_row ( $this->inter_id, 'HOTEL', 0, 'HOME_SETTING' );
		if(!empty($config_data)){
			$data['id'] = $config_data['id'];
			$data['config'] = json_decode($config_data['param_value'],true);
		}
		$this->_render_content ( $this->_load_view_file ( 'index' ), $data, false );
	}
	public function edit_post() {
		$id = $this->input->post ( 'id' );
		if($id>0){
			$data['id'] = $id;
		}
		unset($_POST['id']);
		$data['param_value'] = json_encode( $_POST );
		$data['param_name'] = 'HOME_SETTING';
		$data['module'] = 'HOTEL';
		$data['inter_id'] = $this->inter_id;
		$data['hotel_id'] = 0;
		$this->load->model ( 'hotel/hotel_config_model' );
		$this->hotel_config_model->replace_config($data);
		redirect ( site_url ( 'hotel/Home_setting/index' ) );
	}
}
