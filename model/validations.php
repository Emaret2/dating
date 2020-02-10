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

    if (!validState($f3->get('state'))) {
        $isValid = false;
        $f3->set("errors['state']", "Enter one of the United States");
    }

    if (!validGender($f3->get('seeking'))) {

        $isValid = false;
        $f3->set("errors['seeking']", "Please choose one of the options");
    }

    return $isValid;

}

function validInterests() {
    global $f3;
    $isValid = true;

    if(sizeof($f3->get('outInts')) == 0){
        if(sizeof($f3->get('inInts')) == 0){ // no interests selected
            $isValid = false;
            $f3->set("error['interestZero']", "Please select at least one interest");
            $f3->set("warning['outdoorInterestZero']", "No Outdoor Interests Selected");
        } else {
        $f3->set("warning['outdoorInterestZero']", "No Outdoor Interests Selected");
        }
    }

    else if (!validOutdoor($f3->get('outInts'))) {
        $isValid = false;
        $f3->set("errors['outdoorInterest']", "Invalid Outdoor Interest");
    }

    if(sizeof($f3->get('inInts')) == 0){
        $f3->set("warning['indoorInterestZero']", "No Indoor Interests Selected");
    }
    else if (!validIndoor($f3->get('inInts'))) {
        $isValid = false;
        $f3->set("errors['indoorInterests']", "Invalid Indoor Interest");
    }

    return $isValid;
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
        return true;
    }
    return false;
}

function validOutdoor($array) {
    global $f3;

    for ($i = 0; $i < sizeof($array); $i ++) {
        if(!in_array($array[$i], $f3->get('outdoorInterestsAll'))){
            return false;
        }
    }
    return true;
}

function validIndoor($array) {
    global $f3;
    for ($i = 0; $i < sizeof($array); $i ++) {
        if(!in_array($array[$i], $f3->get('indoorInterestsAll'))){
            return false;
        }
    }
    return true;
}

function validGender($gender) {
    global $f3;
    return in_array($gender, $f3->get('genders'));
}

function validState($state) {
    global $f3;
    return in_array($state, $f3->get('states'));
}