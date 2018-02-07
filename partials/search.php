
<?php
	$q = Isset($_GET['q']) ? $_GET['q'] : '';
	$s = isset($_GET['species']) ? $_GET['species'] : '';
	$g = isset($_GET['group']) ? $_GET['group'] : '';
?>
<form action="results.php" method="get" class="form-inline">
<input type="search" name="q" class="form-control" placeholder="Enter Domain or Protein name or ID" value="<?=$q?>">
<select class="form-control" name="species" style="width:125px">
	<?php if(empty($s)) { ?>
	<option value="" selected disabled>Species</option>
	<?php } ?>
	<?php
		$query = "SELECT DISTINCT Species FROM proteins";
		$stmt = $dbh->prepare($query);
		$stmt->execute();
		while ($row = $stmt->fetch()) {
			if (trim($row[0]) !== '') {
				if($s == $row[0])
						echo "<option value='{$row[0]}' selected>{$row[0]}</option>";
					else
						echo "<option value='{$row[0]}'>{$row[0]}</option>";
			}	
		}
	?>
</select>
<select class="form-control" name="group" style="width:180px">
	<?php if(empty($g)) { ?>
	<option value="" selected disabled>Domain Group</option>
	<?php } ?>
	<?php
			$query = "SELECT DISTINCT Domain_Group FROM proteins";
			$stmt = $dbh->prepare($query);
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				if (trim($row[0]) !== '') {
					if($g == $row[0])
						echo "<option value='{$row[0]}' selected>{$row[0]}</option>";
					else
						echo "<option value='{$row[0]}'>{$row[0]}</option>";
				}	

			}
		?>
	</select>
	<button type="submit" class="btn btn-primary">Search</button>
</form>
