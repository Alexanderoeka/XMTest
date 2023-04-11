<?php
declare(strict_types=1);

namespace Tests\Integration\Domain\Dto;


use App\Common\Exception\DateTimeRangeException;
use App\Common\Exception\ValidationException;
use App\Common\Exception\ValueNotFoundDtoException;
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
use Throwable;

class HistoricalQuotesGetDtoTest extends WebTestCase
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


    public function dataProvider(): array
    {
        $baseData = ['companySymbol' => 'AAPL', 'startDate' => '2023-02-01', 'endDate' => '2023-03-01', 'email' => 'some@mail.ru'];
        return [
            [$baseData, null],
            [array_merge($baseData, ['companySymbol' => '']), ValueNotFoundDtoException::class],
            [array_merge($baseData, ['startDate' => '']), ValueNotFoundDtoException::class],
            [array_merge($baseData, ['endDate' => '']), ValueNotFoundDtoException::class],
            [array_merge($baseData, ['email' => '']), ValueNotFoundDtoException::class],
            [['companySymbol' => '', 'startDate' => '', 'endDate' => '', 'email' => ''], ValueNotFoundDtoException::class],
            [[], ValueNotFoundDtoException::class],

            [array_merge($baseData, ['startDate' => '2023-09-01']), DateTimeRangeException::class],
            [array_merge($baseData, ['endDate' => '2023-01-01']), DateTimeRangeException::class],

            [array_merge($baseData, ['email' => '2313']), ValidationException::class],
            [array_merge($baseData, ['email' => 'dsd2313@d2.com']), ValidationException::class],
            [array_merge($baseData, ['email' => 'dsd2313@dds.co2m']), ValidationException::class],
        ];
    }

    /** @dataProvider dataProvider */
    public function testHistoricalQuotesGetDto(array $data, ?string $expectedException)
    {
        if ($expectedException)
            $this->expectException($expectedException);
        else
            $this->assertTrue(true);

        $dto = new HistoricalQuotesGetDto($data);
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