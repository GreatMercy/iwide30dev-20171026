<?php
/**
 * @author John
 * @package models\distribute
 */
class Grades_model extends MY_Model{
	
	/**
	 * 绩效类型
	 */
	public $grade_types = array (
			'iwide_member_additional'           => '会员绩效',
			'iwide_fans_sub_log'                => '粉丝关注收益',
			'iwide_hotels_order'                => '订房收益',
			'iwide_soma_sales_order:default'    => '商城收益',
			'iwide_soma_sales_order:groupon'    => '商城收益', 
			'iwide_soma_sales_order:killsec'    => '商城收益', 
			'iwide_soma_mooncake_order:default' => '商城收益', 
			'iwide_member4_reg' => '会员注册', 
			'iwide_shp_orders'                  => '商城收益', 
			'iwide_distribute_group_member'     => '额外收益',
			'iwide_firstorder_reward'			=>	'额外收益'  
	);
	
	/**
	 * 绩效状态
	 */
	public $grade_status = array (
			1 => '已核定－未发放',//交易成功（不论消费方式一律按7天核定奖励）、拼团成功（成团立即核定奖励）
			2 => '已核定－已发放',
			4 => '未核定－尚未离店',
			5 => '已核定－无绩效',//发生退款（立即撤销奖励）
			6 => '未核定-付款成功', //付款成功、开团成功（只奖励开团人订单）
			9 => '发放异常' //付款成功、开团成功（只奖励开团人订单）
	);
	
	/**
	 * 订单状态
	 */
	public $order_status = array('iwide_shp_orders'=>array(),
			'iwide_soma_sales_order:default'=>array(12=>'购买成功',14=>'订单取消',15=>'拼团中',16=>'拼团成功'),
			'iwide_soma_sales_order:groupon'=>array(12=>'购买成功',14=>'订单取消',15=>'拼团中',16=>'拼团成功'),
			'iwide_soma_sales_order:killsec'=>array(12=>'购买成功',14=>'订单取消',15=>'拼团中',16=>'拼团成功'),
			'iwide_fans_sub_log'=>array(0=>'关注成功'),
			'iwide_member_additional'=>array(0=>'注册成功'),
			'iwide_hotels_order'=>array(0=>'预订',1=>'确认',2=>'入住',3=>'离店',4=>'用户取消',5=>'酒店取消',6=>'酒店删除',7=>'异常',8=>'未到',11=>'系统取消',12=>'完结'),
			'iwide_distribute_group_member'=>array(0=>'成功'),
			'iwide_firstorder_reward'=>array(0=>'成功'),
			'iwide_member4_reg'=>array(0=>'注册成功'),
	);
	/**
	 * 取分销员指定的时间绩效总额，不传时间则返回记录总额
	 * @todo 取分销员指定的时间绩效总额，不传时间则返回记录总额
	 * @param string $inter_id 公众号唯一识别信息
	 * @param int $saler 分销号
	 * @param string $date 时间 Y-m-d|date_type=DAY<br />Y-m|date_type=MONTH
	 * @param string $type  查询类型 NEW|已核定，未发放<br />OLD|已发放<br />ALL|已核定（包括未发放和已发放）<br />PRE|未核定<br />SEND|发放记录
	 * @param string $date_type 时间类型 DAY|MONTH 
	 * @return decimal | false
	 */
	public function get_saler_grades_by_date($inter_id,$saler,$date=NULL,$type='ALL',$date_type='DAY'){
		$sql = "SELECT SUM(grade_total) total FROM iwide_distribute_grade_all WHERE inter_id=? AND saler=?";
		$params = array($inter_id,$saler);
		if(!empty($date) && $date_type == 'DAY'){
			$sql .= " AND DATE_FORMAT(grade_time,'%Y-%m-%d')=?";
			$params[] = $date;
		}elseif(!empty($date) && $date_type == 'MONTH'){
			$sql .= " AND DATE_FORMAT(grade_time,'%Y-%m')=?";
			$params[] = $date;
		}
		if($type == 'NEW'){
			$sql .= ' AND status=1';
		}elseif($type == 'OLD'){
			$sql .= ' AND (status=2 OR status=9)';
		}elseif($type == 'PRE'){
			$sql .= ' AND (status=4 OR status=6)';
		}elseif($type == 'SEND'){
			$sql .= ' AND status=7';
		}else{
			$sql .= ' AND (status=1 OR status=2 OR status=9)';
		}
		$sql .=" GROUP BY saler";
		$query = $this->_db('iwide_r1')->query($sql,$params);
		if($query)$query = $query->row();
		return empty($query->total) ? 0 : $query->total; 
	}
	/**
	 * 取分销员指定的时间绩效笔数，不传时间则返回记录总笔数
	 * @todo 取分销员指定的时间绩效笔数，不传时间则返回记录总笔数
	 * @param string $inter_id 公众号唯一识别信息
	 * @param int $saler 分销号
	 * @param string $date Y-m-d|date_type=DAY<br />Y-m|date_type=MONTH
	 * @param string $type  NEW|已核定，未发放<br />OLD|已发放<br />ALL|已核定（包括未发放和已发放）<br />PRE|未核定<br />SEND|发放记录
	 * @param string $date_type DAY|MONTH 时间类型
	 * @return int | false
	 */
	public function get_saler_grades_times_by_date($inter_id,$saler,$date=NULL,$type='ALL',$date_type='DAY'){
		$sql = "SELECT count(id) nums FROM iwide_distribute_grade_all WHERE inter_id=? AND saler=?";
		$params = array($inter_id,$saler);
		if(!empty($date) && $date_type == 'DAY'){
			$sql .= " AND DATE_FORMAT(grade_time,'%Y-%m-%d')=?";
			$params[] = $date;
		}elseif(!empty($date) && $date_type == 'MONTH'){
			$sql .= " AND DATE_FORMAT(grade_time,'%Y-%m')=?";
			$params[] = $date;
		}
		if($type == 'NEW'){
			$sql .= ' AND status=1';
		}elseif($type == 'OLD'){
			$sql .= ' AND status=2';
		}elseif($type == 'PRE'){
			$sql .= ' AND (status=4 OR status=6)';
		}elseif($type == 'SEND'){
			$sql .= ' AND status=7';
		}else{
			$sql .= ' AND (status=1 OR status=2)';
		}
		$sql .=" GROUP BY saler";
		$query = $this->_db('iwide_r1')->query($sql,$params)->row();
		return empty($query->nums) ? 0 : $query->nums; 
	}
	/**
	 * 取分销员指定的粉丝绩效总额
	 * @todo 取分销员指定的粉丝绩效总额
	 * @param string $inter_id 公众号唯一识别信息
	 * @param int $saler 分销号
	 * @param string $date Y-m-d
	 * @param string $type  NEW|已核定，未发放<br />OLD|已发放<br />ALL|已核定（包括未发放和已发放）<br />PRE|未核定，SEND|发放记录
	 * @return decimal | false
	 */
	public function get_saler_grades_by_fans($inter_id,$saler,$fans_openid,$type='ALL'){
		$sql = "SELECT SUM(grade_total) total FROM iwide_distribute_grade_all WHERE inter_id=? AND saler=? AND openid=?";
		$params = array($inter_id,$saler,$fans_openid);
		if($type == 'NEW'){
			$sql .= ' AND status=1';
		}elseif($type == 'OLD'){
			$sql .= ' AND status=2';
		}elseif($type == 'PRE'){
			$sql .= ' AND (status=4 OR status=6)';
		}elseif($type == 'SEND'){
			$sql .= ' AND status=7';
		}else{
			$sql .= ' AND (status=1 OR status=2)';
		}
		$sql .=" GROUP BY saler";
		$query = $this->_db('iwide_r1')->query($sql,$params)->row();
		return empty($query->total) ? 0 : $query->total; 
	}
	
