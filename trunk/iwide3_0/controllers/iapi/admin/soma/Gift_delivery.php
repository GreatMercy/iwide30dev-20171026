<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/***
 * 礼包派送 Controller
 * Created by Wuqd on.
 * Created Time 2017-09-03
 */
use \App\libraries\Iapi\BaseConst;
use App\controllers\iapi\admin\traits\Soma;

class Gift_delivery extends MY_Admin_Iapi{

    use Soma;

    /**
     * @SWG\Get(
     *     tags={"gift_delivery"},
     *     path="/gift_delivery/getGiftList",
     *     summary="获取礼包列表",
     *     description="获取礼包列表",
     *     operationId="getGiftList",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="分页",
     *         in="query",
     *         name="page",
     *         required=true,
     *         type="integer",
     *         format="int32",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="id",
     *                  description="礼包id",
     *                  type = "integer"
     *              ),
     *              @SWG\Property(
     *                  property="inter_id",
     *                  description="公众号id",
     *                  type = "string",
     *              ),
     *              @SWG\Property(
     *                  property="product_id",
     *                  description="商品id",
     *                  type = "integer",
     *              ),
     *              @SWG\Property(
     *                  property="name",
     *                  description="商品名称",
     *                  type = "string",
     *              ),
     *              @SWG\Property(
     *                  property="stock",
     *                  description="商品库存",
     *                  type = "integer",
     *              ),
     *              @SWG\Property(
     *                  property="cat_name",
     *                  description="分类名称",
     *                  type = "string",
     *              ),
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid pid supplied"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Package not found"
     *     ),
     * )
     */
    public function getGiftList(){
        $params = array();
        $params['page'] = $this->input->get('page');
        $params['page'] = empty($params['page']) ? 0 : intval($params['page'] - 1);
        //获取商家inter_id
        $params['inter_id'] = $this->session->get_admin_inter_id();
        //加载gift_delivery_model
        $this->load->model('soma/Gift_detail_model', 'Gift_detail_model');
        $Gift_detail_model = $this->Gift_detail_model;
        $this->db = $Gift_detail_model->_shard_db_r($this->inter_id);

        $this->load->model('soma/gift_delivery_model');
        //获取礼包列表
        $resultInfo = $this->gift_delivery_model->getGiftListData($params);

        $resultDataArr = array();
        $resultDataArr['status'] = 1000;
        $resultDataArr['msg'] = '';
        $resultDataArr['msg_type'] = '';
        $resultDataArr['count'] = $resultInfo['count'];
        $resultDataArr['pageCount'] = $resultInfo['pageCount'];
        $resultDataArr['web_data'] = $resultInfo['giftListData'];

        $data = [
            'items' => $resultInfo['giftListData'],
            'page_resource' => [
                'page' => $resultInfo['pageCount'],
                'count' => $resultInfo['count'],
                'size'=> $resultInfo['page_size'],
            ],
            'csrf' => $this->common_data,
            'start_time'=>$resultInfo['start_time'],
            'end_time'=>$resultInfo['end_time'],
        ];

        //结果返回
        $this->out_put_msg(BaseConst::OPER_STATUS_SUCCESS, '', $data);
    }


    /**
     * @SWG\Get(
     *     tags={"gift_delivery"},
     *     path="/gift_delivery/getProductList",
     *     summary="获取可添加至礼包的商品列表",
     *     description="获取可添加至礼包的商品列表",
     *     operationId="getProductList",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="商品名称",
     *         in="query",
     *         name="name",
     *         required=true,
     *         type="string",
     *         format="int32",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="product_id",
     *                  description="商品id",
     *                  type = "integer"
     *              ),
     *              @SWG\Property(
     *                  property="stock",
     *                  description="商品库存",
     *                  type = "integer",
     *              ),
     *              @SWG\Property(
     *                  property="name",
     *                  description="商品名称",
     *                  type = "string",
     *              ),
     *              @SWG\Property(
     *                  property="cat_id",
     *                  description="分类id",
     *                  type = "integer",
     *              ),
     *              @SWG\Property(
     *                  property="cat_name",
     *                  description="分类名称",
     *                  type = "string",
     *              ),
     *              @SWG\Property(
     *                  property="is_exist",
     *                  description="是否已添加至礼包",
     *                  type = "integer",
     *              ),
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid pid supplied"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Package not found"
     *     ),
     * )
     */
    public function getProductList(){

        $params = array();
        $params['name'] = $this->input->get('name');
        $params['inter_id'] = $this->session->get_admin_inter_id();

        //加载gift_delivery_model
        $this->load->model('soma/gift_delivery_model');
        $this->load->model('soma/Gift_detail_model', 'Gift_detail_model');
        $Gift_detail_model = $this->Gift_detail_model;
        $this->db = $Gift_detail_model->_shard_db_r($this->inter_id);
        //获取hotel_id
        $hotel_ids = $this->session->get_admin_hotels();
        if($hotel_ids){
            $hotel_ids = $hotel_ids;
        }
        $hotel_ids = $this->session->get_admin_hotels();
        $params['hotel_id'] = $hotel_ids ? explode(',', $hotel_ids) : '';

        //获取商品列表
        $resultInfo = $this->gift_delivery_model->getProductListData($params);

        //结果返回
        $this->out_put_msg(BaseConst::OPER_STATUS_SUCCESS,'',$resultInfo['productListData']);
    }


