<?php
class Price_code_model extends MY_Model {
	function __construct() {
		parent::__construct ();
	}
	const TAB_HPI = 'hotel_price_info';
	const TAB_HPS = 'hotel_price_set';
	const TAB_HOTEL_ROOM = 'hotel_rooms'; 
	function get_hotel_price_codes($inter_id, $hotel_id = null, $status = 1) {
		$db_read = $this->load->database('iwide_r1',true);
		$db_read->select ( 'i.*' );
		$db_read->from ( self::TAB_HPI . ' i' );
		$db_read->join ( self::TAB_HPS . ' s', 'i.inter_id=s.inter_id and i.price_code=s.price_code' );
		$db_read->where ( 's.inter_id', $inter_id );
		$db_read->where ( 'i.status', 1 );
		isset ( $status ) ? $db_read->where_in ( 's.status', explode ( ',', $status ) ) : $db_read->where ( 's.status', 1 );
		if(!is_null($hotel_id)){
			$db_read->where ( 's.hotel_id', $hotel_id );
		}
		$db_read->group_by ( 's.price_code' );
		return $db_read->get ()->result_array ();
	}
	function get_price_codes($inter_id, $status = null,$select='*') {
		$db_read = $this->load->database('iwide_r1',true);
		$db_read->select ( $select );
		$db_read->where ( 'inter_id', $inter_id );
		isset ( $status ) ? $db_read->where_in ( 'status', explode ( ',', $status ) ) : $db_read->where_in ( 'status', array (
				1,
				2 
		) );
		$result = $db_read->get ( self::TAB_HPI )->result_array ();
		$data = array ();
		foreach ( $result as $r ) {
			$data [$r ['price_code']] = $r;
		}
		return $data;
	}
	function create_price_code($inter_id) {
		$db_read = $this->load->database('iwide_r1',true);
		$db_read->where ( 'inter_id', $inter_id );
		$count = $db_read->get ( self::TAB_HPI )->num_rows ();
		return $count + 1;
	}
	function get_price_code($inter_id, $price_code, $status = null) {
		$db_read = $this->load->database('iwide_r1',true);
		$db_read->where ( array (
				'inter_id' => $inter_id,
				'price_code' => $price_code 
		) );
		if (! is_null ( $status ))
			$db_read->where ( 'status', $status );
		else
			$db_read->where_in ( 'status', array (
					1,
					2 
			) );
		return $db_read->get ( self::TAB_HPI )->row_array ();
	}
	function get_price_set($inter_id, $hotel_id, $room_id, $price_code = null, $status = null) {
		$db_read = $this->load->database('iwide_r1',true);
		$db_read->where ( array (
				'inter_id' => $inter_id,
				'hotel_id' => $hotel_id,
				'room_id' => $room_id 
		) );
		is_null ( $status ) ? $db_read->where_in ( 'status', array (
				1,
				2 
		) ) : $db_read->where ( 'status', $status );
		if (! empty ( $price_code )) {
			$db_read->where ( 'price_code', $price_code );
			return $db_read->get ( self::TAB_HPS )->row_array ();
		}
		return $db_read->get ( self::TAB_HPS )->result_array ();
	}
	function get_room_price_code($inter_id, $hotel_id, $room_id, $price_code = null, $status = null) {
		$db_read = $this->load->database('iwide_r1',true);
		$info_sql = " select * from " . $db_read->dbprefix ( self::TAB_HPI ) . " where inter_id='$inter_id' and status=1 ";
		$set_sql = " select * from " . $db_read->dbprefix ( self::TAB_HPS ) . " where inter_id='$inter_id' and hotel_id=$hotel_id and room_id=$room_id ";
		$set_sql .= is_null ( $status ) ? ' and status in (1,2)' : " and status=$status";
		$sql = "select i.price_name,s.* from ($info_sql) i join ($set_sql) s on i.inter_id=s.inter_id and i.price_code=s.price_code ";
		if (! empty ( $price_code ))
			$sql .= ' where s.price_code ="' . $price_code.'"';
		return $db_read->query ( $sql )->result_array ();
	}
	function get_room_price_set($inter_id, $hotel_id, $room_id = 0, $price_code = null, $check_related = true,$type = null) {
		$db_read = $this->load->database('iwide_r1',true);
		$price_info_sql = "SELECT i.*,r.name room_name,r.room_id rid,r.hotel_id hid,s.price_code set_code,s.status set_status,s.must_date smust_date,s.related_cal_way srelated_cal_way,s.related_cal_value srelated_cal_value,s.room_id,s.hotel_id,s.price sprice,s.nums snums,s.use_condition suse_condition,s.coupon_condition scoupon_condition,s.bonus_condition sbonus_condition,s.bookpolicy_condition sbookpolicy_condition";
		$price_info_sql .= $check_related != true ? '' : ' ,ri.price_name related_name ';
		$price_info_sql .= " from (SELECT * from " . $db_read->dbprefix ( self::TAB_HOTEL_ROOM ) . " where status = 1 and hotel_id = $hotel_id and inter_id='$inter_id'";
		if (! empty ( $room_id )) {
			$price_info_sql .= " and room_id = $room_id ";
		}
		$price_info_sql .= ") r join ( select * from " . $db_read->dbprefix ( self::TAB_HPI ) . " where status = 1 and inter_id='$inter_id'";
		$price_info_sql .= !empty($price_code)?'':(empty($type)?" ":" and type='$type'");// 增加价格代码类型筛选
		if (! empty ( $price_code ))
			$price_info_sql .= ' and price_code ="' . $price_code.'"';
		$price_info_sql .= ") i on r.inter_id=i.inter_id";
		$price_info_sql .= " left join ( select * from " . $db_read->dbprefix ( self::TAB_HPS ) . " where inter_id='$inter_id' and hotel_id = $hotel_id and status!=4 ) s 
				 on r.room_id=s.room_id and s.price_code=i.price_code ";
		$price_info_sql .= $check_related != true ? '' : " left join ( select * from " . $db_read->dbprefix ( self::TAB_HPI ) . " where status = 1 and inter_id='$inter_id') ri on ri.price_code=i.related_code ";
		$price_info_sql .= " order by r.room_id,i.price_code asc";
		$data = $db_read->query ( $price_info_sql )->result_array ();
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
		$db_read = $this->load->database('iwide_r1',true);
		$db_read->where ( $param );
		$check = $db_read->get ( self::TAB_HPS )->row_array ();
		if ($check) {
			if(isset($data['breakfast_nums'])){
				$bp_condition = json_decode($check['bookpolicy_condition'],true);
				$bp_condition['breakfast_nums'] = $data['breakfast_nums'];
				unset($data['breakfast_nums']);
				$data['bookpolicy_condition'] = json_encode($bp_condition);
			}
			$this->db->where ( $param );
			if($this->db->update ( self::TAB_HPS, $data )){
				return TRUE;
			}
		}else{
			if(isset($data['breakfast_nums'])){
				$data['bookpolicy_condition'] = json_encode(array(
					'breakfast_nums' => $data['breakfast_nums'],
					'retain_time' => '',
					'delay_time' => '',
					));
				unset($data['breakfast_nums']);
			}
			$data['edittime']=time();
			if($this->db->insert(self::TAB_HPS,array_merge($data,$param))){
				return TRUE;
			}
		}
		return FALSE;
	}
	function edit_price_code($condition, $data , $check=array() ,$h_room_ids ,$limit_hotelids) {
		$this->db->trans_begin ();
		$this->db->where ( $condition );
		$data ['edittime'] = time ();
		if(!$this->db->update ( self::TAB_HPI, $data )){
			$this->db->trans_rollback ();
			return false;
		}
		//更新price_set
		if(!empty($h_room_ids)){
			//查询现有的
			$this->db->select ( 'hotel_id,room_id,status' );
			$this->db->where ( $condition );
			if(!empty($limit_hotelids) && is_array($limit_hotelids)){
				$this->db->where_in ( 'hotel_id' , $limit_hotelids );
			}
			$olds = $this->db->get ( self::TAB_HPS )->result_array ();

			$old_h_room_ids = array();
			foreach ($olds as $old) {
				$old_h_room_ids[$old['hotel_id'].'-'.$old['room_id']] = $old['status'];
			}

			$add = array();//要增加房型
			$del = array();//要删除房型
			$upd = array();//要更新房型

			foreach ($h_room_ids as $hid => $rids) {
				foreach ($rids as $rid) {
					if(isset($old_h_room_ids[$hid.'-'.$rid])){
						if($old_h_room_ids[$hid.'-'.$rid] == 4){//更新的
							$upd[] = $rid;
						}
						unset($old_h_room_ids[$hid.'-'.$rid]);
					}else{//增加的
						$add[$hid][] = $rid;
					}
				}
			}
			foreach ($old_h_room_ids as $key => $value) {//删除的
				$del[] = explode('-', $key)[1];
			}
			if(!empty($add) && !$this->add_price_set($condition['inter_id'],$condition['price_code'],$add) ){//增加
				$this->db->trans_rollback ();
				return false;
			}

			if(!empty($upd)){//更新
				$this->db->where ( $condition );
				$this->db->where_in ( 'room_id' , $upd );
				if( !$this->db->update ( self::TAB_HPS, array('status'=>0) )){
					$this->db->trans_rollback ();
					return false;
				}
			}

			if(!empty($del)){//删除
				$this->db->where ( $condition );
				$this->db->where_in ( 'room_id' , $del );
				if( !$this->db->update ( self::TAB_HPS, array('status'=>4) )){
					$this->db->trans_rollback ();
					return false;
				}
			}
			
		}

		if ($this->db->trans_status () === FALSE) {
			$this->db->trans_rollback ();
			return false;
		}
		$this->db->trans_commit ();
		$this->load->model('hotel/Hotel_log_model');
		if ($check){
			$update_diff=array();
			foreach ($check as $k=>$c){
				if (isset($data[$k])&&$check[$k]!=$data[$k]){
					$update_diff[$k]=array('old'=>$c,'new'=>$data[$k]);
				}
			}
		}else {
			$update_diff=$data;
		}
		unset($update_diff ['edittime']);
		$this->Hotel_log_model->add_admin_log(self::TAB_HPI.'#'.$condition['inter_id'].'_'.$condition['price_code'],'save',$update_diff);
		return true;
	}
	function add_price_code($data,$h_room_ids) {
		$data ['edittime'] = time ();
		$data ['price_code'] = $this->create_price_code ( $data ['inter_id'] );
		$this->db->trans_begin ();
		if(!$this->db->insert ( self::TAB_HPI, $data )){
			$this->db->trans_rollback ();
			return false;
		}
		//插入price_set
		if(!empty($h_room_ids) && !$this->add_price_set($data ['inter_id'],$data ['price_code'],$h_room_ids) ){
			$this->db->trans_rollback ();
			return false;
		}
		if ($this->db->trans_status () === FALSE) {
			$this->db->trans_rollback ();
			return false;
		}
		$this->db->trans_commit ();
		$this->load->model('hotel/Hotel_log_model');
		$inter_id = $data ['inter_id'];
		unset($data ['inter_id']);
		unset($data ['edittime']);
		$this->Hotel_log_model->add_admin_log(self::TAB_HPI.'#'.$inter_id.'_'.$data ['price_code'],'add',$data);

		return true;
	}
	
