<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Hotel extends MY_Front_Hotel_Iapi {
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

		$this->common_data ['index_url'] = $this->public ['is_multy'] == 1 ? Hotel_base::inst()->get_url('INDEX') : Hotel_base::inst()->get_url('SEARCH');

		$this->common_data ['my_saler_id']=$this->my_saler_id;
		$this->common_data ['url_param'] = $this->url_param;

		$this->load->model('hotel/iapi/Hotel_api_data_model');
		$this->Hotel_api_data_model->init_data($this);
	}
	function search() {
	    //获取皮肤配置
	    $module_view=$this->get_display_view('hotel/search');
	    $skin_config=$this->get_skin_config($module_view['skin_name'], 'hotel/search');
	    $module_view=array(
	            'module_view'=>$module_view
	    );
	    $params=array(
	            'module_view'=>$module_view,
	            'skin_config'=>$skin_config
	    );
		$data = $this->Hotel_api_data_model->search_data($params);
        $this->out_put_msg(1,'',$data,'hotel/hotel/search');
	}
	function sresult() {
	    //获取皮肤配置
	    $module_view=$this->get_display_view('hotel/sresult');
	    $skin_config=$this->get_skin_config($module_view['skin_name'], 'hotel/sresult');
	    $module_view=array(
	            'module_view'=>$module_view
	    );
	    $params=array(
	            'module_view'=>$module_view,
	            'skin_config'=>$skin_config
	    );
	    $data = $this->Hotel_api_data_model->sresult_data($params);
	    $this->out_put_msg(1,'',$data,'hotel/hotel/sresult');
	}
	function return_lowest_price() {

        $data = $this->Hotel_api_data_model->return_lowest_price();
        $this->out_put_msg(1,'',$data,'hotel/hotel/return_lowest_price');
	}
	function index() {
        //获取皮肤配置
        $data = $this->Hotel_api_data_model->index_data();
        $this->out_put_msg(1,'',$data,'hotel/hotel/index');

//		if($type == 'athour'){
//			$this->display ( 'hotel/index/room_list_athour', $data );
//		}elseif($type == 'ticket'){
//			$this->display ( 'hotel/index/room_list_ticket', $data );
//		}else{
//			$this->display ( 'hotel/index/room_list', $data );
//		}

	}
	function return_more_room() {
        //获取皮肤配置
        $module_view=$this->get_display_view('hotel/return_more_room');
        $skin_config=$this->get_skin_config($module_view['skin_name'], 'hotel/return_more_room');
        $module_view=array(
            'module_view'=>$module_view
        );
        $params=array(
            'module_view'=>$module_view,
            'skin_config'=>$skin_config
        );
        $data = $this->Hotel_api_data_model->return_more_room($params);
        $this->out_put_msg(1,'',$data,'hotel/hotel/return_more_room');
	}
	function hotel_detail() {
        $data = $this->Hotel_api_data_model->hotel_detail();
        $this->out_put_msg(1,'',$data,'hotel/hotel/hotel_detail');
	}
	function arounds() {
        $data = $this->Hotel_api_data_model->arounds();
        $this->out_put_msg(1,'',$data,'hotel/hotel/arounds');
	}
	function bookroom() {
		$data = $this->common_data;
		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->model ( 'hotel/Order_model' );


		$hotel_id = intval ( $this->input->post ( 'hotel_id' ) );
		$room_id = intval ( $this->input->post ( 'room_id' ) );
		$data ['price_codes'] = $this->input->post ( 'price_codes' );
		$data ['price_type'] = $this->input->post ( 'price_type' );

		$startdate = $this->input->post ( 'startdate' );
		$enddate = $this->input->post ( 'enddate' );

		$date_check = $this->Order_model->date_validate ( $startdate, $enddate,$this->inter_id,$hotel_id);
		$data ['startdate'] = $date_check [0];
		$data ['enddate'] = $date_check [1];
		$data ['hotel_id'] = $hotel_id;
		$datas = $this->input->post ( 'datas', TRUE );
		$price_codes = json_decode ( $data ['price_codes'], TRUE );
		$price_type = json_decode ( $data ['price_type'], TRUE );
		$type = $this->input->post ( 'type', TRUE );
		$countday = get_room_night($data ['startdate'],$data ['enddate'],'ceil',$data);//至少有一个间夜


		if (empty ( $datas ) || empty ( $price_codes )) {
			redirect ( Hotel_base::inst()->get_url('INDEX',array('h'=>$hotel_id,'type'=>$type)) );
		}
		$data ['hotel'] = $this->Hotel_model->get_hotel_detail ( $this->inter_id, $hotel_id, array (
			'img_type' => array (
				'hotel_service',
				'hotel_lightbox'
			)
		) );
		
		$data['share']['link']=site_url ( 'hotel/hotel/index' ) . '?id=' . $this->inter_id . '&h=' . $hotel_id .'&type=' . $type;
		$data['share']['desc']=$data ['hotel']['name'] . '欢迎您使用微信订房,享受快捷服务...';
		
		$data_arr = json_decode ( $datas, TRUE );
		foreach ( $data_arr as $key => $value ) {
			if ($value == 0) {
				unset ( $data_arr [$key] );
			}
		}
		$data ['room_list'] = $this->Hotel_model->get_rooms_detail ( $this->inter_id, $hotel_id, array_keys ( $data_arr ), array (
			'number_realtime' => array (
				's' => $data ['startdate'],
				'e' => $data ['enddate']
			),
			'data' => 'key',
			'img_type' => array (
				'hotel_room_service'
			)
		) );
		$condit = array (
			'startdate' => $data ['startdate'],
			'enddate' => $data ['enddate'],
			'nums' => $data_arr,
			'openid' => $this->openid,
			'member_level' => $this->member_lv,
			'hotel_id'=> $hotel_id
		);
		// if ( $this->member_lv !='') {
		$this->load->model ( 'hotel/Member_model' );
		$member_privilege = $this->Member_model->level_privilege ( $this->inter_id );
		if (! empty ( $member_privilege )) {
			$condit ['member_privilege'] = $member_privilege;
		}

		// }
		$protrol_code = $this->input->post ( 'protrol_code' );
		if (! empty ( $protrol_code ) && array_key_exists ( 'protrol', $price_type )) {
			$protrol_price_code = $this->Order_model->get_protrol_price_code ( $this->inter_id, $hotel_id, $protrol_code );
		}
		if (! empty ( $protrol_price_code )) {
			$price_codes [] = $protrol_price_code;
			$condit ['price_type'] = array (
				'protrol'
			);
		}
		$condit ['price_codes'] = implode ( ',', $price_codes );
		$this->load->library ( 'PMS_Adapter', array (
			'inter_id' => $this->inter_id,
			'hotel_id' => $hotel_id
		), 'pmsa' );
		if($type){
			$condit ['only_type'] = $type;
		}
		$data ['rooms'] = $this->pmsa->get_rooms_change ( $data ['room_list'], array (
			'inter_id' => $this->inter_id,
			'hotel_id' => $hotel_id
		), $condit, true );
		reset($data ['rooms']);
		$data ['first_room'] = current ( $data ['rooms'] );
		$data ['first_state'] = $data ['first_room'] ['state_info'] [$price_codes [$data ['first_room'] ["room_info"] ['room_id']]];
		//预订政策
		$data ['bookpolicy_condition'] = !empty($data ['first_state']['bookpolicy_condition'])?$data ['first_state']['bookpolicy_condition']:'';
		$data ['customer_condition'] = !empty($data ['first_state']['customer_condition'])?$data ['first_state']['customer_condition']:array();
		
		if (!empty($data  ['customer_condition']['multi_fill'])&&!empty($data ['customer_condition']['adult']['num'])){
		    $data['show_multi_inner']=1;
		    if ($data ['customer_condition']['adult']['num']>1||!empty($data ['customer_condition']['child']['num'])){
		        $data ['customer_condition']['show_first']=1;
		    }else{
		        $data ['customer_condition']['show_first']=0;
		    }
		}

		if (empty ( $data ['first_state'] )) {
			redirect ( Hotel_base::inst()->get_url('INDEX',array('h'=>$hotel_id,'type'=>$type)) );
		}
		$data ['total_price'] = 0;
		$data ['total_oprice'] = 0;
		$no_pay_ways = array ();
		foreach ( $data ['rooms'] as $k => $item ) {
			$code_price = $item ['state_info'] [$price_codes [$k]];
			$data ['total_price'] += $code_price ['total_price'];
			$data ['total_oprice'] += empty ( $code_price ['total_oprice'] ) ? 0 : $code_price ['total_oprice'];
			$no_pay_ways = empty ( $code_price ['condition'] ['no_pay_way'] ) ? $no_pay_ways : array_merge ( $no_pay_ways, $code_price ['condition'] ['no_pay_way'] );
		}

		$this->load->model ( 'hotel/Hotel_config_model' );
		$config_data = $this->Hotel_config_model->get_hotel_config ( $this->inter_id, 'HOTEL', $hotel_id, array (
			'PRICE_EXCHANGE_POINT',
			'BANCLANCE_COMSUME_CODE_NEED',
			'POINT_EXCHANGE_ROOM',
			'COUPON_TIPS',
            'BONUS_VIEW_SETTING',
            'POINT_PAY_CODE_NEED',
			'POINT_NAME',
			'HOTEL_PREPAY_FAVOUR',
		    'BOOK_ADDIT_SERVICE'
		) );
		$this->load->model ( 'hotel/Service_model' );
		$data['addit_service']=array();
		if (!empty($config_data['BOOK_ADDIT_SERVICE'])){
    	    $data['addit_service']=$this->Service_model->format_book_service(json_decode($config_data['BOOK_ADDIT_SERVICE'],TRUE));
		}
		//优惠券温馨提示
		if(!empty($config_data['COUPON_TIPS'])){
			$data['coupon_tips']=nl2br($config_data['COUPON_TIPS']);
		}
		
		$data['point_name']=empty($config_data['POINT_NAME'])?'积分':$config_data['POINT_NAME'];
		$prepay_favour=isset($config_data['HOTEL_PREPAY_FAVOUR'])?json_decode($config_data['HOTEL_PREPAY_FAVOUR'],TRUE):array();

		// @author lGh 2016-03-14 钟点房
		$data ['athour'] = 0;
		if ($data ['first_state'] ['price_type'] == 'athour') {
			$data ['athour'] = 1;
		}
		$this->load->model ( 'hotel/Price_code_model' );
		if (! empty ( $data ['first_state'] ['add_service_set'] )) {
			$data ['services'] = $this->Service_model->replace_service ( $this->inter_id, array (
				'service_type' => 'hotel_order',
				'status' => 1,
				'add_occasion' => array (
					'hotel_order_before',
					'hotel_order_both'
				)
			), $data ['first_state'] ['add_service_set'] );
			$data ['services'] = $this->Service_model->classify_service ( $data ['services'] );
		}

		if (! empty ( $data ['first_state'] ['time_condition'] ['book_time'] )) {
			$min_hour = empty ( $data ['first_state'] ['time_condition'] ['min_hour'] ) ? 0 : $data ['first_state'] ['time_condition'] ['min_hour'] *3600;
			$order_times = $this->Price_code_model->get_book_time ( $data ['first_state'] ['time_condition'] ['book_time'], $min_hour );
			$data ['first_state'] ['time_condition'] ['book_times'] = $order_times ['book_times'];
			$data ['first_state'] ['time_condition'] ['last_time'] = $order_times ['last_time'];
		}
		if (! empty ( $data ['first_state'] ['time_condition'] ['book_time_range'] )) {
			$min_hour = empty ( $data ['first_state'] ['time_condition'] ['min_hour'] ) ? 0 : $data ['first_state'] ['time_condition'] ['min_hour'] *3600;
			$order_times = $this->Price_code_model->get_book_time ( $data ['first_state'] ['time_condition'] ['book_time'], $min_hour );
			$data ['first_state'] ['time_condition'] ['book_times'] = $order_times ['book_times'];
			$data ['first_state'] ['time_condition'] ['last_time'] = $order_times ['last_time'];
		}
		if ($data ['athour'] == 1) {
			if (! empty ( $data ['services'] ['add_time'] )) {
				$data ['add_time_service'] = current ( $data ['services'] ['add_time'] );
				$begin_time = empty ( $data ['first_state'] ['condition'] ['last_time'] ) ? date ( 'YmdH00', strtotime ( '+ 1 hour', time () ) ) : $data ['first_state'] ['condition'] ['last_time'];
				$max_time = empty ( $data ['first_state'] ['condition'] ['book_time'] ['e'] ) ? 0 : $data ['first_state'] ['condition'] ['book_time'] ['e'];
				$data ['add_time_service'] ['add_times'] = $this->Service_model->check_service_rule ( 'add_time', array (
					'begin_time' => $begin_time,
					'max_time' => $max_time,
					'max_num' => $data ['add_time_service'] ['max_num']
				) );
			}
		}

		$data ['room_count'] = array_sum ( $data_arr );
		$this->load->model ( 'pay/Pay_model' );
		$this->load->helper ( 'date' );
		$pay_days = get_day_range ( $data ['startdate'], $data ['enddate'], 'array' );
		array_pop ( $pay_days );
		$data ['pay_ways'] = $this->Pay_model->get_pay_way ( array (
			                                                     'inter_id' => $this->inter_id,
			                                                     'module' => $this->module,
			                                                     'status' => 1,
			                                                     'exclude_type' => $no_pay_ways,
			                                                     'check_day' => 1,
			                                                     'hotel_ids' => $hotel_id,
																 'not_show'=>1
		                                                     ), $pay_days );

		//积分支付配置
		$data['point_pay_set']=array();
		//判断是否使用PMS自定义的积分换房规则
		$is_pms_reduce=false;
		if(!empty($config_data['POINT_EXCHANGE_ROOM'])){
			$code_point_set = json_decode($config_data['POINT_EXCHANGE_ROOM'], true);
			if(!empty($code_point_set['is_pms'])){
				$is_pms_reduce = true;
			}
		}

		$data ['has_point_pay']=0;
		$has_favour_ways=array();
		$no_favour_ways=array();
		foreach ($data ['pay_ways'] as $k=>$pay_way){
			$data ['pay_ways'][$k]->favour=0;
			$data ['pay_ways'][$k]->des='';
			switch ($pay_way->pay_type){
				case 'point':
					//PMS的自定义积分计算 Add By 鹏 On 2016-10-17
					$point_params=[
						'countday'     => $countday,
						'startdate'    => $startdate,
						'enddate'      => $enddate,
						'openid'       => $this->openid,
						'total_price'  => $data ['total_price'],
						'roomnums'     => $data ['room_count'],
						'hotel_id'     => $data ['hotel_id'],
						'room_id'      => $data ['first_room'] ["room_info"] ['room_id'],
						'bonus'        => isset($this->common_data ['member']->bonus) ? $this->common_data ['member']->bonus : 0,
						'member_level' => $this->member_lv,
						'price_code'   => current($price_codes),
						'is_pms_reduce'=>$is_pms_reduce,
						'point_name'=>$data['point_name'],
						'check_point_name'=>1
					];

					$point_pay_set = $this->Member_model->point_pay_check($this->inter_id, $point_params);
					//End PMS point

					$data['point_pay_set'] = $point_pay_set['pay_set'];
					if((!empty($point_pay_set['can_exchange']) && $point_pay_set['can_exchange'] == 1)||count($data['pay_ways'])==1){
						$data ['pay_ways'][$k]->point_need = $point_pay_set['point_need'];
						$data ['pay_ways'][$k]->des = $point_pay_set['des'];

						if (count($data['pay_ways'])==1){
							$data['total_point']=$point_pay_set['point_need'];
							if (empty($point_pay_set['point_need'])){
								$data ['pay_ways'][$k]->des='-/'.$point_params['bonus'];
								$data ['total_point']='-';
								$data ['pay_ways'][$k]->disable = 1;
							}else if(empty($point_pay_set['can_exchange'])){
								$data ['pay_ways'][$k]->disable = 1;
							}
						}
					} else{
						if(count($data['pay_ways']) > 1){
							if (!empty($point_pay_set['point_need'])){
								$data ['pay_ways'][$k]->point_need = $point_pay_set['point_need'];
								$data ['pay_ways'][$k]->des = $point_pay_set['des'];
								$data ['pay_ways'][$k]->disable = 1;
							}else{
								unset($data ['pay_ways'][$k]);
							}
						}
					}
					if (isset($data ['pay_ways'][$k])&&empty($data ['pay_ways'][$k]->des)&&!empty($data ['pay_ways'][$k]->point_need)){
						$data ['pay_ways'][$k]->des=$data ['pay_ways'][$k]->point_need.'/'.$data['member']->bonus;
					}
					$data ['has_point_pay']=1;
					break;
				case 'balance':
					$data ['pay_ways'][$k]->des=$data['member']->balance.'元';
					break;
				case 'weixin':
					if (!empty($prepay_favour[$pay_way->pay_type])){
						$data ['pay_ways'][$k]->favour=$prepay_favour[$pay_way->pay_type];
						$data ['pay_ways'][$k]->des='立减'.$data ['pay_ways'][$k]->favour;
					}else if(!empty($data ['first_state']['bookpolicy_condition']['wxpay_favour'])&&$data ['first_state']['bookpolicy_condition']['wxpay_favour']>0){
						$data ['pay_ways'][$k]->favour=$data ['first_state']['bookpolicy_condition']['wxpay_favour'];
						$data ['pay_ways'][$k]->des='立减'.$data ['pay_ways'][$k]->favour;
					}
				default:
					break;
			}
			empty($data ['pay_ways'][$k]->des) or $data ['pay_ways'][$k]->des='('.$data ['pay_ways'][$k]->des.')';
			if (isset($data ['pay_ways'][$k])){
				if ($data ['pay_ways'][$k]->favour>0){
					$has_favour_ways[]=$data ['pay_ways'][$k];
				}else {
					$no_favour_ways[]=$data ['pay_ways'][$k];
				}
			}
		}
		unset($data ['pay_ways']);
		usort($has_favour_ways, function ($a, $b){
			return $b->favour != $a->favour?$b->favour - $a->favour:0;
		});
		$data ['pay_ways']=array_merge($has_favour_ways,$no_favour_ways);
		
		$data ['source_data'] = json_encode ( $data_arr );
		$last_orders = $this->Order_model->get_last_order ( $this->inter_id, $this->openid, 1, false );
// 		$data ['member'] = $this->pub_pmsa->check_openid_member ( $this->inter_id, $this->openid, array (
// 			'create' => TRUE,
// 			'update' => TRUE
// 		) );
		$data ['member'] = $this->member_info;
		empty ( $last_orders ) ?  : $data ['last_order'] = $last_orders [0];

		//@Editor lGh 2016-7-29 11:59:33 积分兑换比例配置
		$point_condit = array (
			'startdate' => $data ['startdate'],
			'enddate' => $data ['enddate'],
			'nums' => current($data_arr),
			'openid' => $this->openid,
			'member_level' => $this->member_lv,
			'room_id'=>key($data_arr),
			'price_code'=>current($price_codes),
			'bonus'=> isset($data['member']->bonus)?$data['member']->bonus:0,
			'hotel_id'=>$hotel_id,
			'total_price'=>$data['total_price'],
			'roomnums'=>$data ['room_count'],
			'paytype'=>empty($data ['pay_ways'])?'':$data ['pay_ways'][0]->pay_type,
			'point_name'=>$data['point_name'],
			'check_point_name'=>1
		);

		$point_consum_set = $this->Member_model->get_point_consum_rate ( $this->inter_id, $this->member_lv,'room',$member_privilege,$point_condit );

		//@Editor lGh 2016-7-29 11:59:33 积分兑换比例配置
		$data ['point_consum_set']=$point_consum_set ['part_set'];
		$data ['point_consum_rate']=$point_consum_set ['consum_rate'];

		// @author lGh 2016-4-6 21:34:15 积分换房
		$avg_price = floatval ( $data ['total_price'] / $countday );

		if (! empty ( $config_data ['PRICE_EXCHANGE_POINT'] )) {
			$this->load->model ( 'hotel/Member_model' );
			$data ['point_exchange'] = $this->Member_model->room_point_exchange ( $this->inter_id, $data ['member'], array (
				'countday' => $countday,
				'price' => $avg_price,
				'config' => $config_data ['PRICE_EXCHANGE_POINT'],
				'roomnums' => 1
			) );
		}

		// 储值消费码
		$data ['banlance_code'] = 0;
		if (! empty ( $config_data ['BANCLANCE_COMSUME_CODE_NEED'] ) && $config_data ['BANCLANCE_COMSUME_CODE_NEED'] == 1) {
			$data ['banlance_code'] = 1;
		}

        //积分支付密码
        $data ['point_pay_code'] = 0;
        if (! empty ( $config_data ['POINT_PAY_CODE_NEED'] ) && $config_data ['POINT_PAY_CODE_NEED'] == 1) {
            $data ['point_pay_code'] = 1;
        }

		//获取券的额外参数
		$data['extra_para']=array();
		$first_room=current($data ['room_list']);
		if (!empty($first_room['webser_id'])){
			$data['extra_para']['web_room_id']=$first_room['webser_id'];
			if (!empty($data ['first_state']['extra_info']['pms_code'])){
				$data['extra_para']['pms_code']=$data ['first_state']['extra_info']['pms_code'];
			}
		}
		$data['extra_para']=json_encode($data['extra_para']);



        $coupon_condition = array (
            'startdate' => $startdate,
            'enddate' => $enddate,
            'hotel' => $hotel_id,
            'price_code'=>current($price_codes),
            'product'=>array(key($data_arr)),
            'category'=>key($data_arr),
            'rooms'=>1,
            'product_num'=>1,
            'extra_para'=>json_decode($data['extra_para']),
            'level'=>array($this->member_lv),
            'amount'=>$data['total_price'],
            'paytype'=>'weixin'

        );


        $select_coupon = $this->select_coupon($coupon_condition);   //自动选择优惠券

        $data['select_coupon_favour'] = 0;
        $data['use_coupon_code'] = array();
        $data['use_coupon']=array();
        if(isset($select_coupon['selected']) && !empty($select_coupon['select_coupon_favour'])){
            $data['select_coupon_favour'] = $select_coupon['select_coupon_favour'];
            foreach($select_coupon['selected'] as $arr_coupon){
                    $data['use_coupon_code'][] = $arr_coupon['code'];
                    $data['use_coupon'][$arr_coupon['code']] = $arr_coupon['reduce_cost'];
            }
            $data['total_price'] = $data['total_price'] - $select_coupon['select_coupon_favour'];
        }


        if(isset($config_data['BONUS_VIEW_SETTING'])){
            $data['bonus_setting'] = $config_data['BONUS_VIEW_SETTING'];
        }else{
            $data['bonus_setting'] = 0;
        }

        $data['exchange_max_point'] = isset($data['member']->bonus)?$data['member']->bonus:0;
        if(isset($point_consum_set['part_set']['max_use']) && !empty($point_consum_set['part_set']['max_use'])){
            if($point_consum_set['part_set']['max_use'] < $data['member']->bonus){
                $data['exchange_max_point'] = $point_consum_set['part_set']['max_use'];
            }
        }
        if($data['total_price'] < $data['exchange_max_point']*$point_consum_set ['consum_rate']){
            $data['exchange_max_point'] = round($data['total_price']/$point_consum_set ['consum_rate']);
        }
        if($data['exchange_max_point']*$point_consum_set ['consum_rate']>=$data['total_price']){
            $data['exchange_max_point'] = ($data['total_price']-1)/$point_consum_set ['consum_rate'];
        }
        if(isset($point_consum_set['part_set']['use_rate']) && !empty($point_consum_set['part_set']['use_rate'])){
            if(fmod($data['exchange_max_point'],$point_consum_set['part_set']['use_rate']) !=0){
                $data['exchange_max_point'] = $data['exchange_max_point'] - fmod($data['exchange_max_point'],$point_consum_set['part_set']['use_rate']);
            }
        }

        $data['exchange_max_point'] = floor($data['exchange_max_point']);


//        $invoice_id = $this->input->get('eid');
//        if(isset($invoice_id)){
//            $this->load->model ( 'invoice/Invoice_model' );
//            $data['invoice'] =  $this->Invoice_model->getInvoiceById($this->openid,$invoice_id);
//        }

		$data ['type'] = $type;
		if($type == 'athour'){
			//读取售卖时间段 缺省
			if(!isset($data ['first_state']['time_condition']) || empty($data ['first_state']['time_condition'])){
				redirect ( Hotel_base::inst()->get_url('INDEX',array('h'=>$hotel_id,'type'=>$type)) );
			}else{
				$saletime_start = date('Ymd').$data ['first_state']['time_condition']['book_time']['s'].'00';
				$saletime_end = date('Ymd').$data ['first_state']['time_condition']['book_time']['e'].'00';
				$saletime_mod = $data ['first_state']['time_condition']['book_time']['mod'];
			}
			$thistime = date('YmdHis');
			$selecttime = array();
			if($thistime<=$saletime_start){
				$thistime = $saletime_start;
			}else{
				if($saletime_mod == 60){
					 $thistime = date('YmdHis',strtotime(substr($thistime,0,10).'0000') + 3600);
				}elseif($saletime_mod == 30){
					$nowminu = substr($thistime,-4,2);
					if($nowminu < 30){
						$thistime = date('YmdHis',strtotime(substr($thistime,0,10).'0000') + 1800);
					}else{
						$thistime = date('YmdHis',strtotime(substr($thistime,0,10).'0000') + 3600);
					}
				}else{
					$saletime_mod = 60;
					$thistime = date('YmdHis',strtotime(substr($thistime,0,10).'0000') + 3600);
				}
			}
			while ( $thistime <= $saletime_end) {
				$selecttime[] = date('H:i',strtotime($thistime));
				$thistime = date('YmdHis',strtotime($thistime)+$saletime_mod*60);
			}
			$data['selecttime'] = $selecttime;
			$this->display ( 'hotel/bookroom/submit_order_athour', $data );
		}elseif($type == 'ticket'){
			$this->display ( 'hotel/bookroom/submit_order_ticket', $data );
		}else{
			$this->display ( 'hotel/bookroom/submit_order', $data );
		}

	}
	function saveorder() {

		// Visit log
		$now=date ( 'Y-m-d H:i:s' );

		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->model ( 'hotel/Order_model' );
		$this->load->model ( 'hotel/Hotel_config_model' );
		$startdate = date ( 'Ymd', strtotime ( $this->input->post ( 'startdate' ) ) );
		$enddate = date ( 'Ymd', strtotime ( $this->input->post ( 'enddate' ) ) );
		$hotel_id = intval ( $this->input->post ( 'hotel_id' ) );
		$price_codes = json_decode ( $this->input->post ( 'price_codes' ), TRUE );
		$datas = $this->input->post ( 'datas' );
		$price_type = json_decode ( $this->input->post ( 'price_type' ), TRUE );
		$coupons = json_decode ( $this->input->post ( 'coupons' ), TRUE );
		$roomnos = json_decode ( $this->input->post ( 'roomnos' ), TRUE );
		// @author lGh 加服务配置
		$add_service = json_decode ( $this->input->post ( 'add_service' ), TRUE );
		$extra_formdata = json_decode($this->input->post ( 'extra_formdata' ),TRUE);
		$custom_remark = $this->input->post ( 'custom_remark',TRUE );
		$consume_code = $this->input->post ( 'consume_code' );
        $bonus_consume_code = $this->input->post ( 'consume_code' );
        $point_pay_code = $this->input->post ( 'consume_code' );
    
		$name = htmlspecialchars ( $this->input->post ( 'name' ) );
		$tel = htmlspecialchars ( $this->input->post ( 'tel' ) );
		$email = $this->input->post ( 'email' ) ;
		$paytype = htmlspecialchars ( $this->input->post ( 'paytype' ) );
		$bonus = intval ( $this->input->post ( 'bonus' ) );
		$config_data = $this->Hotel_config_model->get_hotel_config ( $this->inter_id, 'HOTEL', $hotel_id, array (
			'HOTEL_ORDER_ENSURE_WAY',
			// 'HOTEL_IS_PMS',
			'PMS_AFT_SUBMIT',
			'PRICE_EXCHANGE_POINT',
			'BANCLANCE_COMSUME_CODE_NEED' ,
			'HOTEL_BONUS_CONFIG',
			'HOTEL_BALANCE_PART_PAY',
			'PMS_POINT_REDUCE_WAY',
			'POINT_EXCHANGE_ROOM',//积分换房
            'BONUS_COMSUME_CODE_NEED',
            'POINT_PAY_NEED_CODE',
			'HOTEL_PREPAY_FAVOUR',
			'POINT_NAME',
		    'BOOK_ADDIT_SERVICE',
		    'BOOK_DATE_VALIDATE'
		) );
		$point_name=empty($config_data['POINT_NAME'])?'积分':$config_data['POINT_NAME'];
		$info = array ();
		$order_data = array ();
		$order_additions = array ();
		
		if (isset($custom_remark)){
		    if (mb_strlen($custom_remark,'UTF-8')>256){
		        $info ['s'] = 0;
		        $info ['errmsg'] = '备注信息过长，请重新填写';
		        echo json_encode ( $info );
		        exit ();
		    }
    		$order_data['customer_remark']=$custom_remark;
		}else{
    		$order_data['customer_remark']='';
		}
		
		$this->load->helper('string');
		$name=trim_space($name);
		
		$this->load->model ( 'hotel/Service_model' );
		$book_formdata=isset($extra_formdata['addit_service'])?$extra_formdata['addit_service']:array();
		if (!empty($config_data['BOOK_ADDIT_SERVICE'])){
		    $check_service=$this->Service_model->check_book_formdata($book_formdata,json_decode($config_data['BOOK_ADDIT_SERVICE'],TRUE),'addit_service',array(
		            'startdate'=>$startdate,
		            'enddate'=>$enddate
		    ));
		    if ($check_service['s']==0){
		        unset($check_service['data']);
		        echo json_encode ( $check_service );
		        exit ();
		    }else{
		        $order_additions['add_service_info']=isset($check_service['data'])?json_encode($check_service['data']):'';
		    }
		}
		
		//可预订的开始日期
		$pre_sp_date=$this->preSpDate($hotel_id,$config_data);
		$enable_start = date ( 'Y/m/d',time()+($pre_sp_date*86400));

		if (empty($paytype)){
			$info ['s'] = 0;
			$info ['errmsg'] = '请选择支付方式';
			echo json_encode ( $info );
			exit ();
		}

		if (! $datas || ! $name || ! $tel || ! strtotime ( $this->input->post ( 'startdate' ) ) || ! strtotime ( $this->input->post ( 'enddate' ) ) || $startdate < $enable_start || $enddate <= $startdate) {
			$info ['s'] = 0;
			$info ['errmsg'] = '请填写有效信息';
			echo json_encode ( $info );
			exit ();
		}
		
		if (isset($email)&&empty($email)){
		    $info ['s'] = 0;
		    $info ['errmsg'] = '请填写邮箱地址';
		    echo json_encode ( $info );
		    exit ();
		}
		$email=htmlspecialchars($email);
		
		$hotel_row=$this->Hotel_model->get_hotel_detail($this->inter_id,$hotel_id);
		if(!empty($hotel_row['multiple_inner'])){
			$customer = [];
			
			if($this->input->post('customer') !== null && is_array($this->input->post('customer'))){
				$customer = array_map('trim_space', $this->input->post('customer'));
				foreach($customer as $v){
					if(!$v){
						$info ['s'] = 0;
						$info ['errmsg'] = '请填写有效信息';
						echo json_encode($info);
						exit ();
						break;
					}
				}
			}
			//将主单的入住人放到最前
			array_unshift($customer, $name);
		}
		
		
		if (! empty ( $config_data ['BANCLANCE_COMSUME_CODE_NEED'] ) && $config_data ['BANCLANCE_COMSUME_CODE_NEED'] == 1 && $paytype == 'balance') {
			if (empty ( $consume_code )) {
				$info ['s'] = 0;
				$info ['errmsg'] = '请填写消费密码';
				echo json_encode ( $info );
				exit ();
			}
		} else {
			$consume_code = '';
		}
        if (! empty ( $config_data ['BONUS_COMSUME_CODE_NEED'] ) && $config_data ['BONUS_COMSUME_CODE_NEED'] == 1 && !empty($bonus)) {
            if (empty ( $bonus_consume_code )) {
                $info ['s'] = 0;
                $info ['errmsg'] = '请填写消费密码';
                echo json_encode ( $info );
                exit ();
            }
        } else {
            $bonus_consume_code = '';
        }
        if (! empty ( $config_data ['POINT_PAY_NEED_CODE'] ) && $config_data ['POINT_PAY_NEED_CODE'] == 1 && $paytype == 'point') {
            if (empty ( $point_pay_code )) {
                $info ['s'] = 0;
                $info ['errmsg'] = '请填写消费密码';
                echo json_encode ( $info );
                exit ();
            }
        } else {
            $point_pay_code = '';
        }
//         if(! empty ( $config_data ['HOTEL_BONUS_CONFIG'] )){
//             $checkBonus=$bonus%100;
//             if ($checkBonus!=0) {
//                 $info ['s'] = 0;
//                 $info ['errmsg'] = '消费积分必须是100的倍数';
//                 echo json_encode ( $info );
//                 exit ();
//             }
//         }
		$data_arr = json_decode ( $datas, TRUE );
		foreach ( $data_arr as $key => $value ) {
			if ($value == 0) {
				unset ( $data_arr [$key] );
			}
		}
		$room_list = $this->Hotel_model->get_rooms_detail ( $this->inter_id, $hotel_id, array_keys ( $data_arr ), array (
			'number_realtime' => array (
				's' => $startdate,
				'e' => $enddate
			),
			'data' => 'key'
		) );
		$condit = array (
			'startdate' => $startdate,
			'enddate' => $enddate,
			'price_codes' => implode ( ',', $price_codes ),
			'nums' => $data_arr,
			'openid' => $this->openid,
			'member_level' => $this->member_lv
		);
		// if ( $this->member_lv !='') {
		$this->load->model ( 'hotel/Member_model' );
		$member_privilege = $this->Member_model->level_privilege ( $this->inter_id );
		if (! empty ( $member_privilege )) {
			$condit ['member_privilege'] = $member_privilege;
		}
		// }
		if (! empty ( $price_type )) {
			$condit ['price_type'] = array_keys ( $price_type );
		}
		$this->load->library ( 'PMS_Adapter', array (
			'inter_id' => $this->inter_id,
			'hotel_id' => $hotel_id
		), 'pmsa' );
		$rooms = $this->pmsa->get_rooms_change ( $room_list, array (
			'inter_id' => $this->inter_id,
			'hotel_id' => $hotel_id
		), $condit, true );
		$order_additions ['third_favour_info'] = array ();
		$order_data ['price'] = 0;
		$no_pay_ways = array ();
		$order_data ['roomnums'] = array_sum ( $data_arr );

		$subs = array ();
		$room_codes = array ();
		if (empty ( $rooms )) {
			$info ['s'] = 0;
			$info ['errmsg'] = '无可订房间！';
			echo json_encode ( $info );
			exit ();
		}

		$related_coupons=array();
		$first_state=array();
		foreach ( $rooms as $k => $rm ) {
			$code_price = $rm ['state_info'] [$price_codes [$k]];
            empty($first_state) and $first_state=$code_price;
			//@Editor lGh 2016-7-10 11:39:46 券关联
			if (!empty($code_price['coupon_condition']['couprel'])){
				$related_coupons[$code_price['coupon_condition']['couprel']]=1;
			}

			//@Editor lGh 2016-7-29 11:59:33 积分兑换比例配置
			if (!empty($code_price['coupon_condition']['no_coupon'])&&!empty($coupons)){
				$info ['s'] = 0;
				$info ['errmsg'] = '此价格不能用券！';
				echo json_encode ( $info );
				exit ();
			}
			if (!empty($code_price['bonus_condition']['no_part_bonus'])&&!empty($bonus)){
				$info ['s'] = 0;
				$info ['errmsg'] = '此价格不能用积分！';
				echo json_encode ( $info );
				exit ();
			}
			if (!empty($code_price['bonus_condition']['poc'])&&(!empty($bonus)&&!empty($coupons))){
				$info ['s'] = 0;
				$info ['errmsg'] = '此价格不能同时使用积分与优惠券！请重新选择';
				echo json_encode ( $info );
				exit ();
			}

			$room_info = $rm ['room_info'];
			$room_codes [$room_info ['room_id']] ['code'] ['price_type'] = $code_price ['price_type'];
			if (! empty ( $consume_code )) {
				$room_codes [$room_info ['room_id']] ['room'] ['consume_code'] = $consume_code;
			}
            if (! empty ( $bonus_consume_code )) {
                $room_codes [$room_info ['room_id']] ['room'] ['bonus_consume_code'] = $bonus_consume_code;
            }
            if (! empty ( $point_pay_code )) {
                $room_codes [$room_info ['room_id']] ['room'] ['point_pay_code'] = $point_pay_code;
            }
			$room_codes [$room_info ['room_id']] ['code'] ['extra_info'] = empty ( $code_price ['extra_info'] ) ? '' : $code_price ['extra_info'];
			$room_codes [$room_info ['room_id']] ['room'] ['webser_id'] = $rm ['room_info'] ['webser_id'];
			if ($code_price ['book_status'] != 'available') {
				$info ['s'] = 0;
				$info ['errmsg'] = '房间数不足！';
				echo json_encode ( $info );
				exit ();
			}
			if (! empty ( $roomnos [$k] )) {
				$tmp_nos = array_keys ( $room_info ['number_realtime'] );
				foreach ( $roomnos [$k] as $rk => $no ) {
					if (! in_array ( $rk, $tmp_nos )) {
						$info ['s'] = 0;
						$info ['errmsg'] = $room_info ['name'] . ' 的房号' . $no . '已被选！';
						echo json_encode ( $info );
						exit ();
					}
				}
			}

			$order_data ['price'] += $code_price ['total_price'];
			$no_pay_ways = empty ( $code_price ['condition'] ['no_pay_way'] ) ? $no_pay_ways : array_merge ( $no_pay_ways, $code_price ['condition'] ['no_pay_way'] );

			$subs [$room_info ['room_id']] ['allprice'] = $code_price ['allprice'];
			$subs [$room_info ['room_id']] ['roomname'] = $room_info ['name'];
			$subs [$room_info ['room_id']] ['iprice'] = $code_price ['total'];
			$subs [$room_info ['room_id']] ['price_code'] = $price_codes [$k];
			$subs [$room_info ['room_id']] ['price_code_name'] = $code_price ['price_name'];
			//子订单增加早餐数记录
			$subs [$room_info ['room_id']] ['breakfast_nums'] = !empty($code_price ['bookpolicy_condition']['breakfast_nums'])?$code_price['bookpolicy_condition']:'';
			
			//多个入住人信息
			if(!empty($customer)){
				$subs[$room_info['room_id']]['customer']=$customer;
			}
		}
		
		if (!empty($first_state['customer_condition']['multi_fill'])){
    		$multi_inner=isset($extra_formdata['multi_inner'])?$extra_formdata['multi_inner']:array();
    		$check_inner=$this->Service_model->check_book_formdata($multi_inner,$first_state['customer_condition'],'multi_inner',array('roomnums'=>$order_data['roomnums'],'first_man'=>$name));
    		if ($check_inner['s']==0){
    		    unset($check_inner['data']);
    		    echo json_encode ( $check_inner );
    		    exit ();
    		}else{
    		    $subs[key ( $data_arr )]['multi_inners']=$check_inner['data'];
    		}
		}
		$order_additions ['room_codes'] = json_encode ( $room_codes );
// 		$member = $this->pub_pmsa->check_openid_member ( $this->inter_id, $this->openid, array (
// 			'create' => TRUE,
// 			'update' => TRUE
// 		) );
		$member = $this->member_info;

		if ($paytype == 'bonus') {
			// @author lGh 2016-4-6 21:34:15 积分换房
			$countday = get_room_night($startdate, $enddate ,'ceil',$order_data);//至少有1个间夜
			$avg_price = floatval ( $order_data ['price'] / ($countday * $order_data ['roomnums']) );
			// $this->load->model ( 'hotel/Hotel_config_model' );
			// $config_data = $this->Hotel_config_model->get_hotel_config ( $this->inter_id, 'HOTEL', $hotel_id, 'PRICE_EXCHANGE_POINT');
			if (! empty ( $config_data ['PRICE_EXCHANGE_POINT'] )) {
				$this->load->model ( 'hotel/Member_model' );
				$point_exchange = $this->Member_model->room_point_exchange ( $this->inter_id, $member, array (
					'countday' => $countday,
					'price' => $avg_price,
					'config' => $config_data ['PRICE_EXCHANGE_POINT'],
					'roomnums' => $order_data ['roomnums']
				) );
			}
			if (empty ( $point_exchange ) || $point_exchange ['can_exchange'] == 0) {
				$info ['s'] = 0;
				$info ['errmsg'] = '积分不足兑换！';
				echo json_encode ( $info );
				exit ();
			} else {
				$order_additions ['point_favour'] = $order_data ['price'];
				$order_additions ['point_used'] = 1;
				$order_additions ['point_used_amount'] = $point_exchange ['point_need'];
				$order_data ['price'] -= $order_additions ['point_favour'];
				$bonus_paid = 1;
			}
		}

		// 使用代金券
		$coupon_rel=array();
		if ((!empty($related_coupons)||! empty ( $coupons )) && empty ( $bonus_paid )) {
			$this->load->model ( 'hotel/Coupon_model' );
			$params = array ();
			$params ['days'] = get_room_night($startdate,$enddate,'round',$order_data);//至少有1个间夜
			$params ['amount'] = $order_data ['price'];
			$params ['hotel'] = $hotel_id;
			$params ['rooms'] = $order_data ['roomnums'];
			$params ['product_num'] = $order_data ['roomnums'];
			$params ['product'] = array_keys ( $data_arr );
			$params ['level'] = $this->member_lv;
			reset ( $data_arr );
			$params ['category'] = key ( $data_arr );
			$params ['price_code'] = current ( $price_codes );
			$params ['paytype'] = $paytype;

			//获取券的额外参数
			$params ['startdate'] = $startdate;
			$params ['enddate'] = $enddate;
			$params['extra_para']=array();
			$first_room=current($room_list);
			if (!empty($first_room['webser_id'])){
				$params['extra_para']['web_room_id']=$first_room['webser_id'];
				if (!empty($room_codes [$first_room ['room_id']] ['code'] ['extra_info']['pms_code'])){
					$params['extra_para']['pms_code']=$room_codes [$first_room ['room_id']] ['code'] ['extra_info']['pms_code'];
				}
			}
			$coupon_check = $this->Coupon_model->check_coupon_using ( $this->inter_id, $this->openid, $params, array_keys ( $coupons ),$coupons,$related_coupons );

			if ($coupon_check ['s'] == 0) {
				echo json_encode ( $coupon_check );
				exit ();
			}
			$order_additions ['coupon_favour'] = $coupon_check ['coupon_amount'];
			$order_additions ['coupon_des'] = json_encode ( $coupon_check ['coupon_info'],JSON_UNESCAPED_UNICODE );
			$order_additions ['coupon_used'] = 1;
			if (!empty($coupon_check['coupon_rel'])){
				$coupon_rel=$coupon_check['coupon_rel'];
			}
			$order_data ['price'] -= $order_additions ['coupon_favour'];
			if ($order_data ['price'] <= 0) {
				$info ['s'] = 0;
				$info ['errmsg'] = '不能用那么多券哦！';
				echo json_encode ( $info );
				exit ();
			}
		}

		// 部分使用积分
		if (! empty ( $bonus ) && ! empty ( $member ) && empty ( $bonus_paid )) {
			//@Editor lGh 2016-5-27 19:25:23 增加积分支付方式
			if ($paytype=='point') {
				$info ['s'] = 0;
				$info ['errmsg'] = '您选择了积分支付，不能再使用积分抵扣';
				echo json_encode ( $info );
				exit ();
			}
			if ($bonus<=0){
				$info ['s'] = 0;
				$info ['errmsg'] = '请输入正确的积分数';
				echo json_encode ( $info );
				exit ();
			}
			if ($member->bonus < $bonus) {
				$info ['s'] = 0;
				$info ['errmsg'] = '积分不足！';
				echo json_encode ( $info );
				exit ();
			}

			//@Editor lGh 2016-7-29 11:59:33 积分兑换比例配置
			$point_condit = array (
				'startdate' => $startdate,
				'enddate' => $enddate,
				'nums' => $order_data ['roomnums'],
				'openid' => $this->openid,
				'member_level' => $this->member_lv,
				'room_id'=>key($data_arr),
				'price_code'=>current($price_codes),
				'bonus'=> isset($this->common_data ['member']->bonus)?$this->common_data ['member']->bonus:0,
				'hotel_id'=>$hotel_id,
				'used'=>$bonus,
				'paytype'=>$paytype,
				'roomnums'=>$order_data['roomnums'],
				'total_price'=>$order_data['price'],
				'point_name'=>$point_name,
				'check_point_name'=>1
			);

			$this->load->model ( 'hotel/Member_model' );
			$point_consum_rate = $this->Member_model->get_point_consum_rate ( $this->inter_id, $this->member_lv,'room',$member_privilege,$point_condit );
			if (! empty ( $point_consum_rate )) {
				if ($point_consum_rate['s']!=0 && !empty($point_consum_rate['consum_rate'])){
					$order_additions ['point_favour'] = $bonus * $point_consum_rate['consum_rate'];
					$order_additions ['point_used'] = 1;
					$order_additions ['point_used_amount'] = $bonus;
					$order_data ['price'] -= $order_additions ['point_favour'];
				}else if ($point_consum_rate['s']==0){
					$info ['s'] = 0;
					$info ['errmsg'] = $point_consum_rate['errmsg'];
					echo json_encode ( $info );
					exit ();
				}
			}
			if ($order_data ['price'] <= 0) {
				$info ['s'] = 0;
				$info ['errmsg'] = '不能用那么多积分哦！';
				echo json_encode ( $info );
				exit ();
			}
		}

		//@Editor lGh 2016-5-27 19:21:22 增加积分支付方式 bonus为积分兑换，兑换后订单价格为0，point为积分支付，类似储值支付
		if ($paytype == 'point') {
			$countday = get_room_night($startdate,$enddate,'ceil',$order_data);//至少有1个间夜
			/**
			 * PMS的积分换房规则
			 * add by 鹏 On 2016-10-17
			 */
			$room_id=key($data_arr);
			$point_params=[
				'countday'     => $countday,
				'startdate'    => $startdate,
				'enddate'      => $enddate,
				'openid'       => $this->openid,
				'total_price'  => $order_data ['price'],
				'roomnums'     => $order_data ['roomnums'],
				'hotel_id'     => $hotel_id,
				'room_id'      => $room_id,
				'bonus'        => isset($this->common_data ['member']->bonus) ? $this->common_data ['member']->bonus : 0,
				'member_level' => $this->member_lv,
				'price_code'   => current($price_codes),
				'point_name'=>$point_name,
				'check_point_name'=>1
			];

			//判断是否使用PMS自定义的积分换房规则
			$point_params['is_pms_reduce']=false;
			if(!empty($config_data['POINT_EXCHANGE_ROOM'])){
				$code_point_set = json_decode($config_data['POINT_EXCHANGE_ROOM'], true);
				if(!empty($code_point_set['is_pms'])){
					$point_params['is_pms_reduce'] = true;
				}
			}

			$this->load->model('hotel/Member_model');
			$point_exchange = $this->Member_model->point_pay_check($this->inter_id, $point_params);

			if (empty ( $point_exchange ) || $point_exchange ['can_exchange'] == 0) {
				$info ['s'] = 0;
				$info ['errmsg'] = isset($point_exchange['errmsg'])?$point_exchange['errmsg']:'积分不足支付！';
				echo json_encode ( $info );
				exit ();
			} else {
				$order_additions ['point_used'] = 1;
				$order_additions ['point_used_amount'] = $point_exchange['point_need'];
				$point_paid = 1;
			}
		}

		// 储值支付
		if ($paytype == 'balance') {
			if (empty ( $member ) || $member->balance < $order_data ['price']) {
				$info ['s'] = 0;
				$info ['errmsg'] = '余额不足！';
				echo json_encode ( $info );
				exit ();
			}
		}

		$prepay_favour=isset($config_data['HOTEL_PREPAY_FAVOUR'])?json_decode($config_data['HOTEL_PREPAY_FAVOUR'],TRUE):array();
		if ($paytype == 'weixin') {
			if (isset($prepay_favour['weixin'])){
				$order_additions ['wxpay_favour'] = $prepay_favour['weixin'];
				$order_data ['price'] -= $order_additions ['wxpay_favour'];
			}else if(!empty($first_state['bookpolicy_condition']['wxpay_favour'])&&$first_state['bookpolicy_condition']['wxpay_favour']>0){
			    $order_additions ['wxpay_favour']=$first_state['bookpolicy_condition']['wxpay_favour'];
				$order_data ['price'] -= $order_additions ['wxpay_favour'];
			}
		}

		if ($order_data ['price'] <= 0 && empty ( $bonus_paid )) {
			$info ['s'] = 0;
			$info ['errmsg'] = '价格错误！';
			echo json_encode ( $info );
			exit ();
		}

		// 保存订单
		$order_data ['hotel_id'] = $hotel_id;
		$order_data ['inter_id'] = $this->inter_id;
		$order_data ['openid'] = $this->openid;
		$order_data ['name'] = $name;
		$order_data ['tel'] = $tel;
		$order_data ['email'] = $email;
		$order_data ['startdate'] = $startdate;
		$order_data ['enddate'] = $enddate;
		$order_data ['status'] = 0;
		$order_data ['price_type'] = $condit ['price_type'][0];
		$order_additions['third_favour_info']=empty($order_additions['third_favour_info'])?'':json_encode($order_additions['third_favour_info']);
		//钟点房入住时间
		//读取售卖时间段
		if($condit ['price_type'][0] == 'athour'){
			$order_data ['enddate'] = $startdate;
			if(!isset($first_state['time_condition']) || empty($first_state['time_condition'])){
				$info ['s'] = 0;
				$info ['errmsg'] = '所选入住时间已过';
				echo json_encode ( $info );
				exit ();
			}else{
				$saletime_start = date('Ymd').$first_state['time_condition']['book_time']['s'].'00';
				$saletime_end = date('Ymd').$first_state['time_condition']['book_time']['e'].'00';
			}
			$intime = date('Y-m-d ').$this->input->post ( 'intime' ).':00';
			if(strtotime($intime)<time() || strtotime($intime)<strtotime($saletime_start) || strtotime($intime)>strtotime($saletime_end)){
				$info ['s'] = 0;
				$info ['errmsg'] = '所选入住时间已过！';
				echo json_encode ( $info );
				exit ();
			}
			$order_data ['starttime'] = $intime.':00';
		}

		$order_data ['paytype'] = $paytype; // 支付类型

		$order_data ['own_saler']=$this->my_saler_id;
		if (empty($this->my_saler_id)){
			$order_data ['link_saler']=$this->link_saler_id;
		}else{
			if (!empty($this->ori_saler_id)){
				$order_data ['link_saler']=$this->ori_saler_id;
			}else {
				$order_data ['link_saler']=$this->link_saler_id;
			}
		}

		$order_data ['own_f_saler']=$this->my_f_saler_id;
		if (empty($this->my_f_saler_id)){
			$order_data ['link_f_saler']=$this->link_f_saler_id;
		}else{
			if (!empty($this->ori_f_saler_id)){
				$order_data ['link_f_saler']=$this->ori_f_saler_id;
			}else {
				$order_data ['link_f_saler']=$this->link_f_saler_id;
			}
		}

		$this->load->model ( 'pay/Pay_model' );
		$pre_pay = $this->Pay_model->is_online_pay ( $order_data ['paytype'] );
		if ($pre_pay == 1) {
			$order_data ['status'] = 9;
		} else if (! empty ( $config_data ['HOTEL_ORDER_ENSURE_WAY'] ) && $config_data ['HOTEL_ORDER_ENSURE_WAY'] == 'instant') {
			$order_data ['status'] = 1;
		}

		if ($member){
			$order_data ['member_no'] = $member->mem_card_no;
			$order_data ['jfk_member_no'] = $member->jfk_member_no;
		}
		$info = $this->Order_model->create_order ( $this->inter_id, array (
			'main_order' => $order_data,
			'order_additions' => $order_additions,
			'coupon_rel'=>$coupon_rel
		), $data_arr, $subs, $roomnos );

		if ($info ['s'] == 1) {

			// if (! empty ( $config_data ['HOTEL_IS_PMS'] ) && $config_data ['HOTEL_IS_PMS'] == 1) {
			// if ((! empty ( $config_data ['PMS_PRE_SUBMIT'] ) && $config_data ['PMS_PRE_SUBMIT'] == 1) || $pre_pay != 1) {
			if ($pre_pay != 1) {
				$msg = $this->pmsa->order_submit ( $this->inter_id, $info ['orderid'], array (
					'room_codes' => $room_codes
				) );
				if ($msg ['s'] == 0) {
					$this->Order_model->handle_order ( $this->inter_id, $info ['orderid'], 10, $this->openid ,array('main_db'=>1)); // pms下单失败，退回
					$info = $msg;
				} else {
					$this->Order_model->handle_order ( $this->inter_id, $info ['orderid'], 'ss','',array('main_db'=>1) );
					if (!empty($info['has_paid'])||!empty($msg['has_paid'])){
						$this->Order_model->update_order_status ( $this->inter_id, $info ['orderid'], 1, $this->openid, true );
					}else if ($order_data ['status'] == 1) {
						$this->Order_model->handle_order ( $this->inter_id, $info ['orderid'], $order_data ['status'], $this->openid ,array('main_db'=>1));
					}
				}
			} else {
				if ((empty ( $config_data ['PMS_AFT_SUBMIT'] ) || $config_data ['PMS_AFT_SUBMIT'] == 0)||(!empty($config_data ['PMS_POINT_REDUCE_WAY'])&&$config_data ['PMS_POINT_REDUCE_WAY']=='after'&&$paytype=='point')) {
					$msg = $this->pmsa->order_submit ( $this->inter_id, $info ['orderid'], array (
						'room_codes' => $room_codes
					) );
					if ($msg ['s'] == 0) {
						$this->Order_model->handle_order ( $this->inter_id, $info ['orderid'], 10, $this->openid,array('main_db'=>1) ); // pms下单失败，退回
						$info = $msg;
					}else{
						$this->Order_model->handle_order ( $this->inter_id, $info ['orderid'], 'ss','',array('main_db'=>1) );
						if (!empty($info['has_paid'])||!empty($msg['has_paid'])){
							$this->Order_model->update_order_status ( $this->inter_id, $info ['orderid'], 1, $this->openid, true );
						}
					}
				}
			}


            $invoice_id = $this->input->post('invoice');

            if($invoice_id !=0){
                $this->load->model ( 'invoice/Invoice_model' );
                $invoice_post = array(
                    'openid'=>$this->openid,
                    'inter_id'=>$this->inter_id,
                    'orderid'=>$info ['orderid'],
                    'invoice_id'=>$invoice_id,
                    'hotel_id'=>$hotel_id,
                    'amount'=>$order_data ['price'],
                    'createtime'=>date('Y-m-d H:i:s',time())
                );

                $invoice_info = $this->Invoice_model->getInvoiceById($this->openid,$invoice_id);

                $invoice_content = array(
                    'type'=>$invoice_info['type'],
                    'title'=>$invoice_info['title']
                );

                if(!empty($invoice_info['content'])){
                    $content = json_decode($invoice_info['content']);
                    if(!empty($content)){
                        foreach($content as $key=>$arr){
                            $invoice_content[$key] = $arr;
                        }
                    }
                }

                $invoice_post['invoice_content'] = json_encode($invoice_content);


                $get_invoice = $this->Invoice_model->book_invoice($invoice_post);

                if($get_invoice != 0 ){
                    $this->Invoice_model->update_order_invoice($this->openid,$this->inter_id,$info ['orderid']);
                }

            }
		}

		if (isset($info['errmsg'])&&$point_name!='积分'){
			$info['errmsg']=str_replace('积分', $point_name, $info['errmsg']);
		}

		echo json_encode ( $info );

		// Visit log
		$this->load->model ( 'common/Record_model' );
		$this->Record_model->visit_log ( array (
			                                 'openid' => $this->openid,
			                                 'inter_id' => $this->session->userdata ( 'inter_id' ),
			                                 'title' => '提交订单',
			                                 'url' => $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'],
			                                 'visit_time' => date ( 'Y-m-d H:i:s' ),
			                                 'des' => $now.'-'.getIp()
		                                 ) );
	}
	function add_hotel_collection() {
        //获取皮肤配置
        $params=array(
            'openid'=>$this->openid
        );
        $data = $this->Hotel_api_data_model->add_hotel_collection($params);
        $this->out_put_msg(1,'',$data,'hotel/hotel/add_hotel_collection');
	}
	function clear_visited_hotel() {
        $data = $this->Hotel_api_data_model->clear_visited_hotel();
        $this->out_put_msg(1,'',$data,'hotel/hotel/clear_visited_hotel');
	}
	function cancel_one_mark() {
        $params = array('openid'=>$this->openid);
        $data = $this->Hotel_api_data_model->cancel_one_mark($params);
        $this->out_put_msg(1,'',$data,'hotel/hotel/cancel_one_mark');
	}
	function orderdetail() {
        $params = array(
            'openid'=>$this->openid,
            'member_no'=>$this->member_no
        );
        $data = $this->Hotel_api_data_model->orderdetail($params);
        $this->out_put_msg(1,'',$data,'hotel/hotel/orderdetail');
	}
	function myorder() {
        $params = array(
            'openid'=>$this->openid,
            'member_no'=>$this->member_no
        );
        $data = $this->Hotel_api_data_model->myorder($params);
        $this->out_put_msg(1,'',$data,'hotel/hotel/myorder');
	}
	function hotel_photo() {
		$data = $this->common_data;
		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->model ( 'hotel/Gallery_model' );
		$data ['hotel_id'] = $hotel_id = $this->Hotel_model->get_a_hotel_id ( $this->inter_id, $this->input->get ( 'h' ), false );
		$data ['gallery_count'] = $this->Gallery_model->get_gallery_count ( $this->inter_id, $data ['hotel_id'] );
		$data ['first_gallery'] = $data ['gallery_count'] [0];
		$data ['cur_gallery'] = $this->Gallery_model->get_gallery ( $this->inter_id, array (
			'hotel_id' => $data ['hotel_id'],
			'gallery_id' => $data ['first_gallery'] ['gid']
		), true, 3, 0 );
		$this->display ( 'hotel/hotel_photo/hotel_photo', $data );
	}
	function get_new_gallery() {
		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->model ( 'hotel/Gallery_model' );
		$hotel_id = $hotel_id = $this->Hotel_model->get_a_hotel_id ( $this->inter_id, $this->input->get ( 'h' ), false );
		$gid = $this->input->get ( 'gid' );
		$nums = $this->input->get ( 'nums' );
		$offset = $this->input->get ( 'offset' );
		$new_gallery = $this->Gallery_model->get_gallery ( $this->inter_id, array (
			'hotel_id' => $hotel_id,
			'gallery_id' => $gid
		), true, $nums, $offset );
		$this->load->helper ( 'ajaxdata' );
		$new_gallery = data_dehydrate ( $new_gallery, array (
			'gid',
			'gallery_name',
			'image_url',
			'info'
		) );
		echo json_encode ( $new_gallery );
	}
	function my_marks() {
		$data = $this->common_data;
		$data ['pagetitle'] = '我的收藏';
		$data ['mark_type'] = intval ( $this->input->get ( 'mt' ) );
		$this->load->model ( 'hotel/Hotel_model' );
		$condit = $this->Hotel_model->return_mark_condi ( $data ['mark_type'] );
		$data ['marks'] = array ();
		if (! empty ( $condit )) {
			$data ['marks'] = $this->Hotel_model->get_front_marks ( array (
				                                                        'inter_id' => $this->inter_id,
				                                                        'openid' => $this->openid,
				                                                        'mark_type' => $condit ['type'],
				                                                        'status' => 1
			                                                        ), $condit ['sort'] );
		}
		$this->display ( 'hotel/my_marks/often_like', $data );
	}
	function get_near_hotel() {
		$latitude = $this->input->get ( 'lat', true );
		$longitude = $this->input->get ( 'lnt', true );
		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->helper ( 'calculate' );
		$hotels = $this->Hotel_model->get_all_hotels ( $this->inter_id, 1 );
		$count = count ( $hotels );
		for($i = 0; $i < $count; $i ++) {
			$hotels [$i] ['distance'] = get_distance ( $hotels [$i] ['longitude'], $hotels [$i] ['latitude'], $longitude, $latitude );
		}
		$hotels = $this->Hotel_model->sort_dyd_array ( $hotels, 'distance', 'gt', 5 );
		$this->load->helper ( 'ajaxdata' );
		echo json_encode ( data_dehydrate ( $hotels, array (
			'name',
			'hotel_id'
		), 'hotel_id' ) );
	}
	function hotel_comment() {
		$data = $this->common_data;
		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->model ( 'hotel/Comment_model' );
		$hotel_id = $this->Hotel_model->get_a_hotel_id ( $this->inter_id, $this->input->get ( 'h' ), false );
		$data ['t_t'] = $this->Comment_model->get_hotel_comment_counts ( $this->inter_id, $hotel_id, 1 ,$this->openid);
		$data ['comments'] = $this->Comment_model->get_hotel_comments ( $this->inter_id, $hotel_id, 1 );
		$data ['pagetitle'] = '酒店评论';
		$data ['hotel_id'] = $hotel_id;

        $this->load->model ( 'hotel/Comment_model' );
        $data ['comment_config'] = $this->Comment_model->get_comment_show_type ( $this->inter_id);

		$this->display ( 'hotel/hotel_comment/hotel_reviews', $data );
	}
	function ajax_hotel_comments(){
		$data = $this->common_data;
		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->model ( 'hotel/Comment_model' );
		$hotel_id = $this->Hotel_model->get_a_hotel_id ( $this->inter_id, $this->input->get ( 'h' ), false );
		$offset = $this->input->get ( 'off', TRUE );
		$offset = empty ( intval ( $offset ) ) ? 0 : intval ( $offset );
		$nums = $this->input->get ( 'num', TRUE );
		$nums = empty ( intval ( $nums ) ) ? 20 : intval ( $nums );
		$nums = $nums > 20 ? 20 : $nums;
		$data ['comments'] = $this->Comment_model->get_hotel_comments ( $this->inter_id, $hotel_id, 1 ,'',$nums,$offset);
		if (!empty($data ['comments'])){
			$html=$this->display ( 'hotel/ajax_hotel_comments/ajax_comment_list', $data , '', array (), TRUE );
			echo json_encode ( array (
				                   's' => 1,
				                   'data' => $html
			                   ), JSON_UNESCAPED_UNICODE );
			exit ();
		}
		echo json_encode ( array (
			                   's' => 0,
			                   'data' => ''
		                   ) );
	}
	function to_comment() {
		$data = $this->common_data;
		$oid = intval ( $this->input->get ( 'oid' ) );
		$this->load->model ( 'hotel/Order_model' );
		$list = $this->Order_model->get_main_order ( $this->inter_id, array (
			'oid' => $oid,
			'openid' => $this->openid,
			'member_no' => $this->member_no,
			'idetail' => array (
				'i'
			)
		) );
		if ($list) {
			$this->load->model ( 'common/Enum_model' );
			$data ['status_des'] = $this->Enum_model->get_enum_des ( 'HOTEL_ORDER_STATUS' );
			$list = $list [0];
			$comment = 0;
			$complete_status = array (
				2,
				3
			);
			if ($list ['handled'] == 1) {
				foreach ( $list ['order_details'] as $od ) {
					if (in_array ( $od ['istatus'], $complete_status )) {
						$comment = 1;
						break;
					}
				}
			} else if (count ( $list ['order_details'] ) == 1) {
				$list ['status_des'] = $data ['status_des']  [$list ['status']];
				if (in_array ( $list ['status'], $complete_status )) {
					$comment = 1;
				}
			}

			$this->load->model ( 'hotel/Comment_model' );
			$data ['comment_info'] = $this->Comment_model->get_order_comment ( $this->inter_id, $list ['orderid'], $this->openid );
            $data ['comment_config'] = $this->Comment_model->get_comment_show_type ( $this->inter_id);
            if(!empty($data ['comment_config']) && !empty($data ['comment_config']->sign)){
                $data ['comment_config']->sign = explode(',',$data ['comment_config']->sign);
            }
			$data ['order'] = $list;
			$data ['pagetitle'] = '订单评论';
			$data ['comment'] = $comment;
			$this->load->model ( 'hotel/Hotel_model' );
			$data ['first_room'] = $this->Hotel_model->get_room_detail ( $this->inter_id, $list ['hotel_id'], $data ['order'] ['first_detail'] ['room_id'], array (
				'img_type' => 'hotel_room_service'
			) );
			$this->display ( 'hotel/hotel/to_comment', $data );
		} else {
			redirect ( Hotel_base::inst()->get_url('MYORDER'));
		}
		// Visit log
		$this->load->model ( 'common/Record_model' );
		$this->Record_model->visit_log ( array (
			                                 'openid' => $this->openid,
			                                 'inter_id' => $this->inter_id,
			                                 'title' => '订单评论',
			                                 'url' => $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'],
			                                 'des' => "订单id：" . $oid
		                                 ) );
	}
	function return_usable_coupon() {
		$this->load->model ( 'hotel/Coupon_model' );
		$params = array ();
		$start = $this->input->post ( 'start' );
		$end = $this->input->post ( 'end' );
		$params ['days']  = get_room_night($start,$end,'round');//至少有1个间夜
		$params ['amount'] = $this->input->post ( 'total' );
		$params ['hotel'] = $this->input->post ( 'h' );
		$params ['paytype'] = $this->input->post ( 'paytype' );

		//增加获取券参数
		$params ['startdate'] = $start;
		$params ['enddate'] = $end;
		$params ['extra_para'] = $this->input->post ( 'extra_para' );
		$params ['extra_para'] = empty($params ['extra_para'])?array():json_decode($params ['extra_para'],TRUE);

		$params ['level'] = $this->member_lv;
		$data_arr = json_decode ( $this->input->post ( 'datas' ), TRUE );
		$price_codes = json_decode ( $this->input->post ( 'price_code' ), TRUE );
		if(!empty($data_arr)){
			foreach ( $data_arr as $key => $value ) {
				if ($value == 0) {
					unset ( $data_arr [$key] );
				}
			}
			$params ['rooms'] = array_sum ( $data_arr );
			$params ['product_num'] = array_sum ( $data_arr );
			$params ['product'] = array_keys ( $data_arr );
			reset ( $data_arr );
			$params ['category'] = key ( $data_arr );
		}
		if(!empty($price_codes)){
			$params ['price_code'] = current ( $price_codes );
		}
		$cards = $this->Coupon_model->get_usable_coupon ( $this->inter_id, $this->openid, $params, TRUE );
		$cards['selected'] = [];
		if(!empty($cards['cards'])){ //有优惠券
			$cards_list = json_decode(json_encode($cards['cards']),true);
			uasort($cards_list, function ($a, $b){
				return $a['reduce_cost'] - $b['reduce_cost'] > 0 ? -1 : 1;
			});
			$select_amount = 0;
			$i = 0;
			foreach($cards_list as $v){
				//循环卡券
				if($params['amount'] > $select_amount + $v['reduce_cost']){
					//当前已默认选择卡券
					$cards['selected'][] = $v;
					$select_amount += $v['reduce_cost'];
					$i++;
				}
				if($i >= $cards['count']['num']){
					break;
				}
			}
		}
		echo json_encode ( $cards );
	}

	//@Editor lGh 返回积分配置
	function return_point_set() {
		$params = array ();
		$start = $this->input->post ( 'start' );
		$end = $this->input->post ( 'end' );
		$params ['total_price'] = $this->input->post ( 'total_price' );
		$params ['hotel_id'] = $this->input->post ( 'h' );
		$params ['paytype'] = $this->input->post ( 'paytype' );
		$params ['openid'] = $this->openid;

		$params ['startdate'] = $start;
		$params ['enddate'] = $end;
		$params ['member_level'] = $this->member_lv;
		$params ['bonus'] = isset($this->common_data ['member']->bonus)?$this->common_data ['member']->bonus:0;
		$data_arr = json_decode ( $this->input->post ( 'datas' ), TRUE );
		$price_codes = json_decode ( $this->input->post ( 'price_code' ), TRUE );
		if(!empty($data_arr)){
			foreach ( $data_arr as $key => $value ) {
				if ($value == 0) {
					unset ( $data_arr [$key] );
				}
			}
			$params ['roomnums'] = array_sum ( $data_arr );
			reset ( $data_arr );
			$params ['room_id'] = key ( $data_arr );
		}
		if(!empty($price_codes)){
			$params ['price_code'] = current ( $price_codes );
		}
		$params['point_name']=$this->input->post ( 'point_name');
		$params['check_point_name']=1;
		$this->load->model ( 'hotel/Member_model' );
		$point_consum_set = $this->Member_model->get_point_consum_rate ( $this->inter_id, $this->member_lv,'room',array(),$params );
		ob_clean();
		echo json_encode($point_consum_set);
	}
	//@Editor lGh 返回积分配置
	function return_pointpay_set() {
		$params = array ();
		$start = $this->input->post ( 'start' );
		$end = $this->input->post ( 'end' );
		$params ['total_price'] = $this->input->post ( 'total_price' );
		$params ['hotel_id'] = $this->input->post ( 'h' );
		$params ['openid'] = $this->openid;

		$params ['startdate'] = $start;
		$params ['enddate'] = $end;
		$params ['member_level'] = $this->member_lv;
		$params ['bonus'] = isset($this->common_data ['member']->bonus)?$this->common_data ['member']->bonus:0;
		$data_arr = json_decode ( $this->input->post ( 'datas' ), TRUE );
		$price_codes = json_decode ( $this->input->post ( 'price_code' ), TRUE );
		if(!empty($data_arr)){
			foreach ( $data_arr as $key => $value ) {
				if ($value == 0) {
					unset ( $data_arr [$key] );
				}
			}
			$params ['roomnums'] = array_sum ( $data_arr );
			reset ( $data_arr );
			$params ['room_id'] = key ( $data_arr );
		}
		if(!empty($price_codes)){
			$params ['price_code'] = current ( $price_codes );
		}
		
		$params['point_name']=$this->input->post ( 'point_name');
		$params['check_point_name']=1;

		$this->load->model('hotel/Member_model');
		$point_consum_set = $this->Member_model->point_pay_check($this->inter_id, $params);
		ob_clean();
		echo json_encode($point_consum_set);
	}
	function cancel_main_order() {
		$this->load->model ( 'hotel/Order_model' );
		$orderid = $this->input->get ( 'oid' );
		$info = $this->Order_model->cancel_order ( $this->inter_id, array (
			'openid' => $this->openid,
			'member_no' => $this->member_no,
			'orderid' => $orderid,
			'idetail' => array (
				'i'
			)
		) );
//$this->db->insert('weixin_text',array('content'=>'cancel_main_order+'.json_encode($info),'edit_date'=>date('Y-m-d H:i:s')));
		echo json_encode ( $info );
	}
	function comment_sub() {
		$data ['hotel_id'] = intval ( $this->input->post ( 'hotel_id' ) );
		$data ['orderid'] = $this->input->post ( 'orderid' );
		$data ['openid'] = $this->openid;
		$data ['inter_id'] = $this->inter_id;
		$data ['content'] = htmlspecialchars ( $this->input->post ( 'content' ) );
		$data ['score'] = intval ( $this->input->post ( 'score' ) );
		$data ['order_info'] ['hotel_name'] = $this->input->post ( 'hotel_name' );
		$data ['order_info'] ['room_name'] = $this->input->post ( 'room_name' );
		$this->load->model ( 'hotel/Comment_model' );
		echo json_encode($this->Comment_model->add_comment ( $data ));
	}
	function return_room_detail() {
		$this->load->model ( 'hotel/Hotel_model' );
		$hotel_id = intval ( $this->input->post ( 'h' ) );
		$room_id = intval ( $this->input->post ( 'r' ) );
		$detail = $this->Hotel_model->get_room_detail ( $this->inter_id, $hotel_id, $room_id, array (
			'img_type' => array (
				'hotel_room_service',
				'hotel_room_lightbox'
			)
		), 1 );
		$room = array ();
		$room ['name'] = $detail ['name'];
		$room ['room_img'] = $detail ['room_img'];
		$room ['imgs'] = empty ( $detail ['imgs'] ) ? array () : $detail ['imgs'];
		$detail ['book_policy'] = $detail ['book_policy'];
		if (empty ( $detail ['book_policy'] )) {
			$hotel = $this->Hotel_model->get_hotel_detail ( $this->inter_id, $hotel_id );
			$detail ['book_policy'] = $hotel ['book_policy'];
		}
		$room ['book_policy'] = nl2br ( $detail ['book_policy'] );
		echo json_encode ( $room );
	}

	private function preSpDate($hotel_id=0,$config_data=array()){
		$start_val = 0;
		if (!$config_data){
    		$this->load->model('hotel/Hotel_config_model');
    		$config_data = $this->Hotel_config_model->get_hotel_config ( $this->inter_id, 'HOTEL', $hotel_id, array (
    			'BOOK_DATE_VALIDATE',
    		) );
		}
		if (! empty ( $config_data ['BOOK_DATE_VALIDATE'] )) {
			$condition=json_decode($config_data['BOOK_DATE_VALIDATE'],true);
			if(!empty($condition['startdate'])){
				foreach($condition['startdate'] as $v){
					$hour = $v['hour'];
					switch($v['compare']){
						case 'less': //当前时间少于值
							if(date('H') < $hour){
								$start_val = $v['val'];
							}
							break;
						case 'more':
							if(date('H') > $hour){
								$start_val = $v['val'];
							}
							break;
					}
					//循环，出现多次条件匹配，以最后为准
				}
			}
		}
		return (int)$start_val;
	}

	function new_comment_sub() {    //提交评论
        $this->load->model ( 'hotel/Comment_model' );
        $this->load->model ( 'hotel/Member_model' );
		$data ['images'] = $this->input->post ( 'images' );
		if(!empty($data ['images'])){
			$data ['images'] = implode(',',$data ['images']);
		}
		$data ['hotel_id'] = intval ( $this->input->post ( 'hotel_id' ) );
		$data ['orderid'] = $this->input->post ( 'orderid' );
		$data ['openid'] = $this->openid;
		$data ['inter_id'] = $this->inter_id;
		$data ['content'] = htmlspecialchars ( $this->input->post ( 'content' ) );
		$data ['service_score'] = intval ( $this->input->post ( 'service_score' ) );
		$data ['net_score'] = intval ( $this->input->post ( 'net_score' ) );
		$data ['facilities_score'] = intval ( $this->input->post ( 'facilities_score' ) );
		$data ['clean_score'] = intval ( $this->input->post ( 'clean_score' ) );
		$data ['score'] = number_format(($data ['service_score'] + $data ['net_score'] + $data ['facilities_score'] + $data ['clean_score']) / 4,2);
		$data ['order_info'] ['hotel_name'] = $this->input->post ( 'hotel_name' );
		$data ['order_info'] ['room_name'] = $this->input->post ( 'room_name' );
        $data['order_info']['sign']='';
		$mediaid = $this->input->post ( 'img_url' );
        $sign = $this->input->post ( 'sign' );
        if(!empty($sign)){
            $data['order_info']['sign'] = implode(',',$sign);
        }

        if($mediaid){
            $images_url = '';
            $this->load->model('wx/access_token_model');
            $access_token= $this->access_token_model->get_access_token( $this->inter_id );

            foreach($mediaid as $arr){
                $url = $this->ftp_images($access_token,$arr);
                $images_url.=','.$url;
            }
            $data['images'] = substr($images_url,1);
        }

        $res = $this->Comment_model->add_comment($data);

        if($res && isset($res['comment_id'])){       //评论成功执行送积分
            $comment_info = $this->Comment_model->get_comment_by_id($this->inter_id,$res['comment_id']);
            if(!empty($comment_info) && $comment_info['point_give']==0){
                $this->Comment_model->comment_give_bonus($this->inter_id,$comment_info);
            }
        }

        if($res && isset($res['status']) && $res['status']==1){   //更新评论统计信息
            $this->Comment_model->update_hotel_score_from_redis($this->inter_id,$data ['hotel_id'],$data,'add',$this->openid);
            $keywords = $this->Comment_model->get_keyword($this->inter_id);
            if($keywords){   //更新关键词统计
                foreach($keywords as $key=>$arr){
                    $count = $this->Comment_model->match_keyword($arr['keyword'],array($data));
                    if($count){
                        $keyword_count = json_decode($arr['count']);
                        if(!$keyword_count){
                            $count = json_encode($count);
                        }else{
                            if(isset($keyword_count->{$data['hotel_id']})){
                                $keyword_count->{$data['hotel_id']} = $keyword_count->{$data['hotel_id']} + 1;
                            }else{
                                $keyword_count->{$data['hotel_id']} = 1;
                            }
                            $count = json_encode($keyword_count);
                        }

                        $this->Comment_model->update_keyword_count($arr['keyword_id'],$count);
                    }
                }
            }
        }

		echo json_encode($res);
	}


    function comment_no_order(){

        $data = $this->common_data;
        $openid = $this->openid;
//$openid = 'oz1AKv5xDYeeTBfwImfWZHP8QfyU';
        $hotel_id = $this->input->get('h');

        $this->load->model ( 'hotel/Hotel_config_model' );
        $config_data = $this->Hotel_config_model->get_hotel_config ( $this->inter_id, 'HOTEL', 0, array (
            'COMMENT_NO_ORDER'
        ) );

        if(empty($hotel_id) || empty($openid)){

            redirect ( Hotel_base::inst()->get_url('SEARCH'));


        }else{

            if (! empty ( $config_data ['COMMENT_NO_ORDER']) && $config_data ['COMMENT_NO_ORDER']==1) {

                $this->load->model ( 'hotel/Comment_model' );
                $data['comment'] = 1;
                $check = $this->Comment_model->check_no_order_comment($this->inter_id,$openid,$hotel_id);

                if($check){
                    $data['comment'] = 0;
                }

                $data ['pagetitle'] = '酒店点评';
                $this->load->model ( 'hotel/Hotel_model' );
                $data['order']['hotel_id'] = $hotel_id;
                $this->display ( 'hotel/hotel/to_comment', $data );


            }else{

                redirect ( Hotel_base::inst()->get_url('SEARCH'));

            }

        }

    }


    public function ftp_images($access_token,$url){
        try {
            $data = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$url;
            $file_name = date('YmdHis').rand(1000,9999).'.jpg';
//                file_put_contents('./'.$file_name,base64_decode($data));
            $this->curl_file_get_contents($data,$file_name);

            $this->ftp= $this->_ftp_server('prod');
            $base_path= 'media/club/';

            $to_file = $this->ftp->floder. FD_PUBLIC. '/'. $base_path;

            if(empty($to_file)){
                $this->ftp->mkdir($this->ftp->floder. FD_PUBLIC. '/'. $base_path,0777);
            }

            $up_path = realpath('./').'/'.$file_name;

            $this->ftp->upload($up_path, $to_file.$file_name, 'binary', 0775);
            $this->ftp->close();

            $upload_url= $this->ftp->weburl. '/'. FD_PUBLIC. '/media/club/'.$file_name;

//                保存上传完之后的URL
            return $upload_url;

        }catch (Exception $e){
            echo 'error';
        }

    }


    function curl_file_get_contents($durl,$targetName){
        $ch = curl_init($durl); // 初始化
        $fp = fopen($targetName, 'wb'); // 打开写入
        curl_setopt($ch, CURLOPT_FILE, $fp); // 设置输出文件的位置，值是一个资源类型
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return $targetName;
    }

    //专题页面
    function thematic_index(){
		$data = $this->common_data;
		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->model ( 'hotel/Hotel_thematic_model' );
		$tc_id = intval($this->input->get ( 'tc_id', TRUE ));
		$data ['hot_city'] = array();
		$data ['first_city'] = '全部';
		$data['list'] = $this->Hotel_thematic_model->get_list(array('inter_id'=>$this->inter_id,'nowtime'=>date('Y-m-d H:i:s')));
		if(!empty($tc_id)){
			$data['row'] = $this->Hotel_thematic_model->get_row($this->inter_id,$tc_id);
		}elseif(!empty($data['list'])){
			$data['row'] = $data['list'][0];
		}
		$data['tips']= '没有搜索到相关结果~';
		$data['hidden']= 0;
		
		$pre_sp_date=0;
		$minSelect = 1;

		//没有活动处理
		if(empty($data['row'])){
			$data['tips']= '活动不存在~';
			$row = array();
			$data['row']['id'] = 0;
			$data['row']['act_intro'] = '';
			$data['row']['act_name'] = '';
			$data['hidden']= 1;
		}else{
			//活动过期处理
			if($data['row']['status'] !=1){
				$data['tips']= '活动已失效~';
				$data['hidden']= 1;
			}
			if(strtotime($data['row']['start_time'])>time()){
				$data['tips']= '活动未开始~';
				$data['hidden']= 1;
			}
			if(strtotime($data['row']['end_time'])<time()){
				$data['tips']= '活动已过期~';
				$data['hidden']= 1;
			}

			$tc_hotelids = json_decode($data['row']['hotelids'],TRUE);

			if(!empty($tc_hotelids)){
				$hotel_ids = implode(',',$tc_hotelids);
				//获取推荐城市
				$cities = $this->Hotel_model->get_hotel_citys_by_hid ( $this->inter_id ,array('hotel_id'=>$hotel_ids));
				$data ['hot_city'] = $cities;
				if(isset($cities[0])){
					$data ['first_city'] = $cities[0]['city'];
				}
			}
			//提前预定
			$pre_sp_date += $data['row']['pre_days'];
			$startime=time()+($pre_sp_date*86400);
			$data ['startdate'] = date ( 'Y/m/d',$startime);
			//连住优惠
			$minSelect = $data['row']['min_days']>0?$data['row']['min_days']:1;
			$data ['enddate'] = date ( 'Y/m/d', strtotime ( '+ '.$minSelect.' day', $startime ) );

			$data['pre_sp_date']=$pre_sp_date;
			$data['minSelect']=$minSelect;
		}

		$this->display ( 'hotel/thematic_index/thematic_index', $data);
    }

    public function check_self_continue() {
        $orderid = $this->input->post ( 'orderid' );
        $item_id = intval ( $this->input->post ( 'item_id' ) );
        $this->load->model ( 'hotel/Order_check_model' );
        $result = $this->Order_check_model->check_self_continue ( $this->inter_id, $orderid, $this->openid, $item_id, array (
                'member_level' => $this->member_lv 
        ) );
        $info = array (
                's' => $result ['s'],
                'errmsg' => $result ['errmsg'] 
        );
        isset ( $result ['pay_link'] ) and $info ['pay_link'] = $result ['pay_link'];
        echo json_encode ( $info );
    }


    function select_coupon($params) {

        $this->load->model ( 'hotel/Coupon_model' );
        $params ['days']  = get_room_night($params['startdate'],$params['enddate'],'round');//至少有1个间夜

        $cards = $this->Coupon_model->get_usable_coupon ( $this->inter_id, $this->openid, $params, TRUE );
        $cards['selected'] = [];
        if(!empty($cards['cards'])){ //有优惠券
            $cards_list = json_decode(json_encode($cards['cards']),true);
            uasort($cards_list, function ($a, $b){
                return $a['reduce_cost'] - $b['reduce_cost'] > 0 ? -1 : 1;
            });
            $select_amount = 0;
            $i = 0;
            foreach($cards_list as $v){
                //循环卡券
                if($params['amount'] > $select_amount + $v['reduce_cost']){
                    //当前已默认选择卡券
                    $cards['selected'][] = $v;
                    $select_amount += $v['reduce_cost'];
                    $i++;
                }
                if($i >= $cards['count']['num']){
                    break;
                }
            }
            $cards['select_coupon_favour']=$select_amount;
        }

        return $cards;
    }

}