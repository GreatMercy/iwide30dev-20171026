<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaCustomerCode"))
 */
class SomaCustomerCode
{

    /**
     * @var string $order_id
     * @SWG\Property(type="string", description="订单ID")
     */
    public $order_id;

    /**
     * @var string $code
     * @SWG\Property(type="string", description="卷码")
     */
    public $code;

    /**
     * @var string $status
     * @SWG\Property(enum={1,2,3,4},type="string", description="使用状态, 1 未分配 2 未使用 3 已使用 4 已赠送")
     */
    public $status;

    /**
     * @var string $asset_item_id
     * @SWG\Property(type="string", description="资产细单ID")
     */
    public $asset_item_id;

    /**
     * @var $code_id
     * @SWG\Property(type="string", description="卷码ID")
     */
    public $code_id;

    /**
     * @var $shipping_id
     * @SWG\Property(type="string", description="邮寄ID")
     */
    public $shipping_id;

    /**
     * @var $gid
     * @SWG\Property(type="string", description="礼物ID")
     */
    public $gid;

    /**
     * @var $qrcode_url
     * @SWG\Property(type="string", description="二维码图片链接")
     */
    public $qrcode_url;

    /**
     * @var $use_num
     * @SWG\Property(type="string", description="卷码可使用数量")
     */
    public $use_num;

    /**
     * @var $total_num
     * @SWG\Property(type="string", description="卷码总数量")
     */
    public $total_num;

    /**
     * @var $is_booking_hotel
     * @SWG\Property(type="bool", description="是否已经订房")
     */
    public $is_booking_hotel;
}