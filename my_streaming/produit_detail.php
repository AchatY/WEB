<?php
session_start();
require 'functions.php';

function display_films_attendu()
{
  $connexion = connect_to_db();
  $requete = "SELECT Produits.Images,Produits.Libelle,Produits.Notation 
FROM Produits
JOIN Produit_Categorie
ON Produits.ID = ID_produit
JOIN Categories
ON Categories.ID = ID_categorie 
WHERE Categories.Libelle = 'Films'
ORDER BY Produits.Notation DESC LIMIT 5";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  
  foreach( $results as $row )
  {
    echo "<div class = 'block_films_attendu'><IMG src='{$row['Images']}' class = 'img_film_attendu'></img>\n";
    echo "<div style = 'margin: auto;'><span style = 'display: block;'> {$row['Libelle']}</span><div style = 'text-align: center;'>";
    while ($row['Notation'] > 0)
    {
      echo "<img src = 'images/etoile.png' class = 'etoile_notation'/>";
      $row['Notation']--;
    }
    echo "</div></div></div>";
  }
}

function display_comments()
{
  $connexion = connect_to_db();
  $requete = "SELECT Utilisateurs.Nom, Commentaire.Contenue 
FROM Produits
JOIN Commentaire
ON Produits.ID = ID_Produit
JOIN Utilisateurs
ON Utilisateurs.ID = ID_Utilisateur 
WHERE Produits.ID = {$_GET['ID']}";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  foreach( $results as $row )
  {
    echo "<fieldset class = 'contenue_commentaire'><legend class = 'nom_commentaire'>{$row['Nom']}</legend><p>{$row['Contenue']}</p></fieldset>";
  }
}

function check_genre()
{
  $connexion = connect_to_db();
  $requete = "SELECT Sous_Categories.Libelle  FROM Produits
JOIN Produits_Sous_Categories
ON Produits.ID = Produits_Sous_Categories.ID_Produit
JOIN Sous_Categories
ON Sous_Categories.ID =  Produits_Sous_Categories.ID_Sous_Categories
WHERE Produits.ID = {$_GET['ID']}";
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  $str = "";
  foreach ($results as $row)
  {
    $str .= $row['Libelle'];
    $str .= " ";
  }
  return $str;
}

