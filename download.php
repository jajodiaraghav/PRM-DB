<?php include_once('partials/header.php'); ?>
    <div class="container">
    	<div class="row">
    		<h3 class="text-center">Download Database</h3>
    		<div class="col-md-10 col-md-offset-1">
	          	<p class="lead">All files in the PRM database can be downloaded <a href="download_files.php">HERE</a>, and contain:</p>
                <ul class="list-unstyled">
                    <li><strong>ELISA folder:</strong> phage-derived peptides with the ELISA signal values: ratio between protein/GST binding, and background signal (GST alone).</li>
                    <li><strong>NGS folder:</strong> All curated list of peptide sequences obtained from next-generation sequencing (NGS) of the round 4 and 5 pools</li>
                    <li><strong>PWM folder:</strong> Position weight matrix (PWM) obtained from the alignment of NGS sequences, if they exist, otherwise from the ELISA peptides</li>
                    <li><strong>LOGOS folder:</strong> Logo obtained from the PWM</li>
                    <li><strong>PWM_scan folder:</strong> List of interacting proteins obtained from running the PWM against the human proteome (Jain and Bader, 2016)</li>
                </p>

                <hr>

                <p class="lead" style="margin-bottom: 200px">The Master EXCEL file can be downloaded <a href="download_master.php">HERE</a>, and contains the PRM_ID with all information and characterization of the domain</p>
	        </div>
      	</div>
    </div>
    <?php include_once('partials/footer.php'); ?>
	</body>
</html>