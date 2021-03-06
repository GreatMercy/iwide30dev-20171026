<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MY_Front_Soma {

	public  $themeConfig;
    public  $theme = 'default';

    public function __construct(){

        parent::__construct();
        //theme
        $this->load->model('soma/Theme_config_model');
        $this->themeConfig = $themeConfig = $this->Theme_config_model->get_using_theme($this->inter_id);
        $this->theme = $themeConfig['theme_path'];
    }

    public function index() {
    	
    	// 需求不明，隐藏按钮，by FengZhongcheng 2016-07-25 18:16:53
        // return ;
    	
    	$this->show_invoice();
    }

    /**
     * 根据order_id加载order，如果order为空，则返回列表页面
     *
     * 根据order表检索invoice。
     * 
     * 没有invoice，不操作
     * 
     * 已有invoice
     * 根据invoice_id加载invoice
     * 检查invoice里面的address_id,加载address信息
     *
     * 组装数据：
     * order:product,price
     * invoice:title,contact,phone
     * address:provice,city,region
     * citys_url
     * region_url
     * 
     * @return [type] [description]
     */
	public function show_invoice() {

		// 需求不明，隐藏按钮，by FengZhongcheng 2016-07-25 18:16:53
        // return ;

        $this->theme = 'v1';

		$inter_id = $this->inter_id;
		$openid = $this->openid;
		$order_list = Soma_const_url::inst()
			->get_url('*/order/my_order_list', array('id' => $inter_id));

		$order_id = intval($this->input->get('oid', true));
		$this->load->model('soma/Sales_order_model', 'o_model');
		$order = $this->o_model->load($order_id);

		if(!$order) { redirect($order_list); } 

		// 底层使用->获取信息为空，兼容代码
		$order->business = $order->m_get('business');
		// 获取$order信息
		$order_items = $order->get_order_items($order->business, $inter_id);

		// 双语化翻译
		if($this->langDir == self::LANG_DIR_EN)
		{
			foreach($order_items as $key => $item)
			{
				if(!empty($item['name_en']))
				{
					$order_items[$key]['name'] = $item['name_en'];
				}
			}
		}

		$item_names = array();
		foreach ($order_items as $item) {
			$item_names[] = $item['name'];
		}

		$this->load->model('soma/Cms_region_model','r_model');
		$this->load->model('soma/Sales_invoice_model', 'i_model');
		$this->load->model('soma/Customer_address_model', 'a_model');

		// 初始化省市区地址为空,城市列表、区域列表为空，省列表从a_model获取
		$provinces = $this->r_model->get_provinces($inter_id);
		$province = $city = $region = '';
		$citys = $regions = array();
		$address = null;

		$find_res = $this->i_model->find(array('order_id' => $order_id));
		
		if(is_array($find_res) && count($find_res) > 0) {
			// 如果订单有发票信息，加载发票信息，地址信息
			$invoice = $this->i_model->load($find_res['invoice_id']);
			$address = $this->a_model->load($invoice->m_get('address_id'));
		} else {
			// 没有发票信息，加载订单地址
			$filter['openid'] = $openid;;
			$filter['inter_id'] = $inter_id;	
			$limit = 1;//取出一条地址信息
			$address_info = $this->a_model->get_addresses( $openid, $filter, $limit );
			if(count($address_info) > 0) {
				$address = $this->a_model->load($address_info[0]['address_id']);
			}
		}
		
		if($address) {
			// 加载地址成功，显示地址信息
			$provinces_detail = $this->r_model->get_region_detail( $address->m_get('province') , $inter_id );
			$province = $provinces_detail['region_name'];

			$citys = $this->r_model->get_citys($address->m_get('province'), $inter_id);
			$city_detail = $this->r_model->get_region_detail( $address->m_get('city'), $inter_id );
			$city = $city_detail['region_name'];
			
			$regions = $this->r_model->get_regions($address->m_get('city'), $inter_id);
			$region_detail = $this->r_model->get_region_detail( $address->m_get('region'), $inter_id );
			$region = $region_detail['region_name'];
		}

		$data['order'] = $this->o_model;
		$data['order_items'] = $order_items;
		$data['item_names'] = $item_names;
		$data['invoice'] = $this->i_model;
		$data['address'] = $this->a_model;
		$data['provinces'] = $provinces;
		$data['province'] = $province;
		$data['citys'] = $citys;
		$data['city'] = $city;
		$data['citys_url'] = Soma_const_url::inst()->get_url('*/api/ajax_get_citys', array('id' => $inter_id));
		$data['regions'] = $regions;
		$data['region'] = $region;
		$data['regions_url'] = Soma_const_url::inst()->get_url('*/api/ajax_get_regions', array('id' => $inter_id));
		$data['post_url'] = Soma_const_url::inst()->get_url('*/*/save_invoice', array('id' => $inter_id, 'oid' => $order_id));

		$header['title'] = $this->lang->line('invoice');

		$this->_view("header", $header);
        $this->_view("shipping_bill", $data);
	}

	/**
	 * 
	 * @return [type] [description]
	 */
	public function save_invoice() {

		// 需求不明，隐藏按钮，by FengZhongcheng 2016-07-25 18:16:53
        // return ;
		
		$inter_id = $this->inter_id;
		$order_list = Soma_const_url::inst()
			->get_url('*/order/my_order_list', array('id' => $inter_id));

		$order_id = intval($this->input->get('oid', true));
		$this->load->model('soma/Sales_order_model', 'o_model');
		$order = $this->o_model->load($order_id);

		if(!$order || $order->m_get('is_invoice') == $order::IS_INVOICE_YES) {
			$result = array('success' => false, 'msg' => '订单已提交开具发票请求，请勿重复提交');
			echo json_encode($result);
			exit;
		} 

		$post = $this->input->post(null, true);
		$openid = $this->openid;
		$this->load->model('soma/Sales_invoice_model', 'i_model');
		$this->load->model('soma/Customer_address_model', 'a_model');

		$address['openid'] = $this->openid;
		$address['inter_id'] = $inter_id;
		$address['province'] = $post['province'];
		$address['city'] = $post['city'];
		$address['region'] = $post['region'];
		$address['address'] = $post['address'];
		$address['phone'] = $post['mobile'];
		$address['contact'] = $post['name'];
		$address['status'] = Customer_address_model::STATUS_ACTIVE;

		$address_id = $this->a_model->save_address($address);

		if(!$address_id || $address_id == null) { 
			$result = array('success' => false, 'msg' => '无法保存地址信息，请稍后重新尝试操作');
			echo json_encode($result);
			exit;
		}

		$invoice['inter_id'] = $inter_id;
		$invoice['openid'] = $this->openid;
		$invoice['order_id'] = $order_id;
		// $invoice['row_total'] = $order->m_get('row_total');
		
		$bsn = $order->m_get('business');
		$order->business = $bsn;
		$items = $order->get_order_items($bsn, $inter_id);
		$invoice['row_total'] = 0;
		foreach ($items as $item) {
			$invoice['row_total'] += ($item['price_package'] * $item['qty']);
		}

		$invoice['grand_total'] = $order->m_get('grand_total');
		$invoice['invoice_title'] = $post['billTitle'];
        $invoice['tax_id'] = $post['taxId'];
		$invoice['address_id'] = $address_id;
		$invoice['address'] = $post['area'] . $post['address'];
		$invoice['contact'] = $post['name'];
		$invoice['phone'] = $post['mobile'];
		$invoice['create_time'] = date('Y-m-d H:i:s');
		$invoice['status'] = Sales_invoice_model::STATUS_APPLY;
        $invoice['email'] = $post['email'];

		if($invoice_id = $this->i_model->m_sets($invoice)->m_save()) {
			$order->m_set('is_invoice', Sales_order_model::IS_INVOICE_YES)->m_save();
			$result = array('success' => true, 'msg' => '操作成功');
			echo json_encode($result);
		} else {
			$result = array('success' => false, 'msg' => '无法保存发票申请信息，请稍后重新尝试了');
			echo json_encode($result);
		}

	}


	protected function _view($file, $datas=array() ) {
        parent::_view('consumer'. DS. $file, $datas);
    }

    //日志写入
    public function write_log( $content , $dir = 'mooncake')
    {
        $file= date('Y-m-d'). '.txt';
        //echo $tmpfile;die;
        $path= APPPATH.'logs'.DS. 'soma'. DS;
        if( !file_exists($path) ) {
            @mkdir($path, 0777, TRUE);
        }
        $fp = fopen( $path. $file, 'a');

        $CI = & get_instance();
        $ip= $CI->input->ip_address();
        $content= str_repeat('-', 40). "\n[". date('Y-m-d H:i:s'). ']'
            ."\n". $ip. "\n". $content. "\n";
        fwrite($fp, $content);
        fclose($fp);
    }
}