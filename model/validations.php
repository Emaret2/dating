<?php


function validPersonal() {
    global $f3;
    $isValid = true;

    if (!validName($f3->get('firstName'))) {

        $isValid = false;
        $f3->set("errors['firstName']", "Please enter your first name");
    }

    if (!validName($f3->get('lastName'))) {

        $isValid = false;
        $f3->set("errors['lastName']", "Please enter your last name");
    }

    if (!validAge($f3->get('age'))) {

        $isValid = false;
        $f3->set("errors['age']", "Please enter an age between 18 and 118");
    }

    if (!validGender($f3->get('gender'))) {

        $isValid = false;
        $f3->set("errors['gender']", "Please choose one of the options");
    }

    if (!validPhone($f3->get('phone'))) {

        $isValid = false;
        $f3->set("errors['phone']", "Invalid phone");
    }

    return $isValid;
}



function validProfile(){
    global $f3;
    $isValid = true;

    if (!validEmail($f3->get('email'))) {

        $isValid = false;
        $f3->set("errors['email']", "Invalid Email");
    }

}


function validName($name) {
    return !empty($name) && ctype_alpha($name);
}

function validAge($age) {
    return $age >= 18 && $age <= 118;
}

function validPhone($phone) {
    $phone = str_replace(" ","",$phone);
    $phone = preg_replace('/-/',"",$phone);
    $phone = preg_replace('/\(/',"",$phone);
    $phone = preg_replace('/\)/',"",$phone);
    $phone = preg_replace('/_/',"",$phone);
    //echo "<p>$id</p>"; for de-bugging purposes
    if (is_numeric($phone) && strlen($phone)===10){
        return true;
    }
    return false;
}

function validEmail($email) {
    if (!empty($email) && preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',$email)){
        return;
    }
    return false;
}

function validOutdoor($array) {
    global $f3;
    for ($i = 0; $i < sizeof($array); $i ++) {
        return in_array($array[$i], $f3->get('outdoorInterests'));
    }
}

function validIndoor($array) {
    global $f3;
    for ($i = 0; $i < sizeof($array); $i ++) {
        return in_array($array[$i], $f3->get('indoorInterests'));
    }
}

function validGender($gender) {
    global $f3;
    return in_array($gender, $f3->get('genders'));
}

function validState($state) {
    global $f3;
    return in_array($state, $f3->get('states'));
}