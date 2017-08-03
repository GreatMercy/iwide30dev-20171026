<?php
//error_reporting ( 0 );
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Wxpay extends MY_Front {

	public function __construct() {
		parent::__construct ();
		// 开发模式下开启性能分析
		$this->output->enable_profiler ( false );
	}
	function hotel_order() {
		//统计探针
		$this->load->library('MYLOG');
		MYLOG::hotel_tracker($this->session->userdata ( $this->inter_id . 'openid' ),   $this->session->userdata ( 'inter_id' ));
		
		$parameters = '';
		$data = array ();
		$orderid = $this->input->get ( 'orderid', true );
		$data ['fail_url'] = site_url ( 'hotel/hotel/myorder' ) . '?id=' . $this->inter_id;
		$data ['success_url'] = $data ['fail_url'];
		if ($orderid) {
			$this->load->model ( 'pay/Wxpay_model' );
			$this->load->model ( 'pay/Pay_model' );
			$this->load->model ( 'hotel/Order_model' );
			$this->load->model ( 'wx/Publics_model' );
			// 公众号
			$public = $this->Publics_model->get_public_by_id ( $this->session->userdata ( 'inter_id' ) );
			if (! empty ( $public ['app_id'] )) {
				$order_details = $this->Order_model->get_main_order ( $this->inter_id, array (
					'orderid' => $orderid,
					'idetail' => array (
						'i'
					)
				) );
				if ($order_details) {
					$order_details = $order_details [0];
					//若订单已取消，跳转再次预定页面
					$this->load->model ( 'hotel/Order_check_model' );
					$re = $this->Order_check_model->check_order_state($order_details);
					if($re['re_pay']!=1){
						redirect ( site_url ( 'hotel/hotel/index' ) . '?id=' . $this->inter_id .'&h=' .$order_details['hotel_id'] );
					}

					//配置采用pms单号还是本地单号进行支付
					$pay_orderid=$order_details ['orderid'];
					$this->load->model ( 'hotel/Hotel_config_model' );
					$config_data = $this->Hotel_config_model->get_hotel_config ( $order_details ['inter_id'], 'HOTEL', 0, array (
						'ORDER_PAY_ORDERID'
					) );
					if(!empty($config_data['ORDER_PAY_ORDERID'])&&$config_data['ORDER_PAY_ORDERID']=='web'){
						$pay_orderid=$order_details['web_orderid'];
					}

					$data ['fail_url'] .= '&fro='.$orderid . '&type=' . $order_details ['price_type'];
					$pay_paras = $this->Pay_model->get_pay_paras ( $order_details ['inter_id'], 'weixin' );
					if (! empty ( $pay_paras ['sub_mch_id'] )) {
						$this->Wxpay_model->setParameter ( "sub_openid", $this->session->userdata ( $this->session->userdata ( 'inter_id' ) . 'openid' ) );
						if(!empty($pay_paras['sub_mch_id_h_'.$order_details['hotel_id']]))
							$this->Wxpay_model->setParameter("sub_mch_id",$pay_paras['sub_mch_id_h_'.$order_details['hotel_id']]);
						else
							$this->Wxpay_model->setParameter ( "sub_mch_id", $pay_paras ['sub_mch_id'] );
						$this->Wxpay_model->setParameter ( "mch_id", $pay_paras ['mch_id'] );
					} else {
						$this->Wxpay_model->setParameter ( "openid", $this->session->userdata ( $this->session->userdata ( 'inter_id' ) . 'openid' ) );
						$this->Wxpay_model->setParameter ( "mch_id", $pay_paras ['mch_id'] );
						if (empty ( $pay_paras ['app_id'] )) // new
							$pay_paras ['app_id'] = $public ['app_id'];
					}

					if (isset($pay_paras['hotel_order_goods_tag'])){
						$this->Wxpay_model->setParameter ( "goods_tag", $pay_paras['hotel_order_goods_tag'] ); // 微信立减或优惠券码
					}
					
					$this->Wxpay_model->setParameter ( "body", $order_details ['hname'] . ' - ' .$order_details ['first_detail'] ['roomname'] ); // 商品描述
					$wxpay_reduce = is_null ( $order_details ['wxpay_favour'] ) ? 0 : $order_details ['wxpay_favour'];
					$this->Wxpay_model->setParameter ( "out_trade_no", $pay_orderid ); // 商户订单号
					$this->Wxpay_model->setParameter ( "detail", $order_details ['hname'].'-'.$order_details ['first_detail'] ['roomname'].',单号：'.$order_details ['orderid'] ); // 商品名称明细列表
					$this->Wxpay_model->setParameter ( "total_fee", ($order_details ['price'] - $wxpay_reduce) * 100 ); // 总金额
					$this->Wxpay_model->setParameter ( "notify_url", site_url ( 'Wxpayreturn/hotel_payreturn/'.$order_details ['inter_id'] ) ); // 通知地址
					$this->Wxpay_model->setParameter ( "trade_type", "JSAPI" ); // 交易类型
					//添加订单超时时间 add by ping
					if(isset($pay_paras['outtime']) && $pay_paras['outtime']>=6 && $pay_paras['outtime']<=30){
						$out_time = $pay_paras['outtime'] * 60 + $order_details['order_time'];
					}else{
						$out_time = 900 + $order_details['order_time'];//默认15分钟超时
					}
					$this->Wxpay_model->setParameter ( "time_expire", date('YmdHis',$out_time) ); // 超时时间
					$prepay_id = $this->Wxpay_model->getPrepayId ( $pay_paras );
					$this->Wxpay_model->setPrepayId ( $prepay_id );
					$jsApiObj ["appId"] = $pay_paras ['app_id'];
					$timeStamp =time();
					$jsApiObj ["timeStamp"] = "$timeStamp";
					$jsApiObj ["nonceStr"] = $this->Wxpay_model->createNoncestr ();
					$jsApiObj ["package"] = "prepay_id=$prepay_id";
					$jsApiObj ["signType"] = "MD5";
					$jsApiObj ["paySign"] = $this->Wxpay_model->getSign ( $jsApiObj, $pay_paras );
					$parameters = json_encode ( $jsApiObj );
					$data ['success_url'] = site_url ( 'hotel/hotel/orderdetail' ) . '?id=' . $this->inter_id . '&oid=' . $order_details ['id'];
				}
			}
		}
		$data ['jsApiParameters'] = $parameters;
		$this->display ( 'pay/hotel_order/wxpay', $data );
	}
    function hotel_continue() {
        $this->load->library ( 'MYLOG' ); // 统计探针
        MYLOG::hotel_tracker ( $this->openid, $this->inter_id );
        
        $parameters = '';
        $data = array ();
        $debtid = $this->input->get ( 'debtid', true );
        $data ['fail_url'] = site_url ( 'hotel/hotel/myorder' ) . '?id=' . $this->inter_id;
        $data ['success_url'] = $data ['fail_url'];
        if ($debtid) {
            $this->load->model ( 'wx/Publics_model' );
            $public = $this->Publics_model->get_public_by_id ( $this->inter_id );
            if (! empty ( $public ['app_id'] )) {
                $this->load->model ( 'hotel/Debts_model' );
                $debt = $this->Debts_model->get_debt_by_id ( $this->inter_id, $debtid );
                if ($debt && $debt['debt_state']==0) {
                    $this->load->model ( 'hotel/Order_check_model' );
                    $result = $this->Order_check_model->check_self_continue ( $this->inter_id, $debt ['source_id'], $this->openid, $debt ['sub_ident'] );
                    if ($result ['s'] == 1) {
                        $this->load->model ( 'pay/Wxpay_model' );
                        $this->load->model ( 'pay/Pay_model' );
                        $order = $result ['order'];
                        $data ['fail_url'] = site_url ( 'hotel/hotel/orderdetail' ) . '?id=' . $this->inter_id;
                        $pay_paras = $this->Pay_model->get_pay_paras ( $order ['inter_id'], 'weixin' );
                        if (! empty ( $pay_paras ['sub_mch_id'] )) {
                            $this->Wxpay_model->setParameter ( "sub_openid", $this->openid );
                            if (! empty ( $pay_paras ['sub_mch_id_h_' . $order ['hotel_id']] ))
                                $this->Wxpay_model->setParameter ( "sub_mch_id", $pay_paras ['sub_mch_id_h_' . $order ['hotel_id']] );
                            else
                                $this->Wxpay_model->setParameter ( "sub_mch_id", $pay_paras ['sub_mch_id'] );
                            $this->Wxpay_model->setParameter ( "mch_id", $pay_paras ['mch_id'] );
                        } else {
                            $this->Wxpay_model->setParameter ( "openid", $this->openid );
                            $this->Wxpay_model->setParameter ( "mch_id", $pay_paras ['mch_id'] );
                            if (empty ( $pay_paras ['app_id'] )) 
                                $pay_paras ['app_id'] = $public ['app_id'];
                        }
                        $body = $order ['hname'] . '-' . $order ['orderid'];
                        $body .= empty ( $order ['web_orderid'] ) ? '订单续住' : '/' . $order ['web_orderid'] . '订单续住';
                        $this->load->helper ( 'string' );
                        $body = cubstr ( $body, 0, 127 ); // 微信文档里body长度为128，实际只能到127
                        $this->Wxpay_model->setParameter ( "body", $body ); // 商品描述
                        $this->Wxpay_model->setParameter ( "out_trade_no", $result ['debtid'] ); // 商户订单号
                        $this->Wxpay_model->setParameter ( "detail", $debt ['remark'] ); // 商品名称明细列表
                        $this->Wxpay_model->setParameter ( "total_fee", $debt ['debt_amount'] * 100 ); // 总金额
                        $this->Wxpay_model->setParameter ( "notify_url", site_url ( 'Wxpayreturn/hotel_debt/' . $order ['inter_id'] ) ); // 通知地址
                        $this->Wxpay_model->setParameter ( "trade_type", "JSAPI" ); // 交易类型
                        $prepay_id = $this->Wxpay_model->getPrepayId ( $pay_paras );
                        $this->Wxpay_model->setPrepayId ( $prepay_id );
                        $jsApiObj ["appId"] = $pay_paras ['app_id'];
                        $timeStamp = time ();
                        $jsApiObj ["timeStamp"] = "$timeStamp";
                        $jsApiObj ["nonceStr"] = $this->Wxpay_model->createNoncestr ();
                        $jsApiObj ["package"] = "prepay_id=$prepay_id";
                        $jsApiObj ["signType"] = "MD5";
                        $jsApiObj ["paySign"] = $this->Wxpay_model->getSign ( $jsApiObj, $pay_paras );
                        $parameters = json_encode ( $jsApiObj );
                        $data ['success_url'] = site_url ( 'hotel/hotel/orderdetail' ) . '?id=' . $this->inter_id . '&orderid=' . $debt ['source_id'];
                    }
                }
            }
        }
        $data ['jsApiParameters'] = $parameters;
        $this->display ( 'pay/hotel_order/wxpay', $data );
    }

	public function mall_pay()
	{
		$identity= $this->input->get('t');
		$this->db->where(array(
			                 'order_id'=>$this->input->get('oid'),
			                 'inter_id'=>$this->input->get('id'),
		                 ));
		$this->db->limit(1);
		$order = $this->db->get('shp_orders')->row_array();
		$this->db->where(array('order_id'=>$this->input->get('oid')));
		$this->db->limit(1);
		$oitem = $this->db->get('shp_order_items')->row_array();
		$price = 0;

		if($order){
			$this->load->model('pay/wxpay_model');
			$this->load->model('pay/Pay_model' );
			$this->load->model('wx/publics_model');
			$inter_id = $this->input->get('id');
			$public = $this->publics_model->get_public_by_id($inter_id);
			if(!empty($public['app_id'])){
				$pay_paras=$this->Pay_model->get_pay_paras($inter_id);
				//print_r($pay_paras);die;
				if(isset($pay_paras['sub_mch_id'])){
					$this->wxpay_model->setParameter("sub_openid",$this->session->userdata($inter_id.'openid'));
					$this->wxpay_model->setParameter("sub_mch_id",$pay_paras['sub_mch_id']);
					$this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
				}
				else {
					$this->wxpay_model->setParameter("openid",$this->session->userdata($inter_id.'openid'));
					$this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
					if(empty($pay_paras['app_id'])) //new
						$pay_paras['app_id']=$public['app_id'];
				}

				$this->wxpay_model->setParameter("body", $oitem['gs_name']);//商品描述
				$this->wxpay_model->setParameter("total_fee", $order['total_fee'] * 100);//总金额
				$this->wxpay_model->setParameter("out_trade_no", $order['out_trade_no']);//商户订单号
				$this->wxpay_model->setParameter("notify_url", site_url('wxpayreturn/mall_rtn/'. $inter_id ));//通知地址
				$this->wxpay_model->setParameter("trade_type", "JSAPI");//交易类型
				$prepay_id = $this->wxpay_model->getPrepayId($pay_paras);
				$this->wxpay_model->setPrepayId($prepay_id);
				$jsApiObj["appId"]     = $pay_paras['app_id'];
				$timeStamp             = time();
				$jsApiObj["timeStamp"] = "$timeStamp";
				$jsApiObj["nonceStr"]  = $this->wxpay_model->createNoncestr();
				$jsApiObj["package"]   = "prepay_id=$prepay_id";
				$jsApiObj["signType"]  = "MD5";
				$jsApiObj["paySign"]   = $this->wxpay_model->getSign($jsApiObj,$pay_paras);
				$parameters = json_encode($jsApiObj);
				//$this->vars('oid', $this->input->get('oid'));
			}
			$data ['fail_url'] = site_url( 'mall/wap/pay_error' ). '/'. $this->input->get('oid')
			                     . '?id=' . $this->input->get('id'). '&t='. $identity;
			$data ['success_url'] = site_url( 'mall/wap/pay_success' ). '/'. $this->input->get('oid')
			                        . '?id=' . $this->input->get('id'). '&t='. $identity;
			$data ['jsApiParameters'] = $parameters;
			$this->display ( 'pay/mall_pay/wxpay', $data );

		} else exit('参数错误');
	}

	public function okpay_pay()
	{
		//统计探针
		$this->load->library('MYLOG');
		MYLOG::distribute_tracker($this->session->userdata ( $this->inter_id . 'openid' ),   $this->session->userdata ( 'inter_id' ));
		$this->db->where(array(
			'out_trade_no'=>$this->input->get('oid'),
			'inter_id'=>$this->input->get('id'),
			'hotel_id'=>$this->input->get('hid')
		));
		$this->db->limit(1);
		$order = $this->db->get('okpay_orders')->row_array();

		if(!empty($order) && $order['pay_status'] == 3){
			$data = array();
			$data['id'] = $this->input->get('id');
			$data['hotel_id'] = $this->input->get('hid');
			$data['oid'] = $this->input->get('oid');
			$data['paycode'] = $order['sale'];

			$this->display ('okpay/okpay/pay_redirect', $data);

		}else if($order){
			$this->load->model('pay/wxpay_model');
			$this->load->model('pay/Pay_model' );
			$this->load->model('wx/publics_model');
			$inter_id = $this->input->get('id');
			$public = $this->publics_model->get_public_by_id($inter_id);
			if(!empty($public['app_id'])){
				$pay_paras=$this->Pay_model->get_pay_paras($inter_id);
				//print_r($pay_paras);die;
				if(isset($pay_paras['sub_mch_id'])){
					$this->wxpay_model->setParameter("sub_openid",$this->session->userdata($inter_id.'openid'));
					$this->wxpay_model->setParameter("sub_mch_id",$pay_paras['sub_mch_id']);
					$this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
				}
				else {
					$this->wxpay_model->setParameter("openid",$this->session->userdata($inter_id.'openid'));
					$this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
					if(empty($pay_paras['app_id'])) //new
						$pay_paras['app_id']=$public['app_id'];
				}

				$this->wxpay_model->setParameter("body", "快乐付");//商品描述
				$this->wxpay_model->setParameter("total_fee", $order['pay_money'] * 100);//总金额
				$this->wxpay_model->setParameter("out_trade_no", $order['out_trade_no']);//商户订单号
				$this->wxpay_model->setParameter("notify_url", site_url('wxpayreturn/okpay_rtn/'. $inter_id ));//通知地址
				$this->wxpay_model->setParameter("trade_type", "JSAPI");//交易类型
				$prepay_id = $this->wxpay_model->getPrepayId($pay_paras);
				$this->wxpay_model->setPrepayId($prepay_id);
				$jsApiObj["appId"]     = $pay_paras['app_id'];
				$timeStamp             = time();
				$jsApiObj["timeStamp"] = "$timeStamp";
				$jsApiObj["nonceStr"]  = $this->wxpay_model->createNoncestr();
				$jsApiObj["package"]   = "prepay_id=$prepay_id";
				$jsApiObj["signType"]  = "MD5";
				$jsApiObj["paySign"]   = $this->wxpay_model->getSign($jsApiObj,$pay_paras);
				$parameters = json_encode($jsApiObj);
			}
			$identity = time();
			$data ['fail_url'] = site_url( 'okpay/okpay/pay_error' ).'?id='.$this->input->get('id').'&t='.$identity.'&oid='. $this->input->get('oid');
			$data ['success_url'] = site_url( 'okpay/okpay/pay_success' ).'?id='.$this->input->get('id').'&t='. $identity.'&oid='. $this->input->get('oid');
			$data ['jsApiParameters'] = $parameters;
			$this->display ('pay/mall_pay/wxpay', $data );
		}else{
			exit('参数错误');
		}
	}

    //打赏拉起支付
    public function tips_pay()
    {
        //统计探针
       /* $this->load->library('MYLOG');
        MYLOG::distribute_tracker($this->session->userdata ( $this->inter_id . 'openid' ),   $this->session->userdata ( 'inter_id' ));*/
        $inter_id = addslashes($this->input->get('id'));
        $order_id = (int)$this->input->get('order_id');
        $this->db->where(array(
            'order_id'=>$order_id,
            'inter_id'=>$inter_id,
            'saler'=>(int)$this->input->get('saler'),
        ));
        $this->db->limit(1);
        $order = $this->db->get('tips_orders')->row_array();

        if(!empty($order) && $order['pay_status'] == 2){//已经支付
            redirect(site_url('tips/tips/index?id='.$order['inter_id'].'&saler='.$order['saler']));
            die;
        }else if($order){
            $this->load->model('pay/wxpay_model');
            $this->load->model('pay/Pay_model' );
            $this->load->model('wx/publics_model');
            //$inter_id = $inter_id;
            $public = $this->publics_model->get_public_by_id($inter_id);
            if(!empty($public['app_id'])){
                $pay_paras=$this->Pay_model->get_pay_paras($inter_id);
                //print_r($pay_paras);die;
                if(isset($pay_paras['sub_mch_id'])){
                    $this->wxpay_model->setParameter("sub_openid",$this->session->userdata($inter_id.'openid'));
                    $this->wxpay_model->setParameter("sub_mch_id",$pay_paras['sub_mch_id']);
                    $this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
                }
                else {
                    $this->wxpay_model->setParameter("openid",$this->session->userdata($inter_id.'openid'));
                    $this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
                    if(empty($pay_paras['app_id'])) //new
                        $pay_paras['app_id']=$public['app_id'];
                }

                $this->wxpay_model->setParameter("body", "打赏");//商品描述
                $this->wxpay_model->setParameter("total_fee", $order['pay_money'] * 100);//总金额
                $this->wxpay_model->setParameter("out_trade_no", $order['order_sn']);//商户订单号
                $this->wxpay_model->setParameter("notify_url", site_url('wxpayreturn/tips_rtn/'. $inter_id ));//通知地址
                $this->wxpay_model->setParameter("trade_type", "JSAPI");//交易类型
                $prepay_id = $this->wxpay_model->getPrepayId($pay_paras);
                $this->wxpay_model->setPrepayId($prepay_id);
                $jsApiObj["appId"]     = $pay_paras['app_id'];
                $timeStamp             = time();
                $jsApiObj["timeStamp"] = "$timeStamp";
                $jsApiObj["nonceStr"]  = $this->wxpay_model->createNoncestr();
                $jsApiObj["package"]   = "prepay_id=$prepay_id";
                $jsApiObj["signType"]  = "MD5";
                $jsApiObj["paySign"]   = $this->wxpay_model->getSign($jsApiObj,$pay_paras);
                $parameters = json_encode($jsApiObj);
            }
            $identity = time();
            if($inter_id == 'a429262687' || $inter_id=='a429262687'){
                $data ['fail_url'] = site_url( 'subatips/tips/pay_res' ).'?id='.$inter_id.'&t='.$identity.'&order_id='. $order_id;
            }else{
                $data ['fail_url'] = site_url( 'tips/tips/pay_res' ).'?id='.$inter_id.'&t='.$identity.'&order_id='. $order_id;
            }
            $data ['success_url'] = $data ['fail_url'];
            $data ['jsApiParameters'] = $parameters;
            $this->display ('pay/mall_pay/wxpay', $data );
        }else{
            exit('参数错误');
        }
    }

	public function member_pay()
	{
		$type = $this->input->post('type');
		if($type && $type=='card') {
			$this->load->model('member/icardorder');
			$order = $this->icardorder->getCardOrderByOrderNumber($this->input->post('out_trade_no'));
		} else {
			$this->load->model('member/ichargeorder');
			$order = $this->ichargeorder->getChargeOrderByOrderNumber($this->input->post('out_trade_no'));
		}
		if($order){
			$this->load->model('pay/wxpay_model');
			$this->load->model ('pay/Pay_model' );
			$this->load->model('wx/publics_model');
			$inter_id = $this->input->get('id');
			$public = $this->publics_model->get_public_by_id($inter_id);
			if(!empty($public['app_id'])){
				$pay_paras=$this->Pay_model->get_pay_paras($inter_id);
				//print_r($pay_paras);die;
				if(isset($pay_paras['sub_mch_id'])){
					$this->wxpay_model->setParameter("sub_openid",$this->session->userdata($inter_id.'openid'));
					$this->wxpay_model->setParameter("sub_mch_id",$pay_paras['sub_mch_id']);
					$this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
				}
				else {
					$this->wxpay_model->setParameter("openid",$this->session->userdata($inter_id.'openid'));
					$this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
					if(empty($pay_paras['app_id'])) //new
						$pay_paras['app_id']=$public['app_id'];
				}

				$this->wxpay_model->setParameter("body", $this->input->post('body'));//商品描述
				$this->wxpay_model->setParameter("total_fee", $this->input->post('total_fee') * 100);//总金额
				$this->wxpay_model->setParameter("out_trade_no", $this->input->post('out_trade_no'));//商户订单号
				$this->wxpay_model->setParameter("notify_url", $this->input->post('notify_url'));//通知地址
				$this->wxpay_model->setParameter("trade_type", "JSAPI");//交易类型
				$prepay_id = $this->wxpay_model->getPrepayId($pay_paras);
				$this->wxpay_model->setPrepayId($prepay_id);
				$jsApiObj["appId"]     = $pay_paras['app_id'];
				$timeStamp             = time();
				$jsApiObj["timeStamp"] = "$timeStamp";
				$jsApiObj["nonceStr"]  = $this->wxpay_model->createNoncestr();
				$jsApiObj["package"]   = "prepay_id=$prepay_id";
				$jsApiObj["signType"]  = "MD5";
				$jsApiObj["paySign"]   = $this->wxpay_model->getSign($jsApiObj,$pay_paras);
				$parameters = json_encode($jsApiObj);
			}

			$data ['fail_url'] = site_url('member/center');
			$data ['success_url'] = site_url('member/center');
			$data ['jsApiParameters'] = $parameters;
			$this->display ('pay/mall_pay/wxpay', $data );

		} else exit('参数错误');
	}

	//新版會員支付方法
	public function vip_pay(){
		$inter_id = $this->inter_id;
		$openid = $this->openid;
		$orderId = $this->input->get('orderId')?(int)$this->input->get('orderId'):0;
		$token = $this->get_Member_Token();
		//获取验证的
		//获取订单的详细信息
		$post_order_info = INTER_PATH_URL.'depositorder/get_order';
		$post_order_data = array(
			'inter_id'=>$inter_id,
			'openid'=>$openid,
			'orderId'=>$orderId,
			'token'=>$token,
		);
		$order_info = $this->doCurlPostRequest( $post_order_info , $post_order_data );
		if(isset($order_info['err'])){
			echo 'empty order info';exit;
		}else{
			$order_info = $order_info['data'];
		}
		//获取支付订单的详细信息
		if($orderId){
			$this->load->model('pay/wxpay_model');
			$this->load->model ('pay/Pay_model' );
			$this->load->model('wx/publics_model');
			$public = $this->publics_model->get_public_by_id($inter_id);
			if(!empty($public['app_id'])){
				$pay_paras=$this->Pay_model->get_pay_paras($inter_id);
				//print_r($pay_paras);die;
				if(isset($pay_paras['sub_mch_id'])){
					$this->wxpay_model->setParameter("sub_openid",$this->session->userdata($inter_id.'openid'));
					$this->wxpay_model->setParameter("sub_mch_id",$pay_paras['sub_mch_id']);
					$this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
				}
				else {
					$this->wxpay_model->setParameter("openid",$this->session->userdata($inter_id.'openid'));
					$this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
					if(empty($pay_paras['app_id'])) //new
						$pay_paras['app_id']=$public['app_id'];
				}
				$this->wxpay_model->setParameter("body", '订单号码：'.$order_info['order_num'].'会员充值');//商品描述
				$this->wxpay_model->setParameter("total_fee", $order_info['pay_money'] * 100);//总金额
				$this->wxpay_model->setParameter("out_trade_no", $order_info['order_num']);//商户订单号
				$this->wxpay_model->setParameter("notify_url", site_url("wxpayreturn/vipokpay/".$inter_id."/".$openid."/".$orderId));//通知地址
//                base_url("index.php/membervip/depositcard/pay?orderId=".$orderId);
				$this->api_write_log(site_url("wxpayreturn/vipokpay/".$inter_id."/".$openid."/".$orderId),'RETURN');
				$this->wxpay_model->setParameter("trade_type", "JSAPI");//交易类型
				$prepay_id = $this->wxpay_model->getPrepayId($pay_paras);
				$this->wxpay_model->setPrepayId($prepay_id);
				$jsApiObj["appId"]     = $pay_paras['app_id'];
				$timeStamp             = time();
				$jsApiObj["timeStamp"] = "$timeStamp";
				$jsApiObj["nonceStr"]  = $this->wxpay_model->createNoncestr();
				$jsApiObj["package"]   = "prepay_id=$prepay_id";
				$jsApiObj["signType"]  = "MD5";
				$jsApiObj["paySign"]   = $this->wxpay_model->getSign($jsApiObj,$pay_paras);
				$parameters = json_encode($jsApiObj);
			}
			$pay_data = array(
				'orderId'=>$orderId,
				'interId'=>$inter_id,
				'orderNum'=>$order_info['order_num'],
				'orderMoney'=>$order_info['pay_money'],
			);
			$pay_data = http_build_query($pay_data);
			$data ['fail_url'] = site_url('membervip/depositcard/nopay?'.$pay_data);
			$data ['success_url'] = site_url('membervip/depositcard/okpay?'.$pay_data);
			$data ['jsApiParameters'] = $parameters;
			$this->display ('pay/mall_pay/wxpay', $data );
		}else{
			echo json_encode(array('err'=>40003,'msg'=>'参数错误'));
		}
	}



	public function soma_pay()
	{	/*
	    $inter_id= $this->inter_id;
	    $openid= $this->openid;
	    $url= site_url('soma/payment/wxppay_invoke'). "?". $_SERVER['QUERY_STRING']. "&inter_id=$inter_id&openid=$openid";
	    redirect($url); */

		$this->load->somaDatabase($this->db_soma);
		$this->load->somaDatabaseRead($this->db_soma_read);

		MYLOG::soma_tracker($this->session->userdata ( $this->inter_id . 'openid' ),   $this->session->userdata ( 'inter_id' ));
		//初始化数据库分片配置
		if( $this->inter_id ){
			$this->load->model('soma/shard_config_model', 'model_shard_config');
			$this->current_inter_id= $this->inter_id;
			$this->db_shard_config= $this->model_shard_config->build_shard_config($this->inter_id);
			//print_r($this->db_shard_config);
		}

		$order_id= $this->input->get('order_id');
		$inter_id= $this->inter_id;
		$openid= $this->openid;

		$this->load->model('soma/Sales_order_model');
		$order_detail= $this->Sales_order_model->get_order_simple($order_id);

		//$where = array('order_id' => $order_id);
		//$table = $this->Sales_order_model->table_name($inter_id);
		//$order_detail = $this->Sales_order_model->_shard_db($inter_id)->where($where)->get($table)->row_array();
		//$order_detail= $this->Sales_order_model->find(array('order_id'=> $order_id));

		if( $order_id && $inter_id && $openid && $order_detail ){
			$this->load->model('pay/wxpay_model');
			$this->load->model('pay/pay_model' );
			$this->load->model('wx/publics_model');
			$public = $this->publics_model->get_public_by_id($inter_id);

			if(!empty($public['app_id'])){
				$pay_paras=$this->pay_model->get_pay_paras($inter_id);

				if( isset($pay_paras['sub_mch_id']) && !empty($pay_paras['sub_mch_id']) ){
					$this->wxpay_model->setParameter("sub_openid", $openid);
					$this->wxpay_model->setParameter("mch_id", $pay_paras['mch_id']);
					$this->wxpay_model->setParameter("sub_mch_id", $pay_paras['sub_mch_id']);

					//自商户分账-----------
					if( !empty($pay_paras['sub_mch_id_h_'. $order_detail['hotel_id']]) ){
						$this->wxpay_model->setParameter("sub_mch_id", $pay_paras['sub_mch_id_h_'. $order_detail['hotel_id']] );
					}

				} else {
					$this->wxpay_model->setParameter("openid", $openid);
					$this->wxpay_model->setParameter("mch_id", $pay_paras['mch_id']);
					if(empty($pay_paras['app_id'])) //new
						$pay_paras['app_id']= $public['app_id'];
				}

				$this->load->model('soma/Sales_order_model');
				$business_type= $this->Sales_order_model->get_business_type();  //各种业务类型中文标识：套票|

				if( defined('PROJECT_AREA') && PROJECT_AREA=='mooncake' )
					$business_type= '月饼';

				$settle_type= $this->Sales_order_model->get_settle_label();  //各种结算方式中文标识：普通购买|拼团购买
				$order_desc= $public['name']. '_';
				$order_desc.= array_key_exists($order_detail['business'], $business_type)? $business_type[$order_detail['business']]: '';
				$order_desc.= array_key_exists($order_detail['settlement'], $settle_type)? $settle_type[$order_detail['settlement']]: '';
				$order_desc.= '#'. $order_id;

				if( $order_detail['settlement']== Sales_order_model::SETTLE_KILLSEC ){
					//对于秒杀限定其支付有效期
					$this->wxpay_model->setParameter("time_expire", date('YmdHis', strtotime('+5 minutes')));
				} else {
                    $this->wxpay_model->setParameter("time_expire", date('YmdHis', strtotime('+10 minutes')));
                }

				$wx_order_id= $this->Sales_order_model->wx_out_trade_no_encode($order_id, $order_detail['settlement'], $order_detail['business']);
				$this->wxpay_model->setParameter("body", $order_desc);//商品描述
				$this->wxpay_model->setParameter("total_fee", $order_detail['grand_total']* 100 );//总金额
				$this->wxpay_model->setParameter("out_trade_no", $wx_order_id );//商户订单号
				$this->wxpay_model->setParameter("notify_url", Soma_const_url::inst()->get_payment_return() .'/'. $order_id );//通知地址
				$this->wxpay_model->setParameter("trade_type", "JSAPI");//交易类型
				$prepay_id = $this->wxpay_model->getPrepayId($pay_paras);
				$this->wxpay_model->setPrepayId($prepay_id);

				$jsApiObj["appId"]     = $pay_paras['app_id'];
				$jsApiObj["timeStamp"] = (string) time();
				$jsApiObj["nonceStr"]  = $this->wxpay_model->createNoncestr();
				$jsApiObj["package"]   = "prepay_id=$prepay_id";
				$jsApiObj["signType"]  = "MD5";
				$jsApiObj["paySign"]   = $this->wxpay_model->getSign($jsApiObj, $pay_paras);
				$parameters = json_encode($jsApiObj);
				//print_r($parameters);die;
			}

			$urlParams = array(
				'id'=> $inter_id,
				'order_id'=> $order_id,
				'settlement'=>$order_detail['settlement']
			);

			$successUrl = Soma_const_url::inst()->get_payment_success($order_detail['business'],$urlParams);

			$buyType= $this->input->get('bType');
			if(empty($buyType)){
				$data['success_url'] = $successUrl;
			}else{
				$data['success_url'] = $this->Sales_order_model->success_payment_path($inter_id,$buyType,$order_detail,$successUrl);

			}

			if($this->input->get('wxpay_order_type') == 2) {
				// 邮费订单，成功跳转链接为邮寄详情
				$spid = $this->session->userdata('spid');
				if( false && $spid ){	
					$data['success_url'] = Soma_const_url::inst()->get_url('soma/consumer/shipping_detail', array('id'=> $inter_id, 'spid'=>$spid ) );
				}else{
					$data['success_url'] = Soma_const_url::inst()->get_url('soma/consumer/my_shipping_list', array('id'=> $inter_id ) );
				}
			}

			$data['fail_url'] = Soma_const_url::inst()->get_payment_fail($order_detail['business'], $urlParams);
			$data['jsApiParameters'] = $parameters;
			$this->display ( 'pay/soma_pay/wxpay', $data );

		} else
			exit('参数错误，微信支付失败');
	}

	public function chat_pay()
	{
		$body = $this->input->post('body');
		$total_fee = $this->input->post('total_fee');
		$out_trade_no = $this->input->post('out_trade_no');
		$notify_url = $this->input->post('notify_url');
		$fail_url = $this->input->post('fail_url');
		$success_url = $this->input->post('success_url');

		if($out_trade_no){
			$this->load->model('pay/wxpay_model');
			$this->load->model ('pay/Pay_model' );
			$this->load->model('wx/publics_model');
			$inter_id = $this->input->get('id');
			$public = $this->publics_model->get_public_by_id($inter_id);
			if(!empty($public['app_id'])){
				$pay_paras=$this->Pay_model->get_pay_paras($inter_id);
				//print_r($pay_paras);die;
				if(isset($pay_paras['sub_mch_id'])){
					$this->wxpay_model->setParameter("sub_openid",$this->session->userdata($inter_id.'openid'));
					$this->wxpay_model->setParameter("sub_mch_id",$pay_paras['sub_mch_id']);
					$this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
				}
				else {
					$this->wxpay_model->setParameter("openid",$this->session->userdata($inter_id.'openid'));
					$this->wxpay_model->setParameter("mch_id",$pay_paras['mch_id']);
					if(empty($pay_paras['app_id'])) //new
						$pay_paras['app_id']=$public['app_id'];
				}

				$this->wxpay_model->setParameter("body", $body);//商品描述
				$this->wxpay_model->setParameter("total_fee", $total_fee);//总金额
				$this->wxpay_model->setParameter("out_trade_no", $out_trade_no);//商户订单号
				$this->wxpay_model->setParameter("notify_url", $notify_url);//通知地址
				$this->wxpay_model->setParameter("trade_type", "JSAPI");//交易类型
				$prepay_id = $this->wxpay_model->getPrepayId($pay_paras);
				$this->wxpay_model->setPrepayId($prepay_id);
				$jsApiObj["appId"]     = $pay_paras['app_id'];
				$timeStamp             = time();
				$jsApiObj["timeStamp"] = "$timeStamp";
				$jsApiObj["nonceStr"]  = $this->wxpay_model->createNoncestr();
				$jsApiObj["package"]   = "prepay_id=$prepay_id";
				$jsApiObj["signType"]  = "MD5";
				$jsApiObj["paySign"]   = $this->wxpay_model->getSign($jsApiObj,$pay_paras);
				$parameters = json_encode($jsApiObj);
			}

			$data ['fail_url'] = $fail_url;
			$data ['success_url'] = $success_url;
			$data ['jsApiParameters'] = $parameters;
			$this->display ('pay/mall_pay/wxpay', $data );

		} else exit('参数错误');
	}

	//订餐支付请求
	public function roomservice_pay()
	{
		//统计探针
		$this->load->library('MYLOG');
		MYLOG::distribute_tracker($this->session->userdata ( $this->inter_id . 'openid' ),   $this->session->userdata ( 'inter_id' ));

		$order_id= $this->input->get('order_id');
		$inter_id= $this->inter_id;
		$openid= $this->openid;

		$this->load->model('roomservice/roomservice_orders_model');
		$order_detail= $this->roomservice_orders_model->get_order_simple(array('inter_id'=>$inter_id,'openid'=>$openid,'order_id'=>$order_id,'pay_status'=>'unpay'));

		if( $order_id && $inter_id && $openid && $order_detail ){
			$this->load->model('pay/wxpay_model');
			$this->load->model('pay/pay_model' );
			$this->load->model('wx/publics_model');
			$public = $this->publics_model->get_public_by_id($inter_id);

			if(!empty($public['app_id'])){
				$pay_paras=$this->pay_model->get_pay_paras($inter_id);

				if( isset($pay_paras['sub_mch_id']) && !empty($pay_paras['sub_mch_id']) ){
					$this->wxpay_model->setParameter("sub_openid", $openid);
					$this->wxpay_model->setParameter("mch_id", $pay_paras['mch_id']);
					$this->wxpay_model->setParameter("sub_mch_id", $pay_paras['sub_mch_id']);

				} else {
					$this->wxpay_model->setParameter("openid", $openid);
					$this->wxpay_model->setParameter("mch_id", $pay_paras['mch_id']);
					if(empty($pay_paras['app_id'])) //new
						$pay_paras['app_id']= $public['app_id'];
				}

				$order_desc= $public['name']. '_微服务订单';
				$order_desc.= '#'. $order_detail['order_sn'];

				$this->wxpay_model->setParameter("body", $order_desc);//商品描述
				$this->wxpay_model->setParameter("total_fee", $order_detail['sub_total']* 100 );//总金额
				$this->wxpay_model->setParameter("out_trade_no", $order_detail['order_sn'] );//商户订单号
				$this->wxpay_model->setParameter("notify_url", site_url('wxpayreturn/roomservice_rtn/'. $inter_id ) );//通知地址
				$this->wxpay_model->setParameter("trade_type", "JSAPI");//交易类型
				$prepay_id = $this->wxpay_model->getPrepayId($pay_paras);
				$this->wxpay_model->setPrepayId($prepay_id);

				$jsApiObj["appId"]     = $pay_paras['app_id'];
				$jsApiObj["timeStamp"] = (string) time();
				$jsApiObj["nonceStr"]  = $this->wxpay_model->createNoncestr();
				$jsApiObj["package"]   = "prepay_id=$prepay_id";
				$jsApiObj["signType"]  = "MD5";
				$jsApiObj["paySign"]   = $this->wxpay_model->getSign($jsApiObj, $pay_paras);
				$parameters = json_encode($jsApiObj);
				//print_r($parameters);die;
			}
			$identity = time();
			$data ['fail_url'] = site_url( 'roomservice/roomservice/order_detail' ).'?id='.$inter_id.'&t='.$identity.'&oid='. $order_id;
			$data ['success_url'] = site_url( 'roomservice/roomservice/order_detail' ).'?id='.$inter_id.'&t='. $identity.'&oid='. $order_id;

			$data['jsApiParameters'] = $parameters;
			$this->display ( 'pay/soma_pay/wxpay', $data );

		} else
			exit('参数错误，微信支付失败');
	}


    //门票支付请求
    public function ticket_pay()
    {
        //统计探针
        $this->load->library('MYLOG');
        MYLOG::distribute_tracker($this->session->userdata ( $this->inter_id . 'openid' ),   $this->session->userdata ( 'inter_id' ));

        $order_id= $this->input->get('order_id');
        $inter_id= $this->inter_id;
        $openid= $this->openid;

        $this->load->model('roomservice/roomservice_orders_model');
        $order_detail= $this->roomservice_orders_model->get_order_simple(array('inter_id'=>$inter_id,'openid'=>$openid,'order_id'=>$order_id,'pay_status'=>'unpay'));

        if( $order_id && $inter_id && $openid && $order_detail ){
            $this->load->model('pay/wxpay_model');
            $this->load->model('pay/pay_model' );
            $this->load->model('wx/publics_model');
            $public = $this->publics_model->get_public_by_id($inter_id);

            if(!empty($public['app_id'])){
                $pay_paras=$this->pay_model->get_pay_paras($inter_id);

                if( isset($pay_paras['sub_mch_id']) && !empty($pay_paras['sub_mch_id']) ){
                    $this->wxpay_model->setParameter("sub_openid", $openid);
                    $this->wxpay_model->setParameter("mch_id", $pay_paras['mch_id']);
                    $this->wxpay_model->setParameter("sub_mch_id", $pay_paras['sub_mch_id']);

                } else {
                    $this->wxpay_model->setParameter("openid", $openid);
                    $this->wxpay_model->setParameter("mch_id", $pay_paras['mch_id']);
                    if(empty($pay_paras['app_id'])) //new
                        $pay_paras['app_id']= $public['app_id'];
                }

                $order_desc= $public['name']. '_微服务订单';
                $order_desc.= '#'. $order_detail['order_sn'];

                $this->wxpay_model->setParameter("body", $order_desc);//商品描述
                $this->wxpay_model->setParameter("total_fee", $order_detail['sub_total']* 100 );//总金额
                $this->wxpay_model->setParameter("out_trade_no", $order_detail['order_sn'] );//商户订单号
                $this->wxpay_model->setParameter("notify_url", site_url('wxpayreturn/ticket_rtn/'. $inter_id ) );//通知地址
                $this->wxpay_model->setParameter("trade_type", "JSAPI");//交易类型
                $prepay_id = $this->wxpay_model->getPrepayId($pay_paras);
                $this->wxpay_model->setPrepayId($prepay_id);

                $jsApiObj["appId"]     = $pay_paras['app_id'];
                $jsApiObj["timeStamp"] = (string) time();
                $jsApiObj["nonceStr"]  = $this->wxpay_model->createNoncestr();
                $jsApiObj["package"]   = "prepay_id=$prepay_id";
                $jsApiObj["signType"]  = "MD5";
                $jsApiObj["paySign"]   = $this->wxpay_model->getSign($jsApiObj, $pay_paras);
                $parameters = json_encode($jsApiObj);
                //print_r($parameters);die;
            }
            $identity = time();
            $data ['fail_url'] = site_url( 'ticket/ticket/order_detail' ).'?id='.$inter_id.'&t='.$identity.'&oid='. $order_id;
            $data ['success_url'] = site_url( 'ticket/ticket/order_detail' ).'?id='.$inter_id.'&t='. $identity.'&oid='. $order_id;

            $data['jsApiParameters'] = $parameters;
            $this->display ( 'pay/soma_pay/wxpay', $data );

        } else
            exit('参数错误，微信支付失败');
    }


    //预约核销支付请求
    public function ticket_book_pay()
    {
        //统计探针
        $this->load->library('MYLOG');
        MYLOG::distribute_tracker($this->session->userdata ( $this->inter_id . 'openid' ),   $this->session->userdata ( 'inter_id' ));

        $order_id= $this->input->get('order_id');
        $inter_id= $this->inter_id;
        $openid= $this->openid;

        $this->load->model('ticket/ticket_orders_merge_model');
        $order_detail= $this->ticket_orders_merge_model->get_order_info(array('inter_id'=>$inter_id,'openid'=>$openid,'order_id'=>$order_id));

        if (!empty($order_detail) && $order_detail['pay_status'] > 0)
        {
            die('已成功支付，请不要重复支付订单');
        }
        if( $order_id && $inter_id && $openid && $order_detail )
        {
            $this->load->model('pay/wxpay_model');
            $this->load->model('pay/pay_model' );
            $this->load->model('wx/publics_model');
            $public = $this->publics_model->get_public_by_id($inter_id);

            if(!empty($public['app_id'])){
                $pay_paras=$this->pay_model->get_pay_paras($inter_id);

                if( isset($pay_paras['sub_mch_id']) && !empty($pay_paras['sub_mch_id']) ){
                    $this->wxpay_model->setParameter("sub_openid", $openid);
                    $this->wxpay_model->setParameter("mch_id", $pay_paras['mch_id']);
                    $this->wxpay_model->setParameter("sub_mch_id", $pay_paras['sub_mch_id']);

                } else {
                    $this->wxpay_model->setParameter("openid", $openid);
                    $this->wxpay_model->setParameter("mch_id", $pay_paras['mch_id']);
                    if(empty($pay_paras['app_id'])) //new
                        $pay_paras['app_id']= $public['app_id'];
                }

                $order_desc= $public['name']. '_微服务订单';
                $order_desc.= '#'. $order_detail['order_no'];

                $this->wxpay_model->setParameter("body", $order_desc);//商品描述
                $this->wxpay_model->setParameter("total_fee", $order_detail['pay_fee']* 100 );//总金额
                $this->wxpay_model->setParameter("out_trade_no", $order_detail['order_no'] );//商户订单号
                $this->wxpay_model->setParameter("notify_url", site_url('wxpayreturn/ticket_book_rtn/'. $inter_id ) );//通知地址
                $this->wxpay_model->setParameter("trade_type", "JSAPI");//交易类型
                $prepay_id = $this->wxpay_model->getPrepayId($pay_paras);
                $this->wxpay_model->setPrepayId($prepay_id);

                $jsApiObj["appId"]     = $pay_paras['app_id'];
                $jsApiObj["timeStamp"] = (string) time();
                $jsApiObj["nonceStr"]  = $this->wxpay_model->createNoncestr();
                $jsApiObj["package"]   = "prepay_id=$prepay_id";
                $jsApiObj["signType"]  = "MD5";
                $jsApiObj["paySign"]   = $this->wxpay_model->getSign($jsApiObj, $pay_paras);
                $parameters = json_encode($jsApiObj);
                //print_r($parameters);die;
            }
            $identity = time();
            $data ['fail_url'] = site_url( 'ticket/book/order_detail' ).'?id='.$inter_id.'&hotel_id='.$order_detail['hotel_id'].'&shop_id='.$order_detail['shop_id'].'&t='.$identity.'&order_id='. $order_id;
            $data ['success_url'] = site_url( 'ticket/book/order_detail' ).'?id='.$inter_id.'&hotel_id='.$order_detail['hotel_id'].'&shop_id='.$order_detail['shop_id'].'&t='. $identity.'&order_id='. $order_id;

            $data['jsApiParameters'] = $parameters;
            $this->display ( 'pay/soma_pay/wxpay', $data );

        } else
            exit('参数错误，微信支付失败');
    }

    /**
     * 金陵彩虹跑 活动报名支付
     * author:沙沙
     */
    public function activity_rainbowRun_pay()
    {
        //统计探针
        $this->load->library('MYLOG');
        MYLOG::distribute_tracker($this->session->userdata ( $this->inter_id . 'openid' ),   $this->session->userdata ( 'inter_id' ));

        $order_no = $this->input->get('order_no');
        $inter_id = $this->inter_id;
        $openid= $this->openid;

        $this->load->model('activity/rainbowRun_order_model');
        $filter['order_no'] = $order_no;
        $filter['openid'] = $openid;
        $order_detail = $this->rainbowRun_order_model->get_one($filter);
        if (!empty($order_detail) && $order_detail['pay_status'] > 0)
        {
            redirect(site_url('activity/rainbowRun/detail?id='.$this->inter_id));
            die('已成功支付，请不要重复支付订单');
        }
        if($order_no && $inter_id && $openid && $order_detail)
        {
            $this->load->model('pay/wxpay_model');
            $this->load->model('pay/pay_model' );
            $this->load->model('wx/publics_model');
            $public = $this->publics_model->get_public_by_id($inter_id);

            if(!empty($public['app_id']))
            {
                $pay_paras = $this->pay_model->get_pay_paras($inter_id);

                if( isset($pay_paras['sub_mch_id']) && !empty($pay_paras['sub_mch_id']) ){
                    $this->wxpay_model->setParameter("sub_openid", $openid);
                    $this->wxpay_model->setParameter("mch_id", $pay_paras['mch_id']);
                    $this->wxpay_model->setParameter("sub_mch_id", $pay_paras['sub_mch_id']);

                } else {
                    $this->wxpay_model->setParameter("openid", $openid);
                    $this->wxpay_model->setParameter("mch_id", $pay_paras['mch_id']);
                    if(empty($pay_paras['app_id'])) //new
                        $pay_paras['app_id']= $public['app_id'];
                }

                $order_desc= $public['name']. '_彩虹跑订单';
                $order_desc.= '#'. $order_detail['order_no'];

                $this->wxpay_model->setParameter("body", $order_desc);//商品描述
                $this->wxpay_model->setParameter("total_fee", $order_detail['pay_fee'] * 100 );//总金额
                $this->wxpay_model->setParameter("out_trade_no", $order_detail['order_no'] );//商户订单号
                $this->wxpay_model->setParameter("notify_url", site_url('wxpayreturn/activity_rainbowRun_rtn/'. $inter_id ) );//通知地址
                $this->wxpay_model->setParameter("trade_type", "JSAPI");//交易类型
                $prepay_id = $this->wxpay_model->getPrepayId($pay_paras);
                $this->wxpay_model->setPrepayId($prepay_id);

                $jsApiObj["appId"]     = $pay_paras['app_id'];
                $jsApiObj["timeStamp"] = (string) time();
                $jsApiObj["nonceStr"]  = $this->wxpay_model->createNoncestr();
                $jsApiObj["package"]   = "prepay_id=$prepay_id";
                $jsApiObj["signType"]  = "MD5";
                $jsApiObj["paySign"]   = $this->wxpay_model->getSign($jsApiObj, $pay_paras);
                $parameters = json_encode($jsApiObj);
            }

            $identity = time();
            $data ['fail_url'] = site_url( 'activity/rainbowRun/index' ).'?id='.$inter_id.'&t='.$identity.'&order_no='. $order_no;
            $data ['success_url'] = site_url( 'activity/rainbowRun/success' ).'?id='.$inter_id .'&t='. $identity.'&order_no='. $order_no;

            $data['jsApiParameters'] = $parameters;
            $this->display('pay/soma_pay/wxpay', $data);
        }
        else
        {
            exit('参数错误，微信支付失败');
        }
    }


	/**
	 * 封装curl的调用接口，post的请求方式
	 * @param string URL
	 * @param string POST表单值
	 * @param array 扩展字段值
	 * @param second 超时时间
	 * @return 请求成功返回成功结构，否则返回FALSE
	 */
	protected function doCurlPostRequest( $url , $post_data , $timeout = 5) {
		$requestString = http_build_query($post_data);
		if ($url == "" || $timeout <= 0) {
			return false;
		}
		$curl = curl_init();
		//设置抓取的url
		curl_setopt($curl, CURLOPT_URL, $url);
		//设置头文件的信息作为数据流输出
		curl_setopt($curl, CURLOPT_HEADER, false);
		//设置获取的信息以文件流的形式返回，而不是直接输出。
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		//設置請求數據返回的過期時間
		curl_setopt ( $curl, CURLOPT_TIMEOUT, ( int ) $timeout );
		//设置post方式提交
		curl_setopt($curl, CURLOPT_POST, true);
		//设置post数据
		curl_setopt($curl, CURLOPT_POSTFIELDS, $requestString);
		//执行命令
		$res = curl_exec($curl);
		//关闭URL请求
		curl_close($curl);
		//写入日志
		$log_data = array(
			'url'=>$url,
			'post_data'=>$post_data,
			'result'=>$res,
		);
		$this->api_write_log(serialize($log_data) );
		return json_decode($res,true);
	}

	/**
	 * 把请求/返回记录记入文件
	 * @param String content
	 * @param String type
	 */
	protected function api_write_log( $content, $type='request' )
	{
		$file= date('Y-m-d_H'). '.txt';
		$path= APPPATH. 'logs'. DS. 'front'. DS. 'membervip'. DS;
		if( !file_exists($path) ) {
			@mkdir($path, 0777, TRUE);
		}
		$CI = & get_instance();
		$ip= $CI->input->ip_address();
		$fp = fopen( $path. $file, 'a');

		$content= str_repeat('-', 40). "\n[". $type. ' : '. date('Y-m-d H:i:s'). ' : '. $ip. ']'
		          . "\n". $content. "\n";
		fwrite($fp, $content);
		fclose($fp);
	}
	//获取授权token
	protected function get_Member_Token(){
		$post_token_data = array(
			'id'=>'vip',
			'secret'=>'iwide30vip',
		);
		$token_info = $this->doCurlPostRequest( INTER_PATH_URL."accesstoken/get" , $post_token_data );
		return isset($token_info['data'])?$token_info['data']:"";
	}

}

/* End of file Wxpaytest.php */
/* Location: ./application/controllers/Wxpaytest.php */