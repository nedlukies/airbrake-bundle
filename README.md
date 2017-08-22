# AmiAirbrakeBundle

[![Build Status](https://api.travis-ci.org/aminin/airbrake-bundle.svg)](https://travis-ci.org/aminin/airbrake-bundle)
[![Coding Style](https://img.shields.io/badge/phpcs-PSR--2-brightgreen.svg)](http://www.php-fig.org/psr/psr-2/)
[![Latest Stable Version](https://poser.pugx.org/aminin/airbrake-bundle/v/stable)](https://packagist.org/packages/aminin/airbrake-bundle)
[![Total Downloads](https://poser.pugx.org/aminin/airbrake-bundle/downloads)](https://packagist.org/packages/aminin/airbrake-bundle)
[![Latest Unstable Version](https://poser.pugx.org/aminin/airbrake-bundle/v/unstable)](https://packagist.org/packages/aminin/airbrake-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e4f817d0-3e47-4b9b-afa1-128eb1178749/mini.png)](https://insight.sensiolabs.com/projects/e4f817d0-3e47-4b9b-afa1-128eb1178749)
[![License](https://poser.pugx.org/aminin/airbrake-bundle/license)](https://packagist.org/packages/aminin/airbrake-bundle)

[Airbrake.io](https://airbrake.io) & [Errbit](https://github.com/errbit/errbit) integration for Symfony 2/3.

## Prerequisites

This version of the bundle requires Symfony 2.8+

## Installation

### Step 1: Download AmiAirbrakeBundle using composer

Add AmiAirbrakeBundle in your composer.json:

```shell
$ composer require aminin/airbrake-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Ami\AirbrakeBundle\AmiAirbrakeBundle(),
    );
}
```

### Step 3: Configure the AmiAirbrakeBundle

Add the following configuration to your `config.yml` file

```yml
# app/config/config.yml
ami_airbrake:
    project_id:  YOUR-PROJECT-ID
    project_key: YOUR-API-KEY
```

## Configuration reference

```yml
ami_airbrake:
    # This parameter is required
    # For Errbit the exact value of project_id doesn't matter
    project_id: YOUR-PROJECT-ID

    # Omit this key if you need to enable/disable the bundle temporarily 
    # If not given, this bundle will ignore all exceptions and won't send any data to remote.
    project_key: YOUR-API-KEY

    # By default, it is set to api.airbrake.io.
    # A host is a web address containing a scheme ("http" or "https"), a host and a port.
    # You can omit the scheme ("https" will be assumed) and the port (80 or 443 will be assumed).
    host: http://errbit.localhost:8000

    # You might want to ignore some exceptions such as http not found, access denied etc.
    # By default this bundle ignores all HttpException instances. (includes HttpNotFoundException, AccessDeniedException)
    # To log all exceptions leave this array empty.
    ignored_exceptions: ["Symfony\Component\HttpKernel\Exception\HttpException"]

parameters:
  # You may modify these parameters at your own risk
  ami_airbrake.notifier.class: 'Airbrake\Notifier'
  ami_airbrake.exception_listener.class: 'Ami\AirbrakeBundle\EventListener\ExceptionListener'
  ami_airbrake.shutdown_listener.class: 'Ami\AirbrakeBundle\EventListener\ShutdownListener'
```

## Usage

Once configured, bundle will automatically send exceptions/errors to airbrake server.

You may access the [Notifier](https://github.com/airbrake/phpbrake#api) as `ami_airbrake.notifier` service

```php
    /** @var ContainerInterface $container */
    $container->get('ami_airbrake.notifier')->addFilter(function ($notice) {
        $notice['context']['environment'] = 'production';
        return $notice;
    });
```

## License

This bundle is under the MIT license. See the complete license in the [Resources/meta/LICENSE](Resources/meta/LICENSE)
