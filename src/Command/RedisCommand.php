<?php

namespace CacheSystem\Command;

use CacheSystem\Command\Functions\MainFunction;
use CacheSystem\Command\Interfaces\CommandInterface;
use CacheSystem\Serializer\Interfaces\SerializerInterface;

class RedisCommand extends MainFunction implements CommandInterface
{
    /**
     * RedisService constructor.
     */
    public function __construct(SerializerInterface $serializer)
    {
        parent::__construct(app('redis'), $serializer);
    }

    /**
     * Method for creating multiple items in the cache
     * Example ['key' => $value, 'key2' => $value2]
     *
     * @param array $values
     * @param int $minutes
     */
    public function setMany(array $values, int $minutes = 0)
    {
        foreach ($values as $key => $data)
            $this->set($key, $data, $minutes);

        return $this;
    }

    /**
     * Cache creation through serialization in json coding.
     * If you want to cache response you pass the $data parameter as a Response instance
     *
     * @param string $key
     * @param $data
     * @param int $minutes
     * @return mixed
     */
    public function set(string $key, $data, int $minutes = 0)
    {
        $rawData = $this->_serializeData($data);

        $this->manager->set($key, $rawData, $minutes);

        return $this;
    }

    /**
     * Method for taking multiple keys together, returns an associative array
     * Example ['key' => 'value']
     *
     * @param array $keys
     * @return mixed
     */
    public function getMany(array $keys, ?SerializerInterface $serializer = null): array
    {
        $data = array();
        foreach ($keys as $key)
            $data[$key] = $this->get($key, $serializer);
        return $data;
    }

    /**
     * Method to recover the cache from file or redis
     *
     * @param $key
     * @return $this|string|Response
     */
    public function get($key, ?SerializerInterface $serializer = null)
    {
        $rawData = $this->manager->get($key);
        return $this->_unserializeData($rawData, $serializer);
    }

    /**
     * Example use:
     * forget('key2');     // return 1
     * forget(['key3', 'key4']);   // return 2
     *
     * @param string $key
     * @return bool
     */
    public function forget($key, ...$otersKey)
    {
        return $this->manager->del($key, ...$otersKey);
    }

    /**
     * Delete all file cache
     */
    public function clear()
    {
        $this->manager->flushDB();
    }
}