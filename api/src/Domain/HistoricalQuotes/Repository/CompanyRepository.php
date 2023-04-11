<?php
declare(strict_types=1);

namespace App\Domain\HistoricalQuotes\Repository;

use App\Domain\HistoricalQuotes\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    protected $_entityName = Company::class;


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function getOne()
    {
        $sql = <<<SQL
                select symbol, id from company order by random() limit 1
            SQL;

        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('symbol','symbol');
        $rsm->addScalarResult('id','id');

        $query = $this->_em->createNativeQuery($sql, $rsm);

        $result = $query->getResult()[0];
        return $result;
    }

    public function getCompaniesLike(string $symbol): NativeQuery
    {
        $sql = <<<SQL
            select * from company c
            where c.symbol ~*  ('^' || :symbol || '.*')
            order by c.symbol limit 10;
        SQL;

        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(Company::class, 'c');


        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->setParameter(':symbol', $symbol);

        return $query;
    }
}
