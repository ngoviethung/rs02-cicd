@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'wrapperClass'=> 'shadow-xs',
        'heading'     => trans('backpack::base.welcome'),
        'content'     => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];
    $widgets['after_content'][] = [
	  'type' => 'div',
	  'class' => 'row',
	  'content' => [ // widgets 
	       [
			  'type' => 'card',
			  // 'wrapperClass' => 'col-sm-6 col-md-4', // optional
			  // 'class' => 'card bg-dark text-white', // optional
			  'content' => [
			      'header' => 'Some card title', // optional
			      'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non mi nec orci euismod venenatis. Integer quis sapien et diam facilisis facilisis ultricies quis justo. Phasellus sem <b>turpis</b>, ornare quis aliquet ut, volutpat et lectus. Aliquam a egestas elit. <i>Nulla posuere</i>, sem et porttitor mollis, massa nibh sagittis nibh, id porttitor nibh turpis sed arcu.',
			  ]
			],
			[
			  'type' => 'card',
			  // 'wrapperClass' => 'col-sm-6 col-md-4', // optional
			  // 'class' => 'card bg-dark text-white', // optional
			  'content' => [
			      'header' => 'Another card title', // optional
			      'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non mi nec orci euismod venenatis. Integer quis sapien et diam facilisis facilisis ultricies quis justo. Phasellus sem <b>turpis</b>, ornare quis aliquet ut, volutpat et lectus. Aliquam a egestas elit. <i>Nulla posuere</i>, sem et porttitor mollis, massa nibh sagittis nibh, id porttitor nibh turpis sed arcu.',
			  ]
			],
			[
			  'type' => 'card',
			  // 'wrapperClass' => 'col-sm-6 col-md-4', // optional
			  // 'class' => 'card bg-dark text-white', // optional
			  'content' => [
			      'header' => 'Yet another card title', // optional
			      'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non mi nec orci euismod venenatis. Integer quis sapien et diam facilisis facilisis ultricies quis justo. Phasellus sem <b>turpis</b>, ornare quis aliquet ut, volutpat et lectus. Aliquam a egestas elit. <i>Nulla posuere</i>, sem et porttitor mollis, massa nibh sagittis nibh, id porttitor nibh turpis sed arcu.',
			  ]
			],
	  ]
	];
    $widgets['after_content'][] = [
	  'type'         => 'alert',
	  'class'        => 'alert alert-warning bg-dark border-0 mb-2',
	  'heading'      => 'Demo Refreshes Every Hour on the Hour',
	  'content'      => 'At hh:00, all custom entries are deleted, all files, everything. This cleanup is necessary because developers like to joke with their test entries, and mess with stuff. But you know that :-) Go ahead - make a developer smile.' ,
	  'close_button' => true, // show close button or not
	];
@endphp

@section('content')
@endsection