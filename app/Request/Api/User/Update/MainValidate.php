<?php
declare(strict_types = 1);

namespace App\Request\Api\User\Update;

use App\Request\Api\ApiBaseFormRequest;
use Hyperf\Validation\Rule;

/**
 * 主表更新验证
 */
class MainValidate extends ApiBaseFormRequest
{
    public function rules(): array
    {
        return [
            "mobile" => "sometimes|mobile",
            "email" => "required|email",
            "real_name" => "required|max:32",
            "gender" => ["required", Rule::in([0, 1, 2])],
            "birthday" => "sometimes|date",
            "remark" => "sometimes|max:100",
            "age" => "required|integer|max:100|min:1",
        ];
    }

    public function messages(): array
    {
        return [
            //"mobile.required" => "手机号必填",
            "mobile.mobile" => "手机号格式错误",
            "email.required" => "邮箱必填",
            "email.email" => "邮箱格式错误",
            "real_name.required" => "真实名称必填",
            "real_name.max" => "真实名称过长",
            "gender.required" => "性别必选",
            "age.required" => "年龄必填",
            "age.integer" => "年龄只能是数字",
            "age.max" => "年龄只能是1-100",
            "age.min" => "年龄只能是1-100",
            "gender.in" => "性别值错误",
            "birthday.date" => "出生日期格式错误",
            "remark.max" => "个人描述过长",
        ];
    }
}