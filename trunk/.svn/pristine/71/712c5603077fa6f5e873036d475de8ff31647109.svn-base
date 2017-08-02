<?php 
class Getcenter extends CI_Model{
	const TABLE_GETCARD  = 'member_level_conf';
	
	protected $table_fields = array('id','interid','hotleid','level',);
	
	/**
	 * 根据场景获取会员的等级
	 * @param unknown $inter_id
	 * @param unknown $hotel_id
	 * @param unknown $level
	 */
	public function getLevelInfo($inter_id,$hotel_id,$level)
	{
		$readAdapter = $this->load->database('member_read',true);
		
		$query = $readAdapter->from(self::TABLE_GETCARD)
		    ->select("*")
		    ->where('interid', $inter_id)
		    ->where('hotleid',$hotel_id)
		    ->where('level',$level)
		    ->get();
		return $query->result();
	}
	
}