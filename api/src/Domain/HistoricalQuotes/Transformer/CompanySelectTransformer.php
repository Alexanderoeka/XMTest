<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes\Transformer;


use App\Domain\HistoricalQuotes\Dto\CompanySelectDto;
use App\Domain\HistoricalQuotes\Entity\Company;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class CompanySelectTransformer
{
    #[Pure] #[ArrayShape(['name' => "string", 'symbol' => "string"])]
    public static function transform(Company $dto): array
    {
        return [
            'name' => $dto->getName(),
            'symbol' => $dto->getSymbol(),
        ];
    }

}