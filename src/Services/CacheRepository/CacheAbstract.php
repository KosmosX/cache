<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace LumenCacheService\Services\CacheRepository;

	/**
	 * Class CacheAbstract
	 * @package App\Services\Cache\CacheAbstract
	 */
	abstract class CacheAbstract
	{
		/**
		 * @var
		 */
		protected $serializer;

		/**
		 * @var \Laravel\Lumen\Application|mixed
		 */
		protected $manager;

		/**
		 * RedisService constructor.
		 */
		public function __construct($app, $serializer)
		{
			$this->manager = app($app);
			$this->serializer = $serializer;
		}

		/**
		 * Serializer to use for cache
		 *
		 * @param $serializer
		 * @return $this
		 */
		public function serializer($serializer)
		{
			$this->serializer = $serializer;
			return $this;
		}

		/**
		 * Return class manager
		 *
		 * @return \Laravel\Lumen\Application|mixed
		 */
		public function manager()
		{
			return $this->manager;
		}
	}