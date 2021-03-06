<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MY_Front_Soma {

    public  $themeConfig;
    public  $theme = 'default';//皮肤

	public function __construct()
	{
		parent::__construct();
        //theme
        $this->load->model('soma/Theme_config_model');
        $this->themeConfig = $themeConfig = $this->Theme_config_model->get_using_theme($this->inter_id);
        $this->theme = $themeConfig['theme_path'];
	}

    //显示后台的配置
    public function wx_select_hotel()
    {
        $assetItemId = $this->input->get('aiid');
        $orderId = $this->input->get('oid');
        $aiidi = $this->input->get('aiidi');
        $interId = $this->inter_id;
        $openid = $this->openid;
        $business = 'package';

        $packageService = \App\services\soma\PackageService::getInstance();

        //获取资产和酒店配置信息
        $item = $this->get_asset_item( $assetItemId, $openid, $orderId, $interId, $business );
        if( !$item )
        {
            redirect(Soma_const_url::inst()->get_url('soma/order/order_detail', array(
                'id'=>$interId,
                'oid'=>$orderId,
                'bsn'=>'package',
                'tkid' => $packageService->getParams()['tkid'],
                'layout' => $packageService->getParams()['layout'],
                'brandname' => $packageService->getParams()['brandname'],
            )));
        }


        if(!$this->isNewTheme()){
            //luguihong 2017/02/28 这里的配置修改为同步商品表里的配置
            $this->load->model('soma/Product_package_model','somaProductModel');
            $somaProductModel = $this->somaProductModel;
            $productInfo = $somaProductModel->get_product_package_by_ids( array($item['product_id']), $interId, 'product_id,wx_booking_config');
            if( $productInfo )
            {
                $wx_booking_config = json_decode( $productInfo[0]['wx_booking_config'], true );
            } else {
                $wx_booking_config = json_decode( $item['wx_booking_config'], true );
            }

            //处理搜索
            $isSearch = $this->input->post('is_search');
            $search = $this->input->post('search');
            $searchArr = array();
            if( $isSearch && $isSearch == Soma_base::STATUS_TRUE && $search ){

                //搜索页面，先简单处理，在$item['wx_booking_config']筛选结果
                foreach ($wx_booking_config as $k => $v) {
                    if( isset( $v['name'] ) && stripos( $v['name'], $search ) !== FALSE ){
                        $searchArr[$k] = $wx_booking_config[$k];
                        continue;
                    }else{
                        if( isset( $v['room_ids'] ) && !empty( $v['room_ids'] ) && is_array( $v['room_ids'] ) ){
                            $is_exists = FALSE;
                            $searchArrRooms = array();
                            foreach( $v['room_ids'] as $sk=>$sv ){
                                // var_dump( $sv['name'] );
                                if( isset( $sv['name'] ) && stripos( $sv['name'], $search ) !== FALSE ){
                                    $is_exists = TRUE;
                                    $searchArrRooms[$sk] = $wx_booking_config[$k]['room_ids'][$sk];
                                    continue;
                                }
                            }

                            if( $is_exists ){
                                $searchArr[$k] = $wx_booking_config[$k];
                                $searchArr[$k]['room_ids'] = $searchArrRooms;
                            }
                        }
                    }
                }
                // var_dump( $search, $searchArr );

                //搜索有结果，没有结果输出全部内容z
                if( $searchArr ){
                    $wx_booking_config = $searchArr;
                }
            }

            //搜索链接
            $search_url = Soma_const_url::inst()->get_url('*/booking/wx_select_hotel',array('oid'=>$orderId,'id'=>$interId,'aiid'=>$assetItemId,'aiidi'=>$aiidi));

            $this->datas = array(
                'item'=>$item,
                'aiid'=>$assetItemId,
                'oid'=>$orderId,
                'aiidi'=>$aiidi,
                'search'=>$search,
                'search_url'=>$search_url,
                'wx_booking_config'=>$wx_booking_config,
            );

            $header = array(
                'title'=> '微信订房'
            );
            $this->_view("header",$header);
        }
        else{
            $this->headerDatas['title'] = '订房';
        }

        $this->_view("select_hotel",$this->datas);
    }

    //ajax select_time
    public function ajax_get_time()
    {
        $hotelId = $this->input->post('hid');
        $roomId = $this->input->post('rmid');
        $priceCode = $this->input->post('cdid');
        $orderId = $this->input->post('oid');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $interId = $this->inter_id;
        $openid = $this->openid;

        //因为前端传过来的没有带0
        if( $month < 10 ){
            $month = '0'.$month;
        }
        
        // $start = $year.$month.'01';
        $year_now = date('Y');
        $month_now = date('m');

        $start = $year.$month.'01';
        //结束时间都以下个月1号为结束
        $end = date( "Ym01", strtotime( "{$start} +1 month" ) );
        
        $return = array( 'status'=>Soma_base::STATUS_TRUE, 'data'=>array(), 'message'=>'' );
        $this->load->library('Soma/Api_hotel');
        $ApiModel = new Api_hotel( $interId );

        //过去的时间就不发起订房拉取时间了，全部不可选
        if( $year_now > $year || ( $year_now == $year && $month_now > $month ) ){
            $rooms_un_can_booking = $ApiModel->get_un_booking( $start );
            $return['data']['data'] = $rooms_un_can_booking;
            $return['message'] = '过去的时间不可选！';
        }else{

            if( $year == $year_now && $month == $month_now ){
                $start = date('Ymd');
            }

            // var_dump( $start, $year, $month, $year_now, $month_now, $year != $year_now );die;
            // $end = $year.$month.'31';

            if( !$hotelId || !$roomId || !$priceCode || !$interId || !$year || !$month ){
                // die('参数不全，请返回再试一次！');
                $return['message'] = '参数不全，把这个月都变成不可选';
                $return['data']['data'] = $ApiModel->get_un_booking( $start );

            }else{

                //调取订房时间接口
                $ApiModel->_write_log( 'ajax获取订房时间开始。inter_id：'.$interId.' order_id：'.$orderId, 'start：soma/booking/ajax_get_time' );
                $result = $ApiModel->get_rooms( $openid, $interId, $hotelId, $roomId, $priceCode, $start, $end );
                $ApiModel->_write_log( 'ajax获取订房时间结束。inter_id：'.$interId.' order_id：'.$orderId, 'end：soma/booking/ajax_get_time' );

                $rooms_un_can_booking = $rooms_can_booking = array();
                if( isset( $result['status'] ) && $result['status'] == Soma_base::STATUS_TRUE ){
                    //现在是不管返回状态，都有返回数据
                    //如果没有返回$return['data']['rooms']信息，那么默认全部不可订
                    if( isset( $result['data']['rooms'] ) && !empty( $result['data']['rooms'] ) ){
                        $rooms_can_booking = isset( $result['data']['rooms']['can_booking'] ) 
                                                ? $result['data']['rooms']['can_booking'] 
                                                : array();
                        $rooms_un_can_booking = isset( $result['data']['rooms']['un_can_booking'] ) 
                                                ? $result['data']['rooms']['un_can_booking'] 
                                                : array();
                    }else{
                        $rooms_un_can_booking = $ApiModel->get_un_booking( $start );
                    }
                }else{
                    //如果获取数据失败，那么这个月都变成不可选
                    $return['message'] = isset( $result['message'] ) 
                                                ? $result['message'] 
                                                : '接口获取数据失败，把这个月都变成不可选';
                    $rooms_un_can_booking = $ApiModel->get_un_booking( $start );
                }

                $return['data']['data'] = $rooms_un_can_booking;

            }
        }
        echo json_encode( $return );die;
    }

    //选择时间
    public function select_hotel_time()
    {
        $assetItemId = $this->input->get('aiid');
        $orderId = $this->input->get('oid');
        $hotelId = $this->input->get('hid');
        $roomId = $this->input->get('rmid');
        $priceCode = $this->input->get('cdid');
        $aiidi = $this->input->get('aiidi');
        $interId = $this->inter_id;
        $openid = $this->openid;
        $business = 'package';

        $packageService = \App\services\soma\PackageService::getInstance();

        $params = array();
        $params['bsn'] = $business;
        $params['id'] = $interId;
        $params['oid'] = $orderId;
        $params['tkid'] = $packageService->getParams()['tkid'];
        $params['layout'] = $packageService->getParams()['layout'];
        $params['brandname'] = $packageService->getParams()['brandname'];
        if( !$hotelId || !$roomId || !$priceCode ){
            //点解订房按钮进来，参数出错，跳回选择房型
            redirect(Soma_const_url::inst()->get_url('*/booking/wx_select_hotel', $params));
        }

        if(!$this->isNewTheme()){
            $aiidi = isset( $aiidi ) && !empty( $aiidi ) ? $aiidi : 0;

            $jump = '*/booking/wx_select_hotel';
            $item = $this->get_asset_item( $assetItemId, $openid, $orderId, $interId, $business, $jump );

            //取出券码
            $this->load->model('soma/Consumer_code_model','CodeModel');
            $CodeModel = $this->CodeModel;
            $limit = isset( $item['qty'] ) ? $item['qty'] : 1;
            $filter = array();
            $filter['status'] = $CodeModel::STATUS_SIGNED;//取出没有消费的
            $codes = $CodeModel->get_code_by_assetItemIds( array($assetItemId), $interId, $filter, $limit );
            $code = isset( $codes[$aiidi]['code'] ) ? $codes[$aiidi]['code'] : '';

            //取出联系人和电话
            $filter = array();
            $filter['openid'] = $openid;
            $customer_info = $CodeModel->get_customer_contact( $filter );

            //调取订房时间接口
            $this->load->library('Soma/Api_hotel');
            $ApiModel = new Api_hotel( $interId );
            $ApiModel->_write_log( '获取订房时间开始。inter_id：'.$interId.' order_id：'.$orderId, 'start' );
            $return = $ApiModel->get_rooms( $openid, $interId, $hotelId, $roomId, $priceCode );
            $ApiModel->_write_log( '获取订房时间结束。inter_id：'.$interId.' order_id：'.$orderId, 'end' );

            $rooms = $rooms_un_can_booking = $rooms_can_booking = array();
            $room_name = $code_name = '';
            if( isset( $return['status'] ) && $return['status'] == Soma_base::STATUS_TRUE ){
                $room_name = isset( $return['data']['room_name'] ) ? $return['data']['room_name'] : '';
                $code_name = isset( $return['data']['code_name'] ) ? $return['data']['code_name'] : '';
                //如果没有返回$return['data']['rooms']信息，那么默认全部不可订
                if( isset( $return['data']['rooms'] ) && !empty( $return['data']['rooms'] ) ){
                    $rooms_can_booking = isset( $return['data']['rooms']['can_booking'] )
                        ? $return['data']['rooms']['can_booking']
                        : array();
                    $rooms_un_can_booking = isset( $return['data']['rooms']['un_can_booking'] )
                        ? $return['data']['rooms']['un_can_booking']
                        : array();
                }else{
                    $rooms_un_can_booking = $ApiModel->get_un_booking();
                }

            }else{
                //如果获取数据失败，那么这个月都变成不可选
                $rooms_un_can_booking = $ApiModel->get_un_booking();
            }

            //组装订房下单连接
            $params = array();
            $params['bsn'] = $business;
            $params['id'] = $interId;
            $post_url = Soma_const_url::inst()->get_url( '*/booking/post_booking', $params );

            //ajax获取订房时间
            $get_booking_time_url = Soma_const_url::inst()->get_url( '*/booking/ajax_get_time',array('id'=>$interId,'bsn'=>$business));

            //获取酒店名称
            $hotelName = '';
            $this->load->model( 'hotel/hotel_model', 'somaHotelModel' );
            $hotelInfo = $this->somaHotelModel->get_hotel_detail( $interId, $hotelId );
            if( $hotelInfo )
            {
                $hotelName = $hotelInfo['name'];
            }

            $this->datas = array(
                'item'=>$item,
                'aiid'=>$assetItemId,
                'oid'=>$orderId,
                'code'=>$code,
                'code_name'=>$code_name,
                'room_name'=>$room_name,
                'order_id'=>$orderId,
                'hotel_id'=>$hotelId,
                'room_id'=>$roomId,
                'price_code'=>$priceCode,
                'aiid'=>$assetItemId,
                'aiidi'=>$aiidi,
                'rooms_un_can_booking'=>$rooms_un_can_booking,
                'api_model'=>$ApiModel,
                'customer_info'=>$customer_info,
                'post_url'=>$post_url,
                'get_booking_time_url'=>$get_booking_time_url,
                'hotel_name'=>$hotelName,
            );

            $header = array(
                'title'=> '选择订房时间'
            );
            $this->_view("header",$header);
        }
        else{
            $this->headerDatas['title'] = '订房';
        }

        $this->_view("select_time",$this->datas);
    }

    //提交订房
    public function post_booking()
    {
        $interId        = $this->inter_id;
        $openid         = $this->openid;
        $business       = 'package';

        $name           = $this->input->post('post_name');
        $phone          = $this->input->post('post_phone');
        $orderId        = $this->input->post('post_order_id');
        $hotelId        = $this->input->post('post_hotel_id');
        $roomId         = $this->input->post('post_room_id');
        $priceCode      = $this->input->post('post_price_code');
        $code           = $this->input->post('post_code');
        $start          = $this->input->post('post_start');//订房开始时间
        $end            = $this->input->post('post_end');//订房结束时间
        $room_name      = $this->input->post('post_room_name');//房型名称
        $code_name      = $this->input->post('post_code_name');//价格代码名称
        $assetItemId    = $this->input->post('aiid');
        $aiidi          = $this->input->post('aiidi');
        $num            = $this->input->post('post_num');//选择多少间
        if( !$num || $num > 1 ){
            $num = 1;//暂时只可订一间房
        }

        //组装回跳选时间的链接
        $select_time_params = array();
        $select_time_params['aiid'] = $assetItemId;
        $select_time_params['hid'] = $hotelId;
        $select_time_params['rmid'] = $roomId;
        $select_time_params['cdid'] = $priceCode;
        $select_time_params['aiidi'] = $aiidi;
        $select_time_params['bsn'] = $business;
        $select_time_params['id'] = $interId;
        $select_time_params['oid'] = $orderId;
        $other_time_url = Soma_const_url::inst()->get_url( '*/booking/select_hotel_time', $select_time_params );

        if( !$interId || !$orderId || !$hotelId || !$roomId || !$priceCode || !$code ){
            redirect( $other_time_url );
        }

        //获取资产信息
        $jump = '*/booking/wx_select_hotel';
        $item = $this->get_asset_item( $assetItemId, $openid, $orderId, $interId, $business, $jump );
// var_dump( $item );die;
        //组装回跳选酒店和订单详情页的参数
        $params = array();
        $params['bsn'] = $business;
        $params['id'] = $interId;
        $params['oid'] = $orderId;
        $other_hotel_url = Soma_const_url::inst()->get_url( '*/booking/wx_select_hotel', $params );
        $order_detail_url = Soma_const_url::inst()->get_url( '*/order/order_detail', $params );

        //获取订单详情
        $this->load->model('soma/Sales_order_model','OrderModel');
        $OrderModel = $this->OrderModel;
        $OrderModel = $OrderModel->load( $orderId );
        if( !$OrderModel ){
            redirect( $other_hotel_url );
        }
        $OrderModel->business = $business;
        $orderDetail = $OrderModel->get_order_detail( $business, $interId );
        if( !$orderDetail ){
            redirect( $order_detail_url );
        }

        // 检查下单数量和剩余数量
        $qty = $item['qty'];
        if( $num > $qty ){
            //选择数量大于剩余数量，跳回选择入住时间
            redirect( $other_time_url );
        }

        //计算要发送给订单的金额
        $buy_qty = isset( $orderDetail['items'][0]['qty'] ) ? $orderDetail['items'][0]['qty'] : 0;
        $real_grand_total = $orderDetail['real_grand_total'];//实付金额
        $real_grand_total_arr = explode( '.', $real_grand_total );//如果有小数的，要把小数去掉先，加在最后使用的一个数量
        $remainder = $real_grand_total_arr[0] % $buy_qty;//余数
        if( $qty > 1 ){
            $send_grand_total = ( $real_grand_total_arr[0] - $remainder ) / $buy_qty;
            //($a-$a%$b)/$b
        }elseif( $qty == 1 ){
            //使用数量为1的时候，加上余数和小数
            $send_grand_total = ( ( $real_grand_total_arr[0] - $remainder ) / $buy_qty + $remainder ).'.'.$real_grand_total_arr[1];
            //($a-$a%$b)/$b + $a%$b;
        }else{
            //数量不足，跳回订单详情
            redirect( $order_detail_url );
        }
// var_dump( $buy_qty, $qty, $real_grand_total, $send_grand_total, $remainder, $real_grand_total_arr[0], $real_grand_total_arr[1], $real_grand_total_arr[0].'.'.$real_grand_total_arr[1] );die;

        //给订房发送数据前，检测同一个核销码是否已经发送过，如果已经发送过，要拦截本次请求，防止多次下单
        $key = "SOMA_PACKAGE_TO_HOTEL:BOOKING_ROOM_{$interId}_{$orderId}_{$code}";
        // $cache= $this->_load_cache();
        // $redis= $cache->redis->redis_instance();
        $redis = $this->get_redis_instance();
        $now_time = time();
        $lock_time = $now_time + 10;
        if( !$redis->setnx($key, $lock_time) ){
            // 没有获取到锁的，判断lock是否已过期
            // $lock_expire = (int)$redis->get( $key );
            // $lock_expire_old = (int)$redis->getset( $key, $lock_time );
            // if( $now_time >= $lock_expire && $now_time > $lock_expire_old ){
            //     $redis->delete($key);

            // }
            die('不能多次提交,请稍后再试！');
        }
        $redis->setex($key, 60, $lock_time);

        $remark = '套票预定，订单号：'.$orderId.'，核销券码：'.$code.'，商品名称：'.$item['name'];
        //发送订房的数据
        $post_params = array(
                'openid'=>$openid,
                'startdate'=>date('Ymd',strtotime($start)),
                'enddate'=>date('Ymd',strtotime($end)),
                'hotel_id'=>$hotelId,
                'room_id'=>$roomId,
                'price_code'=>$priceCode,
                'roomnums'=>$num,
                'name'=>$name,
                'tel'=>$phone,
                'remark'=>$remark,
                'rtype'=>'room',//默认room
                // 'allprice'=>$send_grand_total,
                // 默认价格为0
                'allprice' => 0,
            );

        //给订房发送数据
        $this->load->library('Soma/Api_hotel');
        $ApiModel = new Api_hotel( $interId );
        $ApiModel->_write_log( '提交订房订单开始。inter_id：'.$interId.' order_id：'.$orderId, 'start' );
        $return = $ApiModel->post_booking_room( $interId, $post_params );

        //订房返回成功, 核销该核销码
        $booking_status = FALSE;
        $consumer_status = FALSE;
        if( isset( $return['status'] ) && $return['status'] == Soma_base::STATUS_TRUE ){

            $booking_status = TRUE;

            $this->load->model('soma/Consumer_order_model','ConsumerOrderModel');
            $ConsumerOrderModel = $this->ConsumerOrderModel;

            //订房返回成功，插入一条成功信息到consumer_order_booking_hotel表
            $post_params['business'] = $business;
            $post_params['inter_id'] = $interId;
            $post_params['order_id'] = $orderId;
            $post_params['code'] = $code;
            $post_params['show_orderid'] = $return['data']['show_orderid'];
            $post_params['orderid'] = $return['data']['orderid'];
            $post_params['hotel_name'] = $item['hotel_name'];
            $post_params['room_name'] = $room_name;
            $post_params['mobile'] = $phone;
            $post_params['create_time'] = date('Y-m-d H:i:s');
            $post_params['status'] = $ConsumerOrderModel::BOOKING_HOTEL_FALSE;//未处理，核销完之后，更新状态
            // var_dump( $post_params );die;
            $recordId = $ConsumerOrderModel->save_booking_hotel_record_info( $interId, $post_params );

                // var_dump( $this->session->userdata('booking_hotel_consumer_id') );die;
            //根据券码去核销
            $consumer_method = $ConsumerOrderModel::CONSUME_HOTEL_SELF;//自助核销(套票转订房)
            // $result = $ConsumerOrderModel->direct_consumer( $code, $openid, $consumer_method, $interId, $business );
            // if( isset( $result['status'] ) && $result['status'] == Soma_base::STATUS_TRUE ){
            
            $service = \App\services\soma\consumer\ConsumerService::getInstance();
            $result  = $service->codeConsumer($interId, $code, $openid, $consumer_method, $business, $hotelId);
            if ($result->getStatus() == \App\services\Result::STATUS_OK) {
                $consumer_status = TRUE;

                //更新consumer_order_booking_hotel表状态，标记为已处理
                $filter = array();
                $filter['id'] = $recordId;
                $filter['inter_id'] = $interId;
                $filter['openid'] = $openid;
                $filter['order_id'] = $orderId;

                $consumerId = $this->session->userdata('booking_hotel_consumer_id');
                $data = array();
                $data['consumer_id'] = $consumerId;
                $data['status'] = $ConsumerOrderModel::BOOKING_HOTEL_TRUE;
                // var_dump( $interId, $filter, $data );die;
                $ConsumerOrderModel->update_booking_hotel_record_status( $interId, $filter, $data );
                $this->session->set_userdata('booking_hotel_consumer_id','');

                /**
                 * @var Consumer_item_package_model $consumerItemModel
                 */
                ///修改消费细单备注
                $business = 'package';
                $consumerItemId = $this->session->userdata('booking_hotel_consumer_item_id');
                $itemRemark = "订房订单号：{$return['data']['orderid']}，酒店：{$item['hotel_name']}，房型：{$room_name}，价格代码：{$code_name}";
                $this->load->model("soma/Consumer_item_{$business}_model",'consumerItemModel');
                $consumerItemModel = $this->consumerItemModel;
                $consumerItemModel->remark_save( $consumerItemId, $itemRemark, $interId, $business );
                $this->session->set_userdata('booking_hotel_consumer_item_id','');

                /***********************发送模版消息****************************/
                //发送模版消息
                /* 新版核销内已经发送核销模板消息
                $this->load->model('soma/Message_wxtemp_template_model','MessageWxtempTemplateModel');
                $MessageWxtempTemplateModel = $this->MessageWxtempTemplateModel;
                
                $openid = $openid;
                $inter_id = $interId;

                $type = $MessageWxtempTemplateModel::TEMPLATE_CONSUMER_SUCCESS;

                $this->load->model('soma/Asset_customer_model','AssetCustomerModel');
                $AssetCustomerModel = $this->AssetCustomerModel;
                $AssetCustomerModel->asset_item_id = $assetItemId;
                $AssetCustomerModel->code = $code;

                $MessageWxtempTemplateModel->send_template_by_consume_or_booking_success( $type, $AssetCustomerModel, $openid, $inter_id, $business);
                */
                /***********************发送模版消息****************************/

                //
            }else{
                //提示自助核销失败
                // $message = isset( $result['message'] ) ? $result['message'] : '自助核销失败，发生未知错误。';
                $message = $result->getMessage();
                $ApiModel->_write_log( '提交订房订单成功，券码自助核销失败。inter_id：'.$interId.' order_id：'.$orderId.'，失败信息：'.$message , 'consumer');
            }
        }
        
        // $redis->delete($key);//不能删除，如果同时并发很多，删除了后面跟着进来去订房下单
        $ApiModel->_write_log( '提交订房订单结束。inter_id：'.$interId.' order_id：'.$orderId , 'end');

        //后续处理 这里需要跳转，不能在这里显示成功或者失败页面，否则可能会重复发送数据给订房下单
        if( $booking_status == TRUE && $consumer_status == TRUE ){
            $url = Soma_const_url::inst()->get_url( '*/booking/success', array( 'bid'=>$recordId, 'id'=>$interId, 'bsn'=>$business ) );
            header("Location:$url");
            die;
            
        }else{
            $url = Soma_const_url::inst()->get_url( '*/booking/fail', array(
                                                                            'id'=>$interId,
                                                                            'bsn'=>$business,
                                                                            'aiid'=>$assetItemId,
                                                                            'oid'=>$orderId,
                                                                            'hid'=>$hotelId,
                                                                            'rmid'=>$roomId,
                                                                            'cdid'=>$priceCode,
                                                                            'aiidi'=>$aiidi,
                                                                        ) 
                                                    );
            header("Location:$url");
            die;
        }

    }

    public function success()
    {
        $interId = $this->inter_id;
        //获取推荐位
        $uri = 'soma_package_package_detail';
        $block = $this->get_page_block( $uri );
        // var_dump( $block );die;

        $interId = $this->inter_id;
        $openid = $this->openid;
        $business = 'package';

        $booking_id = $this->input->get('bid');
        $consumer_id = $this->input->get('cid');

        $this->load->model('soma/Consumer_order_model','ConsumerOrderModel');
        $ConsumerOrderModel = $this->ConsumerOrderModel;

        $filter = array();

        if( $booking_id ){
            $filter['id'] = $booking_id;
        }elseif( $consumer_id ){
            $filter['consumer_id'] = $consumer_id;
        }else{
            die('参数不足');
        }

        $filter['inter_id'] = $interId;
        $filter['openid'] = array( $openid );
        $filter['status'] = $ConsumerOrderModel::BOOKING_HOTEL_TRUE;

        $select = 'id,startdate,enddate,hotel_name,room_name,name,mobile,show_orderid';
        $bookingInfo = $ConsumerOrderModel->get_booking_hotel_info( $interId, $filter, $select );
// var_dump( $bookingInfo );
        //跳转到成功页面
        $this->datas = array(
            'id'=>$interId,
            'block'=>$block,
            'successInfo'=>$bookingInfo,
        );

        $header = array(
            'title'=> '订房成功'
        );
        $this->_view("header",$header);
        $this->_view("success",$this->datas);
    }

    public function fail()
    {
        $assetItemId = $this->input->get('aiid');
        $orderId = $this->input->get('oid');
        $hotelId = $this->input->get('hid');
        $roomId = $this->input->get('rmid');
        $priceCode = $this->input->get('cdid');
        $aiidi = $this->input->get('aiidi');
        $interId = $this->inter_id;
        $openid = $this->openid;
        $business = 'package';

        $other_hotel_url = Soma_const_url::inst()->get_url( '*/booking/wx_select_hotel', array(
                                                                                                'id'=>$interId,
                                                                                                'bsn'=>$business,
                                                                                                'oid'=>$orderId,
                                                                                            ) 
                                                    );

        $other_time_url = Soma_const_url::inst()->get_url( '*/booking/select_hotel_time', array(
                                                                            'id'=>$interId,
                                                                            'bsn'=>$business,
                                                                            'aiid'=>$assetItemId,
                                                                            'oid'=>$orderId,
                                                                            'hid'=>$hotelId,
                                                                            'rmid'=>$roomId,
                                                                            'cdid'=>$priceCode,
                                                                            'aiidi'=>$aiidi,
                                                                        ) 
                                                    );

        //跳转到失败页面
        $this->datas = array(
            'other_hotel_url'=>$other_hotel_url,
            'other_time_url'=>$other_time_url,
        );

        $header = array(
            'title'=> '订房失败'
        );
        $this->_view("header",$header);
        $this->_view("fail",$this->datas);
    }

    //获取资产，并检查
    protected function get_asset_item( $assetItemId, $openid, $orderId, $interId, $business, $jump='*/order/order_detail' )
    {
        $params = array();
        $params['bsn'] = $business;
        $params['id'] = $interId;
        $params['oid'] = $orderId;

        if( !$assetItemId || !$openid || !$interId || !$orderId ){
            redirect( Soma_const_url::inst()->get_url( $jump, $params ) );
        }

        $this->load->model('soma/Asset_item_package_model','ItemModel');
        $ItemModel = $this->ItemModel;
        $items = $ItemModel->get_order_items_byItemids( array( $assetItemId ), $business, $interId );
        if( !$items ){
            redirect( Soma_const_url::inst()->get_url( $jump, $params ) );
        }

        $item = $items[0];
        $nowTime = date('Y-m-d H:i:s');
        if( 
            $item['inter_id'] != $interId 
            || $item['openid'] != $openid 
            || $item['order_id'] != $orderId 
            || $item['qty'] <= 0 
            || $item['expiration_date'] < $nowTime 
        ){
            redirect( Soma_const_url::inst()->get_url( $jump, $params ) );
        }

        return $item;
    }

    //展示为以后的皮肤做扩展
    protected function _view($file, $datas=array() )
    {
        parent::_view('booking'. DS. $file, $datas);
    }

}
