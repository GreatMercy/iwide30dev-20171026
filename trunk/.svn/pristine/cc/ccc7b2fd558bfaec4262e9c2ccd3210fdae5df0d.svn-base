<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Atools extends MY_Admin {
	protected $label_module = NAV_HOTELS;
	protected $label_controller = '酒店列表';
	protected $label_action = '';
	function __construct() {
		parent::__construct ();
	}
	function exchange_ym_location() {
		$sql = "SELECT * FROM `iwide_hotels` WHERE `inter_id` LIKE 'a445223616' and status =1";
		$hotels = $this->db->query ( $sql )->result_array ();
// var_dump($hotels);exit;
		$this->load->helper ( 'calculate' );
		foreach ( $hotels as $h ) {
			if (! empty ( $h ['longitude'] )) {
				$data = bd2gcj ( $h ['longitude'], $h ['latitude'] );
				$this->db->where ( array (
						'inter_id' => 'a445223616',
						'hotel_id' => $h ['hotel_id'] 
				) );
				$this->db->update ( 'hotels', array (
						'longitude' => $data ['longitude'],
						'latitude' => $data ['latitude'] 
				) );
			}
		}
	}
}
