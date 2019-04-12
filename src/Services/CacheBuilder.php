<?php
namespace CacheSystem\Services;

use CacheSystem\Command\FileCommand;
use CacheSystem\Command\Interfaces\CommandInterface;
use CacheSystem\Command\RedisCommand;
use CacheSystem\Serializer\DefaultSerializer;

class CacheBuilder
{
    /**
     * This method returns the class to be able to use the primitive methods and not those implemented by the Reids Cache Repository
     *
     * use into controller: $this->cache->file()-> any method that class implement
     *
     * @return \Illuminate\Cache\CacheManager
     */
    public function file(string $serializer = DefaultSerializer::class) :CommandInterface{
        return new FileCommand($serializer);
    }

    /**
     * This method returns the class to be able to use the primitive methods and not those implemented by the Reids Cache Repository
     *
     * use into controller: $this->cache->redis()-> any method that class implement
     *
     * @return Redis
     */
    public function redis(string $serializer = DefaultSerializer::class) :CommandInterface{
        return new RedisCommand($serializer);
    }
}