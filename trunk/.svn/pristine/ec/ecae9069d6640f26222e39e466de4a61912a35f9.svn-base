<?php

class Auto_run extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		if(isset($_GET['debug'])){
			$this->output->enable_profiler(true);
		}
	}
	
	public function index(){
		echo 'arrival';
	}
	
	/**
	 * 自动发放绩效
	 */
	public function auto_deliver(){
		$cookie_jar = dirname(__FILE__)."/auto_deliver.cookie";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, site_url('distribute/auto_run/do_deliver'));
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
		$result=curl_exec($ch);
		echo $result;
		curl_close($ch);
	}
	
	/**
	 * 生产-自动发放绩效 
	 */
	public function deliver_product(){
		
		$cookie_jar = dirname(__FILE__)."/deliver_product.cookie";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://jfk.iwide.cn/index.php/distribute/auto_run/do_deliver');
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
		$result=curl_exec($ch);
		echo $result;
		curl_close($ch);
		
	}
	
	private function gen_order_no(){
		$date_code= array(
				'0','1','2','3','4','5','6','7','8','9',
				'A','C','D','E','F','G','H','J','K',
				'M','N','P','Q','R','T','U','V','W','X','Y','Z','S');
		//eg: C 15 X 94737 74906 00
		return strtoupper( dechex(date('m'))). date('y'). $date_code[intval(date('d'))]
		. substr(time(),-5). substr(microtime(),2,5) .sprintf('%02d',rand(0,99));
	}

	public function auto_grade(){
		set_time_limit ( 55 );
		$this->load->model('distribute/grades_model');
		$query = $this->grades_model->deal_queue();
		// foreach ($query as $item){
		// 	$this->grades_model->_create_grade($item->rec_content,$item->id);

		// }
		echo 'success';exit;
	}
	
	public function do_deliver(){
		
		log_message('error', date('Y-m-d H:i:s').' : '.microtime(TRUE).' 开始查询分销绩效信息...');
		
		set_time_limit ( 55 );
		$this->load->model('distribute/grades_model');
		$this->load->model('distribute/distribute_model');
		
		//取所有待发放的分销员
		$salers = $this->distribute_model->get_auto_deliver_salers();
		$batch_no = $this->gen_order_no();
		$saler_arr = $auto_deliver_salers = array();
		if($this->session->userdata('_auto_deliver_salers')){
			$auto_deliver_salers = $this->session->userdata('_auto_deliver_salers');
			log_message('error', date('Y-m-d H:i:s').' : '.microtime(TRUE).' HAS_SESSION_DATA:_auto_deliver_salers->'.json_encode($this->session->userdata()));
			if($auto_deliver_salers['date'] == date('Ymd')){
				$saler_arr = $auto_deliver_salers['salers'];
			}else{
				$auto_deliver_salers['salers'] = $saler_arr;
				$auto_deliver_salers['date']   = date('Ymd');
				$this->session->set_userdata('_auto_deliver_salers',$auto_deliver_salers);
			}
		}else{
			$auto_deliver_salers['salers'] = $saler_arr;
			$auto_deliver_salers['date']   = date('Ymd');
			$this->session->set_userdata('_auto_deliver_salers',$auto_deliver_salers);
		}
		foreach ($salers as $saler){
			if(!in_array($saler->inter_id.$saler->saler,$saler_arr)){
				$saler_arr[] = $saler->inter_id.$saler->saler;
				
				$auto_deliver_salers['salers'] = $saler_arr;
				$this->session->set_userdata('_auto_deliver_salers',$auto_deliver_salers);
				
				if($this->session->userdata($saler->inter_id.'auto')){
					$auto_config = $this->session->userdata($saler->inter_id.'auto');
					if($auto_config['date'] == date('Y-m-d')){
						$batch_no = $auto_config['batch_no'];
					}else{
						$this->session->set_userdata(array($this->inter_id.'auto'=>array('batch_no'=>$batch_no,'date'=>date('Y-m-d'))));
					}
				}else{
					$this->session->set_userdata(array($this->inter_id.'auto'=>array('batch_no'=>$batch_no,'date'=>date('Y-m-d'))));
				}
				$this->distribute_model->send_grades_by_saler_yestoday($saler->inter_id,$saler->saler,$batch_no);
			}
		}
		log_message('error', date('Y-m-d H:i:s').' : '.microtime(TRUE).' 分销绩效发放结束...');
		
		//更新最后发放时间
		$this->distribute_model->update_last_deliver_time();
		echo 'success';
		
	}
}