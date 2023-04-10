<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes;

use App\Common\BaseService;
use App\Common\CollectionDto;
use App\Common\EmailSender;
use App\Common\Exception\ValueNotFoundDtoException;
use App\Domain\HistoricalQuotes\Dto\CompanySelectDto;
use App\Domain\HistoricalQuotes\Dto\HistoricalQuoteDto;
use App\Domain\HistoricalQuotes\Dto\HistoricalQuotesGetDto;
use App\Domain\HistoricalQuotes\Entity\Company;
use App\Domain\HistoricalQuotes\Repository\CompanyRepository;
use App\Domain\HistoricalQuotes\Request\RequestTypes;
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HistoricalQuotesService extends BaseService
{


    public function __construct(
        private EmailSender $emailSender,
        private RequestTypes $requestTypes,
        private CompanyRepository $companyRepository

    )
    {
    }

    /** @return Company[] */
    public function getCompaniesLike(string $symbol): array
    {
        /** @var Company[] $companies */
        $companies = $this->companyRepository->getCompaniesLike($symbol)->getResult();

        return $companies;
    }

    /** @return CompanySelectDto[] */
    public function getCompaniesNameAndSymbol(): array
    {
        $symbolAndNameArray = $this->requestTypes->getCompaniesNameAndSymbolAPI();

        /** @var CompanySelectDto[] $companiesDtoCollection */
        $companiesDtoCollection = CollectionDto::getData($symbolAndNameArray, CompanySelectDto::class);

        return $companiesDtoCollection;
    }


    /**
     * @param HistoricalQuotesGetDto $dto
     * @return HistoricalQuoteDto[]
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function getHistoricalQuotes(HistoricalQuotesGetDto $dto): array
    {
        $historicalQuotesArray = $this->requestTypes->getHistoricalQuotesAPI($dto->companySymbol);


        $historicalQuotesArraySorted = $this->sortArrayBy($historicalQuotesArray, 'date', SORT_ASC);

        /** @var HistoricalQuoteDto[] $historicalQuotesDto */
        $historicalQuotesDto = CollectionDto::getData($historicalQuotesArraySorted, HistoricalQuoteDto::class);
        $historicalQuotesDtoRanged = [];
        foreach ($historicalQuotesDto as $historicalQuoteDto) {
            if (!$dto->dateTimeRange->isDateBetweenRange($historicalQuoteDto->date))
                continue;
            $historicalQuotesDtoRanged[] = $historicalQuoteDto;
        }


        $companyName = $this->companyRepository->findOneBy(['symbol' => $dto->companySymbol])?->getName() ?? 'undefinedName';

        $this->emailSender->sendEmail($dto->email, "Company name : {$companyName}", "From {$dto->dateTimeRange->getStart()->format('Y-m-d')} to {$dto->dateTimeRange->getEnd()->format('Y-m-d')}");


        return $historicalQuotesDtoRanged;
    }

    private function sortArrayBy(array $array, string $key, int $order): array
    {
        $arrayColumn = array_column($array, $key);
        array_multisort($arrayColumn, $order, $array);

        return $array;
    }


}