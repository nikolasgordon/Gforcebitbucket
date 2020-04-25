<?php
require './includes/library.php';
$pdo = connectDB();
session_start(); 

if(!isset($_SESSION['username'])){     
  header("Location:loginPage.php"); 
  exit();  
}

$username = $_SESSION['username'];

$query = "SELECT username FROM `project_users` WHERE username != ? ";
$statement = $pdo->prepare($query);
$statement->execute([$username]);
$userlist = $statement->fetchAll();


$query1 = "SELECT id,username, listitem, access FROM `wholelist` WHERE username != ? AND access = ?  ";
$statement1 = $pdo->prepare($query1);
$statement1->execute([$username, 1]); //acce 1 means public
$results = $statement1->fetchAll();

//I dont remember doing this but i will leave it in hopes it does not break anything
if(isset($_POST['ownlist'])){     
  echo $_SESSION['Go back to school'];
}

/*if(isset($_POST['searchOptionsButton'])){     
  $accessadd = $_POST['searchOptions'] ?? NULL;
    
  if(isset($_POST['accessOptionsChoice'])){
    $query1 = "SELECT * FROM `wholelist` WHERE username != ? AND access = ? ";
    $statement1 = $pdo->prepare($query1);
    $statement1->execute([$username, 1]); //acce 1 means public
    $results = $statement1->fetchAll();

  }*/
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
  </head>
  
        <ul class="navigation">
            <li id="space"> <a href="myList.php"><i class="fas fa-fill" id="font" style="font-size:20px;color:white"></i></a></li>     <!--Is this allowed?-->
            <li class ="toTheLeft" id="space">GForce-bucketList</li>
            <li class="toTheRight">
              <div class="search-container">
                <form action="search.php" method="POST"> <!--Use of header script would be cool -->
                  <input type="text" placeholder="Search.." name="searchbar"/>
                  <button type="submit" name="luckySearch"><i class="fa fa-search"></i> feeling lucky</button>
                  <button type="submit" name="actualSearch"><i class="fa fa-search"></i></button>
                </form>
              </div>
          </li>
          <li><a href="main.php">Public Lists</a></li>
            <li><a href="myList.php">My List</a></li>
            <li><a href="myAccount.php">My Account</a></li>
            <li><a id ="logout">Log Out</a></li>

        </ul>
    <body>
    <form action = "<?= $_SERVER['PHP_SELF']?>" method="POST">
      <div class="mainBody">
      
      <div class = "searchStuff">
        <label for="searchOptions">Search by..:</label>

        <select id="searchOptions" name = "searchOptions">
          <option value="new">Newest First</option>
          <option value="task">Most task</option>
        </select> 
        <button type = "submit" name="searchOptionsButton">Add to list</button>

          <!--looped call to evrything in the database call-->
           <!--when a list is being created, if public add to public table-->
          <div class="exampleList">
          <ul id="publicList">
            <?php foreach ($userlist as $user): ?>
              <h4><?= $user['username'] ?>'s List</h4>
              <?php foreach ($results as $row): ?>
              <li><?php if($row['username'] == $user['username']){ echo $row['listitem'];}?></li>
              <a href= "phpscripts/take.php?id=<?=$row["id"]?> ">Add task to your list</a>
              <?php endforeach; ?>
              <br> <!--just seeing something-->
            <?php endforeach; ?>
          </ul>
          </div>
    
      </div>
    </div>

    <!--I know it is bad practice to include script in html but it would not work on my included logout script-->
    <!--remove empty list item found when generating the list from the-->
    <script>

      function appendLink() {
        let txt3 = $("<a></a>").text("Add this task to own list");  // Create text with jQuery
        txt3.attr('href','phpscripts/take.php?id=<?=$row["id"]?>');
        $('#publicList li').append(txt3);   // Append new elements
      }
        //$('#PublicList li button').remove();
         $('ul li:empty + a').remove();
         $('ul li:empty').remove();
        
        //appendLink();
    </script>

    </form>
    </body>
      <footer>
        
      </footer>
  
</html>