function insert_comment()
{
  if (isset($_POST['comment']))
  {
    $connexion = connect_to_db();
    $requete = "SELECT ID FROM Utilisateurs WHERE Utilisateur = \"{$_SESSION['connected']}\"";
    $ind = $connexion->prepare($requete);
    $ind->execute();
    $results = $ind->fetchAll();
    foreach ($results as $row)
    {
      $ID = $row['ID'];	
    }
    
      $requete = "INSERT INTO `Commentaire` (`ID_Utilisateur`, `ID_Produit`, `Contenue`) VALUES
({$ID},{$_GET['ID']}, \"{$_POST['comment_text']}\")";
      $ind = $connexion->prepare($requete);
      $ind->execute();
      header("LOCATION: produit_detail.php?ID={$_GET['ID']}");
  }
  
}



function insert_notation($str, $nb)
{
  if (isset($_POST[$str]))
  {
    $connexion = connect_to_db();
    $requete = "SELECT ID FROM Utilisateurs WHERE Utilisateur = \"{$_SESSION['connected']}\"";
    $ind = $connexion->prepare($requete);
    $ind->execute();
    $results = $ind->fetchAll();
    foreach ($results as $row)
    {
      $ID = $row['ID'];	
    }
    $requete = "SELECT * FROM Notation WHERE ID_Utilisateurs = {$ID} AND ID_Produit = {$_GET['ID']}";
    $ind = $connexion->prepare($requete);
    $ind->execute();
    $results = $ind->fetchAll();
    foreach ($results as $row)
    {
      $tmp = $row['ID_Utilisateurs'];	
    }
    if (!isset($tmp))
    {
      $requete = "INSERT INTO `Notation` (`ID_Utilisateurs`, `ID_Produit`, `Notation`) VALUES
({$ID},{$_GET['ID']}, {$nb})";
      $ind = $connexion->prepare($requete);
      $ind->execute();
      $requete = "SELECT count(ID_Produit) AS NB, SUM(Notation) AS Somme FROM Notation WHERE ID_Produit = {$_GET['ID']}";
      $ind = $connexion->prepare($requete);
      $ind->execute();
      $results = $ind->fetchAll();
      foreach ($results as $row)
      {
	$moyenne = $row['Somme'] / $row['NB'];
	$moyenne = round($moyenne);   
      }
      if (isset($moyenne))
	{
	  $requete = "UPDATE Produits SET Notation = {$moyenne} Where ID = {$_GET['ID']}";
	  $ind = $connexion->prepare($requete);
	  $ind->execute();
	  header("LOCATION: produit_detail.php?ID={$_GET['ID']}");
	}
      header("LOCATION: produit_detail.php?ID={$_GET['ID']}");
    }
    header("LOCATION: produit_detail.php?ID={$_GET['ID']}");
  }
}

function inserer_detail()
{
  $connexion = connect_to_db();
  $requete = 'SELECT Produits.*,SUBSTR(Produits.Discription, 1, 1680) AS Discription_new
        FROM Produits
        JOIN Produit_Categorie
        ON ID_Produit = Produits.ID
        JOIN Categories
        ON ID_Categorie = Categories.ID
        WHERE Produits.ID = '. $_GET['ID'];
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();
  return $results;
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
	</ul>
	  <?php
	  if (isset($_SESSION['connected']))
	  {
	    echo "<ul id = 'text_connected'><li><a href = 'del_artcile.php'>{$_SESSION['connected'][0]}</a><ul><li id = 'text_deconection'><a href = 'deconnexion.php?login={$_SESSION['connected']} '>déconnection</a></li></ul></li></ul>";
	  }
	  else 
	echo "<a href = 'connexion.php' style = 'margin: auto;'>
	  <img src = 'images/icone_utilisateur.jpg' id = 'icone_utilisateur'/>
	</a>";
	?>
	<div id="search_bar">
	  <form name="search" action="produits.php" method="get">
	    <input name="search" type="text" placeholder="   Mots-Clefs..." required />
	  </form>
        </div>
        
      </div>
    </header>
  <body>
    <div class="bloc_page">
    	<?php
	  $results = inserer_detail();
	  
	  foreach($results as $row)
	  {
	    echo"<p id = 'titre_du_film'>{$row['Libelle']}</p>";
	  }

	  ?>
    	
    	<div style = 'display: flex;justify-content: space-between;'>
    <div class="produit">
    <div style = 'display:flex;'>
	<div class="image_produit">
	  <?php
	  $results = inserer_detail();
	  
	  foreach($results as $row)
	  {
	    echo"<img src = '{$row['Images']}'/>";
	  }
	  ?>
	</div>
	<div class="outil_produit">
	  <div class="name_produit">
	    <?php
	    $results = inserer_detail();
	    $genre = check_genre();
	    foreach($results as $row)
	    {
	      
	      echo "
	    <h3>Date de sortie : {$row['Date_de_sortie']} </h3>
	    <h3> De : {$row['Realisateur']}</h3>
	    <h3> Avec : {$row['Acteurs']} </h3>
	    <h3> Genre : {$genre}</h3>
	    </h3><h3> Nationalité: {$row['Nationalité']} </h3>
	    <h3> Notation: ";
	    while ($row['Notation'] > 0)
    	{
      		echo "<img src = 'images/etoile.png' class = 'etoile_notation_detail'/>";
      		$row['Notation']--;
    	}

	    
	    echo "</h3><button id = 'bande_annonce'><a href = {$row['Bande-annonce']}>Bande_annonce</a></button>
	  </div>";
	  	  }
	  ?>
	</div>
</div>
<div>
<?php
	$results = inserer_detail();

	 foreach($results as $row)
	 {
	 	echo "<p class = 'titre_princ'>SYNOPSIS ET DÉTAILS</p>";
	    echo "<p id = 'text_produit'>{$row['Discription_new']} ...</p>";
	 }
?>
</div>
<div id = 'commentaires'>
	<p class = 'titre_princ'>Commentaires</p>
	<?php 
	display_comments(); 
	?>
	<form method = 'post'>
		<input type = 'text' value = 'Ajouter un commentaire' name = 'comment_text'/>
		<input type = 'submit' Value = 'Commenter' name = 'comment'/>
	</form>
	<?php insert_comment(); ?>
</div>
<div id = 'Notation'>
	<p class = 'titre_princ'>Notation</p>
	<div class="rating">
	  <form method = 'post'>
   	    <input value = '☆' type = 'submit' Name = 'notation5'/>
   	    <input value = '☆' type = 'submit' Name = 'notation4'/>
   	    <input value = '☆' type = 'submit' Name = 'notation3'/>
   	    <input value = '☆' type = 'submit' Name = 'notation2'/>
   	    <input value = '☆' type = 'submit' Name = 'notation1'/>
   	  </form>
	  <?php
	  insert_notation('notation1', '1');
	  insert_notation('notation2', '2');
	  insert_notation('notation3', '3');
	  insert_notation('notation4', '4');
	  insert_notation('notation5', '5');
	  ?>
	</div>
	
</div>


</div>
<div>
	 <p id = 'titre_films_attendu'>Best Films</p>
	      <div id = "films_attendu">
		<?php display_films_attendu(); ?>
	      </div>
	    </div>	
	</div>

	<?php
		/*$results = inserer_detail();
	
		foreach($results as $row)
			{
				$content  = nl2br($row["Description"]);
				echo "<div id='information'>
	  			<p>{$content}</p>
	  			";
			}*/

	?>
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

