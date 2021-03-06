<?php
class Wxpay_model extends CI_Model{
	public $parameters;//请求参数，类型为关联数组
	public $response;//微信返回的响应
	public $result;//返回参数，类型为关联数组
	var $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";//接口链接
	var $curl_timeout = 30;//curl超时时间
	
	function __construct()
	{
		parent::__construct();
	}

	function trimString($value) {
		$ret = null;
		if (null != $value) {
			$ret = $value;
			if (strlen($ret) == 0) {
				$ret = null;
			}
		}
		return $ret;
	}
	
	/**
	 * 	作用：产生随机字符串，不长于32位
	 */
	public function createNoncestr( $length = 32 ) {
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
		}
		return $str;
	}
	
	/**
	 * 	作用：格式化参数，签名过程需要使用
	 */
	function formatBizQueryParaMap($paraMap, $urlencode) {
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v) {
			if($urlencode) {
				$v = urlencode($v);
			}
			//$buff .= strtolower($k) . "=" . $v . "&";
			$buff .= $k . "=" . $v . "&";
		}
		$reqPar;
		if (strlen($buff) > 0) {
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}
	
	/**
	 * 	作用：生成签名
	 */
	public function getSign($Obj,$pay_paras=array()) {
				

		foreach ($Obj as $k => $v) {
			$Parameters[$k] = $v;
		}
		//签名步骤一：按字典序排序参数
		ksort($Parameters);
		$String = $this->formatBizQueryParaMap($Parameters, false);
		//echo '【string1】'.$String.'</br>';
		//签名步骤二：在string后加入KEY
		// $String = $String."&key=lnlsjyhotel12345678900987654321a";
		$String = $String."&key=".$pay_paras['key'];
		//echo "【string2】".$String."</br>";
		//签名步骤三：MD5加密
		$String = md5($String);
		//echo "【string3】 ".$String."</br>";
		//签名步骤四：所有字符转为大写
		$result_ = strtoupper($String);
		//echo "【result】 ".$result_."</br>";
		return $result_;
	}
	
	
	
	/**
	 * 	作用：array转xml
	 */
	function arrayToXml($arr) {
		$xml = "<xml>";
		foreach ($arr as $key=>$val) {
			if (is_numeric($val)) {
				$xml.="<".$key.">".$val."</".$key.">";
	
			}
			else
				$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
		}
		$xml.="</xml>";
		return $xml;
	}
	
	/**
	 * 	作用：将xml转为array
	 */
	public function xmlToArray($xml) {
		//将XML转为array
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $array_data;
	}
	
	/**
	 * 	作用：以post方式提交xml到对应的接口url
	 */
	public function postXmlCurl($xml,$url,$second=30) {
		//初始化curl
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		//这里设置代理，如果有的话
		//curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
		//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//运行curl
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	/**
	 * 	作用：设置请求参数
	 */
	function setParameter($parameter, $parameterValue)
	{
		$this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
	}
	
	/**
	 * 	作用：设置标配的请求参数，生成签名，生成接口参数xml
	 */
	function createXml_()
	{
		$this->parameters["appId"] = "";
		$this->parameters["mch_id"] = "";
		$this->parameters["nonceStr"] = $this->createNoncestr();//随机字符串
		$this->parameters["sign"] = $this->getSign($this->parameters);//签名
		return  $this->arrayToXml($this->parameters);
	}
	
	/**
	 * 	作用：post请求xml
	 */
	function postXml($pay_paras)
	{
		$xml = $this->createXml($pay_paras);
		$this->response = $this->postXmlCurl($xml,$this->url,$this->curl_timeout);
		return $this->response;
	}
	
	/**
	 * 	作用：使用证书post请求xml
	 */
	function postXmlSSL()
	{
		$xml = $this->createXml_();
		$this->response = $this->postXmlSSLCurl($xml,$this->url,$this->curl_timeout);
		return $this->response;
	}
	
	/**
	 * 	作用：获取结果，默认不使用证书
	 */
	function getResult()
	{
		$this->postXml();
		$this->result = $this->xmlToArray($this->response);
		// $this->db->insert('weixin_text',array('content'=>json_encode($this->result)));
		return $this->result;
	}
	function createXml($pay_paras)
	{
	// $this->db->insert('weixin_text',array('content'=>json_encode($this->parameters)));
		//检测必填参数
		if($this->parameters["out_trade_no"] == null)
		{
			throw new SDKRuntimeException("缺少统一支付接口必填参数out_trade_no！"."<br>");
		}elseif($this->parameters["body"] == null){
			throw new SDKRuntimeException("缺少统一支付接口必填参数body！"."<br>");
		}elseif ($this->parameters["total_fee"] == null ) {
			throw new SDKRuntimeException("缺少统一支付接口必填参数total_fee！"."<br>");
		}elseif ($this->parameters["notify_url"] == null) {
			throw new SDKRuntimeException("缺少统一支付接口必填参数notify_url！"."<br>");
		}elseif ($this->parameters["trade_type"] == null) {
			throw new SDKRuntimeException("缺少统一支付接口必填参数trade_type！"."<br>");
		}elseif ($this->parameters["trade_type"] == "JSAPI" && isset( $this->parameters["openid"] ) && 
				$this->parameters["openid"] == NULL){
			//throw new SDKRuntimeException("统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！"."<br>");
		}
		$this->parameters["appid"] = $pay_paras['app_id'];
		// $this->parameters["appid"] = 'wxa7af1b429e66801f';
		// $this->parameters["mch_id"] = '1225837802';
		$this->parameters["mch_id"] = $pay_paras['mch_id'];
		$this->parameters["spbill_create_ip"] = $_SERVER['REMOTE_ADDR'];//终端ip
		$this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
		$this->parameters["sign"] = $this->getSign($this->parameters,$pay_paras);//签名
		return  $this->arrayToXml($this->parameters);
	}

    /*
     * 提交被扫支付API
     * */
    function createMicropayXml($pay_paras){
        if($this->parameters["out_trade_no"] == null)
        {
            throw new SDKRuntimeException("提交被扫支付API接口中,缺少必填参数out_trade_no！"."<br>");
        }elseif($this->parameters["body"] == null){
            throw new SDKRuntimeException("提交被扫支付API接口中,缺少必填参数body！"."<br>");
        }elseif ($this->parameters["total_fee"] == null ) {
            throw new SDKRuntimeException("提交被扫支付API接口中,缺少必填参数total_fee！"."<br>");
        }elseif ($this->parameters["auth_code"] == null) {
            throw new SDKRuntimeException("提交被扫支付API接口中,缺少必填参数auth_code！"."<br>");
        }
        $this->parameters["appid"] = $pay_paras['app_id'];
        // $this->parameters["appid"] = 'wxa7af1b429e66801f';
        // $this->parameters["mch_id"] = '1225837802';
        $this->parameters["mch_id"] = $pay_paras['mch_id'];
        $this->parameters["spbill_create_ip"] = $_SERVER['REMOTE_ADDR'];//终端ip
        $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
        $this->parameters["sign"] = $this->getSign($this->parameters,$pay_paras);//签名
        return  $this->arrayToXml($this->parameters);
    }
	
	/**
	 * 获取prepay_id
	 */
	function getPrepayId($pay_paras)
	{
		 //$this->db->insert('weixin_text',array('content'=>'1--------'.json_encode($this->result)));
		$resp = $this->postXml($pay_paras);
		$this->result = $this->xmlToArray($resp);
		// $this->db->insert('weixin_text',array('content'=>json_encode($this->resp)));
		 $this->db->insert('weixin_text',array('content'=>'--------'.json_encode($this->result).json_encode($pay_paras),'edit_date'=>date('Y-m-d H:i:s')));
		$this->prepay_id = $this->result["prepay_id"];
		return $this->prepay_id;
	}
	/**
	 * 	作用：设置prepay_id
	 */
	function setPrepayId($prepayId)
	{
		$this->prepay_id = $prepayId;
	}
	
	/**
	 * 	作用：设置code
	 */
	function setCode($code_)
	{
		$this->code = $code_;
	}
	
	function get_parameters(){
		return $this->parameters;
	}
	
	function save_pay_result($array){
		return $this->db->insert('wxpay_result',$array);
	}
	
	function get_pay_paras($inter_id,$type='weixin'){
		$paras=$this->db->get_where('pay_param',array('inter_id'=>$inter_id,'pay_type'=>$type))->result();
		$result=array();
		foreach($paras as $pa){
			$result[$pa->param_name]=$pa->param_value;
		}
		return $result;
	}

	/**微信支付回调签名校验
	 * @param unknown $inter_id
	 * @param unknown $arr
	 * @return boolean
	 */
	function wxpay_return_sign($inter_id,$arr=array()){
		$wx_sign=$arr['sign'];
		unset($arr['sign']);
		$this->load->model('pay/Pay_model');
		$pay_paras = $this->Pay_model->get_pay_paras ( $inter_id, 'weixin' );
		$sign=$this->getSign($arr,$pay_paras);
		return $sign===$wx_sign?TRUE:FALSE;
	}
}
class  SDKRuntimeException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}

}