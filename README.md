# phossa2/uuid
[![Build Status](https://travis-ci.org/phossa2/uuid.svg?branch=master)](https://travis-ci.org/phossa2/uuid)
[![Code Quality](https://scrutinizer-ci.com/g/phossa2/uuid/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/phossa2/uuid/)
[![Code Climate](https://codeclimate.com/github/phossa2/uuid/badges/gpa.svg)](https://codeclimate.com/github/phossa2/uuid)
[![PHP 7 ready](http://php7ready.timesplinter.ch/phossa2/uuid/master/badge.svg)](https://travis-ci.org/phossa2/uuid)
[![HHVM](https://img.shields.io/hhvm/phossa2/uuid.svg?style=flat)](http://hhvm.h4cc.de/package/phossa2/uuid)
[![Latest Stable Version](https://img.shields.io/packagist/vpre/phossa2/uuid.svg?style=flat)](https://packagist.org/packages/phossa2/uuid)
[![License](https://img.shields.io/:license-mit-blue.svg)](http://mit-license.org/)

**phossa2/uuid** is a PHP library for generating sequential UUID to be used as
primary key in databases.

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
       "phossa2/uuid": "2.*"
    }
}
```

Features
---

- <a name="seq"></a>**Ordered UUID**

  According to article [Store UUID in an optimized way](https://www.percona.com/blog/2014/12/19/store-uuid-optimized-way/),
  Non-ordered UUID has big impact on Mysql db insert performance.

- <a name="type"></a>**Typed UUID**

  Instead of following RFC 4122 for generating UUID, we adopted a new design
  with data types built in. For example, user id has the type of `1010`. And
  any user id using this lib will start with '2101-0'

- <a name="shard"></a>**Sharding supported**

  With sharding bits built-in, it is easy to shard your db tables.

- <a name="good"></a>**Ready for extension**

  As long as the timestamp algorithm is good enough, it will guarantee
  uniqueness at least inside one vendor's house.

Design
---

Using 32 chars, without `-`

```
 2xxx - xxxx - xxxx - xxxx - xxxx - xxxx - xxxx - xxxx
 ^ ^^^^^^ ^^^^^^^^^^^^^^^^^^^^^^^   ^^^^   ^^^^ ^^^^^^
ver type          timestamp         shard  vendor remain
```

- version: position 0, 1 char

  - this uuid lib version

  - default to `2`

- data type: position 1 - 4, 4 chars

  - 16bit, 65535

  - lib reserves types `1***`

  - custom types starts from `[2-f]***`

- timestamp: position 5 - 19, 15 chars

  - 60bit

  - can be used for at least 360 years

- shard: position 20 - 23, 4 chars

  - 16bit, 65535

  - for sharding purpose, provided by user

- vendor: position 24 - 27 (4 chars)

  - vendor id provided by user

- remain: position 28 - 31 (4 chars)

  - reserved for future usage

Usage
---

```php
use Phossa2\Uuid\Uuid;

// 2100020bc58eb7f18602000100010000
$uuid = Uuid::get();

// encode/shorten it, can be used in URL
if (Uuid::isValid($uuid)) {
    // AWprUw7urpN8bbQ4LciGNa
    $short = Uuid::encode($uuid);

    // decode
    var_dump($uuid === Uuid::decode($short)); // true
}
```

Extend `Phossa2\Uuid\Uuid` with your own settings or algorithm,

```php
class MyUuid extends Uuid
{
    /*
     * use this vendor id
     *
     * {@inheritDoc}
     */
    protected $vendor = '1234';

    /*
     * use this more reliable sequence
     *
     * {@inheritDoc}
     */
    protected function getSequence()
    {
         // ...
    }
}
```

APIs
---

- <a name="api"></a>`UuidInterface`

  - `Uuid::get(string $dataType, string $shardId): string`

    Both parameters are optional.

- <a name="api2"></a>`UtilityInterface`

  - `Uuid::isValid(string $uuid): bool`

    Check `$uuid` valid or not.

  - `Uuid::info(string $uuid): array`

    Get detail information about this `$uuid` including `version`, `type`,
    `time`, `vendor`, `remain`.

  - `Uuid::encode(string $uuid): string`

    Encode `$uuid` into a short version (base56)

  - `Uuid::decode(string $string): string`

    Decode the short version into full 32-char UUID

Predefined data types
---

- Generic OID `UuidInterface::TYPE_OID`, value `1000`.

- User id `UuidInterface::TYPE_USER`, value `1010`.

- Post or article `UuidInterface::TYPE_POST`, value `1020`.

- News `UuidInterface::TYPE_NEWS`, value `1021`.

- Image `UuidInterface::TYPE_IMAGE`, value `1030`.

- Image album `UuidInterface::TYPE_ALBUM`, value `1031`.

- Comment `UuidInterface::TYPE_COMM`, value `1040`.

- Rating `UuidInterface::TYPE_RATE`, value `1041`.

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
