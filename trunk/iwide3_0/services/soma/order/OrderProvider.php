<?php

namespace App\services\soma\order;
use App\services\soma\contract\OrderContract;

/**
 * Class OrderProvider
 * @package App\services\soma\order
 * @author renshuai  <renshuai@mofly.cn>
 *
 */
class OrderProvider
{
    /**
     * 普通
     */
    const NORMAL_SETTLEMENT = 'default';

    /**
     * 秒杀
     */
    const KILLSEC_SETTLEMENT = 'killsec';

    /**
     * 拼团
     */
    const GROUPON_SETTLEMENT = 'groupon';

    /**
     * @param array $arr
     * @return AbstractOrder|OrderContract
     * @author renshuai  <renshuai@mofly.cn>
     */
    public function resolve(Array $arr)
    {
        if (empty($arr) || !isset($arr['settlement'])) {
            throw new \RuntimeException('没找到对应的下单类');
        }

        if ($arr['settlement'] === self::KILLSEC_SETTLEMENT) {
            $order = new KillsecOrder();
        } elseif ($arr['settlement'] === self::NORMAL_SETTLEMENT) {
            $order = new NormalOrder();
        } elseif ($arr['settlement'] === self::GROUPON_SETTLEMENT) {
            $order = new GrouponOrder();
        } else {
            throw new \RuntimeException('没找到对应的下单类');
        }

        return $order;
    }
}