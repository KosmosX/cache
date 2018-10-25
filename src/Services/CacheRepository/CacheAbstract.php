<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace LumenCacheService\Services\CacheRepository;
	use LumenCacheService\Serializer\DefaultSerializer;

	/**
	 * Class CacheAbstract
	 * @package App\Services\Cache\CacheAbstract
	 */
	abstract class CacheAbstract
	{
		/**
		 * Class of Serializer to use
		 *
		 * @var
		 */
		protected $serializer;

		/**
		 * Is class of service that manage cache
		 *
		 * @var \Laravel\Lumen\Application|mixed
		 */
		protected $manager;

		/**
		 * Check if use default Serializer or not
		 *
		 * @var bool
		 */
		protected $defaultSerializer = false;

		/**
		 * RedisService constructor.
		 */
		public function __construct($service, string $serializer)
		{
			$this->manager = app($service);
			$this->set($serializer);
		}

		/**
		 * Private function to set Serializer
		 * @param $serializer
		 */
		private function set($serializer){
			$this->serializer = new $serializer;
		}

		/**
		 * Serializer to use for cache
		 *
		 * @param $serializer
		 * @return $this
		 */
		public function withSerialize($serializer)
		{
			$this->set($serializer);
			return $this;
		}

		/**
		 * Function to disable autoDetect and use DefaultSerializer
		 *
		 * @return $this
		 */
		public function withoutSerialize() {
			$this->defaultSerializer = true;
			return $this;
		}

		/**
		 * Detect serializer of get cache and set serializer attr
		 *
		 * @param $data
		 */
		protected function autoDetect($data)
		{
			$serializerOfCache = $this->serializer->getSerializer($data);
			if ($serializerOfCache != get_class($this->serializer) && !$this->defaultSerializer)
				$this->set($serializerOfCache);
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