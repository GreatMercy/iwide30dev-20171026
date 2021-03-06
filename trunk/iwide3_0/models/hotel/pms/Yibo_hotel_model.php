<?php

class Yibo_hotel_model extends CI_Model{
	const TAB_HO = 'hotel_orders';
	const TAB_HOA = 'hotel_order_additions';
	const YIBO_TOKEN = '100200';
	const HOTEL_URL = 'http://h5.100inn.cc/HotelService.asmx/';
	const DISCOUNT_URL = 'http://h5.100inn.cc/DiscountService.asmx/';
	const COUPON_URL = 'http://h5.100inn.cc/CouponsService.asmx/';
	const MEMBER_URL = 'http://h5.100inn.cc/MemberService.asmx/';
	const GROUP_URL = 'http://h5.100inn.cc/GroupService.asmx/';
	const CLOCK_URL = 'http://medium.100inns.com/ClockService.asmx?wsdl';

	function __construct(){
		parent::__construct();
	}

	function get_city_region($inter_id, $city_no){
		$sql = "SELECT r.region_no,r.region_cnname,c.city_cnname FROM " . $this->readDB()->dbprefix('hotels_web_city') . " c join " . $this->readDB()->dbprefix('hotels_web_region') . " r on c.city_no=r.city_no where c.city_no='$city_no'";
		$region = $this->readDB()->query($sql)->result();
		return $region;
	}

	function get_city($inter_id){
		$sql = "SELECT h.city,i.city_id,getPY(LEFT(h.`city`,1)) py FROM " . $this->readDB()->dbprefix('hotels') . " h join " . $this->readDB()->dbprefix('hotels_webinfo') . " i on h.hotel_id=i.hotel_id and h.inter_id=i.inter_id where h.city!='' and h.city is not null and h.status=0 and h.inter_id='$inter_id' group by i.city_id order by py";
		$citys = $this->readDB()->query($sql)->result();
		return $citys;
	}

