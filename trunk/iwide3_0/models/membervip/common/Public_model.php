<?php

/**
 * 会员4.0后台数据处理模块
 * Created by knight.
 * User: ibuki
 * Date: 16/7/30
 * Time: 下午9:25
 */
class Public_model extends MY_Model_Member {

    const SPACE = ' '; //空格符
    protected $_pk = '';

    /**
     * 获取微信消息模板
     * @param null $inter_id 微信酒店集团ID
     * @param int $type 模板消息类型
     * @return array
     */
    public function template_count_by_type($inter_id = '',$type = 1){
        if(!isset($inter_id) || empty($inter_id)) return array();
        $member_template_table = 'member_message_template';
        $count = $this->_shard_db()
            ->where(array('inter_id'=>$inter_id,'type'=>$type))
            ->get($member_template_table)->num_rows();
        $this->_shard_db()->get($member_template_table)->free_result();
        return $count;
    }

    /**
     * 获取数据表的字段列表
     * @param $table 表名
     * @return array
     */
    protected function get_list_fields($table){
        $result = $this->_shard_db()->query("SHOW FULL COLUMNS FROM iwide_$table")->result_array();
        $fields = array();
        foreach ($result as $k=>$vo){
            if($vo['Key']=='PRI') $this->_pk = $vo['Field'];
            $fields[] = $vo['Field'];
        }
        return $fields;
    }

    /**
     * 模糊查询字段
     * @param string $alias
     * @param int $type
     * @return array
     */
    protected function get_like_field($alias='',$type=1){
        $like_field = array();
        switch ($type){
            case 1:
                $like_field = array($alias.'.member_info_id',$alias.'.nickname',$alias.'.name', $alias.'.membership_number', $alias.'.member_lvl_id',$alias.'.telephone');
                break;
            case 2:
                $like_field = array($alias.'.package_id',$alias.'.name',$alias.'.remark');
                break;
            case 3:
                $like_field = array($alias.'.card_id',$alias.'.title',$alias.'.description',$alias.'.card_stock');
                break;
            case 4:
                $like_field = array($alias.'.member_info_id','m.membership_number','m.nickname','m.name','c.title',$alias.'.remark');
                break;
        }
        return $like_field;
    }

    /**
     * 获取会员等级配置列表（默认等级排在第一）
     * @param int $inter_id
     * @param string $field
     * @return array
     */
    public function get_admin_member_lvl($inter_id=0,$field='*'){
        if(empty($inter_id)) return array();
        if(is_array($field) && count($field) > 0){
            $field = implode(',',$field);
        }
        $where = array('inter_id'=>$inter_id);
        $member_lvl = $this->_shard_db()->select($field)->where($where)->get('member_lvl')->result_array();
        $member_lvl = $this->custom_sort($member_lvl,'is_default','t');
        return $member_lvl;
    }

    /**
     * 获取会员等级配置 （格式：array([key]=>[value])）
     * @param int $inter_id
     * @param string $field
     * @return array
     */
    public function get_field_by_level_config($inter_id=0,$field='*'){
        if(empty($inter_id)) return array();
        $where = array('inter_id'=>$inter_id);
        $member_lvl = $this->_shard_db()->select($field)->where($where)->get('member_lvl')->result_array();
        $member_lvl = $this->field_by_value($member_lvl,'member_lvl_id','lvl_name');
        return $member_lvl;
    }

    /**
     * 重组数组，改变键值
     * @param array $data 数据集
     * @param string $key 指定键值
     * @param string $vkey 指定$key所对应的值
     * @return array
     */
    public function field_by_value($data=array(),$key='',$vkey=''){
        if(empty($data)) return array();
        $list = array();
        $this->load->helper('common_helper');
        uasort($data,"my_sort"); //对分组排序，由小到大根据键值排序
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

        if(!empty($first)) array_unshift($data,$first); //插入到最開始的位置
        return $data;
    }

    /**
     * 获取会员模式
     * @param int $inter_id 酒店集团ID
     * @return array
     */
    public function get_member_mode($inter_id=0){
        if(empty($inter_id)) return array();
        $where = array('inter_id'=>$inter_id,'type_code'=>'member');
        $member_mode = $this->_shard_db()->where_in()->select('value')->where($where)->get('inter_member_config')->row_array();
        if(isset($member_mode['value'])) return $member_mode['value'];
        return array();
    }

    /**
     * 验证字段信息
     * @param array $data
     * @param string $table
     * @return array
     */
    public function check_list_fields($data=array(),$table=''){
        if(empty($data) || empty($table)) return array();
        $list_fields = $this->_shard_db()->list_fields($table);
        foreach ($data as $key => $item){
            if(!in_array($key, $list_fields)) unset($data[$key]);
        }
        return $data;
    }

