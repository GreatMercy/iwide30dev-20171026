<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Public_oauth extends MY_Controller {
    
	public function index()
	{
		$data = $this->input->get();
		$this->write_log("Public_oauth:index->get() : " . json_encode($data));


		$this->load->model('wx/Publics_model');
		$public=$this->Publics_model->get_public_by_id($this->input->get('id'));
		if (! $this->input->get ( 'code' )) {
		    //没有code参数，跳转到weixin获取code，再跳回此地址
			if( isset($_SERVER['SERVER_SOFTWARE']) && $_SERVER['SERVER_SOFTWARE']=='nginx')
				$url =  'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'] ;
			else 
				$url =  'http://' . $_SERVER ['SERVER_NAME'] . $_SERVER ['REQUEST_URI'] ;

			$scope = 'snsapi_base';
			if ($this->input->get ( 'scope' )) {
// 				$scope = 'snsapi_userinfo';
				$scope = $this->input->get ( 'scope' );
			}
			$refer_uri = urlencode($this->input->get('refer'));
			$url = urlencode ($url);
			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $public ['app_id'] . "&redirect_uri=$url&response_type=code&scope=$scope&state=STATE#wechat_redirect";
			redirect ( $url );
			exit();
		} else {
		    //有code参数，进行数据存储。
			$code = $this->input->get ( 'code' );
			$redirect_uri = urldecode($this->input->get ( 'refer' ));
			$inter_id = $this->input->get('id');

			// 月饼说授权必须需要携带code参数
			if(strpos($redirect_uri, 'mooncake_decode_cb') !== FALSE) {
				if (strpos ( $redirect_uri, '?' ) !== FALSE){
					$redirect_uri = $redirect_uri . '&code=' . $code ;
				}else{
					$redirect_uri = $redirect_uri . '?code=' . $code ;
				}
			}

			//处理2.0接口跳转授权
			if($this->input->get('__auth20')){
				if (strpos ( $redirect_uri, '?' ) !== FALSE){
					$redirect_uri = $redirect_uri . '&code=' . $this->input->get ( 'code' ) ;
				}else{
					$redirect_uri = $redirect_uri . '?code=' . $this->input->get ( 'code' ) ;
				}
				redirect ( $redirect_uri);
				exit();
			}
			
			//@Editor lGh 判断域名白名单
			$white_domain=NULL;
			if (!empty($public['white_domains'])){
				$white_domain=$this->check_white_domain($redirect_uri, $public['domain'], $public['white_domains']);
				if ($white_domain===FALSE){
					echo 'block';
					exit;
				}
			}

			//@Editor lGh 跳转的域名需要带上code
			if (!empty($white_domain)&&in_array('code',$white_domain)){
				if (strpos ( $redirect_uri, '?' ))
					$redirect_uri = $redirect_uri . "&icode=" .$this->input->get ( 'code' );
				else
					$redirect_uri = $redirect_uri . "?icode=" . $this->input->get ( 'code' );
				redirect ( $redirect_uri );
				exit();
			}
			
			$result = $this->_auth_res($this->input->get ( 'code' ),$this->input->get('id'));

			$this->write_log("Public_oauth:_auth_res() : " . $result);

			$result = json_decode ( $result, TRUE );
			$this->session->set_userdata ( array ( $this->session->userdata ( 'inter_id' ) . 'openid' => $result ['openid'] ) );
			if ($result ['openid']) {
				$accessstoken = null;
				if ($this->input->get ( 'scope' )) {
					$accessstoken = $result ['access_token'];
				}
				
				// 处理月饼说跨域丢失inter_id
				$inter_id = $this->session->userdata ( 'inter_id' );
				if(!$inter_id) { $inter_id = $this->input->get('id'); }

				$this->Publics_model->update_wxuser_info ( $inter_id, $result ['openid'], $accessstoken );
			}
			
			//@Editor lGh 跳转的域名需要带上openid
			if (!empty($white_domain)&&in_array('openid',$white_domain)){
				if (strpos ( $redirect_uri, '?' ))
					$redirect_uri = $redirect_uri . "&openid=" . $result ['openid'];
				else
					$redirect_uri = $redirect_uri . "?openid=" . $result ['openid'];
				redirect ( $redirect_uri );
				exit();
			}
			
			redirect ( $redirect_uri );
			exit();
		}
	}
	
	/**
	 * @param JSON {"itd":"公众号在系统对应的ID","code":"网页授权返回的CODE","noncestr":"32位随机字符串","timestamp":"时间戳","signature":"签名"}
	 * @todo 对外输出接口取网页授权数据
	 * 接受参数类型为JSON：{"itd":"公众号在系统对应的ID","code":"网页授权返回的CODE","noncestr":"32位随机字符串","timestamp":"时间戳","signature":"签名"}
	 * 签名方法跟微信的签名算法一致，即对所有待签名参数按照字段名的ASCII 码从小到大排序（字典序）后，
	 * 使用URL键值对的格式（即key1=value1&key2=value2…）拼接成字符串string1（参数名均为小写字符），
	 * 然后在加上双方约定的秘钥key即（即key1=value1&key2=value2…&key=秘钥）拼接成string2,
	 * 对string2作sha1加密，字段名和字段值都采用原始值，不进行URL 转义对string2进行sha1签名得到最终签名signature
	 * @version 1.0 bata
	 * @author ounianfeng
	 * @since 2016-01-15
	 * @return JSON 微信网页授权返回的原始数据
	 */
	public function auth_res()
	{
		$source = json_decode ( file_get_contents ( 'php://input' ), TRUE );
		if ($source) {
			if (! isset ( $source ['signature'] )) {
				echo '{"errmsg":"Invalid Signature"}';
				exit ();
			}
			$sign = $source ['signature'];
			unset ( $source ['signature'] );
			$this->load->model ( 'api/signiture_model' );
			$this->load->model ( 'api/common_model' );
			$token = $this->common_model->get_inter_id_token ( $source ['itd'] );
			if (empty ( $token )) {
				echo '{"errmsg":"Invalid Parameter\"itd\",'.$source['itd'].'"}';
				exit ();
			}
			$signature = $this->signiture_model->get_sign ( $source, $token );
			if ($sign != $signature) {
				echo '{"errmsg":"Signiture error"}';
				exit ();
			}
			$result = $this->_auth_res ($source ['code'],$source ['itd']);;
			echo $result;
		} else {
			echo '{"error":"-1"}';
		}
	}
	
	/**
	 * 网页授权通过code获取用户信息
	 * @param String code
	 * @param String 公众号识别码
	 * @return JSON 请求微信返回结果
	 */
	private function _auth_res($code,$inter_id)
	{
		$this->load->model('wx/Publics_model');
		$public=$this->Publics_model->get_public_by_id($inter_id);
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $public ['app_id'] . "&secret=" . $public ['app_secret'] . "&code=$code&grant_type=authorization_code";
			
		$this->load->helper('common');
		return doCurlGetRequest($url);
	}
	
	/**判断域名白名单
	 * @param string $redirect_uri 要验证的链接
	 * @param string $domain 公众号本身域名
	 * @param string $white_domain 域名白名单
	 */
	protected function check_white_domain($redirect_uri,$domain,$white_domains){
		$this->load->helper('string');
		$url_domain=get_url_domain($redirect_uri);
		$domain = get_url_domain($domain);
		$white_domains=json_decode($white_domains,TRUE);
		if (isset($white_domains[$url_domain])||$domain==$url_domain){
			if (isset($white_domains[$url_domain]))
				return $white_domains[$url_domain];
			else if($domain==$url_domain)
				return array();
		}else {
			return FALSE;
		}
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
	
}
