# romans

A Simple PHP Roman Numerals Library

[![Build Status](https://github.com/wandersonwhcr/romans/actions/workflows/test.yml/badge.svg?branch=main)](https://github.com/wandersonwhcr/romans/actions/workflows/test.yml?query=branch%3Amain)
[![Updated](https://github.com/wandersonwhcr/romans/actions/workflows/updated.yml/badge.svg)](https://github.com/wandersonwhcr/romans/actions/workflows/updated.yml)
[![Latest Stable Version](https://poser.pugx.org/wandersonwhcr/romans/v/stable?format=flat)](https://packagist.org/packages/wandersonwhcr/romans)
[![codecov](https://codecov.io/gh/wandersonwhcr/romans/branch/main/graph/badge.svg)](https://codecov.io/gh/wandersonwhcr/romans)
[![License](https://poser.pugx.org/wandersonwhcr/romans/license?format=flat)](https://packagist.org/packages/wandersonwhcr/romans)

## Usage

This library includes a simple couple of filters to convert a `string` with
Roman number to an `int` that represents the input as decimal and decimal `int`
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

This package uses
[Composer](https://packagist.org/packages/wandersonwhcr/romans) as default
repository. You can install it adding the name of package in `require` section
of `composer.json`, pointing to the last stable version.

```json
{
  "require": {
    "wandersonwhcr/romans": "^1.0"
  }
}
```

Also, Romans uses Semantic Versioning. The following package versions support
these PHP releases:

* Romans `1.0.*`: PHP `^7.0` (Augustus)
* Romans `1.1.*`: PHP `^7.0` (Tiberius)
* Romans `1.2.*`: PHP `>=7.4` (Caligula)
* Romans `1.3.*`: PHP `>=7.4` (Claudius)
* Romans `1.4.*`: PHP `>=7.4` (Nero)
* Romans `1.5.*`: PHP `>=8.0` (Galba)

## Integrations

This library can be used as dependency for projects, making integrations with
libraries or frameworks easier. If you want to add more items in this list,
please, open an issue or create a pull request, adding your project
alphabetically.

* [Illuminate Romans](https://github.com/wandersonwhcr/illuminate-romans): Laravel Illuminate Romans Integration
* [Kirby Romans](https://github.com/moevbiz/k3-romans): Kirby CMS Integration
* [Laminas Romans](https://github.com/wandersonwhcr/laminas-romans): Laminas Project Romans Integration
* [Plates Romans Extension](https://github.com/wandersonwhcr/plates-romans): Plates Extension
* [Twig Roman Numerals Extension](https://github.com/EmilMassey/twig-roman-numerals): Twig Extension (Symfony, WordPress + Timber)
* ~~[Zend Romans](https://github.com/wandersonwhcr/zend-romans): Zend Framework Romans Integration~~ **DEPRECATED**

## Advanced Usage

The `Romans` package uses a Lexer-Parser approach and a Deterministic Finite
Automaton (DFA) to convert Roman number to `int`, using a Grammar Token library.

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
    0 => 'M'  // Grammar::T_M
    1 => 'C', // Grammar::T_C
    2 => 'M', // Grammar::T_M
    3 => 'X', // Grammar::T_X
    4 => 'C', // Grammar::T_C
    5 => 'I', // Grammar::T_I
    6 => 'X', // Grammar::T_X
];
*/

$result = $parser->parse($tokens); // 1999
```

### Exception Handling

The filter `RomanToInt` uses Lexer to tokenize the input and Parser to build the
`int` number. When errors are found, the Lexer or Parser throw Exceptions to
notify the problem with a specific code.

```php
use Romans\Filter\RomanToInt;
use Romans\Lexer\Exception as LexerException;
use Romans\Parser\Exception as ParserException;

$filter = new RomanToInt();

try {
    $filter->filter($input);
} catch (LexerException $e) {
    // Unknown Token (LexerException::UNKNOWN_TOKEN)
} catch (ParserException $e) {
    // Invalid Token Type (Not String) (ParserException::INVALID_TOKEN_TYPE)
    // Unknown Token (ParserException::UNKNOWN_TOKEN)
    // Invalid Roman (ParserException::INVALID_ROMAN)
}
```

You can use this structure to validate Roman numbers, adding a _try..catch_
block to check if `$input` is valid. Also, you can validate if an `int` can be
filtered to Roman using an `IntToRoman` filter.

```php
use Romans\Filter\IntToRoman;
use Romans\Filter\Exception as FilterException;

$filter = new IntToRoman();

try {
    $filter->filter($input);
} catch (FilterException $e) {
    // Invalid Integer (< 0) (FilterException::INVALID_INTEGER)
}
```

### Zero

The zero value is represented as `string` `"N"`, the initial of _nulla_ or
_nihil_, the Latin word for "nothing" (see references).

```php
use Romans\Filter\RomanToInt;
use Romans\Filter\IntToRoman;

$filter = new RomanToInt();
$result = $filter->filter('N'); // 0 (Zero)

$filter = new IntToRoman();
$result = $filter->filter(0); // N
```

### Cache

This package uses [PSR-6 Caching Interface](https://www.php-fig.org/psr/psr-6)
to improve execution, mainly over loops (like `while` or `foreach`) using cache
libraries. Any PSR-6 implementation can be used and we suggest
[Symfony Cache](https://packagist.org/packages/symfony/cache) package.

```php
use Romans\Filter\IntToRoman;
use Romans\Filter\RomanToInt;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

$cache = new ArrayAdapter();

$filter = new RomanToInt();
$filter->setCache($cache);
$result = $filter->filter('MCMXCIX'); // 1999
$result = $filter->filter('MCMXCIX'); // 1999 (from cache)

$filter = new IntToRoman();
$filter->setCache($cache);
$result = $filter->filter(1999); // MCMXCIX
$result = $filter->filter(1999); // MCMXCIX (from cache)
```

## Development

You can use Docker Compose to build an image and run a container to develop and
test this package.

```bash
docker-compose build
docker-compose run --rm romans composer install
docker-compose run --rm romans composer test
```

## Techniques

This section describes techniques used by this package to convert Roman numbers
into `int` and vice-versa.

### Lexer-Parser

A Lexer-Parser approach was chosen because the validating and reading of Roman
numbers are more simplified: the Lexer is responsible for reading and transform
the input into tokens, validating content at char level; and the Parser is
responsible for transform tokens into numbers, validating content at position
level and converting to `int` through a DFA.

Wikipedia says that "lexical analysis is the process of converting a sequence of
characters into a sequence of tokens", that "is a structure representing a
lexeme that explicity indicates its categorization for the purpose of parsing".
Even, Wikipedia says that "parsing or syntax analysis is the process of
analysing symbols conforming to the rules of a formal grammar".

This structure makes easier the development of a structure responsible to read
an input `string`, converting it to another structure according to specific
charset and its position inside input.

### Deterministic Finite Automaton (DFA)

A DFA was developed to check if a `string` with Roman number is valid. This
technique was choiced because other implementations simply convert the input
without checking rules, like four chars sequentially.

The current automaton definition is declared below.

```plain
M  = (Q, Σ, δ, q0, F)
Q  = { a, b, c, d, e, f, g, y, z }
Σ  = { I, V, X, L, C, D, M, N }
q0 = g
F  = { z }

z -> ε
y -> $z
a -> y | Iy  | IIy | IIIy
b -> a | IVy | Va  | IXy
c -> b | Xb  | XXb | XXXb
d -> c | XLb | Lc  | XCb
e -> d | Cd  | CCd | CCCd
f -> e | CDd | De  | CMd
g -> f | Ny  | Mg
```

## References

* Rapid Tables: [How to Convert Roman Numerals to Numbers](http://www.rapidtables.com/convert/number/how-roman-numerals-to-number.htm)
* Wikipedia: [Zero in Roman Numerals](https://en.wikipedia.org/wiki/Roman_numerals#Zero)
* Wikipedia: [Lexical Analysis](https://en.wikipedia.org/wiki/Lexical_analysis)
* Wikipedia: [Parsing](https://en.wikipedia.org/wiki/Parsing)
* Wikipedia: [Deterministic Finite Automaton](https://en.wikipedia.org/wiki/Deterministic_finite_automaton)

## License

This package is opensource and available under MIT license described in
[LICENSE](https://github.com/wandersonwhcr/romans/blob/main/LICENSE).
