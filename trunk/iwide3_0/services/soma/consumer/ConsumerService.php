<?php

namespace App\services\soma\consumer;

use App\services\BaseService;
use App\services\Result;
use App\services\soma\SeparateBillingService;
use App\models\soma\SeparateBilling;

/**
 * Class ConsumerService
 * @package    App\services\soma
 *
 * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
 */
class ConsumerService extends BaseService
{
    /**
     * 后台批量核销类型：按订单核销
     */
    const BATCH_CONSUMER_TYPE_ORDER = 'order';
    /**
     * 后台批量核销类型：按赠送单核销
     */
    const BATCH_CONSUMER_TYPE_GIFT  = 'gift';
    
    /**
     * 后台券码核销类型：预约
     */
    const CODE_CONSUMER_TYPE_BOOKING  = 1;
    /**
     * 后台券码核销类型：预约并核销
     */
    const CODE_CONSUMER_TYPE_CONSUMER = 2;

    public function __construct()
    {
        $this->getCI()->load->model('soma/Consumer_code_model');
        $this->getCI()->load->model('soma/Consumer_order_model');
    }

    /**
     * Gets the instance.
     *
     * @return     ConsumerService
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public static function getInstance()
    {
        return self::init(self::class);
    }

    /**
     * 获取批量核销类型转义数组
     *
     * @return     array  批量核销类型转义数组.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getBatchConsumerTypeLabel()
    {
        return array(
            self::BATCH_CONSUMER_TYPE_ORDER => '订单单号',
            self::BATCH_CONSUMER_TYPE_GIFT  => '转赠单号',
        );
    }

    /**
     * 获取券码核销类型转移数组
     *
     * @return     array  券码核销类型转移数组
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getCodeConsumerTypeLabel()
    {
        return array(
            self::CODE_CONSUMER_TYPE_BOOKING  => '券码预约',
            self::CODE_CONSUMER_TYPE_CONSUMER => '预约并核销',
        );
    }

    /**
     * 校验批量核销表单输入值
     *
     * @param      array   $data   表单数据
     *
     * @return     Result  校验结果
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function vaildBatchConsumerEditForm($data)
    {
        $this->getCI()->load->library('form_validation');
        $form_validation = $this->getCI()->form_validation;
        $typeList = implode(',', array_keys($this->getBatchConsumerTypeLabel()));

        $form_validation->set_data($data);
        $form_validation->set_rules(
            'type',
            '核销类型',
            "required|in_list[{$typeList}]",
            array(
                'required' => '核销类型不能为空!',
                'in_list'  => '核销类型非法',
            )
        );
        $form_validation->set_rules(
            'order_id',
            '单号',
            'required',
            array('required' => '单号不能为空!')
        );

        if (isset($data['qty'])) {
            $form_validation->set_rules(
                'qty',
                '核销数量',
                'required|greater_than[0]',
                array(
                    'required'     => '核销数量不能为空!',
                    'greater_than' => '核销数量必须为整数，并且数值需要大于0'
                )
            );
        }

        $result = new Result();
        if ($form_validation->run()) {
            $result->setStatus(Result::STATUS_OK);
        } else {
            $result->setMessage($form_validation->error_string());
        }

        return $result;
    }

    /**
     * 获取订单资产 1.订单中的inter_id与提供的inter_id不符合，返回空数据
     * 2.通过订单get_order_asset()方法获取到的信息中，items字段内容为空的话返回空数据（证明没有资产）
     * 3.获取到订单资产信息后，比对订单的openid与资产中的openid，仅返回匹配的数据
     * 4.如果获取到的资产信息中，对应有多条记录的情况下，将多个资产记录的资产数量汇总（来回转赠会产生多个记录）
     * 5.组合商品主订单需要获取到子商品对应的资产
     *
     * @param      string  $order_id  订单id
     * @param      string  $inter_id  公众号id
     *
     * @return     Result  订单资产信息.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getOrderAsset($order_id, $inter_id)
    {
        $result = new Result();

        $this->getCI()->load->model('soma/sales_order_model');
        $order = $this->getCI()->sales_order_model->load($order_id);

        if ($order && $order->m_get('inter_id') == $inter_id) {
            $assets = $nickname = array();
            $order_info = $order->get_order_asset($order->m_get('business'), $inter_id );

            $combine_assets = $order->getCombineOrderAssets($inter_id);

            if (!empty($combine_assets)) {
                $order_info['combine_main_order'] = true;
                foreach ($combine_assets as $item) {
                    // 查找昵称
                    if (empty($nickname[ $item['openid'] ])) {
                        $nickname[ $item['openid'] ] = $item['openid'];
                        $user_info = $this->getCI()->db
                            ->where_in('openid', $item['openid'])
                            ->select('id,nickname,inter_id')->get('fans')->result_array();
                        if (!empty($user_info)) {
                            $nickname[ $item['openid'] ] = $user_info[0]['nickname'];
                        }
                    }
                    $item['nickname'] = $nickname[ $item['openid'] ];
                    $assets[ $item['item_id'] ] = $item;
                }
            } else {
                $order_info['combine_main_order'] = false;
                if (!empty($order_info['items'])) {
                    foreach ($order_info['items'] as $item) {
                        if ($item['openid'] == $order_info['openid']) {
                            // 昵称
                            if (empty($nickname[ $item['openid'] ])) {
                                $nickname[ $item['openid'] ] = $item['openid'];
                                $user_info = $this->getCI()->db
                                    ->where_in('openid', $item['openid'])
                                    ->select('id,nickname,inter_id')->get('fans')->result_array();
                                if (!empty($user_info)) {
                                    $nickname[ $item['openid'] ] = $user_info[0]['nickname'];
                                }
                            }
                            $item['nickname'] = $nickname[ $item['openid'] ];
                            $assets[ $item['item_id'] ] = $item;
                        }
                    }
                }
            }

            if (!empty($assets)) {
                $result->setStatus(Result::STATUS_OK);
                $result->setData(array('assets' => $assets, 'order' => $order_info));
            } else {
                $result->setMessage('该订单无可用资产信息!');
            }
        } else {
            $result->setMessage('无该订单信息!');
        }

        return $result;
    }
    
    /**
     * 获取赠送资产
     *
     * @param      string  $order_id  礼物id
     * @param      string  $inter_id  公众号id
     *
     * @return     Result  礼物资产.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getGiftAsset($order_id, $inter_id)
    {
        $result = new Result();

        $this->getCI()->load->model('soma/gift_order_model');
        $gift = $this->getCI()->gift_order_model->load($order_id);

        if ($gift && $gift->m_get('inter_id') == $inter_id) {
            // 转赠细单中的资产id为上一个资产id，直接到资产细单表中获取最新的资产信息
            $assets = $nickname = array();
            $gift_info = $gift->m_data();

            $this->getCI()->load->model('soma/asset_item_package_model', 'ai_model');
            $asset_item = $this->getCI()
                ->ai_model->get_order_items_byGiftids(
                    $order_id,
                    $gift->m_get('business'),
                    $inter_id
                );

            if (!empty($asset_item)) {
                // 不需要根据openid进行过滤，群发的同一个gift_id可能存在多个openid
                foreach ($asset_item as $item) {
                    // 昵称
                    if (empty($nickname[ $item['openid'] ])) {
                        $nickname[ $item['openid'] ] = $item['openid'];
                        $user_info = $this->getCI()->db
                            ->where_in('openid', $item['openid'])
                            ->select('id,nickname,inter_id')->get('fans')->result_array();
                        if (!empty($user_info)) {
                            $nickname[ $item['openid'] ] = $user_info[0]['nickname'];
                        }
                    }
                    $item['nickname'] = $nickname[ $item['openid'] ];
                    $assets[ $item['item_id'] ] = $item;
                }
            }

            if (!empty($assets)) {
                $result->setStatus(Result::STATUS_OK);
                $result->setData(array('assets' => $assets, 'gift' => $gift_info));
            } else {
                $result->setMessage('该转赠订单无可用资产信息!');
            }
        } else {
            $result->setMessage('无该转赠订单信息!');
        }

        return $result;
    }

    /**
     * 将资产按照产品和openid维度合并起来，形成一个产品一个资产记录的形式
     *
     * @param      array   $asset   合并前的资产信息
     * @param      string  $openid  用户openid，用于过滤资产
     *
     * @return     array   合并后的资产信息
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function mergeBatchEditAssetInfo($asset, $openid = null)
    {
        $merge_asset = array();
        foreach ($asset as $item) {
            if ($openid === null || $openid == $item['openid']) {
                $key = $item['product_id'] . '_' . $item['openid'];
                if (empty($merge_asset[ $item['product_id'] ])) {
                    $merge_asset[ $key ] = $item;
                } else {
                    $merge_asset[ $key ]['qty'] += $item['qty'];
                }
            }
        }
        return $merge_asset;
    }

    /**
     * 通过资产id获取数个可用的核销码，不传数量则获取全部核销码
     *
     * @param      string  $inter_id  公众号id
     * @param      array   $aiids     资产细单id数组
     * @param      int     $qty       核销数量
     *
     * @return     Result  核销码数组
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getConsumerCodeByAssetItemIds($inter_id, $aiids, $qty = null)
    {
        $model     = $this->getCI()->Consumer_code_model;
        $filter    = array('status' => $model::STATUS_SIGNED);
        $code_list = $model->get_code_by_assetItemIds($aiids, $inter_id, $filter, $qty);

        $result = new Result();
        if ($qty == null || $qty == count($code_list)) {
            $result->setStatus(Result::STATUS_OK);
            $result->setData($code_list);
        } else {
            $result->setMessage('没有足够的核销码!');
        }
        return $result;
    }

    /**
     * 批量核销
     *
     * @param      string  $inter_id   公众号id
     * @param      array   $code_list  核销码信息列表
     * @param      string  $op_user    核销人
     * @param      int     $method     核销方法
     * @param      string  $business   业务类型
     *
     * @return     Result  ( description_of_the_return_value )
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function batchConsumer(
        $inter_id,
        $code_list,
        $op_user,
        $method = \Consumer_order_model::CONSUME_METHOD_SERVICE,
        $business = 'package',
        $hotel_id = null
    ) {
    
        $result    = new Result();
        $aiids     = array();
        $batch_res = true;

        $this->getCI()->soma_db_conn->trans_start();

        foreach ($code_list as $item) {
            $res = $this->codeConsumer($inter_id, $item['code'], $op_user, $method, $business, $hotel_id);
            if ($res->getStatus() != Result::STATUS_OK) {
                $batch_res = false;
                break;
            }
            
            if (!in_array($item['asset_item_id'], $aiids)) {
                $aiids[] = $item['asset_item_id'];
            }
        }

        if ($batch_res) {
            $result->setStatus(Result::STATUS_OK);
            $result->setData($aiids);
            $this->getCI()->soma_db_conn->trans_complete();
        } else {
            $result->setMessage('批量核销失败!');
        }

        return $result;
    }

    /**
     * 验证券码核销表单数据
     *
     * @param      array   $data   表单数据
     *
     * @return     Result  验证结果
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function vaildCodeConsumerEditForm($data)
    {
        $this->getCI()->load->library('form_validation');
        $form_validation = $this->getCI()->form_validation;
        $typeList = implode(',', array_keys($this->getCodeConsumerTypeLabel()));

        $form_validation->set_data($data);
        $form_validation->set_rules(
            'type',
            '核销类型',
            "required|in_list[{$typeList}]",
            array(
                'required' => '核销类型不能为空!',
                'in_list'  => '核销类型非法',
            )
        );
        $form_validation->set_rules(
            'code',
            '核销券码',
            'required',
            array('required' => '单号不能为空!')
        );
        $form_validation->set_rules(
            'ids',
            '资产ID',
            'required',
            array('required' => '无法找到资产信息!')
        );

        $result = new Result();
        if ($form_validation->run()) {
            $result->setStatus(Result::STATUS_OK);
        } else {
            $result->setMessage($form_validation->error_string());
        }

        return $result;
    }

    /**
     * 检查核销时券码是否可用，可用时返回可用状态与资产信息
     *
     * 注：特权券类商品不可核销
     *
     * @param      string  $inter_id  公众号
     * @param      string  $code      券码信息
     * @param      string  $business  业务类型
     *
     * @return     Result  ( description_of_the_return_value )
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    protected function checkCodeConsumerInfo($inter_id, $code, $business = 'package')
    {
        $checkInfo = true;
        $result    = new Result();

        $codeInfo = $this->getCI()->Consumer_code_model->get_consumer_code_info_by_code($code, $inter_id);
        if (empty($codeInfo) || $codeInfo['status'] != \Consumer_code_model::STATUS_SIGNED) {
            $checkInfo = false;
            $result->setMessage("该核销码[$code]无可用信息!");
        }

        if ($checkInfo) {
            $this->getCI()->load->model('soma/Asset_item_' . $business . '_model', 'ai_model');
            $assetInfo = $this->getCI()->ai_model->load($codeInfo['asset_item_id']);
            if (empty($assetInfo)
                || $assetInfo->m_get('type') == $assetInfo::PRODUCT_TYPE_PRIVILEGES_VOUCHER) {
                $checkInfo = false;
                $result->setMessage("该核销码[$code]无可用资产信息!");
            }
        }

        if ($checkInfo) {
            $result->setStatus(Result::STATUS_OK);
            $result->setData([
                'asset' => $assetInfo->m_data(),
            ]);
        }

        return $result;
    }

    /**
     * 后台券码预约核销
     *
     * @param      string  $inter_id  公众号id
     * @param      string  $code      核销码
     * @param      string  $op_user   操作人
     * @param      int     $type      核销类型：1:预约、2:核销
     * @param      int     $method    核销方法
     * @param      string  $business  业务类型
     *
     * @return     Result  预约核销结果
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function bookingConsumer(
        $inter_id,
        $code,
        $op_user,
        $type = self::CODE_CONSUMER_TYPE_BOOKING,
        $method = \Consumer_order_model::CONSUME_METHOD_SERVICE,
        $business = 'package',
        $hotel_id = null
    ) {
    
        $result = new Result();
        switch ($type) {
            case self::CODE_CONSUMER_TYPE_BOOKING:
                $result = $this->codeBooking($inter_id, $code, $op_user, $method, $business, $hotel_id);
                break;
            case self::CODE_CONSUMER_TYPE_CONSUMER:
                $result = $this->codeConsumer($inter_id, $code, $op_user, $method, $business, $hotel_id);
                break;
            default:
                $result->setMessage('未知券码核销操作!');
                break;
        }
        return $result;
    }

    /**
     * 券码预约
     *
     * @param      string  $inter_id  公众号
     * @param      string  $code      核销券码
     * @param      string  $op_user   操作人
     * @param      int     $method    核销方法
     * @param      string  $business  业务类型
     * @param      int     $hotel_id  预约酒店id
     *
     * @return     Result  券码预约结果
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function codeBooking(
        $inter_id,
        $code,
        $op_user = null,
        $method = \Consumer_order_model::CONSUME_METHOD_SERVICE,
        $business = 'package',
        $hotel_id = null
    ) {

        $result = new Result();

        try {
            $this->getCI()->soma_db_conn->trans_start();
            $checkInfo = $this->checkCodeConsumerInfo($inter_id, $code, $business);

            if ($checkInfo->getStatus() == Result::STATUS_OK) {
                // 如果酒店id为null，取当前资产内的酒店id
                $checkData = $checkInfo->getData();
                if ($hotel_id == null) {
                    $hotel_id = $checkData['asset']['hotel_id'];
                }

                $this->getCI()->load->model('hotel/hotel_model');
                $hotel_info = $this->getCI()->hotel_model->get_hotel_by_ids($inter_id, $hotel_id);
                if(!empty($hotel_info)) {
                    // 预约券码
                    $orderModel = $this->getCI()->Consumer_order_model;
                    $orderModel->billing_hotel_id   = $hotel_id;
                    $orderModel->billing_hotel_name = $hotel_info[0]['name'];
                    $res = $orderModel->booking_consumer($code, $op_user, $method, $inter_id, $business);   

                    if ($res && isset( $res['status'] ) && $res['status'] == \Soma_base::STATUS_TRUE) {
                        // 写入分账信息
                        if ($hotel_id != null && $hotel_id != SeparateBilling::MULITPLE_HOTEL_ID) {
                            // 核销后，新的核销码信息中存有核销id，需要同一数据库连接
                            // 即保持事务状态，get_consumer_code_info_by_code方法内已修改
                            $codeModel = $this->getCI()->Consumer_code_model;
                            $codeInfo  = $codeModel->get_consumer_code_info_by_code($code, $inter_id);
                            $oid       = $checkData['asset']['order_id'];
                            $cid       = $codeInfo['consumer_id'];
                            $service   = SeparateBillingService::getInstance(); 

                            if($service->writeConsumerSeparateBilling($oid, $cid, $hotel_id, 1)) {
                                $result->setStatus(Result::STATUS_OK);
                                $result->setData([
                                    'openid'        => $checkData['asset']['openid'],
                                    'asset_item_id' => $checkData['asset']['item_id'],
                                ]);
                            } else {
                                $result->setMessage("券码[$code]核销失败:写入分账信息失败!");
                            }
                        } else {
                            $result->setMessage("券码[$code]核销失败:无核销分账酒店信息!");
                        }
                    } else {
                        $result->setMessage("券码[$code]核销失败!");
                        if ($res && isset($res['message'])) {
                            $result->setMessage("券码[$code]核销失败:" . $res['message']);
                        }
                    }
                } else {
                    $result->setMessage("券码[$code]核销失败:找不到核销酒店信息!");
                }
            } else {
                $result->setMessage($checkInfo->getMessage());
            }

            if ($result->getStatus() == Result::STATUS_OK) {
                $data = $result->getData();
                $this->sendBookingConsumerWxTemplateMessage(
                    $inter_id,
                    $data['openid'],
                    $data['asset_item_id'],
                    $code,
                    self::CODE_CONSUMER_TYPE_BOOKING,
                    $business
                );
                $this->getCI()->soma_db_conn->trans_complete();
            }
        } catch (\Exception $e) {
            $result->setMessage('系统异常！');
        }

        return $result;
    }

    /**
     * 券码核销
     *
     * @param      string  $inter_id  公众号ID
     * @param      string  $code      券码
     * @param      string  $op_user   操作人
     * @param      int     $method    核销方法
     * @param      string  $business  业务类型
     * @param      int     $hotel_id  核销酒店id
     *
     * @return     Result  券码核销结果
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function codeConsumer(
        $inter_id,
        $code,
        $op_user = null,
        $method = \Consumer_order_model::CONSUME_METHOD_SERVICE,
        $business = 'package',
        $hotel_id = null
    ) {
    
        $result = new Result();

        try {
            $this->getCI()->soma_db_conn->trans_start();

            // 查找该核销码是否存在消费信息，存在则直接更改状态，不存在则需要进行核销
            $codeInfo = $this->getCI()->Consumer_code_model->get_consumer_code_info_by_code($code, $inter_id);
            $orderItem = $this->getCI()->Consumer_order_model->get_consumer_order_item(
                $codeInfo['asset_item_id'],
                $code,
                $business,
                $inter_id
            );

            if (empty($orderItem)) {
                $checkInfo = $this->checkCodeConsumerInfo($inter_id, $code, $business);
                if ($checkInfo->getStatus() == Result::STATUS_OK) {
                    // 写入分账信息
                    $checkData = $checkInfo->getData();
                    if ($hotel_id == null) {
                        $hotel_id = $checkData['asset']['hotel_id'];
                    }
                    $this->getCI()->load->model('hotel/hotel_model');
                    $hotel_info = $this->getCI()->hotel_model->get_hotel_by_ids($inter_id, $hotel_id);
                    if(!empty($hotel_info)) {
                        $this->getCI()->Consumer_order_model->billing_hotel_id   = $hotel_id;
                        $this->getCI()->Consumer_order_model->billing_hotel_name = $hotel_info[0]['name'];
                        $res = $this->getCI()->Consumer_order_model->direct_consumer(
                            $code,
                            $op_user,
                            $method,
                            $inter_id,
                            $business
                        );  

                        if ($res && isset( $res['status'] ) && $res['status'] == \Soma_base::STATUS_TRUE) {
                            // 写入分账信息
                            // $checkData = $checkInfo->getData();
                            // if ($hotel_id == null) {
                            //     $hotel_id = $checkData['asset']['hotel_id'];
                            // }
                            if ($hotel_id != null && $hotel_id != SeparateBilling::MULITPLE_HOTEL_ID) {
                                // 核销后，新的核销码信息中存有核销id，需要同一数据库连接
                                // 即保持事务状态，get_consumer_code_info_by_code方法内已修改
                                $codeInfo = $this->getCI()->Consumer_code_model->get_consumer_code_info_by_code($code, $inter_id);
                                $separateResult = SeparateBillingService::getInstance()->writeConsumerSeparateBilling($checkData['asset']['order_id'], $codeInfo['consumer_id'], $hotel_id, 1);
                                if($separateResult) {
                                    $result->setStatus(Result::STATUS_OK);
                                    $result->setData([
                                        'openid'        => $checkData['asset']['openid'],
                                        'asset_item_id' => $checkData['asset']['item_id'],
                                    ]);
                                } else {
                                    $result->setMessage("券码[$code]核销失败:写入分账信息失败!");
                                }
                            } else {
                                $result->setMessage("券码[$code]核销失败:无核销分账酒店信息!");
                            }
                        } else {
                            $result->setMessage("券码[$code]核销失败!");
                            if ($res && isset($res['message'])) {
                                $result->setMessage("券码[$code]核销失败:" . $res['message']);
                            }
                        }
                    } else {
                        $result->setMessage("券码[$code]核销失败:找不到核销酒店信息!");
                    }
                } else {
                    $result->setMessage($checkInfo->getMessage());
                }
            } else {
                // 由于 Consumer_order_model::get_consumer_order_item() 方法没有排序，此处将数组倒置
                $orderItem = array_reverse($orderItem);
                $this->getCI()->load->model('soma/Consumer_item_'.$business.'_model', 'ConsumerItemModel');
                $ConsumerItemModel = $this->getCI()->ConsumerItemModel;

                if ($orderItem['0']['status'] != $ConsumerItemModel::STATUS_ITEM_CONSUME) {
                    $this->getCI()->Consumer_order_model->order_item = $orderItem;
                    $this->getCI()->Consumer_order_model->business   = $business;
                    if ($this->getCI()->Consumer_order_model->consumer_order_consume($business, $inter_id)) {
                        $result->setStatus(Result::STATUS_OK);
                        $result->setData([
                            'openid'        => $orderItem[0]['openid'],
                            'asset_item_id' => $orderItem[0]['asset_item_id'],
                        ]);
                    } else {
                        $result->setMessage("券码[$code]核销失败!");
                    }
                } else {
                    $result->setMessage("券码[$code]已经消费!");
                }
            }

            if ($result->getStatus() == Result::STATUS_OK) {
                $data = $result->getData();
                $this->sendBookingConsumerWxTemplateMessage(
                    $inter_id,
                    $data['openid'],
                    $data['asset_item_id'],
                    $code,
                    self::CODE_CONSUMER_TYPE_CONSUMER,
                    $business
                );
                $this->getCI()->soma_db_conn->trans_complete();
            }
        } catch (\Exception $e) {
            $result->setMessage('系统异常！');
        } 
        
        return $result;
    }

    /**
     * 发送券码核销模板消息
     *
     * @param      string  $inter_id  公众号id
     * @param      string  $openid    用户openid
     * @param      int     $aiid      资产细单id
     * @param      string  $code      核销码
     * @param      int     $type      核销类型：1.预约 -> 预约消息，2.核销 ->核销消息
     * @param      string  $business  业务类型
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function sendBookingConsumerWxTemplateMessage(
        $inter_id,
        $openid,
        $aiid,
        $code,
        $type = self::CODE_CONSUMER_TYPE_BOOKING,
        $business = 'package'
    ) {
    
        $this->getCI()->load->model('soma/Asset_customer_model');
        $this->getCI()->load->model('soma/Message_wxtemp_template_model');

        $tempType = \Message_wxtemp_template_model::TEMPLATE_BOOKING_SUCCESS;
        if ($type == self::CODE_CONSUMER_TYPE_CONSUMER) {
            $tempType = \Message_wxtemp_template_model::TEMPLATE_CONSUMER_SUCCESS;
        }
        
        $this->getCI()->Asset_customer_model->code = $code;
        $this->getCI()->Asset_customer_model->asset_item_id = $aiid;

        $this->getCI()->Message_wxtemp_template_model->send_template_by_consume_or_booking_success(
            $tempType,
            $this->getCI()->Asset_customer_model,
            $openid,
            $inter_id,
            $business
        );
    }

    /**
     * 整单核销
     *
     * @param      string  $order_id  订单号
     * @param      string  $inter_id  公众号id
     * @param      string  $op_user   核销操作人
     * @param      int     $method    核销方法
     * @param      string  $business  业务类型
     * @param      string  $hotel_id  核销酒店，为空时取订单里面的酒店id
     *
     * @return     Result  核销结果
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function orderConsumer(
        $order_id,
        $inter_id,
        $op_user = '',
        $method = \Consumer_order_model::CONSUME_ROOM_AUTO,
        $business = 'package',
        $hotel_id = null)
    {
        $result = $this->getOrderAsset($order_id, $inter_id);
        if ($result->getStatus() == Result::STATUS_OK) {
            $data   = $result->getData();
            $aiids  = array_keys($data['assets']);
            $result = $this->getConsumerCodeByAssetItemIds($inter_id, $aiids);
            if ($result->getStatus() == Result::STATUS_OK) {
                $codes  = $result->getData();
                $result = $this->batchConsumer($inter_id, $codes, $op_user, $method, $business, $hotel_id);
            }
        }
        return $result;
    }

}
