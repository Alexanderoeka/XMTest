<?php
declare(strict_types=1);

namespace Tests;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use LogicException;
use Symfony\Contracts\Service\Attribute\Required;

class DatabasePrimer
{


    public static function prime(KernelInterface $kernel)
    {

        if ('test' !== $kernel->getEnvironment())
            throw new LogicException('Primer must be executed in the test environment');

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $metadatas = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metadatas);
    }

}