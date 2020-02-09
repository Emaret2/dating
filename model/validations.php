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
    if (!empty($id) && preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',$id)){
        return;
    }
    return false;
}
