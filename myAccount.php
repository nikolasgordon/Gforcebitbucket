<?php
require './includes/library.php';
$pdo = connectDB();
session_start(); 
$errors = [];
//although we could just call session for username, we also need email which is not stored in session
if(isset($_SESSION['username'])){    
  
  $query = "SELECT id, username, email FROM project_users WHERE username = ?";
  $statement = $pdo->prepare($query);
  
  $statement->execute([$_SESSION['username']]);
  
  $results = $statement->fetch();
}else {   
    header("Location:loginPage.php"); 
    exit();  
  
}

if(isset($_POST['usersubmit'])){ 
  $newuser = $_POST['usernamechange'];
  $sql="select 1 from project_users where username = ?"; 
  $stmt=$pdo->prepare($sql); 
  $stmt->execute([$newuser]); 
  if($stmt->fetchColumn()){ 
    array_push($errors, "user already exists");
  }else{
        $query = "UPDATE `project_users` SET username = ? WHERE id = ? ";
        $statement = $pdo->prepare($query);
        $statement->execute([$newuser, $results['id']]);

        $query = "UPDATE `wholelist` SET username = ? WHERE username = ? ";
        $statement = $pdo->prepare($query);
        $statement->execute([$newuser, $username]);

        
        $_SESSION['username'] = $newuser;
        header("Location: myList.php");
        exit();

  }
      
}

if(isset($_POST['emailsubmit'])){ 
  $newemail = $_POST['emailchange'];
  $sql="select 1 from project_users where email = ?"; 
  $stmt=$pdo->prepare($sql); 
  $stmt->execute([$newemail]); 
  if($stmt->fetchColumn()){ 
    array_push($errors, "email already exists");
  }else{
        $query = "UPDATE `project_users` SET email = ? WHERE id = ? ";
        $statement = $pdo->prepare($query);
        $statement->execute([$newemail, $results['id']]);

        header("Location: myList.php");
        exit();

  }
}

if(isset($_POST['passsubmit'])){ 
        $newpassword = $_POST['passchange'];
        $hash=password_hash($newpassword, PASSWORD_DEFAULT);
        $query = "UPDATE `project_users` SET password = ? WHERE id = ? ";
        $statement = $pdo->prepare($query);
        $statement->execute([$hash, $results['id']]);

        header("Location: myList.php");
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
      <script defer src="scripts/myAccount.js"></script>
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
    <body >
      <div class="mainBody">
      <div>
        <h3>Welcome <?= $results['username'] ?> !</h3>
        <ul>
          <li id="updateuser"><a>Change username</a></li>
          <li id="updateemail"><a>Change email</a></li>
          <li id="updatepassword"><a>Change password</a></li>
          <li id="editlist"><a>Edit List</a></li>
          <li id="removeaccount"><a>Delete Account</a></li>
        </ul>
      </div>


      <!--MODAL STUFFF-->
      <form action = "<?= $_SERVER['PHP_SELF']?>" method="POST">
      <div class="modal" id="modalupdate">
            <div class="modal-content">
              <span class="close-button" >×</span>
              <p>Please enter the the new information</p>
              <label for="email">New Username:</label>
              <input type="text" id="usernamechange" name ="usernamechange" placeholder = "<?= $results['username'] ?>" ></input>    <!--place holder equals database stuff-->
              <label for="email">Confirm username:</label>
              <input type="text" id="usernamechange2" placeholder = "<?= $results['username'] ?>" ></input>    <!--place holder equals database stuff-->
              <span class="error hidden">usernames do not not match</span><br>
              <input type = "submit" name="usersubmit" id="usersubmit" value="Change Username">
            </div>
          </div>

          <div class="modal" id="modalemail">
            <div class="modal-content">
              <span class="close-button" >×</span>
              <p>Please enter the item you want to add to the list</p>
              <label for="email">Changed Email:</label>
              <input type="text" id="emailchange" name = "emailchange" placeholder = "<?= $results['email'] ?>"></input>    <!--place holder equals database stuff-->
              <span class="error hidden">emails not valid</span><br>
              <label for="email">Confirm Email Address:</label>
              <input type="text" id="emailchange2" placeholder = "<?= $results['email'] ?>"></input>    <!--place holder equals database stuff-->
              <span class="error hidden">emails do not match</span><br>
              <button type = "submit" id="emailsubmit" name = "emailsubmit">Change</button>
            </div>
          </div>

          <div class="modal" id="modalpassword">
            <div class="modal-content">
              <span class="close-button" >×</span>
              <p>Please enter the item you want to add to the list</p>
              <label for="email">New password:</label>
              <input type="password" id="passchange" name="passchange"></input>    <!--place holder equals database stuff-->
              <label for="email">Confirm new password:</label>
              <input type="password" id="passchange2"></input>    <!--place holder equals database stuff-->
              <span class="error hidden">Passwords does not match</span>
              <button type = "submit" id="passsubmit" name = "passsubmit">Change password</button>
              
            </div>
          </div>

          </form>
          <!--looped call to evrything in the database call-->
           <!--when a list is being created, if public add to public table-->
          <div class="exampleList">
          <ul id="errors">
                        <?php foreach ($errors as $error): ?>
                          <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
          </div>
    
      </div>
    </div>

    </body>
      <footer>
        
      </footer>
  
</html>