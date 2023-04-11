<?php
declare(strict_types=1);


namespace App\Domain\HistoricalQuotes\Entity;

use App\Domain\HistoricalQuotes\Repository\CompanyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;


#[Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[Id, Column(name: 'id', type: Types::INTEGER), GeneratedValue()]
    private int $id;

    #[Column(type: Types::STRING, length: 255)]
    private string $name;

    #[Column(type: Types::STRING, length: 255)]
    private string $symbol;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }


}