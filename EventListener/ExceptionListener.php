<?php

namespace Ami\AirbrakeBundle\EventListener;

use Airbrake\Notifier;

class ExceptionListener
{
    /**
     * @var Notifier
     */
    protected $notifier;

    /**
     * @var array
     */
    protected $ignoredExceptions;

    /**
     * @param Notifier $notifier
     * @param array    $ignoredExceptions
     */
    public function __construct(Notifier $notifier, array $ignoredExceptions = [])
    {
        $this->notifier = $notifier;
        $this->ignoredExceptions = $ignoredExceptions;
    }

    /**
     * @param $event
     */
    public function onKernelException($event)
    {
        if (method_exists($event, 'getThrowable')) {
            $exception = $event->getThrowable();
        } elseif (method_exists($event, 'getError')) {
            $exception = $event->getError();
        } elseif (method_exists($event, 'getException')) {
            $exception = $event->getException();
        } else {
            $exception = null;
        }

        foreach ($this->ignoredExceptions as $ignoredException) {
            if ($exception instanceof $ignoredException) {
                return;
            }
        }

        $this->notifier->notify($exception);
    }
}
