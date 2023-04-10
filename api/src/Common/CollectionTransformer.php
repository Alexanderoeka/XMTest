<?php
declare(strict_types=1);


namespace App\Common;


class CollectionTransformer
{
    public static function getData(iterable $data, $transformer): array
    {
        $resultData = [];
        foreach ($data as $one) {
            $resultData[] = $transformer->transform($one);
        }
        return $resultData;
    }
}