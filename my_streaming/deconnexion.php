<?php
session_start();
require 'functions.php';

if ((isset($_GET['login'])) && ($_GET['login']) == $_SESSION['connected'])
  {
    $_SESSION = array();
    $link = connect_to_db();
    $sql = "SELECT Etat FROM Utilisateurs WHERE Utilisateur=\"{$_GET['login']}\"";
    $query = $link->prepare( $sql );
    $query->execute();
    $results = $query->fetch();

    $sql = "UPDATE Utilisateurs SET  Etat=\"Disconnected\" WHERE Utilisateur=\"{$_GET['login']}\"";
    $query = $link->prepare( $sql );
    $query->execute();
    if ($results['Etat'] == "Bloqued")
      header("LOCATION: bloqued.html");
    else
      header("LOCATION: index.php");
  }
else
  header("LOCATION: index.php");

?>

