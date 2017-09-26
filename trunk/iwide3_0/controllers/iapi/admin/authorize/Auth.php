<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Auth extends MY_Admin_Iapi
{
    const SUCCESS = 1;//成功
    const FAIL_AUTO = 2;//失败自动消失
    const FAIL_ALTER = 3;//失败 需要点击确认
    const UN_LOGIN = 4;//未登录
    const UN_KNOWN = 5;//未知错误
    const INTER_STOP = 6;//公众号已停止服务
    const PARAM_ERROR = 10;//参数错误
    const UN_OP = 11;//参数错误

	public $common_data;
	public $openid;
	public $module;
	public $default_skin='default';
    const TOKEN_KEY = 'JFK！@#7s8ash52hs5h3s3login';
    const INTER_ID = 'a429262688';
    const OUT_TIME_VALUE = 300;
	public function __construct()
    {
		parent::__construct ();
		$this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
		$this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
        $this->load->helper('appointment');//加载所需函数
        header('content-type:application/json;charset=utf-8');//定义文本输出返回格式
        $this->admin_profile = $this->session->userdata('admin_profile');
	}

    /**
     * 生成登录二维码 接口
     */
    public function createQrCode()
    {
        $this->load->model('authority/valify_tokens_model');
        $add = array(
            'type' => 1,
            'create_time' => date('Y-m-d H:i:s'),
            'expire_time' => time() + self::OUT_TIME_VALUE,//5分钟失效
        );

        $add['token'] = MD5(getMillisecond() . self::TOKEN_KEY);
        $row = $this->valify_tokens_model->addToken($add);
        //创建成功
        if ($row > 0)
        {
            $this->config->load('authorize', TRUE);
            $authorize = $this->config->item('authorize');
            $host = $authorize['authority_show_url'];//获取配置前台URL
            $host = empty($host) ? 'http://zb.jinfangka.cn/' : $host;

            $text = $host . 'index.php/authority/auth/login?id='.self::INTER_ID.'&token='.$add['token'];
            $ajaxData = array(
                'imgUrl' => site_url('/authorize/auth/showAuthQr?url=').urlencode($text),
                'expire_time' => $add['expire_time'],
            );
            $this->out_put_msg(self::SUCCESS,'成功',$ajaxData);
        }
        else
        {
            $this->out_put_msg(self::FAIL_AUTO,'生成二维码失败');
        }
    }


    /**
     * 获取二维码扫码 状态
     */
    public function checkCodeStatus()
    {
        $param = request();
        $token = !empty($param['token']) ? addslashes($param['token']) : '';
        $oath_para['app_id'] = !empty($param['app_id']) ? addslashes(trim($param['app_id'])) : '';
        $oath_para['state'] = !empty($param['state']) ? addslashes(trim($param['state'])) : '';
        $oath_para['scope'] = !empty($param['scope']) ? addslashes(trim($param['scope'])) : '';
        $oath_para['redirect_uri'] = !empty($param['redirect_uri']) ? addslashes($param['redirect_uri']) : '';

        if (empty($token))
        {
            $this->out_put_msg(self::FAIL_AUTO,'参数错误');
        }

        foreach ($oath_para as $pk=>$para)
        {
            if (is_null($para)||$para==='')
            {
                $this->out_put_msg(self::FAIL_AUTO,'缺少参数');
            }
        }

        if (!$redirect_uri = base64_decode($oath_para['redirect_uri']))
        {
            $this->out_put_msg(self::FAIL_AUTO,'redirect_uri格式错误');
        }

        $cache = $this->_load_cache();
        $redis = $cache->redis->redis_instance();

        //获取token
        $redis->select(10);
        $token = $redis->get('authorityQrCode_1_'.$token);//获取缓存
        if (!empty($token))
        {
            $token = json_decode($token,true);
            if ($token['status'] == 1)
            {
                $this->out_put_msg('scan_success','扫码成功！');
            }
            else if ($token['status'] == 2 && $token['admin_id'])
            {
                $redir_domain = get_url_domain($redirect_uri);
                $this->load->model ( 'application/Application_info_model' );
                $app_info = $this->Application_info_model->get_application ( $oath_para['app_id'], 1 );
                if (!$app_info)
                {
                    $this->out_put_msg(self::FAIL_AUTO,'appid参数错误');
                }

                if (empty($app_info['white_domains']))
                {
                    $this->out_put_msg(self::FAIL_AUTO,'app域名配置错误');
                }
                $white_domains=explode(',', $app_info['white_domains']);
                if (!in_array($redir_domain, $white_domains))
                {
                    $this->out_put_msg(self::FAIL_AUTO,'redirect_uri域名错误');
                }

                $this->load->model('authority/authority_accounts_model');
                //获取用户信息
                $admin = $this->authority_accounts_model->getOne('*',array('admin_id' => $token['admin_id'],'status' => 1,'bind_status' => 1),false);
                if (empty($admin))
                {
                    $this->out_put_msg(self::FAIL_AUTO,'用户不存在');
                }
                $result = $this->accountAuth($admin);
                if (!empty($result))
                {
                    //查询公众号运行状态
                    $this->setFlashData($result['inter_id']);
                }

                $this->load->model('authority/Valify_tokens_model');
                $oauth_code=$this->Valify_tokens_model->tokenAddAdapter(3,array('admin_id'=>$admin->m_get('admin_id'),'app_id'=>'a5cfb5d96b','valify_data'=>array('username'=>$admin->m_get('username'))));
                if($redirect_uri)
                {
                    if (strpos ( $redirect_uri, '?' ))
                    {
                        $redirect_uri.='&icode='.$oauth_code;
                    }
                    else
                    {
                        $redirect_uri.='?icode='.$oauth_code;
                    }
                    $redirect_uri.='&state='.$oath_para['state'];
                }

                $ajaxData = array(
                    'url' => $redirect_uri,
                );
                $this->out_put_msg(self::SUCCESS,'登录成功！',$ajaxData);
            }
        }
        else
        {
            $this->out_put_msg(self::FAIL_AUTO,'未扫码！');
        }
    }


    /**
     * 账号密码登录 登录时整合旧版系统 密码不加盐逻辑
     */
    public function accountLogin()
    {
        $param = request();
        $username = !empty($param['username']) ? addslashes(trim($param['username'])) : '';
        $password = !empty($param['password']) ? addslashes(trim($param['password'])) : '';
        $oath_para['app_id'] = !empty($param['app_id']) ? addslashes(trim($param['app_id'])) : '';
        $oath_para['state'] = !empty($param['state']) ? addslashes(trim($param['state'])) : '';
        $oath_para['scope'] = !empty($param['scope']) ? addslashes(trim($param['scope'])) : '';
        $oath_para['redirect_uri'] = !empty($param['redirect_uri']) ? addslashes($param['redirect_uri']) : '';

        foreach ($oath_para as $pk=>$para)
        {
            if (is_null($para)||$para==='')
            {
                $this->out_put_msg(self::FAIL_AUTO,'缺少参数');
            }
        }

        if (!$redirect_uri = base64_decode($oath_para['redirect_uri']))
        {
            $this->out_put_msg(self::FAIL_AUTO,'redirect_uri格式错误');
        }

        $redir_domain = get_url_domain($redirect_uri);
        $this->load->model ( 'application/Application_info_model' );
        $app_info = $this->Application_info_model->get_application ( $oath_para['app_id'], 1 );
        if (!$app_info)
        {
            $this->out_put_msg(self::FAIL_AUTO,'appid参数错误');
        }

        if (empty($app_info['white_domains']))
        {
             $this->out_put_msg(self::FAIL_AUTO,'app域名配置错误');
        }
        $white_domains=explode(',', $app_info['white_domains']);
        if (!in_array($redir_domain, $white_domains))
        {
            $this->out_put_msg(self::FAIL_AUTO,'redirect_uri域名错误');
        }

        if (empty($username))
        {
            $this->out_put_msg(self::FAIL_AUTO,'请输入用户名');
        }

        if(empty($password))
        {
            $this->out_put_msg(self::FAIL_AUTO,'请输入密码');
        }

        $this->load->model('authority/authority_accounts_model');
        //校验用户名是否存在
        $admin = $this->authority_accounts_model->getOne('*',array('username' => $username,'status' => 1));
        if (empty($admin))
        {
            $this->out_put_msg(self::FAIL_AUTO,'用户不存在');
        }
        else if($admin['password'] != do_hash($password . $admin['passsalt']))
        {
            $this->out_put_msg(self::FAIL_AUTO,'登录密码错误');
        }

        $result = $this->accountAuth($admin);

        if (!empty($result))
        {
            //恢复密码秘钥
            $whereUpdate = array(
                'admin_id' => $admin['admin_id'],
                'passsalt' => '',
            );
            $passsalt = getRandomCode(8);
            $update = array(
                'password' => do_hash($password . $passsalt),
                'passsalt' => $passsalt,
            );
            $this->authority_accounts_model->saveAccount($whereUpdate,$update);

            //查询公众号运行状态
            $this->setFlashData($result['inter_id']);

            $this->load->model('authority/Valify_tokens_model');
            $oauth_code=$this->Valify_tokens_model->tokenAddAdapter(3,array('admin_id'=>$admin->m_get('admin_id'),'app_id'=>'a5cfb5d96b','valify_data'=>array('username'=>$admin->m_get('username'))));
            if($redirect_uri)
            {
                if (strpos ( $redirect_uri, '?' ))
                {
                    $redirect_uri.='&icode='.$oauth_code;
                }
                else
                {
                    $redirect_uri.='?icode='.$oauth_code;
                }
                $redirect_uri.='&state='.$oath_para['state'];
            }

            $this->out_put_msg(self::SUCCESS,'登录成功',array('url'=>$redirect_uri));
        }
        $this->out_put_msg(self::FAIL_AUTO,'登录失败');
    }

    /**
     * 处理登录
     * @param $admin
     * @return bool
     */
    protected function accountAuth($admin)
    {
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
            if (empty($role))
            {
                $this->out_put_msg(self::FAIL_AUTO,'登录的公众号未分配角色');
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
            $authorities = $this->roles_model->login_authority($admin['inter_id'],$roleId);
            //设置登录缓存
            $this->session->account_login($admin, $authorities);

            return $admin;
        }

        return false;
    }

    /**
     * 查询公众号运行状态
     * @param $inter_id
     */
    protected function setFlashData($inter_id)
    {
        // @Editor lGh 查询公众号运行状态
        if ($inter_id && $inter_id != FULL_ACCESS)
        {
            $this->load->model('wx/Public_admin_model');
            $check = $this->Public_admin_model->check_publics_runstatus($inter_id,'arrear');
            if (isset($check[$inter_id]))
            {
                $this->session->set_flashdata('is_arreared', 1);
                if($check[$inter_id]['run_status'] == "arrearage")
                {
                    $stop_date = date("Y年m月d日",strtotime($check[$inter_id]['stop_service_time']));
                    $msg = "{$check[$inter_id]['name']}，您已欠费{$check[$inter_id]['arrearage_money']}元，将于{$stop_date}停止微信系统服务，为了不影响您的正常业务运作，请及时结算！";
                    $this->session->set_flashdata('arrear_tips', $msg);
                }
                else if($check[$inter_id]['run_status'] == "stop")
                {
                    $msg = "{$check[$inter_id]['name']}，您欠费{$check[$inter_id]['arrearage_money']}元，已经停止微信系统服务。请您及时补缴所欠费用，以便恢复微信系统服务！";
                    $this->session->set_flashdata('arrear_tips', $msg);
                }

            }
        }
    }

    /**
     * 加载缓存
     * @param string $name
     * @return mixed
     */
    protected function _load_cache($name='Cache')
    {
        if(!$name || $name=='cache')
            $name='Cache';
        $this->load->driver('cache', array('adapter' => 'redis', 'backup' => 'file', 'key_prefix' => 'dis_ato_'), $name );
        return $this->$name;
    }
}