<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace Kosmosx\Cache\Command\Functions;

	use Kosmosx\Cache\Command\Functions\Traits\RawDataHelpers;
	use Kosmosx\Cache\Command\Functions\Traits\SerializeHelpers;
    use Kosmosx\Cache\Serializer\Interfaces\SerializerInterface;
    use Kosmosx\Cache\Serializer\ResponseSerializer;

    /**
	 * Class CacheAbstract
	 * @package App\Services\Cache\CacheAbstract
	 */
	abstract class MainFunction
	{
		use SerializeHelpers;

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
		public function __construct($service, SerializerInterface $serializer)
		{
			$this->manager = $service;
			$this->setSerializer($serializer);
		}

		/**
		 * Return class manager
		 *
		 * @return \Laravel\Lumen\Application|mixed
		 */
		public function manager(): object
		{
			return $this->manager;
		}
	}