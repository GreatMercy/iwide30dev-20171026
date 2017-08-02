<?php

namespace App\services\soma\order;

use App\libraries\Support\Log;
use App\services\Result;
use App\services\soma\KillsecService;
use App\services\soma\contract\OrderContract;
use Soma_base;
use Soma_const_url;

/**
 * Class KillsecOrder
 * @package App\services\soma\order
 * @author renshuai  <renshuai@mofly.cn>
 *
 */
class KillsecOrder extends AbstractOrder implements OrderContract
{

    /**
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
        $result = parent::beforeCreate($productID, $interID, $qty, $settingID, $actID, $instanceID, $openid);
        if ($result->getStatus() === Result::STATUS_FAIL) {
            Log::debug('result', $result->toArray());
            return $result;
        }

        $product = $result->getData();

        $result->setStatus(Result::STATUS_FAIL);
        $result->setData([]);

        $this->getCI()->load->model('soma/Product_specification_setting_model', 'productSpecificationSettingModel');
        // 秒杀拼团统一库存，随机发货，暂时无法回滚库存，秒杀拼团以活动价格为准
        $psp_settings = $this->getCI()->productSpecificationSettingModel->get_specification_setting($interID, $productID);

        $stocks = 0;
        foreach ($psp_settings as $setting) {
            $stocks += $setting['spec_stock'];
        }
        $product['stock'] = $stocks;
        $product['setting_id'] = 'all';


        $this->getCI()->load->model('soma/Activity_killsec_model', 'activityKillsecModel');
        /**
         * @var \Activity_killsec_model $activityKillsecModel
         */

        $killResult = KillsecService::getInstance()->orderValid($instanceID, $interID, $openid);
        if ($killResult->getStatus() == Result::STATUS_FAIL) {
            Log::debug('killresutl', $killResult->toArray());
            $result->setMessage($killResult->getMessage());
            return $result;
        }

        $activityKillsecModel = $this->getCI()->activityKillsecModel;

        $actDetail = $activityKillsecModel->find(array('inter_id' => $interID, 'act_id' => $actID));

        if (empty($actDetail) || $actDetail['product_id'] != $productID) {
            //防止手动输入product_id借助配额购买其他商品
            $result->setMessage('参数错误，请重新参加活动购买。');
            return $result;
        }

        $product['price_package'] = $actDetail['killsec_price'];
        if ($product['qty'] > $actDetail['killsec_permax']) {
            $productArr['qty'] = $actDetail['killsec_permax'];
        }

        $result->setStatus(Result::STATUS_OK);
        $result->setData($product);

        return $result;
    }

    /**
     * @param \Sales_order_model $salesOrderModel
     * @return Result
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function create($salesOrderModel)
    {
        $result = new Result(Result::STATUS_FAIL);

        $salesOrderModel = $salesOrderModel->order_save($salesOrderModel->business, $salesOrderModel->inter_id);

        if (empty($salesOrderModel->order_id)) {
            $result->setStatus(Result::STATUS_FAIL);
            $result->setMessage('下单失败，请稍后重新尝试');
        }

        $result->setStatus(Result::STATUS_OK);
        $result->setData($salesOrderModel);

        return $result;
    }

    public function afterCreate($salesOrderModel, $product, $openid, $interID, $name, $phone, $u_type, $instanceID, $groupId)
    {

        $this->getCI()->load->model('soma/Activity_killsec_model', 'activityKillsecModel');
        /**
         * @var \Activity_killsec_model $activityKillsecModel
         */
        $activityKillsecModel = $this->activityKillsecModel;
        //秒杀用户信息插入
        $userInfo = array(
            'order_id' => $salesOrderModel->order_id,
            'status' => $activityKillsecModel::USER_STATUS_ORDER,
            'order_time' => date('Y-m-d H:i:s'),
        );
        $activityKillsecModel->update_user_by_filter($salesOrderModel->inter_id,
            [
                'openid' => $salesOrderModel->openid,
                'instance_id' => $instanceID
            ],
            $userInfo
        );

        $result = parent::afterCreate($salesOrderModel, $product, $openid, $interID, $name, $phone, $u_type, $instanceID, $groupId);

        return $result;
    }


}