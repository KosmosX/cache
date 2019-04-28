<?php

namespace Kosmosx\Cache\Services;

use Kosmosx\Cache\Command\FileCommand;
use Kosmosx\Cache\Command\Interfaces\CommandInterface;
use Kosmosx\Cache\Command\RedisCommand;
use Kosmosx\Cache\Serializer\DefaultSerializer;
use Kosmosx\Cache\Serializer\Interfaces\SerializerInterface;

class CacheBuilder
{
    /**
     * @param SerializerInterface|null $serializer
     * @return CommandInterface
     */
    public function file(SerializerInterface $serializer = null): CommandInterface
    {
        return new FileCommand($serializer ?: new DefaultSerializer());
    }

    /**
     * @param SerializerInterface|null $serializer
     * @return CommandInterface
     */
    public function redis(SerializerInterface $serializer = null): CommandInterface
    {
        return new RedisCommand($serializer ?: new DefaultSerializer());
    }
}