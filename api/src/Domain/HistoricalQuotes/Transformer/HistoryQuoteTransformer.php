<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes\Transformer;


use App\Domain\HistoricalQuotes\Dto\HistoricalQuoteDto;

class HistoryQuoteTransformer
{
    public static function transform(HistoricalQuoteDto $dto)
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