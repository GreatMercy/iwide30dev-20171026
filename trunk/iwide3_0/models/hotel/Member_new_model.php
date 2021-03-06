<?php
class Member_new_model extends CI_Model {
    protected $CI;
    protected $obj;
    protected $pms_set;

	function __construct() {
		parent::__construct ();
        $this->CI = & get_instance ();

//        $this->vid=$this->pms_set;
        $this->_server=INTER_PATH_URL;
//        $this->_server='http://vip.iwide.cn/api2/';
	}

    //订房接入会员4.0
    public function request_post($url,$params,$timeout=5,$need_token=true,$id='hotel',$secret='iwide30hotel'){

    	if ($need_token){
    		$params['token']=$this->get_token($id, $secret);
    	}
    	
    	$res=$this->query_post($url, $params,$timeout);

        $data = json_decode($res,true);
        
        if (isset($data['err'])&&$data['err']=='1000'){
        	$params['token']=$this->refresh_token($id, $secret);
        	$res=$this->query_post($url, $params,$timeout);
        	$data = json_decode($res,true);
        }
        
        return $data;

    }
    
    function query_post($url,$params,$timeout=5){
    	$requestString = http_build_query($params);
    	if ($url == "" || $timeout <= 0) {
    		return false;
    	}
    	
    	$now=time();
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
    	//         $log_data = array(
    	//             'url'=>$url,
    	//             'post_data'=>$params,
    	//             'result'=>$res,
    	//         );
    	//         $this->api_write_log(serialize($log_data) );
    	
    	$inter_id='unknown';
    	if (!empty($params ['inter_id'])){
    		$inter_id=$params ['inter_id'];
    	}else if(!empty($this->session->userdata ( 'inter_id' ))){
    		$inter_id=$this->session->userdata ( 'inter_id' );
    	}else if(!empty($this->session->admin_profile['inter_id'])){
    		$inter_id=$this->session->admin_profile['inter_id'];
    	}
    	$openid='mvip';
    	if (!empty($this->session->userdata ( $inter_id . 'openid' ))){
    		$openid=$this->session->userdata ( $inter_id . 'openid' );
    	}else if(!empty($this->session->admin_profile['username'])){
    		$openid=$this->session->admin_profile['username'];
    	}
    	
    	$this->load->model('common/Webservice_model');
    	$this->Webservice_model->add_webservice_record($inter_id, 'membervip', $url, $params, $res,'query_post', $now, microtime (), $openid);
    	return $res;
    }

	function get_token($id,$secret){
		$inter_id='hoteltoken';
		$this->db->where(array('inter_id'=>$inter_id,'expire >'=>time(),'type'=>21));
		$this->db->limit(1);
		$data=$this->db->get('access_tokens')->row_array();
		if (empty($data)){
			$token=$this->set_token($id, $secret);
			$this->db->replace ( 'access_tokens', array (
					'inter_id'     => $inter_id,
					'access_token' => $token ['data'],
					'expire'       => time()+$token['expire'],
					'type'         => 21
			) );
			return $token ['data'];
		}else {
			return $data['access_token'];
		}
	}
	function refresh_token($id,$secret){
		$inter_id='hoteltoken';
		$token=$this->set_token($id, $secret);
		$this->db->replace ( 'access_tokens', array (
				'inter_id'     => $inter_id,
				'access_token' => $token ['data'],
				'expire'       => time()+$token['expire'],
				'type'         => 21
		) );
		return $token ['data'];
	}
    
    function set_token($id,$secret){   //获取token

        $params['id']=$id;
        $params['secret']=$secret;
        $url= $this->_server. 'accesstoken/get';

        return $this->request_post($url,$params,5,false);

    }


