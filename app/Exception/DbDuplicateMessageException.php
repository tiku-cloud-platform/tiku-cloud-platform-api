<?php
declare(strict_types = 1);

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

/**
 * 数据重复key异常
 * Class DbDuplicateMessageException
 */
class DbDuplicateMessageException extends ServerException
{
}
