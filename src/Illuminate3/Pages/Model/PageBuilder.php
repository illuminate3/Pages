<?php

namespace Illuminate3\Pages\Model;

class PageBuilder
{
	/**
	 * @var array
	 */
	protected $data = array();

	/**
	 * @param string $title
	 * @return $this
	 */
	public function title($title)
	{
		$this->data['title'] = $title;
		return $this;
	}

	/**
	 * @param string $route
	 * @return $this
	 */
	public function route($route)
	{
		$this->data['route'] = $route;
		return $this;
	}

	/**
	 * @param string $alias
	 * @return $this
	 */
	public function alias($alias)
	{
		$this->data['alias'] = $alias;
		return $this;
	}

	/**
	 * @param string $method
	 * @return $this
	 */
	public function method($method)
	{
		$this->data['method'] = $method;
		return $this;
	}

	/**
	 * @param Layout $layout
	 * @return $this
	 */
	public function layout($layout)
	{
		if($layout instanceof Layout) {
			$layout = $layout->id;
		}

		$this->data['layout_id'] = $layout;
		return $this;
	}

	/**
	 * @param string $controller
	 * @return $this
	 */
	public function controller($controller)
	{
		$this->data['controller'] = $controller;
		return $this;
	}

	/**
	 * @return Page
	 */
	public function create()
	{
		return Page::create($this->data);
	}

	public function createResourcePages()
	{

	}

	public function createResourcePage()
	{

	}

	public function createWithContent()
	{

	}
}

