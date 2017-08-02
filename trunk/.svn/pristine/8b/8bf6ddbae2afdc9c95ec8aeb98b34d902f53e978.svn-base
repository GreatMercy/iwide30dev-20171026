<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Upgrade_page extends MY_Controller {


	public function index(){

        $this->load->view('upgrading');
    }


    public function test(){
        $openid = 'o4F21jvhC4nKvFiVO492B2XzncOQ';
        $qrcode_id = 1000;

        /*访问限制*/
        $redis = new Redis();
        $redis->connect('30.iwide.cn',16379);
        $this->load->library ("MYLOG");

        $key = $openid.$qrcode_id;
        $timeRecord = $redis->get($key);
        if($timeRecord){
            if(time() - $timeRecord > 2){
                $flag = $redis->setNx($key,time());
                if(!$flag){
                    $this->load->library ("MYLOG");
                    MYLOG::w(__LINE__." Reply_by_qrcode result : 会员卡绑定失败：扫描绑定间隔低于2秒 | ".$qrcode_id,'debug-log');
                    exit();
                }
            }else{
                MYLOG::w(__LINE__." Reply_by_qrcode result : 会员卡绑定失败：扫描绑定间隔低于2秒 | ".$qrcode_id,'debug-log');
                exit();
            }

        }else{
            $flag = $redis->setNX($key,time());
            if(!$flag){
                MYLOG::w(__LINE__." Reply_by_qrcode result : 会员卡绑定失败：扫描绑定间隔低于2秒 | ".$qrcode_id,'debug-log');
                exit();
            }
            $redis->expire($key,10);
            MYLOG::w(__LINE__." Reply_by_qrcode result : 会员成功 | ".$qrcode_id,'debug-log');
        }

        /*访问限制*/
    }
}
