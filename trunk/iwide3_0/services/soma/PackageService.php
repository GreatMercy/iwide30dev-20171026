<?php

namespace App\services\soma;

use App\services\BaseService;
use Api_member;

/**
 * Class PackageService
 * @package App\services\soma
 *
 */
class PackageService extends BaseService
{

    /**
     *
     * @return PackageService
     * @author renshuai  <renshuai@jperation.cn>
     */
    public static function getInstance()
    {
        return self::init(self::class);
    }


    /**
     * 获取套票列表
     * @param array $params
     * @return array
     * @author liguanglong  <liguanglong@mofly.cn>
     */
    public function index($params = []){

        //查看权限
        $inter_id = $this->getCI()->session->get_admin_inter_id();
        if($inter_id != FULL_ACCESS){
            $params['inter_id'] = $inter_id ? $inter_id : 'deny';
        }
        $hotel_ids = $this->getCI()->session->get_admin_hotels();
        if($hotel_ids){
            $params['hotel_id'] = $hotel_ids;
        }
        $hotel_ids= $this->getCI()->session->get_admin_hotels();
        $params['hotel_id'] = $hotel_ids ? explode(',', $hotel_ids) : array();

        $this->getCI()->load->model('soma/product_package_model', 'productPackageModel');
        return $this->getCI()->productPackageModel->getProductsList($params);
    }


    /**
     * 获取套票分类
     * @param $inter_id
     * @return mixed
     * @author liguanglong  <liguanglong@mofly.cn>
     */
    public function getCatalog($inter_id){

        $this->getCI()->load->model('soma/category_package_model', 'CategoryPackageModel');
        $categoryPackageModel = $this->getCI()->CategoryPackageModel;
        return $categoryPackageModel->getCatalog($inter_id);
    }


    /**
     * 判断当前用户是否为分销员或者是泛分销
     * @param $inter_id
     * @param $openid
     * @return array
     * @author luguihong  <luguihong@jperation.com>
     */
    public function getUserSalerOrFansaler($inter_id, $openid)
    {
        $this->getCI()->load->library('Soma/Api_idistribute');
        $staff = $this->getCI()->api_idistribute->get_saler_info($inter_id, $openid);
        if($staff)
        {
            //判断是分销员还是泛分销 $staff['typ'] ＝ 'STAFF'(分销员), 'FANS'(泛分销)
            $saler_type     = isset($staff['typ']) && ! empty($staff['typ']) ? $staff['typ'] : '';
            $saler_id       = isset($staff['info']['saler']) && ! empty($staff['info']['saler']) ? $staff['info']['saler'] : 0;
            if ($saler_id && $saler_type)
            {
                //分销员名称
                $saler_name     = isset($staff['info']['name']) && ! empty($staff['info']['name']) ? $staff['info']['name'] : '';

                //返回分销员信息
                $salesArr = array(
                    'saler_id'      => $saler_id,
                    'saler_type'    => $saler_type,
                    'saler_name'    => $saler_name,
                );

                return $salesArr;
            }
        }

        return array();
    }


    /**
     * 集中不同类型商品相关信息
     * @param array $products
     * @param $interId
     * @param $openId
     * @return array
     * @author liguanglong  <liguanglong@mofly.cn>
     */
    public function composePackage($products = [], $interId, $openId){

        if(is_array($products) && !empty($products)){

            //给商品追加用户对应的专属价格
            ScopeDiscountService::getInstance()->appendScopeDiscount($products, $interId, $openId, false);

            //实例化
            $this->getCI()->load->model('soma/product_package_model', 'productPackageModel');
            $productModel = $this->getCI()->productPackageModel;

            foreach($products as $key => &$val){

                //去掉名称的标签
                $val['name'] = strip_tags($val['name']);

                //秒杀
                $killsec = KillsecService::getInstance()->getInfo($val['product_id']);
                if(!empty($killsec)){
                    $val['price_market'] = $val['price_package'];
                    $val['price_package'] = $killsec['killsec_price'];
                }
                //如果是积分商品，去掉小数点，向上取整
                if($val['type'] == $productModel::PRODUCT_TYPE_POINT) {
                    $val['price_package'] = ceil($val['price_package']);
                    $val['price_market'] = ceil($val['price_market']);
                    if($killsec) {
                        $val['price_package'] = ceil($killsec['killsec_price']);
                    }
                }
                //专属价
                if(!empty($val['scopes'])){
                    $val['price_package'] = $val['scopes'][0]['price'];
                }

                //商品类型 标签 返回值 1：专属 2：秒杀 3：拼团 4：满减 5：组合 6：储值 7：积分
                $val['tag'] = 0;
                if($val['goods_type'] == $productModel::SPEC_TYPE_COMBINE) {
                    //组合标签
                    $val['tag'] = $productModel::PRODUCT_TAG_COMBINED;
                } else {
                    if($val['type'] == $productModel::PRODUCT_TYPE_BALANCE) {
                        //储值标签
                        $val['tag'] = $productModel::PRODUCT_TAG_BALANCE;
                    }
                    if($val['type'] == $productModel::PRODUCT_TYPE_POINT) {
                        //积分标签
                        $val['tag'] = $productModel::PRODUCT_TAG_POINT;
                    }
                }
                if(!empty($val['auto_rule'])){
                    //满减
                    $val['tag'] = $productModel::PRODUCT_TAG_REDUCED;
                }
                if(!empty($killsec)){
                    //秒杀标签
                    $val['tag'] = $productModel::PRODUCT_TAG_KILLSEC;
                }
                if(!empty($val['scopes'])){
                    //专属标签
                    $val['tag'] = $productModel::PRODUCT_TAG_EXCLUSIVE;
                }
                //todo 拼团

                //商品有效期
                $val['is_expire'] = false;
                if($val['goods_type'] != $productModel::SPEC_TYPE_TICKET && $val['date_type'] == $productModel::DATE_TYPE_STATIC) {
                    $time = time();
                    $expireTime = isset($val['expiration_date']) ? strtotime($val['expiration_date']) : null;
                    if($expireTime && $expireTime < $time) {
                        $val['is_expire'] = true;
                    }
                }
            }
        }

        return $products;
    }


