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

    
    /**
     * 
     * @return array
     */
    public function getSortedContent()
    {        
        $pageBlocks = PageBlock::where('page_id', '=', $this->id)->orWhere('global', '=', true)->get();
        $content = array();
        
        foreach($this->layout->zones as $zone) {
            $content[$zone->name] = array();
        }
                
        foreach($pageBlocks as $pageBlock) {
            $content[$pageBlock->zone->name][] = $pageBlock;
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
        $page->name = $name;
        $page->path = $route->getPath();
        $page->title = self::buildTitle($name);
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
    
    static public function buildTitle($name)
    {
        preg_match_all('/(\w)+/', $name, $matches);
        
        $words = array();
        foreach($matches[0] as $word) {
            $words[] = ucfirst($word);
        }
        
        $title = implode(' ', $words);
        
        if(!$title) {
            $title = '--Page title--';
        }
        return $title;
    }
}