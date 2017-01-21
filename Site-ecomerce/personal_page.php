<?php
session_start();
require 'functions.php';

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


function check()
{
  $form = check_post();
  if (!empty($form))
  {
    if ((check_in_db($form['email'])) && (!filter_var($form['email'], FILTER_VALIDATE_EMAIL) === false))
    {
      if ($form['pass'] == $form['check_pass'])
      {
	change_account($form);
	header("LOCATION: index.php");
      }
      else
	echo "<div id='error_msg'>Password and his confirmation doesn't match</div>\n";
    }
    else
      echo "<div id='error_msg'>Email not valide or already used" . "<a href=\"connexion.php\">Log in ?</a></div>\n";
  }
}

function check_in_db($to_check)
{
  try
  {
    if(($query = connect_to_db()) !== FALSE)
    {
      $str =  "SELECT * FROM Utilisateurs WHERE Utilisateur = '{$_SESSION['connected']}' ;";
      $sql = $query->prepare($str) ;
      $sql->execute();
      $results = $sql->fetch();
      
      $str =  "SELECT ID FROM Utilisateurs WHERE Email = '{$to_check}' ;";
      $sql = $query->prepare($str) ;
      $sql->execute();
      if (($sql->rowCount() <= 0) || ($results['Email'] == $to_check))
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
  if (isset($_POST['change_button']))
  {
    $form['login'] = trim(strip_tags($_POST['username']));
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


function change_account($form)
{
  $query = connect_to_db();
  $now = date("Y-m-d H:i:s");

  if (!empty($form['pass']))
  {
    $hashed_pass = hash('sha512', $form['pass']);
    $str = "UPDATE Utilisateurs SET Mot_de_pass=\"{$hashed_pass}\" WHERE ID=\"{$_GET['ID']}\";";
    $sql = $query->prepare($str);
    $sql->execute();
  }
  $str = "UPDATE Utilisateurs SET Email=\"{$form['email']}\", Nom=\"{$form['name']}\", Prenom=\"{$form['first_name']}\", Date_de_naissance=\"{$form['date']}\", Ville=\"{$form['city']}\", Adresse=\"{$form['adress']}\", Code_postal=\"{$form['postal']}\", Pays=\"{$form['country']}\", Sexe=\"{$form['sexe']}\", Date_modification=\"{$now}\" WHERE ID=\"{$_GET['ID']}\";";
  $sql = $query->prepare($str);
  $sql->execute();
}

function display_form($id)
{
  $query = connect_to_db();
  
  $str = "SELECT * FROM Utilisateurs WHERE ID = \"{$id}\"";
  $sql = $query->prepare($str);
  $sql->execute();
  $results = $sql->fetch();
  if ($results['Utilisateur'] != $_SESSION['connected'])
    header("LOCATION: index.php");
  echo "<div class=\"you\">                                                                                                                            
            <h1>Modifier vos Donnees personnelles</h1>
	    <form name=\"change_logs\" id=\"change_logs\" action=\"#\" method=\"post\">
	      <p>
		Sexe :
		<input type=\"radio\" name = \"Sexe\" Value = \"homme\" required>Homme
		<input type=\"radio\" name = \"Sexe\" Value = \"femme\">Femme
	      </p>
	      <input type=\"text\" placeholder=\"Nom D'utilisateur\" name=\"username\" value=\"{$results['Utilisateur']}\" /></br>
	      <input type=\"password\" placeholder=\"Mot de passe\" name=\"password\"/>
	      <input type=\"password\" placeholder=\"Confirmation mot de passe\" name=\"check_password\"/></br>
	      <input type=\"email\" placeholder=\"Email\" name=\"email\" value=\"{$results['Email']}\" required/></br>
	      <input type=\"text\" placeholder=\"nom\" name=\"nom\" value=\"{$results['Nom']}\" required/>
	      <input type=\"text\" placeholder=\"prenom\" name=\"prenom\" value=\"{$results['Prenom']}\" required/>
	      
	      <input type=\"date\" placeholder=\"date de naissance\" name=\"naissance\" min=\"1900-01-01\" value=\"{$results['Date_de_naissance']}\" required/></br>
	      <input type=\"text\" placeholder=\"adresse\" name=\"adresse\" value=\"{$results['Adresse']}\" required/></br>
	      <input type=\"text\" placeholder=\"code postal\" name=\"postale\"value=\"{$results['Code_postal']}\" required/>
	      <input type=\"text\" placeholder=\"Ville\" name=\"ville\"value=\"{$results['Ville']}\" required/></br>
	      <input type=\"text\" placeholder=\"Pays\" name=\"pays\" value=\"{$results['Pays']}\" required/></br>
	      <input type=\"submit\" name=\"change_button\" value=\"Changer\"/></br>
	    </form>          
                </div>";
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
    <?php
    if (check_admin())
    {
    echo "<header>
      <div id='head_bloc'>
	<img src='images/header_logo.jpg'/>
	<a href='index.php'><h1>The Games Sanctum</h1></a>
	<div id='Logged_buttons'>
	  <button class='button'>";
				   if (isset($_SESSION['connected']))
				     echo "<a href=\"admin.php\">{$_SESSION['connected']}</a>";
				   else
				     echo "<a href=\"connexion.php\">Connexion</a>";
	    echo "</button>
	    <button class='button'>";
				   if (isset($_SESSION['connected']))
				     echo "<a  href=\"deconnexion.php?login={$_SESSION['connected']}\">DECONNEXION</a>";
				   else
				     echo "<a href=\"inscription.php\">Inscription</a>";
	    echo "</button>
	</div>
      </div>
      <div id='option'>
	<ul id='menu_deroulant'>
	  <li><a href='admin.php'>Admin Page</a></li>
	  <li><a href='admin_articles.php'>Administartion des Produits</a>
	    <ul>
	      <li><a href='add_article.php'>Ajout d'article</a></li>
	      <li><a href='del_article.php'>Suppression et Modification</a></li>
	    </ul>
	  </li>
	  <li><a href='#'>Administration Utilisateur</a>
	    <ul>
	      <li><a href='manage_rights.php'>Gestion des droits</a></li>
	      <li><a href='manage_users.php'>Gestion des utilisateurs</a></li>
	    </ul>
	  </li>
	</ul>
      </div>
    </header>";
    }
    else
    {
      echo "<header>
	<div id='head_bloc'>
	  <img src='images/header_logo.jpg'/>
	  <a href='index.php'><h1>The Games Sanctum</h1></a>
	  <div id='Logged_buttons'>
	    <button class='button'>";
				   if (isset($_SESSION['connected']))
				     echo "<a href=\"admin.php\">{$_SESSION['connected']}</a>";
				   else
				     echo "<a href=\"connexion.php\">Connexion</a>";
	    echo "</button>
	    <button class='button'>";
				   if (isset($_SESSION['connected']))
				     echo "<a  href=\"deconnexion.php?login={$_SESSION['connected']}\">DECONNEXION</a>";
				   else
				     echo "<a href=\"inscription.php\">Inscription</a>";
	    echo "</button>
	    <button id='panier_button'>";
				   if (isset($_SESSION['connected']))
				   {				     
				     echo "<img src='images/panier.jpg'/><a href=\"panier.php\">  ";
				     echo display_cart();
				     echo " Articles </a>";
				   }
				   else
				     echo "<img src='images/panier.jpg'/><a href=\"connexion.php\">PANIER</a>";
				   
	    echo "</button>
	  </div>
	</div>
	<div id='option'>
	  <ul id='menu_deroulant'>
	    <li><a href='categories.php'>Categories</a>
	    </li>
	    <li><a href='produits.php?categorie=Play+Station'>Play Station</a>
	      <ul>
		<li><a href='produits.php?console=Play+Station+4'>PS4</a></li>
		<li><a href='produits.php?console=Play+Station+3'>PS3</a></li>
		<li><a href='produits.php?console=Play+Station+2'>PS2</a></li>
		<li><a href='produits.php?console=Play+Station+Portable'>PSP</a></li>
	      </ul>
	    </li>
	    <li><a href='produits.php?categorie=XBOX'>XBOX</a>
	      <ul>
		<li><a href='produits.php?console=XBOX+ONE'>XBOX ONE</a></li>
		<li><a href='produits.php?console=XBOX+360'>XBOX 360</a></li>
	      </ul>
	    </li>
	    <li><a href='produits.php?categorie=Nintendo'>Nintendo</a>
	      <ul>
		<li><a href='produits.php?console=Nintendo+DS'>Nintendo DS</a></li>
		<li><a href='produits.php?console=Nintendo+3DS'> Nintendo 3DS</a></li>
		<li><a href='produits.php?console=Nintendo+Wii+U'> Wii U</a></li>
		<li><a href='produits.php?console=Nintendo+Wii'> Wii</a></li>
	      </ul>
	    </li>
	    <li><a href='produits.php?categorie=PC'>PC</a>
	    </li>
	  </ul>

	  <div id='search_bar'>
	    <form name='search' action='produits.php' method='get'>
	      <input name='search' type='text' placeholder='   Mots-Clefs...' required />
              <input class='loupe' type='submit' value=''/>
	    </form>
          </div>
        </div>
      </header>";
    }
    ?>
    <div class='bloc_page'>
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
	  display_form($_GET['ID']);
	  check();
	  ?>
      </div>
    </div>
 </body>
 <footer>
  </footer>
</html>
