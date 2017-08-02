<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaRewardRule"))
 */
class SomaRewardRule
{
    /**
     * @SWG\Property(type="string", description="id")
     * @var string $rule_id
     */
    public $rule_id;

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
     * @SWG\Property(type="string",  description="规则名称")
     * @var string $name
     */
    public $name;

    /**
     * @SWG\Property(enum={"default", "groupon"}, type="string",  description="购买方式。default：普通购买；groupon：拼团")
     * @var string $rule_type*/

    public $rule_type;

    /**
     * @SWG\Property(type="string",  description="奖励来源")
     * @var string $reward_source*/

    public $reward_source;


    /**
     * @SWG\Property(enum={1, 2}, type="string",  description="分组标识：1全员，2按组")
     * @var string $group_mode*/

    public $group_mode;

    /**
     * @SWG\Property(type="string",  description="按组计算绩效时，所选的组别信息")
     * @var string $group_compose*/

    public $group_compose;

    /**
     * @SWG\Property(type="string",  description="按比例/固定金额方式")
     * @var string $reward_type*/

    public $reward_type;

    /**
     * @SWG\Property(type="string",  description="具体金额/百分比")
     * @var string $reward_rate*/

    public $reward_rate;

    /**
     * @SWG\Property(type="string",  description="商品id")
     * @var string $product_ids*/

    public $product_ids;
    /**
     * @SWG\Property(type="string",  description="详情页是否显示分销提示：1显示，2不显示")
     * @var string $can_show_hip*/

    public $can_show_hip;

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
     * @SWG\Property(type="string",  description="创建人")
     * @var string $create_admin*/

    public $create_admin;

    /**
     * @SWG\Property(type="string",  description="更新时间")
     * @var string $update_time*/

    public $update_time;

    /**
     * @SWG\Property(type="string",  description="更新人")
     * @var string $update_admin*/

    public $update_admin;

    /**
     * @SWG\Property(type="string",  description="排序")
     * @var string $sort*/

    public $sort;

    /**
     * @SWG\Property(enum={1, 2}, type="string",  description="状态")
     * @var string $status*/

    public $status;
}