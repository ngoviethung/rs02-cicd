<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AlbumRequest as StoreRequest;
use App\Http\Requests\AlbumUpdateRequest as UpdateRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
class AlbumCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\RevisionsOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Album');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/album');
        $this->crud->setEntityNameStrings('album', 'albums');
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
        $this->crud->addColumn([
           // 1-n relationship
           'label' => "Category", // Table column heading
           'type' => "select",
           'name' => 'category_id', // the column that contains the ID of that connected entity;
           'entity' => 'category', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\Models\Category", // foreign key model
        ]);
        $this->crud->addColumn([
           // 1-n relationship
           'label' => "Topic", // Table column heading
           'type' => "select",
           'name' => 'topic_id', // the column that contains the ID of that connected entity;
           'entity' => 'topic', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\Models\Topic", // foreign key model
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
        $this->crud->addField([  // Select
           'label' => "Category",
           'type' => 'select',
           'name' => 'category_id', // the db column for the foreign key
           'entity' => 'category', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model' => "App\Models\Category" // foreign key model
        ]);
        $this->crud->addField([  // Select
           'label' => "Topic",
           'type' => 'select',
           'name' => 'topic_id', // the db column for the foreign key
           'entity' => 'topic', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model' => "App\Models\Topic" // foreign key model
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
        $this->crud->addField([  // Select
           'label' => "Category",
           'type' => 'select',
           'name' => 'category_id', // the db column for the foreign key
           'entity' => 'category', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model' => "App\Models\Category" // foreign key model
        ]);
        $this->crud->addField([  // Select
           'label' => "Topic",
           'type' => 'select',
           'name' => 'topic_id', // the db column for the foreign key
           'entity' => 'topic', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model' => "App\Models\Topic" // foreign key model
        ]);
        $this->crud->setFromDb();
    }
    
}
