<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SignIn_model
 *
 * @author vencelyang
 */
class Signin_model extends MY_Model_Member
{
    protected $table_record = 'iwide_sign_in_record';// 签到记录表
    protected $table_stat = 'iwide_sign_in_stat';// 签到统计表
    protected $table_conf = 'iwide_sign_in_conf';// 签到设置表

    /**
     * 获取配置数据
     * @param string $inter_id 集团微信id
     * @param string $field
     * @return array|null
     */
    public function get_conf_info($inter_id, $field = '*')
    {
        if (empty($inter_id))
            return null;

        return $this->_shard_db()->select($field)->from($this->table_conf)->where(array('inter_id' => $inter_id))->get()->row_array();
    }

    /**
     * 获取会员模式
     * @param string $inter_id 酒店集团ID
     * @return null|string
     */
    public function get_member_mode($inter_id=''){
        $mode = $this->_shard_db()->select('value')->where(array('inter_id'=>$inter_id,'type_code'=>'member'))->get('inter_member_config')->row_array();
        if($mode) return $mode['value'];
        return null;
    }

    /**
     * 检测会员是否需要登录(分不同会员模式)
     * @param string $inter_id 酒店集团ID
     * @param string $openid 微信ID
     * @return bool
     */
    public function check_login($inter_id='',$openid=''){
        $is_login = false;
        $this->_write_log(func_get_args(),'func_get_args');
        $member_mode = $this->get_member_mode($inter_id); //获取会员模式
        $this->_write_log($member_mode,'get_member_mode');
        if($member_mode=='login'){ //登录模式
            $member_info = $this->get_member_info($inter_id,$openid,2,'is_login');
            if(!empty($member_info) && $member_info['is_login']=='t') $is_login = true;
        }elseif ($member_mode=='perfect'){ //完善資料模式
            $member_info = $this->get_member_info($inter_id,$openid,1,'is_login');
            if(!empty($member_info)) $is_login = true;
        }
        $this->_write_log($member_info,'get_member_info');
        return $is_login;
    }


    /**
     * 获取单条会员卡信息
     * @param string $inter_id 酒店集团ID
     * @param string $openid 微信ID
     * @param string $field 获取字段
     * @return array
     */
    public function get_member_info($inter_id='',$openid='',$member_mode=1,$field='*'){
        if(empty($inter_id)) return array();
        $where = array('inter_id'=>$inter_id,'open_id'=>$openid,'member_mode'=>$member_mode,'is_active'=>'t');
        if($member_mode==2) $where['is_login'] = 't';
        $member_info = $this->_shard_db()->select($field)->where($where)->get('member_info')->row_array();
        return $member_info;
    }

