<?php
class Iwidepay_Transfer_Model extends MY_Model{
    const TAB_IWIDEPAY_ORDER = 'iwide_iwidepay_order';
    const TAB_IWIDEPAY_RULE = 'iwide_iwidepay_rule';
    const TAB_IWIDEPAY_BANK = 'iwide_iwidepay_merchant_info';
    const TAB_IWIDEPAY_TRANSFER = 'iwide_iwidepay_transfer';
    const TAB_IWIDEPAY_SPLIT = 'iwide_iwidepay_split';
    const TAB_IWIDEPAY_SUM = 'iwide_iwidepay_sum_record';
    const TAB_IWIDEPAY_BILL = 'iwide_iwidepay_bill_record';
    const TAB_IWIDEPAY_SETTLE = 'iwide_iwidepay_settlement';
	function __construct() {
		parent::__construct ();
	}

    protected function db_read(){
        
        return $this->db;
        
    }
    
    protected function db_write(){
        
        return $this->db;
    }
    
    protected function db_soma_read(){
        
        $db_soma_read = $this->load->database('iwide_soma_r',true);
        return $db_soma_read;
        
        
    }

    //update 数据
    public function update_data($where = array() , $update = array()){
        if(empty($where)){
            return false;
        }
        $this->db->where($where);
        return $this->db->update('iwide_iwidepay_transfer',$update);
    }

    //获取未分账订单（查询分账订单表）取前一天之前的
    public function get_unsplit_orders(){
        $start_time = date('Y-m-d');
        //$end_time = date('Y-m-d 23:59:59',strtotime('-1 days'));
        $sql = "select * from " . self::TAB_IWIDEPAY_ORDER . " where (is_dist = 0 or is_dist = 2) and (refund_status = 0 or refund_status=2 or refund_status = 8) and ((transfer_status in (1,2,5,8) and module = 'soma') or (transfer_status in (2,8) and module != 'soma'))  and add_time <='{$start_time}'";
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }

    //获取规则
    public function get_rules_by_inter_id($inter_id = ''){
        $sql = "select * from " . self::TAB_IWIDEPAY_RULE . " where inter_id = '{$inter_id}' and status = 1";
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }
    //根据条件获取规则
    public function get_rules_by_filter($filter = array()){
        $this->db_read()->where($filter);
        $res = $this->db_read()->get('iwidepay_rule')->result_array();
        return $res;
    }

    //获取所有规则
    public function get_all_rules(){
        $sql = "select * from " . self::TAB_IWIDEPAY_RULE . " where status = 1";
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }

    //获取分账表行数
    public function get_split_count($inter_id = '',$order_no = '',$module = 'hotel'){
        $sql = "select count(*) as c from " .self::TAB_IWIDEPAY_SPLIT  . "  where inter_id = '{$inter_id}' and order_no = '{$order_no}' and module = '{$module}' and bank !='' and bank_card_no != '' and bank_user_name != ''";
        $res = $this->db->query($sql)->row_array();
        return $res['c'];
    }

    //获取转账表行数
    public function get_transfer_count($inter_id = '',$order_no = '',$module = 'hotel'){
        $sql = "select count(*) as c from " .self::TAB_IWIDEPAY_TRANSFER  . "  where inter_id = '{$inter_id}' and order_no = '{$order_no}' and module = '{$module}' and bank !='' and bank_card_no != '' and bank_user_name != ''";
        $res = $this->db->query($sql)->row_array();
        return $res['c'];
    }

    //获取银行信息
    public function get_bank_info($inter_id = '',$hotel_id = 0,$type = 0){
        $sql = "select id,inter_id,hotel_id,bank,bank_user_name,bank_card_no,type,is_company from " . self::TAB_IWIDEPAY_BANK . " where inter_id = '{$inter_id}' and status = 1 ";
        if($hotel_id >= 0){
            $sql .= " and hotel_id = {$hotel_id} and type = '{$type}'";
            $res = $this->db_read()->query($sql)->row_array();
            return $res;
        }else{
             $res = $this->db_read()->query($sql)->result_array();
             return $res;
        }
    }

