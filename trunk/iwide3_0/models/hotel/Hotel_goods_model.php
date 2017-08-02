<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Hotel_goods_model extends MY_Model {
	function __construct() {
        parent::__construct ();
    }
    const TAB_HG = 'hotel_goods';

    function _load_db() {
        return $this->db;
    }

    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function table_name()
	{
		return self::TAB_HG;
	}
	
	public function table_primary_key()
	{
		return 'id';
	}

    function create_hg($data){

        $db = $this->_load_db ();

        return $db->insert ( self::TAB_HG, $data );

    }

	function get_list($condit=array()){
        $this->load->model('soma/Product_package_model');
        //商品状态
        if(!empty($condit['status']) && $condit['status']=='normal'){
            $params['status'] = Product_package_model::STATUS_ACTIVE;
            $status = array(1);
        }else{
            $params['status'] = null;
            $status = null;
        }
        //同步商城商品
        $this->synchro_soma($condit['inter_id']);
        
        $hotel_goods_list = $this->hotel_goods_list($condit['inter_id'],'*',$status);
        $hotel_good_ids = array();
        $goods_list = array();
        foreach ($hotel_goods_list as $hotel_good) {
            $hotel_good_ids[] = $hotel_good['external_id'];
            $goods_list[$hotel_good['external_id']] = $hotel_good;
        }
        if(empty($hotel_good_ids)) return false;

        //加载商城的获取商品接口
        //参数 inter_id,gs_id,size,page
        if(isset($condit['size']) && isset($condit['page'])){
            $params['size'] = intval($condit['size']);
            $params['page'] = intval($condit['page']);
            $params['is_count'] = true;
        }else{
            $params['size'] = null;
            $params['page'] = null;
            $params['is_count'] = false;
        }
        // if(isset($condit['gs_id'])){
        //     $params['gs_id'] = $condit['gs_id'];
        // }else{
        //     $params['gs_id'] = null;
        // }
        $soma_goods_list = $this->Product_package_model->getHotelPackageProductList($condit['inter_id'],array('in'=>$hotel_good_ids),$params['page'],$params['size'],$params['is_count'],$params['status']);
        $return_list = array();
        foreach ($soma_goods_list['data'] as $soma_good) {
            $return_list[$goods_list[$soma_good['product_id']]['goods_id']] = $goods_list[$soma_good['product_id']];
            $return_list[$goods_list[$soma_good['product_id']]['goods_id']]['name'] = $soma_good['name'];//名称
            $return_list[$goods_list[$soma_good['product_id']]['goods_id']]['soma_status'] = $soma_good['status'];//商城状态
            $return_list[$goods_list[$soma_good['product_id']]['goods_id']]['stock'] = $soma_good['stock'];//库存
            $return_list[$goods_list[$soma_good['product_id']]['goods_id']]['price_package'] = $soma_good['price_package'];//商城价
        }

        $return = array(
            'items'=>$return_list
        );
        if(isset($params['is_count']) && $params['is_count']){
            $return['count'] = $soma_goods_list['total'] ;
        }
        $return['status_des'] = $this->Product_package_model->get_status_label();
        return $return;
    }

    function synchro_soma($inter_id){
        $hotel_goods_list = $this->hotel_goods_list($inter_id,'external_id');
        $somaids = array();
        foreach ($hotel_goods_list as $v) {
            $somaids[] = $v['external_id'];
        }
        //加载商城的获取商品接口
        $this->load->model('soma/Product_package_model');
        $soma_goods_list = $this->Product_package_model->getHotelPackageProductList($inter_id,array('not_in'=>$somaids));
        $newdata = array(
            'inter_id' => $inter_id,
            'create_time' => date('Y-m-d H:i:s')
        ); 
        foreach ($soma_goods_list['data'] as $gs_id) {//订房库未保存的商品
            $newdata['external_id'] = $gs_id['product_id'];
            $newdata['price'] = $gs_id['price_package'];
            $newdata['unit'] = '份';
            $this->create_hg($newdata);
            $somaids[] = $gs_id['price_package'];
        }

        return $somaids;
    }

    function hotel_goods_list($inter_id,$select='*',$status=null,$condit=array())
    {
        $db_read = $this->load->database('iwide_r1',true);
        $db_read->select ( $select );
        $db_read->where ( 'inter_id', $inter_id );
        if($status!==null && is_array($status) ){
            $db_read->where_in ( 'status', $status );
        }else{
            $db_read->where_in ( 'status', array(1,2) );
        }
        $db_read->from ( self::TAB_HG );

        $hotel_goods_list = $db_read->get ()->result_array ();
        return $hotel_goods_list;
    }

    function get_row ( $inter_id,$id,$condit=array()){

        $db_read = $this->load->database('iwide_r1',true);

        $db_read->select ('*');

        $db_read->where('inter_id', $inter_id);
		$db_read->where('id', $id);

        if(isset($condit['status'])){
            $db_read->where('status', $condit['status']);
        }

        $db_read->from ( self::TAB_HG);

        return $db_read->get ()->row_array ();
    }

    //更新
    function update_data($inter_id,$id,$data){
    	$db = $this->_load_db ();
        $db->where('inter_id', $inter_id);
        $db->where('gs_id', $id);
        $this->load->helper ( 'array' );
        $data = elements(array('hotel_price','gs_unit'), $data);
		return $db->update(self::TAB_HG,$data);
    }
}