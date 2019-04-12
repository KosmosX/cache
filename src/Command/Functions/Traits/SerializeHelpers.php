<?php
/**
 * Created by PhpStorm.
 * User: fabrizio
 * Date: 13/12/18
 * Time: 22.26
 */

namespace CacheSystem\Command\Functions\Traits;

use CacheSystem\Command\Functions\MainFunction;
use CacheSystem\Serializer\Interfaces\SerializerInterface;

trait SerializeHelpers
{
    /**
     * Raw data retrieved from stored cache
     *
     * @var string
     */
    protected $rawData;
    /**
     * Class of Serializer to use
     *
     * @var
     */
    private $serializer;

    /**
     * (Alias of _setSerializer())
     * Serializer to use for cache
     *
     * @param $serializer
     *
     * @return $this
     */
    public function withSerializer(SerializerInterface $serializer): self
    {
        $this->_setSerializer($serializer);
        return $this;
    }
    
    /**
     * Get raw data of lastest item (put or get)
     *
     * @param bool $decode
     *
     * @return mixed|string
     */
    public function getRawData($only = NULL, bool $except = false, bool $decode = true): ?array
    {
        if (false === $decode)
            $this->rawData;

        $args = $this->serializer->getArgs($this->rawData, $only, $except);
        if (NULL === $args)
            return NULL;

        return $args;
    }

    /**
     * @return null|string
     */
    public function getSerializer(): ?string
    {
        $serializer_class = $this->serializer->getSerializer($this->rawData);

        if (NULL === $serializer_class)
            return NULL;

        return $serializer_class;
    }

    /**
     * @return null|string
     */
    public function getCreatedAt(): ?string
    {
        $serializer_class = $this->serializer->getCreatedAt($this->rawData);

        if (NULL === $serializer_class)
            return NULL;

        return $serializer_class;
    }

    /**
     * @param string $rawData
     *
     * @throws \Exception
     */
    protected function _setRawData($rawData): void
    {
        if (NULL === $rawData) {
            $this->rawData = json_encode(array("serializer" => "", "data" => [], "created_at" => ""), JSON_FORCE_OBJECT);
            return;
        }

        json_decode($rawData);
        if (0 !== json_last_error())
            throw new \Exception("Serialized Data error json: " . json_last_error_msg());

        $this->rawData = $rawData;
    }


    /**
     * @param      $rawData
     * @param bool $DETECT_SERIALIZER
     *
     * @return mixed
     * @throws \Exception
     */
    protected function _unserializeData($rawData, bool $DETECT_SERIALIZER = true)
    {
        $this->_setRawData($rawData);

        if (true === $DETECT_SERIALIZER)
            $this->_detectSerializer();

        $data = $this->serializer->get($rawData);

        return $data;
    }

    /**
     * Detect serializer of get cache and _set serializer attr
     *
     * @param $data
     */
    protected function _detectSerializer(): void
    {
        $serializer_of_cache = $this->getSerializer();

        if (NULL === $serializer_of_cache)
            return;
        else if ($serializer_of_cache !== get_class($this->serializer))
            $this->_setSerializer(new $serializer_of_cache());
    }

    /**
     * @param $data
     *
     * @return mixed
     * @throws \Exception
     */
    protected function _serializeData($data): ?string
    {
        $rawData = $this->serializer->make($data);
        $this->_setRawData($rawData);
        return $rawData;
    }

    /**
     * Private function to _set Serializer
     *
     * @param $serializer
     */
    protected function _setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }
}