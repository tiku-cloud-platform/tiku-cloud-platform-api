<?php
declare(strict_types = 1);

namespace App\Service\Api\Sign;

use App\Constants\CacheKey;
use App\Mapping\DataFormatter;
use App\Mapping\RedisClient;
use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Service\ApiServiceInterface;
use Closure;
use Hyperf\Redis\Redis;
use RedisException;

/**
 * 用户签到
 */
class SignService implements ApiServiceInterface
{

    public static function searchWhere(array $requestParams): Closure
    {
        return function () {
        };
    }

    /**
     * 签到创建
     * @param array $requestParams
     * @return array
     * @throws RedisException
     */
    public function serviceSign(array $requestParams): array
    {
        if (!$this->serviceStatus($requestParams)["today_sign_status"]) {
            if (RedisClient::getInstance()->zAdd(CacheKey::USER_SIGN . UserLoginInfo::getUserId(), [], (int)date("Ymd"), (int)date("Ymd")) === 1) {
                // 处理连续签到天数
                $days = 1;
                if (RedisClient::getInstance()->zScore(CacheKey::USER_SIGN . UserLoginInfo::getUserId(), date("Ymd", strtotime("-1 day")))) {
                    RedisClient::getInstance()->incr(CacheKey::USER_SIGN_TOTAL . UserLoginInfo::getUserId());
                    $days += 1;
                } else {
                    RedisClient::getInstance()->set(CacheKey::USER_SIGN_TOTAL . UserLoginInfo::getUserId(), $days);
                }
                $score = RedisClient::getInstance()->hGet(CacheKey::SIGN_CONFIG . RequestApp::getStoreUuid(), (string)$days);
                if (!empty($score)) {
                    $score = json_decode($score, true);
                    if (!empty($score["score"])) {// 积分大于0才添加到队列中
                        RedisClient::getInstance()->lPush(CacheKey::SIGN_QUEUE, json_encode([
                            "user_uuid" => UserLoginInfo::getUserId(),
                            "store_uuid" => RequestApp::getStoreUuid(),
                            "client_type" => 1,
                            "score" => $score["score"],
                            "day" => $days,
                        ]));
                    }
                    RedisClient::getInstance()->incrByFloat(CacheKey::SCORE_TOTAL . UserLoginInfo::getUserId(), (float)$score["score"]);
                }
                return ["sign_status" => true, "sign_message" => "签到成功", "score" => !empty($score) ? $score["score"] : 0.00];
            }
            return ["sign_status" => false, "sign_message" => "签到失败"];
        }
        return ["sign_status" => false, "sign_message" => "已签到"];
    }

    /**
     * 是否签到[当前日期]
     * @param array $requestParams
     * @return array
     * @throws RedisException
     */
    public function serviceStatus(array $requestParams): array
    {
        $value     = RedisClient::getInstance()->zScore(CacheKey::USER_SIGN . UserLoginInfo::getUserId(), date("Ymd"));
        $signTotal = RedisClient::getInstance()->get(CacheKey::USER_SIGN_TOTAL . UserLoginInfo::getUserId());
        if (!empty($value) && $value == date("Ymd")) {
            return [
                "today_sign_status" => true,
                "sign_total" => empty($signTotal) ? 0 : (int)$signTotal,
            ];
        }
        return [
            "today_sign_status" => false,
            "sign_total" => empty($signTotal) ? 0 : (int)$signTotal,
        ];
    }

    /**
     * 获取本周的签到状态
     * @param array $requestParams
     * @return array
     * @throws RedisException
     */
    public function serviceSelect(array $requestParams): array
    {
        $weeks       = DataFormatter::getCurrentWeek((string)time(), "Y/m/d");
        $redisClient = RedisClient::getInstance();
        $signList    = [];
        // 查询积分配置最低配置，保证签到之后每天保证的积分
        $minScore = $redisClient->hGet(CacheKey::SIGN_CONFIG . RequestApp::getStoreUuid(), "1");
        $minScore = json_decode($minScore, true);
        foreach ($weeks as $value) {
            $isSign = $redisClient->zScore(CacheKey::USER_SIGN . UserLoginInfo::getUserId(), str_replace("/", "", $value));
            if (!empty($isSign)) {
                $signList[] = [
                    "date_1" => $value,
                    "is_sign" => true,
                    "score" => $minScore["score"],
                    "date_2" => mb_substr($value, 5, mb_strlen($value)),
                    "is_now_day" => $value === date("Y/m/d"),
                ];
            } else {
                $signList[] = [
                    "date_1" => $value,
                    "is_sign" => false,
                    "score" => $minScore["score"],
                    "date_2" => mb_substr($value, 5, mb_strlen($value)),
                    "is_now_day" => $value === date("Y/m/d"),
                ];
            }
        }
        return $signList;
    }

    public function serviceCreate(array $requestParams): bool
    {
        return false;
    }

    public function serviceUpdate(array $requestParams): int
    {
        return 0;
    }

    public function serviceDelete(array $requestParams): int
    {
        return 0;
    }

    public function serviceFind(array $requestParams): array
    {
        return [];
    }
}