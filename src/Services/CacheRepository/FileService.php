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
	 * Class FileService
	 * @package App\Services\Cache\CacheRepository
	 */
	class FileService extends CacheAbstract
	{

		/**
		 * CacheService constructor.
		 *
		 * @param CacheRepository $cache
		 *
		 * @return CacheRepository for instance in
		 */
		public function __construct(string $serializer = DefaultSerializer::class)
		{
			parent::__construct('cache', $serializer);
		}

		/**
		 * Method for creating multiple items in the cache
		 * Example ['key' => $value, 'key2' => $value2]
		 *
		 * @param array $values
		 * @param       $type
		 * @param int   $minutes
		 */
		public function putMany(array $values, int $minutes = 0): void
		{
			foreach ($values as $key => $data)
				$this->put($key, $data, $minutes);
		}

		/**
		 * Cache creation through serialization in json coding.
		 * If you want to cache response you pass the $data parameter as a Response instance
		 *
		 * @param string $key
		 * @param        $data
		 * @param string $type
		 * @param int    $minutes
		 *
		 * @return mixed
		 */
		public function put(string $key, $data, int $minutes = NULL)
		{
			$rawData = $this->_serializeData($data);

			if (NULL === $minutes)
				$this->manager->forever($key, $rawData);
			else
				$this->manager->put($key, $rawData, $minutes);

			return $this;
		}

		/**
		 * Method for taking multiple keys together, returns a key associative array => value
		 *
		 * @param array $keys
		 *
		 * @return mixed
		 */
		public function getMany(array $keys): ?array
		{
			$data = array();
			foreach ($keys as $key)
				$data[$key] = $this->get($key);
			return $data;
		}

		/**
		 * Method to recover the cache from file or redis
		 *
		 * @param        $key
		 * @param string $type
		 *
		 * @return $this|string|BinaryFileResponse
		 */
		public function get($key, bool $DETECT_SERIALIZER = true)
		{
			$rawData = $this->manager->get($key);
			return $this->_unserializeData($rawData, $DETECT_SERIALIZER);
		}

		/**
		 * Delete file cache with array key
		 *
		 * @param array $keys
		 */
		public function forgetMany(array $keys): void
		{
			foreach ($keys as $key)
				$this->forget($key);
		}

		/**
		 * Delete file cache with key
		 *
		 * @param string $key
		 *
		 * @return bool
		 */
		public function forget(string $key): bool
		{
			return $this->manager->forget($key);
		}

		/**
		 * Delete all file cache
		 */
		public function clear()
		{
			$this->manager->flush();
		}
	}