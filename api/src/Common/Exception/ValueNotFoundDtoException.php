<?php


namespace App\Common\Exception;

use LogicException;
use Throwable;

class ValueNotFoundDtoException extends LogicException
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }

}