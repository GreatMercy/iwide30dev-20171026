<?php
class Package_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->library('MYLOG');
	}
	function get_hotels_roomstate($inter_id, $startdate, $enddate, $hotel_rooms = array(), $params = array()) {
		MYLOG::w('inter_id:'.$inter_id.',startdate:'.$startdate.',enddate:'.$enddate.',params:'.json_encode($params).',hotel_rooms:'.json_encode($hotel_rooms),'package_hotel','get_hotels_roomstate');
		if (empty ( $hotel_rooms )) {
			return $this->rtn_msg ( FALSE, '缺少$hotel_rooms' );
		}
		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->model ( 'hotel/Hotel_check_model' );
		$condit = array (
				'startdate' => date ( 'Ymd', strtotime ( $startdate ) ),
				'enddate' => date ( 'Ymd', strtotime ( $enddate ) ),
				'is_package'=>1
		);
		if (! empty ( $params ['openid'] )) {
			$pub_pmsa = $this->Hotel_check_model->get_hotel_adapter ( $inter_id, 0, TRUE );
			$member = $pub_pmsa->check_openid_member ( $inter_id, $params ['openid'] );
			if (! empty ( $member ) && isset ( $member->mem_id )) {
				$member_no = $member->mem_card_no;
				$member_lv = $member->level;
			}
			$condit ['openid'] = $params ['openid'];
		}

		$this->load->model ( 'hotel/Member_model' );
		$member_privilege = $this->Member_model->level_privilege ( $inter_id );
		if (! empty ( $member_privilege )) {
			$condit ['member_privilege'] = $member_privilege;
		}
		if (! empty ( $member_lv )) {
			$condit ['member_level'] = $member_lv;
		}

		$in_room = '';
		$hotel_ids = '';
		$hotel_price_codes = array ();
		foreach ( $hotel_rooms as $hotel_id => $room ) {
			$hotel_ids .= ',' . $hotel_id;
			// if (empty($room)){
			// $in_hotel .= ',' . $hotel_id;
			// }else {
			if (! empty ( $room )) {
				$hotel_price_codes [$hotel_id] = array ();
				foreach ( $room as $r ) {
					$hotel_price_codes [$hotel_id] = array_merge ( $hotel_price_codes [$hotel_id], $r );
				}
				$hotel_price_codes [$hotel_id] = array_unique ( $hotel_price_codes [$hotel_id] );
				$in_room .= ',' . implode ( ',', array_keys ( $room ) );
			}
		}
		$hotels = $this->Hotel_model->get_hotel_by_ids ( $inter_id, substr ( $hotel_ids, 1 ) );
		$hotels = array_column ( $hotels, NULL, 'hotel_id' );
		$rooms = array ();
		$db = $this->load->database('iwide_r1',true);
		if (! empty ( $in_room )) {
			$sql = "select room_id,name,room_img,hotel_id,nums,sort,webser_id from iwide_hotel_rooms where inter_id='$inter_id' and ";
			$sql .= " room_id in (" . substr ( $in_room, 1 ) . ") ";
			$result = $db->query ( $sql )->result_array ();
			if ($result) {
				foreach ( $result as $r ) {
					$rooms [$r ['hotel_id']] [$r ['room_id']] = $r;
				}
			} else {
				return $this->rtn_msg ( FALSE, '没有查询到房型信息' );
			}
		} else {
			return $this->rtn_msg ( FALSE, '没有房型信息' );
		}
		$data = array ();
		foreach ( $hotel_rooms as $hotel_id => $room ) {
			$data [$hotel_id] = array (
					'hotel_info' => array (),
					'room_state' => array ()
			);
			if (! empty ( $hotels [$hotel_id] )) {
				$data [$hotel_id] ['hotel_info'] = array (
						'name' => $hotels [$hotel_id] ['name'],
						'address' => $hotels [$hotel_id] ['address'],
						'hotel_id' => $hotel_id
				);
			}
			if (! empty ( $rooms [$hotel_id] )) {
				if (! empty ( $hotel_price_codes [$hotel_id] )) {
					$adapter = $this->Hotel_check_model->get_hotel_adapter ( $inter_id, $hotel_id, TRUE );
					$condit ['price_codes'] = implode ( ',', $hotel_price_codes [$hotel_id] );
					$data [$hotel_id] ['room_state'] = $adapter->get_rooms_change ( $rooms [$hotel_id], array (
							'inter_id' => $inter_id,
							'hotel_id' => $hotel_id
					), $condit, true );
				}
			}
		}
		MYLOG::w('hotels:'.json_encode($hotels).',rooms:'.json_encode($rooms).',hotel_price_codes:'.json_encode($hotel_price_codes).'data:'.json_encode($data),'package_hotel','get_hotels_roomstate');
		return $this->_room_state_format ( $data, $hotel_rooms );
	}
	function package_to_order($inter_id, $params) {
		MYLOG::w('inter_id:'.$inter_id.',params:'.json_encode($params),'package_hotel','package_to_order');
		$ness = array (
				'hotel_id',
				'room_id',
				'startdate',
				'enddate',
				'openid',
				'roomnums',
				'price_code',
				'name',
				'tel',
				'allprice'
		);
		if ($diff = array_diff ( $ness, array_keys ( $params ) )) {
			return $this->rtn_msg ( FALSE, '缺少 ' . current ( $diff ) . '' );
		}

		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->model ( 'hotel/Order_model' );
		$this->load->model ( 'hotel/Hotel_check_model' );
		$hotel_id = $params ['hotel_id'];
		$room_id = $params ['room_id'];
		$openid = $params ['openid'];

		if (! strtotime ( $params ['startdate'] ) || ! strtotime ( $params ['enddate'] ) || $params ['startdate'] < date ( 'Ymd' ) || $params ['enddate'] <= $params ['startdate']) {
			return $this->rtn_msg ( FALSE, '入离日期错误' );
		}
		$params ['roomnums'] = intval ( $params ['roomnums'] );
		$startdate = date ( 'Ymd', strtotime ( $params ['startdate'] ) );
		$enddate = date ( 'Ymd', strtotime ( $params ['enddate'] ) );
		if (empty ( $params ['roomnums'] )) {
			return $this->rtn_msg ( FALSE, '房间数不正确！' );
		}
		$price = explode ( ',', $params ['allprice'] );
		$this->load->helper('date');
		if (count ( $price ) != get_room_night ( $startdate, $enddate )) {
			return $this->rtn_msg ( FALSE, '价格不正确！' );
		}
		$price = array_sum ( $price );

		$condit = array (
				'startdate' => $startdate,
				'enddate' => $enddate
		);
		$condit ['openid'] = $openid;
		$pub_pmsa = $this->Hotel_check_model->get_hotel_adapter ( $inter_id, 0, TRUE );
		$member = $pub_pmsa->check_openid_member ( $inter_id, $openid );
		if (! empty ( $member ) && isset ( $member->mem_id )) {
			$member_no = $member->mem_card_no;
			$member_lv = $member->level;
		}
		$condit ['openid'] = $openid;
		$condit ['nums'] = $params ['roomnums'];
		$condit ['price_codes'] = $params ['price_code'];
		$this->load->model ( 'hotel/Member_model' );
		$member_privilege = $this->Member_model->level_privilege ( $inter_id );
		if (! empty ( $member_privilege )) {
			$condit ['member_privilege'] = $member_privilege;
		}
		if (! empty ( $member_lv )) {
			$condit ['member_level'] = $member_lv;
		}
		$room_list = $this->Hotel_model->get_rooms_detail ( $inter_id, $hotel_id, array (
				$room_id
		), array (
				'data' => 'key'
		) );
		$adapter = $this->Hotel_check_model->get_hotel_adapter ( $inter_id, $hotel_id, TRUE );
		$rooms = $adapter->get_rooms_change ( $room_list, array (
				'inter_id' => $inter_id,
				'hotel_id' => $hotel_id
		), $condit, true );
		if (empty ( $rooms )) {
			return $this->rtn_msg ( FALSE, '无可订房间！' );
		}

		$data_arr = array (
				$room_id => $params ['roomnums']
		);
		$order_data = array ();
		$order_additions = array ();
		$subs = array ();
		$room_codes = array ();
		$roomnos = array ();

		foreach ( $rooms as $k => $rm ) {
			$code_price = $rm ['state_info'] [$params ['price_code']];
				
			if ($code_price ['book_status'] != 'available') {
				return $this->rtn_msg ( FALSE, '房间数不足！' );
			}
			$room_info = $rm ['room_info'];
			$room_codes [$room_info ['room_id']] ['code'] ['price_type'] = $code_price ['price_type'];
			$price_type = $code_price ['price_type'];
			empty ( $code_price ['extra_info'] ) or $room_codes [$room_info ['room_id']] ['code'] ['extra_info'] = $code_price ['extra_info'];
			$room_codes [$room_info ['room_id']] ['room'] ['webser_id'] = $rm ['room_info'] ['webser_id'];
				
			$subs [$room_info ['room_id']] ['allprice'] = $params ['allprice'];
			$subs [$room_info ['room_id']] ['roomname'] = $room_info ['name'];
			$subs [$room_info ['room_id']] ['iprice'] = $price;
			$subs [$room_info ['room_id']] ['price_code'] = $params ['price_code'];
			$subs [$room_info ['room_id']] ['price_code_name'] = $code_price ['price_name'];
		}
		$order_data ['price'] = $price * $params ['roomnums'];
		$order_data ['roomnums'] = $params ['roomnums'];
		$order_data ['hotel_id'] = $hotel_id;
		$order_data ['inter_id'] = $inter_id;
		$order_data ['openid'] = $openid;
		$order_data ['name'] = $params ['name'];
		$order_data ['tel'] = $params ['tel'];
		$order_data ['startdate'] = $startdate;
		$order_data ['enddate'] = $enddate;
		$order_data ['remark'] = $params['remark'];
		$order_data ['status'] = 0;
		$order_data ['price_type'] = $price_type;
		$order_data ['paytype'] = 'package';
		$order_data ['channel'] = 'package';
		if (! empty ( $member_no ))
			$order_data ['member_no'] = $member_no;
			$order_additions ['room_codes'] = json_encode ( $room_codes );
			$info = $this->Order_model->create_order ( $inter_id, array (
					'main_order' => $order_data,
					'order_additions' => $order_additions
			), $data_arr, $subs, array () );
			if ($info ['s'] == 1) {
				$msg = $adapter->order_submit ( $inter_id, $info ['orderid'], array (
						'room_codes' => $room_codes
				) );
				if ($msg ['s'] == 0) {
					$this->Order_model->handle_order ( $inter_id, $info ['orderid'], 10, $openid ); // pms下单失败，退回
					return $this->rtn_msg ( FALSE, $msg ['errmsg'] );
				} else {
					$this->Order_model->update_order_status ( $inter_id, $info ['orderid'], 1,$openid,TRUE,TRUE );
					// 				$this->Order_model->handle_order ( $inter_id, $info ['orderid'], 'ss' );
					// 				if ($order_data ['status'] == 1) {
					// 					$this->Order_model->handle_order ( $inter_id, $info ['orderid'], $order_data ['status'], $openid );
					// 				}
				}
				$db = $this->load->database('iwide_r1',true);
				$addition=$db->get_where('hotel_order_additions',array(
						'inter_id'=>$inter_id,
						'orderid'=>$info['orderid']
				))->row_array();
				return $this->rtn_msg ( TRUE, '下单成功', array (
						'orderid' => $info ['orderid'],
						'show_orderid' => empty ( $addition ['web_orderid'] ) ? $info ['orderid'] : $addition ['web_orderid']
				) );
			} else {
				return $this->rtn_msg ( FALSE, $info ['errmsg'] );
			}
	}
	private function rtn_msg($s = TRUE, $errmsg = '', $data = array()) {
		$info = array ();
		$info ['s'] = $s == TRUE ? 1 : 0;
		empty ( $errmsg ) or $info ['errmsg'] = $errmsg;
		empty ( $data ) or $info ['data'] = $data;
		return $info;
	}
	private function _room_state_format($state, $hotel_rooms) {
		foreach ( $state as $hotel_id => &$hotel ) {
			foreach ( $hotel ['room_state'] as $room_id => &$sta ) {
				if (! empty ( $hotel_rooms [$hotel_id] [$room_id] )) {
					$sta ['state_info'] = array_intersect_key ( $sta ['state_info'], array_flip ( $hotel_rooms [$hotel_id] [$room_id] ) );
				} else {
					$sta ['state_info'] = array ();
				}
			}
		}
		$data = array (
				's' => 1,
				'errmsg' => '查询成功',
				'data' => $state
		);
		$mode = array (
				'ks' => array (
						's',
						'errmsg'
				),
				'fks' => array (
						'data' => array (
								'ks' => array (
										'hotel_info'
								),
								'fks' => array (
										'room_state' => array (
												'kas' => array (
														'room_info' => array (
																'ks' => array (
																		'room_id',
																		'name',
																		'room_img'
																)
														)
												),
												'fks' => array (
														'state_info' => array (
																'ks' => array (
																		'price_name',
																		'price_type',
																		'price_code',
																		'least_num',
																		'total_price',
																		'avg_price',
																		'book_status'
																),
																'fks' => array (
																		'date_detail' => array (
																				'ks' => array (
																						'price',
																						'nums'
																				)
																		)
																)
														)
												)
										)
								)
						)
				)
		);
		return $this->data_dehydrate ( $data, $mode );
	}
	public function data_dehydrate($data, $mode) {
		if (empty ( $mode ))
			return $data;
			$tmp = array ();
			if (! empty ( $mode ['ks'] )) {
				$mode ['ks'] = array_flip ( $mode ['ks'] );
				$tmp = array_intersect_key ( $data, $mode ['ks'] );
			}
			if (! empty ( $mode ['kas'] )) {
				foreach ( $mode ['kas'] as $mk => $mod ) {
					$tmp [$mk] = isset ( $data [$mk] ) ? $this->data_dehydrate ( $data [$mk], $mod ) : NULL;
				}
			}
			if (! empty ( $mode ['fks'] )) {
				foreach ( $mode ['fks'] as $mk => $mod ) {
					if (isset ( $data [$mk] )) {
						foreach ( $data [$mk] as $fk => $fm ) {
							$tmp [$mk] [$fk] = $this->data_dehydrate ( $fm, $mod );
						}
					} else {
						$tmp [$mk] = NULL;
					}
				}
			}
			return $tmp;
	}
}