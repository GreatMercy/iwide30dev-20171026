<?php
class Distribute_rules_model extends MY_Model {
	function __construct() {
		parent::__construct ();
	}
	const TAB_RULES = 'iwide_hotel_distribute_rules';
	function _load_db() {
		return $this->db;
	}
	function get_rule_list($inter_id, $rule_type = NULL, $status = NULL, $nums = NULL, $offset = NULL) {
		$db = $this->_load_db ();
		$db->order_by ( 'rule_id desc' );
		$db->where ( 'inter_id', $inter_id );
		is_null ( $status ) ? $db->where_in ( $status, array (
				1,
				2 
		) ) : $db->where ( 'status', $status );
		is_null ( $rule_type ) ?  : $db->where ( 'rule_type', $rule_type );
		is_null ( $nums ) ?  : $db->limit ( intval ( $nums ), intval ( $offset ) );
		return $db->get ( self::TAB_RULES )->result_array ();
	}
	function fields_config() {
		$user_operations = array (
				'rule_check' => array (
						'<a href="',
						'key' => site_url ( 'hotel/distribute/rule_check' ),
						'" class="btn btn-info btn-xs" title="查看"><i class="fa fa-file-o"></i>查看</a> '
				),
				'rule_edit' => array (
						'<a href="',
						'key' => site_url ( 'hotel/distribute/rule_edit' ),
						'" class="btn btn-success btn-xs" title="编辑"><i class="fa fa-edit"></i> 编辑</a>'
				)
		);
		$acl_array = $this->session->allow_actions;
		$acl_array = $acl_array [ADMINHTML];
		foreach ( $user_operations as $oper => $link ) {
			if (($acl_array != FULL_ACCESS) && (! isset ( $acl_array ['hotel'] ['distribute'] ) || ! in_array ( $oper, $acl_array ['hotel'] ['coupons'] ))) {
				unset ( $user_operations [$oper] );
			}
		}
		return array (
				'rule_id' => array (
						'label' => '规则编号' 
				),
				'rule_name' => array (
						'label' => '规则名称' 
				),
				'rule_type' => array (
						'label' => '规则类型',
						'select' => $this->enums ( 'rule_type' ) 
				),
				'excitation_type'=>array(
						'label'=>'激励方式',
						'select'=>$this->enums('excitation_type')
				),
				'status' => array (
						'label' => '状态',
						'select' => $this->enums ( 'status' ) 
				),
				'create_time' => array (
						'label' => '创建时间' 
				),
				'update_time' => array (
						'label' => '最后更新时间' 
				) ,
				'user_operations' => array (
						'label' => '操作',
						'user_operations' => $user_operations 
				) 
		);
	}
	function table_fields() {
		return array (
				'rule_id' => '',
				'rule_name' => '',
				'rule_type' => '',
				'conditions' => '',
				'rule_dates' => '',
				'excitation_type' => 1,
				'allocation' => '',
				'status' => 1 
		);
	}
	function enums($type) {
		switch ($type) {
			case 'status' :
				return array (
						'1' => '有效',
						'2' => '无效',
						'3' => '删除' 
				);
				break;
			case 'rule_type' :
				return array (
						'1' => '订房规则' 
				);
				break;
			case 'excitation_type' :
				return array (
						'1' => '优惠前房价百分比', 
						'2' => '优惠后房价百分比', 
						'3' => '每个订单激励固定金额', 
						'4' => '每间夜激励固定金额', 
				);
				break;
			default :
				break;
		}
	}
	function check_rule($inter_id, $rule_id, $rule_type = 1) {
		;
	}
	function get_rule($inter_id, $rule_id, $rule_type, $format = TRUE, $status = NULL) {
		$db = $this->_load_db ();
		$db->where ( array (
				'inter_id' => $inter_id,
				'rule_id' => $rule_id,
				'rule_type' => $rule_type 
		) );
		is_null ( $status ) ? $db->where_in ( $status, array (
				1,
				2 
		) ) : $db->where ( 'status', $status );
		$rule = $db->get ( self::TAB_RULES )->row_array ();
		if (! empty ( $rule ) && $format) {
			$rule ['conditions'] = json_decode ( $rule ['conditions'], TRUE );
			$rule ['rule_dates'] = json_decode ( $rule ['rule_dates'], TRUE );
			$rule ['allocation'] = json_decode ( $rule ['allocation'], TRUE );
			$rule ['rule_dates'] = empty($rule['rule_dates'])?array('',''):explode(',', $result['rule_dates']);
		}
		return $rule;
	}
}