    /**
     * 签到操作
     * @param string $inter_id 集团微信id
     * @param string $openid 微信OpenID
     * @param int $memid 会员卡ID
     * @return array|null（errcode,0：操作失败，1：操作成功，-1：重复操作）
     */
    public function sign_in_handle($inter_id, $openid, $memid = 0)
    {
        if (empty($inter_id) || empty($openid) || empty($memid))
            return null;
        $check_login = true;
        if ($inter_id!='a492669988')
            $check_login = $this->check_login($inter_id,$openid);
        
        if($check_login===false) return array('errcode' => -2, 'msg' => '亲，您还没有登录会员哦，请先登录！', 'is_serial' => 0);

        // 获取签到设置
        $confInfo = $this->get_conf_info($inter_id);
        if (empty($confInfo) || !$confInfo['is_active']) {
            return array('errcode' => 0, 'msg' => '活动尚未开启，敬请期待', 'is_serial' => 0);
        }

        $time = time();
        $ymd = date('Ymd', $time);
        $sign_date = date('Y-m-d H:i:s', $time);

        $where = array();
        $where['inter_id'] = $inter_id;
        $where['openid'] = $openid;
        $where['member_info_id'] = $memid;
        $where['ymd'] = $ymd;
        // 获取最后签到记录
        $lastInfo = $this->get_last_sign_in_record($inter_id, $openid, $memid);
        if ($lastInfo['ymd'] == $ymd) {// 判断是否已签到
            return array('errcode' => -1, 'msg' => '您已签到', 'is_serial' => 0);
        }

        // 整理签到数据
        if (strtotime($lastInfo['sign_at']) >= strtotime(date('Y-m-d', strtotime(date('Y-m-d H:i:s', $time) . '-1 day')))) {// 判断最后一次签到是否为昨天
            $serial_days = $lastInfo['serial_days'] + 1;
        } else {
            $serial_days = 1;
        }
        if ($serial_days % $confInfo['serial_days'] == 0) {
            $is_serial = true;
            $bonus_extra = $confInfo['bonus_extra'];
        } else {
            $is_serial = false;
            $bonus_extra = 0;
        }
        $data = array(
            'inter_id' => $inter_id,
            'openid' => $openid,
            'member_info_id'=>$memid,
            'ymd' => $ymd,
            'day_ranking' => 0,
            'bonus' => $confInfo['bonus_day'],
            'bonus_extra' => $bonus_extra,
            'serial_days' => $serial_days,
            'sign_at' => $sign_date,
        );

        // 整理签到统计数据
        $accumulative_bonus = $confInfo['bonus_day'] + $bonus_extra;
        if (empty($lastInfo)) {// 判断是否有签到数据
            $statData = array(
                'inter_id' => $inter_id,
                'openid' => $openid,
                'member_info_id'=>$memid,
                'accumulative_days' => 1,
                'bonus_ym' => date('Ym', $time),
                'accumulative_bonus' => $accumulative_bonus,
                'create_at' => $sign_date,
                'update_at' => $sign_date,
            );
        }

        // 开启事务
        $this->_shard_db(true)->trans_begin();
        try {
            // 新增签到记录
            $res_record_insert = $this->_shard_db(true)->insert($this->table_record, $data);
            if (!$res_record_insert) {// 判断新增是否成功
                throw new Exception();
            }

            // 更新今日排名，防并发排名
            $new_id = $this->_shard_db(true)->insert_id();// 新增id
            $sql = "select count(*) as total
                    from {$this->table_record}
                    where inter_id = '{$inter_id}' and ymd = '{$ymd}' and sign_at < '{$sign_date}'
                    or (sign_at = '{$sign_date}' and id < '{$new_id}')";
            $res_record_total = $this->_shard_db()->query($sql)->row_array();
            $day_ranking = $res_record_total['total'] + 1;// 今天排名
            $res_record_update = $this->_shard_db(true)->update($this->table_record, array('day_ranking' => $day_ranking), array('id' => $new_id));
            if (!$res_record_update) {// 判断更新排名是否成功
                throw new Exception();
            }

            // 记录统计数据
            if (empty($lastInfo)) {// 判断是否有签到数据
                $res_stat_insert = $this->_shard_db(true)->insert($this->table_stat, $statData);
                if (!$res_stat_insert) {// 判断新增是否成功
                    throw new Exception();
                }
            } else {
                // 获取统计数据
                $res_stat_ym = $this->get_sign_in_stat($inter_id, $openid, $memid, 'bonus_ym');
                $ym = date('Ym', $time);
                if ($res_stat_ym['bonus_ym'] == $ym) {// 判断积分年月是否为当前年月
                    $set_accumulative_bonus = "accumulative_bonus + {$accumulative_bonus}";
                    $set_stat_ym = "";
                } else {
                    $set_accumulative_bonus = $accumulative_bonus;
                    $set_stat_ym = ",bonus_ym = {$ym}";
                }
                // 更新统计数据
                $sql = "update {$this->table_stat}
                        set update_at = '{$sign_date}',accumulative_days = accumulative_days + 1,accumulative_bonus = {$set_accumulative_bonus}{$set_stat_ym}
                        where inter_id = '{$inter_id}' and openid = '{$openid}'";
                $res_stat_update = $this->_shard_db(true)->query($sql);
                if (!$res_stat_update) {// 判断更新是否成功
                    throw new Exception();
                }
            }
            // 添加会员积分
            $remark = "签到，赠送{$confInfo['bonus_day']}积分";
            if (!empty($bonus_extra)) {// 判断是否有赠送额外积分
                $remark .= "；连续签到，额外赠送{$bonus_extra}积分";
            }


            if($inter_id == 'a421641095'){
                $new_id = "{$new_id},,,每日签到,WX";
                $remark = "每日签到，赠送{$confInfo['bonus_day']}积分";
                if (!empty($bonus_extra)) {// 判断是否有赠送额外积分
                    $remark .= "；连续签到，额外赠送{$bonus_extra}积分";
                }
            }

            $post_data = array(
                'openid' => $openid,
                'inter_id' => $inter_id,
                'module' => 'sign',
                'count' => $accumulative_bonus,
                'uu_code' => 'sign_' . $new_id,
                'remark' => $remark,
                'order_id' => $new_id,
                'token' => '',
            );
            $res_bonus = $this->_add_credit($post_data);
            /*if (!$res_bonus) {// 判断添加会员积分是否成功
                throw new Exception();
            }*/

            $this->_shard_db(true)->trans_commit();// 事务提交
        } catch (Exception $e) {
            $this->_shard_db(true)->trans_rollback();// 事务回滚
            return array('errcode' => 0, 'msg' => '签到失败，请稍后重试', 'is_serial' => $is_serial ? 1 : 0);
        }

        return array('errcode' => 1, 'is_serial' => $is_serial ? 1 : 0);
    }

