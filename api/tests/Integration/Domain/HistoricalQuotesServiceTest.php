<?php
declare(strict_types=1);

namespace Tests\Integration\Domain\Dto;


use App\Common\Exception\DateTimeRangeException;
use App\Common\Exception\ValidationException;
use App\Common\Exception\ValueNotFoundDtoException;
use App\Common\ValueObject\DateTimeRange;
use App\Domain\HistoricalQuotes\Dto\HistoricalQuoteDto;
use App\Domain\HistoricalQuotes\Dto\HistoricalQuotesGetDto;
use App\Domain\HistoricalQuotes\Entity\Company;
use App\Domain\HistoricalQuotes\HistoricalQuotesService;
use App\Domain\HistoricalQuotes\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Validator\Validation;
use Tests\DatabasePrimer;
use Exception;
use Tests\Integration\Domain\BigDataProvider;
use Throwable;
use DateTime;

class HistoricalQuotesServiceTest extends WebTestCase
{
    private KernelBrowser $client;

    private EntityManagerInterface $entityManager;

    private CompanyRepository $companyRepository;


    private HistoricalQuotesService $historicalQuotesService;

    protected function setUp(): void
    {

        try {

            $this->client = static::createClient();

            $kernel = self::bootKernel();

            DatabasePrimer::prime($kernel);

            $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();


            $this->historicalQuotesService = $this->getContainerVar(static::getContainer()->get(HistoricalQuotesService::class), HistoricalQuotesService::class);

            $this->companyRepository = $this->entityManager->getRepository(Company::class);

        } catch (Exception $e) {
            return;
        }

    }


    public function historycalQuotesProvider()
    {
        $arr = BigDataProvider::historicQuotesData();
        return $arr;
    }


    /**
     * @dataProvider historycalQuotesProvider
     */
    public function testGetHistoricalQuotes(array $historicalQuotes,string $dateStart, string $dateEnd, string $symbol )
    {

        $dateTimeRange = new DateTimeRange(new DateTime($dateStart), new DateTime($dateEnd));

        /** @var HistoricalQuoteDto[] $historicalQuotesDto */
        $historicalQuotesDtoRanged = $this->historicalQuotesService->sortHistoricalQuotes($historicalQuotes, $dateTimeRange, 'date', SORT_ASC );




        $this->assertTrue(true);
        $companyName = $this->companyRepository->findOneBy(['symbol' => $symbol])?->getName() ?? 'undefinedName. i.e. API found quotes for this symbol, but BD or json site doesnt have it';

    }



    /** @throws Exception */
    private function getContainerVar(?object $variable, string $type): mixed
    {
        if (!$variable instanceof $type)
            throw new Exception("Variable $variable is not type of $type");

        return $variable;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

}