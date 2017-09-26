<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Package"))
 */
class SomaKillsec
{
    /**
     * @SWG\Property(type="string")
     * @var string $act_id
     */
    public $act_id;

    /**
     * @SWG\Property(type="string",description="")
     * @var string $inter_id
     */
    public $inter_id;

    /**
     * @SWG\Property(type="string",description="")
     * @var string $hotel_id
     */
    public $hotel_id;

    /**
     * @SWG\Property(type="string")
     * @var string $act_name
     */
    public $act_name;

    /**
     * @SWG\Property(type="string", description="秒杀价")
     * @var string $killsec_price
     */
    public $killsec_price;

    /**
     * @SWG\Property(type="string",description="库存")
     * @var string $killsec_count
     */
    public $killsec_count;

    /**
     * @SWG\Property(type="string",description="")
     * @var string $killsec_permax
     */
    public $killsec_permax;

    /**
     * @SWG\Property(type="string",description="1：可用 2：禁用")
     * @var string
     */
    public $status;
    /**
     * @SWG\Property(enum={1, 2},type="integer", description="1:已设置提醒 2:未设置提醒")
     * @var int $subscribe_status
     */
    public $subscribe_status;


    //-----------------------------------自定义--------------------------------------------

    /**
     * @SWG\Property(type="integer", description="已购买数量/总库存")
     * @var int $percent
     */
    public $percent;

    /**
     * @SWG\Property(type="integer", description="已购买数量")
     * @var int $subscribe_status
     */
    public $stock;

    /**
     * @SWG\Property(type="integer", description="总库存")
     * @var int $subscribe_status
     */
    public $total;

    /**
     * @SWG\Property(type="integer", description="调用秒杀商品库存api间隔，单位：毫秒")
     * @var int $stock_reflesh_rate
     */
    public $stock_reflesh_rate;

    /**
     * @SWG\Property(type="string", description="是否显示库存。0：不显示，1：显示")
     * @var string $is_stock
     */
    public $is_stock;

}