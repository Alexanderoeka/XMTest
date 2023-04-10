<?php
declare(strict_types=1);

namespace App\Common\ValueObject;

use DateTime;
use Exception;

class DateTimeRange
{
    private DateTime $start;

    private DateTime $end;

    /** @throws Exception */
    public function __construct(DateTime $start, DateTime $end)
    {
        if ($start > $end) {
            throw new Exception('Entered date of start greater then date end');
        }

        $this->start = $start;
        $this->end = $end;
    }

    public function getStart(): DateTime
    {
        return $this->start;
    }

    public function getEnd(): DateTime
    {
        return $this->end;
    }


}