<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 09/10/18
	 * Time: 14.15
	 */

	namespace Kosmosx\Cache;

	use Kosmosx\Cache\Services\CacheBuilder;
    use Illuminate\Support\ServiceProvider;
	use Kosmosx\Cache\Services\CacheService;
	use Kosmosx\Cache\Services\CacheRepository\FileService;
	use Kosmosx\Cache\Services\CacheRepository\RedisService;

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
			$this->app->alias('cache', \Illuminate\Cache\CacheManager::class);

			$this->app->register('Illuminate\Redis\RedisServiceProvider');

			try {
				$this->app->configure('cache');
				$this->app->configure('database');
			} catch (\Exception $e) {

			}

			$this->app->bind('service.cache.builder', function ($app) {
				return new CacheBuilder();
			});

			$this->app->bind('service.cache.file', function ($app) {
				return new FileService();
			});

			$this->app->bind('service.cache.redis', function ($app) {
				return new RedisService();
			});

			$this->commands(\Kosmosx\Cache\Console\Commands\PublishConfig::class);
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