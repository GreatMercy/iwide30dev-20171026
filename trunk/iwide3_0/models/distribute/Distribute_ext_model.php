<?php
/**
 * 全民分销
 * @author John
 * @since 2016-09-08
 * @package models\distribute
 */
class Distribute_ext_model extends MY_Model{

	function __construct(){
		parent::__construct();
	}

	/**
	 * 激活粉丝分销员身份
	 * @todo 全民分销激活粉丝分销员身份
	 * @param string $inter_id 公众号唯一识别编号
	 * @param string $openid 粉丝的OPENID
	 * @param int $fans_id 粉丝的编号
	 * @return boolean
	 */
	public function do_active_fans($inter_id,$openid,$fans_id = NULL){
		// TODO Insert iwide_openid_inter_id_rel
		$this->load->model ( 'distribute/openid_rel_model' );
		if(empty($fans_id)){
			$query = $this->get_fans_info($inter_id,$openid,'openid');
			if(isset($query->fans_key))
				$fans_id = $query->fans_key;
			else {
				$this->load->model('wx/publics_model');
				$this->publics_model->get_wxuser_info($inter_id,$openid);
				$query = $this->get_fans_info($inter_id,$openid,'openid');
				$fans_id = $query->fans_key;
			}
		}
		$qrcode_json = $this->get_wx_temp_qrcode ( $inter_id, $fans_id );
		$fans_info = array (
			'openid'      => $openid,
			'inter_id'    => $inter_id,
			'status'      => 2,
			'qrcode_url'  => isset ( $qrcode_json->ticket ) ? 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $qrcode_json->ticket : '',
			'expire_time' => isset ( $qrcode_json->expire_seconds ) ? $qrcode_json->expire_seconds : 0,
			'actv_time'   => date ( 'Y-m-d H:i:s' )
		);
		return $this->openid_rel_model->update_rel_info ( $fans_info );
	}

	/**
	 * 根据指定条件取粉丝信息
	 * @param string $inter_id 公众号
	 * @param string $fans_id 条件值
	 * @param string $key 条件参数
	 * @return $SQL-Query-Row
	 */
	public function get_fans_info($inter_id,$fans_id,$key = 'fans_key'){
		$this->_db('iwide_r1')->where(array('inter_id'=>$inter_id,$key=>$fans_id));
		$this->_db('iwide_r1')->limit(1);
		return $this->_db('iwide_r1')->get('fans')->row();
	}
	/**
	 * 检索指定OPENID的分销身份信息
	 * @todo 全民分销检索指定OPENID的分销身份信息
	 * @param string $inter_id 公众号唯一识别编号
	 * @param string $openid 粉丝OPENID
	 * @return boolean 没有找到对应分销员的信息（传入的OPENID非分销员）返回FALSE,如果是全民分销的分销员返回<code>Array{'typ':'FANS','info':{'saler':'粉丝粉丝分销号','nickname':'','qrcode_url':''}}</code>,
	 * 如果是员工分销员身份返回<code>Array{'typ':'STAFF','info':{'saler':'员工分销号','nickname':'','qrcode_url':''}}</code>
	 */
	public function check_fans($inter_id,$openid,$rtn_json = TRUE){
		if($this->fans_is_staff($inter_id, $openid)){
			$this->load->model('distribute/staff_model');
			$info = $this->staff_model->saler_info($openid,$inter_id);
			$info['saler'] = $info['qrcode_id'];
			if($info['status'] == 2)
				return $rtn_json ? json_encode(array('typ'=>'STAFF','info'=>$info)) : array('typ'=>'STAFF','info'=>$info);
			return FALSE;
		}else{
			$this->load->model('distribute/openid_rel_model');
			$info = $this->openid_rel_model->get_openid_relationship($inter_id,$openid,'',TRUE);
			if($info && $info->status == 2){
				return $rtn_json ? json_encode(array('typ'=>'FANS','info'=>$info)) : array('typ'=>'FANS','info'=>$info);
			}
		}
		return FALSE;
	}

