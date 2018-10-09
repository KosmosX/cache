<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 09/10/18
	 * Time: 14.15
	 */
	namespace LumenCacheService;

	use Illuminate\Support\ServiceProvider;

	class CacheServiceProvider extends ServiceProvider
	{
		/**
		 * Bootstrap the application services.
		 *
		 * @return void
		 */
		public function boot()
		{
		}
		/**
		 * Register the application services.
		 *
		 * @return void
		 */
		public function register()
		{

			$this->app->bind('CacheService', 'LumenServiceCache\Services\CacheService');

			$this->app->bind('CacheFile', 'LumenServiceCache\Services\CacheRepository\CacheFile');
			$this->app->bind('CacheRedis', 'LumenServiceCache\Services\CacheRepository\CacheRedis');

			$this->app->alias('cache', 'Illuminate\Cache\CacheManager');

		}
	}