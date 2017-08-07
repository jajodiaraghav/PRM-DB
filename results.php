<?php
include_once('common.php');
include_once('partials/header.php');
?>
    <div class="container">
    	<div class="row">
    		<div class="col-md-10 col-md-offset-1">
    			<strong>Summary</strong>
	    		<div class="jumbotron">
	    		<?php
		        	$empty = True;
		        	$q = $_GET['q'];
		        	$sp = $_GET['species'];
					$s = isset($_GET['s']) ? mysqli_real_escape_string($_GET['s']) : 0;

					$query = "SELECT * FROM proteins WHERE `Protein_Name` LIKE ? AND `Species`=? LIMIT ".$s.", 10";
					$stmt = $dbh->prepare($query);
					$param = array("%$q%", "$sp");
					$stmt->execute($param);
					$cnt = $stmt->rowCount();
				?>
	    			<h5>Search Terms: <?=$q?></h5>
		    		<div class="inline">		    			
		    			<ul class="list-unstyled">
							<li><h5>Proteins Found: <?=$cnt?></h5></li>
							<li><h5>Domains Found: <?=$cnt?></h5></li>
						</ul>
						<ul class="list-unstyled">
							<li><h5>HAL Found: <?=$cnt?></h5></li>
							<li><h5>NGS Peptides Found: <?=$cnt?></h5></li>
						</ul>
						<ul class="list-unstyled">
							<li><h5>3D Structures Found: <?=$cnt?></h5></li>
							<li><h5>PWM Found: <?=$cnt?></h5></li>
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
					while ($row = $stmt->fetch()) {
						$empty = False;
		        	?>
			          	<div class="list-group-item">
			          		<img src="files/<?=$row['Protein_Name']?>_Logo.png" alt="<?=$row['Protein_Name']?>" width="30%">
			          		<span class="links">
			          			<?php if(is_file("files/{$row['Protein_Name']}_ELISA.txt")) { ?>
			          			<a href="files/<?=$row['Protein_Name']?>_ELISA.txt">HAL (ELISA Peptides)</a>
			          			<span class="seq"><?=$row['HAL']?></span>
			          			<?php } ?>
			          			<?php if(is_file("files/{$row['Protein_Name']}_SEQ.fa")) { ?>
			          			<a href="files/<?=$row['Protein_Name']?>_SEQ.fa">Top NGS Peptides</a>
			          			<span class="seq"><?=$row['NGS']?></span>
			          			<?php } ?>
			          		</span>
			          		<a href="https://www.rcsb.org/pdb/protein/<?=$row['Protein_Name']?>">
			          			<img src="files/3D/<?=$row['Protein_Name']?>.PNG" width="20%">
			          		</a>
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
				    	<span>Page 1 of 1</span>
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