<?php
// error_reporting ( 0 );
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Order_interface extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		$this->output->enable_profiler ( false );
		ini_set ( 'display_errors', 0 );
		if (version_compare ( PHP_VERSION, '5.3', '>=' )) {
			error_reporting ( E_ALL & ~ E_NOTICE & ~ E_DEPRECATED & ~ E_STRICT & ~ E_USER_NOTICE & ~ E_USER_DEPRECATED );
		} else {
			error_reporting ( E_ALL & ~ E_NOTICE & ~ E_STRICT & ~ E_USER_NOTICE );
		}
	}
	public function get_roomstate() {
		try {
			$now = time ();
			$this->load->model ( 'interface/Icommon_model' );
			$this->load->model ( 'interface/Isigniture_model' );
			$source = $this->Icommon_model->_base_input_valid ();
			if (empty ( $source ['hotel_id'] )) {
				$this->Icommon_model->out_put_msg ( FALSE, 'wrong hotel id' );
			}
			$this->load->model ( 'hotel/Hotel_model' );
			$inter_id = $source ['itd'];
			$hotel_id = $source ['hotel_id'];
			$rooms = $this->Hotel_model->get_hotel_rooms ( $inter_id, $hotel_id );
			$this->load->model ( 'hotel/Member_model' );
			$member_privilege = $this->Member_model->level_privilege ( $inter_id );
			$levels = $this->Member_model->get_member_levels ( $inter_id );
			$condit = array (
					'startdate' => $source ['startdate'],
					'enddate' => $source ['enddate'] 
			);
			if (! empty ( $member_privilege )) {
				$condit ['member_privilege'] = $member_privilege;
			}
			if (! empty ( $levels )) {
				$condit ['member_level'] = current ( array_keys ( $levels ) );
			}
			$this->load->library ( 'PMS_Adapter', array (
					'inter_id' => $inter_id,
					'hotel_id' => $hotel_id 
			), 'pmsa' );
			$rooms = $this->pmsa->get_rooms_change ( $rooms, array (
					'inter_id' => $inter_id,
					'hotel_id' => $hotel_id 
			), $condit, true );
			$rooms = $this->_room_state_format ( $rooms );
			
			$this->load->helper('common');
			$this->load->model('common/Webservice_model');
			$this->Webservice_model->add_webservice_record($inter_id, 'localorder', $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'], $source, $rooms,'rec_post', $now, microtime (), getIp());
			
			$this->Icommon_model->out_put_msg ( TRUE, '查询成功', $rooms );
		} catch ( Exception $ex ) {
			$this->Icommon_model->out_put_msg ( FALSE );
		}
	}
	private function _room_state_format($state) {
		$filter = array (
				'room' => array (
						'room_id',
						'name' 
				),
				'state' => array (
						'price_name',
						'price_code',
						'total_price',
						'avg_price',
						'book_status'
				),
				'others' => array (
						'show_info',
						'all_full',
						'top_price' 
				) 
		);
		foreach ( $state as $room_id => &$sta ) {
			$sta ['state_info'] = $sta ['state_info'] + $sta ['show_info'];
			foreach ( $sta ['room_info'] as $rk => $ri ) {
				if (! in_array ( $rk, $filter ['room'] )) {
					unset ( $sta ['room_info'] [$rk] );
				}
			}
			foreach ( $sta ['state_info'] as $price_code => $price_info ) {
				foreach ( $price_info as $pk => $pi ) {
					if (! in_array ( $pk, $filter ['state'] )) {
						unset ( $sta ['state_info'] [$price_code] [$pk] );
					}
				}
			}
			foreach ( $sta as $sk => $st ) {
				if (in_array ( $sk, $filter ['others'] )) {
					unset ( $sta [$sk] );
				}
			}
		}
		return $state;
	}
}