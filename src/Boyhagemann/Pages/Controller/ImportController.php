<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Pages\Model\Page as Pages;
use View, Input, Redirect, Validator, Route, Request;

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
        
        $page = new Pages();
        $page->name = $name;
        $page->path = $route->getPath();
        $page->title = $route->getOption('_uses');
        $page->layout_id = 1;
        $page->save();
        
        return Redirect::route('pages.import')->with('flash', 'Page imported');
    }

    /**
     * Import all routes
     *
     * @return Response
     */
    public function all()
    {
        foreach($this->getNotImportedRoutes() as $name => $route) {
        
            $page = new Pages();
            $page->name = $name;
            $page->path = $route->getPath();
            $page->title = $route->getOption('_uses');
            $page->layout_id = 1;
            $page->save();
        }
        
        return Redirect::route('pages.import')->with('flash', 'All pages imported');
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