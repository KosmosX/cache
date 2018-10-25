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
		const SERIALIZER = CollectSerializer::class;

		public function serialize($data)
		{
			if (!($data instanceof Collection))
				$this->exception('Data is not instance of Collection');

			$cache = $this->cacheProcessor('PUT', $data, self::SERIALIZER);

			return $cache;
		}

		public function deserialize($data)
		{
			$cache = $this->cacheProcessor('GET', $data);

			$collect = collect($cache['data']);

			return $collect;
		}
	}