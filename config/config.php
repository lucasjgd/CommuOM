<?php
// Database connection parameters / Paramètres de connexion à la base de données
$host = "mysql-joagand.alwaysdata.net"; 
$username = "joagand_lucas";
$password = "2107LuluOm!!";
$dbname = "joagand_commuom";  

// Connect to MySQL server / Se connecter au serveur MySQL
$link = mysqli_connect($host, $username, $password)
    or die("Erreur : impossible de se connecter au serveur MySQL - " . mysqli_connect_error());

// Select the database / Sélectionner la base de données
mysqli_select_db($link, $dbname)
    or die("Erreur : impossible de sélectionner la base de données - " . mysqli_error($link));
?>
