<?php
declare(strict_types = 1);

namespace App\Task\Register;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\UUID;
use App\Model\Shell\StoreUserScoreCollection;
use App\Model\Shell\StoreUserScoreHistory;
use Hyperf\Crontab\Annotation\Crontab;
use Hyperf\DbConnection\Db;

/**
 * @Crontab(name="register_task", rule="* * * * * *", memo="用户注册积分任务", callback="executre")
 */
class RegisterTask
{
    public function execute()
    {
        // 添加积分历史，更新积分汇总
        $value = RedisClient::getInstance()->lPop(CacheKey::USER_REGISTER);
        if (!empty($value)) {
            $value = json_decode($value, true);
            $row   = 0;
            Db::transaction(function () use ($value, &$row) {
                $userScoreHistory = new StoreUserScoreHistory();
                $userScoreHistory::query()->create([
                    "client_type" => 1,
                    "uuid" => UUID::getUUID(),
                    "type" => 1,
                    "title" => "新用户注册",
                    "score" => 200,
                    "user_uuid" => $value["user_uuid"],
                    "store_uuid" => $value["store_uuid"],
                ]);
                (new StoreUserScoreCollection())::query()->where([
                    ["user_uuid", "=", $value["user_uuid"]],
                    ["store_uuid", "=", $value["store_uuid"]],
                ])->increment("score", 200);
                RedisClient::getInstance()->incrByFloat(CacheKey::SCORE_TOTAL . $value["user_uuid"], 200);
                $row = 1;
            }, 2);
            if ($row < 1) {
                RedisClient::getInstance()->lPush(CacheKey::USER_REGISTER, json_encode($value, JSON_UNESCAPED_UNICODE));
            }
        }
    }
}