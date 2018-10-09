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
    
    $cache->file->put( $key, $value, $ttl);
    $cache->file->get( $key);
    
    $cache->redis->put( $key, $value, $ttl);
    $cache->redis->get( $key);