    //获取所有银行信息
    public function get_all_banks(){
        $sql = " select id,inter_id,hotel_id,bank,bank_user_name,bank_card_no,type,is_company from " . self::TAB_IWIDEPAY_BANK . " where status = 1 ";
        $res = $this->db_read()->query($sql)->result_array();
             return $res;
    }

    //获取分账表和转账表的记录（连表）
    public function get_split_transfer_record($inter_id = '',$order_no = '',$module = 'hotel'){
        $sql = " select a.id,a.bank,a.bank_user_name,a.bank_card_no,a.amount,a.inter_id,a.hotel_id,a.type,a.order_no,a.status,a.m_id,b.m_id as s_m_id,b.bank as s_bank,b.bank_card_no as s_bank_card_no,b.bank_user_name as s_bank_user_name,b.amount as s_amount,b.type as s_type,b.hotel_id as s_hotel_id,b.order_no as s_order_no from " . self::TAB_IWIDEPAY_TRANSFER . " a left join " . self::TAB_IWIDEPAY_SPLIT . " b on a.inter_id = b.inter_id and b.order_no = a.order_no and  b.hotel_id = a.hotel_id and b.type = a.type and a.module = b.module where a.inter_id = '{$inter_id}' and a.order_no = '{$order_no}' and a.module = '{$module}' and a.bank !='' and a.bank_card_no != '' and a.bank_user_name != ''";
        $res = $this->db->query($sql)->result_array();
        return $res;
    }

    //获取导出记录 transfer表连merchant表
    public function get_transfer_data(){
        $end_date = date('Y-m-d 06:00:00');
        //先取出异常的订单号 然后拿记录的时候去掉那些订单号
        $sql = "select order_no from ". self::TAB_IWIDEPAY_TRANSFER . " where add_time <= '{$end_date}' and status != 2 group by order_no";
        $orders = $this->db_read()->query($sql)->result_array();
        $sql = "select sum(a.amount) as sum_trans_amt,a.id,a.inter_id,GROUP_CONCAT(a.id) ids,a.hotel_id,a.bank,a.bank_user_name,a.bank_card_no,a.amount,a.add_time,a.m_id,b.bank_code,b.bank_city,b.clearBankNo,b.accBankNo,b.is_company from " . self::TAB_IWIDEPAY_TRANSFER . " a left join " . self::TAB_IWIDEPAY_BANK . " b on a.m_id = b.id where  a.add_time <= '{$end_date}' and a.status = 2 and a.send_status = 0";
        if(!empty($orders)){
            $oid = array_column($orders,'order_no');
            $sql .= " and a.order_no not in ('" . implode("','",$oid) . "' )";
        }
        $sql .= " group by a.bank_card_no having sum_trans_amt>0";//=0的不插表了
        
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }

    //查询汇总表
    public function get_sum_record($start_date = '',$end_date = ''){
        if(empty($start_date)){
            $start_date = date('Y-m-d');
        }
        if(empty($end_date)){
            $end_date = date('Y-m-d 23:59:59');
        }
        $sql = "select amount,status,m_id,merchant_name,merchant_no,bank,bank_card_no,bank_user_name,bank_code,bank_city,add_time,handle_date from " . self::TAB_IWIDEPAY_SUM . " where add_time >= '{$start_date}' and add_time <= '{$end_date}'";
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }

    //统计已经分账的记录 转账表
    public function gather_transfer_amt($inter_id = '',$order_no = '',$module = 'hotel'){
        $sql = "select sum(amount) as sum_trans_amt from " . self::TAB_IWIDEPAY_TRANSFER . " where inter_id = '{$inter_id}' and order_no = '{$order_no}' and module = '{$module}'";
        $res = $this->db_read()->query($sql)->row_array();
        return $res['sum_trans_amt'];
    }

    //商城 获取已分账的记录
    public function get_handle_transfer_amt($order_no = '',$module = 'soma',$status = 2){
        $sql = "select sum(if(type='hotel',amount,0)) as hotel_amt,sum(if(type!='hotel',amount,0)) as o_amt from iwide_iwidepay_transfer where module = '{$module}' and order_no  = '$order_no' and status = {$status}";
        $res = $this->db_read()->query($sql)->row_array();
        return $res;
    }


