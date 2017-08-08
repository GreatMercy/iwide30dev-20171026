<?php 
class Marketcode extends CI_Model
{
	const OPENID_LENGTH        =  28;
	const TABLE_MARKETCODE     =  'member_marketcode';
	
	protected $fields;
	
	public static function getTypes()
	{
		return array(
			'cash_reduce'=>'现金扣减',
		);
	}
	
	/**
	 * 创建营销码
	 * @param unknown $data
	 * @throws Exception
	 * @return boolean
	 */
	public function createMarketcode($data)
	{
		try {	
			if($this->checkData($data,true)) {
				$writeAdapter = $this->load->database('member_write',true);
				return $writeAdapter->insert(self::TABLE_MARKETCODE,$data);
			} else {
				throw new Exception("输入数据非法!");
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	
		return false;
	}
	
	/**
	 * 根据ID获得营销码
	 * @param unknown $mc_id
	 * @param unknown $select
	 */
	public function getMarketcode($mc_id, $select=array())
	{
		$readAdapter = $this->load->database('member_read',true);
	
		if($select) {
			$readAdapter->select(implode(',',$select));
		}
		
		$query = $readAdapter->from(self::TABLE_MARKETCODE)->where(array('mc_id' => $mc_id))->get();
		return $query->row();
	}
	
	/**
	 * 根据ID删除营销码
	 * @param unknown $mc_id
	 * @throws Exception
	 */
	public function deleteMarketcode($mc_id)
	{
		$object = $this->getMarketcode($mc_id);
	
		if(!$object) {
			throw new Exception("ID为".$mc_id."的营销码不存在!");
		}
	
		$writeAdapter = $this->load->database('member_write',true);
		$writeAdapter->delete(self::TABLE_MARKETCODE, array('mc_id' => $mc_id));
	
		return $writeAdapter->affected_rows();
	}
	
	/**
	 * 扣减库存
	 * @param unknown $mc_id
	 * @param unknown $num
	 * @throws Exception
	 * @return number|boolean
	 */
	public function reduceInventory($mc_id,$num)
	{
		$mc_id = intval($mc_id);
		$num   = intval($num);
	
		try {
			$object = $this->getMarketcode($mc_id);
	
			if($object) {
				if(empty($object->total_quantity)) return $num;
				if(!empty($object->total_quantity) && (empty($object->quantity) || $object->quantity<$num)) throw new Exception("库存不足!");
				
				$writeAdapter = $this->load->database('member_write',true);
				$writeAdapter->query("UPDATE ".$writeAdapter->dbprefix(self::TABLE_MARKETCODE)." SET `quantity`=`quantity`-".$num." WHERE `mc_id`=".$mc_id);
				return $writeAdapter->affected_rows();
			} else {
				throw new Exception("ID为".$mc_id."的营销码不存在!");
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	
		return false;
	}
	
	/**
	 * 检测数据是否合法
	 * @param array $data
	 * @param bool $new 是否新建数据
	 *
	 * @return bool
	 */
	protected function checkData(&$data, $new = false)
	{
		$this->_filterData($data);
	
		if($new) {
			$data['create_time']  = date('Y-m-d H:i:s',time());
			//total_quantity初始库存
			//quantity现有库存
			$data['quantity'] = intval($data['total_quantity']);
		}
	
		if(isset($data['is_active'])) {
			if($data['is_active'] != 1) {
				$data['is_active'] = 0;
			}
		}
		
		if(isset($data['inter_id'])) {
			if(!preg_match("/a[0-9]{9}/i",$data['inter_id'])) {
				return false;
			}
		}
	
		if(isset($data['begin_time'])) $data['begin_time'] = strtotime($data['begin_time']);
		if(isset($data['end_time']))   $data['end_time']   = strtotime($data['end_time']);
	
		return true;
	}
	
	/**
	 * 过滤不需要的字段
	 * @param array
	 * @param string type member|info
	 */
	protected function _filterData(&$data)
	{
		$toDelKeys = array_diff(array_keys($data),$this->getTableFields());
	
		if($toDelKeys) {
			foreach($toDelKeys as $key) {
				unset($data[$key]);
			}
		}
	}
	
	/**
	 * 获取表字段
	 * @return Ambigous <multitype:, unknown>
	 */
	protected function getTableFields()
	{
		$ignoreFields = array('mc_id'=>1,'create_time'=>1,'update_time'=>1);
	
		if(!isset($this->fields)) {
			$readAdapter = $this->load->database('member_read',true);
			$fields = $readAdapter->list_fields(self::TABLE_MARKETCODE);
				
			$this->fields = array();
			foreach ($fields as $field)
			{
				if(isset($ignoreFields[$field])) continue;
				$this->fields[] = $field;
			}
		}
	
		return $this->fields;
	}
}