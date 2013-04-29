<?php

namespace Boyhagemann\Pages\Model;

use Boyhagemann\Pages\Model\Block;
use Boyhagemann\Pages\Model\PageBlock;

class Page extends \Eloquent {
    protected $guarded = array();

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';
    
    public static $rules = array(
		'title' => 'required'
	);
    
    public function layout()
    {
        return $this->belongsTo('Boyhagemann\Pages\Model\Layout');
    }
    
    public function content()
    {
        return $this->hasMany('Boyhagemann\Pages\Model\PageBlock');
    }

    

    public function getSortedContent()
    {        
        $content = array();
        
        foreach($this->content as $pageBlock) {
            $content[$pageBlock->zone->name][] = $pageBlock;
        }
        
        // Add empty zones, this prevent the layout from throwing
        // errors.
        foreach($this->layout->zones as $zone) {
            if(!isset($content[$zone->name])) {
                $content[$zone->name] = array();
            }
        }
        
        return $content;        
    }
    

    public function getDefaults()
    {
        return array(
            'id' => 1
        );
    }
    
    /**
     * 
     * @param string $name
     * @param Route $route
     * @return Boyhagemann\Pages\Model\Page
     */
    static public function createFromRoute($name, $route)
    {        
        if(!$route->getOption('_uses')) {
            return;
        }
        
        $page = new self();
        $page->title = \Illuminate\Support\Str::camel($name);
        $page->name = $name;
        $page->path = $route->getPath();
        $page->layout_id = 1;
        $page->save();
        
        $block = new Block;
        $block->title = 'Main content';
        $block->action = $route->getOption('_uses');
        $block->save();
        
        $pageBlock = new PageBlock();
        $pageBlock->block_id = $block->id;
        $pageBlock->page_id = $page->id;
        $pageBlock->zone_id = 1;
        $pageBlock->save();
        
        return $page;
    }
}