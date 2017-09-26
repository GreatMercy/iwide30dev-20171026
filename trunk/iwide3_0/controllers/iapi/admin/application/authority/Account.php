<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Account extends MY_Application_Admin_Iapi {
    public function __construct() {
        parent::__construct ();
    }
    public function test_session() {
        // $this->set_user_session('test_sess', 1,30);
        $user_info = $this->user_session ( '' );
        $data = $this->get_source ();
        echo json_encode ( array (
                'session_data' => $user_info,
                'your_data' => $data 
        ) );
    }

    /**
     * 处理登录
     * @return bool
     */
    public function admin_session()
    {
        $data = $this->get_source ();
        $username = $this->user_session ('username');
        $this->write_log('app_login','admin_session',json_encode($data));
        $this->write_log('app_login','admin_session',json_encode($username));
        if (empty($user_info))
        {
            return '无数据返回';
        }

        $this->load->model('authority/authority_accounts_model');
        //获取用户信息
        $admin = $this->authority_accounts_model->getOne('*',array('username' => $username,'status' => 1),false);
        $this->write_log('app_login','userInfo',json_encode($admin));
        //获取账号下的公众号
        $this->load->model('authority/accounts_entities_model');
        $entities = $this->accounts_entities_model->accountEntities(array('admin_id' => $admin['admin_id']));
        if (!empty($entities))
        {
            foreach ($entities as $item)
            {
                $tmp = array(
                    'inter_id' => $item['inter_id'],
                    'name' => $item['inter_name'],
                    'is_default' => $item['is_default'],
                );

                //获取默认
                if ($item['is_default'] == 1)
                {
                    $interId = $item['inter_id'];
                    $entityIds = $item['entity_id'];
                    $roleId = $item['role_id'];
                }
                $admin['publics'][$item['inter_id']] = $tmp;
            }


            $admin['inter_id'] = !empty($interId) ? $interId : $entities[0]['inter_id'];
            $entityIds = !empty($entityIds) ? $entityIds : $entities[0]['entity_id'];
            $roleId = !empty($roleId) ? $roleId : $entities[0]['role_id'];

            //查询角色名称
            $role = $this->authority_accounts_model->getRoles('role_id,role_name', array('role_id' => $roleId), false);
            $this->write_log('app_login','role',json_encode($role));
            if (empty($role))
            {
                return false;
            }

            $role['role_label'] = $role['role_name'];
            $admin['role'] = $role;
            $entityId = array();
            if (!empty($entityIds))
            {
                $entityIds = json_decode($entityIds,true);
                foreach ($entityIds as $item)
                {
                    $entityId[] = $item['hotel_id'];
                    $admin['shops'][$item['hotel_id']] = $item['shop_id'];
                }
            }
            $admin['entity_id'] = implode(',',$entityId);

            $admin['shops'] = !empty($admin['shops']) ? json_encode($admin['shops']) : '';

            //当前登录账号角色权限
            $this->load->model("authority/roles_model");
            $authorities = $this->roles_model->login_authority($admin['inter_id'],$roleId,$admin['type']);
            //设置登录缓存

            $this->write_log('app_login','key',json_encode($authorities));

            $this->session->account_login($admin, $authorities);

            $return = array(
                'account' => $admin,
                'auth' => $authorities,
            );
            echo json_encode($return);
        }

        return false;
    }


    public function get_account_publics() {
    }


    protected function write_log( $data,$re = '',$result = '',$file=NULL, $path=NULL )
    {
        if(!$file) $file= date('Y-m-d'). '.txt';
        if(!$path) $path= APPPATH. 'logs'. DS. 'authority'. DS;

        if( !file_exists($path) ) {
            @mkdir($path, 0777, TRUE);
        }

        if(is_array($data)){
            $data=json_encode($data);
        }
        if(is_array($result)){
            $result=json_encode($result);
        }
        $fp = fopen($path.$file, "a");
        $content = date("Y-m-d H:i:s")." | ".getmypid()." | ".$_SERVER['PHP_SELF']." | ".session_id()." | ".$data." | ".$re." | ".$result."\n";

        fwrite($fp, $content);
        fclose($fp);
    }
}
