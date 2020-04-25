<?php
require './includes/library.php';
$pdo = connectDB();
session_start(); 
$errors = [];
//no user, no use of page
if(!isset($_SESSION['username'])){     
  header("Location:loginPage.php"); 
  exit();  
}

$username = $_SESSION['username'];

if(isset($_POST['actualSearch']) && strlen($_POST['searchbar']) != 0){

    $search =  $_POST['searchbar'];  //dangerous need to be clean, else exposed to injection, tried prepared statement method but to no avail

       $search = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$search); //regx instead of prepared statement
        $query1 = "SELECT id, username, listitem FROM `wholelist` WHERE username != ? AND listitem LIKE '%$search%' ORDER BY username ";
        $statement1 = $pdo->prepare($query1);
        $statement1->execute([$username]); //could put $search here
        $results = $statement1->fetchAll();

}
if(isset($_POST['luckySearch']) && strlen($_POST['searchbar']) != 0){

  $search =  $_POST['searchbar'];  //dangerous need to be clean, else exposed to injection, tried prepared statement method but to no avail

     $search = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$search); //regx instead of prepared statement
      $query1 = "SELECT id, username, listitem FROM `wholelist` WHERE username != ? AND listitem LIKE '%$search%' ORDER BY username ";
      $statement1 = $pdo->prepare($query1);
      $statement1->execute([$username]); //could put $search here
      $results1 = $statement1->fetch();  //bruh

      
      $query = "INSERT INTO `wholelist` (username, listitem, access) VALUES (?,?,?)";
    $statement = $pdo->prepare($query);
    $statement->execute([$username, $results1['listitem'], 1]);
    header("location:myList.php");
    exit();

      

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
  </head>
  
        <ul class="navigation">
            <li id="space"> <a href="myList.php"><i class="fas fa-fill" id="font" style="font-size:20px;color:white"></i></a></li>     <!--Is this allowed?-->
            <li class ="toTheLeft" id="space">GForce-bucketList</li>
            <li class="toTheRight">
              <div class="search-container">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method ="POST"> 
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
      <div class="mainBody">
      
      
      <div class = "searchStuff">
        <label for="searchOptions">Search by..:</label>

          <!--looped call to evrything in the database call-->
           <!--when a list is being created, if public add to public table-->
          <div class="exampleList">
          <ul id="publicList">
          <?php foreach ($results as $row): ?>
            <li><?=$row['listitem'] ?> by <?=$row['username']?></li>
              <a href= "phpscripts/take.php?id=<?=$row["id"]?> ">Add task to your list</a>
            <?php endforeach; ?>
          </ul>
          </div>
    
      </div>
    </div>

    <!--I know it is bad practice to include script in html but it would not work on ym included logout script-->
    <!--remove empty list item found when generating the list from the-->
    <script>
        $('ul li:empty + a').remove();
         $('ul li:empty').remove();
    </script>

    </body>
      <footer>
        
      </footer>
  
</html>