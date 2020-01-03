<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreatorRequest as StoreRequest;
use App\Http\Requests\CreatorUpdateRequest as UpdateRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
class CreatorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\RevisionsOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Creator');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/creator');
        $this->crud->setEntityNameStrings('creator', 'Creators');
    }

    protected function setupListOperation()
    {
        
        $this->crud->addColumn([
           'name' => 'avatar', // The db column name
           'label' => "Avatar", // Table column heading
           'type' => 'image',
            // 'prefix' => 'folder/subfolder/',
            // optional width/height if 25px is not ok with you
             'height' => 'auto',
             'width' => '100px',
        ]);
        $this->crud->setFromDb();
        
         //$this->crud->enableExportButtons();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(StoreRequest::class);
        $this->crud->addField([
           'name' => 'avatar', // The db column name
           'label' => "Avatar", // Table column heading
           'type' => 'upload',
           'upload' => true,
        ]);
        $this->crud->setFromDb();
        
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(UpdateRequest::class);
        $this->crud->addField([
           'name' => 'avatar', // The db column name
           'label' => "Avatar", // Table column heading
           'type' => 'upload',
           'upload' => true,
           
        ]);
        $this->crud->setFromDb();
    }
    
}
