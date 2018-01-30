# romans

A Simple PHP Roman Numerals Library

[![Build Status](https://travis-ci.org/wandersonwhcr/romans.svg?branch=master)](https://travis-ci.org/wandersonwhcr/romans)
[![Latest Stable Version](https://poser.pugx.org/wandersonwhcr/romans/v/stable?format=flat)](https://packagist.org/packages/wandersonwhcr/romans)
[![License](https://poser.pugx.org/wandersonwhcr/romans/license?format=flat)](https://packagist.org/packages/wandersonwhcr/romans)

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

## Integrations

This library can be used as dependency for other projects, making integrations
with other libraries or frameworks easier. If you want to add more items in this
list, please, open an issue or create a pull request.

* [Illuminate Romans](https://github.com/wandersonwhcr/illuminate-romans): Laravel Illuminate Romans Integration
* [Zend Romans](https://github.com/wandersonwhcr/zend-romans): Zend Framework Romans Integration

## Advanced Usage

The `Romans` package uses a Lexer-Parser approach and a Deterministic Finite
Automaton (DFA) to convert Roman number to Integer, using a Grammar Token
library.

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
Integer number. When some error is found, the Lexer or Parser throw Exceptions
to notify the problem with specific code.

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
block to check if `$input` is valid. Also, you can validate if an Integer can be
filtered to Roman using a `IntToRoman` filter.

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

## Techniques

This section describes some techniques this package uses to convert Roman
numbers into integer and vice-versa.

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
`char` set and your position inside input.

### Deterministic Finite Automaton (DFA)

A DFA was developed to check if a string with Roman number is valid. This
technique was choiced because some implementations simply convert the `$input`
without checking some rules, like four chars sequentially.

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
g -> f | Nz  | Mg
```

## References

* Rapid Tables: [How to Convert Roman Numerals to Numbers](http://www.rapidtables.com/convert/number/how-roman-numerals-to-number.htm)
* Wikipedia: [Zero in Roman Numerals](https://en.wikipedia.org/wiki/Roman_numerals#Zero)
* Wikipedia: [Lexical Analysis](https://en.wikipedia.org/wiki/Lexical_analysis)
* Wikipedia: [Parsing](https://en.wikipedia.org/wiki/Parsing)
* Wikipedia: [Deterministic Finite Automaton](https://en.wikipedia.org/wiki/Deterministic_finite_automaton)

## License

This package is opensource and available under license MIT described in
[LICENSE](https://github.com/wandersonwhcr/romans/blob/master/LICENSE).
