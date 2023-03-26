<?php
declare(strict_types = 1);

namespace App\Library\Log;

use Uptrace\Config;
use Uptrace\Distro;

/**
 * Uptrace 客户端
 */
class UptraceClient
{
    /**
     * 发送uptrace日志信息
     * @param array $logMessage 日志消息
     * @return void
     */
    public function sendLog(array $logMessage)
    {
        if (count($logMessage) > 0) {
            $logMessage["log_time"] = date("Y-m-d H:i:s");
            $conf                   = new Config();
            $conf->setDsn(env("UPTRACE_RUL", ""));
            $conf->setServiceName(env("SERVICE_NAME", ""));
            $conf->setServiceVersion('1.0.0');

            $uptrace        = new Distro($conf);
            $tracerProvider = $uptrace->createTracerProvider();

            $tracer = $tracerProvider->getTracer($logMessage["package"] ?? "app");

            $main      = $tracer->spanBuilder($logMessage["span"] ?? "app")->startSpan();
            $mainScope = $main->activate();
            $main->setAttributes($logMessage);
            $main->setStatus((string)$logMessage["code"] ?? 500, $logMessage["desc"] ?? "系统错误日志");

            $mainScope->detach();
            $main->end();

            $tracerProvider->shutdown();
        }
    }
}