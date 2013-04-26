<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Pages\Model\Page as Pages;
use View, Input, Redirect, Validator, Route, Request;

class PageBlocksController extends \BaseController {

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $page = $this->pages->find($id);
        $zones = $page->layout->zones;
        $content = $page->getSortedContent();

        if (is_null($page))
        {
            return Redirect::route('cms.pages.index');
        }
        
        return View::make('pages::page-blocks.edit', compact('page', 'content', 'zones'));
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
    
}