<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes\Request;


use App\Common\Exception\ValueNotFoundDtoException;
use App\Common\ValueObject\DateTimeRange;
use App\Common\ValueObject\Response;
use App\Domain\HistoricalQuotes\Dto\HistoricalQuoteDto;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpClient\Exception\RedirectionException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;

class RequestTypes
{

    public function __construct(
        private string $XRapidAPIKey,
        private string $XRapidAPIHost,
        private HttpClientInterface $httpClient

    )
    {
    }

    /**
     * @throws DecodingExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    #[ArrayShape(['date' => 'int', 'open' => 'float', 'close' => 'float', 'high' => 'float', 'low' => 'float', 'volume' => 'int'])]
    public function getHistoricalQuotesAPI(string $companySymbol): array
    {

        try {

            $url = 'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data';

            $response = $this->httpClient->request(
                'GET',
                $url,
                [
                    'query' => [
                        'symbol' => $companySymbol
                    ],
                    'headers' => [
                        'X-RapidAPI-Key' => $this->XRapidAPIKey,
                        'X-RapidAPI-Host' => $this->XRapidAPIHost
                    ]
                ]
            );


            $historicalQuotes = $response->toArray()['prices'];

            return $historicalQuotes;
        }catch (RedirectionExceptionInterface $e){
            throw new Exception("API Couldn't find historical data with symbol '$companySymbol'");

        }
    }


    #[ArrayShape(['symbol' => 'string', 'name' => 'string'])]
    public function getCompaniesNameAndSymbolAPI(): array
    {
        $url = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';
        $response = $this->httpClient->request(
            'GET',
            $url
        );
        $arrayResponse = $response->toArray();

        $symbolAndNameArray = array_map(function ($row) {
            return [
                'name' => $row['Company Name'],
                'symbol' => $row['Symbol']
            ];
        }, $arrayResponse);

        return $symbolAndNameArray;
    }


}