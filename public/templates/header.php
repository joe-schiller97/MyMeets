<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Adding this code to the header applies it to each page, preventing users from accessing the site or the database until they login
?>

<!doctype html>
<html lang="en">

<head>

    <title>MyMeets</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <a href="index.php">
        <img class="logo"
            src="assets/images/logo.png"></a>
        <nav>
            <ul1>
                <li class="navigation"><li><a href="create.php">Create meeting</a></li>
        <li><a href="read.php">Show meetings</a></li>
        <li><a href="update.php">Edit meeting</a></li>
        <li><a href="delete.php">Delete meeting</a></li>
        <li><a href="profile.php">Profile</a></li>
            </ul1>
        </nav>
    </header>
<main>
