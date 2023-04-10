<?php

declare(strict_types=1);

namespace App\Common\ValueObject;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\JsonResponse;

class Response extends JsonResponse
{


    public function __construct(mixed $data = '', array $paginationData = [])
    {
        $data = ['data' => $data];
        $paginationData = $paginationData ? ['pagination' => $paginationData] : [];
        $success = ['success' => true];

        $result = array_merge($data, $paginationData, $success);
        parent::__construct($result);
    }


    public function setSuccess(bool $success): static
    {
        $this->setDataValue('success',$success);
        return $this;
    }

    public function setAdditionalData(string $key, mixed $additionalData): static
    {
        $this->setDataValue($key,$additionalData);
        return $this;
    }

    public function setMessage(string $message): static
    {
        $this->setDataValue('message',$message);
        return $this;
    }

    private function setDataValue($key, $value)
    {
        $decodedData = json_decode($this->data, true);
        $decodedData[$key] = $value;
//        $encodedData = json_encode($decodedData);

        self::setData($decodedData);
//        $this->data = $encodedData;
    }

}
