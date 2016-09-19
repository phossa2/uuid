# phossa2/uuid
[![Build Status](https://travis-ci.org/phossa2/uuid.svg?branch=master)](https://travis-ci.org/phossa2/uuid)
[![Code Quality](https://scrutinizer-ci.com/g/phossa2/uuid/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phossa2/uuid/)
[![PHP 7 ready](http://php7ready.timesplinter.ch/phossa2/uuid/master/badge.svg)](https://travis-ci.org/phossa2/uuid)
[![HHVM](https://img.shields.io/hhvm/phossa2/uuid.svg?style=flat)](http://hhvm.h4cc.de/package/phossa2/uuid)
[![Latest Stable Version](https://img.shields.io/packagist/vpre/phossa2/uuid.svg?style=flat)](https://packagist.org/packages/phossa2/uuid)
[![License](https://poser.pugx.org/phossa2/uuid/license)](http://mit-license.org/)

**phossa2/uuid** is a PHP library.

It requires PHP 5.4, supports PHP 7.0+ and HHVM. It is compliant with [PSR-1][PSR-1],
[PSR-2][PSR-2], [PSR-3][PSR-3], [PSR-4][PSR-4], and the proposed [PSR-5][PSR-5].

[PSR-1]: http://www.php-fig.org/psr/psr-1/ "PSR-1: Basic Coding Standard"
[PSR-2]: http://www.php-fig.org/psr/psr-2/ "PSR-2: Coding Style Guide"
[PSR-3]: http://www.php-fig.org/psr/psr-3/ "PSR-3: Logger Interface"
[PSR-4]: http://www.php-fig.org/psr/psr-4/ "PSR-4: Autoloader"
[PSR-5]: https://github.com/phpDocumentor/fig-standards/blob/master/proposed/phpdoc.md "PSR-5: PHPDoc"

Installation
---
Install via the `composer` utility.

```bash
composer require "phossa2/uuid"
```

or add the following lines to your `composer.json`

```json
{
    "require": {
       "phossa2/uuid": "^2.0.0"
    }
}
```

Design
---

Follows UUID format using 32 chars

- version: position 1 (1 char, from left)

  - uuid lib version

  - default to `2`

- data type: position 1 - 4 (4 chars)

  - 16bit, 65535

  - lib reserved types `1***`

  - custom type may use `[2-f]***`

- timestamp: position 5 - 19 (15 chars)

  - 60bit

  - can be used for at least 365 years

- shard: position 20 - 23 (4 chars)

  - 16bit, 65535

  - user provide this number

- vendor: position 24 - 27 (4 chars)

  - self claimed vendor id

- remain: position 28 - 31 (4 chars)

  - reserved for future expansion

Usage
---

Create the uuid instance,

```php
use Phossa2\Uuid\Uuid;

$uuid = new Uuid();
```

Features
---

- <a name="anchor"></a>**Feature One**


APIs
---

- <a name="api"></a>`LoggerInterface` related

Change log
---

Please see [CHANGELOG](CHANGELOG.md) from more information.

Testing
---

```bash
$ composer test
```

Contributing
---

Please see [CONTRIBUTE](CONTRIBUTE.md) for more information.

Dependencies
---

- PHP >= 5.4.0

- phossa2/shared >= 2.0.21

License
---

[MIT License](http://mit-license.org/)
