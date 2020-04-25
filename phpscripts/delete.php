<?php
require '../includes/library.php';
$pdo = connectDB();
session_start(); 

        $query = "DELETE FROM `project_users` WHERE username = ? ";
        $statement = $pdo->prepare($query);
        $statement->execute([$_SESSION['username']]);

        $query1 = "DELETE FROM `wholelist` WHERE username = ? ";
        $statement1 = $pdo->prepare($query1);
        $statement1->execute([$_SESSION['username']]);


        header("Location: ../LandingPage.php");
        exit();

 
?>