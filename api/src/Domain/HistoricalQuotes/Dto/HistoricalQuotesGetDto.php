<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes\Dto;


use App\Common\BaseDto;
use App\Common\Exception\ValidationException;
use App\Common\Exception\ValueNotFoundDtoException;
use App\Common\ValueObject\DateTimeRange;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;
use Exception;
use DateTime;
use Symfony\Component\Validator\Validation;

class HistoricalQuotesGetDto extends BaseDto
{
    public string $companySymbol;
    public DateTimeRange $dateTimeRange;
    public string $email;

    /**
     * @param RequestStack|array $incomingData
     * @throws ValueNotFoundDtoException
     * @throws ValidationException
     * @throws Exception
     */
    public function __construct(RequestStack|array $incomingData)
    {
        parent::__construct($incomingData);
        $this->companySymbol = $this->getValueSure('companySymbol');
        $this->dateTimeRange = $this->getDateRangeSure('startDate', 'endDate');
        $this->email = $this->getEmailValueSure('email');

    }


}