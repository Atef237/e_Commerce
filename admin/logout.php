<?php



    session_start();  //stat the session

    session_unset();  //Destruction of user data

    session_destroy();  //Destruction of sessions

    header('location:index.php');  //redirect to index page

    exit();
