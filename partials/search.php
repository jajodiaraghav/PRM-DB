
<?php
	$q = Isset($_GET['q']) ? $_GET['q'] : '';
	$s = isset($_GET['species']) ? $_GET['species'] : '';
	$g = isset($_GET['group']) ? $_GET['group'] : '';
?>
<form action="results.php" method="get" class="form-inline">
	<input type="search" name="q" class="form-control" placeholder="Enter Domain or Protein name or ID" value="<?=$q?>">
	<select class="form-control" name="species" style="width:125px">
		<?php if(empty($s)) { ?>
		<option value="" selected disabled>Species (All)</option>
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
		<option value="" selected disabled>PRM Family (All)</option>
		<?php } ?>
		<?php
				$query = "SELECT DISTINCT Domain_Group FROM proteins";
				$stmt = $dbh->prepare($query);
				$stmt->execute();
				$all_families = [];
				while ($row = $stmt->fetch()) {
					$all_families = array_merge($all_families, explode('+', $row['Domain_Group']));
				}
				for($i = 0; $i < count($all_families); $i++) {
					$item = $all_families[$i];
					if (trim($item) !== '') {
						if($g == $item)
							echo "<option value='{$item}' selected>{$item}</option>";
						else
							echo "<option value='{$item}'>{$item}</option>";
					}
				}
			?>
	</select>
	<button type="submit" class="btn btn-primary">Search</button>
</form>
