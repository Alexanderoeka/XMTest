<?php
declare(strict_types=1);

namespace App\Common;


use App\Common\Exception\ValueNotFoundDtoException;

class CollectionDto
{

    public static function getData(array $data, string $dtoType): array
    {
        $collectionDto = [];
        foreach ($data as $element) {

            try {
                $dto = new $dtoType($element);
                $collectionDto[] = $dto;
            } catch (ValueNotFoundDtoException $e) {
                continue;
            }

        }
        return $collectionDto;
    }

}