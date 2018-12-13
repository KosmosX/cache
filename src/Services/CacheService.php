<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace CacheSystem\Services;

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
			return app('service.cache.file');
		}

		/**
		 * This method returns the class to be able to use the primitive methods and not those implemented by the Reids Cache Repository
		 *
		 * use into controller: $this->cache->redis()-> any method that class implement
		 *
		 * @return Redis
		 */
		public function redis(){
			return app('service.cache.redis');
		}
	}