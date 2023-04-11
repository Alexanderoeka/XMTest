<?php
declare(strict_types=1);

namespace App\Common\ValueObject;

use App\Common\Exception\DateTimeRangeException;
use DateTime;
use Exception;
use JetBrains\PhpStorm\Pure;

class DateTimeRange
{
    private DateTime $start;

    private DateTime $end;

    /** @throws Exception */
    public function __construct(DateTime $start, DateTime $end)
    {

        if ($start > $end) {
            throw new DateTimeRangeException('Entered date of start greater then date end');
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

    #[Pure]
    public function isDateBetweenRange(DateTime $date): bool
    {
        return $date > $this->getStart() && $date < $this->getEnd();
    }


}