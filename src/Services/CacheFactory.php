<?php

	namespace Kosmosx\Cache\Services;

	use Kosmosx\Cache\Services\Builder\CacheBuilderInterface;
	use Kosmosx\Cache\Services\Builder\FileBuilder;
	use Kosmosx\Cache\Services\Builder\RedisBuilder;

	class CacheFactory
	{
		/**
		 * @return CacheBuilderInterface
		 */
		public function redis():CacheBuilderInterface {
			return new RedisBuilder();
		}

		/**
		 * @return CacheBuilderInterface
		 */
		public function file():CacheBuilderInterface {
			return new FileBuilder();
		}
	}