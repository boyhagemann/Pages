<?php

namespace Boyhagemann\Pages\Model;

class Layout extends \Eloquent
{

    protected $table = 'layouts';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'title',
        'name'
        );

    /**
     * @return \Pages\Section
     */
    public function sections()
    {
        return $this->hasMany('Pages\Section');
    }


}

