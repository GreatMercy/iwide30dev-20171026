<?php if(!defined('BASEPATH')){
	exit('No direct script access allowed');
}
define('HOTEL_WSDL', 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc?singlewsdl');
define('HOTEL_LOCATION', 'http://njqm.beyondh.com:7998/Service/Order/HotelService.svc/Basic');
define('ORDER_WSDL', 'http://njqm.beyondh.com:7998/Service/Order/OrderService.svc?singlewsdl');
define('ORDER_LOCATION', 'http://njqm.beyondh.com:7998/Service/Order/OrderService.svc/Basic');
define('CRM_WSDL', 'http://njqm.beyondh.com:7998/Service/Crm/CrmService.svc?singlewsdl');
define('CRM_LOCATION', 'http://njqm.beyondh.com:7998/Service/Crm/CrmService.svc/Basic');
define('BILL_WSDL', 'http://njqm.beyondh.com:7998/Service/Bill/BillService.svc?singlewsdl');
define('BILL_LOCATION', 'http://njqm.beyondh.com:7998/Service/Bill/BillService.svc/Basic');

/*define('HOTEL_WSDL', 'http://njqm.bak.beyondh.com:7998/Service/Order/HotelService.svc?wsdl');
define('HOTEL_LOCATION', 'http://njqm.bak.beyondh.com:7998/Service/Order/HotelService.svc/Basic');
define('ORDER_WSDL', 'http://njqm.bak.beyondh.com:7998/Service/Order/OrderService.svc?wsdl');
define('ORDER_LOCATION', 'http://njqm.bak.beyondh.com:7998/Service/Order/OrderService.svc/Basic');
define('CRM_WSDL', 'http://njqm.bak.beyondh.com:7998/Service/Crm/CrmService.svc?wsdl');
define('CRM_LOCATION', 'http://njqm.bak.beyondh.com:7998/Service/Crm/CrmService.svc/Basic');
define('BILL_WSDL', 'http://njqm.bak.beyondh.com:7998/Service/Bill/BillService.svc?wsdl');
define('BILL_LOCATION', 'http://njqm.bak.beyondh.com:7998/Service/Bill/BillService.svc/Basic');*/
//define('KEY', 'wechat');
//define('SIGNKEY', 'wechat');
define('KEY', 'JFK');
define('SIGNKEY', 'JFK');

/*define('HOTEL_WSDL', 'https://pms.beyondh.com:7997/Service/Order/HotelService.svc?wsdl');
define('HOTEL_LOCATION', 'https://pms.beyondh.com:7997/Service/Order/HotelService.svc/Basic');
define('ORDER_WSDL', 'https://pms.beyondh.com:7997/Service/Order/OrderService.svc?wsdl');
define('ORDER_LOCATION', 'https://pms.beyondh.com:7997/Service/Order/OrderService.svc/Basic');
define('CRM_WSDL', 'https://pms.beyondh.com:7997/Service/Crm/CrmService.svc?wsdl');
define('CRM_LOCATION', 'https://pms.beyondh.com:7997/Service/Crm/CrmService.svc/Basic');
define('BILL_WSDL', 'https://pms.beyondh.com:7997/Service/Bill/BillService.svc?wsdl');
define('BILL_LOCATION', 'https://pms.beyondh.com:7997/Service/Bill/BillService.svc/Basic');
define('KEY', 'web');
define('SIGNKEY', 'pass');*/

#region
class HotelSearchResponse{
	public $OwnerId = 0;
	public $HotelId = 0;
	public $HotelNo = '';
	public $Name = '';
	public $Brand = '';
	public $Address = '';
	public $Phone = '';
	public $Fax = '';
	public $Description = '';
	public $CityId = '';
	public $HotelInfoType = '';
	public $Star = null;
	public $Latitude = null;
	public $Longitude = null;
	public $ServiceTags = array();
	public $DetailPrice = array();
	public $RoomCounts = array();
	public $CanNetOpen = null;
	public $ImageUris = '';
	public $DecorationDate = null;
	public $OpeningDate = null;
	public $WeChatLocationId = '';
}

class HotelSearchRequest{
	public $CityId = '';
	public $DistrictId = '';
	public $HotelIds = array();
	public $HotelName = '';
	public $BeginDate = '';
	public $EndDate = '';
	public $Star = null;
	public $Longitude = null;
	public $Latitude = null;
	public $Distance = null;
	public $OrgSns = array();
	public $RoomTypeIds = array();
	public $MemberLevels = array();
	public $ServiceTags = array();
	public $PhysicalRoomTypeOnly = null;
	public $BasicInfoOnly = null;
	public $IncludeDetailCounts = true;
	public $ExcludePrices = null;
	public $ExcludeRoomCounts = null;
	public $OnlyOpenedHotel = null;
	public $PageIndex = 1;
	public $PageSize = 10;
}

class OrderAddRequest{
	public $ContractId = 0;
	public $EstimatedArriveTime = '';
	public $EstimatedDepartureTime = '';
	public $ExpireKeepTime = null;
	public $ExternalPriceName = null;
	public $Guests = null;
	public $HotelId = 0;
	public $IsExtenalPrice = null;
	public $Liaisons = array();
	public $CheckinType = 'Normal';
	public $PublicMemo = null;
	public $PrePaymentTypeId = null;
	public $PromotionId = 0;
	public $Locked = false;
	public $MemberId = null;
	public $SalerId = null;
	public $RoomPlans = null;
	public $OrderItemRequests = null;
}

class Guest{
	public $Name = '';
	public $Gender = '0';
	public $Phone = '';
	public $Mobile = '';
	public $Fax = '';
	public $Email = '';
	public $Nationality = '';
	public $TransactoinId = 0;
}

class Liaison{
	public $Name = '';
	public $Gender = '0';
	public $Phone = '';
	public $Mobile = '';
	public $Fax = '';
	public $Email = '';
	public $TransactoinId = 0;
}

class RoomPlan{
	public $RoomTypeId = '';
	public $Amount = 0;
	public $RoomType = null;
	public $TransactoinId = 0;
	public $Price = array();
}

class RoomPrice{
	public $Date = '';
	public $OrignPrice = 0;
	public $RoomCount = 0;
	public $ActualPrice = 0;
	public $RoomTypeId = 0;
	public $TransactoinId = 0;
	public $RoomType = null;
	public $Description = '';
}

class OrderItemRequest{
	public $ItemId = 0;
	public $ItemPrice = 0;
	public $ItemCount = 1;
	public $CustomerOwned = false;
	public $PersistentOnRefresh = false;
}

class RoomType{
	public $Id = '';
	public $OwnerId = 0;
	public $RoomTypeName = '';
	public $Description = '';
	public $BedType = '';
	public $HotelRoomTypeDescription = '';
	public $BedAmount = 0;
	public $Virtual = false;
	public $PhysicalRoomTypeId = '';
	public $Abbreviation = '';
	public $IsActive = false;
	public $ImageUris = '';
}

class MemberAddRequest{
	public $Address = '';
	public $BirthDay = null;
	public $CreateBy = '';
	public $CreateTime = '';//nn
	public $CreditScore = 0;
	public $Email = '';
	public $ExtCardNo = '';
	public $Fax = '';
	public $Gender = '';
	public $IDNo = '';
	public $IDType = 'C01';
	public $IsPermanentLevel = false;
	public $Level = 'P';
	public $Mobile = '';
	public $Name = '';
	public $NationCode = '';
	public $OpenId = '';
	public $ParentCardNo = '';
	public $Password = '';
	public $Phone = '';
	public $Remark = '';
	public $SourceChannel = 'J';
	public $SourceDetailCode = '';
	public $SourceType = '2';
	public $StatusCode = 'I';
	public $TransactoinId = 0;
	public $ZipCode = '';
}

class SearchAvailiableRooms{
	public $EstimatedArriveTime = '';
	public $EstimatedDepartureTime = '';
	public $FloorIds = '';
	public $HallIds = '';
	public $HotelId = 0;
	public $RoomAttributeIds = '';
	public $RoomTypeIds = array();
}

class OccupationSearchRequest{
	public $HotelId = 0;
	public $OrderId = 0;
}

class CheckinRequest{
	public $Customer = null;
	public $HotelId = 0;
	public $OrderId = 0;
	public $OccupationId = 0;
}

class CustomerRequest{
	public $CardNo = '';
	public $CardTypeId = '';
	public $Mobile = '';
	public $Name = '';
}

class OrderCancelRequest{
	public $HotelId = 0;
	public $OrderId = 0;
	public $Reason = '';
}

Class CheckinSearchRequest{
	public $CheckinIds = null;
	public $CheckinStatus = array('I', 'O', 'S');
	public $HotelId = 0;
	public $MemberCardId = '';
	public $MemberId = '';
	public $OccupationIds = null;
	public $OrderIds = null;
	public $PageIndex = 1;
	public $PageSize = 10;
	public $RoomNumbers = null;
}

Class CheckinNetDoorOpenRequest{
	public $CheckinId = 0;
	public $HotelId = 0;
}

Class BillItemAddRequest{
	public $BillId = 0;
	public $BillItemType = '';
	public $SubItemType = '';
	public $IsDeposit = false;
	public $Amount = 0;
	public $Memo = '';
	public $HotelId = '';
	public $ExternalRefId = 0;
	public $PaymentRequest = null;
}

Class PaymentRequest{
	public $ArAccountId = 0;
	public $ArAccountName = '';
	public $BankKey = '';
	public $CardNumber = '';
	public $AuthorizeId = '';
	public $BeginValidTime = null;
	public $EndValidTime = null;
	public $OnlinePaymentId = 0;
	public $Memo = '';
	public $Amount = 0;
	public $MemberId = '';
	public $FeeType = '';
}

Class PartialPayOrderBillRequest{
	public $BillId = 0;
	public $HotelId = 0;
}

Class BillDetailRequest{
	public $BillId = 0;
	public $HotelId = 0;
}

//时租房价格
class HourRentPriceRequest{
	public $HotelId = 0;        //酒店编号
	public $EstimatedArriveTime = '';            //预计到店时间
	public $EstimatedDepartureTime = '';        //预计离店时间
	public $TransactionId = 0;        //事务号
	public $MemberLevels=[];
}

class OnlinePaymentRequest{
	public $HotelId = 0;
	public $BillId = 0;
	public $RoomDetail = '';
	public $PayType = '';
	public $Amount = 0;
}

class PaymentUpdateReqeust{
	public $HotelId = 0;
	public $Id = 0;
	public $OpenId = '';
	public $BankType = '';
	public $BankBillNo = '';
	public $TransctionId = '';
	public $NotifyId = '';
	public $PayAmount = 0;
	public $PayTime = null;
	public $IsSuccess = true;
	public $BillItemId = 0;
}

#endregion
class Beyondh_hotel_model extends MY_Model{
	private $inter_id;
	function __construct(){
		parent::__construct();
		$this->load->helper('common');
		$this->inter_id=$this->session->userdata('inter_id');
		
		$this->load->library('Cache/Redis_proxy',array(
			'not_init'=>FALSE,
			'module'=>'common',
			'refresh'=>FALSE,
			'environment'=>ENVIRONMENT
		),'redis_proxy');
	}
	
	public function get_rooms_change($rooms, $idents, $condit, $pms_set = array()){
		$this->inter_id=$pms_set['inter_id'];
		statistic('a');
		$this->load->model('common/Webservice_model');
		$web_reflect = $this->Webservice_model->get_web_reflect($idents ['inter_id'], $idents ['hotel_id'], $pms_set ['pms_type'], array(
			'web_member_list',
			'member_price_code',
			'web_price_code_set',
			'virtual_price_set',
			'web_checkin',
		), 1, 'w2l');
		
		if($pms_set['inter_id'] == 'a467894987' || $pms_set['inter_id'] == 'a464919542'){
			$this->load->model('api/Vmember_model','vm');
			$member_level=$this->vm->getLvlPmsCode($condit['openid'],$idents['inter_id']);
		} else{
			$member_level = isset ($web_reflect ['member_level'] [$condit ['member_level']]) ? $web_reflect ['member_level'] [$condit ['member_level']] : '';
		}
		
		$web_price_code = '';
		
		if(!empty ($condit ['price_codes'])){
			$web_price_code = $condit ['price_codes'];
			
			//对接模式是本地价格代码时，读取对应的external_code值【PMS价格代码】
			if($pms_set['pms_room_state_way'] == 3 || $pms_set['pms_room_state_way'] == 4){
				$web_code_arr = [];
				$price_code_list = $this->readDB()->from('hotel_price_info')->select('external_code')->where(['inter_id' => $pms_set['inter_id']])->where_in('price_code', explode(',', $condit['price_codes']))->get()->result_array();
				foreach($price_code_list as $v){
					$web_code_arr[] = $v['external_code'];
				}
				if($web_code_arr){
					$web_price_code = implode(',', $web_code_arr);
				}
			}
		} else{
			if(!empty ($web_reflect ['web_price_code'])){
				foreach($web_reflect ['web_price_code'] as $wpc){
					$web_price_code .= ',' . $wpc;
				}
			}
			$web_price_code .= isset ($web_reflect ['member_price_code'] [$member_level]) ? ',' . $web_reflect ['member_price_code'] [$member_level] : '';
			$web_price_code = substr($web_price_code, 1);
		}
		//需要判断优惠价是否不同于门市价
		$virtual_price_set = '';
		if(!empty($web_reflect['virtual_price_set'])){
			foreach($web_reflect['virtual_price_set'] as $v){
				$virtual_price_set .= ',' . $v;
			}
			$virtual_price_set = substr($virtual_price_set, 1);
		}
		$virtual_price_set = explode(',', $virtual_price_set);
		
		$web_price_code = explode(',', $web_price_code);
		$countday = get_room_night($condit ['startdate'],$condit ['enddate'],'ceil',$condit);//至少有一个间夜
		$web_rids = array();
		foreach($rooms as $r){
			$web_rids [$r ['webser_id']] = $r ['room_id'];
		}
		
		$level_price_code = isset ($web_reflect ['member_price_code'] [$member_level]) ? $web_reflect ['member_price_code'] [$member_level] : ($member_level ? $member_level : '非会员');
		
		if(empty($condit['only_type'])&&!empty($condit['price_type'])&&is_array($condit['price_type'])){
			$pt_arr=$condit['price_type'];
			if(count($pt_arr)==1){
				$condit['only_type']=end($pt_arr);
			}
		}
		
		$params = array(
			'countday'          => $countday,
			'web_rids'          => $web_rids,
			'condit'            => $condit,
			'web_reflect'       => $web_reflect,
			'member_level'      => $member_level,
			//			'member_type'  => $member_level,
			'idents'            => $idents,
			'virtual_price_set' => $virtual_price_set,
			'level_price_code'=>$level_price_code,
		);

//		if(!empty ($web_price_code)){
		statistic('b');
		$pms_data = $this->get_web_roomtype($pms_set, $web_price_code, $condit ['startdate'], $condit ['enddate'], $params);
//		}
		statistic('c');
		$result = array();
		if(!empty ($pms_data)){
			switch($pms_set ['pms_room_state_way']){
				case 1 :
				case 2 :
					$result = $this->get_rooms_change_allpms($pms_data, array(
						'rooms' => $rooms
					), $params);
					break;
				case 3 :
					$result = $this->get_rooms_change_lmem($pms_data, array(
						'rooms' => $rooms
					), $params);
					break;
				case 4:
					$result = $this->get_rooms_change_ratecode($pms_data, array(
						'rooms' => $rooms
					), $params);
					break;
			}
		}
		statistic('d');
		$a_b = statistic('a', 'b');//查询本地配置
		$b_c = statistic('b', 'c');//请求PMS实时房态
		$c_d = statistic('c', 'd');//与本地房型匹配
		$a_d = statistic('a', 'd');//获取房型
		$timer_arr = array(
			'查询本地配置'    => $a_b . '秒',
			'请求PMS实时房态' => $b_c . '秒',
			'与本地房型匹配'   => $c_d . '秒',
			'获取房型房态总耗时' => $a_d . '秒',
			'执行时间'      => date('Y-m-d H:i:s'),
		);
		pms_logger(func_get_args(), $timer_arr, __METHOD__ . '->query_time', $pms_set['inter_id']);

//		$this->Webservice_model->log_service_record('获取房型房态', json_encode($timer_arr), $pms_set['inter_id'], 'beyondh', 'get_rooms_change', 'query_time');
		return $result;
	}
	
	public function get_rooms_change_ratecode($pms_data, $rooms, $params){
		$local_rooms = $rooms ['rooms'];
		$condit = $params ['condit'];
		$this->load->model('hotel/Order_model');
		$data = $this->Order_model->get_rooms_change($local_rooms, $params ['idents'], $params ['condit']);
		$pms_state = $pms_data ['pms_state'];
		$valid_state = $pms_data ['valid_state'];
		
		$merge = [
			'least_num',
			'book_status',
			'extra_info',
			'date_detail',
			//			'avg_price',
			//			'allprice',
			//			'total',
			//			'total_price',
		];
		
		foreach($data as $room_key => $lrm){
			$min_price = [];
			if(empty ($valid_state [$lrm ['room_info'] ['webser_id']])){
				unset ($data [$room_key]);
				continue;
			}
			
			$nums = isset ($condit ['nums'] [$lrm ['room_info'] ['room_id']]) ? $condit ['nums'] [$lrm ['room_info'] ['room_id']] : 1;
			
			if(!empty($lrm['state_info'])){
				
				foreach($lrm['state_info'] as $sik => $si){
					
					//需要设置PMS价格代码值
					$web_rate = $si['external_code'];
					
					if($web_rate === '' || empty($pms_state[$lrm['room_info']['webser_id']][$web_rate])){//PMS上不存在该价格代码
						unset($data[$room_key]['state_info'][$sik]);
						continue;
					}
					
					//PMS上的房态数据
					$tmp = $pms_state[$lrm['room_info']['webser_id']][$web_rate];
					foreach($merge as $w){
						if(isset($tmp[$w])){
							
							if($w == 'date_detail'){
								$allprice = '';
								$amount = 0;
								foreach($tmp [$w] as $dk => $td){
									if($si['price_type'] == 'protrol' && $si['related_cal_way'] && $si['related_cal_value']){
										$tmp [$w] [$dk] ['price'] = round($this->Order_model->cal_related_price($td ['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
									} else{
										$tmp [$w] [$dk] ['price'] = $td ['price'];
									}
									$tmp [$w] [$dk] ['nums'] = $tmp['least_num'];
									$allprice .= ',' . $tmp [$w] [$dk] ['price'];
									$amount += $tmp [$w] [$dk] ['price'];
								}
								
								$data [$room_key] ['state_info'] [$sik] ['avg_price'] = number_format($amount / $params ['countday'], 1);
								$data [$room_key] ['state_info'] [$sik] ['allprice'] = substr($allprice, 1);
								$data [$room_key] ['state_info'] [$sik] ['total'] = intval($amount);
								$data [$room_key] ['state_info'] [$sik] ['total_price'] = $data [$room_key] ['state_info'] [$sik] ['total'] * $nums;
							}
							$data[$room_key]['state_info'][$sik][$w] = $tmp[$w];
						}
					}
					
					$min_price[] = str_replace(',','',$data[$room_key]['state_info'][$sik]['avg_price']);
//					}
				}
			}
			$data[$room_key]['lowest'] = empty($min_price) ? 0 : min($min_price);
			$data[$room_key]['highest'] = empty($min_price) ? 0 : max($min_price);
			/*if(empty($lrm['show_info'])){
				$lrm['show_info'] = $lrm['state_info'];
				$data[$room_key]['show_info'] = $lrm['state_info'];
			}*/
			if(!empty($lrm['show_info'])){
				foreach($lrm['show_info'] as $sik => $si){
					//需要设置PMS价格代码值
					$web_rate = $si['external_code'];
					if($web_rate === '' || empty($pms_state[$lrm['room_info']['webser_id']][$web_rate])){//PMS上不存在该价格代码
//					echo '<pre>';print_r($pms_state[$lrm['room_info']['webser_id']]);print_r($lrm);exit;
						unset($data[$room_key]['show_info'][$sik]);
						continue;
					}
					
					//PMS上的房态数据
					$tmp = $pms_state[$lrm['room_info']['webser_id']][$web_rate];
					foreach($merge as $w){
						if(isset($tmp[$w])){
							
							if($w == 'date_detail'){
								$allprice = '';
								$amount = 0;
								foreach($tmp [$w] as $dk => $td){
									if($si['price_type'] == 'protrol' && $si['related_cal_way'] && $si['related_cal_value']){
										$tmp [$w] [$dk] ['price'] = round($this->Order_model->cal_related_price($td ['price'], $si['related_cal_way'], $si['related_cal_value'], 'price'));
									} else{
										$tmp [$w] [$dk] ['price'] = $td ['price'];
									}
									$tmp [$w] [$dk] ['nums'] = $tmp['least_num'];
									$allprice .= ',' . $tmp [$w] [$dk] ['price'];
									$amount += $tmp [$w] [$dk] ['price'];
								}
								
								$data [$room_key] ['show_info'] [$sik] ['avg_price'] = number_format($amount / $params ['countday'], 1);
								$data [$room_key] ['show_info'] [$sik] ['allprice'] = substr($allprice, 1);
								$data [$room_key] ['show_info'] [$sik] ['total'] = intval($amount);
								$data [$room_key] ['show_info'] [$sik] ['total_price'] = $data [$room_key] ['show_info'] [$sik] ['total'] * $nums;
							}
						}
						
						$data[$room_key]['show_info'][$sik][$w] = $tmp[$w];
					}
				}
			}
			if(empty($data[$room_key]['state_info'])){
				unset($data[$room_key]);
			}
		}
//		echo '<pre>';print_r($data);exit;
		
		
		return $data;
	}
	
	public function get_rooms_change_allpms($pms_state, $rooms, $params){
		$data = array();
		foreach($rooms ['rooms'] as $rm){
			if(!empty ($pms_state ['pms_state'] [$rm ['webser_id']])){
				$data [$rm ['room_id']] ['room_info'] = $rm;
				$data [$rm ['room_id']] ['state_info'] = empty ($pms_state ['valid_state'] [$rm ['webser_id']]) ? array() : $pms_state ['valid_state'] [$rm ['webser_id']];
				$data [$rm ['room_id']] ['show_info'] = $pms_state ['pms_state'] [$rm ['webser_id']];
				$data [$rm ['room_id']] ['lowest'] = min($pms_state ['exprice'] [$rm ['webser_id']]);
				$data [$rm ['room_id']] ['highest'] = max($pms_state ['exprice'] [$rm ['webser_id']]);
			}
		}
		
		return $data;
	}
	
	function pms_enum($type = '',$key=''){
		$arr=[];
		switch($type){
			case 'status':
				//订单状态,0预订，1确认，2入住，3离店，4用户取消，5酒店取消,6酒店删除，7异常，8未到，9待支付
				$arr = array(
					'3'          => 3,
					'1'          => 1,
					'2'          => 8,
					'0'          => 5,
					'InProgress' => 1,
					'Finish'     => 3,
					'NoShow'     => 8,
					'Cancel'     => 5,
					'I'          => 2,
					'O'          => 3,
					'S'          => 3
				);
				break;
			case  'func_name':
				$arr=[
					'Search'=>'房态查询',
					'GetHourRentMemberPrice'=>'时租房价',
					'GetAvailablePromotionPrices'=>'促销活动',
					'AddOrder'=>'提交订单',
					'GetOrder'=>'查询订单',
					'SearchCheckin'=>'查询入住',
					'CancelOrder'=>'取消订单',
					'AddOnlinePayment'=>'添加在线支付',
					'UpdateOnlinePayment'=>'更新在线支付',
					'AddBillItem'=>'添加到账',
				];
				break;
		}
		
		if($key === ''){
			return $arr;
		}
		return isset($arr[$key]) ? $arr[$key] : null;
	}
	
	public function cancel_order_web($inter_id, $order, $pms_set = array(), $reason = '用户取消'){
		$this->inter_id=$order['inter_id'];
		if(empty ($order ['web_orderid'])){
			return array(
				's'      => 0,
				'errmsg' => '取消失败~'
			);
		}
		
		//判断订单时间
		/*$intime = strtotime($order['startdate']);
		if(mktime(12, 0, 0, date('m', $intime), date('d', $intime), date('Y', $intime)) < time()){
			//时间超过入住时间当天的12点时不能取消
			return array(
				's'      => 0,
				'errmsg' => '只能在入住当天12点前取消订单！',
			);
		}*/
		
		$web_orderid = $order['web_orderid'];
//		$reason = '用户取消订单！';
		$web_order = $this->get_web_order($web_orderid, $pms_set,$order['orderid']);
		$web_order = obj2array($web_order);
		$data = array();
		if(!empty($web_order)){
			$cancel = new OrderCancelRequest();
			$cancel->HotelId = doubleval($pms_set['hotel_web_id']);
			$cancel->OrderId = doubleval($web_orderid);
			$cancel->Reason = $reason;
			
			$signs = json_decode(json_encode($cancel), true);
			$signs['HotelId'] = $pms_set['hotel_web_id'];
			$signs['OrderId'] = $web_orderid;
			ksort($signs, SORT_STRING);
			$sign_paras = array('orderCancelRequest' => $signs);
			$paras = array('orderCancelRequest' => $cancel);
			$result = $this->sub_to_web('order', "CancelOrder", $paras, $sign_paras,0,['orderid'=>$order['orderid']]);
			if($result->CancelOrderResult->Success == 'true'){
				$data['s'] = 1;
				$data['msg'] = '已取消';
			} else{
				$data['s'] = 0;
				$data['errmsg'] = '取消失败！' . (!empty($result->CancelOrderResult->ErrorMessage) ? $result->CancelOrderResult->ErrorMessage : '');
			}
		} else{
			$data['s'] = 0;
			$data['errmsg'] = '取消失败！';
		}
		return $data;
	}
	
	public function getWebCheckin($hotel_web_id, $web_orderid,$orderid){
		$cki_req = new CheckinSearchRequest();
		$data = array();
		$cki_req->HotelId = doubleval($hotel_web_id);
		$cki_req->OrderIds = array(doubleval($web_orderid));
		$signs = json_decode(json_encode($cki_req), true);
		ksort($signs, SORT_STRING);
		$signs['HotelId'] = $hotel_web_id;
		$signs['OrderIds'] = array($web_orderid);
		$sign_paras = array('checkinSearchRequest' => $signs);
		$paras = array('checkinSearchRequest' => $cki_req);
		$result = $this->sub_to_web('order', "SearchCheckin", $paras, $sign_paras,0,['orderid'=>$orderid]);
		if($result->SearchCheckinResult->Success == 'true' && !empty($result->SearchCheckinResult->Content->CheckinResponse)){
			$info = $result->SearchCheckinResult->Content->CheckinResponse;
			$info = obj2array($info);
			if($info){
				is_array(current($info)) or $info = array($info);
				foreach($info as $v){
					$data[number_format($v['OrderId'], 0, '', '')][number_format($v['CheckinId'], 0, '', '')] = $v;
				}
			}
		}
		return $data;
	}
	
	function getOrderBill($hotelid, $billid,$orderid){
		$bill_req = new BillDetailRequest();
		$bill_req->BillId = floatval($billid);
		$bill_req->HotelId = floatval($hotelid);
		$paras = array('billDetailRequest' => $bill_req);
		$signs = json_decode(json_encode($paras), true);
		$signs['billDetailRequest']['HotelId'] = $hotelid;
		$signs['billDetailRequest']['BillId'] = $billid;
		ksort($signs, SORT_STRING);
		$result = $this->sub_to_web('bill', "GetBillDetails", $paras, $signs,0,['orderid'=>$orderid]);
		if('true'==$result->GetBillDetailsResult->Success&&!empty($result->GetBillDetailsResult->Content->BillItemResponse)){
			$res=$result->GetBillDetailsResult->Content->BillItemResponse;
			$res=obj2array($res);
			is_array(current($res)) or $res=[$res];
			return $res;
		}
		return [];

//		return $result;
//		var_dump($result);
	}
	
	public function getOccupation($web_orderids, $pms_set){
		$occ_req = new OccupationSearchRequest();
		$occ_req->HotelId = doubleval($pms_set['hotel_web_id']);
		$occ_req->OrderId = doubleval($web_orderids);
		
		$signs = json_decode(json_encode($occ_req), true);
		ksort($signs, SORT_STRING);
		$signs['HotelId'] = $pms_set['hotel_web_id'];
		$signs['OrderId'] = $web_orderids;
		$sign_paras = array('occupationSearchRequest' => $signs);
		$paras = array('occupationSearchRequest' => $occ_req);
		$result = $this->sub_to_web('order', "SearchOccupation", $paras, $sign_paras);
		
		/*if($result->SearchOccupationResult->Success == 'true' && !empty($result->SearchOccupationResult->Content->OccupationResponse)){
			$this->db->where(array('orderid' => $orderid, 'webs_orderid' => $od['webs_orderid'], 'id' => $od['id']));
			$this->db->update('hotels_order_items', array('webs_occupy_id' => number_format($result->SearchOccupationResult->Content->OccupationResponse->OccupationId, 0, '', '')));
		}*/
		
	}
	
	public function update_web_order($inter_id, $order, $pms_set){
		$web_orderid = $order['web_orderid'];
		$web_order = $this->get_web_order($order['web_orderid'], $pms_set,$order['orderid']);
		$web_order = obj2array($web_order);
		$istatus = -1;
		
		$this->inter_id=$order['inter_id'];
		
		if(!empty ($web_order)){
			$web_status = $web_order['OrderStatus'];
			$status_arr = $this->pms_enum('status');
			$this->load->model('hotel/Order_model');
			$status = $status_arr[$web_status];
			
			// 未确认单先确认
			if($status != 0 && $order ['status'] == 0){
				$this->change_order_status($inter_id, $order['orderid'], 1);
				$this->Order_model->handle_order($inter_id, $order ['orderid'], 1, '', array(
					'no_tmpmsg' => 1
				));
			}
			
			if($web_status == 'InProgress' || $web_status == 'Finish'){
				
				$checkin_status = $this->getWebCheckin($pms_set['hotel_web_id'], $web_orderid,$order['orderid']);
				if(!empty($checkin_status[$web_orderid])){
					//本地订单列表是否已更新过入住ID
					$local_items = array();
					$local_noitem = array();
					foreach($order ['order_details'] as $od){
						if(!empty($od['webs_orderid'])){
							$local_items[$od['webs_orderid']] = $od;
						} else{
							$local_noitem[] = $od;
						}
					}
					$i = 0;
					foreach($checkin_status[$web_orderid] as $k => $v){
						//判断该入住ID是否已存在本地订单中
						$updata = array();
						if(array_key_exists($k, $local_items)){
							$od = $local_items[$k];
						} else{
							//不存在本地订单中
							$od = $local_noitem[$i];
							
							$this->db->where(array('id' => (int)$od['sub_id']))->update('hotel_order_items', array('webs_orderid' => $k));
							
							$i++;
						}
						$wstatus = $v['CheckinStatus'];//订单状态
						$istatus = $status_arr[$wstatus];
						if($od ['istatus'] == 4 && $istatus == 5){
							$istatus = 4;
						}
						
						list($s_day, $s_time) = explode('T', $v['ActualArriveTime'], 2);
						//实际入住时间
						$web_start = date('Ymd', strtotime($s_day));
						if($v['ActualDepatureTime']){
							//实际离店时间
							list($e_day, $e_time) = explode('T', $v['ActualDepatureTime'], 2);
						} else{
							list($e_day, $e_time) = explode('T', $v['EstimatedDepartureTime'], 2);
						}
						
						$web_end = date('Ymd', strtotime($e_day));
						if($order['price_type']!='athour'){
							$web_end = $web_end == $web_start ? date('Ymd', strtotime('+ 1 day', strtotime($web_start))) : $web_end;
						}
						//判断实际入住时间，订单记录的入住时间
						$ori_day_diff = get_room_night($od ['startdate'],$od ['enddate'],'ceil',$od);//至少有一个间夜
						$web_day_diff = get_room_night($web_start,$web_end,'ceil');//至少有一个间夜
						$day_diff = $web_day_diff - $ori_day_diff;
						
						$updata ['startdate'] = $web_start;
						$updata ['enddate'] = $web_end;
						
						if($day_diff != 0 || $web_start != $od ['startdate'] || $web_end != $od ['enddate']){
							$updata ['no_check_date'] = 1;
						}
						
						if(3 == $istatus){//离店，计算最新房费
							
							$bill_info = $this->getOrderBill($pms_set['hotel_web_id'], $v['BillId'],$order['orderid']);
							$fang_fee = ['D1000', 'D1001', 'D1002', 'D1020','D1005'];
							if($bill_info){
								$new_price = 0;
								foreach($bill_info as $t){
									if(in_array($t['DebitType'], $fang_fee)){//房费类型
										$new_price += $t['Amount'];
									}
								}
								
								if($new_price >= 0 && $new_price != $od['iprice']){
									$updata['no_check_date'] = 1;
									$updata['new_price'] = $new_price;
								}
							}
						}
						
						if($istatus != $od ['istatus']){
							$updata ['istatus'] = $istatus;
						}
						
						if(!empty ($updata)){
							$this->Order_model->update_order_item($inter_id, $order ['orderid'], $od ['sub_id'], $updata);
//					$this->wm->log_service_record('子订单更新资料:' . json_encode($updata), '', $order['inter_id'], 'jinjiang', 'update_order_item', 'query_post');
						}
						
					}

//					$ckstatus = $checkin_status[$web_orderid];
//					$status = $status_arr[$ckstatus['CheckinStatus']];
				
				} else{
					if($web_order == 'Finish'){
						$status = 7;//订单完成但没有入住信息
						$this->change_order_status($inter_id, $order['orderid'], $status);
						$this->Order_model->handle_order($inter_id, $order ['orderid'], $status, $order ['openid']);
					}
				}
			} else{
				if($order ['status'] == 4 && $status == 5){
					$status = 4;
				}
				$istatus = $status;
				
				if($status != $order['status']){
					$this->change_order_status($inter_id, $order['orderid'], $status);
					$this->Order_model->handle_order($inter_id, $order ['orderid'], $status, $order ['openid']);
				}
			}
			
		}
		return $istatus;
	}
	
	public function get_web_order($web_orderid, $pms_set,$orderid=''){
		$paras = array('orderId' => doubleval($web_orderid), 'hotelId' => doubleval($pms_set['hotel_web_id']));
		$sign_params=['orderId'=>$web_orderid,'hotelId'=>$pms_set['hotel_web_id']];
		$result = $this->sub_to_web('order', "GetOrder", $paras,$sign_params,0,['orderid'=>$orderid]);
		$data = array();
		if($result->GetOrderResult->Success == 'true'){
			$data = $result->GetOrderResult->Content;
		}
		return $data;
	}
	
	private function change_order_status($inter_id, $orderid, $status){
		$this->db->where(array(
			'orderid'  => $orderid,
			'inter_id' => $inter_id
		));
		$this->db->update('hotel_orders', array( // 提交失败，把订单状态改为下单失败
		                                         'status' => (int)$status
		));
	}
	
	public function order_to_web($inter_id, $orderid, $params = array(), $pms_set = array()){
		$this->load->model('hotel/Order_model');
		$order = $this->Order_model->get_main_order($inter_id, array(
			'orderid' => $orderid,
			'idetail' => array(
				'i'
			)
		));
		if(!$order){
			return array(
				's'      => 0,
				'errmsg' => '订单不存在'
			);
		}
		$order = $order[0];
		$this->inter_id=$order['inter_id'];
		
		$res = $this->order_reserve($order, $pms_set, $params);
		
		if(!$res['result']){
			$this->change_order_status($inter_id, $orderid, 10);
			
			return array(
				's'      => 0,
				'errmsg' => $res['errmsg']
			);
		} else{
			$web_orderid = $res['oid'];
			$this->db->where(array(
				'orderid'  => $order ['orderid'],
				'inter_id' => $order ['inter_id']
			));
			$this->db->update('hotel_order_additions', array(        //更新pms单号到本地
			                                                         'web_orderid' => $web_orderid
			));
			
			if($order ['status'] != 9){
				$this->change_order_status($inter_id, $orderid, 1);
				
				$this->db->where(array(
					'orderid'  => $order ['orderid'],
					'inter_id' => $order ['inter_id']
				))->update('hotel_order_items', array(
					'istatus' => 1
				));
				
				$this->Order_model->handle_order($inter_id, $orderid, 1); // 若pms的订单是即时确认的，执行确认操作，否则省略这一步
			}
			
			if($order ['paytype'] == 'balance'){
				
				statistic('Z1');
				$this->load->model('hotel/Hotel_config_model');
				$config_data = $this->Hotel_config_model->get_hotel_config($inter_id, 'HOTEL', $order ['hotel_id'], array(
					'PMS_BANCLANCE_REDUCE_WAY'
				));
				if(!empty ($config_data ['PMS_BANCLANCE_REDUCE_WAY']) && $config_data ['PMS_BANCLANCE_REDUCE_WAY'] == 'after'){
					$this->load->model('api/Vmember_model', 'vm');
					$member_id = $this->vm->getPmsUserId($order['openid'], $order['inter_id']);
					//调用入账接口
					$pay_params = array(
						'member_id' => !empty($member_id) ? $member_id : '',
					);
					
					$pay_res = $this->addBalanceBill($web_orderid, $order, $pms_set, $pay_params);
					if($pay_res){
						$this->Order_model->update_order_status($inter_id, $order ['orderid'], 1, $order ['openid'], true);
					}else{
						
						$info = $this->Order_model->cancel_order($inter_id, array(
							'only_openid'   => $order ['openid'],
							'member_no'     => '',
							'orderid'       => $order ['orderid'],
							'cancel_status' => 5,
							'no_tmpmsg'     => 1,
							'delete'        => 2,
							'idetail'       => array(
								'i'
							)
						));
						
						return [
							's'=>0,
							'errmsg'=>'储值支付失败！',
						];
					}
					
				}
				statistic('Z2');
				$g_h = statistic('Z1', 'Z2');//储值支付
				$timer_arr=[
					'储值支付耗时：'=>$g_h,
				];
				pms_logger(func_get_args(), $timer_arr, __METHOD__ . '->query_time', $order['inter_id']);
				
			}
			
			
			if(!empty($params['trans_no'])){
				$this->add_web_bill($web_orderid, $order, $pms_set, $params['trans_no']);
			}
			
			return array('s' => 1);
		}
	}
	
	function addWebOnlineBill($web_order, $order, $pms_set, $params = array()){
		
		$web_paid = 2;
		
		//微信支付，
		//1.需要先调用PMS上的【添加在线支付】
		$onlineReq = new OnlinePaymentRequest();
		$onlineReq->HotelId = doubleval($pms_set['hotel_web_id']);
		$onlineReq->BillId = doubleval($web_order['BillId']);
		$onlineReq->PayType = 'WeChat';
		$onlineReq->Amount = $order['price'];
		
		$paras = array('onlinePaymentAddRequest' => $onlineReq);
		$signs = obj2array($paras);
		$signs['onlinePaymentAddRequest']['HotelId'] = $pms_set['hotel_web_id'];
		$signs['onlinePaymentAddRequest']['BillId'] = $web_order['BillId'];
		
		$result = $this->sub_to_web('bill', 'AddOnlinePayment', $paras, $signs,0,['orderid'=>$order['orderid']]);
		
		if($result->AddOnlinePaymentResult->Success == 'true' && !empty($result->AddOnlinePaymentResult->Content)){
			$res = obj2array($result->AddOnlinePaymentResult->Content);
			$onlinePaymentId = $res['Id'];
		} else{
			return $web_paid;
		}
		
		$time = time();
		
		//2.调用修改在线支付接口
		$updateRequest = new PaymentUpdateReqeust();
		$updateRequest->HotelId = doubleval($pms_set['hotel_web_id']);
		$updateRequest->Id = doubleval($onlinePaymentId);
		$updateRequest->TransctionId = $params['trans_no'];
		$updateRequest->PayAmount = $order['price'];
		$updateRequest->PayTime = date('Y-m-d') . 'T' . date('H:i:s') . '.000';
//		$updateRequest->BillItemId = doubleval($res['BillItemId']);
		$paras = array('onlinePaymentUpdateRequest' => $updateRequest);
		$signs = obj2array($paras);
		$signs['onlinePaymentUpdateRequest']['HotelId'] = $pms_set['hotel_web_id'];
		$signs['onlinePaymentUpdateRequest']['Id'] = $onlinePaymentId;
		
		$result = $this->sub_to_web('bill', 'UpdateOnlinePayment', $paras, $signs,0,['orderid'=>$order['orderid']]);
		
		if(!empty($result->UpdateOnlinePaymentResult->Content) && $result->UpdateOnlinePaymentResult->Success == 'true'){
			$web_paid = 1;
			$time = time();
			//3.调用到账接口
			$payment_req = new PaymentRequest();
			
			/*if(!empty($params['member_id'])){
				$payment_req->MemberId = $params['member_id'];
			}*/
			$payment_req->OnlinePaymentId = doubleval($onlinePaymentId);
			$payment_req->Amount = $order['price'];
//		$payment_req->Memo = '微信支付订单';// . '=========测试到账';
			$payment_req->FeeType = '酒店预订费用';
			
			$bill_req = new BillItemAddRequest();
			$bill_req->Amount = $order['price'];
			$bill_req->BillId = doubleval($web_order['BillId']);
			$bill_req->SubItemType = 'C9240';
			
			$bill_req->BillItemType = 'Credit';
			
			$bill_req->HotelId = doubleval($pms_set['hotel_web_id']);
			
			$bill_req->Memo = '微信支付订单';// . '=========测试到账';
			$bill_req->PaymentRequest = $payment_req;
			
			$paras = array('billItemAddRequest' => $bill_req);
			$signs = obj2array($paras);
			$signs['billItemAddRequest']['HotelId'] = $pms_set['hotel_web_id'];
			$signs['billItemAddRequest']['BillId'] = $web_order['BillId'];
			$signs['billItemAddRequest']['PaymentRequest']['OnlinePaymentId'] = $onlinePaymentId;
			ksort($signs, SORT_STRING);
			
			$result = $this->sub_to_web('bill', "AddBillItem", $paras, $signs,0,['orderid'=>$order['orderid']]);
			
			if(!empty($result->AddBillItemResult->Content) && $result->AddBillItemResult->Success == 'true'){
				$web_paid = 1;
			}
		}
		
		return $web_paid;
	}
	
	public function addBalanceBill($web_orderid, $order, $pms_set, $params = array()){
		$res = false;
		if(empty($web_orderid)){
			return false;
		}
		//查询网络订单是否存在
		$web_order = $this->get_web_order($web_orderid, $pms_set,$order['orderid']);
		$web_order = obj2array($web_order);
		statistic('B2');
		if(!$web_order){
			return false;
		}
		
		$payment_req = new PaymentRequest();
		if(!empty($params['member_id'])){
			$payment_req->MemberId = $params['member_id'];
		}
		
		$payment_req->Amount = $order['price'];
//		$payment_req->Memo = '微信支付订单';// . '=========测试到账';
		$payment_req->FeeType = 'A';// . '=========测试到账';
		
		$bill_req = new BillItemAddRequest();
		$bill_req->Amount = $order['price'];
		$bill_req->BillId = doubleval($web_order['BillId']);
		$bill_req->SubItemType = 'C9130';
		
		$bill_req->BillItemType = 'Credit';
		
		$bill_req->HotelId = doubleval($pms_set['hotel_web_id']);
		
		$bill_req->Memo = '储值支付订单';
		$bill_req->PaymentRequest = $payment_req;
		
		$paras = array('billItemAddRequest' => $bill_req);
		$signs = obj2array($paras);
		$signs['billItemAddRequest']['HotelId'] = $pms_set['hotel_web_id'];
		$signs['billItemAddRequest']['BillId'] = $web_order['BillId'];
		ksort($signs, SORT_STRING);
		
		$result = $this->sub_to_web('bill', "AddBillItem", $paras, $signs,0,['orderid'=>$order['orderid']]);
		
		if(!empty($result->AddBillItemResult->Content) && $result->AddBillItemResult->Success == 'true'){
			$res = true;
		}
		
		return $res;
	}
	
	function add_web_bill($web_orderid, $order, $pms_set, $trans_no = ''){
		statistic('B1');
		$web_paid = 2;
		//空订单号
		if(empty($web_orderid)){
			$this->db->where(array(
				'orderid'  => $order ['orderid'],
				'inter_id' => $order ['inter_id']
			));
			$this->db->update('hotel_order_additions', array( //更新web_paid 状态，2为失败，1为成功
			                                                  'web_paid' => $web_paid
			));
			return false;
		}
		$this->inter_id=$order['inter_id'];
		//查询网络订单是否存在
		$web_order = $this->get_web_order($web_orderid, $pms_set,$order['orderid']);
		$web_order = obj2array($web_order);
		statistic('B2');
		if(!$web_order){
			$this->db->where(array(
				'orderid'  => $order ['orderid'],
				'inter_id' => $order ['inter_id']
			));
			$this->db->update('hotel_order_additions', array(
				'web_paid' => $web_paid
			));
			return false;
		}
		
		if($order ['status'] != 9){
			$this->change_order_status($order['inter_id'], $order['orderid'], 1);
			
			$this->db->where(array(
				'orderid'  => $order ['orderid'],
				'inter_id' => $order ['inter_id']
			))->update('hotel_order_items', array(
				'istatus' => 1
			));
			
		}
		
		$this->load->model('api/Vmember_model', 'vm');
		$member_id = $this->vm->getPmsUserId($order['openid'], $order['inter_id']);
		statistic('B3');
		$params = array(
			'trans_no' => $trans_no,
		);
		if($member_id){
			$params['member_id'] = $member_id;
		}
		
		$web_paid = $this->addWebOnlineBill($web_order, $order, $pms_set, $params);
		
		statistic('B4');
		
		$this->db->where(array(
			'orderid'  => $order ['orderid'],
			'inter_id' => $order ['inter_id']
		));
		$this->db->update('hotel_order_additions', array(
			'web_paid' => $web_paid
		));
		statistic('B5');
		$time_arr = array(
			'请求PMS订单信息' => statistic('B1', 'B2') . '秒',
			'请求会员接口'    => statistic('B2', 'B3') . '秒',
			'请求入账接口'    => statistic('B3', 'B4') . '秒',
			'更新本地订单状态'  => statistic('B4', 'B5') . '秒',
			'总执行时间'     => statistic('B1', 'B5') . '秒',
			'执行时间'      => date('Y-m-d H:i:s'),
		);
		
		pms_logger(func_get_args(), $time_arr, __METHOD__ . '->query_time', $pms_set['inter_id']);
		return $web_paid==1;
	}
	
	
	public function rollback_bill($web_orderid, $pms_set, $remark = ''){
		$web_order = $this->get_web_order($web_orderid, $pms_set);
		$web_order = obj2array($web_order);
		if(!$web_order){
			return false;
		}
		
		$hotel_web_id = $pms_set['hotel_web_id'];
		$bill_item_id = $web_order['BillId'];

//		is_array($bill_item_id) or $bill_item_id=array($bill_item_id);
		$req = new stdClass();
		$req->HotelId = doubleval($hotel_web_id);
		$req->BillItemIds = array(
			doubleval($bill_item_id)
		);
		$req->Memo = $remark;
		$paras = array('model' => $req);
		$signs = json_decode(json_encode($paras), true);
		$signs['model']['HotelId'] = $hotel_web_id;
		$signs['model']['BillItemIds'] = array($bill_item_id);
		
		ksort($signs, SORT_STRING);
		
		$result = $this->sub_to_web('bill', "Rollback", $paras, $signs);
		
		return $result;
		
	}
	
	function order_reserve($order, $pms_set, $params = array()){
		statistic('A1');
		$startdate = date('Y-m-d', strtotime($order['startdate']));
		$enddate = date('Y-m-d', strtotime($order['enddate']));
		
		$new_startdate=$startdate;
		
		
		//判断是否预订凌晨房，入住时间非当天，而且离店时间为当天的
		$is_bd = false;
		if(strtotime($new_startdate) < strtotime(date('Y-m-d'))){
			if($enddate == date('Y-m-d')){
				//离店时间为当天的，则认为是凌晨房
				$new_startdate = date('Y-m-d');
				$is_bd = true;
			} else{
				//其他情况提示用户重新选择日期
				return [
					'result' => false,
					'errmsg' => '预订凌晨房需要入住时间为昨天，离店时间必须是当天！',
				];
			}
		}
		
		$room_codes = json_decode($order ['room_codes'], true);
		$room_codes = $room_codes [$order ['first_detail'] ['room_id']];
		
		$extra_info = $room_codes['code']['extra_info'];
		
		$webser_id = !empty($extra_info['webser_id']) ? $extra_info['webser_id'] : $room_codes['room']['webser_id'];
		
		if(!isset($extra_info['pms_code'])){
			return array(
				'result' => false,
				'errmsg' => '不存在价格代码',
			);
		}
		$price_list = array();
		$is_hours = $extra_info['is_hours'];
		$promotion_id = !empty($extra_info['promotion_id']) ? $extra_info['promotion_id'] : null;
		
		//需要显示的级别
		$this->load->model('common/Webservice_model');
		$web_reflect = $this->Webservice_model->get_web_reflect($pms_set['inter_id'], $order['hotel_id'], $pms_set ['pms_type'], array(
			'web_member_list',
			'member_price_code',
		), 1, 'w2l');
		
		$web_member_list = array();
		if(!empty($web_reflect['web_member_list'])){
			$web_member_str = '';
			foreach($web_reflect['web_member_list'] as $v){
				$web_member_str .= ',' . $v;
			}
			$web_member_str = substr($web_member_str, 1);
			$web_member_list = explode(',', $web_member_str);
		}
		array_push($web_member_list, '');
		
		if($promotion_id){
			$promo_params = array(
				'openid'         => $order['openid'],
				'web_room_types' => array($webser_id),
			);
			$promotion_list = $this->getPromoPrice($pms_set['hotel_web_id'], $startdate, $enddate, $promo_params, $pms_set['inter_id']);
			is_array(current($promotion_list)) or $promotion_list = array($promotion_list);
			
			foreach($promotion_list as $v){
				if($v['PromotionId'] == $promotion_id){
					is_array(current($v['DetailPrices']['RoomPrice'])) or $v['DetailPrices']['RoomPrice'] = array($v['DetailPrices']['RoomPrice']);
					foreach($v['DetailPrices']['RoomPrice'] as $t){
						$date_arr = explode('T', $t['Date']);
						$t['InDate'] = $date_arr[0];
						$price_list[date('Ymd', strtotime($date_arr[0]))] = array(
							'OrignPrice'  => $t['OrignPrice'],
							'ActualPrice' => $t['ActualPrice'],
						);
					}
					break;
				}
			}
		} elseif($is_hours){
			
			$this->load->model('api/Vmember_model', 'vm');
			//会员信息
			$member_info = $this->vm->getUserInfo($order['openid'], $order['inter_id']);
			if(!empty($member_info['pms_user_id'])){
//				$clock_member_list = isset($web_reflect['member_price_code'][$member_info['lvl_pms_code']]) ? $web_reflect['member_price_code'][$member_info['lvl_pms_code']] : '非会员';
				$clock_member_list = [$member_info['lvl_pms_code']];
			} else{
				$clock_member_list = [''];
			}
			statistic('b');
			//时租房价
			$pms_price_arr = $this->getHourPrice($pms_set['hotel_web_id'], $startdate, $clock_member_list, $pms_set['inter_id']);
			statistic('k');
			$b_k = statistic('b', 'k');
			foreach($pms_price_arr as $v){
				$_rate = trim($v['CheckinType']);
				if($extra_info['pms_code'] == $_rate && !empty($v['Prices']['RoomPrice'])){
					foreach($v['Prices']['RoomPrice'] as $t){
						if($t['RoomTypeId'] == $webser_id){
							$date_arr = explode('T', $t['Date']);
							$t['InDate'] = $date_arr[0];
							$price_list[date('Ymd', strtotime($date_arr[0]))] = array(
								'OrignPrice'  => $t['OrignPrice'],
								'ActualPrice' => $t['ActualPrice'],
							);
						}
					}
				}
			}
		} else{
			
			$search_params = array(
				'member_levels'  => $web_member_list,
				'web_room_types' => array($webser_id),
			);
			if(!empty($extra_info['virtual'])){
				unset($search_params['web_room_types']);
				$search_params['member_levels'] = array($extra_info['pms_code']);
			}
			
			$_list = $this->searchHotelById($pms_set['hotel_web_id'], $startdate, $enddate, $search_params, $pms_set['inter_id']);
			statistic('A2');
			$a_b = statistic('A1', 'A2');//查询实时房态
			
			//该酒店的房型信息
			$room_detail = $_list[$pms_set['hotel_web_id']];
			is_array(current($room_detail['DetailPrices']['RoomPrice'])) or $room_detail['DetailPrices']['RoomPrice'] = array($room_detail['DetailPrices']['RoomPrice']);
			foreach($room_detail['DetailPrices']['RoomPrice'] as $v){
				if($v['RoomTypeId'] == $webser_id){//只取下单的房型
					$_rate = trim($v['Description']);
					//只取下单的房价代码
					if($extra_info['pms_code'] == $_rate){
						$date_arr = explode('T', $v['Date']);
						$v['InDate'] = $date_arr[0];
						$price_list[date('Ymd', strtotime($date_arr[0]))] = array(
							'OrignPrice'  => $v['OrignPrice'],
							'ActualPrice' => $v['ActualPrice'],
						);
					}
				}
			}
		}
//		}
		
		$OrderAddRequest = new OrderAddRequest();
		if($order['inter_id'] == 'a464919542' || $order['inter_id'] == 'a467894987'){
			statistic('A3');
			$this->load->model('api/Vmember_model', 'vm');
			$member_id = $this->vm->getPmsUserId($order['openid'], $order['inter_id']);
			if($member_id){
				$OrderAddRequest->MemberId = $member_id;
			}
			statistic('A4');
			$c_d = statistic('A3', 'A4');   //请求会员接口
		}
		statistic('A5');
		$OrderAddRequest->HotelId = doubleval($pms_set['hotel_web_id']);
		$OrderAddRequest->EstimatedArriveTime = $new_startdate . ($is_bd ? 'T05:00:00.000' : 'T12:00:00.000');
		$OrderAddRequest->EstimatedDepartureTime = $enddate . 'T12:00:00.000';
		$OrderAddRequest->Locked = false;
		
		$OrderAddRequest->IsExtenalPrice = true;
		if($order['paytype'] != 'daofu'){
			$OrderAddRequest->PrePaymentTypeId = 'Full';
		}
		//入住类型,若是时租房类型，则将入住类型改为时租类型
		if($is_hours){
			$OrderAddRequest->CheckinType = $extra_info['pms_code'];
			$OrderAddRequest->EstimatedArriveTime = date('Y-m-d',strtotime($order['starttime'])).'T'.date('H:i:s',strtotime($order['starttime'])).'.000';
			$OrderAddRequest->EstimatedDepartureTime = date('Y-m-d',strtotime($new_startdate)+86400) . 'T12:00:00.000';
		}
		
		$guest1 = new Guest();
		$guest1->Name = $order['name'];
		$Guests[] = $guest1;
		$OrderAddRequest->Guests = $Guests;
		
		$liaison1 = new Liaison();
		$liaison1->Name = $order['name'];
		$liaison1->Mobile = $order['tel'];
		$Liaison[] = $liaison1;
		$OrderAddRequest->Liaisons = $Liaison;
		$dates = array();
		
		if($is_bd){
			$dates[]=$startdate;
		}elseif($is_hours){
			$dates[]=$new_startdate;
		}else{
			for($tmpdate = $order['startdate']; $tmpdate < $order['enddate'];){
				$dates[] = $tmpdate;
				$tmpdate = date('Ymd', strtotime($tmpdate)+86400);
			}
		}
		
		$all = explode(',', $order['first_detail']['allprice']);
		$real_price = explode(',', $order['first_detail']['real_allprice']);
		
		$RoomPrice = array();
		//每日房价
		for($i = 0; $i < count($dates); $i++){
			$rprice = new RoomPrice();
			$rprice->Date = date('Y-m-d', strtotime($dates[$i])) . "T00:00:00";
			
			if(isset($price_list[$dates[$i]])){
				$rprice->OrignPrice = (float)$price_list[$dates[$i]]['OrignPrice'];
//				$rprice->ActualPrice = (float)$price_list[$dates[$i]]['ActualPrice'];
			} else{
				$rprice->OrignPrice = floatval($all[$i]);
			}
			$rprice->ActualPrice = floatval($real_price[$i]);
			$rprice->RoomTypeId = $webser_id;
			$RoomPrice[] = $rprice;
		}
		
		$roomplan = new RoomPlan();
		$roomplan->RoomTypeId = $webser_id;
		$roomplan->Amount = $order['roomnums'];
		$roomplan->Price = $RoomPrice;
		$roomPlans[] = $roomplan;
		
		$OrderAddRequest->RoomPlans = $roomPlans;
		
		$remark = '';
		if(!empty($params['trans_no'])){
			$remark .= '该订单已通过微信支付！';
		}
		
		if($order['paytype'] == 'balance'){
			$remark .= '订单使用储值支付。';
		}
		
		if($order['coupon_favour'] > 0){
			$remark .= '使用优惠券:' . $order['coupon_favour'] . '元';
		}
		if($order['point_favour'] > 0){
			$remark .= '积分扣减：' . $order['point_favour'] . '元。';
		}
		
		if($remark){
			$OrderAddRequest->PublicMemo = $remark;
		}
		
		if(!empty($extra_info['promotion_id'])){
			$OrderAddRequest->PromotionId = $extra_info['promotion_id'];
		}

//		$OrderAddRequest->PromotionId = doubleval('467461302517761');
		$paras = array('orderAddRequest' => $OrderAddRequest);
		$signs = json_decode(json_encode($paras), true);
		$signs['orderAddRequest']['HotelId'] = $pms_set['hotel_web_id'];
		if(!empty($extra_info['promotion_id'])){
			$signs['orderAddRequest']['PromotionId'] = $extra_info['promotion_id'];
		}
		ksort($signs, SORT_STRING);
		
		$result = $this->sub_to_web('order', "AddOrder", $paras, $signs,0,['orderid'=>$order['orderid']]);
		statistic('A6');
		$success = false;
		if($result->AddOrderResult->Success == 'true' && !empty($result->AddOrderResult->Content)){
			$web_orderid = $result->AddOrderResult->Content->OrderId;
			$success = true;
		}
		statistic('A9');
		$e_f = statistic('A5', 'A6');//提交订单到PMS
		$a_i = statistic('A1', 'A9');//完成总耗时
		if(!empty($a_b)){
			$timer_arr['查询实时房成'] = $a_b . '秒';
		}
		if(!empty($b_k)){
			$timer_arr['请求时租房价'] = $b_k . '秒';
		}
		if(!empty($c_d)){
			$timer_arr['请求会员接口'] = $c_d . '秒';
		}
		$timer_arr['提交订单到PMS'] = $e_f . '秒';
		$timer_arr['总耗时'] = $a_i . '秒';
		$timer_arr['执行时间'] = date('Y-m-d H:i:s');
//		$this->load->model('common/Webservice_model', 'wm');
//		$this->wm->add_webservice_record($pms_set['inter_id'], 'beyondh', 'order_reserve', '订单提交' . json_encode($order), json_encode($timer_arr), 'query_time', time(), microtime(), $order['openid']);
		pms_logger(func_get_args(), $timer_arr, __METHOD__ . '->query_time', $order['inter_id']);
		if($success){
			return array(
				'result' => true,
				'oid'    => $web_orderid,
			);
		}
		return array('result' => false, 'errmsg' => $result->AddOrderResult->ErrorMessage);
		
	}
	
	function get_rooms_change_lmem($pms_data, $rooms, $params){
		$local_rooms = $rooms ['rooms'];
		$condit = $params ['condit'];
		$this->load->model('hotel/Order_model');
		$data = $this->Order_model->get_rooms_change($local_rooms, $params ['idents'], $params ['condit']);
		$pms_state = $pms_data ['pms_state'];
		$valid_state = $pms_data ['valid_state'];
		
		foreach($data as $room_key => $lrm){
			$min_price = array();
			if(empty ($valid_state [$lrm ['room_info'] ['webser_id']])){
				unset ($data [$room_key]);
				continue;
			}
			if(!empty ($lrm ['state_info'])){
				foreach($lrm ['state_info'] as $sik => $si){
					// if (isset ( $member_level ) && ! empty ( $condit ['member_privilege'] ) && isset ( $si ['condition'] ['member_level'] ) && array_key_exists ( $si ['condition'] ['member_level'], $condit ['member_privilege'] )) {
					/*if ($si ['external_code'] !== '') {
						$external_code = $params ['web_reflect'] ['member_level'] [$si ['external_code']];
						$external_code_reflect = $params ['web_reflect'] ['member_price_code'] [$external_code];
						$external_code = $params ['web_reflect'] ['member_price_code'] [$price_level];
					}*/
					if($si ['external_code'] !== ''){
//						$external_code_reflect = $params ['web_reflect'] ['member_level'] [$si ['external_code']];
						$external_code_reflect = $params ['web_reflect'] ['member_price_code'] [$si ['external_code']];
					}
//					exit($external_code_reflect);
					if(isset ($external_code_reflect) && !empty ($pms_state [$lrm ['room_info'] ['webser_id']] [$external_code_reflect])){
						$tmp = $pms_state [$lrm ['room_info'] ['webser_id']] [$external_code_reflect];
						// $otmp = $pms_state [$lrm ['room_info'] ['webser_id']] [$external_code];
						$nums = isset ($condit ['nums'] [$lrm ['room_info'] ['room_id']]) ? $condit ['nums'] [$lrm ['room_info'] ['room_id']] : 1;

//						$data [$room_key] ['state_info'] [$sik] ['least_num'] = $tmp ['least_num'];
//						$data [$room_key] ['state_info'] [$sik] ['book_status'] = $tmp ['book_status'];
						
						if ($data [$room_key] ['state_info'] [$sik] ['price_type'] == 'member') {
							$data [$room_key] ['state_info'] [$sik] ['least_num'] = $tmp ['least_num'];
							$data [$room_key] ['state_info'] [$sik] ['book_status'] = $tmp ['book_status'];
						} else {
							$data [$room_key] ['state_info'] [$sik] ['least_num'] = $data [$room_key] ['state_info'] [$sik] ['least_num'] <= $tmp ['least_num'] ? $data [$room_key] ['state_info'] [$sik] ['least_num'] : $tmp ['least_num'];
							$data [$room_key] ['state_info'] [$sik] ['book_status'] = $tmp ['book_status'];
							if ($data [$room_key] ['state_info'] [$sik] ['least_num'] <= 0) {
								$data [$room_key] ['state_info'] [$sik] ['book_status'] = 'full';
							}
						}
						
						$data [$room_key] ['state_info'] [$sik] ['extra_info'] = $tmp ['extra_info'];
						// $data [$room_key] ['state_info'] [$sik] ['extra_info'] ['channel_code'] = $price_level;
						$allprice = '';
						$amount = 0;
						foreach($tmp ['date_detail'] as $dk => $td){
							/*if($si['price_type'] == 'member'){
								$tmp ['date_detail'] [$dk] ['price'] = round($this->Order_model->cal_related_price($td ['price'], $si ['related_cal_way'], $si ['related_cal_value'], 'price'));
							} else{
								$tmp ['date_detail'] [$dk] ['price'] = $td ['price'];
							}
							$tmp ['date_detail'] [$dk] ['nums'] = $data[$room_key]['state_info'][$sik]['least_num'];*/
							
							if ($data [$room_key] ['state_info'] [$sik] ['price_type'] == 'member'||(!empty($si ['related_code']))) {
								$tmp ['date_detail'] [$dk] ['price'] = round ( $this->Order_model->cal_related_price ( $td ['price'], $si ['related_cal_way'], $si ['related_cal_value'], 'price' ) );
							} else {
								$tmp ['date_detail'] [$dk] ['price'] = round ( $data [$room_key] ['state_info'] [$sik] ['date_detail'] [$dk] ['price'] );
							}
							$tmp ['date_detail'] [$dk] ['nums'] = $data [$room_key] ['state_info'] [$sik] ['least_num'];
							
							$allprice .= ',' . $tmp ['date_detail'] [$dk] ['price'];
							$amount += $tmp ['date_detail'] [$dk] ['price'];
						}
						$data [$room_key] ['state_info'] [$sik] ['date_detail'] = $tmp ['date_detail'];
						$data [$room_key] ['state_info'] [$sik] ['avg_price'] = number_format($amount / $params ['countday'], 1);
						$data [$room_key] ['state_info'] [$sik] ['allprice'] = substr($allprice, 1);
						$data [$room_key] ['state_info'] [$sik] ['total'] = intval($amount);
						$data [$room_key] ['state_info'] [$sik] ['total_price'] = $data [$room_key] ['state_info'] [$sik] ['total'] * $nums;
						$min_price [] = $data [$room_key] ['state_info'] [$sik] ['avg_price'];
					}
					// else {
					// unset ( $data [$room_key] ['state_info'] [$sik] );
					// }                                       5
					// }
					// else {
					// $min_price [] = $si ['avg_price'];
					// }
				}
				$data [$room_key] ['lowest'] = empty ($min_price) ? 0 : min($min_price);
				$data [$room_key] ['highest'] = empty ($min_price) ? 0 : max($min_price);
				/*if(!$lrm['show_info']){
					$lrm['show_info'] = $lrm['state_info'];
					$data [$room_key] ['show_info'] = $lrm['state_info'];
				}*/
				if(!empty($lrm['show_info'])){
					foreach($lrm ['show_info'] as $sik => $si){
						if($si ['external_code'] !== ''){
//						$external_code_reflect = $params ['web_reflect'] ['member_level'] [$si ['external_code']];
							$external_code_reflect = $params ['web_reflect'] ['member_price_code'] [$si ['external_code']];
						}
						if(isset ($external_code_reflect) && !empty ($pms_state [$lrm ['room_info'] ['webser_id']] [$external_code_reflect])){
							$tmp = $pms_state [$lrm ['room_info'] ['webser_id']] [$external_code_reflect];
							$nums = isset ($condit ['nums'] [$lrm ['room_info'] ['room_id']]) ? $condit ['nums'] [$lrm ['room_info'] ['room_id']] : 1;
							$data [$room_key] ['show_info'] [$sik] ['least_num'] = $tmp ['least_num'];
							$data [$room_key] ['show_info'] [$sik] ['book_status'] = $tmp ['book_status'];
							$allprice = '';
							$amount = 0;
							foreach($tmp ['date_detail'] as $dk => $td){
								if($data [$room_key] ['state_info'] [$sik] ['price_type'] == 'member'){
									$tmp ['date_detail'] [$dk] ['price'] = round($this->Order_model->cal_related_price($td ['price'], $si ['related_cal_way'], $si ['related_cal_value'], 'price'));
								} else{
									$tmp ['date_detail'] [$dk] ['price'] = $td ['price'];
								}
								
								$tmp ['date_detail'] [$dk] ['nums'] = $data [$room_key] ['state_info'] [$sik] ['least_num'];
								$allprice .= ',' . $tmp ['date_detail'] [$dk] ['price'];
								$amount += $tmp ['date_detail'] [$dk] ['price'];
							}
							$data [$room_key] ['show_info'] [$sik] ['date_detail'] = $tmp ['date_detail'];
							
							$data [$room_key] ['show_info'] [$sik] ['avg_price'] = number_format($amount / $params ['countday'], 1);
							$data [$room_key] ['show_info'] [$sik] ['allprice'] = substr($allprice, 1);
							$data [$room_key] ['show_info'] [$sik] ['total'] = intval($amount);
							$data [$room_key] ['show_info'] [$sik] ['total_price'] = $data [$room_key] ['show_info'] [$sik] ['total'] * $nums;
						} else{
							unset ($data [$room_key] ['show_info'] [$sik]);
						}
					}
				}
			}
			if(empty ($data [$room_key] ['state_info'])){
				unset ($data [$room_key]);
			}
		}
		return $data;
	}
	
	function get_web_roomtype($pms_set, $web_price_code, $startdate, $enddate, $params){
//		$_list = $this->search_web_hotel($startdate, $enddate, 'detail', $pms_set['hotel_web_id']);
		//只显示物理房
		$only_physical = true;
		/*if($pms_set['inter_id'] == 'a467894987' || $pms_set['inter_id'] == 'a464919542'){
		}*/
		if(!empty($params['virtual_price_set'])){
			$only_physical = false;
		}
		
		/*$this->load->model('api/Vmember_model','vm');
		$member_id = $this->vm->getPmsUserId($params['condit']['openid'], $pms_set['inter_id']);*/
		
		$countday = $params['countday'];
		
		//需要显示的级别
		$web_member_list = array();
		if(!empty($params['web_reflect']['web_member_list'])){
			$web_member_str = '';
			foreach($params['web_reflect']['web_member_list'] as $v){
				$web_member_str .= ',' . $v;
			}
			$web_member_str = substr($web_member_str, 1);
			$web_member_list = explode(',', $web_member_str);
		}
		array_push($web_member_list, '');
		
		//查询时租房价的会员等级
		$clock_member_levels=$web_member_list;
		
		$search_params = array(
			'only_physical' => $only_physical,
			'member_levels' => $web_member_list,
		);
		$clock_rate_set = array();
		if(!empty($params['web_reflect']['web_checkin']['hour'])){
			$clock_rate_set = explode(',', $params['web_reflect']['web_checkin']['hour']);
		}
		$promo_rate_set = array();
		if(!empty($params['web_reflect']['web_checkin']['promotion'])){
			$promo_rate_set = explode(',', $params['web_reflect']['web_checkin']['promotion']);
		}
		$clock_recache = false;
		$promo_recache = false;
		$recache = false;
		
		//下单时，刷新缓存
		if($this->uri->segment(3) == 'saveorder'){
			$recache = true;
			$clock_recache = true;
			$promo_recache = true;
			$search_params['web_room_types'] = array_keys($params['web_rids']);
			
			$pcode = $web_price_code[0];
			
			if(in_array($pcode, $params['virtual_price_set'])){
				unset($search_params['web_room_types']);
				$search_params['member_levels'] = array($pcode);
			}
			
			//若价格代码为时租房价，则酒店信息直接获取缓存数据，只读取时租房价的实时数据
			if(in_array($pcode, $clock_rate_set)){     //时租房价
				$recache = false;
				$promo_recache = false;
			} elseif(in_array($pcode, $promo_rate_set)){
				$recache = false;
				$clock_recache = false;
			} else{
				$clock_recache = false;
				$promo_recache = false;
			}
			if(!$recache){
				unset($search_params['web_room_types']);
			}
		}
		
		if(!empty($params['condit']['recache'])){
			$recache=$params['condit']['recache'];
			$clock_recache=$params['condit']['recache'];
			$promo_recache=$params['condit']['recache'];
		}
		
		$search_params['recache'] = $recache;
		
		
		$pms_state = array();
		$valid_state = array();
		$exprice = array();
		
		$_list = $this->searchHotelById($pms_set['hotel_web_id'], $startdate, $enddate, $search_params, $pms_set['inter_id']);
		if(!empty($_list[$pms_set['hotel_web_id']])){
			$room_detail = $_list[$pms_set['hotel_web_id']];
			
			$counts_list = array();
			
			is_array(current($room_detail['RoomCounts']['RoomCount'])) or $room_detail['RoomCounts']['RoomCount'] = array($room_detail['RoomCounts']['RoomCount']);
			foreach($room_detail['RoomCounts']['RoomCount'] as $v){
				$counts_list[$v['RoomTypeId']] = $v;
			}
			
			$price_list = array();
			$web_rate_list = array();
			$clock_rate = array();//时租价
			is_array(current($room_detail['DetailPrices']['RoomPrice'])) or $room_detail['DetailPrices']['RoomPrice'] = array($room_detail['DetailPrices']['RoomPrice']);
			
			foreach($room_detail['DetailPrices']['RoomPrice'] as $v){
				$date_arr = explode('T', $v['Date']);
				$v['InDate'] = $date_arr[0];
				$_rate = trim($v['Description']);
				$room_type = $v['RoomType'];
				$check = true;//判断价格是否可以有效
				if(!empty($room_type['Virtual'])){ //若为虚拟房型只，只读取虚拟房
					//只读取虚拟房专用价格
					if(!in_array($_rate, $params['virtual_price_set'])){
						$check = false;
					}
				} elseif(in_array($_rate, $params['virtual_price_set'])){
					$check = false;
				}
				
				if($check){
					$web_rate_list[$v['RoomTypeId']][] = $_rate;
					$price_list[$v['RoomTypeId']][$_rate][] = $v;
				}
			}
			
			//时租房价
			//获取时租时，只能查询当天的，入住天数不能超过一天
			if(!empty($params['condit']['only_type']) && $params['condit']['only_type'] == 'athour' && $clock_rate_set && date('Ymd') == date('Ymd', strtotime($startdate)) && $countday <= 1){
				//获取时租房价
				//$clock_member_levels
				$pms_price_arr = $this->getHourPrice($pms_set['hotel_web_id'], $startdate, [$params['member_level']], $pms_set['inter_id'], $clock_recache);
				//可以入住的钟点数，2小时或3小时
				$checkin_hour = $params['web_reflect']['web_checkin']['hour'];
				$checkin_hour = explode(',', $checkin_hour);
				foreach($pms_price_arr as $v){
					$_rate = trim($v['CheckinType']);
					
					if(in_array($_rate, $checkin_hour) && !empty($v['Prices']['RoomPrice'])){
						is_array(current($v['Prices']['RoomPrice'])) or $v['Prices']['RoomPrice'] = [$v['Prices']['RoomPrice']];
						foreach($v['Prices']['RoomPrice'] as $t){
//							if($t['ActualPrice'] != $t['OrignPrice'] || $params['member_level'] != ''){
							if($t['ActualPrice'] != $t['OrignPrice']){
								if($t['Description'] == $params['level_price_code']){
									$date_arr = explode('T', $t['Date']);
									$t['InDate'] = $date_arr[0];
									$web_rate_list[$t['RoomTypeId']][] = $_rate;   //将时租类型张为入住类型
									$price_list[$t['RoomTypeId']][$_rate][] = $t;
									$clock_rate[$t['RoomTypeId']][] = $_rate;//记录时租价
								}
							}
						}
					}
				}
			}
			//市场活动
			$promotion_ids = array();
			if(empty($params['condit']['only_type']) || $params['condit']['only_type'] != 'athour'){
				if($promo_rate_set){
					$promo_params = array(
						'openid'         => $params['condit']['openid'],
						'recache'        => $promo_recache,
						'web_room_types' => array_keys($counts_list),
					);
					$promotion_list = $this->getPromoPrice($pms_set['hotel_web_id'], $startdate, $enddate, $promo_params, $pms_set['inter_id']);
					if($promotion_list){
						is_array(current($promotion_list)) or $promotion_list = array($promotion_list);
						$promo_rate_count = count($promo_rate_set);
						for($i = 0; $i < $promo_rate_count; $i++){
							if(!empty($promotion_list[$i])){
								$promo = $promotion_list[$i];
								if($promo['IsActive']){
									is_array(current($promo['DetailPrices']['RoomPrice'])) or $promo['DetailPrices']['RoomPrice'] = array($promo['DetailPrices']['RoomPrice']);
									$promotion_id = $promo['PromotionId'];
									foreach($promo['DetailPrices']['RoomPrice'] as $v){
										$date_arr = explode('T', $v['Date']);
										$v['InDate'] = $date_arr[0];
										$_rate = $promo_rate_set[$i];
										$room_type = $v['RoomType'];
										$v['promotion_id'] = $promo['PromotionId'];
										
										$web_rate_list[$v['RoomTypeId']][] = $_rate;
										$price_list[$v['RoomTypeId']][$_rate][] = $v;
										$promotion_ids[$v['RoomTypeId']][$_rate] = $promotion_id;
									}
								}
							}else{
								break;
							}
						}
					}
				}
			}
			foreach($room_detail['RoomCounts']['RoomCount'] as $v){
				$web_room = $v['RoomTypeId'];
				
				$is_virtual = false;
				
				$room_type = $v['RoomType'];
//				if($pms_set['inter_id'] == 'a467894987' || $pms_set['inter_id'] == 'a464919542'){
				if($room_type['Virtual']){
					$is_virtual = true;
				}
//				}
				
				if(array_key_exists($web_room, $params['web_rids']) || $is_virtual){
					if(empty($price_list[$web_room])){
						continue;
					}
					if($is_virtual){
						$web_room = $room_type['PhysicalRoomTypeId'];
					}
					
					foreach($web_rate_list[$v['RoomTypeId']] as $t){
						$web_rate = $t;
						
						$pms_state[$web_room][$web_rate]['price_name'] = $web_rate;
						$pms_state[$web_room][$web_rate]['price_type'] = 'pms';
						$pms_state[$web_room][$web_rate]['price_code'] = $web_rate;
						$pms_state[$web_room][$web_rate]['extra_info'] = array(
							'type'         => 'code',
							'pms_code'     => $web_rate,
							'virtual'      => $room_type['Virtual'],
							'webser_id'    => $v['RoomTypeId'],
							//是否时租价
							'is_hours'     => !empty($clock_rate[$v['RoomTypeId']]) && in_array($web_rate, $clock_rate[$v['RoomTypeId']]),
							//市场活动ID
							'promotion_id' => !empty($promotion_ids[$v['RoomTypeId']][$web_rate]) ? $promotion_ids[$v['RoomTypeId']][$web_rate] : '',
							'hotel_web_id'=>$pms_set['hotel_web_id'],
						);
						$pms_state[$web_room][$web_rate]['des'] = '';
						$pms_state[$web_room][$web_rate]['sort'] = 0;
						$pms_state[$web_room][$web_rate]['disp_type'] = 'buy';
						
						$web_set = array();
						if(isset ($params ['web_reflect'] ['web_price_code_set'] [$web_rate])){
							$web_set = json_decode($params ['web_reflect'] ['web_price_code_set'] [$web_rate], true);
						}
						
						$pms_state[$web_room][$web_rate]['condition'] = $web_set;
						
						if(isset($params['web_rids'][$web_room]) && isset($params['condit']['nums'][$params['web_rids'][$web_room]])){
							$nums = $params['condit']['nums'][$params['web_rids'][$web_room]];
						} else{
							$nums = 1;
						}
						
						$allprice = array();
						$amount = 0;

//						$least_count = $v['Count'];
						
						$least_arr = [5, $v['Count']];

//					$v['Count'] = 1;
						
						if($v['Count'] > 0){
							$room_status = true;
						} else{
							$room_status = false;
						}
						
						$rate_status = true;

//					$room_rate_daily = $t['RateDetailDailys']['RateDetailDaily'];
//					is_array(current($room_rate_daily)) or $room_rate_daily = array($room_rate_daily);
						//存在每日价格价格
						if(isset($price_list[$v['RoomTypeId']][$web_rate])){
							$sc = count($price_list[$v['RoomTypeId']][$web_rate]);
							for($i = 0; $i < $sc; $i++){
								$w = $price_list[$v['RoomTypeId']][$web_rate][$i];
								
								is_array($v['DetailCounts']['int']) or $v['DetailCounts']['int'] = array($v['DetailCounts']['int']);
								
								$room_count = isset($v['DetailCounts']['int'][$i]) ? $v['DetailCounts']['int'][$i] : 0;
								/*switch($pms_set['inter_id']){
									case 'a464919542':     //清沐正式
									case 'a467894987':              //清沐测试
										$pms_state[$web_room][$web_rate]['date_detail'][date('Ymd', strtotime($w['InDate']))] = array(
											'price' => $w['ActualPrice'],
											'nums'  => $room_count,
										);
										$allprice[] = $w['ActualPrice'];
										$amount += $w['ActualPrice'];
										//每次可预订房间数
										$least_count = min(5, $room_count);
										break;
									default:
										$pms_state[$web_room][$web_rate]['date_detail'][date('Ymd', strtotime($w['InDate']))] = array(
											'price' => $w['OrignPrice'],
											'nums'  => $room_count,
										);
										$allprice[] = $w['OrignPrice'];
										$amount += $w['OrignPrice'];
										//每次可预订房间数
										$least_count = min(1, $room_count);
										break;
								}*/
								
								$pms_state[$web_room][$web_rate]['date_detail'][date('Ymd', strtotime($w['InDate']))] = array(
									'price' => $w['ActualPrice'],
									'nums'  => $room_count,
								);
								$allprice[date('Ymd', strtotime($w['InDate']))] = $w['ActualPrice'];
								$amount += $w['ActualPrice'];
								//每次可预订房间数
								$least_arr[] = $room_count;
//								$least_count = min(5, $room_count);
//								$least_count > 0 or $least_count = 0;
								if($room_status && $rate_status){
									if($room_count < 1){
										$rate_status = false;
									}
								}
							}
						}
						$least_count = min($least_arr);
						$least_count > 0 or $least_count = 0;
						/*if(isset($price_list[$web_room])){
							foreach($price_list[$web_room] as $w){
								$w['RoomCount'] = 1;
								$pms_state[$web_room][$web_rate]['date_detail'][date('Ymd', strtotime($w['InDate']))] = array(
									'price' => $w['OrgnPrice'],
									'nums'  => $w['Count']
								);

								$allprice[] = $w['ActualPrice'];
								$amount += $w['ActualPrice'];
								$least_count = min(1, $w['RoomCount']);
								$least_count > 0 or $least_count = 0;
								if($room_status && $rate_status){
									if($w['RoomCount'] < 1){
										$rate_status = FALSE;
									}
								}

							}
						}*/
						
						ksort($allprice);
						$pms_state[$web_room][$web_rate]['allprice'] = implode(',', $allprice);
						$pms_state[$web_room][$web_rate]['total'] = $amount;
						$pms_state[$web_room][$web_rate]['related_des'] = '';
						$pms_state[$web_room][$web_rate]['total_price'] = $amount * $nums;
						
						$pms_state[$web_room][$web_rate]['avg_price'] = number_format($amount / $params ['countday'], 2, '.', '');
						$pms_state[$web_room][$web_rate]['price_resource'] = 'webservice';
						
						$book_status = 'full';
						if($room_status && $rate_status){
							$book_status = 'available';
						}
						
						$pms_state[$web_room][$web_rate]['book_status'] = $book_status;
						$exprice [$web_room][] = $pms_state[$web_room][$web_rate]['avg_price'];
						
						$pms_state[$web_room][$web_rate]['least_num'] = $least_count;
						$valid_state[$web_room][$web_rate] = $pms_state[$web_room][$web_rate];
					}
				}
			}
		}
		
		return array(
			'pms_state'   => $pms_state,
			'valid_state' => $valid_state,
			'exprice'     => $exprice,
		);
	}
	
	function get_rooms_change_($startdate, $enddate, $rooms, $nums = null, $data_arr = array(), $price_code = '', $needimg = true){
		$countday = get_room_night($startdate,$enddate,'ceil');//至少有一个间夜
		$hotel = $this->readDB()->get_where('Hotels', array(
			'hotel_id' => $rooms[0]->hotel_id,
			'inter_id' => $rooms[0]->inter_id,
			'status'   => 0
		))->row_array();
		$nums_array = array();
		if(is_null($nums)){
			foreach($rooms as $r){
				$nums_array[$r->webser_id] = 1;
				if($data_arr[$r->room_id]){
					$nums_array[$r->webser_id] = $data_arr[$r->room_id];
				}
			}
		}
		if($hotel['webser_conn'] == 1 && $hotel['webser_id']){//判断酒店是否要连接到webservice
			$htlcd = $hotel['webser_id'];//webservice上的对应酒店代码
			$web_detail = $this->search_hotel_room_status($startdate, $enddate, $htlcd, $nums, $nums_array, $price_code);
		}
		foreach($rooms as $rm){
			// $odata=$this->readDB()->get_where('Hotels_rooms',array('hotel_id'=>$rm->hotel_id,'inter_id'=>$rm->inter_id,'room_id'=>$rm->room_id,'status'=>0))->row_array();
			if($needimg){
				$roomservice = array();
				$roomintro = array();
				$roomservice = $this->readDB()->get_where('hotel_images', array(
					'hotel_id' => $rm->hotel_id,
					'inter_id' => $rm->inter_id,
					'room_id'  => $rm->room_id,
					'type'     => 'hotel_room_service',
					'status'   => 1
				))->result();//取房型提供的服务的图标
				$this->readDB()->limit(1)->order_by('sort asc');
				$roomintro = $this->readDB()->get_where('hotel_images', array(
					'hotel_id' => $rm->hotel_id,
					'inter_id' => $rm->inter_id,
					'room_id'  => $rm->room_id,
					'type'     => 'hotel_room_lightbox',
					'status'   => 1
				))->row_array();//
				$rm->services = $roomservice;
				$rm->roomimg = $roomintro;
			}
			$rm->webps = $web_detail[$rm->webser_id];
		}
		return $rooms;
	}
	
	function create_soap($type){
		$time=time();
		$url='';
		$location='';
		switch($type){
			case 'hotel':
				$url= HOTEL_WSDL;
				$location= HOTEL_LOCATION;
				break;
			case 'order':
				$url= ORDER_WSDL;
				$location= ORDER_LOCATION;
				break;
			case 'crm':
				$url= CRM_WSDL;
				$location= CRM_LOCATION;
				break;
			case 'bill':
				$url= BILL_WSDL;
				$location= BILL_LOCATION;
				break;
		}
		$soap=null;
		
		try{
			$soap = new SoapClient($url, array(
				'location'     => $location,
				'soap_version' => SOAP_1_1,
				'encoding'     => 'utf-8'
			));
		}catch(SoapFault $e){
			$this->checkWebResult($url,'', [], $e, $time, microtime(),[],['run_alarm'=>1]);
		}catch(Exception $e){
			$this->checkWebResult($url,'', [], $e, $time, microtime(),[],['run_alarm'=>1]);
		}
		return $soap;
	}
	
	public function searchHotelById($hotel_web_id, $startdate, $enddate, $params = array(), $inter_id = ''){
		//清沐缓存
//		if($inter_id == 'a467894987' || $inter_id == 'a464919542'){
		
		if(!empty($params['recache'])){
			$recache = true;
		} else{
			$recache = false;
		}
		unset($params['recache']);
		
		if(!isset($params['only_physical'])){
			$params['only_physical'] = false;
		}
		
		if(!empty($params['member_levels'])){
			sort($params['member_levels']);
		}
		if(!empty($params['web_room_types'])){
			is_array($params['web_room_types']) or $params['web_room_types'] = array($params['web_room_types']);
			sort($params['web_room_types'], SORT_STRING);
		}
		ksort($params, SORT_STRING); //排序，为了匹配KEY值
		$key_str=$hotel_web_id.'|' . strtotime($startdate) . '|' . strtotime($enddate) . '|' . json_encode($params);
		$key = 'QM:normal:' . md5($key_str);
		
		$json = $this->redis_proxy->get($key);
		
		$list = json_decode($json, true);
		
		pms_logger(array($key_str, $key, func_get_args()), $json, __METHOD__ . '->redis', $inter_id);

//		}
		
		$startdate = date('Y-m-d', strtotime($startdate)) . 'T12:00:00.000';
		$enddate = date('Y-m-d', strtotime($enddate)) . 'T12:00:00.000';
		
		if($recache || $json === false || !is_array($list)){
			$list = [];
			$hotelSearchRequest = new HotelSearchRequest();
			if(!empty($params['only_physical'])){
				$hotelSearchRequest->PhysicalRoomTypeOnly = $params['only_physical'];
			}
			
			if(!empty($params['web_room_types'])){
				$hotelSearchRequest->RoomTypeIds = $params['web_room_types'];
			}
			$hotelSearchRequest->OnlyOpenedHotel = true;
			$hotelSearchRequest->HotelIds = array(doubleval($hotel_web_id));
			
			$hotelSearchRequest->HotelName = '';
			$hotelSearchRequest->CityId = '';
			$hotelSearchRequest->EndDate = $enddate;
			$hotelSearchRequest->BeginDate = $startdate;
			$hotelSearchRequest->PageSize = 10;
			$hotelSearchRequest->PageIndex = 1;
			
			if(!empty($params['member_levels'])){
				$hotelSearchRequest->MemberLevels = $params['member_levels'];
			}
			
			$signs = json_decode(json_encode($hotelSearchRequest), true);
			$signs['HotelIds'] = array($hotel_web_id);
			ksort($signs, SORT_STRING);
			$sign_paras = array('searchRequest' => $signs);
			$paras = array('searchRequest' => $hotelSearchRequest);
			$result = $this->sub_to_web('hotel', 'Search', $paras, $sign_paras);
			if($result->SearchResult->Success == 'true'){
				if(!empty($result->SearchResult->Content->HotelSearchResponse)){
					$info = $result->SearchResult->Content->HotelSearchResponse;
					if(is_object($info)){
						$info->HotelId = number_format($info->HotelId, 0, '', '');
						$list[$info->HotelId] = $info;
					} else{
						foreach($info as $i){
							$i->HotelId = number_format($i->HotelId, 0, '', '');
							$list[$i->HotelId] = $i;
						}
					}
					$list = obj2array($list);
				}
				
				if($inter_id == 'a467894987' || $inter_id == 'a464919542'){//清沐需要查询市场活动信息
					$this->redis_proxy->set($key, json_encode($list), 2400);    //将数据缓存
				}
			}
		}
		
		
		return $list;
	}
	
	function search_web_hotel($startdate, $enddate, $type = 'basic', $hotelid = null, $name = '', $city_id = '', $page_index = 1, $page_size = 10){
		$startdate = date('Y-m-d', strtotime($startdate)) . "T12:00:00.000";
		$enddate = date('Y-m-d', strtotime($enddate)) . "T12:00:00.000";
		$hotelSearchRequest = new HotelSearchRequest();
		switch($type){
			case 'basic':
				// $hotelSearchRequest->IncludeDetailCounts=false;
				$hotelSearchRequest->PhysicalRoomTypeOnly = true;
				$hotelSearchRequest->ExcludePrices = true;
				$hotelSearchRequest->BasicInfoOnly = true;
				// $hotelSearchRequest->ExcludeRoomCounts=false;
				$hotelSearchRequest->OnlyOpenedHotel = true;
				break;
			case 'detail':
				// $hotelSearchRequest->IncludeDetailCounts=true;
//				$hotelSearchRequest->PhysicalRoomTypeOnly = false;
				// $hotelSearchRequest->ExcludePrices=false;
				// $hotelSearchRequest->BasicInfoOnly=false;
				// $hotelSearchRequest->ExcludeRoomCounts=false;
				$hotelSearchRequest->OnlyOpenedHotel = true;
				break;
		}
		if($hotelid){
			$hotelSearchRequest->HotelIds = array(doubleval($hotelid));
		}
		$hotelSearchRequest->HotelName = $name;
		$hotelSearchRequest->CityId = $city_id;
		$hotelSearchRequest->EndDate = $enddate;
		$hotelSearchRequest->BeginDate = $startdate;
		$hotelSearchRequest->PageSize = $page_size;
		$hotelSearchRequest->PageIndex = $page_index;
		
		$signs = json_decode(json_encode($hotelSearchRequest), true);
		if($hotelid){
			$signs['HotelIds'] = array($hotelid);
		}
		ksort($signs, SORT_STRING);
		$sign_paras = array('searchRequest' => $signs);
		$paras = array('searchRequest' => $hotelSearchRequest);
		$result = $this->sub_to_web('hotel', "Search", $paras, $sign_paras);
		$data = array();
		if(!empty($result->SearchResult->Content) && $result->SearchResult->Success == 'true'){
			$info = $result->SearchResult->Content->HotelSearchResponse;
			if(is_object($info)){
				$info->HotelId = number_format($info->HotelId, 0, '', '');
				$data[$info->HotelId] = $info;
			} else{
				foreach($info as $i){
					$i->HotelId = number_format($i->HotelId, 0, '', '');
					$data[$i->HotelId] = $i;
				}
			}
		}
		return $data;
	}
	
	public function getHourPrice($hotel_web_id, $startdate, $level_lists = [], $inter_id = '', $recache = false){
//		$recache = true;
		$startdate = date('Y-m-d', strtotime($startdate)) . "T06:00:00.000";
		$enddate = date('Y-m-d', strtotime($startdate)) . "T22:00:00.000";
		
		sort($level_lists);
		$this->inter_id=$inter_id;
		
		//Redis缓存
		$key_str=$hotel_web_id . '|' . strtotime($startdate) . '|' . strtotime($enddate) . '|' . json_encode($level_lists);
		$key = 'QM:hour:' . md5($key_str);
		$json = $this->redis_proxy->get($key);
		$list = json_decode($json, true);
		
		pms_logger(array($key_str,$key, func_get_args()), $json, __METHOD__ . '->redis', $inter_id);
		
		if(!$recache && $json !== false && is_array($list)){
			return $list;
		}
		
		$list = [];
		
		$HourRentPriceRequest = new HourRentPriceRequest ();
		$HourRentPriceRequest->HotelId = floatval($hotel_web_id);//312049751867393;
		$HourRentPriceRequest->EstimatedArriveTime = $startdate;
		$HourRentPriceRequest->EstimatedDepartureTime = $enddate;
		$HourRentPriceRequest->MemberLevels = $level_lists;
		
		$paras = array('hourRentMemberPriceRequest' => $HourRentPriceRequest);
		$signs = json_decode(json_encode($paras), true);
		$signs['hourRentMemberPriceRequest']['HotelId'] = $hotel_web_id;
		ksort($signs, SORT_STRING);
//		$result = $this->sub_to_web('hotel', 'GetHourRentPrice', $paras, $signs);
		$result = $this->sub_to_web('hotel', 'GetHourRentMemberPrice', $paras, $signs);
		
		if(!empty($result->GetHourRentMemberPriceResult) && $result->GetHourRentMemberPriceResult->Success == 'true'){
			if(!empty($result->GetHourRentMemberPriceResult->Content->HourRentRoomPrice)){
				$list = obj2array($result->GetHourRentMemberPriceResult->Content->HourRentRoomPrice);
			}
			//记录缓存
			$this->redis_proxy->set($key, json_encode($list), 2400);
			
		}
		return $list;
	}
	
	public function getPromoPrice($hotel_web_id, $startdate, $enddate, $params = array(), $inter_id = ''){
		$openid = $params['openid'];
		
		if(!empty($params['recache'])){
			$recache = true;
		} else{
			$recache = false;
		}
		unset($params['openid'], $params['recache']);
		
		$list = [];
		
		if($openid){
			$this->load->model('api/Vmember_model', 'vm');
			//会员信息
			$member_info = $this->vm->getUserInfo($openid, $inter_id);
			/*$member_info = array(
				'pms_user_id'  => 107658425,
				'lvl_pms_code' => 'E会员',
			);*/
			if($member_info){
				$member_id = $member_info['pms_user_id'];
				//缓存
				
				sort($params['web_room_types'], SORT_STRING);
				ksort($params, SORT_STRING); //排序，为了匹配KEY值
				$key = "QM:promo:" . md5("$hotel_web_id|" . strtotime($startdate) . "|" . strtotime($enddate) . '|' . $member_info['lvl_pms_code'] . "|" . json_encode($params));
				//获取缓存数据
				$json = $this->redis_proxy->get($key);
				
				$list = json_decode($json, true);

//				pms_logger(array($key, func_get_args()), $list, __METHOD__ . '->redis', $inter_id);
				
				
				if($recache || $json === false || !is_array($list)){
					$list = [];
					
					//下单数据
					$OrderAddRequest = new OrderAddRequest();
					$OrderAddRequest->MemberId = $member_id;
					$OrderAddRequest->HotelId = doubleval($hotel_web_id);
					$OrderAddRequest->EstimatedArriveTime = date("Y-m-d", strtotime($startdate)) . 'T12:00:00.000';
					$OrderAddRequest->EstimatedDepartureTime = date("Y-m-d", strtotime($enddate)) . 'T12:00:00.000';
//					$OrderAddRequest->IsExtenalPrice = true;
					//房型数据
					$roomPlans = array();
					foreach($params['web_room_types'] as $v){
						$roomplan = new RoomPlan();
						$roomplan->RoomTypeId = $v;
						$roomplan->Price = array();
						$roomplan->Amount = 1;
						$roomPlans[] = $roomplan;
					}
					
					if(!empty($roomPlans)){
						$OrderAddRequest->RoomPlans = $roomPlans;
						$paras = array('orderAddRequest' => $OrderAddRequest);
						$signs = json_decode(json_encode($paras), true);
						$signs['orderAddRequest']['HotelId'] = $hotel_web_id;
						$res = $this->sub_to_web('order', 'GetAvailablePromotionPrices', $paras, $signs);
						if(!empty($res->GetAvailablePromotionPricesResult) && $res->GetAvailablePromotionPricesResult->Success == 'true'){
							if(!empty($result = obj2array($res->GetAvailablePromotionPricesResult->Content))){
								$list = $result['PromotionPolicyResponse'];
							}
							$this->redis_proxy->set($key, json_encode($list), 2400);
						}
						/*if($res->GetAvailablePromotionPricesResult->Success == 'true' && !empty($result = obj2array($res->GetAvailablePromotionPricesResult->Content))){
							$list = $result['PromotionPolicyResponse'];
							$this->redis_proxy->set($key, json_encode($list), 2400);
						}*/
					}
				}
			}
		}
		
		return $list;
	}
	
	/**
	 * 市场活动
	 * @param $hotel_web_id
	 * @param $startdate
	 * @param $enddate
	 * @return array|mixed
	 */
	public function getPromoActive($hotel_web_id, $startdate, $enddate, $inter_id = '', $recache = false){
//		InvokeResult<PromotionPolicyResponse[]> GetAvailablePromotionPrices(long orgId, DateTime beginTime, DateTime endTime, long unixExpireTimestamp, string signature);
		
		$startdate = date('Y-m-d', strtotime($startdate)) . "T06:00:00.000";
		$enddate = date('Y-m-d', strtotime($enddate)) . "T22:00:00.000";
		
		//Redis缓存
		$key = 'QM:promo:' . md5($hotel_web_id . '|' . strtotime($startdate) . '|' . strtotime($enddate));
		$json = $this->redis_proxy->get($key);
		$list = json_decode($json, true);
		is_array($list) or $list = [];

//		pms_logger(array($key, func_get_args()), $list, __METHOD__ . '->redis', $inter_id);
		
		if(!$recache && $json !== false && $json !== null){
			return $list;
		}
		
		$paras = array(
			'orgId'     => doubleval($hotel_web_id),
			'beginTime' => $startdate,
			'endTime'   => $enddate,
		);

//		$paras=array('orgId'=>191059230392321,'beginTime'=>'2016-08-20T06:00:00.000','endTime'=>'2016-08-30T22:00:00.000',);
		
		$signs = $paras;
		$signs['orgId'] = $hotel_web_id;
		$result = $this->sub_to_web('order', 'GetPromotionRemains', $paras, $signs);
		if(!empty($result->GetPromotionRemainsResult) && $result->GetPromotionRemainsResult->Success == 'true' && !empty($result->GetPromotionRemainsResult->Content)){
			$list = obj2array($result->GetPromotionRemainsResult->Content->PromotionPolicyResponse);
			//记录缓存
			$this->redis_proxy->set($key, json_encode($list), 2400);
			return $list;
		}
		return array();
	}
	
	function search_hotel_room_status($startdate, $enddate, $hotel_id, $nums = null, $nums_array, $price_code = ''){
		$result = $this->search_web_hotel($startdate, $enddate, 'detail', $hotel_id);
		$datas = array();
		if($result){
			$detail_price = $result[$hotel_id]->DetailPrices->RoomPrice;
			$room_counts = $result[$hotel_id]->RoomCounts->RoomCount;
			$countday = get_room_night($startdate,$enddate,'ceil');//至少有一个间夜
			foreach($detail_price as $dp){
				$datas[$dp->RoomTypeId]['prices'][$dp->Description]['details'][date('Ymd', strtotime($dp->Date))] = array(
					'price'     => $dp->ActualPrice,
					'ori_price' => $dp->OrignPrice
				);
				if($dp->Description == $price_code){
					$datas[$dp->RoomTypeId]['prices']['cmember']['details'][date('Ymd', strtotime($dp->Date))] = array(
						'price'     => $dp->ActualPrice,
						'ori_price' => $dp->OrignPrice
					);
				}
				$datas[$dp->RoomTypeId]['room_type'] = $dp->RoomTypeId;
			}
			foreach($room_counts as $rc){
				$tmp = array();
				for($n = 0; $n < $countday; $n++){
					$tmpdate = date("Ymd", strtotime("+" . $n . "day", strtotime($startdate)));//每次循环将开始日期加一天
					if(is_array($rc->DetailCounts->int)){
						$tmp[$tmpdate] = array('nums' => $rc->DetailCounts->int[$n]);
					} else{
						$tmp[$tmpdate] = array('nums' => $rc->DetailCounts->int);
					}
				}
				$datas[$rc->RoomTypeId]['counts'] = $tmp;
				$datas[$rc->RoomTypeId]['leftnums'] = $rc->Count;
				if(!is_null($nums)){
					if($rc->Count >= $nums){
						$datas[$rc->RoomTypeId]['state'] = 'available';
					} else{
						$datas[$rc->RoomTypeId]['state'] = 'none';
					}
				} else{
					if($rc->Count >= $nums_array[$rc->RoomTypeId]){
						$datas[$rc->RoomTypeId]['state'] = 'available';
					} else{
						$datas[$rc->RoomTypeId]['state'] = 'none';
					}
				}
				$datas[$rc->RoomTypeId]['room_info'] = array(
					'room_name' => $rc->RoomType->RoomTypeName,
					'room_abbr' => $rc->RoomType->Abbreviation,
					'desc'      => $rc->RoomType->Description,
					'bed_num'   => $rc->RoomType->BedAmount,
					'bed_type'  => $rc->RoomType->BedType
				);
			}
			foreach($datas as $k => $d){
				foreach($d['prices'] as $pk => $dp){
					$total = 0;
					foreach($dp['details'] as $dpd){
						$total += $dpd['price'];
					}
					$datas[$k]['prices'][$pk]['total'] = $total;
					$datas[$k]['prices'][$pk]['avgprice'] = $total / $countday;
				}
			}
		}
		return $datas;
	}
	
	function update_web_lowest($inter_id, $startdate, $enddate, $index = 1, $size = 10){
		$lows = $this->get_web_lowest($startdate, $enddate, $index, $size);
		$hotels = $this->readDB()->get_where('hotels', array('inter_id' => $inter_id, 'status' => 0))->result();
		$hto = array();
		foreach($hotels as $h){
			$hto[$h->webser_id] = $h->hotel_id;
		}
		var_dump($hto);
		var_dump($lows);
		$datas = array();
		$tmp['inter_id'] = $inter_id;
		$tmp['update_time'] = date('Y-m-d H:i:s');
		foreach($lows as $k => $v){
			if(!empty($hto[$k])){
				$tmp['hotel_id'] = $hto[$k];
				$tmp['lowest_price'] = $v;
				$this->db->replace('hotels_lowest_price', $tmp);
			}
		}
	}
	
	function get_web_lowest($startdate, $enddate, $index = 1, $size = 10){
		$result = $this->search_web_hotel($startdate, $enddate, 'detail', null, '', '', $index, $size);
		$lows = array();
		if($result){
			foreach($result as $r){
				$datas = array();
				if(!empty($r->LowestPrice->RoomPrice)){
					$lowest = $r->LowestPrice->RoomPrice;
					$countday = get_room_night($startdate,$enddate,'ceil');//至少有一个间夜
					foreach($lowest as $dp){
						$datas[$dp->Description][date('Ymd', strtotime($dp->Date))] = array(
							'price'     => $dp->ActualPrice,
							'ori_price' => $dp->OrignPrice
						);
					}
					$tmp = 999999;
					foreach($datas as $k => $d){
						foreach($d as $dpd){
							if($tmp >= $dpd['price']){
								$tmp = $dpd['price'];
							}
						}
					}
					$lows[$r->HotelId] = $tmp;
				} else{
					$lows[$r->HotelId] = 0;
				}
			}
		}
		return $lows;
	}
	
	function get_hotel_by_webid($hotelId = null){
		$paras = array('hotelIds' => $hotelId);
		$result = $this->sub_to_web('hotel', "GetHotelsByHotelIds", $paras);
		return $result;
	}
	
	function get_all_hotels($page_index = 1, $page_size = 100){
		$paras = array('pageIndex' => $page_index, 'pageSize' => $page_size);
		$result = $this->sub_to_web('hotel', "GetAllHotels", $paras);
		$data = array();
		if(!empty($result->GetAllHotelsResult->Content) && $result->GetAllHotelsResult->Success == 'true'){
			$info = $result->GetAllHotelsResult->Content->HotelSearchResponse;
			if(is_object($info)){
				$info->HotelId = number_format($info->HotelId, 0, '', '');
				$data[$info->HotelId] = $info;
			} else{
				foreach($info as $i){
					$i->HotelId = number_format($i->HotelId, 0, '', '');
					$data[$i->HotelId] = $i;
				}
			}
		}
		return $data;
	}
	
	function get_hotel_web_room_type($hotel_id){
		$paras = array('hotelId' => $hotel_id);
		$result = $this->sub_to_web('hotel', "GetHotelRoomTypes", $paras);
		$data = array();
		if(!empty($result->GetHotelRoomTypesResult->Content) && $result->GetHotelRoomTypesResult->Success == 'true'){
			$info = $result->GetHotelRoomTypesResult->Content->RoomType;
			if(is_object($info)){
				$data[$info->Id] = $info;
			} else{
				foreach($info as $i){
					$data[$i->Id] = $i;
				}
			}
		}
		return $data;
	}
	
	function set_order_room($orderid, $openid){
		$orderdetail = $this->get_order_details($openid, $orderid);
		foreach($orderdetail as $od){
			if(!empty($od['room_no']) && $od['room_occupy'] == 0){
				$paras = array('orderId' => floatval($od['webs_orderid']), 'hotelId' => floatval($od['hweb']));
				$paras['roomNumber'] = (string)$od['room_no'];
				$result = $this->sub_to_web('order', "SetOrderRoom", $paras);
				if($result->SetOrderRoomResult->Success == 'true' && $result->SetOrderRoomResult->Content == 'true'){
					$this->db->where(array('id' => $od['id'], 'orderid' => $orderid));
					$this->db->update('hotels_order_items', array('room_occupy' => 1));
				}
			}
		}
		return true;
	}
	
	function set_order_room_one($orderid, $openid){
		$orderdetail = $this->get_order_details($openid, $orderid);
		$paras = array(
			'orderId' => floatval($orderdetail[0]['web_orderid']),
			'hotelId' => floatval($orderdetail[0]['hweb'])
		);
		// $paras=array('orderId'=>332051442860036,'hotelId'=>318535823949838,'roomNumber'=>'8310');
		foreach($orderdetail as $od){
			if(!empty($od['room_no']) && $od['room_occupy'] == 0){
				$paras['roomNumber'] = (string)$od['room_no'];
				$result = $this->sub_to_web('order', "SetOrderRoom", $paras);
				if($result->SetOrderRoomResult->Success == 'true' && $result->SetOrderRoomResult->Content == 'true'){
					$this->db->where(array('id' => $od['id'], 'orderid' => $orderid));
					$this->db->update('hotels_order_items', array('room_occupy' => 1));
				}
			}
		}
	}
	
	/*
	SetOrderRoomByOccupationId(long orderId, long occupationId, long hotelId, string roomNumber, long unixExpireTimestamp, string signature);
	*/
	function set_web_order_room($orderid, $openid){
		if(empty($orderdetail)){
			$orderdetail = $this->get_order_details($openid, $orderid);
		}
		$count = 0;
		foreach($orderdetail as $od){
			if(!empty($od['room_no']) && $od['room_occupy'] == 0 && $od['webs_occupy_id']){
				$paras = array('orderId' => floatval($od['web_orderid']));
				$paras['occupationId'] = floatval($od['webs_occupy_id']);
				$paras['hotelId'] = floatval($od['hweb']);
				$paras['roomNumber'] = (string)$od['room_no'];
				$sign_paras = array('orderId' => $od['web_orderid']);
				$sign_paras['occupationId'] = $od['webs_occupy_id'];
				$sign_paras['hotelId'] = $od['hweb'];
				$sign_paras['roomNumber'] = (string)$od['room_no'];
				$result = $this->sub_to_web('order', "SetOrderRoomByOccupationId", $paras, $sign_paras);
				if($result->SetOrderRoomByOccupationIdResult->Success == 'true' && $result->SetOrderRoomByOccupationIdResult->Content == 'true'){
					$this->db->where(array('id' => $od['id'], 'orderid' => $orderid));
					$this->db->update('hotels_order_items', array('room_occupy' => 1));
					$count++;
				}
			}
		}
		return $count;
	}
	
	function check_order_room_($orderid, $openid){
		$orderdetail = $this->get_order_details($openid, $orderid);
		foreach($orderdetail as $od){
			if($od['room_occupy'] == 1){
				$occu = new OccupationSearchRequest();
				$occu->HotelId = floatval($od['hweb']);
				$occu->OrderId = floatval($od['webs_orderid']);
				$paras = array('occupationSearchRequest' => $occu);
				$signs = json_decode(json_encode($paras), true);
				$signs['occupationSearchRequest']['HotelId'] = $od['hweb'];
				$signs['occupationSearchRequest']['OrderId'] = $od['webs_orderid'];
				ksort($signs, SORT_STRING);
				$result = $this->sub_to_web('order', "SearchOccupation", $paras, $signs);
				if($result->SearchOccupationResult->Success == 'true' && !empty($result->SearchOccupationResult->Content->OccupationResponse)){
					$this->db->where(array('orderid' => $orderid, 'webs_orderid' => $od['webs_orderid'], 'id' => $od['id']));
					$this->db->update('hotels_order_items', array('webs_occupy_id' => number_format($result->SearchOccupationResult->Content->OccupationResponse->OccupationId, 0, '', '')));
				}
			}
		}
	}
	
	function update_web_room_occupy($orderid, $openid){
		$data = $this->check_order_room($orderid, $openid);
		if($data){
			foreach($data as $d){
				$this->db->limit(1);
				$this->db->where("(webs_occupy_id is null or webs_occupy_id ='')");
				$this->db->where(array('orderid' => $orderid, 'room_web_id' => $d->PriceRoomTypeId));
				$this->db->update('hotels_order_items', array('webs_occupy_id' => $d->OccupationId));
			}
			return true;
		}
		return false;
	}
	
	function check_order_room($orderid, $openid){
		$orderdetail = $this->get_order_details($openid, $orderid);
		$occu = new OccupationSearchRequest();
		$occu->HotelId = floatval($orderdetail[0]['hweb']);
		$occu->OrderId = floatval($orderdetail[0]['web_orderid']);
		$paras = array('occupationSearchRequest' => $occu);
		$signs = json_decode(json_encode($paras), true);
		$signs['occupationSearchRequest']['HotelId'] = $orderdetail[0]['hweb'];
		$signs['occupationSearchRequest']['OrderId'] = $orderdetail[0]['web_orderid'];
		ksort($signs, SORT_STRING);
		$result = $this->sub_to_web('order', "SearchOccupation", $paras, $signs);
		$data = array();
		if($result->SearchOccupationResult->Success == "true" && !empty($result->SearchOccupationResult->Content)){
			$info = $result->SearchOccupationResult->Content->OccupationResponse;
			if(is_object($info)){
				$info->OccupationId = number_format($info->OccupationId, 0, '', '');
				$info->OrderId = number_format($info->OrderId, 0, '', '');
				$data[$info->OccupationId] = $info;
			} else{
				foreach($info as $i){
					$i->OccupationId = number_format($i->OccupationId, 0, '', '');
					$i->OrderId = number_format($i->OrderId, 0, '', '');
					$data[$i->OccupationId] = $i;
				}
			}
		}
		return $data;
	}
	
	/*function add_web_bill($order){
		$order = $this->get_order_web_info($order['inter_id'], $order['orderid'], '', $order['openid']);
		$bill_req = new BillItemAddRequest();
		$bill_req->Amount = $order['price'] - floatval($order['wxpay_reduce']) - floatval($order['vouchertotal']);
		$bill_req->SubItemType = 'C9140';
		$bill_req->BillId = floatval($order['web_billid']);
		$bill_req->BillItemType = 'Credit';
		$bill_req->HotelId = floatval($order['hweb']);
		$bill_req->Memo = '';
		$paras = array('billItemAddRequest' => $bill_req);
		$signs = json_decode(json_encode($paras), TRUE);
		$signs['billItemAddRequest']['HotelId'] = $order['hweb'];
		$signs['billItemAddRequest']['BillId'] = $order['web_billid'];
		ksort($signs, SORT_STRING);
		$result = $this->sub_to_web('bill', "AddBillItem", $paras, $signs);
		if(!empty($result->AddBillItemResult->Content) && $result->AddBillItemResult->Success == 'true'){
			$this->db->where(array('inter_id' => $order['inter_id'], 'orderid' => $order['orderid']));
			$this->db->update('hotels_webser_order', array('web_paid' => 1));
			return TRUE;
		}
		return FALSE;
	}*/
	
	function add_web_bill_jiedai($order){
		exit;
		$order = $this->get_order_web_info($order['inter_id'], $order['orderid'], '', $order['openid']);
		$bill_req = new BillItemAddRequest();
		$bill_req->Amount = $order['price'] - floatval($order['wxpay_reduce']) - floatval($order['vouchertotal']);
		$bill_req->SubItemType = 'C9140';
		$bill_req->BillId = floatval('364516751049895');
		$bill_req->BillItemType = 'Credit';
		$bill_req->HotelId = floatval($order['hweb']);
		$bill_req->Memo = '';
		$paras = array('billItemAddRequest' => $bill_req);
		$signs = json_decode(json_encode($paras), true);
		$signs['billItemAddRequest']['HotelId'] = $order['hweb'];
		$signs['billItemAddRequest']['BillId'] = '364516751049895';
		ksort($signs, SORT_STRING);
		$result = $this->sub_to_web('bill', "AddBillItem", $paras, $signs);
		var_dump($result);
		if(!empty($result->AddBillItemResult->Content) && $result->AddBillItemResult->Success == 'true'){
			$this->db->where(array('inter_id' => $order['inter_id'], 'orderid' => $order['orderid']));
			$this->db->update('hotels_webser_order', array('web_paid' => 1));
			return true;
		}
		return false;
	}
	
	function add_web_voucher_bill($order){
		if(!empty($order['vouchertotal'])){
			$this->readDB()->where(array('inter_id' => $order['inter_id'], 'orderid' => $order['orderid']));
			$vc_check = $this->readDB()->get('hotels_webser_order')->row_array();
			if($vc_check['voucher_consume'] == 0){
				$bill_req = new BillItemAddRequest();
				$bill_req->Amount = intval($order['vouchertotal']);
				$bill_req->BillId = floatval($order['webs_billid']);
				$bill_req->BillItemType = 'Credit';
				$bill_req->HotelId = floatval($order['hweb']);
				$bill_req->Memo = '';
				$bill_req->SubItemType = 'C9200';
				$paras = array('billItemAddRequest' => $bill_req);
				$signs = json_decode(json_encode($paras), true);
				$signs['billItemAddRequest']['HotelId'] = $order['hweb'];
				$signs['billItemAddRequest']['BillId'] = $order['webs_billid'];
				// $signs['billItemAddRequest']['Amount']='30.0';
				ksort($signs, SORT_STRING);
				// var_dump($paras);
				// var_dump($signs);exit;
				$result = $this->sub_to_web('bill', "AddBillItem", $paras, $signs);
				if(!empty($result->AddBillItemResult->Content) && $result->AddBillItemResult->Success == 'true'){
					$this->db->where(array('inter_id' => $order['inter_id'], 'orderid' => $order['orderid']));
					$this->db->update('hotels_webser_order', array('voucher_consume' => 1));
					return true;
				}
			}
		}
		return false;
	}
	
	function add_web_voucher_bill_jiedai($order){
		$order = $this->get_order_web_info($order['inter_id'], $order['orderid'], '', $order['openid']);
		if(!empty($order['vouchertotal'])){
			$this->readDB()->where(array('inter_id' => $order['inter_id'], 'orderid' => $order['orderid']));
			$vc_check = $this->readDB()->get('hotels_webser_order')->row_array();
			if($vc_check['voucher_consume'] == 0){
				$bill_req = new BillItemAddRequest();
				$bill_req->Amount = intval($order['vouchertotal']);
				$bill_req->BillId = floatval('364657224106053');
				$bill_req->BillItemType = 'Credit';
				$bill_req->HotelId = floatval($order['hweb']);
				$bill_req->Memo = '';
				$bill_req->SubItemType = 'C9200';
				$paras = array('billItemAddRequest' => $bill_req);
				$signs = json_decode(json_encode($paras), true);
				$signs['billItemAddRequest']['HotelId'] = $order['hweb'];
				$signs['billItemAddRequest']['BillId'] = '364657224106053';
				// $signs['billItemAddRequest']['Amount']='30.0';
				ksort($signs, SORT_STRING);
				var_dump($paras);
				// var_dump($signs);exit;
				$result = $this->sub_to_web('bill', "AddBillItem", $paras, $signs);
				var_dump($result);
				// exit;
				if(!empty($result->AddBillItemResult->Content) && $result->AddBillItemResult->Success == 'true'){
					$this->db->where(array('inter_id' => $order['inter_id'], 'orderid' => $order['orderid']));
					$this->db->update('hotels_webser_order', array('voucher_consume' => 1));
					return true;
				}
			}
		}
		return false;
	}
	
	function add_web_order_bill($hotelid, $billid){
		$bill_req = new PartialPayOrderBillRequest();
		$bill_req->BillId = floatval($billid);
		$bill_req->HotelId = floatval($hotelid);
		$paras = array('partialPayOrderBillRequest' => $bill_req);
		$signs = json_decode(json_encode($paras), true);
		$signs['partialPayOrderBillRequest']['HotelId'] = $hotelid;
		$signs['partialPayOrderBillRequest']['BillId'] = $billid;
		ksort($signs, SORT_STRING);
		$result = $this->sub_to_web('bill', "PartialPayOrderBill", $paras, $signs);
		var_dump($result);
	}
	
	function check_web_order_bill($hotelid, $billid){
		$bill_req = new BillDetailRequest();
		$bill_req->BillId = floatval($billid);
		$bill_req->HotelId = floatval($hotelid);
		$paras = array('billDetailRequest' => $bill_req);
		$signs = json_decode(json_encode($paras), true);
		$signs['billDetailRequest']['HotelId'] = $hotelid;
		$signs['billDetailRequest']['BillId'] = $billid;
		ksort($signs, SORT_STRING);
		$result = $this->sub_to_web('bill', "GetBillDetails", $paras, $signs);
		return $result;
//		var_dump($result);
	}
	
	function order_submit_($orderid, $openid, $member_id = null, $member_name = ''){
		$orderdetail = $this->get_order_details($openid, $orderid);
		$order = $orderdetail[0];
		$OrderAddRequest = new OrderAddRequest();
		$OrderAddRequest->HotelId = floatval($order['hweb']);
		$OrderAddRequest->EstimatedArriveTime = date("Y-m-d", strtotime($order['startdate'])) . 'T' . '12:00:00.000';
		$OrderAddRequest->EstimatedDepartureTime = date("Y-m-d", strtotime($order['enddate'])) . 'T' . '12:00:00.000';
		$OrderAddRequest->Locked = false;
		$OrderAddRequest->IsExtenalPrice = true;
		$OrderAddRequest->ExternalPriceName = 'Wechat';
		// $OrderAddRequest->MemberId=$member_id;
		
		$guest1 = new Guest();
		$guest1->Name = $order['name'];
		$Guests[] = $guest1;
		$OrderAddRequest->Guests = $Guests;
		
		$liaison1 = new Liaison();
		$liaison1->Name = $order['name'];
		$liaison1->Mobile = $order['tel'];
		$Liaison[] = $liaison1;
		$OrderAddRequest->Liaisons = $Liaison;
		$dates = array();
		for($tmpdate = $order['startdate']; $tmpdate < $order['enddate'];){
			$dates[] = $tmpdate;
			$tmpdate = date('Ymd', strtotime('+ 1 day', strtotime($tmpdate)));
		}
		$addreqs = array();
		foreach($orderdetail as $r){
			$roomPlans = array();
			$all = explode('+', $r['allprice']);
			$ori = explode('+', $r['oriprice']);
			$RoomPrice = array();
			for($i = 0; $i < count($dates); $i++){
				$rprice = new RoomPrice();
				$rprice->Date = date('Y-m-d', strtotime($dates[$i])) . "T00:00:00";
				$rprice->OrignPrice = intval($ori[$i]);
				$rprice->ActualPrice = intval($all[$i]);
				$rprice->RoomTypeId = $r['room_web_id'];
				$RoomPrice[] = $rprice;
			}
			$roomplan = new RoomPlan();
			$roomplan->RoomTypeId = $r['room_web_id'];
			$roomplan->Amount = 1;
			$roomplan->Price = $RoomPrice;
			$roomPlans[] = $roomplan;
			$OrderAddRequest->RoomPlans = $roomPlans;
			$addreqs[$r['id']] = clone $OrderAddRequest;
		}
		
		// $itemrequest1=new OrderItemRequest();
		// $OrderItemRequest[]=$itemrequest1;
		// $OrderAddRequest->OrderItemRequests=$OrderItemRequest;
		// var_dump($addreqs);exit;
		foreach($addreqs as $k => $ar){
			$paras = array('orderAddRequest' => $ar);
			$signs = json_decode(json_encode($paras), true);
			$signs['orderAddRequest']['HotelId'] = $order['hweb'];
			ksort($signs, SORT_STRING);
			$result = $this->sub_to_web('order', "AddOrder", $paras, $signs);
			if($result->AddOrderResult->Success == 'true'){
				$this->db->where(array('orderid' => $orderid, 'id' => $k));
				$this->db->update('hotels_order_items', array(
					'webs_orderno' => $result->AddOrderResult->Content->OrderNo,
					'webs_orderid' => number_format($result->AddOrderResult->Content->OrderId, 0, '', ''),
					'webs_billid'  => number_format($result->AddOrderResult->Content->BillId, 0, '', '')
				));
			}
		}
		return true;
	}
	
	function order_submit($orderid, $openid, $member_id = null, $member_name = ''){
		$orderdetail = $this->get_order_details($openid, $orderid);
		$order = $orderdetail[0];
		$OrderAddRequest = new OrderAddRequest();
		$OrderAddRequest->HotelId = floatval($order['hweb']);
		$OrderAddRequest->EstimatedArriveTime = date("Y-m-d", strtotime($order['startdate'])) . 'T' . '12:00:00.000';
		$OrderAddRequest->EstimatedDepartureTime = date("Y-m-d", strtotime($order['enddate'])) . 'T' . '12:00:00.000';
		$OrderAddRequest->Locked = false;
		$OrderAddRequest->IsExtenalPrice = false;
		// $OrderAddRequest->ExternalPriceName='Wechat';
		if($member_id){
			$OrderAddRequest->MemberId = $member_id;
		}
		if($order['paytype'] == 1){
			$OrderAddRequest->PrePaymentTypeId = 'Full';
		}
		
		$guest1 = new Guest();
		$guest1->Name = $order['name'];
		$Guests[] = $guest1;
		$OrderAddRequest->Guests = $Guests;
		
		$liaison1 = new Liaison();
		$liaison1->Name = $order['name'];
		$liaison1->Mobile = $order['tel'];
		$Liaison[] = $liaison1;
		$OrderAddRequest->Liaisons = $Liaison;
		$dates = array();
		for($tmpdate = $order['startdate']; $tmpdate < $order['enddate'];){
			$dates[] = $tmpdate;
			$tmpdate = date('Ymd', strtotime('+ 1 day', strtotime($tmpdate)));
		}
		foreach($orderdetail as $r){
			$all = explode('+', $r['allprice']);
			$ori = explode('+', $r['oriprice']);
			$RoomPrice = array();
			for($i = 0; $i < count($dates); $i++){
				$rprice = new RoomPrice();
				$rprice->Date = date('Y-m-d', strtotime($dates[$i])) . "T00:00:00";
				$rprice->OrignPrice = intval($ori[$i]);
				$rprice->ActualPrice = intval($all[$i]);
				$rprice->RoomTypeId = $r['room_web_id'];
				$RoomPrice[] = $rprice;
			}
			$roomplan = new RoomPlan();
			$roomplan->RoomTypeId = $r['room_web_id'];
			$roomplan->Amount = 1;
			$roomplan->Price = $RoomPrice;
			$roomPlans[] = $roomplan;
		}
		$OrderAddRequest->RoomPlans = $roomPlans;
		
		if($order['voucherused'] == 1){
			$OrderAddRequest->PublicMemo = '使用' . $order['vouchertotal'] . '元代金券';
		}
		
		// $itemrequest1=new OrderItemRequest();
		// $OrderItemRequest[]=$itemrequest1;
		// $OrderAddRequest->OrderItemRequests=$OrderItemRequest;
		// var_dump($OrderAddRequest);exit;
		$paras = array('orderAddRequest' => $OrderAddRequest);
		$signs = json_decode(json_encode($paras), true);
		$signs['orderAddRequest']['HotelId'] = $order['hweb'];
		ksort($signs, SORT_STRING);
		$result = $this->sub_to_web('order', "AddOrder", $paras, $signs);
		if($result->AddOrderResult->Success == 'true' && !empty($result->AddOrderResult->Content)){
			$this->db->where(array('orderid' => $orderid, 'openid' => $openid));
			$this->db->update('hotels_order', array(
				'web_orderid' => number_format($result->AddOrderResult->Content->OrderId, 0, '', ''),
				'web_orderno' => $result->AddOrderResult->Content->OrderNo
			));
			$this->db->where(array('orderid' => $orderid, 'inter_id' => $order['inter_id']));
			$this->db->update('hotels_order_items', array('istatus' => 1, 'webs_status' => 1));
			$web_order = array(
				'inter_id'    => $order['inter_id'],
				'openid'      => $openid,
				'orderid'     => $orderid,
				'web_orderno' => $result->AddOrderResult->Content->OrderNo,
				'resvnum'     => number_format($result->AddOrderResult->Content->OrderId, 0, '', ''),
				'web_billid'  => number_format($result->AddOrderResult->Content->BillId, 0, '', ''),
				'htl_cd'      => number_format($result->AddOrderResult->Content->HotelId, 0, '', ''),
				'startdate'   => $order['startdate'],
				'enddate'     => $order['enddate'],
				'acctnm'      => $order['name'],
				'contact_tel' => $order['tel']
			);
			$this->db->insert('hotels_webser_order', $web_order);
			return true;
		}
		return false;
	}
	
	function get_order_details($openid, $orderid){
		$sql = "select h.webser_id hweb,h.name hname,h.net_open,h.hotel_id,a.startdate cstart,a.voucherused,a.vouchertotal,a.openid,a.enddate cend,a.name,a.tel,a.price total,a.roomnums,a.time,a.paid,a.paytype,a.web_orderno,a.web_orderid,a.status,a.handled,b.* from
		 (SELECT * FROM " . $this->readDB()->dbprefix('hotels_order') . " WHERE `openid` LIKE '$openid' AND `orderid` LIKE '$orderid') a
		  join " . $this->readDB()->dbprefix('hotels') . " h on a.inter_id=h.inter_id and a.hotel_id=h.hotel_id
		   join (SELECT * FROM " . $this->readDB()->dbprefix('hotels_order_items') . " WHERE `orderid` LIKE '$orderid') b on a.orderid=b.orderid and a.inter_id=b.inter_id";
		return $this->readDB()->query($sql)->result_array();
	}
	
	function get_order_details_by_id($openid, $oid, $member_no = ''){
		if(!empty($member_no)){
			$s = " member_no='$member_no'";
		} else{
			if(!empty($openid)){
				$s = " openid='$openid' and (member_no ='' or member_no is null)";
			}
		}
		$sql = "select h.webser_id hweb,h.name hname,h.net_open,h.hotel_id,a.voucherused,a.vouchertotal,a.startdate cstart,a.openid,a.enddate cend,a.name,a.tel,a.price total,a.roomnums,a.time,a.paid,a.paytype,a.web_orderno,a.web_orderid,a.status,a.handled,b.* from
		 (SELECT * FROM " . $this->readDB()->dbprefix('hotels_order') . " WHERE $s AND `id` = '$oid') a
		  join " . $this->readDB()->dbprefix('hotels') . " h on a.inter_id=h.inter_id and a.hotel_id=h.hotel_id
		   join " . $this->readDB()->dbprefix('hotels_order_items') . " b on a.orderid=b.orderid and a.inter_id=b.inter_id";
		return $this->readDB()->query($sql)->result_array();
	}
	
	function update_local_order_($orderid = '', $openid = '', $web_orderids = null, $hotelid){
		if(empty($web_orderids)){
			$details = $this->get_order_details($openid, $orderid);
			foreach($details as $d){
				if(!empty($d['webs_orderid']) && ($d['webs_status'] != 'NoShow') && ($d['webs_status'] != 'Cancel')){
					$web_orderids[] = $d['webs_orderid'];
				}
			}
		}
		$web_orders = $this->get_web_order_($web_orderids, $hotelid);
		foreach($web_orders as $wo){
			$this->db->where(array('orderid' => $orderid, 'webs_orderid' => number_format($wo->OrderId, 0, '', '')));
			$this->db->update('hotels_order_items', array('webs_status' => $wo->OrderStatus));
		}
		return true;
	}
	
	function update_local_order($orderid = '', $openid = '', $web_orderid = null, $hotelid){
		if(empty($web_orderid)){
			$details = $this->get_order_details($openid, $orderid);
			$web_orderid = $details[0]['web_orderid'];
		}
		$web_order = $this->get_web_order($web_orderid, $hotelid,$orderid);
		$this->load->model('common_model');
		$status_arr = $this->common_model->get_enum_des('web_local_order_status');
		$new_status = $status_arr[$web_order->OrderStatus];
		if($new_status == '5' && $details[0]['status'] == 4){
			$new_status = 4;
		} else{
			$this->db->where(array('orderid' => $orderid, 'web_orderid' => number_format($web_order->OrderId, 0, '', '')));
			$this->db->update('hotels_order', array('status' => $new_status));
		}
		return $new_status;
	}
	
	function get_web_order_($web_orderids, $hotelid){
		$data = array();
		foreach($web_orderids as $wo){
			$paras = array('orderId' => floatval($wo), 'hotelId' => floatval($hotelid));
			$result = $this->sub_to_web('order', "GetOrder", $paras);
			if($result->GetOrderResult->Success == 'true'){
				$data[] = $result->GetOrderResult->Content;
			}
		}
		return $data;
	}
	
	function get_web_order__($web_orderid, $hotelid){
		$paras = array('orderId' => floatval($web_orderid), 'hotelId' => floatval($hotelid));
		$result = $this->sub_to_web('order', "GetOrder", $paras);
		$data = array();
		if($result->GetOrderResult->Success == 'true'){
			$data = $result->GetOrderResult->Content;
		}
		return $data;
	}
	
	function get_web_able_room($hotelid, $room_web_id, $startdate, $enddate){
		$a_room = new SearchAvailiableRooms();
		$a_room->RoomTypeIds = explode(',', $room_web_id);
		$a_room->EstimatedArriveTime = date('Y-m-d', strtotime($startdate)) . "T12:00:00.000";
		$a_room->EstimatedDepartureTime = date('Y-m-d', strtotime($enddate)) . "T12:00:00.000";
		$a_room->HotelId = floatval($hotelid);
		
		$signs = json_decode(json_encode($a_room), true);
		$signs['HotelId'] = $hotelid;
		ksort($signs, SORT_STRING);
		$sign_paras = array('searchAvailiableRoomModel' => $signs);
		$paras = array('searchAvailiableRoomModel' => $a_room);
		$result = $this->sub_to_web('hotel', "SearchAvailiableRooms", $paras, $sign_paras);
		$data = array();
		if($result->SearchAvailiableRoomsResult->Success == 'true'){
			$a_room = $result->SearchAvailiableRoomsResult->Content->Room;
			if(is_array($a_room)){
				foreach($a_room as $d){
					$data[$d->RoomTypeId][] = $d;
				}
			} else{
				$data[$a_room->RoomTypeId][] = $a_room;
			}
		}
		return $data;
	}
	
	function add_web_room_in($inter_id, $orderid, $web_orderid, $hotel_id = '', $info){
		$web_order = $this->get_sub_order($inter_id, $orderid, $web_orderid, '', '', $hotel_id);
		return $this->web_room_in($web_order, $info);
	}
	
	function web_room_in($web_order, $info, $cardtype = 'C01'){
		$checkin = new CheckinRequest();
		$checkin->HotelId = floatval($web_order['hweb']);
		$checkin->OrderId = floatval($web_order['web_orderid']);
		$checkin->OccupationId = floatval($web_order['webs_occupy_id']);
		
		$customer = new CustomerRequest();
		$customer->CardNo = $info['idno'];
		$customer->CardTypeId = $cardtype;
		$customer->Mobile = $info['tel'];
		$customer->Name = $info['name'];
		
		$checkin->Customer = $customer;
		$signs = json_decode(json_encode($checkin), true);
		$signs['HotelId'] = $web_order['hweb'];
		$signs['OrderId'] = $web_order['web_orderid'];
		$signs['OccupationId'] = $web_order['webs_occupy_id'];
		ksort($signs, SORT_STRING);
		$sign_paras = array('checkinRequest' => $signs);
		$paras = array('checkinRequest' => $checkin);
		$result = $this->sub_to_web('order', "AddCheckin", $paras, $sign_paras);
		$data = array();
		if($result->AddCheckinResult->Success == 'true' && $result->AddCheckinResult->Content == 'true'){
			$this->db->where(array('id' => $web_order['id'], 'orderid' => $web_order['orderid']));
			$this->db->update('hotels_order_items', array('webs_status' => 'I', 'istatus' => 2));
			$data['s'] = 1;
		} else{
			$data['s'] = 0;
			$data['errmsg'] = '入住失败';
			$data['rtnmsg'] = $result->AddCheckinResult->ErrorMessage;
		}
		return $data;
	}
	
	function get_sub_order($inter_id, $orderid, $wid, $openid = '', $in_openid = '', $hotel_id = ''){
		$sql = "select b.*,h.webser_id hweb,h.hotel_id,a.web_orderid,a.openid from
		 (SELECT * FROM " . $this->readDB()->dbprefix('hotels_order') . " WHERE orderid='$orderid' and inter_id='$inter_id'";
		if($openid){
			$sql .= " and openid='$openid'";
		}
		if($hotel_id){
			$sql .= " and hotel_id=$hotel_id";
		}
		$sql .= ") a
		  join (SELECT * FROM " . $this->readDB()->dbprefix('hotels_order_items') . " WHERE orderid='$orderid' and inter_id='$inter_id' and id=$wid ";
		if($in_openid){
			$sql .= " and in_openid='$in_openid'";
		}
		$sql .= ") b on a.orderid=b.orderid and a.inter_id=b.inter_id join " . $this->readDB()->dbprefix('hotels') . " h on h.hotel_id=a.hotel_id and h.inter_id=a.inter_id";
		return $this->readDB()->query($sql)->row_array();
	}
	
	function get_order($inter_id, $orderid, $hotel_id, $openid){
		$sql = "select h.webser_id hweb,a.* from
		 (SELECT * FROM " . $this->readDB()->dbprefix('hotels_order') . " WHERE orderid='$orderid' and inter_id='$inter_id'";
		if($openid){
			$sql .= " and openid='$openid'";
		}
		$sql .= ") a join " . $this->readDB()->dbprefix('hotels') . " h on h.hotel_id=a.hotel_id and h.inter_id=a.inter_id";
		if($hotel_id){
			$sql .= " where h.hotel_id = $hotel_id";
		}
		return $this->readDB()->query($sql)->row_array();
	}
	
	function get_order_web_info($inter_id, $orderid, $hotel_id, $openid){
		$sql = "select h.webser_id hweb,a.*,b.web_billid from
		 (SELECT * FROM " . $this->readDB()->dbprefix('hotels_order') . " WHERE orderid='$orderid' and inter_id='$inter_id'";
		if($openid){
			$sql .= " and openid='$openid'";
		}
		$sql .= ") a join (SELECT * FROM " . $this->readDB()->dbprefix('hotels_webser_order') . " WHERE orderid='$orderid' and inter_id='$inter_id') b
		 on a.orderid=b.orderid and a.inter_id=b.inter_id
 		 join " . $this->readDB()->dbprefix('hotels') . " h on h.hotel_id=a.hotel_id and h.inter_id=a.inter_id";
		if($hotel_id){
			$sql .= " where h.hotel_id = $hotel_id";
		}
		return $this->readDB()->query($sql)->row_array();
	}
	
	function cancel_web_order_($inter_id, $orderid, $web_orderid, $openid = '', $reason = ''){
		$web_order = $this->get_sub_order($inter_id, $orderid, $web_orderid, $openid);
		$data = array();
		if(!empty($web_order)){
			$cancel = new OrderCancelRequest();
			$cancel->HotelId = floatval($web_order['hweb']);
			$cancel->OrderId = floatval($web_orderid);
			$cancel->Reason = $reason;
			
			$signs = json_decode(json_encode($cancel), true);
			$signs['HotelId'] = $web_order['hweb'];
			$signs['OrderId'] = $web_orderid;
			ksort($signs, SORT_STRING);
			$sign_paras = array('orderCancelRequest' => $signs);
			$paras = array('orderCancelRequest' => $cancel);
			$result = $this->sub_to_web('order', "CancelOrder", $paras, $sign_paras);
			if($result->CancelOrderResult->Success == 'true'){
				$data['s'] = 1;
				$data['msg'] = '已取消';
			} else{
				$data['s'] = 0;
				$data['msg'] = '取消失败！';
			}
		} else{
			$data['s'] = 0;
			$data['msg'] = '取消失败！';
		}
		return $data;
	}
	
	function cancel_web_order($inter_id, $orderid, $openid = '', $hotel_id = '', $reason = ''){
		$web_order = $this->get_order($inter_id, $orderid, $hotel_id, $openid);
		$data = array();
		if(!empty($web_order) && $web_order['status'] == 1 && $web_order['paid'] != 1){
			$cancel = new OrderCancelRequest();
			$cancel->HotelId = floatval($web_order['hweb']);
			$cancel->OrderId = floatval($web_order['web_orderid']);
			$cancel->Reason = $reason;
			
			$signs = json_decode(json_encode($cancel), true);
			$signs['HotelId'] = $web_order['hweb'];
			$signs['OrderId'] = $web_order['web_orderid'];
			ksort($signs, SORT_STRING);
			$sign_paras = array('orderCancelRequest' => $signs);
			$paras = array('orderCancelRequest' => $cancel);
			$result = $this->sub_to_web('order', "CancelOrder", $paras, $sign_paras);
			if($result->CancelOrderResult->Success == 'true'){
				$data['s'] = 1;
				$data['msg'] = '已取消';
				$this->db->where(array('inter_id' => $inter_id, 'orderid' => $orderid));
				if($openid){
					$this->db->where('openid', $openid);
				}
				if($hotel_id){
					$this->db->where('hotel_id', $hotel_id);
					$this->db->update('hotel_orders', array('status' => 5));
				} else{
					$this->db->update('hotel_orders', array('status' => 4));
				}
			} else{
				$data['s'] = 0;
				$data['msg'] = '取消失败！';
			}
		} else{
			$data['s'] = 0;
			$data['msg'] = '取消失败！';
		}
		return $data;
	}
	
	
	function cancel_web_order_one($inter_id, $orderid, $openid = '', $reason = ''){
		$orderdetail = $this->get_order_details($openid, $orderid);
		$data = array();
		foreach($orderdetail as $o){
			if(!empty($o['webs_orderid'] && $o['webs_status'] == 'InProgress')){
				$cancel = new OrderCancelRequest();
				$cancel->HotelId = floatval($o['hweb']);
				$cancel->OrderId = floatval($o['webs_orderid']);
				$cancel->Reason = $reason;
				
				$signs = json_decode(json_encode($cancel), true);
				$signs['HotelId'] = $o['hweb'];
				$signs['OrderId'] = $o['webs_orderid'];
				ksort($signs, SORT_STRING);
				$sign_paras = array('orderCancelRequest' => $signs);
				$paras = array('orderCancelRequest' => $cancel);
				$result = $this->sub_to_web('order', "CancelOrder", $paras, $sign_paras);
				if($result->CancelOrderResult->Success == 'true'){
					$data['s'] = 1;
					$data['msg'] = '已取消';
				} else{
					$data['s'] = 0;
					$data['msg'] = '取消失败！';
				}
			} else{
				$data['s'] = 0;
				$data['msg'] = '取消失败！';
			}
		}
		return $data;
	}
	
	function add_web_member($inter_id, $md){
		
		$this->readDB()->order_by('id desc');
		$this->readDB()->limit(1);
		$check = $this->readDB()->get_where('short_msg_record', array(
			'inter_id' => $inter_id,
			'tel'      => $md['tel'],
			'type'     => 'send_reg_message',
			'status'   => 1
		))->row_array();
		if(empty($check) || $check['key_data'] != $md['code']){
			$data = array('s' => 0, 'errmsg' => '验证码错误');
		} else{
			$MemberAddRequest = new MemberAddRequest();
			$MemberAddRequest->Name = $md['name'];
			$MemberAddRequest->Gender = $md['sex'];
			$MemberAddRequest->Mobile = $md['tel'];
			$MemberAddRequest->Email = $md['email'];
			$MemberAddRequest->IDType = 'C01';
			$MemberAddRequest->IDNo = $md['idno'];
			$MemberAddRequest->SourceType = 'A';
			$MemberAddRequest->SourceChannel = 'J';
			$MemberAddRequest->Level = 'L3';
			$MemberAddRequest->StatusCode = 'I';
			$MemberAddRequest->Password = $md['pwd'];
			$MemberAddRequest->CreateBy = '';
			$MemberAddRequest->CreateTime = date('Y-m-d') . 'T' . date('H:i:s');
			
			$signs = json_decode(json_encode($MemberAddRequest), true);
			ksort($signs, SORT_STRING);
			$sign_paras = array('memberAddModel' => $signs);
			$paras = array('memberAddModel' => $MemberAddRequest);
			$result = $this->sub_to_web('crm', "AddMember", $paras, $sign_paras);
			if($result->AddMemberResult->Success == 'true' && !empty($result->AddMemberResult->Content)){
				$data = array('s' => 1, 'data' => $result->AddMemberResult->Content);
				$this->db->where(array('id' => $check['id']));
				$this->db->update('short_msg_record', array('status' => 2));
			} else{
				$data = array('s' => 0, 'errmsg' => $result->AddMemberResult->Code);
			}
		}
		return $data;
	}
	
	function web_member_login($tel, $pwd){
		$paras = array('mobile' => $tel, 'password' => $pwd);
		$result = $this->sub_to_web('crm', "Login", $paras);
		$data = array();
		if($result->LoginResult->Success == 'true'){
			$data['s'] = 1;
			$data['data'] = $result->LoginResult->Content;
		} else{
			$data['s'] = 0;
			$data['errmsg'] = $result->LoginResult->ErrorMessage;
		}
		return $data;
	}
	
	function member_login_web($inter_id, $openid, $tel, $pwd){
		$result = $this->web_member_login($tel, $pwd);
		if($result['s'] == 1){
			$check = $this->get_web_member($inter_id, $result['data']->MemberId);
			$this->load->model('common_model');
			$enum_des = $this->common_model->get_enum_des(array('web_member_level', 'gender'));
			$info = array(
				'member_name'   => $result['data']->Name,
				'tel'           => $result['data']->Mobile,
				'email'         => $result['data']->Email,
				'level'         => $result['data']->MemberLevel,
				'id_card'       => $result['data']->IDNO,
				'address'       => $result['data']->Address,
				'point'         => $result['data']->Point,
				'pre_value'     => $result['data']->Value,
				'password'      => $pwd,
				'sex'           => $enum_des['gender'][$result['data']->Gender],
				'level_name'    => $enum_des['web_member_level'][$result['data']->MemberLevel],
				'last_ip'       => $_SERVER['REMOTE_ADDR'],
				'last_log_time' => date('Y-m-d H:i:s'),
				'last_openid'   => $openid
			);
			if($check){
				$info['login_status'] = 1;
				$this->db->where(array('inter_id' => $inter_id, 'member_no' => $check['member_no'], 'id' => $check['id']));
				$this->db->update('web_members', $info);
			} else{
				$info['openid'] = $openid;
				$info['inter_id'] = $inter_id;
				$info['member_no'] = $result['data']->MemberId;
				$info['reg_time'] = date('Y-m-d H:i:s');
				$info['reg_ip'] = $_SERVER['REMOTE_ADDR'];
				$this->db->insert('web_members', $info);
			}
			$result = array(
				's'           => 1,
				'member_no'   => $result['data']->MemberId,
				'member_type' => $enum_des['web_member_level'][$result['data']->MemberLevel]
			);
		} else{
			$result = array('s' => 0, 'errmsg' => $result['errmsg']);
		}
		return $result;
	}
	
	function get_web_member($inter_id, $member_no, $shield = true){
		$this->readDB()->where(array('inter_id' => $inter_id, 'member_no' => $member_no));
		$check = $this->readDB()->get('web_members')->row_array();
		if($check && $shield){
			$check['tel'] = substr_replace($check['tel'], '****', 4, 4);
			$check['id_card'] = substr_replace($check['id_card'], '********', 4, 8);
		}
		return $check;
	}
	
	function update_web_checkin($orderid, $openid, $orderdetail = null){
		if(empty($orderdetail)){
			$orderdetail = $this->get_order_details($openid, $orderid);
		}
		$occupy_ids = array();
		$occupy_ids_sign = array();
		$netopens = array();
		foreach($orderdetail as $od){
			if(!empty($od['webs_occupy_id'])){
				$occupy_ids[] = floatval($od['webs_occupy_id']);
				$occupy_ids_sign[] = $od['webs_occupy_id'];
			}
			$netopens[$od['webs_occupy_id']] = $od['net_open_door'];
			// if(!empty($od['webs_checkin_id'])){
			// $checkin_ids[]=floatval($od['webs_checkin_id']);
			// $checkin_ids_sign[]=$od['webs_checkin_id'];
			// }
		}
		if(!empty($occupy_ids)){
			$data = $this->get_web_checkin($orderdetail[0]['hweb'], $occupy_ids, $occupy_ids_sign);
			if($data){
				$this->load->model('common_model');
				$webstatus = $this->common_model->get_enum_des('web_local_order_in_status');
				foreach($data as $d){
					$this->db->where(array('orderid' => $orderid, 'webs_occupy_id' => $d->OccupationId));
					$updata = array(
						'webs_status'     => $d->CheckinStatus,
						'room_occupy'     => 1,
						'room_no'         => $d->RoomNumber,
						'webs_checkin_id' => $d->CheckinId,
						'webs_orderno'    => $d->CheckinNo,
						'webs_billid'     => $d->BillId,
						'istatus'         => $webstatus[$d->CheckinStatus]
					);
					if($orderdetail[0]['net_open'] == 1 && is_null($netopens[$d->OccupationId])){
						$updata['net_open_door'] = 1;
					}
					$this->db->update('hotels_order_items', $updata);
				}
			}
		}
	}
	
	function get_web_checkin($hotelid, $occupy_ids, $occupy_ids_sign){
		$cki_req = new CheckinSearchRequest();
		$data = array();
		$cki_req->HotelId = floatval($hotelid);
		$cki_req->OccupationIds = $occupy_ids;
		// $cki_req->CheckinIds=$checkin_ids;
		$signs = json_decode(json_encode($cki_req), true);
		ksort($signs, SORT_STRING);
		$signs['HotelId'] = $hotelid;
		$signs['OccupationIds'] = $occupy_ids_sign;
		// $signs['CheckinIds']=$checkin_ids_sign;
		$sign_paras = array('checkinSearchRequest' => $signs);
		$paras = array('checkinSearchRequest' => $cki_req);
		$result = $this->sub_to_web('order', "SearchCheckin", $paras, $sign_paras);
		if($result->SearchCheckinResult->Success == 'true' && !empty($result->SearchCheckinResult->Content->CheckinResponse)){
			$info = $result->SearchCheckinResult->Content->CheckinResponse;
			if(is_object($info)){
				$info->BillId = number_format($info->BillId, 0, '', '');
				$info->CheckinId = number_format($info->CheckinId, 0, '', '');
				$info->OccupationId = number_format($info->OccupationId, 0, '', '');
				$info->OrderId = number_format($info->OrderId, 0, '', '');
				$info->OrgId = number_format($info->OrgId, 0, '', '');
				$data[$info->OccupationId] = $info;
			} else{
				foreach($info as $i){
					$i->BillId = number_format($i->BillId, 0, '', '');
					$i->CheckinId = number_format($i->CheckinId, 0, '', '');
					$i->OccupationId = number_format($i->OccupationId, 0, '', '');
					$i->OrderId = number_format($i->OrderId, 0, '', '');
					$i->OrgId = number_format($i->OrgId, 0, '', '');
					$data[$i->OccupationId] = $i;
				}
			}
		}
		return $data;
	}
	
	function open_net_room($hotelid, $checkin_id){
		$open_req = new CheckinNetDoorOpenRequest();
		$open_req->HotelId = floatval($hotelid);
		$open_req->CheckinId = floatval($checkin_id);
		$signs = json_decode(json_encode($open_req), true);
		ksort($signs, SORT_STRING);
		$signs['HotelId'] = $hotelid;
		$signs['CheckinId'] = $checkin_id;
		$sign_paras = array('checkinNetDoorOpenRequest' => $signs);
		$paras = array('checkinNetDoorOpenRequest' => $open_req);
		$result = $this->sub_to_web('order', "OpenCheckinNetDoor", $paras, $sign_paras);
		if($result->OpenCheckinNetDoorResult->Success == 'true' && $result->OpenCheckinNetDoorResult->Content == 'true'){
			return true;
		}
		return false;
	}
	
	function open_net_room_yy($hotel_id, $room_no){
		$this->load->model('common_model');
		// return array('s'=>1);
		$key = 'dad@!a';
		$h_lock = $this->common_model->get_enum_des('hotel_lock_product_id');
		if($h_lock[$hotel_id]){
			$url = 'http://api.yeeuu.com/v1/prop/' . $h_lock[$hotel_id] . '/room/' . $room_no . '?key=' . $key . '&action=open';
			// $url='http://api.yeeuu.com/v1/prop/5593b541766d314d98000001/room/101?key=dad@!a&action=open';
			$this->load->helper('common');
			$s = json_decode(doCurlGetRequest($url), true);
			$this->db->insert('weixin_text', array(
				'content'   => json_encode($s) . '--hotel_' . $hotel_id . '--room_no_' . $room_no . '--url_' . $url . '--openlock',
				'edit_date' => date('Y-m-d H:i:s')
			));
			if($s['success'] == true){
				return array('s' => 1);
			} else{
				return array('s' => 0);
			}
		} else{
			return array('s' => 0);
		}
	}
	
	function get_my_order($inter_id, $openid = '', $member_no = ''){
		if(!empty($member_no)){
			$s = " member_no='$member_no'";
		} else{
			if(!empty($openid)){
				$s = " openid='$openid' and (member_no ='' or member_no is null)";
			}
		}
		$sql = "select o.*,h.name hotelname,h.intro_img from
		(select * from " . $this->readDB()->dbprefix("hotels_order") . " where inter_id='$inter_id' and isdel=0 and web_orderid !='' and web_orderid is not null and $s) o
		 join " . $this->readDB()->dbprefix("hotels") . " h on o.hotel_id = h.hotel_id and o.inter_id = h.inter_id order by o.id desc";
		$result = $this->readDB()->query($sql)->result();
		return $result;
	}
	
	function get_lock_web_order($inter_id, $openid, $in_openid, $orderid, $webs_id, $type = 'share'){
		if(intval($webs_id)){
			if($orderid != '68144608545144143'){
				$this->update_web_checkin($orderid, $openid);
			}
			// echo $inter_id.','.$openid.','.$in_openid.','.$orderid.','.$webs_id;
			if($type == 'open' || $type == 'fs'){
				$web_order = $this->get_sub_order($inter_id, $orderid, $webs_id, $openid);
			} else{
				if($type == 'share'){
					$web_order = $this->get_sub_order($inter_id, $orderid, $webs_id, '', $in_openid);
				}
			}
			if($web_order['webs_status'] == 'I' && $web_order['net_open_door'] == 1 && $web_order['startdate'] <= date('Ymd') && $web_order['enddate'] >= date('Ymd')){
				
				if(empty($web_order['in_openid'])){
					if($type == 'share' || $type == 'fs'){
						if($web_order['openid'] == $in_openid){
							return array('s' => 1, 'web_order' => $web_order, 'own' => 1);
						} else{
							return array('s' => 0, 'web_order' => $web_order);
						}
					} else{
						if($type == 'open'){
							return array('s' => 0, 'errdes' => '房间未分配，无法开锁');
						}
					}
				} else{
					if($web_order['in_openid'] == $in_openid){
						$info = array('s' => 1, 'web_order' => $web_order);
						return $info;
					} else{
						return array('s' => 0);
					}
				}
				
				// if($type=='share'){
				// if($web_order['in_openid']==$in_openid)
				// return array('s'=>1,'web_order'=>$web_order);
				// else
				// return array('s'=>0,'web_order'=>$web_order);
				// }
				// else if($type=='open'){
				// if($web_order['openid']==$openid&&empty($web_order['in_openid']))
				// return array('s'=>1,'web_order'=>$web_order);
				// else
				// return array('s'=>0,'web_order'=>$web_order);
				// }
			} else{
				return array('s' => 0);
			}
		}
		return array('s' => 0);
	}
	
	function open_share_lock($inter_id, $orderid, $webs_id){
		$code = mt_rand(10000, 99999);
		$this->db->where(array('inter_id' => $inter_id, 'orderid' => $orderid, 'id' => $webs_id));
		if($this->db->update('hotels_order_items', array('share_lock' => 2, 'share_lock_pwd' => $code))){
			return array('s' => 1, 'code' => $code);
		} else{
			return array('s' => 0, 'errmsg' => '分配失败');
		}
	}
	
	function get_share_lock($inter_id, $orderid, $webs_id){
		$web_order = $this->get_sub_order($inter_id, $orderid, $webs_id);
		if(!empty($web_order)){
			$info = array('s' => 0);
			if($web_order['share_lock'] == 2){
				if(($web_order['webs_status'] == 'I' && $web_order['net_open_door'] == 1 && $web_order['startdate'] <= date('Ymd') && $web_order['enddate'] >= date('Ymd')) || $orderid == 'aE144591960725040'){
					$info['s'] = 1;
					$info['errmsg'] = 'on_share';
					$info['data'] = $web_order;
				} else{
					$info['errmsg'] = 'out_of_date';
					$info['errdes'] = '订单已不能分享';
				}
			} else{
				if($web_order['share_lock'] == 3){
					$info['errmsg'] = 'already_got';
					$info['data'] = $web_order;
					$info['errdes'] = '来晚了，已被别人领取啦';
				} else{
					$info['errmsg'] = 'no_share';
					$info['errdes'] = '订单未分享';
				}
			}
		} else{
			$info['errmsg'] = 'no_order';
			$info['errdes'] = '订单错误';
		}
		return $info;
	}
	
	function update_share_lock($inter_id, $openid, $orderid, $webs_id){
		$this->db->where(array('inter_id' => $inter_id, 'orderid' => $orderid, 'id' => $webs_id));
		return $this->db->update('hotels_order_items', array('in_openid' => $openid, 'share_lock' => 3));
	}
	
	function update_web_pwd_phone($tel, $new_pwd){
		$paras = array('mobile' => $tel, 'newPassword' => $new_pwd);
		$result = $this->sub_to_web('crm', "UpdatePasswordUsedMobile", $paras);
		if($result->UpdatePasswordUsedMobileResult->Content == 'true' && $result->UpdatePasswordUsedMobileResult->Success == 'true'){
			return array('s' => 1, 'errmsg' => '修改成功');
		} else{
			return array('s' => 0, 'errmsg' => $result->UpdatePasswordUsedMobileResult->ErrorMessage);
		}
	}
	
	function get_room_no_detail($hotelid){
		$paras = array(
			'utcTimestamp' => 0,
			'hotelId'      => floatval($hotelid),
			'pageIndex'    => 1,
			'pageSize'     => 100,
			'roomStatus'   => '',
			'hallId'       => '',
			'floorId'      => ''
		);
		$result = $this->sub_to_web('hotel', "GetRooms", $paras);
		var_dump($result);
	}
	
	function sub_to_web($soap_type, $fun_name, $paras, $sign_paras = null, $expire_time = 0,$func_data=[]){
		$time=time();
		$inter_id = $this->inter_id;
		
		switch($soap_type){
			case 'hotel':
				$url= HOTEL_WSDL;
				break;
			case 'order':
				$url= ORDER_WSDL;
				break;
			case 'crm':
				$url= CRM_WSDL;
				break;
			case 'bill':
				$url= BILL_WSDL;
				break;
			default:
				$url='';
				break;
		}
		
		$this->load->model('common/Webservice_model');
		
		$soap = $this->create_soap($soap_type);
		if(!$expire_time){
			$expire_time = $this->create_expire_time();
		}
		if(empty($sign_paras)){
			$sign_paras = $paras;
		}
		$signature = $this->beyondh_sign($sign_paras, $expire_time);
		$paras['unixExpireTimestamp'] = $expire_time;
		$paras['signature'] = $signature;
		$this->db->insert('weixin_text', array(
			'content'   => json_encode($paras) . '--to',
			'edit_date' => date('Y-m-d H:i:s')
		));
		$sign_paras['unixExpireTimestamp'] = $expire_time;
		$sign_paras['signature'] = $signature;
		$result=null;
		$s=null;
		$run_alarm = 0;
		if($soap!==null){
			try{
				$s = $soap->__soapCall($fun_name, array("parameters" => $paras));
				
				$this->Webservice_model->add_webservice_record($inter_id, 'beyondh', $url, [
					$fun_name,
					$sign_paras
				], $s, 'query_post', $time, microtime(), $this->session->userdata($inter_id . 'openid'));
				
				$result = $s;
			}catch(SoapFault $e){
				$s = $e;
				$run_alarm = 1;
			}catch(Exception $e){
				$s = $e;
				$run_alarm = 1;
			}
			
			$this->checkWebResult($url,$fun_name, $sign_paras, $s, $time, microtime(), $func_data, ['run_alarm' => $run_alarm]);
		}
		return $result;
	}
	
	protected function checkWebResult($url,$func_name, $send, $receive, $now, $micro_time,$func_data=[], $params = []){
		$func_name_des = $this->pms_enum('func_name', $func_name);
		isset ($func_name_des) or $func_name_des = $func_name; // 方法名描述\
		$err_msg = ''; // 错误提示信息
		$err_lv = NULL; // 错误级别，1报警，2警告
		$alarm_wait_time = 5; // 默认超时时间
		if(!empty($params['run_alarm'])){ // 程序运行报错，直接报警
			$err_msg = '程序报错,' . json_encode($receive, JSON_UNESCAPED_UNICODE);
			$err_lv = 1;
		}else{
			switch($func_name){ // 针对不同方法判断是否出错
				case 'Search':
					if($receive->SearchResult->Success!='true'||empty($receive->SearchResult->Content->HotelSearchResponse)){
						$err_msg='没有返回数据：'.(isset($receive->SearchResult->ErrorMessage)?$receive->SearchResult->ErrorMessage:'');
						$err_lv=2;
					}
					break;
				case 'GetHourRentMemberPrice':
					if($receive->GetHourRentMemberPriceResult->Success!='true'||empty($receive->GetHourRentMemberPriceResult->Content->HourRentRoomPrice)){
						$err_msg='没有返回数据：'.(isset($receive->GetHourRentMemberPriceResult->ErrorMessage)?$receive->GetHourRentMemberPriceResult->ErrorMessage:'');
						$err_lv=2;
					}
					break;
				case 'GetAvailablePromotionPrices':
					if($receive->GetAvailablePromotionPricesResult->Success!='true'||empty($receive->GetAvailablePromotionPricesResult->Content)){
						$err_msg='没有返回数据：'.(isset($receive->GetAvailablePromotionPricesResult->ErrorMessage)?$receive->GetAvailablePromotionPricesResult->ErrorMessage:'');
						$err_lv=2;
					}
					break;
				case 'AddOrder':
					if($receive->AddOrderResult->Success!='true'||empty($receive->AddOrderResult->Content)){
						$err_msg='接口错误：'.(isset($receive->AddOrderResult->ErrorMessage)?$receive->AddOrderResult->ErrorMessage:'');
						$err_lv=1;
					}
					break;
				case 'GetOrder':
					if($receive->GetOrderResult->Success!='true'){
						$err_msg='没有返回数据：'.(isset($receive->GetOrderResult->ErrorMessage)?$receive->GetOrderResult->ErrorMessage:'');
						$err_lv=2;
					}
					break;
				case 'SearchCheckin':
					if($receive->SearchCheckinResult->Success!='true'){
						$err_msg='接口错误：'.(isset($receive->SearchCheckinResult->ErrorMessage)?$receive->SearchCheckinResult->ErrorMessage:'');
						$err_lv=2;
					}
					break;
				case 'CancelOrder':
					if($receive->CancelOrderResult->Success!='true'){
						$err_msg='接口错误：'.(isset($receive->CancelOrderResult->ErrorMessage)?$receive->CancelOrderResult->ErrorMessage:'');
						$err_lv=1;
					}
					break;
				case 'AddOnlinePayment':
					if($receive->AddOnlinePaymentResult->Success!='true'||empty($receive->AddOnlinePaymentResult->Content)){
						$err_msg='接口错误：'.(isset($receive->AddOnlinePaymentResult->ErrorMessage)?$receive->AddOnlinePaymentResult->ErrorMessage:'');
						$err_lv=1;
					}
					break;
				case 'UpdateOnlinePayment':
					if($receive->UpdateOnlinePaymentResult->Success!='true'||empty($receive->UpdateOnlinePaymentResult->Content)){
						$err_msg='接口错误：'.(isset($receive->UpdateOnlinePaymentResult->ErrorMessage)?$receive->UpdateOnlinePaymentResult->ErrorMessage:'');
						$err_lv=1;
					}
					break;
				case 'AddBillItem':
					if($receive->AddBillItemResult->Success!='true'||empty($receive->AddBillItemResult->Content)){
						$err_msg='接口错误：'.(isset($receive->AddBillItemResult->ErrorMessage)?$receive->AddBillItemResult->ErrorMessage:'');
						$err_lv=1;
					}
					break;
				
			}
		}
		
		$this->Webservice_model->webservice_error_log ( $this->inter_id, 'beyondh', $err_lv, $err_msg, array (
			'web_path' => $url,
			'send' => $send,
			'receive' => $receive,
			'send_time' => $now,
			'receive_time' => $micro_time,
			'fun_name' => $func_name_des,
			'alarm_wait_time' => $alarm_wait_time
		), $func_data );
	}
	
	function beyondh_sign($paras, $timestamp){
		$s = '';
		foreach($paras as $p){
			$a = $this->sign_string($p, 0);
			$s .= $a;
		}
		$s = strtolower($s);
//		echo $s;
		$s .= $timestamp . SIGNKEY;
		// echo $s;
		$s = KEY . ':' . md5($s);
		// echo $s;
		// exit;
		return $s;
	}
	
	function create_expire_time(){
		return time() + 86400;
	}
	
	function sign_string($paras, $t = 0){
		$s = '';
		// natsort($paras);
		if(is_null($paras)){
			return '';
		} else{
			if($paras === false){
				$s .= 'false';
			} else{
				if($paras === true){
					$s .= 'true';
				} else{
					if(is_array($paras) || is_object($paras)){
						ksort($paras, SORT_STRING);
						foreach($paras as $k => $pa){
							if($t == 1){
// 								echo $k . ' : ';
// 								var_dump($pa);
							}
							$s .= $this->sign_string($pa);
						}
					} else{
						if(strtotime($paras) && strstr($paras, 'T') !== false && $paras != 'T'){
							$s .= date('Y-m-d H-i-s', strtotime($paras));
						} else{
							if(strstr($paras, 'E+')){
								$paras = number_format($paras, 0, '', '');
// 								echo $paras;
								$s .= $paras;
							} else{
								$s .= $paras;
							}
						}
					}
				}
			}
		}
//		echo $s.'-';
		return $s;
	}
	
	//判断订单是否能支付
	function check_order_canpay($order, $pms_set){
		$web_orderid = $order['web_orderid'];
		$web_order = $this->get_web_order($order['web_orderid'], $pms_set,$order['orderid']);
		$web_order = obj2array($web_order);
		if(!empty ($web_order)){
			$web_status = $web_order['OrderStatus'];
			$status_arr = $this->pms_enum('status');
			$status = $status_arr[$web_status];
		}
		if(isset($status) && ($status==1 || $status==0)){//订单确认
			return true;
		}else{
			return false;
		}
	}
	
	private function readDB(){
		static $db_read;
		if(!$db_read){
			$db_read = $this->load->database('iwide_r1',true);
		}
		return $db_read;
	}
}