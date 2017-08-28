<?php
use App\libraries\Iapi\BaseConst;
use App\libraries\Iapi\FrontConst;
use App\libraries\Support\Log;
use App\services\Result;
use App\services\soma\ExpressService;
use App\services\soma\OrderService;
use App\services\soma\ScopeDiscountService;
use App\services\soma\PackageService;
use App\libraries\Support\Collection;
use App\services\soma\KillsecService;


/**
 * Class Order
 * @author renshuai  <renshuai@mofly.cn>
 *
 *
 * @property Sales_order_model $salesOrderModel
 */
class Order extends MY_Front_Soma_Iapi
{

    /**
     * @var array
     */
    public $wft_pay_inter_ids = [
        'a479457264',//厦门海旅温德姆至尊酒店
        'a482210445',//厦门帝元维多利亚大酒店
        'a489326393',//都江堰紫坪铺滑翔伞飞行营地
        'a494820079',//成都群光君悦酒店
        'a496652649',//株洲万豪
        'a497580480',// 苏州吴宫泛太平洋酒店
        'a499046681',
        'a492763532',
        //'a498545803',
        'a484533415',
        'a498095405',
    ];


    /**
     * @SWG\Get(
     *        path="/order/index",
     *        summary="订单列表",
     *        tags={"order"},
     *        @SWG\Parameter(
     *            description="第几页",
     *            in="query",
     *            name="page",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="每页行数",
     *            in="query",
     *            name = "page_size",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="菜单类型 1 全部 2 未使用 3 已完成",
     *            in="query",
     *            name = "type",
     *            required=true,
     *            type="integer"
     *        ),
     *         @SWG\Response(
     *              response=400,
     *              description="page or page_size not get",
     *        ),
     *         @SWG\Response(
     *              response=200,
     *              description="订单列表",
     *              @SWG\Schema(
     *                   type="object",
     *                   @SWG\Property(
     *                       property="products",
     *                       description="商品列表",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaSalesOrder")
     *                   ),
     *                   @SWG\Property(
     *                       property="code",
     *                       description="卷码",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaCustomerCode")
     *                   ),
     *                   @SWG\Property(
     *                        property="page_resource",
     *                        description="分页信息和页面链接",
     *                        type="object",
     *                        @SWG\Property(
     *                         property="page",
     *                         description="第几页",
     *                         type = "integer",
     *                        ),
     *                        @SWG\Property(
     *                         property="size",
     *                         description="每页多少行",
     *                         type = "integer",
     *                        ),
     *                        @SWG\Property(
     *                         property="count",
     *                         description="总条数",
     *                         type = "integer",
     *                        ),
     *                        @SWG\Property(
     *                             property="link",
     *                             description="页面链接",
     *                             type="object",
     *                             @SWG\Property(
     *                                  property="all",
     *                                  description="全部",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="pending_use",
     *                                  description="待使用",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="completed",
     *                                  description="已完成",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="detail",
     *                                  description="订单详情，需要拼接order_id",
     *                                  type = "string",
     *                             ),
     *                              @SWG\Property(
     *                                  property="del_order",
     *                                  description="删除，需要参考（接口：DELETE /order/index)",
     *                                  type = "string",
     *                             ),
     *                              @SWG\Property(
     *                                  property="product_link",
     *                                  description="商品详细，需要拼接product_id",
     *                                  type = "string",
     *                             ),
     *                        ),
     *                   ),
     *              ),
     *         ),
     *    )
     *
     */

    public function get_index()
    {
        $openid = $this->openid;
        $input = $this->input;
        $pageSize = $input->get('page_size', null, 0);
        $page = $input->get('page', null, 0);
        $type = $input->get('type', null, 1);
        if (empty($pageSize) || empty($page) || empty($type)) {
            show_error('page or page_size not get', 400);
        }
        $result = OrderService::getInstance()->getOrderList($openid, $type, [
            'limit' => (int)$pageSize,
            'offset' => ($page - 1) * $pageSize,
            'page' => (int)$page
        ]);
        $result_data = $result->getData();
        $data['products'] = isset($result_data['data']) ? $result_data['data'] : [];
        $data['page_resource'] = [
            'link' => [
                'all' => $this->link['my_order_list'] . 1,
                'pending_use' => $this->link['my_order_list'] . 2,
                'completed' => $this->link['my_order_list'] . 3,
                //'gift' => $this->link['my_gift_list'],
                'detail' => $this->link['detail_link'],
                'del_order' => $this->link['delete_order_link'],
                'product_link' => $this->link['product_link'],
            ],
            'count' => isset($result_data['total']) ? $result_data['total'] : 0,
            'size' => $pageSize,
            'page' => $page,
        ];
        $this->json(FrontConst::OPER_STATUS_SUCCESS, 'msg', $data);
    }

    /**
     * @SWG\Get(
     *        path="/order/gift_list",
     *        summary="我的礼物",
     *        tags={"order"},
     *        deprecated=true,
     *        @SWG\Parameter(
     *            description="第几页",
     *            in="query",
     *            name="page",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="每页行数",
     *            in="query",
     *            name = "page_size",
     *            required=true,
     *            type="integer"
     *        ),
     *         @SWG\Response(
     *              response=400,
     *              description="page or page_size not get",
     *        ),
     *         @SWG\Response(
     *              response=200,
     *              description="我的礼物",
     *              @SWG\Schema(
     *                   type="object",
     *                   @SWG\Property(
     *                       property="products",
     *                       description="礼物列表",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaGiftOrder")
     *                   ),
     *                   @SWG\Property(
     *                        property="page_resource",
     *                        description="分页信息和页面链接",
     *                        type="object",
     *                        @SWG\Property(
     *                         property="page",
     *                         description="第几页",
     *                         type = "integer",
     *                        ),
     *                        @SWG\Property(
     *                         property="size",
     *                         description="每页多少行",
     *                         type = "integer",
     *                        ),
     *                        @SWG\Property(
     *                         property="count",
     *                         description="总条数",
     *                         type = "integer",
     *                        ),
     *                        @SWG\Property(
     *                             property="link",
     *                             description="页面链接",
     *                             type="object",
     *                             @SWG\Property(
     *                                  property="package_received",
     *                                  description="礼物详情，需要拼接 gid",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="package_list_send",
     *                                  description="送出礼物",
     *                                  type = "string",
     *                             ),
     *                              @SWG\Property(
     *                                  property="package_list_received",
     *                                  description="收到礼物",
     *                                  type = "string",
     *                             )
     *                        ),
     *                   ),
     *              ),
     *         ),
     *    )
     *
     */
    public function get_gift_list()
    {
        $openid = $this->openid;
        $input = $this->input;
        $pageSize = $input->get('page_size', null, 0);
        $page = $input->get('page', null, 0);
        $type = $input->get('type', null, 1);
        if (empty($openid) || empty($pageSize) || empty($page) || empty($type)) {
            show_error('page or page_size not get', 400);
        }
        $result = OrderService::getInstance()->getGiftList($openid, $type, [
            'limit' => $pageSize,
            'offset' => ($page - 1) * $pageSize,
            'page' => $page
        ]);
        $result_data = $result->getData();
        $data['products'] = isset($result_data['data']) ? $result_data['data'] : [];
        $data['page_resource'] = [
            'link' => [
                'package_received' => $this->link['package_received'], // 礼物详情
                'package_list_send' => $this->link['package_list_send'], // 送出礼物
                'package_list_received' => $this->link['package_list_received'], // 收到礼物
            ],
            'count' => isset($result_data['total']) ? $result_data['total'] : 0,
            'size' => $pageSize,
            'page' => $page,
        ];
        $this->json(FrontConst::OPER_STATUS_SUCCESS, 'msg', $data);
    }

