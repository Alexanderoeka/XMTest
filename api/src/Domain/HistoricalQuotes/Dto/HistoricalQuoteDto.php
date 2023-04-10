<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes\Dto;


use App\Common\BaseDto;
use App\Common\ValueObject\DateTimeRange;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

class HistoricalQuoteDto extends BaseDto
{
    public DateTime $date;
    public float $open;
    public float $close;
    public float $high;
    public float $low;
    public int $volume;

    public function __construct(RequestStack|array $incomingData)
    {
        parent::__construct($incomingData);

        $this->date = $this->getDateValueFromUnixSure('date');
        $this->open = $this->getFloatValueSure('open');
        $this->close = $this->getFloatValueSure('close');
        $this->high = $this->getFloatValueSure('high');
        $this->low = $this->getFloatValueSure('low');
        $this->volume = $this->getValueSure('volume');
    }


}