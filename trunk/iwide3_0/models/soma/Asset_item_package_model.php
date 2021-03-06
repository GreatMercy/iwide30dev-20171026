<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once dirname(__FILE__). DS. 'Asset_item_interface.php';

/**
 * Class Asset_item_package_model
 * @author renshuai  <renshuai@mofly.cn>
 *
 * @property Consumer_code_model $consumer_code_model
 */
class Asset_item_package_model extends MY_Model_Soma 
    implements Asset_item_interface {

    public function table_name($business='package', $inter_id=NULL)
    {
        return $this->_shard_table("soma_asset_item_{$business}", $inter_id);
    }
	public function table_primary_key()
	{
	    return 'item_id';
	}

	/**
	 * 字段映射，key中字段将直接转移到item
	 * @return multitype:string
	 */
	public function product_item_field_mapping()
	{
	    return array(
	        'product_id'=> 'product_id',
	        'inter_id'=> 'inter_id',
	        'hotel_id'=> 'hotel_id',
	        'sku'=> 'sku',
            'conn_devices'=> 'conn_devices',
            'type'=> 'type',
            'goods_type'=> 'goods_type',
            'name'=> 'name',
            'name_en'=> 'name_en',
	        'card_id'=> 'card_id',
	        'price_market'=> 'price_market',
	        'price_package'=> 'price_package',
	        'compose'=> 'compose',
            'compose_en'=> 'compose_en',
	        'face_img'=> 'face_img',
	        'transparent_img'=> 'transparent_img',
            'use_cnt'=> 'use_cnt',
            'can_split_use'=> 'can_split_use',
            'can_wx_booking'=> 'can_wx_booking',
            'wx_booking_config'=> 'wx_booking_config',
	        'can_refund'=> 'can_refund',
	        'can_mail'=> 'can_mail',
	        'can_gift'=> 'can_gift',
	        'can_pickup'=> 'can_pickup',
            'can_sms_notify' => 'can_sms_notify',
	        'can_invoice'=> 'can_invoice',
            'can_reserve'=> 'can_reserve',
	        'is_hide_reserve_date'=> 'is_hide_reserve_date',
	        'room_id'=> 'room_id',
            'hotel_name'=> 'hotel_name',
	        'hotel_tel'=> 'hotel_tel',
	        'validity_date'=> 'validity_date',
	        'expiration_date'=> 'expiration_date',
	        'order_item_id'=> 'item_id',
            'order_id'  => 'order_id',
	        //'openid_origin'=> 'openid',
	        'openid'=> 'openid',
	        //'qty_origin'=> 'qty',
	        'qty'=> 'qty',
	    );
	}

    //定义 m_save 保存时不做转义字段
    public function unaddslashes_field()
    {
        return array(
            'wx_booking_config',
        );
    }
	
	//################# 以上为非必要函数，下面为业务必要函数 #####################

	/**
	 * 获取订单细单数组（单个）
	 */
	public function get_order_items($order, $inter_id)
	{
	    $opk = $order->table_primary_key();
	    $order_id= $order->m_get($opk);
	    $table= $this->table_name($order->business, $inter_id );
	    $data= $order->_shard_db_r('iwide_soma_r')
    	    ->get_where($table, array($opk => $order_id ))
    	    ->result_array();
	    return $data;
	}
	
	public function get_order_items_by_filter($inter_id, $filter)
	{
	    $table= $this->table_name('package', $inter_id );
        $db = $this->_shard_db_r('iwide_soma_r');

	    foreach ($filter as $k=>$v){
	        if( !is_array($v) )
            {
                $db->where($k, $v);
            } else {
                $db->where_in($k, $v);
            }
	    }

	    return $db->get($table)->result_array();
	}

	/**
	 * 获取订单细单数组（多个）
	 */
	public function get_order_items_byIds($ids, $business, $inter_id)
	{
	    $table = $this->_db()->dbprefix( $this->table_name($business, $inter_id) );
	    $items= $this->_shard_db_r('iwide_soma_r')
    	    ->where_in( 'asset_id', $ids )
    	    ->get($table)->result_array();
	    return $items;
	}

	public function get_order_items_byItemids($ids, $business, $inter_id)
	{
	    $table = $this->_db()->dbprefix( $this->table_name($business, $inter_id) );
	    $items= $this->_shard_db($inter_id)
    	    ->where_in( 'item_id', $ids )
    	    ->get($table)->result_array();
	    return $items;
	}
	public function get_order_items_byGiftids($ids, $business, $inter_id)
	{
	    $table = $this->_db()->dbprefix( $this->table_name($business, $inter_id) );
	    $items= $this->_shard_db_r('iwide_soma_r')
    	    ->where_in( 'gift_id', $ids )
    	    ->get($table)->result_array();
	    return $items;
	}
	public function get_order_items_byOrderids($ids, $business, $inter_id)
	{
	    $table = $this->_db()->dbprefix( $this->table_name($business, $inter_id) );
	    $items= $this->_shard_db_r('iwide_soma_r')
    	    ->where_in( 'order_id', $ids )
    	    ->get($table)->result_array();
	    return $items;
	}
	/**
	 * 保存资产明细
	 * @see Asset_item_interface::save_item()
     * @return bool
	 */
	public function save_item($asset, $inter_id)
	{
	    $data = $item_ids = array();
	    $item = $asset->order->item;

        $result = false;
        foreach ($item as $k=>$v){
            foreach ($this->product_item_field_mapping() as $sk=> $sv){
                $data[$k][$sk]= isset($v[$sv])? $v[$sv]: '';
            }

            $data[$k]['asset_id']= $asset->m_get('asset_id');
            $data[$k]['add_time']= date('Y-m-d H:i:s');

            $table = $this->table_name($asset->order->business, $inter_id );
            $result = $asset->_shard_db($inter_id)->insert( $table, $data[$k] );
            if (!$result) break;

            $this->load->model('soma/consumer_code_model');
            //根据id生成对应数量的code
            $id_array= array(
	            'asset_item_id'=> $asset->_shard_db($inter_id)->insert_id(),
	            'order_item_id'=> $data[$k]['order_item_id'],
	            'order_id'=> $data[$k]['order_id'],
	            'asset_id'=> $data[$k]['asset_id'],
	        );
	        $result = $this->consumer_code_model->generate_asset_code($id_array, $data[$k]['qty'], $inter_id);
            if (!$result) break;

	    }
	    return $result;
	}
	
	public function calculate_total($asset, $inter_id)
	{
        $value = 0;
	    $total= $amount= 0;
	    $pk= $asset->table_primary_key();
	    $table = $this->_db()->dbprefix( $this->table_name($asset->order->business, $inter_id) );
	    $items= $asset->_shard_db_r('iwide_soma_r')
	       ->where( $pk, $asset->m_get($pk) )
	       ->get($table)->result_array();
	    foreach ($items as $k=>$v){
	        $qty= isset($v['qty'])? $v['qty']: 0;
	        $amount+= $qty;
	        $value+= isset($v['price_package'])? $v['price_package']* $qty: 0;
	    }
	    $asset->amount= $amount;
	    $asset->row_total= $value;
	    return $asset;
	}
    
    /**
     * 订单退款改变资产库细表数量
     * Usage: $asset->business = $business;
     * Usage: $model->order_refund_status( $asset, $inter_id );
     * Usage: $salesRefundModel; 为了保存事务一致性
     * @author luguihong
     */
    public function order_refund_status( $asset, $inter_id, $salesRefundModel )
    {
        $pk = $this->table_primary_key();
        
        $qty = isset( $asset->qty ) ? $asset->qty : 0;
        if( $qty < 1 ){
            return FALSE;
        }
        
        $where = array();
        $where[$pk] = isset( $asset->{$pk} ) ? $asset->{$pk} : 0;
        
        //取出数据
        $table_name = $this->table_name( $asset->business, $inter_id );
        $result = $salesRefundModel->_shard_db_r('iwide_soma_r')->where( $where )->get( $table_name )->result_array();
        if( !$result ){
            return FALSE;
        }
        
        $qty_old = isset( $result[0]['qty'] ) ? $result[0]['qty'] : 0;
        
        //数量加减
        $minus = isset( $asset->minus ) ? $asset->minus : FALSE;//减操作
        $plus = isset( $asset->plus ) ? $asset->plus : FALSE;//加操作
        $qty_new = $qty_old;
        if( $minus && !$plus ){

            if( $qty_old < 1 || $qty_old < $qty ){
                return FALSE;
            }

            $qty_new = $qty_old - $qty;
            if( $qty_new < 0 ){
                return FALSE;
            }
        }elseif( $plus && !$minus ){
            // $qty_new = $qty_old + $qty;//暂时没有用到
        }else{
            return FALSE;
        }
        
        if( $qty_new < 0 ){
            $qty_new = 0;
        }
        
        $data = array();
        $data['qty'] = $qty_new;
        
        $salesRefundModel->_shard_db( $inter_id )->where( $where )->update( $table_name, $data );
        if( $salesRefundModel->_shard_db( $inter_id )->affected_rows() > 0 ){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
	 * 根据asset_item_id查找细单信息
	 * $model->get_asset_items_by_itemId( $item_id, $business, $inter_id );
	 * @author luguihong@mofly.cn
	 * @deprecated
	 */
    public function get_asset_items_by_itemId( $item_id, $business, $inter_id )
    {
        if( !$item_id ){
            return FALSE;
        }

        $business = strtolower( $business );

        $where = array();
        $where['inter_id'] = $inter_id;
        $where['item_id'] = $item_id + 0;

		$table_name = $this->table_name( $business, $inter_id );
        $result = $this->_shard_db_r('iwide_soma_r')
                      ->get_where( $table_name, $where )
                      ->result_array();
   
        return $result;
    }

    /**
	 * 核销细单
	 * $model->order_item = array( 'consumer_id'=>$consumer_id, 'status'=>$status );
	 * $model->consumer_order_item_use();
	 * @author luguihong@mofly.cn
	 * @deprecated
	 */
    public function consumer_order_item_use( $business, $inter_id )
    {
    	$consumer_id = isset( $this->order_item['consumer_id'] ) ? $this->order_item['consumer_id'] : '';
    	$status = isset( $this->order_item['status'] ) ? $this->order_item['status'] : '';
        if( !$consumer_id || !$status ){
            return FALSE;
        }

        $table_name = $this->table_name( $business, $inter_id );

        $where = array();
        $where['consumer_id'] = $consumer_id;
        $where['inter_id'] = $inter_id;

        $data = array();
        $data['status'] = $status;

        $this->_shard_db( $inter_id )
             ->where( $where )
             ->update( $table_name, $data );

        return $this->_shard_db( $inter_id )->affected_rows();
    }

    /**
     * 核销细单减数量
     * $item[0]['minus_qty'] 需要扣减的数量，要额外添加到细单里
     * @author luguihong@mofly.cn
    */
    public function consumer_asset_items( $consumer, $item, $inter_id, $business='package' )
    {
    	if( !$item ){
    		return FALSE;
    	}

    	$item = $item[0];

    	$minus_qty = isset( $item['minus_qty'] ) && !empty( $item['minus_qty'] ) ? $item['minus_qty'] + 0 : 1;
    	if( ( $item['qty'] < 1 ) || ( $item['qty'] < $minus_qty ) || ( $minus_qty < 1 ) ){
    		return FALSE;
    	}
        
        $where = array();
        $where['item_id'] = isset( $item['item_id'] ) ? $item['item_id'] : 0;
        $where['inter_id'] = isset( $item['inter_id'] ) ? $item['inter_id'] : '';
        $where['qty'] = isset( $item['qty'] ) ? $item['qty'] : '';
        
        $data = array();
        $data['qty'] = $item['qty'] - $minus_qty;

    	$table_name = $this->table_name($business, $inter_id);
    	$consumer->_shard_db( $inter_id )->where( $where )->update( $table_name, $data );
        //记录消费数量
        if ($consumer->_shard_db( $inter_id )->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function _write_log( $content )
    {
        $path= APPPATH. 'logs'. DS. 'soma'. DS. 'consumer'. DS;
        if( !file_exists($path) ) {
            @mkdir($path, 0777, TRUE);
        }
        $file= $path. date('Y-m-d_H'). '.txt';
        $this->write_log($content, $file);
    }

    /**
     * 计划任务，套票快过期的时候发送模版消息(已经迁回到模版model里面处理)
	 * @author luguihong@mofly.cn
     * @deprecated
	 */
    public function create_message_wxtemp( $limit=100, $inter_id=NULL )
    {
        $debug = FALSE;
        //一日扫描一次
        $business = 'package';
        $table_name = $this->table_name( $business, $inter_id );

    	$filter = array();
        $filter['inter_id'] = $inter_id;

        $time = date( 'Y-m-d H:i:s', time() );
        $expireTime = date( 'Y-m-d H:i:s', time() + 15*24*60*60 );//现在的时间加上15天就是>=过期时间，发送模版消息是在过期前15开始发送，只发送一条
        
    	$list = $this->_shard_db_r('iwide_soma_r')
                        ->where( $filter )
                        ->where( 'qty >= ', 1 )
                        ->where( 'expiration_date <= ', $expireTime )
                        ->where( 'expiration_date > ', $time )
                        ->where( '(send_wxtemp_status is NULL or send_wxtemp_status = 2)' )
                        ->limit( $limit )
                        ->get( $table_name )
                        ->result_array();
//SELECT * FROM `iwide_soma_asset_item_package_1001` WHERE `inter_id` = 'a450089706' AND `qty` >'0' AND `expiration_date` <= '2016-06-15 10:20:05' AND `expiration_date` > '2016-05-31 10:20:05' AND (`send_wxtemp_status`=2 or `send_wxtemp_status` is NULL) LIMIT 100
// var_dump( $list );return false;
        if( $debug )$this->_write_log( $inter_id . json_encode( $list ) );

        if( $list ){
            
            $this->load->model('soma/Message_wxtemp_template_model','MessageWxtempTemplateModel');
            $MessageWxtempTemplateModel = $this->MessageWxtempTemplateModel;

            foreach ($list as $k => $v) {
                //套票到期
                /***********************发送模版消息****************************/
                $openid = $v['openid'];//发送给那个用户
                $type = $MessageWxtempTemplateModel::TEMPLATE_PACKAGE_EXPIRE;//套票到期
                $templateInfo = $MessageWxtempTemplateModel->get_template_detail_byType( $type, $inter_id );
                if( $templateInfo ){
                    $template_id = $templateInfo['template_id'];
                    $array = array();
                    $array['name'] = $v['name'];
                    $array['expiration_date'] = $v['expiration_date'];//过期时间
                    $sort_array = $MessageWxtempTemplateModel->get_template_send_sort();
                    $array['sort'] = $sort_array[$type];

                    $createInfo = $MessageWxtempTemplateModel->create_template_message( $openid, $template_id, $type, $array, $inter_id, $business );
                    if( $debug )$this->_write_log( json_encode( $createInfo ) );
                    if( isset( $createInfo['status'] ) && $createInfo['status'] == 1 ){
                        //方式一：保存到队列里
                        // $MessageWxtempTemplateModel->save_template_message( $createInfo['data'], $inter_id );

                        //方式二：立即发送模版消息
                        $result = $MessageWxtempTemplateModel->save_template_record( $createInfo, $inter_id );
                        if( $debug )$this->_write_log( json_encode( $result ) );
                        
                        $data = array();
                        if( $result ){
                            $data['send_wxtemp_status'] = 1;
                        }else{
                            $data['send_wxtemp_status'] = 2;
                        }
                        
                        $where = array();
                        $where['inter_id'] = $inter_id;
                        $where['item_id'] = $v['item_id'];
                        //修改资产细单模版消息状态
                        $this->_shard_db( $inter_id )
                                ->where( $where )
                                ->update( $table_name, $data );
                    }
                }
                /***********************发送模版消息****************************/
            }
        }
    }

    //计划任务，套票过期时间到了，自动把礼包分配到当前的用户
    public function package_to_user( $inter_id, $limit )
    {
        try{
            //一日扫描一次
            $debug = TRUE;
            $business = 'package';
            $table_name = $this->table_name( $business, $inter_id );
            $time = date( 'Y-m-d H:i:s', time() );
            $list = $this->_shard_db_r('iwide_soma_r')
                            ->where( 'inter_id', $inter_id )
                            ->where( 'type', self::PRODUCT_TYPE_PRIVILEGES_VOUCHER )
                            ->where( 'qty >= ', 1 )
                            ->where( 'expiration_date < ', $time )
                            ->limit( $limit )
                            ->get( $table_name )
                            ->result_array();
            if( $debug )$this->_write_log( $inter_id . json_encode( $list ), 'package_to_user' );

            if( count( $list ) > 0 ){

                $this->load->model( 'soma/Consumer_order_model','ConsumerModel' );
                $ConsumerModel = $this->ConsumerModel;

                //这里设置session的作用是，核销的时候不检查有效期
                $this->load->library('session');
                $this->session->set_userdata('not_check_expire', TRUE);
                
                foreach( $list as $k=>$v ){
                    $order_id = $v['order_id'];
                    $openid = $v['openid'];
                    $item_id = $v['item_id'];
                    $limit = $v['qty'];
                    $ConsumerModel->package_consumer( $order_id, $openid, $inter_id, $business, $item_id, $limit );
                }

                $this->session->set_userdata('not_check_expire', FALSE);

            }

        } catch (Exception $e) {
            $this->_write_log( json_encode( $e->getMessage() ), 'package_to_user' );
        }
    }

    
}
