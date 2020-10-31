<?php

    include "connect.php";
    // Routes
    $tmp = 'includes/templates/';      //templates Directory

    $lang = 'includes/langues/';       // langues dairectory

    $func = 'includes/functions/';    // function dairectory

    $css = 'layout/css/';             //css Directory

    $js = 'layout/js/';               // js Directory



    // include the important files

    // include $lang . 'english.php';       //include langues page

    include $tmp . 'header-inc.php';    // include header

    include $func . 'func.php';         //include function page
    
   include $tmp . 'navbar.php'; 
