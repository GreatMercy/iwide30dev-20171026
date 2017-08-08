<?php
class Order_queues_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	const TAB_HOQ = 'hotel_order_queues';
	//拉起支付时，插入队列
	function create_queue($inter_id,$hotel_id,$orderid,$pay_paras){
		$db_read = $this->load->database('iwide_r1',true);
		$row = $db_read->where(array('inter_id'=>$inter_id,'hotel_id'=>$hotel_id,'orderid'=>$orderid,'type'=>1))->get ( self::TAB_HOQ )->row_array ();
		if($row){
			return true;
		}
		$time =time();
		if(isset($pay_paras['outtime']) && $pay_paras['outtime']>=6 && $pay_paras['outtime']<=30){
			$out_time = $pay_paras['outtime'] * 60 + $time;
		}else{
			$out_time = 900 + $time;//默认15分钟超时
		}
		$data = array(
			'inter_id'=>$inter_id,
			'hotel_id'=>$hotel_id,
			'orderid'=>$orderid,
			'create_time'=>$time,
			'type'=>1,//微信支付待处理
			'flag'=>2,//未处理完成
			'out_time'=>$out_time,
		);
		return $this->db->insert ( self::TAB_HOQ, $data );
	}

	//pms订单入账失败时，插入队列
	function create_pms_queue($inter_id,$hotel_id,$orderid,$ex_data){
		$db_read = $this->load->database('iwide_r1',true);
		$row = $db_read->where(array('inter_id'=>$inter_id,'hotel_id'=>$hotel_id,'orderid'=>$orderid,'type'=>2))->get ( self::TAB_HOQ )->row_array ();
		if($row){
			return true;
		}
		$time =time();
		$data = array(
			'inter_id'=>$inter_id,
			'hotel_id'=>$hotel_id,
			'orderid'=>$orderid,
			'create_time'=>$time,
			'type'=>2,//pms待处理
			'flag'=>2,//未处理完成
			'ex_data'=>json_encode($ex_data),
		);
		return $this->db->insert ( self::TAB_HOQ, $data );
	}

	//支付成功或已取消，标记已处理队列
	function cancel_queue($inter_id,$hotel_id,$orderid){
		$time =time();
		$updata = array(
			'flag'=>1,//已处理完成
			'update_time'=>$time
		);
		$this->db->where ( array (
			'type'=>1,//微信支付待处理
			'inter_id' => $inter_id,
			'hotel_id'=>$hotel_id,
			'orderid'=>$orderid,
		) );
		return $this->db->update ( self::TAB_HOQ, $updata );
	}

	//获取超时待处理队列
	function get_queues(){
		$time =time();
		$db_read = $this->load->database('iwide_r1',true);
		$db_read->where ( array (
			'type'=>1,//微信支付待处理
			'flag'=>2,//未处理完成
			'out_time <'=>$time,
			'oper_times <'=>3,//操作次数小于3
		) );
		return $db_read->get ( self::TAB_HOQ )->result_array ();
	}

	//记录操作次数
	function set_deal_time($inter_id,$hotel_id,$orderid)
	{
		$this->db->set('oper_times', 'oper_times+1',false);
		$this->db->where ( array (
			'inter_id' => $inter_id,
			'hotel_id'=>$hotel_id,
			'orderid'=>$orderid,
		) );
		return $this->db->update ( self::TAB_HOQ );
	}
	//获取超时时间
	function get_over_time($orderid){
		$time =time();
		$db_read = $this->load->database('iwide_r1',true);
		$db_read->select('out_time');
		$db_read->where ( array (
			'type'=>1,//微信支付待处理
			'flag'=>2,//未处理完成
			'out_time >'=>$time,
			'orderid'=>$orderid,
		) );
		$row = $db_read->get ( self::TAB_HOQ )->row_array ();
		if(empty($row)) return 0;
		return $row['out_time']-$time;
	}
}