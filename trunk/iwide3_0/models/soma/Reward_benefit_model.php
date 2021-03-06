<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Reward_benefit_model extends MY_Model_Soma {

    const DAYS_CHECKING = 7;
    
    const STATUS_DEFAULT = 1;
    const STATUS_SENDED  = 2;
    const STATUS_ROLLBACK= 3;

    /**
     * 与分销模块的同步状态标记
     */
    public function get_status_label()
    {
        return array(
            self::STATUS_DEFAULT => '未同步',
            self::STATUS_SENDED  => '已同步',
            self::STATUS_ROLLBACK=> '退回',
        );
    }
    
    const REWARD_STATUS_11 = 11;  //此类id业绩为直接核定（跳过待核定过程）
    const REWARD_STATUS_1 = 1;
    //const REWARD_STATUS_2 = 2;
    //const REWARD_STATUS_4 = 4;
    const REWARD_STATUS_5 = 5;
    const REWARD_STATUS_6 = 6;
    const REWARD_STATUS_16 = 16; // 此类绩效为随时退款绩效，不进行定期核定
    
    /**
     * 分销模块定义的状态标记
     */
    public function get_reward_status_label()
    {
        return array(
            self::REWARD_STATUS_11 => '已核定 - 未发放（不可退款）',    //确认发放/拼团成功
            self::REWARD_STATUS_1 => '已核定 - 未发放（定期/成团/拒绝退款）',    //确认发放/拼团成功/拒绝退款
            //self::REWARD_STATUS_2 => '已核定 - 已发放',
            //self::REWARD_STATUS_4 => '未核定 - 尚未离店',
            self::REWARD_STATUS_5 => '已核定 - 无绩效（退款/拼团失败）',    //退款/拼团失败
            self::REWARD_STATUS_6 => '未核定 - 付款成功',  //订单付款/参团
            self::REWARD_STATUS_16 => '未核定 - 付款成功（随时退款）',  //随时退款
        );
    }

    /**
     * 对于这几种计算类型做定时推送计算
     * @return multitype:string
     */
    public function get_timing_settlement()
    {
        return array( self::SETTLE_DEFAULT, self::SETTLE_KILLSEC );
    }
    
	public function get_resource_name()
	{
		return '分销奖励明细';
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function table_name($inter_id=NULL)
	{
		return $this->_shard_table('soma_reward_benefit', $inter_id);
	}

	public function table_primary_key()
	{
	    return 'reward_id';
	}

	//定义 m_save 保存时不做转义字段
	public function unaddslashes_field()
	{
	    return array( 'reward_detail', );
	}
	
	public function attribute_labels()
	{
		return array(
            'reward_id'=> 'ID',
            'inter_id'=> '公众号',
            'hotel_id'=> '酒店ID',
            'rule_id'=> '规则ID',
            'rule_type'=> '规则类型',
            'reward_source'=> '奖励来源',
            'reward_type'=> '计算方式',
            'reward_rate'=> '奖励额度',
            'reward_status'=> '同步状态',
            'reward_total'=> '分销奖励',
            'reward_detail'=> '绩效构成',
            'order_id'=> '订单ID',
            'openid'=> '订单Openid',
            'subtotal'=> '订单总计',
            'grand_total'=> '订单总计',
            'create_time'=> '相关时间',
            'saler_id'=> '分销员ID',
            'status'=> '状态',
		);
	}

	/**
	 * 后台管理的表格中要显示哪些字段
	 */
	public function grid_fields()
	{
        //主键字段一定要放在第一位置，否则 grid位置会发生偏移
	    return array(
            'reward_id',
            'rule_type',
            'reward_source',
            'reward_type',
            'reward_rate',
            'reward_status',
            'reward_total',
            'order_id',
            'create_time',
            'saler_id',
            'status',
	    );
	}

	/**
	 * 在EasyUI grid中的 date-option 定义，包括宽度，是否排序等等
	 *   type: grid中的表头类型定义 
	 *   form_type: form中的元素类型定义
	 *   form_ui: form中的属性补充定义，如加disabled 在< input “disabled” / > 使元素禁用
	 *   form_tips: form中的label信息提示
	 *   form_hide: form中自动化输出中剔除
	 *   form_default: form中的默认值，请用字符类型，不要用数字
	 *   select: form中的类型为 combobox时，定义其下来列表
	 */
	public function attribute_ui()
	{
	    /* text,textbox,numberbox,numberspinner, combobox,combotree,combogrid,datebox,datetimebox, timespinner,datetimespinner, textarea,checkbox,validatebox. */
	    //type: numberbox数字框|combobox下拉框|text不写时默认|datebox
	    $base_util= EA_base::inst();
	    $modules= config_item('admin_panels')? config_item('admin_panels'): array();

	    /** 获取本管理员的酒店权限  */
	    $hotels_hash= $this->get_hotels_hash();
	    $publics = $hotels_hash['publics'];
	    $hotels = $hotels_hash['hotels'];
	    $filter = $hotels_hash['filter'];
	    $filterH = $hotels_hash['filterH'];
	    /** 获取本管理员的酒店权限  */
	    
	    $CI= & get_instance();
	    $CI->load->model('soma/Reward_rule_model');
	    $rule_model= $CI->Reward_rule_model;
	    
	    return array(
            'reward_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'inter_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                // 'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> $publics,
            ),
            'hotel_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> $hotels,
            ),
            'rule_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'rule_type' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox',	//textarea|text|combobox|number|email|url|price
                'select'=> $rule_model->get_rule_type(),
            ),
            'reward_source' => array(
                'grid_ui'=> '',
                'grid_width'=> '8%',
                'form_ui'=> ' required ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox',	//textarea|text|combobox|number|email|url|price
                'select'=> $rule_model->get_reward_source()
            ),
            'reward_type' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox',	//textarea|text|combobox|number|email|url|price
                'select'=> $rule_model->get_reward_type(),
            ),
            'reward_rate' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'reward_status' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=> 'combobox',	//textarea|text|combobox|number|email|url|price
                'select'=> $this->get_reward_status_label(),
            ),
            'reward_total' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',	//textarea|text|combobox|number|email|url|price
            ),
            'reward_detail' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'textarea',	//textarea|text|combobox|number|email|url|price
            ),
            'order_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'openid' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'subtotal' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',	//textarea|text|combobox|number|email|url|price
            ),
            'grand_total' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',	//textarea|text|combobox|number|email|url|price
            ),
            'create_time' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'saler_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'status' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                'type'=>'combobox',	//textarea|text|combobox|number|email|url|price
                'select'=> $this->get_status_label()
            ),
	    );
	}
	
	/**
	 * grid表格中默认哪个字段排序，排序方向
	 */
	public static function default_sort_field()
	{
	    return array('field'=>'reward_id', 'sort'=>'desc');
	}
	
	/* 以上为AdminLTE 后台UI输出配置函数 */

	public function _write_log( $content )
	{
	    $path= APPPATH. 'logs'. DS. 'soma'. DS. 'reward'. DS;
        if( !file_exists($path) ) @mkdir($path, 0777, TRUE);
        $this->write_log($content, $path. date('Y-m-d_H'). '.txt');
	}
	
	/**
	 * Usage:
	 *     $model= $model->load('1000001011');
	 *     $benefit_model->write_benefit_queue('a1111111', $model);
	 * @param String $inter_id
	 * @param Sales_order_model $order
	 * @return boolean|unknown
	 */
	public function write_benefit_queue($inter_id, $order)
	{
        $debug= FALSE;  //debug开关
        
        $this->load->model('soma/Reward_rule_model');
		/**
		 * @var Reward_rule_model $rule_model
		 */
        $rule_model= $this->Reward_rule_model;
        
        // $rules= $rule_model->get_reward_rule($inter_id, array() );
        $rules = $rule_model->getRewardRules($inter_id, $order->m_get('saler_group'));

        if($debug) $this->_write_log( $inter_id. '所有分销规则：'. json_encode($rules) );
        
        $rewardInfo = $this->bgySpecialHotelReward($inter_id, $order);
        if ($rewardInfo['status'] == Soma_base::STATUS_TRUE) {
            $data = $rewardInfo['rewardInfo'];
        } else {
            $data= $rule_model->calculate_reward_data($inter_id, $order, $rules, Reward_rule_model::REWARD_SOURCE_SALER);
        }

        if($debug) $this->_write_log( $inter_id. '业绩计算结果[按分销员]：'. json_encode($data) );

        $refund_reward_status = array(
            self::CAN_REFUND_STATUS_SEVEN    => self::REWARD_STATUS_6,
            self::CAN_REFUND_STATUS_ANY_TIME => self::REWARD_STATUS_16,
            self::CAN_REFUND_STATUS_FAIL     => self::REWARD_STATUS_11,
        );

        //按销售员推荐规则计算
        if($data && $order && $order->m_get('saler_id') ) {
            $data['inter_id']= $order->m_get('inter_id');
            $data['hotel_id']= $order->m_get('hotel_id');
            $data['order_id']= $order->m_get('order_id');
            $data['subtotal']= $order->m_get('subtotal');
            $data['grand_total']= $order->m_get('grand_total');
            $data['openid']= $order->m_get('openid');
            $data['saler_id']= $order->m_get('saler_id');
            //$data['rule_id']= '';           //匹配规则ID
            //$data['reward_source']= '';       //规则中计算方式
            //$data['reward_type']= '';       //规则中计算方式
            //$data['reward_rate']= '';       //规则中的比例
            //$data['reward_total']= '';      //累计绩效
            //$data['reward_detail']= '';     //绩效构成json数组
            // if( $data['reward_status']=== TRUE ) $data['reward_status']= self::REWARD_STATUS_6;   //定期发放
            // else $data['reward_status']= self::REWARD_STATUS_11;  //立即发放
            $data['reward_status'] = $refund_reward_status[ $data['reward_status'] ];

            $data['create_time']= date('Y-m-d H:i:s');
            $data['status']= self::STATUS_DEFAULT;
            //var_dump($data);die;
            $table= $this->table_name($inter_id);
            if($debug) $this->_write_log( $inter_id. '数据保存[按分销员]：'. json_encode($data) );
            $result= $this->_shard_db($inter_id)->insert($table, $data);  //数据库事务关联
            if($debug) $this->_write_log( $inter_id. '保存结果[按分销员]：'. json_encode($result) );
        }
        
        $data= $rule_model->calculate_reward_data($inter_id, $order, $rules, Reward_rule_model::REWARD_SOURCE_FIXED);
        if($debug) $this->_write_log( $inter_id. '业绩计算结果[粉丝归属]：'. json_encode($data) );
        
        //粉丝归属规则计算
        if($data){
            $data['inter_id']= $order->m_get('inter_id');
            $data['hotel_id']= $order->m_get('hotel_id');
            $data['order_id']= $order->m_get('order_id');
            $data['subtotal']= $order->m_get('subtotal');
            $data['grand_total']= $order->m_get('grand_total');
            $data['openid']= $order->m_get('openid');
            $data['saler_id']= 0; // 粉丝分销没有分销员
            
            // if( $data['reward_status']=== TRUE ) $data['reward_status']= self::REWARD_STATUS_6;   //定期发放
            // else $data['reward_status']= self::REWARD_STATUS_11;  //立即发放
            $data['reward_status'] = $refund_reward_status[ $data['reward_status'] ];

            $data['create_time']= date('Y-m-d H:i:s');
            $data['status']= self::STATUS_DEFAULT;
            if($debug) $this->_write_log( $inter_id. '数据保存[粉丝归属]：'. json_encode($data) );

            $table= $this->table_name($inter_id);
            $result= $this->_shard_db($inter_id)->insert($table, $data);  //数据库事务关联

            if($debug) $this->_write_log( $inter_id. '保存结果[粉丝归属]：'. json_encode($result) );
        }
        
        $data = $rule_model->calculate_reward_data($inter_id, $order, $rules, Reward_rule_model::REWARD_SOURCE_FANS_SALER);

        if($debug) $this->_write_log( $inter_id. '业绩计算结果[泛分销]：'. json_encode($data) );

        if($data && $order && $order->m_get('fans_saler_id')) {
            $data['inter_id']= $order->m_get('inter_id');
            $data['hotel_id']= $order->m_get('hotel_id');
            $data['order_id']= $order->m_get('order_id');
            $data['subtotal']= $order->m_get('subtotal');
            $data['grand_total']= $order->m_get('grand_total');
            $data['openid']= $order->m_get('openid');
            $data['saler_id']= $order->m_get('fans_saler_id');
            
            // if( $data['reward_status']=== TRUE ) {
            //     $data['reward_status']= self::REWARD_STATUS_6;   //定期发放
            // } else {
            //     $data['reward_status']= self::REWARD_STATUS_11;  //立即发放
            // }
            $data['reward_status'] = $refund_reward_status[ $data['reward_status'] ];
        
            $data['create_time']= date('Y-m-d H:i:s');
            $data['status']= self::STATUS_DEFAULT;

            if($debug) $this->_write_log( $inter_id. '数据保存[泛分销]：'. json_encode($data) );

            $table= $this->table_name($inter_id);
            $result= $this->_shard_db($inter_id)->insert($table, $data);  //数据库事务关联

            if($debug) $this->_write_log( $inter_id. '保存结果[泛分销]：'. json_encode($result) );
        }

        return ( isset($result) && $result ) ? $result: FALSE;
	}

    public function bgySpecialHotelReward($inter_id, $order)
    {
        //去除需谨慎，为碧桂园定制的分销规则
        $interIds = ['a421641095'];
        if (!in_array($inter_id, $interIds)) {
            return ['status' => Soma_base::STATUS_FALSE];
        }

        $file = APPPATH . '..' . DS . 'www_admin' . DS . 'public' . DS . 'import' . DS . 'bgy_reward_hotels.csv';
        if (!file_exists($file)) {
            return ['status' => Soma_base::STATUS_FALSE];
        }
        
        $csv = fopen($file, 'r');
        $csv_data = array(); 
        $n = 0; 
        while ($data = fgetcsv($csv)) { 
            $num = count($data); 
            for ($i = 0; $i < $num; $i++) { 
                $csv_data[$n][$i] = mb_convert_encoding($data[$i], 'utf-8', 'gbk');//$data[$i]; 
            } 
            $n++; 
        }

        $hotels = [];
        foreach ($csv_data as $row) {
            $hotels[] = $row[0];
        }

        if (!in_array($order->m_get('hotel_id'), $hotels)) {
            return ['status' => Soma_base::STATUS_FALSE];
        }

        $rewardInfo = [];
        if ($order->m_get('grand_total') >= 300) {
            $rewardInfo['rule_type']     = $order->m_get('settlement');
            $rewardInfo['reward_source'] = Reward_rule_model::REWARD_SOURCE_SALER;
            $rewardInfo['rule_id']       = 0;
            $rewardInfo['reward_type']   = Reward_rule_model::REWARD_TYPE_PERCENT;
            $rewardInfo['reward_rate']   = '0.02';
            $rewardInfo['reward_total']  = floor($order->m_get('grand_total') * 0.02);
            $rewardInfo['reward_detail'] = '';

            $items = $order->get_order_items($order->m_get('business'), $inter_id);
            $rewardInfo['reward_status'] = $items[0]['can_refund'];
        }

        return ['status' => Soma_base::STATUS_TRUE, 'rewardInfo' => $rewardInfo];
    }

	/**
	 * 核定/取消分销业绩方法
	 * @param String $inter_id
	 * @param Sales_order_model $order
	 * @param String $step   对应分销模块识别的状态     
	 *     self::REWARD_STATUS_1  //成功用
	 *     self::REWARD_STATUS_5  //退款用
	 */
	public function modify_benefit_queue($inter_id, $order, $step= NULL)
	{
	    $order_id= $order->m_get('order_id');
        $table= $this->table_name($inter_id);
	    $data= $order->_shard_db_r('iwide_soma_r')
                        ->order_by('reward_source desc')
	                    ->get_where($table, array('order_id'=> $order_id))
                        ->result_array();
	    
	    if($data) {
	        //对于存在 “业绩撤销”（退款/拼团失败） 请求的order_id，不允许创建 “业绩核定” 的请求记录
	        $can_check= TRUE;
	        foreach ($data as $sk=>$sv){
	            if($sv['reward_status']== self::REWARD_STATUS_5) $can_check= FALSE; 
	            if($sv['reward_status']== self::REWARD_STATUS_1) $can_check= FALSE; 
	            if($sv['reward_status']== self::REWARD_STATUS_11) $can_check= FALSE; 
	        }
	        
	        if($step=='refund_refuse') {
	            //拒绝退款强制同步
	            $can_check= TRUE; 
	            $step= self::REWARD_STATUS_1;
	        }
	        
	        if($can_check== TRUE){
	            //两类来源业绩
	            $this->load->model('soma/Reward_rule_model');
	            $fixed_data= $saler_data= $fans_saler_data = array();
	            foreach ($data as $k=>$v){
	                if( $v['reward_source']== Reward_rule_model::REWARD_SOURCE_FIXED ){
	                    $fixed_data[]= $v;
	                } elseif( $v['reward_source']== Reward_rule_model::REWARD_SOURCE_SALER ){
	                    $saler_data[]= $v;
	                } elseif( $v['reward_source']== Reward_rule_model::REWARD_SOURCE_FANS_SALER ) {
                        $fans_saler_data[] = $v;
                    }
	            }
                $result = FALSE;
	            if ( count($saler_data)>0 && $order && $order->m_get('saler_id') ) {
	                $line= $saler_data[0];
	                //进行 业绩核定 / 业绩撤销
	                unset($line['reward_id']);
	                //$line['create_time']= date('Y-m-d H:i:s');  //以初次记录时间为准
	                $line['reward_status']= $step;
	                $line['status']= self::STATUS_DEFAULT;
	                $result= $order->_shard_db($inter_id)->insert($table, $line);
	            }
	            if ( count($fixed_data)>0 && $order && $order->m_get('saler_id') ){
	                $line= $fixed_data[0];
	                //进行 业绩核定 / 业绩撤销
	                unset($line['reward_id']);
	                //$line['create_time']= date('Y-m-d H:i:s');  //以初次记录时间为准
	                $line['reward_status']= $step;
	                $line['status']= self::STATUS_DEFAULT;
	                $result= $order->_shard_db($inter_id)->insert($table, $line);
	            }
                if ( count($fans_saler_data)>0 && $order && $order->m_get('fans_saler_id') ){
                    $line= $fans_saler_data[0];
                    //进行 业绩核定 / 业绩撤销
                    unset($line['reward_id']);
                    //$line['create_time']= date('Y-m-d H:i:s');  //以初次记录时间为准
                    $line['reward_status']= $step;
                    $line['status']= self::STATUS_DEFAULT;
                    $result= $order->_shard_db($inter_id)->insert($table, $line);
                }
	            return $result;
	            
	        } else {
	            //已经存在 业绩撤销/退款/团失败
	            return FALSE;
	        }
	    }
	    return FALSE;
	}

    //退款取消分销
    public function modify_benefit_queue_refund( $inter_id, $order )
    {
        return $this->modify_benefit_queue( $inter_id, $order, self::REWARD_STATUS_5 );
    }

    //拒绝退款分销
    public function modify_benefit_queue_refund_refuse( $inter_id, $order )
    {
        return $this->modify_benefit_queue( $inter_id, $order, 'refund_refuse' );
    }
    
    //消费成功处理分销
    public function modify_benefit_queue_check( $inter_id, $order )
    {
        return $this->modify_benefit_queue( $inter_id, $order, self::REWARD_STATUS_1 );
    }

	/**
	 * 查找若干条记录进行发送
	 * @param String $limit
	 * @param Array $filter
	 * @param String $sort
	 * @return boolean
	 */
	public function send_benefit_queue($limit=20, $filter=array(), $sort=NULL )
	{
	    $table= $this->table_name();
	    foreach ($filter as $k=>$v){
	        if(is_array($v)){
	            $this->_db()->where_in($k, $v);
	        } else {
	            $this->_db()->where($k, $v);
	        }
	    }
	    if($sort) $this->_db()->order_by($sort);
	    else $this->_db()->order_by(' reward_id ASC');
	    $result= $this->_db()->where('status', self::STATUS_DEFAULT)->get($table)->result_array();
	    
	    return $result;
	}

	/**
	 * 发送后标记收益记录状态
	 * @param Array $ids
	 * @param String $status
	 * @return boolean
	 */
	public function update_reward_status($ids, $status )
	{
	    if( $ids ){
	        $table= $this->table_name();
	        $pk= $this->table_primary_key();
	        return $this->_db()->where_in($pk, $ids)->update($table, array(
	            'status'=> $status
	        ));
	    } else {
	        return TRUE;
	    }
	}

	/**
	 * 查找7天内无退款记录（使用场景为7天自动核定普通购买订单）
	 * @param String $limit
	 * @param Array $filter
	 * @param String $sort
	 * @return boolean
	 */
	public function set_benefit_norefund($limit=20 )
	{
        $debug= FALSE;  //debug开关
        
	    $days= self::DAYS_CHECKING;
	    if( isset($_SERVER['CI_ENV']) && $_SERVER['CI_ENV']=='production' ){
	        //扫码7-9天前的记录
	        $days2= $days +2;
	        $date= date('Y-m-d H:i:s', strtotime("- $days days") );
	        $date2= date('Y-m-d H:i:s', strtotime("- $days2 days") );
	        
	    } else {
	        //测试版本，7分钟之内
	        $days2= $days *5;
    	    $date= date('Y-m-d H:i:s', strtotime("- $days mins") );
    	    $date2= date('Y-m-d H:i:s', strtotime("- $days2 mins") );
    	    //$date= date('Y-m-d H:i:s', strtotime("- $days hours") );
    	    //$date2= date('Y-m-d H:i:s', strtotime("- $days2 hours") );
	    }
	    $table= $this->table_name();
	    //获取七天内的已发送记录（包含提成/核定/退款）
	    $result= $this->_db()
	        //->where('rule_type', self::SETTLE_DEFAULT )  //限定只会对立即购买进行核定
	        ->where_in('rule_type', $this->get_timing_settlement() )
	        ->where('create_time <', $date)
	        ->where('create_time >', $date2)
            // 随时退款的订单不允许自动核定
            ->where('reward_status !=', self::REWARD_STATUS_16)
	        ->get($table)->result_array();
        //var_dump($result);die;
	    if($debug) $this->_write_log( "时间  [where create_time >'{$date2}' and create_time <'{$date}'] \n绩效明细：". json_encode($result) );
	    
	    $refund_order= $checked_order= array();
	    foreach ($result as $k=>$v){
	        //获取发送过退款核定请求的订单号
            
            if(!isset($refund_order[$v['reward_source']])) {
                $refund_order[$v['reward_source']] = array();
            }
            if(!isset($checked_order[$v['reward_source']])) {
                $checked_order[$v['reward_source']] = array();
            }

	        if( $v['reward_status']== self::REWARD_STATUS_5 ) 
	            $refund_order[$v['reward_source']][]= $v['order_id'];
	        if( $v['reward_status']== self::REWARD_STATUS_1 || $v['reward_status']== self::REWARD_STATUS_11 ) 
	            $checked_order[$v['reward_source']][]= $v['order_id'];
	    }
        //var_dump($refund_order);
        //var_dump($checked_order);die;
	    if($debug) $this->_write_log( "已退款订单：". json_encode($refund_order)
	        . " \n已核定订单：". json_encode($checked_order) );

	    $count= 0;
	    $this->load->model('soma/Reward_rule_model');
	    $reward_source_fixed= Reward_rule_model::REWARD_SOURCE_FIXED;
	    $reward_source_saler= Reward_rule_model::REWARD_SOURCE_SALER;
        $reward_source_fans_saler= Reward_rule_model::REWARD_SOURCE_FANS_SALER;
	    foreach ($result as $k=>$v){
	        switch ($v['reward_source']){
	            case $reward_source_fixed:
	                if(!in_array($v['order_id'], $refund_order[$reward_source_fixed] )
                        && !in_array($v['order_id'], $checked_order[$reward_source_fixed]  ) ){
	                    //没有退过款的订单，才可以发送成功核定记录
	                    $data= $v;
	                    unset($data['reward_id']);
	                    //$data['create_time']= date('Y-m-d H:i:s');  //以初次记录时间为准
	                    $data['reward_status']= self::REWARD_STATUS_1;
	                    $data['status']= self::STATUS_DEFAULT;
	                    //各个订单inter_id 不一样不能用 insert_batch
	                    $this->_shard_db($v['inter_id'])->insert($table, $data);
	                    $checked_order[$reward_source_fixed][]= $v['order_id'];
	                    $count++;
	                }
	                break;
	                
	            case $reward_source_saler:
	                if(!in_array($v['order_id'], $refund_order[$reward_source_saler] )
                        && !in_array($v['order_id'], $checked_order[$reward_source_saler]  ) ){
	                    //没有退过款的订单，才可以发送成功核定记录
	                    $data= $v;
	                    unset($data['reward_id']);
	                    //$data['create_time']= date('Y-m-d H:i:s');  //以初次记录时间为准
	                    $data['reward_status']= self::REWARD_STATUS_1;
	                    $data['status']= self::STATUS_DEFAULT;
	                    //各个订单inter_id 不一样不能用 insert_batch
	                    $this->_shard_db($v['inter_id'])->insert($table, $data);
	                    $checked_order[$reward_source_saler][]= $v['order_id'];
	                    $count++;
	                }
	                break;

                case $reward_source_fans_saler:
                    if(!in_array($v['order_id'], $refund_order[$reward_source_fans_saler] )
                        && !in_array($v['order_id'], $checked_order[$reward_source_fans_saler]  ) ){
                        //没有退过款的订单，才可以发送成功核定记录
                        $data= $v;
                        unset($data['reward_id']);
                        //$data['create_time']= date('Y-m-d H:i:s');  //以初次记录时间为准
                        $data['reward_status']= self::REWARD_STATUS_1;
                        $data['status']= self::STATUS_DEFAULT;
                        //各个订单inter_id 不一样不能用 insert_batch
                        $this->_shard_db($v['inter_id'])->insert($table, $data);
                        $checked_order[$reward_source_fans_saler][]= $v['order_id'];
                        $count++;
                    }
                    break;
	        }
	    }
	    return $count;
	}

	//
	public function get_benefit_formtime($inter_id, $start_time, $end_time )
	{
	    $table= $this->table_name();
	    $result= $this->_shard_db_r('iwide_soma_r')//->where('status', self::STATUS_SENDED )
                        ->where('create_time >', $start_time)
                        ->where('create_time <', $end_time)
                        ->where('inter_id', $inter_id)
                        ->get($table)
                        ->result_array();
	    //echo $this->_shard_db($inter_id)->last_query();die;
	    return $result;
	}
	
    /**
     * 
     * 批量计算绩效时，过滤已发绩效的订单
     * 
     * @param  [type] $order_ids [description]
     * @return [type]            [description]
     */
    public function filter_orders($order_data) {
        if(count($order_data) <= 0) {
            return array();
        }
        $table= $this->table_name();
        $data = $this->_shard_db_r('iwide_soma_r')
                    ->select('order_id')
                    ->where_in('order_id', array_keys($order_data))
                    ->get($table)
                    ->result_array();

        foreach ($data as $row) {
            if(isset($order_data[ $row['order_id'] ])) {
                unset($order_data[ $row['order_id'] ]);
            }
        }
        return $order_data;
    }

    /**
     * 获取数据库分片信息
     *
     * @return     [type]  [description]
     */
    protected function _get_table_suffix() {
        $shards= $this->_db()->get('soma_shard')->result_array();
        $data = array();
        foreach ($shards as $row) { $data[] = $row['table_suffix']; }
        return $data;
    }

    /**
     * 根据业绩记录加载订单信息，再组合到业绩记录里面
     * send_benefit_queue函数调用之后再调用这个，目前仅用于业绩推送
     *
     * @param      <type>  $rewards  The rewards
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function fill_reword_info_with_order($rewards) {

        if(count($rewards) <= 0) { return array(); }

        $order_ids = array();
        foreach ($rewards as $rows) {
            $order_ids[] = $rows['order_id'];
        }

        // 获取总单数据，从总表获取即可，实时性要求高，从读写库读取数据
        $o_idx_tb = $this->_shard_table('soma_sales_order_idx');
        $o_set = $this->_shard_db()
                        ->where_in('order_id', $order_ids)
                        ->get($o_idx_tb)
                        ->result_array();

        $order_set = array();
        foreach ($o_set as $row) {
            $order_set[ $row['order_id'] ] = $row;
            $order_set[ $row['order_id'] ]['item_set'] = array();
        }

        // 获取细单数据，需要从分片获取，实时性要求高，从读写库读取数据
        $item_set = array();
        $suffixs = $this->_get_table_suffix(); 
        foreach ($suffixs as $suffix) {
            $i_tb = 'soma_sales_order_item_package' . $suffix;
            $item_set += $this->_shard_db()
                                ->where_in('order_id', array_keys($order_set))
                                ->get($i_tb)
                                ->result_array();
        }
        foreach ($item_set as $item) {
            $order_set[ $item['order_id'] ]['item_set'][] = $item;
        }

        // 组合数据到业绩记录表中
        $return = array();
        foreach ($rewards as $key => $row) {
            $tmp = $row;
            $tmp['order'] = array();
            if(isset($order_set[ $row['order_id'] ])) {
                $tmp['order'] = $order_set[ $row['order_id'] ];
            }
            $return[$key] = $tmp;
        }

        return $return;
    }

}
