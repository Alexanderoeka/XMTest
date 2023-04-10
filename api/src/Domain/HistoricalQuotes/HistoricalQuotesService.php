<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes;

use App\Common\BaseService;
use App\Common\CollectionTransformer;
use App\Common\SearchDto;
use App\Domain\HistoricalQuotes\Dto\HistoricalQuotesGetDto;
use App\Domain\HistoricalQuotes\Repository\CompanyRepository;
use App\Domain\HistoricalQuotes\Transformer\CompanyTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;

class HistoricalQuotesService extends BaseService
{


    public function __construct(private HttpClientInterface $httpClient)
    {
    }


    public function getHistoricalQuotes(HistoricalQuotesGetDto $dto)
    {
    }


    public function getCompanies(): array
    {
        $url = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0
b2142ca8d7df6/nasdaq-listed_json.json';

        $response = $this->httpClient->request(
            'GET',
            $url
        );

        $companiesArray = $response->toArray();


        return $companiesArray;
    }
}