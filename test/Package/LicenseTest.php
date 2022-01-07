<?php

declare(strict_types=1);

namespace RomansTest\Package;

use PHPUnit\Framework\TestCase;

/**
 * License Test
 */
class LicenseTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->content = file_get_contents(dirname(dirname(__DIR__)) . '/LICENSE');
    }

    /**
     * Test Year
     */
    public function testYear(): void
    {
        $currentYear = date('Y');
        $copyright   = "Copyright (c) $currentYear https://github.com/wandersonwhcr/romans";

        $this->assertStringContainsString($copyright, $this->content, 'Invalid Current Year on Licence Copyright');
    }
}
