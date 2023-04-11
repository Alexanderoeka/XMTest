<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\HistoricalQuotes\Entity\Company;
use App\Domain\HistoricalQuotes\Repository\CompanyRepository;
use Symfony\Component\Console\Output\OutputInterface;
use Tests\DatabasePrimer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SomeTest extends KernelTestCase
{

    private EntityManagerInterface $entityManager;


    protected function setUp(): void
    {
        $kernel = self::bootKernel();


        DatabasePrimer::prime($kernel);

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }


    public function testWork()
    {
        $this->assertTrue(true);

        /** @var CompanyRepository $companyRepository */
        $companyRepository = $this->entityManager->getRepository(Company::class);

        $company = $companyRepository->getOne();


        $this->assertNull(null);


    }


    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
    }

}