# Installation

## Get the bundle using composer

Add SmileCronBundle by running this command from the terminal at the root of
your symfony project:

```bash
composer require smile/cron-bundle
```

## Enable the bundle

To start using the bundle, register the bundle in your application's kernel class:

```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Smile\CronBundle\SmileCronBundle(),
        // ...
    );
}
```

## Define global cron job

in your crontab, add

```cmd
* * * * * cd <your_project_root> && php app/console smile:cron
```

where <your_project_root> is your Symfony root.
