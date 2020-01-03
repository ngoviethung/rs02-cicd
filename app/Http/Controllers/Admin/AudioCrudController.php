<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AudioRequest as StoreRequest;
use App\Http\Requests\AudioUpdateRequest as UpdateRequest;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
class AudioCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\RevisionsOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Audio');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/audio');
        $this->crud->setEntityNameStrings('audio', 'audios');
    }

    protected function setupListOperation()
    {
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
        
        $this->crud->addColumn([
           // 1-n relationship
           'label' => "Playlist", // Table column heading
           'type' => "select",
           'name' => 'playlist_id', // the column that contains the ID of that connected entity;
           'entity' => 'creator', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\Models\Playlist", // foreign key model
        ]);
        $this->crud->addColumn([
           // 1-n relationship
           'label' => "Creator", // Table column heading
           'type' => "select",
           'name' => 'creator_id', // the column that contains the ID of that connected entity;
           'entity' => 'topic', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\Models\Creator", // foreign key model
        ]);
        $this->crud->addColumn([
           // 1-n relationship
           'label' => "Album", // Table column heading
           'type' => "select",
           'name' => 'album_id', // the column that contains the ID of that connected entity;
           'entity' => 'album', // the method that defines the relationship in your Model
           'attribute' => "name", // foreign key attribute that is shown to user
           'model' => "App\Models\Album", // foreign key model
        ]);
        
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
           'name' => 'mp3', // The db column name
           'label' => "Mp3", // Table column heading
           'type' => 'mp3',
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
        $this->crud->addField([
           'name' => 'mp3', // The db column name
           'label' => "Mp3", // Table column heading
           'type' => 'custom_upload',
           'upload' => true,
           'attributes' => [
                'id' => 'mp3',
           ], // extra
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
        
        $this->crud->addField([  // Select
           'label' => "Playlist",
           'type' => 'select',
           'name' => 'playlist_id', // the db column for the foreign key
           'entity' => 'playlist', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model' => "App\Models\Playlist" // foreign key model
        ]);
        $this->crud->addField([  // Select
           'label' => "Creator",
           'type' => 'select',
           'name' => 'creator_id', // the db column for the foreign key
           'entity' => 'creator', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model' => "App\Models\Creator" // foreign key model
        ]);
        $this->crud->addField([  // Select
           'label' => "Album",
           'type' => 'select',
           'name' => 'album_id', // the db column for the foreign key
           'entity' => 'album', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model' => "App\Models\Album" // foreign key model
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
        $this->crud->addField([
           'name' => 'mp3', // The db column name
           'label' => "Mp3", // Table column heading
           'type' => 'custom_upload',
           'upload' => true,
           'attributes' => [
                'id' => 'mp3',
           ], // extra
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
        
        $this->crud->addField([  // Select
           'label' => "Playlist",
           'type' => 'select',
           'name' => 'playlist_id', // the db column for the foreign key
           'entity' => 'playlist', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model' => "App\Models\Playlist" // foreign key model
        ]);
        $this->crud->addField([  // Select
           'label' => "Creator",
           'type' => 'select',
           'name' => 'creator_id', // the db column for the foreign key
           'entity' => 'creator', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model' => "App\Models\Creator" // foreign key model
        ]);
        $this->crud->addField([  // Select
           'label' => "Album",
           'type' => 'select',
           'name' => 'album_id', // the db column for the foreign key
           'entity' => 'album', // the method that defines the relationship in your Model
           'attribute' => 'name', // foreign key attribute that is shown to user
           'model' => "App\Models\Album" // foreign key model
        ]);
        $this->crud->setFromDb();
    }
    
}
