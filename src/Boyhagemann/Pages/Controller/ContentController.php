<?php

namespace Boyhagemann\Pages\Controller;

use Boyhagemann\Crud\CrudController;
use Boyhagemann\Form\FormBuilder;
use Boyhagemann\Model\ModelBuilder;
use Boyhagemann\Overview\OverviewBuilder;
use Pages\Page;

class ContentController extends CrudController
{
    public function indexWithPage(Page $page)
    {
        $q = $this->getOverviewBuilder()->getQueryBuilder()->where('page_id', '=', $page->id);
        return $this->index();
    }

    /**
     * @param FormBuilder $fb
     */
    public function buildForm(FormBuilder $fb)
    {
        $fb->modelSelect('page_id')->alias('page')->label('Page')->model('Boyhagemann\Pages\Model\Page');
        $fb->modelSelect('section_id')->alias('section')->label('Section')->model('Boyhagemann\Pages\Model\Section');
        $fb->modelSelect('block_id')->alias('block')->label('Block')->model('Boyhagemann\Pages\Model\Block');
        $fb->textarea('params')->label('Params');
        $fb->textarea('match')->label('Match url params');
        $fb->checkbox('global')->label('Is globally available?');
    }

    /**
     * @param ModelBuilder $mb
     */
    public function buildModel(ModelBuilder $mb)
    {
        $mb->name('Boyhagemann\Pages\Model\Content')->table('content');
    }

    /**
     * @param OverviewBuilder $ob
     */
    public function buildOverview(OverviewBuilder $ob)
    {
        $ob->fields(array('page_id', 'section_id', 'block_id', 'global'));
    }


}