	function add_price_set($inter_id,$pcode,$h_room_ids){
		$datas = array();
		$time = time();
		foreach ($h_room_ids as $hotel_id => $room_ids) {
			foreach ($room_ids as $room_id) {
				$datas[] = array(
						'inter_id'=>$inter_id,
						'hotel_id'=>$hotel_id,
						'room_id'=>$room_id,
						'price_code'=>$pcode,
						'edittime'=>$time,
						'status'=>0
					);
			}
		}
		if(empty($datas)){
			return false;
		}
		return $this->db->insert_batch ( self::TAB_HPS, $datas );
	}
	function get_book_time($book_time,$min_second=0){
		if(!empty($book_time['s'])){
			if(intval($book_time['s'])>intval(date('Hi'))){
				return FALSE;
			}
			$book_times[]=date('YmdH00',strtotime('+ 1 hour',time()));
		}else{
			$book_times[]=date('YmdH00');
		}
		if(!empty($book_time['e'])){
			if(intval($book_time['e'])<intval(date('Hi'))){
				return FALSE;
			}
			$today=date('Ymd');
			$temp=date('YmdH00',strtotime($today.$book_time['e']));
			for($t=$book_times[0];;){
				$t=date('YmdH00',strtotime('+ 1 hour',strtotime($t)));
				if(floatval($t)>floatval($temp)){
					break; 
				}
				$book_times[]=date('YmdH00',strtotime($t));
			}
		}
		//2016-03-28 Edit by OuNinafeng
		$last_time=date('YmdHi',strtotime($book_times[0]));
		if(!empty($min_second)){
			$last_time=date('YmdHi',strtotime($book_times[0])+$min_second);
		}
		return array('book_times'=>$book_times,'last_time'=>$last_time);
	}
	function create_book_time($book_time,$min_second=0){
		$now=intval(date('Hi'));
		$mod=empty($book_time['mod'])?'+ 1 hour':'+ '.$book_time['mod'].' minute ';
		for ($tmp=intval($book_time['s']);$tmp<=intval($book_time['e']);){
			
			$tmp=date('Hi',strtotime($mod));
			$book_times[]=$tmp;
		}
		return array('book_times'=>$book_times,'last_time'=>$last_time);
	}
	
