<?php
session_start();
require 'functions.php';

/*$connexion = connect_to_db();
$requete = "SELECT * FROM Utilisateurs WHERE Utilisateur = \"{$_SESSION['connected']}\"";
$ind = $connexion->prepare($requete);
$ind->execute();
$results = $ind->fetch();
if((isset($_SESSION['connected'])) && ($results['Etat'] == "Bloqued"))
  header("LOCATION: deconnexion.php?login={$_SESSION['connected']}");
*/
function display_articles()
{
  $length_limit = 12;
  $connexion = connect_to_db();
  if (!empty($_GET['categorie']))
    {
      $categorie_filter = "WHERE Sous_Categories.Libelle = \"{$_GET['categorie']}\"";
      if (!empty($_GET['console']))
	$console_filter = "AND  Categories.Libelle = \"{$_GET['console']}\"";
      else
	$console_filter = "";
    }
  else
  {
    $categorie_filter = "";
    if (!empty($_GET['console']))
      $console_filter = "WHERE Categories.Libelle = '{$_GET['console']}'";
    else
      $console_filter = "";
  }
  
  if (!empty($_GET['search']))
  {
    if (!(empty($categorie_filter) && empty($console_filter)))
      $search_filter = "AND  Produits.Libelle LIKE  '%{$_GET['search']}%'";
    else
      $search_filter = "WHERE Produits.Libelle LIKE  '%{$_GET['search']}%'";
  }
  else
    $search_filter = "";
   $requete = "SELECT Produits.*  FROM Produits
JOIN Produits_Sous_Categories
ON Produits.ID = Produits_Sous_Categories.ID_Produit
JOIN Sous_Categories
ON Sous_Categories.ID =  Produits_Sous_Categories.ID_Sous_Categories
JOIN Produit_Categorie
ON Produits.ID = Produit_Categorie.ID_Produit
JOIN Categories
ON Categories.ID = Produit_Categorie.ID_Categorie
	{$categorie_filter} {$console_filter}
         {$search_filter} ";
   $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  
  foreach( $results as $row )
  {
  	echo "<div><IMG src='{$row['Images']}'></img>\n";
    echo "<span class = 'span_produits'> <a href='produit_detail.php?ID={$row['ID']}'>{$row['Libelle']}</a></span></div>";
   
  }
}


?>
	


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="shortcut icon" href="" />
    <title>The Games Sanctum</title>
  </head>
</head>
  <header>
      <div id="head_bloc">
	<div id = "CineToday">
	  <IMG src = "images/logo.png" id = 'logo'/>
	  <a href = 'index.php'><p>CineToday</p></a>
	  </div>
	<ul id = 'list_option'>
	  <li id = "active" class = "element_option"><a href = 'Films.php'>Films</a></li>
	  <li class = "element_option"><a href = 'Series.php'>Series</a></li>
	  <li class = "element_option">Animes</li>
	  <li class = "element_option">Emissions</li>
	</ul>
	  <?php
	  if (isset($_SESSION['connected']))
	  {
	    echo "<ul id = 'text_connected'><li><a href = 'del_article.php'>{$_SESSION['connected'][0]}</a><ul><li id = 'text_deconection'><a href = 'deconnexion.php?login={$_SESSION['connected']} '>déconnection</a></li></ul></li></ul>";
	  }
	  else 
	echo "<a href = 'connexion.php' style = 'margin: auto;'>
	  <img src = 'images/icone_utilisateur.jpg' id = 'icone_utilisateur'/>
	</a>";
	?>
	<div id="search_bar">
	  <form name="search" action="produits.php" method="get">
	    <input name="search" type="text" placeholder="   Mots-Clefs..." required />
	  </form>
        </div>
        
      </div>
    </header>
  <body>

     
      <div class="bloc_page">
      	<div id = 'Resutat_recherche'>
      		<p id = 'titre_films_attendu'>Resultat de Votre Recherche</p>
		    <div id = 'best_seller'>
		    <?php display_articles(); ?>
			</div>
		</div>	
    </div>
  </body>
  <footer>
    <div id = "minifooter">
      <span>Suivez-nous sur </span>
      <ul>
  	<li>
  	  <a href="https://www.facebook.com/"><img src="images/facebook.jpg"/></a>
  	</li>
  	<li>
  	  <a href="https://twitter.com/"><img src="images/twiter.jpg"/></a>
   	</li>
  	<li>
  	  <a href="https://www.youtube.com/"><img src="images/youtube.jpg"/></a>
  	</li>
  		<li>
  		<a href="https://instagram.com/"><img src="images/instagram.jpg"/></a>
  		</li>
  		<li>
  		<a href="https://plus.google.com/"><img src="images/G.jpg"/></a>
  		</li>
 
    </div>

    <div id="links">
      <div id="usefullinks">
	<ul>
	  <li>
	    <a href="#">Informations Legales</a>
	  </li>
	  <li>
	    <a href="#">CGU</a>
	  </li>
	  <li>
	    <a href="#">Newsletter</a>
	  </li>
	  <li>
	    <a href="#">Contact</a>
	  </li>
	  <li>
	    <a href="#">F.A.Q.</a>
	  </li>
	  <li>
	    <a href="#">Financement</a>
	  </li>
        </ul>
      </div>
      
    <div id="copyrights">
      <p>Copyright © Cinema - 2017</p>
    </div>
  </footer>
</html>