    /**
     * @SWG\Get(
     *        path="/order/detail",
     *        summary="订单详情",
     *        tags={"order"},
     *        @SWG\Parameter(
     *            description="订单ID",
     *            in="query",
     *            name="oid",
     *            required=true,
     *            type="integer"
     *        ),
     *         @SWG\Response(
     *              response=400,
     *              description="order_id not get || order not get",
     *        ),
     *         @SWG\Response(
     *              response=200,
     *              description="订单详情",
     *              @SWG\Schema(
     *                   type="object",
     *                   @SWG\Property(
     *                       property="products",
     *                       description="商品列表",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaSalesOrder")
     *                   ),
     *                    @SWG\Property(
     *                       property="code",
     *                       description="卷码",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaCustomerCode")
     *                   ),
     *                    @SWG\Property(
     *                       property="public",
     *                       description="公众号信息",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/IwideHotel")
     *                   ),
     *                   @SWG\Property(
     *                        property="page_resource",
     *                        description="分页信息和页面链接",
     *                        type="object",
     *                        @SWG\Property(
     *                             property="link",
     *                             description="页面链接",
     *                             type="object",
     *                             @SWG\Property(
     *                                  property="get_received_list",
     *                                  description="卷码 - 已赠送，需要拼接 gid [status = 4]",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="shipping_detail",
     *                                  description="卷码 - 已邮寄，需要拼接 spid[shipping_id] [status = 3，并且 shipping_id != 0]",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="package_review",
     *                                  description="卷码 - 已使用，需要拼接 ciid[consumer_item_id] [status = 3, 并且 shipping_id = 0] 和 aiid[asset_item_id] 和 自行拼接：code_id[code_id]",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="package_booking",
     *                                  description="预约 - 需要拼接值 aiid[asset_item_id] 和 自行拼接：code_id[code_id]",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="package_usage",
     *                                  description="验卷 - 需要拼接 aiid[asset_item_id] 和 自行拼接：code_id[code_id]",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="package_send",
     *                                  description="转赠 - 需要拼接 aiid[asset_item_id] 和 oid[order_id]",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="package_detail",
     *                                  description="商品详细 - 需要拼接 pid[product_id]",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="wx_select_hotel",
     *                                  description="订房 - 打开页面，需要再调用api（接口: GET /order/wx_select_hotel）",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="show_shipping_info",
     *                                  description="邮寄 - 需要拼接 oid[order_id]",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="del_order",
     *                                  description="删除，需要参考（接口：DELETE /order/index)",
     *                                  type = "string",
     *                             ),
     *                             @SWG\Property(
     *                                  property="refund_index",
     *                                  description="申请退款，需要拼接order_id",
     *                                  type = "string",
     *                             ),
     *                        ),
     *                   ),
     *              ),
     *         ),
     *    )
     *
     */
    public function get_detail()
    {
        $input = $this->input;
        $openid = $this->openid;
        $inter_id = $this->inter_id;
        $oid = $input->get('oid', null, null);
        if (empty($oid)) {
            show_error('order_id not get', 400);
        }
        $result = OrderService::getInstance()->getOrderDetail($oid, $openid, $inter_id);
        $result_data = $result->getData();
        $data = isset($result_data['data']) ? $result_data['data'] : [];
        // 取出aiid
        // 第一个未消费的卷码
        $aiid = '';
        if (isset($data['code'])) {
            foreach ($data['code'] as $v) {
                if ($v['status'] == Consumer_code_model::STATUS_SIGNED) {
                    $aiid = $v['asset_item_id'];
                    break;
                }
            }
        }
        $data['page_resource'] = [
            'link' => [
                'package_booking' => sprintf(urldecode($this->link['package_booking']), $aiid), // 预约
                'package_usage' => sprintf(urldecode($this->link['package_usage']), $aiid), // 验卷
                'package_send' => sprintf(urldecode($this->link['package_send']), $aiid), // 转赠
                'package_detail' => $this->link['package_detail'], // 商品详细
                'wx_select_hotel' => $this->link['wx_select_hotel_link'], // 订房
                'show_shipping_info' => $this->link['show_shipping_info'], // 邮寄
                'get_received_list' => $this->link['get_received_list'], // 卷码 - 已赠送（赠送）
                'shipping_detail' => $this->link['shipping_detail'], // 卷码 - 已邮件（邮寄）
                'package_review' => $this->link['package_review'], //  卷码 - 已使用（消费）
                'del_order' => $this->link['delete_order_link'], // 订单删除
                'refund_index' => $this->link['refund_index'], // 退款首页
            ],
        ];
        if ($result->getStatus() !== Result::STATUS_OK) {
            $this->json(FrontConst::OPER_STATUS_FAIL_TOAST, $result->getMessage(), $data);
        } else {
            $this->json(FrontConst::OPER_STATUS_SUCCESS, 'msg', $data);
        }
    }

    /**
     * @SWG\Delete(
     *        path="/order/index",
     *        summary="删除订单",
     *        tags={"order"},
     *        @SWG\Parameter(
     *            description="订单ID",
     *            in="query",
     *            name="oid",
     *            required=true,
     *            type="integer"
     *        ),
     *         @SWG\Response(
     *              response=400,
     *              description="删除失败",
     *        ),
     *         @SWG\Response(
     *              response=200,
     *              description="订单列表",
     *              @SWG\Schema(
     *                   type="object",
     *                   @SWG\Property(
     *                        property="page_resource",
     *                        description="分页信息和页面链接",
     *                        type="object",
     *                        @SWG\Property(
     *                             property="link",
     *                             description="页面链接",
     *                             type="object",
     *                             @SWG\Property(
     *                                  property="order",
     *                                  description="订单中心 (需要在删除提示成功，然后跳转到订单中心)",
     *                                  type = "string",
     *                             ),
     *                        ),
     *                   ),
     *              ),
     *         ),
     *    )
     *
     */
    public function delete_index()
    {
        $oid = $this->input->get('oid');
        if (empty($oid)) {
            show_error('order_id not get', 400);
        }
        $result = OrderService::getInstance()->getDelete($oid);
        if ($result->getStatus() !== Result::STATUS_OK) {
            $this->json(FrontConst::OPER_STATUS_FAIL_TOAST, $result->getMessage());
        } else {
            $data['page_resource'] = [
                'link' => [
                    'order' => $this->link['order_link'],
                ],
            ];
            $this->json(FrontConst::OPER_STATUS_SUCCESS, '', $data);
        }
    }

