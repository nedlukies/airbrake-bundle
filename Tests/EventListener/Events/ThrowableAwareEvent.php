<?php

namespace Ami\AirbrakeBundle\Tests\EventListener\Events;

class ThrowableAwareEvent
{
    private $throwable;

    public function __construct()
    {
        $this->throwable = new \Exception('Test throwable');
    }

    public function getThrowable()
    {
        return $this->throwable;
    }
}
