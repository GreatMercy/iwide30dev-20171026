
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class IwidepayApi
 * @author
 *
 */
class IwidepayApi extends MY_Controller
{
    protected $admin_profile;
    protected $hotel_id;
    const SUCCESS = 1000;//成功
    const FAIL_AUTO = 1001;//失败自动消失
    const FAIL_ALTER = 1002;//失败 需要点击确认
    const UN_LOGIN = 1003;//未登录
    const UN_KNOWN = 1004;//未知错误
    const INTER_STOP = 1005;//公众号已停止服务
    const PARAM_ERROR = 1010;//参数错误
    const UN_OP = 1011;//参数错误
    public function __construct()
    {
        parent::__construct ();

        $this->common_data[$this->security->get_csrf_token_name ()] = $this->security->get_csrf_hash ();

        $this->load->helper('appointment');

        //设置开发用户信息
        $this->set_user();
        $this->admin_profile = $this->session->userdata('admin_profile');

        if (empty($this->admin_profile))
        {
            ajax_return(self::UN_LOGIN,'登录已过期');
        }
        //集团账户
        $this->hotel_id = $this->admin_profile['entity_id'];
    }

    /**
     * 关键词 获取银行账户列表 接口
     * 2017-06-27
     * 沙沙
     */
    public function get_branch()
    {
        $param = request();
        $keyword = !empty($param['keyword']) ? addslashes(trim($param['keyword'])) : '';

        $this->load->model('iwidepay/Iwidepay_bankcode_model');
        $list = $this->Iwidepay_bankcode_model->get_branch('branch_id,branch',array('status' => 1),$keyword);
        $ajaxData = array(
            'list' => $list,
        );
        ajax_return(self::SUCCESS,'成功',$ajaxData);
    }
    /**
     * 银行账户列表 接口
     * 2017-06-27
     * 沙沙
     */
    public function bank_account()
    {
        $param = request();
        $type = !empty($param['type']) ? intval($param['type']) : 0;
        $keyword = !empty($param['keyword']) ? addslashes(trim($param['keyword'])) : '';
        $per_page = !empty($param['limit']) ? intval($param['limit']) : 20;//显示数量
        $cur_page = !empty($param['offset']) ? intval($param['offset']) : 1;//页码

        $inter_id = $this->admin_profile['inter_id'];

        //获取数据
        $this->load->model('iwidepay/iwidepay_merchant_model' );

        $filter = array(
            'is_company' => $type,
            'inter_id' => $inter_id,
            'hotel_id' => $this->hotel_id,
        );

        if (!empty($keyword))
        {
            $filter['wd'] = $keyword;
        }

        $status = array(1=>'有效',2=>'无效');
        $is_company = array(1=>'对公',2=>'对私');
        $select = 'mi.id,mi.inter_id,mi.hotel_id,mi.type,mi.account_aliases,mi.is_company,mi.status,mi.branch_id,mi.bank,mi.bank_card_no,mi.type,mi.bank_user_name';
        $total = $this->iwidepay_merchant_model->count_band_accounts($filter);
        $list = array();
        if ($total > 0)
        {
            $list = $this->iwidepay_merchant_model->get_band_accounts($select,$filter,$cur_page,$per_page);
            if ($list)
            {
                foreach ($list as $key => $value)
                {
                    $value['status'] = $status[$value['status']];
                    $value['is_company'] = $is_company[$value['is_company']];
                    if ($value['type'] == 'jfk')
                    {
                        $value['name'] = $value['hotel_name'] = $value['account_aliases'] = '金房卡';
                    }
                    else if($value['type'] == 'group')
                    {
                        $value['hotel_name'] = '集团';
                    }

                    $value['hotel_name'] = !empty($value['hotel_name']) ? $value['hotel_name'] : '';
                    $value['name'] = !empty($value['name']) ? $value['name'] : '';
                    $value['edit_url'] = site_url('iwidepay/bankAccount/edit?id='.$value['id']);
                    $list[$key] = $value;
                }
            }
        }

        $arr_page = get_page($total, $cur_page, $per_page);

        //组装类型
        $account_type = array(
            '所有',
            '对公',
            '对私'
        );

        foreach ($account_type as $key => $item)
        {
            $value = array();
            $value['status'] = $type == $key ? 1 : 0;
            $value['name'] = $item;
            $value['value'] = $key;
            $account_type[$key] = $value;
        }

        //界面地址
        $url = array(
           // 'select' => site_url('/iwidepay/bankAccount/index'),
            'create' => site_url('/iwidepay/bankAccount/add'),
            'ext_data' => site_url('/iwidepay/bankAccount/ext_data?'.http_build_query($filter)),
        );

        //返回数据
        $ajax_data = array(
            'account_type' => $account_type,
            'url' => $url,
            'keyword' => $keyword,
            'list' => $list,
            'page' => $arr_page,
        );

        $ajax_data = array_merge($ajax_data,$this->common_data);
        ajax_return(self::SUCCESS,'成功',$ajax_data);
    }


    /**
     * 删除银行账户 接口
     * 2017-6-28
     * 沙沙
     */
    public function del_bank_account()
    {
        $param = request();
        $id = !empty($param['id']) ? intval($param['id']) : '';
        if (empty($id))
        {
            ajax_return(self::PARAM_ERROR,'请求参数错误');
        }

        $this->load->model ( 'iwidepay/iwidepay_merchant_model' );

        $where = array(
            'id' => $id,
        );

        //查询数据
        $info = $this->iwidepay_merchant_model->get_one('id,inter_id,type',$where);
        if (empty($info))
        {
            ajax_return(404,'数据不存在');
        }

        if ($info['type'] == 'jfk')
        {
            ajax_return(403,'数据禁止删除');
        }

        //删除数据
        $data = array(
            'status' => 2,//设置无效
        );
        $res = $this->iwidepay_merchant_model->update_account($where,$data);

        if ($res > 0)
        {
            ajax_return(self::SUCCESS,'删除成功');
        }
        else
        {
            ajax_return(self::SUCCESS,'已成功删除');
        }
    }

