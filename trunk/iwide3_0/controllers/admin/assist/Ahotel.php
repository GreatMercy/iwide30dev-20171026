<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Ahotel extends MY_Admin {
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
	function lowest_price() {
	}
}
