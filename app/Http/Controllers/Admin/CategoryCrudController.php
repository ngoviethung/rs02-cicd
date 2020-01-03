<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest as StoreRequest;
use App\Http\Requests\CategoryUpdateRequest as UpdateRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\RevisionsOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Category');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/category');
        $this->crud->setEntityNameStrings('category', 'categories');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
           'name' => 'thumb', // The db column name
           'label' => "Thumb", // Table column heading
           'type' => 'image',
            // 'prefix' => 'folder/subfolder/',
            // optional width/height if 25px is not ok with you
             'height' => 'auto',
             'width' => '100px',
        ]);
        $this->crud->setFromDb();
         
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(StoreRequest::class);
        $this->crud->addField([
           'name' => 'thumb', // The db column name
           'label' => "Thumb", // Table column heading
           'type' => 'upload',
           'upload' => true,
        ]);
        
        $this->crud->addField([  //select_from_array
            'name' => 'tab',
            'label' => "Tab",
            'type' => 'select_from_array',
            'options' => ['sleep' => 'Sleep', 'meditation' => 'Meditation', 'well-being' => 'Well-being', 'music' => 'Music'],
            'allows_null' => false,
            'default' => 'popular_filters',
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
        ]);
        $this->crud->setFromDb();
        
        
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(UpdateRequest::class);
        $this->crud->addField([
           'name' => 'thumb', // The db column name
           'label' => "Thumb", // Table column heading
           'type' => 'upload',
           'upload' => true,
           
        ]);
        
        $this->crud->addField([  //select_from_array
            'name' => 'tab',
            'label' => "Tab",
            'type' => 'select_from_array',
            'options' => ['sleep' => 'Sleep', 'meditation' => 'Meditation', 'well-being' => 'Well-being', 'music' => 'Music'],
            'allows_null' => false,
            'default' => 'popular_filters',
            'allows_multiple' => false, // OPTIONAL; needs you to cast this to array in your model;
        ]);
        $this->crud->setFromDb();
    }
    
}