	/**
	 * 写入新的绩效记录，记录已经存在时只进行更新操作
	 * @param $params <pre>Array{inter_id      => 公众号唯一编号
	hotel_id      => 下单酒店编号
	saler         => 分销号
	grade_openid  => 下单人openid
	grade_table   => 绩效模块类型
	grade_id      => 订单唯一编号，有子单号优先子单号，有PMS单号优先PMS单号
	order_amount  => 订单金额
	grade_total   => 绩效金额
	grade_amount  => 参与绩效的金额
	status        => 绩效状态
	remark        => 备注
	order_hotel   => 下单酒店
	order_status  => 订单状态
	order_time    => 下单时间
	grade_rule    => 绩效规则
	grade_typ     => 绩效类型,1:粉丝归属,2:按次
	product_count => 商品数量
	product       => 产品名称}</pre>
	 * @return boolean
	 */
	public function create_dist($params){
		if(empty($params)){
			return FALSE;
		}else{
// 			if($this->fans_is_staff($params['inter_id'],$params['grade_openid'])){
// 				return false;
// 			}else {
			$grades_info = $this->is_grades_exist($params['inter_id'], $params['grade_id'], $params['grade_table'], $params['grade_typ'],TRUE);
			if(!$grades_info){
				$this->load->model('distribute/openid_rel_model');
				$fans_info = $this->get_fans_info($inter_id,$params['saler']);
				$info = $this->openid_rel_model->get_openid_relationship($params['inter_id'],$fans_info['openid']);
				if($info){
					$this->load->model('plugins/Template_msg_model');
					$this->Template_msg_model->send_fans_dist_msg(array('inter_id'=>$params['inter_id'],'openid'=>$info['openid'],'nickname'=>$info['nickname']),'fans_dist_new_grade');
				}
				return $this->_db('iwide_rw')->insert('distribute_extends',$params) > 0;
			}else{
				$update_result = $this->update_grades($params);
				if($update_result && $grades_info['status'] != 1 && $params['status'] == 1){
					$this->load->model('plugins/Template_msg_model');
					$this->Template_msg_model->send_fans_dist_msg(array('inter_id'=>$params['inter_id'],'openid'=>$info['openid'],'nickname'=>$info['nickname']),'fans_dist_grade_confirm');
				}
				return $update_result;
			}
// 			}
		}
		//TODO iwide_distribute_ext
	}

