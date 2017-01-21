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

function display_best_seller()
{
  $length_limit = 12;
  $connexion = connect_to_db();
  $requete = "SELECT Produits.*, Categories.Logo, SUBSTR(Produits.Libelle, 1, {$length_limit}) AS Libelle_new
	FROM Produits
	JOIN Categorie_Produit
	ON ID_Produit = Produits.ID
	JOIN Categories
	ON ID_Categorie = Categories.ID
	ORDER BY Nombres_produit_vendu DESC LIMIT 8";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();

  foreach( $results as $row )
  {
    $content  = nl2br($row["Description"]);
    $Libelle = nl2br($row["Libelle_new"]);
    if (strlen($row['Libelle']) > $length_limit)
      $suspension = "...";
    else
      $suspension = "";
    
    echo "<div class='article'>
<div class='article_img'>
<img src='{$row['Image']}'></img>
</div>
<div class='price'>
<a href='produit_detail.php?ID={$row['ID']}'><h4>{$Libelle}"."{$suspension}</h4></a>
<dl>
<dt>Prix</dt>
<dd>{$row['Prix_vente']}€</dd>
<dt>Notation</dt>";
    
    echo "<dd>";
    $i = 0;
    while ($i < $row['Notation'])
      {
	echo "*";
	$i = $i + 1;
      }
    echo "</dd></dl>";
    echo "
<div class='console_logo'>
<a href='produits.php'><img src={$row['Logo']}></img></a>
</div>
</div>
</div>";
  }
}

function display_news_banner()
{
  $connexion = connect_to_db();
  $requete = 'SELECT Image FROM Produits ORDER BY Date_de_sortie DESC LIMIT 10';
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  
  foreach( $results as $row )
  {
    echo "<IMG src='{$row['Image']}'></img>\n";
  }
}

function display_cart()
{
  global $length_limit;
  $connexion = connect_to_db();
  $requete = "SELECT Produit_Utilisateur.Quantite AS element                                                                                            
  FROM Produits                                                                                                                                         
  JOIN Produit_Utilisateur                                                                                                                              
  ON ID_Produit = Produits.ID                                                                                                                           
  JOIN Utilisateurs                                                                                                                                     
  ON ID_utilisateur = Utilisateurs.ID                                                                                                                   
  where Utilisateurs.Utilisateur = '{$_SESSION['connected']}' ;";

  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();

  foreach( $results as $row )
  {
    $nb_article = $nb_article + $row['element'];
  }
  echo $nb_article;
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

  <body>
    
      <header>
	<div id="head_bloc">
	  <img src="images/header_logo.jpg"/>
	  <a href="index.php"><h1>The Games Sanctum</h1></a>
	  <div id="Logged_buttons">
	    <button class="button"><?php
				   if (isset($_SESSION['connected']))
				     echo "<a href=\"admin.php\">{$_SESSION['connected']}</a>";
				   else
				     echo "<a href=\"connexion.php\">Connexion</a>";?>
	    </button>
	    <button class="button"><?php
				   if (isset($_SESSION['connected']))
				     echo "<a  href=\"deconnexion.php?login={$_SESSION['connected']}\">DECONNEXION</a>";
				   else
				     echo "<a href=\"inscription.php\">Inscription</a>";?>
	    </button>
	    <button id="panier_button"><?php
				   if (isset($_SESSION['connected']))
				   {				     
				     echo "<img src='images/panier.jpg'/><a href=\"panier.php\">  ";
				     echo display_cart();
				     echo " Articles </a>";
				   }
				   else
				     echo "<img src='images/panier.jpg'/><a href=\"connexion.php\">PANIER</a>";
				   ?>
	    </button>
	  </div>
	</div>
	<div id="option">
	  <ul id="menu_deroulant">
	    <li><a href="categories.php">Categories</a>
	    </li>
	    <li><a href="produits.php?categorie=Play+Station">Play Station</a>
	      <ul>
		<li><a href="produits.php?console=Play+Station+4">PS4</a></li>
		<li><a href="produits.php?console=Play+Station+3">PS3</a></li>
		<li><a href="produits.php?console=Play+Station+2">PS2</a></li>
		<li><a href="produits.php?console=Play+Station+Portable">PSP</a></li>
	      </ul>
	    </li>
	    <li><a href="produits.php?categorie=XBOX">XBOX</a>
	      <ul>
		<li><a href="produits.php?console=XBOX+ONE">XBOX ONE</a></li>
		<li><a href="produits.php?console=XBOX+360">XBOX 360</a></li>
	      </ul>
	    </li>
	    <li><a href="produits.php?categorie=Nintendo">Nintendo</a>
	      <ul>
		<li><a href="produits.php?console=Nintendo+DS">Nintendo DS</a></li>
		<li><a href="produits.php?console=Nintendo+3DS"> Nintendo 3DS</a></li>
		<li><a href="produits.php?console=Nintendo+Wii+U"> Wii U</a></li>
		<li><a href="produits.php?console=Nintendo+Wii"> Wii</a></li>
	      </ul>
	    </li>
	    <li><a href="produits.php?categorie=PC">PC</a>
	    </li>
	  </ul>

	  <div id="search_bar">
	    <form name="search" action="produits.php" method="get">
	      <input name="search" type="text" placeholder="   Mots-Clefs..." required />
              <input class="loupe" type="submit" value=""/>
	    </form>
          </div>
        </div>
      </header>
      <div class="bloc_page">
	<div id="main_bloc">
	<div id="news_banner">
	  <MARQUEE scrolldelay="60" scrollamount="15" behavior="alternate" direction="left">
	    <?php  display_news_banner(); ?>
	  </MARQUEE>
	</div>
	<div id='best_seller'>
	  <?php display_best_seller(); ?>
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
      <div id="partners">
	<ul>
	  <li><a href="#">Pupi</a></li>
	  <li><a href="#">Mr</a></li>
	  <li><a href="#">MrFan</a></li>
	  <li><a href="#">Pupi</a></li>
	  <li><a href="#">Mr</a></li>
	  <li><a href="#">Kaiwaii</a></li>
	  <li><a href="#">Perceval</a></li>
	  <li><a href="#">Belette</a></li>
	  <li><a href="#">concombre</a></li>
	  <li><a href="#">Ptit</a></li>
	  <li><a href="#">MrFan</a></li>
	  <li><a href="#">Pupi</a></li>
	  <li><a href="#">Mr</a></li>
	  <li><a href="#">Kaiwaii</a></li>
	  <li><a href="#">Perceval</a></li>
	  <li><a href="#">Belette</a></li>
	  <li><a href="#">concombre</a></li>
	  <li><a href="#">Ptit</a></li>
	  <li><a href="#">MrFan</a></li>
	</ul>
      </div>
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
    </div>
    <div id="copyrights">
      <p>Copyright © The Game Sanctum - 2016</p>
    </div>
  </footer>
</html>
