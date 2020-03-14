<?php

namespace Ami\AirbrakeBundle\Tests\EventListener;

use Ami\AirbrakeBundle\EventListener\ExceptionListener;
use PHPUnit\Framework\TestCase;
use Airbrake\Notifier;

class ExceptionListenerTest extends TestCase
{
    /**
     * @var Notifier
     */
    private $notifier;

    /**
     * @var ExceptionListener
     */
    private $listener;

    protected function setUp(): void
    {
        $this->notifier = $this->createMock(Notifier::class);
        $this->listener = new ExceptionListener($this->notifier);
    }

    protected function tearDown(): void
    {
        unset($this->container, $this->extension);
    }

    public function testNotifyOnException()
    {
        $this->notifier->expects($this->once())->method('notify')->with(
            $this->callback(function ($subject) {
                return $subject->getMessage() == 'Test exception';
            })
        );
        $this->listener->onKernelException(new Events\ExceptionAwareEvent());
    }

    public function testNotifyOnError()
    {
        $this->notifier->expects($this->once())->method('notify')->with(
            $this->callback(function ($subject) {
                return $subject->getMessage() == 'Test error';
            })
        );
        $this->listener->onKernelException(new Events\ErrorAwareEvent());
    }

    public function testNotifyOnThrowable()
    {
        $this->notifier->expects($this->once())->method('notify')->with(
            $this->callback(function ($subject) {
                return $subject->getMessage() == 'Test throwable';
            })
        );
        $this->listener->onKernelException(new Events\ThrowableAwareEvent());
    }
}