    /**
     * 添加显示配置
     * @param $data 添加数据
     * @return bool
     */
    public function add_data($data=array(),$table=''){
        if(empty($table)) return false;
        if(empty($data) || is_string($data)) return false;
        $result = $this->_shard_db(true)->set($data)->insert($table);
        $this->_write_log($this->_shard_db(true)->last_query(),'insert-SQL','Public_model/sql');
        if($this->input->get('debug') == 1){
            $this->_write_log($this->_shard_db(true)->last_query(),'insert-SQL','Public_model/sql');
        }
        if($result){
            return $this->_shard_db(true)->insert_id();
        }
        return $result;
    }

    /**
     * 更新数据
     * @param $params 条件
     * @param $data 更新数据
     * @return bool
     */
    public function update_save($params=array(),$data=array(),$table=''){
        if(empty($table) || empty($params)) return false;
        if(empty($data) || is_string($data)) return false;
        $where = array();
        $list_fields = $this->_shard_db(true)->list_fields($table);
        foreach ($list_fields as $field){
            if(isset($params[$field])) $where[$field] = $params[$field];
        }

        $result = $this->_shard_db(true)->where($where)->set($data)->update($table);
        if($this->input->get('debug') == 1){
            $this->_write_log($this->_shard_db(true)->last_query(),'update-SQL','Public_model/sql');
        }
        if($result===true) $this->_shard_db(true)->affected_rows();
        return $result;
    }

    /**
     * 删除数据
     * @param array $params 条件
     * @param string $table 表名
     * @return bool
     */
    public function delete_data($params = array(),$table = ''){
        if(empty($params)) return false;
        if(empty($table)) return false;
        $result = $this->_shard_db(true)->where($params)->delete($table);
        return $result;
    }

    /**
     * 更新数据(改变数量)
     * @param $params 条件
     * @param $data 更新数据
     * @return bool
     */
    public function update_deduct($where=array(),$field='',$value='',$table=''){
        if(empty($where) || empty($field) || empty($table)) return false;
        $result = $this->_shard_db(true)->set($field,$value, FALSE)->where($where)->update($table);
        $this->load->library("MYLOG");
        MYLOG::w($this->_shard_db(true)->last_query(),'front/membervip/invitate', 'last_query');
        if($result===true) $this->_shard_db(true)->affected_rows();
        return $result;
    }

    /**
     * 数据集 总数
     */
    public function get_total($params=array(),$table='',$condition=array()){
        $inter_id = $params['inter_id'];
        $where=array($table.'.inter_id'=>$inter_id);
        if(!empty($condition)) $where = array_merge($where,$condition);
        $this->_shard_db()->where($where);
        $count = $this->_shard_db()->get($table)->num_rows();
        return $count;
    }

    /**
     * 获取数据(单条)
     * @param $params 条件
     * @param $table 指定数据表
     * @return array
     */
    public function get_info($where=array(),$table='',$field='*'){
        if(empty($table) || empty($where)) return false;
        $info = $this->_shard_db()->select($field)
            ->where($where)->get($table)->row_array();
        if($this->input->get('debug') == 1){
            $this->_write_log($this->_shard_db()->last_query(),'row_array-SQL','Kiminvited/sql');
            echo $this->_shard_db()->last_query();echo '<br />';
        }
        if(!is_null($info)) return $info;
        return array();
    }

    /**
     * 获取数据(列表)
     * @param $params 条件
     * @param $table 指定数据表
     * @return array
     */
    public function get_list($where=array(),$table='',$field='*',$limit=100){
        if(empty($table) || empty($where)) return false;
        $list = $this->_shard_db()->select($field)->where($where)
            ->limit($limit)->get($table)
            ->result_array();
        if($this->input->get('debug') == 1){
            $this->_write_log($this->_shard_db()->last_query(),'row_array-SQL','invited/sql');
            echo $this->_shard_db()->last_query();echo '<br />';
        }
        if(!empty($list)) return $list;
        return array();
    }

    /**
     * 读取间夜升级规则配置和等級配置
     * @param string $inter_id
     * @param int $offset
     * @param int $limit
     * @return bool
     */
    public function get_night_upgrade_rule($inter_id='',$offset=0,$limit=500,$flag=false){
        if(empty($inter_id)) return false;
        $this->load->helper('common_helper');
        if(is_array($inter_id)){
            if($flag===true){ //获取等级配置
                $_member_lvl = $this->_shard_db()->select('member_lvl_id,inter_id,lvl_name,is_default,upgrade_night,keep_night,lvl_up_sort')->where_in('inter_id',$inter_id)->get('member_lvl')->result_array();
                $member_lvl = array();
                foreach ($_member_lvl as $k=>$vo){
                    $member_lvl[$vo['inter_id']][$vo['member_lvl_id']] = array(
                        'name'=>$vo['lvl_name'],
                        'upgrade_night'=>$vo['upgrade_night'],
                        'keep_night'=>$vo['keep_night'],
                        'sort'=>$vo['lvl_up_sort']
                    );
                }

                foreach ($member_lvl as &$vvo){
                    uasort($vvo,'my_sort');
                }
            }

            $this->_shard_db()->where_in('inter_id',$inter_id);
        }else{
            if($flag===true){ //获取等级配置
                $_member_lvl = $this->_shard_db()->select('member_lvl_id,inter_id,lvl_name,is_default,upgrade_night,keep_night,lvl_up_sort')->where('inter_id',$inter_id)->get('member_lvl')->result_array();
                foreach ($_member_lvl as $k=>$vo){
                    $member_lvl[$vo['member_lvl_id']] = array(
                        'name'=>$vo['lvl_name'],
                        'upgrade_night'=>$vo['upgrade_night'],
                        'keep_night'=>$vo['keep_night'],
                        'sort'=>$vo['lvl_up_sort']
                    );
                }
                foreach ($member_lvl as &$vvo){
                    uasort($vvo,'my_sort');
                }
            }


            $this->_shard_db()->where('inter_id',$inter_id);
        }
        $list = $this->_shard_db()->limit($limit,$offset)->get('night_upgrade_rule')
            ->result_array();

        $return = array(
            'night_upgrade_rule'=>$list,
        );
        if($flag===true){
            $return['member_lvl_conf'] = $member_lvl;
        }

        return $return;
    }

