<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Hotel_report extends MY_Admin_Iapi {
	protected $label_module = '酒店统计';
	protected $label_controller = '酒店统计';
	protected $label_action = '';
	function __construct() {
		parent::__construct ();
		if ($this->input->get ( 'debug' )) {
			$this->output->enable_profiler ( true );
		}
	}
	
	//统计复购率
	public function order_re_purchase(){
		$avgs ['hotel_id'] = $this->input->get ( 'hotel_id' );//酒店id
		$avgs ['month_start'] = $this->input->get ( 'month_start' );//开始月份
		$avgs ['month_end'] = $this->input->get ( 'month_end' );//结束月份
		if (empty ( $avgs ['month_start'] ) || empty( $avgs ['month_end'] )) {
			$this->out_put_msg(2,'请选择日期','','hotel/hotel_report/order_re_purchase');
		}
		$admin_profile = $this->session->userdata ( 'admin_profile' );

		$this->load->model ( 'hotel/hotel_model' );
		if (! empty ( $admin_profile ['entity_id'] )) {
			$hotel_ids = explode ( ',', $admin_profile ['entity_id'] );
			if (! empty ( $avgs ['hotel_id'] ) && ! in_array ( $avgs ['hotel_id'], $hotel_ids )) {
				$this->out_put_msg(2,'权限不足','','hotel/hotel_report/order_re_purchase');
			}
			if(empty($avgs ['hotel_id'])){
				$avgs ['hotel_ids'] = $hotel_ids;
			}
		}
		
		$this->load->model ( 'hotel/Hotel_report_model' );
		
		$avgs ['inter_id'] = $admin_profile ['inter_id'];
		$res = $this->Hotel_report_model->get_re_purchase ( $avgs);
		$data['data'] = $res;
		$this->out_put_msg(1,'',$data,'hotel/hotel_report/order_re_purchase');
	}

	//交易数据统计
	public function general_situation(){
		$avgs ['hotel_id'] = $this->input->get ( 'hotel_id' );//酒店id
		$avgs ['time_start'] = $this->input->get ( 'time_start' );//开始日期
		$avgs ['time_end'] = $this->input->get ( 'time_end' );//结束日期
		if (empty ( $avgs ['time_start'] ) || empty( $avgs ['time_end'] )) {
			$this->out_put_msg(2,'请选择日期','','hotel/hotel_report/general_situation');
		}
		$avgs ['time_start'] = strtotime($avgs ['time_start'].' 00:00:00');
		$avgs ['time_end'] = strtotime($avgs ['time_end'].' 23:59:59');
		$admin_profile = $this->session->userdata ( 'admin_profile' );

		$this->load->model ( 'hotel/hotel_model' );
		if (! empty ( $admin_profile ['entity_id'] )) {
			$hotel_ids = explode ( ',', $admin_profile ['entity_id'] );
			if (! empty ( $avgs ['hotel_id'] ) && ! in_array ( $avgs ['hotel_id'], $hotel_ids )) {
				$this->out_put_msg(2,'权限不足','','hotel/hotel_report/general_situation');
			}
			if(empty($avgs ['hotel_id'])){
				$avgs ['hotel_ids'] = $hotel_ids;
			}
		}
		
		$this->load->model ( 'hotel/Hotel_report_model' );
		
		$avgs ['inter_id'] = $admin_profile ['inter_id'];
		$res_in = $this->Hotel_report_model->get_general_situation_in ( $avgs);
		$res_out = $this->Hotel_report_model->get_general_situation_out ( $avgs);
		$time_start = $avgs ['time_start'];
		$avgs ['time_start'] = 2*$time_start - $avgs ['time_end']-1;
		$avgs ['time_end'] = $time_start-1;
		$res_in_pre = $this->Hotel_report_model->get_general_situation_in ( $avgs);
		
		$hotels_arr = array_keys($res_in);
		foreach ($res_out as $key => $value) {
			if(!in_array($key,$hotels_arr)){
				$hotels_arr[] = $key;
			}
		}
		$data = array();
		$all_in_order_count =0;
		$all_in_order_count_rate ='-';
		$all_in_items_count =0;
		$all_in_items_count_rate ='-';
		$all_in_roomnight_count =0;
		$all_in_roomnight_count_rate ='-';
		$all_in_price_count =0;
		$all_in_price_count_rate ='-';
		$all_out_items_count =0;
		$all_out_roomnight_count =0;
		$all_out_price_count =0;
		$all_out_price_count_avg =0;
		$all_in_order_count_pre = 0;
		$all_in_items_count_pre = 0;
		$all_in_roomnight_count_pre = 0;
		$all_in_price_count_pre = 0;
		foreach ($hotels_arr as $hotel_id) {
			$row = array(
				'in_order_count'=>0,
				'in_order_count_rate'=>'-',
				'in_items_count'=>0,
				'in_items_count_rate'=>'-',
				'in_roomnight_count'=>0,
				'in_roomnight_count_rate'=>'-',
				'in_price_count'=>0,
				'in_price_count_rate'=>'-',
				'out_items_count'=>0,
				'out_roomnight_count'=>0,
				'out_price_count'=>0,
				'out_price_count_avg'=>0
			);
			if(isset($res_in[$hotel_id])){
				$all_in_order_count += $res_in[$hotel_id]['ocount'];
				$all_in_items_count += $res_in[$hotel_id]['icount'];
				$all_in_roomnight_count += $res_in[$hotel_id]['roomnight'];
				$all_in_price_count += $res_in[$hotel_id]['allprice'];
				$row['in_order_count'] = $res_in[$hotel_id]['ocount'];
				$row['in_items_count'] = $res_in[$hotel_id]['icount'];
				$row['in_roomnight_count'] = $res_in[$hotel_id]['roomnight'];
				$row['in_price_count'] = $res_in[$hotel_id]['allprice'];
				if(isset($res_in_pre[$hotel_id])){
					$all_in_order_count_pre += $res_in_pre[$hotel_id]['ocount'];
					$all_in_items_count_pre += $res_in_pre[$hotel_id]['icount'];
					$all_in_roomnight_count_pre += $res_in_pre[$hotel_id]['roomnight'];
					$all_in_price_count_pre += $res_in_pre[$hotel_id]['allprice'];
					if($res_in_pre[$hotel_id]['ocount']>0){
						$row['in_order_count_rate'] = bcmul(bcdiv(bcsub($res_in[$hotel_id]['ocount'] , $res_in_pre[$hotel_id]['ocount'],2),$res_in_pre[$hotel_id]['ocount'],2),100,2);
					}
					if($res_in_pre[$hotel_id]['icount']>0){
						$row['in_items_count_rate'] = bcmul(bcdiv(bcsub($res_in[$hotel_id]['icount'] , $res_in_pre[$hotel_id]['icount'],2),$res_in_pre[$hotel_id]['icount'],2),100,2);
					}
					if($res_in_pre[$hotel_id]['roomnight']>0){
						$row['in_roomnight_count_rate'] = bcmul(bcdiv(bcsub($res_in[$hotel_id]['roomnight'] , $res_in_pre[$hotel_id]['roomnight'],2),$res_in_pre[$hotel_id]['roomnight'],2),100,2);
					}
					if($res_in_pre[$hotel_id]['allprice']>0){
						$row['in_price_count_rate'] = bcmul(bcdiv(bcsub($res_in[$hotel_id]['allprice'] , $res_in_pre[$hotel_id]['allprice'],2),$res_in_pre[$hotel_id]['allprice'],2),100,2);
					}
				}
			}
			if(isset($res_out[$hotel_id])){
				$all_out_items_count += $res_out[$hotel_id]['icount'];
				$all_out_roomnight_count += $res_out[$hotel_id]['roomnight'];
				$all_out_price_count += $res_out[$hotel_id]['allprice'];
				$all_out_price_count_avg += $res_out[$hotel_id]['avg'];
				$row['out_items_count'] = $res_out[$hotel_id]['icount'];
				$row['out_roomnight_count'] = $res_out[$hotel_id]['roomnight'];
				$row['out_price_count'] = $res_out[$hotel_id]['allprice'];
				$row['out_price_count_avg'] = $res_out[$hotel_id]['avg'];
			}
			$data[$hotel_id] = $row;
		}
		//合计
		$data['all']['in_order_count'] = $all_in_order_count;
		$data['all']['in_items_count'] = $all_in_items_count;
		$data['all']['in_roomnight_count'] = $all_in_roomnight_count;
		$data['all']['in_price_count'] = $all_in_price_count;
		$data['all']['out_items_count'] = $all_out_items_count;
		$data['all']['out_roomnight_count'] = $all_out_roomnight_count;
		$data['all']['out_price_count'] = $all_out_price_count;
		$data['all']['out_price_count_avg'] = $all_out_price_count_avg;
		if($all_in_order_count_pre>0){
			$data['all']['in_order_count_rate'] = bcmul(bcdiv(bcsub($all_in_order_count , $all_in_order_count_pre,2),$all_in_order_count_pre,2),100,2);
		}
		if($all_in_items_count_pre>0){
			$data['all']['in_items_count_rate'] = bcmul(bcdiv(bcsub($all_in_items_count , $all_in_items_count_pre,2),$all_in_items_count_pre,2),100,2);
		}
		if($all_in_roomnight_count_pre>0){
			$data['all']['in_roomnight_count_rate'] = bcmul(bcdiv(bcsub($all_in_roomnight_count , $all_in_roomnight_count_pre,2),$all_in_roomnight_count_pre,2),100,2);
		}
		if($all_in_price_count_pre>0){
			$data['all']['in_price_count_rate'] = bcmul(bcdiv(bcsub($all_in_price_count , $all_in_price_count_pre,2),$all_in_price_count_pre,2),100,2);
		}
		$this->out_put_msg(1,'',$data,'hotel/hotel_report/general_situation');
	}
}
