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
		protected $serializer;

		/**
		 * @param $serializer
		 * @return $this
		 */
		public function setSerializer($serializer)
		{
			$this->serializer = $serializer;
			return $this;
		}
	}