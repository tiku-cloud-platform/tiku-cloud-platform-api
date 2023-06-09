<?php
declare(strict_types = 1);

namespace App\Service;

use Closure;

/**
 * 接口公共interface
 * Interface UserServiceInterface.
 */
interface ApiServiceInterface
{
    /**
     * 格式化查询条件
     * @param array $requestParams 请求参数
     * @return Closure 组装的查询条件
     */
    public static function searchWhere(array $requestParams): Closure;

    /**
     * 查询数据
     * @param array $requestParams 请求参数
     * @return array 查询结果
     */
    public function serviceSelect(array $requestParams): array;

    /**
     * 创建数据
     * @param array $requestParams 请求参数
     * @return bool true|false
     */
    public function serviceCreate(array $requestParams): bool;

    /**
     * 更新数据
     * @param array $requestParams 请求参数
     * @return int 更新行数
     */
    public function serviceUpdate(array $requestParams): int;

    /**
     * 删除数据
     * @param array $requestParams 请求参数
     * @return int 删除行数
     */
    public function serviceDelete(array $requestParams): int;

    /**
     * 查询单条数据
     * @param array $requestParams 请求参数
     * @return array
     */
    public function serviceFind(array $requestParams): array;
}
