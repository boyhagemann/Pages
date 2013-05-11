<?php

namespace Boyhagemann\Pages\Model;

class PageBlock extends \Eloquent {
    protected $guarded = array();

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'page_blocks';
    
    public static $rules = array(
		'page_id' => 'required',
		'zone_id' => 'required',
		'block_id' => 'required',
	);
    
    public function page()
    {
        return $this->belongsTo('Boyhagemann\Pages\Model\Page');
    }
    
    public function block()
    {
        return $this->belongsTo('Boyhagemann\Pages\Model\Block');
    }
    
    public function zone()
    {
        return $this->belongsTo('Boyhagemann\Pages\Model\Zone');
    }
    
    /**
     * 
     * @return array
     */
    public function getDefaults()
    {
        return (array) json_decode($this->defaults);
    }
    
    /**
     * 
     * @param array $defaults
     */
    public function setDefaults(Array $defaults)
    {
        $this->defaults = json_encode($defaults);
    }
    
}