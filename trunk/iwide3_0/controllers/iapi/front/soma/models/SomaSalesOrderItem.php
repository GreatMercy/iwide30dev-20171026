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

}