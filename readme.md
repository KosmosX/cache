# Cache System

[![](https://img.shields.io/appveyor/ci/gruntjs/grunt.svg)](https://github.com/FabrizioCafolla/cache-system)
![](https://img.shields.io/badge/version-1.0.0--rc-green.svg)

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

    $builder = app('service.cache.builder');    //CacheBuilder
    $builderFile = $builder->file();        
    $builderFile->set($key, $value, $ttl);
        
    $file = app('service.cache.file');          //FileCommand
    $redis = app('service.cache.redis');        //RedisCommand
 

**SET**

    //With builder obj  
    $builderRedis = $builder->redis();
    $builderRedis->set($key, $value, $ttl);
    
    //With classes 
    $file->put($key, $value, $ttl);
    $redis->set($key, $value, $ttl);

**SET MANY**

    //array example: ["key" => $value, "key2" => $value2 ...]
    //$ttl for all values
    
    $builderFile->setMany(array $values, $ttl);
    $builderRedis->setMany(array $values, $ttl);
    
    $file->putMany(array $values, $ttl);
    $redis->setMany(array $values, $ttl);
    
**GET**

    $builderFile->get($key, $serializer);
    $builderRedis->get($key, $serializer);
    
    $file->get($key, $serializer);
    $redis->get($key, $serializer);
    
**GET MANY**

    //array example: ["key", "key2", "keyN" ...]
    
    $builderFile->getMany(array $keys);
    
    $file->getMany(array $keys);
    
**SERIALIZER**

All data stored in cache (redis / file) are serialized with the json coding, so as to make them transportable by other languages.
it is possible to use typed serializers, so that when it is recovered it is possible to reconstruct the initial object. 
    
    //Serializer 
    ResponseSerializer()  //If you want cache Response object 
    CollectSerializer()   //If you want cache Collect object 
    DefaultSerializer()   //default cache
    
    ...->setSerializer(new ResponseSerializer());
                  
**Own Serializer**

If you want to create your own serializer, just create a class that extends SerializerAbstract

    use CacheSystem\Serializer\Abstracts\Serializer;
    use CacheSystem\Serializer\Interfaces\SerializerInterface;
        
    class {name} extends Serializer implements SerializerInterface

**Other function**

     //Use class cache manager 
     ...->manager()	//return istance of Illuminate/Redis or CacheManager     
     
     ...->forget(string $keys)
     ...->forgetMany(array $keys)
     
     ...->setAutodetect($bool)
     ...->getAutodetect()
     
     ...->clear()
         
