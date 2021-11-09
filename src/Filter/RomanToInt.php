<?php

declare(strict_types=1);

namespace Romans\Filter;

use Romans\Cache\CacheAwareTrait;
use Romans\Grammar\Grammar;
use Romans\Lexer\Lexer;
use Romans\Parser\Parser;

/**
 * Roman to Int
 */
class RomanToInt
{
    use CacheAwareTrait;

    /**
     * Lexer
     */
    private Lexer $lexer;

    /**
     * Parser
     */
    private Parser $parser;

    /**
     * Default Constructor
     *
     * @param Grammar $grammar Grammar Object
     */
    public function __construct(?Grammar $grammar = null)
    {
        $grammar ??= new Grammar();

        $this
            ->setLexer(new Lexer($grammar))
            ->setParser(new Parser($grammar));
    }

    /**
     * Set Lexer
     *
     * @param  Lexer $lexer Lexer Object
     * @return self  Fluent Interface
     */
    public function setLexer(Lexer $lexer): self
    {
        $this->lexer = $lexer;
        return $this;
    }

    /**
     * Get Lexer
     *
     * @return Lexer Lexer Object
     */
    public function getLexer(): Lexer
    {
        return $this->lexer;
    }

    /**
     * Set Parser
     *
     * @param  Parser $parser Parser Object
     * @return self   Fluent Interface
     */
    public function setParser(Parser $parser): self
    {
        $this->parser = $parser;
        return $this;
    }

    /**
     * Get Parser
     *
     * @return Parser Parser Object
     */
    public function getParser(): Parser
    {
        return $this->parser;
    }

    /**
     * Filter Roman Number to Integer
     *
     * @param  string $value Roman Number
     * @return int    Integer Result
     */
    public function filter(string $value): int
    {
        if ($this->hasCache() && $this->getCache()->hasItem($value)) {
            return $this->getCache()->getItem($value)->get();
        }

        $result = $this->getParser()->parse($this->getLexer()->tokenize($value));

        if ($this->hasCache()) {
            $item = $this->getCache()->getItem($value)->set($result);
            $this->getCache()->save($item);
        }

        return $result;
    }
}
