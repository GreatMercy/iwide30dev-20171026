<?php

use App\facades\Input;
use App\services\Result;
use App\services\soma\order\GrouponOrder;
use App\services\soma\order\KillsecOrder;
use App\services\soma\order\NormalOrder;
use App\services\soma\order\OrderProvider;
use App\services\soma\OrderService;
use Monolog\Handler\StreamHandler;
use App\services\soma\CronService;
use App\services\soma\ScopeDiscountService;

/**
 * Class Logic
 *
 * for test
 * @author renshuai  <renshuai@mofly.cn>
 *
 */
class Logic extends MY_Front_Soma
{

    /**
     *  ==========================
     *  OrderLogic tests
     *  ==========================
     */


    public function before_create()
    {
        $interID = 'a450089706';
        $productID = 11866;
        $pspID = 107;
        $qty = 10;
        $actID = 1;
        $instanceID = 0;
        $openid = 'o9VbtwwUedrHzhXFSfegtSFMIKtU';

//        $order = new NormalOrder();
//        $order = new KillsecOrder();
        $order = new GrouponOrder();

        $result = $order->beforeCreate($productID, $interID, $qty, $pspID, $actID, $instanceID, $openid);

        var_dump($result);
    }


    public function build_data()
    {
        $interID = 'a450089706';
        $productID = 10247; //正常的
//        $productID = 11587; //积分的
        $pspID = 0;
        $qty = 1;
        $actID = 0;
        $instanceID = 0;
        $openid = 'o9VbtwwUedrHzhXFSfegtSFMIKtU';

        $order = new NormalOrder();
        $result = $order->beforeCreate($productID, $interID, $qty, $pspID, $actID, $instanceID, $openid);
        if ($result->getStatus() == Result::STATUS_FAIL) {
            var_dump($result);
            exit;
        }
        $product = $result->getData();

//        $memberCardIDs = [2657407, 2657438];
        $memberCardIDs = [];
        $salerID = 0;
        $fanSalerID = 0;
        $phone = '';
        $name = '';
        $quoteType = 30;
        $quote = 1;
        $settlement = 'default';
        $password = '';
        $scope_product_link_id = 0;


        $buildResult = $order->buildData($product, $interID, $qty, $openid, $memberCardIDs, $salerID, $fanSalerID, $phone, $name, $quoteType, $quote, $password, $scope_product_link_id);
        if ($buildResult->getStatus() == Result::STATUS_FAIL) {
            var_dump($buildResult);
            exit;
        }

        $salesOrderModel = $buildResult->getData();
        $salesOrderModel->business = 'package';
        $salesOrderModel->settlement = $settlement;
        var_dump($salesOrderModel);
    }




}