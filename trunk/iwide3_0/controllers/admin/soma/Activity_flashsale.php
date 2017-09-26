<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use App\models\soma\Activity_killsec as ActivityKillsecModel;
use App\models\soma\Activity_killsec_instance as ActivityKillsecInstanceModel;
use App\services\soma\KillsecService;

class Activity_flashsale extends MY_Admin_Soma
{

    protected $label_module = NAV_PACKAGE_GROUPON;        //统一在 constants.php 定义
    protected $label_controller = '限时购活动';        //在文件定义
    protected $label_action = '';                //在方法中定义

    public function main_model_name()
    {
        return 'soma/activity_killsec_model';
    }

    /**
     * 限时购列表页
     * @author xuxianjia
     */
    public function grid()
    {
        $inter_id = $this->current_inter_id;

        $killsecModel   = new ActivityKillsecModel();
        $instanceModel  = new ActivityKillsecInstanceModel();

        //空在这里的意义是代表为全部
        $status = $this->input->get('status');

        $per_page = $this->input->get('per_page',TRUE);
        if( $per_page && $per_page > 0 )
        {
            $page = $per_page;
        } else {
            $page = 1;
        }

        //分页
        $getPerPageNum = $this->input->get('per_page_num') ? $this->input->get('per_page_num') : 20;
        $postPerPageNum = $this->input->post('per_page_num') ? $this->input->post('per_page_num') : 0;
        if( $postPerPageNum && $postPerPageNum > 0 )
        {
            $perPageNum = $postPerPageNum + 0;
        } else {
            $perPageNum = $getPerPageNum + 0;
        }

        $this->load->library('pagination');
        $config['per_page']             = $perPageNum;
        $config['use_page_numbers']     = TRUE;
        $config['cur_page']             = $page;

        $search = $this->input->post('search') ? $this->input->post('search') : '';
        $search = trim( $search );

        $model_name = $this->main_model_name();
        $model = $this->_load_model($model_name);

        if( $search )
        {
            $result = $killsecModel->searchKillsecList($inter_id, $search, $model::ACT_TYPE_ASTBUY);
            $total  = count($result);
        } else {
            $result = $killsecModel->getKillsecList($inter_id, $status, $config['cur_page'], $config['per_page'], 'act_id desc', $model::ACT_TYPE_ASTBUY);
            $total  = $killsecModel->getKillsecTotal($inter_id, $status, $model::ACT_TYPE_ASTBUY);
        }

        //如果没有筛选时间状态的，状态值对应着实例表的状态值
        if( $result && !$status )
        {
            foreach( $result as $k=>$v )
            {
                $nowTime = date('Y-m-d H:i:s');
                if( $v['start_time'] > $nowTime )
                {
                    //未开始
                    $result[$k]['notice_status'] = '';
                } elseif( $v['start_time'] < $nowTime && $nowTime < $v['killsec_time'] ) {
                    //准备开始
                    $result[$k]['notice_status'] = $instanceModel::STATUS_PREVIEW;
                } elseif( $v['killsec_time'] < $nowTime && $nowTime < $v['end_time'] ) {
                    //进行中
                    $result[$k]['notice_status'] = $instanceModel::STATUS_GOING;
                } elseif( $v['end_time'] < $nowTime ) {
                    //已结束
                    $result[$k]['notice_status'] = $instanceModel::STATUS_FINISH;
                }
            }
        }

        $config['page_query_string']    = TRUE;
        $config['base_url']             = Soma_const_url::inst()->get_url('*/*/*');
        $config['total_rows']           = $total;
        $config['cur_tag_open']         = '<ib pagebtn_gray nowpage>';
        $config['cur_tag_close']        = '</ib>';
        $config['num_tag_open']         = '<ib pagebtn_gray>';
        $config['num_tag_close']        = '</ib>';
        $config['prev_tag_open']        = '<ib pagebtn_gray>';
        $config['prev_tag_close']       = '</ib>';
        $config['next_tag_open']        = '<ib pagebtn_gray>';
        $config['next_tag_close']       = '</ib>';
        $config['next_link']            = '>'; // 下一页显示
        $config['prev_link']            = '<'; // 上一页显示
        $this->pagination->initialize($config);

        $pageTotal = ceil( $total / $config['per_page'] );//计算出有多少页
        $tokenArr = array(
            'name' => $this->security->get_csrf_token_name(),
            'value' => $this->security->get_csrf_hash()
        );
        $view_params = array(
            'check_data'    => FALSE,
            'data'          => $result,
            'tokenArr'      => $tokenArr,
            'page_count'    => count($result),
            'total'         => $total,
            'search'        => $search,
            'page'          => $page,
            'pageTotal'     => $pageTotal,
            'status'        => $status,
            'model'         => $killsecModel,
            'instanceModel' => $instanceModel,
            'perPageNum'    => $perPageNum,
            'pageUrl'       => Soma_const_url::inst()->get_url('*/*/*',array('status'=>$status,'per_page_num'=>$perPageNum,'per_page'=>'')),
            'statusUrl'     => Soma_const_url::inst()->get_url('*/*/*',array('status'=>'')),
            'editUrl'       => Soma_const_url::inst()->get_url('*/*/edit',array('ids'=>'')),
            'pagination'    => $this->pagination->create_links(),
        );

        $html= $this->_render_content($this->_load_view_file('grid'), $view_params, TRUE);
        echo $html;
    }