	/**
	 * 取分销员收益记录
	 * @todo 取分销员收益记录
	 * @param string $inter_id 公众号唯一识别信息
	 * @param int $saler 分销号
	 * @param string $type 类型
	 * @param int $offset 起始位置
	 * @param int $limit 长度
	 */
	public function get_saler_grades_logs($inter_id,$saler,$type='ALL',$offset=NULL,$limit=20){
		$sql = 'SELECT ga.*,ge.*,f.nickname,f.headimgurl FROM iwide_distribute_grade_all ga INNER JOIN iwide_distribute_grade_ext ge ON ga.inter_id=ge.inter_id AND ga.id=ge.grade_id LEFT JOIN iwide_fans f ON f.inter_id=ga.inter_id AND f.openid=ga.grade_openid WHERE ga.inter_id=? AND ga.saler=?';
		if($type == 'NEW'){
			$sql .= ' AND status=1 ';
		}elseif($type == 'OLD'){
			$sql .= ' AND status=2 ';
		}elseif($type == 'PRE'){
			$sql .= ' AND (status=4 OR status=6) ';
		}elseif($type == 'SEND'){
			$sql .= ' AND status=7 ';
		}
		$sql .= ' ORDER BY grade_time DESC';
		$params = array($inter_id,$saler);
		if(!is_null($offset)){
			$sql .= ' LIMIT ?,?';
			$params[] = $offset;
			$params[] = $limit;
		}
		return $this->_db('iwide_r1')->query($sql,$params)->result();
	}
	/**
	 * 取分销员收益记录
	 * @todo 取分销员收益记录
	 * @param string $inter_id 公众号唯一识别信息
	 * @param int $saler 分销号
	 * @param string $type 查询类型
	 * @param int $offset 起始位置
	 * @param int $limit 长度
	 */
	public function get_saler_grades_logs_by_month($inter_id,$saler,$type='ALL',$month=null,$offset=NULL,$limit=20){
		$sql = 'SELECT ga.*,ge.*,f.nickname,f.headimgurl FROM iwide_distribute_grade_all ga INNER JOIN iwide_distribute_grade_ext ge ON ga.inter_id=ge.inter_id AND ga.id=ge.grade_id LEFT JOIN iwide_fans f ON f.inter_id=ga.inter_id AND f.openid=ga.grade_openid WHERE ga.inter_id=? AND ga.saler=?';
		if($type == 'NEW'){
			$sql .= ' AND status=1 ';
		}elseif($type == 'OLD'){
			$sql .= ' AND status=2 ';
		}elseif($type == 'PRE'){
			$sql .= ' AND (status=4 OR status=6) ';
		}elseif($type == 'SEND'){
			$sql .= ' AND status=7 ';
		}
		$params = array($inter_id,$saler);
		if(!empty($month)){
			$sql .= " AND DATE_FORMAT(ga.grade_time,'%Y-%m')=?";
			$params[] = $month;
		}
		$sql .= ' ORDER BY order_time DESC';
		if(!is_null($offset)){
			$sql .= ' LIMIT ?,?';
			$params[] = $offset;
			$params[] = $limit;
		}
		$query = $this->_db('iwide_r1')->query($sql,$params)->result();
		if($this->input->get('debug')==1){
			echo $this->_db('iwide_r1')->last_query();echo '<br />';
		}
		return $query;
	}
	/**
	 * 分销员绩效发放记录
	 * @param string $inter_id 公众号唯一识别信息
	 * @param string $batch_no 发放流水号
	 * @param int $offset 起始位置
	 * @param int $limit 长度
	 * @return Query result
	 */
	public function get_saler_send_logs_by_batch_no($inter_id,$batch_no,$saler,$offset=NULL,$limit=20){
		
		$this->_db('iwide_r1')->where(array('batch_no'=>$batch_no,'saler'=>$saler,'inter_id'=>$inter_id));
		
		$res = $this->_db('iwide_r1')->get('distribute_send_record')->row();
		
		$sql = 'SELECT ga.*,ge.*,f.nickname,f.headimgurl FROM iwide_distribute_grade_all ga INNER JOIN iwide_distribute_grade_ext ge ON ga.inter_id=ge.inter_id AND ga.id=ge.grade_id LEFT JOIN iwide_fans f ON f.inter_id=ga.inter_id AND f.openid=ga.grade_openid WHERE ga.inter_id=? AND ga.partner_trade_no=?';
		$params = array($inter_id,$res->partner_trade_no);
		$sql .= ' ORDER BY order_time DESC';
		if(!is_null($offset)){
			$sql .= ' LIMIT ?,?';
			$params[] = $offset;
			$params[] = $limit;
		}
		$query = $this->_db('iwide_r1')->query($sql,$params)->result();
		if($this->input->get('debug')==1){
			echo $this->_db('iwide_r1')->last_query();echo '<br />';
		}
		return $query;
	}
	/**
	 * 取分销员的粉丝的收益记录
	 * @param string $inter_id 公众号唯一编号
	 * @param int $saler 分销号
	 * @param id $fans_id 粉丝编号
	 * @param string $type 绩效类型
	 * @param int $offset 起始位置
	 * @param int $limit 长度
	 * @return Query Result
	 */
	public function get_saler_fans_grades_logs($inter_id,$saler,$fans_id,$type='ALL',$offset=NULL,$limit=20){
		$this->_db('iwide_r1')->where(array('inter_id'=>$inter_id,'id'=>$fans_id));
		$this->_db('iwide_r1')->limit(1);
		$res = $this->_db('iwide_r1')->get('fans_subs')->row();
		if(empty($res->openid))
			return FALSE;
		$sql = 'SELECT ga.*,ge.*,f.nickname,f.headimgurl FROM iwide_distribute_grade_all ga INNER JOIN iwide_distribute_grade_ext ge ON ga.inter_id=ge.inter_id AND ga.id=ge.grade_id LEFT JOIN iwide_fans f ON f.openid=ga.grade_openid AND f.inter_id=ga.inter_id WHERE ga.inter_id=? AND ga.saler=? AND ga.grade_openid=?';
		if($type == 'NEW'){
			$sql .= ' AND status=1 ';
		}elseif($type == 'OLD'){
			$sql .= ' AND status=2 ';
		}elseif($type == 'PRE'){
			$sql .= ' AND (status=4 OR status=6) ';
		}elseif($type == 'SEND'){
			$sql .= ' AND status=7 ';
		}
		$sql .= ' ORDER BY order_time DESC';
		$params = array($inter_id,$saler,$res->openid);
		if(!is_null($offset)){
			$sql .= ' LIMIT ?,?';
			$params[] = $offset;
			$params[] = $limit;
		}
		return $this->_db('iwide_r1')->query($sql,$params)->result();
	}
	
	/**
	 * 写入绩效队列表
	 * @param unknown $params
	 */
	public function create_grade($params){
		if(empty($params)) return FALSE;
		if(!isset($params['grade_id'])) return FALSE;
		if(!isset($params['grade_table'])) return FALSE;
		if(!isset($params['inter_id'])) return FALSE;
		if(isset($params['grade_openid']) || $this->grades_order_exist($params['inter_id'],$params['grade_table'],$params['grade_id'],$params['grade_typ'])){
			return $this->_db('iwide_rw')->insert('distribute_grade_queue',array('rec_content'=>json_encode($params),
					'rec_time'=>date('Y-m-d H:i:s'),
					'flag'=>0,
					'grade_typ'=>isset($params['grade_typ']) ? $params['grade_typ'] : 1,
					'grade_id'=> $params['grade_id'],
					'grade_table'=> $params['grade_table'],
					'inter_id'=> $params['inter_id']
			));
		}
	}
	
