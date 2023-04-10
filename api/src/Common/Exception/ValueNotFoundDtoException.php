<?php
declare(strict_types=1);


namespace App\Common\Exception;

use JetBrains\PhpStorm\Pure;
use LogicException;

class ValueNotFoundDtoException extends LogicException
{
    #[Pure]
    public function __construct($message = "")
    {
        parent::__construct($message);
    }

}