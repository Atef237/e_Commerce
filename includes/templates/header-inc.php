<!doctype html>
<html>
    <head>

        <meta charset="utf-8"/>
        
        <title> <?php getTitle() ?>  </title>

       <!-- <link rel="stylesheet" href='<?php //echo $css ;?>bootstrap.min.css'/>-->
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">


        <link rel="stylesheet" href='<?php echo $css ;?>all.min.css'/>

        <link rel="stylesheet" href='<?php echo $css ;?>jquery-ui.css'/>

        <link rel="stylesheet" href='<?php echo $css ;?>jquery.selectBoxIt.css'/>

        <link rel="stylesheet" href='<?php echo $css ;?>custem.css'/>


    </head>
    <body>

    <div class="upper-bar">
      <div class="container">
        <?php
        
          if(isset($_SESSION['member'])){
            echo 'welcome <a href="profile.php">' . $sessionUser.'  <i class="fas fa-user nv"></i></a> ';

            echo ' | <a href="logout.php"> Logout <i class="fas fa-sign-out-alt nv"></i></a> |';

            echo '  <a href="newads.php"> New Ads <i class="fas fa-plus nv"></i></a> |';

            $userStatus = checkuserstatus( $sessionUser);
            if($userStatus == 1){
              echo "--> your ned membership to need activiate by admin";
            }
          }else{
        
        ?>
              <a href="login.php">
                  <span class="pull-right"> Login/Signup </span>
              </a>
            
        <?php }?>
       </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
  <a class="navbar-brand" href="index.php"> Homepage <i class="fas fa-home nv"></i></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#add-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="sr-only">toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>

  <div class="collapse navbar-collapse" id="add-nav">
    <ul class="nav navbar-nav">
      
        <?php
       
            $cats = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY ID DESC");

            $cats->execute();

            $rows = $cats->fetchAll();

            foreach( $rows as $cat){

               echo'<li><a class="nav-link" href="categories.php?pageid='.$cat['ID'].'&name='. str_replace(' ','-',$cat['Name']).'">'. $cat['Name'] . '</a></li>';
              
            }
       
        ?>

    </ul>
  </div>
</nav>