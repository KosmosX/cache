<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 22/10/18
	 * Time: 19.38
	 */

	namespace CacheSystem\Serializer;

	use CacheSystem\Serializer\SerializerAbstract;

	class DefaultSerializer extends SerializerAbstract
	{
		const SERIALIZER = DefaultSerializer::class;

		public function serialize($data)
		{
			$cache = $this->cacheProcessor('PUT', $data,  self::SERIALIZER);

			return $cache;
		}

		public function deserialize($data)
		{
			$cache = $this->cacheProcessor('GET', $data);

			return $cache['data'];
		}
	}