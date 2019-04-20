<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 09/10/18
	 * Time: 14.15
	 */

	namespace CacheSystem;

	use CacheSystem\Services\CacheBuilder;
    use Illuminate\Support\ServiceProvider;
	use CacheSystem\Services\CacheService;
	use CacheSystem\Services\CacheRepository\FileService;
	use CacheSystem\Services\CacheRepository\RedisService;

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
			$this->app->register(\CacheSystem\CacheServiceProvider::class);

			$this->app->bind('service.cache.builder', function ($app) {
				return new CacheBuilder();
			});

			$this->app->bind('service.cache.file', function ($app) {
				return new FileService();
			});

			$this->app->bind('service.cache.redis', function ($app) {
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
			return ['service.cache.builder', 'service.cache.file', 'service.cache.redis'];
		}
	}