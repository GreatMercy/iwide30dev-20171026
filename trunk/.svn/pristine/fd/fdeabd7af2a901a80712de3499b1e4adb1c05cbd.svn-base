<?php

namespace App\services\soma\order;

use App\services\Result;
use Soma_base;


/**
 * Class Order
 * @package App\services\soma\order
 * @author renshuai  <renshuai@mofly.cn>
 *
 */
abstract class AbstractOrder
{
    /**
     * @var \MY_Front_Soma $CI
     */
    static private $CI;

    /**
     * Order constructor.
     *
     */
    public function __construct()
    {
        if (empty(self::$CI)) {
            self::$CI = &get_instance();
        }
    }

    /**
     * @return \MY_Front_Soma
     * @author renshuai  <renshuai@mofly.cn>
     */
    protected function getCI()
    {
        return self::$CI;
    }

    /**
     *
     * todo 参数优化
     *
     * @param $productID
     * @param $interID
     * @param $qty
     * @param $settingID
     * @param $actID
     * @param $instanceID
     * @param $openid
     * @return Result
     * @author renshuai  <renshuai@jperation.cn>
     */
    public function beforeCreate($productID, $interID, $qty, $settingID, $actID, $instanceID, $openid)
    {
        $result = new Result(Result::STATUS_FAIL);

        $this->getCI()->load->model('soma/Sales_order_model', 'salesOrderModel');
        $stock_limit = \Sales_order_model::STOCK_LIMIT;
        if ($qty > $stock_limit) {
            $result->setMessage('超过了限购数量');
            return $result;
        }

        $this->getCI()->load->model('soma/Product_package_model', 'productPackageModel');
        /**
         * @var \Product_package_model $productPackageModel
         */
        $productPackageModel = $this->getCI()->productPackageModel;

        /**
         * 检查商品状态
         */
        $product = $productPackageModel->getByID($productID, $interID);
        if (!$productPackageModel->isAvaliable($product)) {
            $result->setMessage('商品不可用');
            return $result;
        }

        //默认为不是时间规格的
        $product['setting_date'] = Soma_base::STATUS_FALSE;
        $product['qty'] = $qty;


        $result->setStatus(Result::STATUS_OK);
        $result->setData($product);

        return $result;
    }

