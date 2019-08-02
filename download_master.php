<?php

$file = 'PRM_Master.csv';
header("Content-Disposition: attachment; filename=" . basename($file));
header("Content-Type: application/force-download");
header("Connection: close");

include_once('common.php');
$query = "SELECT * FROM proteins LIMIT 10000";
$stmt = $dbh->prepare($query);
$stmt->execute($param);

echo "
Primary_ID,ID,Protein_Name,Domain_Group,Domain_Number,Uniprot_ID,Domain_Begin,Domain_End,Domain_Sequence,Number_of_Logo_Peptides,No_of_Logos,Species,HAL,NGS,PDB_ID\n";
while ($data = $stmt->fetch(PDO::FETCH_NUM))
{
	$str = implode(",", $data);
	echo $str . "\n";
}
