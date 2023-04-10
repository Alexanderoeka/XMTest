<?php
declare(strict_types=1);


namespace App\Common\Doctrine\Pagination;


use App\Common\CollectionTransformer;
use App\Common\SearchDto;
use App\Common\ValueObject\Response;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query;
use JetBrains\PhpStorm\ArrayShape;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

trait CollectionPaginationBuilder
{

    protected function generateCollection(AdapterInterface $doctrineAdapter, SearchDto $dto, $transformer): array
    {
        $paginator = new Pagerfanta($doctrineAdapter);
        $paginator->setCurrentPage($dto->page);
        $paginator->setMaxPerPage($dto->perPage);


        $filteredResults = $paginator->getCurrentPageResults();
        $resource = CollectionTransformer::getData($filteredResults, $transformer);


        return $resource;
    }

    protected function getResponseWithPaging(SearchDto $dto, Query $query, $transformer): Response
    {
        if ($dto->perPage === -1) {
            return new Response(CollectionTransformer::getData($query->getResult(), $transformer));
        }

        $doctrineAdapter = new QueryAdapter($query);

        $paginationData = $this->getPaginationData($dto, $doctrineAdapter);

        $data = $this->generateCollection($doctrineAdapter, $dto, $transformer);

        return new Response($data, $paginationData);
    }

    protected function getResponseWithPagingNative(SearchDto $dto, NativeQuery $query, $transformer): Response
    {
        if ($dto->perPage === -1) {
            return new Response(CollectionTransformer::getData($query->getResult(), $transformer));
        }

        $doctrineAdapter = new NativeQueryAdapter($query);

        $paginationData = $this->getPaginationData($dto, $doctrineAdapter);

        $data = $this->generateCollection($doctrineAdapter, $dto, $transformer);

        return new Response($data, $paginationData);
    }

    /** @param object[] $data */
    protected function getResponseWithPagingData(SearchDto $dto, array $data, $transformer): Response
    {
        if ($dto->perPage === -1) {
            return new Response(CollectionTransformer::getData($data, $transformer));
        }
        $arrayAdapter = new ArrayAdapter($data);

        $paginationData = $this->getPaginationData($dto, $arrayAdapter);

        $data = $this->generateCollection($arrayAdapter, $dto, $transformer);

        return new Response($data, $paginationData);
    }



    #[ArrayShape(['page' => "int|mixed", 'perPage' => "int|mixed", 'order' => "mixed|string", 'orderBy' => "mixed|string", 'pages' => "float", 'rows' => "int"])]
    private function getPaginationData(SearchDto $dto, AdapterInterface $adapter): array
    {
        $count = $adapter->getNbResults();
        $pages = ceil($count / $dto->perPage);

        return [
            'page' => $dto->page,
            'perPage' => $dto->perPage,
            'order' => $dto->order,
            'orderBy' => $dto->orderBy,
            'pages' => $pages,
            'rows' => $count
        ];
    }

}