    /**
     *
     * todo 参数优化
     *
     * @param $product
     * @param $interID
     * @param $qty
     * @param $openid
     * @param $memberCardIDs
     * @param $saler
     * @param $fansSaler
     * @param $phone
     * @param $name
     * @param $quoteType
     * @param $quote
     * @param $password
     * @param $scopeProductLinkID
     * @return Result
     * @author renshuai  <renshuai@jperation.cn>
     */
    public function buildData($product, $interID, $qty, $openid, $memberCardIDs, $saler, $fansSaler, $phone, $name, $quoteType, $quote, $password, $scopeProductLinkID)
    {
        //todo kanwu 优化下
        $result = new Result(Result::STATUS_FAIL);

        $this->getCI()->load->model('soma/Product_package_model', 'productPackageModel');
        /**
         * @var \Product_package_model $productPackageModel
         */
        $productPackageModel = $this->getCI()->productPackageModel;

        /**
         * 追加英文信息
         */
        $productPackageModel->appendEnInfo($product);

        /**
         * 拉取会员信息 使用优惠
         */
        $this->getCI()->load->library('Soma/Api_member');
        $memberApi = new \Api_member($interID);

        $memberToken = $memberApi->get_token();
        $memberApi->set_token($memberToken['data']);

        $member_info = $memberApi->get_member_info($openid);
        if (empty($member_info)) {
            $result->setMessage('会员信息获取失败，请稍后再重新尝试下单');
            return $result;
        } else {
            $memberID = $member_info['data']->member_id;
            $memberCardID = $member_info['data']->membership_number;
        }

        /**
         * 如果为积分商品，清空优惠规则
         * 如果使用专属价格，清空优惠规则
         */
        if($product['type'] == $productPackageModel::PRODUCT_TYPE_POINT || $scopeProductLinkID > 0) {
            $memberCardIDs = [];
            $quoteType = '';
        }

        $payment_extra = '';
        $discount_array = [];

        $this->getCI()->load->model('soma/Sales_payment_model');
        $this->getCI()->load->model('soma/Sales_order_discount_model');
        /**
         * 使用优惠券
         */
        if (!empty($memberCardIDs)) {
            if (!is_array($memberCardIDs)) {
                $memberCardIDs = explode(',', $memberCardIDs);
            }

            $payment_extra = \Sales_payment_model::PAY_TYPE_CP;
            $couponList = $memberApi->conpon_sign_list($openid);
            $couponList = (array)$couponList['data'];

            $d_type = \Sales_order_discount_model::TYPE_COUPON;

            $couponUsed = [];
            $coupon_count = 0;
            $get_card_id = 0;
            foreach ($couponList as $k => $v) {
                $sv = (array)$v;
                if (in_array($sv['member_card_id'], $memberCardIDs)) {

                    //判断是否是折扣券、兑换券、抵扣券。如果是折扣券，只能使用一张券。
                    if ($sv['card_type'] == \Sales_order_discount_model::TYPE_COUPON_ZK) {
                        //如果是折扣券，那么先置空$info，等于当前的券内容，$coupon_count = 1。并停止循环
                        $couponUsed = [];
                        $coupon_count = 1;
                        $couponUsed[$sv['member_card_id']] = $sv + array('discount_type' => $d_type);
                        break;
                    }

                    $couponUsed[$sv['member_card_id']] = $sv + array('discount_type' => $d_type);
                    $coupon_count++;

                    //判断是否是同一个card_id，否则返回空。只能同种券同一个card_id的券才可以叠加使用
                    if ($get_card_id && $get_card_id != $sv['card_id']) {
                        $couponUsed = array();
                        $coupon_count = 0;
                        break;
                    } else {
                        $get_card_id = $sv['card_id'];
                    }
                }
            }

            //检测购买数量和优惠券的数量  购买数量>=优惠券数量
            if ($coupon_count > $qty) {
                $result->setMessage('选择优惠券出错');
                return $result;
            }

            $discount_array[$d_type] = $couponUsed + ['discount_type' => $d_type];
        }

        $this->getCI()->load->model('soma/Sales_payment_model');
        $this->getCI()->load->model('soma/Sales_rule_model');

        /**
         * 匹配优惠规则
         */
        if ($quoteType && $quote && $quoteType == \Sales_rule_model::RULE_TYPE_BALENCE) {
            //储值优惠
            $payment_extra = \Sales_payment_model::PAY_TYPE_CZ;

            $balance_info = $memberApi->balence_info($openid);

            if ($balance_info['data'] >= $quote) {
                $d_type = \Sales_order_discount_model::TYPE_BALENCE;
                $discount_array[$d_type] = [
                    'discount_type' => $d_type, 'quote' => $quote, 'passwd' => $password,
                ];

            } else {
                $result->setMessage('您的储值不够');

                return $result;
            }

        } elseif ($quoteType && $quote && $quoteType == \Sales_rule_model::RULE_TYPE_POINT) {
            //积分优惠
            $payment_extra = \Sales_payment_model::PAY_TYPE_JF;

            $pointInfo = $memberApi->point_info($openid);

            if ($pointInfo['data'] >= $quote) {
                $d_type = \Sales_order_discount_model::TYPE_POINT;
                $discount_array[$d_type] = [
                    'discount_type' => $d_type, 'quote' => $quote,
                ];

            } else {
                $result->setMessage('您的积分不够');
                return $result;
            }
        }


        $this->getCI()->load->model('soma/Sales_order_model', 'salesOrderModel');
        /**
         * @var \Sales_order_model $salesOrderModel
         */
        $salesOrderModel = $this->getCI()->salesOrderModel;

        $customer = new \Sales_order_attr_customer($openid);
        $customer->name = $name;
        $customer->mobile = $phone;
        $customer->openid = $openid;

        /**
         * 判断是否给予绩效
         */
        $salerID = 0;
        $fansSalerID = 0;
        $salerGroup = '';
        $giveDistribute = $this->getCI()->session->userdata("giveDistribute$interID$openid");
        if ($giveDistribute) {
            $salerID = $saler ? $saler : 0;
            $fansSalerID = $fansSaler ? $fansSaler : 0;

            /**
             * 查询分销员分组信息
             */
            if (!empty($saler)) {
                $this->getCI()->load->library('Soma/Api_idistribute');
                $group_info = $this->getCI()->api_idistribute->get_staff_group_info($interID, $saler);
                $salerGroup = array();
                foreach ($group_info as $group) {
                    $salerGroup[] = $group['group_id'];
                }
                $salerGroup = implode(',', $salerGroup);
            }
        }

        $salesOrderModel->inter_id = $interID;
        $salesOrderModel->openid = $openid;
        $salesOrderModel->customer = $customer;
        $salesOrderModel->saler_id = $salerID;
        $salesOrderModel->saler_group = $salerGroup;
        $salesOrderModel->fans_saler_id = $fansSalerID;
        $salesOrderModel->shipping = 0;
        $salesOrderModel->discount = $discount_array;
        $salesOrderModel->hotel_id = null;
        $salesOrderModel->product = [$product];

        $salesOrderModel->member_id = $memberID;
        $salesOrderModel->member_card_id = $memberCardID;
        $salesOrderModel->scope_product_link_id = $scopeProductLinkID;
        $salesOrderModel->payment_extra = $payment_extra;

        $result->setStatus(Result::STATUS_OK);
        $result->setData($salesOrderModel);
        return $result;
    }

