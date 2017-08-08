<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kargo extends CI_Controller {

	public function test()
	{
	    /**
	     * HTTP-Verb 
              GET/POST/PUT/DELETE (defined for each method)
         * Message-Content-MD5  
              This is a MD5 hash of the message body contained in the 
              request message. 
	     * StringToSign = HTTP-Verb + "\n" + 
              Message-Content-MD5 + "\n" + 
              UTC-Date + "\n" + 
              CanonicalizedAPIEndPoint 
	     * Signature = HexEncode(Base64( HMAC-SHA256( kc-secret-key, UTF-8-Encoding-Of( StringToSign ) ) )); 
	     */
	    $authid= "mer-123456";
	    $secret= "kargocard";
	    $verb= 'POST';
	    $apiUrl= 'https://uat.digital.kargocard.com:8443/DigitalREST/api/ver1.1/order';
	    
	    $message= json_encode(array(
	        "get-ord-details"=> FALSE,
	        "mer-id"=> "00062000000",
	        "mer-ord-id"=> "20160226000791",
	        "ord-create-date"=>"20160226183444",
	        "ord-delivery-date"=>"20160226183444",
			"ord-sender"=> array(
				"sender-id"=> "abc",
			),
			"ord-receiver"=> array(
				"receiver-id"=> "xyz",
			),
	        "ord-item"=> array( array(
	           "face-value"=> 100,
	           "price"=> 100,
	           "qty"=> 3,
	           "upc"=> "8862100000060",
	        ) ),
	        "ord-pymt-rcvd"=> TRUE,
	    ));
	    $message= json_encode(array(
	        "mer-id"=> "00062000000",
	        "mer-ord-id"=> "20160226000791",
	        "kc-ord-id"=> "1173515",
	        "get-ord-details"=> TRUE,
	        "include-code-details"=> TRUE,
	    ));
	    //$message= '{"merchantID":"11111999990","temrinalID":"123456789","mer-OrderID":"14101618082389756"}';
	    //$message= '{"get-ord-details":false,"mer-id":"00062000000","mer-ord-id":"20160223183444","ord-create-date":"20160223183444","ord-delivery-date":"20160223183444","ord-item":[{"face-value":100,"price":100,"qty":1,"upc":"8862100000060"}],"ord-pymt-rcvd":false}';
	    //echo $message;die;  //7d66dba23b9b9574cfe825b7261e6cc3
	    
	    $rtime= '1416171565'* 1000;//time();
	    $endpoint= '/api/ver1.1/order';
	    
	    $toSign= $verb. "\n". strtoupper( md5($message) ). "\n". $rtime. "\n". $endpoint;
	    //echo $toSign;die;
	    
	    $sign= hash_hmac( "sha256", utf8_encode( $toSign ), utf8_encode( $secret ) );
	    //echo strtoupper($sign);die;
	    
	    $result= "kc-". $authid. ":". strtoupper($sign);
	    //echo $result;die;
	    
	    $crl = curl_init();
	    $headr = array();
	    $headr[] = 'Authorization:'. $result;
	    $headr[] = 'kc-utc-date:'. $rtime;
	    $headr[] = 'Content-Type: application/json;charset=UTF-8';
	    //print_r($headr);die;
	    curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
	    
        curl_setopt($crl, CURLOPT_URL, $apiUrl);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $message);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($crl, CURLOPT_POST, true);

       	curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false );
      	curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false );

	    $rest = curl_exec($crl);

	    echo $rest;  //显示结果： boolean false
	    print_r(json_decode($rest));
	    curl_close($crl);
	}
	
	public function decrypt()
	{
	    $str= 'Q33F7Y2L73QMGKCGD397AABA7B701ACC0DBCDA1B9D54E77AA32B59B58A01A1EE359C974F52D979FB';
	    $key= '6L2F94N54RE88OLB';
	    $iv= 'Q33F7Y2L73QMGKCG';
	    $cipher= 'D397AABA7B701ACC0DBCDA1B9D54E77AA32B59B58A01A1EE359C974F52D979FB';
	    
// 	    $this->load->library('encryption');
// 	    $this->encryption->initialize(
// 	        array(
// 	            'cipher' => 'aes-128',
// 	            'mode' => 'cbc',
// 	            'key' => $key
// 	        )
// 	    );
//	    $result= $this->encryption->decrypt( $cipher );

	    echo $result = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, hex2bin( $cipher ), MCRYPT_MODE_CBC, $iv );
	    
	}


