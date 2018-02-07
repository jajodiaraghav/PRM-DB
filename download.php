<?php

$file = 'Network.csv';
header("Content-Disposition: attachment; filename='" . basename($file) . "'");
header("Content-Type: application/force-download");
header("Connection: close");

$q = $_GET['gene'];
include_once('common.php');
$query = "SELECT * FROM PPI WHERE `Domain_Protein` LIKE ?";
$stmt = $dbh->prepare($query);
$param = array("%$q%");
$stmt->execute($param);

echo "
Domain Protein,Domain Protein ID,Domain,Peptite Protein,Peptite Protein ID,PWM,Peptide Sequence,Start,End,Score\n";
while ($data = $stmt->fetch(PDO::FETCH_NUM))
{
	$str = implode(",", $data);
	echo $str . "\n";
}
