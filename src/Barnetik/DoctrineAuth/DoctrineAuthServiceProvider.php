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
        $em = $this->app->make('Doctrine\ORM\EntityManager');
        $driver = \Doctrine\ORM\Mapping\Driver\AnnotationDriver::create(__DIR__);
        
        $driverChain = $em->getConfiguration()->getMetadataDriverImpl();
        $driverChain->addDriver($driver, 'Barnetik\DoctrineAuth');
        
        Auth::extend('doctrine', function($app) {
            $provider = new DoctrineUserProvider($app->make('Doctrine\ORM\EntityManager'), config('auth.model'));
            return new \Illuminate\Auth\Guard($provider, $app['session.store']);
        });

        $this->publishes([
            __DIR__.'/../../doctrine-migrations' => base_path('/database/doctrine-migrations'),
        ]);
        
        $this->commands([
            'Barnetik\DoctrineAuth\Console\Commands\CreateUser'
        ]);
    }

}
