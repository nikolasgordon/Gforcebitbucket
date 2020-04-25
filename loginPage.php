<?php
session_start();
require "./includes/library.php";

$errors = [];

//if you somehow stuble on the landing page while already being logged in
//CHANGE BACK TO "isset"

if(isset($_SESSION['username'])){     
  header("Location:myList.php"); 
  exit();  
}


/* If this form has been submitted... */
if (isset($_POST['submit'])) {
  /* Process log-in request */
  $username = $_POST['username'];
  $password = $_POST['password'];
  $user = $username;
  /* Connect to DB */
  $pdo = connectDB();
  
  /* Check the database for occurances of $username */
  $query = "SELECT username, password FROM `project_users` WHERE username = ?";
  $statement = $pdo->prepare($query);

  $statement->execute([ $username ]);
  $results = $statement->fetch();

  if ($results === FALSE) {
    array_push($errors, "That user doesn't exist.");
  } else if (password_verify($password, $results['password'])) {
    $_SESSION['username'] = $username;
    if (isset($_POST['remember'])) {
      setcookie("cookieuser",$user,time()+60*60*24*30*12);
    }
    header("Location: myList.php");
    exit();
  } else {
    array_push($errors, "Incorrect password or username.");
  }
}
if (isset($_POST['createAccount'])) {
  header("Location: createAccount.php"); ///change
  exit();
}
//set cookie if box checked 

  

  //dont know if I should really utilize this, could use it as a vlaue for login but

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
  </head>
  
    <body>

        <div class= "login-form">
            <i class="fas fa-fill" style="font-size:20px;color:white;padding:0"> GForce Bucket-List</i>
        
            <form action = "<?= $_SERVER['PHP_SELF']?>" method="POST">
                <label for="Username">Username</label>
                <input type="text" name="username" placeholder="Username" >
                <label for="Password">Password</label>
                <input type="password" id="password" name="password" minlength="8" placeholder="Password">
                <label for="remember"> remember me</label>
                <input type="checkbox" id="remember" name="remember" value="remember">
                <label for="submit">Login</label>
                <input type="submit" name="submit" value="login" shape="round">
                <div class="topStuff" >
                     Not Registered? Create Account today!
                     <input type="submit" id="createAccount" name="createAccount" value="Create Account" shape="round"  >
                </div>
            </form> 
                 <ul id="errors">
                    <?php foreach ($errors as $error): ?>
                      <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>

        </div>

    </body>
      <footer>
        
      </footer>
  
</html>