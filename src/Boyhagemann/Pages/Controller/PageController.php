<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Crud\CrudController;
use Boyhagemann\Form\FormBuilder;
use Boyhagemann\Model\ModelBuilder;
use Boyhagemann\Overview\OverviewBuilder;
use DB;

class PageController extends CrudController
{
    protected $viewIndex = 'pages::page.index';
    
    /**
     * @param FormBuilder $fb
     */
    public function buildForm(FormBuilder $fb)
    {
        $fb->text('title')->label('Title');
        $fb->text('route')->label('Route');
        $fb->modelSelect('layout_id')->alias('layout')->label('Layout')->model('Boyhagemann\Pages\Model\Layout');
		$fb->select('method')->label('Method')->choices(array('get' => 'GET', 'post' => 'POST', 'put' => 'PUT', 'patch' => 'PATCH', 'delete' => 'DELETE'))->value('get');
        
        if(DB::table('Boyhagemann\Admin\Model\Resource')) {
            $fb->modelSelect('resource_id')->alias('resource')->label('Resource')->model('Boyhagemann\Admin\Model\Resource');
        }
    }

    /**
     * @param ModelBuilder $mb
     */
    public function buildModel(ModelBuilder $mb)
    {
        $mb->name('Boyhagemann\Pages\Model\Page')->table('pages')->presenter('PagePresenter');
    }

    /**
     * @param OverviewBuilder $ob
     */
    public function buildOverview(OverviewBuilder $ob)
    {
        $ob->fields(array('title', 'route', 'layout_id'));
    }


}

