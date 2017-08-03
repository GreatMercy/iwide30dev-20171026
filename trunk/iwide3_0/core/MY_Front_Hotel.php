<?php
class MY_Front_Hotel extends MY_Front {
	public $inter_id;
	public $public;
	public $my_saler_id;//分销员id
	public $my_f_saler_id;//泛分销员id
	public $member_info;
	public function __construct() {
		parent::__construct ();
		if (empty ( $this->public )) {
			$this->load->model ( 'wx/Publics_model' );
			$this->public = $this->Publics_model->get_public_by_id ( $this->inter_id );
		}
		require_once APPPATH . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "Hotel" . DIRECTORY_SEPARATOR . "Hotel_base.php";
		require_once APPPATH . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "Hotel" . DIRECTORY_SEPARATOR . "Hotel_const.php";

		$this->my_saler_id = $this->session->userdata ( $this->inter_id . $this->openid . '_h_saler' );
		$this->my_f_saler_id = $this->session->userdata ( $this->inter_id . $this->openid . '_h_f_saler' );
		if (! isset ( $this->my_saler_id ) && ! isset ( $this->my_f_saler_id )) {
			$this->load->model ( 'hotel/user/User_info_model' );
			$self_saler = $this->User_info_model->get_saler_info ( $this->inter_id, $this->openid );
			if ($self_saler && isset( $self_saler ['my_saler_id'] ) && isset( $self_saler ['my_f_saler_id'] )) {
				$this->my_saler_id = $self_saler ['my_saler_id'];
				$this->my_f_saler_id = $self_saler ['my_f_saler_id'];
			} else {
				$this->my_saler_id = 0;
				$this->my_f_saler_id = 0;
			}
			$this->session->set_userdata ( $this->inter_id . $this->openid . '_h_saler', $this->my_saler_id );
			$this->session->set_userdata ( $this->inter_id . $this->openid . '_h_f_saler', $this->my_f_saler_id );
		}
		if (! empty ( $this->my_saler_id )) {
			Hotel_base::$_basic_param ['own_saler'] = $this->my_saler_id;
		}
		if (! empty ( $this->my_f_saler_id )) {
			Hotel_base::$_basic_param ['own_f_saler'] = $this->my_f_saler_id;
		}
		$this->url_param = Hotel_base::inst ()->url_param ();
		$seg = $this->module . '/' . $this->controller . '/' . $this->action;
		$not_default=array(
				'a429262687',
				'a449664652',
				'a451037398',
				'a455510007',
				'a456970175',
				'a457062971',
				'a457946152',
				'a464177542',
				'a467780350',
				'a483407432'
		);
		if (! empty ( Hotel_base::$_basic_param ['saler_redirect'] ) && Hotel_const::enums ( 'saler_redirect_url', NULL, $seg ) && !in_array($this->inter_id, $not_default)) {
			redirect ( Hotel_base::inst ()->get_url ( $seg, $this->input->get () ) );
		}
		$this->link_saler_id=intval($this->input->get('lsaler'));
		$this->ori_saler_id=intval($this->input->get('osaler'));
		$this->link_f_saler_id=intval($this->input->get('lfsaler'));
		$this->ori_f_saler_id=intval($this->input->get('ofsaler'));
		
		if ( Hotel_const::enums ( 'query_member_controller', NULL, $this->controller ) ) {
		    $member_session_key=$this->inter_id . $this->openid . '_memberinfo';
		    if ( Hotel_const::enums ( 'fresh_memberinfo_url', NULL, $seg ) ) {
		        $this->member_info = $this->get_member_info();
		        empty($this->member_info->mem_id) or $this->session->set_userdata ( $member_session_key,json_encode($this->member_info));
		    }else{
		        $this->member_info = $this->session->userdata ( $member_session_key);
		        $this->member_info=json_decode( $this->member_info);
		        $cur_login_status = $this->session->userdata ($this->inter_id . $this->openid . '_logined');
		        if (empty($this->member_info) || (isset($cur_login_status) && $cur_login_status != $this->member_info->logined)){
		            $this->member_info = $this->get_member_info();
		            empty($this->member_info->mem_id) or $this->session->set_userdata ( $member_session_key,json_encode($this->member_info));
		        }
		    }
		}
	}
	public function get_member_info(){
	    $this->load->library ( 'PMS_Adapter', array (
	            'inter_id' => $this->inter_id,
	            'hotel_id' => 0
	    ), 'pub_pmsa' );
	    $member = $this->pub_pmsa->check_openid_member ( $this->inter_id, $this->openid, array (
	            'create' => TRUE,
	            'update' => TRUE
	    ) );
	    if (! empty ( $member ) && isset ( $member->mem_id )) {
	        return $member;
	    }else {
	        $member = new stdClass();
	        return $member;
	    }
	}
	function display($paras, $data, $skin = '', $extra_views = array(), $return = false) {
		if ($this->session->userdata ( $this->inter_id . 'skin' )) {
			$skin = $this->session->userdata ( $this->inter_id . 'skin' );
		}

		if (empty ( $extra_views ['module_view'] )) {
			$extra_views ['module_view'] = $this->get_display_view ( $paras );
		}
		if ($return == TRUE)
			return parent::display ( $paras, $data, $skin, $extra_views, $return );
			parent::display ( $paras, $data, $skin, $extra_views, $return );
	}
	function get_display_view($paras) {
		$view = parent::get_display_view ( $paras );
		if (empty ( $view )) {
			$view = array (
					'skin_name' => isset ( $this->default_skin ) ? $this->default_skin : 'default',
					'overall_style' => '',
					'extra_style' => NULL,
					'view_subfix' => NULL,
					'extra_preview' => NULL,
					'extra_subview' => NULL
			);
		}
		return $view;
	}

	/**
	 * 返回皮肤特有配置，用于判断当前所用皮肤有某配置时才进行特定操作
	 *
	 * @param unknown $skin_name
	 * @param unknown $fun
	 */
	function get_skin_config($skin_name, $fun) {
		$config = array (
				'default2' => array (
						'hotel/sresult' => array (
								'no_hotel_list' => 1
						),
                        'hotel/search' => array (
                            'show_area' => 1
                        )
				),
				'junting' => array (
						'hotel/search' => array (
								'fans_info' => 1
						),
						'hotel/sresult' => array (
								'no_hotel_list' => 1
						)
				),
				'bigger' => array (
						'hotel/sresult' => array (
								'no_hotel_list' => 1
						),
                        'hotel/hotel_photo'=>array(
                            'all_photo' => 1
                        )
				)
		);
		return empty ( $config [$skin_name] [$fun] ) ? array () : $config [$skin_name] [$fun];
	}
}
