<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Hotel_fans extends MY_Admin {
    protected $label_controller = '粉丝管理';
    protected $label_action = '';
    protected $common_data = array ();
    function __construct() {
        parent::__construct ();
        $this->inter_id = $this->session->get_admin_inter_id ();
        $this->module = 'hotel';
        $this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
        $this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
        $this->common_data ['inter_id'] = $this->inter_id;
        // $this->output->enable_profiler ( true );
    }

	public function main_model_name()
	{
		return 'hotel/Hotel_fans';
	}

    public function fans_admin(){

        $data = $this->common_data;

        $this->load->model ( 'wx/Fans_model' );
        $this->load->model ( 'hotel/Hotel_model' );

        $fans = $this->Fans_model->count_all_fans($this->inter_id);

        $this->load->helper ( 'common' );
        $this->load->model ( 'wx/Access_token_model' );
        $access_token = $this->Access_token_model->get_access_token ( $this->inter_id );
        $get_fans = doCurlGetRequest('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$access_token);


        $get_fans = json_decode($get_fans);

        $today = strtotime(date("Y-m-d",time()));
        $last_day = strtotime(date("Y-m-d",time())) - 86400;

        $post_data = array(
            'begin_date'=>date("Y-m-d",time()-86400),
            'end_date'=>date("Y-m-d",time()-86400)
        );

//        $post_data = array(
//            'begin_date'=>'2016-12-02',
//            'end_date'=>'2016-12-08'
//        );

        $url = 'https://api.weixin.qq.com/datacube/getusersummary?access_token='.$access_token;

        $usersummary = json_decode(doCurlPostRequest($url,json_encode($post_data)));

        print_r($usersummary);exit;

        $data['new_fans'] = 0;
        $data['cancel_fans'] = 0;
        $data['total'] = 0;
        $data['self_fans'] = 0;

        $data['hotels'] =  $this->Hotel_model->get_all_hotels($this->inter_id);
        $hotel_count = array();

        if(!empty($fans) && isset($get_fans->total)){
            $data['total'] = $get_fans->total;
            foreach($fans as $fan){

                if(!empty($fan['hotel_id'])){

                    if(!isset($hotel_count[$fan['hotel_id']])){
                        $hotel_count[$fan['hotel_id']]['total'] = 1;
                        $hotel_count[$fan['hotel_id']]['cancel'] = 0;
                        $hotel_count[$fan['hotel_id']]['saler'] = 0;
                        $hotel_count[$fan['hotel_id']]['scene'] = 0;
                    }else{
                        $hotel_count[$fan['hotel_id']]['total'] = $hotel_count[$fan['hotel_id']]['total'] + 1 ;
                    }

                }

                if(strtotime($fan['event_time']) > $last_day && strtotime($fan['event_time']) < $today){
                    if($fan['event']==2){
                        $data['new_fans'] = $data['new_fans'] + 1;
                    }elseif($fan['event']==1){
                        $data['cancel_fans'] = $data['cancel_fans'] + 1;
                        if(!empty($fan['hotel_id'])){
                            $hotel_count[$fan['hotel_id']]['cancel'] = $hotel_count[$fan['hotel_id']]['cancel'] + 1;
                        }
                    }
                }


                if($fan['source']<0){
                    $data['self_fans'] = $data['self_fans'] + 1;
                }else{
                    if(!empty($fan['hotel_id'])){
                        if($fan['is_distributed']==1){
                            $hotel_count[$fan['hotel_id']]['saler'] = $hotel_count[$fan['hotel_id']]['saler'] + 1;
                        }else{
                            $hotel_count[$fan['hotel_id']]['scene'] = $hotel_count[$fan['hotel_id']]['scene'] + 1;
                        }
                    }
                }

            }
        }

        $data['hotel_count'] = $hotel_count;


        $html= $this->_render_content($this->_load_view_file('fans_admin'), $data, false);

        echo $html;

    }



}
