<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes\Transformer;


use App\Domain\HistoricalQuotes\Dto\CompanySelectDto;
use App\Domain\HistoricalQuotes\Entity\Company;

class CompanySelectTransformer
{
    public static function transform(Company $dto)
    {
        return [
            'name' => $dto->getName(),
            'symbol' => $dto->getSymbol(),
        ];
    }

}