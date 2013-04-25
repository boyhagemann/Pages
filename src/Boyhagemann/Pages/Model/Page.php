<?php

namespace Boyhagemann\Pages\Model;

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

    

    public function getSortedContent()
    {        
        return array(
            'content' => array(
                array(
                    'action' => 'Boyhagemann\Pages\Controller\PagesController@edit',
                    'defaults' => array(
                        'id' => 1,
                    )
                ),
            ),
            'sidebar' => array(
                array(
                    'action' => 'Boyhagemann\Pages\Controller\PagesController@index',
                    'defaults' => array(),
                    'view' => array(
                        'original' => 'pages::pages.index',
                        'override' => getcwd() . '/../workbench\boyhagemann/pages/src/views/pages/index/sidebar.blade.php',
                    ),
                ),
            )
        );
    }
    
    public function getDefaults()
    {
        return array(
            'id' => 1
        );
    }
}