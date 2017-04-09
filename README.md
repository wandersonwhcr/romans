# romans

A Simple PHP Roman Numerals Library

## Usage

This library includes a simple couple of filters to convert a `string` with
Roman number to an `int` that represents the input as decimal, and decimal `int`
to a `string` with Roman number as result.

```php
use Romans\Filter\RomanToInt;

$filter = new RomanToInt();
$result = $filter->filter('MCMXCIX'); // 1999
```

```php
use Romans\Filter\IntToRoman;

$filter = new IntToRoman();
$result = $filter->filter(1999); // MCMXCIX
```

## Installation

This package uses Composer as default repository. You can install it adding the
name of package in `require` section of `composer.json`, pointing to the last
stable version.

```json
{
    "require": {
        "wandersonwhcr/romans": "1.0.*"
    }
}
```
