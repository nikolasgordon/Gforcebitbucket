<?php 
require '../includes/library.php';
$pdo = connectDB();
session_start();

$username = $_SESSION['username'];
$errors = [];


if(isset($_POST['editbutton'])){
    
        echo $_SESSION['id'];
        if(isset($_POST['editinput'])){
            $newtask = $_POST['editinput'];
            $newtask = preg_replace('/(?<!\\\)([%_])/', '\\\$1',$newtask); //regx instead of prepared statement
            $query = "UPDATE `wholelist` SET listitem = ? WHERE id = ?";
            $statement = $pdo->prepare($query);
            $statement->execute([$newtask, $_SESSION['id'] ]);
            header("location:../myList.php");
            exit();
        }else{
            array_push($errors, "Please enter something.");
        }

        
}
 if(isset($_POST['dontedit'])){

            header("location:../myList.php");
            exit();
        }       
?>
<!DOCTYPE html>
<html>
<body>
        <form action ="<?=$_SERVER['PHP_SELF']?>" method="POST">
              <p>Edit list things </p>
              <input type="text" id="editinput" name = "editinput" placeholder = "Edit entry">
              <input type = "submit" name = "editbutton">Add to list</button>
              <input type = "submit" name = "dontedit">Go back</button>
              <ul id="errors">
                        <?php foreach ($errors as $error): ?>
                          <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
        </form>


</body>
</html>