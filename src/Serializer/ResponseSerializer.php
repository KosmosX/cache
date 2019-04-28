<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 22/10/18
	 * Time: 19.38
	 */

	namespace Kosmosx\Cache\Serializer;

    use Kosmosx\Cache\Serializer\Abstracts\Serializer;
    use Kosmosx\Cache\Serializer\Interfaces\SerializerInterface;

    class ResponseSerializer extends Serializer implements SerializerInterface
	{
		const SERIALIZER = ResponseSerializer::class;

		public function make($data, bool $isRawData = false): ?string
		{
			if (!($data instanceof \Symfony\Component\HttpFoundation\Response))
				throw new \Exception("Data is not instance of Response");

			$data = [
				'headers' => $data->headers->all(),
				'status' => $data->getStatusCode(),
				'content' => $data->getContent(),
			];

			return $this->_serialize($data, $isRawData,self::SERIALIZER);
		}

		public function get()
		{
			$data = $this->_unserialize('data');
			$data = $data['data'];

			if (class_exists(\ResponseHTTP\Response\HttpResponse::class))
				return new \ResponseHTTP\Response\HttpResponse($data['content'], $data['status'], $data['headers']);

			return response()->json($data['content'], $data['status'], $data['headers']);
		}
	}