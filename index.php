<?php
  
    session_start();
    
    $pageTitle = "Home Page";

    include "inti.php";

    foreach( getAll() as $item ){

   ?>


    <div class="card" style="width: 18rem;">
    <?php
        if(! empty($item['image'])){
            echo '<img class="card-img-top" src="image/item_image/'. $item['image'] .'" alt="Card image cap">';
        }else{
            echo '<img class="card-img-top" src="image/item_image/defaultXSjHUKAQXIMlu.jpg" alt="Card image cap">';
        }
    
    ?>
    <div class="card-body">
       <a href="items.php?itemID=<?php echo $item['itemID'] ?>"> <h5 class="card-title"><?php echo $item['name'] ?></h5></a>
        <p class="card-text"><?php echo $item['description'] .'<br><br> add_date: ' . $item['add_date'] ?></p>
        <h5> <?php echo $item['price'] . ".LE" ?> </h5>
    </div>
    </div>



    <?php } include $tmp . 'footer-inc.php'; //استدعاء جزء للفوتر
    