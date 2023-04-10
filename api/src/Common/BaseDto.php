<?php
declare(strict_types=1);


namespace App\Common;

use App\Common\ValueObject\DateTimeRange;
use Symfony\Component\HttpFoundation\Request;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validation;
use DateTime;

abstract class BaseDto
{

    private array $data = [];

    /** @throws Exception */
    public function __construct(RequestStack|array $incomingData)
    {

        switch (true) {
            case $incomingData instanceof RequestStack:

                $request = $incomingData->getMainRequest();
                $uriData = $request->getUri();
                $urlData = $request->getBaseUrl();
                $a1 = $request->getRequestUri();
                $files = $request->files->all();
                $requests = $request->request->all();
                $jsonContent = json_decode($request->getContent(), true);
                $content = gettype($jsonContent) === 'array' ? $jsonContent : [];


                $result = array_merge($files, $requests, $content);

                break;
            case gettype($incomingData) === 'array':

                $result = $incomingData;

                break;
            default:
                throw new Exception('Request is not type of Request of array');
        }

        $this->data = $result;
    }


    public function getValue($key): mixed
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : null;
    }

    public function getValueSure($key): mixed
    {
        return $this->data[$key];
    }


    public function getBoolValue($key, bool $default = false): bool
    {
        return array_key_exists($key, $this->data) ? boolval($this->data[$key]) : $default;
    }

    /** @throws Exception */
    protected function getDateValue($key): ?DateTime
    {
        return array_key_exists($key, $this->data) && !empty($this->data[$key]) && !is_null($this->data[$key]) ? new DateTime($this->data[$key]) : null;
    }

    /** @throws Exception */
    protected function getDateValueSure(string $key): DateTime
    {
        return new DateTime($this->data[$key]);
    }

    /** @throws Exception */
    protected function getDateRangeSure(string $keyDateStart, string $keyDateEnd): DateTimeRange
    {
        return new DateTimeRange($this->getDateValueSure($keyDateStart), $this->getDateValueSure($keyDateEnd));
    }

    public function val()
    {
        $as = Validation::createValidator();
//        $as->validate();
    }

    protected function sanitizeString(?string $input): ?string
    {
        if ($input === null) {
            return null;
        }

        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }


}
