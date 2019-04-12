<?php

namespace CacheSystem\Services;

use CacheSystem\Command\FileCommand;
use CacheSystem\Command\Interfaces\CommandInterface;
use CacheSystem\Command\RedisCommand;
use CacheSystem\Serializer\DefaultSerializer;
use CacheSystem\Serializer\Interfaces\SerializerInterface;

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