    /**
     * @SWG\Post(
     *     tags={"gift_delivery"},
     *     path="/gift_delivery/selectAddGift",
     *     summary="选择商品添加礼包",
     *     description="选择商品添加礼包",
     *     operationId="selectAddGift",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="礼包有效开始时间",
     *         in="query",
     *         name="start_time",
     *         required=true,
     *         type="string",
     *         format="int32",
     *     ),
     *     @SWG\Parameter(
     *         description="礼包有效结束时间",
     *         in="query",
     *         name="end_time",
     *         required=true,
     *         type="string",
     *         format="int32",
     *     ),
     *     @SWG\Parameter(
     *         description="添加至礼包的商品id(单个或多个)",
     *         in="query",
     *         name="product_id",
     *         required=true,
     *         type="string",
     *         format="int32",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="successful operation",
     *         @SWG\Schema(
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid pid supplied"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Package not found"
     *     ),
     * )
     */
    public function selectAddGift(){

        $paramsJson = $this->input->input_json();
        $productIdArr = explode(',',$paramsJson['product_id']);
        $params['start_time'] = $paramsJson['start_time'];
        $params['end_time'] = $paramsJson['end_time'];

        if(empty($params['start_time']) || empty($params['end_time'])){
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST,'礼包有限时间不能为空!','');
        }

