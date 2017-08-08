<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gift_order extends MY_Admin_Soma {

	//protected $label_module= NAV_MALL;		//统一在 constants.php 定义
	protected $label_controller= '赠送订单';		//在文件定义
	protected $label_action= '';				//在方法中定义
	
	protected function main_model_name()
	{
		return 'soma/gift_order_model';
	}

	public function grid()
	{
		$this->label_action= '赠送列表';
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
			. '<div class="input-group-btn"><button type="button" class="btn btn-sm '. $active. '"><i class="fa fa-filter"></i> 赠送状态</button></div>'
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

	public function edit()
	{
		$this->label_action= '赠送详情';
		$this->_init_breadcrumb($this->label_action);
		
		$model_name= $this->main_model_name();
		$model= $this->_load_model($model_name);
		
		$id= intval($this->input->get('ids'));
		if($id){
			$model= $model->load($id);
		}

        if(!$model) $model= $this->_load_model();
		$fields_config= $model->get_field_config('form');

		//越权查看数据跳转
		if( !$this->_can_edit($model) ){
            $this->session->put_error_msg('找不到该数据');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid'));
		}

		//查看赠送订单明细 
		$business = 'package';
		$inter_id = $this->session->get_admin_inter_id();
		$items = $model->get_gift_order_item( $business, $inter_id );

		//赠送订单明细要显示字段
		$grid_field= array(
				// 'item_id'=>'ID',
				// 'gift_id'=>'赠送ID',
				// 'inter_id'=>'公众号',
				'inter_name'=>'公众号',
				// 'hotel_id'=>'酒店',
				'hotel_name'=>'酒店',
				'product_id'=>'商品ID',
				'name'=>'商品名称',
				'qty'=>'数量',
			);

		$view_params= array(
		    'model'=> $model,
		    'fields_config'=> $fields_config,
		    'check_data'=> FALSE,
		    'items'=>$items,
		    'grid_field'=>$grid_field,
		);
		
		$html= $this->_render_content($this->_load_view_file('edit'), $view_params, TRUE);
		//echo $html;die;
		echo $html;
	}

	/**
	 * 禁止进行删除操作
	 */
	public function delete()
	{
	    $url= Soma_const_url::inst()->get_url('*/*/index');
	    redirect($url);
	}
	
}
