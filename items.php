<?php
    ob_start();
    session_start();
    
    $pageTitle = "Show Items";

    include "inti.php";

   // print_r($_SESSION);
   
    if( isset($_GET['itemID']) && is_numeric($_GET['itemID']) ){

            $ID = intval($_GET['itemID']);

            $stmt = $con->prepare("SELECT 
                                        items.*,
                                        categories.Name as cateNAme,
                                        categories.ID as catID,
                                        user.userName,
                                        user.userID
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
                                    WHERE itemID = ?
                                    AND approve = 1 ");

            $stmt->execute(array($ID));

            $row = $stmt->fetch();

        
        if( $stmt->rowCount() > 0){

            
        ?>
                     <div class="container">
                            <h2 class="text-center"> <?php echo $row['name'] ?> </h2>
            
                            <p class="text-center"> <?php echo $row['description'] ?> </p>
                            <h5 class="text-center"><?php echo 'price: ' . $row['price'] . " LE" ?></h5>
                            <p class="text-center"><?php echo ' Date: ' . $row['add_date'] ?> </p>
                            <p class="text-center"><?php echo ' Added by: ' . $row['userName'] ?> </p>
                            <p class="text-center">category: <a href="categories.php?pageid=<?php echo $row['catID']?>&name= <?php echo $row['cateNAme'] ?>"><?php echo $row['cateNAme'] ?> </a></p>
                            <p class="text-center"> <?php
                                echo "Tags:";

                                 $allTags = explode("," , $row['tags']);
                                 
                                 foreach( $allTags as $tag ){
                                        //$tage = str_replace(' ', '', $tag);
                                        echo "<a href='tags.php?name={$tag}'>". $tag ."</a> | ";
                                 }
                            ?> </p>
                            <hr>
                            <?php if(isset($_SESSION['member'])){ ?>
                                    <!-- Start Add Comment -->
                                
                                <div class="row">
                                    <div class="col-md-offset-3">
                                        <div class="add-comment">
                                            <h3> Add Your Comment </h3>
                                            <form action="<?php echo $_SERVER['PHP_SELF'] .'?itemID='.$row['itemID'] ?>" method="POST">
                                                <textarea name="comment"></textarea>
                                                <input class="btn btn-primary" type="submit" value ="Add Comment"> 
                                            </form>
                                            <?php 
                                                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                                                    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                                                    $userID  = $_SESSION['userID'];
                                                    $itemID  = $row['itemID'];

                                                    if(! empty($comment)){
                                                        $stmt = $con->prepare("INSERT INTO
                                                                                         comments(comment, commentDate	, itemID, userID) 
                                                                                        VALUES(:comment, now(), :itemID, :userID)");
                                                        $stmt->execute(array(
                                                                                'comment' => $comment,
                                                                                'itemID' => $itemID,
                                                                                'userID' => $userID,
                                                                            ));

                                                                            if($stmt){
                                                                                echo '<div class="alert alert-success">Added Comment</div>';
                                                                            }else{
                                                                                echo '<div class="alert alert-success">not success</div>';
                                                                            }

                                                    }else{
                                                        echo '<div class="alert alert-danger">Empty faild</div>';
                                                        header("Refresh:1");
                                                    }

                                                    //echo $_POST['comment'];
                                                    header("Refresh:1");

                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                            <?php
                                
                                }else{
                                    echo 'Login Or Register To Add Comment';
                                }
                                    
                            ?>
                                <hr>
                                
                                    <div class="col-md-9">
                                       <?php
                                            $stmt =$con->prepare("SELECT 
                                                                        comments.*, 
                                                                        user.userName
                                                                    FROM 
                                                                        comments
                                                                    INNER JOIN
                                                                        user
                                                                    ON 
                                                                        user.userID = comments.userID 
                                                                   WHERE 
                                                                        itemID = ?
                                                                    AND
                                                                        status = 1
                                                                    ORDER BY
                                                                        cID DESC ");

                                            $stmt->execute(array($row['itemID']));

                                            $comments = $stmt->fetchAll();

                                            $Count = $stmt->rowCount();
                                            
                                            if( $Count > 0 ){

                                                foreach( $comments as $comment ){

                                                    echo  $comment['userName'] . '<br>';
                                                    echo  $comment['comment']. '<br>';
                                                    echo  $comment['commentDate']. '<br>';
                                                    echo  $comment['userID']. '<br>';
                                                    echo "<hr>";
    
                                                }
                                            }else{
                                                echo "no't Comments";
                                            }
                                            
                                       ?>
                                    </div>
                                </div>
                            </div>
                    
        <?php
  
        }else{

            echo "There is no such id or this item is waiting approval";

        }
    }else{

        echo "There is not valed";
    }

    ?>
    <h1 class="text-center"> </h1>
    
    <?php     
 
    include $tmp . 'footer-inc.php'; //استدعاء جزء للفوتر