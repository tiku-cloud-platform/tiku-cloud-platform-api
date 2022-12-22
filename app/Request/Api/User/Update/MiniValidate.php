<?php
declare(strict_types=1);

namespace App\Request\Api\User\Update;

use App\Request\Api\ApiBaseFormRequest;
use Hyperf\Validation\Request\FormRequest;

/**
 * 更新微信小程序信息
 */
class MiniValidate extends ApiBaseFormRequest
{
    public function rules(): array
    {
        return [
            "avatar_url" => "required|url",
            "nickname" => "required|max:32",
        ];
    }

    public function messages(): array
    {
        return [
            "avatar_url.required" => "头像不能为空",
            "avatar_url.url" => "头像不合法",
            "nickname.required" => "昵称必填",
            "nickname.max" => "昵称过长",
        ];
    }
}