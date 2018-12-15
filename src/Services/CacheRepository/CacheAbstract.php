<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace CacheSystem\Services\CacheRepository;

	use CacheSystem\Traits\RawDataHelpers;
	use CacheSystem\Traits\SerializeHelpers;

	/**
	 * Class CacheAbstract
	 * @package App\Services\Cache\CacheAbstract
	 */
	abstract class CacheAbstract
	{
		use SerializeHelpers, RawDataHelpers;

		/**
		 * Is class of service that manage cache
		 *
		 * @var \Laravel\Lumen\Application|mixed
		 */
		protected $manager;

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
	}