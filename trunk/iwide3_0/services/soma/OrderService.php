<?php
namespace App\services\soma;

use App\libraries\Support\Log;
use App\services\BaseService;
use App\services\Result;
use App\services\soma\order\OrderProvider;

/**
 * Class OrderService
 * @package App\services\soma
 * @author renshuai  <renshuai@mofly.cn>
 *
 */
class OrderService extends BaseService
{
    /**
     * 获取服务实例方法
     * @return OrderService
     */
    public static function getInstance()
    {
        return self::init(self::class);
    }

    /**
     * 下单
     * @param $params
     * @return Result
     * @author renshuai  <renshuai@jperation.cn>
     */
    public function create($params)
    {
        $provider = new OrderProvider();
        $order = $provider->resolve($params);

        $interID = $this->getCI()->inter_id;
        $openid = $this->getCI()->openid;

        $productID = $params['product_id'];
        $settlement = isset($params['settlement']) ? $params['settlement'] : null;
        $u_type = isset($params['u_type']) ? $params['u_type'] : '';
        $qty = $params['qty'];
        $memberCardIDs = isset($params['mcid']) ? $params['mcid'] : [];
        $salerID = isset($params['saler']) ? $params['saler'] : null;
        $fanSalerID = isset($params['fans_saler']) ? $params['fans_saler'] : null;
        $phone = isset($params['phone']) ? $params['phone'] : null;
        $name = isset($params['name']) ? $params['name'] : null;
        $quoteType = isset($params['quote_type']) ? $params['quote_type'] : '';
        $quote = isset($params['quote']) ? $params['quote'] : '';
        $password = isset($params['password']) ? $params['password'] : '';
        $pspSettingArr = isset($params['psp_setting']) ? $params['psp_setting'] : [];
        $actID = isset($params['act_id']) ? $params['act_id'] : 0;
        $instanceID = isset($params['inid']) ? $params['inid'] : 0;
        $scopeProductLinkID = isset($params['scope_product_link_id']) ? $params['scope_product_link_id'] : 0;
        $groupId = 0;
        $grid = isset($params['grid']) ? $params['grid'] : 0;
        $type = isset($params['type']) ? $params['type'] : '';


        $settingID = isset($pspSettingArr[$productID]) ? $pspSettingArr[$productID] : 0;

        //第一步
        $beforeResult = $order->beforeCreate($productID, $interID, $qty, $settingID, $actID, $instanceID, $openid);
        if ($beforeResult->getStatus() === Result::STATUS_FAIL) {
            Log::error("OrderService beforeCreate error, before msg is " . $beforeResult->getMessage(), $beforeResult->toArray());
            return $beforeResult;
        }
        $product = $beforeResult->getData();

        //第二步
        $buildResult = $order->buildData($product, $interID, $qty, $openid, $memberCardIDs, $salerID, $fanSalerID, $phone, $name, $quoteType, $quote, $password, $scopeProductLinkID);
        if ($buildResult->getStatus() === Result::STATUS_FAIL) {
            Log::error("OrderService beforeCreate error, build msg is " . $buildResult->getMessage(), $buildResult->toArray());
            return $buildResult;
        }
        /**
         * @var \Sales_order_model $salesOrderModel
         */
        $salesOrderModel = $buildResult->getData();
        $salesOrderModel->business = 'package';
        $salesOrderModel->settlement = $settlement;


        //第三步
        $createResult = $order->create($salesOrderModel);
        if ($createResult->getStatus() === Result::STATUS_FAIL) {
            Log::error("OrderService beforeCreate error, create msg is " . $createResult->getMessage(), $createResult->toArray());
            return $createResult;
        }
        $salesOrderModel = $buildResult->getData();

        //第四步
        $afterResult = $order->afterCreate($salesOrderModel, $product, $openid, $interID, $name, $phone, $u_type, $instanceID, $groupId);
        if ($afterResult->getStatus() === Result::STATUS_FAIL) {
            Log::error("OrderService beforeCreate error, after msg is " . $afterResult->getMessage(), $afterResult->toArray());
            return $afterResult;
        }

        return $afterResult;
    }


    /**
     * 订单列表
     * @param string $openid
     * @param string $type
     * @param array $options
     * @return Result
     */
    public function getOrderList($openid, $type = '', $options)
    {
        $this->getCI()->load->model('soma/sales_order_model', 'somaSalesOrderModel');
        $this->getCI()->load->model('soma/sales_item_package_model', 'salesItemPackageModel');
        $callback_func = function ($order) {
            $result = new Result();
            $result->setStatus(Result::STATUS_OK);
            $result->setData($order);
            return $result;
        };
        /** @var \Sales_order_model $somaSalesOrderModel */
        $somaSalesOrderModel = $this->getCI()->somaSalesOrderModel;
        /** @var \Sales_item_package_model $salesItemPackageModel */
        $Sales_item_package_model = $this->getCI()->salesItemPackageModel;
        $condition = [
            'and openid =' => $openid,
            'and status =' => \Sales_order_model::STATUS_PAYMENT, // 购买成功
        ];
        if ($type == 2) { // 未使用
            $condition['and consume_status !='] = 23; // 21 未消费 22 部分消费 23 全部消费
        }
        if ($type == 3) { // 已完成
            $condition['and consume_status ='] = 23; // 全部消费

            $table_name = $Sales_item_package_model->table_name();

            $table_name = $this->soma_db_conn_read->dbprefix($table_name);

            $condition['and (select expiration_date from ' . $table_name . ' as p where order_id = p.order_id limit 1) <'] = date('Y-m-d H:i:s');
        }
        // TODO 需要增加删除状态
        $paginate = $somaSalesOrderModel->paginate(array_keys($condition), array_values($condition), [
            'order_id',
            'create_time',
            'item_name',
            'real_grand_total',
            'row_qty',
            'status',
            'refund_status',
            'consume_status',
        ], $options);
        $order = isset($paginate['data']) ? $paginate['data'] : [];
        if (empty($order)) {
            return $callback_func($paginate);
        }
        $orderIDMap = array_column($order, 'order_id');
        $item_condition = [
            'order_id' => $orderIDMap
        ];
        $item_map = $Sales_item_package_model->get(array_keys($item_condition), array_values($item_condition), [
            'order_id',
            'face_img',
        ]);
        foreach ($order as $key => $value) {
            foreach ($item_map as $item_key => $item_val) {
                if ($item_val['order_id'] == $value['order_id']) {
                    $order[$key]['package'][] = $item_val;
                }
            }
        }
        $paginate['data'] = $order;
        return $callback_func($paginate);
    }


}