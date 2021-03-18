<?php

declare(strict_types=1);

namespace RomansTest\Grammar;

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
}
