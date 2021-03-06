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
    if ((isset($_POST['modify_button'])) && (!empty($form['categorie'])) && (!empty($form['notation']))) 
      {
	modify_article($form);	
	header("LOCATION: del_article.php");
      }

  }
  else if (isset($_POST['delete_button']))
  {
    delete_article($_GET['ID']);
    header("LOCATION: del_article.php");
  }
}

function check()
{
  $form = "";
  if (isset($_POST['modify_button']))
    {
      $form['article_name'] = trim(strip_tags($_POST['article_name']));
      $form['categorie'] = trim(strip_tags($_POST['categorie']));
      $form['notation'] = trim(strip_tags($_POST['notation']));
      $form['buy_price'] = trim(strip_tags($_POST['buy_price']));
      $form['sell_price'] = trim(strip_tags($_POST['sell_price']));
      $form['nb_articles'] = trim(strip_tags($_POST['nb_articles']));
      $form['image'] = trim(strip_tags($_POST['image']));
      $form['description'] = trim(strip_tags($_POST['description']));
    }
  return $form;
}

function modify_article($form)
{
  $query = connect_to_db();
  $now = date("Y-m-d H:i:s");
  $str = "UPDATE Produits SET Libelle=\"{$form['article_name']}\", Notation=\"{$form['notation']}\", Prix_achat=\"{$form['buy_price']}\", Prix_vente=\"{$form['sell_price']}\", Nombres_produit=\"{$form['nb_articles']}\", Image=\"{$form['image']}\", Description=\"{$form['description']}\", Date_modification=\"{$now}\" WHERE ID=\"{$_GET['ID']}\"";
  $sql = $query->prepare($str);
  $sql->execute();

  $str = "SELECT ID FROM Categories WHERE Libelle = \"{$form['categorie']}\"";
  $sql = $query->prepare($str);
  $sql->execute();
  $results = $sql->fetch();
  $id_categorie = $results['ID'];
  $id_article = $_GET['ID'];

  $str = "UPDATE Categorie_Produit SET ID_categorie=\"{$id_categorie}\" WHERE ID_produit=\"{$id_article}\"";
  $sql = $query->prepare($str);
  $sql->execute();
}


function delete_article($id)
{
  $query = connect_to_db();
  $str = "DELETE FROM Produits WHERE ID='{$id}'";
  $sql = $query->prepare($str);
  $sql->execute();
}

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

  
  $requete = "SELECT Produits.*, Categories.Logo, SUBSTR(Produits.Libelle, 1, $length_limit) AS Libelle_new
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
 <a href='del_article.php?ID={$row['ID']}'><h4>{$Libelle}..</h4></a><dl><dt>Prix</dt>
<dd>{$row['Prix_vente']}€</dd><dt>Notation</dt>";
    echo "<dd>";
    $i = 0;
    while ($i < $row['Notation'])
    {
      echo "*";
      $i = $i + 1;
    }
    echo "</dd></dl>";
    echo "<div class='console_logo'><a href='categories.php'><img src={$row['Logo']}></img>
          </a></div></div></div>";
  }
}


function display_form($id)
{
	$query = connect_to_db();
	$str = "SELECT * FROM Produits WHERE ID = \"{$id}\""; 
	$sql = $query->prepare($str);
	$sql->execute();
	$results = $sql->fetch();
	echo "<div id=\"main_bloc\">
	<div class=\"you\">
	  <h1>Ajouter Un Article</h1>
	  <form name=\"rm_article\" id=\"rm_article\" action=\"#\" method=\"post\">
	    <input type=\"text\" placeholder=\"Nom du jeu\" name=\"article_name\" value=\"{$results['Libelle']}\" required/></br>CATEGORIE
	   	<select name=\"categorie\" >
	      <option value=\"Play Station 4\">PS4</option>
	      <option value=\"Play Station 3\">PS3</option>
	      <option value=\"Play Station 2\">PS2</option>
	      <option value=\"Play Station Portable\">PSP</option>
	      <option value=\"XBOX ONE\">XBOX ONE</option>
	      <option value=\"XBOX 360\">XBOX 360</option>
	      <option value=\"Nintendo Wii U\">Wii U</option>
	      <option value=\"Nintendo Wii\">Wii</option>
	      <option value=\"Nintendo 3DS\">3DS</option>
	      <option value=\"Nintendo DS\">DS</option>
	      <option value=\"PC\">PC</option>
	    </select></br>NOTATION
	    <select name=\"notation\">
	      <option selected disabled>Choisie une note</option>
	      <option value=\"1\">*</option>
	      <option value=\"2\">**</option>
	      <option value=\"3\">***</option>
	      <option value=\"4\">****</option>
	      <option value=\"5\">*****</option>
	    </select></br>
	    <input type=\"text\" placeholder=\"Prix d'achat\" name=\"buy_price\" value=\"{$results['Prix_achat']}\" required/></br>
	    <input type=\"text\" placeholder=\"Prix de vente\" name=\"sell_price\"/ value=\"{$results['Prix_vente']}\" required/></br>
	    <input type=\"text\" placeholder=\"nombe d'articles\" name=\"nb_articles\" value=\"{$results['Nombres_produit']}\" required/></br>
	    <input type=\"text\" placeholder=\"Image\" name=\"image\" value=\"{$results['Image']}\" required/></br>
	    <textarea name=\"description\" form=\"rm_article\" cols=\"60\" rows=\"10\"> {$results['Description']} required</textarea></br>
	    <input type=\"submit\" name=\"modify_button\" value=\"Modifier\"/></br>
	    <input type=\"submit\" name=\"delete_button\" value=\"Supprimer\"/></br>
	  </form>
	</div>
      </div>
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
	  <div id="filter_bar">
	    <form id="filter_form" method="get">
	      <input type="hidden" name="categorie" value="<?php
							   if (isset($_GET['categorie']))
							     echo "{$_GET['categorie']}";
							   ?>">
	      <select name="console">
		<option value="" diasabled>Veuillez choisire une console</option>
		<option value=\"Play Station 4\">PS4</option>
		<option value=\"Play Station 3\">PS3</option>
		<option value=\"Play Station 2\">PS2</option>
		<option value=\"Play Station Portable\">PSP</option>
		<option value=\"XBOX ONE\">XBOX ONE</option>
		<option value=\"XBOX 360\">XBOX 360</option>
		<option value=\"Nintendo Wii U\">Wii U</option>
		<option value=\"Nintendo Wii\">Wii</option>
		<option value=\"Nintendo 3DS\">3DS</option>
		<option value=\"Nintendo DS\">DS</option>
		<option value=\"PC\">PC</option>
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
	  <?php 
       if (isset($_GET['ID']))
       	 display_form($_GET['ID']);
       else
       {
	   echo "<div id=\"articles\">";
       	   display_articles();
	   echo "</div>";
       }
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
	</ul>
 
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
