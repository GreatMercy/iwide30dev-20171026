<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
class Valify_tokens_model extends MY_Model
{
    const TAB_AUTH_ACCOUNTS = 'iwide_authority_accounts';
    const TAB_AUTH_ACCOUNTS_ENT = 'iwide_authority_account_entities';
    const TAB_AUTH_ROLES = 'iwide_authority_roles';
    const TAB_AUTH_TOKENS = 'iwide_authority_valify_tokens';
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
     * 获取账户信息
     * @author 沙沙
     * @param string $select
     * @param array $where 条件
     * @return array $data
     * @date 2017-7-24
     */
    public function getOne($select = '*',$where = array())
    {
        $res = $this->db_read()->select($select)->where($where)->get(self::TAB_AUTH_TOKENS)->row_array();
        return $res;
    }

    /**
     * 获取TOKEN
     * @param string $select
     * @param array $where
     * @param string $orderBy
     * @return
     */
    public function getToken($select = '*', $where = array(), $orderBy = '')
    {
        $db = $this->db_read();
        $db->select($select);
        $db->from(self::TAB_AUTH_TOKENS);
        $db->where($where);
        if (!empty($orderBy))
        {
            $orderBy = explode(' ',$orderBy);
            $db->order_by($orderBy[0],$orderBy[1]);
        }
        $query = $db->get()->row_array();

        return $query;
    }

    /**
     * 添加 TOKEN
     *
     * @param $array 公众号信息
     *        	return 受影响行数
     */
    public function addToken($array)
    {
        $db = $this->db_write();
        $db->insert('authority_valify_tokens', $array);
        return $db->insert_id();
    }

    /**
     * 更新 TOKEN
     *
     * @param $fitter
     * @param $array
     * @return
     */
    public function updateToken($fitter,$array)
    {
        $db = $this->db_write();
        $db->where($fitter);
        $db->update('authority_valify_tokens', $array);
        return $db->affected_rows();
    }
}
