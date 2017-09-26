<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
class Accounts_entities_model extends MY_Model
{
    const TAB_AUTH_ACCOUNTS = 'iwide_authority_accounts';
    const TAB_AUTH_ACCOUNTS_ENT = 'iwide_authority_account_entities';
    const TAB_AUTH_ROLES = 'iwide_authority_roles';
    const TAB_HOTELS = 'iwide_hotels';
    const TAB_ROOMSERVICE_SHOP = 'iwide_roomservice_shop';

    protected $db_read;
    public function __construct()
    {
		parent::__construct ();
	}

    protected function db_read()
    {
        if ($this->db_read == null)
        {
            $this->db_read = $this->load->database('iwide_r1',true);
        }

        return $this->db_read;
    }
    
    protected function db_write()
    {
        return $this->db;
    }


    /**
     * @param $filter
     * 获取账户实体列表
     */
    public function accountEntities($filter)
    {
        $sql = "SELECT entities.admin_id,entities.entity_id,entities.is_default,entities.role_id,entities.inter_id,publics.name AS inter_name
                FROM  ".self::TAB_AUTH_ACCOUNTS_ENT." AS entities ";
        $sql .= " LEFT JOIN iwide_publics AS publics ON publics.inter_id = entities.inter_id AND publics.status = 0";

        $where = $this->set_where_sql($filter);

        if (!empty($where))
        {
            $sql .= " WHERE {$where}";
        }
        $data = $this->db_read()->query($sql)->result_array();
        return $data;
    }


    /**
     * 获取公众号默认/第一个实例
     * @param $filter
     * @return
     */
    public function getDefaultEntity($filter)
    {
        $sql = "SELECT * FROM  ".self::TAB_AUTH_ACCOUNTS_ENT." AS entities ";

        $where = $this->set_where_sql($filter);

        if (!empty($where))
        {
            $sql .= " WHERE {$where}";
        }
        $sql .= " ORDER BY entities.is_default DESC";
        $data = $this->db_read()->query($sql)->row_array();
        return $data;
    }



    /**
     * 查询酒店名称
     * @param $select
     * @param $where
     * @return
     */
    public function getHotels($select,$where)
    {
        $db = $this->db_read();
        $db->select($select);
        $db->from(self::TAB_HOTELS);

        $where_in = $where['hotel_id'];
        unset($where['hotel_id']);
        $db->where($where);
        if (!empty($where_in))
        {
            $db->where_in('hotel_id',$where_in);
        }
        $query = $db->get()->result_array();
        return $query;
    }

    /**
     * 查询店铺名称
     * @param $select
     * @param $where
     * @return
     */
    public function getShops($select,$where)
    {
        $db = $this->db_read();
        $db->select($select);
        $db->from(self::TAB_ROOMSERVICE_SHOP);

        $where_in = $where['shop_id'];
        unset($where['shop_id']);
        $db->where($where);
        if (!empty($where_in))
        {
            $db->where_in('shop_id',$where_in);
        }
        $query = $db->get()->result_array();
        return $query;
    }


    /**
     * 获取账户实体信息
     * @author 沙沙
     * @param string $select
     * @param array $where 条件
     * @return array $data
     * @date 2017-7-24
     */
    public function getOne($select = '*',$where = array())
    {
        $res = $this->db_read()->select($select)->where($where)->get(self::TAB_AUTH_ACCOUNTS_ENT)->row_array();
        return $res;
    }

    /**
     * 获取账户实体
     * @param string $select
     * @param array $where
     * @param string $orderBy
     * @return
     */
    public function getEntities($select = '*', $where = array(), $orderBy = '')
    {
        $admin_id = $where['admin_id'];
        $sql = "SELECT {$select} FROM ".self::TAB_AUTH_ACCOUNTS_ENT." WHERE admin_id = {$admin_id} ";
        if (!empty($orderBy))
        {
            $sql .= "order by {$orderBy} desc";
        }
        $query = $this->db_read()->query($sql)->result_array();

        return $query;
    }

    /**
     * 添加账户实体
     *
     * @param $array 公众号信息
     * @return 受影响行数
     */
    public function addEntities($array)
    {
        $db = $this->db_write();
        $db->insert('authority_account_entities', $array);
        return $db->insert_id();
    }

    /**
     * 更新账户实体
     *
     * @param $fitter
     * @param $array
     * @return
     */
    public function saveEntities($fitter,$array)
    {
        $db = $this->db_write();
        $db->where($fitter);
        $db->update('authority_account_entities', $array);
        return $db->affected_rows();
    }


    /**
     * 删除 账户实体
     * @param $fitter
     */
    public function deleteEntities($fitter)
    {
        $db = $this->db_write();
        $db->where($fitter)->delete(self::TAB_AUTH_ACCOUNTS_ENT);
        return $db->affected_rows();
    }

    /**
     * 根据条件获取店铺信息
     * @param array $filter
     * @param string $select
     * @return
     */
    public function getShopByHotelId($filter = array(),$select = '*')
    {
        $db = $this->db_read();
        $db->select($select);
        $hotel_id = $filter['hotel_id'];
        unset($filter['hotel_id']);
        $db->where($filter);
        $db->where_in('hotel_id',$hotel_id);
        return $db->get('roomservice_shop')->result_array();
     }


    /**
     * 创建查询条件sql语句
     * @access 	public
     * @param 	array	$filter 需要操作的数组
     * @return 	string
     */
    protected function set_where_sql($filter)
    {
        $where = '1';
        if(!empty($filter['admin_id']))
        {
            $where .= " AND entities.admin_id = {$filter['admin_id']}";
        }

        return $where;
    }

    /**
     * 创建排序sql语句
     * @access 	public
     * @param 	array	$data 需要操作的数组
     * @return 	string
     */
    protected function set_order_by_sql($data)
    {
        $arr_order_by = '';
        foreach($data as $k=>$v){
            //需要在字段前加表别名的，在这里写代码判断
            $arr_order_by[] = $k . ' ' . $v;
        }
        return empty($arr_order_by) ? '' : implode(', ', $arr_order_by);
    }

    /**
     * 取得列表限定记录数
     * @access 	public
     * @param   string		$page 当前页数
     * @param   boolean		$page_size	偏移量
     * @return  string		拼装的sql语句
     */
    protected function set_limit($page, $page_size)
    {
        $page = intval($page);
        $page_size = intval($page_size);
        return $page_size > 0 ? (' limit ' . max(0, ($page-1)*$page_size) . ', ' . max(1, $page_size)) : '';
    }
}
