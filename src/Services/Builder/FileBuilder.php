<?php

namespace Kosmosx\Cache\Services\Builder;

use Kosmosx\Cache\Command\FileCommand;
use Kosmosx\Cache\Command\Interfaces\CommandInterface;
use Kosmosx\Cache\Serializer\CollectSerializer;
use Kosmosx\Cache\Serializer\DefaultSerializer;
use Kosmosx\Cache\Serializer\ResponseSerializer;
use Kosmosx\Cache\Serializer\Interfaces\SerializerInterface;

class FileBuilder implements CacheBuilderInterface
{
	/**
	 * @return CommandInterface
	 */
    public function response(): CommandInterface
    {
        return new FileCommand(new ResponseSerializer());
    }

	/**
	 * @return CommandInterface
	 */
    public function collect(): CommandInterface
    {
		return new FileCommand(new CollectSerializer());
    }

	/**
	 * @param SerializerInterface|null $serializer
	 * @return CommandInterface
	 */
    public function default():CommandInterface {
		return new FileCommand(new DefaultSerializer());
	}
}