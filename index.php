<?php
include_once('common.php');
include_once('partials/header.php');
?>
    <div class="container">
    	<div class="row">
    		<div class="col-md-8 col-md-offset-2">
	          	<div class="well">
			        <?php
			          	$query = "SELECT COUNT(DISTINCT `Protein_Name`) AS A,
			                    COUNT(DISTINCT `Domain_Group`) AS B,
			                    COUNT(DISTINCT `Uniprot_ID`) AS C FROM proteins";
			          	$stmt = $dbh->prepare($query);
			          	$stmt->execute();
			          	$ar = $stmt->fetch();
			        ?>
	            	<h4 class="text-primary">
	            		<strong>
	            			PRM database contains <?=$ar['A']?> domains from <?=$ar['B']?> domain groups and <?=$ar['C']?> proteins.
	            		</strong>
	            	</h4>
	          	</div>
	        </div>
      	</div>
    	<div class="row search">
	        <div class="col-md-8 col-md-offset-2">
	          <form action="results.php" method="get" class="form-inline">
	            <input type="search" name="q" class="form-control" placeholder="Enter Domain or Protein name or ID">
	            <select class="form-control" name="species">
	              <option value="" selected disabled>Species</option>
	              <?php
	              $query = "SELECT DISTINCT Species FROM proteins";
	              $stmt = $dbh->prepare($query);
	              $stmt->execute();
	              while ($row = $stmt->fetch()) {
	                echo "<option value='{$row[0]}'>{$row[0]}</option>";
	              }
	              ?>
	            </select>
	            <select class="form-control" name="group">
	              <option value="" selected disabled>Domain Group</option>
	              <?php
	              $query = "SELECT DISTINCT Domain_Group FROM proteins";
	              $stmt = $dbh->prepare($query);
	              $stmt->execute();
	              while ($row = $stmt->fetch()) {
	                echo "<option value='{$row[0]}'>{$row[0]}</option>";
	              }
	              ?>
	            </select>
	            <button type="submit" class="btn btn-primary">Search</button>
	          </form>
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