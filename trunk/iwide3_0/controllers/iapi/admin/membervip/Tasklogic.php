<?php
// +----------------------------------------------------------------------
// | 优惠发放任务
// +----------------------------------------------------------------------
// | Author: liwensong <septet-l@outlook.com>
// +----------------------------------------------------------------------
// Tasklogic.php 2017-06-16
// +----------------------------------------------------------------------
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Tasklogic
 * @property Public_model $common_model
 * @property Card_model $card_model
 * @property Package_model $package_model
 * @property Member_model $member_model
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Loader $load
 */
class Tasklogic extends MY_Admin_Iapi
{
    protected $args        = array();
    private $admin_profile = array();
    private $client_ip     = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('membervip/common/Public_model', 'common_model');
        $this->load->model('membervip/common/Public_log_model', 'common_logm');
        $this->load->library("MYLOG");
        $this->load->helper('common_helper');
        $this->args      = get_args();
        $this->client_ip = $this->input->ip_address();
        MYLOG::w(@json_encode(array('args' => $this->args, 'client_ip' => $this->client_ip)), 'admin/membervip/debug-log', 'task-call');
        $this->admin_profile = $this->session->userdata['admin_profile'];
    }

    public function first_create_check()
    {
        $msg = array(
            'status' => 1004,
            'err'    => '99999',
            'msg'    => '请求失败',
        );

        if (empty($this->admin_profile['inter_id'])) {
            $msg['status'] = 1004;
            $msg['err']    = '49999';
            $msg['msg']    = 'inter_id is null';
            $this->_ajaxReturn($msg);
        } else {
            $msg = $this->first_check_task();
            $this->_ajaxReturn($msg);
        }
    }

    public function next_create_check()
    {
        $msg = array(
            'status' => 1004,
            'err'    => '99999',
            'msg'    => '请求失败',
        );

        if (empty($this->admin_profile['inter_id'])) {
            $msg['status'] = 1004;
            $msg['err']    = '49999';
            $msg['msg']    = 'inter_id is null';
            $this->_ajaxReturn($msg);
        } else {
            $msg = $this->next_check_task();
            $this->_ajaxReturn($msg);
        }
    }

    public function save_create()
    {
        $msg = $this->first_check_task();
        if ($msg['status'] != 1000) {
            $this->_ajaxReturn($msg);
        }

        $msg = $this->next_check_task();
        if ($msg['status'] != 1000) {
            $this->_ajaxReturn($msg);
        }

        $post_data = $this->args;
        if (empty($this->admin_profile['inter_id'])) {
            $msg['status'] = 1004;
            $msg['err']    = '49999';
            $msg['msg']    = 'inter_id is null';
            $this->_ajaxReturn($msg);
        }

        $inter_id = $this->admin_profile['inter_id'];
        if (!empty($post_data['id'])) {
            $where = array(
                'inter_id'  => $inter_id,
                'task_id'   => $post_data['id'],
                'is_active' => 't',
            );

            $task_info = $this->common_model->get_info($where, 'send_task', 'task_id,send_time');
            if (empty($task_info)) {
                $msg['status'] = 1002;
                $msg['err']    = '40044';
                $msg['msg']    = '任务不存在';
                $this->_ajaxReturn($msg);
            }

            $_send_time = strtotime($task_info['send_time']);
            $after_time = strtotime("+1 hours");
            if ($_send_time < $after_time) {
                $msg['status'] = 1002;
                $msg['err']    = '40045';
                $msg['msg']    = '任务即将在' . date('Y-m-d H:i', strtotime($task_info['send_time'])) . '开始执行，不能修改';
                $this->_ajaxReturn($msg);
            }
            $eight_time       = strtotime(date('Y-m-d 08:00:00', $_send_time));
            $eleven_half_time = strtotime(date('Y-m-d 23:30:00', $_send_time));
            if ($_send_time <= $eight_time or $eight_time >= $eleven_half_time) {
                $msg['status'] = 1002;
                $msg['err']    = '40049';
                $msg['msg']    = '定时发送限制为早上8点至晚上11点半';
                $this->_ajaxReturn($msg);
            }
        }

        $task_name = $post_data['task_name'];
        $send_type = $post_data['send_type'];

        if ($send_type == 3) {
            $msg['status'] = 1002;
            $msg['err']    = '40051';
            $msg['msg']    = '请选择发送内容为“发送优惠券或发送礼包”';
            $this->_ajaxReturn($msg);
        }

        $send_value = $post_data['send_value'];
        if ($send_type != 3) {
            $send_count = !empty($post_data['send_count']) ? $post_data['send_count'] : 1;
        } else {
            $send_count = 0;
        }

        if ($send_type != 3) {
            $receive_repeat = $post_data['receive_repeat'];
        } else {
            $receive_repeat = 0;
        }

        $send_target  = $post_data['send_target'];
        $target_value = '';
        $send_num     = '';
        $this->load->model('membervip/admin/Member_model', 'member_model');
        if ($send_target == 1) {
            $send_member_lvl = $post_data['send_member_lvl'];
            if (in_array('all', $send_member_lvl)) {
                $target_value = 'all_member_lvl';

                //获取目标等级的人数
                $member_lvl_id_arr = $this->common_model->get_field_by_level_config($inter_id, 'member_lvl_id,lvl_name');
                if (empty($member_lvl_id_arr)) {
                    $msg['status'] = 1002;
                    $msg['err']    = '40041';
                    $msg['msg']    = '没有检索到等级配置，请确认等级配置是否存在';
                    $this->_ajaxReturn($msg);
                }

                $member_lvl_ids = array_keys($member_lvl_id_arr);
                $where          = array(
                    'inter_id'      => $inter_id,
                    'member_lvl_id' => $member_lvl_ids,
                );
                $send_num = $this->member_model->get_member_info_list($where, 'member_info_id', true);
            } else {
                $target_value = @json_encode($send_member_lvl);
                $where        = array(
                    'inter_id'      => $inter_id,
                    'member_lvl_id' => $send_member_lvl,
                );
                $send_num = $this->member_model->get_member_info_list($where, 'member_info_id', true);
            }
        } elseif ($send_target == 2) {
            $source    = $post_data['source'];
            $rfm       = $post_data['rfm'];
            $rfm_level = '';
            switch ($rfm) {
                case 'r':
                    $rfm_level = $post_data['r_level'];
                    break;
                case 'f':
                    $rfm_level = $post_data['f_level'];
                    break;
                case 'm':
                    $rfm_level = $post_data['m_level'];
                    break;
            }
            $target_value = @json_encode(array($source, $rfm, $rfm_level));
            $data         = array(
                't'        => time(),
                'inter_id' => $inter_id,
                'source'   => $source,
                $rfm       => $rfm_level,
            );
            $secretKey     = '6lPgIYNsmJhVdyqhtX';
            $signature     = $this->common_model->signature($data, $secretKey);
            $data['token'] = $signature;
            $result        = $this->common_model->get_rfm_data($data);
            MYLOG::w(@json_encode(array($result, $data)), 'admin/membervip/debug-log', 'rfm');
            if (empty($result) or $result == 'No Data Found') {
                $send_num = 0;
            } else {
                $send_num = count($result);
            }

        } elseif ($send_target == 3) {
            $send_target_type  = $post_data['send_target_type'];
            $send_target_field = $post_data['send_target_field'];
            if ($send_target_type == 1) {
                $_target_value = array(
                    'field' => $send_target_field,
                    'type'  => $send_target_type,
                    'value' => trim($post_data['send_target_value']),
                );
                $send_target_value_arr = explode(',', $_target_value['value']);
                foreach ($send_target_value_arr as $key => &$vo) {
                    if (!empty($vo) && !empty(trim($vo))) {
                        $vo = trim($vo);
                    } else {
                        unset($send_target_value_arr[$key]);
                    }
                }
                $_target_value['value'] = @implode(',', $send_target_value_arr);
                $target_value           = @json_encode($_target_value);
                $send_num               = count($send_target_value_arr);
            } elseif ($send_target_type == 2) {
                $_target_value = array(
                    'field' => $send_target_field,
                    'type'  => $send_target_type,
                    'value' => $post_data['send_target_file'],
                );
                $target_value = @json_encode($_target_value);
                $file_path    = $post_data['send_target_file'];
                $send_num     = $this->common_model->get_file_content($file_path, true);
            }
        }

        if (empty($send_num) or $send_num < 1) {
            $msg['status'] = 1002;
            $msg['err']    = '40043';
            $msg['msg']    = '发送目标用户群体人数为0';
            $this->_ajaxReturn($msg);
        }

        if (!empty($post_data['is_send_temp']) && $post_data['is_send_temp'] == 1) {
            $temp_id   = $post_data['temp_id'];
            $jump_url  = '';
            $jump_type = !empty($post_data['jump_type']) ? $post_data['jump_type'] : 0;
            if ($jump_type == 1) {
                $jump_url = $post_data['jump_url'];
            } elseif ($jump_type == 2) {
                $jump_url = $post_data['auto_jump_url'];
            }

            $first     = !empty($post_data['first']) ? $post_data['first'] : '';
            $keyword1  = !empty($post_data['keyword1']) ? $post_data['keyword1'] : '';
            $keyword2  = !empty($post_data['keyword2']) ? $post_data['keyword2'] : '';
            $keyword3  = !empty($post_data['keyword3']) ? $post_data['keyword3'] : '';
            $keyword4  = !empty($post_data['keyword4']) ? $post_data['keyword4'] : '';
            $remark    = !empty($post_data['remark']) ? $post_data['remark'] : '';
            $temp_conf = array(
                'first'     => $first,
                'keyword1'  => $keyword1,
                'keyword2'  => $keyword2,
                'keyword3'  => $keyword3,
                'keyword4'  => $keyword4,
                'remark'    => $remark,
                'jump_type' => $jump_type,
                'url'       => $jump_url,
                'temp_id'   => $temp_id,
            );

            if (!empty($post_data['temp_title_field'])) {
                $temp_conf['temp_title_field'] = $post_data['temp_title_field'];
            }

            if (!empty($post_data['temp_title_value'])) {
                $temp_conf['temp_title_value'] = $post_data['temp_title_value'];
            }

            if (!empty($post_data['temp_hint'])) {
                $temp_conf['temp_hint'] = $post_data['temp_hint'];
            }

            if (!empty($post_data['temp_contet_hint'])) {
                $temp_conf['temp_contet_hint'] = $post_data['temp_contet_hint'];
            }

            if (!empty($post_data['temp_field_hint'])) {
                $temp_conf['temp_field_hint'] = $post_data['temp_field_hint'];
            }

            $redis = $this->common_model->get_vip_redis();
            $key   = 'MemberTaskTempConf' . $inter_id;
            $value = @json_encode($temp_conf);
            $redis->set($key, $value);
        }

        $task_id = !empty($post_data['id']) ? $post_data['id'] : '';

        if ($post_data['send_time_mode'] == 2) {
            $send_time_str = $post_data['send_time'];
        } else {
            $send_time_str = date('Y-m-d H:i:s');
        }

        $save_task_data = array(
            'inter_id'       => $inter_id,
            'operate_id'     => !empty($this->admin_profile['admin_id']) ? $this->admin_profile['admin_id'] : 0,
            'task_name'      => $task_name,
            'send_type'      => $send_type,
            'send_value'     => $send_value,
            'send_count'     => $send_count,
            'receive_repeat' => $receive_repeat,
            'send_target'    => $send_target,
            'target_value'   => $target_value,
            'is_send_temp'   => !empty($post_data['is_send_temp']) ? $post_data['is_send_temp'] : 0,
            'temp_id'        => isset($temp_id) ? $temp_id : '',
            'temp_conf'      => isset($temp_conf) ? @json_encode($temp_conf) : '',
            'send_time_mode' => $post_data['send_time_mode'],
            'send_time'      => $send_time_str,
        );

        $this->common_model->_shard_db(true)->trans_begin(); //开启事务

        $this->load->model('membervip/admin/Vapi_logic', 'vapi_logic');
        $this->vapi_logic->save_temp_conf($temp_conf);

        if (!empty($task_id)) {
            $where = array(
                'inter_id' => $inter_id,
                'task_id'  => $task_id,
            );
            if (empty($task_info)) {
                $msg['status'] = 1002;
                $msg['err']    = '40033';
                $msg['msg']    = '找不到发送任务';
                $this->_ajaxReturn($msg);
            }
            $update_add_result = $this->common_model->update_save($where, $save_task_data, 'send_task');
            if ($update_add_result === 0) {
                $msg['status'] = 1002;
                $msg['err']    = '40038';
                $msg['msg']    = '您没有修改任何内容';
                $this->common_model->_shard_db(true)->trans_rollback();
                $this->_ajaxReturn($msg);
            }
        } else {
            $save_task_data['createtime'] = date('Y-m-d H:i:s');
            $update_add_result            = $this->common_model->add_data($save_task_data, 'send_task');
        }

        if (!$update_add_result) {
            $msg['status'] = 1002;
            $msg['err']    = '40038';
            $msg['msg']    = !empty($task_id) ? '编辑任务失败' : '创建任务失败';
            $this->common_model->_shard_db(true)->trans_rollback();
            if ($update_add_result === 0) {
                $msg['err'] = '40048';
                $msg['msg'] = !empty($task_id) ? '您没有修改任何信息' : '创建任务失败';
            }
            $this->_ajaxReturn($msg);
        }

        $save_task_execute_data = array(
            'inter_id' => $inter_id,
            'send_num' => $send_num,
        );

        $where = array(
            'inter_id' => $inter_id,
            'task_id'  => $task_id,
        );

        $task_execute_info = $this->common_model->get_info($where, 'send_task_execute', 'task_execute_id,task_id,task_status');
        if (!empty($task_execute_info)) {
            if ($task_execute_info['task_status'] == 2) {
                $msg['status'] = 1002;
                $msg['err']    = '40039';
                $msg['msg']    = '该任务发送中，无法修改！';
                $this->common_model->_shard_db(true)->trans_rollback();
                $this->_ajaxReturn($msg);
            } elseif ($task_execute_info['task_status'] == 3) {
                $msg['status'] = 1002;
                $msg['err']    = '40040';
                $msg['msg']    = '该任务已发送，无法修改！';
                $this->common_model->_shard_db(true)->trans_rollback();
                $this->_ajaxReturn($msg);
            }

            $save_task_execute_data['task_id']       = $task_execute_info['task_id'];
            $save_task_execute_data['task_status']   = 1;
            $save_task_execute_data['send_fail_num'] = 0;

            $where['task_execute_id']   = $task_execute_info['task_id'];
            $update_task_execute_result = $this->common_model->update_save($where, $save_task_execute_data, 'send_task_execute');
            if ($update_task_execute_result === false) {
                $msg['status'] = 1002;
                $msg['err']    = '40042';
                $msg['msg']    = !empty($task_id) ? '编辑任务失败' : '创建任务失败';
                $this->common_model->_shard_db(true)->trans_rollback();
                $this->_ajaxReturn($msg);
            }
        } else {
            $save_task_execute_data['task_id']    = !empty($task_info['task_id']) ? $task_info['task_id'] : $update_add_result;
            $save_task_execute_data['createtime'] = date('Y-m-d H:i:s');
            MYLOG::w(@json_encode($save_task_execute_data), 'admin/membervip/debug-log', 'add-send_task_execute');
            $add_task_execute_result = $this->common_model->add_data($save_task_execute_data, 'send_task_execute');
            if (!$add_task_execute_result) {
                $msg['status'] = 1002;
                $msg['err']    = '40042';
                $msg['msg']    = !empty($task_id) ? '编辑任务失败' : '创建任务失败';
                $this->common_model->_shard_db(true)->trans_rollback();
                $this->_ajaxReturn($msg);
            }
        }

        $task_info = !empty($task_info) ? $task_info : array();
        $task_id   = !empty($task_info['task_id']) ? $task_info['task_id'] : $update_add_result;
        $logs      = array(
            'title'     => '优惠批量发放任务配置',
            'filter'    => array('createtime', 'lastupdatetime', 'listorder'),
            'rule_name' => $this->module . '/' . $this->controller . '/' . $this->action,
            'name'      => !empty($task_info['task_name']) ? $task_info['task_name'] : '',
            'admin_id'  => !empty($this->admin_profile['admin_id']) ? $this->admin_profile['admin_id'] : 0,
            'inter_id'  => $inter_id,
        );

        $this->common_logm->save_log_init($task_info, $save_task_data, $task_id, $update_add_result, 'membertask', $this->common_model, $logs); //添加操作记录

        $this->common_model->_shard_db(true)->trans_commit();

        if ($post_data['send_time_mode'] == 1 && $send_num <= 500) {
            $_url = 'http://test1.lostsk.com/membervip/TimingTask/welfaretask';
            $con  = curl_init((string) $_url);
            curl_setopt($con, CURLOPT_HEADER, false);
            curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($con, CURLOPT_TIMEOUT_MS, 500);
            curl_setopt($con, CURLOPT_SSL_VERIFYPEER, false);
            $res = curl_exec($con);
            MYLOG::w(@json_encode(array($res, $_url)), 'admin/membervip/debug-log', 'add-send_task');
        }

        $msg['status'] = 1000;
        $msg['err']    = '0';
        $msg['msg']    = 'OK';
        $this->_ajaxReturn($msg);
    }

    /**
     * 检测发送任务配置
     * @return array
     */
    protected function first_check_task()
    {
        $msg = array(
            'status' => 1004,
            'err'    => '99999',
            'msg'    => '请求失败',
        );
        $post_data = $this->args;

        if (empty($this->admin_profile['inter_id'])) {
            $msg['status'] = 1004;
            $msg['err']    = '49999';
            $msg['msg']    = 'inter_id is null';
            return $msg;
        }

        $inter_id = $this->admin_profile['inter_id'];

        if (empty($post_data['task_name'])) {
            $msg['status'] = '1001';
            $msg['err']    = '40001';
            $msg['msg']    = '请填写任务名称';
            return $msg;
        }

        if (empty($post_data['send_time_mode'])) {
            $msg['status'] = '1001';
            $msg['err']    = '40034';
            $msg['msg']    = '请选择任务发送模式';
            return $msg;
        }

        if ($post_data['send_time_mode'] == 2) {
            if (empty($post_data['send_time'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40035';
                $msg['msg']    = '请选择任务发送时间';
                return $msg;
            }

            $_check_send_time = explode(' ', $post_data['send_time']);
            if (empty($_check_send_time[0])) {
                $msg['status'] = '1001';
                $msg['err']    = '40036';
                $msg['msg']    = '任务发送时间不合格';
                return $msg;
            }
            $check_send_time = explode('-', $_check_send_time[0]);
            $time0           = isset($check_send_time[1]) ? intval($check_send_time[0]) : '';
            $time1           = isset($check_send_time[1]) ? intval($check_send_time[1]) : '';
            $time2           = isset($check_send_time[1]) ? intval($check_send_time[2]) : '';
            $checkdate       = checkdate($time1, $time2, $time0) ? true : false;
            if (!$checkdate) {
                $msg['status'] = '1001';
                $msg['err']    = '40036';
                $msg['msg']    = '任务发送时间不合格';
                return $msg;
            }

            $str_send_time   = strtotime($post_data['send_time']);
            $our_hours_after = strtotime("+1 hours");
            if ($str_send_time < $our_hours_after) {
                $msg['status'] = '1001';
                $msg['err']    = '40037';
                $msg['msg']    = '定时发送任务的发送时间必须在一小时后';
                return $msg;
            }
        }

        //-------- 验证选择发送内容 start --------//
        if (empty($post_data['send_type'])) {
            $msg['status'] = '1001';
            $msg['err']    = '40002';
            $msg['msg']    = '请选择发送内容';
            return $msg;
        }

        if ($post_data['send_type'] == 1) {
            if (empty($post_data['send_value'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40003';
                $msg['msg']    = '请选择优惠券';
                $this->_ajaxReturn($msg);
            }
            $this->load->model('membervip/admin/Card_model', 'card_model');
            $card_id   = $post_data['send_value'];
            $card_info = $this->card_model->get_can_received($inter_id, $card_id, 'card_id,title,time_start,time_end,use_time_end_model,use_time_end');
            MYLOG::w(@json_encode($card_info), 'membervip/debug-log', 'card_info');
            if (empty($card_info)) {
                $msg['status'] = '1001';
                $msg['err']    = '40017';
                $msg['msg']    = '找不到所选的优惠券, 请检查优惠券是否未激活';
                return $msg;
            }

            $todaystart = strtotime(date('Y-m-d'));
            $todayend   = strtotime(date('Y-m-d 23:59:59'));

            if ($card_info['time_start'] > $todayend) {
                $msg['status'] = '1001';
                $msg['err']    = '40018';
                $msg['msg']    = "优惠券\"{$card_info['title']}\"领取时间未到";
                return $msg;
            }

            if ($card_info['time_end'] < $todaystart) {
                $msg['status'] = '1001';
                $msg['err']    = '40019';
                $msg['msg']    = "优惠券\"{$card_info['title']}\"已过领取时间";
                return $msg;
            }

            if ($card_info['use_time_end_model'] == 'g') {
                $use_time_end = strtotime(date('Y-m-d 23:59:59', $card_info['use_time_end']));
                if ($use_time_end < time()) {
                    $msg['status'] = '1001';
                    $msg['err']    = '40020';
                    $msg['msg']    = "优惠券\"{$card_info['title']}\"使用期限已过";
                    return $msg;
                }
            }
        } elseif ($post_data['send_type'] == 2) {
            if (empty($post_data['send_value'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40004';
                $msg['msg']    = '请选择礼包';
                return $msg;
            }

            $package_id = $post_data['send_value'];
            $this->load->model('membervip/admin/Package_model', 'package_model');
            $other = array(
                'status'    => 1,
                'is_active' => 't',
            );
            $package_info = $this->package_model->get_package_element($inter_id, $package_id, 'p.package_id,pe.package_element_id,pe.ele_type,pe.ele_value,pe.ele_num,pe.status', $other);

            if (empty($package_info)) {
                $msg['status'] = '1001';
                $msg['err']    = '40021';
                $msg['msg']    = '找不到所选的礼包';
                return $msg;
            }

            if (!empty($package_info['card'])) {
                $card_ids = array();
                foreach ($package_info['card'] as $k => &$vo) {
                    $card_ids[] = $vo['card_id'];
                }

                if (!empty($card_ids)) {
                    $this->load->model('membervip/admin/Card_model', 'card_model');
                    $card_info = $this->card_model->get_can_received($inter_id, $card_ids, 'card_id,title,time_start,time_end,use_time_end_model,use_time_end', false);
                    MYLOG::w(@json_encode(array('id' => $card_ids, 'info' => $card_info)), 'membervip/debug', 'membertask');
                    if (!empty($card_info)) {
                        foreach ($package_info['card'] as $k => &$vo) {
                            $card_data = !empty($card_info[$vo['card_id']]) ? $card_info[$vo['card_id']] : array();
                            if (!empty($card_data)) {
                                $todaystart = strtotime(date('Y-m-d'));
                                $todayend   = strtotime(date('Y-m-d 23:59:59'));

                                if ($card_data['time_start'] > $todayend) {
                                    $msg['status'] = '1001';
                                    $msg['err']    = '40024';
                                    $msg['msg']    = "优惠券\"{$card_data['title']}\"领取时间未到";
                                    return $msg;
                                }

                                if ($card_data['time_end'] < $todaystart) {
                                    $msg['status'] = '1001';
                                    $msg['err']    = '40025';
                                    $msg['msg']    = "优惠券\"{$card_data['title']}\"已过领取时间";
                                    return $msg;
                                }

                                if ($card_data['use_time_end_model'] == 'g') {
                                    $use_time_end = strtotime(date('Y-m-d 23:59:59', $card_data['use_time_end']));
                                    if ($use_time_end < time()) {
                                        $msg['status'] = '1001';
                                        $msg['err']    = '40026';
                                        $msg['msg']    = "优惠券\"{$card_data['title']}\"使用期限已过";
                                        return $msg;
                                    }
                                }
                            } else {
                                $msg['status'] = '1001';
                                $msg['err']    = '40023';
                                $msg['msg']    = '找不到礼包配置的优惠券';
                                return $msg;
                            }
                        }
                    } else {
                        $msg['status'] = '1001';
                        $msg['err']    = '40022';
                        $msg['msg']    = '找不到礼包配置的优惠券';
                        return $msg;
                    }
                }
            }
        } else if ($post_data['send_type'] == 3 && (empty($post_data['is_send_temp']) or $post_data['is_send_temp'] != 1)) {
            //todo
            $msg['status'] = '1001';
            $msg['err']    = '40051';
            $msg['msg']    = '请选择发送模板消息';
            return $msg;
        } else {
            $msg['status'] = '1001';
            $msg['err']    = '40027';
            $msg['msg']    = '发送内容不符合规范，只能优惠券或者礼包';
            return $msg;
        }

        if ($post_data['send_type'] == 1 && (empty($post_data['send_count']) or intval($post_data['send_count']) < 1)) {
            $msg['status'] = '1001';
            $msg['err']    = '40005';
            $msg['msg']    = '优惠券发送数量至少1张';
            return $msg;
        }

        //-------- 验证选择发送内容 end --------//

        //-------- 验证发送目标用户 start --------//
        if (empty($post_data['send_target'])) {
            $msg['status'] = '1001';
            $msg['err']    = '40006';
            $msg['msg']    = '请选择发送目标用户';
            return $msg;
        }

        if ($post_data['send_target'] == 1) {
            //会员等级
            if (empty($post_data['send_member_lvl'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40007';
                $msg['msg']    = '请选择目标用户的会员等级';
                return $msg;
            }
        } elseif ($post_data['send_target'] == 2) {
            //RFM模型
            if (empty($post_data['source'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40008';
                $msg['msg']    = '请选择目标用户来源';
                return $msg;
            }

            if (empty($post_data['rfm'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40009';
                $msg['msg']    = '请选择RFM模型';
                return $msg;
            }

            $rfm_map = array('r', 'f', 'm');
            if (!in_array($post_data['rfm'], $rfm_map)) {
                $msg['status'] = '1001';
                $msg['err']    = '40029';
                $msg['msg']    = 'RFM模型参数不符合规范';
                return $msg;
            }

            switch ($post_data['rfm']) {
                case 'r':
                    $rfm_level = $post_data['r_level'];
                    break;
                case 'f':
                    $rfm_level = $post_data['f_level'];
                    break;
                case 'm':
                    $rfm_level = $post_data['m_level'];
                    break;
            }

            if (empty($rfm_level)) {
                $msg['status'] = '1001';
                $msg['err']    = '40010';
                $msg['msg']    = 'RFM模型参数缺失';
                return $msg;
            }

        } elseif ($post_data['send_target'] == 3) {
            //自定义发送名单
            if (empty($post_data['send_target_field'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40011';
                $msg['msg']    = '请选择您所提供的发送名单类型';
                return $msg;
            }

            $send_target_field_map = array(1, 2, 3, 4);
            if (!in_array($post_data['send_target_field'], $send_target_field_map)) {
                $msg['status'] = '1001';
                $msg['err']    = '40030';
                $msg['msg']    = '发送名单类型不符合规范';
                return $msg;
            }

            if (empty($post_data['send_target_type'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40012';
                $msg['msg']    = '请选择提供数据的方式';
                return $msg;
            }

            $send_target_type_map = array(1, 2);
            if (!in_array($post_data['send_target_type'], $send_target_type_map)) {
                $msg['status'] = '1001';
                $msg['err']    = '40031';
                $msg['msg']    = '提供数据的方式不符合规范';
                return $msg;
            }

            if ($post_data['send_target_type'] == 1 && empty($post_data['send_target_value'])) {
                $field_name = '';
                switch ($post_data['send_target_field']) {
                    case 1:
                        $field_name = '手机号码';
                        break;
                    case 2:
                        $field_name = '会员ID';
                        break;
                    case 3:
                        $field_name = '会员卡号';
                        break;
                    case 4:
                        $field_name = 'OPEN ID';
                        break;
                }
                $msg['status'] = '1001';
                $msg['err']    = '40013';
                $msg['msg']    = '请录入用户的' . $field_name;
                return $msg;
            } elseif ($post_data['send_target_type'] == 2 && empty($post_data['send_target_file'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40014';
                $msg['msg']    = '请导入发送名单';
                return $msg;
            }
        } else {
            $msg['status'] = '1001';
            $msg['err']    = '40028';
            $msg['msg']    = '发送目标不符合规范';
            return $msg;
        }
        //-------- 验证发送目标用户 start --------//
        $msg['status'] = 1000;
        $msg['err']    = '0';
        $msg['msg']    = 'OK';
        return $msg;
    }

    /**
     * 检测发送任务的模版消息配置
     * @return array
     */
    public function next_check_task()
    {
        $msg = array(
            'status' => 1004,
            'err'    => '99999',
            'msg'    => '请求失败',
        );
        $post_data = $this->args;
        if (!empty($post_data['is_send_temp']) && $post_data['is_send_temp'] == 1) {
            if (empty($post_data['temp_id'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40015';
                $msg['msg']    = '请填写模板ID';
                return $msg;
            }

            $jump_type     = !empty($post_data['jump_type']) ? $post_data['jump_type'] : 0;
            $jump_type_map = array(1, 2, 3);
            if (!in_array($jump_type, $jump_type_map)) {
                $msg['status'] = '1001';
                $msg['err']    = '40032';
                $msg['msg']    = '跳转链接方式不符合规范';
                return $msg;
            }

            if ($jump_type == 1 && empty($post_data['jump_url'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40016';
                $msg['msg']    = '请选择跳转链接';
                return $msg;
            }

            if ($jump_type == 2 && empty($post_data['auto_jump_url'])) {
                $msg['status'] = '1001';
                $msg['err']    = '40016';
                $msg['msg']    = '请填写跳转链接';
                return $msg;
            }
        } else if ($post_data['send_type'] == 3) {
            $msg['status'] = '1001';
            $msg['err']    = '40051';
            $msg['msg']    = '请选择发送模板消息';
            return $msg;
        }

        $msg['status'] = 1000;
        $msg['err']    = '0';
        $msg['msg']    = 'OK';
        return $msg;
    }

    public function delete()
    {
        $msg = array(
            'status' => 1004,
            'err'    => '99999',
            'msg'    => '请求失败',
        );

        if (empty($this->admin_profile['inter_id'])) {
            $msg['status'] = 1004;
            $msg['err']    = '49999';
            $msg['msg']    = 'inter_id is null';
            $this->_ajaxReturn($msg);
        }

        if (empty($this->args['id'])) {
            $msg['status'] = 1004;
            $msg['err']    = '40046';
            $msg['msg']    = '任务ID不存在';
            $this->_ajaxReturn($msg);
        } else {
            $where = array(
                'inter_id' => $this->admin_profile['inter_id'],
                'task_id'  => $this->args['id'],
                'is_del'   => 2,
            );
            $data = array(
                'is_del' => 1,
            );
            $update_result = $this->common_model->update_save($where, $data, 'send_task');
            if (!$update_result) {
                $msg['status'] = 1004;
                $msg['err']    = '40047';
                $msg['msg']    = '任务删除失败';
                $this->_ajaxReturn($msg);
            }
            $msg['status'] = 1000;
            $msg['err']    = '0';
            $msg['msg']    = 'OK';
            $this->_ajaxReturn($msg);
        }
    }

    /**
     * Ajax方式返回数据到客户端
     * @param array $data 要返回的数据
     * @param string $type AJAX返回数据格式
     * @param int $json_option JSON 常量
     */
    protected function _ajaxReturn($data = array(), $type = '', $json_option = 0)
    {

        $data['referer'] = !empty($data['url']) ? $data['url'] : "";
        $data['state']   = (!empty($data['status']) && $data['status'] == '1000') ? "success" : "fail";
        if (empty($type)) {
            $type = 'JSON';
        }

        switch (strtoupper($type)) {
            case 'JSON':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data, $json_option));
            case 'XML':
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit($this->common_model->xml_encode($data));
            case 'EVAL':
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);
            case 'AJAX_UPLOAD':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:text/html; charset=utf-8');
                exit(json_encode($data, $json_option));
            default:
                // 中断程序
                exit(0);
        }
    }
}
