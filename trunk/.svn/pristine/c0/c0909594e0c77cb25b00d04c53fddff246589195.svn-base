<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wall extends MY_Admin {

	protected $label_module= NAV_BASIC;		//统一在 constants.php 定义
	protected $label_controller= '上传管理';	//在文件定义
	protected $label_action= '';				//在方法中定义
	
	public function __construct() {
		parent::__construct ();
	}
	
	protected function main_model_name()
	{
		return 'report/Wall_model';
	}
	
	/*
	public function index()
	{
		$inter_id= $this->session->get_admin_inter_id();
		if($inter_id== FULL_ACCESS) $filter= array();
		else if($inter_id) $filter= array('inter_id'=>$inter_id );
		else $filter= array('inter_id'=>'deny' );
		
		$entity_filter = "";
		$entity_id = $this->session->get_admin_hotels();
		if ($entity_id) {
			$entity_filter = " and hotel_id in (".$entity_id.") ";
		}
		
		if($inter_id== FULL_ACCESS) $inter_id_filter = '1';
		else if($inter_id) $inter_id_filter = 'inter_id = "'.$inter_id.'"'.$entity_filter;
		else $inter_id_filter = 'inter_id = "deny"';
	
		$viewdata = array();
	
		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);
	
		//filter params: the same with table fields...
		//sort params: sort_direct, sort_field
		//page params: page_size, page_num
		$params= $this->input->get();
		if(is_array($filter) && count($filter)>0 )
			$params= array_merge($params, $filter);
	
	
		//HTML输出
		$this->label_action= '信息列表';
		$this->_init_breadcrumb($this->label_action);
	
		$fields_config= $model->get_field_config('grid');
		$default_sort= $model::default_sort_field();
		
		
			
		$view_params= array(
				'module'=> $this->module,
				'model'=> $model,
				'attribute_items'=>$model->attribute_items(),
				'fields_config'=> $fields_config,
				'default_sort'=> $default_sort
		);
	
		$view_params= $view_params+ $viewdata;
	
		$html= $this->_render_content($this->_load_view_file('old'), $view_params, TRUE);
		//echo $html;die;
		echo $html;
	
	}
	*/

}
