<?php
declare(strict_types=1);

namespace App\Service\Api\Exam\Record;

use App\Mapping\Request\RequestApp;
use App\Mapping\Request\UserLoginInfo;
use App\Mapping\UUID;
use App\Repository\Api\Exam\Record\ReadingRepository;
use App\Service\ApiServiceInterface;
use Closure;
use Hyperf\Di\Annotation\Inject;

/**
 * 选择试题记录
 */
class ReadingService implements ApiServiceInterface
{
    /**
     * @Inject()
     * @var ReadingRepository
     */
    protected $readingRepository;

    public static function searchWhere(array $requestParams): Closure
    {
        // TODO: Implement searchWhere() method.
    }

    public function serviceSelect(array $requestParams): array
    {
        // TODO: Implement serviceSelect() method.
    }

    /**
     * 创建问答试题记录
     * @param array $requestParams
     * @return bool
     */
    public function serviceCreate(array $requestParams): bool
    {
       $row =  $this->readingRepository->repositoryAdd([
            "uuid" => UUID::getUUID(),
            "user_uuid" => UserLoginInfo::getUserId(),
            "store_uuid" => RequestApp::getStoreUuid(),
            "option_uuid" => $requestParams["uuid"]
        ]);
       if ($row)  return true; return false;
    }

    public function serviceUpdate(array $requestParams): int
    {
        // TODO: Implement serviceUpdate() method.
    }

    public function serviceDelete(array $requestParams): int
    {
        // TODO: Implement serviceDelete() method.
    }

    public function serviceFind(array $requestParams): array
    {
        // TODO: Implement serviceFind() method.
    }
}