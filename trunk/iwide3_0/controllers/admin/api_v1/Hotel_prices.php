<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Hotel_prices extends MY_Admin {
	protected $label_module = NAV_HOTEL;
	protected $label_controller = '价格配置';
	protected $label_action = '';
	function __construct() {
		parent::__construct ();
		$this->inter_id = $this->session->get_admin_inter_id ();
		$this->module = 'hotel';
		$this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
		$this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
		// $this->output->enable_profiler ( true );
	}
	protected function main_model_name() {
		return 'hotel/Price_code_model';
	}
	public function room_state() {
		$this->load->model ( 'hotel/Hotel_model' );
		$this->load->model ( 'hotel/Order_model' );
		$data ['startdate'] = $this->input->get_post ( 'begin' );
		$data ['price_code'] = $this->input->get_post ( 'price_code' );
		$data ['enddate'] = $this->input->get_post ( 'end' );
		$data ['room_id'] = $this->input->get_post ( 'room_id' );
		$data ['hotel_id'] = $this->input->get_post ( 'hotel' );

		$entity_id = $this->session->get_admin_hotels ();
		if (! empty ( $entity_id )) {
			$hotel_ids = explode ( ',', $entity_id );
			if (! empty ( $data ['hotel_id'] ) && ! in_array ( $data ['hotel_id'], $hotel_ids )) {
				$data ['hotel_id'] = 0;
			}
			$data ['hotels'] = $this->Hotel_model->get_hotel_by_ids ( $this->inter_id, $entity_id );
		} else
			$data ['hotels'] = $this->Hotel_model->get_all_hotels ( $this->inter_id,1 );

		$model = $this->_load_model ( $this->main_model_name () );
		if (! empty ( $data ['hotel_id'] ) && ! empty ( $data ['room_id'] ) && ! empty ( $data ['price_code'] )) {
			$list = $model->get_room_price_set ( $this->inter_id, $data ['hotel_id'], $data ['room_id'], $data ['price_code'] );
			if (! empty ( $list )) {
				$list = $list [0];
				$list ['use_condition'] = empty ( $list ['suse_condition'] ) ? json_decode ( $list ['use_condition'], TRUE ) : json_decode ( $list ['suse_condition'], TRUE );
				$date_check = $this->Order_model->date_validate ( $data ['startdate'], $data ['enddate'] );
				$data ['startdate'] = $date_check [0];
				$data ['enddate'] = $date_check [1];
				$data ['room'] = $this->Hotel_model->get_rooms_detail ( $this->inter_id, $data ['hotel_id'], array (
						$data ['room_id']
				), array () );
				$condit = array (
						'startdate' => $data ['startdate'],
						'enddate' => $data ['enddate'],
						'price_type' => array (
								'protrol'
						),
						'price_codes' => $data ['price_code']
				);
				$this->load->model ( 'hotel/Member_model' );
				$member_privilege = $this->Member_model->level_privilege ( $this->inter_id );
				if (! empty ( $member_privilege )) {
					$condit ['member_privilege'] = $member_privilege;
				}
				// if (isset ( $list ['use_condition'] ['member_level'] ) && $list ['type'] == 'member') {
				if (isset ( $list ['use_condition'] ['member_level'] )) {
					$condit ['member_level'] = $list ['use_condition'] ['member_level'];
				}else {
					$levels = $this->Member_model->get_member_levels ( $this->inter_id );
					if (! empty ( $levels )) {
						$condit ['member_level'] = current ( array_keys ( $levels ) );
					}
				}
				$states = $this->Order_model->get_rooms_change ( $data ['room'], array (
						'inter_id' => $this->inter_id,
						'hotel_id' => $data ['hotel_id'],
						'query_site' => 'admin'
				), $condit, TRUE );
				$room_state = empty ( current ( $states ) ) ? array () : current ( $states );
				$date_arr = empty ( $room_state ['state_info'] [$data ['price_code']] ['date_detail'] ) ? array () : $room_state ['state_info'] [$data ['price_code']] ['date_detail'];
				$data ['calendar'] = $this->generate_calendar ( $data ['startdate'], $data ['enddate'], $date_arr );
			}
		} else {
			$data ['hotel_id'] = empty ( $data ['hotels'] [0] ) ? 0 : $data ['hotels'] [0] ['hotel_id'];
		}
		$data ['room_list'] = $this->Hotel_model->get_hotel_rooms ( $this->inter_id, $data ['hotel_id'] );
		if (empty ( $data ['room_id'] ) && ! empty ( $data ['room_list'] ))
			$data ['room_id'] = $data ['room_list'] [0] ['room_id'];
		if (! empty ( $data ['room_list'] ))
			$data ['price_codes'] = $model->get_room_price_code ( $this->inter_id, $data ['hotel_id'], $data ['room_id'] );

		$this->_render_content ( $this->_load_view_file ( 'room_state' ), $data, false );
	}
	private function generate_calendar($begin_date, $end_date, $hdaysets = null) {
		$begin_date = strtotime ( $begin_date );
		$end_date = strtotime ( $end_date );
		$table = '';
		$current_date = $begin_date;
		$day_of_week = '';
		$week = array (
				'sunday',
				'monday',
				'tuesday',
				'wednesday',
				'thursday',
				'friday',
				'saturday'
		);

		$week_title = '<tr><td>星期一</td>';
		$week_title .= '<td>星期二</td>';
		$week_title .= '<td>星期三</td>';
		$week_title .= '<td>星期四</td>';
		$week_title .= '<td>星期五</td>';
		$week_title .= '<td style=\'color:red\'>星期六</td>';
		$week_title .= '<td style=\'color:red\'>星期日</td></tr><tr>';

		$table = "<table class=\"table table-striped\">";
		$day_of_week = date ( 'w', $begin_date ); // day of week
		$day = date ( 'j', $begin_date ); // day of month
		$month_count = (date ( "Y", $end_date ) - date ( "Y", $begin_date )) * 12 + (date ( "m", $end_date ) - date ( "m", $begin_date )); // 月份差
		$table .= '<tr>';

		$datediff = date_diff ( new DateTime ( date ( 'Y-m-d', $begin_date ) ), new DateTime ( date ( 'Y-m-d', $end_date ) ) );
		$monthspan = $datediff->format ( '%m' ) + 1;
		$datespan = $datediff->format ( '%a' );
		$count = 1;
		$source_icon = array (
				'date' => '<i class="fa fa-fw fa-calendar"></i>',
				'room' => '<i class="fa fa-fw fa-hotel"></i>',
				'code' => '<i class="fa fa-fw fa-file-powerpoint-o"></i>',
				'related' => '<i class="fa fa-fw fa-connectdevelop"></i>',
				'quick_close' => '<i class="fa fa-fw fa-close"></i>'
		);
		for($i = 1; $i <= $monthspan; $i ++) {
			$table .= "<tr align='center'><td colspan='7' style='text-align:center'>" . date ( 'Y年m月', $current_date ) . "</td></tr>";
			$table .= $week_title;
			$blank_num = $day_of_week;
			if ($day_of_week == 0)
				$blank_num = 7;
			for($ii = 1; $ii < $blank_num; $ii ++) { // 之前的空白日期
				$table .= '<td>&nbsp;</td>';
			}
			$last_day_of_month = date ( 't', $current_date );
			$week_index = $day_of_week;
			for(; $day <= $last_day_of_month && $count <= $datespan; $day ++) {
				$daystr = $day >= 10 ? $day : '0' . $day;
				$date_str = date ( 'Ym', $current_date ) . $daystr;
				$cur_str = '';
				$num_str = '-';
				if (isset ( $hdaysets [$date_str] ['nums'] ))
					$num_str = $hdaysets [$date_str] ['nums'];
				if (isset ( $hdaysets [$date_str] ))
					$cur_str = '(<span>' . $hdaysets [$date_str] ['price'] . $source_icon [$hdaysets [$date_str] ['price_source']] . '/' . $num_str . $source_icon [$hdaysets [$date_str] ['num_source']] . '</span>)';
				else
					$cur_str = '(<span>不可用</span>)';
				if ($day_of_week % 7 == 0) { // 星期换行
					$week_index = 0;
					$table .= '<td>' . $day . $cur_str . '</td></tr><tr>';
				} else {
					$table .= '<td>' . $day . $cur_str . '</td>';
				}
				$day_of_week ++;
				$count ++;
				$week_index ++;
			}
			$day = 1;
			$current_date = strtotime ( '+1 month', $current_date );
			$day_of_week = date ( 'w', strtotime ( date ( 'Y-m', $current_date ) . '-01' ) );
		}
		return $table .= '</tr></table>';
	}
	public function index() {
		$data = $this->common_data;
		$model = $this->_load_model ( $this->main_model_name () );
		$data ['hotel_id'] = intval($this->input->get_post ( 'hotel' ));
		$data ['room_id'] = intval($this->input->get_post ( 'r' ));
		// add yu 2016-11-15
		$data ['type'] = $this->input->get_post ( 't' )?$this->input->get_post ( 't' ):'common';
		$this->load->model ( 'common/Enum_model' );
		$data ['enum_des'] = $this->Enum_model->get_enum_des ( array (
				'HOTEL_PRICE_CODE_RELATED_CAL_WAY',
				'HOTEL_PRICE_CODE_TYPE',
				'HOTEL_PRICE_CODE_STATUS'
		) );
		// end
		$this->load->model ( 'hotel/hotel_model' );
		// $data ['hotels'] = $this->hotel_model->get_all_hotels ( $this->inter_id );

		$entity_id = $this->session->get_admin_hotels ();
		if (! empty ( $entity_id )) {
			$hotel_ids = explode ( ',', $entity_id );
			if (! empty ( $data ['hotel_id'] ) && ! in_array ( $data ['hotel_id'], $hotel_ids )) {
				$data ['hotel_id'] = 0;
			}
			$data ['hotels'] = $this->hotel_model->get_hotel_by_ids ( $this->inter_id, $entity_id );
		} else
			$data ['hotels'] = $this->hotel_model->get_all_hotels ( $this->inter_id,1 );

		$data ['fields_config'] = $model->grid_fields ();
		if (! empty ( $data ['hotel_id'] )) {
			$list = $model->get_room_price_set ( $this->inter_id, $data ['hotel_id'], $data ['room_id'], null, true,$data['type']);
			$this->load->model ( 'common/Enum_model' );
			$status_des = $this->Enum_model->get_enum_des ( array (
					'HOTEL_PRICE_SET_STATUS',
					'HOTEL_PRICE_CODE_RELATED_CAL_WAY'
			) );
			foreach ( $list as $k => $d ) {
				if (isset ( $d ['set_status'] ))
					$list [$k] ['code_status'] = $status_des ['HOTEL_PRICE_SET_STATUS'] [$d ['set_status']];
				else
					$list [$k] ['code_status'] = '未设置';
				if (! empty ( $d ['related_code'] ))
					$list [$k] ['related_name'] = $d ['related_name'] . '(' . (isset($status_des ['HOTEL_PRICE_CODE_RELATED_CAL_WAY'] [$d ['related_cal_way']])?$status_des ['HOTEL_PRICE_CODE_RELATED_CAL_WAY'] [$d ['related_cal_way']]:'') . $list [$k] ['related_cal_value'] . ')';
				$bp_condition = json_decode($d['sbookpolicy_condition'],true);
				$list[$k]['bfnums'] = $bp_condition['breakfast_nums'];
			}
			$data ['list'] = $list;
		} else {
			$data ['hotel_id'] = empty ( $data ['hotels'] [0] ) ? 0 : $data ['hotels'] [0] ['hotel_id'];
		}
		$this->_render_content ( $this->_load_view_file ( 'index' ), $data, false );
	}
	public function room_types() {
		$hotel_id = $this->input->get ( 'hid' );
		$this->load->model ( 'hotel/Hotel_model' );
		echo json_encode ( $this->Hotel_model->get_hotel_rooms ( $this->inter_id, $hotel_id, 1 , null, null) );
	}
	public function room_price_set() {
		$hotel_id = $this->input->get ( 'hid' );
		$room_id = $this->input->get ( 'rid' );
		$model = $this->_load_model ( $this->main_model_name () );
		echo json_encode ( $model->get_room_price_code ( $this->inter_id, $hotel_id, $room_id ) );
	}
	public function edit() {
		$data = $this->common_data;
		$this->label_action = '价格代码设置';
		$this->_init_breadcrumb ( $this->label_action );
		$this->load->model ( 'hotel/Hotel_model' );
		$model_name = $this->main_model_name ();
		$model = $this->_load_model ( $model_name );

		$data ['hotel_id'] = intval ( $this->input->get ( 'h' ) );

		$entity_id = $this->session->get_admin_hotels ();
		if (! empty ( $entity_id )) {
			$hotel_ids = explode ( ',', $entity_id );
			if (! in_array ( $data ['hotel_id'], $hotel_ids )) {
				redirect ( site_url ( 'privilege/auth/deny' ) );
				exit ();
			}
		}

		$data ['room_id'] = intval ( $this->input->get ( 'r' ) );
		$data ['price_code'] = intval ( $this->input->get ( 'code' ) );
		$list = $model->get_room_price_set ( $this->inter_id, $data ['hotel_id'], $data ['room_id'], $data ['price_code'] );
		if (! empty ( $list )) {
			$data ['list'] = $list [0];
			$data ['list'] ['use_condition'] = json_decode ( $data ['list'] ['use_condition'], TRUE );
			$data ['list'] ['suse_condition'] = json_decode ( $data ['list'] ['suse_condition'], TRUE );
			$data ['list'] ['scoupon_condition'] = json_decode ( $data ['list'] ['scoupon_condition'], TRUE );
			$data ['list'] ['sbonus_condition'] = json_decode ( $data ['list'] ['sbonus_condition'], TRUE );
			$data ['list'] ['sbookpolicy_condition'] = json_decode ( $data ['list'] ['sbookpolicy_condition'], TRUE );
			//获取早餐配置
			$this->load->model ( 'hotel/Price_code_model' );
			$bf_fields = $this->Price_code_model->grid_fields();
			$data ['bf_fields'] = $bf_fields['bfnums']['select'];

			$data ['model'] = $model;
			if (empty ( $list ['price_code'] )) {
				$data ['price_codes'] = $model->get_price_codes ( $this->inter_id );
			}
			$this->load->model ( 'pay/Pay_model' );
			$data ['pay_ways'] = $this->Pay_model->get_pay_way ( array (
					'inter_id' => $this->inter_id,
					'module' => $this->module,
					'status' => 1,
					'key' => 'value',
					'not_show'=>1
			) );
			$this->load->model ( 'common/Enum_model' );
			$data ['enum_des'] = $this->Enum_model->get_enum_des ( array (
					'HOTEL_PRICE_CODE_RELATED_CAL_WAY',
					'HOTEL_PRICE_CODE_TYPE'
			) );
			//判断是否使用pms
			$this->load->model('common/Pms_model');
			$pms_set=$this->Pms_model->get_hotel_pms_set($this->inter_id,0);
			$data['is_pms']=0;
			if (!empty($pms_set)){
				$data['is_pms']=1;
			}
			//与券关联
			$this->load->model('hotel/Coupons_model');
			$coupon_types=$this->Coupons_model->get_hotel_coupons ( $this->inter_id ,'exchange');
			$data['coupon_types']=$coupon_types['coupon_types'];
			$this->_render_content ( $this->_load_view_file ( 'edit' ), $data, FALSE );
		} else {
			redirect ( site_url ( 'hotel/prices/index' ) );
		}
	}
	public function edit_post() {
		$data ['inter_id'] = $this->inter_id;
		$data ['hotel_id'] = intval ( $this->input->post ( 'hotel_id' ) );

		$entity_id = $this->session->get_admin_hotels ();
		if (! empty ( $entity_id )) {
			$hotel_ids = explode ( ',', $entity_id );
			if (! in_array ( $data ['hotel_id'], $hotel_ids )) {
				echo '无权限';
				exit ();
			}
		}

		$data ['room_id'] = intval ( $this->input->post ( 'room_id' ) );
		$data ['price_code'] = empty ( intval ( $this->input->post ( 'price_code_sele' ) ) ) ? intval ( $this->input->post ( 'price_code' ) ) : intval ( $this->input->post ( 'price_code_sele' ) );
		$data ['nums'] = $this->input->post ( 'nums' ) == '' ? null : intval ( $this->input->post ( 'nums' ) );
		$data ['must_date'] = intval ( $this->input->post ( 'must_date' ) );
		$data ['status'] = intval ( $this->input->post ( 'status' ) );
		$data ['price'] = floatval ( $this->input->post ( 'price' ) );

		//预订政策
		$condition_bp = intval ( $this->input->post ( 'condition_bp' ) );
		if($condition_bp==0){
			$data['bookpolicy_condition'] = '';
		}elseif($condition_bp==1){
			$data['bookpolicy_condition']['breakfast_nums'] = $this->input->post ( 'breakfast_nums' );//早餐
			$data['bookpolicy_condition']['retain_time'] = $this->input->post('retain_time');//预订保留时间
			$data['bookpolicy_condition']['delay_time'] = $this->input->post('delay_time');//退房延迟时间
			$data['bookpolicy_condition'] = json_encode($data['bookpolicy_condition']);
		}

		$data ['related_cal_way'] = htmlspecialchars ( $this->input->post ( 'related_cal_way' ) );
		if (! empty ( $data ['related_cal_way'] )) {
			$data ['related_cal_value'] = floatval ( $this->input->post ( 'related_cal_value' ) );
		}
		$condition_way = intval ( $this->input->post ( 'condition_way' ) );
		if ($condition_way == 0)
			$data ['use_condition'] = '';
		else if ($condition_way == 1) {
			$pre_pay=$this->input->post ( 'pre_pay' );
			$data ['use_condition'] ['pre_pay'] = intval ( $pre_pay );
			$no_pay_way = $this->input->post ( 'no_pay_way' );
			if (! empty ( $no_pay_way )) {
				foreach ( $no_pay_way as $npw ) {
					$data ['use_condition'] ['no_pay_way'] [] = $npw;
				}
			}
			
			$imember_level=$this->input->post ( 'imember_level' );
			if(isset($imember_level)){
				$data ['use_condition'] ['member_level']=$imember_level;
			}
			$pre_day = $this->input->post ( 'pre_day' );
			if ($pre_day != '' && is_numeric ( $pre_day ))
				$data ['use_condition'] ['pre_d'] = intval ( $pre_day );
			
			//@Editor lGh 2016-5-31 20:53:08 增加开始与结束日期配置
			$date_limit=array();
			$date_limit['s_date_s'] = intval($this->input->post ( 's_date_s' ));
			$date_limit['s_date_e'] = intval($this->input->post ( 's_date_e' ));
			$date_limit['e_date_s'] = intval($this->input->post ( 'e_date_s' ));
			$date_limit['e_date_e'] = intval($this->input->post ( 'e_date_e' ));
			foreach ($date_limit as $k=>$l){
				if (!empty($l)&&strtotime($l)){
					$data ['use_condition'] [$k] = $l;
				}
			}
			
			//@Editor lGh 2016-7-6 15:10:51 数量与天数限制
			$max_num=intval($this->input->post ( 'max_num' ));
			$max_day=intval($this->input->post ( 'max_day' ));
            $min_day=intval($this->input->post ( 'min_day' ));
			if ($max_num>0)
				$data ['use_condition']['mxn']=$max_num;
			if ($max_day>0)
				$data ['use_condition']['mxd']=$max_day;
            if ($min_day>0)
                $data ['use_condition']['min_day']=$min_day;
			
			$data ['use_condition'] = json_encode ( $data ['use_condition'] );
		}
		
		//@Editor lGh 2016-6-15 15:58:48 增加优惠券配置
		$coupon_way = intval ( $this->input->post ( 'coupon_way' ) );
		if ($coupon_way == 0)
			$data ['coupon_condition'] = '';
		else if ($coupon_way == 1) {
			$data['coupon_condition']=array();
			$coupon_num_type=$this->input->post('coupon_num_type');
			$coupon_num=$this->input->post('coupon_num');
			if (!empty(intval($coupon_num))){
				$data['coupon_condition']['num_type']=$coupon_num_type=='roomnight'?'roomnight':'order';
				$data['coupon_condition']['coupon_num']=intval($coupon_num);
			}
			$no_coupon=$this->input->post ( 'no_coupon' );
			$data ['coupon_condition'] ['no_coupon'] = intval ( $no_coupon );
			
			//@Editor lGh 2016-7-6 15:13:30 券关联
			$related_coupon=intval($this->input->post('related_coupon'));
			if (!empty($related_coupon))
				$data ['coupon_condition'] ['couprel'] = $related_coupon;
			
			//@Editor lGh 2016-10-21 20:26:47 pms券配置
			$coupon_is_pms=intval($this->input->post ( 'coupon_is_pms' ));
			if (!empty($coupon_is_pms))
				$data ['coupon_condition'] ['is_pms'] = 1;
			
			$data ['coupon_condition'] = json_encode ( $data ['coupon_condition'] );
		}
		
		//@Editor lGh 2016-7-29 21:50:43 增加积分配置
		$bonus_way = intval ( $this->input->post ( 'bonus_way' ) );
		if ($bonus_way == 0)
			$data ['bonus_condition'] = '';
		else if ($coupon_way == 1) {
			$data['bonus_condition']=array();
			$no_part_bonus=$this->input->post ( 'no_part_bonus' );
			$poc=$this->input->post ( 'poc' );
			$data ['bonus_condition'] ['no_part_bonus'] = intval ( $no_part_bonus );
			$data ['bonus_condition'] ['poc'] = intval ( $poc );
				
			$data ['bonus_condition'] = json_encode ( $data ['bonus_condition'] );
		}
		
		$model_name = $this->main_model_name ();
		$model = $this->_load_model ( $model_name );
		$model->edit_code_set ( $data );
		$t = $model->get_price_code($this->inter_id,$data ['price_code']);//获取当前价格代码类型
		redirect ( site_url ( 'hotel/prices/index' ) . '?hotel=' . $data ['hotel_id'] . '&r=' . $data ['room_id'].'&t='.$t['type'] );
	}
	public function code_set() {
		$this->label_action = '价格代码管理';
		$this->_init_breadcrumb ( $this->label_action );
		$data = $this->common_data;
		$model_name = $this->main_model_name ();
		$model = $this->_load_model ( $model_name );
		$data ['fields_config'] = $model->code_grid_fields ();
		$list = $model->get_price_codes ( $this->inter_id );
		if (! empty ( $list )) {
			$this->load->model ( 'common/Enum_model' );
			$status_des = $this->Enum_model->get_enum_des ( array (
					'HOTEL_PRICE_CODE_STATUS',
					'HOTEL_PRICE_CODE_TYPE',
					'HOTEL_PRICE_CODE_TYPE',
					'HOTEL_PRICE_CODE_RELATED_CAL_WAY'
			) );
			foreach ( $list as $k => $d ) {
				$list [$k] ['status'] = $status_des ['HOTEL_PRICE_CODE_STATUS'] [$d ['status']];
				$list [$k] ['type'] = $status_des ['HOTEL_PRICE_CODE_TYPE'] [$d ['type']];
				if (! empty ( $d ['related_code'] )) {
					$list [$k] ['related_name'] = $list [$d ['related_code']] ['price_name'];
					if ($d ['type'] != 'member' && !empty($status_des ['HOTEL_PRICE_CODE_RELATED_CAL_WAY'] [$d ['related_cal_way']])) {
						$list [$k] ['related_name'] .= '(' . $status_des ['HOTEL_PRICE_CODE_RELATED_CAL_WAY'] [$d ['related_cal_way']] . $d ['related_cal_value'] . ')';
					}
				} else
					$list [$k] ['related_name'] = '';
			}
			$data ['list'] = $list;
		}
		$this->_render_content ( $this->_load_view_file ( 'price_codes' ), $data, false );
	}
	public function code_edit() {
		$data = $this->common_data;
		$data ['price_code'] = $this->input->get ( 'pcode' );
		$model_name = $this->main_model_name ();
		$model = $this->_load_model ( $model_name );
		$data ['price_codes'] = $model->get_price_codes ( $this->inter_id ,null ,'price_code,price_name');
		$this->load->model ( 'common/Enum_model' );
		$data ['enum_des'] = $this->Enum_model->get_enum_des ( array (
				'HOTEL_PRICE_CODE_RELATED_CAL_WAY',
				'HOTEL_PRICE_CODE_TYPE',
				'HOTEL_PRICE_CODE_STATUS'
		) );
		$this->load->model ( 'pay/Pay_model' );
		$data ['pay_ways'] = $this->Pay_model->get_pay_way ( array (
				'inter_id' => $this->inter_id,
				'module' => $this->module,
				'status' => 1,
				'key' => 'value',
				'not_show'=>1
		) );
		
		// $this->load->model ( 'hotel/Service_model' );
		// $data ['service'] = $this->Service_model->get_service ( $this->inter_id, array (
		// 		'service_type' => 'hotel_order',
		// 		'status' => 1 
		// ) );

		//获取早餐配置
		$this->load->model ( 'hotel/Price_code_model' );
		$bf_fields = $this->Price_code_model->grid_fields();
		$data ['bf_fields'] = $bf_fields['bfnums']['select'];
		
		$this->load->model ( 'hotel/Member_model' );
		$data ['levels'] = $this->Member_model->get_member_levels ( $this->inter_id );
		if (! empty ( $data ['price_code'] )) {
			$list = $model->get_price_code ( $this->inter_id, $data ['price_code'] );
			if (! empty ( $list )) {
				if (! empty ( $list ['related_code'] )) {
					$related = $model->get_price_code ( $this->inter_id, $list ['related_code'] );
					$list ['related_name'] = $related ['price_name'];
				}
				// 预订政策
				$list ['bookpolicy_condition'] = json_decode($list ['bookpolicy_condition'],true);
				$list ['use_condition'] = json_decode ( $list ['use_condition'], TRUE );
				$list ['coupon_condition'] = json_decode ( $list ['coupon_condition'], TRUE );
				$list ['bonus_condition'] = json_decode ( $list ['bonus_condition'], TRUE );
				$list ['add_service_set'] = json_decode ( $list ['add_service_set'], TRUE );
				$list ['time_condition'] = json_decode ( $list ['time_condition'], TRUE );
				$data ['service_keys'] = array ();
				if (! empty ( $list ['add_service_set'] )) {
					$data ['service_keys'] = array_keys ( $list ['add_service_set'] );
				}
				$data ['list'] = $list;
			} else {
				// redirect ( site_url ( 'hotel/prices/code_set' ) );
				die( json_encode(array('status'=>1, 'message'=>'价格代码不存在')) );
			}
		} else {
			$data ['list'] = $model->table_fields ( 'price_info' );
		}
		//判断是否使用pms
		$this->load->model('common/Pms_model');
		$pms_set=$this->Pms_model->get_hotel_pms_set($this->inter_id,0);
		$data['is_pms']=0;
		if (!empty($pms_set)){
			$data['is_pms']=1;
		}
		//与券关联
		$this->load->model('hotel/Coupons_model');
		$coupon_types=$this->Coupons_model->get_hotel_coupons ( $this->inter_id ,'exchange');
		$data['coupon_types']=$coupon_types['coupon_types'];
		echo json_encode($data);
	}
	public function edit_code_post() {
		$price_code = intval ( $this->input->post ( 'price_code' ) );
		$member_level = $this->input->post ( 'member_level' );
		$model_name = $this->main_model_name ();
		$model = $this->_load_model ( $model_name );
		$check = $model->get_price_code ( $this->inter_id, $price_code );
		$data ['sort'] = $this->input->post ( 'sort' );
		$data ['des'] = $this->input->post ( 'des' );
		$data ['status'] = $this->input->post ( 'status' );
		$data ['type'] = $this->input->post ( 'type' );
		$data ['related_cal_way'] = $this->input->post ( 'related_cal_way' );
		$data ['related_code'] = intval ( $this->input->post ( 'related_code' ) );
		$data ['related_cal_value'] = floatval ( $this->input->post ( 'related_cal_value' ) );
		$data ['price_name'] = htmlspecialchars ( $this->input->post ( 'price_name' ) );
		$data ['unlock_code'] = htmlspecialchars ( $this->input->post ( 'unlock_code' ) );
		$data ['external_code'] = htmlspecialchars ( $this->input->post ( 'external_code' ) );
		$data ['use_condition'] ['pre_pay'] = intval ( $this->input->post ( 'pre_pay' ) );
		$no_pay_way = $this->input->post ( 'no_pay_way' );
		if (! empty ( $no_pay_way )) {
			foreach ( $no_pay_way as $npw ) {
				$data ['use_condition'] ['no_pay_way'] [] = $npw;
			}
		}
		if ($member_level != - 1)
			$data ['use_condition'] ['member_level'] = intval ( $member_level );
			
			// @author lGh 可订时间段、最低入住时间、加服务
		$data ['time_condition']='';
		$book_time_s = $this->input->post ( 'book_time_s' );
		$book_time_e = $this->input->post ( 'book_time_e' );
		$book_time_s = intval ( $book_time_s );
		$book_time_e = intval ( $book_time_e );
		$book_time_s = strlen ( $book_time_s ) < 4 ? str_pad ( $book_time_s, 4, '0', STR_PAD_LEFT ) : substr ( $book_time_s, 0, 4 );
		$book_time_e = strlen ( $book_time_e ) < 4 ? str_pad ( $book_time_e, 4, '0', STR_PAD_LEFT ) : substr ( $book_time_e, 0, 4 );
		if (strtotime ( $book_time_s ) && strtotime ( $book_time_e ) && $book_time_s < $book_time_e) {
			$data ['time_condition'] ['book_time'] ['s'] = $book_time_s;
			$data ['time_condition'] ['book_time'] ['e'] = $book_time_e;
		}
		$book_time_mod = intval ( $this->input->post ( 'book_time_mod' ) );
		if (!empty($book_time_mod)){
			$data ['time_condition'] ['book_time'] ['mod']=$book_time_mod==30?30:60;
		}
		if (!empty($data ['time_condition']))
			$data ['time_condition'] = json_encode ( $data ['time_condition'] );
		
		
		$pre_day = $this->input->post ( 'pre_day' );
		if ($pre_day != '' && is_numeric ( $pre_day ))
			$data ['use_condition'] ['pre_d'] = intval ( $pre_day );
		$add_service_set = json_decode ( $this->input->post ( 'service_data' ), TRUE );
		$data ['add_service_set'] = '';
		if (! empty ( $add_service_set )) {
			$this->load->model ( 'hotel/Service_model' );
			$services = $this->Service_model->get_service ( $this->inter_id, array (
					'service_type' => 'hotel_order',
					'status' => 1 
			) );
			foreach ( $add_service_set as $ak => $ass ) {
				if (! empty ( $services [$ak] )) {
					foreach ( $ass as $assk => $assv ) {
						if ($assv != '' && is_numeric ( $assv )) {
							$data ['add_service_set'] [$ak] [$assk] = intval ( $assv );
						}
					}
				}
			}
			if (!empty($data ['add_service_set']))
				$data ['add_service_set'] = json_encode ( $data ['add_service_set'] );
		}
		
		//@Editor lGh 2016-5-31 20:53:08 增加开始与结束日期配置
		$date_limit=array();
		$date_limit['s_date_s'] = intval($this->input->post ( 's_date_s' ));
		$date_limit['s_date_e'] = intval($this->input->post ( 's_date_e' ));
		$date_limit['e_date_s'] = intval($this->input->post ( 'e_date_s' ));
		$date_limit['e_date_e'] = intval($this->input->post ( 'e_date_e' ));
		foreach ($date_limit as $k=>$l){
			if (!empty($l)&&strtotime($l)){
				$data ['use_condition'] [$k] = $l;
			}
		}
		
		//@Editor lGh 2016-7-6 15:10:51 数量与天数限制
		$max_num=intval($this->input->post ( 'max_num' ));
		$max_day=intval($this->input->post ( 'max_day' ));
        $min_day=intval($this->input->post ( 'min_day' ));
		if ($max_num>0)
			$data ['use_condition']['mxn']=$max_num;
		if ($max_day>0)
			$data ['use_condition']['mxd']=$max_day;
        if ($min_day>0)
            $data ['use_condition']['min_day']=$min_day;
		
		$data ['use_condition'] = json_encode ( $data ['use_condition'] );
		$data ['must_date'] = intval ( $this->input->post ( 'must_date' ) );
		
		//@Editor lGh 2016-6-15 15:58:48 增加优惠券配置
		$data['coupon_condition']=array();
		$coupon_num_type=$this->input->post('coupon_num_type');
		$coupon_num=$this->input->post('coupon_num');
		if (!empty(intval($coupon_num))){
			$data['coupon_condition']['num_type']=$coupon_num_type=='roomnight'?'roomnight':'order';
			$data['coupon_condition']['coupon_num']=intval($coupon_num);
		}
		$no_coupon=$this->input->post ( 'no_coupon' );
		$data ['coupon_condition'] ['no_coupon'] = intval ( $no_coupon );
		
		//@Editor lGh 2016-7-6 15:13:30 券关联
		$related_coupon=intval($this->input->post('related_coupon'));
		if (!empty($related_coupon))
			$data ['coupon_condition'] ['couprel'] = $related_coupon;
		
		//@Editor lGh 2016-10-21 20:26:47 pms券配置
		$coupon_is_pms=intval($this->input->post ( 'coupon_is_pms' ));
		if (!empty($coupon_is_pms))
			$data ['coupon_condition'] ['is_pms'] = 1;
		
		$data ['coupon_condition'] = json_encode ( $data ['coupon_condition'] );
		
		//@Editor lGh 2016-7-29 21:50:43 增加积分配置
		$data['bonus_condition']=array();
		$no_part_bonus=$this->input->post ( 'no_part_bonus' );
		$poc=$this->input->post ( 'poc' );
		$data ['bonus_condition'] ['no_part_bonus'] = intval ( $no_part_bonus );
		$data ['bonus_condition'] ['poc'] = intval ( $poc );

		$data ['bonus_condition'] = json_encode ( $data ['bonus_condition'] );

		// 预订政策
		$data['bookpolicy_condition']['breakfast_nums'] = $this->input->post ( 'breakfast_nums' );//早餐
		$data['bookpolicy_condition']['retain_time'] = $this->input->post('retain_time');//预订保留时间
		$data['bookpolicy_condition']['delay_time'] = $this->input->post('delay_time');//退房延迟时间
        $wxpay_favour=floatval($this->input->post('wxpay_favour'));     //微信支付立减
        if (!empty($wxpay_favour)&&$wxpay_favour>0){
            $data['bookpolicy_condition']['wxpay_favour']=$wxpay_favour;
        }
		$data['bookpolicy_condition'] = json_encode($data['bookpolicy_condition']);
		
		$flag = 0;
		if ($check) {
			$flag = $model->edit_price_code ( array (
					'inter_id' => $this->inter_id,
					'price_code' => $check ['price_code']
			), $data );
		} else {
			$data ['inter_id'] = $this->inter_id;
			$flag = $model->add_price_code ( $data );
		}
		$flag == 0 ? redirect ( site_url ( 'hotel/prices/code_set' ) . '?pcode=' . $price_code ) : redirect ( site_url ( 'hotel/prices/code_set' ) );
	}
	public function quick_save_set() {
		$hotel_id = intval ( $this->input->get ( 'hid' ) );

		$entity_id = $this->session->get_admin_hotels ();
		if (! empty ( $entity_id )) {
			$hotel_ids = explode ( ',', $entity_id );
			if (! in_array ( $hotel_id, $hotel_ids )) {
				echo 0;
				exit ();
			}
		}

		$room_id = intval ( $this->input->get ( 'room' ) );
		$code = intval ( $this->input->get ( 'code' ) );
		$data ['price'] = floatval ( $this->input->get ( 'price' ) );
		$num = $this->input->get ( 'num' );
		$num = $num === '' ? null : intval ( $num );
		$data ['nums'] = $num;
		$data ['breakfast_nums'] =  $this->input->get ( 'bfnums' );
		$data ['status'] = intval ( $this->input->get ( 'status' ) );
		$model_name = $this->main_model_name ();
		$model = $this->_load_model ( $model_name );
		$result = $model->edit_code_set_part ( $this->inter_id, $hotel_id, $room_id, $code, $data );
		if ($result)
			echo 1;
		else
			echo 0;
	}
	/**
	 * 一键关房
	 */
	public function quick_close() {
		$data = $this->common_data;
		$model = $this->_load_model ( $this->main_model_name () );
		$this->load->model ( 'hotel/hotel_model' );
		$data ['today'] = date ( 'Ymd' );
		$entity_id = $this->session->get_admin_hotels ();
		if (! empty ( $entity_id )) {
			$hotel_ids = explode ( ',', $entity_id );
			if (! empty ( $data ['hotel_id'] ) && ! in_array ( $data ['hotel_id'], $hotel_ids )) {
				$data ['hotel_id'] = 0;
			}
			$data ['hotels'] = $this->hotel_model->get_hotel_by_ids ( $this->inter_id, $entity_id );
		} else
			$data ['hotels'] = $this->hotel_model->get_all_hotels ( $this->inter_id,1 );

		if (! empty ( $data ['hotel_id'] )) {
			$list = $model->get_room_price_set ( $this->inter_id, $data ['hotel_id'], $data ['room_id'] );
			$this->load->model ( 'common/Enum_model' );
			$status_des = $this->Enum_model->get_enum_des ( array (
					'HOTEL_PRICE_SET_STATUS',
					'HOTEL_PRICE_CODE_RELATED_CAL_WAY'
			) );
			foreach ( $list as $k => $d ) {
				if (isset ( $d ['set_status'] ))
					$list [$k] ['code_status'] = $status_des ['HOTEL_PRICE_SET_STATUS'] [$d ['set_status']];
				else
					$list [$k] ['code_status'] = '未设置';
				if (! empty ( $d ['related_code'] ))
					$list [$k] ['related_name'] = $d ['related_name'] . '(' . $status_des ['HOTEL_PRICE_CODE_RELATED_CAL_WAY'] [$d ['related_cal_way']] . $list [$k] ['related_cal_value'] . ')';
			}
			$data ['list'] = $list;
		} else {
			$data ['hotel_id'] = empty ( $data ['hotels'] [0] ) ? 0 : $data ['hotels'] [0] ['hotel_id'];
		}
		$this->_render_content ( $this->_load_view_file ( 'quick_close' ), $data, false );
	}
	public function quick_close_set() {
		$model = $this->_load_model ( $this->main_model_name () );
		$hotel_id = $this->input->get ( 'hid' );
		$rooms = $this->input->get ( 'room' );
		$rooms = explode ( ',', $rooms );
		$startdate = $this->input->get ( 'start' );
		$enddate = $this->input->get ( 'end' );
		$type = $this->input->get ( 'type' );
		$this->load->helper ( 'date' );
		if (empty ( $rooms ) || empty ( $hotel_id ) || empty ( $startdate ) || empty ( $enddate ) || ! strtotime ( $startdate ) || ! strtotime ( $enddate ) || $startdate > $enddate || $startdate < date ( 'Ymd' )) {
			echo 0;
			exit ();
		}
		$day_arr = get_day_range ( $startdate, $enddate, 'array' );
		$entity_id = $this->session->get_admin_hotels ();
		if (! empty ( $entity_id )) {
			$hotel_ids = explode ( ',', $entity_id );
			if (! in_array ( $hotel_id, $hotel_ids )) {
				echo 0;
				exit ();
			}
		}
		if ($type == 1) {
			$this->db->trans_begin ();
			foreach ( $rooms as $r ) {
				foreach ( $day_arr as $day ) {
					$data = array (
							'inter_id' => $this->inter_id,
							'room_id' => $r,
							'hotel_id' => $hotel_id,
							'date' => $day,
							'price_code' => - 2,
							'channel_code' => 'Weixin'
					);
					$this->db->where ( $data );
					if (! $this->db->get ( 'hotel_room_state' )->result ()) {
						$data ['price_code'] = - 1;
						$data ['price'] = NULL;
						$data ['oprice'] = 0;
						$data ['nums'] = 0;
						$data ['channel_code'] = 'Weixin';
						$data ['edittime'] = time ();
						$this->db->replace ( 'hotel_room_state', $data );
					} else {
						$this->db->where ( $data );
						$this->db->update ( 'hotel_room_state', array (
								'price_code' => - 1,
								'nums' => 0,
								'edittime' => time ()
						) );
					}
				}
			}
			$this->db->trans_complete ();
		} elseif ($type == 2) {
			foreach ( $rooms as $r ) {
				foreach ( $day_arr as $day ) {
					$data = array (
							'inter_id' => $this->inter_id,
							'room_id' => $r,
							'hotel_id' => $hotel_id,
							'date' => $day,
							'price_code' => - 1,
							'channel_code' => 'Weixin'
					);
					$this->db->where ( $data );
					if ($this->db->get ( 'hotel_room_state' )) {
						$this->db->where ( $data );
						$this->db->update ( 'hotel_room_state', array (
								'price_code' => - 2,
								'edittime' => time ()
						) );
					}
				}
			}
		} else {
			echo 0;
			exit ();
		}

		if ($this->db->trans_status () === FALSE) {
			$this->db->trans_rollback ();
			echo 0;
		} else {
			$this->db->trans_commit ();
			echo 1;
		}
	}
}