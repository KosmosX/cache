<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace LumenCacheService\Services;
	use LumenCacheService\Services\CacheRepository\FileService;
	use LumenCacheService\Services\CacheRepository\RedisService;

	/**
	 * Class CacheService
	 * @package App\Services\Cache
	 */
	class CacheService
	{
		/**
		 * This method returns the class to be able to use the primitive methods and not those implemented by the Reids Cache Repository
		 *
		 * use into controller: $this->cache->file()-> any method that class implement
		 *
		 * @return \Illuminate\Cache\CacheManager
		 */
		public function file(){
			return app(FileService::class);
		}

		/**
		 * This method returns the class to be able to use the primitive methods and not those implemented by the Reids Cache Repository
		 *
		 * use into controller: $this->cache->redis()-> any method that class implement
		 *
		 * @return Redis
		 */
		public function redis(){
			return app(RedisService::class);
		}
	}