<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes\Dto;


use App\Common\BaseDto;
use App\Common\Exception\ValueNotFoundDtoException;
use App\Common\ValueObject\DateTimeRange;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;
use Exception;
use DateTime;

class HistoricalQuotesGetDto extends BaseDto
{
    public string $companySymbol;
    public DateTimeRange $dateTimeRange;
    #[Assert\Email]
    public string $email;

    /**
     * @param RequestStack|array $incomingData
     * @throws ValueNotFoundDtoException
     * @throws Exception
     */
    public function __construct(RequestStack|array $incomingData)
    {
        parent::__construct($incomingData);

        $this->companySymbol = $this->getValue('companySymbol');
        $this->dateTimeRange = $this->getDateRangeSure('startDate', 'endDate');
        $this->email = $this->getValue('email');
    }


}