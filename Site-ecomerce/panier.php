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

$connexion = connect_to_db();
$requete = "SELECT * FROM Utilisateurs WHERE Utilisateur = \"{$_SESSION['connected']}\"";
$ind = $connexion->prepare($requete);
$ind->execute();
$results = $ind->fetch();
if((isset($_SESSION['connected'])) && ($results['Etat'] == "Bloqued"))
  header("LOCATION: deconnexion.php?login={$_SESSION['connected']}");

$requete = "SELECT * FROM Utilisateurs 
            JOIN Role ON Utilisateurs.Role=Role.ID
            WHERE Role.Libelle=\"Admin\" AND Utilisateurs.Utilisateur=\"{$_SESSION['connected']}\"";
$ind = $connexion->prepare($requete);
$ind->execute();
$res = $ind->fetch();
if (($results['ID']== $_GET['ID']) && ($ind->rowCount() > 0))
    {
      $disabled = "";
      $id = $_GET['ID'];
    }
else if (!isset($_GET['ID']))
    {
      $disabled = "";
      $id = $_SESSION['connected'];
    }
else
    {
      $disabled = "disabled";
      $id = $_GET['ID'];
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

function produits_panier($id)
{
  $connexion = connect_to_db();
  $requete = "SELECT  Produits.Prix_vente, Produits.Libelle, Produits.Image,  Produits.ID,Produit_Utilisateur.Quantite AS element, Produits.Nombres_produit
  FROM Produits
  JOIN Produit_Utilisateur 
  ON ID_Produit = Produits.ID 
  JOIN Utilisateurs 
  ON ID_utilisateur = Utilisateurs.ID
  WHERE (Utilisateurs.Utilisateur = '{$id}' OR Utilisateurs.ID = '{$id}') AND (Produits.Libelle LIKE '%{$_GET['search']}%');";

  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  return $results;  
}

function produits_panier_logo($ID)
{
  $connexion = connect_to_db();
  $requete = "SELECT Categories.Libelle AS Logo
  	FROM Produits
  	JOIN Categorie_Produit
  	ON ID_Produit = Produits.ID
  	JOIN Categories
  	ON ID_Categorie = Categories.ID
  	WHERE Produits.ID = '{$ID}'";

  $ind = $connexion->prepare($requete);
  $ind->execute();
  $logo = $ind->fetchAll();
  return $logo;
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
	    	session_start();
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
	</div>
      </header>
      
      <div class="bloc_page">
	<div id="main_bloc">
	  <div id="search_panier">
	    <form name="search" action="panier.php" method="get">
	      <input name="search" type="text" placeholder="   Mots-Clefs(Panier)..." required />
              <input  type="submit" value="Search"/>
            </form>
	  </div>
	  <?php
	  if (isset($_POST['nb_element']))
	    header("LOCATION: modif_element.php?ID={$_POST['article_id']}&element={$_POST['nb_element']}");
	  $results = produits_panier($id);
	  $total = 0;
	  $nb_article = 0;
	  foreach( $results as $row )
	  {
       	    $prix_ttc = $row['Prix_vente'];
    	    $prix_ttc += ($row['Prix_vente']  * 20) / 100 ;
	    $total = $total + ($prix_ttc * $row['element']);
	    $nb_article = $nb_article + $row['element'];
	    echo "<table class='tab'>
		<thead>
	  <tr>
	  	<th>{$row['Libelle']}</th>
	  	<th>Prix HT</th>
	    <th>Prix TTC</th>
	    <th>Quantite</th>
	  </tr>
	</thead>
	<tbody>
	  <tr>
	  	<td rowspan=2><img src = '{$row['Image']}'/></td>
	    <td>{$row['Prix_vente']}</td>
	    <td>{$prix_ttc}</td>";
       
       echo "<td>{$_GET['error']}</br></br><form method = 'Post'>
	<input type='text' value = '{$row['element']}' id = 'input_element' name='nb_element'". $disabled ."/> element (s)
	<input type='hidden' value = '{$row['ID']}' name='article_id'/> 
	</form></br>il reste {$row['Nombres_produit']} on stock
              </td>";
       	echo " </tr>
	</tbody>

	<tfoot>
	  <tr>";
       
       $logo = produits_panier_logo($row['ID']);
       foreach ( $logo as $categorie )
       {
	 echo "<td>{$categorie['Logo']}</td>";
       }
       echo "<td colspan=3>
	    	<form name='suprimer_produits' method = 'post' action = 'supprimer_panier.php?ID={$row['ID']}'>
	    		<input Value  = 'Suprimer' type = 'submit' name = 'suprimer_produits' id = 'suprimer_produits'". $disabled . "/>
	    	</form>
		</td>
	  </tr>
	</tfoot>
	</table>";
	}
	echo "<div id = 'payer'> 
	<h2>Total ( {$nb_article} articles):</h2>
		<h3>EUR  $total</h3>";
	if ($disabled == "")
	  {
		echo "<form name='payer' method='post' action = '#'>
			<input name='payer' value='Passer la commande' type='submit'/> 
		</form>
		</div>";
	  }
	?>
      </div>
     </div>
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
