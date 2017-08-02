<?php 
class Gridmember extends MY_Model
{
	const TABLE_MEMBER             = 'member';
	const TABLE_MEMBER_INFO        = 'member_additional';
	
	public function table_name()
	{
		return 'member';
	}
	
	public function table_primary_key()
	{
		return 'mem_id';
	}
	
	public function attribute_labels()
	{
		return array(
			'mem_id'=>'会员ID',
			'inter_id'=>'酒店',
			'name'=>'会员名',
			'mem_card_no'=>'会员号',
			'level'=>'会员等级',
			'membership_number'=>'卡号',
			'bonus'=>'积分',
			'balance'=>'余额'
		);
	}
	
	/**
	 * 后台管理的表格中要显示哪些字段
	 */
	public function grid_fields()
	{
		return array('mem_id', 'inter_id','name', 'mem_card_no', 'level', 'membership_number', 'bonus', 'balance');
	}
	
	public function attribute_ui()
	{
		

		/** 获取本管理员的酒店权限  */
		$this->_init_admin_hotels();
		$publics = $hotels= $topics= array();
		$filter= $filterH= NULL;
		 
		if( $this->_admin_inter_id== FULL_ACCESS ) $filter= array();
		else if( $this->_admin_inter_id ) $filter= array('inter_id'=> $this->_admin_inter_id);
		if(is_array($filter)){
			$this->load->model('wx/publics_model');
			$publics= $this->publics_model->get_public_hash($filter);
			$publics= $this->publics_model->array_to_hash($publics, 'name', 'inter_id');
			//$publics= $publics+ array(FULL_ACCESS=>'-所有公众号-');
			 
			$this->load->model('mall/shp_topic');
			$topics= $this->shp_topic->get_data_filter($filter);
			$topics= $this->shp_topic->array_to_hash_multi($topics, 'identity|page_title', 'topic_id');
		}
		
		if( $this->_admin_hotels== FULL_ACCESS ) $filterH= array();
		else if( $this->_admin_hotels ) $filterH= array('hotel_id'=> $this->_admin_hotels);
		else $filterH= array();
		 
		if( $publics && is_array($filterH)){
			$this->load->model('hotel/hotel_model');
			$hotels= $this->hotel_model->get_hotel_hash($filterH);
			$hotels= $this->hotel_model->array_to_hash($hotels, 'name', 'hotel_id');
			$hotels= $hotels+ array('0'=>'-不限定-');
		}
		/** 获取本管理员的酒店权限  */

		return array(
			'mem_id' => array(
				'grid_ui'=> '',
				'grid_width'=> '3%',
				'form_ui'=> '',
				'type'=>'text',
				//'form_type'=> 'hidden',
			),
			'name' => array(
				'grid_ui'=> '',
				'grid_width'=> '3%',
				'form_ui'=> '',
				'type'=>'text',
			),
			'mem_card_no' => array(
				'grid_ui'=> '',
				'grid_width'=> '5%',
				'form_ui'=> '',
				'type'=>'text',
					//'form_type'=> 'hidden',
			),
			'level' => array(
				'grid_ui'=> '',
				'grid_width'=> '5%',
				'form_ui'=> '',
				'type'=>'combobox',
				'select'=>$this->getLevelHash(),
			),
			'membership_number' => array(
				'grid_ui'=> '',
				'grid_width'=> '5%',
				'form_ui'=> '',
				'type'=>'text',
				//'form_type'=> 'hidden',
			),
			'bonus' => array(
				'grid_ui'=> '',
				'grid_width'=> '5%',
				'form_ui'=> '',
				'type'=>'text',
				//'form_type'=> 'hidden',
			),
			'balance' => array(
				'grid_ui'=> '',
				'grid_width'=> '5%',
				'form_ui'=> '',
				'type'=>'text',
				//'form_type'=> 'hidden',
			),
			'inter_id' => array(
					'grid_ui'=> '',
					'grid_width'=> '5%',
					'form_ui'=> ' disabled ',
					//'form_default'=> '0',
					//'form_tips'=> '注意事项',
					//'form_hide'=> TRUE,
					'type'=>'combobox',
					'select'=> $publics,
			),	
		);
	}
	
	public static function default_sort_field()
	{
		return array('field'=>'mem_id', 'sort'=>'desc');
	}
	
