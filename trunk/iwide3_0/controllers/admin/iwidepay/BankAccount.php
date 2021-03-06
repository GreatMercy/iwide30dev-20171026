<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class BankAccount
 * 银行账户
 * 沙沙
 * 2017-06-27
 */

class BankAccount extends MY_Admin
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
     * 校验 转账账号
     */
    public function check_bank_account()
    {
        $param = request();
        $export = !empty($param['export']) ? addslashes($param['export']) : '';
        $filter['inter_id'] = $inter_id = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';
        $filter['hotel_id'] = !empty($param['hotel_id']) ? intval($param['hotel_id']) : '';
        $filter['status'] = !empty($param['status']) ? intval($param['status']) : '';
        $filter['start_time'] = !empty($param['start_time']) ? addslashes($param['start_time']) : '';
        $filter['end_time'] = !empty($param['end_time']) ? addslashes($param['end_time']) : '';
        $per_page = !empty($param['limit']) ? intval($param['limit']) : 20;//显示数量
        $cur_page = !empty($param['page']) ? intval($param['page']) : 1;//页码

        //设置分页
        if ($filter)
        {
            $http_build_query = http_build_query($filter).'&';
        }
        if (empty($filter['inter_id']))
        {
            $filter['inter_id'] = $this->admin_profile['inter_id'];
        }

        //集团账号
        if (empty($filter['hotel_id']))
        {
            $filter['hotel_id'] = $this->admin_profile['entity_id'];
        }

        //导出数据
        if ($export == '导出')
        {
            $this->ext_report($filter);
            exit;
        }

        $this->load->model('iwidepay/iwidepay_sum_record_model' );
        $select = 'sr.id,sr.amount,sr.status,sr.is_company,sr.bank,sr.bank_card_no,sr.add_time,sr.update_time,sr.remark,sr.bank_card_no,sr.bank_user_name';
        $total = $this->iwidepay_sum_record_model->count_sum_record($filter);

        //分页
        $arr_page = get_page($total, $cur_page, $per_page);

        $list = array();
        $status = array(0=>'待转账',1=>'成功',2=>'失败',3=>'处理中',10=>'放弃转账');
        if ($total > 0)
        {
            $list = $this->iwidepay_sum_record_model->get_sum_record($select,$filter,$cur_page,$per_page);
            if ($list)
            {
                foreach ($list as $key => $value)
                {
                    $value['status_name'] = $status[$value['status']];
                    $value['amount'] = formatMoney($value['amount']/100);
                    if ($value['type'] == 'jfk')
                    {
                        $value['name'] = $value['hotel_name'] = '金房卡';
                    }
                    else if($value['type'] == 'group')
                    {
                        $value['hotel_name'] = '集团';
                    }

                    $value['hotel_name'] = !empty($value['hotel_name']) ? $value['hotel_name'] : '';
                    $value['name'] = !empty($value['name']) ? $value['name'] : '';

                    $list[$key] = $value;
                }
            }
        }


        $url = site_url('/iwidepay/settlement/transfer_accounts?'.$http_build_query);
        $pagehtml = pagehtml($total, $cur_page, $arr_page['page_total'], $url);

        //界面地址
        $url = array(
            'ext_data' => site_url('/iwidepay/settlement/ext_data?'.http_build_query($filter)),
        );

        //返回数据
        $return = array(
            'pagehtml'  => $pagehtml,
            'list'      => $list,
            'param'     => $filter,
            'url'       => $url,
            'publics'   => array(),//$this->get_publics()
            'hotels'    => array(),//$this->get_hotels($inter_id)
        );

        echo $this->_render_content($this->_load_view_file('check'), $return, TRUE);
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $param = request();
        $return = array(
            'param' => $param,
        );

        echo $this->_render_content($this->_load_view_file('edit'), $return, TRUE);
    }

    /**
     * 导出账户
     */
    public function ext_data()
    {
        $param = request();
        $type = !empty($param['type']) ? intval($param['type']) : 0;
        $keyword = !empty($param['keyword']) ? addslashes($param['keyword']) : '';
        $per_page = !empty($param['limit']) ? intval($param['limit']) : '';//显示数量
        $cur_page = !empty($param['offset']) ? intval($param['offset']) : '';//页码

        $inter_id = $this->admin_profile['inter_id'];

        $filter = array(
            'is_company' => $type,
            'inter_id' => $inter_id,
            'hotel_id' => $this->admin_profile['entity_id'],
        );

        if (!empty($keyword))
        {
            $filter['wd'] = $keyword;
        }

        $this->load->model('iwidepay/iwidepay_merchant_model' );
        $select = 'mi.jfk_no,mi.type,mi.account_aliases,mi.is_company,mi.status,mi.type';
        $list = $this->iwidepay_merchant_model->get_band_accounts($select,$filter,$cur_page,$per_page);

        if ($list)
        {
            $status = array(1=>'有效',2=>'无效');
            $is_company = array(1=>'对公',2=>'对私');
            foreach ($list as $key => $value)
            {
                $item = array();
                $item['jfk_no'] = $value['jfk_no'];
                if ($value['type'] == 'jfk')
                {
                    $value['name'] = $value['hotel_name'] = '金房卡';
                }
                else if($value['type'] == 'group')
                {
                    $value['hotel_name'] = '集团';
                }
                $item['name'] = !empty($value['name']) ? $value['name'] : '';
                $item['hotel_name'] = !empty($value['hotel_name']) ? $value['hotel_name'] : '';
                $item['account_aliases'] = $value['account_aliases'];
                $item['is_company'] = $is_company[$value['is_company']];
                $item['status'] = $status[$value['status']];
                unset($value['type']);
                $list[$key] = $item;
            }
        }
        $headArr = array('账户ID','所属公众号','酒店名称','账户别名','账户类型','账户状态');
        $widthArr = array(20,20,20,20,12,12);
        getExcel('分账银行账户',$headArr,$list,$widthArr);
    }
}