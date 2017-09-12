<?php
/**
 * table iwide_soma_sales_order_item_package_1001
 *
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaSalesOrderItem"))
 */
class SomaSalesOrderItem
{
    /**
     * @SWG\Property(type = "string", description="订单号")
     * @var $item_id
     */
    public $item_id;

    /**
     * @SWG\Property(type = "string", description="购买数量")
     * @var $qty
     */
    public $qty;

    /**
     * @SWG\Property(type="string", description="商品图片")
     * @var string $face_img
     */
    public $face_img;

    /**
     * @SWG\Property(type="string", description="价格")
     * @var $price_package
     */
    public $price_package;

    /**
     * @SWG\Property(type="string", description="门市价")
     * @var $price_market
     */
    public $price_market;

    /**
     * @SWG\Property(type="string", description="秒杀价")
     * @var $price_killsec
     */
    public $price_killsec;

    /**
     * @SWG\Property(type="string", description="结束时间")
     * @var $expiration_date
     */
    public $expiration_date;

    /**
     * @SWG\Property(enum={1, 2},type="string", description="过期状态：1 过期 2 未过期")
     * @var $expiration_date
     */
    public $expiration_status;

    /**
     * @SWG\Property(type="string", description="酒店电话")
     * @var $hotel_tel
     */
    public $hotel_tel;

    /**
     * @SWG\Property(type="string", description="酒店名称")
     * @var $hotel_name
     */
    public $hotel_name;


    /**
     * @var array $compose
     * @SWG\Property(type="array", description="商品内容 {content: '', num: ''}")
     */
    public $compose;

    /**
     * @var string $can_refund
     * @SWG\Property(enum={1, 2, 3}, type="string", description="能否退 1, 7天退款 2, 不能退款 3, 随时退款")
     */
    public $can_refund;

    /**
     * @var string $can_mail
     * @SWG\Property(enum={1, 2}, type="string", description="能否邮寄 1 是 2 否")
     */
    public $can_mail;

    /**
     * @var string $can_gift
     * @SWG\Property(enum={1, 2}, type="string", description="能否赠送 1 是 2 否")
     */
    public $can_gift;

    /**
     * @var string $can_pickup
     * @SWG\Property(enum={1, 2}, type="string", description="能否到店 1 是 2 否")
     */
    public $can_pickup;

    /**
     * @var string $can_invoice
     * @SWG\Property(enum={1, 2}, type="string", description="能否开发票 1 是 2 否")
     */
    public $can_invoice;

    /**
     * @var string $can_reserve
     * @SWG\Property(enum={1,2}, type="string", description="是否可预约 1 是 2 否")
     */
    public $can_reserve;

    /**
     * @var string $can_wx_booking
     * @SWG\Property(enum={1,2}, type="string", description="是否可微信订房 1 是 2 否")
     */
    public $can_wx_booking;

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
     * @var array $wx_booking_config
     * @SWG\Property(type="array", description="微信可订房信息 ,参考 rmid = room_id, cdid = price_code")
     */
    public $wx_booking_config;

}