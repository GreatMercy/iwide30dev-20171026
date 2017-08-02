<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Subamsgreturn extends MY_Controller {

    public function msgreturn() {
        $inter_id = $this->input->get('id' ); // 公众号内部ID
        if(empty($inter_id) || $inter_id != 'a429262687'){//test
            exit('data error!');
        }
		$this->load->library('MYLOG');
        $content = file_get_contents ( 'php://input' );
        if(empty($content)){
            die ( '这是微信请求的接口地址，直接在浏览器里无效' );
        }
        MYLOG::w('return_res|'.$content,'subamsg');
        /*$content = '{
  "message": {
    "channel_uuid": "ffd7ae2f-1c1c-405c-9587-7baf1b42a3d8",
    "service_uuid": "",
    "user_uuid": "e7e701bc-4c5c-444b-9ee0-bf9c928dd5de",
    "type": "text",
    "data": {
      "text": "this is a test"
    },
    "time": 1484473428700
  },
  "signature": "d460d3bd7c71d5731e7ac5ef5f8f1db46ffc7203e6c0bf0399ca4ad0e3dee920"
}';*/
        $content = json_decode($content,true);
        $client_secret = 'UXQEdyOPqFl7zUKmXrLNGeCSffyvd6e5jaI7kmUh';
        if(isset($content['message']) && !empty($content['message'])){
            $channel_uuid = isset($content['message']['channel_uuid'])?$content['message']['channel_uuid']:'';
            $service_uuid = isset($content['message']['service_uuid'])?$content['message']['service_uuid']:'';
            $user_uuid = isset($content['message']['user_uuid'])?$content['message']['user_uuid']:'';
            $time = isset($content['message']['time'])?$content['message']['time']:'';
            $signature =  isset($content['signature'])?$content['signature']:'';
            $sign = $this->subaSignature($channel_uuid,$service_uuid,$user_uuid,$time,$client_secret);
            if($sign != $signature){
                exit('签名错误！');
            }
            //查询用户
            $openid = $this->db->get_where('subaopenid_uuid',array('uuid'=>$user_uuid))->row_array()['openid'];
            if(empty($openid)){
                exit('data error!');
            }
            //返回的消息类型
            $type = isset($content['message']['type'])?$content['message']['type']:'';
            $this->load->model ( 'wx/access_token_model' );
            $access_token = $this->access_token_model->get_access_token ( $inter_id );
            $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
            $data = '';//消息返回json数组
            if($type == 'text'){
                $msg = $content['message']['data']['text'];
               // $msg = nl2br($msg);
                //判断是否有语音信息返回，有的话就输出语音
                $flag = false;
                if(isset($content['message']['data']['audio']) && !empty($content['message']['data']['audio']['data'])){
                    $audio = $content['message']['data']['audio']['data'];
                    $audio = str_replace(' ', '+', $audio);//替换空格
                    $audio = base64_decode($audio);//解码
                    //本地先保存 再传到微信服务器 再删掉本地的文件
                    $savepath = 'upload/subamsg';
                    $file = $this->saveFile($audio,$savepath);
                    MYLOG::w('生成的文件名|'.$file,'subamsg');
                    if($file){
                        //传到微信
                        $wxfile = $this->uploadFile($file,'voice',$access_token);
                        if($wxfile){
                            $wxfile = json_decode($wxfile,true);
                            if(isset($wxfile['errcode']) && ($wxfile['errcode'] == '40001'||$wxfile['errcode'] == '42001')){
                                $access_token = $this->access_token_model->reflash_access_token ( $inter_id );//只刷新一次
                                $wxfile = $this->uploadFile($file,'voice',$access_token);
                                $wxfile = json_decode($wxfile,true);
                            }
                        }
                        if($wxfile){
                            if(!isset($wxfile['errcode'])){//还有错误就退出了
                                $flag = true;
                                $data = '{"touser":"'.$openid.'","msgtype":"voice","voice":{"media_id":"'.$wxfile['media_id'].'"}}';
                                //删除文件
                                @unlink($file);
                            }
                        }
                    }
                }
                if(!$flag){//默认文本
                    $data = '{"touser":"'.$openid.'","msgtype":"text","text":{"content":"'.$msg.'"}}';
                }
            }elseif($type == 'hybrid'){
                $msg = $content['message']['data']['text'];
              //  $msg = nl2br($msg);
                $args = $content['message']['data']['args'];
                if(!empty($args)){
                    foreach($args as $k=>$v){
                        $link = "<a href='{$v['url']}'>{$v['link_name']}</a>";
                        $msg = str_replace('{'.$k.'}',$link,$msg);
                    }
                }
                $data = '{"touser":"'.$openid.'","msgtype":"text","text":{"content":"'.$msg.'"}}';
            }elseif($type == 'catalog'){
                if(!empty($content['message']['data']['list'])){
                    $data =  '{"touser":"'.$openid.'","msgtype":"news","news":{"articles":[';
                    $msg = '';
                    foreach($content['message']['data']['list'] as $k=>$v){
                        $msg .= '{"title":"'.$v['title'] . '","description":"'.$v['abstract'] .'","url":"' . $v['link'] . '","picurl":"' . $v['cover'] . '"},';
                    }
                    $data .= $msg . ']}}';
                }
            }
            $this->load->helper('common');//var_dump($data);die;
            $res = doCurlPostRequest($url,$data);
            if(isset($res['errcode']) && ($res['errcode'] == '40001'||$res['errcode'] == '42001')){
                $access_token = $this->access_token_model->reflash_access_token ( $inter_id );//只刷新一次
                $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
                $res = doCurlPostRequest($url,$data);
            }
            MYLOG::w('post_param|'.$data,'subamsg');
            MYLOG::w('post_res|'.json_encode($res),'subamsg');
            die;
        }
    }

    //退让接口
    public function msgout(){
        $inter_id = $this->input->get('id' ); // 公众号内部ID
        if(empty($inter_id) || $inter_id != 'a429262687'){//test
            exit('data error!');
        }
        $this->load->library('MYLOG');
        $content = file_get_contents ( 'php://input' );
        if(empty($content)){
            die ( '这是微信请求的接口地址，直接在浏览器里无效' );
        }
        //MYLOG::w('msgout_res|'.$content,'subamsg');
        $content = json_decode($content,true);
        $client_secret = 'UXQEdyOPqFl7zUKmXrLNGeCSffyvd6e5jaI7kmUh';
        if(isset($content['message']) && !empty($content['message'])){
            $channel_uuid = isset($content['message']['channel_uuid'])?$content['message']['channel_uuid']:'';
            $service_uuid = isset($content['message']['service_uuid'])?$content['message']['service_uuid']:'';
            $user_uuid = isset($content['message']['user_uuid'])?$content['message']['user_uuid']:'';
            $time = isset($content['message']['time'])?$content['message']['time']:'';
            $signature =  isset($content['signature'])?$content['signature']:'';
            $sign = $this->subaSignature($channel_uuid,$service_uuid,$user_uuid,$time,$client_secret);
            if($sign != $signature){
                exit('签名错误！');
            }
            //查询用户
            $openid = $this->db->get_where('subaopenid_uuid',array('uuid'=>$user_uuid))->row_array()['openid'];
            if(empty($openid)){
                exit('data error!');
            }
            //返回的消息类型
            $type = isset($content['message']['type'])?$content['message']['type']:'';
            if($type == 'text'){
                $msg = $content['message']['data']['text'];
                //组装XML 推给客服系统
              //  $str = "<xml><ToUserName><![CDATA[gh_dbc66b6ac145]]></ToUserName><FromUserName><![CDATA[ocbScjhmnOPe2zvd_z6WNDtKCiZ0]]></FromUserName><CreateTime>1487847610</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[\u4f60\u597d]]></Content><MsgId>6390154181367725998</MsgId></xml>";
                $msgdata ['ToUserName']   = 'gh_dbc66b6ac145';//公众号id  运营号：gh_dbc66b6ac145
                $msgdata ['FromUserName'] = $openid;
                $msgdata ['CreateTime']   = time();
                $msgdata ['MsgType']      = 'text';
                $msgdata ['Content']      = $msg;
                $msgdata ['MsgId']      = time().rand(10000,99999);
                $xml = new \SimpleXMLElement ( '<xml></xml>' );
                $this->_data2xml ( $xml, $msgdata );
                $str = $xml->asXML ();
                $kefuurl =  "http://kefu.iwide.cn/frontend/web/index.php?r=public/recivemsg";
                $postmsg['msgxml'] = $str;
                $postmsg['interid'] = $inter_id;//a449675133
                MYLOG::w('kefupost_param|'.json_encode($postmsg),'subamsg');
                $res = $this->http_post($kefuurl,$postmsg);
                MYLOG::w('kefupost_res|'.json_encode($res),'subamsg');
                ob_clean();
                echo "";
                exit();
            }

          //  MYLOG::w('post_res|'.json_encode($res),'subamsg');
            die;
        }
    }

    /* 组装xml数据 */
    public function _data2xml($xml, $data, $item = 'item') {
        foreach ( $data as $key => $value ) {
            is_numeric ( $key ) && ($key = $item);
            if (is_array ( $value ) || is_object ( $value )) {
                $child = $xml->addChild ( $key );
                $this->_data2xml ( $child, $value, $item );
            } else {
                if (is_numeric ( $value )) {
                    $child = $xml->addChild ( $key, $value );
                } else {
                    $child = $xml->addChild ( $key );
                    $node = dom_import_simplexml ( $child );
                    $node->appendChild ( $node->ownerDocument->createCDATASection ( $value ) );
                }
            }
        }
    }
    /**
     * POST 请求
     *
     * @param string $url
     * @param array $param
     * @return string content
     */
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

    //速8接入零秒云 签名
    private function subaSignature($channel_uuid,$service_uuid,$user_uuid,$time,$client_secret){
        $str = $channel_uuid.$service_uuid.$user_uuid.$time;
        $sign = hash_hmac('sha256',$str,$client_secret);
        return $sign;
    }

    //保存本地
    private function saveFile($data = '',$path = ''){
        if( $path==FALSE )
            $path= 'qrcode'. '/'. $this->module. '/'. $this->controller. '/'. $this->action;
        $path= FCPATH. FD_PUBLIC. '/'. $path;
        //echo $path;die;
        if( !file_exists($path) ) @mkdir($path, 755, TRUE);
        $filename = time().uniqid().'.mp3';
        //$file= $path. '/'.$filename;
        $flag = false;
        if(file_put_contents($path.'/'.$filename,$data)){
            $flag = true;
        }
        $to_file= str_replace(array('\\','//'), array('/','/'), $path. '/'. $filename);
        if($flag){
            if( !file_exists($to_file) ){
                MYLOG::w('原上传文件不存在|'.$to_file,'subamsg');
                return false;
            }
            chmod($to_file, 0777);
            return $to_file;
        }else{
            return false;
        }
    }

    /* 上传多媒体文件 */
    private function uploadFile($file, $type = 'image', $acctoken = '') {
        $post_data ['type'] = $type; // 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
        $post_data ['media'] = new CURLFile($file);

        $url = "http://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$acctoken."&type=".$type;
        // 开启curl表单
        $ch = curl_init();
        if (class_exists('CURLFile'))
        {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        }else{
            if (defined('CURLOPT_SAFE_UPLOAD'))
            {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            }
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );

        // 得到返回信息
        $response = curl_exec ( $ch );
        //关闭cURL资源，并且释放系统资源
        curl_close($ch);
        if($response){
            return $response;
        }else{
            return false;
        }
    }
}