    /**
     * 添加银行账户 接口
     */
    public function add_bank_account()
    {
        $param = request();
        $inert['type'] = !empty($param['type']) ? addslashes($param['type']) : ''; //用途
        $inert['account_aliases'] = !empty($param['account_aliases']) ? addslashes($param['account_aliases']) : '';//账户别名
        $inert['inter_id'] = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';//公众号
        $inert['hotel_id'] = !empty($param['hotel_id']) ? intval($param['hotel_id']) : ''; //门店
        $inert['is_company'] = !empty($param['is_company']) ? intval($param['is_company']) : '';//账户类型
        $inert['branch_id'] = !empty($param['branch_id']) ? addslashes(trim($param['branch_id'])) : '';//开户银行
        $inert['bank_city'] = !empty($param['bank_city']) ? addslashes($param['bank_city']) : '';//所在市/县
        $inert['bank_user_name'] = !empty($param['bank_user_name']) ? addslashes(trim($param['bank_user_name'])) : '';//账户名
        $inert['bank_card_no'] = !empty($param['bank_card_no']) ? addslashes(trim($param['bank_card_no'])) : '';//银行账号

        if (empty($inert['branch_id']) || empty($inert['bank_city']) || empty($inert['bank_user_name']) || empty($inert['bank_card_no']))
        {
            ajax_return(self::PARAM_ERROR,'请填写完整资料');
        }

        $this->load->model('iwidepay/iwidepay_bankcode_model');
        $this->load->model('iwidepay/iwidepay_merchant_model');

        if ($inert['type'] == 'jfk')
        {
            $inert['inter_id'] = 'jinfangka';
            $inert['hotel_id'] = '0';
        }
        else if ($inert['type'] == 'group')
        {
            $inert['hotel_id'] = '0';
        }

        //判断是否已添加
        $where_arr = array(
            'type'      => $inert['type'],
            'inter_id'  => $inert['inter_id'],
            'hotel_id'  => $inert['hotel_id'],
            'status'    => 1,
        );

        $merchant_info = $this->iwidepay_merchant_model->get_one('id', $where_arr);
        if (!empty($merchant_info))
        {
            ajax_return(1012,'不能重复添加账户');
        }


        //完善安全添加数据判断...
        $bank = $this->iwidepay_bankcode_model->get_one('branch,bank_code,clearBankNo,accBankNo', array('status'=>1,'branch_id' => $inert['branch_id']));
        if (empty($bank))
        {
            ajax_return(404,'银行不存在');
        }

        //组装数据
        $inert['bank'] = $bank['branch'];//支行
        $inert['clearBankNo'] = $bank['clearBankNo'];//清算行号
        $inert['accBankNo'] = $bank['accBankNo'];//受理行号
        $inert['bank_code'] = $bank['bank_code'];//行别代码

        $inert['registered_address'] = '';
        $inert['telephone'] = '';
        $inert['taxpayer_identity_number'] = '';//纳税人识别号
        $inert['status'] = 1;//状态
        $inert['updated_by'] = $this->admin_profile['username'];//修改人
        $inert['updated_at'] = date('Y-m-d H:i:s');//修改时间
        $inert['created_by'] = $this->admin_profile['username'];//状态
        $inert['created_at'] = date('Y-m-d H:i:s');//状态


        $insert_id = $this->iwidepay_merchant_model->insert_account($inert);
        if ($insert_id > 0)
        {
            //更改 生成金房卡内部ID
            $where = array(
                'id' => $insert_id,
            );
            $update = array(
                'jfk_no' => create_merchant_no(1200000 + $insert_id,'FZZH'),
            );
            $this->iwidepay_merchant_model->update_account($where,$update);

            //添加日志
            $inert['jfk_no'] = $update['jfk_no'];
            add_iwidepay_admin_op_log($inert,'add');

            ajax_return(self::SUCCESS,'添加成功');
        }
        else
        {
            ajax_return(204,'添加失败');
        }
    }


    /**
     * 编辑银行账户 接口
     */
    public function edit_bank_account()
    {
        $param = request();
        $id = !empty($param['id']) ? addslashes($param['id']) : ''; //用途
        $update['type'] = !empty($param['type']) ? addslashes($param['type']) : ''; //用途
        $update['account_aliases'] = !empty($param['account_aliases']) ? addslashes($param['account_aliases']) : '';//账户别名
        $update['inter_id'] = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';//公众号
        $update['hotel_id'] = !empty($param['hotel_id']) ? intval($param['hotel_id']) : ''; //门店
        $update['is_company'] = !empty($param['is_company']) ? intval($param['is_company']) : '';//账户类型
        $update['branch_id'] = !empty($param['branch_id']) ? addslashes(trim($param['branch_id'])) : '';//开户银行
        $update['bank_city'] = !empty($param['bank_city']) ? addslashes($param['bank_city']) : '';//所在市/县
        $update['bank_user_name'] = !empty($param['bank_user_name']) ? addslashes(trim($param['bank_user_name'])) : '';//账户名
        $update['bank_card_no'] = !empty($param['bank_card_no']) ? addslashes(trim($param['bank_card_no'])) : '';//银行账号

        if (empty($id) || empty($update['branch_id']) || empty($update['bank_city']) || empty($update['bank_user_name']) || empty($update['bank_card_no']))
        {
            ajax_return(self::PARAM_ERROR,'请填写完整资料');
        }

        //完善安全添加数据判断...
        $this->load->model('iwidepay/iwidepay_bankcode_model');
        $bank = $this->iwidepay_bankcode_model->get_one('branch,bank_code,clearBankNo,accBankNo', array('status'=>1,'branch_id' => $update['branch_id']));
        if (empty($bank))
        {
            ajax_return(404,'银行不存在');
        }

        //组装数据
        $update['bank_code'] = $bank['bank_code'];//行别代码
        $update['bank'] = $bank['branch'];//支行
        $update['clearBankNo'] = $bank['clearBankNo'];//清算行号
        $update['accBankNo'] = $bank['accBankNo'];//受理行号

        $update['taxpayer_identity_number'] = '';//纳税人识别号
        $update['updated_by'] = $this->admin_profile['username'];//修改人
        $update['updated_at'] = date('Y-m-d H:i:s');//修改时间

        $this->load->model('iwidepay/iwidepay_merchant_model');

        $where = array(
            'id' => $id,
        );

        //查询数据
        $info = $this->iwidepay_merchant_model->get_one('id,inter_id,type,jfk_no',$where);
        if (empty($info))
        {
            ajax_return(404,'数据不存在');
        }

        $inter_id = $this->admin_profile['inter_id'];
        $inter_id = explode(',',$inter_id);
        if (!in_array($info['inter_id'],$inter_id,true))
        {
            //ajax_return(403,'非法编辑数据');
        }

        if ($info['type'] == 'jfk')
        {
            ajax_return(403,'数据禁止编辑');
        }

        $update['jfk_no'] = $info['jfk_no'];
        if (empty($update['jfk_no']))
        {
            $update['jfk_no'] =  create_merchant_no(1200000 + $id,'FZZH');
        }

        $insert_id = $this->iwidepay_merchant_model->update_account($where,$update);
        if ($insert_id > 0)
        {
            //添加日志
            add_iwidepay_admin_op_log($update);
            ajax_return(self::SUCCESS,'修改成功');
        }
        else
        {
            ajax_return(204,'修改失败');
        }
    }