	/**
	 * 写入新绩效
	 * @todo 写入新绩效
	 * @param Array $params 写入新绩效时应该写入的数组<pre>Array {"inter_id":"公众号ID",
"hotel_id":"下单酒店ID",
"saler":"分销号，粉丝归属的分销号不用传，按次计算需要传",
"grade_openid":"粉丝openid",
"grade_table":"订房iwide_hotels_order，商城iwide_shp_orders，套票iwide_product_package_orders",
"grade_id":"记录产生绩效的表的主键值",
"grade_id_name":"记录产生绩效的表的ID名称",
"order_amount":"订单总金额（包含优惠折扣金额）",
"grade_total":"绩效总金额（默认-1）",
"grade_amount":"订单计算绩效部分的金额",
"status":"",
"grade_amount_rate":"绩效值/比例（grade_total等于-1，此字段可以不传）",
"grade_rate_type":"计算类型0：固定金额，1：比例（grade_total等于-1，此字段可以不传）",
"remark":"备注",
"product":"产品名称",
"order_status":"订单状态",
"fans_hotel":"粉丝所属酒店",
"hotel_rate":"酒店绩效规则值",
"group_rate":"集团绩效规则值",
"jfk_rate":"金房卡绩效规则值",
"hotel_grades":"酒店绩效金额",
"group_grades":"集团绩效金额",
"jfk_grades":"金房卡绩效金额",
"grade_typ":"分销来源类型,1|粉丝归属,2|分享绩效",
"order_id":"订单号(如果有PMS订单号传PMS订单号)"}</pre>更新数据时传入的数组跟上面的一样，但是只有<code>$inter_id,$grade_table,$grade_id,$grade_typ</code>为必填项，其他参数只需传入需要更新的参数
	 * @return int|boolean
	 */
	public function _create_grade($params){
		//check order_item_id -> check source -> 
		//先查询订单是否写入过绩效，有写过绩效就不重复写入
		if(!isset($params['grade_typ'])){
			$params['grade_typ'] = 1;
		}
		if(!$this->grades_order_exist($params['inter_id'],$params['grade_table'],$params['grade_id'],$params['grade_typ'])){
			$this->load->model('distribute/fans_model');
			$this->load->model('distribute/staff_model');
			$fans_info = new stdClass();
			//没有传指定的分销号查询粉丝的分销来源
			if(isset($params['saler']) && $params['saler'] != 0){
				$fans_info->source = $params['saler'];
				$fans_info->hotel_id = isset($params['hotel_id']) ? $params['hotel_id'] : 0;
			}else{
				$fans_info  = $this->fans_model->get_fans_beloning($params['inter_id'],$params['grade_openid']);
			}
			$saler_info = array('is_distributed' => 0,'qrcode_id'=>0,'hotel_name'=>'','name'=>'','cellphone'=>'','hotel_id'=>'');
			//分销来源不为空，查询分销员信息
			if(isset($fans_info->source) && $fans_info->source > 0){
				$saler_query = $this->staff_model->get_my_base_info_saler ( $params ['inter_id'], $fans_info->source );
				if ($saler_query){
					$saler_info = $saler_query;
					//停止绩效分销员，记绩效为核定无绩效
					if($saler_info['status'] == 4) $params['status'] = 5;
				}
			}
			if(empty($fans_info->hotel_id)){
				$fans_info->hotel_id = $saler_info['hotel_id'];
			}
			$grades_info = array('hotel_name' => $saler_info['hotel_name'],
								 'staff_name' => $saler_info['name'],
								 'cellphone'  => $saler_info['cellphone'],
								 'product'    => $params['product'],
								 'order_id'   => $params['order_id'],
								 'grade_id'   => $params['grade_id'],
								 'inter_id'   => $params['inter_id'],
								 'distribute' => 0);
			//绩效类型 ：iwide_hotel_orders - 订房，iwide_shp_orders - 商城，iwide_fans_sub_log - 关注
// 			switch ($params['grade_table']){
// 				case 'iwide_hotel_orders':
// 					$this->new_booking_grade($fans_info,$saler_info,$grades_info,$params);
// 					break;
// 				default:
					$this->new_grade($fans_info, $saler_info, $grades_info, $params);
// 					break;
// 			}
			// $this->_db('iwide_rw')->where(array('id'=>$id));
			// $this->_db('iwide_rw')->update('distribute_grade_queue',array('flag'=>1,'deal_time'=>date('Y-m-d H:i:s')));
			return true;
		}else{
			return $this->_update_grade_status($params);
// 			return array('errcode'=>-1,'errmsg'=>'该订单绩效已存在');
		}
	}
	
	/**
	 * 更新绩效状态
	 * @param Array $params
	 */
	private function _update_grade_status($params){
		if(!isset($params['grade_typ'])){
			$params['grade_typ'] = 0;
		}
		$grade_entity = $this->get_single_grade_base($params['inter_id'],$params['grade_table'],$params['grade_id'],$params['grade_typ']);
		//对于已核定未发放的绩效，判断旧状态是否已发放，已发放状态不可再更改为未发放
		//无绩效状态不允许修改
		if(isset($params['status']) && $params['status'] == 1){
			if(isset($grade_entity->status) && $grade_entity->status == 2)
				unset($params['status']);
		}
		if(isset($params['status']) && $grade_entity->status == 5) 
			unset($params['status']);
		if(isset($params['status']))
			$avgs['status'] = $params['status'];
		if(isset($params['order_status'])){
			$avgs['order_status']=$params['order_status'];
		}
		//绩效未发放的时候允许修改绩效金额
		if(isset($grade_entity->status) && $grade_entity->status != 2){
			if (isset ( $params ['grade_amount'] ))
				$avgs ['grade_amount'] = $params ['grade_amount'];
			if (isset ( $params ['grade_amount_rate'] ))
				$avgs ['grade_amount_rate'] = $params ['grade_amount_rate'];
			if (isset ( $params ['grade_rate_type'] ))
				$avgs ['grade_rate_type'] = $params ['grade_rate_type'];
			if (isset ( $params ['hotel_rate'] ))
				$avgs ['hotel_rate'] = $params ['hotel_rate'];
			if (isset ( $params ['group_rate'] ))
				$avgs ['group_rate'] = $params ['group_rate'];
			if (isset ( $params ['jfk_rate'] ))
				$avgs ['jfk_rate'] = $params ['jfk_rate'];
			if (isset ( $params ['hotel_grades'] )){
				$avgs ['hotel_grades'] = $params ['hotel_grades'];
			}
			if (isset ( $params ['group_grades'] ))
				$avgs ['group_grades'] = $params ['group_grades'];
			if (isset ( $params ['jfk_grades'] ))
				$avgs ['jfk_grades'] = $params ['jfk_grades'];
			if (isset ( $params ['grade_total'] ))
				$avgs ['grade_total'] = $params ['grade_total'];
			if (isset ( $params ['order_amount'] ))
				$avgs ['order_amount'] = $params ['order_amount'];
		}
		$where_params = array('inter_id'=>$params['inter_id'],'grade_table'=>$params['grade_table'],'grade_id'=>"{$params['grade_id']}",'grade_typ'=>$params['grade_typ']);
		$this->_db('iwide_rw')->where($where_params);
		if(isset($params['status']) && $params['status'] == 1){
			$avgs['grade_time'] = date('Y-m-d H:i:s');
		}
		$this->write_log($avgs,$params,$grade_entity);
		$flag = $this->_db('iwide_rw')->update('distribute_grade_all',$avgs);
		
		//update hotel grades
		if(isset ( $params ['hotel_grades'] ) && $params ['hotel_grades'] > 0){
			$hotel_avgs = $avgs;
			$hotel_avgs['grade_total'] = $avgs['hotel_grades'];
			$this->_db('iwide_rw')->where($where_params + array('saler'=>-2));
			$this->_db('iwide_rw')->update('distribute_grade_all',$hotel_avgs);
		}
		if(isset ( $params ['group_grades'] ) && $params ['group_grades'] > 0){
			$group_avgs = $avgs;
			$group_avgs['grade_total'] = $avgs['group_grades'];
			$this->_db('iwide_rw')->where($where_params + array('saler'=>-3));
			$this->_db('iwide_rw')->update('distribute_grade_all',$group_avgs);
		}
		if(isset ( $params ['jfk_grades'] ) && $params ['jfk_grades'] > 0){
			$jfk_avgs = $avgs;
			$jfk_avgs['grade_total'] = $avgs['jfk_grades'];
			$this->_db('iwide_rw')->where($where_params + array('saler'=>-1));
			$this->_db('iwide_rw')->update('distribute_grade_all',$jfk_avgs);
		}
		return $flag > 0;
		
	}
	
