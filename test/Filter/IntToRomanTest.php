<?php

declare(strict_types=1);

namespace RomansTest\Filter;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface as CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface as CacheInterface;
use Romans\Filter\Exception as FilterException;
use Romans\Filter\IntToRoman;
use Romans\Grammar\Grammar;

/**
 * Int to Roman Test
 */
class IntToRomanTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->filter = new IntToRoman();
    }

    /**
     * Test Constructor
     */
    public function testConstructor(): void
    {
        $grammar = new Grammar();
        $filter  = new IntToRoman($grammar);

        $this->assertSame($grammar, $filter->getGrammar());
    }

    /**
     * Test Filter
     */
    public function testFilter(): void
    {
        $this->assertSame('I', $this->filter->filter(1));
        $this->assertSame('V', $this->filter->filter(5));
        $this->assertSame('X', $this->filter->filter(10));
    }

    /**
     * Test Filter with Multiple Tokens Result
     */
    public function testFilterWithMultipleTokensResult(): void
    {
        $this->assertSame('III', $this->filter->filter(3));
        $this->assertSame('DLV', $this->filter->filter(555));
    }

    /**
     * Test Filter with Lookahead
     */
    public function testFilterWithLookahead(): void
    {
        $this->assertSame('CDLXIX', $this->filter->filter(469));
        $this->assertSame('MCMXCIX', $this->filter->filter(1999));
    }

    /**
     * Test Filter with Zero
     */
    public function testFilterWithZero(): void
    {
        $this->assertSame('N', $this->filter->filter(0));
    }

    /**
     * Test Filter with Negative
     */
    public function testFilterWithNegative(): void
    {
        $this->expectException(FilterException::class);
        $this->expectExceptionMessage('Invalid integer: -1');
        $this->expectExceptionCode(FilterException::INVALID_INTEGER);

        $this->filter->filter(-1);
    }

    /**
     * Test Cache Found
     */
    public function testCacheFound(): void
    {
        $item  = $this->createMock(CacheItemInterface::class);
        $cache = $this->createMock(CacheInterface::class);

        $item->expects($this->once())
            ->method('get')
            ->willReturn('I');

        $cache->method('hasItem')
            ->with($this->equalTo('1'))
            ->willReturn(true);

        $cache->expects($this->once())
            ->method('getItem')
            ->willReturn($item);

        $this->filter->setCache($cache);

        $this->assertSame('I', $this->filter->filter(1));
    }

    /**
     * Test Cache not Found
     */
    public function testCacheNotFound(): void
    {
        $item  = $this->createMock(CacheItemInterface::class);
        $cache = $this->createMock(CacheInterface::class);

        $item->expects($this->once())
            ->method('set')
            ->with($this->equalTo('I'))
            ->willReturnSelf();

        $cache->method('hasItem')
            ->with($this->equalTo('1'))
            ->willReturn(false);

        $cache->expects($this->once())
            ->method('getItem')
            ->willReturn($item);

        $this->filter->setCache($cache);

        $this->assertSame('I', $this->filter->filter(1));
    }
}
