<?php

class Daisi extends MY_Controller{

//	private $inter_id = '';
	private $inter_id = '';
	private $cfg;

	public function __construct(){
		parent::__construct();
		$this->load->helper('common');
		//测试专用
		$this->cfg = array(
			'inter_id'      => $this->inter_id,
			'url'           => 'http://114.104.156.246:6565/kws35/',
			'user'          => 'WXKWS',
			'pwd'           => '8888',
			'channel_code'  => 'WC',
			'market_code'   => '',
			'source_code'   => '',
		    'reserv_type'=>[
		    	'no_pay'=>'6PM',
		        'paid'=>'GPP'
		    ],
		 
		);
		$this->cfg['inter_id']=$this->inter_id;
		$this->load->library('Baseapi/Shijiapi', $this->cfg, 'serv_api');
	}
}