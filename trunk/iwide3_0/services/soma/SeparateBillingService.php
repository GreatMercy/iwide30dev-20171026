<?php

namespace App\services\soma;

use App\services\BaseService;
use App\models\soma\SeparateBilling;
use App\services\Result;

/**
 * Class LedgerAccountService
 * @package    App\services\soma
 *
 * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
 */
class SeparateBillingService extends BaseService
{
    /**
     * Gets the instance.
     *
     * @return     SeparateBillingService
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public static function getInstance()
    {
        return self::init(self::class);
    }

    /**
     * 下单成功写入分账记录
     *
     * @param      string  $order_id  订单ID
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     *
     * todo 忠诚，用了try catch， 那就要处理异常，要不就别写了， 还有注释要写 return
     *
     * @return bool
     */
    public function writeOrderSeparateBilling($order_id)
    {
        try {
            $separate_model = new SeparateBilling();
            $info = $separate_model->getOrderBillingInfo($order_id);    

            // 订单没有分账信息才写入，避免重复回调或重复重建写入错误信息
            if (empty($info)) {
                $this->getCI()->load->model('soma/sales_order_model');
                if ($order = $this->getCI()->sales_order_model->load($order_id)) {
                    $inter_id = $order->m_get('inter_id');
                    $business = $order->m_get('business');
                    $items    = $order->get_order_items($business, $inter_id);      

                    // 通票商品下单成功暂时不写入分账信息
                    if($items[0]['hotel_id'] != SeparateBilling::MULITPLE_HOTEL_ID) {
                        $data['order_id']       = $order_id;
                        $data['inter_id']       = $inter_id;
                        $data['hotel_id']       = $items[0]['hotel_id'];
                        $data['order_qty']      = $items[0]['qty'];
                        $data['bill_hotel']     = $data['hotel_id'];
                        $data['bill_qty']       = $data['order_qty'];
                        $data['can_auto_check'] = SeparateBilling::CAN_AUTO_CHECK_NO;
                        $data['payment_time']   = $order->m_get('payment_time');
                        $data['create_time']    = date('Y-m-d H:i:s');
                        $data['bill_time']      = $data['create_time'];
                        $data['status']         = SeparateBilling::STATUS_CAN_PAY_YES;

                        // 可退款的订单状态更改为 STATUS_WAITING_CHECK
                        // 7天退款的订单 can_auto_check 改为 CAN_AUTO_CHECK_YES
                        if ($items[0]['can_refund'] != \MY_Model_Soma::CAN_REFUND_STATUS_FAIL) {
                            unset($data['bill_time']);
                            $data['status'] = SeparateBilling::STATUS_WAITING_CHECK;
                            if($items[0]['can_refund'] == \MY_Model_Soma::CAN_REFUND_STATUS_SEVEN) {
                                $data['can_auto_check'] = SeparateBilling::CAN_AUTO_CHECK_YES;
                            }
                        }   

                        return $separate_model->saveBilling($data);
                    }
                }
            }
        } catch (\Exception $e) {
            // 
        }

        return false;
    }

