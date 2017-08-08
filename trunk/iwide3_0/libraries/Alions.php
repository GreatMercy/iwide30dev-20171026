<?php
class AliMq{
	public function send($data){
		$config = array ();
		$config ['AK'] = 'iwnX2QjN5HXSo6Xh'; // Access Key ID
		$config ['SK'] = 'cRMPkjXIjUp3CuKyJBqhmJbinQOWco'; // Access Key Secret
		$config ['Topic'] = 'iwide_queue_test';
		$config ['PID'] = 'PID_biguiyuan';
		$config ['CID'] = 'CID_biguiyuan';
		$AM = new AliONS ($config);
		$result = $AM->send($data);
	}
	
	public function revice(){
		$config = array ();
		$config ['AK'] = 'iwnX2QjN5HXSo6Xh'; // Access Key ID
		$config ['SK'] = 'cRMPkjXIjUp3CuKyJBqhmJbinQOWco'; // Access Key Secret
		$config ['Topic'] = 'iwide_queue_test';
		$config ['PID'] = 'PID_biguiyuan';
		$config ['CID'] = 'CID_biguiyuan';
		$AM = new AliONS ($config);
		$result = $AM->revice();
		return $result;
	}
}


class AliONS {
	/**
	 * 服务地址(公测)
	 * @var string
	 */
	private $_URL = 'http://publictest-rest.ons.aliyun.com';
	//private $_URL = 'http://beijing-rest-internet.ons.aliyun.com';  //北京

	/**
	 * Access Key
	 * @var string
	 */
	private $_AK;

	/**
	 * SecretAccessKey
	 * @var string
	 */
	private $_SK;

	/**
	 * TopIC
	 * @var string
	 */
	private $_Topic;

	/**
	 * 生产者ID
	 * @var string
	 */
	private $_PID;

	/**
	 * 订阅者ID
	 * @var string
	 */
	private $_CID;

	/**
	 * 时间(毫秒数)
	 * @var string
	 */
	private $_Time;

	/**
	 * 签名
	 * @var string
	 */
	private $_Sign;

	/**
	 * 每次返回数量，AliMQ实际返回的数量可能会比这个数量小
	 * @var string
	 */
	private $_Page= 10;

	/**
	 * Tag过滤
	 * @var string
	 */
	private $_Tag= 'http';

	/**
	 * Key过滤
	 * @var string
	 */
	private $_Key= 'http';
	
	/**
	 * 初始
	 */
	public function __construct($config = array()) {
		foreach ( $config as $key => $val ) {
			$this->{"_" . $key} = $val;
		}
		$this->_Time = $this->_microtime ();
	}

	/**
	 * 发送消息
	 *
	 * @param string $body
	 *        	消息内容
	 * @return array
	 */
	public function send($body) {
		$url = $this->_URL . "/message/?topic={$this->_Topic}&time={$this->_Time}&tag={$this->_Tag}&key={$this->_Key}";
		$signStr = $this->_Topic . "\n" . $this->_PID . "\n" . md5 ( $body ) . "\n" . $this->_Time;
		$this->_signature ( $signStr );
		$stream = $this->_html ( $url, $body, 'POST' );
		return json_decode ( $stream, true );
	}

	/**
	 * 接收消息
	 * 说明：没有消息返回空数组
	 *
	 * @return array
	 */
	public function revice($page=NULL) {
	    if( $page!=NULL ) $this->_Page= $page;
		$url = $this->_URL . "/message/?topic={$this->_Topic}&time={$this->_Time}&num={$this->_Page}";
		$signStr = $this->_Topic . "\n" . $this->_CID . "\n" . $this->_Time;
		$this->_signature ( $signStr );
		$stream = $this->_html ( $url, '', 'GET' );
		return json_decode ( $stream, true );
	}

	/**
	 * 删除消息
	 * 说明：删除成功返回空消息
	 *
	 * @param string $msgHandle
	 *        	消息标识
	 */
	public function delete($msgHandle) {
		$url = $this->_URL . "/message/?msgHandle={$msgHandle}&topic={$this->_Topic}&time={$this->_Time}";
		$signStr = $this->_Topic . "\n" . $this->_CID . "\n" . $msgHandle . "\n" . $this->_Time;
		$this->_signature ( $signStr );
		$stream = $this->_html ( $url, '', 'DELETE' );
		return json_decode ( $stream, true );
	}

	/**
	 * 生成签名
	 *
	 * @param string $signStr
	 * @return string
	 */
	private function _signature($signStr) {
		$this->_Sign = base64_encode ( hash_hmac ( 'sha1', $signStr, $this->_SK, true ) );
	}

	/**
	 * 生成毫秒时间
	 *
	 * @return integer
	 */
	private function _microtime() {
		$time = explode ( " ", microtime () );
		$time = $time [1] . ($time [0] * 1000);
		$time2 = explode ( ".", $time );
		$time = $time2 [0];
		return $time;
	}

	/**
	 * 提交请求数据
	 *
	 * @param string $url
	 *        	地址
	 * @param string $post
	 *        	请求体
	 * @param string $method
	 *        	请求类型 POST|PULL|GET|DELETE
	 * @return mixed
	 */
	private function _html($url, $post = '', $method = 'POST') {
		$header = array ();
		$header [] = 'User-Agent: Jetty/9.3.4.RC';
		$header [] = 'Host:publictest-rest.ons.aliyun.com';
		$header [] = 'AccessKey:' . $this->_AK;
		$header [] = 'Signature:' . $this->_Sign;
		$header [] = 'ProducerId:' . $this->_PID;
		$header [] = 'ConsumerId:' . $this->_CID;
		$header [] = 'Content-Type: text/plain;charset=UTF-8';

		$ch = curl_init ( $url );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 100 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
		if ($method)
			curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, $method );
			if ($post)
				curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
				$html = curl_exec ( $ch );
				curl_close ( $ch );
				return $html;
	}
}