<?php

namespace App\Exception;

use Throwable;

class InvalidIpException extends \Exception
{
    private string $clientIp;

    public function __construct(
        string $clientIp,
        string $message = "Invalid IP",
        int $code = 403,
        ?Throwable $previous = null
    ) {
        $this->clientIp = $clientIp;
        parent::__construct($message, $code, $previous);
    }

    public function getClientIp(): string
    {
        return $this->clientIp;
    }
}