<?php

namespace Illuminate3\Pages\Controller;

use Illuminate3\Crud\CrudController;
use Illuminate3\Form\FormBuilder;
use Illuminate3\Model\ModelBuilder;
use Illuminate3\Overview\OverviewBuilder;

class LayoutController extends CrudController
{
	/**
     * @param FormBuilder $fb
     */
    public function buildForm(FormBuilder $fb)
    {
        $fb->text('title')->label('Title');
        $fb->text('name')->label('Name');
        $fb->modelCheckbox('sections')->model('Illuminate3\Pages\Model\Section')->label('Sections');
    }

    /**
     * @param ModelBuilder $mb
     */
    public function buildModel(ModelBuilder $mb)
    {
        $mb->name('Illuminate3\Pages\Model\Layout')->table('layouts');
        $mb->hasMany('sections')->model('Illuminate3\Pages\Model\Section');
    }

    /**
     * @param OverviewBuilder $ob
     */
    public function buildOverview(OverviewBuilder $ob)
    {
        $ob->fields(array('title'));
    }

	/**
	 * @return array
	 */
	public function config()
	{
		return array(
			'title' => 'Layout',
			'redirects' => array(
				'test'
			)
		);
	}


}

//