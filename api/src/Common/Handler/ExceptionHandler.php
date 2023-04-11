<?php


namespace App\Common\Handler;

use App\Common\ValueObject\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;


class ExceptionHandler
{

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();


        $response = (new Response())->setMessage($exception->getMessage())->setSuccess(false)->setStatusCode($exception->getCode() ?: 404);
        $event->setResponse($response);
    }
}