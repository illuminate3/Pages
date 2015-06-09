<?php

namespace Illuminate3\Pages\Controller;

use Illuminate3\Crud\CrudController;
use Illuminate3\Form\FormBuilder;
use Illuminate3\Model\ModelBuilder;
use Illuminate3\Overview\OverviewBuilder;

class SectionController extends CrudController
{
	/**
     * @param FormBuilder $fb
     */
    public function buildForm(FormBuilder $fb)
    {
        $fb->text('title')->label('Title');
        $fb->text('name')->label('Name');
        $fb->select('mode')->label('Content mode')->choices(array(
			'protected' => 'Cannot add content',
			'public' => 'Can add content',
		))->default('public');
    }

    /**
     * @param ModelBuilder $mb
     */
    public function buildModel(ModelBuilder $mb)
    {
        $mb->name('Illuminate3\Pages\Model\Section')->table('sections');
    }

    /**
     * @param OverviewBuilder $ob
     */
    public function buildOverview(OverviewBuilder $ob)
    {
        $ob->fields(array('title', 'name'));
    }

	/**
	 * @return array
	 */
	public function config()
	{
		return array(
			'title' => 'Section',
		);
	}

}

