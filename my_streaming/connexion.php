<?php
session_start();

require 'functions.php';
/*if (isset($_SESSION['connected']))
  header("LOCATION: index.php");*/

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
	</ul><a href = 'inscription.php' style = 'margin: auto;'>
	<img src = "images/icone_utilisateur.jpg" id = "icone_utilisateur"/></a>
	<div id="search_bar">
	  <form name="search" action="produits.php" method="get">
	    <input name="search" type="text" placeholder="   Mots-Clefs..." required />
	  </form>
        </div>
        
      </div>
    </header>
    
  <body>
    <div class="bloc_page">
      <fieldset class="inscription_container">
	  <legend><h1>CONNEXION</h1></legend>
	  <form name="log_in" id="log_in" action="#" method="post">
	    <input type="text" placeholder="Nom D'utilisateur" name="username"/></br>
	    <input type="password" placeholder="Mot de passe" name="password"/></br>
	    <input type="submit" name="log_button" value="Se Connecter"/>
	  <p><a href = 'inscription.php'>S'inscrire </a></p>
	  </form>
	  <?php check(); ?>
      </fieldset>
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

