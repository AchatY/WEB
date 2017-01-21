<?php
session_start();
require 'functions.php';
if (!isset($_GET['ID']))
  header("LOCATION: produits.php");

$connexion = connect_to_db();
$requete = "SELECT * FROM Utilisateurs WHERE Utilisateur = \"{$_SESSION['connected']}\"";
$ind = $connexion->prepare($requete);
$ind->execute();
$results = $ind->fetch();
if((isset($_SESSION['connected'])) && ($results['Etat'] == "Bloqued"))
  header("LOCATION: deconnexion.php?login={$_SESSION['connected']}");


function display_cart()
{
  $connexion = connect_to_db();
  $requete = "SELECT Produit_Utilisateur.Quantite AS element FROM Produits
              JOIN Produit_Utilisateur ON ID_Produit = Produits.ID 
              JOIN Utilisateurs ON ID_utilisateur = Utilisateurs.ID 
              WHERE Utilisateurs.Utilisateur = '{$_SESSION['connected']}' ;";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  foreach( $results as $row )
  {
    $nb_article = $nb_article + $row['element'];
  }
  echo $nb_article;
}

 function ajout_panier()
{
  $connexion = connect_to_db();
  $requete = "SELECT ID FROM Utilisateurs WHERE Utilisateur = '{$_SESSION['connected']}' ;";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  foreach($results as $row)
  {	
    $tmp_ID = $row['ID'];
  }
  
  if (isset($_POST['ajout_panier']))
  {
    if (isset($_SESSION['connected']))
    {
      $connexion = connect_to_db();
      $requete = "SELECT *  FROM Produit_Utilisateur  WHERE ID_produit = '{$_GET['ID']}' AND ID_Utilisateur = '{$tmp_ID}';";
      $ind = $connexion->prepare($requete);
      $ind->execute();
      $results = $ind->fetchAll();
      if (!empty($results))
      {
	$requete = "UPDATE Produit_Utilisateur SET Quantite = Quantite + 1 WHERE ID_produit = '{$_GET['ID']}'AND ID_Utilisateur = '{$tmp_ID}';";
      	$ind = $connexion->prepare($requete);
  	$ind->execute();
      }
      else
      {
  	$requete = 'INSERT INTO Produit_Utilisateur(ID_Produit, ID_Utilisateur) VALUES('. $_GET['ID'] .', '. $tmp_ID .')';
  	$ind = $connexion->prepare($requete);
  	$ind->execute();
  	
      }
      header("LOCATION: produit_detail.php?ID={$_GET['ID']} ");
    }
    else
      header("LOCATION: connexion.php");
    
  }
}