    /**
     * 限时购活动新增
     * @author xuxianjia
     */
    public function edit()
    {

        $this->label_action = '活动修改';
        $this->_init_breadcrumb($this->label_action);

        $model_name = $this->main_model_name();
        $model = $this->_load_model($model_name);

        $id = intval($this->input->get('ids'));
        $model = $model->load($id);
        if (!$model) {
            $model = $this->_load_model();
        }
        $fields_config = $model->get_field_config('form');

        //越权查看数据跳转
        if (!$this->_can_edit($model)) {
            $this->session->put_error_msg('找不到该数据');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid'));
        }

        $temp_id = $this->session->get_temp_inter_id();
        if ($temp_id) {
            $inter_id = $temp_id;
        } else {
            $inter_id = $this->session->get_admin_inter_id();
        }

        $disabled = FALSE;
        if ($inter_id == FULL_ACCESS) {
            $disabled = TRUE;
        }

        $this->load->model('soma/Activity_model');
        $this->load->model('wx/Publics_model','PublicsModel');
        $publics = $this->PublicsModel->get_public_by_id($inter_id);

        //活动开始前一个小时不能修改
        if(isset($id) && !empty($id))
            $isTrue = $model->load($id)->can_modify();
        else
            $isTrue = true;

//        $this->load->model( 'soma/product_package_model', 'product_package' );
//        $products_arr = $this->product_package->get_product_package_list( '', $inter_id , NULL, 1000);
//
//        foreach($products_arr as $product){
//            $productsInfo[$product['product_id']]['stock'] = $product['stock'];
//            $productsInfo[$product['product_id']]['price_package'] = $product['price_package'];
//        }

        $view_params = array(
            'disabled' => $disabled,
            'model' => $model,
            'fields_config' => $fields_config,
            'check_data' => FALSE,
            'ActivityModel' => $this->Activity_model,
            'public'    =>  $publics,
            'can_modify'    =>  $isTrue,
//            'product_info' => $productsInfo
        );
        if(!empty($id)) {
            $killSecInfo = $model->getByID($id);
            $view_params['killSecInfo'] =   $killSecInfo;
        }

        $html = $this->_render_content($this->_load_view_file('edit'), $view_params, TRUE);
        echo $html;
    }

