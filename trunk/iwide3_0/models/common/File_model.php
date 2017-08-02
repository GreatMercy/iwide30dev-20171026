<?php
class File_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	function admin_upload_file($config,$params=array()) {
		if( (!isset($params['create_dir'])||$params['create_dir']==1)&&!is_dir($config['upload_path'])){
			mkdir($config['upload_path']);
		}
		$this->load->library ( 'upload', $config );
		$this->upload->initialize ( $config );
		$this->load->model('hotel/Hotel_log_model');
		$admin_profile = $this->session->admin_profile;
		$admin_id=$admin_profile ['admin_id'];
		if ($this->upload->do_upload ( 'Filedata' )) {
			$data=$this->upload->data ();
			$this->Hotel_log_model->add_admin_log('upload_files#'.$admin_id,'upload',array('config'=>$config,'file'=>$data));
			return array('s'=>1,'data'=>$data);
		} else {
			return array('s'=>0,'errdata'=>$this->upload->error_msg);
		}
	}
}