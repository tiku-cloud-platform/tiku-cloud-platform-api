<?php
declare(strict_types=1);

namespace App\Repository\Api\User;


use App\Mapping\Request\RequestApp;
use App\Mapping\UUID;
use App\Model\Api\StoreMiNiWeChatUser;
use App\Model\Api\StorePlatformUser;
use App\Repository\ApiRepositoryInterface;
use Closure;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Throwable;

/**
 * 微信用户
 *
 * Class WeChatUserService
 * @package App\Repository\Api\Api
 */
class WeChatApiRepository implements ApiRepositoryInterface
{
    /**
     * @Inject()
     * @var StoreMiNiWeChatUser
     */
    protected $userModel;

    public function __construct()
    {
    }

    /**
     * 查询数据
     *
     * @param Closure $closure
     * @param int $perSize 分页大小
     * @return array
     */
    public function repositorySelect(Closure $closure, int $perSize): array
    {
        return [];
    }

    /**
     * 创建数据
     *
     * @param array $insertInfo 创建信息
     * @return bool true|false
     */
    public function repositoryCreate(array $insertInfo): bool
    {
        try {
            Db::transaction(function () use ($insertInfo) {
                // TODO 当前只做微信小程序端，只要小程序表中不存在都判定为是新用户。后续通过手机号作为系统唯一用户。
                $storeUuid = (new RequestApp())->getStoreUuid();
                $userModel = new StorePlatformUser();
                $miniUserModel = new StoreMiNiWeChatUser();
                $insertUser = $userModel::query()->create([
                    'uuid',
                    'real_name',
                    'mobile',
                    'store_uuid' => $storeUuid,
                    'user_uuid' => $insertInfo["user_uuid"],
                    'store_platform_user_group_uuid',
                    "channel_uuid",
                ]);
                $insertMiniUser = $miniUserModel::query()->create([
                    "openid" => $insertInfo["openid"],
                    'uuid' => UUID::getUUID(),
                    'user_uuid' => $insertInfo["user_uuid"],
                    'store_uuid' => $storeUuid,
                    'nickname' => "小白",
                    'avatar_url' => "",
                    'gender',
                    'country',
                    'province',
                    'city',
                    'is_forbidden',
                    'language',
                    'real_name',
                    'mobile',
                    'address',
                    'longitude',
                    'latitude',
                    'district',
                    'birthday',
                    'is_show',
                    "channel_uuid",
                ]);
                if ($insertUser && $insertMiniUser) {
                    return true;
                }
                return false;
            }, 2);
        } catch (Throwable $throwable) {
            // record register error log
            return false;
        }
    }

    /**
     * 添加数据
     *
     * @param array $addInfo 添加信息
     * @return int 添加之后的ID或者行数
     */
    public function repositoryAdd(array $addInfo): int
    {
        // TODO: Implement repositoryAdd() method.
    }

    /**
     * 单条数据查询
     */
    public function repositoryFind(Closure $closure): array
    {
        $bean = $this->userModel::query()
            ->with(['user:uuid,real_name,gender,email,mobile'])
            ->where($closure)
            ->first($this->userModel->searchFields);

        if (!empty($bean)) return $bean->toArray();
        return [];
    }

    /**
     * 更新数据
     *
     * @param array $updateWhere 修改条件
     * @param array $updateInfo 修改信息
     * @return int 更新行数
     */
    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return $this->userModel::query()->where($updateWhere)->update($updateInfo);
    }

    /**
     * 删除数据
     *
     * @param array $deleteWhere 删除条件
     * @return int 删除行数
     */
    public function repositoryDelete(array $deleteWhere): int
    {
        // TODO: Implement repositoryDelete() method.
    }

    /**
     * 范围删除
     *
     * @param array $deleteWhere 删除条件
     * @param string $field 删除字段
     * @return int
     */
    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        // TODO: Implement repositoryWhereInDelete() method.
    }
}