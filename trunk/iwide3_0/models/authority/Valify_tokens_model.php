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
    
    /**根据type插入token
     * @param unknown $tokenType
     * @param array $params
     * @return boolean|unknown
     */
    public function tokenAddAdapter($tokenType,$params=array()) {
        $this->load->library ( 'authority/authorityConst' );
        if (! isset ( authorityConst::$valifyTokenTypes [$tokenType] )) {
            return FALSE;
        }
        $this->load->library ( 'authority/authorityLib' );
        $data = array (
                'type' => $tokenType,
                'create_time' => date ( 'Y-m-d H:i:s' ) 
        );
        $config = isset ( authorityConst::$valifyTokenConfig [$tokenType] ) ? authorityConst::$valifyTokenConfig [$tokenType] : authorityConst::$valifyTokenConfig ['default'];
        $data ['expire_time'] = time () + $config ['ttl'];
        $lib=new authorityLib();
        $method = 'creatValifyToken' . $tokenType;
        if (method_exists ( $lib, $method )) {
            $data ['token'] = $lib::$method ();
        } else {
            $data ['token'] = $lib::creatValifyToken ();
        }
        isset($params['admin_id']) and $data['admin_id']=$params['admin_id'];
        isset($params['openid']) and $data['openid']=$params['openid'];
        isset($params['app_id']) and $data['app_id']=$params['app_id'];
        isset($params['valify_data']) and $data['valify_data']=json_encode($params['valify_data']);
        $db = $this->db_write ();
        if ($db->insert ( authorityConst::TAB_VALIFY_TOKENS, $data )) {
            return $data ['token'];
        }
        return FALSE;
    }
    /**更新token后再取值
     * @param unknown $tokenType
     * @param unknown $token
     * @return number[]|unknown[]|number[]|string[]
     */
    public function upGetToken($tokenType, $token) {
        $now = time ();
        $updata = array (
                'status' => 1,
                'operate_time' => date ( 'Y-m-d H:i:s' ) 
        );
        $filter = array (
                'type' => $tokenType,
                'token' => $token,
                'status' => 0,
                'expire_time >=' => $now 
        );
        $this->load->library ( 'authority/authorityConst' );
        $db = $this->db_write ();
        $db->where ( $filter );
        $db->update ( authorityConst::TAB_VALIFY_TOKENS, $updata );
        $update_row = $db->affected_rows ();
        $db->limit ( 1 );
        $db->where ( array (
                'type' => $tokenType,
                'token' => $token 
        ) );
        $data = $db->get ( authorityConst::TAB_VALIFY_TOKENS )->row_array ();
        $err = 'none';
        if ($data) {
            if ($update_row > 0) {
                return array (
                        's' => 1,
                        'token' => $data 
                );
            } else if ($data ['status'] != 0) {
                $err = 'used';
            } else if ($data ['expire_time'] < $now) {
                $err = 'expired';
            }
        }
        return array (
                's' => 0,
                'err' => $err 
        );
    }
}
