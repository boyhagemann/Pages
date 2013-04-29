<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Pages\Model\Block as Blocks;
use View, Input, Redirect, Validator;

class BlocksController extends \BaseController {

    /**
     * Blocks Repository
     *
     * @var Blocks
     */
    protected $blocks;

    public function __construct(Blocks $blocks)
    {
        $this->blocks = $blocks;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $blocks = $this->blocks->all();

        return View::make('pages::blocks.index', compact('blocks'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function available()
    {
        $blocks = $this->blocks->where('available', '=', true)->get();

        return View::make('pages::blocks.available', compact('blocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('pages::blocks.create');
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

            return Redirect::route('cms.block.index');
        }

        return Redirect::route('cms.block.create')
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
        $block = $this->blocks->findOrFail($id);

        return View::make('pages::blocks.show', compact('block'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $block = $this->blocks->find($id);

        if (is_null($block))
        {
            return Redirect::route('cms.blocks.index');
        }
        
        return View::make('pages::blocks.edit', compact('block'));
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
        $validation = Validator::make($input, Blocks::$rules);

        if ($validation->passes())
        {
            $block = $this->blocks->find($id);
            $block->update($input);

            return Redirect::route('cms.blocks.show', $id);
        }

        return Redirect::route('cms.blocks.edit', $id)
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
        $this->blocks->find($id)->delete();

        return Redirect::route('cms.blocks.index');
    }
    
}