    /**
     * 根据产品id和规格类型获取规格信息列表
     * @param $interId
     * @param $productId
     * @param $type
     * @return mixed
     * @author luguihong  <luguihong@mofly.cn>
     */
    public function getSettingInfoByProductId($interId, $productId, $type){
        $this->getCI()->load->model('soma/Product_specification_setting_model', 'productSpecificationSettingModel');
        return $this->getCI()->productSpecificationSettingModel->get_full_specification_compose($interId, $productId, $type);
    }


    /**
     * 获取产品规格信息
     * @param $interId
     * @param $productId
     * @param $psp_sid
     * @return array
     * @author luguihong  <luguihong@mofly.cn>
     */
    public function getSettingInfoByProductIdAndPspSid($interId, $productId, $psp_sid)
    {
        $setting = [];
        $this->getCI()->load->model('soma/Product_specification_setting_model', 'pspModel');
        $psp_setting = $this->getCI()->pspModel->get_specification_compose($interId, $productId, $psp_sid);
        if (!empty($psp_setting)){
            $setting = array_values($psp_setting);
        }
        return $setting;
    }



    /**
     * 获取推荐位商品
     * @param $page
     * @param $page_size
     * @param $uri
     * @param $inter_id
     * @author daikanwu <daikanwu@jperation.com>
     * @return array
     */
    public function getRecommend($page, $page_size, $uri, $inter_id)
    {
        $filter = array('inter_id' => $inter_id);
        $this->getCI()->load->model('soma/Cms_block_model');
        $this->getCI()->load->model('soma/Product_package_model');
        $recommend_products = $this->getCI()->Cms_block_model->show_in_page($uri, $filter,$page_size, $page);
        $pids = $recommend_products['pids'];
        $count = $recommend_products['count'];

        $products = array();
        if ($pids) {
            $select = 'product_id,face_img,name,price_package,price_market,hotel_id,type';
            $products = $this->getCI()->Product_package_model->get_product_package_by_ids($pids, $inter_id,$select);
        }

        // 如果没有配置推荐位产品，抽取产品销量最高的2条显示
        if (empty($products)) {
            $products = $this->getCI()->Product_package_model->getRecommendedProducts($inter_id);
            $tmp = array();
            foreach ($products as $v) {
                $tmp[] = array(
                    'product_id' => $v['product_id'],
                    'face_img' => $v['face_img'],
                    'name' => $v['name'],
                    'price_package' => $v['price_package'],
                    'price_market' => $v['price_market'],
                    'hotel_id' => $v['hotel_id'],
                    'type' => $v['type']
                );
            }
            $products = $tmp;
            $count = 2;
        }

        foreach ($products as &$val) {

            //价格.00去掉
            if (stripos($val['price_market'], '.00') !== false) {
                $val['price_market'] = number_format($val['price_market']);
            }
            if (stripos($val['price_package'], '.00') !== false) {
                $val['price_package'] = number_format($val['price_package']);
            }
            if (isset($val['killsec'])) {
                if (stripos($val['killsec']['killsec_price'], '.00') !== false) {
                    $val['killsec']['killsec_price'] = number_format($val['killsec']['killsec_price']);
                }
            }
        }
        unset($val);

        $res = ['products' => $products, 'count' => $count];
        return $res;

    }


