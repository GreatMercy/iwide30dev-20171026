<?php

/**
 * User: renshuai <renshuai@mofly.cn>
 * Date: 2017/3/2
 * Time: 14:15
 *
 * @property MY_Cache_redis $redis
 * @property CI_Cache_file $file
 */
class MY_Cache extends CI_Cache
{
    /**
     * @var string
     */
    public $active_group = '';

    /**
     * MY_Cache constructor.
     * @param array $config
     */
    public function __construct($config = array())
    {
        $default_config = array(
            'adapter',
            'memcached'
        );

        foreach ($default_config as $key)
        {
            if (isset($config[$key]))
            {
                $param = '_'.$key;

                $this->{$param} = $config[$key];
            }
        }

        isset($config['key_prefix']) && $this->key_prefix = $config['key_prefix'];
        isset($config['active_group']) && $this->active_group = $config['active_group'];

        if (isset($config['backup']) && in_array($config['backup'], $this->valid_drivers))
        {
            $this->_backup_driver = $config['backup'];
        }

        // If the specified adapter isn't available, check the backup.
        if ( ! $this->is_supported($this->_adapter, $this->active_group))
        {
            if ( ! $this->is_supported($this->_backup_driver, $this->active_group))
            {
                // Backup isn't supported either. Default to 'Dummy' driver.
                log_message('error', 'Cache adapter "'.$this->_adapter.'" and backup "'.$this->_backup_driver.'" are both unavailable. Cache is now using "Dummy" adapter.');
                $this->_adapter = 'dummy';
            }
            else
            {
                // Backup is supported. Set it to primary.
                log_message('debug', 'Cache adapter "'.$this->_adapter.'" is unavailable. Falling back to "'.$this->_backup_driver.'" backup adapter.');
                $this->_adapter = $this->_backup_driver;
            }
        }
    }

    /**
     * @param string $driver
     * @param string $active_group
     * @return mixed
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function is_supported($driver, $active_group ='')
    {
        static $support = array();

        if ( ! isset($support[$driver]))
        {
            $support[$driver] = $this->{$driver}->is_supported($active_group);
        }

        return $support[$driver];
    }
}