<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaGallery"))
 */
class SomaGallery
{
    /**
     * @SWG\Property(type="string", description="id")
     * @var string $gry_id
     */
    public $gry_id;

    /**
     * @SWG\Property(type="string",  description="商品id")
     * @var string $gs_id
     */
    public $gs_id;

    /**
     * @SWG\Property(type="string",  description="相片链接")
     * @var string $gry_url
     */
    public $gry_url;

    /**
     * @SWG\Property(type="string",  description="")
     * @var string $act_name
     */
    public $act_name;

    /**
     * @SWG\Property(type="string",  description="相片描述")
     * @var string $gry_desc*/

    public $gry_desc;

}