    /**
     * @SWG\Get(
     *        path="/order/package_booking",
     *        summary="预约",
     *        tags={"order"},
     *        @SWG\Parameter(
     *            description="资产细单ID",
     *            in="query",
     *            name="aiid",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="卷码ID",
     *            in="query",
     *            name="code_id",
     *            required=true,
     *            type="integer"
     *        ),
     *         @SWG\Response(
     *              response=400,
     *              description="aiid not get",
     *        ),
     *         @SWG\Response(
     *              response=200,
     *              description="预 约",
     *              @SWG\Schema(
     *                   type="object",
     *                   @SWG\Property(
     *                       property="products",
     *                       description="商品信息",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaSalesOrderItem")
     *                   ),
     *                    @SWG\Property(
     *                       property="code",
     *                       description="卷 码",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaCustomerCode")
     *                   ),
     *              ),
     *         ),
     *    )
     *
     */
    public function get_package_booking()
    {
        $input = $this->input;
        $inter_id = $this->inter_id;
        $openid = $this->openid;
        $aiid = $input->get('aiid', null, null);
        $code_id = $input->get('code_id', null, null);
        if (empty($aiid)) {
            show_error('aiid not get', 400);
        }
        if(empty($code_id)){
            show_error('code_id not get', 400);
        }

        $result = OrderService::getInstance()->getPackageInfo($aiid, $openid, $inter_id, $code_id);
        $result_data = $result->getData();
        $data = isset($result_data['data']) ? $result_data['data'] : [];
        if ($result->getStatus() !== Result::STATUS_OK) {
            $this->json(FrontConst::OPER_STATUS_FAIL_TOAST, $result->getMessage(), $data);
        } else {
            $this->json(FrontConst::OPER_STATUS_SUCCESS, 'msg', $data);
        }
    }

    /**
     * @SWG\Get(
     *        path="/order/package_usage",
     *        summary="验卷",
     *        tags={"order"},
     *        @SWG\Parameter(
     *            description="资产细单ID",
     *            in="query",
     *            name="aiid",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="卷码ID",
     *            in="query",
     *            name="code_id",
     *            required=true,
     *            type="integer"
     *        ),
     *         @SWG\Response(
     *              response=400,
     *              description="aiid not get",
     *        ),
     *         @SWG\Response(
     *              response=200,
     *              description="验卷",
     *              @SWG\Schema(
     *                   type="object",
     *                   @SWG\Property(
     *                       property="products",
     *                       description="商品信息",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaSalesOrderItem")
     *                   ),
     *                    @SWG\Property(
     *                       property="code",
     *                       description="卷码",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaCustomerCode")
     *                   ),
     *                   @SWG\Property(
     *                        property="page_resource",
     *                        description="分页信息和页面链接",
     *                        type="object",
     *                        @SWG\Property(
     *                             property="link",
     *                             description="页面链接",
     *                             type="object",
     *                             @SWG\Property(
     *                                  property="package_detail",
     *                                  description="订房 - 需要拼接 product_id",
     *                                  type = "string",
     *                             ),
     *                        ),
     *                   ),
     *              ),
     *         ),
     *    )
     *
     */
    public function get_package_usage()
    {
        $input = $this->input;
        $openid = $this->openid;
        $inter_id = $this->inter_id;
        $aiid = $input->get('aiid', null, null);
        $code_id = $input->get('code_id', null, null);

        if (empty($aiid)) {
            show_error('aiid not get', 400);
        }
        if (empty($code_id)) {
            show_error('code_id not get', 400);
        }
        $result = OrderService::getInstance()->getPackageInfo($aiid, $openid, $inter_id, $code_id);
        $result_data = $result->getData();
        $data = isset($result_data['data']) ? $result_data['data'] : [];

        if ($result->getStatus() !== Result::STATUS_OK) {
            $this->json(FrontConst::OPER_STATUS_FAIL_TOAST, $result->getMessage(), $data);
        } else {
            $data['page_resource'] = [
                'link' => [
                    'package_detail' => $this->link['package_detail'], // 订房
                    // todo 核销的接口
                ],
            ];
            $this->json(FrontConst::OPER_STATUS_SUCCESS, '', $data);
        }
    }

    /**
     * @SWG\Get(
     *        path="/order/order_record",
     *        summary="交易快照",
     *        tags={"order"},
     *        deprecated=true,
     *        @SWG\Parameter(
     *            description="订单ID",
     *            in="query",
     *            name="oid",
     *            required=true,
     *            type="integer"
     *        ),
     *         @SWG\Response(
     *              response=400,
     *              description="order_id not get || order not get",
     *        ),
     *         @SWG\Response(
     *              response=200,
     *              description="交易快照",
     *              @SWG\Schema(
     *                   type="object",
     *                   @SWG\Property(
     *                       property="products",
     *                       description="商品列表",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaSalesOrder")
     *                   ),
     *                    @SWG\Property(
     *                       property="public",
     *                       description="公众号信息",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/IwideHotel")
     *                   ),
     *                   @SWG\Property(
     *                        property="page_resource",
     *                        description="分页信息和页面链接",
     *                        type="object",
     *                        @SWG\Property(
     *                             property="link",
     *                             description="页面链接",
     *                             type="object",
     *                             @SWG\Property(
     *                                  property="package_detail",
     *                                  description="商品详细 - 需要拼接 product_id",
     *                                  type = "string",
     *                             ),
     *                        ),
     *                   ),
     *              ),
     *         ),
     *    )
     *
     */
    public function get_order_record()
    {
        $input = $this->input;
        $openid = $this->openid;
        $inter_id = $this->inter_id;
        $oid = $input->get('oid', null, null);

        if (empty($oid)) {
            show_error('order not get', 400);
        }
        $result = OrderService::getInstance()->getOrderRecord($oid, $inter_id, $openid);
        if ($result->getStatus() !== Result::STATUS_OK) {
            $this->json(FrontConst::OPER_STATUS_FAIL_TOAST, $result->getMessage(), []);
        } else {
            $data = $result->getData();
            $data['page_resource'] = [
                'link' => [
                    'package_detail' => $this->link['package_detail'], // 订房
                ],
            ];
            $this->json(FrontConst::OPER_STATUS_SUCCESS, '', $data);
        }
    }

