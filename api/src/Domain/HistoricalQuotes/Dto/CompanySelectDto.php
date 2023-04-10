<?php
declare(strict_types=1);

namespace App\Domain\HistoricalQuotes\Dto;


use App\Common\BaseDto;
use Symfony\Component\HttpFoundation\RequestStack;

class CompanySelectDto extends  BaseDto
{

    public string $name;
    public string $symbol;


    public function __construct(RequestStack|array $incomingData)
    {
        parent::__construct($incomingData);


        $this->name = $this->getValueSure('name');
        $this->symbol = $this->getValueSure('symbol');
    }


}