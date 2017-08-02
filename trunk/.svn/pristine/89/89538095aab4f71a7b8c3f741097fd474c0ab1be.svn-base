<?php
/**
 * table iwide_soma_sales_order
 *
 * @SWG\Definition(type="object", @SWG\Xml(name="SomaSalesOrder"))
 */
class SomaSalesOrder
{
    /**
     * @var string $order_id
     * @SWG\Property(type="string", description="订单号")
     */
    public $order_id;

    /**
     * @var string $create_time
     * @SWG\Property(type="string", description="创建时间")
     */
    public $create_time;

    /**
     * @var string $status
     * @SWG\Property(enum={12}, type="string", description="订单状态, 12 购买成功")
     */
    public $status;

    /**
     * @var string $item_name
     * @SWG\Property(type="string", description="商品名称")
     */
    public $item_name;

    /**
     * @var string $real_grand_total
     * @SWG\Property(type="string", description="付款金额")
     */
    public $real_grand_total;

    /**
     * @var string $row_qty
     * @SWG\Property(type="string", description="购买数量")
     */
    public $row_qty;

    /**
     * @var string $consume_status
     * @SWG\Property(enum={21,22,23}, type="string", description="消费状态, 21: 未消费, 22: 部分消费, 23: 消费完毕")
     */
    public $consume_status;

    /**
     * @var string $refund_status
     * @SWG\Property(enum={31, 32, 33}, type="string", description="退款标记, 31: 无退款, 32: 部分退款, 33 全部退款")
     */
    public $refund_status;

    /**
     * @var SomaSalesOrderItem[]
     * @SWG\Property(@SWG\Xml(name="package", wrapped=true))
     */
    public $package;
}