<?php

	namespace Kosmosx\Cache\Services\Builder;

	use Kosmosx\Cache\Command\Interfaces\CommandInterface;
	use Kosmosx\Cache\Serializer\Interfaces\SerializerInterface;

	interface CacheBuilderInterface
	{
		public function response(): CommandInterface;

		public function collect(): CommandInterface;

		public function default(): CommandInterface;
	}