    /**
     * @SWG\Get(
     *        path="/order/wx_select_hotel",
     *        summary="微信订房 - 选酒店房型",
     *        tags={"order"},
     *        @SWG\Parameter(
     *            description="订单ID",
     *            in="query",
     *            name="oid",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="资产ID",
     *            in="query",
     *            name="aiid",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="资产ID序号",
     *            in="query",
     *            name="aiidi",
     *            default="0",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="查询条件",
     *            in="query",
     *            name="search",
     *            required=false,
     *            type="integer"
     *        ),
     *         @SWG\Response(
     *              response=400,
     *              description="order_id not get || aiid not get",
     *        ),
     *         @SWG\Response(
     *              response=200,
     *              description="微信订房",
     *              @SWG\Schema(
     *                   type="object",
     *                   @SWG\Property(
     *                       property="products",
     *                       description="商品列表",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaSalesOrderItem")
     *                   ),
     *                   @SWG\Property(
     *                        property="page_resource",
     *                        description="分页信息和页面链接",
     *                        type="object",
     *                        @SWG\Property(
     *                             property="link",
     *                             description="页面链接",
     *                             type="object",
     *                             @SWG\Property(
     *                                  property="select_hotel_time",
     *                                  description="价格日历 - 需要拼接参数(aiid aiidi oid hid cdid)",
     *                                  type = "string",
     *                             ),
     *                        ),
     *                   ),
     *              ),
     *         ),
     *    )
     *
     */
    public function get_wx_select_hotel()
    {
        $input = $this->input;
        $openid = $this->openid;
        $inter_id = $this->inter_id;
        $oid = $input->get('oid', null, null);
        $aiid = $input->get('aiid', null, null);
        $aiidi = $input->get('aiidi', null, null);
        $search = $input->get('search', null, null);

        if (empty($oid) || empty($aiid)) {
            show_error('order not get', 400);
        }
        $result = OrderService::getInstance()->getWxSelectHotel($oid, $aiid, $inter_id, $search);
        $data = $result->getData();
        $data['page_resource'] = [
            'link' => [
                'select_hotel_time' => $this->link['select_hotel_time']
            ],
        ];
        if ($result->getStatus() !== Result::STATUS_OK) {
            $this->json(FrontConst::OPER_STATUS_FAIL_TOAST, $result->getMessage(), $data);
        } else {
            $this->json(FrontConst::OPER_STATUS_SUCCESS, '', $data);
        }
    }

    /**
     * @SWG\Get(
     *        path="/order/select_hotel_info",
     *        summary="微信订房 - 价格日历 - 信息",
     *        tags={"order"},
     *        @SWG\Parameter(
     *            description="资产ID",
     *            in="query",
     *            name="aiid",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="资产ID序号",
     *            in="query",
     *            name="aiidi",
     *            default="0",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="公众号ID",
     *            in="query",
     *            name="id",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="酒店ID",
     *            in="query",
     *            name="hid",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="房间ID",
     *            in="query",
     *            name="rmid",
     *            required=true,
     *            type="integer"
     *        ),
     *         @SWG\Response(
     *              response=400,
     *              description="order_id or hotel_id or room_id or price_code not get",
     *        ),
     *         @SWG\Response(
     *              response=200,
     *              description="微信订房",
     *              @SWG\Schema(
     *                   type="object",
     *                   @SWG\Property(
     *                       property="hotel",
     *                       description="酒店信息",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/IwideHotel")
     *                   ),
     *                   @SWG\Property(
     *                       property="room",
     *                       description="房间信息",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/IwideHotelRooms")
     *                   ),
     *                   @SWG\Property(
     *                       property="customer",
     *                       description="客人信息",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaCustomerContact")
     *                   ),
     *                   @SWG\Property(
     *                       property="code",
     *                       description="卷码信息",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/SomaCustomerCode")
     *                   ),
     *                   @SWG\Property(
     *                       property="price_code",
     *                       description="房价码信息",
     *                       type = "array",
     *                       @SWG\Items(ref="#/definitions/IwideHotelPriceInfo")
     *                   ),
     *                   @SWG\Property(
     *                        property="page_resource",
     *                        description="页面链接",
     *                        type="object",
     *                        @SWG\Property(
     *                             property="link",
     *                             description="页面链接",
     *                             type="object",
     *                             @SWG\Property(
     *                                  property="booking",
     *                                  description="提交预订,需要post提交",
     *                                  type = "string",
     *                             ),
     *                        ),
     *                   ),
     *              ),
     *         ),
     *    )
     *
     */
    public function get_select_hotel_info()
    {
        $input = $this->input;
        $openid = $this->openid;
        $interId = $this->inter_id;
        $hotelId = $input->get('hid', null, null);
        $roomId = $input->get('rmid', null, null);
        $priceCode = $input->get('cdid', null, null);
        $aiid = $input->get('aiid', null, null);
        $aiidi = $input->get('aiidi', null, null);
        if (empty($aiid)) {
            show_error('hotel_id or room_id or price_code not get', 400);
        }
        $result = OrderService::getInstance()->getSelectHotelInfo($aiid, $aiidi, $interId, $openid, $hotelId, $roomId, $priceCode);
        $data = $result->getData();
        if ($result->getStatus() !== Result::STATUS_OK) {
            $this->json(FrontConst::OPER_STATUS_FAIL_TOAST, $result->getMessage(), $data);
        } else {
            $data['page_resource'] = [
                'link' => [
                    'booking' => $this->link['booking_link'], // 订房
                ],
            ];
            $this->json(FrontConst::OPER_STATUS_SUCCESS, 'msg', $data);
        }
    }

    /**
     * @SWG\Get(
     *        path="/order/select_hotel_time",
     *        summary="微信订房 - 价格日历 - 日历可预订时间",
     *        tags={"order"},
     *        @SWG\Parameter(
     *            description="公众号ID",
     *            in="query",
     *            name="id",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="订单ID",
     *            in="query",
     *            name="oid",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="酒店ID",
     *            in="query",
     *            name="hid",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="房间ID",
     *            in="query",
     *            name="rmid",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="价格ID",
     *            in="query",
     *            name="cdid",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="年份",
     *            in="query",
     *            name="year",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="月份",
     *            in="query",
     *            name="month",
     *            required=true,
     *            type="integer"
     *        ),
     *         @SWG\Response(
     *              response=400,
     *              description="order_id or hotel_id or room_id or price_code not get",
     *        ),
     *         @SWG\Response(
     *              response=200,
     *              description="微信订房",
     *              @SWG\Schema(
     *                   type="object",
     *                   @SWG\Property(
     *                       property="data",
     *                       description="不可预订日期",
     *                       type = "array",
     *                   ),
     *              ),
     *         ),
     *    )
     *
     */
    public function get_select_hotel_time()
    {
        $input = $this->input;
        $openid = $this->openid;
        $interId = $this->inter_id;
        $orderId = $input->get('oid', null, null);
        $aiid = $input->get('aiid', null, null);
        $aiidi = $input->get('aiidi', null, null);
        $hotelId = $input->get('hid', null, null);
        $roomId = $input->get('rmid', null, null);
        $priceCode = $input->get('cdid', null, null);
        $year = $input->get('year', null, date('Y'));
        $month = $input->get('month', null, date('m'));
        if (empty($orderId) || empty($aiid) || empty($hotelId) || empty($roomId) || empty($priceCode)) {
            show_error('order_id or hotel_id or room_id or price_code not get', 400);
        }
        if ($month > 12) {
            show_error('月份有误', 400);
        }
        $result = OrderService::getInstance()->getSelectHotelTime($orderId, $hotelId, $roomId, $priceCode, $year, $month, $interId, $openid);
        $data = $result->getData();
        if ($result->getStatus() !== Result::STATUS_OK) {
            $this->json(FrontConst::OPER_STATUS_FAIL_TOAST, $result->getMessage(), $data);
        } else {
            $this->json(FrontConst::OPER_STATUS_SUCCESS, 'msg', $data);
        }
    }

