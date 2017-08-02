<?php

class Yibo extends MY_Controller{
	private $url = 'http://medium.100inns.com/ClockService.asmx?wsdl';
	private $url2 = 'http://medium.100inns.com/ClockService.asmx';
	private $soap;
	private $inter_id = 'a441098524';

	public function __construct(){
		parent::__construct();
		$this->load->helper('common');
		/*$this->soap = new SoapClient($this->url, array(
			'soap_version' => SOAP_1_1,
			'encoding'     => 'UTF-8',
		));*/
	}

	public function test(){
		print_r($this->soap->__getFunctions());
		print_r($this->soap->__getTypes());
	}

	public function hotels(){
		$s = $this->soap->__soapCall('GetClockHotels', array(
			'parameters' => array('hotelCode' => '300', 'city' => '')
		));
		echo json_encode(xml2array($s->GetClockHotelsResult));
	}

	public function rooms(){
		$s = $this->soap->__soapCall('GetClockRoomTypes', array(
			'parameters' => array('hotelCode' => 'hzybyj300')
		));
		echo json_encode(xml2array($s->GetClockRoomTypesResult));
	}

	public function price(){
		$s = $this->soap->__soapCall('GetClockPrice', array(
			'parameters' => array('hotelCode' => 'hzybyj300')
		));
		print_r(xml2array($s->GetClockPriceResult));
	}

	public function qty(){
		$s = $this->soap->__soapCall('GetSalesQuantity', array(
			'parameters' => array('hotelCode' => 'hzybyj300')
		));
		print_r(xml2array($s->GetSalesQuantityResult));
	}

	public function cancelorder(){
		$s = $this->soap->__soapCall('CancelClockOrder', array(
			'parameters' => array('orderNo' => '2016122810064722')
		));
		var_dump(xml2array($s->CancelClockOrderResult));
	}

	public function getorder(){
		$s = $this->soap->__soapCall('GetClockOrderDetail', array(
			'parameters' => array('orderNo' => '2016122810064722')
		));
		print_r(xml2array($s->GetClockOrderDetailResult));
	}

	public function crooms(){
		$data = array(
			'hotelCode' => 'hzybyj300'
		);
		$send_content = http_build_query($data);
		$s = doCurlPostRequest($this->url2 . 'GetClockRoomTypes', $send_content, array(), 10);
		print_r($s);
	}

	public function clockprice(){
		$room_list = $this->db->from('hotel_rooms')->where(['inter_id' => $this->inter_id])->get()->result_array();
		$params = [];
		foreach($room_list as $v){
			$params[] = [
				'inter_id'   => $v['inter_id'],
				'hotel_id'   => $v['hotel_id'],
				'room_id'    => $v['room_id'],
				'price_code' => 7,
				'edittime'   => time(),
				'status'     => 1,
			];
		}

		$this->db->insert_batch('hotel_price_set', $params);
		echo 'success';
	}

	public function priceset(){
		$db = $this->load->database('default', true);
		$json = file_get_contents(FD_PUBLIC . '/tmp_data/yibo_rooms_p10.json');
		$rooms = json_decode($json, true);
		$params = [];
		foreach($rooms as $v){
			$params[] = [
				'inter_id'   => $v['inter_id'],
				'hotel_id'   => $v['hotel_id'],
				'room_id'    => $v['room_id'],
				'price_code' => 10,
				'edittime'   => time(),
				'status'     => 1,
			];
		}
		$db->insert_batch('hotel_price_set_copy',$params);

		$json = file_get_contents(FD_PUBLIC . '/tmp_data/yibo_rooms_p11.json');
		$rooms = json_decode($json, true);
		$params = [];
		foreach($rooms as $v){
			$params[] = [
				'inter_id'   => $v['inter_id'],
				'hotel_id'   => $v['hotel_id'],
				'room_id'    => $v['room_id'],
				'price_code' => 10,
				'edittime'   => time(),
				'status'     => 1,
			];
		}
		$db->insert_batch('hotel_price_set_copy',$params);
		echo 'success';
	}
}