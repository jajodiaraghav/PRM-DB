<?php include_once('partials/header.php'); ?>
    <div class="container">
    	<div class="row">
        <div class="col-md-8 col-md-offset-2">
          <form id="search_form" action="/results" method="get">
            <div class="input-group input-group-lg">
              <input type="search" name="q" class="form-control" placeholder="Enter Domain or Protein name or ID">
              <span class="input-group-btn">
                <button type="submit" class="btn btn-primary">Search</button>
              </span>
            </div>
          </form>
          <p>
            <h4>Load Examples: <a href="/results?q=STAM2">STAM2</a> <a href="/results?q=DOK6">DOK6</a></h4>
          </p>
        </div>
  	  </div>
    </div>
    <?php include_once('partials/footer.php'); ?>
	</body>
</html>