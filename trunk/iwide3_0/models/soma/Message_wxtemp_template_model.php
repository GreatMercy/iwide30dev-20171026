<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Message_wxtemp_template_model extends MY_Model_Soma {

    const QUEUE_STATUS_BOOKING = 1;//计划任务预备发送
    const QUEUE_STATUS_SUCCESS = 2;//计划任务发送成功
    const QUEUE_STATUS_FAIL = 3;//计划任务发送失败

    const TEMPLATE_BUY_SUCCESS = 1;//购买
    const TEMPLATE_BOOKING_SUCCESS = 2;//预约
    const TEMPLATE_CONSUMER_SUCCESS = 3;//消费

    const TEMPLATE_PACKAGE_EXPIRE = 11;//套票过期

    const TEMPLATE_GROUPON_SUCCESS = 21;//团购成功
    const TEMPLATE_GROUPON_FAIL = 22;//团购失败

    const TEMPLATE_PAY_BREAK = 31;//支付中断

    const TEMPLATE_SHIPPING_SHIPPED = 41;//已发货
    const TEMPLATE_SHIPPING_RECEIVED = 42;//订单已签收通知

    const TEMPLATE_GIFT_RECEIVED = 51;//礼物被领取
    const TEMPLATE_GIFT_OVER = 52;//礼物被领完通知
    const TEMPLATE_GIFT_RETURN = 53;//礼物退回

    const TEMPLATE_REFUND_PENDING = 61;//退款申请通过
    const TEMPLATE_REFUND_REFUND = 62;//账户已退款

    const TEMPLATE_BIG_CUSTOMER = 71;//大客户下单

    const TEMPLATE_KILLSEC_SUBSCRIBER = 81;//订阅了秒杀活动

    // 管理员消息通知模板
    const TEMPLATE_BACKEND_NEW_ORDER = 91;
    const TEMPLATE_BACKEND_NEW_REFUND = 92;
    const TEMPLATE_BACKEND_NEW_SHIPPED = 93;

    const TEMPLATE_OTHER = 101;//其它

    const TEMPLATE_FIRST = 'first';//模版内容的头部
    const TEMPLATE_REMARK = 'remark';//模版内容的尾部

    //抢尾房活动
    private $kill_group_url = '';

    public function get_template_send_sort()
    {
        //微信最多可以添加25个模版，这里暂定25为最紧急，数值越大，发送越紧急
        //1-10 非紧急  11-20 比较紧急  21-25 紧急
        return array(
                self::TEMPLATE_BUY_SUCCESS=>25,//购买
                self::TEMPLATE_CONSUMER_SUCCESS=>25,//消费
                self::TEMPLATE_BIG_CUSTOMER=>25,//大客户下单
                self::TEMPLATE_KILLSEC_SUBSCRIBER=>25,//订阅了秒杀活动

                self::TEMPLATE_BOOKING_SUCCESS=>17,//预约
                self::TEMPLATE_SHIPPING_SHIPPED=>16,//已发货
                self::TEMPLATE_GROUPON_SUCCESS=>15,//团购成功
                self::TEMPLATE_GROUPON_FAIL=>14,//团购失败

                self::TEMPLATE_GIFT_RECEIVED=>7,//礼物被领取
                self::TEMPLATE_GIFT_RETURN=>6,//礼物退回
                self::TEMPLATE_PACKAGE_EXPIRE=>5,//套票过期
                self::TEMPLATE_REFUND_PENDING=>4,//退款申请通过
            );
    }

    //模版类型
    public function get_template_type()
    {
        return array(
                self::TEMPLATE_BUY_SUCCESS=>'购买成功',
                self::TEMPLATE_BOOKING_SUCCESS=>'预约成功',
                self::TEMPLATE_CONSUMER_SUCCESS=>'消费成功',
                self::TEMPLATE_PACKAGE_EXPIRE=>'套票到期提醒',
                self::TEMPLATE_GROUPON_SUCCESS=>'拼团成功',
                self::TEMPLATE_GROUPON_FAIL=>'拼团失败',
                self::TEMPLATE_SHIPPING_SHIPPED=>'订单已发货通知',
                // self::TEMPLATE_SHIPPING_RECEIVED=>'订单已签收通知',
                self::TEMPLATE_GIFT_RECEIVED=>'礼物被领取通知',
                // self::TEMPLATE_GIFT_OVER=>'礼物被领完通知',
                self::TEMPLATE_GIFT_RETURN=>'礼物退回通知',
                self::TEMPLATE_REFUND_PENDING=>'商品退款申请通过',
                self::TEMPLATE_BIG_CUSTOMER=>'大客户下单',
                self::TEMPLATE_KILLSEC_SUBSCRIBER=>'订阅秒杀活动通知',
                // self::TEMPLATE_REFUND_REFUND=>'账户已退款',
                self::TEMPLATE_BACKEND_NEW_ORDER => '[管理员]新订单提醒',
                self::TEMPLATE_BACKEND_NEW_REFUND => '[管理员]新退款申请提醒',
                self::TEMPLATE_BACKEND_NEW_SHIPPED => '[管理员]新邮寄申请提醒',
            );
    }

    /**
     * Gets the template default setting.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function get_template_default_setting()
    {
        return array(
            self::TEMPLATE_BUY_SUCCESS => array(
                'header'        => '您好，您的商品已购买成功',
                'footer'        => '感谢您的支持和厚爱',
                'url'           => 'soma_order_order_detail',
                'content_field' => array(
                    'buyOrderId'    => '购买订单号',
                    'buyQty'        => '购买数量',
                    'buyOrderMoney' => '购买订单金额',
                    'buyPoint'      => '积分增加',
                ),
            ),
            self::TEMPLATE_BOOKING_SUCCESS => array(
                'header'        => '您已成功预约',
                'footer'        => '感谢您的支持和厚爱',
                'url'           => 'soma_package_index',
                'content_field' => array(
                    'bookingName' => '预约项目',
                    'bookingDate' => '预约时间',
                ),
            ),
            self::TEMPLATE_CONSUMER_SUCCESS => array(
                'header'        => '您好，您已消费成功',
                'footer'        => '感谢您的支持和厚爱',
                'url'           => 'soma_order_my_order_list',
                'content_field' => array(
                    'consumerName' => '消费商品名称',
                    'consumerCode' => '消费券码',
                    'consumerTime' => '消费时间',
                ),
            ),
            self::TEMPLATE_PACKAGE_EXPIRE => array(
                'header'        => '您的券即将到期',
                'footer'        => '点击立即使用',
                'url'           => 'soma_order_order_detail',
                'content_field' => array(
                    'packageOrderId'    =>'到期订单编号',
                    'packageCreateTime' =>'到期创建时间',
                    'packageExpireTime' =>'到期过期时间',
                ),
            ),
            self::TEMPLATE_GROUPON_SUCCESS => array(
                'header'        => '拼团成功',
                'footer'        => '拼团成功了哦',
                'url'           => 'soma_order_order_detail',
                'content_field' => array(
                    'grouponName'  => '团购成功商品名称',
                    'grouponHeads' => '团购成功团长',
                    'grouponNum'   => '团购成功人数',
                ),
            ),
            self::TEMPLATE_GROUPON_FAIL => array(
                'header'        => '拼团失败',
                'footer'        => '拼团真的失败了',
                'url'           => 'soma_package_package_detail',
                'content_field' => array(
                    'grouponFailName'        => '团购失败产品名称',
                    'grouponFailMoney'       => '团购失败商品金额',
                    'grouponFailRefundMoney' => '团购失败退款金额',
                ),
            ),
            self::TEMPLATE_SHIPPING_SHIPPED => array(
                'header'        => '您的订单已经发货，点击查看物流信息',
                'footer'        => '感谢您的支持和厚爱',
                'url'           => 'soma_order_order_detail',
                'content_field' => array(
                    'mailName'        => '订单发货商品名称',
                    'mailDistributor' => '订单发货物流服务',
                    'mailTrackingNo'  => '订单发货快递单号',
                    'mailAddress'     => '订单发货收货地址',
                ),
            ),
            self::TEMPLATE_GIFT_RECEIVED => array(
                'header'        => '您送出的礼物已被领取',
                'footer'        => '点击查看领取详情',
                'url'           => 'soma_order_order_detail',
                'content_field' => array(
                    'giftUsername' => '礼物领取人',
                    'giftName'     => '礼物名称',
                    'giftDatetime' => '礼物领取时间',
                ),
            ),
            self::TEMPLATE_GIFT_RETURN => array(
                'header'        => '您的礼物已被退回',
                'footer'        => '礼物退回成功',
                'url'           => 'soma_order_my_order_list',
                'content_field' => array(
                    'giftReturnName'     => '礼物退回商品名称',
                    'giftReturnDatetime' => '礼物退回时间',
                ),
            ),
            self::TEMPLATE_REFUND_PENDING => array(
                'header'        => '退款申请',
                'footer'        => '退款申请通过',
                'url'           => 'soma_order_my_order_list',
                'content_field' => array(
                    'refundPendingMoney'   => '退款申请金额',
                    'refundPendingName'    => '退款申请商品名称',
                    'refundPendingOrderId' => '退款申请订单编号',
                ),
            ),
            self::TEMPLATE_BIG_CUSTOMER => array(
                'header'        => '尊敬的客户，您预订的订单已确认',
                'footer'        => '点击查看订单详情，感谢您的支持与厚爱',
                'url'           => 'soma_reserve_reserve_order',
                'content_field' => array(
                    'bigCustomerOrderId'    =>'大客户订单号',
                    'bigCustomerOrderMoney' =>'大客户订单金额',
                    'bigCustomerOrderTime'  =>'大客户订单时间',
                ),
            ),
            self::TEMPLATE_KILLSEC_SUBSCRIBER => array(
                'header' => '秒杀即将开始',
                'footer' => '赶紧去瞅瞅',
                'url' => 'soma_package_package_detail',
                'content_field' => array(
                    'killsecActivityContent' =>'秒杀订阅活动内容',
                    'killsecActivityTime'    =>'秒杀订阅活动时间',
                    'killsecActivityAddress' =>'秒杀订阅活动地点',
                    'killsecActivityMoney'   =>'秒杀订阅活动费用',
                ),
            ),
            self::TEMPLATE_BACKEND_NEW_ORDER => array(
                'header'        => '您有新的商城订单',
                'footer'        => '请及时登录后台处理',
                'url'           => '0',
                'content_field' => array(
                    'backendNewOrderID'            => '[管理员]订单编号',
                    'backendNewOrderDetail'        => '[管理员]订单详情',
                    'backendNewOrderGrandTotal'    => '[管理员]订单金额',
                    'backendNewOrderContact'       => '[管理员]联系人',
                    'backendNewOrderPaymentMethod' => '[管理员]支付方式',
                ),
            ),
            self::TEMPLATE_BACKEND_NEW_REFUND => array(
                'header'        => '您有新的退款申请',
                'footer'        => '请及时登录后台处理',
                'url'           => '0',
                'content_field' => array(
                    'backendNewRefundOrderId'    => '[管理员]订单编号',
                    'backendNewRefundGrandTotal' => '[管理员]订单金额',
                    'backendNewRefundReson'      => '[管理员]申请原因',
                ),
            ),
            self::TEMPLATE_BACKEND_NEW_SHIPPED => array(
                'header'        => '您好，您有新的邮寄申请',
                'footer'        => '请及时发货哦～',
                'url'           => '0',
                'content_field' => array(
                    'backendNewShippedAssetName'       => '[管理员]资产名称',
                    'backendNewShippedReceiver'        => '[管理员]收件人姓名',
                    'backendNewShippedReceiverPhone'   => '[管理员]收件人电话',
                    'backendNewShippedReceiverAddress' => '[管理员]收件人地址',
                ),
            ),
        );
    }

    //模版链接
    public function get_template_url()
    {
        return array(
                '0'=>'－－无链接－－',
                'soma_package_index'=>'首页',
                'soma_package_package_detail'=>'商品详情',
                'soma_order_my_order_list'=>'订单中心',
                'soma_order_order_detail'=>'订单详情',
                'soma_reserve_reserve_order'=>'大客户订单详情',
            );
    }
    //模版字段
    public function get_template_field_name()
    {
        return array(
                //套票到期
                'packageOrderId'        =>'到期订单编号',
                'packageCreateTime'     =>'到期创建时间',
                'packageExpireTime'     =>'到期过期时间',
                //购买成功
                'buyOrderId'            => '购买订单号',
                'buyQty'                => '购买数量',
                'buyOrderMoney'         => '购买订单金额',
                'buyPoint'              => '积分增加',
                //预约成功
                'bookingName'           => '预约项目',
                'bookingDate'           => '预约时间',
                //消费成功
                'consumerName'          => '消费商品名称',
                'consumerCode'          => '消费券码',
                'consumerTime'          => '消费时间',
                //拼团成功
                'grouponName'           => '团购成功商品名称',
                'grouponHeads'          => '团购成功团长',
                'grouponNum'            => '团购成功人数',
                //拼团失败
                'grouponFailName'       => '团购失败产品名称',
                'grouponFailMoney'      => '团购失败商品金额',
                'grouponFailRefundMoney'=> '团购失败退款金额',
                //订单已发货
                'mailName'              => '订单发货商品名称',
                'mailDistributor'       => '订单发货物流服务',
                'mailTrackingNo'        => '订单发货快递单号',
                'mailAddress'           => '订单发货收货地址',
                //订单已签收
                'mailSuccessOrderId'    =>'订单签收订单号',
                'mailSuccessUsername'   =>'订单签收人',
                'mailSuccessDateTime'   =>'订单签收时间',
                //礼物被领取
                'giftUsername'          => '礼物领取人',
                'giftName'              => '礼物名称',
                'giftDatetime'          => '礼物领取时间',
                //礼物退回
                'giftReturnName'        => '礼物退回商品名称',
                'giftReturnDatetime'    => '礼物退回时间',
                //退款申请通过
                'refundPendingMoney'    => '退款申请金额',
                'refundPendingName'     => '退款申请商品名称',
                'refundPendingOrderId'  => '退款申请订单编号',

                //大客户下单
                'bigCustomerOrderId'    =>'大客户订单号',
                'bigCustomerOrderMoney' =>'大客户订单金额',
                'bigCustomerOrderTime'  =>'大客户订单时间',

                //订阅秒杀活动通知
                'killsecActivityContent'=>'秒杀订阅活动内容',
                'killsecActivityTime'   =>'秒杀订阅活动时间',
                'killsecActivityAddress'=>'秒杀订阅活动地点',
                'killsecActivityMoney'  =>'秒杀订阅活动费用',

                // 后台订单通知
                'backendNewOrderID'                 => '[管理员]订单编号',
                'backendNewOrderDetail'             => '[管理员]订单详情',
                'backendNewOrderGrandTotal'         => '[管理员]订单金额',
                'backendNewOrderContact'            => '[管理员]联系人',
                'backendNewOrderPaymentMethod'      => '[管理员]支付方式',

                // 后台退款申请通知
                'backendNewRefundOrderId'           => '[管理员]订单编号',
                'backendNewRefundGrandTotal'        => '[管理员]订单金额',
                'backendNewRefundReson'             => '[管理员]申请原因',

                // 后台邮寄申请通知
                'backendNewShippedAssetName'        => '[管理员]资产名称',
                'backendNewShippedReceiver'         => '[管理员]收件人姓名',
                'backendNewShippedReceiverPhone'    => '[管理员]收件人电话',
                'backendNewShippedReceiverAddress'  => '[管理员]收件人地址',
            );
    }
    //订阅秒杀活动通知
    public function get_killsec_subscriber_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'killsecActivityContent'=>array('key'=>'keyword1','field'=>'name'),//'秒杀活动内容',
                'killsecActivityTime'=>array('key'=>'keyword2','field'=>'time'),//'秒杀活动时间',
                'killsecActivityAddress'=>array('key'=>'keyword3','field'=>'address'),//'秒杀活动地点',
                'killsecActivityMoney'=>array('key'=>'keyword4','field'=>'money'),//'秒杀活动费用',
            );
    }
    //大客户下单
    public function get_big_customer_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'bigCustomerOrderId'=>array('key'=>'keyword1','field'=>'reserve_id'),//'大客户订单号',
                'bigCustomerOrderMoney'=>array('key'=>'keyword2','field'=>'grand_total'),//'大客户订单金额',
                'bigCustomerOrderTime'=>array('key'=>'keyword3','field'=>'update_time'),//'大客户订单时间',
            );
    }
    //商品退款申请通过
    public function get_refund_pending_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'refundPendingMoney'=>array('key'=>'keyword1','field'=>'refund_total'),//退款申请金额
                'refundPendingName'=>array('key'=>'keyword2','field'=>'name'),//退款申请商品名称
                'refundPendingOrderId'=>array('key'=>'keyword3','field'=>'order_id'),//退款申请订单编号
            );
    }
    //礼物退回
    public function get_gift_return_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'giftReturnName'=>array('key'=>'keyword1','field'=>'name'),//礼物退回商品名称
                'giftReturnDatetime'=>array('key'=>'keyword2','field'=>'return_time'),//礼物退回时间
            );
    }
    //礼物被领取
    public function get_gift_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'giftUsername'=>array('key'=>'keyword1','field'=>'username'),//礼物领取人
                'giftName'=>array('key'=>'keyword2','field'=>'name'),//礼物名称
                'giftDatetime'=>array('key'=>'keyword3','field'=>'time'),//礼物领取时间
            );
    }
    //订单已签收
    public function get_mail_success_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'mailSuccessOrderId'=>array('key'=>'keyword1','field'=>'order_id'),//订单签收订单号
                'mailSuccessUsername'=>array('key'=>'keyword2','field'=>'username'),//订单签收人
                'mailSuccessDateTime'=>array('key'=>'keyword3','field'=>'datetime'),//订单签收时间
            );
    }
    //订单已发货
    public function get_mail_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'mailName'=>array('key'=>'keyword1','field'=>'name'),//订单发货产品名称
                'mailDistributor'=>array('key'=>'keyword2','field'=>'distributor'),//订单发货物流服务
                'mailTrackingNo'=>array('key'=>'keyword3','field'=>'tracking_no'),//订单发货快递单号
                'mailAddress'=>array('key'=>'keyword4','field'=>'address'),//订单发货地址
            );
    }
    //团购失败
    public function get_groupon_fail_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'grouponFailName'=>array('key'=>'keyword1','field'=>'name'),//团购失败产品名称
                'grouponFailMoney'=>array('key'=>'keyword2','field'=>'grand_total'),//团购失败商品金额
                'grouponFailRefundMoney'=>array('key'=>'keyword3','field'=>'refund_total'),//团购失败退款金额
            );
    }
    //团购成功
    public function get_groupon_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'grouponName'=>array('key'=>'keyword1','field'=>'name'),//团购成功商品名称
                'grouponHeads'=>array('key'=>'keyword2','field'=>'create_openid'),//团购成功团长
                'grouponNum'=>array('key'=>'keyword3','field'=>'join_count'),//团购成功人数
            );
    }
    //购买成功
    public function get_buy_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'buyOrderId'=>array('key'=>'keyword1','field'=>'order_id'),//订单号
                'buyQty'=>array('key'=>'keyword2','field'=>'qty'),//数量
                'buyOrderMoney'=>array('key'=>'keyword3','field'=>'grand_total'),//订单金额
                'buyPoint'=>array('key'=>'keyword4','field'=>'point'),//point积分
            );
    }
    //预约成功
    public function get_booking_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'bookingName'=>array('key'=>'keyword1','field'=>'name'),//预约项目
                'bookingDate'=>array('key'=>'keyword2','field'=>'reserve_date'),//预约时间
            );
    }
    //消费成功
    public function get_consumer_template_field_mapping()
    {
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
                'consumerName'=>array('key'=>'keyword1','field'=>'name'),//消费信息
                'consumerCode'=>array('key'=>'keyword2','field'=>'consumer_code'),//消费券码
                'consumerTime'=>array('key'=>'keyword3','field'=>'consumer_time'),//消费时间
            );
    }
    //套票过期
    public function get_package_exp_template_field_mapping()
    {
        /**
        //第一版
        return array(//20160809 luguihong  微信模版库里面搜索不出套票过期模版，现在修改为微信模版里面的［即将过期提醒］模版消息
                 'packageName'      =>array('key'=>'name','field'=>'name'),//商品名称
                 'packageExpDate'   =>array('key'=>'expDate','field'=>'expiration_date'),//过期时间
             );
        //第二版
        return array(
                'packageName'   =>array('key'=>'keyword1','field'=>'name'),//商品名称
                'packageExpDate'=>array('key'=>'keyword2','field'=>'expiration_date'),//过期时间
            );
        */
        //第三版
        //key是发送模版内容的key,field是对应的字段根据传入的array取出数据
        return array(
            'packageOrderId'    =>array('key'=>'keyword1','field'=>'order_id_str'),//订单编号
            'packageCreateTime' =>array('key'=>'keyword2','field'=>'create_time'),//创建时间
            'packageExpireTime' =>array('key'=>'keyword3','field'=>'expire_time'),//过期时间
        );
    }

    public function get_resource_name()
    {
        return 'Message_wxtemp_template_model';
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /**
     * @return string the associated database table name
     */
    // public function table_name($inter_id)
    // {
    //  return 'soma_message_wxtemp_template';
    // }

    public function table_name($inter_id=NULL)
    {
        return $this->_shard_table('soma_message_wxtemp_template', $inter_id);
    }

    public function table_primary_key()
    {
        return 'temp_id';
    }
    
    public function attribute_labels()
    {
        return array(
            'temp_id'=> 'ID',
            'inter_id'=> '公众号',
            'hotel_id'=> '酒店',
            'template_id'=> '模版ID',
            'type'=> '模版类型',
            'content'=> '模版内容',
            'link'=> '链接',
            'default_link'=> '自定义链接',
            'create_time'=> '创建时间',
            'update_time'=> '更新时间',
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
            'temp_id',
            'inter_id',
            'hotel_id',
            // 'template_id',
            'type',
            // 'content',
            'link',
            'create_time',
            // 'update_time',
            'status',
        );
    }

    //定义 m_save 保存时不做转义字段
    public function unaddslashes_field()
    {
        return array(
            'msg',
            'result',
            'content',
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
            'temp_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text', //textarea|text|combobox|number|email|url|price
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
            ),'hotel_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                // 'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> $hotels,
            ),
            'template_id' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text', //textarea|text|combobox|number|email|url|price
            ),
            'type' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> $this->get_template_type(),
            ),
            'content' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text', //textarea|text|combobox|number|email|url|price
            ),
            'link' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                'form_default'=> 'http://',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=>$this->get_template_url(),
            ),
            'default_link' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                // 'form_default'=> 'http://',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'text', //textarea|text|combobox|number|email|url|price
            ),
            'create_time' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                'form_default'=> date('Y-m-d H:i:s'),
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'datetime', //textarea|text|combobox|number|email|url|price
            ),
            'update_time' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                'form_default'=> date('Y-m-d H:i:s'),
                //'form_tips'=> '注意事项',
                'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'datetime', //textarea|text|combobox|number|email|url|price
            ),
            'status' => array(
                'grid_ui'=> '',
                'grid_width'=> '10%',
                //'form_ui'=> ' disabled ',
                //'form_default'=> '0',
                //'form_tips'=> '注意事项',
                //'form_hide'=> TRUE,
                //'grid_function'=> 'show_price_prefix|￥',
                'type'=>'combobox', //textarea|text|combobox|number|email|url|price
                'select'=> $Somabase_util::get_status_options(),
            ),
        );
    }
    
    /**
     * grid表格中默认哪个字段排序，排序方向
     */
    public static function default_sort_field()
    {
        return array('field'=>'temp_id', 'sort'=>'desc');
    }
    
    /* 以上为AdminLTE 后台UI输出配置函数 */

    //后台反序列化content字段，输出到详情
    public function unserialize_content()
    {
        if( isset( $this->_data['content'] ) && !empty( $this->_data['content'] ) ){
            $content = @unserialize( base64_decode( $this->_data['content'] ) );
            if( !$content ){
                $content = @unserialize( $this->_data['content'] );//Message: unserialize(): Error at offset 0 of 258 bytes 数据库字段类型不够长
                if( $content ){
                    return $content;
                }
            }else{
                return $content;
            }
        }

        //套票内容,可以设置多个
        return array( 
                        'first'=>array( 'key'=>'first', 'value'=>'', 'color'=>'' ),
                        '1'=>array( 'key'=>'', 'value'=>'', 'color'=>'' ), 
                        'remark'=>array( 'key'=>'remark', 'value'=>'', 'color'=>'' ),
                    );
        

    }

    //获取模版列表
    public function get_template_list( $inter_id=NULL )
    {
        if( !$inter_id ){
            return FALSE;
        }

        $filter = array();
        $filter['inter_id'] = $inter_id;
        $filter['status'] = parent::STATUS_TRUE;

        return $this->find_all( $filter );
    }

    //根据模版ID查找模版详情
    public function get_template_detail( $template_id, $inter_id )
    {
        if( !$template_id ){
            return FALSE;
        }

        $filter = array();
        $filter['template_id'] = $template_id;
        $filter['inter_id'] = $inter_id;
        $filter['status'] = parent::STATUS_TRUE;

        return $this->find( $filter );
    }

    //根据模版类型查找模版详情
    public function get_template_detail_byType( $type, $inter_id )
    {
        if( !$type ){
            return FALSE;
        }

        $filter = array();
        $filter['type'] = $type;
        $filter['inter_id'] = $inter_id;
        $filter['status'] = parent::STATUS_TRUE;

        $result = $this->find( $filter );
        if( !$result ){
            //使用类型查找不到模版
            $this->_write_log( '使用类型查找不到模版'.json_encode( $filter ) );
        }

        return $result;
    }


    /**
     * @param $interIDs
     * @param $type
     * @return array|string
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function get_template_detail_by_type($interIDs, $type)
    {
        if (empty($interIDs)) return [];

        $rows = $this->get(
            array(
                'type',
                'inter_id'
            ),
            array(
                $type,
                $interIDs
            ),
            '*',
            array(
                'limit' => count($interIDs),
                'table_name' => $this->table_name(),
                'debug' => false
            )
        );
        return $rows;
    }


    //获取模版字段映射到表字段
    public function get_template_field_mapping( $type )
    {
        $info = array();
        switch ($type) {
            case self::TEMPLATE_BUY_SUCCESS:
                $info = $this->get_buy_template_field_mapping();//购买成功
                break;
            case self::TEMPLATE_BOOKING_SUCCESS:
                $info = $this->get_booking_template_field_mapping();//预约成功
                break;
            case self::TEMPLATE_CONSUMER_SUCCESS:
                $info = $this->get_consumer_template_field_mapping();//消费成功
                break;
            case self::TEMPLATE_PACKAGE_EXPIRE:
                $info = $this->get_package_exp_template_field_mapping();//套票过期
                break;
            case self::TEMPLATE_GROUPON_SUCCESS:
                $info = $this->get_groupon_template_field_mapping();//团购成功
                break;
            case self::TEMPLATE_GROUPON_FAIL:
                $info = $this->get_groupon_fail_template_field_mapping();//团购失败
                break;
            case self::TEMPLATE_SHIPPING_SHIPPED:
                $info = $this->get_mail_template_field_mapping();//已发货
                break;
            case self::TEMPLATE_SHIPPING_RECEIVED:
                $info = $this->get_mail_success_template_field_mapping();//已签收
                break;
            case self::TEMPLATE_GIFT_RECEIVED:
                $info = $this->get_gift_template_field_mapping();//礼物成功
                break;
            case self::TEMPLATE_GIFT_RETURN:
                $info = $this->get_gift_return_template_field_mapping();//礼物退回
                break;
            case self::TEMPLATE_REFUND_PENDING:
                $info = $this->get_refund_pending_template_field_mapping();//退款申请通过
                break;
            case self::TEMPLATE_BIG_CUSTOMER:
                $info = $this->get_big_customer_template_field_mapping();//大客户下单
                break;
            case self::TEMPLATE_KILLSEC_SUBSCRIBER:
                $info = $this->get_killsec_subscriber_template_field_mapping();//订阅了秒杀活动
                break;
            case self::TEMPLATE_BACKEND_NEW_ORDER:
                $info = $this->getOrderAdminNoticeMessageFieldMapping();
                break;
            case self::TEMPLATE_BACKEND_NEW_SHIPPED:
                $info = $this->getShipAdminNoticeMessageFieldMapping();
                break;
            case self::TEMPLATE_BACKEND_NEW_REFUND:
                $info = $this->getRefundAdminNoticeMessageFieldMapping();
                break;
            default:
                # code...
                break;
        }

        return $info;
    }

    /*
     * 组装发送模版内容，并生成计划任务
     * @param $openid 要发送到哪个用户
     * @param $template_id 模版ID
     * @param $array 组装好发送的数据(一维数组)
     * @param $inter_id 公众号
     * @return array('status'=>'1创建模版消息成功，2失败','message'=>'模版消息','data'=>'保存到队列的数据')
    */
    public function create_template_message( $openid, $template_id, $type, $array, $inter_id, $business='package' )
    {

        $return = array();//返回的数据
        if( !$openid || !$template_id || !$inter_id || count( $array ) == 0 ){
            $return['status'] = 2;
            $return['message'] = '传入的条件不足';

            $log = array();
            $log['openid'] = $openid;
            $log['template_id'] = $template_id;
            $log['type'] = $type;
            $log['array'] = $array;
            $log['inter_id'] = $inter_id;
            $log['business'] = $business;
            $this->_write_log( json_encode( $log ) );

            return $return;
        }

        //获取模版信息
        $templateInfo = $this->get_template_detail( $template_id, $inter_id );
        if( !$templateInfo ){
            $return['status'] = 2;
            $return['message'] = '找不到消息模版';

            $this->_write_log( json_encode( $return ) );

            return $return;
        }

        $message = array();//模版消息

        //模版内容
        $content = @unserialize( base64_decode( $templateInfo['content'] ) );
        if( !$content ){
            $content = unserialize( $templateInfo['content'] );//Message: unserialize(): Error at offset 0 of 258 bytes
        }
        // $content = unserialize( $templateInfo['content'] );

        $message['touser'] = $openid;//发送给哪个用户
        $message['template_id'] = $template_id;//微信模版ID

        //链接处理
        $url = '';
        $param = array( 'id'=>$inter_id, 'bsn'=>$business );
        $defaultTemplateUrl = isset( $templateInfo['default_link'] ) ? $templateInfo['default_link'] : '';//自定义链接
        $templateUrl = $templateInfo['link'];//需要处理链接
        if( $templateUrl && !$defaultTemplateUrl ){
            
            switch ($templateUrl) {
                case 'soma_package_index':
                    break;
                case 'soma_package_package_detail':
                    $param['pid'] = isset( $array['product_id'] ) ? $array['product_id'] : '';
                    break;
                case 'soma_order_my_order_list':
                    break;
                case 'soma_order_order_detail':
                    $param['oid'] = isset( $array['order_id'] ) ? $array['order_id'] : '';
                    break;
                case 'soma_reserve_reserve_order':
                    $param['reserve_id'] = isset( $array['order_id'] ) ? $array['order_id'] : '';
                    break;
                default:
                    break;
            }
            
            if ( !empty($this->kill_group_url)){
                $templateUrl = $this->kill_group_url;
            }

            $exp = explode( '_', $templateUrl, 3 );

            if( defined('PROJECT_AREA') && PROJECT_AREA=='mooncake' ){
                //月饼域名
                $url = config_item('mooncake_front_domain').'/'.$exp[0].'/'.$exp[1].'/'.$exp[2].'?';//.'?id='.$param['id'].'&reserve_id='.$param['reserve_id'];
                foreach ($param as $k => $v) {
                    $url .= $k.'='.$v.'&';
                }
                $url = trim( $url, '&' );
            }else{
                $url = Soma_const_url::inst()->get_front_url( $inter_id, $exp[0].'/'.$exp[1].'/'.$exp[2], $param );
            }
        }else{
            $url = $defaultTemplateUrl;
        }
        $message['url'] = $url;

        $message['data'] = array();//发送的内容
        $message['data']['first'] = array( 
                                        'value'=>$content['first']['value'], 
                                        'color'=>$content['first']['color'], 
                                    );
        $message['data']['remark'] = array( 
                                        'value'=>$content['remark']['value'], 
                                        'color'=>$content['remark']['color'], 
                                    );

        //获取模版字段映射
        $templateMapping = $this->get_template_field_mapping( $type );
        foreach ($templateMapping as $k => $v) {//循环字段映射
            foreach( $content as $sk=>$sv ){//循环模版内容
                if( $sv['key'] == $k ){//如果模版内容的key＝字段映射的key

                    $value = '';
                    $key = '';
                    if( $sv['key'] == self::TEMPLATE_FIRST ){
                        $value = $sv['value'];
                        $key = self::TEMPLATE_FIRST;
                    }elseif( $sv['key'] == self::TEMPLATE_REMARK ){
                        $value = $sv['value'];
                        $key = self::TEMPLATE_REMARK;
                    }else{

                        $key = $v['key'];

                        //过期提醒需要特殊处理
                        if( $type == self::TEMPLATE_PACKAGE_EXPIRE )
                        {
                            if( !empty( $templateInfo['update_time'] ) )
                            {
                                if ( $v['field'] == 'name' ){
                                    //20170526 luguihong 这里修改，主要是为了兼容第二版已经添加过期模版消息的
                                    $key = 'keyword1';
                                } elseif ( $v['field'] == 'expiration_date' ){
                                    //20160809 luguihong 这里修改，主要是为了兼容第二版已经添加过期模版消息的
                                    $key = 'keyword2';
                                }

                            } else {
                                if( $v['field'] == 'name' ){
                                    //20160809 luguihong 这里修改，主要是为了兼容第一版已经添加过期模版消息的
                                    $key = 'name';
                                } elseif ( $v['field'] == 'expiration_date' ){
                                    //20160809 luguihong 这里修改，主要是为了兼容第一版已经添加过期模版消息的
                                    $key = 'expDate';
                                }

                            }
                        }

                        $value = isset( $array[$v['field']] ) ? $array[$v['field']] : '';

                    }

                    //赋值
                    $message['data'][$key] = array( 'value'=>$value, 'color'=>$sv['color'] );
                }
            }
        }
// var_dump( $message );exit;

        $json = json_encode( $message );
        $data = array();
        $data['inter_id'] = $inter_id;
        $data['hotel_id'] = $templateInfo['hotel_id'];
        $data['temp_id'] = $templateInfo['temp_id'];
        $data['template_id'] = $template_id;
        $data['openid'] = $openid;
        $data['type'] = $type;
        $data['msg'] = $json;
        $data['create_time'] = date( "Y-m-d H:i:s", time() );
        $data['sort'] = isset( $array['sort'] ) ? $array['sort'] : NULL;//计划任务排序，传入值时添加
        $data['status'] = 1;
        // $table_name = 'soma_message_wxtemp_queue';

        // //把数据添加到计划任务表里
        // $result = $this->_shard_db( $inter_id )->insert( $table_name, $data );
        // if( $result ){
        //     return TRUE;
        // }else{
        //     return FALSE;
        // }

        $return['status'] = 1;
        $return['message'] = $json;
        $return['data'] = $data;
        return $return;

    }

    //保存要发送的模版消息到队列咧
    public function save_template_message( $data=array(), $inter_id )
    {
        if( count( $data ) == 0 ){
            return FALSE;
        }

        $table_name = 'soma_message_wxtemp_queue';

        //把数据添加到计划任务表里
        $result = $this->_shard_db( $inter_id )->insert( $table_name, $data );
        if( $result ){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function _write_log( $content )
    {
        $path= APPPATH. 'logs'. DS. 'soma'. DS. 'wxtemp'. DS;
        if( !file_exists($path) ) {
            @mkdir($path, 0777, TRUE);
        }
        $file= $path. date('Y-m-d_H'). '.txt';
        $this->write_log($content, $file);
    }

    //保存发送的模版消息到record
    public function save_template_record( $createInfo, $inter_id=NULL )
    {
        if( count( $createInfo ) == 0 || !$inter_id ){
            return FALSE;
        }

        $sendResult = $this->send_template( $createInfo['message'], $inter_id );
        if( isset( $sendResult['status'] ) && $sendResult['status'] == 1 ){
            //发送成功

            //实例化
            $this->load->model( 'soma/Message_wxtemp_record_model', 'MessageWxtempRecordModel' );
            $MessageWxtempRecordModel = $this->MessageWxtempRecordModel;

            $data = array();
            $data = $createInfo['data'];
            $data['result'] = $sendResult['data'];
            $data['create_time'] = date( "Y-m-d H:i:s", time() );
            $data['status'] = $MessageWxtempRecordModel::STATUS_SUCCESS;
            unset( $data['sort'] );
            
            //保存到record
            $MessageWxtempRecordModel->save_record( $data, $inter_id );
        }else{
            //保存到队列里
            $this->save_template_message( $createInfo['data'], $inter_id );
            
            $this->_write_log( json_encode($createInfo) );
            $this->_write_log( json_encode($sendResult['data']) );
        }
        
        return TRUE;
    }

    //执行计划任务
    public function sending_template_message($limit=100,$sort='sort DESC')
    {
        //取出信息
        $filter = array();
        $filter['status'] = self::QUEUE_STATUS_BOOKING;

        $queue_table_name = 'soma_message_wxtemp_queue';
        $queueList = $this->_shard_db_r('iwide_soma_r')
                            ->where( $filter )
                            ->limit( $limit )
                            ->order_by( $sort )
                            ->get( $queue_table_name )
                            ->result_array();

        $this->load->model( 'soma/Message_wxtemp_record_model', 'MessageWxtempRecordModel' );
        $MessageWxtempRecordModel = $this->MessageWxtempRecordModel;

        $queue_status = self::QUEUE_STATUS_BOOKING;
        $record_array = array();
        foreach ($queueList as $k => $v) {

            $message = $v['msg'];
            $inter_id = $v['inter_id'];
            //发送模版消息
            $return = $this->send_template( $message, $inter_id );

            $queue_id = $v['queue_id'];
            $result = isset( $return['data'] ) ? $return['data'] : '';
            $create_time = date( 'Y-m-d H:i:s', time() );
            if( isset( $return['status'] ) && $return['status'] == Soma_base::STATUS_TRUE ){
                
                unset( $v['queue_id'] );
                unset( $v['send_time'] );
                unset( $v['sort'] );

                $v['result'] = $result;
                $v['create_time'] = $create_time;
                $v['status'] = $MessageWxtempRecordModel::STATUS_SUCCESS;
                
                $record_array[] = $v;
                $queue_status = self::QUEUE_STATUS_SUCCESS;
            }else{
                $queue_status = self::QUEUE_STATUS_FAIL;
            }

            $filter = array();
            $filter['queue_id'] = $queue_id;
            $data = array();
            $data['result'] = $result;
            $data['send_time'] = $create_time;
            $data['status'] = $queue_status;
            $this->_shard_db()->where( $filter )->update( $queue_table_name, $data );
        }

        //一次添加发送成功的数据到记录表
        // $this->load->model( 'soma/Message_wxtemp_record_model','MessageWxtempRecordModel' );
        // $MessageWxtempRecordModel = $this->MessageWxtempRecordModel;
        // $record_table_name = $MessageWxtempRecordModel->table_name();
        if( $record_array ){
            // $record_table_name = 'soma_message_wxtemp_record';
            // $this->_shard_db()->insert_batch( $record_table_name, $record_array );
            $MessageWxtempRecordModel->save_record( $record_array );
        }

        return TRUE;
    }

    /**
     * 封装curl的调用接口，post的请求方式
     * @param string URL
     * @param string POST表单值
     * @param array  扩展字段值
     * @param second 超时时间
     * @return mixed 请求成功返回成功结构，否则返回FALSE
     */
    public function doCurlPostRequest($url, $requestString, $extra = array(), $timeout = 5){
        if($url == "" || $requestString == "" || $timeout <= 0){
            return false;
        }
        $con = curl_init(( string )$url);
        curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
        curl_setopt($con, CURLOPT_POST, true);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($con, CURLOPT_TIMEOUT, ( int )$timeout);
        curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($con, CURLOPT_SSL_VERIFYHOST, 0);

        if(!empty ($extra) && is_array($extra)){
            $headers = array();
            foreach($extra as $opt => $value){
                if(strexists($opt, 'CURLOPT_')){
                    curl_setopt($con, constant($opt), $value);
                } elseif(is_numeric($opt)){
                    curl_setopt($con, $opt, $value);
                } else{
                    $headers [] = "{$opt}: {$value}";
                }
            }
            if(!empty ($headers)){
                curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
            }
        }
        $res = curl_exec($con);
    //  var_dump(curl_error($con));
        return $res;
    }

    /**
     * 发送模版消息
     * @param string message 组装好要发送的模版消息
     * wx_return string '{"errcode":0,"errmsg":"ok","msgid":405945162}'
     * @return array
     *
     * @link https://mp.weixin.qq.com/wiki 43004 需要接收者关注
    */
    public function send_template( $message, $inter_id )
    {
        $this->load->model('wx/access_token_model');
        $access_token= $this->access_token_model->get_access_token( $inter_id );
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;

        // $this->load->helper('common_helper');
        $result = $this->doCurlPostRequest( $url, $message );

        $return = array();
        $result_array = json_decode ( $result, TRUE );
        //发送模版消息
        if( $result_array['errcode'] == 40001 || $result_array['errcode'] == 42001 ) {

            //返回40001access_token过期，刷新access_token重新发送
            $access_token = $this->access_token_model->reflash_access_token ( $inter_id );
            $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
            $result = $this->doCurlPostRequest( $url, $message );

            $result_array = json_decode ( $result, TRUE );
        }

        if( $result_array['errcode'] == 0 || $result_array['errcode'] == 43004){
            $return['status'] = 1;
            $return['message'] = '发送成功';

        }else{
            $return['status'] = 2;
            $return['message'] = '发送失败';

            $log = array();
            $log['inter_id'] = $inter_id;
            $log['message'] = $message;
            $log['result'] = $result;
            $this->_write_log( json_encode( $log ) );
        }
        $return['data'] = $result;

        return $return;
        
    }

    /*
     * 团购成功发送模版消息
     * usage $activityGrouponModel->order_id = $order_id 活动对象
     * Usage $model->groupon_success(模版类型, 活动对象, 公众号, 业务类型)
    */
    public function send_template_by_groupon_success( $activityGrouponModel, $inter_id, $business)
    {
        try {

            $debug = FALSE;
            if( $debug )$this->_write_log( json_encode( $activityGrouponModel ).'-->'.$inter_id.'-->'.$business );
            /***********************发送模版消息****************************/
            $userGroup = $activityGrouponModel->get_users_by_order_id( $activityGrouponModel->order_id );
            $groupon = $activityGrouponModel->groupon_group_detail( $userGroup['group_id'] );
            $users = $activityGrouponModel->groupon_group_users($groupon['group_id'],$activityGrouponModel::GROUP_ADD_STATUS_SUCCESS,$inter_id);
            $grouponStatus = $activityGrouponModel->groupon_status_check($groupon,$users);

            if($grouponStatus == $activityGrouponModel::GROUP_STATUS_FINISHED){  //拼团订单成团
                $actInfo = $activityGrouponModel->groupon_detail( $groupon['act_id'] );

                foreach($users as $v) {
                    //bug 发送模版消息的时候团长名称为空，这里获取团长名称可能存在问题
                    $create_name = NULL;
                    if( $v['openid'] == $groupon['create_openid'] ){
                        $create_name = $v['nickname'];
                    }

                    $openid = $v['openid'];//发送给那个用户

                    $type = self::TEMPLATE_GROUPON_SUCCESS;//团购成功
                    $templateInfo = $this->get_template_detail_byType( $type, $inter_id );
                    if( $templateInfo ){
                        $template_id = $templateInfo['template_id'];
                        $array = array();
                        
                        //获取核销码
                        $codeIds = $this->get_code_by_order_id( $v['order_id'], $inter_id );
                        $codeIds_str = '(券码：'.implode($codeIds, ',');
                        if( count( $codeIds ) > 3 ){
                            $codeIds_str .= '更多券码，点击查看)';
                        }else{
                            $codeIds_str .= ')';
                        }

                        $array['name'] = '订单编号：'.$v['order_id'].$codeIds_str.'，商品内容［'.$actInfo['product_name'].'］';//团购商品名称
                        $array['product_id'] = $actInfo['product_id'];//
                        $array['order_id'] = $v['order_id'];//
                        $array['create_openid'] = $create_name;//团长名称
                        $array['join_count'] = $groupon['join_count'];//团购人数

                        if( $debug )$this->_write_log( json_encode( $array ) );
                        $sort_array = $this->get_template_send_sort();
                        $array['sort'] = $sort_array[$type];
                        $createInfo = $this->create_template_message( $openid, $template_id, $type, $array, $inter_id, $business );
                        if( $debug )$this->_write_log( json_encode( $createInfo ) );
                        if( isset( $createInfo['status'] ) && $createInfo['status'] == 1 ){
                            //方式一：保存到队列里
                            $this->save_template_message( $createInfo['data'], $inter_id );

                            //方式二：立即发送模版消息
                            // $this->save_template_record( $createInfo, $inter_id );
                        }
                    }
                    /***********************发送模版消息****************************/
                }
            }

        } catch (Exception $e) {
            $this->_write_log( json_encode( $e->getMessage() ) );
        }
    }

    protected function get_code_by_order_id( $order_id, $inter_id )
    {
        //增加发送核销码(显示三个，更多的显示三个并且加一句更多券码，点击查看)
        $this->load->model('soma/Consumer_code_model','CodelModel');
        $CodelModel = $this->CodelModel;
        $filter = array();
        $filter['order_id'] = $order_id + 0;
        $codeList = $CodelModel->get_code_by_orderId( $filter, 4, $inter_id);
        $codeIds = array();
        if( $codeList ){
            foreach( $codeList as $k=>$v ){
                $codeIds[] = $v['code'];
            }
        }

        return $codeIds;
    }

    /*
     * 普通购买成功发送模版消息
     * usage $salesOrderModel->load( $order_id ); 订单对象
     * Usage $model->groupon_success(模版类型, 活动对象, 公众号, 业务类型)
    */
    public function send_template_by_buy_success( $salesOrderModel, $openid, $inter_id, $business)
    {
        try {

            $debug = FALSE;
            if( $debug )$this->_write_log( json_encode( $salesOrderModel ).'-->'.$openid.'-->'.$inter_id.'-->'.$business );

            $type = self::TEMPLATE_BUY_SUCCESS;//购买成功
            $templateInfo = $this->get_template_detail_byType( $type, $inter_id );
            if( $templateInfo ){
                $template_id = $templateInfo['template_id'];
                $array = array();

                $this->load->model('soma/Sales_item_'.$business.'_model','SalesItemModel');
                $items = $this->SalesItemModel->get_order_items( $salesOrderModel, $inter_id );
                $name = isset( $items[0]['name'] ) ? $items[0]['name'] : '';

                //获取核销码
                $codeIds = $this->get_code_by_order_id( $salesOrderModel->m_get('order_id'), $inter_id );
                $codeIds_str = '(券码：'.implode($codeIds, ',');
                if( count( $codeIds ) > 3 ){
                    $codeIds_str .= '更多券码，点击查看)';
                }else{
                    $codeIds_str .= ')';
                }

                $items = $salesOrderModel->get_order_items( $business, $inter_id );
                if ($inter_id === 'a490782373') {
                    $array['order_id'] = $salesOrderModel->m_get('order_id').$codeIds_str.'，申请的［'.$name.'］';//订单号
                } else {
                    $array['order_id'] = $salesOrderModel->m_get('order_id').$codeIds_str.'，购买的商品［'.$name.'］';//订单号
                }

                $array['product_id'] = isset( $items[0]['product_id'] ) ? $items[0]['product_id'] : NULL;
                $array['qty'] = isset( $items[0]['qty'] ) ? $items[0]['qty'] : NULL;//购买数量
                $array['grand_total'] = $salesOrderModel->m_get('grand_total');//订单金额
                $array['point'] = NULL;//增加积分

                if( $debug )$this->_write_log( json_encode( $array ) );
                $sort_array = $this->get_template_send_sort();
                $array['sort'] = $sort_array[$type];
                $createInfo = $this->create_template_message( $openid, $template_id, $type, $array, $inter_id, $business );
                if( $debug )$this->_write_log( json_encode( $createInfo ) );
                if( isset( $createInfo['status'] ) && $createInfo['status'] == 1 ){
                    //方式一：保存到队列里
                    // $this->save_template_message( $createInfo['data'], $inter_id );

                    //方式二：立即发送模版消息
                    $this->save_template_record( $createInfo, $inter_id );
                }
            }
        } catch (Exception $e) {
            $this->_write_log( json_encode( $e->getMessage() ) );
        }
    }

    /*
     * 退款成功发送模版消息
     * usage $salesRefundModel->load( $refund_id ); 退款订单对象
     * Usage $model->send_template_by_refund_success( 退款订单对象, 用户id, 公众号, 业务类型)
    */
    public function send_template_by_refund_success( $salesRefundModel, $openid, $inter_id, $business)
    {
        try {
            $debug = FALSE;
            if( $debug )$this->_write_log( json_encode( $salesRefundModel ).'-->'.$openid.'-->'.$inter_id.'-->'.$business );
            $type = self::TEMPLATE_REFUND_PENDING;
            $templateInfo = $this->get_template_detail_byType( $type, $inter_id );
            if( $templateInfo ){
                $template_id = $templateInfo['template_id'];
                $array = array();
                
                $order_detail = $salesRefundModel->get_order_detail( $business, $inter_id );
                $array['refund_total'] = $order_detail['refund_total'];
                $array['name'] = '订单编号：'.$order_detail['order_id'].'，商品内容［'.$order_detail['items'][0]['name'].'］';
                $array['order_id'] = $order_detail['order_id'];
                $array['product_id'] = $order_detail['items'][0]['product_id'];

                if( $debug )$this->_write_log( json_encode( $array ) );
                $sort_array = $this->get_template_send_sort();
                $array['sort'] = $sort_array[$type];
                $createInfo = $this->create_template_message( $openid, $template_id, $type, $array, $inter_id, $business );
                if( $debug )$this->_write_log( json_encode( $createInfo ) );
                if( isset( $createInfo['status'] ) && $createInfo['status'] == 1 ){
                    //方式一：保存到队列里
                    $this->save_template_message( $createInfo['data'], $inter_id );

                    //方式二：立即发送模版消息
                    // $this->save_template_record( $createInfo, $inter_id );
                }
            }
        } catch (Exception $e) {
            $this->_write_log( json_encode( $e->getMessage() ) );
        }
    }

    /*
     * 大客户发送模版消息
     * usage $salesReserveModel->load( $reserve_id ); 大客户订单对象
     * Usage $model->send_template_by_big_customer_success( 大客户订单对象, 用户id, 公众号, 业务类型)
    */
    public function send_template_by_big_customer_success( $salesReserveModel, $openid, $inter_id, $business)
    {
        try {
            $debug = TRUE;
            if( $debug )$this->_write_log( json_encode( $salesReserveModel ).'-->'.$openid.'-->'.$inter_id.'-->'.$business );
            $type = self::TEMPLATE_BIG_CUSTOMER;
            $templateInfo = $this->get_template_detail_byType( $type, $inter_id );
            if( $templateInfo ){
                $template_id = $templateInfo['template_id'];
                $array = array();
                
                //大客户下单发送模版内容
                $array['reserve_id'] = '订单编号：'.$salesReserveModel->m_get( 'reserve_id' ).'，购买的商品［'.$salesReserveModel->m_get( 'name' ).'］，';//订单号
                $array['grand_total'] = $salesReserveModel->m_get( 'grand_total' );
                $array['update_time'] = $salesReserveModel->m_get( 'update_time' );
                $array['order_id'] = $salesReserveModel->m_get( 'reserve_id' );
                $array['product_id'] = $salesReserveModel->m_get( 'product_id' );

                if( $debug )$this->_write_log( json_encode( $array ) );
                $sort_array = $this->get_template_send_sort();
                $array['sort'] = $sort_array[$type];
                $createInfo = $this->create_template_message( $openid, $template_id, $type, $array, $inter_id, $business );
                if( $debug )$this->_write_log( json_encode( $createInfo ) );
                if( isset( $createInfo['status'] ) && $createInfo['status'] == 1 ){
                    //方式一：保存到队列里
                    // $this->save_template_message( $createInfo['data'], $inter_id );

                    //方式二：立即发送模版消息
                    $this->save_template_record( $createInfo, $inter_id );
                }
            }
        } catch (Exception $e) {
            $this->_write_log( json_encode( $e->getMessage() ) );
        }
    }

    public function get_notice_openids()
    {
        //放心住下的openid
        return array(
            // 'o9Vbtw5bgFCel1nuSugUG4uVVZ3k', //libinyan
            'o9Vbtw3ELLZaarxtyw5UXV_MexFk', //luguihong
            'o9Vbtw30wn-MHB5TLqac2jJNvha4', //fengzhongcheng
        );
    }

    /*
     * 消费／预约成功发送模版消息
     * usage $AssetCustomerModel->asset_item_id = $asset_item_id; 资产细单id
     * usage $AssetCustomerModel->code = $code; 消费码
     * Usage $model->send_template_by_consume_success( 消费对象, 用户id, 公众号, 业务类型)
    */
    public function send_template_by_consume_or_booking_success( $type, $AssetCustomerModel, $openid, $inter_id, $business, $message='', $is_save=TRUE)
    {
        try{
            $debug = FALSE;
            if( $debug )$this->_write_log( $type.'-->'.json_encode( $AssetCustomerModel ).'-->'.$openid.'-->'.$inter_id.'-->'.$business );
            $templateInfo = $this->get_template_detail_byType( $type, $inter_id );
            if( $templateInfo ){
                $template_id = $templateInfo['template_id'];
                $array = array();

                if( !empty( $message ) ){
                    //给内部人员发送模版消息
                    $array['name'] = $message;
                    $array['consumer_time'] = date( 'Y-m-d H:i:s', time() );
                }else{
                    $assetItemId = $AssetCustomerModel->asset_item_id;
                    $assetItem = $AssetCustomerModel->get_asset_items_by_itemId( $assetItemId, $business, $inter_id );

                    $array['name'] = isset( $assetItem[0]['name'] ) 
                                        ? '订单编号：'.$assetItem[0]['order_id'].'，商品内容［'.$assetItem[0]['name'].'］' 
                                        : NULL;
                    $array['order_id'] = isset( $assetItem[0]['order_id'] ) ? $assetItem[0]['order_id'] : NULL;//用于连接
                    $array['product_id'] = isset( $assetItem[0]['product_id'] ) ? $assetItem[0]['product_id'] : NULL;//用于连接

                    if( $type == self::TEMPLATE_CONSUMER_SUCCESS ){
                        //消费
                        $array['consumer_code'] = $AssetCustomerModel->code;
                        $array['consumer_time'] = date( 'Y-m-d H:i:s', time() );
                    }elseif( $type == self::TEMPLATE_BOOKING_SUCCESS ){
                        //预约
                        $array['reserve_date'] = NULL;//date( 'Y-m-d H:i:s', time() );
                    }
                }

                if( $debug )$this->_write_log(  json_encode( $array ) );
                $sort_array = $this->get_template_send_sort();
                $array['sort'] = $sort_array[$type];
                $createInfo = $this->create_template_message( $openid, $template_id, $type, $array, $inter_id, $business );
                if( $debug )$this->_write_log(  json_encode( $createInfo ) );
                if( isset( $createInfo['status'] ) && $createInfo['status'] == 1 ){
                    
                    if($is_save==TRUE){
                        //方式一：保存到队列里
                        $this->save_template_message( $createInfo['data'], $inter_id );
                        
                        //方式二：立即发送模版消息
                        // $this->save_template_record( $createInfo, $inter_id );
                        
                    } else {
                        $sendResult = $this->send_template( $createInfo['message'], $inter_id );
                    }
                }
            }
        } catch (Exception $e) {
            $this->_write_log( json_encode( $e->getMessage() ) );
        }
    }

    /*
     * 邮寄后台保存快递名称和快递单号成功发送模版消息
     * usage $ConsumerShippingModel->load($shipping_id); //邮寄model
     * usage $ConsumerShippingModel->distributor = $distributor; //快递名称
     * usage $ConsumerShippingModel->tracking_no = $tracking_no; //快递单号
     * usage $ConsumerShippingModel->consumer_id = $consumer_id; //消费ID
     * Usage $model->send_template_by_shipping_success( 邮寄对象, 用户id, 公众号, 业务类型)
    */
    public function send_template_by_shipping_success( $ConsumerShippingModel, $openid, $inter_id, $business)
    {
        try{


            $debug = FALSE;
            if( $debug )$this->_write_log( json_encode( $ConsumerShippingModel ).'-->'.$openid.'-->'.$inter_id.'-->'.$business );
            $type = self::TEMPLATE_SHIPPING_SHIPPED;// 邮寄
            $templateInfo = $this->get_template_detail_byType( $type, $inter_id );
            if( $templateInfo ){
                $template_id = $templateInfo['template_id'];
                $array = array();

                $this->load->model('soma/Consumer_item_'.$business.'_model','ConsumerItemModel');
                $table_name = $this->ConsumerItemModel->table_name($business, $inter_id);
                $consumer_id = $ConsumerShippingModel->consumer_id;
                $items = $this->ConsumerItemModel->get_order_items_byIds($consumer_id,$business,$inter_id);

                //配送商
                $distributor_name = $ConsumerShippingModel->get_label_byname( $ConsumerShippingModel->distributor );

                $name = NULL;
                if( isset( $items[0]['name'] ) && !empty( $items[0]['name'] ) ){
                    $name = $items[0]['name'];
                }

                $productId = NULL;
                if( isset( $items[0]['product_id'] ) && !empty( $items[0]['product_id'] ) ){
                    $productId = $items[0]['product_id'];
                }

                $array['name'] = '订单编号：'.$ConsumerShippingModel->m_get('order_id').'，商品内容［'.$name.'］';//要到消费单里取
                $array['distributor'] = $distributor_name['dist_label'];
                $array['tracking_no'] = $ConsumerShippingModel->tracking_no;
                $array['address'] = $ConsumerShippingModel->m_get('address');
                $array['order_id'] = $ConsumerShippingModel->m_get('order_id');
                $array['product_id'] = $productId;

                if( $debug )$this->_write_log( json_encode( $array ) );
                $sort_array = $this->get_template_send_sort();
                $array['sort'] = $sort_array[$type];
                $createInfo = $this->create_template_message( $openid, $template_id, $type, $array, $inter_id, $business );
                if( $debug )$this->_write_log( json_encode( $createInfo ) );
                if( isset( $createInfo['status'] ) && $createInfo['status'] == 1 ){
                    //方式一：保存到队列里
                    $this->save_template_message( $createInfo['data'], $inter_id );

                    //方式二：立即发送模版消息
                    // $this->save_template_record( $createInfo, $inter_id );
                }
            }
        } catch (Exception $e) {
            $this->_write_log( json_encode( $e->getMessage() ) );
        }
    }

    /*
     * 礼物领取/礼物退回
     * usage $GiftOrderModel->load($gift_id); //giftmodel
     * usage $GiftModel->nickname; //领取人昵称(领取的时候需要)
     * Usage $model->send_template_by_gift_success( gift对象, 公众号, 业务类型)
    */
    public function send_template_by_gift_success( $type, $GiftOrderModel, $openid, $inter_id, $business)
    {
        try{


            $debug = FALSE;
            if( $debug )$this->_write_log( $type .'-->'. json_encode( $GiftOrderModel ).'-->'.$openid.'-->'.$inter_id.'-->'.$business );
            $templateInfo = $this->get_template_detail_byType( $type, $inter_id );
            if( $templateInfo ){
                $template_id = $templateInfo['template_id'];
                $array = array();

                if( $type == self::TEMPLATE_GIFT_RECEIVED ){
                    //被领取
                    $gift_requirement= $GiftOrderModel->get_requirement($business, $inter_id);  //array( asset_item_id=>qty_require )
                    $this->load->model('soma/Asset_item_package_model', 'assetItemModel');
                    $items= $this->assetItemModel->get_order_items_byItemids( array_keys($gift_requirement), $business, $inter_id);

                    $array['username'] = $GiftOrderModel->nickname;// 礼物领取人
                    $array['name'] = isset( $items[0]['name'] ) ? $items[0]['name'] : NULL;// 礼物名称
                    $array['time'] = date( 'Y-m-d H:i:s', time() );// 领取时间
                }elseif( $type == self::TEMPLATE_GIFT_RETURN ){
                    //退回
                    $items = $GiftOrderModel->get_order_items( $business, $inter_id );
                    $array['name'] = isset( $items[0]['name'] ) ? $items[0]['name'] : NULL;
                    $array['return_time'] = date( 'Y-m-d H:i:s', time() );
                }

                $is_p2p = '';
                if( $GiftOrderModel->m_get('is_p2p') == Soma_base::STATUS_FALSE ){
                    $is_p2p = '群发';
                }
                $array['name'] .= '(赠送编号：' . $GiftOrderModel->m_get('gift_id') . ') ' . $is_p2p;
                $array['order_id'] = isset( $items[0]['order_id'] ) ? $items[0]['order_id'] : NULL;
                $array['product_id'] = isset( $items[0]['product_id'] ) ? $items[0]['product_id'] : NULL;

                if( $debug )$this->_write_log( $template_id.'-->'.json_encode( $array ) );
                $sort_array = $this->get_template_send_sort();
                $array['sort'] = $sort_array[$type];
                $createInfo = $this->create_template_message( $openid, $template_id, $type, $array, $inter_id, $business );
                if( $debug )$this->_write_log( json_encode( $createInfo ) );
                if( isset( $createInfo['status'] ) && $createInfo['status'] == 1 ){
                    //方式一：保存到队列里
                    $this->save_template_message( $createInfo['data'], $inter_id );

                    //方式二：立即发送模版消息
                    // $this->save_template_record( $createInfo, $inter_id );
                }
            }
        } catch (Exception $e) {
            $this->_write_log( json_encode( $e->getMessage() ) );
        }
    }

    /**
     * 计划任务，套票快过期的时候发送模版消息
     * @author luguihong@mofly.cn
     */
    public function create_message_wxtemp( $limit=100, $inter_id=NULL )
    {
        try{
            //一日扫描一次
            $debug = FALSE;
            $business = 'package';

            $this->load->model('soma/Asset_item_package_model','AssetItemModel');
            $AssetItemModel = $this->AssetItemModel;
            $asset_item_table_name = $AssetItemModel->table_name( $business, $inter_id );

            $filter = array();
            $filter['inter_id'] = $inter_id;

            $time = date( 'Y-m-d H:i:s', time() );
            $expireTime = date( 'Y-m-d H:i:s', time() + 15*24*60*60 );//现在的时间加上15天就是>=过期时间，发送模版消息是在过期前15开始发送，只发送一条
            
            $list = $this->_shard_db_r('iwide_soma_r')
                            ->where( $filter )
                            ->where( 'qty >= ', 1 )
                            ->where( 'expiration_date <= ', $expireTime )
                            ->where( 'expiration_date > ', $time )
                            ->where( '(send_wxtemp_status is NULL or send_wxtemp_status = 2)' )
                            ->limit( $limit )
                            ->get( $asset_item_table_name )
                            ->result_array();
            if( $debug )$this->_write_log( $inter_id . json_encode( $list ) );
    //SELECT * FROM `iwide_soma_asset_item_package_1001` WHERE `inter_id` = 'a450089706' AND `qty` >'0' AND `expiration_date` <= '2016-06-15 10:20:05' AND `expiration_date` > '2016-05-31 10:20:05' AND (`send_wxtemp_status`=2 or `send_wxtemp_status` is NULL) LIMIT 100
    // var_dump( $list );return false;

            if( $list ){
                foreach ($list as $k => $v) {
                    //套票到期
                    /***********************发送模版消息****************************/
                    $openid = $v['openid'];//发送给那个用户
                    $type = self::TEMPLATE_PACKAGE_EXPIRE;//套票到期
                    $templateInfo = $this->get_template_detail_byType( $type, $inter_id );
                    if( $templateInfo ){
                        $template_id = $templateInfo['template_id'];
                        $array = array();

                        if( empty( $v['gift_id'] ) ){
                            $array['order_id']      = $v['order_id'];//组装链接时使用
                            $array['order_id_str']  = '订单编号：'.$v['order_id'].'，购买的商品［'.$v['name'].'］，';
                        }else{
                            $array['order_id_str']  = '赠送编号：'.$v['gift_id'].'，收到的礼物［'.$v['name'].'］，';
                        }
                        $array['create_time'] = date('Y-m-d H:i:s');//创建时间
                        $array['expire_time'] = $v['expiration_date'];//过期时间

                        $sort_array = $this->get_template_send_sort();
                        $array['sort'] = $sort_array[$type];
                        $createInfo = $this->create_template_message( $openid, $template_id, $type, $array, $inter_id, $business );
                        if( $debug )$this->_write_log( json_encode( $createInfo ) );
                        if( isset( $createInfo['status'] ) && $createInfo['status'] == 1 ){
                            //方式一：保存到队列里
                            // $this->save_template_message( $createInfo['data'], $inter_id );

                            //方式二：立即发送模版消息
                            $result = $this->save_template_record( $createInfo, $inter_id );
                            if( $debug )$this->_write_log( json_encode( $result ) );
                            
                            $data = array();
                            if( $result ){
                                $data['send_wxtemp_status'] = 1;
                            }else{
                                $data['send_wxtemp_status'] = 1;//不管发送是否成功，都标记为发送，发送失败的会记录在queue表里，下次会再次发送
                                // $data['send_wxtemp_status'] = 2;
                            }
                            
                            $where = array();
                            $where['inter_id'] = $inter_id;
                            $where['item_id'] = $v['item_id'];
                            //修改资产细单模版消息状态
                            $this->_shard_db( $inter_id )
                                    ->where( $where )
                                    ->update( $asset_item_table_name, $data );
                        }
                    }
                    /***********************发送模版消息****************************/
                }
            }
        } catch (Exception $e) {
            $this->_write_log( json_encode( $e->getMessage() ) );
        }
    }

    /**
     * 计划任务，订阅秒杀活动通知
     * @author luguihong@mofly.cn
     */
    public function send_template_by_killsec_subscriber( $inter_id, $sendlist, $interInfo )
    {
        try{
            $debug = FALSE;
            $business = 'package';
            $killsec_table_name = 'soma_activity_killsec_notice';

            /* $filter = array();
            $filter['inter_id'] = $inter_id;
            $filter['status'] = Soma_base::STATUS_TRUE;
            $list = $this->_shard_db( $inter_id )->where( $filter )->limit( $limit )
                            ->get( $killsec_table_name )
                            ->result_array();
            if ( $debug )$this->_write_log( $inter_id . json_encode( $list ) );
            */
            
            $noticeIds = array();
            if( $sendlist ){
                //$this->load->model('wx/Publics_model');
                //$interInfo = $this->Publics_model->get_public_by_id( $inter_id );
                $inter_id_name = isset( $interInfo['name'] ) && !empty( $interInfo['name'] ) ? $interInfo['name'] : $inter_id;
                
                foreach ($sendlist as $k => $v) {
                    $act_id = $v['act_id'];

                    $serviceName = 'soma/Kill_Service';
                    $serviceAlias = 'soma_kill_service';
                    $this->load->service($serviceName, null, $serviceAlias);

                    $this->kill_group_url = '';
                    if ($this->soma_kill_service->groupProductHasKill($act_id) ){
                        $this->kill_group_url = 'soma_killsec_group'; //抢尾房链接地址
                    }

                    //订阅秒杀活动通知
                    /***********************发送模版消息****************************/
                    $openid = $v['openid'];//发送给那个用户
                    $type = self::TEMPLATE_KILLSEC_SUBSCRIBER;//订阅秒杀活动通知
                    $templateInfo = $this->get_template_detail_byType( $type, $inter_id );
                    if( $templateInfo ){
                        $template_id = $templateInfo['template_id'];
                        $array = array();

                        $array['name'] = $v['product_name']. '(秒杀商品)';
                        $array['time'] = $v['killsec_time'];
                        $array['address'] = $inter_id_name;
                        $array['money'] = '￥'. $v['killsec_price']. '(秒杀价)';
                        $array['product_id'] = $v['product_id'];

                        $sort_array = $this->get_template_send_sort();
                        $array['sort'] = $sort_array[$type];
                        $createInfo = $this->create_template_message( $openid, $template_id, $type, $array, $inter_id, $business );
                        if( $debug )$this->_write_log( json_encode( $createInfo ) );
                        if( isset( $createInfo['status'] ) && $createInfo['status'] == 1 ){
                            //方式一：保存到队列里
                            // $this->save_template_message( $createInfo['data'], $inter_id );

                            //方式二：立即发送模版消息
                            $result = $this->save_template_record( $createInfo, $inter_id );
                            if( $debug )$this->_write_log( json_encode( $result ) );
                            
                            //不管发送是否成功，都标记为发送，发送失败的会记录在queue表里，下次会再次发送
                            $noticeIds[] = $v['notice_id'];
                        }
                    }
                    /***********************发送模版消息****************************/
                }
            }
            return $noticeIds;

            /* //修改状态迁移到killsec model
            if( count( $noticeIds ) > 0 ){
                $data = array();
                $data['status'] = Soma_base::STATUS_FALSE;

                $where = array();
                $where['inter_id'] = $inter_id;

                //修改资产细单模版消息状态
                $this->_shard_db( $inter_id )
                        ->where_in( 'notice_id', $noticeIds )
                        ->where( $where )
                        ->update( $killsec_table_name, $data );
            } */

        } catch (Exception $e) {
            $this->_write_log( json_encode( $e->getMessage() ) );
        }
    }

    /**
     * 获取新订单微信通知模板消息键值映射 keyword1 应该取信息的那个值（order_id）
     *
     * @return     array  新订单微信通知模板消息键值映射数组
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getOrderAdminNoticeMessageFieldMapping()
    {
        return array(
            'backendNewOrderID'            => array('key' => 'keyword1', 'field' => 'order_id'),
            'backendNewOrderDetail'        => array('key' => 'keyword2', 'field' => 'item_name'),
            'backendNewOrderGrandTotal'    => array('key' => 'keyword3', 'field' => 'grand_total'),
            'backendNewOrderContact'       => array('key' => 'keyword4', 'field' => 'contact'),
            'backendNewOrderPaymentMethod' => array('key' => 'keyword5', 'field' => 'settlement'),
        );
    }

    /**
     * 获取新订单微信通知模板消息
     *
     * @param      string          $order_id  订单号
     *
     * @return     string|boolean  创建成功返回订单通知模板消息json字符串，失败返回false.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getOrderAdminNoticeMessage($order_id)
    {
        $this->load->model('soma/sales_order_model');
        if ($order = $this->sales_order_model->load($order_id)) {
            $inter_id            = $order->m_get('inter_id');
            $settlements         = $order->get_settle_label();
            $data['order_id']    = $order->m_get('order_id');
            $data['item_name']   = $order->m_get('item_name');
            $data['grand_total'] = $order->m_get('grand_total');
            $data['contact']     = $order->m_get('contact') . '(' . $order->m_get('mobile') . ')';
            $data['settlement']  = $settlements[ $order->m_get('settlement') ];

            $templateInfo = $this->get_template_detail_byType(self::TEMPLATE_BACKEND_NEW_ORDER, $inter_id);
            if($templateInfo) {
                $message = $this->create_template_message(
                    'admin',
                    $templateInfo['template_id'],
                    self::TEMPLATE_BACKEND_NEW_ORDER,
                    $data,
                    $inter_id
                );
                if (isset($message['status']) && $message['status'] == 1) {
                    return $message['message'];
                }
            }
        }
        return false;
    }

    /**
     * 获取新退款请求微信通知模板消息键值映射
     *
     * @return     array  新退款请求微信通知模板消息键值映射数组
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getRefundAdminNoticeMessageFieldMapping()
    {
        return array(
            'backendNewRefundOrderId'    => array('key' => 'keyword1', 'field' => 'order_id'),
            'backendNewRefundGrandTotal' => array('key' => 'keyword2', 'field' => 'refund_total'),
            'backendNewRefundReson'      => array('key' => 'keyword3', 'field' => 'refund_cause'),
        );
    }

    /**
     * 获取新退款请求微信通知模板消息
     *
     * @param      string          $refund_id  The refund identifier
     *
     * @return     string|boolean  创建成功返回退款申请通知模板消息json字符串，失败返回false.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getRefundAdminNoticeMessage($refund_id)
    {
        $this->load->model('soma/sales_refund_model');
        if ($refund = $this->sales_refund_model->load($refund_id)) {
            $inter_id             = $refund->m_get('inter_id');
            $data['order_id']     = $refund->m_get('order_id');
            $data['refund_total'] = $refund->m_get('refund_total');
            $data['refund_cause'] = $refund->m_get('refund_cause');

            $templateInfo = $this->get_template_detail_byType(self::TEMPLATE_BACKEND_NEW_REFUND, $inter_id);
            if ($templateInfo) {
                $message = $this->create_template_message(
                    'admin',
                    $templateInfo['template_id'],
                    self::TEMPLATE_BACKEND_NEW_REFUND,
                    $data,
                    $inter_id
                );
                if (isset($message['status']) && $message['status'] == 1) {
                    return $message['msg'];
                }
            }
        }
        return false;
    }

    /**
     * 获取新邮寄订单微信通知模板消息键值映射
     *
     * @return     array  新邮寄订单微信通知模板消息键值映射数组
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getShipAdminNoticeMessageFieldMapping()
    {
        return array(
            'backendNewShippedAssetName'       => array('key' => 'keyword1', 'field' => 'name'),
            'backendNewShippedReceiver'        => array('key' => 'keyword2', 'field' => 'contacts'),
            'backendNewShippedReceiverPhone'   => array('key' => 'keyword3', 'field' => 'phone'),
            'backendNewShippedReceiverAddress' => array('key' => 'keyword4', 'field' => 'address'),
        );
    }

    /**
     * 获取新邮寄订单微信通知模板消息
     *
     * @param      string          $shipping_id  The shipping identifier
     *
     * @return     string|boolean  创建成功返回邮寄申请通知模板消息json字符串，失败返回false.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getShipAdminNoticeMessage($shipping_id)
    {
        $this->load->model('soma/consumer_shipping_model');
        if ($shipping = $this->consumer_shipping_model->load($shipping_id)) {
            $inter_id         = $shipping->m_get('inter_id');
            $data['name']     = $shipping->m_get('name');
            $data['contacts'] = $shipping->m_get('contacts');
            $data['phone']    = $shipping->m_get('phone');
            $data['address']  = $shipping->m_get('address');

            $templateInfo = $this->get_template_detail_byType(self::TEMPLATE_BACKEND_NEW_SHIPPED, $inter_id);
            if ($templateInfo) {
                $message = $this->create_template_message(
                    'admin',
                    $templateInfo['template_id'],
                    self::TEMPLATE_BACKEND_NEW_SHIPPED,
                    $data,
                    $inter_id
                );
                if (isset($message['status']) && $message['status'] == 1) {
                    return $message['msg'];
                }
            }
        }
        return false;
    }

}