<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// error_reporting(0);
class Consumer_order extends MY_Admin_Soma {

	const TYPE_BOOKING = 1;//预约
	const TYPE_BOOKING_CONSUMER = 2;//预约并核销

	//protected $label_module= NAV_MALL;		//统一在 constants.php 定义
	protected $label_controller= '消费码';		//在文件定义
	protected $label_action= '';				//在方法中定义
	
	protected function main_model_name()
	{
		return 'soma/consumer_order_model';
	}
	
	protected function main_item_model_name($business)
	{
		return 'soma/consumer_item_'.$business.'_model';
	}

	protected function main_consumer_code_model_name()
	{
		return 'soma/consumer_code_model';
	}

	protected function main_order_model_name()
	{
		return 'soma/Sales_order_model';
	}

	public function show_consume_code()
	{
	    $inter_id= $this->input->get('id');
	    $url= front_site_url($inter_id). '/index.php/soma/consumer/consumer_scaner?id='. $inter_id;
	    $this->_get_qrcode_png($url);
	}

	public function get_list()
	{
		die('暂未开放');
		$this->label_action= '核销列表';
	    $inter_id= $this->session->get_admin_inter_id();
	    if($inter_id== FULL_ACCESS) $filter= array();
	    else if($inter_id) $filter= array('inter_id'=>$inter_id );
	    else $filter= array('inter_id'=>'deny' );
	    //print_r($filter);die;
	    
	    $ent_ids= $this->session->get_admin_hotels();
	    $hotel_ids= $ent_ids? explode(',', $ent_ids ): array();
	    if( count($hotel_ids)>0 ) $filter+= array('hotel_id'=> $hotel_ids );
	    
        $model_name= $this->main_model_name();
        $model= $this->_load_model($model_name);

		if(is_ajax_request()) 
            //处理ajax请求，参数规格不一样
            $get_filter= $this->_ajax_params_parse( $this->input->post(), $model );
		    
        else 
		    $get_filter= $this->input->get('filter');
        
		if(is_array($get_filter)) $filter= $get_filter+ $filter;

        $sts= $model->get_status_label();
        $ops= '';
        foreach( $sts as $k=> $v){
        	if( isset($filter['status']) && $filter['status']==$k ) $ops.= '<option value="'. $k. '" selected="selected">'. $v. '</option>';
        	else $ops.= '<option value="'. $k. '">'. $v. '</option>';
        }
        
        if( !isset($filter['status']) || $filter['status']===NULL )
            $active= 'disabled';
        else 
            $active= 'btn-success';
        $jsfilter_btn= '&nbsp;&nbsp;<div class="input-group">'
			. '<div class="input-group-btn"><button type="button" class="btn btn-sm '. $active. '"><i class="fa fa-filter"></i> 状态</button></div>'
			. '<select class="form-control input-sm" name="filter[status]" id="filter_status" >'
			. '<option value="-">全部</option>'. $ops
			. '</select>'
			. '</div>';

		$current_url= current_url();
        $jsfilter= <<<EOF
$('#filter_status').change(function(){
	var go_url= '?'+ $(this).attr('name')+ '='+  $(this).val();
	//alert(go_url);
	if($(this).val()=='-') window.location= '{$current_url}';
	else window.location= '{$current_url}'+ go_url;
});
EOF;

        $viewdata= array(
            'js_filter_btn'=> $jsfilter_btn,
            'js_filter'=> $jsfilter,
        );
	    $this->_grid($filter, $viewdata);
	}
	
	public function grid($view_file = 'manage')
	{
		$this->label_action= '核销处理';
		$this->_init_breadcrumb($this->label_action);
		$inter_id= $this->session->get_admin_inter_id();
		if($inter_id== FULL_ACCESS) $filter= array();
	    else if($inter_id) $filter= array('inter_id'=>$inter_id );
	    else $filter= array('inter_id'=>'deny' );
	    
	    if(is_array($filter)){
	        $this->load->model('wx/publics_model');
	        $publics= $this->publics_model->get_public_hash($filter);
	        $publics= $this->publics_model->array_to_hash($publics, 'name', 'inter_id');
	        //$publics= $publics+ array(FULL_ACCESS=>'-所有公众号-');
	    }

	    $consumer_type= $this->input->post('consumer_type');
	    $start_time= $this->input->post('start_time');
	    $end_time= $this->input->post('end_time');
	    $business= 'package';

		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);

		/*********新后台新增**********/
		$hotelIds = array();
		$ent_ids = '';
		$this->load->model( 'hotel/hotel_model' );
		$hotels = $this->hotel_model->get_all_hotels($inter_id);
		if( $hotels ){
			// $ent_ids = '';
			foreach ($hotels as $k => $v) {
				$ent_ids .= $v['hotel_id'].',';
			}
			$ent_ids = trim( $ent_ids, ',' );
		}
		// var_dump( $hotels );
        // $hotel_info = $this->hotel_model->get_hotel_detail( $inter_id, $hotel_ids[0] );
        $hotel_infos = $this->hotel_model->get_hotel_by_ids( $inter_id, $ent_ids );
        // var_dump( $hotel_infos );die;
        if( $hotel_infos ){
        	foreach ($hotel_infos as $k => $v) {
        		if( $k == 0 ){
        			$hotel_address = $v['province'].$v['city'].$v['address'];
        			$hotel_tel = $v['tel'];
        		}
        		$data = array();
	        	$data['hotel_address'] = $v['province'].$v['city'].$v['address'];
	            $data['hotel_tel'] = isset( $v['tel'] ) && !empty( $v['tel'] ) 
	            						? $v['tel'] 
	            						: '';
				$data['name'] = $v['name'];
        		$hotelIds[$v['hotel_id']] = $data;
        	}
        }
		/*********新后台新增**********/

	    //核销列表显示
	    $consumer_fields_config = array(
	    		'consumer_id'=>'核销编号',
	    		'consumer_code'=>'核销券码',
	    		'hotel_name'=>'酒店名称',
	    		'name'=>'核销商品',
	    		'price_package'=>'核销价格',
	    		'grand_total'=>'订单实付金额',
	    		'order_id'=>'订单号',
	    		'remark'=>'备注',
	    		'consumer_time'=>'核销时间',
	    		'consumer_method'=>'核销方式',
	    		'consumer'=>'核销账号',
	    		// 'edit'=>'操作',
	    	);
	    //核销分页
	    $this->load->library('pagination');
		$config['per_page']          = 30;
		// $page = empty($this->uri->segment(5)) ? 0 : ($this->uri->segment(5) - 1) * $config['per_page'];
		$page = empty($this->input->get('per_page')) ? 0 : ($this->input->get('per_page') - 1) * $config['per_page'];
	// var_dump( $page );
		$config['use_page_numbers']  = TRUE;
		$config['cur_page']          = $page;
		$avgs['inter_id'] = $inter_id;
		
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$params = array('inter_id'=>$inter_id);
		$filter = array( 'consumer_type'=>$model::CONSUME_TYPE_DEFAULT,'status'=>$model::STATUS_ALLUSE );
		
		/*********新后台新增**********/
		$hotel_id = $this->input->get('hotel_id');
		if( $hotel_id )$filter['hotel_id'] = $hotel_id;

		$consumer = $this->input->get('consumer');
		if( $consumer )$filter['consumer'] = $consumer;
		/*********新后台新增**********/
		
		$model->start = $start;
		$model->end = $end;
		$result = $model->get_consumer_list($filter,$inter_id,$business,$config['per_page'],$config['cur_page']);//
        $consumerIds = array();
        if( count( $result ) > 0 ){
			$pk = $model->table_primary_key();
            foreach( $result as $k=>$v ){
                $consumerIds[$v[$pk]] = $v;
            }

         //    $SalesOrderModelName= "Sales_order_model";
	        // require_once dirname(__FILE__). DS. "$SalesOrderModelName.php";
	        // $Sales_order_model = new $SalesOrderModelName();

            $this->load->model('soma/Sales_order_model','SalesOrderModel');
        	$SalesOrderModel = $this->SalesOrderModel;

	        $this->load->model("soma/Consumer_item_{$business}_model",'ItemModel');
	        $object= $this->ItemModel;
	        $item_result = $object->get_order_items_byIds( array_keys( $consumerIds ), $business, $inter_id );
	        if( count( $item_result ) > 0 ){

	        	$consumerMethod = $model->get_method_label();
	            foreach( $item_result as $k=>$v ){
	                $consumerIds[$v[$pk]]['consumer_id'] = $v['consumer_id'];
	                $consumerIds[$v[$pk]]['consumer_code'] = $v['consumer_code'];
	                $consumerIds[$v[$pk]]['name'] = $v['name'];
	                $consumerIds[$v[$pk]]['price_package'] = $v['price_package'];
	                $consumerIds[$v[$pk]]['order_id'] = $v['order_id'];
	                $consumerIds[$v[$pk]]['remark'] = $v['remark'];
	                $consumerIds[$v[$pk]]['item_id'] = $v['item_id'];
	                $consumerIds[$v[$pk]]['hotel_name'] = $v['hotel_name'];
	                // $consumerIds[$v[$pk]]['consumer_time'] = $consumerIds[$v[$pk]]['consumer_time'];
	                if( isset( $consumerIds[$v[$pk]]['consumer_method'] ) )
	                	$consumerIds[$v[$pk]]['consumer_method'] = $consumerMethod[$consumerIds[$v[$pk]]['consumer_method']];
	                // $consumerIds[$v[$pk]]['consumer'] = $consumerIds[$v[$pk]]['consumer'];

	                //实付金额
		            $SalesOrderModel = $SalesOrderModel->load( $v['order_id'] );
		            if( $SalesOrderModel )
		                $consumerIds[$v[$pk]]['grand_total'] = $SalesOrderModel->m_get('real_grand_total');
		            else
		                $consumerIds[$v[$pk]]['grand_total'] = '';
	            }
	        }
        }

