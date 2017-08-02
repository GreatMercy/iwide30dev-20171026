<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_package extends MY_Admin_Soma {

	protected $label_module= NAV_PACKAGE_GROUPON;		//统一在 constants.php 定义
	protected $label_controller= '商品管理';		//在文件定义
	protected $label_action= '';				//在方法中定义

	protected $update_order_attr = false;		// 仅在editattribute()中改变该值
	
	protected function main_model_name()
	{
		return 'soma/product_package_model';
	}

	public function grid()
	{
		$this->label_action= '商品管理';
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
/* 兼容grid变为ajax加载加这一段 */
		if(is_ajax_request()) 
            //处理ajax请求，参数规格不一样
            $get_filter= $this->_ajax_params_parse( $this->input->post(), $model );
		
        else 
		    $get_filter= $this->input->get('filter');
        
		if( !$get_filter) $get_filter= $this->input->get('filter');

		if(is_array($get_filter)) $filter= $get_filter+ $filter;
/* 兼容grid变为ajax加载加这一段 */
        
		$this->load->model('soma/category_package_model');
		$f_inter_id= isset($filter['inter_id'])? $filter['inter_id']: NULL;
		$cats= $this->category_package_model->get_cat_tree_option($f_inter_id);
        
        $ops= '';
        foreach( $cats as $k=> $v){
        	if( isset($filter['cat_id']) && $filter['cat_id']==$k ) $ops.= '<option value="'. $k. '" selected="selected">'. $v. '</option>';
        	else $ops.= '<option value="'. $k. '">'. $v. '</option>';
        }
        
        if( !isset($filter['cat_id']) || $filter['cat_id']===NULL )
            $active= '';
        else 
            $active= 'btn-success';

        $jsfilter_btn= '&nbsp;&nbsp;<div class="input-group">'
			. '<div class="input-group-btn"><button type="button" class="btn btn-sm '. $active. '"><i class="fa fa-filter"></i> 分类筛选</button></div>'
			. '<select class="form-control input-sm" name="filter[cat_id]" id="filter_status" >'
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
            'categories' => $cats,
        );

	    $this->_grid($filter, $viewdata);
	}

	public function edit()
	{
		$this->label_action= '商品管理';
		$this->_init_breadcrumb($this->label_action);
		
		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);

		// $detail_field= '';
		$id= intval($this->input->get('ids'));
		$model= $model->load($id);
        if(!$model) $model= $this->_load_model();
		$fields_config= $model->get_field_config('form');

		if($this->update_order_attr) {
			$update_attr = $model->can_edit_attribute();
			$tmp_config = array();
			foreach ($update_attr as $key) {
				$tmp_config[$key] = $fields_config[$key];
			}
			$fields_config = $tmp_config;
		}

		//越权查看数据跳转
		if( !$this->_can_edit($model) ){
            $this->session->put_error_msg('找不到该数据');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid'));
		}
		
		//反序列化compose，输出到详情
		$compose = array();
		$compose = $model->unserialize_compose();

		//获取相册数组
		$gallery= $model->get_gallery();

		$view_params= array(
		    'model'=> $model,
		    'fields_config'=> $fields_config,
		    'check_data'=> FALSE,
		    'gallery'=> $gallery,
		    'compose'=>$compose,
		    'update_order_attr'=>$this->update_order_attr,
		);

		$html= $this->_render_content($this->_load_view_file('edit'), $view_params, TRUE);
		//echo $html;die;
		echo $html;
	}

	public function edit_post()
	{
	    $this->label_action= '产品修改';
	    $this->_init_breadcrumb($this->label_action);

	    //cat_id从ticket_center->get_id_category('package')获取
	    $this->load->model('soma/ticket_center_model','ticket_center');
	    $productId = $this->ticket_center->get_id_product('package');
	
	    $model_name= $this->main_model_name();
	    $model= $this->_load_model($model_name);
	    $pk= $model->table_primary_key();
	
	    $this->load->library('form_validation');
	    $post= $this->input->post();

	    //不同的产品类型不能相互转换
	    if( isset( $post[$pk] ) && !empty( $post[$pk] ) ){
	    	$model = $model->load( $post[$pk] );
	    	if( $model && $model->m_get( 'type' ) != $post['type'] ){
	    		$this->session->put_notice_msg('此次数据修改失败！不能转换产品类型');
	            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid'));
	    	}elseif( !$model ){
	    		$this->session->put_notice_msg('检查产品类型出错！');
	            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid'));
	    	}
	    }

	    $labels= $model->attribute_labels();
	    $base_rules= array(
	        'name'=> array(
	            'field' => 'name',
	            'label' => $labels['name'],
	            'rules' => 'trim|required',
	        ),
// 	        'sku'=> array(
// 	            'field' => 'sku',
// 	            'label' => $labels['sku'],
// 	            'rules' => 'trim|required',
// 	        ),
	        'cat_id'=> array(
	            'field' => 'cat_id',
	            'label' => $labels['cat_id'],
	            'rules' => 'trim|required',
	        ),
	        'price_market'=> array(
	            'field' => 'price_market',
	            'label' => $labels['price_market'],
	            'rules' => 'trim|required',
	        ),
	        'price_package'=> array(
	            'field' => 'price_package',
	            'label' => $labels['price_package'],
	            'rules' => 'trim|required',
	        ),
	        'hotel_id'=> array(
	            'field' => 'hotel_id',
	            'label' => $labels['hotel_id'],
	            'rules' => 'trim|required',
	        ),
	        // 'inter_id'=> array(
	        //     'field' => 'inter_id',
	        //     'label' => $labels['inter_id'],
	        //     'rules' => 'trim|required',
	        // ),
	        // 'room_id'=> array(
	        //     'field' => 'room_id',
	        //     'label' => $labels['room_id'],
	        //     'rules' => 'trim|required',
	        // ),
	        // 'max_reserve'=> array(
	        //     'field' => 'max_reserve',
	        //     'label' => $labels['max_reserve'],
	        //     'rules' => 'trim|required',
	        // ),
	        // 'sort'=> array(
	        //     'field' => 'sort',
	        //     'label' => $labels['sort'],
	        //     'rules' => 'trim|required',
	        // ),
	        'use_cnt'=> array(
	            'field' => 'use_cnt',
	            'label' => $labels['use_cnt'],
	            'rules' => 'trim|less_than_equal_to[20]|greater_than_equal_to[1]',
	        ),
	    );

	    //酒店地址详情处理
	    $inter_id = $this->session->get_admin_inter_id();
		$post['inter_id'] = $inter_id;
        $hotel_id = isset( $post['hotel_id'] ) ? $post['hotel_id'] + 0 : '';
	    
	    //检测并上传文件。
	    $post= $this->_do_upload($post, 'face_img');
	    $post= $this->_do_upload($post, 'transparent_img');

	    //处理套票内容和数量,序列化存在compose
	    $compose = array();
	    $compose = isset( $post['compose'] ) ? $post['compose'] : '';
	    if( !empty( $compose ) ){
		    foreach ($compose as $k => $v) {
		    	$num = isset( $v['num'] ) ? $v['num'] + 0 : 0;
		    	if( $num < 0 ){ 
		    		$compose[$k]['num'] = 0;
		    	}else{ 
		    		$compose[$k]['num'] = $num;
		    	}
		    }
		}
	    $post['compose'] = serialize( $compose );

	    //在售数量
	    $stock = isset( $post['stock'] ) ? $post['stock'] + 0 : 0;
	    if( $stock < 0 ){ 
	    	$post['stock'] = 0;
	    }else{ 
	    	$post['stock'] = $stock;
	    }

	    //门市价
	    $price_market = isset( $post['price_market'] ) ? $post['price_market'] + 0 : 0;
	    if( $price_market <= 0 ){ 
	    	$post['price_market'] = 0.01;
	    }else{ 
	    	$post['price_market'] = $price_market;
	    }

	    //组合价
		$price_package = isset( $post['price_package'] ) ? $post['price_package'] + 0 : 0;
		if( $price_package <= 0 ){ 
	    	$post['price_market'] = 0.01;
		}else{ 
			$post['price_package'] = $price_package;
		}

        $this->load->model( 'hotel/hotel_model' );
        // $inter_id = 'a429262687';
        // $hotel_id = '1081';
        $hotel_info = $this->hotel_model->get_hotel_detail( $inter_id, $hotel_id );
        if( $hotel_info ){
        	$post['hotel_address'] = $hotel_info['province'] 
						        	. $hotel_info['city'] 
						        	. $hotel_info['address'];
        	$post['hotel_name'] = $hotel_info['name'];
            $post['latitude'] = $hotel_info['latitude'];
            $post['longitude'] = $hotel_info['longitude'];
            $post['product_city'] = $hotel_info['city'];
        }else{
        	$post['hotel_address'] = '';
        	$post['hotel_name'] = '';
        	$post['latitude'] = '';
            $post['longitude'] = '';
            $post['product_city'] = '';
        }
// var_dump( $hotel_info );exit;
// var_dump( $pk, $post );exit;	    

        //如果是特权券，赠送好友必须开着
        if( isset( $post['type'] ) && $post['type'] == Soma_base::STATUS_FALSE ){
        	// $post['can_gift'] = 1;
        	$post['can_pickup'] = 2;//不能自提
        	$post['can_mail'] = 2;//不能邮寄
        	$post['can_reserve'] = 2;//不能预约
        }

	    if( empty($post[$pk]) ){
	        //add data.

	        $post[$pk] = $productId;//添加的自定义主键值

	        $this->form_validation->set_rules($base_rules);
	
	        if ($this->form_validation->run() != FALSE) {
	            $model->post = $post;
	            $business = 'package';
	            $result= $model->product_package_save( $business, $inter_id );
	            $message= ($result)?
		            $this->session->put_success_msg('已新增商品，为丰富效果，请添加对应的图片相册吧'):
		            $this->session->put_notice_msg('此次数据保存失败！');
					$this->_log($model);
				//不是自增字段
				if( $result ){
					$result = $productId;
				}

	            $this->_redirect(Soma_const_url::inst()->get_url('*/*/edit',  array('ids'=> $result, 'tab'=> '2' ) ));

	        } else
	            $model= $this->_load_model();
	
	    } else {
	        $this->form_validation->set_rules($base_rules);
	        if ($this->form_validation->run() != FALSE) {
	            $result= $model->load($post[$pk])->m_sets($post)->m_save($post);
	            $message= ($result)?
    	            $this->session->put_success_msg('已保存数据！'):
    	            $this->session->put_notice_msg('此次数据修改失败！');
				$this->_log($model);
	            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid'));
	
	        } else
	            $model= $model->load($post[$pk]);
	    }

	    //验证失败的情况
	    $validat_obj= _get_validation_object();
	    $message= $validat_obj->error_html();
	    //页面没有发生跳转时用寄存器存储消息
	    $this->session->put_error_msg($message, 'register');
	    
	    //获取相册数组
	    $gallery= $model->get_gallery();
	    
	    $fields_config= $model->get_field_config('form');

	    $view_params= array(
	        'model'=> $model,
	        'fields_config'=> $fields_config,
	        'check_data'=> TRUE,
	        'gallery'=> $gallery,
		    'compose'=> $compose,
		    'update_order_attr'=>$this->update_order_attr,
	    );
	    
	    $html= $this->_render_content($this->_load_view_file('edit'), $view_params, TRUE);
	    echo $html;
	}

	public function edit_focus()
	{
	    $model_name= $this->main_model_name();
	    $model= $this->_load_model($model_name);
	    $pk= $model->table_primary_key();
	    $post= $this->input->post();

	    if(isset( $post['del_gallery'] ) ){
	        $model->delete_gallery($post['del_gallery'], $post[$pk]);
	    }
	    //检测并上传新的文件。
	    $post= $this->_do_upload($post, 'gallery');
	    if(isset($post['gallery'])){
	        $data= array(
	            'gry_url'=> $post['gallery'],
	            'gry_intro'=> isset( $post['gry_intro'] ) ? $post['gry_intro'] : '',
	            'product_id'=> $post['product_id'],
	        );
	        $model->plus_gallery($data);
	    }
	    $this->session->put_success_msg('成功保存产品相册，请继续编辑产品信息');
	    $this->_redirect(Soma_const_url::inst()->get_url('*/*/edit', array('ids'=> $post[$pk]) ));
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
	 * 仅限开发使用
	 * @return [type] [description]
	 */
	public function upattribute()
	{
		$this->_toolkit_writelist();
	    $this->view_file= 'upattribute';
	    $this->grid();
	}
	
	/**
	 * 仅限开发使用
	 * @return [type] [description]
	 */
	public function editattribute() {
		$this->_toolkit_writelist();
		$this->update_order_attr = true;
		$this->edit();
	}

	/**
	 * 仅限开发使用
	 * @return [type] [description]
	 */
	public function update_post() {

		$this->_toolkit_writelist();

		$post = $this->input->post();

		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);
		$id= intval($post['product_id']);

		if($model->load($id)->update_related_table($post)) {
			$this->session->put_success_msg('已更新订单/资产/消费数据！');
			$this->_redirect(Soma_const_url::inst()->get_url('*/*/upattribute'));
		} else {
			$this->session->put_error_msg('更新数据失败，请重新尝试！');
			$this->_redirect(Soma_const_url::inst()->get_url('*/*/editattribute'));
		}

	}

}
