<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="shortcut icon" href="" />
    <title>The Games Sanctum</title>
  </head>

  <body>
    <div class="bloc_page">
      <header>
	<div id="head_bloc">
	  <img src="images/header_logo.jpg"/>
	  <a href="index.html"><h1>The Games Sanctum</h1></a>
	  <div id="Logged_buttons">
	    <button class="button"><a  href="#">Youmer</a></button>
	    <button class="button"><a  href="inscription.php">Deconnexion</a></button>
	    <form action="panier.html">
	      <input class="panier" type="submit" value="3" />
	    </form>
	  </div>
	</div>
      </header>
<?php
define( 'DB_NAME', 'TGS_halli_a');
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'toor');
define( 'DB_HOST', 'localhost');
define( 'DB_TABLE', 'users');

try
{
  $connexion = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
  $requete = 'SELECT Produits.*, Categories.Logo
  FROM Produits
  JOIN Categorie_Produit
  ON ID_Produit = Produits.ID

  JOIN Categories

  ON ID_Categorie = Categories.ID

  ORDER BY Nombres_produit_vendu DESC limit 6';
  
  $ind = $connexion->prepare($requete);
  $ind->execute();
  $results = $ind->fetchAll();

  foreach( $results as $row )
  {
    $content  = nl2br($row["Discription"]);
    $Libelle = nl2br($row["Libelle"]);
              echo "                                                                                                  
            <div class='article'>                                                                                                          
            <div class='article_img'>                                                                                                      
            <img src='{$row['Image']}'></img>                                                                                               
            </div>                                                                                                                         
            <div class='price'>                                                                                                            
            <a href='produit_detail.html'><h4>{$row['Libelle']}</h4></a>                                                                   
            <dl>                                                                                                                           
            <dt>Prix</dt>                                                                                                                  
            <dd>{$row['Prix_vente']}</dd>                                                                                                  
            <dt>Notation</dt>                                                                                                              
            <dd>{$row['Notation']}</dd>                                                                                                    
            </dl>                                                                                                                          
            <div class='console_logo'>                                                                                                     
            <a href='produits.html'><img src={$row['Logo']}></img></a>                                                                     
            </div>                                                                                                                         
            </div>                                                                                                                      ";
  }
}

catch (Exception $e)
{
  echo 'Erreur : ' . $e->getMessage();
}
?>
    </div>
  </body>
</html>

