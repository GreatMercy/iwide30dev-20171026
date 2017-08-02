<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Template_msg_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	const TAB_TEMP_MSG = 'template_msg';
	const TAB_ENUM = 'enum_desc';
	const ENUM_TMG_TYPE = 'HOTEL_ORDER_TMPMSG_TYPE';
	public function get_temp_msg_list($inter_id, $type) {
		$sql = "SELECT tm.*,ed.des,ed.type FROM 
			   (SELECT * FROM `" . $this->db->dbprefix ( self::TAB_TEMP_MSG ) . "` where inter_id='$inter_id' AND status!=3 ) tm 
			    JOIN (SELECT * FROM `" . $this->db->dbprefix ( self::TAB_ENUM ) . "` where type='$type' ) ed 
		         on ed.code=tm.temp_type";
		$result = $this->db->query ( $sql )->result_array ();
		$data = array ();
		if (! empty ( $result ))
			foreach ( $result as $r ) {
				$data [$r ['temp_type']] = $r;
			}
		return $data;
	}
	public function get_temp_msg_types($type) {
		$tmp_type = '';
		switch ($type) {
			case 'hotel_order' :
				$tmp_type = self::ENUM_TMG_TYPE;
				break;
			case 'member' :
				$tmp_type = 'MEMBER_TMPMSG_TYPE';
				break;
            case 'okpay' :
                $tmp_type = 'OKPAY_TMPMSG_TYPE';
                break;
            case 'roomservice' :
                $tmp_type = 'ROOMSERVICE_TMPMSG_TYPE';
                break;
            case 'ticket' :
                $tmp_type = 'TICKET_TMPMSG_TYPE';
                break;
            case 'appointment' :
                $tmp_type = 'APPOINTMENT_TMPMSG_TYPE';
                break;
            case 'tips' :
                $tmp_type = 'TIPS_ORDERS_TMPMSG_TYPE';
                break;
			default :
				break;
		}
		$this->load->model ( 'common/Enum_model' );
		return $this->Enum_model->get_enum_des ( $tmp_type );
	}
	function get_template($inter_id, $temp_type = '', $status = null,$channel='weixin') {
		$this->db->where ( 'inter_id', $inter_id );
		$this->db->where ( 'temp_type', $temp_type );
		$this->db->where ( 'channel', $channel );
		if(is_array($status)){
			$this->db->where_in ( 'status', $status );
		}else{
			is_null ( $status ) ?  : $this->db->where ( 'status', $status );
		}
		$temp = $this->db->get ( self::TAB_TEMP_MSG )->row_array ();
		if (! empty ( $temp )) {
			$temp ['content'] = json_decode ( $temp ['content'], TRUE );
		}
		return $temp;
	}
	function order_find_des() {
		return array (
				'{ORDERID}' => '订单号',
				'{STARTDATE}' => '入住日期',
				'{ENDDATE}' => '离店日期',
				'{NAME}' => '预订人姓名',
				'{HOTEL}' => '酒店名',
				'{PRICE}' => '订单总价',
				'{ROOMNUMS}' => '预订房间数',
				'{ROOM}' => '房型',
				'{OID}' => '',
				'{INTER_ID}' => '',
				'{ORDERTIME}' => '下单时间',
				'{STATUS}' => '订单状态',
				'{OPERTIME}' => '发送时间',
				'{TEL}'=>'联系电话',
				'{STARTDATE_ENG}'=>'入住日期年-月-日格式',
				'{ENDDATE_ENG}'=>'离店日期年-月-日格式',
				'{MTORDERID}'=>'后台添加的pms单号'
		);
	}
	function order_find_replace($order) {
		$this->load->model ( 'common/Enum_model' );
		$enum_des = $this->Enum_model->get_enum_des ( array (
				'HOTEL_ORDER_STATUS' 
		) );
		$find = array (
				'{ORDERID}',
				'{STARTDATE}',
				'{ENDDATE}',
				'{NAME}',
				'{HOTEL}',
				'{PRICE}',
				'{ROOMNUMS}',
				'{ROOM}',
				'{OID}',
				'{INTER_ID}',
				'{ORDERTIME}',
				'{STATUS}',
				'{OPERTIME}',
				'{TEL}',
				'{STARTDATE_ENG}',
				'{ENDDATE_ENG}',
				'{MEMBER_NO}',
		        '{MTORDERID}'
		);
		$orderid = empty ( $order ['web_orderid'] ) ? $order ['orderid'] : $order ['web_orderid'];
		$member_no=empty($order['member_no'])?'--':$order['member_no'];
		$replace = array (
				$orderid,
				date ( 'Y年m月d日', strtotime ( $order ['startdate'] ) ),
				date ( 'Y年m月d日', strtotime ( $order ['enddate'] ) ),
				$order ['name'],
				$order ['hname'],
				$order ['price'],
				$order ['roomnums'],
				$order ['first_detail'] ['roomname'],
				$order ['id'],
				$order ['inter_id'],
				date ( 'Y-m-d H:i', $order ['order_time'] ),
				$enum_des ['HOTEL_ORDER_STATUS'] [$order ['status']],
				date ( 'Y-m-d H:i:s' ),
				$order['tel'],
				date ( 'Y-m-d', strtotime ( $order ['startdate'] ) ),
				date ( 'Y-m-d', strtotime ( $order ['enddate'] ) ),
				$member_no,
		        $order['mt_pms_orderid']
		);
		return array (
				'find' => $find,
				'replace' => $replace 
		);
	}
	
	/**
	 *
	 * @param unknown $order
	 *        	array('openid'=>$openid,'member'=>$member_name,'inter_id'=>$inter_id)
	 * @param unknown $send_type        	
	 */
	public function send_member_msg($order, $send_type) {
		$temp_query = $this->get_template ( $order ['inter_id'], $send_type, 1 );
		if ($temp_query) {
			$data ['touser'] = $order ['openid'];
			$data ['template_id'] = $temp_query ['temp_id'];
			if (! empty ( $temp_query ['url'] )) {
				$data ['url'] = $temp_query ['url'];
			} else if (! empty ( $temp_query ['url_type'] )) {
				$this->load->model ( 'common/Enum_model' );
				$urls = $this->Enum_model->get_enum_des ( 'HOTEL_ORDER_TMPMSG_URL' );
				$this->load->model ( 'wx/Publics_model' );
				$public = $this->Publics_model->get_public_by_id ( $order ['inter_id'] );
				$data ['url'] = $public ['domain'] . str_replace ( '{NAME}', $order ['member_name'], $urls [$temp_query ['url_type']] );
			}
			$data ['topcolor'] = $temp_query ['top_color'];
			foreach ( $temp_query ['content'] as $tk => $tc ) {
				$text = empty ( $tc ['common'] ) ? '' : $tc ['common'];
				$subdata [$tk] ['value'] = str_replace ( '{NAME}', $order ['member_name'], $text );
				$subdata [$tk] ['color'] = empty ( $tc ['color'] ) ? $temp_query ['text_color'] : $tc ['color'];
			}
			$data ['data'] = $subdata;
			$this->send_template_msg ( $order ['inter_id'], $data,$send_type );
		}
	}

    /**
     * 快乐付支付成功模板消息
     * @param unknown $order
     * @param unknown $send_type
     * */
    public function send_okpay_success_msg($order, $send_type ) {
        $temp_query = $this->get_template ( $order ['inter_id'], $send_type, 1 );
        if ($temp_query) {
            $data ['touser'] = $order ['openid'];
            $data ['template_id'] = $temp_query ['temp_id'];
            if (! empty ( $temp_query ['url'] )) {
                $data ['url'] = $temp_query ['url'];
            } else if (! empty ( $temp_query ['url_type'] )) {
                $this->load->model ( 'common/Enum_model' );
                $urls = $this->Enum_model->get_enum_des ( 'HOTEL_ORDER_TMPMSG_URL' );
                $this->load->model ( 'wx/Publics_model' );
                $public = $this->Publics_model->get_public_by_id ( $order ['inter_id'] );
// 				$data ['url'] = $public ['domain'] . str_replace ( '{NAME}', $grade_info ['member_name'], $urls [$temp_query ['url_type']] );
                $data ['url'] = $public ['domain'] . str_replace ( '{INTER_ID}', $order ['inter_id'], $urls [$temp_query ['url_type']] );
                $data ['url'] = str_replace('{HOTEL_ID}',$order['hotel_id'],$data['url']);
                $data ['url'] = str_replace('{OID}',$order['out_trade_no'],$data['url']);
                $data ['url'] = str_replace('{PAY_CODE}',$order['sale'],$data['url']);
            }
            $data ['topcolor'] = $temp_query ['top_color'];
            foreach ( $temp_query ['content'] as $tk => $tc ) {
                $text = empty ( $tc ['common'] ) ? '' : $tc ['common'];
                $temp_str = str_replace ( '{ORDER_SN}', $order ['out_trade_no'], $text );
                $temp_str = str_replace('{PAY_MONEY}', $order['pay_money'], $temp_str);
                $temp_str = str_replace('{HOTEL}', $order['hotel_name'], $temp_str);
                $temp_str = str_replace('{PAY_TIME}', date('Y-m-d H:i',$order['pay_time']), $temp_str);
                $subdata [$tk] ['value'] = $temp_str;
                $subdata [$tk] ['color'] = empty ( $tc ['color'] ) ? $temp_query ['text_color'] : $tc ['color'];
            }
            $data ['data'] = $subdata;
            $this->send_template_msg ( $order ['inter_id'], $data,$send_type );
        }
    }

    /**
     * 订餐支付成功模板消息
     * @param unknown $order
     * @param unknown $send_type
     * */
    public function send_roomservice_success_msg($order, $send_type ) {
        $temp_query = $this->get_template ( $order ['inter_id'], $send_type, 1 );
        if ($temp_query) {
            $data ['touser'] = $order ['openid'];
            $data ['template_id'] = $temp_query ['temp_id'];
            if (! empty ( $temp_query ['url'] )) {
                $data ['url'] = $temp_query ['url'];
            } else if (! empty ( $temp_query ['url_type'] )) {
                $this->load->model ( 'common/Enum_model' );
                $urls = $this->Enum_model->get_enum_des ( 'ROOMSERVICE_ORDER_TMPMSG_URL' );
                $this->load->model ( 'wx/Publics_model' );
                $public = $this->Publics_model->get_public_by_id ( $order ['inter_id'] );
// 				$data ['url'] = $public ['domain'] . str_replace ( '{NAME}', $grade_info ['member_name'], $urls [$temp_query ['url_type']] );
                $data ['url'] = $public ['domain'] . str_replace ( '{INTER_ID}', $order ['inter_id'], $urls [$temp_query ['url_type']] );
                $data ['url'] = str_replace('{ORDER_ID}',$order['order_id'],$data['url']);
             //   $data ['url'] = str_replace('{OID}',$order['out_trade_no'],$data['url']);
             //   $data ['url'] = str_replace('{PAY_CODE}',$order['sale'],$data['url']);
            }
            $data ['topcolor'] = $temp_query ['top_color'];
            foreach ( $temp_query ['content'] as $tk => $tc ) {
                $text = empty ( $tc ['common'] ) ? '' : $tc ['common'];
                $temp_str = str_replace ( '{ORDER_SN}', $order ['order_sn'], $text );
                $temp_str = str_replace('{PAY_MONEY}', $order['sub_total'], $temp_str);
				$temp_str = str_replace('{GOODS_INFO}', $order['show_name'], $temp_str);
                $temp_str = str_replace('{STATUS}', $order['order_show_status'], $temp_str);
               // $temp_str = str_replace('{PAY_TIME}', date('Y-m-d H:i',$order['pay_time']), $temp_str);
                $subdata [$tk] ['value'] = $temp_str;
                $subdata [$tk] ['color'] = empty ( $tc ['color'] ) ? $temp_query ['text_color'] : $tc ['color'];
            }
            $data ['data'] = $subdata;
            $this->send_template_msg ( $order ['inter_id'], $data,$send_type );
        }
    }

    /**
     * 打赏支付成功模板消息
     * @param unknown $order
     * @param unknown $send_type
     * */
    public function send_tips_success_msg($order, $send_type ) {
        $temp_query = $this->get_template ( $order ['inter_id'], $send_type, 1 );
        if ($temp_query) {
            $data ['touser'] = $order ['openid'];
            $data ['template_id'] = $temp_query ['temp_id'];
            if (! empty ( $temp_query ['url'] )) {
                $data ['url'] = $temp_query ['url'];
            } else if (! empty ( $temp_query ['url_type'] )) {
                $this->load->model ( 'common/Enum_model' );
                $urls = $this->Enum_model->get_enum_des ( 'HOTEL_ORDER_TMPMSG_URL' );
                $this->load->model ( 'wx/Publics_model' );
                $public = $this->Publics_model->get_public_by_id ( $order ['inter_id'] );
// 				$data ['url'] = $public ['domain'] . str_replace ( '{NAME}', $grade_info ['member_name'], $urls [$temp_query ['url_type']] );
                $data ['url'] = $public ['domain'] . str_replace ( '{INTER_ID}', $order ['inter_id'], $urls [$temp_query ['url_type']] );
                //   $data ['url'] = str_replace('{HOTEL_ID}',$order['hotel_id'],$data['url']);
                //   $data ['url'] = str_replace('{OID}',$order['out_trade_no'],$data['url']);
                //   $data ['url'] = str_replace('{PAY_CODE}',$order['sale'],$data['url']);
            }
            $data ['topcolor'] = $temp_query ['top_color'];
            foreach ( $temp_query ['content'] as $tk => $tc ) {
                $text = empty ( $tc ['common'] ) ? '' : $tc ['common'];
                $temp_str = str_replace ( '{ORDER_SN}', $order ['order_sn'], $text );
                $temp_str = str_replace('{PAY_MONEY}', $order['pay_money'], $temp_str);
                //$temp_str = str_replace('{PAY_NAME}', $order['pay_name'], $temp_str);
                // $temp_str = str_replace('{PAY_TIME}', date('Y-m-d H:i',$order['pay_time']), $temp_str);
                $subdata [$tk] ['value'] = $temp_str;
                $subdata [$tk] ['color'] = empty ( $tc ['color'] ) ? $temp_query ['text_color'] : $tc ['color'];
            }
            $data ['data'] = $subdata;
            $this->send_template_msg ( $order ['inter_id'], $data,$send_type );
        }
    }


    /**
     * 预约/排队取号模板消息
     * @param unknown $order
     * @param unknown $send_type
     * @author Shacaisheng   2017-3-13
     * */
    public function send_appointment_msg($order, $send_type )
    {
        $temp_query = $this->get_template($order['inter_id'], $send_type, 1);
        if ($temp_query) {
            $data ['touser'] = $order ['openid'];
            $data ['template_id'] = $temp_query ['temp_id'];
            if (! empty ( $temp_query ['url'] )) {
                $data ['url'] = $temp_query ['url'];
            } else if (! empty ( $temp_query ['url_type'] )) {
                $this->load->model ( 'common/Enum_model' );
                $urls = $this->Enum_model->get_enum_des ( 'HOTEL_ORDER_TMPMSG_URL' );
                $this->load->model ( 'wx/Publics_model' );
                $public = $this->Publics_model->get_public_by_id ( $order ['inter_id'] );
// 				$data ['url'] = $public ['domain'] . str_replace ( '{NAME}', $grade_info ['member_name'], $urls [$temp_query ['url_type']] );
                $data ['url'] = $public ['domain'] . str_replace ( '{INTER_ID}', $order ['inter_id'], $urls [$temp_query ['url_type']] );
                //   $data ['url'] = str_replace('{HOTEL_ID}',$order['hotel_id'],$data['url']);
                //   $data ['url'] = str_replace('{OID}',$order['out_trade_no'],$data['url']);
                //   $data ['url'] = str_replace('{PAY_CODE}',$order['sale'],$data['url']);
            }
            $data ['topcolor'] = $temp_query ['top_color'];
            foreach ($temp_query ['content'] as $tk => $tc ) {
                $text = empty ( $tc ['common'] ) ? '' : $tc ['common'];
                $temp_str = str_replace ( '{SHOP_NAME}', $order['shop_name'], $text );
                $temp_str = str_replace ( '{UNIT}', $order ['unit'], $temp_str );
                $temp_str = str_replace('{NAME}', $order['name'], $temp_str);
                $temp_str = str_replace('{TIME}', $order['time'], $temp_str);
                $temp_str = str_replace('{WAIT}', $order['wait'], $temp_str);
                $temp_str = str_replace('{NUMBER}', $order['number'], $temp_str);
                $temp_str = str_replace('{ITEM}', $order['item'], $temp_str);
                $temp_str = str_replace('{REASON}', $order['reason'], $temp_str);
                $temp_str = str_replace('{USER_NAME}', $order['book_name'], $temp_str);
                $temp_str = str_replace('{PHONE}', $order['book_phone'], $temp_str);
                $temp_str = str_replace('{NOTE}', $order['book_info'], $temp_str);
                $subdata [$tk] ['value'] = $temp_str;
                $subdata [$tk] ['color'] = empty ( $tc ['color'] ) ? $temp_query ['text_color'] : $tc ['color'];
            }
            $data ['data'] = $subdata;
            $this->send_template_msg ( $order ['inter_id'], $data,$send_type );
        }
    }

	/**
	 * 储值充值成功模板消息
	 * @param unknown $order
	 * @param unknown $send_type
	 */
	public function send_charge_msg($order, $send_type) {
		$temp_query = $this->get_template ( $order ['inter_id'], $send_type, 1 );
		if ($temp_query) {
			$data ['touser'] = $order ['openid'];
			$data ['template_id'] = $temp_query ['temp_id'];
			if (! empty ( $temp_query ['url'] )) {
				$data ['url'] =  str_replace ( '{ORDER_NO}', $order ['orderid'],$temp_query ['url']);
			} else if (! empty ( $temp_query ['url_type'] )) {
				$this->load->model ( 'common/Enum_model' );
				$urls = $this->Enum_model->get_enum_des ( 'HOTEL_ORDER_TMPMSG_URL' );
				$this->load->model ( 'wx/Publics_model' );
				$public = $this->Publics_model->get_public_by_id ( $order ['inter_id'] );
				$data ['url'] = $public ['domain'] . str_replace ( '{ORDER_NO}', $order ['orderid'], $urls [$temp_query ['url_type']] );
			}
			$data ['topcolor'] = $temp_query ['top_color'];
			foreach ( $temp_query ['content'] as $tk => $tc ) {
				$text = empty ( $tc ['common'] ) ? '' : $tc ['common'];
				$temp_str = str_replace ( '{MEMBER_NO}', $order ['membership_number'], $text );
				$temp_str = str_replace('{AMOUNT}', $order['amount'], $temp_str);
				$temp_str = str_replace('{ORDER_NO}', $order['orderid'], $temp_str);
				$subdata [$tk] ['value'] = $temp_str;
				$subdata [$tk] ['color'] = empty ( $tc ['color'] ) ? $temp_query ['text_color'] : $tc ['color'];
			}
			$data ['data'] = $subdata;
			$this->send_template_msg ( $order ['inter_id'], $data,$send_type );
		}
	}
	public function send_hotel_order_msg($order, $send_type,$status=1,$condit=array()) {
		$order_channel=isset($order['channel'])?$order['channel']:'weixin';//类型
		$temp_query = $this->get_template ( $order ['inter_id'], $send_type, $status,$order_channel );
		if ($temp_query) {
			$data ['touser'] = $order ['openid'];
			$data ['template_id'] = $temp_query ['temp_id'];
			$fr = $this->order_find_replace ( $order );
			$find = $fr ['find'];
			$replace = $fr ['replace'];
			if (! empty ( $temp_query ['url'] )  || $temp_query ['url_type'] == 'diy' ) {
				$data ['url'] = str_replace ( $find, $replace, $temp_query ['url'] );
			} else if (! empty ( $temp_query ['url_type'] )) {
// 				$this->load->model ( 'common/Enum_model' );
// 				$urls = $this->Enum_model->get_enum_des ( 'HOTEL_ORDER_TMPMSG_URL' );
				$urls = $this->enums( $order_channel.'_hotel_order_urltypes' );
				$this->load->model ( 'wx/Publics_model' );
				if ($order_channel=='wxapp'){
// 					$public = $this->Publics_model->get_wxapublic_info ( $order ['inter_id'] );
					$data ['page'] = str_replace ( $find, $replace, $urls [$temp_query ['url_type']] );
					$data ['form_id'] = isset($order['msg_auth'])?$order['msg_auth']:'';
				}else{
					$public = $this->Publics_model->get_public_by_id ( $order ['inter_id'] );
					$data ['url'] = $public ['domain'] . str_replace ( $find, $replace, $urls [$temp_query ['url_type']] );
					if (! empty ( $data ['url'] ) && strpos ( $data ['url'], 'orderid=' ) === false) {
						if (strpos ( $data ['url'], '?' ))
							$data ['url'] = $data ['url'] . "&orderid=" . $order ['orderid'];
						else
							$data ['url'] = $data ['url'] . "?orderid=" . $order ['orderid'];
					}
				}
			}
			empty($temp_query ['top_color']) or $data ['topcolor'] = $temp_query ['top_color'];
			foreach ( $temp_query ['content'] as $tk => $tc ) {
				if (empty ( $tc ['pay_' . $order ['paid']] )) {
					$text = empty ( $tc ['common'] ) ? '' : $tc ['common'];
				} else {
					$text = $tc ['pay_' . $order ['paid']];
				}
				$subdata [$tk] ['value'] = str_replace ( $find, $replace, $text );
				$subdata [$tk] ['color'] = empty ( $tc ['color'] ) ? $temp_query ['text_color'] : $tc ['color'];
				if (isset($tc['emphasize']) && $tc['emphasize'] = 1)
					$data['emphasis_keyword']=$tk;
			}
			$data ['data'] = $subdata;
			//附加条件处理
			if( isset($condit['wx_notify']) && $send_type == 'hotel_order_notice' && (in_array('all',$condit['wx_notify']) || in_array('new_deal',$condit['wx_notify']))){
				$this->load->model ( 'wx/Publics_model' );
				$public = $this->Publics_model->get_public_by_id ( $order ['inter_id'] );
				$data ['url'] = prep_url ( $public ['domain'] . '/index.php/hotel_notify/hotel_notify/deal_order?id=' . $order ['inter_id'].'&oid='.$order ['orderid'] );
			}
			return $this->send_template_msg ( $order ['inter_id'], $data,$send_type,$order_channel );
		}
		return array('s'=>0,'errmsg'=>'no this template');
	}
	function send_ensure_distribute($inter_id, $openid, $name, $tel, $saler_id) {
		$this->db->where ( array (
				'inter_id' => $inter_id,
				'temp_type' => 'hotel_distribute_ensure',
				'status' => 1 
		) );
		$temp_query = $this->db->get ( 'template_msg' )->row_array ();
		if ($temp_query && $openid) {
			$data ['template_id'] = $temp_query ['temp_id'];
			$remark = '';
			$data ['touser'] = $openid;
			$this->load->model ( 'wx/Publics_model' );
			$public = $this->Publics_model->get_public_by_id ( $inter_id );
			$data ['url'] = prep_url ( $public ['domain'] . '/index.php/distribute/distribute/reg?id=' . $inter_id );
			$data ['topcolor'] = '#000000';
			$subdata ['first'] = array (
					'value' => "$name 你好，你的分销申请已经通过审核。",
					'color' => '#20773F' 
			);
			$subdata ['keyword1'] = array (
					'value' => '分销号：' . $saler_id . ',手机号：' . $tel,
					'color' => '#20773F' 
			);
			$subdata ['keyword2'] = array (
					'value' => '已审核通过',
					'color' => '#20773F' 
			);
			$subdata ['keyword3'] = array (
					'value' => date ( "Y-m-d H:i:s" ),
					'color' => '#20773F' 
			);
			$subdata ['remark'] = array (
					'value' => $remark . "点击查看详情",
					'color' => '#20773F' 
			);
			$data ['data'] = $subdata;
			$this->send_template_msg ( $order ['inter_id'], $data,'hotel_distribute_ensure' );
		}
	}
    function hotel_club_templates($inter_id,$params,$send_type,$status=1){
        $this->db->where ( array (
            'inter_id' => $inter_id,
            'temp_type' => $send_type,
            'status' => $status
        ) );
        $temp_query = $this->db->get ( 'template_msg' )->row_array ();
        if ($temp_query && $params['openid']) {
            $data ['template_id'] = $temp_query ['temp_id'];
            $remark = '';
            $data ['touser'] = $params['openid'];

            $this->load->model ( 'wx/Publics_model' );
            $public = $this->Publics_model->get_public_by_id ( $inter_id );

            if(empty($temp_query['url'])){
                $data ['url'] = prep_url ( $public ['domain'] . '/index.php/club/club/index?id=' . $inter_id );
            }else{
                $data ['url'] = $temp_query['url'];
            }


            $data ['topcolor'] = '#000000';
            $content = json_decode($temp_query['content']);

            if(isset($params['keyword1']) && $content->keyword1->common=='club'){
                $content->keyword1->common = $params['keyword1'];
            }

            if(isset($params['keyword2']) && $content->keyword2->common=='club'){
                $content->keyword2->common = $params['keyword2'];
            }

            if(isset($params['keyword3']) && $content->keyword3->common=='club'){
                $content->keyword3->common = $params['keyword3'];
            }

            if(isset($content->first)){
                $subdata ['first'] = array (
                    'value' => $content->first->common,
                    'color' => $content->first->color
                );
            }

            if(isset($content->keyword1)){
                $subdata ['keyword1'] = array (
                    'value' => $content->keyword1->common,
                    'color' => $content->keyword1->color
                );
            }

            if(isset($content->keyword2)){
                $subdata ['keyword2'] = array (
                    'value' => $content->keyword2->common,
                    'color' => $content->keyword2->color
                );
            }

            if(isset($content->keyword3)){
                $subdata ['keyword3'] = array (
                    'value' =>$content->keyword3->common,
                    'color' => $content->keyword3->color
                );
            }

            if(isset($content->remark)){
                $subdata ['remark'] = array (
                    'value' => $content->remark->common,
                    'color' => $content->remark->color
                );
            }

            $data ['data'] = $subdata;

            $this->send_template_msg ( $inter_id, $data,$send_type );
        }
    }


	//退房和发票模板消息匹配配置
	public function find_checkout_or_invoice_replace($order,$content,$send_type){
		$replace = array();
		$contents = array();
		switch ($send_type) {
			// 退房预约成功提醒
			case 'hotel_checkout_notice':
				$replace = array(
					'type' => '{TYPE}',
					'check_out_time' => '{CHECK_OUT_TIME}',
					);
			    $order['type'] = '预约退房';
				break;
			// 退房发票开具提醒
			case 'hotel_invoice_notice':
				$replace = array(
					'hotel' => '{HOTEL}',
					'amount' => '{AMOUNT}',
					'type' => '{TYPE}',
					'project' => '{PROJECT}',
					'title' => '{TITLE}',
					);
				$order['project'] = '住宿费';
				break;
			// 退房预约申请提醒(酒店用)
			case 'hotel_checkout_apply_notice':
				$replace = array(
					'hotel' => '{HOTEL}',
					'check_out_time' => '{CHECK_OUT_TIME}',
					'room_num' => '{ROOM_NUM}',
					);
				break;
			// 退房成功提醒
			case 'hotel_checkout_success_notice':
				$replace = array(
					'hotel' => '{HOTEL}',
					'room_num' => '{ROOM_NUM}',
					);
				break;
			default:
				# code...
				break;
		}
		if(!empty($replace)&&!empty($content)&&!empty($order)){
			foreach ($content as $key => $value) {
				// if(in_array($value['common'],$replace)!==false){
				// 	$contents[$key]['color'] = $value['color'];
				// 	$contents[$key]['value'] = $order[array_search($value['common'],$replace)];
				// }else{
				// 	$contents[$key]['color'] = $value['color'];
				// 	$contents[$key]['value'] = $value['common'];
				// }
				$contents[$key]['color'] = $value['color'];
				$common = $value['common'];
				foreach ($replace as $kre => $vre) {
					$common = str_replace($vre, $order[$kre], $common);
				}
				$contents[$key]['value'] = $common;
			}
		}
		return $contents;
	}
    //退房和发票模板消息提醒
    function send_checkout_or_invoice_msg($order,$send_type,$status=1){
    	$this->db->where ( array (
            'inter_id' => $order['inter_id'],
            'temp_type' => $send_type,
            'status' => $status
        ) );
        $temp_query = $this->db->get ( 'template_msg' )->row_array ();
        if($temp_query && $order['openid']){
        	$data ['template_id'] = $temp_query ['temp_id'];
            $data ['touser'] = $order['openid'];
		    if(!empty($temp_query['url'])){
		        $data ['url'] = $temp_query['url'];
		    }
		    $data ['topcolor'] = '#000000';
		    $content = json_decode($temp_query['content'],1);
		    $subdata = $this->find_checkout_or_invoice_replace($order,$content,$send_type);
            $data ['data'] = $subdata;
            return $this->send_template_msg ( $order['inter_id'], $data,$send_type );
        }
        return array('s'=>0,'errmsg'=>'no this template');
    }

    //发送智能调价模板消息
    function send_smart_price_msg($inter_id,$info,$send_type,$status=1){
    	$this->db->where ( array (
            'inter_id' => $inter_id,
            'temp_type' => $send_type,
            'status' => $status
        ) );
        $temp_query = $this->db->get ( 'template_msg' )->row_array ();
        if($temp_query && $info['openid']){
        	$data ['template_id'] = $temp_query ['temp_id'];
            $data ['touser'] = $info['openid'];
            if(!empty($temp_query['url'])){
            	if($info['remark_type']=='down'){
			        $this->load->model ( 'wx/Publics_model' );
			        $public = $this->Publics_model->get_public_by_id ( $info ['inter_id'] );
					$data ['url'] = $public ['domain'] . str_replace ( '{INTER_ID}', $info['inter_id'], $temp_query ['url'] );
					$data ['url'] = str_replace ( '{HOTEL_ID}', $info['hotel_id'], $data ['url'] );
					$data ['url'] = str_replace ( '{BATCH}', $info['batch'], $data ['url'] );
					$data ['url'] = str_replace ( '{DAY}', date('Y-m-d'), $data ['url'] );
				}else{
					$data ['url'] = '';
				}
		    }
            $data ['topcolor'] = '#000000';
		    $content = json_decode($temp_query['content'],1);
		    $finds = array(
		    	'hotel' => '{HOTEL}',
		    	// 'warndate' => '{WARNDATE}',
		    	// 'warncontent' => '{WARNCONTENT}',
		    	// 'remark' => '{REMARK}',
		    	// 'starttime' => '{STARTTIME}',
		    	// 'endtime' => '{ENDTIME}',
		    	);
		    if($info['remark_type']=='down'){
		    	$finds['starttime'] = '{STARTTIME}';
		    	$finds['endtime'] = '{ENDTIME}';
		    }
		    // if($info['warn_type']=='down'){
		    // 	$info['color'] = '';
		    // 	$info['warncontent'] = '价格已出现倒挂';
		    // }else{
		    // 	$info['color'] = '';
		    // 	$info['warncontent'] = '价格已修改成功';
		    // }
		    // if($info['remark_type']=='down'){
		    // 	$info['color'] = '';
		    // 	$info['remark'] = '请点击详情，确认是否需要执行智能调价！';
		    // }else{
		    // 	$info['color'] = '';
		    // 	$info['remark'] = '';
		    // }
		    foreach($content as $k=>$v){
		    	$subdata[$k]['color'] = $v['color'];
		    	foreach($finds as $kf=>$vf){
		    		$v['common'] = str_replace($vf,$info[$kf],$v['common']);
		    	}
		    	$subdata[$k]['value'] = $v['common'];
		    }
            $data ['data'] = $subdata;
            return $this->send_template_msg ( $inter_id, $data,$send_type );
        }
        return array('s'=>0,'errmsg'=>'no config or no openid');
    }

	function send_template_msg($inter_id, $data,$tmp_type='',$channel='weixin') {
		$url=$this->enums('send_msg_path',$channel);
		if ($url){
			$this->load->model ( 'wx/Access_token_model' );
			$access_token = $this->Access_token_model->get_access_token ( $inter_id ,FALSE,$channel);
			$this->load->helper ( 'common_helper' );
			$now = time ();
			$result=doCurlPostRequest ( $url. $access_token, json_encode ( $data ) );
			$xml = json_decode ( $result, True );
			if ($xml ['errcode'] == 40001 || $xml ['errcode'] == 42001) {
				$access_token = $this->Access_token_model->reflash_access_token ( $inter_id,FALSE,$channel );
				$xml = json_decode ( doCurlPostRequest ( $url. $access_token, json_encode ( $data ) ),TRUE );
			}
	
			$send_content=json_encode ( $data,JSON_UNESCAPED_UNICODE ).'--access_token="'.$access_token.'"';
			$this->load->model('common/Webservice_model');
			$this->Webservice_model->add_webservice_record($inter_id, $channel.'_tmpmsg', $url, $send_content, $result,$tmp_type, $now, microtime (), $data['touser']);
			if (isset($xml['errcode'])&&$xml['errcode'] == 0){
				return array('s'=>1,'errmsg'=>'ok');
			}else {
				return array('s'=>0,'errmsg'=>$xml['errmsg'],'datas'=>array('wx_errcode'=>$xml['errcode']));
			}
		}
		return array('s'=>0,'errmsg'=>'no config');
	}
	function edit_template_msg($condition, $data) {
		$this->db->where ( $condition );
		$data ['edit_time'] = time ();
		return $this->db->update ( self::TAB_TEMP_MSG, $data );
	}
	function add_template_msg($data) {
		$data ['edit_time'] = time ();
		return $this->db->insert ( self::TAB_TEMP_MSG, $data );
	}
	function delete_template_msg($condition) {
		$this->db->where ( $condition );
		return $this->db->delete ( self::TAB_TEMP_MSG );
	}
	/**
	 * 后台管理的表格中要显示哪些字段
	 */
	public function grid_fields() {
		return array (
				'des' => array (
						'label' => '模板名' 
				),
				'temp_id' => array (
						'label' => '模板ID' 
				),
				'url_type' => array (
						'label' => '链接' 
				),
				'status' => array (
						'label' => '状态' 
				) 
		);
	}
	public function table_fields() {
		return array (
				'temp_type' => '',
				'inter_id' => '',
				'content' => '',
				'top_color' => '#1BAB3E',
				'url_type' => '',
				'url' => '',
				'text_color' => '',
				'temp_id' => '',
				'status' => 1 
		);
	}
	public function enums($type,$key=NULL){
		switch ($type){
			case 'weixin_hotel_order_urltypes':
				$this->load->model ( 'common/Enum_model' );
				$data=$this->Enum_model->get_enum_des ( 'HOTEL_ORDER_TMPMSG_URL' );
				break;
			case 'wxapp_hotel_order_urltypes':
				$data=array(
					'search_index'=>'pages/hotel/default/search/search',
					'hotel_index'=>'pages/hotel/default/roomlist/roomlist?hotel_id={HOTEL_ID}',
					'my_order'=>'pages/hotel/default/myorder/myorder',
					'order_detail'=>'pages/hotel/default/orderdetail/orderdetail?orderid={ORDERID}',
				);
				break;
			case 'send_msg_path':
				$data=array(
					'weixin'=>'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=',
					'wxapp'=>'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='
				);
				break;
			default:
				$data=array();
		}
		if (isset($key)){
			return isset($data[$key])?$data[$key]:NULL;
		}
		return $data;
	}

    /**
     * 核销模板消息
     * @param unknown $order
     * @param unknown $send_type
     * */
    public function send_ticket_success_msg($order, $send_type ) {
        $temp_query = $this->get_template ( $order ['inter_id'], $send_type, 1 );
        if ($temp_query) {
            $data ['touser'] = $order ['openid'];
            $data ['template_id'] = $temp_query ['temp_id'];
            if (! empty ( $temp_query ['url'] )) {
                $data ['url'] = $temp_query ['url'];
            } else if (! empty ( $temp_query ['url_type'] )) {
                $this->load->model ( 'common/Enum_model' );
                $urls = $this->Enum_model->get_enum_des ( 'TICKET_ORDER_TMPMSG_URL' );
                $this->load->model ( 'wx/Publics_model' );
                $public = $this->Publics_model->get_public_by_id ( $order ['inter_id'] );
// 				$data ['url'] = $public ['domain'] . str_replace ( '{NAME}', $grade_info ['member_name'], $urls [$temp_query ['url_type']] );
                $data ['url'] = $public ['domain'] . str_replace ( '{INTER_ID}', $order ['inter_id'], $urls [$temp_query ['url_type']] );
                //   $data ['url'] = str_replace('{HOTEL_ID}',$order['hotel_id'],$data['url']);
                //   $data ['url'] = str_replace('{OID}',$order['out_trade_no'],$data['url']);
                //   $data ['url'] = str_replace('{PAY_CODE}',$order['sale'],$data['url']);
            }
            $data ['topcolor'] = $temp_query ['top_color'];
            foreach ( $temp_query ['content'] as $tk => $tc ) {
                $text = empty ( $tc ['common'] ) ? '' : $tc ['common'];
                $temp_str = str_replace ('{BOOK_USER}', $order ['consignee'], $text);
                $temp_str = str_replace('{BOOK_PHONE}', $order['phone'], $temp_str);
                $temp_str = str_replace('{GOODS_INFO}', $order['show_name'], $temp_str);
                $temp_str = str_replace('{BOOK_DATE}', $order['dissipate'], $temp_str);
                $temp_str = str_replace ('{ORDER_SN}', $order ['order_sn'], $temp_str);
                $temp_str = str_replace('{PAY_MONEY}', $order['sub_total'], $temp_str);
                $temp_str = str_replace('{GOODS_INFO}', $order['show_name'], $temp_str);
                $temp_str = str_replace('{STATUS}', $order['order_show_status'], $temp_str);
                // $temp_str = str_replace('{PAY_TIME}', date('Y-m-d H:i',$order['pay_time']), $temp_str);
                $subdata [$tk] ['value'] = $temp_str;
                $subdata [$tk] ['color'] = empty ( $tc ['color'] ) ? $temp_query ['text_color'] : $tc ['color'];
            }
            $data ['data'] = $subdata;
            $this->send_template_msg ( $order ['inter_id'], $data,$send_type );
        }
    }
}