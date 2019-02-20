<?php

namespace Ami\AirbrakeBundle\EventListener;

use Airbrake\Notifier;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

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
     * @param GetResponseForExceptionEvent|ConsoleErrorEvent $event
     */
    public function onKernelException($event)
    {
        if ($event instanceof ConsoleErrorEvent) {
            $exception = $event->getError();
        } else {
            $exception = $event->getException();
        }

        foreach ($this->ignoredExceptions as $ignoredException) {
            if ($exception instanceof $ignoredException) {
                return;
            }
        }

        $this->notifier->notify($exception);
    }
}
