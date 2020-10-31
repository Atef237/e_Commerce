<?php

session_start();

$pageTitle = '';


// items page

if(isset($_SESSION['userName'])){
    
    include 'inti.php';

    if(isset($_GET['action'])){

        $action = $_GET['action'];
    }else{
        $action = 'manage';
    }


    if($action == 'manage'){

        $stmt = $con->prepare("SELECT 
                                    items.*,
                                    categories.Name AS category_name,
                                    user.userName
                                FROM
                                    items
                                INNER JOIN
                                    categories
                                ON
                                    categories.ID = items.catID 
                                INNER JOIN
                                    user
                                ON
                                    user.userID = items.userID
                                ORDER BY
                                     itemID DESC");
        $stmt ->execute();
        $items = $stmt->fetchAll();
        if(! empty($items)){
        ?>
        <h1 class="text-center">Manage Items</h1>
            <div class="container">
                <div class="table-responsive">
                   <table class="main-table text-center table table-bordered">
                       <tr>
                           <td> #ID </td>
                           <td> Name </td>
                           <td> Description </td>
                           <td> Price </td>
                           <td> Addind Date </td>
                           <td> Category </td>
                           <td> userName </td>
                           <td> Control </td>
                        </tr>

                            <?php 
                                foreach($items as $item){
                                    echo "<tr>";
                                        echo "<td>" . $item['itemID'] . "</td>";
                                        echo "<td>" . $item['name'] . "</td>";
                                        echo "<td>" . $item['description'] . "</td>";
                                        echo "<td>" . $item['price'] . "</td>";
                                        echo "<td> ".$item['add_date']." </td>";
                                        echo "<td> ".$item['category_name']." </td>";
                                        echo "<td> ".$item['userName']." </td>";
                                        echo '<td> <a href="items.php?action=edit&itemID='.$item['itemID'] .'" <i class="fas fa-edit"></i></a> 
                                                      <a href="items.php?action=delete&itemID='. $item['itemID'].'"> <i class="fas fa-trash-alt"></i></a>';

                                                      if($item['approve'] == 0){
                                                        echo '  <a href="items.php?action=approve&itemID='. $item['itemID'].'"> <i class="fas fa-check"></i></a> </td>';
                                                       }
                                                   
                                    echo "</tr>";
                                }
                            ?>
                   </table>
                </div>
                <a href='?action=add' class="btn btn-sm btn-primary " > Add New Item <i class="fas fa-tag"></i> </a>
            </div>
        <?php }else{
                    echo "<div class='container'>";
                        echo "<div class='alert alert-info'>There's No Items to show</div>";
                        echo '<a href="?action=add" class="btn btn-sm btn-primary " > Add New Item <i class="fas fa-tag"></i> </a>';

                    echo "</div>";

                    }?>
        <?php

    }elseif($action == 'add'){

        ?> 
                
                                  <!-- Add New item -->     

                    <h1 class="text-center">Add New Category</h1>
                        <div class="container">
                            <form class="form-horizontal" action="?action=insert" method="POST"> 
                                <!-- start name field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Name</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="Name" class="form-control"  placeholder = "Name Of The item"/>
                                    </div>
                                </div>
                                <!-- End name field-->

                                <!-- start Description field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Description</label>
                                    <div class="col-sm-10 col-md-6">
                                        <textarea name="description" class="form-control"  placeholder = "Description Of The item"></textarea>
                                    </div>
                                </div>
                                <!-- End Description field-->



                                <!-- start Price field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Price</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="price" class="form-control" placeholder = "Description Of The item"/>
                                    </div>
                                </div>
                                <!-- End Price field-->

                                

                                <!-- start country field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Country</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="country" class="form-control"  placeholder = "country Of Made"/>
                                    </div>
                                </div>
                                <!-- End country field-->




                                <!-- start status field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Status</label>
                                    <div class="col-sm-10 col-md-6">
                                        <select class="form-control" name="status">
                                            <option value="0">....</option>
                                            <option value="1">New</option>
                                            <option value="2">Like New</option>
                                            <option value="3">Used</option>
                                            <option value="4">Old</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- End status field-->


                                <!-- start member field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Members</label>
                                    <div class="col-sm-10 col-md-6">
                                        <select class="form-control" name="member">
                                            <option value="0">....</option>
                                            <?php
                                                $stmt = $con->prepare("SELECT * FROM user");
                                                $stmt->execute();
                                                $users =$stmt->fetchAll();
                                                foreach($users as $user){
                                                    echo'<option value="'.$user['userID'].'">'.$user['userName'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- End member field-->


                                <!-- start catigory field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">categores</label>
                                    <div class="col-sm-10 col-md-6">
                                        <select class="form-control" name="catigory">
                                            <option value="0">....</option>
                                            <?php
                                                $stmt2 = $con->prepare("SELECT * FROM categories");
                                                $stmt2->execute();
                                                $cats =$stmt2->fetchAll();
                                                foreach($cats as $cat){
                                                    echo'<option value="'.$cat['ID'].'">'.$cat['Name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- End catigory field-->


                                <!-- start btton field-->
                                <div class = "form-group">
                                    <div class="col-sm-offset-2 col-sm-10 col-md-6">
                                        <input type="submit" value="Add item" class="btn btn-primary btn-sm"/>
                                    </div>
                                </div>
                                <!-- start full name field-->
                            <form>
                        </div>
                    <?php


    }elseif($action == 'insert'){

       
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo'<h1 class="text-center">Insert Item</h1>';
            echo "<div class='container'>";

            $Name     =   $_POST['Name'];
            $desc     =   $_POST['description'];
            $price    =   $_POST['price'];
            $country  =   $_POST['country'];
            $status   = $_POST['status'];
            $member   = $_POST['member'];
            $cat   = $_POST['catigory'];

            $errorArray = array();

            if(empty($Name )){
                $errorArray[] = "Name can't Be<strong> empty</strong>";
            }
            if(strlen($desc) < 3){
                $errorArray[] = "Description can't Be<strong> empty</strong>";
            }
            if(empty($price)){
                $errorArray[] = "Price can't Be<strong> empty</strong>";
            }
            if(empty($country)){
                $errorArray[] = "Country Made can't Be<strong> empty</strong>";
            }
            if($status == 0){
                $errorArray[] = "You mast choose the <strong> stuatus</strong>";
            }
            if($member == 0){
                $errorArray[] = "You mast choose the <strong> Member</strong>";
            }
            if($cat == 0){
                $errorArray[] = "You mast choose the <strong> Category</strong>";
            }
            foreach($errorArray as $error){
                echo"<div class='alert alert-danger'>" . $error . "</div>";
            }

            if(empty($errorArray)){


                    $stmt = $con->prepare("INSERT INTO items(name, description, price , add_date,country_made, status, catID, userID ) 
                                                    VALUES(:Name, :description, :price, now(), :country, :status, :catID, :userID) ");
                    $stmt->execute(array(

                        'Name'           => $Name ,
                        'description'    => $desc,
                        'price'          => $price,
                        'country'        => $country,
                        'status'         => $status,
                        'catID'          => $cat,
                        'userID'         => $member,
                        
                    ));

                    echo "<div class='container'>";

                        $Mesg = "<div class='alert alert-success'> Record Inserted </div>";

                        redirect($Mesg ,'back' ,2);

                    echo"</div>";
                
            }
            
        }else{
            
            echo "<div class='container'>";
                $Mesg = "<div class='alert alert-danger'> Sorry you cant Browse this page Directiy</div>";

                redirect($Mesg, 2);
            echo"</div>";
        }

        echo "</div>";

    }elseif($action == 'edit'){

        
        if(isset($_GET['itemID']) && is_numeric($_GET['itemID']) ){  //Ensure that the id is a number and is free of any other tags and symbols
                
            $stmt = $con->prepare("SELECT * FROM items WHERE itemID = ? "); // select member by id from table user
            $stmt->execute(array($_GET['itemID']));  // pass the id to select statment 
            $items = $stmt->fetch();                   // Converting data to an array inside the variable
            $count = $stmt->rowCount();              // save the count rorw in the variable
            $itemID = $_GET['itemID'];               // save userID in variable 
            if($stmt->rowCount() > 0){ ?>           <!-- make sure row count bigger thean 0 -->
            
                    
            <h1 class="text-center">Edit Item</h1>
                <div class="container">
                    <form class="form-horizontal" action="?action=update" method="POST"> 
                    <input type="hidden" name="itemID" value="<?php echo $itemID?>">
                        <!-- start name field-->
                        <div class = "form-group form-group-lg">
                            <label class="col-sm2 control-label">Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" value="<?php echo $items['name']; ?>" name="Name" class="form-control"  placeholder = "Name Of The item"/>
                            </div>
                        </div>
                        <!-- End name field-->

                        <!-- start Description field-->
                        <div class = "form-group form-group-lg">
                            <label class="col-sm2 control-label">Description</label>
                            <div class="col-sm-10 col-md-6">
                                <textarea value="<?php echo $items['description']; ?>" name="description" class="form-control"  placeholder = "Description Of The item"></textarea>
                            </div>
                        </div>
                        <!-- End Description field-->



                        <!-- start Price field-->
                        <div class = "form-group form-group-lg">
                            <label class="col-sm2 control-label">Price</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" value="<?php echo $items['price']; ?>" name="price" class="form-control" placeholder = "Description Of The item"/>
                            </div>
                        </div>
                        <!-- End Price field-->

                        

                        <!-- start country field-->
                        <div class = "form-group form-group-lg">
                            <label class="col-sm2 control-label">Country</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" value="<?php echo $items['country_made']; ?>" name="country" class="form-control"  placeholder = "country Of Made"/>
                            </div>
                        </div>
                        <!-- End country field-->




                        <!-- start status field-->
                        <div class = "form-group form-group-lg">
                            <label class="col-sm2 control-label">Status</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="status">
                                    <option value="1" <?php if($items['status'] == 1) {echo 'selected';} ?> >New</option>
                                    <option value="2" <?php if($items['status'] == 2) {echo 'selected';} ?> >Like New</option>
                                    <option value="3" <?php if($items['status'] == 3) {echo 'selected';} ?> >Used</option>
                                    <option value="4" <?php if($items['status'] == 4) {echo 'selected';} ?> >Old</option>
                                </select>
                            </div>
                        </div>
                        <!-- End status field-->


                        <!-- start member field-->
                        <div class = "form-group form-group-lg">
                            <label class="col-sm2 control-label">Members</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="member">
                                    <?php
                                        $stmt = $con->prepare("SELECT * FROM user");
                                        $stmt->execute();
                                        $users =$stmt->fetchAll();
                                        foreach($users as $user){
                                            echo'<option value="'.$user['userID'].'"';
                                                if($items['userID'] == $user['userID']) {echo 'selected';}
                                                echo">".$user['userName'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End member field-->


                        <!-- start catigory field-->
                        <div class = "form-group form-group-lg">
                            <label class="col-sm2 control-label">categores</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-control" name="catigory">
                                    <?php
                                        $stmt2 = $con->prepare("SELECT * FROM categories");
                                        $stmt2->execute();
                                        $cats =$stmt2->fetchAll();
                                        foreach($cats as $cat){
                                            echo'<option value="'.$cat['ID'].'"';
                                                if($items['catID'] == $cat['ID']){
                                                    echo'selected';
                                                }
                                            echo'>'.$cat['Name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End catigory field-->


                        <!-- start btton field-->
                        <div class = "form-group">
                            <div class="col-sm-offset-2 col-sm-10 col-md-6">
                                <input type="submit" value="Save Item" class="btn btn-primary btn-sm"/>
                            </div>
                        </div>
                        <!-- start full name field-->
                    <form>
                    <?php
                    $stmt = $con->prepare("SELECT 
                                comments.*, user.userName AS member
                            FROM
                                    comments
                            INNER JOIN
                                user 
                            ON 
                                user.userID = comments.userID
                            where itemID = ?");
                            
                            $stmt ->execute(array($itemID));
                            $rows = $stmt->fetchAll();
                            
                                    ?>
                                    <h1 class="text-center">Manage <?php echo"[". $items['name'] ."]" ?> comments</h1>
                                        <div class="container">
                                            <div class="table-responsive">
                                            <table class="main-table text-center table table-bordered">
                                                <tr>
                                                    <td> Comment </td>
                                                    <td> User Name </td>
                                                    <td> Added Date </td>
                                                    <td> Control </td>
                                                    </tr>
                                                    <?php 
                                                    foreach($rows as $row){
                                                        echo "<tr>";
                                                            echo "<td>" . $row['comment'] . "</td>";
                                                            echo "<td>" . $row['member'] . "</td>";
                                                            echo "<td>" . $row['commentDate'] . "</td>";
                                                            echo '<td> <a href="comments.php?action=edit&cID='.$row['cID'] .'"> <i class="fas fa-edit"></i> </a> 
                                                            <a href="comments.php?action=delete&cID='. $row['cID'].'"> <i class="fas fa-trash-alt"></i></i> </a>';

                                                            if($row['status'] == 0){
                                                            echo '  <a href="comments.php?action=approve&cID='. $row['cID'].'"> <i class="fas fa-check"></i> </a> </td>';
                                                            }
                                                                echo "</tr>";
                                                            }
                                                        ?>
                                            </table>
                                            </div>
                                        </div>
                                
                </div>
                <?php
            }else{
                echo "<div class='container'>";
                    $Mesg = "<div class='alert alert-danger'> Theres No Such ID</div>";
                    redirect($Mesg, 3 ); // redirect function
                echo"</div>";
            }
        }else{
            $Mesg = "<div class='alert alert-danger'> this ID not valied </div>";\

            redirect($Mesg,'back');
    }
        
    }elseif($action == 'update'){
        
        
        if( $_SERVER['REQUEST_METHOD']== 'POST' ){

            echo'<h1 class="text-center">update Item</h1>';
            echo "<div class='container'>";
            //get variables from the form

            $itemID    = $_POST['itemID'];
            $Name      = $_POST['Name'];
            $desc      = $_POST['description'];
            $price     = $_POST['price'];
            $country   = $_POST['country'];
            $status    = $_POST['status'];
            $member    = $_POST['member'];
            $cat       = $_POST['catigory'];

            //validate the form
            $errorArray = array();

            if(empty($Name )){
                $errorArray[] = "Name can't Be<strong> empty</strong>";
            }
            if(strlen($desc) < 3){
                $errorArray[] = "Description can't Be<strong> empty</strong>";
            }
            if(empty($price)){
                $errorArray[] = "Price can't Be<strong> empty</strong>";
            }
            if(empty($country)){
                $errorArray[] = "Country Made can't Be<strong> empty</strong>";
            }
            if($status == 0){
                $errorArray[] = "You mast choose the <strong> stuatus</strong>";
            }
            if($member == 0){
                $errorArray[] = "You mast choose the <strong> Member</strong>";
            }
            if($cat == 0){
                $errorArray[] = "You mast choose the <strong> Category</strong>";
            }
            foreach($errorArray as $error){
                echo"<div class='alert alert-danger'>" . $error . "</div>";
            }
           
            if(empty($arrayError)){  //check if therw’s no erro proceed the update operation 

                $stmt = $con->prepare("UPDATE items SET name = ?, description = ?, price = ?, country_made = ?, status = ?, catID = ?, userID = ?  WHERE itemID = ?");
                $stmt->execute(array($Name, $desc, $price, $country, $status, $cat, $member, $itemID ));


                $Mesg =" <div class ='alert alert-success'>". $stmt->rowCount() ." Record Updated </div> ";    //Echo success messeage
                redirect($Mesg,'back');

            }

        }else{
           echo "<div class='container'>";
                $Mesg = "<div class ='alert alert-danger'>sorry you cant browes this directly </div>";
                
                redirect($Mesg);
            echo "</div>";
        }

        echo "</div>";
        

    }elseif($action == 'delete'){

       if(isset($_GET['itemID']) && is_numeric($_GET['itemID'])){

            echo'<h1 class="text-center">Delete Item</h1>';
            echo "<div class='container'>";

            $id = intval($_GET['itemID']);

            $check = check("itemID", "items", $id);

            if($check > 0){
                $stmt = $con->prepare("DELETE FROM items WHERE itemID = ?");

                $stmt->execute(array($id));

                $Mesg = "<div class='alert alert-danger'> delete success </div>" ;

                redirect($Mesg);

            }else{
                $Mesg = "<div class='alert alert-danger'> This id is not Exist </div>";\

                redirect($Mesg);
            }
       }else{
            $Mesg = "<div class='alert alert-danger'> this ID not valied </div>";\

            redirect($Mesg,'back');
    }

    }elseif($action == 'approve'){

        
        if(isset($_GET['itemID']) && is_numeric($_GET['itemID'])){

            echo'<h1 class="text-center">Approve Item</h1>';
            echo "<div class='container'>";

            $itemID = intval($_GET['itemID']);

            $check = check("itemID", "items", $itemID);

            if($check > 0){
                
                $stmt = $con->prepare("UPDATE items SET approve = 1 WHERE itemID = ?");

                $stmt->execute(array($itemID));

                $Mesg = "<div class='alert alert-success'> Activate success </div>" ;

                redirect($Mesg, 'back', 2);


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