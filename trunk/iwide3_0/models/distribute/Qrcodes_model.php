<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author John
 * @package models\distribute
 */
class Qrcodes_model extends MY_Model {

	public function get_resource_name()
	{
		return '员工信息';
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function _shard_db($inter_id=NULL)
    {
        return $this->_db();
    }

    public function _shard_table($basename, $inter_id=NULL )
    {
        return $basename;
    }

	/**
	 * @return string the associated database table name
	 */
	public function table_name()
	{
		return 'hotel_staff';
	}

    /**
     * 取分销二维码
     * @param char $inter_id 公众号唯一识别号
     * @param number $distributed 0|1|2
     * @param string $saler_name 姓名
     * @param string $saler_no 分销号
     * @param string $cellphone 电话
     * @param string $hotel_id 酒店ID
     * @param string $department 部门
     * @param string $status 状态
     * @param string $limit 长度
     * @param number $offset 起始位置
     */
    public function get_salers($inter_id,$distributed = 1,$saler_name = NULL,$saler_no = NULL,$cellphone = NULL,$hotel_id = NULL,$department = NULL,$status = NULL,$limit = NULL,$offset = 0,$grade_time_begin = NULL,$grade_time_end = NULL){
    	$sql = "SELECT s.id,s.inter_id,s.status_time,s.audit_time,s.master_dept,s.qrcode_id,s.`name`,s.cellphone,s.hotel_name,s.hotel_id,s.`status`,s.`is_club`,s.`distribute_hidden`,SUM(a.grade_total) grade_total,SUM(IF(a.`status`=1,a.grade_total,0)) undeliver FROM iwide_hotel_staff s LEFT JOIN iwide_distribute_grade_all a ON s.inter_id=a.inter_id AND a.saler=s.qrcode_id AND (a.`status`=1 OR a.`status`=2 OR a.`status`=9) WHERE s.inter_id=? AND s.is_distributed=?";
    	$params[] = $inter_id;
    	$params[] = $distributed;
    	if(!empty($saler_name)){
    		$sql .= " AND s.`name` LIKE ?";
    		$params[] = "%$saler_name%";
    	}
    	if(!empty($saler_no)){
    		$sql .= " AND s.`qrcode_id`=?";
    		$params[] = "$saler_no";
    	}
    	if(!empty($cellphone)){
    		$sql .= " AND s.`cellphone` LIKE ?";
    		$params[] = "%$cellphone%";
    	}
    	if(!empty($hotel_id)){
    		if(is_array($hotel_id))
	    		$sql .= " AND s.`hotel_id` IN ?";
    		else 
	    		$sql .= " AND s.`hotel_id`=?";
    		$params[] = $hotel_id;
    	}
    	if(!empty($department)){
    		$sql .= " AND s.`master_dept`=?";
    		$params[] = $department;
    	}
    	if(!empty($status)){
    		$sql .= " AND s.`status`=?";
    		$params[] = $status;
    	}
    	if(!empty($grade_time_begin)){
    		$sql .= " AND a.`grade_time`>=?";
    		$params[] = $grade_time_begin;
    	}
    	if(!empty($grade_time_end)){
    		$sql .= " AND a.`grade_time`<=?";
    		$params[] = $grade_time_end.' 23:59:59';
    	}
    	$sql .= " GROUP BY s.id";
    	$sql .= " ORDER BY s.status asc,s.qrcode_id desc";
    	if(!empty($limit)){
    		$sql .= " LIMIT ?,?";
    		$params[] = $offset;
    		$params[] = $limit;
    	}
    	return $this->_db('iwide_r1')->query($sql,$params);
    }
    /**
     * 根据指定条件取分销员数量
     * @param string $inter_id 公众号唯一识别号
     * @param number $distributed 分销标识
     * @param string $saler_name 姓名
     * @param string $saler_no 分销号
     * @param string $cellphone 电话
     * @param string $hotel_id 酒店ID
     * @param string $department 部门
     * @param string $status 状态
     * @param string $grade_time_begin 绩效开始时间
     * @param string $grade_time_end 绩效结束时间
     * @return number 符合条件的分销员的数量
     */
    public function get_salers_count($inter_id,$distributed = 1,$saler_name = NULL,$saler_no = NULL,$cellphone = NULL,$hotel_id = NULL,$department = NULL,$status = NULL){
    	$sql = "SELECT COUNT(s.id) counts FROM iwide_hotel_staff s WHERE s.inter_id=? AND s.is_distributed=?";
    	$params[] = $inter_id;
    	$params[] = $distributed;
    	if(!empty($saler_name)){
    		$sql .= " AND s.`name` LIKE ?";
    		$params[] = "%$saler_name%";
    	}
    	if(!empty($saler_no)){
    		$sql .= " AND s.`qrcode_id`=?";
    		$params[] = "$saler_no";
    	}
    	if(!empty($cellphone)){
    		$sql .= " AND s.`cellphone` LIKE ?";
    		$params[] = "%$cellphone%";
    	}
    	if(!empty($hotel_id)){
			if (is_array ( $hotel_id ))
				$sql .= " AND s.`hotel_id` IN ?";
			else
				$sql .= " AND s.`hotel_id`=?";
			$params [] = $hotel_id;
		}
    	if(!empty($department)){
    		$sql .= " AND s.`master_dept`=?";
    		$params[] = $department;
    	}
    	if(!empty($status)){
    		$sql .= " AND s.`status`=?";
    		$params[] = $status;
    	}
//     	return $this->_db('iwide_rw')->query($sql,$params)->row()->counts;
		$query = $this->_db('iwide_r1')->query($sql,$params)->row();
    	return is_null($query) ? 0 : $query->counts;
    }
    public function get_grades_summary($inter_id,$grade_typ = '',$saler_id = NULL,$grade_time_begin = NULL,$grade_time_end = NULL){
    	$sql = "SELECT saler,inter_id,SUM(IF(`status`<2,grade_total,0)) grade_totals,SUM(`status`<2) counts FROM iwide_distribute_grade_all WHERE inter_id=?";
    	$params[] = $inter_id;
    	if(!empty($grade_typ)){
    		$sql .= " AND grade_table=?";
    		$params[] = $grade_typ;
    	}
    	if(!empty($saler_id)){
    		if(is_array($saler_id)){
    			$sql .= " AND saler IN ?";
    		}else{
    			$sql .= " AND saler=?";
    		}
    		$params[] = $saler_id;
    	}
    	if(!empty($grade_time_begin)){
    		$sql .= " AND grade_time>=?";
    		$params[] = $grade_time_begin;
    	}
    	if(!empty($grade_time_end)){
    		$sql .= " AND grade_time<=?";
    		$params[] = $grade_time_end;
    	}
    	$sql .= " GROUP BY inter_id,saler";
    	return $this->_db('iwide_r1')->query($sql,$params);
    }
    public function get_hash_map($object,$key,$val = NULL){
    	$arr = array();
    	foreach ($object as $item){
    		$arr[$item->$key] = is_null($val) ? $item : $item->$val;
    	}
    	return $arr;
    }
    /**
     * 根据条件获取分销员数量
     * @param Array $inter_id 公众号唯一编号
     * @param Array $hotel_id 酒店ID
     * @param string $begin_time 起始时间
     * @param string $end_time 结束时间
     * @return number
     */
    public function get_salers_counts_sample($inter_id = array(),$hotel_id = array(),$begin_time = '',$end_time = ''){
    	if($inter_id == 'ALL_PRIVILEGES') $inter_id = '';
    	$sql = "SELECT COUNT(*) counts FROM iwide_hotel_staff WHERE `status`=2";
    	if(!empty($inter_id) && $inter_id !='ALL_PRIVILEGES'){
    		if(is_array($inter_id)){
				$sql .= " AND inter_id IN ?";
				$params[] = $inter_id;
			}else{
				$sql .= " AND inter_id=?";
				$params[] = $inter_id;
			}
    		if(!empty($hotel_id)){
    			$sql .= " AND hotel_id IN ?";
    			$params[] = $hotel_id;
    		}
    	}
    	if(!empty($begin_time)){
    		$sql .= " AND audit_time>=?";
    		$params[] = $begin_time;
    	}
    	if(!empty($end_time)){
    		$sql .= " AND audit_time<?";
    		$params[] = $end_time;
    	}
    	$query = $this->_db('iwide_r1')->query($sql,$params)->row();
    	return is_null($query->counts) ? 0 : $query->counts;
    }
    /**
     * 更新分销员状态
     * @param string $inter_id 公众号唯一识别号
     * @param int $saler 分销号
     * @param int $status 状态
     * @return boolean
     */
    public function auth_saler($inter_id,$saler,$status){
		$curr_saler = $this->_get_saler ( $inter_id, $saler );
		if (isset($curr_saler->status)) {
			switch ($curr_saler->status) {
				case 0 :
					if ($status == 2 || $status == 3) {
						$this->_db('iwide_rw')->where(array('inter_id'=>$curr_saler->inter_id,'id'=>$curr_saler->id));
						$params = array('status'=>$status);
						if(empty($curr_saler->qrcode_id) && $status == 2){//不通过的不生成qrcode_id
							$params['qrcode_id'] = $this->_get_qr_code($curr_saler->inter_id, $curr_saler->name, '', $curr_saler->hotel_name);
							if(empty($params['qrcode_id']) || !is_numeric($params['qrcode_id'])){
								return false;//当没有分销号时，更新失败
							}
						}
						return $this->_db('iwide_rw')->update('hotel_staff',$params);
					}
					break;
				case 1 :
					if ($status == 2 || $status == 3) {
						$this->_db('iwide_rw')->where(array('inter_id'=>$curr_saler->inter_id,'id'=>$curr_saler->id));
						$params = array('status'=>$status);
						if(empty($curr_saler->qrcode_id) && $status == 2){//不通过的不生成qrcode_id
							$params['qrcode_id'] = $this->_get_qr_code($curr_saler->inter_id, $curr_saler->name, '', $curr_saler->hotel_name);
							if(empty($params['qrcode_id']) || !is_numeric($params['qrcode_id'])){
								return false;//当没有分销号或者不是数字时，更新失败
							}
						}
						return $this->_db('iwide_rw')->update('hotel_staff',$params);
					}
					break;
				case 2 :
					if ($status == 4) {
						$this->_db('iwide_rw')->where(array('inter_id'=>$curr_saler->inter_id,'id'=>$curr_saler->id));
						$params = array('status'=>$status);
						return $this->_db('iwide_rw')->update('hotel_staff',$params);
					}
					break;
				case 3 :
					return false;
					break;
				case 4 :
					if ($status == 2) {
						$this->_db('iwide_rw')->where(array('inter_id'=>$curr_saler->inter_id,'id'=>$curr_saler->id));
						$params = array('status'=>$status);
						return $this->_db('iwide_rw')->update('hotel_staff',$params);
					}
					break;
			}
		}
		return false;
	}
    /**
     * 根据分销号取分销员信息
     * @param string $inter_id 公众号唯一识别号
     * @param int $saler 分销号
     * @return Query Row
     */
    public function _get_saler($inter_id,$saler,$key = 'id'){
    	$this->_db('iwide_r1')->where(array('inter_id'=>$inter_id,$key=>$saler));
    	$this->_db('iwide_r1')->limit(1);
    	return $this->_db('iwide_r1')->get('hotel_staff')->row();
    }
    /**
     * 更新分销员状态
     * 对于未取得分销号的分销员同时会分配分销号
     * @param string $inter_id 公众号唯一识别号
     * @param int $saler_id 分销员数据库ID
     * @param int $status 状态
     * @param string $qrcode_id 分销号
     * @param string $saler_name 姓名
     * @param string $hotel_name 酒店名
     * @return boolean
     */
    private function _update_saler_status($inter_id,$saler_id,$status,$qrcode_id = NULL,$saler_name = NULL,$hotel_name = NULL){
    	$this->_db('iwide_rw')->trans_begin();
    	$this->_db('iwide_rw')->where(array('inter_id'=>$inter_id,'id'=>$saler_id));
    	$this->_db('iwide_rw')->update('hotel_staff',array('status'=>$status));
    	if ($status == 2 && empty($qrcode_id)){
    		$qrcode_id = $this->_get_qr_code($inter_id, $saler_name, $keyword, $name);
    	}
    	if($this->_db('iwide_rw')->trans_status() === FALSE){
    		$this->_db('iwide_rw')->trans_rollback();
    		return FALSE;
    	}else{
    		$this->_db('iwide_rw')->trans_commit();
    		return TRUE;
    	}
    }
    /**
     * 生成参数二维码
     * @param unknown $inter_id
     * @param unknown $intro
     * @param unknown $keyword
     * @param unknown $name
     * @param string $id
     * @return number|mixed
     */
    private function _get_qr_code($inter_id, $intro, $keyword, $name, $id = NULL) {
		$this->load->model ( 'wx/access_token_model' );
		if (is_null ( $id )) {
			$sql = "SELECT MAX(id) id FROM " . $this->_db ( 'iwide_rw' )->dbprefix ( 'qrcode' ) . " WHERE inter_id='" . $inter_id . "'";
			$max_query = $this->_db ( 'iwide_rw' )->query ( $sql )->row_array ();
			$id = $max_query ['id'] + 1;
		}
		$this->load->helper ( 'common' );
		$access_token = $this->access_token_model->get_access_token ( $inter_id );
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
		$qrcode = '{"action_name": "QR_LIMIT_SCENE","action_info": {"scene": {"scene_id": ' . $id . '}}';
		$output = doCurlPostRequest ( $url, $qrcode );
		$jsoninfo = json_decode ( $output, true );
		if (isset ( $jsoninfo ['errcode'] ) && ($jsoninfo ['errcode'] == '40001' || $jsoninfo ['errcode'] == '42001')) {
			$access_token = $this->access_token_model->reflash_access_token ( $inter_id );
			$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
			$qrcode = '{"action_name": "QR_LIMIT_SCENE","action_info": {"scene": {"scene_id": ' . $id . '}}';
		}
		$output = doCurlPostRequest ( $url, $qrcode );
		$jsoninfo = json_decode ( $output, true );
		if (isset ( $jsoninfo ['url'] )) {
			$this->db->insert ( 'qrcode', array (
					'id'          => $id,
					'intro'       => $intro,
					'keyword'     => $keyword,
					'name'        => $name,
					'inter_id'    => $inter_id,
					'url'         => 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($jsoninfo ['ticket']),
					'create_date' => date ( 'Y-m-d H:i:s' ) 
			) );
			return $id;
		} else
			return $jsoninfo;
	}
	/**
	 * 员工绩效记录
	 * @param string $inter_id 公众号唯一识别号
	 * @param int $saler 分销号
	 * @param int $limit 长度
	 * @param int $typ 绩效状态
	 * @param int $grade_table 绩效类型
	 * @param number $offset 起始位置
	 */
	public function get_saler_grades($inter_id, $saler, $limit = NULL, $offset = 0,$typ = '',$grade_table='') {
		$sql = "SELECT a.id,a.inter_id,a.saler,a.hotel_id,a.grade_table,a.grade_openid,a.order_status,a.order_amount,a.grade_total,a.`status`,a.grade_time,e.product,e.order_id,f.nickname
FROM iwide_distribute_grade_all a 
INNER JOIN iwide_distribute_grade_ext e ON a.inter_id=e.inter_id AND a.id=e.grade_id
LEFT JOIN iwide_fans f ON f.openid=a.grade_openid AND f.inter_id=a.inter_id WHERE a.saler=? AND a.inter_id=?";
		$params = array ( $saler, $inter_id );
		if(!empty($typ)){
			if(is_array($typ)){
				$sql .= " AND `status` IN ?";
			}else{
				$sql .= " AND `status`=?";
			}
			$params[] = $typ;
		}
		if(!empty($grade_table)){
			if(is_array($grade_table)){
				$sql .= " AND `grade_table` IN ?";
			}else{
				$sql .= " AND `grade_table`=?";
			}
			$params[] = $grade_table;
		}
		$sql .= ' ORDER BY a.id DESC';
		if (! empty ( $limit )) {
			$sql .= " LIMIT ?,?";
			$params [] = $offset;
			$params [] = $limit;
		}
		return $this->_db ( 'iwide_r1' )->query ( $sql, $params );
	}
	/**
	 * 去员工绩效记录数
	 * @param string $inter_id 公众号唯一识别号
	 * @param int $saler 分销号
	 * @param int $typ 绩效状态
	 * @param int $grade_table 绩效类型
	 * @return int 记录数
	 */
	public function get_saler_grades_count($inter_id, $saler,$typ = '',$grade_table='') {
		$sql = "SELECT COUNT(a.id) nums FROM iwide_distribute_grade_all a WHERE a.saler=? AND a.inter_id=?";
		$params = array ( $saler, $inter_id );
		if(!empty($typ)){
			if(is_array($typ)){
				$sql .= " AND `status` IN ?";
			}else{
				$sql .= " AND `status`=?";
			}
			$params[] = $typ;
		}
		if(!empty($grade_table)){
			if(is_array($grade_table)){
				$sql .= " AND `grade_table` IN ?";
			}else{
				$sql .= " AND `grade_table`=?";
			}
			$params[] = $grade_table;
		}
		$query = $this->_db ( 'iwide_r1' )->query ( $sql, $params )->row ();
		return is_null($query->nums) ? 0 : $query->nums;
	}
	/**
	 * 员工绩效统计
	 * @param unknown $inter_id
	 * @param unknown $saler
	 */
	public function get_saler_grades_amounts($inter_id, $saler) {
		$sql = "SELECT SUM(IF(a.status=1 OR a.`status`=2 OR a.`status`=9,grade_total,0)) total_grades,SUM(IF(a.status=1,grade_total,0)) undeliver,SUM(a.`status`=1) total_counts,SUM(IF(a.`status`=2 OR a.`status`=9,1,0)) delivered FROM iwide_distribute_grade_all a WHERE saler=? AND inter_id=?";
		$params = array($saler,$inter_id);
		return $this->_db('iwide_r1')->query($sql,$params)->row();
	}
	
	/**
	 * 取员工所有部门
	 * @param string $inter_id 公众号唯一识别号
	 */
	public function get_staff_depts($inter_id,$key = '',$hotel_id = NULL) {
		if(!empty($inter_id)){
			if (is_array ( $inter_id ))
				$this->_db ( 'iwide_r1' )->where_in ( 'inter_id', $inter_id );
			else
				$this->_db ( 'iwide_r1' )->where ( 'inter_id', $inter_id );
		}
		if(!empty($key)){
			$this->_db('iwide_r1')->where('master_dept LIKE',"%{$key}%");
		}
		if(!empty($hotel_id)){
			if(is_array($hotel_id)){
				$this->_db('iwide_r1')->where_in('hotel_id',$hotel_id);
			}else{
				$this->_db('iwide_r1')->where('hotel_id',$hotel_id);
			}
		}
		$this->_db ( 'iwide_r1' )->select ( 'master_dept' );
		$this->_db ( 'iwide_r1' )->group_by ( 'master_dept' );
		return $this->_db ( 'iwide_r1' )->get ( 'hotel_staff' )->result ();
	}
	/**
	 * 根据指定的公众号查询其中有参与分销的公众号的数量
	 * @param Array $inter_id 公众号数组，为空时默认全部
	 * @return int
	 */
	public function get_inter_id_counts_with_pris($inter_id = array()){
		$sql = "SELECT COUNT(DISTINCT inter_id) counts FROM iwide_hotel_staff WHERE `status`=2";
		$params = array();
		if(!empty($inter_id) && $inter_id != 'ALL_PRIVILEGES'){
			if(is_array($inter_id)){
				$sql .= " AND inter_id IN ?";
				$params[] = $inter_id;
			}else{
				$sql .= " AND inter_id=?";
				$params[] = $inter_id;
			}
		}
		$query = $this->_db ( 'iwide_r1' )->query ( $sql,$params )->row ();
		return is_null($query->counts) ? 0 : $query->counts;
	}
	/**
	 * 根据指定的公众号查询其中有参与分销的公众号的数量
	 * @param Array $inter_id 公众号数组，为空时默认全部
	 * @return int
	 */
	public function get_hotel_id_counts_with_pris($inter_id){
		$sql = "SELECT COUNT(DISTINCT hotel_id) counts FROM iwide_hotel_staff WHERE `status`=2";
		$params = array();
		if(!empty($inter_id) && $inter_id != 'ALL_PRIVILEGES'){
			if(is_array($inter_id)){
				$sql .= " AND inter_id IN ?";
				$params[] = $inter_id;
			}else{
				$sql .= " AND inter_id=?";
				$params[] = $inter_id;
			}
		}
		$query = $this->_db ( 'iwide_r1' )->query ( $sql,$params )->row ();
		return is_null($query->counts) ? 0 : $query->counts;
	}
	public function qrsave($params) {
		if (! isset ( $params ['qrcode_id'] ) || ! isset ( $params ['inter_id'] )) {
			return FALSE;
		} else {
			if (isset ( $params ['status'] )) {
				if (! $this->is_status_valid ( $params ['inter_id'], $params ['qrcode_id'], $params ['status'] )) {
					return FALSE;
				}
			}
			$this->load->model('hotel/hotel_model');
			$hotel_info = $this->hotel_model->get_hotel_by_ids($params ['inter_id'],$params ['hotel_id']);
			if(isset($hotel_info))
				$params['hotel_name'] = $hotel_info[0]['name'];
			$this->_db ( 'iwide_rw' )->where ( array ( 'qrcode_id' => $params ['qrcode_id'], 'inter_id' => $params ['inter_id'] ) );
			$fields = $this->_shard_db ()->list_fields ( 'hotel_staff' );
			foreach ( $params as $k => $v ) {
				if (! in_array ( $k, $fields )) {
					unset ( $params [$k] );
				}
			}
			return $this->_db ( 'iwide_rw' )->update ( 'hotel_staff',$params );
		}
	}
	public function is_status_valid($inter_id, $saler,$status){
		$curr_saler = $this->_get_saler ( $inter_id, $saler ,'qrcode_id');
		if (isset($curr_saler->status)) {
			$valid_status = $this->get_valid_status(intval($curr_saler->status));
			return in_array($status, $valid_status);
// 			if(($curr_saler->status == 0 || $curr_saler->status == 1) && ($status == 2 || $status == 3)){
// 				return TRUE;
// 			}else if ($curr_saler->status == 2 && $status == 4){
// 				return TRUE;
// 			}else if ($curr_saler->status == 3){
// 				return FALSE;
// 			}else if ($curr_saler->status == 4 && $status == 2){
// 				return TRUE;
// 			}else{
// 				return FALSE;
// 			}
		}
	}
	public function get_valid_status($cur_status){
		if($cur_status == 0 || $cur_status == 1)
			return array(2,3,$cur_status);
		else if($cur_status == 4)
			return array(2,$cur_status);
		else if($cur_status == 2)
			return array(4,$cur_status);
		else
			return array($cur_status);
	}
	public function get_qrcodes_base($params = array(), $select = array(), $format = 'array') {
		$select = count ( $select ) == 0 ? '*' : implode ( ',', $select );
		$this->_db ( 'iwide_r1' )->select ( " {$select} " );
		
		$where = array ();
		$dbfields = array_values ( $fields = $this->_db ( 'iwide_r1' )->list_fields ( 'hotel_staff' ) );
		foreach ( $params as $k => $v ) {
			$key = explode(' ', $k);
			// 过滤非数据库字段，以免产生sql报错
			if (in_array ( $key[0], $dbfields ) && is_array ( $v )) {
				$this->_db ( 'iwide_r1' )->where_in ( $key[0], $v );
			} else if (in_array ( $key[0], $dbfields )) {
				$this->_db ( 'iwide_r1' )->where ( $k, $v );
			}
		}
		$result = $this->_db ( 'iwide_r1' )->get ( 'hotel_staff' );
		if ($format == 'object')
			return $result->result ();
		else
			return $result->result_array ();
	}
	    public function club_status(){
	        return array(
	            0=>'否',
	            1=>'是'
	        );
	    }


	    public function distribute_hidden(){
	        return array(
	            0=>'显示',
	            1=>'隐藏'
	        );
	    }
}
