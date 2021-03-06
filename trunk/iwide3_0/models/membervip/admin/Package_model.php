<?php

/**
 * 会员4.0后台礼包数据处理模块
 * Created by knight.
 * User: ibuki
 * Date: 16/7/30
 * Time: 下午9:25
 */
class Package_model extends MY_Model_Member {


    /**
     * 获取已激活的礼包，包含内容的检测
     * @param string $inter_id 酒店集团ID
     * @param string $package_id 礼包ID，可以传数组 array(1,2,xxx,...)
     * @param string $field 检索字段
     * @param array $extra 扩展参数
     * @return array
     */
    public function get_packages_elements_list($inter_id = '', $package_id = '', $field = '*', $extra = array()){
        if(empty($inter_id)) return array();
        $where = array('p.inter_id'=>$inter_id);
        $where['p.is_active'] = 't';
        $where['pl.status'] = 1;

        $this->_shard_db()->select("{$field},p.status as package_status")->where($where)->from('package p');
        if(!empty($package_id)){
            if(is_array($package_id)){
                $this->_shard_db()->where_in('p.package_id',$package_id);
            }else{
                $this->_shard_db()->where('p.package_id',$package_id);
            }
        }
        if(!empty($extra)){
            $list_fields = $this->_shard_db(true)->list_fields('package');
            foreach ($list_fields as $_field){
                if(isset($extra[$_field])) {
                    if(is_array($extra[$_field])){
                        $this->_shard_db()->where_in('p.'.$_field,$extra[$_field]);
                    }else{
                        $this->_shard_db()->where('p.'.$_field,$extra[$_field]);
                    }
                }
            }
        }

        $result = $this->_shard_db()->order_by('p.createtime desc, p.package_id desc')
                                    ->join('package_element pl','p.package_id = pl.package_id','left')
                                    ->get()->result_array();
        $_result = array();
        if(!empty($result)){
            //优惠券配置信息
            $this->load->model('membervip/admin/Card_model','card_model');
            $card_info = $this->card_model->get_can_received($inter_id);
            $package_list = array();
            foreach ($result as $k => $vo){
                $package_list[$vo['package_id']][] = $vo;
            }

            foreach ($package_list as $k => $package_element){
                $arr = array();
                foreach ($package_element as $kk => &$vo){
                    $package_element_id = !empty($vo['package_element_id'])?$vo['package_element_id']:0;
                    $_result[$vo['package_id']] = $vo;
                    $vo['ele_value'] = isset($vo['ele_value'])?$vo['ele_value']:'';
                    $vo['ele_num'] = isset($vo['ele_num'])?$vo['ele_num']:'';
                    $vo['status'] = isset($vo['status'])?$vo['status']:'';
                    switch ($vo['ele_type']){
                        case 'credit':
                            $arr['credit'] = $vo['ele_value'];
                            break;
                        case 'deposit':
                            $arr['balance'] = $vo['ele_value'];
                            break;
                        case 'membership':
                            $arr['lvl_name'] = isset($other['lvl_name'][$vo['ele_value']])?$other['lvl_name'][$vo['ele_value']]:$vo['ele_value'];
                            if($arr['lvl_name'] == 'null') $arr['lvl_name'] = '';
                            break;
                        case 'card':
                            $card_id = $vo['ele_value'];
                            $arr['card'][$card_id] = array(
                                'card_id' => $card_id,
                                'state' => 0,
                                'count' => $vo['ele_num'],
                                'status' => $vo['status'],
                                'element_id' => $package_element_id
                            );
                            if(!empty($card_info[$card_id])){
                                $card_data = $card_info[$card_id];
                                $arr['card'][$card_id]['state'] = 1;
                                $arr['card'][$card_id]['title'] = $card_data['title'];

                                $todaystart = strtotime(date('Y-m-d'));
                                $todayend = strtotime(date('Y-m-d 23:59:59'));

                                if($card_data['time_start'] > $todayend){
                                    $arr['card'][$card_id]['state'] = 0;
                                    $arr['card'][$card_id]['err_msg'] = "礼包内的\"{$card_data['title']}\"领取时间未到";
                                }elseif ($card_data['time_end'] < $todaystart){
                                    $arr['card'][$card_id]['state'] = 0;
                                    $arr['card'][$card_id]['err_msg'] = "礼包内的\"{$card_data['title']}\"已过领取时间";
                                }elseif ($card_data['use_time_end_model']=='g') {
                                    $use_time_end = strtotime(date('Y-m-d 23:59:59',$card_data['use_time_end']));
                                    if($use_time_end < time()){
                                        $arr['card'][$card_id]['state'] = 0;
                                        $arr['card'][$card_id]['err_msg'] = "礼包内的\"{$card_data['title']}\"使用期限已过";
                                    }
                                }elseif ($card_data['card_stock'] <= 0){
                                    $arr['card'][$card_id]['state'] = 0;
                                    $arr['card'][$card_id]['err_msg'] = "礼包内的\"{$card_data['title']}\"库存为 0 ";
                                }
                            }
                            break;
                    }
                    unset($_result[$vo['package_id']]['ele_type']);
                    unset($_result[$vo['package_id']]['ele_value']);
                    unset($_result[$vo['package_id']]['ele_num']);
                    unset($_result[$vo['package_id']]['status']);
                    $_result[$vo['package_id']] = array_merge_recursive($_result[$vo['package_id']],$arr);
                }
            }
        }

        foreach ($_result as $key => &$item){
            if(!empty($item['card'])){
                foreach ($item['card'] as $kc => $cv){
                    if(!empty($cv['err_msg'])){
                        $item['state'] = $cv['state'];
                        $item['err_msg'] = $cv['err_msg'];
                    }
                }
            }
        }

        if(!empty($package_id) && !empty($_result) && is_numeric($package_id)){
            $_result = reset($_result);
        }

        return $_result;
    }

