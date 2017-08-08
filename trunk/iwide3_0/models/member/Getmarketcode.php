<?php 
class Getmarketcode extends CI_Model
{
	const OPENID_LENGTH            =  28;
	const TABLE_MARKETCODE_GET     =  'member_marketcode_get';
	
	const STATUS_NORMAL = 0;//还没被使用的状态
	const STATUS_USED   = 1;//已经被使用的状态
	
	protected $fields;
	
	/**
	 * 根据条件获取营销码列表
	 * @param unknown $mc_id
	 * @param string $openid
	 * @param unknown $select
	 */
	public function getMarketcodes($mc_id, $openid='', $select=array())
	{
		$readAdapter = $this->load->database('member_read',true);
		
		if($select) {
			$readAdapter->select(implode(',',$select));
		}
		
		if(!empty($openid)) $readAdapter->where('openid', $openid);
		
		$query = $readAdapter->from(self::TABLE_MARKETCODE_GET)
		    ->where('mc_id', $mc_id)
		    ->get();
		
		return $query->query();
	}
	
	/**
	 * 使用营销码
	 * @param unknown $code
	 * @param unknown $openid
	 * @param unknown $data
	 * @throws Exception
	 * @return unknown
	 */
	public function useMarketcode($code, $openid, $is_use=false, $data = array())
	{
		$codeModel = $this->getMarketCodeByCode($code);
		
		if(!$codeModel) throw new Exception("营销码不存在!");
		
		$this->load->model('member/marketcode');
		$marketcodeModel = $this->marketcode->getMarketcode($codeModel->mc_id);
		
		if($codeModel->status==self::STATUS_USED) {
			throw new Exception("营销码已经被使用!");
		}
		
		if($marketcodeModel->user_bind && (!$codeModel->openid || $codeModel->openid != $openid)) {
			throw new Exception("营销码用户不正确!");
		}
		
		if($marketcodeModel->begin_time>time() || $marketcodeModel->end_time<time()) {
			throw new Exception("该营销码超过使用有效期！");
		}
		
		if($is_use) {
			$data['code']   = $code;
			if(!$marketcodeModel->user_bind) $data['openid'] = $openid;
			$data['status'] = self::STATUS_USED;
			$result = $this->updateMarketcodeByCode($data);
			
			return $result;
		}
		
		return true;
	}
	
