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

function display_articles()
{
  $length_limit = 12;
  $connexion = connect_to_db();
  if (!empty($_GET['categorie']))
    {
      $categorie_filter = "WHERE Categories.Libelle LIKE  '{$_GET['categorie']}%'";
      if (!empty($_GET['console']))
	$console_filter = "AND  Categories.Libelle = '{$_GET['console']}'";
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
  
  if (!empty($_GET['order']))
    $order_filter = "ORDER BY  Produits.{$_GET['order']}";
  else
    $order_filter = "";

  if (!empty($_GET['search']))
  {
    if (!(empty($categorie_filter) && empty($console_filter)))
      $search_filter = "AND  Produits.Libelle LIKE  '%{$_GET['search']}%'";
    else
      $search_filter = "WHERE Produits.Libelle LIKE  '%{$_GET['search']}%'";
  }
  else
    $search_filter = "";

  
  $requete = "SELECT Produits.*, Categories.Logo, SUBSTR(Produits.Libelle, 1, {$length_limit}) AS Libelle_new
	FROM Produits
	JOIN Categorie_Produit
	ON ID_Produit = Produits.ID
	JOIN Categories
	ON ID_Categorie = Categories.ID
	{$categorie_filter} {$console_filter}
         {$search_filter} {$order_filter}";

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
<a href='produit_detail.php?ID={$row['ID']}'><h4>{$row['Libelle']}</h4></a>
<dl>
<dt>Prix</dt>
<dd>{$row['Prix_vente']}€</dd>
<dt>Notation</dt>
<dd>{$row['Notation']}</dd>
</dl>
<div class='console_logo'>
<a href='categories.php'><img src={$row['Logo']}></img></a>
</div>
</div>
</div>";
  }
}

function display_cart()
{
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
	    <li><a href="produits.php?categorie=XBOX">Xbox</a>
	      <ul>
		<li><a href="produits.php?console=XBOX+ONE">XBOX ONE</a></li>
		<li><a href="produits.php?console=XBOX+360">XBOX 360</a></li>
	      </ul>
	    </li>
	    <li><a href="produits.php?categorie=NINTENDO">Nintendo</a>
	      <ul>
		<li><a href="produits.php?console=NINTENDO+DS">Nintendo DS</a></li>
		<li><a href="produits.php?console=NINTENDO+3DS"> Nintendo 3DS</a></li>
		<li><a href="produits.php?console=NINTENDO+WII+U"> Wii U</a></li>
		<li><a href="produits.php?console=NINTENDO+WII"> Wii</a></li>
	      </ul>
	    </li>
	    <li><a href="produits.php?categorie=PC">PC</a>
	    </li>
	  </ul>
	</div>
      </header>
      <div class="bloc_page">
	<div id="main_bloc">
	  <div id="filter_bar">
	    <form id="filter_form" method="get">
	      <input type="hidden" name="categorie" value="<?php
					  if (isset($_GET['categorie']))
					    echo "{$_GET['categorie']}";
					  ?>">
	      <select name="console">
		<option value="" diasabled>Veuillez choisire une console</option>
		<option value="Play Station 4">PS4</option>
		<option value="Play Station 3">PS3</option>
		<option value="Play Station 2">PS2</option>
		<option value="Play Station Portable">PSP</option>
		<option value="XBOX ONE">XBOX ONE</option>
		<option value="XBOX 360">XBOX 360</option>
		<option value="Nintendo Wii U">Wii U</option>
		<option value="Nintendo Wii">Wii</option>
		<option value="Nintendo 3DS">3DS</option>
		<option value="Nintendo DS">DS</option>
		<option value="PC">PC</option>
	      </select>
	      <select name="order">
		<option value="" diasabled>Veuillez choisire un ordre</option>
		<option value="Libelle ASC">Alphabetique(A-Z)</option>
		<option value="Libelle DESC">Alphabetique Inverse(Z-A)</option>
		<option value="Prix_vente DESC">Du plus cher au moins cher</option>
		<option value="Prix_vente ASC">Du moins cher au plus cher</option>
		<option value="Notation DESC">Du plus notes</option>
		<option value="Date_de_sortie DESC">Du plus recent</option>
		<option value="Nombres_produit_vendu DESC">Du plus vendu</option>
	      </select>
	      <input name="search" type="text" placeholder="   Mots-Clefs..."/>
	      <input class="loupe" type="submit" id="filter_button" value="Filtrer" />
	    </form>
	  </div>
	  <div id='best_seller'>
	    <?php display_articles(); ?>
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
