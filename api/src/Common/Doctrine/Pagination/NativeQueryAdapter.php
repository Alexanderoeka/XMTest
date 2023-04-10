<?php

namespace App\Common\Doctrine\Pagination;


use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMapping;
use Pagerfanta\Adapter\AdapterInterface;
use Traversable;

class NativeQueryAdapter implements AdapterInterface
{
    private NativeQuery $query;

    public function __construct(NativeQuery $query)
    {
        $this->query = $query;
    }

    public function getNbResults(): int
    {
        $em = $this->query->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('cnt', 'cnt');
        $countQuery = $em->createNativeQuery('SELECT COUNT(1) AS cnt FROM (' . $this->query->getSQL() . ') sqCountPage', $rsm);

        $countQuery->setParameters($this->query->getParameters());

        return (int)$countQuery->getSingleScalarResult();
    }

    public function getSlice(int $offset, int $length): array|Traversable
    {
        $cloneQuery = clone $this->query;
        $cloneQuery->setParameters($this->query->getParameters());

        foreach ($this->query->getHints() as $name => $value) {
            $cloneQuery->setHint($name, $value);
        }

        //add on limit and offset
        $sql = $cloneQuery->getSQL();
        $sql .= " LIMIT $length OFFSET $offset";
        $cloneQuery->setSQL($sql);

        return $cloneQuery->getResult();
    }
}
