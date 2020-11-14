<?php
  
    session_start();
    
    $pageTitle = "Profile";

    

    include "inti.php";
    if(isset($_SESSION['member'])){

        $getUser = $con->prepare("SELECT * FROM user WHERE userName = ?");

        $getUser -> execute(array($sessionUser));

        $info = $getUser->fetch();
        
    ?>
    <h1 class="text-center">My Profile </h1>
    
        <div class="information">
            <div class="container"> 
                <div class="panel panel-primary">
                    <div class="panel-heading"> Main Information </div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li> <span> <i class="fas fa-unlock nv"></i>  Login Name:<?php echo $info['userName'] ?> </span></li>
                                <li> <span> <i class="fas fa-envelope nv"></i> Email:<?php echo $info['email'] ?> </span></li>
                                <li> <span> <i class="fas fa-user nv"></i> Full Name:<?php echo $info['fullName'] ?> </span></li>
                                <li> <span> <i class="fas fa-calendar-alt nv"></i> Registered Date:<?php echo $info['date'] ?></span> </li>
                                <li> <span> <i class="fas fa-star nv"></i> Fav Category:  </span></li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>

        <div class="my-Ads">
            <div class="container"> 
                <div class="panel panel-primary">
                    <div class="panel-heading"> My Ads </div>
                        <div class="panel-body">
                            <?php

                                $rows = getItems('userID', $info['userID']);
                                if(! empty($rows)){
                                    foreach($rows as $row){

                            ?>
                                    
                                        <div class="card mb-4 col-sm-6 " style="max-width: 540px;">
                                            <div class="row no-gutters">
                                                <div class="col-md-4">
                                                    <img src="..." class="card-img" alt="...">
                                                </div>
                                                <div class="col-md-8">
                                                <div class="card-body">
                                                <a href="items.php?itemID=<?php echo $row['itemID'] ?>">
                                                    <h3 class="card-title"><?php echo $row['name'] ?></h3>
                                                </a>
                                                    <?php if( $row['approve'] == 0 ){echo 'Not enabled';} ?>
                                                    <p class="card-text"> <?php echo $row['description'] ?> </p>
                                                    <h5><?php echo 'price: ' . $row['price'] . " LE" ?></h5>
                                                    <p><?php echo ' Date: ' . $row['add_date'] . " LE" ?></p>

                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                         
                                <?php
                                        }
                                    }else{
                                        echo "Sorry there'no ads to show cared <a href='newads.php'> New Ads </a>";
                                    }
                                    
                                ?>
                                
                         </div>
                </div>
            </div>
        </div>

        <div class="my-comments">
            <div class="container"> 
                <div class="panel panel-primary">
                    <div class="panel-heading"> Latest Comments </div>
                        <div class="panel-body">

                        <?php
                            $stmt = $con->prepare("SELECT * FROM comments where userID = ?");
                            
                            $stmt ->execute(array($info['userID']));
                            $comments = $stmt->fetchAll();
                            if(! empty($comments)){
                                
                                foreach( $comments as $comment){
                                    echo $comment['comment'] . "<br>";
                                    echo $comment['commentDate'];
                                }
                            }else{
                                echo "there's no comments to show";
                                
                            }
                            
                        ?>
                       
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