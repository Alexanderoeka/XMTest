<?php
declare(strict_types=1);


namespace App\Common;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class BaseService
{

    private EntityManagerInterface $entityManager;

    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function persist(object $entity): void
    {
        $this->entityManager->persist($entity);
    }

    public function remove(object $entity): void
    {
        $this->entityManager->remove($entity);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }


    protected function sortArrayBy(array $array, string $key, int $order): array
    {
        $arrayColumn = array_column($array, $key);
        array_multisort($arrayColumn, $order, $array);

        return $array;
    }
}