<?php
include_once('common.php');
include_once('partials/header.php');
?>
<div class="container">
	<div class="row">	
		<h4 class="text-center">Network Visualization canvas</h4>
		<div class="col-md-12">
			<div class="cytoscape" id="cytoscape"></div>
		</div>
	</div>
</div>

<script src="/assets/js/cytoscape.min.js"></script>
<script src="/assets/js/panzoom.js"></script>
<script src="/assets/js/cola.js"></script>
<script src="/assets/js/cytoscape-cola.js"></script>

<?php include_once('partials/footer.php'); ?>
<?php
	$q = $_GET['gene'];
	$query = "SELECT * FROM PPI WHERE `Protein_A` LIKE ? OR `Protein_B` LIKE ?";
	$stmt = $dbh->prepare($query);
	$param = array("%$q%", "%$q%");
	$stmt->execute($param);
	$data = json_encode($stmt->fetchAll());
?>

<script>
$(function(){
	var data = <?=$data?>;
	var hero = "<?=strtoupper($q)?>";	
	var cy = cytoscape({
		container: document.getElementById('cytoscape'),
		elements: [],
		style: [
		    {
		    	selector: 'node',
		    	style: {
		        	'background-color': '#5296dd',
		        	'label': 'data(id)',
		        	'width': 100,
		        	'height': 100,
		        	'font-size': 36,
		        	'text-valign': 'center',
                    'color': 'white',
                    'text-outline-width': 5,
                    'padding-top': '10px',
                    'padding-left': '10px',
                    'padding-bottom': '10px',
                    'padding-right': '10px',
                    'text-align': 'center',
		      	}
		    },
		    {
		    	selector: 'edge',
		    	style: {
		        	'width': 8,
		        	'line-color': '#FF9933'
		    	}
		    }
	  	]
	});
	
	for(var i = 0; i < 20; i++)
	{		
		cy.add([
		  { group: "nodes", data: { id: data[i][1] } },
		  { group: "nodes", data: { id: data[i][2] } },
		  { group: "edges", data: { id: data[i][2]+'@'+data[i][1], source: data[i][2], target: data[i][1] } }
		]);
	}
	cy.center();
	cy.panzoom({});	
	cy.layout({ name: 'cola', avoidOverlap: true, equidistant: true, maxNodeSpacing: 50, randomize: true});
	cy.style().selector('node[id = "'+hero+'"]').style({'background-color': 'red'}).update();
});
</script>
    
	</body>
</html>