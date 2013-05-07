<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Pages\Model\Page as Pages;
use View, Input, Redirect, Route;

class ImportController extends \BaseController {

    /**
     * Pages Repository
     *
     * @var Pages
     */
    protected $pages;

    public function __construct(Pages $pages)
    {
        $this->pages = $pages;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $routes = $this->getNotImportedRoutes();    
        return View::make('pages::import.index', compact('routes'));
    }

    /**
     * Import one route
     *
     * @return Response
     */
    public function page()
    {
        $name = Input::input('name');        
        $route = Route::getRoutes()->get($name);        
        $page = Pages::createFromRoute($name, $route);
        
        return Redirect::route('cms.pages.content', array('page' => $page->id))
                ->with('success', 'Page imported!');
    }

    /**
     * Import all routes
     *
     * @return Response
     */
    public function all()
    {
        foreach($this->getNotImportedRoutes() as $name => $route) {
        
            Pages::createFromRoute($name, $route);
        }
        
        return Redirect::route('pages.import')->with('success', 'All pages imported');
    }

    /**
     * 
     * @return array
     */
    public function getNotImportedRoutes()
    {        
        $pages = array();
        foreach(Pages::all() as $page) {
            $pages[$page->name] = $page;
        }
        
        return array_diff_key(Route::getRoutes()->all(), $pages);
    }

}