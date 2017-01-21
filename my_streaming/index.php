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

function display_news_banner()
{
  $connexion = connect_to_db();
  $requete = "SELECT Produits.Images,Produits.Libelle, Produits.ID 
FROM Produits
JOIN Produit_Categorie
ON Produits.ID = ID_produit
JOIN Categories
ON Categories.ID = ID_categorie 
WHERE Categories.Libelle = 'Films'
ORDER BY Date_de_sortie DESC LIMIT 6";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  
  foreach( $results as $row )
  {
    echo "<div><IMG src='{$row['Images']}'></img>\n";
    echo "<span class = 'span_produits'> <a href='produit_detail.php?ID={$row['ID']}'>{$row['Libelle']}</a></span></div>";
  }
}

function display_films_attendu()
{
  $connexion = connect_to_db();
  $requete = "SELECT Produits.Images,Produits.Libelle,Produits.Notation , Produits.ID
FROM Produits
JOIN Produit_Categorie
ON Produits.ID = ID_produit
JOIN Categories
ON Categories.ID = ID_categorie 
WHERE Categories.Libelle = 'Films'
ORDER BY Produits.Notation DESC LIMIT 5";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  
  foreach( $results as $row )
  {
    echo "<div class = 'block_films_attendu'><IMG src='{$row['Images']}' class = 'img_film_attendu'></img>\n";
    echo "<div style = 'margin: auto;'><span style = 'display: block;'> <a href='produit_detail.php?ID={$row['ID']}'>{$row['Libelle']}</a></span><div style = 'text-align: center;'>";
    while ($row['Notation'] > 0)
    {
      echo "<img src = 'images/etoile.png' class = 'etoile_notation'/>";
      $row['Notation']--;
    }
    echo "</div></div></div>";
  }
}

function display_top_de_la_semaine()
{
  $connexion = connect_to_db();
  $requete = "SELECT ID,Images,Libelle, SUBSTR(Discription, 1, '380') AS Discription_new FROM Produits  ORDER BY Date_de_sortie AND Notation DESC LIMIT 1";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  
  foreach( $results as $row )
  {
    echo "<div class = 'block_top1'><IMG class = 'img_top1'src='{$row['Images']}'></img>\n";
    echo "<div> <div id = 'top1_container'><img src = 'images/trophe.png' class = 'trophe'/><span><a href='produit_detail.php?ID={$row['ID']}'>{$row['Libelle']}</a></span><img src = 'images/trophe.png' class = 'trophe'/></div><p>  {$row['Discription_new']} ...</p></div></div>";
  }
}

function display_top_series_de_la_semaine()
{
  $connexion = connect_to_db();
  $requete = "SELECT Produits.Images,Produits.Libelle , Produits.ID
FROM Produits
JOIN Produit_Categorie
ON Produits.ID = ID_produit
JOIN Categories
ON Categories.ID = ID_categorie 
WHERE Categories.Libelle = 'Series'
ORDER BY 'Notation' DESC LIMIT 3";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  
  foreach( $results as $row )
  {
    echo "<div class = 'block_films_attendu'><IMG src='{$row['Images']}'></img>\n";
     echo "<span> <a href='produit_detail.php?ID={$row['ID']}'>{$row['Libelle']}</a></span></div>";
  }
}

function display_News()
{
  $connexion = connect_to_db();
  $requete = "SELECT Libelle, images, SUBSTR(Article, 1, '380') AS Article_new
FROM News
ORDER BY Date_de_sortie DESC LIMIT 1";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  
  foreach( $results as $row )
  {
    echo "<div class = 'block_News'><IMG src='{$row['images']}'></img>\n";
     echo "<div class = 'Article'><span class = 'titre_article'> <a href='produit_detail.php?ID={$row['ID']}'>{$row['Libelle']}</a></span><p>  {$row['Article_new']} ...</p></div></div>";
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="shortcut icon" href="" />
    <title>CineToday</title>
  </head>
  <body>
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
	            echo "<a href = 'connexion.php' style = 'margin: auto;'><img src = 'images/icone_utilisateur.jpg' id = 'icone_utilisateur'/></a>";
	  ?>
	  <div id="search_bar">
	    <form name="search" action="produits.php" method="get">
	      <input name="search" type="text" placeholder="   Mots-Clefs..." required />
	    </form>
	  </div>

	</div>
      </header>
      <div class="bloc_page">
	<img src = "images/mission_impossible.jpg" class = "image_princ"/>
	<p class = "titre_princ">Sortie de la Semaine</p>
	  <div id='best_seller'>
	  <?php display_news_banner(); ?>
	  </div>
	  <div id = "seconde_party">
	    <div style = 'display: flex;flex-direction: column;'>
	      <div style = 'display: flex;justify-content: space-around;'> 
		<div>
		  <p id = 'titre_films_attendu'>TOP SÉRIES DE LA SEMAINE</p>
		  <div id = "top_series_de_la_semaine">
		    <?php display_top_series_de_la_semaine();?>
		  </div>
		</div>
		<div>
		  <p id = 'titre_films_attendu'>TOP 1 de la Semaine</p>
		  <div id = "top_de_la_semaine">
		    <?php display_top_de_la_semaine();?>
		  </div>
		</div>
	      </div>
	      <div id = "NEW">
		<p id = 'titre_films_attendu'>News</p>
		<?php
		display_News();
		?>
	      </div>
	    </div>
	    <div>
	      <p id = 'titre_films_attendu'>Best Films</p>
	      <div id = "films_attendu">
		<?php display_films_attendu(); ?>
	      </div>
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
