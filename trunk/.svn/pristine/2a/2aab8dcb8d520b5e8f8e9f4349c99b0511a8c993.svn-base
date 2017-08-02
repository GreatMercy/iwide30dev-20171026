<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Focus extends MY_Admin {
	protected $label_module = NAV_HOTEL;
	protected $label_controller = '焦点图设置';
	protected $label_action = '';
	function __construct() {
		parent::__construct ();
		$this->inter_id = $this->session->get_admin_inter_id ();
		$this->module = 'hotel_2';
		// $this->output->enable_profiler ( true );
	}
	protected function main_model_name() {
		return 'hotel/hotel_ext_model';
	}
	public function index()
	{
		$this->label_action = '集团轮播图管理';
		$this->_init_breadcrumb ( $this->label_action );

		$this->load->model ( 'wx/publics_model' );
		$datas = $this->publics_model->get_pub_imgs($this->session->get_admin_inter_id(),'hotelslide');
		$data = array('datas'=>$datas,'inter_id'=>$this->session->get_admin_inter_id());

		$html = $this->_render_content ( $this->_load_view_file ( 'index' ), $data, true );
		// $this->load->view($this->_get_template().'/index');
		echo $html;
	}
	public function index2()
	{
		$this->label_action = '集团轮播图管理';
		$this->_init_breadcrumb ( $this->label_action );

		$this->load->model ( 'wx/publics_model' );
		$datas = $this->publics_model->get_pub_imgs($this->session->get_admin_inter_id(),'hotelslide');
		$data = array('datas'=>$datas,'inter_id'=>$this->session->get_admin_inter_id());

		$html = $this->_render_content ( $this->_load_view_file ( 'index2' ), $data, true );
		// $this->load->view($this->_get_template().'/index');
		echo $html;
	}
	public function grid()
	{
	    $inter_id= $this->session->get_admin_inter_id();
	    if($inter_id== FULL_ACCESS) $filter= array();
	    else if($inter_id) $filter= array('inter_id'=>$inter_id );
	    else $filter= array('inter_id'=>'deny' );
	    //print_r($filter);die;
	    
	    $this->_grid($filter,$_POST);
	}
	
	public function save(){
		$is_success = false;
		if(empty($this->input->get('t'))){
			$this->load->model ( 'wx/publics_model' );
			$is_success = $this->publics_model->save_focus();
		}else if($this->input->get('t') == 1){
			$this->load->model ( 'hotel/hotel_ext_model' );
			$is_success = $this->hotel_ext_model->save_focus();
		}else if($this->input->get('t') == 2){
			$this->load->model ( 'hotel/rooms_model' );
			$is_success = $this->rooms_model->save_focus();
		}
		if($is_success){
			echo json_encode(array('errmsg' => 'ok'));
		}else{
			echo json_encode(array('errmsg' => 'faild'));
		}
	}
	public function del(){
		$is_success = false;
		if(empty($this->input->get('t'))){
			$this->load->model ( 'wx/publics_model' );
			$is_success = $this->publics_model->del_focus();
		}else if($this->input->get('t') == 1){
			$this->load->model ( 'hotel/hotel_ext_model' );
			$is_success = $this->hotel_ext_model->del_focus();
		}else if($this->input->get('t') == 2){
			$this->load->model ( 'hotel/rooms_model' );
			$is_success = $this->rooms_model->del_focus();
		}
		if($is_success){
			echo json_encode(array('errmsg' => 'ok'));
		}else{
			echo json_encode(array('errmsg' => 'faild'));
		}
	}

    public function update(){
        $is_success = false;
        if(empty($this->input->get('t'))){
            $this->load->model ( 'wx/publics_model' );
            $is_success = $this->publics_model->update_focus();
        }else if($this->input->get('t') == 1){
            $this->load->model ( 'hotel/hotel_ext_model' );
            $is_success = $this->hotel_ext_model->update_focus();
        }else if($this->input->get('t') == 2){
            $this->load->model ( 'hotel/rooms_model' );
            $is_success = $this->rooms_model->update_focus();
        }
        if($is_success){
            echo json_encode(array('errmsg' => 'ok'));
        }else{
            echo json_encode(array('errmsg' => 'faild'));
        }
    }


    public function hotel_focus(){

        $_GET['t']=1;

        $this->label_action = '酒店轮播图管理';
        $this->_init_breadcrumb ( $this->label_action );

        $this->load->model ( 'hotel/hotel_ext_model' );
        $datas = $this->hotel_ext_model->get_focus_s();
        $data = array('datas'=>$datas);

        $html = $this->_render_content ( $this->_load_view_file ( 'index' ), $data, true );
        // $this->load->view($this->_get_template().'/index');
        echo $html;

    }



    public function room_focus(){

        $_GET['t']=2;

        $this->label_action = '房间轮播图管理';
        $this->_init_breadcrumb ( $this->label_action );

        $this->load->model ( 'hotel/rooms_model' );
        $datas = $this->rooms_model->get_focus_s();
        $data = array('datas'=>$datas);

        $html = $this->_render_content ( $this->_load_view_file ( 'index' ), $data, true );
        // $this->load->view($this->_get_template().'/index');
        echo $html;

    }

}
