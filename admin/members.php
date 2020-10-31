<?php
/**
 *Maneg Member Page
 * You Can Add | Edit | Delete Memcers From Here
 */




    session_start();

    include 'inti.php';


    $pageTitle = "members";

    if(isset($_SESSION['userName'])){


        $action = "";



        if(isset($_GET['action'])){

            $action = $_GET['action'];

        }else{
            $action = 'manage';
        }

        $query = "";
        if(isset($_GET['page']) && $_GET['page'] == 'pending'){
            $query = 'AND regStatus = 0'; 
        }

        if($action == 'manage'){
            $stmt = $con->prepare("SELECT * FROM user WHERE groupID != 1  $query ORDER BY userID DESC");
            $stmt ->execute();
            $rows = $stmt->fetchAll();
            if(! empty($rows)){
            ?>
                 <h1 class="text-center">Manage Member</h1>
                <div class="container">
                    <div class="table-responsive">
                       <table class="main-table text-center table table-bordered">
                           <tr>
                               <td> #ID </td>
                               <td> UserName </td>
                               <td> Email </td>
                               <td> Full Name </td>
                               <td> Registerd Date </td>
                               <td> Control </td>
                            </tr>

                                <?php 
                                    foreach($rows as $row){
                                        echo "<tr>";
                                            echo "<td>" . $row['userID'] . "</td>";
                                            echo "<td>" . $row['userName'] . "</td>";
                                            echo "<td>" . $row['email'] . "</td>";
                                            echo "<td>" . $row['fullName'] . "</td>";
                                            echo "<td> ".$row['date']." </td>";
                                            echo '<td> <a href="members.php?action=edit&userID='.$row['userID'] .'"><i class="fas fa-user-edit"></i></a> 
                                                          <a href="members.php?action=delete&userID='. $row['userID'].'"><i class="fas fa-user-times confirm"></i></i></a>';

                                                         if($row['regStatus'] == 0){
                                                          echo '  <a href="members.php?action=activate&userID='. $row['userID'].'"><i class="fas fa-user-check"></i></i></a> </td>';
                                                         }
                                        echo "</tr>";
                                    }
                                ?>
                       </table>
                    </div>
                    <a href='?action=Add' class="btn btn-primary"> Add New Member <i class="fas fa-user-plus"></i> </a>
                </div>

           <?php }else{
               echo "<div class='container'>";
                echo "<div class='alert alert-info'>There's No record to show</div>";
                echo '<a href="?action=Add" class="btn btn-primary"> Add New Member <i class="fas fa-user-plus"></i> </a>';
               echo "</div>";

           } ?>
            <?php
        }elseif($action == 'Add'){?> 
                
                                  <!-- Add New Member -->     

                    <h1 class="text-center">Add New Member</h1>
                        <div class="container">
                            <form class="form-horizontal" action="?action=insert" method="POST"> 
                                <input type="hidden" name="userID" value="<?php echo $userID?>">
                                <!-- start user name field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">userName</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="userName" class="form-control" autocomplete="off"  placeholder = "UserName To Logen Into Shoop"/>
                                    </div>
                                </div>
                                <!-- start user name field-->

                                <!-- start password field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">password</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="password" name="password"  class="form-control" autocomplete="new-password"  placeholder = "Password Must Be Hard & Complex"/>
                                    </div>
                                </div>
                                <!-- start password field-->

                                <!-- start email field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">email</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="email" name="email"  class="form-control"  placeholder = "Email Must Be Valid"/>
                                    </div>
                                </div>
                                <!-- email email field-->

                                <!-- start full name field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">full name</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="fullName"   class="form-control"  placeholder ="Full Name Appear In Your Profile Page"/>
                                    </div>
                                </div>
                                <!-- end full name field-->


                                <!-- start btton field-->
                                <div class = "form-group">
                                    <div class="col-sm-offset-2 col-sm-10 col-md-6">
                                        <input type="submit" value="Add Member" class="btn btn-primary btn-lg"/>
                                    </div>
                                </div>
                                <!-- start full name field-->
                            <form>
                        </div>
                    <?php

        }elseif($action == "insert"){ // insert New Member Page

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo'<h1 class="text-center">Insert Member</h1>';
                echo "<div class='container'>";

                $userName   =   $_POST['userName'];
                $pass       =   $_POST['password'];
                $email      =   $_POST['email'];
                $fullName   =   $_POST['fullName'];

                $shaPass = sha1($_POST['password']);

                $errorArray = array();

                if(strlen($userName ) > 20){
                    $errorArray[] = "userName cant Be more than <strong>20 charactres </strong>";
                }
                if(strlen($userName) < 3){
                    $errorArray[] = "userName cant Be less than <strong>3 charactres </strong>";
                }
                if(empty($userName)){
                    $errorArray[] = " user name cant Be  <strong> empty </strong> ";
                }
                if(empty($pass)){
                    $errorArray[] = " password cant Be  <strong> empty </strong> ";
                }
                if(empty($email)){
                    $errorArray[] = " password cant Be  <strong> empty </strong> ";
                }
                if(empty($fullName)){
                    $errorArray[] = " password cant Be  <strong> empty </strong> ";
                }
                foreach($errorArray as $error){
                    echo"<div class='alert alert-danger'>" . $error . "</div>";
                }

                if(empty($errorArray)){


                    $check = check("userName", "user", $userName);

                    if($check == 1){

                        $Mesg = "<div class='alert alert-danger'> Sorry This User Name Is Exist </div>";

                        redirect($Mesg, 'back');

                    }else{

                        $stmt = $con->prepare("INSERT INTO user(userName, password, email, fullName, date) 
                                                        VALUES(:username, :password, :email, :fullname ,now())");
                        $stmt->execute(array(

                            'username'   => $userName,
                            'password'   => $shaPass,
                            'email'      => $email,
                            'fullname'   => $fullName,
                        ));

                        echo "<div class='container'>";

                            $Mesg = "<div class='alert alert-success'> Record Inserted </div>";

                            redirect($Mesg,'BACK',2);

                        echo"</div>";
                    }
                }
                
            }else{
                
                echo "<div class='container'>";
                    $Mesg = "<div class='alert alert-danger'> Sorry you cant Browse this page Directiy</div>";

                    redirect($Mesg,'', 2);

                echo"</div>";
            }

            echo "</div>";
        }elseif($action == "edit"){ // sheck if action = edit

            if(isset($_GET['userID']) && is_numeric($_GET['userID']) ){  //Ensure that the id is a number and is free of any other tags and symbols
                
                $stmt = $con->prepare("SELECT * FROM user WHERE userID = ? "); // select member by id from table user
                $stmt->execute(array($_GET['userID']));  // pass the id to select statment 
                $row = $stmt->fetch();                   // Converting data to an array inside the variable
                $count = $stmt->rowCount();              // save the count rorw in the variable
                $userID = $_GET['userID'];               // save userID in variable 
                if($stmt->rowCount() > 0){ ?>           <!-- make sure row count bigger thean 0 -->
                
                                       
                    <h1 class="text-center">Edit Member</h1>
                        <div class="container">
                            <form class="form-horizontal" action="?action=update" method="POST"> 
                                <input type="hidden" name="userID" value="<?php echo $userID?>">
                                <!-- start user name field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">userName</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="userName" value="<?php echo $row['userName']?>" class="form-control" autocomplete="off" required = "required"/>
                                    </div>
                                </div>
                                <!-- start user name field-->

                                <!-- start password field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">password</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="hidden" name="oldPassword" value="<?php echo $row['password']?>">
                                        <input type="password" name="newPassword"  class="form-control" autocomplete="new-password"/>
                                    </div>
                                </div>
                                <!-- start password field-->

                                <!-- start email field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">email</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="email" name="email" value="<?php echo $row['email']?>" class="form-control" required = "required"/>
                                    </div>
                                </div>
                                <!-- email email field-->

                                <!-- start full name field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">full name</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="fullName" value="<?php echo $row['fullName']?>"  class="form-control" required = "required"/>
                                    </div>
                                </div>
                                <!-- end full name field-->


                                <!-- start btton field-->
                                <div class = "form-group">
                                    <div class="col-sm-offset-2 col-sm-10 col-md-6">
                                        <input type="submit" value="save" class="btn btn-primary btn-lg"/>
                                    </div>
                                </div>
                                <!-- start full name field-->
                            <form>
                        </div>
                    <?php
                }else{
                    echo "<div class='container'>";
                        $Mesg = "<div class='alert alert-danger'> Theres No Such ID</div>";
                        redirect($Mesg, 3 ); // redirect function
                    echo"</div>";
                }
            }
        }elseif($action == "update"){

            if( $_SERVER['REQUEST_METHOD']== 'POST' ){

                echo'<h1 class="text-center">update Member</h1>';
                echo "<div class='container'>";
                //get variables from the form

                $userID      = $_POST['userID'];
                $userName    = $_POST['userName'];
                $email       = $_POST['email'];
                $fullName    = $_POST['fullName'];


                $pass = "";
                if(empty($_POST['newPassword'])){   

                    $pass = $_POST['oldPassword'];
                }else{
                    $pass = sha1($_POST['newPassword']);
                }

                //validate the form
                $arrayError = array();

                if(strlen($userName) < 3){
                    $arrayError[] = " userName cant Be less than <strong>3 charactres </strong> ";
                }
                if(strlen($userName) > 20){
                    $arrayError[] = " userName cant Be more than <strong>20 charactres </strong>";
                }
                if(empty($userName)){
                    
                    $arrayError[] = " user name cant Be  <strong> empty </strong> ";
                }
                if(empty($email)){

                    $arrayError[] = " email name cant Be <strong> empty </strong> ";
                }
                if(empty($fullName)){
                    $arrayError[] = "full name cant Be <strong> empty </strong>";
                }

                foreach($arrayError as $error){  //loop into error array and echo it 

                    echo"<div class='alert alert-danger'>" . $error . "</div>";
                }

               
                if(empty($arrayError)){  //check if therw’s no erro proceed the update operation 

                    $stmt = $con->prepare("SELECT * FROM user WHERE userNAme = ? AND UserID != ? ");
                    $stmt->execute(array($userName, $userID));

                    $count = $stmt->rowCount();
                    if( $count == 0 ){

                        $stmt = $con->prepare("UPDATE user SET userName = ?, email = ?, fullName = ?, password = ?  WHERE userID = ?");
                        $stmt->execute(array($userName, $email, $fullName, $pass, $userID ));
    
    
                        $Mesg =" <div class ='alert alert-success'>". $stmt->rowCount() ." Record Updated </div> ";    //Echo success messeage
    
                        redirect($Mesg,'back');
                    }else{

                        echo "<div class='container'>";
                            $Mesg = "<div class ='alert alert-danger'>sorry This Memmber is Exist </div>";
                            redirect($Mesg);
                        echo "</div>";

                    }
                  

                }

            }else{
               echo "<div class='container'>";
                    $Mesg = "<div class ='alert alert-danger'>sorry you cant browes this directly </div>";
                    
                    redirect($Mesg);
                echo "</div>";
            }

            echo "</div>";
            
        }elseif($action == 'delete'){

            // delete member page

            if(isset($_GET['userID']) && is_numeric($_GET['userID'])){

                echo'<h1 class="text-center">Delete Member</h1>';
                echo "<div class='container'>";

                $userID = intval($_GET['userID']);

                $check = check("userID", "user", $userID);

                if($check > 0){
                    
                    $stmt = $con->prepare("DELETE FROM user WHERE userID = :UserID");

                    $stmt->bindParam(":UserID", $userID);

                    $stmt->execute();

                    $Mesg = "<div class='alert alert-danger'> delete success </div>" ;

                    redirect($Mesg, 'back');

                    //redirect($Mesg,2,'BACK');

                }else{
                    $Mesg = "<div class='alert alert-danger'> This id is not Exist </div>";\

                    redirect($Mesg);
                }
               
                echo "</div>";

            }
        }elseif($action == 'activate'){
           

            if(isset($_GET['userID']) && is_numeric($_GET['userID'])){

                echo'<h1 class="text-center">Activate Member</h1>';
                echo "<div class='container'>";

                $userID = intval($_GET['userID']);

                $check = check("userID", "user", $userID);

                if($check > 0){
                    
                    $stmt = $con->prepare("UPDATE user SET regStatus = 1 WHERE userID = ?");

                    $stmt->execute(array($userID));

                    $Mesg = "<div class='alert alert-success'> Activate success </div>" ;

                    redirect($Mesg, 'back');

                    //redirect($Mesg,2,'BACK');

                }else{
                    $Mesg = "<div class='alert alert-danger'> This id is not Exist </div>";\

                    redirect($Mesg, 'back');
                }
               
                echo "</div>";

            
            }
           
        }

        include $tmp . "footer-inc.php";
    }else{

        header('Location: index.php');
        exit();
    }