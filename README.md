LswSecureControllerBundle
==================

Provide Security From Namespace to actions in controllers by specifying required roles.

NB: This bundle was created because the [JMSSecurityExtraBundle](https://github.com/schmittjoh/JMSSecurityExtraBundle) is no 
longer provided in Symfony 2.3 (due to a license incompatibility) and we needed this type of features

## Requirements

* PHP 5.3
* Symfony 2.3

## Installation

Installation is broken down in the following steps:

1. Download ReflexeSecurityBundle using composer
2. Enable the Bundle

### Step 1: Download LswSecureControllerBundle using composer

Add ReflexeSecurityBundle in your composer.json:

```js
{
    "require": {
        "Reflexe/SecurityBundle": "*",
        ...
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update Reflexe/SecurityBundle
```

Composer will install the bundle to your project's `vendor/Reflexe` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Reflexe\Bundle\SecurityBundle\ReflexeSecurityBundle(),
    );
}
```

Note that you can configure the firewall in ```app/config/security.yml```.

