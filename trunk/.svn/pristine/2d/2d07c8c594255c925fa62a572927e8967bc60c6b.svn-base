<?php
class Hotel_config_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	const TAB_HOTEL_CONFIG = 'hotel_config';
	function get_hotel_config($inter_id, $module, $hotel_id, $type, $params = array()) {
		$arr = array ();
		$this->db->order_by ( 'hotel_id asc' );
		$this->db->where_in ( 'hotel_id', array (
				0,
				$hotel_id 
		) );
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'module' => $module 
		) );
		if (empty ( $params ['effect'] ) || $params ['effect'] == 1) {
			$this->db->where ( 'priority >', - 1 );
		}
		if (is_array ( $type )) {
			$this->db->where_in ( 'param_name', $type );
			$config = $this->db->get ( self::TAB_HOTEL_CONFIG )->result_array ();
			foreach ( $config as $d ) {
				$arr [$d ['param_name']] = $d ['param_value'];
			}
		} else {
			$this->db->where ( 'param_name', $type );
			$config = $this->db->get ( self::TAB_HOTEL_CONFIG )->row_array ();
			if (! empty ( $config ))
				$arr [$config ['param_name']] = $config ['param_value'];
		}
		return $arr;
	}
	function get_hotels_config($inter_id, $module, $hotel_ids, $type, $params = array()) {
		$arr = array ();
		$this->db->order_by ( 'hotel_id asc' );
		if (empty ( $params ['default'] ) || $params ['default'] == 1) {
			$hotel_ids [] = 0;
		}
		$this->db->where_in ( 'hotel_id', $hotel_ids );
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'module' => $module 
		) );
		if (empty ( $params ['effect'] ) || $params ['effect'] == 1) {
			$this->db->where ( 'priority >', - 1 );
		}
		is_array ( $type )?$this->db->where_in ( 'param_name', $type ):$this->db->where ( 'param_name', $type );
		$config = $this->db->get ( self::TAB_HOTEL_CONFIG )->result_array ();
		foreach ( $config as $d ) {
			$arr [$d ['hotel_id']] [$d ['param_name']] [$d['id']] = $d ;
		}
		return $arr;
	}

	public function replace_config($param){
		if(!empty($param['id'])){
			$map = [
				'id'       => $param['id'],
				'inter_id' => $param['inter_id'],
				'hotel_id' => $param['hotel_id'],
			];
			unset($param['id']);
			$this->db->update('hotel_config', $param, $map);
			return true;
		} else{
			unset($param['id']);
			$this->db->insert('hotel_config', $param);
			$id = $this->db->insert_id();
			return $id;
		}
	}

	public function get_hotels_config_row($inter_id, $module, $hotel_id, $type){
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'module' => $module,
				'hotel_id' => $hotel_id,
				'param_name' => $type
		) );
		return $this->db->get ( self::TAB_HOTEL_CONFIG )->row_array ();
	}
}