    /**
     * @SWG\Post(
     *        path="/order/booking",
     *        summary="微信订房 - 下单",
     *        tags={"order"},
     *        @SWG\Parameter(
     *            description="订单ID",
     *            in="formData",
     *            name="post_order_id",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="酒店ID",
     *            in="formData",
     *            name="post_hotel_id",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="房间ID",
     *            in="formData",
     *            name="post_room_id",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="价格ID",
     *            in="formData",
     *            name="post_price_code",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="卷码",
     *            in="formData",
     *            name="post_code",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="预订人名字",
     *            in="formData",
     *            name="post_name",
     *            required=true,
     *            type="string"
     *        ),
     *        @SWG\Parameter(
     *            description="预订人手机号",
     *            in="formData",
     *            name="post_phone",
     *            required=true,
     *            type="string"
     *        ),
     *        @SWG\Parameter(
     *            description="订房开始时间",
     *            in="formData",
     *            name="post_start",
     *            required=true,
     *            type="string"
     *        ),
     *        @SWG\Parameter(
     *            description="订房结束时间",
     *            in="formData",
     *            name="post_end",
     *            required=true,
     *            type="string"
     *        ),
     *        @SWG\Parameter(
     *            description="房型名称",
     *            in="formData",
     *            name="post_room_name",
     *            required=true,
     *            type="string"
     *        ),
     *        @SWG\Parameter(
     *            description="价格代码名称",
     *            in="formData",
     *            name="post_code_name",
     *            required=true,
     *            type="string"
     *        ),
     *        @SWG\Parameter(
     *            description="资产ID",
     *            in="formData",
     *            name="aiid",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="资产ID序号",
     *            in="formData",
     *            name="aiidi",
     *            required=true,
     *            type="integer"
     *        ),
     *        @SWG\Parameter(
     *            description="下单房间数",
     *            in="formData",
     *            name="post_num",
     *            required=true,
     *            default="1",
     *            type="integer"
     *        ),
     *         @SWG\Response(
     *              response=200,
     *              description="微信订房",
     *              @SWG\Schema(
     *                   type="object",
     *                   @SWG\Property(
     *                        property="page_resource",
     *                        description="页面链接",
     *                        type="object",
     *                        @SWG\Property(
     *                             property="link",
     *                             description="页面链接",
     *                             type="object",
     *                             @SWG\Property(
     *                                  property="pay_success_stay",
     *                                  description="跳转到支付成功页面, 到成功页面展示需要参考接口(GET /package/success_pay
    购买成功 )",
     *                                  type = "string",
     *                             ),
     *                        ),
     *                   ),
     *              ),
     *         ),
     *    )
     *
     */
    public function post_booking()
    {
        $interId = $this->inter_id;
        $openid = $this->openid;
        $business = 'package';

        $orderId = $this->input->post('post_order_id'); // 订单ID
        $hotelId = $this->input->post('post_hotel_id'); // 酒店ID
        $roomId = $this->input->post('post_room_id'); // 房间ID
        $priceCode = $this->input->post('post_price_code'); // 房价码
        $code = $this->input->post('post_code'); // 卷码
        $name = $this->input->post('post_name');
        $phone = $this->input->post('post_phone');
        $start = $this->input->post('post_start');//订房开始时间
        $end = $this->input->post('post_end');//订房结束时间
        $room_name = $this->input->post('post_room_name');//房型名称
        $code_name = $this->input->post('post_code_name');//价格代码名称
        $assetItemId = $this->input->post('aiid');
        $aiidi = $this->input->post('aiidi');
        $num = $this->input->post('post_num');//选择多少间

        if (!$num || $num > 1) {
            $num = 1; //暂时只可订一间房
        }
        $result = OrderService::getInstance()->getBooking(get_defined_vars());
        $data = $result->getData();
        if ($result->getStatus() !== Result::STATUS_OK) {
            $this->json(FrontConst::OPER_STATUS_FAIL_TOAST, $result->getMessage(), $data);
        } else {
            $data['page_resource'] = [
                'link' => [
                    // 下单成功跳转的页面
                    'pay_success_stay' => $this->link['pay_success_stay_link'] . $orderId
                ],
            ];
            $this->json(FrontConst::OPER_STATUS_SUCCESS, '', $data);
        }
    }


    /**
     * 储值支付
     * @param $passwd
     * @param $order
     * @return array
     *
     */
    protected function balance_pay($passwd, $order)
    {
        $openid = $order->m_get('openid');
        $inter_id = $order->m_get('inter_id');
        $order_id = $order->m_get('order_id');

        try {
            $api = new Api_member($order->m_get('inter_id'));

            $result = $api->get_token();
            $api->set_token($result['data']);

            $balance_info = $api->balence_info($openid);
            $balance = isset($balance_info['data']) ? $balance_info['data'] : 0;
            if ($balance < $order->m_get('grand_total')) {
                // return json_encode(array('status' => Soma_base::STATUS_FALSE, 'message' => '储值余额不足！'));
                return array('status' => Soma_base::STATUS_FALSE, 'message' => '储值余额不足！');
            }

            $scale = $api->balence_scale($openid);
            $pay_total = $api->balence_scale_convert($scale, $order->m_get('grand_total'), false);
            $uu_code = rand(1000, 9999);

            $use_result['err'] = 1; // 默认调用失败

            $yinju_inter_ids = array('a457946152', 'a471258436');
            if (in_array($inter_id, $yinju_inter_ids)) {
                $use_result = (array)$api->yinju_balence_use($pay_total, $openid, $passwd, $uu_code, $order_id);
            } else {
                $use_result = (array)$api->balence_use($pay_total, $openid, $passwd, $uu_code, $order_id);
            }

            if ($use_result['err'] == 0) {
                return array('status' => Soma_base::STATUS_TRUE, 'message' => '');
            }

        } catch (Exception $e) {
            Log::error('balance_pay error' . $e->getMessage(), []);
        }

        return array('status' => Soma_base::STATUS_FALSE, 'message' => '订单信息错误！');
    }

    /**
     * @param $order
     * @return array
     * @author renshuai  <renshuai@jperation.cn>
     */
    protected function point_pay($order)
    {
        try {
            $inter_id = $order->m_get('inter_id');
            $open_id = $order->m_get('openid');
            $order_id = $order->m_get('order_id');

            $api = new Api_member($inter_id);
            $result = $api->get_token();
            $api->set_token($result['data']);

            $point_info = null;
            $point_info = $api->point_info($open_id);
            $point = isset($point_info['data']) ? $point_info['data'] : 0;
            if ($point < $order->m_get('grand_total')) {
                return array('status' => Soma_base::STATUS_FALSE, 'message' => '积分余额不足！');
            }

            $uu_code = rand(1000, 9999);
            // 积分支付必须是整数，上取整
            $pay_total = ceil($order->m_get('grand_total'));
            $pay_res = $api->point_use($pay_total, $open_id, $uu_code, $order_id, $order);

            if ($pay_res['err'] == 0) {
                return array('status' => Soma_base::STATUS_TRUE, 'message' => '');
            }
        } catch (Exception $e) {
            Log::error('point_pay error' . $e->getMessage(), []);
        }

        return array('status' => Soma_base::STATUS_FALSE, 'message' => '订单信息错误！');
    }

