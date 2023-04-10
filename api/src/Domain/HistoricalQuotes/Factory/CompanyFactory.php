<?php


namespace App\Domain\HistoricalQuotes\Factory;


use App\Domain\HistoricalQuotes\Dto\CompanySelectDto;
use App\Domain\HistoricalQuotes\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;

class CompanyFactory
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function make(CompanySelectDto $dto, bool $flush = false): Company
    {
        $company = new Company();
        $company->setName($dto->name);
        $company->setSymbol($dto->symbol);

        $this->entityManager->persist($company);
        if ($flush)
            $this->entityManager->flush();

        return $company;
    }

    /** @param CompanySelectDto[] */
    public function makeALot(array $companiesDto)
    {
        foreach ($companiesDto as $dto) {
            $this->make($dto);
        }

        $this->entityManager->flush();
    }

}