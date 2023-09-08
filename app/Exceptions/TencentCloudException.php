<?php

namespace App\Exceptions;

use Exception;

class TencentCloudException extends Exception
{
    public function __construct(array $result)
    {
        parent::__construct($result['Code'] . $result['Message']);
    }
}
