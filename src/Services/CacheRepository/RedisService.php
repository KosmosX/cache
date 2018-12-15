<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace CacheSystem\Services\CacheRepository;

	use CacheSystem\Serializer\DefaultSerializer;
	use CacheSystem\Services\CacheRepository\CacheAbstract;

	/**
	 * Class RedisService
	 * @package App\Services\Cache\CacheRepository
	 */
	class RedisService extends CacheAbstract
	{

		/**
		 * RedisService constructor.
		 */
		public function __construct(string $serializer = DefaultSerializer::class)
		{
			parent::__construct('redis', $serializer);
		}

		/**
		 * Method for creating multiple items in the cache
		 * Example ['key' => $value, 'key2' => $value2]
		 *
		 * @param array $values
		 * @param int $minutes
		 */
		public function setMany(array $values, $minutes = 0): void
		{
			foreach ($values as $key => $data)
				$this->set($key, $data, $minutes);
		}

		/**
		 * Cache creation through serialization in json coding.
		 * If you want to cache response you pass the $data parameter as a Response instance
		 *
		 * @param string $key
		 * @param $data
		 * @param int $minutes
		 * @return mixed
		 */
		public function set(string $key, $data, int $minutes = 0): void
		{
			$rawData = $this->_serializeData($data);

			$this->manager->set($key, $rawData, $minutes);
		}

		/**
		 * Method for taking multiple keys together, returns an associative array
		 * Example ['key' => 'value']
		 *
		 * @param array $keys
		 * @return mixed
		 */
		public function getMany(array $keys) : ?array
		{
			$data = array();
			foreach ($keys as $key)
				$data[$key] = $this->get($key);
			return $data;
		}

		/**
		 * Method to recover the cache from file or redis
		 *
		 * @param $key
		 * @return $this|string|Response
		 */
		public function get($key, bool $DETECT_SERIALIZER = true)
		{
			$rawData = $this->manager->get($key);
			return $this->_unserializeData($rawData,$DETECT_SERIALIZER);
		}

		/**
		 * Example use:
		 * forget('key2');     // return 1
		 * forget(['key3', 'key4']);   // return 2
		 *
		 * @param string $key
		 * @return bool
		 */
		public function forget($key)
		{
			return $this->manager->del($key);
		}
	}