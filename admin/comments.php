<?php
/**
 *Maneg comments Page
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

        if($action == 'manage'){
            $stmt = $con->prepare("SELECT 
                                        comments.*,
                                        items.name AS item_name,
                                        user.userName AS member
                                    FROM
                                        comments
                                    INNER JOIN
                                        items
                                    ON 
                                        items.itemID = comments.itemID
                                    INNER JOIN
                                        user 
                                    ON 
                                        user.userID = comments.userID
                                    ORDER BY
                                       cID desc");
            $stmt ->execute();
            $comments = $stmt->fetchAll();
            if(! empty($comments)){
            ?>
                <h1 class="text-center">Manage comments</h1>
                    <div class="container">
                        <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                <td> Comment </td>
                                <td> Item Name </td>
                                <td> User Name </td>
                                <td> Added Date </td>
                                <td> Control </td>
                                </tr>

                                    <?php 
                                        foreach($comments as $comment){
                                            echo "<tr>";
                                                echo "<td>" . $comment['comment'] . "</td>";
                                                echo "<td>" . $comment['item_name'] . "</td>";
                                                echo "<td>" . $comment['member'] . "</td>";
                                                echo "<td>" . $comment['commentDate'] . "</td>";
                                                echo '<td> <a href="comments.php?action=edit&cID='. $comment['cID'].'"> <i class="fas fa-edit"></i> </a> 
                                                            <a href="comments.php?action=delete&cID='. $comment['cID'].'"> <i class="fas fa-trash-alt"></i></i> </a>';

                                                            if($comment['status'] == 0){
                                                            echo '  <a href="comments.php?action=approve&cID='. $comment['cID'].'"> <i class="fas fa-check"></i> </a> </td>';
                                                            }
                                            echo "</tr>";
                                        }
                                    ?>
                       </table>
                    </div>
                   
                </div>
            <?php }else{
                        echo "<div class='container'>";
                            echo "<div class='alert alert-info'>There's No comments to show</div>";
                        echo "</div>";

                        } ?>
            <?php
        }elseif($action == "edit"){ // sheck if action = edit

            if(isset($_GET['cID']) && is_numeric($_GET['cID']) ){  //Ensure that the id is a number and is free of any other tags and symbols
                
                $stmt = $con->prepare("SELECT * FROM comments WHERE cID = ? "); // select member by id from table user
                $stmt->execute(array($_GET['cID']));  // pass the id to select statment 
                $row = $stmt->fetch();                   // Converting data to an array inside the variable
                $count = $stmt->rowCount();              // save the count rorw in the variable
                $cID = $_GET['cID'];               // save cID in variable 
                if($stmt->rowCount() > 0){ ?>           <!-- make sure row count bigger thean 0 -->
                
                                       
                    <h1 class="text-center">Edit Comment</h1>
                        <div class="container">
                            <form class="form-horizontal" action="?action=update" method="POST"> 
                                <input type="hidden" name="cID" value="<?php echo $cID ?>">
                                <!-- start user name field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Comment</label>
                                    <div class="col-sm-10 col-md-6">
                                        <textarea name="comment" class="form-control"><?php echo $row['comment']?></textarea>
                                    </div>
                                </div>
                                <!-- start user name field-->

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
                        redirect($Mesg,'comments.php', 3 ); // redirect function
                    echo"</div>";
                }
            }
        }elseif($action == "update"){

            if( $_SERVER['REQUEST_METHOD']== 'POST' ){

                echo'<h1 class="text-center">update Comment</h1>';
                echo "<div class='container'>";

                //get variables from the form
                
                $cID       = $_POST['cID'];
                $comment   = $_POST['comment'];

                $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE cID = ?");
                $stmt->execute(array($comment, $cID));
                
                $Mesg =" <div class ='alert alert-success'>". $stmt->rowCount() ." Record Updated </div> ";    //Echo success messeage
                redirect($Mesg,'comments.php', 2);

            }else{
               echo "<div class='container'>";

                    $Mesg = "<div class ='alert alert-danger'>sorry you cant browes this directly </div>";
                    redirect($Mesg);

                echo "</div>";
            }

            echo "</div>";
            
        }elseif($action == 'delete'){

            // delete member page

            if(isset($_GET['cID']) && is_numeric($_GET['cID'])){

                echo'<h1 class="text-center">Delete Comment</h1>';
                echo "<div class='container'>";

                $cID = intval($_GET['cID']);

                $check = check("cID", "comments", $cID);

                if($check > 0){
                    
                    $stmt = $con->prepare("DELETE FROM comments WHERE cID = :cID");

                    $stmt->bindParam(":cID", $cID);

                    $stmt->execute();

                    $Mesg = "<div class='alert alert-danger'> delete success </div>" ;

                    redirect($Mesg,'back');

                    //redirect($Mesg,2,'BACK');

                }else{
                    $Mesg = "<div class='alert alert-danger'> This id is not Exist </div>";\

                    redirect($Mesg);
                }
               
                echo "</div>";

            }
        }elseif($action == 'approve'){
           

            if(isset($_GET['cID']) && is_numeric($_GET['cID'])){

                echo'<h1 class="text-center">Activate Member</h1>';
                echo "<div class='container'>";

                $cID = intval($_GET['cID']);

                $check = check("cID", "comments", $cID);

                if($check > 0){
                    
                    $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE cID = :cID");

                    $stmt->bindParam(":cID", $cID);

                    $stmt->execute();
                    

                    $Mesg = "<div class='alert alert-success'>". $stmt->rowCount() ." Record Approved </div>" ;

                    redirect($Mesg);

                    //redirect($Mesg,2,'BACK');

                }else{
                    $Mesg = "<div class='alert alert-danger'> This id is not Exist </div>";\

                    redirect($Mesg);
                }
               
                echo "</div>";

            
            }
           
        }

        include $tmp . "footer-inc.php";
    }else{

        header('Location: index.php');
        exit();
    }