<?php

namespace CacheSystem\Command\Interfaces;

use CacheSystem\Serializer\Interfaces\SerializerInterface;

interface CommandInterface
{
    //function set(string $key, $data, int $minutes = 0): self;

    //function setMany(array $values, $minutes = 0): self;

    function get($key, ?SerializerInterface $serializer = null);

    function getMany(array $keys, ?SerializerInterface $serializer = null): array;

    function forget(string $key);

    function clear();
}