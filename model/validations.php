<?php

function validName($name) {
    return !empty($name) && ctype_alpha($name);
}

function validAge($age) {
    return gettype($age) === "integer" && $age >= 18 && $age <= 118;
}

function validPhone($phone) {
    $id = str_replace(" ","",$id);
    $id = preg_replace('/-/',"",$id);
    $id = preg_replace('/\(/',"",$id);
    $id = preg_replace('/\)/',"",$id);
    $id = preg_replace('/_/',"",$id);
    //echo "<p>$id</p>"; for de-bugging purposes
    if (is_numeric($id) && strlen($id)===10){
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
