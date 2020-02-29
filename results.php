<?php
include_once('common.php');
include_once('partials/header.php');
?>
    <div class="container">
    	<div class="row">
    		<div class="col-md-8 col-md-offset-2">
    			<?php include_once('partials/search.php'); ?>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-10 col-md-offset-1">
    			<h4><strong>Summary</strong></h4><hr>
	    		<div class="jumbotron">
	    		<?php
		        	$q = $_GET['q'];
		        	$sp = isset($_GET['species']) ? $_GET['species'] : '';
		        	$gr = isset($_GET['group']) ? $_GET['group'] : '';
		        	$page = isset($_GET['page']) ? $_GET['page'] : '1';
					$s = isset($_GET['page']) ? (($_GET['page'] - 1) * 10) : '0';

					$query = "SELECT COUNT(*) FROM proteins WHERE
							(`Protein_Name` LIKE ? OR `Domain_Group` LIKE ? OR `Uniprot_ID` LIKE ?)
							AND `Species` LIKE ? AND `Domain_Group` LIKE ?";
					$stmt = $dbh->prepare($query);
					$param = array("%$q%", "%$q%", "%$q%", "%$sp%", "%$gr%");
					$stmt->execute($param);
					$total = $stmt->fetch()[0];
					$total_pages = ceil($total / 10);

					$query = "SELECT COUNT(DISTINCT `Uniprot_ID`) FROM proteins WHERE
							(`Protein_Name` LIKE ? OR `Domain_Group` LIKE ? OR `Uniprot_ID` LIKE ?)
							AND `Species` LIKE ? AND `Domain_Group` LIKE ?";
					$stmt = $dbh->prepare($query);
					$stmt->execute($param);
					$total_proteins = $stmt->fetch()[0];

					$query = "SELECT COUNT(DISTINCT `Protein_Name`) FROM proteins WHERE
							(`Protein_Name` LIKE ? OR `Domain_Group` LIKE ? OR `Uniprot_ID` LIKE ?)
							AND `Species` LIKE ? AND `Domain_Group` LIKE ?";
					$stmt = $dbh->prepare($query);
					$stmt->execute($param);
					$total_pwms = $stmt->fetch()[0];

					$query = "SELECT COUNT(DISTINCT `Domain_Group`) FROM proteins WHERE
							(`Protein_Name` LIKE ? OR `Domain_Group` LIKE ? OR `Uniprot_ID` LIKE ?)
							AND `Species` LIKE ? AND `Domain_Group` LIKE ?";
					$stmt = $dbh->prepare($query);
					$stmt->execute($param);
					$total_families = $stmt->fetch()[0];

					$query = "SELECT * FROM proteins WHERE
							(`Protein_Name` LIKE ? OR `Domain_Group` LIKE ? OR `Uniprot_ID` LIKE ?)
							AND `Species` LIKE ? AND `Domain_Group` LIKE ? LIMIT ?, 10";
					$stmt = $dbh->prepare($query);
					$param = array("%$q%", "%$q%", "%$q%", "%$sp%", "%$gr%", "$s");
					$stmt->execute($param);					
				?>
					<table class="table table-condensed">
						<tbody>
							<tr>
								<td style="border: none;"><h5>Search Terms: <span class="text-uppercase"><?=$q?></span></h5></td>
								<td style="border: none;"><h5>Species: <span class="text-uppercase"><?=$sp?></span></h5></td>
								<td style="border: none;"><h5>PRM Family: <span class="text-uppercase">
									<?php if(empty($gr)) { ?>
										<?=$total_families.' found'?>
									<?php } else { ?>
										<?=$gr?>
									<?php } ?>
								</span></h5></td>
							</tr>
							<tr>
								<td style="border: none;"><h5>Proteins Found: <?=$total_proteins?></h5></td>
								<td style="border: none;"><h5>Domains Found: <?=$total?></h5></td>
								<td style="border: none;"><h5>PWM Found: <?=$total_pwms?></h5></td>
							</tr>
						<tbody>
					</table>
	    		</div>
    		</div>
    	</div>
    	<div class="row">
	        <div class="col-md-10 col-md-offset-1">
	        	<h4><strong>Search Results</strong></h4><hr>

				<?php if ($total_pages > 1) { ?>
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<nav aria-label="...">
								<ul class="pager">
									<?php $link = "results.php?q={$q}&species={$sp}&group={$gr}&page="; ?>
									<li><a href='<?=$link.'1'?>'>First</a></li>
									<?php if(($page) > 1) { ?>
										<li><a href='<?=$link.strval($page - 1)?>'>Previous</a></li>
									<?php } ?>
									<li>Page <?=$page?> of <?=$total_pages?></li>
									<?php if(($page) < $total_pages) { ?>
										<li><a href='<?=$link.strval($page + 1)?>'>Next</a></li>
									<?php } ?>
									<li><a href='<?=$link.$total_pages?>'>Last</a></li>
								</ul>
							</nav>
						</div>
					</div>
				<?php } ?>

	        	<div class="list-group">
		        	<?php while ($row = $stmt->fetch()) { ?>
		          		<h5 class="list-group-item-heading">
		          			<strong>PRM Definition: </strong><?=$row['Protein_Name'].' '.$row['Domain_Begin'].'-'.$row['Domain_End']?> | 
		          			<!-- <strong>Protein Domain Name: </strong><?=$row['Protein_Name'].'_'.$row['Domain_Group'].$row['Domain_Number']?> |  -->
		          			<strong>Family: </strong><?=$row['Domain_Group']?> | 
		          			<strong>UNIPROT ID: </strong><a href="http://www.uniprot.org/uniprot/<?=$row['Uniprot_ID']?>" target="_blank"><?=$row['Uniprot_ID']?></a>
		          		</h5>
			          	<div class="list-group-item">
			          		<div class="col-md-3">
			          			<h5 style="font-weight:bold">Sequence logo</h5>
								<?php if(file_exists('files/Logos/'.$row['Primary_ID'].'_1.png')) { ?>
									<img src="files/Logos/<?=$row['Primary_ID']?>_1.png" class="img-thumbnail logo" data-element="<?=$row['Primary_ID']?>">
									<?php
										$i = 1;
										while(true) {
											$i = $i + 1;
											if(!file_exists("files/Logos/".$row['Primary_ID']."_".$i.".png")) break;
										}
									?>
									<span class="pager-bubble">
										<?php for($j=1; $j<$i; $j++) { ?>
											<i class="fa fa-lg fa-circle" data-count="<?=$j?>"></i>
										<?php } ?>
									</span>
								<?php } else { ?>
									<img src="files/Logos/<?=$row['Primary_ID']?>.png" class="img-thumbnail logo">
								<?php } ?>
				          	</div>
				          	<div class="col-md-3">
				          		<h5 style="font-weight:bold">Top Peptides Binders</h5>
				          		<span class="links top-peptides">
				          			<strong>Top ELISA-based peptide binders</strong>
				          			<span class="seq">
				          				<?php
				          				if(trim($row['HAL']) != '' && $row['HAL'] != 'NA') echo str_replace(",",", ",$row['HAL']);
				          				else echo '#N/A';
				          				?>
				          			</span>
				          			<strong>Most abundant NGS peptides</strong>
				          			<span class="seq">
				          				<?php
				          				if(trim($row['NGS']) != '' && $row['NGS'] != 'NA') echo str_replace(",",", ",$row['NGS']);
				          				else echo '#N/A';
				          				?>
				          			</span>
				          		</span>
				          	</div>
				          	<div class="col-md-3">
				          		<h5 style="font-weight:bold">Closest Complex Structure</h5>
				          		<a href="https://www.rcsb.org/pdb/explore/explore.do?structureId=<?=$row['PDB_ID']?>" target="_blank">
				          			<img src="https://cdn.rcsb.org/images/rutgers/<?=substr($row['PDB_ID'],1,2)?>/<?=$row['PDB_ID']?>/<?=$row['PDB_ID']?>.pdb1-500.jpg" class="img-thumbnail structure">
				          		</a>
				          	</div>
				          	<div class="col-md-3">
				          		<h5 style="font-weight:bold">Downloads</h5>
				          		<span class="links downloads">
				          			<a href="network.php?gene=<?=$row['Protein_Name']?>">PWM pattern matches</a>

				          			<?php if (file_exists('files/PWM/'.$row['Primary_ID'].'.dat')) { ?>
										<a href="files/PWM/<?=$row['Primary_ID']?>.dat" target="_blank">Position Weight Matrix</a>
									<?php } else if(file_exists('files/PWM/'.$row['Primary_ID'].'_1.dat')) { ?>
									<span>
				          				Position Weight Matrix
										<?php
											$i = 1;
											while(true) {
												echo "<a href='files/PWM/".$row['Primary_ID']."_".$i.".dat' target='_blank' style='padding: 0px 2px'>".$i."</a>";
												$i = $i + 1;
												if(!file_exists("files/PWM/".$row['Primary_ID']."_".$i.".dat")) break;
											}
										?>
									</span>
				          			<?php } ?>

									<?php if(file_exists('files/ELISA/'.$row['Primary_ID'].'.fa')) { ?>
				          				<a href="files/ELISA/<?=$row['Primary_ID']?>.fa" target="_blank">ELISA-based peptide binders</a>
									<?php } else if (file_exists('files/ELISA/'.$row['Primary_ID'].'_1.fa')) { ?>
									<span>
										ELISA-based peptide binders
										<?php
											$i = 1;
											while(true) {
												echo "<a href='files/ELISA/".$row['Primary_ID']."_".$i.".fa' target='_blank' style='padding: 0px 2px'>".$i."</a>";
												$i = $i + 1;
												if(!file_exists("files/ELISA/".$row['Primary_ID']."_".$i.".fa")) break;
											}
										?>
									</span>
									<?php } ?>

									<?php if(file_exists('files/NGS/'.$row['Primary_ID'].'.fa')) { ?>
				          				<a href="files/NGS/<?=$row['Primary_ID']?>.fa" target="_blank">NGS peptides</a>
									<?php } ?>

									<?php if(file_exists('files/PDB/'.$row['Primary_ID'].'.txt')) { ?>
				          				<a href="files/PDB/<?=$row['Primary_ID']?>.txt" target="_blank">Structural Similarities</a>
									<?php } ?>
				          		</span>
				          	</div>
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
						<?php $link = "results.php?q={$q}&species={$sp}&group={$gr}&page="; ?>
						<li><a href='<?=$link.'1'?>'>First</a></li>
						<?php if(($page) > 1) { ?>
							<li><a href='<?=$link.strval($page - 1)?>'>Previous</a></li>
						<?php } ?>
						<li>Page <?=$page?> of <?=$total_pages?></li>
						<?php if(($page) < $total_pages) { ?>
							<li><a href='<?=$link.strval($page + 1)?>'>Next</a></li>
						<?php } ?>
						<li><a href='<?=$link.$total_pages?>'>Last</a></li>
					</ul>
				</nav>
	        </div>
  		</div>
  		<?php } ?>
    </div>
    <script>
    $(window).on('load', function () {
    	$('.logo').each(function () {
        	if (!this.complete || typeof this.naturalWidth === "undefined" || this.naturalWidth === 0) {
            	$(this).attr("src", "http://via.placeholder.com/800x300/fff/000?text=NO+LOGO+AVAILABLE");
		$(this).next().hide();
        	}
     	});

	$('.structure').each(function () {
                if (!this.complete || typeof this.naturalWidth === "undefined" || this.naturalWidth === 0) {
                $(this).attr("src", "http://via.placeholder.com/800x300/fff/000?text=NO+STRUCTURE+AVAILABLE");
                $(this).parent().removeAttr("href"); 
		}
        });	

     	$('.top-peptides').each(function () {
        	if($.trim($(this).html()) == "") {
        		$(this).hide();
        	}
     	});
 	});

 	$(document).ready(function() {
	    $('.fa-circle').on('click', function(){
	    	$(this).parent().children().removeClass('fa-circle-thin').addClass('fa-circle');
	    	$(this).removeClass('fa-circle').addClass('fa-circle-thin');
	    	var count = $(this).data('count');
	    	var el = $(this).parent().prev().data('element');
	    	$(this).parent().prev().attr('src', 'files/Logos/' + el + '_' + count + '.png');
	    });
	});
    </script>
    <?php include_once('partials/footer.php'); ?>
	</body>
</html>
