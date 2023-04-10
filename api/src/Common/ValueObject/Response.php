<?php

declare(strict_types=1);

namespace App\Common\ValueObject;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\JsonResponse;

class Response extends JsonResponse
{


    public function __construct(mixed $data, array $paginationData = [])
    {
        $data = ['data' => $data];
        $paginationData = $paginationData ? ['pagination' => $paginationData] : [];
        $success = ['success' => true];

        $result = array_merge($data, $paginationData, $success);
        parent::__construct($result);
    }


    public function setSuccess(bool $success): static
    {
        $this->data['success'] = $success;
        return $this;
    }

    public function setAdditionalData(string $key, mixed $additionalData): static
    {
        $this->data[$key] = $additionalData;
        return $this;
    }

}