	function get_rooms_change($rooms, $idents, $condit, $pms_set = array()){
		$hotel_no = $idents ['hotel_web_id'];
		$startdate = $condit ['startdate'];
		$enddate = $condit ['enddate'];
//		$member_type = $condit ['member_level'];
		$member_type = '';

		$this->load->model ( 'common/Webservice_model' );
		$level_reflect = $this->Webservice_model->get_web_reflect ( $idents ['inter_id'], $idents ['hotel_id'], $pms_set ['pms_type'], array (
			'member_level',
			'basic_member_level',
			'no_favour_level'
		), 1, 'l2w' );
		if(isset($condit ['member_level'])){
			if (isset($level_reflect ['member_level'])&&isset($level_reflect['member_level'][$condit ['member_level']])){
				$member_type=$level_reflect['member_level'][$condit ['member_level']];
			}
			if (isset($level_reflect['basic_member_level'])&&isset($level_reflect['basic_member_level'][$condit ['member_level']])){
				$condit ['member_level']=$level_reflect['basic_member_level'][$condit ['member_level']];
			}
		}
		if(empty($condit['only_type'])&&!empty($condit['price_type'])&&is_array($condit['price_type'])){
			$pt_arr=$condit['price_type'];
			if(count($pt_arr)==1){
				$condit['only_type']=end($pt_arr);
			}
		}

		$countday = get_room_night($startdate,$enddate,'ceil');//至少有一个间夜
		// 取房态方式为并存
		if(!empty ($pms_set ['pms_room_state_way']) && $pms_set ['pms_room_state_way'] == 3){
			$this->load->model('hotel/Order_model');
			$extra_state = $this->Order_model->get_rooms_change($rooms, $idents, $condit);
			$external = array();
			$extra = array();
			foreach($extra_state as $room_id => $state){
				if(!empty ($state ['state_info'])){
					foreach($state ['state_info'] as $si){
						if(!empty ($si ['external_code'])){
							$external [$state ['room_info'] ['room_id']] [$si ['external_code']] [] = $si;
						} else{
							$extra [$state ['room_info'] ['room_id']] [] = $si;
						}
					}
				}
			}
		}
		$data = array();
		if(!empty($condit['only_type'])&&$condit['only_type']=='athour'){
			//钟点房
			$clock_list=$this->getClockRoomStatus($hotel_no,$pms_set['inter_id']);

			$merge = [
				'least_num',
				'book_status',
				'extra_info',
				'date_detail',
			];

			foreach($rooms as $rm){
				if(empty($clock_list[$rm['webser_id']])){
					continue;
				}
				$webps=[];
				$r=$clock_list[$rm['webser_id']];
				if(empty($r['rate'])){
					continue;
				}
				$least_arr = [1];
				$book_status='full';
				$min_price=[];

				foreach($r['rate'] as $web_rate=>$t){
					if($t['Price']<=0){
						continue;
					}
					$webps[$web_rate]['price_name']=$web_rate;
					$webps[$web_rate]['price_type']='pms';
					$webps[$web_rate]['extra_info']=[
						'type'     => 'code',
						'pms_code' => $web_rate
					];
					$webps[$web_rate]['price_code']=$web_rate;
					$webps[$web_rate]['des']='';
					$webps[$web_rate]['sort']=0;
					$webps[$web_rate]['disp_type']='buy';
					$webps[$web_rate]['related_code']='';
					$webps[$web_rate]['related_des']='';
					$webps[$web_rate]['related_cal_way']='';
					$webps[$web_rate]['related_cal_value']='';
					$webps[$web_rate]['condition']='';
					$webps[$web_rate]['price_name']='钟点房价';

					$allprice=[];
					$amount=0;
					$date_status=true;
					$webps[$web_rate]['date_detail']=[];
					foreach($r['quantity'] as $w){
						$in_date=date('Ymd',strtotime($w['RoomDate']));
						$webps[$web_rate]['date_detail'][$in_date]=[
							'price'=>$t['Price'],
						    'nums'=>$w['Count'],
						];

						$allprice[$in_date] = $t['Price'];

						$amount += $t['Price'];
						$least_arr[] = $w['Count'];

						$date_status = $date_status && ($w['Count'] > 0);
					}

					ksort($allprice);
					$least_count = min($least_arr);
					$least_count > 0 or $least_count = 0;
					if($date_status){
						$book_status = 'available';
					}

					$webps[$web_rate]['price_resource']='webservice';
					$webps[$web_rate]['least_num']=$least_count;
					$webps[$web_rate]['book_status']=$book_status;
					$webps[$web_rate]['allprice']=implode(',', $allprice);
					$webps[$web_rate]['total']=number_format($amount,1,'.','');
					$webps[$web_rate]['total_price']=number_format($amount,1,'.','');
					$webps[$web_rate]['avg_price']=number_format($amount/$countday,1);

					if(!empty($external[$rm['room_id']][$web_rate])){
						$room_key=$rm['webser_id'];
						foreach($external[$rm['room_id']][$web_rate] as $local){
							$tmp=$webps[$web_rate];
							foreach($merge as $w){
								if(isset($tmp[$w])){
									if($w == 'date_detail'){
										$allprice = '';
										$amount = 0;
										foreach($tmp [$w] as $dk => $td){
											if($si['related_cal_way'] && $si['related_cal_value']){
												$tmp[$w][$dk]['price'] = round($this->Order_model->cal_related_price($td['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
											} else{
												$tmp[$w][$dk]['price'] = $td['price'];
											}
											$tmp [$w] [$dk] ['nums'] = $tmp['least_num'];
											$allprice .= ',' . $tmp [$w] [$dk] ['price'];
											$amount += $tmp [$w] [$dk] ['price'];
										}

										$local['avg_price'] = number_format($amount / $countday, 1,'.','');
										$local['allprice'] = substr($allprice, 1);
										$local['total'] = intval($amount);
										$local['total_price'] = $local['total'] * 1;
									}
									$local[$w]=$tmp[$w];
//									$data[$room_key]['state_info'][$sik][$w] = $tmp[$w];
								}
							}
							$min_price[]=$local['avg_price'];
							if(!empty($webps[$local['price_code']])){ //外部价格代码名与本地的冲突,将外部的重命名
								$webps[$local['price_code'].'_conflict']=$webps[$local['price_code']];
							}

							unset($webps[$web_rate]);

							$webps[$local['price_code']]=$local;


							/*$local['least_num']=$least_count;
							$local['book_status']=$book_status;
							if(!empty($webps[$local['price_code']])){ //外部价格代码名与本地的冲突,将外部的重命名
								$webps[$local['price_code'].'_conflict']=$webps[$local['price_code']];
							}

							$webps[$local['price_code']]=$local;
							$min_price[]=$local['avg_oprice'];*/
						}
						// unset ( $webps [$code] );
					} else{
						$min_price[] = $webps[$web_rate]['avg_price'];
					}
				}

				if(!empty ($extra [$rm ['room_id']])){
					foreach($extra [$rm ['room_id']] as $dis){
						$code = $dis ['price_code'];
						if(!empty ($webps [$code])){ // 外部价格代码名与本地的冲突,将外部的重命名
							$webps [$code . '_conflict'] = $webps [$code];
						}
						$dis['book_status'] = $book_status;
						if($book_status == 'available' && !empty($dis['least_num'])){
// 						if ($dis ['book_status'] == 'available') {
							$dis ['least_num'] = 1;
						} else{
							$dis['book_status'] = 'full';
							$dis ['least_num'] = 0;
						}
						$webps [$code] = $dis;
						$min_price [] = $dis ['avg_price'];
					}
				}
				if(!empty ($webps)){
					$data [$rm ['room_id']] ['room_info'] = $rm;
					$data [$rm ['room_id']] ['state_info'] = $webps;
					$data [$rm ['room_id']] ['show_info'] = array();
					$data [$rm ['room_id']] ['lowest'] = min($min_price);
					$data [$rm ['room_id']] ['highest'] = max($min_price);
				}
			}
//			echo '<pre>';print_r($data);exit;
		}else{
			$s = $this->get_web_room_status($hotel_no, $startdate, $enddate, $member_type);
			if($s ['Result'] == 1){
				if (!isset($condit ['member_level'])||!empty($level_reflect['no_favour_level'][$condit ['member_level']])){
					$discounts = array();
				}else{
					$discounts = $this->get_rooms_discount($hotel_no, $startdate, $enddate);
				}
				$web_room_list = $s ['Data'] ['RoomList'];
				foreach($web_room_list as $wrl){
					$web_rooms [$wrl ['RoomTypeNo']] = $wrl;
				}
				foreach($rooms as $rm){
					if(empty($web_rooms [$rm ['webser_id']])){
						continue;
					}
					$webps = array();
					$r = $web_rooms [$rm ['webser_id']];
					$least_num = 0;
					$book_status = 'full';
					switch($r ['RoomStatus']){
						case 'False' :
							$least_num = 0;
							$book_status = 'full';
							break;
						case 'True' :
							$least_num = 1;
							$book_status = 'available';
							break;
						default :
							break;
					}
					$min_price = array();

					//获取每日房量
					$daily_qty_list=[];
					if(!empty($condit['is_package'])){
						$daily_qty_list = $this->getDailyQty($pms_set['hotel_web_id'], $rm['webser_id'], $startdate, $enddate,$pms_set['inter_id']);
					}

					foreach($r ['Pricelist'] as $p){
						$amount = 0;
						$code = $p ['RateCode'];
						if($member_type && $p ['RateCode'] == 'RETAIL'){
							continue;
						} else{
							if(empty ($member_type) && $p ['RateCode'] == 'USER'){
								continue;
							}
						}
						$webps [$code] ['price_name'] = $p ['RateCodeName'];
						$webps [$code] ['price_type'] = 'pms';
						$webps [$code] ['extra_info'] = array(
							'type'     => 'code',
							'pms_code' => $p ['RateCodeName']
						);
						$webps [$code] ['price_code'] = $p ['RateCode']; // price_type为pms时，价格代码使用pms_code
						$webps [$code] ['des'] = '';
						$webps [$code] ['sort'] = 0;
						$webps [$code] ['disp_type'] = 'buy';
						$webps [$code] ['related_code'] = '';
						$webps [$code] ['related_des'] = '';
						$webps [$code] ['related_cal_way'] = '';
						$webps [$code] ['related_cal_value'] = 0;
						$webps [$code] ['condition'] = '';
						if($p ['RateCode'] == 'USER'){
							$webps [$code] ['price_name'] = '会员价';
						}
						$date_detail = array();
						$allprice = '';
						foreach($p ['CodePrice'] as $pri){
							$_date=date('Ymd', strtotime($pri ['Date']));
							if(!empty($condit['is_package'])){
								$daily_qty=isset($daily_qty_list[$_date])?$daily_qty_list[$_date]:0;
							}else{
								$daily_qty=$least_num;
							}
							$date_detail [$_date] = array(
								'price' => $pri ['Price'],
								'nums'  => $daily_qty,
							);
							$allprice .= ',' . $pri ['Price'];
							$amount += $pri ['Price'];
						}

						//校验日期价格
						$all_exists=true;
						for($start = date('Ymd', strtotime($startdate)); $start < date('Ymd', strtotime($enddate));){
							if(empty($date_detail[$start])){
								$all_exists=false;
								break;
							}
							$start = date('Ymd', strtotime($start)+86400);
						}

						//是否所有日期都直接价格代码
						if(!$all_exists){
							unset($webps[$code]);
							continue;
						}
						$webps [$code] ['date_detail'] = $date_detail;
						$webps [$code] ['price_resource'] = 'webservice';
						$webps [$code] ['least_num'] = $least_num;
						$webps [$code] ['book_status'] = $book_status;
						$webps [$code] ['allprice'] = substr($allprice, 1);
						$webps [$code] ['total'] = number_format($amount, 1, '.', '');
						$webps [$code] ['total_price'] = number_format($amount, 1, '.', '');
						$webps [$code] ['avg_price'] = number_format($amount / $countday, 1);
						if(!empty ($external [$rm ['room_id']] [$p ['RateCode']])){
							foreach($external [$rm ['room_id']] [$p ['RateCode']] as $local){
								$local ['least_num'] = $least_num;
								$local ['book_status'] = $book_status;
								if(!empty ($webps [$local ['price_code']])){ // 外部价格代码名与本地的冲突,将外部的重命名
									$webps [$local ['price_code'] . '_conflict'] = $webps [$local ['price_code']];
								}
								$webps [$local ['price_code']] = $local;
								$min_price [] = $local ['avg_oprice'];
							}
							// unset ( $webps [$code] );
						} else{
							$min_price [] = $webps [$code] ['avg_price'];
						}
					}

					if(!empty ($discounts [$r ['RoomTypeNo']])){
						foreach($discounts [$r ['RoomTypeNo']] as $dis){
							$code = $dis ['price_code'];
							$webps [$code] = $dis;
							$min_price [] = $dis ['avg_price'];
						}
					}
					if(!empty ($extra [$rm ['room_id']])){
						foreach($extra [$rm ['room_id']] as $dis){
							$code = $dis ['price_code'];
							if(!empty ($webps [$code])){ // 外部价格代码名与本地的冲突,将外部的重命名
								$webps [$code . '_conflict'] = $webps [$code];
							}
							$dis['book_status'] = $book_status;
							if($book_status == 'available' && !empty($dis['least_num'])){
// 						if ($dis ['book_status'] == 'available') {
								$dis ['least_num'] = 1;
							} else{
								$dis['book_status'] = 'full';
								$dis ['least_num'] = 0;
							}
							$webps [$code] = $dis;
							$min_price [] = $dis ['avg_price'];
						}
					}
					if(!empty ($webps)){
						$data [$rm ['room_id']] ['room_info'] = $rm;
						$data [$rm ['room_id']] ['state_info'] = $webps;
						$data [$rm ['room_id']] ['show_info'] = array();
						$data [$rm ['room_id']] ['lowest'] = min($min_price);
						$data [$rm ['room_id']] ['highest'] = max($min_price);
					}
				}
			}
		}
		return $data;
	}

	function get_rooms_discount($hotel_no, $startdate, $enddate){
		$d = $this->get_web_discount($hotel_no, $startdate, $enddate);
		$countday = get_room_night($startdate,$enddate,'ceil');//至少有一个间夜
		$day_diff = round((strtotime($startdate) - strtotime(date('Ymd'))) / 86400);
		$discounts = array();
		if($d ['Result'] == 1){
			$data = $d ['Data'];
			foreach($data as $d){
				$tmp = array();
				// $tmp ['pre_day'] = $d ['preDay'];
				// $tmp ['pre_day'] = 0;
				$tmp ['need_days'] = $d ['liveDays'];

				$tmp ['price_name'] = $d ['pro_Name'];
				$tmp ['price_type'] = 'pms';
				$tmp ['extra_info'] = array(
					'type'     => 'discounts',
					'pms_code' => $d ['proId']
				);
				$tmp ['price_code'] = $d ['proId'];
				$tmp ['des'] = '不可用券';
// 				$tmp ['no_coupon'] = 1;
				$tmp ['sort'] = 0;
				$tmp ['disp_type'] = 'buy';
				$tmp ['related_code'] = '';
				$tmp ['related_des'] = '';
				$tmp ['related_cal_way'] = '';
				$tmp ['related_cal_value'] = 0;
				$tmp ['condition'] = array();
				$tmp ['condition']['no_coupon'] = 1;
				switch($d ['pre_pay']){
					case 'False' :
						$tmp ['condition'] ['pre_pay'] = 0;
						break;
					case 'True' :
						$tmp ['condition'] ['pre_pay'] = 1;
						$tmp ['condition'] ['no_pay_way'] = array(
							'daofu'
						);
						break;
					default :
						break;
				}
				$date_detail = array();
				$allprice = '';
				$dis_price = explode('|', $d ['roomRate']);
				$min_num = array();
				$amount = 0;
				foreach($dis_price as $dp){
					$p_d = explode('#', $dp);
					$date_detail [date('Ymd', strtotime($p_d [0]))] = array(
						'price' => $p_d [2],
						'nums'  => $p_d [1]
					);
					$allprice .= ',' . $p_d [2];
					$amount += $p_d [2];
					$min_num [] = $p_d [1];
				}

				//校验日期价格
				$all_exists=true;
				for($start = date('Ymd', strtotime($startdate)); $start < date('Ymd', strtotime($enddate));){
					if(empty($date_detail[$start])){
						$all_exists=false;
						break;
					}
					$start = date('Ymd', strtotime($start)+86400);
				}

				//是否所有日期都直接价格代码
				if(!$all_exists){
					continue;
				}
				$tmp ['date_detail'] = $date_detail;
				$tmp ['least_num'] = min($min_num);
				if($tmp ['least_num'] > 0 && $d ['canBooked'] == 1){
					$tmp ['book_status'] = 'available';
					$tmp ['least_num'] = 1;
				} else{
					$tmp ['book_status'] = 'full';
				}
				$tmp ['allprice'] = substr($allprice, 1);
				$tmp ['total'] = number_format($amount, 1, '.', '');
				$tmp ['total_price'] = number_format($amount, 1, '.', '');
				$tmp ['avg_price'] = number_format($amount / $countday, 1);
				if(!empty ($d ['preDay']) && $d ['preDay'] != 999 && $d ['preDay'] > $day_diff){
					$tmp ['book_status'] = 'full';
					$tmp ['des'] = '需提前' . $d ['preDay'] . '天预订';
				}
				$discounts [$d ['roomType']] [$d ['proId']] = $tmp;
			}
		}
		return $discounts;
	}

	function get_web_discount($hotel_no, $startdate, $enddate){
		$url = self::DISCOUNT_URL . 'GetDiscounts';
		$data ['hotelCode'] = $hotel_no;
		$data ['checkIn'] = date("Y-m-d", strtotime($startdate));
		$data ['checkOut'] = date("Y-m-d", strtotime($enddate));

		$s = $this->post_to($url, $data);
		return $s;
	}

	function get_web_room_status($hotel_no, $startdate, $enddate, $member_type){
		$url = self::HOTEL_URL . 'GetRoomStatusByHotelNo';
		$data ['hotelNo'] = $hotel_no;
		$data ['checkInDate'] = date('Y-m-d', strtotime($startdate));
		$data ['checkOutDate'] = date('Y-m-d', strtotime($enddate));
		$data ['memberType'] = $member_type;
		$s = $this->post_to($url, $data);
		return $s;
	}

	function order_to_web($inter_id, $orderid, $paras = array(), $pms_set = array()){
		$this->load->model('hotel/Order_model');
		$order = $this->Order_model->get_main_order($inter_id, array(
			'orderid' => $orderid,
			'idetail' => array(
				'i'
			)
		));
		if(!empty ($order)){
			$order = $order [0];
			if($order['price_type']=='athour'){
				$result=$this->addClockOrder($order,$pms_set,$paras);
				if($result['result']){
					$web_orderid=$result['web_orderid'];
					$this->db->where(array(
						                 'orderid'  => $order ['orderid'],
						                 'inter_id' => $order ['inter_id']
					                 ));
					$this->db->update('hotel_order_additions', array(
						'web_orderid' => $web_orderid
					));
					$this->db->where(array(
						                 'orderid'  => $order ['orderid'],
						                 'inter_id' => $order ['inter_id'],
						                 'id'       => $order ['first_detail'] ['id']
					                 ));
					$this->db->update('hotel_order_items', array(
						'webs_orderid' => $web_orderid
					));
					if($order ['status'] != 9){
						$this->db->where(array(
							                 'orderid'  => $order ['orderid'],
							                 'inter_id' => $order ['inter_id']
						                 ));
						$this->db->update('hotel_orders', array(
							'status' => 1
						));
						$this->Order_model->handle_order($inter_id, $orderid, 1);
					}
					if(!empty ($paras ['trans_no'])){
						$this->add_web_bill($web_orderid, $order, $paras ['trans_no']);
					}
					return array(
						's' => 1
					);
				}else{
					$this->db->where(array(
						                 'orderid'  => $order ['orderid'],
						                 'inter_id' => $order ['inter_id']
					                 ));
					$this->db->update('hotel_orders', array(
						'status' => 10
					));
					return array(
						's'      => 0,
						'errmsg' => '提交订单失败。'
					);
				}
			}else{

				$hotel_no = $pms_set ['hotel_web_id'];
				$room_codes = json_decode($order ['room_codes'], true);
				$room_codes = $room_codes [$order ['first_detail'] ['room_id']];
				$remark = '微信订单。';
				if($room_codes ['code'] ['price_type'] == 'pms'){
					if($room_codes ['code'] ['extra_info'] ['type'] == 'discounts'){
						$url = self::DISCOUNT_URL . 'MakeDisCountOrder';
						$data ['proID'] = $room_codes ['code'] ['extra_info'] ['pms_code'];
					} else{
						if($order ['coupon_used'] == 0){
							$url = self::HOTEL_URL . 'AddReservation';
						} else{
							if($order ['coupon_used'] == 1){
								$url = self::HOTEL_URL . 'AddReservationNew';
								$voucher = json_decode($order ['coupon_des'], true);
								$c = '';
								if(!empty ($voucher ['cash_token'])){
									foreach($voucher ['cash_token'] as $v){
										$c .= '|' . $v ['voucher_amount'];
									}
									$c = substr($c, 1);
								}
								$data ['coupons'] = $c;
							} else{
								if($order ['coupon_used'] == 2){
									$url = self::COUPON_URL . 'AddReservation';
									$voucher = json_decode($order ['coupon_des'], true);
									if(!empty ($voucher ["cash_token"])){
										$data ['couponsNo'] = $voucher ["cash_token"] [0] ['code'];
									}
									$data ['type'] = 0;
								}
							}
						}
					}
				} else{
					$url = self::HOTEL_URL . 'AddReservationNew';
					$voucher = json_decode($order ['coupon_des'], true);
					$c = '';
					if(!empty ($voucher ['cash_token'])){
						foreach($voucher ['cash_token'] as $v){
							$c .= '|' . $v ['voucher_amount'];
						}
						$c = substr($c, 1);
					}
					$data ['coupons'] = $c;
					$remark .= '微信自定义价格：' . $order ['first_detail'] ['price_code_name'];
				}
				$data ['hotelNo'] = $hotel_no;
				$data ['checkInDate'] = date('Y-m-d', strtotime($order ['startdate']));
				$data ['checkOutDate'] = date('Y-m-d', strtotime($order ['enddate']));
				$rates = '';
				$countday = get_room_night($order ['startdate'], $order ['enddate'], 'ceil', $order);//至少有一个间夜
				$all_p = explode(',', $order ['first_detail'] ['allprice']);
				for($i = 0; $i < $countday; $i++){
					$tmpdate = date('Y-m-d', strtotime("+ $i day", strtotime($order ['startdate'])));
					if($i == 0){
						$rates .= '|' . $tmpdate . '#' . ($all_p [$i] - $order ['coupon_favour']);
					} else{
						$rates .= '|' . $tmpdate . '#' . $all_p [$i];
					}
				}
				$rates = substr($rates, 1);
				$data ['roomRate'] = $rates; // 日期#价格|日期#价格
				$data ['totalPrice'] = intval($order ['price']);
				$data ['roomTypeNo'] = $room_codes ['room'] ['webser_id'];
				$data ['roomCount'] = 1;
				$data ['bookerName'] = $order ['name'];
				$data ['bookerTel'] = $order ['tel'];
				$data ['bookerEmail'] = '';
				$data ['bookerMebNo'] = '';
				$data ['bookerMebNo'] = $order ['member_no'];
				$data ['remarks'] = $remark;
				$s = $this->post_to($url, $data);
				if($s ['Result'] == 1){ // 把订单数据保存到本地
					$web_orderid = $s ['Data'] ['confirmNo'];
					$this->db->where(array(
						                 'orderid'  => $order ['orderid'],
						                 'inter_id' => $order ['inter_id']
					                 ));
					$this->db->update('hotel_order_additions', array(
						'web_orderid' => $web_orderid
					));
					$this->db->where(array(
						                 'orderid'  => $order ['orderid'],
						                 'inter_id' => $order ['inter_id'],
						                 'id'       => $order ['first_detail'] ['id']
					                 ));
					$this->db->update('hotel_order_items', array(
						'webs_orderid' => $web_orderid
					));
					if($order ['status'] != 9){
						$this->db->where(array(
							                 'orderid'  => $order ['orderid'],
							                 'inter_id' => $order ['inter_id']
						                 ));
						$this->db->update('hotel_orders', array(
							'status' => 1
						));
						$this->Order_model->handle_order($inter_id, $orderid, 1);
					}
					if(!empty ($paras ['trans_no'])){
						$this->add_web_bill($web_orderid, $order, $paras ['trans_no']);
					}
					return array(
						's' => 1
					);
				} else{
					$this->db->where(array(
						                 'orderid'  => $order ['orderid'],
						                 'inter_id' => $order ['inter_id']
					                 ));
					$this->db->update('hotel_orders', array(
						'status' => 10
					));
					return array(
						's'      => 0,
						'errmsg' => '提交订单失败。' . $s ['Message']
					);
				}
			}
		}
		return array(
			's'      => 0,
			'errmsg' => '提交订单失败'
		);
	}

	function get_hotel_web_coupon($hotel_no, $card_no, $ajax = 1){
		$coupons = $this->web_hotel_coupons($hotel_no, $card_no);
		$datas = array();
		if($coupons ['Result'] == 1 && $coupons ['Data']){
			foreach($coupons ['Data'] as $c){
				$data = array();
				$data ['voucherid'] = $c ['CouponsNo'];
				$data ['amount'] = $c ['CouponsPrice'];
				$data ['validtime'] = $c ['Exptime'];
				if($ajax == 1){
					$datas [] = $data;
				} else{
					$datas [$c ['CouponsNo']] = $data;
				}
			}
		}
		return $datas;
	}

	function web_hotel_coupons($hotel_no, $card_no){
		$url = self::COUPON_URL . 'GetCouponsByCardNo';
		$data ['hotelNo'] = $hotel_no;
		$data ['cardNo'] = $card_no;
		$s = $this->post_to($url, $data);
		return $s;
	}

	function add_web_bill($web_orderid, $order, $trans_no = ''){
		$url = self::DISCOUNT_URL . 'DepositOrder';
		$data ['orderNo'] = $web_orderid;
		$data ['account'] = floatval($order ['price']);
		$data ['mobile'] = $order ['orderid'];
		$s = $this->post_to($url, $data);
		if($s ['Result'] == 1){
			$this->db->where(array(
				                 'orderid'  => $order ['orderid'],
				                 'inter_id' => $order ['inter_id']
			                 ));
			$this->db->update(self::TAB_HOA, array(
				'web_paid' => 1
			));
			return true;
		}
		$this->db->where(array(
			                 'orderid'  => $order ['orderid'],
			                 'inter_id' => $order ['inter_id']
		                 ));
		$this->db->update(self::TAB_HOA, array(
			'web_paid' => 2
		));
		return false;
	}

	function get_web_order_on($web_orderid, $tel = ''){
		$url = self::HOTEL_URL . 'QueryReservation';
		$data ['confirmNo'] = $web_orderid;
		$data ['bookerTel'] = $tel; // 不传也可
		$s = $this->post_to($url, $data);
		return $s;
	}

	public function getContinueTime($web_orderid){
		$url=self::MEMBER_URL.'QueryContinue';
		$data['orderNo']=$web_orderid;
		$s=$this->post_to($url,$data);
		return $s;
	}

	function get_member_web_order($member_no, $status = 0, $num = 10, $offset = 1){
		$url = self::MEMBER_URL . 'QueryRes';
		$data ['mebNo'] = $member_no;
		$data ['pageIndex'] = $offset;
		$data ['pageSize'] = $num;
		$data ['resState'] = $status;
		$s = $this->post_to($url, $data);
		$order = array();
		if($s ['Result'] == 1){
			foreach($s ['Data'] as $d){
				$order [] = $d;
			}
			$order = array_reverse($order);
		}
		return $order;
	}

	function yibo_status_reflect(){
		return array(
			'C' => 5,
			'R' => 1,
			'N' => 8,
			'L' => 3,
			'S' => 2
		);
	}

	function yibo_status_hour(){
		//订单状态,0预订，1确认，2入住，3离店，4用户取消，5酒店取消,6酒店删除，7异常，8未到，9待支付

		return [
			0=>0,
		    1=>5,
		    2=>1,
		    3=>2,
		    4=>8,
		    5=>5,
		    6=>5,
		    7=>3
		];
	}

	/**
	 * @param unknown $list
	 * @return NULL|number|unknown
	 */
	function update_web_order($inter_id, $list){
		$new_status = null;
		if($list['price_type']=='athour'){
			$status_arr=$this->yibo_status_hour();
			$web_order=$this->getClockOrderDetail($list['web_orderid'],$inter_id);
			if($web_order){
				$new_status=$status_arr[$web_order['ClockStatus']];
				$od=end($list['order_details']);
				if($od['istatus'] == 4 && $new_status == 5){
					$new_status = 4;
				}
				$updata=[];
				//只同步状态，
				if(!empty($new_status)&&$new_status != $od['istatus']){
					$updata['istatus']=$new_status;
				}

				if(!empty($updata)){
					$this->load->model('hotel/Order_model');
					$this->Order_model->update_order_item($inter_id, $list['orderid'], $od['sub_id'], $updata);
				}

			}
		}else{
			$status_arr = $this->yibo_status_reflect();
			$s = $this->get_web_order_on($list ['web_orderid'], $list ['tel']);
			if($s ['Result'] == 1){

				$new_status = $status_arr [$s ['Data'] ['ResState']];
				$od=end($list['order_details']);
				if($od['istatus'] == 4 && $new_status == 5){
					$new_status = 4;
				}
				$updata=[];

				if(in_array($new_status,[1,2,3])){
					//查询续住信息
					$continue_res=$this->getContinueTime($list['web_orderid']);
					if($continue_res['Result']==1&&!empty($continue_res['Data'])){
						$res=$continue_res['Data'];
						$web_end = date('Ymd', strtotime($res['CheckOutDate']));
						$ori_end=date('Ymd',strtotime($od['enddate']));
						$updata['startdate']=$od['startdate'];
						$updata['enddate']=$web_end;
						if($web_end!=$ori_end){
							$updata['no_check_date']=1;
						}
						$price_list=$res['PriceList'];
						$new_price=0;
						foreach($price_list as $v){
							$new_price+=$v['RoomRate'];
						}
						if($new_price>=0&&$new_price!=$od['iprice']){
							$updata['new_price']=$new_price;
							$updata['no_check_date']=1;
						}
					}
				}

				//增加IsValid判断，离店状态但IsValid为0的，即为离店无效的状态，取消之
				if($new_status == 3 && isset($s ['Data'] ['IsValid']) && $s ['Data'] ['IsValid'] == 0){
					$this->db->where(array(
						                 'inter_id' => $list ['inter_id'],
						                 'orderid'  => $list ['orderid']
					                 ));
					$this->db->update('hotel_order_items', array(
						'istatus' => 1
					));
					$new_status = 5;
				}

				if(!empty($new_status)&&$new_status != $od['istatus']){
					/*$this->load->model('hotel/Order_model');
					$this->db->where(array(
										 'inter_id' => $list ['inter_id'],
										 'orderid'  => $list ['orderid']
									 ));
					$this->db->update('hotel_orders', array(
						'status' => $new_status
					));
					$this->Order_model->handle_order($inter_id, $list ['orderid'], $new_status, $list ['openid']);*/
					$updata['istatus']=$new_status;
				}
				if(!empty($updata)){
					$this->load->model('hotel/Order_model');
					$this->Order_model->update_order_item($inter_id, $list['orderid'], $od['sub_id'], $updata);
				}
			}
		}

		return $new_status;
	}

	function cancel_order($inter_id, $order){
		if($order['price_type']=='athour'){
			$result=$this->cancelClockOrder($order['web_orderid'],$inter_id);
			if($result){
				return [
					's'      => 1,
					'errmsg' => '取消成功'
				];
			}
		}else{
			$url = self::HOTEL_URL . 'CancelReservation';
			$data ['confirmNo'] = $order ['web_orderid'];
			$data ['bookerTel'] = $order ['tel'];
			$s = $this->post_to($url, $data);
			if($s ['Result'] == 1 || is_null($s)){
				return array(
					's'      => 1,
					'errmsg' => '取消成功'
				);
			}
		}

		return array(
			's'      => 0,
			'errmsg' => '取消失败'
		);
	}

	/**获取会员积分详情
	 * @param unknown $member_no
	 * @param number  $offset
	 * @param number  $nums
	 * @return number[]|mixed[]|unknown[]
	 */
	function web_point($member_no, $offset = 1, $nums = 10){
		$url = self::MEMBER_URL . 'QueryPoints';
		$data ['mebNo'] = $member_no;
		$data ['pageIndex'] = $offset;
		$data ['pageSize'] = $nums;
		$s = $this->post_to($url, $data);
		$result = array();
		if($s ['Result'] == 1){
			$result ['s'] = 1;
			if($s ['Data']){
				$result ['total_point'] = $s ['Data'] ['TotalAmount'];
				$valid_point = 0;
				foreach($s ['Data'] ['PointsList'] as $p){
					$tmp = array();
					$tmp ['valid_amount'] = $p ['AvailableAmount'];
					$tmp ['create_time'] = $p ['CreateTime'];
					$tmp ['valid_time'] = $p ['DeadLine'];
					$tmp ['point_type'] = $p ['PointType'];
					$valid_point += $tmp ['valid_amount'];
					$result ['point_list'] [] = $tmp;
				}
				$result ['valid_point'] = $valid_point;
			} else{
				$result = array(
					's'           => 0,
					'total_point' => -1,
					'valid_point' => -1,
					'errmsg'      => $s ['Message']
				);
			}
		} else{
			$result = array(
				's'           => 0,
				'total_point' => -1,
				'valid_point' => -1,
				'errmsg'      => $s ['Message']
			);
		}
		return $result;
	}

	function web_coupon($member_no, $get_detail = false){
		$url = self::COUPON_URL . 'GetCoupons';
		$data ['cardNo'] = $member_no;
		$s = $this->post_to($url, $data);
		$result = array();
		if($s ['Result'] == 1){
			$result ['s'] = 1;
			$total_count = 0;
			$valid_count = 0;
			if($s ['Data']){
				foreach($s ['Data'] as $d){
					if($get_detail == true){
						$tmp = array();
						$tmp ['coupon_no'] = $d ['CouponsNo'];
						$tmp ['amount'] = $d ['CouponsPrice'];
						$tmp ['is_valid'] = $d ['IsUse'];
						$tmp ['valid_time'] = $d ['Exptime'];
						$tmp ['brand_type'] = $d ['BrandType'];
						$result ['coupon_list'] [] = $tmp;
					}
					if($d ['IsUse'] == 0){
						$valid_count++;
					}
					$total_count++;
				}
			}
			$result ['valid_count'] = $valid_count;
			$result ['total_count'] = $total_count;
		} else{
			$result = array(
				's'           => 0,
				'valid_count' => 0,
				'total_count' => 0,
				'errmsg'      => $s ['Message']
			);
		}
		return $result;
	}

	function post_to($url, $data, $inter_id = 'a441098524'){
		$data ['token'] = self::YIBO_TOKEN;
		$this->load->helper('common');
		$send_content = http_build_query($data);
		$now = time();
		$s = doCurlPostRequest($url, $send_content, array(), 10);

		$this->load->model('common/Webservice_model');
		$this->Webservice_model->add_webservice_record($inter_id, 'yibo', $url, $data, $s,'query_post', $now, microtime (), $this->session->userdata ( $inter_id . 'openid' ));

		$s = json_decode($this->json_clear($s), true);
		return $s;
	}

	function get_to($url, $data, $inter_id = 'a441098524'){
		$data ['token'] = self::YIBO_TOKEN;
		$this->load->helper('common');
		$r_url = $url;
		$now = time();
		$s = doCurlGetRequest($url, $data, 10);

		$this->load->model('common/Webservice_model');
		$this->Webservice_model->add_webservice_record($inter_id, 'yibo', $r_url, $data, $s,'query_get', $now, microtime (), $this->session->userdata ( $inter_id . 'openid' ));

		$s = json_decode($this->json_clear($s), true);
		return $s;
	}

	function json_clear($s){
		if(!json_decode($s)){
			$s = preg_replace('/,\s*([\]}])/m', '$1', $s);
			$s = str_replace("\n", ' ', $s);
			$s = str_replace("\t", ' ', $s);
			$s = str_replace("\r", ' ', $s);
			$s = str_replace("\\", ' ', $s);
			$s = preg_replace("/\t/", " ", $s);
			$s = preg_replace("/\n/", " ", $s);
			$s = preg_replace("/\r/", " ", $s);
			$s = str_replace("'", '"', $s);
			$s = trim($s, chr(239) . chr(187) . chr(191));
			$n = strlen($s);
			for($i = 0; $i < $n; $i++){
				if($s [$i] == ':' && $s [$i + 1] == '"'){
					for($j = $i + 2; $j < $n; $j++){
						if($s [$j] == '"'){
							if($s [$j + 1] != ',' && $s [$j + 1] != '}'){
								$s [$j] = 'y';
							} else{
								if($s [$j + 1] == ',' || $s [$j + 1] == '}'){
									break;
								}
							}
						}
					}
				}
			}
		}
		return $s;
	}

	protected function postService($func, $params = array(),$inter_id='a441098524'){
		$this->load->model('common/Webservice_model');
		$this->load->helper('common');
		$time=time();
		try{
			$soap_opt = array(
				'soap_version' => SOAP_1_1,
				'encoding'     => 'UTF-8',
			);
			$soap = new SoapClient(self::CLOCK_URL, $soap_opt);
			$result = $soap->__soapCall($func, array(
				'parameters' => $params,
			));

			$this->Webservice_model->add_webservice_record($inter_id, 'yibo', self::CLOCK_URL, [$func,$params], $result,'query_post', $time, microtime (), $this->session->userdata ( $inter_id . 'openid' ));

			if(!empty($result->{$func . 'Result'})){
				return xml2array($result->{$func . 'Result'});
			}
		} catch(SoapFault $er){
			$this->Webservice_model->add_webservice_record($inter_id, 'yibo', self::CLOCK_URL, [$func,$params], $er,'query_post', $time, microtime (), $this->session->userdata ( $inter_id . 'openid' ));
		}
		return array();
	}

	protected function getClockRoomStatus($hotel_web_id,$inter_id=''){
		$data=array(
			'hotelCode'=>$hotel_web_id,
		);
		$result=[];
		$qty_arr=$this->postService('GetSalesQuantity',$data,$inter_id);
		if(!empty($qty_arr['Quantity'])){
			$qty_list=$qty_arr['Quantity'];
			is_array(current($qty_list)) or $qty_list=[$qty_list];
			foreach($qty_list as $v){
				$result[$v['RoomType']]['quantity'][]=$v;
			}
		}

		$price_arr=$this->postService('GetClockPrice',$data,$inter_id);
		if(!empty($price_arr['Price'])){
			$price_list=$price_arr['Price'];
			is_array(current($price_list)) or $price_list=[$price_list];
			foreach($price_list as $v){
				$result[$v['RoomType']]['rate']['clock_'.$v['ClockHour']]=$v;
			}
		}

		return $result;

	}

	protected function addClockOrder($order, $pms_set, $params = []){
		$room_codes = json_decode($order ['room_codes'], true);
		$room_codes = $room_codes [$order ['first_detail'] ['room_id']]; //$room_codes 结构：array('本地room_id'=>array('room'=>array('webser_id'=>房型代码),'code'=>array($extra_info(就是取房态时的 extra_info),'price_type'=>'价格类型')))
		$extra_info = $room_codes['code']['extra_info'];
//		print_r($extra_info);exit;
		list($tmp,$hour)=explode('_',$extra_info['pms_code'],2);

		$remark = '';
		if($order ['coupon_favour'] > 0){
			$remark .= '使用优惠券：' . $order ['coupon_favour'] . '元。';
		}

		$order_param=[
			'medinum'=>'100710',
		    'hotelCode'=>$pms_set['hotel_web_id'],
		    'roomType'=>$room_codes['room']['webser_id'],
		    'guestName'=>$order['name'],
		    'mobile'=>$order['tel'],
		    'checkInTime'=>date('Y-m-d H:i',strtotime($order['starttime'])),
		    'hour'=>$hour,
		    'price'=>$order['price'],
		    'roomcount'=>$order['roomnums'],
		    'earliest'=>date('H:i',strtotime($order['starttime'])),
		    'latest'=>date('H:i',strtotime($order['starttime'])+3600),
		    'remark'=>$remark,
		];

		$result=$this->postService('ClockBook',$order_param,$pms_set['inter_id']);
		if(!empty($result['ReturnInfo']['OrderNo'])){
			return [
				'result'      => true,
				'web_orderid' => $result['ReturnInfo']['OrderNo'],
			];
		}
		return [
			'result'=>false,
		];
	}

	public function cancelClockOrder($web_orderid,$inter_id=''){
		$param=['orderNo'=>$web_orderid];
		$result=$this->postService('CancelClockOrder',$param,$inter_id);
		if($result['ReturnInfo']['IsSuccess']=='True'){
			return true;
		}
		return false;
	}

	public function getClockOrderDetail($web_orderid,$inter_id=''){
		$param=['orderNo'=>$web_orderid];
		$result=$this->postService('GetClockOrderDetail',$param,$inter_id);
		if(!empty($result['OrderInfo'])){
			return $result['OrderInfo'];
		}
		return [];
	}

	public function getDailyQty($hotel_web_id, $webser_id, $startdate, $enddate,$inter_id=''){
		$startdate=date('Y-m-d',strtotime($startdate));
		$enddate=date('Y-m-d',strtotime($enddate));

		$params=[
			'hotelCode'=>$hotel_web_id,
			'roomType'=>$webser_id,
			'startTime'=>$startdate,
			'endTime'=>$enddate,
		];
		$url=self::MEMBER_URL.'QueryCheckOutTimeByOrderNo';
	    $res=$this->post_to($url,$params,$inter_id);
	    $result=[];
	    if($res['Result']==1&&!empty($res['Data'])){
	    	foreach($res['Data'] as $v){
	    		$date_str=date('Ymd',strtotime($v['RateDate']));
	    		$result[$date_str]=$v['Count'];
			}
		}
		return $result;
	}

	//判断订单是否能支付
	function check_order_canpay($list){
		$s = $this->get_web_order_on($list ['web_orderid'], $list ['tel']);
		if($s ['Result'] == 1){
			$status_arr = $this->yibo_status_reflect();
			$new_status = $status_arr [$s ['Data'] ['ResState']];
		}
		if(isset($new_status) && ($new_status == 1 || $new_status == 0)){//订单预定或确认
			return true;
		}else{
			return false;
		}
	}

	function order_checkin_type($web_orderid){
		$continue_res=$this->getContinueTime($web_orderid);
		if($continue_res['Result']==1&&!empty($continue_res['Data'])){
			$res=$continue_res['Data'];
			if ($res['IsSame']=='true'){
				return 'self';
			}else{
				return 'other';
			}
		}
		return 'unkown';
	}

	private function readDB(){
		static $db_read;
		if(!$db_read){
			$db_read = $this->load->database('iwide_r1',true);
		}
		return $db_read;
	}

}