        $model->consumer = $consumer;
        $total = $model->get_consumer_list_count($inter_id, $business, $hotel_id);
// var_dump( $result_new );die;
		$config['uri_segment']       = 5;
		$config['page_query_string'] = TRUE;   
		$config['numbers_link_vars'] = array('class'=>'number');
		$config['cur_tag_open']      = '<a class="number current" href="#">';
		$config['cur_tag_close']     = '</a>';
		$config['base_url']          = Soma_const_url::inst()->get_url('*/*/grid/export?start='.$start.'&end='.$end.'&hotel_id='.$hotel_id.'&consumer='.$consumer);
		$config['total_rows']        = $total;
		$config['cur_tag_open'] = '<li class="paginate_button active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="paginate_button">';
		$config['num_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li class="paginate_button first">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="paginate_button last">';
		$config['last_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="paginate_button previous">';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="paginate_button next">';
		$config['next_tag_close'] = '</li>';
		$config['first_link'] = '首页'; // 第一页显示   
		$config['last_link'] = '末页'; // 最后一页显示   
		$config['next_link'] = '下一页 >'; // 下一页显示   
		$config['prev_link'] = '< 上一页'; // 上一页显示 
		$this->pagination->initialize($config);
	    
	    //核销方式
	    $type = array( $model::CONSUME_TYPE_DEFAULT=>'核销使用' );//$model->get_type_label();
		
        if(!$model) $model= $this->_load_model();
		$fields_config= $model->get_field_config('form');
		$code= $this->input->get('ids');

		$btn_search = '';
		if( $code ){
			// $btn_search .= '
			// 	            <div class="form-group ">
			// 	            	<label class="col-sm-2 control-label"></label>
			// 	                <div class="col-sm-6">暂无信息</div>
			// 	            </div>';
		}else{
			$code = '';
		}

		$btn= '<div class="form-group ">
                <label class="col-sm-2 control-label">核销码</label>
                <div class="col-sm-6 inline">
                    <input type="text" maxlength="12" style="font-size:25px;line-height:40px;height:40px;" class="form-control " name="code" id="el_consumer_code" value="'.$code.'">
                </div><div style="height:40px;line-height:40px;">请输入12位核销码</div>
            </div>';

        $batch = $this->input->get('batch');
        if( !$batch ){
        	$batch = $this->uri->segment(4);
        	if( !$batch ){
        		$batch = 'export';
        	}
        }

        // 新后台拉取所有公众号产品
        $this->load->model('soma/Product_package_model', 'p_model');
        $products = $this->p_model->get_product_package_list();

        // var_dump( $batch );
		$view_params= array(
		    'model'=> $model,
		    'settle_arr'=> $type,
		    'consumer_type'=> isset( $consumer_type ) ? $consumer_type : $model::CONSUME_TYPE_DEFAULT,
		    'publics'=> $publics,
		    'code'=> $code,
		    'fields_config'=> $fields_config,
		    'btn'=> $btn,
		    'start_time'=> $start_time,
	        'end_time'=> $end_time,
		    'btn_search'=> $btn_search,
		    'batch'=> $batch,
		    'consumer_fields_config'=> $consumer_fields_config,
		    'pagination' => $this->pagination->create_links(),
		    'total' => $total,
		    'export_data' => $consumerIds,
		    'start_time' => $start,
		    'end_time' => $end,
		    'hotelIds' => $hotelIds,
		    'hotel_id' => $hotel_id,
			'products' => $products,
			'consumer' => $consumer,
		);
		if($inter_id && $inter_id != FULL_ACCESS){
		    $view_params['inter_id']= $inter_id;
		}
		
		$html= $this->_render_content($this->_load_view_file($view_file), $view_params, TRUE);
		//echo $html;die;
		echo $html;
	}

	// 核销记录表
	public function consumer_order_record() {
		$this->grid('record');
	}

	public function edit($return = false){
		$this->label_action= '核销处理';
		$this->_init_breadcrumb($this->label_action);
		
		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);

		//越权查看数据跳转
		if( !$this->_can_edit($model) ){
            $this->session->put_error_msg('找不到该数据');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid'));
		}
		
		$code = $this->input->post('code');
// var_dump( $code );exit;
		if( !$code ){
			$this->session->put_error_msg('找不到该核销码的相关信息');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?ids='.$code ) );
		}

		//根据consumer_item_id获取细单信息
		$business = 'package';
		$inter_id = $this->_get_real_inter_id( TRUE );
//测试使用
// $inter_id = 'a429262687'; 

		//到码表查询是否已经分配
		$consumer_code_model_name = $this->main_consumer_code_model_name();
		$this->load->model( $consumer_code_model_name, 'consumer_code' );
		$consumer_code = $this->consumer_code;
		$consumer_code_info = $consumer_code->get_consumer_code_info_by_code( $code, $inter_id );
// var_dump( $code, $inter_id, $consumer_code_info );exit;
		if( !$consumer_code_info ){
			// die( '预约码不存在' );
    	    $this->session->put_notice_msg('核销码不存在！');
	    	$this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
		}
		$status_unsign = $consumer_code::STATUS_UNSIGN;//未分配
		$status_consume = $consumer_code::STATUS_CONSUME;//已消费
		$status = $consumer_code_info['status'];
		if( $status == $status_unsign ){
			// die( '预约码没有分配' );
			$this->session->put_notice_msg('核销码没有分配！');
	    	$this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
		}elseif( $status == $status_consume ){
			// die( '预约码已经消费' );
			// $this->session->put_notice_msg('核销码已经消费！');
	  //   	$this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
		}

		//资产细单id
		$asset_item_id = $consumer_code_info['asset_item_id'];
		
		//获取资产细单
		$this->load->model('soma/asset_customer_model');
		$asset_customer_model = $this->asset_customer_model;
		//要传入的参数

		$show_remark = FALSE;
		$remark_data = '';

		$items = $asset_customer_model->get_asset_items_by_itemId( $asset_item_id, $business, $inter_id );
		if( !$items ){
			$this->session->put_notice_msg('没有找到要核销的相关信息');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?ids='.$code ) );
		}else{
			$items = $items[0];

			//判断是否是该公众号的数据
			if( $items['inter_id'] != $inter_id ){ 
				$this->session->put_error_msg('不是本店的核销码');
	    		$this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
			}

			$button_str = '';//要输出的按钮操作，预约或者核销

			//判断是否已经消费了
			// $asset_status = $asset_customer_model::STATUS_ITEM_SIGNED;//已经消费
			// if( $items['status'] == $asset_status ){
			// 	//已经消费完(qty等于0)
			// 	$button_str .= '<a type="button" href="#" class="btn btn-info">已经消费</a>&nbsp;&nbsp;&nbsp;';
			// }else{

				//已经预约或着不需要预约的直接消费
		    	//不需要预约的直接生成消费单，并核销处理
		    	//已经预约的直接核销
		    	$can_reserve_yes = $asset_customer_model::ITEMS_CAN_RESERVE_YES;//需要预约
				$can_reserve_no = $asset_customer_model::ITEMS_CAN_RESERVE_NO;//不需要预约
				$model->business = $business;

				$model_item_name = $this->main_item_model_name( $business );
				$this->load->model( $model_item_name, 'model_item' );
				$model_item = $this->model_item;
				$result = $model_item->get_consumer_order_item( $asset_item_id, $code, $business, $inter_id );
				$consumer_item_status = $model_item::STATUS_ITEM_CONSUME;//已使用

				$result = array_reverse( $result );//翻转数组
				$post_url = '';

				$consumer_yes = $model_item->get_consumer_yes();
				if( isset( $result[0]['status'] ) && in_array( $result[0]['status'], $consumer_yes ) ){
					$button_str .= '<a type="button" href="#" class="btn btn-info">已经消费</a>&nbsp;&nbsp;&nbsp;';
				}elseif( $items['can_reserve'] == $can_reserve_yes ){
					//需要预约的，查找消费单是否有记录
					//没有预约的，提示需要预约
					//根据asset_item_id查找消费单

					//找出消费单
					// $consumer_item_list = $model->consumer_order_item_list_by_productId( $product_id, $business, $inter_id );
					// if( $consumer_item_list ){
					// 	$consumer_count = count( $consumer_item_list );
					// }

					if( $result ){
						if( $result[0]['status'] == $consumer_item_status ){
							$button_str .= '<a type="button" href="#" class="btn btn-info">已经消费</a>&nbsp;&nbsp;&nbsp;';
						}else{
							// if( $status == $status_consume ){
							// 	$button_str .= '<a type="button" href="#" class="btn btn-info">已经核销</a>&nbsp;&nbsp;&nbsp;';
							// }else{

								// $button_str .= '<a type="button" href="#" class="btn btn-info">已经预约</a>&nbsp;&nbsp;&nbsp;';
								$show_remark = TRUE;
								$remark_data = isset( $result[0]['remark'] ) ? $result[0]['remark'] : '';
								$post_url = Soma_const_url::inst()->get_url( '*/*/consumer_post?ids='.$asset_item_id.'&code='.$code );//核销
								$button_str .= '<input type="submit" id="button" type_id="'.self::TYPE_BOOKING.'" class="btn btn-info button_consumer" value="核销" />&nbsp;&nbsp;&nbsp;';
							// }

						}
					}else{
						$show_remark = TRUE;
						// $booking_url = Soma_const_url::inst()->get_url( '*/*/booking_post?ids='.$asset_item_id.'&code='.$code.'&type='.self::TYPE_BOOKING );//预约
						// $booking_consumer_url = Soma_const_url::inst()->get_url( '*/*/booking_post?ids='.$asset_item_id.'&code='.$code.'&type='.self::TYPE_BOOKING_CONSUMER );//预约并核销
						$post_url = Soma_const_url::inst()->get_url( '*/*/booking_post?ids='.$asset_item_id.'&code='.$code );
						$button_str .= '<input type="submit" id="button" type_id="'.self::TYPE_BOOKING.'" class="btn btn-info button_consumer" value="预约" />&nbsp;&nbsp;&nbsp;';
						$button_str .= '<input type="submit" id="button" type_id="'.self::TYPE_BOOKING_CONSUMER.'" class="btn btn-info button_consumer" value="预约并核销" />&nbsp;&nbsp;&nbsp;';
					}
				}else{
					if( $result && ( $result[0]['status'] == $consumer_item_status ) ){
						$button_str .= '<a type="button" href="#" class="btn btn-info">已经消费</a>&nbsp;&nbsp;&nbsp;';
					}else{
						$show_remark = TRUE;
						$post_url = Soma_const_url::inst()->get_url( '*/*/consumer_post?ids='.$asset_item_id.'&code='.$code );//核销
						$button_str .= '<input type="submit" id="button" type_id="'.self::TYPE_BOOKING.'" class="btn btn-info button_consumer" value="核销" />&nbsp;&nbsp;&nbsp;';
					}
				}
			// }
		}

		//显示的字段类型转换
        $item_status_label = $asset_customer_model->get_status_item_label();
        $items['status'] = $item_status_label[$items['status']];

        //能否退款／赠送／状态
	    $status_can = $model->get_status_can_label();
	    $items['can_refund'] = $status_can[$items['can_refund']];
	    $items['can_gift'] = $status_can[$items['can_gift']];
	    $items['can_reserve'] = $status_can[$items['can_reserve']];

        if( isset( $items['price_market'] ) ){
            $items['price_market'] = '￥'.$items['price_market'];
        }

        if( isset( $items['price_package'] ) ){
            $items['price_package'] = '￥'.$items['price_package'];
        }

        $this->load->model( 'hotel/hotel_model' );
        $hotel_info = $this->hotel_model->get_hotel_detail( $items['inter_id'], $items['hotel_id'] );
        if( $hotel_info ){
        	$items['hotel_name'] = $hotel_info['name'];
        }else{
        	$items['hotel_name'] = '';
        }

        $rooms_detail = $this->hotel_model->get_room_detail( $items['inter_id'], $items['hotel_id'], $items['room_id'] );
        if( $rooms_detail ){ 
        	$items['room_name'] = $rooms_detail['name'];
        }else{ 
        	$items['room_name'] = '';
        }

        //购买人
        $openid = isset( $items['openid'] ) ? $items['openid'] : '';
        $user_info = $this->db->where_in( 'openid', $openid )->select('id,nickname,inter_id')->get('fans' )->result_array();
        // $user_info = $publics_model->get_fans_info( $openid );
        if( $user_info ){
        	$items['nickname'] = $user_info[0]['nickname'];
        }else{
        	// $items['openid'] = '';
        }

        //添加购买方式和订单金额
        $this->load->model('soma/Sales_order_model','SalesOrderModel');
        $SalesOrderModel = $this->SalesOrderModel->load( $items['order_id'] );
        $items['grand_total'] = $SalesOrderModel->m_get( 'grand_total' );
        $order_status = $SalesOrderModel->get_settle_label();
        $items['settlement'] = $order_status[$SalesOrderModel->m_get( 'settlement' )];

		$fields_config= $model->get_field_config('form');

		//输出字段
		$grid_field= array(
						// 'product_id'=> 'product_id',
				        // 'inter_id'=> 'inter_id',
				        // 'hotel_id'=> '酒店',
						'hotel_name' => '酒店',
				        'name'=> '商品名',
				        'price_market'=> '市场价',
				        'price_package'=> '微信价',
				        // 'compose'=> '套票内容',
				        // 'face_img'=> 'face_img',
				        'can_refund'=> '能否退',
				        'can_gift'=> '能否赠送',
				        'can_reserve'=> '能否预约',
				        'room_name'=> '房型',
				        'validity_date'=> '开始有效期',
				        'expiration_date'=> '截止有效期',
				        // 'order_item_id'=> 'item_id',
			            'order_id'  => '订单号',
				        //'openid_origin'=> 'openid',
				        'nickname'=> '购买人',
				        //'qty_origin'=> 'qty',
				        'qty'=> '数量',
						'status' => '状态',
						'settlement' => '购买方式',
						'grand_total' => '订单金额',
					);

		$view_params= array(
		    'model'=> $this->asset_customer_model,
		    'grid_field'=> $grid_field,
		    'items'=> $items,
		    'fields_config'=> $fields_config,
		    'code'=> $code,
		    'button_str'=> $button_str,
		    'show_remark'=> $show_remark,
		    'post_url'=> $post_url,
		    'remark_data'=> $remark_data,
		    'remark_url'=> Soma_const_url::inst()->get_url( '*/*/remark_post?aiid='.$asset_item_id.'&code='.$code.'&id='.$inter_id.'&bsn='.$business ),
		);

		if($return) {
			return $view_params;
		}

		$html= $this->_render_content($this->_load_view_file('edit'), $view_params, TRUE);
		//echo $html;die;
		echo $html;
	}

