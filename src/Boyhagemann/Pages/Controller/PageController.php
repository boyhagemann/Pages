<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Crud\CrudController;
use Boyhagemann\Form\FormBuilder;
use Boyhagemann\Model\ModelBuilder;
use Boyhagemann\Overview\OverviewBuilder;
use Boyhagemann\Pages\Model\Page;
use Boyhagemann\Pages\Model\Section;
use Boyhagemann\Pages\Model\Block;
use DB, App, View, Input, Config, Redirect;

class PageController extends CrudController
{
	/**
	 * @param FormBuilder $fb
	 */
	public function buildForm(FormBuilder $fb)
	{
		$fb->text('title')->label('Title');
		$fb->text('route')->label('Route');
		$fb->text('alias')->label('Alias');
		$fb->modelSelect('layout_id')->alias('layout')->label('Layout')->model('Boyhagemann\Pages\Model\Layout');
		$fb->text('controller')->label('Controller');
		$fb->select('method')->label('Method')->choices(array(
			'get' => 'GET',
			'post' => 'POST',
			'put' => 'PUT',
			'patch' => 'PATCH',
			'delete' => 'DELETE',
			'resource' => 'Resource'
		))->value('get');
	}

	/**
	 * @param ModelBuilder $mb
	 */
	public function buildModel(ModelBuilder $mb)
	{
		$mb->name('Boyhagemann\Pages\Model\Page')->table('pages');
		$mb->autoGenerate();
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
			'view' => array(
//				'create' => 'crud::crud.create',
				'edit' => 'pages::page.edit',
				'index' => 'pages::page.index',
			),
                        'redirects.success.store' => 'pages::page.content'
		);
	}

}

