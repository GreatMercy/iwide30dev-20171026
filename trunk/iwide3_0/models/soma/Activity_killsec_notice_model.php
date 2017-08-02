<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'models' . DS . 'soma' . DS . 'Activity_model.php');

class Activity_killsec_notice_model extends Activity_model
{


    public function table_name($inter_id = null)
    {
        return $this->_shard_table('soma_activity_killsec_notice', $inter_id);
    }

    public function table_name_r($inter_id = null)
    {
        return $this->_shard_table_r('soma_activity_killsec_notice', $inter_id);
    }

    public function table_primary_key()
    {
        return 'notice_id';
    }

    public function attribute_labels()
    {
        return array();
    }

    /**
     * 新增一条秒杀设置提醒
     * @param $inter_id
     * @param $data
     * @return bool|object
     * @author daikanwu <daikanwu@jperation.com>
     */
    public function add_notice($inter_id, Array $data)
    {
        if (isset($data['openid']) && isset($data['act_id'])) {
            $table = $this->table_name($inter_id);
            $where = array('openid' => $data['openid'], 'act_id' => $data['act_id']);
            $result = $this->_shard_db_r('iwide_soma_r')->get_where($table, $where)->result_array();
            if (!empty($result)) {
                return false;
            }
            $data['status'] = Soma_base::STATUS_TRUE;
            $data['create_time'] = date('Y-m-d H:i:s');
            $result = $this->_shard_db($inter_id)->insert($table, $data);

            return $result;
        }

        return false;
    }


}
