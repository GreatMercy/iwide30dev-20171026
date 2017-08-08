<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Hotel_import_model extends MY_Model {
	function __construct() {
		parent::__construct ();
	}
	function import_hotel($inter_id, $hotels, $params = array()) {
		$default_imgs = $this->imgs ( 'hotel_service' );
		$hotel_services = array ();
		$success_hotels = array ();
		$fail_hotels = array ();
		$prefix = 'http://file.iwide.cn/public/uploads/' . date ( 'Ym' ) . '/';
		foreach ( $hotels as $h ) {
			$h ['inter_id'] = $inter_id;
			if (! empty ( $h ['services_imgs'] )) {
				$services_imgs = explode ( ',', $h ['services_imgs'] );
				unset ( $h ['services_imgs'] );
			}
			if (! empty ( $params ['create_img'] ) && empty ( $h ['intro_img'] ) && ! empty ( $h ['i'] )) {
				$h ['intro_img'] = $prefix . $inter_id . '-hi-' . $h ['i'] . '.jpg';
			}
			if (! empty ( $r ['i'] )) {
				unset ( $r ['i'] );
			}
			if ($this->db->insert ( 'hotels', $h )) {
				$hotel_id = $this->db->insert_id ();
				$success_hotels [$hotel_id] = $h ['name'];
				if (! empty ( $services_imgs )) {
					foreach ( $services_imgs as $img_id ) {
						if (! empty ( $default_imgs [$img_id] )) {
							$tmp = $default_imgs [$img_id];
							$tmp ['hotel_id'] = $hotel_id;
							$tmp ['inter_id'] = $inter_id;
							$hotel_services [] = $tmp;
						}
					}
				}
			} else {
				$fail_hotels [] = $h ['name'];
			}
		}
		if (! empty ( $hotel_services )) {
			$this->db->insert_batch ( 'hotel_imgs', $hotel_services );
		}
		return array (
				'success' => $success_hotels,
				'fail' => $fail_hotels 
		);
	}
	function import_rooms($inter_id, $rooms, $params = array()) {
		$default_imgs = $this->imgs ( 'hotel_room_service' );
		$room_services = array ();
		$success_rooms = array ();
		$fail_rooms = array ();
		$prefix = 'http://file.iwide.cn/public/uploads/' . date ( 'Ym' ) . '/';
		foreach ( $rooms as $r ) {
			$r ['inter_id'] = $inter_id;
			if (! empty ( $r ['services_imgs'] )) {
				$services_imgs = explode ( ',', $r ['services_imgs'] );
				unset ( $r ['services_imgs'] );
			}
			if (! empty ( $params ['create_img'] ) && empty ( $r ['room_img'] ) && ! empty ( $r ['i'] )) {
				$r ['room_img'] = $prefix . $inter_id . '-ri-' . $r ['hotel_id'] . '-' . $r ['i'] . '.jpg';
			}
			if (! empty ( $r ['i'] )) {
				unset ( $r ['i'] );
			}
			if ($this->db->insert ( 'hotel_rooms', $r )) {
				$room_id = $this->db->insert_id ();
				$success_rooms [$r ['hotel_id']] [$room_id] = $r ['name'];
				if (! empty ( $services_imgs )) {
					foreach ( $services_imgs as $img_id ) {
						if (! empty ( $default_imgs [$img_id] )) {
							$tmp = $default_imgs [$img_id];
							$tmp ['hotel_id'] = $r ['hotel_id'];
							$tmp ['room_id'] = $room_id;
							$tmp ['inter_id'] = $inter_id;
							$room_services [] = $tmp;
						}
					}
				}
			} else {
				$fail_rooms [] = $r ['name'];
			}
		}
		if (! empty ( $room_services )) {
			$this->db->insert_batch ( 'hotel_imgs', $room_services );
		}
		return array (
				'success' => $success_hotels,
				'fail' => $fail_hotels 
		);
	}
	function imgs($type) {
		switch ($type) {
			case 'hotel_service' :
				$this->load->model ( 'hotel/Image_model' );
				$imgs = $this->Image_model->get_hotels_img ( 'defaultimg', 0, 'hotel_service' );
				if (! empty ( $imgs [0] ['hotel_service'] )) {
					return $imgs [0] ['hotel_service'];
				}
				break;
			case 'hotel_room_service' :
				$this->load->model ( 'hotel/Image_model' );
				$imgs = $this->Image_model->get_hotels_img ( 'defaultimg', 0, 'hotel_room_service' );
				if (! empty ( $imgs [0] ['hotel_room_service'] )) {
					return $imgs [0] ['hotel_room_service'];
				}
				break;
			default :
				break;
		}
		return array ();
	}
}
