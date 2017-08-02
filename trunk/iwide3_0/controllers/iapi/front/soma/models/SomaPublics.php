<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaPublics"))
 */
class SomaPublics
{
    /**
     * @var string $name
     * @SWG\Property(type="string", description="公众号名称")
     */
    public $name;

    /**
     * @var string $public_id
     * @SWG\Property(type="string", description="公众号原始ID")
     */
    public $public_id;

    /**
     * @var string $wechat_name
     * @SWG\Property(type="string", description="微信号")
     */
    public $wechat_name;

    /**
     * @var string $language
     * @SWG\Property(type="string", description="AppID(公众号)")
     */
    public $app_id;

    /**
     * @var string $app_secret
     * @SWG\Property(type="string", description="AppSecret")
     */
    public $app_secret;

    /**
     * @var string $app_type
     * @SWG\Property(enum={1, 2, 3, 4}, type="string", description="微信号类型, 1：服务号 2：认证服务号 3：企业号 4：订阅号")
     */
    public $app_type;

    /**
     * @var string $alipay_id
     * @SWG\Property(type="string", description="")
     */
    public $alipay_id;

    /**
     * @var string $inter_id
     * @SWG\Property(type="string", description="内部ID")
     */
    public $inter_id;

    /**
     * @var string $status
     * @SWG\Property(enum={0, 1, 2}, type="string", description="0:正常，1停用，2:已删除")
     */
    public $status;

    /**
     * @var string $create_time
     * @SWG\Property(type="string", description="创建时间")
     */
    public $create_time;

    /**
     * @var string $del_time
     * @SWG\Property(type="string", description="删除时间")
     */
    public $del_time;

    /**
     * @var string $crypt_type
     * @SWG\Property(enum={0, 1, 2}, type="string", description="消息加密方式, 0：明文模式 1：兼容模式 2：安全模式")
     */
    public $crypt_type;

    /**
     * @var string $aes_key
     * @SWG\Property(type="string", description="AesEncodingKey")
     */
    public $aes_key;

    /**
     * @var string $email
     * @SWG\Property(type="string", description="公众号邮箱")
     */
    public $email;

    /**
     * @var string integer $sort
     * @SWG\Property(type="string", description="头像地址（url）")
     */
    public $logo;

    /**
     * @var string $domain
     * @SWG\Property(type="string", description="公众号域名")
     */
    public $domain;

    /**
     * @var string $is_multy
     * @SWG\Property(enum={1, 2}, type="string",format="date-time", description="1单体酒店，2多酒店")
     */
    public $is_multy;

    /**
     * @var string $follow_page
     * @SWG\Property(type="string", description="引导关注图文URL")
     */
    public $follow_page;

    /**
     * @var string $statis_code
     * @SWG\Property(type="string", description="js统计代码")
     */
    public $statis_code;

    /**
     * @var string $product_url
     * @SWG\Property(type="string", description="")
     */
    public $token;

    /**
     * @var string $white_domains
     * @SWG\Property(type="string", description="")
     */
    public $white_domains;

    /**
     * @var string $is_authed
     * @SWG\Property(enum={1,2}, type="string", description="是否已经第三方授权, 1：未授权 2：已授权")
     */
    public $is_authed;

    /**
     * @var string $auth_time
     * @SWG\Property(type="string", description="授权/取消授权时间")
     */
    public $auth_time;

    /**
     * @var string $auth_code
     * @SWG\Property(type="string", description="授权码")
     */
    public $auth_code;

    /**
     * @var string $auth_expire_time
     * @SWG\Property(type="string", description="授权码过期时间")
     */
    public $auth_expire_time;

    /**
     * @var string $auth_info
     * @SWG\Property(type="string", description="授权信息")
     */
    public $auth_info;

    /**
     * @var string $run_status
     * @SWG\Property(enum={"running", "arrearage", "stop"}, type="string", description="运行状态：正常：running，欠费：arrearage，停服：stop")
     */
    public $run_status;

    /**
     * @var string $arrearage_money
     * @SWG\Property(type="string", description="欠费金额数")
     */
    public $arrearage_money;

    /**
     * @var string $stop_service_time
     * @SWG\Property(type="string", description="停服时间，欠费提示使用")
     */
    public $stop_service_time;

    /**
     * @var string $split_status
     * @SWG\Property(enum={0, 1}, type="string", description="分账状态(1.使用中)")
     */
    public $split_status;

    /**
     * @var string $qrcode
     * @SWG\Property(type="string", description="公众号二维码")
     */
    public $qrcode;


}