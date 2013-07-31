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
        'url',
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
        return $this->belongsTo('Pages\Layout');
    }

    public function content()
    {
        return $this->hasMany('Pages\Content');
    }

    public function getBlocks()
    {
        $blocks = array();
        foreach($this->with(array('layout', 'content', 'content.section'))->get() as $page) {
            
            $config = array(
                'layout' => $page->layout->name,
            );
            
            foreach($page->content as $content) {
                $section = $content->section->name;
                $controller = $content->block->controller;
                $config['sections'][$section][]['controller'] = $controller;
            }
            
            $blocks[$page->url] = $config;
        }
        
        return $blocks;
    }
}
