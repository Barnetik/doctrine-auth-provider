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
        // @FIXME: A bit (Tooooooo) dirty. Clean me up when you know more, please, please, pleeeease
        $em = $this->app->make('Doctrine\ORM\EntityManager');
        $driverChain = $em->getConfiguration()->getMetadataDriverImpl();
        foreach ($driverChain->getDrivers() as $namespace => $driver) {
            $clonedDriver = clone($driver);
            break;
        }
        $driverChain->addDriver($clonedDriver, 'Barnetik\DoctrineAuth');
        
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
