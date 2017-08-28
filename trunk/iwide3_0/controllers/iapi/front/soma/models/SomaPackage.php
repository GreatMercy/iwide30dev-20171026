<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaPackage"))
 */
class SomaPackage
{

    //-----------------------------------表字段--------------------------------------


    /**
     * @SWG\Property(type="string")
     * @var string $product_id
     */
    public $product_id;

    /**
     * @SWG\Property(type="string", description="公众号id")
     * @var string $inter_id
     */
    public $inter_id;

    /**
     * @var string $hotel_id
     * @SWG\Property(type="string")
     */
    public $hotel_id;

    /**
     * @var string $language
     * @SWG\Property(type="string", description="中英文标识，1:仅中文，2:中英文")
     */
    public $language;

    /**
     * @var string $cat_id
     * @SWG\Property(type="string", description="分类id")
     */
    public $cat_id;

    /**
     * @var string $type
     * @SWG\Property(type="string", description="商品类型。1.套票类，2.特权券，3.储值商品，4.运费补差，5.积分商品",example="1")
     */
    public $type;

    /**
     * @var string $goods_type
     * @SWG\Property(type="string", description="商品类型。1:通用；2:门票；3:组合", example = "1")
     */
    public $goods_type;

    /**
     * @var string $name
     * @SWG\Property(type="string", description="商品名称")
     */
    public $name;

    /**
     * @var string $sku
     * @SWG\Property(type="string", description="商品SKU")
     */
    public $sku;

    /**
     * @var string $stock
     * @SWG\Property(type="string", description="库存")
     */
    public $stock;

    /**
     * @var string $conn_devices
     * @SWG\Property(type="string", description="是否对接核销设备。1.不对接，2.对接智游宝 默认为1")
     */
    public $conn_devices;

    /**
     * @var string $price_market
     * @SWG\Property(type="string", description="市场价", example="0.01")
     */
    public $price_market;

    /**
     * @var string $price_package
     * @SWG\Property(type="string",description="微信价")
     */
    public $price_package;

    /**
     * @var string $is_hide
     * @SWG\Property(type="string", description="首页是否显示1:显示，2:不显示")
     */
    public $is_hide;

    /**
     * @var string $sort
     * @SWG\Property(type="string", description="排序，越大排前")
     */
    public $sort;

    /**
     * @var string $date_type
     * @SWG\Property(type="string", description="失效模式：1.固定失效时间，2.存活时间(自购买起存活天数)")
     */
    public $date_type;

    /**
     * @var string $validity_date
     * @SWG\Property(type="string",description="上架时间")
     */
    public $validity_date;

    /**
     * @var string $status
     * @SWG\Property(type="string", description="状态：1上架，2禁止，3下架")
     */
    public $status;

    /**
     * @var string $face_img
     * @SWG\Property(type="string", description="封面图")
     */
    public $face_img;

    /**
     * @var string $sales_cnt
     * @SWG\Property(type="string", description="已销售数量")
     */
    public $sales_cnt;

    /**
     * @var string $product_url
     * @SWG\Property(type="string", description="商品链接")
     */
    public $product_url;

    /**
     * @var string $expiration_date
     * @SWG\Property(type="string", description="过期时间")
     */
    public $expiration_date;

    /**
     * @var int $product_type
     * @SWG\Property(enum={1, 2}, type="integer", description="商品类型 用于鉴别BUTTON 返回值 1：立即购买, 2：去秒杀 秒杀开始前10分钟以前button变成 订阅提醒")
     */
    public $product_type;

    /**
     * @var int $tag
     * @SWG\Property(enum={1, 2, 3, 4, 5, 6, 7}, type="integer", description="标签 返回值 1：专属 2：秒杀 3：拼团 4：满减 5：组合 6：储值 7：积分")
     */
    public $tag;

    /**
     * @var SomaKillsec
     * @SWG\Property(@SWG\Xml(name="killsec", wrapped=true))
     */
    public $killsec;


    /**
     * @var SomaGallery[]
     * @SWG\Property(@SWG\Xml(name="gallery", wrapped=true))
     */
    public $gallery;


    /**
     * @var string $is_expire
     * @SWG\Property(type="string", description="商品是否过期")
     */
    public $is_expire;

