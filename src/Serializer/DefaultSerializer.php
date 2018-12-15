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

		public function make($data): ?string
		{
			return $this->_serialize($data, false, self::SERIALIZER);
		}

		public function get($rawData)
		{
			$data = $this->_unserialize($rawData,'data');
			return $data['data'];
		}
	}