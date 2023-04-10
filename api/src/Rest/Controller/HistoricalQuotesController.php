<?php
declare(strict_types=1);


namespace App\Rest\Controller;

use App\Common\CollectionTransformer;
use App\Common\SearchDto;
use App\Domain\HistoricalQuotes\Dto\HistoricalQuotesGetDto;
use App\Domain\HistoricalQuotes\HistoricalQuotesService;
use App\Rest\Controller\BaseController;
use App\Domain\HistoricalQuotes\Transformer\CompanyTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HistoricalQuotesController extends BaseController
{

    public function __construct(private HistoricalQuotesService $historicalQuotesService)
    {
    }

    #[Route('/api/historical-quotes/aa', methods: ['GET'])]
    public function getSome(): JsonResponse
    {
        return new JsonResponse(['fqef']);
    }

    #[Route('/api/historical-quotes/get', methods: ['GET'])]
    public function getHistoricalQuotes(HistoricalQuotesGetDto $dto): JsonResponse
    {
        return $this->getHistoricalQuotes($dto);
//        return $this->getResponseWithPagingNative($dto,$this->historicalQuotesService->searchCompanies($dto), new CompanyTransformer);
    }
}