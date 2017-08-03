<?php

use App\libraries\Support\Log;
use App\models\soma\ScopeProductLink;
use App\services\soma\ScopeDiscountService;

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order_attr_customer {
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

class Sales_order_attr_shipping {
    public $amount= 0;
}

/**
 * @deprecated  Already move to Sales_order_discount_model.
class Sales_order_attr_discount {
    const TYPE_COUPON = 1;
    const TYPE_FCODE  = 2;
    const TYPE_POINT  = 3;
    const TYPE_BALENCE= 4;
    public $type= array('coupon', 'point', 'balence');
    public $amount= 0;
} */


/**
 * Class Sales_order_model
 *
 */
class Sales_order_model extends MY_Model_Soma {

    public $inter_id;
    public $openid;
    public $business;
    public $settlement;
    public $extra;

    public $hotel_id;
    /**
     * 客户对象
     * @var Sales_order_customer
     */
    public $customer;
    public $saler_id;
    public $saler_group = '';
    public $fans_saler_id = 0; // 0代表没有泛分销员
    public $killsec_instance = 0;  // 0代表没有秒杀实例，大客户，兑换券生成订单时出现此列值错误
    public $member_id = 0;
    public $member_card_id = 0;
    /**
     * 运费对象
     * @var Sales_order_shipping
     */
    public $shipping;
    public $shipping_mount= 0;
    /**
     * 折扣对象(数组)
     * @var Array Sales_order_attr_discount
     */
    public $discount= array();
    public $discount_mount= array();  //折扣实施结果
    /**
     * 购买商品对象(数组)，内含各类产品model对象 ，如 Product_package_model
     * @var Array 
     */
    public $product= array();
    /**
     * 退款对象(数组)
     * @var Array 
     */
    public $refund= array();
    /**
     * 退款细单对象(数组)
     * @var Array 
     */
    public $refund_item= array();
    /**
     * 细单对象(数组)
     * @var Array 
     */
    public $item= array();

    public $row_qty= 0;
    public $coupon_reduce= 0;

    /**
     * @var int
     */
    public $scope_product_link_id = 0;
    public $payment_extra;

    //const MIN_PAY_AMOUNT= 0.01;
    const MIN_PAY_AMOUNT= 0;

    const ORDER_STATUS_UNDER_PAY = 1; //未付款
    const ORDER_STATUS_UNDER_USE = 2;//未使用
    const ORDER_STATUS_USING     = 3;//使用中

    const STATUS_HOLDING = 10;
    const STATUS_WAITING = 11;  //等待支付
    const STATUS_PAYMENT = 12;  //
    const STATUS_INVOICE = 13;
    const STATUS_CANCLE  = 14;
    const STATUS_GROUPING= 15;
    const STATUS_REFUND  = 17;
    const STATUS_UN_VALID= 18;//未支付取消
    const STATUS_EXCEPTION_PAY = 61;

    const CONSUME_PENDING = 21;
    const CONSUME_PART    = 22;
    const CONSUME_ALL     = 23;

    const GIFT_PENDING = 41;
    const GIFT_PART    = 42;
    const GIFT_ALL     = 43;

    const REFUND_PENDING  = 31;
    const REFUND_PART     = 32;
    const REFUND_ALL      = 33;

    const STATUS_ITEM_UNSIGN = 1;
    const STATUS_ITEM_SIGNED = 2;

    const STATUS_ITEM_UNREFUND = 1;
    const STATUS_ITEM_REFUNDING = 2;
    const STATUS_ITEM_REFUNDED = 3;

    const IS_PAYMENT_YES = 1;   //已支付
    const IS_PAYMENT_NOT = 2;   //未支付

    const IS_INVOICE_YES = 1;   //已申请发票
    const IS_INVOICE_NOT = 2;   //未申请发票


    const ORDER_CHECK_DAYS = 1;   //在某客户ip的下单次数累计周期（天数）
    const ORDER_PERIP_LIMIT= 20;   //在某客户ip某一周期内允许累计下单的总数
    const ORDER_IP_REMARK = TRUE;  //下单记录用户ip身份，适用于soma模块
    const ORDER_IP_CHECK  = FALSE;  //下单检测用户ip身份，适用于soma模块

    //对接设备的状态
    const CONN_DEVICES_DEFAULT      = 1;//未同步
    const CONN_DEVICES_ORDER        = 2;//同步订单
    const CONN_DEVICES_CONSUMER     = 3;//核销完毕
    const CONN_DEVICES_REFUND       = 4;//退款
    const CONN_DEVICES_CANCEL       = 5;//取消

    const STOCK_LIMIT = 200;

    // 订房套餐调用此model请求类型
    const HOTEL_PACKAGE_API_REQUEST_TYPE_ORDER = 1;
    const HOTEL_PACKAGE_API_REQUEST_TYPE_PAY   = 2;

    /**
     * 获取对接设备的状态
     * @return array
     * @author luguihong  <luguihong@jperation.com>
     */
    public function get_conn_devices_status()
    {
        return array(
            self::CONN_DEVICES_DEFAULT      => '未同步',
            self::CONN_DEVICES_ORDER        => '同步订单',
            self::CONN_DEVICES_CONSUMER     => '核销完毕',
            self::CONN_DEVICES_REFUND       => '退款',
            self::CONN_DEVICES_CANCEL       => '取消',
        );
    }

    const REDIS_ZB_PREFIX = 'Soma_ZB';
    
    public function get_zb_order_redis_key()
    {
        $order_id = $this->m_get('order_id');
        if(empty($order_id)) {
            return false;
        }
        return "Soma_ZB:{$order_id}";
    }

    public function get_payment_label()
    {
        return array(
            self::IS_PAYMENT_YES=>'已支付',
            self::IS_PAYMENT_NOT=>'未支付',
        );
    }

    public function get_invoice_label()
    {
        return array(
            self::IS_INVOICE_YES=>'已申请',
            self::IS_INVOICE_NOT=>'未申请',
        );
    }

    public function get_status_label()
    {
        return array(
            self::STATUS_WAITING => '等待支付', 
            self::STATUS_GROUPING=> '拼团中',
            self::STATUS_PAYMENT => '购买成功',  //包含拼团成功、立即购买成功、秒杀成功
            self::STATUS_INVOICE => '申请发票',
            self::STATUS_HOLDING => '订单挂起',
            self::STATUS_CANCLE  => '订单取消',
            self::STATUS_REFUND  => '订单退款',  //包含拼团失败、订单退款
            self::STATUS_EXCEPTION_PAY => '支付异常', 
            self::STATUS_UN_VALID => '未支付取消',//拉取支付，15分钟后不支付，订单变为无效订单，回滚库存、优惠券、积分、储值等 
        );
    }

    /**
     * Gets the status label language key.
     * 供前端进行状态翻译用，返回的内容是语言包中对应的key
     *
     * @return     <type>  The status label language key.
     */
    public function get_status_label_lang_key()
    {
        return array(
            self::STATUS_WAITING => 'wait_payment',
            self::STATUS_GROUPING=> 'group_now',
            self::STATUS_PAYMENT => 'purchase_successful',
            self::STATUS_INVOICE => 'apply_for_invoice',
            self::STATUS_HOLDING => 'order_pending',
            self::STATUS_CANCLE  => 'order_cancel',
            self::STATUS_REFUND  => 'order_refund',
            self::STATUS_EXCEPTION_PAY => 'pay_exception',
            self::STATUS_UN_VALID => 'pay_cancel',
        );
    }

    public function get_consume_label()
    {
        return array(
            self::CONSUME_PENDING => '未使用',
            self::CONSUME_PART => '部分使用',
            self::CONSUME_ALL => '使用完毕',
        );
    }
    public function get_gift_label()
    {
        return array(
            self::GIFT_PENDING => '未赠送',
            self::GIFT_PART => '部分赠送',
            self::GIFT_ALL => '赠送完毕',
        );
    }
    public function get_refund_label()
    {
        return array(
            self::REFUND_PENDING => '无退款',
            self::REFUND_PART => '部分退款',
            self::REFUND_ALL => '全部退款',
        );
    }
    
    public function get_status_item_label()
    {
        return array(
            self::STATUS_ITEM_UNSIGN => '未分配',  //已分配产品库
            self::STATUS_ITEM_SIGNED => '已分配',  //未分配产品库
        );
    }
    public function get_refund_item_label()
    {
        return array(
            self::STATUS_ITEM_UNREFUND => '无退款',
            self::STATUS_ITEM_REFUNDING => '申请退款',
            self::STATUS_ITEM_REFUNDED => '已退款',
        );
    }

    //**************
    // status 字段能否进行某种操作的状态归类，操作前需封装校验
    public function can_payment_status()
    {
        return array( self::STATUS_WAITING, );
    }
    public function can_invoice_status()
    {
        return array( self::STATUS_PAYMENT, );
    }
    public function can_refund_status()
    {
        return array( self::STATUS_PAYMENT, );
    }
    public function can_mail_status()
    {
        return array( self::STATUS_PAYMENT, );
    }
    public function can_holding_status()
    {
        return array( self::STATUS_WAITING, );
    }
    public function can_cancel_status()
    {
        return array( self::STATUS_WAITING, self::STATUS_HOLDING, );
    }
    
    // 有效订单判断，在此状态中在前台对用于予以展示
    public function available_order()
    {
        return array( self::STATUS_PAYMENT , self::STATUS_INVOICE , self::STATUS_CANCLE, self::STATUS_GROUPING );
    }
    
    /**
     * 判断订单能否进行退款操作
     * @return boolean
     */
    public function can_refund_order()
    {

        //拼团订单不可退款
        $settlement = $this->m_get('settlement');
        if($settlement == 'groupon'){
            return FALSE;
        }
        $status= $this->m_get('status');
        if( ! in_array($status, $this->can_refund_status()) ){
            return FALSE;
        }
        $status= $this->m_get('refund_status');
        if( $status!= self::REFUND_PENDING ){
            return FALSE;
        }
        $status= $this->m_get('consume_status');
        if( $status!= self::CONSUME_PENDING ){
            return FALSE;
        }
        $status= $this->m_get('gift_status');
        if( $status!= self::GIFT_PENDING ){
            return FALSE;
        }
        //检查细单是否为可退款产品
        $status= $this->m_get('can_refund');
        if( $status == self::CAN_REFUND_STATUS_FAIL ){
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 判断订单能否进行邮寄操作
     * @return boolean
     */
    public function can_mail_order()
    {
        //拼团订单不可退款
        $status= $this->m_get('status');
        if( ! in_array($status, $this->can_mail_status()) ){
            return FALSE;
        }
        $status= $this->m_get('refund_status');
        if( $status!= self::REFUND_PENDING ){
            return FALSE;
        }
        // $status= $this->m_get('consume_status');
        // if( $status!= self::CONSUME_PENDING ){
        //     return FALSE;
        // }
        // $status= $this->m_get('gift_status');
        // if( $status!= self::GIFT_PENDING ){
        //     return FALSE;
        // }
        return TRUE;
    }

    /**
     * 判断订单能否进行赠送操作
     * @return boolean
     */
    public function can_gift_order()
    {
        // 20160817 luguihong 注释的原因是，买了数量为2的单，全部赠送给别人，订单的状态位为全部赠送，所以不能使用这个状态位判断能否赠送
        //赠送完毕
        // $status= $this->m_get('gift_status');
        // if( $status == self::GIFT_ALL ){
        //     return FALSE;
        // }
        //退款订单不能赠送
        $status= $this->m_get('refund_status');
        if( $status!= self::REFUND_PENDING ){
            return FALSE;
        }
        // $status= $this->m_get('consume_status');
        // if( $status!= self::CONSUME_PENDING ){
        //     return FALSE;
        // }
        // $status= $this->m_get('gift_status');
        // if( $status!= self::GIFT_PENDING ){
        //     return FALSE;
        // }
        return TRUE;
    }

    /**
     * 判断订单能否进行赠送操作
     * @return boolean
     */
    public function can_consume_order()
    {
        // 20160817 luguihong 注释的原因是，买了数量为2的单，先赠送给别人，然后自己消费一个，订单的状态位为全部消费，所以不能使用这个状态位判断能否消费
        //消费完毕 
        // $status= $this->m_get('consume_status');
        // if( $status == self::CONSUME_ALL ){
        //     return FALSE;
        // }
        //退款订单不能赠送
        $status= $this->m_get('refund_status');
        if( $status!= self::REFUND_PENDING ){
            return FALSE;
        }
        // $status= $this->m_get('consume_status');
        // if( $status!= self::CONSUME_PENDING ){
        //     return FALSE;
        // }
        // $status= $this->m_get('gift_status');
        // if( $status!= self::GIFT_PENDING ){
        //     return FALSE;
        // }
        return TRUE;
    }

	//根据相关表记录情况刷新订单的三个状态
	public function refresh_status()
	{
	    //根据
	}
	public function refresh_consume()
	{
	    
	}
	public function refresh_refund()
	{
	    
	}
    
	public function get_resource_name()
	{
		return '交易订单';
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
		return $this->_shard_table('soma_sales_order', $inter_id);
	}
    public function order_idx_table_name( $inter_id=NULL)
    {
        return $this->_shard_table('soma_sales_order_idx', $inter_id);
    }
    public function order_blacklist_table_name( $inter_id=NULL)
    {
        return $this->_shard_table('soma_sales_order_blacklist', $inter_id);
    }
	public function item_table_name($business, $inter_id=NULL)
	{
	    $business= strtolower($business);
		return $this->_shard_table('soma_sales_order_item_'. $business, $inter_id);
	}
	public function asset_item_table_name($business, $inter_id=NULL)
	{
	    $business= strtolower($business);
		return $this->_shard_table('soma_asset_item_'. $business, $inter_id);
	}
    public function gift_item_table_name($business, $inter_id=NULL)
    {
        $business= strtolower($business);
        return $this->_shard_table('soma_gift_order_item_'. $business, $inter_id);
    }
    public function mail_table_name($inter_id=NULL)
    {
        return $this->_shard_table('soma_consumer_shipping', $inter_id);
    }
    /**
     * 返回sonsumer_code完整表名
     * @author chencong <chencong@mofly.cn>
     * @date 2017/07/28
     * @param null $inter_id
     * @return string
     */
    public function code_table_name($inter_id = NULL)
    {
        return $this->_shard_table('soma_consumer_code', $inter_id);
    }

	public function table_primary_key()
	{
	    return 'order_id';
	}
	public function item_table_primary_key()
	{
	    return 'item_id';
	}
	
	public function attribute_labels()
	{
		return array(
            'order_id'=> '订单号',
            'master_oid'=> '主订单号',
            'business'=> '所属业务',
            'settlement'=> '购买方式',
            'inter_id'=> '公众号',
            'hotel_id'=> '酒店',
            'openid'=> '购买者',
            'transaction_id'=> '交易流水号',
            'create_time'=> '下单时间',
            'update_time'=> '更新时间',
            'payment_time'=> '付款时间',
            'row_total'=> '小计总额',
            'row_qty'=> '购买件数',
            'subtotal'=> '订单总额',
            'grand_total'=> '应付金额',
            'discount'=> '优惠金额',
            'wx_total' => '微信支付',
            'balance_total' => '储值支付',
            'point_total' => '积分抵用金额',
            'conpon_total' => '优惠券抵用金额',
            'real_grand_total' => '实付金额',
            'is_invoice'=> '申请发票',
            'is_payment'=> '是否支付',
            'can_refund'=> '能否退',
            'refund_status'=> '退款状态',
            'consume_status'=> '消费状态',
            'gift_status'=> '赠送状态',
            'item_name'=> '购买商品名称',
            'contact'=> '购买人',
            'saler_id'=> '关联分销ID',
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
            'order_id',
            // 'business',
            'settlement',
            // 'inter_id',
            'hotel_id',
            // 'openid',
            // 'transaction_id',
            'create_time',
            // 'update_time',   
            'payment_time',
            // 'row_total',
            // 'subtotal',
            // 'grand_total',
            // 'balance_total',
            'real_grand_total',
            // 'discount',
            // 'is_invoice',
            // 'is_payment',
            // 'can_refund',
            // 'refund_status',
            'consume_status',
            // 'gift_status',
            'item_name',
            'contact',
            'row_qty',
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
	    $Somabase_util= Soma_base::inst();
	    $modules= config_item('admin_panels')? config_item('admin_panels'): array();

        /** 获取本管理员的酒店权限  */
        $hotels_hash= $this->get_hotels_hash();
        $publics = $hotels_hash['publics'];
        $hotels = $hotels_hash['hotels'];
        $filter = $hotels_hash['filter'];
        $filterH = $hotels_hash['filterH'];
        /** 获取本管理员的酒店权限  */

	    return array(
            'order_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'master_oid' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text', //textarea|text|combobox|number|email|url|price
            ),
            'business' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox',	//textarea|text|combobox|number|email|url|price
                'select'=> $this->get_business_type(),
            ),
            'settlement' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> $this->get_settle_label(),
            ),
            'inter_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                // 'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                // 'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> $publics,
            ),
            'hotel_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> $hotels,
            ),
            'openid' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
            ),
            'transaction_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text',	//textarea|text|combobox|number|email|url|price
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
            'update_time' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                'form_default'=> date('Y-m-d H:i:s'),
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'datetime',	//textarea|text|combobox|number|email|url|price
            ),
            'payment_time' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                'form_default'=> date('Y-m-d H:i:s'),
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'datetime',	//textarea|text|combobox|number|email|url|price
            ),
            'row_total' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',	//textarea|text|combobox|number|email|url|price
            ),
            'row_qty' => array(
                'grid_ui'=> '',
                'grid_width'=> '5%',
                'form_ui'=> ' disabled ',
                'type'=>'number',
            ),
            'subtotal' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                // 'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',	//textarea|text|combobox|number|email|url|price
            ),
            'grand_total' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',	//textarea|text|combobox|number|email|url|price
            ),
            'discount' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',	//textarea|text|combobox
            ),
            'wx_total' => array(
                'grid_ui' => '',
                'grid_width' => '10%',
                'form_ui' => 'disabled ',
                'form_default'=> '0.00',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',    //textarea|text|combobox
            ),
            'balance_total' => array(
                'grid_ui' => '',
                'grid_width' => '10%',
                'form_ui' => 'disabled ',
                'form_default'=> '0.00',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',    //textarea|text|combobox
            ),
            'point_total' => array(
                'grid_ui' => '',
                'grid_width' => '10%',
                'form_ui' => 'disabled ',
                'form_default'=> '0.00',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',    //textarea|text|combobox
            ),
            'conpon_total' => array(
                'grid_ui' => '',
                'grid_width' => '10%',
                'form_ui' => 'disabled ',
                'form_default'=> '0.00',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',    //textarea|text|combobox
            ),
            'real_grand_total' => array(
                'grid_ui' => '',
                'grid_width' => '10%',
                'form_ui' => 'disabled ',
                'form_default'=> '0.00',
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                'grid_function'=> 'show_price_prefix|￥',
                'type'=>'price',    //textarea|text|combobox
            ),
            'is_invoice' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> self::get_invoice_label(),
            ),
            'is_payment' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> self::get_payment_label(),
            ),
            'can_refund' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> $this->get_status_can_label(),
            ),
            'refund_status' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> self::get_refund_label(),
            ),
            'consume_status' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> self::get_consume_label(),
            ),
            'gift_status' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> self::get_gift_label(),
            ),
            'item_name' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text', //textarea|text|combobox|number|email|url|price
                // 'select'=> self::get_gift_label(),
            ),
            'contact' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text', //textarea|text|combobox|number|email|url|price
                // 'select'=> self::get_gift_label(),
            ),
            'saler_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                'type'=>'number',
            ),
            'status' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> self::get_status_label(),
            ),
	    );
	}
	
	/**
	 * grid表格中默认哪个字段排序，排序方向
	 */
	public static function default_sort_field()
	{
	    return array('field'=>'order_id', 'sort'=>'desc');
	}
	
	/* 以上为AdminLTE 后台UI输出配置函数 */


	public function get_orderid_ticket($business)
	{
	    $this->load->model('soma/ticket_center_model');
	    return $this->ticket_center_model->get_increment_id_order($business);
	}

    /**
     * @param $id
     * @return array
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function getByID($id)
    {
        $row = $this->get($this->table_primary_key(), $id);
        if (!empty($row) && isset($row[0])) {
            return $row[0];
        }
        return [];
    }
	
	// 查询订单索引表
	public function get_order_simple($order_id)
	{
	    $result= $this->_db()->get_where('soma_sales_order_idx', array($this->table_primary_key() => $order_id) )
	       ->result_array();
	    return $result[0];
	}

	/**
	 * 记录下单客户的身份信息
	 * @return boolean
	 */
	public function remark_order_ip($customer, $business)
	{
	    if( self::ORDER_IP_REMARK== FALSE) 
	        return TRUE;
	    
	    $ip= ip2long($customer->ip);
	    $openid= $customer->openid;
	    $table= $this->order_blacklist_table_name();
	    $result= $this->_shard_db_r('iwide_soma_r')->get_where($table, array(
	        'remote_ip'=> $ip, 'openid'=> $openid , 'business'=> $business 
	    ) )->result_array();
	    
	    if( count($result)==0 ){
    	    $data= array(
    	        'remote_ip'=> $ip,
    	        'openid'=> $customer->openid,
    	        'business'=> $business,
    	        'create_time'=> date('Y-m-d H:i:s'),
    	        'order_count'=> 1,
    	    );
	        if( !empty($data['ip'])&& !empty($data['openid'])&& !empty($data['business']) ) 
	            $this->_shard_db()->insert($table, $data);
	        
	    } else {
	        $table= $this->_shard_db()->dbprefix($table);
	        $sql= "update {$table} set `order_count`=`order_count`+1 where `remote_ip`={$ip}";
	        $this->_shard_db()->query($sql);
	    }
	    //echo $this->_shard_db()->last_query();die;
	    return TRUE;
	}
	
	/**
	 * 检测客户的下单频次
	 * @return boolean
	 */
	public function check_client_can_order($customer, $business)
	{
	    if( self::ORDER_IP_CHECK== FALSE) 
	        return TRUE;
	    
	    $ip= ip2long($customer->ip);
	    $openid= $customer->openid;
	    $table= $this->order_blacklist_table_name();
	    $result= $this->_shard_db_r('iwide_soma_r')->get_where($table,  array(
	        'remote_ip'=> $ip, 'openid'=> $openid , 'business'=> $business 
	    ) )->result_array();
	    
	    if( count($result)==0 ){
	       return TRUE;
	    } else {
	       return $result[0]['order_count']> self::ORDER_PERIP_LIMIT ? FALSE: TRUE;  
	    }
	}

	/**
	 * 把下单次数记录表按照周期清空（计划任务）
	 * @return boolean
	 */
	public function clean_order_client_ip()
	{
	    $limit_time= time()- self::ORDER_CHECK_DAYS * 3600 * 24;
	    $table= $this->order_blacklist_table_name();
	    $result= $this->_shard_db()->where('create_time< ', date('Y-m-d H:i:s', $limit_time) )->delete($table);
	    //echo $this->_shard_db()->last_query();die;
	    return $result;
	}
	
	/**
	 * 检测各个商品的库存情况
	 * @return boolean
	 */
	public function check_item_stock()
	{
        $stock_limit = self::STOCK_LIMIT;
        if($this->settlement == self::SETTLE_WHOLESALE) {
            $stock_limit = 10000;
        }
	    $product= $this->product; 
	    foreach ($product as $k=>$v){
            if( $v['can_split_use'] == Soma_base::STATUS_TRUE && $v['use_cnt'] > 1 ) {
                // 分时住库存检查
                if( $v['qty'] * $v['use_cnt'] > $v['stock'] ) return FALSE;
            }
	        if( $v['qty'] > $v['stock'] || $v['qty'] > $stock_limit  ) return FALSE;
	    }
	    return TRUE;
	}
	/**
	 * 对价格做统一处理
	 */
	public function handle_pay_amount($subtotal, $discount_amount=0)
	{
	    $grand_total= $subtotal- $discount_amount;  //总价-优惠额，可能为复数
	    $grand_total= ($grand_total<= self::MIN_PAY_AMOUNT)? self::MIN_PAY_AMOUNT: $grand_total;
	    //echo $subtotal;echo $grand_total;die;
	    return array(
	        'grand_total'=> $grand_total,
	        'grand_discount'=> $subtotal- $grand_total,
	    );
	}
	
	/**
	 * 订单保存
	 * Usage: 
	 *   $model->saler_id= '';
	 *   $model->customer= '';
	 *   $model->shipping= '';
	 *   $model->discount= array;
	 *   $model->product= array;
	 *   $model->order_save($business, $inter_id);
     *
     * @param string $business
     * @param string $inter_id
     * @return boolean
	 */
	public function order_save($business, $inter_id)
	{
	    try {

            $db = $this->_shard_db($inter_id);
	        $db->trans_begin();
	        
	        $this->_order_save($business, $inter_id);

            //子商品下单 start ======================================
            $this->load->model('soma/Product_package_link_model', 'somaProductPackageLink');
            /**
             * @var Product_package_link_model $productPackageLink
             */
            $productPackageLink = $this->somaProductPackageLink;

            $productID = $this->product[0]['product_id'];
            $childs = $productPackageLink->get('parent_pid', $productID, '*', ['limit' => 1000]);

            if (!empty($childs)) {
                foreach($childs as $childProductLink) {

                    $this->load->model('soma/Product_package_model', 'somaProductPackageModel');
                    /**
                     * @var Product_package_model $productPackage
                     */
                    $productPackage = $this->somaProductPackageModel;
                    $childProduct = $productPackage->get('product_id', $childProductLink['child_pid']);
                    if (empty($childProduct)) {
                        Soma_base::inst()->show_exception('缺少产品信息。');
                    }

                    $childProduct = $childProduct[0];
                    $productPackage->appendEnInfo($childProduct);

                    if (!empty($childProductLink['spec_id'])) {
                        $productPackage->rewiteInfo($childProduct, $childProductLink['spec_id'], $this->settlement);
                    }

                    $child_order = new self();
                    $child_order->business = $business;
                    $child_order->settlement = $this->settlement;
                    $child_order->inter_id = $inter_id;
                    $child_order->openid = $this->customer->openid;
                    $child_order->member_id = $this->member_id;
                    $child_order->member_card_id = $this->member_card_id;
                    $child_order->discount = array();

                    $customer = new Sales_order_attr_customer($child_order->openid);
                    $customer->mobile = $this->customer->mobile;
                    $customer->name = $this->customer->name;
                    $child_order->customer = $customer;
                    $customer->openid = $this->customer->openid;

                    $childProduct['qty'] = $childProductLink['num'] * $this->product[0]['qty'];
                    $childProduct['price_package'] = 0;
                    $childProduct['setting_date'] = Soma_base::STATUS_FALSE;

                    $child_order->product = array($childProduct);
                    $child_order->saler_id = '0';
                    $child_order->saler_group = '';
                    $child_order->killsec_instance = 0;


                    $child_order->_order_save($business, $inter_id, $this->order_id);

                }

            }
            //子商品下单 end ======================================

	        if ($db->trans_status() === false) {
                $db->trans_rollback();
	            return false;
	        
	        } else {
                $db->trans_commit();
	            return $this;
	        }
	        
	    } catch (Exception $e) {
	        return false;
	    }
	}

    private function _order_save($business, $inter_id, $master_oid = null)
    {
        $business = strtolower($business);

        //下单次数限制检测
        $can_order= $this->check_client_can_order($this->customer, $business);
        if( !$can_order ){
            Soma_base::inst()->show_exception('您今天下单次数已超过限制。');
        }

        //检查商品状态
        $this->load->model('soma/' . Product_package_model::class, 'somaProductPackageModel');
        if (!empty($this->product[0]) && !$this->somaProductPackageModel->isAvaliable($this->product[0])) {
            Log::error('商品不可用 product id is ', [$this->product[0]]);
            Soma_base::inst()->show_exception('商品不可用');
        }

        //库存检测
        $stock_enough= $this->check_item_stock();
        if( !$stock_enough ){
            Soma_base::inst()->show_exception($this->lang->line('inventory_shortage_tip'));
        }

        if ($this->scope_product_link_id) {
            if (!ScopeDiscountService::getInstance()->checkStock($inter_id, $this->customer->openid, $this->scope_product_link_id, $this->product[0]['qty'])) {
                Soma_base::inst()->show_exception('超过了名额限制');
            }

            if (!ScopeDiscountService::getInstance()->updateStock($inter_id, $this->customer->openid, $this->scope_product_link_id, $this->product[0]['qty'])) {
                Soma_base::inst()->show_exception('更新库存失败');
            }
        }


        //统一获取订单号
        $order_id = $this->get_orderid_ticket($business);
        if( !$order_id ){
            Soma_base::inst()->show_exception($this->lang->line('try_later_tip'));
        }

        //根据业务类型初始化对象
        $item_object_name = "Sales_item_{$business}_model";
        $this->load->model('soma/' . $item_object_name, 'salesItemPackageModel');
        /**
         * @var Sales_item_package_model $salesItemPackageModel
         */
        $salesItemPackageModel= $this->salesItemPackageModel;

        //计算优惠总额，下面为保存时需要的字段
        $this->order_id= $order_id;
        $this->inter_id= $inter_id;
        $this->openid= $this->customer->openid;

        // 初始化储值支付金额为0，在计算折扣的时候再叠加
        $this->balance_total = 0;
        $this->point_total = 0;
        $this->conpon_total = 0;
        $this->wx_total = 0;

        //使用价格配置的价格
        if ($this->scope_product_link_id) {
            $scopeProductLinkModel = new ScopeProductLink();
            $link = $scopeProductLinkModel->getById($this->scope_product_link_id);
            if (!empty($link)) {
                $this->product[0]['price_package'] = $link['price'];
            }
        }

        //计算订单总额，与calculate_discount的先后顺序不能颠倒
        $total= $salesItemPackageModel->calculate_total($this, $inter_id);

        if ($this->scope_product_link_id) { //价格配置不参与优惠!!!!!
            $discount = 0;
        } else {
            $discount = $salesItemPackageModel->calculate_discount($this, $inter_id);//优惠券批量使用，这里需要改成多个mcid 4
        }

        //实际支付和实际扣减
        $grand= $this->handle_pay_amount($total['subtotal'], $discount);

        $grand_total= $grand['grand_total'];    //$total['subtotal'],
        $grand_discount= $grand['grand_discount'];


        //扣减商品库存
        $salesItemPackageModel->reduce_item_stock($this->product, $inter_id);


        // 2016-10-27 添加购买人、商品信息 fengzhongcheng
        $contact = '';
        if(isset($this->customer->name)
            && $this->customer->name != '') {
            $contact = $this->customer->name;
        }
        $item_name = $item_name_en = '';
        if(count($this->product) > 0) {
            $product = $this->product[0];
            $item_name = $product['name'];
            $item_name_en = isset($product['name_en'])?$product['name_en']:'';
        }
        // 2017-1-22 添加购买人电话
        $mobile = '';
        if(isset($this->customer->mobile)
            && $this->customer->mobile != '') {
            $mobile = $this->customer->mobile;
        }

        $remote_ip = \App\libraries\Support\Tool::getUserIP();

        //路由标识,用于统计
        $route = $this->session->userdata(session_id()) ? $this->session->userdata(session_id()) : '';

        if($this->product[0]['type'] == MY_Model_Soma::PRODUCT_TYPE_POINT) {
            // 积分商品金额算进积分支付里面
            $this->point_total += $grand_total;
        } else if($this->product[0]['type'] == MY_Model_Soma::PRODUCT_TYPE_BALANCE) {
            // 储值商品金额算进储值支付里面
            $this->balance_total += $grand_total;
        } else {
            // 微信支付金额
            $this->wx_total += $grand_total;
        }

        // 实付等于微信付款+储值付款
        $real_grand_total = $this->balance_total + $this->wx_total;

        $can_refund = $this->product[0]['can_refund'];

        //组装插入数据
        $data= array(
            'order_id'=> $order_id,
            'master_oid' => $master_oid ? $master_oid : 0,
            'scope_product_link_id' => $this->scope_product_link_id,
            'business'=> $this->business,
            'settlement'=> $this->settlement,
            'inter_id'=> $inter_id,
            'hotel_id'=> $this->hotel_id,   //calculate_total方法中标记
            'openid'=> $this->customer->openid,
            'member_id' => $this->member_id,
            'member_card_id' => $this->member_card_id,
            'create_time'=> date('Y-m-d H:i:s'),
            'row_qty'=> $this->row_qty,
            'row_total'=> $total['row_total'],
            'subtotal'=> $total['subtotal'],
            'grand_total'=> $grand_total,
            'discount'=> $grand_discount,
            'is_invoice'=> self::STATUS_FALSE,
            'is_payment'=> self::STATUS_FALSE,
            'consume_status'=> self::CONSUME_PENDING,
            'refund_status'=> self::REFUND_PENDING,
            'gift_status'=> self::GIFT_PENDING,
            'status'=> self::STATUS_WAITING,
            'remote_ip'=> $remote_ip,
            'saler_id'=> $this->saler_id,
            'saler_group'=> $this->saler_group,
            'fans_saler_id'=> $this->fans_saler_id,
            'killsec_instance'=> $this->killsec_instance,
            'wx_total' => $this->wx_total,
            'balance_total' => $this->balance_total,
            'point_total' => $this->point_total,
            'conpon_total' => $this->conpon_total,
            'real_grand_total' => $real_grand_total,
            'item_name' => $item_name,
            'item_name_en' => $item_name_en,
            'contact' => $contact,
            'mobile' => $mobile,
            'route' => $route,
            'can_refund' => $can_refund
        );

        //根据保存主订单相关的表，自定义主键需要用 _m_save()
        $this->_m_save($data);


        $extra = $this->extra;
        $idxExtraInfo = array();
        if (isset($extra['mail']) && !empty($extra['mail'])) {
            $addressId = $extra['mail']['address_id'];
            $this->load->model('soma/Customer_address_model', 'CustomerAddressModel');
            $CustomerAddressModel = $this->CustomerAddressModel;
            $addressRs = $CustomerAddressModel->get_addresses($this->customer->openid, array('address_id' => $addressId));
            if (!empty($addressRs)) {
                $address = $addressRs[0];
                $idxExtraInfo['mail'] = array(
                    'address_id' => $address['address_id'],
                    'province'   => $address['province'],
                    'city'       => $address['city'],
                    'region'     => $address['region'],
                    'address'    => $address['address'],
                    'phone'      => $address['phone'],
                    'contact'    => $address['contact']
                );
            }

        }


        $idx_data= array(
            'order_id'=> $order_id,
            'business'=> $this->business,
            'settlement'=> $this->settlement,
            'grand_total'=> $grand_total,
            'real_grand_total' => $real_grand_total,
            'discount'=> $grand_discount,
            'inter_id'=> $inter_id,
            'hotel_id'=> $this->hotel_id,
            'row_qty'=> $this->row_qty,
            'openid'=> $this->customer->openid,
            'status'=> self::STATUS_WAITING,
            'is_payment'=> self::STATUS_FALSE,
            'channel' => $this->session->tempdata('channel'),
            'create_time'=> date('Y-m-d H:i:s'),
        );

        if(!empty($idxExtraInfo)){
            $idx_data['extra'] = json_encode($idxExtraInfo);
        }

        $this->_shard_db()->insert($this->order_idx_table_name(), $idx_data);

        //echo $this->_shard_db($inter_id)->last_query();

        //保存各个细单
        $save_item_result = $salesItemPackageModel->save_item_new($order_id, $this->product, $this->customer, $this->killsec_instance, $business, $inter_id);


        //记录下单IP地址
        $this->remark_order_ip($this->customer, $business);

        // 交易快照 luguihong 20161031
        $this->load->model('soma/Sales_order_product_record_model','productRecordModel');

        /**
         * @var Sales_order_product_record_model $productRecordModel
         */
        $productRecordModel = $this->productRecordModel;
//        $productRecordModel->order = $this;
//        $productRecordModel->status = Soma_base::STATUS_FALSE;
//        $productRecordModel->product_record_save( $this->inter_id );

        $productRecordModel->product_record_save_new($inter_id, $this->product,$order_id, $this->customer->openid, $data['create_time'], $data['row_qty'], Soma_base::STATUS_FALSE, $business);
    }

	public function _write_log( $content )
	{
	    $path= APPPATH. 'logs'. DS. 'payment'. DS;
	    if( !file_exists($path) ) {
	        @mkdir($path, 0777, TRUE);
	    }
	    $file= $path. 'soma_order_debug_'. date('Y-m-d'). '.txt';
	    $this->write_log($content, $file);
	}

    /**
     * 分时住，根据产品修改订单细单数量
     */
    protected function _modify_order_item_qty()
    {
        $item = $this->item;
        if (empty($this->item)) {
            $item = $this->item = $this->get_order_items($this->m_get('business'), $this->m_get('inter_id'));
        }

        if (empty($item)) {
            return false;
        }

        // 商品快照出来后改为商品快照
        $this->load->model('soma/Product_package_model', 'p_model');
        $product = $this->p_model->load($item[0]['product_id']);

        if($item[0]['use_cnt'] > 1 && $item[0]['can_split_use'] == Soma_base::STATUS_TRUE) {

            $data = array(
                'item_id' => $item[0]['item_id'],
                'qty' => $item[0]['qty'] * $product->m_get('use_cnt')
            );

            //更新了数据库的qty，把变量的也更新了，方便后边用
            $this->item[0]['qty'] = $data['qty'];

            $log_dir = APPPATH. 'logs'. DS. 'soma'. DS .'split_use';
            $log_file = $log_dir . DS . date('Y-m-d_H') . '.txt';
            if( !file_exists($log_file) ) { @mkdir($log_dir, 0777, TRUE); }

            $log = array('order_id' => $this->m_data(), 'update' => $data);
            $this->write_log(var_export($log, true), $log_file);

            $table_name = $this->item_table_name($this->m_get('business'), $this->m_get('inter_id'));

            $db = $this->_shard_db($this->m_get('inter_id'));
            $res = $db->set('qty', $data['qty'])->where('item_id', $data['item_id'])->update($table_name);

            $log['update_result'] = $res;
            $this->write_log(var_export($log, true), $log_file);

            return $res;
        }

        return true;
    }

    /**
     * @param $log_data
     * @param $order_status
     * @param bool $debug
     * @param bool $give_member_package
     * @author renshuai  <renshuai@mofly.cn>
     */
    private function _order_payment($log_data, $order_status, $debug, $give_member_package = true)
    {
        /**
         * 这里会拉订单细单的数据，放到$this->item里
         */
        if (!$this->_modify_order_item_qty()) {
            Soma_base::inst()->show_exception('更新分时住失败.');
        }

        $inter_id = $this->m_get('inter_id');
        $order_id = $this->m_get('order_id');

        // 交易快照 luguihong 20161031
        $this->load->model('soma/Sales_order_product_record_model','ProductRecordModel');
        /**
         * @var Sales_order_product_record_model $ProductRecordModel
         */
        $ProductRecordModel = $this->ProductRecordModel;
        $updateRecordStatusResult = $ProductRecordModel->update_record_status( $this->m_get('openid'), $order_id, $inter_id );
        if (!$updateRecordStatusResult) {
            Soma_base::inst()->show_exception('更新交易快照失败.');
        }

        /***************20160816 luguihong 以下为添加购买商品名称、购买人。为了解决订单管理中，订单列表的调整**************/
        $item = $this->item;
        $item_name = isset( $item[0]['name'] ) ? $item[0]['name'] : '';//购买商品名称

        $contact = '';//购买人，是用openid获取
        $filter = array( 'openid' => $this->m_get('openid') );
        $order_contact = $this->get_customer_contact($filter);
        if($order_contact) {
            $contact = $order_contact['name'];
        }
        /***************以上为添加购买商品名称、购买人。为了解决订单管理中，订单列表的调整*********************************/

        $this->m_save( array(
            'status'=> $order_status,
            'is_payment'=> self::STATUS_TRUE,
            'payment_time'=> date('Y-m-d H:i:s'),
            'update_time'=> date('Y-m-d H:i:s'),
            'transaction_id'=> $log_data['transaction_id'],
            'item_name'=> $item_name,
            'contact'=> $contact,
        ) );

        if($debug) $this->_write_log($log_data['order_id']. ' 保存order表交易流水。');

        //更新订单索引表
        $this->_db()->where( 'order_id', $log_data['order_id'] )->update($this->order_idx_table_name(), array(
            'status'=> $order_status,
            'payment_time'=> date('Y-m-d H:i:s'),
            'is_payment'=> self::STATUS_TRUE,
        ));

        if($debug) $this->_write_log($log_data['order_id']. ' 保存order_idx表。');

        //核销订单中的所有优惠券/积分
        $this->load->model('soma/Sales_order_discount_model');
        /**
         * @var Sales_order_discount_model $discount_model
         */
        $discount_model= $this->Sales_order_discount_model;
        $discount_model->used_discount($order_id, $inter_id);//优惠券批量使用，这里需要改成多个mcid 8

        if($debug) $this->_write_log($log_data['order_id']. ' 锁定订单所用优惠券。');

        //分销业绩计算写入
        $this->load->model('soma/Reward_benefit_model');
        /**
         * @var Reward_benefit_model $benefit_model
         */
        $benefit_model = $this->Reward_benefit_model;
        $benefit_model->write_benefit_queue($inter_id, $this);

        if($debug) $this->_write_log($log_data['order_id']. ' 分销业绩计算写入。');

        /**
         * 购买成功赠送会员礼包，拼团购买的暂时不送
         * @author     luguihong    2017/02/22
         */
        if( $this->m_get('settlement') != self::SETTLE_GROUPON && $give_member_package )
        {
            $this->load->model('soma/Config_member_package_model','somaConfigMemberModel');
            $somaConfigMemberModel = $this->somaConfigMemberModel;
            $memberRecordData[] = array(
                'inter_id'      => $inter_id,
                'openid'        => $this->m_get('openid'),
                'send_id'       => $order_id,
                'product_id'    => $item[0]['product_id'],
                'num'           => $item[0]['qty'],
                'type'          => $somaConfigMemberModel::TYPE_BUY_SUCCESS,
                'create_time'   => date('Y-m-d H:i:s'),
                'status'        => $somaConfigMemberModel::RECORD_STATUS_PENDING,
            );
            $somaConfigMemberModel->insert_record( $this, $inter_id, $memberRecordData );
        }

        //对接设备处理
        $this->load->model('soma/Product_package_model');
        $productPackageModel = $this->Product_package_model;
        $this->_write_log("同步智游宝 order_id:{$order_id} product_id:{$item[0]['product_id']} conn_devices:{$item[0]['conn_devices']}");
        if( isset( $item[0]['conn_devices'] ) && $item[0]['conn_devices'] != $productPackageModel::DEVICE_NO_CONN )
        {
            $conn_devices_res = $this->m_save( array(
                'conn_devices_status'=> self::CONN_DEVICES_DEFAULT,
            ) );
            $this->_write_log("同步智游宝 result：{$conn_devices_res}");

            switch ( $item[0]['conn_devices'] )
            {
                case $productPackageModel::DEVICE_ZHIYOUBAO:
                    //对接智游宝，放到定时任务里面
//                    $this->load->library('Soma/Api_zhiyoubao');
//                    $api= new Api_zhiyoubao( $item[0]['inter_id'] );
//                    $api->send_order( $this->m_get('order_id') );
                    break;
                default:
                    break;
            }
        }

        // 产品销量更新
        $productPackageModel->increase($item[0]['product_id'], 'sales_cnt', $item[0]['qty']);
    }

    /**
     * 订单支付操作
     * @param $log_data
     * @param int $order_status
     * @return bool
     * @author renshuai  <renshuai@mofly.cn>
     */
	public function order_payment($log_data, $order_status = self::STATUS_PAYMENT)
	{
	    $debug= FALSE;  //开启支付节点记录
	    if($debug) $this->_write_log($log_data['order_id']. ' 进入支付流程');

        try {
            $inter_id = $this->m_get('inter_id');

            $this->_shard_db($inter_id)->trans_begin();

            $this->business = $this->m_get('business');
            $this->inter_id = $inter_id;
            $this->_order_payment($log_data, $order_status, $debug);

            // 写入分账
            App\services\soma\SeparateBillingService::getInstance()->writeOrderSeparateBilling($this->m_get('order_id'));

            //更新子订单状态 start ==========================
            $childs = $this->get('master_oid', $this->m_get('order_id'), 'master_oid,order_id', ['limit' => 100]);
            if (!empty($childs)) {
                if($debug) $this->_write_log($log_data['order_id']. ' begin 子订单支付流程');
                foreach ($childs as $childOrder) {
                    $childOrderNew = new self();
                    /**
                     * @var Sales_order_model $childOrderNew
                     */
                    $childOrderNew = $childOrderNew->load($childOrder['order_id']);

                    $childOrderNew->business = $this->m_get('business');
                    $childOrderNew->inter_id = $inter_id;

                    $childOrderNew->_order_payment($log_data, $order_status, $debug, false);

                    //分配资产
                    $this->load->model('soma/asset_customer_model', 'assetCustomerModel');
                    /**
                     * @var Asset_customer_model $assetCustomerModel
                     */
                    $assetCustomerModel = $this->assetCustomerModel;
                    $sign_asset_result = $assetCustomerModel->sign_asset_item($childOrderNew, $inter_id);
                }
                if($debug) $this->_write_log($log_data['order_id']. ' end 子订单支付流程');
            }
            //更新子订单状态 end ==========================

            // 直播添加需要参数
            // $zbcode = $this->input->get('zbcode', true);
            // $channel_id = $this->input->get('channelid', true);
            $redis = $this->get_redis_instance();
            $redis_key = $this->get_zb_order_redis_key();
            if($redis_key && $redis_info = $redis->get($redis_key))
            {
                $zb_info = json_decode($redis_info, true);
                $item = $this->item;
                if (empty($item)) {
                    $item = $this->item = $this->get_order_items($this->m_get('business'), $this->m_get('inter_id'));
                }
                if(!empty($item)) {
                    $qty = $item[0]['qty'];
                    if($item[0]['can_split_use'] == Soma_base::STATUS_TRUE && $item[0]['use_cnt'] > 1) {
                        $qty /= $item[0]['use_cnt'];
                    }
                    
                    $this->load->model ( 'livebc/Record_model' );
                    $this->Record_model->buy_goods_add_mibi($item[0]['product_id'], $zb_info['zbcode'], $zb_info['channelid'], $qty);
                }
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

	/**
	 * 订单支付后续操作
	 * Usage: $model->load($id)->order_payment();
	 */
	public function order_payment_post()
	{
	    //各个business其他分支动作
	    $order_id = $this->m_get('order_id');
	    $inter_id = $this->m_get('inter_id');
	    $openid  = $this->m_get('openid');
	    $business = $this->m_get('business');

        $debug= FALSE;  //开启支付节点记录
        if ($debug) $this->_write_log("order_payment_post(order_id):" . $order_id);
	    
	    //各个settlement其他分支动作
	    $settlement= $this->m_get('settlement');
	    switch($settlement){
	        case 'groupon':
	            $this->load->model('soma/activity_groupon_model');
	            $activityGrouponModel =  $this->activity_groupon_model;
	            $userGroup = $activityGrouponModel->get_users_by_order_id( $order_id );
	            $groupon = $activityGrouponModel->groupon_group_detail($userGroup['group_id']);
	            $actInfo = $activityGrouponModel->groupon_detail($groupon['act_id']);
	    
	            $groupon['openid'] = $userGroup['openid'];
	            $groupon['act_id'] = $actInfo['act_id'];
	            $groupon['inter_id'] = $actInfo['inter_id'];
	    
	            $activityGrouponModel->groupon_user_update($groupon['group_id'], $order_id, $groupon['openid'], $activityGrouponModel::GROUP_ADD_STATUS_SUCCESS);
	            $users = $activityGrouponModel->groupon_group_users($groupon['group_id'],$activityGrouponModel::GROUP_ADD_STATUS_SUCCESS, $inter_id);
	            $grouponStatus = $activityGrouponModel->groupon_status_check($groupon,$users);

                if ($debug) $this->_write_log("order_payment_post(grouponStatus):" . $grouponStatus);

	            if($grouponStatus == $activityGrouponModel::GROUP_STATUS_FINISHED){  //拼团订单成团
	                $activityGrouponModel->update_groupon_group($groupon['group_id'],$activityGrouponModel::GROUP_STATUS_FINISHED,$inter_id); //拼团成功状态切换

                    //分配资产库
                    foreach($users as $v) {

                        /**
                         * @var Sales_order_model $order
                         */
                        $order = $this;
                        /**
                         * 分时住那里修改了item里的qty，所以这里还是在读一遍
                         */
                        $order->item = $this->get_order_items($business, $inter_id);

                        if ($v['order_id'] != $order_id) {

                            $order = (new self())->load($v['order_id']);
                            $order->m_set('business', $business);
                            $order->business = $business;
                        }

                        if ($order->m_get('order_id')) {
                            /*分销*/
                            if ($v['openid'] == $groupon['create_openid']) {

                                $this->load->model('soma/Reward_benefit_model', 'RewardBenefitModel');
                                $RewardBenefitModel = $this->RewardBenefitModel;
                                $RewardBenefitModel->modify_benefit_queue_check($groupon['inter_id'], $order);
                            }

                            $order->sign_item_to_asset($business, $groupon['inter_id']);
                            $order->order_paid($business, $inter_id);
                        }
                    }

	                //团购成功
	                /***********************发送模版消息****************************/
	    
	                $this->load->model('soma/Message_wxtemp_template_model','MessageWxtempTemplateModel');
	                $messageWxtempTemplateModel = $this->MessageWxtempTemplateModel;
	    
	                $activityGrouponModel->order_id = $order_id;
	    
	                $messageWxtempTemplateModel->send_template_by_groupon_success( $activityGrouponModel, $groupon['inter_id'], $business);
	    
	                /***********************发送模版消息****************************/
	    
	            } else if($grouponStatus == $activityGrouponModel::GROUP_STATUS_ING) {  //参团
	                $this->load->model('soma/Sales_order_model', 'soma_sales_order_model'); 
                    $this->soma_sales_order_model->load($order_id)->order_grouping(); //个人订单切到拼团中
	    
	            } else if($grouponStatus == $activityGrouponModel::GROUP_STATUS_WAITING_PAY) { //第一个拼团用户
	                $activityGrouponModel->update_groupon_group($groupon['group_id'],$activityGrouponModel::GROUP_STATUS_ING,$inter_id); //用户个人拼团成功状态切换
                    $this->order_grouping(); //个人订单切到拼团中
	            }
	            break;
	    
	        case 'killsec':
                \App\services\soma\KillsecService::getInstance()->payed($order_id, $openid, $this->m_get('row_qty'));
	            break;

	    }

        if (!in_array($settlement, array('groupon'))) {

            $this->load->model('soma/asset_customer_model', 'assetCustomerModel');
            /**
             * @var Asset_customer_model $assetCustomerModel
             */
            $assetCustomerModel = $this->assetCustomerModel;

            $sign_asset_result = $assetCustomerModel->sign_asset_item($this, $inter_id);
            if (!$sign_asset_result) {
                return false;
            }

            $item = $this->item;
            $send_flag = true;
            if(isset($item[0]) && isset($item[0]['type']) && $item[0]['type'] == Sales_order_model::PRODUCT_TYPE_SHIPPING) {
                $send_flag = false;
            }
            //购买成功
            /***********************发送模版消息****************************/
            if($send_flag) {
                $this->load->model('soma/Message_wxtemp_template_model','MessageWxtempTemplateModel');
                /**
                 * @var Message_wxtemp_template_model $messageWxtempTemplateModel
                 */
                $messageWxtempTemplateModel = $this->MessageWxtempTemplateModel;
                $messageWxtempTemplateModel->send_template_by_buy_success( $this, $openid, $inter_id, $business);
            }

            /***********************发送模版消息****************************/
        }

        // 进行邮费核销处理
        $this->consumer_shipping();

            //需要直接邮寄
            $this->load->model('soma/Sales_order_idx_model','SalesOrderIdxModel');
            $mailInfo = $this->SalesOrderIdxModel->get_extra_value($order_id,'mail');
            if($mailInfo){

//                $this->_write_log( '邮寄：' . $order_id. json_encode($mailInfo));

                $this->load->model('soma/Consumer_order_model','ConsumerOrderModel');
                $ConsumerOrderModel = $this->ConsumerOrderModel;

                //是否使用的是微信地址

                $SalesOrderModel = $this->load($order_id);
                if( !$SalesOrderModel ){
                    return false;
                }

                //检查能否邮寄
                if( !$SalesOrderModel->can_mail_order() ){
                    return false ;
                }

                $detail = $SalesOrderModel->get_order_asset($business,$inter_id); //资产订单
                \App\libraries\Support\Log::error('邮寄：' . $order_id. '资产', $detail);
                $arid = $mailInfo['address_id']; //地址ID

                foreach( $detail['items'] as $mailItem){
                    $mailPost = array(
                        'aiid' =>$mailItem['item_id'],                 //资产细单ID
                        'arid' =>$arid,                //地址ID
                        'num' => $mailItem['qty'],                   //邮寄数量
                        'datetime' =>'',             //预约发货时间
                        'note' =>'',                //备注
                    );
                    $result = $ConsumerOrderModel->mail_consumer( $mailPost, $openid, $inter_id, $business );
                    \App\libraries\Support\Log::error('邮寄：' . $order_id. ' | aiid : '.$mailItem['item_id'], $result);

                    if( isset( $result['status'] ) && $result['status'] == Soma_base::STATUS_TRUE ){

                    }else{
                        return FALSE;
                    }

                }


            }
            //end需要直接邮寄


        // 插入短信记录，组合商品主订单不发
        $item = $this->item;
        $this->load->model('soma/Product_package_link_model', 'somaProductPackageLink');
        $childs = $this->somaProductPackageLink->get('parent_pid', $item[0]['product_id']);

        if(empty($childs) && $item[0]['can_sms_notify'] == self::STATUS_CAN_YES) {

            $this->load->model('soma/Sms_model', 'somaSmsModel');
            $this->somaSmsModel->switch_db($this->db_soma);
            $smsData = $this->somaSmsModel->get_order_success_sms($this->m_get('order_id'));
            if($smsData['res'])
            {
                $this->somaSmsModel->sms_insert($this->m_get('inter_id'), Sms_model::SMS_TYPE_ORDER_SUCCESS, $this->m_get('order_id'), $smsData['data']);
            }
            else
            {
                \App\libraries\Support\Log::error($smsData['msg']);
            }
        }

        // 发送后台通知
        $this->load->model('soma/message_wxtemp_template_model', 'message_model');
        if ($message = $this->message_model->getOrderAdminNoticeMessage($order_id)) {
            $this->load->model('hotel/hotel_notify_model');
            $this->hotel_notify_model->insert_wxmsg_queue(
                $this->m_get('inter_id'),
                $this->m_get('hotel_id'),
                'soma',
                16,
                $message
            );
        }

        // 升级房券进行订单自动核销
        $this->load->model('soma/Product_package_model');
        if (!empty($item[0]['goods_type']) 
            && $item[0]['goods_type'] == Product_package_model::SPEC_TYPE_ROOM) {
            \App\services\soma\consumer\ConsumerService::getInstance()->orderConsumer($order_id, $inter_id);
        }

	    return TRUE;
	}
	
	/**
	 * 在支付回掉处判断，成功将细单保存在资产库
	 * Usage: $model->load($id)->sign_item_to_asset();
	 */
	public function sign_item_to_asset($business, $inter_id)
	{

        //根据业务类型初始化对象
        $business = strtolower($business);
        $item_object_name = "Sales_item_{$business}_model";

        $this->load->model($item_object_name, 'salesItemPackageModel');
        /**
         * @var Sales_item_interface|Sales_item_package_model|Sales_item_groupon_model $salesItemPackageModel
         */
        $salesItemPackageModel = $this->salesItemPackageModel;

        $result = $salesItemPackageModel->sign_item_to_asset($this, $inter_id);

	}
	
    /**
     * 显示订单细单明细
     * @param $business
     * @param $inter_id
     * @return mixed
     * @author renshuai  <renshuai@mofly.cn>
     */
	public function get_order_items($business, $inter_id)
	{
	    $primary_key = $this->table_primary_key();
	    if( !$this->m_get($primary_key) ){
	        Soma_base::inst()->show_exception('Please Load Model first.');
	    }
	    //根据业务类型初始化对象
	    $business= strtolower($business);
	    $item_object_name= "soma/Sales_item_{$business}_model";
        $this->load->model($item_object_name, 'salesItemPackageModel');
        /**
         * @var Sales_item_package_model $sales_item_package_model
         */
	    $sales_item_package_model = $this->salesItemPackageModel;

        $this->business = $business;
	    //细单订单保存支付
	    $result = $sales_item_package_model->get_order_items($this, $inter_id);
	    return $result;
	    
	}
	/**
	 * 显示订单列表
	 * Usage: $model->get_order_list('package', 'a123456789', array('openid'=>'asgaehae'), 'order_id desc', '20,150' );
	 */
	public function get_order_list($business, $inter_id, $filter, $sort=NULL, $limit=NULL )
	{
	    //根据业务类型初始化对象
	    $business= strtolower($business);
	    $item_object_name= "Sales_item_{$business}_model";
	    require_once dirname(__FILE__). DS. "$item_object_name.php";
	    $object= new $item_object_name();
	    
	    $ids = array();
	    $data = $this->find_all($filter, $sort, $limit);

	    $pk= $this->table_primary_key();
	    foreach ($data as $k=> $v){
	        array_push($ids , $v[$pk]);
	        //将主单排好序
	    }

	    if( count($ids)>0 ){
	        $items= $object->get_order_items_byIds($ids, $business, $inter_id);

            foreach($data as &$order) {
                foreach($items as $item) {

                    if ($order['order_id'] == $item['order_id']) {
                        $order['items'] = $item;
                    }
                }
            }
        }


        return $data;
	}

    /**
     * 显示订单列表
     * Usage: $model->get_order_list('package', 'a123456789', array('openid'=>'asgaehae'), 'order_id desc', '20,150' );
     */
    public function get_order_list_with_filter($business, $inter_id, $filter, $sort=NULL, $limit=NULL )
    {
        $db = $this->_shard_db_r('iwide_soma_r');
        foreach($filter as $k=> $v){
            if(is_array($v)){
                $searchKey = implode(',',$v);
                $searchKey = explode(',',$searchKey);
            }else{
                $searchKey = $v;
            }
            $db->where_in($k,$searchKey);
        }
        //根据业务类型初始化对象
        $business= strtolower($business);
        $item_object_name= "Sales_item_{$business}_model";
        require_once dirname(__FILE__). DS. "$item_object_name.php";
        $object= new $item_object_name();

        $ids= $sort_data= array();

        $table = $this->table_name($inter_id);
        $data = $db
                ->order_by($sort)
                ->limit($limit)
//                ->where('openid',$searchKey)
                ->get($table)
                ->result_array();
        //$data= $this->find_all($filter, $sort, $limit);
        $pk= $this->table_primary_key();
        foreach ($data as $k=> $v){
            array_push($ids , $v[$pk]);
            //将主单排好序
            $sort_data[$v[$pk]]= $v;
        }

        if( count($ids)>0 ){
            $items= $object->get_order_items_byIds($ids, $business, $inter_id);
            foreach ($items as $k=> $v){
                //将细单按照上面排好的顺序加入到 items 数组中
                $sort_data[$v[$pk]]['items'][]= $v;
            }
        }

        return $sort_data;
    }

	/**
	 * 获取显示订单详情
	 * Usage: $model->load($id)->get_order_detail();
	 */
	public function get_order_detail($business, $inter_id)
	{
	    $primary_key= $this->table_primary_key();
	    if( !$this->m_get($primary_key) ){
	        Soma_base::inst()->show_exception('Please Load Model first.');
	    }
	    $detail= $this->m_data();
	    $detail['items']= $this->get_order_items($business, $inter_id);
	    return $detail;
	}
	/**
	 * 获取订单对应的资产明细
	 * Usage: $model->load($id)->get_order_asset();
	 */
	public function get_order_asset($business, $inter_id)
	{
	    $primary_key= $this->table_primary_key();
	    if( !$this->m_get($primary_key) ){
	        Soma_base::inst()->show_exception('Please Load Model first.');
	    }
	    //根据业务类型初始化对象
	    $business= strtolower($business);
	    $item_object_name= "Sales_item_{$business}_model";
	    require_once dirname(__FILE__). DS. "$item_object_name.php";
	    $object= new $item_object_name();
	    
	    $detail= $this->m_data();
	    $detail['items']= $object->get_asset_items($this, $inter_id);
	    return $detail;
	}

    /**
     * 获取订单对应的消费明细
     * Usage: $model->load($id)->get_order_consumer();
     */
    public function get_order_consumer($business, $inter_id)
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
        
        $detail= $this->m_data();
        $detail['items']= $object->get_order_items($this, $inter_id);
        return $detail;
    }
	
	/**
	 * 订单取消操作（未完成）
	 * Usage: $model->load($id)->order_cancel();
	 */
	public function order_cancel($business, $inter_id)
	{
	    try {
	        $this->_shard_db($inter_id)->trans_begin ();
	        
	        $business= strtolower($business);
    	    $item_object_name= "Sales_item_{$business}_model";
    	    require_once dirname(__FILE__). DS. "$item_object_name.php";
    	    $object= new $item_object_name();
	        
    	    $primary_key= $this->table_primary_key();
    	    
    	    $status= $this->m_get('status');
    	    if( in_array($status, $this->can_cancel_status() )){
    	        
    	        //处理订单主单状态
    	        $this->m_set('status', self::STATUS_CANCLE )->m_save();
    	        
    	        //处理订单细单状态
    	        
    	        //释放商品库存
    	        
    	    } else {
    	        return FALSE;
    	    }
    	    
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
	 * 订单挂起操作
	 * Usage: $model->load($id)->order_holding();
	 */
	public function order_holding()
	{
	    try {
    	    $primary_key= $this->table_primary_key();
    	    if( !$this->m_get($primary_key) ){
    	        Soma_base::inst()->show_exception('Please Load Model first.');
    	    }
    	    $this->m_set('status', self::STATUS_HOLDING )
                ->m_save();
    	    return TRUE;
	     
	    } catch (Exception $e) {
	        return FALSE;
	    }
	}

    /**
     * 无效订单操作
     * Usage: $model->load($id)->order_holding();
     */
    public function order_un_valid()
    {
        try {
            $primary_key= $this->table_primary_key();
            if( !$this->m_get($primary_key) ){
                Soma_base::inst()->show_exception('Please Load Model first.');
            }
            $this->m_set('status', self::STATUS_UN_VALID )
                ->m_save();
            return TRUE;
         
        } catch (Exception $e) {
            return FALSE;
        }
    }

	/**
	 * 订单异常处理操作
	 * Usage: $model->load($id)->order_holding();
	 */
	public function order_pay_exception()
	{
	    try {
    	    $primary_key= $this->table_primary_key();
    	    if( !$this->m_get($primary_key) ){
    	        Soma_base::inst()->show_exception('Please Load Model first.');
    	    }
    	    $this->m_set('status', self::STATUS_EXCEPTION_PAY )
                ->m_save();
    	    return TRUE;
	     
	    } catch (Exception $e) {
	        return FALSE;
	    }
	}

    /**
     * 订单切换到 订单拼团进行中
     * Usage: $model->load($id)->order_holding();
     */
    public function order_grouping()
    {
        $primary_key= $this->table_primary_key();
        if( !$this->m_get($primary_key) ){
            Soma_base::inst()->show_exception('Please Load Model first.');
        }
        $this->m_set('status', self::STATUS_GROUPING )
            ->m_save();
        $this->_write_log("order_grouping(order_status):" . $this->m_get('order_id') . '_'. $this->m_get('status'));
        return ;
    }

    /**
     * 订单支付完成操作
     * Usage: $model->load($id)->order_paid();
     */
    public function order_paid($business, $inter_id)
    {
        $primary_key= $this->table_primary_key();
        if( !$this->m_get($primary_key) ){
            Soma_base::inst()->show_exception('Please Load Model first.');
        }
        $this->m_set('status', self::STATUS_PAYMENT )
            ->m_save();
        return ;
    }


    /**
     * 改变主单的状态位（退款管理）
     * Usage: $model->refund_status = $refund_status;
     * Usage: $model->is_refund = $is_refund;
     * Usage: $model->load($order_id)->order_refund_status($business, $inter_id);
     * Usage: $salesRefundModel; 为了保存事务一致性
     * @author luguihong
     */
    public function order_refund_status( $business, $inter_id, $salesRefundModel )
    {
        //处理主单
        $business= strtolower($business);
        $this->business = $business;
        
        //标记主单需要修改的状态位，refund为需要修改的数组数据
        $refund = $this->refund;

        $data = array();

        //退款位
        $refund_status = isset( $refund['refund_status'] ) ? $refund['refund_status'] : '';//没有传值过来默认为全部退款
        if( $refund_status ){
            $data['refund_status'] = $refund_status;
        }

        //消费位
        $consume_status = isset( $refund['consume_status'] ) ? $refund['consume_status'] : '';
        if( $consume_status ){
            $data['consume_status'] = $consume_status;
        }

        //状态位
        $status = isset( $refund['status'] ) ? $refund['status'] : '';//改变主单状态
        if( $status ){
            $data['status'] = $status;
        }

        $result = TRUE;
        if( !empty( $data ) ){
            $where = array();
            $pk = $this->table_primary_key();
            $where[$pk] = $this->m_get( $pk );
            $where['inter_id'] = $inter_id;

            $table_name = $this->table_name();
            $salesRefundModel->_shard_db( $inter_id )
                                        ->where( $where )
                                        ->update( $table_name, $data );

            if( $salesRefundModel->_shard_db( $inter_id )->affected_rows() > 0 ){
                //$result = TRUE;
            }else{
                $result = FALSE;
            }
        }

        //处理细单
        $item_object_name= "Sales_item_{$business}_model";
        require_once dirname(__FILE__). DS. "$item_object_name.php";
        $object= new $item_object_name();
        $order_item_result = $object->order_refund_status( $this, $inter_id, $salesRefundModel );
        if( $result && $order_item_result ){
            return TRUE;
        }else{
            return FALSE;
        }
        
    }

    /**
     * 导出订单细单明细
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
            $db->where('create_time >=', $start);
        }
        if($end) {
            if( strlen($end)<=10 ) $end.= ' 23:59:59';
            $db->where('create_time <', $end);
        }
         
        //不设定时间最多导出3个月的数据
        if(!$start && !$end){
            $db->where('create_time >', date('Y-m-d H:i:s', strtotime('-3 month') ) );
        }
        $orders = $db->select('order_id, openid, member_card_id, contact, mobile,settlement, create_time, payment_time, status, consume_status, refund_status, grand_total, real_grand_total, balance_total, point_total, conpon_total, saler_id, fans_saler_id, remark')
            ->order_by('order_id desc')->get( $this->table_name( $inter_id ) )->result_array();
        // echo $this->_shard_db()->last_query();die;
        if( count( $orders ) == 0 )return array();
        //var_dump( $orders );exit;
        $ids= array();
        foreach ($orders as $k=>$v){
            $ids[$v['order_id']]= array(
                'openid'=>$v['openid'],
                'member_card_id' => $v['member_card_id'],
                'contact'=>$v['contact'],
                'mobile'=>$v['mobile'],
                'settlement'=>$v['settlement'],
                'create_time'=>$v['create_time'],
                'payment_time'=>$v['payment_time'],
                'status'=>$v['status'],
                'consume_status'=>$v['consume_status'],
                'refund_status'=>$v['refund_status'],
                // 'grand_total'=>$v['grand_total'],
                'real_grand_total'=>$v['real_grand_total'],
                'balance_total' => $v['balance_total'],
                'point_total' => $v['point_total'],
                'conpon_total' => $v['conpon_total'],
                'gift_total'=>0,//用于下面计算赠送数量
                'shipping_total'=>0,//用于下面计算邮寄数量
                'shipping_ids'=>'',//用于下面计算邮寄id
                'shipment_total'=>0,//邮寄＋自提
                'consumer_total'=>0,//用于下面计算自提数量
                /** edit by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 start  **/
                'saler_id' => $v['saler_id'],// 订单分销员ID
                'fans_saler_id' => $v['fans_saler_id'],// 分销粉丝ID
                'not_verificated_num' => 0,// 未核销总数
                'overdue_num' => 0,// 已过期总数
                'verificated_num' => 0,// 已核销总数
                'remark' => $v['remark'],
                /** edit by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 end  **/
            );
        }

        $table_item = $this->item_table_name( $business, $inter_id );
        $items = $this->_shard_db_r('iwide_soma_r')
                        ->where_in('order_id', array_keys($ids) )
                        ->get( $table_item )
                        ->result_array();
        
        $asset_item = $this->asset_item_table_name( $business, $inter_id );
        $asset_items_= $this->_shard_db_r('iwide_soma_r')
                            ->where_in('order_id', array_keys($ids) )
                            ->get( $asset_item )
                            ->result_array();

        //针对赠送的资产细单发生转移的情况，用order_id进行qty合并。
        //$asset_items= $this->array_to_hash($asset_items, 'qty', 'order_id');
        $gids = array();
        $gift_list = array();
        $asset_items= array();
        foreach ($asset_items_ as $k=> $v) {

            if( $v['qty'] > 0 ){
                if( isset($asset_items[$v['order_id']]) ){
                    $asset_items[$v['order_id']]+= $v['qty'];
                } else {
                    $asset_items[$v['order_id']] = $v['qty'];
                }
            }

            /***************************查找赠送单号start****************************/
            //筛选出赠送数量  不能在资产判断赠送数量，1->2->3很难判断原始单赠送出的数量，要拿到原始单第一次赠送的赠送ID到赠送表查询
            if( isset($gift_list[$v['order_id']]) && !empty( $v['gift_id'] ) ){
                if( $v['parent_id'] == $gift_list[$v['order_id']]['item_id'] ){
                    $gift_list[$v['order_id']]['qty']+= $v['qty'];
                    $gift_list[$v['order_id']]['parent_id'] = $v['parent_id'];

                    //防止群发的一个赠送单号有多条记录
                    if( isset( $gift_list[$v['order_id']]['gift_ids'] ) && !in_array( $v['gift_id'], $gift_list[$v['order_id']]['gift_ids'] ) ){
                        $gift_list[$v['order_id']]['gift_ids'][] = $v['gift_id'];

                        $gids[] = $v['gift_id'];
                    }
                }
            }else{
                $gift_list[$v['order_id']]['qty'] = $v['qty'];
                $gift_list[$v['order_id']]['gift_num'] = 0;
                $gift_list[$v['order_id']]['item_id'] = $v['item_id'];
                $gift_list[$v['order_id']]['gift_ids'] = array();
            }
            /***************************查找赠送单号end****************************/

        }
        //print_r($asset_items);die;

        /***************************计算赠送数量start ok ****************************/
        //到赠送细单，查找赠送数量
        if( count( $gids ) > 0 ){
            $gift_item_table = $this->gift_item_table_name( $business, $inter_id );
            $gifts = $this->_shard_db_r('iwide_soma_r')
                                    ->where_in( 'gift_id', $gids )
                                    ->select('gift_id,asset_item_id,qty')
                                    ->get($gift_item_table)
                                    ->result_array();
        
            /*
                array(
                    array('gift_id'=>1000000932,'qty'=>1),
                    array('gift_id'=>1000000933,'qty'=>1),
                )
            */

            //计算一个单号下赠送的数量
            foreach ($gift_list as $k => $v) {
                if( isset( $v['gift_ids'] ) && count( $v['gift_ids'] ) > 0 ){
                    foreach ($gifts as $sk => $sv) {
                        if( $v['item_id'] == $sv['asset_item_id'] && in_array( $sv['gift_id'], $v['gift_ids'] ) ){
                            $gift_list[$k]['gift_num'] += $sv['qty'];
                        }
                    }
                }

                $ids[$k]['gift_total'] = $gift_list[$k]['gift_num'];
            }
        }
        /***************************计算赠送数量end ok ****************************/

        /***************************计算邮寄数量start ok ****************************/
        //到邮寄表，查找邮寄数量
        $mail_item_table = $this->mail_table_name( $inter_id );
        $mails = $this->_shard_db_r('iwide_soma_r')
                                ->where_in( 'order_id', array_keys( $ids ) )
                                ->select('shipping_id,order_id,qty')
                                ->get($mail_item_table)
                                ->result_array();
        /*
            array(
                array('shipping_id'=>1,'order_id'=>10000002110,'qty'=>1),
                array('shipping_id'=>2,'order_id'=>10000002111,'qty'=>2),
            )
        */

        //计算一个单号下赠送的数量
        foreach ($mails as $k => $v) {
            foreach ($ids as $sk => $sv) {
                if( $v['order_id'] == $sk ){
                    $ids[$sk]['shipping_total'] += $v['qty'];
                    $ids[$sk]['shipping_ids'] .= $v['shipping_id'] . '、';
                }
            }
        }
        /***************************计算邮寄数量end ok ****************************/

        /***************************计算自提数量start ok ****************************/
        //到自提表，查找自提数量
        $this->load->model('soma/Consumer_order_model','ConsumerModel');
        $ConsumerModel = $this->ConsumerModel;
        $consumer_pk = $ConsumerModel->table_primary_key();

        $consumer_item_table = $ConsumerModel->item_table_name($business, $inter_id);
        $consumer_items = $this->_shard_db_r('iwide_soma_r')
                                ->where_in( 'order_id', array_keys( $ids ) )
                                ->select('consumer_id,order_id,consumer_qty')
                                ->get($consumer_item_table)
                                ->result_array();
        //组装消费ID
        $consumerIds = array();
        foreach ($consumer_items as $k => $v) {
            $consumerIds[] = $v['consumer_id'];
        }

        if( count( $consumerIds ) > 0 ){
            $consumer_table = $ConsumerModel->table_name( $inter_id );
            $consumers = $this->_shard_db_r('iwide_soma_r')
                                    ->where( 'consumer_type', $ConsumerModel::CONSUME_TYPE_DEFAULT )
                                    ->where( 'status', $ConsumerModel::STATUS_ALLUSE )
                                    ->where_in( $consumer_pk, $consumerIds )
                                    ->select('consumer_id,row_qty')
                                    ->get($consumer_table)
                                    ->result_array();
    // var_dump( $consumerIds,$consumers );die;
            /*
                array(
                    array('consumer_id'=>1,'order_id'=>10000002110,'row_qty'=>1),
                    array('consumer_id'=>2,'order_id'=>10000002111,'row_qty'=>2),
                )
            */

            //计算一个单号下赠送的数量
            foreach ($consumers as $k => $v) {
                foreach ($consumer_items as $sk => $sv) {
                    if( $v[$consumer_pk] == $sv[$consumer_pk] ){
                        $ids[$sv['order_id']]['consumer_total'] += $v['row_qty'];
                    }
                }
            }
        }
        /***************************计算自提数量end ok ****************************/

        /** add by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 start  **/
        $overdue_ids = array();// 已过期订单id集合
        $not_overdue_ids = array();// 未过期订单id集合
        foreach($items as $val){
            if(strtotime($val['expiration_date']) >= time()){
                $not_overdue_ids[] = $val['order_id'];
            }else{
                $overdue_ids[] = $val['order_id'];
            }
        }
        $code_table = $this->code_table_name( $inter_id );
        // 未核销数量集合（未过期未核销）
        if(!empty($not_overdue_ids)){
            $not_verificated_data = $this->_shard_db_r( 'iwide_soma_r' )
                ->where('status', 2)
                ->where_in( 'order_id', $not_overdue_ids )
                ->select( 'order_id,count(*) as not_verificated_num' )
                ->group_by('order_id')
                ->get( $code_table )
                ->result_array();
            // 压入未核销总数
            if(!empty($not_verificated_data)){
                foreach($not_verificated_data as $val){
                    $ids[$val['order_id']]['not_verificated_num'] = $val['not_verificated_num'];
                }
            }
        }
        // 已过期数量集合（已过期未核销）
        if(!empty($overdue_ids)){
            $overdue_data = $this->_shard_db_r( 'iwide_soma_r' )
                ->where('status', 2)
                ->where_in( 'order_id', $overdue_ids )
                ->select( 'order_id,count(*) as overdue_num' )
                ->group_by('order_id')
                ->get( $code_table )
                ->result_array();
            // 压入已过期总数
            if(!empty($overdue_data)){
                foreach($overdue_data as $val){
                    $ids[$val['order_id']]['overdue_num'] = $val['overdue_num'];
                }
            }
        }
        // 已核销数量集合（已核销）
        $verificated_data = $this->_shard_db_r( 'iwide_soma_r' )
            ->where('status', 3)
            ->where_in( 'order_id', array_keys( $ids ) )
            ->select( 'order_id,count(*) as verificated_num' )
            ->group_by('order_id')
            ->get( $code_table )
            ->result_array();
        // 压入已核销总数
        if(!empty($verificated_data)){
            foreach($verificated_data as $val){
                $ids[$val['order_id']]['verificated_num'] = $val['verificated_num'];
            }
        }
        /** add by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 start  **/

// print_r( $gifts );
// print_r( $gift_list );
// print_r( $ids );die;

        $hotels= array();
        foreach ($items as $k=> $v)
        {
            $hotels[$v['hotel_id']]= $v['hotel_id'];
        }

        if( count( $hotels ) > 0 )
        {

            $this->load->model('hotel/Hotel_ext_model');
            $hotel= $this->Hotel_ext_model->get_data_filter( array('hotel_id'=> array_values($hotels),'inter_id'=>$inter_id ) );
            $hotel= $this->Hotel_ext_model->array_to_hash( $hotel, 'name', 'hotel_id' );
        } else {
            $hotel = array();
        }

        $result= array();
        
        //$this->load->model("soma/sales_item_{$business}_model", 'item_model');

        $status_arr= $this->get_status_label();
        $settle_arr= $this->get_settle_label();
        $consume_arr= $this->get_consume_label();
        $refund_arr = $this->get_refund_label();
        // var_dump( $ids );
        foreach ($items as $k=>$v){
            $result[$k]['order_id'] = $v['order_id'];
// echo $ids[$v['order_id']]['refund_status'];
            // $result[$k]['openid'] = $ids[$v['order_id']]['openid'];
            // $userinfo = $this->get_userinfo( $ids[$v['order_id']]['openid'] );
            // $result[$k]['mobile'] = isset( $userinfo['mobile'] ) ? $userinfo['mobile'] : '';
            // var_dump($ids[$v['order_id']]);exit;
            if(isset($ids[$v['order_id']]['mobile'])
                && $ids[$v['order_id']]['mobile'] != '') {
                $result[$k]['openid'] = $ids[$v['order_id']]['contact'];
                $result[$k]['mobile'] = $ids[$v['order_id']]['mobile'];
            } else {
                $userinfo = $this->get_userinfo( $ids[$v['order_id']]['openid'] );
                // var_dump($userinfo);exit;
                $result[$k]['openid'] = $userinfo['name'];
                $result[$k]['mobile'] = $userinfo['mobile'];
            }
            /** edit by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 start  **/
            $result[$k]['openID'] = $ids[$v['order_id']]['openid'];
            $result[$k]['saler_id'] = $ids[$v['order_id']]['saler_id'];
            $result[$k]['fans_saler_id'] = $ids[$v['order_id']]['fans_saler_id'];
            /** edit by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 end  **/
            $result[$k]['create_time'] = $ids[$v['order_id']]['create_time'];
            $result[$k]['payment_time'] = $ids[$v['order_id']]['payment_time'];
            $result[$k]['settlement'] = $ids[$v['order_id']]['settlement'];
            $result[$k]['consume_status'] = $consume_arr[$ids[$v['order_id']]['consume_status']];
            $result[$k]['refund_status'] = $ids[$v['order_id']]['refund_status'];

            if( empty($item_field) ){
                $result[$k][]= $items[$k];

            } else {
                foreach ($items[$k] as $sk=> $sv){
                    if( in_array($sk, $item_field) ){
                        $result[$k][$sk]= $sv ;
                        if($sk=='name' && isset($result[$k]['sku'])) {
                            // 调整 name 和 sku 的顺序
                            $sku = $result[$k]['sku'];
                            unset($result[$k]['sku']);
                            $result[$k]['sku'] = $sku;
                        }
                    }
                }
            }

            $result[$k]['row_qty'] = $v['qty'];
            if($v['can_split_use'] == Soma_base::STATUS_TRUE
                && $ids[$v['order_id']]['status'] != self::STATUS_WAITING
                && $v['use_cnt'] > 0
                && !empty($ids[$v['order_id']]['payment_time'])) {
                // 等待支付的订单不用除
                // 礼品卡券后台兑换不用除
                $result[$k]['row_qty'] = $v['qty'] / $v['use_cnt'];
            }
            $result[$k]['total'] = $result[$k]['row_qty'] * $v['price_package'];
            $result[$k]['balance_total'] = $ids[$v['order_id']]['balance_total'];
            $result[$k]['point_total'] = $ids[$v['order_id']]['point_total'];
            $result[$k]['conpon_total'] = $ids[$v['order_id']]['conpon_total'];
            $result[$k]['real_grand_total'] = $ids[$v['order_id']]['real_grand_total'];

            // 调整qty的位置
            $qty = $result[$k]['qty'];
            unset($result[$k]['qty']);
            $result[$k]['qty'] = $qty;

//            $result[$k]['status'] = $ids[$v['order_id']]['status'];

            $result[$k]['gift_total'] = $ids[$v['order_id']]['gift_total'];//已赠送
            $result[$k]['shipping_total'] = $ids[$v['order_id']]['shipping_total'];//已邮寄
            $result[$k]['consumer_total'] = $ids[$v['order_id']]['consumer_total'];//已自提
            /** edit by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 start  **/
//            $result[$k]['shipment_total'] = $ids[$v['order_id']]['shipping_total'] + $ids[$v['order_id']]['consumer_total'];//已出货总数
            $per_amount = $result[$k]['real_grand_total'] / $result[$k]['qty'];// 每份金额
            $result[$k]['not_verificated_num'] = $ids[$v['order_id']]['not_verificated_num'];// 未核销总数
            $result[$k]['not_verificated_amount'] = round($per_amount * $result[$k]['not_verificated_num'], 2);// 未核销总金额
            $result[$k]['overdue_num'] = $ids[$v['order_id']]['overdue_num'];// 已过期总数
            $result[$k]['overdue_amount'] = round($per_amount * $result[$k]['overdue_num'], 2);// 已过期总金额
            $result[$k]['expiration_date'] = $v['expiration_date'];// 过期时间
            $result[$k]['verificated_num'] = $ids[$v['order_id']]['verificated_num'];// 已核销总数
            $result[$k]['verificated_amount'] = round($per_amount * $result[$k]['verificated_num'], 2);// 已核销总金额
            /** edit by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 end  **/
            $result[$k]['shipping_ids'] = $ids[$v['order_id']]['shipping_ids'];//邮寄编号
            
            //状态标签转换
//             if( array_key_exists($result[$k]['status'], $status_arr) ){
//                 $result[$k]['status']= $status_arr[$result[$k]['status']];
//             }
            //结算方式转换
            if( array_key_exists($result[$k]['settlement'], $settle_arr) ){
                $result[$k]['settlement']= $settle_arr[$result[$k]['settlement']];
            }
            /*
                使用数量
                20160812 luguihong bug:为支付的订单导出订单消费状态为已消费
                                        问题所在没有分配资产
            */
            if( isset($asset_items[$v['order_id']]) ){
                $result[$k]['qty_leave']= $asset_items[$v['order_id']];
            } else {
                $result[$k]['qty_leave']= 0;
            }
            //消费情况转换
            //if( array_key_exists($result[$k]['consume_status'], $consume_arr) ){
            //    $result[$k]['consume_status']= $consume_arr[$result[$k]['consume_status']];
            //}
            if( $ids[$v['order_id']]['status'] == self::STATUS_WAITING || $ids[$v['order_id']]['status'] == self::STATUS_UN_VALID ){
                $result[$k]['consume_status']= '未支付';
            }else{
                // if( $result[$k]['qty_leave']==$v['qty'] ){
                //     $result[$k]['consume_status']= '未消费';
                // } else if( $result[$k]['qty_leave']==0 && $result[$k]['consume_status'] != self::CONSUME_PENDING ){
                //     //20160826 luguihong 如果赠送人了，别人没接，数量为0，又没有消费的情况
                //     $result[$k]['consume_status']= '已消费';
                // } else {
                //     $result[$k]['consume_status']= '消费中';
                // }
            }
// var_dump( $result );exit;
            $result[$k]['refund_status']= isset( $refund_arr[$result[$k]['refund_status']] ) ? $refund_arr[$result[$k]['refund_status']] : '' ;

            //不需要未使用数量了 luguihong 20160809
            unset( $result[$k]['qty_leave'] );
            // 替换掉“,”分隔符,防止导出布局错乱
            $_fmt_res = $result[$k];
            foreach($result[$k] as $key => $value) {
                $_fmt_res[$key] = str_replace(',', '，', $value);
            }
            $result[$k] = $_fmt_res;

            $result[$k]['hotel_id']= isset($hotel[$v['hotel_id']])? $hotel[$v['hotel_id']]: $v['hotel_id'];

            $result[$k]['member_card_id'] = $ids[$v['order_id']]['member_card_id'];
            $result[$k]['remark'] = $ids[$v['order_id']]['remark'];// edit by chencong <chencong@mofly.cn> 2017/07/31 增加导出字段

        }
        // print_r( $result );die;
         
        //数量合并
//         $lines = array();
//         $last_orderid = $last_gsid = $last_key ='';
//         foreach ($result as $k=>$v){
//             if( $last_orderid== $v['order_id'] && $last_gsid== $v['product_id'] ){
//                 $lines[$last_key]['qty']++;
                 
//             } else {
//                 $last_orderid= $v['order_id'];
//                 $last_gsid= $v['product_id'];
//                 $last_key= $k;
//                 $lines[$k]= $v+ array('qty'=>1);
//             }
//             //清除下面2个用来匹配数量合并的字段
//             // unset($lines[$k]['order_id']);
//             unset($lines[$k]['product_id']);
//         }

        // print_r( $lines );die;
        return $result;
    }

    //获取用户填写的电话和姓名
    public function get_userinfo($openid)
    {
        return $this->_shard_db_r('iwide_soma_r')->where_in( 'openid', $openid )
            ->select('contact_id,name,order_id,mobile')
            ->order_by('create_time DESC')
            ->get( 'soma_customer_contact' )
            ->row_array();
    }


    /**
     * @param $inter_id
     * @param $orderDetail (array)
     * @param $params (array)
     * @param $successUrl (string) 默认支付成功返回路径
     */
    public function success_payment_path($inter_id, $type, $order_detail, $successUrl, $param = array())
    {
        $param= array();
        $param['id']  = $inter_id;
        $param['bsn'] = $order_detail['business'];
        switch($type){
            case 'mail':
                $param['oid'] = $order_detail['order_id'];
                $successUrl = Soma_const_url::inst()->get_soma_shipping( $param );//邮寄
                break;
            case 'gift':
                $param['oid'] = $order_detail['order_id'];
                $this->load->model('soma/Gift_order_model');
                $model = $this->Gift_order_model;
                $param['send_from'] = $model::SEND_FROM_ORDER;
                $param['send_order_id'] = $order_detail['order_id'];
                $successUrl = Soma_const_url::inst()->get_url('soma/gift/package_pre_send', $param );//赠送
                break;
        }
        return $successUrl;
    }

    /**
     * 获取一组order_id的信息
     * 
     * @param  [type] $filter array:$start_time,$end_time,$limit,$offset
     * @return [type]         [description]
     */
    public function get_all_order_idx($filter = null) {
        return $this->_shard_db_r('iwide_soma_r')
            ->where("`create_time` between '".$filter['start_time']."' and '".$filter['end_time']."'")
            ->limit($filter['limit'], $filter['offset'])
            ->get($this->order_idx_table_name())
            ->result_array();
    }

    /**
     * 获取订单的优惠方式信息
     * 使用: $this->load($order_id)->get_order_discount()
     * 
     * @return [type] [description]
     */
    public function get_order_discount() {
        $this->load->model('soma/Sales_order_discount_model', 'd_model');
        return $this->d_model->get_disount_by_filter(array('order_id', $this->m_get('order_id')));
    }

    /**
     * 获取订单客户联系信息
     * 
     * @return [type] [description]
     */
    public function get_order_customer_contact() {
        return $this->_shard_db_r('iwide_soma_r')
            ->where('order_id', $this->m_get('order_id'))
            ->get('soma_customer_contact')
            ->result_array();
    }

    /**
     * 一条订单的详细信息
     * 关联表：
     * sales_order_idx  --->  订单数据索引
     * sales_order_item_package_xxxx  --->  订单数据产品表，需要分片
     * sales_order_discount  --->  订单折扣信息表
     * customer_constact  --->  订单数据客户表
     * @return array [description]
     */
    public function get_order_summary($filter) {

        // 查找索引信息
        $idx_imfo = $this->get_all_order_idx($filter);
        $idx_hash = $this->get_row_id_hash($idx_imfo, 'order_id');
        if(count($idx_imfo) == 0) {
            return array();
        }

        $id_arr = array();
        $openid_arr = array();
        foreach ($idx_imfo as $row) {
            $id_arr[] = $row['order_id'];
            if(!in_array($row['openid'], $openid_arr)) {
                $openid_arr[] = $row['openid'];
            }
        }

        // 查找items信息
        $shards= $this->_db()->get('soma_shard')->result_array();
        $items = array();
        foreach ($shards as $k => $v) {
            $temp = $this->_db($v['db_resource'])
                ->where_in('order_id',$id_arr)
                ->get('soma_sales_order_item_package'. $v['table_suffix'])
                ->result_array();
            $items = array_merge($items, $temp);
        }

        // 查找客户信息 openid
        $contacts = $this->_db()
            ->where_in('openid', $openid_arr)
            ->get('soma_customer_contact')
            ->result_array();
        $co_hash = $this->get_row_id_hash($contacts, 'openid');

        // 查找折扣信息
        $discount = $this->_db()
            ->where_in('order_id', $id_arr)
            ->get('soma_sales_order_discount')
            ->result_array();
        $do_hash = $this->get_row_id_hash($discount, 'order_id');

        // var_dump($idx_hash);exit;
        $summary = $this->_db($this->db_write)
            ->where_in('order_id', $id_arr)
            ->get('mall_order_summary')
            ->result_array();
        $so_hash = $this->get_row_id_hash($summary, 'order_id');

        $data['insert'] = array();
        $data['update'] = array();

        foreach ($items as $item) {
            
            $tmp = array();
            $order_id = $item['order_id'];
            $openid = $item['openid'];

            $tmp['order_id'] = $item['order_id'];
            $tmp['inter_id'] = $item['inter_id'];
            $tmp['product'] = $item['name'];
            $tmp['pay_typ'] = '微信支付';

            // 无数据
            // $tmp['sub_order_id'] = null;
            // $tmp['pms_order_id'] = null;
            // $tmp['member_card_no'] = null;
            // $tmp['membership_number'] = null;
            // $tmp['product_group'] = null;

            $tmp['openid'] = $tmp['customer'] = $tmp['cellphone'] = null;
            if (!empty($co_hash[$openid])) {
                $tmp['openid'] = $openid;
                $tmp['customer'] = $co_hash[$openid][0]['name'];
                $tmp['cellphone'] = $co_hash[$openid][0]['mobile'];
            }
            
            $tmp['order_time'] = $tmp['counts'] = $tmp['order_status'] = null;
            $tmp['price'] = $tmp['shopping_mode'] = $tmp['actually_paid'] = $tmp['hotel_id'] = null;
            if(!empty($idx_hash[$order_id])) {
                $tmp['order_time'] = $idx_hash[$order_id][0]['create_time'];
                $tmp['counts'] = $idx_hash[$order_id][0]['row_qty'];
                $tmp['order_status'] = $idx_hash[$order_id][0]['status'];
                $tmp['price'] = $idx_hash[$order_id][0]['grand_total']+$idx_hash[$order_id][0]['discount'];
                $tmp['shopping_mode'] = $idx_hash[$order_id][0]['settlement'];
                $tmp['actually_paid'] = $idx_hash[$order_id][0]['grand_total'];
                $tmp['hotel_id'] = $idx_hash[$order_id][0]['hotel_id'];
            }

            $tmp['ticket'] = $tmp['point'] = $tmp['balance'] = 0;
            if(!empty($do_hash[$item['order_id']])) {
                $this->load->model('soma/Sales_order_discount_model');
                $model = $this->Sales_order_discount_model;
                foreach ($do_hash[$order_id] as $row) {
                    switch ($row['type']) {
                        case $model::TYPE_COUPON:
                            $tmp['ticket'] = $row['amount'];
                            break;
                        case $model::TYPE_POINT:
                            $tmp['point'] = $row['amount'];
                            break;
                        case $model::TYPE_BALENCE:
                            $tmp['balance'] = $row['amount'];
                            break;
                        case $model::TYPE_REDUCE:
                        default:
                            # code...
                            break;
                    }
                }
            }

            if(isset($so_hash[$order_id])) {
                $data['update'][] = $tmp;
            } else {
                $data['insert'][] = $tmp;
            }
        }

        return $data;

    }

    protected function get_row_id_hash($data, $id) {
        $hash = array();
        foreach ($data as $row) {
            if(!isset($hash[$row[$id]])) {
                $hash[$row[$id]] = array();
            }
            $hash[$row[$id]][] = $row;
        }
        return $hash;
    }

    /**
     * 保存
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function save_order_summary($data) {
        if(count($data) == 0) { return true; }
        $iwide_rw = $this->_db($this->db_write);
        $iwide_rw->trans_begin();
        try {
            if(count($data['insert']) > 0) {
                $iwide_rw->insert_batch('mall_order_summary', $data['insert']);
            }
            if(count($data['update']) > 0) {
                $iwide_rw->update_batch('mall_order_summary', $data['update'], 'order_id');
            }
            $iwide_rw->trans_commit();
            return true;
        } catch (Exception $e) {
            $iwide_rw->trans_rollback();
            return false;
        }
    }

    # ====================================================================================================

    /**
     * 获取订单信息
     *
     * 额外信息：细单内的商品名，contact里面的联系人名
     *
     * 状态翻译
     * 
     * @param  [type] $filter   过滤条件
     * @param  [type] $inter_id 公众号
     * @return [type]           数组
     */
    public function get_grid_data($filter) {
        // $data = array();
        $orders = array();
        $items = array();

        $suffix = $this->_get_table_suffix();
        foreach ($suffix as $_suffix) {
            $_tmp_o = $this->_order_from_suffix($filter, $_suffix);
            $_tmp_i = $this->_item_from_suffix(array_keys($_tmp_o), $_suffix);
            $orders += $_tmp_o;
            $items += $_tmp_i;
        }

        $r_status = $this->get_refund_label();
        $c_status = $this->get_consume_label();
        $g_status = $this->get_gift_label();
        $o_status = $this->get_status_label();
        $s_labels = $this->get_settle_label();
        // 附加数据：联系人名
        $contacts = $this->_get_contact_data();

        $inter_hash = $this->_get_total_inter_ids();

        $_fmt_data = array();
        foreach ($orders as $order_id => $row) {
            $_tmp_row = $row;
            $_tmp_row['refund_status'] = @$r_status[ $row['refund_status'] ];
            $_tmp_row['consume_status'] = @$c_status[ $row['consume_status'] ];
            $_tmp_row['gift_status'] = @$g_status[ $row['gift_status'] ];
            $_tmp_row['status'] = @$o_status[ $row['status'] ];
            $_tmp_row['settlement'] = @$s_labels[ $row['settlement'] ];

            $_tmp_row['item_name'] = '';
            if(isset($items[$order_id]) 
                && is_array($items[$order_id])
                && count($items[$order_id]) > 0) {
                $_tmp_row['item_name'] = $items[$order_id][0]['name'];
                if(count($items[$order_id]) > 1) {
                    $_tmp_row['item_name'] .= '等' . count($items[$order_id]) . '个商品';
                }
            }
            $_tmp_row['contact'] = '';
            if(isset($contacts[ $row['openid'] ])) {
                $_tmp_row['contact'] = $contacts[ $row['openid'] ]['name'];
            }
            $_tmp_row['inter_name'] = '';
            if(isset($inter_hash[ $row['inter_id'] ])) {
                $_tmp_row['inter_name'] = $inter_hash[ $row['inter_id'] ];
            }
            $hotel_hash = $this->_get_inter_hotels($row['inter_id']);
            if(isset($hotel_hash[ $row['hotel_id'] ])) {
                $_tmp_row['hotel_id'] = $hotel_hash[ $row['hotel_id'] ];
            }

            $_fmt_data[] = $_tmp_row;
        }

        return $_fmt_data;
    }

    /**
     * 获取数据库分片信息
     * @return [type] [description]
     */
    protected function _get_table_suffix() {
        $shards= $this->_shard_db_r('iwide_soma_r')->get('soma_shard')->result_array();
        $data = array();
        foreach ($shards as $row) { $data[] = $row['table_suffix']; }
        return $data;
    }

    /**
     * 从分片中获取总单数据
     * 
     * @param  [type] $filter 过滤条件
     * @param  [type] $suffix 数据分片
     * @return [type]         数组
     */
    protected function _order_from_suffix($filter, $suffix) {
        $table = 'soma_sales_order'. $suffix;
        $db = $this->_shard_db_r('iwide_soma_r');
        foreach ($filter['where'] as $k => $v) {
            if(is_array($v)) {
                if(count($v) <= 0) { return array(); }
                $db->where_in($k, $v);
            } else {
                $db->where($k, $v);
            }
        }
        if(isset($filter['order_by']) && is_array($filter['order_by'])) {
            foreach ($filter['order_by'] as $orderby => $direction) {
                $db->order_by($orderby, $direction);
            }
        }
        $data = $db->get($table)->result_array();
        $orders = array();
        foreach ($data as $row) {
            $orders[$row['order_id']] = $row;
        }

        return $orders;
    }

    /**
     * 从分片中获取细单数据
     * 
     * @param  [type] $orders 总单信息
     * @param  [type] $suffix 分片信息
     * @param  [type] $bsn    业务类型（用于指定细单表）
     * @return [type]         [description]
     */
    protected function _item_from_suffix($order_ids, $suffix, $bsn = 'package') {

        if(count($order_ids) <= 0) { return array(); }

        $table = 'soma_sales_order_item_'. $bsn . $suffix;
        $data = $this->_shard_db_r('iwide_soma_r')
            ->where_in('order_id', $order_ids)
            ->get($table)
            ->result_array();
        $_fmt_data = array();
        foreach ($data as $row) {
            if(!isset($_fmt_data[ $row['order_id'] ])) {
                $_fmt_data[ $row['order_id'] ] = array();
            }
            $_fmt_data[ $row['order_id'] ][] = $row;
        }
        return $_fmt_data;
    }

    /**
     * 获取所有联系人信息
     * 
     * @return [type] [description]
     */
    protected function _get_contact_data() {
        $table = 'soma_customer_contact';
        $data = $this->_shard_db_r('iwide_soma_r')->get($table)->result_array();
        $_fmt_data = array();
        foreach ($data as $row) {
            $_fmt_data[ $row['openid'] ] = $row;
        }
        return $_fmt_data;
    }

    protected function _get_total_inter_ids() {
        $this->load->model('wx/publics_model');
        $publics_array= $this->publics_model->get_public_hash();
        $publics_hash= $this->publics_model->array_to_hash($publics_array, 'name', 'inter_id');
        return $publics_hash;
    }

    protected $_inter_hotels = array();

    /**
     * 性能瓶颈，出现问题时，优化从缓存中获取酒店信息
     * @param  [type] $inter_id [description]
     * @return [type]           [description]
     */
    protected function _get_inter_hotels($inter_id) {
        if(isset($this->_inter_hotels[$inter_id])) {
            return $this->_inter_hotels[$inter_id];
        }
        $hotels = $this->_get_total_hotel_ids($inter_id);
        $this->_inter_hotels[$inter_id] = $hotels;
        return $hotels;
    }

    protected function _get_total_hotel_ids($inter_id) {
        $this->load->model('hotel/Hotel_model');
        $hotels_array = $this->Hotel_model->get_all_hotels($inter_id);
        $hotels_hash = $this->Hotel_model->array_to_hash($hotels_array, 'name', 'hotel_id');
        return $hotels_hash;
    }
    
    public function get_grid_header() {
        return array(
            'order_id' => '订单编号',
            'inter_id' => '公众号ID',
            'inter_name' => '公众号名称',
            'hotel_id' => '酒店名称',
            'settlement' => '结算方式',
            'create_time' => '下单时间',
            'payment_time' => '支付时间',
            'row_total' => '小计总额',
            'subtotal' => '实际总额',
            'grand_total' => '实付总额',
            'refund_status'=> '退款状态',
            'consume_status'=> '消费状态',
            'gift_status'=> '赠送状态',
            'item_name'=> '购买商品名称',
            'contact'=> '购买人',
            'status'=> '状态',
        );
    }

    public function format_grid_data($data, $header) {
        
        $keys = array_keys($header);
        $_fmt_data = array();
        foreach ($data as $row) {
            $_tmp_row = array();
            foreach ($keys as $key) {
                $_tmp_row[] = isset($row[$key]) ? $row[$key] : '';
            }
            $_fmt_data[] = $_tmp_row;
        }
        return $_fmt_data;
    }

    public function format_grid_header($header) {
        $_fmt_header = array();
        foreach ($header as $key => $value) {
            $_fmt_header[] = array('title' => $value);
        }
        return $_fmt_header;
    }


    /**
     * 获取订单聚合列表，包括细单信息
     * 
     * 注：公众号，酒店号做了中文转义，分别对应inter_name,hotel_name
     *
     * @param      array  $filter  过滤条件
     *
     * @return     array  定单聚合信息
     */
    public function get_order_collection($filter) {

        $orders = $items = array();
        $suffixs = $this->_get_table_suffix();
        foreach ($suffixs as $_suffix) {
            $_tmp_o = $this->_order_from_suffix($filter, $_suffix);
            $_tmp_i = $this->_item_from_suffix(array_keys($_tmp_o), $_suffix);
            $orders += $_tmp_o;
            $items += $_tmp_i;
        }

        $inter_hash = $this->_get_total_inter_ids();

        $collection = array();
        foreach ($orders as $oid => $order) {

            $_tmp_row = $order;
            $_tmp_row['items'] = array();
            if(isset($items[$oid])) { $_tmp_row['items'] = $items[$oid]; }

            if(isset($inter_hash[ $order['inter_id'] ])) {
                $_tmp_row['inter_name'] = $inter_hash[ $order['inter_id'] ];
            }
            $hotel_hash = $this->_get_inter_hotels($order['inter_id']);
            if(isset($hotel_hash[ $order['hotel_id'] ])) {
                $_tmp_row['hotel_name'] = $hotel_hash[ $order['hotel_id'] ];
            }

            $collection[] = $_tmp_row;
        }

        return $collection;
    }

    # ====================================================================================================


    /**
     * { function_description }
     *
     * @param      <type>  $s_time  The s time
     * @param      <type>  $days    The days
     */
    public function rebuild_balance_data($s_time, $days) {

        $ob_tb = 'soma_sales_order';
        $oi_tb = 'soma_sales_order_idx';
        $d_tb = 'soma_sales_order_discount';
        $this->load->model('soma/Sales_order_discount_model');

        $ce_time = date('Y-m-d H:i:s', strtotime($s_time));
        $cs_time = date('Y-m-d H:i:s', strtotime("- $days day", strtotime($ce_time)));

        $d_set = $this->_shard_db_r('iwide_soma_r')
            ->where('create_time >=', $cs_time)->where('create_time <', $ce_time)
            ->where('type', Sales_order_discount_model::TYPE_BALENCE)->get($d_tb)->result_array();

        $ids = array();
        $discount = array();
        foreach ($d_set as $row) {
            $ids[] = $row['order_id'];
            $discount[ $row['order_id'] ] = $row;
        }

        $o_set = $this->_shard_db_r('iwide_soma_r')
            ->where_in('order_id', $ids)->where('status', self::STATUS_PAYMENT)
            ->get($oi_tb)->result_array();

        $data = array();
        foreach ($o_set as $row) {
            $_tmp['order_id'] = $row['order_id'];
            $_tmp['balance_total'] = $discount[ $row['order_id'] ]['amount'];
            $_tmp['real_grand_total'] = $_tmp['balance_total'] + $row['grand_total'];
            $data[] = $_tmp;
        }

        if(count($data) <= 0) { return true; }

        $this->_shard_db()->trans_begin();
        try {
            $suffixs = $this->_get_table_suffix();
            foreach($suffixs as $_suffix) {
                $table = $ob_tb . $_suffix;
                $this->_shard_db()->set('balance_total', 0)
                    ->set('real_grand_total', 'grand_total', false)->update($table);
                $this->_shard_db()->update_batch($table, $data, 'order_id');
            }
            $this->_shard_db()->trans_commit();
            return $data;
        } catch (Exception $e) {
            $this->_shard_db()->trans_rollback();
        }
        return false;
    }

    public function consumer_shipping() {
        
        $this->load->model('soma/consumer_order_model', 'c_model');
        $this->load->model('soma/sales_shipping_order_model', 'ss_model');

        $info = $this->ss_model->find(array('pay_order_id' => $this->m_get('order_id')));

        if(is_array($info) && count($info) > 0) {
            $this->c_model->shipping_order = $this->m_get('order_id');
            $this->c_model->shipping_fee = $this->m_get('grand_total');
            $data = json_decode($info['shipping_data'], true);

            $inter_id = $this->m_get('inter_id');
            $openid   = $this->m_get('openid');
            $bsn      = $this->m_get('business');

            $res = $this->c_model->mail_consumer($data, $openid, $inter_id, $bsn);
            if(isset($res['status']) 
                && $res['status'] == Soma_base::STATUS_TRUE){
                return true;
            } else {
                return false;
            }
        }

        return true;
    }

    //根据公众号获取订单列表
    public function get_un_pay_orders( $inter_id, $limit=100, $start=NULL, $end=NULL, $select='*', $status=self::STATUS_WAITING )
    {
        if( !$inter_id ){
            return array();
        }

        $db = $this->_shard_db_r('iwide_soma_r');
        if($start) {
            if( strlen($start)<=10 ) $start.= ' 00:00:00';
            $db->where('create_time >=', $start);
        }
        if($end) {
            if( strlen($end)<=10 ) $end.= ' 23:59:59';
            $db->where('create_time <', $end);
        }

        $table = $this->table_name($inter_id);
        return $db
                ->where('inter_id',$inter_id)
                ->where('status',$status)
                ->select($select)
                ->limit($limit)
                ->get($table)
                ->result_array();

    }

    /**
     * 新后台重写此方法,提供新后台的数据，注意保持ori_data中的原数据格式，避免其他地方调用异常
     *
     * @param      array   $params  The parameters
     * @param      array   $select  The select
     * @param      string  $format  The format
     */
    public function filter( $params=array(), $select= array(), $format='array' ) {
        $ori_data = parent::filter($params, $select, $format);
        return $this->get_new_backend_order_data($ori_data);
    }

    public function get_new_backend_order_data($ori_data) {
        $filter = $orders = $items = $ids = $hash_orders= array();
        foreach($ori_data['data'] as $row) {
            $ids[] = $row['DT_RowId'];
        }

        $filter['where'] = array('order_id' => $ids);
        $orders = $this->get_order_collection($filter);
        $contacts = $this->_get_contact_data();

        foreach($orders as $row) {
            $hash_orders[$row['order_id']] = $row;
            $hash_orders[$row['order_id']]['contacts_info'] = array();
            if(isset($contacts[$row['openid']])) {
                $hash_orders[$row['order_id']]['contacts_info'] = $contacts[$row['openid']];
            }
        }

        $new_res = $ori_data;
        foreach($ori_data['data'] as $key => $row) {
            $new_res['data'][$key]['new_info'] = array();
            if(isset($hash_orders[ $row['DT_RowId'] ])) {
                $new_res['data'][$key]['new_info'] = $hash_orders[ $row['DT_RowId'] ];
            }
        }

        return $new_res;
    }


    /**
     * { function_description }
     */
    public function rebuild_order_total_data($s_time, $e_time) {

        $orders = $items = array();
        $filter['where']['create_time >='] = $s_time;
        $filter['where']['create_time <'] = $e_time;
        // $filter['where']['status'] = self::STATUS_PAYMENT;

        $suffix = $this->_get_table_suffix();
        foreach ($suffix as $_suffix) {
            $_tmp_o = $this->_order_from_suffix($filter, $_suffix);
            $_tmp_i = $this->_item_from_suffix(array_keys($_tmp_o), $_suffix);
            $orders += $_tmp_o;
            $items += $_tmp_i;
        }
        // var_dump($orders, $items);exit;
        // 获取各产品类型
        $order_product_type = array();
        foreach($items as $order_id => $order_item) {
            if(!empty($order_item)) {
                $order_product_type[$order_id] = $order_item[0]['type'];
            }
        }

        $data = array();
        foreach ($orders as $order_id => $order) {
            $data[$order_id]['wx_total'] = 0;
            $data[$order_id]['balance_total'] = 0;
            $data[$order_id]['point_total'] = 0;
            $data[$order_id]['conpon_total'] = 0;

            if($order_product_type[$order_id] == self::PRODUCT_TYPE_BALANCE) {
                $data[$order_id]['balance_total'] += $order['grand_total'];
            } else if ($order_product_type[$order_id] == self::PRODUCT_TYPE_POINT) {
                $data[$order_id]['point_total'] += $order['grand_total'];
            } else {
                $data[$order_id]['wx_total'] += $order['grand_total'];
            }
        }

        $this->load->model('soma/Sales_order_discount_model');

        $d_tb = 'soma_sales_order_discount';
        $discounts = $this->_shard_db_r('iwide_soma_r')
            ->where_in('order_id', array_keys($orders))->get($d_tb)->result_array();

        foreach ($discounts as $row) {
            if($row['type'] == Sales_order_discount_model::TYPE_COUPON) {
                $data[$row['order_id']]['conpon_total'] += $row['amount'];
            }
            if($row['type'] == Sales_order_discount_model::TYPE_POINT) {
                $data[$row['order_id']]['point_total'] += $row['amount'];
            }
            if($row['type'] == Sales_order_discount_model::TYPE_BALENCE) {
                $data[$row['order_id']]['balance_total'] += $row['amount'];
            }
        }

        $fmt_data = array();
        foreach ($data as $order_id => $row) {
            $tmp_row = $row;
            $tmp_row['order_id'] = $order_id;
            // 实付需要叠加微信付款金额与储值付款金额
            $tmp_row['real_grand_total'] = $row['wx_total'] + $row['balance_total'];
            $fmt_data[] = $tmp_row;
        }
        // var_dump($fmt_data);exit;
        
        if(count($fmt_data) <= 0) { return true; }
        $o_tb = 'soma_sales_order';
        $this->_shard_db()->trans_begin();
        try {
            $suffixs = $this->_get_table_suffix();
            foreach($suffixs as $_suffix) {
                $table = $o_tb . $_suffix;
                $this->_shard_db()->update_batch($table, $fmt_data, 'order_id');
            }
            $this->_shard_db()->trans_commit();
            return $fmt_data;
        } catch (Exception $e) {
            $this->_shard_db()->trans_rollback();
        }
        return false;

    }

    # 新后台获取表单数据
    
    /**
     * Gets the new backend list data.
     *
     * @param      <type>  $filter  The filter
     */
    public function getNewBackendListData($filter)
    {
        $inter_hash    = $this->_get_total_inter_ids();
        $hotel_hash    = $this->_get_inter_hotels($filter['inter_id']);
        $settle_lable  = $this->get_settle_label();
        $consume_lable = $this->get_consume_label();
        $status_label  = $this->get_status_label();
        $refund_label  = $this->get_refund_label();
        $result        = $this->_fetchNewBackendData($filter);

        $data = array();
        foreach($result['data'] as $order_id => $order)
        {
            foreach($order as $item)
            {
                if(!isset($data[$order_id]))
                {
                    $data[$order_id]['order_id']         = $item['order_id'];
                    $data[$order_id]['contact']          = empty($item['contact']) ? $item['cname'] : $item['contact'];
                    $data[$order_id]['mobile']           = empty($item['mobile']) ? $item['cmobile'] : $item['mobile'];
                    $data[$order_id]['create_time']      = $item['create_time'];
                    $data[$order_id]['payment_time']     = $item['payment_time'];
                    $data[$order_id]['settlement']       = $settle_lable[$item['settlement']];
                    $data[$order_id]['consume_status']   = $consume_lable[$item['consume_status']];
                    $data[$order_id]['refund_status']    = $refund_label[$item['refund_status']];
                    $data[$order_id]['balance_total']    = $item['balance_total'];
                    $data[$order_id]['point_total']      = $item['point_total'];
                    $data[$order_id]['real_grand_total'] = $item['real_grand_total'];
                    $data[$order_id]['inter_id']         = $item['inter_id'];
                    $data[$order_id]['inter_name']       = empty($inter_hash[$item['inter_id']]) ? '' : $inter_hash[$item['inter_id']];
                    $data[$order_id]['hotel_id']         = $item['hotel_id'];
                    $data[$order_id]['hotel_name']       = empty($hotel_hash[$item['hotel_id']]) ? '' : $hotel_hash[$item['hotel_id']];
                    $data[$order_id]['status']           = $status_label[$item['status']];
                    $data[$order_id]['discount']         = $item['discount'];
                }
                
                $_tmp_i['name']          = $item['iname'];
                $_tmp_i['sku']           = $item['isku'];
                $_tmp_i['price_package'] = $item['iprice_package'];
                $_tmp_i['pay_qty']       = $item['iqty'];
                $_tmp_i['get_qty']       = $item['iqty'];
                $_tmp_i['face_img']      = $item['iface_img'];
                if($item['ican_split_use'] == Soma_base::STATUS_TRUE
                    && $item['iuse_cnt'] > 1)
                {
                    $_tmp_i['pay_qty'] = $item['iqty'] / $item['iuse_cnt'];
                }
                $_tmp_i['total'] = $_tmp_i['pay_qty'] * $_tmp_i['price_package'];   

                $data[$order_id]['items'][] = $_tmp_i;
            }
        }
        return array('data' => $data, 'total' => $result['total']);
    }

    /**
     * 从数据库获取订单列表数据
     *
     * @param      array  $filter  The filter
     *
     * @return     array  The new backend grid data.
     */
    public function _fetchNewBackendData($filter)
    {
        if(!isset($filter['inter_id']))
        {
            return array();
        }

        $otb_name = $this->_shard_table('soma_sales_order', $filter['inter_id']);
        $itb_name = $this->_shard_table('soma_sales_order_item_package', $filter['inter_id']);
        $ctb_name = $this->_shard_table('soma_customer_contact', $filter['inter_id']);

        $otb_full_name = $this->db_conn_read->dbprefix($otb_name);
        $itb_full_name = $this->db_conn_read->dbprefix($itb_name);
        $ctb_full_name = $this->db_conn_read->dbprefix($ctb_name);

        /*
        $this->db_conn_read->select('o.order_id,o.inter_id,o.hotel_id,o.real_grand_total,i.qty,o.discount,o.contact,o.mobile,o.settlement,o.status,o.consume_status,o.payment_time,i.name as iname,i.face_img as iface_img,i.can_split_use as ican_split_use,i.use_cnt as iuse_cnt,c.name as cname,c.mobile as cmobile');
        $this->db_conn_read->from($otb_full_name . ' as o');
        $this->db_conn_read->join($itb_full_name . ' as i', 'o.order_id = i.order_id', 'left');
        $this->db_conn_read->join($ctb_full_name . ' as c', 'o.openid = c.openid', 'left');
        */
        // 底层版本没有查询条件组的方法，拼接sql字符串
        $sql = "select o.*,i.qty as iqty,i.name as iname,i.face_img as iface_img,i.can_split_use as ican_split_use,i.use_cnt as iuse_cnt,i.sku as isku, i.price_package as iprice_package, c.name as cname,c.mobile as cmobile from {$otb_full_name} as o left join {$itb_full_name} as i on o.order_id = i.order_id left join {$ctb_full_name} as c on o.openid = c.openid where o.inter_id = '{$filter['inter_id']}'";

        if(!empty($filter['hotel_id']))
        {
            if(!is_array($filter['hotel_id']))
            {
                $sql .= " and o.hotel_id = {$filter['hotel_id']}";
            }
            else
            {
                $hotel_str = implode(',', $filter['hotel_id']);
                $sql .= " and o.hotel_id in ({$hotel_str})";
            }
        }
        if(!empty($filter['order_id']))
        {
            $sql .= " and o.order_id like '%{$filter['order_id']}%'";
        }
        if(!empty($filter['pname']))
        {
            $sql .= " and i.name like '%{$filter['pname']}%'";
        }
        if(!empty($filter['contact']))
        {
            // $sql .= " and (o.contact like '%{$filter['contact']}%' or (o.contact not like '%{$filter['contact']}%' and c.name like '%{$filter['contact']}%'))";
            // 防止误查数据，仅当订单联系人没有设置时才匹配联系人表
            $sql .= " and (o.contact like '%{$filter['contact']}%' or ((o.contact is null or o.contact = '') and c.name like '%{$filter['contact']}%'))";
        }
        if(!empty($filter['mobile']))
        {
            $sql .= " and (o.mobile like '%{$filter['mobile']}%' or ((o.mobile is null or o.mobile = '') and c.mobile like '%{$filter['mobile']}%'))";
        }
        if(!empty($filter['real_grand_total']))
        {
            $sql .= " and o.real_grand_total = {$filter['real_grand_total']}";
        }
        if(!empty($filter['settlement']))
        {
            $sql .= " and o.settlement = '{$filter['settlement']}'";
        }
        if(!empty($filter['status']))
        {
            $sql .= " and o.status = {$filter['status']}";
        }
        if(!empty($filter['consume_status']))
        {
            $sql .= " and o.consume_status = {$filter['consume_status']}";
        }
        if(!empty($filter['refund_status']))
        {
            $sql .= " and o.refund_status = {$filter['refund_status']}";
        }
        if(!empty($filter['create_start_time']))
        {
            $s_time = date('Y-m-d', strtotime($filter['create_start_time'])) . ' 00:00:00';
            $sql .= " and o.create_time > '{$s_time}'";
        }
        if(!empty($filter['create_end_time']))
        {
            $e_time = date('Y-m-d', strtotime($filter['create_end_time'])) . ' 23:59:59';
            $sql .= " and o.create_time < '{$e_time}'";
        }

        $count = $this->db_conn_read->query($sql)->num_rows();

        $sql .= ' order by o.order_id desc';
        if(!empty($filter['page_num']) && !empty($filter['page_size']))
        {
            $offset = ($filter['page_num'] - 1) * $filter['page_size'];
            $sql .= " limit {$offset}, {$filter['page_size']}";
        }

        $result = $this->db_conn_read->query($sql)->result_array();
        // echo $this->db_conn_read->last_query();die;
        
        $data = array();
        foreach($result as $row)
        {
            $data[$row['order_id']][] = $row;
        }

        return array('data' => $data, 'total' => $count);
    }

    public function export_header()
    {
        return array(
            '订单号',
            '购买人',
            '购买电话',
            /** edit by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 start  **/
            'openID',
            '转发分享分销ID',
            '粉丝分销ID',
            /** edit by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 end  **/
            '下单时间',
            '支付时间',
            '购买方式', 
            '消费状态',
            '退款状态', 
            '酒店名称',
            '商品名称',
            'SKU',
            '单价',
            '购买件数',
            '订单总额',
            '储值支付金额',
            '积分使用',
            '优惠券抵用金额',
            '实付金额（含储值）', // edit by chencong <chencong@mofly.cn> 2017/07/28 修改导出字段名称
            '获得数量',
            // '未使用数量', 
            '已赠送', //全部已赠送              思路：使用单号去赠送表查询。一个数量不论被赠送多少次，数量都是1
            '已邮寄', //全部已经邮寄             思路：使用单号去邮寄表查找数量
            '已自提',//全部已经自提          思路：使用单号去消费细单查找
            /** edit by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 start  **/
            // '已出货总数',//已邮寄＋已自提
            '未核销',
            '未核销总金额',
            '已过期',
            '已过期总金额',
            '过期时间',
            '已核销总数（含赠送已核销）',
            '核销总金额',
            /** edit by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段 end  **/
            '邮寄编号',//全部已经邮寄了的编号     思路：使用单号去邮寄表查找对应邮寄ID
            '会员号',
            '备注',// add by chencong <chencong@mofly.cn> 2017/07/28 增加导出字段
        );
    }


    /**
     *
     * 测试
     * @param $order_id
     * @param $inter_id
     * @return array
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function test_tran($order_id, $inter_id)
    {
        $result = array();

        $this->_shard_db($inter_id)->trans_begin ();

        $params = array(
            $this->table_primary_key() => $order_id
        );
        $table_name = $this->table_name($inter_id);

        $rows = $this->_shard_db($inter_id)->from($table_name)->where($params)->limit(1)->get()->result_array();
        $row = $rows[0];

        $result['before_update'] = $row['contact'];


        $this->_shard_db($inter_id)->set('contact', 'test123')->where($params)->update($table_name);

        $rows = $this->_shard_db($inter_id)->from($table_name)->where($params)->limit(1)->get()->result_array();
        $row = $rows[0];
        $result['after_update'] = $row['contact'];



        if ($this->_shard_db($inter_id)->trans_status() === false) {
            $this->_shard_db($inter_id)->trans_rollback();

            $result['trans_status'] = false;
        } else {
            $this->_shard_db($inter_id)->trans_commit();
            $result['trans_status'] = true;
        }

        return $result;
    }

    /**
     * Gets the combine order items.
     *
     * @param      string  $inter_id  The inter identifier
     *
     * @return     array   The combine order items.
     *
     * @author     fengzhongcheng <fengzhongcheng@molfy.cn>
     */
    public function getCombineOrderItems($inter_id)
    {
        $primary_key = $this->table_primary_key();
        if( !$oid = $this->m_get($primary_key) )
        {
            Soma_base::inst()->show_exception('Please Load Model first.');
        }

        $db_res = $this->_shard_db_r($inter_id)->select('order_id')
            ->where(array('master_oid' => $oid))->get($this->table_name($inter_id))->result_array();

        $combine_oids = array();
        foreach($db_res as $row)
        {
            $combine_oids[] = $row['order_id'];
        }

        if(empty($combine_oids))
        {
            return array();
        }

        return $this->_shard_db_r($inter_id)->select('*')
            ->where_in('order_id', $combine_oids)->get($this->item_table_name('package', $inter_id))->result_array();
    }

    /**
     * Gets the combine order assets.
     *
     * @param      string  $inter_id  The inter identifier
     *
     * @return     array   The combine order assets.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getCombineOrderAssets($inter_id)
    {
        $primary_key = $this->table_primary_key();
        if( !$oid = $this->m_get($primary_key) )
        {
            Soma_base::inst()->show_exception('Please Load Model first.');
        }

        $db_res = $this->_shard_db_r($inter_id)->select('order_id')
            ->where(array('master_oid' => $oid))->get($this->table_name($inter_id))->result_array();

        $combine_oids = array();
        foreach($db_res as $row)
        {
            $combine_oids[] = $row['order_id'];
        }

        if(empty($combine_oids))
        {
            return array();
        }

        return $this->_shard_db_r($inter_id)->select('*')
            ->where_in('order_id', $combine_oids)->where('openid', $this->m_get('openid'))
            ->get($this->asset_item_table_name('package', $inter_id))->result_array();
    }

    /**
     * 订房套餐批量下单接口
     *
     * @param      string  $inter_id      The inter identifier
     * @param      string  $openid        The openid
     * @param      array   $product_info  The product information
     * @param      string  $uu_code       The uu code
     *
     * @return     array   ( description_of_the_return_value )
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function batchHotelPackageOrder($inter_id, $openid, $product_info, $uu_code)
    {
        try {
            if(empty($inter_id) || empty($openid) 
                || !is_array($product_info) || empty($uu_code))
            {
                return array("res" => false, "msg" => "参数错误！");
            }   

            $this->soma_db_conn->trans_start(); 

            $this->load->model('soma/shard_config_model', 'model_shard_config');
            $CI = &get_instance();
            $CI->db_shard_config = $this->model_shard_config->build_shard_config($inter_id);
            $CI->current_inter_id = $inter_id;

            // 日志
            $log = array(
                'inter_id'     => $inter_id,
                'type'         => self::HOTEL_PACKAGE_API_REQUEST_TYPE_ORDER,
                'uu_code'      => $uu_code,
                'request_info' => json_encode(array('openid' => $openid, 'product_info' => $product_info)),
                'create_time'  => date('Y-m-d H:i:s'),
            );
            $this->logHotelPackageOrderRequst(json_encode($log));
            $this->soma_db_conn->insert('soma_sales_hotel_order_api_log', $log);
            if($this->soma_db_conn->insert_id() === 0)
            {
                return array("res" => false, 'msg' => "接口异常，请求无法受理，请检查传递参数是否正确！");
            }
            
            $order_res = array();
            foreach($product_info as $pid => $info)
            {
                if(empty($info['qty']) || $info['qty'] <= 0 
                    || empty($info['price'] || $info['price'] < 0))
                {
                    return array("res" => false, "msg" => "ID为[$pid]的产品下单数量和价格不能为空并且必须大于0！");
                }   

                $this->load->model('soma/Product_package_model', 'somaProductPackageModel');
                $product = $this->somaProductPackageModel->get('product_id', $pid);
                if(!empty($product) 
                    && $product[0]['can_wx_booking'] == Product_package_model::CAN_PASS_TO_HOTEL_MODEL)
                {
                    $product                  = $product[0];
                    $product['qty']           = $info['qty'];
                    // $product['price_package'] = $info['price'];
                    $product['price_package'] = 0;
                    $product['can_refund']    = self::CAN_REFUND_STATUS_FAIL;
                    $product['setting_date']  = Soma_base::STATUS_FALSE;
                    $this->somaProductPackageModel->appendEnInfo($product); 

                    $order = $this->generateHotelPackageOrder($product, $openid);
                    // 订房套餐下单时先不进行支付，等待后续通知处理
                    // if($order && $this->virtualPayHotelPackageOrder($order))
                    if($order)
                    {
                        $order_res[ $pid ] = $order->m_get('order_id');
                    }
                    else
                    {
                        return array("res" => false, "msg" => "ID为[$pid]的产品下单失败，请联系商城技术排查！");
                    }
                }
                else
                {
                    return array("res" => false, "msg" => "ID为[$pid]的产品不存在！");
                }
            }   

            $this->soma_db_conn->trans_complete();  

            return array("res" => true, 'data' => $order_res);
        } catch (\Exception $e) {
            return array("res" => false, 'msg' => '接口异常，请联系商城技术排查！');
        }
    }

    /**
     * 订房套餐订单支付接口
     *
     * @param      string  $inter_id   公众号ID
     * @param      array   $order_ids  订单单号数组
     * @param      stirng  $uu_code    唯一ID，避免重复支付
     *
     * @return     array   接口调用结果
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function batchHotelPackageOrderPay($inter_id, $order_ids, $uu_code)
    {
        try {
            if(!is_array($order_ids) || empty($uu_code))
            {
                return array("res" => false, "msg" => "参数错误！");
            } 

            $this->soma_db_conn->trans_start(); 

            $this->load->model('soma/shard_config_model', 'model_shard_config');
            $CI = &get_instance();
            $CI->db_shard_config = $this->model_shard_config->build_shard_config($inter_id);
            $CI->current_inter_id = $inter_id;

            // 日志
            $log = array(
                'inter_id'     => $inter_id,
                'type'         => self::HOTEL_PACKAGE_API_REQUEST_TYPE_PAY,
                'uu_code'      => $uu_code,
                'request_info' => json_encode(array('order_ids' => $order_ids)),
                'create_time'  => date('Y-m-d H:i:s'),
            );
            $this->logHotelPackageOrderRequst(json_encode($log));
            $this->soma_db_conn->insert('soma_sales_hotel_order_api_log', $log);
            if($this->soma_db_conn->insert_id() === 0)
            {
                return array("res" => false, 'msg' => "接口异常，请求无法受理，请检查传递参数是否正确！");
            }

            $pay_res = array();
            foreach($order_ids as $order_id)
            {
                $model = new self();
                $order = $model->load($order_id);
                if($order && $this->virtualPayHotelPackageOrder($order))
                {
                    $pay_res[$order_id] = 'success';
                }
                else
                {
                    return array("res" => false, "msg" => "订单[$order_id]支付失败，请联系商城技术排查！");
                }
            }

            $this->soma_db_conn->trans_complete();  

            return array("res" => true, 'data' => $pay_res);

        } catch (\Exception $e) {
            return array("res" => false, 'msg' => '接口异常，请联系商城技术排查！');
        }
    }

    protected function logHotelPackageOrderRequst($content)
    {
        $path= APPPATH. 'logs'. DS. 'soma'. DS . 'hotel_order' . DS;
        if( !file_exists($path) ) {
            @mkdir($path, 0777, TRUE);
        }
        $file= $path . date('Y-m-d_H'). '.txt';
        $this->write_log($content, $file);
    }

    protected function generateHotelPackageOrder($product, $openid)
    {
        try {
            $order                   = new self();
            $order->business         = 'package';
            $order->settlement       = self::SETTLE_HOTEL_PACKAGE;
            $order->inter_id         = $product['inter_id'];
            $order->openid           = $openid;
            $order->discount         = array();
            $order->product          = array($product);
            $order->saler_id         = '0';
            $order->killsec_instance = 0;
            
            $customer                = new Sales_order_attr_customer($openid);
            $order->customer         = $customer;

            $order->_order_save('package', $product['inter_id']);
            return $order;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function virtualPayHotelPackageOrder($order)
    {
        $data = $order->m_data();
        try {
            $this->load->model('soma/sales_payment_model');
            $payment_model = $this->sales_payment_model;

            $log_data                   = array();
            $log_data['paid_ip']        = $this->input->ip_address();
            $log_data['paid_type']      = $payment_model::PAY_TYPE_DF;
            $log_data['order_id']       = $data['order_id'];
            $log_data['openid']         = $data['openid'];
            $log_data['business']       = $data['business'];
            $log_data['settlement']     = $data['settlement'];
            $log_data['inter_id']       = $data['inter_id'];
            $log_data['hotel_id']       = $data['hotel_id'];
            $log_data['grand_total']    = $data['grand_total'];
            $log_data['transaction_id'] = '-1';
            
            $order->order_payment( $log_data );
            $order->order_payment_post( $log_data );
            $payment_model->save_payment($log_data, NULL);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Queries hotel package orders information.
     *
     * @param      string  $inter_id   The inter identifier
     * @param      array   $order_ids  The order identifiers
     *
     * @return     array   ( description_of_the_return_value )
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function queryHotelPackageOrdersInfo($inter_id, $order_ids)
    {
        if(!is_array($order_ids) || empty($order_ids))
        {
            return array();
        }

        $this->load->model('soma/shard_config_model', 'model_shard_config');
        $CI = &get_instance();
        $CI->db_shard_config = $this->model_shard_config->build_shard_config($inter_id);
        $CI->current_inter_id = $inter_id;

        $this->soma_db_conn_read->select('order_id, gift_status, consume_status, status');
        $this->soma_db_conn_read->where_in('order_id', $order_ids);
        $result = $this->soma_db_conn_read->get($this->table_name($inter_id))->result_array();

        $gift_status_label      = $this->get_gift_label();
        $consume_status_label   = $this->get_consume_label();
        $order_status_label     = $this->get_status_label();

        $fmtResult = array();
        foreach($result as $row)
        {
            $tmp                           = $row;
            $tmp['gift_status_label']      = $gift_status_label[ $row['gift_status'] ];
            $tmp['consume_status_label']   = $consume_status_label[ $row['consume_status'] ];
            $tmp['status_label']           = $order_status_label[ $row['status'] ];
            $fmtResult[ $row['order_id'] ] = $tmp;
        }

        return array('res' => true, 'data' => $fmtResult);
    }

    /**
     * 获取某一时间段内的订单数量
     *
     * @param      string  $inter_id   公众号
     * @param      string  $s_time     开始时间
     * @param      array   $hotel_ids  酒店id集合
     * @param      int     $status     订单状态
     *
     * @return     int     订单数量
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getOrderQty(
        $inter_id,
        $start_time,
        $hotel_ids = array(),
        $status = self::STATUS_PAYMENT)
    {
        $this->load->model('soma/shard_config_model', 'model_shard_config');
        $CI = &get_instance();
        $CI->db_shard_config = $this->model_shard_config->build_shard_config($inter_id);
        $CI->current_inter_id = $inter_id;

        $this->soma_db_conn_read->from($this->table_name($inter_id));
        $this->soma_db_conn_read->where('inter_id', $inter_id);
        $this->soma_db_conn_read->where('create_time >=', $start_time);
        if (!empty($hotel_ids)) {
            $this->soma_db_conn_read->where_in('hotel_id', $hotel_ids);
        }
        if (is_array($status)) {
            $this->soma_db_conn_read->where_in('status', $status);
        } else {
            $this->soma_db_conn_read->where('status', $status);
        }

        return $this->soma_db_conn_read->count_all_results();
    }

    /**
     * 获取订单的价格详情
     * @param $inter_id
     * @param $select
     * @param $filter
     * @return mixed
     * @author daikanwu <daikanwu@jperation.com>
     */
    public function getOrderList($inter_id, $select, $filter)
    {
        $select = empty($select)? '*':implode(',', $select);
        $result = $this->soma_db_conn_read
            ->select($select);
        if (!empty($filter)) {
            foreach ($filter as $k=>$v) {
                if (is_array($v)) {
                    $result = $result->where_in($k, $v);
                } else {
                    $result = $result->where($k, $v);
                }
            }
        }

        $result = $result->get($this->table_name($inter_id))
            ->result_array();
        return $result;
    }

    /**
     * 修改备注
     * @param string $inter_id
     * @param int $order_id 订单id
     * @param string $remark 备注
     * @return array
     * @author chencong <chencong@mofly.cn>
     * @date 2017/07/31
     */
    public function save_remark($inter_id, $order_id, $remark)
    {
        $order_id = (int)$order_id;
        $remark = addslashes($remark);

        if(mb_strlen($remark, 'utf-8') > 256){
            return array('res' => false, 'msg' => '备注最多只能256个字符数');
        }

        $res = $this->_shard_db($inter_id)
            ->set(array('remark' => $remark))
            ->where(array('order_id' => $order_id))
            ->update($this->table_name($inter_id));
        if($res === false){
            return array('res' => false, 'msg' => '编辑失败');
        }

        return array('res' => true, 'msg' => '编辑成功');
    }
}