<?php
//error_reporting ( 0 );
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Hkwxpay extends MY_Front {

	public function __construct() {
		parent::__construct ();
		// 开发模式下开启性能分析
		$this->output->enable_profiler ( false );
	}
	function hotel_order() {
		$orderid = $this->input->get ( 'orderid', true );
		$OpenId =  $this->session->userdata ( $this->session->userdata ( 'inter_id' ) . 'openid' );
		// echo $OpenId;
			
		// error_reporting(E_ERROR | E_PARSE );
		date_default_timezone_set("Asia/Hong_Kong");
		$url = 'https://osqt.qfpay.com';
		$api_type = '/trade/v1/payment';
		$mchid = "wVmZKN5nk6Zz3CvKDMkGxajqMV"; //錢台提供的 mchid
		$app_code = '9843E6852D8042E08FCA3D3F1CE9C04A'; //錢台提供的 App Code
		$app_key = '5486DE9AB8BE49178B7B1A12588AE94C'; //錢台提供的 App Key
		$now_time = date("Y-m-d H:i:s"); //獲取當前時間
		//// 拼裝 Post 資料 ////
		$fields_string = '';
		$fields = array(
		'mchid' => urlencode($mchid),
		'out_trade_no' => urlencode($orderid),
		'pay_type' => urlencode(800207),
		'sub_openid' => $OpenId,
		'txamt' => urlencode(10),
		'txdtm' => $now_time 
		);
		ksort($fields); //字典排序 A-Z 升序台式
		foreach($fields as $key=>$value) {
			$fields_string .= $key.'='.$value.'&' ;
		}
		// echo '<br>';
		// echo $fields_string;
		// echo '<br>';

		$fields_string = substr($fields_string , 0 , strlen($fields_string) - 1);
		$sign = '';
		$sign = strtoupper(md5($fields_string . $app_key));
		$header = array();
		$header[] = 'X-QF-APPCODE: ' . $app_code;
		$header[] = 'X-QF-SIGN: ' . $sign;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url . $api_type);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		$output = curl_exec($ch);
		if(curl_exec($ch) === false){
			echo 'Curl error: ' . curl_error($ch);
		}else{
		}
		curl_close($ch);
		// header('Content-type:text/json');
		$final_data = json_decode($output, true);
		// echo "<pre>";
		// var_dump($final_data);
		// echo "</pre>";
		// exit();
		$data ['fail_url'] = site_url ( 'hotel/hotel/myorder' ) . '?id=' . $this->inter_id;
		$data ['success_url'] = $data ['fail_url'];
		$data ['jsApiParameters'] = json_encode($final_data['pay_params']);
		$this->display ( 'pay/hotel_order/wxpay', $data );
	}
	

}

/* End of file Wxpaytest.php */
/* Location: ./application/controllers/Wxpaytest.php */