	/**
	 * 订房绩效处理
	 * @param Object $grade_settings
	 * @param Object $fans_info
	 * @param Object $saler_info
	 * @param Object $grades_info
	 */
	private function new_booking_grade($fans_info,$saler_info,$grades_info,$params){
		//查询分销配置信息
		$grade_settings = $this->get_grades_settings($params['inter_id'], $params['grade_table']);
		$saler_rate = isset($grade_settings->excitation_value) ? $grade_settings->excitation_value : 0;
		//多级绩效结构
		//归属的酒店的绩效比例
		$hotel_rate = isset($grade_settings->hotel_value) ? $grade_settings->hotel_value : 0;
		//金房卡绩效比例
		$jfk_rate   = isset($grade_settings->jfk_value) ? $grade_settings->jfk_value : 0;
		//集团绩效比例
		$group_rate = isset($grade_settings->group_value) ? $grade_settings->group_value : 0;
		/*
		 * 云盟绩效体系
		 * QRCODE 酒店 员工 金房卡 云盟
		 * 员工            5%  2%  2% 1%
		 * 酒店            5%  0%  2% 3% 
		 * 公共            0%  0%  2% 8%
		 * */
		if(isset($grade_settings->excitation_type) && ($grade_settings->excitation_type == 1 || $grade_settings->excitation_type == 2)){
			if ($saler_rate == 0 && $hotel_rate == 0)
				$group_rate = 10 - $jfk_rate;
			if ($saler_rate == 0 && $hotel_rate > 0)
				$group_rate = 10 - $jfk_rate - $hotel_rate;
		}
		$saler_val = $hotel_val = $jfk_val = $group_val = 0;
		switch ($grade_settings->excitation_type){
			case 2 : // 订单金额百分比
				if ($fans_info->source > 0 && $saler_rate > 0)
					$saler_val = $params ['grade_amount'] * $saler_rate;
				if ($fans_info->hotel_id > 0 && $hotel_rate > 0)
					$hotel_val = $params ['grade_amount'] * $hotel_rate;
				if ($jfk_rate > 0)
					$jfk_val = $params ['grade_amount'] * $jfk_rate;
				if ($group_rate > 0)
					$group_val = $params ['grade_amount'] * $group_rate;
				break;
			case 3 : // 订单固定金额
			        // 子单首单记录绩效
				if ($this->is_order_first_cout ( $params ['inter_id'], $params ['order_id'] )) {
					if ($fans_info->source > 0 && $saler_rate > 0)
						$saler_val = $saler_rate;
					if ($fans_info->hotel_id > 0 && $hotel_rate > 0)
						$hotel_val = $saler_rate;
					if ($jfk_rate > 0)
						$jfk_val = $jfk_rate;
					if ($group_rate > 0)
						$group_val = $group_rate;
				}
				break;
			case 4 : // 每间夜固定金额
				$date_span = $this->get_order_date_span ( $params ['inter_id'], $params ['grade_id'] );
				if ($fans_info->source > 0 && $saler_rate > 0)
					$saler_val = $date_span * $saler_rate;
				if ($fans_info->hotel_id > 0 && $hotel_rate > 0)
					$hotel_val = $date_span * $hotel_rate;
				if ($jfk_rate > 0)
					$jfk_val = $date_span * $jfk_rate;
				if ($group_rate > 0)
					$group_val = $date_span * $group_rate;
				break;
		}
		$grades_base = array('inter_id' => $params['inter_id'],
				'saler'             => $saler_info['qrcode_id'],
				'grade_openid'      => $params['grade_openid'],
				'grade_id'          => "{$params['grade_id']}",
				'grade_table'       => $params['grade_table'],
				'grade_id_name'     => $params['grade_id_name'],
				'grade_amount'      => $params['grade_amount'],
				'grade_total'       => $params['grade_total'],
				'order_amount'      => $params['order_amount'],
				'grade_time'        => $params['grade_time'],
				'status'            => $params['status'],
				'grade_amount_rate' => $params['grade_amount_rate'],
				'order_hotel'       => $params['hotel_id'],
				'grade_rate_type'   => $params['grade_rate_type'],
				'hotel_id'          => $saler_info['hotel_id']);
		if($saler_val > 0){
			if($params['grade_total'] < 0){
				$grades_base['grade_total']       = $saler_val;
				$grades_base['grade_amount_rate'] = $saler_rate;
				$grades_base['grade_rate_type']   = $grade_settings->excitation_type;
			}
			$this->_db('iwide_rw')->insert('distribute_grade_all',$grades_base);
			$last_insert_id = $this->_db('iwide_rw')->insert_id();
			$grades_info['distribute'] = $saler_info['is_distributed'];
			$this->_db('iwide_rw')->insert('distribute_grade_ext',$grades_info);
		}
		if($group_val > 0){
			$grades_base['saler'] = -3;
			$grades_base['grade_total'] = $group_val;
			$this->_db('iwide_rw')->insert('distribute_grade_all',$grades_base);
			$last_insert_id = $this->_db('iwide_rw')->insert_id();
			$this->_db('iwide_rw')->insert('distribute_grade_ext',$grades_info);
		}
		if($hotel_val > 0){
			$grades_base['saler'] = -2;
			$grades_base['grade_total'] = $hotel_val;
			$this->_db('iwide_rw')->insert('distribute_grade_all',$grades_base);
			$last_insert_id = $this->_db('iwide_rw')->insert_id();
			$this->_db('iwide_rw')->insert('distribute_grade_ext',$grades_info);
		}
		if($jfk_val > 0){
			$grades_base['saler'] = -1;
			$grades_base['grade_total'] = $jfk_val;
			$this->_db('iwide_rw')->insert('distribute_grade_all',$grades_base);
			$last_insert_id = $this->_db('iwide_rw')->insert_id();
			$this->_db('iwide_rw')->insert('distribute_grade_ext',$grades_info);
		}
		return true;
	}
	
