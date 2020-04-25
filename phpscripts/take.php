<?php 
require '../includes/library.php';
$pdo = connectDB();
session_start();
$id=$_REQUEST['id'];
$username = $_SESSION['username'];

$query1 = "SELECT listitem FROM `wholelist` WHERE id = ? ";
$statement1 = $pdo->prepare($query1);
$statement1->execute([$id]);
$results = $statement1->fetch();

$query = "INSERT INTO `wholelist` (username, listitem, access) VALUES (?,?,?)";
    $statement = $pdo->prepare($query);
    $statement->execute([$username,$results['listitem'], 1]);
    header("location:../myList.php");
    exit();

?>