	/**
	 * 根据code更新营销码的状态
	 * @param unknown $data
	 * @throws Exception
	 * @return unknown|boolean
	 */
	public function updateMarketcodeByCode($data)
	{
		try {
			if($this->checkData($data)) {
				$codeModel = $this->getMarketCodeByCode($data['code']);
	
				if($codeModel) {
					$writeAdapter = $this->load->database('member_write',true);
					unset($data['code']);
					$result = $writeAdapter->update(self::TABLE_MARKETCODE_GET, $data, array('code' => $data['code']));
	
					return $result;
				} else {
					throw new Exception("Code为".$data['code']."的营销码不存在!");
				}
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	
		return false;
	}

	/**
	 * 获取营销码
	 * @param unknown $mc_id
	 * @param unknown $num
	 * @param string $openid
	 * @throws Exception
	 * @return unknown|boolean
	 */
	public function sendMarketcode($mc_id, $num, $inter_id, $openid='')
	{
		try {
			if(!empty($openid) && !$this->checkOpenid($openid)) {
				throw new Exception("OpenID非法!");
			}
			
			$this->load->model('member/marketcode');
			$marketcodeModel = $this->marketcode->getMarketcode($mc_id);
			
			if(!$marketcodeModel || !isset($marketcodeModel->mc_id)) {
				throw new Exception("营销码不存在");
			}
			
			if($marketcodeModel->user_bind && empty($openid)) {
				throw new Exception("缺少OpenID");
			}
			
			if(!$marketcodeModel->is_active) {
				throw new Exception("该营销码已经停止使用！");
			}
			
			if(!empty($marketcodeModel->total_quantity)) {
				if($marketcodeModel->quantity<$num) throw new Exception("该营销码库存用完！");
			}
			
			if($marketcodeModel->begin_time>time() || $marketcodeModel->end_time<time()) {
				throw new Exception("该营销码超过使用有效期！");
			}
			
// 			if(!empty($marketcodeModel->get_limit) && !empty($openid)) {
// 				$codes = $this->getMarketcodes($mc_id, $openid, array('gm_id'));
				
// 				if(count($codes)>=$marketcodeModel->get_limit) throw new Exception("每个人只能领取".$marketcodeModel->get_limit."个营销码!");
// 			}
			
			$codes = $this->createCodes($num);
			if(empty($codes)) throw new Exception("create code more than 10 times!");
			
		    try {
		    	$writeAdapter = $this->load->database('member_write',true);
		    	$writeAdapter->trans_begin();
		    	
		    	foreach($codes as $code) {
		    		if(!$marketcodeModel->user_bind) $openid='';
		    		
		    		$id = $this->createMarketcodeget(array('mc_id'=>$mc_id,'inter_id'=>$inter_id,'openid'=>$openid,'code'=>$code));
		    		if(!$id) throw new Exception("插入数据库失败！");
		    	}
				
		    	if ($writeAdapter->trans_status() === FALSE) {
		    		$writeAdapter->trans_rollback();
		    		return false;
		    	} else {
		    		if(!empty($marketcodeModel->total_quantity)) $marketcodeModel->reduceInventory($mc_id,$num);
		    		$writeAdapter->trans_commit();
		    		return $codes;
		    	}
			} catch (Exception $e) {
				    $writeAdapter->trans_rollback();
					throw new Exception($e->getMessage());
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		
		return false;
	}
	
	/**
	 * 生成code记录
	 * @param unknown $data
	 * @throws Exception
	 * @return boolean
	 */
	public function createMarketcodeget($data)
	{
		try {
			if($this->checkData($data,true)) {
				$writeAdapter = $this->load->database('member_write',true);
				$writeAdapter->insert(self::TABLE_MARKETCODE_GET,$data);
				return $writeAdapter->insert_id();
			} else {
				throw new Exception("输入数据非法!");
			}
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	
		return false;
	}
	
	/**
	 * 获取唯一的code
	 * @param unknown $num
	 * @return multitype:|Ambigous <multitype:, multitype:string >|multitype:string
	 */
	protected function createCodes($num)
	{
		static $time=0;
		$time++;
		
		if($time>=10) return array();
		
		$codes = array();
		
		for($i=0;$i<$num;$i++) {
			$codes[] = $this->createNoncestr();
		}
		
		if(count($codes)) {
			$result = $this->checkUniqueCode($codes);
			
			if(!$result) {
				return $this->createCodes($num);
			}
		}
		
		return $codes;
	}
	
	/**
	 * 根据code获取记录
	 * @param unknown $code
	 */
	public function getMarketCodeByCode($code)
	{
		$readAdapter = $this->load->database('member_read',true);
		
		$query = $readAdapter->from(self::TABLE_MARKETCODE_GET)
		    ->where('code', $code)
		    ->get();
		
		return $query->row();
	}
	
	/**
	 * 检测code是否存在重复的
	 * @param unknown $codes
	 * @return boolean
	 */
	protected function checkUniqueCode($codes)
	{
		$readAdapter = $this->load->database('member_read',true);
		
		$query = $readAdapter->from(self::TABLE_MARKETCODE_GET)
		    ->where_in('code', $codes)
		    ->get();
		
		$result = $query->result();
		
		if($result) return false;
	}
	
	/**
	 * 生成随机字符串
	 * @param number $length
	 * @return string
	 */
	protected function createNoncestr($length = 8) {
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$str = "";
		for($i=0; $i<$length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
		}
		return $str;
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
		}
		
		if(isset($data['inter_id'])) {
			if(!preg_match("/a[0-9]{9}/i",$data['inter_id'])) {
				return false;
			}
		}
	
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
	 * 检测openid是否合法
	 * @param unknown $openid
	 * @return boolean
	 */
	protected function checkOpenid($openid) {
		if(empty($openid)) {
			return false;
		}
	
		if(strlen($openid) != self::OPENID_LENGTH) {
			return false;
		}
	
		return true;
	}
	
	/**
	 * 获取表字段
	 * @return Ambigous <multitype:, unknown>
	 */
	protected function getTableFields()
	{
		$ignoreFields = array('gm_id'=>1,'create_time'=>1,'update_time'=>1);
	
		if(!isset($this->fields)) {
			$readAdapter = $this->load->database('member_read',true);
			$fields = $readAdapter->list_fields(self::TABLE_MARKETCODE_GET);
				
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