<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class SplitRule
 * 分账规则
 * 沙沙
 * 2017-06-27
 */
class SplitRule extends MY_Admin
{
    protected $label_module = '列表';
    protected $label_controller = '列表';
    protected $label_action = '列表';
    public $username = '';

    public function __construct()
    {
        parent::__construct();
        $this->admin_profile = $this->session->userdata('admin_profile');
        $this->load->helper('appointment');
    }


    /**
     * 首页管理列表
     *
     */
    public function index()
    {
        $param = request();
        $return = array(
            'param'      => $param,
        );

        echo $this->_render_content($this->_load_view_file('index'), $return, TRUE);
    }

    /**
     * 分账规则列表
     */
    public function rule_list()
    {
        $param = request();
        $return = array(
            'param'      => $param,
        );

        echo $this->_render_content($this->_load_view_file('rule_list'), $return, TRUE);
    }

    /**
     * 添加
     */
    public function add()
    {
        $param = request();
        $return = array(
            'param'      => $param,
        );

        echo $this->_render_content($this->_load_view_file('add'), $return, TRUE);
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $param = request();
        $return = array(
            'param'      => $param,
        );

        echo $this->_render_content($this->_load_view_file('edit'), $return, TRUE);
    }

    /**
     * 导出规则
     */
    public function ext_data()
    {
        $param = request();
        $filter['inter_id'] = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';
        $filter['hotel_id'] = !empty($param['hotel_id']) ? intval($param['hotel_id']) : '';
        $filter['start_time'] = !empty($param['start_time']) ? addslashes($param['start_time']) : '';
        $filter['end_time'] = !empty($param['end_time']) ? addslashes($param['end_time']) : '';
        $per_page = !empty($param['limit']) ? intval($param['limit']) : '';//显示数量
        $cur_page = !empty($param['offset']) ? intval($param['offset']) : '';//页码

        if (empty($filter['inter_id']))
        {
            die('请求参数错误');
        }

        if (empty($filter['inter_id']))
        {
            $filter['inter_id'] = $this->admin_profile['inter_id'];
        }
        if (empty($filter['hotel_id']))
        {
            $filter['hotel_id'] = $this->admin_profile['entity_id'];
        }

        $this->load->model('iwidepay/iwidepay_rule_model' );
        $status = array(1 => '正常',2 => '无效');
        $module = array('hotel'=>'订房','soma'=>'商城','vip'=>'会员','okpay'=>'快乐付','dc'=>'在线点餐');
        $select = 'mi.module,mi.rule_name,mi.edit_time,mi.status';
        $rules = $this->iwidepay_rule_model->get_hotel_rule($select,$filter,$cur_page,$per_page);
        if (!empty($rules))
        {
            foreach ($rules as $key => $rule)
            {
                $item = array();
                $item['edit_time'] = $rule['edit_time'];
                $item['hotel_name'] = !empty($rule['hotel_name']) ? $rule['hotel_name'] : '所有门店';
                $item['module'] = $module[$rule['module']];
                $item['status'] = $status[$rule['status']];
                $rules[$key] = $item;
            }
        }

        $headArr = array('修改时间','所属门店','生效模块','状态');
        $widthArr = array(20,25,15,12);
        getExcel('门店规则',$headArr,$rules,$widthArr);
    }
}