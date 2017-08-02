<?php
class Hotel_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	const TAB_H = 'hotels';
	const TAB_O = 'hotel_orders';
	const TAB_HOI = 'hotel_order_items';
	const TAB_HI = 'hotel_images';
	const TAB_HR = 'hotel_rooms';
	const TAB_HRN = 'hotel_room_numbers';
	const TAB_HLP = 'hotel_lowest_price';
	const TAB_HFM = 'hotel_front_marks';
	const TAB_HC = 'hotel_config';
	const TAB_HCT = 'hotel_comments';
	const TAB_FANS = 'fans';
	const TAB_HPS = 'hotel_price_set';
	function get_imgs($type, $inter_id, $hotel_id = '', $room_id = 0, $sway = 'eq') {
		$imgs = array ();
		switch ($type) {
			case 'pub' :
				$this->load->model ( 'wx/Publics_model' );
				$imgs = $this->Publics_model->get_pub_imgs ( $inter_id, 'hotelslide' );
				break;
			default :
				$db_read = $this->load->database('iwide_r1',true);
				$db_read->order_by ( 'sort desc' );
				$db_read->where ( 'status', 1 );
				$db_read->where ( 'inter_id', $inter_id );
				if (is_array ( $type )) {
					$db_read->where_in ( 'type', $type );
				} else {
					if ($sway == 'eq')
						$db_read->where ( 'type', $type );
					else if ($sway == 'like')
						$db_read->like ( 'type', $type );
				}
				$db_read->where ( 'hotel_id', $hotel_id );
				$db_read->where ( 'room_id', $room_id );
				$imgs = $db_read->get ( self::TAB_HI )->result_array ();
				break;
		}
		return $imgs;
	}
	function get_hotel_citys($inter_id) {
		$this->load->model ( 'hotel/Hotel_check_model' );
		$adapter = $this->Hotel_check_model->get_hotel_adapter ( $inter_id, 0 );
		$data = $adapter->get_hotel_citys ( $inter_id, array () );
        $area = $this->Hotel_check_model->get_hotel_area ( $inter_id, array () );
		$city_sort = array ();
		$this->load->model ( 'hotel/Hotel_config_model' );
		$config_data = $this->Hotel_config_model->get_hotel_config ( $inter_id, 'HOTEL', 0, array (
				'HOT_CITY_SEARCH',
				'FIRST_CITY_SEARCH',
				'HOT_CITY_NUM_SEARCH' 
		) );
		if (empty ( $config_data ['FIRST_CITY_SEARCH'] ) || empty ( $config_data ['HOT_CITY_SEARCH'] )) {
			foreach ( $data as $c ) {
				foreach ( $c as $s ) {
					$city_sort [] = $s;
				}
			}
			uasort ( $city_sort, function ($a, $b) {
				return $b ['hotel_num'] > $a ['hotel_num'] ? 1 : - 1;
			} );
		}
		$hot_num = 3;
		if (! empty ( $config_data ['HOT_CITY_NUM_SEARCH'] )) {
			$hot_num = $config_data ['HOT_CITY_NUM_SEARCH'];
		}
		
		if (! empty ( $config_data ['FIRST_CITY_SEARCH'] )) {
			$first_city = $config_data ['FIRST_CITY_SEARCH'];
		} else {
			$first_city = current ( $city_sort );
			$first_city = $first_city ['city'];
		}
		if (! empty ( $config_data ['HOT_CITY_SEARCH'] )) {
			$hot_city = json_decode ( $config_data ['HOT_CITY_SEARCH'], TRUE );
			$hot_city = array_slice ( $hot_city, 0, $hot_num );
		} else {
			$hot_city = array_slice ( $city_sort, 0, $hot_num );
			foreach ( $hot_city as $hk => $hc ) {
				$hot_city [$hk] = $hc ['city'];
			}
		}
		
		return array (
				'citys' => $data,
				'hot_city' => $hot_city,
				'first_city' => $first_city ,
                'area' => $area
		);
	}
	function search_hotel_front($inter_id, $paras) {
		$this->load->model ( 'hotel/Hotel_check_model' );
		$adapter = $this->Hotel_check_model->get_hotel_adapter ( $inter_id, 0 );
		return $adapter->search_hotel_front ( $inter_id, $paras );
	}
	function get_all_hotels($inter_id, $status = null, $key = '',$condit=null) {
		$db_read = $this->load->database('iwide_r1',true);
		if (! is_null ( $status ))
			$db_read->where ( 'status', $status );
		$db_read->where ( 'inter_id', $inter_id );
		$db_read->where_in ( 'status', array (
				1,
				2 
		) );
		if(!empty($condit['keyword'])){
			$db_read->like ( 'name', $condit['keyword'] );
		}
		if(!empty($condit['is_count'])){
			$db_read->from( self::TAB_H );
			return $db_read->count_all_results	 ();
		}
		if( isset($condit['offset']) && isset($condit['size']) ){
			$db_read->limit ( $condit['size'], $condit['offset'] );
		}

		$result = $db_read->get ( self::TAB_H )->result_array ();
		if ($key == 'key') {
			$hotels = array ();
			foreach ( $result as $r ) {
				$hotels [$r ['hotel_id']] = $r;
			}
			return $hotels;
		}
		return $result;
	}
	function get_hotel_detail($inter_id, $hotel_id, $detail_type = array(), $status = 1) {
		$db_read = $this->load->database('iwide_r1',true);
		if (! empty ( $detail_type ['not_del'] )) {
			$db_read->where_in('status',array(1,2));
		}
		$hotel = $db_read->get_where ( self::TAB_H, array (
				'hotel_id' => $hotel_id,
				'inter_id' => $inter_id,
				'status' => $status 
		) )->row_array ();
		if (! empty ( $detail_type ['img_type'] )) {
			$imgs = $this->get_imgs ( $detail_type ['img_type'], $inter_id, $hotel_id );
			foreach ( $imgs as $i ) {
				$hotel ['imgs'] [$i ['type']] [] = $i;
			}
		}
		if (!empty($detail_type['icon_type'])){
			$this->load->model ( 'hotel/Image_model' );
			$icons = $this->Image_model->get_hotels_icon ( $inter_id, array($hotel_id), $detail_type['icon_type'] );
			$hotel['icons']=isset($icons[$hotel_id])?$icons[$hotel_id]:array();
		}

		if (isset($detail_type['extra_info'] ) && $detail_type['extra_info'] == 1){
			$this->load->model('hotel/Hotel_check_model');
			$adapter=$this->Hotel_check_model->get_hotel_adapter($inter_id,$hotel_id);
			$hotel['extra_info']=$adapter->get_hotel_extra_info();

		}
		return $hotel;
	}
	
	
	function get_hotel_by_ids($inter_id, $ids, $status = null, $key = '',$return_type='array',$condit=null) {
		$db_read = $this->load->database('iwide_r1',true);
		if (! is_null ( $status ))
			$db_read->where ( 'status', $status );
		$db_read->where ( 'inter_id', $inter_id );
		$db_read->where_in ( 'hotel_id', explode ( ',', $ids ) );
		$db_read->where_in ( 'status', array (
				1,
				2 
		) );
		if(!empty($condit['keyword'])){
			$db_read->like ( 'name', $condit['keyword'] );
		}
		if(!empty($condit['is_count'])){
			$db_read->from( self::TAB_H );
			return $db_read->count_all_results	 ();
		}
		if( isset($condit['offset']) && isset($condit['size']) ){
			$db_read->limit ( $condit['size'], $condit['offset'] );
		}
		if ($return_type=='array')
			$result = $db_read->get ( self::TAB_H )->result_array ();
		else 
			$result = $db_read->get ( self::TAB_H )->result ();
		if ($key == 'key') {
			$hotels = array ();
			if ($return_type=='array'){
				foreach ( $result as $r ) {
					$hotels [$r ['hotel_id']] = $r;
				}
			}else{
				foreach ( $result as $r ) {
					$hotels [$r->hotel_id] = $r;
				}
			}
			return $hotels;
		}
		return $result;
	}
	function get_hotel_rooms($inter_id, $hotel_id, $status = null, $nums = null, $offset = null, $rtype = 'room') {
		$db_read = $this->load->database('iwide_r1',true);
		$db_read->order_by ( 'sort desc' );
		if (! is_null ( $nums ))
			$db_read->limit ( $nums, $offset );
		// add yu 2016-11-15 增加参数，筛选房型类型 room 订房类，ticket 门票类
		if(!empty($rtype)){
			$db_read->where ( array (
					'type' => $rtype,
			) );
		}
		$db_read->where ( array (
				'hotel_id' => $hotel_id,
				'inter_id' => $inter_id,
		) );
		if (! is_null ( $status ))
			$db_read->where ( 'status', $status );
		return $db_read->get ( self::TAB_HR )->result_array ();
	}
	//获取有设置房型的酒店ids
	function get_room_hotels($inter_id, $status = null) {
        $db_read = $this->load->database('iwide_r1',true);
		$db_read->select ( 'hotel_id' );
		$db_read->where ( array (
				'inter_id' => $inter_id
		) );
		if (! is_null ( $status ))
			$db_read->where ( 'status', $status );
		$db_read->group_by ( 'hotel_id' );
		return $db_read->get ( self::TAB_HR )->result_array ();
	}

	//获取有设置对应价格代码的酒店ids
	function get_pcode_hotels($inter_id, $hotel_ids ,$pcode , $status = null) {
        $db_read = $this->load->database('iwide_r1',true);
		$db_read->select ( 'hotel_id' );
		$db_read->where ( array (
				'inter_id' => $inter_id,
				'price_code' => $pcode
		) );
		if(!empty($hotel_ids)){
			$db_read->where_in ( 'hotel_id', explode(',',$hotel_ids) );
		}
		if (! is_null ( $status )){
			if(is_array($status))
				$db_read->where_in ( 'status', $status );
			else
				$db_read->where ( 'status', $status );
		} else
			$db_read->where_in ( 'status', array(0,1,2) );

		$db_read->group_by ( 'hotel_id' );
		return $db_read->get ( self::TAB_HPS )->result_array ();
	}
	function get_room_detail($inter_id, $hotel_id, $room, $detail_type = array(), $status = 1) {
		$db_read = $this->load->database('iwide_r1',true);
		if (! is_array ( $room )) {
			$room = $db_read->get_where ( self::TAB_HR, array (
					'inter_id' => $inter_id,
					'hotel_id' => $hotel_id,
					'room_id' => $room,
					'status' => $status 
			) )->row_array ();
		}
		if (isset ( $detail_type ['img_type'] )) {
			$imgs = $this->get_imgs ( $detail_type ['img_type'], $inter_id, $hotel_id, $room ['room_id'] );
			foreach ( $imgs as $i ) {
				$room ['imgs'] [$i ['type']] [] = $i;
			}
		}
		if (isset ( $detail_type ['number_detail'] )) {
			$no = $this->get_room_no ( $inter_id, $hotel_id, $room ['room_id'], $detail_type ['number_detail'] );
			$room ['number_detail'] = $no;
		}
		if (isset ( $detail_type ['number_realtime'] )) {
			$real_no = $this->get_room_realtime ( $inter_id, $hotel_id, $room ['room_id'], $detail_type ['number_realtime'] );
			$room ['number_realtime'] = $real_no;
		}
		return $room;
	}
	function get_rooms_detail($inter_id, $hotel_id, $rooms = array(), $detail_type) {
		$data = array ();
		if (! empty ( $detail_type ['data'] ) && $detail_type ['data'] == 'value') {
			foreach ( $rooms as $ri ) {
				$data [$ri ['room_id']] = $this->get_room_detail ( $inter_id, $hotel_id, $ri, $detail_type );
			}
		} else {
			foreach ( $rooms as $ri ) {
				$data [$ri] = $this->get_room_detail ( $inter_id, $hotel_id, $ri, $detail_type );
			}
		}
		return $data;
	}
	function get_room_realtime($inter_id, $hotel_id, $room_id, $date, $params = array()) {
		$data = array ();
		if ($inter_id == 'a441624001') {
			$this->load->model ( 'hotel/pms/Zhuzhe_hotel_model' );
			$data = $this->Zhuzhe_hotel_model->get_room_realtime ( $inter_id, $hotel_id, $room_id, $date, $params = array () );
		} else {
			$db_read = $this->load->database('iwide_r1',true);
			$sql = 'select * from ' . $db_read->dbprefix ( self::TAB_HRN ) . " where status=1 and inter_id='$inter_id' and hotel_id=$hotel_id and room_id='$room_id' and num_id not in 
			(SELECT room_no_id FROM `" . $db_read->dbprefix ( self::TAB_HOI ) . "` where istatus in (1,2) and room_no !='' and (startdate >=" . $date ['s'] . " or enddate<" . $date ['e'] . "))";
			$result = $db_read->query ( $sql )->result_array ();
			foreach ( $result as $r ) {
				$data [$r ['num_id']] = $r;
			}
		}
		return $data;
	}
	function get_room_no($inter_id, $hotel_id, $room_id, $status = 1) {
		$db_read = $this->load->database('iwide_r1',true);
		if (! empty ( $status ))
			$db_read->where ( 'status', $status );
		$db_read->where ( array (
				'hotel_id' => $hotel_id,
				'inter_id' => $inter_id,
				'room_id' => $room_id 
		) );
		$result = $db_read->get ( self::TAB_HRN )->result_array ();
		$data = array ();
		foreach ( $result as $r ) {
			$data [$r ['num_id']] = $r;
		}
		return $data;
	}
	function return_mark_condi($mt) {
		switch ($mt) {
			case 1 :
				return array (
						'type' => 'hotel_collection',
						'sort' => 'mark_nums desc' 
				);
				break;
			case 2 :
				return array (
						'type' => 'hotel_visited',
						'sort' => 'mark_time desc' 
				);
				break;
			default :
				return false;
				break;
		}
	}
	function add_front_mark($arr) {
		$arr ['mark_time'] = time ();
		$this->db->insert ( self::TAB_HFM, $arr );
		return $this->db->insert_id ();
	}
	function get_front_marks($idents, $sort = 'mark_time desc', $nums = null, $offset = null) {

        $this->load->model('member/imember');
        return $this->imember->get_user_front_marks($idents, $sort , $nums, $offset);

//原来的逻辑
//		$this->db->select ( '*,count(mark_name) mark_nums' );
//		$this->db->order_by ( $sort );
//		if (! is_null ( $nums ))
//			$this->db->limit ( $nums, $offset );
//		$this->db->group_by ( 'mark_name' );
//		$this->db->where ( $idents );
//		return $this->db->get ( self::TAB_HFM )->result_array ();

	}
    function get_front_marks_local($idents, $sort = 'mark_time desc', $nums = null, $offset = null){
    	$db_read = $this->load->database('iwide_r1',true);
        $db_read->select ( '*,count(mark_name) mark_nums' );
		$db_read->order_by ( $sort );
		if (! is_null ( $nums ))
			$db_read->limit ( $nums, $offset );
		$db_read->group_by ( 'mark_name' );
		$db_read->where ( $idents );
		return $db_read->get ( self::TAB_HFM )->result_array ();
    }

	function get_type_mark($idents, $status = 1) {
        $this->load->model('member/imember');
        return $this->imember->get_type_mark($idents, $status,0);
//		$this->db->where ( 'status', $status );
//		$this->db->where ( $idents );
//		return $this->db->get ( self::TAB_HFM )->row_array ();
	}

    function get_type_mark_local($idents, $status = 1) {
    	$db_read = $this->load->database('iwide_r1',true);
    	$db_read->where ( 'status', $status );
    	$db_read->where ( $idents );
        return $db_read->get ( self::TAB_HFM )->row_array ();
    }

	function update_mark_status($inter_id, $openid, $status, $mid, $field = 'id') {
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'openid' => $openid 
		) );
		$this->db->where ( $field, $mid );
		return $this->db->update ( self::TAB_HFM, array (
				'status' => $status 
		) );
	}
	function get_a_hotel_id($inter_id, $h_get = '', $neccessary = true) {
		$h = intval ( $h_get );
		$db_read = $this->load->database('iwide_r1',true);
		if ($neccessary) {
			$h_s = $this->session->userdata ( $inter_id . '_room_hotel_id' );
			if (! $h && ! empty ( $h_s )) {
				$h = intval ( $this->session->userdata ( $inter_id . '_room_hotel_id' ) );
			}
			if ($h) {
				$hotel = $this->get_hotel_detail ( $inter_id, $h );
				if (empty ( $hotel )) {
					$db_read->limit ( 1 );
					$hotel = $db_read->get_where ( self::TAB_H, array (
							'inter_id' => $inter_id,
							'status' => 1 
					) )->row_array ();
				}
				$h = empty ( $hotel ) ? 0 : $hotel ['hotel_id'];
			} else {
				$db_read->limit ( 1 );
				$hotel = $db_read->get_where ( self::TAB_H, array (
						'inter_id' => $inter_id,
						'status' => 1
				) )->row_array ();
				$h = empty ( $hotel ) ? 0 : $hotel ['hotel_id'];
			}
		}
		empty ( $h ) ?  : $this->session->set_userdata ( array (
				$inter_id . '_room_hotel_id' => $h 
		) );
		;
		return $h;
	}
	function sort_dyd_array($arr, $sort_field, $sort_type = 'gt', $num = null, $offset = 0) {
		$count = count ( $arr );
		for($i = 0; $i < $count; $i ++) {
			for($j = $i + 1; $j < $count; $j ++) {
				if ($sort_type == 'gt') {
					if ($arr [$i] [$sort_field] > $arr [$j] [$sort_field]) {
						$tmp = $arr [$j];
						$arr [$j] = $arr [$i];
						$arr [$i] = $tmp;
					}
				} else if ($sort_type == 'lt') {
					if ($arr [$i] [$sort_field] < $arr [$j] [$sort_field]) {
						$tmp = $arr [$j];
						$arr [$j] = $arr [$i];
						$arr [$i] = $tmp;
					}
				}
			}
		}
		$arr = array_slice ( $arr, $offset, $num );
		return $arr;
	}
	public function get_hotel_hash($params = array(), $select = array(), $format = 'array', $table = NULL) {
		return $this->get_data_hash ( $params, $select, $format, self::TAB_H );
	}
	public function get_hotel_room_hash($params = array(), $select = array(), $format = 'array', $table = NULL) {
		return $this->get_data_hash ( $params, $select, $format, self::TAB_HR );
	}
	public function get_hotel_order_hash($params = array(), $select = array(), $format = 'array', $table = NULL) {
		return $this->get_data_hash ( $params, $select, $format, self::TAB_O );
	}
	/**
	 *
	 * @author libinyan
	 */
	public function get_data_hash($params = array(), $select = array(), $format = 'array', $table = NULL) {
		$select = count ( $select ) == 0 ? '*' : implode ( ',', $select );
		$db_read = $this->load->database("iwide_r1", TRUE);
		$db_read->select ( " {$select} " );
		
		$where = array ();
		$dbfields = array_values ( $fields = $db_read->list_fields ( $table ) );
		foreach ( $params as $k => $v ) {
			$key = explode(' ', $k);
			// 过滤非数据库字段，以免产生sql报错
			if (in_array ( $key[0], $dbfields ) && is_array ( $v )) {
				$db_read->where_in ( $key[0], $v );
			} else if (in_array ( $key[0], $dbfields )) {
				$db_read->where ( $k, $v );
			}
		}
		$result = $db_read->get ( $table );
		if ($format == 'object')
			return $result->result ();
		else
			return $result->result_array ();
	}
	/**
	 *
	 * @author libinyan
	 */
	public function array_to_hash($array, $label_key, $value_key = NULL) {
		$data = array ();
		foreach ( $array as $k => $v ) {
			// 过滤额外增加的数据 如 key=0的不完整数据
			if (isset ( $v [$label_key] )) {
				if ($value_key == NULL) {
					$key = $k;
				} else {
					$key = $v [$value_key];
				}
				$data [$key] = $v [$label_key];
			}
		}
		return $data;
	}
	/**
	 *
	 * @author libinyan
	 */
	public function hash_to_option($array) {
		// [{value:'',text:'All'},{value:'P',text:'P'},{value:'N',text:'N'}],
		$data = array ();
		foreach ( $array as $k => $v ) {
			$data [] = array (
					'value' => $k,
					'text' => $v 
			);
		}
		return $data;
	}
	/**
	 *
	 * @author libinyan
	 */
	public function hash_to_optionhtml($array, $selected = NULL) {
		$html = '';
		foreach ( $array as $k => $v ) {
			if ($selected !== NULL && $selected == $k)
				$html .= "<option value='{$k}' selected='selected'>{$v}</option>";
			else
				$html .= "<option value='{$k}'>{$v}</option>";
		}
		return $html;
	}
	
	/**
	 * 取酒店附加信息，包括wifi,设施
	 */
	public function return_room_detail($inter_id,$hotel_id,$room_id){
		
		//$this->load->model ( 'hotel/Hotel_model' );
		
		$this->load->model('hotel/Hotel_check_model');
		
		$adapter=$this->Hotel_check_model->get_hotel_adapter($inter_id,$hotel_id);
		//$hotel['extra_info']=$adapter->get_hotel_extra_info();
		
		$adapter->return_room_detail($inter_id,$hotel_id,$room_id);
		
		
		
	}
	
	public function return_room_detail_local($inter_id,$hotel_id,$room_id){
		
		//$this->load->model ( 'hotel/Hotel_model' );
	
		$detail = $this->get_room_detail ( $inter_id, $hotel_id, $room_id, array (
				'img_type' => array (
						'hotel_room_service',
						'hotel_room_lightbox'
				)
		), 1 );
		$room = array ();
		$room ['name'] = $detail ['name'];
		$room ['room_img'] = $detail ['room_img'];
		$room ['imgs'] = empty ( $detail ['imgs'] ) ? array () : $detail ['imgs'];
		$detail ['book_policy'] = $detail ['book_policy'];
		if (empty ( $detail ['book_policy'] )) {
			$hotel = $this->get_hotel_detail ( $inter_id, $hotel_id );
			$detail ['book_policy'] = $hotel ['book_policy'];
		}
		$room ['book_policy'] = nl2br ( $detail ['book_policy'] );
		echo json_encode ( $room );
		
	}

	function get_hotels_by_params($inter_id, $paras) {
		$db_read = $this->load->database('iwide_r1',true);
		$s = 'select * from ' . $db_read->dbprefix ( self::TAB_H );
		$s .= ' where inter_id = "' . $inter_id . '" and status=1 ';
		if(!empty($paras['hotel_id'])){
			$s.=" and hotel_id = ".(int)$paras['hotel_id'];
		}
		if (isset ( $paras ['city'] ) || isset ( $paras ['keyword'] )) {
			if (isset ( $paras ['city'] )) {
				$s .= ' and (city like "%' . $paras ['city'] . '%" or CONCAT(city,"市") like "%' . $paras ['city'] . '%")';
			}
			if (isset ( $paras ['keyword'] )) {
				$s .= 'and ( name like "%' . $paras ['keyword'] . '%" or address like "%' . $paras ['keyword'] . '%" or tel like "%' . $paras ['keyword'] . '%" )';
			}
		}
		$s .= " order by sort desc ";
		if (! empty ( $paras ['nums'] ) && empty ( $paras ['check_distance'] ) && empty ( $paras ['sort_type'] )) {
			$s .= ' limit ' . $paras ['offset'] . ',' . $paras ['nums'];
		}
		$hotels = $db_read->query ( $s )->result_array ();
		return $hotels;
	}

	public function get_hotel_predate_set($inter_id, $hotel_id = null){
		$db_read = $this->load->database('iwide_r1',true);
		$db_read->where(['inter_id'   => $inter_id,
		                  'param_name' => 'BOOK_DATE_VALIDATE',
		                  'module'     => 'HOTEL'
		                 ])->from('hotel_config');
		if($hotel_id){
			if(is_array($hotel_id)){
				$db_read->where_in('hotel_id', $hotel_id);
			} else{
				$db_read->where(['hotel_id', (int)$hotel_id]);
			}
		}
		$result = $db_read->get()->result_array();

		$list = [];
		foreach($result as $v){
			//解析JSON
			$pre_set = json_decode($v['param_value'], true);
			unset($v['param_value']);
			//判断是否有值
			if(!empty($pre_set)){
				//合并
				$v = array_merge($v,array_shift($pre_set['startdate']));
			}else{
				$v=[];
			}
			$list[$v['hotel_id']] = $v;
		}

		return $list;
	}


    function hot_city_post($data,$inter_id,$param_name="HOT_CITY_SEARCH"){   //保存热门城市

       $config_data = $this->check_config($inter_id,$param_name);

        if($config_data){

            $data=array(
                'param_value'=>$data['param_value']
            );

            $this->db->where ( 'id', $config_data['id'] );
            $res = $this->db->update ( self::TAB_HC, $data);

        }else{

           $res =  $this->db->insert ( self::TAB_HC, $data );

        }

         return $res;

    }


    function check_config($inter_id,$param_name){
    	$db_read = $this->load->database('iwide_r1',true);
    	$db_read->where ( 'inter_id', $inter_id );
    	$db_read->where ( 'param_name', $param_name );

        return $db_read->get ( self::TAB_HC )->row_array ();


    }

    function get_hotel_citys_by_hid($inter_id,$paras) {
		$s = 'select city,count(*) as citynums from ' . $this->db->dbprefix ( self::TAB_H );
		$s .= ' where inter_id = "' . $inter_id . '" and status=1 and city !="" and city is not null ';
		if(!empty($paras['hotel_id'])){
			$s.=" and hotel_id in (".$paras['hotel_id'].") ";
		}

		$s .= " GROUP BY city order by citynums desc ";
		$hotels = $this->db->query ( $s )->result_array ();
		return $hotels;
	}


    function bigger_payways_icon(){

        return array(
            'balance'=>'&#xe018',
            'daofu'=>'&#xe020',
            'weixin'=>'&#xe008',
            'point'=>'&#xe039',
            'lakala'=>'&#xe040',
            'unionpay'=>'&#xe041',
            'weifutong'=>'&#xe042'
        );

    }

}