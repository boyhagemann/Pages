<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Content\Controller\CrudController;
use Boyhagemann\Pages\Model\Block as Blocks;
use Boyhagemann\Content\ResourceBuilder\Element;
use View, Input, Redirect, Validator;

class BlocksController extends CrudController {
        
    public function init()
    {
        $builder = $this->getResourceBuilder();
        $builder->setModelClass('Boyhagemann\Pages\Model\Block');
        
        $builder->addElement(new Element\Text('title', 'Title'));                
        $builder->addElement(new Element\Text('action', 'Action'));
        $builder->addElement(new Element\Text('path', 'Path'));
        $builder->addElement(new Element\ResourceSelect('layout_id', 'Layout', 'cms.layouts'));
                
        $overview = $this->getOverview();
        $overview->showElements(array('title', 'action'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function available()
    {
//        $blocks = Blocks::where('available', '=', true)->get();

//        return View::make('pages::blocks.available', compact('blocks'));
    }

    
}