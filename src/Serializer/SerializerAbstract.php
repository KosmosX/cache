<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 22/10/18
	 * Time: 19.39
	 */

	namespace LumenCacheService\Serializer;

	use Symfony\Component\HttpKernel\Exception\HttpException;

	abstract class SerializerAbstract
	{
		const SERIALIZER = self::SERIALIZER;

		abstract public function serialize($data);

		abstract public function deserialize($data);

		/**
		 * A method for processing data to be stored or retrieved from cache.
		 *
		 * @param string $process (PUT or GET)
		 * @param $data
		 * @param string $type
		 * @return array|string
		 */
		protected function cacheProcessor(string $process, $data, string $type = null)
		{
			if ($process === 'PUT')
				return $this->put($data, $type);
			else if($process === 'GET')
				return $this->get($data);

			$this->exception('Cache is processed wrong');
		}

		/**
		 * Function for return exception
		 * Example: if $data is not the object we expected
		 *
		 * @param string $content
		 * @param int $status
		 */
		protected function exception($content = 'Error serializing Cache', $status = 400) {
			throw new HttpException($status,$content);
		}

		/**
		 * Unpacked cache and return array with Serializer and $data
		 *
		 * @param $data
		 * @return array
		 */
		private function get($data) {
			$serializedData = json_decode($data, true);
			$cache = ['serializer' => $serializedData['serializer'], 'data' => $serializedData['data']];
			return $cache;
		}

		/**
		 * Create array with type of Serializer and $data, in json encode
		 *
		 * @param $data
		 * @param $serializer
		 * @return string
		 */
		private function put($data, $serializer): string
		{
			$serializedData = ['serializer' => $serializer, 'data' => $data];
			return json_encode($serializedData, JSON_FORCE_OBJECT);
		}

		/**
		 * Get Serializer used for cached data
		 *
		 * @param $data
		 * @return mixed
		 */
		public function getSerializer($data) :string {
			$serialize = $this->get($data);
			return $serialize['serializer'];
		}
	}