<?php

class Linhao extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->helper('common');
		$this->pms_auth=array(
			'channelCode' => 'WJFK',
			'channelFrom' => 'WEIXIN',
		);
	}

	public function get_roomsf(){
		$url = 'http://61.145.107.134:8080/HOTELCRSREQ/weiXin?method=SingleHotelSearch';

		$params = [
			'channelCode' => 'WJFK',
			'channelFrom' => 'WEIXIN',
			'hotelCode'   => 'LH001',
			'startDate'   => date('Y-m-d'),
			'endDate'     => date('Y-m-d', time() + 86400),
		];
		
		$extra=['CURLOPT_HTTPHEADER'=>['Content-Type: application/json']];
		$res=doCurlPostRequest($url, json_encode($params),$extra,25);
		
		echo $res;
	}

	public function get_roomss(){
		$url = 'http://218.17.41.170:8085/pms/api/RoomTypes';
		//?arrival={Arrival}&departure={Departure}&ratecode={RateCode}
		$params=array(
			'arrival'=>date('Y-m-d'),
			'departure'=>date('Y-m-d',time()+86400),
			'ratecode'=>'RR',
		);
		$p_url='http://218.17.41.170:8085/pms/home/login?user=100&password=100';
		$ch = curl_init(( string )$p_url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch,CURLOPT_REFERER,'http://hotels.iwide.cn');
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.80 Safari/537.36 Core/1.47.640.400 QQBrowser/9.4.8309.400');
		$re = curl_exec($ch);
		echo $re;
		echo "\n";
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch,CURLOPT_URL,$url);
		$res=curl_exec($ch);
		echo $res;
	}
}