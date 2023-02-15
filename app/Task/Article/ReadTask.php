<?php
declare(strict_types = 1);

namespace App\Task\Article;

use App\Constants\CacheKey;
use App\Exception\DbDataMessageException;
use App\Exception\DbDuplicateMessageException;
use App\Mapping\RedisClient;
use App\Mapping\Request\UserLoginInfo;
use App\Mapping\UUID;
use App\Model\Shell\StoreArticle;
use App\Model\Shell\StoreArticleReadHistory;
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
            $value = json_decode($value, true);
            $row   = 0;
            Db::transaction(function () use ($value, &$row) {
                $articleModel = new StoreArticle();
                $article      = $articleModel::query()->where([["uuid", "=", $value["article_uuid"]]])->first(["read_score", "read_expend_score"]);
                // 增加文章阅读数量
                $row = $articleModel::query()->where([["uuid", "=", $value["article_uuid"]]])->increment("read_number");
                if (!empty($value["user_uuid"])) {
                    // 增加(减少)用户积分
                    $userScoreHistory = new StoreUserScoreHistory();
                    if (!empty($article->read_score)) {
                        $userScoreHistory::query()->create([
                            "client_type" => 1,
                            "uuid" => UUID::getUUID(),
                            "type" => 1,
                            "title" => "阅读文章",
                            "score" => $article->read_score,
                            "user_uuid" => $value["user_uuid"],
                            "store_uuid" => $value["store_uuid"],
                        ]);
                    }
                    if (!empty($article->read_expend_score)) {
                        $userScoreHistory::query()->create([
                            "client_type" => 1,
                            "uuid" => UUID::getUUID(),
                            "type" => 2,
                            "title" => "阅读文章",
                            "score" => $article->read_expend_score,
                            "user_uuid" => $value["user_uuid"],
                            "store_uuid" => $value["store_uuid"],
                        ]);
                    }
                    // 增加文章阅读记录
                    try {
                        (new StoreArticleReadHistory())::query()->create([
                            "uuid" => UUID::getUUID(),
                            "store_uuid" => $value["store_uuid"],
                            "article_uuid" => $value["article_uuid"],
                            "user_uuid" => $value["user_uuid"],
                        ]);
                    } catch (Throwable $throwable) {
                        preg_match("/Duplicate entry/", $throwable->getMessage(), $msg);
                    }
                    // 更新用户总积分缓存
                    $score = RedisClient::getInstance()->incrByFloat(CacheKey::SCORE_TOTAL . $value["user_uuid"],
                        ($article->read_score - $article->read_expend_score));
                    if (is_float($score)) {
                        var_dump("用户积分添加成功", $score);
                    }
                }
            }, 2);
            if ($row > 0) {
                RedisClient::getInstance()->lPush(CacheKey::ARTICLE_QUEUE, json_encode($value, JSON_UNESCAPED_UNICODE));
            }
        }
    }
}