<?php

/**
 * Category Page
 */

session_start();

$pageTitle = 'Category';

if(isset($_SESSION['userName'])){
    
    include 'inti.php';

    if(isset($_GET['action'])){

        $action = $_GET['action'];
    }else{
        $action = 'manage';
    }


    if($action == 'manage'){

        $sort_array = array('ASC','DESC');

        $sort = 'ASC';

        if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
            
            $sort = $_GET['sort'];

        }
     
        $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");

        $stmt2->execute();

        $cats = $stmt2->fetchAll();
        if(! empty($cats)){
        ?>

            <h1 class="text-center"> Manage categories</h1>
                <ul class="list-group col-md-12">
                    <li class="list-group-item active"> Manage Categories 

                        <div class = "ordering">
                        ordering 
                            <a class="<?php if($sort == 'ASC'){echo'active';}?>" href="?sort=ASC">ASC</a> | 
                            <a class="<?php if($sort == 'DESC'){echo'active';}?>" href="?sort=DESC">DESC</a>
                        </div>

                    </li>
                    <?php
                        foreach($cats as $cat){
                            echo '<li class="list-group-item">';
                                echo '<div class="control">';
                                    echo '<a href ="categories.php?action=delete&catID='.$cat['ID'].'"> <i class="fas fa-trash-alt"></i> </a> ';
                                    echo ' <a href ="categories.php?action=edit&catID='.$cat['ID'].'"> <i class="fas fa-edit"></i> </a>';
                                echo '</div>';
                                echo '<h3>' . $cat['Name'] . '</h3>';
                                echo '<p>';  if($cat['Description'] == ''){echo 'This category has no description';}else{echo $cat['Description'];}  echo'</p>';
                                if($cat['Visibility'] == 1){echo '<span class = "Visibility"> Hidden </span>' ;}
                                if($cat['Allow_comment'] == 1){echo '<span class = "comment"> Comment Disabled </span>' ;}
                                echo '<span class = "Ads"> Allow_Ads Is' . $cat['Allow_Ads'] . '</span>';
                                echo '</div>';
                            echo'</li>';
                        }
                    ?>
                    <a class="btn btn-primary" href="categories.php?action=add"> Add New Category <i class="fas fa-plus"></i></a>
                </ul>

        <?php }else{
                    echo "<div class='container'>";
                        echo "<div class='alert alert-info'>There's No category to show</div>";
                        echo'<a class="btn btn-primary" href="categories.php?action=add"> Add New Category <i class="fas fa-plus"></i></a>';
                    echo "</div>";

                    }?>
<?php
    }elseif($action == 'add'){

        ?> 
                
                                  <!-- Add New Category -->     

                    <h1 class="text-center">Add New Category</h1>
                        <div class="container">
                            <form class="form-horizontal" action="?action=insert" method="POST"> 
                                <!-- start name field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Name</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="Name" class="form-control" autocomplete="off"   placeholder = "Name Of The Category"/>
                                    </div>
                                </div>
                                <!-- start name field-->

                                <!-- start Description field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Description</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="description"  class="form-control" autocomplete="new-password"  placeholder = "Describe The Category"/>
                                    </div>
                                </div>
                                <!-- start Description field-->

                                <!-- start Ordering field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Ordering</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="ordering"  class="form-control"  placeholder = "Number To Arrange The Categories"/>
                                    </div>
                                </div>
                                <!-- end Ordering field-->

                                <!-- start Visible field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Visible</label>
                                    <div class="col-sm-10 col-md-6">
                                        <div> 
                                            <input id="vis-yes" type = "radio" name = "visibility" value = "0" checked>
                                            <label for="vis-yes">Yes</label>
                                         </div>

                                         <div> 
                                            <input id="vis-no" type = "radio" name = "visibility" value = "1" checkdate>
                                            <label for="vis-no">No</label>
                                         </div>
                                    </div>
                                </div>
                                <!-- end Visible field-->

                                <!-- start Commention field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Allow Commention</label>
                                    <div class="col-sm-10 col-md-6">
                                        <div> 
                                            <input id="com-yes" type = "radio" name = "Commention" value = "0" checked>
                                            <label for="com-yes">Yes</label>
                                         </div>

                                         <div> 
                                            <input id="com-no" type = "radio" name = "Commention" value = "1" checkdate>
                                            <label for="com-no">No</label>
                                         </div>
                                    </div>
                                </div>
                                <!-- end Commention field-->


                                <!-- start Ads field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Allow Ads</label>
                                    <div class="col-sm-10 col-md-6">
                                        <div> 
                                            <input id="ads-yes" type = "radio" name = "ads" value = "0" checked>
                                            <label for="ads-yes">Yes</label>
                                         </div>

                                         <div> 
                                            <input id="ads-no" type = "radio" name = "ads" value = "1" checkdate>
                                            <label for="ads-no">No</label>
                                         </div>
                                    </div>
                                </div>
                                <!-- end Visible field-->


                                <!-- start btton field-->
                                <div class = "form-group">
                                    <div class="col-sm-offset-2 col-sm-10 col-md-6">
                                        <input type="submit" value="Add Category" class="btn btn-primary btn-lg"/>
                                    </div>
                                </div>
                                <!-- start full name field-->
                            <form>
                        </div>
                    <?php

    }elseif($action == 'insert'){

        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo'<h1 class="text-center">Insert Category</h1>';
            echo "<div class='container'>";

            $Name         =   $_POST['Name'];
            $desc         =   $_POST['description'];
            $order        =   $_POST['ordering'];
            $visibil      =   $_POST['visibility'];
            $Comment      =   $_POST['Commention'];
            $ads          =   $_POST['ads'];

            // Check if category exist in database
            if(empty($Name)){

                echo "<div class='container'>";

                $Mesg = "<div class='alert alert-danger'> Sorry The Record Anam Requierd </div>";

                redirect($Mesg,'BACK',2);

            echo"</div>";
            }else{
                $check = check("Name", "categories", $Name);

                if($check == 1){

                    $Mesg = "<div class='alert alert-danger'> Sorry This categorie Is Exist </div>";

                    redirect($Mesg, 'back');

                }else{

                    $stmt = $con->prepare("INSERT INTO categories(Name, Description, Ordering, Visibility, Allow_comment, Allow_Ads) 
                                                    VALUES(:name, :desc, :order, :visibil ,:Comment ,:ads)");
                    $stmt->execute(array(

                        'name'       => $Name,
                        'desc'       => $desc,
                        'order'      => $order,
                        'visibil'    => $visibil,
                        'Comment'    => $Comment,
                        'ads'        => $ads
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

                redirect($Mesg,'back', 3);
            echo"</div>";
        }

        echo "</div>";

        
    }elseif($action == 'edit'){

        //check if get request catid is numeric & get its integer value

        if(isset($_GET['catID']) && is_numeric($_GET['catID']) ){  //Ensure that the id is a number and is free of any other tags and symbols
                
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? "); // select member by id from table user
            $stmt->execute(array($_GET['catID']));  // pass the id to select statment 
            $cat = $stmt->fetch();                   // Converting data to an array inside the variable
            $count = $stmt->rowCount();              // save the count rorw in the variable
            $catID = $_GET['catID'];               // save catID in variable 
            if($stmt->rowCount() > 0){ ?>           <!-- make sure row count bigger thean 0 -->
            
            <h1 class="text-center">Edit Category</h1>
                        <div class="container">
                            <form class="form-horizontal" action="?action=update" method="POST"> 
                            <input type="hidden" name="catID" value="<?php echo $catID ?>">

                                <!-- start name field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Name</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="Name" class="form-control" value="<?php echo $cat['Name'] ?>"   placeholder = "Name Of The Category"/>
                                    </div>
                                </div>
                                <!-- start name field-->

                                <!-- start Description field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Description</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="description"  class="form-control"  value="<?php echo $cat['Description'] ?>"  placeholder = "Describe The Category"/>
                                    </div>
                                </div>
                                <!-- start Description field-->

                                <!-- start Ordering field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Ordering</label>
                                    <div class="col-sm-10 col-md-6">
                                        <input type="text" name="ordering"  class="form-control" value="<?php echo $cat['Ordering'] ?>"   placeholder = "Number To Arrange The Categories"/>
                                    </div>
                                </div>
                                <!-- end Ordering field-->

                                <!-- start Visible field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Visible</label>
                                    <div class="col-sm-10 col-md-6">
                                        <div> 
                                            <input id="vis-yes" type = "radio" name = "visibility" value = "0" <?php if($cat['Visibility'] == 0){echo 'checked'; }?> >
                                            <label for="vis-yes">Yes</label>
                                         </div>

                                         <div> 
                                            <input id="vis-no" type = "radio" name = "visibility" value = "1" <?php if($cat['Visibility'] == 1){echo 'checked'; }?> >
                                            <label for="vis-no">No</label>
                                         </div>
                                    </div>
                                </div>
                                <!-- end Visible field-->

                                <!-- start Commention field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Allow Commention</label>
                                    <div class="col-sm-10 col-md-6">
                                        <div> 
                                            <input id="com-yes" type = "radio" name = "Commention" value = "0" <?php if($cat['Allow_comment'] == 0){echo 'checked'; }?> >
                                            <label for="com-yes">Yes</label>
                                         </div>

                                         <div> 
                                            <input id="com-no" type = "radio" name = "Commention" value = "1"  <?php if($cat['Allow_comment'] == 1){echo 'checked'; }?>>
                                            <label for="com-no">No</label>
                                         </div>
                                    </div>
                                </div>
                                <!-- end Commention field-->


                                <!-- start Ads field-->
                                <div class = "form-group form-group-lg">
                                    <label class="col-sm2 control-label">Allow Ads</label>
                                    <div class="col-sm-10 col-md-6">
                                        <div> 
                                            <input id="ads-yes" type = "radio" name = "ads" value = "0" <?php if($cat['Allow_Ads'] == 0){echo 'checked'; }?> >
                                            <label for="ads-yes">Yes</label>
                                         </div>

                                         <div> 
                                            <input id="ads-no" type = "radio" name = "ads" value = "1" <?php if($cat['Allow_Ads'] == 1){echo 'checked'; }?> >
                                            <label for="ads-no">No</label>
                                         </div>
                                    </div>
                                </div>
                                <!-- end Visible field-->


                                <!-- start btton field-->
                                <div class = "form-group">
                                    <div class="col-sm-offset-2 col-sm-10 col-md-6">
                                        <input type="submit" value="Update Category" class="btn btn-primary btn-lg"/>
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
        
    }elseif($action == 'update'){
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            echo'<h1 class="text-center">update category </h1>';
            echo "<div class='container'>";

            $catID       = $_POST['catID'];
            $name        = $_POST['Name'];
            $disc        = $_POST['description'];
            $order       = $_POST['ordering'];
            $Visibility  = $_POST['visibility'];
            $comment     = $_POST['Commention'];
            $Ads         = $_POST['ads'];

            
            $stmt = $con->prepare("UPDATE categories SET Name = ?, 	Description = ?, Ordering = ?, Visibility = ?, 	Allow_comment = ?, 	Allow_Ads = ? WHERE ID = ?");
            $stmt->execute(array($name, $disc, $order, $Visibility, $comment, $Ads, $catID));

            $Mesg =" <div class ='alert alert-success'>". $stmt->rowCount() ." categorie Updated </div> ";    //Echo success messeage

            redirect($Mesg,'back');
            
        }else{
            echo "<div class='container'>";
                $Mesg = "<div class ='alert alert-danger'>sorry you cant browes this directly </div>";
                
                redirect($Mesg);
            echo "</div>";
        }

     echo "</div>";

    }elseif($action == 'delete'){

        if(isset($_GET['catID']) && is_numeric($_GET['catID'])){

            echo'<h1 class="text-center">Delete category </h1>';
            echo "<div class='container'>";

            $catID = intval($_GET['catID']);

            $check = check("ID", "categories", $catID);

            if($check > 0){
                
                $stmt = $con->prepare("DELETE FROM categories WHERE ID = :catID");

                $stmt->bindParam("catID",$catID);

                $stmt->execute();

                $Mesg = "<div class='alert alert-danger'> delete success </div>" ;

                redirect($Mesg, 'back');

                //redirect($Mesg,2,'BACK');

            }else{
                $Mesg = "<div class='alert alert-danger'> This id is not Exist </div>";

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