    /**
     * 获取商品规格列表
     * @author xuxianjia
     */
    public function get_product_specification()
    {
        $product_id = $this->input->post('product_id');
        $act_id = $this->input->post('act_id');
        $temp_id = $this->session->get_temp_inter_id();
        if ($temp_id) {
            $inter_id = $temp_id;
        } else {
            $inter_id = $this->session->get_admin_inter_id();
        }
        $model_name = $this->main_model_name();
        $model = $this->_load_model($model_name);

        //获取商品信息
        $this->load->model( 'soma/product_package_model', 'product_package');
        $product_info = $this->product_package->get_product_package_phone_by_product_id($product_id, $inter_id);

        //获取商品规格信息
        $this->load->model( 'soma/Product_specification_setting_model', 'specification_setting');
        $specification_arr = $this->specification_setting->get_specification_setting($inter_id, $product_id);

        //获取商品分类详情
        $this->load->model( 'soma/Category_package_model', 'category_package');
        $category_info = $this->category_package->get_category_package_by_cat_id($product_info['cat_id'], $inter_id);

        $setting_arr_map = [];
        $product_killsec_price = 0.00;
        $product_killsec_count = 0;
        $is_specification = 0;      //1.多规格，2.不是多规格
        //编辑-获取已保存的抢购价和抢购库存
        if ($act_id > 0) {
            $killSecInfo = $model->getByID($act_id);
            //是多规格,从活动规格配置表获取价格和库存
            if ($killSecInfo['is_specification'] == $model::IS_SPECIFICATION_YES) {
                $this->load->model( 'soma/Activity_killsec_specification_model', 'killsec_specification' );
                $setting_arr = $this->killsec_specification->getSpecificationByActID($act_id);
                foreach ($setting_arr_map as $key => $val) {
                    $setting_arr_map[$val['setting_id']] = $val;
                }
                $is_specification = 1;
            }else {
                //不是多规格,采用活动表商品的微信价和库存
                $product_killsec_price = $killSecInfo['killsec_price'];
                $product_killsec_count = $killSecInfo['killsec_count'];
                $is_specification = 2;
            }
        }

        $setting_data = [];
        $metadata = [
            'cat_name' => $category_info['cat_name'],
            'product_id' => $product_id,
            'product_name' => $product_info['name'],
            'setting_id' => 0,
            'spec_name' => '',
            'spec_price' => 0.00,
            'spec_stock' => 0,
            'killsec_price' => 0.00,
            'killsec_count' => 0
        ];

        if (!empty($specification_arr)) {
            $is_specification = 1;
            foreach ($specification_arr as $key => $val) {
                $setting_spec_compose = json_decode($val['setting_spec_compose'], true);
                if (!isset($setting_spec_compose[$val['setting_id']]['spec_name'])) {
                    echo json_encode(['data' => [], 'is_specification' => $is_specification]);
                    exit;
                }
                $setting_data[] = array_merge($metadata, [
                    'setting_id' => $val['setting_id'],
                    'spec_name' => implode('/', $setting_spec_compose[$val['setting_id']]['spec_name']),
                    'spec_price' => $val['spec_price'],
                    'spec_stock' => $val['spec_stock'],
                    'killsec_price' => isset($setting_arr_map[$val['setting_id']]) ? $setting_arr_map[$val['setting_id']]['killsec_price'] : 0.00,
                    'killsec_count' => isset($setting_arr_map[$val['setting_id']]) ? $setting_arr_map[$val['setting_id']]['killsec_count'] : 0
                ]);
            }
        }else {
            $is_specification = 2;
            $setting_data[] = array_merge($metadata, [
                'spec_price' => $product_info['price_package'],
                'spec_stock' => $product_info['stock'],
                'killsec_price' => $product_killsec_price,
                'killsec_count' => $product_killsec_count,
            ]);
        }

        echo json_encode(['data' => $setting_data, 'is_specification' => $is_specification]);
        exit;
    }

