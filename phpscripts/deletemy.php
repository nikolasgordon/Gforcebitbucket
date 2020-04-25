<?php 
require '../includes/library.php';
$pdo = connectDB();
session_start();
$id=$_REQUEST['id'];
$username = $_SESSION['username'];
echo $id;

$query1 = "DELETE FROM `wholelist` WHERE id = ? ";
$statement1 = $pdo->prepare($query1);
$statement1->execute([$id]);
$results = $statement1->fetch();

    header("location:../myList.php");
    exit();

?>