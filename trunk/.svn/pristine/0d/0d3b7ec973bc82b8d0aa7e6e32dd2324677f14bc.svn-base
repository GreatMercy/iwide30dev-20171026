<?php
/**
* 比价系统后台
* author chenjunyu
* date 2016-10-30
*/
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Parity extends MY_Admin{
	function __construct(){
		parent::__construct();
	}

	function index(){
		echo __METHOD__;
	}

	//比价首页(管理员版)
	public function admin_index(){
		$data = array('content'=>'This is admin_index，比价首页(管理员版)');
		$this->_render_content ( $this->_load_view_file ( 'admin_index' ), $data, false );
	}

	//比价首页(酒店版)
	public function hotel_index(){
		$data = array('content'=>'This is hotel_index，比价首页(酒店版)');
		$this->_render_content( $this->_load_view_file( 'hotel_index' ), $data, false);
	}

	//比价结果页
	public function detail(){
		$data = array('content'=>'This is detail，比价结果页');
		$this->_render_content( $this->_load_view_file( 'detail' ), $data, false);
	}

	//房型匹配(运营管理)
	public function admin_match(){
		$data = array('content'=>'This is admin_match，房型匹配(运营管理)');
		$this->_render_content( $this->_load_view_file( 'admin_match' ), $data, false);
	}

	//房型匹配(酒店集团》房型匹配)
	public function hotels_match(){
		$data = array('content'=>'This is hotels_match，酒店集团》房型匹配');
		$this->_render_content( $this->_load_view_file( 'hotels_match' ), $data, false);
	}

	//酒店/房型匹配修改
	public function hotel_edit(){
		$data = array('content'=>'This is hotel_edit，酒店/房型匹配修改');
		$this->_render_content( $this->_load_view_file( 'hotel_edit' ), $data, false);
	}
}