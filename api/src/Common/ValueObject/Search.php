<?php
declare(strict_types=1);


namespace App\Common\ValueObject;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

class Search
{
    private string $search;
    private string $order;
    private string $orderBy;


    public function __construct(string $search, string $order, string $orderBy)
    {
        $params = new ArrayCollection();
        $where = [];
        $whereClause = '';
        $orderClause = '';


        if ($search) {
            $where[] = " name like '%' || :search || '%' ";
            $params->add(new Parameter(':search', $search));
        }

        if ($orderBy) {
            $orderClause = " order by $orderBy $order ";
        }

        if ($where) {
            $whereClause = ' where ' . implode(' and ', $where) . ' ';
        }
    }

}