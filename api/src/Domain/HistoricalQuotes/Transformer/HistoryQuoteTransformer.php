<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes\Transformer;


use App\Domain\HistoricalQuotes\Dto\HistoricalQuoteDto;
use JetBrains\PhpStorm\ArrayShape;

class HistoryQuoteTransformer
{
    #[ArrayShape(['date' => "string", 'open' => "float", 'high' => "float", 'low' => "float", 'close' => "float", 'volume' => "int|mixed"])]
    public static function transform(HistoricalQuoteDto $dto): array
    {
        return [
            'date' => $dto->date->format('d-m-Y'),
            'open' => $dto->open,
            'high' => $dto->high,
            'low' => $dto->low,
            'close' => $dto->close,
            'volume' => $dto->volume,
        ];
    }

}