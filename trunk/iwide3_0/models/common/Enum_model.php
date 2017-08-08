<?php
class Enum_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	function get_enum_des($type, $status = 1, $inter_id = 'defaultdes') {
		$arr = array ();
		is_array ( $status ) ? $this->db->where_in ( 'status', $status ) : $this->db->where ( 'status', $status );
		if (empty ( $inter_id ) || $inter_id=='defaultdes') {
			$this->db->where ( array (
					'inter_id' => 'defaultdes' 
			) );
		} else {
			$this->db->order_by ( 'inter_id desc' );
			$this->db->where_in ( 'inter_id', array (
					$inter_id,
					'defaultdes' 
			) );
		}
		if (is_array ( $type )) {
			$this->db->where_in ( 'type', $type );
			$des = $this->db->get ( 'enum_desc' )->result_array ();
			foreach ( $des as $d ) {
				$arr [$d ['type']] [$d ['code']] = $d ['des'];
			}
		} else {
			$this->db->where ( array (
					'type' => $type 
			) );
			$des = $this->db->get ( 'enum_desc' )->result_array ();
			foreach ( $des as $d ) {
				$arr [$d ['code']] = $d ['des'];
			}
		}
		return $arr;
	}
}