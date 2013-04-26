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
		'title' => 'required'
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
    
}