	//批量核销：1.填写订单号，批量核销。2.填写赠送订单，批量核销。这里的批量核销指的是同一个单下面的，核销多个数量。
	//订单核销的ok , 赠送核销的没有完成，下个版本迭代
	public function batch_edit($return = false)
	{
		$this->label_action= '批量核销处理';
		$this->_init_breadcrumb($this->label_action);
		
		$order_model_name= $this->main_order_model_name();
		$model= $this->_load_model($order_model_name);

		//越权查看数据跳转
		if( !$this->_can_edit($model) ){
            $this->session->put_error_msg('找不到该数据');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?batch='.Soma_base::STATUS_TRUE));
		}

		//根据consumer_item_id获取细单信息
		$business = 'package';
		$inter_id = $this->_get_real_inter_id( TRUE );

		$order_id = $this->input->post('order_id');
		if( !$order_id ){
			$this->session->put_error_msg('请输入订单号！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?batch='.Soma_base::STATUS_TRUE ) );
		}

		//传入订单号和数量
		$model->business = $business;
		$model = $model->load( $order_id );
		if( !$model ){
			$this->session->put_error_msg('sales_order_model初始化失败！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?batch='.Soma_base::STATUS_TRUE ) );
		}

		$order_detail = $model->get_order_asset($business, $inter_id);
		if( count( $order_detail ) == 0 ){
			$this->session->put_error_msg('没有找到该订单信息！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?batch='.Soma_base::STATUS_TRUE ) );
		}

		//检查公众号是否匹配
		$inter_id = $this->_get_real_inter_id( TRUE );
		if( $inter_id != $order_detail['inter_id'] ){
			$this->session->put_error_msg('不是本店的订单号！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?batch='.Soma_base::STATUS_TRUE ) );
		}

		$asset_items = $model->filter_items_by_openid( $order_detail['items'], $order_detail['openid'] );
		if( count( $asset_items ) == 0 ){
			$this->session->put_error_msg('没有找到该订单的资产信息！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?batch='.Soma_base::STATUS_TRUE ) );
		}

		$asset_items_num = 0;
		foreach( $asset_items as $k=>$v ){
			$asset_items_num += $v['qty'];
		}

		//购买人
        $openid = isset( $asset_items[0]['openid'] ) ? $asset_items[0]['openid'] : '';
        $user_info = $this->db->where_in( 'openid', $openid )->select('id,nickname,inter_id')->get('fans' )->result_array();
        // $user_info = $publics_model->get_fans_info( $openid );
        // var_dump( $user_info );die;
        if( $user_info ){
        	$asset_items[0]['openid'] = $user_info[0]['nickname'];
        }else{
        	// $items['openid'] = '';
        }

        $asset_items[0]['openid_buy'] = isset( $order_detail['contact'] ) ? $order_detail['contact'] : '';

        //商品过期时间
        $time = time();
        $expireTime = isset( $productDetail['expiration_date'] ) ? strtotime( $productDetail['expiration_date'] ) : NULL;
        $is_expire = FALSE;
        if( $expireTime && $expireTime < $time ){
            $is_expire = TRUE;
        }

        $status_label = $model->get_status_label();
        $order_detail['status'] = $status_label[$order_detail['status']];

		$fields_config= $model->get_field_config('form');

		//输出字段
		$grid_field= array(
						'order_id' => '订单号',
				        'openid'=> 'openid',
				        'transaction_id'=> '流水号',
				        'payment_time'=> '支付时间',
				        'subtotal'=> '优惠价总额',
				        'grand_total'=> '实付总额',
				        'discount'=> '优惠总额',
						'status' => '状态',
					);

		//输出字段
		$item_grid_field= array(
						'order_id' => '订单号',
				        'openid_buy'=> '购买人',
				        'product_id'=> '商品ID',
				        'name'=> '商品名',
				        'qty'=> '剩余数量',
				        'expiration_date'=> '过期时间',
						// 'status' => '状态',
					);

		$view_params= array(
		    'item_grid_field'=> $item_grid_field,
		    'order_detail'=> $order_detail,
		    'items'=> $order_detail['items'],
		    'order_id'=> $order_id,
		    'model'=> $model,
		    'fields_config'=> $fields_config,
		    'grid_field'=> $grid_field,
		    'asset_items'=> $asset_items,
		    'asset_items_num'=> $asset_items_num,
		    'is_expire'=> $is_expire,
		);

		if($return) {
			return $view_params;
		}

		$html= $this->_render_content($this->_load_view_file('batch_edit'), $view_params, TRUE);
		//echo $html;die;
		echo $html;
	}

	//批量核销：1.填写订单号，批量核销。2.填写赠送订单，批量核销。这里的批量核销指的是同一个单下面的，核销多个数量。
	//订单核销的ok , 赠送核销的没有完成，下个版本迭代
	public function batch_post( $return_flag = false )
	{
		$this->label_action= '批量核销处理';
		$this->_init_breadcrumb($this->label_action);
		
		// $order_model_name= $this->main_order_model_name();
		// $order_model= $this->_load_model($order_model_name);
		$this->load->model('soma/Sales_order_model','order_model');
		$order_model = $this->order_model;

		//越权查看数据跳转
		if( !$this->_can_edit($order_model) ){

			if($return_flag) {
				return array('status' => Soma_base::STATUS_FALSE, 'message' => '找不到该数据');
			}
            
            $this->session->put_error_msg('找不到该数据');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?batch='.Soma_base::STATUS_TRUE));
		}

		//根据consumer_item_id获取细单信息
		$business = 'package';
		$inter_id = $this->_get_real_inter_id( TRUE );

		$order_id = $this->input->post('order_id');
		$num = $this->input->post('num');

		if( !$order_id || !$num ){
			
			if($return_flag) {
				return array('status' => Soma_base::STATUS_FALSE, 'message' => '请输入核销数量！');
			}
			
			$this->session->put_error_msg('请输入核销数量！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?batch='.Soma_base::STATUS_TRUE ) );
		}

		//传入订单号和数量
		$order_model->business = $business;
		$order_detail = $order_model->load( $order_id )->get_order_asset($business, $inter_id);
		if( count( $order_detail ) == 0 ){

			if($return_flag) {
				return array('status' => Soma_base::STATUS_FALSE, 'message' => '没有找到该订单信息！');
			}

			$this->session->put_error_msg('没有找到该订单信息！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?batch='.Soma_base::STATUS_TRUE ) );
		}

		//筛选属于自己的资产订单
    	$asset_items = $order_model->filter_items_by_openid( $order_detail['items'], $order_detail['openid'] );
		if( count( $asset_items ) == 0 ){

			if($return_flag) {
				return array('status' => Soma_base::STATUS_FALSE, 'message' => '没有找到核销信息！');
			}

			$this->session->put_error_msg('没有找到核销信息！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?batch='.Soma_base::STATUS_TRUE ) );
		}

		//特权券不能在后台核销！
		if( isset( $asset_items[0]['type'] ) && $asset_items[0]['type'] == $order_model::PRODUCT_TYPE_PRIVILEGES_VOUCHER ){

			if($return_flag) {
				return array('status' => Soma_base::STATUS_FALSE, 'message' => '后台不能使用特权券！');
			}

			$this->session->put_error_msg('后台不能使用特权券！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?batch='.Soma_base::STATUS_TRUE ) );
		}

		//一个订单下，可能存在两条记录，例如一个订单数量2，赠送出去又被送回来，那么相当于有两条资产记录，总剩余数量为2.
		$asset_items_num = 0;
		$assetItemIds = array();
		foreach( $asset_items as $k=>$v ){
			$asset_items_num += $v['qty'];
			$assetItemIds[$v['item_id']] = $v;
		}

		//判断数量
		if( $asset_items_num < 1 || $num < 1 || $asset_items_num < $num ){

			if($return_flag) {
				return array('status' => Soma_base::STATUS_FALSE, 'message' => '数量不足或核销数量超出剩余数量！');
			}

			$this->session->put_error_msg('数量不足或核销数量超出剩余数量！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?batch='.Soma_base::STATUS_TRUE ) );
		}

		//取出核销码
        $this->load->model('soma/Consumer_code_model');
        $Consumer_code_model = $this->Consumer_code_model;
		$codeList = array();
		if( count( $assetItemIds ) > 0 ){
			//消费码的信息
			$filter = array();
			$filter['status'] = $Consumer_code_model::STATUS_SIGNED;
			$codeList = $Consumer_code_model->get_code_by_assetItemIds( array_keys( $assetItemIds ), $inter_id, $filter, $num );
		}
        if( count( $codeList ) == 0 ){

        	if($return_flag) {
				return array('status' => Soma_base::STATUS_FALSE, 'message' => '没有足够的核销码！');
			}

			$this->session->put_error_msg('没有足够的核销码！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?batch='.Soma_base::STATUS_TRUE ) );
		}

		//这里设置session的作用是，核销的时候不检查有效期
        $this->load->library('session');
        $this->session->set_userdata('not_check_expire', TRUE);

		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);
		//循环核销码，进行核销
		foreach ($codeList as $k => $v) {
			//核销条件
			$assetItemId = $v['asset_item_id'];
			$code = $v['code'];
			$consumer_name = $this->session->get_admin_username();
			$consumer_method = $model::CONSUME_METHOD_SERVICE;//后台核销
			$name = NULL;

			//消费细单不存在，直接核销
			$return = $model->direct_consumer( $code, $consumer_name, $consumer_method, $inter_id, $business );
			if( isset( $return['status'] ) && $return['status'] == Soma_base::STATUS_TRUE ){
	    		$result = TRUE;
	    	}else{
	    		$result = FALSE;
	    	}
	    }
	    $this->session->set_userdata('not_check_expire', FALSE);

    	$openid = isset( $asset_items[0]['openid'] ) ? $asset_items[0]['openid'] : NULL;
		if( $result ){
			/***********************发送模版消息****************************/
	    	//发送模版消息
	    	$this->load->model('soma/Message_wxtemp_template_model','MessageWxtempTemplateModel');
			$MessageWxtempTemplateModel = $this->MessageWxtempTemplateModel;
			
			$openid = $openid;
			$inter_id= $this->session->get_admin_inter_id();

			$type = $MessageWxtempTemplateModel::TEMPLATE_CONSUMER_SUCCESS;

			$this->load->model('soma/Asset_customer_model','AssetCustomerModel');
			$AssetCustomerModel = $this->AssetCustomerModel;
			$AssetCustomerModel->asset_item_id = $assetItemId;
			$AssetCustomerModel->code = NULL;

			$MessageWxtempTemplateModel->send_template_by_consume_or_booking_success( $type, $AssetCustomerModel, $openid, $inter_id, $business);
			/***********************发送模版消息****************************/
		}
		
		if($return_flag) {
			if($result) {
				return array('status' => Soma_base::STATUS_TRUE, 'message' => '核销成功！');
			} else {
				return array('status' => Soma_base::STATUS_FALSE, 'message' => '核销失败！');
			}
		}

		$message = ($result)?
    	            $this->session->put_success_msg('核销成功'):
    	            $this->session->put_notice_msg( isset( $return['message'] ) ? $return['message'] : '核销失败！');
	    $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?batch='.Soma_base::STATUS_TRUE));

	}

	/**
	 * 预约
	 * @author luguihong
	 * @deprecated
	 */
	public function booking()
	{
		// var_dump( $this->input->post() );exit;
		// $type = isset( $this->input->get('type') ) ? $this->input->get('type') : self::TYPE_BOOKING;
		$type = $this->input->get('type');
		if( !isset( $type ) ){
			$type = self::TYPE_BOOKING;
		}

		$item_id = $this->input->get('ids');
		$code = $this->input->get( 'code' );
		
		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);

		//预约条件
		$asset_item_id = $item_id + 0;//资产库细单ID
		$inter_id = $this->_get_real_inter_id( TRUE );
		$business = 'package';
