<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Fans extends MY_Admin_Iapi {
    protected $label_module = NAV_HOTEL;
    protected $label_controller = '粉丝分析';
    protected $label_action = '';
    function __construct() {
        parent::__construct ();
        $this->inter_id = $this->session->get_admin_inter_id ();
        $this->module = 'hotel';
        $this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
        $this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
        // $this->output->enable_profiler ( true );
    }
    protected function main_model_name() {
        return 'wx/Fans_model';
    }


    public function fans_report(){

        $data = $this->common_data;
        $this->load->model("wx/Fans_model");
        $this->load->model("hotel/Hotel_model");
        $hotels = $this->Hotel_model->get_all_hotels($this->inter_id,null,'key');
        $params = array();
        $data['new_total'] = 0;
        $data['self_total'] = 0;
        $data['scan_total'] = 0;
        $data['dis_total'] = 0;
        $data['cancel_total'] = 0;
        $data['date_data'] = array();
        $data['hotel_data'] = array();
        $data['percentage'] = 0;

        $get = $this->input->get();

        if(isset($get['hotel_id']))$params['hotel_id'] = $get['hotel_id'];

        $data['total'] = $this->Fans_model->total_fans($this->inter_id,$params); //累计粉丝

        if(!isset($get['startdate']) || !isset($get['enddate'])){
            $get['startdate'] = '2017-08-01';
            $get['enddate'] = '2017-08-12';
        }

        $params['startdate'] = $get['startdate'];
        $params['enddate'] = $get['enddate'];


        $dt_start = strtotime($params['startdate']);
        $dt_end = strtotime($params['enddate']);
        while ($dt_start<=$dt_end){
            $each_day[date('Y-m-d',$dt_start)] = array('date'=>date('Y-m-d',$dt_start));
            $dt_start = strtotime('+1 day',$dt_start);
        }


        $params['cur_status'] = 1;
        $time_total = $this->Fans_model->total_fans($this->inter_id,$params);   //筛选条件后总粉丝


        $date_new_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'date');  //按日期统计新增
        $hotel_new_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'hotel');//按酒店统计新增

        $date_self_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'date',-1);  //按日期统计自主关注
        $hotel_self_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'hotel',-1);  //按酒店统计自主关注

        $dis_date_fans = $this->Fans_model->dis_fans($this->inter_id,$params,'date');   //按日期统计分销
        $dis_hotel_fans = $this->Fans_model->dis_fans($this->inter_id,$params,'hotel');   //按酒店统计分销

        $scan_date_fans = $this->Fans_model->dis_fans($this->inter_id,$params,'date',2);   //按日期统计扫码关注
        $scan_hotel_fans = $this->Fans_model->dis_fans($this->inter_id,$params,'hotel',2);   //按酒店统计扫码关注

        $params['cur_status'] = 2;
        $date_cancel_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'date');  //按日期统计取消
        $hotel_cancel_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'hotel');//按酒店统计取消


        $days = round((strtotime($params['enddate'])-strtotime($params['startdate']))/86400);
        $o_startdate = date('Y-m-d',strtotime($params['startdate'])-($days+1)*86400);
        $o_enddate = date('Y-m-d',strtotime($params['enddate'])-($days+1)*86400);

        $params['cur_status'] = 1;
        $params['startdate'] = $o_startdate;
        $params['enddate'] = $o_enddate;

        $o_total = $this->Fans_model->total_fans($this->inter_id,$params);   //环比总粉丝


        if(!empty($each_day)){
            foreach($each_day as $key => $e_day){
                $each_day[$key]['new'] = isset($date_new_fans[$key])? $date_new_fans[$key]['total'] : 0;
                $each_day[$key]['self'] = isset($date_self_fans[$key])? $date_self_fans[$key]['total'] : 0;
                $each_day[$key]['dis'] = isset($dis_date_fans[$key])? $dis_date_fans[$key]['total'] : 0;
                $each_day[$key]['scan'] = isset($scan_date_fans[$key])? $scan_date_fans[$key]['total'] : 0;
                $each_day[$key]['cancel'] = isset($date_cancel_fans[$key])? $date_cancel_fans[$key]['total'] : 0;

                $data['new_total'] += $each_day[$key]['new'];
                $data['self_total'] += $each_day[$key]['self'];
                $data['scan_total'] += $each_day[$key]['dis'];
                $data['dis_total'] += $each_day[$key]['scan'];
                $data['cancel_total'] += $each_day[$key]['cancel'];
            }
        }

        if(!empty($hotels)){
            $hotel_data = array(
                -1 => array(
                    'hotel_id' => -1,
                    'hotel_name' => '无'
                )
            );
            $hotel_data[-1]['new'] = isset($hotel_new_fans[-1])? $hotel_new_fans[-1]['total'] : 0;
            $hotel_data[-1]['self'] = isset($hotel_self_fans[-1])? $hotel_self_fans[-1]['total'] : 0;
            $hotel_data[-1]['dis'] = isset($dis_hotel_fans[-1])? $dis_hotel_fans[-1]['total'] : 0;
            $hotel_data[-1]['scan'] = isset($scan_hotel_fans[-1])? $scan_hotel_fans[-1]['total'] : 0;
            $hotel_data[-1]['cancel'] = isset($hotel_cancel_fans[-1])? $hotel_cancel_fans[-1]['total'] : 0;
            foreach($hotels as $key => $hotel){
                $hotel_data[$key]['hotel_id'] = $key;
                $hotel_data[$key]['hotel_name'] = $hotel['name'];
                $hotel_data[$key]['new'] = isset($hotel_new_fans[$key])? $hotel_new_fans[$key]['total'] : 0;
                $hotel_data[$key]['self'] = isset($hotel_self_fans[$key])? $hotel_self_fans[$key]['total'] : 0;
                $hotel_data[$key]['dis'] = isset($dis_hotel_fans[$key])? $dis_hotel_fans[$key]['total'] : 0;
                $hotel_data[$key]['scan'] = isset($scan_hotel_fans[$key])? $scan_hotel_fans[$key]['total'] : 0;
                $hotel_data[$key]['cancel'] = isset($hotel_cancel_fans[$key])? $hotel_cancel_fans[$key]['total'] : 0;
            }
        }

        $data['hotel_data'] = $hotel_data;
        $data['date_data'] = $each_day;

        if($o_total !=0 && $data['new_total'] !='0'){
            $data['percentage'] = ($data['new_total'] - $o_total)/$o_total*100;
        }


        $this->out_put_msg(1,'',$data,'report/fans/fans_report',200);

    }


    public function hotel_detail_data(){

        $data = $this->common_data;
        $this->load->model("wx/Fans_model");
        $inter_id = $this->inter_id;

        $params['startdate'] = '2017-08-01';
        $params['enddate'] = '2017-08-12';

        $this->Fans_model->dept_fans($inter_id,$params);

    }


    public function ext_date_data(){

        $data = $this->common_data;
        $this->load->model("wx/Fans_model");
        $this->load->model ( 'plugins/Excel_model');
        $params = array();
        $data['new_total'] = 0;
        $data['self_total'] = 0;
        $data['scan_total'] = 0;
        $data['dis_total'] = 0;
        $data['cancel_total'] = 0;
        $data['date_data'] = array();
        $data['hotel_data'] = array();

        $post = json_decode($this->input->raw_input_stream,true);
        if(isset($post['hotel_id']))$params['hotel_id'] = $post['hotel_id'];


        if(!isset($post['startdate']) || !isset($post['enddate'])){
            $post['startdate'] = '2017-08-01';
            $post['enddate'] = '2017-08-12';
        }

        $params['startdate'] = $post['startdate'];
        $params['enddate'] = $post['enddate'];


        $dt_start = strtotime($params['startdate']);
        $dt_end = strtotime($params['enddate']);
        while ($dt_start<=$dt_end){
            $each_day[date('Y-m-d',$dt_start)] = array('date'=>date('Y-m-d',$dt_start));
            $dt_start = strtotime('+1 day',$dt_start);
        }

        $params['cur_status'] = 1;

        $date_new_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'date');  //按日期统计新增
        $date_self_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'date',-1);  //按日期统计自主关注
        $dis_date_fans = $this->Fans_model->dis_fans($this->inter_id,$params,'date');   //按日期统计分销
        $scan_date_fans = $this->Fans_model->dis_fans($this->inter_id,$params,'date',2);   //按日期统计扫码关注

        $params['cur_status'] = 2;
        $date_cancel_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'date');  //按日期统计取消

        if(!empty($each_day)){
            foreach($each_day as $key => $e_day){
                $each_day[$key]['new'] = isset($date_new_fans[$key])? $date_new_fans[$key]['total'] : 0;
                $each_day[$key]['self'] = isset($date_self_fans[$key])? $date_self_fans[$key]['total'] : 0;
                $each_day[$key]['dis'] = isset($dis_date_fans[$key])? $dis_date_fans[$key]['total'] : 0;
                $each_day[$key]['scan'] = isset($scan_date_fans[$key])? $scan_date_fans[$key]['total'] : 0;
                $each_day[$key]['cancel'] = isset($date_cancel_fans[$key])? $date_cancel_fans[$key]['total'] : 0;
            }
        }


        $head = array ('时间','新增粉丝','自主关注','扫码关注','分销关注','取消关注');

        $ext_data = array();

        if(!empty($each_day)){
            foreach($each_day as $key=>$item){
                $temp[0]=$key;
                $temp[1]=$item['new'];
                $temp[2]=$item['self'];
                $temp[3]=$item['dis'];
                $temp[4]=$item['scan'];
                $temp[5]=$item['cancel'];
                $ext_data[]=$temp;
            }

        }

        $ext_date = date('Y-m-d',time());

        $filename='';

        $filename = $filename.'每日粉丝明细_'.$ext_date;

        $this->Excel_model->exp_exl($head,$ext_data,$filename);

    }


    public function ext_hotel_data(){

        $data = $this->common_data;
        $this->load->model("wx/Fans_model");
        $this->load->model("hotel/Hotel_model");
        $this->load->model ( 'plugins/Excel_model');
        $hotels = $this->Hotel_model->get_all_hotels($this->inter_id,null,'key');
        $params = array();
        $data['new_total'] = 0;
        $data['self_total'] = 0;
        $data['scan_total'] = 0;
        $data['dis_total'] = 0;
        $data['cancel_total'] = 0;
        $data['hotel_data'] = array();

        $post = json_decode($this->input->raw_input_stream,true);

        if(isset($post['hotel_id']))$params['hotel_id'] = $post['hotel_id'];

        if(!isset($post['startdate']) || !isset($post['enddate'])){
            $post['startdate'] = '2017-08-01';
            $post['enddate'] = '2017-08-12';
        }

        $params['startdate'] = $post['startdate'];
        $params['enddate'] = $post['enddate'];

        $params['cur_status'] = 1;
        $hotel_new_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'hotel');//按酒店统计新增
        $hotel_self_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'hotel',-1);  //按酒店统计自主关注
        $dis_hotel_fans = $this->Fans_model->dis_fans($this->inter_id,$params,'hotel');   //按酒店统计分销
        $scan_hotel_fans = $this->Fans_model->dis_fans($this->inter_id,$params,'hotel',2);   //按酒店统计扫码关注
        $params['cur_status'] = 2;
        $hotel_cancel_fans = $this->Fans_model->count_con_fans($this->inter_id,$params,'hotel');//按酒店统计取消


        if(!empty($hotels)){
            $hotel_data = array(
                -1 => array(
                    'hotel_id' => -1,
                    'hotel_name' => '无'
                )
            );
            $hotel_data[-1]['new'] = isset($hotel_new_fans[-1])? $hotel_new_fans[-1]['total'] : 0;
            $hotel_data[-1]['self'] = isset($hotel_self_fans[-1])? $hotel_self_fans[-1]['total'] : 0;
            $hotel_data[-1]['dis'] = isset($dis_hotel_fans[-1])? $dis_hotel_fans[-1]['total'] : 0;
            $hotel_data[-1]['scan'] = isset($scan_hotel_fans[-1])? $scan_hotel_fans[-1]['total'] : 0;
            $hotel_data[-1]['cancel'] = isset($hotel_cancel_fans[-1])? $hotel_cancel_fans[-1]['total'] : 0;
            foreach($hotels as $key => $hotel){
                $hotel_data[$key]['hotel_id'] = $key;
                $hotel_data[$key]['hotel_name'] = $hotel['name'];
                $hotel_data[$key]['new'] = isset($hotel_new_fans[$key])? $hotel_new_fans[$key]['total'] : 0;
                $hotel_data[$key]['self'] = isset($hotel_self_fans[$key])? $hotel_self_fans[$key]['total'] : 0;
                $hotel_data[$key]['dis'] = isset($dis_hotel_fans[$key])? $dis_hotel_fans[$key]['total'] : 0;
                $hotel_data[$key]['scan'] = isset($scan_hotel_fans[$key])? $scan_hotel_fans[$key]['total'] : 0;
                $hotel_data[$key]['cancel'] = isset($hotel_cancel_fans[$key])? $hotel_cancel_fans[$key]['total'] : 0;
            }
        }


        $head = array ('所属酒店','新增粉丝','自主关注','扫码关注','分销关注','取消关注');

        $ext_data = array();

        if(!empty($hotel_data)){
            foreach($hotel_data as $key=>$item){
                $temp[0]=$item['hotel_name'];
                $temp[1]=$item['new'];
                $temp[2]=$item['self'];
                $temp[3]=$item['dis'];
                $temp[4]=$item['scan'];
                $temp[5]=$item['cancel'];
                $ext_data[]=$temp;
            }

        }

        $ext_date = date('Y-m-d',time());

        $filename='';

        $filename = $filename.'酒店发展粉丝统计_'.$ext_date;

        $this->Excel_model->exp_exl($head,$ext_data,$filename);


    }

}
