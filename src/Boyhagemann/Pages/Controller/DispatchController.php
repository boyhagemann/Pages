<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Pages\Model\Page as Pages;
use View, Route, Request, App;

class DispatchController extends \BaseController {
    
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
            App::abort(404, 'Page not found');
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
                    $this->layout->$zone .= $this->dispatchAction($pageBlock->block->action);
                }
            }
            
        });
        
    }
    
    /**
     * Dispatch a route
     * 
     * @param string $route
     * @param string $method
     * @param array $params
     * @return Response
     */
    public function dispatchRoute($route, $method = 'GET', $params = array())
    {
        $route = '/' . ltrim($route, '/');
        $request = Request::create($route, $method, $params);
        return Route::dispatch($request)->getContent();
    }
    
    /**
     * Dispatch an action
     * 
     * @param string $action
     * @param array $params
     * @return Response
     */
    public function dispatchAction($action, $params = array())
    {
        Route::get(Request::path(), $action);                
        return $this->dispatchRoute(Request::path(), 'GET', $params);
    }

}