    /**
     * 核销成功写入分账记录
     *
     * @param      string  $order_id        订单号
     * @param      int|string  $consumer_id     核销id
     * @param      string  $consumer_hotel  核销酒店
     * @param      string  $consumer_qty    核销数量
     *
     * @return     boolean  操作成功返回true, 失败返回false.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function writeConsumerSeparateBilling(
        $order_id,
        $consumer_id = -1,
        $consumer_hotel = null,
        $consumer_qty = null)
    {
        try {
            $this->getCI()->load->model('soma/sales_order_model');  

            if ($order = $this->getCI()->sales_order_model->load($order_id)) {
                $inter_id = $order->m_get('inter_id');
                $business = $order->m_get('business');
                $items    = $order->get_order_items($business, $inter_id);  

                if ($consumer_hotel == null) {
                    $consumer_hotel = $items[0]['hotel_id'];
                }   

                if ($consumer_qty == null) {
                    $consumer_hotel = $items[0]['qty'];
                }   

                // 存在核销酒店时才记录分账信息，单店时，核销酒店要与单店id一致
                // if ($consumer_hotel != SeparateBilling::MULITPLE_HOTEL_ID
                //     && ($items[0]['hotel_id'] == $consumer_hotel
                //     || $items[0]['hotel_id'] == SeparateBilling::MULITPLE_HOTEL_ID)) {
                
                // 核销酒店不能是通用酒店
                if ($consumer_hotel != SeparateBilling::MULITPLE_HOTEL_ID) {
                    // 单店订单核销时，整单确认分账，通票按核销信息插入新数据，核销的一定是可发放的
                    $data['order_id']       = $order_id;
                    $data['inter_id']       = $inter_id;
                    $data['hotel_id']       = $items[0]['hotel_id'];
                    $data['order_qty']      = $items[0]['qty'];
                    $data['bill_hotel']     = $consumer_hotel;
                    $data['bill_qty']       = $consumer_qty;
                    $data['can_auto_check'] = SeparateBilling::CAN_AUTO_CHECK_NO;
                    $data['payment_time']   = $order->m_get('payment_time');
                    $data['create_time']    = date('Y-m-d H:i:s');
                    $data['bill_time']      = $data['create_time'];
                    $data['status']         = SeparateBilling::STATUS_CAN_PAY_YES;
                    $data['consumer_id']    = $consumer_id;


                    $separate_model = new SeparateBilling();
                    if ($items[0]['hotel_id'] != SeparateBilling::MULITPLE_HOTEL_ID) {
                        // 单店订单在核销时直接确认整单分账信息，数量和酒店均为细单中的数据
                        $data['bill_hotel']  = $data['hotel_id'];
                        $data['bill_qty']    = $data['order_qty'];
                        $data['consumer_id'] = -1;

                        // 已存在分账信息的更新分账信息，单店订单只能有1条分账记录，代码维护
                        // 不存在分账信息的订单，证明此订单是漏单或上线之前的订单，直接插入可发放分账信息
                        $info = $separate_model->getOrderBillingInfo($order_id);
                        if (!empty($info)) {
                            // 已经确认可以核销发放的不再写入，不能发放的更新为可以核销发放
                            if ($info[0]['status'] == SeparateBilling::STATUS_CAN_PAY_YES) {
                                return true;
                            }
                            $data['bill_id'] = $info[0]['bill_id'];
                        }
                    }   

                    return $separate_model->saveBilling($data);
                }   

            }
        } catch (\Exception $e) {
            // 
        }

        return false;
    }

    /**
     * 自动审核7天未退款的订单分账信息（单店）
     * 
     * @param      array    $order_ids    订单id，如果有值，则只审核该部分订单
     *
     * @return     boolean  分账审核成功返回true，失败返回false.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function autoCheckSeparateBillingInfo($order_ids = array())
    {
        $separate_model = new SeparateBilling();
        $info = $separate_model->getWattingCheckBilling(null, $order_ids);

        $update = array();
        $pk = $separate_model->table_primary_key();
        foreach ($info as $item) {
            $tmp[ $pk ]         = $item[ $pk ];
            $tmp[ 'status' ]    = SeparateBilling::STATUS_CAN_PAY_YES;
            $tmp[ 'bill_time' ] = date('Y-m-d H:i:s');
            $update[]           = $tmp;
        }
        return $separate_model->batchSaveBilling($update);
    }

    /**
     * 更新一个订单的分账信息：
     * 
     * 注：存在已确认可以付款的，不可更新任何状态信息
     *
     * @param      string   $order_id  订单id
     * @param      int      $status    订单分账状态
     *
     * @return     boolean  更新成功返回true，失败返回false.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function updateOrderSeparateBillingInfo(
        $order_id,
        $status = SeparateBilling::STATUS_CAN_PAY_NO)
    {
        $separate_model = new SeparateBilling();
        $info           = $separate_model->getOrderBillingInfo($order_id);

        $update = array();
        $pk     = $separate_model->table_primary_key();
        foreach ($info as $item) {
            if($item['status'] == SeparateBilling::STATUS_CAN_PAY_YES) {
                return false;
            }
            $tmp[ $pk ]    = $item[ $pk ];
            $tmp['status'] = $status;
            $update[]      = $tmp;
        }
        return $separate_model->batchSaveBilling($update);
    }

    /**
     * 获取可以划款的订单分账信息，对于没有查询到信息的订单重建数据
     *
     * @param      array   $order_ids    订单id
     * @param      string  $check_point  开始检查时间点
     * @param      string  $inter_id     公众号id
     *
     * @return     array   可以划款订单分账信息
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getCanPaySeparateBilling($order_ids, $check_point = null, $inter_id = null)
    {

        $this->buildShardConfig($inter_id);

        // 加载旧的model父类
        $this->getCI()->load->model('soma/sales_order_model');

        $this->rebuildOrderSeparateBilling($order_ids);
        $this->autoCheckSeparateBillingInfo($order_ids);

        // 由于上述操作用读写库，此处也同步用读写库
        $separate_model = new SeparateBilling();
        $separate_model->setActiveDb($this->getCI()->soma_db_conn);

        $status = SeparateBilling::STATUS_CAN_PAY_YES;
        return $separate_model->getOrderBillingInfo($order_ids, $check_point, $status);
    }

    /**
     * 重建订单分账信息
     *
     * @param      array    $order_ids  订单id
     *
     * @return     boolean  重建成功返回true, 失败返回false.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function rebuildOrderSeparateBilling($order_ids)
    {
        $separate_model = new SeparateBilling();
        $bill_info      = $separate_model->getOrderBillingInfo($order_ids);

        // 将订单数组倒置，以订单号为键值
        $none_info_ids  = array_flip($order_ids);
        foreach ($bill_info as $info) {
            // 存在信息，将$none_info_ids中的相应订单号去掉
            if (isset($none_info_ids[ $info['order_id'] ])) {
                unset($none_info_ids[ $info['order_id'] ]);
            }
        }

        $separate_model->getActviveDb()->trans_start();
        $res = true;
        foreach ($none_info_ids as $order_id => $value) {
            $res = $res && $this->writeOrderSeparateBilling($order_id);
        }

        if ($res) {
            $separate_model->getActviveDb()->trans_complete();
        }
        return $res;
    }

    /**
     * 根据核销记录重建订单分账信息
     *
     * @param      <type>  $order_ids  The order identifiers
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function rebulidConsumerSeparateBilling($order_ids)
    {

    }

    /**
     * 检查订单退款状态信息
     *
     * @param      string  $inter_id   公众号id
     * @param      array   $order_ids  订单数组
     *
     * @return     array   订单退款信息
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getOrderRefundInfo($inter_id = null, $order_ids = array())
    {
        $result = new Result();

        if (!empty($inter_id) && !empty($order_ids)) {
            $this->buildShardConfig($inter_id);
            $this->getCI()->load->model('soma/sales_order_model');
            $data = $this->getCI()->sales_order_model->get(
                ['order_id'],
                [$order_ids],
                'order_id,settlement,create_time,can_refund,consume_status,gift_status,refund_status,status',
                ['limit' => null]
            );

            $info = $hash_data = array();
            foreach ($data as $order) {
                $hash_data[ $order['order_id'] ] = $order;
            }

            foreach ($order_ids as $order_id) {
                if (isset( $hash_data[ $order_id ] )) {
                    $status = SeparateBilling::CAN_ORDER_REFUND_YES;
                    // 当前只有普通购买支付可以退款，秒杀平团由于价格特殊是不可以退款的
                    // 其他平团下单也是不可以退款的，即大客户，礼品卡，订房套餐
                    if ($hash_data[ $order_id ][ 'settlement' ] != \Sales_order_model::SETTLE_DEFAULT) {
                        $status = SeparateBilling::CAN_ORDER_REFUND_NO;
                    }

                    // 不是已支付状态的不能退款
                    if ($hash_data[ $order_id ]['status'] != 12) {
                        $status = SeparateBilling::CAN_ORDER_REFUND_NO;
                    }

                    // 产品设置不能退款的订单不能退款
                    if ($hash_data[ $order_id ]['can_refund'] == \Sales_order_model::CAN_REFUND_STATUS_FAIL) {
                        $status = SeparateBilling::CAN_ORDER_REFUND_NO;
                    }

                    // 已消费的不能退款
                    if ($hash_data[ $order_id ]['consume_status'] != \Sales_order_model::CONSUME_PENDING) {
                        $status = SeparateBilling::CAN_ORDER_REFUND_NO;
                    }

                    // 已转赠的不能退款
                    if ($hash_data[ $order_id ]['gift_status'] != \Sales_order_model::GIFT_PENDING) {
                        $status = SeparateBilling::CAN_ORDER_REFUND_NO;
                    }

                    // 7天退款的过了7天后不能退款
                    $order_time     = strtotime($hash_data[ $order_id ]['create_time']);
                    $seven_days_ago = strtotime(date('Y-m-d H:i:s', strtotime('-7 days')));
                    if ($hash_data[ $order_id ]['can_refund'] == \Sales_order_model::CAN_REFUND_STATUS_SEVEN
                        && $order_time < $seven_days_ago) {
                        $status = SeparateBilling::CAN_ORDER_REFUND_NO;
                    }

                    // 不是等待退款的不能退款
                    if ($hash_data[ $order_id ]['refund_status'] != \Sales_order_model::REFUND_PENDING) {
                        $status = SeparateBilling::CAN_ORDER_REFUND_NO;
                    }

                    // 全部退款的标识为已退款
                    if ($hash_data[ $order_id ]['status'] == \Sales_order_model::REFUND_ALL) {
                        $status = SeparateBilling::ORDER_AREADY_REFUND;
                    }

                    $info[ $order_id ] = [ 'order_id' => $order_id, 'refund_status' => $status ];
                } else {
                    $info[ $order_id ] = [];
                }
            }

            $result->setData(['info' => $info]);
            $result->setStatus(Result::STATUS_OK);

        } else {
            $result->setMessage('参数错误!');
        }

        return $result->toArray();
    }

    protected function buildShardConfig($inter_id = null)
    {
        $this->getCI()->load->model('soma/shard_config_model');
        $this->getCI()->current_inter_id = $inter_id;
        $this->getCI()->db_shard_config = $this->getCI()->shard_config_model->build_shard_config($inter_id);
    }

}