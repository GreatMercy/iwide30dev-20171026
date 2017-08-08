<?php 
class Marketcoderule extends CI_Model
{
	const TABLE_MARKETCODE_RULE   = 'iwide_member_marketcode_get_rule';
	
	/**
	 * 根据mc_id获取规则
	 * @param unknown $mc_id
	 * @return unknown
	 */
	public function getMcRuleByMcId($mc_id)
	{
		$readAdapter = $this->load->database('member_read',true);
	
		$query = $readAdapter->from(self::TABLE_MARKETCODE_RULE)
		    ->where('mc_id', $mc_id)
		    ->get();
		
		$rule = $query->row();
		
		$rule->module = unserialize($rule->module);
		$rule->condition = unserialize($rule->condition);
		
		return $rule;
	}
	
	/** 
	 * 根据规则检测营销码是否可用
	 * @param unknown $openid
	 * @param unknown $module
	 * @param unknown $inter_id
	 * @param unknown $code
	 * @param unknown $params
	 * @return boolean
	 */
	public function checkMarketCodeByRule($openid, $module, $inter_id, $code, $params=array())
	{	
		$this->load->model('member/getmarketcode');
		$codeModel = $this->getmarketcode->getMarketCodeByCode($code);
		
		if(!$codeModel) return false;
		
		$rule = $this->getMcRuleByMcId($codeModel->mc_id);
		
		if(!$rule) return false;
		
		if((isset($rule->module[0]) && $rule->module[0] != 'all') && !in_array($module,$rule->module)) return false;

		//过滤产品
		if(!empty($this->condition['product'])) {
			if(!isset($params['product']) || !in_array($params['product'],$this->condition['product'])) return false;
		}

		//过滤消费金额满
		if(isset($rule->condition['consume_balance_up'])) {
			if(!isset($params['amount']) && $params['amount']<$rule->condition['consume_balance_up']) {
				return false;
			}
		}
			
		//过滤积分满
		if(isset($rule->condition['consume_bonus_up'])) {
			if(!isset($params['bonus']) || $params['bonus']<$rule->condition['consume_bonus_up']) {
				return false;
			}
		}
			
		//过滤订单满足几个商品
		if(isset($rule->condition['consume_product_up'])) {
			if(!isset($params['product_num']) || $params['product_num']<$rule->condition['consume_product_up']) {
				return false;
			}
		}
		
		try {
			if(isset($params['is_use']) && $params['is_use']) {
				$is_use = true;
			} else {
				$is_use = false;
			}
		    $result = $codeModel->useMarketcode($code, $openid, $is_use, $params);
		} catch(Exception $e) {
			return false;
		}
		
		if($result) {
			$this->load->model('member/marketcode');
			return $this->marketcode->getMarketcode($codeModel->mc_id);
		} else {
			return false;
		}
	}
}