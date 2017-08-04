<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaAddress"))
 */
class SomaAddress
{
    /**
     * @SWG\Property(type="string")
     * @var string $address_id
     */
    public $address_id;

    /**
     * @SWG\Property(type="string")
     * @var string $openid
     */
    public $openid;

    /**
     * @SWG\Property(type="string")
     * @var string $hotel_id
     */
    public $hotel_id;

    /**
     * @SWG\Property(type="string")
     * @var string $inter_id
     */
    public $inter_id;

    /**
     * @SWG\Property(type="string")
     * @var string $country
     */
    public $country;

    /**
     * @SWG\Property(type="string",description="省份")
     * @var string $province
     */
    public $province;

    /**
     * @SWG\Property(type="string")
     * @var string $city
     */
    public $city;

    /**
     * @SWG\Property(type="string")
     * @var string $region
     */
    public $region;

    /**
     * @SWG\Property(type="string")
     * @var string $address
     */
    public $address;

    /**
     * @SWG\Property(type="string")
     * @var string $zip_code
     */
    public $zip_code;

    /**
     * @SWG\Property(type="string")
     * @var string $phone
     */
    public $phone;

    /**
     * @SWG\Property(type="string")
     * @var string $contact
     */
    public $contact;

    /**
     * @SWG\Property(type="string")
     * @var string $status
     */
    public $status;

    /**
     * @SWG\Property(type="string")
     * @var string $created_at
     */
    public $created_at;

    /**
     * @SWG\Property(type="string")
     * @var string $updated_at
     */
    public $updated_at;

}