    /**
     * 获取数据列表
     * @param array $params 条件参数组
     * @param array $select 查询字段
     * search[value]: 搜索字眼
     * @return mixed
     */
    public function get_admin_list($params=array(),$select=array()){
        $return['total'] = 0;
        $return['data'] = array();
        $table = $params['table_name'];
        $dbfields = $this->get_list_fields($table);
        $exp=array('>','<','!=','<>');
        $where = $where_in = array();
        foreach ($params as $k=>$v){
            //过滤非数据库字段，以免产生sql报错，把in匹配另外处理
            if(in_array($k, $dbfields) ){
                if( is_array($v)){
                    if(!empty($v[0]) && isset($v[1]) && in_array($v[0],$exp))
                        $where[$k.self::SPACE.$v[0]]=$v[1];
                    else
                        $where_in[$k]= $v;
                } else {
                    $where[$k]= $v;
                }
            }

            if(strpos($k,'.')!==false){
                $fk = explode('.',$k);
                if(in_array($fk[1], $dbfields)) {
                    if( is_array($v)){
                        if(!empty($v[0]) && isset($v[1]) && in_array($v[0],$exp))
                            $where[$k.self::SPACE.$v[0]]=$v[1];
                        else
                            $where_in[$k]= $v;
                    } else {
                        $where[$k]= $v;
                    }
                }
            }
        }

        if(isset($params['search']) && is_array($params['search']) && !empty($params['search'])){
            $params['f_like'] = $params['search'];
        }

        $alias = 'a';
        if(isset($params['alias']) && !empty($params['alias'])) $alias = $params['alias']; //主表别名

        $pk= $alias.'.'.$this->_pk;
        if(isset($params['sort_field']) && isset($params['sort_direct'])){
            $sort= $params['sort_field']. ' '. $params['sort_direct'];
        } else $sort= "{$pk} DESC";  //默认排序

        $num= (config_item('grid_static_num'))? config_item('grid_static_num'): 500;
        $page_size= isset($params['page_size'])? $params['page_size']: $num; //获取行数
        if(isset($params['length'])){
            $page_size = $params['length'];
        }

        $return['page_size'] = $page_size;

        $current_page = isset($params['page_num'])? $params['page_num']: 1;

        $return['current_page'] = $current_page;

        if(count($select)==0) $select = array($alias.'.*');
        $select= count($select)==0? '*': implode(',', $select);
        $offset= ($current_page-1)>=0? ($current_page-1)*$page_size: 0; //获取起始行
        if(isset($params['start'])){
            $offset = $params['start'];
        }

        $this->_shard_db()->select("COUNT($alias.$this->_pk) as count")->from($table.' as '.$alias);

        //联表查询
        if(isset($params['join']) && !empty($params['join']) && is_array($params['join'])){
            $join = $params['join'];
            foreach ($join as $key=>$item){
                $this->_shard_db()->join($item['table'],$item['on'],$item['type']);
                if(isset($item['exp']) && !empty($item['exp'])){
                    $this->_shard_db()->where($item['exp']);
                }
            }
        }

        //in条件
        if( count($where_in)>0 ){
            foreach ($where_in as $k => $v ){
                if( count($v) ) $this->_shard_db()->where_in($k, $v);
            }
        }

        if(isset($params['f_like']['value']) && !empty($params['f_like']['value'])){
            //模糊匹配参数
            $like_field = $this->get_like_field($alias,$params['f_type']);
            $this->_shard_db()->group_start();
            foreach ($like_field as $sv) {
                $this->_shard_db()->or_like($sv,$params['f_like']['value']);
            }
            $this->_shard_db()->group_end();
        }

        $tbug = $this->input->get('tbug');
        if($tbug=='1'){
            echo 'cstartime:'.date('Y-m-d H:i:s');
            echo '<br/>';
        }

        if(!empty($params['extendedWhere'])){
            if(count($params['extendedWhere'])!=count($params['extendedWhere'],1)){
                foreach ($params['extendedWhere'] as $k=>$w){
                    if(count($w)!=count($w,1)){
                        foreach ($w as $v){
                            if(!empty($v[0]) && isset($v[1]) && in_array($v[0],$exp))
                                $this->_shard_db()->where($k.self::SPACE.$v[0],$v[1]);
                            else
                                $this->_shard_db()->where($k,$v);
                        }
                    }else{
                        if(!empty($w[0]) && isset($w[1]) && in_array($w[0],$exp))
                            $this->_shard_db()->where($k.self::SPACE.$w[0],$w[1]);
                        else
                            $this->_shard_db()->where($k,$w);
                    }
                }
            }
        }

        $total= $this->_shard_db()->where($where)->get()->row_array();
        if($this->input->get('debug')=='1') {
            echo $this->_shard_db()->last_query();
            echo '<br/>';
        }
        if($tbug=='1'){
            echo 'cendtime:'.date('Y-m-d H:i:s');
            echo '<br/>';
        }
        $return['total'] = $total['count'];

        $this->_shard_db()->select("{$select}")->from($table.' as '.$alias);

        //联表查询
        if(isset($params['join']) && !empty($params['join']) && is_array($params['join'])){
            $join = $params['join'];
            foreach ($join as $key=>$item){
                $this->_shard_db()->join($item['table'],$item['on'],$item['type']);
                if(isset($item['exp']) && !empty($item['exp'])){
                    $this->_shard_db()->where($item['exp']);
                }
            }
        }

        //in条件
        if( count($where_in)>0 ){
            foreach ($where_in as $k => $v ){
                if( count($v) ) $this->_shard_db()->where_in($k, $v);
            }
        }

        if(isset($params['f_like']['value']) && !empty($params['f_like']['value'])){
            //模糊匹配参数
            $like_field = $this->get_like_field($alias,$params['f_type']);
            $this->_shard_db()->group_start();
            foreach ($like_field as $sv) {
                $this->_shard_db()->or_like($sv,$params['f_like']['value']);
            }
            $this->_shard_db()->group_end();
        }

        //分组查询
        if(isset($params['group_by']) && !empty($params['group_by'])) $this->_shard_db()->group_by($params['group_by']);
        if($tbug=='1'){
            echo 'startime:'.date('Y-m-d H:i:s');
            echo '<br/>';
        }

        if(!empty($params['extendedWhere'])){
            if(count($params['extendedWhere'])!=count($params['extendedWhere'],1)){
                foreach ($params['extendedWhere'] as $k=>$w){
                    if(count($w)!=count($w,1)){
                        foreach ($w as $v){
                            if(!empty($v[0]) && isset($v[1]) && in_array($v[0],$exp))
                                $this->_shard_db()->where($k.self::SPACE.$v[0],$v[1]);
                            else
                                $this->_shard_db()->where($k,$v);
                        }
                    }else{
                        if(!empty($w[0]) && isset($w[1]) && in_array($w[0],$exp))
                            $this->_shard_db()->where($k.self::SPACE.$w[0],$w[1]);
                        else
                            $this->_shard_db()->where($k,$w);
                    }
                }
            }
        }

        $result = $this->_shard_db()->where($where)->order_by($sort)->limit($page_size, $offset)->get()->result_array();

        if($tbug=='1'){
            echo 'endtime:'.date('Y-m-d H:i:s');
        }
        if(!empty($result)){
            $return['data'] = $result;
        }
        return $return;
    }

