<?php
function connect_to_db()
{
  $servername = "localhost";
  $username = "root";
  $password = "toor";
  $dbname = "achat_y";
  try
  {
    $mysql_link = new PDO("mysql:host=$servername", $username, $password);
    $mysql_link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mysql_link->exec("USE " . $dbname);
    return $mysql_link;
}
  catch(PDOException $error)
  {
    echo "CONNEXION FAILED \nERROR: " . $error->getMessage() . "\n";
    return FALSE;
  }
}


function check_admin()
{
	$admin = $_SESSION['connected'];
	try
  	{
    	if(($query = connect_to_db()) !== FALSE)
    	{
      		$str =  "SELECT Role FROM Utilisateurs AS u
      		JOIN Role AS r ON u.Role = r.ID
      		WHERE u.Utilisateur = '{$admin}' AND r.Libelle = 'Admin' ";
      		$sql = $query->prepare($str) ;
      		$sql->execute();
      		if ($sql->rowCount() <= 0)
      		{
				$sql = null;
				return 0;
      		}
      		$sql = null;
      		return 1;
    	}
  	}
  	catch(PDOException $error)
  	{
    	echo "CANNOT CHECK IN DB \nERROR: " . $error->getMessage() . "\n";
 	   return FALSE;
  	}
}

?>
