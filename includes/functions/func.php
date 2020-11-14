<?php



    function getTags($tag){

        global $con;

        $items = $con->prepare("SELECT * FROM items WHERE tags LIKE '%$tag%' AND approve = 1");

        $items->execute(array($tag));

        $getTags = $items->fetchAll();

        return $getTags;

    }




    function getAll(){
    
        global $con;

        $items = $con->prepare("SELECT * FROM items WHERE approve = 1 ORDER BY itemID DESC");

        $items->execute();

        $Allitems = $items->fetchAll();

        return $Allitems;

    }



    /*
        get latest records function V1.0
        function to get latest items from database [user, items, comments]
        $select = field to select 
        $table = the table to choose from
        $limit = number of records to get
    
    */

    function getcat(){
 
        global $con;

        $cats = $con->prepare("SELECT * FROM categories ORDER BY ID DESC");

        $cats->execute();

        $rows = $cats->fetchAll();

        return $cats; 
   
    
    }



    /*
        get Items function V1.0
        function to get Items from database 
    
    */

    function getItems($where, $value){
 
        global $con;

        $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? ORDER BY itemID DESC");

        $getItems->execute(array($value));

        $items = $getItems->fetchAll();

        return $items; 
        
   
    }



    
    /*
        get AD Items function V1.0
        function to get Items from database 
    
    */

    function getAds($where, $value){
 
        global $con;

        $Ads = $con->prepare("SELECT * FROM items WHERE $where = ? AND approve = 1 ORDER BY itemID DESC");

        $Ads->execute(array($value));

        $Ads = $Ads->fetchAll();

        return $Ads; 
        
   
    }




    function checkuserstatus($user){

        global $con;

        $getItems = $con->prepare("SELECT
                                        userName, regStatus
                                    FROM 
                                        user
                                    WHERE
                                        userName = ?
                                    AND
                                        regStatus = 0 ");

        $getItems->execute(array($user));

        $ststus = $getItems->rowCount();

        return $ststus; 
    }




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