    /**
     * @param Sales_order_model $order
     * @param $payment
     * @param bool $save_flag
     * @return mixed
     * @author renshuai  <renshuai@jperation.cn>
     */
    protected function _inner_payment($order, $payment, $save_flag = true)
    {

        $result['status'] = Soma_base::STATUS_FALSE;
        $result['message'] = '订单支付失败';
        $result['step'] = 'fail';

        $log_data = array();
        $log_data['paid_ip'] = $this->input->ip_address();
        $log_data['paid_type'] = $payment['paid_type'];
        $log_data['order_id'] = $order->m_get('order_id');
        $log_data['openid'] = $order->m_get('openid');
        $log_data['business'] = $order->m_get('business');
        $log_data['settlement'] = $order->m_get('settlement');
        $log_data['inter_id'] = $order->m_get('inter_id');
        $log_data['hotel_id'] = $order->m_get('hotel_id');
        $log_data['grand_total'] = $order->m_get('grand_total');
        $log_data['transaction_id'] = isset($payment['trans_id']) ? $payment['trans_id'] : '';

        if ($order->order_payment($log_data)) {

            $order->order_payment_post($log_data);
            if ($save_flag) {
                $this->load->model('soma/Sales_payment_model', 'pay_model');
                $this->pay_model->save_payment($log_data);
            }
            $url_params = array(
                'id' => $order->m_get('inter_id'),
                'order_id' => $order->m_get('order_id')
            );
            $url = Soma_const_url::inst()->get_payment_package_success($url_params);
            $result['success_url'] = $url;
            $result['status'] = Soma_base::STATUS_TRUE;
            $result['message'] = '订单支付成功';
            $result['data'] = array('orderId' => $order->m_get('order_id'));
            $result['step'] = 'success';

        } else {

            Log::error('inner_payment order_payment return false', $log_data);

            $result['status'] = Soma_base::STATUS_FALSE;
            $result['message'] = '订单支付失败';
            $result['step'] = 'fail';
        }

        return $result;
    }


    /**
     * @SWG\Get(
     *     tags={"order"},
     *     path="/order/pay",
     *     summary="准备下单数据",
     *     description="跳至下单页面，所要获取相关数据",
     *     operationId="get_pay",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="商品id",
     *         in="query",
     *         name="pid",
     *         required=true,
     *         type="integer",
     *         format="int32",
     *     ),
     *     @SWG\Parameter(
     *         description="业务类型",
     *         in="query",
     *         name="btype",
     *         required=true,
     *         type="string",
     *         default="package"
     *     ),
     *    @SWG\Parameter(
     *         description="商品多规格id",
     *         in="query",
     *         name="psp_id",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         description="token，秒杀活动要传此参数",
     *         in="query",
     *         name="token",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="customer_info",
     *                  description="联系人信息",
     *                  type = "array",
     *                  @SWG\Items(ref="#/definitions/SomaCustomerContact")
     *              ),
     *              @SWG\Property(
     *                  property="coupons",
     *                  type="integer" ,
     *                  description="可用优惠券数量" ,
     *              ),
     *              @SWG\Property(
     *                  property="point",
     *                  type="integer" ,
     *                  description="可用积分" ,
     *              ),
     *              @SWG\Property(
     *                  property="balance",
     *                  type="object" ,
     *                  description="用户信息信息。money：储值金额；url：储值充值中心链接；password：某些公众号储值类型商品必须输入密码，0：不需要，1：需要" ,
     *              ),
     *              @SWG\Property(
     *                  property="psp_setting",
     *                  type="array" ,
     *                  description="多规格商品款式设置" ,
     *                  @SWG\Items(ref="#/definitions/SomaProductSpecificationSetting")
     *              ),
     *              @SWG\Property(
     *                  property="scope_product_link",
     *                  type="array" ,
     *                  description="判断是否使用价格配置的价格，如果使用的话就不能使用优惠券了" ,
     *              ),
     *              @SWG\Property(
     *                  property="product",
     *                  description="购买商品信息",
     *                  type="array" ,
     *                  @SWG\Items(ref="#/definitions/SomaPackage")
     *              ),
     *              @SWG\Property(
     *                  property="address",
     *                  description="邮寄地址",
     *                  type = "array",
     *                  @SWG\Items(ref="#/definitions/SomaCustomerAddress")
     *              ),
     *              @SWG\Property(
     *                  property="saler",
     *                  description="分销员信息",
     *                  type = "array",
     *                  @SWG\Items(ref="#/definitions/IwideHotelStaff")
     *              ),
     *              @SWG\Property(
     *                  property="count",
     *                  description="default：默认购买数量，limit：限制数量",
     *                  type = "array",
     *              ),
     *             @SWG\Property(
     *                  property="countdown",
     *                  description="支付倒计时：当前时间 + 5分钟",
     *                  type = "integer",
     *              ),
     *             @SWG\Property(
     *                  property="public_info",
     *                  description="公众号信息",
     *                  type = "object",
     *                  @SWG\Items(ref="#/definitions/IwidePublics")
     *              ),
     *             @SWG\Property(
     *                  property="create_order_params",
     *                  description="下单附加参数",
     *                  type = "object",
     *              )
     *
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid pid supplied"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Package not found"
     *     )
     * )
     */
    public function get_pay()
    {

        $data = [];

        $productId = $this->input->get('pid');
        $common = $this->input->get('common');

        if (empty($productId)) {
            show_error('Invalid pid supplied', 400);
        }

        $this->load->model('soma/Product_package_model', 'productPackageModel');
        $productPackageModel = $this->productPackageModel;
        $productDetail = $productPackageModel->get_product_package_detail_by_product_id($productId, $this->inter_id);

        //商品不存在
        if (!$productDetail) {
            show_404();
        }

        $productDetail = PackageService::getInstance()->composePackage([$productDetail], $this->inter_id, $this->openid, ['common' => $common])[0];

        //取出联系人和电话
        $data['customer_info'] = $productPackageModel->get_customer_contact(['openid' => $this->openid]);

        //读取购买人的可用券
        $this->load->library('Soma/Api_member');
        $api = new Api_member($this->inter_id);

        //储值类型商品读取购买人的储值信息
        $data['balance'] = ['money' => 0, 'url' => null, 'password' => false];
        if ($productDetail['type'] == Product_package_model::PRODUCT_TYPE_BALANCE) {
            $result = $api->get_token();
            $result['data'] = isset($result['data']) ? $result['data'] : array();
            $api->set_token($result['data']);
            $balance = $api->balence_info($this->openid);
            $balance['data'] = isset($balance['data']) ? $balance['data'] : 0;
            $data['balance']['money'] = $balance['data'];
            $data['balance']['url'] = $api->balence_deposit_url($this->inter_id);
        }
        if (in_array($this->inter_id, array('a457946152', 'a471258436', 'a450089706'))) {
            $data['balance']['password'] = Soma_base::STATUS_TRUE;
        }

        //积分商品拉取用户积分信息
        $data['point'] = 0;
        if ($productDetail['type'] == Product_package_model::PRODUCT_TYPE_POINT) {
            $result = $api->get_token();
            $result['data'] = isset($result['data']) ? $result['data'] : array();
            $api->set_token($result['data']);
            $point = $api->point_info($this->openid);
            $data['point'] = isset($point['data']) ? (int)$point['data'] : 0;
        }

        $this->load->helper('soma/time_calculate');
        $this->load->model('soma/Sales_rule_model');
        $this->load->model('soma/Sales_order_discount_model');
        $this->load->model('soma/Sales_order_model');


        //可用优惠券数量
        $result = $api->get_token();
        $result['data'] = isset($result['data']) ? $result['data'] : array();
        $api->set_token($result['data']);
        $result = $api->conpon_sign_list($this->openid);
        $result['data'] = isset($result['data']) ? $result['data'] : array();
        $data['coupons'] = count($result['data']);

        //支付倒计时（15分钟）
        $data['countdown'] = 300;

        //加载产品规格信息
        $data['psp_setting'] = [];
        $psp_sid = $this->input->get('psp_id');
        if ($psp_sid) {
            $data['psp_setting'] = PackageService::getInstance()->getSettingInfoByProductIdAndPspSid($this->inter_id, $productId, $psp_sid);
            if (!empty($data['psp_setting'])) {
                $productDetail['price_package'] = $data['psp_setting'][0]['specprice'];
            }
        }

        //判断是否使用价格配置的价格，如果使用的话就不能使用优惠券了
        $scope_product_link = ScopeDiscountService::getInstance()->useScopeDiscount($this->inter_id, $this->openid, $productDetail, $psp_sid);
        $data['scope_product_link'] = $scope_product_link;
        if (!empty($scope_product_link)) {
            $productDetail['price_package'] = $scope_product_link['price'];
        }

        //邮寄
        $userAddressList = array();
        if (isset($productDetail['can_mail']) && $productDetail['can_mail'] == Product_package_model::CAN_T) {
            $userAddressList = ExpressService::getInstance()->getUserAddressList($this->openid, $this->inter_id, null);
        }

        //最多买多少份
        $limitCount = 200;
        //秒杀
        $killsec = KillsecService::getInstance()->getInfo($productId);
        if ($killsec && $common != 1) {
            $limitCount = (int)$killsec['killsec_permax'];
        }

        //默认买多少份
        $defaultCount = 1;
//        $ruleId = null;
//        $this->load->model('soma/Sales_rule_model');
//        if ($productDetail['type'] != Product_package_model::PRODUCT_TYPE_POINT && empty($productDetail['scopes'])) {
//            //促销规则加载
//            $auto_rule = $this->Sales_rule_model->get_product_rule(array($productId), $this->inter_id, 'auto_rule');
//            $auto_rule_new = array();
//            if ($auto_rule && count($auto_rule) > 0) {
//                foreach ($auto_rule as $v) {
//                    $auto_rule_new[] = $v;
//                }
//            }
//            if(!empty($auto_rule_new)){
//                $ruleId = $auto_rule_new[0]['rule_id'];
//            }
//        }
//
//        $fix_rule = $this->Sales_rule_model->find(array('rule_id' => $ruleId));
//        if ($fix_rule && $fix_rule['lease_cost'] && $productDetail['price_package']) {
//            $fix_qty = $fix_rule['lease_cost'] / $productDetail['price_package'];
//            if ($fix_qty < 1) {
//                $fix_qty = 1;
//            } else {
//                if ($fix_qty > 1) {
//                    $fix_qty = ceil($fix_qty);
//                } else {
//                    $fix_qty = intval($fix_qty);
//                }
//            }
//
//            $defaultCount = $fix_qty > $limitCount ? $limitCount : $fix_qty;
//        }


        //公众号
        $data['public_info'] = ['name' => data_get($this->public_info, 'name')];

        //类型
        $settlement = 'default';
        if(!isset($attach['common']) || $attach['common'] != 1){
            if($productDetail['tag'] == $productPackageModel::PRODUCT_TAG_KILLSEC){
                $settlement = 'killsec';
            }
        }

        $data['count'] = ['default' => $defaultCount, 'limit' => $limitCount];
        $data['product'] = $productDetail;
        $data['address'] = $userAddressList;
        $data['create_order_params'] = [
            'settlement' => $settlement,
            'business' => 'package',
        ];

        $this->json(BaseConst::OPER_STATUS_SUCCESS, '', $data);
    }


