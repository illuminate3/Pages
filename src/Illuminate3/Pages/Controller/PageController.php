<?php

namespace Illuminate3\Pages\Controller;

use Illuminate3\Crud\CrudController;
use Illuminate3\Form\FormBuilder;
use Illuminate3\Model\ModelBuilder;
use Illuminate3\Overview\OverviewBuilder;
use Illuminate3\Pages\Model\Page;
use Illuminate3\Pages\Model\Section;
use Illuminate3\Pages\Model\Block;
use DB, App, View, Input, Config, Redirect;

class PageController extends CrudController
{
	/**
	 * @param FormBuilder $fb
	 */
	public function buildForm(FormBuilder $fb)
	{
		$fb->text('title')->label('Title')->required();
		$fb->text('route')->label('Route')->required();
		$fb->text('alias')->label('Alias');
		$fb->modelRadio('layout_id')->alias('layout')->label('Layout')->model('Illuminate3\Pages\Model\Layout')->value(2);
		$fb->text('controller')->label('Controller');
		$fb->text('color')->label('Color')->value('#31b0d5');
		$fb->select('method')->label('Method')->choices(array(
			'get' => 'GET',
			'post' => 'POST',
			'put' => 'PUT',
			'patch' => 'PATCH',
			'delete' => 'DELETE',
			'resource' => 'Resource'
		))->value('get');
	}

	/**
	 * @param ModelBuilder $mb
	 */
	public function buildModel(ModelBuilder $mb)
	{
		$mb->name('Illuminate3\Pages\Model\Page')->table('pages');
	}

	/**
	 * @param OverviewBuilder $ob
	 */
	public function buildOverview(OverviewBuilder $ob)
	{
		$ob->fields(array('title', 'route', 'layout_id'));
	}

}