    /**
     * 查询礼包列表
     * @param int $inter_id 酒店集团ID
     * @param string $field 获取字段
     * @param array $extra 扩展参数
     * @return array
     */
    public function get_package_list($inter_id=0,$field='*',$extra = array()){
        if(empty($inter_id)) return array();
        $where = array('inter_id'=>$inter_id);
        $list_fields = $this->_shard_db(true)->list_fields('package');
        foreach ($list_fields as $_field){
            if(isset($extra[$_field])) $where[$_field] = $extra[$_field];
        }
        $result = $this->_shard_db()->select($field)->where($where)->get('package')->result_array();
        return $result;
    }

    public function get_field_by_field($inter_id=0,$extra = array()){
        if(empty($inter_id)) return array();
        $where = array('inter_id'=>$inter_id);
        $list_fields = $this->_shard_db(true)->list_fields('package');
        foreach ($list_fields as $_field){
            if(isset($extra[$_field])) $where[$_field] = $extra[$_field];
        }
        $package_list = array();
        $result = $this->_shard_db()->select('package_id,name')->where($where)->get('package')->result_array();
        if(!empty($result)){
            foreach ($result as $item){
                $package_list[$item['package_id']] = $item['name'];
            }
        }
        return $package_list;
    }

    /**
     * 获取单个礼包的所有信息
     * @param int $inter_id
     * @param int $id 礼包ID
     * @param string $field
     * @param array $other
     * @return mixed
     */
    public function get_package_element($inter_id=0,$id=0,$field='*',$other=array()){
        $where = array('p.package_id'=>$id,'p.inter_id'=>$inter_id);
        if(isset($other['is_active'])) $where['p.is_active'] = $other['is_active'];
        if(isset($other['status'])) $where['pe.status'] = $other['status'];
        $result = $this->_shard_db()->select($field)->from('package as p')
                        ->join('package_element as pe','pe.package_id=p.package_id','left')
                        ->where($where)->get()->result_array();
        if($this->input->get('debug')=='1'){
            echo 'get_package_element - sql:';
            echo $this->_shard_db()->last_query();
        }

        $_result = array();
        $arr = array();
        $package_element = array();
        foreach ($result as $k=>$vo){
            if(isset($vo['package_id'])){
                $package_element_id = !empty($vo['package_element_id'])?$vo['package_element_id']:0;
                $element = '';
                $_result[$vo['package_id']] = $vo;
                $vo['ele_value'] = isset($vo['ele_value'])?$vo['ele_value']:'';
                $vo['ele_num'] = isset($vo['ele_num'])?$vo['ele_num']:'';
                $vo['status'] = isset($vo['status'])?$vo['status']:'';
                switch ($vo['ele_type']){
                    case 'credit':
                        $arr['credit'] = $vo['ele_value'];
                        $element = 'credit';
                        break;
                    case 'deposit':
                        $arr['balance'] = $vo['ele_value'];
                        $element = 'deposit';
                        break;
                    case 'membership':
                        $arr['lvl_name'] = isset($other['lvl_name'][$vo['ele_value']])?$other['lvl_name'][$vo['ele_value']]:$vo['ele_value'];
                        if($arr['lvl_name'] == 'null') $arr['lvl_name'] = '';
                        $element = 'membership';
                        break;
                    case 'card':
                        $arr['card'][$vo['ele_value']] = array(
                            'card_id'=>$vo['ele_value'],
                            'count'=>$vo['ele_num'],
                            'status'=>$vo['status'],
                            'element_id'=>$package_element_id
                        );
                        break;
                }
                $_result[$vo['package_id']] = array_merge($_result[$vo['package_id']],$arr);
                if(!empty($element)) $package_element[$package_element_id] = $element;
            }
        }

        if(!empty($_result[$id])){
            $_result[$id]['package_element'] = array_unique($package_element);
            $mapkey = array('credit','balance','lvl_name');
            foreach ($mapkey as $fd){
                $_result[$id][$fd] = isset($_result[$id][$fd])?$_result[$id][$fd]:'';
            }
        }
        $res = isset($_result[$id])?$_result[$id]:$result;
        return $res;
    }

