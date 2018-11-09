<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 22/10/18
	 * Time: 19.38
	 */

	namespace CacheSystem\Serializer;

	use CacheSystem\Serializer\SerializerAbstract;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\Response;

	class ResponseSerializer extends SerializerAbstract
	{
		const SERIALIZER = ResponseSerializer::class;

		public function serialize($data)
		{
			if (!($data instanceof Response) && !($data instanceof JsonResponse))
				$this->exception('Data is not instance of Response or JsonResponse');

			$data = [
				'headers' => $data->headers,
				'status' => $data->getStatusCode(),
				'content' => $data->getContent(),
			];

			$cache = $this->cacheProcessor('PUT', $data, self::SERIALIZER);

			return $cache;
		}

		public function deserialize($data)
		{
			$cache = $this->cacheProcessor('GET', $data);

			$response = response()->json(json_decode($cache['data']['content'],true), $cache['data']['status'], $cache['data']['headers']);

			return $response;
		}
	}