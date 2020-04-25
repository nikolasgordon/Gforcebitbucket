<?php
require './includes/library.php';
$pdo = connectDB();
session_start();
if(!isset($_SESSION['username'])){     
  header("Location:loginPage.php"); 
  exit();  
}
$username = $_SESSION['username'];
/* $errors starts as an empty array */
$errors = [];
//unfortunately dont have the patience to fix when username changes, simply adding the userid would prevent this problem
$query1 = "SELECT * FROM `wholelist` WHERE username = ?";
$statement1 = $pdo->prepare($query1);
$statement1->execute([$username]);
$results = $statement1->fetchAll();


if(isset($_POST['listsubmit'])){
  $textadd = $_POST['actualadd'] ?? NULL;
    
  if(isset($_POST['actualadd'])){
    $query = "INSERT INTO `wholelist` (username, listitem, access) VALUES (?,?,?)";
    $statement = $pdo->prepare($query);
    $statement->execute([$username, $textadd, 1]);
    header("location:myList.php");
    exit();

  }
}

if(isset($_POST['despSubmit'])){
  $despadd = $_POST['actualDesp'] ?? NULL;
    
  if(isset($_POST['actualDesp'])){
    $query = "INSERT INTO `despandpicture` (desp, username) VALUES (?,?)";
    $statement = $pdo->prepare($query);
    $statement->execute([$despadd,$username]);
    header("location:myList.php");
    exit();

  }
}

if(isset($_POST['accessOptions'])){
  $accessadd = $_POST['accessOptionsChoice'] ?? NULL;
    
  if(isset($_POST['accessOptionsChoice'])){
    $query = "UPDATE `wholelist` SET access = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$accessadd]);
    header("location:myList.php");
    exit();

  }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!--meta data goes here-->  
    <title>GForce bucket</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">    
      <link rel="stylesheet" href="css/main.css">    
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
      <script src="https://kit.fontawesome.com/a076d05399.js"></script>
      <script defer src="scripts/logout.js"></script>
      <script defer src="scripts/myList.js"></script>
  </head>
  
        <ul class="navigation">
            <li id="space"> <a href="myList.php"><i class="fas fa-fill" id="font" style="font-size:20px;color:white"></i></a></li>     <!--Is this allowed?-->
            <li class ="toTheLeft" id="space">GForce-bucketList</li>
            <li class="toTheRight">
              <div class="search-container">
                <form action="search.php" method="POST"> <!--Could be a javascript in stead or something idk-->
                  <input type="text" placeholder="Search.." name="searchbar"/>
                  <button type="submit" name="luckySearch"><i class="fa fa-search"></i> feeling lucky</button>
                  <button type="submit" name="actualSearch"><i class="fa fa-search"></i></button>
                </form>
              </div>
          </li>
          <li><a href="main.php">Public Lists</a></li>
            <li><a href="myList.php">My List</a></li>
            <li><a href="myAccount.php">My Account</a></li>
            <li><a id="logout">Log Out</a></li>

        </ul>
    <body>
      <div class="mainBody">
      <div class="myList">
        <h2>My List</h2>
        <div class="navList">
          <button type="submit" id="addtolist" title="add to list"><i class="fa fa-plus" ></i></button>
          <button type="submit" id="addpicture" title="add picture"><i class="fa fa-camera" ></i></button>
          <button type="submit" id="share" title="Add/edit description"><i class="fa fa-share"></i></button>
          <button type="submit" id="removelist" title="remove list"><i class="fa fa-minus" ></i></button>
          <button type="submit" id="access" title="access"><i class="fa fa-globe" ></i></button>
          <button type="submit" id="descript" title="description and photo"><i class="fa fa-question" ></i></button>
        </div>
          <!--put array of items here-->
          <div class="listitems">
          <ul id="myListItems">
            <?php foreach ($results as $row): ?>
              <li>
                <p><?= $row['listitem']?></p> 
                <input type="checkbox" class="disbut" value ="Complete Task">
                <a class="disbut" href="phpscripts/editmy.php?id=<?=$row["id"]?>" >Edit Entry</a>
                <a class="disbut" href="phpscripts/deletemy.php?id=<?=$row["id"]?>">Delete Entry</a>
                <a class="disbut" href="phpscripts/publicitem.php?id=<?=$row["id"]?>">make public</a>
                <a class="disbut" href="phpscripts/privateitem.php?id=<?=$row["id"]?>">make private</a>
                <p><?php if($row['access'] == 1){echo "public"; }else{echo "private";}?></p>
              </li>
            <?php endforeach; ?>
          </ul>
          </div>
          
          <!--modul stufff-->
          <!--very easy to loose track of ids-->
          <form action ="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
          <div class="modal" id="modaladd">
            <div class="modal-content">
              <span class="close-button" >×</span>
              <p>Please enter the item you want to add to the list</p>
              <textarea type="text" name="actualadd"></textarea>
              <button type ="submit" id="listsubmit" name="listsubmit" >Add to list</button>
            </div>
          </div>
          
          <!--very easy to loose track of ids-->
          <div class="modal" id="modalpic">
            <div class="modal-content">
              <span class="close-button" >×</span>
              <p>Add picture</p>
              
              
            </div>
          </div>

          <!--very easy to loose track of ids-->
          <div class="modal" id="modalDesp">
            <div class="modal-content">
              <span class="close-button" >×</span>
              <p>description </p>
              <textarea type="text" name="actualDesp"></textarea>
              <button type = "submit" name= "despSubmit">Add to list</button>
            </div>
          </div>

          

          <div class="modal" id="modalacc">
            <div class="modal-content">
              <span class="close-button" >×</span>
              <p>Edit list things </p>
              <select id="accessOptionsChoice" name="accessOptionsChoice">

                <option value="1">public</option>
                <option value="0">private</option>
              </select> 
              <button type = "submit" name="accessOptions">Add to list</button>
            </div>
          </div>

         

        
          </form>
      </div>
      
      
    </div>
<!--I know it is bad practice to include script in html but it would not work on ym included logout script-->
    <!--remove empty list item found when generating the list from the-->
    <script>
         //$('ul li:empty').remove();
         
         $(document).ready(function(){
          $('input[type="checkbox"]').click(function(){
          if($(this).prop("checked") == true){
               $( "#myListItems li p:hover" ).wrap("<s></s>");
            }

          else if($(this).prop("checked") == false){
              $( "#myListItems li p:hover" ).unwrap()
            }
          });
    });
    </script>
    </body>
    
      <footer>
      <?php include "./includes/footer.php"; ?>
      <!-- Fix for Chrome bug, leave this. https://stackoverflow.com/a/42969608 -->
      </footer>
  
</html>