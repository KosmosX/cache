<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace CacheSystem\Services\CacheRepository;

	use CacheSystem\Traits\SerializeHelpers;

	/**
	 * Class CacheAbstract
	 * @package App\Services\Cache\CacheAbstract
	 */
	abstract class CacheAbstract
	{
		use SerializeHelpers;

		/**
		 * Is class of service that manage cache
		 *
		 * @var \Laravel\Lumen\Application|mixed
		 */
		protected $manager;

		/**
		 * Raw data retrieved from stored cache
		 *
		 * @var string
		 */
		protected $rawData;

		/**
		 * CacheAbstract constructor.
		 *
		 * @param string $service
		 * @param string $serializer
		 */
		public function __construct(string $service, string $serializer)
		{
			$this->manager = app($service);
			$this->_setSerializer($serializer);
		}

		/**
		 * (Alias of _setSerializer())
		 * Serializer to use for cache
		 *
		 * @param $serializer
		 *
		 * @return $this
		 */
		public function withSerializer($serializer): CacheAbstract
		{
			$this->_setSerializer($serializer);
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

		/**
		 * Get raw data of lastest item (put or get)
		 *
		 * @param bool $decode
		 *
		 * @return mixed|string
		 */
		public function getRawData(bool $decode = false)
		{
			return $decode ? json_decode($this->rawData, true) : $this->rawData;
		}

		/**
		 * @param string $rawData
		 *
		 * @throws \Exception
		 */
		private function _setRawData(string $rawData)
		{
			json_decode($rawData);
			if (0 !== json_last_error())
				throw new \Exception("Serialized Data error json: " . json_last_error_msg());

			$this->rawData = $rawData;
		}
	}