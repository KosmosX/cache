<?php
/**
 * Created by PhpStorm.
 * User: fabrizio
 * Date: 22/10/18
 * Time: 19.38
 */

namespace CacheSystem\Serializer;

use CacheSystem\Serializer\Abstracts\Serializer;
use CacheSystem\Serializer\Interfaces\SerializerInterface;

class DefaultSerializer extends Serializer implements SerializerInterface
{
    const SERIALIZER = DefaultSerializer::class;

    public function make($data, bool $isRawData = false): ?string
    {
        $rawData = $this->_serialize($data, $isRawData, self::SERIALIZER);
        
        return $rawData;
    }

    public function get()
    {
        $data = $this->_unserialize('data');
        return $data['data'];
    }
}