<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaCustomerAddress"))
 */
class SomaCustomerAddress
{
    /**
     * @SWG\Property(type="string", description="id")
     * @var string $address_id
     */
    public $address_id;

    /**
     * @SWG\Property(type="string",  description="openid")
     * @var string $openid
     */
    public $openid;

    /**
     * @SWG\Property(type="string",  description="酒店id")
     * @var string $hotel_id
     */
    public $hotel_id;

    /**
     * @SWG\Property(type="string",  description="公众号内部id")
     * @var string $inter_id
     */
    public $inter_id;

    /**
     * @SWG\Property(type="string",  description="国")
     * @var string $country*/

    public $country;

    /**
     * @SWG\Property(type="string",  description="省")
     * @var string $province*/

    public $province;

    /**
     * @SWG\Property(type="string",  description="市")
     * @var string $city*/

    public $city;

    /**
     * @SWG\Property(type="string",  description="区")
     * @var string $region*/

    public $region;

    /**
     * @SWG\Property(type="string",  description="详细地址")
     * @var string $address*/

    public $address;

    /**
     * @SWG\Property(type="string",  description="地区编码")
     * @var string $zip_code*/

    public $zip_code;

    /**
     * @SWG\Property(type="string",  description="联系人电话")
     * @var string $phone*/

    public $phone;

    /**
     * @SWG\Property(type="string",  description="联系人姓名")
     * @var string $contact*/

    public $contact;

    /**
     * @SWG\Property(type="string",  description="状态")
     * @var string $status*/

    public $status;

    /**
     * @SWG\Property(type="string",  description="创建时间")
     * @var string $created_at*/

    public $created_at;

    /**
     * @SWG\Property(type="string",  description="修改时间")
     * @var string $updated_at*/

    public $updated_at;


    /**
     * @SWG\Property(type="string",  description="区域名称")
     * @var string $region_name*/

    public $region_name;

    /**
     * @SWG\Property(type="string",  description="区域id")
     * @var string $region_id*/

    public $region_id;

    /**
     * @SWG\Property(type="string",  description="父区域id")
     * @var string $parent_id*/

    public $parent_id;

    /**
     * @SWG\Property(type="array",  description="子区域列表")
     * @var array $children*/

    public $children;
}