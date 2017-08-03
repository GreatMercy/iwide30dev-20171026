<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_nz extends MY_Controller {

    protected $_basic_path;
    protected $_redis = null;

    public function __construct() {
        parent::__construct();
        $this->_basic_path = APPPATH . '..' . DS . 'www_admin' . DS . 'public' . DS . 'import' . DS;
        $this->_redis = $this->get_redis_instance();
        if($this->_redis == null)
        {
            die('redis connect fail!');
        }
    }

    protected function _parse_csv_file($file) {
        $csv = fopen($file, 'r');
        $csv_data = array(); 
        $n = 0; 
        while ($data = fgetcsv($csv)) { 
            $num = count($data); 
            for ($i = 0; $i < $num; $i++) { 
                $csv_data[$n][$i] = mb_convert_encoding($data[$i], 'utf-8', 'gbk');//$data[$i]; 
            } 
            $n++; 
        }
        return $csv_data;
    }

    protected function get_inter_domain($inter_id)
    {
        $this->load->model('wx/publics_model', 'wxp_model');
        $public = $this->wxp_model->get_public_by_id($inter_id);
        return empty($public['domain']) ? false : $public['domain'];
    }

    protected function get_target_openids_from_csv($inter_id, $file)
    {
        // 抽取需要发送的订单号、openid
        $csv_data = $this->_parse_csv_file($file);
        unset($csv_data[0]);

        $order_ids = $openids = array();
        foreach ( $csv_data as $row)
        {
            if(!empty($row[0]))
            {
                $order_ids[] = $row[0];
            }
            if(!empty($row[1]) && !in_array($row[1], $openids))
            {
                $openids[] = $row[1];
            }
        }

        //初始化数据库分片配置，微信接口关闭订单需要初始化shard_id
        $this->load->model('soma/shard_config_model', 'model_shard_config');
        $this->current_inter_id= $inter_id;
        $this->db_shard_config= $this->model_shard_config->build_shard_config( $inter_id );

        if(!empty($order_ids))
        {
            $this->load->model('soma/Sales_order_model', 'o_model');
            $orders = $this->o_model->get_order_list('package', $inter_id, array('order_id' => $order_ids));
            if(!empty($orders))
            {
                foreach($orders as $order)
                {
                    if(!in_array($order['openid'], $openids))
                    {
                        $openids[] = $order['openid'];
                    }
                }
            }
        }

        return $openids;
    }

    /**
     * Gets the redis instance.
     *
     * @param      string $select The select
     *
     * @return     Redis|null  The redis instance.
     */
    public function get_redis_instance($select = 'soma_redis')
    {
        $this->load->library('Redis_selector');
        if ($redis = $this->redis_selector->get_soma_redis($select)) {
            return $redis;
        }
        return null;
    }

    public function wdm()
    {
        $inter_id = 'a495077577';
        $template_id = 'mAvBTWgcXSs1gmqeyd3bEL0FUZdWOyWECmr7foF0aSg';
        $file = $this->_basic_path . 'wdm.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://mp.weixin.qq.com/s/rzdXvxyLA2AFHRgmPkwg1Q';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '粉丝福利｜您有一份福利待确认',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '电影票、音乐会门票',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '即日起至2017年6月18日22:00',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击详情立即参与活动',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function upsky_gx()
    {
        $inter_id = 'a470377478';
        $template_id = 'DJvbl5nW_Xh18S9b8ugGCqxj2JUsZ4zxu0QUPgJzxQk';
        $file = $this->_basic_path . 'upsky_gx.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://hotels.liyewl.com/index.php/soma/package/index/?id=a470377478&tkid=82&catid=';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '亲爱的你，UPSKY广西区年中大促即将开启',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '149元自助晚餐、39.9元双人下午茶、799元2晚商务套房限时抢购',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '6月15日20:00正式开启',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击本消息立即订阅',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function jt()
    {
        $inter_id = 'a441624001';
        $template_id = 'eyqP2VTvIuf3qh2jniLXrXzaODF3SGtjxjRTuch8HOE';
        $file = $this->_basic_path . 'jt.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://chatinn.iwide.cn/index.php/soma/package/index?id=a441624001';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '您好：街町酒店618已经开启',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '207元起两晚客房券秒杀',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '6月16日12:00正式开启',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击模版即刻抢购',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function symldm()
    {
        $inter_id = 'a466508403';
        $template_id = 'ZcyMuLi9dFCwI9cxrGfpQXjS3ta5wjqtuqOwBsx0TNE';
        $file = $this->_basic_path . 'symldm.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://symarry.iwide.cn/index.php/soma/package/package_detail?pid=116689&id=a466508403';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '您好：沈阳碧桂园玛丽蒂姆酒店618已经开启',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '618元两晚客房券秒杀、316元买一大一小送一大自助晚餐;',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '6月16日12:00已经正式开启',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击即刻抢购（分享给好友，购买成功即可获得分销奖励5元）',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function csxld()
    {
        $inter_id = 'a492660851';
        $template_id = 'cC6s1U6bGxhWybVtjxej_jVmYkClL8Rud9kAs7XSacc';
        $file = $this->_basic_path . 'csxld.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://hotels.tyxbf.com/index.php/membervip/card/getcard?id=a492660851&card_rule_id=957';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '粉丝福利 | 我们为您预约了一份专属大礼',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '10元商城优惠券（任意正价商品抵用）',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '2017年6月18日-6月23日可用',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击详情立即领取',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function btebg()
    {
        $inter_id = 'a467780350';
        $template_id = '0R1187s4zjDHDsOpUIw8bsDsxziNUdmS8ELKmm1Dbss';
        $file = $this->_basic_path . 'btebg.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://hotels.liyewl.com/index.php/soma/package/index?id=a467780350';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '尊敬的顾客，广州白天鹅宾馆618大促已经开启',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '分享秒杀产品，您的好友购买后，您将获得8元奖励',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '秒杀活动将于明日结束，先到先得',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击模版马上分享',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function cdsjc_open()
    {
        $inter_id = 'a484122795';
        $template_id = 'zm7KXr7RKzYuM55TD2OC--mmrLVUQCcnYEF9jVYACJg';
        $file = $this->_basic_path . 'cdsjc.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://hotels.iwide.cn/index.php/soma/package/index?id=a484122795';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '成都世纪城天堂洲际大饭店·618父出真爱秒杀即将开启~',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '直降100元自助餐24小时限时抢',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '6月18日00:00正式开启',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击即刻订阅',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function cdsjc_close()
    {
        $inter_id = 'a484122795';
        $template_id = 'zm7KXr7RKzYuM55TD2OC--mmrLVUQCcnYEF9jVYACJg';
        $file = $this->_basic_path . 'cdsjc.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://hotels.iwide.cn/index.php/soma/package/index?id=a484122795';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '成都世纪城天堂洲际大饭店·618父出真爱秒杀火热进行中~',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '直降100元自助餐24小时限时抢',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '6月18日23:59秒杀关闭',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '赶紧点击抢购',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function cdhq_open()
    {
        $inter_id = 'a484123441';
        $template_id = 'bNfvt9JC8eUP81GjHdaax1g5Pbjmp99CqBzOGkGSpaI';
        $file = $this->_basic_path . 'cdhq.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://hotels.iwide.cn/index.php/soma/package/index?id=a484123441';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '成都环球中心洲际天堂大酒店丨微信商城618父亲节福利秒杀火热进行时~',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '感恩父亲节全场五折秒杀限量抢购',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '6月17日00:00开启中',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击即刻抢购',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function cdhq_close()
    {
        $inter_id = 'a484123441';
        $template_id = 'bNfvt9JC8eUP81GjHdaax1g5Pbjmp99CqBzOGkGSpaI';
        $file = $this->_basic_path . 'cdhq.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://hotels.iwide.cn/index.php/soma/package/index?id=a484123441';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '成都环球中心洲际天堂大酒店丨微信商城618父亲节福利秒杀结束倒计时6小时~',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '感恩父亲节全场五折秒杀限量抢购',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '6月18日23:59秒杀通道关闭',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击即刻抢购',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function wdm_622()
    {
        $inter_id = 'a495077577';
        $template_id = 'mAvBTWgcXSs1gmqeyd3bEL0FUZdWOyWECmr7foF0aSg';
        $file = $this->_basic_path . 'wdm_622.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://mp.weixin.qq.com/s/hsX2K36C49c7evOkARaWsA';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '粉丝福利｜您有一份福利待确认',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '免费意大利美食节品鉴',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '即日起至2017年6月23日12:00',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击详情进入链接即可参与活动',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function qdhsl_628()
    {
        $inter_id = 'a490782373';
        $template_id = 'hQyT3Lm7R-pnQ4R9Q3eS1vpOzuC6T6nmZsCaPlQxmdA';
        $file = $this->_basic_path . 'qdhsl_628.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://mp.weixin.qq.com/s/MOIIXj0h9biQuBKAuAjGmw';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '青岛红树林702欢乐开启泡泡趴/荧光夜跑活动即将开始',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '您报名的青岛红树林702欢乐开启泡泡趴/荧光夜跑活动将于6月29日-7月1日10:00-16:00在红树林婚礼堂预发装备包，请在此时间段内前往红树林领取。同时请点击填写提交您的个人信息，参与7.02泡泡趴/荧光跑活动保险。点击查看详情＞',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '6月29日-7月1日10:00-16:00',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击模版进入详情',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function qdhsl_630()
    {
        $inter_id = 'a490782373';
        $template_id = 'hQyT3Lm7R-pnQ4R9Q3eS1vpOzuC6T6nmZsCaPlQxmdA';
        $file = $this->_basic_path . 'qdhsl_630.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://1.kuai354.com/index.php/soma/package/index?id=a490782373';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '青岛红树林7.02海边自助晚餐即将启动',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '尊敬的客人您好，您已成功购买青岛红树林度假世界7.02海边自助产品。由于最近天气情况多变，如遇大雨大风等特殊天气，7月2日海边自助盛宴将转移至珊瑚酒店1楼珊瑚宴会厅举行，如有更多问题，请拨打咨询电话：17685596192.',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '7月2日00:00-23:59',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击模版进入商城',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function shuxiang_630()
    {
        $inter_id = 'a449675133';
        $template_id = 'LVCqCmcettpg_vVQbEp2a0c7nBDQnIR_zFtKqc3r8gg';
        $file = $this->_basic_path . 'shuxiang_630.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://soocor.iwide.cn/index.php/soma/package/?id=a449675133';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '书香酒店【周五秒杀】已经开启',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '358元秒杀|荡口古镇+梁鸿湿地双景包价',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '6月30日18:00正式开启',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击即刻抢购',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function csstkbsj_703()
    {
        $inter_id = 'a497598114';
        $template_id = 'h4x2NItvYtL7XplrryHdx4iwB1bpn2UXLWBLvTYDW9k';
        $file = $this->_basic_path . 'csstkbsj_703.csv';

        $data['template_id'] = $template_id;
        $data['url'] = '';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '长沙顺天凯宾斯基酒店商城  粉丝提醒：',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '您秒杀的商品【黄金鸡】',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '商品使用有效期：2017.7.1-2017.7.31 ',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '使用前请提前至少24小时预约，预约电话：0731-8463 3333转祈顺中餐厅',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function syxlwdm_710()
    {
        $inter_id = 'a495426640';
        $template_id = 'N_GqbrNSgQLaWlv559VvReuy4TE89ez8hLfWJ08UDC4';
        $file = $this->_basic_path . 'syxlwdm_710.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://hotels.hfmc99.com/index.php/soma/groupon/groupon_detail?grid=3013&id=a495426640&saler=&fans_saler=15130756&rel_res=';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '亲，你发起的拼团人数距离71人差距尚远，我们已发起官方拼团，您可点击此消息参与',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '龙虾、海鲜自助晚餐（拼团）',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '7.1',
            'color' => '#000000'
        );
        $subdata['keyword3'] = array(
            'value' => '7.1',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '您原支付的钱款我们已在发起退款，预计第二天到账。',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function csxld_713()
    {
        // 1000277687
        $inter_id = 'a492660851';
        $template_id = 'dBkhAgQDVOCjiXtq-a-Wg9uA3vVKep-Ei1SHBUlWsFI';
        $file = $this->_basic_path . 'csxld_713.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://hotels.tyxbf.com/index.php/soma/package/index?id=a492660851&saler=&fans_saler=12896531';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '亲爱的您，自助餐通用券到期提醒',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '您于2017年5月18日购买的150元自助餐通用券即将到期，敬请于有效期内前往营业点使用。预约电话：0731-84888887',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '有效期截止至2017年8月19日',
            'color' => '#000000'
        );
        $subdata['keyword3'] = array(
            'value' => '长沙运达喜来登酒店三楼盛宴西餐厅',
            'color' => '#000000'
        );
        $subdata['keyword4'] = array(
            'value' => '150元（费用已支付）',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function zzmdwh_717()
    {
        $inter_id = 'a496652649';
        $template_id = 'YUOT8BHMgDWzr0YlOYFwbAryoUw02LLw2T37tgakNLs';
        $file = $this->_basic_path . 'zzmdwh_717.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://hotels.hfmc99.com/index.php/soma/package/index?id=a496652649&code=071Tuaox1AcWff0s0gox1brgox1TuaoJ&state=STATE&saler=&fans_saler=13890315';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '二周年商城秒杀7月18日零点开启',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '餐饮&客房大放价，17:00视频直播开启，带您边看直播边秒杀',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '7月18日00:00-23:59',
            'color' => '#000000'
        );
        $subdata['keyword3'] = array(
            'value' => '株洲美的万豪酒店',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function whxgll_718()
    {
        // 1000286253
        $inter_id = 'a492152200';
        $template_id = 'bWe5spsQVo3rDuZEwmB0Qq_KjjCU8I5FZJy3mIEoqdk';
        $file = $this->_basic_path . 'whxgll_718.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://hotels.hfmc99.com/index.php/soma/package/index?id=a492152200';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '商城秒杀7月18日零点开启',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '餐饮&红酒&月饼&房券大礼包，年中钜惠，何止五折！',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '7月18日00:00-23:59',
            'color' => '#000000'
        );
        $subdata['keyword3'] = array(
            'value' => '武汉香格里拉大酒店',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function qdhsl_725()
    {
        // 1000229820
        $pos = $this->input->get('pos', true);
        $inter_id = 'a490782373';
        $template_id = 'hQyT3Lm7R-pnQ4R9Q3eS1vpOzuC6T6nmZsCaPlQxmdA';
        $file = $this->_basic_path . 'qdhsl_725_' . $pos . '.csv';

        $data['template_id'] = $template_id;
        $data['url'] = 'http://1.njt3s.com/index.php/distribute/distribute/reg?id=a490782373';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '恭喜您已成功成为馅饼侠',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '同时您获得了1个“推荐有礼”的资格。您只要成功推荐1名新馅饼侠，即可获得“双升”海景房的机会。即您与新馅饼侠都可获得升海景房资格。',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '即日起至8月20日23:59',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '点击加入：我们一起寻找新的馅饼侠',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function whhkfhxld()
    {
        // 1000306435
        $inter_id = 'a499844461';
        $template_id = 'qbavjDfEm8CaZeNnpuBBh4Mteln67-nZRotULCa9VDc';
        $file = $this->_basic_path . 'whhkfhxld.csv';

        $data['template_id'] = $template_id;
        $data['url'] = '';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '亲，您购买的波士顿龙虾使用时间有变更哦',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '波士顿龙虾使用时间更改',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '购买日起--2017/07/21-2017/09/17',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '武汉汉口泛海喜来登大酒店',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

    public function cskbsj_731()
    {
        $inter_id = 'a497598114';
        $template_id = 'h4x2NItvYtL7XplrryHdx4iwB1bpn2UXLWBLvTYDW9k';
        $file = $this->_basic_path . 'cskbsj_731.csv';

        $data['template_id'] = $template_id;
        $data['url'] = '';
        $data['topcolor'] = '#000000';
        $subdata['first'] = array(
            'value' => '尊敬的客人，您的自助餐通用券到期提醒',
            'color' => '#000000' 
        );
        $subdata['keyword1'] = array(
            'value' => '您于2017年6月29日-7月2日秒杀购买的180元自助餐通用券即将到期，敬请于有效期内前往营业点使用。预约电话：0731-8463 3333',
            'color' => '#000000'
        );
        $subdata['keyword2'] = array(
            'value' => '有效期截止至2017年7月31日',
            'color' => '#000000'
        );
        $subdata['keyword3'] = array(
            'value' => '酒店二楼 元素西餐厅',
            'color' => '#000000'
        );
        $subdata['keyword4'] = array(
            'value' => '180元（费用已支付）',
            'color' => '#000000'
        );
        $subdata['remark'] = array(
            'value' => '',
            'color' => '#000000'
        );
        $data['data'] = $subdata;

        $openids = $this->get_target_openids_from_csv($inter_id, $file);
        $this->load->model('soma/Message_wxtemp_template_model', 't_model');
        $base_key = 'Soma_cron_nz:' . date('Y-m-d') . ':' . __FUNCTION__ . ':';
        foreach ($openids as $openid) {
            $redis_key = $base_key . $openid;
            if($this->_redis->exists($redis_key))
            {
                continue;
            }
            $data['touser'] = $openid;
            $res = $this->t_model->send_template(json_encode($data), $inter_id);
            $this->_redis->set($redis_key, json_encode($res));
        }
        echo 'success';
    }

}