<?php
session_start();
require 'functions.php';

function display_news_banner()
{
  $connexion = connect_to_db();
  $requete = "SELECT Produits.Images,Produits.Libelle, Produits.ID 
FROM Produits
JOIN Produit_Categorie
ON Produits.ID = ID_produit
JOIN Categories
ON Categories.ID = ID_categorie 
WHERE Categories.Libelle = 'Series'";
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
    <title>CineToday</title>
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
                  echo "<ul id = 'text_connected'><li><a href = 'del_article.php'>{$_SESSION['connected'][0]}</a><ul><li id = 'text_deconection'><a href = 'deconnexion.php?login={$_SESSION['connected']} '>déconnection</a></li></ul></l\
i></ul>";
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
      <div id = 'Films_categorie'>
      <div id = 'Films'>
      <p id = 'titre_films_attendu'>Séries</p>
      <div id='best_seller'>
        <?php display_news_banner(); ?>
      </div>
    </div>
    <div id = 'Genre_Films'>
        <p id = 'titre_films_attendu'>Genre de Séries</p>
        <ul>
	  <li><a href = 'produits.php?categorie=Action&console=Series'>Action</a></li>
          <li><a href = 'produits.php?categorie=Aventure&console=Series'>Aventure</a></li>
          <li><a href = 'produits.php?categorie=Comedie&console=Series'>Comedie</a></li>
          <li><a href = 'produits.php?categorie=Drame&console=Series'>Drame</a></li>
          <li><a href = 'produits.php?categorie=Animation&console=Series'>Animation</a></li>
          <li><a href = 'produits.php?categorie=Arts_Martiaux&console=Series'>Arts_Martiaux</a></li>
          <li><a href = 'produits.php?categorie=Thriller&console=Series'>Thriller</a></li>
          <li><a href = 'produits.php?categorie=Biopic&console=Series'>Biopic</a></li>
          <li><a href = 'produits.php?categorie=Policier&console=Series'>Policier</a></li>
          <li><a href = 'produits.php?categorie=Romance&console=Series'>Romance</a></li>
          <li><a href = 'produits.php?categorie=Comedie_drame&console=Series'>Comedie_drame</a></li>
          <li><a href = 'produits.php?categorie=Western&console=Series'>Western</a></li>
          <li><a href = 'produits.php?categorie=Fantastique&console=Series'>Fantastique</a></li>
          <li><a href = 'produits.php?categorie=Guerre&console=Series'>Guerre</a></li>
         </ul>
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
