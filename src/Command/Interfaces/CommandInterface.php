<?php

namespace CacheSystem\Command\Interfaces;

interface CommandInterface
{
    //function set(string $key, $data, int $minutes = 0): self;

    //function setMany(array $values, $minutes = 0): self;

    function get($key, bool $DETECT_SERIALIZER = true);

    function getMany(array $keys): ?array;

    function forget(string $key);

    function clear();
}