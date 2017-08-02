<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Hotel_goods extends MY_Admin_Iapi {
	protected $label_module = NAV_HOTEL;
	protected $label_controller = '商品管理';
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
		return 'hotel/Hotel_goods_model';
	}
	public function index() {
		$data = $this->common_data;
		$this->label_action = '商品列表';
		$model = $this->_load_model ( $this->main_model_name () );
		$this->_init_breadcrumb ( $this->label_action );
		$this->_render_content ( $this->_load_view_file ( 'index' ), $data, false );
	}

	public function ajax_get_list(){
		
		$condit ['inter_id'] = $this->inter_id;
		$model = $this->_load_model ( $this->main_model_name () );
		$condit ['page'] = $this->input->get ( 'page' )>0 ? intval($this->input->get ( 'page' )) : 1;
		$condit ['size'] = $this->input->get ( 'size' )>0 ? intval($this->input->get ( 'size' )) : 20;
		$condit ['is_active'] = true;//上架的商品

		$data = $model->get_list ( $condit );
		$data['page'] = $condit ['page'];
		$data['size'] = $condit ['size'];

		$this->out_put_msg(1,'',$data,'hotel/goods/ajax_get_list');
	}

	public function edit_post() {
		$gid = $this->input->post ( 'gid' );
		$model_name = $this->main_model_name ();
		$model = $this->_load_model ( $model_name );
		$data ['hotel_price'] = $this->input->post ( 'hotel_price' );
		$data ['gs_unit'] = $this->input->post ( 'gs_unit' );

		if ($gid) {
			$re = $model->update_data ( $this->inter_id,$gid, $data );
		}
		if(empty($re)){
			echo json_encode(array('status'=>1,'msg'=>'失败'));
		} else {
			echo json_encode(array('status'=>0,'msg'=>'成功'));
		}
	}
}
