<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaProductSpecificationSetting"))
 */
class SomaProductSpecificationSetting
{
    /**
     * @SWG\Property(type="string", description="id")
     * @var string $spec_id
     */
    public $setting_id;

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
     * @SWG\Property(enum={1, 2}, type="string",  description="规格类型。1:通用；2:门票")
     * @var string $type
     */
    public $type;

    /**
     * @SWG\Property(type="string",  description="商品id")
     * @var string $product_id
     */
    public $product_id;

    /**
     * @SWG\Property(type="string",  description="规格信息")
     * @var string $setting_spec_compose*/
    public $setting_spec_compose;

    /**
     * @SWG\Property(type="string",  description="规格价格")
     * @var string $spec_price*/

    public $spec_price;

    /**
     * @SWG\Property(type="string",  description="规格库存")
     * @var string $spec_stock*/

    public $spec_stock;

    /**
     * @SWG\Property(type="string",  description="外部SKU")
     * @var string $outter_sku*/

    public $outter_sku;

    /**
     * @SWG\Property(type="string",  description="缩略图")
     * @var string $spec_face_img*/

    public $spec_face_img;
}