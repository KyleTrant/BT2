<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'autoload.php'; 
require_once 'route.php'; 
define("ROOT_DIR",__DIR__);
Router::get('/', 'UserController@index');
Router::post('/Login', 'UserController@Login');
Router::get('/Login', 'UserController@index');
Router::get('/Register', 'UserController@Register');
Router::post('/Register', 'UserController@Register');
Router::get('/Logout', 'UserController@Logout');
Router::get('/Tasks', 'TaskController@Index');
Router::post('/Tasks/Create', 'TaskController@Create');
Router::post('/Tasks/Update/{id}', 'TaskController@Update');
Router::post('/Tasks/Delete/{id}', 'TaskController@Delete');
//request
Router::dispatch();