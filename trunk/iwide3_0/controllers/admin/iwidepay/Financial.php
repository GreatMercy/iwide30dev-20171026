<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Transaction
 * 财务对账单
 * 沙沙
 * 2017-06-27
 */

class Financial extends MY_Admin
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
            'param' => $param,
        );

        echo $this->_render_content($this->_load_view_file('index'), $return, TRUE);
    }


    /**
     * 导出数据
     */
    public function ext_data()
    {
        $param = request();
        $filter['inter_id'] = !empty($param['inter_id']) ? addslashes($param['inter_id']) : $this->admin_profile['inter_id'];
        $filter['pay_start_time'] = !empty($param['start_time']) ? addslashes($param['start_time']) : '';
        $filter['pay_end_time'] = !empty($param['end_time']) ? addslashes($param['end_time']) : '';
        $filter['transfer_status'] = 3;//已分账

        //集团账号
        $filter['hotel_id'] = $this->admin_profile['entity_id'];

        $this->load->model('iwidepay/iwidepay_order_model' );
        $this->load->model('iwidepay/iwidepay_refund_model' );
        $this->load->model('iwidepay/iwidepay_transfer_model' );
        $select = 'o.id,o.inter_id,o.hotel_id,o.module,o.order_no,o.pay_no,o.order_status,o.transfer_status,o.trans_amt,o.is_dist,o.pay_time';
        $status = array(0=>'--',1=>'待定',2=>'待分',3=>'已分',4=>'异常',5=>'待定未分完',6=>'退款',7=>'已结清全额退款',8=>'部分退款',9=>'已结清部分退款');
        $module = array('hotel'=>'订房','soma'=>'商城','vip'=>'会员','okpay'=>'快乐付','dc'=>'在线点餐','ticket' => '预约核销','base_pay' => '基础月费');
        $list = $this->iwidepay_order_model->get_orders($select,$filter,'','');

        //已分账
        $sort_time = array();

        if ($list)
        {
            foreach ($list as $key => $value)
            {
                $order_no[] = $value['order_no'];
            }
            $transfer = $this->iwidepay_transfer_model->get_transfer('order_no,type,amount,add_time,module,name',$order_no);
            $transfer_data = $transfer_time = $transfer_hotel = array();
            if (!empty($transfer))
            {
                foreach ($transfer as $val)
                {
                    if ($val['module'] == 'soma')
                    {
                        $transfer_hotel[$val['order_no']] = $transfer_data[$val['type'].'_'.$val['order_no']] = array();

                        $temp[$val['type'].'_'.$val['order_no']][] = !empty($val['name']) ? $val['name'] : '';
                        $transfer_hotel[$val['order_no']] = implode(',',$temp[$val['type'].'_'.$val['order_no']]);

                        $tmp[$val['type'].'_'.$val['order_no']][] = formatMoney($val['amount']/100);
                        $transfer_data[$val['type'].'_'.$val['order_no']] = implode(',',$tmp[$val['type'].'_'.$val['order_no']]);
                    }
                    else
                    {
                        $transfer_data[$val['type'].'_'.$val['order_no']] = formatMoney($val['amount']/100);
                    }

                    $transfer_time[$val['order_no']] = $val['add_time'];
                }
            }

            unset($transfer);

            foreach ($list as $key => $value)
            {
                $item = array();
                $item['add_time'] = $value['pay_time'];
                $item['name'] = !empty($value['name']) ? $value['name'] : '';
                $item['hotel_name'] = !empty($value['hotel_name']) ? $value['hotel_name'] : '';
                $item['module'] = $module[$value['module']];
                $item['order_no'] = $value['order_no'];
                $item['pay_no'] = $value['pay_no'];
                $item['order_status'] = '交易';
                $value['trans_amt'] = formatMoney($value['trans_amt']/100);

                if ($value['transfer_status'] == 6 || $value['transfer_status'] == 7)
                {
                    $value['trans_amt'] = '-' . $value['trans_amt'];
                }

                $item['transfer_status'] = '已分账';
                $item['transfer_time'] = !empty($transfer_time[$value['order_no']]) ? date('Y-m-d',strtotime($transfer_time[$value['order_no']])) : '--';

                $item['trans_amt'] =  $value['trans_amt'];
                $item['sell_hotel_id'] = !empty($transfer_hotel[$value['order_no']]) ? $transfer_hotel[$value['order_no']] : '';

                //分成
                $item['cost'] = !empty($transfer_data['cost'.'_'.$value['order_no']]) ? $transfer_data['cost'.'_'.$value['order_no']] : '--';
                $item['jfk'] = !empty($transfer_data['jfk'.'_'.$value['order_no']]) ? $transfer_data['jfk'.'_'.$value['order_no']] : '--';
                $item['group'] = !empty($transfer_data['group'.'_'.$value['order_no']]) ? $transfer_data['group'.'_'.$value['order_no']] : '--';
                $item['hotel'] = !empty($transfer_data['hotel'.'_'.$value['order_no']]) ? $transfer_data['hotel'.'_'.$value['order_no']] : '--';
                $item['dist'] = !empty($transfer_data['dist'.'_'.$value['order_no']]) ? $transfer_data['dist'.'_'.$value['order_no']] : '--';

                $list[$key] = $item;

                $sort_time[] = $item['add_time'];
            }
        }

        //已结清全额退款
        $where_arr = $filter;
        $where_arr['start_time'] = $filter['pay_start_time'];
        $where_arr['end_time'] = $filter['pay_end_time'];
        $where_arr['type'] = 2;
        $select = 'R.inter_id,R.hotel_id,R.module,R.hotel_id,R.amount,R.orig_order_no,R.refund_amt,R.add_time,R.charge';
        $list_refund = $this->iwidepay_refund_model->get_refund($select,$where_arr,'','');

        if (!empty($list_refund))
        {
            foreach ($list_refund as $key => $value)
            {
                $item = array();
                $item['add_time'] = $value['add_time'];
                $item['name'] = !empty($value['name']) ? $value['name'] : '';
                $item['hotel_name'] = !empty($value['hotel_name']) ? $value['hotel_name'] : '';
                $item['module'] = $module[$value['module']];
                $item['order_no'] = $value['orig_order_no'];
                $item['pay_no'] = '--';
                $item['order_status'] = '退款';
                $item['transfer_status'] = '已结清全额退款';
                $item['transfer_time'] = '--';
                $item['trans_amt'] = formatMoney($value['refund_amt']/100);
                $item['sell_hotel_id'] = '--';

                //分成
                $item['cost'] = formatMoney($value['charge']/100);
                $item['jfk'] = '0';
                $item['group'] = '0';
                $item['hotel'] = formatMoney(($value['refund_amt'] - $value['charge'])/100);
                $item['dist'] = '0';

                $list_refund[$key] = $item;

                $sort_time[] = $item['add_time'];
            }

            $list = array_merge($list,$list_refund);
        }

        array_multisort($sort_time, SORT_DESC, $list);

        $headArr = array('交易时间','所属公众号','所属门店','来源模块','平台订单号','支付订单号','交易类型','分账状态','分账时间','交易/退款金额(元)','核销门店','交易手续费','金房卡分成','集团分成','门店分成','分销员分成');
        $widthArr = array(20,20,20,12,20,20,12,12,12,12,12,12,12,14);
        getExcel('分账财务对账表',$headArr,$list,$widthArr);

    }
}