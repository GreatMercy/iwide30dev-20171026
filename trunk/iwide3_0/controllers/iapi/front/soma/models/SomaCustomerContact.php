<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaCustomerContact"))
 */
class SomaCustomerContact
{
    /**
     * @SWG\Property(type="string", description="id")
     * @var string $contact_id
     */
    public $contact_id;

    /**
     * @SWG\Property(type="string",  description="公众号内部id")
     * @var string $inter_id
     */
    public $inter_id;

    /**
     * @SWG\Property(type="string",  description="订单id")
     * @var string $order_id
     */
    public $order_id;

    /**
     * @SWG\Property(type="string",  description="礼物id")
     * @var string $gift_id
     */
    public $gift_id;

    /**
     * @SWG\Property(type="string",  description="openid")
     * @var string $openid*/

    public $openid;

    /**
     * @SWG\Property(type="string",  description="联系人")
     * @var string $name*/

    public $name;

    /**
     * @SWG\Property(type="string",  description="手机号码")
     * @var string $mobile*/

    public $mobile;

    /**
     * @SWG\Property(type="string",  description="创建时间")
     * @var string $create_time*/

    public $create_time;

    /**
     * @SWG\Property(type="string",  description="状态")
     * @var string $status*/

    public $status;

}