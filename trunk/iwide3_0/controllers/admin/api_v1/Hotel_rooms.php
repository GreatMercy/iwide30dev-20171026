<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Hotel_rooms extends MY_Admin {
	protected $label_module = NAV_HOTEL;
	protected $label_controller = '房型配置';
	protected $label_action = '';
	function __construct() {
		parent::__construct ();
		$this->inter_id = $this->session->get_admin_inter_id ();
		$this->module = 'hotel';
	}
	protected function main_model_name() {
		return 'hotel/rooms_model';
	}
	
	public function get_rooms()
	{
		$condit ['page'] = $this->input->get ( 'page' )>0 ? ($this->input->get ( 'page' )-1) : 0;
		$condit ['size'] = $this->input->get ( 'size' )>0 ? $this->input->get ( 'size' ) : 10;
		$condit ['keyword'] = $this->input->get ( 'keyword' ) ? $this->input->get ( 'keyword' ) : '';
		$condit ['offset'] = $condit ['size']*$condit ['page'];

		$entity_id = $this->session->get_admin_hotels ();
		//获取酒店列表
		$return = array();
		$this->load->model ( 'hotel/Hotel_model' );
		if( empty ( $entity_id ) ){
			$hotels = $this->Hotel_model->get_all_hotels( $this->inter_id ,null ,'' ,$condit);
			$condit ['is_count'] = true;
			$return['count'] = $this->Hotel_model->get_all_hotels( $this->inter_id ,null ,'' ,$condit);
		}else{
			$hotels = $this->Hotel_model->get_hotel_by_ids( $this->inter_id, $entity_id ,null ,'' ,'array',$condit);
			$condit ['is_count'] = true;
			$return['count'] = $this->Hotel_model->get_hotel_by_ids( $this->inter_id, $entity_id ,null ,'' ,'array',$condit);
		}

		$hotels_new = array();
		if( $hotels ){
			foreach( $hotels as $v ){
				//删除一些不需要的字段
				$data = array();
				$data['hotel_id'] = $v['hotel_id'];
				$data['inter_id'] = $v['inter_id'];
				$data['name'] = $v['name'];
				$data['address'] = $v['province'].$v['city'].$v['address'];
				$data['latitude'] = $v['latitude'];
				$data['longitude'] = $v['longitude'];
				$data['tel'] = $v['tel'];
				$hotels_new[$v['hotel_id']] = $data;
			}
		}
		
		//获取所有酒店的房型
		$this->load->model ( 'hotel/Rooms_model' );
		$rooms = $this->Rooms_model->get_hotels_rooms( $this->inter_id, array_keys( $hotels_new ), 'name,room_id,hotel_id,room_img' );
		if( $hotels_new ){
			foreach( $rooms as $k=>$v ){
				$hotels_new[$k]['room_ids'] = $v; 
			}
		}
		$return['data'] = $hotels_new;
		echo json_encode($return);
	}
}
