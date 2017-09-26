<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Hotel extends MY_Admin_Iapi {
	protected $label_module = NAV_HOTEL;
	protected $label_controller = '订房';
	protected $label_action = '';
	function __construct() {
		parent::__construct ();
		$this->inter_id = $this->session->get_admin_inter_id ();
		$this->module = 'hotel';
	}
	protected function main_model_name() {
		return 'hotel/hotel_model';
	}
	
	public function get_hotels()
	{
		$admin_profile = $this->session->userdata ( 'admin_profile' );

		$this->load->model ( $this->main_model_name() );
		if (! empty ( $admin_profile ['entity_id'] )) {
			$hotels = $this->hotel_model->get_hotel_by_ids ( $admin_profile ['inter_id'], $admin_profile ['entity_id'], NULL, 'key' );
		} else {
			$hotels = $this->hotel_model->get_all_hotels ( $admin_profile ['inter_id'], NULL, 'key' );
		}
		
		$return = array (
				'hotels' => $hotels
		);
		$this->out_put_msg(1,'',$return,'hotel/hotel/get_hotels',200);
	}

}
