<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 09/10/18
	 * Time: 14.15
	 */

	namespace LumenCacheService;

	use Illuminate\Support\ServiceProvider;
	use LumenCacheService\Services\CacheService;
	use LumenCacheService\Services\CacheRepository\FileService;
	use LumenCacheService\Services\CacheRepository\RedisService;

	class CacheServiceProvider extends ServiceProvider
	{
		/**
		 * Indicates if loading of the provider is deferred.
		 *
		 * @var bool
		 */
		protected $defer = true;

		public function boot()
		{
			$this->app->alias('cache', 'Illuminate\Cache\CacheManager');
			$this->app->register('Illuminate\Redis\RedisServiceProvider');
		}

		/**
		 * Register the application services.
		 *
		 * @return void
		 */
		public function register()
		{
			$this->app->singleton('cache.service', function ($app) {
				$fileService = app(FileService::class);
				$redisService = app(RedisService::class);

				return new CacheService($fileService, $redisService);
			});

			$this->app->singleton('cache.file', function ($app) {
				return new FileService();
			});

			$this->app->singleton('cache.redis', function ($app){
				return new RedisService();
			});
		}

		/**
		 * Get the services provided by the provider.
		 *
		 * @return array
		 */
		public function provides()
		{
			return ['cache.service', 'cache.file', 'cache.redis'];
		}
	}