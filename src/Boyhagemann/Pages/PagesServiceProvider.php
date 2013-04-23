<?php namespace Boyhagemann\Pages;

use Illuminate\Support\ServiceProvider,
    Symfony\Component\Routing\Matcher\UrlMatcher,
    Symfony\Component\Routing\RequestContext,
    Boyhagemann\Pages\Model\Pages,
    Route, 
    View, 
    App, 
    Request;

class PagesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('boyhagemann/pages');
        
        Route::get('test', 'HomeController@showWelcome');
        Route::resource('cms/pages', 'Boyhagemann\Pages\Controller\PagesController');
                       
                      
        App::instance('request', Request::create('/dispatch-page'));
        Route::get('/dispatch-page', 'Boyhagemann\Pages\Controller\PagesController@dispatch');

        
        Route::before(function() {  
            
            try {
                
                $context = new RequestContext;
                $context->fromRequest(Request::getFacadeRoot());
                $matcher = new UrlMatcher(Route::getRoutes(), $context);

                $parameters = $matcher->match('/' . ltrim(Request::path(), '/'));
                $found = Route::getRoutes()->get($parameters['_route']);

                foreach(Route::getRoutes()->all() as $name => $route) {
                    $route->setOption('name', $name);
                    $route->setOption('originalRoute', $found);                    
                }
                
            }
            catch(\Exception $e) {
                
            }
            
        });
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}