        if(strtotime($params['start_time']) > strtotime($params['end_time'])){
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST,'开始时间不能大于结束时间!','');
        }

        $this->load->model('soma/Gift_detail_model', 'Gift_detail_model');
        $Gift_detail_model = $this->Gift_detail_model;
        $this->db = $Gift_detail_model->_shard_db_r($this->inter_id);
        $params['inter_id'] = $this->session->get_admin_inter_id();
        //商品校验是否属于inter_id 不属于则过滤
        $productWhere = ['inter_id'=>$params['inter_id']];
        $productIdArr = empty($productIdArr) ? '' : $productIdArr;
        $productIdRes = $this->db->select(['product_id','inter_id'])->where($productWhere)->where_in('product_id',$productIdArr)
            ->get('soma_catalog_product_package')->result_array();

        $productIdArr = arrayColumn($productIdRes,'product_id');
        //加载gift_delivery_model
        $this->load->model('soma/gift_delivery_model');
        if(empty($productIdArr)){

            $resultInfo = ['status'=>BaseConst::OPER_STATUS_SUCCESS,'message'=>'添加成功'];
        }else{

            //求出差集(获取要添加至礼包的product_id)
            $addGiftProductId = $productIdArr;
            //求出差集(获取要删除礼包的product_id)
            $delGiftProductId = [];
            //获取商品列表
            $resultInfo = $this->gift_delivery_model->selectProductAddGift($addGiftProductId,$delGiftProductId,'add',$params);

        }

        $this->out_put_msg($resultInfo['status'],$resultInfo['message'],'');
    }


    /**
     * @SWG\Post(
     *     tags={"gift_delivery"},
     *     path="/gift_delivery/deleteProductGift",
     *     summary="删除商品礼包",
     *     description="删除商品礼包",
     *     operationId="deleteProductGift",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="商品id",
     *         in="query",
     *         name="product_id",
     *         required=true,
     *         type="integer",
     *         format="int32",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="successful operation",
     *         @SWG\Schema(
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid pid supplied"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Package not found"
     *     ),
     * )
     */
    public function deleteProductGift(){

        $params = array();
        $paramsJson = $this->input->input_json();
        $params['product_id'] = $paramsJson['product_id'];
        $params['inter_id'] = $this->session->get_admin_inter_id();

        $this->load->model('soma/Gift_detail_model', 'Gift_detail_model');
        $Gift_detail_model = $this->Gift_detail_model;
        $this->db = $Gift_detail_model->_shard_db_r($this->inter_id);
        $productIdRes = $this->db->select(['product_id','inter_id'])->where($params)
            ->get('soma_catalog_product_package')->row_array();
        if(empty($productIdRes)){
            $this->out_put_msg(BaseConst::OPER_STATUS_FAIL_TOAST,'商品参数有误!','');
        }

        //加载gift_delivery_model
        $this->load->model('soma/gift_delivery_model');
        //删除inter_id 礼包
        $resultInfo = $this->gift_delivery_model->deleteProductGiftData($params);
        $this->out_put_msg($resultInfo['status'],$resultInfo['message'],'');
    }


    /**
     * @SWG\Get(
     *     tags={"gift_delivery"},
     *     path="/gift_delivery/giftReceiveDetail",
     *     summary="礼包领取信息详情",
     *     description="礼包领取信息详情",
     *     operationId="giftReceiveDetail",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         description="分页",
     *         in="query",
     *         name="page",
     *         required=true,
     *         type="integer",
     *         format="int32",
     *     ),
     *     @SWG\Parameter(
     *         description="筛选开始时间",
     *         in="query",
     *         name="start_time",
     *         required=true,
     *         type="string",
     *         format="int32",
     *     ),
     *     @SWG\Parameter(
     *         description="筛选结束时间",
     *         in="query",
     *         name="end_time",
     *         required=true,
     *         type="string",
     *         format="int32",
     *     ),
     *     @SWG\Parameter(
     *         description="订单号",
     *         in="query",
     *         name="order_id",
     *         required=true,
     *         type="integer",
     *         format="int32",
     *     ),
     *     @SWG\Parameter(
     *         description="登记信息",
     *         in="query",
     *         name="record_info",
     *         required=true,
     *         type="string",
     *         format="int32",
     *     ),
     *     @SWG\Parameter(
     *         description="创建人",
     *         in="query",
     *         name="saler_name",
     *         required=true,
     *         type="string",
     *         format="int32",
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="order_id",
     *                  description="订单号",
     *                  type = "integer"
     *              ),
     *              @SWG\Property(
     *                  property="name",
     *                  description="商品名称",
     *                  type = "string",
     *              ),
     *              @SWG\Property(
     *                  property="saler_name",
     *                  description="创建人",
     *                  type = "integer",
     *              ),
     *              @SWG\Property(
     *                  property="nickname",
     *                  description="购买人",
     *                  type = "string",
     *              ),
     *              @SWG\Property(
     *                  property="gift_num",
     *                  description="领取数量",
     *                  type = "integer",
     *              ),
     *              @SWG\Property(
     *                  property="cat_name",
     *                  description="分类名称",
     *                  type = "string",
     *              ),
     *              @SWG\Property(
     *                  property="consume_num",
     *                  description="核销数量",
     *                  type = "string",
     *              ),
     *              @SWG\Property(
     *                  property="consume_price",
     *                  description="核销金额",
     *                  type = "string",
     *              ),
     *         )
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid pid supplied"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Package not found"
     *     ),
     * )
     */
    public function giftReceiveDetail(){

        //接受筛选参数
        $params = array();
        $params['start_time'] = $this->input->get('start_time');
        $params['end_time'] = $this->input->get('end_time');
        $params['order_id'] = intval($this->input->get('order_id'));
        $params['saler_name'] = $this->input->get('saler_name');
        $params['record_info'] = $this->input->get('record_info');
        $params['page'] = intval($this->input->get('page'));
        $params['page'] = empty($params['page']) ? 0 : $params['page'] - 1;

        if(!empty($params['end_time'])){
            $params['end_time'] = $params['end_time'].' 23:59:59';
        }

        $params['inter_id'] = $this->session->get_admin_inter_id();
        //加载gift_delivery_model
        $this->load->model('soma/gift_delivery_model');
        $this->load->model('soma/Gift_detail_model', 'Gift_detail_model');
        $Gift_detail_model = $this->Gift_detail_model;
        //获取礼包领取详情
        $resultInfo = $this->gift_delivery_model->getGiftReceiveDetail($params,$Gift_detail_model);

        $data = [
            'items' => $resultInfo['message'],
            'page_resource' => [
                'page' => $resultInfo['pageCount'],
                'count' => $resultInfo['count'],
                'size'=> $resultInfo['page_size'],
            ],
            'csrf' => $this->common_data,
        ];

        $this->out_put_msg($resultInfo['status'],'',$data);
    }


}













