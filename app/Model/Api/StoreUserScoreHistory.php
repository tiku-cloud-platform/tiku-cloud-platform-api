<?php
declare(strict_types = 1);

namespace App\Model\Api;


/**
 * 用户积分历史
 *
 * Class StoreUserScoreHistory
 * @package App\Model\Api
 */
class StoreUserScoreHistory extends \App\Model\Common\StoreUserScoreHistory
{
    public function getCreatedAtAttribute($key)
    {
        return date('Y-m-d', strtotime($key));
    }
}