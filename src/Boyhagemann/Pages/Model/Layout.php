<?php

namespace Boyhagemann\Pages\Model;

class Layout extends \Eloquent {
    protected $guarded = array();

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'layouts';
    
    public static $rules = array(
		'title' => 'required'
	);
    
    public function pages()
    {
        return $this->hasMany('Boyhagemann\Pages\Model\Page');
    }
    
}