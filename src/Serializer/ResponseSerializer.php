<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 22/10/18
	 * Time: 19.38
	 */

	namespace CacheSystem\Serializer;

	use CacheSystem\Serializer\SerializerAbstract;

	class ResponseSerializer extends SerializerAbstract
	{
		const SERIALIZER = ResponseSerializer::class;

		public function make($data): ?string
		{
			if (!($data instanceof \Symfony\Component\HttpFoundation\Response))
				throw new \Exception("Data is not instance of Response");

			$data = [
				'headers' => $data->headers->all(),
				'status' => $data->getStatusCode(),
				'content' => $data->getContent(),
			];

			return $this->_serialize($data, false,self::SERIALIZER);
		}

		public function get($rawData)
		{
			$data = $this->_unserialize($rawData, 'data');
			$data = $data['data'];

			if (class_exists(\ResponseHTTP\Response\HttpResponse::class))
				return new \ResponseHTTP\Response\HttpResponse($data['content'], $data['status'], $data['headers']);

			return response()->json($data['content'], $data['status'], $data['headers']);
		}
	}