    /**
     * 账户详情 接口
     */
    public function bank_account_detail()
    {
        $param = request();
        $id = !empty($param['id']) ? intval($param['id']) : '';

        $this->load->model ( 'iwidepay/iwidepay_merchant_model' );
        $this->load->model ( 'iwidepay/Iwidepay_bankcode_model' );

        $where = array(
            'id' => $id,
        );
        $inter_id = $this->admin_profile['inter_id'];
        //查询数据
        if (!empty($id))
        {
            $select = 'id,inter_id,hotel_id,type,bank,branch_id,bank_user_name,account_aliases,bank_card_no,bank_city,bank_code,status,is_company';
            $info = $this->iwidepay_merchant_model->get_one($select,$where);
            if (empty($info))
            {
                ajax_return(404,'数据不存在');
            }

            $info['bank'] = $info['bank_code'];
        }

        $type_temp = array(
            'group' => '集团分成',
            'hotel' => '门店分成',
            'jfk' => '金房卡分成',
        );

        foreach ($type_temp as $key => $value)
        {
            if ($key == 'jfk')
            {
                $where_arr = array(
                    'type' => $key,
                );
                $bank = $this->iwidepay_merchant_model->get_one('id', $where_arr);
            }
            $temp = array(
                'value' => "$key",
                'name' => $value,
                'status' => empty($bank) ? '1' : '0',//1-可选，0-不可选
            );

            $type[] = $temp;
        }

        //获取公众号
        $filter_public = array();
        if ($inter_id != 'ALL_PRIVILEGES')
        {
            $filter_public['inter_id'] = $inter_id;
        }
        $this->load->model('wx/publics_model');
        $publics = $this->publics_model->get_public_hash($filter_public,array('inter_id','name'));
        if (!empty($publics))
        {
            foreach ($publics as $key => $value)
            {
                if ($value['inter_id'])
                {
                    $item = array(
                        'inter_id' => $value['inter_id'],
                        'name' => $value['name'],
                        'status' => 1,
                    );

                    $public[] = $item;
                }
            }
        }
        unset($publics);

        //获取城市
        $citys = $this->iwidepay_merchant_model->get_city('areaName',array('areaType'=>1,'areaFlag'=>1));//,'parentId'=>440000

        //获取银行
        $where_arr =  array('status'=>1);
        if (!empty($info['branch_id']))
        {
            $where_arr['branch_id'] = $info['branch_id'];
        }

        $banks = $this->Iwidepay_bankcode_model->get_bank('branch,branch_id',$where_arr);
        if (!empty($banks))
        {
            foreach ($banks as $key=>$value)
            {
                $banks[$key] = $value;
            }
        }

        //获取公众号下的酒店
        $this->load->model ( 'hotel/hotel_model' );
        $hotels = $this->hotel_model->get_hotel_hash(array('inter_id'=>!empty($info) ? $info['inter_id'] : $inter_id,'status'=>1));
        if (!empty($hotels))
        {
            foreach ($hotels as $key => $value)
            {
                $item = array(
                    'hotel_id' => $value['hotel_id'],
                    'hotel_name' => $value['name'],
                    'status' => 1,
                );

                $hotels[$key] = $item;
            }
        }

        //账户类型
        $temp_type = array(
            '1' => '对公',
            '2' => '对私',
        );

        foreach ($temp_type as $key => $value)
        {
            $temp = array(
                'value' => "$key",
                'name' => $value,
            );

            $bank_type[] = $temp;
        }

        $temp = array(
            'id' => '',
            'inter_id' => '',
            'hotel_id' => '',
            'type' => '',
            'bank' => '',
            'branch_id' => '',
            'bank_user_name' => '',
            'account_aliases' => '',
            'bank_card_no' => '',
            'bank_city' => '',
            'bank_code' => '',
            'status' => '',
            'is_company' => '',
        );

        $ajax_data = array(
            'bank' => !empty($info) ? array_merge($info,$this->common_data) : array_merge($temp,$this->common_data),
            'type' => $type,
            'hotels' => $hotels,
            'publics' => $public,
            'citys' => !empty($citys) ? $citys : array(),
            'banks' => $banks,
            'bank_type' => $bank_type,
        );
        ajax_return(self::SUCCESS,'成功',$ajax_data);
    }

    /**
     * 结算记录 接口
     */

