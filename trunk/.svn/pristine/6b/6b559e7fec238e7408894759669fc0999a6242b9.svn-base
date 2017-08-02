<?php

namespace App\facades;

/**
 * Class Base
 * @package App\facades
 *
 */
class Base
{
    /**
     * @var \CI_Controller
     */
    static private $ci;

    public static function getFacadeRoot()
    {
        if (empty($ci)) {
            self::$ci = &get_instance();
        }
        $facadeAccessor = static::getFacadeAccessor();
        if (! self::$ci) {
            throw new \RuntimeException('A facade accessor has not been set.');
        }
        return self::$ci->$facadeAccessor;
    }

    protected static function getFacadeAccessor()
    {
        throw new \RuntimeException('Facade does not implement getFacadeAccessor method.');
    }

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     *
     */
    static public function __callStatic($method, $arguments)
    {
        $instance = static::getFacadeRoot();
        if (! $instance) {
            throw new \RuntimeException('A facade root has not been set.');
        }

        return call_user_func_array([$instance, $method], $arguments);

    }
}