<?php
declare(strict_types = 1);

namespace App\Library\WeChat;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\Request\RequestApp;
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
        // 从Redis中获取appid和app_secret
        $miniConfig = RedisClient::getInstance()->hMGet(CacheKey::STORE_MINI_SETTING . RequestApp::getStoreUuid(), [
            "name", "app_key", "app_secret"
        ]);

        $config      = [
            'app_id' => $miniConfig["app_key"],
            'secret' => $miniConfig["app_secret"],
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
        // 添加一个缓存前缀，避免缓存的key是同一个，被强制刷走
        $cache = new RedisAdapter($redis, mb_substr(md5(RequestApp::getStoreUuid()), 0, 10));

        $app = Factory::miniProgram($config);
        $app->rebind("cache", $cache);
        return $app;
    }
}