<?php

class MY_Admin_Soma extends MY_Admin {

    protected $label_module= NAV_SOMA;		//统一在 constants.php 定义
    
    public $db_shard_config= array();
    public $current_inter_id= '';
    public $view_file= '';
    
    public function __construct()
    {
        parent::__construct();

        $this->load->somaDatabase($this->db_soma);
        $this->load->somaDatabaseRead($this->db_soma_read);

        $inter_id= $this->session->get_admin_inter_id();
        $temp_id= $this->session->get_temp_inter_id();
        
        if( $temp_id ){
            $this->_init_current_inter_id($temp_id);
            
        } else if( $inter_id && $inter_id != FULL_ACCESS){
            $this->_init_current_inter_id($inter_id);
        }

        return $this;
    }

    protected function _init_current_inter_id($inter_id)
    {
        $this->load->model('soma/shard_config_model', 'model_shard_config');
        $this->current_inter_id= $inter_id;
        $this->db_shard_config= $this->model_shard_config->build_shard_config($inter_id);  //提取所有公众号的数据源分片数据
        //print_r($this->db_shard_config);
    }

    protected function _toolkit_writelist( $module='soma' )
    {
        $writelist= array(
            'soma'=> array('libinyan', 'luguihong', 'F.oris'),
        );
        //$current_id= $this->session->get_admin_id();
        $current_user= $this->session->get_admin_username();
        if( in_array($current_user, $writelist[$module]) )
            return TRUE;
        else 
            die('该功能为开发者调试数据所用。');
    }

    /**
     * 获取中心平台公众号ID
     */
    protected function get_center_inter_id() {
        if( isset($_SERVER['CI_ENV']) && $_SERVER['CI_ENV']=='production' ){
            // return 'a429262688';a476864535
            return 'a476864535';
        } else {
            // 测试环境中心平台公众号
            return "a471258436";
        }
    }
    protected function _center_writelist( $module='center' )
    {
        $writelist= array(
            'center'=> array('luguihong','F.oris','zxpt-001','jfkpingtai','jianlei1','jianlei'),
        );
        //$current_id= $this->session->get_admin_id();
        $current_user= $this->session->get_admin_username();
        if( in_array($current_user, $writelist[$module]) ){
            $inter_id = $this->session->get_admin_inter_id();
            $cener_inter_id = $this->get_center_inter_id();
            if( $inter_id == $cener_inter_id ){
                return TRUE;
            }else{
                die('该功能为中心平台所属的公众号使用。');
            }
        }
        else {
            die('该功能为中心平台管理者所用。');
        }
    }
    
    public function delete()
    {
        try {
            $model_name= $this->main_model_name();
            $model= $this->_load_model($model_name);
            
            $ids= explode(',', $this->input->get('ids'));
            $result= $model->delete_in($ids);
			$this->_log($model);
            
            if( $result ){
                $this->session->put_success_msg("删除成功");
                
            } else {
                $this->session->put_error_msg('删除失败');
            }
            
        } catch (Exception $e) {
            $message= '删除失败过程中出现问题！';
            //$message= $e->getMessage();
            $this->session->put_error_msg('删除失败');
        }
        $url= EA_const_url::inst()->get_url('*/*/grid');
        $this->_redirect($url);
    }
    
    public function _grid($filter= array(), $viewdata=array())
    {
        //print_r($filter);die;
        $model_name= $this->main_model_name();
        $model= $this->_load_model($model_name);

        //filter params: the same with table fields...
        //sort params: sort_direct, sort_field
        //page params: page_size, page_num
        $params= $this->input->get() ? $this->input->get() : array();
        if(is_array($filter) && count($filter)>0)
            $params= array_merge($params, $filter);
        
        if(is_ajax_request()){
            //处理ajax请求
            $result= $model->filter_json($params );
            echo json_encode($result);
            
        } else {
            //HTML输出
			if( !$this->label_action ) $this->label_action= '信息列表';
            $this->_init_breadcrumb($this->label_action);

            //base grid data..
            $result= $model->filter($params);
            $fields_config= $model->get_field_config('grid');
            $default_sort= $model::default_sort_field();
            //print_r($fields_config);die;
                
            $view_params= array(
                'module'=> $this->module,
                'model'=> $model,
                'result'=> $result,
                'fields_config'=> $fields_config,
                'default_sort'=> $default_sort,
            );

            $view_params= $view_params+ $viewdata;

            $view_file= $this->view_file? $this->view_file: 'grid';
            $html= $this->_render_content($this->_load_view_file($view_file), $view_params, TRUE);
            //echo $html;die;
            echo $html;
        }
    }

