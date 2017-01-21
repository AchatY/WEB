
<?php
session_start();

require 'functions.php';
if (!check_admin())
  header("LOCATION: index.php");
else
{
  $form = check();
  if (!empty($form))
  {
    add_article($form);
    header("LOCATION: del_article.php");
  }
}

function check()
{
  $form = "";
  if (isset($_POST['add_button']))
    {
      $form['article_name'] = trim(strip_tags($_POST['article_name']));
      $form['categorie'] = trim(strip_tags($_POST['categorie']));
      $form['notation'] = trim(strip_tags($_POST['notation']));
      $form['buy_price'] = trim(strip_tags($_POST['buy_price']));
      $form['sell_price'] = trim(strip_tags($_POST['sell_price']));
      $form['nb_articles'] = trim(strip_tags($_POST['nb_articles']));
      $form['release_date'] = trim(strip_tags($_POST['release_date']));
      $form['image'] = trim(strip_tags($_POST['image']));
      $form['description'] = trim(strip_tags($_POST['description']));
    }
  return $form;
}

function add_article($form)
{
  $query = connect_to_db();
  $now = date("Y-m-d H:i:s"); 
  $str = "INSERT INTO Produits (Libelle, Notation, Prix_achat, Prix_vente, Nombres_produit, Date_de_sortie, Image, Description, Date_creation, Date_modification) VALUES (\"{$form['article_name']}\", \"{$form['notation']}\", \"{$form['buy_price']}\", \"{$form['sell_price']}\", \"{$form['nb_articles']}\", \"{$form['release_date']}\", \"{$form['image']}\", \"{$form['description']}\", \"{$now}\", \"{$now}\")";
  $sql = $query->prepare($str);
  $sql->execute();

  $str = "SELECT ID FROM Categories WHERE Libelle = \"{$form['categorie']}\"";  
  $sql = $query->prepare($str);
  $sql->execute();
  $results = $sql->fetch();
  $id_categorie = $results['ID'];

  $str = "SELECT ID FROM Produits WHERE Libelle = \"{$form['article_name']}\"";  
  $sql = $query->prepare($str);
  $sql->execute();
  $results = $sql->fetch();
  $id_article = $results['ID'];

  $str = "INSERT INTO Categorie_Produit (ID_categorie, ID_produit) VALUES ({$id_categorie}, {$id_article})";  
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
				<li><a href="manage_users.php">Gestion des utilisateurs</a></li>
	      	</ul>
	    </li>
	  </ul>
	  </div>
      </header>
      <div class="bloc_page">
       <div id="main_bloc">
	<div class="you">
	  <h1>Ajouter Un Article</h1>
	  <form name="add_article" id="add_article" action="#" method="post">
	    <input type="text" placeholder="Nom du jeu" name="article_name"/></br>
	    <input type="text" placeholder="Prix d'achat" name="buy_price"/></br>
	    <input type="text" placeholder="Prix de vente" name="sell_price"/></br>
	    <input type="text" placeholder="nombe d'articles" name="nb_articles"/></br>
	    <input type="date" placeholder="date de sortie" name="release_date" min="1900-01-01" /></br>
	    <input type="text" placeholder="Image" name="image"/><p>CATEGORIE : 
	    <select name="categorie">
	      <option selected disabled>Choisie une categorie</option>
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
	    </select>NOTATION :
	    <select name="notation">
	      <option selected disabled>Choisie une note</option>
	      <option value="1">*</option>
	      <option value="2">**</option>
	      <option value="3">***</option>
	      <option value="4">****</option>
	      <option value="5">*****</option>
	    </select></p>
	    <textarea name="description" form="add_article" rows="6" cols="48">Veuillez mettre la description de l'article ici...</textarea></br>
	    <input type="submit" name="add_button" value="Ajouter"/></br>
	  </form>
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
