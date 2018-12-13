<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 13/12/18
	 * Time: 22.26
	 */

	namespace CacheSystem\Traits;

	trait SerializeHelpers
	{
		/**
		 * Class of Serializer to use
		 *
		 * @var
		 */
		private $serializer;

		/**
		 * @param      $rawData
		 * @param bool $DETECT_SERIALIZER
		 *
		 * @return mixed
		 * @throws \Exception
		 */
		protected function _unserializeData($rawData, bool $DETECT_SERIALIZER = true)
		{
			$this->_setRawData($rawData);

			if (true === $DETECT_SERIALIZER)
				$this->_detectSerializer($rawData);

			$data = $this->serializer->deserialize($rawData);

			return $data;
		}

		/**
		 * Detect serializer of get cache and _set serializer attr
		 *
		 * @param $data
		 */
		protected function _detectSerializer($rawData): void
		{
			$serializer_of_cache = $this->serializer->getSerializer($rawData);

			if ($serializer_of_cache !== get_class($this->serializer))
				$this->_setSerializer($serializer_of_cache);
		}

		/**
		 * @param $data
		 *
		 * @return mixed
		 * @throws \Exception
		 */
		protected function _serializeData($data) :?string
		{
			$rawData = $this->serializer->serialize($data);
			$this->_setRawData($rawData);
			return $rawData;
		}

		/**
		 * Private function to _set Serializer
		 *
		 * @param $serializer
		 */
		protected function _setSerializer(string $serializer): void
		{
			if (!class_exists($serializer))
				throw new \Exception("Error serializer not exist");

			$this->serializer = new $serializer;
		}

		protected function _getSerializer() {
			return $this->serializer;
		}
	}