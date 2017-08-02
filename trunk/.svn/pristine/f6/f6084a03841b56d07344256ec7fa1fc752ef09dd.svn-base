<?php
class Keyword_record_model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}
	
	function log_record($array){
		return $this->db->insert('keyword_record',$array);
	}
	
	function get_new_record(){
		/* set_time_limit(0);
		$find_new = TRUE;
		//直到有新的数据才返回
		while($find_new){
			sleep(3);
			
		} */
		$this->db->select('r.*,f.nickname customer_name');
		$this->db->from('keyword_record r');
		$this->db->join('fans f','f.openid=r.openid and f.inter_id=r.inter_id','left');
		$this->db->where(array('r.status'=>0,'r.p_id'=>0));
		// $this->db->where_in('r.inter_id',array('a434678028','a434677894','a431058562'));
		// $this->db->where(array('r.status'=>0,'r.p_id'=>0,'r.inter_id'=>'a429262687'));
		return $this->db->get();
	}
	
	function update_status($ids,$status = 1){
		$this->db->where_in('id',$ids);
		return $this->db->update('keyword_record',array('status'=>$status));
	}
	
	function get_record($record_id){
		$this->db->where('id',$record_id);
		return $this->db->get('keyword_record');
	}
}//End of keyword_record_model.php