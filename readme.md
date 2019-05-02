# Cache System

![](https://img.shields.io/badge/version-1.0.0-green.svg) ![](https://img.shields.io/badge/laravel->=5.7-blue.svg) ![](https://img.shields.io/badge/lumen->=5.7-blue.svg)

##### Why use it?
>Manage your cache easily.
This package is useful for better managing the File or Redis cache. Implements the functions for creating and returning caches using json-encoded serialization to make the cache transportable and usable by other external microservices.


##### Install & Configuration
    
    composer require kosmosx/cache

You must enter the following provider in the bootstrap/app.php file:
Uncomment the function 
    
    $app->withFacades();

Load configuration in boostrap file

	$this->configure('cache');
	$this->configure('database');
Or publish config in your Service Provider

    $this->publishes([
        'Kosmosx/Cache/config/cache.php' => config_path('cache.php')
    ], 'config');
    
    $this->publishes([
        'Kosmosx/Cache/config/database.php' => config_path('database.php')
    ], 'config');
    
Register service provider 
    
    $app->register(Kosmosx\Cache\CacheServiceProvider::class);

#### Documentation
Once you have cofigured using it:

    $factory = app('factory.cache');            //return CacheFactory
    $builderFile = $factory->file();            //return FileBuilder
    $builderRedis = $factory->redis();          //return RedisBuilder
        
    $file = app('service.cache.file');          //FileCommand
    $redis = app('service.cache.redis');        //RedisCommand

**SET**

    //If you use builder obj  
    $builderRedis->default()->set($key, $value, $ttl);          //build FileCommand with DefaultSerializer and set cache
    $builderRedis->response()->set($response, $value, $ttl);
    $builderRedis->collect()->set($collect, $value, $ttl);
    
    //With services 
    $file->set($key, $value, $ttl);
    $redis->set($key, $value, $ttl);

**SET MANY**

    //array example: ["key" => $value, "key2" => $value2 ...]
    //$ttl for all values
    
    $builderFile->default()->setMany(array $values, $ttl);
    
    $file->setMany(array $values, $ttl);
    $redis->setMany(array $values, $ttl);
    
**GET**
    
    $file->get($key, $serializer);
    $redis->get($key, $serializer);
    
**GET MANY**

    //array example: ["key", "key2", "keyN" ...]
    
    $file->getMany(array $keys);
    $redis->getMany(array $keys);
    
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

    use Kosmosx\Cache\Serializer\Abstracts\Serializer;
    use Kosmosx\Cache\Serializer\Interfaces\SerializerInterface;
        
    class {name} extends Serializer implements SerializerInterface

**Other function**

     //Use class cache manager 
     ...->manager()	//return istance of Illuminate/Redis or CacheManager     
     
     ...->forget(string $keys)
     ...->forgetMany(array $keys)
     
     ...->setAutodetect($bool)
     ...->getAutodetect()
     
     ...->clear()
         
