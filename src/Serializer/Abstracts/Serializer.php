<?php
/**
 * Created by PhpStorm.
 * User: fabrizio
 * Date: 22/10/18
 * Time: 19.39
 */

namespace Kosmosx\Cache\Serializer\Abstracts;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;

class Serializer
{
    const SERIALIZER = self::SERIALIZER;

    protected $rawData;

    public function __construct($rawData = null)
    {
        $this->rawData = $rawData;
    }

    /**
	 * @param null $args
	 * @return array
	 * @throws \Exception
	 */
    public function getArgs($args = null): array
    {
        $args = $this->_unserialize($args);

        return $args;
    }

	/**
	 * @param null $rawData
	 * @throws \Exception
	 */
    public function setRawData($rawData = null): void
    {
        if (is_string($rawData)) {
            json_decode($rawData);

            if (0 !== json_last_error())
                throw new \Exception("Serialized Data error json: " . json_last_error_msg());
        } else {
            $rawData = json_encode(array("serializer" => "", "data" => [], "created_at" => ""), JSON_FORCE_OBJECT);
        }

        $this->rawData = $rawData;
    }

    /**
     * Unserialize cache and return array with Serializer and $data
     *
     * @param null|array|string $only
     *
     * @return array
     * @throws \Exception
     */
    protected function _unserialize($only = null): array
    {
        try {
            $data = json_decode($this->rawData, true);
        } catch (\Exception $e) {
            throw new \Exception("Serialized Data error json: " . json_last_error_msg());
        }

        if (!empty($data) && (!empty($only) || null != $only)) {
            if (is_string($only))
                $only = (array)$only;
            return array_only($data, $only);
        }

        return is_array($data) ?: array();
    }

    /**
     * Create array with type of Serializer and $data, in json encode
     *
	 * @param $data
	 * @param bool $isRawData
	 * @param string $serializer
	 * @return string|null
	 * @throws \Exception
	 */
    protected function _serialize($data, bool $isRawData = false, string $serializer = DefaultSerializer::class): ?string
    {
        if (false === $isRawData)
            $data = array('serializer' => $serializer, 'data' => $data, 'created_at' => Carbon::now()->toDateTimeString());

        $rawData = json_encode($data, JSON_FORCE_OBJECT);

        $this->setRawData($rawData);

        return $rawData;
    }
}