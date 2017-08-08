<?php 

class Aisino extends MY_Controller{
	function __construct(){
		parent::__construct ();
	}

	function test(){
		// $this->load->model('invoice/Aisino_invoice_model');
		$this->load->library ( 'PMS_Adapter', array (
			'inter_id' => 'a481004792',
			'hotel_id' => 0
		), 'pmsa' );
		// $res = $this->pmsa->get_next_invoice(0);
		// $res = $this->Aisino_invoice_model->get_next_invoice(0);
		// var_dump($res);
		$content = array(
			'infoKind'=>0,
			'cName'=>'测试购方名称',
			'cAddress'=>'广州市天河区天河路490号',
			'cBank'=>'工商银行',
			'cTaxCode'=>'245345345343',
			'taxRate'=>6,
			'invoicer'=>'测开票人',
			'sAddress'=>'广州市天河区天河路491号',
			'sBank'=>'建设银行',
			'details'=>array(
				'amount'=>99.99,
				'goodsName'=>'测试商品名称',
				'priceKind'=>0,
				'taxRate'=>6,
				// 'goodsNoVer'=>1.0,
				'goodsTaxNo'=>'30799',
				'taxPre'=>0,
				),
			);
		// $res1 = $this->Aisino_invoice_model->issue_invoice(0,$content);
		// $res1 = $this->pmsa->issue_invoice(0,$content);
		// var_dump($res1);
		// $res2 = $this->Aisino_invoice_model->print_invoice(0,'4400151140','00500407');
		// $res2 = $this->pmsa->print_invoice(0,'4400151139','00500412');
		// var_dump($res2);
		$res3 = $this->pmsa->cancel_invoice(0,'4400151140','00500412');
		var_dump($res3);
	}
}