<?php

    ini_set('display_errors', 'on');
    error_reporting(E_ALL);

    include "admin/connect.php";

    $sessionUser = '';
    if(isset($_SESSION['member'])){

        $sessionUser = $_SESSION['member'];
        
    }
    // Routes
    $tmp = 'includes/templates/';      //templates Directory

    $lang = 'includes/langues/';       // langues dairectory

    $func = 'includes/functions/';    // function dairectory

    $css = 'layout/css/';             //css Directory

    $js = 'layout/js/';               // js Directory



    // include the important files

    // include $lang . 'english.php';       //include langues page

    include $func . 'func.php';         //include function page

    include $tmp . 'header-inc.php';    // include header