    /**
     * 限时购活动编辑提交
     * @author xuxianjia
     */
    public function edit_post()
    {
        $this->label_action = '信息维护';
        $this->_init_breadcrumb($this->label_action);

        $model_name = $this->main_model_name();
        $model = $this->_load_model($model_name);
        $pk = $model->table_primary_key();

        $this->load->model('soma/ticket_center_model', 'ticket_center');
        $activityId = $this->ticket_center->get_id_product('package');

        $this->load->library('form_validation');
        $post = $this->input->post();

        $temp_id = $this->session->get_temp_inter_id();
        if ($temp_id) {
            $inter_id = $temp_id;
        } else {
            $inter_id = $this->session->get_admin_inter_id();
        }

        $post['inter_id'] = isset($post['inter_id']) ? $post['inter_id'] : $inter_id;
        $post['is_stock'] = isset($post['is_stock']) &&  $post['is_stock'] == 1 ? $post['is_stock'] : 0;

        $labels = $model->attribute_labels();
        $base_rules = array(
            'act_name' => array(
                'field' => 'act_name',
                'label' => $labels['act_name'],
                'rules' => 'trim|required',
            ),
            'product_id' => array(
                'field' => 'product_id',
                'label' => $labels['product_id'],
                'rules' => 'trim|required',
            ),
            'killsec_count' => array(
                'field' => 'killsec_count',
                'label' => $labels['killsec_count'],
                'rules' => 'trim|required',
            ),
            'killsec_price' => array(
                'field' => 'killsec_price',
                'label' => $labels['killsec_price'],
                'rules' => 'trim|required',
            ),
        );

        if( strlen($post['act_name']) > 90){
            $this->session->put_error_msg('活动名称字数不能超过30个汉字！');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/edit'));
        }

        if(strlen($post['keyword']) > 150){
            $this->session->put_error_msg('关键字描述字数不能超过50个汉字！');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/edit'));
        }

        if (isset($post['schedule_type']) && $post['schedule_type'] == 2) {

            if ($post['end_time'] <= 0 || $post['end_time'] > 23) {
                $this->session->put_error_msg('按星期进行的秒杀时长必须在1~23之间!');
                $this->_redirect(Soma_const_url::inst()->get_url('*/*/edit'));
            }

            $schedule =   $post['schedule'];
            $post['schedule'] = implode(',', $post['schedule']);

            if (empty($post['schedule'])) {
                $this->session->put_error_msg('必须勾选星期选项！');
                $this->_redirect(Soma_const_url::inst()->get_url('*/*/edit'));
            }


            /*计算时间最接近的日期*/
            $nowDateTime = date("Y-m-d H:i:s",time());
            if (isset($post['schedule_type']) && $post['schedule_type'] == 2) {             //周期是以周期开始日期计算
                if($post['cycle_stime']." ".$post['killsec_time'] < $nowDateTime){
                    $startTime = $nowDateTime;
                }else{
                    $startTime = $post['cycle_stime']." ".$post['killsec_time'];
                }
            }else{
                if($post['start_time'] < $nowDateTime){
                    $startTime = $nowDateTime;
                }else{
                    $startTime = $post['cycle_stime'];
                }
            }

            $w = date("w", strtotime($startTime));
            if($w == 0){
                $w = 7;
            }
            if(is_array($schedule) && in_array($w,$schedule) && ( date("Y-m-d",strtotime($startTime))." ".$post['killsec_time'] ) > date("Y-m-d H:i:s",time() + 600)){
                $startTime = date("Y-m-d",strtotime($startTime))." ".$post['killsec_time'];
            }else if(is_array($schedule)){
                $i = 0;
                while($w){
                    $w ++;
                    $temp  = $w % 7;
                    $i ++;
                    if(in_array($temp,$schedule) || ($temp == 0 && in_array($w,$schedule)))
                        break;

                }
                $startTime = date("Y-m-d",strtotime($startTime) + $i* 86400)." ".$post['killsec_time'];
            }
            $post['killsec_time'] = $startTime;
            $post['end_time']  =   date("Y-m-d H:i:s" , strtotime($startTime) + $post['end_time'] * 3600);
            /*end 时间最接近的日期*/

        } else {

            if ($post['end_time'] <= 0 || $post['end_time'] > 72) {
                $this->session->put_error_msg('按日期进行的秒杀时长必须在1~72之间!');
                $this->_redirect(Soma_const_url::inst()->get_url('*/*/edit'));
            }

            $post['schedule'] = '';
            $post['end_time'] = date('Y-m-d H:i:s', strtotime($post['killsec_time']) + $post['end_time'] * 3600);
        }

        if (!$post['start_time'] || !$post['killsec_time']) {
            $this->session->put_error_msg('此次数据修改失败，请设置好活动的开始时间和秒杀时间！');
            $this->_redirect(Soma_const_url::inst()->get_url('*/*/edit'));

        } else {
            if (date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($post['killsec_time']) - 600)) {
                $this->session->put_error_msg('秒杀时间至少预留10分钟，请重新调整！');
                $this->_redirect(Soma_const_url::inst()->get_url('*/*/edit'));

            } else {
                if ($post['start_time'] > date('Y-m-d H:i:s', strtotime($post['killsec_time']) - 600)) {
                    $this->session->put_error_msg('活动开始时间必须早于秒杀时间10分钟！');
                    $this->_redirect(Soma_const_url::inst()->get_url('*/*/edit'));
                }
            }
        }

        //秒杀价
        $killsec_price = isset($post['killsec_price']) ? $post['killsec_price'] + 0 : 0;
        if ($killsec_price < 0) {
            $post['killsec_price'] = 0;
        } else {
            $post['killsec_price'] = $killsec_price;
        }

