<?php

declare (strict_types=1);
namespace App\Service\Api\User;

use App\Mapping\UserInfo;
use App\Mapping\UUID;
use App\Repository\Api\User\ExamSubmitHistoryRepository;
use App\Service\Api\Exam\CollectionService;
use App\Service\Api\Exam\OptionService;
use App\Service\ApiServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;
/**
 * 试题提交
 *
 * Class ExamSubmitHistoryService
 * @package App\Service\Api\Api
 */
class ExamSubmitHistoryService implements ApiServiceInterface
{
    use \Hyperf\Di\Aop\ProxyTrait;
    use \Hyperf\Di\Aop\PropertyHandlerTrait;
    /**
     * @Inject()
     * @var ExamSubmitHistoryRepository
     */
    protected $historyRepository;
    public function __construct()
    {
        $this->__handlePropertyHandler(__CLASS__);
    }
    /**
     * 格式化查询条件
     *
     * @param array $requestParams 请求参数
     * @return mixed 组装的查询条件
     */
    public static function searchWhere(array $requestParams)
    {
        return function ($query) use($requestParams) {
            extract($requestParams);
            if (!empty($user_uuid)) {
                $query->where('user_uuid', '=', $user_uuid);
            }
        };
    }
    /**
     * 查询数据
     *
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams) : array
    {
        return $this->historyRepository->repositorySelect(self::searchWhere($requestParams), (int) $requestParams['size'] ?? 20);
    }
    /**
     * 创建数据
     *
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams) : bool
    {
        if ($requestParams['type'] == 1) {
            // 单选试题
            return $this->optionCreate((array) $requestParams);
        }
        return true;
    }
    /**
     * 更新数据
     *
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams) : int
    {
        // TODO: Implement serviceUpdate() method.
    }
    /**
     * 删除数据
     *
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams) : int
    {
        // TODO: Implement serviceDelete() method.
    }
    /**
     * 查询单条数据
     *
     * @param array $requestParams 请求参数
     * @return array
     */
    public function serviceFind(array $requestParams) : array
    {
        // TODO: Implement serviceFind() method.
    }
    /**
     * 单选试题创建
     *
     * @param array $requestParams 请求参数
     * @return bool
     */
    private function optionCreate(array $requestParams) : bool
    {
        /** @var array $selectArray 用户选择的试题 */
        $selectArray = json_decode($requestParams['select'], true);
        if (count($selectArray) < 1) {
            return false;
        }
        /** @var array $optionsArray 用户选择的试题对应数据 */
        $optionsArray = (new OptionService())->serviceIdWhereIn(array_column($selectArray, 'uuid'));
        /** @var array $collection 试卷信息 */
        $collection = (new CollectionService())->serviceFind(['uuid' => $requestParams['collection_uuid']]);
        /** @var string $useTime 答题时间 */
        $useTime = $requestParams['cutDownTime']['hour'] . ':' . $requestParams['cutDownTime']['minutes'] . ':' . $requestParams['cutDownTime']['seconds'];
        /** @var array $userInfo 微信用户信息 */
        $userInfo = UserInfo::getWeChatUserInfo();
        /** @var int $successNumber 正确题数 */
        $successNumber = 0;
        /** @var double $totalScore 所得分数 */
        $totalScore = 0.0;
        /** @var array $insertInfoArray 答题记录 */
        $insertInfoArray = [];
        foreach ($selectArray as $key => $value) {
            // TODO 根据$options的长度进行循环，避免用户跑接口传递一些错误的试题uuid到服务端。
            $optionAnswer = $optionsArray[$key]['answer'];
            sort($optionAnswer);
            $optionAnswer = implode(',', $optionAnswer);
            $selectAnswer = explode('-', $value['options']);
            sort($selectAnswer);
            $selectAnswer = implode(',', $selectAnswer);
            if ($optionAnswer == $selectAnswer) {
                ++$successNumber;
                $totalScore += $optionsArray[$key]['answer_income_score'];
            }
            $insertInfoArray[] = ['user_uuid' => $userInfo['user_uuid'], 'exam_collection_uuid' => $requestParams['collection_uuid'], 'exam_uuid' => $value['uuid'], 'score' => $optionAnswer == $selectAnswer ? $optionsArray[$key]['answer_income_score'] : 0.0, 'submit_time' => $useTime, 'exam_answer' => $optionAnswer, 'select_answer' => $selectAnswer, 'type' => 1, 'store_uuid' => $userInfo['store_uuid']];
        }
        $scoreConfig = (new ScoreConfigService())->serviceFind(['key' => 'wechat_exam']);
        $score = !empty($scoreConfig) ? $scoreConfig['score'] + $totalScore : $totalScore;
        $scoreHistory = ['uuid' => UUID::getUUID(), 'title' => $scoreConfig['title'] ?? '试卷答题', 'type' => 1, 'score_key' => 'wechat_exam', 'score' => $score, 'user_uuid' => $userInfo['user_uuid'], 'store_uuid' => $userInfo['store_uuid']];
        $insertResult = $this->historyRepository->repositoryCreate(['exam' => $insertInfoArray, 'score' => $scoreHistory]);
        if ($insertInfoArray) {
            // 向协程写入数据
            Context::set('score', ['score' => $totalScore, 'time' => $useTime, 'success' => $successNumber]);
        }
        return $insertResult;
    }
    /**
     * 统计用户总答题试卷数量
     *
     * @param array $requestParams
     * @return int
     */
    public function serviceSubmitCount(array $requestParams) : int
    {
        return $this->historyRepository->repositoryCountGroup(self::searchWhere($requestParams));
    }
}