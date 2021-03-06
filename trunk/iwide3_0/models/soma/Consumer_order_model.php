<?php
use App\services\soma\ExpressService;
defined('BASEPATH') OR exit('No direct script access allowed');

class Consumer_order_attr_customer {
    public $ip;
    public $openid;
    public $name;
    public $mobile;
    public function __construct($openid){
        $CI = & get_instance();
        $this->ip= $CI->input->ip_address();
        $this->openid= $openid;
    }
}

class Consumer_order_model extends MY_Model_Soma {

    public $business;
    
    /**
     * 客户对象
     * @var Gift_order_attr_customer
     */
    public $consumer;

    /**
     * 兑换对象
     * @var 
     */
    public $voucher;

    /**
     * 订单对象
     * @var Gift_order_attr_customer
     */
    public $order;

    /**
     * 地址对象
     * @var Gift_order_attr_customer
     */
    public $address;
    
    /**
     * 细单对象(数组)
     * @var Array 
     */
    public $order_item= array();
    /**
     * 资产库对象(数组)
     * @var Array 
     */
    public $asset_item= NULL;

    /**
     * 核销码对象(数组)
     * @var Array
     */
    public $codeIds=array();

    /**
     * 核销是否需要检测对接设备，为真就是不检测，反之检测
     * @var
     */
    public $uncheck_conn_devices = NULL;

    const STATUS_PENDING = 1;
    const STATUS_CONSUME = 11;
    const STATUS_ALLUSE  = 12;
    const STATUS_ADDRESS = 21;
    const STATUS_DELIVERY= 22;
    
    const CONSUME_TYPE_DEFAULT = 1;
    const CONSUME_TYPE_SHIPPING= 2;

    const CONSUME_METHOD_SERVICE = 1;
    const CONSUME_METHOD_SCANER  = 2;
    const CONSUME_METHOD_FRONTEND= 3;
    const CONSUME_METHOD_API     = 4;
    const CONSUME_VOUCHER_SELF   = 5;
    const CONSUME_VOUCHER_SCANER = 6;
    const CONSUME_HOTEL_SELF     = 7;
    const CONSUME_ROOM_AUTO      = 8;

    const BOOKING_HOTEL_TRUE = 1;//已处理
    const BOOKING_HOTEL_FALSE = 2;//未处理

    const CALLBACK_TYPE_ORDER       = 1;//订单完结回调，暂时只用在智游宝
    const CALLBACK_TYPE_CONSUMER    = 2;//核销通知回调，暂时只用在智游宝

    public function get_status_label()
    {
        return array(
            self::STATUS_PENDING  => '未使用',
    
            self::STATUS_CONSUME  => '使用中',
            self::STATUS_ALLUSE   => '已使用',
    
            self::STATUS_ADDRESS  => '地址确认',
            self::STATUS_DELIVERY => '已发货',
        );
    }

    public function get_type_label()
    {
        return array(
            self::CONSUME_TYPE_DEFAULT  => '核销使用',
            self::CONSUME_TYPE_SHIPPING => '物流邮寄',
        );
    }
    
    public function get_method_label()
    {
        return array(
            self::CONSUME_METHOD_SERVICE => '后台操作',
            self::CONSUME_METHOD_SCANER  => '扫码核销',
            self::CONSUME_METHOD_FRONTEND=> '自助核销',
            self::CONSUME_METHOD_API     => '接口核销',
            self::CONSUME_VOUCHER_SELF   => '自助核销(礼品卡券)',
            self::CONSUME_VOUCHER_SCANER => '店员核销(礼品卡券)',
            self::CONSUME_HOTEL_SELF     => '自助核销(套票转订房)',
            self::CONSUME_ROOM_AUTO      => '自动核销(升级房券)',
        );
    }
    
	public function get_resource_name()
	{
		return '消费记录';
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
		return $this->_shard_table('soma_consumer_order', $inter_id);
	}
	public function item_table_name($business, $inter_id=NULL)
	{
	    $business= strtolower($business);
		return $this->_shard_table('soma_consumer_order_item_'. $business, $inter_id);
	}
    public function booking_hotel_table_name($inter_id=NULL)
    {
        return $this->_shard_table('soma_consumer_order_booking_hotel_record', $inter_id);
    }

    /**
     * 字段映射，key中字段将直接转移到item
     * @return multitype:string
     */
    public function booking_hotel_record_field_mapping()
    {
        return array(
            'id'=> 'id',
            'business'=> 'business',
            'inter_id'=> 'inter_id',
            'hotel_id'=> 'hotel_id',
            'consumer_id'=> 'consumer_id',
            'openid'=> 'openid',
            'order_id'=> 'order_id',
            'orderid'=> 'orderid',
            'room_id'=> 'room_id',
            'price_code'=> 'price_code',
            'roomnums'=> 'roomnums',
            'startdate'=> 'startdate',
            'enddate'=> 'enddate',
            'name'=> 'name',
            'mobile'=> 'mobile',
            'remark'=> 'remark',
            'rtype'=> 'rtype',
            'allprice'=> 'allprice',
            'code'=> 'code',
            'code'=> 'code',
            'show_orderid'=> 'show_orderid',
            'startdate'=> 'startdate',
            'hotel_name'=> 'hotel_name',
            'room_name'=> 'room_name',
            'status'=> 'status',
        );
    }

	public function table_primary_key()
	{
	    return 'consumer_id';
	}
	public function item_table_primary_key()
	{
	    return 'item_id';
	}
	
