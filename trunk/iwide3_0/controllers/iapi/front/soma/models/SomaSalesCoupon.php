<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaSalesCoupon"))
 */
class SomaSalesCoupon
{
    /**
     * @SWG\Property(type="string", description="id")
     * @var string $gry_id
     */
    public $coupon_id;

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
     * @SWG\Property(type="string",  description="优惠券id")
     * @var string $card_id
     */
    public $card_id;

    /**
     * @SWG\Property(type="string",  description="券类型")
     * @var string $card_type*/

    public $card_type;

    /**
     * @SWG\Property(type="string",  description="券名称")
     * @var string $card_name*/

    public $card_name;

    /**
     * @SWG\Property(type="string",  description="创建时间")
     * @var string $create_time*/

    public $create_time;

    /**
     * @SWG\Property(type="string",  description="更新时间")
     * @var string $update_time*/

    public $update_time;

    /**
     * @SWG\Property(enum={1, 2}, type="string",  description="1：不限定商品，2：限定商品")
     * @var string $scope*/

    public $scope;

}