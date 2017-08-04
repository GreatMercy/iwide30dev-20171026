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
}