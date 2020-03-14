<?php

namespace Ami\AirbrakeBundle\Tests\EventListener\Events;

class ErrorAwareEvent
{
    private $error;

    public function __construct()
    {
        $this->error = new \Exception('Test error');
    }

    public function getError()
    {
        return $this->error;
    }
}
