<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes\Transformer;


use App\Domain\HistoricalQuotes\Entity\Company;

class CompanyTransformer
{
    public static function transform(Company $company)
    {
        return [
            'id' => $company->getId(),
            'name' => $company->getName(),
            'symbol' => $company->getSymbol(),
        ];
    }

}