    protected function api_write_log( $content, $type='request' )     //记录日志
    {
        $file= date('Y-m-d_H'). '.txt';
        $path= APPPATH. 'logs'. DS. 'front'. DS. 'hotel'. DS;
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



    function addBonus($openid, $amount, $note, $orderid, $inter_id){      //积分增加

        $url= $this->_server. 'credit/add';

        $params=array(
            'openid'=> $openid,
            'inter_id'=>$inter_id,
            'module'=>'hotel',
            'count'=>$amount,
            'uu_code'=>time().rand(0,9999),
            'remark'=>$note,
            'order_id'=>$orderid
        );

        $result=$this->request_post($url,$params);

        if($result['msg']=='ok'){

            return true;

        }else{

            return false;

        }

    }


    function getAllBonus($openid,$inter_id,$is_pms=''){          //全部积分

        $url= $this->_server. 'credit/getinfo';

        $params=array(
            'openid'=> $openid,
            'inter_id'=>$inter_id,
            'module'=>'hotel'
//            'member_info_id'=>121
        );

        $result=$this->request_post($url,$params);

        return $result;
    }


    function refund($inter_id,$orderid){       //积分返还

        $url= $this->_server. 'credit/giveback';

        $params=array(
            'inter_id'=>$inter_id,
            'order_id'=>$orderid,
            'uu_code'=>time().rand(0,9999)
        );

        $result=$this->request_post($url,$params);

        if($result['msg']=='ok'){

            return true;

        }else{

            return false;

        }
    }



    function bonusDetail($inter_id,$openid,$orderid){       //积分明细

        $url= $this->_server. 'credit/getlogs';
        $params=array(
            'openid'=> 'o9Vbtw-7C9NVnApvqvhfL6GtFhds',
            'inter_id'=>'a450089706',
            'module'=>'hotel',
        );

        $result=$this->request_post($url,$params);

        return $result;
    }


    function reduceBonus($inter_id, $orderid, $openid, $amount,$params=array()){       //积分扣减

        $url= $this->_server. 'credit/useoff';
        $params['openid']= $openid;
        $params['inter_id']=$inter_id;
        $params['module']='hotel';
        $params['count']=$amount;
        $params['uu_code']=time().rand(0,9999);
        $params['order_id']=$orderid;
        $params['remark']='订房订单扣减积分';
//         $params=array(
//             'openid'=> $openid,
//             'inter_id'=>$inter_id,
//             'module'=>'hotel',
//             'count'=>$amount,
//             'uu_code'=>time().rand(0,9999),
//             'order_id'=>$orderid,
//             'remark'=>'订房订单扣减积分'
//         );
	    
	    //超时时间
	     $timeout=isset($params['timeout'])?$params['timeout']:5;
	     unset($params['timeout']);

        $result=$this->request_post($url,$params,$timeout);

        if($result['msg']=='ok'){

            return true;

        }else{

            return false;

        }
    }


    function exchangeBonus($inter_id,$orderid,$openid,$amount,$params=array()){       //隐居积分换算金额扣减

        $url= $this->_server. 'credit/spec_useoff';
        $params['openid']=$openid;
        $params['inter_id']=$inter_id;
        $params['module']='hotel';
        $params['uu_code']=time().rand(0,9999);
//        $params['rate']=$amount;

//        $params['count'] = 1.00; //总金额
        $params['scene'] = 'hotel';
        $params['note'] = '订房订单扣减积分-测试';
//        $params['password'] = '705771';  //支付密码
        $params['order_id'] = $orderid; //order_id
//        $params['crsNo'] = 'W1610180038'; //订单号
        $params['credit_amount'] = $amount; //总积分
//        $params['percentage'] = 0.4;  //直扣积分比例
//        $params['rate'] = 100; //积分比例:1元对应多少积分

        return $this->request_post($url,$params);

    }



	function reduceBalance($inter_id,$openid,$orderid,$amount,$params=array(),$order=array()){       //余额扣减

        $url= $this->_server. 'deposit/useoff';
		$params['openid']=$openid;
		$params['inter_id']=$inter_id;
		$params['module']=isset($params['module'])?$params['module']:'hotel';
		$params['count']=$amount;
		$params['uu_code']=time().rand(0,9999);
		$params['localNo']=$orderid;
        $params['hotel_id']=isset($order['hotel_id'])?$order['hotel_id']:'';
		if(!isset($params['crsNo'])){
			$params['crsNo']=$orderid;
		}
        // $params=array(
            // 'openid'=> $openid,
            // 'inter_id'=>$inter_id,
            // 'module'=>'hotel',
            // 'count'=>$amount,
            // 'uu_code'=>time().rand(0,9999)
        // );

        $result=$this->request_post($url,$params);

        if($result['msg']=='ok'){

            return true;

        }else{

            return false;

        }
    }

    function addBalance($inter_id,$openid,$orderid,$amount,$remark='',$data=array()){       //余额返还

        $url= $this->_server. 'deposit/add';
        $params=array(
            'openid'=> $openid,
            'inter_id'=>$inter_id,
            'module'=>isset($data['module'])?$data['module']:'hotel',
            'count'=>$amount,
            'uu_code'=>time().rand(0,9999),
            'note'=>$remark
        );

        $result=$this->request_post($url,$params);

        if($result['msg']=='ok'){

            return true;

        }else{

            return false;

        }
    }


    function getAllMemberLevels($inter_id,$all_data=false){       //获取全部会员等级

        $result=array();
        $url= $this->_server. 'member/lvl_info';
        $params=array(
            'inter_id'=>$inter_id,
        );

        $level=$this->request_post($url,$params);

        if(!empty($level)){

            if(isset($level['data']) && is_array($level['data'])){
				if ($all_data){
					foreach($level['data'] as $arr){
						$result[$arr['member_lvl_id']]=$arr;
					}
				}else{
	                foreach($level['data'] as $arr){
						
	                    $result[$arr['member_lvl_id']]=$arr['lvl_name'];
	                }
				}

                return $result;

            }else{

                return false;
            }

        }else{

        }


    }


    function getMemberByOpenId($inter_id,$openid){       //获取会员信息，包括会员等级积分与余额

        $url= $this->_server. 'member/getinfo';
        $params=array(
            'openid'=>$openid,
            'inter_id'=>$inter_id
        );

        $result=$this->request_post($url,$params);

        if(!empty($result['data'])){
            $result=(Object)$result['data'];

            $result->bonus=$result->credit;
            $result->level=$result->member_lvl_id;
            $result->identity_card=$result->id_card_no;
            $result->mem_id=$result->member_id;
            if (isset($result->mem_card_no)){
            	$result->mem_card_no_old=$result->mem_card_no;//原mem_card_no
            }
            $result->mem_card_no=$result->membership_number;
            
            isset($result->jfk_member_no) or $result->jfk_member_no='';
            
            $result->logined=1;
            if($result->member_mode==1&&(!empty($result->login_type)&&$result->login_type=='login')){
            	$result->logined=0;
            }

            return $result;

        }else{

            return false;
        }

    }
    
    function get_pms_member($inter_id,$openid){       //获取pms会员信息

        $url= $this->_server. 'member/getpmsinfo';
        $params=array(
            'openid'=>$openid,
            'inter_id'=>$inter_id
        );

        $result=$this->request_post($url,$params,15);

        if(!empty($result)&&is_array($result)&&(!isset($result['err'])||$result['err']==0)){

            return $result;

        }else{

            return false;
        }

    }
    
    function newMember($inter_id,$openid){       //新会员

        $url= $this->_server. 'member/notify_new';
        $params=array(
            'openid'=>$openid,
            'inter_id'=>$inter_id
        );

        $newMember=$this->request_post($url,$params);

        if($newMember['msg']=='ok'){

            $result=$this->getMemberByOpenId($inter_id,$openid);

            return $result;

        }else{

            return false;
        }
    }
    
    function save_roomnight($inter_id,$openid,$member_no,$order_data,$params=array()){       //新会员

        $url= $this->_server. 'member/save_night_record';
        $params['openid']=$openid;
        $params['inter_id']=$inter_id;
        $params['membernum']=$member_no;
        $params['data']=$order_data;

        $result=$this->request_post($url,$params);

        if(!empty($result)&&is_array($result)&&(!isset($result['err'])||$result['err']==0)){
        	return true;
        }else{
        	return false;
        }
    }

	public function refundBalance($inter_id, $orderid,$amount,$params=[]){
		$url=$this->_server.'deposit/giveback';
		$params['inter_id']=$inter_id;
		$params['order_id']=$orderid;
		$params['uu_code']=time().rand(0,9999);
		$params['amount']=$amount;
		$result=$this->request_post($url, $params);
		if(!empty($result)&&is_array($result)&&(!isset($result['err'])||$result['errcode']==0)){
			return true;
		}
		return false;
    }


}