    /**
     * 重组数据，解析积分、储值、等级信息
     * @param array $data
     * @param array $other
     * @return array
     */
    public function parse_package($data=array(),$lvl_info=array()){
        if(empty($data)) return array();
        $result = array();
        $arr = array();
        foreach ($data as $k=>$val){
            $result[$val['package_id']] = $val;
            switch ($val['ele_type']){
                case 'credit':
                    $arr['credit'] = $val['ele_value'];
                    break;
                case 'deposit':
                    $arr['balance'] = $val['ele_value'];
                    break;
                case 'membership':
                    $arr['lvl_name'] = isset($lvl_info[$val['ele_value']])?$lvl_info[$val['ele_value']]:' -- ';
                    break;
            }
            $result[$val['package_id']] = array_merge($result[$val['package_id']],$arr);
        }
        return $result;
    }

    /**
     * 重组数组，改变键值
     * @param array $data 数据集
     * @param string $key 指定键值
     * @param string $vkey 指定$key所对应的值
     * @return array
     */
    protected function field_by_value($data=array(),$key='',$vkey=''){
        if(empty($data)) return array();
        $list = array();
        foreach ($data as $k => $vo){
            $list[$vo[$key]] = $vo[$vkey];
        }
        return $list;
    }

    /**
     * 根据某字段的值自定义排序
     * @param array $data 数组
     * @param string $field 字段
     * @param string $value 字段的值
     * @return array
     */
    protected function custom_sort($data=array(),$field='',$value=''){
        if(empty($data)) return array();
        $first = array();
        foreach ($data as $key => $item){
            if(isset($item[$field]) && $item[$field]==$value){
                $first = $item;
                unset($data[$key]);
            }
        }
        array_unshift($data,$first); //插入到最開始的位置
        return $data;
    }

    /**
     * 运行日志记录
     * @param String $content
     */
    protected function _write_log( $content,$type ) {
        $file= date('Y-m-d_H'). '.txt';
        $path= APPPATH. 'logs'. DS. 'membervip'. DS. 'customize'. DS;
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