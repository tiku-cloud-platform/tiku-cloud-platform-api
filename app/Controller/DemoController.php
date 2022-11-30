<?php
declare(strict_types = 1);

namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;

/**
 * 演示控制器
 * @Controller(prefix="demo")
 * Class DemoController
 */
class DemoController
{
    /**
     * 测试自动部署
     */
    public function index()
    {
        echo 1;
    }

    /**
     * @GetMapping(path="get")
     */
    public function read()
    {
        $container = ApplicationContext::getContainer();
        $redis     = $container->get(Redis::class);

        for (; ;) {
            $value = $redis->decr('aaaa');
            if (empty($value) || $value < 0) {
                echo '库存不足';
                break;
            } else {
                echo $value . PHP_EOL;
            }
        }
    }
}
