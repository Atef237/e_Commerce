<?php

session_start();

$pageTitle = '';

if(isset($_SESSION['userName'])){
    
    include 'inti.php';
    
    if(isset($_GET['action'])){

        $action = $_GET['action'];
    }else{
        $action = 'manage';
    }


    if($action == 'manage'){

        echo 'welcom to manage Page';

    }elseif($action == 'add'){

        echo 'welcom to add Page';

    }elseif($action == 'insert'){

        echo 'welcom to insert Page';

    }elseif($action == 'edit'){

        echo 'welcom to edit Page';
        
    }elseif($action == 'update'){
        
        echo 'welcom to update Page';

    }elseif($action == 'delete'){

        echo 'welcom to update Page';

    }elseif($action == 'activate'){

        echo 'welcom to activate Page';

    }

    
    include $tmp . "footer-inc.php";
}else{
    header('Location: index.php');
    exit();
}