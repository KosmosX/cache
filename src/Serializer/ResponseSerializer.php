<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 22/10/18
	 * Time: 19.38
	 */

	namespace LumenCacheService\Serializer;

	use LumenCacheService\Serializer\SerializerAbstract;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\Response;

	class ResponseSerializer extends SerializerAbstract
	{
		const TYPE = 'response_type_cache';

		public function serialize($data)
		{
			if (!($data instanceof Response) && !($data instanceof JsonResponse))
				$this->exception('Data is not instance of Response or JsonResponse');

			$data = [
				'headers' => $data->headers,
				'status' => $data->getStatusCode(),
				'content' => $data->getContent(),
			];

			$type = self::TYPE;
			$cache = $this->cacheProcessor('PUT', $data, $type);

			return $cache;
		}

		public function unserialize($data)
		{
			$cache = $this->cacheProcessor('GET', $data);

			$response = response()->json(json_decode($cache['data']['content'],true), $cache['data']['status'], $cache['data']['headers']);

			return $response;
		}
	}