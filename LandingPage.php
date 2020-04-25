<?php
session_start();
require "./includes/library.php";

$errors = [];

/* If this form has been submitted... */
if (isset($_POST['createAccount'])) {
  /* Process log-in request */
  
  $username = $_POST['username'];
  $password = $_POST['pwd'];
  $password2 = $_POST['pwd2'] ?? NULL ;
  $email = $_POST['email'] ?? NULL;

  if (!isset($username) || strlen($username) === 0) array_push($errors, "Please enter your username.");
  if (!isset($password) || strlen($password) === 0) array_push($errors, "Please enter your password.");
  if (!isset($password2) || strlen($password2) === 0) array_push($errors, "Please enter your password.");
  if (strcmp($password, $password2) != 0) array_push($errors, "Passwords don't match");
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) array_push($errors, "Please enter a valid email address.");

  if (count($errors) === 0) {
    /* Connect to DB */
      $pdo = connectDB();
      /* Check the database for occurances of $username */
      //before error count maybe?
      $sql="select 1 from project_users where username = ?"; 
      $sql2="select 1 from project_users where email = ?"; 
      $stmt=$pdo->prepare($sql); 
      $stmt2=$pdo->prepare($sql2); 
      $stmt->execute([$username]); 
      $stmt2->execute([$email]);

      if($stmt->fetchColumn()){ 
        array_push($errors, "user already exists");
      }
      if($stmt2->fetchColumn()){ 
        array_push($errors, "email is already in use");
      }
      else {
        $hash=password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO `project_users`(username, password, email) VALUES (?,?,?) ";
        $statement = $pdo->prepare($query);
        $statement->execute([$username,$hash,$email]);

        //create table for user


        $_SESSION['username'] = $username;
        header("Location: main.php");
        exit();
      }
  }  
}

if (isset($_POST['submit'])) {
  header("Location: loginPage.php"); ///change
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
      <script src="https://kit.fontawesome.com/a076d05399.js"></script>
      <script defer src="scripts/createAccount.js"></script>
  </head>
  
        <ul class="navigation">
            <li id="space"> <a href="LandingPage.php"><i class="fas fa-fill" style="font-size:20px;color:white"></i></a></li>     <!--Is this allowed?-->
            <li class ="toTheLeft" id="space">GForce-bucketList</li>
            <li class="toTheRight">
                <div class="search-container">
                  <form action="search.php"> <!--Could be a javascript in stead or something idk-->
                    <input type="text" placeholder="Search.." name="searchbar"/>
                    <button type="submit" name="actualSearch"><i class="fa fa-search"></i></button>
                  </form>
                </div>
            </li>
            <li><a href="loginPage.php">Login</a></li>
        </ul>
    <body>
    <div class="titlepicture">
    <h1>Welcome to GForce todo list!<h1>
    <p><i>Be bold!</i></p>
    </div>

    <div class="aboutpicture">
      <div>
    <h3>ABout us<h3> 

    <p>
      GForce todo list offers the best in house capabilities to suit your desires and needs for a todo list.
      Although you are limted with one list, the oppurtunites are endless with what you can experience with your list.
      Are main goal is to get a community of people determined to achive their goals, sharing occomplishments and reach self-actualization. 
      Start today! and be reafy to recieve the tool of your dreams! 

    </p>
    </div>
    </div>
    <div>
                <ul id="errors">
                    <?php foreach ($errors as $error): ?>
                      <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
        </div>
      <div class="happypeople">
        
        <div class="login-form-2">
          <p>GForce-bucketList is the ultimate tool to create, update, share, and delete list! all in a click of a bottum
          new? Create an account today!</p>
          <form action="<?= $_SERVER['PHP_SELF']?>" method="POST">
            <label for="Username">Username</label> 
            <input type="text" id="username" name="username" placeholder="Username">
            <label for="Password">Password</label>
            <input type="password" id="pwd" name="pwd" minlength="8" placeholder="Password">
            <label for="Password">Confirm Password</label><br>
            <input type="password" id="pwd2" name="pwd2" minlength="8" placeholder="Password">
            <span class="error hidden">Passwords does not match</span>
            <label for="Email">Email</label> 
            <input type="text" id="email" name="email" placeholder="john.smith@gmail.com">
            <span class="error hidden">That email address is invalid.</span>
            <lable for="button">Create your account!</lable>
            <input type="submit" id="createAccount" name="createAccount" value="Create Account" shape="round"  >
            <lable for="button">Already Registered? Sign in!</lable>
            <input type="submit" id="submit" name="submit" value="Login" shape="round">
        </form>
        </div>
      </div>
        
    </body>
      <footer>
        
      </footer>
  
</html>