<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProjectCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProjectCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Project::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/project');
        CRUD::setEntityNameStrings('project', 'projects');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('title')->type('text');
        CRUD::column('slug')->type('text');
        CRUD::column('is_published')->type('boolean');
        CRUD::column('is_featured')->type('boolean');
        CRUD::column('published_at')->type('datetime');
        CRUD::column('status')->type('text');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProjectRequest::class);
        
        CRUD::field('title')->type('text');
        CRUD::field('slug')->type('text');
        CRUD::field('description')->type('textarea');
        CRUD::field('excerpt')->type('textarea');
        CRUD::field('cover_image')->type('text');
        
        CRUD::field('tech_stack')->type('text')
            ->hint('Comma separated values, we can cast it if needed.'); 
            
        CRUD::field('repo_url')->type('url');
        CRUD::field('live_url')->type('url');
        
        CRUD::field('is_featured')->type('boolean');
        CRUD::field('is_published')->type('boolean');
        CRUD::field('published_at')->type('datetime');
        CRUD::field('status')->type('text')->default('planned');
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
