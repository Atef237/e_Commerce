<?php

  session_start();

  if(isset($_SESSION['userName'])){

      $pageTitle = 'Dashboard';

      include 'inti.php';

        // start cashpord page

        //Number of Latest Users

        $LatestUsers =getLatest('*', 'user', 'userID'); // Latest Users Array 

        

        $latestItems = getLatest('*', 'items', 'itemID');  // Latest Items Array 
        

        

        $latestcomments = getLatest('*', 'comments', 'cID');
        
?>

    
     <div class="container hom-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
              <div class="stat st-members">
                Toatal Membars  
                <span class="dash"><a href="members.php"><?php echo countItems('userID', 'user') ?></a></span>
              </div>
            </div>

            <div class="col-md-3">
              <div class="stat st-pending"> 
                Pending Membars 
                <span class="dash"><a href="members.php?action=manage&page=pending">
                  <?php echo  check('regStatus', 'user','0');?>
                </a></span>
              </div>
            </div>

            <div class="col-md-3">
              <div class="stat st-items"> 
                Toatal Items 
              
                <span class="dash"><a href="items.php?action=manage">
                  <?php echo countItems('itemID', 'items');?>
                </a></span>

              </div>
            </div>

            <div class="col-md-3">
              <div class="stat st-comments"> 
                Toatal Comments 
                <span class="dash"><a href="comments.php">
                  <?php echo countItems('cID', 'comments');?>
                </a></span>
              </div>
            </div>
        </div>
    </div>

    <div class="container latest">
      
    <ul class="list-group dash col-md-12">
          <li class="list-group-item active"> <i class="fas fa-users">  Latest Registerd Users</i> 
          <?php
            if(! empty($LatestUsers)){
              foreach($LatestUsers as $lateUser){

                echo '<li class="list-group-item">'.$lateUser['userName'].'<a href="members.php?action=edit&userID='.$lateUser['userID'] .'"><i class="fas fa-user-edit"></i></a> 
                <a href="members.php?action=delete&userID='.$lateUser['userID'].'"><i class="fas fa-user-times confirm"></i></i></a>';
                if($lateUser['regStatus'] == 0){
                  echo ' <a href="members.php?action=activate&userID='. $lateUser['userID'].'"><i class="fas fa-user-check"></i></i></a> </li>';
                 }
              }
            
            }else{
              echo "<li>There\'s No Record To Show</li>";
            }
          ?>
        </ul>


        <ul class="list-group dash col-md-12">
          <li class="list-group-item active"><i class="fas fa-tags">  Latest Items</i>
          <?php
            if(! empty($latestItems)){
              foreach($latestItems as $lateItems){

                echo '<li class="list-group-item">'.$lateItems['name'].'<a href="items.php?action=edit&itemID='.$lateItems['itemID'] .'"> <i class="fas fa-edit"></i></a> 
                <a href="items.php?action=delete&itemID='.$lateItems['itemID'].'"> <i class="fas fa-trash-alt"></i></i></a>';
                if($lateItems['approve'] == 0){
                  echo ' <a href="items.php?action=approve&itemID='. $lateItems['itemID'].'"><i class="fas fa-check"></i></a> </li>';
                 }
              }
            }else{
              echo "<li>There\'s No Record To Show </li>";
             
            }
          
          ?>
        </ul>




        <ul class="list-group dash col-md-12">
          <li class="list-group-item active"><i class="fas fa-comment-dots"> Latest Comments</i>
          <?php
            
           
              $stmt = $con->prepare("SELECT 
                                        comments.*, user.userName AS member
                                    FROM
                                         comments
                                    INNER JOIN
                                        user 
                                    ON 
                                        user.userID = comments.userID");
            $stmt ->execute();
            $comments = $stmt->fetchAll();
      
            foreach($comments as $comment){
              
                echo '<li class="list-group-item"> '. $comment["member"] .' <br>'.$comment["comment"] . 
                ' <a href="comments.php?action=delete&cID='.$comment['cID'] .'"><i class="fas fa-trash"></i></a>'.
                 ' <a href="comments.php?action=edit&cID='.
                   $comment['cID'] .'"><i class="fas fa-edit"></i></a> ';
                
                

                
                if($comment['status'] == 0){
                  echo ' <a href="comments.php?action=approve&cID='. $comment['cID'] .'"><i class="fas fa-check"></i></a> </li>';
                } 
            }
            
          ?>
        </ul>

      </div>
      
  <?php      

      include $tmp . 'footer-inc.php';

  }else{

        header('location: index.php');
        
        exit();
  }