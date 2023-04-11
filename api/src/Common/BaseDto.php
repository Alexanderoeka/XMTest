<?php
declare(strict_types=1);


namespace App\Common;

use App\Common\Exception\ValueNotFoundDtoException;
use App\Common\ValueObject\DateTimeRange;
use App\Common\Exception\ValidationException;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use DateTime;
use Symfony\Component\Validator\Validation;


abstract class BaseDto
{

    private array $data = [];

    /** @throws Exception */
    public function __construct(RequestStack|array $incomingData)
    {

        switch (true) {
            case $incomingData instanceof RequestStack:

                $request = $incomingData->getMainRequest();
                $getParams = $request->query->all();
                $files = $request->files->all();
                $requests = $request->request->all();
                $jsonContent = json_decode($request->getContent(), true);
                $content = gettype($jsonContent) === 'array' ? $jsonContent : [];


                $result = array_merge($files, $requests, $content, $getParams);

                break;
            case gettype($incomingData) === 'array':

                $result = $incomingData;

                break;
            default:
                throw new Exception('Request is not type of Request of array');
        }

        $this->data = $result;
    }


    protected function getValue($key): mixed
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : null;
    }

    /**
     * @throws ValueNotFoundDtoException
     */
    protected function getValueSure($key): mixed
    {
        if (!array_key_exists($key, $this->data) || !$this->data[$key])
            throw new ValueNotFoundDtoException("Value with key $key not found in array \$data");
        return $this->data[$key];
    }

    protected function getFloatValue($key): ?float
    {
        return array_key_exists($key, $this->data) ? floatval($this->data[$key]) : null;
    }

    /**
     * @throws ValueNotFoundDtoException
     */
    protected function getFloatValueSure($key): float
    {
        if (!array_key_exists($key, $this->data) || !$this->data[$key])
            throw new ValueNotFoundDtoException("Value with key $key not found in array \$data");
        return floatval($this->data[$key]);
    }


    protected function getBoolValue($key, bool $default = false): bool
    {
        return array_key_exists($key, $this->data) ? boolval($this->data[$key]) : $default;
    }

    /** @throws Exception */
    protected function getDateValue($key): ?DateTime
    {
        return array_key_exists($key, $this->data) && !empty($this->data[$key]) && !is_null($this->data[$key]) ? new DateTime($this->data[$key]) : null;
    }

    /**
     * @throws Exception
     * @throws ValueNotFoundDtoException
     */
    protected function getDateValueSure(string $key): DateTime
    {
        if (!array_key_exists($key, $this->data) || !$this->data[$key])
            throw new ValueNotFoundDtoException("Value with key $key not found in array \$data");

        return new DateTime((string)$this->data[$key]);
    }

    /**
     * @throws Exception
     * @throws ValueNotFoundDtoException
     */
    protected function getDateValueFromUnixSure(string $key): DateTime
    {
        if (!array_key_exists($key, $this->data) || !$this->data[$key])
            throw new ValueNotFoundDtoException("Value with key $key not found in array \$data");

        return new DateTime("@{$this->data[$key]}");
    }

    /**
     * @throws Exception
     * @throws ValueNotFoundDtoException
     * @throws ValidationException
     */
    protected function getDateRangeSure(string $keyDateStart, string $keyDateEnd): DateTimeRange
    {
        return new DateTimeRange($this->getDateValueSure($keyDateStart), $this->getDateValueSure($keyDateEnd));
    }

    /**
     * @throws ValueNotFoundDtoException
     * @throws ValidationException
     */
    protected function getEmailValueSure(string $key): string
    {
        if (!array_key_exists($key, $this->data) || !$this->data[$key])
            throw new ValueNotFoundDtoException("Value with key $key not found in array \$data");

        if(!preg_match('/^.+@[a-zA-Z]+\.[a-zA-Z]+$/',$this->data[$key]))
            throw new ValidationException("Email with value : '{$this->data[$key]}' not valid",);

        return $this->data[$key];
    }

}