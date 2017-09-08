<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 公众号信息
 *
 * @author Nfou
 * @since 2015-11-04
 * @version 1.0.0
 */
class Publics_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	const TAB_PUB = 'publics';
	const TAB_PUBIMG = 'public_images';
	const TAB_FANS = 'fans';
	/**
	 * 根据公众号ID取公众号
	 *
	 * @param $id 公众号ID        	
	 * @param $field ID类型        	
	 * @param $status 公众号状态，0正常，1停用，2已删除
	 *        	return $query
	 */
	function get_public_by_id($id, $field = 'inter_id', $status = null) {
		if (! is_null ( $status )) {
			$this->db->where ( 'status', $status );
		}
		return $this->db->get_where ( self::TAB_PUB, array (
				$field => $id 
		) )->row_array ();
	}
	
	/**
	 * 取所有公众号
	 *
	 * @param $num 数量
	 * @param $offset 起始位置
	 * @return $query
	 */
	function get_public($num = null, $offset = null) {

		$this->db->where ( 'status', 0 );
		if (is_null($num)) {
			return $this->db->get ( 'publics' )->result ();
		} else {
			return $this->db->get ( self::TAB_PUB, $num, $offset )->result ();
		}
	}
	/**
	 *
	 * @author libinyan
	 */
	public function get_public_hash($params = array(), $select = array(), $format = 'array') {
		$table = self::TAB_PUB;
		$select = count ( $select ) == 0 ? '*' : implode ( ',', $select );
		$this->db->select ( " {$select} " );
		
		$where = array ();
		$dbfields = array_values ( $fields = $this->db->list_fields ( $table ) );
		foreach ( $params as $k => $v ) {
			// 过滤非数据库字段，以免产生sql报错
			if (in_array ( $k, $dbfields ) && is_array ( $v )) {
				$this->db->where_in ( $k, $v );
			} else if (in_array ( $k, $dbfields )) {
				$this->db->where ( $k, $v );
			}
		}
		$result = $this->db->get ( $table );
		if ($format == 'object')
			return $result->result ();
		else
			return $result->result_array ();
	}
	/**
	 *
	 * @author libinyan
	 */
	public function array_to_hash($array, $label_key, $value_key = NULL) {
		$data = array ();
		foreach ( $array as $k => $v ) {
			// 过滤额外增加的数据 如 key=0的不完整数据
			if (isset ( $v [$label_key] )) {
				if ($value_key == NULL) {
					$key = $k;
				} else {
					$key = $v [$value_key];
				}
				$data [$key] = $v [$label_key];
			}
		}
		return $data;
	}
	/**
	 *
	 * @author libinyan
	 */
	public function hash_to_option($array) {
		// [{value:'',text:'All'},{value:'P',text:'P'},{value:'N',text:'N'}],
		$data = array ();
		foreach ( $array as $k => $v ) {
			$data [] = array (
					'value' => $k,
					'text' => $v 
			);
		}
		return $data;
	}
	/**
	 *
	 * @author libinyan
	 */
	public function hash_to_optionhtml($array, $selected = NULL) {
		$html = '';
		foreach ( $array as $k => $v ) {
			if ($selected !== NULL && $selected == $k)
				$html .= "<option value='{$k}' selected='selected'>{$v}</option>";
			else
				$html .= "<option value='{$k}'>{$v}</option>";
		}
		return $html;
	}
	
	/**
	 * 创建公众号
	 *
	 * @param $array 公众号信息
	 *        	return 受影响行数
	 */
	function create($array) {
		return $this->db->insert ( self::TAB_PUB, $array );
	}
	
	/**
	 * 更新公众号
	 *
	 * @param $array 公众号信息
	 *        	return 受影响行数
	 */
	function update_public($array) {
		$this->db->where ( 'inter_id', $array ['inter_id'] );
		$this->db->update ( self::TAB_PUB, $array );
	}
	
	/**
	 * 删除公众号
	 *
	 * @param $id 公众号内部ID
	 *        	return 受影响行数
	 */
	function delete($id) {
		/*
		 * $this->db->where('inter_id',$id);
		 * return $this->db->update('public',array('status'=>1));
		 */
		$this->db->delete ( self::TAB_PUB, array (
				'inter_id',
				$id 
		) );
	}
	
	/**
	 * 添加幻灯片记录
	 *
	 * @param
	 *        	$data
	 */
	function create_lightbox($data) {
		return $this->db->insert ( self::TAB_PUBIMG, $data );
	}
	function update_lightbox($id, $info, $sort) {
		$this->db->where ( 'id', $id );
		return $this->db->update ( self::TAB_PUBIMG, array (
				'info' => $info,
				'sort' => $sort 
		) );
	}
	function save_focus(){
		$datas['image_url']  = trim($this->input->post('imgurl'));
		$datas['info']       = trim($this->input->post('describe'));
		$datas['sort']       = $this->input->post('sort');
        $datas['link']       = $this->input->post('link');
        
        if (empty($datas['link'])){
        	$datas['link']='#';
        }else{
        	if(strpos($datas['link'],'http://')!==0&&strpos($datas['link'],'https://')!==0){
        		$datas['link']='http://'.$datas['link'];
        	}
        }
        
		$key= $this->input->post('key');
		if(empty($key)){
			$datas['inter_id']   = $this->input->post('inter_id');
			$datas['status']     = 0;
			$datas['type']       = 'hotelslide';
			return $this->db->insert(self::TAB_PUBIMG,$datas) > 0;
		}else{
			$this->db->where(array('inter_id'=>$this->input->post('inter_id'),'id'=>$this->input->post('key')));
			return $this->db->update(self::TAB_PUBIMG,$datas) > 0;
		}
	}
	function del_focus(){
		$this->db->where(array('inter_id'=>$this->input->get('inter_id'),'id'=>$this->input->get('key')));
		return $this->db->delete(self::TAB_PUBIMG) > 0;
	}

    /**
     * 前后端分离删除轮播图
     * @param $post
     * @return bool
     * @author daikanwu <daikanwu@jperation.com>
     */
    function del_focus_new($post){
        $this->db->where('id', $post['id']);
        return $this->db->update(self::TAB_PUBIMG, ['status' => 2]) > 0;
    }

    function update_focus(){
    	
    	$link=$this->input->get('link');
    	if (empty($link)){
    		$link='#';
    	}else{
    		if(strpos($link,'http://')!==0&&strpos($link,'https://')!==0){
    			$link='http://'.$link;
    		}
    	}
    	$data = array (
            'info' =>$this->input->get('info'),
            'sort' => $this->input->get('sort'),
            'link' => $link
        );
    	$imgurl = trim($this->input->get('imgurl'));
    	if(!empty($imgurl)){
    		$data['image_url'] = $imgurl;
    	}
        $this->db->where(array('inter_id'=>$this->input->get('inter_id'),'id'=>$this->input->get('key')));
        $this->db->update ( self::TAB_PUBIMG, $data );
        return true;
    }

    /**
     * 前后端分离更新轮播图
     * @param $post
     * @return bool
     * @author daikanwu <daikanwu@jperation.com>
     */
    public function update_focus_new($post)
    {
        $link = trim($post['link']);
        if (empty($post['link'])) {
            $link = '#';
        } else {
            if (strpos($post['link'], 'http://') !== 0 && strpos($post['link'], 'https://') !== 0) {
                $link = 'http://' . $post['link'];
            }
        }

        $data = array(
            'link' => $link
        );
        if (!empty($post['sort'])) {
            $data['sort'] = $post['sort'];
        }

        $imgurl = trim($post['image_url']);
        if (!empty($imgurl)) {
            $data['image_url'] = $imgurl;
        }
        if (!empty($post['id'])) {
            $this->db->where('id', $post['id']);
            return $this->db->update(self::TAB_PUBIMG, $data) > 0;
        } else {
            $data['inter_id'] = $post['inter_id'];
            return $this->db->insert(self::TAB_PUBIMG, $data) > 0;
        }
    }
	
	/**
	 * 删除幻灯片记录
	 *
	 * @param $id 幻灯片id        	
	 */
	function del_lightbox($id) {
		$this->db->where ( 'id', $id );
		return $this->db->update ( self::TAB_PUBIMG, array (
				'status' => 1 
		) );
	}
	function get_pub_imgs($id, $type = '') {
		$this->db->order_by ( 'sort desc' );
		$this->db->where ( array (
				'inter_id' => $id,
				'status' => 0,
				'type' => $type 
		) );
		return $this->db->get ( self::TAB_PUBIMG )->result_array ();
	}

	/**
	 * 根据ID取幻灯片
	 *
	 * @param $id 公众号ID        	
	 *        	return $query
	 */
	function get_pub_img_by_id($id) {
		return $this->db->get_where ( self::TAB_PUBIMG, array (
				'id' => $id 
		) )->row_array ();
	}

	function get_public_by_hotel_id($hotel_id, $inter_id = '') {
		$sql = "SELECT p.* FROM iwide_hotels h INNER JOIN iwide_public p ON h.inter_id=p.inter_id WHERE h.hotel_id=$hotel_id";
		if ($inter_id)
			$sql .= " and h.inter_id=$inter_id";
		$sql .= " limit 1";
		return $this->db->query ( $sql )->row_array ();
	}
	function get_wxuser_info($inter_id, $openid, $accesstoken = null) {
		$this->load->model ( 'wx/Access_token_model' );
		$access_token = $this->Access_token_model->get_access_token ( $inter_id );
		if ($accesstoken)
			$url = "https://api.weixin.qq.com/sns/userinfo?access_token=$accesstoken&openid=$openid&lang=zh_CN";
		else
			$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $access_token . '&openid=' . $openid;

		$this->write_log("Public_model:get_wxuser_info()-->curl_url : " . $url);

		$con = curl_init ( $url );
		curl_setopt ( $con, CURLOPT_HEADER, false );
		curl_setopt ( $con, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $con, CURLOPT_SSL_VERIFYPEER, false );
		$result = curl_exec ( $con );

		$this->write_log("Public_model:get_wxuser_info()-->result : " . json_encode($result));

		$result = json_decode ( $result, TRUE );
		return $result;
	}

	/**
	 * 2016-7-20 16:02:31
	 * 将更新fans表的依据改为isset($result['headimgurl'])
	 * 原依据$result['headimgurl']的值作为判断导致没有设置头像的用户数据不加入fans表
	 */
	function update_wxuser_info($inter_id, $openid, $accesstoken = null) {
		$check = $this->db->get_where ( self::TAB_FANS, array (
				'openid' => $openid,
				'inter_id' => $inter_id 
		) );
		if ($check->num_rows () > 0) {
			$result = $this->get_wxuser_info ( $inter_id, $openid, $accesstoken );
			if (!empty($result ['openid'])) {
				if (isset($result ['headimgurl'])) {
					$stime = null;
					if (!empty($result ['subscribe_time']))
						$stime = date ( "Y-m-d H:i:s", $result ['subscribe_time'] );
					$this->db->where ( array (
							'openid' => $openid,
							'inter_id' => $inter_id 
					) );
					$this->db->update ( 'fans', array (
							'headimgurl' => $result ['headimgurl'],
							'nickname' => $result ['nickname'],
							'sex' => $result ['sex'],
							'province' => $result ['province'],
							'city' => $result ['city'],
							'subscribe_time' => $stime 
					) );
				}
			}
		} else {
			$result = $this->get_wxuser_info ( $inter_id, $openid, $accesstoken );
			if (!empty($result ['openid'])) {
				$stime = null;
				if (!empty($result ['subscribe_time']))
					$stime = date ( "Y-m-d H:i:s", $result ['subscribe_time'] );
				if (isset($result ['headimgurl'])) {
					$this->db->insert ( 'fans', array (
							'inter_id' => $inter_id,
							'openid' => $openid,
							'headimgurl' => $result ['headimgurl'],
							'nickname' => $result ['nickname'],
							'sex' => $result ['sex'],
							'province' => $result ['province'],
							'city' => $result ['city'],
							'subscribe_time' => $stime 
					) );
				} else {
					$this->db->insert ( 'fans', array (
							'inter_id' => $inter_id,
							'openid' => $openid 
					) );
				}
			}
		}
	}

    /**
     * 2016-07-21
     * @author knight
     * 关注送劵/礼包
     * @param $inter_id 微信集团ID
     * @param $openid 微信会员ID
     * @return bool|void
     */
    public function give_package_card($inter_id, $openid){
        if(!isset($inter_id) || empty($inter_id)) return;
        if(!isset($openid) || empty($openid)) return;
        $token = $this->get_Token();
        $this->write_log("Public_model:get_Token()-->result : " . json_encode(array('data'=>$token)));

        if(!isset($token) || empty($token)) return;

        $fans = $this->getFansByOpenid($inter_id,$openid);
        $this->write_log("Public_model:getFansByOpenid()-->result : " . json_encode($fans));

        if(!empty($fans) && count($fans) > 0){
            $subscribe_time = floatval(strtotime($fans[0]['subscribe_time']));
            if($subscribe_time < time()) return;
        }
        //获取优惠信息
        $post_card = array(
            'token'=>$token,
            'inter_id'=>$inter_id,
            'type'=>'gazeini',
        );

        $rule_info= $this->doCurlPostRequest( PMS_PATH_URL."cardrule/get_package_card_rule_info" , $post_card );
        $this->write_log("cardrule:get_package_card_rule_info()-->result : " . json_encode(array('data'=>$rule_info)));

        if(isset($rule_info['data'])){
            $rule_info = $rule_info['data'];
        }

        $packge_url = INTER_PATH_URL.'package/give'; //领取礼包
        $card_url = PMS_PATH_URL.'cardrule/reg_gain_card'; //领取卡劵
        $res = array();
        foreach ($rule_info as $key => $item){
            if( isset($item['is_package']) && $item['is_package']=='t'){
                $package_data = array(
                    'token'=>$token,
                    'inter_id'=>$inter_id,
                    'openid'=>$openid,
                    'uu_code'=>uniqid(),
                    'package_id'=>$item['package_id'],
                    'card_rule_id'=>$item['card_rule_id'],
                    'number'=>$item['frequency']
                );
                $res = $this->doCurlPostRequest( $packge_url , $package_data );
            }elseif (isset($item['is_package']) && $item['is_package']=='f'){
                $card_data = array(
                    'token'=>$token,
                    'inter_id'=>$inter_id,
                    'openid'=>$openid,
                    'card_id'=>$item['card_id'],
                    'type'=>'reg'
                );
                $res = $this->doCurlPostRequest( $card_url , $card_data );
            }
        }
        $this->write_log("Public_model:give_package_card()-->result : " . json_encode(array('data'=>$res)));
        return $res;
    }

    /**
     * 2016-07-21
     * @author knight
     * 获取会员授权token
     */
    protected function get_Token(){
        $post_token_data = array(
            'id'=>'vip',
            'secret'=>'iwide30vip',
        );
        $token_info = $this->doCurlPostRequest( INTER_PATH_URL."accesstoken/get" , $post_token_data );
        $_token = isset($token_info['data'])?$token_info['data']:"";
        return $_token;
    }

    /**
     * 2016-07-21
     * @author knight
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
     * 2016-07-21
     * @author knight
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

    /**
     * 获取粉丝信息
     * @param $openid 微信ID
     * @return mixed
     */
	function get_fans_info($openid) {
		return $this->db->get_where ( self::TAB_FANS, array (
				'openid' => $openid 
		) )->row_array ();
	}
	
	/**
	 * 通过多个openid获取所有粉丝信息
	 * @param Array $openids
	 */
	public function get_fans_info_byIds($openids)
	{
	    if( is_array($openids) ){
	        $this->db->where_in('openid', $openids);
	    } else {
	        $this->db->where('openid', $openids);
	    }
		return $this->db->where('nickname is not', NULL)->get( self::TAB_FANS )->result_array ();
	}

    /**
     * 2016-07-29
     * @author knight
     * 通过openid 获取粉丝信息  (支持单个或者以数组方式获取多个粉丝信息)
     * @param $openid
     * @return mixed
     */
	public function getFansByOpenid($inter_id,$openid){
	    if(empty($inter_id) || empty($openid)) return array();
        if( is_array($openid) ){
            $this->db->where_in('openid', $openid);
            $this->db->where('inter_id', $inter_id);
        } else {
            $where = array('openid'=>$openid,'inter_id'=>$inter_id);
            $this->db->where($where);
        }
        return $this->db->get( self::TAB_FANS )->result_array ();
    }
    
    function get_fans_info_one($inter_id,$openid) {
    	$this->db->order_by('id','desc');
    	$this->db->limit(1);
    	return $this->db->get_where ( self::TAB_FANS, array (
    			'inter_id'=>$inter_id,
    			'openid' => $openid
    	) )->row_array ();
    }
	
	//日志写入
    public function write_log( $content )
    {
        $file= date('Y-m-d'). '.txt';
        //echo $tmpfile;die;
        $path= APPPATH.'logs'.DS. 'public_oauth'. DS;
        if( !file_exists($path) ) {
            @mkdir($path, 0777, TRUE);
        }
        $fp = fopen( $path. $file, 'a');

        $CI = & get_instance();
        $ip= $CI->input->ip_address();
        $content= str_repeat('-', 40). "\n[". date('Y-m-d H:i:s'). ']'
            ."\n". $ip. "\n". $content. "\n";
        fwrite($fp, $content);
        fclose($fp);
    }
    
    function get_wxapublic_info($id, $field = 'inter_id', $status = null) {
    	$db = $this->load->database('iwide_r1',true);
    	if (! is_null ( $status )) {
    		$db->where ( 'status', $status );
    	}
    	$db->limit(1);
    	return $db->get_where ( 'publics_appinfo', array (
    			$field => $id
    	) )->row_array ();
    }

}