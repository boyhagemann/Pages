<?php

namespace Boyhagemann\Pages\Model;

use Robbo\Presenter\PresentableInterface;

class Page extends \Eloquent implements PresentableInterface
{
    protected $table = 'pages';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'title',
        'route',
        'layout_id'
        );

    /**
     * @return \PagePresenter
     */
    public function getPresenter()
    {
        return new \PagePresenter($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function layout()
    {
        return $this->belongsTo('Boyhagemann\Pages\Model\Layout');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function content()
    {
        return $this->hasMany('Boyhagemann\Pages\Model\Content');
    }

    public function getBlocks()
    {                
        $q = Content::with(array('page', 'page.layout', 'page.layout.sections', 'section', 'block'));
        
        $blocks = array();
        $globals = array();
        
        foreach($q->get() as $content) {      
                             
            $route = $content->page->route;
            
            // Fill the empty sections first
            if(!isset($blocks[$route])) {
                foreach($content->page->layout->sections as $section) {
                    $blocks[$route]['sections'][$section->name] = array();
                }
            }
                   
            $section = $content->section->name;
            $block = array(
                'controller' => $content->block->controller,
                'params' => $content->params,
                'match' => $content->match,
            );
                        
            if($content->global == 1) {     
                $globals['sections'][$section][] = $block;
            }
            else { 
                $blocks[$route]['layout'] = $content->page->layout->name;  
                $blocks[$route]['sections'][$section][] = $block;
            }
            
        }

        foreach($blocks as &$config) {
            $config = array_merge_recursive($config, $globals);
        }
                
        return $blocks;
    }
}

