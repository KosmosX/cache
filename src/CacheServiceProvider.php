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
		 * Indicates if loading of the provider is deferred.
		 *
		 * @var bool
		 */
		protected $defer = true;

		/**
		 * Register the application services.
		 *
		 * @return void
		 */
		public function register()
		{
			$this->app->bind('CacheService', 'LumenServiceCache\Services\CacheService');
			$this->app->bind('CacheFile', 'LumenServiceCache\Services\CacheRepository\FileService');
			$this->app->bind('CacheRedis', 'LumenServiceCache\Services\CacheRepository\RedisService');
		}

		/**
		 * Get the services provided by the provider.
		 *
		 * @return array
		 */
		public function provides()
		{
			return ['CacheService', 'CacheFile', 'CacheRedis'];
		}
	}