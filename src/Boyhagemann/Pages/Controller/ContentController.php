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
        $fb->modelSelect('page_id')->label('Page')->model('Pages\Page');
        $fb->modelSelect('section_id')->label('Section')->model('Pages\Section');
        $fb->modelSelect('block_id')->label('Block')->model('Pages\Block');
    }

    /**
     * @param ModelBuilder $mb
     */
    public function buildModel(ModelBuilder $mb)
    {
        $mb->name('Pages\Content')->table('content');
    }

    /**
     * @param OverviewBuilder $ob
     */
    public function buildOverview(OverviewBuilder $ob)
    {
        $ob->fields(array('page_id', 'section_id', 'block_id'));
    }


}

