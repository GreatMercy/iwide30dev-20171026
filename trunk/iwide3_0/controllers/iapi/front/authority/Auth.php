<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Auth extends MY_Front_Iapi
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
	public function __construct()
    {
		parent::__construct ();
		$this->common_data ['csrf_token'] = $this->security->get_csrf_token_name ();
		$this->common_data ['csrf_value'] = $this->security->get_csrf_hash ();
        $this->load->helper('appointment');//加载所需函数
        header('content-type:application/json;charset=utf-8');//定义文本输出返回格式
	}

    /**
     * 绑定微信账号 接口
     */
    public function bindAccount()
    {
        $param = request();
        $token = !empty($param['token']) ? addslashes($param['token']) : '';
        if (empty($token))
        {
            $this->out_put_msg(self::FAIL_AUTO,'参数错误');
        }

        //获取token
        $this->load->model('authority/valify_tokens_model');
        $where = array(
            'openid' => $this->openid,
            'status' => 1,
            'type'   => 2,
            'token'  => $token,
        );
        $token = $this->valify_tokens_model->getOne('id,admin_id,expire_time', $where);
        if (empty($token))
        {
            $this->out_put_msg(self::FAIL_AUTO,'非法操作');
        }

        //判断二维码时效性
        if ($token['expire_time'] < time())
        {
            $this->out_put_msg(self::FAIL_AUTO,'绑定时间已过期，请重新扫码绑定');
        }

        //获取账户信息
        $this->load->model('authority/authority_accounts_model');
        $account = $this->authority_accounts_model->getOne('admin_id,bind_status',array('admin_id' => $token['admin_id']));
        if (empty($account))
        {
            $this->out_put_msg(self::FAIL_AUTO,'绑定失败，绑定账号不存在');
        }
        else if($account['bind_status'] == 1)
        {
            $this->out_put_msg(self::FAIL_AUTO,'绑定失败,账号已被绑定');
        }

        //绑定微信
        $update = array(
            'openid'        => $this->openid,
            'wx_nickname'   => !empty($this->user['nickname']) ? $this->user['nickname'] : '',
            'head_pic'      => !empty($this->user['headimgurl']) ? $this->user['headimgurl'] : '',
            'bind_status'   => 1,
            'update_time'   => date('Y-m-d H:i:s'),
        );

        $whereUpdate = array(
            'admin_id'      => $account['admin_id'],
            'bind_status'   => 0,
        );
        $resRow = $this->authority_accounts_model->saveAccount($whereUpdate,$update);
        if ($resRow > 0)
        {
            //设置绑定状态和时间
            $this->valify_tokens_model->updateToken(array('id' => $token['id']), array('status' => 2,'success_time' => date('Y-m-d H:i:s')));
            $this->out_put_msg(self::SUCCESS,'绑定成功');
        }

        $this->out_put_msg(self::FAIL_AUTO,'绑定失败,账号已被绑定');
    }

    /**
     * 获取微信号下的绑定账户 接口
     */
    public function getAccount()
    {
        $param = request();
        $token = !empty($param['token']) ? addslashes($param['token']) : '';
        if (empty($token))
        {
            $this->out_put_msg(self::FAIL_AUTO,'参数错误');
        }
        $this->load->model('authority/authority_accounts_model');

        $account = $this->authority_accounts_model->getAccounts('admin_id,username,head_pic',  array('openid' => $this->openid,'status' => 1,'bind_status' => 1));
        if (!empty($account))
        {
            $ajaxData = array(
                'list' => $account,
                'user_info' => $this->user,
            );
            $this->out_put_msg(self::SUCCESS,'成功',$ajaxData);
        }
        else
        {
            $this->out_put_msg(self::FAIL_AUTO,'暂无数据');
        }
    }

    /**
     * 二维码确认登录 接口
     */
    public function qrLogin()
    {
        $param = $this->get_source();
        $request = request();
        if (!empty($request))
        {
            $param = array_merge($param,$request);
        }

        $adminId = !empty($param['admin_id']) ? intval($param['admin_id']) : '';
        $token = !empty($param['token']) ? addslashes($param['token']) : '';

        if (empty($adminId) || empty($token))
        {
            $this->out_put_msg(self::FAIL_AUTO,'参数错误');
        }

        //获取token
        $this->load->model('authority/valify_tokens_model');
        $where = array(
            'openid' => $this->openid,
            'status' => 1,
            'type'   => 1,
            'token'  => $token,
        );
        $token = $this->valify_tokens_model->getOne('id,expire_time,token', $where);
        if (empty($token))
        {
            $this->out_put_msg(self::SUCCESS,'您已经登录成功');
        }

        //判断二维码时效性
        if ($token['expire_time'] < time())
        {
            $this->out_put_msg(self::FAIL_AUTO,'二维码已失效');
        }

        $this->load->model('authority/authority_accounts_model');
        //校验用户名是否存在
        $admin = $this->authority_accounts_model->getOne('*',array('admin_id' => $adminId,'openid' => $this->openid,'status' => 1,'bind_status' => 1),false);
        if (empty($admin))
        {
            $this->out_put_msg(self::FAIL_AUTO,'用户不存在');
        }

        //设置绑定状态和时间
        $this->valify_tokens_model->updateToken(array('id' => $token['id']), array('admin_id'=> $admin['admin_id'],'status' => 2,'success_time' => date('Y-m-d H:i:s')));

        $cache = $this->_load_cache();
        $redis = $cache->redis->redis_instance();
        $redis->select(10);

        //设置状态缓存
        $update = array(
            'status' => 2,
            'admin_id' => $adminId,
        );
        $redis->set('authorityQrCode_1_'.$token['token'],json_encode($update),300);//设置缓存

        $this->out_put_msg(self::SUCCESS,'登录成功');
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