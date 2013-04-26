<?php

namespace Boyhagemann\Pages\Model;

class Zone extends \Eloquent {
    protected $guarded = array();

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'zones';
    
    public static $rules = array(
		'title' => 'required'
	);
    
    public function layout()
    {
        return $this->belongsTo('Boyhagemann\Pages\Model\Layout');
    }
}