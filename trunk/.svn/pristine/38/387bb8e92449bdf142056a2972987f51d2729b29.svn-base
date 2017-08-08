<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Distribute extends MY_Admin {
	protected $label_module = NAV_HOTEL;
	protected $label_controller = '分销配置';
	protected $label_action = '';
	protected $common_data = array ();
	function __construct() {
		parent::__construct ();
		$this->inter_id = $this->session->get_admin_inter_id ();
		$this->module = 'hotel_2';
		$this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
		$this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
		$this->common_data ['inter_id'] = $this->inter_id;
		// $this->output->enable_profiler ( true );
	}
	protected function main_model_name() {
		return 'distribute/Idistribution_model';
	}
	protected function main_model() {
		if (!isset($this->m_model)){
			$this->load->model($this->main_model_name(),'m_model');
		}
		return $this->m_model;
	}
	public function rules() {
		$data = $this->common_data;
		$model=$this->main_model();
		$data['list']=$model->get_list($this->inter_id);
		$data['fields_config']=$model->fields_config();
		$this->_render_content ( $this->_load_view_file ( 'rules' ), $data, false );
	}
	//新增||编辑规则
	public function rule_edit() {
		$data = $this->common_data;
		$model = $this->main_model();
		$rule_id = $this->input->get ( 'rid' );
		if (! empty ( $rule_id )) {
			$data ['row'] = $model->get_row ($this->inter_id,$rule_id);
			if(!$data ['row']){
				redirect ( site_url ( 'hotel/Distribute/rules' ) );
			}
		}
		//获取酒店价格代码
		$this->load->model('hotel/Price_code_model');
		$data ['price_code'] = $this->Price_code_model->get_price_codes ( $this->inter_id,1);

		//获取酒店支付方式
		$this->load->model ( 'pay/Pay_model' );
		$data ['pay_ways'] = $this->Pay_model->get_pay_way ( array (
				'inter_id' => $this->inter_id,
				'module' => 'hotel',
				'status' => 1
		) );
		$this->_render_content ( $this->_load_view_file ( 'rule_edit' ), $data, false );
	}
	//保存规则
	public function rule_save()	{
		$datas['id']  = ($_POST['rule_id']>0)? intval($this->input->post('rule_id')) : 0; //有id是修改无id是新增
		$datas['title']  = ($_POST['title'] != '') ? trim($this->input->post('title')) : ''; //标题
		$datas['beyond']  = ($_POST['beyond']>0) ? intval($this->input->post('beyond')) : 0; //归属
		$datas['price_typeid']  = (isset($_POST['price_typeid']) && is_array($_POST['price_typeid'])) ? $this->input->post('price_typeid') : array(); //价格代码
		$datas['pay_wayid']  = is_array($_POST['pay_wayid']) ? $this->input->post('pay_wayid') : ''; //支付方式
		$datas['excitation_type']  = ($_POST['excitation_type']>0) ? intval($this->input->post('excitation_type')) : 0; //订房激励
		$datas['excitation_value']  = ($_POST['excitation_value']>0) ? trim($this->input->post('excitation_value')) : 0; //激励值
		$datas['starttime']  = ($_POST['starttime']!='') ? trim($this->input->post('starttime')) : '0000-00-00'; //开始时间
		$datas['endtime']  = ($_POST['endtime']!='') ? trim($this->input->post('endtime')) : '9999-12-31'; //结束时间
		$datas['weight']  = ($_POST['weight']>0) ? intval($this->input->post('weight')) : 1; //权重
		@$datas['status']  = ($_POST['status']>0) ? intval($this->input->post('status')) : 1; //状态默认生效
		@$datas['all']  = ($_POST['all']>0) ? intval($this->input->post('all')) : 1; //默认全部价格代码执行
		$model = $this->main_model();
		if($datas['id']){
			$re = $model->edit_dc ($datas);//修改
		}else{
			$re = $model->add_dc ($datas);//新增
		}

		if($re){
			echo json_encode(array('code' => '1', 'msg' => '保存成功'));
		}else{
			echo json_encode(array('code' => '0', 'msg' => '保存失败'));
		}
	}
	//查看规则
	public function rule_check() {
		$data = $this->common_data;
		$model = $this->main_model();
		$rule_id = $this->input->get ( 'rid' );
		if (! empty ( $rule_id )) {
			$data ['row'] = $model->get_row ($this->inter_id,$rule_id);
			if(!$data ['row']){
				redirect ( site_url ( 'hotel/Distribute/rules' ) );
			}
			$data ['beyond'] = $model->enums('beyond');
			$data ['excitation_type'] = $model->enums('excitation_type');
			//获取酒店价格代码
			$this->load->model('hotel/Price_code_model');
			$data ['price_code'] = $this->Price_code_model->get_price_codes ( $this->inter_id,1);

			//获取酒店支付方式
			$this->load->model ( 'pay/Pay_model' );
			$data ['pay_ways'] = $this->Pay_model->get_pay_way ( array (
					'inter_id' => $this->inter_id,
					'module' => 'hotel',
					'status' => 1
			) );
			//查询操作日志
			$this->load->model('hotel/Hotel_log_model');
			$params=array(
				'ident'=>'Idistribution/dc#'.$rule_id,
				'need_data'=>1,
				'order_by'=>'log_id asc'
			);
			
			$admin_logs = $this->Hotel_log_model->get_admin_log($this->inter_id,$params);
			$pre = array();
			foreach ($admin_logs as $k => &$admin_log) {
				if($pre){
					$str = '修改了规则：';
					$now = json_decode($admin_log['key_data'],true);
					if($now['title']!=$pre['title']){//对比标题
						$str .= '<br>标题：'.$now['title'];
					}
					if($now['beyond']!=$pre['beyond']){//对比归属
						$beyond = $model->enums('beyond');
						$str .= '<br>归属：'.$beyond[$now['beyond']];
					}
					if(@$now['all']!=@$pre['all'] || @$now['all']==2){//对比价格代码
						if($now['all']==1){
							$str .= '<br>价格代码：全部价格代码';
						}else{
							if($now['price_typeid']!=$pre['price_typeid']){
								$price_typeid = explode('-', trim($now['price_typeid'],'-'));
								$str .= '<br>价格代码：';
								foreach ($price_typeid as $price) {
									$str .= $data ['price_code'][$price]['price_name'].',';
								}
							}
						}
					}
					if($now['pay_wayid']!=$pre['pay_wayid']){//对比支付方式
						$pay_wayid = explode('-', trim($now['pay_wayid'],'-'));
						$str .= '<br>支付方式：';
	            		foreach($data ['pay_ways'] as $pay_way){
		            		if(in_array($pay_way->pay_type,$pay_wayid))
		            			$str .= $pay_way->pay_name.',';
		            	}
					}
					if($now['excitation_type']!=$pre['excitation_type']){//对比激励类型
						$str .= '<br>激励类型：'.$data ['excitation_type'][$now['excitation_type']];
					}
					if($now['excitation_value']!=$pre['excitation_value']){//对比激励值
						$str .= '<br>激励类型：'.$now['excitation_value'];
						if($now['excitation_type']==1){
							$str .= '%';
						}else{
							$str .= '元';
						}
					}
					if($now['starttime']!=$pre['starttime']){//对比开始日期
						$str .= '<br>开始日期：'.$now['starttime'];
					}
					if($now['endtime']!=$pre['endtime']){//对比结束日期
						$str .= '<br>结束日期：'.$now['endtime'];
					}
					if($now['weight']!=$pre['weight']){//对比权重
						$str .= '<br>优先级：'.$now['weight'];
					}
					if($now['status']!=$pre['status']){//对比状态
						$status = $model->enums('status');
						$str .= '<br>状态：'.$status[$now['status']];
					}
					$admin_log['desc'] = $str;
				}else{
					$admin_log['desc'] ='创建了规则';
				}
				$pre = json_decode($admin_log['key_data'],true);
				if($admin_log['desc']=='修改了规则：'){
					unset($admin_logs[$k]);
				}
			}
			$data['admin_logs'] = $admin_logs;
		}
		$this->_render_content ( $this->_load_view_file ( 'rule_check' ), $data, false );
	}
    
}
