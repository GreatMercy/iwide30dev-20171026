<?php
class Coupon_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	const STATUS_DID_NOT_RECEIVE = 0; // 未领取
	const STATUS_HAVE_RECEIVE = 1; // 已经领取
	const STATUS_DONATE_COMPLETION = 2; // 转赠完毕
	const STATUS_CANCEL_VERIFICATION = 3; // 核销
	const STATUS_DELETE = 4; // 用户删除
	const STATUS_FREEZE = 5; // 冻结
	const STATUS_GRANT = 6; // 未发放
	const TAB_MGCL = 'member_get_card_list';
	function get_coupon_set($inter_id, $idents = array()) {
		$this->db->where ( array (
				'inter_id' => $inter_id 
		) );
		empty ( $idents ['status'] ) ? $this->db->where_in ( 'status', array (
				1,
				2 
		) ) : $this->db->where ( 'status', $idents ['status'] );
		if (empty ( $idents ['hotel_id'] )) {
			$this->db->where_in ( 'hotel_id', 0 );
			$this->db->where ( 'status', $idents ['status'] );
		}
	}
	function get_usable_coupon($inter_id, $openid, $params, $is_ajax = false ,$vid=NULL) {
		if (!isset($vid)){
			$this->load->model('hotel/Member_model');
			$vid=$this->Member_model->get_vid($inter_id);
		}
		
		if (isset($params['price_code'])){
			$this->load->model('hotel/Price_code_model');
        	$code_check=$this->Price_code_model->check_special_code($params['price_code'],$inter_id);
        	if (!empty($code_check)){
        		$params['price_code'] = $code_check['true_code'];
        	}
		}
		
		if (!empty($vid)&&$vid==1){
			$data= $this->get_usable_coupon_v($inter_id, $openid, $params,$is_ajax);
		}else{
			$data= $this->get_usable_coupon_m($inter_id, $openid, $params,$is_ajax);
		}
		$data['vid']=$vid;
		return $data;
	}
	function get_usable_coupon_v($inter_id, $openid, $params, $is_ajax = false){
		$this->load->model('hotel/Coupon_new_model');
		
		$result = array ();
		$count = array ();
		$wxcards = array ();
		$this->load->model('hotel/Price_code_model');
		$list=array();
        $all_cards=array();
		$coupon_condition=array();
		if (is_numeric($params ['price_code']))
			$list = $this->Price_code_model->get_room_price_set ( $inter_id, $params ['hotel'], $params ['category'], $params ['price_code'] );
		if (! empty ( $list )) {
			$list = $list [0];
			if (!empty($list['suse_condition'])){
				$condition=json_decode($list['suse_condition'],TRUE);
			}else {
				$condition=json_decode($list['use_condition'],TRUE);
			}
			if (!empty($list['scoupon_condition'])){
				$coupon_condition=json_decode($list['scoupon_condition'],TRUE);
			}else {
				$coupon_condition=json_decode($list['coupon_condition'],TRUE);
			}
		}else{
			$this->load->model ( 'common/Webservice_model' );
			$level_reflect = $this->Webservice_model->get_web_reflect ( $inter_id, $params ['hotel'], 'pms', array (
					'code_coupon_set'
			), 1, 'w2l' );
			if (!empty($level_reflect['code_coupon_set'])){
				if (!empty($level_reflect['code_coupon_set'][$params ['price_code']])){
					$coupon_condition=json_decode($level_reflect['code_coupon_set'][$params ['price_code']],TRUE);
				}else if (!empty($level_reflect['code_coupon_set']['all_price'])){
					$coupon_condition=json_decode($level_reflect['code_coupon_set']['all_price'],TRUE);
				}
			}
		}

		if (!empty($coupon_condition)){
			if (!empty($condition['no_coupon'])||!empty($coupon_condition['no_coupon'])||empty($coupon_condition['num_type'])){
				return array (
						'cards' => $result,
						'wxcards' => $wxcards,
						'count' => $count
				);
			}
			$room_night_use = array ();
			$order_use = array ();
			$card_types=array('1'=>'voucher','2'=>'discount','3'=>'exchange');

            $is_pms = isset($coupon_condition['is_pms']) ? $coupon_condition['is_pms'] : 0;//判断是否使用pms券
//            if(!empty($coupon_condition['extra_para'])){//若pms券需要额外参数，增加
			if($is_pms){
//				if(in_array('web_id', $coupon_condition['extra_para'])){
                    //PMS上的酒店代码
                    $hotel_room = $this->db->from('hotel_rooms r')
                    ->join('hotel_additions a', "a.hotel_id=r.hotel_id", 'left')
                    ->where(array(
                           'r.room_id'  => (int)$params['category'],
                           'a.hotel_id' => (int)$params['hotel'],
                           'r.inter_id' => $inter_id,
                       ))->select('a.hotel_web_id,r.webser_id')->get()->row_array();
                    if($hotel_room){
                        $params['hotel_web_id'] = $hotel_room['hotel_web_id'];
                        $params['webser_id'] = $hotel_room['webser_id'];
                    }
				if(is_numeric($params ['price_code'])){
					//价格代码
					$price_info = $this->db->from('hotel_price_info')->where([
						                                                         'inter_id'   => $inter_id,
						                                                         'price_code' => $params['price_code']
					                                                         ])->get()->row_array();
					if($price_info){
						$params['web_ratecode'] = $price_info['external_code'];
					}
				}
//                }
            }

            if(empty($params['all_cards'])){
                $all_cards=$this->Coupon_new_model->myCoupons($openid,$inter_id,'',$is_pms,$params);
            }else{
                $all_cards = $params['all_cards'];
            }

			if (!empty($all_cards['data'])){
				$num_type='order';
				$num=0;
				$room_nights = $params ['rooms'] * $params ['days'];
				$num_type=$coupon_condition['num_type'];
				$num=empty($coupon_condition['coupon_num'])?0:intval($coupon_condition['coupon_num']);
				$num=$num_type=='order'?$num:$num*$room_nights;

				if (!empty($params['related_coupons'])){
					foreach ($all_cards['data'] as $d){
						if (!empty($count['related_use'][$d['card_id']])&&$count['related_use'][$d['card_id']]['expire_time']>$d['expire_time']){
							$count['related_use'][$d['card_id']]=$d;
						}
						if (isset($params['related_coupons'][$d['card_id']])){
							$count['related_use'][$d['card_id']]=$d;
							unset($params['related_coupons'][$d['card_id']]);
						}
					}
					if (!empty($params['related_coupons'])){
						$count['no_related']=1;
					}
				}
				
                if(!$is_pms){
                    $this->load->model('hotel/Coupons_model');
                    $data=$this->Coupons_model->check_userule($inter_id,$all_cards['data'],$params);
                    $all_cards['data']=$data['valid_cards'];
                    $count['effects']=$data['effects'];
                }
			}else{
				return array (
						'cards' => $result,
						'wxcards' => $wxcards,
						'count' => $count
				);
			}
			foreach ( $all_cards['data'] as $c ) {
				$tmp=new stdClass();
				$tmp->valid_date=date('Y-m-d',$c['expire_time']);
				$tmp->date_info_end_timestamp=$c['expire_time'];
				$tmp->coupon_type=$card_types[$c['card_type']];
				$tmp->code=$c['member_card_id'];
				$tmp->reduce_cost=$c['reduce_cost'];
				if ($tmp->coupon_type=='discount'){
					$tmp->reduce_cost=$c['discount']*0.1;
				}
				$tmp->ci_id=$c['card_id'];
				$tmp->title=$c['title'];
				$tmp->brand_name=$c['title'];
				$tmp->rule_id=$c['effect_rule_id'];
				$tmp->status=1;
				$tmp->is_wxcard = 0;
				$tmp->card_id = '';
				
				if (!empty($c->extra)){
					$tmp->extra=$c->extra;
				}
				
				if (! $is_ajax) {
					$result [$tmp->code] = $tmp;
				} else {
					$result [] = $tmp;
				}
			}
			$count ['num_type'] = $num_type;
			$count ['num'] = $num;
		}
		return array (
				'cards' => $result,
				'wxcards' => $wxcards,
				'count' => $count,
                'all_cards'=>$all_cards
		);
	}
	function get_usable_coupon_m($inter_id, $openid, $params, $is_ajax = false) {
            $this->load->model ( 'member/Icardrule' );
            $all_cards = $this->Icardrule->getRulesByParams ( $openid, 'room', $inter_id, $params );
            $result = array ();
            $count = array ();
            $wxcards = array ();
            $room_nights = $params ['rooms'] * $params ['days'];
            if (! empty ( $all_cards )) {
                $room_night_use = array ();
                $order_use = array ();
                foreach ( $all_cards as $c ) {
                    $c->valid_date=date('Y-m-d H:i:s',$c->date_info_end_timestamp);
                    if (empty($c->coupon_type))
                        $c->coupon_type='voucher';
                    if (isset ( $c->restriction ['room_nights'] )) {
                        $c->hotel_use_num_type = 'room_nights';
                        $c->hotel_max_use_num = $c->restriction ['room_nights'] * $room_nights;
                        $room_night_use [] = $c->restriction ['room_nights'] * $room_nights;
                    } else if (isset ( $c->restriction ['order'] )) {
                        $c->hotel_use_num_type = 'order';
                        $c->hotel_max_use_num = $c->restriction ['order'];
                        $order_use [] = $c->restriction ['order'];
                    }
                    if(isset($c->status)){
                        if ($c->status == 7) {
                            $wxcards [$c->code] = $c->card_id;
                            $c->is_wxcard = 1;
                        } else {
                            $c->is_wxcard = 0;
                        }
                    }

                    if (! $is_ajax) {
                        $result [$c->code] = $c;
                    } else {
                        $result [] = $c;
                    }
                }
                $count ['max_room_night_use'] = empty ( $room_night_use ) ? 0 : min ( $room_night_use );
                $count ['max_order_use'] = empty ( $order_use ) ? 0 : min ( $order_use );
                // $wxcards = $all_cards['wxcards'];
            }

		//$result可增加多个属性extra，用于附加信息
		return array (
				'cards' => $result,
				'wxcards' => $wxcards,
				'count' => $count 
		);
	}
	function check_coupon_using($inter_id, $openid, $params, $coupons,$coupon_data=array(),$related_coupons=array()){
		$this->load->model('hotel/Member_model');
		$vid=$this->Member_model->get_vid($inter_id);
		
		if (isset($params['price_code'])){
			$this->load->model('hotel/Price_code_model');
			$code_check=$this->Price_code_model->check_special_code($params['price_code'],$inter_id);
			if (!empty($code_check)){
				$params['price_code'] = $code_check['true_code'];
			}
		}
		
		if (!empty($vid)&&$vid==1){
			$data= $this->check_coupon_using_v($inter_id, $openid, $params,$coupons,$coupon_data,$related_coupons);
		}else{
			$data= $this->check_coupon_using_m($inter_id, $openid, $params, $coupons,$coupon_data);
		}
		$data['vid']=$vid;
		return $data;
	}
	function check_coupon_using_m($inter_id, $openid, $params, $coupons,$coupon_data=array()) {
		$cards = $this->get_usable_coupon_m ( $inter_id, $openid, $params );
		$coupon_num_count = array ();
		$coupon_info = array ();
		$coupon_amount = 0;
		
		foreach ( $coupons as $k ) {
			if (! empty ( $cards ['cards'] [$k] ) || ! empty ( $cards ['wxcards'] [$k] )) {
				empty ( $coupon_num_count [$cards ['cards'] [$k]->hotel_use_num_type] ) ? $coupon_num_count [$cards ['cards'] [$k]->hotel_use_num_type] = 1 : $coupon_num_count [$cards ['cards'] [$k]->hotel_use_num_type] ++;
				if (! empty ( $cards ['cards'] [$k]->reduce_cost )) {
					$extra=empty($cards ['cards'] [$k]->extra)?array():$cards ['cards'] [$k]->extra;
					if (empty($cards ['cards'] [$k]->coupon_type)||$cards ['cards'] [$k]->coupon_type=='voucher'){
						
						//速8房间有用券金额限制
						$tmp_amout=$inter_id=='a455510007'?$coupon_data[$k]:$cards ['cards'] [$k]->reduce_cost;

						$extra['type']='voucher';
                        //锦江优惠券类型限制
                        if(isset($cards ['cards'] [$k]->pms_coupon_type)){
                            $coupon_info ['cash_token'] [] = array (
                                'amount' => $tmp_amout,
                                'code' => $k,
                                'title' => $cards ['cards'] [$k]->title,
                                'is_wxcard' => $cards ['cards'] [$k]->is_wxcard,
                                'wxcard_id' => $cards ['cards'] [$k]->card_id,
                                'extra'=> $extra,
                                'coupon_type'=>$cards ['cards'] [$k]->pms_coupon_type
                            );
                        }else{
                            $coupon_info ['cash_token'] [] = array (
                                'amount' => $tmp_amout,
                                'code' => $k,
                                'title' => $cards ['cards'] [$k]->title,
                                'is_wxcard' => $cards ['cards'] [$k]->is_wxcard,
                                'wxcard_id' => $cards ['cards'] [$k]->card_id,
                                'extra'=> $extra
                            );
                        }

						$coupon_amount += $tmp_amout;
					}else if($cards ['cards'] [$k]->coupon_type=='discount'){
						$reduce=$params ['amount']-$params ['amount']*$cards ['cards'] [$k]->reduce_cost;
						$extra['type']='discount';
						$coupon_info ['cash_token'] [] = array (
								'amount' => $reduce,
								'code' => $k,
								'title' => $cards ['cards'] [$k]->title,
								'is_wxcard' => $cards ['cards'] [$k]->is_wxcard,
								'wxcard_id' => $cards ['cards'] [$k]->card_id,
								'extra'=> $extra
						);
						$coupon_amount += $reduce;
					}
				}
			} else {
				return array (
						's' => 0,
						'errmsg' => '选择了无效或过期的优惠券。' 
				);
			}
		}
		if (! empty ( $coupon_num_count )) {
			foreach ( $coupon_num_count as $ck => $cnc ) {
				if (isset ( $cards ['count'] [$ck] ) && $cnc > $cards ['count'] [$ck]) {
					return array (
							's' => 0,
							'errmsg' => '选择的优惠券太多啦' 
					);
				}
			}
			return array (
					's' => 1,
					'coupon_amount' => $coupon_amount,
					'coupon_info' => $coupon_info 
			);
		}
		return array (
				's' => 0,
				'errmsg' => '您没有优惠券' 
		);
	}
	function check_coupon_using_v($inter_id, $openid, $params, $coupons,$coupon_data=array(),$related_coupons=array()) {
		$params['related_coupons']=$related_coupons;
		$cards = $this->get_usable_coupon_v ( $inter_id, $openid, $params );
		$coupon_info = array ();
		$coupon_amount = 0;
		$coupon_rel = array ();

		if (!empty($related_coupons)){
			if (!empty($cards['count']['no_related'])||empty($cards['count']['related_use'])){
				return array (
						's' => 0,
						'errmsg' => '您没有对应的兑换券'
				);
			}
			$tmp=array('inter_id'=>$inter_id,'status'=>0,'rel_type'=>1);
			foreach ($cards['count']['related_use'] as $r){
				$tmp['amount']=$r['reduce_cost'];
				$tmp['code']=$r['member_card_id'];
				$tmp['title']=$r['title'];
// 				$tmp['extra']=json_encode($r['extra'],JSON_UNESCAPED_UNICODE);
// 				$tmp['rule_id']=$r['rule_id'];
				$tmp['card_id']=$r['card_id'];
// 				$tmp['wxcard_id']=$r['wxcard_id'];
				$tmp['create_time']=date('Y-m-d H:i:s');
				$coupon_rel[$r['member_card_id']]=$tmp;
				
				$coupon_info ['exchange'] [] = array (
						'amount' => $r['reduce_cost'],
						'code' => $r['member_card_id'],
						'title' => $r['title'],
						'cid'=>$r['card_id']
				);
			}
		}
		if (!empty($coupons)){
			foreach ( $coupons as $k ) {
				if (! empty ( $cards ['cards'] [$k] ) || ! empty ( $cards ['wxcards'] [$k] )) {
					if (! empty ( $cards ['cards'] [$k]->reduce_cost )) {
						$extra=empty($cards ['cards'] [$k]->extra)?array():$cards ['cards'] [$k]->extra;
						if (empty($cards ['cards'] [$k]->coupon_type)||$cards ['cards'] [$k]->coupon_type=='voucher'){
							$tmp_amout=$cards ['cards'] [$k]->reduce_cost;
							$extra['type']='voucher';
	                        $coupon_info ['cash_token'] [] = array (
									'amount' => $tmp_amout,
									'code' => $k,
	                               	'title' => $cards ['cards'] [$k]->title,
	                              	'is_wxcard' => $cards ['cards'] [$k]->is_wxcard,
	                              	'wxcard_id' => $cards ['cards'] [$k]->card_id,
	                              	'extra'=> $extra,
	                        		'cid'=>$cards ['cards'] [$k]->ci_id,
	                        		'rule_id'=>$cards['cards'][$k]->rule_id
	                        );
	
							$coupon_amount += $tmp_amout;
						}else if($cards ['cards'] [$k]->coupon_type=='discount'){
							$reduce=$params ['amount']-$params ['amount']*$cards ['cards'] [$k]->reduce_cost;
							$extra['type']='discount';
							$coupon_info ['cash_token'] [] = array (
									'amount' => $reduce,
									'code' => $k,
									'title' => $cards ['cards'] [$k]->title,
									'is_wxcard' => $cards ['cards'] [$k]->is_wxcard,
									'wxcard_id' => $cards ['cards'] [$k]->card_id,
									'extra'=> $extra,
									'cid'=>$cards ['cards'] [$k]->ci_id,
	                        		'rule_id'=>$cards['cards'][$k]->rule_id
							);
							$coupon_amount += $reduce;
						}
					}
				} else {
					return array (
							's' => 0,
							'errmsg' => '选择了无效或过期的优惠券。' 
					);
				}
			}
			if (! empty ( $coupon_info ['cash_token'] )) {
				if (count($coupon_info ['cash_token'])>$cards['count']['num']) {
					return array (
							's' => 0,
							'errmsg' => '选择的优惠券太多啦' 
					);
				}
				$tmp=array('inter_id'=>$inter_id,'status'=>0,'rel_type'=>1);
				foreach ($coupon_info['cash_token'] as &$ct){
					$tmp['amount']=$ct['amount'];
					$tmp['code']=$ct['code'];
					$tmp['title']=$ct['title'];
					$tmp['extra']=json_encode($ct['extra'],JSON_UNESCAPED_UNICODE);
					$tmp['rule_id']=$ct['rule_id'];
					$tmp['card_id']=$ct['cid'];
					$tmp['wxcard_id']=$ct['wxcard_id'];
					$tmp['create_time']=date('Y-m-d H:i:s');
					$coupon_rel[$ct['code']]=$tmp;
					unset($ct['cid']);
					unset($ct['rule_id']);
				}
				return array (
						's' => 1,
						'coupon_amount' => $coupon_amount,
						'coupon_info' => $coupon_info,
						'coupon_rel' => $coupon_rel
				);
			}
			return array (
					's' => 0,
					'errmsg' => '您没有优惠券' 
			);
		}
		if (!empty($coupon_info)){
			return array (
					's' => 1,
					'coupon_amount' => $coupon_amount,
					'coupon_info' => $coupon_info,
					'coupon_rel' => $coupon_rel
			);
		}else{
			return array (
					's' => 0,
					'errmsg' => '您没有优惠券'
			);
		}
	}
	function change_order_coupon($orderid, $inter_id, $openid, $coupon_des, $type = 'hang_on',$vid=NULL,$order=array()) {
		if (!isset($vid)){
			$this->load->model('hotel/Member_model');
			$vid=$this->Member_model->get_vid($inter_id);
		}
		if (!empty($vid)&&$vid==1){
			return $this->change_order_coupon_v($orderid, $inter_id, $openid, $coupon_des, $type,$order);
		}else{
			return $this->change_order_coupon_m($orderid, $inter_id, $openid, $coupon_des, $type,$order);
		}
	}
	function change_order_coupon_v($orderid, $inter_id, $openid, $coupon_des, $type = 'hang_on',$order=array()) {
		$funtion='';
		$remark='';
		switch ($type) {
			case 'hang_on' :
				$funtion='userCoupon';
				$status=0;
				$new_status=1;
				$remark='单号：'.$orderid.'，挂起券';
				break;
			case 'use' :
				$funtion='userOffCoupon';
				$status=1;
				$new_status=2;
				$remark='单号：'.$orderid.'，核销券';
				break;
			case 'back' :
				$funtion='returnCoupon';
				$status=array(0,1);
				$new_status=8;
				$remark='单号：'.$orderid.'，返还券';
				break;
			default :
				return false;
				break;
		}
		$coupons=$this->get_order_use_coupons($inter_id, $orderid, $status);
// 		$coupon_info = json_decode ( $coupon_des, TRUE );
		$wxcards = array ();
		if (! empty ( $coupons )) {
			$this->load->model('hotel/Coupon_new_model');
			$params=array();
			if(!empty($order)){
				$room_codes = json_decode($order ['room_codes'], TRUE);
				$room_codes = $room_codes [$order ['first_detail'] ['room_id']];
				if (!empty($room_codes['room']['webser_id'])){
					
					$params['startdate']=$order['startdate'];
					$params['enddate']=$order['enddate'];
					$params['roomnums']=$order['roomnums'];
					$params['web_orderid']=$order['web_orderid'];
					$params['price_code']=empty($room_codes ['code'] ['extra_info'] ['pms_code'])?$order ['first_detail']['price_code']:$room_codes ['code'] ['extra_info'] ['pms_code'];
					$params['webser_id']=$room_codes['room']['webser_id'];
					if (!empty($room_codes['code']['extra_info']['coupon_para'])){
						if (in_array('hotel_id', $room_codes['code']['extra_info']['coupon_para'])){
							$this->load->model('common/Pms_model');
							$pms_set=$this->Pms_model->get_hotel_pms_set($inter_id,$order['hotel_id']);
							$params['hotel_web_id']=$pms_set['hotel_web_id'];
						}
					}
				}
			}
			
			foreach ( $coupons as $ci ) {
				if (empty($ci ['wxcard_id'])) {
					if($this->Coupon_new_model->change_coupon_status($openid,$inter_id,$ci['code'],$funtion,'hotel_order',$remark,'',$params)){
						$this->db->where(array('rel_id'=>$ci['rel_id']));
						$this->db->update('hotel_order_coupons',array('status'=>$new_status,'update_time'=>date('Y-m-d H:i:s')));
					}else{
						$this->db->where(array('rel_id'=>$ci['rel_id']));
						$this->db->update('hotel_order_coupons',array('status'=>3,'update_time'=>date('Y-m-d H:i:s')));
					}
				} else {
					$wxcards [$ci ['code']] = $ci ['wxcard_id'];
				}
			}
		}
		return array (
				'wxcards' => $wxcards 
		);
	}
	function change_order_coupon_m($orderid, $inter_id, $openid, $coupon_des, $type = 'hang_on',$order) {
		$status = - 1;
		switch ($type) {
			case 'hang_on' :
				$status = self::STATUS_FREEZE;
				break;
			case 'give' :
				$status = self::STATUS_HAVE_RECEIVE;
				break;
			case 'create' :
				$status = self::STATUS_GRANT;
				break;
			case 'use' :
				$status = self::STATUS_CANCEL_VERIFICATION;
				break;
			default :
				break;
		}
		$coupon_info = json_decode ( $coupon_des, TRUE );
		$wxcards = array ();
		if (! empty ( $coupon_info )) {
			$this->load->model ( 'member/Igetcard' );
			foreach ( $coupon_info as $ci ) {
				foreach ( $ci as $c ) {
					if ($c ['is_wxcard'] == 0) {
//                         $this->load->model('hotel/Member_model');
// 						$this->vid=$this->Member_model->get_vid($inter_id);
//                         if($this->vid==1){     //锦江优惠券暂时写死
//                             $wxcards [$c ['code']] = $c ['wxcard_id'];
//                         }else{
                            if (! $this->Igetcard->updateGcardStatus ( $openid, $c ['code'], $status,null,null,null,null,$inter_id ))
                            return false;
//                         }
					} else {
						$wxcards [$c ['code']] = $c ['wxcard_id'];
					}
				}
			}
		}
		return array (
				'wxcards' => $wxcards 
		);
	}
	
	function get_order_use_coupons($inter_id,$orderid,$status=NULL){
		if (!is_null($status)){
			is_array($status)?$this->db->where_in('status',$status):$this->db->where('status',$status);
		}
		$this->db->where(array('inter_id'=>$inter_id,'orderid'=>$orderid,'rel_type'=>1));
		$result=$this->db->get('hotel_order_coupons')->result_array();
		return $result;
	}
	
	function create_market_reward($inter_id, $order, $scene, $params) {

        $coupon_info = array ();

        $this->load->model('hotel/Member_model');
		$vid=$this->Member_model->get_vid($inter_id);

        if($vid==1){     //新的发券规则

            $this->load->model('hotel/Coupon_new_model');
            $couponsList=$this->Coupon_new_model->allCouponsList($inter_id);   //记录对应的优惠券对应的名称

            if(!empty($couponsList['data'])){
                $couponTitle = array();
                foreach($couponsList['data'] as $c_list){
                    $couponTitle[$c_list['card_id']] = $c_list['title'];
                }
            }


            if(!empty($order['first_detail']['price_code'] )){
                $params['price_code']=$order['first_detail']['price_code'];
            }

            if(!empty($order['paytype'])){
                $params['paytype']=$order['paytype'];
            }

            if(!empty($order['first_detail']['room_id'] )){
                $params['room_id']=$order['first_detail']['room_id'];
            }

            if(!empty($order['first_detail']['startdate'] )){
                $params['startdate']=$order['first_detail']['startdate'];
            }

            if(!empty($order['first_detail']['enddate'] )){
                $params['enddate']=$order['first_detail']['enddate'];
            }

            $rules = $this->get_coupon_rules ( $inter_id, $scene, $params ,$order['openid']);

            if (! empty ( $rules ) && !empty($couponsList['data'])) {
                $extra_data = array (
                    'module' => 'hotel',
                    'scene' => $scene,
                    'scene_id' => $order ['orderid']
                );
                $room_nights = $params ['rooms'] * $params ['days'];
                foreach ( $rules as $k => $r ) {

                    if (! empty ( $r ['reward'] )) {
                        $coupon_info [$r['reward']->rule_type] [$k] = array (
                            'rule_name' => $r ['rule_name'],
                            'coupon_ids'=>$r ['reward']->coupon_ids
                        );

                        if (isset($r['reward']->send_condition) AND $r['reward']->send_condition!='') {
                            $send_condition=json_decode($r['reward']->send_condition);
                        }

                        if (isset( $send_condition->num->order) AND  $send_condition->num->order!='') {
                            $coupon_info [$r['reward']->rule_type] [$k] ['card_nums'] = $send_condition->num->order;
                            $coupon_info [$r['reward']->rule_type] [$k] ['give_num'] = $send_condition->num->order;
                        } else if (isset( $send_condition->num->night) AND  $send_condition->num->night!='') {
                            $coupon_info [$r['reward']->rule_type] [$k]  ['card_nums'] = $send_condition->num->night * $room_nights;
                            $coupon_info [$r['reward']->rule_type] [$k] ['give_num'] = $send_condition->num->night;
                            if(isset($params['extra_nums'])){
                                $coupon_info [$r['reward']->rule_type] [$k]  ['card_nums']=$send_condition->num->night * $params['extra_nums'];
                            }
                        }

                        $temp_coupon_ids = explode(',',$r ['reward']->coupon_ids);
                        $str_couponTitle = '';
                        foreach($temp_coupon_ids as $temp_arr_coupon){
                            $temp_title=isset($couponTitle[$temp_arr_coupon])?$couponTitle[$temp_arr_coupon]:'';
                            if(empty($str_couponTitle)){
                                $str_couponTitle = $temp_title;
                            }else{
                                $str_couponTitle += ','.$temp_title;
                            }
                        }

                        $coupon_info['title'][] = $coupon_info [$r['reward']->rule_type] [$k] ['give_num'].'张'.$str_couponTitle;

                        $coupon_info [$r['reward']->rule_type] [$k]  ['give_rule'] = $r['reward']->extra_rule;
                        $coupon_info [$r['reward']->rule_type] [$k]  ['uu_code'] = $order ['orderid'].rand(0,9999);


                        $coupon_info ['status'][$r['reward']->rule_type] = 0;   //优惠券发放状态

                        $give_num=$coupon_info [$r['reward']->rule_type] [$k]  ['card_nums'];

                        $this->load->model("hotel/Coupons_rules_model");

                        //生产待送券记录
                        $this->Coupons_rules_model->add_user_coupon ( $inter_id,$order ['orderid'],$r ['reward']->coupon_ids, 'create', $r['reward']->rule_type,$k,$r ['rule_name'],$order['openid'],$give_num);

                    }

                }
            }
            $s = 0;

        }else{      //旧发券规则

            $rules = $this->get_market_give_rule ( $inter_id, $scene, $params );

            if (! empty ( $rules )) {
                $extra_data = array (
                    'module' => 'hotel',
                    'scene' => $scene,
                    'scene_id' => $order ['orderid']
                );
                $room_nights = $params ['rooms'] * $params ['days'];
                foreach ( $rules as $k => $r ) {
                    if (! empty ( $r ['reward'] ['card'] )) {
                        $coupon_info ['check_out'] [$k] = array (
                            'rule_name' => $r ['rule_name']
                        );
                        foreach ( $r ['reward'] ['card'] as $rck => $rc ) {
                            $coupon_info ['check_out'] [$k] ['cards'] [$rck] ['card_id'] = $rc ['ci_id'];
                            if ($rc ['restriction'] == 'order') {
                                $coupon_info ['check_out'] [$k] ['cards'] [$rck] ['card_nums'] = $rc ['quantity'];
                                $coupon_info ['check_out'] [$k] ['cards'] [$rck] ['give_num'] = $rc ['quantity'];
                            } else if ($rc ['restriction'] == 'room_nights') {
                                $coupon_info ['check_out'] [$k] ['cards'] [$rck] ['card_nums'] = $rc ['quantity'] * $room_nights;
                                $coupon_info ['check_out'] [$k] ['cards'] [$rck] ['give_num'] = $rc ['quantity'];
                            }
                            $coupon_info ['check_out'] [$k] ['cards'] [$rck] ['give_rule'] = $rc ['restriction'];
                            // $this->add_user_card ( $inter_id, $order ['openid'], $rc ['ci_id'], $coupon_info ['check_out'] [$k] ['cards'] [$rck] ['card_nums'], 'create', $extra_data );
                        }
                    }
                }
            }
            $s = 0;

        }

		if (! empty ( $coupon_info )) {
			$s = 1;
		}
		return array (
				's' => $s,
				'coupons' => $coupon_info
		);
	}
	function give_market_reward($inter_id, $order, $give_info, $scene,$give_condition='') {

        $this->load->model('hotel/Member_model');
		$vid=$this->Member_model->get_vid($inter_id);

        if($vid==1){

            $extra_data = array (
                'module' => 'hotel',
                'scene' => $scene,
                'scene_id' => $order ['orderid']
            );

            $give_info=json_decode($order['coupon_give_info']);
            $this->load->model("hotel/Coupons_rules_model","Coupons_rules_model");

            $result=$this->Coupons_rules_model->giveCouponTo($order,$give_info,$give_condition);

            if($result){

                return true;

            }else{

                return false;

            }


        }else{

            $extra_data = array (
                'module' => 'hotel',
                'scene' => $scene,
                'scene_id' => $order ['orderid']
            );
            foreach ( $give_info as $k => $r ) {
                if (! empty ( $r ['cards'] )) {
                    $extra_data ['rule_id'] = $k;
                    foreach ( $r ['cards'] as $rck => $rc ) {
                        if (! $this->add_user_card ( $inter_id, $order ['openid'], $rc ['card_id'], $rc ['card_nums'], 'give', $extra_data )) {
                            return false;
                        }
                    }
                }
            }

        }
		return true;
	}
	function _give_market_reward($inter_id, $order, $scene) {
		$idents ['inter_id'] = $inter_id;
		$idents ['scene'] = $scene;
		$idents ['openid'] = $order ['openid'];
		$idents ['module'] = 'hotel';
		$idents ['scene_id'] = $order ['orderid'];
		$codes = $this->get_coupon_code_given ( $idents );
		$this->load->model ( 'member/Igetcard' );
		foreach ( $codes as $c ) {
			if (! $this->Igetcard->updateGcardStatus ( $order ['openid'], $c ['code'], 1 ))
				return false;
		}
		return true;
	}
	function cancel_market_reward($inter_id, $order, $scene) {
		$idents ['inter_id'] = $inter_id;
		$idents ['scene'] = $scene;
		$idents ['openid'] = $order ['openid'];
		$idents ['module'] = 'hotel';
		$idents ['scene_id'] = $order ['orderid'];
		$codes = $this->get_coupon_code_given ( $idents );
		$this->load->model ( 'member/Igetcard' );
		foreach ( $codes as $c ) {
			if (! $this->Igetcard->updateGcardStatus ( $order ['openid'], $c ['code'], 1 ))
				return false;
		}
		return true;
	}
	function get_coupon_code_given($idents) {
		$this->db->where ( $idents );
		return $this->db->get ( self::TAB_MGCL )->result_array ();
	}
	function get_market_give_rule($inter_id, $scene, $params) {
		$this->load->model ( 'member/Irule' );
		switch ($scene) {
			case 'order_complete' :
				$params ['hotel_checkout'] = 1;
				$params ['consume_completed'] = 1;
				break;
			default :
				break;
		}
		$data = $this->Irule->getRewardByRules ( 'room', null, $inter_id, $params );
		return $data;
	}
	function add_user_card($inter_id, $openid, $card_id, $nums = 1, $add_type = 'create', $extra_data = array()) {
		switch ($add_type) {
			case 'create' :
				$status = 6;
				break;
			case 'give' :
				$status = 1;
				break;
			default :
				break;
		}
		$this->load->model ( 'member/Igetcard' );
		$this->load->library ( 'PMS_Adapter', array (
				'inter_id' => $inter_id,
				'hotel_id' => 0 
		), 'pub_pmsa' );
		$member = $this->pub_pmsa->check_openid_member ( $inter_id, $openid );
		// $extra_data['rule_id'] = $card_id;//card_id作rule_id传，错误
		// if ($member) {
		if ($this->Igetcard->userGetCard ( $openid, $inter_id, array (
				$card_id => $nums 
		), $status, $extra_data )) {
			return true;
		}
		// }
		return false;
	}
	function wx_card_consume($inter_id, $wxcards) {
		$this->load->helper ( 'common' );
		$this->load->model ( 'wx/Access_token_model' );
		foreach ( $wxcards as $code => $card_id ) {
			$access_token = $this->Access_token_model->get_access_token ( $inter_id );
			$url = "https://api.weixin.qq.com/card/code/consume?access_token=" . $access_token;
			$result = doCurlPostRequest ( $url, json_encode ( array (
					'code' => $code,
					'card_id' => $card_id 
			) ) );
			$this->db->insert ( 'weixin_text', array (
					'content' => $result 
			) );
		}
	}

    function get_vid($inter_id){

        $this->load->model ( 'hotel/Hotel_config_model' );
        $config_data = $this->Hotel_config_model->get_hotel_config ( $inter_id, 'HOTEL', 0, 'NEW_VIP');
        if (isset($config_data['NEW_VIP']))
            return $config_data['NEW_VIP'];
        return 0;
    }


    function get_coupon_rules($inter_id, $scene, $params,$openid) {
        $this->load->model ( 'hotel/Coupons_rules_model','Coupons_rules_model' );
        switch ($scene) {
            case 'order_complete' :
                $params ['hotel_checkout'] = 1;
                $params ['consume_completed'] = 1;
                break;
            default :
                break;
        }
        $data = $this->Coupons_rules_model->getCouponsByRules ( 'room', null, $inter_id, $params,$openid);
        return $data;
    }


    function select_coupon($params,$mycards=array()) {

        $params ['days']  = get_room_night($params['startdate'],$params['enddate'],'round');//至少有1个间夜
        $params['all_cards'] = $mycards;
        $cards = $this->get_usable_coupon ( $this->inter_id, $this->openid, $params, TRUE );

        if(empty($mycards) && !empty($cards['all_cards'])){
            $mycards = $cards['all_cards'];
        }

        $cards['selected'] = [];
        if(!empty($cards['cards'])){ //有优惠券
            $cards_list = json_decode(json_encode($cards['cards']),true);
            uasort($cards_list, function ($a, $b){
                if($a['coupon_type']=='discount' && $b['coupon_type']=='discount'){
                    return $a['reduce_cost'] - $b['reduce_cost'] < 0 ? -1 : 1;
                }elseif($a['coupon_type']=='voucher' && $b['coupon_type']=='voucher'){
                    return $a['reduce_cost'] - $b['reduce_cost'] > 0 ? -1 : 1;
                }elseif($a['coupon_type'] != $b['coupon_type']){
                    return $a['coupon_type']=='discount'? -1 : 1;
                }
//                return $a['reduce_cost'] - $b['reduce_cost'] > 0 ? -1 : 1;
            });
            $select_amount = 0;
            $i = 0;
            foreach($cards_list as $v){
                //循环卡券
                if(($params['amount'] > $select_amount + $v['reduce_cost'])){
                    //当前已默认选择卡券
                    $cards['selected'][] = $v;
                    $select_amount += $v['reduce_cost'];
                    $i++;
                }
                if($v['coupon_type']=='discount')break;
                if($i >= $cards['count']['num']){
                    break;
                }
            }
            $cards['select_coupon_favour']=$select_amount;
        }

        return array(
            'cards'=>$cards,
            'mycards'=>$mycards,
        );
    }

}