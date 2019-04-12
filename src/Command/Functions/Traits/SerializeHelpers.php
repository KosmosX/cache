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
     * Class of Serializer to use
     *
     * @var
     */
    private $serializer;

    private $autodetect = true;

    /**
     * @param bool $autodetect
     */
    public function setAutodetect(bool $autodetect): self
    {
        $this->autodetect = $autodetect;
        return $this;
    }

    public function getAutodetect()
    {
        return $this->autodetect;
    }

    /** Function in beta
     *
     * @return null|string
     * protected function _createdAt(): ?string
     * {
     *      $arg = $this->serializer->getArgs('created_at');
     *
     *      if (array_key_exists('created_ad', $arg))
     *          return $arg['created_at'];
     *
     *      return null;
     * }
     */

    /**
     * @param      $rawData
     * @param bool $DETECT_SERIALIZER
     *
     * @return mixed
     * @throws \Exception
     */
    protected function _unserializeData($rawData, ?SerializerInterface $serializer = null)
    {
        $this->serializer->setRawData($rawData);

        if ($serializer instanceof SerializerInterface)
            $this->setSerializer($serializer, $rawData);
        else
            $this->_detectSerializer($rawData);

        $data = $this->serializer->get();

        return $data;
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
        return $rawData;
    }

    /**
     * Detect serializer of get cache and _set serializer attr
     *
     * @param $data
     */
    protected function _detectSerializer($rawData): void
    {
        if (false === $this->autodetect)
            return;

        $arg = $this->serializer->getArgs('serializer');
        if (array_key_exists('serializer', $arg) && $arg['serializer'] !== get_class($this->serializer))
            $this->serializer = new $arg['serializer']($rawData);
    }

    /**
     * Private function to _set Serializer
     *
     * @param $serializer
     */
    public function setSerializer(SerializerInterface $serializer, $rawData = null): self
    {
        $this->serializer = $serializer;

        if (null != $rawData)
            $this->serializer->setRawData($rawData);

        return $this;
    }
}