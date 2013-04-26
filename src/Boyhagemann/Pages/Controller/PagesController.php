<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Pages\Model\Page as Pages;
use View, Input, Redirect, Validator, Route, Request;

class PagesController extends \BaseController {

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
        $pages = $this->pages->all();

        return View::make('pages::pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('pages::pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $validation = Validator::make($input, Pages::$rules);

        if ($validation->passes())
        {
            $this->pages->create($input);

            return Redirect::route('cms.pages.index');
        }

        return Redirect::route('cms.pages.create')
            ->withInput()
            ->withErrors($validation)
            ->with('flash', 'There were validation errors.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $page = $this->pages->findOrFail($id);

        return View::make('pages::pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $page = $this->pages->find($id);

        if (is_null($page))
        {
            return Redirect::route('cms.pages.index');
        }

        return View::make('pages::pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = array_except(Input::all(), '_method');
        $validation = Validator::make($input, Pages::$rules);

        if ($validation->passes())
        {
            $page = $this->pages->find($id);
            $page->update($input);

            return Redirect::route('cms.pages.show', $id);
        }

        return Redirect::route('cms.pages.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('flash', 'There were validation errors.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->pages->find($id)->delete();

        return Redirect::route('cms.pages.index');
    }
    
    /**
     * Override the default dispatching and add content to the view
     * 
     * @return string
     */
    public function dispatch()
    {
        // Get the original route that the system is supposed to dispatch
        $original = Route::getCurrentRoute()->getOption('originalRoute');        
                
        // Only continue if an original route was found
        if(!$original) {
            return 'Page not found';
        }
        
        // Search for a page in the database that has the same name as the
        // original route.
        $name = $original->getOption('name');        
        $page = Pages::where('name', '=', $name)->first();
        
        // If no page is found in the database, just dispatch the original
        // route like nothing happened.
        if(!$page) {
            return $this->dispatchRoute($original->getPath());
        }
        
        // Set the right layout for this page
        $this->layout = View::make($page->layout->name);        
        
        // Dispatch the page
        $this->dispatchRoute($page->path);        
        
        
        
        // When the layout is being rendered, add content to each zone
        View::composer($page->layout->name, function($view) use ($page) {
                             
            foreach($page->getSortedContent() as $zone => $blocks) {
                
                // Start with an empty zone
                $this->layout->$zone = '';
                
                foreach($blocks as $pageBlock) {            
                    
                    // If the block has a custom view path, then override the
                    // default view with this one
                    if(isset($pageBlock->view)) {
                        View::composer($block['view']['original'], function($view) use($block) {            
                            $view->setPath($block['view']['override']);
                        });
                    }
                    
                    // Dispatch the action and add the response to the right zone
                    $this->layout->$zone .= $this->dispatchAction($pageBlock->block->action, array());
                }
            }
            
        });
    }

    
    
    /**
     * 
     * @param string $route
     * @param string $method
     * @param array $params
     * @return Response
     */
    public function dispatchRoute($route, $method = 'GET', $params = array())
    {
        $request = Request::create($route, $method, $params);
        return Route::dispatch($request)->getContent();
    }
    
    /**
     * 
     * @param string $action
     * @param array $params
     * @return Response
     */
    public function dispatchAction($action, $params = array())
    {
        $parts = array();
        $patterns = array();
        
        foreach($params as $key => $value) {
            $parts[sprintf('{%s}', $key)] = $value;
            $patterns[sprintf('/\{%s\}/', $key)] = $value;
        }
        $uri = '/testdus/' . implode('/', array_keys($parts));
        Route::get($uri, $action);
        
        foreach($patterns as $pattern => $value) {
            $uri = preg_replace($pattern, $value, $uri);
        }
        
        return $this->dispatchRoute($uri, 'GET', $params);
    }

}