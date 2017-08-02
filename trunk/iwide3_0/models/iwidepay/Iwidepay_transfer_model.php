<?php
class Iwidepay_Transfer_Model extends MY_Model{
    const TAB_IWIDEPAY_ORDER = 'iwide_iwidepay_order';
    const TAB_IWIDEPAY_RULE = 'iwide_iwidepay_rule';
    const TAB_IWIDEPAY_BANK = 'iwide_iwidepay_merchant_info';
    const TAB_IWIDEPAY_TRANSFER = 'iwide_iwidepay_transfer';
    const TAB_IWIDEPAY_SPLIT = 'iwide_iwidepay_split';
    const TAB_IWIDEPAY_SUM = 'iwide_iwidepay_sum_record';
	function __construct() {
		parent::__construct ();
	}

    protected function db_read(){
        
        $db_read = $this->load->database('iwide_r1',true);
        return $db_read;
        
    }
    
    protected function db_write(){
        
        return $this->db;
    }
    
    protected function db_soma_read(){
        
        $db_soma_read = $this->load->database('iwide_soma_r',true);
        return $db_soma_read;
        
        
    }
    //获取未分账订单（查询分账订单表）取前一天之前的
    public function get_unsplit_orders(){
        $start_time = date('Y-m-d',strtotime('-1 days'));
        //$end_time = date('Y-m-d 23:59:59',strtotime('-1 days'));
        $sql = "select * from " . self::TAB_IWIDEPAY_ORDER . " where transfer_status in (1,2,5,8) and (is_dist = 0 or is_dist = 2) and add_time <='{$start_time}'";
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
    public function get_transfer_data($start_date = '',$end_date = ''){
        if(empty($start_date)){
            $start_date = date('Y-m-d',strtotime('-1 days'));
        }
        if(empty($end_date)){
            $end_date = date('Y-m-d');
        }
        //先取出异常的订单号 然后拿记录的时候去掉那些订单号
        $sql = "select order_no from ". self::TAB_IWIDEPAY_TRANSFER . " where  add_time > '{$start_date}' and add_time <= '{$end_date}' and (status = 1 or status = 3) group by order_no";
        $orders = $this->db_read()->query($sql)->result_array();
        $sql = "select sum(a.amount) as sum_trans_amt,a.id,a.inter_id,GROUP_CONCAT(a.id) ids,a.hotel_id,a.bank,a.bank_user_name,a.bank_card_no,a.amount,a.add_time,a.m_id,b.bank_code,b.bank_city from " . self::TAB_IWIDEPAY_TRANSFER . " a left join " . self::TAB_IWIDEPAY_BANK . " b on a.m_id = b.id where a.add_time > '{$start_date}' and a.add_time <= '{$end_date}' and (a.status = 2) group by a.bank_card_no";
        if(!empty($orders)){
            $oid = array_column($orders,'order_no');
            $sql .= " and order_no not in (" . implode(',',$oid) . " )";
        }
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }

    //查询汇总表
    public function get_sum_record($start_date = '',$end_date = ''){
        if(empty($start_date)){
            $start_date = date('Y-m-d',strtotime('-1 days'));
        }
        if(empty($end_date)){
            $end_date = date('Y-m-d');
        }
        $sql = "select amount,status,m_id,merchant_name,merchant_no,bank,bank_card_no,bank_user_name,bank_code,bank_city,add_time,handle_date from " . self::TAB_IWIDEPAY_SUM . " where add_time > '{$start_date}' and add_time <= '{$end_date}'";
        $res = $this->db_read()->query($sql)->result_array();
        return $res;
    }

    //统计已经分账的记录 转账表
    public function gather_transfer_amt($inter_id = '',$order_no = '',$module = 'hotel'){
        $sql = "select sum(amount) as sum_trans_amt from " . self::TAB_IWIDEPAY_TRANSFER . " where inter_id = '{$inter_id}' and order_no = '{$order_no}' and module = '{$module}'";
        $res = $this->db_read()->query($sql)->row_array();
        return $res['sum_trans_amt'];
    }


    /**
     * 获取分账信息
     * @author 沙沙
     * @param string $select
     * @param array $where 条件
     * @date 2017-7-6
     */
    public function get_transfer($select = '*',$where = array())
    {
        $this->db->select($select);
        $this->db->from('iwide_iwidepay_transfer');
        $this->db->join('iwide_hotels','iwide_hotels.inter_id = iwide_iwidepay_transfer.inter_id AND iwide_hotels.hotel_id = iwide_iwidepay_transfer.hotel_id AND iwide_iwidepay_transfer.type="hotel"','left');
        $this->db->where_in('iwide_iwidepay_transfer.order_no',$where);

        return $this->db->get()->result_array();
    }

}
