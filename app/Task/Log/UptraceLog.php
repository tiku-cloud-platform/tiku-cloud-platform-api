<?php
declare(strict_types = 1);

namespace App\Task\Log;

use App\Library\Log\UptraceClient;
use App\Mapping\RedisClient;
use Hyperf\Crontab\Annotation\Crontab;

/**
 * @Crontab(rule="* * * * * *", name="log_queue", callback="execute", memo="发送日志到uptrace")
 */
class UptraceLog
{
    public function execute()
    {
        $value = RedisClient::getInstance()->lPop("log_queue");
        if (!empty($value)) {
            $value = json_decode($value, true);
            (new UptraceClient())->sendLog($value);
        }
    }
}