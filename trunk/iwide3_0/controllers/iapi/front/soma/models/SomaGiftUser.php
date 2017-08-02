<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaGift"))
 */
class SomaGiftUser
{

    /**
     * @SWG\Property(type="string",description="用户openid")
     * @var string $openid
     */
    public $openid;

    /**
     * @SWG\Property(type="string",description="领取份数")
     * @var string $get_qty
     */
    public $get_qty;

    /**
     * @SWG\Property(type="string",description="领取时间")
     * @var string $get_time
     */
    public $get_time;

    /**
     * @SWG\Property(type="string",description="用户昵称")
     * @var string $openid_nickname
     */
    public $openid_nickname;

    /**
     * @SWG\Property(type="string",description="用户头像url地址")
     * @var string $openid_headimg
     */
    public $openid_headimg;



}