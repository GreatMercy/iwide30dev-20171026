<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Import extends MY_Admin {
	function __construct() {
		parent::__construct ();
		$this->inter_id = $this->session->get_admin_inter_id ();
		$this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
		$this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
		$this->common_data ['inter_id'] = $this->inter_id;
	}
	function index() {
		exit ();
	}
	public function import_xlshotel() {
		$data = $this->common_data;
		$this->load->model ( 'hotel/Hotel_import_model' );
		$data ['services'] = $this->Hotel_import_model->imgs ( 'hotel_service' );
		$this->_render_content ( $this->_load_view_file ( 'import_xlshotel' ), $data, false );
	}
	public function xls_upload() {
		$type = $this->input->post ( 'type' );
		$config ['upload_path'] = '../www_admin/public/uploads/'.date('Ym');
		$config ['file_name'] = date ( 'YmdHis' ) . rand ( 10, 99 );
		$config['allowed_types'] ='*';
		$config ['max_size'] = '1024';
		$config ['encrypt_name'] = TRUE;
		$this->load->model('common/File_model');
		$result=$this->File_model->admin_upload_file($config);
		/*array(2) {
  ["s"]=>
  int(1)
  ["data"]=>
  array(14) {
    ["file_name"]=>
    string(37) "9aa97086e8a1d55de1cfb43d489d269f.xlsx"
    ["file_type"]=>
    string(24) "application/octet-stream"
    ["file_path"]=>
    string(48) "D:/work/svns/i3/www_admin/public/uploads/201607/"
    ["full_path"]=>
    string(85) "D:/work/svns/i3/www_admin/public/uploads/201607/9aa97086e8a1d55de1cfb43d489d269f.xlsx"
    ["raw_name"]=>
    string(32) "9aa97086e8a1d55de1cfb43d489d269f"
    ["orig_name"]=>
    string(21) "2016072218505085.xlsx"
    ["client_name"]=>
    string(35) "酒店批量导入标准文档.xlsx"
    ["file_ext"]=>
    string(5) ".xlsx"
    ["file_size"]=>
    float(11.98)
    ["is_image"]=>
    bool(false)
    ["image_width"]=>
    NULL
    ["image_height"]=>
    NULL
    ["image_type"]=>
    string(0) ""
    ["image_size_str"]=>
    string(0) ""
  }
}*/
		if ($result['s']==1){
			echo json_encode ( array (
					'status' => 1,
					'message' => '2' 
			) );
		}else {
			echo json_encode ( array (
					'status' => 2,
					'message' => $result['errdata']
			) );
		}
	}
}