    /**
     * @param array $params 条件参数组
     * @param array $select 查询字段
     * @param string $format
     * @return array
     */
    public function get_admin_filter($params=array(),$select=array(),$other='',$format='array'){
        $return = $this->get_admin_list($params,$select);
        $total = $return['total'];
        $result = $return['data'];
        if(isset($params['ispackage']) && $params['ispackage']=='1'){
            $this->load->model('membervip/admin/package_model','pk_model');
            $result = $this->pk_model->parse_package($result,$other); //处理礼包信息的所包含内容
        }

        if(isset($params['iscard']) && $params['iscard']=='1'){
            $this->load->model('membervip/admin/card_model','c_model');
            $card_id = $params[$params['alias'].'.card_id'];
            $results = $this->c_model->parse_member_card_by_data($result,$card_id); //添加优惠券使用范围
            $result=isset($results['data'])?$results['data']:array();
        }

        $page_size = $return['page_size'];
        $current_page = $return['current_page'];
        $tbug = $this->input->get('tbug');
        if($tbug=='1'){
            echo 'arraystartime:'.date('Y-m-d H:i:s');
            echo '<br/>';
        }
        $this->load->model('membervip/admin/config/attribute_model','ui_model');
        if($format=='array'){
            $tmp= array();
            $field_config = $this->ui_model->get_field_config('grid',$params['ui_type']);
            foreach ($result as $k=> $v){
                $vo = array();
                //判断combobox类型需要对值进行转换
                foreach($field_config as $sk=>$sv){
                    if(!isset($v[$sk])) $vo[$sk] = ''; else $vo[$sk] = $v[$sk];
                    if($field_config[$sk]['type']=='combobox') {
                        if( isset($field_config[$sk]['select'][$v[$sk]])){
                            $vo[$sk]= $field_config[$sk]['select'][$v[$sk]];
                        }
                        else $vo[$sk]= '--';
                    }

                    if( $field_config[$sk]['grid_function'] ) {
                        $funp= explode('|', $field_config[$sk]['grid_function']);
                        $fun= $funp[0];
                        $funp[0] = isset($v[$sk])?$v[$sk]:'';
                        $funp[1] = $v;
                        switch ($sk){
                            case 'member_mode':
                                $funp[2] = $other;
                                $funp[3] = $v['cellphone'];
                                break;
                            case 'is_login':
                                $funp[2] = $other;
                                $funp[3] = $v['cellphone'];
                                break;
                            case 'operation':
                                $funp[1] = $v;
                                $funp[2] = $params['opt'];
                                break;
                        }
                        $vo[$sk] = call_user_func_array(array($this,$fun),$funp);
                    } else if( $field_config[$sk]['function'] ) {
                        $funp= explode('|', $field_config[$sk]['function']);
                        $fun= $funp[0];
                        $funp[0]= $v[$sk];
                        $funp[1] = $v['inter_id'];
                        $vo[$sk]= call_user_func_array (array($this,$fun),$funp);
                    }
                }//---
                if(!empty($vo)){
                    $el= array_values($vo);
                    $el['DT_RowId']= $v[$this->_pk];
                    $tmp[]= $el;
                }
            }
            $result= $tmp;
        }
        if($this->input->get('debug')=='1') {
            echo $total;
            echo '<pre>';
            echo $this->_shard_db()->last_query();
        }
        if($tbug=='1'){
            echo 'arrayendime:'.date('Y-m-d H:i:s');
            echo '<br/>';exit;
        }

        if(is_ajax_request()){
            $return_data = array(
                'draw'=> isset($params['draw'])? $params['draw']: 1,
                'data'=> $result,
                'recordsTotal'=>$total,
                'recordsFiltered'=>$total,
            );
        }else{
            $return_data = array(
                'ui'=>$this->ui_model,
                'total'=>$total,
                'data'=>$result,
                'page_size'=>$page_size,
                'page_num'=>$current_page,
            );
        }
        if(isset($params['iscard']) && $params['iscard']=='1'){
            $return_data['use_num']=isset($results['use_num'])?$results['use_num']:0;
            $return_data['useoff_num']=isset($results['useoff_num'])?$results['useoff_num']:0;
            $return_data['expire_num']=isset($results['expire_num'])?$results['expire_num']:0;
            $return_data['giving_num']=isset($results['giving_num'])?$results['giving_num']:0;
            $return_data['is_get']=isset($results['is_get'])?$results['is_get']:2;
            $return_data['title']=isset($results['title'])?$results['title']:'';
        }
        return $return_data;
    }

