<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;


use App\Mapping\Request\RequestApp;
use App\Mapping\UUID;
use App\Model\Api\StoreMiniUserDevice;
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
            $insertUserResult = false;
            Db::transaction(function () use ($insertInfo, &$insertUserResult) {
                // TODO 当前只做微信小程序端，只要小程序表中不存在都判定为是新用户。后续通过手机号作为系统唯一用户。
                $storeUuid      = RequestApp::getStoreUuid();
                $userModel      = new StorePlatformUser();
                $miniUserModel  = new StoreMiNiWeChatUser();
                $deviceModel    = new StoreMiniUserDevice();
                $insertUser     = $userModel::query()->create([
                    'uuid' => $insertInfo["user_uuid"],
                    'real_name' => "未知用户",
                    'store_uuid' => $storeUuid,
                    'store_platform_user_group_uuid',
                    "avatar_url" => "https://qiniucloud.qqdeveloper.com/avatar_tiku_cloud.png",
                    "remark" => "这家伙很懒，什么都没留下...",
                    "channel_uuid",
                    "gender" => 0,
                    "email",
                    "mobile",
                ]);
                $miniUserId     = UUID::getUUID();
                $insertMiniUser = $miniUserModel::query()->create([
                    "openid" => $insertInfo["openid"],
                    'uuid' => $miniUserId,
                    'user_uuid' => $insertInfo["user_uuid"],
                    'store_uuid' => $storeUuid,
                    'nickname' => "未知用户",
                    'avatar_url' => "https://qiniucloud.qqdeveloper.com/avatar_tiku_cloud.png",
                    'gender' => 0,
                    'is_forbidden' => 2,
                    'language' => "zh-Cn",
                ]);
                $deviceModel::query()->create([
                    "uuid" => UUID::getUUID(),
                    "store_uuid" => $storeUuid,
                    "mini_user_uuid" => $miniUserId,
                    "device_type" => $insertInfo["device"]["deviceType"] ?? "",
                    "device_brand" => $insertInfo["device"]["deviceBrand"] ?? "",
                    "device_model" => $insertInfo["device"]["deviceModel"] ?? "",
                    "os_name" => $insertInfo["device"]["osName"] ?? "",
                    "os_version" => $insertInfo["device"]["osVersion"] ?? "",
                    "os_language" => $insertInfo["device"]["language"] ?? "",
                    "os_theme" => $insertInfo["device"]["osTheme"] ?? "",
                    "uni_platform" => $insertInfo["device"]["uniPlatform"] ?? "",
                    "uni_compile_version" => $insertInfo["device"]["uniCompileVersion"] ?? "",
                    "uni_runtime_version" => $insertInfo["device"]["uniRuntimeVersion"] ?? "",
                    "app_id" => $insertInfo["device"]["appId"] ?? "",
                    "app_name" => $insertInfo["device"]["appName"] ?? "",
                    "app_version" => $insertInfo["device"]["appVersion"] ?? "",
                    "app_version_code" => $insertInfo["device"]["appVersionCode"] ?? "",
                    "app_wgt_version" => $insertInfo["device"]["appWgtVersion"] ?? "",
                    "app_language" => $insertInfo["device"]["appLanguage"] ?? "",
                    "ua" => $insertInfo["device"]["ua"] ?? "",
                    "rom_name" => $insertInfo["device"]["romName"] ?? "",
                    "rom_version" => $insertInfo["device"]["romVersion"] ?? "",
                    "sdk_version" => $insertInfo["device"]["SDKVersion"] ?? "",
                ]);
                if ($insertUser && $insertMiniUser) {
                    $insertUserResult = true;
                }
            }, 2);
        } catch (Throwable $throwable) {
            // record register error log
            var_dump($throwable->getMessage());
        }
        return $insertUserResult;
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