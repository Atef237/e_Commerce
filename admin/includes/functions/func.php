<?php

//title function that echo the page title in case the page
//hase the variable $pageTitle and default title for 


    function getTitle(){

         $pageTitle = $GLOBALS['pageTitle'];

        if(isset($pageTitle)){

            echo $pageTitle;

        }else{

            echo 'Default';

        }
    }


        /**
         * Hom redirect function V2.0 
         * [this funcion accept parameters]
         * $url = the link you want to redirect to
         * $Mesg = echo the error message [error | success | whernig]
         * $seconds = seconde before redirecting
         */



    function redirect($Mesg, $url = null, $seconds=3){

        if($url == null){

            $url = "index.php";

            $link = "HomePage";

        }else{
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){

                $url = $_SERVER['HTTP_REFERER'] ;  

                $link = "previous Page";

            } else {

                $url = "index.php";

                $link = "HomePage";
            }
        }
            
        echo $Mesg;

        echo "<div class='alert alert-info'> you will Be redirected to $link after $seconds seconds</div>";

        //echo "<div style='background-image: url('../../Delet_page.jpg')'>";

        header("refresh:$seconds;url=$url");

        exit();

    }


    function check($select, $from, $valu){

        global $con;

        $statment = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
        
        $statment->execute(array($valu));

        $count =$statment->rowCount();

        return $count;

    }
    

    /**
     * count number of items function V1.0
     * function to count number of itens rows
     * $item = the item to count
     * $table = the table to choose from
     */

    function countItems($item, $table){
        global $con;
        $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
        $stmt2->execute();
        return $stmt2->fetchColumn();

    }





    /*
        get latest records function V1.0
        function to get latest items from database [user, items, comments]
        $select = field to select 
        $table = the table to choose from
        $limit = number of records to get
    
    */

    function getLatest($select, $table, $order, $limit = 5){
 
            global $con;

            $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    
            $getStmt->execute();
    
            $rows = $getStmt->fetchAll();
    
            return $rows; 
       
        
    }