	/**
	 * 后台管理的表格中要显示哪些字段
	 */
	public function grid_fields() {
		return array (
				'room_name' => array (
						'label' => '房型/商品' 
				),
				'price_name' => array (
						'label' => '价格代码' 
				),
				'sprice' => array (
						'label' => '默认房价/商品价',
						'enable' => TRUE 
				),
				'snums' => array (
						'label' => '默认房间数/商品数',
						'enable' => TRUE 
				),
				'bfnums' => array(
						'label' => '早餐',
						'select' => array(
								'-1'=>'不设置',
								'no'=>'无早',
								'1'=>'单早',
								'2'=>'双早',
								'3'=>'三早',
								'4'=>'四早',
						),
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
						'related_code' => '0',
						'des' => '',
						'detail' => '',
						'related_cal_way' => '',
						'related_cal_value' => '',
						'use_condition' => '',
						'sort' => '',
						'unlock_code' => '',
						'must_date' => 3,
						'is_packages' => '0',
						'status' => 1,
						'external_code'=>'',
						'time_condition'=>array('limit_weeks'=>array("0","1","2","3","4","5","6")),
						'good_info'=>''
				);
				break;
			default :
				return array ();
				break;
		}
	}
	
	function get_hotels_price_set($inter_id,$hotel_ids=array(),$select='*',$format=TRUE,$status=NULL){
		$db_read = $this->load->database('iwide_r1',true);
		$db_read->select($select);
		$db_read->where('inter_id',$inter_id);
		empty($hotel_ids)?:$db_read->where_in('hotel_id',$hotel_ids);
		is_null($status)?$db_read->where_in('status',array(1,2)):$db_read->where('status',$status);
		$sets=$db_read->get(self::TAB_HPS)->result_array();
		if ($format&&!empty($sets)){
			$data=array();
			foreach ($sets as $s){
				$data[$s['hotel_id']][$s['room_id']][$s['price_code']]=$s;
			}
			return $data;
		}
		return $sets;
	}
	
