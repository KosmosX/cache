<?php

namespace CacheSystem\Serializer\Interfaces;

interface SerializerInterface
{
    function get($rawData);

    function make($data): ?string;
}