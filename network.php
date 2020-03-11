<?php
include_once('common.php');
include_once('partials/header.php');
?>
<div class="container">
	<!-- <div class="row">
		<h3 class="text-center">Network Visualization canvas</h3>
		<div class="col-md-12">
			<div class="cytoscape" id="cytoscape"></div>
		</div>
	</div> -->
	<div class="row">
		<h3 class="text-center">Network Table</h3>
		<h5 class="text-center">
			<a href="download_network.php?gene=<?=$_GET['gene']?>">Download Network as CSV</a>
		</h5>
		<div class="col-md-12">
			<table class="table table-hover"></table>
		</div>
	</div>
	<div class="row">
		<h5>
			<a href="assets/PRM_PPI_supplementary.pdf">(*) The score is the sum of log-odds scores of amino acid Si at position j in the PWM</a>
		</h5>
	</div>
</div>

<script src="assets/js/cytoscape.min.js"></script>
<script src="assets/js/panzoom.js"></script>
<script src="assets/js/cola.js"></script>
<script src="assets/js/cytoscape-cola.js"></script>
<script src="assets/js/datatables.min.js"></script>

<br /><br />
<?php include_once('partials/footer.php'); ?>
<?php
	$q = $_GET['gene'];
	$query = "SELECT * FROM PPI WHERE `Domain_Protein` LIKE ?";
	$stmt = $dbh->prepare($query);
	$param = array("%$q%");
	$stmt->execute($param);
	$data = json_encode($stmt->fetchAll());
?>

<script>
$(function(){
	var data = <?=$data?>;
	var hero = "<?=strtoupper($q)?>";

	// var cy = cytoscape({
	// 	container: document.getElementById('cytoscape'),
	// 	elements: [],
	// 	style: [
	// 	    {
	// 	    	selector: 'node',
	// 	    	style: {
	// 	        	'background-color': '#5296dd',
	// 	        	'label': 'data(id)',
	// 	        	'width': 100,
	// 	        	'height': 100,
	// 	        	'font-size': 36,
	// 	        	'text-valign': 'center',
 	//              'color': 'white',
 	//              'text-outline-width': 5,
 	//              'padding-top': '10px',
 	//              'padding-left': '10px',
 	//              'padding-bottom': '10px',
 	//              'padding-right': '10px',
 	//              'text-align': 'center',
	// 	      	}
	// 	    },
	// 	    {
	// 	    	selector: 'edge',
	// 	    	style: {
	// 	        	'width': 8,
	// 	        	'line-color': '#FF9933'
	// 	    	}
	// 	    }
	//   	]
	// });
	
	// maxNodes = (data.length > 100) ? 100 : data.length;
	
	// for(var i = 0; i < maxNodes; i++)
	// {		
	// 	cy.add([
	// 	  { group: "nodes", data: { id: data[i][1] } },
	// 	  { group: "nodes", data: { id: data[i][2] } },
	// 	  { group: "edges", data: { id: data[i][2]+'@'+data[i][1], source: data[i][2], target: data[i][1] } }
	// 	]);
	// }
	// cy.center();
	// cy.panzoom({});	
	// cy.layout({ name: 'cola', avoidOverlap: true, equidistant: true, maxNodeSpacing: 50, randomize: true});
	// cy.style().selector('node[id = "'+hero+'"]').style({'background-color': 'red'}).update();

	$('.table').DataTable({
        data: data,
        columns: [
        	{ title: "Domain Protein" },
            { title: "Domain Protein ID" },
            { title: "Domain" },
            { title: "Peptite Protein" },
            { title: "Peptite Protein ID" },
            { title: "PWM" },
            { title: "Peptide Sequence" },
            { title: "Start" },
            { title: "End" },
            { title: "Score *" }
        ]
    });
});
</script>
    
	</body>
</html>
