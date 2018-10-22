<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 22/10/18
	 * Time: 19.38
	 */

	namespace LumenCacheService\Serializer;

	use LumenCacheService\Serializer\SerializerAbstract;

	class DefaultSerializer extends SerializerAbstract
	{
		const TYPE = 'default_type_cache';

		public function serialize($data)
		{
			$type = self::TYPE;

			$cache = $this->cacheProcessor('PUT', $type, $data);

			return $cache;
		}

		public function unserialize($data)
		{
			$cache = $this->cacheProcessor('GET', $data);

			return $cache['data'];
		}
	}