<?php
use Fighter\Router\Router;
Router::group('/api/v1/user',[
    [
        'method'=>'POST',
        'uri'=>'/',
        'controller'=>'ApiController',
        'action' => 'createUser'
    ],
    [
        'method'=>'GET',
        'uri'=>'/:id/posts/',
        'controller'=>'ApiController',
        'action' => 'getUserPostsByUserId'
    ],
    [
        'method'=>'GET',
        'uri'=>'/:id/posts/:postId/',
        'controller'=>'ApiController',
        'action' => 'getUserPostsByUserId'
    ],
    [
        'method'=>'GET',
        'uri'=>'/:id/',
        'controller'=>'ApiController',
        'action' => 'getUserById'
    ]
]);
Router::add([
    'method'=>'GET',
    'uri'=>'/config/app/',
    'controller'=>'AppController',
    'action' => 'getAppConfig'
]);
Router::add([
    [
        'method'=>'GET',
        'uri'=>'/config/web/',
        'controller'=>'WebController',
        'action' => 'getWebConfig'
    ],
    [
        'method'=>'POST',
        'uri'=>'/config/web/',
        'controller'=>'WebController',
        'action' => 'postWebConfig'
    ]
]);