<?php
declare(strict_types=1);


namespace App\Common;


use Symfony\Component\HttpFoundation\RequestStack;

class SearchDto extends BaseDto
{
    public string $search;

    public int $perPage;

    public int $page;

    public string $order;

    public string $orderBy;


    public function __construct(RequestStack|array $request)
    {
        parent::__construct($request);

        $this->search = $this->getValue('search');
        $this->perPage = $this->getValue('perPage');
        $this->page = $this->getValue('page');
        $this->order = $this->getValue('order');
        $this->orderBy = $this->getValue('orderBy');
    }


}