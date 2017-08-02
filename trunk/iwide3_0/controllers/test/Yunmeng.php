<?php

class Yunmeng extends MY_Controller{
	public function merge_set(){
		$json = file_get_contents(FD_PUBLIC . '/huayi_zhuzhe_rooms.json');
		$room_list = json_decode($json, true);
		$params = array();
		foreach($room_list as $v){
			$params[] = array(
				'inter_id'   => $v['inter_id'],
				'hotel_id'   => $v['hotel_id'],
				'room_id'    => $v['room_id'],
				'price_code' => 20,
				'edittime'   => time(),
				'status'     => 1,
			);
		}
		$db = $this->load->database('default', true);
		if($params){
//			echo json_encode($params);
			$db->insert_batch('hotel_price_set_copy', $params);
		}
		echo 'success';
	}

}