        //秒杀数量
        $killsec_count = isset($post['killsec_count']) ? $post['killsec_count'] + 0 : 0;
        if ($killsec_count < 0) {
            $post['killsec_count'] = 0;
        } else {
            $post['killsec_count'] = $killsec_count;
        }

        //商品名称
        $this->load->model('soma/product_package_model', 'product_package');
        $product_id = isset($post['product_id']) ? $post['product_id'] : NULL;
        if ($product_id) {
            $product_info = $this->product_package->get_product_package_detail_by_product_id($product_id, $inter_id);
            if ($product_info) {
                $post['product_name'] = $product_info['name'];
            } else {
                $post['product_name'] = '';
            }
        } else {
            $post['product_name'] = NULL;
        }


        if(isset($post[$pk]) && !empty($post[$pk]))
            $act_id = $post[$pk];
        else
            $act_id = '';

        $post['cycle_stime'] = date("Y-m-d H:i:s",strtotime($post['cycle_stime']));
        $post['cycle_etime'] = date("Y-m-d H:i:s",strtotime($post['cycle_etime']));
        /*时间交集验证*/
        $checkIntersectResult = KillsecService::getInstance()->checkIntersect($product_id,$post['schedule_type'],$post['killsec_time'],$post['end_time'],$act_id,$post['cycle_stime'],$post['cycle_etime'],$post['schedule']);
        if(isset($checkIntersectResult['status']) && $checkIntersectResult['status'] == true){
            $this->session->put_error_msg('此次数据保存失败,该商品的秒杀时间有重合！已存在的秒杀编号：'.$checkIntersectResult['killsec']['act_id']);
            if(!empty($act_id)){
                $this->_redirect(Soma_const_url::inst()->get_url('*/*/edit'));
            }else{
                $this->_redirect(Soma_const_url::inst()->get_url('*/*/add'));
            }

        }
        /*end 时间交集验证*/

        if (empty($post[$pk])) {
            //add data.
            // $post[$pk] = $activityId;
            $post['create_time'] = date('Y-m-d H:i:s', time());

            $post['status'] = Activity_killsec_model::STATUS_TRUE;
            $post['type'] =  2;//目前先写死了秒杀的type


            $this->form_validation->set_rules($base_rules);

            if ($this->form_validation->run() != FALSE) {

                $result = $model->_activity_save($post, $inter_id);

                $message = ($result) ?
                    $this->session->put_success_msg('已新增数据！') :
                    $this->session->put_notice_msg('此次数据保存失败！');
                $this->_log($model);
                $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid'));

            } else {
                $model = $this->_load_model();
            }

        } else {

            //活动开始前一个小时不能修改
            $pk = $model->table_primary_key();
            $post['act_type'] = $model::ACT_TYPE_KILLSEC;
            $isTrue = $model->load($post[$pk])->can_modify();
            if (!$isTrue) {
                $this->session->put_error_msg('活动准备与进行期间不能修改');
                $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid'));
            }

            //修改数据的时候，如果改变了状态，需要发送一个信号到中心平台，修改中心平台的状态
            if (isset($post['status']) && !empty($post['status']) && $post['status'] == Soma_base::STATUS_FALSE) {
                $this->load->model('soma/Center_activity_model', 'CenterModel');
                $this->CenterModel->update_status_byActIds($post['act_id']);
            }

            $this->form_validation->set_rules($base_rules);

            if ($this->form_validation->run() != FALSE) {
                //
                $result = $model->_activity_edit($post, $inter_id);

                $message = ($result) ?
                    $this->session->put_success_msg('已保存数据！') :
                    $this->session->put_notice_msg('此次数据修改失败！');
                $this->_log($model);
                $this->_redirect(Soma_const_url::inst()->get_url('*/*/grid'));

            } else {
                $model = $model->load($post[$pk]);
            }
        }

        //验证失败的情况
        $validat_obj = _get_validation_object();
        $message = $validat_obj->error_html();
        //页面没有发生跳转时用寄存器存储消息
        $this->session->put_error_msg($message, 'register');

        $this->load->model('soma/Activity_model');

