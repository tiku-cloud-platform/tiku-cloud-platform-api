<?php
declare(strict_types = 1);

namespace App\Mapping;

/**
 * 数据格式化.
 * Class DataFormatter
 */
class DataFormatter
{
    /**
     * 递归数据.
     *
     * @param array $info
     * @param string $pid
     * @return array
     */
    public static function recursionData(array $info, $pid = ''): array
    {
        $tree = [];
        foreach ($info as $value) {
            if ($value['parent_uuid'] == $pid) {
                $value['children'] = self::recursionData($info, (string)$value['uuid']);
                if ($value['children'] == null) {
                    unset($value['children']);
                }
                $tree[] = $value;
            }
        }

        return $tree;
    }

    /**
     * 将日期格式化为今天、昨天、两天前、三天前的格式.
     *
     * @param string $startDate 开始日期
     * @param string|null $endDate 结束日期
     * @return string
     */
    public static function formatterDate(string $startDate, string $endDate = null): string
    {
        $endDate = empty($endDate) ? date('Y-m-d') : $endDate;

        $startTimeStamp = strtotime($startDate);
        $endTimeStamp   = strtotime($endDate);

        if ($startTimeStamp == $endTimeStamp) {
            return '今天';
        }
        if (($endTimeStamp - $startTimeStamp) / 86400 == 1) {
            return '昨天';
        }
        if (($endTimeStamp - $startTimeStamp) / 86400 == 2) {
            return '两天前';
        }
        if (($endTimeStamp - $startTimeStamp) / 86400 == 3) {
            return '三天前';
        }
        return '四天前';
    }

    /**
     * 获取用户真实IP地址
     *
     * @param array $requestParams
     * @return string
     */
    public static function getClientIp(array $requestParams): string
    {
        if (isset($res['http_client_ip'])) {
            return $res['http_client_ip'];
        } elseif (isset($res['http_x_real_ip'])) {
            return $res['http_x_real_ip'];
        } elseif (isset($res['http_x_forwarded_for'])) {
            //部分CDN会获取多层代理IP，所以转成数组取第一个值
            $arr = explode(',', $res['http_x_forwarded_for']);
            return $arr[0];
        } else {
            return $requestParams['remote_addr'];
        }
    }

    /**
     * 获取本周的所有日期
     * @param string $time
     * @param string $format
     * @return array
     */
    public static function getCurrentWeek(string $time = '', string $format = 'Y-m-d'): array
    {
        $time = $time != '' ? $time : time();
        //获取当前周几
        $week = date('w', (int)$time);
        $date = [];
        for ($i = 1; $i <= 7; $i++) {
            $date[$i - 1] = date($format, strtotime('+' . ($i - $week) . ' days', (int)$time));
        }
        return $date;
    }
}
