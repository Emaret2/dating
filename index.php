<?php
/*
 * Elijah Maret
 * IT 328
 * 1/16/2020
 * Dating Website
 *
 * index.php
 *
 * This is the controller file for my dating website assignment it redirects to home.html
*/

//The Controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require the autoload file
require_once('vendor/autoload.php');

//Create an instance of the base class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function() {
    $view = new Template();
    echo $view->render('views/home.html');
});

//Run fat free
$f3->run();