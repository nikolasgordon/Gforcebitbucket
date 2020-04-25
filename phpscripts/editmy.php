<?php 
session_start();
$id = $_REQUEST['id'];
$username = $_SESSION['username'];
$_SESSION['id'] = $id;
header("location:editmy2.php");
exit();
          
        
?>