    /**
     * todo 参数优化
     *
     * @param \Sales_order_model $salesOrderModel
     * @param $product
     * @param $openid
     * @param $interID
     * @param $name
     * @param $phone
     * @param $u_type
     * @param $instanceID
     * @param $groupId
     * @return Result
     * @author renshuai  <renshuai@jperation.cn>
     */
    public function afterCreate($salesOrderModel, $product, $openid, $interID, $name, $phone, $u_type, $instanceID, $groupId)
    {
        $result = new Result(Result::STATUS_FAIL);

        $contact['inter_id']  = $interID;
        $contact['mobile']  = $phone;
        $contact['name']    = $name;
        $contact['openid']  = $openid;
        $contact['create_time'] = date('Y-m-d H:i:s');;
        $contact['order_id'] = $salesOrderModel->order_id;
        if( !empty($contact['mobile']) ){
            $salesOrderModel->save_customer_contact($contact, array('openid'=> $openid ) );
        }

        /**
         * 直播
         */
        $zbcode = $this->getCI()->session->tempdata('zbcode');
        $channel_id = $this->getCI()->session->tempdata('channelid');
        if ($zbcode && $channel_id) {
            $redis = $this->getCI()->get_redis_instance();
            $redis_key = $salesOrderModel->get_zb_order_redis_key();
            $redis_value = [
                'zbcode'    => $zbcode,
                'channelid' => $channel_id,
            ];
            $redis->setex($redis_key, 3600, json_encode($redis_value));
        }

        $payChannel = '';
        if($product['type'] == \Product_package_model::PRODUCT_TYPE_BALANCE) {
            $payChannel = 'balance_pay';
        }

        if($product['type'] == \Product_package_model::PRODUCT_TYPE_POINT) {
            $payChannel = 'point_pay';
        }

        if( in_array( $interID, $this->getCI()->wft_pay_inter_ids) ){
            $payChannel = 'wft_pay';
        }


        //记录使用方式到session
        $this->getCI()->session->set_userdata('order_use_type', $u_type);

        $result->setStatus(Result::STATUS_OK);
        $result->setData([
            'payChannel' => $payChannel,
            'salesOrderModel' => $salesOrderModel

        ]);
        return $result;
    }


}