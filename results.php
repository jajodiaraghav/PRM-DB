<?php
include_once('common.php');
include_once('partials/header.php');
?>
    <div class="container">
    	<div class="row">
	        <div class="col-md-10 col-md-offset-1">
	        	<div class="list-group">
	        	<?php
	        	$q = $_GET['q'];
				$s = isset($_GET['s']) ? mysqli_real_escape_string($_GET['s']) : 0;

				$query = "SELECT * FROM proteins WHERE `Protein_Name` LIKE ? LIMIT ".$s.", 10";
				$stmt = $dbh->prepare($query);
				$param = array("%$q%");
				$stmt->execute($param);
				while ($row = $stmt->fetch()) {
	        	?>
		          	<div class="list-group-item">
		          		<img src="files/<?=$row['Protein_Name']?>_Logo.png" alt="<?=$row['Protein_Name']?>" width="30%">
		          		<span class="links">
		          			<a href="<?=$row['Protein_Name']?>_ELISA.txt">HAL (ELISA Peptides)</a>
		          			<a href="<?=$row['Protein_Name']?>_SEQ.fa">Top NGS Peptides</a>
		          		</span>
		          		<img src="files/<?=$row['Protein_Name']?>_Logo.png" alt="<?=$row['Protein_Name']?>" width="20%">
		          		<span class="links">
		          			<strong>Downloads</strong>
		          			<a href="#">Binders</a>
		          			<a href="#">PWM</a>
		          			<a href="#">Peptide Sequence</a>
		          			<a href="#">Domain Sequence</a>
		          		</span>
		          	</div>
		        <?php } ?>
	        	</div>
	        </div>
	        <div class="col-md-4 col-md-offset-4">
	        	<nav aria-label="...">
					<ul class="pager">
				    	<li><a href="#">Previous</a></li>
				    	<span>Page X of Y</span>
				    	<li><a href="#">Next</a></li>
					</ul>
				</nav>
	        </div>
  		</div>
    </div>
    <?php include_once('partials/footer.php'); ?>
	</body>
</html>