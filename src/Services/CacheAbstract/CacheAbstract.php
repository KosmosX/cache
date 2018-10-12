<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace LumenCacheService\Services\CacheAbstract;

	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\Response;
	use Illuminate\Support\Collection;

	/**
	 * Class CacheAbstract
	 * @package App\Services\Cache\CacheAbstract
	 */
	class CacheAbstract
	{
		const GENERIC_TYPE = 'generic_type_normal';
		const RESPONSE_TYPE = 'response_type_normal';
		const COLLECT_TYPE = 'collect_type_normal';

		private $withSerlizeObj = true;

		public function withoutSerialize()
		{
			$this->withSerlizeObj = false;
			return $this;
		}

		public function withSerialize()
		{
			$this->withSerlizeObj = true;
			return $this;
		}

		/**
		 * Private method for serialization, implements a control to correctly cache responses.
		 *
		 * @param $response
		 * @param bool $withoutObj
		 * @return string
		 */
		protected function serialize($data)
		{
			if ((($data instanceof Response) || ($data instanceof JsonResponse)) && $this->withSerlizeObj)
				return $this->responseSerialize($data);

			if (($data instanceof Collection) && $this->withSerlizeObj)
				return $this->serializeCollect($data);

			$type = self::GENERIC_TYPE;

			return $this->makeSerializedCache($type, $data);
		}

		/**
		 * @param $response
		 * @return string
		 */
		protected function responseSerialize($response)
		{
			$headers = $response->headers;
			$status = $response->getStatusCode();
			$content = $response->getContent();

			$type = self::RESPONSE_TYPE;
			$data = response()->json(compact('content', 'status'), $status, array($headers));

			return $this->makeSerializedCache($type, $data);
		}

		/**
		 * @param $type
		 * @param $data
		 * @return string
		 */
		private function makeSerializedCache($type, $data): string
		{
			$responseSerialized = ['type' => $type, 'data' => $data];

			return json_encode($responseSerialized, JSON_FORCE_OBJECT);
		}

		/**
		 * @param $collect
		 * @return string
		 */
		protected function serializeCollect($collect)
		{
			$type = self::COLLECT_TYPE;

			return $this->makeSerializedCache($type, $collect);
		}

		/**
		 * Private method that decodes the data recovered from the cache, using json decode and if the cachet data is an response will be decoded correctly
		 *
		 * @param string $serializedResponse
		 * @return $this|string|Response|Model
		 */
		protected function unserialize($serializedCache)
		{
			if (!$serializedCache)
				return response()->json([
					"error" => [
						"message" => "404 Not Found",
						"status_code" => 404
					]
				], 404);

			$cache = $this->getSerializedCache($serializedCache);

			if (($cache['type'] === self::RESPONSE_TYPE) && $this->withSerlizeObj)
				return $this->unserializeResponse($cache['data']);

			if (($cache['type'] === self::COLLECT_TYPE) && $this->withSerlizeObj)
				return $this->unserializeCollect($cache['data']);

			return $cache['data'];
		}

		/**
		 * @param $serializedCache
		 * @return array
		 */
		private function getSerializedCache($serializedCache): array
		{
			$serializedData = json_decode($serializedCache, true);

			$cache = ['type' => $serializedData['type'], 'data' => $serializedData['data']];

			return $cache;
		}

		/**
		 * @param $serializedResponse
		 * @return mixed
		 */
		protected function unserializeResponse($serializedResponse)
		{
			$response = response()->json($serializedResponse['original']['content'], $serializedResponse['original']['status'], $serializedResponse['headers']);

			return $response;
		}

		/**
		 * @param $serializedCollect
		 * @return Collection
		 */
		protected function unserializeCollect($serializedCollect)
		{
			$collect = collect($serializedCollect);

			return $collect;
		}

	}