<?php
declare(strict_types = 1);

namespace App\Task\Sign;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\UUID;
use App\Model\Shell\StoreUserScoreCollection;
use App\Model\Shell\StoreUserScoreHistory;
use App\Model\Shell\StoreUserSignCollection;
use Hyperf\Crontab\Annotation\Crontab;
use Hyperf\DbConnection\Db;

/**
 * @Crontab(name="sign_task", rule="* * * * * *", callback="execute", memo="用户签到处理队列")
 */
class SignTask
{
    public function execute()
    {
//        "user_uuid" => UserLoginInfo::getUserId(),
//        "store_uuid" => RequestApp::getStoreUuid(),
//        "client_type" => 1,
//        "score" => $score["score"],
//        "day" => $days,// 连续签到天数
        $value = RedisClient::getInstance()->rPop(CacheKey::SIGN_QUEUE);
        if (!empty($value)) {
            $value = json_decode($value, true);
            // 创建积分历史记录，更新连续签到天数，更新积分汇总
            $row = 0;
            Db::transaction(function () use ($value, &$row) {
                $userScoreHistory = new StoreUserScoreHistory();
                $userScoreHistory::query()->create([
                    "client_type" => $value["client_type"],
                    "uuid" => UUID::getUUID(),
                    "type" => 1,
                    "title" => "签到积分",
                    "score" => $value["score"],
                    "user_uuid" => $value["user_uuid"],
                    "store_uuid" => $value["store_uuid"],
                ]);
                (new StoreUserSignCollection())::query()->where([
                    ["user_uuid", "=", $value["user_uuid"]],
                    ["store_uuid", "=", $value["store_uuid"]],
                ])->update(["sign_number" => $value["day"]]);
                (new StoreUserScoreCollection())::where([
                    ["user_uuid", "=", $value["user_uuid"]],
                    ["store_uuid", "=", $value["store_uuid"]],
                ])->increment("score", $value["score"]);
                $row = 1;
            }, 2);
            if ($row < 1) {
                RedisClient::getInstance()->lPush(CacheKey::SIGN_QUEUE, json_encode($value, JSON_UNESCAPED_UNICODE));
            }
        }
    }
}