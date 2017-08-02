<?php

class Qinde extends MY_Controller{
	private $curl_url = 'http://a.qininn.com:10008/JfkSoap';
	private $inter_id = 'a463105262';

	public function __construct(){
		parent::__construct();

		$this->load->helper('common');
		$this->pms_auth = array(
			'url'  => $this->curl_url,
			'user' => 'jfksoap',
			'pwd'  => 'jfk.qdkz.2016',
		);
	}

	public function updatePmsAuth(){
		$this->db->update('hotel_additions',array('pms_auth'=>json_encode($this->pms_auth)),array('inter_id'=>$this->inter_id));
		echo 'success';
	}

	public function bill(){
		$serv_api = new QindeApi();
		$serv_api->setAuthToen($this->pms_auth);
		print_r($serv_api->payOrder('36146735665954852','ODR16070100002','2016070115061122',49200));
	}

	public function index(){
		$serv_api = new QindeApi();
		$serv_api->setAuthToen($this->pms_auth);

		$res = $serv_api->getInventoryByHotel('584ab1dd-32b1-4ac9-a165-5829d9a270ac',date('Y-m-d'), date('Y-m-d', time() + 86400));
		echo $res['InventoryPrice'];
	}

	public function order(){
		$serv_api = new QindeApi();
		$serv_api->setAuthToen($this->pms_auth);
		print_r($serv_api->getOrder('36146735665954852', 'ODR16070100002'));
	}

	public function merge(){
		set_time_limit(0);
		$hotels = $this->getJsonList('hotels');
		$rooms = $this->getJsonList('hotel_rooms');
		$room_list = array();
		foreach($rooms as $v){
			$room_list[$v['hotel_id']][] = $v;
		}
		$price_sets = $this->getJsonList('hotel_price_set');
		$price_list = array();
		foreach($price_sets as $v){
			$price_list[$v['hotel_id']][$v['room_id']][] = $v;
		}
		/*$price_infos = $this->getJsonList('hotel_price_info');
		$price_info_list = array();
		foreach($price_infos as $v){
			$price_info_list[$v['hotel_id']][$v['room_id']][] = $v;
		}*/
		$hotel_additions = $this->getJsonList('hotel_additions');
		$additions_list = array();
		foreach($hotel_additions as $v){
			$additions_list[$v['hotel_id']] = $v;
		}

		$additions_params = array();
		$price_params = array();

		foreach($hotels as $v){
			$hotel_id = $v['hotel_id'];
			unset($v['hotel_id']);
			$this->db->set($v)->insert('hotels');
			$new_hotel_id = $this->db->insert_id();
			if(!empty($additions_list[$hotel_id])){
				$t = $additions_list[$hotel_id];
				$t['hotel_id'] = $new_hotel_id;
				$additions_params[] = $t;
			}
			if(!empty($room_list[$hotel_id])){
				foreach($room_list[$hotel_id] as $t){
					$t['hotel_id'] = $new_hotel_id;
					$room_id = $t['room_id'];
					unset($t['room_id']);
					$this->db->set($t)->insert('hotel_rooms');
					$new_room_id = $this->db->insert_id();
					if(!empty($price_list[$hotel_id][$room_id])){
						foreach($price_list[$hotel_id][$room_id] as $w){
							$w['hotel_id'] = $new_hotel_id;
							$w['room_id'] = $new_room_id;
							$price_params[] = $w;
						}
					}
				}

				if($price_params){
					$this->db->set_insert_batch($price_params)->insert_batch('hotel_price_set');
					$price_params=array();
				}
			}
		}
		if($additions_params){
			$this->db->set_insert_batch($additions_params)->insert_batch('hotel_additions');
		}

		echo 'success';

	}

	public function teststate(){
		$list = $this->getJsonList('hotel_price_set');
//		$list=$this->db->from('hotel_room_state')->where(array('inter_id'=>$this->inter_id))->get()->result_array();
		print_r($list);
	}


	private function getJsonList($file){
		$list = array();
		if(file_exists(FD_PUBLIC . '/qinde/qinde_' . $file . '.json')){
			$json = file_get_contents(FD_PUBLIC . '/qinde/qinde_' . $file . '.json');
			$list = json_decode($json, TRUE);
		}
		return $list;
	}

}

class QindeApi{
	private $username;
	private $password;
	private $url;

	public function __construct(){

	}

	public function setAuthToen($pms_auth){
		if(isset($pms_auth['user'])){
			$this->username = $pms_auth['user'];
		}
		if(isset($pms_auth['pwd'])){
			$this->password = $pms_auth['pwd'];
		}
		if(isset($pms_auth['url'])){
			$this->url = $pms_auth['url'];
		}
	}

	public function getPostAuth(){
		if($this->username && $this->password){
			return array(
				'AuthenticationToken' => array(
					'Username' => $this->username,
					'Password' => $this->password,
				),
			);
		}
		return array();
	}

	/**
	 * 查询/同步库存
	 * @param string $hotel_id     酒店ID
	 * @param string $room_type_id 房型ID
	 * @param mixed  $checkin      入住日期
	 * @param mixed  $checkout     离店日期
	 * @return array
	 */
	public function getInventoryByRoom($hotel_id, $room_type_id, $checkin, $checkout){
		$data = array(
			'HotelId'    => $hotel_id,
			'RoomTypeId' => $room_type_id,
			'CheckIn'    => $checkin,
			'CheckOut'   => $checkout,
		);
		$data = array_merge($data, $this->getPostAuth());

		$curl_array = array(
			'StockRQ' => $data
		);

		return $this->apiCall($curl_array);
	}

