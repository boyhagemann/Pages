<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Pages\Model\Page as Pages;
use View, Input, Redirect, Validator;

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function content($id)
    {
        $page = $this->pages->find($id);
        $zones = $page->layout->zones;
        $content = $page->getSortedContent();

        if (is_null($page))
        {
            return Redirect::route('cms.pageblocks.index');
        }
        
        return View::make('pages::pages.content', compact('page', 'content', 'zones'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        $page = $this->pages->findOrFail($id);

        return View::make('pages::pages.delete', compact('page'));
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

        return Redirect::route('cms.pages.index')->with('success', 'Page deleted!');
    }
    
}