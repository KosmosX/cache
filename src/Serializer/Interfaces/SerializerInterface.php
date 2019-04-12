<?php

namespace CacheSystem\Serializer\Interfaces;

interface SerializerInterface
{
    function get();

    function make($data, bool $isRawData = false): ?string;
}