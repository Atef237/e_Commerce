<?php 

    session_start();

    $pageTitle = 'Tags';

    include "inti.php";


?>
    
    <div class="container">

        
       
        <?php 
        if(isset($_GET['name']) ){

            echo " <h1> Show Items By Tags :".  $_GET['name'] . "</h1> ";



           $tags = getTags($_GET['name']);

            foreach(  $tags as $item){

        ?>
            <div class="card mb-4 col-sm-6 " style="max-width: 540px;">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="..." class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                <a href="items.php?itemID=<?php echo $item['itemID'] ?>">
                    <h5 class="card-title"><?php echo $item['name'] ?></h5>
                </a>
                    <p class="card-text"> <?php echo $item['description'] ?> </p>
                    <p class="card-text"><small class="text-muted"><?php echo 'country made: ' . $item['country_made'] ."<br>".$item['price'] . " LE <br> Date Add: " . $item['add_date'] ?></small></p>

                </div>
                </div>
            </div>
            </div>

        <?php } ?>
    

   <?php

}else{
    echo "you didnt specify Name Tags";
}
 include $tmp . 'footer-inc.php'; //استدعاء جزء للفوتر 