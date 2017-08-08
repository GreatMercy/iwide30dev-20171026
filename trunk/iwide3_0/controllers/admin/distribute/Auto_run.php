<?php

class Auto_run extends CI_Controller{
	
	public function index(){
		echo 'arrival';
	}
	
	/**
	 * 自动发放绩效
	 */
	public function auto_deliver(){
		
		$this->load->model('distribute/grades_model');
		$this->load->model('distribute/distribute_model');
		
		//取所有待发放的分销员
		$salers = $this->distribute_model->get_auto_deliver_salers();
		foreach ($salers as $saler){
			$this->distribute_model->send_grades_by_saler($saler->inter_id,$saler->saler);
		}
		
		//更新最后发放时间
		$this->distribute_model->update_last_deliver_time();
		echo 'success';
	}
	
	private function gen_order_no()
	{
		$date_code= array(
				'0','1','2','3','4','5','6','7','8','9',
				'A','C','D','E','F','G','H','J','K',
				'M','N','P','Q','R','T','U','V','W','X','Y','Z','S');
		//eg: C 15 X 94737 74906 00
		return strtoupper( dechex(date('m'))). date('y'). $date_code[intval(date('d'))]
		. substr(time(),-5). substr(microtime(),2,5) .sprintf('%02d',rand(0,99));
	}
	
	public function auto_grade(){
		$this->load->model('distribute/grade_model');
		$query = $this->grade_model->get_grade_queue();
		foreach ($query as $item){
			
		}
	}
}