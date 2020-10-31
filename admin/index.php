<?php
    $noNavbar = "";

    $pageTitle = "Login";

    session_start();

    if(isset($_SESSION['userName'])){
        
        header('location: dashboard.php');
    }

    include "inti.php";
    


    //check if user coming from http post request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $userName   = $_POST['user'];
        $pass       = $_POST['pass'];
        $hashPass   = sha1($pass);
       
        //check if the user exist in database

        $stmt = $con->prepare("SELECT
                                    userID, userName, password
                                FROM
                                    user 
                                WHERE 
                                    userName = ? 
                                AND 
                                    password = ? 
                                AND 
                                    groupID = 1");

        $stmt->execute(array($userName, $hashPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        // if count > 0 this mean the database contain record about this username
        if($count > 0){

            $_SESSION['userName'] = $userName; //register session name
            $_SESSION['userID'] = $row['userID'];  //register session ID
            header('location: dashboard.php'); //redirect to dashbord page
            exit();
        }


    }
?>


    

<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <h4 class="text-center"> Admin Login </h4>
    <input class="form-control " type="text" name="user" placeholder ="UserName" autocomplete="off">
    <input class="form-control " type="password" name="pass" placeholder="Password" autocomplete="new-password">
    <input class="btn btn-primary btn-block" type="submit" value="login">
</form>


<?php include $tmp . 'footer-inc.php'; //استدعاء جزء للفوتر ?>