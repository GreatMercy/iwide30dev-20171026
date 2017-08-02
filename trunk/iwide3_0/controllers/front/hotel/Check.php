<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Check extends MY_Front_Hotel {
	public $common_data;
	public $openid;
	public $module;
	public $default_skin='default2';
	function __construct() {
		parent::__construct ();
		MYLOG::hotel_tracker($this->openid,  $this->inter_id);
		$this->module = 'hotel';
		$this->member_no = '';
		$this->member_lv = '';
		if (! empty ( $this->member_info ) && isset ( $this->member_info->mem_id )) {
			$this->member_no = $this->member_info->mem_card_no;
			$this->member_lv = $this->member_info->level;
		}
		$this->load->model ( 'wx/Access_token_model' );
		$this->common_data ['signPackage'] = $this->Access_token_model->getSignPackage ( $this->inter_id );
		$this->common_data ['pagetitle'] = $this->public ['name'];
		$this->common_data ['member'] = $this->member_info;
		$this->common_data ['inter_id'] = $this->inter_id;
		$this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
		$this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
		$this->share ['title'] = $this->public ['name'] . '-微信订房';
		$slink = $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
		if (strpos ( $slink, '?' ))
			$slink = $slink . "&id=" . $this->inter_id;
		else
			$slink = $slink . "?id=" . $this->inter_id;
		$this->share ['link'] = $slink;
		$this->share ['imgUrl'] = 'http://7n.cdn.iwide.cn/public/uploads/201609/qf051934149038.jpg';
		$this->share ['desc'] = $this->public ['name'] . '欢迎您使用微信订房,享受快捷服务...';
		$this->share ['type'] = '';
		$this->share ['dataUrl'] = '';
		$this->common_data ['share'] = $this->share;
		
		$this->common_data ['index_url'] = $this->public ['is_multy'] == 1 ?Hotel_base::inst()->get_url('INDEX') : Hotel_base::inst()->get_url('SEARCH');;
		
	}
	
	function nearby() {
		$data = $this->common_data;
		
		$startdate = $this->input->get ( 'sd', TRUE );
		$enddate = $this->input->get ( 'ed', TRUE );
		
		$this->load->model ( 'hotel/Hotel_check_model' );
		$this->load->model ( 'hotel/Order_model' );
		$date_check = $this->Order_model->date_validate ( $startdate, $enddate, $this->inter_id);
		$data ['startdate'] = $date_check [0];
		$data ['enddate'] = $date_check [1];
		
		// $this->load->model ( 'hotel/Hotel_check_model' );
		// $result = $this->Hotel_model->search_hotel_front ( $this->inter_id, array () );
		$data ['hotel_ids'] = '';
		// if (! empty ( $result )) {
		// $this->load->model ( 'hotel/Hotel_check_model' );
		// $result = $this->Hotel_check_model->get_extra_info ( $this->inter_id, $result, array (
		// 'hotel_service',
		// 'lowest_price',
		// 'search_icons',
		// 'comment_data',
		// 'distance'
		// ), array (
		// 'startdate' => $data ['startdate'],
		// 'enddate' => $data ['enddate'],
		// 'latitude' => 23.129163,
		// 'longitude' => 113.264435
		// ) );
		// $data ['result'] = $result;
		// }
		
		$this->load->model ( 'common/Record_model' );
		$this->Record_model->visit_log ( array (
				'openid' => $this->openid,
				'inter_id' => $this->inter_id,
				'title' => '附近酒店',
				'url' => $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'],
				'des' => "附近酒店" 
		) );
		$this->display ( 'hotel/nearby/near_hotel', $data );
	}
	function my_collection() {
		$data = $this->common_data;
		$data ['pagetitle'] = '我的收藏';
		$data ['mark_type'] = intval ( $this->input->get ( 'mt' ) );
		$data ['mark_type'] = 1;
		$this->load->model ( 'hotel/Hotel_model' );
		$condit = $this->Hotel_model->return_mark_condi ( $data ['mark_type'] );
		$data ['marks'] = array ();
		$data ['hotels'] = array ();
		if (! empty ( $condit )) {
			$data ['marks'] = $this->Hotel_model->get_front_marks ( array (
					'inter_id' => $this->inter_id,
					'openid' => $this->openid,
					'mark_type' => $condit ['type'],
					'status' => 1 
			), $condit ['sort'] );
			if (! empty ( $data ['marks'] )) {
				$hotel_ids = '';
				foreach ( $data ['marks'] as $mark ) {
					$hotel_ids .= ',' . $mark ['mark_name'];
				}
				$hotel_ids = substr ( $hotel_ids, 1 );
				$this->load->model ( 'hotel/Hotel_model' );
				$hotels = $this->Hotel_model->get_hotel_by_ids ( $this->inter_id, $hotel_ids, 1, 'key', 'object' );
				$this->load->model ( 'hotel/Hotel_check_model' );
				$info_types = array (
						'hotel_service',
						'lowest_price',
						'search_icons',
//						'comment_data'
				);
				
				$this->load->model('hotel/Hotel_config_model');
				$config_data = $this->Hotel_config_model->get_hotel_config ( $this->inter_id, 'HOTEL', 0, [
					'NONE_COMMENT'//取消评论
				]);
				if(empty($config_data['NONE_COMMENT'])){
					$info_types[]='comment_data';
				}
				
				
				$params = array (
						'startdate' => date ( 'Ymd' ),
						'enddate' => date ( 'Ymd', strtotime ( '+ 1 day', time () ) ),
						'member_level'=>$this->member_lv
				);
				$hotels = $this->Hotel_check_model->get_extra_info ( $this->inter_id, $hotels, $info_types, $params );
				$data ['hotels'] = $hotels;
			}
		}
		$this->display ( 'hotel/my_collection/my_collection', $data );
	}
	
	function check_repay(){
		$this->load->model ( 'hotel/Order_model' );
		$orderid = $this->input->get ( 'oid' );
		$check = $this->Order_model->get_main_order ( $this->inter_id, array (
				'openid' => $this->openid,
				'member_no' => $this->member_no,
				'orderid' => $orderid,
				'idetail' => array (
						'i' 
				) 
		) );
		if (! empty ( $check )) {
			$check = $check [0];
			$this->load->model ( 'hotel/Order_check_model' );
			$state = $this->Order_check_model->check_order_state ( $check );
			if ($state['re_pay']==1){
				echo json_encode(array('s'=>1));
				exit;
			}
		}
		echo  json_encode(array('s'=>0,'errmsg'=>'已无法再支付'));
	}
	
	function ajax_hotel_list() {
		$data = $this->common_data;
		$latitude = $this->input->get ( 'lat', true );
		$longitude = $this->input->get ( 'lnt', true );
		$startdate = $this->input->get ( 'start', TRUE );
		$enddate = $this->input->get ( 'end', TRUE );
		$city = $this->input->get ( 'city', TRUE );
        $area = $this->input->get ( 'area', TRUE );
		$keyword = $this->input->get ( 'keyword', TRUE );
		$offset = $this->input->get ( 'off', TRUE );
		$sort_type = $this->input->get ( 'sort_type', TRUE );
		$offset = intval ( $offset );
		$offset = empty ( $offset ) ? 0 : intval ( $offset );
		$nums = $this->input->get ( 'num', TRUE );
		$nums = intval ( $nums );
		$nums = empty ( $nums ) ? 5 : intval ( $nums );
		$nums = $nums > 20 ? 20 : $nums;
		$extra_condition = $this->input->get ( 'ec', TRUE );
		$type = $this->input->get ( 'type', TRUE );
		// $extra_condition = '{"land_mark":110229}';
		$this->load->model ( 'hotel/Hotel_check_model' );
		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->model ( 'hotel/Order_model' );
		$date_check = $this->Order_model->date_validate ( $startdate, $enddate, $this->inter_id);
		$startdate = $date_check [0];
		$enddate = $date_check [1];
		$check_distance = 0;
		$params = array (
				'startdate' => $startdate,
				'enddate' => $enddate,
				'city' => $city,
                'area' => $area,
				'extra_condition' => $extra_condition,
				'keyword'=>$keyword,
				'type'=>$type
		);
		
		if(isset($extra_condition) && !empty($extra_condition)){
			$landmark_info = json_decode($extra_condition);
			if(isset($landmark_info->bdmap)){
				$landmark_info = explode(',',$landmark_info->bdmap);
				if(isset($landmark_info[2])){
					$data['landmark']=  $landmark_info[2];
				}
				//转换百度坐标
				if (isset($landmark_info[0])){
					$this->load->helper ( 'calculate' );
					$location=bd2gcj($landmark_info[1], $landmark_info[0]);
					$latitude=$location['latitude'];
					$longitude=$location['longitude'];
				}
		
			}
		}
		
		if (! is_null ( $latitude ) && ! is_null ( $longitude ) && $latitude !== '' && $longitude !== '') {
			$check_distance = 1;
			$params ['latitude'] = $latitude;
			$params ['longitude'] = $longitude;
		}
		$params ['offset'] = $offset;
		$params ['nums'] = $nums;
		$params ['sort_type'] = $sort_type;
		$params ['check_distance'] = $check_distance;
		$result=array();
		if($type != 'athour' || date('Hi')<2300){
			$result = $this->Hotel_model->search_hotel_front ( $this->inter_id, $params );
		}
		//专题活动过滤hotelid add by ping
		$tc_id = intval($this->input->get ( 'tc_id', TRUE ));
		$data['exe_param'] = '';
		if(!empty($tc_id)){
			$data['exe_param'] = '&tc_id='.$tc_id;
			$this->load->model ( 'hotel/Hotel_thematic_model' );
			$tc_row = $this->Hotel_thematic_model->get_row($this->inter_id,$tc_id,array('nowtime'=>date('Y-m-d H:i:s'),'status'=>1));
			$tc_hotelids = json_decode($tc_row['hotelids'],TRUE);

			foreach ($result as $tc_k => $re) {
				if(empty($tc_hotelids) || !in_array($re->hotel_id,$tc_hotelids) ){
					unset($result[$tc_k]);
				}
			}
		}

		if (! empty ( $result )) {
			$info_types = array (
					'hotel_service',
					'lowest_price',
					'search_icons',
//					'comment_data'
			);
			
			$this->load->model('hotel/Hotel_config_model');
			$config_data = $this->Hotel_config_model->get_hotel_config ( $this->inter_id, 'HOTEL', 0, [
				'NONE_COMMENT'//取消评论
			]);
			if(empty($config_data['NONE_COMMENT'])){
				$info_types[]='comment_data';
			}
			
			$params = array (
					'startdate' => $startdate,
					'enddate' => $enddate,
					'member_level'=>$this->member_lv
			);
			$params ['offset'] = $offset;
			$params ['nums'] = $nums;
			$params ['check_distance'] = $check_distance;
			$params ['sort_type'] = $sort_type;
			if ($check_distance == 1) {
				$info_types [] = 'distance';
				$params ['latitude'] = $latitude;
				$params ['longitude'] = $longitude;
			}
			if ($sort_type == 'distance' || $sort_type == 'distance_up') {
				$params ['distance_sort'] = 'lt';
			}
			elseif ($sort_type == 'distance_down') {
				$params ['distance_sort'] = 'gt';
			}
			if(!empty($tc_row)){
				$params ['price_codes'] = json_decode($tc_row['price_codes'],TRUE);//起价价格代码
			}
			$this->load->model ( 'hotel/Hotel_check_model' );
			$result = $this->Hotel_check_model->get_extra_info ( $this->inter_id, $result, $info_types, $params ,$this->openid);
			
			$data ['result'] = $result;
			$html = $this->display ( 'hotel/ajax_hotel_list/ajax_hotel_list', $data, '', array (), TRUE );
			echo json_encode ( array (
					's' => 1,
					'data' => $html 
			), JSON_UNESCAPED_UNICODE );
			exit ();
		}
		// $this->load->helper ( 'ajaxdata' );
		// var_dump ( $result );
		echo json_encode ( array (
				's' => 0,
				'data' => '' 
		) );
		// echo json_encode ( data_dehydrate ( $hotels, array (
		// 'name',
		// 'hotel_id'
		// ), 'hotel_id' ) );
	}
	function ajax_city_filter() {
		$data = $this->common_data;
		$city = $this->input->get ( 'city', TRUE );
		$this->load->model ( 'hotel/Hotel_check_model' );
		$result = $this->Hotel_check_model->get_city_filter ( $this->inter_id, $city );
		if (! empty ( $result )) {
			$data ['result'] = $result;
			$html = $this->display ( 'hotel/ajax_city_filter/ajax_city_filter', $data, '', array (), TRUE );
			echo json_encode ( array (
					's' => 1,
					'data' => $html 
			), JSON_UNESCAPED_UNICODE );
			exit ();
		}
		echo json_encode ( array (
				's' => 0,
				'data' => '暂无数据' 
		) );
	}
	function ajax_hotel_search() {
		$data = $this->common_data;
		$keyword = $this->input->get ( 'keyword', TRUE );
		$city = $this->input->get ( 'city', TRUE );
		$city =='全部' and $city='';
		$this->load->model ( 'hotel/Hotel_check_model' );
		$paras = array (
				'city' => $city,
				'keyword' => $keyword,
				'nums'=>5,
				'offset'=>0
		);
		$result = $this->Hotel_check_model->search_hotel_front ( $this->inter_id, $paras );

		//专题活动过滤hotelid add by ping
		$tc_id = intval($this->input->get ( 'tc_id', TRUE ));
		$data['exe_param']='';
		if(!empty($tc_id)){
			$data['exe_param'] = '&tc_id='.$tc_id;
			$this->load->model ( 'hotel/Hotel_thematic_model' );
			$tc_row = $this->Hotel_thematic_model->get_row($this->inter_id,$tc_id,array('nowtime'=>date('Y-m-d H:i:s'),'status'=>1));
			$tc_hotelids = json_decode($tc_row['hotelids'],TRUE);
			foreach ($result as $tc_k => $re) {
				if(empty($tc_hotelids) || !in_array($re->hotel_id,$tc_hotelids) ){
					unset($result[$tc_k]);
				}
			}
		}
		
		if (! empty ( $result )) {
			$data ['result'] = $result;
			$html = $this->display ( 'hotel/ajax_hotel_search/ajax_hotel_search', $data, '', array (), TRUE );
			echo json_encode ( array (
					's' => 1,
					'data' => $html,
					'count'=>count($result)
			), JSON_UNESCAPED_UNICODE );
			exit ();
		}
		echo json_encode ( array (
				's' => 0,
				'data' => '暂无数据' 
		) );
	}
    function check_order_canpay(){
    	$orderid = $this->input->get ( 'oid', true );
    	if ($orderid) {
    		$this->load->model ( 'hotel/Order_model' );
    		$order_details = $this->Order_model->get_main_order ( $this->inter_id, array (
    			'orderid' => $orderid,
    			'idetail' => array (
    				'i'
    			)
    		) );
	    	if ($order_details) {
				$order_details = $order_details [0];
		    	$this->load->model ( 'hotel/Order_check_model' );
				$re = $this->Order_check_model->check_order_state($order_details);
				if($re['re_pay']!=1){
					echo json_encode(array('s' => 0,'errmsg' => '不可支付' ));exit;
				}else{
					echo json_encode(array('s' => 1,'errmsg' => '可支付' ));exit;
				}
			}
		}
		echo json_encode(array('s' => 0,'errmsg' => '不可支付' ));
    }
}