	/**
	 * 检查库存
	 * @param string $hotel_id     酒店ID
	 * @param string $room_type_id 房型ID
	 * @param mixed  $checkin      入住日期
	 * @param mixed  $checkout     离店日期
	 * @param int    $room_num     房间数
	 * @return array
	 */
	public function checkInventoryByRoom($hotel_id, $room_type_id, $checkin, $checkout, $room_num = 1){
		$data = array(
			'HotelId'    => $hotel_id,
			'RoomTypeId' => $room_type_id,
			'CheckIn'    => $checkin,
			'CheckOut'   => $checkout,
			'RoomNum'    => (int)$room_num,
		);
		$data = array_merge($data, $this->getPostAuth());

		$curl_array = array(
			'ValidateRQ' => $data
		);

		return $this->apiCall($curl_array);

	}

	/**
	 * 预订
	 * @param $params
	 *          array(
	 *          OrderId=>订单ID
	 *          HotelId=>酒店ID
	 *          RoomTypeId=>房型ID
	 *          CheckIn=>入住日期
	 *          CheckOut=>离店日期
	 *          EarliestArriveTime=>最早到店时间
	 *          LatestArriveTime=>最迟到店时间
	 *          RoomNum=>预订房数
	 *          TotalPrice=>总价格（单位分）
	 *          ContactName=>联系人姓名
	 *          PaymentType=>预订类型（1：预付，2：现付）
	 *          ContactTel=>联系电话
	 *          DailyInfos=>array(  每日价格
	 *          DailyInfo=>array(
	 *          array(
	 *          Day=>日期
	 *          Price=>价格（单位：分）
	 *          )
	 *          )
	 *          )
	 *          OrderGuests=>array(
	 *          OrderGuest=>array(
	 *          Name=>姓名
	 *          RoomPos=>房间序号
	 *          )
	 *          )
	 *          Comment=>备注
	 *
	 * )
	 * @return array
	 */
	public function createOrder($params){
		$params = array_merge($params, $this->getPostAuth());

		$curl_array = array(
			'BookRQ' => $params
		);
		return $this->apiCall($curl_array);
	}

	/**
	 * 获取樟
	 * @param string $zl_orderid 直连订单ID
	 * @param string $orderid    PMS上订单ID
	 * @return array
	 */
	public function getOrder($zl_orderid, $orderid = ''){
		$data = array(
			'ZlOrderId' => $zl_orderid,
			'OrderId'   => $orderid
		);
		$data = array_merge($data, $this->getPostAuth());
		$curl_array = array(
			'QueryStatusRQ' => $data,
		);
		return $this->apiCall($curl_array);
	}

	/**
	 * @param string $zl_orderid  直连订单ID
	 * @param string $orderid     PMS上订单ID
	 * @param string $reson       取消原因
	 * @param bool   $hard_cancel 是否强制取消
	 * @return array
	 */
	public function cancelOrder($zl_orderid, $orderid = '', $reson = '', $hard_cancel = FALSE){
		$data = array(
			'ZlOrderId'  => $zl_orderid,
			'OrderId'    => $orderid,
			'Reason'     => $reson,
			'HardCancel' => $hard_cancel,
		);
		$data = array_merge($data, $this->getPostAuth());
		$curl_array = array(
			'CancelRQ' => $data,
		);
		return $this->apiCall($curl_array);

	}

	/**
	 * 支付订单
	 * @param string $zl_orderid 直连订单ID
	 * @param string $orderid    订单ID
	 * @param string $trade_no   支付记录ID
	 * @param int    $payment    支付金额【单位分】
	 * @return array
	 */
	public function payOrder($zl_orderid, $orderid, $trade_no, $payment){
		$data = array(
			'ZlOrderId'     => $zl_orderid,
			'OrderId'       => $orderid,
			'AlipayTradeNo' => $trade_no,
			'Payment'       => (int)$payment,
		);
		$data = array_merge($data, $this->getPostAuth());
		$curl_array = array(
			'PaySuccessRQ' => $data,
		);
		return $this->apiCall($curl_array);
	}

	public function getInventoryByHotel($hotel_id, $checkin, $checkout){
		$data = array(
			'HotelId'  => $hotel_id,
			'CheckIn'  => $checkin,
			'CheckOut' => $checkout,
		);
		$data = array_merge($data, $this->getPostAuth());

		$curl_array = array(
			'StockListRQ' => $data
		);

		return $this->apiCall($curl_array);
	}

	private function apiCall($curl_array){
		$curl_xml = array2xml($curl_array);
		$extra=['CURLOPT_HTTPHEADER'=>['Content-Type: application/xml']];
		$xml=doCurlPostRequest($this->url, $curl_xml,$extra,30);
		if($xml){
			$result = obj2array(simplexml_load_string($xml));
			return $result;
		}
		return array(
			'ResultCode' => -9999,
			'Message'    => '没有返回结果',
		);
	}
}