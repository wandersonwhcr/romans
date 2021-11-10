<?php

declare(strict_types=1);

namespace Romans\Cache;

use Psr\Cache\CacheItemPoolInterface as CacheInterface;

/**
 * Cache Aware Trait
 */
trait CacheAwareTrait
{
    private ?CacheInterface $cache = null;

    /**
     * Has Cache?
     *
     * @return bool Cache Exists
     */
    public function hasCache(): bool
    {
        return $this->cache !== null;
    }

    /**
     * Set Cache
     *
     * @param ?CacheInterface $cache Cache Object
     * @param self            Fluent Interface
     */
    public function setCache(?CacheInterface $cache): self
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * Get Cache
     *
     * @return ?CacheInterface Cache Object
     */
    public function getCache(): ?CacheInterface
    {
        return $this->cache;
    }
}
