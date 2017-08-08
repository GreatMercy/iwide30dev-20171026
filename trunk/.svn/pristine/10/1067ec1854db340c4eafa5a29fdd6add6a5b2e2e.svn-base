<?php
// if (! defined ( 'BASEPATH' ))
// exit ( 'No direct script access allowed' );
class Trans extends MY_Controller {
	function __construct() {
		parent::__construct ();
		error_reporting ( E_ALL );
		ini_set ( 'display_errors', 1 );
		set_time_limit ( 0 );
		$this->output->enable_profiler ( FALSE );
	}
    function rr(){
        $this->load->helper('common_helper');
        $this->load->helper('common');
        echo createNoncestr();
    }
	function tran_hotels() {
		exit ();
		$inter_id = 'a433320892';
		
		$sql = "SELECT * FROM `iwide_tmp_hotels` where inter_id='$inter_id'";
		$old_hotels = $this->db->query ( $sql )->result_array ();
		
		$old_rooms = array ();
		$sql = "SELECT * FROM `iwide_tmp_hotels_rooms`  where inter_id='$inter_id'";
		$old_rooms = $this->db->query ( $sql )->result_array ();
		
		$datas = array ();
		
		$addition = array ();
		// $addition = array (
		// 'inter_id' => $inter_id,
		// 'pms_type' => 'zhongruan',
		// 'pms_auth' => '{"url":"http:\/\/218.13.33.122:8089\/webservice\/Interface.asmx?wsdl","user":"crs1","pwd":"crs1","lang":"CN","channel":"WX","rp_nm":"01","crdt_cd":"CA"}',
		// 'pms_room_state_way' => 1,
		// 'pms_member_way' => 1
		// );
		
		$datas ['additions'] = $addition;
		$datas ['old_rooms'] = $old_rooms;
		$datas ['hotel_id'] = 1152;
		$datas ['room_id'] = 4352;
// 	var_dump($old_hotels);exit;	
		$this->hotel_trans ( $inter_id, $old_hotels, $datas );
	}
	function hotel_trans($inter_id, $old_hotels, $datas = array()) {
		$hotel_rooms = array ();
		if (! empty ( $datas ['old_rooms'] )) {
			foreach ( $datas ['old_rooms'] as $or ) {
				$hotel_rooms [$or ['hotel_id']] [] = $or;
			}
		}
		$hotel_id = empty ( $datas ['hotel_id'] ) ? 0 : $datas ['hotel_id'];
		$room_id = empty ( $datas ['room_id'] ) ? 0 : $datas ['room_id'];
		$prefix = 'http://file.iwide.cn/public/uploads/' . date ( 'Ym' ) . '/';
		$data = array (
				'inter_id' => $inter_id 
		);
		$addition = empty ( $datas ['additions'] ) ? array () : $datas ['additions'];
		$status_arr = array (
				'0' => 1,
				'1' => 2,
				'2' => 3 
		);
		$room = array (
				'inter_id' => $inter_id 
		);
		$addition_count = 0;
		$hotel_count = 0;
		$room_count = 0;
		foreach ( $old_hotels as $oh ) {
			$data ['latitude'] = $oh ['longitude'];
			$data ['longitude'] = $oh ['latitude'];
			$data ['address'] = $oh ['address'];
			$data ['tel'] = $oh ['tel'];
			$data ['name'] = $oh ['name'];
			$data ['hotel_id'] = empty ( $hotel_id ) ? $oh ['hotel_id'] : $hotel_id;
			
			$data ['intro'] = $oh ['intro'];
			$data ['email'] = $oh ['email'];
			$data ['fax'] = $oh ['fax'];
			$data ['star'] = $oh ['star'] == 99 ? 0 : $oh ['star'];
			$data ['country'] = $oh ['country'];
			$data ['province'] = $oh ['province'];
			$data ['web'] = $oh ['web'];
			$data ['city'] = $oh ['city'];
			$data ['intro_img'] = empty ( $oh ['intro_img'] ) ? '' : $prefix . $this->GrabImage ( trim ( $oh ['intro_img'] ), $inter_id . 'hi_' . $data ['hotel_id'] );
			$data ['status'] = $status_arr [$oh ['status']];
			$this->db->insert ( 'hotels', $data );
			$hotel_count ++;
			if (! empty ( $addition ) && ! empty ( $oh ['webser_id'] )) {
				$addition ['hotel_id'] = $data ['hotel_id'];
				$addition ['hotel_web_id'] = $oh ['webser_id'];
				$this->db->insert ( 'hotel_additions', $addition );
				$addition_count ++;
				if ($addition_count == 0) {
					$addition ['hotel_id'] = 0;
					$addition ['hotel_web_id'] = '';
					$this->db->insert ( 'hotel_additions', $addition );
				}
			}
			$room ['hotel_id'] = $data ['hotel_id'];
			if (! empty ( $hotel_id ))
				$hotel_id ++;
			if (! empty ( $hotel_rooms [$oh ['hotel_id']] )) {
				foreach ( $hotel_rooms [$oh ['hotel_id']] as $hr ) {
					$room ['name'] = $hr ['name'];
					$room ['room_id'] = empty ( $room_id ) ? $hr ['room_id'] : $room_id;
					$room ['price'] = $hr ['price'];
					$room ['oprice'] = $hr ['vprice'];
					$room ['description'] = $hr ['description'];
					$room ['nums'] = $hr ['nums'];
					$room ['bed_num'] = $hr ['bed_num'];
					$room ['area'] = $hr ['area'];
					$room ['room_img'] = empty ( $hr ['room_img'] ) ? '' : $prefix . $this->GrabImage ( trim ( $hr ['room_img'] ), $inter_id . 'hri_' . $room ['room_id'] );
					$room ['status'] = $hr ['status'] == 0 ? 1 : 2;
					$room ['webser_id'] = $hr ['webser_id'];
					$room ['sort'] = $hr ['sort'];
					$this->db->insert ( 'hotel_rooms', $room );
					if (! empty ( $room_id ))
						$room_id ++;
					$room_count ++;
				}
			}
		}
		echo 'hotel_count:' . $hotel_count . '<br />';
		echo 'addition_count:' . $addition_count . '<br />';
		echo 'room_count:' . $room_count . '<br />';
	}
	// update `iwide_hotel_rooms` set room_img =concat( 'http://file.iwide.cn/public/uploads/201603/a426755343hri_',hotel_id,'_',room_id,'.jpg') WHERE `inter_id` LIKE 'a426755343'
	function trans_room_shortimg() {
		set_time_limit ( 0 );
		$inter_id = 'a433320892';
		
		$room_reflect=array();
		$sql="SELECT * FROM `iwide_tmp_hotels_rooms` WHERE `inter_id` LIKE '$inter_id'";
		$rooms=$this->db->query($sql)->result_array();
		$room_id=4352;
		foreach ($rooms as $r){
			$room_reflect[$r['room_id']]=$room_id;
			$room_id++;
		}
		$sql = "SELECT * FROM `iwide_tmp_hotels_rooms_image` where inter_id='$inter_id' and type=1";
		$imgs = $this->db->query ( $sql )->result_array ();
// 		var_dump($imgs);exit;
		$prefix = 'http://file.iwide.cn/public/uploads/' . date ( 'Ym' ) . '/';
		foreach ( $imgs as $i ) {
			$intro_img = empty ( $i ['image_url'] ) ? '' : $prefix . $this->GrabImage ( trim ( $i ['image_url'] ), $inter_id . 'hri_' . $i ['hotel_id'] . '_' . $i ['room_id'] );
			echo $this->db->update_string('hotel_rooms',array('room_img'=>$intro_img),array('room_id'=>$room_reflect[$i['room_id']],'inter_id'=>$inter_id)).';<br />';
		}
// 		echo 'ok';
	}
	public function GrabImage($url, $filename = "") {
		if ($url == "")
			return false;
		
		$ext = strrchr ( $url, "." );
		if ($filename == "") {
			$filename = date ( 'YmdHis' ) . rand ( 10, 99 ) . $ext;
		}
		$filename .= $ext;
		
		ob_start ();
		readfile ( $url );
		$img = ob_get_contents ();
		ob_end_clean ();
		$size = strlen ( $img );
		
		$fp2 = @fopen ( $filename, "a" );
		fwrite ( $fp2, $img );
		fclose ( $fp2 );
		
		return $filename;
	}
	function img_test(){
		$this->GrabImage('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQGi8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0NFaEFScFBsWkNBZG16b0hNbVJtAAIEBfmQVQMEAAAAAA==');
	}
	function bgy_trans_order() {
		exit ();
		set_time_limit ( 0 );
		ini_set ( 'memory_limit', '1280M' );
		$inter_id = 'a421641095';
		$select = ' hotel_id,room_id,openid,price,roomnums,name,tel,time,startdate,enddate,paid,orderid,status,holdtime,allprice,paytype,voucherused,vouchertotal,isdel,operate_reason,web_orderid,wxpay_reduce,rp_cd,handled ';
		$sql = "SELECT $select FROM `iwide_tmp_bgy_hotels_order` where inter_id = '$inter_id' and roomnums > 0 ";
		$old_order = $this->db->query ( $sql )->result_array ();
		// var_dump($old_order);exit;
		$this->db->select ( 'room_id,name' );
		$this->db->where ( array (
				'inter_id' => $inter_id 
		) );
		$rooms = $this->db->get ( 'hotel_rooms' )->result_array ();
		// $room_reflect=json_decode('{"1267":3545,"1268":3546,"1269":3547,"1270":3548,"1271":3549,"1272":3550,"1273":3551}',TRUE);
		// $room_reflect=array_flip($room_reflect);
		// $room_names = array ('0'=>array('name'=>'无'));
		foreach ( $rooms as $r ) {
			$room_names [$r ['room_id']] = $r;
		}
		// var_dump ( $room_names );
		// exit ();
		$orders = array ();
		$order_additions = array ();
		$order_items = array ();
		$tmp_order = array (
				'inter_id' => $inter_id 
		);
		$tmp_addition = array (
				'inter_id' => $inter_id 
		);
		$tmp_item = array (
				'inter_id' => $inter_id 
		);
		$paytype = array (
				'0' => 'daofu',
				'1' => 'weixin' 
		);
		$handled_status = array (
				3,
				4,
				5,
				8 
		);
		// $code_name = '微信价(2.0)';
		$code_name = array (
				'01' => '直销价',
				'03' => '直销价',
				'08' => '直销预付价-含双早',
				'09' => '直销预付价-无早',
				'10' => '直销现付价-含双早',
				'11' => '直销现付价',
				'16' => '直销预付',
				'31' => '钻石会银卡会员',
				'32' => '钻石会金卡会员',
				'33' => '钻石会黑卡会员' 
		);
		// 01 直销价,
		// 03 直销价,
		// 08 直销预付价-含双早,
		// 09 直销预付价-无早,
		// 10 直销现付价-含双早,
		// 11 直销现付价,
		// 16 直销预付,
		// 31 钻石会银卡会员,
		// 32 钻石会金卡会员,
		// 33 钻石会黑卡会员
		$order_id = 142151;
		$addition_id = 142151;
		$item_id = 150651;
		foreach ( $old_order as $oo ) {
			$tmp_order ['id'] = $order_id;
			$order_id ++;
			$tmp_order ['hotel_id'] = $oo ['hotel_id'];
			$tmp_order ['openid'] = $oo ['openid'];
			$tmp_order ['price'] = $oo ['price'];
			if ($oo ['paid'] == 1 && ! empty ( $oo ['wxpay_reduce'] )) {
				$tmp_addition ['wxpay_favour'] = $oo ['wxpay_reduce'];
				$tmp_order ['price'] -= $oo ['wxpay_reduce'];
			} else {
				$tmp_addition ['wxpay_favour'] = 0;
			}
			$tmp_order ['roomnums'] = $oo ['roomnums'];
			$tmp_order ['name'] = $oo ['name'];
			$tmp_order ['tel'] = $oo ['tel'];
			$tmp_order ['order_time'] = strtotime ( $oo ['time'] );
			$tmp_order ['startdate'] = $oo ['startdate'];
			$tmp_order ['enddate'] = $oo ['enddate'];
			$tmp_order ['paid'] = $oo ['paid'];
			$tmp_order ['orderid'] = $oo ['orderid'];
			$tmp_order ['status'] = $oo ['status'];
			$tmp_order ['holdtime'] = $oo ['holdtime'];
			$tmp_order ['paytype'] = $paytype [$oo ['paytype']];
			$tmp_order ['operate_reason'] = empty ( $oo ['operate_reason'] ) ? '' : $oo ['operate_reason'];
			$tmp_order ['member_no'] = '';
			$tmp_order ['handled'] = $oo ['handled'];
			// $handled = 0;
			// if (in_array ( $oo ['status'], $handled_status ))
			// $handled = 1;
			$sub_orders = $this->get_sub_order ( $inter_id, $oo ['orderid'] );
			$tmp_order ['isdel'] = $oo ['isdel'];
			if (empty ( $sub_orders ) && $oo ['isdel'] == 0)
				$tmp_order ['isdel'] = 2;
			$this->db->insert ( 'hotel_orders', $tmp_order );
			// $orders [] = $tmp_order;
			
			$tmp_addition ['id'] = $addition_id;
			$addition_id ++;
			$tmp_addition ['orderid'] = $oo ['orderid'];
			// $tmp_addition ['web_orderid'] = $oo ['web_orderid'];
			// $tmp_addition ['web_paid'] = $oo ['web_paid'];
			$tmp_addition ['coupon_favour'] = intval ( $oo ['vouchertotal'] );
			$tmp_addition ['coupon_used'] = intval ( $oo ['voucherused'] );
			$tmp_addition ['web_orderid'] = is_null ( $oo ['web_orderid'] ) ? '' : $oo ['web_orderid'];
			$this->db->insert ( 'hotel_order_additions', $tmp_addition );
			// $order_additions [] = $tmp_addition;
			
			if (empty ( $oo ['web_orderid'] ) || empty ( $sub_orders )) {
				$iprice = intval ( $oo ['price'] / $oo ['roomnums'] );
				$change = $oo ['price'] - ($iprice * $oo ['roomnums']);
				$p_check = 0;
				for($i = 0; $i < $oo ['roomnums']; $i ++) {
					$tmp_item ['id'] = $item_id;
					$tmp_item ['orderid'] = $oo ['orderid'];
					$tmp_item ['room_id'] = $oo ['room_id'];
					if ($p_check == 0) {
						$tmp_item ['iprice'] = $iprice + $change;
						$p_check = 1;
					} else {
						$tmp_item ['iprice'] = $iprice;
					}
					$tmp_item ['startdate'] = $oo ['startdate'];
					$tmp_item ['enddate'] = $oo ['enddate'];
					$tmp_item ['istatus'] = $oo ['status'];
					$tmp_item ['price_code'] = $oo ['rp_cd'];
					$tmp_item ['price_code_name'] = empty ( $code_name [$oo ['rp_cd']] ) ? '微信价2.0' : $code_name [$oo ['rp_cd']];
					;
					$tmp_item ['handled'] = $tmp_order ['handled'];
					// $tmp_item ['webs_orderid'] = $oo ['web_orderid'];
					$tmp_item ['allprice'] = str_replace ( '+', ',', $oo ['allprice'] );
					$tmp_item ['roomname'] = trim ( $room_names [$oo ['room_id']] ['name'] );
					$this->db->insert ( 'hotel_order_items', $tmp_item );
					// $order_items [] = $tmp_item;
					$item_id ++;
				}
			} else {
				$iprice = intval ( $oo ['price'] / $oo ['roomnums'] );
				$change = $oo ['price'] - ($iprice * $oo ['roomnums']);
				$p_check = 0;
				foreach ( $sub_orders as $so ) {
					$tmp_item ['id'] = $item_id;
					$tmp_item ['orderid'] = $oo ['orderid'];
					$tmp_item ['room_id'] = $oo ['room_id'];
					$everyday_amt = explode ( ',', $so ['everyday_amt'] );
					array_pop ( $everyday_amt );
					$w_price = array_sum ( $everyday_amt );
					if ($w_price == 0) {
						if ($p_check == 0) {
							$tmp_item ['iprice'] = $iprice + $change;
							$p_check = 1;
						} else {
							$tmp_item ['iprice'] = $iprice;
						}
					} else {
						$tmp_item ['iprice'] = $w_price;
					}
					$tmp_item ['startdate'] = $so ['startdate'];
					$tmp_item ['enddate'] = $so ['enddate'];
					$tmp_item ['istatus'] = $so ['local_status'];
					$tmp_item ['price_code'] = $oo ['rp_cd'];
					$tmp_item ['price_code_name'] = empty ( $code_name [$oo ['rp_cd']] ) ? '微信价2.0' : $code_name [$oo ['rp_cd']];
					$tmp_item ['handled'] = $so ['handled'];
					$tmp_item ['webs_orderid'] = $so ['acctnum'];
					$tmp_item ['allprice'] = str_replace ( '+', ',', $oo ['allprice'] );
					$tmp_item ['roomname'] = trim ( $room_names [$oo ['room_id']] ['name'] );
					$this->db->insert ( 'hotel_order_items', $tmp_item );
					// $order_items [] = $tmp_item;
					$item_id ++;
				}
			}
		}
		// var_dump ( $orders );
		// var_dump ( $order_additions );
		// var_dump ( $order_items );
		// exit ();
		// $this->db->insert_batch ( 'hotel_orders', $orders );
		// $this->db->insert_batch ( 'hotel_order_additions', $order_additions );
		// $this->db->insert_batch ( 'hotel_order_items', $order_items );
		echo $order_id . ',' . $addition_id . ',' . $item_id;
	}
	function import_img() {
		$inter_id = 'a421641095';
		
		$sql = "SELECT * FROM `iwide_tmp_hotels` where inter_id='$inter_id'";
		$old_hotels = $this->db->query ( $sql )->result_array ();
		
		$old_rooms = array ();
		$sql = "SELECT * FROM `iwide_tmp_hotels_rooms`  where inter_id='$inter_id'";
		$old_rooms = $this->db->query ( $sql )->result_array ();
		
		$rl_img = array (
				'inter_id' => $inter_id 
		);
		
		$img_id = 43846;
		$prefix = 'http://file.iwide.cn/public/uploads/201603/';
		$imgs = array ();
		foreach ( $old_rooms as $od ) {
			$rl_img ['hotel_id'] = $od ['hotel_id'];
			$rl_img ['room_id'] = $od ['room_id'];
			$rl_img ['id'] = $img_id;
			$rl_img ['info'] = $od ['name'];
			$rl_img ['type'] = 'hotel_room_lightbox';
			$rl_img ['image_url'] = $prefix . 'a421641095hrl_' . $od ['hotel_id'] . '_' . $od ['room_id'] . '.jpg.jpg';
			$imgs [] = $rl_img;
			$img_id ++;
			// echo '<img src="'.$prefix .'yuanzhouhrlb_'.$od['room_id'].'-1.jpg'.'">';
			// echo '<img src="'.$prefix .'yuanzhouhri_'.$od['room_id'].'.jpg'.'">';
		}
		// var_dump($imgs);
		// exit;
		$this->db->insert_batch ( 'hotel_images', $imgs );
		echo 'ok';
	}
	function trans_room_lbimg() {
		set_time_limit(0);
		$inter_id = 'a433320892';
		$sql = "SELECT * FROM `iwide_tmp_hotels_rooms_image` where inter_id='$inter_id' and type=0";
		$room_lbimg = $this->db->query ( $sql )->result_array ();
		$prefix = 'http://file.iwide.cn/public/uploads/' . date ( 'Ym' ) . '/';
		
		$rl_img = array (
				'inter_id' => $inter_id 
		);
		
		$hotel_reflect=array();
		$sql="SELECT * FROM `iwide_tmp_hotels` WHERE `inter_id` LIKE '$inter_id'";
		$hotels=$this->db->query($sql)->result_array();
		$hotel_id=1152;
		foreach ($hotels as $h){
			$hotel_reflect[$h['hotel_id']]=$hotel_id;
			$hotel_id++;
		}
		
		$room_reflect=array();
		$sql="SELECT * FROM `iwide_tmp_hotels_rooms` WHERE `inter_id` LIKE '$inter_id'";
		$rooms=$this->db->query($sql)->result_array();
		$room_id=4352;
		foreach ($rooms as $r){
			$room_reflect[$r['room_id']]=$room_id;
			$room_id++;
		}
		
// 		var_dump($room_lbimg);exit;
		$img_id = 52366;
		$imgs = array ();
		foreach ( $room_lbimg as $rb ) {
			if (! empty ( $rb ['image_url'] )) {
				$rl_img ['hotel_id'] = $hotel_reflect[$rb ['hotel_id']];
				$rl_img ['room_id'] = $room_reflect[$rb ['room_id']];
				$rl_img ['id'] = $img_id;
				$rl_img ['type'] = 'hotel_room_lightbox';
				$rl_img ['image_url'] = $prefix . $this->GrabImage ( trim ( $rb ['image_url'] ), $inter_id . 'hrl_' . $img_id );
				$imgs [] = $rl_img;
				$img_id ++;
			}
		}
// 		var_dump($imgs);
// 		exit;
		$this->db->insert_batch ( 'hotel_images', $imgs );
		echo count ( $imgs );
	}
	function trans_hotel_lbimg() {
		set_time_limit(0);
		$inter_id = 'a433320892';
		$sql = "SELECT * FROM `iwide_tmp_hotels_image` where inter_id='$inter_id' and type=0 and status = 0";
		$hotel_lbimg = $this->db->query ( $sql )->result_array ();
		$prefix = 'http://file.iwide.cn/public/uploads/' . date ( 'Ym' ) . '/';
		
		$rl_img = array (
				'inter_id' => $inter_id 
		);
		
		$hotel_reflect=array();
		$sql="SELECT * FROM `iwide_tmp_hotels` WHERE `inter_id` LIKE '$inter_id'";
		$hotels=$this->db->query($sql)->result_array();
		$hotel_id=1152;
		foreach ($hotels as $h){
			$hotel_reflect[$h['hotel_id']]=$hotel_id;
			$hotel_id++;
		}
				
// 		var_dump($hotel_lbimg);exit;
		$img_id = 57896;
		$imgs = array ();
		foreach ( $hotel_lbimg as $hb ) {
			if (! empty ( $hb ['image_url'] )) {
				$rl_img ['hotel_id'] = $hotel_reflect[$hb ['hotel_id']];
				$rl_img ['room_id'] = 0;
				$rl_img ['id'] = $img_id;
				$rl_img ['type'] = 'hotel_lightbox';
				$rl_img ['image_url'] = $prefix . $this->GrabImage ( trim ( $hb ['image_url'] ), $inter_id . 'hl_' . $img_id );
				$imgs [] = $rl_img;
				$img_id ++;
			}
		}
// 		var_dump($imgs);
// 		exit;
		$this->db->insert_batch ( 'hotel_images', $imgs );
		echo count ( $imgs );
	}
	function trans_order() {
		exit ();
		set_time_limit ( 0 );
		ini_set ( 'memory_limit', '1280M' );
		$inter_id = 'a426755343';
		$sql = "SELECT * FROM `iwide_tmp_jy_hotels_order` where inter_id = '$inter_id' ";
		$old_order = $this->db->query ( $sql )->result_array ();
		$this->db->where ( array (
				'inter_id' => $inter_id 
		) );
		$rooms = $this->db->get ( 'hotel_rooms' )->result_array ();
		// $room_reflect=json_decode('{"1267":3545,"1268":3546,"1269":3547,"1270":3548,"1271":3549,"1272":3550,"1273":3551}',TRUE);
		// $room_reflect=array_flip($room_reflect);
		$room_names = array (
				'0' => array (
						'name' => '无' 
				) 
		);
		foreach ( $rooms as $r ) {
			$room_names [$r ['room_id']] = $r;
		}
		// var_dump($room_names);
		// exit;
		$orders = array ();
		$order_additions = array ();
		$order_items = array ();
		$tmp_order = array (
				'inter_id' => $inter_id 
		);
		$tmp_addition = array (
				'inter_id' => $inter_id 
		);
		$tmp_item = array (
				'inter_id' => $inter_id 
		);
		$paytype = array (
				'0' => 'daofu',
				'1' => 'weixin' 
		);
		$handled_status = array (
				3,
				4,
				5,
				8 
		);
		$code_name = '微信价(2.0)';
		$order_id = 192500;
		$addition_id = 192500;
		$item_id = 208050;
		foreach ( $old_order as $oo ) {
			$tmp_order ['id'] = $order_id;
			$order_id ++;
			$tmp_order ['hotel_id'] = $oo ['hotel_id'];
			$tmp_order ['openid'] = $oo ['openid'];
			$tmp_order ['price'] = $oo ['price'];
			if ($oo ['paid'] == 1 && ! empty ( $oo ['wxpay_reduce'] )) {
				$tmp_addition ['wxpay_favour'] = $oo ['wxpay_reduce'];
				$tmp_order ['price'] -= $oo ['wxpay_reduce'];
			} else {
				$tmp_addition ['wxpay_favour'] = 0;
			}
			$tmp_order ['roomnums'] = $oo ['roomnums'];
			$tmp_order ['name'] = $oo ['name'];
			$tmp_order ['tel'] = $oo ['tel'];
			$tmp_order ['order_time'] = strtotime ( $oo ['time'] );
			$tmp_order ['startdate'] = $oo ['startdate'];
			$tmp_order ['enddate'] = $oo ['enddate'];
			$tmp_order ['paid'] = $oo ['paid'];
			$tmp_order ['orderid'] = $oo ['orderid'];
			$tmp_order ['status'] = $oo ['status'];
			$tmp_order ['holdtime'] = $oo ['holdtime'];
			$tmp_order ['paytype'] = $paytype [$oo ['paytype']];
			$tmp_order ['isdel'] = $oo ['isdel'];
			$tmp_order ['operate_reason'] = empty ( $oo ['operate_reason'] ) ? '' : $oo ['operate_reason'];
			$tmp_order ['member_no'] = '';
			$handled = 0;
			if (in_array ( $oo ['status'], $handled_status ))
				$handled = 1;
			$tmp_order ['handled'] = $handled;
			$tmp_order ['isdel'] = $oo ['isdel'];
			if ($oo ['status'] == 9) {
				$tmp_order ['isdel'] = 1;
			}
			$orders [] = $tmp_order;
			
			$tmp_addition ['id'] = $addition_id;
			$addition_id ++;
			$tmp_addition ['orderid'] = $oo ['orderid'];
			// $tmp_addition ['web_orderid'] = $oo ['web_orderid'];
			// $tmp_addition ['web_paid'] = $oo ['web_paid'];
			$tmp_addition ['coupon_favour'] = intval ( $oo ['vouchertotal'] );
			$tmp_addition ['coupon_used'] = intval ( $oo ['voucherused'] );
			$order_additions [] = $tmp_addition;
			
			$iprice = intval ( $oo ['price'] / $oo ['roomnums'] );
			$change = $oo ['price'] - ($iprice * $oo ['roomnums']);
			$p_check = 0;
			for($i = 0; $i < $oo ['roomnums']; $i ++) {
				$tmp_item ['id'] = $item_id;
				$tmp_item ['orderid'] = $oo ['orderid'];
				$tmp_item ['room_id'] = $oo ['room_id'];
				if ($p_check == 0) {
					$tmp_item ['iprice'] = $iprice + $change;
					$p_check = 1;
				} else {
					$tmp_item ['iprice'] = $iprice;
				}
				$tmp_item ['startdate'] = $oo ['startdate'];
				$tmp_item ['enddate'] = $oo ['enddate'];
				$tmp_item ['istatus'] = $oo ['status'];
				$tmp_item ['price_code'] = 0;
				$tmp_item ['price_code_name'] = empty ( $oo ['favour'] ) ? $code_name : '提前预订价(2.0)';
				$tmp_item ['handled'] = $handled;
				// $tmp_item ['webs_orderid'] = $oo ['web_orderid'];
				$tmp_item ['allprice'] = str_replace ( '+', ',', $oo ['allprice'] );
				$tmp_item ['roomname'] = $room_names [$oo ['room_id']] ['name'];
				$order_items [] = $tmp_item;
				$item_id ++;
			}
		}
		// var_dump ( $orders );
		// var_dump ( $order_additions );
		// var_dump ( $order_items );
		// exit ();
		$this->db->insert_batch ( 'hotel_orders', $orders );
		$this->db->insert_batch ( 'hotel_order_additions', $order_additions );
		$this->db->insert_batch ( 'hotel_order_items', $order_items );
		echo $order_id . ',' . $addition_id . ',' . $item_id;
	}
	function trans_room_service() {
		$inter_id = 'a421641095';
		
		$has = '530,531,532,534,535,536,537,538,539,541,543,544,545,546,547,548,549,550,551,552,553,554,555,556,557,558,559,560,561,562';
		$old_rooms = array ();
		$sql = "SELECT * FROM `iwide_tmp_hotels_rooms`  where inter_id='$inter_id'";
		$old_rooms = $this->db->query ( $sql )->result_array ();
		
		$rl_img = array (
				'inter_id' => $inter_id 
		);
		
		$img_id = 43846;
		$prefix = 'http://file.iwide.cn/public/uploads/201603/';
		$imgs = array ();
		foreach ( $old_rooms as $od ) {
			$rl_img ['hotel_id'] = $od ['hotel_id'];
			$rl_img ['room_id'] = $od ['room_id'];
			$rl_img ['id'] = $img_id;
			$rl_img ['info'] = $od ['name'];
			$rl_img ['type'] = 'hotel_room_lightbox';
			$rl_img ['image_url'] = $prefix . 'a421641095hrl_' . $od ['hotel_id'] . '_' . $od ['room_id'] . '.jpg.jpg';
			$imgs [] = $rl_img;
			$img_id ++;
			// echo '<img src="'.$prefix .'yuanzhouhrlb_'.$od['room_id'].'-1.jpg'.'">';
			// echo '<img src="'.$prefix .'yuanzhouhri_'.$od['room_id'].'.jpg'.'">';
		}
		// var_dump($imgs);
		// exit;
		$this->db->insert_batch ( 'hotel_images', $imgs );
		echo 'ok';
	}
	function trans_hotel_img() {
		exit ();
		$inter_id = 'a421641095';
		
		$sql = "SELECT * FROM `iwide_tmp_hotels` where inter_id='$inter_id' and status=0";
		$old_hotels = $this->db->query ( $sql )->result_array ();
		
		// $old_rooms = array ();
		// $sql = "SELECT * FROM `iwide_tmp_hotels_rooms` where inter_id='$inter_id'";
		// $old_rooms = $this->db->query ( $sql )->result_array ();
		
		$rl_img = array (
				'inter_id' => $inter_id 
		);
		
		$img_id = 44513;
		$prefix = 'http://file.iwide.cn/public/uploads/201603/';
		$imgs = array ();
		foreach ( $old_hotels as $od ) {
			$rl_img ['hotel_id'] = $od ['hotel_id'];
			$rl_img ['room_id'] = 0;
			$rl_img ['info'] = $od ['name'];
			$rl_img ['type'] = 'hotel_lightbox';
			for($i = 1; $i <= 3; $i ++) {
				$rl_img ['id'] = $img_id;
				$rl_img ['image_url'] = $prefix . 'a421641095hl_' . $od ['hotel_id'] . '_' . $i . '.jpg';
				$imgs [] = $rl_img;
				$img_id ++;
			}
			// echo '<img src="'.$prefix .'yuanzhouhrlb_'.$od['room_id'].'-1.jpg'.'">';
			// echo '<img src="'.$prefix .'yuanzhouhri_'.$od['room_id'].'.jpg'.'">';
		}
		// var_dump($imgs);
		// exit;
		$this->db->insert_batch ( 'hotel_images', $imgs );
		echo 'ok';
	}
	// SELECT c.*,o.orderid o_orderid,h.name hotel_name,r.name room_name FROM `iwide_hotels_comment` c join iwide_hotels_order o on c.orderid=o.id and c.inter_id=o.inter_id join iwide_hotels h on o.hotel_id = h.hotel_id and o.inter_id=h.inter_id join iwide_hotels_rooms r on r.room_id=o.room_id and r.inter_id=o.inter_id
	// insert into iwide30dev.iwide_tmp_hotels_comment SELECT c.*,o.orderid o_orderid,h.name hotel_name,r.name room_name FROM lnjycms.iwide_hotels_comment c join lnjycms.iwide_hotels_order o on c.orderid=o.id and c.inter_id=o.inter_id join lnjycms.iwide_hotels h on o.hotel_id = h.hotel_id and o.inter_id=h.inter_id join lnjycms.iwide_hotels_rooms r on r.room_id=o.room_id and r.inter_id=o.inter_id
	function trans_comments() {
		$inter_id = 'a426755343';
		$sql = "SELECT * FROM `iwide_tmp_hotels_comment` where inter_id= '$inter_id'";
		$iwide_hotels_comment = $this->db->query ( $sql )->result_array ();
		$comment_id = 4407;
		$comments = array ();
		$comment = array (
				'inter_id' => $inter_id 
		);
		foreach ( $iwide_hotels_comment as $c ) {
			$comment ['comment_id'] = $comment_id;
			$comment ['content'] = empty ( $c ['content'] ) ? '' : $c ['content'];
			$comment ['comment_time'] = strtotime ( $c ['comment_time'] );
			$comment ['openid'] = $c ['openid'];
			$comment ['hotel_id'] = $c ['hotel_id'];
			$comment ['liked'] = $c ['liked'];
			$comment ['status'] = $c ['status'] == 0 ? 1 : 2;
			$comment ['orderid'] = $c ['o_orderid'];
			$comment ['order_info'] = json_encode ( array (
					'hotel_name' => trim ( $c ['hotel_name'] ),
					'room_name' => trim ( $c ['room_name'] ) 
			), JSON_UNESCAPED_UNICODE );
			$comment ['like_time'] = strtotime ( $c ['like_time'] );
			$comment ['score'] = $c ['liked'] == 1 ? 5 : 4;
			$comment ['type'] = 'user';
			$comment_id ++;
			$comments [] = $comment;
		}
		// var_dump($comments);
		$this->db->insert_batch ( 'hotel_comments', $comments );
		echo count ( $comments );
	}
	function get_sub_order($inter_id, $orderid) {
		return $this->db->get_where ( 'tmp_bgy_hotels_webser_suborder', array (
				'inter_id' => $inter_id,
				'orderid' => $orderid 
		) )->result_array ();
	}
	// SELECT * FROM `iwide_hotels_vouchers` WHERE `inter_id` LIKE 'a431058562' AND `status` in (0,3) and validtime>='2016-02-22 23:59:59'and openid not like '0'
	function create_member_coupon() {
		echo 1;
		exit ();
		set_time_limit ( 0 );
		ini_set ( 'memory_limit', '1280M' );
		$inter_id = 'a426755343';
		
		// $sql="SELECT mem_id,openid FROM `iwide_tmp_bgy_member` where inter_id='$inter_id'";
		// $exi_members=$this->db->query ( $sql )->result_array ();
		// $tmp_members=array();
		// foreach ($exi_members as $em){
		// $tmp_members[$em['openid']]=$em['mem_id'];
		// }
		// unset($exi_members);
		// $s = $this->input->get ( 's' );
		// $b = $this->input->get ( 'b' );
		$select = ' openid,type,amount,fromorderid,creattime ';
		$sql = "SELECT $select FROM `iwide_tmp_hotels_vouchers` WHERE inter_id='$inter_id' and status = 0 ";
		// echo $sql;exit;
		$coupons = $this->db->query ( $sql )->result_array ();
		
		// var_dump ( $coupons );
		// exit ();
		$scene = array (
				'1' => 'hotel_order_complete',
				'2' => 'hotel_order_share' 
		);
		$from = array (
				'10' => 'subscribe',
				'default' => 'hotel_order_complete' 
		);
		$ci_from = array (
				'10' => 179,
				'20' => 156,
				'40' => 180 
		);
		$extra_data = array (
				'module' => 'hotel',
				'inter_id' => $inter_id 
		);
		$members = array ();
		$new_coupons = array ();
		$openids = array ();
		$codes = array ();
		$member_id = 494400;
		$gc_id = 239600;
		foreach ( $coupons as $c ) {
			// 不调用接口插入
			// if (! isset ( $openids [$c ['openid']])) {
			$exist_member = $this->get_exist_member ( $c ['openid'] );
			if (! empty ( $exist_member )) {
				// $openids [$c ['openid']] = $exist_member['mem_id'];
				$mid = $exist_member ['mem_id'];
			} else {
				$member = array (
						'inter_id' => $inter_id,
						'openid' => $c ['openid'],
						'mem_id' => $member_id,
						'mem_card_no' => $this->create_member_no ( $inter_id ),
						// 'mem_card_no' => $member_id . '88',
						'create_time' => date ( 'Y-m-d H:i:s' ),
						'update_time' => date ( 'Y-m-d H:i:s' ) 
				);
				// $this->db->insert ( 'tmp_bgy_member', $member );
				$this->db->insert ( 'member', $member );
				// $members [] = $member;
				$mid = $member_id;
				// $tmp_members[$c['openid']]=$mid;
				$member_id ++;
				// $openids [$c ['openid']] = $member_id;
			}
			// }
			// $extra_data ['scene'] = $scene [$c ['type']];
			if (! empty ( $from [$c ['amount']] ))
				$extra_data ['scene'] = $from [$c ['amount']];
			else
				$extra_data ['scene'] = $from ['default'];
			$extra_data ['scene_id'] = $c ['fromorderid'];
			$extra_data ['gc_id'] = $gc_id;
			$extra_data ['ci_id'] = $ci_from [$c ['amount']];
			$extra_data ['mem_id'] = $mid;
			// $extra_data ['mem_id'] = $openids [$c ['openid']];
			$extra_data ['openid'] = $c ['openid'];
			$extra_data ['status'] = 1;
			$extra_data ['create_time'] = $c ['creattime'];
			$extra_data ['update_time'] = date ( 'Y-m-d H:i:s' );
			$code = $this->createCardCode ( $c ['openid'], $extra_data ['ci_id'] );
			for($i = 0;; $i ++) {
				if (in_array ( $code, $codes )) {
					$code ++;
				} else {
					break;
				}
			}
			$codes [] = $code;
			$extra_data ['code'] = $code;
			$this->db->insert ( 'member_get_card_list', $extra_data );
			// $new_coupons [] = $extra_data;
			$gc_id ++;
		}
		// var_dump($members);
		// var_dump($new_coupons);
		// $this->db->insert_batch ( 'tmp_bgy_member', $members );
		// $this->db->insert_batch ( 'member_get_card_list', $new_coupons );
		echo $member_id . ',';
		echo $gc_id;
		echo 'ok';
	}
	function update_member_point() {
		echo 1;
		exit ();
		set_time_limit ( 0 );
		ini_set ( 'memory_limit', '1280M' );
		$inter_id = 'a426755343';
		
		$sql = "SELECT openid,sum(valid_amount) total FROM `iwide_tmp_points` where inter_id='$inter_id' and status=0 group by openid";
		// echo $sql;exit;
		$points = $this->db->query ( $sql )->result_array ();
		
		$change_sign = array (
				'0' => '3',
				'1' => '4' 
		);
		$note = array (
				'points_order' => '积分商城消费(2.0)',
				'hotel_order_get' => '订单离店，赠送积分' 
		);
		$member_id = 505182;
		$count = 0;
		foreach ( $points as $c ) {
			$exist_member = $this->get_exist_member ( $c ['openid'] );
			if (! empty ( $exist_member )) {
				$mid = $exist_member ['mem_id'];
			} else {
				$member = array (
						'inter_id' => $inter_id,
						'openid' => $c ['openid'],
						'mem_id' => $member_id,
						'mem_card_no' => $this->create_member_no ( $inter_id ),
						'create_time' => date ( 'Y-m-d H:i:s' ),
						'update_time' => date ( 'Y-m-d H:i:s' ) 
				);
				$this->db->insert ( 'member', $member );
				$mid = $member_id;
				$member_id ++;
			}
			$this->db->where ( array (
					'inter_id' => $inter_id,
					'openid' => $c ['openid'],
					'mem_id' => $mid 
			) );
			$this->db->update ( 'member', array (
					'bonus' => $c ['total'] 
			) );
			$count ++;
		}
		echo $member_id . ',';
		echo $count;
		echo 'ok';
	}
	function create_member_point_record() {
		echo 1;
		exit ();
		set_time_limit ( 0 );
		ini_set ( 'memory_limit', '1280M' );
		$inter_id = 'a426755343';
		
		$sql = "SELECT * FROM `iwide_tmp_points_record` where inter_id = '$inter_id' and (status=0 or ( status=1 and change_type='pointgoods' ) )";
		// echo $sql;
		// exit ();
		$records = $this->db->query ( $sql )->result_array ();
		
		$change_sign = array (
				'0' => '3',
				'1' => '4' 
		);
		$note = array (
				'pointgoods' => '积分商城消费',
				'hotel_order_get' => '订单离店，赠送积分' 
		);
		$record = array (
				'inter_id' => $inter_id,
				'on_offline' => 1 
		);
		$member_id = 507750;
		$record_id = 9626;
		$count = 0;
		$datas = array ();
		foreach ( $records as $c ) {
			$exist_member = $this->get_exist_member ( $c ['openid'] );
			if (! empty ( $exist_member )) {
				$mid = $exist_member ['mem_id'];
			} else {
				$member = array (
						'inter_id' => $inter_id,
						'openid' => $c ['openid'],
						'mem_id' => $member_id,
						'mem_card_no' => $this->create_member_no ( $inter_id ),
						'create_time' => date ( 'Y-m-d H:i:s' ),
						'update_time' => date ( 'Y-m-d H:i:s' ) 
				);
				$this->db->insert ( 'member', $member );
				$mid = $member_id;
				$member_id ++;
			}
			$record ['cr_id'] = $record_id;
			$record ['order_id'] = $c ['change_id'];
			$record ['type'] = $change_sign [$c ['change_sign']];
			$record ['mem_id'] = $mid;
			$record ['bonus'] = $c ['amount'];
			$record ['note'] = $note [$c ['change_type']];
			$record ['create_time'] = $c ['change_time'];
			// $this->db->insert ( 'member_consumption_record', $record );
			$datas [] = $record;
			$record_id ++;
		}
		$this->db->insert_batch ( 'member_consumption_record', $datas );
		echo $member_id . ',';
		echo $record_id;
		echo 'ok';
	}
	function fix_member_point_record() {
		echo 1;
		exit ();
		set_time_limit ( 0 );
		ini_set ( 'memory_limit', '1280M' );
		$inter_id = 'a426755343';
		
		$sql = "SELECT * FROM `iwide_tmp_points_record` where inter_id = '$inter_id' and (status=0 or ( status=1 and change_type='pointgoods' ) )";
		// echo $sql;
		// exit ();
		$records = $this->db->query ( $sql )->result_array ();
		$count = 0;
		$datas = array ();
		foreach ( $records as $c ) {
			$data = array (
					'create_time' => $c ['change_time'] 
			);
			// if($c['change_type']=='pointgoods'){
			// $data['note']='积分商城消费';
			// }
			$this->db->where ( array (
					'inter_id' => $inter_id,
					'order_id' => $c ['change_id'] 
			) );
			$this->db->update ( 'member_consumption_record', $data );
			// echo $this->db->update_string ( 'member_consumption_record', $data, array (
			// 'inter_id' => $inter_id,
			// 'order_id' => $c ['change_id']
			// ) ) . ';<br />';
			// $datas[]=$data;
			$count ++;
			// exit;
		}
		// $this->db->update_batch('member_consumption_record',$datas,'order_id');
		// echo $this->db->last_query();
		// echo $member_id . ',';
		// echo $record_id;
		echo $count . ',ok';
	}
	function order_coupon() {
		set_time_limit ( 0 );
		$inter_id = 'a426755343';
		$sql = "SELECT *,count(id) total_num FROM `iwide_tmp_hotels_vouchers` WHERE inter_id='$inter_id' and status=3 group by fromorderid";
		$coupons = $this->db->query ( $sql )->result_array ();
		// var_dump($coupons);exit;
		$rule = array (
				'20' => 87 
		);
		$coupon_id = array (
				'20' => 94 
		);
		foreach ( $coupons as $c ) {
			$des = array ();
			$des ['check_out'] = array (
					'140' => array (
							'rule_name' => '返券20',
							'cards' => array (
									'156' => array (
											'card_id' => 156,
											'card_nums' => $c ['total_num'],
											'give_num' => 1,
											'give_rule' => 'room_nights' 
									) 
							) 
					) 
			);
			echo $this->db->update_string ( 'hotel_order_additions', array (
					'coupon_give_info' => json_encode ( $des, JSON_UNESCAPED_UNICODE ),
					'complete_reward_given' => 2 
			), array (
					'inter_id' => $inter_id,
					'orderid' => $c ['fromorderid'] 
			) ) . ';';
		}
	}
	// SELECT tp.*,tr.change_id,tr.change_type,count(tp.point_id) from ( select * FROM `iwide_tmp_points` WHERE `status` = 2 and inter_id='a426755343') tp join iwide_tmp_points_record tr on tp.point_id=tr.point_id and tp.inter_id=tr.inter_id group by tp.point_id
	function order_point() {
		set_time_limit ( 0 );
		$inter_id = 'a426755343';
		$sql = "SELECT tp.*,tr.change_id,tr.change_type,count(tp.point_id) from 
				( select * FROM `iwide_tmp_points` WHERE `status` = 2 and inter_id='$inter_id') tp join 
		iwide_tmp_points_record tr on tp.point_id=tr.point_id and tp.inter_id=tr.inter_id group by tp.point_id ";
		$points = $this->db->query ( $sql )->result_array ();
		// var_dump($coupons);exit;
		foreach ( $points as $c ) {
			echo $this->db->update_string ( 'hotel_order_additions', array (
					'complete_point_info' => '{"type":"BALANCE","give_amount":' . $c ['amount'] . ',"give_rate":1}',
					'complete_point_given' => 2 
			), array (
					'inter_id' => $inter_id,
					'orderid' => $c ['change_id'] 
			) ) . ';';
		}
	}
	function get_exist_member($openid) {
		return $this->db->get_where ( 'member', array (
				'openid' => $openid 
		) )->row_array ();
	}
	function create_member_no($inter_id) {
		$tmp = $this->getRandCode ( 8 );
		// $tmp = str_pad ( substr ( time (), 4, 6 ) . mt_rand ( 0, 99 ), 8, mt_rand ( 0, 9 ) );
		for($i = 0;; $i ++) {
			$tmp += $i;
			if (! $this->db->get_where ( 'member', array (
					'inter_id' => $inter_id,
					'mem_card_no' => $tmp 
			) )->row_array ())
				return $tmp;
		}
		return false;
	}
	public function getRandCode($digit = 8) {
		$code = mt_rand ( 1, 9 );
		for($i = 1; $i < $digit; $i ++) {
			$code .= mt_rand ( 0, 9 );
		}
		return $code;
	}
	protected function createCardCode($openid, $ci_id) {
		// $this->load->model ( 'member/getcard' );
		// $code = $this->getcard->getRandCode ();
		$code = $this->getRandCode ( 12 );
		return $code;
		$result = $this->getcard->checkIsExistCode ( $openid, $ci_id, $code );
		
		if (! $result)
			return $code;
		
		$i = 0;
		do {
			$i ++;
			$code += 1;
			$result = $this->getcard->checkIsExistCode ( $openid, $ci_id, $code );
		} while ( $result && $i < 100 );
		return $code;
	}
	function zhuzhe_room() {
		$hotel_id = $this->input->get ( 'h' );
		$inter_id = $this->input->get ( 'id' );
		$new = $this->input->get ( 'new' );
		$token = '';
		switch ($inter_id) {
			case 'a441624001' :
				$token = 'jieting_83383_20160106_web:admin';
				break;
			default :
				$token = 'ejia365_82250_20151023_web:admin';
				if ($new==1)
					$token = 'dikete_7523_201506172048:admin';
				break;
		}
		$this->load->model ( 'hotel/pms/Zhuzhe_hotel_model', 'pms' );
		$hotelretdata = $this->pms->qfcurl ( $this->pms->path ( '/hotel/' . $hotel_id . '/' . date ( 'Y-m-d' ) . '/' . date ( 'Y-m-d', strtotime ( '+ 1 day', time () ) ) ), '', $token );
		preg_match_all ( "/\<houseTypeList\>(.*?)\<\/houseTypeList\>/", $hotelretdata, $hotelretdataarr );
		$allprice = array ();
		$qfrooms = array ();
// 		echo '<h1>Lauridou</h1>';
		$hotelretdata=simplexml_load_string($hotelretdata);
		if (isset ( $hotelretdataarr [0] [0] )) {
			$hotelretxml = $hotelretdataarr [0] [0];
			$xmlobj = simplexml_load_string ( $hotelretxml );
			// print_r(json_decode(json_encode($xmlobj),true));
			$data = json_decode ( json_encode ( $xmlobj ), true );
			foreach ( $data ['houseType'] as $d ) {
				echo '房间名：' . $d ['houseTypeName'] . '<br />';
				echo '房间id：' . $d ['houseTypeId'] . '<br />';
				echo '房间数：' . $d ['available'] . '<br />';
				echo '房价：' . $d ['fitPrice'] . '<br />';
				echo '原价：' . $d ['price'] . '<hr />';
			}
		}else if (isset($hotelretdata->code)&&isset($hotelretdata->msg)){
			echo 'pms报错：'.$hotelretdata->msg;
		}
		else
			echo '参数不对';
	}
	function huayi_room() {
		$hotel_id = $this->input->get ( 'h' );
		$inter_id = $this->input->get ( 'id' );
		if (empty ( $hotel_id ))
			exit ();
		switch ($inter_id) {
			default :
				$pms_auth = '{"url":"http:\/\/adapter.onlineding.com\/eaka365IwideApi/app\/hotelSelfService","channelFrom":"iwide","chainCode":"YJGROUP"}';
		}
		$this->load->model ( 'hotel/pms/Huayi_hotel_model', 'pms' );
		$pms_auth = json_decode ( $pms_auth, true );
		$url = $pms_auth ['url'] . '?method=SingleHotelSearch';
		$json = array (
				"channelCode" => 18,
				"channelFrom" => $pms_auth ['channelFrom'],
				"userId" => "",
				"priceRange" => "",
				"chainCode" => $pms_auth ['chainCode'],
				"brandCode" => "",
				"hotelCode" => $hotel_id,
				"startDate" => date ( 'Y-m-d' ),
				"endDate" => date ( 'Y-m-d', strtotime ( '+ 1 day', time () ) ),
				"memberCode" => '',
				"cardTypeCode" => '' 
		);
		$pms_data = $this->pms->get_to ( $url, $json, 'a445223616' );
		echo '<h1>DoubiLaurie </h1>';
		if (! empty ( $pms_data ) && $pms_data ['state'] == 1) {
			$rooms=array();
			$s='';
			foreach ($pms_data['data']['roomTypes'] as $r){
				$rooms[$r['roomTypeCode']]=array('name'=>$r['roomTypeName'],'img'=>$r['smallImgUrl']);
				$s.= '房间名：'.$r['roomTypeName'].'<br />';
				$s.= 'pms id：'.$r['roomTypeCode'].'<br />';
				$s.= '数量：无 <br />';
				$s.= '价格：无 <br />';
				$s.= '图片：<img src="'.$r['smallImgUrl'].'" /><br />';
				$s.= '<hr />';
			}
			if (!empty($pms_data['data']['detail'][0]['ratePlans'])){
				$s='';
				foreach ($pms_data['data']['detail'][0]['ratePlans'] as $rp){
					if($rp['canBook']==1){
						foreach ($rp['roomTypes'] as $rt){
							echo '房间名：'.$rooms[$rt['roomTypeCode']]['name'].'<br />';
							echo 'pms id：'.$rt['roomTypeCode'].'<br />';
							echo '数量：'.$rt['roomQuantity'].'<br />';
							echo '价格：'.$rt['rates'][0]['rate'].'<br />';
							echo '图片：<img src="'.$rooms[$rt['roomTypeCode']]['img'].'" /><br />';
							echo '<hr />';
						}
					}
				}
			}
			echo $s;
		} else
			echo '参数不对';
	}
	function lvyun_room() {
		$hotel_id =  $this->input->get ( 'h' );
		$inter_id = $this->input->get ( 'id' );
		echo nl2br ( '	酒店名	酒店pmsID<hr />
				苏州园区左岸书香世家酒店	13
				上海虹桥书香世家酒店	14
				苏州树山书香世家度假酒店	15
				苏州独墅湖书香世家酒店	16
				苏州新区玉山书香世家酒店	17
				书香府邸•平江府	18
				书香_32	32
				书香_33	33
				书香_34	34
				胥城大厦	30
				济南新区书香世家酒店	19
				无锡滨湖书香世家酒店	20
				南京新街口书香世家酒店	21
				徐州云龙书香世家酒店	22
				杭州书香世家酒店	23
				苏州新浒书香世家酒店	24
				南通星湖书香世家酒店	12
				南京中江书香世家酒店	11
				镇江书香世家酒店	25
				苏州月亮湾书香世家酒店	31
				苏州园区星海书香世家酒店	10
				山塘书香府邸	9
				东苑书香酒店	28
				书香世家通州湾商务中心	29
				大丰书香世家神鹿家园酒店	35
				巡塘书香府邸	36<hr />' );
		$url = 'http://pms.myschotel.com:8090' . '/ipms/CRS/queryHotelList';
		$data = array (
// 				'date' => '2016-05-14',
				'date' => date ( 'Y-m-d',strtotime('+1 day',time()) ),
				'dayCount' => 1,
				'cityCode' => '',
				'brandCode' => '',
				'order' => '1',
				'firstResult' => 1,
				'pageSize' => 100,
				'rateCodes' => '',
				'salesChannel' => 'DG',
				'hotelIds' => $hotel_id,
				// 'hotelIds' => '18,19,20',
				/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
				'hotelGroupId' => 2 
		);
		$url .= '?' . http_build_query ( $data );
		$res = $this->get_to ( $url );
		if (! empty ( $res ['hrList'] [0] ['rmtypes'] )) {
			$res = $res ['hrList'] [0] ['rmtypes'];
			foreach ( $res as $d ) {
				echo '房间名：' . $d ['descript'] . '<br />';
				echo '房间id：' . $d ['code'] . '<hr />';
			}
		}
	}
	function yunmeng_room() {
		$hotel_id =  $this->input->get ( 'h' );
		$inter_id = $this->input->get ( 'id' );
		$url = 'http://pms.eaka365.net:8102/ipmsgroup/CRS/queryHotelList';
		$data = array (
// 				'date' => '2016-05-14',
				'date' => date ( 'Y-m-d',strtotime('+1 day',time()) ),
				'dayCount' => 1,
				'cityCode' => '',
				'brandCode' => '',
				'order' => '1',
				'firstResult' => 1,
				'pageSize' => 100,
				'rateCodes' => '',
				'salesChannel' => 'WEB',
				'hotelIds' => $hotel_id,
				// 'hotelIds' => '18,19,20',
				/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
				'hotelGroupId' => 2 
		);
		$url .= '?' . http_build_query ( $data );
		$res = $this->get_to ( $url );
		if (! empty ( $res ['hrList'] [0] ['rmtypes'] )) {
			$res = $res ['hrList'] [0] ['rmtypes'];
			foreach ( $res as $d ) {
				echo '房间名：' . $d ['descript'] . '<br />';
				echo '房间id：' . $d ['code'] . '<hr />';
			}
		}else {
			echo '没有房型信息';
		}
	}
	function yinju_room() {
		$hotel_id =  $this->input->get ( 'h' );
		echo nl2br ( '	酒店名	酒店pmsID<hr />
				隐居西湖-满觉陇	18
				隐居海上-空中别院	19
				隐居逸扬			20
				隐居繁华			21
				隐居洱海			22
				隐居西湖-白乐桥	23
				隐居西湖-杨梅岭	24
				隐居西湖-上天竺	25
				隐居画乡			26
				隐居海上-中国院子	29
				隐居桃源			30
				隐居-乡宿上泗安32<hr />' );
		$url = 'http://202.107.192.24:8090' . '/ipms/CRS/queryHotelList';
		$data = array (
// 				'date' => '2016-05-14',
				'date' => date ( 'Y-m-d',strtotime('+1 day',time()) ),
				'dayCount' => 1,
				'cityCode' => '',
				'brandCode' => '',
				'order' => '1',
				'firstResult' => 1,
				'pageSize' => 100,
				'rateCodes' => '',
				'salesChannel' => 'WEIXIN',
				'hotelIds' => $hotel_id,
				// 'hotelIds' => '18,19,20',
				/* 13,14,15,16,17,18,32,33,34,30,19,20,21,22,23,24,12,11,25,31,10,9,28,29,35,36 */
				'hotelGroupId' => 2 
		);
		$url .= '?' . http_build_query ( $data );
		$res = $this->get_to ( $url );
		if (! empty ( $res ['hrList'] [0] ['rmtypes'] )) {
			$res = $res ['hrList'] [0] ['rmtypes'];
			foreach ( $res as $d ) {
				echo '房间名：' . $d ['descript'] . '<br />';
				echo '房间id：' . $d ['code'] . '<hr />';
			}
		}
	}
	function get_web_order() {
		$web_orderid = $this->input->get ( 'oid' );
		$url = 'http://webapi.zhuzher.com' . '/v2/order/info/' . $web_orderid . '/111/admin';
		$return_data = $this->qfcurl ( $url, '', 'ejia365_82250_20151023_web:admin', 'a445223616' );
		
		$result = simplexml_load_string ( $return_data );
		$result = json_decode ( json_encode ( $result ), TRUE );
		if (empty ( $result ['order'] ['childOrderInfoExtend'] )) {
			echo '查不到';
			exit ();
		}
		$sub_orders = explode ( '@', $result ['order'] ['childOrderInfoExtend'] );
		$status_arr = array (
				'0' => '已确认',
				'1' => '入住',
				'2' => '离店',
				'6' => '取消',
				'8' => '未到' 
		);
		$i = 1;
		foreach ( $sub_orders as $so ) {
			$sub_order = explode ( '#', $so );
			echo '订单' . $i . ':' . $status_arr [$sub_order [3]];
			$i ++;
		}
	}
	function qfcurl($url, $data = '', $token = '', $inter_id = '') {
		$s = json_encode ( $data );
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 ); // 对认证证书来源的检查
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 2 ); // 从证书中检查SSL加密算法是否存在
		curl_setopt ( $ch, CURLOPT_USERAGENT, $_SERVER ['HTTP_USER_AGENT'] ); // 模拟用户使用的浏览器
		curl_setopt ( $ch, CURLOPT_USERPWD, $token );
		curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 ); // 自动设置Referer
		if (is_array ( $data )) {
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
		} elseif ($data) {
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		}
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 5 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 ); // 获取的信息以文件流的形式返回
		$data = curl_exec ( $ch );
		if (curl_errno ( $ch )) {
			echo 'Errno' . curl_error ( $ch ); // 捕抓异常
		}
		curl_close ( $ch );
		$this->db->insert ( 'webservice_record', array (
				'send_content' => $s,
				'receive_content' => $data,
				'record_time' => time (),
				'inter_id' => $inter_id,
				'service_type' => 'zhuzhe',
				'web_path' => $url,
				'record_type' => 'query_post' 
		) );
		return $data;
	}
	function get_to($url, $data = array()) {
		$this->load->helper ( 'common' );
		$s = doCurlGetRequest ( $url );
		$s = json_decode ( $s, true );
		return $s;
	}
	function yibo_room() {
		$this->load->model ( 'hotel/pms/Yibo_hotel_model', 'pms' );
		$hotel_no = $this->input->get ( 'h' );
		if ($hotel_no) {
			$hotel = $this->pms->get_web_room_status ( $hotel_no, date ( 'Y-m-d' ), date ( 'Y-m-d', strtotime ( '+ 1 day', time () ) ), '' );
			if (! empty ( $hotel )) {
				foreach ( $hotel ['Data'] as $k => $d ) {
					if ($k != 'RoomList') {
						echo $k . ':' . $d . '<br />';
					} else {
						echo '房型：<br />';
						foreach ( $d as $r ) {
							echo $r ['RoomTypeName'] . ':' . $r ['RoomTypeNo'];
							$tmp = current ( $r ['Pricelist'] );
							$tmp = current ( $tmp ['CodePrice'] );
							echo ',price:' . $tmp ['Price'] . '<br />';
						}
					}
				}
				echo '<br />接口：GetRoomStatusByHotelNo'.'<br />';
				echo '时间:'.date('Y-m-d H:i:s').'<br />数据：';
				print_r($hotel);
			}
		}
	}
	function molin_room(){
		$hotel_no = $this->input->get ( 'h' );
		if ($hotel_no) {
			$url="http://x.hotelwebs.cn/gateway/get_room_type_list?sob.sob_code=www.ldmlfs.com&sob.password=20120525&sob.hotelgroup_id=376&hotel_id=$hotel_no";
			$this->load->model ( 'hotel/pms/Luopan_hotel_model', 'pms' );
			$rooms=$this->pms->get_to($url,array(),'a452223043');
			if (!empty($rooms['room_types'])){
				echo '图片要先下载<hr />';
				foreach ($rooms['room_types'] as $r){
					echo '房型id:'.$r['id'].'<br />';
					echo '房名:'.$r['name'].'<br />';
					echo '价格:'.$r['list_price'].'<br />图片:';
					echo empty($r['logo'])?'无图片':'http://bj.chinapms.com:8900/crs_images/?path='.$r['logo'].'<br />';
					echo '<hr />';
				}
				exit;
			}
		}
		echo '没有';
	}
	
	function temp_interface() {
		$this->load->helper('common');
		$this->load->model('interface/Isigniture_model');
		// 		$url='ihotels.iwide.cn/index.php/interface/hotel_interface/send_order_template_msg';
		// 		$url='ihotels.iwide.cn/index.php/interface/public_interface/reflash_access_token';
		// 		$url=site_url('interface/public_interface/reflash_access_token');
// 		$url='soocor.iwide.cn/index.php/interface/member_interface/get_openid_member';
		$url=site_url('interface/member_interface/get_openid_member');
// 		$url='http://soocor.iwide.cn/index.php/interface/member_interface/get_openid_member';
// 				$url=site_url('interface/public_interface/code_openid');
		$data=array('timestamp'=>1465985544,'noncestr'=>'8C6744C9D42EC2CB9E8885B54FF744D0','itd'=>'a449675133',);
		// 		$data+=array(
		// 			'order_id'=>'32495926',
		//  			'template_type'=>'hotel_order_cancel',
		// 			'template_content'=>'{"template_id":"aboQ5NMhY6gokkqyqBPR-yHDLo7o9C2Kp5DcUigYaOA","data":{"first":{"value":"客人您好，你已成功预订酒店房间","color":"#173177"},"keynote1":{"value":"32495926","color":"#173177"},"keynote2":{"value":"速8酒店北京密云鼓楼店","color":"#173177"},"keynote3":{"value":"李东宇","color":"#173177"},"keynote4":{"value":"2016年05月09日","color":"#173177"},"keynote5":{"value":"2016年05月10日","color":"#173177"},"remark":{"value":"客人您好，你已成功预订酒店房间","color":"#173177"}}}',
		// 			'url_type'=>'order_detail'
		// 		);
		$data['openid']='ocbScjmgF8bP4ZHVlrYKii6cfzJU';
// 				$data['code']='031PosX51jkg4Z1jCbX51KzxX51PosXh';
		$data['signature'] = $this->Isigniture_model->get_sign($data,'eyj6kjj74jc14ucitxu4xobctopcor5o');
		// 		echo $data['signature'].'<br />';
		// sha1
		// echo sha1('itd=a455510007&noncestr=60564617172b4347b3ea38feb2e8909f&order_id=32495926&template_content={"template_id":"aboQ5NMhY6gokkqyqBPR-yHDLo7o9C2Kp5DcUigYaOA","data":{"first":{"value":"客人您好，你已成功预订酒店房间","color":"#173177"},"keynote1":{"value":"32495926","color":"#173177"},"keynote2":{"value":"速8酒店北京密云鼓楼店","color":"#173177"},"keynote3":{"value":"李东宇","color":"#173177"},"keynote4":{"value":"2016年05月09日","color":"#173177"},"keynote5":{"value":"2016年05月10日","color":"#173177"},"remark":{"value":"客人您好，你已成功预订酒店房间","color":"#173177"}}}&timestamp=1463038604&url_type=order_detail&key=oxn31kfjdva0o8i6ue320wcv1sum7y2d');
// 		echo json_encode($data);
// echo $url;
		var_dump(doCurlPostRequest($url, json_encode($data)));
		// 		var_dump(json_decode(doCurlPostRequest($url, json_encode($data))));
	}
	function img_batch(){
		$hotel_ids='2866,2867,2872,2874,2876,2877,2878,2879,2880,2881,2882,2883,2884,2885,2886,2887,2888,2889,2890,2891,2893,2894,2895,2896,2897,2898,2899,2900,2901,2902,2903,2904,2905,2906,2907,2908,2909,2910,2911,2912,2913,2914,2915,2916,2917,2918,2919,2920,2921,2922,2923,2924,2925,2926,2927,2928,2929,2930,2931,2932,2933,2934,2935,2936,2937,2938,2972';
		$hotel_ids=explode(',', $hotel_ids);
		$inter_id='a468209719';
		foreach ($hotel_ids as $hotel_id){
			$tmp=array('inter_id'=>$inter_id,'hotel_id'=>$hotel_id,'room_id'=>0,'type'=>'hotel_lightbox');
			$tmp['image_url']='http://file.iwide.cn/public/uploads/201607/a_'.$hotel_id.'_1.jpg';
			echo $this->db->insert_string('hotel_images',$tmp).';'.'<br />';
			$tmp['image_url']='http://file.iwide.cn/public/uploads/201607/a_'.$hotel_id.'_2.jpg';
			echo $this->db->insert_string('hotel_images',$tmp).';'.'<br />';
			$tmp['image_url']='http://file.iwide.cn/public/uploads/201607/a_'.$hotel_id.'_3.jpg';
			echo $this->db->insert_string('hotel_images',$tmp).';'.'<br />';
		}
	}
	function room_img_batch(){

		$iwide_hotel_rooms = array(
				array('hotel_id' => '2866','room_id' => '13383'),
				array('hotel_id' => '2866','room_id' => '13384'),
				array('hotel_id' => '2866','room_id' => '13385'),
				array('hotel_id' => '2866','room_id' => '13386'),
				array('hotel_id' => '2866','room_id' => '13387'),
				array('hotel_id' => '2866','room_id' => '13388'),
				array('hotel_id' => '2866','room_id' => '13389'),
				array('hotel_id' => '2866','room_id' => '13390'),
				array('hotel_id' => '2867','room_id' => '13391'),
				array('hotel_id' => '2867','room_id' => '13392'),
				array('hotel_id' => '2867','room_id' => '13393'),
				array('hotel_id' => '2867','room_id' => '13394'),
				array('hotel_id' => '2867','room_id' => '13395'),
				array('hotel_id' => '2872','room_id' => '13396'),
				array('hotel_id' => '2872','room_id' => '13397'),
				array('hotel_id' => '2872','room_id' => '13398'),
				array('hotel_id' => '2872','room_id' => '13399'),
				array('hotel_id' => '2872','room_id' => '13400'),
				array('hotel_id' => '2872','room_id' => '13401'),
				array('hotel_id' => '2872','room_id' => '13402'),
				array('hotel_id' => '2874','room_id' => '13403'),
				array('hotel_id' => '2874','room_id' => '13404'),
				array('hotel_id' => '2874','room_id' => '13405'),
				array('hotel_id' => '2874','room_id' => '13406'),
				array('hotel_id' => '2874','room_id' => '13407'),
				array('hotel_id' => '2874','room_id' => '13408'),
				array('hotel_id' => '2874','room_id' => '13409'),
				array('hotel_id' => '2874','room_id' => '13410'),
				array('hotel_id' => '2876','room_id' => '13411'),
				array('hotel_id' => '2876','room_id' => '13412'),
				array('hotel_id' => '2876','room_id' => '13413'),
				array('hotel_id' => '2876','room_id' => '13414'),
				array('hotel_id' => '2894','room_id' => '13415'),
				array('hotel_id' => '2876','room_id' => '13416'),
				array('hotel_id' => '2876','room_id' => '13417'),
				array('hotel_id' => '2876','room_id' => '13418'),
				array('hotel_id' => '2894','room_id' => '13419'),
				array('hotel_id' => '2894','room_id' => '13420'),
				array('hotel_id' => '2894','room_id' => '13421'),
				array('hotel_id' => '2894','room_id' => '13422'),
				array('hotel_id' => '2894','room_id' => '13423'),
				array('hotel_id' => '2894','room_id' => '13424'),
				array('hotel_id' => '2894','room_id' => '13425'),
				array('hotel_id' => '2894','room_id' => '13426'),
				array('hotel_id' => '2895','room_id' => '13427'),
				array('hotel_id' => '2895','room_id' => '13428'),
				array('hotel_id' => '2895','room_id' => '13429'),
				array('hotel_id' => '2895','room_id' => '13430'),
				array('hotel_id' => '2895','room_id' => '13431'),
				array('hotel_id' => '2895','room_id' => '13432'),
				array('hotel_id' => '2895','room_id' => '13433'),
				array('hotel_id' => '2895','room_id' => '13434'),
				array('hotel_id' => '2895','room_id' => '13435'),
				array('hotel_id' => '2896','room_id' => '13436'),
				array('hotel_id' => '2896','room_id' => '13437'),
				array('hotel_id' => '2896','room_id' => '13438'),
				array('hotel_id' => '2896','room_id' => '13439'),
				array('hotel_id' => '2877','room_id' => '13440'),
				array('hotel_id' => '2896','room_id' => '13441'),
				array('hotel_id' => '2877','room_id' => '13442'),
				array('hotel_id' => '2877','room_id' => '13443'),
				array('hotel_id' => '2877','room_id' => '13444'),
				array('hotel_id' => '2898','room_id' => '13445'),
				array('hotel_id' => '2877','room_id' => '13446'),
				array('hotel_id' => '2898','room_id' => '13447'),
				array('hotel_id' => '2877','room_id' => '13448'),
				array('hotel_id' => '2898','room_id' => '13449'),
				array('hotel_id' => '2877','room_id' => '13450'),
				array('hotel_id' => '2898','room_id' => '13451'),
				array('hotel_id' => '2898','room_id' => '13452'),
				array('hotel_id' => '2898','room_id' => '13453'),
				array('hotel_id' => '2878','room_id' => '13454'),
				array('hotel_id' => '2906','room_id' => '13455'),
				array('hotel_id' => '2878','room_id' => '13456'),
				array('hotel_id' => '2906','room_id' => '13457'),
				array('hotel_id' => '2898','room_id' => '13458'),
				array('hotel_id' => '2878','room_id' => '13459'),
				array('hotel_id' => '2878','room_id' => '13460'),
				array('hotel_id' => '2878','room_id' => '13461'),
				array('hotel_id' => '2878','room_id' => '13462'),
				array('hotel_id' => '2878','room_id' => '13463'),
				array('hotel_id' => '2878','room_id' => '13464'),
				array('hotel_id' => '2900','room_id' => '13465'),
				array('hotel_id' => '2900','room_id' => '13466'),
				array('hotel_id' => '2900','room_id' => '13467'),
				array('hotel_id' => '2878','room_id' => '13468'),
				array('hotel_id' => '2900','room_id' => '13469'),
				array('hotel_id' => '2878','room_id' => '13470'),
				array('hotel_id' => '2878','room_id' => '13471'),
				array('hotel_id' => '2901','room_id' => '13472'),
				array('hotel_id' => '2901','room_id' => '13473'),
				array('hotel_id' => '2879','room_id' => '13474'),
				array('hotel_id' => '2901','room_id' => '13475'),
				array('hotel_id' => '2879','room_id' => '13476'),
				array('hotel_id' => '2901','room_id' => '13477'),
				array('hotel_id' => '2879','room_id' => '13478'),
				array('hotel_id' => '2901','room_id' => '13479'),
				array('hotel_id' => '2879','room_id' => '13480'),
				array('hotel_id' => '2901','room_id' => '13481'),
				array('hotel_id' => '2901','room_id' => '13482'),
				array('hotel_id' => '2879','room_id' => '13483'),
				array('hotel_id' => '2901','room_id' => '13484'),
				array('hotel_id' => '2879','room_id' => '13485'),
				array('hotel_id' => '2901','room_id' => '13486'),
				array('hotel_id' => '2879','room_id' => '13487'),
				array('hotel_id' => '2901','room_id' => '13488'),
				array('hotel_id' => '2879','room_id' => '13489'),
				array('hotel_id' => '2901','room_id' => '13490'),
				array('hotel_id' => '2879','room_id' => '13491'),
				array('hotel_id' => '2903','room_id' => '13492'),
				array('hotel_id' => '2903','room_id' => '13493'),
				array('hotel_id' => '2880','room_id' => '13494'),
				array('hotel_id' => '2903','room_id' => '13495'),
				array('hotel_id' => '2880','room_id' => '13496'),
				array('hotel_id' => '2880','room_id' => '13497'),
				array('hotel_id' => '2880','room_id' => '13498'),
				array('hotel_id' => '2880','room_id' => '13499'),
				array('hotel_id' => '2903','room_id' => '13500'),
				array('hotel_id' => '2880','room_id' => '13501'),
				array('hotel_id' => '2903','room_id' => '13502'),
				array('hotel_id' => '2903','room_id' => '13503'),
				array('hotel_id' => '2881','room_id' => '13504'),
				array('hotel_id' => '2904','room_id' => '13505'),
				array('hotel_id' => '2881','room_id' => '13506'),
				array('hotel_id' => '2866','room_id' => '13507'),
				array('hotel_id' => '2881','room_id' => '13508'),
				array('hotel_id' => '2904','room_id' => '13509'),
				array('hotel_id' => '2881','room_id' => '13510'),
				array('hotel_id' => '2881','room_id' => '13511'),
				array('hotel_id' => '2881','room_id' => '13512'),
				array('hotel_id' => '2881','room_id' => '13513'),
				array('hotel_id' => '2881','room_id' => '13514'),
				array('hotel_id' => '2881','room_id' => '13515'),
				array('hotel_id' => '2904','room_id' => '13516'),
				array('hotel_id' => '2882','room_id' => '13517'),
				array('hotel_id' => '2904','room_id' => '13518'),
				array('hotel_id' => '2882','room_id' => '13519'),
				array('hotel_id' => '2904','room_id' => '13520'),
				array('hotel_id' => '2882','room_id' => '13521'),
				array('hotel_id' => '2904','room_id' => '13522'),
				array('hotel_id' => '2882','room_id' => '13523'),
				array('hotel_id' => '2904','room_id' => '13524'),
				array('hotel_id' => '2882','room_id' => '13525'),
				array('hotel_id' => '2904','room_id' => '13526'),
				array('hotel_id' => '2882','room_id' => '13527'),
				array('hotel_id' => '2882','room_id' => '13528'),
				array('hotel_id' => '2882','room_id' => '13529'),
				array('hotel_id' => '2907','room_id' => '13530'),
				array('hotel_id' => '2882','room_id' => '13531'),
				array('hotel_id' => '2907','room_id' => '13532'),
				array('hotel_id' => '2882','room_id' => '13533'),
				array('hotel_id' => '2907','room_id' => '13534'),
				array('hotel_id' => '2882','room_id' => '13535'),
				array('hotel_id' => '2882','room_id' => '13536'),
				array('hotel_id' => '2908','room_id' => '13537'),
				array('hotel_id' => '2908','room_id' => '13538'),
				array('hotel_id' => '2908','room_id' => '13539'),
				array('hotel_id' => '2908','room_id' => '13540'),
				array('hotel_id' => '2883','room_id' => '13541'),
				array('hotel_id' => '2883','room_id' => '13542'),
				array('hotel_id' => '2883','room_id' => '13543'),
				array('hotel_id' => '2883','room_id' => '13544'),
				array('hotel_id' => '2883','room_id' => '13545'),
				array('hotel_id' => '2883','room_id' => '13546'),
				array('hotel_id' => '2883','room_id' => '13547'),
				array('hotel_id' => '2884','room_id' => '13548'),
				array('hotel_id' => '2884','room_id' => '13549'),
				array('hotel_id' => '2884','room_id' => '13550'),
				array('hotel_id' => '2884','room_id' => '13551'),
				array('hotel_id' => '2884','room_id' => '13552'),
				array('hotel_id' => '2885','room_id' => '13553'),
				array('hotel_id' => '2885','room_id' => '13554'),
				array('hotel_id' => '2885','room_id' => '13555'),
				array('hotel_id' => '2885','room_id' => '13556'),
				array('hotel_id' => '2885','room_id' => '13557'),
				array('hotel_id' => '2885','room_id' => '13558'),
				array('hotel_id' => '2885','room_id' => '13559'),
				array('hotel_id' => '2886','room_id' => '13560'),
				array('hotel_id' => '2886','room_id' => '13561'),
				array('hotel_id' => '2886','room_id' => '13562'),
				array('hotel_id' => '2886','room_id' => '13563'),
				array('hotel_id' => '2910','room_id' => '13564'),
				array('hotel_id' => '2910','room_id' => '13565'),
				array('hotel_id' => '2910','room_id' => '13566'),
				array('hotel_id' => '2910','room_id' => '13567'),
				array('hotel_id' => '2910','room_id' => '13568'),
				array('hotel_id' => '2910','room_id' => '13569'),
				array('hotel_id' => '2910','room_id' => '13570'),
				array('hotel_id' => '2910','room_id' => '13571'),
				array('hotel_id' => '2910','room_id' => '13572'),
				array('hotel_id' => '2910','room_id' => '13573'),
				array('hotel_id' => '2910','room_id' => '13574'),
				array('hotel_id' => '2911','room_id' => '13575'),
				array('hotel_id' => '2911','room_id' => '13576'),
				array('hotel_id' => '2911','room_id' => '13577'),
				array('hotel_id' => '2911','room_id' => '13578'),
				array('hotel_id' => '2911','room_id' => '13579'),
				array('hotel_id' => '2911','room_id' => '13580'),
				array('hotel_id' => '2911','room_id' => '13581'),
				array('hotel_id' => '2911','room_id' => '13582'),
				array('hotel_id' => '2911','room_id' => '13583'),
				array('hotel_id' => '2911','room_id' => '13584'),
				array('hotel_id' => '2911','room_id' => '13585'),
				array('hotel_id' => '2911','room_id' => '13586'),
				array('hotel_id' => '2912','room_id' => '13587'),
				array('hotel_id' => '2912','room_id' => '13588'),
				array('hotel_id' => '2912','room_id' => '13589'),
				array('hotel_id' => '2912','room_id' => '13590'),
				array('hotel_id' => '2912','room_id' => '13591'),
				array('hotel_id' => '2912','room_id' => '13592'),
				array('hotel_id' => '2913','room_id' => '13593'),
				array('hotel_id' => '2913','room_id' => '13594'),
				array('hotel_id' => '2913','room_id' => '13595'),
				array('hotel_id' => '2916','room_id' => '13596'),
				array('hotel_id' => '2916','room_id' => '13597'),
				array('hotel_id' => '2916','room_id' => '13598'),
				array('hotel_id' => '2916','room_id' => '13599'),
				array('hotel_id' => '2916','room_id' => '13600'),
				array('hotel_id' => '2916','room_id' => '13601'),
				array('hotel_id' => '2916','room_id' => '13602'),
				array('hotel_id' => '2916','room_id' => '13603'),
				array('hotel_id' => '2916','room_id' => '13604'),
				array('hotel_id' => '2887','room_id' => '13605'),
				array('hotel_id' => '2887','room_id' => '13606'),
				array('hotel_id' => '2887','room_id' => '13607'),
				array('hotel_id' => '2887','room_id' => '13608'),
				array('hotel_id' => '2888','room_id' => '13609'),
				array('hotel_id' => '2888','room_id' => '13610'),
				array('hotel_id' => '2888','room_id' => '13611'),
				array('hotel_id' => '2888','room_id' => '13612'),
				array('hotel_id' => '2888','room_id' => '13613'),
				array('hotel_id' => '2888','room_id' => '13614'),
				array('hotel_id' => '2888','room_id' => '13615'),
				array('hotel_id' => '2888','room_id' => '13616'),
				array('hotel_id' => '2889','room_id' => '13617'),
				array('hotel_id' => '2889','room_id' => '13618'),
				array('hotel_id' => '2889','room_id' => '13619'),
				array('hotel_id' => '2889','room_id' => '13620'),
				array('hotel_id' => '2889','room_id' => '13621'),
				array('hotel_id' => '2889','room_id' => '13622'),
				array('hotel_id' => '2889','room_id' => '13623'),
				array('hotel_id' => '2889','room_id' => '13624'),
				array('hotel_id' => '2889','room_id' => '13625'),
				array('hotel_id' => '2889','room_id' => '13626'),
				array('hotel_id' => '2889','room_id' => '13627'),
				array('hotel_id' => '2889','room_id' => '13628'),
				array('hotel_id' => '2889','room_id' => '13629'),
				array('hotel_id' => '2889','room_id' => '13630'),
				array('hotel_id' => '2889','room_id' => '13631'),
				array('hotel_id' => '2890','room_id' => '13632'),
				array('hotel_id' => '2890','room_id' => '13633'),
				array('hotel_id' => '2890','room_id' => '13634'),
				array('hotel_id' => '2890','room_id' => '13635'),
				array('hotel_id' => '2890','room_id' => '13636'),
				array('hotel_id' => '2890','room_id' => '13637'),
				array('hotel_id' => '2890','room_id' => '13638'),
				array('hotel_id' => '2890','room_id' => '13639'),
				array('hotel_id' => '2890','room_id' => '13640'),
				array('hotel_id' => '2891','room_id' => '13641'),
				array('hotel_id' => '2891','room_id' => '13642'),
				array('hotel_id' => '2891','room_id' => '13643'),
				array('hotel_id' => '2891','room_id' => '13644'),
				array('hotel_id' => '2891','room_id' => '13645'),
				array('hotel_id' => '2905','room_id' => '13646'),
				array('hotel_id' => '2905','room_id' => '13647'),
				array('hotel_id' => '2905','room_id' => '13648'),
				array('hotel_id' => '2905','room_id' => '13649'),
				array('hotel_id' => '2905','room_id' => '13650'),
				array('hotel_id' => '2905','room_id' => '13651'),
				array('hotel_id' => '2905','room_id' => '13652'),
				array('hotel_id' => '2905','room_id' => '13653'),
				array('hotel_id' => '2906','room_id' => '13654'),
				array('hotel_id' => '2906','room_id' => '13655'),
				array('hotel_id' => '2906','room_id' => '13656'),
				array('hotel_id' => '2906','room_id' => '13657'),
				array('hotel_id' => '2906','room_id' => '13658'),
				array('hotel_id' => '2906','room_id' => '13659'),
				array('hotel_id' => '2906','room_id' => '13660'),
				array('hotel_id' => '2906','room_id' => '13661'),
				array('hotel_id' => '2906','room_id' => '13662'),
				array('hotel_id' => '2906','room_id' => '13663'),
				array('hotel_id' => '2909','room_id' => '13664'),
				array('hotel_id' => '2909','room_id' => '13665'),
				array('hotel_id' => '2909','room_id' => '13666'),
				array('hotel_id' => '2909','room_id' => '13667'),
				array('hotel_id' => '2909','room_id' => '13668'),
				array('hotel_id' => '2909','room_id' => '13671'),
				array('hotel_id' => '2909','room_id' => '13672'),
				array('hotel_id' => '2909','room_id' => '13674'),
				array('hotel_id' => '2909','room_id' => '13675'),
				array('hotel_id' => '2909','room_id' => '13676'),
				array('hotel_id' => '2909','room_id' => '13677'),
				array('hotel_id' => '2909','room_id' => '13678'),
				array('hotel_id' => '2909','room_id' => '13679'),
				array('hotel_id' => '2914','room_id' => '13680'),
				array('hotel_id' => '2914','room_id' => '13681'),
				array('hotel_id' => '2914','room_id' => '13682'),
				array('hotel_id' => '2914','room_id' => '13683'),
				array('hotel_id' => '2914','room_id' => '13684'),
				array('hotel_id' => '2914','room_id' => '13685'),
				array('hotel_id' => '2918','room_id' => '13686'),
				array('hotel_id' => '2918','room_id' => '13687'),
				array('hotel_id' => '2918','room_id' => '13688'),
				array('hotel_id' => '2918','room_id' => '13689'),
				array('hotel_id' => '2918','room_id' => '13690'),
				array('hotel_id' => '2918','room_id' => '13691'),
				array('hotel_id' => '2919','room_id' => '13692'),
				array('hotel_id' => '2919','room_id' => '13693'),
				array('hotel_id' => '2919','room_id' => '13694'),
				array('hotel_id' => '2919','room_id' => '13695'),
				array('hotel_id' => '2919','room_id' => '13696'),
				array('hotel_id' => '2920','room_id' => '13697'),
				array('hotel_id' => '2920','room_id' => '13698'),
				array('hotel_id' => '2920','room_id' => '13699'),
				array('hotel_id' => '2920','room_id' => '13700'),
				array('hotel_id' => '2920','room_id' => '13701'),
				array('hotel_id' => '2920','room_id' => '13702'),
				array('hotel_id' => '2920','room_id' => '13703'),
				array('hotel_id' => '2920','room_id' => '13704'),
				array('hotel_id' => '2921','room_id' => '13706'),
				array('hotel_id' => '2921','room_id' => '13707'),
				array('hotel_id' => '2921','room_id' => '13708'),
				array('hotel_id' => '2921','room_id' => '13709'),
				array('hotel_id' => '2921','room_id' => '13710'),
				array('hotel_id' => '2921','room_id' => '13711'),
				array('hotel_id' => '2921','room_id' => '13712'),
				array('hotel_id' => '2866','room_id' => '13713'),
				array('hotel_id' => '2921','room_id' => '13714'),
				array('hotel_id' => '2921','room_id' => '13715'),
				array('hotel_id' => '2921','room_id' => '13716'),
				array('hotel_id' => '2922','room_id' => '13717'),
				array('hotel_id' => '2922','room_id' => '13718'),
				array('hotel_id' => '2922','room_id' => '13719'),
				array('hotel_id' => '2922','room_id' => '13720'),
				array('hotel_id' => '2922','room_id' => '13721'),
				array('hotel_id' => '2922','room_id' => '13722'),
				array('hotel_id' => '2922','room_id' => '13723'),
				array('hotel_id' => '2923','room_id' => '13724'),
				array('hotel_id' => '2923','room_id' => '13726'),
				array('hotel_id' => '2923','room_id' => '13727'),
				array('hotel_id' => '2923','room_id' => '13728'),
				array('hotel_id' => '2923','room_id' => '13729'),
				array('hotel_id' => '2923','room_id' => '13730'),
				array('hotel_id' => '2923','room_id' => '13731'),
				array('hotel_id' => '2924','room_id' => '13732'),
				array('hotel_id' => '2924','room_id' => '13733'),
				array('hotel_id' => '2924','room_id' => '13734'),
				array('hotel_id' => '2924','room_id' => '13735'),
				array('hotel_id' => '2924','room_id' => '13736'),
				array('hotel_id' => '2925','room_id' => '13737'),
				array('hotel_id' => '2925','room_id' => '13738'),
				array('hotel_id' => '2925','room_id' => '13739'),
				array('hotel_id' => '2925','room_id' => '13740'),
				array('hotel_id' => '2925','room_id' => '13741'),
				array('hotel_id' => '2925','room_id' => '13742'),
				array('hotel_id' => '2925','room_id' => '13743'),
				array('hotel_id' => '2925','room_id' => '13744'),
				array('hotel_id' => '2925','room_id' => '13745'),
				array('hotel_id' => '2926','room_id' => '13747'),
				array('hotel_id' => '2926','room_id' => '13748'),
				array('hotel_id' => '2926','room_id' => '13749'),
				array('hotel_id' => '2926','room_id' => '13750'),
				array('hotel_id' => '2926','room_id' => '13751'),
				array('hotel_id' => '2926','room_id' => '13752'),
				array('hotel_id' => '2926','room_id' => '13754'),
				array('hotel_id' => '2926','room_id' => '13755'),
				array('hotel_id' => '2926','room_id' => '13756'),
				array('hotel_id' => '2926','room_id' => '13757'),
				array('hotel_id' => '2927','room_id' => '13759'),
				array('hotel_id' => '2927','room_id' => '13760'),
				array('hotel_id' => '2928','room_id' => '13762'),
				array('hotel_id' => '2928','room_id' => '13763'),
				array('hotel_id' => '2928','room_id' => '13764'),
				array('hotel_id' => '2928','room_id' => '13765'),
				array('hotel_id' => '2928','room_id' => '13766'),
				array('hotel_id' => '2917','room_id' => '13767'),
				array('hotel_id' => '2917','room_id' => '13768'),
				array('hotel_id' => '2917','room_id' => '13769'),
				array('hotel_id' => '2917','room_id' => '13770'),
				array('hotel_id' => '2929','room_id' => '13771'),
				array('hotel_id' => '2929','room_id' => '13772'),
				array('hotel_id' => '2929','room_id' => '13773'),
				array('hotel_id' => '2929','room_id' => '13774'),
				array('hotel_id' => '2934','room_id' => '13775'),
				array('hotel_id' => '2934','room_id' => '13776'),
				array('hotel_id' => '2934','room_id' => '13777'),
				array('hotel_id' => '2934','room_id' => '13778'),
				array('hotel_id' => '2935','room_id' => '13779'),
				array('hotel_id' => '2935','room_id' => '13780'),
				array('hotel_id' => '2935','room_id' => '13781'),
				array('hotel_id' => '2935','room_id' => '13782'),
				array('hotel_id' => '2935','room_id' => '13783'),
				array('hotel_id' => '2935','room_id' => '13784'),
				array('hotel_id' => '2930','room_id' => '13785'),
				array('hotel_id' => '2930','room_id' => '13786'),
				array('hotel_id' => '2930','room_id' => '13787'),
				array('hotel_id' => '2930','room_id' => '13788'),
				array('hotel_id' => '2930','room_id' => '13789'),
				array('hotel_id' => '2930','room_id' => '13790'),
				array('hotel_id' => '2931','room_id' => '13791'),
				array('hotel_id' => '2931','room_id' => '13792'),
				array('hotel_id' => '2931','room_id' => '13793'),
				array('hotel_id' => '2931','room_id' => '13794'),
				array('hotel_id' => '2931','room_id' => '13795'),
				array('hotel_id' => '2932','room_id' => '13796'),
				array('hotel_id' => '2932','room_id' => '13797'),
				array('hotel_id' => '2932','room_id' => '13798'),
				array('hotel_id' => '2932','room_id' => '13799'),
				array('hotel_id' => '2932','room_id' => '13800'),
				array('hotel_id' => '2932','room_id' => '13801'),
				array('hotel_id' => '2932','room_id' => '13802'),
				array('hotel_id' => '2933','room_id' => '13803'),
				array('hotel_id' => '2933','room_id' => '13804'),
				array('hotel_id' => '2933','room_id' => '13805'),
				array('hotel_id' => '2933','room_id' => '13806'),
				array('hotel_id' => '2933','room_id' => '13807'),
				array('hotel_id' => '2933','room_id' => '13808'),
				array('hotel_id' => '2933','room_id' => '13809'),
				array('hotel_id' => '2936','room_id' => '13810'),
				array('hotel_id' => '2936','room_id' => '13811'),
				array('hotel_id' => '2936','room_id' => '13812'),
				array('hotel_id' => '2936','room_id' => '13813'),
				array('hotel_id' => '2938','room_id' => '13814'),
				array('hotel_id' => '2938','room_id' => '13815'),
				array('hotel_id' => '2938','room_id' => '13816'),
				array('hotel_id' => '2938','room_id' => '13817'),
				array('hotel_id' => '2938','room_id' => '13818'),
				array('hotel_id' => '2938','room_id' => '13819'),
				array('hotel_id' => '2938','room_id' => '13820'),
				array('hotel_id' => '2937','room_id' => '13821'),
				array('hotel_id' => '2937','room_id' => '13822'),
				array('hotel_id' => '2937','room_id' => '13823'),
				array('hotel_id' => '2937','room_id' => '13824'),
				array('hotel_id' => '2937','room_id' => '13825'),
				array('hotel_id' => '2937','room_id' => '13826'),
				array('hotel_id' => '2937','room_id' => '13827'),
				array('hotel_id' => '2937','room_id' => '13828'),
				array('hotel_id' => '2937','room_id' => '13829'),
				array('hotel_id' => '2937','room_id' => '13830'),
				array('hotel_id' => '2937','room_id' => '13831'),
				array('hotel_id' => '2893','room_id' => '13866'),
				array('hotel_id' => '2893','room_id' => '13867'),
				array('hotel_id' => '2893','room_id' => '13868'),
				array('hotel_id' => '2893','room_id' => '13869'),
				array('hotel_id' => '2972','room_id' => '13870'),
				array('hotel_id' => '2972','room_id' => '13871'),
				array('hotel_id' => '2972','room_id' => '13872'),
				array('hotel_id' => '2972','room_id' => '13873'),
				array('hotel_id' => '2972','room_id' => '13874'),
				array('hotel_id' => '2972','room_id' => '13875'),
				array('hotel_id' => '2972','room_id' => '13876'),
				array('hotel_id' => '2972','room_id' => '13877'),
				array('hotel_id' => '2915','room_id' => '14150'),
				array('hotel_id' => '2915','room_id' => '14151'),
				array('hotel_id' => '2915','room_id' => '14152'),
				array('hotel_id' => '2915','room_id' => '14153'),
				array('hotel_id' => '2915','room_id' => '14154')
		);
		$inter_id='a468209719';
		foreach ($iwide_hotel_rooms as $room){
			$tmp=array('inter_id'=>$inter_id,'hotel_id'=>$room['hotel_id'],'room_id'=>$room['room_id'],'type'=>'hotel_room_lightbox');
			$tmp['image_url']='http://file.iwide.cn/public/uploads/201607/a_'.$room['hotel_id'].'_'.$room['room_id'].'.jpg';
			echo $this->db->insert_string('hotel_images',$tmp).';'.'<br />';
		}
	}
	
	function daili() {
		error_reporting(-1);
		ini_set ( 'display_errors', 0 );
		$t=$this->input->get('t');
		$this->load->helper('common');
		$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
		$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
		$this->db->insert('weixin_text',array('content'=>$t.'-'.$user_IP,
				'edit_date'=>date('Y-m-d H:i:s')));
		sleep(1);
		$result=$this->db->query("select * from iwide_weixin_text where content like '$t-%' and id >13774 order by id desc limit 100")->result_array();
		foreach ($result as $r){
			echo $r['content'].'-'.$r['edit_date'].'<br />';
		}
		echo count($result).'条访问记录';
	}
	function stime(){
		echo time();
	}
	function redit(){
		echo date('Y-m-d H:i:s');
		$this->sysconfig = $this->config->config;
		$redis = new Redis ();
		$redis->connect('120.27.132.97',$this->sysconfig['test_redis_port']);
		$key = 'a';
		$value = 'b';
		$redis->set ( $key, $value, 600 );
		echo $redis->get ( 'a' );
	}
	
	function member_test(){
		$this->load->model('hotel/Coupon_new_model');
		$this->load->model('hotel/Member_new_model');
		$inter_id='a449675133';
		// 		$inter_id='a429262687';
		// 		$openid='oX3WojmwFD6GYsEgDTJH1qeRCHqE';
		// 		$openid='oX3WojhfNUD4JzmlwTzuKba1MywY';
		$openid='ocbScjgsBYrqOSI3q80te1dYB3SY';
		$orderid='test';
		$card_id=1000183;
		$amount=100000;
		$note='测试积分';
		// 		$result=$this->Coupon_new_model->getNewCoupon($openid,$inter_id,$card_id,time().rand(0,9999));
		// 		$result=$this->Member_new_model->addBonus($openid, $amount, $note, $orderid, $inter_id);
		// 		$result=$this->Member_new_model->getMemberByOpenId($inter_id,$openid);
		$result=$this->Member_new_model->get_pms_member($inter_id,$openid);
		// 		$result=$this->Coupon_new_model->myCoupons($openid,$inter_id);
		// 		$result['data']=(object)$result['data'];
		var_dump($result);
	}
	function yasite(){
		$soap_opt = [
				'soap_version' => SOAP_1_1,
				'encoding'     => 'UTF-8',
		];
		$this->soap = new SoapClient('http://121.41.82.114:9026/IWideService.asmx?wsdl', $soap_opt);
		$params = [
				'ChainID' => '41',
				'FolioID' => '25088',
		];
		$obj = $this->soap->__soapCall('QueryOrder', [
				'parameters' => $params
		]);
		print_r($obj);
	}
	function yibo_pay(){
		$this->load->model('hotel/pms/Yibo_hotel_model');
		echo "<form method='get' action='' align='center' />";
		echo "<input type='text' name='web_orderid' placeholder='pms 订单号' />";
		echo "<br /><br /><input type='text' name='price' placeholder='价格' />";
		echo "<br /><br /><input type='text' name='orderid' placeholder='微信单号' />";
		echo "<br /><br /><input type='submit' />";
		if ($this->input->get('web_orderid')&&$this->input->get('price')&&$this->input->get('orderid')){
			$url = 'http://h5.100inn.cc/DiscountService.asmx/DepositOrder';
			$data ['orderNo'] = $this->input->get('web_orderid');
			$data ['account'] = $this->input->get('price');
			$data ['mobile'] = $this->input->get('orderid');
			$this->load->helper ( 'common' );
			$this->db->insert('hotel_admin_log',array(
							'inter_id'=>'a441098524',
							'admin'=>'kefu',
							'url'=>$_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'],
							'ip'=>getIp (),
							'ident'=>'yibo_'.$data ['orderNo'],
							'record_time'=>date('Y-m-d H:i:s'),
							'key_data'=>json_encode($data),
							'log_type'=>'yibo_paid'
					));
			$s = $this->Yibo_hotel_model->post_to($url, $data);
			if($s ['Result'] == 1){
				$this->session->set_userdata ( 'message', '操作成功' );
			}else{
				$this->session->set_userdata ( 'message', '操作失败，'.$s['Message'] );
			}
			redirect(site_url('hotel/trans/yibo_pay'));
		}else{
			echo '以上均为必填';
		}
		if ($this->session->userdata ( 'message' )){
			echo '<br /><p style="color:red">'.$this->session->userdata ( 'message' ).'</p>';
			$this->session->set_userdata ( 'message', '' );
		}
		echo '</form>';
	}
	function server(){
		var_dump($_SERVER);
	}
}

	