	public function filter_json( $params=array(), $select= array() )
	{
		$table= $this->table_name();
		$where= array();
		$dbfields= array_values($fields= $this->_db()->list_fields($table));
		foreach ($params as $k=>$v){
			//过滤非数据库字段，以免产生sql报错
			if(in_array($k, $dbfields) || ($k==self::TABLE_MEMBER.'.inter_id')) $where[$k]= $v;
		}
	
		if( isset($params['order'][0]['column']) && isset($params['order'][0]['dir']) ){
			$field= $this->field_name_in_grid($params['order'][0]['column']);
			$sort= $field. ' '. $params['order'][0]['dir'];
				
		} else {
			$pk= $this->table_primary_key();
			$sort= "{$pk} DESC";  //默认排序
		}
	
		if(count($select)==0) {
			$select= $this->grid_fields();
		}
		$select= count($select)==0? '*': implode(',', $select);
		
		$select = str_replace('mem_id', self::TABLE_MEMBER.'.mem_id', $select);
		$select = str_replace('inter_id', self::TABLE_MEMBER.'.inter_id', $select);
	
		$total= $this->_db()->get_where($table, $where)->num_rows();
		//echo $total;
		
		$result= $this->_db()->select(" {$select} ")->order_by($sort)
			->join(self::TABLE_MEMBER_INFO, self::TABLE_MEMBER.'.mem_id='.self::TABLE_MEMBER_INFO.'.mem_id', 'left')
			->limit($this->input->post('length'),$this->input->post('start'))->get_where($table, $where)
			->result_array();
	
		$tmp= array();
		$field_config= $this->get_field_config('grid');
		foreach ($result as $k=> $v){
			//判断combobox类型需要对值进行转换
			foreach($field_config as $sk=>$sv){
				if($field_config[$sk]['type']=='combobox') {
					if( isset($field_config[$sk]['select'][$v[$sk]]))
						$v[$sk]= $field_config[$sk]['select'][$v[$sk]];
					else $v[$sk]= '--';
				}
				if( $field_config[$sk]['grid_function'] ) {
					$funp= explode('|', $field_config[$sk]['grid_function']);
					$fun= $funp[0];
					$funp[0]= $v[$sk];
					$v[$sk]= call_user_func_array ($fun, $funp);
				} else if( $field_config[$sk]['function'] ) {
					$funp= explode('|', $field_config[$sk]['function']);
					$fun= $funp[0];
					$funp[0]= $v[$sk];
					$v[$sk]= call_user_func_array ($fun, $funp);
				}
			}//-----
	
			$el= array_values($v);
			$el['DT_RowId']= $v[$this->table_primary_key()];
			$tmp[]= $el;
		}
		$result= $tmp;
		return array(
			'draw'=> isset($params['draw'])? $params['draw']: 1,
			'data'=> $result,
			'recordsTotal'=>$total,
			'recordsFiltered'=>$total,
		);
	}
	
	public function filter( $params=array(), $select= array(), $format='array' )
	{
		$table= $this->table_name();
		$where= array();
		$dbfields= array_values($fields= $this->_db()->list_fields($table));
		foreach ($params as $k=>$v){
			//过滤非数据库字段，以免产生sql报错
			if(in_array($k, $dbfields) || ($k==self::TABLE_MEMBER.'.inter_id')) $where[$k]= $v;
		}
	
		if( isset($params['sort_field']) && isset($params['sort_direct']) ){
			$sort= $params['sort_field']. ' '. $params['sort_direct'];
		} else
			$pk= $this->table_primary_key();
		$sort= "{$pk} DESC";  //默认排序
	
		$num= (config_item('grid_static_num'))? config_item('grid_static_num'): 500;
		$page_size= isset($params['page_size'])? $params['page_size']: $num;
		$current_page= isset($params['page_num'])? $params['page_num']: 1;
	
		if(count($select)==0) {
			$select= $this->grid_fields();
		}
		$select= count($select)==0? '*': implode(',', $select);
	
		$select = str_replace('mem_id', self::TABLE_MEMBER.'.mem_id', $select);
		$select = str_replace('inter_id', self::TABLE_MEMBER.'.inter_id', $select);
		//echo $select;die;
		$offset= ($current_page-1)>=0? ($current_page-1)*$page_size: 0;
		$total= $this->_db()->get_where($table, $where)->num_rows();

		$result= $this->_db()->select(" {$select} ")
		->join(self::TABLE_MEMBER_INFO, self::TABLE_MEMBER.'.mem_id='.self::TABLE_MEMBER_INFO.'.mem_id', 'left')
		->order_by($sort)
		->limit($page_size, $offset)->get_where($table, $where)
		->result_array();

		if($format=='array'){
			$tmp= array();
			$field_config= $this->get_field_config('grid');
			foreach ($result as $k=> $v){
				//判断combobox类型需要对值进行转换
				foreach($field_config as $sk=>$sv){
					if($field_config[$sk]['type']=='combobox') {
						if( isset($field_config[$sk]['select'][$v[$sk]]))
							$v[$sk]= $field_config[$sk]['select'][$v[$sk]];
						else $v[$sk]= '--';
					}
				}//---
	
				$el= array_values($v);
				$el['DT_RowId']= $v[$this->table_primary_key()];
				$tmp[]= $el;
			}
			$result= $tmp;
		}
			
		return array(
				'total'=>$total,
				'data'=>$result,
				'page_size'=>$page_size,
				'page_num'=>$current_page,
		);
	}
	
	protected function getLevelHash()
	{
		$this->load->model('member/config','mconfig');
		$result = $this->mconfig->getConfig('level',true,$this->_admin_inter_id);
	
		if($result) {
			$ret = array();
			foreach($result->value as $k=>$v) {
				$ret[$k] = $v;
			}
			return $ret;
		} else {
			return array();
		}
	}
}