    /**
     * 添加会员积分
     * @param $params array 请求数组
     * @return bool
     */
    private function _add_credit($params)
    {
        $url = INTER_PATH_URL . 'credit/add';
        $post_data = array(
            'openid' => $params['openid'],
            'inter_id' => $params['inter_id'],
            'module' => $params['module'],
            'count' => $params['count'],
            'uu_code' => $params['uu_code'],
            'remark' => $params['remark'],
            'order_id' => $params['order_id'],
            'token' => $params['token'],
        );
        $post_data = http_build_query($post_data);
        $this->load->helper('common');
        $startime = microtime(true);
        MYLOG::w("Start_sign_add_credit | ".@json_encode(array('url'=>$url,'post'=>$post_data,'startime'=>$startime)),'membervip/debug-log');
        $result = json_decode(doCurlPostRequest($url, $post_data, null, 20), true);
        $endtime = microtime(true);
        $usetime = $endtime - $startime;
        if($usetime > 10){
            MYLOG::w("Complete_sign_add_credit | Timeout_sign_add_credit | ".@json_encode(array('result'=>$result,'url'=>$url,'post'=>$post_data,'usetime'=>$usetime)),'membervip/debug-log');
        }else{
            MYLOG::w("Complete_sign_add_credit | ".@json_encode(array('result'=>$result,'url'=>$url,'post'=>$post_data,'usetime'=>$usetime)),'membervip/debug-log');
        }

        if(isset($result['err']) && $result['err'] == '0'){
            return true;
        }
        return false;
    }

    /**
     * 获取会员签到数据
     * @param string $inter_id 集团微信id
     * @param string $openid 微信OpenID
     * @param int $memid 会员卡ID
     * @return array|null
     */
    public function get_sign_info($inter_id, $openid, $memid = 0)
    {
        if (empty($inter_id) || empty($openid) || empty($memid))
            return null;

        // 获取最后签到记录
        $lastInfo = $this->get_last_sign_in_record($inter_id, $openid,$memid);
        // 获取签到统计记录
        $statInfo = $this->get_sign_in_stat($inter_id, $openid,$memid);

        // 初始化签到数据
        $data = array();
        $data['is_sign'] = false;
        $data['day_ranking'] = 0;
        $data['serial_days'] = 0;
        $data['accumulative_bonus'] = 0;
        $data['accumulative_days'] = 0;

        // 整理签到数据
        if ($lastInfo && $statInfo) {// 判断是否存在签到数据
            if ($lastInfo['ymd'] == date('Ymd')) {// 判断最后签到是否为今天
                $data['is_sign'] = true;
                $data['day_ranking'] = $lastInfo['day_ranking'];
            }
            if (strtotime($lastInfo['sign_at']) >= strtotime(date('Y-m-d', strtotime('-1 day')))) {// 判断最后签到是否为昨天或今天
                $data['serial_days'] = $lastInfo['serial_days'];
            }
            if ($statInfo['bonus_ym'] == date('Ym')) {// 判断积分年月是否为当今年月
                $data['accumulative_bonus'] = $statInfo['accumulative_bonus'];
            }
            $data['accumulative_days'] = $statInfo['accumulative_days'];
        }

        return $data;
    }

    /**
     * 获取会员最后签到记录
     * @param string $inter_id 集团微信id
     * @param string $openid 微信OpenID
     * @param string $field 获取字段
     * @param int $memid 会员卡ID
     * @return array|null
     */
    public function get_last_sign_in_record($inter_id = '', $openid = '', $memid = 0 ,$field = '*')
    {
        if (empty($inter_id) || empty($openid) || empty($memid))
            return null;

        $where = array();
        $where['inter_id'] = $inter_id;
       
        if ($inter_id!='a492669988'){
            $where['member_info_id'] = $memid;
        }else {
            $where['openid'] = $openid;
        }
        return $this->_shard_db()->select($field)->from($this->table_record)->where($where)->order_by('sign_at', 'desc')->limit(1)->get()->row_array();
    }