    protected function _get_operation(){
        $data = func_get_args();
        $arr = $data[1];
        $opt = $data[2];
        $button = '';
        switch ($opt){
            case '1':
                $member_info_id = $arr['member_info_id'];
                $membership_number = $arr['membership_number'];
                $name = $arr['name'];
                $url = EA_const_url::inst()->get_url('membervip/membermanage/add',array('member_info_id'=>$member_info_id));
                $button .= '<a class="btn btn-sm btn-default" href="'.$url.'">查看详细</a>';
                $button .= '<button type="button" dataid="'.$member_info_id.'" attrno="'.$membership_number.'" attrname="'.$name.'" class="btn btn-sm btn-default adjustment">调整储值</button>';
                $button .= '<a dataid="'.$member_info_id.'" attrno="'.$membership_number.'" attrname="'.$name.'" class="btn btn-sm btn-default integral">积分调整</a>';
                break;
            case '2':
                $package_id = $arr['package_id'];
                $url = EA_const_url::inst()->get_url('membervip/memberpackage/add',array('package_id'=>$package_id));
                $button .= '<a class="btn btn-sm btn-default" href="'.$url.'">编辑</a>';
                $exurl = EA_const_url::inst()->get_url('*/memberexport/package_excel');
                $button .= '<a class="btn btn-sm btn-default memberexport" data-action="'.$exurl.'" href="javascript:void(0);">导出</a>';
                break;
            case '3':
                $card_id = $arr['card_id'];
                $url = EA_const_url::inst()->get_url('*/membercard/add',array('card_id'=>$card_id));
                $button .= '<a class="btn btn-sm btn-default" href="'.$url.'">编辑</a>';
                $url2 = EA_const_url::inst()->get_url('*/membercard/card_user_info/'.$card_id);
                $button .= '<a class="btn btn-sm btn-default" href="'.$url2.'">领取详情</a>';
                break;
        }
        return $button;
    }

    protected function _get_member_mode(){
        $data = func_get_args();
        $mode_value = $data[0];
        $member_mode = $data[2];
        $cellphone = $data[3];
        $name = ' -- ';
        if($member_mode=='login'){
            $name = '粉丝会员';
            if($mode_value=='2') $name = '正式会员';
        }elseif($member_mode=='perfect'){
            $name = '粉丝会员';
            if(!empty($cellphone)) $name = '正式会员';
        }
        return $name;
    }