//测试使用
// $inter_id = 'a429262687';   

		if( !$asset_item_id ){
			$this->session->put_notice_msg('预约加载失败');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?ids='.$code ) );
		}
		
		//预约
		//资产model
		$this->load->model('soma/asset_customer_model');
		$asset_customer_model = $this->asset_customer_model;
		//要传入的参数
		$items = $asset_customer_model->get_asset_items_by_itemId( $asset_item_id, $business, $inter_id );
		if( !$items ){
			$this->session->put_notice_msg('没有找到预约信息！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?ids='.$code ) );
		}


		//要判断最大预约数
		//取出商品的最大预约数
		// $product_id = $items[0]['product_id'];
		// $this->load->model( 'soma/Product_package_model', 'product' );
		// $max_reserve = $this->product->get_max_reserve( $product_id, $inter_id );
		// if( $max_reserve ){
		// 	$max_reserve = $max_reserve[0]['max_reserve'];
		// }

		// if( $max_reserve > 0 ){
		
		// }else{
		// 	$this->session->put_notice_msg('已经预约完了');
		// 	$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?ids='.$code ) );
		// }

		$items[0]['consumer_code'] = $code;

		//判断是否是该公众号下的
		if( $items[0]['inter_id'] != $inter_id ){
			$this->session->put_notice_msg('没有找到核销信息！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?ids='.$code ) );
		}

		//判断是否是该公众号下的
		if( $items[0]['qty'] < 1 ){
			$this->session->put_notice_msg('没有足够的数量');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?ids='.$code ) );
		}

		//生成消费单之前，需要检查是否已经生成过消费单了
		//生成消费单

// 		$order_item = $model->get_consumer_order_item( $asset_item_id, $code, $business, $inter_id );
// 		$model->order_item = $order_item;
// var_dump( $order_item );exit;

		$items[0]['consumer_time'] = NULL;
    	$items[0]['consume_status'] = $model::STATUS_PENDING;//可以预约的生成消费主单，并且状态为未使用
    	$items[0]['consumer_type'] = $model::CONSUME_TYPE_DEFAULT;
    	$items[0]['consumer_method'] = $model::CONSUME_METHOD_SERVICE;//后台核销
		$items[0]['consumer'] = $this->session->get_admin_username();

    	$this->load->model( 'soma/Consumer_item_'.$business.'_model', 'ConsumerItemModel' );
    	$ConsumerItemModel = $this->ConsumerItemModel;
    	$items[0]['consume_item_status'] = $ConsumerItemModel::STATUS_ITEM_PENDING;//消费细单状态

    	$msg_success = '预约成功';
	    $msg_fail = '预约失败';
		if( $type == self::TYPE_BOOKING_CONSUMER ){
			//预约并核销
			$items[0]['consumer_time'] = date( "Y-m-d H:i:s", time() );
	    	$items[0]['consume_status'] = $model::STATUS_ALLUSE;//状态改为已使用
	    	$items[0]['consume_item_status'] = $ConsumerItemModel::STATUS_ITEM_CONSUME;//消费细单状态

	    	$msg_success = '预约并核销成功';
	    	$msg_fail = '预约并核销失败';
		}

		$model->asset_item = $items;

		$model->business = $business;
		$model->can_reserve = $asset_customer_model::ITEMS_CAN_RESERVE_YES;
		$result = $model->asset_to_consumer( $business, $inter_id );

		$message = ($result)?
    	            $this->session->put_success_msg($msg_success):
    	            $this->session->put_notice_msg($msg_fail);
	    $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
	}

	//保存备注
	protected function remark_save()
	{
		$inter_id = $inter_id = $this->_get_real_inter_id( TRUE );
		$business = 'package';

		$remark = $this->input->post('remark');
		$assetItemId = $this->input->get('ids');
		$code = $this->input->get('code');
		// var_dump( $this->input->post(), $this->input->get() );die;
		if( !$remark || !$assetItemId || !$code ){
			// die();
		}else{
			$this->load->model('soma/Consumer_item_'.$business.'_model','ConsumerItemModel');
			$ConsumerItemModel = $this->ConsumerItemModel;
			//查出对应的消费细单
			$items = $ConsumerItemModel->get_consumer_order_item( $assetItemId, $code, $business, $inter_id );
			if( count( $items ) > 0 ){
				$item_id = $items[0]['item_id'];
				$ConsumerItemModel->remark_save( $item_id, htmlspecialchars( $remark ), $inter_id, $business );
			}
		}
	}

	/**
	 * 预约
	 * @author luguihong
	 */
	public function booking_post( $return_flag = false )
	{
		$type = $this->input->get('type');
		if( !isset( $type ) ){
			$type = self::TYPE_BOOKING;
		}

		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);

		//预约条件
		$code = $this->input->get( 'code' );
		$consumer_name = $this->session->get_admin_username();
		$consumer_method = $model::CONSUME_METHOD_SERVICE;//后台核销
		$inter_id = $this->_get_real_inter_id( TRUE );

		$assetItemId = $this->input->get('ids');
		$this->load->model('soma/Asset_item_package_model','ItemModel');
		$ItemModel = $this->ItemModel->load( $assetItemId );
		if( $ItemModel->m_get('type') == $ItemModel::PRODUCT_TYPE_PRIVILEGES_VOUCHER ){
			//后台不能使用特权券！
			
			if($return_flag) {
				return array('status' => Soma_base::STATUS_FALSE, 'message' => '后台不能使用特权券！');
			}

			$this->session->put_notice_msg('后台不能使用特权券！');
	    	$this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
		}
		
		$business = 'package';
		if( $type == self::TYPE_BOOKING_CONSUMER ){
			//预约并核销
			$this->load->model( 'soma/Consumer_item_'.$business.'_model', 'ConsumerItemModel' );
    		$ConsumerItemModel = $this->ConsumerItemModel;
    		
			$items[0]['consumer_time'] = date( "Y-m-d H:i:s", time() );
	    	$items[0]['consume_status'] = $model::STATUS_ALLUSE;//状态改为已使用
	    	$items[0]['consume_item_status'] = $ConsumerItemModel::STATUS_ITEM_CONSUME;//消费细单状态

			$return = $model->direct_consumer( $code, $consumer_name, $consumer_method, $inter_id, $business );
	    	
	    	if( isset( $return['status'] ) && $return['status'] == Soma_base::STATUS_TRUE ){
	    		$result = TRUE;
	    		$msg_success = '预约并核销成功';

	    		/***********************发送模版消息****************************/
		    	//发送模版消息
		    	$this->load->model('soma/Message_wxtemp_template_model','MessageWxtempTemplateModel');
				$MessageWxtempTemplateModel = $this->MessageWxtempTemplateModel;

				$openid = $return['data'][0]['openid'];
				$inter_id= $this->session->get_admin_inter_id();

				$type = $MessageWxtempTemplateModel::TEMPLATE_CONSUMER_SUCCESS;

				$this->load->model('soma/Asset_customer_model','AssetCustomerModel');
				$AssetCustomerModel = $this->AssetCustomerModel;
				$AssetCustomerModel->asset_item_id = $return['data'][0]['item_id'];
				$AssetCustomerModel->code = $code;

				$MessageWxtempTemplateModel->send_template_by_consume_or_booking_success( $type, $AssetCustomerModel, $openid, $inter_id, $business);

				/***********************发送模版消息****************************/

		    	//保存备注信息
				$this->remark_save();

	    	}else{
	    		$result = FALSE;
	    		$msg_fail = isset( $return['message'] ) ? $return['message'] : '预约并核销失败';
	    	}


		}else{
			$return = $model->booking_consumer( $code, $consumer_name, $consumer_method, $inter_id, $business );

			if( isset( $return['status'] ) && $return['status'] == Soma_base::STATUS_TRUE ){
				$result = TRUE;
	    		$msg_success = '预约成功';

				/***********************发送模版消息****************************/
		    	//发送模版消息
		    	$this->load->model('soma/Message_wxtemp_template_model','MessageWxtempTemplateModel');
				$MessageWxtempTemplateModel = $this->MessageWxtempTemplateModel;

				$openid = $return['data'][0]['openid'];
				$inter_id= $this->session->get_admin_inter_id();

				$type = $MessageWxtempTemplateModel::TEMPLATE_BOOKING_SUCCESS;

				$this->load->model('soma/Asset_customer_model','AssetCustomerModel');
				$AssetCustomerModel = $this->AssetCustomerModel;
				$AssetCustomerModel->asset_item_id = $return['data'][0]['item_id'];
				$AssetCustomerModel->code = $code;

				$MessageWxtempTemplateModel->send_template_by_consume_or_booking_success( $type, $AssetCustomerModel, $openid, $inter_id, $business);
				/***********************发送模版消息****************************/

		    	//保存备注信息
				$this->remark_save();

	    	}else{
	    		$result = FALSE;
	    		$msg_fail = isset( $return['message'] ) ? $return['message'] : '预约失败';
	    	}
		}
    	
		if($return_flag) {
			if($result) {
				return array('status' => Soma_base::STATUS_TRUE, 'message' => $msg_success);
			} else {
				return array('status' => Soma_base::STATUS_FALSE, 'message' => $msg_fail);
			}
		}

		$message = ($result)?
    	            $this->session->put_success_msg($msg_success):
    	            $this->session->put_notice_msg($msg_fail);
	    $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
	}

	/**
	 * 核销
	 * @author luguihong
	 * @deprecated
	 */
	public function consumer(){

		$item_id = $this->input->get('ids');
		$code = $this->input->get('code');
		
		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);

		//核销条件
		$asset_item_id = $item_id + 0;
		$inter_id = $this->_get_real_inter_id( TRUE );
		$business = 'package';
