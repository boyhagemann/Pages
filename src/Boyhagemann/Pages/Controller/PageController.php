<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Crud\CrudController;
use Boyhagemann\Form\FormBuilder;
use Boyhagemann\Model\ModelBuilder;
use Boyhagemann\Overview\OverviewBuilder;
use DB;

class PageController extends CrudController
{
    /**
     * @param FormBuilder $fb
     */
    public function buildForm(FormBuilder $fb)
    {
        $fb->text('title')->label('Title');
        $fb->text('route')->label('Route');
        $fb->modelSelect('layout_id')->alias('layout')->label('Layout')->model('Boyhagemann\Pages\Model\Layout');
		$fb->select('method')->label('Method')->choices(array('get' => 'GET', 'post' => 'POST', 'put' => 'PUT', 'patch' => 'PATCH', 'delete' => 'DELETE'))->value('get');
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

	/**
	 * @return array
	 */
	public function config()
	{
		return array(
			'title' => 'Page',
			'views' => array(
				'index' => 'pages::page.index',
			)
		);
	}

}

