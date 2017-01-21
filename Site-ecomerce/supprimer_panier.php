<?php
session_start();
require 'functions.php';

$connexion = connect_to_db();
$requete = "SELECT * FROM Utilisateurs WHERE Utilisateur = \"{$_SESSION['connected']}\"";
$ind = $connexion->prepare($requete);
$ind->execute();
$results = $ind->fetch();
if((isset($_SESSION['connected'])) && ($results['Etat'] == "Bloqued"))
  header("LOCATION: deconnexion.php?login={$_SESSION['connected']}");
else if (!isset($_SESSION['connected']))
  header("LOCATION: index.php");

suprimer_produits();


function suprimer_produits()
{
  $connexion = connect_to_db();
  $requete = "SELECT ID  FROM Utilisateurs WHERE Utilisateur = '{$_SESSION['connected']}';";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetch();
  $ID = $results['ID'];
  
  $requete = "SELECT Quantite AS element FROM Produit_Utilisateur WHERE ID_Utilisateur = '{$ID}' AND ID_Produit = '{$_GET['ID']}';";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  foreach( $results as $row )
  {
    $element = $row['element'];
  }
  if ($element == 1 || $element == 0)
  {
    $requete = "DELETE FROM Produit_Utilisateur  where ID_Utilisateur = '{$ID}' AND ID_Produit = '{$_GET['ID']}';";
    $ind = $connexion->prepare($requete);
    $ind->execute();
    }
  else
  {
      $requete = "UPDATE  Produit_Utilisateur  SET Quantite = Quantite - 1 where ID_Utilisateur = '{$ID}' AND ID_Produit = '{$_GET['ID']}';";
      $ind = $connexion->prepare($requete);
      $ind->execute();
  }
  header("LOCATION: panier.php");
}

?>
