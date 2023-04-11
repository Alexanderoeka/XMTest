<?php
declare(strict_types=1);


namespace App\Common\Exception;

use JetBrains\PhpStorm\Pure;
use LogicException;

class ValidationException extends LogicException
{
    #[Pure]
    public function __construct($message = "", $code = 400)
    {
        parent::__construct($message, $code);
    }

}