# romans

A Simple PHP Roman Numerals Library

[![Build Status](https://travis-ci.org/wandersonwhcr/romans.svg?branch=master)](https://travis-ci.org/wandersonwhcr/romans)

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
        "wandersonwhcr/romans": "^1.0"
    }
}
```

## Advanced Usage

The `Romans` package uses a Lexer-Parser approach to convert Roman number to
Integer, using a Grammar Token library.

```php
use Romans\Grammar\Grammar;
use Romans\Lexer\Lexer;
use Romans\Parser\Parser;

$grammar = new Grammar();
$lexer   = new Lexer($grammar);
$parser  = new Parser($grammar);

$tokens = $lexer->tokenize('MCMXCIX');

/*
$tokens = [
    0 => 'M',  // Grammar::T_M
    1 => 'CM', // Grammar::T_CM
    2 => 'XC', // Grammar::T_XC
    3 => 'IX', // Grammar::T_IX
];
*/

$result = $parser->parse($tokens); // 1999
```

### Exception Handling

The filter `RomanToInt` uses Lexer to tokenize the input and Parser to build the
Integer number. When some error is found, the Lexer or Parser throw Exceptions
to notify the problem.

```php
use Romans\Filter\RomanToInt;
use Romans\Lexer\Exception as LexerException;
use Romans\Parser\Exception as ParserException;

$filter = new RomanToInt();

try {
    $filter->filter($input);
} catch (LexerException $e) {
    // Unknown Token
} catch (ParserException $e) {
    // Invalid Token Type (Not String)
    // Unknown Token
    // Invalid Roman Number
}
```

### Zero

The zero value is represented as `string` `"N"`, the initial of _nulla_ or of
_nihil_, the Latin word for "nothing" (see references).

```php
use Romans\Filter\RomanToInt;
use Romans\Filter\IntToRoman;

$filter = new RomanToInt();
$result = $filter->filter('N'); // 0 (Zero)

$filter = new IntToRoman();
$result = $filter->filter(0); // N
```

## References

* Rapid Tables: [How to Convert Roman Numerals to Numbers](http://www.rapidtables.com/convert/number/how-roman-numerals-to-number.htm)
* Wikipedia: [Zero in Roman Numerals](https://en.wikipedia.org/wiki/Roman_numerals#Zero)

## License

This package is opensource and available under license MIT described in
[LICENSE](https://github.com/wandersonwhcr/romans/blob/master/LICENSE).
