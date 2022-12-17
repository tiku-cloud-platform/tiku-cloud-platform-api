<?php
declare(strict_types = 1);

namespace App\Library\WeChat;

use EasyWeChat\Factory;
use EasyWeChat\MiniProgram\Application;
use Predis\Client;
use Symfony\Component\Cache\Adapter\RedisAdapter;

/**
 * 微信小程序
 */
class WeChatMiNi
{
    /**
     * 获取wechat实例
     * @return Application
     */
    public static function getInstance(): Application
    {
        $config      = [
            'app_id' => 'wxd9f531131711833d',
            'secret' => 'f2c57403ce2e3806795ba906d1a9e531',
            'response_type' => 'array',
            'log' => [
                'level' => 'debug',
                'file' => __DIR__ . '/wechat.log',
            ],
        ];
        $redisConfig = config("redis")["default"];
        $url         = "tcp://{$redisConfig['host']}:{$redisConfig['port']}";
        $redis       = new Client($url);
        if (!empty($redisConfig["auth"])) {
            $redis->auth($redisConfig["auth"]);
        }
        $cache = new RedisAdapter($redis);

        $app = Factory::miniProgram($config);
        $app->rebind("cache", $cache);
        return $app;
    }
}