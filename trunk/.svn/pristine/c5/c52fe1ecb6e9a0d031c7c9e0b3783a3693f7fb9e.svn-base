<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Comment extends MY_Admin {
	protected $label_module = NAV_HOTEL;
	protected $label_controller = '酒店评论';
	protected $label_action = '';
	function __construct() {
		parent::__construct ();
		$this->inter_id = $this->session->get_admin_inter_id ();
		$this->module = 'hotel_2';
		$this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
		$this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
		// $this->output->enable_profiler ( true );
	}
	protected function main_model_name() {
		return 'hotel/Comment_model';
	}
	public function index() {
		$data = $this->common_data;
		$model = $this->_load_model ( $this->main_model_name () );
		$data ['hotel_id'] = $this->input->get_post ( 'hotel' );
		$data ['room_id'] = $this->input->get_post ( 'r' );
		$this->load->model ( 'hotel/hotel_model' );
		// $data ['hotels'] = $this->hotel_model->get_all_hotels ( $this->inter_id );
		
		$entity_id = $this->session->get_admin_hotels ();
		if (! empty ( $entity_id )) {
			$hotel_ids = explode ( ',', $entity_id );
			if (! empty ( $data ['hotel_id'] ) && ! in_array ( $data ['hotel_id'], $hotel_ids )) {
				$data ['hotel_id'] = 0;
			}
			$data ['hotels'] = $this->hotel_model->get_hotel_by_ids ( $this->inter_id, $entity_id );
		} else
			$data ['hotels'] = $this->hotel_model->get_all_hotels ( $this->inter_id );
		
		$data ['fields_config'] = $model->grid_fields ();
		if (! empty ( $data ['hotel_id'] )) {
			$list = $model->get_hotel_comments ( $this->inter_id, $data ['hotel_id'], null, '' );
			$this->load->model ( 'common/Enum_model' );
			$status_des = $this->Enum_model->get_enum_des ( array (
					'HOTEL_COMMENT_STATUS' 
			) );
			foreach ( $list as $k => $d ) {
				$list [$k] ['disp_status'] = $status_des ['HOTEL_COMMENT_STATUS'] [$d ['status']];
				$list [$k] ['comment_time'] = date ( 'Y-m-d H:i:s', $d ['comment_time'] );
				$list [$k] ['hotel_name'] = empty ( $d ['order_info'] ['hotel_name'] ) ? '' : $d ['order_info'] ['hotel_name'];
				$list [$k] ['room_name'] = empty ( $d ['order_info'] ['room_name'] ) ? '' : $d ['order_info'] ['room_name'];
			}
			$data ['list'] = $list;
		} else {
			$data ['hotel_id'] = empty ( $data ['hotels'] [0] ) ? 0 : $data ['hotels'] [0] ['hotel_id'];
		}
		$this->_render_content ( $this->_load_view_file ( 'index' ), $data, false );
	}
	public function change_comment_status() {
		$hotel_id = $this->input->get ( 'hid' );
		$comment_id = $this->input->get ( 'comment_id' );
		$status = intval ( $this->input->get ( 'status' ) );
		$status = $status == 1 ? 2 : 1;
		$model = $this->_load_model ( $this->main_model_name () );
		$result = $model->change_comment_status ( $this->inter_id, $comment_id, $status, $hotel_id );
		if ($result){
            $comment=$model->get_comment_by_id($this->inter_id, $comment_id, $status, $hotel_id);

            $data['score']=$comment['score'];
            $data['facilities_score']=$comment['facilities_score'];
            $data['clean_score']=$comment['clean_score'];
            $data['service_score']=$comment['service_score'];
            $data['net_score']=$comment['net_score'];

            if(isset($comment['images'])){
                $data['images']=$comment['images'];
            }

            if($status==1){
                $action='add';
            }else{
                $action = 'del';
            }

            $model->update_hotel_score_from_redis($this->inter_id,$hotel_id,$data,$action);
			echo $status;
        }else{
			echo 0;
        }
	}






    public function comment_settings(){    //获取酒店关键词

        $data = $this->common_data;
        $model = $this->_load_model ( $this->main_model_name () );

        $inter_id = $this->session->get_admin_inter_id ();
        $entity_id = $this->session->get_admin_hotels ();

        $data['list'] = $model->get_keyword($inter_id);

        $data['type']=$model->get_comment_show_type($inter_id);

//        if ($inter_id == FULL_ACCESS){
//            exit;
//        }else{
//            $list = $model->get_keyword($inter_id);
//        }

        $data['logs']=$model->get_keyword_log($this->inter_id);

        $data['log_des'] = $model->hotel_log_des();

        $this->_render_content ( $this->_load_view_file ( 'keyword' ), $data, false );

    }


    public function keyword_post(){   //添加关键词

        $model = $this->_load_model ( $this->main_model_name () );
        $inter_id = $this->session->get_admin_inter_id ();

        $keyword = $this->input->get('keyword');

        $content=$model->get_comment_content($inter_id);

        if($content){

            $count = json_encode($model->match_keyword($keyword,$content));

        }

        $result = $model->new_keyword($inter_id,$keyword,$count);

        if($result){

            $content=$model->get_comment_content($inter_id);

            if($content){

                $count = $model->match_keyword($keyword,$content);

            }
            $this->load->model('hotel/Hotel_log_model');
            $this->Hotel_log_model->add_admin_log('hotel_comment_keyword#'.$result,'add',$keyword);
        }

        echo json_encode($result);

    }


    public function del_keyword(){   //删除关键词

        $inter_id = $this->session->get_admin_inter_id ();
        $keyword_id = $this->input->get('keyword_id');

        $model = $this->_load_model ( $this->main_model_name () );

        $result = $model->update_keyword($inter_id,$keyword_id);

        if($result){

            $keyword=$model->get_keyword_by_id($inter_id,$keyword_id);
            $this->load->model('hotel/Hotel_log_model');
            $this->Hotel_log_model->add_admin_log('hotel_comment_keyword#'.$keyword_id,'del',$keyword['keyword']);

        }

        echo json_encode($result);

    }



    function get_comment(){    //获取酒店评论

        $data = $this->common_data;
        $model = $this->_load_model ( $this->main_model_name () );
        $inter_id = $this->session->get_admin_inter_id ();

        $this->load->model ( 'hotel/Hotel_model');

        $data['hotel']=$this->Hotel_model->get_all_hotels($inter_id,1);



        $condition = $this->input->get();

        $idents=array();

        if($condition){
            foreach($condition['data'] as $arr){
                $idents[$arr['name']]=$arr['val'];
            }
        }


        $data['comment'] = $model->get_comments($inter_id,$idents);

        if(!empty($idents['hotel_id'])){
            $data['score_count'] = json_decode($model->get_hotel_score_from_redis($inter_id,$idents['hotel_id']));
        }


        if($condition){

            if($data['comment']['list']){
                foreach($data['comment']['list'] as $key=>$arr){
                    $info = json_decode($arr['order_info']);
                    $data['comment']['list'][$key]['comment_time']=date('Y-m-d H:i:s',$arr['comment_time']);
                    $data['comment']['list'][$key]['hotel_name']=$info->hotel_name;
                    $data['comment']['list'][$key]['room_name']=$info->room_name;
                }
            }

            if(isset($data['score_count'])){
                $data['score_count']->score = round($data['score_count']->score,1);
                $data['score_count']->facilities_score = round($data['score_count']->facilities_score,1);
                $data['score_count']->clean_score = round($data['score_count']->clean_score,1);
                $data['score_count']->service_score = round($data['score_count']->service_score,1);
                $data['score_count']->net_score = round($data['score_count']->net_score,1);
            }else{
                $data['score_count']['score'] = 0;
                $data['score_count']['facilities_score']  = 0;
                $data['score_count']['clean_score']  = 0;
                $data['score_count']['service_score']  = 0;
                $data['score_count']['net_score']  = 0;
                json_encode($data['score_count']);
            }


            echo json_encode($data);

        }else{
            $data['score_count']['score'] = 0;
            $data['score_count']['facilities_score']  = 0;
            $data['score_count']['clean_score']  = 0;
            $data['score_count']['service_score']  = 0;
            $data['score_count']['net_score']  = 0;
            json_encode($data['score_count']);

            $this->_render_content ( $this->_load_view_file ( 'comment_list' ), $data, false );
        }

    }


    function hotel_new_feedback(){        //酒店新的回复

        $this->load->model ( 'hotel/Comment_model');

        $inter_id = $this->session->get_admin_inter_id ();

        $data = $condition = $this->input->get();

        $result = $this->Comment_model->new_feedback($inter_id,$data);

        if($result){

            $this->Comment_model->change_comment_feedback($inter_id,$data['comment_id'],1);

        }

        echo json_encode($result);

    }


//    function match_keyword(){    //测试
//
//        $model = $this->_load_model ( $this->main_model_name () );
//        $inter_id = $this->session->get_admin_inter_id ();
//
//        $keyword = '舒服';
//
//        $content=$model->get_comment_content($inter_id);
//
//        if($content){
//
//            $count = $model->match_keyword($keyword,$content);
//
//        }

//    }


}
