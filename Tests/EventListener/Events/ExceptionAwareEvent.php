<?php

namespace Ami\AirbrakeBundle\Tests\EventListener\Events;

class ExceptionAwareEvent
{
    private $exception;

    public function __construct()
    {
        $this->exception = new \Exception('Test exception');
    }

    public function getError()
    {
        return $this->exception;
    }
}
