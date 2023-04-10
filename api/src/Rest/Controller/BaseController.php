<?php
declare(strict_types=1);


namespace App\Rest\Controller;


use App\Common\Doctrine\Pagination\CollectionPaginationBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    use CollectionPaginationBuilder;
}