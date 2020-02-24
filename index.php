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

//Require the autoload file
require_once('vendor/autoload.php');

session_start();

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('model/validations.php');  // I tried adding this through composer and updating, but it doesn't seem to work

//Create an instance of the base class
$f3 = Base::instance();

// create controller
$controller = new DatingController($f3);

$f3->set('states', array('Alabama', 'Alaska', 'Arizona' ,'Arkansas', 'California', 'Colorado', 'Connecticut',
    'Delaware', 'District Of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana',
    'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
    'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico',
    'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
    'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington',
    'West Virginia', 'Wisconsin', 'Wyoming'));

$f3->set('genders', array("Male", "Female"));

$f3->set('indoorInterestsAll', array("TV", "Movies", "Cooking", "Board games", "Puzzles",
    "Reading", "Playing cards", "Videogames"));

$f3->set('outdoorInterestsAll', array("Hiking", "Biking", "Swimming", "Collecting", "Walking", "Climbing"));

//Define a default route

$f3->route('GET /', function() {
    global $controller;
    $controller ->home();
});

$f3->route('GET /home', function() {
    global $controller;
    $controller ->home();
});


$f3->route('GET|POST /personal', function($f3) {
    global $controller;
    $controller ->personal($f3);
});


$f3->route('GET|POST /profile', function($f3) {
    global $controller;
    $controller ->profile($f3);
});

$f3->route('GET|POST /interests', function($f3) {
    global $controller;
    $controller ->interests($f3);
});

$f3->route('GET /summary', function($f3) {
    global $controller;
    $controller ->summary($f3);
});



//Run fat free
$f3->run();