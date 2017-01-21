<?php
require 'functions.php';
session_start();
if (isset($_SESSION['connected']))
  header("LOCATION: index.php");

function check()
{
  $form = check_post();
  if (!empty($form))
  {
    if ((check_in_db($form['username'])) && (strlen($form['username']) >= 4) && (strlen($form['username']) <= 14))
    {
      if ((check_in_db($form['email'])) && (!filter_var($form['email'], FILTER_VALIDATE_EMAIL) === false))
      {
	if (($form['pass'] == $form['check_pass']) && (strlen($form['pass']) >= 4) && (strlen($form['pass']) <= 18))
	{
	  if((strlen($form['name']) < 50) || (strlen($form['name']) >= 1))
	    {
	      if((strlen($form['first_name']) < 50) || (strlen($form['first_name']) >= 1))
	      {
		if(($form['sexe'] == "homme") || ($form['sexe'] == "femme"))
		{
		  if((strlen($form['adresse']) >= 0) && (strlen($form['adresse']) <= 100))
		  {
		    if((strlen($form['postal']) == 5) && (intval($form['postal']) != 1) && (is_int(intval($form['postal']))))
		    {
		      if((strlen($form['city']) >= 0) && (strlen($form['city']) <= 50))
		      {
			 if((strlen($form['country']) >= 0) && (strlen($form['country']) <= 50))
			{
			  add_account($form);
			  header("LOCATION: connexion.php");
			}
			else
			  echo "<div id='error_msg'>Erreur: Le nom du pays est erroné (50 caractères)</div>\n";
		      }
		      else
			echo "<div id='error_msg'>Erreur: Le nom de la ville est erroné (50 caractères)</div>\n";
		    }
		    else
		      echo "<div id='error_msg'>Erreur: Le code postal est erroné (5 caractères numériques)</div>\n";
		  }
		  else
		    echo "<div id='error_msg'>Erreur: L'adresse est erroné (maximum 100 caractères)</div>\n";
		}
		else
		  echo "<div id='error_msg'>Erreur: Le sexe est erroné (Homme ou Femme)</div>\n";
	      }
	      else
		echo "<div id='error_msg'>Erreur: Le prenom est erroné (entre 2 et 50 caractères)</div>\n";
	    }
	  else
	    echo "<div id='error_msg'>Erreur: Le nom est erroné (entre 2 et 50 caractères)</div>\n";
	}
	else
	  echo "<div id='error_msg'>Erreur: Le mot de passe et sa confirmation ne correspondent pas(entre 4 et 18 caractères)</div>\n";
      }
      else
	echo "<div id='error_msg'>Erreur: L'email est erroné ou deja utilisé" . ": " . "<a href=\"connexion.php\">Se connecter ?</a></div>\n";
    }
    else
      echo "<div id='error_msg'>Erreur: Le nom d'utilisateur est erroné ou deja utilisé (entre 4 et 14 caractères)" . ": " . "<a href=\"connexion.php\">Se connecter ?</a></div>\n";
  }
}

function check_in_db($to_check)
{
  try
  {
    if(($query = connect_to_db()) !== FALSE)
    {
      $str =  "SELECT ID FROM Utilisateurs WHERE Utilisateur = '{$to_check}' OR Email = '{$to_check}' ;";
      $sql = $query->prepare($str) ;
      $sql->execute();
      if ($sql->rowCount() <= 0)
      {
		$sql = null;
		return 1;
      }
      $sql = null;
      return 0;
    }
  }
  catch(PDOException $error)
  {
    echo "CANNOT CHECK IN DB \nERROR: " . $error->getMessage() . "\n";
    return FALSE;
  }
}


function check_post()
{
  $form = "";
  if (isset($_POST['sign_button']))
    {
      $form['username'] = trim(strip_tags($_POST['username']));
      $form['pass'] = trim(strip_tags($_POST['password']));
      $form['check_pass'] = trim(strip_tags($_POST['check_password']));
      $form['email'] = trim(strip_tags($_POST['email']));
      $form['name'] = trim(strip_tags($_POST['nom']));
      $form['sexe'] = trim(strip_tags($_POST['Sexe']));
      $form['first_name'] = trim(strip_tags($_POST['prenom']));
      $form['date'] = trim(strip_tags($_POST['naissance']));
      $form['adress'] = trim(strip_tags($_POST['adresse']));
      $form['postal'] = trim(strip_tags($_POST['postale']));
      $form['city'] = trim(strip_tags($_POST['ville']));
      $form['country'] = trim(strip_tags($_POST['pays']));
    }
  return $form;
}
    