	public function get_salers($inter_id = array(),$act_time_begin = '',$act_time_end = '',$fans_id='',$nickname='',$limit = NULL,$offset=0){
		$sql = 'SELECT f.fans_key,oir.inter_id,oir.inter_id,f.nickname,f.subscribe_time,oir.actv_time
				FROM iwide_openid_inter_id_rel oir INNER JOIN iwide_fans f ON oir.inter_id=f.inter_id AND oir.openid=f.openid WHERE oir.status=2 ';
		$params = array();
		$where = '';
		if(!empty($inter_id) && $inter_id != 'ALL_PRIVILEGES'){
			if(is_array($inter_id))
				$where .= ' AND oir.inter_id IN ?';
			else
				$where .= ' AND oir.inter_id = ?';
			$params[] = $inter_id;
		}
		if(!empty($act_time_begin)){
			$where .= ' AND oir.actv_time>=?';
			$params[] = $act_time_begin;
		}
		if(!empty($act_time_end)){
			$where .= ' AND oir.actv_time<=?';
			$params[] = $act_time_end.' 23:59:59';
		}
		if(!empty($fans_id)){
			$where .= ' AND f.fans_key LIKE ?';
			$params[] = "%$fans_id%";
		}
		if(!empty($nickname)){
			$where .= ' AND f.nickname LIKE ?';
			$params[] = "%$nickname%";
		}
		$sql .= $where;
		$sql .= " GROUP BY oir.inter_id,f.fans_key ORDER BY f.fans_key DESC";
		if(!is_null($limit)){
			$sql .= " LIMIT ?,?";
			$params[] = $offset;
			$params[] = $limit;
		}
		return $this->_db('iwide_r1')->query($sql,$params);
	}
	public function get_salers_count($inter_id,$act_time_begin = '',$act_time_end = '',$fans_id='',$nickname=''){
		$sql = 'SELECT COUNT(DISTINCT f.fans_key) counts
				FROM iwide_openid_inter_id_rel oir INNER JOIN iwide_fans f ON oir.inter_id=f.inter_id AND oir.openid=f.openid WHERE oir.status=2';
		$params = array();
		$where = '';
		if(!empty($inter_id) && $inter_id != 'ALL_PRIVILEGES'){
			if(is_array($inter_id))
				$where .= ' AND oir.inter_id IN ?';
			else
				$where .= ' AND oir.inter_id = ?';
			$params[] = $inter_id;
		}
		if(!empty($act_time_begin)){
			$where .= ' AND oir.actv_time>=?';
			$params[] = $act_time_begin;
		}
		if(!empty($act_time_end)){
			$where .= ' AND oir.actv_time<=?';
			$params[] = $act_time_end.' 23:59:59';
		}
		if(!empty($fans_id)){
			$where .= ' AND f.fans_key LIKE ?';
			$params[] = "%$fans_id%";
		}
		if(!empty($nickname)){
			$where .= ' AND f.nickname LIKE ?';
			$params[] = "%$nickname%";
		}
		$query = $this->_db('iwide_r1')->query($sql)->row();
		return is_null($query->counts) ? 0 : $query->counts;
	}
	public function get_grades_summary($inter_id,$grade_typ = '',$saler_id = NULL,$grade_time_begin = NULL,$grade_time_end = NULL){
		$sql = "SELECT saler,inter_id,SUM(IF(`status`<2,grade_total,0)) grade_totals,SUM(`status`<2) counts FROM iwide_distribute_extends WHERE inter_id=?";
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

	public function get_grades($inter_id = array(),$order_time_begin = '',$order_time_end = '',$fans_id = '',$send_time_begin = '',$send_time_end = '',$send_status = '',$limit = NULL,$offset = 0){
		$sql = "SELECT de.saler,mos.order_time,mos.product,mos.order_id,mos.counts,mos.actually_paid,de.grade_total,de.send_time,de.`status`,de.remark FROM iwide_mall_order_summary mos RIGHT JOIN iwide_distribute_extends de ON de.inter_id=mos.inter_id AND de.grade_id=mos.order_id";
		$params = array();
		$where = '';
		if(!empty($inter_id) && $inter_id != 'ALL_PRIVILEGES'){
			if(is_array($inter_id))
				$where .= ' WHERE mos.inter_id IN ?';
			else
				$where .= ' WHERE mos.inter_id = ?';
			$params[] = $inter_id;
		}
		if(!empty($order_time_begin)){
			if(empty($where)){
				$where .= ' WHERE mos.order_time>=?';
			}else{
				$where .= ' AND mos.order_time>=?';
			}
			$params[] = $order_time_begin;
		}
		if(!empty($order_time_end)){
			if(empty($where)){
				$where .= ' WHERE mos.order_time<=?';
			}else{
				$where .= ' AND mos.order_time<=?';
			}
			$params[] = $order_time_end.' 23:59:59';
		}
		if(!empty($fans_id)){
			if(empty($where)){
				$where .= ' WHERE de.saler LIKE ?';
			}else{
				$where .= ' AND de.saler LIKE ?';
			}
			$params[] = "%$fans_id%";
		}
		if(!empty($send_time_begin)){
			if(empty($where)){
				$where .= ' WHERE de.send_time>=?';
			}else{
				$where .= ' AND de.send_time>=?';
			}
			$params[] = $send_time_begin;
		}
		if(!empty($send_time_end)){
			if(empty($where)){
				$where .= ' WHERE de.send_time<=?';
			}else{
				$where .= ' AND de.send_time<=?';
			}
			$params[] = $send_time_end.' 23:59:59';
		}
		if(!empty($send_status)){
			if(empty($where)){
				$where .= ' WHERE de.`status`=?';
			}else{
				$where .= ' AND de.`status`=?';
			}
			$params[] = $send_status;
		}
		$sql .= $where;
		$sql .= ' ORDER BY de.id DESC';
		if(!is_null($limit)){
			$sql .= " LIMIT ?,?";
			$params[] = $offset;
			$params[] = $limit;
		}
		$query= $this->_db('iwide_r1')->query($sql,$params);
// 		echo $this->_db('iwide_rw')->last_query();
		return $query;
	}
	public function get_grades_count($inter_id = array(),$order_time_begin = '',$order_time_end = '',$fans_id = '',$senf_time_begin = '',$send_time_end = '',$send_status = ''){
		$sql = "SELECT COUNT(de.id) counts FROM iwide_mall_order_summary mos RIGHT JOIN iwide_distribute_extends de ON de.inter_id=mos.inter_id AND de.grade_id=mos.order_id";
		$params = array();
		$where = '';
		if(!empty($inter_id) && $inter_id != 'ALL_PRIVILEGES'){
			if(is_array($inter_id))
				$where .= ' WHERE mos.inter_id IN ?';
			else
				$where .= ' WHERE mos.inter_id = ?';

			$params[] = $inter_id;
		}
		if(!empty($order_time_begin)){
			if(empty($where)){
				$where .= ' WHERE mos.order_time>=?';
			}else{
				$where .= ' AND mos.order_time>=?';
			}
			$params[] = $order_time_begin;
		}
		if(!empty($order_time_end)){
			if(empty($where)){
				$where .= ' WHERE mos.order_time<=?';
			}else{
				$where .= ' AND mos.order_time<=?';
			}
			$params[] = $order_time_end.' 23:59:59';
		}
		if(!empty($fans_id)){
			if(empty($where)){
				$where .= ' WHERE de.saler LIKE ?';
			}else{
				$where .= ' AND de.saler LIKE ?';
			}
			$params[] = "%$fans_id%";
		}
		if(!empty($send_time_begin)){
			if(empty($where)){
				$where .= ' WHERE de.send_time>=?';
			}else{
				$where .= ' AND de.send_time>=?';
			}
			$params[] = $send_time_begin;
		}
		if(!empty($send_time_end)){
			if(empty($where)){
				$where .= ' WHERE de.send_time<=?';
			}else{
				$where .= ' AND de.send_time<=?';
			}
			$params[] = $send_time_end.' 23:59:59';
		}
		if(!empty($send_status)){
			if(empty($where)){
				$where .= ' WHERE de.`status`=?';
			}else{
				$where .= ' AND de.`status`=?';
			}
			$params[] = $send_status;
		}
		$query = $this->_db('iwide_r1')->query($sql.$where,$params)->row();
		return is_null($query->counts) ? 0 : $query->counts;
	}

	/**
	 * 粉丝是否有效的分销员工
	 * @param string $inter_id 公众号编号
	 * @param string $openid OPENID
	 */
	private function fans_is_staff($inter_id,$openid){
		$this->load->model('distribute/staff_model');
		return $this->staff_model->saler_is_valid($inter_id,$openid);
	}
	/**
	 * 重新生成二维码
	 * @param unknown $temp_id
	 * @param unknown $inter_id
	 * @param unknown $expire_time
	 */
	private function refresh_qrcode($temp_id,$inter_id,$expire_time){
		//TODO iwide_temp_qrcode_logs
		//TODO iwide_openid_inter_id_rel
	}
	/**
	 * 临时二维码生成记录
	 * @param int $temp_id 临时二维码场景ID
	 * @param string $inter_id 公众号Id
	 * @param int $expire_time 有效时间(second)
	 * @param string $create_time 创建时间
	 * @return boolean
	 */
	private function set_qrcode_infos($temp_id,$inter_id,$expire_time,$create_time = NULL){
		if(is_null($create_time)){
			$create_time = time();
		}
		return $this->_db('iwide_rw')->insert('temp_qrcode_logs',array('temp_id'=>$temp_id,'create_time'=>$create_time,'inter_id'=>$inter_id,'expire_time'=>$expire_time)) > 0;
	}
	/**
	 * 获取生成的临时二维码的记录，默认返回最新的一条记录，通过https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$result->TICKET可以访问生成的二维码
	 * @param int $temp_id 临时二维码的ID
	 * @param int $offset 起始位置
	 * @param int $limit 取的长度
	 */
	private function get_qrcode_infos($temp_id,$offset=0,$limit=1){
		$this->_db('iwide_r1')->where(array('inter_id'=>$temp_id));
		$this->_db('iwide_r1')->order_by('id DESC');
		$this->_db('iwide_r1')->limit($offset,$limit);
		return $this->_db('iwide_r1')->get('temp_qrcode_logs')->result();
	}
	/**
	 * 检索绩效记录是否存在
	 * @param string $inter_id 公众号唯一编号
	 * @param string $grade_id 绩效订单编号
	 * @param string $grade_table 绩效模块类型
	 * @param int $grade_typ 绩效类型
	 * @return boolean TRUE|FALSE
	 */
	private function is_grades_exist($inter_id,$grade_id,$grade_table,$grade_typ,$return_row_info = FALSE){
		$this->_db('iwide_r1')->where(array('inter_id'=>$inter_id,'grade_id'=>$grade_id,'grade_table'=>$grade_table,'grade_typ'=>$grade_typ));
		$this->_db('iwide_r1')->limit(1);
		if($return_row_info){
			return $this->_db('iwide_r1')->get('distribute_extends')->num_rows() > 0;
		}else{
			return $this->_db('iwide_r1')->get('distribute_extends')->row();
		}
	}
	/**
	 * 更新绩效记录
	 * @param Array $params <pre>Array{$inter_id=>'',$grade_id=>'',$grade_table=>'',$grade_typ=>''[,$status=>''][,$grade_total][...]}</pre>
	 * @return boolean
	 */
	public function update_grades($params){
		if(empty($params['inter_id']) || empty($params['grade_id']) || empty($params['grade_table']) || empty($params['grade_typ'])){
			return FALSE;
		}
		$this->_db('iwide_rw')->where(array('inter_id'=>$params['inter_id'],'grade_id'=>$params['grade_id'],'grade_table'=>$params['grade_table'],'grade_typ'=>$params['grade_typ']));
		$fields= $this->_db('iwide_rw')->list_fields('distribute_extends');
		foreach ($params as $k=>$v){
			if (!in_array($k, $fields)) unset($params[$k]);
		}
		return $this->_db('iwide_rw')->update('distribute_extends',$params) > 0;
	}
	/**
	 * 生成带参数的临时二维码，返回二维码的链接和有效时间
	 * @param string $inter_id 公众号编号
	 * @param int $ticket_num 临时二维码场景ID
	 * @param int $expire_seconds 临时二维码有效时间
	 * @param string $continue_on_failed 遇到错误是否继续尝试生成
	 * @return JSON 正确时返回结果<pre>{"ticket":"gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==","expire_seconds":60,"url":"http:\/\/weixin.qq.com\/q\/kZgfwMTm72WWPkovabbI"}</pre>
	 * 错误时返回事例<pre>{"errcode":40013,"errmsg":"invalid appid"}</pre>
	 * @link http://mp.weixin.qq.com/wiki/18/167e7d94df85d8389df6c94a7a8f78ba.html
	 * @see wx\Qrcode_model
	 */
	private function get_wx_temp_qrcode($inter_id,$ticket_num,$expire_seconds = 2592000,$continue_on_failed = TRUE){
		$this->load->model ( 'wx/access_token_model' );
		$this->load->helper ( 'common' );
		$access_token = $this->access_token_model->get_access_token ( $inter_id );
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
		// 临时码
		$qrcode = '{"expire_seconds": 2592000,"action_name": "QR_SCENE","action_info": {"scene": {"scene_id": '.$ticket_num.'}}}';
		$output = json_decode (doCurlPostRequest ( $url, $qrcode ));

		if(isset($jsoninfo->errcode) && ($jsoninfo->errcode == '40014' || $jsoninfo->errcode == '42001') && $continue_on_failed){
			$this->access_token_model->reflash_access_token ( $inter_id );
			return $this->get_wx_temp_qrcode($inter_id, $ticket_num, FALSE);
		}
		$this->set_qrcode_infos($ticket_num, $inter_id, isset($jsoninfo->expire_time) ? $jsoninfo->expire_time : 0);
		return $output;
	}

	function send_grades_by_saler_yestoday($inter_id,$saler,$batch_no = ''){
		$this->load->model('distribute/grades_model');
		$deliver_config = $this->grades_model->get_deliver_setting($inter_id);
		$sql = 'SELECT gs.*,ds.openid FROM (SELECT SUM(grade_total) total,saler,inter_id,GROUP_CONCAT(id) ids FROM iwide_distribute_extends WHERE `status`=1 AND `inter_id`=? AND saler=? AND grade_time <? AND grade_time > ? GROUP BY saler) gs
				LEFT JOIN (SELECT * FROM iwide_fans WHERE inter_id=?)ds ON ds.inter_id=gs.inter_id AND ds.fans_key=gs.saler';
		$amount_query = $this->_db('iwide_r1')->query ( $sql,array($inter_id,$saler,date('Y-m-d 00:00:00'),$deliver_config->send_after_time,$inter_id) )->result_array ();
		$err_count = 0;
		$suc_count = 0;

		$deliver_id = '';
		if (isset ( $deliver_config->deliver ) && $deliver_config->deliver == 2) {
			$distribution_delier_account = $this->get_redis_key_status ( '__DISTRIBUTION_DELIER_ACCOUNT' );
			if ($distribution_delier_account)
				$deliver_id = $distribution_delier_account;
		}
		foreach ($amount_query as $amount_item){
			$amount = $amount_item ['total'];
			if ($amount < 0.01 || $amount > 2000) {
				$err_count++;
			} else {
				$this->load->model('pay/company_pay_model');
				// $up_param['last_update_time'] = date('Y-m-d H:i:s');
				if(isset($amount_item['saler']) && $amount_item['saler'] > 0){
					$flag = $this->company_pay_model->company_pay ( $amount_item ['openid'], $amount * 100 ,$inter_id,$amount_item['ids'],$amount_item['saler'],'绩效激励',$batch_no,$deliver_id,2);
					$this->load->model('distribute/distribute_notice_model');
					$msg = '<p>核定绩效截止时间：'.date('Y-m-d 23:59:59',strtotime('-1 day',time())).'</p><p>核定发放绩效金额：'.$amount.'</p><p>发放状态：';
					if(!empty($flag['rid'])){
						//写入发放关联订单数据
						$sql = "INSERT IGNORE INTO iwide_distri_sgrade_ext_rel (sr_id,ga_id) SELECT ?,id FROM iwide_distribute_extends WHERE inter_id=? AND saler=? AND `status`=1 AND grade_time<? AND grade_time >?";
						$this->_db('iwide_rw')->query($sql,array($flag['rid'],$inter_id,$saler,date('Y-m-d 00:00:00'),$deliver_config->send_after_time));
					}
					if ($flag['errmsg'] == 'ok') {
						$suc_count++;
						$up_param['status'] = 2;
						$up_param['partner_trade_no'] = $flag['partner_trade_no'];
						$up_param['send_time'] = date('Y-m-d H:i:s');
						$this->_db('iwide_rw')->where(array('inter_id'=>$inter_id,'saler'=>$saler,'status'=>1,'grade_time <'=>date('Y-m-d 00:00:00'),'grade_time >'=>$deliver_config->send_after_time));
						// 					$this->_db('iwide_rw')->where_in('id',$ids);
						if(!$this->_db('iwide_rw')->update ( 'iwide_distribute_extends', $up_param )){
							$this->set_redis_key_status('CONTINUE_DELIVER','false');
						}else{
							$this->set_redis_key_status('CONTINUE_DELIVER','true');
						}

						//发放系统消息
						$msg .= '成功</p><p>亲，绩效金额已发放至您的微信“钱包-零钱”中，请查看。再接再厉，多多的绩效等着您...</p>';
						$this->distribute_notice_model->create_deliver_notice_content($inter_id,$amount,date('Y-m-d 23:59:59',strtotime('-1 day',time())),$msg,$amount_item ['openid'],$batch_no,10);
					}else if($flag['errmsg'] == 'faild'){
						//记录发放失败次数
						$this->update_deliver_fails_by_saler($inter_id,$saler);
						//发放系统消息
						$msg .= '失败</p><p>亲，别着急，今天发放不成功，明天还会继续发放哦</p>';
						$msg .= '<p>失败原因：'.$flag['return_msg'].'</p>';
						$this->distribute_notice_model->create_deliver_notice_content($inter_id,$amount,date('Y-m-d 23:59:59',strtotime('-1 day',time())),$msg,$amount_item ['openid'],$batch_no,10);
						$err_count++;
					}else if($flag['errmsg'] == 'duplicate'){
						//加多一个重复的判断，不然都跑异常去了
					}else{
						//发放异常
						$up_param['status'] = 9;
						$up_param['send_time'] = date('Y-m-d H:i:s');
						$this->_db('iwide_rw')->where(array('inter_id'=>$inter_id,'saler'=>$saler,'status'=>1,'grade_time <'=>date('Y-m-d 00:00:00'),'grade_time>'=>$deliver_config->send_after_time));
						// 						$this->_db('iwide_rw')->update ( 'distribute_grade_all', $up_param );
						if(!$this->_db('iwide_rw')->update ( 'iwide_distribute_extends', $up_param )){
							$this->set_redis_key_status('CONTINUE_DELIVER','false');
						}else{
							$this->set_redis_key_status('CONTINUE_DELIVER','true');
						}
					}
				}
			}
		}
		return array('success'=>$suc_count,'error'=>$err_count);
	}
	/**
	 * 取有绩效未发放的分销员
	 * @param unknown $inter_id
	 * @param number $limit
	 * @param number $offset
	 */
	public function get_unsend_salers($inter_id,$limit=20,$offset=0){
		$sql = "SELECT ga.saler,hs.openid,ga.inter_id FROM iwide_distribute_extends ga LEFT JOIN iwide_openid_inter_id_rel hs ON ga.inter_id=hs.inter_id AND ga.saler=hs.fans_id WHERE ga.grade_total>0 AND ga.`status`=1 AND hs.openid<>'' AND hs.status=2 AND ga.inter_id=? GROUP BY saler";
		$params[] = $inter_id;
		if($limit > 0){
			$sql .= ' LIMIT ?,?';
			$params[] = $offset;
			$params[] = $limit;
		}
		return $this->_db('iwide_r1')->query($sql,$params)->result();
	}

	/**
	 * @todo 取上次发放时间不是今天的（发放完更新最后发放时间，发放时间是今天说明今天的绩效已经发放了）、循环周期到今天的、自动发放的、绩效金额大于0的分销员
	 */
	public function get_auto_deliver_salers(){
		//取上次发放时间不是今天的（发放完更新最后发放时间，发放时间是今天说明今天的绩效已经发放了）、循环周期到今天的、自动发放的、绩效金额大于0的分销员
		$sql = "SELECT dc.inter_id,ga.saler FROM iwide_distribute_deliver_config dc
				LEFT JOIN iwide_distribute_extends ga ON ga.inter_id=dc.inter_id
				LEFT JOIN iwide_openid_inter_id_rel hs ON ga.inter_id=hs.inter_id AND ga.saler=hs.fans_id
				WHERE dc.`mode`=0 AND DATEDIFF(NOW(),dc.last_send_time) >= dc.`cycle` AND dc.send_time<=? AND DATE_FORMAT(dc.last_send_time,'%Y-%m-%d')<>? AND ga.grade_total>0 AND ga.`status`=1 AND ga.grade_time<? AND ga.grade_time>dc.send_after_time AND hs.openid<>'' AND hs.status=2 AND ga.deliver_fail=0 GROUP BY saler";
		return $this->_db('iwide_r1')->query($sql,array(date('H:i:s'),date('Y-m-d'),date('Y-m-d 00:00:00')))->result();
		// 		 return $this->_db('iwide_rw')->query($sql,array(date('H:i:s'),'1970-01-01',date('Y-m-d H:i:s')))->result();
	}

	/**
	 * 更新最后发放时间
	 */
	public function update_last_deliver_time(){
		$sql = "UPDATE iwide_distribute_deliver_config dc,(SELECT count(*) counts,ga.inter_id FROM iwide_distribute_extends ga LEFT JOIN iwide_openid_inter_id_rel hs ON ga.inter_id=hs.inter_id AND ga.saler=hs.fans_id WHERE ga.grade_total>0 AND ga.`status`=1 AND hs.openid<>'' AND hs.status=2 GROUP BY ga.inter_id)a SET dc.last_send_time=NOW() WHERE a.inter_id=dc.inter_id AND a.counts = 0 AND date_format(dc.last_send_time,'%Y%m%d')<>?";
		$this->_db('iwide_rw')->query($sql,array(date('Ymd')));
	}

	/**
	 * 更新发放失败次数
	 * @param unknown $inter_id
	 * @param unknown $saler
	 */
	public function update_deliver_fails_by_saler($inter_id, $saler) {
		$sql = "UPDATE iwide_distribute_extends set deliver_fail=deliver_fail+1 WHERE grade_time<=? AND inter_id=? AND saler=?";
		return $this->_db('iwide_rw')->query ( $sql, array ( date ( 'Y-m-d 23:59:59', strtotime ( '-1 day', time () ) ), $inter_id, $saler ) );
	}
	/**
	 * 取分销员指定的时间绩效总额，不传时间则返回记录总额
	 * @todo 取分销员指定的时间绩效总额，不传时间则返回记录总额
	 * @param string $inter_id 公众号唯一识别信息
	 * @param int $saler 分销号
	 * @param string $date 时间 Y-m-d|date_type=DAY<br />Y-m|date_type=MONTH
	 * @param string $type  查询类型 NEW|已核定，未发放<br />OLD|已发放<br />ALL|已核定（包括未发放和已发放）<br />PRE|未核定<br />SEND|发放记录
	 * @param string $date_type 时间类型 DAY|MONTH
	 * @return Sql-Query-Row
	 */
	public function get_saler_grades_by_date($inter_id,$saler,$date=NULL,$type='ALL',$date_type='DAY'){
		$sql = "SELECT SUM(grade_total) total,COUNT(id) counts FROM iwide_distribute_extends WHERE inter_id=? AND saler=?";
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
		return $this->_db('iwide_r1')->query($sql,$params)->row();
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
		$sql = 'SELECT ga.*,f.nickname,f.headimgurl FROM iwide_distribute_extends ga LEFT JOIN iwide_fans f ON f.inter_id=ga.inter_id AND f.openid=ga.grade_openid WHERE ga.inter_id=? AND ga.saler=?';
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
	 * 重置60天内发放失败的绩效记录
	 */
	public function reset_fails_grades(){
		$sql = "UPDATE iwide_distribute_extends set deliver_fail=0 WHERE grade_time>? AND deliver_fail>0 AND status=1";
		$this->_db('iwide_rw')->query ( $sql, array ( date ( 'Y-m-d 23:59:59', strtotime ( '-60 day', time () ) ) ) );
		echo $this->_db('iwide_rw')->last_query();
	}
	protected function _load_cache( $name='Cache' ){
		if(!$name || $name=='cache')
			$name='Cache';
		$this->load->driver('cache', array('adapter' => 'redis', 'backup' => 'file', 'key_prefix' => 'dis_ato_'), $name );
		return $this->$name;
	}
	public function get_redis_key_status($key = 'CONTINUE_DELIVER'){
		$cache= $this->_load_cache();
		$redis= $cache->redis->redis_instance();
		return $redis->get( $key );
	}
	public function set_redis_key_status($key = 'CONTINUE_DELIVER',$val = 'false'){
		$cache= $this->_load_cache();
		$redis= $cache->redis->redis_instance();
		return $redis->set( $key , $val);
	}
}