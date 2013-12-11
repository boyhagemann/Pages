<?php

namespace Boyhagemann\Pages;

use Boyhagemann\Pages\Model\Page;
use Boyhagemann\Pages\Model\PageRepository;
use Illuminate\Support\ServiceProvider;
use PDOException;

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
				PageRepository::createRoute($page);
			}
            
		}
		catch(PDOException $e) {
            
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