        $fields_config = $model->get_field_config('form');
        $view_params = array(
            'model' => $model,
            'fields_config' => $fields_config,
            'check_data' => TRUE,
            'ActivityModel' => $this->Activity_model,
        );
        $html = $this->_render_content($this->_load_view_file('edit'), $view_params, TRUE);
        echo $html;
    }

    /**
     * 使限时购活动失效
     * @author xuxianjia
     */
    public function disable_status()
    {
        $actId = $this->input->post('act_id');

        $result = KillsecService::getInstance()->disable($actId);

        $model_name = $this->main_model_name();
        $model = $this->_load_model($model_name);
        $model = $model->load($actId);
        $this->_log($model);

        $this->json($result->toArray());
    }

    /**
     * 改变库存，这里暂时只能增加不能减少
     * @author xuxianjia
     */
    public function modify_stock()
    {
        $return = array( 'status'=>Soma_base::STATUS_FALSE, 'msg'=>'操作失败', 'data'=>'' );

        $inter_id = $this->session->get_admin_inter_id();
        $actId = $this->input->post('act_id');
        $addStockNum = $this->input->post('add_stock_num');

        if(!is_numeric($actId) || $actId < 0 || !is_numeric($addStockNum) || $addStockNum <= 0 ){
            echo json_encode($return);
            exit;
        }


        $stocksInfoObj = KillsecService::getInstance()->getStock($actId);
        $stocksInfo = $stocksInfoObj->toArray();

        if($stocksInfo && $stocksInfo['status'] && isset($stocksInfo['data']['status']) && $stocksInfo['data']['status']){
            $model_name = $this->main_model_name();
            $model = $this->_load_model($model_name);
            $model = $model->load($actId);
            $killsec = $model->getByID($actId);

            //iwide_soma_activity_killsec
            $updateData['act_id'] = $actId;
            $updateData['killsec_count'] = $addStockNum + $killsec['killsec_count'];

            $result = $model->_activity_edit($updateData, $inter_id);
            $this->_log($model);
            //iwide_soma_activity_killsec_instance
            $instanceModel  = new ActivityKillsecInstanceModel();
            $instance = $instanceModel->getUsingRow($killsec['act_id'], $killsec['killsec_time'], $killsec['end_time']);

            $decreaseResult = $instanceModel->increase($instance['instance_id'], 'killsec_count', $addStockNum);


            //设置redis上的库存
            $result = KillsecService::getInstance()->addRedisStock($actId,$addStockNum);
            if($result){
                $return['status']  = Soma_base::STATUS_TRUE;
                $return['msg']  = '操作成功！';
            }else{
                $return['msg']  = '操作失败！[参考信息：Redis设置失败]';
            }

        }else{
            $return['msg'] = '获取秒杀信息失败[参考信息：Redis获取失败]';
        }

        echo json_encode( $return );
    }

    /**
     * 检查redis实例化情况
     * @author xuxianjia
     */
    public function check_instance_status()
    {
        $return = array(
            'status' => Soma_base::STATUS_FALSE,
            'msg'   => '获取实例化失败'
        );

        $actId = $this->input->post('act_id');
        $model_name = $this->main_model_name();
        $model = $this->_load_model($model_name);
        $model = $model->load($actId);
        $killsec = $model->getByID($actId);

        if (empty($killsec)) {
            $return['msg'] = '获取秒杀活动信息失败';
            echo json_encode($return);
            die;
        }

        $instanceModel  = new ActivityKillsecInstanceModel();
        $instance = $instanceModel->getUsingRow($killsec['act_id'], $killsec['killsec_time'], $killsec['end_time']);

        if(empty($instance)){
            $return['msg'] = '获取秒杀活动实例失败，实例尚未生成';
            echo json_encode($return);
            die;
        }

        $key =    "soma_killsec2_".$instance['instance_id']; //放秒杀活动的库存

        $this->config->load('redis', true, true);
        $redis_config = $this->config->item('redis');
        $redis = new Redis();
        if ( ! $redis->connect($redis_config['host'], $redis_config['port'], $redis_config['timeout'])) {
            throw new RuntimeException('redis connect fail');
        }

        $result = $redis->get($key);
        if(  $result !== false ){
            $return['status'] = Soma_base::STATUS_TRUE;
            $return['msg'] = "实例ID：".$instance['instance_id']." | Redis：".$result;
        }else{
            $return['msg'] = '获取秒杀活动实例失败<br/>实例ID：'.$instance['instance_id']."<br/>Redis没有成功赋值";
            echo json_encode($return);
            die;
        }

        echo json_encode($return);
    }
}