function add_account($form)
{
  $query = connect_to_db();
  $now = date("Y-m-d H:i:s"); 
  $hashed_pass = hash('sha512', $form['pass']);
  $str = "INSERT INTO Utilisateurs (Utilisateur, Mot_de_pass, Email, Nom, Prenom, Date_de_naissance, Ville, Adresse, Code_postal, Pays, Sexe, Role, Date_creation, Date_modification) VALUES (\"{$form['username']}\", \"{$hashed_pass}\", \"{$form['email']}\", \"{$form['name']}\", \"{$form['first_name']}\", \"{$form['date']}\", \"{$form['city']}\", \"{$form['adress']}\", \"{$form['postal']}\", \"{$form['country']}\", \"{$form['sexe']}\",\"2\", \"{$now}\", \"{$now}\");";
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
	    <button class="button"><a  href="connexion.php">Connexion</a></button>
	    <button class="button"><a  href="inscription.php">Inscription</a></button>
	  </div>
	</div>
	<div id="option">
	  <ul id="menu_deroulant">
	    <li><a href="categories.php">Categories</a>
	    </li>
	    <li><a href="produits.php?categorie=Play+Station">Play Station</a>
	      <ul>
		<li><a href="produits.php?categorie=Play+Station+4">PS4</a></li>
		<li><a href="produits.php?categorie=Play+Station+3">PS3</a></li>
		<li><a href="produits.php?categorie=Play+Station+2">PS2</a></li>
		<li><a href="produits.php?categorie=Play+Station+Portable">PSP</a></li>
	      </ul>
	    </li>
	    <li><a href="produits.php?categorie=XBOX">XBOX</a>
	      <ul>
		<li><a href="produits.php?categorie=XBOX+ONE">XBOX ONE</a></li>
		<li><a href="produits.php?categorie=XBOX+360">XBOX 360</a></li>
	      </ul>
	    </li>
	    <li><a href="produits.php?categorie=Nintendo">Nintendo</a>
	      <ul>
		<li><a href="produits.php?categorie=Nintendo+DS">Nintendo DS</a></li>
		<li><a href="produits.php?categorie=Nintendo+3DS"> Nintendo 3DS</a></li>
		<li><a href="produits.php?categorie=Nintendo+Wii+U"> Wii U</a></li>
		<li><a href="produits.php?categorie=Nintendo+Wii"> Wii</a></li>
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
	<div class="you">
	  <h1>INSCRIPTION</h1>
	  <form name="sign_in" id="sign_in" action="#" method="post">
	    <p>
	      Sexe :
	      <input type="radio" name = "Sexe" Value = "homme">Homme
	      <input type="radio" name = "Sexe" Value = "femme">Femme
	    </p>
	    <input type="text" placeholder="Nom D'utilisateur" name="username"/></br>
	    <input type="password" placeholder="Mot de passe" name="password"/>
	    <input type="password" placeholder="Confirmation mot de passe" name="check_password"/></br>
	    <input type="email" placeholder="Email" name="email"/></br>
	    <input type="text" placeholder="nom" name="nom"/>
	    <input type="text" placeholder="prenom" name="prenom"/>
	    
	    <input type="date" placeholder="date de naissance" name="naissance" min="1900-01-01" /></br>
	    <input type="text" placeholder="adresse" name="adresse"/></br>
	    <input type="text" placeholder="code postal" name="postale"/>
	    <input type="text" placeholder="Ville" name="ville"/></br>
	    <input type="text" placeholder="Pays" name="pays"/></br>
	    <input type="submit" name="sign_button" value="S'inscrire"/></br>
	  </form>
	  <?php 
	  check();
	  ?>
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