	/**
	 * 写入新绩效记录
	 * @param Array $fans_info 粉丝身份信息数组
	 * @param Array $saler_info 分销员身份信息数组
	 * @param Array $grades_info 绩效信息数组
	 * @param Array $params 绩效信息集数组
	 * @return boolean
	 */
	private function new_grade($fans_info,$saler_info,$grades_info,$params){
		/**
		 * -- @ex_type 商城激励0：每个订单金额百分比,1：每个订单激励固定金额
                  CASE IFNULL(@ex_type,0)
                        WHEN 0 THEN
                        SET @distribute_amount=NEW.total_fee;
                        SET @amount_total=NEW.total_fee*@ex_val*0.01;
                        WHEN 1 THEN
                        SET @distribute_amount=NEW.total_fee;
                        SET @amount_total=@ex_val;
                  END CASE;
                  SELECT `name`,`hotel_name`,`cellphone`,`is_distributed`,`hotel_id` INTO @staff_name,@hotel_name,@cellphone,@distributed,@hotel_id FROM iwide_hotel_staff WHERE qrcode_id=NEW.`saler` AND inter_id=NEW.`inter_id` limit 1;
                  INSERT INTO IWIDE_DISTRIBUTE_GRADE_ALL (`inter_id`,`saler`,`grade_openid`,`grade_id`,`grade_table`,`grade_id_name`,`grade_amount`,`grade_total`,`order_amount`,`grade_time`,`status`,`grade_amount_rate`,`grade_rate_type`,`hotel_id`) VALUES (NEW.`inter_id`,NEW.`saler`,NEW.`openid`,NEW.`order_id`,'iwide_shp_orders','id',@distribute_amount,@amount_total,NEW.total_fee,NOW(),1,@ex_val,@ex_type,@hotel_id);
                  SELECT LAST_INSERT_ID() INTO @last_id;
                  INSERT INTO IWIDE_DISTRIBUTE_GRADE_EXT (`hotel_name`,`staff_name`,`cellphone`,`product`,`order_id`,`grade_id`,`inter_id`,`distribute`) VALUES (@hotel_name,@staff_name,@cellphone,'商城商品',NEW.`out_trade_no`,@last_id,NEW.`inter_id`,@distributed);
                  UPDATE iwide_distribute_salers SET income=income+@ex_val WHERE saler=NEW.`saler` AND inter_id=NEW.`inter_id`;
		 * **/
		$grades_base = array('inter_id' => $params['inter_id'],
				'saler'             => isset($params['saler']) && !empty($params['saler']) ? $params['saler'] : $saler_info['qrcode_id'],
				'grade_openid'      => $params['grade_openid'],
				'grade_id'          => "{$params['grade_id']}",
				'grade_table'       => $params['grade_table'],
				'grade_id_name'     => $params['grade_id_name'],
				'grade_amount'      => isset($params['grade_amount']) ? $params['grade_amount'] : 0,
				// 'grade_total'       => $params['grade_total'],
				'order_amount'      => isset($params['order_amount']) ? $params['order_amount'] : 0,
				'status'            => $params['status'],
				// 'grade_amount_rate' => $params['grade_amount_rate'],
				// 'grade_rate_type'   => $params['grade_rate_type'],
				'order_hotel'       => isset($params['hotel_id']) ? $params['hotel_id'] : -1,
				'order_status'      => isset($params['order_status']) ? $params['order_status'] : 0,
				'grade_typ'         => $params['grade_typ'],
				'order_time'        => empty($params['order_time']) ? date('Y-m-d H:i:s') : $params['order_time'],
				'hotel_id'          => $saler_info['hotel_id']);
		if(isset($params['status']) && $params['status'] < 3){
			$grades_base['grade_time'] = empty($params['grade_time'])?date('Y-m-d H:i:s'):$params['grade_time'];
		}
		if(empty($params['grade_total']) || $params['grade_total'] < 0){
			$grade_settings = $this->get_grades_settings($params['inter_id'], $params['grade_table']);
			if(isset($grade_settings->excitation_category) && $grade_settings->excitation_category == 0){
				$params['grade_total'] = $params->grade_amount * $grade_settings->excitation_value * 0.01;
			}elseif(isset($grade_settings->excitation_category) && $grade_settings->excitation_category == 1){
				$params['grade_total'] = $grade_settings->excitation_value;
			}
			$grades_base['grade_total']       = isset($params['grade_total']) ? $params['grade_total'] : 0;
			$grades_base['grade_amount_rate'] = isset($grade_settings->excitation_value) ? $grade_settings->excitation_value : 0;
			$grades_base['grade_rate_type']   = isset($grade_settings->excitation_type) ? $grade_settings->excitation_type : 0;
		}else{
			$grades_base['grade_total']       = isset($params['grade_total']) ? $params['grade_total'] : 0;
			$grades_base['grade_amount_rate'] = isset($params['grade_amount_rate']) ? $params['grade_amount_rate'] : 0;
			$grades_base['grade_rate_type']   = isset($params['grade_rate_type']) ? $params['grade_rate_type'] : 0;
		}
		// if($saler_val > 0){
// 			if(empty($params['grade_total']) || $params['grade_total'] < 0){
// 			}

			if(isset($params['fans_hotel'])){
				$grades_base['fans_hotel'] = $params['fans_hotel'];
			}
			if(isset($params['hotel_rate'])){
				$grades_base['hotel_rate'] = $params['hotel_rate'];
			}
			if(isset($params['group_rate'])){
				$grades_base['group_rate'] = $params['group_rate'];
			}
			if(isset($params['jfk_rate'])){
				$grades_base['jfk_rate'] = $params['jfk_rate'];
			}
			if(isset($params['hotel_grades'])){
				$grades_base['hotel_grades'] = $params['hotel_grades'];
			}
			if(isset($params['group_grades'])){
				$grades_base['group_grades'] = $params['group_grades'];
			}
			if(isset($params['jfk_grades'])){
				$grades_base['jfk_grades'] = $params['jfk_grades'];
			}
			$this->_db('iwide_rw')->insert('distribute_grade_all',$grades_base);
			$last_insert_id = $this->_db('iwide_rw')->insert_id();
			$grades_info['distribute'] = $saler_info['is_distributed'];
			$grades_info['grade_id']   = $last_insert_id;
			$this->_db('iwide_rw')->insert('distribute_grade_ext',$grades_info);
			if(isset($params['hotel_grades']) && $params['hotel_grades'] > 0){
				$grades_base_hotel = $grades_base;
				$grades_base_hotel['grade_total'] = $params['hotel_grades'];
				$grades_base_hotel['saler'] = -3;
				$this->_db('iwide_rw')->insert('distribute_grade_all',$grades_base_hotel);
				$last_insert_id = $this->_db('iwide_rw')->insert_id();
				$grades_info['grade_id']   = $last_insert_id;
				$this->_db('iwide_rw')->insert('distribute_grade_ext',$grades_info);
			}
			if(isset($params['group_grades']) && $params['group_grades'] > 0){
				$grades_base_group = $grades_base;
				$grades_base_group['grade_total'] = $params['group_grades'];
				$grades_base_group['saler'] = -2;
				$this->_db('iwide_rw')->insert('distribute_grade_all',$grades_base_group);
				$last_insert_id = $this->_db('iwide_rw')->insert_id();
				$grades_info['grade_id']   = $last_insert_id;
				$this->_db('iwide_rw')->insert('distribute_grade_ext',$grades_info);
			}
			if(isset($params['jfk_grades']) && $params['jfk_grades'] > 0){
				$grades_base_jfk = $grades_base;
				$grades_base_jfk['grade_total'] = $params['jfk_grades'];
				$grades_base_jfk['saler'] = -1;
				$this->_db('iwide_rw')->insert('distribute_grade_all',$grades_base_jfk);
				$last_insert_id = $this->_db('iwide_rw')->insert_id();
				$grades_info['grade_id']   = $last_insert_id;
				$this->_db('iwide_rw')->insert('distribute_grade_ext',$grades_info);
			}
			
		// }
		return true;
	}
	/**
	 * 查询绩效规则设定
	 * @param string $inter_id 公众号身份唯一编号
	 * @param string $type 绩效分类
	 * @return Query row result
	 */
	public function get_grades_settings($inter_id,$type){
		$this->_db('iwide_r1')->where(array('inter_id'=>$inter_id,'excitation_category'=>$type));
		$this->_db('iwide_r1')->limit(1);
		return $this->_db('iwide_r1')->get('distribute_config')->row();
	}
	/**
	 * 查询订单是否首次离店
	 * @param string $inter_id 公众号身份唯一编号
	 * @param string $order_id 订单号
	 * @return boolean
	 */
	private function is_order_first_cout($inter_id,$order_id){
		$sql = 'SELECT COUNT(*) nums FROM '.$this->_db('iwide_r1')->dbprefix('hotel_order_items').' WHERE inter_id=? AND orderid=? AND istatus=3';
		$query_res = $this->_db('iwide_r1')->query($sql, array($inter_id,$order_id))->row();
		return (!$query_res || $query_res->num >1);
	} 
	/**
	 * 查询子订单间夜数，当天入住当天离店返回1
	 * @param string $inter_id 公众号身份唯一编号
	 * @param string $order_item_id 子订单编号
	 * @return int
	 */
	private function get_order_date_span($inter_id,$order_item_id){
		$sql = 'SELECT DATEDIFF(NEW.enddate,NEW.startdate) dsp FROM '.$this->_db('iwide_r1')->dbprefix('hotel_order_items').' WHERE inter_id=? AND id=?';
		$this->_db('iwide_r1')->limit(1);
		$rs = $this->_db('iwide_r1')->query($sql,$inter_id,$order_item_id)->row();
		return $rs->dsp == 0 ? 1 : $rs->dsp;
	}
	/**
	 * 查询订单是否已经计算绩效
	 * @param string $inter_id 公众号身份唯一编号
	 * @param string $grade_table 绩效类型
	 * @param string $grade_id 订单编号
	 * @return boolean
	 */
	public function grades_order_exist($inter_id,$grade_table,$grade_id,$grade_typ){
		$sql = 'SELECT COUNT(*) nums FROM iwide_distribute_grade_all WHERE grade_table=? AND grade_id=? AND inter_id=? AND grade_typ=?';
		$rs = $this->_db('iwide_r1')->query($sql,array($grade_table,"{$grade_id}",$inter_id,$grade_typ));
		if($rs)$rs = $rs->row();
		return (isset($rs->nums) && $rs->nums > 0);
	}
	
	/**
	 * 更新绩效状态
	 * @param string $inter_id 公众号身份唯一编号
	 * @param string $grade_table 绩效类型
	 * @param string $grade_id 订单号
	 * @param int $status 状态
	 */
	private function update_grade_status($inter_id,$grade_table,$grade_id,$status){
		$this->_db('iwide_rw')->where(array('inter_id'=>$inter_id,'grade_table'=>$grade_table,'grade_id'=>"{$grade_id}"));
		return $this->_db('iwide_rw')->update('distribute_grade_all',array('status'=>$status));
	}
	
	/**
	 * 把一个绩效记录改成已核定状态
	 * @param string $inter_id 公众号身份唯一编号
	 * @param string $grade_table 绩效类型
	 * @param string $grade_id 订单编号
	 */
	public function audit_grade($inter_id,$grade_table,$grade_id){
		$grade = $this->get_single_grade_base($inter_id, $grade_table, $grade_id);
		if(!empty($grade) && $grade->status !=2){
			return $this->update_grade_status($inter_id, $grade_table, $grade_id, 1);
		}else{
			return false;
		}
	}
	