    /**
     * 获取会员签到统计记录
     * @param string $inter_id 集团微信id
     * @param string $openid 微信OpenID
     * @param string $field 获取字段
     * @param int $memid 会员卡ID
     * @return array|null
     */
    public function get_sign_in_stat($inter_id, $openid, $memid = 0, $field = '*')
    {
        if (empty($inter_id) || empty($openid) || empty($memid))
            return null;

        $where = array();
        $where['inter_id'] = $inter_id;
        
        if ($inter_id!='a492669988'){
            $where['member_info_id'] = $memid;
        }else {
            $where['openid'] = $openid;
        }
        return $this->_shard_db()->select($field)->from($this->table_stat)->where($where)->get()->row_array();
    }

    /**
     * 获取排行数据
     * @param string $inter_id 集团微信id
     * @param int page 页码，默认为0，第一页
     * @param string $ymd 签到年月日，默认为当天
     * @return array
     */
    public function get_day_ranking_data($inter_id, $page = 0, $ymd = '')
    {
        if (empty($inter_id))
            return null;

        if (empty($ymd))
            $ymd = date('Ymd');

        $where = array();
        $where['r.inter_id'] = $inter_id;
        $where['r.ymd'] = $ymd;
        $pageSize = 50;
        $page = intval($page);
        $offset = $page * $pageSize;
        if ($inter_id!='a492669988'){
            $res_count = $this->_shard_db()
                ->select('count(*) as num')
                ->from($this->table_record . ' as r')
                ->join('iwide_member_info as mi', 'mi.inter_id = r.inter_id and mi.member_info_id = r.member_info_id', 'left')
                ->where($where)
                ->get()->row_array();
        }else{
            $res_count = $this->_shard_db()
                ->select('count(*) as num')
                ->from($this->table_record . ' as r')
                ->join('iwide_member_info as mi', 'mi.inter_id = r.inter_id and mi.open_id = r.openid', 'left')
                ->where($where)
                ->get()->row_array();
        }

        $end = $res_count['num'] > $page * $pageSize ? 0 : 1;
        if (!$end) {// 判断是否有分页数据
            if ($inter_id!='a492669988'){
                $sql = "select r.inter_id,r.openid,r.ymd,r.day_ranking,r.sign_at,mi.name,mi.nickname,mi.member_mode,mi.cellphone
                    from {$this->table_record} r
                    left join iwide_member_info mi on mi.inter_id = r.inter_id and mi.member_info_id = r.member_info_id
                    where r.inter_id = '{$inter_id}' and r.ymd = '{$ymd}'
                    order by sign_at
                    limit {$offset},{$pageSize}";
            }else{
                $sql = "select r.inter_id,r.openid,r.ymd,r.day_ranking,r.sign_at,mi.name,mi.nickname,mi.member_mode,mi.cellphone
                    from {$this->table_record} r
                    left join iwide_member_info mi on mi.inter_id = r.inter_id and mi.open_id = r.openid
                    where r.inter_id = '{$inter_id}' and r.ymd = '{$ymd}'
                    order by sign_at
                    limit {$offset},{$pageSize}";
            }

            $data = $this->_shard_db()->query($sql)->result_array();
            foreach ($data as &$d) {
                $d['ranking_date'] = date('n月j日 H:i:s', strtotime($d['sign_at']));
                $name = '微信用户';
                if($d['member_mode']=='1'){
                    $name = !empty($d['cellphone'])?$d['name']:(!empty($d['nickname'])?$d['nickname']:$name);
                }elseif($d['member_mode']=='2'){
                    $name = !empty($d['name'])?$d['name']:(!empty($d['nickname'])?$d['nickname']:$name);
                }

                if(!empty($name)){
                    $name = trim(str_replace(array("\r\n", "\r", "\n", "\t"), "", $name));
                    $name = mb_substr($name, 0,1,'utf-8').'**';
                }else{
                    $name = '***';
                }
                $d['name'] = $name;
            }
        } else {
            $data = array();
        }

        return array('end' => $end, 'data' => $data);
    }

    /**
     * 运行日志记录
     * @param String $content
     */
    protected function _write_log( $content,$type ) {
        if(is_array($content) || is_object($content)) $content = json_encode($content);
        $file= date('Y-m-d_H'). '.txt';
        $path= APPPATH. 'logs'.DS.'front'.DS. 'membervip'. DS. 'signin'. DS;
        if( !file_exists($path) ) {
            @mkdir($path, 0777, TRUE);
        }
        $ip= $this->input->ip_address();
        $fp = fopen( $path. $file, 'a');

        $content= "\n[". date('Y-m-d H:i:s'). '] [' . $ip. "] $type '". $content. "' starting...";
        fwrite($fp, $content);
        fclose($fp);
    }
}