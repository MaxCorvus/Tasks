<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once 'Autoloader.php';
use DbConnection\Db;
use Routes\Route;
Route::get('/Blog/posts', 'getPosts');
Route::post('/Blog/addPost', 'addPost');
Route::post('/Blog/addComment', 'addComment');
Route::post('/Blog/addRate', 'addRate');

try {

    Route::handleRequest($_SERVER['REQUEST_METHOD'], parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
}
catch (Exception $e) {
    echo $e->getMessage();
}


