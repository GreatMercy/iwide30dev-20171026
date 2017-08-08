<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaGiftBtn"))
 */
class SomaGiftBtn
{

    /**
     * @SWG\Property(type="string",description="所属类型,reserve:提前预约，mail：邮寄，gift：可以赠送，pickup：可以自提，wx_book：可以微信订房")
     * @var string $type
     */
    public $type;

    /**
     * @SWG\Property(type="string",description="跳转的URL")
     * @var string $url
     */
    public $url;

    /**
     * @SWG\Property(type="string",description="按钮中文标示")
     * @var string $label
     */
    public $label;



}