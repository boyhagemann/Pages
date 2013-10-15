<?php

namespace Boyhagemann\Pages\Model;

use DB, Str;

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

//    /**
//     * @return \Illuminate\Database\Eloquent\Collection
//     */
//    public function content()
//    {
//        return $this->hasMany('Boyhagemann\Pages\Model\Content')->with('block');
//    }
//
//	/**
//	 * @return array
//	 */
//	public function getBlocksAttribute()
//	{
//		$blocks = array();
//
//		foreach($this->content as $content) {
//
//			$block = $content->block;
//			if(!$block instanceof Block) {
//				$block = new Block;
//				$block->title = 'Default block';
//				$block->controller = $content->controller;
//				$block->locked = true;
//			}
//
//			$blocks[$content->section_id][] = $block;
//		}
//
//		return $blocks;
//	}
//
//    public function getBlocks()
//    {
//        $q = Content::with(array('page', 'page.layout', 'page.layout.sections', 'section', 'block'));
//
//        $blocks = array();
//        $globals = array();
//
//        foreach($q->get() as $content) {
//
//            $route = $content->page->route;
//			$controller = $content->controller ?: $content->block->controller;
//
//            // Fill the empty sections first
//            if(!isset($blocks[$route])) {
//                foreach($content->page->layout->sections as $section) {
//                    $blocks[$route]['sections'][$section->name] = array();
//                }
//            }
//
//            $section = $content->section->name;
//            $block = array(
//                'controller' => $controller,
//                'params' => $content->params,
//                'match' => $content->match,
//            );
//
//            if($content->global == 1) {
//                $globals['sections'][$section][] = $block;
//            }
//            else {
//                $blocks[$route]['layout'] = $content->page->layout->name;
//                $blocks[$route]['sections'][$section][] = $block;
//            }
//
//        }
//
//        foreach($blocks as &$config) {
//            $config = array_merge_recursive($config, $globals);
//        }
//
//        return $blocks;
//    }
//

	/**
	 *
	 */
	static public function createResourcePages($title, $controller, $url)
	{
		// Create pages
		foreach(array('index', 'create', 'store', 'edit', 'update', 'destroy') as $action) {

			$route = '/' . trim($url, '/');
			$alias = str_replace('/', '.', trim($url, '/')) . '.' . $action;
			$title = $action;
			$match = null;
			$method = 'get';

			switch($action) {

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

			$layout = 'admin::layouts.admin';
			$zone = 'content';

			$page = self::createWithContent($title, $route, $controller . '@' . $action, $layout, $zone, $method, $alias);
//			$page->resource()->associate($resource);
			$page->save();
		}

	}

	/**
	 * @param        $title
	 * @param        $route
	 * @param        $controller
	 * @param string $method
	 * @param string $layout
	 *
	 * @return \Boyhagemann\Pages\Model\Page
	 */
	public static function createWithContent($title, $route, $controller, $layout, $zone = 'content', $method = 'get', $alias = null)
	{
		$layout = Layout::whereName($layout)->first();
//		$section = Section::whereName($section)->first();

		$page = new Page;
		$page->title = $title;
		$page->route = $route;
		$page->alias = $alias;
		$page->layout()->associate($layout);
		$page->controller = $controller;
		$page->method = $method;
//		$page->save();

//		$content = new Content;
//		$content->page()->associate($page);
//		$content->section()->associate($section);
//		$content->controller = $controller;
//		$content->params = (array) $params;
//		$content->match = (array) $match;
//		$content->save();

		return $page;
	}
}

