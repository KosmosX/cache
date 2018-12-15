<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 13/12/18
	 * Time: 22.26
	 */

	namespace CacheSystem\Traits;

	trait RawDataHelpers
	{
		/**
		 * Raw data retrieved from stored cache
		 *
		 * @var string
		 */
		protected $rawData;

		/**
		 * Get raw data of lastest item (put or get)
		 *
		 * @param bool $decode
		 *
		 * @return mixed|string
		 */
		public function getRawData($only = NULL, bool $except = false, bool $decode = true): ?array
		{
			if (false === $decode)
				$this->rawData;

			$args = $this->serializer->getArgs($this->rawData, $only, $except);
			if (NULL === $args)
				return NULL;

			return $args;
		}

		/**
		 * @return null|string
		 */
		public function getSerializer(): ?string
		{
			$serializer_class = $this->serializer->getSerializer($this->rawData);

			if (NULL === $serializer_class)
				return NULL;

			return $serializer_class;
		}

		/**
		 * @return null|string
		 */
		public function getCreatedAt(): ?string
		{
			$serializer_class = $this->serializer->getCreatedAt($this->rawData);

			if (NULL === $serializer_class)
				return NULL;

			return $serializer_class;
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