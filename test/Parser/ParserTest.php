<?php

namespace RomansTest\Parser;

use PHPUnit\Framework\TestCase;
use Romans\Grammar\Grammar;
use Romans\Parser\Parser;

/**
 * Parser Test
 */
class ParserTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->parser = new Parser();
    }

    /**
     * Test Parse
     */
    public function testParse()
    {
        $this->assertSame(1, $this->parser->parse([Grammar::T_I]));
    }
}
