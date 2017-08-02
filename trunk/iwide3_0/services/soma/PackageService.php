<?php

namespace App\services\soma;

use App\services\BaseService;

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
            $select = 'product_id,face_img,name,price_package,price_market,hotel_id';
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
                    'hotel_id' => $v['hotel_id']
                );
            }
            $products = $tmp;
            $count = 2;
        }

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
            $auto_rule = $salesRuleModel->get_product_rule(array($productPackageModel['product_id']), $interId, 'auto_rule');
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
        $salesRuleModel = $this->salesRuleModel;

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

}