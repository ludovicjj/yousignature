<?php

namespace App\Subscriber;

use App\Exception\InvalidIpException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class InvalidIpExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof InvalidIpException) {
            $response = new JsonResponse([
                'message' => sprintf("Restricted access area limited to whitelisted IP addresses. Given IP : %s", $exception->getClientIp()),
                'code' => $exception->getCode()
            ], $exception->getCode());

            $event->setResponse($response);
        }
    }
}