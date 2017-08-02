<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
class Authority_accounts_model extends MY_Model
{
    const TAB_AUTH_ACCOUNTS = 'iwide_authority_accounts';
    const TAB_AUTH_ACCOUNTS_ENT = 'iwide_authority_account_entities';
    const TAB_AUTH_ROLES = 'iwide_authority_roles';
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
     * 获得数量
     * @param $filter
     */
    public function countAccount($filter)
    {
        $sql = "SELECT count(account.admin_id) AS num FROM  ".self::TAB_AUTH_ACCOUNTS." AS account ";
        $sql .= " LEFT JOIN iwide_authority_account_entities AS entities ON account.admin_id = entities.admin_id AND entities.is_default = 1";
        $sql .= " LEFT JOIN iwide_publics AS publics ON publics.inter_id = entities.inter_id AND publics.status = 0";

        $where = $this->set_where_sql($filter);

        if (!empty($where))
        {
            $sql .= " WHERE {$where}";
        }

        $data = $this->db_read()->query($sql)->row_array();
        return $data ? $data['num'] : $data['num'];

    }

    /**
     * @param $filter
     * 获取账户列表
     */
    public function accountList($filter)
    {
        $sql = "SELECT account.admin_id,account.type,account.username,account.create_time,account.status,entities.role_id,publics.name AS inter_name
                FROM  ".self::TAB_AUTH_ACCOUNTS." AS account ";
        $sql .= " LEFT JOIN iwide_authority_account_entities AS entities ON account.admin_id = entities.admin_id AND entities.is_default = 1";
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
     * 获取账户信息
     * @author 沙沙
     * @param string $select
     * @param array $where 条件
     * @return array $data
     * @date 2017-7-24
     */
    public function getOne($select = '*',$where = array())
    {
        $res = $this->db_read()->select($select)->where($where)->get(self::TAB_AUTH_ACCOUNTS)->row_array();

        return $res;
    }

    /**
     * 获取账户
     * @param string $select
     * @param array $where
     * @param string $orderBy
     * @return
     */
    public function getAccounts($select = '*', $where = array(), $orderBy = '')
    {
        $db = $this->db_read();
        $db->select($select);
        $db->from(self::TAB_AUTH_ACCOUNTS);
        $db->where($where);
        if (!empty($orderBy))
        {
            $orderBy = explode(' ',$orderBy);
            $db->order_by($orderBy[0],$orderBy[1]);
        }
        $query = $db->get()->result_array();

        return $query;
    }

    /**
     * 添加账户
     *
     * @param $array 公众号信息
     *        	return 受影响行数
     */
    public function addAccount($array)
    {
        $db = $this->db_write();
        $db->insert('authority_accounts', $array);
        return $db->insert_id();
    }

    /**
     * 更新账户
     *
     * @param $fitter
     * @param $array
     * @return
     */
    public function saveAccount($fitter,$array)
    {
        $db = $this->db_write();
        $db->where($fitter);
        $db->update('authority_accounts', $array);
        return $db->affected_rows();
    }

    /**
     * 获取角色信息
     * @param string $select
     * @param array $where
     * @param bool $rows 是否查询多行记录 默认: TRUE
     * @return
     */
    public function getRoles($select = '*',$where = array(),$rows = true)
    {
        $res = $this->db_read()->select($select)->where($where)->get(self::TAB_AUTH_ROLES);
        if ($rows == true)
        {
            return $res->result_array();
        }
        else
        {
            return $res->row_array();
        }
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
        if(isset($filter['parent_id']) && $filter['parent_id'] >= 0)
        {
            $where .= " AND account.parent_id = {$filter['parent_id']}";
        }

        if(!empty($filter['keyword']))
        {
            $where .= " AND (account.username like '%{$filter['keyword']}%'";
            $where .= " OR  publics.name like '%{$filter['keyword']}%')";
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
