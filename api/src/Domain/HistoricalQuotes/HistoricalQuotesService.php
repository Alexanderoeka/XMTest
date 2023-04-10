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
     * @return HistoricalQuoteDto[]
     */
    public function getHistoricalQuotes(HistoricalQuotesGetDto $dto): array
    {
        $historicalQuotesArray = $this->requestTypes->getHistoricalQuotesAPI($dto->companySymbol);


        $historicalQuotesArraySorted = $this->sortArrayBy($historicalQuotesArray, 'date', SORT_ASC);

        $historicalQuotesDto = [];
        foreach ($historicalQuotesArraySorted as $historicalQuote) {

            try {
                $historicalQuoteDto = new HistoricalQuoteDto($historicalQuote);
                if (!$dto->dateTimeRange->isDateBetweenRange($historicalQuoteDto->date))
                    continue;
                $historicalQuotesDto[] = $historicalQuoteDto;
            } catch (ValueNotFoundDtoException $e) {
                continue;
            }

        }
        $this->emailSender->sendEmail($dto->email, 'submitted Company Symbol', "From {$dto->dateTimeRange->getStart()->format('Y-m-d')} to {$dto->dateTimeRange->getEnd()->format('Y-m-d')}");


        return $historicalQuotesDto;
    }

    private function sortArrayBy(array $array, string $key, int $order): array
    {
        $arrayColumn = array_column($array, $key);
        array_multisort($arrayColumn, $order, $array);

        return $array;
    }


}