    /**
     * 获取商品促销规则
     * @param $product
     * @param $interId
     * @return array
     * @author liguanglong  <liguanglong@mofly.cn>
     */
    public function getProductAutoRule($product, $interId)
    {

        $auto_rule = [];

        if(empty($product)){

            return $auto_rule;
        }

        $this->getCI()->load->model('soma/product_package_model', 'productPackageModel');
        $productPackageModel = $this->getCI()->productPackageModel;

        if($product['type'] != $productPackageModel::PRODUCT_TYPE_POINT && empty($product['scopes'])) {
            //促销规则加载
            $this->getCI()->load->model('soma/Sales_rule_model', 'salesRuleModel');
            $salesRuleModel = $this->getCI()->salesRuleModel;
            $auto_rule = $salesRuleModel->get_product_rule(array($product['product_id']), $interId, 'auto_rule');
            $auto_rule_new = array();
            if ($auto_rule && count($auto_rule) > 0) {
                foreach ($auto_rule as $v) {
                    $auto_rule_new[] = $v;
                }
            }
            $auto_rule = $auto_rule_new;
        }

        return $auto_rule;
    }


    /**
     * 根据规则id参数确定应该默认买多少份
     * @param $product
     * @param $ruleId
     * @return float|int
     * @author liguanglong  <liguanglong@mofly.cn>
     */
    public function getProductDefaultCount($product, $ruleId)
    {

        $count = 1;

        if(!$product || !$ruleId){
            return $count;
        }

        $this->getCI()->load->model('soma/Sales_rule_model', 'salesRuleModel');
        $salesRuleModel = $this->getCI()->salesRuleModel;

        $fix_rule = $salesRuleModel->find(array('rule_id' => $ruleId));
        if ($fix_rule && $fix_rule['lease_cost'] && $product['price_package']) {
            $fix_qty = $fix_rule['lease_cost'] / $product['price_package'];
            if ($fix_qty < 1) {
                $fix_qty = 1;
            }
            else {
                if ($fix_qty > 1) {
                    $fix_qty = ceil($fix_qty);
                } else {
                    $fix_qty = intval($fix_qty);
                }
            }
            $count = $fix_qty > 200 ? 200 : $fix_qty;
        }

        return $count;
    }