	public function attribute_labels()
	{
		return array(
            'consumer_id'=> '消费编号',
            // 'order_id'=> '订单ID',
            'business'=> '所属业务',
            'inter_id'=> '公众号',
            'hotel_id'=> '酒店',
            'openid'=> 'Openid',
            'trans_no'=> '流水单号',
            'consumer_type'=> '消费类型',
            'related_id'=> '关联ID',
            'consumer_time'=> '核销时间',
            'consumer'=> '核销人',
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
            'consumer_id',
            // 'order_id',
            // 'business',
            'inter_id',
            'hotel_id',
            // 'openid',
            // 'trans_no',
            'consumer_type',
            // 'related_id',
            'consumer_time',
            'consumer',
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

	    return array(
            'consumer_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            // 'order_id' => array(
            //     'grid_ui'=> '',
            //     'grid_width'=> '10%',
            //     //'form_ui'=> ' disabled ',
            //     //'form_default'=> '0',
            //     //'form_tips'=> '注意事项',
            //     //'form_hide'=> TRUE,
            //     //'grid_function'=> 'show_price_prefix|￥',
            //     'type'=>'text',	//textarea|text|combobox|number|email|url|price
            // ),
            'business' => array(
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
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                // 'type'=>'text',  //
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox',
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
                // 'type'=>'text',	//textarea|text|combobox|number|email|url|price
                'type'=>'combobox',
                'select'=> $hotels,
            ),
            'openid' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'trans_no' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'consumer_type' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox',	//textarea|text|combobox|number|email|url|price
                'select'=> $this->get_type_label(),
            ),
            'consumer_method' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox',	//textarea|text|combobox|number|email|url|price
                'select'=> $this->get_method_label(),
            ),
            'related_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'consumer_time' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'datetime',	//textarea|text|combobox|number|email|url|price
            ),
            'consumer' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
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
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox',	//textarea|text|combobox|number|email|url|price
                'select'=>$this->get_status_label(),
            ),
	    );
	}
	
	/**
	 * grid表格中默认哪个字段排序，排序方向
	 */
	public static function default_sort_field()
	{
	    return array('field'=>'consumer_id', 'sort'=>'desc');
	}
	
	/* 以上为AdminLTE 后台UI输出配置函数 */

    public function get_consumer_list( $filter, $inter_id, $business, $limit=30, $limitStart=0, $orderby='consumer_id DESC' )
    {
        $db = $this->_shard_db_r('iwide_soma_r');
        if( count($filter)>0 ){
            foreach ($filter as $k=> $v){
                if(is_array($v)){
                    $db->where_in($k, $v);
                } else {
                    $db->where($k, $v);
                }
            }
        }

        if($this->start) {
            $start = $this->start;
            if( strlen($start)<=10 ) $start.= ' 00:00:00';
            $db->where('consumer_time >=', $start);
        }
        if($this->end) {
            $end = $this->end;
            if( strlen($end)<=10 ) $end.= ' 23:59:59';
            $db->where('consumer_time <', $end);
        }

        $table = $this->table_name($inter_id);
        $result = $db
                        ->where('inter_id',$inter_id)
                        ->limit($limit, $limitStart)
                        ->order_by($orderby)
                        ->get($table)
                        ->result_array();
        
        return $result;
    }
    public function get_consumer_list_count( $inter_id, $business, $hotel_id='' )
    {
        $db = $this->_shard_db_r('iwide_soma_r');
        if($this->start) {
            $start = $this->start;
            if( strlen($start)<=10 ) $start.= ' 00:00:00';
            $db->where('consumer_time >=', $start);
        }
        if($this->end) {
            $end = $this->end;
            if( strlen($end)<=10 ) $end.= ' 23:59:59';
            $db->where('consumer_time <', $end);
        }
        if( $hotel_id ){
            $db->where('hotel_id', $hotel_id);
        }
        if( isset( $this->consumer ) && $this->consumer ){
            $db->where('consumer', $this->consumer);
        }
        
        $table = $this->table_name($inter_id);
        $result = $db->where('inter_id',$inter_id)->count_all_results($table);
        
        return $result;
    }

	/**
	 * 显示订单细单明细
	 * Usage: $model->load($id)->get_order_items();
	 */
	public function get_order_items($business, $inter_id)
	{
	    $primary_key= $this->table_primary_key();
	    if( !$this->m_get($primary_key) ){
	        Soma_base::inst()->show_exception('Please Load Model first.');
	    }
	    //根据业务类型初始化对象
	    $business= strtolower($business);
	    $item_object_name= "Consumer_item_{$business}_model";
	    require_once dirname(__FILE__). DS. "$item_object_name.php";
	    $object= new $item_object_name();
	     
	    //细单订单保存支付
	    $result= $object->get_order_items($this, $inter_id);
	    return $result;
	     
	}
	
	/**
	 * 消费订单保存（从订单）
	 * Usage:
	 *   $model->order_item= array();  //不传入整个订单的原因是可能为部分消费
	 *   $model->order_to_consumer($business, $inter_id);
	 */
	public function order_to_consumer($business, $inter_id)
	{
	    try {
	        $this->_shard_db($inter_id)->trans_begin ();
	        $business= strtolower($business);
	         
	        //根据业务类型初始化对象
	        $item_object_name= "Consumer_item_{$business}_model";
	        require_once dirname(__FILE__). DS. "$item_object_name.php";
	        $object= new $item_object_name();
	        
	        $object->save_item_from_order_item($this, $inter_id);
	        
	        $this->_shard_db($inter_id)->trans_complete();
	         
	        if ($this->_shard_db($inter_id)->trans_status() === FALSE) {
	            $this->_shard_db($inter_id)->trans_rollback();
	            return FALSE;
	             
	        } else {
	            $this->_shard_db($inter_id)->trans_commit();
	            return TRUE;
	        }
	         
	    } catch (Exception $e) {
	        return FALSE;
	    }
	}

	/**
	 * 消费订单保存（从资产）邮寄
	 * Usage:
	 *   $model->asset_item= array();  //不传入整个订单的原因是可能为部分消费
	 *   $model->asset_to_consumer($business, $inter_id);
	 */
	public function asset_to_consumer_by_shipping($business, $inter_id)
	{
	    try {
            
            $debug = TRUE;

	        $business= strtolower($business);

			//生成消费单，扣减资产
	        $consumer_result = $this->asset_to_consumer( $business, $inter_id );

            // 20170111 luhuihonh 这里弃用，放到生成消费细单里面（consumer_item_package_model->save_item_from_asset_item）
	        if( $consumer_result && FALSE ){

		        //改变码的状态为已使用(邮寄多少个就注销多少个码)
		        //标记码表
		        $item = $this->asset_item;
		        $consumer_qty = isset( $item[0]['minus_qty'] ) && !empty( $item[0]['minus_qty'] ) ? $item[0]['minus_qty'] : 1;//消费数量
				$order_id = isset( $item[0]['order_id'] ) && !empty( $item[0]['order_id'] ) ? $item[0]['order_id'] : NULL;
				$asset_item_id = isset( $item[0]['item_id'] ) && !empty( $item[0]['item_id'] ) ? $item[0]['item_id'] : NULL;
	            //根据订单ID获取相应数量的核销码
	            if( $order_id && $asset_item_id ){

		            $consumer_code_object_name= "Consumer_code_model";
		            require_once dirname(__FILE__). DS. "Consumer_code_model.php";
		            $Consumer_code_model= new $consumer_code_object_name();

		            $filter = array();
		            // $filter['order_id'] = $order_id + 0; //赠送退回之后，没有order_id，只有asset_item_id
		            $filter['asset_item_id'] = $asset_item_id + 0;
		            $filter['status'] = $Consumer_code_model::STATUS_SIGNED;//取出没有消费的

                    // $codeList = $Consumer_code_model->get_code_by_orderId( $filter, $consumer_qty, $inter_id );
		            $codeList = array();
                    if( $debug )$this->_write_log( '消费码列表：'.json_encode( $codeList ) );
		            if( $codeList ){

			            $codeIds = array();
			            foreach ($codeList as $k => $v) {
			            	$codeIds[] = $v['code_id'];
			            }

			            if( count( $codeIds ) != 0 ){
			                // $code_result = $Consumer_code_model->consume_code_by_mail( $codeIds, $inter_id );
                            if( $debug )$this->_write_log( '本次邮寄消费码处理ID：'.json_encode( $codeIds ) );
			            }
		            }
	            }
	        }

	        return $consumer_result;
			
	    } catch (Exception $e) {
	        return FALSE;
	    }
	}

	/**
	 * 消费订单保存（从资产）
	 * Usage:
	 *   $model->asset_item= array();  //不传入整个订单的原因是可能为部分消费
	 *   $model->asset_to_consumer($business, $inter_id);
	 */
	public function asset_to_consumer($business, $inter_id)
	{
	    try {
	    	// 如果有分账酒店信息，替换资产内的核销酒店信息
            foreach ($this->asset_item as $key => $value) {
                if (!empty($this->billing_hotel_id)) {
                    $this->asset_item[$key]['hotel_id'] = $this->billing_hotel_id;
                }
                if (!empty($this->billing_hotel_name)) {
                    $this->asset_item[$key]['hotel_name'] = $this->billing_hotel_name;
                }
            }

			//邮寄，核销都经过该方法处理
	    	$isClose = FALSE;//是否暂时关闭该方法，关闭就直接返回FALSE，不执行任何操作
	    	if( $isClose == TRUE ) return FALSE;

            $debug = TRUE;
            
            //开启事务            
            $this->_shard_db($inter_id)->trans_begin ();

            $business= strtolower($business);
            $asset_item = $this->asset_item;
            $order_id = isset( $asset_item[0]['order_id'] ) ? $asset_item[0]['order_id'] : '';
            $asset_item_id = isset( $asset_item[0]['item_id'] ) ? $asset_item[0]['item_id'] : '';
            $openid = isset( $asset_item[0]['openid'] ) ? $asset_item[0]['openid'] : '';
            $qty = isset( $asset_item[0]['qty'] ) ? $asset_item[0]['qty'] : '';
            $asset_inter_id = isset( $asset_item[0]['inter_id'] ) ? $asset_item[0]['inter_id'] : '';

            //这里需要处理一下，因为智游宝核销回调检测需要去掉
            $connDevices = isset( $asset_item[0]['conn_devices'] ) ? $asset_item[0]['conn_devices'] : '';
            if( !$this->uncheck_conn_devices && $connDevices != Soma_base::STATUS_TRUE )
            {
                if( $debug )$this->_write_log( '对接核销设备的不能核销：'.json_encode( $asset_item[0] ) );
                return FALSE;
            }

            //20170103 luguihong 防止短时间内多次提交，做一个锁
            $key = "SOMA_ASSET_TO_CONSUMER:CONSUMER_LOCK_{$inter_id}_{$order_id}_{$asset_item_id}_{$openid}";
            // $cache= $this->_load_cache();
            // $redis= $cache->redis->redis_instance();
            $redis = $this->get_redis_instance();
            $now_time = time();
            $lock_time = $now_time + 10;
            if( !$redis->setnx($key, $lock_time) ){
                // 没有获取到锁的，判断lock是否已过期
                // $lock_expire = (int)$redis->get( $key );
                // $lock_expire_old = (int)$redis->getset( $key, $lock_time );
                // if( $now_time >= $lock_expire && $now_time > $lock_expire_old ){
                //     $redis->delete($key);
                // }
                return FALSE;
            }
            $redis->setex($key, 60, $lock_time);

            $asset_result = $consumer_result = FALSE;
            //扣减资产
            //根据业务类型初始化对象
            $asset_item_object_name= "Asset_item_{$business}_model";
            require_once dirname(__FILE__). DS. "$asset_item_object_name.php";
            $asset_item_object= new $asset_item_object_name();

            if( $debug )$this->_write_log( '资产信息'.json_encode( array( 
                                                                        'order_id'=>$order_id,
                                                                        'asset_item_id'=>$asset_item_id,
                                                                        'openid'=>$openid,
                                                                        'qty'=>$qty,
                                                                        'asset_inter_id'=>$asset_inter_id,
                                                                        'inter_id'=>$inter_id,
                                                                        ) 
                                                                    ) 
                                        );
            $asset_result = $asset_item_object->consumer_asset_items( $this, $this->asset_item, $inter_id );
            if( $debug )$this->_write_log( '资产扣减：'.json_encode( $asset_result ) );

            if( $asset_result ){
             
                //根据业务类型初始化对象
                $item_object_name= "Consumer_item_{$business}_model";
                require_once dirname(__FILE__). DS. "$item_object_name.php";
                $object= new $item_object_name();
                
                //生成消费单
                $consumer_result = $object->save_item_from_asset_item($this, $inter_id, $business);
            	if( $debug )$this->_write_log( '消费单处理：'.json_encode( $consumer_result ) );

                // //预约过来的需要扣减预约数
                // $item = $this->asset_item;
                // $product_id = $items[0]['product_id'];
                // $this->load->model( 'soma/Product_package_model', 'product' );
                
                //不是邮寄的，就赠送会员礼包
                $consumerType = isset( $asset_item[0]['consumer_type'] ) ? $asset_item[0]['consumer_type'] : '';//消费类型
                if( $consumerType != self::CONSUME_TYPE_SHIPPING ){
                    /**
                     * 核销成功赠送会员礼包
                     * @author     luguihong    2017/02/23
                     */
                    $consumerQty = isset( $asset_item[0]['minus_qty'] ) && !empty( $asset_item[0]['minus_qty'] ) ? $asset_item[0]['minus_qty'] : 1;//消费数量
                    $this->load->model('soma/Config_member_package_model','somaConfigMemberModel');
                    $somaConfigMemberModel = $this->somaConfigMemberModel;
                    $memberRecordData[] = array(
                                    'inter_id'      => $inter_id, 
                                    'openid'        => $openid, 
                                    'send_id'       => $order_id, 
                                    'product_id'    => $asset_item[0]['product_id'], 
                                    'num'           => $consumerQty, 
                                    'type'          => $somaConfigMemberModel::TYPE_CONSUMER_SUCCESS,
                                    'create_time'   => date('Y-m-d H:i:s'),
                                    'status'        => $somaConfigMemberModel::RECORD_STATUS_PENDING,
                                );
                    $somaConfigMemberModel->insert_record( $this, $inter_id, $memberRecordData );
                }

            }

            // //测试事务使用
            // $this->_shard_db($inter_id)->where(array('id'=>5))->update('iwide_soma_theme',array('them_name'=>'111'));
            // $this->_shard_db($inter_id)->trans_complete();
            
            $redis->delete($key);

            //这里为了防止资产更新语句，影响0条数据，对于事务来说是没问题，但是对于程序是出错的。
            if( $asset_result && $consumer_result ){
                //都等于真
            }else{
                $this->_shard_db($inter_id)->trans_rollback();
                return FALSE;
            }
	         
	        if ($this->_shard_db($inter_id)->trans_status() === FALSE) {
	            $this->_shard_db($inter_id)->trans_rollback();
	            return FALSE;
	             
	        } else {
	            $this->_shard_db($inter_id)->trans_commit();
	            return TRUE;
	        }
	         
	    } catch (Exception $e) {
	        return FALSE;
	    }
	}


    public function _write_log( $content )
    {
        $path= APPPATH. 'logs'. DS. 'soma'. DS. 'consumer'. DS;
        if( !file_exists($path) ) {
            @mkdir($path, 0777, TRUE);
        }
        $file= $path. date('Y-m-d_H'). '.txt';
        $this->write_log($content, $file);
    }

	/**
	 * 主单状态刷新
	 * Usage: $model->load($id)->get_order_items();
	 */
	public function consumer_order_reflesh($business, $inter_id)
	{
	    try {
	        $business= strtolower($business);
	        
	        //根据业务类型初始化对象
	        $item_object_name= "Consumer_item_{$business}_model";
	        require_once dirname(__FILE__). DS. "$item_object_name.php";
	        $object= new $item_object_name();
	        
	        $consomer= $object->order_status_reflesh($this, $inter_id);
	        return $consomer->m_save();
	        
	    } catch (Exception $e) {
	        return FALSE;
	    }
	}

	/**
	 * 根据资产细单ID和code查找消费单信息
	 * $model->get_consumer_order_item($item_id, $code, $business, $inter_id);
	 * @author luguihong@mofly.cn
	 */
	public function get_consumer_order_item($item_id, $code, $business, $inter_id)
	{
		try {
	        $business= strtolower($business);
	        
	        //根据业务类型初始化对象
	        $item_object_name= "Consumer_item_{$business}_model";
	        require_once dirname(__FILE__). DS. "$item_object_name.php";
	        $object= new $item_object_name();
	        
	        return $object->get_consumer_order_item( $item_id, $code, $business, $inter_id );
	        
	    } catch (Exception $e) {
	        return FALSE;
	    }
	}

	/**
	 * 核销(改变消费单状态)
	 * $model->order_item = $order_item;
	 * $model->consumer_order_consume( $business, $inter_id);
	 * @author luguihong@mofly.cn
	 */
	public function consumer_order_consume( $business, $inter_id)
	{
		try {
	        $business= strtolower($business);
	        
	        //根据业务类型初始化对象
	        $item_object_name= "Consumer_item_{$business}_model";
	        require_once dirname(__FILE__). DS. "$item_object_name.php";
	        $object= new $item_object_name();
	        
	        //标记主单状态为已使用
	        $order_item = $this->order_item;
	        $consumer_id = $order_item[0]['consumer_id'];
	        $data = array();
	        $data['status'] = self::STATUS_ALLUSE;//已使用
        	$data['consumer_time'] = date( 'Y-m-d H:i:s', time() );//核销时间
	        $this->load( $consumer_id )->m_sets( $data )->m_save();

	        return $object->consumer_order_consume( $this, $inter_id );
	        
	    } catch (Exception $e) {
	        return FALSE;
	    }
	}


    /**
     * 消费单明细
     * @param $asset_item_id
     * @param $business
     * @param $inter_id
     * @return mixed
     */
    public function consumer_order_item_list($asset_item_id,$business,$inter_id)
    {
        $table = $this->item_table_name($business,$inter_id);
        $filter = array(
            'asset_item_id' => $asset_item_id
        );
        $result = $this->_shard_db_r('iwide_soma_r')
                        ->where($filter)
                        ->get($table)
                        ->result_array();

        if(!empty($result))
            return $result;
        else
            return NULL;
    }

    /**
     * 消费单明细(根据商品ID)
     * @param $product_id
     * @param $business
     * @param $inter_id
     * @return mixed
     */
    public function consumer_order_item_list_by_productId( $product_id, $business, $inter_id )
    {
    	if( !$product_id || !$inter_id ){
    		return FALSE;
    	}

    	$business = strtolower( $business );

    	$where = array();
    	$where['product_id'] = $product_id + 0;
    	$where['inter_id'] = $inter_id;

    	$table = $this->item_table_name($business,$inter_id);
    	$result = $this->_shard_db_r('iwide_soma_r')
                        ->where($where)
                        ->get($table)
                        ->result_array();

        if(!empty($result))
            return $result;
        else
            return NULL;
    }

    /**
	 * 前台扫码核销
	 * 码的判断处理
	 * @author luguihong@mofly.cn
	 */
    public function can_use_code( $code, $inter_id=NULL )
    {
    	$return = array();
    	if( !$code ){
    		$return['message'] = '缺少参数consumer_code';
    		$return['error_code'] = 11002;
    		$return['status'] = 2;
    		return $return;
    	}

    	//查找核销码的信息
        $ConsumerCodeModelName= "Consumer_code_model";
        if( !class_exists( $ConsumerCodeModelName ) ){

	        require_once dirname(__FILE__). DS. "$ConsumerCodeModelName.php";
	        $ConsumerCodeModel = new $ConsumerCodeModelName();
        }else{
        	$ConsumerCodeModel = $this->$ConsumerCodeModelName;
        }
        $consumerCodeInfo = $ConsumerCodeModel->get_consumer_code_info_by_code( $code, $inter_id );
        if( !$consumerCodeInfo ){
			$return['message'] = '找不到该核销码信息';
			$return['error_code'] = 11102;
    		$return['status'] = 2;
    		return $return;
		}
		
		//核销码状态
		$status = isset( $consumerCodeInfo['status'] ) ? $consumerCodeInfo['status'] : '';

		//未分配
		$status_unsign = $ConsumerCodeModel::STATUS_UNSIGN;
		if( $status == $status_unsign ){
			$return['message'] = '该核销码没有被分配';
			$return['error_code'] = 11103;
    		$return['status'] = 2;
    		return $return;
		}

		//已消费
		$status_consume = $ConsumerCodeModel::STATUS_CONSUME;
		if( $status == $status_consume ){
			$return['message'] = '该券码已核销/失效';
			$return['error_code'] = 11105;
    		$return['status'] = 2;
    		return $return;
		}

        //已消费
        $status_consume = $ConsumerCodeModel::STATUS_GIFT;
        if( $status == $status_consume ){
            $return['message'] = '该券码已转赠';
            $return['error_code'] = 11106;
            $return['status'] = 2;
            return $return;
        }

		$return['message'] = '成功';
		$return['status'] = 1;
		$return['data'] = $consumerCodeInfo;
		return $return;
    }

    /**
	 * 前台扫码核销
	 * 资产细单的判断处理
	 * @author luguihong@mofly.cn
	 */
    public function can_use_assetItem( $assetItemId, $inter_id, $business )
    {
    	$return = array();
    	if( !$assetItemId ){
    		$return['message'] = '找不到该核销码信息';
    		$return['error_code'] = 11102;
    		$return['status'] = 2;
    		return $return;
    	}

		//获取资产细单信息
        $this->load->model('soma/Asset_customer_model','AssetCustomerModel');
        $AssetCustomerModel = $this->AssetCustomerModel;
		$assetItem = $AssetCustomerModel->get_asset_items_by_itemId( $assetItemId, $business, $inter_id );
		if( !$assetItem ){
			$return['message'] = '找不到订单信息';
			$return['error_code'] = 11106;
    		$return['status'] = 2;
    		return $return;
		}

		//判断是否是该公众号的数据
		if( isset( $assetItem[0]['inter_id'] ) && $assetItem[0]['inter_id'] != $inter_id ){ 
			$return['message'] = '不是本店的订单';
			$return['error_code'] = 11109;
    		$return['status'] = 2;
    		return $return;
		}

		//判断数量
		if( isset( $assetItem[0]['qty'] ) && $assetItem[0]['qty'] < 1 ){
			$return['message'] = '订单商品数量不足';
			$return['error_code'] = 11108;
    		$return['status'] = 2;
    		return $return;
		}

        //这里设置session的作用是，核销的时候不检查有效期
        $not_check_expire = $this->session->userdata('not_check_expire');//not_check_expire为真就是不检查有效期，反之检查
        if( !$not_check_expire ){
		    //判断是否已过期
    		$time = time();
    	    $expireTime = isset( $assetItem[0]['expiration_date'] ) ? strtotime( $assetItem[0]['expiration_date'] ) : NULL;
            if( $expireTime && $expireTime < $time ){
            	$return['message'] = '订单商品已过期';
            	$return['error_code'] = 11107;
        		$return['status'] = 2;
        		return $return;
            }
        }

        //检查能否核销
        $order_id = isset( $assetItem[0]['order_id'] ) ? $assetItem[0]['order_id'] : NULL;
    	if( !$this->can_consume( $order_id ) ){
    		$return['message'] = '检查能否核销失败';
			$return['status'] = 2;
			return $return;
    	}

    	//消费细单model
    	$ConsumerItemModelName= "Consumer_item_{$business}_model";
        require_once dirname(__FILE__). DS. "$ConsumerItemModelName.php";
        $ConsumerItemModel = new $ConsumerItemModelName();

		$assetItem[0]['consumer_time'] = date( "Y-m-d H:i:s", time() );//消费主单的核销时间
    	$assetItem[0]['consumer_type'] = self::CONSUME_TYPE_DEFAULT;//消费主单的核销类型
    	$assetItem[0]['consume_status'] = self::STATUS_ALLUSE;//消费主单状态改为已使用
    	$assetItem[0]['consume_item_status'] = $ConsumerItemModel::STATUS_ITEM_CONSUME;//消费细单状态改为已核销

		$return['message'] = '成功';
		$return['status'] = 1;
		$return['data'] = $assetItem;
		return $return;

    }

    /**
	 * 直接核销(直接核销不管是否需要预约,暂时用到的地方有自助核销和扫码核销)
	 * @author luguihong@mofly.cn
	 */
    public function direct_consumer( $code, $openid, $consumer_method, $inter_id, $business='package' )
    {
    	$return = array();
        $debug = TRUE;
    	try{

    		if( !$code ){
				$return['message'] = '提交错误,请稍候再试';
	    		$return['status'] = 2;
	    		return $return;
			}

            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 核销码：'.$code.', 直接核销(自助、扫码)开始' );

	    	$business = strtolower( $business );

	    	//核销码信息
	    	$consumerCodeInfo = $this->can_use_code( $code, $inter_id );
	    	if( isset( $consumerCodeInfo['status'] ) && $consumerCodeInfo['status'] == 1 ){
	    		$consumerCodeInfo = isset( $consumerCodeInfo['data'] ) ? $consumerCodeInfo['data'] : '';
	    	}else{
	    		return $consumerCodeInfo;
	    	}

	    	//资产细单id
			$assetItemId = isset( $consumerCodeInfo['asset_item_id'] ) ? $consumerCodeInfo['asset_item_id'] : '';
			$assetItem = $this->can_use_assetItem( $assetItemId, $inter_id, $business );
			if( isset( $assetItem['status'] ) && $assetItem['status'] == 1 ){
	    		$assetItem = isset( $assetItem['data'] ) ? $assetItem['data'] : '';
	    	}else{
	    		return $assetItem;
	    	}

            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 订单ID：'.$assetItem[0]['order_id'] );

			$assetItem[0]['consumer_code'] = isset( $consumerCodeInfo['code'] ) ? $consumerCodeInfo['code'] : '';//消费细单存入核销码
	    	$assetItem[0]['consumer_method'] = isset( $consumer_method ) ? $consumer_method : '';//核销方式
			$assetItem[0]['consumer'] = isset( $openid ) ? $openid : '';//核销人

			//自助核销不用填入核销人，但是要判断是否是自己的单
	    	if( $consumer_method == self::CONSUME_METHOD_FRONTEND ){

				//判断是否是本人的数据(自助核销的要判断，扫码的是店员的openid所以不需要判断)
				if( isset( $assetItem[0]['openid'] ) && $assetItem[0]['openid'] != $openid ){ 
					$return['message'] = '不是本人的核销码';
		    		$return['status'] = 2;
		    		return $return;
				}

				//不需要填写核销人
	    		$assetItem[0]['consumer'] = '';
	    	}

			// $this->asset_item = $assetItem;//传入资产细单信息
			// $this->business = $business;

			// //进行核销处理
			// $result = $this->asset_to_consumer( $business, $inter_id );
			// if( $result ){
			// 	$return['data'] = $assetItem;
			// 	$return['message'] = '核销成功';
			// 	$return['status'] = 1;
			// }else{
			// 	$return['message'] = '核销失败';
			// 	$return['status'] = 2;
			// }

			// return $return;
			$result = $this->go_consume( $assetItem, $business, $inter_id );
            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 核销码：'.$code.', 直接核销(自助、扫码)结束' );

            return $result;

    	} catch (Exception $e) {
    		$return['message'] = '发生错误';
    		$return['status'] = 2;
    		return $return;
    	}
    }

    /**
     * 接口核销(直接核销不管是否需要预约,暂时用到的地方有智游宝)
     * @param $orderId
     * @param $num
     * @param $interId
     * @param $business
     * @param $callbackType
     * @return array|bool
     * @author luguihong  <luguihong@jperation.com>
     */
    public function api_consumer( $orderId, $num, $interId, $business, $callbackType )
    {
        $return = array();
        $debug = TRUE;
        try{

            if( $debug )$this->_write_log( '公众号：'.$interId.', 订单ID：'.$orderId.', 接口核销开始' );
            if( $debug )$this->_write_log( '公众号：'.$interId.', 订单ID：'.$orderId.', 接口核销数量：'.$num );

            /**
             * @var Sales_order_model $somaSalesOrderModel
             */
            $this->load->model('soma/Sales_order_model','somaSalesOrderModel');
            $somaSalesOrderModel = $this->somaSalesOrderModel->load( $orderId );
            if( !$somaSalesOrderModel )
            {
                $return['message'] = 'Sales_order_model load order_id error!';
                $return['status'] = Soma_base::STATUS_FALSE;
                return $return;
            }

            $orderDetail = $somaSalesOrderModel->get_order_asset($business, $interId);
            $assetItems = $somaSalesOrderModel->filter_items_by_openid( $orderDetail['items'], $orderDetail['openid'] );
            if( !$assetItems )
            {
                $return['message'] = 'Asset_items is null!';
                $return['status'] = Soma_base::STATUS_FALSE;
                return $return;
            }

            //特权券不能在后台核销！
            $assetItem = current( $assetItems );
            if( isset( $assetItem['type'] ) && $assetItem['type'] == $somaSalesOrderModel::PRODUCT_TYPE_PRIVILEGES_VOUCHER )
            {
                $return['message'] = 'Product_type is voucher, do not consumer to here!';
                $return['status'] = Soma_base::STATUS_FALSE;
                return $return;
            }

            /**
             * @var Consumer_item_package_model $somaConsumerItemPackageModel
             */
            $this->load->model('soma/Consumer_item_package_model','somaConsumerItemPackageModel');
            $somaConsumerItemPackageModel = $this->somaConsumerItemPackageModel;

            //一个订单下，可能存在两条记录，例如一个订单数量2，赠送出去又被送回来，那么相当于有两条资产记录，总剩余数量为2.
            $assetItemsNum = 0;
            $assetItemIds = array();
            foreach( $assetItems as $k=>$v )
            {
                $assetItemsNum += $v['qty'];
                $assetItemIds[$v['item_id']] = $v;

                $assetItems[$k]['consumer_time']        = date( "Y-m-d H:i:s", time() );//消费主单的核销时间
                $assetItems[$k]['consumer_type']        = self::CONSUME_TYPE_DEFAULT;//消费主单的核销类型
                $assetItems[$k]['consume_status']       = self::STATUS_ALLUSE;//消费主单状态改为已使用
                $assetItems[$k]['consume_item_status']  = $somaConsumerItemPackageModel::STATUS_ITEM_CONSUME;//消费细单状态改为已核销
                $assetItems[$k]['consumer_code']        = '';//消费细单存入核销码
                $assetItems[$k]['consumer_method']      = self::CONSUME_METHOD_API;//接口核销
                $assetItems[$k]['consumer']             = '';//核销人

            }

            /**
             * 因为是订单完结，所以把剩余的都给核销掉
             */
            if( $callbackType == self::CALLBACK_TYPE_ORDER )
            {
                $num = $assetItemsNum;
            }

            foreach( $assetItems as $k=>$v )
            {
                $assetItems[$k]['minus_qty']            = $num + 0;//扣减的资产数量
            }

            //判断数量
            if( $assetItemsNum < 1 || $num < 1 || $assetItemsNum < $num )
            {
                $return['message'] = "asset_item qty = 0 or num = 0 or qty({$assetItemsNum}) !＝ num({$num})";
                $return['status'] = Soma_base::STATUS_FALSE;
                return $return;
            }

            /**
             * 取出核销码
             * @var Consumer_code_model $somaConsumerCodeModel
             */
            $this->load->model('soma/Consumer_code_model','somaConsumerCodeModel');
            $somaConsumerCodeModel = $this->somaConsumerCodeModel;
            $codeList = array();
            if( count( $assetItemIds ) > 0 )
            {
                //消费码的信息
                $filter = array();
                $filter['status'] = $somaConsumerCodeModel::STATUS_SIGNED;
                $codeList = $somaConsumerCodeModel->get_code_by_assetItemIds( array_keys( $assetItemIds ), $interId, $filter, $num );
            }

            $codeNum = count( $codeList );
            if( $codeNum == 0 )
            {
                $return['message'] = 'Code list is null';
                $return['status'] = Soma_base::STATUS_FALSE;
                return $return;
            }

            //判断数量
            if( $codeNum < 1 || $num < 1 || $codeNum < $num )
            {
                $return['message'] = "Code num ({$codeNum}) !＝ checkNum({$num})";
                $return['status'] = Soma_base::STATUS_FALSE;
                return $return;
            }

            $codeIds = array();
            foreach ( $codeList as $k=>$v )
            {
                $codeIds[] = $v['code_id'];
            }
            $this->codeIds = $codeIds;

            $this->uncheck_conn_devices = TRUE;//去掉核销时检测对接设备
            $result = $this->go_consume( $assetItems, $business, $interId );
            if( $debug )$this->_write_log( '公众号：'.$interId.', 订单ID：'.$orderId.', 接口核销结束' );

            return $result;


        } catch (Exception $e) {
            $return['message'] = '发生错误';
            $return['status'] = 2;
            return $return;
        }
    }

    /**
     * 特权券礼包核销
     * @param $order_id
     * @param $openid
     * @param $inter_id
     * @param string $business
     * @param string $item_id
     * @param int $limit
     * @return array|bool
     * @author luguihong  <luguihong@jperation.com>
     */
    public function package_consumer( $order_id, $openid, $inter_id, $business='package', $item_id='', $limit=1 )
    {
        $return = array();
        $debug = TRUE;
        try{

            if( !$order_id || !$openid ){
                $return['message'] = '提交错误,请稍候再试';
                $return['status'] = 2;
                return $return;
            }

            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 订单ID：'.$order_id.', 特权券礼包核销开始' );

            $business = strtolower( $business );

            $assetItemIds = array();
            if( !$item_id ){
                //没有传入资产ID，在支付完成之后被调用
                $this->load->model("soma/Sales_order_model",'SalesOrderModel');
                $SalesOrderModel = $this->SalesOrderModel->load( $order_id );
                if( !$SalesOrderModel ){
                    $return['message'] = 'Sales_order_model初始化失败！';
                    $return['status'] = 2;
                    return $return;
                }
                // $limit = $SalesOrderModel->m_get('row_qty');//购买总量

                //筛选属于自己的资产订单
                $SalesOrderModel->business = $business;
                $orderDetail = $SalesOrderModel->get_order_asset($business,$inter_id);
                $orderDetail['items'] = $SalesOrderModel->filter_items_by_openid( $orderDetail['items'], $openid );
                if( count( $orderDetail['items'] ) == 0 ){
                    $return['message'] = '没有找到属于自己的订单信息！';
                    $return['status'] = 2;
                    return $return;
                }

                $itemQty = 0;
                $assetItems = $orderDetail['items'];
                foreach( $assetItems as $k=>$v ){
                    //是特权券才可以
                    if( $v['type'] == self::PRODUCT_TYPE_PRIVILEGES_VOUCHER && Soma_base::STATUS_FALSE == $v['can_gift'] ){
                        $itemQty += $v['qty'];
                        $assetItemIds[] = $v['item_id'];
                    }
                }

                $limit = $itemQty;
            }else{
                $assetItemIds[] = $item_id+0;
            }
            
            //检查是否有资产ID            
            if( count( $assetItemIds ) == 0 ){
                $return['message'] = '没有找到对应的资产！';
                $return['status'] = 2;
                return $return;
            }

            //查找要核销的消费码
            $consumer_code_object_name= "Consumer_code_model";
            require_once dirname(__FILE__). DS. "Consumer_code_model.php";
            $Consumer_code_model= new $consumer_code_object_name();

            $filter = array();
            $filter['status'] = $Consumer_code_model::STATUS_SIGNED;//取出没有消费的
            $codeList = $Consumer_code_model->get_code_by_assetItemIds( $assetItemIds, $inter_id, $filter, $limit );
            if( count( $codeList ) == 0 ){
                $return['message'] = '根据aiid查找信息错误！';
                $return['status'] = 2;
                return $return;
            }

            $consumer_result = FALSE;

            //循环核销多条
            $this->load->library('Soma/Api_member');
            $api= new Api_member($inter_id);//放心住
            $result= $api->get_token();
            $api->set_token($result['data']);
            foreach ($codeList as $k => $v) {

                //资产细单id
                $assetItemId = isset( $v['asset_item_id'] ) ? $v['asset_item_id'] : '';
                $assetItem = $this->can_use_assetItem( $assetItemId, $inter_id, $business );
                if( isset( $assetItem['status'] ) && $assetItem['status'] == 1 ){
                    $assetItem = isset( $assetItem['data'] ) ? $assetItem['data'] : '';
                }else{
                    return $assetItem;
                }

                //判断是否是本人的数据(自助核销的要判断，扫码的是店员的openid所以不需要判断)
                if( isset( $assetItem[0]['openid'] ) && $assetItem[0]['openid'] != $openid ){ 
                    $return['message'] = '不是本人的核销码';
                    $return['status'] = 2;
                    return $return;
                }

                //判断是否是本人的数据(自助核销的要判断，扫码的是店员的openid所以不需要判断)
                if( !isset( $assetItem[0]['card_id'] ) || empty( $assetItem[0]['card_id'] ) || $assetItem[0]['card_id'] == '0' ){ 
                    $return['message'] = '礼包ID不能为空或者0';
                    $return['status'] = 2;
                    return $return;
                }

                $assetItem[0]['consumer_code'] = isset( $v['code'] ) ? $v['code'] : '';//消费细单存入核销码
                $assetItem[0]['consumer_method'] = isset( $consumer_method ) ? $consumer_method : '';//核销方式
                $assetItem[0]['consumer'] = isset( $openid ) ? $openid : '';//核销人
                
                //调用会员接口核销
                $uu_code = $inter_id.$order_id.$v['asset_item_id'].$v['code'];
                $member_result = $api->package_use( $openid, $assetItem[0]['card_id'], $uu_code );
                if( isset( $member_result['err'] ) && ($member_result['err'] == 0 || $member_result['err'] == 1033) ){
                    //核销结果
                    $consumer_result = $this->go_consume( $assetItem, $business, $inter_id );
                }

            }
            
            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 订单ID：'.$order_id.', 特权券礼包核销结束' );

            return $consumer_result;

        } catch (Exception $e) {
            $return['message'] = '发生错误';
            $return['status'] = 2;
            return $return;
        }
    }

    protected function go_consume( $assetItem, $business, $inter_id )
    {
    	if( !$assetItem || !$business || !$inter_id ){
    		return FALSE;
    	}
    	
    	$this->asset_item = $assetItem;//传入资产细单信息
		$this->business = $business;

		//进行核销处理
		$return = array();
		$result = $this->asset_to_consumer( $business, $inter_id );
		if( $result ){
			$return['data'] = $assetItem;
			$return['message'] = '成功';
			$return['status'] = 1;
		}else{
			$return['message'] = '失败';
			$return['status'] = 2;
		}

		return $return;
    }

    protected function can_consume( $order_id )
    {
    	//检查能否赠送
        $this->load->model("soma/Sales_order_model",'SalesOrderModel');
        $SalesOrderModel = $this->SalesOrderModel->load( $order_id );
        if( $SalesOrderModel ){
            if( !$SalesOrderModel->can_consume_order() ){
            	return FALSE;
                // die('不能进行核销！');
            }
        }else{
        	return FALSE;
            // die('检查能否核销失败，加载sales_order_model失败！');
        }

        return TRUE;
    }

	/**
	 * 邮寄核销
	 * @author luguihong@mofly.cn
	 */
    public function mail_consumer( $post, $openid, $inter_id, $business='package' )
    {
    	$return = array();
        $debug = TRUE;
    	try{

    		$post = $this->_addslashes( $post );
	    	$assetItemId = isset( $post['aiid'] ) ? $post['aiid'] : '';//资产细单ID
			$addressId = isset( $post['arid'] ) ? $post['arid'] : '';//地址ID
			$shippingNum = isset( $post['num'] ) ? $post['num'] : '';//邮寄数量
			$datetime = isset( $post['datetime'] ) ? $post['datetime'] : '';//预约发货时间
			$note = isset( $post['note'] ) ? $post['note'] : '';//备注

            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 资产细单ID：'.$assetItemId.', 邮寄开始' );
            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 资产细单ID：'.$assetItemId.', 邮寄数量：'.$shippingNum );

			//是否使用的是微信地址
			$is_wx_address = isset( $post['is_wx_address'] ) ? $post['is_wx_address'] : '';
			if( $is_wx_address && $is_wx_address == 1 ){
				//不做地址过滤
				if( !$assetItemId || !$shippingNum ){
					$return['message'] = '提交错误,请稍候再试';
		    		$return['status'] = 2;
		    		return $return;
				}
			}else{
				if( !$assetItemId || !$addressId || !$shippingNum ){
					$return['message'] = '提交错误,请稍候再试';
		    		$return['status'] = 2;
		    		return $return;
				}
			}

	    	$business = strtolower( $business );

	    	//资产细单信息
			$assetItem = $this->can_use_assetItem( $assetItemId, $inter_id, $business );
			if( isset( $assetItem['status'] ) && $assetItem['status'] == 1 ){
	    		$assetItem = isset( $assetItem['data'] ) ? $assetItem['data'] : '';
	    	}else{
	    		return $assetItem;
	    	}

    		//检查能否邮寄
    		$this->load->model("soma/Sales_order_model",'SalesOrderModel');
    		$order_id = isset( $assetItem[0]['order_id'] ) ? $assetItem[0]['order_id'] : '';

            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 订单号：'.$order_id );

    		$SalesOrderModel = $this->SalesOrderModel->load( $order_id );
    		if( $SalesOrderModel ){
    			if( !$SalesOrderModel->can_mail_order() ){
    				$return['message'] = $this->lang->line('can_not_mail');
		    		$return['status'] = 2;
		    		return $return;
    			}
    		}else{
    			$return['message'] = '检验是否能邮寄失败，加载sales_order_model失败！';
	    		$return['status'] = 2;
	    		return $return;
    		}

		    //判断是否是本人的数据
			if( isset( $assetItem[0]['openid'] ) && $assetItem[0]['openid'] != $openid ){ 
				$return['message'] = '邮寄商品错误';
	    		$return['status'] = 2;
	    		return $return;
			}

	    	//判断资产数量和邮寄数量
	    	if( isset( $assetItem[0]['qty'] ) && ( $assetItem[0]['qty'] < $shippingNum || $shippingNum < 1 ) ){
		    	//数量不足
		    	$return['message'] = '已经没有商品数量啦';
	    		$return['status'] = 2;
	    		return $return;
		    }

	    	$assetItem[0]['consumer_type'] = self::CONSUME_TYPE_SHIPPING;//消费主单的核销类型
	    	$assetItem[0]['minus_qty'] = $shippingNum + 0;//扣减的资产数量

	    	//消费细单
			// $ConsumerItemModelName= "Consumer_item_{$business}_model";
			// if( !class_exists($ConsumerItemModelName) ){
		 //        require_once dirname(__FILE__). DS. "$ConsumerItemModelName.php";
		 //        $ConsumerItemModel = new $ConsumerItemModelName();
			// }else{
			// 	$ConsumerItemModel = $this->$ConsumerItemModelName;
			// }
            /**
             * @var Consumer_item_package_model $ConsumerItemModel
             */
			$this->load->model("soma/Consumer_item_{$business}_model",'ConsumerItemModel');
			$ConsumerItemModel = $this->ConsumerItemModel;
			$assetItem[0]['consume_item_status'] = $ConsumerItemModel::STATUS_ITEM_SHIPPING;//消费细单状态

			$this->asset_item = $assetItem;//传入资产细单信息
			$this->business = $business;

			//配送对象
			//消费细单model
	    	$CustomerAddressModelName= "Customer_address_model";
	        require_once dirname(__FILE__). DS. "$CustomerAddressModelName.php";
	        $CustomerAddressModel = new $CustomerAddressModelName();

	        if( $is_wx_address && $is_wx_address == 1 ){
				//不做地址过滤
			}else{
				$CustomerAddressModel = $CustomerAddressModel->load( $addressId );
			    if( !$CustomerAddressModel ){
			    	$return['message'] = '地址实例错误';
		    		$return['status'] = 2;
		    		return $return;
			    }
			}

			//配送信息
			$shippingInfo = array();
			$shippingInfo['address_id'] = $addressId + 0;//地址ID
			$shippingInfo['datetime'] = $datetime;//预约发货时间
			$shippingInfo['note'] = $note;//备注

            $customerAddress  = $CustomerAddressModel->get_address_by_id($openid,$inter_id,$addressId);
            $shippingInfo['is_wx_address'] = 1;
            \App\libraries\Support\Log::error('邮寄：' . $order_id. ' | 邮寄地址 : '.json_encode($customerAddress));
            if(!empty($customerAddress)){
                $customerAddressName  =  ExpressService::getInstance()->getRegion($openid,$inter_id,$addressId);
			//是否使用的是微信地址
			// if( $is_wx_address && $is_wx_address == 1 ){
				$shippingInfo['contact'] = isset( $post['name'] ) ? $post['name'] : $customerAddress['contact'];//联系人
				$shippingInfo['phone'] = isset( $post['mobile'] ) ? $post['mobile'] : $customerAddress['phone'];//联系电话
				$area = isset( $post['area'] ) ? $post['area'] : $customerAddressName[0].$customerAddressName[1].$customerAddressName[2];//省市区
				$address = isset( $post['address'] ) ? $post['address'] : $customerAddress['address'];//详细地址
				$shippingInfo['address'] = $area.$address;//收货地址
			// }
            }else{
                $shippingInfo['contact'] = isset( $post['name'] ) ? $post['name'] : '';//联系人
                $shippingInfo['phone'] = isset( $post['mobile'] ) ? $post['mobile'] : '';//联系电话
                $area = isset( $post['area'] ) ? $post['area'] : '';//省市区
                $address = isset( $post['address'] ) ? $post['address'] : '';//详细地址
                $shippingInfo['address'] = $area.$address;//收货地址
            }

		    $CustomerAddressModel->shipping_info = $shippingInfo;
		    $this->address = $CustomerAddressModel;

			//进行核销处理
			$result = $this->asset_to_consumer_by_shipping( $business, $inter_id );
            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 资产细单ID：'.$assetItemId.', 邮寄结束' );
            
			if( $result ){
				$return['data'] = $assetItem;
				$return['message'] = '邮寄申请成功';
				$return['status'] = 1;
			}else{
				$return['message'] = '邮寄申请失败';
				$return['status'] = 2;
			}

			return $return;



    	} catch (Exception $e) {
    		$return['message'] = '发生错误';
    		$return['status'] = 2;
    		return $return;
    	}
    }
    
    /**
	 * 预约
	 * @author luguihong@mofly.cn
	 */
    public function booking_consumer( $code, $openid, $consumer_method, $inter_id, $business='package' )
    {
    	$return = array();
        $debug = TRUE;
    	try{

			if( !$code ){
				$return['message'] = '提交错误,请稍候再试';
	    		$return['status'] = 2;
	    		return $return;
			}

            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 消费码：'.$code.', 预约开始' );

	    	$business = strtolower( $business );

	    	//核销码信息
	    	$consumerCodeInfo = $this->can_use_code( $code, $inter_id );
	    	if( isset( $consumerCodeInfo['status'] ) && $consumerCodeInfo['status'] == 1 ){
	    		$consumerCodeInfo = isset( $consumerCodeInfo['data'] ) ? $consumerCodeInfo['data'] : '';
	    	}else{
	    		return $consumerCodeInfo;
	    	}

	    	//资产细单id
			$assetItemId = isset( $consumerCodeInfo['asset_item_id'] ) ? $consumerCodeInfo['asset_item_id'] : '';
			$assetItem = $this->can_use_assetItem( $assetItemId, $inter_id, $business );
			if( isset( $assetItem['status'] ) && $assetItem['status'] == 1 ){
	    		$assetItem = isset( $assetItem['data'] ) ? $assetItem['data'] : '';
	    	}else{
	    		return $assetItem;
	    	}

            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 订单ID：'.$assetItem[0]['order_id'] );

	    	$assetItem[0]['consumer_time'] = NULL;
	    	$assetItem[0]['consume_status'] = self::STATUS_PENDING;//可以预约的生成消费主单，并且状态为未使用
			$assetItem[0]['consumer_code'] = isset( $consumerCodeInfo['code'] ) ? $consumerCodeInfo['code'] : '';//消费细单存入核销码
	    	$assetItem[0]['consumer_method'] = isset( $consumer_method ) ? $consumer_method : '';//核销方式
			$assetItem[0]['consumer'] = isset( $openid ) ? $openid : '';//核销人

			//消费细单
			// $ConsumerItemModelName= "Consumer_item_{$business}_model";
			// if( !class_exists($ConsumerItemModelName) ){
		 //        require_once dirname(__FILE__). DS. "$ConsumerItemModelName.php";
		 //        $ConsumerItemModel = new $ConsumerItemModelName();
			// }else{
			// 	$ConsumerItemModel = $this->$ConsumerItemModelName;
			// }
			$this->load->model("soma/Consumer_item_{$business}_model",'ConsumerItemModel');
			$ConsumerItemModel = $this->ConsumerItemModel;
			$assetItem[0]['consume_item_status'] = $ConsumerItemModel::STATUS_ITEM_PENDING;//消费细单状态

			// $this->asset_item = $assetItem;//传入资产细单信息
			// $this->business = $business;

			// //进行核销处理
			// $result = $this->asset_to_consumer( $business, $inter_id );
			// if( $result ){
			// 	$return['data'] = $assetItem;
			// 	$return['message'] = '预约成功';
			// 	$return['status'] = 1;
			// }else{
			// 	$return['message'] = '预约失败';
			// 	$return['status'] = 2;
			// }

			// return $return;
			// return $this->go_consume( $assetItem, $business, $inter_id );

            $result = $this->go_consume( $assetItem, $business, $inter_id );
            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 消费码：'.$code.', 预约结束' );
            
            return $result;




    	} catch (Exception $e) {
    		$return['message'] = '发生错误';
    		$return['status'] = 2;
    		return $return;
    	}
    }

    /*
     * 内部核销
     * 不做过多检查，直接核销
    */
    public function consume( $code, $inter_id )
    {
    	$return = array();
    	$business = 'package';
        $debug = TRUE;
    	try{

    		if( !$code ){
				$return['message'] = '提交错误,请稍候再试';
	    		$return['status'] = 2;
	    		return $return;
			}

            if( $debug )$this->_write_log( '公众号：'.$inter_id.', 消费码：'.$code.', 内部核销开始' );

	    	$business = strtolower( $business );

	    	//核销码信息
	    	$consumerCodeInfo = $this->can_use_code( $code, $inter_id );
	    	if( isset( $consumerCodeInfo['status'] ) && $consumerCodeInfo['status'] == 1 ){
	    		$consumerCodeInfo = isset( $consumerCodeInfo['data'] ) ? $consumerCodeInfo['data'] : '';
	    	}else{
	    		return $consumerCodeInfo;
	    	}

	    	//资产细单id
			$assetItemId = isset( $consumerCodeInfo['asset_item_id'] ) ? $consumerCodeInfo['asset_item_id'] : '';
			$this->load->model( 'soma/Asset_customer_model', 'AssetCustomerModel' );
			$AssetCustomerModel = $this->AssetCustomerModel;
			$assetItem = $AssetCustomerModel->get_asset_items_by_itemId( $assetItemId, $business, $inter_id );
			if( $assetItem ){

				//判断是否是该公众号的数据
				if( isset( $assetItem[0]['inter_id'] ) && $assetItem[0]['inter_id'] != $inter_id ){ 
					$return['message'] = '选择公众号错误！';
		    		$return['status'] = 2;
		    		return $return;
				}

                if( $debug )$this->_write_log( '公众号：'.$inter_id.', 订单ID：'.$assetItem[0]['order_id'] );

				$assetItem[0]['consumer_time'] = date( "Y-m-d H:i:s", time() );//消费主单的核销时间
		    	$assetItem[0]['consumer_type'] = self::CONSUME_TYPE_DEFAULT;//消费主单的核销类型
		    	$assetItem[0]['consume_status'] = self::STATUS_ALLUSE;//消费主单状态改为已使用

		    	$this->load->model("soma/Consumer_item_{$business}_model",'ConsumerItemModel');
				$ConsumerItemModel = $this->ConsumerItemModel;
				$assetItem[0]['consume_item_status'] = $ConsumerItemModel::STATUS_ITEM_CONSUME;//消费细单状态

				$assetItem[0]['consumer_code'] = isset( $consumerCodeInfo['code'] ) ? $consumerCodeInfo['code'] : '';//消费细单存入核销码
		    	$assetItem[0]['consumer_method'] = isset( $consumer_method ) ? $consumer_method : '';//核销方式
				$assetItem[0]['consumer'] = isset( $openid ) ? $openid : '';//核销人

				// $this->asset_item = $assetItem;//传入资产细单信息
				// $this->business = $business;

				// //进行核销处理
				// $result = $this->asset_to_consumer( $business, $inter_id );
				// if( $result ){
				// 	$return['data'] = $assetItem;
				// 	$return['message'] = '核销成功';
				// 	$return['status'] = 1;
				// }else{
				// 	$return['message'] = '核销失败';
				// 	$return['status'] = 2;
				// }

				// return $return;
                $result = $this->go_consume( $assetItem, $business, $inter_id );
                if( $debug )$this->_write_log( '公众号：'.$inter_id.', 消费码：'.$code.', 内部核销结束' );

                return $result;

			}else{
				$return['message'] = '找不到资产信息';
				$return['status'] = 2;
                if( $debug )$this->_write_log( '公众号：'.$inter_id.', 消费码：'.$code.', 内部核销结束' );
				return $return;
			}

    	} catch (Exception $e) {
    		$return['message'] = '发生错误';
    		$return['status'] = 2;
    		return $return;
    	}
    }


    /**
     * 导出消费明细
     * @param Array $filter      过滤条件
     * @param Array $item_field  摘选哪些字段
     * @param string $start      订单开始时间
     * @param string $end        订单结束时间
     * @return Array
     */
    public function export_item( $business, $inter_id, $filter=array(), $item_field=array(), $start=FALSE, $end=FALSE )
    {
        $inter_id = isset( $inter_id ) ? $inter_id : $this->session->get_admin_inter_id();

        if( $inter_id == FULL_ACCESS ){
            
        } else if( $inter_id ) {
            $filter+= array('inter_id'=> $inter_id);
        }

        $db = $this->_shard_db_r('iwide_soma_r');
        if( count($filter)>0 ){
            foreach ($filter as $k=> $v){
                if(is_array($v)){
                    $db->where_in($k, $v);
                } else {
                    $db->where($k, $v);
                }
            }
        }
        if($start) {
            if( strlen($start)<=10 ) $start.= ' 00:00:00';
            $db->where('consumer_time >=', $start);
        }
        if($end) {
            if( strlen($end)<=10 ) $end.= ' 23:59:59';
            $db->where('consumer_time <', $end);
        }
         
        //不设定时间最多导出3个月的数据
        if(!$start && !$end){
            $db->where('consumer_time >', date('Y-m-d H:i:s', strtotime('-3 month') ) );
        }
        $orders = $db->select('consumer_id,consumer_time,consumer_method,consumer')
            ->order_by('consumer_id desc')->get( $this->table_name( $inter_id ) )->result_array();
        //echo $this->_shard_db()->last_query();die;

        //查找数据为空
        if( count( $orders ) == 0 ){
        	return array();
        }
        
        //var_dump( $orders );exit;
        $ids= array();
        foreach ($orders as $k=>$v){
            $ids[$v['consumer_id']]= array(
                'consumer_time'=>$v['consumer_time'],
                'consumer_method'=>$v['consumer_method'],
                'consumer'=>$v['consumer'],
            );
        }

        $this->load->model('soma/Sales_order_model','SalesOrderModel');
        $SalesOrderModel = $this->SalesOrderModel;

        $this->load->model('soma/Consumer_item_package_model','ConsumerItemModel');
        $ConsumerItemModel = $this->ConsumerItemModel;
        $table_item = $this->item_table_name( $business, $inter_id );
        $items = $this->_shard_db_r('iwide_soma_r')
                ->where_in('consumer_id', array_keys($ids) )
                ->where(array('status'=>$ConsumerItemModel::STATUS_ITEM_CONSUME))
                ->select('consumer_id,consumer_code,name,price_package,order_id,remark, use_cnt, can_split_use, consumer_qty')
                ->get( $table_item )
                ->result_array();

        $result= array();
        $method_arr = $this->get_method_label();
        // var_dump( $ids );
        foreach ($items as $k=>$v){

            if( empty($item_field) ){
                $result[$k][]= $items[$k];
                 
            } else {
                foreach ($item_field as $sk) {
                    $result[$k][$sk] = $v[$sk];
                    if($sk == 'price_package') {
                        // 订单总额置于核销价格后面
                        $result[$k]['grand_total'] = '';
                    }
                }
                /*
                foreach ($items[$k] as $sk=> $sv){
                    if( in_array($sk, $item_field) ){
                        $result[$k][$sk]= $sv ;
                    }

                    if( $sk == 'price_package' ){
                        //实付金额
                        $SalesOrderModel = $SalesOrderModel->load( $v['order_id'] );
                        if( $SalesOrderModel ) {
                            $result[$k]['grand_total'] = $SalesOrderModel->m_get('real_grand_total');
                        } else {
                            $result[$k]['grand_total'] = '';
                        }
                    }
                }
                */
            }

            $SalesOrderModel = $SalesOrderModel->load( $v['order_id'] );
            if($SalesOrderModel) {
                $result[$k]['grand_total'] = $SalesOrderModel->m_get('real_grand_total');
                // 优化核销价格＝订单实付总额／购买数量／分时次数＊核销数量 同导出
                if($v['can_split_use'] == Soma_base::STATUS_FALSE) {
                    $v['use_cnt'] = 1;
                } else {
                    if($v['use_cnt'] <= 0) {
                        $v['use_cnt'] = 1;
                    }
                }
                $result[$k]['price_package'] = (($result[$k]['grand_total'] / $SalesOrderModel->m_get('row_qty')) / $v['use_cnt']) * $v['consumer_qty'];
                $result[$k]['price_package'] = round($result[$k]['price_package'], 2);
            } else {
                $result[$k]['grand_total'] = '';
                $result[$k]['price_package'] = '';
            }

            // $result[$k]['consumer_id'] = $v['consumer_id'];
            $result[$k]['consumer_time'] = $ids[$v['consumer_id']]['consumer_time'];
            $result[$k]['consumer_method'] = $ids[$v['consumer_id']]['consumer_method'];
            $result[$k]['consumer'] = $ids[$v['consumer_id']]['consumer'];

            $result[$k]['consumer_method']= isset( $method_arr[$result[$k]['consumer_method']] ) ? $method_arr[$result[$k]['consumer_method']] : '' ;

        }

        // var_dump($result);exit;

        return $result;
    }

    /**
     * 兑换码核销  兑换码没有资产没有核销码，只有订单主单和细单，核销方式和其它的核销不一样
     * @author luguihong@mofly.cn
     */
    public function voucher_consumer( )
    {
        $return = array();
        try{

        } catch (Exception $e) {

        }
    }

    //套票转订房，订房下单成功后，生成一个记录表
    public function save_booking_hotel_record_info( $inter_id, $params )
    {
        $data = array();
        foreach ($this->booking_hotel_record_field_mapping() as $k=> $v){
            $data[$k]= isset($params[$v])? $params[$v]: '';
        }

        if( !$data ){
            return FALSE;
        }

        $table = $this->_shard_db( $inter_id )->dbprefix($this->booking_hotel_table_name($inter_id));
        $result = $this->_shard_db( $inter_id )->insert($table,$data);
        if( $result ){
            return $this->_shard_db( $inter_id )->insert_id();
        }else{
            return FALSE;
        }
    }

    //套票转订房，订房下单成功后，生成一个记录表
    public function update_booking_hotel_record_status( $inter_id, $filter, $data )
    {
        if( count($filter)>0 ){
            foreach ($filter as $k=> $v){
                if(is_array($v)){
                    $this->_shard_db( $inter_id )->where_in($k, $v);
                } else {
                    $this->_shard_db( $inter_id )->where($k, $v);
                }
            }
        }else{
            return FALSE;
        }

        if( !$data ){
            return FALSE;
        }
        
        $table = $this->_shard_db( $inter_id )->dbprefix($this->booking_hotel_table_name($inter_id));
        $result = $this->_shard_db()->update($table,$data);
        return $result;
    }

    //套票转订房，订房下单成功后，生成一个记录表
    public function get_booking_hotel_info( $inter_id, $filter, $select='*' )
    {
        $db = $this->_shard_db_r('iwide_soma_r');
        if( count($filter)>0 ){
            foreach ($filter as $k=> $v){
                if(is_array($v)){
                    $db->where_in($k, $v);
                } else {
                    $db->where($k, $v);
                }
            }
        }else{
            return FALSE;
        }
        
        $table = $this->_shard_db( $inter_id )->dbprefix($this->booking_hotel_table_name($inter_id));
        $result = $db->select( $select )->get( $table )->row_array();
        return $result;
    }


    public function generate_shipping_fee_order($data, $openid) {

        $this->load->model('soma/Asset_item_package_model', 'a_model');
        $asset_item = $this->a_model->load($data['aiid']);
        if($asset_item->m_get('product_id') != $data['product_id']) {
            Soma_base::inst()->show_exception('提交的信息有误!');
        }

        $this->load->model('soma/product_package_model', 'p_model');
        /**
         * @var Product_package_model $productPackageModel
         */
        $productPackageModel = $this->p_model;
        $product = $productPackageModel->load($data['product_id']);

        if($data['num'] && $product && ($sfu = $product->m_get('shipping_fee_unit')) && ($spi = $product->m_get('shipping_product_id'))) {

            $this->load->model('soma/Sales_order_model');
            $order = $this->Sales_order_model;
            $order->business = 'package';
            $order->settlement = 'default';
            $order->inter_id = $product->m_get('inter_id');
            $order->openid = $openid;
            $order->discount = array();

            require_once dirname(__FILE__). DS. 'Sales_order_model.php';
            $customer = new Sales_order_attr_customer($openid);
            $order->customer = $customer;

            $qty = ceil($data['num'] / $sfu);
//            $_tmp = $productPackagetModel->get_product_package_by_ids(array($spi), $product->m_get('inter_id'));
//
//            $p_arr = array();
//            $total = 0;
//            foreach ($_tmp as $p) {
//                $p['qty'] = $qty;
//                $total += $p['qty'] * $p['price_package'];
//                $p_arr[] = $p;
//            }

            $childProduct = $productPackageModel->get('product_id', $spi);
            if (empty($childProduct)) {
                Soma_base::inst()->show_exception('缺少产品信息。');
            }

            $childProduct = $childProduct[0];

            $productPackageModel->appendEnInfo($childProduct);
            $childProduct['qty'] = $qty;
            $total = $childProduct['qty'] * $childProduct['price_package'];

            if($total <= 0) { return false; }

            $order->product = array($childProduct);
            $order->saler_id = '0';  // 没有saler_id
            $order->killsec_instance = 0;
            // var_dump($order);exit;
            $order = $order->order_save($order->business, $order->inter_id);   
            return $order;

        }

        return false;
    }

}
