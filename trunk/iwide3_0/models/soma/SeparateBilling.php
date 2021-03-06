<?php

namespace App\models\soma;

/**
 * Class SeparateBilling
 * @package    App\models\soma
 * @author     fengzhongcheng  <fengzhongcheng@mofly.cn>
 */
class SeparateBilling extends \MY_Model_Soma
{
    /**
     * 分账记录状态：可以划款
     */
    const STATUS_CAN_PAY_YES   = 1;

    /**
     * 分账记录状态：等待确认
     */
    const STATUS_WAITING_CHECK = 2;

    /**
     * 分账记录状态：不可划款
     */
    const STATUS_CAN_PAY_NO    = 3;

    /**
     * 通票的酒店id
     */
    const MULITPLE_HOTEL_ID = '9999999';

    /**
     * 可以自动审核（如7天退款的订单7天后自动审核）
     */
    const CAN_AUTO_CHECK_YES = 1;
    
    /**
     * 不可自动审核
     */
    const CAN_AUTO_CHECK_NO  = 2;
    
    /**
     * 订单可退款
     */
    const CAN_ORDER_REFUND_YES = 1;

    /**
     * 订单不可退款
     */
    const CAN_ORDER_REFUND_NO  = 2;

    /**
     * 订单已退款
     */
    const ORDER_AREADY_REFUND  = 3;

    protected $db_conn_active;

    public function __construct($db_conn = null)
    {
        if (!empty($db)) {
            $this->db_conn_active = $db_conn;
        } else {
            $this->db_conn_active = $this->soma_db_conn;
        }
    }

    public function setActiveDb($db_conn)
    {
        $this->db_conn_active = $db_conn;
    }

    public function getActviveDb()
    {
        return $this->db_conn_active;
    }

    public function table_name($inter_id = null)
    {
        return $this->_shard_table('soma_sales_order_separate_billing', $inter_id);
    }

    public function table_primary_key()
    {
        return 'bill_id';
    }

    /**
     * 保存分账记录
     *
     * @param      array  $data   单个分账记录数据
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function saveBilling($data)
    {
        $table = $this->table_name();
        $pk    = $this->table_primary_key();

        if (empty($data[$pk])) {
            $this->db_conn_active->insert($table, $data);
        } else {
            $this->db_conn_active->where($pk, $data[$pk]);
            $this->db_conn_active->update($table, $data);
        }

        return $this->db_conn_active->affected_rows() === 1;
    }

    /**
     * 获取等待审核的订单信息
     *
     * @param      string  $check_point  截至时间点
     * @param      array   $order_ids    订单ids
     *
     * @return     array   等待审核订单信息
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getWattingCheckBilling($check_point = null, $order_ids = array())
    {
        if ($check_point === null) {
            if (ENVIRONMENT == 'production') {
                $check_point = date('Y-m-d H:i:s', strtotime('-7 days'));
            } else {
                $check_point = date('Y-m-d H:i:s', strtotime('-7 minutes'));
            }
        }

        $this->db_conn_active->where('hotel_id !=', self::MULITPLE_HOTEL_ID);
        $this->db_conn_active->where('payment_time <=', $check_point);
        $this->db_conn_active->where('can_auto_check', self::CAN_AUTO_CHECK_YES);
        $this->db_conn_active->where('status', self::STATUS_WAITING_CHECK);
        if (!empty($order_ids)) {
            $this->db_conn_active->where_in('order_id', $order_ids);
        }
        
        return $this->db_conn_active->get($this->table_name())->result_array();
    }

    /**
     * 批量保存分账记录信息
     *
     * @param      array    $data   分账记录信息
     *
     * @return     boolean  保存成功返回true，失败返回false.
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function batchSaveBilling($data)
    {
        $table = $this->table_name();
        $pk    = $this->table_primary_key();

        $insert = $update = array();
        foreach ($data as $item) {
            if (!empty($item[ $pk ])) {
                $update[] = $item;
            } else {
                $insert[] = $item;
            }
        }

        $insert_res = $update_res = true;
        if (!empty($insert)) {
            $insert_res = $this->db_conn_active->insert_batch($table, $insert);
        }
        if (!empty($update)) {
            $update_res = $this->db_conn_active->update_batch($table, $update, $pk);
        }

        return $insert_res && $update_res;
    }

    /**
     * 获取一个订单的分账信息
     *
     * @param      array|string  $order_id     订单id
     * @param      string        $check_point  开始检查时间点
     * @param      int           $status       分账状态
     *
     * @return     array         订单分账信息
     *
     * @author     fengzhongcheng <fengzhongcheng@mofly.cn>
     */
    public function getOrderBillingInfo($order_id, $check_point = null, $status = null)
    {
        if (is_array($order_id)) {
            $this->db_conn_active->where_in('order_id', $order_id);
        } else {
            $this->db_conn_active->where('order_id', $order_id);
        }

        if (!empty($check_point)) {
            $this->db_conn_active->where('bill_time >=', $check_point);
        }
        if (!empty($status)) {
            $this->db_conn_active->where('status', $status);
        }
        return $this->db_conn_active->get($this->table_name())->result_array();
    }

}