	/**
	 * 取得一个绩效项的基础信息
	 * @param string $inter_id 公众号身份唯一编号
	 * @param string $grade_table 绩效类型
	 * @param string $grade_id 订单编号
	 */
	public function get_single_grade_base($inter_id,$grade_table,$grade_id,$grade_typ=1){
		$this->_db('iwide_r1')->where(array('inter_id'=>$inter_id,'grade_table'=>$grade_table,'grade_id'=>"{$grade_id}",'grade_typ'=>$grade_typ));
		$this->_db('iwide_r1')->limit(1);
		$re = $this->_db('iwide_r1')->get('distribute_grade_all');

		return $re ? $re->row() : null;
	}
	
	/**
	 * 发放配置
	 * @param unknown $inter_id 公众号身份唯一编号，为空时返回全部公众号配置信息
	 */
	public function get_deliver_setting($inter_id = ''){
		if (! empty ( $inter_id )) {
			if (is_array ( $inter_id ))
				$this->_db ( 'iwide_r1' )->where_in ( 'inter_id', $inter_id );
			else
				$this->_db ( 'iwide_r1' )->where ( array ('inter_id' => $inter_id ) );
			$this->_db ( 'iwide_r1' )->limit ( 1 );
			return $this->_db ( 'iwide_r1' )->get ( 'distribute_deliver_config' )->row ();
		} else {
			return $this->_db ( 'iwide_r1' )->get ( 'distribute_deliver_config' )->result ();
		}
	}
	
	/**
	 * 更新发放配置
	 * @param Array $params 新配置数组
	 */
	public function set_deliver_setting($params){
		if(!isset($params['inter_id'])){
			return FALSE;
		}
		$this->_db('iwide_r1')->where(array('inter_id'=>$params['inter_id']));
		$this->_db('iwide_r1')->limit(1);
		if($this->_db('iwide_r1')->get('distribute_deliver_config')->num_rows()){
			$this->_db('iwide_rw')->where(array('inter_id'=>$params['inter_id']));
			return $this->_db('iwide_rw')->update('distribute_deliver_config',$params);
		}else{
			return $this->_db('iwide_rw')->insert('distribute_deliver_config',$params);
		}
	}
	
	/**
	 * 更新分销发放账号设置
	 * 
	 * @param array|string $inter_ids        	
	 * @param boolean $update_all        	
	 * @return boolean
	 */
	public function update_setting_deliver($inter_ids, $update_all = FALSE) {
		$this->_db ( 'iwide_rw' )->trans_begin ();
		if ($update_all) {
			$this->_db ( 'iwide_rw' )->update ( 'distribute_deliver_config', array ( 'deliver' => 1 ) );
		}
		if (is_array ( $inter_ids ))
			$this->_db ( 'iwide_rw' )->where_in ( 'inter_id', $inter_ids );
		else
			$this->_db ( 'iwide_rw' )->where ( 'inter_id', $inter_ids );
		$this->_db ( 'iwide_rw' )->update ( 'distribute_deliver_config', array ( 'deliver' => 2 ) );
		if ($this->_db ( 'iwide_rw' )->trans_status() === FALSE) {
			$this->_db ( 'iwide_rw' )->trans_rollback ();
			return FALSE;
		} else {
			$this->_db ( 'iwide_rw' )->trans_commit ();
			return TRUE;
		}
	}
	
	/**
	 * 绩效详细信息
	 * @param string $inter_id 公众号身份唯一编号
	 * @param int $grade_id 订单编号
	 */
	public function get_grade_details($inter_id,$grade_id){
		$sql = 'SELECT ga.grade_time,ge.product,ge.hotel_name,ge.order_id,f.nickname,f.headimgurl FROM iwide_distribute_grade_all ga INNER JOIN iwide_distribute_grade_ext ge ON ga.inter_id=ge.inter_id AND ga.id=ge.grade_id LEFT JOIN iwide_fans f ON f.openid=ga.grade_openid AND f.inter_id=ga.inter_id WHERE ga.id=? AND ga.inter_id=?';
		return $this->_db('iwide_r1')->query($sql,array($grade_id,$inter_id))->row();
	}
	/**
	 * 取绩效队列表待处理的信息 
	 */
	public function get_grade_queue(){
		$this->_db('iwide_r1')->where(array('flag'=>0));
		$this->_db('iwide_r1')->limit(1000);
		return $this->_db('iwide_r1')->get('distribute_grade_queue');
	}
	
	/**
	 * 处理分销绩效队列
	 */
	public function deal_queue(){
		$queues = $this->get_grade_queue ()->result ();
		foreach ( $queues as $grade ) {
			$rec_contnet = json_decode ( $grade->rec_content, TRUE );
			if(empty($rec_contnet['order_time'])){
				$rec_contnet['order_time'] = $grade->rec_time;
			}
			//首单奖励检查，符合推送首单奖励绩效到队列表
			$this->check_first_order_reward($rec_contnet);
			$this->_create_grade ( $rec_contnet );
			$this->_db('iwide_rw')->trans_begin ();
			
			$this->_db('iwide_rw')->where(array('id'=>$grade->id));
			$this->_db('iwide_rw')->update('distribute_grade_queue',array('deal_time'=>date('Y-m-d H:i:s'),'flag'=>1));
			
			if ($this->_db('iwide_rw')->trans_status () === FALSE) {
				$this->_db('iwide_rw')->trans_rollback ();
				continue;
			} else {
				$this->_db('iwide_rw')->trans_commit ();
				continue;
			}
		}
	}

