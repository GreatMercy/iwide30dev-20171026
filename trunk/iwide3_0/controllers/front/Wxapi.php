<?php
class Wxapi extends My_Controller {
	private $token;

	//当前公众号id
	private $wx_master_id;


	function __construct() {
		parent::__construct ();
		$this->output->enable_profiler ( FALSE );
		$this->token = $this->input->get('id' ); // 公众号内部ID
	}

	public function index() {

		$echostr = $this->input->get ( 'echostr' );
		$content = file_get_contents ( 'php://input' );
		if (!empty($echostr)){
			if ($this->checkSignature()) {
				echo $echostr;
			} else {
				echo 'Error';
			}
		} else {
			$this->load->model ( 'wx/Weixin_model' );
			$data = $this->Weixin_model->getData();

			$this->db->insert('weixin_text',array('content'=>json_encode($data),'edit_date'=>date('Y-m-d H:i:s')));

				
			if($this->uri->segment(3)){
				$this->load->model('wx/publics_model');
				$p_info = $this->publics_model->get_public_by_id($this->uri->segment(3), 'app_id');
				$this->token = isset($p_info['inter_id']) ? $p_info['inter_id'] : '';
			}
			//富林酒店定制：记录公众号id,用于富林酒店wifi连接
			$this->wx_master_id = $data['ToUserName'];
				
			$content_arr = $this->reply($data);

			// $content_arr = $this->weixin->reply();
			// 回复类型 0：文本,1：图文,2：多图文,3：语音
			if (is_array ( $content_arr )) {
				if (isset($content_arr [1]) && $content_arr [1] == 'text') {
					$this->Weixin_model->replyText ( $content_arr[0][0] ['Description'] );
					// 					$this->db->insert('weixin_text_record',array('msg_type'=>$content_arr [1],'openid'=>$data['FromUserName'],'content'=>json_encode($content_arr),'inter_id'=>$this->token,'type'=>'reply','record_time'=>date('Y-m-d H:i:s')));
				} else if (isset($content_arr [1]) && $content_arr [1] == 'news') {
					$this->Weixin_model->replyNews ( $content_arr [0] );
					// 					$this->db->insert('weixin_text_record',array('msg_type'=>$content_arr [1],'openid'=>$data['FromUserName'],'content'=>json_encode($content_arr),'inter_id'=>$this->token,'type'=>'reply','record_time'=>date('Y-m-d H:i:s')));
				}else{
					echo 'success';
				}
			} else {
				// $this->Weixin_model->replyText ( '无效的二维码' );
				// 				$this->Weixin_model->replyText ( '' );
				echo 'success';
				// 				$this->db->insert('weixin_text_record',array('msg_type'=>$content_arr [1],'openid'=>$data['FromUserName'],'content'=>'无效的二维码'.json_encode($content_arr),'inter_id'=>$this->token,'type'=>'reply','record_time'=>date('Y-m-d H:i:s')));
			}
		}
	}
	private function reply($data) {

		$this->load->model ( 'wx/Weixin_model' );
		// 		$this->db->insert('weixin_text',array('content'=>json_encode($data),'edit_date'=>date('Y-m-d H:i:s')));
		// 		$this->db->insert('weixin_text_record',array('msg_type'=>$data ['MsgType'],'event'=>$data['Event'],'openid'=>$data['FromUserName'],'content'=>json_encode($data),'inter_id'=>$this->token,'type'=>'receive','record_time'=>date('Y-m-d H:i:s')));
		//第三方平台全网发布监测 ---
		//第三方平台自动化测试公众号appid:wx570bc396a51b8ff8,Username:gh_3c884a361561
		if($this->uri->segment(3) == 'wx570bc396a51b8ff8'){
			/*
			 * 1、模拟粉丝触发专用测试公众号的事件，并推送事件消息到专用测试公众号，第三方平台方开发者需要提取推送XML信息中的event值，并在5秒内立即返回按照下述要求组装的文本消息给粉丝。
			 *  1）微信推送给第三方平台方： 事件XML内容（与普通公众号接收到的信息是一样的）
			 *  2）服务方开发者在5秒内回应文本消息并最终触达到粉丝：文本消息的XML中Content字段的内容必须组装为：event + “from_callback”
			 *   （假定event为LOCATION，则Content为: LOCATIONfrom_callback）
			 * */
			if($data['MsgType'] == 'event'){
				$this->weixin_model->replyText($data ['Event'].'from_callback');exit;
			}
			/*
			 * 2、模拟粉丝发送文本消息给专用测试公众号，第三方平台方需根据文本消息的内容进行相应的响应
			 *  1）微信模推送给第三方平台方：文本消息，其中Content字段的内容固定为：TESTCOMPONENT_MSG_TYPE_TEXT
			 *  2）第三方平台方立马回应文本消息并最终触达粉丝：Content必须固定为：TESTCOMPONENT_MSG_TYPE_TEXT_callback
			 * */
			if($data['MsgType'] == 'text' && $data['Content'] == 'TESTCOMPONENT_MSG_TYPE_TEXT'){
				$this->weixin_model->replyText('TESTCOMPONENT_MSG_TYPE_TEXT_callback');exit;
			}
			/*
			 * 3、模拟粉丝发送文本消息给专用测试公众号，第三方平台方需在5秒内返回空串表明暂时不回复，然后再立即使用客服消息接口发送消息回复粉丝
			 *  1）微信模推送给第三方平台方：文本消息，其中Content字段的内容固定为： QUERY_AUTH_CODE:$query_auth_code$
			 *   （query_auth_code会在专用测试公众号自动授权给第三方平台方时，由微信后台推送给开发者）
			 *  2）第三方平台方拿到$query_auth_code$的值后，通过接口文档页中的“使用授权码换取公众号的授权信息”API，将$query_auth_code$的值赋值给API所需的参数authorization_code。
			 *    然后，调用发送客服消息api回复文本消息给粉丝，其中文本消息的content字段设为：$query_auth_code$_from_api
			 *    （其中$query_auth_code$需要替换成推送过来的query_auth_code）
			 * */
			if($data['MsgType'] == 'text' && stripos($data['Content'], 'QUERY_AUTH_CODE',0) !== FALSE){
				ob_start();
				echo '';
				ob_flush();
				flush();
				$query_auth_code = str_replace('QUERY_AUTH_CODE:', '', $data['Content']);
				$this->load->model('wx/access_token_model');
				$access_token = $this->access_token_model->_get_authorizer_access_token($this->inter_id,$query_auth_code,time() + 7200);
				$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
				$msg = '{"touser":"'.$data['FromUserName'].'","msgtype":"text","text":{"content":"'.$query_auth_code.'_from_api"}}';
				$this->load->helper('common');
				//发送客服消息
				doCurlPostRequest($url, $msg);die;
			}
		}

		//全网发布，测试发送客服消息
		//ACCESS_TOKEN

		// if($data['MsgType'] == 'event'){
		// 	$this->
		// }
		/**
		 * <xml>
		 <ToUserName><![CDATA[toUser]]></ToUserName>
		 <FromUserName><![CDATA[fromUser]]></FromUserName>
		 <CreateTime>12345678</CreateTime>
		 <MsgType><![CDATA[text]]></MsgType>
		 <Content><![CDATA[你好]]></Content>
		 </xml>
		 * **/

		// --- 第三方平台全网发布监测
		if ($data ['MsgType'] == 'event') {
			switch ($data ['Event']) {
				case 'subscribe' :
					$data ['EventKey'] = str_replace ( 'last_trade_no_', '', $data ['EventKey'] );
					/**
					 * @author knight
					 * 赠送礼包
					 */
					$this->load->model('member/Getpackagecard');
					$this->Getpackagecard->give_package_card($this->token,$data['FromUserName']);
					/*end*/

					$this->load->model('wx/Qrcode_model');
					$this->load->model('wx/Publics_model');
					$event_time = date('Y-m-d H:i:s');
					$this->load->model('distribute/fans_model');
					if(!empty($data ['EventKey'])){
						$fans_id = $this->Qrcode_model->event_log(str_replace ( 'qrscene_', '', $data ['EventKey'] ),$this->token,2,$data['FromUserName'],$event_time);
						//判断是否属于社群客qrcode_id
						$this->load->model ( 'club/Clubs_model' );
						$c_qrcode_id=str_replace('qrscene_','',$data['EventKey']);
						$this->fans_model->mark_fans_grades($this->token,$data['FromUserName'],$c_qrcode_id,2,$fans_id,date('Y-m-d H:i:s'));
						$res=$this->Clubs_model->check_club_qrcode($this->token,$c_qrcode_id);

						if($res=='社群客扫码'){
							$result = $this->get_reply_contents_by_keyword($res,'',$c_qrcode_id);
							$this->Publics_model->update_wxuser_info($this->token,$data['FromUserName']);
							return $result;
						}
					}else{
						$event_time = date('Y-m-d H:i:s');
						$fans_id = $this->Qrcode_model->event_log(-1,$this->token,2,$data['FromUserName'],$event_time);
						$this->fans_model->mark_fans_grades($this->token,$data['FromUserName'],-1,2,$fans_id,date('Y-m-d H:i:s'));
					}
					if (!empty($data ['EventKey']) && ! (strpos ( $data ['EventKey'], 'qrscene_' ) === false)) {
						//qrscene_10
						//last_trade_no_11111111111111111
						$qrcode_id=str_replace('qrscene_', '', $data['EventKey']);
						$result = $this->get_reply_contents_qrcode ( $qrcode_id );
						$this->Qrcode_model->scan_log( $qrcode_id ,$this->token,$data['FromUserName'],NULL,$event_time);
						$this->load->model('distribute/Staff_model');
						if($this->Staff_model->check_saler_status($this->token,$qrcode_id,'valid_saler') ){
						    if ($check = $this->get_reply_contents_by_keyword('分销二维码扫描推送','','',array('extra_url_param'=>array(
						            '/index.php/hotel/'=>'lsaler='.$qrcode_id,
						            '??all?'=>'saler='.$qrcode_id,
						    )))){
						        $result=$check;
						    }
						}
					}
					if(!isset($result) || is_null($result)){
						$result = $this->get_reply_contents_by_keyword('关注自动回复');
					}
					$this->Publics_model->update_wxuser_info($this->token,$data['FromUserName']);
					if(is_null($result)){
						$this->Weixin_model->replyService($data['FromUserName'],$data['ToUserName'],$this->token);exit;
					}else{
						return $result;
					}
					break;
				case 'SCAN' :

                    $inter_id = $this->token;
                    $qrcode_id = str_replace('qrscene_', '', $data['EventKey']);

//                    //----------------------------------商城----------------------------
//                    $splitList = explode('_', $qrcode_id);
//                    //商品详情，格式：soma_detail_商品id_分销员id_泛分销id
//                    if(count($splitList) == 5){
//                        if($splitList[0].'_'.$splitList[1].'_' == \App\services\soma\WxService::QR_CODE_PRODUCT_DETAIL){
//                            $arr = array();
//                            $type = 'news';
//                            //商品
//                            $productId = $splitList[2];
//                            $this->load->model('soma/Product_package_model', 'productPackageModel');
//                            $productPackageModel = $this->productPackageModel->getByID($productId, $inter_id);
//                            if($productPackageModel){
//                                array_push($arr,
//                                    array(
//                                        'Title' => $productPackageModel['name'],
//                                        'Description' => $productPackageModel['name'],
//                                        'PicUrl' => $productPackageModel['face_img'],
//                                        'Url' => site_url('soma/package/package_detail?id='.$inter_id.'&pid='.$productId.'&saler='.$splitList[3].'&fans_saler='.$splitList[4])
//                                    )
//                                );
//                                return array($arr, $type);
//                            }
//                        }
//                    }
//                    //商城首页，格式：soma_index_分销员id_泛分销id
//                    if(count($splitList) == 4){
//                        if($splitList[0].'_'.$splitList[1].'_' == \App\services\soma\WxService::QR_CODE_SOMA_INDEX){
//                            $arr = array();
//                            $type = 'news';
//                            array_push($arr,
//                                array(
//                                    'Title' => '商城',
//                                    'Description' => '点击进入商城',
//                                    'PicUrl' => '',
//                                    'Url' => site_url('soma/package/index?id='.$inter_id.'&saler='.$splitList[2].'&fans_saler='.$splitList[3])
//                                )
//                            );
//                            return array($arr, $type);
//                        }
//                    }
                    //-------------------------------商城：scene_id以44开头的将被拦截，跳至商品详情----------------------------


                    $this->load->model ( 'wx/Qrcode_model' );
                    // $this->Qrcode_model->scan_log($data ['EventKey'],$this->token);
                    $this->Qrcode_model->scan_log ( $data ['EventKey'], $this->token, $data ['FromUserName'], NULL, date ( 'Y-m-d H:i:s' ) );
                    $result = $this->get_reply_contents_qrcode ( $data ['EventKey'] );

					//社群客
					$this->load->model('distribute/fans_model');
					$event_time = date('Y-m-d H:i:s');
					$this->fans_model->mark_fans_grades($this->token,$data['FromUserName'],str_replace('qrscene_','',$data['EventKey']),2,-1,date('Y-m-d H:i:s'));
				    $this->load->model('distribute/Staff_model');
				    if($this->Staff_model->check_saler_status($this->token,$data ['EventKey'],'valid_saler')){
				        if($this->Staff_model->check_saler_status($this->token,$data ['EventKey'],'valid_saler') ){
				            if ($check = $this->get_reply_contents_by_keyword('分销二维码扫描推送','','',array('extra_url_param'=>array(
				                    '/index.php/hotel/'=>'lsaler='.$data ['EventKey'],
				                    '??all?'=>'saler='.$data ['EventKey'],
				            )))){
				                $result=$check;
				            }
				        }
				    }
					
					if (is_null ( $result )) {
						$this->Weixin_model->replyService ( $data ['FromUserName'], $data ['ToUserName'], $this->token );
						exit ();
					} else {
						return $result;
					}
					break;
				case 'LOCATION' :
				MYLOG::w('位置推送|'.json_encode($data),'subamsg');
					$this->Weixin_model->send_location_info($data['FromUserName'],$data['ToUserName'],$this->token);
					return array(0);
					break;
				case 'CLICK':
					$this->load->model ( 'distribute/fans_model' );
					if (isset ( $data ['FromUserName'] ) && ! empty ( $data ['FromUserName'] )) {
						$this->fans_model->active_fans_subcribe_grades ( $this->token, $data ['FromUserName'] );
					}
						
					$query = $this->get_reply_contents_by_keyword ( $data ['EventKey'], $data ['FromUserName'] );
					if (is_null ( $query )) {
						$this->Weixin_model->replyService ( $data ['FromUserName'], $data ['ToUserName'], $this->token );
						exit ();
					} else
						return $query;
						return $query;
						break;
				case 'VIEW':
					$this->load->model ( 'distribute/fans_model' );
					if (isset ( $data ['FromUserName'] ) && ! empty ( $data ['FromUserName'] )) {
						$this->fans_model->active_fans_subcribe_grades ( $this->token, $data ['FromUserName'] );
					}
					return array ( 0 );
					break;
				case 'unsubscribe' :
					$this->load->model('wx/Qrcode_model');
					$this->load->model ( 'distribute/fans_model' );
					$event_time = date('Y-m-d H:i:s');
					$this->Qrcode_model->event_log(-1,$this->token,1,$data['FromUserName'],$event_time);
					$this->fans_model->_unsubcribe($this->token, $data['FromUserName']);
					return array(0);
					break;
				case 'user_get_card' ://领取卡券事件
                    $this->load->library('MYLOG');
                    $this->load->model('membervip/front/Wechat_membercard_model',"wechatMembercard");
                    $cid = $this->wechatMembercard->add_get_card_info($this->token,$data);
                    MYLOG::w("Get Card Info Data : ".json_encode($data)." | Result ". $cid,'wechat_member_card/get_card');
					$result = $this->get_reply_contents_by_keyword('~卡券领取');
					if(!$result)
						$result = array();
						// $this->db->insert('weixin_text',array('content'=>json_encode($data),'edit_date'=>date('Y-m-d H:i:s')));
						return $result;
						break;
				case 'user_consume_card' ://核销卡券事件
					// if($data['OuterId']){
					$this->load->model('icard_model');
					$this->icard_model->change_card_in_wx($this->token,$data);
					$this->load->model('wxact_model');
					$this->wxact_model->change_card_in_wx($this->token,$data);
					// }
					$result = $this->get_reply_contents_by_keyword('~卡券核销');
					if(!$result)
						$result = array();
						// $this->db->insert('weixin_text',array('content'=>json_encode($data),'edit_date'=>date('Y-m-d H:i:s')));
						return $result;
						break;
				case 'user_del_card' ://删除卡券事件
                    $this->load->library('MYLOG');
                    $this->load->model('membervip/front/Wechat_membercard_model',"wechatMembercard");
                    $cid = $this->wechatMembercard->del_card_info($this->token,$data);
                    MYLOG::w("Get Card Info Data : ".json_encode($data)." | Result ". $cid,'wechat_member_card/del_card');
                    $result = $this->get_reply_contents_by_keyword('~卡券领取');
                    if(!$result)
                        $result = array();
                    // $this->db->insert('weixin_text',array('content'=>json_encode($data),'edit_date'=>date('Y-m-d H:i:s')));
                    return $result;
                    break;
					return $result;
					break;
				case 'card_pass_check' ://卡券审核通过事件
					return 'success';
					break;
				case 'card_not_pass_check' ://卡券审核不通过事件
					return 'success';
					break;
				case 'user_gifting_card' ://卡券转赠事件
					return 'success';
					break;
				case 'user_pay_from_pay_cell' ://买单事件
					return 'success';
					break;
				case 'user_view_card' ://进入会员卡事件
                    $this->load->model('membervip/front/Wechat_membercard_model',"wechatMembercard");
                    $this->wechatMembercard->sys_member_info($this->token,$data);
					return 'success';
					break;
				case 'user_enter_session_from_card' ://从卡券进入公众号会话事件
					return 'success';
					break;
				case 'update_member_card' ://会员卡内容更新事件
					return 'success';
					break;
				case 'card_sku_remind' ://库存报警事件
					return 'success';
					break;
				case 'card_pay_order' ://券点流水详情事件:当商户朋友的券券点发生变动时，微信服务器会推送消息给商户服务器。
					return 'success';
					break;
				case 'submit_membercard_user_info' ://会员卡激活事件推送

                    $this->load->model('wx/Qrcode_model');
                    $this->load->model('wx/Publics_model');
                    $event_time = date('Y-m-d H:i:s');
                    $this->load->model('distribute/fans_model');
                    if(isset($data['OuterId']) && $data['OuterId'] > 0)
                    $fans_id = $this->Qrcode_model->event_log( $data['OuterId'],$this->token,2,$data['FromUserName'],$event_time);
                    $this->fans_model->mark_fans_grades($this->token,$data['FromUserName'],$data['OuterId'],2,$fans_id,date('Y-m-d H:i:s'));
                    $this->load->model('membervip/front/Wechat_membercard_model',"wechatMembercard");
                    $this->wechatMembercard->wx_activate_syc($this->token,$data);
					return 'success';
					break;
				default :
// 					$content_tmp = isset($data['Content']) ? $data['Content']:'关注自动回复';
// 					$query = $this->get_reply_contents_by_keyword($content_tmp);
// 					if(is_null($query)){
// 						$this->Weixin_model->replyService($data['FromUserName'],$data['ToUserName'],$this->token);exit;
// 					}else{
// 						return $query;
// 					}
					return 'success';
					break;
			}
		} else if($data['MsgType'] == 'text') {
			$content_str = isset($data['Content']) ? $data['Content'] : '关注自动回复';
			$query = $this->get_reply_contents_by_keyword($content_str);
			if(empty($query)){
				//威尼斯照片打印机
				if($this->token == 'a440476198' && (stripos($data ['Content'],'+') == '0' || stripos($data ['Content'],'-') == '0')){
					$this->load->helper('common');
					$url = 'http://www.vcinspire.com/printer/receive/lyzl12345678';
					echo doCurlPostRequest($url,json_encode($data,JSON_FORCE_OBJECT));exit;
				}

				/* $this->load->model('wx/Keyword_record_model');
				 $arr['keyword']   = json_encode(array('MsgType'=>$data['MsgType'],'Content'=>$data['Content']));
				 $arr['mark_time'] = date('Y-m-d H:i:s');
				 $arr['openid']    = $data['FromUserName'];
				 $arr['inter_id']  = $this->token; */
				//$this->Keyword_record_model->log_record($arr);

				$this->Weixin_model->replyService($data['FromUserName'],$data['ToUserName'],$this->token);exit;

				/* $url = "http://kefu.iwide.cn/frontend/web/index.php?r=public/debug";
				 $msg = array();
				 $msg['interid'] = $this->token;
				 $msg['msg'] = $data['Content'];
				 $this->http_post($url,$msg); */

				/*
				 $str = '<?xml version="1.0"?><xml><Content>test</Content><ToUserName>oz1AKv3UfAC_AczDw6EDtOB0FQg4</ToUserName><FromUserName>gh_fcece65d520a
				 </FromUserName><CreateTime>1461849864</CreateTime><MsgType><![CDATA[text]]></MsgType></xml>';
				 */
				echo "success";
				exit;
			}else{
				return $query;
			}
			//return  array( array('Title'=>'Title','Description'=>'Description','PicUrl'=>'http://vcode2.iwide.cn/media/a420423523/woodstack/images/shangpin_04.png','Url'=>'www.baidu.com'), array('Title'=>'Title1','Description'=>'Description1','PicUrl'=>'http://vcode2.iwide.cn/media/a420423523/woodstack/images/shangpin_04.png','Url'=>'www.baidu.com') );
			// 			return  array('Title'=>'Title','Description'=>'Description','PicUrl'=>'http://vcode2.iwide.cn/media/a420423523/woodstack/images/shangpin_04.png','Url'=>'www.baidu.com');
		}elseif($data ['MsgType'] == 'image'){
			if($this->token == 'a440476198'){//威尼斯照片打印机
				$this->load->helper('common');
				$url = 'http://www.vcinspire.com/printer/receive/lyzl12345678';
				echo doCurlPostRequest($url,json_encode($data,JSON_FORCE_OBJECT));exit;
			}
			$this->load->model('wx/Keyword_record_model');
			$arr['keyword']   = json_encode(array('MsgType'=>$data['MsgType'],'PicUrl'=>$data['PicUrl'],'MediaId'=>$data['MediaId']));
			$arr['mark_time'] = date('Y-m-d H:i:s');
			$arr['openid']    = $data['FromUserName'];
			$arr['inter_id']  = $this->token;
			// 			$this->Keyword_record_model->log_record($arr);
			$this->Weixin_model->replyService($data['FromUserName'],$data['ToUserName'],$this->token);exit;
		}elseif($data ['MsgType'] == 'voice'){
			$this->load->model('wx/Keyword_record_model');
			$arr['keyword']   = json_encode(array('MsgType'=>$data['MsgType'],'MediaId'=>$data['MediaId'],'Format'=>$data['Format']));
			$arr['mark_time'] = date('Y-m-d H:i:s');
			$arr['openid']    = $data['FromUserName'];
			$arr['inter_id']  = $this->token;
			// 			$this->Keyword_record_model->log_record($arr);
			$this->Weixin_model->replyService($data['FromUserName'],$data['ToUserName'],$this->token);exit;
		}elseif($data ['MsgType'] == 'video'){
			$this->load->model('wx/Keyword_record_model');
			$arr['keyword']   = json_encode(array('MsgType'=>$data['MsgType'],'MediaId'=>$data['MediaId'],'ThumbMediaId'=>$data['ThumbMediaId']));
			$arr['mark_time'] = date('Y-m-d H:i:s');
			$arr['openid']    = $data['FromUserName'];
			$arr['inter_id']  = $this->token;
			// 			$this->Keyword_record_model->log_record($arr);
			$this->Weixin_model->replyService($data['FromUserName'],$data['ToUserName'],$this->token);exit;
		}elseif($data ['MsgType'] == 'location'){
			$this->load->model('wx/Keyword_record_model');
			$arr['keyword']   = json_encode(array('MsgType'=>$data['MsgType'],'Location_X'=>$data['Location_X'],'Location_Y'=>$data['Location_Y'],'Scale'=>$data['Scale'],'Label'=>$data['Label']));
			$arr['mark_time'] = date('Y-m-d H:i:s');
			$arr['openid']    = $data['FromUserName'];
			$arr['inter_id']  = $this->token;
			// 			$this->Keyword_record_model->log_record($arr);
			$this->Weixin_model->replyService($data['FromUserName'],$data['ToUserName'],$this->token);exit;
		}elseif($data ['MsgType'] == 'link'){
			$this->load->model('wx/Keyword_record_model');
			$arr['keyword']   = json_encode(array('MsgType'=>$data['MsgType'],'Title'=>$data['Title'],'Description'=>$data['Description'],'Url'=>$data['Url']));
			$arr['mark_time'] = date('Y-m-d H:i:s');
			$arr['openid']    = $data['FromUserName'];
			$arr['inter_id']  = $this->token;
			// 			$this->Keyword_record_model->log_record($arr);
			$this->Weixin_model->replyService($data['FromUserName'],$data['ToUserName'],$this->token);exit;
		}
	}
	private function checkSignature() {
		$signature = $_GET ["signature"];
		$timestamp = $_GET ["timestamp"];
		$nonce     = $_GET ["nonce"];

		$tmpArr = array ( $this->token, $timestamp, $nonce );
		sort ( $tmpArr );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );
		return $tmpStr == $signature;
	}
	private function get_reply_contents($keyword_id) {
		$this->load->model ( 'wx/Keyword_reply_model' );
		$arr = array();
		$result = $this->Keyword_reply_model->get_keyword_reply_all_by_id ( $keyword_id, $this->token );
		$type = 'text';
		foreach ($result->result() as $item){
			if($item->reply_type == 1)$type='news';
			array_push($arr,array (
					'Title' => $item->title,
					'Description' => $item -> description,
					'PicUrl' => $item ->cover_img,
					'Url' => $item -> url
			) );
		}
		return array($arr,$type);
	}
	private function get_reply_contents_qrcode($keyword_id) {
		$keyword_id = str_replace ( 'last_trade_no_', '', $keyword_id );
		$this->load->model ( 'wx/Qrcode_model' );
		$arr = $this->Qrcode_model->get_detail ( $keyword_id, $this->token );
		if ($arr->num_rows () > 0) {
			$arr = $arr->row_array();
			if(empty($arr ['keyword'])){
				$arr ['keyword'] = '关注自动回复';
			}
			return $this->get_reply_contents_by_keyword ( $arr ['keyword'],'',$keyword_id );
		} else {
			return NULL;
		}
	}

	private function get_reply_contents_by_keyword($keyword,$openid='',$qrcode_id='',$params=array()) {
		/*start 为富林酒店定制功能，对接其已接入的免费wifi接口*/
		//phone_wifi增加在自动回复里，用手机连接wifi接口调用，返回url
		if($keyword == "phone_wifi"){
			$type = 'text';
			//用户微信openid
			$openid = $openid;
			//公众号的微信号；如果无，则传入公众号的openid
			$weixin_id = $this->wx_master_id;
			$content = '单击这里<a href="'.$this->getWifiRandomUrl($openid,$weixin_id).'">一键上网</a>';
			$arr = array();
			array_push($arr,array(
					'Title'=>'',
					'Description'=>$content,
					'PicUrl'=>'',
					'Url'=>''
			) );
			return array($arr,$type);
		}
		//company_wifi增加在自动回复里，用电脑连wifi返回密码
		if($keyword == 'computer_wifi'){
			$type = 'text';
			//用户微信openid
			$openid = $openid;
			//公众号的微信号；如果无，则传入公众号的openid
			$weixin_id = $this->wx_master_id;
				
			$wifi_password = $this->getWifiPasswordForComputer($openid, $weixin_id);
				
			$content = "您的上网验证码是：{$wifi_password}。15分钟有效。";
				
			$arr = array();
			array_push($arr,array(
					'Title'=>'',
					'Description'=>$content,
					'PicUrl'=>'',
					'Url'=>''
			));
				
			return array($arr,$type);
		}
		/*end 为富林酒店定制功能，对接其已接入的免费wifi接口*/


		if($keyword == '社群客扫码'){
			$inter_id=$this->token;
			$arr = array();
			$type = 'news';

			$this->load->model('club/Clubs_model');
			$club_info=$this->Clubs_model->getClubByQrcode($inter_id,$qrcode_id);

			if($inter_id=='a476756979'){    //银座暂时写死
				$image_url = 'public/club/images/background_01.jpg';
			}else{
				$image_url = 'public/club/images/background.jpg';
			}
			
			array_push($arr,
					array(
							'Title'=>'点击激活',
							'Description'=>'欢迎您，请先登记激活您的专属优惠价',
							'PicUrl'=>base_url($image_url),
							'Url'=>site_url('club/club/scan_qrcode?id='.$this->token.'&qid='.$qrcode_id)
					)
					);
			
			return array($arr,$type);
		}


		$this->load->model('wx/Keyword_reply_model');
		$result = $this->Keyword_reply_model->get_keyword_reply_text_all($keyword,$this->token);

		if((!empty($result)) && $result->num_rows() > 0){
			$arr = array();
			$type = 'text';
				
			$data = $result->result();
			foreach ($data as $item){
				$url = $item->url;
// 				$url = str_replace("openid=1",'openid='.$openid,$url);
				if(strpos($url,'saler=1')!==false){
					$url = str_replace("saler=1",'saler='.$qrcode_id,$url);
				}
				if (!empty($params['extra_url_param'])){
				    $tmp_url_para=NULL;
				    foreach ($params['extra_url_param'] as $ukey=>$upara){
				        if (strpos($url, $ukey)){
				            $tmp_url_para=$upara;
				            break;
				        }
				    }
				    if (!isset($tmp_url_para)&&!empty($params['extra_url_param']['??all?'])){
				        $tmp_url_para=$params['extra_url_param']['??all?'];
				    }
				    if ($tmp_url_para){
    				    if (strpos ( $url, '?' ))
        				    $url = $url . "&" . $tmp_url_para;
        			    else
        			        $url = $url . "?" . $tmp_url_para;
				    }
				}
				if($item->type == 1){
					$type='news';
				}
				array_push($arr,
						array(
								'Title'=>$item->title,
								'Description'=>$item->description,
								'PicUrl'=>$item->pic_url,
								'Url'=>$url
						)
						);
			}
			return array($arr,$type);
		}else{
			return "";
		}
	}

	/**
	 * 取wifi链接的url
	 * @param $openid 用户微信openid
	 * @param $weixin_id 公众号的微信号；如果无，则传入公众号的openid
	 * @return String 手机上网的url地址
	 */
	private function getWifiRandomUrl($openid,$weixin_id){


		$rand_num = $this->getPasswordAndSendToWifiServer($openid, $weixin_id);

		return "http://www.longyatthotel.com/?ulWxNum=".$rand_num;

	}

	/**
	 * 取wifi链接的上网密码，用于电脑上网
	 * @param $openid 用户微信openid
	 * @param $weixin_id 公众号的微信号；如果无，则传入公众号的openid
	 * @return String 电脑上网的密码
	 */
	private function getWifiPasswordForComputer($openid,$weixin_id){
			
		//建议加上日志记录
		return $this->getPasswordAndSendToWifiServer($openid, $weixin_id);

	}

	/**
	 * wifi链接的上网密码备案,并返回密码
	 * @param $openid Sting 用户微信openid
	 * @param $weixin_id String 公众号的微信号；如果无，则传入公众号的openid
	 * @return String
	 */
	private function getPasswordAndSendToWifiServer($openid,$weixin_id){

		$startTime = time();

		//断开链接时间暂设2小时
		$endTime = time()+900;


		//暂时直接随机，可能上网人数多会出现重复，但机率少，暂不处理，出现问题也可获取多次实现上网
		$rand_num = rand(100000,999999);

		$api='http://www.login-wifi.com/cmps/admin.php?a=wxinsert&m=api&num='.$rand_num.
		'&start='.$startTime.
		'&end='.$endTime.
		'&openid='.$openid.
		'&weid='.$weixin_id;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $api);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
		$output = curl_exec($curl);

		//建议加上日志记录
		return $rand_num;

	}

	private function http_post($url, $param) {
		$oCurl = curl_init ();
		if (stripos ( $url, "https://" ) !== FALSE) {
			curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYPEER, FALSE );
			curl_setopt ( $oCurl, CURLOPT_SSL_VERIFYHOST, false );
		}
		if (is_string ( $param )) {
			$strPOST = $param;
		} else {
			$aPOST = array ();
			foreach ( $param as $key => $val ) {
				$aPOST [] = $key . "=" . urlencode ( $val );
			}
			$strPOST = join ( "&", $aPOST );
		}
		curl_setopt ( $oCurl, CURLOPT_URL, $url );
		curl_setopt ( $oCurl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $oCurl, CURLOPT_POST, true );
		curl_setopt ( $oCurl, CURLOPT_POSTFIELDS, $strPOST );
		$sContent = curl_exec ( $oCurl );
		$aStatus = curl_getinfo ( $oCurl );
		curl_close ( $oCurl );
		if (intval ( $aStatus ["http_code"] ) == 200) {
			return $sContent;
		} else {
			return false;
		}
	}

}

?>