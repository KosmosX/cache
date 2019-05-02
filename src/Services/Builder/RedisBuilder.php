<?php

namespace Kosmosx\Cache\Services\Builder;

use Kosmosx\Cache\Command\RedisCommand;
use Kosmosx\Cache\Command\Interfaces\CommandInterface;
use Kosmosx\Cache\Serializer\CollectSerializer;
use Kosmosx\Cache\Serializer\DefaultSerializer;
use Kosmosx\Cache\Serializer\ResponseSerializer;
use Kosmosx\Cache\Serializer\Interfaces\SerializerInterface;

class RedisBuilder implements CacheBuilderInterface
{
	/**
	 * @return CommandInterface
	 */
    public function response(): CommandInterface
    {
        return new RedisCommand(new ResponseSerializer());
    }

	/**
	 * @return CommandInterface
	 */
    public function collect(): CommandInterface
    {
		return new RedisCommand(new CollectSerializer());
    }

	/**
	 * @param SerializerInterface|null $serializer
	 * @return CommandInterface
	 */
    public function default(): CommandInterface {
		return new RedisCommand(new DefaultSerializer());
	}
}