<?php
declare(strict_types = 1);

namespace App\Task\Article;

use App\Constants\CacheKey;
use App\Mapping\RedisClient;
use App\Mapping\UUID;
use App\Model\Shell\StoreArticle;
use App\Model\Shell\StoreArticleReadHistory;
use App\Model\Shell\StoreUserScoreCollection;
use App\Model\Shell\StoreUserScoreHistory;
use Hyperf\Crontab\Annotation\Crontab;
use Hyperf\DbConnection\Db;
use Throwable;

/**
 * @Crontab(name="article_task", rule="* * * * * *", callback="execute", memo="增加文章阅读数量队列")
 */
class ReadTask
{
    public function execute()
    {
//        "article_uuid" => $requestParams["uuid"],
//            "store_uuid" => RequestApp::getStoreUuid(),
//            "user_uuid" => UserLoginInfo::getUserId(),
        $value = RedisClient::getInstance()->rPop(CacheKey::ARTICLE_QUEUE);
        if (!empty($value)) {
            $value        = json_decode($value, true);
            $articleModel = new StoreArticle();
            Db::beginTransaction();
            try {
                $articleModel::query()->where([["uuid", "=", $value["article_uuid"]]])->increment("read_number");// 增加文章阅读量
                (new StoreArticleReadHistory())::query()->create([
                    "uuid" => UUID::getUUID(),
                    "store_uuid" => $value["store_uuid"],
                    "article_uuid" => $value["article_uuid"],
                    "user_uuid" => $value["user_uuid"],
                ]);
                RedisClient::getInstance()->incrByFloat(CacheKey::SCORE_TOTAL . $value["user_uuid"],
                    ($value["read_score"] - $value["read_expend_score"]));// 更新Redis积分总数
                if (!empty($value["read_score"] - $value["read_expend_score"])) {
                    (new StoreUserScoreCollection())::query()->where([
                        ["user_uuid", "=", $value["user_uuid"]]
                    ])->increment("score", $value["read_score"] - $value["read_expend_score"]);// 更新数据库积分总数
                }
                // 添加积分历史
                $userScoreHistory = new StoreUserScoreHistory();
                if (!empty($value["read_score"])) {
                    $userScoreHistory::query()->create([
                        "client_type" => 1,
                        "uuid" => UUID::getUUID(),
                        "type" => 1,
                        "title" => "阅读文章",
                        "score" => $value["read_score"],
                        "user_uuid" => $value["user_uuid"],
                        "store_uuid" => $value["store_uuid"],
                    ]);
                }
                if (!empty($value["read_expend_score"])) {
                    $userScoreHistory::query()->create([
                        "client_type" => 1,
                        "uuid" => UUID::getUUID(),
                        "type" => 2,
                        "title" => "阅读文章",
                        "score" => $value["read_expend_score"],
                        "user_uuid" => $value["user_uuid"],
                        "store_uuid" => $value["store_uuid"],
                    ]);
                }
                Db::commit();
            } catch (Throwable $throwable) {
                Db::rollBack();
                RedisClient::getInstance()->incrByFloat(CacheKey::SCORE_TOTAL . $value["user_uuid"],
                    $value["read_expend_score"] - $value["read_score"]);// 回退Redis积分总数
                RedisClient::getInstance()->lPush(CacheKey::ARTICLE_QUEUE, json_encode($value, JSON_UNESCAPED_UNICODE));
            }
        }
    }
}