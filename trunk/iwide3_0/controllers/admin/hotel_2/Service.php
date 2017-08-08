<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Service extends MY_Admin {
	protected $label_module = NAV_HOTEL;
	protected $label_controller = '服务';
	protected $label_action = '';
	function __construct() {
		parent::__construct ();
		$this->inter_id = $this->session->get_admin_inter_id ();
		$this->module = 'hotel_2';
		$this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
		$this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
		// $this->output->enable_profiler ( true );
	}
	protected function main_model_name() {
		return 'hotel/Service_model';
	}
	public function index() {
		$_POST ['inter_id'] = $this->inter_id;
		$this->_grid ( $_POST );
	}
	public function edit() {
		$this->label_action = '服务管理';
		$this->_init_breadcrumb ( $this->label_action );
		
		$model_name = $this->main_model_name ();
		$model = $this->_load_model ( $model_name );
		$id = intval ( $this->input->get ( 'ids' ) );
		$price_rule = array ();
		$rule_tips=array('r'=>'规则','b'=>'起始数量','e'=>'结束数量','v'=>'配置值');
		if ($id) {
			// for edit page.
			$model = $model->load ( $id );
			$fields_config = $model->get_field_config ( 'form' );
			$detail_field = array ();
			$price_rule = json_decode ( $model->m_get ( 'price_rule' ), TRUE );
			$price_rule = empty($price_rule)?array():$price_rule;
			if (count ( $detail_field ) > 0) {
				$detail_field = $detail_field [0] ['attr_value'];
			} else {
				$detail_field = '';
			}
		} else {
			// for add page.
			$model = $model->load ( $id );
			if (! $model)
				$model = $this->_load_model ();
			$fields_config = $model->get_field_config ( 'form' );
			$detail_field = '';
		}
		
		$view_params = array (
				'model' => $model,
				'fields_config' => $fields_config,
				'check_data' => FALSE,
				'detail_field' => $detail_field,
				'price_rule'=>$price_rule,
				'rule_tips'=>$rule_tips
		);
		// 'gallery'=> $gallery,
		$html = $this->_render_content ( $this->_load_view_file ( 'edit' ), $view_params, TRUE );
		// echo $html;die;
		echo $html;
	}
	public function edit_post()
	{
		$this->label_action= '信息维护';
		$this->_init_breadcrumb($this->label_action);
	
		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);
		$pk= $model->table_primary_key();
	
		$this->load->library('form_validation');
		$post= $this->input->post();
	
		$labels= $model->attribute_labels();
		$base_rules= array(
				'service_name'=> array(
						'service_name' => 'service_name',
						'label' => $labels['service_name'],
						'rules' => 'trim',
				),
				'sex'=> array(
						'field' => 'sex',
						'label' => $labels['sex'],
						'rules' => 'trim',
				),
				'birthday'=> array(
						'field' => 'birthday',
						'label' => $labels['birthday'],
						'rules' => 'trim',
				),
				'education'=> array(
						'field' => 'education',
						'label' => $labels['education'],
						'rules' => 'trim',
				),
				'graduation'=> array(
						'field' => 'graduation',
						'label' => $labels['graduation'],
						'rules' => 'trim',
				),
				'position'=> array(
						'field' => 'position',
						'label' => $labels['position'],
						'rules' => 'trim',
				),
				'business'=> array(
						'field' => 'business',
						'label' => $labels['business'],
						'rules' => 'trim',
				),
				'in_date'=> array(
						'field' => 'in_date',
						'label' => $labels['in_date'],
						'rules' => 'trim',
				),
				'changes'=> array(
						'field' => 'changes',
						'label' => $labels['changes'],
						'rules' => 'trim',
				),
				'previous_job'=> array(
						'field' => 'previous_job',
						'label' => $labels['previous_job'],
						'rules' => 'trim',
				),
				'description'=> array(
						'field' => 'description',
						'label' => $labels['description'],
						'rules' => 'trim',
				),
				'master_dept'=> array(
						'field' => 'master_dept',
						'label' => $labels['master_dept'],
						'rules' => 'trim',
				),
				'second_dept'=> array(
						'field' => 'second_dept',
						'label' => $labels['second_dept'],
						'rules' => 'trim',
				),
				'employee_id'=> array(
						'field' => 'employee_id',
						'label' => $labels['employee_id'],
						'rules' => 'trim',
				),
				'in_group_date'=> array(
						'field' => 'in_group_date',
						'label' => $labels['in_group_date'],
						'rules' => 'trim',
				),
				'cellphone'=> array(
						'field' => 'cellphone',
						'label' => $labels['cellphone'],
						'rules' => 'trim',
				),
				'hotel_name'=> array(
						'field' => 'hotel_name',
						'label' => $labels['hotel_name'],
						'rules' => 'trim',
				),
				'view_count'=> array(
						'field' => 'view_count',
						'label' => $labels['view_count'],
						'rules' => 'trim',
				),
				'hotel_id'=> array(
						'field' => 'hotel_id',
						'label' => $labels['hotel_id'],
						'rules' => 'trim',
				),
				'inter_id'=> array(
						'field' => 'inter_id',
						'label' => $labels['inter_id'],
						'rules' => 'trim',
				)
		);
	
		$adminid= $this->session->get_admin_id();
			
		if( empty($post[$pk]) ){
			//add data.
			$this->form_validation->set_rules($base_rules);
	
			if ($this->form_validation->run() != FALSE) {
				$post['add_date']= date('Y-m-d H:i:s');
				$post['add_user']= $adminid;
					
				$this->load->model ( 'hotel/hotel_model' );
				$hotels = $this->hotel_model->get_hotel_hash ( array('inter_id'=>$this->session->get_admin_inter_id()) );
				$hotels = $this->hotel_model->array_to_hash ( $hotels, 'name', 'hotel_id' );
				$post['hotel_name'] = $hotels[$post['hotel_id']];
	
				$result= $model->m_sets($post)->m_save($post);
				$message= ($result)?
				$this->session->put_success_msg('已新增数据！'):
				$this->session->put_notice_msg('此次数据保存失败！');
				$this->_redirect(EA_const_url::inst()->get_url('*/*/index'));
	
			} else
				$model= $this->_load_model();
	
		} else {
			$this->form_validation->set_rules($base_rules);
			if ($this->form_validation->run() != FALSE) {
				$post['last_update_time']= date('Y-m-d H:i:s');
				$post['last_update_user']= $adminid;
	
				$this->load->model ( 'hotel/hotel_model' );
				$hotels = $this->hotel_model->get_hotel_hash ( array('inter_id'=>$this->session->get_admin_inter_id()) );
				$hotels = $this->hotel_model->array_to_hash ( $hotels, 'name', 'hotel_id' );
				$post['hotel_name'] = $hotels[$post['hotel_id']];
				if(empty($post['qrcode_id']) && $post['status'] == 2){
					$this->load->model('distribute/staff_model');
					$post['qrcode_id'] = $this->staff_model->get_qr_code($post['inter_id'],$post['name'],'','');
					$this->staff_model->save_staff_to_saler($post['inter_id'],$post['qrcode_id']);
				}
	
				$result= $model->load($post[$pk])->m_sets($post)->m_save($post);
				$message= ($result)?
				$this->session->put_success_msg('已保存数据！'):
				$this->session->put_notice_msg('此次数据修改失败！');
	
				$this->_redirect(EA_const_url::inst()->get_url('*/*/index'));
	
			} else
				$model= $model->load($post[$pk]);
		}
	
		//验证失败的情况
		$validat_obj= _get_validation_object();
		$message= $validat_obj->error_html();
		//页面没有发生跳转时用寄存器存储消息
		$this->session->put_error_msg($message, 'register');
	
		$fields_config= $model->get_field_config('form');
		$view_params= array(
				'model'=> $model,
				'fields_config'=> $fields_config,
				'check_data'=> TRUE,
		);
		$html= $this->_render_content($this->_load_view_file('edit'), $view_params, TRUE);
		echo $html;
	}
}
