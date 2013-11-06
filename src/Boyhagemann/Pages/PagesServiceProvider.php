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
    }
    
    public function boot()
    {
//		Route::model('page', 'Boyhagemann\Pages\Model\Page');
//		Route::model('section', 'Boyhagemann\Pages\Model\Section');
//		Route::model('block', 'Boyhagemann\Pages\Model\Block');

//        Route::get('admin/pages/{page}/content', array(
//            'uses'  => 'Boyhagemann\Pages\Controller\PageController@content',
//            'as'    => 'admin.pages.content'
//        ));
//		Route::get('admin/pages/{page}/content/create/{section}/{block}', array(
//			'uses'  => 'Boyhagemann\Pages\Controller\PageController@addContent',
//			'as'    => 'admin.pages.content.create'
//		));
//		Route::post('admin/pages/{page}/content/store/{section}/{block}', array(
//			'uses'  => 'Boyhagemann\Pages\Controller\PageController@storeContent',
//			'as'    => 'admin.pages.content.store'
//		));
//
//        Route::resource('admin/layouts', 'Boyhagemann\Pages\Controller\LayoutController');
//        Route::resource('admin/pages', 'Boyhagemann\Pages\Controller\PageController');
//        Route::resource('admin/blocks', 'Boyhagemann\Pages\Controller\BlockController');
//        Route::resource('admin/sections', 'Boyhagemann\Pages\Controller\SectionController');
//        Route::resource('admin/content', 'Boyhagemann\Pages\Controller\ContentController');

		try {

			if(Schema::hasTable('pages')) {

				foreach(Model\Page::get() as $page) {

					$method = $page->method;
					$config['uses'] = $page->controller;
					if($page->alias) {
						$config['as'] = $page->alias;
					}

					Route::$method($page->route, $config);
				}

			}
		}
		catch(\Exception $e) {

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