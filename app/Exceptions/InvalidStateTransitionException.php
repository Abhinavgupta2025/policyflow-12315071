<?php

namespace App\Exceptions;

use RuntimeException;

class InvalidStateTransitionException extends RuntimeException
{
    public function __construct(string $fromState, string $toState, string $message = '')
    {
        $defaultMsg = "Illegal state transition from '{$fromState}' to '{$toState}'.";
        parent::__construct($message ?: $defaultMsg, 409);
    }
}
