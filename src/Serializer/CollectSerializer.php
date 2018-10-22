<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 22/10/18
	 * Time: 19.38
	 */

	namespace LumenCacheService\Serializer;

	use LumenCacheService\Serializer\SerializerAbstract;
	use Illuminate\Support\Collection;

	class CollectSerializer extends SerializerAbstract
	{
		const TYPE = 'collect_type_cache';

		public function serialize($data)
		{
			if (!($data instanceof Collection))
				$this->exception('Data is not instance of Collection');

			$type = self::TYPE;

			$cache = $this->cacheProcessor('PUT', $type, $data);

			return $cache;
		}

		public function unserialize($data)
		{
			$cache = $this->cacheProcessor('GET', $data);

			$collect = collect($cache['data']);

			return $collect;
		}
	}