<?php
session_start();
require 'functions.php';

if (!check_admin())
  header("LOCATION: index.php");

function display_users()
{
  if (isset($_POST['modify_user']))
    modify_user($_POST['login'], $_POST['group'], $_POST['etat']);

  if (isset($_POST['remove_user']))
    remove_user($_POST['login']);
  
  $link = connect_to_db();
  $sql = "SELECT U.*, R.Libelle AS grp
          FROM Utilisateurs AS U
          JOIN Role AS R ON U.Role = R.ID
          ORDER BY U.Etat ASC";
  $query = $link->prepare( $sql );
  $query->execute();
  $results = $query->fetchAll();

  foreach( $results as $row )
  {
    $grp = $row["grp"];
    $login = $row["Utilisateur"];
    $id = $row["ID"];
    if ($row["Etat"] == "Connected")
      $etat = "<div id=\"green_ground\">" . $row["Etat"] . "</div>";
    else if ($row["Etat"] == "Disconnected")
      $etat = "<div id=\"red_ground\">" . $row["Etat"] . "</div>";
    else
      $etat = "<div id=\"black_ground\">" . $row["Etat"] . "</div>";
    $email = $row["Email"];
    
    echo "<tr>\n<td>" . $email .  "</td>\n<td>" . $login  . "</td>\n<td>" . $grp . "</td>\n<td>" . $etat . "</td>\n";
    echo "<form id='user_cart' method='post' action='panier.php?ID={$id}'  accept-charset='UTF-8'>\n";
    echo "<td><input type='submit' name='cart_button' id=\"cart_button\" value='Aller Au Panier' /></form></td></tr>\n";
    echo "</tr>\n";
  }
}

function modify_user($login, $grp, $etat)
{
  $query = connect_to_db();
  $now = date("Y-m-d H:i:s");
  
  if ($grp == "Admin")
    $grp = 1;
  else if ($grp == "Client")
  $grp = 2;
  
  $str = "UPDATE Utilisateurs SET Etat=\"{$etat}\", Role=\"{$grp}\", Date_modification=\"{$now}\" WHERE Utilisateur=\"{$login}\"";
  $sql = $query->prepare($str);
  $sql->execute();
}

function remove_user($login)
{
  $query = connect_to_db();
  $str = "DELETE FROM Utilisateurs WHERE Utilisateur=\"{$login}\"";
  $sql = $query->prepare($str);
  $sql->execute();
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
		<li><a href="manage_users.php">Gestion des utilisateurs</a>
	      </ul>
	    </li>
	  </ul>
      </header>
      <div class="bloc_page">
	<div id="main_bloc">
	  <div id="users_management">
	    <div id="users_list">
	      <table class = "table_users">
		<caption>ALL USERS</caption>
		<tr><th>Email</th><th>Login</th><th>Groupe</th><th>Etat</th><th>Panier</th></tr><br>
		<?php display_users(); ?>
	      </table>
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

