# Lumen Cache Service
[build] [stable]

[version] [v1.0.0-rc]

##### Why use it?
This package is useful for better managing the File or Redis cache. Implements the functions for creating and returning caches using json-encoded serialization to make the cache transportable and usable by other external microservices.


##### Install & Configuration
    
    composer require fabrizio-cafolla /lumen-cache-service

You must enter the following provider in the bootstrap/app.php file:
Uncomment the function 
    
    $app->whitFacades();

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

    $cache = app('service.cache');
    $cacheFile = app('service.cache.file');
    $cacheRedis = app('service.cache.redis');
 

*PUT* function 
    
    $cache->file()->put($key, $value, $ttl);    //Cache with File
    $cache->redis()->put($key, $value, $ttl);    //Cache with Redis
    
    $cacheRedis->put($key, $value, $ttl);
    
    $cacheFile->put($key, $value, $ttl);

*PUT MANY*  

    //array format ["key" => $value, "key2" => $value2 ...]
    //$ttl for all values
    $cache->file()->putMany(array $values, $ttl);
    $cache->redis()->putMany(array $values, $ttl);
    
    $cacheRedis->putMany(array $values, $ttl);
    
    $cacheFile->putMany(array $values, $ttl);
    
*GET*

    $cache->file()->get($key);
    $cache->redis()->get($key);
    
    $cacheRedis->get($key);
    
    $cacheFile->get($key);
    
*GET MANY*

    //array format ["key", "key2", "keyN" ...]
    $cache->file()->getMany(array $keys);
    $cache->redis()->getMany(array $keys);
    
    $cacheRedis->getMany(array $keys);
    
    $cacheFile->getMany(array $keys);
    
*SERIALIZATION*
All data are stored in cache with json encode (to make the cache transportable and readable by other languages).
Serializers can be used to construct the cache in order to rebuild it as desired.
 

    $cache->file()->serializer(new ResponseSerializer) //if value is not instanceof Response or ResponseJson return exception
                  ->put($key, $value, $ttl);  
    $cache->file()->serializer(new ResponseSerializer) //it is not necessary, because DefaultSerializer is used by default
                  ->get($key);  
                  
    $cache->redis()->serializer(new CollectSerializer) //if value is not instanceof Collect return exception
                   ->put($key, $value, $ttl);  
    $cache->redis()->serializer(new CollectSerializer)
                   ->get($key);

If you want to create your own serializer, just create a class that extends SerializerAbstract

    use CacheSystem\Serializer\SerializerAbstract;
    
    //$process = 'PUT' or 'GET'
    cacheProcessor($process, $data, $type = 'default_type')

Other function:

     //Use class cache manager 
     manager()->... //istance of Illuminate/Redis or CacheManager
     $cache->redis->...		//istance in attribute
     $cache->redis()->manager()	//create istance when called 
     $cache->file->...
     $cache->file()->manager()     
     
     forget(string $keys)
     forgetMany(array $keys)
     
     clear()
         
