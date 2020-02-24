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





        //Add data to hive



        //If data is valid
        if (validPersonal()) {

            if(!empty($_POST['isPremium'])){
                $member = new PremiumMember($firstName, $lastName, $age, $gender, $phone);
                $f3->set('premium', true);
            } else {
                $member = new Member($firstName, $lastName, $age, $gender, $phone);
                $f3->set('premium', false);
            }

            //Write data to Session
            $_SESSION['member'] = $member;

            $f3->set('newMember', $member);


            //Redirect to Summary
            $f3->reroute('/profile');
        } else {
            //Add POST array data to f3 hive for "sticky" form
            $f3->set('personal', $_POST);
        }
    }

    $view = new Template();
    echo $view->render('views/formPersonal.html');
});


$f3->route('GET|POST /profile', function($f3) {
    //var_dump($_POST);
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $member = $_SESSION['member'];


        //$selectedCondiments = !empty($_POST['condiments']) ? $_POST['condiments'] : array();


        //Add data to hive


        //If data is valid
        if (validProfile()) {

            //Get data from form
            $member->setEmail($_POST['email']);
            $member->setState($_POST['state']);
            $member->setSeeking($_POST['seeking']);
            $member->setBio($_POST['biography']);

            $f3->set('newMember', $member);


            //Write data to Session
            $_SESSION['member'] = $member;

            //Redirect to Summary
            if(is_a($member, 'PremiumMember')) {
                $f3->reroute('/interests');
            } else {
                $f3->reroute('/summary');
            }
        } else {
            //Add POST array data to f3 hive for "sticky" form
            $f3->set('profile', $_POST);
        }
    }


    $view = new Template();
    echo $view->render('views/formProfile.html');
});

$f3->route('GET|POST /interests', function($f3) {
    //var_dump($_POST);
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $member = $_SESSION['member'];


        //$selectedCondiments = !empty($_POST['condiments']) ? $_POST['condiments'] : array();




        //If data is valid
        if (validInterests()) {

            //Get data from form

            if(!empty($_POST['outdoorInterests'])){
                $member->setOutDoorInterests($_POST['outdoorInterests']);
            }
            if(!empty($_POST['indoorInterests'])){
                $member->setInDoorInterests($_POST['indoorInterests']);
            }


            //Add data to hive
            $f3->set('newMember', $member);

            //Write data to Session
            $_SESSION['member'] = $member;

            //Redirect to Summary
            $f3->reroute('/summary');
        }else {
            //Add POST array data to f3 hive for "sticky" form
            $f3->set('interests', $_POST);
        }
    }

    $view = new Template();
    echo $view->render('views/formInterests.html');
});

$f3->route('GET /summary', function($f3) {
    //var_dump($_SESSION);

    $member = $_SESSION['member'];

    $f3->set('fname', $member->getFname());
    $f3->set('lname', $member->getLname());
    $f3->set('gender', $member->getGender());
    $f3->set('age', $member->getAge());
    $f3->set('phone', $member->getPhone());
    $f3->set('email', $member->getEmail());
    $f3->set('state', $member->getState());
    $f3->set('seeking', $member->getSeeking());

    if(is_a($member, 'PremiumMember')) {
        $f3->set('premium', true);
        $f3->set('indoorInterests', $member->getInDoorInterests());
        $f3->set('outdoorInterests', $member->getOutDoorInterests());
    }



//    echo "<pre>";
//    print_r($member);
//    echo "</pre>";

    $view = new Template();
    echo $view->render('views/summary.html');
});



//Run fat free
$f3->run();