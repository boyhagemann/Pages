<?php

namespace Boyhagemann\Pages;

use Illuminate\Support\ServiceProvider;
use Route, App, Config, Schema;

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
        $this->app->register('Boyhagemann\Blocks\BlocksServiceProvider');        
    }
    
    public function boot()
    {        
	Config::set('blocks', array());

	if(Schema::hasTable('pages')) {
	    //Config::set('blocks', App::make('Boyhagemann\Pages\Model\Page')->getBlocks()); 
	}

        Route::model('page', 'Pages\Page');
                
        Route::get('admin/pages/{page}/content', array(
            'uses'  => 'Boyhagemann\Pages\Controller\ContentController@indexWithPage',
            'as'    => 'admin.content'
        ));
        
        Route::resource('admin/layouts', 'Boyhagemann\Pages\Controller\LayoutController');
        Route::resource('admin/pages', 'Boyhagemann\Pages\Controller\PageController');
        Route::resource('admin/blocks', 'Boyhagemann\Pages\Controller\BlockController');
        Route::resource('admin/sections', 'Boyhagemann\Pages\Controller\SectionController');
        Route::resource('admin/content', 'Boyhagemann\Pages\Controller\ContentController', array('excep' => array('index')));
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