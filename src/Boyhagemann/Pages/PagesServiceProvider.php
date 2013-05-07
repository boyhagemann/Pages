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
                    
        
        Route::get('cms/pages/content/{page}', array(
            'as'    => 'cms.pages.content',
            'uses'  => 'Boyhagemann\Pages\Controller\PagesController@content'
        ));
        Route::get('cms/pages/{page}/delete', array(
            'as'    => 'cms.pages.delete',
            'uses'  => 'Boyhagemann\Pages\Controller\PagesController@delete'
        ));
        Route::get('cms/import', array(
            'as'    => 'pages.import',
            'uses'  => 'Boyhagemann\Pages\Controller\ImportController@index'
        ));
        Route::post('cms/import/page', array(
            'as'    => 'pages.import.page',
            'uses'  => 'Boyhagemann\Pages\Controller\ImportController@page'
        ));
        Route::get('cms/import/all', array(
            'as'    => 'pages.import.all',
            'uses'  => 'Boyhagemann\Pages\Controller\ImportController@all'
        ));    
        Route::get('cms/blocks/available', array(
            'as'    => 'pages.blocks.available',
            'uses'  => 'Boyhagemann\Pages\Controller\BlocksController@available'
        ));                    
        
        
        
        Route::resource('cms/pages', 'Boyhagemann\Pages\Controller\PagesController');
        Route::resource('cms/blocks', 'Boyhagemann\Pages\Controller\BlocksController');
        Route::resource('cms/pageblocks', 'Boyhagemann\Pages\Controller\PageBlocksController');
                 
        Route::get('cms/pageblocks/create/{page}/{zone}/{position}', array(
            'as'    => 'cms.pageblocks.create',
            'uses'  => 'Boyhagemann\Pages\Controller\PageBlocksController@create',
            'defaults' => array(
                'page'      => '',
                'zone'      => '',
                'position'  => '',
            )
        ));   
        Route::get('cms/pageblocks/{pageblock}/delete', array(
            'as'    => 'cms.pageblocks.delete',
            'uses'  => 'Boyhagemann\Pages\Controller\PageBlocksController@delete'
        ));
        
        // Hook into the routing cycle to dispatch a different route
        $this->prepareDispatch();
        
	}

    /**
     * 
     */
    public function prepareDispatch()
    {        
        // Add the dispatch route
        Route::get('dispatch-page', 'Boyhagemann\Pages\Controller\DispatchController@dispatch');
        
        // We only want to ovverride GET requests for displaying blocks.
        // Leave POST and UPDATE alone (for now)
        if(Request::getMethod() == 'GET') {
                        
            // Change the request url to point to the dispatch route
            $_SERVER['REQUEST_URI'] = Request::getBaseUrl() . '/dispatch-page';
            App::instance('request', Request::createFromGlobals());

        }
        
        // Just before the new route is dispatched, add the original one to it.
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