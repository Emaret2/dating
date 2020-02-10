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
require_once('model/validations.php');

//Create an instance of the base class
$f3 = Base::instance();

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
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET /home', function() {
    $view = new Template();
    echo $view->render('views/home.html');
});



$f3->route('GET|POST /personal', function($f3) {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Get data from form
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];

        //$selectedCondiments = !empty($_POST['condiments']) ? $_POST['condiments'] : array();


        //Add data to hive
        $f3->set('firstName', $firstName);
        $f3->set('lastName', $lastName);
        $f3->set('age', $age);
        $f3->set('gender', $gender);
        $f3->set('phone', $phone);

        //If data is valid
        if (validPersonal()) {

            //Write data to Session
            $_SESSION['firstName'] = $_POST['firstName'];
            $_SESSION['lastName'] = $_POST['lastName'];
            $_SESSION['age'] = $_POST['age'];
            $_SESSION['gender'] = $_POST['gender'];
            $_SESSION['phone'] = $_POST['phone'];

            //Redirect to Summary
            $f3->reroute('/profile');
        }
    }

    $view = new Template();
    echo $view->render('views/formPersonal.html');
});


$f3->route('GET|POST /profile', function($f3) {
    //var_dump($_POST);
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Get data from form
        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        $biography = $_POST['biography'];

        //$selectedCondiments = !empty($_POST['condiments']) ? $_POST['condiments'] : array();


        //Add data to hive
        $f3->set('email', $email);
        $f3->set('state', $state);
        $f3->set('seeking', $seeking);
        $f3->set('biography', $biography);

        //If data is valid
        if (validProfile()) {

            //Write data to Session
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['state'] = $_POST['state'];
            $_SESSION['seeking'] = $_POST['seeking'];
            $_SESSION['biography'] = $_POST['biography'];



            //Redirect to Summary
            $f3->reroute('/interests');
        }
    }


    $view = new Template();
    echo $view->render('views/formProfile.html');
});

$f3->route('GET|POST /interests', function($f3) {
    //var_dump($_POST);
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Get data from form
        if(!empty($_POST['outdoorInterests'])){
            $outInts = $_POST['outdoorInterests'];
        }
        if(!empty($_POST['indoorInterests'])){
            $inInts = $_POST['indoorInterests'];
        }

        //$selectedCondiments = !empty($_POST['condiments']) ? $_POST['condiments'] : array();


        //Add data to hive
        $f3->set('outInts', $outInts);
        $f3->set('inInts', $inInts);

        //If data is valid
        if (validInterests()) {

            //Write data to Session
            $_SESSION['outdoorInterests'] = $_POST['outdoorInterests'];
            $_SESSION['indoorInterests'] = $_POST['indoorInterests'];



            //Redirect to Summary
            $f3->reroute('/summary');
        }
    }

    $view = new Template();
    echo $view->render('views/formInterests.html');
});

$f3->route('GET /summary', function() {
    //var_dump($_SESSION);

    $view = new Template();
    echo $view->render('views/summary.html');
});



//Run fat free
$f3->run();