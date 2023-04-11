<?php
declare(strict_types=1);


namespace App\Rest\Controller;

use App\Common\CollectionTransformer;
use App\Common\ValueObject\Response;
use App\Domain\HistoricalQuotes\Dto\HistoricalQuotesGetDto;
use App\Domain\HistoricalQuotes\HistoricalQuotesService;
use App\Domain\HistoricalQuotes\Transformer\HistoryQuoteTransformer;
use App\Domain\HistoricalQuotes\Transformer\CompanySelectTransformer;
use Symfony\Component\Routing\Annotation\Route;

class HistoricalQuotesController extends BaseController
{

    public function __construct(private HistoricalQuotesService $historicalQuotesService)
    {
    }

    #[Route('/api/historical-quotes/get', methods: ['GET'])]
    public function getHistoricalQuotes(HistoricalQuotesGetDto $dto): Response
    {
            $historicalQuoteDto = $this->historicalQuotesService->getHistoricalQuotes($dto);
            $formattedData = CollectionTransformer::getData($historicalQuoteDto, new HistoryQuoteTransformer());
            return new Response($formattedData);
    }

    #[Route('/api/companies-name-symbol/get/{symbol}', methods: ['GET'])]
    public function getCompaniesLike(string $symbol): Response
    {
            $data = $this->historicalQuotesService->getCompaniesLike($symbol);
            $formattedData = CollectionTransformer::getData($data, new CompanySelectTransformer());
            return new Response($formattedData);
    }
}