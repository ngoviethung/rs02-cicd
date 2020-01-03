<?php

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    // CRUD resources and other admin routes
    Route::crud('category', 'CategoryCrudController');
    Route::crud('video', 'VideoCrudController');
    Route::crud('audio', 'AudioCrudController');
    Route::crud('album', 'AlbumCrudController');
    Route::crud('playlist', 'PlaylistCrudController');
    Route::crud('creator', 'CreatorCrudController');
    Route::crud('topic', 'TopicCrudController'); 
    Route::crud('cdn-setting', 'CdnCrudController');
});
