<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 09/08/18
	 * Time: 17.42
	 */
	namespace LumenCacheService\Facades;

	use Illuminate\Support\Facades\Facade;

	class CacheService extends Facade
	{
		protected static function getFacadeAccessor()
		{
			return 'cache.service';
		}
	}