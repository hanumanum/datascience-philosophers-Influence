<?php
	if(isset($_POST["source"]) && isset($_POST["target"])){
		$source = addslashes(trim($_POST["source"]));
		$target = addslashes(trim($_POST["target"]));
		if($source!="" && $target!=""){
			$sql = "INSERT INTO `influences` (`source`,`target`)
					VALUES ('$source','$target');";
			
			$conn = mysqli_connect("localhost","root","root","philos");
			mysqli_set_charset($conn,'utf8');
			$res = mysqli_query($conn,$sql);
			echo mysqli_error($conn);
			mysqli_close($conn);				

		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>
<body>


<div class="container">
	<h1>Edge editor</h1>
	<hr>
	<div class="row">
		<div class="col-md-6">
			<h2>Pairs</h2>
			<form method="POST">
			<input type="text" name="source" data-provide="typeahead" placeholder="Source" id="source">
			<input type="text" name="target" data-provide="typeahead" placeholder="Target" id="target">	
			<input type="submit" value="Save" class="btn btn-success">
			</form>
		</div>

		<div class="col-md-6">
			<h2>Influencies</h2>
			<table class="table table-bordered">
				<thead>
					<td>Source</td>
					<td>Target</td>
				</thead>
				<tbody id="tbbody">
					
				</tbody>
			</table>
		</div>
	</div>
</div>


<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="bootstrap3-typeahead.min.js"></script>


<script type="text/javascript">
	var pairss;
	var source, target;
	var sourceName="", targetName="";

	$(document).ready(function(){
		$.get('../database.php?info=names', function(data){
			source = $("#source").typeahead({ source:data });
			target = $('#target').typeahead({ source:data });
			
			source.change(function(event) {
				sourceName = $(this).val();
				$.get('../database.php?info=pairs&source='+sourceName, function(data){
					if(data.length>0){
						pairss = JSON.parse(data);
						makeTable();
					}
				});
				target.val("");
				
			});

		target.change(function(event) {
			targetName = $(this).val();
			makeTable();
		});	
				

		},'json');
	

		$("#btn").click(function(event) {
			if(!(targetName=="" || sourceName=="")){
				console.log(targetName,sourceName);
			}
		});

	});


	function makeTable(){
		$("#tbbody").empty();
		console.log(targetName);
		if(targetName==""){
			$(pairss).each(function(index, el) {
				$('#tbbody').append('<tr><td>'+el.source+'</td><td>'+el.target+'</td></tr>');
			});

		}
		else{
			$(pairss).each(function(index, el) {
				if(targetName==el.target){
					$('#tbbody')
						.append('<tr><td>'+el.source+'</td><td>'+el.target+'</td></tr>');
				}
			});
		}
	  targetName="";	
	 }
</script>

</body>
</html>






