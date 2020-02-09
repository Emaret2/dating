<?php
/*
 * Elijah Maret
 * IT 328
 * 1/16/2020
 * 1/25/2020
 * Dating Website part 2
 *
 * index.php
 *
 * This is the controller file for my dating website assignment it redirects to home.html
*/

//The Controller

session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require the autoload file
require_once('vendor/autoload.php');

//Create an instance of the base class
$f3 = Base::instance();

$f3->set('indoorInterests', array("Tv", "Movies", "Cooking", "Board games", "Puzzles",
    "Reading", "Playing cards", "Videogames"));

$f3->set('indoorInterests', array("Hiking", "Biking", "Swimming", "Collecting", "Walking", "Climbing"));

//Define a default route

$f3->route('GET /', function() {
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET /home', function() {
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET /personal', function() {
    $view = new Template();
    echo $view->render('views/formPersonal.html');
});
$f3->route('POST /profile', function() {
    //var_dump($_POST);
    $_SESSION['firstName'] = $_POST['firstName'];
    $_SESSION['lastName'] = $_POST['lastName'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['phone'] = $_POST['phone'];
    $view = new Template();
    echo $view->render('views/formProfile.html');
});

$f3->route('POST /interests', function() {
    //var_dump($_POST);
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['state'] = $_POST['state'];
    $_SESSION['seeking'] = $_POST['seeking'];
    $_SESSION['biography'] = $_POST['biography'];

    $view = new Template();
    echo $view->render('views/formInterests.html');
});

$f3->route('POST /summary', function() {
    //var_dump($_SESSION);
    $_SESSION['interests'] = $_POST['interests'];
    $view = new Template();
    echo $view->render('views/summary.html');
});



//Run fat free
$f3->run();