function inserer_detail()
{
  $connexion = connect_to_db();
  $requete = 'SELECT Produits.*, Categories.Logo,Categories.Libelle AS Libelle_cat, SUBSTR(Produits.Description, 1, 300) AS Description_new
        FROM Produits
        JOIN Categorie_Produit
        ON ID_Produit = Produits.ID
        JOIN Categories
        ON ID_Categorie = Categories.ID
        WHERE Produits.ID = '. $_GET['ID'];
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  return $results;
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
	    <button class="button">
	      <?php
	      if (isset($_SESSION['connected']))
	      echo "<a href=\"admin.php\">{$_SESSION['connected']}</a>";
	      else
	        echo "<a href=\"connexion.php\">Connexion</a>";?>
	    </button>
	    <button class="button">
	      <?php
	      if (isset($_SESSION['connected']))
		echo "<a  href=\"deconnexion.php?login={$_SESSION['connected']}\">DECONNEXION</a>";
	      else
	        echo "<a href=\"inscription.php\">Inscription</a>";
	      ?>
	    </button>
	    <button id="panier_button">
	      <?php
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
	    <form action = "produits.php" name="search" method="get">
	      <input name="search" type="text" placeholder="   Mots-Clefs..." required />
	      <input class="loupe" type="submit" value="" />
	    </form>
	  </div>
	</div>
      </header>
      <div class="bloc_page">
      <div class="produit">
	<div class="image_produit">
	  <?php
	  $results = inserer_detail();
	  
	  foreach($results as $row)
	  {
	    echo"<img src = '{$row['Image']}'/>";
	  }
	  ?>
	</div>
	<div class="outil_produit">
	  <div class="name_produit">
	    <?php
	    $results = inserer_detail();

	    foreach($results as $row)
	    {
	      $content  = nl2br($row["Description_new"]);
	      $Libelle = nl2br($row["Libelle"]);
	      $Libelle_cat = nl2br($row["Libelle_cat"]);
	      echo "<h1>{$Libelle} </h1>
	    <h3>Date de sortie : {$row['Date_de_sortie']} </h3>
	    <p>{$Libelle_cat}</p>
	  </div>
	  <div class='text_produit'>
	    <p>{$content} ...</p>
	  </div>";
	  }
	  ?>
	  <TABLE>
	    <TR>
	      <td><a href="#enimage"><button>EN IMAGES</button></a></td>
	      <td><a href="#information"><button>DESCRIPTION COMPLETE</button></a></td>
	    </TR>
	  </TABLE>
	  </div>
	  <?php
	  $results = inserer_detail();

	  foreach($results as $row)
	  {
	  echo"<div class='cmp_prix'>
	    <p>PRIX</p>
	  <h1> {$row['Prix_vente']}€</h1>";
	  }
	  ?>
	  <h4>200 points de fidélité
	  sur votre Carte de fidélité</h4>
	  <form method='post'>
	    <input value='ajouter au panier' type="submit" name = "ajout_panier"/>
	</br>
	<?php
	ajout_panier();
	?>
	  <h4> Paiement en CB sans frais </h4>
	  <input value='Reserver au magasin' type="submit" name = "Reserver au magasin"/>
	  </form>
	</div>
	</div>

	<?php
		$results = inserer_detail();
	
		foreach($results as $row)
			{
				$content  = nl2br($row["Description"]);
				echo "<div id='information'>
	  			<p>{$content}</p>
	  			";
			}

	?>
      </div>
      <div id="enimage">
	<MARQUEE scrolldelay="60" scrollamount="15" behavior="alternate" direction="left">
	  <IMG src="images/fifa6.jpg">
	  <IMG src="images/fifa7.jpg">
	  <IMG src="images/fifa8.jpg">
	</MARQUEE>
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
	  <li><a href="produits.php?console=">Pupi</a></li>
	  <li><a href="produits.php?console=">Mr</a></li>
	  <li><a href="produits.php?console=">MrFan</a></li>
	  <li><a href="produits.php?console=">Pupi</a></li>
	  <li><a href="produits.php?console=">Mr</a></li>
	  <li><a href="produits.php?console=">Kaiwaii</a></li>
	  <li><a href="produits.php?console=">Perceval</a></li>
	  <li><a href="produits.php?console=">Belette</a></li>
	  <li><a href="produits.php?console=">concombre</a></li>
	  <li><a href="produits.php?console=">Ptit</a></li>
	  <li><a href="produits.php?console=">MrFan</a></li>
	  <li><a href="produits.php?console=">Pupi</a></li>
	  <li><a href="produits.php?console=">Mr</a></li>
	  <li><a href="produits.php?console=">Kaiwaii</a></li>
	  <li><a href="produits.php?console=">Perceval</a></li>
	  <li><a href="produits.php?console=">Belette</a></li>
	  <li><a href="produits.php?console=">concombre</a></li>
	  <li><a href="produits.php?console=">Ptit</a></li>
	  <li><a href="produits.php?console=">MrFan</a></li>
	</ul>
      </div>
      <div id="usefullinks">
	<ul>
	  <li>
	    <a href="produits.php?console=">Informations Legales</a>
	  </li>
	  <li>
	    <a href="produits.php?console=">CGU</a>
	  </li>
	  <li>
	    <a href="produits.php?console=">Newsletter</a>
	  </li>
	  <li>
	    <a href="produits.php?console=">Contact</a>
	  </li>
	  <li>
	    <a href="produits.php?console=">F.A.Q.</a>
	  </li>
	  <li>
	    <a href="produits.php?console=">Financement</a>
	  </li>
        </ul>
      </div>
    </div>
    <div id="copyrights">
      <p>Copyright © The Game Sanctum - 2016</p>
    </div>
  </footer>
   </html>
