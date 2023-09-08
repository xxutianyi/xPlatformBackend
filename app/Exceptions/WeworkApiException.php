<?php

namespace App\Exceptions;

use Exception;

class WeworkApiException extends Exception
{
    public function __construct(array $result)
    {
        parent::__construct($result['errmsg'], $result['errcode']);
    }
}
