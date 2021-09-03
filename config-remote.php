<?php

/* here we connect to the hosting service */
$host       = "sql311.epizy.com";
$username   = "epiz_29615742";
$password   = "U6Y9cZjY18hwNnS";
$dbname     = "epiz_29615742_mymeets"; 
$dsn        = "mysql:host=$host;dbname=$dbname"; 
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );

/* Attempt to connect to MySQL database */
try{
  $pdo_connection = new PDO($dsn, $username, $password, $options);
} catch(PDOException $e){
  die("ERROR: Could not connect. " . $e->getMessage());
}
?>