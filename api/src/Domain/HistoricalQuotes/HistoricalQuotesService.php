<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes;

use App\Common\BaseService;
use App\Common\CollectionDto;
use App\Common\EmailSender;
use App\Common\ValueObject\DateTimeRange;
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
use Symfony\Component\Mailer\Exception\TransportExceptionInterface as MailerTransportExceptionInterface;

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

    /**
     * @param HistoricalQuotesGetDto $dto
     * @return HistoricalQuoteDto[]
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws MailerTransportExceptionInterface
     * @throws Exception
     */
    public function getHistoricalQuotes(HistoricalQuotesGetDto $dto): array
    {
        $historicalQuotesArray = $this->requestTypes->getHistoricalQuotesAPI($dto->companySymbol);


        /** @var HistoricalQuoteDto[] $historicalQuotesDto */
        $historicalQuotesDtoRanged = $this->sortHistoricalQuotes($historicalQuotesArray, $dto->dateTimeRange, 'date', SORT_ASC );


        $companyName = $this->companyRepository->findOneBy(['symbol' => $dto->companySymbol])?->getName() ?? 'undefinedName. i.e. API found quotes for this symbol, but BD or json site doesnt have it';

        $this->emailSender->sendEmail($dto->email, "Company name : {$companyName}", "From {$dto->dateTimeRange->getStart()->format('Y-m-d')} to {$dto->dateTimeRange->getEnd()->format('Y-m-d')}");


        return $historicalQuotesDtoRanged;
    }



    /**
     * @param int $sort might be  SORT_DESC | SORT_ASC  etc.
     * @return HistoricalQuoteDto[]
     */
    public function sortHistoricalQuotes(array $historicalQuotesArray, DateTimeRange $dateTimeRange, string $sortBy, int $sort = SORT_ASC): array
    {
        $historicalQuotesArraySorted = $this->sortArrayBy($historicalQuotesArray, $sortBy, $sort);

        /** @var HistoricalQuoteDto[] $historicalQuotesDto */
        $historicalQuotesDto = CollectionDto::getData($historicalQuotesArraySorted, HistoricalQuoteDto::class);
        $historicalQuotesDtoRanged = [];
        foreach ($historicalQuotesDto as $historicalQuoteDto) {
            if (!$dateTimeRange->isDateBetweenRange($historicalQuoteDto->date))
                continue;
            $historicalQuotesDtoRanged[] = $historicalQuoteDto;
        }

        return $historicalQuotesDtoRanged;
    }


}