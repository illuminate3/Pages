<?php

namespace Illuminate3\Pages\Subscriber;

use Illuminate\Events\Dispatcher as Events;
use Illuminate3\Form\FormBuilder;
use Illuminate3\Pages\Controller\PageController;
use Illuminate3\Crud\CrudController;
use Illuminate\Database\Eloquent\Model;
use Illuminate3\Pages\Model\Page;
use Sentry, Input;

/**
 *
 * @package Illuminate3\Admin\Subscriber
 */
class SetPermissionsForViewingPage
{
	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param Events $events
	 */
	public function subscribe(Events $events)
	{
		$events->listen('crud::saved', array($this, 'onSaved'));
		$events->listen('page.createWithContent', array($this, 'onCreateWithContent'));
		$events->listen('form.formBuilder.build.before', array($this, 'onBuildForm'));
	}

	/**
	 * @param Model          $model
	 * @param CrudController $controller
	 */
	public function onCreateWithContent(Page $page)
	{
        $permission = 'view.page.' . $page->alias;

        if(strpos($page->alias, 'admin.') === 0) {
            
            $admin = Sentry::findGroupByName('admin');
            $admin->permissions += array($permission => 1);
            $admin->save();
        }
	}

	/**
	 * @param Model          $model
	 * @param CrudController $controller
	 */
	public function onSaved(Model $model, CrudController $controller)
	{
		// We are only interested in a page controller
		if(!$controller instanceof PageController) {
			return;
		}
        
        $permission = 'view.page.' . $model->alias;
        
        foreach(Sentry::findAllGroups() as $group) {
            
            $allowed = in_array($group->id, Input::get('viewable_by_group'));            
            $status = $allowed ? 1 : 0;
            
            $group->permissions += array($permission => $status);
            $group->save();
        }
            
        
	}
    
	/**
	 * @param FormBuilder $fb
	 */
	public function onBuildForm(FormBuilder $fb)
	{
		if($fb->getName() != 'Illuminate3\Pages\Controller\PageController') {
			return;
		}
        
		$fb->modelCheckbox('viewable_by_group')
            ->model('Cartalyst\Sentry\Groups\Eloquent\Group')
            ->field('name')
            ->label('Allowed for')
            ->value(array(1, 2));
	}

}