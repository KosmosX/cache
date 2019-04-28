<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 09/08/18
	 * Time: 17.42
	 */
	namespace Kosmosx\Cache\Facades;

	use Illuminate\Support\Facades\Facade;

	class CacheFile extends Facade
	{
		protected static function getFacadeAccessor()
		{
			return 'service.cache.file';
		}
	}