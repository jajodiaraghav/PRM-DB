<?php
include_once('common.php');
include_once('partials/header.php');
?>
    <div class="container">
    	<div class="row">
    		<div class="col-md-8 col-md-offset-2">
	          	<div class="well">
			        <?php
			          	$query = "SELECT COUNT(`Protein_Name`) AS A,
			                    COUNT(DISTINCT `Domain_Group`) AS B,
			                    COUNT(DISTINCT `Uniprot_ID`) AS C FROM proteins";
			          	$stmt = $dbh->prepare($query);
			          	$stmt->execute();
						$ar = $stmt->fetch();
						
						
						$query = "SELECT DISTINCT `Domain_Group` FROM proteins";
			          	$stmt = $dbh->prepare($query);
						$stmt->execute();
						$all_families = [];
			          	while ($row = $stmt->fetch()) {
							$all_families = array_merge($all_families, explode('+', $row['Domain_Group']));
						}
						$all_families = array_unique($all_families);
			        ?>
	            	<h4 class="text-primary">
	            		<strong>
	            			PRM database contains <?=$ar['A']?> domains from <?=count($all_families)?> PRM families and <?=$ar['C']?> proteins.
	            		</strong>
	            	</h4>
	          	</div>
	        </div>
      	</div>
    	<div class="row search">
	        <div class="col-md-8 col-md-offset-2">
			<h4>Search for a domain or protein by name, all domains from a given species, all members of a domain family, or search for combinations of these criteria.</h4>	
	        	<?php include_once('partials/search.php'); ?>
	        	<p>
	            	<h4><strong>Load Examples:</strong></h4>
	            	<h4>Protein Name: <a class="example">GRAP2</a> | <a class="example">SPSB2</a></h4>
	            	<h4>Domain Group: <a class="example">SH3</a> | <a class="example">IRS</a></h4>
	            	<h4>Uniprot ID: <a class="example">O75791</a> | <a class="example">Q99619</a></h4>
	        	</p>
	        </div>
  	  	</div>
    </div>
    <?php include_once('partials/footer.php'); ?>
    <script>
      $(function() {
        $('.example').click(function() {
          $('input[type="search"]').val($(this).text());
        });
      });
    </script>
	</body>
</html>
