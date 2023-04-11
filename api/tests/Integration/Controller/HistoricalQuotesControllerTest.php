<?php
declare(strict_types=1);

namespace Tests\Integration\Controller;


use App\Domain\HistoricalQuotes\Entity\Company;
use App\Domain\HistoricalQuotes\HistoricalQuotesService;
use App\Domain\HistoricalQuotes\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\DatabasePrimer;
use Exception;

class HistoricalQuotesControllerTest extends WebTestCase
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


    public function companiesProvider(): array
    {
        return [
            ['A', true],
            ['B', true],
            ['C', true],
            ['Aqeqefqef21341f', false],
            ['Aqegwqefqef2134d1231f', false],
            ['A113qeqefqef21341f', false],
        ];
    }

    /** @dataProvider companiesProvider */
    public function testGetCompaniesLike(string $symbol, bool $isReturn)
    {
        $this->client->request('GET', "/api/companies-name-symbol/get/{$symbol}");
        $content = json_decode($this->client->getResponse()->getContent(), true);

        $true = ($isReturn ? count($content['data']) > 0 : count($content['data']) === 0);

        $this->assertTrue($true);
        $this->assertTrue($content['success']);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
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