    /**
     * @var SomaSalesBaseRule[]
     * @SWG\Property(@SWG\Xml(name="auto_rule", wrapped=true))
     */
    public $auto_rule;

    /**
     * @var string $spec_product
     * @SWG\Property(type="string", description="是否为多规格商品")
     */
    public $spec_product;

    /**
     * @var SomaProductSpecification[]
     * @SWG\Property(@SWG\Xml(name="psp_summary", wrapped=true))
     */
    public $psp_summary;

    /**
     * @var SomaProductSpecificationSetting[]
     * @SWG\Property(@SWG\Xml(name="psp_setting", wrapped=true))
     */
    public $psp_setting;

    /**
     * @var array $saler_info todo: iwide_hotel_staff
     * @SWG\Property(type="array", description="自身分销员信息")
     */
    public $saler_info;

    /**
     * @var SomaRewardRule[]
     * @SWG\Property(@SWG\Xml(name="effective_rule", wrapped=true))
     */
    public $effective_rule;

    /**
     * @var SomaActivityGroupon[]
     * @SWG\Property(@SWG\Xml(name="groupons", wrapped=true))
     */
    public $groupons;

    /**
     * @var string $finish_killsec
     * @SWG\Property(type="string", description="秒杀是否完成")
     */
    public $finish_killsec;

    
    /**
     * @var string $ticketId
     * @SWG\Property(type="string", description="多店铺id")
     */
    public $ticketId;

    /**
     * @var string $isTicket
     * @SWG\Property(type="string", description="是否有门票")
     */
    public $isTicket;

    /**
     * @var string $bType
     * @SWG\Property(type="string", description="？？")
     */
    public $bType;

    /**
     * @var array $theme
     * @SWG\Property(type="array", description="设置皮肤信息")
     */
    public $theme;

    /**
     * @var SomaCustomerContact
     * @SWG\Property(@SWG\Xml(name="customercontact", wrapped=true))
     */
    public $customercontact;

    /**
     * @var string $can_split_use
     * @SWG\Property(type="string", description="能否分时使用：1能，2不能")
     */
    public $can_split_use;

    /**
     * @var string $can_wx_booking
     * @SWG\Property(type="string", description="是否可以微信订房：1可2不可")
     */
    public $can_wx_booking;

    /**
     * @var string $can_refund
     * @SWG\Property(type="string", description="1：表示7天退款，3：表示随时退款，2：表示不支持退款")
     */
    public $can_refund;

    /**
     * @var string $can_mail
     * @SWG\Property(type="string", description="能否邮寄：1可2不可")
     */
    public $can_mail;

    /**
     * @var string $can_gift
     * @SWG\Property(type="string", description="能否赠送：1可2不可")
     */
    public $can_gift;

    /**
     * @var string $can_pickup
     * @SWG\Property(type="string", description="能否自提：1可2不可")
     */
    public $can_pickup;

    /**
     * @var string $can_sms_notify
     * @SWG\Property(type="string", description="能否短信通知：1可以，2不可以")
     */
    public $can_sms_notify;

    /**
     * @var string $can_invoice
     * @SWG\Property(type="string", description="能否开发票：1可2不可")
     */
    public $can_invoice;

    /**
     * @var string $can_reserve
     * @SWG\Property(type="string", description="能否预约：1可2不可")
     */
    public $can_reserve;

    /**
     * @var string $order_notice
     * @SWG\Property(type="string", description="订购须知")
     */
    public $order_notice;

    /**
     * @var string $img_detail
     * @SWG\Property(type="string", description="图文详情")
     */
    public $img_detail;

    /**
     * @var string $compose
     * @SWG\Property(type="string", description="商品内容")
     */
    public $compose;

    /**
     * @var string $show_sales_cnt
     * @SWG\Property(type="string", description="前端是否显示销售数量：1是；2否")
     */
    public $show_sales_cnt;

    /**
     * @var string $qrcode_detail
     * @SWG\Property(type="string", description="商品二维码")
     */
    public $qrcode_detail;

    /**
     * @var string $reward_money
     * @SWG\Property(type="double", description="商品绩效金额")
     */
    public $reward_money;


}