    /**
     *
     * @SWG\Post(
     *     tags={"order"},
     *     path="/order/create",
     *     summary="下单",
     *     description="用户下单，例如：index.php?id=xxx&openid=xxx&business=package&settlement=default&product_id=123&qty=2&name=fanlaoshi&phone=666&act_id=110&inid=120&token=555&grid=222&type=add&mcid=2658915&quote_type=51&quote=120&password=12345&bpay_passwd=54321&u_type=-1&psp_setting=160&scope_product_link_id=&address_id=124",
     *     operationId="get_create",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="业务类型。商城默认：package",
     *         in="formData",
     *         name="business",
     *         required=true,
     *         type="string",
     *         default="package"
     *     ),
     *     @SWG\Parameter(
     *         description="结算类型。普通商品：default，秒杀商品：killsec",
     *         in="formData",
     *         name="settlement",
     *         required=true,
     *         type="string",
     *         default="default"
     *    ),
     *    @SWG\Parameter(
     *         description="商品id",
     *         in="query",
     *         name="product_id",
     *         required=true,
     *         type="integer",
     *    ),
     *    @SWG\Parameter(
     *         description="购买商品数量",
     *         in="query",
     *         name="qty",
     *         required=true,
     *         type="string",
     *    ),
     *    @SWG\Parameter(
     *         description="客户姓名",
     *         in="query",
     *         name="name",
     *         required=true,
     *         type="string",
     *    ),
     *    @SWG\Parameter(
     *         description="客户电话",
     *         in="query",
     *         name="phone",
     *         required=true,
     *         type="string",
     *    ),
     *    @SWG\Parameter(
     *         description="活动id。秒杀购买时传相应活动id，普通购买传空",
     *         in="query",
     *         name="act_id",
     *         required=false,
     *         type="integer",
     *    ),
     *    @SWG\Parameter(
     *         description="活动实例id。秒杀购买时传相应实例id，普通/拼团购买传空",
     *         in="query",
     *         name="inid",
     *         required=false,
     *         type="integer",
     *    ),
     *    @SWG\Parameter(
     *         description="秒杀活动下单资格token。秒杀购买时传相应token，普通/拼团购买传空",
     *         in="query",
     *         name="token",
     *         required=false,
     *         type="string",
     *    ),
     *    @SWG\Parameter(
     *         description="优惠券批量使用(选择优惠券后，取所选优惠券的member_card_id字段)",
     *         in="query",
     *         name="mcid",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="优惠类型。选择优惠券后，要传。说明：30表示积分抵扣，40表示资产抵扣，51表示满减，52表示满打折",
     *         in="query",
     *         name="quote_type",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         description="优惠金额 (确定)。选择优惠券后，要传",
     *         in="query",
     *         name="quote",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         description="积分/储值优惠规则时使用的支付密码，默认传空值过来，隐居必须传递储值密码",
     *         in="query",
     *         name="password",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="积分/储值作为支付方式时使用的支付密码，默认传空值过来，隐居必须传递储值密码",
     *         in="query",
     *         name="bpay_passwd",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="特权券（膨胀券）商品特有的使用方式，1送自己，2送朋友，-1无使用方式",
     *         in="query",
     *         name="u_type",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         description="多规格id",
     *         in="query",
     *         name="psp_setting",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         description="专属价id。该项判断是否使用价格配置的价格，如果使用的话就不能使用优惠券了",
     *         in="query",
     *         name="scope_product_link_id",
     *         required=false,
     *         type="string",
     *         default="0",
     *     ),
     *     @SWG\Parameter(
     *         description="邮寄前置地址id。商品需要 直接邮寄 的时候要传过来",
     *         in="query",
     *         name="address_id",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="page_resource",
     *                  type="object" ,
     *                  description="页面数据" ,
     *              ),
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid params supplied"
     *     )
     * )
     */
    public function post_create()
    {

        $request_param = $this->input->input_json();

        //校验
        if (!$request_param->has('act_id')) {
            show_error('缺少act_id', 400);
        }
        if (!$request_param->has('inid')) {
            show_error('缺少inid', 400);
        }
        if (!$request_param->has('token')) {
            show_error('缺少token', 400);
        }
        if (!$request_param->has('type')) {
            show_error('缺少type', 400);
        }
        if (!$request_param->has('mcid')) {
            show_error('缺少mcid', 400);
        }
        if (!$request_param->has('quote_type')) {
            show_error('缺少quote_type', 400);
        }
        if (!$request_param->has('quote')) {
            show_error('缺少quote', 400);
        }
        if (!$request_param->has('password')) {
            show_error('缺少password', 400);
        }
        if (!$request_param->has('bpay_passwd')) {
            show_error('缺少bpay_passwd', 400);
        }
        if (!$request_param->has('u_type')) {
            show_error('缺少u_type', 400);
        }
        if (!$request_param->has('psp_setting')) {
            show_error('缺少psp_setting', 400);
        }
        if (!$request_param->has('scope_product_link_id')) {
            show_error('缺少scope_product_link_id', 400);
        }
        if (!$request_param->has('address_id')) {
            show_error('缺少address_id', 400);
        }
        if (!$request_param->has('name')) {
            show_error('缺少name', 400);
        }
        if (!$request_param->has('phone')) {
            show_error('缺少phone', 400);
        }
        if (!$request_param->has('qty')) {
            show_error('缺少qty', 400);
        }

        //赋值
        $params['act_id'] = empty($request_param->get('act_id')) ? 0 : $request_param->get('act_id');
        $params['inid'] = empty($request_param->get('inid')) ? 0 : $request_param->get('inid');
        $params['token'] = empty($request_param->get('token')) ? '' : $request_param->get('token');
        $params['grid'] = empty($request_param->get('grid')) ? 0 : $request_param->get('grid');
        $params['type'] = empty($request_param->get('type')) ? '' : $request_param->get('type');
        $params['mcid'] = empty($request_param->get('mcid')) ? [] : $request_param->get('mcid');
        $params['quote_type'] = empty($request_param->get('quote_type')) ? 0 : $request_param->get('quote_type');
        $params['quote'] = empty($request_param->get('quote')) ? 0 : $request_param->get('quote');
        $params['password'] = empty($request_param->get('password')) ? 'true' : $request_param->get('password');
        $params['bpay_passwd'] = empty($request_param->get('bpay_passwd')) ? 'true' : $request_param->get('bpay_passwd');
        $params['u_type'] = empty($request_param->get('u_type')) ? -1 : $request_param->get('u_type');
        $params['psp_setting'] = empty($request_param->get('psp_setting')) ? [] : $request_param->get('psp_setting');
        $params['scope_product_link_id'] = empty($request_param->get('scope_product_link_id')) ? 0 : $request_param->get('scope_product_link_id');
        $params['address_id'] = empty($request_param->get('address_id')) ? 0 : $request_param->get('address_id');
        $params['qty'] = empty($request_param->get('qty')) ? 0 : $request_param->get('qty');
        $params['product_id'] = empty($request_param->get('product_id')) ? 0 : $request_param->get('product_id');
        $params['hotel_id'] = empty($request_param->get('hotel_id')) ? 0 : $request_param->get('hotel_id');
        $params['settlement'] = empty($request_param->get('settlement')) ? 0 : $request_param->get('settlement');
        $params['business'] = empty($request_param->get('business')) ? 0 : $request_param->get('business');
        $params['saler'] = $this->session->tempdata('saler');
        $params['fans_saler'] = $this->session->tempdata('fans_saler');
        $params['saler_group'] = $this->session->tempdata('saler_group');
        $params['inter_id'] = $this->inter_id;
        $params['openid'] = $this->openid;
        $params['name'] = empty($request_param->get('name')) ? null : $request_param->get('name');
        $params['phone'] = empty($request_param->get('phone')) ? null : $request_param->get('phone');
        if (!preg_match("/^.{1,20}$/", $params['name'])) {
            $this->json(BaseConst::OPER_STATUS_FAIL_TOAST, '购买人信息不能超过20个字符');
            return;
        }
        if (!preg_match("/^1[34578]{1}\d{9}$/", $params['phone'])) {
            $this->json(BaseConst::OPER_STATUS_FAIL_TOAST, '手机号码不正确');
            return;
        }

        //下单
        $result = OrderService::getInstance()->create($params);

        //返回
        if ($result->getStatus() == Result::STATUS_OK) {

            $link = null;
            $result = $result->getData();

            //直接支付
            if (in_array($result['payChannel'], ['already_pay', 'balance_pay', 'point_pay'])) {
                $link = $this->link['already_pay'] . '?id=' . $this->inter_id . '&bType=' . '&saler=' . $this->session->tempdata('saler') . '&order_id=' . $result['orderInfo']['order_id'] . '&settlement=' . $params['settlement'] . '&zburl=' . $this->session->tempdata('zburl');
            } //微信支付
            elseif ($result['payChannel'] == 'wx_pay') {
                $link = $this->link['wx_pay'] . '?id=' . $this->inter_id . '&bType=' . '&saler=' . $this->session->tempdata('saler') . '&order_id=' . $result['orderInfo']['order_id'];
            } //威付通支付
            elseif ($result['payChannel'] == 'wft_pay') {
                $link = $this->link['wft_pay'] . '?id=' . $this->inter_id . '&bType=' . '&saler=' . $this->session->tempdata('saler') . '&order_id=' . $result['orderInfo']['order_id'];
            }
            $page_resource = [
                'link' => [
                    'wx_pay' => $link
                ]
            ];
            $data['page_resource'] = $page_resource;
            $this->json(BaseConst::OPER_STATUS_SUCCESS, '下单成功', $data);

        } else {

            $this->json(BaseConst::OPER_STATUS_FAIL_TOAST, $result->getMessage());
        }

    }
}