# AmiAirbrakeBundle

[Airbrake.io](https://airbrake.io) & [Errbit](https://github.com/errbit/errbit) integration for Symfony 6/7.
This bundle plugs the [Airbrake API client] into a Symfony project.

This is a fork of [aminin/airbrake-bundle](https://github.com/aminin/airbrake-bundle).

## Prerequisites

This version of the bundle requires Symfony 6.0+ and PHP 8.1+

## Installation

### Step 1: Download the bundle using composer

```shell
$ composer require nedlukies/airbrake-bundle
```

### Step 2: Enable the bundle

If it is not added automatically by Symfony Flex, register the bundle in `config/bundles.php`:

```php
<?php
// config/bundles.php

return [
    // ...
    Ami\AirbrakeBundle\AmiAirbrakeBundle::class => ['all' => true],
];
```

### Step 3: Configure the bundle

Add the following configuration to `config/packages/ami_airbrake.yaml`

```yml
# config/packages/ami_airbrake.yaml
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

    # Set to false when logging to a non-Airbrake server (e.g. Errbit)
    # to disable fetching the remote config from Airbrake.
    remote_config: true

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

You may access the [Notifier](https://github.com/airbrake/phpbrake#api) through dependency injection
by type-hinting `Airbrake\Notifier` (the service is private, so it cannot be fetched from the
container directly):

```php
use Airbrake\Notifier;

class MyService
{
    public function __construct(private Notifier $notifier)
    {
    }

    public function doSomething(): void
    {
        $this->notifier->addFilter(function ($notice) {
            $notice['context']['environment'] = 'production';
            return $notice;
        });
    }
}
```

## License

This bundle is under the MIT license. See the complete license in the [Resources/meta/LICENSE](Resources/meta/LICENSE)

## References

Airbrake API client: https://github.com/airbrake/phpbrake

[Airbrake API client]: https://github.com/airbrake/phpbrake
