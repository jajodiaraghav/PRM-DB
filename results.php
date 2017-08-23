<?php
include_once('common.php');
include_once('partials/header.php');
?>
    <div class="container">
    	<div class="row">
    		<div class="col-md-10 col-md-offset-1">
    			<h4><strong>Summary</strong></h4><hr>
	    		<div class="jumbotron">
	    		<?php
		        	$q = $_GET['q'];
		        	$sp = isset($_GET['species']) ? $_GET['species'] : '';
		        	$gr = isset($_GET['group']) ? $_GET['group'] : '';
					$s = isset($_GET['page']) ? (($_GET['page'] - 1) * 10) : '0';

					$query = "SELECT COUNT(*) FROM proteins WHERE
							(`Protein_Name` LIKE ? OR `Domain_Group` LIKE ? OR `Uniprot_ID` LIKE ?)
							AND `Species` LIKE ? AND `Domain_Group` LIKE ?";
					$stmt = $dbh->prepare($query);
					$param = array("%$q%", "%$q%", "%$q%", "%$sp%", "%$gr%");
					$stmt->execute($param);
					$total = $stmt->fetch()[0];
					$total_pages = ceil($total / 10);

					$query = "SELECT * FROM proteins WHERE
							(`Protein_Name` LIKE ? OR `Domain_Group` LIKE ? OR `Uniprot_ID` LIKE ?)
							AND `Species` LIKE ? AND `Domain_Group` LIKE ? LIMIT ?, 10";
					$stmt = $dbh->prepare($query);
					$param = array("%$q%", "%$q%", "%$q%", "%$sp%", "%$gr%", "$s");
					$stmt->execute($param);					
				?>
	    			<h5>Search Terms: <span class="text-uppercase"><?=$q?></span></h5>
		    		<div class="inline">		    			
		    			<ul class="list-unstyled">
							<li><h5>Proteins Found: <?=$total?></h5></li>
							<li><h5>Domains Found: <?=$total?></h5></li>
						</ul>
						<ul class="list-unstyled">
							<li><h5>HAL Found: <?=$total?></h5></li>
							<li><h5>NGS Peptides Found: <?=$total?></h5></li>
						</ul>
						<ul class="list-unstyled">
							<li><h5>3D Structures Found: <?=$total?></h5></li>
							<li><h5>PWM Found: <?=$total?></h5></li>
						</ul>
					</div>
	    		</div>
    		</div>
    	</div>
    	<div class="row">    		
	        <div class="col-md-10 col-md-offset-1">
	        	<h4><strong>Search Results</strong></h4><hr>
	        	<div class="list-group">
		        	<?php while ($row = $stmt->fetch()) { ?>
			          	<div class="list-group-item">
			          		<h5 class="list-group-item-heading">
			          			<strong>Protein Name: </strong><?=$row['Protein_Name']?> | 
			          			<strong>Domain Group: </strong><?=$row['Domain_Group']?> | 
			          			<strong>Uniprodt ID: </strong><?=$row['Uniprot_ID']?>
			          		</h5>    
			          		<img src="files/<?=$row['Protein_Name']?>_Logo.png" class="img-thumbnail pwm">
			          		<span class="links top-peptides">
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
			          			<img src="files/3D/<?=$row['Protein_Name']?>.PNG" class="img-thumbnail pwm">
			          		</a>
			          		<span class="links downloads">
			          			<strong>Downloads</strong>
			          			<a href="#">Interactions</a>
			          			<a href="#">PWM</a>
			          			<a href="#">Peptide Sequence</a>
			          			<a href="#">Domain Sequence</a>
			          		</span>
			          	</div>
			        <?php } if ($total == 0) { ?>
			        	<div class="list-group-item text-center">Nothing Found!</div>
			        <?php } ?>
	        	</div>
	        </div>
	    </div>
	    <?php if ($total_pages > 1) { ?>
	    <div class="row">
	        <div class="col-md-4 col-md-offset-4">
	        	<nav aria-label="...">
					<ul class="pager">
					<?php
						for ($i = 1; $i <= $total_pages; $i++)
						{ 
				            echo "<li><a href='/results.php?q={$q}&species={$sp}&group={$gr}&page={$i}'>{$i}</a></li>";
						};
					?>
					</ul>
				</nav>
	        </div>
  		</div>
  		<?php } ?>
    </div>
    <script>
    $(window).on('load', function () {
    	$('img').each(function () {
        	if (!this.complete || typeof this.naturalWidth === "undefined" || this.naturalWidth === 0) {
            	$(this).attr("src", "http://via.placeholder.com/350x150");
        	}
     	});

     	$('.top-peptides').each(function () {
        	if($.trim($(this).html()) == "") {
        		$(this).hide();
        	}
     	});
 	});
    </script>
    <?php include_once('partials/footer.php'); ?>
	</body>
</html>