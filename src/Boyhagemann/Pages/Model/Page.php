<?php

namespace Boyhagemann\Pages\Model;

use DB,
    Str,
    Event;

class Page extends \Eloquent
{
    protected $table = 'pages';
    public $timestamps = false;
    public $rules = array();
    protected $guarded = array('id');
    protected $fillable = array(
        'title',
        'route',
        'alias',
        'method',
        'layout_id',
        'controller',
    );

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function layout()
    {
        return $this->belongsTo('Boyhagemann\Pages\Model\Layout');
    }

    /**
     * @param $title
     * @param $controller
     * @param $url
     * @return array
     */
    static public function createResourcePages($title, $controller, $url, $layout = 'admin::layouts.admin')
    {
        // Create pages
        foreach (array('index', 'create', 'store', 'edit', 'update', 'destroy') as $action) {

            $pages[$action] = self::createResourcePage($title, $controller, $url, $action, $layout);
        }

        return $pages;
    }

    /**
     * @param $title
     * @param $controller
     * @param $url
     * @param $action
     * @return Page
     */
    static public function createResourcePage($title, $controller, $url, $action, $layout)
    {
        $route = '/' . trim($url, '/');
        $alias = str_replace('/', '.', trim($url, '/')) . '.' . $action;
        $title = $action;
        $match = null;
        $method = 'get';

        switch ($action) {

            case 'index':
                $title = Str::plural($title);
                break;

            case 'create':
                $route .= '/create';
                break;

            case 'store':
                $method = 'post';
                break;

            case 'edit':
                $route .= '/{id}/edit';
                break;

            case 'update':
                $method = 'put';
                $route .= '/{id}';
                break;

            case 'destroy':
                $method = 'delete';
                $route .= '/{id}';
                $title = 'delete';
                break;
        }

        $page = self::createWithContent($title, $route, $controller . '@' . $action, $layout, $method, $alias);

        return $page;
    }

    /**
     * @param        $title
     * @param        $route
     * @param        $controller
     * @param        $layout
     * @param string $section
     * @param string $method
     * @param null   $alias
     * @return Page
     */
    public static function createWithContent($title, $route, $controller, $layout, $method = 'get', $alias = null)
    {
        $layout = Layout::whereName($layout)->first();
        $page = Page::whereRoute($route)->whereMethod($method)->first();

        if (!$alias) {
            $alias = $route;
        }

        if (!$page) {
            $page = new Page;
            $page->title = $title;
            $page->route = $route;
            $page->alias = $alias;
            $page->layout()->associate($layout);
            $page->controller = $controller;
            $page->method = $method;
            $page->save();
        }


        Event::fire('page.createWithContent', array($page));

        return $page;
    }

}

