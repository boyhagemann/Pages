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
        
        $q = Content::with(array('page', 'page.layout', 'section', 'block'));
        
        $blocks = array();
        $globals = array();
        
        foreach($q->get() as $content) {      
                                    
	    $config = array();
            $section = $content->section->name;
            $controller = $content->block->controller;
                
            if($content->global == 1) {
        
                $config['sections'][$section][]['controller'] = $controller;
                $globals[] = $config;
            }
            else {
                $config = array(
                    'layout' => $content->page->layout->name,
                );  
                $config['sections'][$section][]['controller'] = $controller;
                $blocks[$content->page->route] = $config;
            }
        }

        foreach($blocks as $route => &$config) {
            foreach($globals as $global) {
                $config = array_merge_recursive($config, $global);
            }
        }
        
        //var_dump($blocks); exit;
        return $blocks;
    }
}

