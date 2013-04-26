<?php

namespace Boyhagemann\Pages\Model;

class Block extends \Eloquent {
    protected $guarded = array();

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'blocks';
    
    public static $rules = array(
		'title' => 'required'
	);
    
}