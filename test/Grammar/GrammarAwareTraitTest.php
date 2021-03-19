<?php

declare(strict_types=1);

namespace RomansTest\Grammar;

use Error;
use PHPUnit\Framework\TestCase;
use Romans\Grammar\Grammar;
use Romans\Grammar\GrammarAwareTrait;

/**
 * Grammar Aware Trait Test
 */
class GrammarAwareTraitTest extends TestCase
{
    /**
     * Test Grammar
     */
    public function testGrammar(): void
    {
        $grammar = new Grammar();
        $element = $this->getMockForTrait(GrammarAwareTrait::class);

        $this->assertSame($element, $element->setGrammar($grammar));
        $this->assertSame($grammar, $element->getGrammar());
    }

    public function testNullableGrammar(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('$grammar must not be accessed before initialization');

        $element = $this->getMockForTrait(GrammarAwareTrait::class);

        $element->getGrammar();
    }
}
