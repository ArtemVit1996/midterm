<?php
/*
 * Artem Vityuk
 * 4/28/2020
 * This file is used for all the "behind the scenes" code
 * It contains the required files, instantiations and routes
 */

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// start a session
session_start();

// Require the autoload file
require_once("vendor/autoload.php");

// Instantiate the F3 Base class
$f3 = Base::instance();

// Default route
$f3->route('GET /', function() {
    // echo '<h1>Dating website</h1>';

    $view = new Template();
    echo $view->render('views/home.html');
});

// page1 route
$f3->route('GET|POST /page1', function($f3) {

    // If the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST); // testing purposes
        // { ["ftname"]=> string(6) "Artem " ["lname"]=> string(6) "Vityuk"
        // ["age"]=> string(2) "24" ["gender"]=> string(4) "male"
        // ["phone"]=> string(7) "hmmm206" }

        // Validate data here
        // 4/29 Zoom recording
        // if ............ { }

        // else (Data is valid) {
            // store data in the session array
                $_SESSION['fname'] = $_POST['fname'];
                $_SESSION['lname'] = $_POST['lname'];
                $_SESSION['age'] = $_POST['age'];
                $_SESSION['gender'] = $_POST['gender'];
                $_SESSION['phone'] = $_POST['phone'];
                // Reroute to summary to test
                //$f3-> reroute('summary');

        // route to the next page (page2)
            $f3-> reroute('page2');
        // }


    }

    $view = new Template();
    echo $view->render('views/page1.html');
});

// page2(profile) route
$f3->route('GET|POST /page2', function($f3) {

    // If the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        var_dump($_POST); // testing purposes
        // { ["ftname"]=> string(6) "Artem " ["lname"]=> string(6) "Vityuk"
        // ["age"]=> string(2) "24" ["gender"]=> string(4) "male"
        // ["phone"]=> string(7) "hmmm206" }

        // Validate data here
        // 4/29 Zoom recording
        // if ............ { }

        // else (Data is valid) {
        // store data in the session array
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['loc'] = $_POST['loc'];
        $_SESSION['seeking'] = $_POST['gender'];
        $_SESSION['bio'] = $_POST['bio'];
        // Reroute to summary to test
        //$f3->reroute('summary');

        // route to the next page (page2)
        $f3-> reroute('page3');
        // }
    }


    $view = new Template();
    echo $view->render('views/page2.html');
});

// page3(interests) route
$f3->route('GET|POST /page3', function($f3) {

    // If the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST); // testing purposes
        // { ["ftname"]=> string(6) "Artem " ["lname"]=> string(6) "Vityuk"
        // ["age"]=> string(2) "24" ["gender"]=> string(4) "male"
        // ["phone"]=> string(7) "hmmm206" }

        // Validate data here
        // 4/29 Zoom recording
        // if ............ { }

        // else (Data is valid) {
        // store data in the session array
        /*
        $_SESSION['activity1'] = $_POST['in1'];
        $_SESSION['activity2'] = $_POST['in2'];
        $_SESSION['activity3'] = $_POST['in3'];
        $_SESSION['activity4'] = $_POST['in4'];
        */

        // define a session array
        if (!isset($_SESSION['activities'])){
            $_SESSION['activities'] = array();
        }

        $count = 1;
        while ($count < 13){
            if (!empty($_POST['a'.$count])) {
                array_push($_SESSION['activities'],$_POST['a'.$count]);
            }
            $count++;
        }

        foreach ($_SESSION['activities'] as $item){
            echo $item.'<br>';
        }
        // route to the summary page
        $f3-> reroute('summary');


    }

    $view = new Template();
    echo $view->render('views/page3.html');
});

// summary route
$f3->route('GET /summary', function() {

    // echo "<h1>Thank you !</h1>";

    $view = new Template();
    echo $view->render('views/summary.html');
    session_destroy();
});

// Run F3
$f3->run();