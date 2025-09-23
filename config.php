<?php
$host = "mysql-joagand.alwaysdata.net"; 
$username = "joagand_lucas";
$password = "2107LuluOm!!";
$dbname = "joagand_commuom";   

$link = mysqli_connect($host, $username, $password)
    or die("Erreur : impossible de se connecter au serveur MySQL - " . mysqli_connect_error());

mysqli_select_db($link, $dbname)
    or die("Erreur : impossible de sélectionner la base de données - " . mysqli_error($link));
?>