    /**
     * 获取商品优惠券
     * @param $inter_id
     * @param $openid
     * @param $productId
     * @param $count
     * @param $type
     * @return array
     * @author liguanglong  <liguanglong@mofly.cn>
     */
    public function getProductCoupons($inter_id, $openid, $productId, $count, $type){

        $data = [];

        $cardType = $type;
        $pid = $productId;

        if(empty($pid)){
            show_error('Invalid pid supplied', 400);
        }

        $this->getCI()->load->model('soma/Product_package_model');
        $products = $this->getCI()->Product_package_model->get_product_package_by_ids([$pid], $inter_id);
        $subtotal = 0;
        if (!empty($products)) {
            foreach ($products as $k => $v) {
                $subtotal += $v['price_package'] * $count;  //累计订单总额
            }
        }
        else{
            return $data;
        }

        //读取购买人的可用券
        $this->getCI()->load->library('Soma/Api_member');
        $api = new Api_member($inter_id);
        $result = $api->get_token();
        $api->set_token($result['data']);
        $result = $api->conpon_sign_list($openid);

        $card_ids = array();
        if (isset($result['data']) && count($result['data']) > 0) {
            $coupons = array();
            foreach ($result['data'] as $k => $v) {
                if (!in_array($v->card_id, $card_ids)) {
                    $card_ids[] = $v->card_id;
                }
                $result['data'][$k]->discount = number_format($v->discount, 0, '.', ',');
            }

            $this->getCI()->load->model('soma/Sales_order_discount_model');
            $discountModel = $this->getCI()->Sales_order_discount_model;
            $this->getCI()->load->model('soma/Sales_coupon_model');
            $link_all = $this->getCI()->Sales_coupon_model->get_coupon_product_list($card_ids, $inter_id);

            //取出适用所有商品的优惠券，格式：array('card_id'=>'券1',)
            $wide_scope_coupon = $this->getCI()->Sales_coupon_model->get_wide_scope_coupon($inter_id, true);

            foreach ($result['data'] as $k => $v) {
                //逐张优惠券判断是否满足购物条件
                $tmp = (array)$v;

                if (array_key_exists($tmp['card_id'], $wide_scope_coupon)) {
                    if (isset($tmp['least_cost']) && $tmp['least_cost'] > $subtotal) {
                        $tmp['usable'] = false;

                    } else {
                        if (isset($tmp['over_limit']) && $tmp['over_limit'] > 0 && $tmp['over_limit'] < $subtotal) {
                            $tmp['usable'] = false;

                        } else {
                            $tmp['usable'] = true;  //该卡属于宽泛匹配卡id
                        }
                    }
                    $tmp['scopeType'] = '全部商品适用';

                } else {
                    foreach ($link_all as $sk => $sv) {
                        //匹配配置表中的各个配置商品，匹配到为止
                        if (isset($tmp['usable']) && $tmp['usable'] == true) {
                            continue;  //匹配到之后跳出不再循环匹配。
                        }

                        //已经配置了该卡券 && 配置的商品、数量 跟当前购物清单匹配
                        if (isset($tmp['least_cost']) && $tmp['least_cost'] > $subtotal) {
                            $tmp['usable'] = false;

                        } else {
                            if (isset($tmp['over_limit']) && $tmp['over_limit'] > 0 && $tmp['over_limit'] < $subtotal) {
                                $tmp['usable'] = false;

                            } else {
                                if ($sv['card_id'] == $tmp['card_id'] && in_array($sv['product_id'], [$pid]) && $count >= $sv['qty']) {
                                    $tmp['usable'] = true;  //该卡满足配置和数量条件
                                    $tmp['scopeType'] = '部分商品适用';

                                } else {
                                    $tmp['usable'] = false;  //该卡不符合使用条件
                                    $tmp['scopeType'] = '无适用商品';
                                }
                            }
                        }
                    }
                }

                //判断是否到了可用时间
                if (time() < $tmp['use_time_start']) {
                    $tmp['usable'] = false;  //该卡不符合使用条件,没有到使用时间
                }


                //跟会员组了解过, 券的过期时间设置是 2016-11-11 00:00:00，但是实际过期时间是2016-11-11 23:59:59
                $expire_date = date('Y-m-d', $tmp['expire_time']);
                $expire_time = strtotime($expire_date);
                if ($tmp['expire_time'] == $expire_time) {
                    $real_expire_date = $expire_date . ' 23:59:59';
                    $tmp['expire_time'] = strtotime($real_expire_date);
                }

                $minusTime = $tmp['expire_time'] - time();
                if ($minusTime <= 0) {
                    continue;
                } elseif (($minusTime / 86400) <= 10) {
                    $tmp['expire_time'] = str_replace('[0]', ceil($minusTime / 86400), "还有[0]天过期");
                } else {
                    $tmp['expire_time'] = '有效期至'.'：' . date("Y-m-d", $tmp['expire_time']);
                }

                $coupons[] = $tmp;
            }

            //将不可用的券排到最后面
            $can_use_arr = array();
            $can_use_not_arr = array();
            foreach ($coupons as $k => $v) {
                if(isset($v['usable']) && $v['usable'] == true) {
                    $can_use_arr[] = $v;
                    unset($coupons[$k]);
                }
                if(isset($v['usable']) && $v['usable'] == false) {
                    $can_use_not_arr[] = $v;
                    unset($coupons[$k]);
                }
            }
            $coupons = array_merge($can_use_arr, $can_use_not_arr);

            //把优惠券分成抵扣券、兑换券、折扣券
            $dj = array();
            $zk = array();
            $dh = array();
            $cz = array();
            foreach ($coupons as $k => $v) {
                if ($v['card_type'] == $discountModel::TYPE_COUPON_DJ) {
                    //代金券
                    $dj[] = $v;
                } elseif ($v['card_type'] == $discountModel::TYPE_COUPON_ZK) {
                    //折扣券
                    $zk[] = $v;
                } elseif ($v['card_type'] == $discountModel::TYPE_COUPON_DH) {
                    //兑换券
                    $dh[] = $v;
                } elseif ($v['card_type'] == $discountModel::TYPE_COUPON_CZ) {
                    //储值券
                    $cz[] = $v;
                }
            }

            if ($cardType == $discountModel::TYPE_COUPON_DJ) {
                //代金券
                $coupons = $dj;
            } elseif ($cardType == $discountModel::TYPE_COUPON_ZK) {
                //折扣券
                $coupons = $zk;
            } elseif ($cardType == $discountModel::TYPE_COUPON_DH) {
                //兑换券
                $coupons = $dh;
            } elseif ($cardType == $discountModel::TYPE_COUPON_CZ) {
                //储值券
                $coupons = $cz;
            }

            $data = $coupons;
        }

        return $data;
    }
}