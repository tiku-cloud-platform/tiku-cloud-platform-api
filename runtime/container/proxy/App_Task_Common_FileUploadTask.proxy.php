<?php

declare (strict_types=1);
namespace App\Task\Common;

use Hyperf\Task\Annotation\Task;
/**
 * 文件上传
 *
 * Class FileUploadTask
 * @package App\Task\Common
 */
class FileUploadTask
{
    use \Hyperf\Di\Aop\ProxyTrait;
    use \Hyperf\Di\Aop\PropertyHandlerTrait;
    function __construct()
    {
        $this->__handlePropertyHandler(__CLASS__);
    }
    /**
     * 根据传入的文件数组，传递到默认的文件配置平台。
     *
     * @Task()
     * @param array $fileArray 需要上传的文件数组
     * @return array 上传之后的文件绝对路径地址
     */
    public function handle(array $fileArray) : array
    {
        $__function__ = __FUNCTION__;
        $__method__ = __METHOD__;
        return self::__proxyCall(__CLASS__, __FUNCTION__, self::__getParamsMap(__CLASS__, __FUNCTION__, func_get_args()), function (array $fileArray) use($__function__, $__method__) {
        });
    }
}