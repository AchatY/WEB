<?php
session_start();
require 'functions.php';

if (!check_admin())
  header("LOCATION: personal_account.php");
function personal_information()
  {
    $connexion = connect_to_db();
    $requete = "SELECT * FROM Utilisateurs WHERE Utilisateur = '{$_SESSION['connected']}';";
    $ind = $connexion->prepare($requete);
    $ind->execute();
    $results = $ind->fetchAll();
    foreach( $results as $row )
    {
      echo "<table id='detail_personal'>
	  <caption>Mon Compte</caption>";
      echo "<tr><th> Username </th><td colspan='3'> {$row['Utilisateur']} </td></tr>";
      echo "<tr><th> Nom </th><td colspan='3'> {$row['Nom']}</td></tr>";
      echo "<tr><th> Prenom </th><td colspan='3'> {$row['Prenom']}</td></tr>";
      echo "<tr><th> Email </th><td colspan='3'> {$row['Email']}</td></tr>";
      echo "<tr><th> Date_de_naissance </th><td colspan='3'> {$row['Date_de_naissance']}</td></tr>";
      echo "<tr><th> Vilee </th><td colspan='3'> {$row['Ville']}</td></tr>";
      echo "<tr><th> Adresse </th><td colspan='3'> {$row['Adresse']}</td></tr>";
      echo "<tr><th> Code_postal </th><td colspan='3'> {$row['Code_postal']}</td></tr>";
      echo "<tr><th> Pays </th><td colspan='3'> {$row['Pays']}</td></tr>";
      echo "<tr><th> Sexe </th><td rowspan='3'> {$row['Sexe']}</td></tr>";
      echo "</table>
    <form  method='post' action = 'personal_page.php?ID={$row['ID']}'>
    <input type='submit' id = 'Edit_personal' value='Edit'/>
	</form>";
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
				     echo "<a href=\"inscription.php\">Inscription</a>";
				 ?>
	  </button>
	</div>
      </div>
      <div id="option">
	<ul id="menu_deroulant">
	  <li><a href="admin.php">Admin Page</a></li>
	  <li><a href="#">Administartion des Produits</a>
	    <ul>
	      <li><a href="add_article.php">Ajout d'article</a></li>
	      <li><a href="del_article.php">Suppression et Modification</a></li>
	    </ul>
	  </li>
	  <li><a href="#">Administration Utilisateur</a>
	    <ul>
	      <li><a href="manage_rights.php">Gestion des droits</a></li>
	      <li><a href="manage_users.php">Gestion des utilisateurs</a></li>
	    </ul>
	  </li>
	</ul>
      </div>
    </header>
    <div class="bloc_page">
      <?php
      if (isset($_POST['color_button']))
	echo "<div id=\"main_bloc\" style=\"background-color: {$_POST['color']};   opacity: 0.87;\">";
      else
	echo "<div id=\"main_bloc\">";
      ?>
	<form name="change_color" id="change_color" method="post">
	  <input type='color' name='color'/>
	  <input type='submit' name='color_button' value="Changer la couleur"/>
	</form>
	
	<?php
	personal_information();
	?>

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
