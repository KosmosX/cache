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
		abstract public function serialize($data);

		abstract public function unserialize($data);

		/**
		 * @param $serializedCache
		 * @return array
		 */
		protected function cacheProcessor($process, $data, $type = 'default_type')
		{
			if ($process === 'PUT')
				return $this->put($data, $type);
			else if($process === 'GET')
				return $this->get($data);

			$this->exception();
		}

		protected function exception($content = 'Error serializing Cache', $status = 400){
			throw new HttpException($status,$content);
		}

		private function get($data) {
			$serializedData = json_decode($data, true);

			$cache = ['type' => $serializedData['type'], 'data' => $serializedData['data']];

			return $cache;
		}
		/**
		 * @param $type
		 * @param $data
		 * @return string
		 */
		private function put($data, $type): string
		{
			$serializedData = ['type' => $type, 'data' => $data];

			return json_encode($serializedData, JSON_FORCE_OBJECT);
		}
	}