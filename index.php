<?php 
session_start(); 
require_once 'autoload.php'; 
require_once 'route.php'; 
define("ROOT_DIR",__DIR__);

Router::get('/tasks', 'TaskController@index');
Router::get('/', 'UserController@index');
Router::post('/Login', 'UserController@index');
//request
Router::dispatch();
