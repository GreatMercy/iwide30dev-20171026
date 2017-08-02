<?php
class User_info_model extends MY_Model {
	function __construct() {
		parent::__construct ();
	}
	function get_saler_info($inter_id, $openid ) {

		$this->load->model ( 'distribute/Idistribute_model' );
		$saler_info = $this->Idistribute_model->fans_is_saler ( $inter_id, $openid, false );

		if ($saler_info && ! empty ( $saler_info ['info'] )) {
			if($saler_info['typ'] == 'STAFF'){
				if(empty($saler_info ['info'] ['saler'])){
					$my_saler_id = 0;
				}else{
					$my_saler_id = $saler_info ['info'] ['saler'];
				}
				$my_f_saler_id = 0;
			}elseif($saler_info['typ'] == 'FANS'){
				$my_saler_id = 0;
				$my_f_saler_id = $saler_info ['info'] ->saler;
				if(is_object($saler_info ['info'])){
					$saler_info ['info'] =  (array) $saler_info['info'];
				}
			}else{
				return NULL;
			}
		} else {
			return NULL;
		}
		$saler_info['my_saler_id'] = $my_saler_id;
		$saler_info['my_f_saler_id'] = $my_f_saler_id;
		return $saler_info;
	}
}