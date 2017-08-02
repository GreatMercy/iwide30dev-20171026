<?php
class Roomservice_ticket_sales_Model extends MY_Model{
	function __construct() {
		parent::__construct ();
	}

        const TAB_TICKET_SALES = 'roomservice_ticket_sales';

	public function get_resource_name()
	{
		return 'Roomservice_ticket_sales_Model';
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function table_name()
	{
		return self::TAB_TICKET_SALES;
	}


    public function get_num_where()
    {

    }

    /**
     * 更新库存
     * @param $data 更改的数据
     * @param $where 条件
     * @return mixed
     */
    public function update_data($data,$where)
    {
        if (!empty($data))
        {
            foreach ($data as $key => $value)
            {
                $this->db->set($key, $value, $key == 'sales' ? false : true);
            }

            $this->db->where($where);
            $this->db->update(self::TAB_TICKET_SALES);
            return $this->db->affected_rows();
        }
    }
}
