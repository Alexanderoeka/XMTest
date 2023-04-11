<?php
declare(strict_types=1);

namespace Tests\Integration;

use App\Domain\HistoricalQuotes\Entity\Company;
use App\Domain\HistoricalQuotes\HistoricalQuotesService;
use App\Domain\HistoricalQuotes\Repository\CompanyRepository;
use Tests\DatabasePrimer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Exception;

class IntegrationSomeTest extends KernelTestCase
{


    private EntityManagerInterface $entityManager;

    private HistoricalQuotesService $historicalQuotesService;


    protected function setUp(): void
    {
        try {
            $kernel = self::bootKernel();


            DatabasePrimer::prime($kernel);

            $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();


            $this->historicalQuotesService = $this->getContainerVar(static::getContainer()->get(HistoricalQuotesService::class), HistoricalQuotesService::class);

        } catch (Exception $e) {
            return;
        }

    }


    public function testWork()
    {
        $this->assertTrue(true);

        /** @var CompanyRepository $companyRepository */
        $companyRepository = $this->entityManager->getRepository(Company::class);

        $companyId = $companyRepository->getOne()['id'];

        $company = $companyRepository->find($companyId);


//        $this->expectOutputString(json_encode($company->getName()));


        $this->entityManager->remove($company);


        $this->entityManager->flush();
    }




    /** @throws Exception */
    private function getContainerVar(?object $variable, string $type): mixed
    {
        if (!$variable instanceof $type)
            throw new Exception("Variable $variable is not type of $type");

        return $variable;
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
    }


}