    protected function _parse_card_type(){
        $data = func_get_args();
        $name='';
        switch ($data[0]){
            case '1':$name='抵用';break;
            case '2':$name='折扣';break;
            case '3':$name='兑换';break;
            case '4':$name='储值';break;
        }
        return $name;
    }

    protected function _get_is_active(){
        $data = func_get_args();
        $name = ' -- ';
        if($data[0]=='t'){
            $name = '正常';
        }elseif ($data[0]=='f'){
            $name = '已冻结';
        }
        return $name;
    }

    protected function _parse_is_active(){
        $data = func_get_args();
        $name = ' -- ';
        if($data[0]=='t'){
            $name = '<span style="color:#18BF0E;"><strong>启用</strong></span>';
        }elseif ($data[0]=='f'){
            $name = '<span style="color:red;" ><strong>禁用</strong></span>';
        }
        return $name;
    }

    protected function _get_is_login(){
        $data = func_get_args();
        $is_login = $data[0];
        $member_mode = $data[2];
        $cellphone = $data[3];
        $name = ' -- ';
        if($is_login=='t'){
            $name = '默认登录';
            if($member_mode=='login' && !empty($cellphone)) $name = '<font color="#26EC0E">已登录</font>';
        }elseif ($is_login=='f'){
            $name = '未登录';
        }
        return $name;
    }

    protected function _parsedatetime(){
        $data = func_get_args();
        if(empty($data[0])) return '------';
        $date = date('Y-m-d H:i:s',$data[0]);
        return $date;
    }

    protected function _parsedate(){
        $data = func_get_args();
        if(empty($data[0])) return '------';
        $date = date('Y-m-d',$data[0]);
        return $date;
    }

    protected function _parse_createtime(){
        $data = func_get_args();
        $_time = $data[0];
        if(empty($data[0]) && isset($data[1]['last_update_time']) && !empty($data[1]['last_update_time'])){
            $_time = strtotime($data[1]['last_update_time']);
        }
        $date = date('Y-m-d H:i:s',$_time);
        return $date;
    }

    protected function _parse_module(){
        $data = func_get_args();
        $name='------';
        $model = array(
            'vip'=>'<span style="color:#26EC0E" >会员模块</span>',
            'hotel'=>'<span style="color:#26EC0E" >订房模块</span>',
            'shop'=>'<span style="color:#26EC0E" >商城模块</span>',
            'soma'=>'<span style="color:#26EC0E" >套票模块</span>',
        );
        if(isset($model[$data[0]])) $name=$model[$data[0]];
        return $name;
    }

    protected function _parse_use_module(){
        $data = func_get_args();
        $name='------';
        $model = array(
            'vip'=>'<span style="color:#E88927" >会员模块</span>',
            'hotel'=>'<span style="color:#E88927" >订房模块</span>',
            'shop'=>'<span style="color:#E88927" >商城模块</span>',
            'soma'=>'<span style="color:#E88927" >套票模块</span>',
        );
        if(isset($model[$data[0]])) $name=$model[$data[0]];
        return $name;
    }

    protected function _parse_useoff_module(){
        $data = func_get_args();
        $name='------';
        $model = array(
            'vip'=>'<span style="color:#EA0041">会员模块</span>',
            'hotel'=>'<span style="color:#EA0041" >订房模块</span>',
            'shop'=>'<span style="color:#EA0041" >商城模块</span>',
            'soma'=>'<span style="color:#EA0041" >套票模块</span>',
        );
        if(isset($model[$data[0]])) $name=$model[$data[0]];
        return $name;
    }

    protected function _parse_use_in(){
        $data = func_get_args();
        if(empty($data[0])) return '';
        $model = array(
            'vip'=> '<span>会员模块</span>',
            'hotel'=>'<span>订房模块</span>',
            'shop'=>'<span>商城模块</span>',
            'soma'=>'<span>套票模块</span>',
        );
        $arr=array();
        foreach ($data[0] as $item){
            $arr[]=$model[$item];
        }
        return implode('/',$arr);
    }

    protected function _parse_is_expire(){
        $data = func_get_args();
        $_time=isset($data[1]['expire_time'])?$data[1]['expire_time']:0;
        $exp=strtotime(date('Y-m-d 23:59:59',$_time));
        $name='否';
        if(time()>$exp) $name='是';
        return $name;
    }

    protected function _parse_card_state(){
        $data = func_get_args();
        $is_use = isset($data[1]['is_use'])?$data[1]['is_use']:'';
        $is_useoff = isset($data[1]['is_useoff'])?$data[1]['is_useoff']:'';
        $is_giving = isset($data[1]['is_giving'])?$data[1]['is_giving']:'';
        $arr=array();
        if($is_use=='t') $arr[]='<span style="color:#EA0041">已使用</span>';
        if($is_useoff=='t') $arr[]='<span style="color:#EA0041">已核销</span>';
        if(empty($arr)){
            if($is_giving=='t') $arr[]='<span style="color:#EA0041">已转赠</span>';
        }
        if(empty($arr)) $arr[]='<span style="color:#26EC0E">未使用</span>';
        $name=implode('/',$arr);
        return $name;
    }

