<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Hotel_report extends MY_Admin {
	protected $label_module = '酒店统计';
	protected $label_controller = '酒店统计';
	protected $label_action = '';
	function __construct() {
		parent::__construct ();
		if ($this->input->get ( 'debug' )) {
			$this->output->enable_profiler ( true );
		}
	}
	public function order_rn() {
		$avgs ['hotel_id'] = $this->input->post ( 'hotel_id' );
		$avgs ['order_time_start'] = $this->input->post ( 'order_time_start' );
		$avgs ['order_time_end'] = $this->input->post ( 'order_time_end' );
		$avgs ['start_date_start'] = $this->input->post ( 'start_date_start' );
		$avgs ['start_date_end'] = $this->input->post ( 'start_date_end' );
		$avgs ['end_date_start'] = $this->input->post ( 'end_date_start' );
		$avgs ['end_date_end'] = $this->input->post ( 'end_date_end' );
		$avgs ['order_status'] = $this->input->post ( 'order_status' );
		$avgs ['orderid'] = $this->input->post ( 'orderid' );
		$avgs ['web_orderid'] = $this->input->post ( 'web_orderid' );
		$avgs ['in_name'] = $this->input->post ( 'in_name' );
		$avgs ['in_tel'] = $this->input->post ( 'in_tel' );
		
		$keys = $this->input->get ();
		foreach ( $avgs as $k => $v ) {
			if (! empty ( $keys [$k] )) {
				$avgs [$k] = $keys [$k];
			}
		}
		
		$this->load->model ( 'distribute/report_model' );
		$admin_profile = $this->session->userdata ( 'admin_profile' );
		$confs = $this->report_model->get_dist_field_conf ( $admin_profile ['inter_id'], 'ORDERS_BY_ROOMNIGHT', $admin_profile ['admin_id'] );
		$this->load->library ( 'pagination' );
		$config ['per_page'] = 20;
		$page = empty ( $this->uri->segment ( 4 ) ) ? 0 : ($this->uri->segment ( 4 ) - 1) * $config ['per_page'];
		
		$this->load->model ( 'hotel/hotel_model' );
		$filterH ['inter_id'] = $admin_profile ['inter_id'];
		if (! empty ( $admin_profile ['entity_id'] )) {
			$hotel_ids = explode ( ',', $admin_profile ['entity_id'] );
			$filterH ['hotel_id'] = $hotel_ids;
			if (! empty ( $avgs ['hotel_id'] ) && ! in_array ( $avgs ['hotel_id'], $hotel_ids )) {
				unset ( $avgs ['hotel_id'] );
			}
			$hotels = $this->hotel_model->get_hotel_by_ids ( $admin_profile ['inter_id'], $admin_profile ['entity_id'], NULL, 'key' );
		} else {
			$hotels = $this->hotel_model->get_all_hotels ( $admin_profile ['inter_id'], NULL, 'key' );
		}
		
		$this->load->model ( 'hotel/Hotel_report_model' );
		
		$config ['use_page_numbers'] = TRUE;
		$config ['cur_page'] = $page;
		$config ['suffix'] = "?" . http_build_query ( $avgs );
		$avgs ['inter_id'] = $admin_profile ['inter_id'];
		if (! empty ( $admin_profile ['entity_id'] )) {//添加酒店筛选 stgc 20160902
			$avgs ['entity_hotel_id'] = explode(',',$admin_profile ['entity_id']);
		}
		$res = $this->Hotel_report_model->get_orders_by_roomnight ( $avgs, $config ['per_page'], $config ['cur_page'] );
		$config ['uri_segment'] = 4;
		$config ['numbers_link_vars'] = array (
				'class' => 'number' 
		);
		$config ['cur_tag_open'] = '<a class="number current" href="#">';
		$config ['cur_tag_close'] = '</a>';
		$config ['base_url'] = site_url ( "hotel/hotel_report/order_rn" );
		$config ['total_rows'] = $this->Hotel_report_model->get_orders_by_roomnight ( $avgs, NULL, 0, array (
				'just_count' => TRUE 
		) );
		$config ['cur_tag_open'] = '<li class="paginate_button active"><a>';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li class="paginate_button">';
		$config ['num_tag_close'] = '</li>';
		$config ['first_tag_open'] = '<li class="paginate_button first">';
		$config ['first_tag_close'] = '</li>';
		$config ['first_url'] = site_url ( "hotel/hotel_report/order_rn" ) . "?" . http_build_query ( $avgs );
		$config ['last_tag_open'] = '<li class="paginate_button last">';
		$config ['last_tag_close'] = '</li>';
		$config ['prev_tag_open'] = '<li class="paginate_button previous">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_tag_open'] = '<li class="paginate_button next">';
		$config ['next_tag_close'] = '</li>';
		$this->pagination->initialize ( $config );
		$view_params = array (
				'pagination' => $this->pagination->create_links (),
				'res' => $res,
				'confs' => $confs,
				'hotels' => $hotels,
				'posts' => $avgs,
				'total' => $config ['total_rows'] 
		);
		$html = $this->_render_content ( $this->_load_view_file ( 'order_rn' ), $view_params, TRUE );
		echo $html;
	}
	public function ext_order_rn() {
		$avgs ['hotel_id'] = $this->input->get ( 'hotel_id' );
		$avgs ['order_time_start'] = $this->input->get ( 'order_time_start' );
		$avgs ['order_time_end'] = $this->input->get ( 'order_time_end' );
		$avgs ['start_date_start'] = $this->input->get ( 'start_date_start' );
		$avgs ['start_date_end'] = $this->input->get ( 'start_date_end' );
		$avgs ['end_date_start'] = $this->input->get ( 'end_date_start' );
		$avgs ['end_date_end'] = $this->input->get ( 'end_date_end' );
		$avgs ['order_status'] = $this->input->get ( 'order_status' );
		$avgs ['orderid'] = $this->input->get ( 'orderid' );
		$avgs ['web_orderid'] = $this->input->get ( 'web_orderid' );
		$avgs ['in_name'] = $this->input->get ( 'in_name' );
		$avgs ['in_tel'] = $this->input->get ( 'in_tel' );
		
		$this->load->model ( 'distribute/report_model' );
		$admin_profile = $this->session->userdata ( 'admin_profile' );
		$confs = $this->report_model->get_dist_field_conf ( $admin_profile ['inter_id'], 'ORDERS_BY_ROOMNIGHT', $admin_profile ['admin_id'] );
		
		$this->load->model ( 'hotel/hotel_model' );
		$filterH ['inter_id'] = $admin_profile ['inter_id'];
		if (! empty ( $admin_profile ['entity_id'] )) {
			$hotel_ids = explode ( ',', $admin_profile ['entity_id'] );
			$filterH ['hotel_id'] = $hotel_ids;
			if (! empty ( $avgs ['hotel_id'] ) && ! in_array ( $avgs ['hotel_id'], $hotel_ids )) {
				unset ( $avgs ['hotel_id'] );
			}
			$hotels = $this->hotel_model->get_hotel_by_ids ( $admin_profile ['inter_id'], $admin_profile ['entity_id'], NULL, 'key' );
		} else {
			$hotels = $this->hotel_model->get_all_hotels ( $admin_profile ['inter_id'], NULL, 'key' );
		}
		
		$this->load->model ( 'hotel/Hotel_report_model' );
		
		$avgs ['inter_id'] = $admin_profile ['inter_id'];
		$res = $this->Hotel_report_model->get_orders_by_roomnight ( $avgs, NULL, 0, array (
				'xls' => TRUE 
		) );
		
		$public = $this->db->get_where ( 'publics', array (
				'inter_id' => $admin_profile ['inter_id'] 
		) )->row_array ();
		$filename = $public ['name'] . '_' . date ( 'YmdHis' );
		$this->load->model ( 'plugins/Excel_model' );
		$head = array ();
		foreach ( $confs as $key => $item ) {
			if ($item ['must'] == 1 || $item ['choose'] == 1) {
				$head [] = $item ['name'];
			}
		}
		$data = array ();
		foreach ( $res as $k => $item ) {
			$tmp = array ();
			foreach ( $confs as $data_type => $i ) {
				if ($i ['must'] == 1 || $i ['choose'] == 1) {
					if (isset ( $item [$data_type] ))
						$tmp [] = $item [$data_type];
					else
						$tmp [] = '';
				}
			}
			$data [] = $tmp;
		}
		ob_clean ();
		$this->Excel_model->exp_exl ( $head, $data, $filename );
	}
	public function order_htl() {
		$avgs ['hotel_id'] = $this->input->post ( 'hotel_id' );
		$avgs ['order_time_start'] = $this->input->post ( 'order_time_start' );
		$avgs ['order_time_end'] = $this->input->post ( 'order_time_end' );
		$avgs ['start_date_start'] = $this->input->post ( 'start_date_start' );
		$avgs ['start_date_end'] = $this->input->post ( 'start_date_end' );
		$avgs ['end_date_start'] = $this->input->post ( 'end_date_start' );
		$avgs ['end_date_end'] = $this->input->post ( 'end_date_end' );
		
		$keys = $this->input->get ();
		foreach ( $avgs as $k => $v ) {
			if (! empty ( $keys [$k] )) {
				$avgs [$k] = $keys [$k];
			}
		}
		
		$this->load->model ( 'distribute/report_model' );
		$admin_profile = $this->session->userdata ( 'admin_profile' );
		$confs = $this->report_model->get_dist_field_conf ( $admin_profile ['inter_id'], 'ORDERS_BY_HOTEL', $admin_profile ['admin_id'] );
		$this->load->library ( 'pagination' );
		$config ['per_page'] = 20;
		$page = empty ( $this->uri->segment ( 4 ) ) ? 0 : ($this->uri->segment ( 4 ) - 1) * $config ['per_page'];
		
		$this->load->model ( 'hotel/hotel_model' );
		if (! empty ( $admin_profile ['entity_id'] )) {
			$hotel_ids = explode ( ',', $admin_profile ['entity_id'] );
			if (! empty ( $avgs ['hotel_id'] ) && ! in_array ( $avgs ['hotel_id'], $hotel_ids )) {
				unset ( $avgs ['hotel_id'] );
			}
			$hotels = $this->hotel_model->get_hotel_by_ids ( $admin_profile ['inter_id'], $admin_profile ['entity_id'], NULL, 'key' );
		} else {
			$hotels = $this->hotel_model->get_all_hotels ( $admin_profile ['inter_id'], NULL, 'key' );
		}
		
		$this->load->model ( 'hotel/Hotel_report_model' );
		
		$config ['use_page_numbers'] = TRUE;
		$config ['cur_page'] = $page;
		$config ['suffix'] = "?" . http_build_query ( $avgs );
		$avgs ['inter_id'] = $admin_profile ['inter_id'];
		$res = $this->Hotel_report_model->get_orders_by_hotel ( $avgs, $config ['per_page'], $config ['cur_page'] );
		$config ['uri_segment'] = 4;
		$config ['numbers_link_vars'] = array (
				'class' => 'number' 
		);
		$config ['cur_tag_open'] = '<a class="number current" href="#">';
		$config ['cur_tag_close'] = '</a>';
		$config ['base_url'] = site_url ( "hotel/hotel_report/order_htl" );
		$config ['total_rows'] = $this->Hotel_report_model->get_orders_by_hotel ( $avgs, NULL, 0, array (
				'just_count' => TRUE 
		) );
		$config ['cur_tag_open'] = '<li class="paginate_button active"><a>';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li class="paginate_button">';
		$config ['num_tag_close'] = '</li>';
		$config ['first_tag_open'] = '<li class="paginate_button first">';
		$config ['first_tag_close'] = '</li>';
		$config ['first_url'] = site_url ( "hotel/hotel_report/order_htl" ) . "?" . http_build_query ( $avgs );
		$config ['last_tag_open'] = '<li class="paginate_button last">';
		$config ['last_tag_close'] = '</li>';
		$config ['prev_tag_open'] = '<li class="paginate_button previous">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_tag_open'] = '<li class="paginate_button next">';
		$config ['next_tag_close'] = '</li>';
		$this->pagination->initialize ( $config );
		$view_params = array (
				'pagination' => $this->pagination->create_links (),
				'res' => $res,
				'confs' => $confs,
				'hotels' => $hotels,
				'posts' => $avgs,
				'total' => $config ['total_rows'] 
		);
		$html = $this->_render_content ( $this->_load_view_file ( 'order_htl' ), $view_params, TRUE );
		echo $html;
	}
	public function ext_order_htl() {
		$avgs ['hotel_id'] = $this->input->get ( 'hotel_id' );
		$avgs ['order_time_start'] = $this->input->get ( 'order_time_start' );
		$avgs ['order_time_end'] = $this->input->get ( 'order_time_end' );
		$avgs ['start_date_start'] = $this->input->get ( 'start_date_start' );
		$avgs ['start_date_end'] = $this->input->get ( 'start_date_end' );
		$avgs ['end_date_start'] = $this->input->get ( 'end_date_start' );
		$avgs ['end_date_end'] = $this->input->get ( 'end_date_end' );
		
		$this->load->model ( 'distribute/report_model' );
		$admin_profile = $this->session->userdata ( 'admin_profile' );
		$confs = $this->report_model->get_dist_field_conf ( $admin_profile ['inter_id'], 'ORDERS_BY_HOTEL', $admin_profile ['admin_id'] );
		
		$this->load->model ( 'hotel/hotel_model' );
		if (! empty ( $admin_profile ['entity_id'] )) {
			$hotel_ids = explode ( ',', $admin_profile ['entity_id'] );
			if (! empty ( $avgs ['hotel_id'] ) && ! in_array ( $avgs ['hotel_id'], $hotel_ids )) {
				unset ( $avgs ['hotel_id'] );
			}
			$hotels = $this->hotel_model->get_hotel_by_ids ( $admin_profile ['inter_id'], $admin_profile ['entity_id'], NULL, 'key' );
		} else {
			$hotels = $this->hotel_model->get_all_hotels ( $admin_profile ['inter_id'], NULL, 'key' );
		}
		
		$this->load->model ( 'hotel/Hotel_report_model' );
		
		$avgs ['inter_id'] = $admin_profile ['inter_id'];
		$res = $this->Hotel_report_model->get_orders_by_hotel ( $avgs, NULL, 0 );
		
		$public = $this->db->get_where ( 'publics', array (
				'inter_id' => $admin_profile ['inter_id'] 
		) )->row_array ();
		$filename = $public ['name'] . '_' . date ( 'YmdHis' );
		$this->load->model ( 'plugins/Excel_model' );
		$head = array ();
		foreach ( $confs as $key => $item ) {
			if ($item ['must'] == 1 || $item ['choose'] == 1) {
				$head [] = $item ['name'];
			}
		}
		$data = array ();
		foreach ( $res as $k => $item ) {
			$tmp = array ();
			foreach ( $confs as $data_type => $i ) {
				if ($i ['must'] == 1 || $i ['choose'] == 1) {
					if (isset ( $item [$data_type] ))
						$tmp [] = $item [$data_type];
					else
						$tmp [] = '';
				}
			}
			$data [] = $tmp;
		}
		ob_clean ();
		$this->Excel_model->exp_exl ( $head, $data, $filename );
	}
	public function rooms_sales() {
		$avgs ['hotel_id'] = $this->input->post ( 'hotel_id' );
		$avgs ['check_date_start'] = $this->input->post ( 'check_date_start' );
		$avgs ['check_date_end'] = $this->input->post ( 'check_date_end' );
		
		$keys = $this->input->get ();
		foreach ( $avgs as $k => $v ) {
			if (! empty ( $keys [$k] )) {
				$avgs [$k] = $keys [$k];
			}
		}
		
		if (empty ( $avgs ['check_date_start'] ) && empty ( $avgs ['check_date_end'] )) {
			$avgs ['check_date_start'] = date ( 'Ymd' );
			$avgs ['check_date_end'] = date ( 'Ymd' );
		} else {
			if (empty ( $avgs ['check_date_start'] )) {
				$avgs ['check_date_start'] = $avgs ['check_date_end'];
			}
			if (empty ( $avgs ['check_date_end'] )) {
				$avgs ['check_date_end'] = $avgs ['check_date_start'];
			}
		}
		
		$this->load->model ( 'distribute/report_model' );
		$admin_profile = $this->session->userdata ( 'admin_profile' );
		$confs = $this->report_model->get_dist_field_conf ( $admin_profile ['inter_id'], 'ROOMS_SALES', $admin_profile ['admin_id'] );
		
		$this->load->model ( 'hotel/hotel_model' );
		if (! empty ( $admin_profile ['entity_id'] )) {
			$hotel_ids = explode ( ',', $admin_profile ['entity_id'] );
			if (! empty ( $avgs ['hotel_id'] ) && ! in_array ( $avgs ['hotel_id'], $hotel_ids )) {
				unset ( $avgs ['hotel_id'] );
			}
			$hotels = $this->hotel_model->get_hotel_by_ids ( $admin_profile ['inter_id'], $admin_profile ['entity_id'], NULL, 'key' );
		} else {
			$hotels = $this->hotel_model->get_all_hotels ( $admin_profile ['inter_id'], NULL, 'key' );
		}
		
		$this->load->model ( 'hotel/Hotel_report_model' );
		
		$avgs ['inter_id'] = $admin_profile ['inter_id'];
		$res = $this->Hotel_report_model->get_rooms_sales ( $avgs );
		$view_params = array (
				'res' => $res,
				'confs' => $confs,
				'hotels' => $hotels,
				'posts' => $avgs,
				'total' => count ( $res ) 
		);
		$html = $this->_render_content ( $this->_load_view_file ( 'rooms_sales' ), $view_params, TRUE );
		echo $html;
	}
	public function ext_rooms_sales() {
		$avgs ['hotel_id'] = $this->input->get ( 'hotel_id' );
		$avgs ['check_date_start'] = $this->input->get ( 'check_date_start' );
		$avgs ['check_date_end'] = $this->input->get ( 'check_date_end' );
		
		if (empty ( $avgs ['check_date_start'] ) && empty ( $avgs ['check_date_end'] )) {
			$avgs ['check_date_start'] = date ( 'Ymd' );
			$avgs ['check_date_end'] = date ( 'Ymd' );
		} else {
			if (empty ( $avgs ['check_date_start'] )) {
				$avgs ['check_date_start'] = $avgs ['check_date_end'];
			}
			if (empty ( $avgs ['check_date_end'] )) {
				$avgs ['check_date_end'] = $avgs ['check_date_start'];
			}
		}
		
		$this->load->model ( 'distribute/report_model' );
		$admin_profile = $this->session->userdata ( 'admin_profile' );
		$confs = $this->report_model->get_dist_field_conf ( $admin_profile ['inter_id'], 'ROOMS_SALES', $admin_profile ['admin_id'] );
		
		$this->load->model ( 'hotel/Hotel_report_model' );
		
		$avgs ['inter_id'] = $admin_profile ['inter_id'];
		$res = $this->Hotel_report_model->get_rooms_sales ( $avgs );
		
		$public = $this->db->get_where ( 'publics', array (
				'inter_id' => $admin_profile ['inter_id'] 
		) )->row_array ();
		$filename = $public ['name'] . '_' . date ( 'YmdHis' );
		$this->load->model ( 'plugins/Excel_model' );
		$head = array ();
		foreach ( $confs as $key => $item ) {
			if ($item ['must'] == 1 || $item ['choose'] == 1) {
				$head [] = $item ['name'];
			}
		}
		$data = array ();
		foreach ( $res as $k => $item ) {
			$tmp = array ();
			foreach ( $confs as $data_type => $i ) {
				if ($i ['must'] == 1 || $i ['choose'] == 1) {
					if (isset ( $item [$data_type] ))
						$tmp [] = $item [$data_type];
					else
						$tmp [] = '';
				}
			}
			$data [] = $tmp;
		}
		ob_clean ();
		$this->Excel_model->exp_exl ( $head, $data, $filename );
	}
	public function get_cofigs() {
		$this->load->model ( 'distribute/report_model' );
		echo json_encode ( $this->report_model->get_dist_field_conf () );
	}
	public function save_cofigs() {
		$this->load->model ( 'distribute/report_model' );
		if ($this->report_model->save_dist_field_conf ()) {
			echo 'success';
		} else {
			echo '保存失败';
		}
	}
	public function booking_summary(){
		$keys = $this->uri->segment(4);
		$btime  = $this->input->post('btime');
		$etime  = $this->input->post('etime');
		$keys = explode('_', $keys);
		if(!empty($keys[0])){
			$btime = $keys[0];
		}
		if(!empty($keys[1])){
			$etime = $keys[1];
		}
		$this->load->model('hotel/hotel_report_model');
		$admin_profile = $this->session->userdata('admin_profile');
	
		$this->load->library('pagination');
		$config['per_page']          = 20;
		$page = empty($this->uri->segment(5)) ? 0 : ($this->uri->segment(5) - 1) * $config['per_page'];
		
		$rbtime = empty($btime) ? null : strtotime($btime);
		$retime = empty($etime) ? null : strtotime($etime.' 23:59:59');

		$config['use_page_numbers']  = TRUE;
		$config['cur_page']          = $page;
		$res = $this->hotel_report_model->get_booking_summary($admin_profile['inter_id'],$rbtime,$retime,$config['per_page'],$config['cur_page'])->result();
		$config['uri_segment']       = 5;
		// 		$config['suffix']            = $sub_fix;
		$config['numbers_link_vars'] = array('class'=>'number');
		$config['cur_tag_open']      = '<a class="number current" href="#">';
		$config['cur_tag_close']     = '</a>';
		$config['base_url']          = site_url("hotel/hotel_report/booking_summary/".$btime.'_'.$etime);
		$config['total_rows']        = $this->hotel_report_model->get_booking_summary_count($admin_profile['inter_id'],$rbtime,$retime);
		$config['cur_tag_open'] = '<li class="paginate_button active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="paginate_button">';
		$config['num_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="paginate_button first">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="paginate_button last">';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="paginate_button previous">';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="paginate_button next">';
		$config['next_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		$this->load->model ( 'hotel/hotel_model' );
		$filterH ['inter_id'] = $admin_profile['inter_id'];
		$hotels = $this->hotel_model->get_hotel_hash ( $filterH );
		$hotels = $this->hotel_model->array_to_hash ( $hotels, 'name', 'hotel_id' );
		$view_params= array(
				'pagination' => $this->pagination->create_links(),
				'res'        => $res,
				'btime'      => $btime,
				'etime'      => empty($etime)?'':$etime,
				'hotels'     => $hotels,
				'total'      => $config['total_rows']
		);
		$html= $this->_render_content($this->_load_view_file('order_summary'), $view_params, TRUE);
		echo $html;
	}
	
	public function ex_booking_summary(){
		$keys = $this->uri->segment(4);
		$btime  = $this->input->post('btime');
		$etime  = $this->input->post('etime');
		$keys = explode('_', $keys);
		if(!empty($keys[0])){
			$btime = $keys[0];
		}
		if(!empty($keys[1])){
			$etime = $keys[1];
		}
		$this->load->model('hotel/hotel_report_model');
		$admin_profile = $this->session->userdata('admin_profile');
		
		$rbtime = empty($btime) ? null : strtotime($btime);
		$retime = empty($etime) ? null : strtotime($etime.' 23:59:59');
		
		$res = $this->hotel_report_model->get_booking_summary($admin_profile['inter_id'],$rbtime,$retime)->result();

		$this->load->model ( 'hotel/hotel_model' );
		$filterH ['inter_id'] = $admin_profile['inter_id'];
		$hotels = $this->hotel_model->get_hotel_hash ( $filterH );
		$hotels = $this->hotel_model->array_to_hash ( $hotels, 'name', 'hotel_id' );
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setTitle ( "export" )->setDescription ( "none" );
		$col = 0;
		$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 0, 1, '酒店名称' );
		$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 1, 1, '预订间数' );
		$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 2, 1, '取消间数' );
		$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 3, 1, '预付间数' );
		$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 4, 1, '入住间数' );
		$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 5, 1, '入住订单总额' );
		$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 6, 1, '离店间数' );
		$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 7, 1, '离店订单总额' );
		// Fetching the table data
		$row = 2;
		foreach ( $res as $item ) {
			$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 0, $row, $hotels[$item->hotel_id] );
			$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 1, $row, $item->total_count );
			$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 2, $row, $item->cancel_count );
			$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 3, $row, $item->prepay_count );
			$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 4, $row, $item->check_in_count );
			$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 5, $row, $item->check_in_amount );
			$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 6, $row, $item->check_out_count );
			$objPHPExcel->getActiveSheet ()->setCellValueByColumnAndRow ( 7, $row, $item->check_out_amount );
			$row ++;
		}
		$objPHPExcel->setActiveSheetIndex ( 0 );
		$objWriter = IOFactory::createWriter ( $objPHPExcel, 'Excel5' );
		// 发送标题强制用户下载文件
		header ( 'Content-Type: application/vnd.ms-excel' );
		header ( 'Content-Disposition: attachment;filename="' . date ( 'YmdHis' ) . '.xls"' );
		header ( 'Cache-Control: max-age=0' );
		$objWriter->save ( 'php://output' );
	}

	//统计复购率
	public function order_re_purchase(){
		$admin_profile = $this->session->userdata ( 'admin_profile' );

		$this->load->model ( 'hotel/hotel_model' );
		if (! empty ( $admin_profile ['entity_id'] )) {
			$hotels = $this->hotel_model->get_hotel_by_ids ( $admin_profile ['inter_id'], $admin_profile ['entity_id'], NULL, 'key' );
		} else {
			$hotels = $this->hotel_model->get_all_hotels ( $admin_profile ['inter_id'], NULL, 'key' );
		}
		
		$view_params = array (
				'hotels' => $hotels
		);
		$html = $this->_render_content ( $this->_load_view_file ( 'order_re_purchase' ), $view_params, TRUE );
		echo $html;
	}
	//异步获取复购率数据
	public function ajax_get_re_purchase(){
		$avgs ['hotel_id'] = $this->input->get ( 'hotel_id' );//酒店id
		$avgs ['time_type'] = $this->input->get ( 'time_type' );//时间类型
		$avgs ['month_start'] = $this->input->get ( 'month_start' );//开始月份
		$avgs ['month_end'] = $this->input->get ( 'month_end' );//结束月份
		
		$admin_profile = $this->session->userdata ( 'admin_profile' );

		$this->load->model ( 'hotel/hotel_model' );
		$filterH ['inter_id'] = $admin_profile ['inter_id'];
		if (! empty ( $admin_profile ['entity_id'] )) {
			$hotel_ids = explode ( ',', $admin_profile ['entity_id'] );
			$filterH ['hotel_id'] = $hotel_ids;
			if (! empty ( $avgs ['hotel_id'] ) && ! in_array ( $avgs ['hotel_id'], $hotel_ids )) {
				unset ( $avgs ['hotel_id'] );
			}
			$hotels = $this->hotel_model->get_hotel_by_ids ( $admin_profile ['inter_id'], $admin_profile ['entity_id'], NULL, 'key' );
		} else {
			$hotels = $this->hotel_model->get_all_hotels ( $admin_profile ['inter_id'], NULL, 'key' );
		}
		
		$this->load->model ( 'hotel/Hotel_report_model' );
		
		$avgs ['inter_id'] = $admin_profile ['inter_id'];
		$res = $this->Hotel_report_model->get_orders_re_purchase ( $avgs);
		echo json_encode($res);
	}



    public function all_order_rn() {
        $avgs ['hotel_id'] = $this->input->post ( 'hotel_id' );
        $avgs ['order_time_start'] = $this->input->post ( 'order_time_start' );
        $avgs ['order_time_end'] = $this->input->post ( 'order_time_end' );
        $avgs ['start_date_start'] = $this->input->post ( 'start_date_start' );
        $avgs ['start_date_end'] = $this->input->post ( 'start_date_end' );
        $avgs ['end_date_start'] = $this->input->post ( 'end_date_start' );
        $avgs ['end_date_end'] = $this->input->post ( 'end_date_end' );
        $avgs ['order_status'] = $this->input->post ( 'order_status' );
        $avgs ['orderid'] = $this->input->post ( 'orderid' );
        $avgs ['web_orderid'] = $this->input->post ( 'web_orderid' );
        $avgs ['in_name'] = $this->input->post ( 'in_name' );
        $avgs ['in_tel'] = $this->input->post ( 'in_tel' );
        $avgs ['inter_id'] = $this->input->post ( 'inter_id' );

        $keys = $this->input->get ();
        foreach ( $avgs as $k => $v ) {
            if (! empty ( $keys [$k] )) {
                $avgs [$k] = $keys [$k];
            }
        }

        $this->load->model ( 'distribute/report_model' );
        $admin_profile = $this->session->userdata ( 'admin_profile' );
        $confs = $this->report_model->get_dist_field_conf ( $admin_profile ['inter_id'], 'ORDERS_BY_ROOMNIGHT', $admin_profile ['admin_id'] );
        $inter_confs=array(
            'inter_id'=>array(
                'must'=>2,
                'choose'=>1,
                'name'=>'公众号'
            )
        );
        $confs=array_merge($inter_confs,$confs);
        $this->load->library ( 'pagination' );
        $config ['per_page'] = 20;
        $page = empty ( $this->uri->segment ( 4 ) ) ? 0 : ($this->uri->segment ( 4 ) - 1) * $config ['per_page'];

        $this->load->model ( 'hotel/hotel_model' );
        $filterH ['inter_id'] = $admin_profile ['inter_id'];
        if (! empty ( $admin_profile ['entity_id'] )) {
            $hotel_ids = explode ( ',', $admin_profile ['entity_id'] );
            $filterH ['hotel_id'] = $hotel_ids;
            if (! empty ( $avgs ['hotel_id'] ) && ! in_array ( $avgs ['hotel_id'], $hotel_ids )) {
                unset ( $avgs ['hotel_id'] );
            }
            $hotels = $this->hotel_model->get_hotel_by_ids ( $admin_profile ['inter_id'], $admin_profile ['entity_id'], NULL, 'key' );
        } else {
            $hotels = $this->hotel_model->get_all_hotels ( $admin_profile ['inter_id'], NULL, 'key' );
        }

        $this->load->model ( 'hotel/Hotel_report_model' );

        $config ['use_page_numbers'] = TRUE;
        $config ['cur_page'] = $page;
        $config ['suffix'] = "?" . http_build_query ( $avgs );
        if(empty($avgs ['inter_id'])){
            $avgs ['inter_id'] = $admin_profile ['inter_id'];
        }

        $res = $this->Hotel_report_model->get_all_orders_by_roomnight ( $avgs, $config ['per_page'], $config ['cur_page'] );
        $config ['uri_segment'] = 4;
        $config ['numbers_link_vars'] = array (
            'class' => 'number'
        );
        $config ['cur_tag_open'] = '<a class="number current" href="#">';
        $config ['cur_tag_close'] = '</a>';
        $config ['base_url'] = site_url ( "hotel/hotel_report/all_order_rn" );
        $config ['total_rows'] = $this->Hotel_report_model->get_all_orders_by_roomnight ( $avgs, NULL, 0, array (
            'just_count' => TRUE
        ) );
        $config ['cur_tag_open'] = '<li class="paginate_button active"><a>';
        $config ['cur_tag_close'] = '</a></li>';
        $config ['num_tag_open'] = '<li class="paginate_button">';
        $config ['num_tag_close'] = '</li>';
        $config ['first_tag_open'] = '<li class="paginate_button first">';
        $config ['first_tag_close'] = '</li>';
        $config ['first_url'] = site_url ( "hotel/hotel_report/all_order_rn" ) . "?" . http_build_query ( $avgs );
        $config ['last_tag_open'] = '<li class="paginate_button last">';
        $config ['last_tag_close'] = '</li>';
        $config ['prev_tag_open'] = '<li class="paginate_button previous">';
        $config ['prev_tag_close'] = '</li>';
        $config ['next_tag_open'] = '<li class="paginate_button next">';
        $config ['next_tag_close'] = '</li>';
        $this->pagination->initialize ( $config );

        $view_params = array (
            'pagination' => $this->pagination->create_links (),
            'res' => $res,
            'confs' => $confs,
            'hotels' => $hotels,
            'posts' => $avgs,
            'total' => $config ['total_rows']
        );

        $html = $this->_render_content ( $this->_load_view_file ( 'all_order_rn' ), $view_params, TRUE );
        echo $html;
    }


    public function ext_all_order_rn() {
        $avgs ['hotel_id'] = $this->input->get ( 'hotel_id' );
        $avgs ['order_time_start'] = $this->input->get ( 'order_time_start' );
        $avgs ['order_time_end'] = $this->input->get ( 'order_time_end' );
        $avgs ['start_date_start'] = $this->input->get ( 'start_date_start' );
        $avgs ['start_date_end'] = $this->input->get ( 'start_date_end' );
        $avgs ['end_date_start'] = $this->input->get ( 'end_date_start' );
        $avgs ['end_date_end'] = $this->input->get ( 'end_date_end' );
        $avgs ['order_status'] = $this->input->get ( 'order_status' );
        $avgs ['orderid'] = $this->input->get ( 'orderid' );
        $avgs ['web_orderid'] = $this->input->get ( 'web_orderid' );
        $avgs ['in_name'] = $this->input->get ( 'in_name' );
        $avgs ['in_tel'] = $this->input->get ( 'in_tel' );
        $avgs ['inter_id'] = $this->input->get ( 'inter_id' );


        $this->load->model ( 'distribute/report_model' );
        $admin_profile = $this->session->userdata ( 'admin_profile' );
        $confs = $this->report_model->get_dist_field_conf ( $admin_profile ['inter_id'], 'ORDERS_BY_ROOMNIGHT', $admin_profile ['admin_id'] );

        $inter_confs=array(
            'inter_id'=>array(
                'must'=>2,
                'choose'=>1,
                'name'=>'公众号'
            )
        );
        $confs=array_merge($inter_confs,$confs);

        $this->load->model ( 'hotel/hotel_model' );
        $filterH ['inter_id'] = $admin_profile ['inter_id'];
        if (! empty ( $admin_profile ['entity_id'] )) {
            $hotel_ids = explode ( ',', $admin_profile ['entity_id'] );
            $filterH ['hotel_id'] = $hotel_ids;
            if (! empty ( $avgs ['hotel_id'] ) && ! in_array ( $avgs ['hotel_id'], $hotel_ids )) {
                unset ( $avgs ['hotel_id'] );
            }
            $hotels = $this->hotel_model->get_hotel_by_ids ( $admin_profile ['inter_id'], $admin_profile ['entity_id'], NULL, 'key' );
        } else {
            $hotels = $this->hotel_model->get_all_hotels ( $admin_profile ['inter_id'], NULL, 'key' );
        }

        $this->load->model ( 'hotel/Hotel_report_model' );

        if(empty($avgs ['inter_id'])){
            $avgs ['inter_id'] = $admin_profile ['inter_id'];
        }
        $res = $this->Hotel_report_model->get_all_orders_by_roomnight ( $avgs, NULL, 0, array (
            'xls' => TRUE
        ) );

        $public = $this->db->get_where ( 'publics', array (
            'inter_id' => $admin_profile ['inter_id']
        ) )->row_array ();
        $filename = $public ['name'] . '_' . date ( 'YmdHis' );
        $this->load->model ( 'plugins/Excel_model' );
        $head = array ();
        foreach ( $confs as $key => $item ) {
            if ($item ['must'] == 1 || $item ['choose'] == 1) {
                $head [] = $item ['name'];
            }
        }
        $data = array ();
        foreach ( $res as $k => $item ) {
            $tmp = array ();
            foreach ( $confs as $data_type => $i ) {
                if ($i ['must'] == 1 || $i ['choose'] == 1) {
                    if (isset ( $item [$data_type] ))
                        $tmp [] = $item [$data_type];
                    else
                        $tmp [] = '';
                }
            }
            $data [] = $tmp;
        }
        ob_clean ();
        $this->Excel_model->exp_exl ( $head, $data, $filename );
    }

}
