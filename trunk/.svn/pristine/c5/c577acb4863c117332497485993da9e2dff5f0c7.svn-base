<?php
class Okpay_model extends CI_Model{
	function __construct() {
		parent::__construct ();
	}
	
	const TAB_OKPAY_ORDERS = 'okpay_orders';

	public function create_new_okpay_order($arr){
		$arr['create_time'] = time();
		$arr['update_time'] = time();
		$arr['status']		= 1;
		$arr['pay_status']	= 1;
		
		$this->db->insert(self::TAB_OKPAY_ORDERS,$arr);
		$insert_id = $this->db->insert_id();
		
		if($insert_id){
			return true;
		}else{
			return false;
		}
	}
	
}
