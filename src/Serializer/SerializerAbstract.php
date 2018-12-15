<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 22/10/18
	 * Time: 19.39
	 */

	namespace CacheSystem\Serializer;

	use Symfony\Component\HttpKernel\Exception\HttpException;
	use Carbon\Carbon;

	abstract class SerializerAbstract
	{
		const SERIALIZER = self::SERIALIZER;

		abstract public function make($data);

		abstract public function get($data);

		/**
		 * Get Serializer used for cached data
		 *
		 * @param $rawData
		 *
		 * @return null|string
		 * @throws \Exception
		 */
		public function getSerializer($rawData): ?string
		{
			$data = $this->_unserialize($rawData,'serializer');
			if (null === $data)
				return NULL;
			return $data['serializer'];
		}

		/**
		 * @param $rawData
		 *
		 * @return null|string
		 * @throws \Exception
		 */
		public function getCreatedAt($rawData): ?string
		{
			$data = $this->_unserialize($rawData,'created_at');
			if (null === $data)
				return NULL;
			return $data['created_at'];
		}

		/**
		 * @param      $rawData
		 * @param null $only
		 * @param bool $except
		 *
		 * @return array
		 * @throws \Exception
		 */
		public function getArgs($rawData, $only = NULL, bool $except = false): array {
			$args = $this->_unserialize($rawData,$only,$except);
			if (null === $args)
				return NULL;
			return $args;
		}

		/**
		 * Unserialize cache and return array with Serializer and $data
		 *
		 * @param      $rawData
		 * @param null $only
		 * @param bool $except
		 *
		 * @return array
		 * @throws \Exception
		 */
		protected function _unserialize($rawData, $only = NULL, bool $except = false): array
		{
			$data = json_decode($rawData, true);
			if (0 !== json_last_error())
				throw new \Exception("Serialized Data error json: " . json_last_error_msg());

			if (is_array($only))
				foreach ($only as $key)
					if (!array_key_exists($key, $data))
						array_forget($only, $key);

			if (NULL != $only) {
				if (true === $except)
					return array_except($data, $only);
				else
					return array_only($data, $only);
			}

			return $data;
		}

		/**
		 * Create array with type of Serializer and $data, in json encode
		 *
		 * @param        $rawData
		 * @param bool   $serialized
		 * @param string $serializer
		 *
		 * @return null|string
		 */
		protected function _serialize($data, bool $just_raw_data = false, string $serializer = DefaultSerializer::class): ?string
		{
			if(false === $just_raw_data)
				$rawData = array('serializer' => $serializer, 'data' => $data, 'created_at' => Carbon::now()->toDateTimeString());

			return json_encode(isset($rawData)?$rawData:$data, JSON_FORCE_OBJECT);
		}
	}