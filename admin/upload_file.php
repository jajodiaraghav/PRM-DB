<?php
session_start();
include_once('../common.php');
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);

if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin')
{
  if ($_FILES["file"]["error"] > 0)
  {
    echo "Error: " . $_FILES["file"]["error"];
    die;
  }
  else
  {
    $dir = __DIR__ . "/upload/" . $_FILES["file"]["name"];
    move_uploaded_file($_FILES["file"]["tmp_name"], $dir);
    
    if ($_POST['action'] == "replace")
    {    	
      $command = "TRUNCATE TABLE proteins";
      $dbh->query($command);
    }

    $command = "LOAD DATA LOCAL INFILE './upload/{$_FILES["file"]["name"]}' INTO TABLE proteins FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\\r\\n'";
    $stmt = $dbh->prepare($command);
    $stmt->execute();
    if (is_file($dir)) unlink($dir);
  }
  header('Location: ./index.php?submit=PRMHAL');
}
else
{
	echo "Error:unauthorized.";
}
