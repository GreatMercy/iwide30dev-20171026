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
     * @SWG\Property(type="string", description="酒店电话")
     * @var $hotel_tel
     */
    public $hotel_tel;

    /**
     * @SWG\Property(type="string", description="酒店名称")
     * @var $hotel_name
     */
    public $hotel_name;

}