    public function sum_record()
    {
        $param = request();
        $filter['inter_id'] = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';
        $filter['hotel_id'] = !empty($param['hotel_id']) ? intval($param['hotel_id']) : '';
        $filter['start_time'] = !empty($param['start_time']) ? addslashes($param['start_time']) : '';
        $filter['end_time'] = !empty($param['end_time']) ? addslashes($param['end_time']) : '';
        $per_page = !empty($param['limit']) ? intval($param['limit']) : 20;//显示数量
        $cur_page = !empty($param['offset']) ? intval($param['offset']) : 1;//页码

        if (empty($filter['inter_id']))
        {
            $filter['inter_id'] = $this->admin_profile['inter_id'];
        }

        //集团账号
        if (empty($filter['hotel_id']))
        {
            $filter['hotel_id'] = $this->hotel_id;
        }

        $this->load->model('iwidepay/iwidepay_sum_record_model' );
        $select = 'sr.id,sr.amount,sr.status,sr.is_company,sr.bank,sr.bank_card_no,sr.add_time,sr.update_time,sr.type';
        $total = $this->iwidepay_sum_record_model->count_settlement($filter);
        $list = array();
        if ($total > 0)
        {
            $status = array(0=>'待转账',1=>'成功',2=>'失败',3=>'处理中',10 => '放弃转账');
            $list = $this->iwidepay_sum_record_model->get_settlement($select,$filter,$cur_page,$per_page);
            if ($list)
            {
                foreach ($list as $key => $value)
                {
                    $value['status'] = $status[$value['status']];
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

        $arr_page = get_page($total, $cur_page, $per_page);

        //界面地址
        $url = array(
            'ext_data' => site_url('/iwidepay/settlement/ext_data?'.http_build_query($filter)),
        );

        //返回数据
        $ajax_data = array(
            'list' => $list,
            'page' => $arr_page,
            'url'  => $url,
        );

        $ajax_data = array_merge($ajax_data,$this->common_data);
        ajax_return(self::SUCCESS,'成功',$ajax_data);
    }

    /**
     * 交易流水 接口
     */
    public function transaction_flow()
    {
        $param = request();
        $filter['inter_id'] = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';
        $filter['hotel_id'] = !empty($param['hotel_id']) ? intval($param['hotel_id']) : '';
        $filter['start_time'] = !empty($param['start_time']) ? addslashes($param['start_time']) : '';
        $filter['end_time'] = !empty($param['end_time']) ? addslashes($param['end_time']) : '';
        $filter['module'] = !empty($param['module']) ? addslashes($param['module']) : '';
        $filter['order_status'] = !empty($param['order_status']) ? addslashes($param['order_status']) : '';
        $filter['transfer_status'] = !empty($param['transfer_status']) ? addslashes($param['transfer_status']) : '';
        $filter['order_no'] = !empty($param['order_no']) ? addslashes($param['order_no']) : '';
        $per_page = !empty($param['limit']) ? intval($param['limit']) : 20;//显示数量
        $cur_page = !empty($param['offset']) ? intval($param['offset']) : 1;//页码

        if (empty($filter['inter_id']))
        {
            $filter['inter_id'] = $this->admin_profile['inter_id'];
        }

        //集团账号
        if (empty($filter['hotel_id']))
        {
            $filter['hotel_id'] = $this->hotel_id;
        }

        $this->load->model('iwidepay/iwidepay_order_model' );
        $select = 'o.id,o.inter_id,o.hotel_id,o.module,o.order_no,o.order_status,o.transfer_status,o.orig_amount,o.trans_amt,o.is_dist,o.add_time';
        $total = $this->iwidepay_order_model->count_orders($filter);
        $list = array();
        if ($total > 0)
        {
            $status = array(0=>'--',1=>'待定',2=>'待分',3=>'已分',4=>'异常',5=>'待定未分完',6=>'退款',7=>'已结清全额退款',8=>'部分退款',9=>'已结清部分退款',10=>'退款异常');
            $module = array('hotel'=>'订房','soma'=>'商城','vip'=>'会员','okpay'=>'快乐付','dc'=>'在线点餐','ticket' => '预约核销');
            $is_dist = array('0'=>'否','1'=>'是','2'=>'是','3'=>'是');
            $list = $this->iwidepay_order_model->get_orders($select,$filter,$cur_page,$per_page);
            if ($list)
            {
                foreach ($list as $key => $value)
                {
                    $value['is_dist'] = $is_dist[$value['is_dist']];
                    $value['module'] = $module[$value['module']];

                    // $value['trans_amt'] = formatMoney($value['trans_amt']/100);
                    // if ($value['transfer_status'] == 6 || $value['transfer_status'] == 7)
                    // {
                    //     $value['trans_amt'] = '-' . $value['trans_amt'];
                    // }
                    //add by chenjunyu 2017-07-27 19:20:00 改为显示原始交易金额，退款不显示负号
                    $value['trans_amt'] = formatMoney($value['orig_amount']/100);

                    $value['order_status'] = return_iwidepay_status($value);
                    $value['transfer_status'] = $status[$value['transfer_status']];

                    $value['hotel_name'] = !empty($value['hotel_name']) ? $value['hotel_name'] : '';
                    $value['name'] = !empty($value['name']) ? $value['name'] : '';

                    $list[$key] = $value;
                }
            }
        }

        $arr_page = get_page($total, $cur_page, $per_page);

        //界面地址
        $url = array(
            'ext_data' => site_url('/iwidepay/transaction/ext_data?'.http_build_query($filter)),
        );

        //返回数据
        $ajax_data = array(
            'list' => $list,
            'page' => $arr_page,
            'url'  => $url,
        );

        $ajax_data = array_merge($ajax_data,$this->common_data);
        ajax_return(self::SUCCESS,'成功',$ajax_data);
    }

    /**
     * 获取交易流水初始化 搜索数据
     *
     */
    public function get_order_search()
    {
        $inter_id = $this->admin_profile['inter_id'];
        $filter = array();
        if ($inter_id != 'ALL_PRIVILEGES')
        {
            $filter['inter_id'] = $inter_id;
        }
        //获取公众号
        $public = array();
        $this->load->model('wx/publics_model');
        $publics = $this->publics_model->get_public_hash($filter,array('inter_id','name'));
        if (!empty($publics))
        {
            foreach ($publics as $key => $value)
            {
                if (!empty($value['inter_id']))
                {
                    $item = array(
                        'inter_id' => $value['inter_id'],
                        'name' => $value['name'],
                        'status' => 1,
                    );

                    $public[] = $item;
                }
            }
        }
        unset($publics);

        //获取公众号下的酒店
        $this->load->model ( 'hotel/hotel_model' );
        $hotels = $this->hotel_model->get_hotel_hash(array('inter_id' => $inter_id ,'status'=>1));
        if (!empty($hotels))
        {
            foreach ($hotels as $key => $value)
            {
                $item = array(
                    'hotel_id' => $value['hotel_id'],
                    'hotel_name' => $value['name'],
                    'status' => 1,
                );

                $hotels[$key] = $item;
            }
        }

        //模块
        $temp = array('0'=>'所有模块','hotel'=>'订房','soma'=>'商城','vip'=>'会员','okpay'=>'快乐付','dc'=>'在线点餐','ticket' => '预约核销');
        foreach ($temp as $key => $value)
        {
            $item = array(
                'value' => $key,
                'name' => $value,
            );
            $module[] = $item;
        }

        //分账状态
        $temp = array(0=>'所有状态',1=>'待定',2=>'待分',3=>'已分',4=>'异常',5=>'待定未分完',6=>'全额退款',7=>'已结清全额退款',8=>'部分退款',9=>'已结清部分退款',10=>'退款异常');
        foreach ($temp as $key => $value)
        {
            $item = array(
                'value' => "$key",
                'name' => $value,
            );
            $transfer_status[] = $item;
        }

        //订单状态
        $temp = array(0=>'所有状态','1'=>'用户支付成功','2'=>'全额退款成功','3'=>'部分退款成功');
        foreach ($temp as $key => $value)
        {
            $item = array(
                'value' => "$key",
                'name' => $value,
            );
            $order_status[] = $item;
        }

        //返回数据
        $ajax_data = array(
            'publics'   => $public,
            'hotels'    => $hotels,
            'module'    => $module,
            'order_status' => $order_status,
            'transfer_status' => $transfer_status,
        );
        ajax_return(self::SUCCESS,'成功',$ajax_data);
    }


    /**
     * 获取公众号 接口
     */
    public function get_publics()
    {
        $param = request();
        $inter_id = !empty($param['inter_id']) ? addslashes($param['inter_id']) : $this->admin_profile['inter_id'];
        $filter = array();
        if ($inter_id != 'ALL_PRIVILEGES')
        {
            $filter = array('inter_id' => $inter_id);
        }

        //获取公众号
        $this->load->model('wx/publics_model');
        $publics = $this->publics_model->get_public_hash($filter,array('inter_id','name'));
        $public[0] = array(
            'inter_id' => '',
            'name' => '所有公众号',
            'status' => '1',
        );
        if (!empty($publics))
        {
            foreach ($publics as $key => $value)
            {
                if ($value['inter_id'])
                {
                    $item = array(
                        'inter_id' => $value['inter_id'],
                        'name' => $value['name'],
                        'status' => 1,
                    );

                    $public[] = $item;
                }
            }
        }
        ajax_return(self::SUCCESS,'成功',$public);
    }


    /**
     * 获取公众号 下的酒店信息 接口
     */
    public function get_hotels()
    {
        $param = request();
        $inter_id = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';
        $type = !empty($param['type']) ? intval($param['type']) : 0;
        if (empty($inter_id))
        {
            ajax_return(self::SUCCESS,'无数据',array());
        }

        //防止非法访问数据
        $this->check_admin($inter_id);

        //获取公众号下的酒店
        $this->load->model ( 'hotel/hotel_model' );
        $hotels = $this->hotel_model->get_hotel_hash(array('inter_id'=>!empty($info) ? $info['inter_id'] : $inter_id,'status'=>1));
        $hotel[0] = array(
            'hotel_id' => '',
            'hotel_name' => '所有门店',
            'status' => '1',
        );
        if (!empty($hotels))
        {
            foreach ($hotels as $key => $value)
            {
                $item = array(
                    'hotel_id' => $value['hotel_id'],
                    'hotel_name' => $value['name'],
                    'status' => 1,
                );

                $hotel[] = $item;
            }
            ajax_return(self::SUCCESS,'成功',$hotel);
        }

        ajax_return(self::SUCCESS,'暂无酒店数据');
    }


    /**
     * 获取分账规则模块
     */
    public function get_module()
    {
        $param = request();
        $inter_id = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';
        $hotel_id = !empty($param['hotel_id']) ? addslashes($param['hotel_id']) : '';
        if (empty($inter_id) || empty($hotel_id))
        {
            ajax_return(self::PARAM_ERROR,'请求参数错误');
        }

        //获取规则实例
        $this->load->model('iwidepay/iwidepay_rule_model' );
        $rules = $this->iwidepay_rule_model->get_rules('rule_id,hotel_id,module',array('inter_id' => $inter_id,'hotel_id' => $hotel_id,'status' => 1));
        $rule_hotel = $rule_module = array();
        if (!empty($rules))
        {
            foreach ($rules as $val)
            {
                $rule_hotel[$val['hotel_id']][] = $val['hotel_id'];
                $rule_module[$val['module']] = $val['module'];
            }
        }

        //模块
        $temp = array('all'=>'所有模块','hotel'=>'订房','soma'=>'商城','vip'=>'会员','okpay'=>'快乐付','dc'=>'在线点餐','ticket' => '预约核销');
        foreach ($temp as $key => $value)
        {
            $item = array(
                'value' => "$key",
                'name' => $value,
                'status' => !empty($rule_module[$key]) || ($key == 'all' && !empty($rule_module)) ? '0' : '1',
            );
            $module[] = $item;
        }

        ajax_return(self::SUCCESS,'成功',$module);
    }

    /**
     * 财务对账单
     */
    public function financial()
    {
        $param = request();
        $filter['start_time'] = !empty($param['start_time']) ? addslashes($param['start_time']) : '';
        $filter['end_time'] = !empty($param['end_time']) ? addslashes($param['end_time']) : '';

        $ajax_data = array(
            'download_url' => site_url('/iwidepay/financial/ext_data?'.http_build_query($filter)),
        );
        ajax_return(self::SUCCESS,'成功',$ajax_data);
    }

    /**
     * 获取
     */
    public function split_rule()
    {
        $param = request();
        $inter_id = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';
        $filter['start_time'] = !empty($param['start_time']) ? addslashes($param['start_time']) : '';
        $filter['end_time'] = !empty($param['end_time']) ? addslashes($param['end_time']) : '';
        $per_page = !empty($param['limit']) ? intval($param['limit']) : 20;//显示数量
        $cur_page = !empty($param['offset']) ? intval($param['offset']) : 1;//页码

        $filter['inter_id'] = $inter_id;
        if (empty($inter_id))
        {
            $filter['inter_id'] = $this->admin_profile['inter_id'];
        }

        //集团账号
        $filter['hotel_id'] = $this->hotel_id;

        //获取数据
        $this->load->model('iwidepay/iwidepay_merchant_model' );
        $this->load->model('iwidepay/iwidepay_rule_model' );
        $select = 'mi.inter_id,mi.created_at';
        $total = $this->iwidepay_merchant_model->count_inter_bank($filter);
        $rule_bank = array();
        if ($total > 0)
        {
            $split_status = array('0'=>'停用','1'=>'启用');
            $rule_bank = $this->iwidepay_merchant_model->get_inter_bank($select,$filter,$cur_page,$per_page);
            if (!empty($rule_bank))
            {
                foreach ($rule_bank as $key => $value)
                {
                    //统计规格数
                    $value['rule_number'] = $this->iwidepay_rule_model->count_inter_num($value);
                    if ($value['rule_number'] > 0)
                    {
                        $rule = $this->iwidepay_rule_model->get_rule('edit_time',array('inter_id' => $value['inter_id']),'edit_time desc');
                        $value['created_at'] = !empty($rule) ? $rule['edit_time'] : $value['created_at'];
                    }
                    $value['url'] = site_url('/iwidepay/splitRule/rule_list?inter_id='.$value['inter_id']);
                    $value['name'] = !empty($value['name']) ? $value['name'] : '';
                    $value['split_status'] = isset($value['split_status']) ? $split_status[$value['split_status']] : '';
                    $rule_bank[$key] = $value;
                }
            }
        }

        $arr_page = get_page($total, $cur_page, $per_page);

        //返回数据
        $ajax_data = array(
            'list' => $rule_bank,
            'page' => $arr_page,
        );

        $ajax_data = array_merge($ajax_data,$this->common_data);
        ajax_return(self::SUCCESS,'成功',$ajax_data);

    }

    /**
     * 更改公众号分账状态
     */
    public function change_split_status()
    {
        $param = request();
        $id = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';
        $split_status = !empty($param['split_status']) ? intval($param['split_status']) : '0'; //1-启用，0-停用

        $inter_id = $this->admin_profile['inter_id'];
        if($id != $inter_id && $inter_id !='ALL_PRIVILEGES')
        {
            ajax_return(401,'您无编辑该公众号的权限');
        }

        //获取
        $this->load->model('iwidepay/iwidepay_rule_model' );

        //获取规则实例
        if ($split_status == 1)
        {
            $rules = $this->iwidepay_rule_model->count_hotel_rule(array('hotel_id' => '-1','inter_id' => $id));
            if ($rules < 6)
            {
                ajax_return(1013,'请先添加完所有模块的规则');
            }
        }

        $array = array(
            'split_status' => $split_status,
        );

        $where['inter_id'] = $id;
        $res = $this->iwidepay_rule_model->update_public($where,$array);

        if ($res > 0)
        {
            //写入操作日志
            $array['inter_id'] = $id;
            $array['jfk_no']    = '';
            add_iwidepay_admin_op_log($array,'change');

            ajax_return(self::SUCCESS,'操作成功！');
        }
        else
        {
            ajax_return(401,'操作失败！');
        }
    }


    /**
     * 门店分账规则列表
     *
     */
    public function hotel_rule()
    {
        $param = request();
        $filter['inter_id'] = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';
        $filter['hotel_id'] = !empty($param['hotel_id']) ? intval($param['hotel_id']) : '';
        $filter['start_time'] = !empty($param['start_time']) ? addslashes($param['start_time']) : '';
        $filter['end_time'] = !empty($param['end_time']) ? addslashes($param['end_time']) : '';
        $per_page = !empty($param['limit']) ? intval($param['limit']) : 20;//显示数量
        $cur_page = !empty($param['offset']) ? intval($param['offset']) : 1;//页码

        if (empty($filter['inter_id']))
        {
            ajax_return(self::PARAM_ERROR,'请求参数错误');
        }

        if (empty($filter['inter_id']))
        {
            $filter['inter_id'] = $this->admin_profile['inter_id'];
        }

        //集团账号
        if (empty($filter['hotel_id']))
        {
            $filter['hotel_id'] = $this->hotel_id;
        }

        //防止非法访问数据
        $this->check_admin($filter['inter_id']);

        $this->load->model('iwidepay/iwidepay_rule_model' );
        $total = $this->iwidepay_rule_model->count_hotel_rule($filter);
        $rules = array();
        if ($total > 0)
        {
            $status = array(1 => '正常',2 => '无效');
            $module = array('hotel'=>'订房','soma'=>'商城','vip'=>'会员','okpay'=>'快乐付','dc'=>'在线点餐','ticket' => '预约核销');
            $select = 'mi.rule_id,mi.inter_id,mi.hotel_id,mi.module,mi.rule_name,mi.edit_time,mi.status,mi.regular_jfk_cost,mi.regular_jfk,mi.regular_group,mi.regular_hotel';
            $rules = $this->iwidepay_rule_model->get_hotel_rule($select,$filter,$cur_page,$per_page);
            if (!empty($rules))
            {
                foreach ($rules as $key => $rule)
                {
                    $rule['module'] = $module[$rule['module']];
                    $rule['status'] = $status[$rule['status']];

                    $rule['hotel_name'] = !empty($rule['hotel_name']) ? $rule['hotel_name'] : ($rule['hotel_id'] == '-1' ? '所有门店':'');
                    $rule['regular_jfk_cost'] = $rule['regular_jfk_cost'];
                    $rule['regular_jfk'] = $rule['regular_jfk'];
                    $rule['regular_group'] = $rule['regular_group'] == '-1' ? '剩余金额' : $rule['regular_group'];
                    $rule['regular_hotel'] = $rule['regular_hotel'] == '-1' ? '剩余金额' : $rule['regular_hotel'];
                    $rule['name'] = !empty($rule['name']) ? $rule['name'] : '';
                    $rule['url'] = site_url('/iwidepay/splitRule/edit?rule_id='.$rule['rule_id']);
                    $rules[$key] = $rule;
                }
            }
        }

        $arr_page = get_page($total, $cur_page, $per_page);

        //链接
        $url = array(
            'create' => site_url('/iwidepay/splitRule/add?inter_id='.$filter['inter_id']),
            'ext_data' => site_url('/iwidepay/splitRule/ext_data?'.http_build_query($filter)),
        );

        //返回数据
        $ajax_data = array(
            'list'  => $rules,
            'page'  => $arr_page,
            'url'   => $url,
        );

        $ajax_data = array_merge($ajax_data,$this->common_data);
        ajax_return(self::SUCCESS,'成功',$ajax_data);

    }

    /**
     * 创建规则时初始化接口
     */
    public function rule_data()
    {
        $param = request();
        $inter_id = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';

        if (empty($inter_id))
        {
            ajax_return(self::PARAM_ERROR,'请求参数错误');
        }

        //获取公众号下的酒店
        $this->load->model('hotel/hotel_model');
        $hotels = $this->hotel_model->get_hotel_hash(array('inter_id' => $inter_id,'status'=>1));

        //获取规则实例
        $this->load->model('iwidepay/iwidepay_rule_model' );
        $rules = $this->iwidepay_rule_model->get_rules('rule_id,hotel_id,module',array('inter_id' => $inter_id,'status' => 1));
        $rule_hotel = $rule_module = array();
        if (!empty($rules))
        {
            foreach ($rules as $val)
            {
                $rule_hotel[$val['hotel_id']][] = $val['hotel_id'];
                $rule_module[$val['module']] = $val['module'];
            }
        }

        //模块数量
        $m_module = !empty($rule_hotel[-1]) ? count($rule_hotel[-1]) : 0;//所有门店

        $hotel[] = array(
            'hotel_id' => '-1',
            'hotel_name' => '所有',
            'status' => $m_module >= 5 ? '0' : '1',
        );

        if (!empty($hotels))
        {
            foreach ($hotels as $key => $value)
            {
                $r_number = !empty($rule_hotel[$value['hotel_id']]) ? count($rule_hotel[$value['hotel_id']]) : 0;
                $item = array(
                    'hotel_id' => $value['hotel_id'],
                    'hotel_name' => $value['name'],
                    'status' => $r_number >= 6 || $m_module < 5 ? '0' : '1',
                );

                $hotel[] = $item;
            }
        }

        //模块
        $temp = array('all'=>'所有模块','hotel'=>'订房','soma'=>'商城','vip'=>'会员','okpay'=>'快乐付','dc'=>'在线点餐','ticket' => '预约核销');
        foreach ($temp as $key => $value)
        {
            $item = array(
                'value' => "$key",
                'name' => $value,
                'status' => !empty($rule_module[$key]) || ($key == 'all' && !empty($rule_module)) ? '0' : '1',
            );
            $module[] = $item;
        }

        //查询公众号名字
        $this->load->model('wx/publics_model');
        $public = $this->publics_model->get_public_by_id($inter_id,'inter_id');
        $rule['inter_name'] = !empty($public) ? $public['name'] : '';
        $rule['inter_id'] = $inter_id;
        $rule['regular_jfk_cost'] = $this->handle_rule();
        $rule['regular_jfk'] = $this->handle_rule();
        $rule['regular_group'] = $this->handle_rule();
        $rule['regular_hotel'] = $this->handle_rule();
        $rule['regular_dist'] = array('type'=>'4','value'=>'');

        $ajax_data = array(
            'hotel' => $hotel,
            'module' => $module,
            'rule' => $rule,
        );
        ajax_return(self::SUCCESS,'成功',$ajax_data);

    }


    /**
     * 获取规则信息
     */
    public function rule_detail()
    {
        $param = request();
        $rule_id = !empty($param['rule_id']) ? intval($param['rule_id']) : '';

        if (empty($rule_id))
        {
            ajax_return(self::PARAM_ERROR,'请求参数错误');
        }

        $this->load->model('iwidepay/iwidepay_rule_model' );
        $rule = $this->iwidepay_rule_model->get_one('*',array('rule_id' => $rule_id,'status' => 1));
        if (!empty($rule))
        {
            //获取公众号下的酒店
            $this->load->model('hotel/hotel_model');
            $hotels = $this->hotel_model->get_hotel_hash(array('inter_id'=>$rule['inter_id'],'status'=>1));
            $hotel[0] = array(
                'hotel_id' => '-1',
                'hotel_name' => '所有',
                'status' => '1',
            );

            //获取规则实例
            $rules = $this->iwidepay_rule_model->get_rules('rule_id,hotel_id,module',array('inter_id' => $rule['inter_id'],'status' => 1));
            $rule_hotel = $rule_module = array();
            if (!empty($rules))
            {
                foreach ($rules as $val)
                {
                    $rule_hotel[$val['hotel_id']] = $val['hotel_id'];
                    $rule_module[$val['module']] = $val['module'];
                }
            }

            if (!empty($hotels))
            {
                foreach ($hotels as $key => $value)
                {
                    $item = array(
                        'hotel_id' => $value['hotel_id'],
                        'hotel_name' => $value['name'],
                        'status' => !empty($rule_hotel[$value['hotel_id']]) && $value['hotel_id'] != $rule['hotel_id'] ? '0' : '1',
                    );

                    $hotel[] = $item;
                }
             }

            //模块
            $temp = array('all'=>'所有模块','hotel'=>'订房','soma'=>'商城','vip'=>'会员','okpay'=>'快乐付','dc'=>'在线点餐','ticket' => '预约核销');
            foreach ($temp as $key => $value)
            {
                $item = array(
                    'value' => "$key",
                    'name' => $value,
                    'status' => !empty($rule_module[$key]) && $key != $rule['module'] ? '0' : '1',
                );
                $module[] = $item;
            }

            //查询公众号名字
            $this->load->model('wx/publics_model');
            $public = $this->publics_model->get_public_by_id($rule['inter_id'],'inter_id');
            $rule['inter_name'] = !empty($public) ? $public['name'] : '';
            $rule['regular_jfk_cost'] = $this->handle_rule($rule['regular_jfk_cost']);
            $rule['regular_jfk'] = $this->handle_rule($rule['regular_jfk']);
            $rule['regular_group'] = $this->handle_rule($rule['regular_group']);
            $rule['regular_hotel'] = $this->handle_rule($rule['regular_hotel']);
            $rule['regular_dist'] = array('type'=>'4','value'=>'');

            $ajax_data = array(
                'hotel' => $hotel,
                'module' => $module,
                'rule' => $rule,
            );
            ajax_return(self::SUCCESS,'成功',$ajax_data);
        }
        else
        {
            ajax_return(404,'规则不存在');
        }
    }



    /**
     * 保存规则信息
     */
    public function save_rule()
    {
        $param = request();
        $data['inter_id'] = !empty($param['inter_id']) ? addslashes($param['inter_id']) : '';
        $data['rule_id'] = !empty($param['rule_id']) ? intval($param['rule_id']) : '';
        $data['hotel_id'] = !empty($param['hotel_id']) ? intval($param['hotel_id']) : '-1';
        $rule_info = !empty($param['rule_info']) ? $param['rule_info'] : '';

        //判断参数
        if (empty($data['inter_id']))
        {
            ajax_return(self::PARAM_ERROR,'请选择所属公众号');
        }

        if (empty($rule_info))
        {
            ajax_return(self::PARAM_ERROR,'请填完规则参数');
        }

        //判断账号是否有权限更改/添加当前保存的inter_id
        $this->check_admin($data['inter_id']);

        $this->load->model('iwidepay/iwidepay_rule_model' );
        if (!empty($data['rule_id']))
        {
            $filter = array(
                'rule_id' => $data['rule_id'],
                'inter_id' => $data['inter_id'],
            );

            $rule = $this->iwidepay_rule_model->get_one('jfk_rule_no',$filter);
            if (empty($rule))
            {
                ajax_return(404,'保存失败');
            }

            $data['edit_time'] = date('Y-m-d H:i:s');

            $data['regular_jfk_cost'] = !empty($rule_info['regular_jfk_cost']) ? addslashes(trim($rule_info['regular_jfk_cost'])) : '';//金房卡分账手续费
            $data['regular_jfk'] = !empty($rule_info['regular_jfk']) ? addslashes(trim($rule_info['regular_jfk'])) : '';//金房卡分账数值
            $data['regular_group'] = !empty($rule_info['regular_group']) ? addslashes(trim($rule_info['regular_group'])) : '';//集团分账数值
            $data['regular_hotel'] = !empty($rule_info['regular_hotel']) ? addslashes(trim($rule_info['regular_hotel'])) : '';//门店分账数值
            $data['regular_dist'] = '';//分销员分账数值
            $data['module'] = !empty($rule_info['module']) ? addslashes($rule_info['module']) : '';

            if ($data['regular_group'] != '-1' && ($data['regular_hotel'] != '-1'))
            {
                ajax_return(1015,'门店分成和集团分成必须有一个设置剩余金额类型');
            }
            else if ($data['regular_group'] == '-1' && ($data['regular_hotel'] == '-1'))
            {
                ajax_return(1015,'门店分成和集团分成不允许同时设置剩余金额类型');
            }

            //会员模块门店分成为空
            /*
            if ($data['module'] == 'vip')
            {
                $data['regular_hotel'] = '';
                $data['regular_group'] = '-1';
            }
            */

            //判断设置
            $this->check_set_rule($data);

            //处理单位
            $data['regular_jfk_cost'] = $this->set_rule($data['regular_jfk_cost']);
            $data['regular_jfk'] = $this->set_rule($data['regular_jfk']);
            $data['regular_group'] = $this->set_rule($data['regular_group']);
            $data['regular_hotel'] = $this->set_rule($data['regular_hotel']);

            $res = $this->iwidepay_rule_model->save_rule($filter,$data);
            //添加日志
            $data['jfk_no'] = $rule['jfk_rule_no'];
            add_iwidepay_admin_op_log($data);
        }
        else
        {
            $data['create_time'] = date('Y-m-d H:i:s');
            $data['edit_time'] = date('Y-m-d H:i:s');
            foreach ($rule_info as $item)
            {
                $regular = handle_rule_value($item);
                $data['regular_jfk_cost'] = !empty($regular['regular_jfk_cost']) ? addslashes(trim($regular['regular_jfk_cost'])) : '';//金房卡分账手续费
                $data['regular_jfk'] = !empty($regular['regular_jfk']) ? addslashes(trim($regular['regular_jfk'])) : '';//金房卡分账数值
                $data['regular_group'] = !empty($regular['regular_group']) ? addslashes(trim($regular['regular_group'])) : '';//集团分账数值
                $data['regular_hotel'] = !empty($regular['regular_hotel']) ? addslashes(trim($regular['regular_hotel'])) : '';//门店分账数值
                $data['regular_dist'] =  '';//分销员分账数值
                $data['module'] = !empty($item['module']) ? addslashes($item['module']) : '';

                if ($data['regular_group'] != '-1' && ($data['regular_hotel'] != '-1'))
                {
                    ajax_return(1015,'门店分成和集团分成必须有一个设置剩余金额类型');
                }
                else if ($data['regular_group'] == '-1' && ($data['regular_hotel'] == '-1'))
                {
                    ajax_return(1015,'门店分成和集团分成不允许同时设置剩余金额类型');
                }

                //会员模块门店分成为空
                /*
                if ($data['module'] == 'vip')
                {
                    $data['regular_hotel'] = '';
                    $data['regular_group'] = '-1';
                }
                */

                //判断设置
                $this->check_set_rule($data);

                //处理单位
                $data['regular_jfk_cost'] = $this->set_rule($data['regular_jfk_cost']);
                $data['regular_jfk'] = $this->set_rule($data['regular_jfk']);
                $data['regular_group'] = $this->set_rule($data['regular_group']);
                $data['regular_hotel'] = $this->set_rule($data['regular_hotel']);

                if ($data['module'] == 'all')
                {
                    $module = array('hotel','soma','vip','okpay','dc','ticket');
                    $regular_hotel = $data['regular_hotel'];
                    $regular_group = $data['regular_group'];
                    foreach ($module as $val)
                    {
                        $data['module'] = $val;
                        //会员模块门店分成为空
                        /*
                        if ($data['module'] == 'vip')
                        {
                            $data['regular_hotel'] = '';
                            $data['regular_group'] = '-1';
                        }
                        else
                        {

                        }
                        */

                        $data['regular_hotel'] = $regular_hotel;
                        $data['regular_group'] = $regular_group;

                        $res = $this->iwidepay_rule_model->add_rule($data);
                        //更改 生成金房卡内部ID
                        if ($res > 0)
                        {
                            $where = array(
                                'rule_id' => $res,
                            );
                            $update = array(
                                'jfk_rule_no' => create_merchant_no(1200000 + $res,'GZ'),
                            );
                            $this->iwidepay_rule_model->save_rule($where,$update);

                            //添加日志
                            $log = $data;
                            $log['jfk_no'] = $update['jfk_rule_no'];
                            add_iwidepay_admin_op_log($log,'add');
                        }
                    }
                }
                else
                {
                    $res = $this->iwidepay_rule_model->add_rule($data);
                    //更改 生成金房卡内部ID
                    if ($res > 0)
                    {
                        $where = array(
                            'rule_id' => $res,
                        );
                        $update = array(
                            'jfk_rule_no' => create_merchant_no(1200000 + $res,'GZ'),
                        );
                        $this->iwidepay_rule_model->save_rule($where,$update);

                        //添加日志
                        $log = $data;
                        $log['jfk_no'] = $update['jfk_rule_no'];
                        add_iwidepay_admin_op_log($log,'add');
                    }
                }
            }
        }

        if ($res > 0 )
        {
            ajax_return(self::SUCCESS,"保存成功");
        }
        else
        {
            ajax_return(401,"保存失败");
        }
    }

    /**
     * 退款记录
     */
    public function refund_list()
    {
        $param = request();
        $filter['start_time'] = !empty($param['start_time']) ? addslashes($param['start_time']) : '';
        $filter['end_time'] = !empty($param['end_time']) ? addslashes($param['end_time']) : '';
        $filter['orig_order_no'] = !empty($param['order_no']) ? addslashes($param['order_no']) : '';
        $per_page = !empty($param['limit']) ? intval($param['limit']) : 20;//显示数量
        $cur_page = !empty($param['offset']) ? intval($param['offset']) : 1;//页码

        //集团账号
        $filter['inter_id'] = $this->admin_profile['inter_id'];
        $filter['hotel_id'] = $this->hotel_id;

        $this->load->model('iwidepay/iwidepay_refund_model' );
        $total = $this->iwidepay_refund_model->count_refund($filter);
        $list = array();
        if ($total > 0)
        {
            $select = 'R.inter_id,R.hotel_id,R.module,R.hotel_id,R.amount,R.orig_order_no,R.refund_amt,R.add_time,R.charge,R.type,R.refund_status';
            $list = $this->iwidepay_refund_model->get_refund($select,$filter,$cur_page,$per_page);

            $module = array('hotel'=>'订房','soma'=>'商城','vip'=>'会员','okpay'=>'快乐付','dc'=>'在线点餐','ticket' => '预约核销');
            $refund_status = array('0'=>'--','1'=>'成功','2'=>'失败','3'=>'异常','4' => '失败');
            $type = array('0'=>'--','1'=>'原路退回','2'=>'已结清全额退款','3'=>'部分原路退回','4'=>'已结清部分退款');

            if ($list)
            {
                foreach ($list as $key => $value)
                {
                    $value['type'] = $type[$value['type']];
                    $value['refund_status'] = $refund_status[$value['refund_status']];
                    $value['module'] = $module[$value['module']];

                    $value['amount'] = formatMoney($value['amount']/100);
                    $value['refund_amt'] = formatMoney($value['refund_amt']/100);

                    $value['hotel_name'] = !empty($value['hotel_name']) ? $value['hotel_name'] : '';
                    $value['name'] = !empty($value['name']) ? $value['name'] : '';

                    $list[$key] = $value;
                }
            }
        }

        $arr_page = get_page($total, $cur_page, $per_page);

        //界面地址
        $url = array(
            'ext_data' => site_url('/iwidepay/refund/ext_data?'.http_build_query($filter)),
        );

        //返回数据
        $ajax_data = array(
            'list' => $list,
            'page' => $arr_page,
            'url'  => $url,
        );

        $ajax_data = array_merge($ajax_data,$this->common_data);

        ajax_return(self::SUCCESS,'成功',$ajax_data);
    }

    /**
     * 判断
     * @param $data
     */
    protected function check_set_rule($data)
    {
        $per = 0;
        if (strpos($data['regular_jfk_cost'],'%'))
        {
            $per += $data['regular_jfk_cost'];
        }
        if (strpos($data['regular_jfk'],'%'))
        {
            $per += $data['regular_jfk'];
        }

        if (strpos($data['regular_group'],'%'))
        {
            $per += $data['regular_group'];
        }

        if (strpos($data['regular_hotel'],'%'))
        {
            $per += $data['regular_hotel'];
        }

        //判断百分比
        if ($per > 100)
        {
            ajax_return(1016,'不能设置超过100%');
        }
    }


    /**
     * 超管不能创建数据
     * @param $id
     */
    protected function check_admin($id)
    {
        if ($this->admin_profile['inter_id'] != 'ALL_PRIVILEGES' && $id != $this->admin_profile['inter_id'])
        {
            ajax_return(self::INTER_STOP,'无权限访问该公众号');
        };
    }

    /**
     * 处理固定金额单位
     * @param string $rule
     * @return string
     */
    private function set_rule($rule = '')
    {
        if ($rule == '-1')
        {
            return $rule;
        }
        else
        {
            $temp = explode('%',$rule);
            if (!isset($temp[1]))
            {
                return $rule * 100; //转成分
            }
        }

        return $rule;
    }

    /**
     * 处理规则设置
     * @param string $rule
     * @return array
     */
    private function handle_rule($rule = '')
    {
        $type = !empty($rule) && $rule == -1 ? 3 : 2;
        $temp = explode('%',$rule);
        $arr = array(
            'type' => "$type",
            'value' => !empty($temp[0]) ? $temp[0] : '',
        );
        if (isset($temp[1]))
        {
            $arr['type'] = '1';
        }
        else if ($arr['value'] > 0)
        {
            $arr['value'] = $arr['value']/100;
        }

        return $arr;
    }

    private function set_user()
    {
        $inter_id = 'ALL_PRIVILEGES';//a450089706
        $this->session->set_admin_profile(
            array(
                'admin_id'=> 50,
                'inter_id'=> $inter_id,
                'entity_id'=> '',
                'username'=> 'st888',
                'nickname'=> 'st888',
                'head_pic'=> 'http://test008.iwide.cn/public/media/admin_head_pic/default.png',
                'update_time'=> date('Y-m-d H:i:s'),
                'role'=> array('role_name'=>'','role_lable'=>'超级管理员')
            )

        );
        $this->session->allow_actions = array('adminhtml'=>FULL_ACCESS);
    }
}