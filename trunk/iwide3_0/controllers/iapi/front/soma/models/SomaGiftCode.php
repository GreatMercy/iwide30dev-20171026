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
     * @SWG\Property(type="string",description="券码状态：2为不能退款，1为7天退款，3为随时退")
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

}