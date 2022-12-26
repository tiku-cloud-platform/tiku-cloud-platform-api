<?php
declare(strict_types = 1);

namespace App\Library\WeChat;

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
        $config      = [
            'app_id' => 'wx24062428b4883952',
            'secret' => '7852162b42b3e570bb451779bc97d1ca',
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