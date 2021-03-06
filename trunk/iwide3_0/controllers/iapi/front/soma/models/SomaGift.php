<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaGift"))
 */
class SomaGift
{

    /**
     * @SWG\Property(type="string",description="公众号ID")
     * @var string $inter_id
     */
    public $inter_id;

    /**
     * @SWG\Property(type="string",description="物品ID")
     * @var string $item_id
     */
    public $item_id;

    /**
     * @SWG\Property(type="string",description="资产ID")
     * @var string $asset_id
     */
    public $asset_id;

    /**
     * @SWG\Property(type="string",description="订单ID")
     * @var string $item_id
     */
    public $order_id;

    /**
     * @SWG\Property(type="string",description="礼物ID")
     * @var string $gift_id
     */
    public $gift_id;

    /**
     * @SWG\Property(type="string",description="产品ID")
     * @var string $product_id
     */
    public $product_id;

    /**
     * @SWG\Property(type="string",description="当前所属用户的OPENID")
     * @var string $openid
     */
    public $openid;

    /**
     * @SWG\Property(type="string",description="产品名")
     * @var string $name
     */
    public $name;

    /**
     * @SWG\Property(type="string",description="市场价")
     * @var string $price_market
     */
    public $price_market;

    /**
     * @SWG\Property(type="string",description="售价")
     * @var string $price_package
     */
    public $price_package;

    /**
     * @SWG\Property(type="string",description="商品图片")
     * @var string $face_img
     */
    public $face_img;

    /**
     * @SWG\Property(type="string",description="所属酒店")
     * @var string $hotel_name
     */
    public $hotel_name;


    /**
     * @SWG\Property(type="string",description="酒店电话")
     * @var string $item_id
     */
    public $hotel_tel;

    /**
     * @SWG\Property(type="string",description="剩余数量")
     * @var string $qty
     */
    public $qty;

    /**
     * @SWG\Property(type="string",description="有效起始日期")
     * @var string $validity_date
     */
    public $validity_date;


    /**
     * @SWG\Property(type="string",description="失效日期")
     * @var string $expiration_date
     */
    public $expiration_date;


}