    /**
     * 获取分账信息
     * @author 沙沙
     * @param string $select
     * @param array $where 条件
     * @param string $send_status
     * @return
     * @date 2017-7-6
     */
    public function get_transfer($select = '*',$where = array(),$send_status = '')
    {
        $this->db->select($select);
        $this->db->from('iwide_iwidepay_transfer');
        $this->db->join('iwide_hotels','iwide_hotels.inter_id = iwide_iwidepay_transfer.inter_id AND iwide_hotels.hotel_id = iwide_iwidepay_transfer.hotel_id AND iwide_iwidepay_transfer.type="hotel"','left');
        $this->db->where('iwide_iwidepay_transfer.status', 2);
        if ($send_status !== '')
        {
            $status = $send_status == 1 ? 1 : 0;
            $this->db->where('iwide_iwidepay_transfer.send_status',$status);
        }

        $this->db->where_in('iwide_iwidepay_transfer.order_no',$where);

        return $this->db->get()->result_array();
    }

    //SOMA 商城 查询已经核销的未进行分账处理的通票 
    public function get_soma_bill($inter_id,$order_id){
        $sql = "select id,bill_id,inter_id,hotel_id,order_id,order_qty,bill_hotel,bill_qty,bill_time,status,handle_status from " . self::TAB_IWIDEPAY_BILL . " where order_id = '{$order_id}' and inter_id = '{$inter_id}'  and status = 1 order by id asc";
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }

    //获取当天汇总待发放的数据
    public function get_deliver_data(){
        $date = date('Ymd');
        $sql = "SELECT id,m_id,amount,bank_card_no,bank_user_name,handle_date,bank_city,bank_code,is_company FROM " . self::TAB_IWIDEPAY_SUM . " WHERE handle_date = '{$date}' and status = 0 ";
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }

    /**
     * 查询分账结算表
     * 沙沙
     * @param string $start_date
     * @param string $end_date
     * @return mixed
     */
    public function get_settlement($start_date = '',$end_date = '')
    {
        if(empty($start_date)){
            $start_date = date('Y-m-d');
        }
        if(empty($end_date)){
            $end_date = date('Y-m-d 23:59:59');
        }
        $sql = "select id from " . self::TAB_IWIDEPAY_SETTLE . " where add_time >= '{$start_date}' and add_time <= '{$end_date}'";
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }

    /**
     * 获取转账信息
     * 沙沙
     */
    public function get_settlement_transfer()
    {
        $end_date = date('Y-m-d 06:00:00');
        //先取出异常的订单号 然后拿记录的时候去掉那些订单号
        $sql = "select order_no from ". self::TAB_IWIDEPAY_TRANSFER . " where add_time <= '{$end_date}' and status != 2 group by order_no";
        $orders = $this->db_read()->query($sql)->result_array();
        $sql = "select a.id,a.inter_id,a.hotel_id,a.bank,a.bank_user_name,a.type,
                a.bank_card_no,a.amount,a.add_time,a.m_id,b.bank_code,b.bank_city,b.clearBankNo,b.accBankNo,b.is_company
                from " . self::TAB_IWIDEPAY_TRANSFER . " a
                left join " . self::TAB_IWIDEPAY_BANK . " b on a.m_id = b.id
                where  a.add_time <= '{$end_date}' and a.status = 2 and a.send_status = 0";
        if(!empty($orders)){
            $oid = array_column($orders,'order_no');
            $sql .= " and a.order_no not in ('" . implode("','",$oid) . "' )";
        }

        unset($orders);
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }

    /**
     * 查询分账结算表 汇总匹配 
     * @param string $start_date
     * @param string $end_date
     * @return mixed
     */
    public function get_settlement_info($date='')
    {
        if(empty($date)){
            $date = date('Ymd');//凌晨跑前一天 所以这里不去前一天
        }
        $sql = "select id,sum(amount) as sum_amount,bank_card_no from " . self::TAB_IWIDEPAY_SETTLE . " where handle_date = '{$date}' and status = 0  group by bank_card_no";
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }

}