	function check_special_code($price_code,$inter_id=''){
		$cp_check=strpos($price_code,'_iwidep_clbu_');
		$check=array();
		if ($cp_check!==FALSE){
			$true_code = substr($price_code,0, $cp_check);
			$special_code = substr($price_code, $cp_check+13);
			$check=array('true_code'=>$true_code,'special_code'=>$special_code,'type'=>'club');
		}
		return $check;
	}
	function check_type_exist($inter_id,$hotel_id,$type,$status='valid'){
		if (empty ( $hotel_id ))
			return array ();
		$db = $this->load->database ( 'iwide_r1', true );
		$db->select ( ' count(s.price_code) as type_count,s.hotel_id ' );
		$db->from ( self::TAB_HPI . ' i' );
		$db->join ( self::TAB_HPS . ' s', ' i.inter_id = s.inter_id and i.price_code=s.price_code ' );
		$db->where ( array (
				'i.inter_id' => $inter_id,
				'i.type' => $type 
		) );
		if ($status == 'valid') {
			$db->where ( array (
					'i.status' => 1,
					's.status' => 1 
			) );
		}
		if (is_array ( $hotel_id )) {
			$db->where_in ( 's.hotel_id', $hotel_id );
			$db->group_by ( ' s.hotel_id ' );
		} else {
			$db->where ( 's.hotel_id', $hotel_id );
			$result = $db->get ()->row_array ();
			return isset ( $result ['type_count'] ) ? $result ['type_count'] : 0;
		}
		$result = $db->get ()->result_array ();
		if (! empty ( $result )) {
			$result = array_column ( $result, 'type_count', 'hotel_id' );
		}
		return $result;
	}
}