<?php
class Price_code_model extends MY_Model {
	function __construct() {
		parent::__construct ();
	}
	const TAB_HPI = 'hotel_price_info';
	const TAB_HPS = 'hotel_price_set';
	const TAB_HOTEL_ROOM = 'hotel_rooms';
	function get_hotel_price_codes($inter_id, $hotel_id, $status = 1) {
		$this->db->select ( 'i.*' );
		$this->db->from ( self::TAB_HPI . ' i' );
		$this->db->join ( self::TAB_HPS . ' s', 'i.inter_id=s.inter_id and i.price_code=s.price_code' );
		$this->db->where ( 's.inter_id', $inter_id );
		$this->db->where ( 'i.status', 1 );
		isset ( $status ) ? $this->db->where_in ( 's.status', explode ( ',', $status ) ) : $this->db->where ( 's.status', 1 );
		$this->db->where ( 's.hotel_id', $hotel_id );
		$this->db->group_by ( 's.price_code' );
		return $this->db->get ()->result_array ();
	}
	function get_price_codes($inter_id, $status = null) {
		$this->db->where ( 'inter_id', $inter_id );
		isset ( $status ) ? $this->db->where_in ( 'status', explode ( ',', $status ) ) : $this->db->where_in ( 'status', array (
				1,
				2 
		) );
		$result = $this->db->get ( self::TAB_HPI )->result_array ();
		$data = array ();
		foreach ( $result as $r ) {
			$data [$r ['price_code']] = $r;
		}
		return $data;
	}
	function create_price_code($inter_id) {
		$this->db->where ( 'inter_id', $inter_id );
		$count = $this->db->get ( self::TAB_HPI )->num_rows ();
		return $count + 1;
	}
	function get_price_code($inter_id, $price_code, $status = null) {
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'price_code' => $price_code 
		) );
		if (! is_null ( $status ))
			$this->db->where ( 'status', $status );
		else
			$this->db->where_in ( 'status', array (
					1,
					2 
			) );
		return $this->db->get ( self::TAB_HPI )->row_array ();
	}
	function get_price_set($inter_id, $hotel_id, $room_id, $price_code = null, $status = null) {
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'hotel_id' => $hotel_id,
				'room_id' => $room_id 
		) );
		is_null ( $status ) ? $this->db->where_in ( 'status', array (
				1,
				2 
		) ) : $this->db->where ( 'status', $status );
		if (! empty ( $price_code )) {
			$this->db->where ( 'price_code', $price_code );
			return $this->db->get ( self::TAB_HPS )->row_array ();
		}
		return $this->db->get ( self::TAB_HPS )->result_array ();
	}
	function get_room_price_code($inter_id, $hotel_id, $room_id, $price_code = null, $status = null) {
		$info_sql = " select * from " . $this->db->dbprefix ( self::TAB_HPI ) . " where inter_id='$inter_id' and status=1 ";
		$set_sql = " select * from " . $this->db->dbprefix ( self::TAB_HPS ) . " where inter_id='$inter_id' and hotel_id=$hotel_id and room_id=$room_id ";
		$set_sql .= is_null ( $status ) ? ' and status in (1,2)' : " and status=$status";
		$sql = "select i.price_name,s.* from ($info_sql) i join ($set_sql) s on i.inter_id=s.inter_id and i.price_code=s.price_code ";
		return $this->db->query ( $sql )->result_array ();
	}
	function get_room_price_set($inter_id, $hotel_id, $room_id = 0, $price_code = null, $check_related = true) {
		$price_info_sql = "SELECT i.*,r.name room_name,r.room_id rid,r.hotel_id hid,s.price_code set_code,s.status set_status,s.must_date smust_date,s.related_cal_way srelated_cal_way,s.related_cal_value srelated_cal_value,s.room_id,s.hotel_id,s.price sprice,s.nums snums,s.use_condition suse_condition";
		$price_info_sql .= $check_related != true ? '' : ' ,ri.price_name related_name ';
		$price_info_sql .= " from (SELECT * from " . $this->db->dbprefix ( self::TAB_HOTEL_ROOM ) . " where status = 1 and hotel_id = $hotel_id and inter_id='$inter_id'";
		if (! empty ( $room_id )) {
			$price_info_sql .= " and room_id = $room_id ";
		}
		$price_info_sql .= ") r join ( select * from " . $this->db->dbprefix ( self::TAB_HPI ) . " where status = 1 and inter_id='$inter_id'";
		if (! empty ( $price_code ))
			$price_info_sql .= ' and price_code =' . $price_code;
		$price_info_sql .= ") i on r.inter_id=i.inter_id";
		$price_info_sql .= " left join ( select * from " . $this->db->dbprefix ( self::TAB_HPS ) . " where inter_id='$inter_id' and hotel_id = $hotel_id ) s 
				 on r.room_id=s.room_id and s.price_code=i.price_code ";
		$price_info_sql .= $check_related != true ? '' : " left join ( select * from " . $this->db->dbprefix ( self::TAB_HPI ) . " where status = 1 and inter_id='$inter_id') ri on ri.price_code=i.related_code ";
		$price_info_sql .= " order by r.room_id,i.price_code asc";
		$data = $this->db->query ( $price_info_sql )->result_array ();
		return $data;
	}
	function edit_code_set($data) {
		$data ['edittime'] = time ();
		return $this->db->replace ( self::TAB_HPS, $data );
	}
	function edit_code_set_part($inter_id, $hotel_id, $room_id, $price_code, $data) {
		$param = array (
				'inter_id' => $inter_id,
				'hotel_id' => $hotel_id,
				'room_id' => $room_id,
				'price_code' => $price_code 
		);
		$this->db->where ( $param );
		$check = $this->db->get ( self::TAB_HPS )->row_array ();
		if ($check) {
			$this->db->where ( $param );
			if($this->db->update ( self::TAB_HPS, $data )){
				return TRUE;
			}
		}else{
			$data['edittime']=time();
			if($this->db->insert(self::TAB_HPS,array_merge($data,$param))){
				return TRUE;
			}
		}
		return FALSE;
	}
	function edit_price_code($condition, $data) {
		$this->db->where ( $condition );
		$data ['edittime'] = time ();
		return $this->db->update ( self::TAB_HPI, $data );
	}
	function add_price_code($data) {
		$data ['edittime'] = time ();
		$data ['price_code'] = $this->create_price_code ( $data ['inter_id'] );
		return $this->db->insert ( self::TAB_HPI, $data );
	}
	/**
	 * 后台管理的表格中要显示哪些字段
	 */
	public function grid_fields() {
		return array (
				'room_name' => array (
						'label' => '房型' 
				),
				'price_name' => array (
						'label' => '价格代码' 
				),
				'sprice' => array (
						'label' => '默认房价',
						'enable' => TRUE 
				),
				'snums' => array (
						'label' => '默认房间数',
						'enable' => TRUE 
				),
				'related_name' => array (
						'label' => '关联价格代码' 
				),
				'code_status' => array (
						'label' => '当前状态' 
				),
				'set_status' => array (
						'label' => '状态修改',
						'select' => array (
								'1' => '可用',
								'2' => '隐藏',
								'3' => '无效' 
						) 
				) 
		);
	}
	public function code_grid_fields() {
		return array (
				'price_name' => array (
						'label' => '价格代码' 
				),
				'des' => array (
						'label' => '描述' 
				),
				'type' => array (
						'label' => '类型' 
				),
				'related_name' => array (
						'label' => '关联价格代码' 
				),
				'sort' => array (
						'label' => '排序' 
				),
				'status' => array (
						'label' => '状态' 
				) 
		);
	}
	public function table_fields($table) {
		switch ($table) {
			case 'price_info' :
				return array (
						'price_code' => '',
						'price_name' => '',
						'type' => 'common',
						'related_code' => '',
						'des' => '',
						'related_cal_way' => '',
						'related_cal_value' => '',
						'use_condition' => '',
						'sort' => '',
						'unlock_code' => '',
						'must_date' => 3,
						'status' => 1 
				);
				break;
			default :
				return array ();
				break;
		}
	}



}