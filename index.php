<?php
include_once('common.php');
include_once('partials/header.php');
?>
    <div class="container">
    	<div class="row search">
        <div class="col-md-8 col-md-offset-2">
          <form action="results.php" method="get" class="form-inline">
            <input type="search" name="q" class="form-control" placeholder="Enter Domain or Protein name or ID">
            <select class="form-control" name="species" required>
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