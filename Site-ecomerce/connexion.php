<?php
session_start();

require 'functions.php';
if (isset($_SESSION['connected']))
  header("LOCATION: index.php");

function check()
{
  $form = check_post();
  if (!empty($form))
  {
    if((strlen($form['username']) >= 4) && (strlen($form['username']) <= 14))
    {
      if((strlen($form['pass']) >= 4) && (strlen($form['pass']) <= 18))
      {
	if (check_logs($form))
	{
	  $link = connect_to_db();
	  $sql = "UPDATE Utilisateurs SET  Etat=\"Connected\" WHERE Utilisateur=\"{$form['username']}\"";
	  $query = $link->prepare( $sql );
	  $query->execute();
	  $_SESSION['connected'] = $form['username'];
	  header("LOCATION: index.php");
	}
	else
	  echo "<div id='error_msg'>Erreur: La combinaison nom d'utilisateur et mot de passe est incorrecte \n" ."</br>". "<a href=\"inscription.php\">S'inscrire ?</a></div>\n";
      }
      else
	echo "<div id='error_msg'>Erreur: Le mot de passe doit contenir entre 4 et 18 caractères</div>\n"; 
    }
    else
      echo "<div id='error_msg'>Erreur: Le nom d'utilisateur doit contenir entre 4 et 14 caractères</div>\n"; 
  }
}

function check_post()
{
  $form = "";
  if (isset($_POST['log_button']))
    {
      $form['username'] = trim(strip_tags($_POST['username']));
      $form['pass'] = trim(strip_tags($_POST['password']));
      $form['email'] = trim(strip_tags($_POST['email']));
    }
  return $form;
}
    
function check_logs($form)
{
  $hashed_pass = hash('sha512', $form['pass']);
  if(($query = connect_to_db()) !== FALSE)
  {
    $str =  "SELECT * FROM Utilisateurs WHERE Utilisateur = '{$form['username']}' AND Mot_de_pass = '{$hashed_pass}' ;";
    $sql = $query->prepare($str) ;
    $sql->execute();
    $results = $sql->fetch();
    if ($sql->rowCount() <= 0)
    {
      $sql = null;
      return 0;
    }
    $sql = null;
    if ($results['Etat'] == "Bloqued")
      header("LOCATION: bloqued.html");
    else
      return 1;
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
	    <button class="button"><a  href="connexion.php">Connexion</a></button>
	    <button class="button"><a  href="inscription.php">Inscription</a></button>
	  </div>
	</div>
	<div id="option">
	  <ul id="menu_deroulant">
	    <li><a href="categories.html">Categories</a>
	    </li>
	    <li><a href="#">Play Station</a>
	      <ul>
		<li><a href="produits.html">PS4</a></li>
		<li><a href="#">PS3</a></li>
		<li><a href="#">PS2</a></li>
		<li><a href="#">PSP</a></li>
	      </ul>
	    </li>
	    <li><a href="#">Xbox</a>
	      <ul>
		<li><a href="#">XBOX ONE</a></li>
		<li><a href="#">XBOX 360</a></li>
		<li><a href="#">XBOX</a></li>
	      </ul>
	    </li>
	    <li><a href="#">Nintendo</a>
	      <ul>
		<li><a href="#">Nintendo DS</a></li>
		<li><a href="#"> Nintendo 3DS</a></li>
		<li><a href="#"> Wii U</a></li>
		<li><a href="#"> Wii</a></li>
	      </ul>
	    </li>
	    <li><a href="#">PC</a>
	    </li>
	  </ul>
	  <div id="search_bar">
	    <form action="" name="search" method="post">
	      <input name="saisie" type="text" placeholder="   Mots-Clefs..." required />
              <input class="loupe" type="submit" value="" />
            </form>
          </div>
        </div>
      </header>
      <div class="bloc_page">
      <div id="main_bloc">
	<div class="you">
	  <h1>CONNEXION</h1>
	  <form name="log_in" id="log_in" action="#" method="post">
	    <input type="text" placeholder="Nom D'utilisateur" name="username"/></br>
	    <input type="password" placeholder="Mot de passe" name="password"/></br>
	    <input type="submit" name="log_button" value="Se Connecter"/>
	  </form>
	    <?php check();?>
	</div>
      </div>
    </div>
  </body>
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
  <footer>
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
