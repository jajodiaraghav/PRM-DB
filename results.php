<?php
include_once('common.php');
include_once('partials/header.php');
?>
    <div class="container">
    	<div class="row">
    		<div class="col-md-10 col-md-offset-1">
    			<strong>Summary</strong>
	    		<div class="jumbotron">
	    			<h5>Search Terms: </h5>
		    		<div class="inline">		    			
		    			<ul class="list-unstyled">
							<li><h5>Proteins Found: </h5></li>
							<li><h5>Domains Found: </h5></li>
						</ul>
						<ul class="list-unstyled">
							<li><h5>HAL Found: </h5></li>
							<li><h5>NGS Peptides Found: </h5></li>
						</ul>
						<ul class="list-unstyled">
							<li><h5>3D Structures Found: </h5></li>
							<li><h5>PWM Found: </h5></li>
						</ul>
					</div>
	    		</div>
    		</div>
    	</div>
    	<div class="row">    		
	        <div class="col-md-10 col-md-offset-1">
	        	<strong>Search Results</strong>
	        	<div class="list-group">
		        	<?php
		        	$empty = True;
		        	$q = $_GET['q'];
		        	$sp = $_GET['species'];
					$s = isset($_GET['s']) ? mysqli_real_escape_string($_GET['s']) : 0;

					$query = "SELECT * FROM proteins WHERE `Protein_Name` LIKE ? AND `Species`=? LIMIT ".$s.", 10";
					$stmt = $dbh->prepare($query);
					$param = array("%$q%", "$sp");
					$stmt->execute($param);
					while ($row = $stmt->fetch()) {
						$empty = False;
		        	?>
			          	<div class="list-group-item">
			          		<img src="files/<?=$row['Protein_Name']?>_Logo.png" alt="<?=$row['Protein_Name']?>" width="30%">
			          		<span class="links">
			          			<a href="<?=$row['Protein_Name']?>_ELISA.txt">HAL (ELISA Peptides)</a>
			          			<span class="seq"><?=$row['HAL']?></span>
			          			<a href="<?=$row['Protein_Name']?>_SEQ.fa">Top NGS Peptides</a>
			          			<span class="seq"><?=$row['NGS']?></span>
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
			        <?php } if ($empty) { ?>
			        	<div class="list-group-item text-center">Nothing Found!</div>
			        <?php } ?>
	        	</div>
	        </div>
	    </div>
	    <?php if (!$empty) { ?>
	    <div class="row">
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
  		<?php } ?>
    </div>
    <?php include_once('partials/footer.php'); ?>
	</body>
</html>