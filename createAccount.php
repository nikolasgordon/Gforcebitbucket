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
if (isset($_POST['createAccount'])) {
  /* Process log-in request */
  
  $username = $_POST['username'] ?? NULL;
  $password = $_POST['pwd'] ?? NULL ;
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

        
        $_SESSION['username'] = $username;
        header("Location: myList.php");
        exit();
      }
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
      <script src="https://kit.fontawesome.com/a076d05399.js"></script>
      <script defer src="scripts/createAccount.js"></script>
  </head>
  
    <body>
        <div class= "login-form">
            <i class="fas fa-fill" style="font-size:20px;color:white;padding:0"> GForce Bucket-List</i>
        
            <form action = "<?= $_SERVER['PHP_SELF']?>" method="POST">
                <label for="Username">Username</label> 
                <input type="text" id = "username" name="username" placeholder="Username">
                <label for="Password">Password</label><br>
                <input type="password" id="pwd" name="pwd" minlength="8" placeholder="Password">
                <label for="Password">Confirm Password</label><br>
                <input type="password" id="pwd2" name="pwd2" minlength="8" placeholder="Password">
                <span class="error hidden">Passwords does not match</span><br>
                <label for="email">Email</label> <br>
                <input id="email" name="email" type="text" placeholder="johnsmith@gmail.com">
                <span class="error hidden">That email address is invalid.</span>
             

                 <div class="topStuff">
                    <ul id="errors">
                        <?php foreach ($errors as $error): ?>
                          <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                     <input type="submit" id="createAccount" name="createAccount" value="Create Account" shape="round"  >
                 </div>
            </form>
        </div>

    </body>
      <footer>
        
      </footer>
  
</html>