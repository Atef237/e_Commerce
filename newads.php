<?php

    session_start();
        
    $pageTitle = "New Ad";

    include "inti.php";
    
    if(isset($_SESSION['member'])){

        $getUser = $con->prepare("SELECT * FROM user WHERE userName = ?");

        $getUser -> execute(array($sessionUser));

        $info = $getUser->fetch();
       
        if(isset($_POST['add'])){

            $fomerrors = array();

            $imageName = $_FILES['image']['name'];
            $imageType = $_FILES['image']['type'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp = $_FILES['image']['tmp_name'];

            $alowedExctinction = array("png", "gif", "jpeg", "jpg");

            $extnImage = explode("." , $imageName);

            $extnImage  = strtolower(end($extnImage));


            $name    = filter_var( $_POST['Name'], FILTER_SANITIZE_STRING);
            $desc    = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            $pric    = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
            $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
            $tags    =filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
            $status  = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
            $catID   = filter_var($_POST['catigory'], FILTER_SANITIZE_NUMBER_INT);
            

          


           if( strlen($name) <4 ){

                $fomerrors[] = "Item Title must be at least 4 characters";

           }
           if( strlen($desc) <20 ){

                $fomerrors[] = "Item Description must be at least 20 characters";

            }
            if( empty($pric) ){

                    $fomerrors[] = "price must be empty";

            }
            if( empty($country) || $country > 2){

                $fomerrors[] = "The country must be of at least two characters";

            }
            if( empty($status) ){

                $fomerrors[] = "status must be empty";

            }
            if( empty($catID) ){

                $fomerrors[] = "catID must be empty";

            }
            if(! empty($imageName) && ! in_array($extnImage, $alowedExctinction)){
                $fomerrors[] = " This <strong> Extension  </strong> is not allowed";
            }
            if( $imageSize > 4194304 ){
                $fomerrors[] = " Image Cant Be Larger Than<strong> 4MB  </strong>";
            }
            
            if( empty($fomerrors) ){

                $newNameItem = rand(0 , 1000000) . "_" . $imageName . "." . $extnImage;

                move_uploaded_file ( $imageTmp, "image\item_image\\" . $newNameItem );

                $stmt = $con->prepare("INSERT INTO items(name, description, price, add_date, country_made, image,tags ,status, catID, userID)
                                                    VALUE(:name, :description, :price, now(), :country_made, :image ,:tags ,:status, :catID, :userID)");
                $stmt->execute(array(
                                        'name'           => $name,
                                        'description'    => $desc,
                                        'price'          => $pric,
                                        'country_made'   => $country,
                                        'image'          => $newNameItem,
                                        'tags'           => $tags,
                                        'status'         => $status,
                                        'catID'          => $catID,
                                        'userID'         => $_SESSION['userID']
                                        

                                    ));

            }
                            
        }
        
    ?>
    <h1 class="text-center">Create New Ad </h1>
    
        <div class="information">
            <div class="container"> 
                <div class="panel panel-primary">
                    <div class="panel-heading"> Create New Item </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data"> 
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


                                        <!-- start tags field-->
                                        <div class = "form-group form-group-lg">
                                            <label class="col-sm2 control-label">tags</label>
                                            <div class="col-sm-10 col-md-6">
                                                <input type="text" name="tags" class="form-control"  placeholder = "Separate Tags With Comma(,)"/>
                                            </div>
                                        </div>
                                        <!-- End tags field-->



                                        <!-- start image field-->
                                        <div class = "form-group form-group-lg">
                                            <label class="col-sm2 control-label">tags</label>
                                            <div class="col-sm-10 col-md-6">
                                                <input type="file" name="image" class="form-control" />
                                            </div>
                                        </div>
                                        <!-- End image field-->


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
                                                <input type="submit" name="add" value="Add item" class="btn btn-primary btn-sm"/>
                                            </div>
                                        </div>
                                        <!-- start full name field-->
                                    <form>


                                    <?php
                                        
                                        if(isset($fomerrors)){
                                            foreach( $fomerrors as $error){

                                                echo $error ."<br>";
                                            }
                                        }
                                        if(isset($stmt)){
                                            echo " Added New items";
                                        }
                                    ?>
                                </div>
                                <div class="col-md-4">
                                    
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        


    <?php     
    }else{
        header('Location: login.php');
        exit();
    }
    include $tmp . 'footer-inc.php'; //استدعاء جزء للفوتر