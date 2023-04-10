<?php
declare(strict_types=1);


namespace App\Rest\Controller;

use App\Common\CollectionTransformer;
use App\Common\SearchDto;
use App\Common\ValueObject\Response;
use App\Domain\HistoricalQuotes\Dto\HistoricalQuotesGetDto;
use App\Domain\HistoricalQuotes\HistoricalQuotesService;
use App\Domain\HistoricalQuotes\Transformer\HistoryQuoteTransformer;
use App\Rest\Controller\BaseController;
use App\Domain\HistoricalQuotes\Transformer\CompanySelectTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Exception;

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
    public function getHistoricalQuotes(HistoricalQuotesGetDto $dto): Response
    {
        try {
            $data = $this->historicalQuotesService->getHistoricalQuotes($dto);


            $formattedData = CollectionTransformer::getData($data, new HistoryQuoteTransformer());
            return new Response($formattedData);
        } catch (RedirectionExceptionInterface $e) {
            return (new Response())->setMessage("Couldn\'t find historical data with symbol $dto->companySymbol")->setSuccess(false);
        } catch (ClientExceptionInterface | ServerExceptionInterface | DecodingExceptionInterface | TransportExceptionInterface  $e) {
            return (new Response())->setMessage($e->getMessage())->setSuccess(false);
        } catch (Exception $e) {
            return (new Response())->setMessage($e->getMessage())->setSuccess(false);
        }
    }

    #[Route('/api/companies-name-symbol/get/{symbol}', methods: ['GET'])]
    public function getCompaniesLike(string $symbol): Response
    {
        try {
            $data = $this->historicalQuotesService->getCompaniesLike($symbol);
            $formattedData = CollectionTransformer::getData($data, new CompanySelectTransformer());
            return new Response($formattedData);
        }catch (Exception $e){
            return (new Response())->setMessage($e->getMessage())->setSuccess(false);
        }
    }
}