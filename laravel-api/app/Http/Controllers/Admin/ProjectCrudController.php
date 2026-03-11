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
        
        // --- BASIC INFO TAB ---
        CRUD::addField([
            'name' => 'title',
            'type' => 'text',
            'tab'  => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'slug',
            'type' => 'text',
            'tab'  => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'excerpt',
            'type' => 'textarea',
            'tab'  => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'description',
            'type' => 'textarea',
            'tab'  => 'Basic Info',
        ]);
        CRUD::addField([
            'name' => 'cover_image',
            'label' => 'Thumbnail URL',
            'type' => 'text',
            'tab'  => 'Basic Info',
        ]);
        
        // --- CASE STUDY TAB ---
        CRUD::addField([
            'name' => 'problem',
            'type' => 'textarea',
            'tab'  => 'Case Study',
            'hint' => 'What was the core problem to solve?'
        ]);
        CRUD::addField([
            'name' => 'solution',
            'type' => 'textarea',
            'tab'  => 'Case Study',
            'hint' => 'How did you approach it?'
        ]);
        CRUD::addField([
            'name' => 'implementation',
            'type' => 'textarea',
            'tab'  => 'Case Study',
            'hint' => 'Technical details and execution.'
        ]);
        CRUD::addField([
            'name' => 'result',
            'type' => 'textarea',
            'tab'  => 'Case Study',
            'hint' => 'Final outcome and learnings.'
        ]);
        CRUD::addField([
            'name' => 'metrics',
            'label' => 'Metrics (JSON)',
            'type' => 'textarea',
            'tab'  => 'Case Study',
            'hint' => 'Optional quantifiable results formatted as JSON (e.g., {"users": "10k+", "uptime": "99.9%"}).'
        ]);

        // --- LINKS & META TAB ---
        CRUD::addField([
            'name' => 'repo_url',
            'label' => 'Repository URL',
            'type' => 'url',
            'tab'  => 'Links & Meta',
        ]);
        CRUD::addField([
            'name' => 'live_url',
            'label' => 'Live Demo URL',
            'type' => 'url',
            'tab'  => 'Links & Meta',
        ]);
        CRUD::addField([
            'name' => 'tech_stack',
            'label' => 'Tech Stack (JSON format array)',
            'type' => 'textarea',
            'tab'  => 'Links & Meta',
            'hint' => 'e.g., ["Vue", "Laravel", "Tailwind"]',
        ]);
        
        CRUD::addField([
            'name' => 'is_featured',
            'label' => 'Featured Project',
            'type' => 'checkbox',
            'tab'  => 'Links & Meta',
        ]);
        CRUD::addField([
            'name' => 'is_published',
            'label' => 'Published',
            'type' => 'checkbox',
            'tab'  => 'Links & Meta',
        ]);
        CRUD::addField([
            'name' => 'published_at',
            'type' => 'datetime',
            'tab'  => 'Links & Meta',
        ]);
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
