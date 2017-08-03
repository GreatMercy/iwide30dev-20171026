<?php
use App\libraries\Iapi\CommonLib;

/**
 * Class MY_Front_Soma_Iapi
 * @author renshuai  <renshuai@mofly.cn>
 *
 *
 * @property Shard_config_model $shardConfigModel
 */
class MY_Front_Soma_Iapi extends MY_Front_Iapi
{
    /**
     * 常用页面链接
     * @var array
     */
    public $link;

    public $public_info;

    /**
     * MY_Front_Soma_Iapi constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->public_info = $this->public;

        $this->current_inter_id = $this->inter_id;
        $this->link = array(
            'home' => site_url('soma/package/index') . "?id=" . $this->inter_id,
            'product_link' => site_url('soma/package/package_detail') . "?id=" . $this->inter_id . '&pid=',
            'order_link' => site_url('soma/order/my_order_list') . "?id=" . $this->inter_id,
            'center_link' => site_url("membervip/center") . "?id=" . $this->inter_id,
            'prepay_link' => site_url("soma/package/package_pay"),
            // 订单中心
            'my_order_list' => site_url('iapi/soma/order/index') . "?" . http_build_query(['id' => $this->inter_id, 'type' => '']), // 我的订单(全部、待使用、已完成)
            'my_gift_list' => site_url('iapi/soma/order/gift_list') . "?id=" . $this->inter_id, // 我的礼物
            'detail_link' => site_url('soma/order/order_detail') . "?id=" . $this->inter_id . '&oid=', //  订单详情
            'delete_order_link' => site_url('iapi/soma/order/delete_order') . "?id=" . $this->inter_id . '&oid=', // 删除
            // 我的礼物
            'package_received' => site_url('soma/gift/package_received') .'?id=' . $this->inter_id .'&gid=', // 礼物详情
            'package_list_send' => site_url('soma/gift/package_list_send') .'?id=' . $this->inter_id .'&fans_saler=', // 送出礼物
            'package_list_received' => site_url('soma/gift/package_list_received') .'?id=' . $this->inter_id .'&fans_saler=', // 收到礼物
            // 订单明细
            'package_booking' => site_url('soma/consumer/package_booking') . '?' . http_build_query([
                    'id' => $this->inter_id, 'aiid' => '', 'aiidi' => 0, 'bsn' => 'package'
                ]), // 预约
            'package_usage' => site_url('soma/consumer/package_usage') . '?' . http_build_query([
                    'id' => $this->inter_id, 'aiid' => '', 'aiidi' => 0, 'bsn' => 'package'
                ]), // 验卷
            'package_send' => site_url('soma/gift/package_send') . '?' . http_build_query([
                    'id' => $this->inter_id, 'pid' => ''
                ]), // 转赠
            'package_detail' => site_url('soma/package/package_detail') . '?' . http_build_query([
                    'id' => $this->inter_id, 'aiid' => '', 'aiidi' => 0, 'group' => '',
                    'send_from' => '', 'send_order_id' => ''
                ]), // 订房
            'show_shipping_info' => site_url('soma/consumer/show_shipping_info') . '?' . http_build_query([
                    'oid' => '', 'bsn' => 'package', 'id' => $this->inter_id,
                ]), // 邮寄
            // 卷码相关
            'get_received_list' => site_url('soma/gift/get_received_list') . '?' . http_build_query([
                    'gid' => '', // iwide_soma_gift_order_1001.gift_id  || iwide_soma_gift_order_receiver_1001.gift_id
                    'id' => $this->inter_id, 'bsn' => 'package',
                ]), // 卷码 - 已赠送（赠送）
            'shipping_detail' => site_url('soma/consumer/shipping_detail') . '?' . http_build_query([
                    'spid' => '', // iwide_soma_consumer_shipping.shipping_id
                    'id' => $this->inter_id, 'bsn' => 'package',
                ]), // 卷码 - 已邮寄（邮寄）
            'package_review' => site_url('soma/consumer/package_review') . '?' . http_build_query([
                    'ciid' => '',
                    'id' => $this->inter_id, 'bsn' => 'package',
                ]), // 卷码 - 已使用（消费）
            'refund_index_link' => site_url('soma/refund/apply')."?id=".$this->inter_id.'&oid='
        );

    }

    /**
     * @param $method
     * @param array $params
     * @return mixed
     * @author renshuai  <renshuai@jperation.cn>
     *
     */
    public function _remap($method, $params = array())
    {
        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $method = "{$requestMethod}_{$method}";

        if (method_exists($this, $method)) {
            //数据库链接
            $this->load->somaDatabase($this->db_soma);
            $this->load->somaDatabaseRead($this->db_soma_read);
            //初始化数据库分片配置
            $this->load->model('soma/shard_config_model', 'shardConfigModel');
            $this->db_shard_config = $this->shardConfigModel->build_shard_config($this->inter_id);

            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404('api not found');
        }
    }

    /**
     * @param $result
     * @param $msg
     * @param $data
     * @param $fun
     * @param $extra
     * @param $msg_lv
     * @author renshuai  <renshuai@jperation.cn>
     */
    public function json($result, $msg = '', $data = array(), $fun = '', $extra = array(), $msg_lv = 0)
    {
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(CommonLib::create_put_msg('jwx', $result, $msg, $data, $fun, $extra, $msg_lv)));
    }

    /**
     * Gets the redis instance.
     *
     * @param      string $select The select
     *
     * @return     Redis|null  The redis instance.
     */
    public function get_redis_instance($select = 'soma_redis')
    {
        $this->load->library('Redis_selector');
        if ($redis = $this->redis_selector->get_soma_redis($select)) {
            return $redis;
        }

        return null;
    }

}