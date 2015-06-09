<?php

namespace Illuminate3\Pages\Model;

use Illuminate3\Pages\Model\Page;
use Route, DB, Str, Event;

class PageRepository
{

	/**
	 * @param $title
	 * @param $controller
	 * @param $url
	 * @param $layout
	 * @return array
	 */
	static public function createResourcePages($title, $controller, $url = null, $layout = 'layouts.admin')
	{
		if(!$url) {
			$url = 'admin/' . Str::slug($title);
		}

		// Create pages
		foreach (array('index', 'create', 'store', 'edit', 'update', 'destroy') as $action) {

			$pages[$action] = self::createResourcePage($title, $controller, $url, $action, $layout);
		}

		Event::fire('page.createResourcePages', array($pages));

		return $pages;
	}

	/**
	 * @param $title
	 * @param $controller
	 * @param $url
	 * @param $action
	 * @param $layout
	 * @return Page
	 */
	static public function createResourcePage($title, $controller, $url, $action, $layout = 'layouts.admin')
	{
		$route = '/' . trim($url, '/');
		$alias = str_replace('/', '.', trim($url, '/')) . '.' . $action;
		$match = null;
		$method = 'get';

		switch ($action) {

			case 'index':
				$title = Str::plural($title);
				break;

			case 'create':
				$title = 'Create new ' . $title;
				$route .= '/create';
				break;

			case 'store':
				$title = 'Store ' . $title;
				$method = 'post';
				$layout = null;
				break;

			case 'edit':
				$title = 'Edit ' . $title;
				$route .= '/{id}/edit';
				break;

			case 'update':
				$title = 'Update ' . $title;
				$method = 'put';
				$route .= '/{id}';
				$layout = null;
				break;

			case 'destroy':
				$title = 'Delete ' . $title;
				$method = 'delete';
				$route .= '/{id}';
				$layout = null;
				break;
		}

		$page = self::createWithContent($title, $route, $controller . '@' . $action, $layout, $method, $alias);

		Event::fire('page.createResourcePage', array($page, $action));

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
	public static function createWithContent($title, $route, $controller, $layout = 'layouts.default', $method = 'get', $alias = null)
    {        
		$page = Page::whereRoute($route)->whereMethod($method)->first();

        // Nothing to do if the page already exists
		if ($page) {
            return $page;
        }

        // Page does not exist yet, continue creating...
        
        if (!$alias) {
            $alias = $route;
        }

        $page = new Page;
        $page->title = $title;
        $page->route = $route;
        $page->alias = $alias;
        $page->controller = $controller;
        $page->method = $method;

        if($layout) {
            $layout = Layout::whereName($layout)->first();
            $page->layout()->associate($layout);
        }
        
        $page->save();


		Event::fire('page.createWithContent', array($page));

		// Dynamically add the Laravel route
		self::createRoute($page);

		return $page;
    }

    /**
	 * @param Page $page
	 */
	static public function createRoute(Page $page)
   {
	   $method = $page->method;
	   $config['uses'] = $page->controller;
       $config['before'] = 'auth';

	   // Add an alias if it exists for this page
	   if($page->alias) {
		   $config['as'] = $page->alias;
	   }

	   // Add the route the conventional way, only this time all the routes
	   // are added dynamically.
	   $route = Route::$method($page->route, $config, compact('page'));
       
       // Add the current page as an option to the route, so we know
       // the page responsible for this route.
       $route->setOption('page', $page);
   }
}

