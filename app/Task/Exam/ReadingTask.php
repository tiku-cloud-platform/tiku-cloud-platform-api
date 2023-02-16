<?php
declare(strict_types = 1);

namespace App\Task\Exam;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\UUID;
use App\Model\Shell\StoreUserScoreCollection;
use App\Model\Shell\StoreUserScoreHistory;
use Hyperf\Crontab\Annotation\Crontab;
use Hyperf\DbConnection\Db;
use Throwable;

/**
 * @Crontab(name="reading_task", rule="* * * * * *" , callback="execute", memo="用户问答试题积分")
 */
class ReadingTask
{
    public function execute()
    {
        // 积分历史记录，积分汇总
        $value = RedisClient::getInstance()->lPop(CacheKey::EXAM_READING);
        if (!empty($value)) {
            $value = json_decode($value, true);
            Db::beginTransaction();
            $scoreModel = new StoreUserScoreHistory();
            try {
                if (!empty($value["income_score"])) {
                    $scoreModel::query()->create([
                        "client_type" => $value["client_type"],
                        "uuid" => UUID::getUUID(),
                        "title" => "答题积分",
                        "type" => 1,
                        "score" => $value["income_score"],
                        "user_uuid" => $value["user_uuid"],
                        "store_uuid" => $value["store_uuid"],
                    ]);
                }
                if (!empty($value["expend_score"])) {
                    $scoreModel::query()->create([
                        "client_type" => $value["client_type"],
                        "uuid" => UUID::getUUID(),
                        "title" => "答题积分",
                        "type" => 2,
                        "score" => $value["expend_score"],
                        "user_uuid" => $value["user_uuid"],
                        "store_uuid" => $value["store_uuid"],
                    ]);
                }
                RedisClient::getInstance()->incrByFloat(CacheKey::SCORE_TOTAL . $value["user_uuid"], $value["income_score"] - $value["expend_score"]);
                (new StoreUserScoreCollection())::query()->where([
                    ["user_uuid", "=", $value["user_uuid"]],
                    ["store_uuid", "=", $value["store_uuid"]],
                ])->increment("score", $value["income_score"] - $value["expend_score"]);
                Db::commit();
            } catch (Throwable $throwable) {
                RedisClient::getInstance()->lPush(CacheKey::EXAM_READING, json_encode($value, JSON_UNESCAPED_UNICODE));
                Db::rollBack();
            }
        }
    }
}