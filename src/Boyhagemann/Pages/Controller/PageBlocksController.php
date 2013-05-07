<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Pages\Model\PageBlock as PageBlocks;
use View, Input, Redirect, Validator, Route, Request;

class PageBlocksController extends \BaseController {

    /**
     * Pages Repository
     *
     * @var PageBlocks
     */
    protected $pageblocks;

    public function __construct(PageBlocks $pageblocks)
    {
        $this->pageblocks = $pageblocks;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @param $page
     * @param $zone
     * @param $position
     * @return Response
     */
    public function create($page, $zone, $position)
    {
        return View::make('pages::page-blocks.create', compact('page', 'zone', 'position'))
                    ->with('success', 'Added the block to the page!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $validation = Validator::make($input, PageBlocks::$rules);

        if ($validation->passes())
        {
            $this->pageblocks->create($input);

            return Redirect::route('cms.pages.content', array($input['page_id']));
        }

        return Redirect::route('cms.pageblocks.create')
            ->withInput()
            ->withErrors($validation)
            ->with('flash', 'There were validation errors.');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $pageblock = $this->pageblocks->find($id);

        if (is_null($pageblock))
        {
            return Redirect::route('cms.pages.index');
        }
        
        return View::make('pages::page-blocks.edit', compact('pageblock'));
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
        $validation = Validator::make($input, PageBlocks::$rules);

        if ($validation->passes())
        {
            $pageblock = $this->pageblocks->find($id);
            $pageblock->update($input);

            return Redirect::route('cms.pages.content', $pageblock->page->id);
        }

        return Redirect::route('cms.pageblocks.edit', $id)
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
        $pageblock = $this->pageblocks->findOrFail($id);
        $page = $pageblock->page;

        return View::make('pages::page-blocks.delete', compact('pageblock', 'page'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $pageblock = $this->pageblocks->find($id);
        $page = $pageblock->page;
        $pageblock->delete();

        return Redirect::route('cms.pages.content', $page->id)->with('success', 'Block removed from page!');
    }
    
}