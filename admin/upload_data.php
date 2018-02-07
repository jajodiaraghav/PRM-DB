<?php
session_start();

if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin')
{
	for ($i = 0; $i < sizeof($_FILES["files"]["name"]); $i++)
	{
		if ($_FILES["files"]["error"][$i] > 0)
		{
    		$temp = array('error' => $_FILES["files"]["name"][$i]);
    		$returnLink = array("files" => [$temp]);			
			die(json_encode($returnLink));
		}
		else
		{
			$temp = array(
				'name' => $_FILES["files"]["name"][$i],
				'type' => $_FILES["files"]["type"][$i],
				'size' => $_FILES["files"]["size"][$i]
			);
			$returnLink = array("files" => [$temp]);

			$dir = __DIR__ . "/../files/" . $_POST["folder"] . "/" . $_FILES["files"]["name"][$i];
			move_uploaded_file($_FILES["files"]["tmp_name"][$i], $dir);
			die(json_encode($returnLink));
		}
	}

}
else
{
	echo "Error: unauthorized!";
}
