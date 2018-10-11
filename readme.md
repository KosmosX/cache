# Lumen Cache Service
[build] [stable]

[version] [v1.1.0]

##### Why use it?
This package is useful for better managing the File or Redis cache. Implements the functions for creating and returning caches using json-encoded serialization to make the cache transportable and usable by other external microservices.


##### Install & Configuration
    
    composer require fabrizio-cafolla /lumen-cache-service

You must enter the following provider in the bootstrap/app.php file:
Uncomment the function 
    
    $app->whitFacades();
   
Add the configuration files
    
    $app->configure('cache');
    $app->configure('database');
    
Finally add the provider registration 
    
    $app->register(LumenCacheService\CacheServiceProvider::class);

#### Documentation
Once you have cofigured using it, it's easy to instantiate the services:

    $cache = app('cache.service');
    $cacheFile = app('cache.file');
    $cacheRedis = app('cache.redis');
 
In the first case, an object is created that implements the use of both services and will therefore be accessible with only one entry in the cache
    
    $cache->file->put($key, $value, $ttl);
    $cache->file->get($key);
    
    $cache->redis->put($key, $value, $ttl);
    $cache->redis->get($key);
    
    $cacheRedis->put(... );
    $cacheFile->get(... );
    
The serialization by default is performed and converts the data to json, moreover, a serialization system is pre-set for Response and / or Response Json objects or a Collection, when they are retrieved through the get function of the service will be again objects so you can use the methods related to the object.

    //value is Response and / or Response Json or a Collection objects
    //A json cache is created with the related data
    $cache->file->put($key, $value, $ttl);  
    $cache->redis->put($key, $value, $ttl);
    
    //The data is retrieved and the starting object is rebuilt
    $cache->file->get($key);  
    $cache->redis->get($key);
    
    //If you do not want to create the cache also serializing the object or do not want to recover it as an object, just use the following function
     $cache->file->withoutSerialize()->put($key, $value, $ttl);  
     $cache->redis->withoutSerialize()->put($key, $value, $ttl);
     
     $cache->file->withoutSerialize()->get($key);  
     $cache->redis->withoutSerialize()->get($key);

In the next releases there will be new objects to serialize and functions for the cache with s3 and CDN assets
    
