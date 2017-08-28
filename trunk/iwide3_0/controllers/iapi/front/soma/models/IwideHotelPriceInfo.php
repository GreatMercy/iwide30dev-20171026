<?php

/**
 * table iwide_hotel_price_info
 * @SWG\Definition(type="object", @SWG\Xml(name="IwideHotelPriceInfo"))
 */
class IwideHotelPriceInfo
{
    /**
     * @SWG\Property(type="string", description="房价码信息")
     * @var string $price_name
     */
    public $price_name;

    /**
     * @SWG\Property(type="string", description="房价码")
     * @var string $price_code
     */
    public $price_code;

}