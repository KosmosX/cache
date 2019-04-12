# Lumen Cache Service

[![](https://img.shields.io/appveyor/ci/gruntjs/grunt.svg)](https://github.com/FabrizioCafolla/cache-system)
![](https://img.shields.io/badge/version-1.1.0--rc-green.svg)

![](https://img.shields.io/badge/package-laravel-orange.svg)
![](https://img.shields.io/badge/package-lumen-orange.svg)

##### Why use it?
>Manage your cache easily.
This package is useful for better managing the File or Redis cache. Implements the functions for creating and returning caches using json-encoded serialization to make the cache transportable and usable by other external microservices.


##### Install & Configuration
    
    composer require fabrizio-cafolla/cache-system

You must enter the following provider in the bootstrap/app.php file:
Uncomment the function 
    
    $app->withFacades();

Load configuration in boostrap file

	$this->configure('cache');
	$this->configure('database');
Or publish config in your Service Provider

    $this->publishes([
        'CacheSystem/config/cache.php' => config_path('cache.php')
    ], 'config');
    
    $this->publishes([
        'CacheSystem/config/database.php' => config_path('database.php')
    ], 'config');
    
Register service provider 
    
    $app->register(CacheSystem\CacheServiceProvider::class);

#### Documentation
Once you have cofigured using it:

    $cache = app('service.cache');              //CacheService
    $cacheFile = app('service.cache.file');     //FileService
    $cacheRedis = app('service.cache.redis');   //RedisService
 

**PUT** / **SET**
    
    $cache->file()->put($key, $value, $ttl);    //Using cache File with cache service
    $cache->redis()->set($key, $value, $ttl);   //Using cache Redis with cache service
    
    $cacheRedis->set($key, $value, $ttl);
    $cacheFile->put($key, $value, $ttl);

**PUT MANY** / **SET MANY**

    //array example: ["key" => $value, "key2" => $value2 ...]
    //$ttl for all values
    
    $cache->file()->putMany(array $values, $ttl);
    $cache->redis()->setMany(array $values, $ttl);
    
    $cacheRedis->setMany(array $values, $ttl);
    $cacheFile->putMany(array $values, $ttl);
    
**GET**

    $cache->file()->get($key);
    $cache->redis()->get($key);
    
    $cacheRedis->get($key);
    $cacheFile->get($key);
    
**GET MANY**

    //array example: ["key", "key2", "keyN" ...]
    
    $cache->file()->getMany(array $keys);
    $cache->redis()->getMany(array $keys);
    
    $cacheRedis->getMany(array $keys);
    $cacheFile->getMany(array $keys);
    
**SERIALIZER**
All data stored in cache (redis / file) are serialized with the json coding, so as to make them transportable by other languages.
it is possible to use typed serializers, so that when it is recovered it is possible to reconstruct the initial object. 

    $cache->file()->serializer(new ResponseSerializer)  //if value is not instanceof Symfony\Response return exception
                  ->put('response', $response, $ttl);  
    $cache->file()->get('response');                    //return response obj with data stored (autodetect Serializer used for cache)
    $cache->file()->get('response',false);              //return array of data stored (use DefaultSerializer)
                  
    $cache->redis()->serializer(new CollectSerializer)  //if value is not instanceof Collect return exception
                   ->put('collect', $value, $ttl);  
    $cache->redis()->get('collect);                     //retrun collection obj with data stored

**DefaultSerializer** used by default if not specified

**ResponseSerializer** used to cache responses

**CollectSerializer** used to cache collection

**Own Serializer**
If you want to create your own serializer, just create a class that extends SerializerAbstract

    use CacheSystem\Serializer\SerializerAbstract;
    
    required to implement the two abstract methods extended from the class: get () and make ()

**Other function**

     //Use class cache manager 
     $cache->redis()->manager()	//return istance of Illuminate/Redis
     $cache->file()->manager()  //return istance of CacheManager     
     
     ->forget(string $keys)
     ->forgetMany(array $keys)
     
     ->clear()
         