	/*situguanchen@mofly.cn 20161207
	*首单奖励检查（订房or商城）
	*/
	public function check_first_order_reward($param = array(),$type = 1){//默认查绩效表
		//只是订房和商城
		$array = array('iwide_hotels_order' ,
					'iwide_soma_sales_order:default',
					'iwide_soma_sales_order:groupon', 
					'iwide_soma_sales_order:killsec', 
					'iwide_soma_mooncake_order:default', 
					'iwide_shp_orders'
				);
		if(in_array($param['grade_table'],$array)){//符合类型
			if($param['status'] == 1){//当是已核定状态时，查是否有设首单奖励规则
				$this->write_log(array('inter_id'=>$param['inter_id'],'param'=>$param),'','','开始检查是否符合首单');
				//记录日志
				$this->load->model ( 'distribute/firstorder_reward_model' );
				$rules = $this->firstorder_reward_model->check_the_first_order_rule($param['inter_id']);
				if(!empty($rules)){//规则存在
					foreach($rules as $value){
						$first_order = 0;
						$reward = $order_id = $hotel_id = $amount = 0;
						$openid = $saler_id='';
						if($value['type'] == 1 || $value['type'] == 3){//订房首单
							if($param['grade_table'] == 'iwide_hotels_order'){//订房
									//先查出粉丝openid
									$sql = "select grade_openid,hotel_id,saler,order_amount from iwide_distribute_grade_all where inter_id = '{$param['inter_id']}' and grade_table = 'iwide_hotels_order' and grade_id = '{$param['grade_id']}' limit 1";
									$query = $this->_db('iwide_r1')->query($sql)->row();
									$openid = $query->grade_openid;
									$saler_id = $query->saler;
									$hotel_id = $query->hotel_id;
									$amount = $query->order_amount;
									/*$this->load->model('distribute/fans_model');
									$fans_info  = $this->fans_model->get_fans_beloning($param['inter_id'],$openid);
									if(isset($fans_info->source) && !empty($fans_info->source)){
										$saler_id = $fans_info->source;
									}*/
								if(!empty($openid) && !empty($saler_id)){
									//去查询是否是首单 
									if($value['type'] == 1){
										$sql = "select count(*) as cc from iwide_distribute_grade_all where inter_id = '{$param['inter_id']}' and grade_table = 'iwide_hotels_order' and grade_openid = '{$openid}' and (status = 1 or status = 2)";
									}else{
										$sql = "select count(*) as cc from iwide_distribute_grade_all where inter_id = '{$param['inter_id']}' and grade_table in ('".implode("','", $array)."') and grade_openid = '{$openid}' and (status = 1 or status = 2)";
									}
									$count = $this->_db('iwide_r1')->query($sql)->row()->cc;
									if($count < 1){//是首单
										$first_order = 1;//首单
										//根据规则奖励 推送一条记录到队列中
										//计算绩效金额
										//查询订单信息
										$sql = "select iprice,startdate,enddate,orderid from iwide_hotel_order_items where orderid = (select orderid from iwide_hotel_order_items where id = {$param['grade_id']} and inter_id = '{$param['inter_id']}') and inter_id = '{$param['inter_id']}'";
										$order = $this->_db('iwide_r1')->query($sql)->result_array();
										if(!empty($order)){
											$order_id = $order[0]['orderid'];
											if($value['reward_type'] == 1){//按订单
												$reward = $value['reward'];
											}elseif($value['reward_type'] == 2){//订房按间夜
												$night_count = 0;
												foreach($order as $ov){
													/*$tmp_room = round(strtotime($ov['enddate']) - strtotime($ov['startdate'])) / 86400;
                            						$tmp_room = $tmp_room <= 0 ? 1 : $tmp_room;//间夜数*/
                            						$tmp_room = get_room_night($ov['startdate'],$ov['enddate'],'round',$ov);
                            						$night_count += $tmp_room;
												}
												$reward = $night_count*$value['reward'];
											}elseif($value['reward_type'] == 3){//按订单金额百分比
												foreach($order as $ov){
													$amount += $ov['iprice'];
												}
												$reward = $amount*$value['reward']/100;
											}

										}
									}else{
										$this->write_log(array('inter_id'=>$param['inter_id'],'grade_openid'=>$openid,'orderid'=>$order_id,'saler_id'=>$saler_id),'','','不符合首单sql:'.$sql);
									}
								}else{
									$this->write_log(array('inter_id'=>$param['inter_id']),'','','openid'.$openid.'或saler_id'.$saler_id.'为空');
								}
								
							}
						}
						if($value['type'] == 2 || $value['type'] == 3){//商城首单
							if($param['grade_table'] != 'iwide_hotels_order'){
								//先查出粉丝openid
								if(isset($param['grade_openid'])){
									$openid = $param['grade_openid'];
									//$saler_id = $param['saler'];
									$hotel_id = isset($param['hotel_id'])?$param['hotel_id']:-1;
									$amount = isset($param['order_amount'])?$param['order_amount']:0;
								}else{
									$sql = "select grade_openid,hotel_id,saler,grade_typ,order_amount from iwide_distribute_grade_all where inter_id = '{$param['inter_id']}' and grade_table = '{$param['grade_table']}' and grade_id = '{$param['grade_id']}' limit 1";
									$query = $this->_db('iwide_r1')->query($sql)->result_array();
									if(!empty($query)){
										$openid = $query[0]['grade_openid'];
										$hotel_id = $query[0]['hotel_id'];
										$amount = $query[0]['order_amount'];
									}
								}
								$this->load->model('distribute/fans_model');
								$fans_info = $this->fans_model->get_fans_beloning($param['inter_id'],$openid);
								if(isset($fans_info->source) && !empty($fans_info->source)){
									$saler_id = $fans_info->source;
									if($hotel_id == -1){
										$hotel_id = isset($fans_info->hotel_id)?$fans_info->hotel_id:'-1';
									}
								}
								if(!empty($openid) && !empty($saler_id)){
									//去查询是否是首单 
									if($value['type'] == 2){
										$sql = "select count(*) as cc from iwide_distribute_grade_all where inter_id = '{$param['inter_id']}' and grade_table in('iwide_soma_sales_order:default','iwide_soma_sales_order:groupon', 'iwide_soma_sales_order:killsec', 'iwide_soma_mooncake_order:default', 'iwide_shp_orders') and grade_openid = '{$openid}' and (status = 1 or status = 2)";
									}else{
										$sql = "select count(*) as cc from iwide_distribute_grade_all where inter_id = '{$param['inter_id']}' and grade_table in ('".implode("','", $array)."') and grade_openid = '{$openid}' and (status = 1 or status = 2)";
									}
									$count = $this->_db('iwide_r1')->query($sql)->row()->cc;
									if($count < 1){//是首单
										$first_order = 1;//首单
										$order_id = $param['grade_id'];
										//根据规则奖励 推送一条记录到队列中
										if($value['reward_type'] == 1){//按订单
											$reward = $value['reward'];
										}elseif($value['reward_type'] == 3){//订单百分比
											if(isset($param['order_amount'])){
												$reward = $param['order_amount']*$ov['reward']/100;
											}else{
												$reward = $amount*$ov['reward']/100;
											}
										}
									}else{
										$this->write_log(array('inter_id'=>$param['inter_id'],'grade_openid'=>$openid,'orderid'=>$order_id,'saler_id'=>$saler_id),'','','不符合首单sql:'.$sql);
									}
								}else{
									$this->write_log(array('inter_id'=>$param['inter_id']),'','','openid'.$openid.'或saler_id'.$saler_id.'为空');
								}
							}
						}
						//如果符合首单，推送绩效
						if($first_order){
							//记录下产生首单绩效奖励的订单信息
							$arr = array();
							$arr['reward_id'] = $value['id'];
							$arr['inter_id'] = $param['inter_id'];
							$arr['status'] = 1;
							$arr['type'] = $value['type'];
							$arr['reward'] = $reward;
							$arr['order_id'] = $order_id;
							$arr['grade_id'] = "{$param['grade_id']}";
							$arr['add_time'] = date('Y-m-d H:i:s');
							$this->db->insert('firstorder_reward_log',$arr);
							$insertid = $this->db->insert_id();
							$this->write_log($arr,array('insert_id'=>$insertid),'','记录首单奖励的订单信息');
							//组装绩效数组
							$data = array();
							$product = '';
							if($value['type']==1){
								$product = '订房';
							}elseif($value['type']==2){
								$product = '商城';
							}elseif($value['type']==3){
								$product = '订房或商城';
							}
		                    $data['inter_id'] = $param['inter_id'];
		                    $data['grade_openid'] = $openid;
		                    $data['grade_id_name'] = 'id';
		                    $data['grade_table'] = 'iwide_firstorder_reward';//类型
		                    $data['grade_id'] = $insertid;//奖励日志表的id
		                    $data['saler'] = $saler_id;
		                    $data['order_amount'] = $amount;//订单金额
		                    $data['remark'] = $data['product'] = $product.'首单绩效奖励';
		                    $data['order_id'] = $order_id;
		                    $data['grade_time'] = $data['order_time'] =  date('Y-m-d H:i:s');
		                    $data['grade_total'] = $reward;//根据上面的计算得出
		                    $data['grade_typ'] = 1;//粉丝归属为1
		                    $data['status'] = 1;//先设定为这个状态
		                    $data['hotel_id'] = $hotel_id;
		                    //var_dump($data);die;
		                    $this->create_grade($data);
		                    $this->write_log($data,array('推送到绩效队列表'),'');
						}
					}
				}
			}
		}
	}

	/**
	 * 按时间取指定公众号指定酒店的分销产生的间夜数、交易额和绩效总额
	 * @param Array $inter_id 公众号唯一编码，为空时取全部公众号
	 * @param Array $hotel_id 酒店ID数组，为空时取全部酒店
	 * @param string $date_begin 起始时间，默认前一个月1号
	 * @param string $date_end 结束时间，默认当月1号
	 * @return Query Row
	 */
	public function get_distribute_room_nights_with_grades($inter_id = array(),$hotel_id = array(),$date_begin = '',$date_end = ''){
		if(empty($date_begin)){
			$date_begin = date('Y-m-01',strtotime('-1 month'));
		}
		if(empty($date_end)){
			$date_end = date('Y-m-01');
		}
		$sql = "SELECT SUM(a.grade_total) gas,SUM(IF(DATEDIFF(i.enddate,i.startdate)=0,1,DATEDIFF(i.enddate,i.startdate)))ds,SUM(i.iprice) trans_amounts FROM iwide_distribute_grade_all a INNER JOIN iwide_hotel_order_items i ON a.inter_id=i.inter_id AND a.grade_id=i.id WHERE a.saler>0 AND a.grade_table='iwide_hotels_order'";
		if(!empty($inter_id)){
			$sql .= " AND a.inter_id IN ?";
			$param[] = $inter_id;
			//只有inter_id不为空才添加hotel_id判断
			if(!empty($hotel_id)){
				$sql .= " AND a.hotel_id IN ?";
				$param[] = $hotel_id;
			}
		}
		$sql .= " AND order_time>=?";
		$param[] = $date_begin;
		$sql .= " AND order_time<?";
		$param[] = $date_end;
		$query = $this->_db('iwide_r1')->query($sql,$param)->row();
		return $query;
	}
	
