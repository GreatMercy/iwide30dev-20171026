<?php
class Yinju extends MY_Controller{
	public function fixpms(){
		$old_json='{"url":"http:\/\/115.159.213.30:8104\/ipmsgroup\/CRS","salesChannel":"WEIXIN","hotelGroupId":2,"member_url":"http:\/\/115.159.213.30:8090\/ipms\/","taCode":"9600","src":"MOB","def_market":"NET","member_mulprice":1,"point_market":"YYB"}';
		$old_auth=json_decode($old_json,true);
		$merge=[
			'fang_fee'    => ['0001','0002','0003','0004','0005','0006','0007'],
			'new_upd'     => 1,
			'multi_rooms' => 1,
		];
	}
}