    /**
     * 后台管理的表格中要显示哪些字段
     */
    public function grid_fields($type=1)
    {
        //主键字段一定要放在第一位置，否则 grid位置会发生偏移
        $show = array();
        switch ($type){
            case 1:
                $show = array('member_info_id','nickname','member_mode','name','membership_number','lvl_name','credit', 'balance','mcount','is_active','is_login','createtime','operation');
                break;
            case 2:
                $show = array('package_id','name','remark','credit','balance','lvl_name','is_active','createtime','operation');
                break;
        }
        return $show;
    }

    /**
    +----------------------------------------------------------
     * 生成随机字符串
    +----------------------------------------------------------
     * @param int       $length  要生成的随机字符串长度
    +----------------------------------------------------------
     * @return string
    +----------------------------------------------------------
     */
    public function randCode($length = 5,$srand='') {
        $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $count = strlen($string) - 1;
        $code = '';
        if(!empty($srand)) srand($srand);
        for ($i = 0; $i < $length; $i++) {
            $code .= $string[mt_rand()%$count];
        }
        return $code;
    }

    /**
    +----------------------------------------------------------
     * 生成生成唯一随机码
    +----------------------------------------------------------
     *
     */
    public function create_unique() {
        $data = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']
            .time() . rand();
        return sha1($data);
    }

    /**
     * 验证日期格式
     * @param $dateString
     * @return bool
     */
    public function isDate( $dateString ) {
        return strtotime( date('Y-m-d', strtotime($dateString)) ) === strtotime( $dateString );
    }

    protected function redis_setting(){
        if( isset($_SERVER['CI_ENV']) && $_SERVER['CI_ENV']=='production' ){
            $config = array(
                'task'=> array(
                    'socket_type'   => 'tcp',
                    'password'      => NULL,
                    'timeout'       => 5,
                    'cachedb'       => 14,
                    'host'          => 'redis02',
                    'port'          => 6381
                ),
            );
        } else {
            $config = array(
                'task'=> array(
                    'socket_type'   => 'tcp',
                    'password'      => NULL,
                    'timeout'       => 5,
                    'cachedb'       => 2,
                    'host'          => '120.27.132.97',
                    'port'          => 16379
                ),
            );
        }
        return $config;
    }

    public function get_vip_redis($select = 'task') {
        $redis_config = $this->redis_setting();
        $config = $redis_config[$select];
        if(!is_array($config)) {
            return false;
        }
        $redis = new Redis();
        $success = $redis->connect($config['host'], $config['port'], $config['timeout']);
        MYLOG::w(@json_encode(array('data'=>$redis_config,'success'=>$success)),'membervip/debug-log','wxpay_vip_redis');
        if(!$success) {
            return false;
        }
        return $redis;
    }


    /**
     * XML编码
     * @param mixed $data 数据
     * @param string $root 根节点名
     * @param string $item 数字索引的子节点名
     * @param string $attr 根节点属性
     * @param string $id   数字索引子节点key转换的属性名
     * @param string $encoding 数据编码
     * @return string
     */
    public function xml_encode($data, $root='iwide', $item='item', $attr='', $id='id', $encoding='utf-8') {
        if(is_array($attr)){
            $_attr = array();
            foreach ($attr as $key => $value) {
                $_attr[] = "{$key}=\"{$value}\"";
            }
            $attr = implode(' ', $_attr);
        }
        $attr   = trim($attr);
        $attr   = empty($attr) ? '' : " {$attr}";
        $xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
        $xml   .= "<{$root}{$attr}>";
        $xml   .= $this->data_to_xml($data, $item, $id);
        $xml   .= "</{$root}>";
        return $xml;
    }

    /**
     * 数据XML编码
     * @param mixed  $data 数据
     * @param string $item 数字索引时的节点名称
     * @param string $id   数字索引key转换为的属性名
     * @return string
     */
    public function data_to_xml($data, $item='item', $id='id') {
        $xml = $attr = '';
        foreach ($data as $key => $val) {
            if(is_numeric($key)){
                $id && $attr = " {$id}=\"{$key}\"";
                $key  = $item;
            }
            $xml    .=  "<{$key}{$attr}>";
            $xml    .=  (is_array($val) || is_object($val)) ? $this->data_to_xml($val, $item, $id) : $val;
            $xml    .=  "</{$key}>";
        }
        return $xml;
    }

    /**
     * 生成签名
     * @param array $data 请求参数
     * @param string $secretKey 秘钥
     * Api秘钥，定义为:6lPgIYNsmJhVdyqhtX
     * @return array|bool
     */
    public function signature($data = array(),$secretKey = ''){
        if(empty($data)) return false;
        ksort($data);
        $token = md5($secretKey.http_build_query($data));
        return $token;
    }

