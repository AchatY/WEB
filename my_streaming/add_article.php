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
  if (isset($_POST['modify_button']))
    {
      $form['article_name'] = trim(strip_tags($_POST['article_name']));
      $form['Realisateur'] = trim(strip_tags($_POST['Realisateur']));
      $form['notation'] = trim(strip_tags($_POST['notation']));
      $form['Acteurs'] = trim(strip_tags($_POST['Acteurs']));
      $form['image'] = trim(strip_tags($_POST['image']));
      $form['description'] = trim(strip_tags($_POST['description']));
    }
  return $form;
}

function add_article($form)
{
  $query = connect_to_db();
  $now = date("Y-m-d H:i:s"); 
  $str = "INSERT INTO Produits (Libelle, Notation, Images, Discription, Realisateur, Acteurs) VALUES (\"{$form['article_name']}\", \"{$form['notation']}\", \"{$form['image']}\", \"{$form['description']}\", \"{$form['Realisateur']}\", \"{$form['Acteurs']}\"";
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
	  <div id = "CineToday">
	    <IMG src = "images/logo.png" id = 'logo'/>
	    <a href = 'index.php'><p>CineToday</p></a>
	  </div>
	  <ul id = 'list_option'>
	    <li id = "active" class = "element_option"><a href = 'Films.php'>Films</a></li>
	    <li class = "element_option"><a href = 'Series.php'>Series</a></li>
	    <li class = "element_option">Animes</li>
	    <li class = "element_option">Emissions</li>
	  </ul>
	  <?php
	  if (isset($_SESSION['connected']))
	  {
	              echo "<ul id = 'text_connected'><li><a href = 'admin.php'>{$_SESSION['connected'][0]}</a><ul><li id = 'text_deconection'><a href = 'deconnexion.php?login={$_SESSION['connected']} '>déconnection</a></li></ul></li></ul>";
	    }
	    else
	            echo "<a href = 'connexion.php' style = 'margin: auto;'><img src = 'images/icone_utilisateur.jpg' id = 'icone_utilisateur'/></a>";
	  ?>
	  <div id="search_bar">
	    <form name="search" action="produits.php" method="get">
	      <input name="search" type="text" placeholder="   Mots-Clefs..." required />
	    </form>
	  </div>

	</div>
      </header>
      <div class="bloc_page">
	  <div id="filter_bar">
	    <form id="search_bar" method="get" style = 'margin:auto;'>
	      <input name="search" type="text" placeholder="   Mots-Clefs..."/>
	    </form>
	  </div>
	  <div id="main_bloc">
	<fieldset class="you">
	  <legend><h1>Ajouter Un Article</h1></legend>
	  <form name="rm_article" id="rm_article" action="#" method="post">
	    <input type="text" placeholder="Titre" name="article_name"  required/>
</br>
<input type="text" placeholder="Realisateur" name="Realisateur"  required/>
</br>
<input type="text" placeholder="Acteurs" name="Acteurs" required/>
</br> NOTATION
<select name="notation">
  <option selected disabled>Choisie une note</option>
  <option value="1">*</option>
  <option value="2">**</option>
  <option value="3">***</option>
  <option value="4">****</option>
  <option value="5">*****</option>
</select></br>
<input type="text" placeholder="Image" name=\"image\"  required/></br>
<textarea name="description" form="rm_article" cols="60" rows="10">  required</textarea></br>
<input type="submit" name="delete_button" Value = 'Ajouter'></br>
	  </form>
	  </div>
	</fieldset>
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
