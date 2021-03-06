<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaGiftCode"))
 */
class SomaGiftCode
{

    /**
     * @SWG\Property(type="string",description="券码ID")
     * @var string $code_id
     */
    public $code_id;

    /**
     * @SWG\Property(type="string",description="券码状态： 1 未分配 2 未使用 3 已使用 4 已赠送 5 已邮寄")
     * @var string $status
     */
    public $status;

    /**
     * @SWG\Property(type="string",description="券码")
     * @var string $code
     */
    public $code;

    /**
     * @SWG\Property(type="string",description="券码二维码地址")
     * @var string $code
     */
    public $qrcode_url;

    /**
     * @SWG\Property(type="string",description="券码点击后跳转的URL")
     * @var string $btn_url
     */
    public $btn_url;

}