    public function _grid_new($filter= array(), $inter_id=NULL, $viewdata=array(), $select=array(), $page = array(), $like = array(), $order = array())
    {
        //print_r($filter);die;
        $model_name= $this->main_model_name();
        $model= $this->_load_model($model_name);

        //HTML输出
        if( !$this->label_action ) $this->label_action= '信息列表';
        $this->_init_breadcrumb($this->label_action);

        //base grid data..
        $fields_config= $model->get_field_config('grid');
        $default_sort= $model::default_sort_field();
        //print_r($fields_config);die;

        if(count($select)==0) {
            $select= $model->grid_fields();
        }
        $select= count($select)==0? '*': implode(',', $select);


        $limit = isset($page['page_size']) ? $page['page_size'] : 5;
        $offset = isset($page['page_num']) ? (($page['page_num'] - 1) >= 0? ($page['page_num'] - 1) * $limit : 0) : 0;

        // $result = $model->get_shipping_info( $filter, $inter_id, $select );
        $table_name = $model->table_name( $inter_id );
        // 新后台必须对数据进行分页处理
        $result = array();
        if(count($page) <= 0) {
            $result = $model->_shard_db( $inter_id )
                            ->select( $select )
                            ->where( $filter );
            $result = $this->set_like($result, $like);
            $result = $this->set_order_by($result, $order);
            $result = $result->get( $table_name )->result_array();
        }
        else {
            $result = $model->_shard_db( $inter_id )->select( $select );
            //$result = $this->set_order_by($result, $order);
            $result = $this->set_like($result, $like);
            $result = $this->set_order_by($result, $order);
            $result = $result->where( $filter );
            $result = $result->limit($limit, $offset)
                             ->get( $table_name )
                             ->result_array();
        }



        $total = $model->_shard_db( $inter_id )
                       ->select( $select )
                       ->where( $filter );
        $total = $total->order_by('product_id', 'desc');
        $total = $this->set_like($total, $like);
        $total = $this->set_order_by($total, $order);
        $total = $total->get( $table_name )
                       ->num_rows();

        $result = $this->get_result_grid($result, $model, $total);

        $result['page_size'] = $limit;
        $result['page_num'] = isset($page['page_num']) ? $page['page_num'] : 0;

        $view_params= array(
            'module'=> $this->module,
            'model'=> $model,
            'result'=> $result,
            'fields_config'=> $fields_config,
            'default_sort'=> $default_sort,
        );

        $view_params= $view_params+ $viewdata;

        $view_file= $this->view_file? $this->view_file: 'grid';
        $html= $this->_render_content($this->_load_view_file($view_file), $view_params, TRUE);
        //echo $html;die;
        echo $html;
    }

    private function set_like($model = null, $like = array()){
        //like: [['and', 'name', '标题', 'before'], ['or', 'name', '标题', 'before']];
        if(!empty($like)){
            foreach ($like as $val){
                $mode = 'like';
                if($val[0] == 'or'){
                    $mode = 'or_like';
                }
                $model = $model->$mode($val[1], $val[2], $val[3]);
            }
        }
        return $model;
    }

    private function set_order_by($model = null, $order = array()){
        //order: [['id' => 'desc'], ['oid' => 'asc']]
        if(!empty($order)){
            foreach ($order as $val){
                foreach ($val as $item => $vale){
                    $model = $model->order_by($item, $vale);
                }
            }
        }
        return $model;
    }

