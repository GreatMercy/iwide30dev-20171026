<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaSalesBaseRule"))
 */
class SomaSalesBaseRule
{
    /**
     * @var string $rule_id
     * @SWG\Property(type="string", description="规则id")
     */
    public $rule_id;

    /**
     * @var string $inter_id
     * @SWG\Property(type="string", description="公众号内部id")
     */
    public $inter_id;

    /**
     * @var string $hotel_id
     * @SWG\Property(type="string", description="酒店id")
     */
    public $hotel_id;

    /**
     * @var string $settlement
     * @SWG\Property(enum={"default", "groupon"}, type="string", description="结算类型。普通购买：default，拼团：groupon")
     */
    public $settlement;

    /**
     * @var string $rule_type
     * @SWG\Property(type="string", description="")
     */
    public $rule_type;

    /**
     * @var string $name
     * @SWG\Property(type="string", description="名称（中文）")
     */
    public $name;

    /**
     * @var string $name_en
     * @SWG\Property(type="string", description="名称（英文）")
     */
    public $name_en;

    /**
     * @var string $rule_detail
     * @SWG\Property(type="string", description="规则明细")
     */
    public $rule_detail;

    /**
     * @var string $limit_type
     * @SWG\Property(type="string", description="限制比例方式")
     */
    public $limit_type;

    /**
     * @var string $limit_percent
     * @SWG\Property(type="string", description="限制比例")
     */
    public $limit_percent;

    /**
     * @var string $lease_percent
     * @SWG\Property(type="string", description="使用比例下限")
     */
    public $lease_percent;

    /**
     * @var string $crypt_type
     * @SWG\Property(type="string", description="使用上限")
     */
    public $over_limit;

    /**
     * @var string $lease_cost
     * @SWG\Property(type="string", description="使用下限")
     */
    public $lease_cost;

    /**
     * @var string $reduce_cost
     * @SWG\Property(type="string", description="公众号邮箱")
     */
    public $reduce_cost;

    /**
     * @var string $bonus_size
     * @SWG\Property(type="string", description="1积分等值x元")
     */
    public $bonus_size;

    /**
     * @var string $can_use_coupon
     * @SWG\Property(enum={1, 2}, type="string", description="是否可以使用优惠券")
     */
    public $can_use_coupon;

    /**
     * @var string $can_use_balence
     * @SWG\Property(enum={1, 2}, type="string", description="")
     */
    public $can_use_balence;

    /**
     * @var string $can_use_point
     * @SWG\Property(enum={1, 2}, type="string", description="是否可以使用积分")
     */
    public $can_use_point;

    /**
     * @var string $can_use_reduce
     * @SWG\Property(enum={1, 2}, type="string", description="是否可以使用折扣")
     */
    public $can_use_reduce;

    /**
     * @var string $require_password
     * @SWG\Property(enum={1, 2}, type="string", description="")
     */
    public $require_password;

    /**
     * @var string $start_time
     * @SWG\Property(type="string", description="规则开始时间")
     */
    public $start_time;

    /**
     * @var string $end_time
     * @SWG\Property(type="string", description="规则终止时间")
     */
    public $end_time;

    /**
     * @var string $create_time
     * @SWG\Property(type="string", description="创建时间")
     */
    public $create_time;

    /**
     * @var string $create_admin
     * @SWG\Property(type="string", description="创建人")
     */
    public $create_admin;

    /**
     * @var string $update_time
     * @SWG\Property(type="string", description="更新时间")
     */
    public $update_time;

    /**
     * @var string $update_admin
     * @SWG\Property(type="string", description="更新人")
     */
    public $update_admin;

    /**
     * @var string $modules
     * @SWG\Property(type="string", description="适用模块")
     */
    public $modules;

    /**
     * @var string $scope
     * @SWG\Property(enum={1, 2}, type="string", description="1：不限定商品 2：限定商品")
     */
    public $scope;

    /**
     * @var string $sort
     * @SWG\Property(type="string", description="排序")
     */
    public $sort;

    /**
     * @var string $status
     * @SWG\Property(enum={1, 2}, type="string", description="")
     */
    public $status;
}