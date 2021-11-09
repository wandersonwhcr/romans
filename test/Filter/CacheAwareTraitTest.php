<?php

declare(strict_types=1);

namespace RomansTest\Filter;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface as CacheInterface;
use Romans\Filter\CacheAwareTrait;

/**
 * Cache Aware Trait Test
 */
class CacheAwareTraitTest extends TestCase
{
    /**
     * Test Cache
     */
    public function testCache(): void
    {
        $cache   = $this->createMock(CacheInterface::class);
        $element = $this->getMockForTrait(CacheAwareTrait::class);

        $this->assertNull($element->getCache());
        $this->assertFalse($element->hasCache());

        $this->assertSame($element, $element->setCache($cache));
        $this->assertSame($cache, $element->getCache());
        $this->assertTrue($element->hasCache());

        $this->assertSame($element, $element->setCache(null));
        $this->assertNull($element->getCache());
        $this->assertFalse($element->hasCache());
    }
}
