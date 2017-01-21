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
  header("LOCATION: connexion.php");

function modif_element()
{
  $connexion = connect_to_db();
  $requete = "SELECT Produits.Nombres_produit,Utilisateurs.ID
  FROM Produits                                                                                                           
  JOIN Produit_Utilisateur                                                                                                
  ON ID_Produit = Produits.ID                                                                                             
  JOIN Utilisateurs                                                                                                       
  ON ID_utilisateur = Utilisateurs.ID                                                                                     
  where Utilisateurs.Utilisateur = '{$_SESSION['connected']}' AND Produit_Utilisateur.ID_Produit = '{$_GET['ID']}';";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  foreach( $results as $row )
  {
    $ID = $row['ID'];
    $Nombres_produit = $row['Nombres_produit'];
  }

  
  if ($Nombres_produit >= $_GET['element'])
  {
    $requete = "UPDATE Produit_Utilisateur  
SET Quantite = '{$_GET['element']}'
WHERE ID_Utilisateur = '{$ID}' AND ID_Produit = '{$_GET['ID']}';" ;
    $ind = $connexion->prepare($requete);
    $ind->execute();
  }
  else
    $str= "Pas assez en stock";
 
  if ($_GET['element'] == "0")
  {
    header("LOCATION: supprimer_panier.php?ID={$_GET['ID']}");
  }
  else if (isset($str))
  {
    strip_tags($str);
    header("LOCATION: panier.php?error={$str}");
  }
    else
    header("LOCATION: panier.php");
}

modif_element();

?>
