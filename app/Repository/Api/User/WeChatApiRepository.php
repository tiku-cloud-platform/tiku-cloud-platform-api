<?php
declare(strict_types = 1);

namespace App\Repository\Api\User;


use App\Constants\ErrorCode;
use App\Mapping\RedisClient;
use App\Mapping\Request\RequestApp;
use App\Mapping\UUID;
use App\Model\Api\StoreMiniUserDevice;
use App\Model\Api\StoreMiNiWeChatUser;
use App\Model\Api\StorePlatformUser;
use App\Model\Common\StoreUserScoreCollection;
use App\Repository\Api\Sign\CollectionRepository;
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
    public function repositorySelect(Closure $closure, int $perSize, array $searchFields = []): array
    {
        return [];
    }

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
                    'real_name' => "小白号",
                    'store_uuid' => $storeUuid,
                    'store_platform_user_group_uuid' => $insertInfo["grade_uuid"],
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
                    'nickname' => "小白" . mt_rand(0, 10000) . "号",
                    'avatar_url' => "https://qiniucloud.qqdeveloper.com/avatar_tiku_cloud.png",
                    'gender' => 0,
                    "register_ip" => $insertInfo["register_ip"],
                    "login_ip" => $insertInfo["login_ip"],
                    'is_forbidden' => 2,
                    'language' => "zh-Cn",
                ]);
                if (!empty($insertInfo["device"])) {
                    $deviceModel::query()->create([
                        "uuid" => UUID::getUUID(),
                        "store_uuid" => $storeUuid,
                        "user_uuid" => $insertInfo["user_uuid"],
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
                }
                $createScoreCollection = (new StoreUserScoreCollection())::query()->create([
                    "user_uuid" => $insertInfo["user_uuid"],
                    "uuid" => UUID::getUUID(),
                    "score" => 0,
                    "store_uuid" => $storeUuid,
                ]);
                $createSignCollection  = (new CollectionRepository())->repositoryCreate([
                    'uuid' => UUID::getUUID(),
                    'user_uuid' => $insertInfo["user_uuid"],
                    'sign_number' => 0,
                    'store_uuid' => $storeUuid,
                    'is_show' => 1,
                ]);
                if ($insertUser && $insertMiniUser && $createScoreCollection && $createSignCollection) {
                    $insertUserResult = true;
                }
            }, 2);
        } catch (Throwable $throwable) {
            // record register error log
            var_dump($throwable->getMessage());
            $data = json_encode([
                'code' => empty($throwable->getCode()) ? ErrorCode::REQUEST_SUCCESS : $throwable->getCode(),
                'message' => $throwable->getMessage(),
                'data' => $insertInfo,
                "request_id" => UUID::snowFlakeId(),
            ]);
            RedisClient::getInstance()->lPush("log_queue", json_encode([
                "code" => 500,
                "desc" => "系统级别错误信息",
                "package" => "register_log",
                "span" => "register",
                "error_log_file" => $throwable->getFile(),
                "error_log_line" => $throwable->getLine(),
                "error_log_message" => $throwable->getMessage()
            ]));
        }
        return $insertUserResult;
    }

    public function repositoryAdd(array $addInfo): int
    {
        return 0;
    }

    public function repositoryFind(Closure $closure, array $searchFields = []): array
    {
        if (count($searchFields) === 0) {
            $searchFields = [
                'uuid', 'openid', 'nickname', 'avatar_url', 'gender', 'country', 'province', 'city', 'is_forbidden',
                'language', 'longitude', 'latitude', 'district', 'store_uuid', 'user_uuid', 'created_at',
            ];
        }
        $bean = (new StoreMiNiWeChatUser)::query()
            ->with(['user:uuid,real_name,gender,email,mobile,age,real_name,birthday,remark'])
            ->where($closure)
            ->first($searchFields);

        return !empty($bean) ? $bean->toArray() : [];
    }

    public function repositoryUpdate(array $updateWhere, array $updateInfo): int
    {
        return (new StoreMiNiWeChatUser)::query()->where($updateWhere)->update($updateInfo);
    }

    public function repositoryDelete(array $deleteWhere): int
    {
        return 0;
    }

    public function repositoryWhereInDelete(array $deleteWhere, string $field): int
    {
        return 0;
    }
}