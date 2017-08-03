<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Pay_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->paytype_not_show = array(
			'hotel'=>array('package')
		) ;
	}
	const TAB_PAP_PARAM = 'pay_params';
	const TAB_PAY_CONFIG = 'pay_config';
	const TAB_ENUM = 'enum_desc';
	const TAB_MODULE = 'modules';
	const TAB_PAY_LOG = 'pay_log';
	
	function get_pay_paras($inter_id, $type = 'weixin') {
		$paras = $this->db->get_where ( self::TAB_PAP_PARAM, array (
				'inter_id' => $inter_id,
				'pay_type' => $type 
		) )->result ();
		$result = array ();
		foreach ( $paras as $pa ) {
			$result [$pa->param_name] = $pa->param_value;
		}
		return $result;
	}
	function get_pay_way($condits = array(), $pay_days = array()) {
		$this->db->order_by ( 'sort desc' );
		$this->db->where ( array (
				'inter_id' => $condits ['inter_id'],
				'module' => $condits ['module'] 
		) );
		if (!empty ( $condits ['not_show'] ) && !empty($this->paytype_not_show[$condits['module']]) ){
			$this->db->where_not_in ( 'pay_type', $this->paytype_not_show[$condits['module']] );
		}
		empty ( $condits ['pay_type'] ) ?  : $this->db->where_in ( 'pay_type', $condits ['pay_type'] );
		empty ( $condits ['exclude_type'] ) ?  : $this->db->where_not_in ( 'pay_type', $condits ['exclude_type'] );
		empty ( $condits ['status'] ) ?  : $this->db->where ( 'status', $condits ['status'] );
		empty ( $condits ['hotel_ids'] ) ?  : $this->db->not_like ( 'no_hotels', ','.$condits ['hotel_ids'].',' );
		$result = $this->db->get ( self::TAB_PAY_CONFIG )->result ();
		if (! empty ( $condits ['check_day'] )) {
			$this->load->helper ( 'date' );
			foreach ( $result as $k => $r ) {
// 				if (! empty ( $r->no_days )) {
					$no_days = explode ( ',', $r->no_days );
					$no_hotels = explode ( ',', $r->no_hotels );
					if (check_date_in ( $no_days, $pay_days )&&in_array ( $condits ['hotel_ids'], $no_hotels )) {
						unset ( $result [$k] );
					}
// 				}
			}
			$result = array_values ( $result );
		}
// 		if (! empty ( $condits ['hotel_ids'] )) {
// 			foreach ( $result as $k => $r ) {
// 				if (! empty ( $r->no_hotels )) {
// 					$no_hotels = explode ( ',', $r->no_hotels );
// 					if (in_array ( $condits ['hotel_ids'], $no_hotels )) {
// 						unset ( $result [$k] );
// 					}
// 				}
// 			}
// 			$result = array_values ( $result );
// 		}
		if (isset ( $condits ['key'] ) && $condits ['key'] == 'value') {
			$data = array ();
			foreach ( $result as $r ) {
				$data [$r->pay_type] = $r;
			}
			return $data;
		}
		return $result;
	}
	function get_module_pay_config($inter_id, $module = array(), $status = null) {
		$way_sql = 'select * from ' . $this->db->dbprefix ( self::TAB_ENUM ) . ' where type="PAY_WAY" and status=1 and (inter_id = "defaultdes" or inter_id = "'.$inter_id.'")';
		$config_sql = 'select * from ' . $this->db->dbprefix ( self::TAB_PAY_CONFIG ) . " where inter_id='$inter_id'";
		if (! empty ( $module ))
			$config_sql .= ' and module in (' . implode ( ',', $module ) . ' )';
		if (! is_null ( $status ))
			$config_sql .= " and status =$status";
		$pay_config_sql = 'select c.*,e.des,e.code,m.* from ' . $this->db->dbprefix ( self::TAB_MODULE ) . " m 
						  join ($way_sql) e 
						   left join ($config_sql) c 
							on c.module=m.module and c.pay_type=e.code";
		$result = $this->db->query ( $pay_config_sql )->result_array ();
		$data = array ();
		
		foreach ( $result as $r ) {
			$data [$r ['module']] ['module_name'] = $r ['module_name'];
			$data [$r ['module']] ['pay_ways'] [$r ['code']] = $r;
			if (is_null ( $r ['pay_type'] )) {
				$data [$r ['module']] ['pay_ways'] [$r ['code']] ['status'] = 0;
				$data [$r ['module']] ['pay_ways'] [$r ['code']] ['pay_name'] = $r ['des'];
			}
		}
		//获取微信超时时间
		$data['hotel']['pay_ways']['weixin']['outtime'] = $this->get_weixin_outtime($inter_id);

		return $data;
	}
	function get_pay_link($pay_type) {
		switch ($pay_type) {
			case 'weixin' :
				return site_url ( 'wxpay' );
				break;
			case 'weifutong' :
				return site_url ( 'wftpay' );
				break;
			case 'lakala' :
			case 'lakala_y' :
				return site_url ( 'lakalapay' );
				break;
			case 'unionpay' :
				return site_url ( 'unionpay' );
				break;
			default :
				return '';
				break;
		}
	}
	function is_online_pay($pay_type = '') {
		if (! $pay_type) {
			$this->load->model ( 'common/Enum_model' );
			$pay_type = $this->Enum_model->get_enum_des ( 'PAY_WAY' );
			$arr = array ();
			foreach ( $pay_type as $k => $pt ) {
				switch ($k) {
					case 'daofu' :
						$arr [$k] = 2;
						break;
					default :
						$arr [$k] = 1;
						break;
				}
			}
			return $arr;
		} else {
			if (is_array ( $pay_type )) {
				$arr = array ();
				foreach ( $pay_type as $pt ) {
					switch ($pt) {
						case 'daofu' :
							$arr [$pt] = 2;
							break;
						default :
							$arr [$pt] = 1;
							break;
					}
				}
				return $arr;
			} else {
				switch ($pay_type) {
					case 'daofu' :
						return 2;
						break;
					default :
						return 1;
						break;
				}
			}
		}
		return false;
	}
	public function update_pay_config($inter_id, $module, $pay_type, $data) {
		$where = array (
				'inter_id' => $inter_id,
				'module' => $module,
				'pay_type' => $pay_type 
		);
		$check = $this->db->get_where ( self::TAB_PAY_CONFIG, $where )->row_array ();
		if ($check) {
			$this->db->where ( $where );
			return $this->db->update ( self::TAB_PAY_CONFIG, $data );
		} else {
			$data = array_merge ( $data, $where );
			return $this->db->insert ( self::TAB_PAY_CONFIG, $data );
		}
	}
	public function replace_param($data) {
		return $this->db->replace ( self::TAB_PAP_PARAM, $data );
	}
	//获取微信支付超时时间
	public function get_weixin_outtime($inter_id) {
		$paras = $this->db->get_where ( self::TAB_PAP_PARAM, array (
				'inter_id' => $inter_id,
				'pay_type' => 'weixin',
				'param_name' => 'outtime' 
		) )->row_array ();
		return $paras['param_value'];
	}
    ////获取快乐付默认方式
    public function get_okpay_config($inter_id) {
        $paras = $this->db->get_where ( self::TAB_PAP_PARAM, array (
            'inter_id' => $inter_id,
            'pay_type' => 'weixin',
            'param_name' => 'okpay_type'
        ) )->row_array ();
        return isset($paras['param_value'])?$paras['param_value']:'';
    }
    public function get_pay_log($inter_id,$orderid,$pay_type='weixin'){
        $db_read = $this->load->database('iwide_r1',true);
        $db_read->limit(1);
        return $db_read->get_where ( self::TAB_PAY_LOG, array (
                'inter_id' => $inter_id,
                'out_trade_no' => $orderid,
                'type'=>$pay_type
        ) )->row_array ();
    }
}