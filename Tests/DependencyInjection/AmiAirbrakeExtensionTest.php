<?php

namespace Ami\AirbrakeBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\Reference;
use Ami\AirbrakeBundle\DependencyInjection\AmiAirbrakeExtension;

class AmiAirbrakeExtensionTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var AmiAirbrakeExtension
     */
    private $extension;

    protected function setUp(): void
    {
        $this->container = new ContainerBuilder(new ParameterBag([
            'kernel.project_dir'    => __DIR__,
            'kernel.bundles'     => ['AmiAirbrakeBundle' => true],
            'kernel.environment' => 'test',
        ]));
        $this->extension = new AmiAirbrakeExtension();
    }

    protected function tearDown(): void
    {
        unset($this->container, $this->extension);
    }

    public function testEnableAmiAirbrakeNotifier()
    {
        $config = ['ami_airbrake' => [
            'project_id' => 42,
            'project_key' => 'foo-bar',
        ]];
        $this->extension->load($config, $this->container);

        $this->assertTrue($this->container->hasDefinition('ami_airbrake.notifier'));
    }

    public function testDisableAmiAirbrakeNotifier()
    {
        $config = ['ami_airbrake' => [
            'project_id' => 42,
            'project_key' => null,
        ]];
        $this->extension->load($config, $this->container);

        $this->assertFalse($this->container->hasDefinition('ami_airbrake.notifier'));
    }
}
