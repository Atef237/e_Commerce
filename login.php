<?php 

        ob_start();

        $pageTitle = "Login";

        session_start();

        if(isset($_SESSION['member'])){
            
            header('location: index.php');
        }

        include 'inti.php';

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(isset($_POST['login'])){

                $userName = $_POST['usernamee'];
                $password = $_POST['password'];
                $passSha  = sha1($password);

                $stmt =$con->prepare("SELECT userID, userName, password FROM user WHERE userName = ? AND password = ?");
                $stmt->execute(array($userName, $passSha));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();

                if( $count > 0){

                    $_SESSION['member'] =   $userName;
                    $_SESSION['userID'] =   $row['userID'];

                    header('Location: index.php');
                    exit();
                }
            }else{

                $formerrors = array();
                
                $imageName = $_FILES['image']['name'];
                $imageSize = $_FILES['image']['size'];
                $imageTmp  = $_FILES['image']['tmp_name'];
                $imageType = $_FILES['image']['type'];

                $alowedExctinction = array("png", "gif", "jpeg", "jpg");

                $extnImage = explode("." , $imageName);

                $extnImage  = strtolower(end($extnImage));

              
                $usernamesignup = $_POST['username'];
                $password1      = $_POST['password1'];
                $password2      = $_POST['password2'];
                $email          = $_POST['email'];

               

                // Filter the username field
                if(isset($usernamesignup)){

                    $filteruser = filter_var($usernamesignup, FILTER_SANITIZE_STRING);

                    if(strlen($filteruser) < 4){
                        $formerrors[] = "username must be larger than 4 characters";
                    }
                    if(! empty($imageName) && ! in_array($extnImage, $alowedExctinction)){
                        $formerrors[] = " This <strong> Extension  </strong> is not allowed";
                    }
                    if( $imageSize > 4194304 ){
                        $errorArray[] = " Image Cant Be Larger Than<strong> 4MB  </strong>";
                    }
                }

                // Test match the two password fields together
                if( isset($password1) && isset($password2) ){

                    if(empty($_POST['password1'])){
                        $formerrors[] = "Sorry password cant be empty";
                    }else{

                        if( sha1($password1) !== sha1($password2) ){

                            $formerrors[] = "Sorry password is not match";
                        }
                    }
                }

                if(isset($email)){

                    $filteremail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

                    if(filter_var($filteremail, FILTER_VALIDATE_EMAIL) != TRUE){
                        $formerrors[] = "THESE EMAIL NOT VALID";
                    }
                }


                if(empty($formerrors)){

                    $check = check('userName', 'user', $usernamesignup);

                    if($check == 1){

                        $formerrors[] = "THIS USERNAME IS EXIST";
                        
                    }else{

                        $newNameImage = rand(0 , 1000000) . "_" . $usernamesignup . "." . $extnImage;

                        move_uploaded_file($imageTmp , "image\user_image\\" . $newNameImage);

                        $stmt = $con->prepare("INSERT INTO user (userName, password, email, regStatus, date, image)
                                                         VALUE(:username, :pass, :email, 0, now(), :image)");
                            
                        $stmt->execute(array(

                            'username'   => $usernamesignup,
                            'pass'       => sha1($password1),
                            'email'      => $email,
                            'image'      =>$newNameImage,

                        ));

                        $succesMsg = "Congrats you are now a registered user";
                    }
                }
             
            }
        }

    ?>


    <div class ="container">
 
        
    <!-- Start Login form -->
        <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" >
            <label>userName</label>
            <input class="form-control" type="text" name="usernamee" autocomplete="off">
            <label>Password</label>
            <input class="form-control" type="password" name="password" autocomplete="new-password">

            <input class="btn btn-primary" name="login" type="submit" value="Login">

        <form>
    <!-- End Login form -->

        <br>
        <br>
        
    <!-- Start signUp form -->

        <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" >
            <label>userName</label>
            <input class="form-control" type="text" name="username" autocomplete="off">
            <label>Password</label>
            <input class="form-control" type="password" name="password1" autocomplete="new-password">
            <label>Password again</label>
            <input class="form-control" type="password" name="password2" autocomplete="new-password">
            <label>Email</label>
            <input class="form-control" type="email" name="email" autocomplete="on">
            <label>Choose Image</label>
            <input type="file" name="image" class="form-control" >
            
            <input class="btn btn-primary" name="signup" type="submit" value="signup">

        <form>
    <!-- End signUp form -->


    <div class="the_error text-center">

        <?php 

            if(! empty($formerrors)){
                foreach( $formerrors as $error){
                    echo $error . '<br>';
                }
            }
            if(isset($succesMsg)){
                echo  '<div class="msg success">' . $succesMsg . '</div>';
            }
        
        ?>
    </div>

    </div>
    <?php
        include $tmp . 'footer-inc.php'; 
        
        ob_end_flush();
    ?>