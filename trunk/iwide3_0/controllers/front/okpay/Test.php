<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Test extends MY_Front {
	public $common_data;

    public function __construct(){
        parent::__construct();
        if(isset($_GET['debug'])){
            $this->output->enable_profiler(true);
        }
    }
    public function test(){
       echo  date('Y-m-d',strtotime("-8 days"));
        die;
    }

    function batch_send(){
        $start = $this->input->get('s',true);
        if(empty($start)){
            $start=0;
        }
        set_time_limit ( 0 );
        @ini_set('memory_limit','256M');
        $inter_id = 'a421641095';
        $tag = 'biguiyuan';
        $sql = "SELECT * FROM `iwide_template_send_log` where flag=0 and inter_id = '$inter_id' and tag='$tag' limit 3000"; // 一次发3000条
       //  $sql="SELECT * FROM `iwide_template_send_log` where flag=0 and  inter_id = '$inter_id' and openid='oGaHQjqnmuL51B9dhvGiECR5-zZU' and tag='$tag' limit 1";//取试发的openid
        $openids = $this->db->query ( $sql )->result_array ();//var_dump($openids);die;
        if ($openids) {
            $to_url = 'http://biguiyuan30.iwide.cn/index.php/soma/package/package_detail?pid=112701&id=a421641095'; // 跳转链接 加上 &from=tmpmsg 方便统计来源
            $tmp_id = 'Llyk6QL9Uur9eIufqnChNC2t-jvAypcIwCCdKkqjuJo'; // 模板消息id
            $access_token = '7lvdYduUmF_UuDWrmWWa8lCnHoXKAGZ6t7EdUqAXKnijtCVWsgwtzhEbf-nGJ300d46EBmqdLDZy036k5g0jmuMc1DixwRVv1ttRljP2_T8poNH04tOOPdVC97ANnjmoUHFgAAABOM'; // 线上iwide_access_tokens表 type=0
            $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
            $this->load->helper ( 'common' );
            foreach ( $openids as $s ) {
                $data = array ();
                $data ['template_id'] = $tmp_id;
                if ($data ['template_id']) {
                    $data ['touser'] = $s ['openid'];
                    $data ['url'] = $to_url;
                    $data ['topcolor'] = '#000000';
                    $subdata ['first'] = array (
                        'value' => "年终大促分销奖励通知：",
                        'color' => '#000000'
                    );
                    $subdata ['keyword1'] = array (
                        'value' => '碧桂园再发新招，319元任住碧桂园53家高星酒店1晚，周末不加价',
                        'color' => '#000000'
                    );
                    $subdata ['keyword2'] = array (
                        'value' => '319元',
                        'color' => '#000000'
                    );
                    $subdata ['keyword3'] = array (
                        'value' => '5.00元',
                        'color' => '#000000'
                    );
                    $subdata ['keyword4'] = array (
                        'value' => '2017年6月1日 10:00',
                        'color' => '#000000'
                    );
                    $subdata ['remark'] = array (
                        'value' => "转发链接有销售即可获得5元奖励哦，点击该消息进转发页，动动你的手指，抓紧转发吧！",
                        'color' => '#20773F'
                    );
                    $data ['data'] = $subdata;

                    $result = doCurlPostRequest ( $url, json_encode ( $data ) );
                    $tmp = $result;
                    $result = json_decode ( $result, true );
                    $this->db->where ( 'openid', $s ['openid'] );
                    $this->db->where ( 'inter_id', $inter_id );
                    if ($result ['errcode'] == 0 && $result ['errmsg'] == 'ok') { // 发送成功
                        $this->db->update ( 'iwide_template_send_log', array (
                            'flag' => 1,
                            'status' => 1,
                            'msg' => json_encode ( $result, JSON_UNESCAPED_UNICODE )
                        ) );
                    } else if ($result ['errcode'] == '43004') { // 未关注
                        $this->db->update ( 'iwide_template_send_log', array (
                            'flag' => 1,
                            'status' => 3,
                            'msg' => json_encode ( $result, JSON_UNESCAPED_UNICODE )
                        ) );
                    } else { // 其他
                        $this->db->update ( 'iwide_template_send_log', array (
                            'flag' => 1,
                            'status' => 2,
                            'msg' => json_encode ( $result, JSON_UNESCAPED_UNICODE ) . '---' . $tmp
                        ) );
                    }
                }
            }
            echo 'ok';
        }
    }


    //ceshi
    public function dada(){
        $no = $_GET['no'];
        $f = $_GET['f'];
        $config = array();
        $config['app_key'] = 'dada0bdfd3c8fc42a89';
        $config['app_secret'] = '9a2975ca27686589402bbf33480dcb0b';
        $config['source_id'] = '73753';
        $config['url'] = 'http://newopen.qa.imdada.cn/api/order/' . $f;
        $this->load->library('Dada/DadaOpenapi',$config,'DadaOpenapi');
        //发单请求数据,只是样例数据，根据自己的需求进行更改。
        /* $data = array(
              'shop_no'=> '11047059',
              'origin_id'=> 'FJ149144847353121',
              'city_code'=> '021',
              'pay_for_supplier_fee'=> 0.0,
              'fetch_from_receiver_fee'=> 0.0,
              'deliver_fee'=> 0.0,
             // 'tips'=> 0,
              'info'=> '测试fdf订单',
             // 'cargo_type'=> 1,
              //'cargo_weight'=> 10,
             'cargo_price'=> 10,
              //'cargo_num'=> 2,
              'is_prepay'=> 0,
              'expected_fetch_time'=> 1491462994,
              'expected_finish_time'=> 0,
              'invoice_title'=> 'e测试',
              'receiver_name'=> '测e试',
              'receiver_address'=> '上海e市崇明岛',
              'receiver_phone'=> '18588888888',
              'receiver_tel'=> '18599999999',
              'receiver_lat'=> 31.632,
              'receiver_lng'=> 121.4331,
              'callback'=>'http://dingfang.liyewl.com/index.php/dadareturn/dada_rtn/a450089706',
          );*/
        $data['order_id'] = $no;

//请求接口
        $reqStatus = $this->DadaOpenapi->makeRequest($data);
        var_dump($reqStatus);die;
    }

    /**
     * 定时扫描订单，超过15分钟的未支付订单状态关闭，返还对应的券
     */
    public function update_okpay_order_status(){
        //取出所有未支付的，超过15分钟未支付的订单
        $this->db->where(
            array(
                'pay_status'=>1,
                'create_time>'=>time()-900,
            )
        );
        $unpay_order = $this->db->get('okpay_orders')->result_array();
        if(!empty($unpay_order)){
            foreach($unpay_order as $k=>$v){//关闭超过15分钟未支付订单，同时退还对应的优惠券
                if($v['coupon_type']){
                    //退还券
                    $post_data = array(
                        'inter_id'=>$v['inter_id'],
                        'token'=>$this->_token,
                        'openid'=>$v['openid'],
                    );
                    $coupon_res = $this->doCurlPostRequest( INTER_PATH_URL."membercard/getinfo" , $post_data );
                    //退还记录 记录表
                    $arr['inter_id'] = $v['inter_id'];
                    $arr['order_sn'] = $v['out_trade_no'];
                    $arr['coupon_ids'] = $v['coupon_ids'];
                    $arr['coupon_type'] = $v['coupon_type'];
                    $arr['coupon_money'] = $v['coupon_money'];
                    $this->db->insert('okpay_orders_returncoupon',$arr);
                }
                $this->db->update('okpay_orders',array(
                    'pay_status'=>5,//关闭
                    'update_time'=>time(),
                    'out_trade_no'=>$v['out_trade_no'],
                    'inter_id'=>$v['inter_id'],
                ));
            }
        }
    }

}