	/**
	 * 按时间取指定公众号指定酒店的分销产生的商品数、交易额和绩效总额
	 * @param Array $inter_id 公众号唯一编码，为空时取全部公众号
	 * @param Array $hotel_id 酒店ID数组，为空时取全部酒店
	 * @param string $date_begin 起始时间，默认前一个月1号
	 * @param string $date_end 结束时间，默认当月1号
	 * @return Query Row
	 */
	public function get_distribute_products_counts_with_grades($inter_id = array(),$hotel_id = array(),$date_begin = '',$date_end = ''){
		if(empty($date_begin)){
			$date_begin = date('Y-m-01',strtotime('-1 month'));
		}
		if(empty($date_end)){
			$date_end = date('Y-m-01');
		}
		$sql = "SELECT SUM(a.grade_total) gas,SUM(i.counts)ds,SUM(i.actually_paid) trans_amounts FROM iwide_distribute_grade_all a INNER JOIN iwide_mall_order_summary i ON a.inter_id=i.inter_id AND a.grade_id=i.order_id AND substr(a.grade_table ,1,10)='iwide_soma'";
		if(!empty($inter_id)){
			$sql .= " AND a.inter_id IN ?";
			$param[] = $inter_id;
			//只有inter_id不为空才添加hotel_id判断
			if(!empty($hotel_id)){
				$sql .= " AND a.hotel_id IN ?";
				$param[] = $hotel_id;
			}
		}
		$sql .= " AND grade_time>=?";
		$param[] = $date_begin;
		$sql .= " AND grade_time<?";
		$param[] = $date_end;
		return $this->_db('iwide_r1')->query($sql,$param)->row();
	}
	
	/**
	 * 当前公众号指定时间内产生的员工绩效
	 * @param string $inter_id 公众号唯一编号
	 * @param string $begin_date 起始时间
	 * @param string $end_date 结束时间
	 * @return number
	 */
	public function get_ps_grades_amount($inter_id,$begin_date = '',$end_date = ''){
		$sql = "SELECT SUM(grade_total) total_amount FROM iwide_distribute_grade_all WHERE inter_id=? AND (`status`=1 OR `status`=2 OR `status`=9) AND saler > 0";
		$params[] = $inter_id;
		if(!empty($begin_date)){
			$sql .= " AND grade_time>=?";
			$params[] = $begin_date;
		}
		if(!empty($end_date)){
			$sql .= " AND grade_time<?";
			$params[] = $end_date;
		}
		$query = $this->_db('iwide_r1')->query($sql,$params)->row();
		return is_null($query->total_amount) ? 0 : $query->total_amount;
	}
	
	/**
	 * 取员工佣金总额，已发放佣金总额，产生绩效的公众号的数量
	 * @param string $inter_id 公众号唯一识编号
	 * @param string $begin_time 起始时间
	 * @param string $end_time 结束时间
	 */
	public function get_saler_grades_all($inter_id = array(),$begin_time = '',$end_time = ''){
		$sql = "SELECT SUM(IF(`status`=1 OR `status`=2 OR `status`=9,grade_total,0)) grade_total,SUM(IF(`status`=2,grade_total,0)) send_total,COUNT(DISTINCT inter_id) hotel_count FROM iwide_distribute_grade_all WHERE saler>0";
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
		if(!empty($begin_time)){
			$sql .= " AND grade_time>=?";
			$params[] = $begin_time;
		}
		if(!empty($end_time)){
			$sql .= " AND grade_time<?";
			$params[] = $end_time;
		}
		$query = $this->_db('iwide_r1')->query($sql,$params)->row();
		return $query;
	}
	/**
	 * 取员工佣金总额，已发放佣金总额，产生绩效的酒店的数量
	 * @param Array $inter_id 公众号唯一识编号
	 * @param string $begin_time 起始时间
	 * @param string $end_time 结束时间
	 * @return Object Query-Result
	 */
	public function get_saler_grades_group_by_inter_id($inter_id = array(),$begin_time = '',$end_time = ''){
		$sql = "SELECT inter_id,SUM(IF(`status`=1 OR `status`=2 OR `status`=9,grade_total,0)) grade_total,SUM(IF(`status`=1 OR `status`=2 OR `status`=9,grade_amount,0)) grade_amount,SUM(IF(`status`=2,grade_total,0)) send_total,COUNT(DISTINCT hotel_id) hotel_count FROM iwide_distribute_grade_all WHERE saler>0";
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
		if(!empty($begin_time)){
			$sql .= " AND order_time>=?";
			$params[] = $begin_time;
		}
		if(!empty($end_time)){
			$sql .= " AND order_time<?";
			$params[] = $end_time;
		}
		$sql .= " GROUP BY inter_id";
		return $this->_db('iwide_r1')->query($sql,$params)->result();
// 		$query = $this->_db('iwide_rw')->query($sql,$params)->result();
// 		echo $this->_db('iwide_r1')->last_query();
// 		echo '<br />';
// 		return $query;
	}
	
	/**
	 * 根据条件查询产生交易绩效的酒店数
	 * @param string $inter_id 酒店
	 * @param string $begin_time 起始时间
	 * @param string $end_time 结束时间
	 */
	public function get_hotel_counts_with_records($inter_id = '',$begin_time = '',$end_time = ''){
		$sql = "SELECT inter_id,COUNT(DISTINCT hotel_id) counts FROM iwide_distribute_grade_all";
		$where = '';
		$params = array();
		if(!empty($inter_id)){
			$where .= " WHERE inter_id=?";
			$params[] = $inter_id;
		}
		if(!empty($begin_time)){
			if(empty($where)){
				$where .= " WHERE grade_time>=?";
			}else{
				$where .= " AND grade_time>=?";
			}
			$params[] = $begin_time;
		}
		if(!empty($end_time)){
			if(empty($where)){
				$where .= " WHERE grade_time<?";
			}else{
				$where .= " AND grade_time<?";
			}
			$params[] = $end_time;
		}
		$sql = $sql.$where;
		$sql .= ' GROUP BY inter_id';
		$query = $this->_db('iwide_r1')->query($sql,$params)->result();
		$res = array();
		foreach ($query as $item){
			$res[$item->inter_id] = $item->counts;
		}
		return $res;
	}
	/**
	 * 获取公众号下的酒店数
	 * @param string $inter_id 公众号唯一识别编号
	 * @return number 数量
	 */
	public function get_hotel_counts($inter_id){
		$this->_db('iwide_r1')->where(array('inter_id'=>$inter_id,'status'=>1));
		$this->_db('iwide_r1')->select('COUNT(hotel_id) counts');
		$query = $this->_db('iwide_r1')->get('hotels')->row();
// 		echo $this->_db('')
		return is_null($query) ? 0 : $query->counts;
	}
	/**
	 * 取指定条件的公众号的编号名称
	 * @param Array $inter_id 公众号唯一识别编号
	 * @return multitype:NULL 
	 */
	public function get_hotel_counts_hash($inter_id = array()){
		$sql = "SELECT inter_id,COUNT(hotel_id) counts FROM iwide_hotels WHERE `status`=1";
		$params = array();
		if(!empty($inter_id) && $inter_id != 'ALL_PRIVILEGES'){
			if(is_array($inter_id))
				$sql .= " AND inter_id IN ?";
			else 
				$sql .= " AND inter_id=?";
			$params[] = $inter_id;
		}
		$sql .= " GROUP BY inter_id";
		$query = $this->_db('iwide_r1')->query($sql,$params)->result();
		$res = array();
		foreach ($query as $item){
			$res[$item->inter_id] = $item->counts;
		}
		return $res;
	}
	
	private function write_log( $order,$result,$re,$msg = '')
	{
		$file= date('Y-m-d'). '.txt';
		//echo $tmpfile;die;
		$path= APPPATH.'logs'.DS. 'grades'. DS;
		
		if( !file_exists($path) ) {
			@mkdir($path, 0777, TRUE);
		}

		//echo $tmpfile;die;
		// $path= APPPATH.'logs'.DS. 'mysql_log'. DS;
		if(is_array($order)){
			$order=json_encode($order);
		}
		if(is_array($result)){
			$result=json_encode($result);
		}
		if(is_array($re) || is_object($re)){
			$re=json_encode($re);
		}
		$fp = fopen($path.$file, "a");
		//echo __FILE__
		$content = date("Y-m-d H:i:s")." | ".getmypid()." | ".$_SERVER['PHP_SELF']." | ".session_id()." | ".$order." | ".$re." | ".$result." | ".$msg."\n";
	
		fwrite($fp, $content);
		fclose($fp);
	}
}