    public function get_result_grid( $result, $model, $total = 100)
    {
        $tmp= array();
        $field_config= $model->get_field_config('grid');
        foreach ($result as $k=> $v){
            //判断combobox类型需要对值进行转换
            foreach($field_config as $sk=>$sv){
                if($field_config[$sk]['type']=='combobox') {
                    if( isset($field_config[$sk]['select'][$v[$sk]])){
                        $v[$sk]= $field_config[$sk]['select'][$v[$sk]];
                    }
                    else $v[$sk]= '--';
                }
                if( $field_config[$sk]['grid_function'] ) {
                    $funp= explode('|', $field_config[$sk]['grid_function']);
                    $fun= $funp[0];
                    $funp[0]= $v[$sk];
                    $v[$sk]= call_user_func_array ($fun, $funp);
                } else if( $field_config[$sk]['function'] ) {
                    $funp= explode('|', $field_config[$sk]['function']);
                    $fun= $funp[0];
                    $funp[0]= $v[$sk];
                    $v[$sk]= call_user_func_array ($fun, $funp);
                }
            }//---

            $el= array_values($v);
            $el['DT_RowId']= $v[$model->table_primary_key()];
            $tmp[]= $el;
        }
        $result= $tmp;

        return array(
            'total'=>$total,
            'data'=>$result,
            'page_size'=>500,
            'page_num'=>1,
        );
    }

    public function _do_export($data, $header, $type='csv', $download=TRUE )
    {
        switch ($type) {
            case 'csv':
            default:
                $tmppath= FD_. 'export'. DS;
                $urlpath= base_url('public/export'). '/';
                if(!file_exists($tmppath)) @mkdir($tmppath, 0777, TRUE);
                $tmpfile= $this->module. '_'. $this->controller. '_'. $this->action. '_'
                    . date('ymdHis_'. rand(10, 99)). '.'. $type;
    
                if($download== TRUE){
                    header( 'Content-Type: text/csv' );
                    header( 'Content-Disposition: attachment;filename='.$tmpfile);
                }
    
                $fp = fopen($tmppath. $tmpfile, 'w');
    
                //转换字符集
                array_unshift($data, $header);
                foreach ($data as $k=> $v){
                    foreach ($v as $sk=> $sv){
                        if (strlen($sv) >= 10) {
                            $data[$k][$sk]= '="' . convert_to_gbk($sv) . '"';
                        } else {
                            $data[$k][$sk]= convert_to_gbk($sv);
                        }
                    }
                }
                //print_r($data);die;
                
                if($fp){
                    //循环插入数据
                    foreach ($data as $k => $line) {
                        if($download== TRUE){
                            echo implode(',', $line) . "\n";
                        }
                        fputcsv($fp, $line, ',', '"');
                    }
                    fclose($fp);
                }
                
                break;
        }
        //上传到ftp
    
        //@unlink($tmppath. $tmpfile);
        return $urlpath. $tmpfile;
    }

    public function _get_real_inter_id( $is_prevent=FALSE )
    {
		$inter_id= $this->session->get_temp_inter_id();
		if( !$inter_id ) $inter_id= $this->session->get_admin_inter_id();
		
        if( $inter_id==FULL_ACCESS && $is_prevent ) {
            $this->session->put_error_msg('不能用跨公众号账号进行此操作。');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid'));
        } else {
            return $inter_id;
        }
    }

    /**
     * @param $serviceName
     * @param string $prefix
     * @return string
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function serviceAlias($serviceName, $prefix = 'soma')
    {
        return $prefix . '_' . strtolower($serviceName);
    }

    /**
     * @param string $serviceName
     * @param string $prefix
     * @return string
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function serviceName($serviceName, $prefix = 'soma')
    {
        return "$prefix/$serviceName";
    }

    /**
     * @param $arr
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function json($arr)
    {
        $this->output->set_content_type('Content-Type: application/json');
        $this->output->set_output(json_encode($arr));
    }

    /**
     * 根据scope_product_link_id获取价格配置名称
     * @param $scopeProductLinkId
     * @return Ambigous|string
     * @author luguihong  <luguihong@jperation.com>
     */
    public function getScopeDiscountName($scopeProductLinkId)
    {
        $scopeName = '';
        //获取价格配置的名称
        if( $scopeProductLinkId )
        {
            $scopeProductLinkModel = new \App\models\soma\ScopeProductLink();
            $scopeModel = new \App\models\soma\ScopeDiscount();
            $scopeProductLinkModel = $scopeProductLinkModel->load($scopeProductLinkId);
            if( $scopeProductLinkModel )
            {
                $scopeId = $scopeProductLinkModel->m_get('scope_id');
                if( $scopeId )
                {
                    $scopeModel = $scopeModel->load($scopeId);
                    if( $scopeModel )
                    {
                        $scopeName = $scopeModel->m_get('name');
                    }
                }
            }
        }

        return $scopeName;
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
}
