<?php
declare(strict_types = 1);

namespace App\Mapping;

use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;

/**
 * Redis客户端
 *
 * Class RedisClient
 */
class RedisClient
{
    public static function getInstance()
    {
        $container = ApplicationContext::getContainer();
        return $container->get(Redis::class);
    }
}
