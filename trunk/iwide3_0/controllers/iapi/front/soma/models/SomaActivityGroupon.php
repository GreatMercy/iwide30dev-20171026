<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaActivityGroupon"))
 */
class SomaActivityGroupon
{
    /**
     * @SWG\Property(type="string", description="id")
     * @var string $act_id
     */
    public $act_id;

    /**
     * @SWG\Property(type="string",  description="公众号内部id")
     * @var string $inter_id
     */
    public $inter_id;

    /**
     * @SWG\Property(type="string",  description="酒店id")
     * @var string $hotel_id
     */
    public $hotel_id;

    /**
     * @SWG\Property(type="string",  description="活动类型")
     * @var string $act_type
     */
    public $act_type;

    /**
     * @SWG\Property(enum={"default", "groupon"}, type="string",  description="活动名称")
     * @var string $act_name*/

    public $act_name;

    /**
     * @SWG\Property(type="string",  description="活动封面图")
     * @var string $banner_url*/

    public $banner_url;


    /**
     * @SWG\Property(type="string",  description="商品id")
     * @var string $product_id*/

    public $product_id;

    /**
     * @SWG\Property(type="string",  description="商品名称")
     * @var string $product_name*/

    public $product_name;

    /**
     * @SWG\Property(type="string",  description="拼团价")
     * @var string $group_price*/

    public $group_price;

    /**
     * @SWG\Property(type="string",  description="拼团人数")
     * @var string $group_count*/

    public $group_count;

    /**
     * @SWG\Property(type="string",  description="")
     * @var string $group_deadline*/

    public $group_deadline;
    /**
     * @SWG\Property(type="string",  description="")
     * @var string $keyword*/

    public $keyword;

    /**
     * @SWG\Property(type="string",  description="开始时间")
     * @var string $start_time*/

    public $start_time;

    /**
     * @SWG\Property(type="string",  description="终止时间")
     * @var string $end_time*/

    public $end_time;

    /**
     * @SWG\Property(type="string",  description="创建时间")
     * @var string $create_time*/

    public $create_time;

    /**
     * @SWG\Property(enum={1, 2}, type="string",  description="状态")
     * @var string $status*/

    public $status;
}