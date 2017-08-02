<?php

/**
 * User: renshuai <renshuai@mofly.cn>
 * Date: 2017/3/1
 * Time: 18:03
 *
 */
class MY_Cache_redis extends CI_Cache_redis
{
    //定义使用的数据库
    public function select_db($db)
    {
        $this->_redis->select($db);
        return $this;
    }

    //调用此方法获得redis实例，使用后必须调用 $redis->close() 释放资源
    public function redis_instance()
    {
        return $this->_redis;
    }

    /**
     * Check if Redis driver is supported
     * @param string $active_group
     * @return	bool
     */
    public function is_supported($active_group = '')
    {
        if ( ! extension_loaded('redis'))
        {
            log_message('debug', 'The Redis extension must be loaded to use Redis cache.');
            return FALSE;
        }

        return $this->_setup_redis($active_group);
    }

    /**
     * @param string $active_group
     * @return bool
     * @author renshuai  <renshuai@mofly.cn>
     */
    protected function _setup_redis($active_group = '')
    {
        $config = array();
        $CI =& get_instance();

        if ($CI->config->load('redis', TRUE, TRUE))
        {
            $config_redis = $CI->config->item('redis');
            $config += $config_redis;
            if (! empty($active_group) && isset($config_redis[$active_group])) {
                $config = $config_redis[$active_group];
            }
        }

        $config = array_merge(self::$_default_config, $config);

        $this->_redis = new Redis();

        try
        {
            if ($config['socket_type'] === 'unix')
            {
                $success = $this->_redis->connect($config['socket']);
            }
            else // tcp socket
            {
                $success = $this->_redis->connect($config['host'], $config['port'], $config['timeout']);
            }

            if ( ! $success)
            {
                log_message('debug', 'Cache: Redis connection refused. Check the config.');
                return FALSE;
            }
        }
        catch (RedisException $e)
        {
            log_message('debug', 'Cache: Redis connection refused ('.$e->getMessage().')');
            return FALSE;
        }

        if (isset($config['password']))
        {
            $this->_redis->auth($config['password']);
        }

        if (isset($config['cachedb'])) {
            $this->_redis->select($config['cachedb']);
        }
        
        // Initialize the index of serialized values.
        $serialized = $this->_redis->sMembers('_ci_redis_serialized');
        if ( ! empty($serialized))
        {
            $this->_serialized = array_flip($serialized);
        }

        return TRUE;
    }


}