// 	protected $_key= 'KARGOANDEGIFTING';
// 	protected $_iv = 'FHAE5908SAGAG8AC';
    protected $_key= 'KARGOANDEGIFTINB';
    protected $_iv= 'FHAE5908SAGAG8AB';

	public function decrytion($data, $key=NULL, $iv=NULL)
	{
	    if($key==NULL) $key= $this->_key;
	    if($iv==NULL) $iv= $this->_iv; 
	    //$data = mb_substr($data, 16, mb_strlen($data, 'utf8'), 'utf8');
	    $td = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, hex2bin( trim($data) ), MCRYPT_MODE_CBC, $iv );
	    return trim($td);
	}
	public function encrytion($data, $key=NULL, $iv=NULL)
	{
	    if($key==NULL) $key= $this->_key;
	    if($iv==NULL) $iv= $this->_iv; 
	    // 是卡购系统加密时插入的无名字符串
	    $td = bin2hex( mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, trim($data). "", MCRYPT_MODE_CBC, $iv ) );
	    return trim($td);
	}

	public function test2()
	{
                             //17db36f866eb221a6078190efc3139916f73dcd74cb903d584c9bc7fd3cf24a8cb12d9ce71953ef58d7b60f6eb11b05f9b8f24e562da8e0d561b3e9367a8d40b4c98d9bf85188f200cd70d97b8dd8aa9b20c81fdc3f265c55f23f2d1b8ce215f
// 	    echo $a= $this->decrytion('17db36f866eb221a6078190efc3139916f73dcd74cb903d584c9bc7fd3cf24a8cb12d9ce71953ef58d7b60f6eb11b05f9b8f24e562da8e0d561b3e9367a8d40b4c98d9bf85188f200cd70d97b8dd8aa95f3ae55845fc9a642fd296a56ed7610b');
// 	    echo "<br/>\n";
// 	    echo $this->encrytion("grant_type=client_credential&appid=wx5f969321cf58a9d5&secret=32e64d96956c200d19524698c3f59bc6");
//         die; 
        
	    $this->load->helper ( 'common' );
	    $base_string= "grant_type=client_credential&appid=wx992e5c06624b1a6e&secret=901647c10c10a2b8a0487324d8794706";
	    $signature= $this->encrytion( $base_string );
	    //$url   = "https://mycard.kargocard.com/CHolder/control/token?grant_type=client_credential&appid=wx5f969321cf58a9d5&secret=32e64d96956c200d19524698c3f59bc6&signature=cb58c299565605e603e65405df1e4d096c369c42dbf9d76b615b201f38bd1b54bc7acfd375a931499b5855b5608783db9dfa6144170f0146056daa9f5aef39be29fbfe72693db05244fab04026dc70283656ac0b13449ec19afef2183e486ca2" ;
	    //$url   = "https://uat.digital.kargocard.com/CHolder/control/token?grant_type=client_credential&appid=wx5f969321cf58a9d5&secret=32e64d96956c200d19524698c3f59bc6&signature=17db36f866eb221a6078190efc3139916f73dcd74cb903d584c9bc7fd3cf24a8cb12d9ce71953ef58d7b60f6eb11b05f9b8f24e562da8e0d561b3e9367a8d40b4c98d9bf85188f200cd70d97b8dd8aa95f3ae55845fc9a642fd296a56ed7610b" ;
	    $url   = "https://mycard.kargocard.com/CHolder/control/token?{$base_string}&signature={$signature}" ;
	    echo $url;die;
	    $data  = doCurlGetRequest ( $url );
	    $data  = json_decode ( $data, true );
	    print_r($data);die;
	
	}
	
	
}