//测试使用
// $inter_id = 'a429262687'; 

		$this->load->model('soma/asset_customer_model');
		$asset_customer_model = $this->asset_customer_model;
		$items = $asset_customer_model->get_asset_items_by_itemId( $asset_item_id, $business, $inter_id );
		if( !$items ){
			$this->session->put_notice_msg('没有找到核销信息！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?ids='.$code ) );
		}

		//判断是否是该公众号下的
		if( $items[0]['inter_id'] != $inter_id ){
			$this->session->put_notice_msg('没有找到核销信息！');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?ids='.$code ) );
		}

		if( $items[0]['qty'] < 1 ){
			$this->session->put_notice_msg('没有足够的数量');
			$this->_redirect( Soma_const_url::inst()->get_url( '*/*/grid?ids='.$code ) );
		}

		//判断是否已经消费了
		$asset_status = $asset_customer_model::STATUS_ITEM_SIGNED;//已经消费
		if( $items[0]['status'] == $asset_status ){
			//已经消费
			$this->session->put_notice_msg('核销码已经消费！');
	    	$this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
		}else{

			$items[0]['consumer_code'] = $code;


	    	$this->load->model( 'soma/Consumer_item_'.$business.'_model', 'ConsumerItemModel' );
	    	$ConsumerItemModel = $this->ConsumerItemModel;

			$order_item = $model->get_consumer_order_item( $asset_item_id, $code, $business, $inter_id );
			if( $order_item ){
				$order_item = array_reverse( $order_item );//翻转数组
				$consume_item_status = $ConsumerItemModel::STATUS_ITEM_CONSUME;//已使用
	    		if( $order_item[0]['status'] == $consume_item_status ){
	    			//已经消费
					$this->session->put_notice_msg('核销码已经消费！');
			    	$this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
	    		}
			}

			$model->order_item = $order_item;//需要预约的要用到

			$items[0]['consumer_time'] = date( 'Y-m-d H:i:s', time() );
	    	$items[0]['consume_status'] = $model::STATUS_ALLUSE;//已使用
	    	$items[0]['consumer_type'] = $model::CONSUME_TYPE_DEFAULT;
	    	$items[0]['consumer_method'] = $model::CONSUME_METHOD_SERVICE;//后台核销
			$items[0]['consumer'] = $this->session->get_admin_username();

	    	$items[0]['consume_item_status'] = $ConsumerItemModel::STATUS_ITEM_CONSUME;//消费细单状态

			$asset_customer_model->item = $items;//细单对象
			$model->asset_item = $items;

			$model->business = $business;
			$asset_customer_model->consumer = $model;//消费单的model

			//码表的model
			// $code_name = $this->main_consumer_code_model_name();
			// $this->load->model( $code_name, 'consumer_code_model' );
			// $consumer_code_model = $this->consumer_code_model;
			// $asset_customer_model->consumer_code = $consumer_code_model;
			
			$asset_customer_model->business = $business;
			$result = $asset_customer_model->consumer_asset_items( $business, $inter_id );
		}
		
		$message = ($result)?
    	            $this->session->put_success_msg('核销成功'):
    	            $this->session->put_notice_msg('核销失败！');
	    $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
	}

	/**
	 * 核销
	 * @author luguihong
	 */
	public function consumer_post(){
		
		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);

		//核销条件
		$assetItemId = $this->input->get('ids');
		$code = $this->input->get('code');
		$consumer_name = $this->session->get_admin_username();
		$consumer_method = $model::CONSUME_METHOD_SERVICE;//后台核销
		$inter_id = $this->_get_real_inter_id( TRUE );
		$business = 'package';
		$name = NULL;

		//消费细单信息
		$model->business = $business;

		$this->load->model('soma/Asset_item_package_model','ItemModel');
		$ItemModel = $this->ItemModel->load( $assetItemId );
		if( $ItemModel->m_get('type') == $ItemModel::PRODUCT_TYPE_PRIVILEGES_VOUCHER ){
			//后台不能使用特权券！
			$this->session->put_notice_msg('后台不能使用特权券！');
	    	$this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
		}

		$order_item = $model->get_consumer_order_item( $assetItemId, $code, $business, $inter_id );
		if( $order_item ){
			//消费细单存在，改变消费单的状态
			$this->load->model( 'soma/Consumer_item_'.$business.'_model', 'ConsumerItemModel' );
    		$ConsumerItemModel = $this->ConsumerItemModel;

			$order_item = array_reverse( $order_item );//翻转数组
			$consume_item_status = $ConsumerItemModel::STATUS_ITEM_CONSUME;//已使用
    		if( $order_item[0]['status'] == $consume_item_status ){
    			//已经消费
				$this->session->put_notice_msg('核销码已经消费！');
		    	$this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
    		}

			//需要预约的核销要用到
			$model->order_item = $order_item;
			$result = $model->consumer_order_consume( $business, $inter_id );

	    	$openid = isset( $order_item[0]['openid'] ) ? $order_item[0]['openid'] : NULL;
		}else{
			//消费细单不存在，直接核销
			$return = $model->direct_consumer( $code, $consumer_name, $consumer_method, $inter_id, $business );
			if( isset( $return['status'] ) && $return['status'] == Soma_base::STATUS_TRUE ){
	    		$result = TRUE;
	    	}else{
	    		$result = FALSE;
	    	}

	    	$openid = isset( $return['data'][0]['openid'] ) ? $return['data'][0]['openid'] : NULL;
		}

		if( $result ){
			/***********************发送模版消息****************************/
	    	//发送模版消息
	    	$this->load->model('soma/Message_wxtemp_template_model','MessageWxtempTemplateModel');
			$MessageWxtempTemplateModel = $this->MessageWxtempTemplateModel;
			
			$openid = $openid;
			$inter_id= $this->session->get_admin_inter_id();

			$type = $MessageWxtempTemplateModel::TEMPLATE_CONSUMER_SUCCESS;

			$this->load->model('soma/Asset_customer_model','AssetCustomerModel');
			$AssetCustomerModel = $this->AssetCustomerModel;
			$AssetCustomerModel->asset_item_id = $assetItemId;
			$AssetCustomerModel->code = $code;

			$MessageWxtempTemplateModel->send_template_by_consume_or_booking_success( $type, $AssetCustomerModel, $openid, $inter_id, $business);
			/***********************发送模版消息****************************/

			//保存备注信息
			$this->remark_save();
		}
		
		$message = ($result)?
    	            $this->session->put_success_msg('核销成功'):
    	            $this->session->put_notice_msg( isset( $return['message'] ) ? $return['message'] : '核销失败！');
	    $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?ids='.$code));
	}


	/**
	 * 禁止进行删除操作
	 */
	public function delete()
	{
	    $url= Soma_const_url::inst()->get_url('*/*/index');
	    redirect($url);
	}


	/**
	 * 内部根据消费码直接核销
	 * 不做过多检查，直接核销
	*/
	public function consume()
	{

		//防止其他账号使用该功能。
	    $this->_toolkit_writelist();

		$this->label_action= '内部直接核销';
		$this->_init_breadcrumb($this->label_action);
		
		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);
		
        if(!$model) $model= $this->_load_model();
		$fields_config= $model->get_field_config('form');

		// $code = isset( $_POST['code'] ) && !empty( $_POST['code'] ) ? $_POST['code'] : NULL;
		$code = $this->input->post('code');
		// $inter_id = isset( $_POST['inter_id'] ) && !empty( $_POST['inter_id'] ) ? $_POST['inter_id'] : NULL;
		$inter_id = $this->input->post('inter_id');
		if( $code && $inter_id ){
			
			if( $inter_id ){
				//初始化数据库分片配置，微信接口关闭订单需要初始化shard_id
                $this->load->model('soma/shard_config_model', 'model_shard_config');
                $this->current_inter_id= $inter_id;
                $this->db_shard_config= $this->model_shard_config->build_shard_config( $inter_id );
                //print_r($this->db_shard_config);
			}

			//去核销
			//消费model
			$this->load->model( 'soma/Consumer_order_model', 'ConsumerOrderModel' );
			$ConsumerOrderModel = $this->ConsumerOrderModel;
			$result = $ConsumerOrderModel->consume( $code, $inter_id );
			if( isset( $result['status'] ) && $result['status'] == Soma_base::STATUS_TRUE ){
            	$this->session->put_success_msg( '核销成功' );
			}else{
            	$this->session->put_notice_msg( $result['message'] );
			}
	    	$this->_redirect(Soma_const_url::inst()->get_url('*/*/consume'));
		}

		$filter= array();
		$this->load->model('wx/publics_model');
        $publics= $this->publics_model->get_public_hash($filter);
        $publics= $this->publics_model->array_to_hash($publics, 'name', 'inter_id');
        
        $options = '<option value="">请选择公众号</option>';
        foreach( $publics as $sk=>$sv ){

        	$selected = '';
        	if( $inter_id == $sk ){
        		$selected = 'selected';
        	}

        	$options .= '<option value="'.$sk.'" '.$selected.'>'.$sv.'</option>';
        }

		$btn= '<div class="form-group ">
                <label class="col-sm-2 control-label">选择公众号</label>
                <div class="col-sm-6 inline">
                    <select class="form-control selectpicker show-tick" data-live-search="true" name="inter_id" id="interId">'.$options.'</select>
                </div>
            </div>';
		$btn.= '<div class="form-group ">
                <label class="col-sm-2 control-label">核销码</label>
                <div class="col-sm-6 inline">
                    <input type="text" maxlength="12" style="font-size:25px;line-height:40px;height:40px;" class="form-control " name="code" id="el_consumer_code" value="'.$code.'">
                </div><div style="height:40px;line-height:40px;">请输入12位核销码</div>
            </div>';

		$view_params= array(
		    'model'=> $model,
		    'code'=> $code,
		    'fields_config'=> $fields_config,
		    'btn'=> $btn,
		);
		$inter_id= $this->session->get_admin_inter_id();
		if($inter_id && $inter_id != FULL_ACCESS){
		    $view_params['inter_id']= $inter_id;
		}
		$html= $this->_render_content($this->_load_view_file('consume'), $view_params, TRUE);
		echo $html;

	}

	/**
	 * 内部根据消费码或者订单号查询数据
	 * 查询包括消费码明细，订单明细，资产明细，消费明细
	*/
	public function get_info()
	{
		//防止其他账号使用该功能。
	    $this->_toolkit_writelist();

	    $this->label_action= '内部根据消费码或者订单号查找信息';
		$this->_init_breadcrumb($this->label_action);
		
		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);
		
        if(!$model) $model= $this->_load_model();
		$fields_config= $model->get_field_config('form');

		// $code = isset( $_POST['code'] ) && !empty( $_POST['code'] ) ? $_POST['code'] : NULL;
		// $inter_id = isset( $_POST['inter_id'] ) && !empty( $_POST['inter_id'] ) ? $_POST['inter_id'] : NULL;
		// $order_id = isset( $_POST['order_id'] ) && !empty( $_POST['order_id'] ) ? $_POST['order_id'] : NULL;
		$code = $this->input->post('code');
		$inter_id = $this->input->post('inter_id');
		$order_id = $this->input->post('order_id');
		$gift_id = $this->input->post('gift_id');

		$code_codeDetail = NULL;
		$code_orderDetail = NULL;
		$code_assetItems = NULL;
		$code_consumerDetail = NULL;
		$code_giftDetail = NULL;
		$code_refundDetail = NULL;

		$order_codeDetail = NULL;
		$order_orderDetail = NULL;
		$order_assetItems = NULL;
		$order_consumerDetail = NULL;
		$order_giftDetail = NULL;
		$order_refundDetail = NULL;

		$gift_codeDetail = NULL;
		$gift_orderDetail = NULL;
		$gift_assetItems = NULL;
		$gift_consumerDetail = NULL;
		$gift_giftDetail = NULL;
		$gift_selfGiftDetail = array();
		$gift_refundDetail = NULL;

		$codeStatus	= array();
		$giftStatus = array();
		$orderStatus = array();
		$ConsumerStatus = array();
		$ConsumerItemStatus = array();
		$refundStatus = array();
		$giftTypeStatus = array();
		$orderRefundStatus = array();
		$orderConsumerStatus = array();
		$ConsumerMothedStatus = array();
		$ConsumerTypeStatus = array();
		if( !$code && !$inter_id && !$order_id && !$gift_id ){
			
		} else {
			if( $inter_id ){
				//初始化数据库分片配置，微信接口关闭订单需要初始化shard_id
                $this->load->model('soma/shard_config_model', 'model_shard_config');
                $this->current_inter_id= $inter_id;
                $this->db_shard_config= $this->model_shard_config->build_shard_config( $inter_id );
                //print_r($this->db_shard_config);
			}
		
			$business = 'package';

			//消费码model
			$this->load->model('soma/consumer_code_model','ConsumerCodeModel');
			$ConsumerCodeModel = $this->ConsumerCodeModel;
			$codeStatus = $ConsumerCodeModel->get_status_label();

			//赠送model
			$this->load->model( 'soma/Gift_order_model', 'GiftOrderModel' );
			$GiftOrderModel = $this->GiftOrderModel;
			$giftStatus = $GiftOrderModel->get_status_label();
			$giftTypeStatus = $GiftOrderModel->get_gift_type_label();

			//订单model
			$this->load->model('soma/Sales_order_model','SalesOrderModel');
			$SalesOrderModel = $this->SalesOrderModel;
			$SalesOrderModel->business = $business;
			$orderStatus = $SalesOrderModel->get_status_label();
			$orderRefundStatus = $SalesOrderModel->get_refund_label();
			$orderConsumerStatus = $SalesOrderModel->get_consume_label();

			//消费model
			$this->load->model( 'soma/Consumer_order_model', 'ConsumerOrderModel' );
			$ConsumerOrderModel = $this->ConsumerOrderModel;
			$ConsumerStatus = $ConsumerOrderModel->get_status_label();
			$ConsumerMothedStatus = $ConsumerOrderModel->get_method_label();
			$ConsumerTypeStatus = $ConsumerOrderModel->get_type_label();

			$this->load->model( 'soma/Consumer_item_'.$business.'_model', 'ConsumerItemModel' );
			$ConsumerItemModel = $this->ConsumerItemModel;
			$ConsumerItemStatus = $ConsumerItemModel->get_item_status_label();

			//资产细单model
			$this->load->model( 'soma/Asset_item_'.$business.'_model', 'AssetItemModel' );
			$AssetItemModel = $this->AssetItemModel;

			//退款
			$this->load->model('soma/Sales_refund_model','SalesRefundModel');
			$SalesRefundModel = $this->SalesRefundModel;
			$refundStatus = $SalesRefundModel->get_status_label();

			//根据消费码搜索信息
			if( $code && $inter_id ){
				//根据码查询信息
				$code_codeDetail = $ConsumerCodeModel->get_consumer_code_info_by_code( $code, $inter_id );

				if( $code_codeDetail ){
					//查询订单信息
					$data = $this->_get_data( $code_codeDetail['order_id'], $business, $inter_id );
					$inter_id = $data['orderDetail']['inter_id'];

					$code_orderDetail = isset( $data['orderDetail'] ) ? $data['orderDetail'] : NULL;
					$code_assetItems = isset( $data['assetItems'] ) ? $data['assetItems'] : NULL;
					$code_consumerDetail = isset( $data['consumerDetail'] ) ? $data['consumerDetail'] : NULL;
					$code_giftDetail = isset( $data['giftDetail'] ) ? $data['giftDetail'] : NULL;
					$code_refundDetail = isset( $data['refundDetail'] ) ? $data['refundDetail'] : NULL;
				}
			}

			//根据订单号搜索信息
			if( $order_id && $inter_id ){

				$data = $this->_get_data( $order_id, $business, $inter_id );
				$inter_id = $data['orderDetail']['inter_id'];

				$order_orderDetail = isset( $data['orderDetail'] ) ? $data['orderDetail'] : NULL;
				$order_assetItems = isset( $data['assetItems'] ) ? $data['assetItems'] : NULL;
				$order_consumerDetail = isset( $data['consumerDetail'] ) ? $data['consumerDetail'] : NULL;
				$order_giftDetail = isset( $data['giftDetail'] ) ? $data['giftDetail'] : NULL;
				$order_refundDetail = isset( $data['refundDetail'] ) ? $data['refundDetail'] : NULL;
				
				//消费码的信息
				// $filter = array();
				// $filter['order_id'] = $order_id;
				// $order_codeDetail = $ConsumerCodeModel->get_code_by_orderId( $filter, NULL, $inter_id );
				if( count( $order_assetItems ) > 0 ){
					$assetItemIds = array();
					foreach ($order_assetItems as $k => $v) {
						$assetItemIds[$v['item_id']] = $v;
					}

					if( count( $assetItemIds ) > 0 ){
						//消费码的信息
						$order_codeDetail = $ConsumerCodeModel->get_code_by_assetItemIds( array_keys( $assetItemIds ), $inter_id );
					}
				}

			}

			//根据赠送编号搜索信息
			if( $gift_id && $inter_id ){
				//防止其他账号使用该功能。
	    		$this->_toolkit_writelist();

				$GiftOrderModel = $GiftOrderModel->load($gift_id);
				if( !$GiftOrderModel ){
					die('赠送编号不存在！');
				}
				$inter_id = $GiftOrderModel->m_get('inter_id');

				//赠送信息
				$gift_giftDetail = array();
				if( $GiftOrderModel ){
					$gift_info = array();
					$gift_info = $GiftOrderModel->m_data();
					$gift_info['items'] = array();
					if( $GiftOrderModel->m_get('is_p2p') == Soma_base::STATUS_FALSE ){
						$gift_info['items'] = $GiftOrderModel->get_receiver_list( $inter_id, $gift_id );
					}
					$gift_selfGiftDetail[] = $gift_info;

					//待发送、超时退回
					$gifts = $GiftOrderModel->get_order_list($business, $inter_id, array( 'send_order_id'=>$gift_id, 'send_from'=>Soma_base::STATUS_FALSE ) );
					if( count( $gifts ) > 0 ){
						foreach ($gifts as $k => $v) {
							// if( !$v['openid_received'] && $v['is_p2p'] == Soma_base::STATUS_TRUE ){
								$v['items'] = array();

								if( $v['is_p2p'] == Soma_base::STATUS_FALSE ){
									$v['items'] = $GiftOrderModel->load( $v['gift_id'] )->get_receiver_list( $inter_id, $v['gift_id'] );
								}

								$gift_giftDetail[] = $v;
							// }
						}
					}
				}

				//资产信息
				$gift_assetItems = $AssetItemModel->get_order_items_byGiftids($gift_id, $business, $inter_id);

				//这里主要是获取消费信息
				if( count( $gift_assetItems ) > 0 ){
					$orderIds = array();
					$assetItemIds = array();
					foreach ($gift_assetItems as $k => $v) {
						$orderIds[] = $v;
						$assetItemIds[$v['item_id']] = $v;
					}

					if( count( $assetItemIds ) > 0 ){
						//消费码的信息
						$gift_codeDetail = $ConsumerCodeModel->get_code_by_assetItemIds( array_keys( $assetItemIds ), $inter_id );
					}

					$gift_consumerDetail = array();
					if( count( $orderIds ) > 0 ){

						//消费信息
						foreach ($orderIds as $k => $v) {
							$consumerItemDetail = $SalesOrderModel->load( $v['order_id'] )->get_order_consumer($business, $inter_id );
							if( isset( $consumerItemDetail['items'] ) ){

								foreach ($consumerItemDetail['items'] as $sk => $sv) {
									// var_dump( $sv );die;
									if( $v['item_id'] == $sv['asset_item_id'] ){

										$consumer_id = $sv['consumer_id'];
										$ConsumerOrderModel = $ConsumerOrderModel->load( $consumer_id );
										if( $ConsumerOrderModel ){
											$consumer_info = $ConsumerOrderModel->m_data();
											$consumer_info['items'] = $sv;
											$gift_consumerDetail[] = $consumer_info;
										}
									}
								}
							}

							//退款信息
							$refundDetail = $SalesRefundModel->get_refund_order_detail_byOrderId( $v['order_id'], $inter_id );
							if( $refundDetail ){
								$refundDetail['items'] = array();
								$gift_refundDetail[] = $refundDetail;
							}
						}
					}
				}
// var_dump( $gift_codeDetail );die;
// var_dump( $gift_assetItems );die;
// var_dump( $gift_consumerDetail );die;
// var_dump( $gift_giftDetail );die;
			}
		}

		$filter= array();
		$this->load->model('wx/publics_model');
        $publics= $this->publics_model->get_public_hash($filter);
        $publics= $this->publics_model->array_to_hash($publics, 'name', 'inter_id');

		$view_params= array(
		    'model'=> $model,
		    'code'=> $code,
		    'publics'=> $publics,
		    'fields_config'=> $fields_config,
		    // 'btn'=> $btn,
		    'order_id'=> $order_id,
		    'gift_id'=> $gift_id,
		    'inter_id'=> $inter_id,

			'codeStatus'=>$codeStatus,
			'giftStatus'=>$giftStatus,
			'giftTypeStatus'=>$giftTypeStatus,
			'orderStatus'=>$orderStatus,
			'ConsumerStatus'=>$ConsumerStatus,
			'ConsumerTypeStatus'=>$ConsumerTypeStatus,
			'ConsumerMothedStatus'=>$ConsumerMothedStatus,
			'ConsumerItemStatus'=>$ConsumerItemStatus,
			'refundStatus'=>$refundStatus,
			'orderRefundStatus'=>$orderRefundStatus,
			'orderConsumerStatus'=>$orderConsumerStatus,

		    'code_codeDetail'=>$code_codeDetail,
			'code_orderDetail'=>$code_orderDetail,
			'code_assetItems'=>$code_assetItems,
			'code_consumerDetail'=>$code_consumerDetail,
			'code_giftDetail'=>$code_giftDetail,
			'code_refundDetail'=>$code_refundDetail,

			'order_codeDetail'=>$order_codeDetail,
			'order_orderDetail'=>$order_orderDetail,
			'order_assetItems'=>$order_assetItems,
			'order_consumerDetail'=>$order_consumerDetail,
			'order_giftDetail'=>$order_giftDetail,
			'order_refundDetail'=>$order_refundDetail,

			'gift_codeDetail'=>$gift_codeDetail,
			'gift_orderDetail'=>$gift_orderDetail,
			'gift_assetItems'=>$gift_assetItems,
			'gift_consumerDetail'=>$gift_consumerDetail,
			'gift_giftDetail'=>$gift_giftDetail,
			'gift_selfGiftDetail'=>$gift_selfGiftDetail,
			'gift_refundDetail'=>$gift_refundDetail,
		);
		$inter_id= $this->session->get_admin_inter_id();
		if($inter_id && $inter_id != FULL_ACCESS){
		    // $view_params['inter_id']= $inter_id;
		}
		$html= $this->_render_content($this->_load_view_file('get_info'), $view_params, TRUE);
		echo $html;
	}
	
	protected function _get_data( $order_id, $business, $inter_id )
	{
		//防止其他账号使用该功能。
	    $this->_toolkit_writelist();

		//订单model
		$this->load->model('soma/Sales_order_model','SalesOrderModel');
		$SalesOrderModel = $this->SalesOrderModel;

		//消费model
		$this->load->model( 'soma/Consumer_order_model', 'ConsumerOrderModel' );
		$ConsumerOrderModel = $this->ConsumerOrderModel;

		//赠送model
		$this->load->model( 'soma/Gift_order_model', 'GiftOrderModel' );
		$GiftOrderModel = $this->GiftOrderModel;

		$this->load->model( 'soma/Gift_item_'.$business.'_model', 'GiftItemModel' );
		$GiftItemModel = $this->GiftItemModel;

		$data = array();
		//查询订单信息
		$SalesOrderModel->business = $business;
		$SalesOrderModel = $SalesOrderModel->load($order_id);
		if( $SalesOrderModel ){
			$data['orderDetail'] = $SalesOrderModel->get_order_detail($business, $inter_id );
			//资产信息
			$assetDetail = $SalesOrderModel->get_order_asset($business, $inter_id );
			if( isset( $assetDetail['items'] ) ){
				$data['assetItems'] = $assetDetail['items'];
			}
			//消费信息
			$consumerItemDetail = $SalesOrderModel->get_order_consumer($business, $inter_id );
			if( isset( $consumerItemDetail['items'] ) ){

				foreach ($consumerItemDetail['items'] as $k => $v) {
					$consumer_id = $v['consumer_id'];
					$ConsumerOrderModel = $ConsumerOrderModel->load( $consumer_id );
					if( $ConsumerOrderModel ){
						$consumer_info = $ConsumerOrderModel->m_data();
						$consumer_info['items'] = $v;
						$data['consumerDetail'][] = $consumer_info;
					}
				}
			}
			//赠送信息
			if( isset( $data['assetItems'] ) ){
				$giftIds = array();
				foreach ($data['assetItems'] as $k => $v) {
					//计算个人送个人的
					if( !empty( $v['gift_id'] ) ){
						$giftIds[$v['gift_id']] = $v;
					}
				}

				//个人列表
				if( count($giftIds) > 0 ){
					// $GiftOrderModel = $GiftOrderModel->load( $gift_id );
					// $gift_info = $GiftOrderModel->m_data();
					$giftItems = $GiftItemModel->get_order_items_byIds(array_keys($giftIds), $business, $inter_id);
					if( count( $giftItems ) > 0 ){
						foreach ($giftItems as $k => $v) {
							$GiftOrderModel = $GiftOrderModel->load($v['gift_id']);
							if( $GiftOrderModel ){
								$gift_info = $GiftOrderModel->m_data();
								$gift_info['items'] = array();
								if( $GiftOrderModel->m_get('is_p2p') == Soma_base::STATUS_FALSE ){
									// $giftIds[$v['gift_id']]['items'] = $GiftOrderModel->get_receiver_list( $inter_id, $v['gift_id'] );
									$gift_info['items'] = $GiftOrderModel->get_receiver_list( $inter_id, $v['gift_id'] );
								}

								$data['giftDetail'][] = $gift_info;
							}
						}
					}
				}

				//待发送、超时退回（单人没有接收人，群发还没有第一个领取人）
				$gifts = $GiftOrderModel->get_order_list($business, $inter_id, array( 'send_order_id'=>$order_id, 'send_from'=>Soma_base::STATUS_TRUE ) );
				if( count( $gifts ) > 0 ){
					foreach ($gifts as $k => $v) {
						//如果接收人为空，代表没有接收
						if( !$v['openid_received'] ){

							$v['items'] = array();

							if( $v['is_p2p'] == Soma_base::STATUS_FALSE ){
								$receiver_lists = $GiftOrderModel->load( $v['gift_id'] )->get_receiver_list( $inter_id, $v['gift_id'] );
								if( $receiver_lists ){
									//如果已经存在第一个领取人，去掉这条信息，因为上面已经获取
									continue;
								}
							}

							$data['giftDetail'][] = $v;
						}
					}
				}
				// var_dump( $data['giftDetail'] );die;

			}

			//退款信息
			$this->load->model('soma/Sales_refund_model','SalesRefundModel');
			$SalesRefundModel = $this->SalesRefundModel;
			$refundDetail = $SalesRefundModel->get_refund_order_detail_byOrderId( $order_id, $inter_id );
			if( $refundDetail ){
				$refundDetail['items'] = array();
				$data['refundDetail'][] = $refundDetail;
			}

		}
// var_dump( $data['giftDetail'] );die;
		return $data;
	}

	//修改有效期
	public function expire_edit( $return = false )
	{

		$this->label_action= '修改有效期';
		$this->_init_breadcrumb($this->label_action);
		
		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);

		$product_id = $this->input->post('pid');
		if( !$product_id ){
			$this->session->put_error_msg('请输入商品ID');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?batch='.Soma_base::STATUS_FALSE));
		}

		//到订单细单里面查找同一个商品，不同有效期的商品组 group by expriation_date
		$business = 'package';
		$inter_id = $this->_get_real_inter_id( TRUE );
		$this->load->model('soma/Sales_item_'.$business.'_model','ItemModel');
		$ItemModel = $this->ItemModel;

		$select = 'inter_id,product_id,name,expiration_date';
		$items = $ItemModel->get_order_items_byProductIds( $product_id, $business, $inter_id, $select );
		if( count( $items ) == 0 ){
			$this->session->put_error_msg('找不到该数据');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?batch='.Soma_base::STATUS_FALSE));
		}

		//输出字段
		$grid_field= array(
						'product_id' => '商品ID',
						'name' => '商品名称',
						'expiration_date' => '过期时间',
					);

		$view_params= array(
		    'items'=> $items,
		    'model'=>$model,
		    'grid_field'=> $grid_field,
		);

		if($return) {
			return $view_params;
		}

		$html= $this->_render_content($this->_load_view_file('edit_expire'), $view_params, TRUE);
		echo $html;
	}
	public function expire_post( $return_flag = false )
	{
		// var_dump( $this->input->post() );die;
		$this->load->model('soma/Product_package_model','ProductModel');
		
		$ProductModel = $this->ProductModel;
		$oldTimes = $this->input->post('old_time');
		$newTimes = $this->input->post('new_time');
		$pids = $this->input->post('pid');

		$is_true = FALSE;
		foreach ($newTimes as $k => $v) {
			if( !empty( $v ) ){
				if( strlen($v)<=10 ) $v.= ' 23:59:59';
				//修改的有效期不能少于当前有效期
				if( $v > $oldTimes[$k] ){
					$data = array();
					$data['expiration_date'] = $v;
					
					$filter = array();
					$filter['expiration_date'] = $oldTimes[$k];

					$id= intval($pids[$k]);
					$result = $ProductModel->load($id)->update_related_table($data,$filter);
					if( $result ){
						$is_true = TRUE;
					}
					break;//现在一次只能处理一条
				}
			}
		}

		if($is_true) {
			//记录日志
			$post = $this->input->post();
		    $post['update_time'] = date('Y-m-d H:i:s');
			$post_admin = $this->session->get_admin_username();
		    $remote_ip = $this->input->ip_address();
		    $post['admin'] = $post_admin;
		    $post['admin_ip'] = $remote_ip;
			$this->write_log( json_encode( $post ) );

			if($return_flag) {
				return array('status' => Soma_base::STATUS_TRUE, 'message' => '已更新有效期！');
			}

			$this->session->put_success_msg('已更新有效期！');
			$this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?batch='.Soma_base::STATUS_FALSE));
		} else {

			if($return_flag) {
				return array('status' => Soma_base::STATUS_FALSE, 'message' => '更新有效期失败，请重新尝试！');
			}

			$this->session->put_error_msg('更新有效期失败，请重新尝试！');
			$this->_redirect(Soma_const_url::inst()->get_url('*/*/grid?batch='.Soma_base::STATUS_FALSE));
		}

	}
	

	/**
     * 消费列表按钮导出处理  预约和邮寄的不导出
     */
    public function export_list()
    {
	    $business= 'package';

        $this->load->model('soma/Consumer_order_model','ConsumerOrderModel');
        $ConsumerOrderModel = $this->ConsumerOrderModel;
    	$consumer_type= $this->input->get('consumer_type');//邮寄不算进来，现在只有核销使用
	    $start_time= $this->input->get('start_time');
	    $end_time= $this->input->get('end_time');
	    $hotel_id= $this->input->get('hotel_id');
	    $consumer= $this->input->get('consumer');
        $business= 'package';

        $inter_id= $this->session->get_admin_inter_id();
        if($inter_id == FULL_ACCESS ){
            $inter_id= $this->current_inter_id;
        }
    
        //不设定时间最多导出3个月的数据
        $item_field= array( 'consumer_code','name','price_package','order_id','remark' );
        $filter= array();
        $filter['status']= $ConsumerOrderModel::STATUS_ALLUSE;
        if($consumer_type) $filter['consumer_type']= $consumer_type;
        // if($hotel_id) $filter['hotel_id']= $hotel_id;
        // if($consumer) $filter['consumer']= $consumer;

        // 如果hotel_id不为空，添加hotel_id条件
        $ent_ids= $this->session->get_admin_hotels();
	    $hotel_ids= $ent_ids? explode(',', $ent_ids ): array();
	    if( count($hotel_ids)>0 ) $filter+= array('hotel_id'=> $hotel_ids );

        $data= $this->ConsumerOrderModel->export_item( $business, $inter_id, $filter, $item_field, $start_time, $end_time );
    	// var_dump( $data );die;

        /**
		'consumer_id' => string '1000000360' (length=10)
		'consumer_time' => string '2016-06-06 15:48:54' (length=19)
		'consumer_type' => string '核销使用' (length=12)
		'consumer' => string 'luguihong' (length=9)
		'consumer_code' => string '638909397955' (length=12)
		'name' => string '华山赏花祈福套餐＋华山门票2张' (length=43)
		'price_package' => string '0.01' (length=4)
		'order_id' => string '1000001653' (length=10)
         */

        $header= array( '核销券码','核销商品','核销价格','订单实付金额','订单号','备注','核销时间','核销方式','核销帐号' );
        $url= $this->_do_export($data, $header, 'csv', TRUE );
        //$url= $this->_do_export($data, $header, 'csv', FALSE ); //FALSE 直接echo内容
    }

    //日志写入
    protected function write_log( $content, $dir = 'expiration')
    {
        $file= date('Y-m-d'). '.txt';
        //echo $tmpfile;die;
        $path= APPPATH.'logs'.DS. $dir . DS;
        if( !file_exists($path) ) {
            @mkdir($path, 0777, TRUE);
        }
        $fp = fopen( $path. $file, 'a');

        $CI = & get_instance();
        $ip= $CI->input->ip_address();
        $content= str_repeat('-', 40). "\n[". date('Y-m-d H:i:s'). ']'
            ."\n". $ip. "\n". $content. "\n";
        fwrite($fp, $content);
        fclose($fp);
    }

    public function remark_post()
    {
    	$item_id = $this->input->post('iid');
    	$remark = $this->input->post('remark');

    	$inter_id= $this->session->get_admin_inter_id();
        if($inter_id == FULL_ACCESS ){
            $inter_id= $this->current_inter_id;
        }

		$business = 'package';
        $this->load->model("soma/Consumer_item_{$business}_model",'ItemModel');
    	
    	$ajax = $this->input->post('ajax');
    	if(  $ajax == Soma_base::STATUS_TRUE ){
	        $result = $this->ItemModel->remark_save( $item_id, $remark, $inter_id, $business );
	        $return = array();
	        $return['status'] = Soma_base::STATUS_TRUE;
	        $return['message'] = '保存成功';
	        echo json_encode( $return );die;
    	}else{
    		$url = $this->input->post('curr_url');
	    	if( !$url ){
	    		$url = Soma_const_url::inst()->get_url('*/*/grid?batch=export&start='.$this->input->post('start_time').'&end='.$this->input->post('end_time'));
	    	}
	        $result = $this->ItemModel->remark_save( $item_id, $remark, $inter_id, $business );
	       	$result ? $this->session->put_success_msg('修改备注成功') 
	       			: $this->session->put_notice_msg( isset( $return['message'] ) ? $return['message'] : '修改备注失败');
		    $this->_redirect($url);
		}
    }

    /**
     * ============================================================================
     * 核销新后台数据获取改为ajax提交与获取
     * ============================================================================
     */

    /**
     * ajax查询核销码对应的资产信息
     */
    public function ajax_consumer_code_info() {
    	$data = $this->edit(true);
    	$fmt_data = array();

   		$header = $grid_data = array();
   		foreach($data['grid_field'] as $key => $field) {
    		$header[] = $field;
    		$grid_data[] = $data['items'][$key];
    	}
    	$fmt_data['header'] = $header;
    	$fmt_data['data'] = array($grid_data);
    	$fmt_data['items'] = $data['items'];

    	echo json_encode($fmt_data);
    }

    /**
     * ajax核销操作
     */
    public function ajax_consumer_code() {
    	$op_res = $this->booking_post(true);
    	echo json_encode($op_res);
    }

    /**
     * ajax查询订单对应资产信息
     */
    public function ajax_consumer_order_info() {
		$data = $this->batch_edit(true);
		$order_data = $item_data = array();

		$header = $grid_data = array();
		foreach ($data['grid_field'] as $key => $field) {
			$header[] = $field;
			$grid_data[] = $data['order_detail'][$key];
		}

		$order_data['header'] = $header;
		$order_data['data'] = array($grid_data);

		$header = $grid_data = array();
		foreach ($data['item_grid_field'] as $key => $field) {
			$header[] = $field;
		}
		foreach ($data['asset_items'] as $row) {
			$tmp = array();
			foreach ($data['item_grid_field'] as $key => $field) {
				$tmp[] = $row[$key];
			}
			$grid_data[] = $tmp;
		}
		$item_data['header'] = $header;
		$item_data['data'] = $grid_data;

		echo json_encode(array('order_data' => $order_data, 'asset_data' => $item_data));
    }

    public function ajax_consumer_order() {
    	$op_res = $this->batch_post(true);
    	echo json_encode($op_res);
    }

    /**
     * ajax查询产品延期信息
     */
    public function ajax_consumer_product_info() {
    	$data = $this->expire_edit(true);
    	$fmt_data = $header = $grid_data = array();

    	foreach ($data['grid_field'] as $key => $field) {
    		$header[] = $field;
    	}
    	$header[] = '操作';

    	// var_dump($data);exit;

    	foreach ($data['items'] as $row) {
			$tmp = array();
			foreach ($data['grid_field'] as $key => $field) {
				$tmp[] = $row[$key];
			}
			$edit_column = '延期至：'
					. '<input type="type" class="expireTime" name="new_time[]" value="" placeholder="时间不能少于当前有效期">'
					. '<input type="hidden" name="old_time[]" value="' . $row['expiration_date'] . '">'
					. '<input type="hidden" name="pid[]" value="' . $row['product_id'] . '">';
			$tmp[] = $edit_column;
			$grid_data[] = $tmp;
		}
		$fmt_data['header'] = $header;
		$fmt_data['data'] = $grid_data;
		$fmt_data['items'] = $data['items'];
    	echo json_encode($fmt_data);
    }

    public function ajax_consumer_product() {
    	$op_res = $this->expire_post(true);
    	echo json_encode($op_res);
    }

    // ============================================================================

}