    public function get_rfm_data($data = array()){
        if(empty($data)){
            return false;
        }
        $apiurl = "http://api.business.iwide.cn/bulls-eye/get-open-id-list";
        $this->load->helper('common_helper');
        $requestString = http_build_query($data);
        $extra = array(
            'Content-type'=>"application/x-www-form-urlencoded; charset=\"utf-8\"",
            "Accept"=>"text/json",
            "Cache-Control"=>"no-cache",
        );
        $result = doCurlPostRequest($apiurl,$requestString,$extra);
        if(!empty($result) && $result != 'No Data Found'){
            $result = explode(',',$result);
            $arr = array();
            foreach ($result as $vo){
                $openid = trim($vo);
                if(!empty($openid)) $arr[] = $openid;
            }
            $result = $arr;
        }else{
            $result = array();
        }
        return $result;
    }

    /**
     * 获取Excel文件内容，兼容远程和本地
     * @param string $file_path Excel文件地址
     * @param bool $is_num 是否返回数量
     * @return array|bool|int
     */
    public function get_file_content($file_path = '', $is_num = false){
        if(empty($file_path)) return false;
        $xlsx_content = $this->xlsx_parser($file_path);
        if($is_num) return count($xlsx_content);
        return $xlsx_content;
    }

    /**
     * 解析读取Excel文件内容，兼容远程和本地
     * @param string $file_path Excel文件地址
     * @return array
     */
    public function xlsx_parser($file_path = ''){
        if(empty($file_path)) return array();
        $array = $this->do_xlsx_parser($file_path);
        if(empty($array) || empty($array[0]['Content'])) return array();
        $xlsx_arr = array();
        foreach ($array as $val){
            $Content = $val['Content'];
            foreach ($Content as $item){
                if(!empty(trim($item[0])) OR trim($item[0]) === 0) $xlsx_arr[] = $item[0];
            }
        }
        return $xlsx_arr;
    }

    public function do_xlsx_parser($file_path = ''){
        if(empty($file_path)) return array();
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        if(strpos($file_path,'http://') !== false || strpos($file_path,'https://') !== false){
            $fp_output = fopen(FD_PUBLIC.'/task_tmp.xlsx', 'w');
            $ch = curl_init($file_path);
            curl_setopt($ch, CURLOPT_FILE, $fp_output);
            curl_exec($ch);
            curl_close($ch);
            $objPHPExcel = IOFactory::load(FD_PUBLIC.'/task_tmp.xlsx');
//            @unlink(FD_PUBLIC.'/task_tmp.xlsx');
        }else{
            $objPHPExcel = IOFactory::load($file_path);
        }
        $allWorksheets = $objPHPExcel->getAllSheets();
        $i = 0;
        $array = array();
        foreach($allWorksheets as $objWorksheet){
            $sheetname=$objWorksheet->getTitle();
            $allRow = $objWorksheet->getHighestRow();//how many rows
            $highestColumn = $objWorksheet->getHighestColumn();//how many columns
            $allColumn = PHPExcel_Cell::columnIndexFromString($highestColumn);
            $array[$i]["Title"] = $sheetname;
            $array[$i]["Cols"] = $allColumn;
            $array[$i]["Rows"] = $allRow;

            $arr = array();
            $isMergeCell = array();

            foreach ($objWorksheet->getMergeCells() as $cells) {//merge cells
                foreach (PHPExcel_Cell::extractAllCellReferencesInRange($cells) as $cellReference) {
                    $isMergeCell[$cellReference] = true;
                }
            }
            for($currentRow = 1 ;$currentRow<=$allRow;$currentRow++){
                $row = array();
                for($currentColumn=0;$currentColumn<$allColumn;$currentColumn++){
                    $afCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn+1);
                    $bfCol = PHPExcel_Cell::stringFromColumnIndex($currentColumn-1);
                    $col = PHPExcel_Cell::stringFromColumnIndex($currentColumn);
                    $address = $col.$currentRow;
                    $value = $objWorksheet->getCell($address)->getValue();
                    if(is_object($value))  $value = $value->__toString(); //格式化文本
                    if(substr($value,0,1)=='='){
                        $value = '';
//                        return array("error"=>0,'message'=>'can not use the formula!');
//                        exit;
                    }

                    if(!empty($isMergeCell[$col.$currentRow]) && !empty($isMergeCell[$afCol.$currentRow]) && !empty($value)){
                        $temp = $value;
                    }elseif(!empty($isMergeCell[$col.$currentRow]) && !empty($isMergeCell[$col.($currentRow-1)]) && empty($value)){
                        $value = $arr[$currentRow-1][$currentColumn];
                    }elseif(!empty($isMergeCell[$col.$currentRow]) && !empty($isMergeCell[$bfCol.$currentRow]) && empty($value)){
                        if(!empty($temp)) $value=$temp;
                    }
                    $row[$currentColumn] = $value;
                }
                $arr[$currentRow] = $row;
            }
            $array[$i]["Content"] = $arr;
            $i++;
        }

        return $array;
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