<?php

$file = 'Network.csv';
header("Content-Disposition: attachment; filename='" . basename($file) . "'");
header("Content-Type: application/force-download");
header("Connection: close");

$q = $_GET['gene'];
include_once('common.php');
$query = "SELECT * FROM PPI WHERE `Protein_A` LIKE ? OR `Protein_B` LIKE ?";
$stmt = $dbh->prepare($query);
$param = array("%$q%", "%$q%");
$stmt->execute($param);

echo "ID,Protein_A,Protein_B,Score,Type\n";
while ($data = $stmt->fetch(PDO::FETCH_NUM))
{
	$str = implode(",", $data);
	echo $str . "\n";
}