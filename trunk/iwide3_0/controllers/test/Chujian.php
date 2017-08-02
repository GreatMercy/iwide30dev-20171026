<?php

class Chujian extends MY_Controller{
	private $inter_id = 'a494296203';
	private $url = 'http://114.215.188.191:8080/HotelCRSREQ/app/hotelSelfService';
	
	private $channelFrom = '';
	private $chainCode = '';
	
	private $pms_auth;
	
	public function __construct(){
		parent::__construct();
		$this->pms_auth = [
			'url'         => $this->url,
			'channelFrom' => $this->channelFrom,
			'chainCode'   => $this->chainCode,
		];
		
		$this->load->helper('common');
		
		$this->load->model('hotel/pms/Huayi_hotel_model', 'pms');
		
	}
	
	public function get_hotels(){
		$data = [
			'channelCode' => $this->channelFrom,
		    'channelFrom'=>$this->chainCode,
		];
	}
}