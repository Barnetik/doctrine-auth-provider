<?php namespace Barnetik\DoctrineAuth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class DoctrineAuthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}
    
    public function boot()
    {
        Auth::extend('doctrine', function($app) {
            $provider = new \Intimus\AuthDoctrineUserProvider($app->make('doctrine'), config('auth.model'));
            return new \Illuminate\Auth\Guard($provider, $app['session.store']);
        });
    }

}
