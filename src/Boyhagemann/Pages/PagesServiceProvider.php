<?php

namespace Boyhagemann\Pages;

use Boyhagemann\Pages\Model\Page;
use Illuminate\Support\ServiceProvider;
use Route, App, Config, Schema, Exception;

class PagesServiceProvider extends ServiceProvider
{
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
        $this->package('pages', 'pages');
        
        $this->app->register('Boyhagemann\Crud\CrudServiceProvider');
    }
    
    public function boot()
    {

		/**
		 *
		 * Get all pages that are in the database. We can't be sure if there is a working database
		 * connection, so put the code in a try/catch.
		 *
		 */
		try {

			foreach(Page::get() as $page) {

				$method = $page->method;
				$config['uses'] = $page->controller;

				// Add an alias if it exists for this page
				if($page->alias) {
					$config['as'] = $page->alias;
				}

				// Add the route the conventional way, only this time all the routes
				// are added dynamically.
				Route::$method($page->route, $config);
			}

		}
		catch(Exception $e) {

			/**
			 * There is probably no database connection yet. We can't get the pages from
			 * the database, so fall back to the original routes in Laravel.
			 *
			 */

		}

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