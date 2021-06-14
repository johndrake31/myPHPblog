<?php

$modeInscription = false;

$isLoggedIn = false;
$leSecret = "non mais c'est un secret";
$isAdmin = false;

if (isset($_SESSION['userId'])) {
    $isLoggedIn = true;
}

if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    $isAdmin = true;
}


if ($isLoggedIn) {
    echo "LOGGED IN";
} else {
    require_once "login.php";
}
if (isset($_POST['modeInscription']) && $_POST['modeInscription'] == "on") {

    $modeInscription = true;
    require_once "signup.php";
}
if (isset($_POST['modeInscription']) && $_POST['modeInscription'] == "off") {

    $modeInscription = false;
}


if ($modeInscription) {
    require_once "signup.php";
}
