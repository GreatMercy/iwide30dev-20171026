<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaAdv"))
 */
class SomaSignCode
{
    /**
     * @SWG\Property(type="string")
     * @var string $appId
     */
    public $appId;

    /**
     * @SWG\Property(type="string")
     * @var string $nonceStr
     */
    public $nonceStr;

    /**
     * @SWG\Property(type="string")
     * @var string $timestamp
     */
    public $timestamp;


    /**
     * @SWG\Property(type="string")
     * @var string $url
     */
    public $url;

    /**
     * @SWG\Property(type="string")
     * @var string $signature
     */
    public $signature;

    /**
     * @SWG\Property(type="string")
     * @var string $rawString
     */
    public $rawString;


}